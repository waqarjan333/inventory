<?php
class ModelDashboardPo extends Model{
        public function saveInvoice($data,$det){
          $po_remarks = isset($data["po_remarks"])?$data["po_remarks"]:NULL;  
          list($dd, $md, $yd) = mb_split('[/.-]', $data["po_date"]);
          list($ddp, $mdp, $ydp) = mb_split('[/.-]', $data["po_due_date"]);
          $warehouse=0;
          if( isset($data['po_type']) && $data['po_type']=="1"){ 
             $newPoTotal=0;
                  if($data["po_total"]>0)
                  {
                    $newPoTotal=-1*$data["po_total"];
                  }else{
                    $newPoTotal=$data["po_total"];
                  }
              if(isset($data["po_hidden_id"]) && $data["po_hidden_id"]!=0) {
                  $invoice_no = $this->getInvoiceNumber($data["po_hidden_id"],2);
                 
                  $this->db->query("UPDATE  " . DB_PREFIX . "po_invoice SET
                      vendor_id = '".$data["vendor_id"]."',    
                      invoice_type ='2',
                      invoice_date = '".$data["po_date"]." ".$data["po_time"]."',  
                      paid_date = '".$data["po_due_date"]."',
                      custom  = '".$po_remarks."',  
                      invoice_total = '".$newPoTotal."',
                      invoice_status = '".$data["po_status_val"]."'
                      WHERE invoice_id='".$data["po_hidden_id"]."'
                    ");  
                 $invoice_id = $data["po_hidden_id"];
              } else {
                 $invoice_no = $this->getInvoiceNumber(0,2);
                 $this->db->query("INSERT INTO " . DB_PREFIX . "po_invoice SET
                      vendor_id = '".$data["vendor_id"]."',
                      invoice_no ='".$invoice_no."',    
                      invoice_type ='2',
                      invoice_date = '".$data["po_date"]." ".$data["po_time"]."',  
                      paid_date = '".$data["po_due_date"]."',
                      custom  = '".$po_remarks."',  
                      invoice_total = '".$newPoTotal."',
                      invoice_status = '2'
                      ");  
                 $invoice_id = $this->db->getLastId();
              }
              
              
            $this->db->query("DELETE FROM " . DB_PREFIX . "po_invoice_detail WHERE inv_id='".$invoice_id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "po_receive WHERE po_id='".$invoice_id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "item_warehouse WHERE inv_id='".$invoice_id."' AND invoice_type='5'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE type='PO_RET' AND inv_id='".$invoice_id."'");
            
                for($i=0;$i<count($det);$i++){
                    
                    $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                    
                    if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                  $subTotal=$det[$i]->{'sub_total'};
                  $Newsubtotal=0;
                    if($subTotal>0)
                    {
                      $Newsubtotal=-1*$subTotal;
                    }
                    else{
                     $Newsubtotal=$subTotal; 
                    }
                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "po_invoice_detail SET
                      inv_id = '".$invoice_id."',
                      inv_item_id = '".$det[$i]->{'item_id'}."',
                      item_quantity = '".$det[$i]->{'item_quantity'}."',
                      conv_from = '".$det[$i]->{'conv_from'}."',
                      inv_item_quantity = '".$item_qty."',
                      bonus_qty = '".$det[$i]->{'bonus_quantity'}."',
                      unit_id = '".$det[$i]->{'unit_id'}."',
                      unit_name = '".$det[$i]->{'unit_name'}."',
                      warehouse_id = '".$warehouse."',
                      inv_item_price = '".$det[$i]->{'unit_price'}."',
                      inv_item_sprice = '".$det[$i]->{'sale_price'}."',
                      inv_item_discount = '".$det[$i]->{'discount'}."',
                      inv_item_subTotal = '".$Newsubtotal."'
                      ");             


                  
                  $item_result = $this->db->query("SELECT * FROM ".DB_PREFIX."item WHERE id='".$det[$i]->{'item_id'}."'");
                  $asset_id = $item_result->row['asset_acc'];
                  $cogs_id = $item_result->row['cogs_acc'];

  
                  $sql = "SELECT vendor_acc_id FROM ".DB_PREFIX."vendor WHERE vendor_id='".$data["vendor_id"]."' ";
                  $acc_payable = $this->db->query($sql)->row['vendor_acc_id'];
                  $total_asset = $Newsubtotal;
                                    $priceDiff=($det[$i]->{'unit_price'}/$det[$i]->{'conv_from'})-$item_result->row['normal_price'];
                        $total_cogs=$priceDiff*$item_qty;
                  $NewtotalAsset=$total_asset-$total_cogs; 
                  $convPrice=$det[$i]->{'conv_from'} * $item_result->row['normal_price'];   
                  if($det[$i]->{'unit_price'}!=$convPrice) {
                    if($det[$i]->{'unit_price'} < $convPrice)
                        {

                            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$NewtotalAsset."', journal_details  = 'Purchase Return',inv_id= '".$invoice_id."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='PO_RET', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_payable."', journal_amount='".-1*$total_asset."', journal_details  = 'Purchase Return Items',inv_id= '".$invoice_id."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='PO_RET', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 

                          $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Purchase Return Item When Price Low',inv_id= '".$invoice_id ."',currency_rate='1',type='PO_RET_A',currency_id='1', entry_date ='".$data["po_date"]." ".$data["po_time"]."'");  
                        }
                        else{
                          $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_asset."', journal_details  = 'Purchase Return',inv_id= '".$invoice_id."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='PO_RET', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_payable."', journal_amount='".-1*$total_asset."', journal_details  = 'Purchase Return Items',inv_id= '".$invoice_id."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='PO_RET', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 

                          $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$total_cogs."', journal_details  = 'Purchase Return Item When Price High',inv_id= '".$invoice_id ."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',type='PO_RET_A',currency_id='1', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 

                          $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$total_cogs."', journal_details  = 'Purchase Return Item When Price High',inv_id= '".$invoice_id ."',currency_rate='1',type='PO_RET_A',currency_id='1', entry_date ='".$data["po_date"]." ".$data["po_time"]."'");   
                        }
                  }else{
                     $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_asset."', journal_details  = 'Purchase Return',inv_id= '".$invoice_id."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='PO_RET', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 
                  $last_journal_id = (int)$this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                  $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_payable."', journal_amount='".-1*$total_asset."', journal_details  = 'Purchase Return Items',inv_id= '".$invoice_id."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='PO_RET', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 
                  }
                
                    if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                  $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$invoice_id."', qty='".$det[$i]->{'item_quantity'}."', conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$warehouse."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='5',invoice_status='{{Purchase Return}}',inv_date='".date('Y-m-d')."'"); 
                  // $this->db->query("UPDATE item SET normal_price='".$det[$i]->{'unit_price'}."' WHERE id='".$det[$i]->{'item_id'}."'");
                  //Purchase return fix
                  if($det[$i]->{'bonus_quantity'} !=0 && $det[$i]->{'bonus_quantity'} !='')
                  {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET 
                    item_id='".$det[$i]->{'item_id'}."',
                    inv_id='".$invoice_id."',
                    qty='".$det[$i]->{'bonus_quantity'}."',
                    conv_from='1', 
                    warehouse_id  = '".$warehouse."',
                    unit_id='1',
                    invoice_type='9',
                    invoice_status='{{Purchase Return B-Qty}}',
                    inv_date='".date('Y-m-d')."'
                "); 
                  }
                
                    $sql = "SELECT sum( pd.qty*pd.conv_from ) AS qty FROM ". DB_PREFIX . "item_warehouse AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )                  
                    WHERE pd.item_id=".$det[$i]->{'item_id'}."";
                   $query1 = $this->db->query($sql);
                   $qty=$query1->row['qty'];
                   $unit_price1=$det[$i]->{'unit_price'};
                   $unit_price = $det[$i]->{'unit_price'}/$det[$i]->{'conv_from'};
                   $sale_price = $det[$i]->{'sale_price'}/$det[$i]->{'conv_from'};
              $sql1 = "SELECT avg_cost,asset_acc,sale_acc,cogs_acc FROM ".DB_PREFIX."item
                                WHERE id='".$det[$i]->{'item_id'}."' ";
                    $asset_id = $this->db->query($sql1)->row['asset_acc'];
                    $sale_id = $this->db->query($sql1)->row['sale_acc'];
                    $cogs_id = $this->db->query($sql1)->row['cogs_acc'];
                    $cogs_cost = $this->db->query($sql1)->row['avg_cost']*$det[$i]->{'conv_from'};
                    $cogs_cost_per_unit = $this->db->query($sql1)->row['avg_cost'];
                     $total_cogs = $qty-$item_qty;
                     $qty1=0;
                       if($cogs_cost<$unit_price1 && $total_cogs<0)
                    {
                      
                      $cost=-1*($cogs_cost_per_unit-$unit_price);
                   
                      if($qty<0)
                      {
                         $net=number_format( $cost*$qty,2,'.','');
                      }
                      else{
                        $qty1=-1*($total_cogs);
                        $net=number_format($cost*$qty1,2,'.','');
                         
                      }
                    }
                     elseif($cogs_cost>$unit_price1 && $total_cogs<0){
                     
                     $cost=-1*($cogs_cost_per_unit-$unit_price);                                    

                         if($qty<0)
                      {
                        // $qty1=-1*($qty);
                         $net=number_format($cost*$qty,2,'.','');
                      }
                      else{
                        $qty1=-1*($total_cogs);
                         $net=number_format($cost*$qty1,2,'.','');
                      }
                     }
                    if($data['po_hidden_id']==0)
                    {
                    $this->updateAvgCost($det[$i]->{'item_id'},$unit_price,$sale_price,$det[$i]->{'item_quantity'},$det[$i]->{'conv_from'},$invoice_id,$data["po_date"],$cogs_cost,$total_cogs);  
                    }
                    else{
                        if(isset($sale_price) && $sale_price!=0){
                $saleprice_update = "sale_price='".$sale_price."'";
            }
                      $this->db->query("UPDATE ".DB_PREFIX."item SET normal_price='".$unit_price."',".$saleprice_update." WHERE id='".$det[$i]->{'item_id'}."'");  
                    }
                    }
                    
                }  
             
          else {
            
            if(isset($data["po_hidden_id"]) && $data["po_hidden_id"]!=0) {
               $sql = "SELECT (invoice_date) AS date FROM ".DB_PREFIX."po_invoice  WHERE  invoice_id='".$data["po_hidden_id"]."' "; 
             // echo $sql;exit;          
                  $old_date = $this->db->query($sql)->row['date'];
                $invoice_no = $this->getInvoiceNumber($data["po_hidden_id"]);
                $this->db->query("UPDATE " . DB_PREFIX . "po_invoice SET
                          vendor_id = '".$data["vendor_id"]."',
                          invoice_date = '".$old_date."',
                          invoice_status = '".$data["po_status_val"]."',
                          paid_date  = '".$data["po_due_date"]."',
                          custom  = '".$po_remarks."',
                          discount_invoice='".$data["po_discount_invoice"]."',      
                          invoice_total = '".$data["po_total"]."'
                          WHERE invoice_id='".$data["po_hidden_id"]."'
                          ");
                $invoice_id = $data["po_hidden_id"];
            } else {
               $invoice_no = $this->getInvoiceNumber(0);
               $this->db->query("INSERT INTO " . DB_PREFIX . "po_invoice SET
                    invoice_no ='".$invoice_no."',
                    invoice_type ='1',
                    vendor_id = '".$data["vendor_id"]."',
                    invoice_date = '".$data["po_date"]." ".$data["po_time"]."',
                    invoice_status = '".$data["po_status_val"]."',
                    discount_invoice='".$data["po_discount_invoice"]."',
                    invoice_total='".$data['po_total']."',
                    invoice_paid='".$data['po_paid']."',
                    paid_date  = '".$data["po_due_date"]."',  
                    custom  = '".$po_remarks."' 
                    "); 
                $invoice_id = $this->db->getLastId(); 
            }
            
             $sql = "SELECT (invoice_date) AS date FROM ".DB_PREFIX."po_invoice  WHERE  invoice_id='".$invoice_id."' "; 
             // echo $sql;exit;          
                  $old_date = $this->db->query($sql)->row['date'];
            $this->db->query("DELETE FROM " . DB_PREFIX . "po_invoice_detail WHERE inv_id='".$invoice_id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "po_receive WHERE po_id='".$invoice_id."'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "item_warehouse WHERE inv_id='".$invoice_id."' AND invoice_type='4'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "account_journal WHERE  inv_id='".$invoice_id."'");
            
            
            
            for($i=0;$i<count($det);$i++){
                $item_qty = ($det[$i]->{'item_quantity'})*($det[$i]->{'conv_from'});
                // echo $item_qty;exit;
                  if($det[$i]->{'ware_id'}==0 || $det[$i]->{'ware_id'}=="") {
                    $warehouse=1;
                  } else{
                    $warehouse=$det[$i]->{'ware_id'};
                  } 
                $this->db->query("INSERT INTO " . DB_PREFIX . "po_invoice_detail SET
                    inv_id = '".$invoice_id."',
                    inv_item_id = '".$det[$i]->{'item_id'}."',
                    item_quantity = '".$det[$i]->{'item_quantity'}."',
                    conv_from = '".$det[$i]->{'conv_from'}."',
                    inv_item_quantity = '".$item_qty."',
                    bonus_qty = '".$det[$i]->{'bonus_quantity'}."',
                    unit_id = '".$det[$i]->{'unit_id'}."',
                    unit_name = '".$det[$i]->{'unit_name'}."',
                    warehouse_id = '".$warehouse."',
                    inv_item_price = '".$det[$i]->{'unit_price'}."',
                    inv_item_sprice = '".$det[$i]->{'sale_price'}."',    
                    inv_item_discount = '".$det[$i]->{'discount'}."',
                    inv_item_subTotal = '".$det[$i]->{'sub_total'}."'
                "); 
                  
                $this->db->query("INSERT INTO " . DB_PREFIX . "po_receive SET
                    po_id = '".$invoice_id."',
                    rec_item_id = '".$det[$i]->{'item_id'}."', 
                    quantity='".$det[$i]->{'item_quantity'}."',
                    rec_quantity = '".$item_qty."',
                    rec_warehouse = '".$det[$i]->{'ware_id'}."',
                    rec_date = '".$data["po_date"]."',
                    rec_complete = '1'    
                "); 
                  
                  
                $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET 
                    item_id='".$det[$i]->{'item_id'}."',
                    inv_id='".$invoice_id."',
                    qty='".$det[$i]->{'item_quantity'}."',
                    conv_from='".$det[$i]->{'conv_from'}."', 
                    warehouse_id  = '".$warehouse  ."',
                    unit_id='".$det[$i]->{'unit_id'}."',
                    invoice_type='4',
                    invoice_status='{{Purchase Order}}',
                    inv_date='".$data["po_date"]."'
                ");  
                  if($det[$i]->{'bonus_quantity'} !=0 && $det[$i]->{'bonus_quantity'} !='')
                  {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET 
                    item_id='".$det[$i]->{'item_id'}."',
                    inv_id='".$invoice_id."',
                    qty='".$det[$i]->{'bonus_quantity'}."',
                    conv_from='1', 
                    warehouse_id  = '".$warehouse  ."',
                    unit_id='1',
                    invoice_type='8',
                    invoice_status='{{Purchase Order B-Qty}}',
                    inv_date='".$data["po_date"]."'
                "); 
                  }
                     

               $this->db->query("UPDATE " . DB_PREFIX . " item  SET 
                    vendor='".$data["vendor_id"]."'
                     WHERE id='".$det[$i]->{'item_id'}."'
                "); 
                
                    
                if($det[$i]->{'conv_from'}==1){
                    $this->db->query("UPDATE " . DB_PREFIX . "item SET 
                        sale_price=".$det[$i]->{'sale_price'}." 
                        WHERE id='".$det[$i]->{'item_id'}."'
                    ");    
                }
                
                    $this->db->query("UPDATE " . DB_PREFIX . "unit_mapping SET 
                        sale_price=".$det[$i]->{'sale_price'}." 
                        WHERE item_id='".$det[$i]->{'item_id'}."' 
                        AND unit_id='".$det[$i]->{'unit_id'}."'
                    ");
                        
               $unit_price = $det[$i]->{'unit_price'}/$det[$i]->{'conv_from'};
               $sale_price = $det[$i]->{'sale_price'}/$det[$i]->{'conv_from'};
               
               
              $total_asset =number_format( $det[$i]->{'sub_total'},2,'.','');//$rec_det[$i]->{'item_quantity'}*$det[$i]->{'unit_price'};
              $sql = "SELECT asset_acc FROM ".DB_PREFIX."item WHERE id='".$det[$i]->{'item_id'}."' ";
              $asset_id = $this->db->query($sql)->row['asset_acc'];
              $sql = "SELECT vendor_acc_id FROM ".DB_PREFIX."vendor WHERE vendor_id='".$data["vendor_id"]."'";
              $acc_payable = $this->db->query($sql)->row['vendor_acc_id'];
              $po_remarks = $po_remarks==""?"Items Received":$po_remarks;
              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_asset."', journal_details  = '".$po_remarks."',inv_id= '".$invoice_id."',item_id='".$det[$i]->{'item_id'}."',currency_rate='1',currency_id='1',type='P', entry_date ='".$old_date."'"); 
              $last_journal_id = (int)$this->db->getLastId();  
              $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_payable."', journal_amount='".-1*$total_asset."', journal_details  = '".$po_remarks."',inv_id= '".$invoice_id."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='P', entry_date ='".$old_date."' ");
              
              
              
              $sql = "SELECT sum( pd.qty*pd.conv_from ) AS qty FROM ". DB_PREFIX . "item_warehouse AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )                  
                    WHERE pd.item_id=".$det[$i]->{'item_id'}."";
                   $query1 = $this->db->query($sql);
                   $qty=$query1->row['qty'];
                   $unit_price1=$det[$i]->{'unit_price'};
              $sql1 = "SELECT avg_cost,asset_acc,sale_acc,cogs_acc FROM ".DB_PREFIX."item
                                WHERE id='".$det[$i]->{'item_id'}."' ";
                    $asset_id = $this->db->query($sql1)->row['asset_acc'];
                    $sale_id = $this->db->query($sql1)->row['sale_acc'];
                    $cogs_id = $this->db->query($sql1)->row['cogs_acc'];
                    $cogs_cost = $this->db->query($sql1)->row['avg_cost']*$det[$i]->{'conv_from'};
                    $cogs_cost_per_unit = $this->db->query($sql1)->row['avg_cost'];
                     $total_cogs = $qty-$item_qty;
                     $qty1=0;
                 // echo $cogs_cost .' '.$unit_price1; exit;
                if($cogs_cost<$unit_price1 && $total_cogs<0)
                    {
                      
                      $cost=-1*($cogs_cost_per_unit-$unit_price);
                      // echo $cost; exit;
                      // echo $unit_price1;exit;
                      if($qty<0)
                      {
                         $net=number_format( $cost*$qty,2,'.','');
                      }
                      else{
                        $qty1=-1*($total_cogs);
                        $net=number_format($cost*$qty1,2,'.','');
                         
                      }

                       
                              $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$net."', journal_details  = 'Sale Items',inv_id= '".$invoice_id ."',currency_rate='1',type='S',currency_id='1', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 
                            $last_journal_id = (int)$this->db->getLastId();  
                            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$net."', journal_details  = 'Sale Items',inv_id= '".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$data["po_date"]." ".$data["po_time"]."'");

                    }
                elseif($cogs_cost>$unit_price1 && $total_cogs<0){
                     
                     $cost=-1*($cogs_cost_per_unit-$unit_price);                                    

                         if($qty<0)
                      {
                        // $qty1=-1*($qty);
                         $net=number_format($cost*$qty,2,'.','');
                      }
                      else{
                        $qty1=-1*($total_cogs);
                         $net=number_format($cost*$qty1,2,'.','');
                      }

                        $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$cogs_id."', journal_amount='".$net."', journal_details  = 'Sale Items',inv_id= '".$invoice_id ."',currency_rate='1',type='S',currency_id='1', entry_date ='".$data["po_date"]." ".$data["po_time"]."'"); 
                            $last_journal_id = (int)$this->db->getLastId();  
                            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".-1*$net."', journal_details  = 'Sale Items',inv_id= '".$invoice_id ."',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='S', entry_date ='".$data["po_date"]." ".$data["po_time"]."'");

                    }
                    
                    if($data['po_hidden_id']==0)
                    {
                  $this->updateAvgCost($det[$i]->{'item_id'},$unit_price,$sale_price,$det[$i]->{'item_quantity'},$det[$i]->{'conv_from'},$invoice_id,$data["po_date"],$cogs_cost,$total_cogs);  
                    }
                    else{
                      if(isset($sale_price) && $sale_price!=0){
                $saleprice_update = "sale_price='".$sale_price."'";
            }
                      $this->db->query("UPDATE ".DB_PREFIX."item SET normal_price='".$unit_price."',".$saleprice_update." WHERE id='".$det[$i]->{'item_id'}."'");  
                    }
                
            } 
            
            
          }
          return array("invoice_id" => $invoice_id, "inv_no" => $invoice_no);
        }
        
        private function getInvoiceNumber($id=0,$type=1){
            $inv_no = 0;
            if($id==0){
                $query_item = $this->db->query("SELECT max(invoice_no) as inv_no FROM ".DB_PREFIX."po_invoice WHERE invoice_type=".$type);
                $inv_no = $query_item->row['inv_no']+1;
            }
            else{
                //echo "SELECT invoice_no FROM ".DB_PREFIX."po_invoice WHERE invoice_type=".$type." and invoice_id=".$id; exit;
                $query_item = $this->db->query("SELECT invoice_no FROM ".DB_PREFIX."po_invoice WHERE invoice_type=".$type." and invoice_id=".$id);                
                $inv_no = $query_item->row['invoice_no'];
            }
            
            return $inv_no;
        }
        
        public function updateItemsCount($item_id,$count){
            $this->db->query("UPDATE " . DB_PREFIX . "item SET
                        quantity= quantity +".(int)$count." 
                        WHERE id='".$item_id."'
                    "); 
        }
        
        //Avg cost solution it will traverse all purchase and set cost. 
        
        private function updateAvgCost($item_id,$unit_price,$sale_price,$quantity,$conv_from,$invoice_id,$date,$old_cost,$old_qty){ 

        $sql = "SELECT pd.inv_item_quantity as qty,pd.inv_item_price as price, pd.inv_item_subTotal as subTotal, inv.invoice_date as p_date,inv.invoice_id as inv_id FROM ".DB_PREFIX."po_invoice_detail as pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    WHERE  pd.inv_item_id='".$item_id."'";
            $query = $this->db->query($sql);
            $record = $query->rows;
            
            $query = $this->db->query("SELECT quantity,avg_cost,normal_price FROM ".DB_PREFIX."item WHERE id='".$item_id."'");
            $r_count = $query->row['quantity']==NULL?0:$query->row['quantity'];
            $avg_rate1 = $query->row['avg_cost'];
            $normal_price = $query->row['normal_price'];
            $new_avg_rate = '';
            $avg_rate =$query->row['avg_cost'];
            $purchase_count = $r_count;
             
            
            $query = $this->db->query("SELECT sum(qty) as qty FROM ".DB_PREFIX."stock_adjust WHERE item_id='".$item_id."'");
            $adjust_qty = $query->row['qty']==NULL?0:$query->row['qty'];
            $purchase_count = $r_count +$adjust_qty;
            
            for ($c=0; $c<count($record); $c++){
                                
                $query = $this->db->query("SELECT sum(pid.inv_item_quantity) as qty FROM ".DB_PREFIX."pos_invoice_detail pid
                          LEFT JOIN ".DB_PREFIX."pos_invoice p ON (p.invoice_id = pid.inv_id)  
                          WHERE pid.inv_item_id='".$item_id."'");
                $sold=$query->row['qty']==NULL?0:$query->row['qty'];
                $r = $purchase_count - $sold;
                $po_qty=$quantity*$conv_from;

                $sum_qty=$r+$record[$c]["qty"];
                if($old_qty>0)
                {
                    $oldAvg=number_format($old_qty*$avg_rate1,2,'.','');
                    $newAvg=$po_qty*$unit_price;
                    $avg_rate = ($oldAvg+$newAvg)/($old_qty+$po_qty);
                }
                else if($old_qty<=0)
                {
                  $test=$old_qty+$po_qty;
                  // echo $test;exit;
                  if($test<0)
                  {
                     $avg_rate =$old_cost; 
                  }
                  else{
                     $avg_rate =$unit_price; 
                  }
                  //echo $avg_rate;
                }
                else if($avg_rate<0)
                {
                  $avg_rate=$normal_price;
                }
                $purchase_count = $purchase_count+$record[$c]["qty"];
            }
            $saleprice_update = "";
            if(isset($sale_price) && $sale_price!=0){
                $saleprice_update = "sale_price='".$sale_price."'";
            }
         
           

            $this->db->query("UPDATE ".DB_PREFIX."item SET avg_cost='".$avg_rate."',normal_price='".$unit_price."',".$saleprice_update." WHERE id='".$item_id."'");           
           
        }
        
        
                
        public function deleteInvoice($data){  
            $query_item = $this->db->query("SELECT inv_item_id as itemId, inv_item_price as unit_price, conv_from as conv_from FROM po_invoice_detail WHERE inv_id='".$data['selected']."'");
            $results = $query_item->rows;
            
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." po_invoice_detail
            WHERE inv_id='".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." invoice_payment
          WHERE inv_id='".$data['selected']."' AND invoice_type='1'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." po_receive
          WHERE po_id='".$data['selected']."'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." item_warehouse
            WHERE inv_id='".$data['selected']."' AND invoice_type='4'");
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." po_invoice
          WHERE invoice_id='".$data['selected']."'");
            
            $query = $this->db->query("DELETE FROM ".DB_PREFIX." account_journal
            WHERE inv_id='".$data['selected']."'");
            
            var_dump($results);exit;
            foreach ($results as $result) {
                $this->updateAvgCost($result['itemId']);
            }
            
            return $query;
            
        }
        public function previousOrderId($id){
            $query = $this->db->query("SELECT invoice_id FROM " . DB_PREFIX . "po_invoice WHERE invoice_id<'".$id."' AND `invoice_type`='1'  ORDER BY invoice_id  DESC LIMIT 1"); 
            $pre_id = 0;
            if($query->num_rows){
                $pre_id = $query->row['invoice_id'];
            }
            return $pre_id;
        }
        public function nextOrderId($id){
            $query = $this->db->query("SELECT invoice_id FROM " . DB_PREFIX . "po_invoice WHERE invoice_id>'".$id."' AND `invoice_type`='1' ORDER BY invoice_id  LIMIT 1"); 
            $next_id = 0;
            if($query->num_rows){
                $next_id = $query->row['invoice_id'];
            }
            return $next_id;
        }
        
        
        public function getOrders($data){
                $search_string = '';
                
                if(isset($data['search'])){
                    $search_string = "WHERE 1 ";
                    if(!empty($data['search_invoice_id'])){
                        $search_string .= "AND pi.invoice_no = '".$data['search_invoice_id']."' ";
                    }
                    if($data['search_status']!='0'){
                        $search_string .= "AND pi.invoice_status='".$data['search_status']."' ";
                    }
                    if($data['search_vendor']!='-1'){
                        $search_string .= "AND pi.vendor_id='".$data['search_vendor']."'";
                    }
                 
                }
                if($search_string==""){
                      $search_string = "WHERE 1 ";
                }
                if(isset($data['poreturn']) && $data['poreturn']=="1"){
                    $search_string .= "AND pi.invoice_type='2' ";
                }
                else{
                    $search_string .= "AND pi.invoice_type='1' ";
                }
    $sql = "SELECT pi.*,v.vendor_name  FROM ".DB_PREFIX."po_invoice pi
                        LEFT JOIN ".DB_PREFIX."vendor v ON (v.vendor_id = pi.vendor_id)
                        ".$search_string ." ORDER BY invoice_id DESC" ;    
                //echo $sql;
  $query = $this->db->query($sql);
  return $query->rows;
 }
        public function getPurchaseInvoice($inc_id){
  $sql   = "SELECT * FROM ".DB_PREFIX."po_invoice WHERE  invoice_id='".$inc_id['po_id']."'";
                $query = $this->db->query($sql);
                         return $query->row;
 }
        public function getPurchaseInvoiceDetails($inc_id){
    $sql   = "SELECT pid.*,i.item_name as item_name,u.name as name,u.id as unit_id,w.warehouse_id AS w_id,w.warehouse_name AS w_name FROM ".DB_PREFIX."po_invoice_detail pid
                        LEFT JOIN ".DB_PREFIX."item i ON (i.id = pid.inv_item_id)
                        LEFT JOIN ".DB_PREFIX."units u ON (u.id = pid.unit_id)
                        LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id=pid.warehouse_id)
                        WHERE pid.inv_id='".$inc_id['po_id']."'";
                  // echo $sql;exit;      
                $query = $this->db->query($sql);
             return $query->rows;
  }
        
        public function bl_getPurchaseInvoiceDetails($data){
            $condition = "";
            if($data['search']==1){
                $vendor_invoice = $this->getVendorInvoices($data['vend_id']);
                if($data['vend_id']!="" && $data['inv_id']==""){
                    $condition = " pid.inv_id IN ('".$vendor_invoice."')";
                } elseif ($data['vend_id']!="" && $data['inv_id']!=""){
                    $condition = " pid.inv_id='".$data['inv_id']."'";
                }
            } else {
                    $condition = " pid.inv_id='".$data['inv_id']."'";
            }
            
      $sql   = "SELECT pid.*,i.item_name as item_name,i.item_code as item_code, i.quantity as itemQty FROM ".DB_PREFIX."po_invoice_detail pid
                    LEFT JOIN ".DB_PREFIX."item i ON (i.id = pid.inv_item_id)
                    LEFT JOIN ".DB_PREFIX."units u ON (u.id = pid.unit_id)
                    WHERE ".$condition;
            $query = $this->db->query($sql);
            return $query->rows;
  }
        private function getVendorInvoices($vend_id){
            $query = "";
            if($vend_id=='-1'){
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."po_invoice");
            } else {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."po_invoice WHERE vendor_id=".$vend_id);
            }
            $results = $query->rows;
            $inv_no =array();
            foreach ($results as $result) {
                array_push($inv_no, $result['invoice_id']);
            }
      return  implode(',', $inv_no);
        }
        public function bl_getPurchaseInvoiceNo($data){
            if($data['vend_id']=='-1'){
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."po_invoice");
                return $query->rows;
            } else {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."po_invoice WHERE vendor_id=".$data['vend_id']);
                return $query->rows;
            }
        }
        
        public function bl_getPurchaseInvoiceItems($data){
            if($data['cat_id']=='-1'){
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."item");
                return $query->rows;
            } else {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."item WHERE category_id=".$data['cat_id']);
                return $query->rows;
            }
        }
        public function getPurchaseReceiveDetails($inc_id){
    $sql = "SELECT pr.*,i.item_name,w.warehouse_name AS warehouseName, pid.* FROM ".DB_PREFIX."po_receive pr
                        LEFT JOIN ".DB_PREFIX."item i ON (i.id = pr.rec_item_id)
                        LEFT JOIN ".DB_PREFIX."po_invoice_detail pid ON (pid.inv_item_id = pr.rec_item_id and pid.inv_id=pr.po_id)
                        LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id = pr.rec_warehouse)
                        WHERE pr.po_id='".$inc_id['po_id']."'";
                //echo $sql;
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
           
