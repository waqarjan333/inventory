<?php
class ControllerAccountLedger extends Controller { 
	private $error = array(); 
	public function index() {
             
		$this->load->language('account/ledger'); 
		$this->document->title =$this->language->get('heading_title'); 
		$this->load->model('account/ledger'); 
		$this->getList();
	} 
	
      
	private function getList() {
		
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['text_no_results'] = $this->language->get('text_no_results'); 
		$this->data['column_ledger'] = $this->language->get('column_ledger');
                $this->data['column_type'] = $this->language->get('column_type');
                $this->data['column_debit'] = $this->language->get('column_debit');
                $this->data['column_credit'] = $this->language->get('column_credit');
                $this->data['column_date'] = $this->language->get('column_date');
                $this->data['column_rate'] = $this->language->get('column_rate');
                $this->data['column_orgional_amount'] = $this->language->get('column_orgional_amount');
                $this->data['column_particular'] = $this->language->get('column_particular');
                $this->data['column_balance'] = $this->language->get('column_balance');
                $this->data['column_regid'] = $this->language->get('column_regid');
                
                $this->data['column_ledger_urdu'] = $this->language->get('column_ledger_urdu');
                $this->data['column_type_urdu'] = $this->language->get('column_type_urdu');
                $this->data['column_debit_urdu'] = $this->language->get('column_debit_urdu');
                $this->data['column_credit_urdu'] = $this->language->get('column_credit_urdu');
                $this->data['column_date_urdu'] = $this->language->get('column_date_urdu');
                $this->data['column_rate_urdu'] = $this->language->get('column_rate_urdu');
                $this->data['column_orgional_amount_urdu'] = $this->language->get('column_orgional_amount_urdu');
                $this->data['column_particular_urdu'] = $this->language->get('column_particular_urdu');
                $this->data['column_balance_urdu'] = $this->language->get('column_balance_urdu');
                $this->data['column_regid_urdu'] = $this->language->get('column_regid_urdu');
                $this->data['company_title'] = $this->language->get('company_title');
                $this->data['general_ledger'] = $this->language->get('general_ledger');
                
                $this->data['button_today'] = $this->language->get('button_today');
                $this->data['button_all'] = $this->language->get('button_all');
                $this->data['button_print'] = $this->language->get('button_print');
                $this->data['button_find'] = $this->language->get('button_find');
                $this->data['button_details'] = $this->language->get('button_details');
                $this->data['button_save'] = $this->language->get('button_save');
                $this->data['button_cancel'] = $this->language->get('button_cancel');
                
                $this->data['text_end_date'] = $this->language->get('text_end_date');
                $this->data['text_start_date'] = $this->language->get('text_start_date');
                $this->data['text_account'] = $this->language->get('text_account');
                $this->data['text_debit'] = $this->language->get('text_debit');
                $this->data['text_credit'] = $this->language->get('text_credit');
                $this->data['text_description'] = $this->language->get('text_description');
                $this->data['text_new_dialog'] = $this->language->get('text_new_dialog');
                $this->data['text_account_detail'] = $this->language->get('text_account_detail');
                $this->data['text_detail'] = $this->language->get('text_detail');
                
                $this->data['text_m0'] = $this->language->get('text_m0');
                $this->data['text_m1'] = $this->language->get('text_m1');
                $this->data['text_m2'] = $this->language->get('text_m2');
                $this->data['text_m3'] = $this->language->get('text_m3');
                $this->data['text_m4'] = $this->language->get('text_m4');
                $this->data['text_m5'] = $this->language->get('text_m5');
                $this->data['text_m6'] = $this->language->get('text_m6');
                $this->data['text_m7'] = $this->language->get('text_m7');
                $this->data['text_m8'] = $this->language->get('text_m8');
                $this->data['text_m9'] = $this->language->get('text_m9');
                $this->data['text_m10'] = $this->language->get('text_m10');
                $this->data['text_m11'] = $this->language->get('text_m11');
               
                $this->data['url_getledger'] = HTTP_SERVER . 'index.php?route=account/ledger/getLedger';
                $this->data['url_ledger_detail'] = HTTP_SERVER . 'index.php?route=account/ledger/getLedger&acc_id=';
                $this->data['url_getledgerdetail'] = HTTP_SERVER . 'index.php?route=account/ledger/getLedgerDetail';
                $this->data['url_print_iframe'] = HTTPS_SERVER . 'index.php?route=account/ledger&print=1';
                               
                $this->load->model('common/common'); 
                $results = $this->model_common_common->getAccounts(); 
                foreach ($results as $result) {
                    $this->data['accounts'][] = array( 
                            'acc_id'       => $result['acc_id'],
                            'acc_name' => $result['acc_name'],
                            'acc_head' => $result['acc_head_title']
                    );
                }		
                if(isset($this->request->get['print'])){
                    $this->template = 'account/print_ledger.tpl';
                    $this->children = array(); 
                }   
                else{
                    $this->template = 'account/account_ledger.tpl';
                    $this->children = array(
                            'common/header',	
                            'common/footer',
                            'common/leftcol'	
                    ); 
                }
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
        
        public function getLedger(){
            $this->load->model('account/ledger'); 
            $results = $this->model_account_ledger->getLedgerList($this->request->get); 
           
            $this->load->library('json');
            $this->response->setOutput(Json::encode($results), $this->config->get('config_compression'));
        }
	public function getLedgerDetail(){
            $this->load->model('account/ledger'); 
            $data = $this->request->get;
            $detail_array = $this->model_account_ledger->getDetailsAccount($data["acc_id"],$data);
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($detail_array), $this->config->get('config_compression'));
        }
        
}
?>