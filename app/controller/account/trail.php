<?php
class ControllerAccountTrail extends Controller { 
	public function index() {
                
		$this->load->language('account/trail'); 
		$this->document->title =$this->language->get('heading_title'); 
		$this->load->model('account/trail'); 
		$this->getList();
	} 
	
        
	
	private function getList() {
	
                $this->data['url_account_trail'] = HTTPS_SERVER . 'index.php?route=account/trail/getTrail';    
                $this->data['url_print_iframe'] = HTTPS_SERVER . 'index.php?route=account/trail&print=1';
		$this->data['heading_title'] = $this->language->get('heading_title'); 
		$this->data['column_debit'] = $this->language->get('column_debit');
                $this->data['column_credit'] = $this->language->get('column_credit');
                $this->data['column_name'] = $this->language->get('column_name');
                $this->data['column_debit_urdu'] = $this->language->get('column_debit_urdu');
                $this->data['column_credit_urdu'] = $this->language->get('column_credit_urdu');
                $this->data['column_name_urdu'] = $this->language->get('column_name_urdu');
                $this->data['company_title'] = $this->language->get('company_title');
		
                $this->data['button_print'] = $this->language->get('button_print');
                $this->data['button_get_trail'] = $this->language->get('button_get_trail');
                $this->data['text_till'] = $this->language->get('text_till');
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
                $this->data['text_title'] = $this->language->get('text_title');
                $this->data['text_end_date'] = $this->language->get('text_end_date');
                $this->data['text_start_date'] = $this->language->get('text_start_date');
                                	
                if(isset($this->request->get['print'])){
                    $this->template = 'account/print_trail.tpl';
                    $this->children = array(); 
                }   
                else{
                    $this->template = 'account/account_trail.tpl';
                    $this->children = array(
                            'common/header',	
                            'common/footer',
                            'common/leftcol'	
                    ); 
                }
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
        public function getTrail(){
            $this->load->model('account/trail'); 
            $results = $this->model_account_trail->getTrail($this->request->get); 
            $accounts_array = array();
            $adjust_ammount_debit = 0;
            $adjust_ammount_credit = 0;
            $acc_payable_name = $this->model_account_trail->getTypeName(7);
            foreach ($results as $result) {
                   if($result['debit']!=0 || $result['credit']!=0){
                                             
                       $balance = $result['debit']-$result['credit'];
                       
                       $debit = $credit = 0;
                       $debit_text = $credit_text = '';
                       if($balance>0){
                           $debit = number_format($balance,2,'.','');
                           $debit_text = $debit!=0?$debit:'';
                       }
                       else{
                           $credit = number_format($balance*-1,2,'.','');
                           $credit_text = $credit!=0?$credit:'';
                       }
                       if($balance==0){
                           $debit_text = number_format(0,2,'.','');
                       }
                       $acc_type = $result['acc_type'];
                       if($result['acc_type_id']==6 && $credit>0){
                           $acc_type = $acc_payable_name;
                       }
                       if($result['_acc_type']==2){
                           $balance_amount = $result['debit_amount']-$result['credit_amount'];
                           if($balance_amount==0){
                               if($debit>0){
                                 $adjust_ammount_debit += $debit;
                                 $debit = $debit - $debit;
                                 $debit_text = $debit!=0?$debit:'';
                               }
                               else if($credit>0){
                                   $adjust_ammount_credit += $credit;
                                   $credit = $credit - $credit;
                                   $credit_text = $credit!=0?$credit:'';
                               }
                           }
                       }
                       $accounts_array['trail'][] = array(
                                'id' => $result['acc_id'],
                                'account_name'      => $result['acc_name'],
                                'type' =>        $acc_type,
                                'debit' => $debit_text,
                                'credit' => $credit_text

                        );
                   }
                   if($adjust_ammount_debit!=0 || $adjust_ammount_credit!=0){
                    $_bal = $adjust_ammount_debit-$adjust_ammount_credit;  
                    $_debit = $_bal>0?$_bal:0; 
                    $_credit = $_bal<0?$_bal:0;
                    $accounts_array['trail'][] = array(
                                 'id' => '-1',
                                 'account_name'      => 'Adjustments',
                                 'type' =>        'Amanat Adjustment',
                                 'debit' => number_format($_debit,2,'.',''),
                                 'credit' => number_format($_credit,2,'.','')

                     );
                   }
                }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
        }
	
	
}
?>