<?php
class ModelDashboardCgroup extends Model{
        public function saveupdategroup($data){
            $result=str_replace("&amp;", '&', $data["group_name"]); 
            $name=str_replace("&quot;", '"', $result);
          if($data["group_isdefault"]=="1"){
             $this->db->query("UPDATE " . DB_PREFIX . "customer_groups SET cust_group_isdefault=0"); 
          }  
          if($data['group_id']==0){ 
              $this->db->query("INSERT INTO " . DB_PREFIX . "customer_groups SET 
                        cust_group_name = '".$name."',                        
                        cust_group_isdefault='".$data["group_isdefault"]."',  
                        updated_date=NOW(),
                        created_date=NOW()
                        "); 
              $last_id = $this->db->getLastId();
          }
          else{
              $this->db->query("UPDATE " . DB_PREFIX . "customer_groups SET 
                        cust_group_name = '".$name."',                        
                        cust_group_isdefault='".$data["group_isdefault"]."',  
                        updated_date=NOW()
                        WHERE id='".$data['group_id']."'
                      "); 
             $last_id = $this->db->getLastId();
          }
          return $last_id;
        }
         public function checkNameExists($data){
            $condition = '';
            if($data['group_id']!=0){
                $condition = "AND id!=".$data['group_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."customer_groups
                        WHERE cust_group_name='".$data['group_name']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }       
        
        public function getGroup($data){
                if(!isset($data['search'])){
		$sql = "SELECT * FROM ".DB_PREFIX."customer_groups 
        		";    
                }
                else{
                   $sql = "SELECT * FROM ".DB_PREFIX."customer_groups 
        		WHERE cust_group_name like '".$data['search']."%'";     
                }
		$query = $this->db->query($sql);
		return $query->rows;
	}
           
        public function deleteGroup($id){
            $sql = "DELETE FROM ".DB_PREFIX."customer_groups 
                    WHERE id='".$id."'";    
            $query = $this->db->query($sql);
            return $query;
	}
       
        
}
?>

