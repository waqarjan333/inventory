<?php
class ModelProjectsProjects extends Model {  
	public function deleteProjects($p_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "projects WHERE project_id = '" . (int)$p_id . "'"); 
		$this->db->query("DELETE FROM " . DB_PREFIX . "projects_description WHERE project_id = '" . (int)$p_id . "'");
		$sql = sprintf("SELECT filename from " . DB_PREFIX . "projects_files where project_id = %d", (int)$p_id);
		$query = $this->db->query($sql); 
		foreach($query->rows as $row) {
			if (isset($row['filename']) and $row['filename'])
				@unlink('../'.$row['filename']);
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "projects_files WHERE project_id = '" . (int)$p_id . "'");		
	} 
	public function getProject($pid) {
		$arrayidea=array();
		$query = $this->db->query("SELECT DISTINCT p.*, pd.* from " . DB_PREFIX . "projects as p, " . DB_PREFIX . "projects_description as pd WHERE p.project_id=pd.project_id AND p.project_id = '" . (int) $pid . "'");
		$arrayidea['projectdetails']=$query->row;
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "siteusers WHERE 	su_id = '" . (int)$query->row['user_id'] . "'");
		$arrayidea['projectuser']=$query->row;
		//$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "iuser_from WHERE idea_user_id = '" . (int)$query->row['idea_user_id'] . "'");
		//$arrayidea['iuser_from']=$query->row; 
		return $arrayidea;
	} 
		
	public function getProjects($data = array()) {
		//$sql = "SELECT p.*, pd.project_name,u.fullname,cat.name as cat_name from " . DB_PREFIX . "projects as p, " . DB_PREFIX . "projects_description as pd," . DB_PREFIX . "siteusers as u," . DB_PREFIX . "category_description as cat"; 
		$sql = sprintf("SELECT p.*, pd.language_id, pd.project_name, pd.decription as description, pf.filename, cat.name as category_name, u.fullname from ".DB_PREFIX."projects as p
		inner join ".DB_PREFIX."projects_description as pd on p.project_id = pd.project_id
		left join ".DB_PREFIX."projects_files as pf on p.project_id = pf.project_id
		inner join ".DB_PREFIX."category_description as cat on p.category_id = cat.category_id
		inner join ".DB_PREFIX."siteusers as u on p.user_id = u.su_id");
		$implode = array(); 
		$implode[] = "p.project_id=pd.project_id";
		$implode[] = "p.user_id=u.su_id";
		$implode[] = "p.category_id=cat.category_id";
		if (isset($data['filter_id']) && !is_null($data['filter_id'])) {
			$implode[] = " p.project_id='" . (int)$data['filter_id']. "'";
		}  
		if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
			$implode[] = " LOWER(pd.project_name) LIKE '%" . $this->db->escape($data['filter_title']) . "%'";
		} 
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "p.status = '" . (int)$data['filter_status'] . "'";
		} 
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "p.approved = '" . (int)$data['filter_approved'] . "'";
		}	 
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(p.added_date) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		} 
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		} 
		$sort_data = array(
			'pd.project_name', 
			'p.status',
			'p.added_date'
		);	 
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY p.added_date";	
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
	} 
	public function approve($p_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "projects SET approved = '1' WHERE project_id = '" . (int)$p_id . "'");
	}  
	public function getTotalprojects($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "projects as p, " . DB_PREFIX . "projects_description as pd ";
		$implode = array(); 
		$implode[] = "p.project_id=pd.project_id"; 
		if (isset($data['filter_id']) && !is_null($data['filter_id'])) {
			$implode[] = " p.project_id='" . (int)$data['filter_id'] . "'";
		}  
		if (isset($data['filter_title']) && !is_null($data['filter_title'])) {
			$implode[] = "LOWER(pd.project_name) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		} 
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "p.status = '" . (int)$data['filter_status'] . "'";
		} 
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "p.approved = '" . (int)$data['filter_approved'] . "'";
		}	 
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(p.added_date) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}  
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		} 
		$query = $this->db->query($sql); 
		return $query->row['total'];
	}
	
	public function getTotalIdeasAwaitingApproval() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "projects WHERE status = '0' OR approved = '0'"); 
		return $query->row['total'];
	}  
}
?>