<?php
class ControllerSettingSetting extends Controller {
	private $error = array(); 
	public function index() { 
		$this->load->language('setting/setting');  
		$this->document->title = $this->language->get('heading_title'); 
		$this->load->model('setting/setting'); 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('config', $this->request->post); 
			if ($this->config->get('config_currency_auto')) {
				$this->load->model('localisation/currency'); 
				$this->model_localisation_currency->updateCurrencies();
			}	 
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->redirect(HTTPS_SERVER . 'index.php?route=setting/setting');
		} 
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_add_site'] = $this->language->get('text_add_site');
		$this->data['text_edit_site'] = $this->language->get('text_edit_site');
		$this->data['text_mail'] = $this->language->get('text_mail');
		$this->data['text_smtp'] = $this->language->get('text_smtp'); 
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_url'] = $this->language->get('entry_url');	
		$this->data['entry_owner'] = $this->language->get('entry_owner');
                $this->data['entry_store_description'] = $this->language->get('entry_store_description');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
                $this->data['entry_mobile_2'] = $this->language->get('entry_mobile_2');
                $this->data['entry_mobile'] = $this->language->get('entry_mobile');
		$this->data['entry_fax'] = $this->language->get('entry_fax');		
                $this->data['entry_receipt_title'] = $this->language->get('entry_receipt_title');
                $this->data['entry_thanks_note'] = $this->language->get('entry_thanks_note');
		$this->data['entry_pjc'] = $this->language->get('entry_pjc');		
		$this->data['entry_inc'] = $this->language->get('entry_inc');		
		$this->data['entry_pssmall'] = $this->language->get('entry_pssmall');		
		$this->data['entry_psmedium'] = $this->language->get('entry_psmedium');		
		$this->data['entry_pslarge'] = $this->language->get('entry_pslarge');		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
                $this->data['entry_meta_policy'] = $this->language->get('entry_meta_policy');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');		
		$this->data['entry_language'] = $this->language->get('entry_language');
                $this->data['entry_message'] = $this->language->get('entry_message');
		$this->data['entry_admin_language'] = $this->language->get('entry_admin_language');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_length_class'] = $this->language->get('entry_length_class');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_invoice'] = $this->language->get('entry_invoice');
		$this->data['entry_invoice_prefix'] = $this->language->get('entry_invoice_prefix');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_customer_price'] = $this->language->get('entry_customer_price');
		$this->data['entry_customer_approval'] = $this->language->get('entry_customer_approval');
		$this->data['entry_guest_checkout'] = $this->language->get('entry_guest_checkout');
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_checkout'] = $this->language->get('entry_checkout');
		$this->data['entry_stock_display'] = $this->language->get('entry_stock_display');
		$this->data['entry_stock_check'] = $this->language->get('entry_stock_check');
		$this->data['entry_stock_checkout'] = $this->language->get('entry_stock_checkout');
		$this->data['entry_stock_subtract'] = $this->language->get('entry_stock_subtract');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$this->data['entry_download'] = $this->language->get('entry_download');
		$this->data['entry_download_status'] = $this->language->get('entry_download_status');	
		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$this->data['entry_image_popup'] = $this->language->get('entry_image_popup');
		$this->data['entry_image_category'] = $this->language->get('entry_image_category');
		$this->data['entry_image_product'] = $this->language->get('entry_image_product');
		$this->data['entry_image_additional'] = $this->language->get('entry_image_additional');
		$this->data['entry_image_related'] = $this->language->get('entry_image_related');
		$this->data['entry_image_cart'] = $this->language->get('entry_image_cart');		
		$this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
		$this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$this->data['entry_alert_mail'] = $this->language->get('entry_alert_mail');
		$this->data['entry_ssl'] = $this->language->get('entry_ssl');
		$this->data['entry_encryption'] = $this->language->get('entry_encryption');
		$this->data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$this->data['entry_compression'] = $this->language->get('entry_compression');
		$this->data['entry_error_display'] = $this->language->get('entry_error_display');
		$this->data['entry_error_log'] = $this->language->get('entry_error_log');
		$this->data['entry_error_filename'] = $this->language->get('entry_error_filename');
		$this->data['entry_shipping_session'] = $this->language->get('entry_shipping_session');
		$this->data['entry_admin_limit'] = $this->language->get('entry_admin_limit');
		$this->data['entry_catalog_limit'] = $this->language->get('entry_catalog_limit');
		$this->data['entry_cart_weight'] = $this->language->get('entry_cart_weight'); 
		$this->data['entry_rewardpoints'] = $this->language->get('entry_rewardpoints');
		$this->data['entry_vcontactinfo'] = $this->language->get('entry_vcontactinfo');
		$this->data['entry_vlegals'] = $this->language->get('entry_vlegals');
		$this->data['entry_vhtouse'] = $this->language->get('entry_vhtouse');
		$this->data['entry_onevochour'] = $this->language->get('entry_onevochour');
                $this->data['entry_intial_points'] = $this->language->get('entry_intial_points');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_site'] = $this->language->get('button_add_site'); 
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_site'] = $this->language->get('tab_site');
		$this->data['tab_local'] = $this->language->get('tab_local');
		$this->data['tab_option'] = $this->language->get('tab_option');
		$this->data['tab_image'] = $this->language->get('tab_image');
		$this->data['tab_mail'] = $this->language->get('tab_mail');
		$this->data['tab_server'] = $this->language->get('tab_server'); 
		$this->data['tab_vcode'] = $this->language->get('tab_vcode'); 
		$this->data['tab_other'] = $this->language->get('tab_other');
                $this->data['tab_message'] = $this->language->get('tab_message');
                $this->data['tab_userKey'] = $this->language->get('tab_userKey');
                $this->data['tab_barcodeLabelDesign'] = $this->language->get('tab_barcodeLabelDesign');
                $this->data['barcode_label'] = $this->language->get('barcode_label');
                $this->data['text_large_print'] = $this->language->get('text_large_print');
                $this->data['text_small_print'] = $this->language->get('text_small_print');
                $this->data['text_eleven_digits'] = $this->language->get('text_eleven_digits');
                $this->data['text_five_digits'] = $this->language->get('text_five_digits');
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
 		if (isset($this->error['url'])) {
			$this->data['error_url'] = $this->error['url'];
		} else {
			$this->data['error_url'] = '';
		} 
 		if (isset($this->error['owner'])) {
			$this->data['error_owner'] = $this->error['owner'];
		} else {
			$this->data['error_owner'] = '';
		} 
 		if (isset($this->error['address'])) {
			$this->data['error_address'] = $this->error['address'];
		} else {
			$this->data['error_address'] = '';
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
 
  		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}
		
 		if (isset($this->error['image_thumb'])) {
			$this->data['error_image_thumb'] = $this->error['image_thumb'];
		} else {
			$this->data['error_image_thumb'] = '';
		}
		
 		if (isset($this->error['image_popup'])) {
			$this->data['error_image_popup'] = $this->error['image_popup'];
		} else {
			$this->data['error_image_popup'] = '';
		} 
		
		if (isset($this->error['error_filename'])) {
			$this->data['error_error_filename'] = $this->error['error_filename'];
		} else {
			$this->data['error_error_filename'] = '';
		}		
		
		if (isset($this->error['front_limit'])) {
			$this->data['error_front_limit'] = $this->error['front_limit'];
		} else {
			$this->data['error_front_limit'] = '';
		}
		
		if (isset($this->error['admin_limit'])) {
			$this->data['error_admin_limit'] = $this->error['admin_limit'];
		} else {
			$this->data['error_admin_limit'] = '';
		} 
                
                if (isset($this->error['admin_intial_points'])) {
			$this->data['error_intial_points'] = $this->error['admin_intial_points'];
		} else {
			$this->data['error_intial_points'] = '';
		} 
                
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success']; 
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		} 
		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=setting/site/insert'; 
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=setting/setting'; 
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=setting/setting'; 
		if (isset($this->request->post['config_name'])) {
			$this->data['config_name'] = $this->request->post['config_name'];
		} else {
			$this->data['config_name'] = $this->config->get('config_name');
		} 
		if (isset($this->request->post['config_url'])) {
			$this->data['config_url'] = $this->request->post['config_url'];
		} else {
			$this->data['config_url'] = $this->config->get('config_url');
		} 
		if (isset($this->request->post['config_owner'])) {
			$this->data['config_owner'] = $this->request->post['config_owner'];
		} else {
			$this->data['config_owner'] = $this->config->get('config_owner');
		} 
                
                if (isset($this->request->post['config_message'])) {
			$this->data['config_message'] = $this->request->post['config_message'];
		} else {
			$this->data['config_message'] = $this->config->get('config_message');
		}
                
                if (isset($this->request->post['api_username'])) {
			$this->data['api_username'] = $this->request->post['api_username'];
		} else {
			$this->data['api_username'] = $this->config->get('api_username');
		}
                
                if (isset($this->request->post['api_password'])) {
			$this->data['api_password'] = $this->request->post['api_password'];
		} else {
			$this->data['api_password'] = $this->config->get('api_password');
		}
                
                if (isset($this->request->post['masking'])) {
			$this->data['masking'] = $this->request->post['masking'];
		} else {
			$this->data['masking'] = $this->config->get('masking');
		}
