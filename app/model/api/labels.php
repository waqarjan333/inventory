<?php
class ModelApiLabels extends Model{	
    public function createLabel($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "labels SET                                      
                    user_id = '20',
                    type = '1',
                    data = '".$data["json"]."',
                    created_date = NOW(),
                    updated_date = NOW()                    
                    ");
        $label_id =  $this->db->getLastId();     
        return $label_id;
    }
      public function updateLabel($data) {
        
        $this->db->query("UPDATE " . DB_PREFIX . "labels SET                     
                    data = '" . $data["json"] . "',
                    updated_date = NOW()                      
                    WHERE id= '" . $data["id"] . "'
                    ");
        
        return $data["id"];
    }
    
    public function getLabels($data){
         $search_string = '';
        if (isset($data['search'])) {
            $search_string = " WHERE ";
            $search_string .= "vendor_name like '" . $data['search_name'] . "%' AND ";            
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "labels
                ";

        $query = $this->db->query($sql);
        return $query->rows;
    }
    
    public function getLabelById($data){
        
         $sql = "SELECT * FROM " . DB_PREFIX . "labels
                WHERE id =".$data["id"];

        $query = $this->db->query($sql);
        return $query->row;
    
    }
    public function deleteLabel($id){
         return $this->db->query("DELETE FROM " . DB_PREFIX . "labels WHERE id = '" . $id . "'");            
    }
	
}
?>