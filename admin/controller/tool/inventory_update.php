<?php 
class ControllerToolInventoryUpdate extends Controller { 
	private $error = array();
			
	public function index() {		
		$this->load->language('tool/inventory_update');
		$this->document->title = $this->language->get('heading_title');
		$this->load->model('tool/inventory_update');
		$this->load->model('setting/setting');		
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {	
		
		  	$this->model_setting_setting->editSetting('inventory_update', $this->request->post);		
	
		if (isset($this->request->post['id_field'])) {
		 if ($this->ValidateFormFile()) {
		 					//Select case to reference the product to be updated
							switch ($this->request->post['id_field'])
							{
							case "model":
							$column = "model";
							break;
							case "sku":
							$column = "sku";
							} 
			 
		 					//Create an array of file content
		 		$file_content = explode("\n",(file_get_contents($this->request->files['import']['tmp_name'])));
		    $this->data['error_filedata['su_id']] = '';
				
				$error_reference = $this->language->get('error_reference');
				$error_quantity = $this->language->get('error_quantity');
				$error_recordnotfound = $this->language->get('error_recordnotfound');
				$error_failedvalidation = $this->language->get('error_failedvalidation');
				$error_fieldcount = $this->language->get('error_fieldcount');								
								
				$recordsUpdated = 0;
							//Create second dimension to hold items using defined delimiter on lines that have data
	     	foreach ($file_content as $key => $value)	{					
					   if (trim(strlen($value)) > 1) {
						 		$line_records = explode(',', $value);
									
	 		 					if (count($line_records) != 2) {
		 		 						 $this->data['error_filedata['su_id']].= $error_fieldcount. $value."<br />";
	 		 					} else {
								 				$reference = trim($line_records[0]);      
												$quantity = trim($line_records[1]);
										 if ($this->ValidateFileData($quantity)) {  
										 
 	  									  if ($this->model_tool_inventory_update->inventory_update($column,$reference,$quantity)) {
												$recordsUpdated ++;
												} else {
												$this->data['error_filedata['su_id']].= $error_recordnotfound.$error_reference.$reference.$error_quantity.$quantity."<br />";
												}
											} else {
  	 		 		 						$this->data['error_filedata['su_id']].= $error_failedvalidation.$error_reference.$reference.$error_quantity.$quantity."<br />";
											}	 
									}
			 					}	
					
						 }	
	
		$this->session->data['success'] = $this->language->get('text_success');
		} else { 
		$this->data['error_file']= $this->language->get('error_file');
		}
		} else {
		$this->data['error_id_field'] = $this->language->get('error_id_field');
		}
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_file'] = $this->language->get('entry_file');
		$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['text_howto'] = $this->language->get('text_howto');
		$this->data['text_id_field'] = $this->language->get('text_id_field');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['tab_general'] = $this->language->get('tab_general');
		
		if (isset($this->request->post['id_field'])) {
			$this->data['id_field'] = $this->request->post['id_field'];
		} else {
			 $this->data['id_field'] = $this->config->get('id_field');
		}	
						
  	if (isset($this->data['error_filedata['su_id']])) {
      $this->data['error_filedata['su_id']] = $this->language->get('error_filedata['su_id']).$this->data['error_filedata['su_id']];
   	}		
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $recordsUpdated.$this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
  		$this->document->breadcrumbs = array();
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=tool/inventory_update',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=tool/inventory_update';
			
	  $this->template = 'tool/inventory_update.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/inventory_update')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
	
	private function ValidateFormFile() { 
		 if (($this->request->files['import']) && ($this->request->files['import']['error']==0)) {
			 		 $filename = basename($this->request->files['import']['name']);
           $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "csv") && ($this->request->files['import']['size'] < 100000)) {
        return file_get_contents($this->request->files['import']['tmp_name']);
				} else {
				return FALSE;
				}
		} else {
		return FALSE;		
	  }
	}
	
 
  private function ValidateFileData ($value) {
						if (strlen($value)<1 || strlen($value)>4) {
						return false;
						} else if (!eregi('^[0-9]+$', $value)) {
				    return false;
				    } else {
						return true;
						}				  
 }				
} 
?>