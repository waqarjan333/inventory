<?php
class ModelFixScript extends Model {
	public function purchaseFix() {
            
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item                                  
                    "); 
            $results = $query->rows; 
            
            foreach ($results as $result) {
                //if($result['avg_cost']!=0){
                    $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice_detail SET item_purchase_price='".$result['avg_cost']."'   
                        WHERE inv_item_id = '".$result['id']."'
                    ");
               // }
            }
            
            return true;
	}
        public function fixSaleInvoices() {
            
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal WHERE acc_id =2 AND journal_amount >0"); 
            $results = $query->rows; 
            
            $count=0;
            foreach ($results as $result) { 
                $sql = $this->db->query("SELECT * 
                                FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_item_quantity >0
                                ORDER BY pos_idx ASC 
                                LIMIT 1 
                                OFFSET " . $count . "");
                $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice_detail SET item_purchase_price='".$result['journal_amount']/$sql->row['inv_item_quantity']."'  
                    WHERE pos_idx='".$sql->row['pos_idx']."'");
            $count++;  }
            
            return true;
	}
        
        public function fixSaleInvoicessubtotal() {
            
           $query = $this->db->query("SELECT inv_id, SUM(inv_item_subTotal) AS total FROM " . DB_PREFIX . "pos_invoice_detail GROUP BY inv_id"); 
           $results = $query->rows; 
            
            foreach ($results as $result) { 
              $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET invoice_total='".$result['total']."' WHERE invoice_id='".$result['inv_id']."'");
            }
            
            return true;
	}
        
        public function POSinvoiceTotalZero() {
            
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice WHERE discount=invoice_total AND invoice_name!='Sale Return'"); 
            $results = $query->rows; 
            
            foreach ($results as $result) {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE inv_id='".-1*$result['invoice_id']."' AND type='DIS'");
                
            }
            $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET discount='' WHERE discount=invoice_total AND invoice_name!='Sale Return'");
            return true;
	}
        public function POSReturninvoiceTotalZero() {
            
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice WHERE discount=invoice_total AND invoice_name='Sale Return'"); 
            $results = $query->rows; 
            
            foreach ($results as $result) {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE inv_id='".-1*$result['invoice_id']."' AND type='SALE_RET_I'");
                
            }
            $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET discount='' WHERE discount=invoice_total AND invoice_name='Sale Return'");
            return true;
	}
        public function chart_fix() {
            
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer                                  
                    where cust_id!=0"); 
            $results = $query->rows; 
            
            foreach ($results as $result) {
                if($result['cust_id']>0){
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                        acc_name = 'CUST_".$result["cust_name"]."',
                        acc_description = '',
                        acc_type_id = '1',
                        opening_balance = '0',
                        balance = '0',
                        acc_status='1',
                        last_changed=NOW() 
                    "); 
                    $account_id = $this->db->getLastId();
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET cust_acc_id='".$account_id."'   
                        WHERE cust_id = '".$result['cust_id']."'
                    ");
                }
            }
            
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendor                                  
                    "); 
            $results = $query->rows; 
            
            foreach ($results as $result) {                
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'VENDOR_".$result["vendor_name"]."',
                    acc_description = '',
                    acc_type_id = '2',
                    opening_balance = '0',
                    balance = '0',
                    acc_status='1',
                    last_changed=NOW() 
                    ");  
                    $account_id = $this->db->getLastId();
                    $this->db->query("UPDATE " . DB_PREFIX . "vendor SET vendor_acc_id='".$account_id."'   
                        WHERE vendor_id = '".$result['vendor_id']."'
                    ");
                
            }
            
            return true;
	}
	
        public function customer_fix() {
            
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_chart                                  
                    "); 
            $results = $query->rows; 
            
            foreach ($results as $result) {
                if($result['acc_id']>0){
                    $this->db->query("UPDATE " . DB_PREFIX . "account_chart SET acc_id='".($result['acc_id']+2)."'   
                        WHERE acc_name = '".$result['acc_name']."'
                    ");
                }
            }
            
            return true;
	}
        
         public function update_item($_data) {
            
            $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$_data[2].",avg_cost=".$_data[3].",normal_price=".$_data[3].",sale_price=".$_data[4]." WHERE id = ".$_data[0]);             
            
            $query = $this->db->query("SELECT ref_id FROM " . DB_PREFIX . "account_journal WHERE type='E' AND item_id=".$_data[0] );  
            if($query->row && $query->row['ref_id']){
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE type='E' AND ref_id=".$query->row['ref_id']);                
            }
            
            
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE id=".$_data[0]);                                    
            $data = $query->row;             
            $total_asset = $_data[2]*$data["normal_price"];                        
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["asset_acc"]."', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['added_date']."'"); 
            $last_journal_id = (int)$this->db->getLastId();  
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['added_date']."'"); 
            
            
            return true;
	}
        
        public function update_customer($_data) {
            
            //$this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$_data[2].",avg_cost=".$_data[3].",normal_price=".$_data[3].",sale_price=".$_data[4]." WHERE id = ".$_data[0]);             
            
            $query = $this->db->query("SELECT ref_id FROM " . DB_PREFIX . "account_journal WHERE type='CUST_OB' AND item_id=".$_data[0] );  
            if($query->row && $query->row['ref_id']){
                $query = $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE type='CUST_OB' AND ref_id=".$query->row['ref_id']);                
            }
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE cust_id=".$_data[0]);                                    
            $data = $query->row;             
            if($_data[2]!=0){                
                $total_asset =$_data[2];            
                $account_id = $data["cust_acc_id"];
                $this->db->query("UPDATE " . DB_PREFIX . "account_chart SET opening_balance=".$_data[2].",balance=".$_data[2]." WHERE acc_id = ".$account_id);             
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
           }      
            
            
            return true;
	}
        public function createupdatecustomer($_data){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE cust_id=".$_data[0]); 
            $result = $query->row;
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'CUST_".$result["cust_name"]."',
                    acc_description = '".$result["cust_name"]."',                    
                    opening_balance = '".$_data[2]."',
                    balance = '".$_data[2]."',
                    acc_type_id='1',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
            $account_id = $this->db->getLastId();
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET cust_acc_id=".$account_id." WHERE cust_id = ".$_data[0]);             
            
            if($_data[2]!=0){             
                                          
                $total_asset =$_data[2];                            
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
           }     
        }
        public function createupdatecustomerByGroupID($_data){
            $query = $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET 
                    cust_name = '".$_data[1]."'    
                    ");  
            $customer_id = $this->db->getLastId();
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'CUST_".$_data[1]."',
                    acc_description = '".$_data[1]."',                    
                    opening_balance = '".$_data[2]."',
                    balance = '".$_data[2]."',
                    acc_type_id='1',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
            $account_id = $this->db->getLastId();
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET cust_acc_id=".$account_id." WHERE cust_id = ".$customer_id);             
            if($_data[2]!=0){                
                $total_asset =$_data[2];                            
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'Customer opening balance',inv_id= '0',ref_id='".$last_journal_id."',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='CUST_OB', entry_date =NOW()"); 
           }     
        }
        public function updateCustomerAccount(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE cust_id!=0"); 
            $results = $query->rows;
            foreach ($results as $result) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                        acc_name = 'CUST_".$result["cust_name"]."',
                        acc_description = '".$result["cust_name"]."',                    
                        opening_balance = '0',
                        balance = '0',
                        acc_type_id='1',
                        acc_status='1',
                        last_changed=NOW() 
                        "); 
                $account_id = $this->db->getLastId();
                $this->db->query("UPDATE " . DB_PREFIX . "customer SET cust_acc_id=".$account_id." WHERE cust_id = ".$result["cust_id"]);  
            }
        }
        
