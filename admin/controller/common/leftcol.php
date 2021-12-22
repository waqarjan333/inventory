<?php 
class ControllerCommonLeftcol extends Controller {
	protected function index() {
		$this->load->language('common/leftcol');  
		$this->data['home'] = HTTPS_SERVER . 'index.php?route=common/home';
		$this->data['text_dashboard'] = $this->language->get('text_dashboard');
		$this->data['text_front'] = $this->language->get('text_front');
		$this->data['text_logout'] = $this->language->get('text_logout');
		//projects
		$this->data['text_projectcat'] = $this->language->get('text_projectcat');
		$this->data['industries'] = HTTPS_SERVER . 'index.php?route=projects/category';
		$this->data['text_projects'] = $this->language->get('text_projects'); 
		$this->data['projects'] = HTTPS_SERVER . 'index.php?route=projects/projects';  
		$this->data['text_packages'] = $this->language->get('text_packages');
		$this->data['packages'] = HTTPS_SERVER . 'index.php?route=packages/packages'; 
                
		// cms
		$this->data['text_cmsblocks'] = $this->language->get('text_cmsblocks');
		$this->data['text_cms'] = $this->language->get('text_cms');
		$this->data['text_cmstype'] = $this->language->get('text_cmstype');
		$this->data['text_cmsmenu'] = $this->language->get('text_cmsmenu'); 
		$this->data['text_testimonial'] = $this->language->get('text_testimonial'); 
		$this->data['text_homeslider'] = $this->language->get('text_homeslider');
		$this->data['homeslider'] = HTTPS_SERVER . 'index.php?route=cms/homeslider'; 
		$this->data['testimonial'] = HTTPS_SERVER . 'index.php?route=cms/testimonial';
		$this->data['cmsblocks'] = HTTPS_SERVER . 'index.php?route=cms/block';
		$this->data['cms'] = HTTPS_SERVER . 'index.php?route=cms/cms'; 
		$this->data['cmsmenu'] = HTTPS_SERVER . 'index.php?route=cms/menusetting'; 
         //news management 
		$this->data['text_news'] = $this->language->get('text_news');  
		$this->data['news'] = HTTPS_SERVER . 'index.php?route=news/news'; 
        //faqs management 
		$this->data['text_faqs'] = $this->language->get('text_faqs');  
		$this->data['faqs'] = HTTPS_SERVER . 'index.php?route=faqs/faqs'; 
		//forum management 
		$this->data['text_forumtopic'] = 'Topics';  
		$this->data['forumtopic'] = HTTPS_SERVER . 'index.php?route=forum/topics';
		$this->data['text_forum'] = 'Forum';  
		$this->data['forum'] = HTTPS_SERVER . 'index.php?route=forum/forum'; 
		//user management
		$this->data['text_users'] = $this->language->get('text_users');
		$this->data['text_user'] = $this->language->get('text_user');
		$this->data['text_user_group'] = $this->language->get('text_user_group'); 
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['user'] = HTTPS_SERVER . 'index.php?route=user/user';
      	$this->data['user_group'] = HTTPS_SERVER . 'index.php?route=user/user_permission'; 
		$this->data['order'] = HTTPS_SERVER . 'index.php?route=sale/order';
		$this->data['contact'] = HTTPS_SERVER . 'index.php?route=sale/contact'; 
		//localization 
		$this->data['text_localisation'] = $this->language->get('text_localisation');
		$this->data['text_language'] = $this->language->get('text_language');
		$this->data['text_tax_class'] = $this->language->get('text_tax_class');
		$this->data['text_weight_class'] = $this->language->get('text_weight_class');
		$this->data['text_length_class'] = $this->language->get('text_length_class'); 
      	$this->data['text_zone'] = $this->language->get('text_zone');
		$this->data['text_country'] = $this->language->get('text_country');
		$this->data['text_coupon'] = $this->language->get('text_coupon');
		$this->data['text_currency'] = $this->language->get('text_currency');
		$this->data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$this->data['country'] = HTTPS_SERVER . 'index.php?route=localisation/country';
		$this->data['currency'] = HTTPS_SERVER . 'index.php?route=localisation/currency';
		$this->data['geo_zone'] = HTTPS_SERVER . 'index.php?route=localisation/geo_zone';
		$this->data['language'] = HTTPS_SERVER . 'index.php?route=localisation/language';
		$this->data['order_status'] = HTTPS_SERVER . 'index.php?route=localisation/order_status';
		$this->data['stock_status'] = HTTPS_SERVER . 'index.php?route=localisation/stock_status';
      	$this->data['tax_class'] = HTTPS_SERVER . 'index.php?route=localisation/tax_class';
		$this->data['weight_class'] = HTTPS_SERVER . 'index.php?route=localisation/weight_class';
		$this->data['length_class'] = HTTPS_SERVER . 'index.php?route=localisation/length_class';
      	$this->data['zone'] = HTTPS_SERVER . 'index.php?route=localisation/zone';
		
		//system setting 
		$this->data['text_setting'] = $this->language->get('text_setting');
		$this->data['text_system'] = $this->language->get('text_system');
		$this->data['text_backup'] = $this->language->get('text_backup');
		$this->data['text_export'] = $this->language->get('text_export');
		$this->data['text_error_log'] = $this->language->get('text_error_log');
		$this->data['setting'] = HTTPS_SERVER . 'index.php?route=setting/setting';
		$this->data['backup'] = HTTPS_SERVER . 'index.php?route=tool/backup';
		$this->data['export'] = HTTPS_SERVER . 'index.php?route=tool/export'; 
		$this->data['error_log'] = HTTPS_SERVER . 'index.php?route=tool/error_log'; 
		//modules
		$this->data['text_extension'] = $this->language->get('text_extension');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_status'] = $this->language->get('text_order_status');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_shipping'] = $this->language->get('text_shipping'); 
		$this->data['text_stock_status'] = $this->language->get('text_stock_status'); 
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['module'] = HTTPS_SERVER . 'index.php?route=extension/module';
		$this->data['payment'] = HTTPS_SERVER . 'index.php?route=extension/payment'; 
		$this->data['total'] = HTTPS_SERVER . 'index.php?route=extension/total'; 
		// feeds  
		$this->data['text_feed'] = $this->language->get('text_feed');
		$this->data['feed'] = HTTPS_SERVER . 'index.php?route=extension/feed'; 
		 
		//Reports
		$this->data['text_reports'] = $this->language->get('text_reports');
		$this->data['text_report_purchased'] = $this->language->get('text_report_purchased');     		
		$this->data['text_report_sale'] = $this->language->get('text_report_sale');
      	$this->data['text_report_viewed'] = $this->language->get('text_report_viewed');
		$this->data['report_purchased'] = HTTPS_SERVER . 'index.php?route=report/purchased';
		$this->data['report_sale'] = HTTPS_SERVER . 'index.php?route=report/sale';
      	$this->data['report_viewed'] = HTTPS_SERVER . 'index.php?route=report/viewed'; 
		//help management
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['txt_helps']='Help'; 
		$this->data['helps'] = HTTPS_SERVER . 'doc/help'; 
		//faq
		$this->data['text_faq'] = $this->language->get('text_faq');
		$this->data['faq'] = HTTPS_SERVER . 'index.php?route=cms/faq'; 
		//logout
		$this->data['logout'] = HTTPS_SERVER . 'index.php?route=common/logout'; 
		
		$this->id       = 'left_col';
		$this->template = 'common/leftcol.tpl'; 
		$this->render();
	}
}
?>