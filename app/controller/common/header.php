<?php  
class ControllerCommonHeader extends Controller {
	protected function index() {              
            if (isset($this->request->post['redirectreg']) && ($this->siteusers->isLogged())) {
                $txtredir=$this->session->data['redirectreg'];
                unset($this->session->data['redirectreg']);
                $this->redirect($this->seourls->rewrite(str_replace('&amp;', '&', $txtredir)));
            }  
                        
            $this->data['home'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/pos');
            
          
            $this->language->load('common/header'); 
            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $server = HTTPS_IMAGE;
            } else {
                    $server = HTTP_IMAGE;
            } 
            $this->data['title'] = $this->document->title;
            $this->data['description'] = $this->document->description; 
            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $this->data['base'] = HTTPS_SERVER;
            } else {
                    $this->data['base'] = HTTP_SERVER;
            } 
            if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
                    $this->data['icon'] = $server . $this->config->get('config_icon');
            } else {
                    $this->data['icon'] = '';
            } 
            $this->data['parent_id'] = $this->siteusers->getUserParentId();
            $this->data['charset'] = $this->language->get('charset');
            $this->data['lang'] = $this->language->get('code');
            $this->data['direction'] = $this->language->get('direction');
            $this->data['links'] = $this->document->links;	
            $this->data['styles'] = $this->document->styles;
            $this->data['scripts'] = $this->document->scripts;		
            $this->data['breadcrumbs'] = $this->document->breadcrumbs; 
            $this->data['site'] = $this->config->get('config_name'); 
            if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
                    $this->data['logo'] = $server . $this->config->get('config_logo');
            } else {
                    $this->data['logo'] = '';
            } 
            
            $this->data['button_go'] = $this->language->get('button_go'); 
            $this->data['button_cancel'] = $this->language->get('button_cancel'); 
            $this->data['text_title'] = $this->language->get('text_title'); 
            $this->data['text_shortcuts'] = $this->language->get('text_shortcuts'); 
            
            $this->data['account'] = 'javascript:void(0)';
            $this->data['logged'] = $this->siteusers->isLogged();  
            $this->data['logout'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=dashboard/logout');
            $this->data['tellafriend'] = 'javascript:void(0)';
            $this->data['rfriend'] = $this->config->get('config_refer_friend_message');
            if (isset($this->request->get['keyword'])) {
                    $this->data['keyword'] = $this->request->get['keyword'];
            } else {
                    $this->data['keyword'] = '';
            } 
            $this->data['advanced'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=search/search'); 
                       
            
            $this->data['action'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/home'); 
            if (!isset($this->request->get['route'])) {
                    $this->data['redirect'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/home');
            } else { 
                    $data = $this->request->get; 
                    unset($data['_route_']); 
                    $route = $data['route']; 
                    unset($data['route']); 
                    $url = ''; 
                    if ($data) {
                            $url = '&' . urldecode(http_build_query($data));
                    }	 
                    $this->data['redirect'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=' . $route . $url);
            } 
            $this->data['language_code'] = $this->session->data['language'];  
            $this->load->model('localisation/language'); 
            $this->data['languages'] = array(); 
            $results = $this->model_localisation_language->getLanguages(); 
            foreach ($results as $result) {
                    if ($result['status']) {
                            $this->data['languages'][] = array(
                                    'name'  => $result['name'],
                                    'code'  => $result['code'],
                                    'image' => $result['image']
                            );	
                    }
            } 
            $this->data['currency_code'] = $this->currency->getCode();  
            $this->load->model('localisation/currency'); 
            $this->data['currencies'] = array(); 
            $results = $this->model_localisation_currency->getCurrencies();	 
            $this->data['dealsloc']=array();
            $this->load->model('common/common');  
            $logged = 0;
            $this->data['fullname']="";
            $this->data['full_name']="";
            if ($this->siteusers->isLogged()) {  
                $logged = 1;
                $this->data['fullname'] = sprintf($this->language->get('text_logged'),$this->siteusers->getFullName());
                $this->data['full_name'] = $this->siteusers->getFullName();
            } 
            $this->data['logged'] = $logged; 
            foreach ($results as $result) {
                if ($result['status']) {
                        $this->data['currencies'][] = array(
                                'title' => $result['title'],
                                'code'  => $result['code']
                        );
                }
            } 
            $this->id = 'header'; 
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/common/header.tpl';
            } else {
                    $this->template = 'default/template/common/header.tpl';
            } 
        	$this->render();
	} 
	
	
}
?>