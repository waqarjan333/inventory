<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerSettingsSettings extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
           $this->data['url_getrights'] = HTTP_SERVER.'index.php?route=common/rights/getUserRight';
           $this->data['url_saverights'] = HTTP_SERVER.'index.php?route=common/rights/saveRights';          
        
  	}
       
        public function saveUnit(){
            $this->load->model('settings/settings');
            $this->load->language('settings/settings'); 
            $save_item = array();
            if(!$this->model_settings_settings->checkNameExists($this->request->post)){
                if($this->request->post['unit_hidden_id']==0){
                    $result = $this->model_settings_settings->saveUnit($this->request->post);
                }
                else{
                    $result = $this->model_settings_settings->updateUnit($this->request->post);
                }
                $save_item['success'] = true;
                $save_item['msg'] = $this->language->get('msg_save_success');                
                $save_item['obj_id'] = $result;
            }
            else{
                $save_item['success'] = 0;
                $save_item['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        private function fetchUnits(){
            $this->load->model('settings/settings');
              $this->load->language('settings/settings'); 
             $results = $this->model_settings_settings->getUnits($this->request->get);
             $user_array = array();
                         
             foreach ($results as $result) {
                 $user_array['units'][] = array(
                        'id'             => $result['id'],                        
                        'name'             => $result['name']                        
                    );
             }
             return $user_array;
        }
        
         public function getUnits(){
             $users = $this->fetchUnits();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($users), $this->config->get('config_compression'));
         }
         
         
        
         public function deleteUnit(){
            $this->load->model('settings/settings');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                 $this->model_settings_settings->deleteUnit($id);
            } 
            $delete_user = array();
            $delete_user['success'] = true;
            $delete_user['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_user), $this->config->get('config_compression'));
            
        }
        
    }
?>