<?php 
class ControllerProjectsCategory extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('projects/category'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('projects/category'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('projects/category'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('projects/category'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_projects_category->addCategory($this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=projects/category'); 
		} 
		$this->getForm();
	} 
	public function update() {
		$this->load->language('projects/category'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('projects/category'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_projects_category->editCategory($this->request->get['category_id'], $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=projects/category');
		} 
		$this->getForm();
	} 
	public function delete() {
		$this->load->language('projects/category'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('projects/category'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				$this->model_projects_category->deleteCategory($category_id);
			} 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=projects/category');
		} 
		$this->getList();
	} 
	private function getList() { 
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=projects/category/insert';
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=projects/category/delete'; 
		$this->data['categories'] = array(); 
		$results = $this->model_projects_category->getCategories(0); 
		foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=projects/category/update&category_id=' . $result['category_id']
			); 
			$this->data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected']),
				'action'      => $action
			);
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
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
		$this->template = 'projects/category_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	} 
	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled'); 
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description'); 
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_status'] = $this->language->get('entry_status'); 
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel'); 
                $this->data['tab_general'] = $this->language->get('tab_general');
                $this->data['tab_data'] = $this->language->get('tab_data'); 
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		} 
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}  
		if (!isset($this->request->get['category_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=projects/category/insert';
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=projects/category/update&category_id=' . $this->request->get['category_id'];
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=projects/category'; 
		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$category_info = $this->model_projects_category->getCategory($this->request->get['category_id']);
    	} 
		$this->load->model('localisation/language'); 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($category_info)) {
			$this->data['category_description'] = $this->model_projects_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$this->data['category_description'] = array();
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($category_info)) {
			$this->data['status'] = $category_info['status'];
		} else {
			$this->data['status'] = 1;
		} 
		$this->data['categories'] = $this->model_projects_category->getCategories(0); 
		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($category_info)) {
			$this->data['parent_id'] = $category_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}  
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($category_info)) {
			$this->data['keyword'] = $category_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		} 
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($category_info)) {
			$this->data['sort_order'] = $category_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}  
		$this->template = 'projects/category_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	} 
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'projects/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
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
		if (!$this->user->hasPermission('modify', 'projects/category')) {
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