<?php
class ControllerExtensionFeed extends Controller {
	public function index() {
		$this->load->language('extension/feed');
		 
		$this->document->title = $this->language->get('heading_title'); 

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/feed',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['error'] = '';
		}

		$this->load->model('setting/extension');

		$extensions = $this->model_setting_extension->getInstalled('feed');
		
		$this->data['extensions'] = array();
						
		$files = glob(DIR_APP . 'controller/feed/*.php');
		
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
			
				$this->load->language('feed/' . $extension);

				$action = array();
			
				if (!in_array($extension, $extensions)) {
					$action[] = array(
						'text' => $this->language->get('text_install'),
						'href' => HTTPS_SERVER . 'index.php?route=extension/feed/install&extension=' . $extension
					);
				} else {
					$action[] = array(
						'text' => $this->language->get('text_edit'),
						'href' => HTTPS_SERVER . 'index.php?route=feed/' . $extension
					);
							
					$action[] = array(
						'text' => $this->language->get('text_uninstall'),
						'href' => HTTPS_SERVER . 'index.php?route=extension/feed/uninstall&extension=' . $extension
					);
				}
									
				$this->data['extensions'][] = array(
					'name'   => $this->language->get('heading_title'),
					'status' => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'action' => $action
				);
			}
		} 
		$this->template = 'extension/feed.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	public function install() {
    	if (!$this->user->hasPermission('modify', 'extension/feed')) {
      		$this->session['error'] = $this->language->get('error_permission'); 
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/feed');
    	} else {
			$this->load->model('setting/extension'); 
			$this->model_setting_extension->install('feed', $this->request->get['extension']); 
			$this->load->model('user/user_group'); 
			$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'feed/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'feed/' . $this->request->get['extension']); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/feed');			
		}
	}
	
	public function uninstall() {
    	if (!$this->user->hasPermission('modify', 'extension/feed')) {
      		$this->session['error'] = $this->language->get('error_permission');  
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/feed');
    	} else {		
			$this->load->model('setting/extension');
			$this->load->model('setting/setting'); 
			$this->model_setting_extension->uninstall('feed', $this->request->get['extension']); 
			$this->model_setting_setting->deleteSetting($this->request->get['extension']); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/feed');
		}
	}
}
?>