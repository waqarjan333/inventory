<?php
class ModelCmstestimonial extends Model {
	public function addtestimonial($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial SET title = '" . $this->db->escape($data['title']) . "',description= '" . $this->db->escape($data['description']) . "',sort_order = '" . (int)$data['sort_order'] . "'");
		$this->cache->delete('testimonial');
	} 
	public function edittestimonial($t_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET title = '" . $this->db->escape($data['name']) . "',description= '" . $this->db->escape($data['description']) . "',linkto='" . $this->db->escape($data['linkto']) . "',sort_order = '" . (int)$data['sort_order'] . "' WHERE hps_id = '" . (int)$hps_id . "'"); 
		$this->cache->delete('testimonial');
	} 
	public function deletetestimonial($t_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial WHERE t_id = '" . (int)$t_id . "'");
		$this->cache->delete('Homeslider');
	}  
	public function gettestimonial($t_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "testimonial WHERE t_id = '" . (int)$t_id . "'"); 
		return $query->row;
	} 
	public function gettestimonials($data = array()) { 
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "testimonial"; 
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
			$testimonial_data = $this->cache->get('testimonial'); 
			if (!$testimonial_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial ORDER BY title"); 
				$testimonial_data = $query->rows; 
				$this->cache->set('testimonial', $Homeslider_data);
			} 
			return $testimonial_data;
		}
	}  
	public function getTotalTestimonialByImageId($image_id) {
      	//$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "Homeslider WHERE image_id = '" . (int)$image_id . "'");

		return  0  ; //$query->row['total'];
	} 
	public function getTotalTestimonials() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "testimonial"); 
		return $query->row['total'];
	}	
}
?>