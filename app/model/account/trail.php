<?php
class ModelAccountTrail extends Model {
		
	public function getTrail($data) {
            $date_range = "";
            $sql = "SELECT at.acc_type_id,at.acc_type_name,ah.acc_head_title,ac.* FROM " . DB_PREFIX . "account_chart ac
                    LEFT JOIN " . DB_PREFIX . "account_type at ON (ac.acc_type_id = at.acc_type_id) 
                    LEFT JOIN " . DB_PREFIX . "account_heads ah ON (ah.acc_head_id = at.head_id) 
                    WHERE ac.acc_type<51 ORDER BY at.head_id ASC"; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            $results = $query->rows;
            $ledger_accounts = array();
            foreach ($results as $result) {
                $debit_sum = $this->getDebitCredit($result['acc_id'],'d',$data);
                $credit_sum = $this->getDebitCredit($result['acc_id'],'c',$data);
            $ledger_accounts[] = array(
                    "acc_id" 		=>$result['acc_id'],
                    "acc_head"      	=>$result['acc_head_title'],
                    "_acc_type"      	=>$result['acc_type'],
                    "acc_type"      	=>$result['acc_type_name'],
                    "acc_type_id"      	=>$result['acc_type_id'],
                    "acc_name" 		=>$result['acc_name'],
                    "debit"		=> $debit_sum['sum']==NULL?0:$debit_sum['sum'],
                    "credit" 	=>     $credit_sum['sum']==NULL ? 0 : (-1*$credit_sum['sum']),
                    "debit_amount" => $debit_sum['amount']==NULL?0:$debit_sum['amount'],
                    "credit_amount" => $credit_sum['amount']==NULL ? 0 : (-1*$credit_sum['amount'])
                );
            }
            return $ledger_accounts;
	}
        
        public function getDebitCredit($id,$action,$data){
            $date_range = '';
            if(isset($data["end_date"]) ){
                if(!empty($data["end_date"])){
                $end_date = $data["end_date"];
                $date_range = " AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $flag = $action=='d'?">":"<";
            $sql = "SELECT SUM(journal_amount*currency_rate) as sum, SUM(journal_amount) as amount FROM " . DB_PREFIX . "account_journal
                    WHERE acc_id='".$id."' AND show_entry=1 and journal_amount".$flag."0
                 ".$date_range; 
            $query = $this->db->query($sql);
            $sum = $query->row;
            return $sum;
            
        }
        public function getTypeName($id){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_type WHERE acc_type_id='".$id."'"); 
            return $query->row['acc_type_name'];
        }
        public function getAmanatAccId($acc_id){
            $query = $this->db->query("SELECT avg_rate FROM " . DB_PREFIX . "amanat_account WHERE acc_id='".$acc_id."'"); 
            $result = "";
            if($query->num_rows){
                $result =$query->row['avg_rate'];
            }
            return $result;
        }
        
}

?>