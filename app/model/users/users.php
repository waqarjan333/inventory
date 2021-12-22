<?php

class ModelUsersUsers extends Model {

    public function saveUser($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "siteusers SET 
                    username = '" . $this->db->escape($data["username"]) . "',
                    password = '" . $this->db->escape(md5($data['password'])) . "',                    
                    user_type = '" . $data["usertype"] . "',
                    status = '" . (int) $data['status'] . "',
                    approved = '1',
                    date_added = NOW(),
                    howDidYouHear = '" . $data["customer_id"] . "',
                    update_pass = '1',
                    user_right='".$data['user_rights']."'
                    ");
        $user_id =  $this->db->getLastId();
        if($data['user_rights']==2){
          $this->db->query("INSERT INTO " . DB_PREFIX . "user_settings SET 
                     user_id = '" . $user_id . "',
                    user_rigths = '" . $data["user_access_json"] . "',
                    date_updated = NOW()
                    ");  
        }

        $user_id = $this->db->getLastId();
        return $user_id;
    }

    public function updateUser($data) {
        $password = "";
        if(isset($data['password']) && !empty($data['password'])){
            $password = "password = '" . $this->db->escape(md5($data['password'])) . "',";
        }
        $this->db->query("UPDATE " . DB_PREFIX . "siteusers SET 
                    username = '" . $this->db->escape($data["username"]) . "',
                    ".$password."                    
                    user_type = '" . $data["usertype"] . "',
                    status = '" . (int) $data['status'] . "',
                    update_pass = '1',
                    user_right='".$data['user_rights']."',
                    howDidYouHear = '" . $data["customer_id"] . "'
                    WHERE su_id= '" . $data["user_hidden_id"] . "'
                    ");
        $this->db->query("UPDATE " . DB_PREFIX . "user_settings SET 
                    user_rigths = '".$data["user_access_json"]."' 
                    WHERE user_id='".$data["user_hidden_id"]."'");
        return $data["user_hidden_id"];
    }

    public function checkNameExists($data) {
        $condition = '';
        if ($data['user_hidden_id'] != 0) {
            $condition = "AND su_id!=" . $data['user_hidden_id'];
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "siteusers
                        WHERE username='" . $data['username'] . "' " . $condition;
        $query = $this->db->query($sql);
        return $query->num_rows;
    }

    public function getUsers($data) {
        $search_string = '';
        if (isset($data['search'])) {
            $search_string = " WHERE ";
            $search_string .= "vendor_name like '" . $data['search_name'] . "%' AND ";
            $search_string .= "vendor_ct_name like '" . $data['search_contact'] . "%' AND ";
            $search_string .= "vendor_mobile like '" . $data['search_mobile'] . "%'";
        }
        $sql = "SELECT s.*, us.* FROM " . DB_PREFIX . "siteusers s
                LEFT JOIN " . DB_PREFIX . "user_settings us ON (s.su_id = us.user_id) ";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getUser($data) {

        $sql = "SELECT c.*, ac.balance as vendor_balance FROM " . DB_PREFIX . "vendor c
                        LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = c.vendor_acc_id)
                        WHERE c.vendor_id = '" . $data["vendor_id"] . "'
                        "
        ;
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function changeState($data) {
        $r = $data["_state"];
        try {
            $this->db->query("UPDATE " . DB_PREFIX . "vendor SET 
                    vendor_status = '" . $data["_state"] . "' 
                    WHERE vendor_id='" . $data["_id"] . "'");
        } catch (Exception $e) {
            $r = '$e->getMessage()';
        }
        return $r;
    }
      public function deleteUser($id){
		$sql = "UPDATE ".DB_PREFIX."siteusers SET 
                        status=0
        		WHERE su_id='".$id."'";    
		$query = $this->db->query($sql);
	}

}

?>
