
<?php
  date_default_timezone_set("Asia/Karachi");

class ModelDashboardSo extends Model{
        public function saveInvoice($data,$det){
          $this->initSales();  
          $so_remarks = isset($data['so_remarks'])?$data['so_remarks']:NULL;
          //list($so_date,$so_time) = mb_split(' ', $data["so_date"]);
          list($dd, $md, $yd) = mb_split('[/.-]', $data["so_date"]);
          list($ddp, $mdp, $ydp) = mb_split('[/.-]', $data["so_due_date"]);
          $_is_print = (isset($data['so_allow_print']))?$data['so_allow_print']:1;
          $_is_email = (isset($data['so_allow_email']))?$data['so_allow_email']:0;
          $_previous_balance = ($data['prev_total_balance']!=0)?$data['prev_total_balance']:0;
          $query = $this->db->query("SELECT max(invoice_id) as last_id FROM po_invoice");
          $last_po_id = $query->row['last_id']==NULL? 0: $query->row['last_id'];
          $invoice_total = $data["so_total"]-$data['so_discount_invoice'];
          $discount = $data['so_discount']+$data['so_discount_invoice'];
          $warehouse=0;
         
          if( isset($data['so_type']) && $data['so_type']=="1"){         
              
               $query = $this->db->query("SELECT max(invoice_id) as last_id FROM po_invoice");
               $last_po_id = $query->row['last_id']==NULL? 0: $query->row['last_id'];
               $inv_no = $this->getInvoiceNumber($data['so_hidden_id'],4);
                $mobile='';
               if(is_numeric($data["customer_mobile"]))
               {
                $mobile=$data["customer_mobile"];
               }
               else{
                $mobile='';
               }
              
               $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice SET
                    cust_id = '".$data["customer_id"]."',
                    invoice_date = '". $data["so_datetime_hidden"]."',
                    updated_date = '". $data["so_datetime_hidden"]."',
                    paid_date  = '".$ydp.'-'.$mdp.'-'.$ddp."',
                    invoice_status = '".$data["so_order_status"]."',
                    invoice_type = '4',                    
                    invoice_no = '".$inv_no."',
                    in_print = '".$_is_print."',
                    in_email = '".$_is_email."',
                    invoice_paid = '".$data["so_paid"]."',
                    cust_name    = '".$data["customer_contact"]."',
                    cust_mobile_no    = '".$mobile."',
                    previous_balance = '".$_previous_balance."',    
                    discount = '',
                    discount_invoice = '".$data['so_discount_invoice']."',
                    salesrep_id = '".$data['so_salesrep']."',
                    custom = '".$so_remarks."',   
                    invoice_name = '{{Sales Return}}',
                    invoice_total = '".$invoice_total."',
                    sale_return = '1',    
                    last_po_id ='".$last_po_id."'    
                ");                 
                $invoice_id =  $this->db->getLastId();
                
                $salereturn_account = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Sales Return' && acc_description='{{SALE_RETURN_ACCOUNT_SYSTEM}}'")->row['acc_id'];
                $acc_receiveable = $this->db->query("SELECT cust_acc_id FROM ".DB_PREFIX."customer WHERE cust_id='".$data["customer_id"]."'")->row['cust_acc_id'];

                for($i=0;$i<count($det);$i++){

                  if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                    
                $item_cost = $this->getPurchasePrice($det[$i]->{'item_id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];
                $item_sale_price=  $item_cost['sale_price'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                $unit_avg_cost = $item_avg_cost*$det[$i]->{'conv_from'};
                $unit_sale_price = $det[$i]->{'unit_price'};
                

                
                $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                
                $total_asset = $det[$i]->{'item_quantity'}*$unit_sale_price;
                $total_cogs = $det[$i]->{'item_quantity'}*$unit_avg_cost;
                

                
                  $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET
                  inv_id = '".$invoice_id."',
                  inv_item_id = '".$det[$i]->{'item_id'}."',
                  inv_item_name = '".addslashes($det[$i]->{'item_name'})."',
                  item_quantity = '".$det[$i]->{'item_quantity'}."',
                  conv_from = '".$det[$i]->{'conv_from'}."',
                  inv_item_quantity = '".$item_qty."',
                  bonus_qty = '".$det[$i]->{'bonus_quantity'}."',
                  unit_id = '".$det[$i]->{'unit_id'}."',
                  warehouse_id = '".$warehouse."',
                  unit_name = '".$det[$i]->{'unit_name'}."',
                  inv_item_price = '".$unit_sale_price."',
                  item_purchase_price = '".$unit_avg_cost."',    
                  inv_item_subTotal = '".$det[$i]->{'sub_total'}."',    
                  inv_item_discount = '".$this->discount($det[$i])."'
                  ");

                                  
                  if($data["so_paid"] == $data["so_total"]){
                      $acc_receiveable = -1;
                  }
                    if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                  $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$invoice_id."', qty='".-1*$det[$i]->{'item_quantity'}."',conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$warehouse ."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='1',invoice_status='{{SALE RETURN}}',inv_date='".date($data["so_datetime_hidden"])."' "); 
                     if($det[$i]->{'bonus_quantity'} !=0 && $det[$i]->{'bonus_quantity'} !='')
                  {
                     $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$invoice_id."', qty='".-1*$det[$i]->{'bonus_quantity'}."',conv_from='1', warehouse_id  = '".$warehouse ."',unit_id='1',invoice_type='11',invoice_status='{{SALE RETURN B-Qty}}',inv_date='".date($data["so_datetime_hidden"])."' "); 

                  }
                   
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$salereturn_account."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_datetime_hidden"]."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");                                    
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_datetime_hidden"]."'"); 
                  
                  if($det[$i]->{'type'}==1) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_datetime_hidden"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',type='SALE_RET',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'");  
                  }
                  
                }
                if($discount!="0"){
                    $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Income on Sales Return' && acc_description='{{SALE_RETRUN_INCONE_ACCOUNT_SYSTEM}}'");
                    $discount_account = $query->row['acc_id'];
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$discount."', journal_details  = 'Sale Return Income',inv_id= -'".$invoice_id ."',currency_rate='1',type='SALE_RET_INCOME',currency_id='1', entry_date ='".$data["so_date_time"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".$discount."', journal_details  = 'Sale Return Income',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET_INCOME', entry_date ='".$data["so_date_time"]."'");
                }
              /*if($sale_id!=-1 && $data["so_paid"]>0){
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='-1', journal_amount='".-1*$data["so_paid"]."', journal_details  = 'Payment',inv_id= -'".$invoice_id ."',currency_rate='1',type='SALE_RET',currency_id='1', entry_date ='".$data["so_date_time"]."'"); 
                   $last_journal_id = (int)$this->db->getLastId();  
                   $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$data["so_paid"]."', journal_details  = 'Payment',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_date_time"]."'");                        
               }*/
              
              // End of Sale Return Check
          }  
          else if( isset($data['so_type']) && $data['so_type']=="2"){
                $inv_no = $this->getInvoiceNumber($data['so_hidden_id'],5);
                $mobile='';
               if(is_numeric($data["customer_mobile"]))
               {
                $mobile=$data["customer_mobile"];
               }
               else{
                $mobile='';
               }

                $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice SET
                          cust_id = '".$data["customer_id"]."',
                          invoice_date = '". $data["so_datetime_hidden"]."',
                          updated_date = '". $data["so_datetime_hidden"]."',    
                          invoice_no = '". $inv_no."',
                          paid_date  = '".$ydp.'-'.$mdp.'-'.$ddp."',
                          invoice_status = '".$data["so_status_val"]."',
                          invoice_type = '5',
                          in_print = '".$_is_print."',
                          cust_name    = '".$data["customer_contact"]."',
                          cust_mobile_no    = '".$mobile."',  
                          discount = '',  
                          discount_invoice = '".$data['so_discount_invoice']."',                        
                          in_email = '".$_is_email."',
                          previous_balance = '".$_previous_balance."',    
                          salesrep_id = '".$data['so_salesrep']."',
                          custom = '".$so_remarks."', 
                          invoice_name = '{{ESTIMATE}}',
                          invoice_total = '".$invoice_total."',
                          last_po_id ='".$last_po_id."'    
                      "); 
                $invoice_id = $this->db->getLastId();          
                for($i=0;$i<count($det);$i++){
                
                    
                $item_cost = $this->getPurchasePrice($det[$i]->{'item_id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                $unit_avg_cost = $item_avg_cost*$det[$i]->{'conv_from'};
                $unit_sale_price=0;
                if($det[$i]->{'unit_price'}>=$det[$i]->{'net_price'}){
                    $unit_sale_price = $det[$i]->{'unit_price'};
                }
                elseif($det[$i]->{'unit_price'}==0)
                {
                 $unit_sale_price = $det[$i]->{'sub_total'} / $det[$i]->{'item_quantity'};
                }

                 else {
                    $unit_sale_price = $det[$i]->{'net_price'};
                }
                
                $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                
                $total_asset = $det[$i]->{'item_quantity'}*$unit_sale_price;
                $total_cogs = $det[$i]->{'item_quantity'}*$unit_avg_cost;
                
                  if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 

                  $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET
                    inv_id = '".$invoice_id."',
                    inv_item_id = '".$det[$i]->{'item_id'}."',
                    inv_item_name = '".addslashes($det[$i]->{'item_name'})."',
                    item_quantity = '".$det[$i]->{'item_quantity'}."',
                    conv_from = '".$det[$i]->{'conv_from'}."',
                    inv_item_quantity = '".$item_qty."',
                    bonus_qty = '".$det[$i]->{'bonus_quantity'}."',
                    unit_id = '".$det[$i]->{'unit_id'}."',
                    warehouse_id = '".$warehouse."',
                    unit_name = '".$det[$i]->{'unit_name'}."',
                    inv_item_price = '".$unit_sale_price."',
                    item_purchase_price = '".$unit_avg_cost."', 
                    inv_item_subTotal = '".$det[$i]->{'sub_total'}."',      
                    inv_item_discount = '".$this->discount($det[$i])."'
                    ");  

              }
          }
          else {
            if(isset($data["so_estimate_id"]) && $data["so_estimate_id"]!=0){
                $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice WHERE invoice_id='".$data["so_estimate_id"]."'"); 
                $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id='".$data["so_estimate_id"]."'"); 
            }
            $inv_no = $this->getInvoiceNumber();
             $mobile='';
               if(is_numeric($data["customer_mobile"]))
               {
                $mobile=$data["customer_mobile"];
               }
               else{
                $mobile='';
               }
            $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice SET
                      cust_id = '".$data["customer_id"]."',
                      invoice_date = '". $data["so_datetime_hidden"]."',
                      updated_date = '". $data["so_datetime_hidden"]."',    
                      invoice_no = '". $inv_no."',
                      paid_date  = '".$ydp.'-'.$mdp.'-'.$ddp."',
                      invoice_status = '".$data["so_order_status"]."',
                      invoice_type = '2',
                      in_print = '".$_is_print."',
                      cust_name    = '".$data["customer_contact"]."',
                      cust_mobile_no    = '".$mobile."',    
                      discount = '',                        
                      discount_invoice = '".$data['so_discount_invoice']."',                        
                      invoice_paid = '".$data['so_paid']."',                        
                      in_email = '".$_is_email."',
                      previous_balance = '".$_previous_balance."',    
                      salesrep_id = '".$data['so_salesrep']."',
                      custom = '".$so_remarks."',   
                      invoice_name = '{{Sales Order}}',
                      invoice_total = '".$invoice_total."',
                      last_po_id ='".$last_po_id."'    
                  "); 
            $invoice_id = $this->db->getLastId();          
            if($data["so_order_status"]>=2){
              for($i=0;$i<count($det);$i++){
                
                $item_cost = $this->getPurchasePrice($det[$i]->{'item_id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                $unit_avg_cost = $item_avg_cost*$det[$i]->{'conv_from'};
                $unit_sale_price=0;
                if($det[$i]->{'unit_price'}>=$det[$i]->{'net_price'}){
                    $unit_sale_price = $det[$i]->{'unit_price'};
                }
                elseif($det[$i]->{'unit_price'}==0)
                {
                 $unit_sale_price = $det[$i]->{'sub_total'} / $det[$i]->{'item_quantity'};
                }

                 else {
                    $unit_sale_price = $det[$i]->{'net_price'};
                }
                $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                
                $total_asset = $det[$i]->{'item_quantity'}*$unit_sale_price;
                $total_cogs = $det[$i]->{'item_quantity'}*$unit_avg_cost;
                
                   if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  }

                  if($unit_avg_cost<=0 || $unit_avg_cost>$unit_sale_price)
                  {
                    $unit_avg_cost=$det[$i]->{'normal_price'};
                    $total_cogs = $det[$i]->{'item_quantity'}*$det[$i]->{'normal_price'};
                  }               
                $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET
                    inv_id = '".$invoice_id."',
                    inv_item_id = '".$det[$i]->{'item_id'}."',
                    inv_item_name = '".addslashes($det[$i]->{'item_name'})."',
                    item_quantity = '".$det[$i]->{'item_quantity'}."',
                    conv_from = '".$det[$i]->{'conv_from'}."',
                    inv_item_quantity = '".$item_qty."',
                    bonus_qty = '".$det[$i]->{'bonus_quantity'}."',
                    unit_id = '".$det[$i]->{'unit_id'}."',
                    warehouse_id = '".$warehouse."',
                    unit_name = '".$det[$i]->{'unit_name'}."',
                    inv_item_price = '".$unit_sale_price."',
                    item_purchase_price = '".$unit_avg_cost."',   
                    inv_item_subTotal = '".$det[$i]->{'sub_total'}."',    
                    inv_item_discount = '".$this->discount($det[$i])."'
                ");     
                  
                $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET 
                    item_id='".$det[$i]->{'item_id'}."',
                    inv_id='".$invoice_id."',
                    qty='".-1*$det[$i]->{'item_quantity'}."',
                    conv_from='".$det[$i]->{'conv_from'}."',
                    warehouse_id  = '".$warehouse."',
                    unit_id='".$det[$i]->{'unit_id'}."',
                    invoice_type='2',
                    invoice_status='{{Sale Order}}',
                    inv_date='".date('Y-m-d')."'
                ");  
                    if($det[$i]->{'bonus_quantity'} !=0 && $det[$i]->{'bonus_quantity'} !='')
                  {
                     $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$invoice_id."', qty='".$det[$i]->{'bonus_quantity'}."',conv_from='1', warehouse_id  = '".$warehouse ."',unit_id='1',invoice_type='10',invoice_status='{{SALE Order B-Qty}}',inv_date='".date($data["so_datetime_hidden"])."' "); 

                  }         
                    $acc_receiveable = $this->db->query("SELECT cust_acc_id FROM ".DB_PREFIX."customer WHERE cust_id='".$data["customer_id"]."'")->row['cust_acc_id'];

                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',type='S',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$sale_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$data["so_datetime_hidden"]."'"); 
                    
                    if($det[$i]->{'type'}==1) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',type='S',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$data["so_datetime_hidden"]."'"); 
                    }
                   

               }

               if($discount>0){
                   $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Discount' && acc_description='{{DISCOUNT_ACCOUNT_SYSTEM}}'");
                   $discount_account = $query->row['acc_id'];
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".$discount."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',type='DIS',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'"); 
                   $last_journal_id = (int)$this->db->getLastId();  
                   $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$discount."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='DIS', entry_date ='".$data["so_datetime_hidden"]."'");

               }
               if($sale_id!=-1 && $data["so_paid"]>0){

                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['so_payment_id']."', journal_amount='".$data["so_paid"]."', item_id='".$data["customer_id"]."', journal_details  = 'Payment',inv_id= -'".$invoice_id ."',currency_rate='1',type='CUST_PAYME',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'"); 

                   $last_journal_id = (int)$this->db->getLastId();  
                   $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', item_id='".$data["customer_id"]."', journal_amount='".-1*$data["so_paid"]."', journal_details  = 'Payment',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='CUST_PAYME', entry_date ='".$data["so_datetime_hidden"]."'"); 
                   $this->db->query("INSERT INTO " . DB_PREFIX . "invoice_payment SET
                      inv_id = '".$invoice_id."',
                      pay_method = '1',
                      pay_date = '". $data["so_datetime_hidden"]."',
                      pay_amount = '".$data["so_paid"]."',
                      pay_remarks = 'First Payment',
                      invoice_type = '2'
                  ");
                  if($data["customer_id"] !=0)
               {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "salesrep_detail SET 
                     salesrep_id='".$data["so_salesrep"]."',
                     ref_id='".$last_journal_id."',
                     type_id='1', 
                     payment_type='1',
                     updated_date ='".$data["so_datetime_hidden"]."'"); 
               }    
                   $expense = $this->enter_credit_expense($data['so_payment_id'],$data["so_paid"]);
                   if($expense){
                       $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Credit Card Expense' && acc_description='{{CREDIT_CARD_EXPENSE_ACCOUNT_SYSTEM}}'");
                       $expense_account = $query->row['acc_id'];
                       $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$expense_account."', journal_amount='".$expense."', journal_details  = 'Credit Card Charges',inv_id= -'".$invoice_id ."',currency_rate='1',type='C_E',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'"); 
                        $last_journal_id = (int)$this->db->getLastId();  
                        $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['so_payment_id']."', journal_amount='".-1*$expense."', journal_details  = 'Credit Card Charges',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='C_E', entry_date ='".$data["so_datetime_hidden"]."'"); 
                   }
               }
               
            } 
          }
          return array("invoice_id" => $invoice_id, "inv_no" => $inv_no);
        }
        
        private function discount($data){
            $discount = $data->{'discount'};
            if(!empty($data->{'discount_complete'})){
                $discount = $data->{'discount_complete'};
            }
            return $discount;
        }
        
        public function updateInvoice($data,$det,$pick_det){          
          $inv_id =0;  
          $update_date=date('Y-m-d H:i:s');
          $so_remarks = isset($data['so_remarks'])?$data['so_remarks']:NULL;
          list($dd, $md, $yd) = mb_split('[/.-]', $data["so_date"]);
          list($ddp, $mdp, $ydp) = mb_split('[/.-]', $data["so_due_date"]);
          $_is_print = (isset($data['so_allow_print']))?$data['so_allow_print']:0;
          $_is_email = (isset($data['so_allow_email']))?$data['so_allow_email']:0;       
          $_previous_balance = ($data['prev_total_balance']!=0)?$data['prev_total_balance']:0;
          $invoice_id = $data['so_hidden_id'];
          $invoice_total = $data["so_total"]-$data['so_discount_invoice'];
          $discount = $data['so_discount']+$data['so_discount_invoice'];
          $warehouse=0;
        
          if( isset($data['so_type']) && $data['so_type']=="1"){      
                    
              $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET
                      cust_id = '".$data["customer_id"]."',
                      invoice_name = '{{Sales Return}}',    
                      updated_date = '". $update_date."',
                      invoice_date = '". $data['so_date_time']."',
                      paid_date  = '".$ydp.'-'.$mdp.'-'.$ddp."',   
                      invoice_status = '".$data["so_status_val"]."',
                      invoice_total = '".$invoice_total."',
                      discount = '',
                      discount_invoice = '".$data['so_discount_invoice']."',                          
                      custom = '".$so_remarks."',
                      cust_name    = '".$data["customer_contact"]."',
                      cust_mobile_no    = '".$data["customer_mobile"]."',    
                      salesrep_id = '".$data['so_salesrep']."',
                      in_print = '".$_is_print."',
                      in_email = '".$_is_email."',
                      previous_balance = '".$_previous_balance."',        
                      invoice_paid = '".$data["so_paid"]."'
                       WHERE invoice_id='".$invoice_id."'
              ");  
               $sql = "SELECT date(invoice_date) AS date FROM ".DB_PREFIX."pos_invoice  WHERE invoice_id='".$invoice_id."' ";           
                  $old_date = $this->db->query($sql)->row['date'];
              $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail 
                          WHERE inv_id='".$invoice_id."'
                    "); 
             $this->db->query("DELETE FROM " . DB_PREFIX . "item_warehouse 
                          WHERE inv_id='".$invoice_id."' AND invoice_type='1'
                    ");
               $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal 
                          WHERE inv_id='-".$invoice_id."' and journal_details  != 'Payment'
              ");
                for($i=0;$i<count($det);$i++){
                
                $item_cost = $this->getPurchasePrice($det[$i]->{'item_id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                $unit_avg_cost = $item_avg_cost*$det[$i]->{'conv_from'};
                $unit_sale_price=0;
                if($det[$i]->{'unit_price'}>=$det[$i]->{'net_price'}){
                    $unit_sale_price = $det[$i]->{'unit_price'};
                }
                elseif($det[$i]->{'unit_price'}==0)
                {
                 $unit_sale_price = $det[$i]->{'sub_total'} / $det[$i]->{'item_quantity'};
                }

                 else {
                    $unit_sale_price = $det[$i]->{'net_price'};
                }
                
                
                $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                
                $total_asset = $det[$i]->{'item_quantity'}*$unit_sale_price;
                $total_cogs = $det[$i]->{'item_quantity'}*$unit_avg_cost;
                
                  if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
            $warehouse=1;
          } else{
            $warehouse=$det[$i]->{'ware_id'};
          }
                $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET
                  inv_id = '".$invoice_id."',
                  inv_item_id = '".$det[$i]->{'item_id'}."',
                  inv_item_name = '".$det[$i]->{'item_name'}."',
                  item_quantity = '".$det[$i]->{'item_quantity'}."',
                  conv_from = '".$det[$i]->{'conv_from'}."',
                  inv_item_quantity = '".$item_qty."',
                  unit_id = '".$det[$i]->{'unit_id'}."',
                  warehouse_id = '".$warehouse."',
                  unit_name = '".$det[$i]->{'unit_name'}."',
                  inv_item_price = '".$unit_sale_price."',
                  item_purchase_price = '".$unit_avg_cost."',  
                  inv_item_subTotal = '".$det[$i]->{'sub_total'}."',    
                  inv_item_discount = '".$this->discount($det[$i])."'
                  ");
                  

                  $sql = "SELECT cust_acc_id FROM ".DB_PREFIX."customer WHERE cust_id='".$data["customer_id"]."' ";           
                  $acc_receiveable = $this->db->query($sql)->row['cust_acc_id'];
                   $sql = "SELECT invoice_date FROM ".DB_PREFIX."pos_invoice WHERE invoice_id='".$invoice_id."' ";           
                  $invoice_date = $this->db->query($sql)->row['invoice_date'];

                  // $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='sr-".$invoice_id."', qty='".-1*$det[$i]->{'item_quantity'}."', conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$det[$i]->{'ware_id'} ."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='1',invoice_status='{{SALE RETURN}}',inv_date='".date('Y-m-d')."'"); 

                   
                  // $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$invoice_date."'"); 
                  // $last_journal_id = (int)$this->db->getLastId();  
                  // $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");                  
                  // if($sale_id==-1){
                  //       $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$sale_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$invoice_date."'"); 
                  //  }else{
                  //   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$invoice_date."'");   
                  //  }
                   
                  // $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$invoice_date."'"); 
                  // $last_journal_id = (int)$this->db->getLastId();  
                  // $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                  // $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',type='SALE_RET',currency_id='1', entry_date ='".$invoice_date."'");   
                   $salereturn_account = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Sales Return' && acc_description='{{SALE_RETURN_ACCOUNT_SYSTEM}}'")->row['acc_id'];
                $acc_receiveable = $this->db->query("SELECT cust_acc_id FROM ".DB_PREFIX."customer WHERE cust_id='".$data["customer_id"]."'")->row['cust_acc_id'];
                    if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                  $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$invoice_id."', qty='".-1*$det[$i]->{'item_quantity'}."',conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$warehouse ."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='1',invoice_status='{{SALE RETURN}}',inv_date='".$old_date."' "); 

                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$salereturn_account."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_datetime_hidden"]."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");                                    
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_datetime_hidden"]."'"); 
                  
                  if($det[$i]->{'type'}==1) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',currency_id='1',type='SALE_RET', entry_date ='".$data["so_datetime_hidden"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',type='SALE_RET',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'");  
                  }
              
                   }
                     if($discount!="0"){
                    $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Income on Sales Return' && acc_description='{{SALE_RETRUN_INCONE_ACCOUNT_SYSTEM}}'");
                    $discount_account = $query->row['acc_id'];
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$discount."', journal_details  = 'Sale Return Income',inv_id= -'".$invoice_id ."',currency_rate='1',type='SALE_RET_INCOME',currency_id='1', entry_date ='".$data["so_date_time"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".$discount."', journal_details  = 'Sale Return Income',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET_INCOME', entry_date ='".$data["so_date_time"]."'");
                }
            $inv_no =  $this->getInvoiceNumber($data['so_hidden_id'],4);
            
          }  
          else if( isset($data['so_type']) && $data['so_type']=="2"){

              $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET
                      cust_id = '".$data["customer_id"]."',
                      invoice_name = '{{Sales Order}}',    
                      updated_date = '". $data["so_datetime_hidden"]."',
                      invoice_date = '". $data['so_date_time']."',
                      paid_date  = '".$ydp.'-'.$mdp.'-'.$ddp."',  
                      invoice_status = '".$data["so_status_val"]."',
                      invoice_total = '".$invoice_total."',
                      discount = '',
                      discount_invoice = '".$data['so_discount_invoice']."',                          
                      custom = '".$so_remarks."',
                      salesrep_id = '".$data['so_salesrep']."',
                      in_print = '".$_is_print."',
                      in_email = '".$_is_email."',
                      cust_name    = '".$data["customer_contact"]."',
                      cust_mobile_no    = '".$data["customer_mobile"]."',    
                      previous_balance = '".$_previous_balance."',        
                      invoice_paid = '".$data["so_paid"]."'
                       WHERE invoice_id='".$invoice_id."'
                      "); 
                  
                    $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail 
                               WHERE inv_id='".$invoice_id."'
                         "); 
                      $this->db->query("DELETE FROM " . DB_PREFIX . "item_warehouse 
                          WHERE inv_id='".$invoice_id."' AND invoice_type='2'
                    ");
                    
                    for($i=0;$i<count($det);$i++){
                        $item_cost = $this->getPurchasePrice($det[$i]->{'item_id'}); 
                        $item_avg_cost=  $item_cost['avg_cost'];

                        $asset_id = $item_cost['asset_acc'];
                        $sale_id = $item_cost['sale_acc'];
                        $cogs_id = $item_cost['cogs_acc'];
                        
                        $unit_avg_cost = $item_avg_cost*$det[$i]->{'conv_from'};
                        $unit_sale_price=0;
                        if($det[$i]->{'unit_price'}>=$det[$i]->{'net_price'}){
                            $unit_sale_price = $det[$i]->{'unit_price'};
                        }
                        elseif($det[$i]->{'unit_price'}==0)
                        {
                         $unit_sale_price = $det[$i]->{'sub_total'} / $det[$i]->{'item_quantity'};
                        }

                         else {
                            $unit_sale_price = $det[$i]->{'net_price'};
                        }
                        
                        
                        $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                        
                        $total_asset = $det[$i]->{'item_quantity'}*$unit_sale_price;
                        $total_cogs = $det[$i]->{'item_quantity'}*$unit_avg_cost;
                        
                          if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                        $warehouse=1;
                      } else{
                        $warehouse=$det[$i]->{'ware_id'};
                      }
                          $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET
                          inv_id = '".$invoice_id."',
                          inv_item_id = '".$det[$i]->{'item_id'}."',
                          inv_item_name = '".addslashes($det[$i]->{'item_name'})."',
                          item_quantity = '".$det[$i]->{'item_quantity'}."',
                          conv_from = '".$det[$i]->{'conv_from'}."',
                          inv_item_quantity = '".$item_qty."',
                          unit_id = '".$det[$i]->{'unit_id'}."',
                          warehouse_id = '".$warehouse."',
                          unit_name = '".$det[$i]->{'unit_name'}."',
                          inv_item_price = '".$unit_sale_price."',
                          item_purchase_price = '".$unit_avg_cost."',   
                          inv_item_subTotal = '".$det[$i]->{'sub_total'}."',        
                          inv_item_discount = '".$this->discount($det[$i])."'
                          ");
                          
                    }
                    $inv_no =  $this->getInvoiceNumber($data['so_hidden_id'],5);
          }
          else{                            
            $this->initSales(); 
                         
            $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET
                      cust_id = '".$data["customer_id"]."',
                      invoice_name = '{{Sales Order}}',    
                      updated_date = '". $update_date."',
                      invoice_date = '". $data['so_date_time']."',
                      paid_date  = '".$ydp.'-'.$mdp.'-'.$ddp."',   
                      invoice_status = '".$data["so_status_val"]."',
                      invoice_total = '".$invoice_total."',
                      cust_name    = '".$data["customer_contact"]."',
                      cust_mobile_no    = '".$data["customer_mobile"]."',        
                      discount = '',
                      discount_invoice = '".$data['so_discount_invoice']."',                          
                      custom = '".$so_remarks."',                      
                      salesrep_id = '".$data['so_salesrep']."',
                      in_print = '".$_is_print."',
                      in_email = '".$_is_email."',                          
                      previous_balance = '".$_previous_balance."',        
                      invoice_paid = '".$data["so_paid"]."'
                       WHERE invoice_id='".$invoice_id."'
                      "); 
                 $sql = "SELECT date(invoice_date) AS date FROM ".DB_PREFIX."pos_invoice  WHERE invoice_id='".$invoice_id."' ";           
                  $old_date = $this->db->query($sql)->row['date'];
             $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail 
                        WHERE inv_id='".$invoice_id."'
                  "); 
                  $this->db->query("DELETE FROM " . DB_PREFIX . "item_warehouse 
                          WHERE inv_id='".$invoice_id."' AND invoice_type='2'
                    ");
               $sql = "SELECT count(*) AS found FROM ".DB_PREFIX."account_journal  WHERE acc_id='-1' AND type='CUST_PAYME' AND inv_id='-".$invoice_id."' ";   
               // echo $sql;exit;
               $found = $this->db->query($sql)->row['found'];
               if($found !='0')
               {
                       $sql = "SELECT ref_id FROM ".DB_PREFIX."account_journal  WHERE acc_id='-1' AND type='CUST_PAYME' AND inv_id='-".$invoice_id."' ";           
                  $old_refID = $this->db->query($sql)->row['ref_id']; 
               }  
               else{
                $old_refID=0;
               }
           

             $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal 
                        WHERE inv_id='-".$invoice_id."' ");

             $this->db->query("DELETE FROM " . DB_PREFIX . "invoice_payment 
                        WHERE inv_id='".$invoice_id."' ");
            for($i=0;$i<count($det);$i++){
                $item_cost = $this->getPurchasePrice($det[$i]->{'item_id'}); 
                        $item_avg_cost=  $item_cost['avg_cost'];

                        $asset_id = $item_cost['asset_acc'];
                        $sale_id = $item_cost['sale_acc'];
                        $cogs_id = $item_cost['cogs_acc'];
                        
                        $unit_avg_cost = $item_avg_cost*$det[$i]->{'conv_from'};
                        $unit_sale_price=0;
                        if($det[$i]->{'unit_price'}>=$det[$i]->{'net_price'}){
                            $unit_sale_price = $det[$i]->{'unit_price'};
                        }
                        elseif($det[$i]->{'unit_price'}==0)
                        {
                         $unit_sale_price = $det[$i]->{'sub_total'} / $det[$i]->{'item_quantity'};
                        }

                         else {
                            $unit_sale_price = $det[$i]->{'net_price'};
                        }
                        
                        
                        $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                        
                        $total_asset = $det[$i]->{'item_quantity'}*$unit_sale_price;
                        $total_cogs = $det[$i]->{'item_quantity'}*$unit_avg_cost;
                
                  if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
            $warehouse=1;
          } else{
            $warehouse=$det[$i]->{'ware_id'};
          }
                $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET
                  inv_id = '".$invoice_id."',
                  inv_item_id = '".$det[$i]->{'item_id'}."',
                  inv_item_name = '".addslashes($det[$i]->{'item_name'})."',
                  item_quantity = '".$det[$i]->{'item_quantity'}."',
                  conv_from = '".$det[$i]->{'conv_from'}."',
                  inv_item_quantity = '".$item_qty."',
                  unit_id = '".$det[$i]->{'unit_id'}."',
                  warehouse_id = '".$warehouse."',
                  unit_name = '".$det[$i]->{'unit_name'}."',
                  inv_item_price = '".$unit_sale_price."',
                  item_purchase_price = '".$unit_avg_cost."',    
                  inv_item_subTotal = '".$det[$i]->{'sub_total'}."',        
                  inv_item_discount = '".$this->discount($det[$i])."'
                  ");         
 

                  $sql = "SELECT cust_acc_id FROM ".DB_PREFIX."customer WHERE cust_id='".$data["customer_id"]."' ";           
                  $acc_receiveable = $this->db->query($sql)->row['cust_acc_id'];

                  $sql = "SELECT invoice_date FROM ".DB_PREFIX."pos_invoice WHERE invoice_id='".$invoice_id."' ";           
                  $invoice_date = $this->db->query($sql)->row['invoice_date'];
                    if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                   $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$invoice_id."', qty='".-1*$det[$i]->{'item_quantity'}."', conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$warehouse ."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='2',invoice_status='{{Sale Order}}',inv_date='".$old_date."'"); 

                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='S', entry_date ='".$invoice_date."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");                  
                  //if($sale_id==-1){
                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$sale_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$invoice_date."'"); 
                   //}else{
                     //$this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$data["so_date_time"]."'"); 
                   //}

                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',currency_id='1',type='S', entry_date ='".$invoice_date."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',type='S',currency_id='1', entry_date ='".$invoice_date."'"); 
                  
            }            
            if($discount>0){
                 $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Discount' && acc_description='{{DISCOUNT_ACCOUNT_SYSTEM}}'");
                 $discount_account = $query->row['acc_id'];
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".$discount."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',currency_rate='1',type='DIS',currency_id='1', entry_date ='".$invoice_date."'"); 
                 $last_journal_id = (int)$this->db->getLastId();  
                 $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$discount."', journal_details  = 'Sale Items',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='DIS', entry_date ='".$invoice_date."'");
                 
             }  

               if($sale_id!=-1 && $data["so_paid"]>0){

                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['so_payment_id']."', journal_amount='".$data["so_paid"]."', item_id='".$data["customer_id"]."', journal_details  = 'Payment',inv_id= -'".$invoice_id ."',currency_rate='1',type='CUST_PAYME',currency_id='1', entry_date ='".$data["so_datetime_hidden"]."'"); 

                   $last_journal_id = (int)$this->db->getLastId();  
                   $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', item_id='".$data["customer_id"]."', journal_amount='".-1*$data["so_paid"]."', journal_details  = 'Payment',inv_id= -'".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='CUST_PAYME', entry_date ='".$data["so_datetime_hidden"]."'"); 
                   $this->db->query("INSERT INTO " . DB_PREFIX . "invoice_payment SET
                      inv_id = '".$invoice_id."',
                      pay_method = '1',
                      pay_date = '". $data["so_datetime_hidden"]."',
                      pay_amount = '".$data["so_paid"]."',
                      pay_remarks = 'First Payment',
                      invoice_type = '2'
                  ");

                   $this->db->query("DELETE FROM " . DB_PREFIX . "salesrep_detail 
                        WHERE ref_id='".$old_refID."' ");
                   if($data["customer_id"] !=0)
               {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "salesrep_detail SET 
                     salesrep_id='".$data["so_salesrep"]."',
                     ref_id='".$last_journal_id."',
                     type_id='1', 
                     payment_type='1',
                     updated_date ='".$data["so_datetime_hidden"]."'"); 
               }          
               } 
             // $query = $this->db->query("SELECT pay_amount,pay_method,pay_date FROM ".DB_PREFIX."invoice_payment WHERE inv_id='".$data['so_hidden_id']."' AND invoice_type='2'");
             // $record = $query->rows;
             // for ($c=0; $c<count($record); $c++){
                 
             //     $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$record[$c]["pay_method"]."', journal_amount='".$record[$c]["pay_amount"]."', journal_details  = 'Payment',inv_id= -'".$data['so_hidden_id'] ."',currency_rate='1',type='S',currency_id='1', entry_date ='".$invoice_date."'"); 
             //     $last_journal_id = (int)$this->db->getLastId();  
             //     $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
             //     $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$record[$c]["pay_amount"]."', journal_details  = 'Payment',inv_id= -'".$data['so_hidden_id'] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$invoice_date."'"); 
                 
             //     //Credit card handling need to be done.
             // }
             
             
             $inv_no =  $this->getInvoiceNumber($data['so_hidden_id']);
          }                    
          return array("invoice_id" => $invoice_id, "inv_no" => $inv_no);
        }
        
        private function getInvoiceNumber($id=0,$type=2){
            $inv_no = 0;
            if($id==0){
                $query_item = $this->db->query("SELECT max(invoice_no) as inv_no FROM ".DB_PREFIX."pos_invoice WHERE invoice_type=".$type);
                $inv_no = $query_item->row['inv_no']+1;
            }
            else{
                $query_item = $this->db->query("SELECT invoice_no FROM ".DB_PREFIX."pos_invoice WHERE invoice_type=".$type." and invoice_id=".$id);                
                $inv_no = $query_item->row['invoice_no'];
            }
            
            return $inv_no;
        } 
       
        
        public function deleteInvoice($data){            
            
            $query_item = $this->db->query("SELECT inv_item_id as itemId, inv_item_price as unit_price, conv_from as conv_from FROM po_invoice_detail WHERE inv_id='".$data['selected']."'");
            $results = $query_item->rows;
            
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." pos_invoice_detail WHERE inv_id='".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." invoice_payment WHERE inv_id='".$data['selected']."' AND invoice_type='2'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." sale_pick WHERE so_id='".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." pos_invoice WHERE invoice_id='".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." account_journal WHERE inv_id='-".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." item_warehouse WHERE inv_id='".$data['selected']."' AND invoice_type='1'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." item_warehouse WHERE inv_id='".$data['selected']."' AND invoice_type='2'");

            foreach ($results as $result) {
                //$this->updateAvgCost($result['itemId']);
            }
            return $query;
            
        }

        public function deleteTransferInvoice($data)
        {
           $query = $this->db->query("DELETE FROM ".DB_PREFIX." stock_transfer WHERE invoice_no='".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." item_warehouse WHERE inv_id='".$data['selected']."' AND invoice_type='8'");
            return $query;
        }

        public function previousOrderId($id){
            $query = $this->db->query("SELECT invoice_id FROM " . DB_PREFIX . "pos_invoice WHERE invoice_id<'".$id."' and invoice_type='2' AND sale_return=0 ORDER BY invoice_id  DESC LIMIT 1"); 
            $pre_id = 0;
            if($query->num_rows){
                $pre_id = $query->row['invoice_id'];
            }
            return $pre_id;
        }
        public function nextOrderId($id){
            $query = $this->db->query("SELECT invoice_id FROM " . DB_PREFIX . "pos_invoice WHERE invoice_id>'".$id."' and invoice_type='2' AND sale_return=0 ORDER BY invoice_id  LIMIT 1"); 
            $next_id = 0;
            if($query->num_rows){
                $next_id = $query->row['invoice_id'];
            }
            return $next_id;
        }
        public function updateItemsCount($item_id,$count){
            $this->db->query("UPDATE " . DB_PREFIX . "item SET
                        quantity= quantity -".(int)$count." 
                        WHERE id='".$item_id."'
                    "); 
        }
        public function initSales(){
            //$this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice WHERE  invoice_status ='0' and invoice_type = '1'");      
        }
        public function getOrders($data){
                $search_string = '';
                if(isset($data['search'])){
                    $search_string = " ";
                    if(!empty($data['search_invoice_id'])){
                        $search_string .= "AND si.invoice_no = '".$data['search_invoice_id']."' ";
                    }
                    if($data['search_status']!='0'){
                        $search_string .= "AND si.invoice_status='".$data['search_status']."' ";
                    }
                    
                    if($data['search_customer']!='-1'){
                        $search_string .= " AND si.cust_id='".$data['search_customer']."'";
                    }
                 
                }
                $sale_invoice_search = "si.invoice_type='2' AND sale_return='0' ";
                if(isset($data['salereturn']) && $data['salereturn']=="1"){
                    $sale_invoice_search = "si.invoice_type='4' ";
                }
                else if(isset($data['salereturn']) && $data['salereturn']=="2"){
                    $sale_invoice_search = "si.invoice_type='5' ";
                }
                
    $sql = "SELECT si.*,c.cust_name,c.cust_id, si.cust_name as c_name  FROM ".DB_PREFIX."pos_invoice si
                        LEFT JOIN ".DB_PREFIX."customer c ON (c.cust_id = si.cust_id)
                        WHERE  ".$sale_invoice_search.$search_string ." ORDER BY invoice_id DESC"
            ;    
                // echo $sql;exit();
    $query = $this->db->query($sql);
    return $query->rows;
  }
        public function getSaleInvoice($inc_id){
    $sql = "SELECT sl.*,c.cust_name as c_name,c.cust_id as c_id,c.cust_address as cust_address, w.warehouse_name,cg.cust_group_name  FROM ".DB_PREFIX."pos_invoice sl
                        LEFT JOIN ".DB_PREFIX."customer c ON (c.cust_id = sl.cust_id)
                        LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id = sl.so_location_id)
                        LEFT JOIN ".DB_PREFIX."customer_groups cg ON (cg.id = c.cust_group_id)
                        WHERE  sl.invoice_id='".$inc_id['so_id']."' AND (sl.invoice_type='2' OR sl.invoice_type='4' OR sl.invoice_type='5') 
            ";
           
                $query = $this->db->query($sql);
                return $query->row;
  }
        public function getSaleInvoiceDetails($inc_id){
    $sql = "SELECT sid.*,i.item_name,u.name as unit_name, u.id as unit_id, (sid.inv_item_price*sid.inv_item_discount/100) as discount_price,w.warehouse_name AS w_name FROM ".DB_PREFIX."pos_invoice_detail sid
                        LEFT JOIN ".DB_PREFIX."item i ON (i.id = sid.inv_item_id)
                        LEFT JOIN ".DB_PREFIX."units u ON (u.id = sid.unit_id)
                        LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id = sid.warehouse_id)
                        WHERE sid.inv_id='".$inc_id['so_id']."'";
                $query = $this->db->query($sql);
    return $query->rows;
  }
        public function getSalePickDetails($inc_id){
            $sql = "SELECT sp.*,i.item_name,w.warehouse_name FROM ".DB_PREFIX."sale_pick sp
                        LEFT JOIN ".DB_PREFIX."item i ON (i.id = sp.pick_item_id)
                        LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id = sp.pick_warehouse)
                        WHERE sp.so_id='".$inc_id['so_id']."'
            ";
                $query = $this->db->query($sql);
    return $query->rows;
        }
        public function payInvoice($data){
           $payment_date = "";
           
           if(isset($data['invoice_id'])){               
               list($pay_date, $T) = mb_split('[T]', $data['payment_paid_date']);
               $payment_date = $pay_date;
           }
           else{
               list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_paid_date"]); 
               $payment_date = $yd.'-'.$md.'-'.$dd;
           }
               
                $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET invoice_paid=invoice_paid + '".$data["paid_total"]."' WHERE invoice_id='".$data["G_invoice_id"]."'");
                 $sql = "SELECT cust_acc_id FROM ".DB_PREFIX."customer
                              WHERE cust_id='".$data["G_vendor_id"]."' ";           
                 $acc_receiveable = $this->db->query($sql)->row['cust_acc_id'];       
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".$data["paid_total"]."', journal_details  = 'Payment',inv_id= -'".$data["G_invoice_id"] ."',currency_rate='1',type='S',currency_id='1', entry_date ='".$payment_date." ".$data["payment_time"]."'"); 
                 $last_journal_id = (int)$this->db->getLastId();  
                 $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$data["paid_total"]."', journal_details  = 'Payment',inv_id= -'".$data["G_invoice_id"] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$payment_date." ".$data["payment_time"]."'"); 
                 
                $expense = $this->enter_credit_expense($data['payment_method'],$data["paid_total"]);
                if($expense){                   
                    $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Credit Card Expense' && acc_description='{{CREDIT_CARD_EXPENSE_ACCOUNT_SYSTEM}}'");
                    $expense_account = $query->row['acc_id'];
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$expense_account."', journal_amount='".$expense."', journal_details  = 'Credit Card Charges',inv_id= -'".$data["G_invoice_id"] ."',currency_rate='1',type='C_E',currency_id='1', entry_date ='".$payment_date." ".$data["payment_time"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["payment_method"]."', journal_amount='".-1*$expense."', journal_details  = 'Credit Card Charges',inv_id= -'".$data["G_invoice_id"] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='C_E', entry_date ='".$payment_date." ".$data["payment_time"]."'"); 
                }
                 
             
          
          $pay_id = $this->db->getLastId();
          
          return $pay_id;
        }
        
        private function enter_credit_expense($id,$paid){
             $sql = "SELECT * FROM ".DB_PREFIX."credit_card_merchant                        
                        WHERE acc_id='".$id."'
            ";
             $query = $this->db->query($sql);
             $amount = 0;
             if ($query->num_rows) {
                $record = $query->row;
                $amount = $paid * ($record['percentage']/100);
             }
             return $amount;
        }
        
        public function getPayments($data){
            $sql = "SELECT * FROM ".DB_PREFIX."invoice_payment                        
                        WHERE inv_id='".$data['so_id']."' AND invoice_type='2'
            ";
                $query = $this->db->query($sql);
    return $query->rows;
        }
        
        public function getTotalPaid($so_id){
            $sql = "SELECT SUM(journal_amount) as amount FROM ".DB_PREFIX."account_journal                        
                        WHERE inv_id=".-1* $so_id." AND acc_id='-1' AND type IN('S','CUST_PAYME') AND journal_details='Payment' AND journal_amount>0";
            // echo $sql;exit;
                $query = $this->db->query($sql);
    return  $query->row['amount']==NULL ? 0: $query->row['amount'];
        }
        
        public function paymentDel($inc_id){
            $sql = "DELETE FROM ".DB_PREFIX."invoice_payment
                        WHERE  pay_id='".$inc_id['id']."' AND invoice_type='2'
            ";
            $query = $this->db->query($sql);
            return $query;
        }
        
        public function getBatchOrders($data){
                                
                $search_string = "WHERE 1 ";
                if(isset($data['search_from_date']) && isset($data['search_end_date'])){
                    $search_string .= " AND si.invoice_date >='". $data['search_from_date'] ."' AND si.invoice_date < '". $data['search_end_date'] ."' + interval 1 day";
                }                    

                if($data['search_customer']!='-1'){
                    $search_string .= " AND si.cust_id='".$data['search_customer']."'";
                }
                
                if($data['search_group']!='-1'){
                    $search_string .= " AND c.cust_group_id='".$data['search_group']."'";
                }
                
                if($data['search_type']!='-1'){
                    $search_string .= " AND c.cust_type_id='".$data['search_type']."'";
                }
                 
                
    $sql = "SELECT si.*,c.cust_name  FROM ".DB_PREFIX."pos_invoice si
                        LEFT JOIN ".DB_PREFIX."customer c ON (c.cust_id = si.cust_id)
                        ".$search_string." AND si.in_print='1' and si.invoice_type=2"
            ;                   
            // echo $sql;exit;
    $query = $this->db->query($sql);
    return $query->rows;
  }
        
        public function getSaleReturn($data){
                                
                $search_string = "WHERE 1 ";
                if(isset($data['search_from_date']) && isset($data['search_end_date'])){
                    $search_string .= " AND si.invoice_date >='". $data['search_from_date'] ."' AND si.invoice_date < '". $data['search_end_date'] ."' + interval 1 day";
                }                    

                if($data['search_customer']!='-1'){
                    $search_string .= " AND si.cust_id='".$data['search_customer']."'";
                }
                
                if($data['search_group']!='-1'){
                    $search_string .= " AND c.cust_group_id='".$data['search_group']."'";
                }
                
                if($data['search_type']!='-1'){
                    $search_string .= " AND c.cust_type_id='".$data['search_type']."'";
                }
                 
                
    $sql = "SELECT si.*,c.cust_name  FROM ".DB_PREFIX."pos_invoice si
                        LEFT JOIN ".DB_PREFIX."customer c ON (c.cust_id = si.cust_id)
                        ".$search_string." AND si.sale_return='0' AND invoice_type=2"
            ;                   
    $query = $this->db->query($sql);
    return $query->rows;
  }
        
        private function getPurchasePrice($item_id){
            $query = $this->db->query("SELECT sale_price, avg_cost,asset_acc,sale_acc,cogs_acc ,normal_price  FROM ".DB_PREFIX."item WHERE id='".$item_id."'");
            return $query->row;
        }
        
        public function getItemWeight($id){
            $sql = "SELECT weight FROM ".DB_PREFIX."item WHERE id='".$id."'";
                $query = $this->db->query($sql);
    return  $query->row['weight'] ==NULL?0:  $query->row['weight'];
        }

        public function getCustRegion($id)
        {
          $sql = "SELECT cust_group_id FROM ".DB_PREFIX."customer WHERE cust_id='".$id."'";
                $query = $this->db->query($sql);
    return  $query->row['cust_group_id'] ==NULL?0:  $query->row['cust_group_id'];
        }

        public function getTransferInvoice($inc_id)
        {
          $sql="SELECT st.*,fromWare.warehouse_name AS from_warehouse_name,Sto_warehouse.warehouse_name AS Sto_warehouse FROM `stock_transfer` st LEFT JOIN warehouses fromWare ON (st.from_warehouse=fromWare.warehouse_id) LEFT JOIN warehouses Sto_warehouse ON (Sto_warehouse.warehouse_id=st.to_warehouse) WHERE invoice_no=".$inc_id['so_id']."";
          $query = $this->db->query($sql);
                return $query->row;
        }

        public function nextStOrderId($id)
        {
          $query = $this->db->query("SELECT invoice_no FROM " . DB_PREFIX . "stock_transfer WHERE invoice_no>'".$id."' ORDER BY invoice_no  LIMIT 1"); 
            $next_id = 0;
            if($query->num_rows){
                $next_id = $query->row['invoice_no'];
            }
            return $next_id;
        }

        public function previousStOrderId($id)
        {
           $query = $this->db->query("SELECT invoice_no FROM " . DB_PREFIX . "stock_transfer WHERE invoice_no<'".$id."' ORDER BY invoice_no  DESC LIMIT 1"); 
            $pre_id = 0;
            if($query->num_rows){
                $pre_id = $query->row['invoice_no'];
            }
            return $pre_id;
        }

        public function getTransferInvoiceDetails($data)
        {
             $sql="SELECT st.item_id,st.qty,st.unit_id,SUM(i.sale_price*st.conv_from) AS price,i.item_name AS item_name,u.name AS unit_name FROM stock_transfer st left join item i on (i.id=st.item_id) left join units u on (u.id=st.unit_id) WHERE invoice_no=".$data['so_id']." GROUP BY st.item_id";
          $query = $this->db->query($sql);
                return $query->rows;
        }

        public function getStockTransferOrders($data)
        {
              $search_string = '';
                if($data['search']==1){
                    $search_string = "WHERE 1 ";
                    if(!empty($data['inv_no'])){
                        $search_string .= "AND st.invoice_no = '".$data['inv_no']."' ";
                    }
                    
                    if($data['search_warehouse']!='-1'){
                        $search_string .= " AND st.from_warehouse='".$data['search_warehouse']."'";
                    }
                 
                }
                
    $sql = "SELECT st.*,w.warehouse_name,w.warehouse_id  FROM ".DB_PREFIX."stock_transfer st
                        LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id = st.from_warehouse)
                          ".$search_string ." GROUP BY invoice_no ORDER BY invoice_no DESC"
            ;    
                // echo $sql;exit();
    $query = $this->db->query($sql);
    return $query->rows;
        }
        
        
                
}
?>
