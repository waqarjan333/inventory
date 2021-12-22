<?php    
class ControllerSeoSeo extends Controller { 
	private $error = array(); 
  	public function index() { 
		$this->load->language('seo/seo'); 
		$this->document->title = "seo urls"; 
		$this->load->model('seo/seo');  
    	$this->getList(); 
  	} 
  	public function insert() { 
		$this->load->language('seo/seo'); 
		$this->load->model('seo/seo'); 
    	$this->document->title = "seo urls"; 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { 
			$this->model_seo_seo->addSeo($this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=seo/seo');
		} 
    	$this->getForm();
  	} 
  	public function update() {  
		$this->load->language('seo/seo'); 
    	$this->document->title = "seo urls";
		$this->load->model('seo/seo'); 
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { 
			$this->model_seo_seo->editSeo($this->request->get['seo_id'], $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success');  
			$this->redirect(HTTPS_SERVER . 'index.php?route=seo/seo');
		} 
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('seo/seo'); 
    	$this->document->title = "seo urls";
		$this->load->model('seo/seo'); 
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $seo_id) { 
				$this->model_seo_seo->deleteseo($seo_id);
			} 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=seo/seo');
    	} 
    	$this->getList();
  	}   
  	private function getList() {  
 		$this->data['seo'] = array(); 
  		$results = $this->model_seo_seo->getSeos();
     	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=seo/seo/update&seo_id=' . $result['seo_id'],
				'target' => ''
			);  
			$this->data['seo'][] = array(
				'seo_id'		 	 => $result['seo_id'],
				'mainurl'     		 => $result['mainurl'],
				'title'     		 => $result['title'],
				'seourl'       		 => $result['seourl'],
				'selected'        	 => isset($this->request->post['selected']) && in_array($result['seo_id'], $this->request->post['selected']),
				'action'          	 => $action
			);
		} 
		$this->data['heading_title'] = "Custom SEO url"; 
		$this->data['text_no_results'] = $this->language->get('text_no_results');  
		$this->data['column_action'] = $this->language->get('column_action'); 
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');  
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		} 
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success']; 
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		} 
		$url = ''; 
  		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=seo/seo/insert'. $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=seo/seo/delete'. $url; 
		$this->template = 'seo/seo.tpl'; 
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression')); 
	}
  
  	private function getForm() {
    	$this->data['heading_title'] = "Custom SEO url"; 
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager'); 
		$this->data['entry_url'] = $this->language->get('entry_url');  
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');  
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		} 
 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}  
		$url = '';  
		if (!isset($this->request->get['seo_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=seo/seo/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=seo/seo/update&seo_id=' . $this->request->get['seo_id'] . $url;
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=seo/seo' . $url; 
    	if (isset($this->request->get['seo_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$seo_info = $this->model_seo_seo->getSeo($this->request->get['seo_id']);
    	} 
		if (isset($this->request->post['mainurl'])) {
      		$this->data['mainurl'] = $this->request->post['mainurl'];
    	} elseif (isset($seo_info)) {
			$this->data['mainurl'] = $seo_info['mainurl'];
		} else {	
      		$this->data['mainurl'] = '';
    	}
		if (isset($this->request->post['seourl'])) {
      		$this->data['seourl'] = $this->request->post['seourl'];
    	} elseif (isset($seo_info)) {
			$this->data['seourl'] = $seo_info['seourl'];
		} else {	
      		$this->data['seourl'] = '';
    	} 
		if (isset($this->request->post['seotitle'])) {
      		$this->data['seotitle'] = $this->request->post['seotitle'];
    	} elseif (isset($seo_info)) {
			$this->data['seotitle'] = $seo_info['title'];
		} else {	
      		$this->data['seotitle'] = '';
    	}
		if (isset($this->request->post['seokeywords'])) {
      		$this->data['seokeywords'] = $this->request->post['seokeywords'];
    	} elseif (isset($seo_info)) {
			$this->data['seokeywords'] = $seo_info['keywords'];
		} else {	
      		$this->data['seokeywords'] = '';
    	}
		if (isset($this->request->post['seodescription'])) {
      		$this->data['seodescription'] = $this->request->post['seodescription'];
    	} elseif (isset($seo_info)) {
			$this->data['seodescription'] = $seo_info['description'];
		} else {	
      		$this->data['seodescription'] = '';
    	}
		$this->template = 'seo/seo_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	public function autoseo() {
        $this->load->language('seo/seo');
        $this->document->title = $this->language->get('heading_title');
        $this->load->model('setting/setting');
        $this->load->model('seo/seo');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            if (isset($this->request->post['categories'])) {
                $this->model_seo_seo->generateCategories();
            }
            if (isset($this->request->post['ideas'])) {
                $this->model_seo_seo->generateIdeas();
            } 
			if (isset($this->request->post['cms'])) {
                $this->model_seo_seo->generateCMS();
            } 
            $this->data['success'] = $this->language->get('text_success');
        }
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        $this->data['warning_clear'] = $this->language->get('warning_clear');
        $this->data['back'] = $this->language->get('back');
        $this->data['categories'] = $this->language->get('categories');
        $this->data['ideas'] = $this->language->get('ideas'); 
		$this->data['cms'] = $this->language->get('cms'); 
        $this->data['generate'] = $this->language->get('generate');
        $this->data['action'] = HTTPS_SERVER . 'index.php?route=seo/seo/autoseo';//&token=' . $this->session->data['token'];
        $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=seo/seo';//&token=' . $this->session->data['token']; 
        $this->data['heading_title'] = $this->language->get('heading_title'); 
        $this->template = 'seo/auto_seo.tpl';
        $this->children = array('common/header','common/footer','common/leftcol');
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'seo/seo')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	} 
    	if ((strlen(utf8_decode($this->request->post['mainurl'])) ==0) || (strlen(utf8_decode($this->request->post['seourl'])) ==0) ) {
      		$this->error['warning'] .= 'both urls are required';
    	} 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	} 
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'seo/seo')) {
			$this->error['warning'] = $this->language->get('error_permission');
    	} 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	}
}
?>
