<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardVendor extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
                     
        
  	}
       
        public function saveVendor(){
            $this->load->model('dashboard/vendor');
            $this->load->language('dashboard/vendor'); 
            $save_item = array();
            
            if(!$this->model_dashboard_vendor->checkNameExists($this->request->post)){
                if(!isset($this->request->post['vendor_hidden_id']) || $this->request->post['vendor_hidden_id']==0){
                    $result = $this->model_dashboard_vendor->saveVendor($this->request->post);
                }
                else{
                    $result = $this->model_dashboard_vendor->updateVendor($this->request->post);
                }
                $save_item['success'] = true;
                $save_item['msg'] = $this->language->get('msg_save_success');
                $save_item['data'] = $this->fetchVendors();
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
        private function fetchVendors(){
            $this->load->model('dashboard/vendor');
              $this->load->language('dashboard/vendor'); 
             $results = $this->model_dashboard_vendor->getVendors($this->request->get);
             $vendor_array = array();
                       
             foreach ($results as $result) {

                 $res=str_replace("&amp;", '&', $result['vendor_name']); 
                 $vendor_name=str_replace("&quot;", '"', $res);
                 $vendor_array['vendors'][] = array(
                        'vendor_id'             => $result['vendor_id'],
                        'vendor_name'             => $vendor_name,
                        'vendor_acc_id'             => $result['vendor_acc_id'],
                        'vendor_contact'                  => $result['vendor_ct_name'],
                        'vendor_phone'             => $result['vendor_phone'],
                        'vendor_mobile'             => $result['vendor_mobile'],
                        'vendor_fax'             => $result['vendor_fax'],
                        'vendor_email'             => $result['vendor_email'],
                        'vendor_address'             => $result['vendor_address'],
                        'vendor_status_id'             => $result['vendor_status'],
                        'vendor_status'             => $result['vendor_status']==1?$this->language->get('text_enabled'):$this->language->get('text_disabled')
                    );
             }
             return $vendor_array;
        }
        private function getAccountArray(){
             $results = $this->model_dashboard_vendor->getAccounts();
             $accounts_array = array();
             foreach ($results as $result) {
                 $res=str_replace("&amp;", '&', $result['acc_name']); 
                 $vendor_acc=str_replace("&quot;", '"', $res);
                 $accounts_array['accounts'][] = array(
                        'id'             => $result['acc_id'],
                        'acc_name'             => $vendor_acc,
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
         public function getVendors(){
             $vendors = $this->fetchVendors();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($vendors), $this->config->get('config_compression'));
         }
         
          public function getVendor(){
             $this->load->model('dashboard/vendor');
             $result = $this->model_dashboard_vendor->getVendor($this->request->get);
             $vendor_array = array();
             $res=str_replace("&amp;", '&', $result['vendor_name']); 
             $vendor_name=str_replace("&quot;", '"', $res);
             $pre_row = $this->model_dashboard_vendor->getVendorRegister($result['vendor_acc_id']); 
             $vendor_array["vendor_id"] = $result['vendor_id'];
             $vendor_array["vendor_acc_id"] = $result['vendor_acc_id'];
             $vendor_array["vendor_name"] = $vendor_name;
             $vendor_array["vendor_obalance"] = $result['vendor_balance'];
             $vendor_array["vendor_contact"] = $result['vendor_ct_name'];
             $vendor_array["vendor_phone"] = $result['vendor_phone'];
             $vendor_array["vendor_mobile"] = $result['vendor_mobile'];
             $vendor_array["vendor_fax"] = $result['vendor_fax'];
             $vendor_array["vendor_email"] = $result['vendor_email'];
             $vendor_array["vendor_address"] = $result['vendor_address'];
             $vendor_array["vendor_status"] = $result['vendor_status'];
             $vendor_array["vendor_balance"] = number_format($pre_row,2,'.','');
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($vendor_array), $this->config->get('config_compression'));
         }
         public function changeState(){
            $this->load->model('dashboard/vendor');
            $result = $this->model_dashboard_vendor->changeState($this->request->post);
            $save_item = array();
            if($result==1 || $result==0){
                $save_item['action'] = 'success';
                $save_item['msg'] = $result;
                $save_item['data'] = $this->fetchVendors();
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