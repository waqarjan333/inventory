<?php    
class ControllerUserSiteusers extends Controller { 
	private $error = array();
	private $utypes= array(
					  '1' => 'Service seeker',
					  '2' => 'Service provider'
	);
  	public function index() {
		$this->load->language('user/siteusers'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('user/siteusers'); 
    	$this->getList();
  	} 
  	public function insert() {
		$this->load->language('user/siteusers'); 
    	$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('user/siteusers'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      	  	$this->model_user_siteusers->addSiteusers($this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			} 
			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			} 
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			} 
			if (isset($this->request->get['filter_siteusers_type'])) {
				$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
			} 
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			} 
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			} 
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			} 			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			} 
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			} 
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			} 
			$this->redirect(HTTPS_SERVER . 'index.php?route=user/siteusers' . $url);
		} 
    	$this->getForm();
  	}  
  	public function update() {
		$this->load->language('user/siteusers'); 
    	$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('user/siteusers'); 
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_siteusers->editSiteusers($this->request->get['su_id'], $this->request->post); 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			} 
			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			} 
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			} 
			if (isset($this->request->get['filter_siteusers_type'])) {
				$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
			}  
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			} 
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			} 
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			} 		
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			} 
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			} 
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			} 
			$this->redirect(HTTPS_SERVER . 'index.php?route=user/siteusers' . $url);
		} 
    	$this->getForm();
  	}   
  	public function delete() {
		$this->load->language('user/siteusers'); 
    	$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('user/siteusers'); 
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $siteusers_id) {
				$this->model_user_siteusers->deletesiteusers($siteusers_id);
			} 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			} 
			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			} 
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			} 
		    if (isset($this->request->get['filter_siteusers_type'])) {
				$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
			}  
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			} 
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			} 
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			} 		
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			} 
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			} 
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			} 
			$this->redirect(HTTPS_SERVER . 'index.php?route=user/siteusers' . $url);
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
			$sort = 'date_added'; 
		} 
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		} 
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		} 
		
		if (isset($this->request->get['filter_username'])) {
			$filter_username = $this->request->get['filter_username'];
		} else {
			$filter_username = NULL;
		} 
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = NULL;
		} 
		if (isset($this->request->get['filter_siteusers_type'])) {
			$filter_siteusers_type = $this->request->get['filter_siteusers_type'];
		} else {
			$filter_siteusers_type = NULL;
		} 
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = NULL;
		} 
		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = NULL;
		} 
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		} 
		$url = ''; 
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		} 
		if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
		} 
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		} 
		if (isset($this->request->get['filter_siteusers_type'])) {
			$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
		} 
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		} 
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		} 
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		} 			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$this->data['userstypes']=$this->utypes;
		$this->data['approve'] = HTTPS_SERVER . 'index.php?route=user/siteusers/approve' . $url;
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=user/siteusers/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=user/siteusers/delete' . $url; 
		$this->data['siteusers'] = array(); 
		$data = array(
			'filter_name'              => $filter_name, 
			'filter_username'          => $filter_username, 
			'filter_email'             => $filter_email, 
			'filter_siteusers_type'    => $filter_siteusers_type, 
			'filter_status'            => $filter_status, 
			'filter_approved'          => $filter_approved, 
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		); 
		$siteusers_total = $this->model_user_siteusers->getTotalSiteusers($data); 
		$results = $this->model_user_siteusers->getSiteusers($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=user/siteusers/update&su_id=' . $result['su_id'] . $url
			); 
			$this->data['siteusers'][] = array(
				'su_id'    		 => $result['su_id'],
				'name'           => $result['fullname'],
				'username'       => $result['username'],
				'email'          => $result['email'],
				'referal'        => $result['howDidYouHear'], 
				'user_type'		 => $this->Usertypes($result['user_type']),
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'       => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['su_id'], $this->request->post['selected']),
				'action'         => $action
			);
		} 		
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_username'] = $this->language->get('column_username');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_user_type'] = $this->language->get('column_user_type');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action'); 
		$this->data['button_approve'] = $this->language->get('button_approve');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter'); 
		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error']; 
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
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
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			} 
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		} 
		if (isset($this->request->get['filter_siteusers_type'])) {
			$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
		} 
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		} 
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		} 
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		} 
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		} 
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=name' . $url;
		$this->data['sort_username'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=username' . $url;
		$this->data['sort_email'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=email' . $url;
		$this->data['sort_user_type'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=user_type' . $url;
		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=status' . $url;
		$this->data['sort_approved'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=approved' . $url;
		$this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=user/siteusers&sort=date_added' . $url; 
		$url = ''; 
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		} 
		if (isset($this->request->get['filter_username'])) {
			$url .= '&filter_username=' . $this->request->get['filter_username'];
		} 
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		} 
		if (isset($this->request->get['filter_siteusers_type'])) {
			$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
		} 
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		} 
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		} 
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		} 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 									
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $siteusers_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=user/siteusers' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_username'] = $filter_username;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_siteusers_type'] = $filter_siteusers_type;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_date_added'] = $filter_date_added;  
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'user/siteusers_list.tpl';
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
    	$this->data['entry_fullname'] = $this->language->get('entry_fullname');
    	$this->data['entry_username'] = $this->language->get('entry_username');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone'); 
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_user_type'] = $this->language->get('entry_user_type');
		$this->data['entry_status'] = $this->language->get('entry_status'); 
		$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel'); 
		$this->data['tab_general'] = $this->language->get('tab_general'); 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		} 
 		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		} 
		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}  
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		} 
 		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		} 
 		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		} 
 		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		} 
		$url = ''; 
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		} 
		if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			} 
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		} 
		if (isset($this->request->get['filter_siteusers_type'])) {
			$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
		} 
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		} 
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		} 
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		} 			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		if (!isset($this->request->get['su_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=user/siteusers/insert' . $url;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=user/siteusers/update&su_id=' . $this->request->get['su_id'] . $url;
		} 
    	$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=user/siteusers' . $url; 
    	if (isset($this->request->get['su_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$siteusers_info = $this->model_user_siteusers->getSiteuser($this->request->get['su_id']);
    	} 
    		if (isset($this->request->post['firstname'])) {
      		$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($siteusers_info)) { 
			$this->data['firstname'] = $siteusers_info['firstname'];
		} else {
      		$this->data['firstname'] = '';
    	} 
		if (isset($this->request->post['lastname'])) {
      		$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($siteusers_info)) { 
			$this->data['lastname'] = $siteusers_info['lastname'];
		} else {
      		$this->data['lastname'] = '';
    	} 
    	if (isset($this->request->post['email'])) {
      		$this->data['email'] = $this->request->post['email'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['email'] = $siteusers_info['email'];
		} else {
      		$this->data['email'] = '';
    	} 
    	if (isset($this->request->post['telephone'])) {
      		$this->data['telephone'] = $this->request->post['telephone'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['telephone'] = $siteusers_info['telephone'];
		} else {
      		$this->data['telephone'] = '';
    	}
		if (isset($this->request->post['country_id'])) {
      		$this->data['country_id'] = $this->request->post['country_id'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['country_id'] = $siteusers_info['country_id'];
		} else {
      		$this->data['country_id'] = '';
    	}
		if (isset($this->request->post['city'])) {
      		$this->data['city'] = $this->request->post['city'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['city'] = $siteusers_info['city'];
		} else {
      		$this->data['city'] = '';
    	}
		if (isset($this->request->post['mobileNumber'])) {
      		$this->data['mobileNumber'] = $this->request->post['mobileNumber'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['mobileNumber'] = $siteusers_info['mobileNumber'];
		} else {
      		$this->data['mobileNumber'] = '';
    	}
    	if (isset($this->request->post['newsletter'])) {
      		$this->data['newsletter'] = $this->request->post['newsletter'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['newsletter'] = $siteusers_info['newsletter'];
		} else {
      		$this->data['newsletter'] = '';
    	}
		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		$this->data['userstypes']=$this->utypes;
    	if (isset($this->request->post['user_type'])) {
      		$this->data['user_type'] = $this->request->post['user_type'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['user_type'] = $siteusers_info['user_type'];
		} else {
      		$this->data['user_type'] = '1';
    	} 
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($siteusers_info)) { 
			$this->data['status'] = $siteusers_info['status'];
		} else {
      		$this->data['status'] = 1;
    	} 
    	if (isset($this->request->post['password'])) { 
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		} 
		if (isset($this->request->post['confirm'])) { 
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		} 
		$this->template = 'user/siteusers_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}   
	public function approve() {
		$this->load->language('user/siteusers');
		$this->load->language('mail/siteusers'); 
		if (!$this->user->hasPermission('modify', 'user/siteusers')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['selected'])) {
				$this->load->model('user/siteusers');	 
				foreach ($this->request->post['selected'] as $siteusers_id) {
					$siteusers_info = $this->model_user_siteusers->getSiteuser($siteusers_id); 
					if ($siteusers_info && !$siteusers_info['approved']) {
						$this->model_user_siteusers->approve($siteusers_id);  
						$site_name = $this->config->get('config_name');
						$site_url = $this->config->get('config_url') . 'index.php?route=dashboard/login'; 
						$message  = "Hello ".$siteusers_info['fullname']. ", \n\n";;
						$message  .= sprintf($this->language->get('text_welcome'), $site_name) . "\n\n";;
						$message .= $this->language->get('text_login') . "\n";
						$message .= $site_url . "\n\n"; 
						$message .= $this->language->get('text_thanks') . "\n";
						$message .= $site_name; 
						$mail = new Mail();
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->hostname = $this->config->get('config_smtp_host');
						$mail->username = $this->config->get('config_smtp_username');
						$mail->password = $this->config->get('config_smtp_password');
						$mail->port = $this->config->get('config_smtp_port');
						$mail->timeout = $this->config->get('config_smtp_timeout');							
						$mail->setTo($siteusers_info['email']);
						$mail->setFrom($this->config->get('config_email'));
						$mail->setSender($site_name);
						$mail->setSubject(sprintf($this->language->get('text_subject'), $site_name));
						$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
						$mail->send(); 
						$this->session->data['success'] = sprintf($this->language->get('text_approved'), $siteusers_info['firstname'] . ' ' . $siteusers_info['lastname']);
					}
				}
			}			
		} 
		$url = ''; 
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		} 
		if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			} 
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		} 
		if (isset($this->request->get['filter_siteusers_type'])) {
			$url .= '&filter_siteusers_type=' . $this->request->get['filter_siteusers_type'];
		} 
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		} 
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		} 
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		} 		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		} 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}	 
		$this->redirect(HTTPS_SERVER . 'index.php?route=user/siteusers' . $url);
	}  
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'user/siteusers')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	} 
    	if ((strlen(utf8_decode($this->request->post['firstname'])) < 1) || (strlen(utf8_decode($this->request->post['firstname'])) > 30)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	} 
		if ((strlen(utf8_decode($this->request->post['lastname'])) < 1) || (strlen(utf8_decode($this->request->post['lastname'])) > 30)) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}  
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i'; 
		if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match($pattern, $this->request->post['email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    	} 
    	if ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	} 
    	if (($this->request->post['password']) || (!isset($this->request->get['su_id']))) {
      		if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
        		$this->error['password'] = $this->language->get('error_password');
      		} 
	  		if ($this->request->post['password'] != $this->request->post['confirm']) {
	    		$this->error['confirm'] = $this->language->get('error_confirm');
	  		}
    	} 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}  
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'user/siteusers')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	} 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	} 
	private function Usertypes($utype=1){ 
		return $this->utypes[$utype]; 
	} 
}
?>