               $this->db->query("UPDATE " . DB_PREFIX . "po_invoice SET invoice_status='".$data['po_order_status']."', invoice_paid=invoice_paid + '".$data['paid_total']."' WHERE invoice_id='".$data["G_invoice_id"]."'");
               $sql = "SELECT vendor_acc_id FROM ".DB_PREFIX."vendor WHERE vendor_id='".$data["G_vendor_id"]."' ";           
                 $acc_payable = $this->db->query($sql)->row['vendor_acc_id'];       
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$acc_payable."', journal_amount='".$data["paid_total"]."', journal_details  = 'Payment',inv_id= '".$data["G_invoice_id"] ."',currency_rate='1',currency_id='1',type='P', entry_date ='".$payment_date." ".$data["payment_time"]."'"); 
                 $last_journal_id = (int)$this->db->getLastId();  
                 $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                 $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='-1', journal_amount='".-1*$data["paid_total"]."', journal_details  = 'Payment',inv_id= '".$data["G_invoice_id"] ."',currency_rate='1',ref_id='".$last_journal_id."',type='P',currency_id='1', entry_date ='".$payment_date." ".$data["payment_time"]."'"); 
           
          $pay_id = $this->db->getLastId();
          return $pay_id;
        }
        
        public function getPayments($data){
            $sql = "SELECT * FROM ".DB_PREFIX."invoice_payment                        
                        WHERE inv_id='".$data['po_id']."' AND invoice_type='1'";
                $query = $this->db->query($sql);
    return $query->rows;
        }
        
        public function getPurchaseUnits($data){
            $sql = "SELECT um.*,u.name as unit_name,u.id as unit_id,i.purchase_unit as purchase_unit,i.sale_unit as sale_unit FROM ".DB_PREFIX."unit_mapping um
                        LEFT JOIN ".DB_PREFIX."units u ON (um.unit_id = u.id)
                        LEFT JOIN ".DB_PREFIX."item i ON (um.unit_id = i.id) WHERE 
                        um.item_id='".$data['id']."'"; 
                $query = $this->db->query($sql);
    return $query->rows;
        }
     
        
        public function getTotalPaid($po_id){
            $query = $this->db->query("SELECT v.vendor_acc_id FROM " . DB_PREFIX . "po_invoice po
                    LEFT JOIN ".DB_PREFIX."vendor v ON (po.vendor_id= v.vendor_id) WHERE po.invoice_id='".$po_id."'"); 
            
            $sql = "SELECT sum(journal_amount) as amount FROM ".DB_PREFIX."account_journal                        
                        WHERE inv_id='".$po_id."' AND journal_details='Payment' AND acc_id='".$query->row['vendor_acc_id']."'";
                $query = $this->db->query($sql);
    return  $query->row['amount']==NULL ? 0: $query->row['amount'];
        }
        
        public function paymentDel($inc_id){
            $sql = "DELETE FROM ".DB_PREFIX."invoice_payment
                        WHERE pay_id='".$inc_id['id']."' AND invoice_type='1'
            ";
            $query = $this->db->query($sql);
            return $query;
        }

        public function PurcahseExpense($data)
        {
          $payment_date = "";                      
            list($dd, $md, $yd) = mb_split('[/.-]', $data["payment_date"]); 
            $payment_date = $yd.'-'.$md.'-'.$dd." ".$data["payment_time"];       

           $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='-1', journal_amount='".$data['amount']."', journal_details  = '',inv_id= '0',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'"); 
                $last_journal_id = (int)$this->db->getLastId();  
                $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$data["expenseType"]."', journal_amount='".-1*$data['amount']."', journal_details  = '',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='EXPENSE', entry_date ='".$payment_date."'");
                if($last_journal_id !=0)
                {
                  return  $success=true;
                } 
        }
}
?>
