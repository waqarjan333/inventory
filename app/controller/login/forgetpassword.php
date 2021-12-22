<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for Forget Password
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerLoginForgetpassword extends Controller { 
        public function index() {
            $this->forget_password();
  	}
        
        public function forget_password(){ 
            $this->data['base_url'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/login');
            $this->data['url_checkUserName'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/forgetpassword/checkUserName');
            $this->data['url_login'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login/login_user');
            $this->data['url_updatePass'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/forgetpassword/updatePass');
            $this->data['url_home'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/home');
            $this->data['url_pos'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/pos'); 
            $this->template = $this->config->get('config_template') . '/template/common/forget_password.tpl';
             $this->children = array();
             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
            
            
        }
        
        public function checkUserName(){
            $results='';
             $this->load->model('login/forgetpassword'); 
             if($this->request->post['username']!=""){
             $results = $this->model_login_forgetpassword->checkUserName($this->request->post);
             
             if($results){
                if($results['username'] == $this->request->post['username']){
                    $questions = $this->model_login_forgetpassword->adminQuestions($results['id']);
                    //print_r ($questions[0]);
                    $results = array(
                        'success' => '1', 
                        'msg' => "Now Please Enter Answer of Your Questions",
                        'user_hidden_id' => $results['id'],
                        'question_1' => $questions[0]['question'],
                        'question_2' => $questions[1]['question'],
                        'answer_1' => $questions[0]['answer'],
                        'answer_2' => $questions[1]['answer'], 
                        );
                } else {
                    $results = array('success' => '0', 'msg' => "Wrong Username! Please Enter Correct Admin Username");
                }
             } else {
                $results = array('success' => '0', 'msg' => "Wrong Username! Please Enter Correct Admin Username"); 
             }
             } else {
                 $results = array('success' => '0', 'msg' => "Please Enter Admin Username");
              }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($results), $this->config->get('config_compression'));
         }
         
         public function updatePass(){
            $results='';
             $this->load->model('login/forgetpassword'); 
             $result = $this->model_login_forgetpassword->updatePass($this->request->post);
             $results = array(
                 'success'=>'1',
                 'su_id' => $result['id'],
                 'msg' => "Password Successfully Changed",
                 'updPassword' => $this->request->post['pass'],
                 'type'=> $result['type'],
             );
             $this->load->library('json');
             $this->response->setOutput(Json::encode($results), $this->config->get('config_compression'));
         }
        
       
    }
?>