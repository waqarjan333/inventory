<?php
class ModelReportsReportsAccounts extends Model {

	
        public function get_assets($data){
            $date_range = "";           
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range = " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
           
            $sql = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name, acc.acc_type_id as type_id  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )
                    LEFT JOIN " . DB_PREFIX . "account_heads acc_head ON ( acc_head.acc_head_id = acc_type.head_id )
                    WHERE acc_head.acc_head_id='1' ".$date_range." 
                    GROUP BY acc.acc_id";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
        }
        
        
        
         public function get_liabilities($data){
            $date_range = "";           
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range = " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
           
            $sql = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name, acc.acc_type_id as type_id  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )
                    LEFT JOIN " . DB_PREFIX . "account_heads acc_head ON ( acc_head.acc_head_id = acc_type.head_id )
                    WHERE acc_head.acc_head_id='2'  ".$date_range." 
                    GROUP BY acc.acc_id    
                    ";
            // echo $sql;exit;
            $query = $this->db->query($sql);            
            return $query->rows;
        }
        
        public function get_equity($data){
            $date_range = "";           
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range = " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
           
            $sql = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )
                    LEFT JOIN " . DB_PREFIX . "account_heads acc_head ON ( acc_head.acc_head_id = acc_type.head_id )
                    WHERE acc_head.acc_head_id='3' ".$date_range." 
                    GROUP BY acc.acc_id    
                    ";
            
            $query = $this->db->query($sql);            
            return $query->rows;
        }
        
        public function get_netIcome($data){            
            $date_range = "";           
            if( isset($data["end_date"]) ){
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range = " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            
          $query_income = $this->db->query("SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='4' ".$date_range."");  
            $query_expense = $this->db->query("SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='5' ".$date_range."");  
            
            $query_cogs = $this->db->query("SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='7' ".$date_range."");  
                      
                        
            $cogs = $query_cogs->row['amount'] ==NULL?0:  $query_cogs->row['amount']; 
            $income =  $query_income->row['amount'] ==NULL?0:  $query_income->row['amount']; 
            $expenses = $query_expense->row['amount']==NULL?0:$query_expense->row['amount'];
            $salereturn = 0;//$this->get_netSalereturn($data);

            // var_dump($query_income;exit;
            return $income + $expenses + $cogs + $salereturn;
            
        }
            public function getTrail($data) {
            $date_range = "";
            $sql = "SELECT at.acc_type_id,at.acc_type_name,ah.acc_head_title,ac.* FROM " . DB_PREFIX . "account_chart ac
                    LEFT JOIN " . DB_PREFIX . "account_type at ON (ac.acc_type_id = at.acc_type_id) 
                    LEFT JOIN " . DB_PREFIX . "account_heads ah ON (ah.acc_head_id = at.head_id) 
                    WHERE ac.acc_type<51 ORDER BY at.head_id ASC
                "; 
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
                    WHERE acc_id='".$id."' AND show_entry=1 AND type !='PO_RET_A' and journal_amount".$flag."0
                ".$date_range; 
                // echo $sql;exit;
            $query = $this->db->query($sql);
            $sum = $query->row;
            return $sum;
            
        }
        public function getSaleReturnValue($id)
        {
            $query = $this->db->query("SELECT SUM(journal_amount*currency_rate) as sum FROM " . DB_PREFIX . "account_journal WHERE acc_id='".$id."'");
            return $query->row['sum']==NULL?0:$query->row['sum'];
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
        
        public function get_income($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date >= '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum( j.journal_amount)*-1 
                    AS amount, acc.acc_name as account_name
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='4' and acc.acc_id!=8 ".$date_range." group by acc.acc_id";
             $query_income = $this->db->query($query);  
             // echo $query;  exit;           
             return $query_income->rows;            
        }
        
         public function get_salereturn($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = "SELECT sum( j.journal_amount) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='4' and acc.acc_type='1' ".$date_range." group by acc.acc_id";
            
             
             $query_income = $this->db->query($query);  
               
             return $query_income->rows;            
        }
        

         public function get_oincome($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date >= '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Purchase Discount' && acc_description='{{PURCHASE_DISCOUNT_INCOME_ACCOUNT_SYSTEM}}'");
            $purchase_discount = $query->row['acc_id'];
              
            $query = "SELECT sum( j.journal_amount)*-1 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc.acc_id='".$purchase_discount."' ".$date_range." group by acc.acc_id";
                         
             $query_income = $this->db->query($query);                 
             return $query_income->rows;            
        }
                
        
        public function get_expense($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date >= '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            
            $query = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name, acc.acc_id as account_id  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='5' and acc.acc_id !=9  ".$date_range." group by acc.acc_id";
            
            $query_income = $this->db->query($query);  
            return $query_income->rows;
        }
        
        public function get_cogs($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            
            $query = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='7' and j.type in ('S','POS','PO_RET_A') ".$date_range." group by acc.acc_id";
            // echo $query;exit;
            $query_income = $this->db->query($query);  
            return $query_income->rows;
        }
        
        public function get_cogs_return($data){
            $date_range = "";           
            if( isset($data["start_date"]) &&  isset($data["end_date"])){
                if(!empty($data["start_date"])){                   
                    $start_date = $data["start_date"];
                    $date_range .= "AND j.entry_date > '". $start_date ."' ";
                }                
                if(!empty($data["end_date"])){                   
                    $end_date = $data["end_date"];
                    $date_range .= " AND j.entry_date < '". $end_date ."' + interval 1 day";
                }
            }
            
            $query = "SELECT sum( j.journal_amount ) 
                    AS amount, acc.acc_name as account_name  
                    FROM ". DB_PREFIX . "account_journal AS j
                    LEFT JOIN " . DB_PREFIX . "account_chart acc ON ( acc.acc_id = j.acc_id )
                    LEFT JOIN " . DB_PREFIX . "account_type acc_type ON ( acc_type.acc_type_id = acc.acc_type_id )                    
                    WHERE acc_type.acc_type_id='7' and j.type in ('SALE_RET','POS_RET') ".$date_range." group by acc.acc_id";
            
            $query_income = $this->db->query($query);  
            return $query_income->rows;
        }
        
        
}
?>