        public function updateitems($_data){            
            $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$_data[1]." WHERE id = ".$_data[0]);                              
        }
        
         public function updateprices($_data){            
            $this->db->query("UPDATE " . DB_PREFIX . "item SET normal_price=".$_data[2].",sale_price=".$_data[3].",avg_cost=".$_data[2]." WHERE id = ".$_data[0]);                              
        }
        
        public function importDB($path){ 
            
            $file = fopen($path."_new_items.csv","r");
            $item_name_entered = "";
            $qty = 0;
            $avg_cost =0;
            $item_id = 0;
            $category_id =1; 
            $vendor_id = 0;
            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                        
                   $_data = $result;                    
                      
                      if($_data[5]!=""){
                        $sql = "SELECT id FROM ". DB_PREFIX . "category WHERE name='".$_data[5]."' ";
                        $query = $this->db->query($sql);                        
                        if($query->num_rows){
                            $category_id = $query->row['id'];
                        }
                        else{
                            $this->db->query("INSERT INTO " . DB_PREFIX . "category SET name='".$_data[5]."', parent_id= '1'");
                            $category_id = (int)$this->db->getLastId();                              
                        }
                      }
                      
                      if($_data[6]!=""){
                          $vendor = $_data[6];                
                            $vendor_name = str_replace("'","\'",$vendor);
                        $sql = "SELECT vendor_id FROM ". DB_PREFIX . "vendor WHERE vendor_name='".$vendor_name."' ";
                        $query = $this->db->query($sql);                        
                        if($query->num_rows){
                            $vendor_id = $query->row['vendor_id'];
                        }
                        else{                            
                            $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                                    acc_name = 'VENDOR_".$vendor_name."',
                                    acc_description = '".$vendor_name."',                    
                                    opening_balance = '0',
                                    balance = '0',
                                    acc_type_id='2',
                                    acc_status='1',
                                    last_changed=NOW() 
                                    "); 
                            $account_id = $this->db->getLastId();
                            $this->db->query("INSERT INTO " . DB_PREFIX . "vendor SET vendor_name='".$vendor_name."', vendor_acc_id=".$account_id);      
                            $vendor_id = $this->db->getLastId();
                        }
                      }

                      $item = $_data[0];                
                      $item_name = str_replace("'","\'",$item);
                      $this->db->query("INSERT INTO " . DB_PREFIX . "item SET item_name='".$item_name."', avg_cost= '".$_data[1]."',sale_price='".$_data[2]."',item_code='".$_data[3]."',normal_price='".$_data[1]."',category_id='".$category_id."',quantity='0',type_id=1,added_date=NOW(),cogs_acc=2,sale_acc=5,asset_acc=1,unit=8,vendor='".$vendor_id."'");                              
                      $qty =$_data[7];
                      $avg_cost = $_data[1];
                      $item_id = (int)$this->db->getLastId();  
                      $item_name_entered = $_data[0];
                      
                      if($qty!=0 and $item_id!=0){
                        if($qty>0){  
                            $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id = ".$item_id);                          
                            $total_asset = $qty * $avg_cost;  
                            if($total_asset!=0){
                                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='1', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$item_id."',currency_rate='1',currency_id='1',type='E', entry_date =NOW()"); 
                                $last_journal_id = (int)$this->db->getLastId();  
                                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date =NOW()"); 
                            }
                        }
                        else{
                            $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=0 WHERE id = ".$item_id);                          
                        }
                      }
                      
                        if($_data[3]==""){
                            $this->db->query("UPDATE " . DB_PREFIX . "item SET item_code='00".$_data[8]."' WHERE id = ".$item_id);  
                        }
                              
                      
                    
                    
               }
              }
              $total_asset = $qty * $avg_cost;  
           

            fclose($file);
            
            
        }
        
        public function get_items(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item ");  
            return $query->rows;
        }
        
        public function stock_fix() {
          
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item                              
                    ");             
            $results = $query->rows; 
            
            foreach ($results as $result) {
                // $opening_qty = $this->get_opening_items($result['id']);
                // $purchase_qty = $this->get_purchase_items($result['id']);
                // $sale_qty = $this->get_sale_items($result['id']);
                // $adjust_qty = $this->get_adjust_items($result['id']);
                $sql="SELECT SUM(qty*conv_from) AS qty FROM item_warehouse WHERE item_id=".$result['id'];
                 $query = $this->db->query($sql);

                $qty =$query->row['qty'];                    
                //echo $sale_qty;
                $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id=".$result['id']);
                
            }
        }
        
        public function stockToZero() {
          
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item                              
                    ");             
            $results = $query->rows; 
            
            foreach ($results as $result) {
                $purchase_qty = $this->get_purchase_items($result['id']);
                $sale_qty = $this->get_sale_items($result['id']);
                $adjust_qty = $this->get_adjust_items($result['id']);
                $qty = ($adjust_qty+$purchase_qty-$sale_qty)*-1;                  
                //echo $sale_qty;
                $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id=".$result['id']);
                
            }
        }
        
        public function fix_quantity() {
           
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item                               
                    ");             
            $results = $query->rows; 
            foreach ($results as $result) {
                $purchase_qty = $this->get_purchase_items($result['id']);
                $sale_qty = $this->get_sale_items($result['id']);
                $adjust_qty = $this->get_adjust_items($result['id']);
                $qty = $result['quantity']+$adjust_qty+$purchase_qty-$sale_qty;                                                             
                
                $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id=".$result['id']);                
            }
        }
        
        public function get_quantity($id) {
           
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE id = '".$id."'                             
                    ");             
            $results = $query->rows; 
            foreach ($results as $result) {
                $purchase_qty = $this->get_purchase_items($result['id']);
                $sale_qty = $this->get_sale_items($result['id']);
                $adjust_qty = $this->get_adjust_items($result['id']);
                $qty = $result['quantity']+$adjust_qty+$purchase_qty-$sale_qty;                                                             
                
                echo "Total Quantity on hand =".$qty;
            }
        }
        
        public function fix_Stock() {           

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item  Where type_id=1 and item_status=1");             
            $results = $query->rows; 
            foreach ($results as $result) {
                $data = $result;
                $total_asset = $data['quantity']*$data["avg_cost"];                                        

                if($total_asset !=0){
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["asset_acc"]."', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$data['id']."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['added_date']."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['added_date']."'"); 
                }
                else
                {
                    echo "id=".$data['id']."-total=".$total_asset."<br/>";                    
                }
                
               
            }
        }
        
         public function fix_category() {           
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item                               
                    ");             
            $results = $query->rows; 
            foreach ($results as $result) {
                 $query = $this->db->query("SELECT count(*) as row_count FROM " . DB_PREFIX . "category Where id='".$result['category_id']."'                               
                    ");
                 if($query->row['row_count']==0){
                     echo $result['category_id'] . "<br/>";
                 }
            }
        }
        
         public function get_purchase_items($item_id){
            
            $sql = "SELECT sum( pd.qty * pd.conv_from) 
                    AS qty 
                    FROM ". DB_PREFIX . "item_warehouse AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND pd.invoice_type='4';  
                    ";            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;
        }
        public function get_opening_items($item_id)
        {
          $sql = "SELECT sum( pd.qty * pd.conv_from ) 
                    AS qty 
                    FROM ". DB_PREFIX . "item_warehouse AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND pd.invoice_type='6';  
                    ";            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;   
        }
        public function get_sale_items($item_id){
            
            $sql = "SELECT sum( pd.qty * pd.conv_from ) 
                AS qty 
                FROM ". DB_PREFIX . "item_warehouse AS pd
                LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )
                LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                WHERE i.id='".$item_id."'  AND pd.invoice_type= '2' 
                ";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
         public function get_adjust_items($item_id){            
            $sql = "SELECT sum( qty * conv_from ) 
                AS qty 
                FROM ". DB_PREFIX . "item_warehouse                            
                WHERE item_id='".$item_id."' AND invoice_type='7'";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
        public function get_customers() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE cust_id>0");  
            $results = $query->rows; 
            $customer_details = array();
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum(journal_amount) as sum FROM " . DB_PREFIX . "account_journal                               
                    where acc_id=".$result['cust_acc_id']);         
                $customer_details[] = array(
                        'customer_id'             => $result['cust_id'],
                        'customer_name'             => $result['cust_name'],
                        'customer_balance'             => $query2->row['sum'],
                        'cust_type_id'             => $result['cust_type_id'],
                        'cust_group_id'             => $result['cust_group_id'] 
                      
                    );
            }
            return $customer_details;
        }
        public function get_customersByGroupID($groupID) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE cust_id>0 AND cust_group_id='".$groupID."'");  
            $results = $query->rows; 
            $customer_details = array();
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum(journal_amount) as sum FROM " . DB_PREFIX . "account_journal                               
                    where acc_id=".$result['cust_acc_id']);         
                $customer_details[] = array(
                        'customer_id'             => $result['cust_id'],
                        'customer_name'             => $result['cust_name'],
                        'customer_balance'             => $query2->row['sum'],
                        'cust_type_id'             => $result['cust_type_id'],
                        'cust_group_id'             => $result['cust_group_id'] 
                      
                    );
            }
            return $customer_details;
        }
         public function get_vendors() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendor");  
            $results = $query->rows; 
            $vendor_details = array();
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum(journal_amount) as sum FROM " . DB_PREFIX . "account_journal                               
                    where acc_id=".$result['vendor_acc_id']);         
                $vendor_details[] = array(
                        'vendor_id'             => $result['vendor_id'],
                        'vendor_name'             => $result['vendor_name'],
                        'vendor_balance'             => -1*$query2->row['sum'] 
                      
                    );
            }
            return $vendor_details;
        }
        
        public function get_items_write() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item");  
            $results = $query->rows; 
            $item_details = array();
            foreach ($results as $result) {                
                $item_details[] = array(
                        'item_id'             => $result['id'],
                        'item_name'             => $result['item_name'],
                        'item_qty'             => $result['quantity'],
                        'item_sale_price'             => $result['sale_price'],
                        'item_purchase_price'             => $result['normal_price']
                      
                    );
            }
            return $item_details;
        }
                
        
        public function createupdatevendor($_data){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendor WHERE vendor_id=".$_data[0]); 
            $result = $query->row;
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'VENDOR_".$result["vendor_name"]."',
                    acc_description = '".$result["vendor_name"]."',                    
                    opening_balance = '".$_data[2]."',
                    balance = '".$_data[2]."',
                    acc_type_id='2',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
            $account_id = $this->db->getLastId();
            $this->db->query("UPDATE " . DB_PREFIX . "vendor SET vendor_acc_id=".$account_id." WHERE vendor_id = ".$_data[0]);      
            if($_data[2]!=0){                
                $total_asset =$_data[2];                            
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='".$_data[0]."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='".$_data[0]."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()");                     
           }     
        }
        
        public function getAccounts() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_chart where acc_type_id=8 or (acc_type_id=5 AND acc_id!=9 && acc_id!=10) or  acc_type_id=14 or acc_type_id=15");  
            $results = $query->rows; 
            $vendor_details = array();
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum(journal_amount) as sum FROM " . DB_PREFIX . "account_journal                               
                    where acc_id=".$result['acc_id']);         
                $vendor_details[] = array(
                        'acc_id'             => $result['acc_id'],
                        'acc_name'             => $result['acc_name'],
                        'acc_type_id'             => $result['acc_type_id'],
                        'acc_balance'             => $query2->row['sum']                       
                    );
            }
            return $vendor_details;
        }
        
         public function createupdateaccounts($_data){
            
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = '".$_data[2]."',
                    acc_description = '".$_data[2]."',                    
                    opening_balance = '".$_data[3]."',
                    balance = '".$_data[3]."',
                    acc_type_id='".$_data[1]."',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
            $account_id = $this->db->getLastId();
            
            if($_data[1]==8){                
                if($_data[3]!=0){                
                    $total_asset =$_data[3];                            
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'Bank Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='BANK', entry_date =NOW()"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Bank Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='BANK', entry_date =NOW()");                     
               }     
           }
           else if($_data[1]==5){
               $total_asset =$_data[3];                            
               $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'Expense Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='EXPENSE', entry_date =NOW()"); 
               $last_journal_id = (int)$this->db->getLastId();  
               $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
               $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Expense Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='EXPENSE', entry_date =NOW()");                     
           }
           else if($_data[1]==14){
               $total_asset =$_data[3];                                                           
               $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()"); 
               $last_journal_id = (int)$this->db->getLastId();  
               $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
               $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()");                     
           }
           else if($_data[1]==15){
               $total_asset =$_data[3];                            
               $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'A / P Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='VENDOR_PAY', entry_date =NOW()"); 
               $last_journal_id = (int)$this->db->getLastId();  
               $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
               $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".-1*$total_asset."', journal_details  = 'A / P Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='VENDOR_PAY', entry_date =NOW()");                     
               
           }
        }
        
    
        
        public function makezero(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item");             
            $results = $query->rows; 
            foreach ($results as $result) {                
                $qty = $result['quantity'];                  
                if($qty < 0){
                    $query2 = $this->db->query("SELECT count(*) as row_count FROM " . DB_PREFIX . "account_journal where item_id='".$result['id']."'");  
                    if($query2->row["row_count"]==0){
                        $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=0 WHERE id=".$result['id']);    
                    }
                }
            }
        }
       
        public function fixRegister(){
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET acc_id=5 WHERE acc_id=6 and type='S'" );
        }
        
        public function pandlfix() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal WHERE acc_id=2 and journal_amount<0 and `type`='POS'");             
            $results = $query->rows; 
            foreach ($results as $result) {                                
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET acc_id=1 WHERE journal_id=".$result['journal_id']);                
            }
        }
        
        public function get_items_zero_purchase(){
            $id = array();
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item as i ");             
            $results =  $query->rows; 
            foreach ($results as $result) { 
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "po_invoice_detail WHERE inv_item_id=".$result['id']."");             
                if($query->num_rows==0){
                    $id[] = array($result['id']);
                }
            }
            return $id;
        }
        
        public function getSaleInvoiceId(){
            
            $query = $this->db->query("SELECT inv_id FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id NOT IN (SELECT invoice_id FROM " . DB_PREFIX . "pos_invoice) GROUP BY inv_id");  
            $results =  $query->rows; 
            foreach ($results as $result) { 
                $query1 = $this->db->query("SELECT inv_id FROM " . DB_PREFIX . "account_journal WHERE inv_id=-".$result['inv_id']."");             
                if($query1->num_rows==0){
                    echo "Not in Account Journal Table, Invoice Id = ".$result['inv_id']."<br/>";
                }                
                $query2 = $this->db->query("SELECT invoice_id,invoice_status FROM " . DB_PREFIX . "pos_invoice WHERE invoice_id=".$result['inv_id']."");             
                if($query2->num_rows==0){
                    echo "<font color='red'>Not in Pos Invoice Table , Invoice Id = ".$result['inv_id']."</font><br/>";
                    echo "-------------------------</br>";
                }
                else{
                    if($query2->row['invoice_status']==1){
                        echo "<font color='green'>Invoice status is in process, that is why it is shown in list </font><br/>";
                        echo "-------------------------<br/>";
                    }
                }
                
                
            }
        }
        // Get PO invoice differnece
        public function getPurchaseInvoiceId(){
            $query = $this->db->query("SELECT inv_id FROM " . DB_PREFIX . "po_invoice_detail GROUP BY inv_id");  
            $results =  $query->rows; 
            foreach ($results as $result) { 
                
                $query1 = $this->db->query("SELECT inv_id FROM " . DB_PREFIX . "account_journal WHERE inv_id=".$result['inv_id']."");             
                if($query1->num_rows==0){
                    echo "Not in Account Journal Table, Invoice Id = ".$result['inv_id']."<br/>";
                }                
                $query2 = $this->db->query("SELECT invoice_id,invoice_status FROM " . DB_PREFIX . "po_invoice WHERE invoice_id=".$result['inv_id']."");             
                if($query2->num_rows==0){
                    echo "<font color='red'>Not in PO Invoice Table , Invoice Id = ".$result['inv_id']."</font><br/>";
                    echo "-------------------------</br>";
                }
                else{
                    if($query2->row["invoice_status"]==1){
                        echo "<font color='green'>Invoice status is in process, that is why it is shown in list </font><br/>";
                        echo "-------------------------<br/>";
                    }
                }
                
                
            }
        }
        // Check for Invalid journal enteries.
        
        public function getPOJournalEnteries(){
            $query = $this->db->query("SELECT DISTINCT inv_id FROM " . DB_PREFIX . "account_journal WHERE inv_id>0");  
            $results =  $query->rows; 
            foreach ($results as $result) { 
                echo "PO Invoice ID = ". $result['inv_id']."<br/>";
                $query1 = $this->db->query("SELECT invoice_id FROM " . DB_PREFIX . "po_invoice WHERE invoice_id=".$result['inv_id']."");             
                if($query1->num_rows==0){
                    echo "Not in PO Table, Invoice Id = ".$result['inv_id']."<br/>";
                }                                                
                $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE inv_id=".$result["inv_id"]);                    
            }
        }
        
        
        public function removeItems($_data){            
            $this->db->query("DELETE FROM " . DB_PREFIX . "item WHERE id = ".$_data[0]);                              
        }
        
        
        
        public  function sendMessages(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts where sent=1");             
            $results = $query->rows; 
            $cont_text = "";
            
            $text ="";
            echo "<table width='400px' border=1>";
            foreach ($results as $result) {                                
                echo "<tr>";                
                echo "<td>".$result["name"]."</td><td width=20>".$result["count"]."</td><td>".$result["mobile_no"]."</td><td width=20>&nbsp;</td>";
                echo "</tr>";
            }
            echo "<table>";
                        
            
        }
        public function sendSMS($to, $message){
            $username = 'waqarjan333';
            $password = '5777697waqar';
            $from = 'Umair';
            $url = "http://Lifetimesms.com/plain?username=".$username."&password=".$password.
            "&to=".$to."&from=".urlencode($from)."&message=".urlencode($message)."";
            $ch  =  curl_init();
            $timeout  =  60;
            curl_setopt ($ch,CURLOPT_URL, $url) ;
            curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
            $response = curl_exec($ch) ;
            curl_close($ch) ;
            return $response ;
      }
      
      public function exportFromExcel1(){         
            //set_error_handler('error_handler_for_export',E_ALL);
            require_once 'app/Spreadsheet/Excel/Reader.php';            
            ini_set("memory_limit","512M");
            ini_set("max_execution_time",380);            
            $reader=new Spreadsheet_Excel_Reader();
            $reader->setUTFEncoder('iconv');
            $reader->setOutputEncoding('CP1251');
            $reader->read(DIR_UPLOAD."items.xlsx");            
            $this->importItems( $reader );
            
        }
                
        
        
                
        function uploadItems( &$reader ) {
            $data = $reader->sheets[0];
            $category_id = 1;    
            foreach ($data['cells'] as $row) {                
                if(!isset($row[1])){
                    continue;
                }
                if(trim($row[1])=="Page -1 of 1"){
                    continue;
                }
                if(trim($row[1])=="Item Code"){
                    continue;
                }
                if(trim($row[1])=="Category Total:-"){
                    continue;
                }
                if(isset($row[1]) && isset($row[2]) && !isset($row[3]) && !isset($row[4]) && !isset($row[5])){
                    $this->db->query("INSERT INTO " . DB_PREFIX . "category SET name='".$row[2]."', parent_id= '1'");
                    $category_id = (int)$this->db->getLastId();     
                    continue;
                }
                else{
                    
                    $item = $row[2];                
                    $item_name = str_replace("'","\'",$item);
                    $avg_cost = isset($row[4]) ? $row[4] : 0 ;
                    $this->db->query("INSERT INTO " . DB_PREFIX . "item SET item_name='".$item_name."', avg_cost= '".$avg_cost."',sale_price='".$row[5]."',item_code='".$row[1]."',normal_price='".$avg_cost."',category_id='".$category_id."',quantity='0',type_id=1,added_date=NOW(),cogs_acc=2,sale_acc=5,asset_acc=1,unit=1");                              
                    $qty =isset($row[3])?$row[3]:0;                    
                    $item_id = (int)$this->db->getLastId();                      

                    if($qty!=0 and $item_id!=0){
                      if($qty>0){  
                          $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id = ".$item_id);                          
                          $total_asset = $qty * $avg_cost;  
                          if($total_asset!=0){
                              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='1', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$item_id."',currency_rate='1',currency_id='1',type='E', entry_date =NOW()"); 
                              $last_journal_id = (int)$this->db->getLastId();  
                              $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date =NOW()"); 
                          }
                      }
                      else{
                          $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=0 WHERE id = ".$item_id);                          
                      }
                    }
                    
                    
                }                                
            }
        }
        
        public function missingSOInvoice() {
           
            $query = $this->db->query("SELECT DISTINCT inv_id FROM " . DB_PREFIX . "account_journal where inv_id <0");             
            $results = $query->rows; 
            foreach ($results as $result) {
                $query = $this->db->query("SELECT count(*) as co FROM " . DB_PREFIX . "pos_invoice WHERE invoice_id=-1*".$result["inv_id"]);                    
                if($query->row["co"]==0){
                    echo $result["inv_id"]. "<br/>";
                }
            }
        }
        
        public function missingPOInvoice() {
           
            $query = $this->db->query("SELECT DISTINCT inv_id FROM " . DB_PREFIX . "account_journal where inv_id >0                                
                    ");             
            $results = $query->rows; 
            foreach ($results as $result) {
                $query = $this->db->query("SELECT count(*) as co FROM " . DB_PREFIX . "po_invoice WHERE invoice_id=".$result["inv_id"]);                    
                if($query->row["co"]==0){
                    echo $result["inv_id"]. "<br/>";
                }
            }
        }
        
        public function fixSaleReturnDiscount(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice as pos_d where invoice_type=3");             
            $item_discount = 0;
            $results = $query->rows; 
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum((inv_item_price * (inv_item_discount/100)) * item_quantity ) as items_discount  FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id=".$result["invoice_id"]);                    
                
                $item_discount = $query2->row["items_discount"] * -1 + $result["discount"] ;
                                              
                echo "Inv id = ".$result["invoice_id"] ." -Total discount = ". $item_discount ."<br/>";
                
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='".$item_discount."' WHERE inv_id=-'".$result["invoice_id"]."' and acc_id=-1 and type='SALE_RET_I'");
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='-".$item_discount."' WHERE inv_id=-'".$result["invoice_id"]."' and acc_id=12 and type='SALE_RET_I'");
            }
        }
        
        public function fixDiscountSaleReturn(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice where invoice_type=3 and invoice_date >='2017-6-18 0:0:0' and invoice_date< '2017-6-25 0:0:0' + interval 1 day");             
            $item_discount = 0;
            $results = $query->rows; 
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum((inv_item_price * (inv_item_discount/100)) * item_quantity ) as items_discount  FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id=".$result["invoice_id"]);                    
                
                $item_discount = $query2->row["items_discount"] * -1 + $result["discount"] ;
                                              
                echo "Inv id = ".$result["invoice_id"] ." -Total discount = ". $item_discount ."<br/>";
                
                $query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal  where inv_id=-'".$result["invoice_id"]."' and acc_id=-1 and type='SALE_RET_I'");             
                if( $query2->num_rows){                
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='".$item_discount."' WHERE inv_id=-'".$result["invoice_id"]."' and acc_id=-1 and type='SALE_RET_I'");
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='-".$item_discount."' WHERE inv_id=-'".$result["invoice_id"]."' and acc_id=12 and type='SALE_RET_I'");
                }
                else{
                    echo "<br/> Missing Journal Entry=".$result["invoice_id"]."<br/>";
                }
            }
        }
        public function fixDiscountPOS(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice where invoice_type=1 and invoice_date >='2017-6-18 0:0:0' and invoice_date< '2017-6-25 0:0:0' + interval 1 day");             
            $item_discount = 0;
            $results = $query->rows; 
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum((inv_item_price * (inv_item_discount/100)) * item_quantity ) as items_discount  FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id=".$result["invoice_id"]);                    
                
                $item_discount = $query2->row["items_discount"] + $result["discount"] ;
                                              
                echo "Inv id = ".$result["invoice_id"] ." -Total discount = ". $item_discount ."<br/>";
                
                $query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal  where inv_id=-'".$result["invoice_id"]."' and acc_id=-1 and type='DIS'");             
                if( $query2->num_rows){                
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='".$item_discount."' WHERE inv_id=-'".$result["invoice_id"]."' and acc_id=-1 and type='DIS'");
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='-".$item_discount."' WHERE inv_id=-'".$result["invoice_id"]."' and acc_id=10 and type='DIS'");
                }
                else{
                    echo "<br/> Missing Journal Entry=".$result["invoice_id"]."<br/>";
                }
            }
        }
        /**** Sohrab Fashion Ghar fixes ***/
        public function getSaleDifference(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice as pos_d where sale_return=1 and invoice_status >= '2' and invoice_date>='2017-8-21 0:0:0' AND invoice_date < '2017-8-21 0:0:0' + interval 1 day");             
            $r_total = 0;
            $j_total = 0;
            $results = $query->rows; 
            foreach ($results as $result) {
                $query2 = $this->db->query("SELECT sum(inv_item_quantity * inv_item_price ) as invoice_total_r  FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id=".$result["invoice_id"]);                    
                $total_discount_on_invoice = ($query2->row["invoice_total_r"] + $result["discount"]);
                echo "Invoice id = ".$result["invoice_id"]."] POS_inv_detail total= ". $total_discount_on_invoice;
                $r_total = $r_total +$total_discount_on_invoice;
                
                $query2 = $this->db->query("SELECT sum(journal_amount ) as invoice_total_j  FROM " . DB_PREFIX . "account_journal WHERE acc_id=11 and inv_id=-".$result["invoice_id"]);                    
                //$this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE inv_id=-".$result["invoice_id"]);                    
                
                echo "--- Journal Total = ".$query2->row["invoice_total_j"]."<br/>";
                $j_total = $j_total +$query2->row["invoice_total_j"];
            }
            echo "R Total = ". $r_total . "-----J Total = ". $j_total;
        }
        
        public function updaeSaleDateDifference(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice as pos_d where invoice_type=1 and invoice_status >= '2'");                        
            $results = $query->rows; 
            foreach ($results as $result) {              
                $query2 = $this->db->query("SELECT *  FROM " . DB_PREFIX . "account_journal WHERE date(entry_date)=date('".$result['invoice_date']."') and acc_id=5 and inv_id=-".$result["invoice_id"]);                    
                if($query2->num_rows==0){
                    $query3 = $this->db->query("SELECT *  FROM " . DB_PREFIX . "account_journal WHERE acc_id=5 and inv_id=-".$result["invoice_id"]);  
                    $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice set invoice_date ='".$query3->row["entry_date"]."'  WHERE invoice_id=".$result["invoice_id"]);                    
                                        
                }                
            }
            
        }
        
        public function changeDiscountJournal(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal  WHERE type='DIS' and inv_id!=0 and entry_date>='2017-6-18 0:0:0' AND entry_date < '2017-6-25 0:0:0' + interval 1 day");                        
            $results = $query->rows; 
            foreach ($results as $result) {                              
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal set journal_amount ='".($result['journal_amount']*-1)."'  WHERE journal_id=".$result["journal_id"]);                 
            }
            
        }
        
        /**** Sohrab Fashion Ghar fixes ***/
        
        public function getMissingJournalEntry (){
            
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal where type='EXPENSE'");  
            $results = $query->rows; 
            //$ind =1 ;
            foreach ($results as $result) {
                 $query2 = $this->db->query("SELECT count(*) as entry  FROM " . DB_PREFIX . "account_journal WHERE ref_id=".$result["ref_id"]);                    
                
                 if( $query2->row["entry"]!=2){
                     echo $result['journal_id'] ."<br/>";
                    // $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE journal_id=".$result["journal_id"]);     
                 } 
                /*if($ind<=10){
                     echo $result['journal_id']. "<br/>";   
                     $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE journal_id=".$result["journal_id"]); 
                 }
                 $ind = $ind + 1;*/
            }
        }
        
        public function getCashTrasnferedAccount(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal where acc_id=-1 and journal_amount<0");  
            $results = $query->rows;
            $sum = 0;
            foreach ($results as $result) {
                 $query2 = $this->db->query("SELECT aj.*,acc.acc_name  FROM " . DB_PREFIX . "account_journal as aj 
                           LEFT JOIN account_chart acc ON ( aj.acc_id = acc.acc_id )
                           WHERE aj.acc_id!=-1 and aj.type!='DIS' and aj.type!='POS_RET' and  aj.ref_id=".$result["ref_id"]);                    
                
                 if( $query2->num_rows){
                     echo "Id= ".$query2->row['journal_id']." ------ Date= ".$query2->row['entry_date']." ----- To Account= ". $query2->row['acc_name']. " --- Amount = ". $query2->row['journal_amount']."<br/>";
                    $sum =  $sum  + $query2->row['journal_amount'];
                 } 
                                     
                
            }
            echo "<br/>----------------------------------Total -------------------------: ".$sum;
        }
        
        public function getPOSDateDiffernce (){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice where  invoice_status >= '2' and invoice_date>='2017-8-3 0:0:0' AND invoice_date < '2017-8-3 0:0:0' + interval 1 day");
             $results = $query->rows;
             
             foreach ($results as $result) {
                 $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_journal where inv_id = -".$result['invoice_id']);
                 echo "POS Date = ". $result["invoice_date"]. "--- Journal Date".$query2->row["entry_date"]."<br/>";
             }
        }
        
        public function createVendorAccounts(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendor WHERE 1"); 
            $results = $query->rows;
            foreach ($results as $result) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "account_chart WHERE acc_id = '".$result["vendor_acc_id"]."' and acc_type_id=2"); 
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                        acc_name = 'VENDOR_".$result["vendor_name"]."',
                        acc_description = '".$result["vendor_name"]."',                    
                        opening_balance = '0',
                        balance = '0',
                        acc_type_id='2',
                        acc_status='1',
                        last_changed=NOW() 
                        "); 
                $account_id = $this->db->getLastId();

                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET acc_id=".$account_id." WHERE acc_id = ".$result['vendor_acc_id']." and inv_id >0");               
                $this->db->query("UPDATE " . DB_PREFIX . "vendor SET vendor_acc_id=".$account_id." WHERE vendor_id = ".$result['vendor_id']);      
            }
                 
        }
        
        public function importItems(){         
            
            require_once 'app/Spreadsheet/Excel/XLSXReader.php';                          
            $xlsx = new XLSXReader(DIR_UPLOAD.'items.xlsx');
            $sheetNames = $xlsx->getSheetNames();
                        
            
            $sheet = $xlsx->getSheet("Item Detail");
            $data = $sheet->getData();
            
            
            $category_id = 1;    
            $category_name ="";
            $total_neg =0;
            $total_qty = 0;
            foreach ($data as $row) {  
                
                if(!isset($row[1])){
                    continue;
                }
                if(trim($row[1])=="Department"){
                    continue;
                }
                
                if( isset($row[1]) && isset($row[2]) && isset($row[3]) && isset($row[4]) && isset($row[5]) ){
                    
                    if( $category_name != $row[1]){
                        $cat_name = str_replace("'","\'",$row[1]);
                        $this->db->query("INSERT INTO " . DB_PREFIX . "category SET name='".$cat_name."', parent_id= '1'");
                        $category_name = $row[1];
                        $category_id = (int)$this->db->getLastId();     
                    }
                    
                    $item = $row[2];                
                    $item_name = str_replace("'","\'",$item);
                    $avg_cost = isset($row[4]) ? $row[4] : 0 ;
                    $this->db->query("INSERT INTO " . DB_PREFIX . "item SET item_name='".$item_name."', avg_cost= '".$avg_cost."',sale_price='".$row[5]."',item_code='".$row[8]."',normal_price='".$avg_cost."',category_id='".$category_id."',quantity='0',type_id=1,added_date=NOW(),cogs_acc=2,sale_acc=5,asset_acc=1,unit=1,sale_unit=1,purchase_unit=1");                                                  
                    $qty =isset($row[3]) ? $row[3] : 0;                                        
                    $item_id = (int)$this->db->getLastId();  
                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$item_id."', 
                    `uom_id`='0', 
                    `unit_id`='1', 
                    `conv_from`='1', 
                    `conv_to`='1', 
                    `qty_on_hand`='".$qty."', 
                    `sale_price`='".$row[5]."', 
                    `avg_cost`='".$avg_cost."', 
                    `created_date`='NOW()', 
                    `updated_date`='NOW()'
                    ");
                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$item_id."', 
                    `uom_id`='0', 
                    `barcode`='".$row[8]."', 
                    `upc`='1'
                    ");
                    if(isset($row[9])){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                        `item_id`='".$item_id."', 
                        `uom_id`='0', 
                        `barcode`='".$row[9]."', 
                        `upc`='0'
                        ");
                    }

                    if($qty!=0 and $item_id!=0){
                      if($qty>0){  
                          $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".$qty." WHERE id = ".$item_id);                          
                          $total_asset = number_format($qty * $avg_cost,2,'.','');  
                          if($total_asset!=0){
                              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='1', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$item_id."',currency_rate='1',currency_id='1',type='E', entry_date =NOW()"); 
                              $last_journal_id = (int)$this->db->getLastId();  
                              $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date =NOW()"); 
                          }
                      }
                      else{
                          $total_asset = number_format($qty * $avg_cost,2,'.',''); 
                          echo $qty."--".$avg_cost."--".($total_asset)."</br>";
                          $total_qty = $total_qty+$qty;
                          $total_neg = $total_neg + $total_asset;
                          $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=0 WHERE id = ".$item_id);                          
                      }
                    }
                    
                    
                }                          
            }
            echo "qty=". $total_qty. "Total with Negative Qty=".$total_neg;
            
        }
        
        public function importReceivable(){
            require_once 'app/Spreadsheet/Excel/XLSXReader.php';                          
            $xlsx = new XLSXReader(DIR_UPLOAD.'receivable.xlsx');
            $sheetNames = $xlsx->getSheetNames();
                           
            $sheet = $xlsx->getSheet("Sheet1");
            $data = $sheet->getData();
                              
            foreach ($data as $row) {  
                
                if(!isset($row[0]) && isset($row[1])){
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                        acc_name = '".$row[1]."',
                        acc_description = '".$row[1]."',                    
                        opening_balance = '".$row[12]."',
                        balance = '".$row[12]."',
                        acc_type_id='14',
                        acc_status='1',
                        last_changed=NOW() 
                        "); 
                   $account_id = $this->db->getLastId();


                $total_asset =$row[12];                                                           
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='8', journal_amount='".-1*$total_asset."', journal_details  = 'A / R Opening Balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='R_LOAN', entry_date =NOW()");                     
            }
        }
     }
     
     public function importPayableAsVendors(){
            require_once 'app/Spreadsheet/Excel/XLSXReader.php';                          
            $xlsx = new XLSXReader(DIR_UPLOAD.'payable.xlsx');
            $sheetNames = $xlsx->getSheetNames();
                           
            $sheet = $xlsx->getSheet("Sheet1");
            $data = $sheet->getData();
                              
            foreach ($data as $row) { 
                if(!isset($row[0]) && isset($row[1])){
                    $vendor_name = $row[1];
                    $vendor_balance =$row[12];
                    $query = $this->db->query("INSERT INTO " . DB_PREFIX . "vendor SET vendor_name = '".$vendor_name."',
                            vendor_ct_name = '".$vendor_name."',
                            vendor_phone = '',
                            vendor_mobile = '',
                            vendor_email = '',
                            vendor_fax = '',
                            vendor_address = ''
                            ");  
                    $vendor_id = $this->db->getLastId();
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                            acc_name = 'VENDOR_".$vendor_name."',
                            acc_description = '".$vendor_name."',                    
                            opening_balance = '".$vendor_balance."',
                            balance = '".$vendor_balance."',
                            acc_type_id='2',
                            acc_status='1',
                            last_changed=NOW() 
                            "); 
                    $account_id = $this->db->getLastId();
                    $this->db->query("UPDATE " . DB_PREFIX . "vendor SET vendor_acc_id=".$account_id." WHERE vendor_id = ".$vendor_id);      
                    if($vendor_balance!=0){                
                        $total_asset =$vendor_balance;                            
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='9', journal_amount='".$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='0',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Vendor opening balance',inv_id= '0',item_id='0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='VEND_OB', entry_date =NOW()");                     
                   }        
                }
            }
        }
        
        public function generate_five_barcode(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE item_status=1                              
                    ");             
            $results = $query->rows; 
            foreach ($results as $result) {
                 $upc = (isset($result['item_code']) && $result['item_code']!="")? 0 : 1 ;
                 $bar_code = str_pad($result["id"], 5, "0", STR_PAD_LEFT);
                 $bar_code = $this->checkDublicateBarcode($bar_code);
                 $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$result["id"]."', 
                    `uom_id`='0', 
                    `barcode`='".$bar_code."', 
                    `upc`= '".$upc."'
                    ");
                 
            }
            
        }
        private function checkDublicateBarcode($barcode){
           $code = $barcode;           
           $query = $this->db->query("SELECT barcode FROM " . DB_PREFIX . "uom_barcodes WHERE barcode=".$barcode."");             
           if($query->num_rows > 0){
                mt_srand((double)microtime()*1000);
                $charid = strtoupper(uniqid(rand(), true));
                $uuid = '';                
                $code = $uuid.substr($charid, 0, 5);                       
           }
                      
           return $code;
           
        }
        
        public function fixBarCodes(){           
           $query = $this->db->query("SELECT id,item_id,barcode FROM " . DB_PREFIX . "uom_barcodes WHERE 1");             
           $results = $query->rows; 
           foreach ($results as $result) {
               if(intval($result['barcode']) >= 11273){
                   if(!strrpos($result['barcode'],"-")){
                       $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "po_invoice_detail WHERE inv_item_id='".$result['item_id']."'");
                       if($query2->num_rows == 0){
                         echo $result['barcode'] . "<br/>";
                         $this->db->query("DELETE FROM " . DB_PREFIX . "uom_barcodes WHERE id=".$result['id']);                
                       }
                   }
               }
           }
                                            
        }
        
        public function noBarcodes(){           
           $query = $this->db->query("SELECT id,item_name FROM " . DB_PREFIX . "item WHERE 1");             
           $results = $query->rows; 
           foreach ($results as $result) {
            $query2 = $this->db->query("SELECT barcode FROM " . DB_PREFIX . "uom_barcodes WHERE item_id='".$result['id']."'");
                if($query2->num_rows == 0){
                  echo "No Barcode Exists for item=".$result['item_name'] ."--- Item Id=".$result['id'] . "<br/>";
                }                   
           }
                                            
        }
        
        public function getSumofCost(){
            $query = $this->db->query("SELECT i.id,c.name,sum(pd.item_quantity * pd.item_purchase_price) as sum FROM pos_invoice_detail AS pd
                    LEFT JOIN pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                     LEFT JOIN item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN category c ON ( c.id = i.category_id )
                    WHERE inv.sale_return='0' and inv.invoice_status >= '2' AND inv.invoice_date>='2017-3-25 0:0:0' AND inv.invoice_date < '2017-3-30 0:0:0' + interval 1 day
GROUP BY i.id ORDER BY c.name ASC");
            $results = $query->rows; 
            $total  = 0;
            foreach ($results as $result) {
               $total = $total + $result['sum'];
            }
            echo $total;
        }
        
        public function compareResults(){
            $date = '2017-6-10 0:0:0';
            $query = $this->db->query("SELECT  i.id as item_id,i.avg_cost as avg_cost, i.normal_price as purchase_price, inv.invoice_id as inv_id,pd.item_purchase_price, pd.item_quantity * pd.item_purchase_price as sum FROM pos_invoice_detail AS pd
                    LEFT JOIN pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                     LEFT JOIN item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN category c ON ( c.id = i.category_id )
                    WHERE  inv.invoice_status >= '2' AND inv.invoice_date>='".$date."' AND inv.invoice_date < '".$date."' + interval 1 day
                    ORDER BY inv.invoice_id,sum  ASC");
            $results1 = $query->rows; 
            
            $query2 = $this->db->query("SELECT inv_id, journal_amount  FROM `account_journal` WHERE acc_id=2 and entry_date>='".$date."' AND entry_date < '".$date."' + interval 1 day Order by inv_id, journal_amount ASC");
            $results2 = $query2->rows; 
            $i=0;
            $diff =0;
            foreach ($results1 as $result) {                
                if($result["sum"]!=$results2[$i]["journal_amount"]){
                    echo "Price in journal=". $results2[$i]["journal_amount"] ."<br/>";
                    echo $result["inv_id"]."----".$result["item_id"]."----".$result["avg_cost"]."----".$result["purchase_price"]."----".$result["sum"]."<br/><br/>";
                    $diff = $diff + ($result["sum"]-$results2[$i]["journal_amount"]);
                }                
                $i++;
               //$total = $total + $result['sum'];
            }
            echo "Total Differenc= ". $diff;
            
            //echo $total;
        }
        
        public function getCOCGSDiff(){
            
            $query = $this->db->query("SELECT inv.invoice_id as inv_id,pd.inv_item_id as item_id, pd.item_purchase_price, pd.item_quantity * pd.item_purchase_price as sum, 
                    inv.invoice_date as date FROM pos_invoice_detail AS pd
                    LEFT JOIN pos_invoice inv ON ( pd.inv_id = inv.invoice_id )                    
                    WHERE  inv.invoice_status >= '2' ");
            $results1 = $query->rows; 
            $diff_total=0;;                        
            foreach ($results1 as $result) {                
                $query2 = $this->db->query("SELECT journal_id FROM account_journal WHERE inv_id=-".$result['inv_id']." and item_id='".$result['item_id']."'");
                $results2 = $query2->row; 
                $jid = $results2["journal_id"] + 2;
                $query3 = $this->db->query("SELECT journal_amount FROM account_journal WHERE journal_id=".$jid." and acc_id='2'");
                $results3 = $query3->row;
                if($results3['journal_amount']!=$result["sum"]){                
                    echo "Dated=".$result['date']."-----Invoice Total = ".$result["sum"]."<br/>";
                    echo "Invoice ID =".$result['inv_id']."---"."Item Id =".$result['item_id']."---Journal Amount=".$results3['journal_amount']."<br/>";
                    $d_total = $results3['journal_amount'] -$result["sum"]; 
                    echo "Difference=".$d_total."<br/>";
                    $diff_total = $diff_total + $d_total;
                    echo "Total Difference=".$diff_total."<br/>____________________________________________<br/>";           
                    
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET journal_amount='".$result["sum"]."' WHERE journal_id='".$jid."'");
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET journal_amount='".($result["sum"]*-1)."' WHERE journal_id='".($jid+1)."'");
                }
            }
            
            echo "Total Diff End=".$diff_total;
        }
        
        public function createCustomerAccounts(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE cust_acc_id>0"); 
            $results = $query->rows;
            foreach ($results as $result) {
                if($result["cust_acc_id"]>14){
                    $this->db->query("DELETE FROM " . DB_PREFIX . "account_chart WHERE acc_id = '".$result["cust_acc_id"]."' and acc_type_id=1"); 
                }
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_chart SET 
                    acc_name = 'CUST_".$result["cust_name"]."',
                    acc_description = '".$result["cust_name"]."',                    
                    opening_balance = '0',
                    balance = '0',
                    acc_type_id='1',
                    acc_status='1',
                    last_changed=NOW() 
                    "); 
                $account_id = $this->db->getLastId();
                if($result["cust_acc_id"]>0){
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET acc_id=".$account_id." WHERE acc_id = ".$result['cust_acc_id']." and inv_id <0");               
                }
                $this->db->query("UPDATE " . DB_PREFIX . "customer SET cust_acc_id=".$account_id." WHERE cust_id = ".$result['cust_id']);      
            }
        }
        
        public function updatePurchasePrice(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice_detail WHERE item_purchase_price=0");
            $results = $query->rows;
             foreach ($results as $result) {
                 $query2 = $this->db->query("SELECT avg_cost FROM item WHERE id=".$result['inv_item_id']);
                 $avg_cost = $query2->row['avg_cost'];
                 $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice_detail SET item_purchase_price=".$avg_cost." WHERE pos_idx = ".$result['pos_idx']);               
             }
        }
        
        public function insert_item($_data) {
                                                
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item_temp WHERE id=".$_data[2]);                                    
            if($query->num_rows){
            $data = $query->row;                         
            $item_name = $data['item_name'];
            
            $this->db->query("INSERT INTO " . DB_PREFIX . "item SET item_name='".addslashes($item_name)."', avg_cost= '".$data['avg_cost']."',sale_price='".$data['sale_price']."',item_code='".$data['item_code']."',normal_price='".$data['normal_price']."',sale_unit=1,purchase_unit=1,category_id='1',quantity='0',type_id=1,added_date=NOW(),cogs_acc=2,sale_acc=5,asset_acc=1,unit=1");
            $last_id = $this->db->getLastId();
            $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$last_id."', 
                    `uom_id`='0', 
                    `unit_id`='1', 
                    `conv_from`='1', 
                    `conv_to`='1',  
                    `sale_price`='".number_format($data["sale_price"],2,'.','')."', 
                    `created_date`='".date('Y-m-d h:i:s')."', 
                    `updated_date`='".date('Y-m-d h:i:s')."'
                    ");
              $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$last_id."', 
                    `uom_id`='0', 
                    `barcode`='".$data["item_code"]."', 
                    `upc`='1'
                    ");
            
            return true;
            }
            else{
                echo "<br/>Id=".$_data[2] . " didn't exist.";
            }
             
	}
        public function remove_table() {
            $this->db->query("Drop Table " . DB_PREFIX . "item_temp");                                   
        }
        public function insert_po($_data) {
            $invoice_no = $this->getInvoiceNumber(0);
            $this->db->query("INSERT INTO " . DB_PREFIX . "po_invoice SET
                      vendor_id = '48',
                      invoice_no ='".$invoice_no."',
                      invoice_type ='1',
                      invoice_date = NOW(),
                      paid_date  = NOW(),  
                      custom  = '',  
                      invoice_status = '3'
                      "); 
            $invoice_id = $this->db->getLastId();
            
            while(! feof($_data))
              {
               $result = fgetcsv($_data);
               if($result[0]!=""){                    
                    $item_qty = 1;
                
                    $query = $this->db->query("SELECT id FROM " . DB_PREFIX . "item where item_name='".addslashes($result[3])."'");  
                    $data = $query->row;
                    $this->db->query("INSERT INTO " . DB_PREFIX . "po_invoice_detail SET
                      inv_id = '".$invoice_id."',
                      inv_item_id = '".$data["id"]."',
                      item_quantity = '".$result[6]."',
                      conv_from = '".$result[5]."',
                      inv_item_quantity = '".$result[6]."',
                      unit_id = '".$result[7]."',
                      unit_name = '".$result[8]."',
                      inv_item_price = '".$result[9]."',
                      inv_item_sprice = '".$result[10]."',    
                      inv_item_discount = '0',
                      inv_item_subTotal = '".$result[9]*$result[6]."'
                      ");             
               }
              }

            fclose($_data);
            
        }
        private function getInvoiceNumber($id=0,$type=1){
            $inv_no = 0;
            if($id==0){
                $query_item = $this->db->query("SELECT max(invoice_no) as inv_no FROM ".DB_PREFIX."po_invoice WHERE invoice_type=".$type);
                $inv_no = $query_item->row['inv_no']+1;
            }            
            
            return $inv_no;
        }
        
        public function comparePOANDJournal(){            
            $query = $this->db->query("SELECT  invoice_id from po_invoice
                    WHERE  1");
            $results = $query->rows;
            $total1 = $total2 = 0;
            
            echo "Journal Total--------------------PO Total <br/>";
            foreach ($results as $result) {                
                $query = $this->db->query("SELECT sum(journal_amount) as j_total FROM " . DB_PREFIX . "account_journal WHERE inv_id=".$result["invoice_id"]." and journal_amount>0");                                                
                $resutl1= $query->row;  
                $total1 = $total1 +$resutl1['j_total'];
                
                $query2 = $this->db->query("SELECT sum(inv_item_price*inv_item_quantity) as po_total FROM " . DB_PREFIX . "po_invoice_detail WHERE inv_id=".$result["invoice_id"]);                                                
                $resutl2= $query2->row; 
                $total2 = $total2 +$resutl2['po_total'];
                
                echo $resutl1['j_total'].'--------------------'.$resutl2['po_total']."<br/>";
               
            }
            
            echo "<br/>".$total1."--------------------".$total2;
            
            
            //echo $total;
        }
        
        public function changedAvgCost(){            
            $query = $this->db->query("SELECT inv_item_id,inv_item_price,inv_id from po_invoice_detail
                    WHERE  1");
            $results = $query->rows;
            $total1 = $total2 = 0;
                        
            foreach ($results as $result) {                
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE id=".$result["inv_item_id"]);                                                
                $resutl1= $query->row;  
                if($result['inv_item_price'] !=$resutl1['normal_price']){
                    echo "inv_id=".$result['inv_id']."--------item_id=".$resutl1['id']."-----pric_po=".$result['inv_item_price']."-------item price=".$resutl1['normal_price']."</br>";
                }
                                               
            }
                        
            
            
            //echo $total;
        }
        public function keepInProcessInvoices(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice WHERE invoice_status!='1' and invoice_id<30000 ");
            $results = $query->rows;  
            foreach ($results as $result) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id = ".$result['invoice_id']);
                $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice WHERE invoice_id = ".$result['invoice_id']);
            }
           
        }
        
        public function reNumberInvoices(){
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice WHERE invoice_status='1'");
            $results = $query->rows;  
            $no = 1;
            foreach ($results as $result) {
                $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET invoice_id=".$no.", invoice_no='".$no."' WHERE invoice_id = ".$result['invoice_id']);               
                $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice_detail SET inv_id=".$no." WHERE inv_id = ".$result['invoice_id']);               
                $no = $no + 1;
            }
           
        }
}
?>
