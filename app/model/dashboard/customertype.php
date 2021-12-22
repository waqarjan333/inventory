<?php
class ModelDashboardCustomertype extends Model{
        public function saveupdatetype($data){
            $result=str_replace("&amp;", '&', $data["type_name"]); 
            $name=str_replace("&quot;", '"', $result);
          if($data["type_isdefault"]=="1"){
             $this->db->query("UPDATE " . DB_PREFIX . "customer_types SET cust_type_isdefault=0"); 
          }  
          if($data['type_id']==0){ 
              
              $this->db->query("INSERT INTO " . DB_PREFIX . "customer_types SET 
                        cust_type_name = '".$name."',                        
                        cust_type_isdefault='".$data["type_isdefault"]."',  
                        updated_date=NOW(),
                        created_date=NOW()
                        "); 
              $last_id = $this->db->getLastId();
          }
          else{
              $this->db->query("UPDATE " . DB_PREFIX . "customer_types SET 
                        cust_type_name = '".$name."',                        
                        cust_type_isdefault='".$data["type_isdefault"]."',  
                        updated_date=NOW()
                        WHERE id='".$data['type_id']."'
                      "); 
             $last_id = $this->db->getLastId();
          }
          return $last_id;
        }
         public function checkNameExists($data){
             $result=str_replace("&amp;", '&', $data["type_name"]); 
            $name=str_replace("&quot;", '"', $result);
            $condition = '';
            if($data['type_id']!=0){
                $condition = "AND id!=".$data['type_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."customer_types
                        WHERE cust_type_name='".$name."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }       
        
        public function getType($data){
                if(!isset($data['search'])){
		$sql = "SELECT * FROM ".DB_PREFIX."customer_types 
        		";    
                }
                else{
                   $sql = "SELECT * FROM ".DB_PREFIX."customer_types 
        		WHERE cust_type_name like '".$data['search']."%'";     
                }
		$query = $this->db->query($sql);
		return $query->rows;
	}
           
        public function deleteType($id){
            $sql = "DELETE FROM ".DB_PREFIX."customer_types 
                    WHERE id='".$id."'";    
            $query = $this->db->query($sql);
            return $query;
	}
       
        
}
?>

