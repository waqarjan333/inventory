<?php
class ModelDashboardExpense extends Model{
        public function getExpenses($data){
            $search_string = '';
            if(isset($data['search'])){
                $search_string = " AND ";
                $search_string .= "acc_name like '%".$data['search']."%'";                    
            }
            $sql = "SELECT * FROM ".DB_PREFIX."account_chart
                    WHERE acc_type_id=5 AND acc_id!=9 && acc_id!=10"
                    .$search_string;

            $query = $this->db->query($sql);
            return $query->rows;
	}
        public function getAllExpenses($data){            
            $sql = "SELECT * FROM ".DB_PREFIX."account_chart
                    WHERE acc_type_id=5";                   
            $query = $this->db->query($sql);
            return $query->rows;
	}
        
        public function getAllLoans($data){            
            $sql = "SELECT * FROM ".DB_PREFIX."account_chart
                    WHERE acc_type_id=14 or acc_type_id=15";                   
            $query = $this->db->query($sql);
            return $query->rows;
	}
        
}
?>
