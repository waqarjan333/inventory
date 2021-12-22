<?php
class ModelUserSiteusers extends Model {
	public function addSiteusers($data) {
      	$sql="INSERT INTO " . DB_PREFIX . "siteusers SET 
		fullname = '" . $this->db->escape($data['fullname']) . "',
		firstname = '" . $this->db->escape($data['firstname']) . "',
		lastname = '" . $this->db->escape($data['lastname']) . "',
		username = '" . $this->db->escape($data['email']) . "', 
		email = '" . $this->db->escape($data['email']) . "',
		mobileNumber = '" . $this->db->escape($data['mobileNumber']) . "', 
		telephone = '" . $this->db->escape($data['telephone']) . "', 
		newsletter = '" . (int)$data['newsletter'] . "', 
		country_id = '" . (int)$data['country_id'] . "', 
		city= '" .  $this->db->escape($data['city']) . "', 
		howDidYouHear='Admin added',
		user_type = '" . (int)$data['user_type'] . "', 
		password = '" . $this->db->escape(md5($data['password'])) . "', 
		status = '" . (int)$data['status'] . "', date_added = NOW()";
		$this->db->query($sql);
	} 
	public function editSiteusers($su_id, $data) {
		$sql="UPDATE " . DB_PREFIX . "siteusers SET 
			fullname = '" . $this->db->escape($data['firstname']." ".$data['lastname']) . "',
			firstname = '" . $this->db->escape($data['firstname']) . "',
			lastname = '" . $this->db->escape($data['lastname']) . "',
			username = '" . $this->db->escape($data['email']) . "', 
			email = '" . $this->db->escape($data['email']) . "',
			mobileNumber = '" . $this->db->escape($data['mobileNumber']) . "', 
			country_id = '" . (int)$data['country_id'] . "', 
			city= '" .  $this->db->escape($data['city']) . "', 
			telephone = '" . $this->db->escape($data['telephone']) . "', 
			newsletter = '" . (int)$data['newsletter'] . "', 
			user_type = '" . (int)$data['user_type'] . "', 
			status = '" . (int)$data['status'] . "' WHERE su_id = '" . (int)$su_id . "'"; 
	    $this->db->query($sql);
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "siteusers SET password = '" . $this->db->escape(md5($data['password'])) . "' WHERE su_id = '" . (int)$su_id . "'");
      	}
	} 
	public function deleteSiteusers($su_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "siteusers WHERE su_id = '" . (int)$su_id . "'");
		//$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE su_id = '" . (int)$su_id . "'");
	} 
	public function getSiteuser($su_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "siteusers WHERE su_id = '" . (int)$su_id . "'"); 
		return $query->row;
	} 
	public function getSiteusers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "siteusers"; 
		$implode = array(); 
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = " LCASE(fullname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		} 
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = " LCASE(username) LIKE '%" . $this->db->escape($data['filter_username']) . "%'";
		} 
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		} 
		if (isset($data['filter_siteusers_type']) && !is_null($data['filter_siteusers_type'])) {
			$implode[] = "user_type = '" . $this->db->escape($data['filter_siteusers_type']) . "'";
		} 
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}	 
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
		}  
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		} 
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		} 
		$sort_data = array(
			'fullname',
			'email',
			'user_type',
			'status',
			'date_added'
		);	 
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY fullname";	
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
	public function approve($su_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "siteusers SET approved = '1' WHERE su_id = '" . (int)$su_id . "'");
	} 
	public function getSiteusersByNewsletter() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "siteusers WHERE newsletter = '1' ORDER BY fullname, email"); 
		return $query->rows;
	} 
	public function getSiteusersByKeyword($keyword) {
		if ($keyword) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "siteusers WHERE LCASE(fullname) LIKE '%" . $this->db->escape(strtolower($keyword)) . "%' ORDER BY fullname, email"); 
			return $query->rows;
		} else {
			return array();	
		}
	}
	public function getAddresses($keyword) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE su_id = '" . (int)$siteusers_id . "'"); 
		return $query->rows;
	} 
	public function getTotalSiteusers($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers"; 
		$implode = array(); 
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(fullname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		} 
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = " LCASE(username) LIKE '%" . $this->db->escape($data['filter_username']) . "%'";
		} 
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		} 
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		} 
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		} 
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		} 	
		$query = $this->db->query($sql); 
		return $query->row['total'];
	} 
	public function getTotalSiteusersAwaitingApproval() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE status = '0' OR approved = '0'"); 
		return $query->row['total'];
	} 
	public function getTotalAddressesBysiteusersId($su_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE su_id = '" . (int)$su_id . "'"); 
		return $query->row['total'];
	} 
	public function getTotalAddressesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int)$country_id . "'"); 
		return $query->row['total'];
	} 
	public function getTotalAddressesByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE zone_id = '" . (int)$zone_id . "'"); 
		return $query->row['total'];
	} 
	public function getTotalSiteusersByUserType($siteusers_type) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "siteusers WHERE user_type = '" . (int)$siteusers_type . "'"); 
		return $query->row['total'];
	}	
}
?>