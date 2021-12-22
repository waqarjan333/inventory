<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardPos extends Controller { 
        public function index() {
            //Load Controller            
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }    
            // else if($this->siteusers->isPosOpen()){
            //     $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            // }
            else {
                $this->getPOS();
            }
  	}
        
        public function getPOS(){
             $this->language->load('dashboard/pos');
             
             $this->data['url_dashboard'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/home');
             $this->data['url_logout'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=dashboard/logout');
             $this->data['full_name'] = $this->siteusers->getFullName();
             $this->data['category_list'] = $this->getCategory();
             $this->data['item_list'] = $this->getItems();
             
             $this->data['lang'] = $this->language->get('code');
             $this->data['direction'] = $this->language->get('direction');
             
             $this->data['url_getdetails'] = HTTP_SERVER.'index.php?route=dashboard/pos/getCategoryItems';
             $this->data['url_search'] = HTTP_SERVER.'index.php?route=dashboard/pos/search';
             $this->data['url_scan_item'] = HTTP_SERVER.'index.php?route=dashboard/pos/scanItem';
             $this->data['url_get_customer'] = HTTP_SERVER.'index.php?route=dashboard/pos/getCustomer';
             $this->data['url_save_invoice'] = HTTP_SERVER.'index.php?route=dashboard/pos/saveInvoice';
             $this->data['url_invoices_list'] = HTTP_SERVER.'index.php?route=dashboard/pos/getInvoices';
             $this->data['url_invoice_details'] = HTTP_SERVER.'index.php?route=dashboard/pos/getInvoiceDetail';
             $this->data['url_del_item_invoice'] = HTTP_SERVER.'index.php?route=dashboard/pos/deleteItem';
             $this->data['url_del_invoice'] = HTTP_SERVER.'index.php?route=dashboard/pos/deleteInvoice';
             $this->data['url_set_item_order'] = HTTP_SERVER.'index.php?route=dashboard/pos/setOrder';
             $this->data['url_get_items']= HTTP_SERVER.'index.php?route=dashboard/pos/getAllItems';
             $this->data['url_search_items']= HTTP_SERVER.'index.php?route=dashboard/pos/getAllItems';
             $this->data['url_display_total']= HTTP_SERVER.'index.php?route=dashboard/pos/displayOnPool';
             $this->data['url_fetch_invoice_list']= HTTP_SERVER.'index.php?route=dashboard/pos/fetchInvoices';  
             $this->data['url_save_item']= HTTP_SERVER.'index.php?route=dashboard/pos/saveItem';  
             $this->data['url_save_customer']= HTTP_SERVER.'index.php?route=dashboard/pos/saveCustomer'; 
             $this->data['url_reset_pos']= HTTP_SERVER.'index.php?route=dashboard/pos/resetPosOpen'; 
             $this->data['url_getTodaySale']= HTTP_SERVER.'index.php?route=dashboard/pos/getTodaySale'; 
             $this->data['site_logo'] = HTTP_SERVER."images/" . $this->config->get('config_logo');
             $this->data['pos_policy'] =  $this->config->get('config_meta_policy');
             
             $this->data['heading_title'] = $this->language->get('heading_title');            
             $this->data['button_close'] = $this->language->get('button_close');            
             $this->data['text_close'] = $this->language->get('button_close');            
             $this->data['text_empty_cart'] = $this->language->get('text_empty_cart');            
             $this->data['text_empty_return'] = $this->language->get('text_empty_return'); 
             $this->data['text_sale_return'] = $this->language->get('text_sale_return'); 
             
             $this->data['text_cash_journal'] = $this->language->get('text_cash_journal');  
             $this->data['text_cash_payment'] = $this->language->get('text_cash_payment');  
             $this->data['text_last_completed'] = $this->language->get('text_last_completed');  
             $this->data['text_on_account'] = $this->language->get('text_on_account'); 
             $this->data['text_total'] = $this->language->get('text_total');
             $this->data['text_paid'] = $this->language->get('text_total');
             $this->data['text_cash'] = $this->language->get('text_cash');
             
             $this->data['text_invoice_margin'] = $this->language->get('text_invoice_margin'); 
             
             $this->data['text_qty'] = $this->language->get('text_qty'); 
             $this->data['text_disc'] = $this->language->get('text_disc');
             $this->data['text_price'] = $this->language->get('text_price');
             $this->data['text_ret'] = $this->language->get('text_ret');
             $this->data['text_search_products'] = $this->language->get('text_search_products');
             $this->data['text_received'] = $this->language->get('text_received');
             $this->data['text_tendered'] = $this->language->get('text_tendered');
             $this->data['text_change'] = $this->language->get('text_change');
             
             $this->data['text_paid'] = $this->language->get('text_paid');
             $this->data['text_remaining'] = $this->language->get('text_remaining');
             $this->data['text_total_after_discount'] = $this->language->get('text_total_after_discount');
             $this->data['text_discount'] = $this->language->get('text_discount');
             $this->data['text_discount_in'] = $this->language->get('text_discount_in');
             $this->data['text_deduction'] = $this->language->get('text_deduction');
             $this->data['text_deduction_in'] = $this->language->get('text_deduction_in');
             $this->data['text_discount_invoice'] = $this->language->get('text_discount_invoice');             
             $this->data['text_pay_method'] = $this->language->get('text_pay_method');
             
             $this->data['text_back'] = $this->language->get('text_back');
             $this->data['button_cancel'] = $this->language->get('button_cancel');
             $this->data['text_next_order'] = $this->language->get('text_next_order');
             $this->data['text_validate'] = $this->language->get('text_validate');
             $this->data['button_print'] = $this->language->get('button_print'); 
             $this->data['button_pay'] = $this->language->get('button_pay'); 
             $this->data['title_payment'] = $this->language->get('title_payment'); 
             $this->data['button_print_next'] = $this->language->get('button_print_next');  
             
             $this->data['text_layout'] = $this->language->get('text_layout');
             $this->data['text_layout_a4'] = $this->language->get('text_layout_a4');
             $this->data['text_layout_small'] = $this->language->get('text_layout_small');
             $this->data['text_layout_dotmatrix'] = $this->language->get('text_layout_dotmatrix');
             
             $this->data['text_receipt'] = $this->language->get('text_receipt');
             $this->data['text_sale_receipt'] = $this->language->get('text_sale_receipt');
             
             $this->data['text_user'] = $this->language->get('text_user');
             $this->data['text_contact'] = $this->language->get('text_contact');
             $this->data['text_dated'] = $this->language->get('text_dated');
             $this->data['text_print'] = $this->language->get('text_print');
             $this->data['text_inv_des'] = $this->language->get('text_inv_des');
             $this->data['text_inv_qty'] = $this->language->get('text_inv_qty');
             $this->data['text_inv_rate'] = $this->language->get('text_inv_rate');
             $this->data['text_inv_amount'] = $this->language->get('text_inv_amount');
             $this->data['text_inv_totalqty'] = $this->language->get('text_inv_totalqty');
             $this->data['text_inv_subtotal'] = $this->language->get('text_inv_subtotal');
             
             $this->data['text_thanks_note'] = $this->language->get('text_thanks_note');
             $this->data['text_aursoft_footer'] = $this->language->get('text_aursoft_footer');
             
             $this->data['text_units'] = $this->language->get('text_units');
             $this->data['text_at'] = $this->language->get('text_at');
             $this->data['text_a'] = $this->language->get('text_a');
             $this->data['text_with'] = $this->language->get('text_with');
             $this->data['text_invoice'] = $this->language->get('text_invoice');
             
             $this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
             $this->data['text_print_date'] = $this->language->get('text_print_date');
             $this->data['text_billto'] = $this->language->get('text_billto');
             
             $this->data['text_welcome'] = $this->language->get('text_welcome');
             $this->data['text_scan_item'] = $this->language->get('text_scan_item');
             $this->data['text_select_customer'] = $this->language->get('text_select_customer');
             $this->data['text_address'] = $this->language->get('text_address');
             
             $this->data['text_menu_rename'] = $this->language->get('text_menu_rename');
             $this->data['text_menu_delete'] = $this->language->get('text_menu_delete');
             $this->data['text_menu_hold'] = $this->language->get('text_menu_hold');
             
             $this->data['text_invoice_name'] = $this->language->get('text_invoice_name');
             $this->data['text_new_invoice'] = $this->language->get('text_new_invoice');
             
             
             $this->data['label_item_name'] = $this->language->get('label_item_name');
             $this->data['label_item_category'] = $this->language->get('label_item_category');
             $this->data['label_item_qty_on_hand'] = $this->language->get('label_item_qty_on_hand');
             $this->data['label_item_bar_code'] = $this->language->get('label_item_bar_code');
             $this->data['label_item_sale_price'] = $this->language->get('label_item_sale_price');
             $this->data['label_item_purchase_price'] = $this->language->get('label_item_purchase_price');
             
             $this->data['plcholder_item_name'] = $this->language->get('plcholder_item_name');
             $this->data['plcholder_item_category'] = $this->language->get('plcholder_item_category');
             $this->data['plcholder_qty_on_hand'] = $this->language->get('plcholder_qty_on_hand');
             $this->data['plcholder_barcode'] = $this->language->get('plcholder_barcode');
             $this->data['plcholder_sale_price'] = $this->language->get('plcholder_sale_price');
             $this->data['plcholder_purchase_price'] = $this->language->get('plcholder_purchase_price');
             
             $this->data['button_save'] = $this->language->get('button_save');
             
             $this->data['new_customer_add'] = $this->language->get('new_customer_add');
             $this->data['plcholder_customer_name'] = $this->language->get('plcholder_customer_name');
             $this->data['plcholder_customer_obalance'] = $this->language->get('plcholder_customer_obalance');
             $this->data['plcholder_customer_phone'] = $this->language->get('plcholder_customer_phone');
             $this->data['plcholder_customer_mobile'] = $this->language->get('plcholder_customer_mobile');
             
             
             $this->data['text_load_invoices'] = $this->language->get('text_load_invoices');
             $this->data['new_item_add'] = $this->language->get('new_item_add');
             $this->data['col_name'] = $this->language->get('col_name');
             $this->data['col_customer'] = $this->language->get('col_customer');
             $this->data['col_status'] = $this->language->get('col_status');
             $this->data['col_amount'] = $this->language->get('col_amount');
             $this->data['col_date'] = $this->language->get('col_date');
             $this->data['button_load'] = $this->language->get('button_load');
             $this->data['text_untitled'] = $this->language->get('text_untitled');
             
             $this->load->model('dashboard/pos');
             $this->model_dashboard_pos->initSales();
             
             $invoice_no = $this->model_dashboard_pos->getInvoiceNo();             
             $this->data['invoice_no'] = $invoice_no;
             $this->data['user_type'] = $this->session->data['su_type'];
             
             $last_invoice = $this->model_dashboard_pos->lastCompleted();             
             $this->data['last_completed_invoice'] = number_format($last_invoice,2,'.','');
             
             $categories = array();
             $categories = $this->model_dashboard_pos->getCategories();
             $this->load->library('json');
             $this->data['categories'] =Json::encode($categories);
             
             $this->load->model('dashboard/customer');             
             $customers =$this->model_dashboard_customer->getCustomers($this->request->get,1);
             foreach ($customers as $result) {
                   $this->data['list_customers'][] = array(
                        'cust_id'             => $result['cust_id'],
                        'cust_name'           => $result['cust_name'],
                        'cust_status'         =>   $result['cust_status']
                   );
             }
             
             $this->load->model('dashboard/salesrep');             
             $getsalerep =$this->model_dashboard_salesrep->getSalesreps($this->request->get);
             foreach ($getsalerep as $result) {
                   $this->data['list_salerep'][] = array(
                        'salesrep_id'             => $result['id'],
                        'salesrep_name'             => $result['salesrep_name']
                   );
             }
             
             $this->load->model('common/common');             
             $getgroups_regions =$this->model_common_common->getGroup();
             foreach ($getgroups_regions as $result) {
                   $this->data['list_group'][] = array(
                        'group_id'             => $result['id'],
                        'group_name'             => $result['cust_group_name']
                   );
             }
             
             $this->load->model('common/common');             
             $methods =$this->model_common_common->getSOPayMethods();
             foreach ($methods as $result) {
                   $this->data['methods'][] = array(
                        'acc_id'             => $result['acc_id'],
                        'acc_name'           => $result['acc_name']
                   );
             }
             
             $this->model_dashboard_pos->posOpen(); 
             
             $this->template = $this->config->get('config_template') . '/template/dashboard/pos.tpl';
             $this->children = array();
             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
            
            
        }
       
        private function getCategory($parent_id=1){
            $this->language->load('dashboard/pos');
            $this->load->model('dashboard/pos');
            $results =  $this->model_dashboard_pos->getCategories($parent_id);
            return $results;
        }
        
        private function getItems($cat_id=1){
            $this->language->load('dashboard/pos');
            $this->load->model('dashboard/pos');
            $results =  $this->model_dashboard_pos->getItems($cat_id);
            $items_array = array();
              $this->load->model('dashboard/item');
            $ware_id = array('ware_id' =>0); 
            foreach ($results as $result) {
                 $items_array[] = array(
                        'id'             => $result['id'],
                        'item_code'             => $result['item_code'],
                        'item_map_id'             => $result['item_map_id'],
                        'item_name'                  => $result['item_name'],
                        'item_status'                  => $result['item_status'],
                        'markup'                  => $result['markup'],                        
                        'normal_price'                => $result['normal_price'],
                        'part_number'             => $result['part_number'],
                        'picture'             => $result['picture'],
                        'quantity'             => $this->model_dashboard_item->get_warehouse_items($result['id'],$ware_id),
                        'sale_acc'             => $result['sale_acc'],
                        'sale_price'             => number_format($result['sale_price'],2,'.',''),
                        'sort_order'             => $result['sort_order'],
                        'type_id'             => $result['type_id'],
                        'unit'               => $result['unit'],
                        'sale_unit'               => $result['sale_unit'],
                        'item_unit'               => $this->getunits($result['id']),
                        'added_date'             => $result['added_date'],
                        'asset_acc'             => $result['asset_acc'],
                        'avg_cost'             => $result['avg_cost'],
                        'category_id'             => $result['category_id'],
                        'cogs_acc'             => $result['cogs_acc'],
                     
                    );
             }
            return $items_array;
        }
        private function getunits($unit_id){
            $this->language->load('dashboard/pos');
            $this->load->model('dashboard/pos');
            $results =  $this->model_dashboard_pos->getunits($unit_id);
            $units_array = array();
            foreach ($results as $result) {
                 $units_array[] = array(
                        'item_id'             => $result['item_id'],
                        'uom_id'             => $result['uom_id'],
                        'unit_id'                  => $result['unit_id'],
                        'unit_name'                  => $result['unit_name'],
                        'conv_from'                  => $result['conv_from'],
                        'conv_to'                  => $result['conv_to'],    
                        'sale_price'             => $result['sale_price'],
                     
                    );
             }
            return $units_array;
        }
        public function getCategoryItems(){
            $detail_item = array();
            $cat_id = $this->request->get['cat_id'];
                         
            $detail_item['cats'] = $this->getCategory($cat_id);
            $detail_item['items'] = $this->getItems($cat_id);
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($detail_item), $this->config->get('config_compression'));
        }
        public function search(){
            $detail_item = array();
            $search = $this->request->get['search'];
             $this->load->model('dashboard/pos');
            $detail_item['items'] = $this->model_dashboard_pos->searchItem($search);
            $this->load->library('json');
            $this->response->setOutput(Json::encode($detail_item), $this->config->get('config_compression'));
        }
        public function scanItem(){
            $_item = array();
            $this->load->model('dashboard/pos');
            $barcode = $this->request->get['barcode'];
            $Newbarcode = str_replace("'", "\'", $barcode);
            $result = $this->model_dashboard_pos->getItem($Newbarcode);
                   $this->load->model('dashboard/item');
            $ware_id = array('ware_id' =>0); 
            if($result->num_rows){
                $_item['item_id'] = $result->row['id'];
                $_item['item_name'] = $result->row['item_name'];
                $_item['sale_price'] = $result->row['sale_price'];
                $_item['avg_cost'] = $result->row['normal_price'];
                $_item['quantity'] =  $this->model_dashboard_item->get_warehouse_items($result->row['id'],$ware_id);
                $_item['item_code'] = $result->row['barcode'];
                $_item['item_uom'] = $result->row['uom_id'];
                $_item['sale_unit'] = $result->row['sale_unit'];
                $_item['item_unit']  = $this->getunits($result->row['id']);
                
            }
             
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_item), $this->config->get('config_compression'));
        }
        
        public function getCustomer(){
            $this->load->model('dashboard/customer');
            $customer_address =$this->model_dashboard_customer->getCustomerAddress($this->request->get);
            $cust_details = array();
            $address_str = $customer_address['cust_address'];
            
            if(isset($customer_address['cust_mobile']) && $customer_address['cust_mobile']!=""){
                $address_str .= "\nMobile: ".$customer_address['cust_mobile'];
            }
            if(isset($customer_address['cust_phone']) && $customer_address['cust_phone']!=""){
                $address_str .= "\nPhone: ".$customer_address['cust_phone'];
            }
             if(isset($customer_address['cust_fax']) && $customer_address['cust_fax']!=""){
                $address_str .= "\nFax: ".$customer_address['cust_fax'];
             }
             if(isset($customer_address['cust_email']) && $customer_address['cust_email']!=""){
                $address_str .= "\nEmail: ".$customer_address['cust_email'];
             }
             
            $this->load->library('json'); 
            $cust_details['cust_address'] = $address_str;
            $p_level_record = $this->model_dashboard_customer->getPriceLevel($customer_address['cust_price_level']);
            if($p_level_record){
                $cust_details['cust_price_level'] = $p_level_record;
                if($p_level_record['level_type']=='2'){                
                    $cust_details['cust_price_level_items'] = $this->model_dashboard_customer->getItems($p_level_record['level_id']);
                }
            }
            $this->response->setOutput(Json::encode($cust_details), $this->config->get('config_compression'));
        }
        
        public function saveInvoice(){
            $this->language->load('dashboard/pos');
            $this->load->model('dashboard/pos');
            $data = $this->request->post;
            $data_sale = NULL;
            $this->load->library('json');
            if(isset($data['sales_detail'])){                
                $data_sale = (array)Json::decode(html_entity_decode($data['sales_detail']));
            }
            $result = array();
            if(!isset($data["returnMode"]) || $data["returnMode"]==""){
                $inv = $this->model_dashboard_pos->save_invoice($data,$data_sale);
                $result['nexInvoice_no'] = $inv["last_id"] +1 ;
                $result['curInvoice_no'] = $inv["last_id"] ;
            } 
            else{
                $inv = $this->model_dashboard_pos->get_SaleInvoiceNo();
            }
            if($inv["inv_no"]>0){
                $result['invoice_no'] = $inv["inv_no"];
            }
            $last_completed = $this->model_dashboard_pos->lastCompleted();
            if($last_completed>0){
                $result['last_completed'] = $last_completed;
            }
            $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        }
        
        public function getInvoices(){
            $this->load->model('dashboard/pos');
            $results = $this->model_dashboard_pos->get_invoices();
            $invoices_array = array();
             foreach ($results as $result) {
                 $disable_checkbox = "";    //($result['invoice_status']=='2')?"disabled='disabled'":"";                 
                 $invoices_array['aaData'][] = array(
                        'checkbox'                  =>"<input type='checkbox' ".$disable_checkbox." class='invoice_check' id='inv_".$result['invoice_id']."' value='".$result['invoice_id']."'/>",
                        'invoice_name'             => $result['invoice_name'],                        
                        'invoice_status'             => ($result['invoice_status']=='2')?$this->language->get('text_completed'):$this->language->get('text_uncomplete'),
                        'invoice_date'                  =>   date($this->language->get('date_formatwithtime'), strtotime($result['invoice_date'])),
                        'invoice_customer'           => $result['customer_name'],
                        'invoice_total'                => number_format($result['invoice_total'],2,'.','')
                        // 'invoice_total'                => number_format($result['invoice_total']-$result['discount'],2,'.','')
                    );
             }
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($invoices_array), $this->config->get('config_compression'));
        }
        
        public function getInvoiceDetail(){
            $this->load->model('dashboard/pos');
            $invoice_detail = array();           
            $data = $this->request->get;
            $invoice = $this->model_dashboard_pos->get_invoice($data['invoice_id']); 
            $invoice_detail['invoice_id'] = $invoice['invoice_id'];
            $invoice_detail['invoice_no'] = $invoice['invoice_no'];
            $invoice_detail['invoice_name'] = $invoice['invoice_name'];
            $invoice_detail['invoice_type'] = $invoice['invoice_type'];
            $invoice_detail['cust_id'] = $invoice['cust_id'];
            $invoice_detail['invoice_total'] = $invoice['invoice_total']-$invoice['discount_invoice']-$invoice['discount'];
            $invoice_detail['invoice_paids'] = $invoice['invoice_paid'];
            $invoice_detail['invoice_discount'] = $invoice['discount_invoice'];
            $invoice_detail['invoice_remaining'] = $invoice['invoice_total']-($invoice['invoice_paid']+$invoice['discount']);
            $invoice_detail['created_date']= date($this->language->get('date_slashformatwithtime'), strtotime($invoice['invoice_date']));
            $invoice_detail['invoice_status'] =  ($invoice['invoice_status']=='2')?"complete":"";
            $results = $this->model_dashboard_pos->get_invoice_detail($data['invoice_id']); 
              $this->load->model('dashboard/item');
            $ware_id = array('ware_id' =>0);  
             foreach ($results as $result) {
                 $sale_price  = round($result['sale_price'],0);
                 $normal_price  = round($result['normal_price'],0);
                 $conv_from = $result['inv_item_quantity']/$result['item_quantity'];
                  $invoice_detail['detail'][] = array(
                        'id'                  =>$result["inv_item_id"],
                        'name'             => $result['inv_item_name'],
                        'quantity'             => $result['item_quantity'],
                        'qty_on_hand'           => $this->model_dashboard_item->get_warehouse_items($result['inv_item_id'],$ware_id),
                        'item_code'             => $this->model_dashboard_pos->getItemById($result['inv_item_id'])->row['item_code'],
                        'price'                  => number_format($result['inv_item_price'],2,'.',''),
                        'discount'             => $result['inv_item_discount'],
                        'sale_price'           => number_format($sale_price,2,'.',''),
                        'normal_price'           => number_format($normal_price,2,'.',''),
                        'sale_unit'           => $result['unit_id'],
                        'unit_name'           => $result['unit_name'],
                        'conv_from'           => $conv_from,
                        'item_unit'               => $this->getunits($result['inv_item_id']),
                        'isChanged'                => 0
                    );
             }                        
            $this->load->library('json');
            $this->response->setOutput(Json::encode($invoice_detail), $this->config->get('config_compression'));
        }
        
        public function deleteItem(){
            $this->load->model('dashboard/pos');
            $data = $this->request->post;
            
            $inv_id = $this->model_dashboard_pos->delete_item_invoice($data);
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
        }
        
        public function deleteInvoice(){
            $this->load->model('dashboard/pos');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_pos->deleteInvoice($id);
            } 
            $deactivate_invoice = array();
            $deactivate_invoice['success'] = true;
            $deactivate_invoice['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($deactivate_invoice), $this->config->get('config_compression'));
            
        }
        
        public function orderCategory(){
            $this->language->load('dashboard/pos');
            $this->load->model('dashboard/pos');
            $results =  $this->model_dashboard_pos->setItemCategory();
             $cat = 0;
             $order = 0;
             foreach ($results as $result) {
                 if($cat!=$result['category_id']){
                     $cat = $result['category_id']; 
                     $order = 1;
                 }
                 $this->model_dashboard_pos->updateOrder($order,$result['id']);                 
                 $order = $order + 1;
             }
            
            $this->template = $this->config->get('config_template') . '/template/dashboard/cat.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
        }
        
        public function setOrder(){
            $this->load->model('dashboard/pos');
            $order = array();
            $new_order = $this->request->post['new_order'];
            $old_order = $this->request->post['old_order'];            
            
            if(intval($new_order) < intval($old_order)){
                $this->model_dashboard_pos->incrementOrder($this->request->post);
            }
            else{
                $this->model_dashboard_pos->decrementOrder($this->request->post);
            }
            
            $order['success'] = true;
            $this->load->library('json');
            $this->response->setOutput(Json::encode($order), $this->config->get('config_compression'));
        }
        
        public function getAllItems(){
            $this->load->model('dashboard/pos');
            $this->load->model('dashboard/item');
            $items = array();
            $ware_id = array('ware_id' =>0);    
                  $items = $this->model_dashboard_pos->get_all_items($this->request->get);
                       
            $items_array = array();
            foreach ($items as $result) {
                 $items_array[] = array(
                        'id'             => $result['id'],
                        'item_code'             => $result['item_code'],
                        // 'item_map_id'             => $result['item_map_id'],
                        'item_name'                  => $result['item_name'],
                        'item_status'                  => $result['item_status'],
                        // 'markup'                  => $result['markup'],
                        'normal_price'                => $result['normal_price'],
                        // 'part_number'             => $result['part_number'],
                        'picture'             => '',
                        'quantity'             => $this->model_dashboard_item->get_warehouse_items($result['id'],$ware_id),
                        'sale_acc'             => $result['sale_acc'],
                        'sale_price'             => number_format($result['sale_price'],2,'.',''),
                        'sort_order'             => $result['sort_order'],
                        'type_id'             => $result['type_id'],
                        'unit'             => $result['unit'],
                        'sale_unit'               => $result['sale_unit'],
                        'item_unit'               => $this->getunits($result['id']),
                        // 'added_date'             => $result['added_date'],
                        'asset_acc'             => $result['asset_acc'],
                        'avg_cost'             => $result['avg_cost'],
                        'category_id'             => $result['category_id'],
                        'cogs_acc'             => $result['cogs_acc'],
                     
                    );
             }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        public function displayOnPool(){
            $data = $this->request->get;
            $this->load->model('dashboard/pos');
            $this->model_dashboard_pos->displayPool($data);     
        }
        
        public function fetchInvoices(){
            $this->load->model('dashboard/pos');
            $items = array();            
            $items = $this->model_dashboard_pos->get_invoice_batch($this->request->post);             
            $items_array = array();
            $items_array['draw'] =$this->request->post['draw'];
            $items_array['recordsTotal'] = $this->model_dashboard_pos->total_invoices();
            $items_array['recordsFiltered'] = $this->model_dashboard_pos->total_invoices();
            $items_array['data'] = array();
            foreach ($items as $result) {
                $invoice_date =  $result['updated_date'];
                 $items_array['data'][] = array(
                     'id'   => $result['invoice_id'],
                     'invoice_no'     => $result['invoice_no'], 
                     'title'          => $result['invoice_name'],                      
                     'status'          => ($result['invoice_status']=='2')?$this->language->get('text_completed'):$this->language->get('text_uncomplete'),
                     'invoice_date'                  =>   date($this->language->get('date_formatwithtime'), strtotime($invoice_date)),
                     'invoice_customer'           => $result['customer_name'],
                     'invoice_total'                => number_format($result['invoice_total']-$result['discount_invoice'],2,'.','')
                 );
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($items_array), $this->config->get('config_compression'));
        }
        
        public function saveItem(){
            $this->load->model('common/common');
            $this->load->language('dashboard/item'); 
            $save_item = array();
            if(!$this->model_common_common->checkNameExists($this->request->post)){
                if(!$this->model_common_common->checkBarCodeExists($this->request->post)){                    

                    $results = $this->model_common_common->saveItem($this->request->post);     
                    $save_item['success'] = 1;                    
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
        
        public function saveCustomer(){
            $this->load->model('dashboard/customer');
            $this->load->language('dashboard/customer'); 
            $save_item = array();
            if(!$this->model_dashboard_customer->checkNameExists($this->request->post)){                               
                $result = $this->model_dashboard_customer->saveCustomer($this->request->post);                                
                $save_item['success'] = 1;
                $save_item['msg'] = $this->language->get('msg_save_success');                
                $save_item['obj_id'] = $result;
            }
            else{
                $save_item['success'] = 0;
                $save_item['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
        }
        
         public function resetPosOpen(){
            $data = $this->request->get;
            $this->load->model('dashboard/pos');
            $this->model_dashboard_pos->resetPosOpen($data);     
        }

        public function getTodaySale()
        {
          $this->load->model('dashboard/pos');
          $date=date('Y-m-d').' 0:0:0';
          // echo $date;
            $this->model_dashboard_pos->getTodaySale($date);  

            
        }
    }
?>