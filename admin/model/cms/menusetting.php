<?php
class ModelCmsMenusetting extends Model {
	public function addMenu($data) {
		
		if($data['parent_id'] == ''){
			$data['parent_id'] = 'NULL';
		}
	   $this->db->query("INSERT INTO " . DB_PREFIX . "cmsmenu SET tm_title = '" . $data['tm_title'] . "',tm_url = '" . $data['tm_url'] . "',tm_dir = '" . $data['tm_dir'] . "',menu_for = '" . $data['tm_for'] . "', status = '" . (int)$data['status'] . "',sort_order = '" . (int)$data['sort_order'] . "', parent_id = ".$data['parent_id']);       
	   $cmsmenu_id = $this->db->getLastId(); 
	   $this->cache->delete('cmsmenu');
	} 
	public function editMenu($cmsmenu_id, $data) {
		
		if($data['parent_id'] == ''){
			$data['parent_id'] = 'NULL';
		}
		$this->db->query("UPDATE " . DB_PREFIX . "cmsmenu SET 
			tm_title = '" . $data['tm_title'] . "',
			tm_url = '" . $data['tm_url'] . "',
			tm_dir = '" . $data['tm_dir'] . "', 
                        menu_for = '" . $data['tm_for'] . "', 
			status = '" . (int)$data['status'] . "',
			sort_order = '" . (int)$data['sort_order'] . "',
			parent_id = ".$data['parent_id']." 
			WHERE tm_id = '" . (int)$cmsmenu_id . "'"); 
		$this->cache->delete('cmsmenu');
	} 
	public function deleteMenu($cmsmenu_id) {
		//FIX me to check first that this type have no pages 
		$this->db->query("DELETE FROM " . DB_PREFIX . "cmsmenu WHERE tm_id = '" . (int)$cmsmenu_id . "'"); 
		$this->cache->delete('cmsmenu');
	}	 
	public function getMenu($cmsmenu_id) {
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cmsmenu WHERE tm_id = '" . (int)$cmsmenu_id . "'"); 
		return $query->row;
	}
	public function getMenusall() {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cmsmenu"); 
		return $query->rows;
	}
	public function getActiveMenu() {
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cmsmenu where status = 1 order by parent_id, sort_order"); 
		return $query->rows;
	}
	public function getChildMenus($id = null){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cmsmenu where parent_id =".$id); 
		return $query->rows;
	}
		
	public function getMenus($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "cmsmenu"; 
			$sort_data = array(
				'tm_title' 
			); 
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY parent_id, " . $data['sort'];	
			} else {
				$sql .= " ORDER BY parent_id, sort_order";	
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
			$cmsmenu_data = $this->cache->get('cmsmenu'); 
			if (!$cmsmenu_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cmsmenu ORDER BY tm_title"); 
				$cmsmenu_data = $query->rows; 
				$this->cache->set('cmsmenu', $cmsmenu_data);
			}	 
			return $cmsmenu_data;			
		}
	}
	public function getTotalMenus() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cmsmenu"); 
		return $query->row['total'];
	}
		
}
?>