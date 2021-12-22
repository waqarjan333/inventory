<?php
class ControllerFaqsFaqs extends Controller { 
	private $error = array(); 
	public function index() {
		$this->load->language('faqs/faqs'); 
		$this->document->title =$this->language->get('heading_title'); 
		$this->load->model('faqs/faqs'); 
		$this->getList();
	} 
	public function insert() {
		$this->load->language('faqs/faqs'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('faqs/faqs'); 
                
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                        if(isset($this->request->get['type']) && $this->request->get['type']=='question'){
                            
                            $this->model_faqs_faqs->addQuestionFaqs($this->request->post); 
                            $faq_id = $this->request->get['pid'];
                        }
                        else{
                            $faq_id=$this->model_faqs_faqs->addFaqs($this->request->post); 
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
                        
                        
                        $this->redirect(HTTPS_SERVER . 'index.php?route=faqs/faqs/update&faq_id=' . $faq_id . $url);
		} 
		$this->getForm();
	}

	public function update() {
		$this->load->language('faqs/faqs'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('faqs/faqs'); 
                
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                    if(isset($this->request->get['type']) && $this->request->get['type']=='question'){
                        $this->model_faqs_faqs->editQuestion($this->request->get['pid'],$this->request->get['q_id'], $this->request->post);
                    }
                    else{
			$this->model_faqs_faqs->editFaqs($this->request->get['faq_id'], $this->request->post); 
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
                        if(isset($this->request->get['type'])){
                            $this->redirect(HTTPS_SERVER . 'index.php?route=faqs/faqs/update&faq_id='.$this->request->get['pid'] . $url);
                        }
                        else{
			$this->redirect(HTTPS_SERVER . 'index.php?route=faqs/faqs' . $url);
                        }
                        
		} 
		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('faqs/faqs'); 
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('faqs/faqs'); 
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
                    if(isset($this->request->get['pid'])){
			foreach ($this->request->post['selected'] as $faq_id) {
                              
				$this->model_faqs_faqs->deleteQuestions($faq_id);
			} 
                    }
                    else{
                        foreach ($this->request->post['selected'] as $faq_id) {
                              
				$this->model_faqs_faqs->deleteFaqs($faq_id);
			} 
                        
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
                        if(isset($this->request->get['pid'])){
                            $this->redirect(HTTPS_SERVER . 'index.php?route=faqs/faqs/update&faq_id='. $this->request->get['pid'] . $url);
                        }
                        else{
                            $this->redirect(HTTPS_SERVER . 'index.php?route=faqs/faqs' . $url);
                        }
		} 
		$this->getList();
	} 
	private function getList() {
		$this->makeList();
		$this->template = 'faqs/faqs_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
        private function makeList(){
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
		
		$this->data['faqs'] = array(); 
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		); 
                $type = '';
                if(isset($this->request->get['faq_id'])){
                    $type = 'question';
                    $this->data['showquestions'] = 1;
                    $faq_id = $this->request->get['faq_id'];
                    $faqs_total = $this->model_faqs_faqs->getTotalQuestions($faq_id); 
                    $results = $this->model_faqs_faqs->getQuestionsp($data,$faq_id); 
                        
                    foreach ($results as $result) {
                            $action = array(); 
                            $action[] = array(
                                    'text' => $this->language->get('text_edit'),
                                    'href' => HTTPS_SERVER . 'index.php?route=faqs/faqs/update&type=question&pid='.$faq_id.'&q_id=' . $result['q_id'] . $url
                            ); 	
                            $this->data['resultfaqs'][] = array(
                                    'faq_id' => $result['q_id'],
                                    'title'      => $result['question'],
                                    'sort_order' => $result['q_sort'],
                                    'fc_status'    => $result['q_status'],
                                    'selected'   => isset($this->request->post['selected']) && in_array($result['q_id'], $this->request->post['selected']),
                                    'action'     => $action
                            );

                    } 
                    $this->data['insert'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/insert&type=question&pid='.$faq_id . $url;
                    $this->data['delete'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/delete&pid='.$faq_id . $url;
                    
                    
                }
                else{
                    $faqs_total = $this->model_faqs_faqs->getTotalFaqs(); 
                    $results = $this->model_faqs_faqs->getFaqsp($data); 

                    foreach ($results as $result) {
                            $action = array(); 
                            $action[] = array(
                                    'text' => $this->language->get('text_edit'),
                                    'href' => HTTPS_SERVER . 'index.php?route=faqs/faqs/update&faq_id=' . $result['faq_id'] . $url
                            ); 	
                            $this->data['resultfaqs'][] = array(
                                    'faq_id' => $result['faq_id'],
                                    'title'      => $result['name'],
                                    'sort_order' => $result['sort_order'],
                                    'fc_status'    => $result['status'],
                                    'selected'   => isset($this->request->post['selected']) && in_array($result['faq_id'], $this->request->post['selected']),
                                    'action'     => $action
                            );

                    } 
                    $this->data['insert'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/insert' . $url;
                    $this->data['delete'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/delete' . $url;	 
                }
                
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
                if($type==''){
		$this->data['column_title'] = $this->language->get('column_title');
                }
                else{
                    $this->data['column_title'] = $this->language->get('column_question');
                }
                $this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_type'] = $this->language->get('column_type'); 
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
                $this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action'); 
                $this->data['column_sort_order'] = $this->language->get('column_sort_order'); 
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete'); 
		$this->data['tab_general'] = $this->language->get('tab_general'); 
		$this->data['tab_data'] = $this->language->get('tab_data'); 
                $this->data['button_insert_question'] = $this->language->get('button_insert_question');
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
		$this->data['sort_title'] = HTTPS_SERVER . 'index.php?route=faqs/faqs&sort=cd.title' . $url;
		$this->data['sort_sort_order'] = HTTPS_SERVER . 'index.php?route=faqs/faqs&sort=c.sort_order' . $url; 
		$url = ''; 
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} 								
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} 
		$pagination = new Pagination();
		$pagination->total = $faqs_total;
		$pagination->page = $page;
		$pagination->limit = 20;  //FIX ME FOR AMDIN PANELED SER $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=faqs/faqs' . $url . '&page={page}'; 
		$this->data['pagination'] = $pagination->render(); 
		$this->data['sort'] = $sort;
		$this->data['order'] = $order; 
        }
	private function getForm() {
                $typeparameter = '';
                if(isset($this->request->get['type'])){
                    $this->data['type'] = $this->request->get['type'];
                    $typeparameter = '&type='.$this->data['type'].'&pid='.$this->request->get['pid'];
                }
                else{
                    $this->data['type'] = 'topic';
                }
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
                $this->data['entry_industry'] = $this->language->get('entry_industry'); 
                $this->data['entry_question'] = $this->language->get('entry_question'); 
                $this->data['entry_answer'] = $this->language->get('entry_answer'); 
                $this->data['entry_topic'] = $this->language->get('entry_topic'); 
                $this->data['text_none'] = $this->language->get('text_none');
		$this->data['button_save'] = $this->language->get('button_save');
                
		$this->data['button_cancel'] = $this->language->get('button_cancel'); 
                $this->load->model('common/common'); 
		$results = $this->model_common_common->getIndustries();
                $topics = $this->model_faqs_faqs->getAlltopics();
                
                foreach ($topics as $topic){
                     $this->data['topics'][] = array(
                        'faq_id' => $topic['faq_id'],
                        'topic_name' => $topic['name']
                       
                       );
                }
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
	 	if (isset($this->error['answer'])) {
			$this->data['error_answer'] = $this->error['answer'];
		} else {
			$this->data['error_answer'] = '';
		}  
                if (isset($this->error['question'])) {
			$this->data['error_question'] = $this->error['question'];
		} else {
			$this->data['error_question'] = '';
		}  
                if (isset($this->error['topic'])) {
			$this->data['error_topic'] = $this->error['topic'];
		} else {
			$this->data['error_topic'] = '';
		}  
		$this->document->breadcrumbs = array(); 
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=faqs/faqs',
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
		
                if($typeparameter==''){
                    if (!isset($this->request->get['faq_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/insert' .$typeparameter. $url;
                    } else {
                            $this->data['action'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/update'.$typeparameter.'&faq_id=' . $this->request->get['faq_id'] . $url;
                    } 
                    $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=faqs/faqs' . $url; 
                }
                else{
                    if (!isset($this->request->get['q_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/insert' .$typeparameter. $url;
                    } else {
                            $this->data['action'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/update'.$typeparameter.'&q_id=' . $this->request->get['q_id'] . $url;
                    } 
                    $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=faqs/faqs/update&faq_id='. $this->request->get['pid']. $url; 
                }
                
                $this->load->model('localisation/language'); 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
                
		
                if(isset($this->request->get['pid']) && isset($this->request->get['q_id']) &&  ($this->request->server['REQUEST_METHOD'] != 'POST')){
                        $faqs_info = $this->model_faqs_faqs->getQuestion($this->request->get['pid'],$this->request->get['q_id']);
                        if (isset($this->request->post['faq_description'])) {
                            $this->data['faq_description'] = $this->request->post['faq_description'];
                        } elseif (isset($this->request->get['q_id'])) {
                                $this->data['faq_description'][$this->config->get('config_language_id')]['question'] = $faqs_info['question'];
                                $this->data['faq_description'][$this->config->get('config_language_id')]['answer'] = $faqs_info['answer'];
                        } else {
                                $this->data['faq_description'] = array();
                        } 

                        if (isset($this->request->post['fs_status'])) {
                                $this->data['fc_status'] = $this->request->post['fc_status'];
                        } elseif (isset($faqs_info)) {
                                $this->data['fc_status'] = $faqs_info['q_status'];
                        } else {
                                $this->data['fc_status'] = 1;
                        } 

                

                        if (isset($this->request->post['keyword'])) {
                                $this->data['keyword'] = $this->request->post['keyword'];
                        } elseif (isset($faqs_info)) {
                                $this->data['keyword'] = $faqs_info['q_seo'];
                        } else {
                                $this->data['keyword'] = '';
                        } 


                        if (isset($this->request->post['sort_order'])) {
                                $this->data['sort_order'] = $this->request->post['sort_order'];
                        } elseif (isset($faqs_info)) {
                                $this->data['sort_order'] = $faqs_info['q_sort'];
                        } else {
                                $this->data['sort_order'] = '';
                        } 
                }
                else{
                    if (isset($this->request->get['faq_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$faqs_info = $this->model_faqs_faqs->getFaqs($this->request->get['faq_id']);
                        
		} 
		if (isset($this->request->post['faq_description'])) {
			$this->data['faq_description'] = $this->request->post['faq_description'];
                        } elseif (isset($this->request->get['faq_id'])) {
                                $this->data['faq_description'] = $this->model_faqs_faqs->getFaqsDescriptions($this->request->get['faq_id']);
                        } else {
                                $this->data['faq_description'] = array();
                        } 

                        if (isset($this->request->post['fs_status'])) {
                                $this->data['fc_status'] = $this->request->post['fc_status'];
                        } elseif (isset($faqs_info)) {
                                $this->data['fc_status'] = $faqs_info['status'];
                        } else {
                                $this->data['fc_status'] = 1;
                        } 

                        if (isset($this->request->post['fc_faq_id'])) {
                                $this->data['fc_faq_id'] = $this->request->post['fc_faq_id'];
                        } elseif (isset($faqs_info)) {
                                $this->data['fc_faq_id'] = $faqs_info['category_id'];
                        } else {
                                $this->data['fc_faq_id'] = 0;
                        } 

                        if (isset($this->request->post['keyword'])) {
                                $this->data['keyword'] = $this->request->post['keyword'];
                        } elseif (isset($faqs_info)) {
                                $this->data['keyword'] = $faqs_info['seo_keywords'];
                        } else {
                                $this->data['keyword'] = '';
                        } 
                        
                           if (isset($this->request->post['sort_order'])) {
                                $this->data['sort_order'] = $this->request->post['sort_order'];
                        } elseif (isset($faqs_info)) {
                                $this->data['sort_order'] = $faqs_info['sort_order'];
                        } else {
                                $this->data['sort_order'] = '';
                        } 

                }
                     
		
                foreach ($results as $result) {
                    $this->data['industries'][] = array(
                                    'ind_id' => $result['category_id'],
                                    'title'      => $result['title']
                                    
                            );
                }
		if($typeparameter=='' && isset($this->request->get['faq_id'])){
                    $this->makeList();
                }
		$this->template = 'faqs/faqs_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	} 
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'faqs/faqs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
                $type = $this->request->get['type'];
                if($type=='question'){
                    foreach ($this->request->post['faq_description'] as $language_id => $value) {
                            if (strlen(utf8_decode(trim($value['question']))) ==0) {
                                    $this->error['question'][$language_id] = $this->language->get('error_question');
                            }
                            
                            if (strlen(utf8_decode(trim($value['answer']))) ==0 ) {
                                    $this->error['answer'][$language_id] = $this->language->get('error_answer');
                            }
                    }    
                   
                }
                else{
                    foreach ($this->request->post['faq_description'] as $language_id => $value) {
                            if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 32)) {
                                    $this->error['title'][$language_id] = $this->language->get('error_title');
                            }


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
		if (!$this->user->hasPermission('modify', 'faqs/faqs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}  
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
        private function getQuestions($id){
            $questions = array();
            $results = $this->model_faqs_faqs->getQuestionsp($id);
            foreach($results as $result){
                $questions[] = array(
                    'question_id' => $result['q_id'],
                    'parent_id' => $result['parent_id'],
                    'question' => $result['question'],
                    'q_status' => $result['q_status']
                   );
            }
            return $quesitons;
        }
}
?>