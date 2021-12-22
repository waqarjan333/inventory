<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardSalesrep extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
  	}
       
        public function saveupdate(){
            $this->load->model('dashboard/salesrep');
            $this->load->language('dashboard/salesrep'); 
            $this->load->model('common/common');
            $save_salesrep = array();            
            if(!$this->model_dashboard_salesrep->checkNameExists($this->request->post)){
                $results = $this->model_dashboard_salesrep->saveupdateSalesRep($this->request->post);
                
                $save_salesrep['success'] = 1;
                $save_salesrep['obj_id'] = $results;
                $save_salesrep['data'] = $this->model_common_common->getSalesrep();
                $save_salesrep['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_salesrep['success'] = 0;
                $save_salesrep['msg'] = $this->language->get('msg_name_exists');
            }
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_salesrep), $this->config->get('config_compression'));            
        }
        
        public function deleteSalerep(){
            $this->load->model('dashboard/salesrep');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                $this->model_dashboard_salesrep->deleteSalerep($id);
            } 
            $delete_account = array();
            $delete_account['success'] = true;
            $delete_account['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_account), $this->config->get('config_compression'));
            
        }
        public function deactivateSalerep(){
            $this->load->model('dashboard/salesrep');
            $this->load->model('common/common');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_salesrep->deactivateSalesrep($id);

            } 
            $deactivate_salesrep = array();
            $deactivate_salesrep['success'] = true;
            $deactivate_salesrep['data'] =$this->model_common_common->getSalesrep();
            $deactivate_salesrep['msg'] = $this->language->get('msg_deactivate_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($deactivate_salesrep), $this->config->get('config_compression'));
            
        }
         public function getSalesreps(){
             $this->load->model('dashboard/salesrep');
             $this->load->language('dashboard/salesrep');
             $salesreps_array =$this->getSaleRepArray($this->request->get);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($salesreps_array), $this->config->get('config_compression'));
         }
         private function getSaleRepArray($get){
             $results = $this->model_dashboard_salesrep->getSalesreps($get);
             $salesreps_array = array();
             foreach ($results as $result) {
                 $salesreps_array['salesreps'][] = array(
                        'id'             => $result['id'],
                        'salesrep_name'             => $result['salesrep_name'],
                        'salesrep_title'                  => $result['salesrep_title'],
                        'salesrep_phone'                  => $result['salesrep_phone'],
                        'salesrep_email'           =>  $result['salesrep_email'],
                        'salesrep_mobile'                  => $result['salesrep_mobile'],
                        'salesrep_address'                  => $result['salesrep_address'],                        
                        'salesrep_status'                  => $result['salesrep_status']
                    );
             }
             return $salesreps_array;
         }
          
       
    }
?>