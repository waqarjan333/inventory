<?php
class ModelAccountRegister extends Model {
	public function addEntry($data) { 
            $debit_cur_rate = 1;
            $credit_cur_rate = 1;
            $debit_cur_id = '0';
            $credit_cur_id = '0';
                                                    
            $credit_cur_id = '0';
            $amount_credit = -1*$data["credit_amount"];   
            $amount_debit = $data["debit_amount"];
            $credit_account_id = $data['acc_1'];
            
                       
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['acc_0']."', journal_amount='".$amount_debit."', journal_details  = '" . $data['desc'] . "',inv_id= '0',currency_rate='".$debit_cur_rate."',currency_id='".$debit_cur_id."', entry_date ='".$data['entry_date']."'"); 
            $last_id = (int)$this->db->getLastId();  
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_id."' WHERE journal_id='".$last_id."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$credit_account_id."', journal_amount='".$amount_credit."', journal_details  = '" . $data['desc'] . "',inv_id= '0',ref_id='".$last_id."',currency_rate='".$credit_cur_rate."',currency_id='".$credit_cur_id."', entry_date ='".$data['entry_date']."'"); 
            
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
        public function getPreviousRow1($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
        }
	public function getRegisterList1($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            }                                  
            $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range." ORDER BY aj.journal_id ASC"; 
              // echo $sql;exit;              
            $query = $this->db->query($sql);
            $results = $query->rows;
            $register_accounts = array();
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.ref_id=".$result['ref_id'];
                 
