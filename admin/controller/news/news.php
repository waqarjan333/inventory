<?php
class ControllerNewsNews extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('news/news'); 
		$this->document->title =$this->language->get('heading_title'); 
		$this->load->model('news/news'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('news/news'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('news/news'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news->addNews($this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=news/news' . $url);
		} 
		$this->getForm();
	}

	public function update() {
		$this->load->language('news/news'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('news/news'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news->editNews($this->request->get['news_id'], $this->request->post); 
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=news/news' . $url);
		} 
		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('news/news'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('news/news'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->deleteNews($news_id);
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=news/news' . $url);
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
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=news/news/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=news/news/delete' . $url;	 
		$this->data['newsp'] = array(); 
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
		$news_total = $this->model_news_news->getTotalNews(); 
		$results = $this->model_news_news->getNewsp($data); 
                foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=news/news/update&news_id=' . $result['news_id'] . $url
			); 	
                        
			$this->data['newsp'][] = array(
				'news_id' => $result['news_id'],
				'title'      => $result['title'],
				'type'       => $result['n_name'],
                                'status'       => ($result['news_status']==1)?$this->language->get('option_enable'):$this->language->get('option_disable'),
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'action'     => $action
			);
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_title'] = $this->language->get('column_title');
                $this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_type'] = $this->language->get('column_type'); 
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action'); 
                $this->data['column_status'] = $this->language->get('column_status'); 
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
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=news/news&sort=cd.title' . $url;
		$this->data['sort_sort_order'] = HTTPS_SERVER . 'index.php?route=news/news&sort=c.sort_order' . $url; 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 								
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = 20;  //FIX ME FOR AMDIN PANELED SER $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=news/news' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'news/news_list.tpl';
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
                $this->data['entry_industry'] = $this->language->get('entry_industry');
		$this->data['entry_status'] = $this->language->get('entry_status'); 
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel'); 
                $this->data['text_none'] = $this->language->get('text_none');
                $this->data['option_disable'] =$this->language->get('option_disable');
                $this->data['option_enable'] =$this->language->get('option_enable');
		
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
       		'href'      => HTTPS_SERVER . 'index.php?route=news/news',
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
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=news/news/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=news/news/update&news_id=' . $this->request->get['news_id'] . $url;
		} 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=news/news' . $url; 
		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_news_news->getNews($this->request->get['news_id']);
		} 
		$this->load->model('localisation/language'); 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_description'] = $this->model_news_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		} 
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
			$this->data['status'] = 1;
		} 
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($news_info)) {
			$this->data['keyword'] = $news_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		} 
                
                if (isset($this->request->post['news_industry_id'])) {
                        $this->data['news_industry_id'] = $this->request->post['news_industry_id'];
                } elseif (isset($news_info)) {
                        $this->data['news_industry_id'] = $news_info['newstype_id'];
                } else {
                        $this->data['news_industry_id'] = 0;
                } 
		
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($news_info)) {
			$this->data['sort_order'] = $news_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		} 
                
		$this->load->model('common/common'); 
		$results = $this->model_common_common->getIndustries();		
                foreach ($results as $result) {
                    $this->data['industries'][] = array(
                                    'ind_id' => $result['category_id'],
                                    'title'      => $result['title']
                                    
                            );
                }
		
		$this->template = 'news/news_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	} 
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		foreach ($this->request->post['news_description'] as $language_id => $value) {
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
		if (!$this->user->hasPermission('modify', 'news/news')) {
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