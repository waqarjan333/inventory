<?php 
class ControllerLoginLogin extends Controller {
        private $error = array();
	public function index() {
            
            if ($this->siteusers->isLogged() && $this->siteusers->isAdmin() && $this->siteusers->userRight()!=0) {
                    $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/home'));
            } 
            $this->language->load('login/login');           
            $this->data['forgotten'] = '#';
            $this->data['user_type'] = $this->language->get('text_admin');
            $this->data['button_login'] = $this->language->get('button_login');
            $this->data['text_login_page'] = $this->language->get('text_login_page');
            $this->data['text_login2'] = $this->language->get('text_login2');
            $this->document->title = $this->language->get('heading_title'); 
            $this->data['text_username'] = $this->language->get('text_username');
            $this->data['error_username'] = $this->language->get('error_username');
            $this->data['text_password'] = $this->language->get('text_password');
            $this->data['copy_right_text'] = $this->language->get('copy_right_text');
            $this->data['text_remember_preferences'] = $this->language->get('text_remember_preferences');
            $this->data['url_login'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login/login_user');
            $this->data['url_forgetPassword'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/forgetpassword');
            $this->data['url_home'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/home');
            $this->data['url_pos'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/pos');
            $this->load->model('login/login'); 
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/login/login.tpl')) { 
                    $this->template = $this->config->get('config_template') . '/template/login/login.tpl';
            } else {
                    $this->template = 'default/template/login/login.tpl';
            } 
            $this->children = array(
                    'common/header',
                    'common/footer'
            ); 
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
    } 
   
    public function login_user(){
        $auth_user = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) { 
                if (isset($this->request->post['username']) && isset($this->request->post['password']) && $this->validate()) {
                    if($this->session->data['user_right']==0) {
                       $auth_user["success"] = false;
                        $auth_user["errors"]["reason"] = "You have no access to login! Contact Administrator"; 
                    } else if($this->session->data['user_right']>=1 && $this->session->data['user_right']<=3) {  
                        $auth_user["success"] = true;                        
                        $auth_user["type"] =$this->session->data['su_type'];
                        $auth_user["update_pass"] =$this->session->data['update_pass'];
                        $auth_user["user_right"] =$this->session->data['user_right'];
                    }else {
                       $auth_user["success"] = false;
                        $auth_user["errors"]["reason"] = "Login failed. Try again."; 
                    }
                } else{
                        $auth_user["success"] = false;
                        $auth_user["errors"]["reason"] = "Login failed. Try again.";      
                }

            }  
       $this->load->library('json');
       $this->response->setOutput(Json::encode($auth_user), $this->config->get('config_compression'));     
    }
    private function validate() {
        
        if (!$this->siteusers->login($this->request->post['username'], $this->request->post['password'])) {
                $this->error['message'] = $this->language->get('error_login');
        }
        if (!$this->error) {
                return TRUE;
        } else {
                return FALSE;
        }  	

    }

}
?>