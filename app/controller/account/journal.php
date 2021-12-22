<?php
class ControllerAccountJournal extends Controller { 	
	public function save_update() {
		$save_update_array = array();	
		$this->load->model('account/journal');                 
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $data = $this->request->post;
                        if($data['debit_entry_id']==0){    
                            $last_id=$this->model_account_journal->addEntry($data); 
                        }
                        else{
                            $last_id= $this->model_account_journal->updateEntry($data); 
                        }
                        $save_update_array['message'] = 'success';
                        $save_update_array['last_id'] = $last_id;
			$save_update_array['action'] = '1';                        
		} 
                
                $this->load->library('json');
                $this->response->setOutput(Json::encode($save_update_array), $this->config->get('config_compression'));
		
	}
        public function delete() {
		$delete_array = array();	
		$this->load->model('account/journal');                 
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $data = $this->request->post;
                        $id_array = explode(",",$data['_ids']); 
                        foreach ( $id_array as $id) {
                            $this->model_account_journal->deleteEntry($id);
                        } 
                                                
                        $delete_array['message'] ='success';
			$delete_array['action'] = '1';
                        
		} 
                
                $this->load->library('json');
                $this->response->setOutput(Json::encode($delete_array), $this->config->get('config_compression'));
		
	}
      
        public function getJournal(){
            $this->load->model('account/journal'); 
            $results = $this->model_account_journal->getJournalList($this->request->get); 
            $accounts_array = array();
                        
             foreach ($results as $result) {
                  $out= $in= $debit= $credit= 0;
                   if($result['journal_amount']>0){
                     $in =   number_format($result['journal_amount'],6,'.','');
                     $debit = number_format($in * $result['currency_rate'],2,'.','');
                   }
                   else{
                      $out =   number_format(-1*$result['journal_amount'],6,'.','');
                      $credit =  number_format($out * $result['currency_rate'],2,'.','');
                   }
                   $accounts_array['journal'][] = array(
                            'id' => $result['journal_id'],
                            'register_id'=> $this->getRegisterNo('REG',$result['journal_id']),
                            'r_id'=> $result['journal_id'],     
                            'invoice_id'=> '',
                            'inv_id'=> '',
                            'ref_id'=> $result['ref_id'],
                            'details'      => $result['journal_details'],
                            'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                            'account'       => $result['acc_name'],                            
                            'acc_id'       => $result['acc_id'],
                            'in'       => $in==0?'':$in,
                            'out' => $out==0?'':$out,                            
                            'debit' => $debit==0?'':$debit,
                            'credit' => $credit==0?'':$credit,
                            'entry_date' => date($this->language->get('date_format'),strtotime($result['entry_date'])),
                            'acc_type' => $result['type']

                    );
                }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
        }
	
	private function getRegisterNo($str,$reg_id){
            $custom_no = '';
            if($reg_id>0){
                $reg_id = str_pad($reg_id, 8, "0", STR_PAD_LEFT);
                $custom_no =$str.$reg_id;
            }
            return $custom_no;
        }
}
?>