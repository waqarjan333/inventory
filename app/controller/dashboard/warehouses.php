<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for items
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardWarehouses extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }
  	}
       
        public function saveupdate(){
            $this->load->model('dashboard/warehouses');
            $this->load->language('dashboard/warehouses'); 
             $this->load->model('common/common');
            $save_warehouse = array();
            if(!$this->model_dashboard_warehouses->checkNameExists($this->request->post) && !$this->model_dashboard_warehouses->checkCodeExists($this->request->post)){
                $results = $this->model_dashboard_warehouses->saveupdateWarehouse($this->request->post);
                
                $save_warehouse['success'] = 1;
                $save_warehouse['obj_id'] = $results;
                $save_warehouse['data'] = $this->model_common_common->getWarehouses();
                $save_warehouse['msg'] = $this->language->get('msg_save_success');
            }
            else{
                $save_warehouse['success'] = 0;
                $save_warehouse['msg'] = $this->language->get('msg_name_exists');
            }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_warehouse), $this->config->get('config_compression'));            
        }
        
        public function deleteAccount(){
            $this->load->model('dashboard/warehouses');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_account->deleteAccount($id);
            } 
            $delete_account = array();
            $delete_account['success'] = true;
            $delete_account['msg'] = $this->language->get('msg_delete_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($delete_account), $this->config->get('config_compression'));
            
        }
        public function deactivateWarehouse(){
            $this->load->model('dashboard/warehouses');
            $id_array = explode(",",$this->request->post['selected']); 
            foreach ( $id_array as $id) {
                    $this->model_dashboard_warehouses->deactivateWarehouse($id);

            } 
            $deactivate_warehouse = array();
            $deactivate_warehouse['success'] = true;
            $deactivate_warehouse['msg'] = $this->language->get('msg_deactivate_success');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($deactivate_warehouse), $this->config->get('config_compression'));
            
        }
         public function getWarehouses(){
             $this->load->model('dashboard/warehouses');
             $this->load->language('dashboard/warehouses');
             $warehouses_array =$this->getWarehousesArray($this->request->get);
             $this->load->library('json');
             $this->response->setOutput(Json::encode($warehouses_array), $this->config->get('config_compression'));
         }

         public function get_warehouses_2()
         {
           $this->load->model('dashboard/warehouses');
           $results = $this->model_dashboard_warehouses->getWarehouses_2($this->request->get);
                   $warehouses_array = array();
             foreach ($results as $result) {
                 $warehouses_array['warehouses2'][] = array(
                        'id'             => $result['warehouse_id'],
                        'warehouse_name'             => $result['warehouse_name'],
                        'warehouse_code'                  => $result['warehouse_code'],
                        'warehouse_isdefault'                  => $result['warehouse_isdefault'],
                        'warehouse_isactive'           =>  $result['warehouse_isactive'],
                        'warehouse_contact_name'                  => $result['warehouse_contant_name'],
                        'warehouse_phone'                  => $result['warehouse_phone'],
                        'warehouse_mobile'                  => $result['warehouse_mobile'],
                        'warehouse_ddi_number'                  => $result['warehouse_ddi_number'],
                        'warehouse_address'                  => $result['warehouse_address'],
                        'warehouse_city'                  => $result['warehouse_city'],
                        'warehouse_street'                  => $result['warehouse_street'],
                        'warehouse_state'                  => $result['warehouse_state'],
                        'warehouse_country'                  => $result['warehouse_country'],
                        'warehouse_postalcode'                  => $result['warehouse_postalcode']
                    );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($warehouses_array), $this->config->get('config_compression'));
         }
         private function getWarehousesArray($get){

             $results = $this->model_dashboard_warehouses->getWarehouses($get);
             $warehouses_array = array();
             foreach ($results as $result) {
                 $warehouses_array['warehouses'][] = array(
                        'id'             => $result['warehouse_id'],
                        'warehouse_name'             => $result['warehouse_name'],
                        'warehouse_code'                  => $result['warehouse_code'],
                        'warehouse_isdefault'                  => $result['warehouse_isdefault'],
                        'warehouse_isactive'           =>  $result['warehouse_isactive'],
                        'warehouse_contact_name'                  => $result['warehouse_contant_name'],
                        'warehouse_phone'                  => $result['warehouse_phone'],
                        'warehouse_mobile'                  => $result['warehouse_mobile'],
                        'warehouse_ddi_number'                  => $result['warehouse_ddi_number'],
                        'warehouse_address'                  => $result['warehouse_address'],
                        'warehouse_city'                  => $result['warehouse_city'],
                        'warehouse_street'                  => $result['warehouse_street'],
                        'warehouse_state'                  => $result['warehouse_state'],
                        'warehouse_country'                  => $result['warehouse_country'],
                        'warehouse_postalcode'                  => $result['warehouse_postalcode']
                    );
             }
             return $warehouses_array;
         }
          
       
    }
?>