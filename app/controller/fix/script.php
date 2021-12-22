<?php
class ControllerFixScript extends Controller {
	private $error = array(); 
	public function index() {
           if (!$this->siteusers->isLogged() || $this->siteusers->userRight()==0) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
           }
           
           
	}
        public function fixSaleInvoices(){            
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->fixSaleInvoices();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         public function fixSaleInvoicessubtotal(){            
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->fixSaleInvoicessubtotal();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         public function copyPrices(){            
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->purchaseFix();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         public function POSinvoiceTotalZero(){            
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->POSinvoiceTotalZero();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         public function POSReturninvoiceTotalZero(){            
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->POSReturninvoiceTotalZero();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         public function fixAccount(){            
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->chart_fix();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function importStock(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."item.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->update_item($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function importCustomer(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."customer.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->update_customer($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
                  
         
         public function stockFix(){            
             
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->stock_fix();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
         }
         
          public function MakeStockZero(){            
             
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->stockToZero();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
         }
         
         public function setQuantityToZero(){            
             
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->fix_quantity();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
          public function getQuantity(){            
             
            $this->load->model('fix/script'); 
            $id=$this->request->get["id"];
            $results =  $this->model_fix_script->get_quantity($id);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function stockEntry(){            
             
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->fix_Stock();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function fixCategory(){            
             
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->fix_category();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
          public function writeVendor(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->get_vendors();                    
            
            $list = array();
            foreach ($results as $result) {
                $list[] = array($result['vendor_id'],$result['vendor_name'],$result['vendor_balance']);
            }
            $file = fopen(DIR_UPLOAD."_vendor_.csv","w");

            foreach ($list as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         public function writeItems(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->get_items_write();                    
            
            $list = array();
            foreach ($results as $result) {
                $list[] = array($result['item_id'],$result['item_name'],$result['item_qty'],$result['item_sale_price'],$result['item_purchase_price']);
            }
            $file = fopen(DIR_UPLOAD."_items_.csv","w");

            foreach ($list as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         
          public function importVendorBalance(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_vendor_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->createupdatevendor($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function writeAccounts(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getAccounts();                    
            
            $list = array();
            foreach ($results as $result) {
                $list[] = array($result['acc_id'],$result['acc_type_id'],$result['acc_name'],$result['acc_balance']);
            }
            $file = fopen(DIR_UPLOAD."_account_.csv","w");

            foreach ($list as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
          public function importAccountBalances(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_account_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->createupdateaccounts($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         
         public function writeCustomer(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->get_customers();                    
            
            $list = array();
            foreach ($results as $result) {
                $list[] = array($result['customer_id'],$result['customer_name'],round($result['customer_balance'], 2));
            }
            $file = fopen(DIR_UPLOAD."_customer_.csv","w");

            foreach ($list as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function writeCustomerByGroupID(){
            $this->load->model('fix/script'); 
            $groupID = '8';
            $results= $this->model_fix_script->get_customersByGroupID($groupID);                    
            
            $list = array();
            foreach ($results as $result) {
                $list[] = array($result['customer_id'],$result['customer_name'],$result['customer_balance']);
            }
            $file = fopen(DIR_UPLOAD."_customer_.csv","w");

            foreach ($list as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function importCustBalance(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_customer_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->createupdatecustomer($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         public function importCustBalanceByGroupID(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_customer_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->createupdatecustomerByGroupID($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
          public function writeStock(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->get_items();                    
            
            $list = array();
            foreach ($results as $result) {
                $list[] = array($result['id'],$result['item_name'], $result['normal_price'], $result['sale_price']);
            }
            $file = fopen(DIR_UPLOAD."_items_.csv","w");

            foreach ($list as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }

         public function importItemStock(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_items_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->updateitems($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function updateItemPrices(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_items_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->updateprices($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function importDB(){            
             
            $this->load->model('fix/script'); 
            $this->model_fix_script->importDB(DIR_UPLOAD);                    
            
            
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
          public function makeZero(){   
              $this->load->model('fix/script'); 
              $results= $this->model_fix_script->makezero();  
              
              $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
              $this->children = array();             
              // Render final out put to view.    
              $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
          }
          
          public function checkMissingSOInvoice(){   
              $this->load->model('fix/script'); 
              $results= $this->model_fix_script->missingSOInvoice();  
              
              $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
              $this->children = array();             
              // Render final out put to view.    
              $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
          }
          
          public function checkMissingPOInvoice(){   
              $this->load->model('fix/script'); 
              $results= $this->model_fix_script->missingPOInvoice();  
              
              $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
              $this->children = array();             
              // Render final out put to view.    
              $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
          }
          
          public function fixRegister(){   
              $this->load->model('fix/script'); 
              $results= $this->model_fix_script->fixRegister();  
              
              $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
              $this->children = array();             
              // Render final out put to view.    
              $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
          }
          
          public function pandlfix(){   
              $this->load->model('fix/script'); 
              $results= $this->model_fix_script->pandlfix();  
              
              $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
              $this->children = array();             
              // Render final out put to view.    
              $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
          }
          
          public function writeItemsWithZeroPurchase(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->get_items_zero_purchase();                    
                       
            $file = fopen(DIR_UPLOAD."_zeropurchase_.csv","w");

            foreach ($results as $r){
                fputcsv($file, $r);    
            }
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }                 
         
         public function sendInvitation(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->sendMessages();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function getMissingSaleInvoices(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getSaleInvoiceId();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function fixSaleReturnDiscount(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->fixSaleReturnDiscount();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function getSaleDifference(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getSaleDifference();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function getMissingPOFromJournal(){ 
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getPOJournalEnteries();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         public function getMissingPOFromPOtable(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getPurchaseInvoiceId();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function updateCustomerAccount(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->updateCustomerAccount();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
          public function getPOSDates(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getPOSDateDiffernce();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
          public function getMissingJournalEntry(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getMissingJournalEntry();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
          
          public function removeUnPurchasedItems(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."_zeropurchase_.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->removeItems($result);                    
               }
              }

            fclose($file);
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function getCashTrasnferedAccount (){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getCashTrasnferedAccount();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
         }
         
         public function fixDiscountSaleReturn(){
             $this->load->model('fix/script'); 
            $results= $this->model_fix_script->fixDiscountSaleReturn();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
         }
         public function fixDiscountPOS(){
             $this->load->model('fix/script'); 
            $results= $this->model_fix_script->fixDiscountPOS();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
         }
         
         public function createVendorAccounts(){
             $this->load->model('fix/script'); 
            $results= $this->model_fix_script->createVendorAccounts();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
         }
         
         public function importItemsFromVendorReport(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->importItems();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }

         
          public function importReceivable(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->importReceivable();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function importPayableAsVendors(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->importPayableAsVendors();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function generateFiveBarcode(){            
             
            $this->load->model('fix/script'); 
            $results =  $this->model_fix_script->generate_five_barcode();
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));		
         }
         
          public function changeDiscountJournal(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->changeDiscountJournal();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function updaeSaleDateDifference(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->updaeSaleDateDifference();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function fixBarCodes(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->fixBarCodes();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         public function noBarcodes(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->noBarcodes();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function getSumofCost(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getSumofCost();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         public function compareResults(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->compareResults();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         public function getCOCGSDiff(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->getCOCGSDiff();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function createCustomerAccounts(){
             $this->load->model('fix/script'); 
            $results= $this->model_fix_script->createCustomerAccounts();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
         }
         
         public function updatePurchasePrice(){
             $this->load->model('fix/script'); 
            $results= $this->model_fix_script->updatePurchasePrice();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
         }
         
         public function importZamZamStock(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."pos_invoice_detail.csv","r");

            while(! feof($file))
              {
               $result = fgetcsv($file);
               if($result[0]!=""){                    
                    $this->model_fix_script->insert_item($result);                    
               }
              }

            fclose($file);
            $this->model_fix_script->remove_table($result);                    
            
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function createPOZamZam(){            
             
            $this->load->model('fix/script'); 
            $file = fopen(DIR_UPLOAD."pos_invoice_detail.csv","r");
            $this->model_fix_script->insert_po($file);                    
                                  
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();             
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
         }
         
         public function comparePOANDJournal(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->changedAvgCost();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function keepInProcessInvoices(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->keepInProcessInvoices();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
         
         public function reNumberInvoices(){
            $this->load->model('fix/script'); 
            $results= $this->model_fix_script->reNumberInvoices();                    
                                               
            $this->template = $this->config->get('config_template') . '/template/fix/script.tpl';
            $this->children = array();                        
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
            
         }
}
?>
