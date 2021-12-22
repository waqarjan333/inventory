<?php 
/* Copyright (c) 2013- AURSoft
 * Crontroller for Pricel level
 * Created Date: 03/07/2013
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardPricelevel extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
    }
       
        public function saveupdate(){
            $this->load->model('dashboard/pricelevel');
            $this->load->language('dashboard/pricelevel'); 
             $this->load->model('common/common');
             $this->load->library('json');
            $save_pricelevel = array();
            if(!$this->model_dashboard_pricelevel->checkNameExists($this->request->post)){                
                $level_details = NULL;
                if($this->request->post['level_type']=="2"){
                    $level_details = (array)Json::decode(html_entity_decode($this->request->post['selected']));
                }
                
                $results = $this->model_dashboard_pricelevel->saveupdatePricelevel($this->request->post,$level_details);                                
                $save_pricelevel['success'] = 1;
                $save_pricelevel['obj_id'] = $results;
                //$save_pricelevel['data'] = $this->model_dashboard_pricelevel->getPriceLevels();
                $save_pricelevel['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_pricelevel['success'] = 0;
                $save_pricelevel['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_pricelevel), $this->config->get('config_compression'));            
        }
        
        public function deletePriceLevel(){
            $this->load->model('dashboard/pricelevel');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_pricelevel->deletePriceLevel($id);

            } 
            $delete_pricelevel = array();
            $delete_pricelevel['success'] = true;
            $delete_pricelevel['msg'] = $this->language->get('msg_deactivate_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_pricelevel), $this->config->get('config_compression'));
            
        }
        
         public function getPriceLevels(){
             $this->load->model('dashboard/pricelevel');
             $this->load->language('dashboard/pricelevel');
             $pricelevels_array =$this->getPriceLevelsArray($this->request->get);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($pricelevels_array), $this->config->get('config_compression'));
         }
         
         public function itemsPriceLevel(){
             $this->load->model('dashboard/pricelevel');
             $this->load->language('dashboard/pricelevel');
             $pricelevels_item_array =$this->model_dashboard_pricelevel->getItems($this->request->get);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($pricelevels_item_array), $this->config->get('config_compression'));
         }
         
         private function getPriceLevelsArray($get){
             $results = $this->model_dashboard_pricelevel->getPriceLevels($get);
             $pricelevels_array = array();
             foreach ($results as $result) {
                 $pricelevels_array['pricelevels'][] = array(
                        'id'             => $result['level_id'],
                        'level_name'             => $result['level_name'],
                        'level_type'                  => $result['level_type'],
                        'level_dir'                  => $result['level_dir'],
                        'level_per'                  => $result['level_per'],
                        'level_round'                  => $result['level_round'],
                        'level_compare_price'                  => $result['level_compare_price'],
                        'level_detail'                  => $result['level_detail'],
                         'level_from_date'              => date("Y-m-d", strtotime($result['level_from_date'])),
                         'level_to_date'              => date("Y-m-d", strtotime($result['level_to_date']))
                    );
             }
             return $pricelevels_array;
         }
          
       
    }
?>