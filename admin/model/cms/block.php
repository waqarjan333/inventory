<?php
class ModelCmsblock extends Model {
	public function addBlock($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blocks SET sort_order = '" . (int)$this->request->post['sort_order'] . "', status = '" . (int)$data['status'] . "', block_home='".$this->db->escape($data['homepage'])."',position='".(int)$data['position']."', block_name = '" . $this->db->escape($data['blockname']) . "'"); 
		$block_id = $this->db->getLastId();  
		foreach ($data['block_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blocks_description SET block_id = '" . (int)$block_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		} 
		if (isset($data['block_pages'])) {
			foreach ($data['block_pages'] as $pageid) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "block_pages SET block_id = '" . (int)$block_id . "', page_id = '" . (int)$pageid . "'");
			}
		} 
		$this->cache->delete('blocks');
	} 
	public function editBlock($block_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blocks SET sort_order = '" . (int)$data['sort_order'] . "',status = '" . (int)$this->request->post['status'] . "',block_home='".$this->db->escape($data['homepage'])."',position='".(int)$data['position']."', block_name = '" .$data['blockname'] . "' WHERE block_id = '" . (int)$block_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "blocks_description WHERE block_id = '" . (int)$block_id . "'"); 
		foreach ($data['block_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blocks_description SET block_id = '" . (int)$block_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}  
		$this->db->query("DELETE FROM " . DB_PREFIX . "block_pages WHERE block_id = '" . (int)$block_id . "'"); 
		if (isset($data['block_pages'])) {
			foreach ($data['block_pages'] as $pageid) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "block_pages SET block_id = '" . (int)$block_id . "', page_id = '" . (int)$pageid . "'");
			}
		}  
		$this->cache->delete('blocks');
	} 
	public function deleteBlock($block_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blocks WHERE block_id = '" . (int)$block_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "blocks_description WHERE block_id = '" . (int)$block_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "block_pages WHERE block_id = '" . (int)$block_id . "'");   
		$this->cache->delete('blocks');
	}	 
	public function getBlock($block_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blocks WHERE block_id = '" . (int)$block_id . "'"); 
		return $query->row;
	} 
	public function getBlockp($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blocks b LEFT JOIN " . DB_PREFIX . "blocks_description bd ON (b.block_id = bd.block_id) WHERE bd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
			$sort_data = array(
				'bd.title',
				'b.sort_order'
			); 
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY bd.title";	
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
			$blocks_data = $this->cache->get('blocks.' . $this->config->get('config_language_id')); 
			if (!$blocks_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blocks b LEFT JOIN " . DB_PREFIX . "blocks_description bd ON (b.block_id = bd.block_id) WHERE bd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bd.title"); 
				$blocks_data = $query->rows; 
				$this->cache->set('blocks.' . $this->config->get('config_language_id'), $cms_data);
			}	 
			return $blocks_data;			
		}
	} 
	public function getBlockDescriptions($block_id) {
		$block_description_data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blocks_description WHERE block_id = '" . (int)$block_id . "'"); 
		foreach ($query->rows as $result) {
			$block_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		} 
		return $block_description_data;
	}  
	public function getTotalBlock() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blocks"); 
		return $query->row['total'];
	}
	public function getBlockpages($block_id) { 
		$block_p_data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "block_pages WHERE block_id = '" . (int)$block_id . "'"); 
		foreach ($query->rows as $result) {
			$block_p_data[] = $result['page_id'];
		} 
		return $block_p_data;
	} 
	public function getAllpages() { 
		$query = $this->db->query("SELECT DISTINCT i.cms_id,id.title FROM " . DB_PREFIX . "cms as i, " . DB_PREFIX . "cms_description as id WHERE i.cms_id = id.cms_id AND i.status = '1'");
		return $query->rows;
	} 
}
?>