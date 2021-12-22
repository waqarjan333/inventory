<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 17/07/2015
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardExpense extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }                           
  	}
              
        private function fetchExpenses(){
            $this->load->model('dashboard/expense');
              $this->load->language('dashboard/expense'); 
             $results = $this->model_dashboard_expense->getExpenses($this->request->get);
             $expense_array = array();
                         
             foreach ($results as $result) {
                 $expense_array['expenses'][] = array(
                        'id'             => $result['acc_id'],
                        'expense_name'             => $result['acc_name'],
                        'expense_description'             => $result['acc_description'],
                        'expense_status'             => $result['acc_status']                        
                    );
             }
             return $expense_array;
        }
       
         public function getExpenses(){
             $expenses = $this->fetchExpenses();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($expenses), $this->config->get('config_compression'));
         }
         
         public function getAllExpenses (){             
             $this->load->model('dashboard/expense');
             $this->load->language('dashboard/expense'); 
             $results = $this->model_dashboard_expense->getAllExpenses($this->request->get);
             $expense_array = array();                         
             foreach ($results as $result) {
                 $expense_array['expenses'][] = array(
                        'expense_id'             => $result['acc_id'],
                        'expense_name'             => $result['acc_name'],                        
                        'expense_status'             => $result['acc_status']                        
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($expense_array), $this->config->get('config_compression'));
             
         }
         
         public function getAllLoans (){             
             $this->load->model('dashboard/expense');
             $this->load->language('dashboard/expense'); 
             $results = $this->model_dashboard_expense->getAllLoans($this->request->get);
             $expense_array = array();                         
             foreach ($results as $result) {
                 $flag = $result['acc_type_id']==14 ? " (A/R)": " (A/P)";
                 $expense_array['loans'][] = array(
                        'loan_id'             => $result['acc_id'],
                        'loan_name'             => $result['acc_name'] . $flag,                        
                        'loan_type'             => $result['acc_type_id'],                        
                        'loan_status'             => $result['acc_status']                        
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($expense_array), $this->config->get('config_compression'));
             
         }
                
        
        
    }
?>