<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerCommonRights extends Controller { 
        public function index() {
            //Load Controller            
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }                
            else {
                $this->getDetails();
            }
  	}
        
        public function getDetails(){
                                                 
             
             $this->data['url_getrights'] = HTTP_SERVER.'index.php?route=common/rights/getUserRight';
             $this->data['url_saverights'] = HTTP_SERVER.'index.php?route=common/rights/saveRights';
             
             
             $this->template = $this->config->get('config_template') . '/template/common/userrights.tpl';
             $this->children = array();
             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
            
            
        }
       
        
        public function getUserRight(){            
            $this->load->model('common/rights');
            
            $data = $this->request->get;            
            $userid = $data["user_id"];
            
            $result_array = array();
            $result =  $this->model_common_rights->getUser($userid);                        
            $result_array["user_id"] = $result['user_id'];
            $result_array["user_rights"] = $result['user_rigths'];
                        
            $this->load->library('json'); 
            $this->response->setOutput(Json::encode($result_array), $this->config->get('config_compression'));
        }
       
        
        public function saveRights(){            
            $this->load->model('common/rights');
            $data = $this->request->post;
            
            $this->load->library('json');            
            $result = array();
            $result['success'] = 0;
            $user = $this->model_common_rights->saveRights($data);
            if($user=="0"){
                $result['success'] = 1;
            }
            else{
                $result['error'] = $user;
            }
                        
            $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        }
        
        
    }
?>