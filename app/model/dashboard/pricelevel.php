<?php
class ModelDashboardPricelevel extends Model{
        public function saveupdatePricelevel($data,$details){
          $level_dir = $data['level_type']=='1'?$data['fix_level_value']:$data['peritem_level_value'];
          $level_per = $data['level_type']=='1'?$data['fix_level_percentage']:$data['peritem_level_percentage'];
          $level_round = $data['price_level_rounding'];
          $level_compare = $data['level_type']=='1'?NULL:$data['peritem_level_field'];
           $items_array = null;
         
          $level_detail = "";
          if($data['level_type']=='1'){
              $level_detail .=   ($level_dir == -1) ? '-' : '';
              $level_detail .=   $level_per . '.0%';
          }
          else{
              $level_detail = "Varies per item";
              //$items_array = explode(",",$data['selected']); 
          }
          
          if($data['pricelevel_id']==0){ 
              $this->db->query("INSERT INTO " . DB_PREFIX . "price_level SET 
                level_name = '".$data["level_name"]."',
                level_type = '".$data["level_type"]."',
                level_dir = '".$level_dir."',    
                level_per = '".$level_per."',
                level_round = '".$level_round."',
                level_compare_price = '".$level_compare."',
                level_detail = '".$level_detail."',
                level_from_date = '".$data["level_from_date"]."',
                level_to_date = '".$data["level_to_date"]."',
                last_changed=NOW() 
                ");               
              $last_id = $this->db->getLastId();
              if($data['level_type']=='2'){
                   for($i=0;$i<count($details);$i++){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "price_level_per_item SET
                        l_id = '".$last_id."',    
                        item_id = '".$details[$i]->{'id'}."',        
                        item_per_level = '".$details[$i]->{'per_level'}."',            
                        last_changed=NOW() 
                        "); 
                   }
              }
          }
          else{
              $this->db->query("UPDATE " . DB_PREFIX . "price_level SET 
                level_name = '".$data["level_name"]."',
                level_type = '".$data["level_type"]."',                                     
                level_dir = '".$level_dir."',    
                level_per = '".$level_per."',
                level_round = '".$level_round."',
                level_compare_price = '".$level_compare."',    
                level_detail = '".$level_detail."',
                level_from_date = '".$data["level_from_date"]."',
                level_to_date = '".$data["level_to_date"]."',                        
                last_changed=NOW() 
                WHERE level_id='".$data['pricelevel_id']."'
              "); 
             $last_id = $this->db->getLastId();
             if($data['level_type']=='2'){
                   $query = $this->db->query("DELETE FROM ".DB_PREFIX."price_level_per_item WHERE l_id='".$data['pricelevel_id']."'");                   
                   for($i=0;$i<count($details);$i++){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "price_level_per_item SET
                        l_id = '".$data['pricelevel_id']."',    
                        item_id = '".$details[$i]->{'id'}."',        
                        item_per_level = '".$details[$i]->{'per_level'}."',            
                        last_changed=NOW() 
                        "); 
                   }
              }
          }
          return $last_id;
        }
        
        public function checkNameExists($data){
            $condition = '';
            if($data['pricelevel_id']!=0){
                $condition = "AND level_id!=".$data['pricelevel_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."price_level
                        WHERE level_name='".$data['level_name']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
      
        
        public function getPriceLevels($data){
                if(!isset($data['search'])){
		$sql = "SELECT * FROM ".DB_PREFIX."price_level 
        		";    
                }
                else{
                   $sql = "SELECT * FROM ".DB_PREFIX."price_level 
        		WHERE level_name like '".$data['search']."%'";     
                }
		$query = $this->db->query($sql);
		return $query->rows;
	}
    
        public function deletePriceLevel($id){
		$sql = "DELETE FROM ".DB_PREFIX."price_level 
        		WHERE level_id='".$id."'";    
		$query = $this->db->query($sql);
	}
        
        public function getItems($data){
            $sql = "SELECT item_id,item_per_level FROM ".DB_PREFIX."price_level_per_item
        		WHERE l_id = '".$data['level_id']."'";   
            $query = $this->db->query($sql);
            return $query->rows;
        }
        
}
?>

