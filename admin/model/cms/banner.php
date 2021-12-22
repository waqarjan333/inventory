<?php
class ModelCmsBanner extends Model {
	public function addSponsor($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "banners SET 
			banner_description = '" . $data['name'] . "',
			banner_image = '" . $data['sponsor_image'] . "', 
			banner_url = '" . $data['sponsor_url'] . "', 
			banner_position = '".$data['banner_position']."',  
			banner_status= '" . $data['banner_status'] . "',
			internal_url='".$data['internal_url']."',
			banner_type='".$data['banner_type']."',
			banner_document = '".$data['banner_document']."',
			created = NOW()"); 
		$this->cache->delete('banner');
	}
	
	public function editSponsor($banner_id, $data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "banners SET 
			banner_description = '" . $data['name'] . "',
			banner_image = '" . $data['sponsor_image'] . "', 
			banner_url = '" . $data['sponsor_url'] . "', 
			banner_status= '" . $data['banner_status'] . "', 
			banner_position = '".$data['banner_position']."', 
			internal_url='".$data['internal_url']."',
			banner_type='".$data['banner_type']."',
			banner_document = '".$data['banner_document']."
			WHERE banner_id = '" . (int)$banner_id . "'"); 
		$this->cache->delete('banner');
	} 
	public function deleteSponsor($banner_id) {
		//die("delete");
		$this->db->query("DELETE FROM " . DB_PREFIX . "banners WHERE banner_id = '" . (int)$banner_id . "'");
		$this->cache->delete('banner');
	}	 
	public function getSponsor($banner_id) {
		$query = $this->db->query("SELECT * from ". DB_PREFIX . "banners WHERE banner_id = ".$banner_id); 
		return $query->row;
	}
	public function getAllSponsor() {
		
		$query = $this->db->query("SELECT * from ". DB_PREFIX . "banners WHERE banner_status = 1"); 
		return $query->rows;
	}
	public function getTotalSponsor() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "banners"); 
		return $query->row['total'];
	}	
}
?>
