<?php
class ModelDashboardAccount extends Model{
        public function saveupdateAccount($data){
            $result=str_replace("&amp;", '&', $data["acc_name"]); 
              $name=str_replace("&quot;", '"', $result);
              $obalance = isset($data["acc_obalance"])?"opening_balance = '".$data["acc_obalance"]."',":"";
              $o_balance = isset($data["acc_obalance"])?"balance = '".$data["acc_obalance"]."',":"";
          if($data['account_id']==0){
              $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                        acc_name = '".$name."',
                        acc_description = '".$data["acc_description"]."',
                        acc_type_id = '".$data["acc_type_id"]."',
                       ".$obalance."        
                        ".$o_balance."
                        acc_status='".$data["acc_status"]."',
                        last_changed=NOW() 
                        "); 
              $last_id = $this->db->getLastId();
              //Set opening balance for account
              $this->setOpeningBalance($data,$last_id);              
              if($data["acc_type_id"]==16){
                  $this->db->query("INSERT INTO " . DB_PREFIX . "credit_card_merchant SET acc_id='".$last_id."', percentage='".$data["percentage"]."', fromto  = '".$data["per_to_from"]."'"); 
              }
          }
          else{              
              $this->db->query("UPDATE " . DB_PREFIX . "account_chart SET 
                        acc_name = '".$name."',
                        acc_description = '".$data["acc_description"]."',
                        acc_type_id = '".$data["acc_type_id"]."',
                        ".$obalance."                        
                        acc_status='".$data["acc_status"]."',
                        last_changed=NOW() 
                        WHERE acc_id='".$data['account_id']."'
                      "); 
              
              if($data["acc_type_id"]==16){
                  $this->db->query("UPDATE " . DB_PREFIX . "credit_card_merchant SET percentage='".$data["percentage"]."', fromto  = '".$data["per_to_from"]."' WHERE acc_id='".$data['account_id']."'"); 
              }
              else if($data['acc_type_id']==14)
              {
                $this->db->query("DELETE FROM " . DB_PREFIX . "customer  WHERE cust_acc_id='".$data['account_id']."'");
                $sql="SELECT * FROM account_journal WHERE acc_id='".$data['account_id']."' AND type='CUST_OB'";

                 $query = $this->db->query($sql);
                 $num=$query->num_row;
                 if($num>0)
                 {
                  $ref_id=$query->row['ref_id'];
                  $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal  WHERE ref_id='".$ref_id."'");
                  $total_asset = $data["acc_obalance"];  
                             // Receivable Loans
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['account_id']."', journal_amount='".$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()");

                 }
                 
              }
             $last_id = $this->db->getLastId();
          }
          return $last_id;
        }
        private function setOpeningBalance($data,$last_id){
             $result=str_replace("&amp;", '&', $data["acc_name"]); 
              $name=str_replace("&quot;", '"', $result);
            if(isset($data["acc_obalance"]) && $data["acc_obalance"]!=0){
                //Bank 
                $total_asset = $data["acc_obalance"];    
                if($data["acc_type_id"]==8){                            
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".$total_asset."', journal_details  = 'Bank Opening Balance',inv_id= '0',currency_rate='1',currency_id='1',type='BANK', entry_date ='".$data['entry_date']."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Bank Opening Balance',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='BANK', entry_date ='".$data['entry_date']."'"); 
                 }                 
                 else if($data["acc_type_id"]==1){
                     //Customer
                     $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
                     $last_journal_id = (int)$this->db->getLastId();  
                     $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                     $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='0',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
                    
                    //if(isset($data["set_as_vend_cust"]) && $data["set_as_vend_cust"]==1){ 
                        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET 
                            cust_name = '".$name."',
                            cust_group_id = '1',
                            cust_type_id = '1',
                            cust_acc_id = '".$last_id."',
                            cust_ct_name = '',
                            cust_phone = '',
                            cust_mobile = '',
                            cust_email = '',
                            cust_credit_limit = '0',    
                            cust_fax = '',
                            cust_address = '',
                            cust_price_level = '0'    
                         "); 
                    //}
                 }
                 else if($data["acc_type_id"]==2){
                     //Vendor
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()");                     
                        
                        $this->db->query("INSERT INTO " . DB_PREFIX . "vendor SET 
                            vendor_name = '".$name."',
                            vendor_acc_id = '".$last_id."',
                            vendor_ct_name = '',
                            vendor_phone = '',
                            vendor_mobile = '',
                            vendor_email = '',
                            vendor_fax = '',
                            vendor_address = ''
                        "); 
                 }
                 else if($data["acc_type_id"]==5){
                        //Expenses
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='-1', journal_amount='".$total_asset."', journal_details  = 'Expense Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='EXPENSE', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Expense Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='EXPENSE', entry_date =NOW()");                     
                 }
                 else if($data["acc_type_id"]==10){
                        //Other Expenses
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='-1', journal_amount='".$total_asset."', journal_details  = 'Other Expense Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='OEXPENSE', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Other Expense Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='OEXPENSE', entry_date =NOW()");                     
                 }
                 else if($data["acc_type_id"]==14){   
                        // Receivable Loans
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()");                     
                }
                else if($data["acc_type_id"]==15 || $data["acc_type_id"]==6){                    
                        // Payable Loans , Loans
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'A / P Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='VENDOR_PAY', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".-1*$total_asset."', journal_details  = 'A / P Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='VENDOR_PAY', entry_date =NOW()");                     
                }
                 else if($data["acc_type_id"]==17){   
                        //Loans
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$last_id."', journal_amount='".$total_asset."', journal_details  = 'Credit Card Opening Balance',inv_id= '0',currency_rate='1',currency_id='1',type='CREDIT', entry_date ='".$data['entry_date']."'"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Credit Card Opening Balance',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='CREDIT', entry_date ='".$data['entry_date']."'");
                }
                 
            }
        }
         public function checkNameExists($data){
             $result=str_replace("&amp;", '&', $data["acc_name"]); 
              $name=str_replace("&quot;", '"', $result);
            $condition = '';
            if($data['account_id']!=0){
                $condition = "AND acc_id!=".$data['account_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."account_chart
                        WHERE acc_name='".$name."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        
        public function getAccounts($data){
                if(!isset($data['search'])){
		$sql = "SELECT * FROM ".DB_PREFIX."account_chart ac
                        LEFT JOIN ".DB_PREFIX."account_type at ON (at.acc_type_id = ac.acc_type_id)                        
                        LEFT JOIN ".DB_PREFIX."account_heads ah ON (ah.acc_head_id = at.head_id)                        
        		WHERE acc_type=0";    
                }
                else{
                   $sql = "SELECT * FROM ".DB_PREFIX."account_chart ac
                        LEFT JOIN ".DB_PREFIX."account_type at ON (at.acc_type_id = ac.acc_type_id)
        		WHERE acc_type=0 && acc_name like '".$data['search']."%'";     
                }

                // echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}
        public function getIncomeAccounts($data){
		$sql = "SELECT * FROM ".DB_PREFIX."account_chart ac
                        LEFT JOIN ".DB_PREFIX."account_type at ON (at.acc_type_id = ac.acc_type_id)                        
                        LEFT JOIN ".DB_PREFIX."account_heads ah ON (ah.acc_head_id = at.head_id)";    
                
		$query = $this->db->query($sql);
		return $query->rows;
	}
        
        public function getAccountTypes($flag){
                if($flag!='all'){
                $sql = "SELECT * FROM ".DB_PREFIX."account_type 
                        WHERE acc_type_status=1";    
                }
                else{
                    $sql = "SELECT * FROM ".DB_PREFIX."account_type";    
                }
		$query = $this->db->query($sql);
		return $query->rows;
	}
        public function getAccountHeads(){
                $sql = "SELECT * FROM ".DB_PREFIX."account_heads";    
      		$query = $this->db->query($sql);
		return $query->rows;
	}
        public function deleteAccount($id){
		$sql = "DELETE FROM ".DB_PREFIX."account_chart 
        		WHERE acc_id='".$id."'";    
		$query = $this->db->query($sql);
	}
        public function deactivateAccount($id){
		$sql = "UPDATE ".DB_PREFIX."account_chart SET 
                        acc_status=0
        		WHERE acc_id='".$id."'";    
		$query = $this->db->query($sql);
	}
        
        public function getInvoiceDetails($inc_id){
		$sql = "SELECT * FROM ".DB_PREFIX."currenxyx_invoice_details cid
                        LEFT JOIN ".DB_PREFIX."currencyexchange curx ON (curx.currency_id = cid.currency_id)
                        WHERE cid.invoice_id='".$inc_id."'
        		";
                $query = $this->db->query($sql);
		return $query->rows;
	}
        public function saveupdatetypes($data){
            if(empty($data["id"])){
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_type SET 
                    acc_type_name = '".$data["name"]."',
                    acc_type_status='".$data["status"]."',
                    head_id='".$data["head"]."'    
             "); 
            }
            else{
               $this->db->query("UPDATE " . DB_PREFIX . "account_type SET 
                    acc_type_name = '".$data["name"]."',
                    acc_type_status='".$data["status"]."',
                    head_id='".$data["head"]."' 
                    WHERE acc_type_id='".$data["id"]."'
             "); 
            }
        }        
       public function deleteType($id){
		$sql = "DELETE FROM ".DB_PREFIX."account_type 
        		WHERE acc_type_id='".$id."'";    
		$query = $this->db->query($sql);
	}
        
        public function getCreditMerchantAccount($id){
                $sql = "SELECT * FROM ".DB_PREFIX."credit_card_merchant where acc_id='".$id."'";    
      		$query = $this->db->query($sql);
		return $query->row;
	}
        
}
?>

