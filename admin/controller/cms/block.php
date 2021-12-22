<?php
class ControllerCmsblock extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('cms/block'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/block'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('cms/block'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/block'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_block->addBlock($this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/block' . $url);
		} 
		$this->getForm();
	}

	public function update() {
		$this->load->language('cms/block'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/block'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_block->editBlock($this->request->get['block_id'], $this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/block' . $url);
		} 
		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('cms/block'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/block'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $block_id) {
				$this->model_cms_block->deleteblock($block_id);
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/block' . $url);
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
			$sort = 'bd.title';
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
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=cms/block/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=cms/block/delete' . $url;	 
		$this->data['blockp'] = array(); 
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
		$blockpositions= array(
			'1'  => "Left",
			'2' => "Right" 
		); 
		$block_total = $this->model_cms_block->getTotalblock(); 
		/*$results = $this->model_cms_block->getblockp($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=cms/block/update&block_id=' . $result['block_id'] . $url
			); 	
			$this->data['blockp'][] = array(
				'block_id' => $result['block_id'],
				'block_name' => $result['block_name'],
				'title'      => $result['title'], 
				'position'   => $blockpositions[$result['position']], 
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['cms_id'], $this->request->post['selected']),
				'action'     => $action
			);
		} */
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_title'] = $this->language->get('column_title'); 
		$this->data['column_position'] = $this->language->get('column_position'); 
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action'); 
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete'); 
		$this->data['tab_general'] = $this->language->get('tab_general'); 
		$this->data['tab_data'] = $this->language->get('tab_data'); 
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
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=cms/block&sort=cd.title' . $url;
		$this->data['sort_sort_order'] = HTTPS_SERVER . 'index.php?route=cms/block&sort=c.sort_order' . $url; 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 								
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $block_total;
		$pagination->page = $page;
		$pagination->limit = 20;  //FIX ME FOR AMDIN PANELED SER $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=cms/block' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'cms/block_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_all'] = $this->language->get('text_all');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['tab_general'] = $this->language->get('tab_general'); 
		$this->data['tab_data'] = $this->language->get('tab_data'); 
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_position'] = $this->language->get('entry_position'); 
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_pagestoshow'] = $this->language->get('entry_pagestoshow');
		$this->data['entry_showonhomepage'] = $this->language->get('entry_showonhomepage'); 
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
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
	 	if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		} 
  		$this->document->breadcrumbs = array(); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/block',
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
		if (!isset($this->request->get['block_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/block/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/block/update&block_id=' . $this->request->get['block_id'] . $url;
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=cms/block' . $url; 
		if (isset($this->request->get['block_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$block_info = $this->model_cms_block->getBlock($this->request->get['block_id']);
		} 
		$this->load->model('localisation/language'); 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
		if (isset($this->request->post['block_description'])) {
			$this->data['block_description'] = $this->request->post['block_description'];
		} elseif (isset($this->request->get['block_id'])) {
			$this->data['block_description'] = $this->model_cms_block->getBlockDescriptions($this->request->get['block_id']);
		} else {
			$this->data['block_description'] = array();
		}  
		$this->data['cmspages'] = $this->model_cms_block->getAllpages();  
		if (isset($this->request->post['block_pages'])) {
			$this->data['block_pages'] = $this->request->post['block_pages'];
		} elseif (isset($block_info)) {
			//$this->data['block_pages'] = $this->model_cms_block->getBlockpages($block_info['block_id']);
		} else {
			$this->data['block_pages'] = array(0);
		}	
		if (isset($this->request->post['homepage'])) {
			$this->data['homepage'] = $this->request->post['homepage'];
		} elseif (isset($block_info)) {
			$this->data['homepage'] = $block_info['block_home'];
		} else {
			$this->data['homepage'] = 0;
		} 
		$blockpositions= array(
			'1'  => "Left",
			
			'2' => "Right" 
		); 
		$this->data['bpositions']=$blockpositions;
		if (isset($this->request->post['position'])) {
			$this->data['position'] = $this->request->post['position'];
		} elseif (isset($block_info)) {
			$this->data['position'] = $block_info['position'];
		} else {
			$this->data['position'] = 0;
		} 
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($block_info)) {
			$this->data['status'] = $block_info['status'];
		} else {
			$this->data['status'] = 1;
		} 
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($block_info)) {
			$this->data['sort_order'] = $block_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		} 
		if (isset($this->request->post['blockname'])) {
			$this->data['blockname'] = $this->request->post['blockname'];
		} elseif (isset($block_info)) {
			$this->data['blockname'] = $block_info['block_name'];
		} else {
			$this->data['blockname'] = '';
		}  
		$this->template = 'cms/block_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/block')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		foreach ($this->request->post['block_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 32)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			} 
			if (strlen(utf8_decode($value['description'])) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
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
		if (!$this->user->hasPermission('modify', 'cms/block')) {
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