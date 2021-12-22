<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for Banks
 * Created Date: 10/07/2015
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardBank extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }                             
  	}
              
        private function fetchBanks(){
             $this->load->model('dashboard/bank');
             $this->load->language('dashboard/bank'); 
             $results = $this->model_dashboard_bank->getBanks($this->request->get);
             $bank_array = array();
                         
             foreach ($results as $result) {
                 $bank_array['banks'][] = array(
                        'bank_id'             => $result['acc_id'],
                        'bank_name'             => $result['acc_name'],
                        'bank_status'             => $result['acc_status'],
                        'balance'                 => 0  
                    );
             }
             return $bank_array;
        }
       
         public function getBanks(){
             $banks = $this->fetchBanks();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($banks), $this->config->get('config_compression'));
         }
         
          public function getBank(){
             $this->load->model('dashboard/bank');
             $result = $this->model_dashboard_bank->getVendor($this->request->get);
             $bank_array = array();
             $bank_array["bank_id"] = $result['acc_id'];          
             $bank_array["bank_name"] = $result['acc_name'];             
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($bank_array), $this->config->get('config_compression'));
         }
        
        
    }
?>