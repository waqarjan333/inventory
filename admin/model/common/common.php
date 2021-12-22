<?php
class ModelCommonCommon extends Model {

	public function getTotalSiteUsers($utype='1') {
      	//$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cms"); 
		//return $query->row['total'];
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE status = '1' AND user_type='".$utype."'"); 
		return $query->row['total']; 
	}	
	public function getTotalSiteUsersAwaitingApproval($utypes=1) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE (status = '0' OR approved = '0') AND user_type='".$utypes."'"); 
		return $query->row['total']; 
	}	
	public function getTotalideas(){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "projects WHERE status = '1' AND approved = '1'"); 
		return $query->row['total']; 
	}
	public function  getTotalideasAwaitingApproval(){ 
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "projects WHERE status = '0' OR approved = '0'"); 
		return $query->row['total'];
	} 
        
        public function getIndustries(){ 
            
		$industries=array();
                $query =$this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
                WHERE c.parent_id = '0' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                ORDER BY c.sort_order, cd.name ASC");
                foreach ($query->rows as $result) {
                    $industries[] = array(
                            "category_id" 	=>$result['category_id'],
                            "title" 		=>$result['name'],
                            "sort_order" 	=> $result['sort_order'] 
                    );
		}		
		return $industries; 
	}
}
?>