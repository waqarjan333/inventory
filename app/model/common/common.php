<?php
class ModelCommonCommon extends Model {  
       public function getCategories(){
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category 
		 WHERE status = '1' ORDER BY id ASC"); 
		return $query->rows;
       }
       public function getTypes(){
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "type 
		 WHERE status = '1' ORDER BY id ASC"); 
		return $query->rows;
       }
        public function getPaymentMethods(){
           $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "payment_methods 
		 WHERE method_status = '1' ORDER BY method_id ASC"); 
		return $query->rows;
       }
       
       public function getWarehouses(){
           $query = $this->db->query("SELECT *,warehouse_id as id FROM " . DB_PREFIX . "warehouses 
		 WHERE warehouse_isactive = '1' ORDER BY id ASC"); 
		return $query->rows;
       }

           public function getAssetAccount(){
           $query = $this->db->query("SELECT acc_id,acc_name FROM " . DB_PREFIX . "account_chart 
     WHERE acc_id != '-1' AND acc_type_id ='3' ORDER BY acc_id ASC"); 
    return $query->rows;
       }
      
       public function getAccounts(){
           $query = $this->db->query("SELECT *,acc_id as id FROM " . DB_PREFIX . "account_chart 
		 WHERE acc_type = '0' ORDER BY acc_name ASC"); 
		return $query->rows;
       }
       
       public function getPriceLevels(){
           $query = $this->db->query("SELECT *,level_id as id FROM " . DB_PREFIX . "price_level 
		 ORDER BY level_name ASC"); 
		return $query->rows;
       }
      public function getTreeCategories(){
          $data = $this->getCategories();
          //$category_list = $this->MakeTree($results); 
            $itemsByReference = array();

            // Build array of item references:
            foreach($data as $key => &$item) {
               $itemsByReference[$item['id']] = &$item;
               $itemsByReference[$item['id']]['children'] = array();
               // Empty data class (so that json_encode adds "data: {}" ) 
               if($item['id']=="1"){
                   $itemsByReference[$item['id']]['iconCls'] = 'root-icon';
               }
               $itemsByReference[$item['id']]['expanded'] = true;
            }

            // Set items as children of the relevant parent item.
            foreach($data as $key => &$item)
               if($item['parent_id'] && $itemsByReference[$item['parent_id']]!='0')
                  $itemsByReference [$item['parent_id']]['children'][] = &$item;

            // Remove items that were added to parents elsewhere:
            foreach($data as $key => &$item) {
               if($item['parent_id'] && $itemsByReference[$item['parent_id']]!='0')
                  unset($data[$key]);
            }
            
            return $data;
      }
      
      public function deleteCategory($data){
          $sql = "DELETE FROM ".DB_PREFIX."category 
        		WHERE id='".$data['id']."'";    
          $query = $this->db->query($sql);
           $this->db->query("UPDATE ".DB_PREFIX."category SET 
                        parent_id='".$data['parent_id']."'
        		WHERE parent_id='".$data['id']."'");
           $this->db->query("UPDATE ".DB_PREFIX."item SET 
                        category_id='1'
        		WHERE category_id='".$data['id']."'");
          return $query;
      }
      
      public function getCustomerGroup(){
          $sql = "SELECT * FROM ".DB_PREFIX."customer_groups 
            WHERE 1"; 
          $query = $this->db->query($sql); 
          $results = $query->rows;
          $groups_array = array();
          foreach ($results as $result) {
                 $groups_array['groups'][] = array(
                        'id'             => $result['id'],
                        'cust_group_name'             => $result['cust_group_name'],
                        'cust_group_code'                  => str_pad($result['id'], 5, "0", STR_PAD_LEFT),
                        'cust_group_isdefault'                  => $result['cust_group_isdefault']                        
                    );
             }
             
         return $groups_array['groups'];    
      }
      
      public function getCustomerType(){
          $sql = "SELECT * FROM ".DB_PREFIX."customer_types 
            WHERE 1"; 
          $query = $this->db->query($sql); 
          $results = $query->rows;
          $groups_array = array();
          foreach ($results as $result) {
                 $groups_array['types'][] = array(
                        'id'             => $result['id'],
                        'cust_type_name'             => $result['cust_type_name'],
                        'cust_type_code'                  => str_pad($result['id'], 5, "0", STR_PAD_LEFT),
                        'cust_type_isdefault'                  => $result['cust_type_isdefault']                        
                    );
             }
             
         return $groups_array['types'];    
      }
      
      public function getLastSaleId(){
           $sql = "SELECT max(invoice_id) as max_id FROM ".DB_PREFIX."pos_invoice WHERE invoice_type='2' AND sale_return=0 ";
           $query = $this->db->query($sql); 
           return $query->row['max_id'];
      } 
      public function getLastTransferId(){
           $sql = "SELECT max(invoice_no) as max_id FROM ".DB_PREFIX."stock_transfer ";
           $query = $this->db->query($sql); 
           return $query->row['max_id'];
      }
      
      public function getLastPOId(){
           $sql = "SELECT max(invoice_id) as max_id FROM ".DB_PREFIX."po_invoice ";
           $query = $this->db->query($sql); 
           return $query->row['max_id'];
      }
      
      public function getSalesrep(){
         $sql = "SELECT * FROM ".DB_PREFIX."salesrep 
        		";  
         $query = $this->db->query($sql); 
         return $query->rows;
      }
      
      public function saveItem($data){          
          $cogs_id = 2;
          $sale_id =5;
          $asset_id =1;
          $part_no =(isset($data["part_number"]) && !empty($data["part_number"]))?$data["part_number"]:NULL;
          $quantity =(isset($data["quantity"]) && !empty($data["quantity"]))?$data["quantity"]:0;
          $weight = 0;
          $reorder_point =0;
          $this->db->query("INSERT INTO " . DB_PREFIX . "item SET 
                    item_name = '".$data["name"]."',
                    item_code = '".$data["barcode"]."',
                    category_id = '".$data["cat_id"]."',
                    type_id = '1',
                    picture = '',
                    sort_order = '".$this->getOrder($data["cat_id"]) ."',
                    quantity = '".$quantity."',
                    reorder_point = '".$reorder_point."',   
                    part_number = '".$part_no."',
                    normal_price='".$data["nprice"]."',
                    weight='".$weight."',    
                    avg_cost='".$data["nprice"]."',
                    sale_price='".$data["sprice"]."',
                    cogs_acc='".$cogs_id."',
                    sale_acc='".$sale_id."',
                    unit='8',    
                    asset_acc='".$asset_id."',
                    item_map_id='0',    
                    vendor='0',
                    added_date='".$data['item_date']."',
                    sale_unit='1',
                    purchase_unit='1'
                    ");
          
          $last_id = $this->db->getLastId();
          
          $this->db->query("INSERT INTO " . DB_PREFIX . "unit_mapping SET 
                    item_id = '".$last_id."',
                    uom_id = '0',
                    unit_id = '1',
                    conv_from = '1',
                    conv_to = '1',
                    sale_price = '".$data["sprice"]."',   
                    created_date = '".$data['item_date']."',
                    updated_date='".$data['item_date']."'
                    ");
          $this->db->query("INSERT INTO " . DB_PREFIX . "uom_barcodes SET 
                    item_id = '".$last_id."',
                    uom_id = '0',
                    barcode = '".$data["barcode"]."',
                    upc = '1'
                    ");
          //Adding Journal entries
          if($quantity!=0){
            $total_asset = $quantity*$data["nprice"];            
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='".$asset_id."', journal_amount='".$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',item_id='".$last_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['item_date']."'"); 
            $last_journal_id = (int)$this->db->getLastId();  
            $this->db->query("UPDATE " . DB_PREFIX . "account_journal SET ref_id='".$last_journal_id."' WHERE journal_id='".$last_journal_id."'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "account_journal SET acc_id='6', journal_amount='".-1*$total_asset."', journal_details  = 'Item Stock Entry',inv_id= '0',ref_id='".$last_journal_id."',currency_rate='1',currency_id='1',type='E', entry_date ='".$data['item_date']."'"); 
          }  
          
          $result_array = array(
                "id" =>$last_id
            );
          
          return $result_array;
        }
        private function getOrder($cat_id){
            $sql = "SELECT count(*) as order_no FROM ".DB_PREFIX."item WHERE category_id='".$cat_id."'";
            $query = $this->db->query($sql);
            return intval($query->row['order_no'])+1;
        }
        public function checkNameExists($data){
            $condition = '';            
            $sql = "SELECT * FROM ".DB_PREFIX."item
                        WHERE item_name='".$data['name']."' ".$condition;
            $query = $this->db->query($sql);
            return $query->num_rows;
        }
        
        public function checkBarCodeExists($data){
            $rows = 0;
                        $Newbarcode = str_replace("'", "\'", $data);
            if($data['barcode']!=""){
                $condition = '';                
                $sql = "SELECT * FROM ".DB_PREFIX."item
                            WHERE item_code='".$Newbarcode."' ".$condition;
                $query = $this->db->query($sql);
                $rows =  $query->num_rows;
            }
            return $rows;
        }
        
        public function getBalance($data){
            $condition = '';            
            $sql = "SELECT sum(journal_amount) as balance FROM ".DB_PREFIX."account_journal
                        WHERE acc_id='".$data['acc_id']."'";
                        // echo $sql;exit;
            $query = $this->db->query($sql);
            $_balance = $query->row['balance']==NULL?0:$query->row['balance'];
            return $_balance;
        }
        
        public function saveInvoiceDescription($data)
        {
          $sql="UPDATE ".$data['table']."_invoice SET custom='".$data['desc']."' WHERE invoice_id=".$data['id']."";
          $this->db->query($sql);
        }

        public function getSingleItemQtyDetail($item_id,$ware_id)
        {
           if($ware_id==0)
         {
          $ware=" AND warehouse_id !=''";
         }                                  
         else{
          $ware=" AND warehouse_id ='".$ware_id."'";
         } 
          $sql="SELECT item_id,SUM(CASE WHEN `invoice_type`!='' THEN qty*conv_from ELSE 0 END) AS QtyOnHand, SUM(CASE WHEN `invoice_type`='6' THEN qty*conv_from ELSE 0 END) AS OpeningQty, SUM(CASE WHEN `invoice_type`='2' THEN qty*conv_from ELSE 0 END) AS SaleQty, SUM(CASE WHEN `invoice_type`='4' THEN qty*conv_from ELSE 0 END) AS PurchaseQty, SUM(CASE WHEN `invoice_type`='7' THEN qty*conv_from ELSE 0 END) AS AdjustQty, SUM(CASE WHEN `invoice_type`='1' THEN qty*conv_from ELSE 0 END) AS S_RetunQty, SUM(CASE WHEN `invoice_type`='5' THEN qty*conv_from ELSE 0 END) AS P_ReturnQty FROM item_warehouse WHERE item_id='$item_id' ".$ware." GROUP BY item_id ";
          // echo $sql;exit;
             $query=$this->db->query($sql);
             if($query->num_rows>1)
             {
              $results = $query->rows;
             }
             else{
              $results = $query->row;
             }
            
            return $results;
        }
        
        public function getSOPayMethods(){
          $sql = "SELECT * FROM ".DB_PREFIX."account_chart where acc_type_id=8 or acc_type_id=16 or acc_id=-1"; 
          $query = $this->db->query($sql);                                  
          return $query->rows;    
      }
      public function getGroup(){
		$sql = "SELECT * FROM ".DB_PREFIX."customer_groups"; 
        	$query = $this->db->query($sql);
		return $query->rows;
	}
      public function saveSettings($data){
          $sql = "SELECT * FROM ".DB_PREFIX."store_settings WHERE `key`='".$data["key"]."'";
          $query = $this->db->query($sql);
          $rows =  $query->num_rows;          
          if(!$rows){
              $this->db->query("INSERT INTO " . DB_PREFIX . "store_settings SET `group` = '" . $this->db->escape('sale') . "', `key` = '" . $this->db->escape($data["key"]) . "', `value` = '" . $this->db->escape($data["config_saleterms_value"]) . "', updated=NOW()");
          }
          else{
              $this->db->query("UPDATE " . DB_PREFIX . "store_settings SET `group` = '" . $this->db->escape('sale') . "', `value` = '" . $this->db->escape($data["config_saleterms_value"]) . "', updated=NOW() WHERE `key` = '" . $this->db->escape($data["key"]) . "'");
          }
      }
      
      public function getSettings(){
          $sale_terms = "";
          $sql = "SELECT * FROM ".DB_PREFIX."store_settings WHERE `key`='config_saleterms'";
          $query = $this->db->query($sql);
          if($query->rows){
              $sale_terms = $query->row["value"];
          }
          return $sale_terms;
      }
      
      public function getUnits($item_id){
            $this->db->query('SET SQL_BIG_SELECTS=1');
            $sql = "SELECT um.item_id as item_id, um.uom_id as uom_id,SUM(w.qty*w.conv_from/um.conv_from) AS conv_qty, um.sale_price as sprice,(i.normal_price*um.conv_from) as nprice,um.conv_from as conv_from, u.name as unit_name,u.id as unit_id FROM ".DB_PREFIX."unit_mapping um
                   LEFT JOIN ".DB_PREFIX."units u ON (um.unit_id = u.id)
                   LEFT JOIN ".DB_PREFIX."item i ON (um.item_id = i.id)
                     LEFT JOIN item_warehouse w ON (um.item_id =w.item_id)
                    WHERE um.item_id='".$item_id."' GROUP BY um.unit_id ORDER BY um.uom_id" ;
            $query = $this->db->query($sql);
            return $query->rows;
        }
      public function getPriceLevel($item_id)
      {
          $check="SELECT count(l_id) AS count FROM price_level_per_item WHERE item_id='".$item_id."'";
                      // echo $check;
                      $chExe=$this->db->query($check);
                      $chRow=$chExe->row;
                      if($chRow['count']==0){
                      
      $sql="SELECT 'Base Sale Price' AS head,sale_price,'level_id','item'  FROM item WHERE id='".$item_id."' UNION SELECT level_name,(level_dir*level_per),level_id,level_compare_price FROM price_level";
         $query = $this->db->query($sql);
          $results = $query->rows;
          $groups_array = array();
          $Price=0;
          $base=0;
           foreach ($results as $result) {
           
              // var_dump($result['item']);
              if($result['item']!=1)
              {
                if($result['head']=='Base Sale Price')
              {
                $base=$result['sale_price'];
                 $Price=$result['sale_price'];
                
              }else{
                    
                       $precent=$result['sale_price']/100*$base;
                  
                    $Price=$base+$precent;
                    
                
                 
              }
               $groups_array['priceLevel'][] = array(
                        'head'             => $result['head'],
                        'sale_price'       => $Price                      
                    );
            
              }
              

                
             }

             
         return $groups_array['priceLevel'];   
                                }
           else{
             $sql="SELECT 'Base Sale Price' AS head,sale_price,'level_id','item'  FROM item WHERE id='".$item_id."' UNION SELECT level_name,(level_dir*level_per),level_id,level_compare_price  FROM price_level";
         $query = $this->db->query($sql);
          $results = $query->rows;
          $groups_array = array();
          $Price=0;
          $base=0;
               foreach ($results as $result) {
             
                   if($result['head']=='Base Sale Price')
              {
                $base=$result['sale_price'];
                 $Price=$result['sale_price'];
                
              }else{
                    if($result['sale_price'] !='-0')
                    {
                       $precent=$result['sale_price']/100*$base;
                  
                    $Price=$base+$precent;
                    }
                    else{
                       if($result['level_id'] !='level_id')
                    {
                      $check="SELECT count(l_id) AS count FROM price_level_per_item WHERE item_id='".$item_id."'";
                      // echo $check;
                      $chExe=$this->db->query($check);
                      $chRow=$chExe->row;
                      if($chRow['count']!=0)
                      {
                        // echo 'worig';
                         $sql="SELECT * FROM price_level_per_item WHERE l_id='".$result['level_id']."' AND item_id='".$item_id."'";
                      // echo $sql;exit;
                       $query = $this->db->query($sql);
                      $res = $query->row;
                      $precent=$res['item_per_level']/100*$base;
                  
                      $Price=$base+$precent;
                      }
                     
                    } 

                    }
                

              }

               $groups_array['priceLevel'][] = array(
                        'head'             => $result['head'],
                        'sale_price'       => $Price                      
                    );
     }
      return $groups_array['priceLevel'];   
             }
             
        
                                
             }
             
             public function unit_price_uom($data)
      {
        $getID="SELECT id FROM item WHERE id='".$data['item_id']."'";
        $query = $this->db->query($getID);
                      $ID = $query->row;
                      $ItemID=$ID['id'];
           if($ItemID!=0)
          {

         $check="SELECT count(l_id) AS count FROM price_level_per_item WHERE item_id='".$ItemID."'";
                      // echo $check;exit;
                      $chExe=$this->db->query($check);
                      $chRow=$chExe->row;
           if($chRow['count']==0){
             $sql="SELECT 'Base Sale Price' AS head,sale_price,'level_id','item' FROM unit_mapping WHERE item_id=".$ItemID." AND unit_id=".$data['unit_id']." UNION SELECT level_name,(level_dir*level_per),level_id,level_compare_price FROM price_level WHERE price_level.level_type !=2";
        // echo $sql;exit;
         $query = $this->db->query($sql);
          $results = $query->rows;
          $groups_array = array();
          $Price=0;
          $base=0;
       
              foreach ($results as $result) {
              if($result['head']=='Base Sale Price')
              {
                $base=$result['sale_price'];
                 $Price=$result['sale_price'];
                
              }else{
                    $precent=$result['sale_price']/100*$base;
                  
                    $Price=$base+$precent;
              }

                 $groups_array['priceLevel'][] = array(
                        'head'             => $result['head'],
                        'sale_price'       => $Price                      
                    );
             }
              return $groups_array['priceLevel']; 
           }
           else{
              $sql="SELECT 'Base Sale Price' AS head,sale_price,'level_id','item' FROM unit_mapping WHERE item_id=".$ItemID." AND unit_id=".$data['unit_id']." UNION SELECT  level_name,(level_dir*level_per),level_id,level_compare_price FROM price_level";
               $query = $this->db->query($sql);
          $results = $query->rows;
          $groups_array = array();
          $Price=0;
          $base=0;
            foreach ($results as $result) {
             
                   if($result['head']=='Base Sale Price')
              {
                $base=$result['sale_price'];
                 $Price=$result['sale_price'];
                
              }else{
                    if($result['sale_price'] !='-0')
                    {
                       $precent=$result['sale_price']/100*$base;
                  
                    $Price=$base+$precent;
                    }
                    else{
                       if($result['level_id'] !='level_id')
                    {
                      $check="SELECT count(l_id) AS count FROM price_level_per_item WHERE item_id='".$ItemID."'";
                      // echo $check;
                      $chExe=$this->db->query($check);
                      $chRow=$chExe->row;
                      if($chRow['count']!=0)
                      {
                        // echo 'worig';
                         $sql="SELECT * FROM price_level_per_item WHERE l_id='".$result['level_id']."' AND item_id='".$ItemID."'";
                      // echo $sql;exit;
                       $query = $this->db->query($sql);
                      $res = $query->row;
                      $precent=$res['item_per_level']/100*$base;
                  
                      $Price=$base+$precent;
                      }
                     
                    } 

                    }
                

              }

               $groups_array['priceLevel'][] = array(
                        'head'             => $result['head'],
                        'sale_price'       => $Price                      
                    );
     }
      return $groups_array['priceLevel']; 
           }                 
       
          }

         
             
          
            // return $query->rows;
      }  
      public function getBarcodes($item_id, $uom_id){
            $sql = "SELECT barcode FROM ".DB_PREFIX."uom_barcodes WHERE item_id=".$item_id." AND uom_id =".$uom_id; 
            $query = $this->db->query($sql); 
            $results = $query->rows;
            return $results;
            
        }
        public function getitemUnitSalePrice($item_id, $uom_id){
            $sql = "SELECT sale_price FROM ".DB_PREFIX."unit_mapping WHERE item_id=".$item_id." AND uom_id =".$uom_id; 
            $query = $this->db->query($sql); 
            $results = $query->row['sale_price'];
            return $results;
            
        }
        public function getitemUoM($item_id,$unit_id){
            $sql = "SELECT uom_id FROM ".DB_PREFIX."unit_mapping WHERE item_id=".$item_id." AND unit_id=".$unit_id; 
            $query = $this->db->query($sql); 
            $results = $query->row['uom_id'];

           return $results;
            
        }
        public function updateRemarks($data){
            $po_remarks = isset($data["remarks"])?$data["remarks"]:NULL;
            $sql = "UPDATE ".DB_PREFIX."po_invoice SET custom='".$po_remarks."' WHERE invoice_id=".$data['inv_id']; 
            $query = $this->db->query($sql); 
            
        }
       
      public function securityQuestion(){
            $sql = "SELECT id, question FROM ".DB_PREFIX."security_question"; 
            $query = $this->db->query($sql);
            return $query->rows;
        }
      
        public function saveSecurityQuestions($data){
            $username = "";
            $password = "";
        if(isset($data['update_username']) && !empty($data['update_username'])){
            $username = "username = '" . $this->db->escape($data['update_username']) . "',";
        }
        if(isset($data['conform_password']) && !empty($data['conform_password'])){
            $password = "password = '" . $this->db->escape(md5($data['conform_password'])) . "',";
        }
        $query = $this->db->query("UPDATE " . DB_PREFIX . "siteusers SET 
                    ".$username."
                    ".$password."
                    update_pass='1' WHERE su_id= '".$data['user_id']."'");
        $query1 = $this->db->query("INSERT INTO " . DB_PREFIX . "answer(user_id, question_id, answer) VALUES ('20','".$data['question_1']."','".$data['answer_1']."')");
        $query2 = $this->db->query("INSERT INTO " . DB_PREFIX . "answer(user_id, question_id, answer) VALUES ('20','".$data['question_2']."','".$data['answer_2']."')");
        if($query && $query1 && $query2){ 
            $this->session->data['update_pass'] = '1';
            return true;
        }
        }
        public function getUserAccess($user_id){            
             $sql = "SELECT * FROM ".DB_PREFIX."user_settings           
                        WHERE user_id='".$user_id."'    
        		";
                //echo $sql;
                $query = $this->db->query($sql);
                if ($query->num_rows) {
		return $query->row['user_rigths'];
                } else {
                    return null;
                }
		
	}
        public function sendSMS($data){
            $url = "";
            $api_token = $data['password'];
            $api_secret = $data['username'];
            $to = $data['to'];
            $from = $data['from'];
            $message = $data['message'];
            if (strlen($data['message']) != strlen(utf8_decode($data['message'])))
            {
$url = "http://sms.aursoft.com/plain?api_token=".urlencode($api_token)."&api_secret=".urlencode($api_secret)."&to=".$to."&from=".urlencode($from)."&type=unicode&message=".urlencode($message)."";
            } else {
                $url = "http://sms.aursoft.com/plain?api_token=".urlencode($api_token)."&api_secret=".urlencode($api_secret)."&to=".$to."&from=".urlencode($from)."&message=".urlencode($message)."";
            }
$ch  =  curl_init();
$timeout  =  30;
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$response = curl_exec($ch);
curl_close($ch);
return $response;
      }
      public function getCustomerId($su_id){
           $sql = "SELECT howDidYouHear FROM ".DB_PREFIX."siteusers           
                        WHERE su_id='".$su_id."'    
        		";            
            $query = $this->db->query($sql);
            if ($query->num_rows) {
            return $query->row['howDidYouHear'];
            } else {
                return 0;
            }
      }
}
?>