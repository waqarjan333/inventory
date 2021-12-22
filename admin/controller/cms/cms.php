<?php
class ControllerCmscms extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('cms/cms'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cms'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('cms/cms'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cms'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_cms->addCms($this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/cms' . $url);
		} 
		$this->getForm();
	}

	public function update() {
		$this->load->language('cms/cms'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cms'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_cms->editCms($this->request->get['cms_id'], $this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/cms' . $url);
		} 
		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('cms/cms'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/cms'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $cms_id) {
				$this->model_cms_cms->deleteCms($cms_id);
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/cms' . $url);
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
			$sort = 'cd.title';
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
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=cms/cms/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=cms/cms/delete' . $url;	 
		$this->data['cmsp'] = array(); 
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
		$cms_total = $this->model_cms_cms->getTotalCms(); 
		$results = $this->model_cms_cms->getCmsp($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=cms/cms/update&cms_id=' . $result['cms_id'] . $url
			); 	
			$this->data['cmsp'][] = array(
				'cms_id' => $result['cms_id'],
				'title'      => $result['title'],
				'type'       => $result['c_name'],
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['cms_id'], $this->request->post['selected']),
				'action'     => $action
			);
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_type'] = $this->language->get('column_type'); 
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
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=cms/cms&sort=cd.title' . $url;
		$this->data['sort_sort_order'] = HTTPS_SERVER . 'index.php?route=cms/cms&sort=c.sort_order' . $url; 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 								
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $cms_total;
		$pagination->page = $page;
		$pagination->limit = 20;  //FIX ME FOR AMDIN PANELED SER $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=cms/cms' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'cms/cms_list.tpl';
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
		$this->data['text_enabled'] = $this->language->get('text_enabled');
                $this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['tab_general'] = $this->language->get('tab_general'); 
		$this->data['tab_data'] = $this->language->get('tab_data'); 
		$this->data['tab_menu'] = $this->language->get('tab_menu'); 
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_site'] = $this->language->get('entry_site');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_moderated'] = $this->language->get('entry_moderated');
		$this->data['entry_comments'] = $this->language->get('entry_comments');
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
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/cms',
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
		if (!isset($this->request->get['cms_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/cms/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/cms/update&cms_id=' . $this->request->get['cms_id'] . $url;
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=cms/cms' . $url; 
                
		if (isset($this->request->get['cms_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$cms_info = $this->model_cms_cms->getCms($this->request->get['cms_id']);
		} 
		$this->load->model('localisation/language'); 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
		if (isset($this->request->post['cms_description'])) {
			$this->data['cms_description'] = $this->request->post['cms_description'];
		} elseif (isset($this->request->get['cms_id'])) {
			$this->data['cms_description'] = $this->model_cms_cms->getCmsDescriptions($this->request->get['cms_id']);
		} else {
			$this->data['cms_description'] = array();
		} 
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($cms_info)) {
			$this->data['status'] = $cms_info['status'];
		} else {
			$this->data['status'] = 1;
		} 
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($cms_info)) {
			$this->data['keyword'] = $cms_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		} 
		
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($cms_info)) {
			$this->data['sort_order'] = $cms_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		} 
		//documents retreival
		
		if (isset($this->request->post['documents'])) {
			$this->data['documents']=$this->request->post['documents'];
		} elseif (isset($industryinsight_info)) {
			$this->data['documents'] = $this->model_cms_cms->getDocuments($this->request->get['cms_id']); 
		} else {
				$this->data['documents']=array();
		} 
		
		//menus
		$this->load->model('cms/cms'); 
		$this->load->model('cms/menusetting');
		$this->data['menus'] = array();
		$this->data['menus'] = $this->model_cms_menusetting->getActiveMenu(); 
		//menu setting
		if(isset($cms_info)) { 
                    $menusetting_info = $this->model_cms_cms->getMenu($cms_info['cmsmenu_id']);
		}
		if (isset($this->request->post['tm_title'])) {
			$this->data['tm_title'] = $this->request->post['tm_title'];
		} elseif (isset($menusetting_info) && isset($menusetting_info['tm_title'])) {
			$this->data['tm_title'] = $menusetting_info['tm_title'];
		} else {
			$this->data['tm_title'] = '';
		}
		$this->data['menudirs'] =array(
                     'Top | Main Navigation'      => 1,
                     'left'     => 2,
                     'right'    => 3,
                     'Member'    => 4,
                     'Bottom | Column 1'   => 5,
                     'Bottom | Column 2'   => 6,
                     'Bottom | Column 3'   => 7,
                     'Bottom | Column 4'   => 8,
									 
		);
		if (isset($this->request->post['tm_dir'])) {
			$this->data['tm_dir'] = $this->request->post['tm_dir'];
		} elseif (isset($menusetting_info) && isset($menusetting_info['tm_dir'])) {
                    
			$this->data['tm_dir'] = $menusetting_info['tm_dir'];
		} else {
			$this->data['tm_dir'] = '';
		} 
		if (isset($this->request->post['msort_order'])) {
			$this->data['msort_order'] = $this->request->post['msort_order'];
		} elseif (isset($menusetting_info) && isset($menusetting_info['sort_order'])) {
			$this->data['msort_order'] = $menusetting_info['sort_order'];
		} else {
			$this->data['msort_order'] = 0;
		} 
		
		$this->template = 'cms/cms_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	} 
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/cms')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		foreach ($this->request->post['cms_description'] as $language_id => $value) {
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
		if (!$this->user->hasPermission('modify', 'cms/cms')) {
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