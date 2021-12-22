<?php  
class ControllerCommonPrint extends Controller {
    public function index() { 
            $this->language->load('common/print'); 
            
            $this->data['site_logo'] = HTTP_SERVER."images/" . $this->config->get('config_logo');
            
            $this->data['lang'] = $this->language->get('code');
            $this->data['direction'] = $this->language->get('direction');
            
            $this->data['text_invoice'] = $this->language->get('text_invoice'); 
            $this->data['text_telephone'] = $this->language->get('text_telephone'); 
            $this->data['text_mobile'] = $this->language->get('text_mobile'); 
            $this->data['text_mobile2'] = $this->language->get('text_mobile2'); 
            
            $this->data['text_invoice_date'] = $this->language->get('text_invoice_date'); 
            $this->data['text_printed_date'] = $this->language->get('text_printed_date'); 
            $this->data['text_invoice_no'] = $this->language->get('text_invoice_no'); 
            
            $this->data['text_bill_to'] = $this->language->get('text_bill_to');
            $this->data['text_cust_mobile'] = $this->language->get('text_mobile'); 
            $this->data['text_cust_address'] = $this->language->get('text_cust_address');
            $this->data['text_region'] = $this->language->get('text_region'); 
            $this->data['text_warehouse'] = $this->language->get('text_warehouse'); 
            $this->data['text_salesrep'] = $this->language->get('text_salesrep'); 
            $this->data['text_s_no'] = $this->language->get('text_s_no'); 
            $this->data['text_description'] = $this->language->get('text_description');
            $this->data['text_uom'] = $this->language->get('text_uom');
            $this->data['text_net'] = $this->language->get('text_net');
            $this->data['text_qty'] = $this->language->get('text_qty');             
            $this->data['text_rate'] = $this->language->get('text_rate'); 
            $this->data['text_discount'] = $this->language->get('text_discount'); 
            $this->data['text_weight'] = $this->language->get('text_weight'); 
            $this->data['text_amount'] = $this->language->get('text_amount'); 
            $this->data['text_rs'] = $this->language->get('text_rs'); 
            
            
            $this->data['text_total_qty'] = $this->language->get('text_total_qty'); 
            $this->data['text_sub_total'] = $this->language->get('text_sub_total'); 
            $this->data['text_discount'] = $this->language->get('text_discount'); 
            $this->data['text_paid'] = $this->language->get('text_paid'); 
            $this->data['text_balance'] = $this->language->get('text_balance'); 
            $this->data['text_total'] = $this->language->get('text_total');             
            $this->data['text_pre_balance'] = $this->language->get('text_pre_balance'); 
            $this->data['text_grand_total'] = $this->language->get('text_grand_total');             
            $this->data['text_footer'] = $this->language->get('text_footer');
            
            $this->data['terms_condition_heading'] = $this->language->get('terms_condition_heading'); 
            $this->data['terms_condition_text'] = $this->language->get('terms_condition_text'); 
                        
            $this->template = $this->config->get('config_template') . '/template/common/print.tpl';                                  
            $this->children = array();
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
            
    } 
        
        public function printList() { 
            
            $this->data['site_logo'] = HTTP_SERVER."images/" . $this->config->get('config_logo');               
            $this->template = $this->config->get('config_template') . '/template/common/print_list.tpl';                                  
            $this->children = array();
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
            
    } 
        
          public function printRegister() { 
            
            $this->data['site_logo'] = HTTP_SERVER."images/" . $this->config->get('config_logo');
               
            $this->template = $this->config->get('config_template') . '/template/common/print_register.tpl';                                  
            $this->children = array();
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
            
    } 
        
        public function printRegisterPayment() { 
            
            $this->data['site_logo'] = HTTP_SERVER."images/" . $this->config->get('config_logo');
               
            $this->template = $this->config->get('config_template') . '/template/common/print_register_payment.tpl';                                  
            $this->children = array();
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
            
    } 
         public function printJournal() { 
            
            $this->data['site_logo'] = HTTP_SERVER."images/" . $this->config->get('config_logo');
               
            $this->template = $this->config->get('config_template') . '/template/common/print_journal.tpl';                                  
            $this->children = array();
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));  
            
    }
}
?>
