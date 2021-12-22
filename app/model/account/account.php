<?php
class ModelAccountAccount extends Model {
	public function addAccount($data) { 
            $result=str_replace("&amp;", '&', $data["acc_name"]); 
            $name=str_replace("&quot;", '"', $result);
		$this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET acc_name= '" . $name . "', acc_description  = '" . $data['acc_description'] . "',acc_type_id='". (int)$data['acc_type'] ."', last_changed ='".$data['last_changed']."', inTrail='".$data['acc_trail']."', acc_cat_id='".$data['acc_group']."' "); 
		$acc_id = $this->db->getLastId();  
             
                $this->cache->delete('accounts');
	}
	
	public function updateAccount($data) {
            $result=str_replace("&amp;", '&', $data["acc_name"]); 
            $name=str_replace("&quot;", '"', $result);
		$this->db->query("UPDATE " . DB_PREFIX . "account_chart SET acc_name= '" . $name . "', acc_description  = '" . $data['acc_description'] . "',acc_type_id='". (int)$data['acc_type'] ."', last_changed ='".$data['last_changed']."', inTrail='".$data['acc_trail']."', acc_cat_id='".$data['acc_group']."' WHERE acc_id = '" . (int)$data['acc_id'] . "'"); 
		
		$this->cache->delete('accounts');
	} 
	public function deleteAccount($acc_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "account_chart WHERE acc_id = '" . (int)$acc_id . "'");
				
		$this->cache->delete('news');
	}	 
	public function getAccount($news_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "') AS keyword FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'"); 
		return $query->row;
	}
		
	public function getAccountList() {
            $sql = "SELECT * FROM " . DB_PREFIX . "account_chart ac 
                LEFT JOIN " . DB_PREFIX . "account_type at ON (ac.acc_type_id = at.acc_type_id) 
                LEFT JOIN " . DB_PREFIX . "account_heads ah ON (ah.acc_head_id = at.head_id) 
                LEFT JOIN " . DB_PREFIX . "account_category act ON (act.category_id = ac.acc_cat_id) 
                WHERE ac.acc_type=0;"; 
            $query = $this->db->query($sql);
            return $query->rows;
	}
	
	public function getAccountTypes() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_type"); 
            return $query->rows;
	}

	public function getTotalNews() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news"); 
		return $query->row['total'];
	}
        
        public function getGroups (){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_category"); 
            return $query->rows;
        }
	public function addGroup ($data){
            $query = $this->db->query("INSERT INTO " . DB_PREFIX . "account_category set category_name='". $data['name'] ."',isActive='".$data['status']."' "); 
            return $query;
        }
        public function updateGroup ($data){
            $query = $this->db->query("UPDATE " . DB_PREFIX . "account_category set category_name='". $data['name'] ."',isActive='".$data['status']."' WHERE category_id='". $data['id'] ."'"); 
            return $query;
        }
        public function deleteGroup ($data){
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "account_category WHERE category_id='". $data['id'] ."' "); 
            return $query;
        }
}

?>