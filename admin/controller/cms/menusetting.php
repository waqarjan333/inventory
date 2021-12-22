<?php
class ControllerCmsMenusetting extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('cms/menusetting'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/menusetting'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('cms/menusetting'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/menusetting'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_menusetting->addMenu($this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/menusetting' . $url);
		} 
		$this->getForm();
	}

	public function update() {
		$this->load->language('cms/menusetting'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/menusetting'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_menusetting->editMenu($this->request->get['menu_id'], $this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/menusetting' . $url);
		} 
		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('cms/menusetting'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/menusetting'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $menusetting_id) {
				$this->model_cms_menusetting->deleteMenu($menusetting_id);
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/menusetting' . $url);
		} 
		$this->getList();
	} 
	
	private function _getChildren($id, $menus) {
		$children = array();
		foreach($menus as $menu):
			if ($menu['parent_id']==$id)
				$children[] = $menu;
		endforeach;
		return $children;
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
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/menusetting' . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		); 				
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=cms/menusetting/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=cms/menusetting/delete' . $url;	 
		$this->data['menus'] = array(); 
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
		$menus_total = $this->model_cms_menusetting->getTotalMenus(); 
		$results = $this->model_cms_menusetting->getMenus($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=cms/menusetting/update&menu_id=' . $result['tm_id'] . $url
			); 	
			$this->data['menus'][] = array(
				'tm_id' 	  => $result['tm_id'],
				'tm_title'    => $result['tm_title'], 
				'tm_url'	  => $result['tm_url'],
				'tm_dir' 	  => $result['tm_dir'],
                                'tm_for' 	  => $result['menu_for'],
				'sort_order'  => $result['sort_order'],
				'parent_id'  => $result['parent_id'],
				'status' 	  => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'    => isset($this->request->post['selected']) && in_array($result['tm_id'], $this->request->post['selected']),
				'action'      => $action
			);
		} 
		
		
		$menus = $this->data['menus']; 
		$this->data['menus'] = array();
		for ($count=0,$size=count($menus);$count<$size;$count++):
			if (!$menus[$count]['parent_id']) {
				$menus[$count]['children'] = $this->_getChildren($menus[$count]['tm_id'], $menus);
				$this->data['menus'][] = $menus[$count];
			}
		endfor;
		
		
		
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_title']  = $this->language->get('column_title'); 
		$this->data['column_url']  = $this->language->get('column_murl'); 
		$this->data['column_dir']    = $this->language->get('column_dir'); 
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action'); 
                $this->data['column_for'] = $this->language->get('column_for'); 
                $this->data['option_allusers'] = $this->language->get('option_allusers'); 
                $this->data['option_providers'] = $this->language->get('option_providers'); 
                $this->data['option_seekers'] = $this->language->get('option_seekers'); 
                $this->data['option_not_providers'] = $this->language->get('option_not_providers'); 
                $this->data['option_not_seekers'] = $this->language->get('option_not_seekers'); 
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
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=cms/menusetting&sort=tm_title' . $url; 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 								
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $menus_total;
		$pagination->page = $page;
		$pagination->limit = 20;  // FIX me for admin panel ::::($this->config->get('config_admin_limit')) ? $this->config->get('config_admin_limit') : 20; 
		$pagination->text =  $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=cms/menusetting' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'cms/menusetting_list.tpl';
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
		$this->data['entry_url'] = $this->language->get('entry_url'); 
		$this->data['entry_dir'] = $this->language->get('entry_dir'); 
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order'); 
		$this->data['entry_status'] = $this->language->get('entry_status'); 
                $this->data['entry_for'] = $this->language->get('entry_for'); 
                $this->data['option_allusers'] = $this->language->get('option_allusers'); 
                $this->data['option_providers'] = $this->language->get('option_providers'); 
                $this->data['option_seekers'] = $this->language->get('option_seekers'); 
                $this->data['option_not_providers'] = $this->language->get('option_not_providers'); 
                $this->data['option_not_seekers'] = $this->language->get('option_not_seekers'); 
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		
		$this->data['menus'] = $this->model_cms_menusetting->getActiveMenu();
		
		
		$menus = $this->data['menus']; 
		$this->data['menus'] = array();
		for ($count=0,$size=count($menus);$count<$size;$count++):
			if (!$menus[$count]['parent_id']) {
				$menus[$count]['children'] = $this->_getChildren($menus[$count]['tm_id'], $menus);
				$this->data['menus'][] = $menus[$count];
			}
		endfor;

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
		if (isset($this->error['murl'])) {
			$this->data['error_murl'] = $this->error['murl'];
		} else {
			$this->data['error_murl'] = '';
		}  
  		$this->document->breadcrumbs = array(); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/menusetting',
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
		if (!isset($this->request->get['menu_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/menusetting/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/menusetting/update&menu_id=' . $this->request->get['menu_id'] . $url;
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=cms/menusetting' . $url; 
		if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$menusetting_info = $this->model_cms_menusetting->getMenu($this->request->get['menu_id']);
		} 
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($menusetting_info)) {
			$this->data['status'] = $menusetting_info['status'];
		} else {
			$this->data['status'] = 1;
		}   
		if (isset($this->request->post['tm_title'])) {
			$this->data['tm_title'] = $this->request->post['tm_title'];
		} elseif (isset($menusetting_info)) {
			$this->data['tm_title'] = $menusetting_info['tm_title'];
		} else {
			$this->data['tm_title'] = '';
		}
		
		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($menusetting_info)) {
			$this->data['parent_id'] = $menusetting_info['parent_id'];
		} else {
			$this->data['parent_id'] = '';
		}
		 
		if (isset($this->request->post['tm_url'])) {
			$this->data['tm_url'] = $this->request->post['tm_url'];
		} elseif (isset($menusetting_info)) {
			$this->data['tm_url'] = $menusetting_info['tm_url'];
		} else {
			$this->data['tm_url'] = '';
		} 
		$this->data['menudirs'] =array(
                         'Top'      => 1,
                         'Bottom'   => 2,
                         'left'     => 3,
                         'right'    => 4,
                );
		if (isset($this->request->post['tm_dir'])) {
			$this->data['tm_dir'] = $this->request->post['tm_dir'];
		} elseif (isset($menusetting_info)) {
			$this->data['tm_dir'] = $menusetting_info['tm_dir'];
		} else {
			$this->data['tm_dir'] = '';
		} 
                if (isset($this->request->post['tm_for'])) {
			$this->data['tm_for'] = $this->request->post['tm_for'];
		} elseif (isset($menusetting_info)) {
			$this->data['tm_for'] = $menusetting_info['menu_for'];
		} else {
			$this->data['tm_for'] = '';
		} 
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($menusetting_info)) {
			$this->data['sort_order'] = $menusetting_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		} 
		$this->template = 'cms/menusetting_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/menusetting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		if ((strlen(utf8_decode($this->request->post['tm_title'])) < 3) || (strlen(utf8_decode($this->request->post['tm_title'])) > 100)) {
				$this->error['tm_title'] = $this->language->get('error_title');
		} 
		if ((strlen(utf8_decode($this->request->post['tm_url'])) < 3) || (strlen(utf8_decode($this->request->post['tm_url'])) > 350)) {
				$this->error['tm_url'] = $this->language->get('error_url');
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
		if (!$this->user->hasPermission('modify', 'cms/menusetting')) {
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