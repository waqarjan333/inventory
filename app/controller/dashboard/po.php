<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
     
class ControllerDashboardPo extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }                             
  	}
        
        public function save(){
            $this->load->model('dashboard/po');
            $this->load->language('dashboard/po'); 
            $this->load->library('json');
            $so_details = (array)Json::decode(html_entity_decode($this->request->post['trans']));            
            //if($this->request->post['po_hidden_id']=="0"){
                $results = $this->model_dashboard_po->saveInvoice($this->request->post,$so_details);
//            }
//            else{
//               $results = $this->model_dashboard_po->updateInvoice($this->request->post,$so_details); 
//            }
            $save_item = array();
            $save_item['success'] = true;
            $save_item['msg'] = $this->language->get('msg_save_success');
            $save_item['next_order_id'] = $this->model_dashboard_po->nextOrderId($results["invoice_id"]);
            $save_item['pre_order_id'] = $this->model_dashboard_po->previousOrderId($results["invoice_id"]);
            $save_item['obj_id'] = $results["invoice_id"];
            $save_item['inv_no'] = $results["inv_no"];
            $pd = $this->request->post;
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        public function delete(){
            $this->load->model('dashboard/po');
            $this->load->model('common/common');
            $results = $this->model_dashboard_po->deleteInvoice($this->request->post);
            $delete_po = array();
            $delete_po['success'] = true;
            $delete_po['pre_order_id'] = $this->model_common_common->getLastPOId();
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_po), $this->config->get('config_compression'));
        }
         public function getPO(){
             $this->load->model('dashboard/po');
             $this->load->language('dashboard/po'); 
             $results = $this->model_dashboard_po->getOrders($this->request->get);
             $po_array = array();
             foreach ($results as $result) {
                   $time = strtotime($result['invoice_date']); 
                     $order_date = date("d-m-y",$time );
                 $po_array['orders'][] = array(
                        'id'             => $result['invoice_id'],
                        'po_id'             => $result['invoice_id'],
                        'vendor_id'             => $result['vendor_id'],
                        'inv_no'             => $result['invoice_no'],
                        'location_id'             => $result['po_location_id'],
                        'vendor_name'             => $result['vendor_name'],
                        'po_date'                  => date($this->language->get('date_format'), strtotime($result['invoice_date'])),                        
                        'po_status'           => $this->getStatusText($result['invoice_status']),
                        'po_total'                => number_format($result['invoice_total'],2),
                        'po_paid'             => number_format($result['invoice_paid'],2),
                        'po_balance'             => number_format(floatval($result['invoice_total']) - floatval ($result['invoice_paid']),2),
                        'po_due_date'             => date($this->language->get('date_format'), strtotime($result['paid_date'])),
                        'order_date'             => $order_date
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($po_array), $this->config->get('config_compression'));
         }
       private function getStatusText($val){
            $status_text = $this->language->get('text_open');
            if($val==2){
                $status_text = $this->language->get('text_pending');
            }
            else if($val==3){
                $status_text = $this->language->get('text_completed');
            }
            return $status_text;
        }  
       public function getPurchaseInvoice(){
            $this->load->model('dashboard/po');
            $this->load->model('common/common');
             $this->load->language('dashboard/po'); 
             $result = $this->model_dashboard_po->getPurchaseInvoice($this->request->get);
             $po_total_paid = $this->model_dashboard_po->getTotalPaid($result['invoice_id']);
             $po_array = array();
             $po_array['po_id'] = $result['invoice_id'];
             $po_array['inv_no'] = $result['invoice_no'];
             $po_array['vendor_id'] = $result['vendor_id'];
             $po_array['po_date'] = date($this->language->get('date_format'), strtotime($result['invoice_date']));
             $po_array['po_status_id'] = $result['invoice_status'];
             $po_array['next_order_id'] = $this->model_dashboard_po->nextOrderId($result['invoice_id']);
             $po_array['pre_order_id'] = $this->model_dashboard_po->previousOrderId($result['invoice_id']);
             $po_array['po_location_id'] = $result['po_location_id'];
             $po_array['po_pmethod'] = $result['payment_method'];
             $po_array['po_shipped'] = $result['order_shipped'];
             $po_array['custom'] = $result['custom'];
             $po_array['po_total'] = number_format($result['invoice_total'],2,'.','');
             $po_array['po_paid'] = number_format(floatval($po_total_paid),2,'.','');
             $po_array['po_balance'] =number_format(floatval($result['invoice_total']) - floatval ($po_total_paid),2,'.','');
             $po_array['po_paid_date'] = date($this->language->get('date_format'), strtotime($result['paid_date']));
             $results = $this->model_dashboard_po->getPurchaseInvoiceDetails($this->request->get);
             foreach ($results as $result) {
                 $po_array['order_details'][] = array(
                        'item_id'                 => $result['inv_item_id'],
                        'item_name'               => $result['item_name'],
                        'unit_name'               => $result['name'],
                        'unit_id'                 => $result['unit_id'],
                        'item_quantity'           => $result['item_quantity'],
                        'warehouse_name'          => $result['w_name'],
                        'conv_from'               => $result['conv_from'],
                        'unit_price'              => number_format($result['inv_item_price'],2,'.',''),
                        'sale_price'              => number_format($result['inv_item_sprice'],2,'.',''),
                        'discount'                => number_format($result['inv_item_discount'],2,'.','').'%',
                        'discount_complete'       => $result['inv_item_discount'].'%',
                        'sub_total'               => $result['inv_item_subTotal'],
                        'item_units'              => $this->model_common_common->getUnits($result['inv_item_id'])
                    );
             }
             
             $results = $this->model_dashboard_po->getPurchaseReceiveDetails($this->request->get);
             foreach ($results as $result) {
                // $subtotal=$result['inv_item_price']*$result['quantity'];
                 $po_array['expense_details'][] = array(
                        'item_id'               => $result['rec_item_id'],
                        'item_name'             => $result['item_name'],
                        'item_quantity'         => $result['quantity'],
                        'unit_id'               => $result['unit_id'],
                        'conv_from'             => $result['conv_from'],
                        'conv_from'             => $result['conv_from'],
                        'unit_price'            => number_format($result['inv_item_price'],2,'.',''),
                        'sale_price'            => number_format($result['inv_item_sprice'],2,'.',''),
                        'new_price'            => '0',
                        'inv_item_subTotal'     => $result['inv_item_subTotal'],
                        'item_location'         => $result['warehouse_id'],
                        'warehouseName'         => $result['warehouseName'],
                        'item_location_id'      => $result['rec_warehouse'],
                        'date_received'         => date($this->language->get('date_format_extjs'),strtotime($result['rec_date'])),
                        'is_received'           => $result['rec_complete']=="1"?true:false    
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($po_array), $this->config->get('config_compression'));
       }
       
       
       public function bl_getPurchaseInvoice(){
            $this->load->model('dashboard/po');
            $this->load->model('common/common');
             $this->load->language('dashboard/po'); 
             $this->load->model('dashboard/item');
             $po_array = array();
             
             $results = $this->model_dashboard_po->bl_getPurchaseInvoiceDetails($this->request->post);
             foreach ($results as $result) {
                 $item_id = array();
                 $item_id['item_id'] = $result['inv_item_id'];
                 
                 $cust_fields = $this->model_dashboard_item->getItemFields($item_id);
                 $qty_on_hand = $result['itemQty'] + $this->model_dashboard_item->get_adjust_items($result['inv_item_id']) + $this->model_dashboard_item->bl_get_purchase_items($this->request->post['inv_id'],$result['inv_item_id']) - $this->model_dashboard_item->get_sale_items($result['inv_item_id']);
                 $po_array['order_details'][] = array(
                        'barcode_lable_item_id'                 => $result['inv_item_id'],
                        'barcode_lable_item_name'               => $result['item_name'],
                        'barcode_lable_unit_id'                 => $result['unit_id'],
                        'barcode_lable_unit_name'               => $result['unit_name'],
                        'barcode_lable_conv_from'               => $result['conv_from'],
                        'barcode_lable_barcode'                 => $result['item_code'],
                        'barcode_lable_color'                   => (isset($cust_fields['item_1']))?$cust_fields['item_1']:"",
                        'barcode_lable_size'                    => (isset($cust_fields['item_2']))?$cust_fields['item_2']:"",
                        'barcode_lable_sale_price'              => number_format($result['inv_item_sprice'],2,'.',''),
                        'barcode_lable_qty'                     => $result['item_quantity'],
                        'barcode_lable_inv_qty'                 => $result['inv_item_quantity'],
                        'barcode_lable_qty_on_hand'             => $qty_on_hand/$result['conv_from'],
                        'barcode_qty_on_hand'                   => $qty_on_hand,
                        'barcode_lable_total_qty'               => $result['item_quantity']+($qty_on_hand/$result['conv_from']),
                        'barcode_lable_no_of_copies'            => $result['item_quantity']+($qty_on_hand/$result['conv_from']),
                        'barcode_lable_custom_copies'           => $result['item_quantity']+($qty_on_hand/$result['conv_from']),
                        'barcode_lable_item_units'              => $this->model_common_common->getUnits($result['inv_item_id']),
                        'barcode_lable_item_unit_uom'           => $this->model_common_common->getitemUoM($result['inv_item_id'],$result['unit_id']),
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($po_array), $this->config->get('config_compression'));
       }
       
       
       public function bl_getPurchaseInvoiceNo(){
            $this->load->model('dashboard/po');
            $this->load->model('common/common');
             $this->load->language('dashboard/po'); 
             $po_array = array();
             
             $results = $this->model_dashboard_po->bl_getPurchaseInvoiceNo($this->request->post);
             foreach ($results as $result) {
                 $po_array['inv_no'][] = array(
                        'id'                 => $result['invoice_id'],
                        'name'               => 'Invoice No '.$result['invoice_no']
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($po_array), $this->config->get('config_compression'));
       }
       
       public function bl_getBarcodes(){
            $this->load->model('dashboard/po');
            $this->load->model('common/common');
             $this->load->language('dashboard/po'); 
             $po_array = array();
             
             $results = $this->model_common_common->getBarcodes($this->request->post['item_id'],$this->request->post['uom_id']);
             foreach ($results as $result) {
                 $po_array['barcodes'][] = array(
                        'barcode'                 => $result['barcode'],
                    );
             }
             $po_array['barcode_lable_sale_price'] = $this->model_common_common->getitemUnitSalePrice($this->request->post['item_id'],$this->request->post['uom_id']);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($po_array), $this->config->get('config_compression'));
       }
       public function bl_getPurchaseInvoiceItems(){
            $this->load->model('dashboard/po');
            $this->load->model('common/common');
             $this->load->language('dashboard/po'); 
             $po_array = array();
             
             $results = $this->model_dashboard_po->bl_getPurchaseInvoiceItems($this->request->post);
             foreach ($results as $result) {
                 $po_array['items'][] = array(
                        'id'                 => $result['id'],
                        'name'               => $result['item_name']
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($po_array), $this->config->get('config_compression'));
       }
       public function payPO(){
          $this->load->model('dashboard/po');
          $this->load->language('dashboard/po');  
          $po_pay = array();
          
          $result = $this->model_dashboard_po->payInvoice($this->request->post); 
          $po_pay['invoice_id'] = $result;
          $po_pay['success'] = true;
          $po_pay['ref_no'] = $result;
          $po_pay['msg'] = $this->language->get('msg_pay_success');
          
          $this->load->library('json');
          $this->response->setOutput(Json::encode($po_pay), $this->config->get('config_compression'));
       }
       
       public function getPoUnits(){
          $this->load->model('dashboard/po');
          $this->load->language('dashboard/po');  
         
          $result = $this->model_dashboard_po->getPurchaseUnits($this->request->post); 
           $po_uom = array();
           foreach ($result as $results) {
                 $po_uom['po_uom'][] = array(
                    'item_id'             => $results['item_id'],
                    'purchase_unit'      => $results['purchase_unit'],
                     'sale_unit'         => $results['sale_unit'],
                    'uom_id'             => $results['uom_id'],
                    'unit_id'            => $results['unit_id'],
                    'unit_name'          => $results['unit_name'],
                    'conv_from'          => $results['conv_from'],
                    'conv_to'            => $results['conv_to'],
                    'sale_price'         => $results['sale_price'],
                    );
             }
          
          $this->load->library('json');
          $this->response->setOutput(Json::encode($po_uom), $this->config->get('config_compression'));
       }
       
       
       
       public function getPayments(){
           $this->load->model('dashboard/po');
           $results = $this->model_dashboard_po->getPayments($this->request->get);
           $po_payment_array = array();
           foreach ($results as $result) {
                 $po_payment_array['po_payments'][] = array(
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
       
       public function payDelPO(){
          $this->load->model('dashboard/po');
          $this->load->language('dashboard/po');  
          $po_pay = array();
          
          $result = $this->model_dashboard_po->paymentDel($this->request->post);           
          $po_pay['success'] = true;          
          $po_pay['msg'] = $this->language->get('msg_pay_success');
          
          $this->load->library('json');
          $this->response->setOutput(Json::encode($po_pay), $this->config->get('config_compression'));
       }
        
     public function SavePurcahseExpense()
     {
         $this->load->model('dashboard/po');
         $data=$this->request->post;
         // var_dump($data);exit;
         $po_msg = array();
          $result = $this->model_dashboard_po->PurcahseExpense($this->request->post);     
           $this->load->library('json');
           if($result==true)
           {
             $po_msg['success'] = true;          
             $po_msg['msg'] = "Expense Inserted Successfully";
           }
          $this->response->setOutput(Json::encode($po_msg), $this->config->get('config_compression'));
     }   
    }
    
?>
