<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardCustomertype extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
  	}
       
        public function saveupdate(){
            $this->load->model('dashboard/customertype');
            $this->load->language('dashboard/customertype'); 
            $this->load->model('common/common');
            $save_type = array();
            if(!$this->model_dashboard_customertype->checkNameExists($this->request->post)){
                $results = $this->model_dashboard_customertype->saveupdatetype($this->request->post);
                
                $save_type['success'] = 1;
                $save_type['obj_id'] = $results;
                $save_type['data'] = $this->model_common_common->getCustomerType();
                $save_type['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_type['success'] = 0;
                $save_type['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_type), $this->config->get('config_compression'));            
        }
               
        public function deleteType(){
            $this->load->model('dashboard/customertype');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    if($id!="1"){
                        $this->model_dashboard_customertype->deleteType($id);
                    }

            } 
            $delete_type = array();
            $delete_type['success'] = true;
            $delete_type['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_type), $this->config->get('config_compression'));
            
        }
        
         public function getType(){
             $this->load->model('dashboard/customertype');
             $this->load->language('dashboard/customertype');             
             
             $types_array =$this->getTypeArray($this->request->get);
             
             $this->load->library('json');             
             $this->response->setOutput(Json::encode($types_array), $this->config->get('config_compression'));
         }
         
         private function getTypeArray($get){
             $results = $this->model_dashboard_customertype->getType($get);
             $types_array = array();
             foreach ($results as $result) {
                 $types_array['types'][] = array(
                        'id'             => $result['id'],
                        'cust_type_name'             => $result['cust_type_name'],
                        'cust_type_code'                  => str_pad($result['id'], 5, "0", STR_PAD_LEFT),
                        'cust_type_isdefault'                  => $result['cust_type_isdefault']                        
                    );
             }
             return $types_array;
         }
          
       
    }
?>