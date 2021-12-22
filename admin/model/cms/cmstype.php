<?php
class ModelCmsCmstype extends Model {
	public function addCmstype($data) {
	   $this->db->query("INSERT INTO " . DB_PREFIX . "cms_type SET c_name = '" . $this->request->post['c_name'] . "', status = '" . (int)$data['status'] . "'");       $cmstype_id = $this->db->getLastId(); 
	   $this->cache->delete('cmstype');
	} 
	public function editCmstype($cmstype_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "cms_type SET c_name = '" . $data['c_name'] . "', status = '" . (int)$data['status'] . "' WHERE cmstype_id = '" . (int)$cmstype_id . "'"); 
		$this->cache->delete('cmstype');
	} 
	public function deleteCmstype($cmstype_id) {
		//FIX me to check first that this type have no pages 
		$this->db->query("DELETE FROM " . DB_PREFIX . "cms_type WHERE cmstype_id = '" . (int)$cmstype_id . "'"); 
		$this->cache->delete('cmstype');
	}	 
	public function getCmstype($cmstype_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cms_type WHERE cmstype_id = '" . (int)$cmstype_id . "'"); 
		return $query->row;
	}
	public function getCmstypeall() {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cms_type"); 
		return $query->rows;
	}
		
	public function getCmstypes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "cms_type c"; 
			$sort_data = array(
				'c_name' 
			); 
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY c_name";	
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
			$cmstype_data = $this->cache->get('cmstype'); 
			if (!$cmstype_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cms_type ORDER BY c_name"); 
				$cmstype_data = $query->rows; 
				$this->cache->set('cmstype', $cmstype_data);
			}	 
			return $cmstype_data;			
		}
	}
	public function getTotalCmstypes() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cms_type"); 
		return $query->row['total'];
	}	
}
?>