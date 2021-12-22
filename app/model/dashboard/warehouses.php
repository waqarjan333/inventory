<?php
class ModelDashboardWarehouses extends Model{
        public function saveupdateWarehouse($data){
          if($data["warehouse_isdefault"]=="1"){
             $this->db->query("UPDATE " . DB_PREFIX . "warehouses SET warehouse_isdefault=0"); 
          }  
          if($data['warehouse_id']==0){ 
              $this->db->query("INSERT INTO " . DB_PREFIX . "warehouses SET 
                        warehouse_name = '".$data["warehouse_name"]."',
                        warehouse_code = '".$data["warehouse_code"]."',
                        warehouse_contant_name = '".$data["warehouse_contact_name"]."',
                        warehouse_phone = '".$data["warehouse_phone"]."',
                        warehouse_mobile = '".$data["warehouse_mobile"]."',
                        warehouse_ddi_number='".$data["warehouse_ddi_number"]."',
                        warehouse_isdefault='".$data["warehouse_isdefault"]."',
                        warehouse_address='".$data["warehouse_address"]."',
                        warehouse_street='".$data["warehouse_street"]."',
                        warehouse_city='".$data["warehouse_city"]."',    
                        warehouse_state='".$data["warehouse_state"]."',
                        warehouse_country='".$data["warehouse_country"]."',    
                        warehouse_postalcode='".$data["warehouse_postalcode"]."',    
                        warehouse_isactive='".$data["warehouse_isactive"]."',    
                        last_changed=NOW() 
                        "); 
              $last_id = $this->db->getLastId();
          }
          else{
              $this->db->query("UPDATE " . DB_PREFIX . "warehouses SET 
                        warehouse_name = '".$data["warehouse_name"]."',
                        warehouse_code = '".$data["warehouse_code"]."',
                        warehouse_contant_name = '".$data["warehouse_contact_name"]."',
                        warehouse_phone = '".$data["warehouse_phone"]."',
                        warehouse_mobile = '".$data["warehouse_mobile"]."',
                        warehouse_ddi_number='".$data["warehouse_ddi_number"]."',
                        warehouse_isdefault='".$data["warehouse_isdefault"]."',
                        warehouse_address='".$data["warehouse_address"]."',
                        warehouse_street='".$data["warehouse_street"]."',
                        warehouse_city='".$data["warehouse_city"]."',    
                        warehouse_state='".$data["warehouse_state"]."',
                        warehouse_country='".$data["warehouse_country"]."',    
                        warehouse_postalcode='".$data["warehouse_postalcode"]."',    
                        warehouse_isactive='".$data["warehouse_isactive"]."', 
                        last_changed=NOW() 
                        WHERE warehouse_id='".$data['warehouse_id']."'
                      "); 
             $last_id = $this->db->getLastId();
          }
          return $last_id;
        }
         public function checkNameExists($data){
            $condition = '';
            if($data['warehouse_id']!=0){
                $condition = "AND warehouse_id!=".$data['warehouse_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."warehouses
                        WHERE warehouse_name='".$data['warehouse_name']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        public function checkCodeExists($data){
            $condition = '';
            if($data['warehouse_id']!=0){
                $condition = "AND warehouse_id!=".$data['warehouse_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."warehouses
                        WHERE warehouse_code='".$data['warehouse_code']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        
        public function getWarehouses($data){
                if(!isset($data['search'])){
		$sql = "SELECT * FROM ".DB_PREFIX."warehouses ORDER BY `warehouse_id` ASC
        		";    
                }
                else{
                   $sql = "SELECT * FROM ".DB_PREFIX."warehouses 
        		WHERE warehouse_name like '".$data['search']."%'";     
                }
		$query = $this->db->query($sql);
		return $query->rows;
	}
    
        public function getWarehouses_2($data)
        {
            $sql="SELECT * FROM ".DB_PREFIX."warehouses WHERE warehouse_id !='".$data['ware_id']."'";
            $query = $this->db->query($sql);
            // echo $sql;exit;
        return $query->rows;
        }
        public function deleteAccount($id){
		$sql = "DELETE FROM ".DB_PREFIX."account_chart 
        		WHERE acc_id='".$id."'";    
		$query = $this->db->query($sql);
	}
        public function deactivateWarehouse($id){
		$sql = "UPDATE ".DB_PREFIX."warehouses SET 
                        warehouse_isactive=0
        		WHERE warehouse_id='".$id."'";    
		$query = $this->db->query($sql);
	}
       
        
}
?>

