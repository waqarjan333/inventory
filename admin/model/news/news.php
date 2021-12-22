<?php
class ModelNewsnews extends Model {
	public function addNews($data) { 
		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET sort_order = '" . (int)$this->request->post['sort_order'] . "', status = '" . (int)$data['status'] . "',newstype_id='". (int)$this->request->post['news_industry_id'] ."', added_date=NOW(), modified_date = NOW()"); 
		$news_id = $this->db->getLastId();  
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		/*if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}*/
		$this->cache->delete('news');
	}
	
	public function editNews($news_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "',sort_order='".(int)$data['sort_order'] ."',newstype_id='". (int)$data['news_industry_id'] ."' WHERE news_id = '" . (int)$news_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'"); 
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		} 
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'"); 
		/*if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}*/
		$this->cache->delete('news');
	} 
	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "'"); 
				
		$this->cache->delete('news');
	}	 
	public function getNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "') AS keyword FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'"); 
		return $query->row;
	}
		
	public function getNewsp($data = array()) {
		if ($data) {
                                
			$sql = "SELECT *, c.status as news_status FROM " . DB_PREFIX . "news c LEFT JOIN " . DB_PREFIX . "news_description cd ON (c.news_id = cd.news_id) LEFT JOIN " . DB_PREFIX . "news_type ct ON (c.newstype_id = ct.newstype_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
                        
			$sort_data = array(
				'cd.title',
				'c.sort_order'
			); 
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY cd.title";	
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
			$news_data = $this->cache->get('news.' . $this->config->get('config_language_id')); 
                        
			if (!$news_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news c LEFT JOIN " . DB_PREFIX . "news_description cd ON (c.news_id = cd.news_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.added_date"); 
                        
				$news_data = $query->rows; 
				$this->cache->set('news.' . $this->config->get('config_language_id'), $news_data);
			}	 
			return $news_data;			
		}
	}
	
	public function getNewsDescriptions($news_id) {
		$news_description_data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'"); 
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		} 
		return $news_description_data;
	}

	public function getTotalNews() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news"); 
		return $query->row['total'];
	}
	
}

?>