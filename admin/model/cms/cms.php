<?php
class ModelCmscms extends Model {
	public function addCms($data) { 
		$this->db->query("INSERT INTO " . DB_PREFIX . "cms SET sort_order = '" . (int)$this->request->post['sort_order'] . "', status = '" . (int)$data['status'] . "', added_date=NOW(), modified_date = NOW()"); 
		$cms_id = $this->db->getLastId();  
		foreach ($data['cms_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "cms_description SET cms_id = '" . (int)$cms_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'cms_id=" . (int)$cms_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		//menu adding
		if(isset($data['tm_title']) && isset($data['tm_dir'])){
			if($data['tm_title']!=""){
			  $cmsurl="index.php?route=cms/cms&cms_id=".$cms_id;
			  $this->db->query("INSERT INTO " . DB_PREFIX . "cmsmenu SET tm_title = '" . $data['tm_title'] . "',tm_url = '" . $cmsurl. "',tm_dir = '" . $data['tm_dir'] . "', status = '1',sort_order = '" . (int)$data['msort_order'] . "'");       
			  $cmsmenu_id = $this->db->getLastId();
			  $this->db->query("UPDATE " . DB_PREFIX . "cms SET menu_id = '" . $cmsmenu_id . "' WHERE cms_id = '" . (int)$cms_id. "'");
			}
		} 
		$this->cache->delete('cms');
	}
	
	public function editCms($cms_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "cms SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE cms_id = '" . (int)$cms_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "cms_description WHERE cms_id = '" . (int)$cms_id . "'"); 
		foreach ($data['cms_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "cms_description SET cms_id = '" . (int)$cms_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		} 
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'cms_id=" . (int)$cms_id. "'"); 
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'cms_id=" . (int)$cms_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		//menu updating 
		if(isset($data['tm_title']) && isset($data['tm_dir'])){
			if($data['tm_title']!=""){
			  $cmsurl="index.php?route=cms/cms&cms_id=".$cms_id;
			  $cmsmenu_id=$this->getCmsMenu($cms_id);
			  if(isset($cmsmenu_id)){
				  $this->db->query("DELETE FROM " . DB_PREFIX . "cmsmenu WHERE tm_id = '" . (int)$cmsmenu_id . "'"); 
				  $this->db->query("INSERT INTO " . DB_PREFIX . "cmsmenu SET tm_title = '" . $data['tm_title'] . "',tm_url = '" . $cmsurl. "',tm_dir = '" . $data['tm_dir'] . "', status = '1',sort_order = '" . (int)$data['msort_order'] . "'");       
				  $cmsmenu_id = $this->db->getLastId();
				  $this->db->query("UPDATE " . DB_PREFIX . "cms SET menu_id = '" . $cmsmenu_id . "' WHERE cms_id = '" . (int)$cms_id. "'");
			  }
			}
		} 
		
		$this->cache->delete('cms');
	} 
	public function deleteCms($cms_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cms WHERE cms_id = '" . (int)$cms_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "cms_description WHERE cms_id = '" . (int)$cms_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'cms_id=" . (int)$cms_id . "'"); 
		$cmsmenu_id=$this->getCmsMenu($cms_id);
		if(isset($cmsmenu_id)){
			  $this->db->query("DELETE FROM " . DB_PREFIX . "cmsmenu WHERE tm_id = '" . (int)$cmsmenu_id . "'"); 
		}
		$this->cache->delete('cms');
	}	 
	public function getCms($cms_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'cms_id=" . (int)$cms_id . "') AS keyword FROM " . DB_PREFIX . "cms WHERE cms_id = '" . (int)$cms_id . "'"); 
		return $query->row;
	}
	public function getCmsMenu($cms_id) {
		$query = $this->db->query("SELECT menu_id FROM " . DB_PREFIX . "cms WHERE cms_id = '" . (int)$cms_id . "'"); 
		return $query->row['menu_id'];
	}
		
	public function getCmsp($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "cms c LEFT JOIN " . DB_PREFIX . "cms_description cd ON (c.cms_id = cd.cms_id) LEFT JOIN " . DB_PREFIX . "cms_type ct ON (c.cmstype_id = ct.cmstype_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
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
			$cms_data = $this->cache->get('cms.' . $this->config->get('config_language_id')); 
			if (!$cms_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cms c LEFT JOIN " . DB_PREFIX . "cms_description cd ON (c.cms_id = cd.cms_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cd.title"); 
				$cms_data = $query->rows; 
				$this->cache->set('cms.' . $this->config->get('config_language_id'), $cms_data);
			}	 
			return $cms_data;			
		}
	}
	
	public function getCmsDescriptions($cms_id) {
		$cms_description_data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cms_description WHERE cms_id = '" . (int)$cms_id . "'"); 
		foreach ($query->rows as $result) {
			$cms_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		} 
		return $cms_description_data;
	}
	public function getMenu($cmsmenu_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "cmsmenu WHERE tm_id = '" . (int)$cmsmenu_id . "'"); 
		return $query->row;
	} 
	public function getTotalCms() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cms"); 
		return $query->row['total'];
	}
	
	public function getDocuments($cid){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."cms_files where cms_id = ".$cid);
		return $query->rows;
	}
	public function getBlocks(){
		$sql = "SELECT * FROM " . DB_PREFIX . "blocks b LEFT JOIN " . DB_PREFIX . "blocks_description bd ON (b.block_id = bd.block_id) WHERE bd.language_id = '" . (int)$this->config->get('config_language_id') . "' and b.status='1'"; 
		$query=$this->db->query($sql);
		return $query->rows;
	}
}

?>