<?php  
class ControllerCommonColumnLeft extends Controller {
      protected function index() { 
            
            $this->language->load('common/column_left'); 
                        
            $this->data['current_url'] = COMPLETE_URL;
            $this->data['text_shortcuts'] = $this->language->get('text_shortcuts');
            $this->data['text_home'] = $this->language->get('text_home');
            $this->data['text_pos'] = $this->language->get('text_pos');
            $this->data['text_dashboard'] = $this->language->get('text_dashboard');
            $this->data['text_accounts'] = $this->language->get('text_accounts');
            $this->data['text_journal'] = $this->language->get('text_journal');
            $this->data['text_register'] = $this->language->get('text_register');
            $this->data['text_salesreps'] = $this->language->get('text_salesreps');
            $this->data['text_price_level'] = $this->language->get('text_price_level');
            $this->data['text_reports'] = $this->language->get('text_reports');
            $this->data['text_settings'] = $this->language->get('text_settings');
            $this->data['text_sms'] = $this->language->get('text_sms');
            $this->data['text_logout'] = $this->language->get('text_logout');
            
           
            $this->data['url_dashboard'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/home');
            $this->data['url_pos'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/pos');
            $this->data['url_reports'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/reports');
            $this->data['url_account'] = $this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=dashboard/account');
            $this->data['url_logout'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=dashboard/logout');
                                  
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/column_left.tpl')) {
                  $this->template = $this->config->get('config_template') . '/template/common/column_left.tpl';
            } else {
                  $this->template = 'default/template/common/column_left.tpl';
            } 
            $this->id = 'column_left'; 
            $this->render();
        }
}
?>