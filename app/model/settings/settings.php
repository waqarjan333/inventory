<?php

class ModelSettingsSettings extends Model {

    public function saveUnit($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "units SET 
                    name = '" . $this->db->escape($data["unit_name"]) . "',                    
                    date_added = NOW()
                   ");

        $unit_id = $this->db->getLastId();
        return $unit_id;
    }

    public function updateUnit($data) {
        
        $this->db->query("UPDATE " . DB_PREFIX . "units SET 
                    name = '" . $this->db->escape($data["unit_name"]) . "'                                                          
                    WHERE id= '" . $data["unit_hidden_id"] . "'
                    ");
        return $data["unit_hidden_id"];
    }

    public function checkNameExists($data) {
        $condition = '';
        if ($data['unit_hidden_id'] != 0) {
            $condition = "AND id!=" . $data['unit_hidden_id'];
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "units
                        WHERE name='" . $data['unit_name'] . "' " . $condition;
        $query = $this->db->query($sql);
        return $query->num_rows;
    }

    public function getUnits($data) {
        $search_string = '';
        
        $sql = "SELECT * FROM " . DB_PREFIX . "units";

        $query = $this->db->query($sql);
        return $query->rows;
    }


    public function deleteUnit($id){
        $sql = "delete from ".DB_PREFIX."units 
                WHERE id='".$id."'";    
        $query = $this->db->query($sql);
    }

}

?>
