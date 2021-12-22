<?php
class ModelSettingSite extends Model {
	public function addsite($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "site SET name = '" . $this->db->escape($data['name']) . "', url = '" . $this->db->escape($data['url']) . "', title = '" . $this->db->escape($data['title']) . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', template = '" . $this->db->escape($data['template']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', language = '" . $this->db->escape($data['language']) . "', currency = '" . $this->db->escape($data['currency']) . "', tax = '" . (int)$data['tax'] . "', siteusers_group_id = '" . (int)$data['siteusers_group_id'] . "', siteusers_price = '" . (int)$data['siteusers_price'] . "', siteusers_approval = '" . (int)$data['siteusers_approval'] . "', guest_checkout = '" . (int)$data['guest_checkout'] . "', account_id = '" . (int)$data['account_id'] . "', checkout_id = '" . (int)$data['checkout_id'] . "', stock_display = '" . (int)$data['stock_display'] . "', stock_check = '" . (int)$data['stock_check'] . "', stock_checkout = '" . (int)$data['stock_checkout'] . "', stock_subtract = '" . (int)$data['stock_subtract'] . "', order_status_id = '" . (int)$data['order_status_id'] . "', logo = '" . $this->db->escape($data['logo']) . "',  icon = '" . $this->db->escape($data['icon']) . "', image_thumb_width = '" . (int)$data['image_thumb_width'] . "', image_thumb_height = '" . (int)$data['image_thumb_height'] . "', image_popup_width = '" . (int)$data['image_popup_width'] . "', image_popup_height = '" . (int)$data['image_popup_height'] . "', image_category_width = '" . (int)$data['image_category_width'] . "', image_category_height = '" . (int)$data['image_category_height'] . "', image_product_width = '" . (int)$data['image_product_width'] . "', image_product_height = '" . (int)$data['image_product_height'] . "', image_additional_width = '" . (int)$data['image_additional_width'] . "', image_additional_height = '" . (int)$data['image_additional_height'] . "', image_related_width = '" . (int)$data['image_related_width'] . "', image_related_height = '" . (int)$data['image_related_height'] . "', image_cart_width = '" . (int)$data['image_cart_width'] . "', image_cart_height = '" . (int)$data['image_cart_height'] . "', `ssl` = '" . (int)$data['ssl'] . "'");
		
		$site_id = $this->db->getLastId();
		
		foreach ($data['site_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "site_description SET site_id = '" . (int)$site_id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->cache->delete('site');
		
		return $site_id;
	}
	
	public function editsite($site_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "site SET name = '" . $this->db->escape($data['name']) . "', url = '" . $this->db->escape($data['url']) . "', title = '" . $this->db->escape($data['title']) . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', template = '" . $this->db->escape($data['template']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', language = '" . $this->db->escape($data['language']) . "', currency = '" . $this->db->escape($data['currency']) . "', tax = '" . (int)$data['tax'] . "', siteusers_group_id = '" . (int)$data['siteusers_group_id'] . "', siteusers_price = '" . (int)$data['siteusers_price'] . "', siteusers_approval = '" . (int)$data['siteusers_approval'] . "', guest_checkout = '" . (int)$data['guest_checkout'] . "', account_id = '" . (int)$data['account_id'] . "', checkout_id = '" . (int)$data['checkout_id'] . "', stock_display = '" . (int)$data['stock_display'] . "', stock_check = '" . (int)$data['stock_check'] . "', stock_checkout = '" . (int)$data['stock_checkout'] . "', stock_subtract = '" . (int)$data['stock_subtract'] . "', order_status_id = '" . (int)$data['order_status_id'] . "', logo = '" . $this->db->escape($data['logo']) . "',  icon = '" . $this->db->escape($data['icon']) . "', image_thumb_width = '" . (int)$data['image_thumb_width'] . "', image_thumb_height = '" . (int)$data['image_thumb_height'] . "', image_popup_width = '" . (int)$data['image_popup_width'] . "', image_popup_height = '" . (int)$data['image_popup_height'] . "', image_category_width = '" . (int)$data['image_category_width'] . "', image_category_height = '" . (int)$data['image_category_height'] . "', image_product_width = '" . (int)$data['image_product_width'] . "', image_product_height = '" . (int)$data['image_product_height'] . "', image_additional_width = '" . (int)$data['image_additional_width'] . "', image_additional_height = '" . (int)$data['image_additional_height'] . "', image_related_width = '" . (int)$data['image_related_width'] . "', image_related_height = '" . (int)$data['image_related_height'] . "', image_cart_width = '" . (int)$data['image_cart_width'] . "', image_cart_height = '" . (int)$data['image_cart_height'] . "', `ssl` = '" . (int)$data['ssl'] . "', catalog_limit = '" . (int)$data['catalog_limit'] . "', cart_weight = '" . (int)$data['cart_weight'] . "' WHERE site_id = '" . (int)$site_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "site_description WHERE site_id = '" . (int)$site_id . "'");
		
		foreach ($data['site_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "site_description SET site_id = '" . (int)$site_id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->cache->delete('site');
	}
	
	public function deletesite($site_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "site WHERE site_id = '" . (int)$site_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "site_description WHERE site_id = '" . (int)$site_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_site WHERE site_id = '" . (int)$site_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_site WHERE site_id = '" . (int)$site_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "cms_to_site WHERE site_id = '" . (int)$site_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_site WHERE site_id = '" . (int)$site_id . "'");
	
		$this->cache->delete('site');
	}	
	
	public function getsite($site_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "site WHERE site_id = '" . (int)$site_id . "'");
		
		return $query->row;
	}
	
	public function getsiteDescriptions($site_id) {
		$site_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "site_description WHERE site_id = '" . (int)$site_id . "'");
		
		foreach ($query->rows as $result) {
			$site_description_data[$result['language_id']] = array('description' => $result['description']);
		}
		
		return $site_description_data;
	}
	
	public function getsites($data = array()) {
		$site_data =array(); /*$this->cache->get('site');
	
		if (!$site_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "site ORDER BY url");

			$site_data = $query->rows;
		
			$this->cache->set('site', $site_data);
		}*/
	 
		return $site_data;
	}

	public function getTotalsites() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site");
		
		return $query->row['total'];
	}	

	public function getTotalsitesByLanguage($language) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE language = '" . $this->db->escape($language) . "'");
		
		return $query->row['total'];		
	}
	
	public function getTotalsitesByCurrency($currency) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE currency = '" . $this->db->escape($currency) . "'");
		
		return $query->row['total'];		
	}
	
	public function getTotalsitesByCountryId($country_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE country_id = '" . (int)$country_id . "'");
		
		return $query->row['total'];		
	}
	
	public function getTotalsitesByZoneId($zone_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE zone_id = '" . (int)$zone_id . "'");
		
		return $query->row['total'];		
	}
	
	public function getTotalsitesByCustomerGroupId($siteusers_group_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE siteusers_group_id = '" . (int)$siteusers_group_id . "'");
		
		return $query->row['total'];		
	}	
	
	public function getTotalsitesBycmsId($cms_id) {
      	$account_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE account_id = '" . (int)$cms_id . "'");
      	
		$checkout_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE checkout_id = '" . (int)$cms_id . "'");
		
		return ($account_query->row['total'] + $checkout_query->row['total']);
	}
	
	public function getTotalsitesByOrderStatusId($order_status_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "site WHERE order_status_id = '" . (int)$order_status_id . "'");
		
		return $query->row['total'];		
	}	
}
?>