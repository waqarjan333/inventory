<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 02/01/2020
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerApiLabels extends Controller { 
        public function index() {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: access");
            header('Content-Type: application/json');
            
            $this->load->library('json');
            $this->load->model('api/labels');
                        
            $api_response = array();
            if(isset($_REQUEST)){
                $api_type =  $_REQUEST["type"];
                $_request = $_REQUEST;
            }            
            if(isset($api_type)){                              
                
                if($api_type=="create"){
                    $api_response = $this->addLabel($_request);
                   // $api_response = $_request["json"];
                }
                else if($api_type=="update"){
                    $api_response = $this->updateLabel($_request);
                }
                else if($api_type=="getLabelById"){
                    $api_response = $this->getLabelById($_request);
                }
                else if($api_type=="get"){
                    $api_response = $this->getLabels($_request);
                }
                else if($api_type=="delete"){
                    $api_response = $this->deleteLabel($_request);
                }
                
            }
            else{
                $api_response['success'] = 0;                
                $api_response['msg'] = "Type is not defined!";
            }
            
            $this->response->setOutput(Json::encode($api_response), $this->config->get('config_compression'));
            
  	}
        
       private function addLabel($data){
            $response = array();              
            if(isset($data["json"])){
                $result = $this->model_api_labels->createLabel($data);                
                $response['success'] = 1;
                $response['msg'] = $this->language->get('msg_save_success');                
                $response['id'] = $result;
            }
            else{
                $response['success'] = 0;
                $response['msg'] = "json field is not defined";
            }
            return $response;          
       }
       
       private function updateLabel($data){
           $response = array();              
            if(isset($data["json"]) && isset($data["id"])){
                $result = $this->model_api_labels->updateLabel($data);                
                $response['success'] = 1;
                $response['msg'] = $this->language->get('msg_save_success');                
                $response['id'] = $result;
            }
            else{
                $response['success'] = 0;
                $response['msg'] = "json or id field is not defined";
            }
            return $response;                  
       }
       
       private function getLabelById($data){      
           $label_array = array();
           if(isset($data["id"])){
                $results = $result = $this->model_api_labels->getLabelById($data);         
                $label_array = array();
                $label_array["id"] = $result['id'];
                $label_array["user_id"] = $result['user_id'];
                $label_array["type"] = $result['type'];
                $label_array["json"] = $result['data'];
                $label_array["created_date"] = $result['created_date'];
                $label_array["updated_date"] = $result['updated_date'];
           }
           else{
               $label_array['success'] = 0;
               $label_array['msg'] = "Id param is missing";
           }
           
           return $label_array;
       }
       private function getLabels($data){           
             $results = $result = $this->model_api_labels->getLabels($data);        ;
             $label_array = array();                         
             foreach ($results as $result) {                 
                 
                 $label_array['labels'][] = array(
                        'id'             => $result['id'],                        
                        'user_id'             => $result['user_id'],                        
                        'type'             => $result['type'],
                        'json'             => $result['data'],
                        'created_date'     => $result['created_date'],                        
                        'updated_date'     => $result['updated_date']
                    );
             }
             return $label_array;
           
       }
       private function deleteLabel($data){
           $delete_label = array();
           if(isset($data["id"])){
                $id_array = explode(",",$data["id"]); 
                foreach ( $id_array as $id) {
                     $this->model_api_labels->deleteLabel($id);
                } 
                $delete_label = array();
                $delete_label['success'] = 1;
                $delete_label['msg'] = $this->language->get('msg_delete_success');
           }
           else{
               $delete_label['success'] = 0;
               $delete_label['msg'] = "Id param is missing";
           }
            
            return $delete_label;
       } 
    }
?>
