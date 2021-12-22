<?php 
class ControllerCommonNlheader extends Controller {
	protected function index() {
		$this->load->language('common/header'); 
		$this->data['title'] = $this->document->title; 
		$this->data['base'] = HTTPS_SERVER;
		$this->data['charset'] = $this->language->get('charset');
		$this->data['lang'] = $this->language->get('code');	
		$this->data['direction'] = $this->language->get('direction');
		$this->data['links'] = $this->document->links;	
		$this->data['styles'] = $this->document->styles;
		$this->data['scripts'] = $this->document->scripts; 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		if ($this->user->isLogged()) {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		} else {
			$this->data['logged'] = '';
		} 
		$this->id       = 'nlheader';
		$this->template = 'common/nlheader.tpl'; 
		$this->render();
	}
}
?>