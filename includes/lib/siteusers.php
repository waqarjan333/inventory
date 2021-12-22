<?php
final class Siteusers {
	private $su_id;
        private $su_type;
        private $update_pass;
        private $user_right;
	private $firstname;
	private $lastname;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $siteusers_parent_id;
	private $address_id; 
	private $partner_id;
	private $partnername;
	private $preferences;
        private $record_per_page;
        private $fullname;
  	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
                $this->seourls = $registry->get('seourl');
		$this->session = $registry->get('session');
                $this->lang = $registry->get('language');
                //Change this number to change per page record. 
                $this->record_per_page = 20;//$this->config->get('config_admin_limit');
                //$this->logout();
		if (isset($this->session->data['su_id'])) { 
                        if($this->session->data['parent_id']==0){
			$siteusers_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "siteusers WHERE su_id = '" . 
                                           (int)$this->session->data['su_id'] . "' AND status = '1'"); 
                        }
                        else{
                            $siteusers_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "subusers WHERE subu_id = '" . 
                                           (int)$this->session->data['su_id'] . "' AND status = '1'"); 
                        }
			if ($siteusers_query->num_rows) {
                                if($this->session->data['parent_id']==0){
                                    $this->su_id = $siteusers_query->row['su_id'];
                                    $this->fullname = $siteusers_query->row['fullname'];
                                    $this->email = $siteusers_query->row['email'];
                                    $this->telephone = $siteusers_query->row['telephone'];
                                    $this->siteusers_parent_id = 0;
                                }
                                else{
                                    $this->session->data['su_id'] = $siteusers_query->row['subu_id'];	  
                                    $this->su_id = $siteusers_query->row['subu_id'];
                                    $this->fullname = $siteusers_query->row['username'];
                                    $this->siteusers_parent_id = $siteusers_query->row['parent_id'];
                                }
				
			} else {
				$this->logout();
			}
  		} else if (isset($this->session->data['pid'])) { 
			$partner_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "partners WHERE partner_id = '" .  (int)$this->session->data['pid'] . "' 
											 AND status = '1'");
			if($partner_query->num_rows){  
				$this->partner_id = $partner_query->row['partner_id'];
				$this->partnername = $partner_query->row['p_name']; 
			} else {
				$this->plogout();
			}  
		}
	} 
  	public function login($email, $password) { 
		if (!$this->config->get('config_siteusers_approval')) {
			$siteusers_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "siteusers 
                                WHERE username = '" . $this->db->escape($email) . "'
                                AND password = '" . $this->db->escape(md5($password)) . "'
                                AND status = '1' and logged_in=0");
		} 
                else {
                        $siteusers_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "siteusers
                                WHERE username = '" . $this->db->escape($email) . "'
                                AND password = '" . $this->db->escape(md5($password)) . "' 
                                AND status = '1' AND approved = '1' "); //and logged_in=0 
                        
                     }  
		if ($siteusers_query->num_rows) {		
			$this->session->data['su_id'] = $siteusers_query->row['su_id'];	 
                        $this->session->data['su_type'] = $siteusers_query->row['user_type'];
                        $this->session->data['update_pass'] = $siteusers_query->row['update_pass'];
                        $this->session->data['user_right'] = $siteusers_query->row['user_right'];
			$this->session->data['parent_id'] = 0;	 			                        
			$this->su_id = $siteusers_query->row['su_id'];
                        $this->su_type = $siteusers_query->row['user_type'];
                        $this->update_pass = $siteusers_query->row['update_pass'];
                        $this->user_right = $siteusers_query->row['user_right'];
			$this->firstname = $siteusers_query->row['firstname'];
			$this->lastname = $siteusers_query->row['lastname'];
			$this->email = $siteusers_query->row['email'];
			$this->telephone = $siteusers_query->row['telephone'];
			$this->siteusers_group_id = $siteusers_query->row['user_type'];
                        $this->db->query("UPDATE  " . DB_PREFIX . "siteusers SET logged_in = '1',pos_open=0 WHERE su_id = '" . $siteusers_query->row['su_id'] . "'"); 
			return TRUE; 
		} else {
			
                    return FALSE;
                } 
  	} 
        	
  	public function logout() {
                $this->db->query("UPDATE  " . DB_PREFIX . "siteusers SET logged_in = '0' WHERE su_id = '" . $this->session->data['su_id'] . "'"); 
		unset($this->session->data['su_id']); 
                unset($this->session->data['parent_id']); 
                unset($this->session->data['su_type']); 
                unset($this->session->data['update_pass']);
                unset($this->session->data['user_right']);
                
		$this->su_id = '';
		$this->firstname = '';
                $this->su_type ='';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->siteusers_parent_id = '';
                $this->update_pass = '';
                $this->user_right = '';
		
  	}
	public function plogout() { 
                $this->db->query("UPDATE  " . DB_PREFIX . "siteusers SET logged_in = '0' WHERE su_id = '" . $this->session->data['su_id'] . "'"); 
		unset($this->session->data['partner_id']);
	 	unset($this->session->data['firstname']); 
		unset($this->session->data['su_id']); 
                
		$this->partner_id='';
		$this->partnername='';
		$this->su_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->siteusers_parent_id = '';
		$this->address_id = '';
		$this->preferences='';
  	}
        
        public function isPosOpen(){
            $is_pos_open = false;
            $siteusers_query = $this->db->query("SELECT pos_open FROM " . DB_PREFIX . "siteusers WHERE su_id=".$this->session->data['su_id']);
            if ($siteusers_query->row['pos_open']) {
                $is_pos_open = true;
            }            
            return $is_pos_open;
        }
          
  	public function isLogged() {
            return $this->su_id;
  	}
        public function userRight() {
            return $this->user_right;
  	}
       
	public function isAdmin(){
            if($this->siteusers_parent_id==0){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        
	public function getPId() {
            return $this->partner_id;
  	}
	public function getPName() {
		return $this->partnername;
  	}

  	public function getId() {
            return $this->su_id;
  	}
        
        public function getType() {
            return $this->su_type;
  	}
        
      
  	public function getFullName() {
		return $this->fullname;
  	}
  
  	public function getLastName() {
		return $this->lastname;
  	}
  
  	public function getEmail() {
		return $this->email;
  	}
  
  	public function getTelephone() {
		return $this->telephone;
  	}
  
  	public function getFax() {
		return $this->fax;
  	}
	
  	public function getNewsletter() {
		return $this->newsletter;	
  	}
	public function getPreferences() { 
			return $this->preferences;	 
  	} 
  	public function getUserParentId() {
		return $this->siteusers_parent_id;	
  	}
	
  	public function getAddressId() {
		return $this->address_id;	
  	}
        //Get usertype of logged in user.
        public function getUserType(){
                if(isset($this->session->data['user_type'])){
                    return $this->session->data['user_type'];
                }
                else{
                    return 0;
                }
        }
        
        
        //Get top menu according to logged in user
        public function getTopMenus(){
            echo $this->getUserType();
        }
        
        
        //Pagination common function
        public function pagination($page=1,$total=0){
          $pagination = new Pagination();
          $pagination->total = $total;
          $pagination->page = $page;
          $pagination->limit = $this->record_per_page;  
          $pagination->text =  $this->lang->get('text_pagination');
          $pagination->url = HTTPS_SERVER . 'index.php?route='.$this->request->get['route'].'&page={page}';  ; 
          return $pagination->render(); 
      }
      public function getPagination(){
          $page = 1;
          if (isset($this->request->get['page'])) {
                    $page = $this->request->get['page'];
            } else {
                    $page = 1;
            } 
            $data = array(
                    'page' => $page,
                    'start' => ($page - 1) * $this->record_per_page,
                    'limit' => $this->record_per_page
            ); 
            return $data;
      }
      public function sendSmsMessage($in_phoneNumber, $in_msg)
         {
           $url = '/sendSMS.php?to='.$in_phoneNumber
                  .'&text=' . urlencode($in_msg);

        $complete_url = "http://"
                           . CONFIG_KANNEL_HOST. $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$complete_url);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result= curl_exec ($ch);
        curl_close ($ch);
        return $result;

        }
}
?>