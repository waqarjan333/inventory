<?php
date_default_timezone_set("Asia/Karachi");

class ModelAccountJournal extends Model {

	public function addEntry($data) { 
            $debit_cur_rate = 1;
            $credit_cur_rate = 1;
            $debit_cur_id = '0';
            $credit_cur_id = '0';
                                                    
            $credit_cur_id = '0';
            $amount_credit = -1*$data["credit_amount"];   
            $amount_debit = $data["debit_amount"];
            $credit_account_id = $data['acc_1'];
            $date_format=date('Y-m-d', strtotime($data['entry_date'])).' '.date('H:i:s');

            // echo $date_format;exit;
            
                       
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['acc_0']."', journal_amount='".$amount_debit."', journal_details  = '" . $data['desc'] . "',inv_id= '0',currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$date_format."'"); 
            $last_id = (int)$this->db->getLastId();  
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_id."' WHERE journal_id='".$last_id."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$credit_account_id."', journal_amount='".$amount_credit."', journal_details  = '" . $data['desc'] . "',inv_id= '0',ref_id='".$last_id."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$date_format."'"); 
            
	    return ($last_id);	
	}
        
	public function updateEntry($data) {
            $debit_cur_rate = 1;
            $credit_cur_rate = 1;
            $debit_cur_id = '0';
            $credit_cur_id = '0';
            $amount_debit = $data["debit_amount"];
            $amount_credit = -1*$data["credit_amount"];
            
           $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET acc_id='".$data['acc_0']."', journal_amount='".$amount_debit."', journal_details  = '" . $data['desc'] . "',currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$data['entry_date']."' WHERE journal_id = '".$data["debit_entry_id"] ."'");  
           $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET acc_id='".$data['acc_1']."', journal_amount='".$amount_credit."', journal_details  = '" . $data['desc']."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$data['entry_date']."' WHERE journal_id = '".$data["credit_entry_id"] ."'"); 
           
           return $data["debit_entry_id"];
	} 
	
        public function deleteEntry($id) {   
            $query = $this->db->query("SELECT ref_id FROM " . DB_PREFIX . "account_journal WHERE journal_id='".(int)$id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE ref_id = '" . $query->row['ref_id'] . "'");            
        }
	public function getJournalList($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            
            /*if(isset($data['load_id']) && !empty($data['load_id'])){
                $date_range = " ref_id='".$data['load_id']."'";
            }*/
          
            $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                WHERE 
                ".$date_range; 
            
            $query = $this->db->query($sql);
            return $query->rows;
	}
	
        public function updateAvgCost($data){
            $bought= $this->getDebitCreditCurency($data['acc_0'], 'd', $data["entry_date"]);
            $bought_sum = ($bought['sum']==NULL)?0:$bought['sum'];
            $sell= $this->getDebitCreditCurency($data['acc_0'], 'c', $data["entry_date"]);
            $sell_sum =($sell['sum']==NULL)?0:$sell['sum'];
            $remaining = $bought_sum + $sell_sum;
            $avg_buy_rate = $data['cur_rate'];
            $sql = "SELECT avg_buy_value FROM " . DB_PREFIX . "currencyexchange WHERE currency_id='".$data['cur_id']."'"; 
            $query = $this->db->query($sql);
            $cur_avg_rate = $query->row['avg_buy_value']==NULL?1:$query->row['avg_buy_value'];
            if($remaining!=0){
                $avg_buy_rate = (($remaining*$cur_avg_rate)+($data['debit_amount']*$data['cur_rate']))/($remaining+$data['debit_amount']);
            }
            $this->db->query("UPDATE " . DB_PREFIX . "currencyexchange SET 
                    avg_buy_value = '".$avg_buy_rate."'
                    WHERE currency_id = '".$data['cur_id']."'
             "); 
        }
        public function getDebitCreditCurency($id,$action,$_date){
            $date_range = " AND entry_date < '". $_date ."' + interval 1 day";                
            $flag = $action=='d'?">":"<";
            $sql = "SELECT SUM(journal_amount) as sum FROM " . DB_PREFIX . "account_journal
                    WHERE acc_id='".$id."' and journal_amount".$flag."0
                ".$date_range;           
            $query = $this->db->query($sql);
            return $query->row;
            
        }
        public function updateAvgRateOnChange($data){
           $sql = "SELECT SUM(journal_amount*currency_rate) as amount_sum,SUM(journal_amount) as remaining  FROM " . DB_PREFIX . "account_journal
                    WHERE acc_id='".$data['acc_id']."'";
            $query = $this->db->query($sql);
            $avg_buy_rate =   $query->row['amount_sum']/$query->row['remaining'];
            $this->db->query("UPDATE " . DB_PREFIX . "currencyexchange SET 
                    avg_buy_value = '".$avg_buy_rate."'
                    WHERE currency_id = '".$data['currency_id']."'
             "); 
        }
	
}

?>