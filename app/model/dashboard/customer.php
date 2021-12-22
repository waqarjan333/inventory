<?php
class ModelDashboardCustomer extends Model{
        public function saveCustomer($data){
          $price_level = (!isset($data["cust_price_level"]) || empty($data["cust_price_level"]))?0:$data["cust_price_level"];  
          $cust_ct_name = isset($data["cust_ct_name"])?$data["cust_ct_name"]:NULL;  
          $cust_phone = isset($data["cust_phone"])?$data["cust_phone"]:NULL;  
          $cust_mobile = isset($data["cust_mobile"])?$data["cust_mobile"]:NULL;
          $cust_email = isset($data["cust_email"])?$data["cust_email"]:NULL;
          $cust_fax = isset($data["cust_fax"])?$data["cust_fax"]:NULL;
          $cust_address = isset($data["cust_address"])?$data["cust_address"]:NULL;
          $cust_cnic = isset($data["cust_cnic"])?$data["cust_cnic"]:NULL;
          $cust_credit_limit = isset($data["cust_credit_limit"])?$data["cust_credit_limit"]:0;
          $result=str_replace("&amp;", '&', $data["cust_name"]); 
          $order_no=isset($data["cust_display_no"])?$data["cust_display_no"]:0;
          $name=str_replace("&quot;", '"', $result);
          $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET 
                    cust_name = '".$name."',
                    cust_group_id = '".$data["cust_group_name"]."',
                    cust_type_id = '".$data["cust_type_name"]."',
                    cust_ct_name = '".$cust_ct_name."',
                    cust_phone = '".$cust_phone."',
                    cust_mobile = '".$cust_mobile."',
                    cust_email = '".$cust_email."',
                    cust_cnic = '".$cust_cnic."',
                    cust_credit_limit = '".$cust_credit_limit."',    
                    cust_fax = '".$cust_fax."',
                    cust_address = '".$cust_address."',
                    cust_price_level = '".$price_level."',    
                    order_no = '".$order_no."'    
                    "); 
                 $customer_id = $this->db->getLastId();
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'CUST_".$name."(C)',
                    acc_description = '".$cust_ct_name."',
                    acc_type_id = '1',
                    opening_balance = '".$data["cust_obalance"]."',
                    balance = '".$data["cust_obalance"]."',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
                
                $account_id = $this->db->getLastId();
                if(isset($account_id)){
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET 
                        cust_acc_id = '".$account_id."'
                        WHERE cust_id = '". $customer_id ."'
                    "); 
                }
             
             if($data["cust_obalance"]!=0){
              $date=date('Y-m-d H:i:s');
                $total_asset = $data["cust_obalance"];            
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',item_id='".$customer_id."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date ='".$date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$customer_id."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date ='".$date."'"); 
              }      
             return $customer_id;
        }
        
