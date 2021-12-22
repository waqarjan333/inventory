<?php
class ModelAccountLedger extends Model {
	
		
	public function getLedgerList($data) {
            $date_range = "";
            $sql = "SELECT at.acc_type_id,ah.acc_head_title,ac.* FROM " . DB_PREFIX . "account_chart ac
                    LEFT JOIN " . DB_PREFIX . "account_type at ON (ac.acc_type_id = at.acc_type_id) 
                    LEFT JOIN " . DB_PREFIX . "account_heads ah ON (ah.acc_head_id = at.head_id) 
                    WHERE ac.acc_type<51
                "; 
            
            $query = $this->db->query($sql);
            $results = $query->rows;
            $ledger_accounts = array();
            foreach ($results as $result) {
                $debit = $this->getDebitCredit($result['acc_id'],'d',$data);
                $credit = -1*$this->getDebitCredit($result['acc_id'],'c',$data);
                $balance = number_format($debit - $credit,2,'.','');  
            $ledger_accounts[] = array(
                    "id" 		=>$result['acc_id'],
                    "type"      	=>$result['acc_head_title'],
                    "acc_type"      	=>$result['acc_type'],     
                    "account_ledger" 		=>$result['acc_name'],
                    "debit"		=> number_format($debit,2,'.',''),
                    "credit" 	=>  number_format($credit,2,'.',''),
                    "balance"   => $balance
                );
            }
            return $ledger_accounts;
	}
        public function getAccountType($acc_id){
             $sql = "SELECT acc_type FROM " . DB_PREFIX . "account_chart WHERE acc_id='".$acc_id."'";
             $query = $this->db->query($sql);
             return $query->row['acc_type'];
        }
        public function getDebitCredit($id,$action,$data){
            $date_range = '';
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                 $start_date = $data["start_date"];
                $end_date = $data["end_date"];
                $date_range = " AND entry_date>='". $start_date ."' AND entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $flag = $action=='d'?">":"<";
            $sql = "SELECT SUM(journal_amount*currency_rate) as sum FROM " . DB_PREFIX . "account_journal
                    WHERE acc_id='".$id."' and show_entry=1 and journal_amount".$flag."0
                ".$date_range; 
            $query = $this->db->query($sql);
            $sum = $query->row['sum']===NULL ? 0: $query->row['sum'] ;
            return $sum;
            
        }
        public function getDebitCreditOpening($id,$action,$data){
            $date_range = '';
            if(isset($data["start_date"]) ){
                if(!empty($data["start_date"])){
                 $start_date = $data["start_date"];
                 $date_range = " AND entry_date<'". $start_date ."'";
                }
            }
            $flag = $action=='d'?">":"<";
            $sql = "SELECT SUM(journal_amount*currency_rate) as sum,SUM(journal_amount) as amount FROM " . DB_PREFIX . "account_journal
                    WHERE acc_id='".$id."' and show_entry=1 and journal_amount".$flag."0
                ".$date_range; 
            $query = $this->db->query($sql);
            $sum = $query->row ;
            return $sum;
            
        }
        public function getOpeningBalance($acc_id,$data){
            $ledger_account = array();
            $debit_sum = $this->getDebitCreditOpening($acc_id,'d',$data);
            $credit_sum = $this->getDebitCreditOpening($acc_id,'c',$data);
            $ledger_account[] = array(
                    "id" 		=>$acc_id,
                    "debit"		=> $debit_sum['sum']==NULL?0:$debit_sum['sum'],
                    "credit" 	=>     $credit_sum['sum']==NULL ? 0 : (-1*$credit_sum['sum']),
                    "debit_amount" => $debit_sum['amount']==NULL?0:$debit_sum['amount'],
                    "credit_amount" => $credit_sum['amount']==NULL ? 0 : (-1*$credit_sum['amount'])
                );
            return $ledger_account;
        }
	public function getDetailsAccount($acc_id,$data){
            
            $acc_type = $this->getAccountType($acc_id); 
            $open_results = $this->getOpeningBalance($acc_id,$data); 
            $p_balance = 0;
            $last_date = $data['end_date'];
             foreach ($open_results as $result) {
                 if($acc_type!=2){
                    $balance = number_format($result['debit'] - $result['credit'],2,'.','');
                 }
                 else{
                    $balance = number_format($result['debit_amount'] - $result['debit_amount'],2,'.','');
                 }
                 $tbalance = $balance<0 ? "(".number_format(-1*$balance,2,'.','').")":$balance;
                 $p_balance = $balance;
                 $detail_array['ledger_detail'][] = array(
                        'id' => '0',
                        'reg_id' => '',
                        'ent_date'=>date($this->language->get('date_format_short'),strtotime('-1 day', strtotime($data['start_date']))),
                        'particular' => 'Opening Balance',
                        'code' => '',
                        'other_amount'       => '',
                        'other_code'       => '',
                        'currency_rate'  => '', 
                        'debit' => number_format($result['debit'],2,'.',''),
                        'credit' => number_format($result['credit'],2,'.',''),
                        'balance'=> $tbalance
                    );
             }
             
            $sql = "SELECT cx.code,aj.*  FROM " . DB_PREFIX . "account_journal aj
                    LEFT JOIN " . DB_PREFIX . "currencyexchange cx ON (aj.currency_id = cx.currency_id) 
                    WHERE aj.acc_id='".$acc_id."' AND aj.show_entry=1 AND aj.entry_date>='". $data['start_date'] ."' AND aj.entry_date < '". $data['end_date'] ."' + interval 1 day ORDER BY aj.entry_date ASC";
            $query = $this->db->query($sql);
            $results = $query->rows;
             
            
            
            foreach ($results as $result) {
                $other_details = $this->getParticulars($result['journal_id'], $result['ref_id'],$result);
                 
                $j_amount = $result['journal_amount']*$result['currency_rate'];
                $debit = $j_amount > 0 ?$j_amount:0;
                $credit = $j_amount < 0 ? $j_amount:0;
                
                if($acc_type!=2){
                     $balance = $p_balance + $j_amount;
                 }
                 else{
                     $balance = $p_balance + (-1*$$j_amount);
                 }
                 if($other_details['journal_amount']=='*'){
                    $other_amount = $other_details['journal_amount'];
                 }
                 else{
                     $other_amount = $other_details['journal_amount'] <0 ? number_format($other_details['journal_amount']*-1,2,'.',''):"(".number_format($other_details['journal_amount'],2,'.','').")";
                 }
                 
                 $tbalance = $balance<0 ? "(".number_format(-1*$balance,2,'.','').")":number_format($balance,2,'.','');
                 $p_balance = $balance;
                 $last_date = $result['entry_date'];
                
               
                $detail_array['ledger_detail'][] = array(
                        'id' 		=>  $result['journal_id'],
                        'reg_id'        =>  $this->getRegisterNo('REG',$result['journal_id']),
                        'ent_date'      =>  date($this->language->get('date_format_short'),strtotime($result['entry_date'])),
                        'particular'    =>  $this->generateParticulars($result,$other_details),
                        'code'          =>  $result['code']==$other_details['code']?$result['code']:$other_details['code'],
                        'other_amount'  =>   $other_amount,
                        'other_code'       => $other_details['code'],
                        'currency_rate'  => number_format(($result['currency_id']==2)?$other_details['currency_rate']:$result['currency_rate'],2,'.',''), 
                        'debit' => number_format($debit,2,'.',''),
                        'credit' => number_format(-1*$credit,2,'.',''),
                        'balance'=> $tbalance
                    );
            }
            
            $detail_array['ledger_detail'][] = array(
                      'id' => '2000000',
                      'reg_id' => '',
                      'ent_date'=>date($this->language->get('date_format_short'),strtotime('0 day', strtotime($last_date))),
                      'particular' => 'Closing Balance',
                      'code' => '',
                      'other_amount'       => '',
                      'other_code'       => '',
                      'currency_rate'  => '', 
                      'debit' => '',
                      'credit' => '',
                      'balance'=> $tbalance
                  );
            
            return $detail_array;
        }
        
