<?php
class ControllerCmsCmstype extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('cms/cmstype'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cmstype'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('cms/cmstype'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cmstype'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_cmstype->addCmstype($this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			} 
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			} 
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/cmstype' . $url);
		} 
		$this->getForm();
	}

	public function update() {
		$this->load->language('cms/cmstype'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cmstype'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_cmstype->editCmstype($this->request->get['cmstype_id'], $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			} 
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			} 
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			} 
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/cmstype' . $url);
		} 
		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('cms/cmstype'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cmstype'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $cmstype_id) {
				$this->model_cms_cmstype->deleteCmstype($cmstype_id);
			} 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			} 
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			} 
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			} 
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/cmstype' . $url);
		} 
		$this->getList();
	} 
	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		} 
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c_name';
		} 
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		} 
		$url = ''; 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
  		$this->document->breadcrumbs = array(); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/cmstype' . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		); 				
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=cms/cmstype/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=cms/cmstype/delete' . $url;	 
		$this->data['cmstypes'] = array(); 
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
		$cmstype_total = $this->model_cms_cmstype->getTotalCmstypes(); 
		$results = $this->model_cms_cmstype->getCmstypes($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=cms/cmstype/update&cmstype_id=' . $result['cmstype_id'] . $url
			); 	
			$this->data['cmstypes'][] = array(
				'cmstype_id'  => $result['cmstype_id'],
				'c_name'      => $result['c_name'], 
				'status' 	  => $result['status'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['cmstype_id'], $this->request->post['selected']),
				'action'      => $action
			);
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_page'] = $this->language->get('column_page'); 
		$this->data['column_type'] = $this->language->get('column_type'); 
		$this->data['column_status'] = $this->language->get('column_status');
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
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		} 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=cms/cmstype&sort=c_name' . $url; 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 								
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $cmstype_total;
		$pagination->page = $page;
		$pagination->limit = 20;  // FIX me for admin panel ::::($this->config->get('config_admin_limit')) ? $this->config->get('config_admin_limit') : 20; 
		$pagination->text =  $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=cms/cmstype' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'cms/cmstype_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');  
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled'); 
		$this->data['entry_title'] = $this->language->get('entry_title');  
		$this->data['entry_status'] = $this->language->get('entry_status'); 
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
  		$this->document->breadcrumbs = array(); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/cmstype',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		); 
		$url = ''; 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 				
		if (!isset($this->request->get['cmstype_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/cmstype/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/cmstype/update&cmstype_id=' . $this->request->get['cmstype_id'] . $url;
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=cms/cmstype' . $url; 
		if (isset($this->request->get['cmstype_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$cmstype_info = $this->model_cms_cmstype->getCmstype($this->request->get['cmstype_id']);
		} 
		$this->load->model('localisation/language'); 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
		 
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($cmstype_info)) {
			$this->data['status'] = $cmstype_info['status'];
		} else {
			$this->data['status'] = 1;
		}   
		if (isset($this->request->post['c_name'])) {
			$this->data['c_name'] = $this->request->post['c_name'];
		} elseif (isset($cmstype_info)) {
			$this->data['c_name'] = $cmstype_info['c_name'];
		} else {
			$this->data['c_name'] = '';
		}  
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($cmstype_info)) {
			$this->data['status'] = $cmstype_info['status'];
		} else {
			$this->data['status'] = 1;
		} 
		$this->template = 'cms/cmstype_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/cmstype')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		if ((strlen(utf8_decode($this->request->post['c_name'])) < 3) || (strlen(utf8_decode($this->request->post['c_name'])) > 50)) {
				$this->error['c_name'] = $this->language->get('error_title');
		}   

		if (!$this->error) {
			return TRUE;
		} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cms/cmstype')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		//check that its assigned to some page or not
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>