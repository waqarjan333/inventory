<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardItem extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
           
            
        }
       
        public function saveItem(){
            $this->load->model('dashboard/item');
            $this->load->language('dashboard/item'); 
            $save_item = array();
            if(!$this->model_dashboard_item->checkNameExists($this->request->post)){
                if(!$this->model_dashboard_item->checkBarCodeExists($this->request->post)){
                    if($this->request->post['item_hidden_id']==0){
                        $results = $this->model_dashboard_item->saveItem($this->request->post,$this->request->files);
                    }
                    else{
                        $results = $this->model_dashboard_item->updateItem($this->request->post,$this->request->files);
                    }

                    $save_item['success'] = 1;
                    $save_item['obj_id'] = $results["id"];
                    $save_item['picture_path'] = $results["url"];
                    $save_item['msg'] = $this->language->get('msg_save_success');
                }
                else{
                    $save_item['success'] = 0;
                    $save_item['msg'] = $this->language->get('msg_barcode_exists');
                }
            }
            else{
                $save_item['success'] = 0;
                $save_item['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        public function saveuom(){
        $this->load->model('dashboard/item');
        $this->load->language('dashboard/item');
        $data = $this->request->post;
        $this->model_dashboard_item->delbarcode($data['item_id']);
        if($data['uom_combo_base']!=""){ $this->CheckBarcode($data, 'base');}
        if($data['conv_from_1']!=""){ $this->CheckBarcode($data, '1'); }
        if($data['conv_from_2']!=""){ $this->CheckBarcode($data, '2'); }
        if($data['conv_from_3']!=""){ $this->CheckBarcode($data, '3'); }
    }

        public function getCat()
    {
          $this->load->model('dashboard/item');
             $this->load->model('common/common'); 
             $results = $this->model_dashboard_item->getCat();             
             $items_array = array();
             foreach ($results as $result) {
                 // $res=str_replace("&amp;", '&', $result['name']); 
                 // $cat_name=str_replace("&quot;", '"', $res);
                    if($result['name']==NULL)
                    {
                        $result['name']="Default";
                    }
                 $cat_name=$result['parent']." → ".$result['name'];
                 $items_array['categories'][] = array(
                        'id'                        => $result['id'],
                        'name'                      => $result['parent'],
                        'parent'                      =>$result['name']
                    );
                   $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
    }
    
    }
    public function savestocktransfer()
    {
         $this->load->model('dashboard/item');
            $this->load->library('json');
            $so_details = (array)Json::decode(html_entity_decode($this->request->post['trans']));
             $results = $this->model_dashboard_item->savetransfer($this->request->post,$so_details);
             $stock_item = array();
             $success=true;
                    
            $this->load->library('json');
            $this->response->setOutput(Json::encode($success), $this->config->get('config_compression'));
    }
    private function CheckBarcode($data, $type){
        $this->load->model('dashboard/item');
        $this->load->language('dashboard/item');
        
        $save_uom = array();
        $save_uom['upc']=$data["upc_".$type];
        $upc = $this->model_dashboard_item->CheckBarcodes($data["upc_".$type]);
        
        if($upc=="" || $upc=="0"){
            $save_uom['success'] = 1;
            $items_upc = array(
           'item_id'            => $data['item_id'], 
           'uom_type'           => $data["uom_".$type],
            'barcode'       => $data["upc_".$type],
            'upc_type'          => '1',
            );
            $this->model_dashboard_item->savebarcode($items_upc);
            
            $barcode_lookups = $data["lookup_".$type];
            $result = substr($barcode_lookups, 1, -1);
            $code = explode(',', $result);
            $barcode  = preg_replace("/&#?[a-z0-9]{2,8};/i","",$code);
            if (is_array($barcode) || is_object($barcode)){
                foreach($barcode as $lookups){

                    $lookup = $this->model_dashboard_item->CheckBarcodes($lookups);
                    $save_uom['lookup']=$lookups;
                    if($lookup=="" || $lookup=="0"){
                       $save_uom['success'] = 1;
                       $items_lookup = array(
                        'item_id'            => $data['item_id'], 
                        'uom_type'           => $data["uom_".$type],
                         'barcode'           => $lookups,
                         'upc_type'          => '0',
                         );
                       $this->model_dashboard_item->savebarcode($items_lookup);
                    } else {
                     $save_uom['success'] = 0;
                     $save_uom['msg'] = "Lookup " . $type .  '&nbsp"' . $lookups . '"&nbsp' . " already Exit";     
                   }
                   
                }
        }
        } else{
          $save_uom['success'] = 0;
          $save_uom['msg'] = 'UPC ' . $type . '&nbsp"'. $data["upc_".$type] . '"&nbsp' . " already Exit";  
        }
        
    if($save_uom['success'] === 1){
       $save_uom['success'] = 1;
       $items_uom = array(
           'item_id'            => $data['item_id'], 
           'uom_type'           => $data["uom_".$type], 
           'uom_combo_type'     => $data["uom_combo_".$type],
           'conv_from_type'     => $data["conv_from_".$type],
           'conv_to_type'       => $data["conv_to_".$type],
           'upc_type'           => $data["upc_".$type],
           'lookup_type'        => $data["lookup_".$type],
           'sale_price_type'    => $data["sale_price_".$type], 
           'avg_cost_type'    => $data["avg_cost_".$type], 
           'sale_uom_combo'     => $data['sale_uom_combo'], 
           'purchase_uom_combo' => $data['purchase_uom_combo']
        );
        $this->model_dashboard_item->save_uom($items_uom); 
    } else {
        $save_uom['success'] = 0;
    }
    
    $this->load->library('json');
    $this->response->setOutput(Json::encode($save_uom), $this->config->get('config_compression'));    
    }
        
        private function fetchItems($status=0){
             $this->load->model('dashboard/item');
             $this->load->model('common/common');
             $this->load->language('dashboard/item'); 
             $results = $this->model_dashboard_item->getItems($this->request->get,$status);             
             $items_array = array();
             $items_array["totalCount"] =  $results[0];
             // echo $results[0];exit;
             // var_dump( $this->request->get);exit;
             //$ware_id = array('ware_id' =>0);
             $ware_id=0;
            
             foreach ($results[1] as $result) {
                 $ItemQty= $this->model_common_common->getSingleItemQtyDetail($result['id'],$ware_id);
                  // $priceLevel=$this->model_common_common->getPriceLevel($result['id']);
                  // $priceLevel['head'];
                 $res=str_replace("&amp;", '&', $result['item_name']); 
                 $item_name=str_replace("&quot;", '"', $res);
                 $items_array['items'][] = array(
                'id'                        => $result['id'],
                'item'                      => $item_name,
                'item_status'               => ($result['item_status']==1)?$this->language->get('text_active'):$this->language->get('text_deactive'),
                'type'                      => $result['type_id'],
                'weight'                    => $result['weight'],
                'qty'                       => $ItemQty['QtyOnHand'],
                'category'                  => $result['cat_name'],
                'nprice'                    => $result['normal_price'],
                'navg_cost'                 => $result['avg_cost'],
                'sprice'                    => $result['sale_price'],
                'sale_unit'                 => $result['sale_unit'],
                'purchase_unit'             => $result['purchase_unit'],
                'sale_item_uom'             => $result['sale_unit'],
                'purchase_item_uom'         => $result['purchase_unit'],
                'barcode'                   => $result['item_code'],
                'item_status_id'               => $result['item_status'],
                'item_units'                => $this->model_common_common->getUnits($result['id']),
                'item_Plevel'                => $this->model_common_common->getPriceLevel($result['id']),
                'item_warehouses'           => $this->model_dashboard_item->getitemwarehouse($result['id'],$result['type_id'] ),
                     );
             }
            return $items_array;
        }

        public function unit_price_uom()
        {
             $this->load->model('dashboard/item');
             $this->load->model('common/common');
             $this->load->language('dashboard/item'); 
             $result= $this->model_common_common->unit_price_uom($this->request->post); 
               $this->load->library('json');
             $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        }

        public function Updateunit_price_uom()
        {
             $this->load->model('dashboard/item');
             $this->load->model('common/common');
             $this->load->language('dashboard/item'); 
             $result= $this->model_dashboard_item->Updateunit_price_uom($this->request->post); 
               $this->load->library('json');
             $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        }
        //   public function save_uom_price2()
        // {
        //      $this->load->model('dashboard/item');
        //      $this->load->model('common/common');
        //      $this->load->language('dashboard/item'); 
        //      $result= $this->model_dashboard_item->unit_price_uom_2($this->request->post); 
        //        $this->load->library('json');
        //      $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        // }
        //  public function save_uom_price3()
        // {
        //      $this->load->model('dashboard/item');
        //      $this->load->model('common/common');
        //      $this->load->language('dashboard/item'); 
        //      $result= $this->model_dashboard_item->unit_price_uom_3($this->request->post); 
        //        $this->load->library('json');
        //      $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        // }
        
        public function fetchSingleItem()
        {
             $this->load->model('dashboard/item');
             $this->load->model('common/common');
             $this->load->language('dashboard/item'); 
             $result = $this->model_dashboard_item->getsingleItem($this->request->get); 
             $res=str_replace("&amp;", '&', $result['item_name']); 
             $item_name=str_replace("&quot;", '"', $res);
             $ware_id=0;
             $items_array = array();
           $items_array['items'][] = array(
                'item'                      =>  $item_name,
                'type'                      =>  $result['type_id'],
                'conv_from'                 =>  '1',
                'qty'                       =>  $this->model_dashboard_item->get_warehouse_items($result['id'],$ware_id),
                'item_units'                =>  $this->model_common_common->getUnits($result['id']),
                'item_warehouses'           =>  $this->model_dashboard_item->getitemwarehouse($result['id'],$result['type_id'] ),
             );
            $this->load->library('json');
             $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
            
        
        private function fetchPurchaseItems($status=0){
             $this->load->model('dashboard/item');
             $this->load->model('common/common');
             $this->load->language('dashboard/item'); 
             $results = $this->model_dashboard_item->getItems($this->request->get,$status);             
             $items_array = array();
             $items_array["totalCount"] =  $results[0];
             // echo $results[0];exit;
             // var_dump( $this->request->get);exit;
             // $ware_id = array('ware_id' =>0);
             $ware_id = 0;
             foreach ($results[1] as $result) {
                 $ItemQty= $this->model_common_common->getSingleItemQtyDetail($result['id'],$ware_id);
                 if($result['type_id'] != 3){
                 $res=str_replace("&amp;", '&', $result['item_name']); 
                 $item_name=str_replace("&quot;", '"', $res);
                 $items_array['items'][] = array(
                'id'                 =>     $result['id'],
                'item'               =>     $item_name,
                'item_status'        =>     ($result['item_status']==1)?$this->language->get('text_active'):$this->language->get('text_deactive'),
                'type'               =>     $result['type_id'],
                'weight'             =>     $result['weight'],
                'qty'                =>     $ItemQty['QtyOnHand'],
                'category'           =>     $result['cat_name'],
                'nprice'             =>     $result['normal_price'],
                'navg_cost'          =>     $result['avg_cost'],
                'sprice'             =>     $result['sale_price'],
                'sale_unit'          =>     $result['sale_unit'],
                'purchase_unit'      =>     $result['purchase_unit'],
                'sale_item_uom'      =>     $result['sale_unit'],
                'purchase_item_uom'  =>     $result['purchase_unit'],
                'barcode'            =>     $result['item_code'],
                'item_units'         =>     $this->model_common_common->getUnits($result['id']),
                'item_warehouses'    =>     $this->model_dashboard_item->getitemwarehouse($result['id'],$result['type_id'] ),
                     );
                 }
             }
            return $items_array;
        }
         public function getItems(){
             $items = $this->fetchItems();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($items), $this->config->get('config_compression'));
         }
         
         public function getPurchaseItems(){
             $items = $this->fetchPurchaseItems();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($items), $this->config->get('config_compression'));
         }

         public function warehouseitemslist()
         {
             $this->load->model('common/common');
           $this->load->model('dashboard/item');
            $this->load->language('dashboard/item'); 
              $ware_id=0;
             $results = $this->model_dashboard_item->getwarehouseItemslist($this->request->get);
             $items = array(); 

                foreach ($results as $result) {
                    $ware_id=0;
                     $ItemQty= $this->model_common_common->getSingleItemQtyDetail($result['id'],$ware_id);
                 $res=str_replace("&amp;", '&', $result['item_name']); 
                 $item_name=str_replace("&quot;", '"', $res);
                 $items['items'][] = array(
                        'id'                        => $result['id'],
                        'item'                      => $item_name,
                        'item_status'               => ($result['status']==1)?$this->language->get('text_active'):$this->language->get('text_deactive'),
                        'type'                      => $result['type_id'],
                        'qty'                       =>$ItemQty['QtyOnHand'],
                        // 'qty'                       =>$this->model_dashboard_item->get_warehouse_items($result['id'],$ware_id),
                        'category'                  => $result['cat_name'],
                        'nprice'                    => $result['normal_price'],
                        'navg_cost'                 => $result['avg_cost'],
                        'sprice'                    => $result['sale_price'],
                        'sale_unit'                 => $result['sale_unit'],
                        'purchase_unit'             => $result['purchase_unit'],
                        'sale_item_uom'             => $result['sale_unit'],
                        'purchase_item_uom'         => $result['purchase_unit'],
                        'barcode'                   => $result['barcode'],
                        'item_units'                => $this->model_common_common->getUnits($result['id']),
                        'item_warehouses'           => $result['warehouse']
                    );
                 $this->load->library('json');
             $this->response->setOutput(Json::encode($items), $this->config->get('config_compression'));
             }
            
         }
         public function getStockItems(){
             $this->load->model('dashboard/item');
               $this->load->model('common/common');
             $items = array();
             $data=$this->request->get;
              //if(isset($data['warehouse_id']))
                //{
                    // echo $data['warehouse_id'];exit;
                   $results = $this->model_dashboard_item->getadjustwarehouseitems($this->request->get,1);
                   $items["totalCount"] = $results[0];
                   $ware_id=0;
                       foreach ($results[1] as $result) {
              $ItemQty= $this->model_common_common->getSingleItemQtyDetail($result['id'],$ware_id);
               $totalValue=$ItemQty['QtyOnHand']*$result['avg_cost'];   
                 $items['items'][] = array(
                        'id'             => $result['id'],
                        'item'             => $result['item_name'],
                        'salePrice'             => $result['sale_price'],
                        'avg_cost'             => $result['avg_cost'],
                        'purchasePrice'             => $result['avg_cost'],
                        'qty'             => number_format($ItemQty['QtyOnHand'],2,'.',''),
                        'item_description' => $result['cat_name'],      
                         'item_units'      =>$this->model_common_common->getUnits($result['id']),   
                        'newQty' =>"0",
                        'totalValue' =>number_format($totalValue,2,'.',''),
                        'newValue' =>"0",
                        'adjust_id' =>"0",
                        'conv_from' =>"1"
                    );
             }
               // }
             //    else{
             //       $results = $this->model_dashboard_item->getStockItems($this->request->get,1); 
             //       $items["totalCount"] = $results[0];
             //          foreach ($results[1] as $result) {
             
             //     $items['items'][] = array(
             //            'id'             => $result['id'],
             //            'item'             => $result['item_name'],
             //            'salePrice'             => $result['sale_price'],
             //            'purchasePrice'             => $result['avg_cost'],
             //            'qty'             => number_format($result['quantity'] + $this->model_dashboard_item->get_adjust_items($result['id']) + $this->model_dashboard_item->get_purchase_items($result['id']) - $this->model_dashboard_item->get_sale_items($result['id']),2,'.',''),
             //            'item_description' => $result['cat_name'],                        
             //            'newQty' =>"0",
             //            'adjust_id' =>"0"
             //        );
             // }
             //    }
             
             // $data=$results['warehouse_id'];
                   
             $this->load->library('json');
             $this->response->setOutput(Json::encode($items), $this->config->get('config_compression'));
         }

         public function getuom()
         {
             $this->load->model('dashboard/item');
                 $units = array();
             $data=$this->request->post;
             // var_dump($data);
             $results=$this->model_dashboard_item->getuom($data);
              foreach ($results as $result) {
                 $units['units'][] = array(
                        'item_id'             => $result['item_id'],
                        'uom_id'             => $result['uom_id'],
                        'sprice'             => $result['sprice'],
                        'nprice'             => $result['nprice'],
                        'conv_from' => $result['conv_from'],              
                        'conv_qty' => number_format($result['conv_qty'],2,'.',''),              
                        'unit_name' => $result['unit_name'],              
                         'unit_id'      =>$result['unit_id']
                    );
             }
                 $this->load->library('json');
             $this->response->setOutput(Json::encode($units), $this->config->get('config_compression'));
         }

         public function get_warehouse_reorder()
         {
          $this->load->model('dashboard/item');
            $data=$this->request->post;
             // var_dump($data);
             $results=$this->model_dashboard_item->insert_warehouse_reorder($data);
         }
           public function get_item_warehouse_reorder_qty()
         {
          $this->load->model('dashboard/item');
            $data=$this->request->get;
             // var_dump($data);

            
             $reorder = array();
            $item_id=$data['item_id'];
            if($data['warehouse_url']==1)
            {
            $results=$this->model_dashboard_item->getitemwarehouse_all(); 
            }
            else{
             $results=$this->model_dashboard_item->getitemwarehouse_reorder($item_id);  
            }
             
              foreach ($results as $result) {

                if($data['warehouse_url']==1)
                {
                    $reorder_qty='0';
                }
                else{
                    $reorder_qty=$result['reorder_qty'];
                }
                 $reorder['reorder'][] = array(
                        'warehouse_id'        => $result['warehouse_id'],
                        'warehouse_name'        => $result['warehouse_name'],
                        'reorder_qty'             => $reorder_qty
                    );
             }
                 $this->load->library('json');
             $this->response->setOutput(Json::encode($reorder), $this->config->get('config_compression'));   
         }

         public function getItem(){
             $this->load->model('dashboard/item');
             $this->load->model('common/common');
             // var_dump($this->request->get);exit;
             $result = $this->model_dashboard_item->getItem($this->request->get);
             $cust_fields = $this->model_dashboard_item->getItemFields($this->request->get);
             //////////////////////////////////////////////////////////////////////////////////
             
             $get_Uombase_lookup = $this->model_dashboard_item->getUombase_lookup($this->request->get);
             $get_Uom1_lookup = $this->model_dashboard_item->getUom1_lookup($this->request->get);
             $get_Uom2_lookup = $this->model_dashboard_item->getUom2_lookup($this->request->get);
             $get_Uom3_lookup = $this->model_dashboard_item->getUom3_lookup($this->request->get);
             
             
             /////////////////////////////////////////////////////////////////////////////////
             $get_Uombase = $this->model_dashboard_item->getUombase($this->request->get);
             $get_Uom1 = $this->model_dashboard_item->getUom1($this->request->get);
             $get_Uom2 = $this->model_dashboard_item->getUom2($this->request->get);
             $get_Uom3 = $this->model_dashboard_item->getUom3($this->request->get);
             $items_array = array();
             $ware_id=0;
             $ItemQty= $this->model_common_common->getSingleItemQtyDetail($result['id'],$ware_id);
             $items_array['item_id'] = $result['id'];
             $items_array['item_name'] = $result['item_name'];
             $items_array['item_type'] = $result['type_id'];
             $items_array['item_quantity'] = number_format($ItemQty['QtyOnHand'],2,'.','');
             $items_array['item_part_no'] = $result['part_number'];
             $items_array['item_cat_id'] = $result['category_id'];
             $items_array['item_nprice'] = number_format($result['normal_price'],2,'.','');              
             $items_array['item_avgcost'] = number_format($result['avg_cost'],2,'.','');    
             $items_array['item_vendor_id'] = $result['vendor'];    
             $items_array['item_sprice'] = $result['sale_price'];
             $items_array['item_status'] = $result['item_status'];  
             $items_array['item_cogs_acc'] = $result['cogs_acc'];  
             $items_array['item_sale_acc'] = $result['sale_acc'];  
             $items_array['item_asset_acc'] = $result['asset_acc'];  
             $items_array['item_barcode'] = $result['item_code'];  
             $items_array['item_unit'] = $result['unit'];  
             $items_array['item_weight'] = $result['weight'];               
             $items_array['item_picture'] = $result['picture'];  
             $items_array['item_map_id'] = $result['item_map_id'];
             $items_array['sale_unit'] = $result['sale_unit'];
             $items_array['purchase_unit'] = $result['purchase_unit'];
             $items_array['item_reorder_point'] = $result['reorder_point'];
             $items_array['item_color'] = (isset($cust_fields['item_1']))?$cust_fields['item_1']:"";
             $items_array['item_size'] = (isset($cust_fields['item_2']))?$cust_fields['item_2']:"";
             $items_array['item_brand'] = (isset($cust_fields['item_3']))?$cust_fields['item_3']:"";
             $items_array['item_units'] = $this->model_dashboard_item->get_item_units($result['id']);
             $items_array['item_warehouses'] = $this->model_dashboard_item->getitemwarehouse($result['id'],$result['type_id']);
             $items_array['item_warehouses_reorder'] = $this->model_dashboard_item->getitemwarehouse_reorder($result['id']);
             $items_array['preferd_vendor'] = $this->model_dashboard_item->getitempreferd_vendor($result['id']);
             //Base Unit Values
             $check_base_count = $this->model_dashboard_item->check_base_unit_count($this->request->get);
             if($check_base_count > 0){
             $items_array['uom_base_mapping_id'] = $get_Uombase['id'];
             $items_array['uom_base_item_id'] = $get_Uombase['item_id'];
             $items_array['uom_base_uom_id'] = $get_Uombase['uom_id'];
             $items_array['uom_base_unit_id'] = $get_Uombase['unit_id'];
             $items_array['uom_base_conv_from'] = $get_Uombase['conv_from'];
             $items_array['uom_base_conv_to'] = $get_Uombase['conv_to'];
             $items_array['uom_base_sale_price'] = $get_Uombase['sale_price'];
             }
             //UOM 1 Values
             $check_1_count = $this->model_dashboard_item->check_1_unit_count($this->request->get);
             if($check_1_count > 0){
             $items_array['uom_1_mapping_id'] = $get_Uom1['id'];
             $items_array['uom_1_item_id'] = $get_Uombase['item_id'];
             $items_array['uom_1_uom_id'] = $get_Uom1['uom_id'];
             $items_array['uom_1_unit_id'] = $get_Uom1['unit_id'];
             $items_array['uom_1_conv_from'] = $get_Uom1['conv_from'];
             $items_array['uom_1_conv_to'] = $get_Uom1['conv_to'];
             $items_array['uom_1_sale_price'] = $get_Uom1['sale_price'];
             }
             //UOM 2 Values
             $check_2_count = $this->model_dashboard_item->check_2_unit_count($this->request->get);
             if($check_2_count > 0){
             $items_array['uom_2_mapping_id'] = $get_Uom2['id'];
             $items_array['uom_2_item_id'] = $get_Uombase['item_id'];
             $items_array['uom_2_uom_id'] = $get_Uom2['uom_id'];
             $items_array['uom_2_unit_id'] = $get_Uom2['unit_id'];
             $items_array['uom_2_conv_from'] = $get_Uom2['conv_from'];
             $items_array['uom_2_conv_to'] = $get_Uom2['conv_to'];
             $items_array['uom_2_sale_price'] = $get_Uom2['sale_price'];
             }
             //UOM 3 Values
             $check_3_count = $this->model_dashboard_item->check_3_unit_count($this->request->get);
             if($check_3_count > 0){
             $items_array['uom_3_mapping_id'] = $get_Uom3['id'];
             $items_array['uom_3_item_id'] = $get_Uombase['item_id'];
             $items_array['uom_3_uom_id'] = $get_Uom3['uom_id'];
             $items_array['uom_3_unit_id'] = $get_Uom3['unit_id'];
             $items_array['uom_3_conv_from'] = $get_Uom3['conv_from'];
             $items_array['uom_3_conv_to'] = $get_Uom3['conv_to'];
             $items_array['uom_3_sale_price'] = $get_Uom3['sale_price'];
             }
             
             $check_base_upc_count = $this->model_dashboard_item->base_upc_count($this->request->get);
             if($check_base_upc_count > 0){
              $get_Uombase_upc = $this->model_dashboard_item->getUombase_upc($this->request->get);
              $items_array['Uombase_upc'] = $get_Uombase_upc;
             }
             $check_uom1_upc_count = $this->model_dashboard_item->uom1_upc_count($this->request->get);
             if($check_uom1_upc_count > 0){
              $get_Uom1_upc = $this->model_dashboard_item->getUom1_upc($this->request->get);
              $items_array['Uom1_upc'] = $get_Uom1_upc;
             }
             
             $check_uom2_upc_count = $this->model_dashboard_item->uom2_upc_count($this->request->get);
             if($check_uom2_upc_count > 0){
              $get_Uom2_upc = $this->model_dashboard_item->getUom2_upc($this->request->get);
              $items_array['Uom2_upc'] = $get_Uom2_upc;
             }
             
             $check_uom3_upc_count = $this->model_dashboard_item->uom3_upc_count($this->request->get);
             if($check_uom3_upc_count > 0){
              $get_Uom3_upc = $this->model_dashboard_item->getUom3_upc($this->request->get);
              $items_array['Uom3_upc'] = $get_Uom3_upc;
             }
             ////////////////////////////////////////////////////////////////////////////////////////
             ////////////////////////////////////////////////////////////////////////////////////////
             $check_base_barcode_count = $this->model_dashboard_item->base_barcode_count($this->request->get);
             if($check_base_barcode_count > 0){
              $items_array['Uombase_lookup'] = $get_Uombase_lookup;
             }
             $check_uom1_barcode_count = $this->model_dashboard_item->uom1_barcode_count($this->request->get);
             if($check_uom1_barcode_count > 0){
             $items_array['uom_1_lookup'] = $get_Uom1_lookup;
             }
             $check_uom2_barcode_count = $this->model_dashboard_item->uom2_barcode_count($this->request->get);
             if($check_uom2_barcode_count > 0){
             $items_array['uom_2_lookup'] = $get_Uom2_lookup;
             }
             $check_uom3_barcode_count = $this->model_dashboard_item->uom3_barcode_count($this->request->get);
             if($check_uom3_barcode_count > 0){
             $items_array['uom_3_lookup'] = $get_Uom3_lookup;
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
         }
         public function changeState(){
            $this->load->model('dashboard/item');
            $result = $this->model_dashboard_item->changeState($this->request->post);
            $save_item = array();
            if($result==1 || $result==0){
                $save_item['action'] = 'success';
                $save_item['msg'] = $result;                
            }
            else{
                $save_item['action'] = 'failed';
                $save_item['msg'] = $result;
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        public function savecateogory(){

            $this->load->model('dashboard/item');
            $this->load->model('common/common');
            $this->load->language('dashboard/item'); 
            $save_category = array();
            if(!$this->model_dashboard_item->checkCategoryExists($this->request->post)){
                $results = $this->model_dashboard_item->saveCategory($this->request->post);
                $save_category['success'] = 1;
                $save_category['obj_id'] = $results;
                $save_category['data'] = $this->model_common_common->getCategories();
                $save_category['tree_data'] = $this->model_common_common->getTreeCategories();
                $save_category['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_category['success'] = 0;
                $save_category['msg'] = $this->language->get('msg_name_category_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_category), $this->config->get('config_compression'));
            
        }
        
        public function deletecategory(){            
            $this->load->model('common/common');
            
            $this->model_common_common->deleteCategory($this->request->post);
             
            $delete_category = array();
            $delete_category['success'] = true;
            $delete_category['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_category), $this->config->get('config_compression'));
        }
        public function gbarcode(){
            $this->load->model('dashboard/item');
            $barcode = array();
            $code = $this->getBarCode();
            while($this->model_dashboard_item->checkBarCode($code)){
                $code = $this->getBarCode();
            }
            $barcode ['code'] = $code;
            $this->load->library('json');
            $this->response->setOutput(Json::encode($barcode), $this->config->get('config_compression'));
        }
        private function barCodeSize(){
            $code = $this->getBarCode();
            while($this->model_dashboard_item->checkBarCode($code)){
                $code = $this->getBarCode();
            }
            return $code;
        }
        private function  getBarCode(){
            mt_srand((double)microtime()*1000);
            $charid = strtoupper(uniqid(rand(), true));
            $uuid = '';
            $conf_barcode_digit = $this->config->get('config_barcdoe_digits')=="5"?5:11;            
            $uuid = $uuid.substr($charid, 0, $conf_barcode_digit);
            return $uuid;
        }
        
        public function createItems(){
             $this->load->model('dashboard/item'); 
             $items_array = array();             
             $data = $this->request->post;             
             $map_id = 0;
             $this->load->library('json');
             $cells = Json::decode(html_entity_decode($data['items']),true);                          
             if($data['map_id']=="0"){
                $mapping_no = $this->model_dashboard_item->getMappingNo();                
                $map_id = isset($mapping_no) ? $mapping_no+1 : 1;                                                                 
             }
             else{
                 $map_id = $data['map_id'];                 
             }             
             $item_id = 0;
             for($i=0;$i<count($cells);$i++){     
                 $cell_array = (array)$cells[$i]; 
                 if($cells[$i]->{'edit_id'}=="0"){                                        
                    $cell_array['item_map_hidden_id'] =  $map_id;
                    $cell_array['barcode']=$this->barCodeSize();
                    $_temp= $this->model_dashboard_item->saveItem($cell_array, NULL);
                    $item_id=$_temp["id"];
                 }
                 else{
                     $item_id=$cells[$i]->{'edit_id'};
                     $this->model_dashboard_item->updateItem($cell_array, NULL);                     
                 }
                 $items_array[$cells[$i]->{'id'}]  = $item_id;
                 
                 $this->model_dashboard_item->saveMapping($cells[$i],$map_id,$item_id);
             }
             
             $items_array['success'] = 1;
             $items_array['map_id'] = $map_id;
                           
             $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        public function getMapItems(){
            $this->load->model('dashboard/item');
            $items_array = array();  
            $type = array();  
            $ware_id=0;
            $type['type_id']=1;
            $results = $this->model_dashboard_item->getMappingItems($this->request->get);
             foreach ($results as $result) {
                 $item_quantity = $this->model_dashboard_item->get_warehouse_items($result['id'],$ware_id,$type['type_id']);
                 $items_array['mapping_details'][] = array(
                        'cell_id'             => $result['cell_id'],
                        'top_head'             => $result['top_head'],
                        'left_head'             => $result['left_head'],
                        'item_id'             => $result['item_id'],
                        'qty'             => $item_quantity                         
                    );
             }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        public function saveAdjustedStock(){
            $this->load->model('dashboard/item');            
            $this->load->library('json');
            $items_array = array();  
            $items = (array)Json::decode(html_entity_decode($this->request->post['adjusted_items']));   
            $this->model_dashboard_item->saveAdjustedStock($this->request->post,$items);
            $items_array['success'] = 1;
            $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        public function batchCount(){
            $this->load->model('dashboard/item');            
            $this->load->library('json');
            $items_array = array();  
            $items_array['batch_count'] = $this->model_dashboard_item->getBatchId();
            $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        
        public function getBatchAdjust(){
           $this->load->model('dashboard/item');            
           $this->load->library('json');
           $items_array = array();  
           $results = $this->model_dashboard_item->getAdjustBatch($this->request->get);
             foreach ($results as $result) {                
                 $items_array['batch'][] = array(
                        'adjust_id'             => $result['adjust_id'],
                        'item_id'             => $result['item_id'],
                        'salePrice'             => $result['sale_price'],
                        'purchasePrice'             => $result['avg_cost'],
                        'qty'             => $result['qty'],
                        'acc_id'             => $result['acc_id'],
                        'memo'             => $result['memos'],
                        'updated_date'             => date($this->language->get('date_format'), strtotime($result['updated_date']))                        
                    );
             }
             $items_array['next'] = $this->model_dashboard_item->nextId($this->request->get["batch_id"]);
             $items_array['prev'] = $this->model_dashboard_item->previousId($this->request->get["batch_id"]);
            $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        
        public function adjustBarcode(){
           $this->load->model('dashboard/item');            
           $this->load->library('json');
           $item_array = array();  
           $result = $this->model_dashboard_item->adjustBarcode($this->request->post);
           $item_array["message"]=$result;
           $this->load->library('json');
           $this->response->setOutput(Json::encode($item_array), $this->config->get('config_compression'));
        }
        
        public function deleteUnitUom(){
           $this->load->model('dashboard/item');            
           $this->load->library('json');
           $item_array = array();  
           $result = $this->model_dashboard_item->deleteUnitUom($this->request->post);
           $item_array["message"]=$result;
           $this->load->library('json');
           $this->response->setOutput(Json::encode($item_array), $this->config->get('config_compression'));
        }
        
        public function printlabelItem(){
            $qty = $this->request->post['quantity'];
            $design = '{
                        "cmd": [{
			"textArray": [{
                            "text": "'.$this->request->post['store_name'].'",
                            "font": "24",
                            "XPosition": "5",
                            "YPosition": "20"
			},
			{
                            "text": "Ph : 0945826262",
                            "font": "24",
                            "XPosition": "5",
                            "YPosition": "50"
			},
			{
                            "text": "'.$this->request->post['item_name'].'",
                            "font": "24",
                            "XPosition": "5",
                            "YPosition": "160"
			},
			{
                            "text": "Rs:'.$this->request->post['price'].'",
                            "font": "24",
                            "XPosition": "150",
                            "YPosition": "160"
			}],
			"Barcode": {
                            "type": "Code 128",
                            "data": "'.$this->request->post['barcode'].'",
                            "XPosition": "5",
                            "YPosition": "80",
                            "height": "60"
			},
			"border": "true",
                        "Quantity": "'.$qty.'"
                        }],
                        "width": "36",
                        "height": "19",
                        "column": "3",
                        "user": "1543401136334"
                    }';
            
            
           //echo $design;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://apologetic-minister-59792.herokuapp.com/api/printlabel",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $design,
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"                
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $result = array();
            $result["message"] = $response;
            $result["error"] = $err;
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        }
    }
?>
