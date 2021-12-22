<?php
class ControllerAccountJournalview extends Controller { 
        public function save_update_invoice() {
            $save_update_array = array();	
            $this->load->model('account/journalview');                 
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

                    $json = file_get_contents('php://input');

                    // Converts it into a PHP object
                    $data = json_decode($json);
                    $entry_id = json_decode($data->entry_id);
                    $data = json_decode($data->data);
                    if($entry_id == null){
                        $last_id = $this->model_account_journalview->addInvoice($data);
                    }
                    else{
                        $last_id = $this->model_account_journalview->updateInvoice($data, $entry_id);
                    }
                    $save_update_array['message'] = 'success';
                    $save_update_array['last_id'] = $last_id;
                    $save_update_array['action'] = '1';
            } 

            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_update_array), $this->config->get('config_compression'));
		
	}
        
        public function previous_invoice(){
            $previous_array = array();
            $details_array = array();
            $this->load->model('account/journalview'); 
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $json = file_get_contents('php://input');
                
                // Converts it into a PHP object
                $data = json_decode($json);
                $entry_id = json_decode($data->entry_id);
            
                $min_max_id = $this->model_account_journalview->minmaxId();
                $invoice_id = $this->model_account_journalview->previousInvoice($entry_id);
                $invoice_details = $this->model_account_journalview->InvoiceDetails($invoice_id['id']);
                
                
                $previous_array['min'] = $min_max_id['min'];
                $previous_array['max'] = $min_max_id['max'];
                $previous_array['entry_id'] = $invoice_id['entry_id'];
                $previous_array['inv_date'] = date("d-m-Y H:i:s", strtotime($invoice_id['date']));
                $count = 0;
                foreach($invoice_details as $data){
                    $details_array[$count]['acc_name'] = $data['acc_name'];
                    $details_array[$count]['debit_amount'] = 1* $data['debit_amount'];
                    $details_array[$count]['credit_amount'] = -1 * $data['credit_amount'];
                    $details_array[$count]['memo'] = $data['memo'];
                    $details_array[$count]['name'] = $this->model_account_journalview->nameID($data['name']);
                    $count++;
                }
                $previous_array['details'] = $details_array;
                //echo json_encode($previous_array);
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($previous_array), $this->config->get('config_compression'));
        }
        
        public function next_invoice(){
            $next_array = array();
            $details_array = array();
            $this->load->model('account/journalview'); 
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $json = file_get_contents('php://input');
                
                // Converts it into a PHP object
                $data = json_decode($json);
                $entry_id = json_decode($data->entry_id);
            
                $min_max_id = $this->model_account_journalview->minmaxId();
                $invoice_id = $this->model_account_journalview->nextInvoice($entry_id);
                $invoice_details = $this->model_account_journalview->InvoiceDetails($invoice_id['id']);

                $next_array['min'] = $min_max_id['min'];
                $next_array['max'] = $min_max_id['max'];
                $next_array['entry_id'] = $invoice_id['entry_id'];
                $next_array['inv_date'] = date("d-m-Y H:i:s", strtotime($invoice_id['date']));
                $count = 0;
                foreach($invoice_details as $data){
                    $details_array[$count]['acc_name'] = $data['acc_name'];
                    $details_array[$count]['debit_amount'] = 1* $data['debit_amount'];
                    $details_array[$count]['credit_amount'] = -1 * $data['credit_amount'];
                    $details_array[$count]['memo'] = $data['memo'];
                    $details_array[$count]['name'] = $this->model_account_journalview->nameID($data['name']);
                    $count++;
                }
                $next_array['details'] = $details_array;
                //echo json_encode($previous_array);
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($next_array), $this->config->get('config_compression'));
        }
        
        public function delete_invoice(){
            $delete_array = array();
            $this->load->model('account/journalview'); 
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $json = file_get_contents('php://input');
                
                // Converts it into a PHP object
                $data = json_decode($json);
                $entry_id = json_decode($data->entry_id);
            
                $last_id = $this->model_account_journalview->deleteInvoice($entry_id);
                $delete_array['message'] = 'success';
                $delete_array['last_id'] = $last_id;
                $delete_array['action'] = '1';
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_array), $this->config->get('config_compression'));
        }
        
        public function retrieve_invoice(){
            $retrieve_array = array();
            $this->load->model('account/journalview'); 
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $json = file_get_contents('php://input');
                
                // Converts it into a PHP object
                $data = json_decode($json);
                $date =  json_encode($data->date);
                $result = $this->model_account_journalview->retrieveID($date);
                $count = 0;
                foreach ($result as $row){
                    $result_details = $this->model_account_journalview->retrieveDetails($row['id']);
                    foreach($result_details as $row_details){
                        $retrieve_array[$count]['date'] = date("d-m-Y H:i:s", strtotime($row['inv_date']));
                        $retrieve_array[$count]['entry_id'] = $row['entry_id'];
                        $retrieve_array[$count]['adj'] = '';
                        $retrieve_array[$count]['account'] = $row_details['account'];
                        $retrieve_array[$count]['memo'] = $row_details['memo'];
                        if($row_details['debit'] == 0 ){
                            $retrieve_array[$count]['amount'] = 1 * $row_details['credit'];
                        }
                        else{
                            $retrieve_array[$count]['amount'] = 1 * $row_details['debit'];
                        }
                        $count++;
                        
                    }
                }
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($retrieve_array), $this->config->get('config_compression'));
        }
        
        public function retrieve_invoice_details(){
            $current_array = array();
            $details_array = array();
            $this->load->model('account/journalview'); 
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $json = file_get_contents('php://input');
                
                // Converts it into a PHP object
                $data = json_decode($json);
                $entry_id = json_decode($data->entry_id);
            
                $min_max_id = $this->model_account_journalview->minmaxId();
                $invoice_id = $this->model_account_journalview->thisInvoice($entry_id);
                $invoice_details = $this->model_account_journalview->InvoiceDetails($invoice_id['id']);

                $next_array['min'] = $min_max_id['min'];
                $next_array['max'] = $min_max_id['max'];
                $current_array['entry_id'] = $invoice_id['entry_id'];
                $current_array['inv_date'] = date("d-m-Y H:i:s", strtotime($invoice_id['date']));
                $count = 0;
                foreach($invoice_details as $data){
                    $details_array[$count]['acc_name'] = $data['acc_name'];
                    $details_array[$count]['debit_amount'] = 1* $data['debit_amount'];
                    $details_array[$count]['credit_amount'] = -1 * $data['credit_amount'];
                    $details_array[$count]['memo'] = $data['memo'];
                    $details_array[$count]['name'] = $this->model_account_journalview->nameID($data['name']);
                    $count++;
                }
                $current_array['details'] = $details_array;
                
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($current_array), $this->config->get('config_compression'));
        }
}
?>