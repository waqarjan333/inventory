<?php
class ModelDashboardItem extends Model{
        public function saveItem($data,$file){          
          $cogs_id = (isset($data["acc_cogs_id"]) && !empty($data["acc_cogs_id"]))?$data["acc_cogs_id"]:NULL;
          $sale_id =(isset($data["acc_income_id"]) && !empty($data["acc_income_id"]))?$data["acc_income_id"]:NULL;
          $asset_id =(isset($data["acc_asset_id"]) && !empty($data["acc_asset_id"]))?$data["acc_asset_id"]:NULL;
          $part_no =(isset($data["part_number"]) && !empty($data["part_number"]))?$data["part_number"]:NULL;
          $qty =(isset($data["quantity"]) && !empty($data["quantity"]))?$data["quantity"]:0;
          $weight = (isset($data["item_weight"]) && !empty($data["item_weight"]))?$data["item_weight"]:0;
          $reorder_point =(isset($data["reorder_point"]) && !empty($data["reorder_point"]))?$data["reorder_point"]:NULL;
            $result=str_replace("&amp;", '&', $data["name"]); 
            $name=str_replace("&quot;", '"', $result);
            $NewName = str_replace("'", "\'", $name);
            // echo $NewName;
            $barcode = str_replace("'", "\'", $data['barcode']);
            $normalPrice = "";
            if($data["item_type"]=='3'){
                $normalPrice = 0;
                $avgCost = 0;
                $quantity = $qty;
            } else {
                $normalPrice = $data["nprice"];
                $avgCost = $data["nprice"];
                $quantity = $qty;
            }
          $this->db->query("INSERT INTO " . DB_PREFIX . "item SET 
                    item_name = '".$NewName."',
                    item_code = '".$barcode."',
                    category_id = '".$data["cat_id"]."',
                    type_id = '".$data["item_type"]."',
                    picture = '',
                    sort_order = '".$this->getOrder($data["cat_id"]) ."',
                    quantity = '".$quantity."',
                    reorder_point = '".$reorder_point."',   
                    part_number = '".$part_no."',
                    normal_price='".$normalPrice."',
                    weight='".$weight."', 
                    avg_cost='".$avgCost."',
                    sale_price='".$data["sprice"]."',
                    cogs_acc='".$cogs_id."',
                    sale_acc='".$sale_id."',
                    unit='".$data['_item_unit']."',    
                    asset_acc='".$asset_id."',
                    item_map_id='".$data["item_map_hidden_id"]."',    
                    vendor='".$data["acc_vendor_id"]."',
                    added_date='".$data['entry_date']."',
                    sale_unit='1',
                    purchase_unit='1'
                    "); 
          $last_id = $this->db->getLastId();
          $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$last_id."', 
                    `uom_id`='0', 
                    `unit_id`='1', 
                    `conv_from`='1', 
                    `conv_to`='1',  
                    `sale_price`='".number_format($data["sprice"],2,'.','')."', 
                    `created_date`='".date('Y-m-d h:i:s')."', 
                    `updated_date`='".date('Y-m-d h:i:s')."'
                    ");

              $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$last_id."', 
                    `uom_id`='0', 
                    `barcode`='".$barcode."', 
                    `upc`='1'
                    ");
          //Adding Journal entries
          if($quantity!=0 && $data["item_type"]!=3){
            $total_asset = $quantity*$normalPrice;         
            // echo $total_asset;exit;   
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$last_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['entry_date']."'"); 
            $last_journal_id = (int)$this->db->getLastId();  
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['entry_date']."'"); 
          }
          // if($data["item_type"] != 3){
            $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET 
                     inv_id = '0',
                     item_id = '".$last_id."',
                     qty = '".$quantity."',
                     conv_from = '1',
                     warehouse_id = '1',
                     unit_id = '".$data['_item_unit']."',   
                     invoice_type = '6',
                     invoice_status='{{Opening Quantity}}',
                     inv_date='".date('Y-m-d')."'
                     "); 
          // }
          $file_path = "";
          if(isset($file)){
              $file_path=$this->uploadfiles($this->session->data['su_id'],$last_id,'item_image',$file);
             
          }           
          if(!empty($file_path)){
            $this->db->query("UPDATE " . DB_PREFIX . "item SET 
                      picture = '".$file_path."'
                      WHERE id='".$last_id."'
                      "); 
          }
          $result_array = array(
                "id" => $last_id,
                "url" => $file_path,
            );
          
          if(isset($data["item_color"]) && !empty($data["item_color"])){
              $this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_value SET cust_field_id='1',item_id='".$last_id."', cust_field_value='".$data["item_color"]."' ");
          }
          if(isset($data["item_size"]) && !empty($data["item_size"])){
              $this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_value SET cust_field_id='2',item_id='".$last_id."', cust_field_value='".$data["item_size"]."' ");
          }
          if(isset($data["item_brand"]) && !empty($data["item_brand"])){
              $this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_value SET cust_field_id='3',item_id='".$last_id."', cust_field_value='".$data["item_brand"]."' ");
          }
          return $result_array;
        }


        public function getCat()
        {
          $sql="SELECT m.id,c.name,m.name AS parent FROM " . DB_PREFIX . " category m LEFT JOIN category c ON (m.parent_id=c.id) WHERE m.status=1";
           $query = $this->db->query($sql);
            return $query->rows;
        }

        public function savetransfer($data,$det)
        {
            $id=0;
           $inv_no = $this->getTransferNumber($id);
           $this->db->query("DELETE FROM " . DB_PREFIX . "stock_transfer WHERE invoice_no='".$inv_no."'");
           $this->db->query("DELETE FROM " . DB_PREFIX . "stock_transfer WHERE invoice_no='".$inv_no."'");
          for($i=0;$i<count($det);$i++){
             $this->db->query("INSERT INTO " . DB_PREFIX . "stock_transfer SET invoice_no='".$inv_no."',item_id='".$det[$i]->{'item_id'}."', qty='".$det[$i]->{'item_quantity'}."',conv_from='".$det[$i]->{'conv_from'}."',unit_id='".$det[$i]->{'unit_id'}."', from_warehouse  = '".$data['from_warehouse'] ."', to_warehouse  = '".$data['to_warehouse'] ."', date='".$data['so_date']."'");
             // $last_id = $this->db->getLastId();
            $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$inv_no."', qty='-".$det[$i]->{'item_quantity'}."',conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$data['from_warehouse'] ."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='8',invoice_status='{{Stock Transfer}}',inv_date='".$data['so_date']."' "); 
           
         $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET item_id='".$det[$i]->{'item_id'}."',inv_id='".$inv_no."', qty='".$det[$i]->{'item_quantity'}."',conv_from='".$det[$i]->{'conv_from'}."', warehouse_id  = '".$data['to_warehouse'] ."',unit_id='".$det[$i]->{'unit_id'}."',invoice_type='8',invoice_status='{{Stock Transfer}}',inv_date='".$data['so_date']."' "); 


            
          }
        }
         private function getTransferNumber($id=0){
            $inv_no = 0;
            if($id==0){
                $query_item = $this->db->query("SELECT max(invoice_no) as inv_no FROM ".DB_PREFIX."stock_transfer");
                $inv_no = $query_item->row['inv_no']+1;
            }
            
            return $inv_no;
        }
        public function get_item_units($id){
            $sql = "SELECT um. * , u.name AS unit_name
            FROM " . DB_PREFIX . "unit_mapping um
            LEFT JOIN " . DB_PREFIX . "units u ON ( um.unit_id = u.id ) 
            WHERE um.item_id =  '".$id."'";
            $query = $this->db->query($sql);
            return $query->rows;
        }
        private function getOrder($cat_id){
            $sql = "SELECT count(*) as order_no FROM ".DB_PREFIX."item WHERE category_id='".$cat_id."'";
            $query = $this->db->query($sql);
            return intval($query->row['order_no'])+1;
        }
        private function uploadfiles($folder,$last_id,$file_control_id,$files){
            $upload_path = DIR_UPLOAD.$folder; 
            $file_path = '';
                if (!$files[$file_control_id]["error"]){
                        if (!is_dir($upload_path.'/')) {
                                if (!mkdir($upload_path.'/', 0777, true)) {
                                        die('Failed to create folders...');
                                }
                        }
                        $filename = $files[$file_control_id]["name"];
                        
                        move_uploaded_file($files[$file_control_id]["tmp_name"],$upload_path.'/'. $filename);
                        rename($upload_path.'/'. $filename,$upload_path .'/'.$last_id.'_'. $filename);
                        $file_path= $upload_path .'/'.$last_id.'_'. $filename;
                        /*Image resize code*/
                        $img = new Image($file_path);
                        $img->resize(100,100);
                        $img->save($file_path,100);
                }
                
                return $file_path;
        }
        
