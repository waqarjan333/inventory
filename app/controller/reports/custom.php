<?php
class ControllerReportsCustom extends Controller {
	private $error = array(); 
	public function index() {
           if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
           }
           $this->data['get_url_custom'] = HTTP_SERVER.'index.php?route=reports/custom';
           
           $post_data=$this->request->post;
           if(isset($post_data) && isset($post_data["report_id"])){
                if($post_data["report_id"]=="51"){
                    $this->generateInvoices($post_data);
                }
                else if($post_data["report_id"]=="52"){
                    $this->generateStock($post_data);
                }
                else if($post_data["report_id"]=="53"){
                     $this->generateCustomer();
                }
           }
                                
           if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/reports/custom.tpl')) { 
                    $this->template = $this->config->get('config_template') . '/template/reports/custom.tpl';
            } else {
                    $this->template = 'default/template/login/login.tpl';
            } 
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
        
        private function generateCustomer(){
            $this->load->model('reports/custom');
                        
            $report_lines =  $this->model_reports_custom->get_customer();                                   
            $data = str_pad('DSTBiD',6,' ').' '. str_pad('CustID',10,' ').' '. str_pad('CustName',50,' ').' '. str_pad('Address',50,' ').' '.'CT'.' '.str_pad('TownID','16',' ').' Town'."\r\n";
            foreach ($report_lines as $result) {
                $data.=str_pad(str_pad('278',4,'0',STR_PAD_LEFT),6,' ').' '. str_pad($result['cust_id'],10,' ').' '. str_pad($result['cust_name'],50,' ').' '. str_pad($result['cust_group_name'],50,' ').' '. str_pad($result['cust_type_id'],2,'0',STR_PAD_LEFT).' '. str_pad(str_pad($result['cust_group_id'],5,'0',STR_PAD_LEFT),16,' ').' '.str_pad($result['cust_group_name'],'16',' ')." \r\n";
            }
            $file_name = "0278Cust.txt";
            
            $this->createFile($data, $file_name);
        }
        
        private function generateStock($data){
            $this->load->model('reports/custom');
            
             
            $report_lines =  $this->model_reports_custom->get_stock($data);                
            $data = str_pad('DSTBiD',6,' ').' '. str_pad('DocDate',10,' ').' '. str_pad('PrdID',10,' ').' '. str_pad('Prd',50,' ').' '.str_pad('Balance',16,' ').' InTransit'."\r\n";
            foreach ($report_lines as $result) {
                $data.=str_pad(str_pad('278',4,'0',STR_PAD_LEFT),6,' ').' '. str_pad($result["cldate"],10,' ').' '. str_pad($result["item_id"],10,' ').' '. str_pad($result["item_name"],50,' ').' '.str_pad($result["qty"],16,' ').' '."\r\n";
            }
            $file_name = "0278Stock.txt";
            
            $this->createFile($data, $file_name);
        }
        
        private function generateInvoices($data){
            $this->load->model('reports/custom');
            
            
            $report_lines =  $this->model_reports_custom->get_invoices($data);    
            //'DSTBiD', 'DocumentNO', 'DocDate', 'CustID', 'CT', 'TownID', 'PrdID', 'Prd', 'BatchNO', 'Price', 'QuanTiTy', 'Bonus', 'Discount', 'NetAmnt', 'Reason'
            $data = str_pad('DSTBiD',6,' ').' '. str_pad('DocumentNO',12,' ').' '. str_pad('DocDate',10,' ').' '. str_pad('CustID',10,' ').' '.str_pad('CT',2,' ').' '.str_pad('TownID',16,' ').' '.str_pad('PrdID',9,' ').' '.str_pad('Prd',50,' ').' ';
            $data .= str_pad('BatchNO',10,' ').' '.str_pad('Price',14,' ').' '.str_pad('QuanTiTy',12,' ').' '.str_pad('Bonus',12,' ').' '.str_pad('Discount',14,' ').' '.str_pad('NetAmnt',14,' ').' Reason'. "\r\n";
            foreach ($report_lines as $result) {
                $data .= str_pad(str_pad('278',4,'0',STR_PAD_LEFT),6,' ').' '. str_pad($result['inv_no'],12,' ').' '. str_pad(date("d/m/Y", strtotime($result['inv_date'])),10,' ').' '. str_pad($result['inv_cust'],10,' ').' '.str_pad(str_pad($result['cust_type'],2,'0',STR_PAD_LEFT),2,' ').' '.str_pad(str_pad($result['cust_town'],5,'0',STR_PAD_LEFT),16,' ').' '.str_pad($result['item_id'],9,' ').' '.str_pad($result['item_name'],50,' ').' ';
                $data .= str_pad('000',10,' ').' '.str_pad($result['item_price'],14,' ').' '.str_pad($result['item_qty'],12,' ').' '.str_pad('000',12,' ').' '.str_pad(number_format($result['item_discount'],2,'.',''),14,' ').' '.str_pad($result['item_net_price'],14,' ').' S'."\r\n";
            }
            $file_name = "0278Inv.txt";
            
            $this->createFile($data, $file_name);
        }
        
        private function createFile($data, $file_name){
            
            $handle = fopen(DIR_UPLOAD.$file_name, "w");
            fwrite($handle, $data);
            fclose($handle);

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file_name));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize(DIR_UPLOAD.$file_name));
            readfile(DIR_UPLOAD.$file_name);
            exit;
            
            
        }
                                          
         
}
?>
