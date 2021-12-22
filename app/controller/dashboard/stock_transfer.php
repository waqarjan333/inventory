<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for stock Transfer
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
     
class ControllerDashboardStock_transfer extends Controller { 
        public function index() {
            //Load Controller
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }                             
  	}
      

         public function save(){
            // $this->load->model('dashboard/po');
            $this->load->language('dashboard/stock_transfer'); 
            $this->load->library('json');
            $so_details = (array)Json::decode(html_entity_decode($this->request->post['trans']));            
            if($this->request->post['po_hidden_id']=="0"){
                $results = $this->model_dashboard_po->saveInvoice($this->request->post,$so_details);
            }
            else{
               $so_rec_details = (array)Json::decode(html_entity_decode($this->request->post['rec']));
               $results = $this->model_dashboard_po->updateInvoice($this->request->post,$so_details,$so_rec_details); 
            }
            $save_item = array();
            $save_item['success'] = true;
            $save_item['msg'] = $this->language->get('msg_save_success');
            $save_item['inv_no'] = $results["inv_no"];
            $pd = $this->request->post;
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($save_item), $this->config->get('config_compression'));
            
        }
      }

      ?><!--  -->