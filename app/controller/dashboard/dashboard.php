<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
     
class ControllerDashboardDashboard extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
                     
        
  	}
                
         public function saleChart(){
             $this->load->model('dashboard/dashboard');             
             $data = $this->request->get;
             $results = $this->model_dashboard_dashboard->getSalesReport($this->request->get);
             $chart_array = array();
             if($data['type_id']=="1"){                 
                foreach ($results as $result) {
                    $chart_array['data'][] = array(
                           'xData'             => DATE("g:i a", STRTOTIME($result['xAxis'].":00")),
                           'yData'             => number_format($result['yAxis'],2,'.','')
                       );
                }
             }
             else if ($data['type_id']=="2" || $data['type_id']=="3"|| $data['type_id']=="4" || $data['type_id']=="5"){
                 foreach ($results as $result) {
                    $chart_array['data'][] = array(
                           'xData'             => $result['xData'],
                           'yData'             => number_format($result['yData'],2,'.','')
                       );
                }
             }
             else if ($data['type_id']=="6" || $data['type_id']=="7" || $data['type_id']=="8" || $data['type_id']=="9" || $data['type_id']=="10"){
                 foreach ($results as $result) {
                    $chart_array['data'][] = array(
                           'xData'             => date($this->language->get('date_format_chart'), strtotime($result['xData'])),
                           'yData'             => number_format($result['yData'],2,'.','')
                       );
                }  
             }

             $this->load->library('json');
             $this->response->setOutput(Json::encode($chart_array), $this->config->get('config_compression'));
         }
         
         public function topProductChart(){
             $this->load->model('dashboard/dashboard');             
             $data = $this->request->get;
             $chart_array = array();
             $results = $this->model_dashboard_dashboard->getProductReport($this->request->get);
                           
            foreach ($results as $result) {
                $chart_array['data'][] = array(
                       'xData'             => $result['xData'],
                       'yData'             => number_format($result['yData'],2,'.','')
                   );
            }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($chart_array), $this->config->get('config_compression'));
         }
         
         public function topCustomerChart(){
             $this->load->model('dashboard/dashboard');             
             $data = $this->request->get;
             $chart_array = array();
             $results = $this->model_dashboard_dashboard->getPCustomerReport($this->request->get);
             
            foreach ($results as $result) {
                $chart_array['data'][] = array(
                       'xData'             => $result['xData'],
                       'yData'             => number_format($result['yData'],2,'.','')
                   );
            }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($chart_array), $this->config->get('config_compression'));
         }
       
    }
    
?>