        public function saveCategory($data){
            $result=str_replace("&amp;", '&', $data["category_name"]); 
          $name=str_replace("&quot;", '"', $result);
          $this->db->query("INSERT INTO " . DB_PREFIX . "category SET 
                    name = '".$name."', parent_id='".$data["cat_parent_id"]."',
                    status= 1
                    "); 
          $last_id = $this->db->getLastId();
          return $last_id;
        }
        
         public function updateItem($data,$file){
          $file_path = "";
          $sql = "SELECT picture,quantity FROM ".DB_PREFIX."item
                        WHERE id='".$data['item_hidden_id']."' ";
          $_query = $this->db->query($sql);
          
          $stored_image= $_query->row['picture']==NULL?'':$_query->row['picture'];
          if(isset($file)){
              $file_path=$this->uploadfiles($this->session->data['su_id'],$data['item_hidden_id'],'item_image',$file);
              /*if($file_path && $stored_image){
                  try {
                    unlink($stored_image);
                  }
                  catch (Exception $e) {                  
                  }
              }*/
              
          }
          if($file_path==''){
             $file_path = $stored_image;
          }
          $cogs_id = (isset($data["acc_cogs_id"]) && !empty($data["acc_cogs_id"]))?$data["acc_cogs_id"]:NULL;
          $sale_id =(isset($data["acc_income_id"]) && !empty($data["acc_income_id"]))?$data["acc_income_id"]:NULL;
          $asset_id =(isset($data["acc_asset_id"]) && !empty($data["acc_asset_id"]))?$data["acc_asset_id"]:NULL;
          $reorder_point =(isset($data["reorder_point"]) && !empty($data["reorder_point"]))?$data["reorder_point"]:NULL;
          $quantity =(isset($data["quantity"]) && !empty($data["quantity"]))?"quantity = '".$data["quantity"]."',":"";
          $_quantity =(isset($data["quantity"]) && !empty($data["quantity"]))?$data["quantity"]:0;
          $weight = (isset($data["item_weight"]) && !empty($data["item_weight"]))?$data["item_weight"]:0;
          $image_path =(isset($data["item_image_path"]) && !empty($data["item_image_path"]))?"picture = '".$data["item_image_path"]."',":""; 
          $result=str_replace("&amp;", '&', $data["name"]); 
          $name=str_replace("&quot;", '"', $result);
          $normalPrice = "";
          $barcode = str_replace("'", "\'", $data['barcode']);
          if($data["item_type"]=='3'){
                $normalPrice = "avg_cost = 0, normal_price =0, quantity = 0,";
            }
            else{
              $normalPrice = "avg_cost = ".$data['nprice'].", normal_price = ".$data['nprice'].",";
            } 
          $this->db->query("UPDATE " . DB_PREFIX . "item SET 
                    item_name = '".$name."',
                    item_code = '".$barcode."',
                    category_id = '".$data["cat_id"]."',
                    type_id = '".$data["item_type"]."', 
                    picture = '".$file_path."',
                    part_number = '".$data["part_number"]."',    
                    reorder_point = '".$reorder_point."',    
                    weight='".$weight."',        
                    unit='',
                    ".$normalPrice."
                    sale_price='".number_format($data["sprice"],2,'.','')."',
                    cogs_acc='".$cogs_id."',
                    sale_acc='".$sale_id."',
                    asset_acc='".$asset_id."',
                    item_map_id='".$data["item_map_hidden_id"]."',    
                    vendor='".$data["acc_vendor_id"]."'
                    WHERE id='".$data['item_hidden_id']."'
                  "); 
          
          $last_id = $data['item_hidden_id'];
          // $query_upc = $this->db->query("SELECT * FROM ".DB_PREFIX."unit_mapping
          //               WHERE `item_id`='".$data['item_hidden_id']."' AND `uom_id`='0' AND `unit_id`='1'");
          // $query_upc = $this->db->query("SELECT * FROM ".DB_PREFIX."unit_mapping
          //               WHERE `item_id`='".$data['item_hidden_id']."'");
          // if($query_upc->num_rows>0){
          // $this->db->query("UPDATE " . DB_PREFIX . "unit_mapping SET 
          //           `sale_price`=`conv_from` * '".number_format($data["sprice"],2,'.','')."'
          //            WHERE `item_id`='".$data['item_hidden_id']."'
          //         ");
          // }
           $query_upc = $this->db->query("SELECT * FROM ".DB_PREFIX."unit_mapping
                        WHERE `item_id`='".$data['item_hidden_id']."' AND `uom_id`='0' AND `unit_id`='1'");
            if($query_upc->num_rows>0){
          $this->db->query("UPDATE " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$data['item_hidden_id']."', 
                    `uom_id`='0', 
                    `unit_id`='1', 
                    `conv_from`='1', 
                    `conv_to`='1',  
                    `sale_price`='".number_format($data["sprice"],2,'.','')."', 
                    `created_date`='".date('Y-m-d h:i:s')."', 
                    `updated_date`='".date('Y-m-d h:i:s')."'
                     WHERE `item_id`='".$data['item_hidden_id']."'
                         AND `uom_id`='0' AND `unit_id`='1'
                  ");
          }
           else {
            $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$data['item_hidden_id']."', 
                    `uom_id`='0', 
                    `unit_id`='1', 
                    `conv_from`='1', 
                    `conv_to`='1',  
                    `sale_price`='".number_format($data["sprice"],2,'.','')."', 
                    `created_date`='".date('Y-m-d h:i:s')."', 
                    `updated_date`='".date('Y-m-d h:i:s')."'
                  ");  
          }
          $query_upc = $this->db->query("SELECT * FROM ".DB_PREFIX."uom_barcodes
                        WHERE `item_id`='".$data['item_hidden_id']."' AND `uom_id`='0' AND `upc`=1");
          if($query_upc->num_rows>0){
          $this->db->query("UPDATE " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$data['item_hidden_id']."', 
                    `uom_id`='0', 
                    `barcode`='".$barcode."',
                    `upc`='1'
                     WHERE `item_id`='".$data['item_hidden_id']."'
                     AND `uom_id`='0' AND `upc`='1'");
          } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$data['item_hidden_id']."', 
                    `uom_id`='0', 
                    `barcode`='".$barcode."',
                     `upc`='1'
                    ");
          }
          $result_array = array(
                "id" => $last_id,
                "url" => $file_path,
            );
          if($data["item_type"]!='3'){
          if(($_query->row['quantity']=="0" || $_query->row['quantity']==0)  && $_quantity!=0){
           $this->db->query("UPDATE " . DB_PREFIX . "item SET avg_cost='".$data["nprice"]."', normal_price='".$data["nprice"]."',quantity='".$_quantity."' WHERE id='".$data['item_hidden_id']."'");   
          //Temp logic for custom fields           
           $total_asset = $data["quantity"]*$data["nprice"];            
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$data['item_hidden_id']."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['entry_date']."'"); 
            $last_journal_id = (int)$this->db->getLastId();  
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['entry_date']."'"); 
          }  
          }
          if(isset($data["item_color"]) && !empty($data["item_color"])){
              if($this->checkCustomFieldExists(1, $last_id)){
                  $this->db->query("UPDATE " . DB_PREFIX . "custom_fields_value SET cust_field_value='".$data["item_color"]."' WHERE cust_field_id='1' AND item_id='".$last_id."'");
              }
              else{
                $this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_value SET cust_field_id='1',item_id='".$last_id."', cust_field_value='".$data["item_color"]."' ");
              }
          }
          if(isset($data["item_size"]) && !empty($data["item_size"])){
              if($this->checkCustomFieldExists(2, $last_id)){
                  $this->db->query("UPDATE " . DB_PREFIX . "custom_fields_value SET cust_field_value='".$data["item_size"]."' WHERE cust_field_id='2' AND item_id='".$last_id."'");
              }
              else{
                $this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_value SET cust_field_id='2',item_id='".$last_id."', cust_field_value='".$data["item_size"]."' ");
              }
          }
          if(isset($data["item_brand"]) && !empty($data["item_brand"])){
              if($this->checkCustomFieldExists(3, $last_id)){
                  $this->db->query("UPDATE " . DB_PREFIX . "custom_fields_value SET cust_field_value='".$data["item_brand"]."' WHERE cust_field_id='3' AND item_id='".$last_id."'");
              }
              else{
                $this->db->query("INSERT INTO " . DB_PREFIX . "custom_fields_value SET cust_field_id='3',item_id='".$last_id."', cust_field_value='".$data["item_brand"]."' ");
              }
          }
          
          

          return $result_array;
        }
        public function checkCustomFieldExists($field_id,$item_id){
            $sql = "SELECT * FROM ".DB_PREFIX."custom_fields_value where cust_field_id='".$field_id."' AND item_id='".$item_id."'";
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        public function checkNameExists($data){
            $condition = '';
            if($data['item_hidden_id']!=0){
                $condition = "AND id!=".$data['item_hidden_id'];
            }
            $NewName = str_replace("'", "\'", $data['name']);
            $sql = "SELECT * FROM ".DB_PREFIX."item
                        WHERE item_name='".$NewName."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        
        public function checkBarCodeExists($data){
            $rows = 0;
            if($data['barcode']!=""){
                $condition = '';
                if($data['item_hidden_id']!=0){
                    $condition = "AND item_id!=".$data['item_hidden_id'];
                }
                $barcode = str_replace("'", "\'", $data['barcode']);
                $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes
                            WHERE barcode='".$barcode."' ".$condition;

                $query = $this->db->query($sql);
                $rows =  $query->num_rows;
            }
            return $rows;
        }
        public function delbarcode($item_id){
           $this->db->query("DELETE FROM " . DB_PREFIX . "uom_barcodes WHERE item_id='".$item_id."' OR barcode=''");
            
        }
        public function CheckBarcodes($barcode){
          
            $query = $this->db->query("SELECT * FROM ".DB_PREFIX."uom_barcodes WHERE barcode='".$barcode."'");
            return $query->num_rows;
          
            
             
        }

        public function save_uom($data){
           if($data['conv_from_type']=='0'){ $conv_from = '1'; $conv_to = 1; } else { $conv_from = $data['conv_from_type']; $conv_to = $data['conv_to_type']; }
            $this->db->query("DELETE FROM " . DB_PREFIX . "unit_mapping WHERE item_id='".$data['item_id']."' AND uom_id='".$data['uom_type']."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$data['item_id']."', 
                    `uom_id`='".$data['uom_type']."', 
                    `unit_id`='".$data['uom_combo_type']."', 
                    `conv_from`='".$conv_from."', 
                    `conv_to`='".$conv_to."',  
                    `sale_price`='".number_format($data['sale_price_type'],2,'.','')."', 
                    `created_date`='".date('Y-m-d h:i:s')."', 
                    `updated_date`='".date('Y-m-d h:i:s')."'
                    ");
        if($data['uom_type']==0){    
        $this->db->query("UPDATE " . DB_PREFIX . "item SET 
            sale_price = '".number_format($data['sale_price_type'],2,'.','')."',
            sale_unit = '".$data['sale_uom_combo']."',
            purchase_unit = '".$data['purchase_uom_combo']."'
            WHERE id='".$data['item_id']."'
            ");
        }

      
            
        
        }
        
          public function Updateunit_price_uom($data)
        {
          $sql="SELECT * FROM unit_mapping WHERE uom_id=".$data['uom_id']." AND item_id=".$data['item_id']." ";
          $query = $this->db->query($sql);
            $row=$query->num_rows;
            if($row>0)
            {
              $this->db->query("UPDATE " . DB_PREFIX . "unit_mapping SET 
            sale_price = '".number_format($data['price'],2,'.','')."'
            WHERE item_id='".$data['item_id']."' AND uom_id='".$data['uom_id']."';
            "); 
            }
            else{
                $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    `item_id`='".$data['item_id']."', 
                    `uom_id`='".$data['uom_id']."', 
                    `unit_id`='".$data['unit_id']."', 
                    `conv_from`='".$data['conv_from']."', 
                    `conv_to`='1',  
                    `sale_price`='".number_format($data['price'],2,'.','')."', 
                    `created_date`='".date('Y-m-d h:i:s')."', 
                    `updated_date`='".date('Y-m-d h:i:s')."'
                    ");
            }
         
        }
        
         
          
        
        public function savebarcode($data){
          $barcode = str_replace("'", "\'", $data['barcode']);
            if($data['barcode']!=""){
            $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    `item_id`='".$data['item_id']."', 
                    `uom_id`='".$data['uom_type']."', 
                    `barcode`='".$barcode."',
                    `upc`='".$data['upc_type']."'
                    ");
            }
        }
                public function checkCategoryExists($data){
                    $result=str_replace("&amp;", '&', $data["category_name"]); 
                    $name=str_replace("&quot;", '"', $result);
            $sql = "SELECT * FROM ".DB_PREFIX."category
                        WHERE name='".$name."' and parent_id='".$data['cat_parent_id']."'";
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        public function getItems($data,$status=0){
                $search_string = '';
                $status_string = '';
                $barcode_search = '';
                $search_type = '';
                $item_name_barcode = '';
                if(isset($data['search'])){
                  // if (isset($data['ware_id'])) {
                  //   // echo $data['ware_id'];exit;
                  // }
                   $barcode = str_replace("'", "\'", $data['search_barcode']);
                   if($data['search_name']){ 
                        $search_string .= " and i.item_name like '%".$data['search_name']."%' ";
                   }
                   if(isset($data['search_category']) && $data['search_category']!='0'){
                        $search_string .= " AND category_id='".$data['search_category']."'";
                    }
                    if(isset($data['search_barcode']) && $data['search_barcode']!=''){
                        $barcode_search .= " LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id)";
                        $search_string .= " AND uom_b.barcode LIKE'%".$barcode."%'";
                    }                    
                    
                }                
                if(isset($data['query'])){                    
                    $item_name_barcode = " and i.item_name like '%".$data['query']."%' ";
                } 
                 if(isset($data['search_type'])){                    
                    $search_type = " AND i.type_id='".$data['search_type']."' ";
                }

                else{                   
                   $search_type = " AND i.type_id !=''";
                }

                  if(isset($data['query']) && !empty($data['query']))
                  {
                    $count="SELECT COUNT(id) FROM item WHERE item_name like '%".$data['query']."%'";
                      $query = $this->db->query($count);
                    $num= $query->num_rows;
                    if($num>25)
                    {
                     $LIMIT=" ORDER BY i.item_name ASC LIMIT 20";   
                    }
                    else{
                     $LIMIT=" ORDER BY i.item_name ASC"; 
                    }
                   
                  }
                  else{
                    $LIMIT=" ORDER BY i.item_name ASC" ." LIMIT ".$data['start'].", ".$data['limit']."";
                  }
                if(isset($data['status']) || $status==1){
                    $status_string = ' item_status=1';
                }
                elseif(isset($data['search_status']) && $data['search_status']==1)
                {
                   $status_string = ' item_status=1';
                }
                elseif(isset($data['search_status']) && $data['search_status']==0)
                {
                   $status_string = ' item_status=0';
                }
                else { 
                    $status_string="item_status=1"; 
                }
                if(isset($data['p_level']))
                {
                  $sql = "SELECT i.*,t.name as type_name,c.name as cat_name FROM ".DB_PREFIX."item i
                        LEFT JOIN ".DB_PREFIX."type t ON (i.type_id = t.id)
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) ".$barcode_search." WHERE 
                        ".$status_string.$search_string.$item_name_barcode.$search_type." ORDER BY i.item_name ASC LIMIT ".$data['limit']."";
                }
                else{
                  $sql = "SELECT i.*,t.name as type_name,c.name as cat_name FROM ".DB_PREFIX."item i
                        LEFT JOIN ".DB_PREFIX."type t ON (i.type_id = t.id)
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) ".$barcode_search." WHERE 
                        ".$status_string.$search_string.$item_name_barcode.$search_type."".$LIMIT ;                  }
      
         // echo $sql;exit;         

                $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item i
                        LEFT JOIN ".DB_PREFIX."type t ON (i.type_id = t.id)
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) ".$barcode_search." WHERE 
                        ".$status_string.$search_string.$item_name_barcode."  ORDER BY i.item_name ASC";    
                                 
  $query = $this->db->query($sql);
                $query_count = $this->db->query($sql2);
                
                //New Logic to search barcode. 
                if($query_count->row["total"]==0){                   
                     if(isset($data['query'])){
                      $barcode = str_replace("'", "\'", $data['query']);
                         $barcode_search .= " LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id)"; 
                         $item_name_barcode = " AND uom_b.barcode='".$barcode."'";
                     }                     
                     $sql = "SELECT i.*,t.name as type_name,c.name as cat_name FROM ".DB_PREFIX."item i
                        LEFT JOIN ".DB_PREFIX."type t ON (i.type_id = t.id)
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) ".$barcode_search." WHERE 
                            ".$status_string.$search_string.$item_name_barcode." AND i.type_id=1 ORDER BY i.item_name ASC" ." LIMIT ".$data['start'].", ".$data['limit'];        
                            // echo $sql;exit;                    
                    $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item i
                            LEFT JOIN ".DB_PREFIX."type t ON (i.type_id = t.id)
                            LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) ".$barcode_search." WHERE 
                            ".$status_string.$search_string.$item_name_barcode." AND i.type_id=1 ORDER BY i.item_name ASC";    

                    $query = $this->db->query($sql);
                    $query_count = $this->db->query($sql2);
                }                                
  return array($query_count->row["total"], $query->rows) ;
 }
        
      public function getsingleItem($data)
      {
        $sql="SELECT i.id AS id,i.item_name,i.type_id as type_id,SUM(w.qty) AS qty FROM item i LEFT JOIN item_warehouse w ON i.id=w.item_id WHERE i.type_id !='' AND i.id=".$data['item_id']."";
        echo $sql;exit;
         $query = $this->db->query($sql);
          return $query->row;
      }

        public function getStockItems($data,$status=0){
                $search_string = '';
                $search_item = '';
                $status_string = '';
                if(isset($data['category_id']) && $data['category_id']!='0'){
                        $search_string .= " AND c.id='".$data['category_id']."'";
                    }
                
                if(isset($data['query'])){                    
                    $search_item .= " and i.item_name like '%".$data['query']."%'";
                }
                else{
                    $search_item .=" AND i.item_name!=''";
                }
                          
    
        $sql = "SELECT i.*,c.name as cat_name FROM ".DB_PREFIX."item i                        
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id)                         
                        WHERE i.item_status>0 AND i.type_id=1 
                         
                        ".$search_string . $search_item ." ORDER BY i.item_name LIMIT ".$data['start'].", ".$data['limit'];             
                
                 $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item i                        
                    LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id)                      
                    WHERE i.item_status>0 AND i.type_id=1  
                    ".$search_string . $search_item
                    ;             
    $query = $this->db->query($sql);
                $query_count = $this->db->query($sql2);
                
      
                if($query_count->row["total"]==0){   
                    if(isset($data['query'])){             
                    $barcode = str_replace("'", "\'", $data['query']);       
                        $search_item = " and uom_b.barcode='".$data."'";
                    }
                    $sql = "SELECT i.*,c.name as cat_name FROM ".DB_PREFIX."item i                        
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) 
                        LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id) 
                        WHERE i.item_status>0 AND i.type_id=1 AND
                         
                        ".$search_string . $search_item ." ORDER BY i.item_name LIMIT ".$data['start'].", ".$data['limit']
          ;             
                
                    $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item i                        
                       LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) 
                       LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id)     
                       WHERE i.item_status>0 AND i.type_id=1 AND
                       ".$search_string . $search_item
                       ;           
                    
                    $query = $this->db->query($sql);
                    $query_count = $this->db->query($sql2);
                }
                
                
  return array($query_count->row["total"], $query->rows) ;
 }
                
        
        public function getItemFields($inc_id){
            $sql = "SELECT * FROM ".DB_PREFIX."custom_fields_value
                      WHERE item_id='".$inc_id["item_id"]."'    
          ";
                $query = $this->db->query($sql);
                $results = $query->rows;
                $item_fields = array();
                foreach ($results as $result) {
                   $item_fields["item_".$result['cust_field_id']] = $result['cust_field_value'];                        
                }
  return $item_fields;
        }


