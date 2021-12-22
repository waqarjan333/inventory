<?php 
class ModelSettingSetting extends Model {
	public function getSetting($group) {
		$data = array();  
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE AND `group` = '" . $this->db->escape($group) . "'"); 
		foreach ($query->rows as $result) {
			$data[$result['key']] = $result['value'];
		} 
		return $data;
	} 
	public function editSetting($group, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "'"); 
		foreach ($data as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");

$grop= $this->db->escape($key);
$val=$this->db->escape($value);
			if($grop=='config_language' && $val=='ur')
			{
			$this->db->query("UPDATE  " . DB_PREFIX . " category SET  `name`='پہلے سے طے شدہ', `description`='طے شدہ کیٹیگری' WHERE `id`='1'");
			$this->db->query("UPDATE  " . DB_PREFIX . " customer SET `cust_name`='نقد گاہک' WHERE `cust_id`=0");
			$this->db->query("UPDATE  " . DB_PREFIX . " customer_groups SET `cust_group_name`='طے شدہ گروپ' WHERE `id`=1");
			$this->db->query("UPDATE  " . DB_PREFIX . " customer_types SET `cust_type_name`='طے شدہ' WHERE `id`=1");
			$this->db->query("UPDATE  " . DB_PREFIX . " salesrep SET `salesrep_name`='طے شدہ فروخت کندہ' WHERE `id`=1");
			$this->db->query("UPDATE  " . DB_PREFIX . " warehouses SET  `warehouse_name`='طے شدہ مقام' WHERE `warehouse_id`=1");
			}elseif($grop=='config_language' && $val=='en')
			{
			$this->db->query("UPDATE  " . DB_PREFIX . " category SET `name`='Default', `description`='Default Category' WHERE `id`='1'");
			$this->db->query("UPDATE  " . DB_PREFIX . " customer SET `cust_name`='Walk In Customer' WHERE `cust_id`=0");
			$this->db->query("UPDATE  " . DB_PREFIX . " customer_groups SET `cust_group_name`='Default Group' WHERE `id`=1");
			$this->db->query("UPDATE  " . DB_PREFIX . " customer_types SET `cust_type_name`='Default' WHERE `id`=1");
			$this->db->query("UPDATE  " . DB_PREFIX . " salesrep SET `salesrep_name`='Default Rep' WHERE `id`=1");
			$this->db->query("UPDATE  " . DB_PREFIX . " warehouses SET `warehouse_name`='Default Location' WHERE `warehouse_id`=1");
			}
		}
	} 
	public function deleteSetting($group) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "'");
	}
}
?>