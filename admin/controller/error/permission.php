<?php    
class ControllerErrorPermission extends Controller {    
	public function index() { 
    	$this->load->language('error/permission');
  
    	$this->document->title = $this->language->get('heading_title');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_permission'] = $this->language->get('text_permission');
													
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=error/permission',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->template = 'error/permission.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
}
?>