        public function updateCustomer($data){
         $price_level = (!isset($data["cust_price_level"]) || empty($data["cust_price_level"]))?0:$data["cust_price_level"];  
         $cust_ct_name = isset($data["cust_ct_name"])?$data["cust_ct_name"]:NULL; 
         $cust_acc_id = isset($data["cust_acc_id"])?$data["cust_acc_id"]:NULL;  
          $cust_phone = isset($data["cust_phone"])?$data["cust_phone"]:NULL;  
          $cust_mobile = isset($data["cust_mobile"])?$data["cust_mobile"]:NULL;
          $cust_email = isset($data["cust_email"])?$data["cust_email"]:NULL;
          $cust_fax = isset($data["cust_fax"])?$data["cust_fax"]:NULL;
          $cust_address = isset($data["cust_address"])?$data["cust_address"]:NULL;
          $cust_cnic = isset($data["cust_cnic"])?$data["cust_cnic"]:NULL;
          $cust_credit_limit = isset($data["cust_credit_limit"])?$data["cust_credit_limit"]:0;
          $order_no=isset($data["cust_display_no"])?$data["cust_display_no"]:0;
          $result=str_replace("&amp;", '&', $data["cust_name"]); 
          $name=str_replace("&quot;", '"', $result);
          $this->db->query("UPDATE " . DB_PREFIX . "customer SET 
                    cust_name = '".$name."',
                    cust_type_id = '".$data["cust_type_name"]."',    
                    cust_group_id = '".$data["cust_group_name"]."',    
                    cust_ct_name = '".$cust_ct_name."',
                    cust_phone = '".$cust_phone."',
                    cust_mobile = '".$cust_mobile."',
                    cust_credit_limit = '".$cust_credit_limit."',    
                    cust_email = '".$cust_email."',
                    cust_fax = '".$cust_fax."',
                    cust_address = '".$cust_address."',
                    cust_cnic = '".$cust_cnic."',
                    cust_price_level = '".$price_level."',     
                    order_no = '".$order_no."'    
                    WHERE cust_id= '". $data["cust_hidden_id"] ."'
                    ");   
                     $this->db->query("UPDATE " . DB_PREFIX . "account_chart SET 
                    acc_name = 'CUST_".$name."(C)',    
                    opening_balance = '".$data["cust_obalance"]."',
                    balance = '".$data["cust_obalance"]."'  
                    WHERE acc_id= '".$data["cust_acc_id"]."'
                    ");   
                
                $account_id = $data['cust_acc_id'];
              $sql="SELECT journal_id FROM account_journal WHERE acc_id='".$account_id."' AND type='CUST_OB'";
               $query = $this->db->query($sql);
            $result = $query->num_rows;
              if($result==0)
              {
                $date=date('Y-m-d H:i:s');
                 $total_asset = $data["cust_obalance"]; 
                 $customer_id = $data["cust_hidden_id"]; 
                 if($total_asset !=0)
                 {
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',item_id='".$customer_id."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date ='".$date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$customer_id."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date ='".$date."'"); 
                 }
                 
              }
              else{
                 if($data["cust_obalance"]!=0 || $data["cust_obalance"]!=''){
                $total_asset = $data["cust_obalance"];            
                $this->db->query("UPDATE  " . DB_PREFIX . "account_journal SET journal_amount='".$total_asset."' WHERE acc_id='".$account_id."' AND type='CUST_OB'"); 

                $sql="SELECT journal_id FROM account_journal WHERE acc_id='".$account_id."' AND type='CUST_OB'";
                 $query = $this->db->query($sql);
                $last_journal_id = $query->row['journal_id'];
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='".-1*$total_asset."' WHERE acc_id='8' AND ref_id='".$last_journal_id."' AND type='CUST_OB'"); 
              }   
              }

              
             return $data["cust_hidden_id"]; 

        }
        public function checkNameExists($data){
            $result=str_replace("&amp;", '&', $data["cust_name"]); 
          $name=str_replace("&quot;", '"', $result);
            $condition = '';
            if($data['cust_hidden_id']!=-1){
                $condition = "AND cust_id!=".$data['cust_hidden_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."customer
                        WHERE cust_name='".$name."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        public function getCustomers($data,$flag){
                $search_string = '';
                $appendWalkInCustomer = '';
                if(isset($data['search'])){
                    // $search_string = " WHERE ";
                    $search_string .= "AND cust_name like '%".$data['search_name']."%' ";
                    $search_string .= "AND cust_phone like '%".$data['search_contact']."%' ";
                    $search_string .= "AND cust_mobile like '%".$data['search_mobile']."%'";
                 
                }
                if(isset($data['fororder']) || $flag==1){

                    $appendWalkInCustomer .= "1 ";

                }
                else{
                    $appendWalkInCustomer .= "cust_id !=0 Order by cust_name ASC";
                }
              // echo $appendWalkInCustomer;exit;
		$sql = "SELECT * FROM ".DB_PREFIX."customer c
                        LEFT JOIN ".DB_PREFIX."customer_groups cg ON (cg.id = c.cust_group_id)
                        LEFT JOIN ".DB_PREFIX."customer_types ct ON (ct.id = c.cust_type_id)    
                         WHERE " .$appendWalkInCustomer
                        .$search_string;
                
                 // echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}
        public function getCustomer($data){
                
		$sql = "SELECT c.*, ac.balance as cust_balance FROM ".DB_PREFIX."customer c
                        LEFT JOIN ".DB_PREFIX."account_chart ac ON (ac.acc_id = c.cust_acc_id)
                        WHERE c.cust_id = '".$data["cust_id"]."'";    
              
		$query = $this->db->query($sql);
		return $query->row;
	}

  public function getCustomerRegister($id)
  {
    $sql="SELECT ac.acc_name,sum(aj.journal_amount) as pre_total,cus.cust_name FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "customer cus ON (cus.cust_acc_id = aj.acc_id)
                WHERE aj.acc_id=".$id."";
                   $query = $this->db->query($sql);
            if($query->row['pre_total']==NULL || $query->row['pre_total']<=0)
            {
               return $total="0";
            } 
            else{
                return $query->row['pre_total'];
            }     
  }
        
        public function getCustomerOB($id)
        {
          $sql="SELECT COUNT(journal_id),journal_amount FROM account_journal WHERE acc_id=".$id." AND type='CUST_OB'";
          $query = $this->db->query($sql);
           $qty = $query->row['journal_amount']==NULL ? '0' :$query->row['journal_amount'];    
        }

          public function getRegionCustomer($data){
            $sql = "";
                if($data["region_id"]=='-1'){
                   $sql = "SELECT c.*, ac.balance as cust_balance FROM ".DB_PREFIX."customer c
                        LEFT JOIN ".DB_PREFIX."account_chart ac ON (ac.acc_id = c.cust_acc_id)
                        WHERE c.cust_id > '-1' ";
                } else {
    $sql = "SELECT c.*, ac.balance as cust_balance FROM ".DB_PREFIX."customer c
                        LEFT JOIN ".DB_PREFIX."account_chart ac ON (ac.acc_id = c.cust_acc_id)
                        WHERE c.cust_group_id = '".$data["region_id"]."'";    
                }
    // echo $sql;exit;                
    $query = $this->db->query($sql);
    return $query->rows;
  }
        
        public function changeState($data){
            $r = $data["_state"];
            try{
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET 
                    cust_status = '".$data["_state"]."' 
                    WHERE cust_id='".$data["_id"]."'"); 
            }
            catch(Exception $e){
              $r = '$e->getMessage()';  
            }
            return $r;
	}
        public function getCustomerAddress($data){
            $sql = "Select cust_address,cust_mobile,cust_email,cust_phone,cust_fax,cust_price_level from " . DB_PREFIX . "customer where cust_id='".$data['cust_id']."'";
            $query = $this->db->query($sql);
            return $query->row;
        }
        
        public function getPriceLevel($id){
            date_default_timezone_set("Asia/Karachi");
            $date = date('Y-m-d');
            $sql = "Select * from " . DB_PREFIX . "price_level where level_id='".$id."'";
            $query = $this->db->query($sql);
            if($query->num_rows > 0){
                if($date >= $query->row['level_from_date']){
                    if($query->row['level_to_date'] == Null || $date <= $query->row['level_to_date']){
                        $result = $query->row;
                        return $result;
                    }
                }
            }
            return false;
        }
        
        public function getItems($id){
            $sql = "SELECT item_id,item_per_level FROM ".DB_PREFIX."price_level_per_item
        		WHERE l_id = '".$id."'";   
            $query = $this->db->query($sql);
            return $query->rows;
        }
         public function getAccounts(){
                
                   $sql = "SELECT * FROM ".DB_PREFIX."account_chart ac
                        LEFT JOIN ".DB_PREFIX."account_type at ON (at.acc_type_id = ac.acc_type_id)
        		WHERE acc_type=0";     
                
		$query = $this->db->query($sql);
		return $query->rows;
	}
        public function getEstimateCount($data){
             $sql = "SELECT count(*) as est_count FROM ".DB_PREFIX."pos_invoice                        
                        WHERE invoice_type='5' AND cust_id = '".$data['cust_id']."'
        		";
            $query = $this->db->query($sql);
            return  $query->row['est_count'] ==NULL?0:  $query->row['est_count'];
        }
        
}
?>
