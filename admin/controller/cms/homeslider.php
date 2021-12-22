<?php    
class ControllerCmshomeslider extends Controller { 
	private $error = array(); 
  	public function index() {
		$this->load->language('cms/homeslider'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/homeslider'); 
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->language('cms/homeslider'); 
    	$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/homeslider'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_homeslider->addhomeslider($this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/homeslider' . $url);
		} 
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->language('cms/homeslider'); 
    	$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('cms/homeslider'); 
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_homeslider->edithomeslider($this->request->get['hs_id'], $this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/homeslider' . $url);
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('cms/homeslider');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('cms/homeslider');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $hps_id) {
				$this->model_cms_homeslider->deletehomeslider($hps_id);
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
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=cms/homeslider' . $url);
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
			$sort = 'title';
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
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/homeslider' . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=cms/homeslider/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=cms/homeslider/delete' . $url;	

		$this->data['homesliders'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
		$hps_total = $this->model_cms_homeslider->getTotalhomesliders(); 
		$results = $this->model_cms_homeslider->gethomesliders($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=cms/homeslider/update&hs_id=' . $result['hs_id'] . $url
			); 	
			$this->data['homesliders'][] = array(
				'hs_id'		  => $result['hs_id'],
				'title'            => $result['title'],
				'sort_order'      => $result['sort_order'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['hs_id'], $this->request->post['selected']),
				'action'          => $action
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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=cms/homeslider&sort=title' . $url;
		$this->data['sort_sort_order'] = HTTPS_SERVER . 'index.php?route=cms/homeslider&sort=sort_order' . $url;
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $hps_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=cms/homeslider' . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'cms/homeslider_list.tpl';
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
		$this->data['text_default'] = $this->language->get('text_default');
    	$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['entry_url'] = $this->language->get('entry_url');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
    	$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_url'] = $this->language->get('entry_url'); 
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel'); 
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
  		$this->document->breadcrumbs = array(); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=cms/homeslider',
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
							
		if (!isset($this->request->get['hs_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/homeslider/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=cms/homeslider/update&hs_id=' . $this->request->get['hs_id'] . $url;
		}
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=cms/homeslider' . $url;

    	if (isset($this->request->get['hs_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$homeslider_info = $this->model_cms_homeslider->gethomeslider($this->request->get['hs_id']);
    	}

    	if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (isset($homeslider_info)) {
			$this->data['name'] = $homeslider_info['title'];
		} else {	
      		$this->data['name'] = '';
    	}
		if (isset($this->request->post['short_description'])) {
      		$this->data['short_description'] = $this->request->post['short_description'];
    	} elseif (isset($homeslider_info)) {
			$this->data['short_description'] = $homeslider_info['short_description'];
		} else {	
      		$this->data['short_description'] = '';
    	}
		if (isset($this->request->post['description'])) {
      		$this->data['description'] = $this->request->post['description'];
    	} elseif (isset($homeslider_info)) {
			$this->data['description'] = $homeslider_info['description'];
		} else {	
      		$this->data['description'] = '';
    	}

		if (isset($this->request->post['linkto'])) {
      		$this->data['linkto'] = $this->request->post['linkto'];
    	} elseif (isset($homeslider_info)) {
			$this->data['linkto'] = $homeslider_info['linkto'];
		} else {	
      		$this->data['linkto'] = '';
    	}
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($homeslider_info)) {
			$this->data['image'] = $homeslider_info['image'];
		} else {
			$this->data['image'] = '';
		} 
		$this->load->model('tool/image'); 
		if (isset($homeslider_info) && $homeslider_info['image'] && file_exists(DIR_IMAGE . $homeslider_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($homeslider_info['image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		} 
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (isset($homeslider_info)) {
			$this->data['sort_order'] = $homeslider_info['sort_order'];
		} else {
      		$this->data['sort_order'] = '';
    	} 
		$this->template = 'cms/homeslider_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'cms/homeslider')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'cms/homeslider')) {
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