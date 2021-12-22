<?php
class ControllerAccountAccount extends Controller { 
	private $error = array(); 
	public function index() {
                
		$this->load->language('account/account'); 
		$this->document->title =$this->language->get('heading_title'); 
		$this->load->model('account/account'); 
		$this->getList();
	} 
	public function save_update() {
		$save_update_array = array();	
		$this->load->model('account/account'); 
                $this->load->language('account/account');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $data = $this->request->post;
                        if($data['acc_id']==0){
                            $this->model_account_account->addAccount($data); 
                            $save_update_array['message'] = $this->language->get('msg_success');
                        }
                        else{
                            $this->model_account_account->updateAccount($data); 
                            $save_update_array['message'] = $this->language->get('msg_update_success');
                        }
			
			$save_update_array['action'] = '1';
                        
		} 
                
                $this->load->library('json');
                $this->response->setOutput(Json::encode($save_update_array), $this->config->get('config_compression'));
		
	}
        
	public function delete() {
                $delete_array = array();	
		$this->load->language('account/account'); 
		$this->load->model('account/account'); 
		if (isset($this->request->post['selected'])) {
                    $id_array = explode(",",$this->request->post['selected']); 
                    foreach ( $id_array as $id) {
                            $this->model_account_account->deleteAccount($id);

                    } 
                    $delete_array['message'] = $this->language->get('msg_delete_success');
                    $this->load->library('json');
                    $this->response->setOutput(Json::encode($delete_array), $this->config->get('config_compression'));
		} 
		
	} 
	private function getList() {
		
		$this->data['save_update_url'] = HTTPS_SERVER . 'index.php?route=account/account/save_update';
		$this->data['delete_url'] = HTTPS_SERVER . 'index.php?route=account/account/delete';	 
                $this->data['url_add_group'] = HTTPS_SERVER . 'index.php?route=account/account/addgroup';
                $this->data['url_delete_group'] = HTTPS_SERVER . 'index.php?route=account/account/deletegroup';    
                $this->data['url_show_group'] = HTTPS_SERVER . 'index.php?route=account/account/groups';    
                
		$results = $this->model_account_account->getAccountTypes(); 
		foreach ($results as $result) {
			
			$this->data['account_types'][] = array(
				'acc_type_id' => $result['acc_type_id'],
				'name'      => $result['acc_type_name']
                                
			);
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_name'] = $this->language->get('column_name');
                $this->data['column_type'] = $this->language->get('column_type');
                $this->data['column_category'] = $this->language->get('column_category');
                $this->data['column_head'] = $this->language->get('column_head');
                $this->data['column_trail'] = $this->language->get('column_trail');
		$this->data['column_balance'] = $this->language->get('column_balance'); 
		$this->data['column_last_updated'] = $this->language->get('column_last_updated');
                
                $this->data['label_name'] = $this->language->get('label_name');
                $this->data['label_trail'] = $this->language->get('label_trail');
                $this->data['text_yes'] = $this->language->get('text_yes');
                $this->data['text_no'] = $this->language->get('text_no');
                $this->data['label_type'] = $this->language->get('label_type');
                $this->data['label_group'] = $this->language->get('label_group');
                $this->data['label_description'] = $this->language->get('label_description');
                $this->data['label_obalance'] = $this->language->get('label_obalance');
                $this->data['label_select_type'] = $this->language->get('label_select_type');
		
                $this->data['button_new'] = $this->language->get('button_insert'); 
                $this->data['button_edit'] = $this->language->get('button_edit'); 
                                
                $this->data['url_getaccountlist'] = HTTP_SERVER . 'index.php?route=account/account/getAccountList';
                
                $this->data['modal_title'] = $this->language->get('modal_title');
                $this->data['modal_title_delete'] = $this->language->get('modal_title_delete');
                $this->data['confirmation_delete'] = $this->language->get('confirmation_delete');
                $this->data['button_category_management'] = $this->language->get('button_category_management');
		$this->data['button_save'] = $this->language->get('button_save');
                $this->data['button_save_close'] = $this->language->get('button_save_close');
                $this->data['button_save_new'] = $this->language->get('button_save_new');
                $this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_cancel'] = $this->language->get('button_cancel'); 
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
		
		
		$this->template = 'account/account_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		); 
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
        public function getAccountList(){
            $this->load->model('account/account'); 
            $results = $this->model_account_account->getAccountList(); 
            $accounts_array = array();
             foreach ($results as $result) {
                 $res=str_replace("&amp;", '&', $result["acc_name"]); 
                 $name=str_replace("&quot;", '"', $res);
                   $accounts_array['accounts'][] = array(
                        'id' => $result['acc_id'],
                        'name'      => $name,
                        'category'       => $result['category_name'],
                        'intrail'       => $result['inTrail'],
                        'group_id'       => $result['acc_cat_id'],
                        'type'       => $result['acc_type_name'],
                        'head'       => $result['acc_head_title'],
                        'description' => $result['acc_description'],
                        'type_id' => $result['acc_type_id'],
                        'lastChange' => date($this->language->get('date_time_format'),strtotime($result['last_changed']))
                    );
                }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
        }
	
	public function groups(){
            $this->load->language('account/account'); 
            $this->load->model('account/account'); 
            $results = $this->model_account_account->getGroups(); 
            $groups_array = array();
            foreach ($results as $result) {
                $res=str_replace("&amp;", '&', $result["category_name"]); 
                 $name=str_replace("&quot;", '"', $res);
                   $groups_array['groups'][] = array(
                            'group_id' => $result['category_id'],
                            'group_name'      => $name,
                            'status'      => $result['isActive']==1 ?$this->language->get('text_enable'): $this->language->get('text_disable')
                    );
                }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($groups_array), $this->config->get('config_compression'));
        }
        public function addgroup(){
            $this->load->model('account/account');
            $groups_array = array();
            $data = $this->request->post;
            if(empty($data['id'])){
                $result = $this->model_account_account->addGroup($data); 
            }
            else{
                $result = $this->model_account_account->updateGroup($data); 
            }
            $groups_array['action'] = 'success';
            $this->load->library('json');
            $this->response->setOutput(Json::encode($groups_array), $this->config->get('config_compression'));
        }
        public function deletegroup(){
            $this->load->model('account/account'); 
            $groups_array = array();
            $data = $this->request->post;
            $result = $this->model_account_account->deleteGroup($data); 
            $groups_array['action'] = 'success';
            $this->load->library('json');
            $this->response->setOutput(Json::encode($groups_array), $this->config->get('config_compression'));
        }
}
?>