        public function getwarehouseitems($data,$status=0)
        {
              $search_string = '';
              $search_ware = '';
                $search_item = '';
                $status_string = '';
                if(isset($data['category_id']) && $data['category_id']!='0'){
                        $search_string .= " AND c.id='".$data['category_id']."'";
                    }

             if(isset($data['warehouse_id']) && $data['warehouse_id']!='0'){
                        $search_ware .= " AND itw.warehouse_id='".$data['warehouse_id']."'";
                    }
                
                if(isset($data['query'])){                    
                    $search_item .= " and i.item_name like '%".$data['query']."%'";
                }
                else{
                    $search_item .=" AND i.item_name!=''";
                }

          $sql="SELECT SUM(itw.qty*itw.conv_from) AS qty,i.item_name AS item_name,c.name AS cat_name,i.avg_cost AS avg_cost,i.sale_price AS sale_price,i.id AS id,i.sale_unit AS sale_unit  FROM ".DB_PREFIX." item_warehouse itw LEFT JOIN ".DB_PREFIX." item i ON(i.id=itw.item_id) LEFT JOIN ".DB_PREFIX." category c ON (c.id=i.category_id) WHERE i.item_status>0  ".$search_ware." ".$search_item." ".$search_string." GROUP BY itw.item_id ORDER BY i.item_name LIMIT ".$data['start'].", ".$data['limit'];
         // echo $sql;exit;
            $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item_warehouse itw                        
                    LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id)
                    LEFT JOIN ".DB_PREFIX."category c ON (c.id = i.category_id)                      
                    WHERE i.item_status>0 AND i.type_id=1 " .$search_string . $search_item;  
                    $query = $this->db->query($sql);
                     $query_count = $this->db->query($sql2);
                     

