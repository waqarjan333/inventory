<?php
class ModelProjectsCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()"); 
		$c_id = $this->db->getLastId();  
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$c_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		} 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$industryry_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		$this->cache->delete('categories');
	} 
	public function editCategory($c_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE category_id = '" . (int)$c_id . "'");  
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$c_id . "'"); 
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$c_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}  
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'cateory_id=" . (int)$c_id. "'"); 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$c_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		} 
		$this->cache->delete('categories');
	}
	
	public function deleteCategory($c_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$c_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$c_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'industry_id=" . (int)$c_id . "'"); 
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$c_id . "'"); 
		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		} 
		$this->cache->delete('categories');
	}  
	public function getCategory($c_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$c_id . "') AS keyword FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$c_id . "'"); 
		return $query->row;
	} 
	public function getCategories($parent_id) {
		
			$c_data = array(); 
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC"); 
			foreach ($query->rows as $result) {
				$c_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				); 
				$c_data = array_merge($c_data, $this->getCategories($result['category_id']));
			}	 
			$this->cache->set('category.' . $this->config->get('config_language_id') . '.' . $parent_id, $c_data);
		 
		return $c_data;
	} 
	public function getPath($c_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$c_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC"); 
		$c_info = $query->row; 
		if ($c_info['parent_id']) {
			return $this->getPath($c_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $c_info['name'];
		} else {
			return $c_info['name'];
		}
	}
	
	public function getCategoryDescriptions($c_id) {
		$c_description_data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$c_id . "'"); 
		foreach ($query->rows as $result) {
			$c_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		} 
		return $c_description_data;
	}	 
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category"); 
		return $query->row['total'];
	}	 
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}
}
?>