<?php
class ControllerCommonCommon extends Controller {
	public function index() {
            	
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
      
        public function sendMessage(){
            $output = ''; 
            $this->load->model('dashboard/seekers'); 
            if (($this->request->server['REQUEST_METHOD'] == 'POST')){
                $from = $this->request->post['msgfrom'];
                $to = $this->request->post['msgto'];
                $title = $this->request->post['msgtitle'];
                $body = $this->request->post['message'];
                $this->model_dashboard_seekers->sendMessage($from,$to,$title,$body);
            }
            $this->response->setOutput($output, $this->config->get('config_compression'));
        }
        public function sendSMS(){
            $output = ''; 
            $this->load->model('common/common'); 
            if (($this->request->server['REQUEST_METHOD'] == 'POST')){
                $data['username'] = $this->request->post['username'];
                $data['password'] = $this->request->post['password'];
                $data['from'] = $this->request->post['from'];
                $data['to'] = $this->request->post['to'];
                $data['message'] = $this->request->post['message'];
                $output = $this->model_common_common->sendSMS($data);
                
            }
            $this->load->library('json');
            $this->response->setOutput($output, $this->config->get('config_compression'));
        }
        
        public function getBalance(){
            $balance_array = array();
            $data = $this->request->get;
            $this->load->model('common/common');             
            $balance_array['balance'] = number_format($this->model_common_common->getBalance($data),2,'.','');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($balance_array), $this->config->get('config_compression'));
        }
        public function saveInvoiceDescription()
         {
             $this->load->model('common/common');
             $result = $this->model_common_common->saveInvoiceDescription($this->request->post);
         }
        public function saveSettings(){
            $data = $this->request->post;
            $this->load->model('common/common');             
            $this->model_common_common->saveSettings($data);
            $settings_array=  array();            
            $settings_array['success'] = 1;            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($settings_array), $this->config->get('config_compression'));
        }
        public function updateRemarks(){
            $data = $this->request->post;
            $this->load->model('common/common');             
            $this->model_common_common->updateRemarks($data);
            $settings_array=  array();            
            $settings_array['success'] = 1;            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($settings_array), $this->config->get('config_compression'));
        }
        public function getUnits(){
            $units_array = array();
            $data = $this->request->get;
            $this->load->model('common/common');       
            $data = $this->request->post;
            $units_array = $this->model_common_common->getUnits($data["id"]);            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($units_array), $this->config->get('config_compression'));
        }
        
        public function getSettings(){
            $settings_array = array();
            $data = $this->request->get;
            $this->load->model('common/common');             
            $settings_array['config_saleterms'] = html_entity_decode($this->model_common_common->getSettings());
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($settings_array), $this->config->get('config_compression'));
        }
        
        public function sendPSMS(){
            $output = ''; 
            $this->load->model('common/common');             
            $to = "03219153370";
            $message = "Hello test service";
            $response = $this->model_common_common->sendSMS($to,$message);
            echo $response;            
            $this->response->setOutput($output, $this->config->get('config_compression'));
        }
        
        public function securityQuestion(){
            $questions_array = array();
            $this->load->model('common/common'); 
            $questions_array = $this->model_common_common->securityQuestion();            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($questions_array), $this->config->get('config_compression'));
        }
        
        public function saveSecurityQuestion(){
            $save_question = array();
            $this->load->model('common/common'); 
            
            $data = $this->request->post;
            
            $save_question['data'] = $this->model_common_common->saveSecurityQuestions($data);
            if($data['new_password']!=$data['conform_password']){
                $save_question['success'] = 0;
                $save_question['msg'] = "Password does not match! Please enter same password";
            } else if($data['question_1']==$data['question_2']){
                $save_question['success'] = 0;
                $save_question['msg'] = "You select same question Please select diffrent questions";
            } else if($data['answer_1']==""){
                $save_question['success'] = 0;
                $save_question['msg'] = "Please Select Question No 1 and gave valid answer";
            } else if($data['answer_2']==""){
                $save_question['success'] = 0;
                $save_question['msg'] = "Please Select Question No 2 and gave valid answer";
            }else if($data['new_password']== "1234" || $data['conform_password']=="1234"){
                $save_question['success'] = 0;
                $save_question['msg'] = "You enter your old password, Please enter another password";
            } else {
                $save_question['success'] = 1;
                $save_question['msg'] = "Successfully update username and password";
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_question), $this->config->get('config_compression'));
        }
        public function printLabel(){
            $this->load->library('json');
            $item_detail = (array)Json::decode(html_entity_decode($this->request->post['item_data']));
            
            $design = '{"cmd":['; $qty = ""; $price = "";
             for($i=0;$i<count($item_detail);$i++){
                $price = "Rs : " . $item_detail[$i]->{'barcode_lable_sale_price'};
                
            $design .= '{"textArray":[{
                            "text": "'.$price.'",
                            "font": "32",
                            "XPosition": "170",
                            "YPosition": "88"
			},
			{
                            "text": "'.$item_detail[$i]->{"barcode_lable_item_name"}.'",
                            "font": "30",
                            "XPosition": "80",
                            "YPosition": "160"
			}],
			"Barcode": {
                            "type": "Code 128",
                            "data": "'.$item_detail[$i]->{"barcode_lable_barcode"}.'",
                            "XPosition": "80",
                            "YPosition": "50",
                            "height": "100"
			},
			"border": "true",
                        "Quantity": "'.$item_detail[$i]->{"barcode_lable_qty"}.'"
                        }';
                        if(count($item_detail)== ($i+1)){
                            $design .= '';
                        } else {
                           $design .= ','; 
                        }
             }
            $design .= '],
                    "width": "38",
                    "height": "26",
                    "column": "1",
                    "user": "1543318887931"
            }';
            
            //echo $design; exit;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://apologetic-minister-59792.herokuapp.com/api/printlabel",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $design,
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"                
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $result = array();
            $result["message"] = $response;
            $result["error"] = $err;
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($result), $this->config->get('config_compression'));
        }
        public function export_database() {
  //load helpers

// $this->load->helper('file');
// $this->load->helper('download');
// $this->load->library('zip');

//load database
$this->load->dbutil();

//create format
$db_format=array('format'=>'zip','filename'=>'backup.sql');

$backup=& $this->dbutil->backup($db_format);

// file name

$dbname='backup-on-'.date('d-m-y H:i').'.zip';
$save='assets/db_backup/'.$dbname;

// write file

write_file($save,$backup);

// and force download
force_download($dbname,$backup);
	
}
}
?>