<?php
class ControllerModuleMoredeals extends Controller {
	private $error = array();  
	public function index() {   
		$this->load->language('module/moredeals'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('setting/setting'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('moredeals', $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module');
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right'); 
		$this->data['text_both'] = $this->language->get('text_both');
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
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=module/moredeals'; 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/module'; 
		$this->data['permissions'] =array(
					"All"=>"*",
					"CMS"=>"cms/cms",
					"Deals directory"=>"deals/deals",
					"FAQ"=>"faqs/faqs",
					"Members"=>"member/member", 
					"Out stations"=>"outstations/outstations",
					"Partners / club partner"=>"clubpartners/clubpartners",
					"Sports"=>"sports/sports" 
	 	);
		if (isset($this->request->post['moredeals_access'])) {
			$this->data['moredeals_access'] = $this->request->post['moredeals_access'];
		} else {
			$this->data['moredeals_access'] = $this->config->get('moredeals_access');
		}  
		if (isset($this->request->post['moredeals_position'])) {
			$this->data['moredeals_position'] = $this->request->post['moredeals_position'];
		} else {
			$this->data['moredeals_position'] = $this->config->get('moredeals_position');
		} 
		if (isset($this->request->post['moredeals_status'])) {
			$this->data['moredeals_status'] = $this->request->post['moredeals_status'];
		} else {
			$this->data['moredeals_status'] = $this->config->get('moredeals_status');
		} 
		if (isset($this->request->post['moredeals_sort_order'])) {
			$this->data['moredeals_sort_order'] = $this->request->post['moredeals_sort_order'];
		} else {
			$this->data['moredeals_sort_order'] = $this->config->get('moredeals_sort_order');
		}	 
		$this->template = 'module/moredeals.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/moredeals')) {
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