                 $query = $this->db->query($sql);                 
                 $aresult = $query->row;
                 if($query->num_rows > 0){
                 $register_accounts[] = array(
                        'journal_id'             => $aresult['journal_id'],
                        'acc_name'             => $result['acc_name'],
                        'o_acc_name'             => $aresult['acc_name'],
                        'ref_id'                  => $result['ref_id'],
                        'num'                  => $result['inv_id']*-1,
                        'description'            => $aresult['journal_details'],
                        'acc_id'             => $aresult['acc_id'],
                        'details'             => $result['journal_details'],
                        'journal_type'             => $result['type'],    
                        'entry_date'                  => $result['entry_date'],                        
                        'journal_amount'                => $result['journal_amount']
                    );
                }
             }
            return $register_accounts;
	}
        public function getPreviousRow2($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,cus.cust_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range; 
            //echo $sql;
            $query = $this->db->query($sql);
            return $query->row;        
        }
        public function getCustomerPrevious($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT sum(aj.journal_amount) as pre_total FROM " . DB_PREFIX . "account_journal aj     
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
        }

            public function getRegisterListForSaleInvoice($data)
            {
                 $date_range =  $start_date = "";$last="";
           
             if(isset($data["end_date"]) && $data['end_date'] !=''){
                if(!empty($data["end_date"])){
                    $end_date = $data["end_date"];
                    $date_format=date('Y-m-d',strtotime($end_date));
                    $last = " aj.entry_date < '".$end_date."'";
                }
            }
            else{
                $date=date('Y-m-d').' 0:0:0';
                $last=" aj.entry_date <='".$date."' + interval 1 day";
            } 
               $sql="SELECT ac.acc_name,aj.*,cus.cust_name,cus.cust_mobile FROM (SELECT * FROM account_journal WHERE acc_id=".$data['account_id']." ORDER BY entry_date DESC LIMIT 250) AS aj INNER JOIN account_chart ac ON (ac.acc_id = aj.acc_id) INNER JOIN customer cus ON (cus.cust_acc_id = aj.acc_id) WHERE ".$last." ORDER BY aj.entry_date ASC,aj.journal_details DESC";

                // $sql = "SELECT ac.acc_name,aj.*,cus.cust_name,cus.cust_mobile FROM " . DB_PREFIX . "account_journal aj                 
                // LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                // LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                // WHERE aj.acc_id=".$data['account_id']." ".$last." ORDER BY aj.entry_date"; 
                          
         // 
            //echo $sql;exit;
            $query = $this->db->query($sql);
            
            $results = $query->rows;
            $register_accounts = array();            
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM  " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                    
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.ref_id=".$result['ref_id']." ORDER BY aj.journal_id ASC" ;
                 $query = $this->db->query($sql);
                 $aresult = $query->row;
                 
                 $register_accounts[] = array(
                        'journal_id'           => $aresult['journal_id'],
                        'acc_name'             => $aresult['acc_name'],
                        'acc_id'               => $aresult['acc_id'],
                        'description'          => $aresult['journal_details'],
                        'cust_name'            => $result['cust_name'],
                        'cust_mobile'          => $result['cust_mobile'],
                        'ref_id'               => $result['ref_id'],
                        'journal_type'         => $result['type'],
                        'num'                  => $result['inv_id']*-1,
                        'entry_date'           => $result['entry_date'],                        
                        'journal_amount'       => $result['journal_amount']);
             } 
            return $register_accounts;
            }

            public function getPreviousRowForSaleInvoice($data)
            {
                 $date_range = $start_date = "";$date_format="";$reg_date="";
              if(isset($data["start_date"]) && $data['end_date'] ==''){
                  $reg_date=$data['reg_date'];
                // $date_format=date('Y-m-d',strtotime($reg_date));
                 $date_range = " and aj.entry_date < '". $reg_date ."'";
              }
            elseif(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                   
                    $end_date = $data["end_date"];
                   
                         $reg_date=$data['reg_date'];
                         $date_range = " and aj.entry_date < '".$reg_date."'";
                    
                   
                }
            }   
            
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,cus.cust_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range. " Order by aj.journal_id ASC"; 
            // echo $sql;exit;
            $query = $this->db->query($sql);
            return $query->row;        
            }

             public function getRegisterList2($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            }                                  
            $this->db->query("SET SQL_BIG_SELECTS=1");
            $sql = "SELECT ac.acc_name,aj.*,cus.cust_name,cus.cust_mobile FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range." ORDER BY aj.entry_date ASC,aj.type DESC"; 
            //echo $sql;   
            $query = $this->db->query($sql);
            
            $results = $query->rows;
            $register_accounts = array();            
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                    
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.ref_id=".$result['ref_id'] ;
                 $query = $this->db->query($sql);
                 //echo $sql;         
                 $aresult = $query->row;
                 
                 $register_accounts[] = array(
                        'journal_id'             => $aresult['journal_id'],
                        'acc_name'             => $aresult['acc_name'],
                        'acc_id'             => $aresult['acc_id'],
                        'description'            => $aresult['journal_details'],
                        'cust_name'             => $result['cust_name'],
                        'cust_mobile'             => $result['cust_mobile'],
                        'ref_id'                  => $result['ref_id'],
                        'journal_type'             => $result['type'],
                        'num'                  => $result['inv_id']*-1,
                        'entry_date'                  => $result['entry_date'],                        
                        'journal_amount'                => $result['journal_amount']);
             } 
            return $register_accounts;
    }

        public function getLastDate($data)
        {
             if(isset($data["end_date"]) && $data['end_date'] !=''){
                if(!empty($data["end_date"])){
                    $end_date = $data["end_date"];
                    // $date_format=date('Y-m-d',strtotime($end_date));
                    $last = " AND entry_date <= '".$end_date."'";
                }
            }
            else{
                $date=date('Y-m-d').' 0:0:0';
                $last=" AND entry_date <='".$date."' + interval 1 day";
            } 
             $sql = "SELECT sum(journal_id),entry_date FROM " . DB_PREFIX . "account_journal 
                WHERE acc_id=".$data['account_id']."
                ".$last.""; 
                // echo $sql;exit;
                  $query = $this->db->query($sql);
                 // echo $sql;exit;         
                 return $query->row;
                 
                
        }
        public function getPreviousRow3($data){
            
            // Need to minus Discount
            
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,ven.vendor_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "vendor ven ON (ven.vendor_acc_id = aj.acc_id)    
                WHERE aj.acc_id=".$data['account_id']." and aj.type!='PO_RET_A'
                ".$date_range; 
            
            $query = $this->db->query($sql);
            return $query->row;
        }
        public function getRegisterList3($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            }                                  
            $sql = "SELECT ac.acc_name,aj.*,ven.vendor_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "vendor ven ON (ven.vendor_acc_id = aj.acc_id)    
                WHERE aj.acc_id=".$data['account_id']." and aj.type!='PO_RET_A'
                ".$date_range." ORDER BY aj.entry_date ASC"; 
            // echo $sql;exit;            
            $query = $this->db->query($sql);
            $results = $query->rows;
            $register_accounts = array();
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                    
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.type!='PO_RET_A' AND aj.ref_id=".$result['ref_id'];
                 $query = $this->db->query($sql);
                 $aresult = $query->row;
                 $amount = $result['journal_amount'];
                 if($result['type']=="P_DIS"){
                     $amount = -1 * $amount;
                 }
                 $register_accounts[] = array(
                        'journal_id'             => $aresult['journal_id'],
                        'acc_name'             => $aresult['acc_name'],
                        'acc_id'             => $aresult['acc_id'],
                        'description'            => $aresult['journal_details'],
                        'vendor_name'             => $result['vendor_name'],
                        'journal_type'             => $result['type'],
                        'ref_id'                  => $result['ref_id'],
                        'num'                  => $result['inv_id'],
                        'entry_date'                  => $result['entry_date'],                        
                        'journal_amount'                => $amount
                    );
             }
            return $register_accounts;
	}
        
        public function getPreviousRow4($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date <'". $start_date ."'";
                }
            }   
            
            $sql = "SELECT ac.acc_name,sum(aj.journal_amount) as pre_total FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)                
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range; 
            //echo $sql;
            $query = $this->db->query($sql);
            return $query->row;        
        }
	public function getRegisterList4($data) {
            $date_range = "";
            if(isset($data["start_date"]) && isset($data["end_date"]) ){
                if(!empty($data["start_date"]) && !empty($data["end_date"])){
                    $start_date = $data["start_date"];
                    $end_date = $data["end_date"];
                    $date_range = " and aj.entry_date>='". $start_date ."' AND aj.entry_date < '". $end_date ."' + interval 1 day";
                }
            }                                  
            $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                WHERE aj.acc_id=".$data['account_id']."
                ".$date_range." ORDER BY aj.entry_date,aj.journal_id ASC"; 
                        
            $query = $this->db->query($sql);
            $results = $query->rows;
            $register_accounts = array();
            foreach ($results as $result) {
                 $sql = "SELECT ac.acc_name,aj.* FROM " . DB_PREFIX . "account_journal aj                 
                    LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                    WHERE aj.acc_id!=".$result['acc_id']." AND aj.ref_id=".$result['ref_id'];
                 $query = $this->db->query($sql);
                 
                 $aresult = $query->row;
                 $register_accounts[] = array(
                        'journal_id'             => $aresult['journal_id'],
                        'acc_name'             => $result['acc_name'],
                        'ref_id'                  => $result['ref_id'],
                        'details'             => $result['journal_details'],
                        'entry_date'                  => $result['entry_date'],                        
                        'journal_amount'                => $result['journal_amount']
                    );
             }
            return $register_accounts;
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
        
        public function savePayment($data){
            $payment_date = "";                      
            list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_paid_date"]); 
            $payment_date = $yd.'-'.$md.'-'.$dd." ".$data["payment_time"];                        
            $query = $this->db->query("SELECT cust_id FROM " . DB_PREFIX . "customer WHERE cust_acc_id='".$data["R_caccount_id"]."'");
             // var_dump($query);exit;
            $journal_type = 'CUST_PAYMENT';
            $change_direction = 1;
            $chargedAccount = 6;
            if($query->num_rows){
                $cust_id =  $query->row['cust_id'];
            }
            else{
                $cust_id = 0;
                $journal_type = 'R_LOAN';
                $change_direction = -1;
                $chargedAccount = $data["payment_method"];
            }

            $total_asset = $data["paid_total"];
            if($data["payment_type"]=="1"){                
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',item_id='".$cust_id."',currency_rate='1',currency_id='1',type='".$journal_type."', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".-1*$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$cust_id."',currency_rate='1',currency_id='1',type='".$journal_type."', entry_date ='".$payment_date."'"); 
            }
            else if ($data["payment_type"]=="2"){
                $chargedAccount = $data["payment_method"];
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',item_id='".$cust_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$chargedAccount."', journal_amount='".-1*$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$cust_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$payment_date."'"); 
            }
            else if ($data["payment_type"]=="3"){
                $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Discount' && acc_description='{{DISCOUNT_ACCOUNT_SYSTEM}}'");
                $discount_account = $query->row['acc_id'];
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',item_id='".$cust_id."',currency_rate='1',currency_id='1',type='DIS', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".-1*$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$cust_id."',currency_rate='1',currency_id='1',type='DIS', entry_date ='".$payment_date."'"); 
            }
            
            $this->salesRepEntry($data,$last_journal_id);
        }
        
        public function salesRepEntry($data,$ref_id){
            if($data["salesrep_id"]){
                list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_paid_date"]); 
                $payment_date = $yd.'-'.$md.'-'.$dd." ".$data["payment_time"];
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesrep_detail SET salesrep_id='".$data["salesrep_id"]."', ref_id='".$ref_id."', type_id='".$data["type"]."', payment_type='".$data["payment_type"]."', updated_date ='".$payment_date."'"); 
            }
            // $this->salesRepEntry($data,$last_journal_id);
        }
        
        public function saveVendorPayment($data){
            $payment_date = "";                      
            list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_paid_date"]); 
            $payment_date = $yd.'-'.$md.'-'.$dd." ".$data["payment_time"];
            $query = $this->db->query("SELECT vendor_id FROM " . DB_PREFIX . "vendor WHERE vendor_acc_id='".$data["R_caccount_id"]."'");
            $change_direction = 1;            
            if($query->num_rows){                
                $vendor_id =  $query->row['vendor_id'];
            }
            else{
                $vendor_id =0;
                $change_direction = -1;
            }
            $total_asset = $data["paid_total"];    
            if($data["payment_type"]=="1"){
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".-1*$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='VENDOR_PAYMENT', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='VENDOR_PAYMENT', entry_date ='".$payment_date."'"); 
            }
            else if ($data["payment_type"]=="2"){
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='P', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".-1*$total_asset*$change_direction."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='P', entry_date ='".$payment_date."'"); 
            }  
            else if ($data["payment_type"]=="3"){
                $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Purchase Discount' && acc_description='{{PURCHASE_DISCOUNT_INCOME_ACCOUNT_SYSTEM}}'");
                $discount_account = $query->row['acc_id'];

                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".-1*$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='P_DIS', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='P_DIS', entry_date ='".$payment_date."'"); 

            }  
            $this->salesRepEntry($data,$last_journal_id);
        }
        
        public function saveExpense($data){
            $payment_date = "";                      
            list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_paid_date"]); 
            $payment_date = $yd.'-'.$md.'-'.$dd." ".$data["payment_time"];            
            $vendor_id =  $data["R_caccount_id"];
            $total_asset = $data["paid_total"];    
            if($data["payment_type"]=="1"){
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".-1*$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
            }
            else if ($data["payment_type"]=="2"){
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".-1*$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
            }
            $this->salesRepEntry($data,$last_journal_id);
            
        }
        
        public function saveBankPayment($data){
            $payment_date = "";                      
            list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_paid_date"]); 
            $payment_date = $yd.'-'.$md.'-'.$dd." ".$data["payment_time"];                        
            $total_asset = $data["paid_total"];    
            //if($data["payment_type"]=="1"){
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".-1*$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',currency_rate='1',currency_id='1',type='BANK', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='BANK', entry_date ='".$payment_date."'"); 
            /*}
            else if ($data["payment_type"]=="2"){
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["R_caccount_id"]."', journal_amount='".-1*$total_asset."', journal_details  = '".$data["payment_remarks"]."',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
            }*/
        }
        
        public function getDescriptionSO($id){
             $sql = "SELECT count(invoice_id), custom FROM " . DB_PREFIX . "pos_invoice
                    WHERE invoice_id='".$id."'"; 
                    // echo $sql;exit;
            $query = $this->db->query($sql);
            if($query->row['custom']==NULL)
            {
               return $msg="Sale Invoice total";
            } 
            else{
                return $query->row['custom'];
            }           
            
        }
        
        public function getInvoiceNo($id){
            $invoice_no = "";
            $sql = "SELECT invoice_no,invoice_type                
                FROM ". DB_PREFIX . "pos_invoice 
                WHERE  invoice_id='".$id."'";    
            
             $query = $this->db->query($sql);             
             if($query->num_rows > 0){ 
                $inv_type = $query->row['invoice_type'];
                $invoice_no_prefix = "";
                if($inv_type!=NULL){
                    if($inv_type=="2"){
                        $invoice_no_prefix = "SALE-";
                    }
                    else if($inv_type=="1"){
                        $invoice_no_prefix = "POS-";
                    }
                    else if($inv_type=="3"){
                        $invoice_no_prefix = "POS-RET-";
                    }
                    else if($inv_type=="4"){
                        $invoice_no_prefix = "SALE-RET-";
                    }
                }
                $invoice_no = $query->row['invoice_no']==NULL ? "": ($invoice_no_prefix.$query->row['invoice_no']) ;
             }
             return $invoice_no;
        }
        
        public function getPOInvoiceNo($id){    
             $invoice_no = "";
             $sql = "SELECT invoice_no,invoice_type                
                FROM ". DB_PREFIX . "po_invoice 
                WHERE  invoice_id='".$id."'";    
            
                $query = $this->db->query($sql);             
              if($query->num_rows > 0){                  
                $inv_type = $query->row['invoice_type'];
                $invoice_no_prefix = "";
                if($inv_type!=NULL){
                    if($inv_type=="1"){
                        $invoice_no_prefix = "PO-";
                    }
                    else if($inv_type=="2"){
                        $invoice_no_prefix = "PO-RET-";
                    }

                }
                $invoice_no =$query->row['invoice_no']==NULL ? "": ($invoice_no_prefix.$query->row['invoice_no']) ;
             }             
             return  $invoice_no;            
        }
        
        public function getSalesRepName($ref_id){
            $sales_rep_name = "";
            $sql = "SELECT sr_det.salesrep_id, sr.salesrep_name as salesrep_name FROM " . DB_PREFIX . "salesrep_detail  sr_det                
                LEFT JOIN " . DB_PREFIX . "salesrep sr ON (sr.id = sr_det.salesrep_id)                
                WHERE sr_det.ref_id=".$ref_id;
            //echo $sql;
            $query = $this->db->query($sql);
            if($query->num_rows){
                $sales_rep_name = " - Sales Rep ( ".$query->row['salesrep_name']." )";
            }
            return $sales_rep_name;        
            
        }
	   public function getAllRegisterRecord($data)
       {
        $date_range='';
        $date_format=date('Y-m-d',strtotime($data['to_date']));
        if(!empty($data['from_date']) && !empty($data['to_date']))
        {

            $date_range="AND entry_date >='".$data['from_date']."' AND entry_date <= '".$date_format." 0:0:0' + INTERVAL 1 DAY";            
        }
        else{
            $date_range="AND entry_date <='".$date_format." 0:0:0' + INTERVAL 1 DAY";
        }
        $sql="SELECT * FROM `account_journal` WHERE `acc_id` = ".$data['acc_id']." ".$date_range." ";
            // echo $sql;exit;
         $query = $this->db->query($sql);
            return $query->rows;
       }

       public function getAllPurchaseAmount($inv_id)
       {
    //     $array = array($inv_id);
    // foreach($array as $array_item){
    //         echo $array_item;
    //         if($array_item=='0'){
    //            unset($array_item);
    //     }
    //     echo"<pre>";
    //     print_r($array_item);
    //     echo"</pre>";
    // }
        $sql="SELECT SUM(journal_amount) AS amount FROM `account_journal` WHERE `inv_id` IN( ".$inv_id.") AND `acc_id` = 2";
        // echo $sql;exit;
         $query = $this->db->query($sql);
         $amount = $query->row['amount']==NULL?0:$query->row['amount'];
            return $amount;
       }
       public function getAllReturnPurchaseAmount($inv_id)
       {
        $sql="SELECT SUM(journal_amount) AS amount FROM `account_journal` WHERE `inv_id` IN( ".$inv_id.") AND `acc_id` = 2 AND type='SALE_RET'";
        // echo $sql;exit;
         $query = $this->db->query($sql);
         $amount = $query->row['amount']==NULL?0:$query->row['amount'];
            return $amount;
       }

      
}

?>