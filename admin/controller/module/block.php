<?php
class ControllerModuleBlock extends Controller {
	private $error = array();  
	public function index() {   
		$this->load->language('module/block'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('setting/setting'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('block', $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module');
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_both'] = $this->language->get('text_both');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right'); 
		$this->data['entry_access'] = $this->language->get('entry_access');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order'); 
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel'); 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		} 
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=module/block'; 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/module'; 
		if (isset($this->request->post['block_position'])) {
			$this->data['block_position'] = $this->request->post['block_position'];
		} else {
			$this->data['block_position'] = $this->config->get('block_position');
		} 
		if (isset($this->request->post['block_status'])) {
			$this->data['block_status'] = $this->request->post['block_status'];
		} else {
			$this->data['block_status'] = $this->config->get('block_status');
		} 
		if (isset($this->request->post['block_sort_order'])) {
			$this->data['block_sort_order'] = $this->request->post['block_sort_order'];
		} else {
			$this->data['block_sort_order'] = $this->config->get('block_sort_order');
		}	 
		$this->template = 'module/block.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/block')) {
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