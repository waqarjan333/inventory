<?php
class ModelDashboardSalesrep extends Model{
        public function saveupdateSalesrep($data){
          
          if($data['salesrep_id']==0){ 
              $this->db->query("INSERT INTO " . DB_PREFIX . "salesrep SET 
                        salesrep_name = '".$data["salesrep_name"]."',
                        salesrep_title = '".$data["salesrep_title"]."',                        
                        salesrep_phone = '".$data["salesrep_phone"]."',
                        salesrep_email = '".$data["salesrep_email"]."',
                        salesrep_mobile = '".$data["salesrep_mobile"]."',                                                
                        salesrep_address='".$data["salesrep_address"]."',                        
                        salesrep_status='".$data["salesrep_status"]."',    
                        salesrep_created=NOW(),
                        salesrep_updated=NOW()
                        "); 
              $last_id = $this->db->getLastId();
          }
          else{
              $this->db->query("UPDATE " . DB_PREFIX . "salesrep SET 
                        salesrep_name = '".$data["salesrep_name"]."',
                        salesrep_title = '".$data["salesrep_title"]."',                        
                        salesrep_phone = '".$data["salesrep_phone"]."',
                        salesrep_email = '".$data["salesrep_email"]."',
                        salesrep_mobile = '".$data["salesrep_mobile"]."',                                                
                        salesrep_address='".$data["salesrep_address"]."',                        
                        salesrep_status='".$data["salesrep_status"]."',                            
                        salesrep_updated=NOW()
                        WHERE id='".$data['salesrep_id']."'
                      "); 
             $last_id = $this->db->getLastId();
          }
          return $last_id;
        }
        
       public function checkNameExists($data){
            $condition = '';            
            if($data['salesrep_id']!=0){
                $condition = "AND id!=".$data['salesrep_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."salesrep
                        WHERE salesrep_name='".$data['salesrep_name']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }    
        
        public function getSalesreps($data){
                if(!isset($data['search'])){
		$sql = "SELECT * FROM ".DB_PREFIX."salesrep WHERE salesrep_status=1
        		";    
                }
                else{
                   $sql = "SELECT * FROM ".DB_PREFIX."salesrep 
        		WHERE salesrep_name like '%".$data['search']."%' AND status=1";     
                }
		$query = $this->db->query($sql);
		return $query->rows;
	}
    
        public function deleteSalerep($id){
		$sql = "DELETE FROM ".DB_PREFIX."salesrep 
        		WHERE id='".$id."'";    
		$query = $this->db->query($sql);
	}
        public function deactivateSalesrep($id){
		$sql = "UPDATE ".DB_PREFIX."salesrep SET 
                        salesrep_status=0
        		WHERE id='".$id."'";    
		$query = $this->db->query($sql);
	}
       
        
}
?>

