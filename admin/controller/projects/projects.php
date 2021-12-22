<?php    
class Controllerprojectsprojects extends Controller { 
	private $error = array(); 
  	public function index() {
		$this->load->language('projects/projects'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('projects/projects'); 
    	$this->getList();
  	} 
	public function insert() {
		$this->getForm();
	}
	
	public function update() {
		$this->getForm();
	}
  	public function delete() {
		$this->load->language('projects/projects'); 
    	$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('projects/projects'); 
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $projects_id) {
				$this->model_projects_projects->deleteprojects($projects_id);
			} 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$url = ''; 
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
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
			$this->redirect(HTTPS_SERVER . 'index.php?route=projects/projects' . $url);
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
			$sort = 'i.created_date'; 
		} 
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		} 
		if (isset($this->request->get['filter_id'])) {
			$filter_id = $this->request->get['filter_id'];
		} else {
			$filter_id = NULL;
		}  
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = NULL;
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
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}  
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
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
		$this->data['approve'] = HTTPS_SERVER . 'index.php?route=projects/projects/approve' . $url;
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=projects/projects/insert' . $url;
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=projects/projects/delete' . $url; 
		$this->data['projectss'] = array(); 
		$data = array(
			'filter_id'             => $filter_id, 
			'filter_title'             => $filter_title,  
			'filter_status'            => $filter_status, 
			'filter_approved'          => $filter_approved, 
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		); 
		$projects_total = $this->model_projects_projects->getTotalprojects($data); 
		$results = $this->model_projects_projects->getprojects($data); 
    	foreach ($results as $result) {
			$action = array(); 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=projects/projects/update&idea_id=' . $result['project_id'] . $url
			); 
			$this->data['projectss'][] = array(
				'project_id'       => $result['project_id'],
				'project_name'       => $result['project_name'],
				'fullname'         => $result['fullname'],  
				'category_name'    => $result['category_name'],  
				'status'           => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'         => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'created_date'      => date('d/m/Y h:i', strtotime($result['added_date'])),
				'selected'         => isset($this->request->post['selected']) && in_array($result['idea_id'], $this->request->post['selected']),
				'action'           => $action
			);
		} 	
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_name'] = $this->language->get('column_name'); 
		$this->data['column_indname'] = $this->language->get('column_indname'); 
		$this->data['column_ideafile'] = $this->language->get('column_ideafile');  
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
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}  
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
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
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=projects/projects&sort=d.idea_title' . $url; 
		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=projects/projects&sort=i.status' . $url;
		$this->data['sort_approved'] = HTTPS_SERVER . 'index.php?route=projects/projects&sort=i.approved' . $url;
		$this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=projects/projects&sort=i.create_date' . $url; 
		$url = ''; 
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
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
		$pagination->total = $projects_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=projects/projects' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['filter_title'] = $filter_title; 
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_date_added'] = $filter_date_added;  
		$this->data['filter_id']=$filter_id;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
		$this->template = 'projects/projects_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	} 
	public function approve() {
		$this->load->language('projects/projects');
		$this->load->language('mail/projects'); 
		if (!$this->user->hasPermission('modify', 'projects/projects')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['selected'])) {
				$this->load->model('projects/projects');	 
				foreach ($this->request->post['selected'] as $projects_id) {
					$projects_info = $this->model_projects_projects->getprojects($projects_id); 
					if ($projects_info && !$projects_info['approved']) {
						$this->model_projects_projects->approve($projects_id); 
						$this->load->model('setting/site'); 
						$site_info = $this->model_setting_site->getsite($projects_info['site_id']); 
						if ($site_info) {
							$site_name = $site_info['name'];
							$site_url = $site_info['url'] . 'index.php?route=account/login';
						} else {
							$site_name = $this->config->get('config_name');
							$site_url = $this->config->get('config_url') . 'index.php?route=account/login';
						} 
						$message  = sprintf($this->language->get('text_welcome'), $site_name) . "\n\n";;
						$message .= $this->language->get('text_login') . "\n";
						$message .= $site_url . "\n\n";
						$message .= $this->language->get('text_services') . "\n\n";
						$message .= $this->language->get('text_thanks') . "\n";
						$message .= $site_name; 
						$mail = new Mail();
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->hostname = $this->config->get('config_smtp_host');
						$mail->username = $this->config->get('config_smtp_username');
						$mail->password = $this->config->get('config_smtp_password');
						$mail->port = $this->config->get('config_smtp_port');
						$mail->timeout = $this->config->get('config_smtp_timeout');							
						$mail->setTo($projects_info['email']);
						$mail->setFrom($this->config->get('config_email'));
						$mail->setSender($site_name);
						$mail->setSubject(sprintf($this->language->get('text_subject'), $site_name));
						$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
						$mail->send(); 
						$this->session->data['success'] = sprintf($this->language->get('text_approved'), $projects_info['firstname'] . ' ' . $projects_info['lastname']);
					}
				}
			}			
		} 
		$url = ''; 
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}  
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}  
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
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
		$this->redirect(HTTPS_SERVER . 'index.php?route=projects/projects' . $url);
	}  
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'projects/projects')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	} 
	public function getForm(){
		//edit 
		$this->redirect(HTTPS_SERVER . 'index.php?route=projects/projects');
	}
	public function details() {
		 if (isset($this->request->get['id'])) {
			 $this->load->model('projects/projects'); 
      		$this->data['idea_info'] = $this->model_projects_projects->getIdea($this->request->get['id']);
			$this->template = 'projects/idea_details.tpl'; 
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    	} else {
			echo "wrong call to this window";
		}
  	} 
}
?>
