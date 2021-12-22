<?php
class ModelLoginLogin extends Model { 
	public function addSiteUser($data) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO " . DB_PREFIX . "siteusers SET 
		fullname = '" . $this->db->escape($data['firstName']." ".$data['lastName']) . "',
		firstname = '" . $this->db->escape($data['firstName']). "',
		lastname = '" . $this->db->escape($data['lastName']) . "',
		username = '" . $this->db->escape($data['email']) . "', 
		email = '" . $this->db->escape($data['email']) . "', 
		telephone = '" . $this->db->escape($data['phoneNumber']) . "',
		mobileNumber = '" . $this->db->escape($data['mobileNumber']) . "',
		user_type = '" . (int)$data['service_type'] . "', 
		password = '" . $this->db->escape(md5($data['password'])) . "',
		howDidYouHear='" . $this->db->escape($data['howDidYouHear']) . "', 
		country_id ='".$data["country"]."' , 
		city='" . $this->db->escape($data['city']) . "',
		status = '1', 
		newsletter = '0', 
		ip='".$ip."', date_added = NOW()";
		if ($this->config->get('config_siteusers_approval')) {
			$sql.=", approved = '1'";
		}
		$this->db->query($sql);
		$su_id = $this->db->getLastId();
                
                if($data['service_type']==2){
                    $sql = "INSERT INTO " . DB_PREFIX . "bid_points SET user_id='". $su_id ."', points='".$this->config->get('config_intial_points')."' ";
                    $this->db->query($sql);
                }
                return $su_id; 
	}  
	public function getTotalUsersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE email = '" . $this->db->escape($email) . "'"); 
		return $query->row['total'];
	} 
	public function getCountries() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country Where status='1' ORDER BY name");  
		return $query->rows;
	}
        public function addProviderDetails($data){
            $sql = "INSERT INTO " . DB_PREFIX . "provider_details SET 
                su_id = '".$data['newuser_id']."',
                company = '".$data['company_name']."',
                company_detail = '".$data['company_description']."',
                company_size = '".$data['no_employes']."',
                category_id ='".$data['industry']."',    
                operating_hours ='".$data['operating_hours']."',    
                delivery_service = '".$data['deliever_serivce']."'   
                ";
           $this->db->query($sql);
        }
}
?>