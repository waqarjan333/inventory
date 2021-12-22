<?php
class ModelCommonRights extends Model{
	public function getUser($user_id){            
            $sql = "SELECT * FROM ".DB_PREFIX."user_settings           
                        WHERE user_id='".$user_id."'    
        		";
                //echo $sql;
                $query = $this->db->query($sql);
		return $query->row;
		
	}
	public function saveRights($data){
            $r = "0";
            try{
            $this->db->query("UPDATE " . DB_PREFIX . "user_settings SET 
                    user_rigths = '".$data["user_rights"]."' 
                    WHERE user_id='".$data["user_id"]."'"); 
            }
            catch(Exception $e){
              $r = '$e->getMessage()';  
            }
            return $r;	
	}
	

	
}
?>