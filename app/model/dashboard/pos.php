<?php
class ModelDashboardPos extends Model{
    public function save_invoice($data,$sale){
        if(isset($data['action'])){
            $this->posOpen();
            $last_id = 0;
            $inv_no = 0;
            $query = $this->db->query("SELECT max(invoice_id) as last_id FROM po_invoice");
            $last_po_id = $query->row['last_id']==NULL? 0: $query->row['last_id'];
            //echo $this->session->data;
            
            
            $user_id = $this->siteusers->getId();
                                    
            
            if($data['action']=='new'){

                $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice SET 
                    cust_id = '".$data["cust_id"]."',
                    invoice_name = '".$data["invoice_name"]."',
                    user_id  = '".$user_id."',
                    invoice_date = '".$data["invoice_date"]."',
                    updated_date = '".$data["invoice_date"]."',
                    invoice_status = '".$data["invoice_status"]."',
                    payment_method = '".$data["paymethod"]."',
                    invoice_type = '1',
                    last_po_id ='".$last_po_id."'
                     "); 
                usleep(200);
                $this->cache->delete('pos_invoice');
                $query = $this->db->query("SELECT max(invoice_id) as last_id FROM pos_invoice");
                $last_id = $query->row['last_id'];
                
          }
          else if($data['action']=='rename'){
            $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET                  
                    invoice_name = '".$data["invoice_name"]."',
                    updated_date = '".$data["invoice_date"]."'                
                    where invoice_id = '".$data["invoice_id"]."'
                    "); 
                $last_id = $this->db->getLastId();
                
          }
          else if($data['action']=='sale'){
            
               $inv_no =  $this->getInvoiceNumber($data["invoice_id"]);
               $this->db->query("UPDATE " . DB_PREFIX . "pos_invoice SET                  
                    invoice_total = '".$data["invoice_total"]."',
                    invoice_paid = '".$data["invoice_paid"]."',
                    invoice_no = '".$inv_no."',    
                    invoice_status = '".$data["invoice_status"]."',
                    updated_date = '".$data["invoice_date"]."'  ,
                    cust_id = '".$data["cust_id"]."',
                    last_po_id ='".$last_po_id."'
                    where invoice_id = '".$data["invoice_id"]."'
                    "); 
              $last_id = $this->db->getLastId();
            

              $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail WHERE  inv_id ='".$data['invoice_id']."'");
              for($i=0;$i<count($sale);$i++){

                     $item_cost = $this->getPurchasePrice($sale[$i]->{'id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];
                $item_sale_price=  $item_cost['sale_price'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                $unit_avg_cost = $item_avg_cost*$sale[$i]->{'conv_from'};
                // $unit_sale_price = $sale[$i]->{'unit_price'};

                  $item_quantity = $sale[$i]->{'quantity'}*$sale[$i]->{'conv_from'};
                  $inv_item_subTotal = $sale[$i]->{'quantity'}*$sale[$i]->{'price'};
                   $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET 
                    inv_id = '".$data["invoice_id"]."',
                    inv_item_id = '".$sale[$i]->{'id'}."',
                    inv_item_name = '".$this->db->escape($sale[$i]->{'name'})."',
                    item_quantity = '".$sale[$i]->{'quantity'}."',
                    conv_from = '".$sale[$i]->{'conv_from'}."',
                    inv_item_quantity = '".$item_quantity."',
                    unit_id = '".$sale[$i]->{'uom_unit'}."',
                    warehouse_id = '1',
                    unit_name = '".$sale[$i]->{'unit_name'}."',
                    inv_item_price = '".$sale[$i]->{'a_price'}."',
                    item_purchase_price = '".$unit_avg_cost."',
                    inv_item_discount = '".$sale[$i]->{'discount'}."',
                    inv_item_subTotal = '".$inv_item_subTotal."'
                    "); 
              }
          }
          else if($data['action']=='complete'){
           $discount_on_invoice = 0;
           if($data['salereturn']=="false"){  
               
            $sql="UPDATE " . DB_PREFIX . "pos_invoice SET                                      
                    invoice_status = '".$data["invoice_status"]."',
                    invoice_total = '".$data["invoice_total"]."',
                    salesrep_id='".$data["sale_rep"]."',
                    cust_id = '".$data["cust_id"]."',
                    invoice_paid = '".$data["invoice_paid"]."',
                    discount = '".$data["discount"]."',    
                    discount_invoice = '".$data["discount_invoice"]."',    
                    invoice_date = '".$data["invoice_date"]."',
                    updated_date = '".$data["invoice_date"]."',
                    last_po_id ='".$last_po_id."'
                    where invoice_id = '".$data["invoice_id"]."'
                    ";
                    // echo $sql;exit;                                     
            $last_id = $this->db->getLastId();
                $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal 
                    WHERE inv_id='-".$data["invoice_id"]."'
                ");
                for($i=0;$i<count($sale);$i++){
                // Journal Entries 
                      $item_cost = $this->getPurchasePrice($sale[$i]->{'id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                  $unit_avg_cost = $item_avg_cost*$sale[$i]->{'conv_from'};
                    $total_asset = $sale[$i]->{'quantity'}*$sale[$i]->{'a_price'}; 
                    $item_quantity = $sale[$i]->{'quantity'}*$sale[$i]->{'conv_from'};
                     $total_cogs = $sale[$i]->{'quantity'}*$unit_avg_cost;
                    $sql = "SELECT cust_acc_id FROM ".DB_PREFIX."customer
                                WHERE cust_id='".$data["cust_id"]."' ";           
                    $acc_receiveable = $this->db->query($sql)->row['cust_acc_id'];
                    $pay_account = 0;
                    if($acc_receiveable=="-1" && $data['pay_method']!="-1"){
                        $pay_account = $data['pay_method'];
                    }
                    else{
                        $pay_account = $acc_receiveable;
                    }
                                        
                      $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$sale[$i]->{'id'}."',inv_id='".$data["invoice_id"]."', qty='".-1*$sale[$i]->{'quantity'}."', conv_from='".$sale[$i]->{'conv_from'}."', warehouse_id  = '1',unit_id='".$sale[$i]->{'uom_unit'}."',invoice_type='2',invoice_status='{{Sale Order}}',inv_date='".date('Y-m-d')."'"); 

                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$pay_account."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$data["invoice_id"] ."',item_id='".$sale[$i]->{'id'}."',currency_rate='1',type='POS',currency_id='1', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$sale_id."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$data["invoice_id"] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='POS', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 

                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$data["invoice_id"] ."',currency_rate='1',currency_id='1',type='POS', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$data["invoice_id"] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='POS', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                }
                $discount_on_invoice = $discount_on_invoice + $data["discount_invoice"] ;
                for($i=0;$i<count($sale);$i++){
                    $discount_on_invoice = $discount_on_invoice + (($sale[$i]->{'a_price'}*($sale[$i]->{'discount'}/100)) * $sale[$i]->{'quantity'}) ;                   
                }
                if($discount_on_invoice>0){
                   $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Discount' && acc_description='{{DISCOUNT_ACCOUNT_SYSTEM}}'");
                   $discount_account = $query->row['acc_id'];
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".$discount_on_invoice."', journal_details  = 'Sale Items',inv_id= -'".$data["invoice_id"] ."',currency_rate='1',type='DIS',currency_id='1', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                   $last_journal_id = (int)$this->db->getLastId();  
                   $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$pay_account."', journal_amount='".-1*$discount_on_invoice."', journal_details  = 'Sale Items',inv_id= -'".$data["invoice_id"] ."',ref_id='".$last_journal_id."', user_id  = '".$user_id."',currency_rate='1',currency_id='1',type='DIS', entry_date ='".$data["invoice_date"]."'");
               }
               
                if($acc_receiveable!=-1 && $data['pay_method']!=0){
                   if($data["invoice_paid"]!="0"){
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data['pay_method']."', journal_amount='".$data["invoice_paid"]."', journal_details  = 'Payment',inv_id= -'".$data["invoice_id"] ."',currency_rate='1',type='S',currency_id='1', entry_date ='".$data["invoice_date"]."'"); 
                   $last_journal_id = (int)$this->db->getLastId();  
                   $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$data["invoice_paid"]."', journal_details  = 'Payment',inv_id= -'".$data["invoice_id"] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$data["invoice_date"]."'"); 
                   $this->db->query("INSERT INTO " . DB_PREFIX . "invoice_payment SET
                      inv_id = '".$data["invoice_id"]."',
                      pay_method = '1',
                      pay_date = '". $data["invoice_date"]."',
                      pay_amount = '".$data["invoice_paid"]."',
                      pay_remarks = 'First Payment from POS',
                      invoice_type = '2'
                  ");    
                 }

                }
               
               if($acc_receiveable==-1 && $data['pay_method']!="-1"){
                    $expense = $this->enter_credit_expense($data['pay_method'],$data["invoice_paid"]);
                    if($expense){                   
                        $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Credit Card Expense' && acc_description='{{CREDIT_CARD_EXPENSE_ACCOUNT_SYSTEM}}'");
                        $expense_account = $query->row['acc_id'];
                         $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$expense_account."', journal_amount='".$expense."', journal_details  = 'Credit Card Charges',inv_id= -'".$data["invoice_id"] ."',currency_rate='1',type='C_E',currency_id='1', entry_date ='".$data["invoice_date"]."'"); 
                         $last_journal_id = (int)$this->db->getLastId();  
                         $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                         $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["pay_method"]."', journal_amount='".-1*$expense."', journal_details  = 'Credit Card Charges',inv_id= -'".$data["invoice_id"] ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='C_E', entry_date ='".$data["invoice_date"]."'"); 
                    }
               }
           }
           else{                
                $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice SET 
                    cust_id = '".$data["cust_id"]."',
                    salesrep_id='".$data["sale_rep"]."',
                    invoice_name = 'Sale Return',
                    invoice_date = '".$data["invoice_date"]."',
                    discount = '".$data["discount"]."',    
                    invoice_no = '".$data["invoice_no"]."',    
                    invoice_total = '".($data["invoice_total"]*-1)."',
                    invoice_paid = '".$data["invoice_paid"]."',                        
                    updated_date = '".$data["invoice_date"]."',
                    invoice_status = '".$data["invoice_status"]."',
                    payment_method = '".$data["paymethod"]."',
                    invoice_type = '3',
                    sale_return = '1',
                    last_po_id ='".$last_po_id."'
                    "); 
                
                $last_id = $this->db->getLastId();
                for($i=0;$i<count($sale);$i++){
                    $item_cost = $this->getPurchasePrice($sale[$i]->{'id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                  $unit_avg_cost = $item_avg_cost*$sale[$i]->{'conv_from'};
                    $total_asset = $sale[$i]->{'quantity'}*$sale[$i]->{'a_price'}; 
                    $item_quantity = $sale[$i]->{'quantity'}*$sale[$i]->{'conv_from'};
                     // $total_cogs = $sale[$i]->{'item_quantity'}*$unit_avg_cost;

                    $item_quantity = ($sale[$i]->{'quantity'}*-1)*($sale[$i]->{'conv_from'});
                    $inv_item_subTotal = ($sale[$i]->{'quantity'}*-1)*($sale[$i]->{'price'});
                        $this->db->query("INSERT INTO " . DB_PREFIX . "pos_invoice_detail SET 
                         inv_id = '".$last_id."',
                         inv_item_id = '".$sale[$i]->{'id'}."',
                         inv_item_name = '".$this->db->escape($sale[$i]->{'name'})."',
                         item_quantity = '".($sale[$i]->{'quantity'}*-1)."',
                         conv_from = '".$sale[$i]->{'conv_from'}."',
                         inv_item_quantity = '".$item_quantity."',
                         unit_id = '".$sale[$i]->{'uom_unit'}."',
                         warehouse_id = '1',
                         unit_name = '".$sale[$i]->{'unit_name'}."',
                         inv_item_price = '".$sale[$i]->{'a_price'}."',
                         item_purchase_price = '".$item_avg_cost."',
                         inv_item_discount = '".$sale[$i]->{'discount'}."',
                         inv_item_subTotal = '".$inv_item_subTotal."'
                         "); 

                   $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$sale[$i]->{'id'}."',inv_id='".$last_id."', qty='".-1*$item_quantity."', conv_from='".$sale[$i]->{'conv_from'}."', warehouse_id  = '1',unit_id='".$sale[$i]->{'uom_unit'}."',invoice_type='1',invoice_status='{{Sale Return}}',inv_date='".date('Y-m-d')."'");      
                 }

                 $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Sales Return' && acc_description='{{SALE_RETURN_ACCOUNT_SYSTEM}}'");
                 $salereturn_account = $query->row['acc_id'];
                 $sql = "SELECT cust_acc_id FROM ".DB_PREFIX."customer
                            WHERE cust_id='".$data["cust_id"]."' ";           
                $acc_receiveable = $this->db->query($sql)->row['cust_acc_id'];  
                 for($i=0;$i<count($sale);$i++){
                // Journal Entries 
                    // $total_asset = $sale[$i]->{'quantity'}*$sale[$i]->{'a_price'};                
                    // $sql = "SELECT avg_cost,asset_acc,sale_acc,cogs_acc FROM ".DB_PREFIX."item
                    //             WHERE id='".$sale[$i]->{'id'}."' ";
                    // $asset_id = $this->db->query($sql)->row['asset_acc'];
                    // $sale_id = $this->db->query($sql)->row['sale_acc'];
                    // $cogs_id = $this->db->query($sql)->row['cogs_acc'];
                    // $total_cogs =($sale[$i]->{'quantity'}*-1)*($sale[$i]->{'normal_price'});
                    $item_cost = $this->getPurchasePrice($sale[$i]->{'id'}); 
                $item_avg_cost=  $item_cost['avg_cost'];

                $asset_id = $item_cost['asset_acc'];
                $sale_id = $item_cost['sale_acc'];
                $cogs_id = $item_cost['cogs_acc'];
                
                  $unit_avg_cost = $item_avg_cost*$sale[$i]->{'conv_from'};
                    $total_asset = $sale[$i]->{'quantity'}*$sale[$i]->{'a_price'}; 
                    $item_quantity = $sale[$i]->{'quantity'}*$sale[$i]->{'conv_from'};
                     $total_cogs = $sale[$i]->{'quantity'}*$unit_avg_cost;

                                      
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$salereturn_account."', journal_amount='".$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$last_id ."',item_id='".$sale[$i]->{'id'}."',currency_rate='1',type='POS_RET',currency_id='1', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".-1*$total_asset."', journal_details  = 'Sale Items',inv_id= -'".$last_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='POS_RET', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 

                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$last_id ."',currency_rate='1',currency_id='1',type='POS_RET', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_cogs."', journal_details  = 'Sale Items',inv_id= -'".$last_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='POS_RET', user_id  = '".$user_id."', entry_date ='".$data["invoice_date"]."'"); 
                }
                $discount_on_invoice = $discount_on_invoice + $data["discount_invoice"] ;
                for($i=0;$i<count($sale);$i++){
                    $discount_on_invoice = $discount_on_invoice + (($sale[$i]->{'a_price'}*($sale[$i]->{'discount'}/100))*$sale[$i]->{'quantity'});                   
                }
                 if($discount_on_invoice>0){
                    $query = $this->db->query("SELECT acc_id FROM ".DB_PREFIX."account_chart WHERE acc_name='Income on Sales Return' && acc_description='{{SALE_RETRUN_INCONE_ACCOUNT_SYSTEM}}'");
                    $discount_account = $query->row['acc_id'];
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_receiveable."', journal_amount='".$discount_on_invoice."', journal_details  = 'Sale Return Income',inv_id= -'".$last_id ."',currency_rate='1',type='SALE_RET_INCOME',currency_id='1', entry_date ='".$data["invoice_date"]."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$discount_account."', journal_amount='".-1*$discount_on_invoice."', journal_details  = 'Sale Return Income',inv_id= -'".$last_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='SALE_RET_INCOME', entry_date ='".$data["invoice_date"]."'");

              }
           }
                
          }
          else if($data['action']=='del_invoice'){
               $query_item = $this->db->query("SELECT inv_item_id as itemId, inv_item_price as unit_price, conv_from as conv_from FROM po_invoice_detail WHERE inv_id='".$data['invoice_id']."'");
               $results = $query_item->rows; 
               
               $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice WHERE  invoice_id ='".$data['invoice_id']."'");               
               $last_id = $this->db->getLastId();
               
               $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice_detail WHERE inv_id ='".$data['invoice_id']."'");
               
               $query = $this->db->query("DELETE FROM ".DB_PREFIX." account_journal
            WHERE inv_id='-".$data['invoice_id']."'");
            
                foreach ($results as $result) {
                    $this->updateAvgCost($result['itemId']);
                }

           }                
        }
        
        return array("last_id" => $last_id, "inv_no" => $inv_no);
    } 
    
    private function getInvoiceNumber($id=0){
        $inv_no = 0;
        $query_item = $this->db->query("SELECT invoice_no FROM ".DB_PREFIX."pos_invoice where invoice_id=".$id);
        if($query_item->num_rows>0){
            $inv_no = $query_item->row['invoice_no'];                
            if($inv_no==0){                                
                $query = $this->db->query("SELECT max(invoice_no) as inv_no FROM ".DB_PREFIX."pos_invoice WHERE invoice_type=1 ");
                $inv_no = $query->row['inv_no']+1;
            }
        }            
        return $inv_no;
    }
     
    public function lastCompleted(){
          $query = $this->db->query("SELECT (invoice_total-discount_invoice) as inv_amount FROM ".DB_PREFIX."pos_invoice WHERE updated_date = (select MAX(`updated_date`) FROM ".DB_PREFIX."pos_invoice WHERE invoice_type=1 AND invoice_status>=2 AND user_id='".$this->siteusers->getId()."' )");
          $last_compeleted_amount = $query->num_rows?$query->row['inv_amount']:0;          
          return $last_compeleted_amount==NULL?0:$last_compeleted_amount;
    }
    
    public function get_SaleInvoiceNo(){
          $query = $this->db->query("SELECT count(*) as inv_no FROM ".DB_PREFIX."pos_invoice WHERE invoice_type=3 and invoice_status>0 ");
          $inv_no = $query->row['inv_no']+1;          
          return array("inv_no" => $inv_no);
    }
    
         private function updateAvgCost($item_id){            
            $sql = "SELECT pd.inv_item_quantity as qty,pd.inv_item_price as price,inv.invoice_date as p_date,inv.invoice_id as inv_id FROM ".DB_PREFIX."po_invoice_detail as pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE  pd.inv_item_id='".$item_id."'";
            $query = $this->db->query($sql);
            $record = $query->rows;
            
            $query = $this->db->query("SELECT quantity,avg_cost,normal_price FROM ".DB_PREFIX."item WHERE id='".$item_id."'");
            $r_count = $query->row['quantity']==NULL?0:$query->row['quantity'];
            $avg_rate = $query->row['normal_price'];
            $purchase_count = $r_count;
            $query = $this->db->query("SELECT sum(qty) as qty FROM ".DB_PREFIX."stock_adjust WHERE item_id='".$item_id."'");
            $adjust_qty = $query->row['qty']==NULL?0:$query->row['qty'];
            $purchase_count = $r_count +$adjust_qty;
            for ($c=0; $c<count($record); $c++){
                                
                $query = $this->db->query("SELECT sum(pid.inv_item_quantity) as qty FROM ".DB_PREFIX."pos_invoice_detail pid
                          LEFT JOIN ".DB_PREFIX."pos_invoice p ON (p.invoice_id = pid.inv_id)  
                          WHERE pid.inv_item_id='".$item_id."' AND p.last_po_id<'".$record[$c]["inv_id"]."'");
                $sold=$query->row['qty']==NULL?0:$query->row['qty'];
                $rem = $purchase_count - $sold;
                $avg_rate = ($rem*$avg_rate + $record[$c]["qty"]*$record[$c]["price"])/($rem+$record[$c]["qty"]);
                
                $purchase_count = $purchase_count+$record[$c]["qty"];
            }
            $this->db->query("UPDATE ".DB_PREFIX."item SET avg_cost='".number_format($avg_rate,2,'.','')."' WHERE id='".$item_id."'");
        }
    
    public function initSales(){
        $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice WHERE  invoice_status ='0' and invoice_type = '1' and user_id='".$this->siteusers->getId()."'");      
    }
    
    public function  get_invoices(){
         $query = $this->db->query("SELECT pos_inv.*,cust.cust_name  as customer_name FROM " . DB_PREFIX . "pos_invoice as pos_inv 
                LEFT JOIN ".DB_PREFIX."customer cust ON (pos_inv.cust_id = cust.cust_id)
                    WHERE pos_inv.invoice_status!='0' AND pos_inv.invoice_type='1' AND sale_return=0 
                    ORDER BY pos_inv.invoice_date DESC"); 
         return $query->rows;
    }
    
    public function get_invoice($id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pos_invoice
                 WHERE invoice_id='".$id."'");
        return $query->row;
    }
    public function get_invoice_detail($id){
        $query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "pos_invoice_detail as pid
                 LEFT JOIN ".DB_PREFIX."item i ON (i.id = pid.inv_item_id)
                 WHERE pid.inv_id='".$id."'");
        return $query->rows;
    }
    public function getCategories($parent_id=-1){
        $search_parent = "";
        if($parent_id!=-1){
            $search_parent = " and parent_id='".$parent_id."'";
        }
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category 
     WHERE status = '1' ".$search_parent." ORDER BY id ASC"); 
    return $query->rows;
    }      
    
    public function getItems($cat_id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item 
     WHERE category_id='".$cat_id."' and item_status='1' ORDER BY sort_order ASC"); 
        
    return $query->rows;
    }
    public function getitemQuantity($data){
            $sql = "SELECT sum( quantity ) 
                    AS quantity 
                    FROM ". DB_PREFIX . "item WHERE id='".$data."'"; 
                $query = $this->db->query($sql);
    return $query->rows;
        }
    public function getUnits($data){
            $sql = "SELECT um.*,u.name as unit_name,u.id as unit_id FROM ".DB_PREFIX."unit_mapping um
                        LEFT JOIN ".DB_PREFIX."units u ON (um.unit_id = u.id) WHERE 
                        um.item_id='".$data."'"; 
                $query = $this->db->query($sql);
    return $query->rows;
        }
    public function searchItem($word){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item 
     WHERE item_name like '".$word."%' ORDER BY id ASC"); 
    return $query->rows;
    }
    public function getItem($barcode){
        $query = $this->db->query("SELECT ub.*,i.id as id, i.item_name as item_name, i.sale_price as sale_price, i.normal_price as normal_price, i.quantity as quantity, i.item_code as item_code, i.sale_unit as sale_unit FROM ".DB_PREFIX."uom_barcodes ub
                        JOIN ".DB_PREFIX."item i ON (ub.item_id = i.id) WHERE 
                        ub.barcode='".$barcode."'"); 
    return $query;
    }
    public function getItemById($id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item 
     WHERE id = '".$id."'"); 
    return $query;
    }
    public function getInvoiceNo(){
        $sql = "SHOW TABLE STATUS LIKE 'pos_invoice'";
        $query = $this->db->query($sql);   
        return $query->row['Auto_increment'];
    }
    
    public function delete_item_invoice($data){
        
        $query = $this->db->query("DELETE FROM ".DB_PREFIX."pos_invoice_detail
            WHERE inv_id='".$data['invoice_id']."' and inv_item_id='".$data['item_id']."'");
         
        return $query;
    }
    
    public function deleteInvoice($id){     
        $this->posOpen();
        $query_item = $this->db->query("SELECT inv_item_id as itemId, inv_item_price as unit_price, conv_from as conv_from FROM po_invoice_detail WHERE inv_id='".$id."'");
        $results = $query_item->rows;
            
        $query = $this->db->query("DELETE FROM ".DB_PREFIX."pos_invoice
            WHERE invoice_id='".$id."'");
        $query = $this->db->query("DELETE FROM ".DB_PREFIX."pos_invoice_detail
            WHERE inv_id='".$id."'");
        $query = $this->db->query("DELETE FROM ".DB_PREFIX." account_journal
            WHERE inv_id='-".$id."'");
            
        foreach ($results as $result) {
            $this->updateAvgCost($result['itemId']);
        }
        
        return $query;
    }
    public function setItemCategory(){       
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item 
     ORDER BY category_id ASC"); 
        return $query->rows;
    }
    public function updateOrder($order,$id){       
         $this->db->query("UPDATE ". DB_PREFIX ."item SET sort_order='".$order."'  WHERE id ='".$id."'");     
        
    }
    
    public function incrementOrder($data){
        $increment = 1;        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item  
                 WHERE id !='".$data['id']."' and category_id='".$data['cat_id']."' and sort_order >= '".$data['new_order']."'
     ORDER BY sort_order ASC"); 
        $results = $query->rows;
        
        foreach ($results as $result) {
            $this->db->query("UPDATE ". DB_PREFIX ."item SET sort_order='".(intval($data['new_order'])+$increment)."'  WHERE id ='".$result['id']."'");     
            $increment = $increment +1;
        }
        $this->db->query("UPDATE ". DB_PREFIX ."item SET sort_order='".$data['new_order']."'  WHERE id ='".$data['id']."'");     
    }
    
    public function decrementOrder($data){
        $increment = 1;        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item  
                 WHERE id !='".$data['id']."' and category_id='".$data['cat_id']."' and sort_order <= '".$data['new_order']."'
     ORDER BY sort_order DESC"); 
        $results = $query->rows;
        
        foreach($results as $result) {
            $this->db->query("UPDATE ". DB_PREFIX ."item SET sort_order='".(intval($data['new_order'])-$increment)."'  WHERE id ='".$result['id']."'");     
            $increment = $increment +1;
        }
        
        $this->db->query("UPDATE ". DB_PREFIX ."item SET sort_order='".$data['new_order']."'  WHERE id ='".$data['id']."'");     
    }
    
    public function get_all_items($data){
        $search_string = "AND 1";
        $searchLen=strlen($data['search']);
        
          if(isset($data['search'])){
            $search_string ="and item_name like '%".$data['search']."%'";
        }
        $count="SELECT COUNT(id) AS count FROM " . DB_PREFIX . "item  WHERE  item_status='1' ".$search_string."";
           $record = $this->db->query($count);
            $rec = $record->row['count']==NULL ? 0 :$record->row['count'];
            if($rec>50)
            {
                $query = $this->db->query("SELECT id,item_name,item_code,category_id,sort_order,type_id,quantity,sale_acc,cogs_acc,avg_cost,normal_price,sale_price,sale_unit,unit,asset_acc,item_status FROM " . DB_PREFIX . "item  WHERE  item_status='1' ".$search_string."                
     ORDER BY item_name ASC LIMIT 50");  
            }
            else{
                 $query = $this->db->query("SELECT id,item_name,item_code,category_id,sort_order,type_id,quantity,sale_acc,cogs_acc,avg_cost,normal_price,sale_price,sale_unit,unit,asset_acc,item_status FROM " . DB_PREFIX . "item  WHERE  item_status='1' ".$search_string."                
     ORDER BY item_name ASC"); 
            }
       
     
         
        return $query->rows;
    }
   private function getPurchasePrice($item_id){
            $query = $this->db->query("SELECT sale_price, avg_cost,asset_acc,sale_acc,cogs_acc ,normal_price  FROM ".DB_PREFIX."item WHERE id='".$item_id."'");
            return $query->row;
        }
   public function displayPool($data){
    if($data['command']=="price"){
      exec('java -jar C:\xampp\htdocs\inventory\application\pool.jar "'.$data['port'].'" "'.$data['command'].'" "'.$data['ttext'].': " "'.$data['total'].'" "'.$data['gtotal'].'"');
     }
     else if($data['command']=="sname"){
      
      exec('java -jar C:\xampp\htdocs\inventory\application\pool.jar "'.$data['port'].'" "'.$data['command'].'" "'.$data['p1'].'" "'.$data['p2'].'" "'.$data['p3'].'"');
     }
      else if($data['command']=="total"){
      exec('java -jar  C:\xampp\htdocs\inventory\application\pool.jar "'.$data['port'].'" "'.$data['command'].'" "'.$data['ttext1'].'" "'.$data['ttext2'].'" "'.$data['total'].'"');
     }
     else if($data['command']=="thank"){
      exec('java -jar C:\xampp\htdocs\inventory\application\pool.jar "'.$data['port'].'" "'.$data['command'].'" "'.$data['p1'].'" "'.$data['p2'].'" "'.$data['p3'].'"');
     }
   }
    public function get_purchase_items($item_id){                                    
           $sql = "SELECT sum( pd.inv_item_quantity ) 
                    AS qty 
                    FROM ". DB_PREFIX . "po_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND inv.invoice_status >= '2' ";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;
        }
        
        public function get_sale_items($item_id){            
            $sql = "SELECT sum( pd.inv_item_quantity ) 
                AS qty 
                FROM ". DB_PREFIX . "pos_invoice_detail AS pd
                LEFT JOIN " . DB_PREFIX . "pos_invoice inv ON ( pd.inv_id = inv.invoice_id )
                LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                WHERE i.id='".$item_id."'  AND inv.invoice_status >= '2' ";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        public function get_adjust_items($item_id){            
            $sql = "SELECT sum( qty ) 
                AS qty 
                FROM ". DB_PREFIX . "stock_adjust                            
                WHERE item_id='".$item_id."' ";
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        public function get_invoice_batch($data){     
            $search_filter = "AND pos_inv.invoice_type='1'";
            if(isset($data['filterBy'])){
                if($data['filterBy']=="-1"){
                        $search_filter .= "";
                }
                else if($data['filterBy']=="1"){
                    $search_filter .= " AND  pos_inv.invoice_status=1 ";
                }
                else if($data['filterBy']=="2"){
                    $search_filter .= " AND  pos_inv.invoice_status>1 ";
                }
                else if($data['filterBy']=="3"){
                    $search_filter = "AND pos_inv.invoice_type='3'";
                }
            }
            $search = "";
            if(isset($data['search']['value']) && !empty($data['search']['value'])){
                $search =" AND (pos_inv.invoice_name like '%".$data['search']['value']."%' OR cust.cust_name like '%".$data['search']['value']."%' OR pos_inv.invoice_no='".$data['search']['value']."' OR pos_inv.invoice_total='".$data['search']['value']."')";
            };
            $sql = "SELECT pos_inv.*,cust.cust_name  as customer_name FROM " . DB_PREFIX . "pos_invoice as pos_inv 
                LEFT JOIN ".DB_PREFIX."customer cust ON (pos_inv.cust_id = cust.cust_id)
                    WHERE pos_inv.invoice_status!='0' ".$search_filter." ".$search.$data['inprocess']." 
                    ORDER BY pos_inv.invoice_no DESC  LIMIT ".$data['start'].", ".$data['length'];
            $query = $this->db->query($sql); 
            
            
            return $query->rows;
            
        }
        
         public function total_invoices(){            
            $query = $this->db->query("SELECT count(*) as count FROM " . DB_PREFIX . "pos_invoice                 
                    WHERE invoice_status!='0' AND invoice_type='1' AND sale_return=0"); 
            return $query->row['count']==NULL ? 0 :$query->row['count'];
            
        }
        
        public function posOpen(){            
            $this->db->query("UPDATE ". DB_PREFIX ."siteusers SET pos_open='1'  WHERE su_id ='".$this->siteusers->getId()."'");     
        }
        public function resetPosOpen($data){
            $this->db->query("UPDATE ". DB_PREFIX ."siteusers SET pos_open='0'  WHERE su_id ='".$this->siteusers->getId()."'");  
            $this->db->query("DELETE FROM " . DB_PREFIX . "pos_invoice WHERE  invoice_status ='0' and invoice_type = '1'");      
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

           public function getTodaySale($date)
        {
          $total_ret=0;
          $no1=0;
          $sql="SELECT SUM(pd.inv_item_price*pd.item_quantity)AS sale, pd.inv_item_price * SUM(pd.inv_item_discount/100) * SUM(pd.item_quantity) AS discount, SUM(pd.inv_item_subTotal) AS sales, SUM(pd.item_purchase_price*pd.item_quantity) as item_cost,SUM(pd.item_quantity*pd.conv_from) AS s_qty FROM pos_invoice_detail AS pd LEFT JOIN pos_invoice inv ON ( pd.inv_id = inv.invoice_id ) LEFT JOIN item i ON ( pd.inv_item_id = i.id )  WHERE inv.invoice_status >= '2' AND inv.invoice_type !='3' AND  inv.invoice_date>='$date' AND inv.invoice_date < '$date' + interval 1 day ";
          // echo $sql;exit;
          $query = $this->db->query($sql);
          
          $query2 = $this->db->query("SELECT SUM(`discount_invoice`) AS discount_invoice FROM `pos_invoice` WHERE invoice_status >= '2' AND  invoice_date>='$date' AND invoice_date < '$date' + interval 1 day");
          $check="SELECT count(invoice_id) AS totRet FROM pos_invoice WHERE invoice_type='3' AND  invoice_date>='$date' AND invoice_date < '$date' + interval 1 day";
          // echo $check;exit;

          $chExe=$this->db->query($check);
          $chRow=$chExe->row;

          if($chRow['totRet']==0)
          {
          $total_ret=0; 
          }
          else{
            $sql1="SELECT SUM(pd.inv_item_price*pd.item_quantity)AS sale_return, pd.inv_item_price * SUM(pd.inv_item_discount/100) * SUM(pd.item_quantity) AS deduction, SUM(pd.inv_item_subTotal) AS sales, SUM(pd.item_purchase_price*pd.item_quantity) as item_cost,SUM(pd.item_quantity*pd.conv_from) AS s_qty FROM pos_invoice_detail AS pd LEFT JOIN pos_invoice inv ON ( pd.inv_id = inv.invoice_id ) LEFT JOIN item i ON ( pd.inv_item_id = i.id )  WHERE inv.invoice_status >= '2' AND inv.invoice_type='3' AND  inv.invoice_date>='$date' AND inv.invoice_date < '$date' + interval 1 day";
          // echo $sql1;exit;
          $query1 = $this->db->query($sql1);   
         //  foreach($query1 as $row1)
           $dataRet= $query1->row;
         // {
           $no1=$dataRet['sale_return'];
         // }
         
         $total_ret=$no1;
          }
         
          $query2 = $this->db->query("SELECT SUM(`discount_invoice`) AS discount_invoice FROM `pos_invoice` WHERE invoice_status = '2' AND  invoice_date>='$date' AND invoice_date < '$date' + interval 1 day");
           $query3 = $this->db->query("SELECT SUM(`discount_invoice`) AS deduction_invoice FROM `pos_invoice` WHERE invoice_status = '3' AND  invoice_date>='$date' AND invoice_date < '$date' + interval 1 day");
           $query4 = $this->db->query("SELECT SUM(`invoice_paid`) AS paidAmount FROM `pos_invoice` WHERE   invoice_date>='$date' AND invoice_date < '$date' + interval 1 day  AND invoice_status >1");
           $query5 = $this->db->query("SELECT SUM(`invoice_total`) AS UnpaidAmount FROM `pos_invoice` WHERE   invoice_date>='$date' AND invoice_date < '$date' + interval 1 day AND invoice_paid=0 AND invoice_status >1");
           // echo $query3;exit;
          $data= $query->row;
          $invoice_discount = $query2->row['discount_invoice'];
          $invoice_deduction = $query3->row['deduction_invoice']==NULL?0:$query3->row['deduction_invoice']; 
          $paidAmount = $query4->row['paidAmount']==NULL?0:$query4->row['paidAmount']; 
          $UnpaidAmount = $query5->row['UnpaidAmount']==NULL?0:$query5->row['UnpaidAmount']; 
          $no=0;
          $dis=0;
         // foreach($data as $row){
          $no=$data['sale'];
          $dis=$data['discount'];
         // }
         $total=$no-$dis;
         $total=$no;
         $discount=$dis;
           echo json_encode( $Sales = array( 'sale'    => number_format($total-$invoice_discount,2,'.',''),
                                            'ret_sale' => number_format($total_ret-$invoice_deduction,2,'.',''),
                                            'discount' => number_format($invoice_discount,2,'.',''),
                                            'deduction'=> number_format($invoice_deduction,2,'.',''),
                                            'paid'=> number_format($paidAmount+$total_ret+$invoice_deduction,2,'.',''),
                                            'unpaid'=> number_format($UnpaidAmount,2,'.','')
            ));
        }
}
?>