        public function generateParticulars($data,$other){
            $particular_str = '';
            if($data['inv_id']>0){
                $details = ($data['currency_id']==2)?$data['journal_details']:$other['journal_details'];
                $particular_str = $this->getRegisterNo('INV',$data['inv_id']) ." (". $details .")" ;
                
            }
            else if($data['amanat_id']>0){
                $particular_str .= $data['journal_details'];
            }
            else{
                $particular_str = $other['journal_amount'];
                if(!empty($other['journal_details'])){
                    $particular_str .= ' ('.$other['journal_details'].')';
                }
                
            }
            
            return $particular_str;
        }
        
        public function getParticulars($journal_id,$ref_id,$data){
           $other_details = array();
               $sql = "SELECT aj.journal_details,aj.acc_id,ac.acc_name,aj.journal_amount,aj.currency_id,cx.code,count(*) as total_rows,aj.currency_rate   FROM " . DB_PREFIX . "account_journal aj
                        LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id) 
                        LEFT JOIN " . DB_PREFIX . "currencyexchange cx ON (aj.currency_id = cx.currency_id)     
                        WHERE aj.journal_id!='".$journal_id."' AND aj.show_entry=1 AND aj.ref_id='".$ref_id."'"; 
               $query = $this->db->query($sql);
               $other_details = $query->row;
            if($data['currency_id']!=2){   
                $other_details['journal_amount'] = -1*$data['journal_amount'];
                $other_details['code'] = $data['code'];
            }
            else{
                $other_details['code'] =  $other_details['code'];
                $other_details['journal_amount'] =  $other_details['journal_amount'];
                
            }
           return $other_details;
           
        }
        
        private function getRegisterNo($str,$reg_id){
            $custom_no = '';
            if($reg_id>0){
                $reg_id = str_pad($reg_id, 8, "0", STR_PAD_LEFT);
                $custom_no =$str.$reg_id;
            }
            return $custom_no;
        }
}

?>