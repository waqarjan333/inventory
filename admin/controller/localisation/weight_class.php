<?php
class ControllerLocalisationWeightClass extends Controller {
	private $error = array();  
 
	public function index() {
		$this->load->language('localisation/weight_class');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/weight_class');
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('localisation/weight_class');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/weight_class');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_weight_class->addWeightClass($this->request->post);
			
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
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url);
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('localisation/weight_class');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/weight_class');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_weight_class->editWeightClass($this->request->get['weight_class_id'], $this->request->post);
			
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
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url);
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('localisation/weight_class');

		$this->document->title = $this->language->get('heading_title');
 		
		$this->load->model('localisation/weight_class');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $weight_class_id) {
				$this->model_localisation_weight_class->deleteWeightClass($weight_class_id);
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
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url);
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
       		'href'      => HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class/delete' . $url;
		 
		$this->data['weight_classes'] = array();
		
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$weight_class_total = $this->model_localisation_weight_class->getTotalWeightClasses();
		
		$results = $this->model_localisation_weight_class->getWeightClasses($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=localisation/weight_class/update&weight_class_id=' . $result['weight_class_id'] . $url
			);

			$this->data['weight_classes'][] = array(
				'weight_class_id' => $result['weight_class_id'],
				'title'           => $result['title'] . (($result['unit'] == $this->config->get('config_weight_class')) ? $this->language->get('text_default') : NULL),
				'unit'            => $result['unit'],
				'value'           => $result['value'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['weight_class_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_unit'] = $this->language->get('column_unit');
		$this->data['column_value'] = $this->language->get('column_value');
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
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class&sort=title' . $url;
		$this->data['sort_unit'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class&sort=unit' . $url;
		$this->data['sort_value'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class&sort=value' . $url;
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $weight_class_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url . '&page={page}';

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/weight_class_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_unit'] = $this->language->get('entry_unit');
		$this->data['entry_value'] = $this->language->get('entry_value');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

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
		
 		if (isset($this->error['unit'])) {
			$this->data['error_unit'] = $this->error['unit'];
		} else {
			$this->data['error_unit'] = '';
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
       		'href'      => HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['weight_class_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class/insert' . $url;
		} else { 
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class/update&weight_class_id=' . $this->request->get['weight_class_id'] . $url;
		}

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class' . $url;

		if (isset($this->request->get['weight_class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$weight_class_info = $this->model_localisation_weight_class->getWeightClass($this->request->get['weight_class_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['weight_class_description'])) {
			$this->data['weight_class_description'] = $this->request->post['weight_class'];
		} elseif (isset($this->request->get['weight_class_id'])) {
			$this->data['weight_class_description'] = $this->model_localisation_weight_class->getWeightClassDescriptions($this->request->get['weight_class_id']);
		} else {
			$this->data['weight_class_description'] = array();
		}	

		if (isset($this->request->post['value'])) {
			$this->data['value'] = $this->request->post['value'];
		} elseif (isset($weight_class_info)) {
			$this->data['value'] = $weight_class_info['value'];
		} else {
			$this->data['value'] = '';
		}
		
		$this->template = 'localisation/weight_class_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/weight_class')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['weight_class_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 32)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if ((!$value['unit']) || (strlen(utf8_decode($value['unit'])) > 4)) {
				$this->error['unit'][$language_id] = $this->language->get('error_unit');
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/weight_class')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('catalog/product');
		
		foreach ($this->request->post['selected'] as $weight_class_id) {
			$weight_class_info = $this->model_localisation_weight_class->getWeightClass($weight_class_id);

			if ($weight_class_info && ($this->config->get('config_weight_class') == $weight_class_info['unit'])) {
				$this->error['warning'] = $this->language->get('error_default');
			}
			
			$product_total = $this->model_catalog_product->getTotalProductsByWeightClassId($weight_class_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}	
}
?>