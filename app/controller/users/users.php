<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerUsersUsers extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
                     
        
  	}
       
        public function saveUser(){
            $this->load->model('users/users');
            $this->load->language('users/users'); 
            $save_item = array();
            if(!$this->model_users_users->checkNameExists($this->request->post)){
                if($this->request->post['user_hidden_id']==0){
                    $result = $this->model_users_users->saveUser($this->request->post);
                }
                else{
                    $result = $this->model_users_users->updateUser($this->request->post);
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
        private function fetchUsers(){
            $this->load->model('users/users');
              $this->load->language('users/users'); 
             $results = $this->model_users_users->getUsers($this->request->get);
             $user_array = array();
                         
             foreach ($results as $result) {
                 $right = "";
                 if($result['user_right']==0 && $result['user_type']==3){ $right = "No Access"; } 
                 else if ($result['user_right']==1 && $result['user_type']==3){ $right = "Full Access"; } 
                 else if ($result['user_right']==2 && $result['user_type']==3){ $right = "Selective Access"; }
                 else if ($result['user_right']==3 && $result['user_type']==3){ $right = "Customer Access"; }
                 else if ($result['user_type']==1){ $right = "POS User"; }                 
                 else { $right = "No Access";  }
                 $user_array['users'][] = array(
                        'user_id'             => $result['su_id'],                        
                        'user_group_id'             => $result['user_type'],
                        'user_type'             => $result['user_type']=="1"?"POS User":"System User",
                        'user_name'                  => $result['username'],
                        'user_firstname'             => $result['firstname'],
                        'user_lastname'             => $result['lastname'],
                        'user_status'             => $result['status'],
                        'customer_id'             => $result['howDidYouHear'],
                        'user_email'             => $result['email'],                                               
                        'user_status_text'             => $result['status']==1?$this->language->get('text_enabled'):$this->language->get('text_disabled'),
                        'update_pass'           =>$result['update_pass'],
                        'user_right'           => $right,
                        'user_group_right'     => $result['user_rigths']
                    );
             }
             return $user_array;
        }
        
         public function getUsers(){
             $users = $this->fetchUsers();
             $this->load->library('json');
             $this->response->setOutput(Json::encode($users), $this->config->get('config_compression'));
         }
         
          public function getUser(){
             $this->load->model('dashboard/user');
             $result = $this->model_users_users->getUser($this->request->get);
             $user_array = array();
             $user_array["user_id"] = $result['user_id'];
             $user_array["user_acc_id"] = $result['user_acc_id'];
             $user_array["user_name"] = $result['user_name'];
             $user_array["user_obalance"] = $result['user_balance'];
             $user_array["user_contact"] = $result['user_ct_name'];
             $user_array["user_phone"] = $result['user_phone'];
             $user_array["user_mobile"] = $result['user_mobile'];
             $user_array["user_fax"] = $result['user_fax'];
             $user_array["user_email"] = $result['user_email'];
             $user_array["user_address"] = $result['user_address'];
             $user_array["user_status"] = $result['user_status'];
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($user_array), $this->config->get('config_compression'));
         }
         public function changeState(){
            $this->load->model('users/users');
            $result = $this->model_users_users->changeState($this->request->post);
            $save_item = array();
            if($result==1 || $result==0){
                $save_item['action'] = 'success';
                $save_item['msg'] = $result;
                $save_item['data'] = $this->fetchUsers();
            }
            else{
                $save_item['action'] = 'failed';
                $save_item['msg'] = $result;
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
        
         public function deleteUser(){
            $this->load->model('users/users');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                 $this->model_users_users->deleteUser($id);
            } 
            $delete_user = array();
            $delete_user['success'] = true;
            $delete_user['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_user), $this->config->get('config_compression'));
            
        }
        
    }
?>