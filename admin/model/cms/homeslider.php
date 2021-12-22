<?php
class ModelCmsHomeslider extends Model {
	public function addHomeslider($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "homeslider SET title = '" . $this->db->escape($data['name']) . "',short_description= '" . $this->db->escape($data['short_description']) . "',description= '" . $this->db->escape($data['description']) . "',linkto='" . $this->db->escape($data['linkto']) . "',sort_order = '" . (int)$data['sort_order'] . "'"); 
		$hps_id = $this->db->getLastId(); 
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "homeslider SET image = '" . $this->db->escape($data['image']) . "' WHERE hs_id = '" . (int)$hps_id . "'");
		}  
		$this->cache->delete('Homeslider');
	} 
	public function editHomeslider($hps_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "homeslider SET title = '" . $this->db->escape($data['name']) . "',short_description= '" . $this->db->escape($data['short_description']) . "',description= '" . $this->db->escape($data['description']) . "',linkto='" . $this->db->escape($data['linkto']) . "',sort_order = '" . (int)$data['sort_order'] . "' WHERE hs_id = '" . (int)$hps_id . "'"); 
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "homeslider SET image = '" . $this->db->escape($data['image']) . "' WHERE hs_id = '" . (int)$hps_id . "'");
		}  
		$this->cache->delete('Homeslider');
	} 
	public function deleteHomeslider($hps_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "homeslider WHERE hs_id = '" . (int)$hps_id . "'");
		$this->cache->delete('Homeslider');
	}  
	public function getHomeslider($hps_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "homeslider WHERE hs_id = '" . (int)$hps_id . "'"); 
		return $query->row;
	} 
	public function getHomesliders($data = array()) { 
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "homeslider"; 
			$sort_data = array(
				'title',
				'sort_order'
			); 
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY title";	
			} 
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			} 
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				} 
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				} 
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			} 
			$query = $this->db->query($sql); 
			return $query->rows;
		} else { 
			$Homeslider_data = $this->cache->get('Homeslider'); 
			if (!$Homeslider_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "homeslider ORDER BY title"); 
				$Homeslider_data = $query->rows; 
				$this->cache->set('Homeslider', $Homeslider_data);
			} 
			return $Homeslider_data;
		}
	}  
	public function getTotalHomeslidersByImageId($image_id) {
      	//$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "Homeslider WHERE image_id = '" . (int)$image_id . "'");

		return  0  ; //$query->row['total'];
	} 
	public function getTotalHomesliders() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "homeslider"); 
		return $query->row['total'];
	}	
}
?>