               if($query_count->row["total"]==0){   
                    if(isset($data['query'])){                    
                        $search_item = " AND  uom_b.barcode='".$data['query']."'";
                    }
          $sql = "SELECT SUM(itw.qty*itw.conv_from) AS qty,i.item_name AS item_name,i.id AS id,i.avg_cost AS avg_cost,i.sale_price AS sale_price,c.name as cat_name FROM ".DB_PREFIX."item_warehouse itw                        
              LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id) 
              LEFT JOIN ".DB_PREFIX."category c ON (c.id = i.category_id) 
              LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id) 
              WHERE i.item_status>0 AND i.type_id=1 ".$search_ware."
               
              ".$search_string . $search_item ." ORDER BY i.item_name LIMIT ".$data['start'].", ".$data['limit'];             

                 // echo $sql;exit();
                    $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item_warehouse itw                        
                       LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id) 
                       LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) 
                       LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id)     
                       WHERE i.item_status>0 AND i.type_id=1 
                       ".$search_string . $search_item;           
                    
                    $query = $this->db->query($sql);
                    $query_count = $this->db->query($sql2);
                }
                          
                  return array($query_count->row["total"], $query->rows) ;   
        }
         public function getadjustwarehouseitems($data,$status=0)
        {
              $search_string = '';
              $search_ware = '';
                $search_item = '';
                $status_string = '';
                if(isset($data['category_id']) && $data['category_id']!='0'){
                        $search_string .= " AND c.id='".$data['category_id']."'";
                    }

             if(isset($data['warehouse_id']) && $data['warehouse_id']!='0'){
                        $search_ware .= " AND itw.warehouse_id='".$data['warehouse_id']."'";
                    }
                
                if(isset($data['query'])){                    
                    $search_item .= " and i.item_name like '%".$data['query']."%'";
                }
                else{
                    $search_item .=" AND i.item_name!=''";
                }

          $sql="SELECT SUM(itw.qty*itw.conv_from) AS qty,i.item_name AS item_name,c.name AS cat_name,i.avg_cost AS avg_cost,i.sale_price AS sale_price,i.id AS id,i.sale_unit AS sale_unit  FROM ".DB_PREFIX." item_warehouse itw LEFT JOIN ".DB_PREFIX." item i ON(i.id=itw.item_id) LEFT JOIN ".DB_PREFIX." category c ON (c.id=i.category_id) WHERE i.item_status>0  ".$search_ware." ".$search_item." ".$search_string." GROUP BY itw.item_id ORDER BY i.item_name";
         // echo $sql;exit;
            $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item_warehouse itw                        
                    LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id)
                    LEFT JOIN ".DB_PREFIX."category c ON (c.id = i.category_id)                      
                    WHERE i.item_status>0 AND i.type_id=1 " .$search_string . $search_item;  
                    $query = $this->db->query($sql);
                     $query_count = $this->db->query($sql2);
                     

               if($query_count->row["total"]==0){   
                    if(isset($data['query'])){                    
                        $search_item = " AND  uom_b.barcode='".$data['query']."'";
                    }
          $sql = "SELECT SUM(itw.qty*itw.conv_from) AS qty,i.item_name AS item_name,i.id AS id,i.avg_cost AS avg_cost,i.sale_price AS sale_price,c.name as cat_name FROM ".DB_PREFIX."item_warehouse itw                        
              LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id) 
              LEFT JOIN ".DB_PREFIX."category c ON (c.id = i.category_id) 
              LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id) 
              WHERE i.item_status>0 AND i.type_id=1 ".$search_ware."
               
              ".$search_string . $search_item ." ORDER BY i.item_name";             

                 // echo $sql;exit();
                    $sql2 = "SELECT COUNT(*) as total FROM ".DB_PREFIX."item_warehouse itw                        
                       LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id) 
                       LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id) 
                       LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id)     
                       WHERE i.item_status>0 AND i.type_id=1 
                       ".$search_string . $search_item;           
                    
                    $query = $this->db->query($sql);
                    $query_count = $this->db->query($sql2);
                }
                          
                  return array($query_count->row["total"], $query->rows) ;   
        }


        public function getuom($data)
        {
                  $sql = "SELECT um.item_id as item_id,SUM(w.qty*w.conv_from/um.conv_from) AS conv_qty, um.uom_id as uom_id, um.sale_price as sprice,(i.normal_price*um.conv_from) as nprice,um.conv_from as conv_from, u.name as unit_name,u.id as unit_id FROM ".DB_PREFIX."unit_mapping um
                   LEFT JOIN ".DB_PREFIX."units u ON (um.unit_id = u.id)
                   LEFT JOIN ".DB_PREFIX."item i ON (um.item_id = i.id)
                  LEFT JOIN item_warehouse w ON (um.item_id =w.item_id)
                    WHERE 
                   um.item_id='".$data['item_id']."' GROUP BY um.unit_id"; 
                   // echo $sql;
            $query = $this->db->query($sql);
            return $query->rows;
        }

        
        public function getItem($inc_id){
  $sql = "SELECT i.*,t.id as type_id,t.name as type_name,c.name as cat_name FROM ".DB_PREFIX."item i
                        LEFT JOIN ".DB_PREFIX."type t ON (i.type_id = t.id)
                        LEFT JOIN ".DB_PREFIX."category c ON (i.category_id = c.id)  
                        WHERE i.id='".$inc_id["item_id"]."'    
          ";
                $query = $this->db->query($sql);
  return $query->row;
 }


  public function getwarehouseItemslist($data)
  {
    $search_item='';
    $ware_item='';
     if(isset($data['query'])){                    
                    $search_item .= " and i.item_name like '%".$data['query']."%'";
                }
                else{
                    $search_item .=" AND i.item_name!=''";
                } 
     if(isset($data['ware_id'])){                    
                    $ware_item .= " AND itw.warehouse_id='".$data['ware_id']."'";
                }
                else{
                    $ware_item .=" AND itw.warehouse_id !=''";
                }

    $sql = "SELECT sum(itw.qty) AS qty,i.item_name AS item_name,i.id AS id,i.avg_cost AS avg_cost,i.sale_price AS sale_price,c.name as cat_name,i.item_code AS barcode,i.normal_price AS normal_price,i.purchase_unit AS purchase_unit,i.sale_unit AS sale_unit,i.type_id AS type_id,w.warehouse_name AS warehouse,i.item_status AS status FROM ".DB_PREFIX."item_warehouse itw                        
              LEFT JOIN ".DB_PREFIX."item i ON (i.id = itw.item_id) 
              LEFT JOIN ".DB_PREFIX."category c ON (c.id = i.category_id) 
              LEFT JOIN ".DB_PREFIX."uom_barcodes uom_b ON (uom_b.item_id = i.id) 
              LEFT JOIN ".DB_PREFIX."warehouses w ON (w.warehouse_id =itw.warehouse_id)
              WHERE i.item_status>0 ".$search_item." AND i.type_id=1 ".$ware_item." GROUP BY itw.item_id";
              // echo $sql;exit;
               $query = $this->db->query($sql);
    return $query->rows;
  }





         public function check_base_unit_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=0";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function check_1_unit_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=1";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function check_2_unit_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=2";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function check_3_unit_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=3";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
        ///////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////
        
         public function base_upc_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=0";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function uom1_upc_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=1";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function uom2_upc_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=2";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function uom3_upc_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=3";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
        ///////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////
        
         public function base_barcode_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=0";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function uom1_barcode_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=1";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function uom2_barcode_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=2";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }
         public function uom3_barcode_count($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=3";
                $query = $this->db->query($sql);
  return $query->num_rows;        
 }

        ///////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////
         public function getUombase_lookup($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=0 AND `upc`='0'";
                $query = $this->db->query($sql);
                $code_fields = array();
                foreach ($query->rows as $result) {
                          $code_fields[] = $result['barcode'];                 
                }
  return $code_fields;
 }
         public function getUom1_lookup($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=1 AND `upc`='0'";
                $query = $this->db->query($sql);
                $code_fields = array();
                foreach ($query->rows as $result) {
                          $code_fields[] = $result['barcode'];                 
                }
  return $code_fields;        
 }
         public function getUom2_lookup($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=2 AND `upc`='0'";
                $query = $this->db->query($sql);
                $code_fields = array();
                foreach ($query->rows as $result) {
                          $code_fields[] = $result['barcode'];                 
                }
  return $code_fields;       
 }
         public function getUom3_lookup($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=3 AND `upc`='0'";
                $query = $this->db->query($sql);
                $code_fields = array();
                foreach ($query->rows as $result) {
                          $code_fields[] = $result['barcode'];                 
                }
  return $code_fields;        
 }
         //////////////////////////////////////////////////////////////////////////////////////////
         public function getUombase_upc($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=0 AND `upc`='1'";
                $query = $this->db->query($sql);
                if($query->num_rows>0){
                return $query->row['barcode'];
                }
 }
         public function getUom1_upc($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=1 AND `upc`='1'";
                $query = $this->db->query($sql);
                if($query->num_rows>0){
                return $query->row['barcode'];
                }
 }
         public function getUom2_upc($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=2 AND `upc`='1'";
                $query = $this->db->query($sql);
                if($query->num_rows>0){
                return $query->row['barcode'];   
                }
 }
         public function getUom3_upc($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=3 AND `upc`='1'";
                $query = $this->db->query($sql);
                if($query->num_rows>0){
                return $query->row['barcode'];  
                }
 }
        
        /////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////
        // Base Unit Record
        public function getUombase($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=0";
                $query = $this->db->query($sql);
  return $query->row;        
 }

        //UOM 1 Record
        public function getUom1($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=1";
                $query = $this->db->query($sql);
  return $query->row;        
 }
     
        //UOM 3 Record
        public function getUom2($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=2";
                $query = $this->db->query($sql);
  return $query->row;        
 }

        public function getUom3($inc_id){
  $sql = "SELECT * FROM ".DB_PREFIX."unit_mapping 
                        WHERE item_id='".$inc_id["item_id"]."' AND uom_id=3";
                $query = $this->db->query($sql);
  return $query->row;        
 }

        public function changeState($data){
            $r = $data["_state"];
            try{
            $this->db->query("UPDATE " . DB_PREFIX . "item SET 
                    item_status = '".$data["_state"]."' 
                    WHERE id='".$data["_id"]."'"); 
            }
            catch(Exception $e){
              $r = '$e->getMessage()';  
            }
            return $r;
 }
        
        public function checkBarCode($barcode){
             $barcodes = str_replace("'", "\'", $barcode);       
            $sql = "SELECT * FROM ".DB_PREFIX."uom_barcodes
                            WHERE barcode='".$barcodes."'";
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        
    
        public function saveMapping($data,$map_id,$item_id){            
           $query = $this->db->query("select count(*) as  _count FROM " . DB_PREFIX . "items_mapping WHERE item_id=".$item_id);
           if($query->row['_count']=="0"){
               $this->db->query("INSERT INTO " . DB_PREFIX . "items_mapping SET 
                    map_id = '".$map_id."',
                    item_id = '".$item_id."',
                    top_head = '".$data->{'top'}."',
                    left_head = '".$data->{'left'}."',                    
                    cell_id = '".$data->{'id'}."',                    
                    created_date=NOW(),
                    updated_date=NOW() 
                    ");                     
           }
           else{
               $this->db->query("UPDATE " . DB_PREFIX . "items_mapping SET 
                    map_id = '".$map_id."',                    
                    top_head = '".$data->{'top'}."',
                    left_head = '".$data->{'left'}."',                    
                    cell_id = '".$data->{'id'}."',                                        
                    updated_date=NOW() 
                    WHERE item_id='".$item_id."'
                    ");    
           }
        }
        public function getMappingNo(){
          $sql = "SELECT max(map_id) as map_id FROM ".DB_PREFIX."items_mapping";
          $query = $this->db->query($sql);   
          return $query->row['map_id'];
        }
             
        public function getMappingItems($data){
            $sql = "SELECT imap.*,i.quantity as item_qty  FROM ".DB_PREFIX."items_mapping imap
                        LEFT JOIN ".DB_PREFIX."item i ON (i.id = imap.item_id)
                        WHERE map_id = '".$data['mapping_id']."'    
                        "
          ;   
            $query = $this->db->query($sql);
            return $query->rows;
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
         public function get_warehouse_items($item_id,$ware_id){ 
         $quer = $this->db->query("SELECT type_id AS type_id FROM " . DB_PREFIX . "item WHERE id = '".$item_id."'");
         if($ware_id['ware_id']==0)
         {
          $ware=" AND pd.warehouse_id !=''";
         }                                  
         else{
          $ware=" AND pd.warehouse_id ='".$ware_id['ware_id']."'";
         } 
         
         if($quer->row['type_id'] != 3){
           $sql = "SELECT sum( pd.qty*pd.conv_from ) 
                    AS qty 
                    FROM ". DB_PREFIX . "item_warehouse AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )                  
                    WHERE pd.item_id=".$item_id." ".$ware." GROUP BY pd.warehouse_id ";
             // echo $sql;exit;
            $query = $this->db->query($sql);
            // json_encode ($query->row);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];      
            return $qty;
         }
         else{
             return 1;
         }
             // return 1;
        }

        public function getitemwarehouse($item_id,$type_id)
        {
          if($type_id != 3){
          $sql="SELECT sum( pd.qty*pd.conv_from ) 
                    AS qty,w.warehouse_id AS ware_id,w.warehouse_name AS warehouse_name  
                    FROM ". DB_PREFIX . "item_warehouse AS pd
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id ) 
                    LEFT JOIN " . DB_PREFIX . "warehouses w ON ( w.warehouse_id = pd.warehouse_id )                    
                    WHERE i.id='".$item_id."' GROUP BY pd.warehouse_id";
                    // echo $sql;exit;
                    $query = $this->db->query($sql);
            return $query->rows;
          }
          else{
              return 1;
          }
        }
        public function bl_get_purchase_items($inv_id, $item_id){ 
            $inv ="";
            if($inv_id!=""){
                $inv =  " AND inv.invoice_id!=".$inv_id;
            }
           $sql = "SELECT sum( pd.inv_item_quantity ) 
                    AS qty 
                    FROM ". DB_PREFIX . "po_invoice_detail AS pd
                    LEFT JOIN " . DB_PREFIX . "po_invoice inv ON ( pd.inv_id = inv.invoice_id )
                    LEFT JOIN " . DB_PREFIX . "item i ON ( pd.inv_item_id = i.id )
                    LEFT JOIN " . DB_PREFIX . "category c ON ( c.id = i.category_id )                    
                    WHERE i.id='".$item_id."' AND inv.invoice_status >= '2'".$inv;
            
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];            
            return $qty;
        }
        public function getitemwarehouse_reorder($item_id)
        {
         

          $sql=" SELECT wo.warehouse_id,w.warehouse_name,wo.reorder_qty FROM warehouse_reorder wo LEFT JOIN warehouses w ON ( wo.warehouse_id = w.warehouse_id ) WHERE item_id='".$item_id."' UNION SELECT w.warehouse_id,w.warehouse_name,w.reorder_qty FROM warehouses w WHERE NOT EXISTS(SELECT wo.warehouse_id, wo.reorder_qty,wo.reorder_qty FROM warehouse_reorder wo WHERE w.warehouse_id = wo.warehouse_id AND wo.item_id='".$item_id."')";
          // echo $sql;exit;
          $query = $this->db->query($sql);
             return $query->rows;
        }
        public function getitemwarehouse_all()
        {
          $sql="SELECT * FROM ". DB_PREFIX . " warehouses";
          // echo $sql;exit;
          $query = $this->db->query($sql);
             return $query->rows;
        }
        public function sumitemwarehouse_reorder($item_id)
        {
          $sql="SELECT SUM(reorder_qty) AS qty FROM ". DB_PREFIX . " warehouse_reorder WHERE item_id='".$item_id."'";
          // echo $sql;exit;
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
            echo $sql;exit;
            $query = $this->db->query($sql);
            $qty = $query->row['qty']==NULL ? 0 :$query->row['qty'];
            return $qty;
        }
        
        public function getBatchId(){
            $query = $this->db->query("SELECT max(batch_id) as batch_id  FROM ".DB_PREFIX."stock_adjust");
            $batch_id = $query->row['batch_id']==NULL?0:$query->row['batch_id'];
            return $batch_id;
        }
        
        public function saveAdjustedStock($data,$items){
            $date = $data['date'];
            $account = $data['adjust_account']; 
            $memos = $data['memo']; 
            $ware_id=$data['warehouse_id'];
            $adjustType=$data['adjustType'];
            $batch_id = $this->getBatchId();
            $batch_id = $batch_id+1;
            if($adjustType==1)
            {
            for($i=0;$i<count($items);$i++){
                $qty = $items[$i]->{'qtyDiff'};
                $conv_qty=$qty*$items[$i]->{'conv_from'};
                $total_asset = $conv_qty * $this->getPurchasePrice($items[$i]->{'id'}) ;
                if($items[$i]->{'adjust_id'}==0){
                    $this->db->query("INSERT INTO " . DB_PREFIX . "stock_adjust SET batch_id ='".$batch_id."', qty=".$qty.",conv_from=".$items[$i]->{'conv_from'}.",item_id='".$items[$i]->{'id'}."',acc_id='".$account."',updated_date='".$date."', memos='".$memos."'");

                    

                    $NewName = str_replace("'", "\'", $items[$i]->{'item'});
                    $last_id = $this->db->getLastId();                                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account."', journal_amount='".-1*$total_asset."', journal_details  = 'Stock Adjusted',item_id='".$items[$i]->{'id'}."',inv_id= 'A".$last_id."',currency_rate='1',currency_id='1',type='A', entry_date ='".$date."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='1', journal_amount='".$total_asset."', journal_details  = '".$NewName." Inventory Adjusted',inv_id= 'A".$last_id."',ref_id='".$last_journal_id."',currency_rate='1',type='A',currency_id='1', entry_date ='".$date."'");

                    
                    $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET inv_id ='0', item_id='".$items[$i]->{'id'}."',qty=".$qty.",conv_from='".$items[$i]->{'conv_from'}."',warehouse_id='".$ware_id."', unit_id='1', invoice_type='7' , invoice_status='{{Stock Adjust}}',inv_date='".date('Y-m-d')."'");                                 
                }
                else {
                    $this->db->query("UPDATE " . DB_PREFIX . "stock_adjust SET  qty=".$qty.",acc_id='".$account."',updated_date='".$date."' WHERE adjust_id='".$items[$i]->{'adjust_id'}."'");

                     $this->db->query("INSERT INTO " . DB_PREFIX . "item_warehouse SET inv_id ='0', item_id='".$items[$i]->{'id'}."',qty=".$qty.",conv_from='1',warehouse_id='".$ware_id."', unit_id='1', invoice_type='7' , invoice_status='{{Stock Adjust}}',inv_date='".date('Y-m-d')."'");

                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  acc_id='".$account."',journal_amount='".-1*$total_asset."',item_id='".$items[$i]->{'id'}."', entry_date ='".$date."' WHERE inv_id='A".$items[$i]->{'adjust_id'}."' AND journal_amount<0 AND type='A'"); 
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET  journal_amount='".$total_asset."',item_id='".$items[$i]->{'id'}."', journal_details  = '".$items[$i]->{'item'}." Inventory Adjusted', entry_date ='".$date."' WHERE inv_id='A".$items[$i]->{'adjust_id'}."' AND acc_id='1'  AND type='A'");                                 
                }
               //$this->updateAvgCost($items[$i]->{'id'}); 
            }

            }
             elseif($adjustType==2){
              $updateCost=0;
               for($i=0;$i<count($items);$i++){
                  $oldValue=$this->db->query("SELECT SUM(i.avg_cost*w.qty) AS amt FROM `item` i INNER JOIN item_warehouse w ON(w.item_id=i.id) WHERE i.id='".$items[$i]->{'id'}."'");
                  // echo $oldValue->row['amt'];exit;
                  $oldV=number_format($oldValue->row['amt'],2,'.','');
                  $newV=number_format($items[$i]->{'newValue'},2,'.','');
                    $NewName = str_replace("'", "\'", $items[$i]->{'item'});
                $updateCost=$items[$i]->{'newValue'} / $items[$i]->{'qty'};
                $NetAmount=$newV-$oldV;
                 $this->db->query("INSERT INTO " . DB_PREFIX . "stock_adjust SET batch_id ='".$batch_id."', qty='0',conv_from='0',item_id='".$items[$i]->{'id'}."',acc_id='".$account."',updated_date='".$date."', memos='".$memos."',adjust_amount='".$items[$i]->{'newValue'}."'");
                  $last_id = $this->db->getLastId();  
                  $this->db->query("UPDATE " . DB_PREFIX . " item SET  avg_cost=".$updateCost." WHERE id='".$items[$i]->{'id'}."'");

                   $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$account."', journal_amount='".-1*$NetAmount."', journal_details  = 'Stock Adjusted',item_id='".$items[$i]->{'id'}."',inv_id= 'A".$last_id."',currency_rate='1',currency_id='1',type='A', entry_date ='".$date."'"); 
                    $last_journal_id = (int)$this->db->getLastId();  
                    $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='1', journal_amount='".$NetAmount."', journal_details  = '".$NewName." Inventory Adjusted',inv_id= 'A".$last_id."',ref_id='".$last_journal_id."',currency_rate='1',type='A',currency_id='1', entry_date ='".$date."'");
               }
            } 
        }
 
        private function getPurchasePrice($item_id){
            $query = $this->db->query("SELECT avg_cost,normal_price  FROM ".DB_PREFIX."item WHERE id='".$item_id."' ");
            return $query->row['avg_cost']==0?$query->row['normal_price']:$query->row['avg_cost'];
        }
        public function getAdjustBatch($data){
            $sql = "SELECT i.sale_price as sale_price, i.avg_cost as avg_cost, s.* FROM ".DB_PREFIX."stock_adjust s
                LEFT JOIN ".DB_PREFIX."item i ON (s.item_id = i.id)
                        WHERE batch_id='".$data["batch_id"]."'
                            ";          
  $query = $this->db->query($sql);
  return $query->rows;
        }
        public function previousId($id){
            $query = $this->db->query("SELECT batch_id FROM " . DB_PREFIX . "stock_adjust WHERE batch_id<'".$id."' ORDER BY batch_id  DESC LIMIT 1"); 
            $pre_id = 0;
            if($query->num_rows){
                $pre_id = $query->row['batch_id'];
            }
            return $pre_id;
        }
        public function nextId($id){
            $query = $this->db->query("SELECT batch_id FROM " . DB_PREFIX . "stock_adjust WHERE batch_id>'".$id."' ORDER BY batch_id  LIMIT 1"); 
            $next_id = 0;
            if($query->num_rows){
                $next_id = $query->row['batch_id'];
            }
            return $next_id;
        }
        
        public function adjustBarcode($data){
            $result = "";
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE item_code='".$data["barcode"]."'");
            if($query->num_rows){
                $adjusted_item = $query->row;
                $qty = $adjusted_item['quantity'] + $this->get_adjust_items($adjusted_item['id'])+ $this->get_purchase_items($adjusted_item['id']) - $this->get_sale_items($adjusted_item['id']);
                
                $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "item WHERE id='".$data["item_id"]."'");
                $existing_qty = $query2->row["quantity"];                
                $this->db->query("UPDATE " . DB_PREFIX . "item SET quantity=".($existing_qty+$qty)."  WHERE id='".$data["item_id"]."'"); 
                $this->db->query("UPDATE " . DB_PREFIX . "item SET item_code='',item_status=0  WHERE id='".$adjusted_item['id']."'");
           
                $result = "Item Adjusted properly";
            }
            else{
                $result ="Item doesn't exist with this barcode";
            }
            
            return $result;
        }
        
        public function deleteUnitUom($data){
            $this->db->query("UPDATE " . DB_PREFIX . "item SET purchase_unit=sale_unit  WHERE id='".$data["item_id"]."'");
            $result = "";
            $query = $this->db->query("DELETE FROM " . DB_PREFIX . "unit_mapping WHERE item_id='".$data["item_id"]."' AND uom_id='".$data['uom']."'");
            if($query){
                $query2 = $this->db->query("DELETE FROM " . DB_PREFIX . "uom_barcodes WHERE item_id='".$data["item_id"]."' AND uom_id='".$data['uom']."'"); 
                if($query2){
                    $result = "Item Unit Successfully Deleted";
                } else {
                    $result = "Item Unit are not Deleted";
                }
            }
            else{
                $result ="Something went wrong Please try again";
            }
            
            return $result;
        }

        public function insert_warehouse_reorder($data)
        {
          if($data['qty']!='')
          {
             $query = $this->db->query("DELETE FROM " . DB_PREFIX . "warehouse_reorder WHERE item_id='".$data["item_id"]."' AND warehouse_id='".$data['warehouse_id']."'");
            if($query)
            {
               $this->db->query("INSERT INTO " . DB_PREFIX . "warehouse_reorder SET 
                    `item_id`='".$data['item_id']."', 
                    `warehouse_id`='".$data['warehouse_id']."', 
                    `reorder_qty`='".$data["qty"]."'
                    ");
            }
          }
           
           

        }

        public function getitempreferd_vendor($id)
        {
              $sql="SELECT * FROM (SELECT p.vendor_id FROM `po_invoice` p INNER JOIN po_invoice_detail po ON po.inv_id = p.invoice_id WHERE po.inv_item_id='".$id."' ORDER BY p.invoice_id DESC LIMIT 1 ) po_invoice UNION ALL SELECT NULL";   
               $query = $this->db->query($sql);
            $vendor = $query->row['vendor_id']==NULL ? 0 :$query->row['vendor_id'];
            return $vendor;    
        }
}
?>
