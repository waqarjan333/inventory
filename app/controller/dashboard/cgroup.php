<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardCgroup extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
  	}
       
        public function saveupdate(){
            $this->load->model('dashboard/cgroup');
            $this->load->language('dashboard/cgroup'); 
            $this->load->model('common/common');
            $save_group = array();
            if(!$this->model_dashboard_cgroup->checkNameExists($this->request->post)){
                $results = $this->model_dashboard_cgroup->saveupdategroup($this->request->post);
                
                $save_group['success'] = 1;
                $save_group['obj_id'] = $results;
                $save_group['data'] = $this->model_common_common->getCustomerGroup();
                $save_group['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_group['success'] = 0;
                $save_group['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_group), $this->config->get('config_compression'));            
        }
               
        public function deleteGroup(){
            $this->load->model('dashboard/cgroup');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    if($id!="1"){
                        $this->model_dashboard_cgroup->deleteGroup($id);
                    }

            } 
            $delete_group = array();
            $delete_group['success'] = true;
            $delete_group['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_group), $this->config->get('config_compression'));
            
        }
        
         public function getGroup(){
             $this->load->model('dashboard/cgroup');
             $this->load->language('dashboard/cgroup');             
             
             $groups_array =$this->getGroupArray($this->request->get);
             
             $this->load->library('json');             
             $this->response->setOutput(Json::encode($groups_array), $this->config->get('config_compression'));
         }
         
         private function getGroupArray($get){
             $results = $this->model_dashboard_cgroup->getGroup($get);
             $groups_array = array();
             foreach ($results as $result) {
                 $groups_array['groups'][] = array(
                        'id'             => $result['id'],
                        'cust_group_name'             => $result['cust_group_name'],
                        'cust_group_code'                  => str_pad($result['id'], 5, "0", STR_PAD_LEFT),
                        'cust_group_isdefault'                  => $result['cust_group_isdefault']                        
                    );
             }
             return $groups_array;
         }
          
       
    }
?>