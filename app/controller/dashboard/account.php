<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardAccount extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
  	}
       
        public function saveupdate(){
            $this->load->model('dashboard/account');
            $this->load->language('dashboard/account'); 
            $save_item = array();
            if(!$this->model_dashboard_account->checkNameExists($this->request->post)){
                $results = $this->model_dashboard_account->saveupdateAccount($this->request->post);
                
                $save_item['success'] = 1;
                $save_item['obj_id'] = $results;
                $save_item['data'] = $this->getAccountArray(array());
                $save_item['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_item['success'] = 0;
                $save_item['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        public function deleteAccount(){
            $this->load->model('dashboard/account');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_account->deleteAccount($id);
            } 
            $delete_account = array();
            $delete_account['success'] = true;
            $delete_account['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_account), $this->config->get('config_compression'));
            
        }
        public function deactivateAccount(){
            $this->load->model('dashboard/account');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_account->deactivateAccount($id);

            } 
            $deactivate_account = array();
            $deactivate_account['success'] = true;
            $deactivate_account['msg'] = $this->language->get('msg_deactivate_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($deactivate_account), $this->config->get('config_compression'));
            
        }
         public function getAccounts(){
             $this->load->model('dashboard/account');
             $this->load->language('dashboard/account');
             $accounts_array =$this->getAccountArray($this->request->get);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
         }
         private function getAccountArray($get){
             $results = $this->model_dashboard_account->getAccounts($get);
             $accounts_array = array();
             foreach ($results as $result) {
                
                $afterunderscore = substr($result['acc_name'], strpos($result['acc_name'], "_"));
                $journalName = str_replace('_', '', $afterunderscore);
                 $accounts_array['accounts'][] = array(
                        'id'             => $result['acc_id'],
                        'acc_name'             => $journalName,
                        'acc_type'                  => $result['acc_type_name'],
                        'acc_desc'                  => $result['acc_description'],
                        'acc_status'           => ($result['acc_status']==1)?$this->language->get('text_enable'):$this->language->get('text_disable'),
                        'acc_balance'                => $result['balance'],
                        'acc_type_id'                  => $result['acc_type_id'],
                        'acc_status_id'           =>  $result['acc_status'],
                        'acc_head_id'   =>$result['acc_head_id']
                    );
             }
             return $accounts_array;
         }
         public function getIncomeAccounts(){
             $this->load->model('dashboard/account');
             $this->load->language('dashboard/account');
             $accounts_array =$this->getIncomeAccountArray($this->request->get);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
         }
         private function getIncomeAccountArray($get){
             $results = $this->model_dashboard_account->getIncomeAccounts($get);
             $accounts_array = array();
             foreach ($results as $result) {
                if ($result['acc_type_id'] == 4){
                    $afterunderscore = substr($result['acc_name'], strpos($result['acc_name'], "_"));
                    $journalName = str_replace('_', '', $afterunderscore);
                     $accounts_array['accounts'][] = array(
                            'id'             => $result['acc_id'],
                            'acc_name'             => $journalName,
                            'acc_type'                  => $result['acc_type_name'],
                            'acc_desc'                  => $result['acc_description'],
                            'acc_status'           => ($result['acc_status']==1)?$this->language->get('text_enable'):$this->language->get('text_disable'),
                            'acc_balance'                => $result['balance'],
                            'acc_type_id'                  => $result['acc_type_id'],
                            'acc_status_id'           =>  $result['acc_status'],
                            'acc_head_id'   =>$result['acc_head_id']
                        );
                }
             }
             return $accounts_array;
         }
          public function getAccountTypes(){
             $this->load->model('dashboard/account');
             $this->load->language('dashboard/account');
             if(isset($this->request->get['flag'])){
                 $results = $this->model_dashboard_account->getAccountTypes($this->request->get['flag']);
             }else{
                $results = $this->model_dashboard_account->getAccountTypes('enabled');
             }
             $accounts_array = array();
             foreach ($results as $result) {
                $accounts_array['types'][] = array(
                        'id'             => $result['acc_type_id'],
                        'type'             => $result['acc_type_name'],
                        'head_id'             => $result['head_id'],
                        'status_id'             => $result['acc_type_status'],
                        'type_type'         => $result['acc_type_type'],
                        'type_type_text'         => $result['acc_type_type']==1?$this->language->get('text_system'):$this->language->get('text_user'),
                        'status'             => ($result['acc_type_status']==1)?$this->language->get('text_enable'):$this->language->get('text_disable')
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
         }
         
         public function getAccountHeads(){
             $this->load->model('dashboard/account');
             $results = $this->model_dashboard_account->getAccountHeads();
             
             $accounts_head = array();
             foreach ($results as $result) {
                $accounts_head['heads'][] = array(
                        'id'             => $result['acc_head_id'],
                        'head_title'             => $result['acc_head_title'],
                        'head_status'             => $result['acc_head_active']
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($accounts_head), $this->config->get('config_compression'));
         }
                  
         
         public function saveupdatetypes(){
            $this->load->model('dashboard/account');
            $this->load->language('dashboard/account'); 
            $results = $this->model_dashboard_account->saveupdatetypes($this->request->post);
            $save_item = array();
            $save_item['success'] = true;
            $save_item['msg'] = $this->language->get('msg_save_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
         }
         public function deletetype(){
            $this->load->model('dashboard/account');
            $id = $this->request->post['id'];
            $results = $this->model_dashboard_account->deletetype($id);
            $delete_item = array();
            $delete_item['success'] = true;
            $delete_item['msg'] = $this->language->get('msg_save_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_item), $this->config->get('config_compression'));
         }
         
          public function getCreditMerchantAccount(){
             $this->load->model('dashboard/account');
             $data = $this->request->get;
             $result = $this->model_dashboard_account->getCreditMerchantAccount($data['acc_id']);
             
             $account_detail = array();
             $account_detail['percentage'] = $result['percentage'];
             $account_detail['fromto'] = $result['fromto'];
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($account_detail), $this->config->get('config_compression'));
         }
    }
?>