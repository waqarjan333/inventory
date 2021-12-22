<?php
class ModelDashboardVendor extends Model{
        public function saveVendor($data){
            
          $vendor_ct_name = isset($data["vendor_ct_name"])?$data["vendor_ct_name"]:NULL;  
          $vendor_phone = isset($data["vendor_phone"])?$data["vendor_phone"]:NULL;  
          $vendor_mobile = isset($data["vendor_mobile"])?$data["vendor_mobile"]:NULL;
          $vendor_email = isset($data["vendor_email"])?$data["vendor_email"]:NULL;
          $vendor_fax = isset($data["vendor_fax"])?$data["vendor_fax"]:NULL;
          $vendor_address = isset($data["vendor_address"])?$data["vendor_address"]:NULL;
          $result=str_replace("&amp;", '&', $data["vendor_name"]); 
          $name=str_replace("&quot;", '"', $result);
          $this->db->query("INSERT INTO " . DB_PREFIX . "vendor SET 
                    vendor_name = '".$name."',
                    vendor_ct_name = '".$vendor_ct_name."',
                    vendor_phone = '".$vendor_phone."',
                    vendor_mobile = '".$vendor_mobile."',
                    vendor_email = '".$vendor_email."',
                    vendor_fax = '".$vendor_fax."',
                    vendor_address = '".$vendor_address."'
                    "); 
                 $vendor_id = $this->db->getLastId();
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'VENDOR_".$name."(V)',
                    acc_description = '".$vendor_ct_name."',
                    acc_type_id = '2',
                    opening_balance = '".$data["vendor_obalance"]."',
                    balance = '".$data["vendor_obalance"]."',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
                $account_id = $this->db->getLastId();
                if(isset($account_id)){
                    $this->db->query("UPDATE " . DB_PREFIX . "vendor SET 
                        vendor_acc_id = '".$account_id."'
                        WHERE vendor_id = '". $vendor_id ."'
                    "); 
                }
                if($data["vendor_obalance"]!=0){
                    $total_asset = $data["vendor_obalance"];                                
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='".$vendor_id."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()");                     
                }  
             return $vendor_id;
        }
        
        public function updateVendor($data){
          $vendor_ct_name = isset($data["vendor_ct_name"])?$data["vendor_ct_name"]:NULL;
          $vendor_acc_id = isset($data["vendor_acc_id"])?$data["vendor_acc_id"]:NULL;   
          $vendor_phone = isset($data["vendor_phone"])?$data["vendor_phone"]:NULL;  
          $vendor_mobile = isset($data["vendor_mobile"])?$data["vendor_mobile"]:NULL;
          $vendor_email = isset($data["vendor_email"])?$data["vendor_email"]:NULL;
          $vendor_fax = isset($data["vendor_fax"])?$data["vendor_fax"]:NULL;
          $vendor_address = isset($data["vendor_address"])?$data["vendor_address"]:NULL; 
          $result=str_replace("&amp;", '&', $data["vendor_name"]); 
          $name=str_replace("&quot;", '"', $result);
          $this->db->query("UPDATE " . DB_PREFIX . "vendor SET 
                    vendor_name = '".$name."',
                    vendor_ct_name = '".$vendor_ct_name."',
                    vendor_phone = '".$vendor_phone."',
                    vendor_mobile = '".$vendor_mobile."',
                    vendor_email = '".$vendor_email."',
                    vendor_fax = '".$vendor_fax."',
                    vendor_address = '".$vendor_address."'
                    WHERE vendor_id= '". $data["vendor_hidden_id"] ."'
                    ");
                    $this->db->query("UPDATE " . DB_PREFIX . "account_chart SET 
                    acc_name = 'VENDOR_".$data["vendor_name"]."(V)',
                    opening_balance = '".$data["vendor_obalance"]."',
                    balance = '".$data["vendor_obalance"]."'    
                    WHERE acc_id= '".$data["vendor_acc_id"]."'
                    "); 
                
                $account_id = $data['vendor_acc_id'];
              $sql="SELECT journal_id FROM account_journal WHERE acc_id='".$account_id."' AND type='VEND_OB'";
               $query = $this->db->query($sql);
            $result = $query->num_rows;
              if($result==0)
              {
                 $total_asset = $data["vendor_obalance"]; 
                 $vendor_id = $data["vendor_hidden_id"]; 
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$vendor_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()"); 
              }
              else{
                 if($data["vendor_obalance"]!=0){
                $total_asset = $data["vendor_obalance"];            
                $this->db->query("UPDATE  " . DB_PREFIX . "account_journal SET journal_amount='".$total_asset."' WHERE acc_id='".$account_id."' AND type='VEND_OB'"); 

                $sql="SELECT journal_id FROM account_journal WHERE acc_id='".$account_id."' AND type='VEND_OB'";
                 $query = $this->db->query($sql);
                $last_journal_id = $query->row['journal_id'];
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='".-1*$total_asset."' WHERE acc_id='9' AND ref_id='".$last_journal_id."' AND type='VEND_OB'"); 
              }   
              }
              return $data["vendor_hidden_id"];      
        }
         public function checkNameExists($data){
            $condition = '';
            if(isset($data['vendor_hidden_id']) && $data['vendor_hidden_id']!=0){
                $condition = "AND vendor_id!=".$data['vendor_hidden_id'];
            }
            $sql = "SELECT * FROM ".DB_PREFIX."vendor
                        WHERE vendor_name='".$data['vendor_name']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        public function getVendors($data){
                $search_string = '';
                if(isset($data['search'])){
                    $search_string = " WHERE ";
                    $search_string .= "vendor_name like '%".$data['search_name']."%' AND ";
                    $search_string .= "vendor_phone like '%".$data['search_contact']."%' AND ";
                    $search_string .= "vendor_mobile like '%".$data['search_mobile']."%'";
                 
                }
		$sql = "SELECT * FROM vendor"
                        .$search_string." Order by vendor_name ASC";
                
                // echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}
        public function getVendor($data){
                
		$sql = "SELECT c.*, ac.balance as vendor_balance FROM ".DB_PREFIX."vendor c
                        LEFT JOIN ".DB_PREFIX."account_chart ac ON (ac.acc_id = c.vendor_acc_id)
                        WHERE c.vendor_id = '".$data["vendor_id"]."'
                        "
        		;    
              
		$query = $this->db->query($sql);
		return $query->row;
	}

  public function getVendorRegister($id)
  {
       $sql = "SELECT ac.acc_name,sum(-1*aj.journal_amount) as pre_total FROM " . DB_PREFIX . "account_journal aj                 
                LEFT JOIN " . DB_PREFIX . "account_chart ac ON (ac.acc_id = aj.acc_id)
                LEFT JOIN " . DB_PREFIX . "vendor ven ON (ven.vendor_acc_id = aj.acc_id)    
                WHERE aj.acc_id=".$id." and aj.type!='PO_RET_A' ";
                // echo $sql;exit;
                 $query = $this->db->query($sql);
            if($query->row['pre_total']==NULL)
            {
               return $total="0";
            } 
            else{
                return $query->row['pre_total'];
            }     
  }
       
          public function changeState($data){
            $r = $data["_state"];
            try{
            $this->db->query("UPDATE " . DB_PREFIX . "vendor SET 
                    vendor_status = '".$data["_state"]."' 
                    WHERE vendor_id='".$data["_id"]."'"); 
            }
            catch(Exception $e){
              $r = '$e->getMessage()';  
            }
            return $r;
	}        
         public function getAccounts(){
                
                   $sql = "SELECT * FROM ".DB_PREFIX."account_chart ac
                        LEFT JOIN ".DB_PREFIX."account_type at ON (at.acc_type_id = ac.acc_type_id)
        		WHERE acc_type=0";     
                
		$query = $this->db->query($sql);
		return $query->rows;
	}
        
}
?>
