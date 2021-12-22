<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardCustomer extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }           
            
  	}
       
        public function saveCustomer(){
            date_default_timezone_set('Asia/Karachi');

            $this->load->model('dashboard/customer');
            $this->load->language('dashboard/customer'); 
            $save_item = array();
            if(!$this->model_dashboard_customer->checkNameExists($this->request->post)){
                if($this->request->post['cust_hidden_id']==-1){
                    $result = $this->model_dashboard_customer->saveCustomer($this->request->post);
                }
                else{
                    $result = $this->model_dashboard_customer->updateCustomer($this->request->post);
                }
                
                $save_item['success'] = 1;
                $save_item['msg'] = $this->language->get('msg_save_success');
                $save_item['data'] = $this->fetchCustomers('1');
                $save_item['data']["accounts"] =  $this->getAccountArray();
                $save_item['obj_id'] = $result;
                }
                else{
                    $save_item['success'] = 0;
                    $save_item['msg'] = $this->language->get('msg_name_exists');
                }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));            
        }
        
        private function fetchCustomers($flag){
            $this->load->model('dashboard/customer');
            $this->load->language('dashboard/customer'); 
            $results = $this->model_dashboard_customer->getCustomers($this->request->get,$flag);
            $customer_array = array();
                         
             foreach ($results as $result) {
                 $res=str_replace("&amp;", '&', $result['cust_name']); 
                 $cust_name=str_replace("&quot;", '"', $res);
                 
                 $customer_array['customers'][] = array(
                        'cust_id'               => $result['cust_id'],
                        'cust_name'             => $cust_name,
                        'cust_contact'          => $result['cust_ct_name'],
                        'cust_phone'            => $result['cust_phone'],
                        'cust_group'            => $result['cust_group_name'],
                        'cust_mobile'           => $result['cust_mobile'],
                        'cust_credit_limit'     => $result['cust_credit_limit'],
                        'account_id'            => $result['cust_acc_id'],
                        'cust_fax'              => $result['cust_fax'],                        
                        'cust_email'            => $result['cust_email'],
                        'cust_cnic'            => $result['cust_cnic'],
                        'cust_address'          => $result['cust_address'],
                        'cust_status_id'        => $result['cust_status'],
                        //'cust_display_no'       => $result['order_no'],
                        'cust_status'           => $result['cust_status']==1?$this->language->get('text_enabled'):$this->language->get('text_disabled')
                    );
             }
             return $customer_array;
        }
         private function getAccountArray(){
             $results = $this->model_dashboard_customer->getAccounts();
             $accounts_array = array();
             foreach ($results as $result) {
                 $res=str_replace("&amp;", '&', $result['acc_name']); 
                 $acc_name=str_replace("&quot;", '"', $res);
                 $accounts_array['accounts'][] = array(
                        'id'             => $result['acc_id'],
                        'acc_name'             => $acc_name,
                        'acc_type'                  => $result['acc_type_name'],
                        'acc_desc'                  => $result['acc_description'],
                        'acc_status'           => ($result['acc_status']==1)?$this->language->get('text_enable'):$this->language->get('text_disable'),
                        'acc_balance'                => $result['balance'],
                        'acc_type_id'                  => $result['acc_type_id'],
                        'acc_status_id'           =>  $result['acc_status']
                    );
             }
             return $accounts_array;
         }
         public function getCustomers(){
             $customers = $this->fetchCustomers(1);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($customers), $this->config->get('config_compression'));
         }
         public function getCustomer(){
             $this->load->model('dashboard/customer');
             $result = $this->model_dashboard_customer->getCustomer($this->request->get);
             $customer_array = array();
              if($result['cust_acc_id']==-1)
              {
                $pre_row=0;
              }
              else{
              $pre_row = $this->model_dashboard_customer->getCustomerRegister($result['cust_acc_id']); 
              $cust_ob = $this->model_dashboard_customer->getCustomerOB($result['cust_acc_id']); 
               
              }
             $res=str_replace("&amp;", '&', $result['cust_name']); 
             $cust_name=str_replace("&quot;", '"', $res);
             $customer_array["cust_id"] = $result['cust_id'];
             $customer_array["cust_name"] = $cust_name;
             $customer_array["cust_group_id"] = $result['cust_group_id'];
             $customer_array["cust_type_id"] = $result['cust_type_id'];
             $customer_array["cust_acc_id"] = $result['cust_acc_id'];
             // $customer_array["cust_obalance"] = number_format($cust_ob,2,'.','');
             $customer_array["cust_obalance"] = number_format( $result['cust_balance'],2,'.','');
             $customer_array["cust_contact"] = $result['cust_ct_name'];
             $customer_array["cust_phone"] = $result['cust_phone'];
             $customer_array["cust_credit_limit"] = $result['cust_credit_limit'];
             $customer_array["cust_mobile"] = $result['cust_mobile'];
             $customer_array["cust_fax"] = $result['cust_fax'];
             $customer_array["cust_email"] = $result['cust_email'];
             $customer_array["cust_cnic"] = $result['cust_cnic'];
             $customer_array["cust_address"] = $result['cust_address'];
             $customer_array["cust_status"] = $result['cust_status'];
             $customer_array["cust_price_level"] = $result['cust_price_level'];
             $customer_array["cust_display_no"] = $result['order_no'];
             $customer_array["customer_balance"] = number_format($pre_row,2,'.','');
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($customer_array), $this->config->get('config_compression'));
         }
          public function getRegionCustomer(){
             $this->load->model('dashboard/customer');
              $this->load->language('dashboard/customer'); 
             $results = $this->model_dashboard_customer->getRegionCustomer($this->request->get);
             $customer_array = array();
             foreach ($results as $result) {
                 $res=str_replace("&amp;", '&', $result['cust_name']); 
                 $cust_name=str_replace("&quot;", '"', $res);
                 
                   $customer_array['customers'][] = array(
                        'cust_id'             => $result['cust_id'],
                        'cust_name'             => $cust_name,
                        'cust_group'  => $result['cust_group_id'],
                        'cust_type_id'  => $result['cust_type_id'],
                        'account_id'  => $result['cust_acc_id'],
                        'cust_obalance'  => $result['cust_balance'],
                        'cust_contact'  => $result['cust_ct_name'],
                        'cust_mobile'  => $result['cust_phone'],
                        'cust_credit_limit'  => $result['cust_credit_limit'],
                        'cust_mobile'  => $result['cust_mobile'],
                        'cust_fax'  => $result['cust_fax'],
                        'cust_email'  => $result['cust_email'],
                        'cust_address'  => $result['cust_address'],
                        'cust_status_id'  => $result['cust_status'],
                        'cust_price_level'  => $result['cust_price_level']
                    );
             }
             $this->load->library('json');
            $this->response->setOutput(Json::encode($customer_array), $this->config->get('config_compression'));
           }
         
         public function changeState(){
            $this->load->model('dashboard/customer');
            $result = $this->model_dashboard_customer->changeState($this->request->post);
            $save_item = array();
            if($result==1 || $result==0){
                $save_item['action'] = 'success';
                $save_item['msg'] = $result;
                $save_item['data'] = $this->fetchCustomers(1);
            }
            else{
                $save_item['action'] = 'failed';
                $save_item['msg'] = $result;
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        
    }
?>