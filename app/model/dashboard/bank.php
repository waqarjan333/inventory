<?php
class ModelDashboardBank extends Model{
            public function getBanks($data){                                
		$sql = "SELECT * FROM ".DB_PREFIX."account_chart 
                        WHERE acc_type_id=8
                        ";
                
                //echo $sql;
		$query = $this->db->query($sql);
		return $query->rows;
	}
      
        
}
?>
