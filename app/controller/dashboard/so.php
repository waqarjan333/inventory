<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
     
class ControllerDashboardSo extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
                     
        
    }
        
        public function save(){
            $this->load->model('dashboard/so');
            $this->load->language('dashboard/so'); 
            $this->load->library('json');
            $data='';
            $so_details = (array)Json::decode(html_entity_decode($this->request->post['trans']));
            if($this->request->post['save_new']==1)
            {
                $data = (array)Json::decode(html_entity_decode($this->request->post['data']));
            }
            else
            {
                $data = $this->request->post;
            }
            
            if($data['so_hidden_id']=="0")
            {
                $results = $this->model_dashboard_so->saveInvoice($data,$so_details);
            }
            else
            {
               $so_pick_details = (array)Json::decode(html_entity_decode($this->request->post['pick'])); 
               $results = $this->model_dashboard_so->updateInvoice($this->request->post,$so_details,$so_pick_details); 
            }
            $save_item = array();
            $save_item['success'] = true;
            $save_item['msg'] = $this->language->get('msg_save_success');
            $save_item['next_order_id'] = $this->model_dashboard_so->nextOrderId($results["invoice_id"]);
            $save_item['pre_order_id'] = $this->model_dashboard_so->previousOrderId($results["invoice_id"]);
            $save_item['obj_id'] = $results["invoice_id"];
            $save_item['inv_no'] = $results["inv_no"];
            $pd = $this->request->post;
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        public function delete(){
            $this->load->model('dashboard/so');
            $this->load->model('common/common');
            $results = $this->model_dashboard_so->deleteInvoice($this->request->post);
            $delete_so = array();
            $delete_so['success'] = true;
            $delete_so['pre_order_id'] = $this->model_common_common->getLastSaleId();
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_so), $this->config->get('config_compression'));
        }  
         public function deleteStockTransfer(){
            $this->load->model('dashboard/so');
            $this->load->model('common/common');
            $results = $this->model_dashboard_so->deleteTransferInvoice($this->request->post);
            $delete_st = array();
            $delete_st['success'] = true;
            $delete_st['pre_order_id'] = $this->model_common_common->getLastTransferId();
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_st), $this->config->get('config_compression'));
        }
         public function getSO(){
             $this->load->model('dashboard/so');
             $this->load->language('dashboard/so'); 
             $results = $this->model_dashboard_so->getOrders($this->request->get);
             $so_array = array();
                
                    
             foreach ($results as $result) {
                $time = strtotime($result['invoice_date']); 
                $order_date = date("d-m-y",$time );
                 $so_array['orders'][] = array(
                        'id'             => $result['invoice_id'],
                        'so_id'             => $result['invoice_id'],
                        'inv_no'             => $result['invoice_no'],
                        'so_location_id'             => $result['so_location_id'],
                        'cust_id'             => $result['cust_id'],                        
                        'cust_name'             => $this->getCustomerName($result),
                        'so_date'                  => date($this->language->get('date_format'), strtotime($result['invoice_date'])),
                        'so_status'           => $this->getStatusText($result['invoice_status']),
                        'so_total'                => number_format($result['invoice_total'],2,'.',''),
                        'so_paid'             => $result['invoice_paid'],
                        'so_balance'             => number_format(floatval($result['invoice_total']) - floatval ($result['invoice_paid']),2,'.',''),
                        'so_due_date'             => date($this->language->get('date_format'), strtotime($result['paid_date'])),
                        'order_date'             => $order_date
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($so_array), $this->config->get('config_compression'));
         }
       private function getCustomerName($result){
           $name = "";
           if($result["cust_id"]=="0"){
                if(!empty($result["c_name"])){
                    $name = $result["cust_name"] . " (".$result["c_name"].")";                        
                }
                else{
                    $name = $result["cust_name"];
                }
           }
           else{
               $name = $result["cust_name"];
           }
           return $name;
       }  
       private function getStatusText($val){
            $status_text = $this->language->get('text_open');
            if($val==2){
                $status_text = $this->language->get('text_unpaid');
            }
            else if($val==3){
                $status_text = $this->language->get('text_paid');
            }
               else if($val==4){
                $status_text = $this->language->get('text_partial');
            }
            return $status_text;
        }  
       public function getSaleInvoice(){
            $this->load->model('dashboard/so');
            $this->load->model('common/common');
             $this->load->language('dashboard/so'); 
             $result = $this->model_dashboard_so->getSaleInvoice($this->request->get);
             $region=$this->model_dashboard_so->getCustRegion($result['cust_id']);
             $so_total_paid = $this->model_dashboard_so->getTotalPaid($result['invoice_id']);
             if($result['invoice_type']==4){
                 $so_total_paid =  $result['invoice_paid'];
             }
             $so_array = array();
             $so_array['so_id'] = $result['invoice_id'];
             $so_array['inv_no'] = $result['invoice_no'];
              $so_array['region'] = $region;
             $so_array['cust_id'] = $result['cust_id'];
            
             // $so_array['cust_id'] = $result['cust_id'];
             $so_array['so_date'] = date($this->language->get('date_format'), strtotime($result['invoice_date']));             
             $so_array['so_date_time'] = date($this->language->get('date_slashformatwithtime') , strtotime($result['invoice_date']));
             $so_array['reg_date'] =$result['invoice_date'];
             //$so_array['so_status'] = $this->getStatusText($result['invoice_status']);
             $so_array['so_status_id'] = $result['invoice_status'];
             $so_array['so_is_print'] = $result['in_print'];
             $so_array['so_is_email'] = $result['in_email'];
             $so_array['so_salesrep']   = $result['salesrep_id'];
             $so_array['next_order_id'] = $this->model_dashboard_so->nextOrderId($result['invoice_id']);
             $so_array['pre_order_id'] = $this->model_dashboard_so->previousOrderId($result['invoice_id']);
             $so_array['so_pmethod'] = $result['payment_method'];
             $so_array['so_custom'] = $result['custom'];
             $so_array['so_cust_name'] = $result['cust_name']; 
             $so_array['so_cust_mobile'] = $result['cust_mobile_no']; 
             $so_array['so_cust_address'] = $result['cust_address'];
             $so_array['so_discount'] = $result['discount']; 
             $so_array['so_discount_invoice'] = $result['discount_invoice']; 
             $so_array['so_previous_invoice'] = $result['previous_balance'];      
             $so_array['so_total'] = number_format($result['invoice_total'],2,'.','');
             $so_array['so_paid'] = number_format(floatval($so_total_paid),2,'.','');
             $so_array['so_balance'] =number_format(floatval($result['invoice_total']) - floatval ($so_total_paid),2,'.','');
             $so_array['so_paid_date'] = date($this->language->get('date_format'), strtotime($result['paid_date']));
             $results = $this->model_dashboard_so->getSaleInvoiceDetails($this->request->get);
             
             foreach ($results as $result) {

                 //$unitPrice = round($result['inv_item_price'],0); Why rounding without seeing through
                 $unitPrice = $result['inv_item_price'];
                 $this->load->library('json');
                 $so_array['order_details'][] =  array(
                        'item_id'             => $result['inv_item_id'],
                        'item_name'           => $result['item_name'],
                        'item_quantity'       => $result['item_quantity'],
                        'conv_from'           => $result['conv_from'],
                        'unit_name'           => $result['unit_name'],
                        'unit_id'             => $result['unit_id'],
                        'ware_id'             => $result['warehouse_id'],
                        'warehouse_name'      => $result['w_name'],
                        'normal_price'        => number_format($result['item_purchase_price'],2,'.',''),
                        'unit_price'          => number_format($result['inv_item_price'],2,'.',''),
                        'net_price'           => number_format($result['inv_item_price'],2,'.',''),                        
                        'discount'            => number_format(floatval($result['inv_item_discount']),2,'.','').'%',
                        'discount_complete'   => $result['inv_item_discount'].'%',
                        'item_units'          => $this->model_common_common->getUnits($result['inv_item_id']),
                        'sub_total'           => $result['inv_item_subTotal']
                         // 'sub_total'           => $result['inv_item_subTotal'] ? $result['inv_item_subTotal'] : round(floatval($result['inv_item_price']) * floatval($result['item_quantity']),2,PHP_ROUND_HALF_UP)
                    );
             }
             $results = $this->model_dashboard_so->getSalePickDetails($this->request->get);
             foreach ($results as $result) {
                 $so_array['pick_details'][]  =  array(
                        'item_id'             => $result['pick_item_id'],
                        'item_name'           => $result['item_name'],
                        'item_quantity'       => $result['pick_quantity'],
                        'unit_name'           => $result['name'],
                        'item_location'       => $result['warehouse_name'],
                        'item_location_id'    => $result['pick_warehouse'],
                        'date_picked'         => date($this->language->get('date_format_extjs'),strtotime($result['pick_date'])),
                        'is_picked'           => $result['pick_complete']=="1"?true:false    
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($so_array), $this->config->get('config_compression'));
            }
       
       public function getTransferInvoice()
       {
         $this->load->model('dashboard/so');
            $this->load->model('common/common');
             $this->load->language('dashboard/so');
             $result = $this->model_dashboard_so->getTransferInvoice($this->request->get);
             $st_array = array();
             $st_array['inv_no'] = $result['invoice_no'];
              $st_array['from_warehouse'] = $result['from_warehouse'];
              $st_array['to_warehouse'] = $result['to_warehouse'];
              $st_array['date'] = $result['date'];
               $st_array['next_order_id'] = $this->model_dashboard_so->nextStOrderId($result['invoice_no']);
             $st_array['pre_order_id'] = $this->model_dashboard_so->previousStOrderId($result['invoice_no']);

             $results = $this->model_dashboard_so->getTransferInvoiceDetails($this->request->get);
             foreach ($results as $result) {
                  $st_array['transfer_details'][]  =  array(
                        'item_name'             => $result['item_name'],
                        'item_quantity'       => $result['qty'],
                        'unit_id'           => $result['unit_id'],
                        'unit_name'           => $result['unit_name'],
                        'unit_price'           => $result['price']
                    );
             }
              $this->load->library('json');
             $this->response->setOutput(Json::encode($st_array), $this->config->get('config_compression'));
       }     
       public function get_stockTransfer()
       {
        $this->load->model('dashboard/so');
             $this->load->language('dashboard/so'); 
             $results = $this->model_dashboard_so->getStockTransferOrders($this->request->get);
             $so_array = array();
             foreach ($results as $result) {
                // $order_date = date("d-m-y",$time );
                 $so_array['orders'][] = array(
                        'inv_no'             => $result['invoice_no'],
                        'warehouse_id'             => $result['from_warehouse'],                        
                        'warehouse_name'             => $result['warehouse_name'],
                        'so_date'             => $result['date']
                         );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($so_array), $this->config->get('config_compression'));


       }
       public function paySO(){
          $this->load->model('dashboard/so');
          $this->load->language('dashboard/so');  
          $so_pay = array();
          
          $result = $this->model_dashboard_so->payInvoice($this->request->post); 
          $so_pay['invoice_id'] = $result;
          $so_pay['success'] = true;
          $so_pay['ref_no'] = $result;          
          $so_pay['msg'] = $this->language->get('msg_pay_success');
          
          $this->load->library('json');
          $this->response->setOutput(Json::encode($so_pay), $this->config->get('config_compression'));
       }
       
       public function getPayments(){
           $this->load->model('dashboard/so');
           $results = $this->model_dashboard_so->getPayments($this->request->get);
           $po_payment_array = array();
           foreach ($results as $result) {
                 $po_payment_array['so_payments'][] = array(
                        'payment_id'             => $result['pay_id'],
                        'payment_date'             => date($this->language->get('date_format_extjs'),strtotime($result['pay_date'])),
                        'payment_method'             => 'Cash',
                        'payment_method_id'             => $result['pay_method'],
                        'ref_no'                =>      $result['pay_id'],
                        'payment_remarks'             =>$result['pay_remarks'] ,
                        'payment_amount'               => $result['pay_amount']    
                    );
           }
           $this->load->library('json');
           $this->response->setOutput(Json::encode($po_payment_array), $this->config->get('config_compression'));
       }
       
        public function payDelSO(){
          $this->load->model('dashboard/so');
          $this->load->language('dashboard/so');  
          $so_pay = array();
          
          $result = $this->model_dashboard_so->paymentDel($this->request->post);           
          $so_pay['success'] = true;          
          $so_pay['msg'] = $this->language->get('msg_pay_success');
          
          $this->load->library('json');
          $this->response->setOutput(Json::encode($so_pay), $this->config->get('config_compression'));
       }
       
        public function getBatchInvoices(){
             $this->load->model('dashboard/so');
             $this->load->language('dashboard/so'); 
             $results = $this->model_dashboard_so->getBatchOrders($this->request->get);
             $so_array = array();
             foreach ($results as $result) {
                 $so_array['orders'][] = array(
                        'id'             => $result['invoice_id'],
                        'so_id'             => $result['invoice_id'],
                        'inv_no'             => $result['invoice_no'],
                        'so_location_id'             => $result['so_location_id'],
                        'cust_id'             => $result['cust_id'],
                        'cust_name'             => $result['cust_name'],
                        'so_date'                  => date($this->language->get('date_format'), strtotime($result['invoice_date'])),
                        'so_status'           => $this->getStatusText($result['invoice_status']),
                        'so_total'                => number_format($result['invoice_total'],2,'.',''),
                        'so_paid'             => number_format($result['invoice_paid'],2,'.',''),
                        'so_balance'             => number_format(floatval($result['invoice_total']) - floatval ($result['invoice_paid']),2,'.',''),
                        'so_due_date'             => date($this->language->get('date_format'), strtotime($result['paid_date']))
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($so_array), $this->config->get('config_compression'));
         }
         
          public function getSaleReturnInvoices(){
             $this->load->model('dashboard/so');
             $this->load->language('dashboard/so'); 
             $results = $this->model_dashboard_so->getSaleReturn($this->request->get);
             $so_array = array();
             foreach ($results as $result) {
                 $so_array['orders'][] = array(
                        'id'             => $result['invoice_id'],
                        'so_id'             => $result['invoice_id'],
                        'inv_no'             => $result['invoice_no'],
                        'so_location_id'             => $result['so_location_id'],
                        'cust_id'             => $result['cust_id'],
                        'cust_name'             => $result['cust_name'],
                        'so_date'                  => date($this->language->get('date_format'), strtotime($result['invoice_date'])),
                        'so_status'           => $this->getStatusText($result['invoice_status']),
                        'so_total'                => number_format($result['invoice_total'],2,'.',''),
                        'so_paid'             => number_format($result['invoice_paid'],2,'.',''),
                        'so_balance'             => number_format(floatval($result['invoice_total']) - floatval ($result['invoice_paid']),2,'.',''),
                        'so_due_date'             => date($this->language->get('date_format'), strtotime($result['paid_date']))
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($so_array), $this->config->get('config_compression'));
         }
         
         public function getBatchDetail(){
            $this->load->model('dashboard/so');
            $this->load->language('dashboard/so'); 
            $id_array = explode(",",$this->request->post['selected']); 
            $so_array = array();
            $data = array();
            $discount = 0;
            foreach ( $id_array as $id) {                           
                $so_detail = array();
                $data["so_id"] = $id;
                $results = $this->model_dashboard_so->getSaleInvoiceDetails($data);
                foreach ($results as $result) {
                    $item_discount = ($result['inv_item_price']*($result['inv_item_discount']/100));
                    $net_price = number_format($result['inv_item_price'] - $item_discount,2,'.','');
                    $so_detail['order_details'][] = array(
                           'item_id'             => $result['inv_item_id'],
                           'item_name'             => $result['item_name'],
                           'item_quantity'             => $result['inv_item_quantity'],
                            'unit_name'             => $result['unit_name'],
                           'unit_price'             => $result['inv_item_price'],
                           'discount'                => $result['inv_item_discount'].'%',
                           'net_price'                => $net_price,
                           'sub_total'             => floatval($net_price) * floatval($result['inv_item_quantity'])
                       );
                    $discount = $discount + $item_discount*$result['inv_item_quantity'];
            }
                
                $result = $this->model_dashboard_so->getSaleInvoice($data);
                $so_total_paid = $this->model_dashboard_so->getTotalPaid($result['invoice_id']);                
                $so_array['orders'][] = array(
                    'so_id' => "INV-".$result['invoice_id'],
                    'cust_name' => $result['c_name'],
                    'cust_id' => $result['c_id'],
                    'discount' => $discount + $result['discount_invoice'],
                    'pre_balance'             => $result['previous_balance'],
                    'inv_no'             => $result['invoice_no'],
                    'so_date' => date($this->language->get('date_format'), strtotime($result['invoice_date'])),
                    'so_total' => number_format($result['invoice_total'],2,'.',''),
                    'so_paid' => number_format(floatval($so_total_paid),2,'.',''),
                    'so_warehouse' =>$result['warehouse_name'],
                    'so_region' =>$result['cust_group_name'],
                    'so_balance' => number_format(floatval($result['invoice_total']) - floatval ($so_total_paid),2,'.',''),
                    'so_paid_date' => date($this->language->get('date_format'), strtotime($result['paid_date'])),
                    'items' => $so_detail['order_details']
                );
                
             
             }
             $so_array['action'] = 'success';
             $this->load->library('json');
             $this->response->setOutput(Json::encode($so_array), $this->config->get('config_compression'));
         }
         
         public function getPriceLevel(){
             $this->load->model('dashboard/customer');
             $customer_pricelevel =$this->model_dashboard_customer->getCustomerAddress($this->request->get);
             $cust_details = array();             
             $this->load->library('json');              
             $p_level_record = $this->model_dashboard_customer->getPriceLevel($customer_pricelevel['cust_price_level']);
             
             if($p_level_record){
                $cust_details['cust_price_level'] = $p_level_record;
                if($p_level_record['level_type']=='2'){                
                    $cust_details['cust_price_level_items'] = $this->model_dashboard_customer->getItems($p_level_record['level_id']);
                }
             }
             $cust_details['cust_estimate_count'] =  $this->model_dashboard_customer->getEstimateCount($this->request->get);
             
             $this->response->setOutput(Json::encode($cust_details), $this->config->get('config_compression'));
         }


         
    }
    
?>