//                if (isset($this->request->post['barcodeDesignJson'])) {
//			$this->data['barcodeDesignJson'] = $this->request->post['barcodeDesignJson'];
//		} else {
//			$this->data['barcodeDesignJson'] = $this->config->get('barcodeDesignJson');
//		}
                if (isset($this->request->post['userKey_barcodeLabel'])) {
			$this->data['userKey_barcodeLabel'] = $this->request->post['userKey_barcodeLabel'];
		} else {
			$this->data['userKey_barcodeLabel'] = $this->config->get('userKey_barcodeLabel');
		}
                if (isset($this->request->post['barcodeLabel'])) {
			$this->data['barcodeLabel'] = $this->request->post['barcodeLabel'];
		} else {
			$this->data['barcodeLabel'] = $this->config->get('barcodeLabel');
		}
                if (isset($this->request->post['label_design'])) {
			$this->data['label_design'] = $this->request->post['label_design'];
		} else {
			$this->data['label_design'] = $this->config->get('label_design');
		}
                
                if (isset($this->request->post['label_design_1'])) {
			$this->data['label_design_1'] = $this->request->post['label_design_1'];
		} else {
			$this->data['label_design_1'] = $this->config->get('label_design_1');
		}
                
                if (isset($this->request->post['label_design_2'])) {
			$this->data['label_design_2'] = $this->request->post['label_design_2'];
		} else {
			$this->data['label_design_2'] = $this->config->get('label_design_2');
		}
                
                if (isset($this->request->post['label_design_3'])) {
			$this->data['label_design_3'] = $this->request->post['label_design_3'];
		} else {
			$this->data['label_design_3'] = $this->config->get('label_design_3');
		}
                
                if (isset($this->request->post['label_design_4'])) {
			$this->data['label_design_4'] = $this->request->post['label_design_4'];
		} else {
			$this->data['label_design_4'] = $this->config->get('label_design_4');
		}
                if (isset($this->request->post['label_design_5'])) {
			$this->data['label_design_5'] = $this->request->post['label_design_5'];
		} else {
			$this->data['label_design_5'] = $this->config->get('label_design_5');
		}
		if (isset($this->request->post['config_address'])) {
			$this->data['config_address'] = $this->request->post['config_address'];
		} else {
			$this->data['config_address'] = $this->config->get('config_address');
		} 
		if (isset($this->request->post['config_email'])) {
			$this->data['config_email'] = $this->request->post['config_email'];
		} else {
			$this->data['config_email'] = $this->config->get('config_email');
		} 
		if (isset($this->request->post['config_telephone'])) {
			$this->data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$this->data['config_telephone'] = $this->config->get('config_telephone');
		} 
                if (isset($this->request->post['config_mobile'])) {
			$this->data['config_mobile'] = $this->request->post['config_mobile'];
		} else {
			$this->data['config_mobile'] = $this->config->get('config_mobile');
		}
                if (isset($this->request->post['config_mobile_2'])) {
			$this->data['config_mobile_2'] = $this->request->post['config_mobile_2'];
		} else {
			$this->data['config_mobile_2'] = $this->config->get('config_mobile_2');
		} 
		if (isset($this->request->post['config_fax'])) {
			$this->data['config_fax'] = $this->request->post['config_fax'];
		} else {
			$this->data['config_fax'] = $this->config->get('config_fax');
		} 
                if (isset($this->request->post['config_receipt_title'])) {
			$this->data['config_receipt_title'] = $this->request->post['config_receipt_title'];
		} else {
			$this->data['config_receipt_title'] = $this->config->get('config_receipt_title');
		}
                if (isset($this->request->post['config_thanks_note'])) {
			$this->data['config_thanks_note'] = $this->request->post['config_thanks_note'];
		} else {
			$this->data['config_thanks_note'] = $this->config->get('config_thanks_note');
		}
		if (isset($this->request->post['config_pjc'])) {
			$this->data['config_pjc'] = $this->request->post['config_pjc'];
		} else {
			$this->data['config_pjc'] = $this->config->get('config_pjc');
		} 
		if (isset($this->request->post['config_inc'])) {
			$this->data['config_inc'] = $this->request->post['config_inc'];
		} else {
			$this->data['config_inc'] = $this->config->get('config_inc');
		} 
		if (isset($this->request->post['config_pssmall'])) {
			$this->data['config_pssmall'] = $this->request->post['config_pssmall'];
		} else {
			$this->data['config_pssmall'] = $this->config->get('config_pssmall');
		} 
		if (isset($this->request->post['config_psmedium'])) {
			$this->data['config_psmedium'] = $this->request->post['config_psmedium'];
		} else {
			$this->data['config_psmedium'] = $this->config->get('config_psmedium');
		} 
		if (isset($this->request->post['config_pslarge'])) {
			$this->data['config_pslarge'] = $this->request->post['config_pslarge'];
		} else {
			$this->data['config_pslarge'] = $this->config->get('config_pslarge');
		} 
		if (isset($this->request->post['config_title'])) {
			$this->data['config_title'] = $this->request->post['config_title'];
		} else {
			$this->data['config_title'] = $this->config->get('config_title');
		} 
		if (isset($this->request->post['config_meta_description'])) {
			$this->data['config_meta_description'] = $this->request->post['config_meta_description'];
		} else {
			$this->data['config_meta_description'] = $this->config->get('config_meta_description');
		} 
                
                if (isset($this->request->post['config_meta_policy'])) {
			$this->data['config_meta_policy'] = $this->request->post['config_meta_policy'];
		} else {
			$this->data['config_meta_policy'] = $this->config->get('config_meta_policy');
		} 
                
                if (isset($this->request->post['config_store_description'])) {
			$this->data['config_store_description'] = $this->request->post['config_store_description'];
		} else {
			$this->data['config_store_description'] = $this->config->get('config_store_description');
		} 
		$this->data['templates'] = array(); 
		$directories = glob(DIR_CATALOG . 'themes/*', GLOB_ONLYDIR); //fix for the admin 
		foreach ($directories as $directory) {
			if(basename($directory)!="admin")
			$this->data['templates'][] = basename($directory);
		}	 
		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');			
		} 
		$this->load->model('localisation/language'); 
		$languages = $this->model_localisation_language->getLanguages(); 
		if (isset($this->request->post['config_refer_friend_message'])) {
			$this->data['config_refer_friend_message'] = $this->request->post['config_refer_friend_message'];
		} else {
			$this->data['config_refer_friend_message'] = $this->config->get('config_refer_friend_message');
		} 
		if (isset($this->request->post['config_country_id'])) {
			$this->data['config_country_id'] = $this->request->post['config_country_id'];
		} else {
			$this->data['config_country_id'] = $this->config->get('config_country_id');
		} 
		$this->load->model('localisation/country'); 
		$this->data['countries'] = $this->model_localisation_country->getCountries(); 
		if (isset($this->request->post['config_zone_id'])) {
			$this->data['config_zone_id'] = $this->request->post['config_zone_id'];
		} else {
			$this->data['config_zone_id'] = $this->config->get('config_zone_id');
		}	 
		if (isset($this->request->post['config_language'])) {
			$this->data['config_language'] = $this->request->post['config_language'];
		} else {
			$this->data['config_language'] = $this->config->get('config_language');
		} 
		if (isset($this->request->post['config_admin_language'])) {
			$this->data['config_admin_language'] = $this->request->post['config_admin_language'];
		} else {
			$this->data['config_admin_language'] = $this->config->get('config_admin_language');
		} 
		$this->data['languages'] = $this->model_localisation_language->getLanguages(); 
		if (isset($this->request->post['config_currency'])) {
			$this->data['config_currency'] = $this->request->post['config_currency'];
		} else {
			$this->data['config_currency'] = $this->config->get('config_currency');
		} 
		if (isset($this->request->post['config_currency_auto'])) {
			$this->data['config_currency_auto'] = $this->request->post['config_currency_auto'];
		} else {
			$this->data['config_currency_auto'] = $this->config->get('config_currency_auto');
		} 
		if (isset($this->request->post['config_jobpost_approval'])) {
			$this->data['config_jobpost_approval'] = $this->request->post['config_jobpost_approval'];
		} else {
			$this->data['config_jobpost_approval'] = $this->config->get('config_jobpost_approval');
		}  
		$this->load->model('localisation/currency'); 
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();  
		if (isset($this->request->post['config_tax'])) {
			$this->data['config_tax'] = $this->request->post['config_tax'];
		} else {
			$this->data['config_tax'] = $this->config->get('config_tax');			
		}
                
                if (isset($this->request->post['config_customreport'])) {
			$this->data['config_customreport'] = $this->request->post['config_customreport'];
		} else {
			$this->data['config_customreport'] = $this->config->get('config_customreport');			
		}
                
                if (isset($this->request->post['config_customregion'])) {
			$this->data['config_customregion'] = $this->request->post['config_customregion'];
		} else {
			$this->data['config_customregion'] = $this->config->get('config_customregion');			
		}

		                if (isset($this->request->post['config_warehouse'])) {
			$this->data['config_warehouse'] = $this->request->post['config_warehouse'];
		} else {
			$this->data['config_warehouse'] = $this->config->get('config_warehouse');			
		}

		      if (isset($this->request->post['config_uom'])) {
			$this->data['config_uom'] = $this->request->post['config_uom'];
		} else {
			$this->data['config_uom'] = $this->config->get('config_uom');			
		} 

		    if (isset($this->request->post['config_BonusQty'])) {
			$this->data['config_BonusQty'] = $this->request->post['config_BonusQty'];
		} else {
			$this->data['config_BonusQty'] = $this->config->get('config_BonusQty');			
		} 
		    if (isset($this->request->post['config_regTooltip'])) {
			$this->data['config_regTooltip'] = $this->request->post['config_regTooltip'];
		} else {
			$this->data['config_regTooltip'] = $this->config->get('config_regTooltip');			
		} 
		   if (isset($this->request->post['config_InvRegister'])) {
			$this->data['config_InvRegister'] = $this->request->post['config_InvRegister'];
		} else {
			$this->data['config_InvRegister'] = $this->config->get('config_InvRegister');			
		}

		  if (isset($this->request->post['config_Reqwarehouse'])) {
			$this->data['config_Reqwarehouse'] = $this->request->post['config_Reqwarehouse'];
		} else {
			$this->data['config_Reqwarehouse'] = $this->config->get('config_Reqwarehouse');			
		}
		
                 if (isset($this->request->post['config_averageQty'])) {
			$this->data['config_averageQty'] = $this->request->post['config_averageQty'];
		} else {
			$this->data['config_averageQty'] = $this->config->get('config_averageQty');			
		}
                
                if (isset($this->request->post['config_invoice_printer'])) {
			$this->data['config_invoice_printer'] = $this->request->post['config_invoice_printer'];
		} else {
			$this->data['config_invoice_printer'] = $this->config->get('config_invoice_printer');			
		}
                if (isset($this->request->post['config_barcdoe_digits'])) {
			$this->data['config_barcdoe_digits'] = $this->request->post['config_barcdoe_digits'];
		} else {
			$this->data['config_barcdoe_digits'] = $this->config->get('config_barcdoe_digits');			
		}
		if (isset($this->request->post['config_invoice_id'])) {
			$this->data['config_invoice_id'] = $this->request->post['config_invoice_id'];
		} else {
			$this->data['config_invoice_id'] = $this->config->get('config_invoice_id');			
		} 
		if (isset($this->request->post['config_invoice_prefix'])) {
			$this->data['config_invoice_prefix'] = $this->request->post['config_invoice_prefix'];
		} else {
			$this->data['config_invoice_prefix'] = $this->config->get('config_invoice_prefix');			
		}  
		if (isset($this->request->post['config_siteusers_approval'])) {
			$this->data['config_siteusers_approval'] = $this->request->post['config_siteusers_approval'];
		} else {
			$this->data['config_siteusers_approval'] = $this->config->get('config_siteusers_approval');			
		}  
		if (isset($this->request->post['config_account_id'])) {
			$this->data['config_account_id'] = $this->request->post['config_account_id'];
		} else {
			$this->data['config_account_id'] = $this->config->get('config_account_id');			
		} 
		if (isset($this->request->post['config_checkout_id'])) {
			$this->data['config_checkout_id'] = $this->request->post['config_checkout_id'];
		} else {
			$this->data['config_checkout_id'] = $this->config->get('config_checkout_id');		
		} 
		$this->load->model('cms/cms'); 
		//$this->data['cmss'] = $this->model_cms_cms->getcmsp(); 
		//$this->data['cmsblocks'] = $this->model_cms_cms->getBlocks();  
		if (isset($this->request->post['config_order_status_id'])) {
			$this->data['config_order_status_id'] = $this->request->post['config_order_status_id'];
		} else {
			$this->data['config_order_status_id'] = $this->config->get('config_order_status_id');		
		}
	    //blocks
		if (isset($this->request->post['config_homepagemessage'])) {
			$this->data['config_homepagemessage'] = $this->request->post['config_homepagemessage'];
		} else {
			$this->data['config_homepagemessage'] = $this->config->get('config_homepagemessage');
		}
		if (isset($this->request->post['config_footerfollowus'])) {
			$this->data['config_footerfollowus'] = $this->request->post['config_footerfollowus'];
		} else {
			$this->data['config_footerfollowus'] = $this->config->get('config_footerfollowus');
		} 
		//$this->load->model('localisation/order_status'); 
		$this->data['order_statuses'] = '';

		if (isset($this->request->post['config_stock_status_id'])) {
			$this->data['config_stock_status_id'] = $this->request->post['config_stock_status_id'];
		} else {
			$this->data['config_stock_status_id'] = $this->config->get('config_stock_status_id');			
		} 
		if (isset($this->request->post['config_shipping_session'])) {
			$this->data['config_shipping_session'] = $this->request->post['config_shipping_session'];
		} else {
			$this->data['config_shipping_session'] = $this->config->get('config_shipping_session');
		}
		
		if (isset($this->request->post['config_admin_limit'])) {
			$this->data['config_admin_limit'] = $this->request->post['config_admin_limit'];
		} else {
			$this->data['config_admin_limit'] = $this->config->get('config_admin_limit');
		}
		
		if (isset($this->request->post['config_front_limit'])) {
			$this->data['config_front_limit'] = $this->request->post['config_front_limit'];
		} else {
			$this->data['config_front_limit'] = $this->config->get('config_front_limit');
		}  
                
                if (isset($this->request->post['config_intial_point'])) {
			$this->data['config_intial_points'] = $this->request->post['config_intial_points'];
		} else {
			$this->data['config_intial_points'] = $this->config->get('config_intial_points');
		}  
                
		$this->load->model('tool/image'); 
		if (isset($this->request->post['config_logo'])) {
			$this->data['config_logo'] = $this->request->post['config_logo'];
		} else {
			$this->data['config_logo'] = $this->config->get('config_logo');			
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['preview_logo'] = HTTPS_IMAGE . $this->config->get('config_logo');		
		} else {
			$this->data['preview_logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['config_icon'])) {
			$this->data['config_icon'] = $this->request->post['config_icon'];
		} else {
			$this->data['config_icon'] = $this->config->get('config_icon');			
		}
		
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['preview_icon'] = HTTPS_IMAGE . $this->config->get('config_icon');		
		} else {
			$this->data['preview_icon'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['config_image_thumb_width'])) {
			$this->data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
		} else {
			$this->data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
		}
		
		if (isset($this->request->post['config_image_thumb_height'])) {
			$this->data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
		} else {
			$this->data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
		}
		
		if (isset($this->request->post['config_image_popup_width'])) {
			$this->data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
		} else {
			$this->data['config_image_popup_width'] = $this->config->get('config_image_popup_width');
		}
		
		if (isset($this->request->post['config_image_popup_height'])) {
			$this->data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
		} else {
			$this->data['config_image_popup_height'] = $this->config->get('config_image_popup_height');
		}  
		if (isset($this->request->post['config_mail_protocol'])) {
			$this->data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
		} else {
			$this->data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
		}
		
		if (isset($this->request->post['config_smtp_host'])) {
			$this->data['config_smtp_host'] = $this->request->post['config_smtp_host'];
		} else {
			$this->data['config_smtp_host'] = $this->config->get('config_smtp_host');
		}		

		if (isset($this->request->post['config_smtp_username'])) {
			$this->data['config_smtp_username'] = $this->request->post['config_smtp_username'];
		} else {
			$this->data['config_smtp_username'] = $this->config->get('config_smtp_username');
		}	
		
		if (isset($this->request->post['config_smtp_password'])) {
			$this->data['config_smtp_password'] = $this->request->post['config_smtp_password'];
		} else {
			$this->data['config_smtp_password'] = $this->config->get('config_smtp_password');
		}	
		
		if (isset($this->request->post['config_smtp_port'])) {
			$this->data['config_smtp_port'] = $this->request->post['config_smtp_port'];
		} elseif ($this->config->get('config_smtp_port')) {
			$this->data['config_smtp_port'] = $this->config->get('config_smtp_port');
		} else {
			$this->data['config_smtp_port'] = 25;
		}	
		
		if (isset($this->request->post['config_smtp_timeout'])) {
			$this->data['config_smtp_timeout'] = $this->request->post['config_smtp_timeout'];
		} elseif ($this->config->get('config_smtp_timeout')) {
			$this->data['config_smtp_timeout'] = $this->config->get('config_smtp_timeout');
		} else {
			$this->data['config_smtp_timeout'] = 5;	
		}	
		
		if (isset($this->request->post['config_alert_mail'])) {
			$this->data['config_alert_mail'] = $this->request->post['config_alert_mail'];
		} else {
			$this->data['config_alert_mail'] = $this->config->get('config_alert_mail');
		}
		
		if (isset($this->request->post['config_ssl'])) {
			$this->data['config_ssl'] = $this->request->post['config_ssl'];
		} else {
			$this->data['config_ssl'] = $this->config->get('config_ssl');
		}

		if (isset($this->request->post['config_encryption'])) {
			$this->data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$this->data['config_encryption'] = $this->config->get('config_encryption');
		}
		
		if (isset($this->request->post['config_seo_url'])) {
			$this->data['config_seo_url'] = $this->request->post['config_seo_url'];
		} else {
			$this->data['config_seo_url'] = $this->config->get('config_seo_url');
		}
		
		if (isset($this->request->post['config_compression'])) {
			$this->data['config_compression'] = $this->request->post['config_compression']; 
		} else {
			$this->data['config_compression'] = $this->config->get('config_compression');
		}

		if (isset($this->request->post['config_error_display'])) {
			$this->data['config_error_display'] = $this->request->post['config_error_display']; 
		} else {
			$this->data['config_error_display'] = $this->config->get('config_error_display');
		}

		if (isset($this->request->post['config_error_log'])) {
			$this->data['config_error_log'] = $this->request->post['config_error_log']; 
		} else {
			$this->data['config_error_log'] = $this->config->get('config_error_log');
		}

		if (isset($this->request->post['config_error_filename'])) {
			$this->data['config_error_filename'] = $this->request->post['config_error_filename']; 
		} else {
			$this->data['config_error_filename'] = $this->config->get('config_error_filename');
		}
		 
		$this->template = 'setting/setting.tpl';
		$this->children = array(
			'common/header',	
			'common/footer',
			'common/leftcol'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['config_name']) {
			$this->error['name'] = $this->language->get('error_name');
		}	
		
		if (!$this->request->post['config_url']) {
			$this->error['url'] = $this->language->get('error_url');
		}	
		
		if ((strlen(utf8_decode($this->request->post['config_owner'])) < 3) || (strlen(utf8_decode($this->request->post['config_owner'])) > 64)) {
			$this->error['owner'] = $this->language->get('error_owner');
		}

		if ((strlen(utf8_decode($this->request->post['config_address'])) < 3) || (strlen(utf8_decode($this->request->post['config_address'])) > 256)) {
			$this->error['address'] = $this->language->get('error_address');
		}

		if (!$this->request->post['config_title']) {
			$this->error['title'] = $this->language->get('error_title');
		}	
		
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

                if ((strlen(utf8_decode($this->request->post['config_email'])) > 32) || (!preg_match($pattern, $this->request->post['config_email']))) {
                        $this->error['email'] = $this->language->get('error_email');
                }

                /*if ((strlen(utf8_decode($this->request->post['config_telephone'])) < 3) || (strlen(utf8_decode($this->request->post['config_telephone'])) > 32)) {
                        $this->error['telephone'] = $this->language->get('error_telephone');
                }*/
                                

		if (!$this->request->post['config_image_thumb_width'] || !$this->request->post['config_image_thumb_height']) {
			$this->error['image_thumb'] = $this->language->get('error_image_thumb');
		}	 
		if (!$this->request->post['config_image_popup_width'] || !$this->request->post['config_image_popup_height']) {
			$this->error['image_popup'] = $this->language->get('error_image_popup');
		} 
		if (!$this->request->post['config_error_filename']) {
			$this->error['error_filename'] = $this->language->get('error_error_filename');
		}
		
		if (!$this->request->post['config_admin_limit']) {
			$this->error['admin_limit'] = $this->language->get('error_limit');
		}
                if (!$this->request->post['config_intial_points']) {
			$this->error['admin_intial_points'] = $this->language->get('error_intial_points');
		}
                
		if (!$this->request->post['config_front_limit']) {
			$this->error['front_limit'] = $this->language->get('error_limit');
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
	
	public function zone() {
		$output = ''; 
		$this->load->model('localisation/zone'); 
		$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
		
		foreach ($results as $result) {
			$output .= '<option value="' . $result['zone_id'] . '"';

			if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['name'] . '</option>';
		}

		if (!$results) {
			$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
		}

		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
	
	public function template() {
		$template = basename($this->request->get['template']);
		$nv=str_replace('/admin/','/', HTTPS_IMAGE);
		if (file_exists(DIR_IMAGE . 'templates/' . $template . '.png')) {
			$image = $nv . 'templates/' . $template . '.png';
		} else {
			$image = $nv . 'no_image.jpg';
		}
		
		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style=" width:300px; height:200px;border: 1px solid #EEEEEE;" />');
	}	
}
?>