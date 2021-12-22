<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		$this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'), $this->config->get('config_name'), date('Y', time())); 
		$this->id = 'footer'; 
                $this->data['print'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/print'); 
                $this->data['print_register'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/print/printRegister');
                $this->data['print_register_payment'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/print/printRegisterPayment');
                $this->data['printlist'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/print/printList'); 
                $this->data['print_journal'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=common/print/printJournal'); 
                $this->data['create_pdf'] = HTTP_SERVER . 'vendor/pdf_form.php'; 
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		} 
		if ($this->config->get('google_analytics_status')) {
			$this->data['google_analytics'] = html_entity_decode($this->config->get('google_analytics_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['google_analytics'] = '';
		} 
		$this->render();
	}
}
?>