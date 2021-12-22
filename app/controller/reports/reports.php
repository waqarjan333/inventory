<?php
class ControllerReportsReports extends Controller {
  private $error = array(); 
  public function index() {
    $this->load->language('dashboard/reports');
           if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
           }
           
           $this->data['get_VendorWiseSaleReport'] = HTTP_SERVER.'index.php?route=reports/reports/get_VendorWiseSaleReport';
           $this->data['get_url_report'] = HTTP_SERVER.'index.php?route=reports/reports/getreport';
           $this->data['get_url_category_wise_report'] = HTTP_SERVER.'index.php?route=reports/reports/CatWiseSummaryReport';
           $this->data['get_url_daily_sale_report'] = HTTP_SERVER.'index.php?route=reports/reports/DailySaleReport';
           $this->data['get_url_Returnreport'] = HTTP_SERVER.'index.php?route=reports/reports/getReturnreport';
           $this->data['get_url_rep_report'] = HTTP_SERVER.'index.php?route=reports/reports/getRepreport';
           $this->data['get_url_usersale_report'] = HTTP_SERVER.'index.php?route=reports/reports/getUserSalereport';
           $this->data['get_url_inventory_summary_report'] = HTTP_SERVER.'index.php?route=reports/reports/getInventorySummaryReprot';
           $this->data['get_url_inventory_detail_report'] = HTTP_SERVER.'index.php?route=reports/reports/getItemDetailReprot';
           $this->data['get_url_inventory_valuation_detail'] = HTTP_SERVER.'index.php?route=reports/reports/getInventoryValuation';
           $this->data['get_url_sale_by_customer_report']= HTTP_SERVER.'index.php?route=reports/reports/getSaleByCustomer';
           $this->data['get_url_account_receivable_detail']= HTTP_SERVER.'index.php?route=reports/reports/getAccountReceivable';
           $this->data['get_url_get_ownership_detail']= HTTP_SERVER.'index.php?route=reports/reports/getOwnerShip';
           $this->data['get_url_get_sales_order_summary']= HTTP_SERVER.'index.php?route=reports/reports/getSalesOrderSummary';
           $this->data['get_url_sale_inventory_summary']= HTTP_SERVER.'index.php?route=reports/reports/getInventoryReport';
           $this->data['get_url_low_inventory']= HTTP_SERVER.'index.php?route=reports/reports/getLowStockReport';
           $this->data['get_url_sale_by_region_report']= HTTP_SERVER.'index.php?route=reports/reports/getSaleSummaryRegion';
           $this->data['get_url_sale_by_invoices_profit']= HTTP_SERVER.'index.php?route=reports/reports/getSaleByInvoicesProfit';
           $this->data['get_url_account_payable_detail']= HTTP_SERVER.'index.php?route=reports/reports/getAccountPayable';
           $this->data['get_url_customers']= HTTP_SERVER.'index.php?route=reports/reports/getCustomers';
           $this->data['get_url_cashregister'] = HTTP_SERVER.'index.php?route=reports/reports/getRegisterReport';
           $this->data['get_url_vendor_register'] = HTTP_SERVER.'index.php?route=reports/reports/getVendorRegisterReport';
           $this->data['get_url_incomestatment'] = HTTP_SERVER.'index.php?route=reports/reports/incomestatment';
           $this->data['get_url_sale_by_customer_item_report']= HTTP_SERVER.'index.php?route=reports/reports/getSaleByCustomerItem';
           $this->data['get_url_vendor_transaction_summary']= HTTP_SERVER.'index.php?route=reports/reports/getVendorTransSummary';
           $this->data['get_url_vendor_payment_summary']= HTTP_SERVER.'index.php?route=reports/reports/getVendorPaymentSummary';
           $this->data['get_url_purchase_order_summary']= HTTP_SERVER.'index.php?route=reports/reports/getPurchaseOrderSummary';
           $this->data['get_url_vendor_wise_sale_report']= HTTP_SERVER.'index.php?route=reports/reports/getVendorWiseSaleReport';
           $this->data['get_url_loan_pay_reciev_detail']= HTTP_SERVER.'index.php?route=reports/reports/getLoanPayReciev';
           $this->data['get_url_amount_recieved_expense_saleRep']= HTTP_SERVER.'index.php?route=reports/reports/getAmountRecievExpenseSaleRep';
           $this->data['get_url_vendor']= HTTP_SERVER.'index.php?route=reports/reports/getVendors';
           $this->data['get_url_cust_transaction_summary']= HTTP_SERVER.'index.php?route=reports/reports/getCustomerTransSummary';
           $this->data['get_url_expensereport']= HTTP_SERVER.'index.php?route=reports/reports/getexpensereport';
           $this->data['get_url_stocktransfer']= HTTP_SERVER.'index.php?route=reports/reports/getstocktransfer';
           $this->data['get_url_stockreorderingreport']= HTTP_SERVER.'index.php?route=reports/reports/getreorderingpoint';
           $this->data['get_url_cust_anging_report']= HTTP_SERVER.'index.php?route=reports/reports/getCustomerAging';
           $this->data['get_url_vendor_anging_report']= HTTP_SERVER.'index.php?route=reports/reports/getVendorAging';
           $this->data['get_url_item_list']= HTTP_SERVER.'index.php?route=reports/reports/getItemList';
           $this->data['getAssetAccountRecord']= HTTP_SERVER.'index.php?route=reports/reports/getAssetAccountRecord';
           $this->data['getPurchaseSummaryReport']= HTTP_SERVER.'index.php?route=reports/reports/getPurchaseSummaryReport';
           $this->data['getPurchaseReport']= HTTP_SERVER.'index.php?route=reports/reports/getPurchaseReport';
           $this->data['getPurchaseReturnReport']= HTTP_SERVER.'index.php?route=reports/reports/getPurchaseReturnReport';
           $this->data['getSaleReturnReport']= HTTP_SERVER.'index.php?route=reports/reports/getSaleReturnReport';
           $this->data['getItemSaleDetail']= HTTP_SERVER.'index.php?route=reports/reports/getItemSaleDetail';
           $this->data['getSaleRepCollection']= HTTP_SERVER.'index.php?route=reports/reports/getSaleRepCollection';
           $this->data['getDailySaleCashRecieve']= HTTP_SERVER.'index.php?route=reports/reports/getDailySaleCashRecieve';
           $this->data['getCashBalance']= HTTP_SERVER.'index.php?route=reports/reports/getCashBalance';
           $this->data['getExpenses']= HTTP_SERVER.'index.php?route=reports/reports/getExpenses';
           
           $this->data['get_url'] = HTTP_SERVER;
           

           
           if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/reports/sale_reports.tpl')) { 
                    $this->template = $this->config->get('config_template') . '/template/reports/sale_reports.tpl';
            } else {
                    $this->template = 'default/template/login/login.tpl';
            } 

              //Column Heading
            $this->data['text_report_printed'] = $this->language->get('text_report_printed');
            $this->data['text_start_date'] = $this->language->get('text_start_date');
            $this->data['text_end_date'] = $this->language->get('text_end_date');
            $this->data['text_no_record_found'] = $this->language->get('text_no_record_found');
            
            $this->data['text_total'] = $this->language->get('text_total');
            $this->data['text_discount_on_invoice'] = $this->language->get('text_discount_on_invoice');
            $this->data['text_grand_total'] = $this->language->get('text_grand_total');
            $this->data['text_sale_return'] = $this->language->get('text_sale_return');
            $this->data['text_net_total'] = $this->language->get('text_net_total');
            $this->data['text_deduction'] = $this->language->get('text_deduction');
            
            $this->data['text_date'] = $this->language->get('text_date');
            $this->data['text_no_of_invoice'] = $this->language->get('text_no_of_invoice');
            $this->data['text_sold_quantities'] = $this->language->get('text_sold_quantities');
            $this->data['text_amount'] = $this->language->get('text_amount');
            $this->data['text_total_sale'] = $this->language->get('text_total_sale');
            $this->data['text_cat_name'] = $this->language->get('text_cat_name');
            
            $this->data['text_s_no'] = $this->language->get('text_s_no');
            $this->data['text_unit'] = $this->language->get('text_unit');
            $this->data['text_from_warehouse'] = $this->language->get('text_from_warehouse');
            $this->data['text_to_warehouse'] = $this->language->get('text_to_warehouse');
            
            $this->data['text_last_vendor'] = $this->language->get('text_last_vendor');
            $this->data['text_current_qty'] = $this->language->get('text_current_qty');
            $this->data['text_reordering_point'] = $this->language->get('text_reordering_point');
            $this->data['text_unit_price'] = $this->language->get('text_unit_price');
            $this->data['text_total_qty'] = $this->language->get('text_total_qty');
            
            $this->data['text_user_id'] = $this->language->get('text_user_id');
            $this->data['text_user_name'] = $this->language->get('text_user_name');
            $this->data['text_net_sale'] = $this->language->get('text_net_sale');
            
            $this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
            $this->data['text_customer_name'] = $this->language->get('text_customer_name');
            
            $this->data['text_paid'] = $this->language->get('text_paid');
            $this->data['text_balance'] = $this->language->get('text_balance');
            
            $this->data['text_warehouse'] = $this->language->get('text_warehouse');
            $this->data['text_qty_diffrence'] = $this->language->get('text_qty_diffrence');
            
            $this->data['text_name'] = $this->language->get('text_name');
            $this->data['text_avg_cost'] = $this->language->get('text_avg_cost');
            
            $this->data['text_barcode'] = $this->language->get('text_barcode');
            $this->data['text_on_hand'] = $this->language->get('text_on_hand');
            $this->data['text_assets_value'] = $this->language->get('text_assets_value');
            $this->data['text_retail_value'] = $this->language->get('text_retail_value');
            
            $this->data['text_opening_balance'] = $this->language->get('text_opening_balance');
            $this->data['text_region'] = $this->language->get('text_region');
            $this->data['text_mobile'] = $this->language->get('text_mobile');
            $this->data['text_phone'] = $this->language->get('text_phone');
            $this->data['text_credit_limit'] = $this->language->get('text_credit_limit');
            $this->data['text_over_limit'] = $this->language->get('text_over_limit');
            
            
            $this->data['text_product'] = $this->language->get('text_product');
            $this->data['text_qty'] = $this->language->get('text_qty');
            $this->data['text_sale_price'] = $this->language->get('text_sale_price');
            $this->data['text_discount'] = $this->language->get('text_discount');
            $this->data['text_net_price'] = $this->language->get('text_net_price');
            $this->data['text_sub_total'] = $this->language->get('text_sub_total');
            $this->data['text_sale'] = $this->language->get('text_sale');
            $this->data['text_cost'] = $this->language->get('text_cost');
            $this->data['text_avg_cogs'] = $this->language->get('text_avg_cogs');
            $this->data['text_revenue'] = $this->language->get('text_revenue');
            $this->data['text_revenue_per'] = $this->language->get('text_revenue_per');
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  }
        
        public function getreport(){
             error_reporting(0);
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = $post_data['report_id'];
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['print_category_report'] = $post_data['print_category_report'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  $report_lines =  $this->model_reports_reports->sale_report($post_data);
                  $category = "";
                  $category1 = "";
                  $category_qty = $category_sale = $category_discount = $category_sales = $category_cost = $category_revenue = 0;
                  $warehouse_qty = $warehouse_sale = $warehouse_discount = $warehouse_sales = $warehouse_cost = $warehouse_revenue = 0;
                  $total_qty = $total_sale = $total_discount = $total_sales = $total_cost = $total_revenue = 0;
                  $qty = $s_qty=$sale = $discount = $sales = $cost = $revenue = 0;
                  $warehouses='';
                  $service='';
                  $m_cat='';
                  $result_cat='';
                  $sub1='';
                  $no=1;
                  $netreturn=0;$convqty=0;
                  foreach ($report_lines as $result) {


                      if($category!=$result['category']){

                         if($category_sales!=0){
                            $report['records'][]      = array( 
                                 'cat_total'          =>$category,   
                                 'category_qty'       => number_format($category_qty,2,'.',''),   
                                 'category_sale'      => number_format($category_sale,2,'.',''),
                                 'category_discount'  =>number_format($category_discount,2,'.',''),
                                 'category_sales'     =>number_format($category_sales,2,'.',''),                         
                                 'category_cost'      =>number_format($category_cost,2,'.',''),                         
                                 'category_revenue'   =>number_format($category_revenue,2,'.',''),                           
                                 'is_type'            => 'cat_total'
                              );

                            $category_qty = $category_sale = $category_discount = $category_sales = $category_cost = $category_revenue = 0;
                         }
                             $category = $result['category'];
                      }

                        if($warehouses !=$result['warehouse'])
                        {

                          if($warehouse_qty !=0)
                          {                          
                            
                             $report['records'][]      = array( 
                                   'ware_total'          =>$warehouses,   
                                   'warehouse_qty'       => number_format($warehouse_qty,2,'.',''),   
                                   'warehouse_sale'      => number_format($warehouse_sale,2,'.',''),
                                   'warehouse_discount'  =>number_format($warehouse_discount,2,'.',''),
                                   'warehouse_sales'     =>number_format($warehouse_sales,2,'.',''),                         
                                   'warehouse_cost'      =>number_format($warehouse_cost,2,'.',''),                         
                                   'warehouse_revenue'   =>number_format($warehouse_revenue,2,'.',''),                           
                                   'is_type'            => 'ware_total'
                              );                            
                              $warehouse_qty = $warehouse_sale = $warehouse_discount = $warehouse_sales = $warehouse_cost = $warehouse_revenue = 0;                            
                        
                        
                          }

                         $warehouses=$result['warehouse'];
                          $report['records'][]= array('warehouse' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           ); 
                         
                          
                           
                        }   

                          
                            if($category1!=$result['category']){
                              $category1 = $result['category'];

                          $report['records'][] = array( 
                           'category_name' =>$category1,                         
                           'is_type'       => 'category'
                          );
                        }
                          if($service !=$result['type'])
                              {
                                $service=$result['type'];
                                   if($service==1)
                            {

                          $report['records'][]= array('service' =>'Inventory' ,
                                                      'is_type'       =>'service'
                           );
                            }
                            else{
                              $report['records'][]= array('service' =>'Service' ,
                                                      'is_type'       =>'service'
                           );
                            }
                              }
                        
                          
                          // $cat_change = true; 
                          
                      
                     $qty      = $result['qty'];
                     $s_qty      = $result['s_qty'];
                     $sale     = $result['sale'];
                     $discount =  $result['discount'];
                     $sales    = $result['sale']-$discount;
                     $cost     = $result['item_cost']/$s_qty;
                     $cost1     = $cost*$s_qty;
                     $revenue  = $sales-$cost1;
                      $margin = $sales-$cost1;
                 if($cost1>"0"){
                      if($sales>0)
                      {
                         $per = ($margin/$sales) * 100; 
                      }
                      else{
                         $per = ($margin/1) * 100; 
                      }
                    
                  } else { 
                     $per = ($margin/1) * 100; 
                  }
                     //print_r($result['product']);exit();
                     if($s_qty!=="0"){
                      if($post_data['show_in_coton']==true)
                      {
                         $convfrom=$this->model_reports_reports->get_last_convfrom($result['id']);
                         if($convfrom==0)
                         {
                           $convqty=$s_qty;
                         }
                         else{
                           $convqty=$s_qty/$convfrom;
                         }
                       
                      }
                      else{
                        $convqty=$s_qty;
                      }
                       
                        $report['records'][]   = array( 
                              'count'   => $no,
                              'item_id'        => $result['item_id'],
                              'product_name'   => $result['product'],
                              'qty'            => number_format($convqty,2,'.',''),
                              'sale'           => number_format($sale,2,'.',''),
                              'discount'       => number_format($discount,2,'.',''),                      
                              'sales'          =>  number_format($sales,2,'.',''), 
                              'cost'           =>  number_format($cost1,2,'.',''),
                              'avg_cogs'           =>  number_format($cost,2,'.',''),
                              'revenue'        => number_format($revenue,2,'.',''),
                              'revenue_percent'        => number_format($per,1,'.',''),
                              'is_type'        => 'product'
                         );
                     }
                     $no=$no+1;
                     $category_qty       = $category_qty + $convqty;
                     $category_sale      = $category_sale + $sale;
                     $category_discount  = $category_discount + $discount;
                     $category_sales     = $category_sales + $sales;
                     $category_cost      = $category_cost + $cost1;
                     $category_revenue   = $category_revenue + $revenue;

                      $warehouse_qty = $warehouse_qty + $convqty;
                     $warehouse_sale = $warehouse_sale + $sale;
                     $warehouse_discount = $warehouse_discount + $discount;
                      $warehouse_sales     = $warehouse_sales + $sales;
                     $warehouse_cost      = $warehouse_revenue + $cost1;
                     $warehouse_revenue   = $warehouse_revenue + $revenue;
                      
                     $total_qty          = $total_qty + $convqty;
                     $total_sale         = $total_sale + $sale;
                     $total_discount     = $total_discount + $discount;
                     $total_sales        = $total_sales + $sales;
                     $total_cost         = $total_cost + $cost1;
                     $total_revenue      = $total_revenue + $revenue;
                    }
                          $report['records'][]      = array( 
                                   'cat_total'          =>$category,   
                                   'category_qty'       => number_format($category_qty,2,'.',''),   
                                   'category_sale'      => number_format($category_sale,2,'.',''),
                                   'category_discount'  =>number_format($category_discount,2,'.',''),
                                   'category_sales'     =>number_format($category_sales,2,'.',''),                         
                                   'category_cost'      =>number_format($category_cost,2,'.',''),                         
                                   'category_revenue'   =>number_format($category_revenue,2,'.',''),                           
                                   'is_type'            => 'cat_total'
                              );

                  $report['records'][]      = array( 
                         'ware_total'          =>$warehouses,   
                         'warehouse_qty'       => number_format($warehouse_qty,2,'.',''),   
                         'warehouse_sale'      => number_format($warehouse_sale,2,'.',''),
                         'warehouse_discount'  =>number_format($warehouse_discount,2,'.',''),
                         'warehouse_sales'     =>number_format($warehouse_sales,2,'.',''),                         
                         'warehouse_cost'      =>number_format($warehouse_cost,2,'.',''),                         
                         'warehouse_revenue'   =>number_format($warehouse_revenue,2,'.',''),                           
                         'is_type'            => 'ware_total'
                    );
                   
                 $_discount = $this->model_reports_reports->total_discount($post_data);

                 // print_r($_discount);exit;
                 if($_discount!=0){
                  $report['records'][]  = array( 
                    'grand_total'       =>'Discount on Invoice',                    
                    'total_discount'    =>number_format($_discount,2,'.',''),                       
                    'sale_minus'        =>number_format($_discount ,2,'.',''),                       
                    'revenue_minus'     =>number_format($_discount ,2,'.',''),                       
                    'is_type'           => 'total_discount'
                   );
                 }
                 $grand_disc = $total_discount+$_discount;
                 $grand_sale = $total_sales-$_discount;

           

                  $report['records'][]    = array( 
                    'grand_total'         =>'Grand Total',
                    'total_qty'           =>   number_format($total_qty,2,'.',''),
                    'total_sale'          => number_format($total_sale,2,'.',''),
                    'total_disc'          =>number_format($grand_disc,2,'.',''),                         
                    'total_sales'         =>number_format($grand_sale,2,'.',''),                         
                    'total_cost'          =>number_format($total_cost,2,'.',''),                         
                    'total_revenue'       =>number_format($total_revenue-$_discount,2,'.',''),                           
                    'is_type'             => 'total'
                   );
                  $_sale_return = $this->model_reports_reports->total_sale_return($post_data);                  
                  $_sale_return_dis = $this->model_reports_reports->total_sale_return_dis($post_data);
                 if($_sale_return[0]['return_sale']!=0){
                     $ret_disc = $_sale_return[0]['return_discount'];
                     // $ret_disc = $_sale_return[0]['return_discount']+(-1*$_sale_return_dis);
                     $ret_sale = $_sale_return[0]['return_sale'];
                     // $ret_sale = $_sale_return[0]['return_sale']-(-1*$_sale_return_dis);
                     $netreturn=$_sale_return[0]['return_sale']-$ret_disc;

                if($post_data['show_in_coton']==true)
                      {
                         // $convfrom=$this->model_reports_reports->get_last_convfrom($result['id']);
                         if($convfrom==0)
                         {
                           $convqty=$s_qty;
                         }
                         else{
                           $convqty=$s_qty/$convfrom;
                         }
                       
                      }
                      else{
                        $convqty=$s_qty;
                      }   
                        
                  $report['records'][] =      array( 
                    'sale_return'       =>   'Sale Return',                    
                    'return_qty'         =>   number_format($_sale_return[0]['return_qty'],2,'.',''), 
                    'return_discount'    => number_format($ret_disc,2,'.',''),
                    'return_sale'       =>   number_format($_sale_return[0]['return_sale'],2,'.',''),
                    'return_sales'       =>   number_format($netreturn,2,'.',''),                         
                    // 'return_sales'       =>   number_format($_sale_return[0]['return_sales'],2,'.',''),                         
                    'return_cost'       =>    number_format($_sale_return[0]['return_cost'],2,'.',''),
                    'return_revenues'       =>    number_format(-1*((-1*($netreturn))-(-1*$_sale_return[0]['return_cost'])),2,'.',''),
                    'is_type'           =>    'total_return_sale'
                   );
                  
                  $report['records'][] =      array( 
                    'net_sale'       =>   'Net Total',                    
                    'net_qty'         =>   number_format($total_qty-(-1*$_sale_return[0]['return_qty']),2,'.',''),
                    'net_salee'       =>   number_format($total_sale-(-1*$_sale_return[0]['return_sale']),2,'.',''),
                    'net_discount'    => number_format($grand_disc-(-1*$ret_disc),2,'.',''),
                    'net_sales'       =>   number_format($grand_sale-(-1*$netreturn),2,'.',''),                         
                    'net_cost'       =>    number_format($total_cost-(-1*$_sale_return[0]['return_cost']),2,'.',''), 
                    'net_revenue'    => number_format($total_revenue,2,'.',''), 
                    'is_type'           =>    'net_total'
                   );
                 }
              }
              
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
        }
        public function CatWiseSummaryReport(){
             
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = $post_data['report_id'];
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  $report_lines =  $this->model_reports_reports->SaleReportCatWise($post_data);
                  $category = "";
                  $cat_sale = $cat_cost = $cat_revenue = $total_revenue = $cat_qty = $total_sale = $total_cost = $total_qty = $_discount =0;
                  
                  foreach ($report_lines as $result) {

                      $revenue = $result['sale'] - $result['item_cost'];
                    
                              $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_qty'       => number_format($cat_qty,2,'.',''),  
                                   'cat_sale'       =>number_format($cat_sale,2,'.',''),
                                   'cat_cost'       =>number_format($cat_cost,2,'.',''),
                                   'cat_revenue'       =>number_format($cat_revenue,2,'.',''),
                                   'is_type'       => 'cat_total'
                              );
                              $cat_sale =$cat_qty= $cat_revenue = 0; 
                         
                         
                          $category = $result['category'];
                          $cat_change = true;
                      
                     
                     
                      $cat_sale = $cat_sale + ($result['sale']-$result['discount']);
                      $cat_cost =  $result['item_cost'];
                      $cat_qty = $cat_qty + $result['s_qty'];
                      $cat_revenue = $cat_revenue + $revenue;
                      $total_sale = $total_sale + ($result['sale']-$result['discount']);
                      $total_cost = $total_cost + $result['item_cost'];
                      $total_qty = $total_qty + $result['s_qty'];
                      $total_revenue = $total_revenue + $revenue;

                  }
                 
                 $report['records'][] = array( 
                        'cat_name'       =>'Total '.$category,   
                        'cat_qty'       => number_format($cat_qty,2,'.',''),  
                        'cat_sale'       =>number_format($cat_sale,2,'.',''),
                        'cat_cost'       =>number_format($cat_cost,2,'.',''),
                        'cat_revenue'       =>number_format($cat_revenue,2,'.',''),
                        'is_type'       => 'cat_total'
                    );
                 $_discount = $this->model_reports_reports->total_discount($post_data);
                 
                 $report['records'][] =      array( 
                    'total_sales'        =>   'Net Total',                    
                    'total_qty'         =>   number_format($total_qty,2,'.',''),
                    'total_sale'        =>   number_format($total_sale-$_discount,2,'.',''),
                    'total_cost'        =>   number_format($total_cost,2,'.',''),
                    'total_revenue'        =>   number_format($total_revenue,2,'.',''),
                    'is_type'         =>    'net_total'
                   );
              }
              
             $report['qty_per'] = number_format($total_qty,2,'.','');
             $report['sale_per'] = number_format($total_sale-$_discount,2,'.','');
             $report['revenue_per'] = number_format($total_revenue,2,'.','');
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
        }
        public function getAmountRecievExpenseSaleRep(){
             $report = array();
             $report_lines;
             $totalRecived = $totalExpense = $TotalremainingBalance = 0;
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];   
                 $report['end_date'] = $post_data['end_date'];
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 
                 $report_lines =  $this->model_reports_reports->getAmountRecievExpenseSaleRep($post_data);
                 
                 $total= 0; $sno='1';
                    foreach ($report_lines as $result) {
                        $remainingBalance = $result['RecivedAmount'] - $result['ExpenseAmount'];
                        if($result['RecivedAmount']!=0 || $result['ExpenseAmount'] !=0){
                            $report['records'][] = array( 
                                'sno'                => $sno,
                                'salRepName'       => $result['saleRepName'],
                                'recieve_amount' => number_format($result['RecivedAmount'],2,'.',','),
                                'expense_amount' => number_format($result['ExpenseAmount'],2,'.',','),
                                'remaining_amount' => number_format($remainingBalance,2,'.',','),
                                'is_type'       => 'amount'                            
                              ); 
                            }
                     $sno = $sno +1;
                     $totalRecived = $totalRecived + $result['RecivedAmount'];
                     $totalExpense = $totalExpense + $result['ExpenseAmount'];
                     $TotalremainingBalance = $TotalremainingBalance + $remainingBalance;
                    }
                      

                    $report['records'][] = array(
                            'title'       =>'Total',
                            'total_recieve_amount'       => number_format($totalRecived,2,'.',''),
                            'total_expense_amount'       => number_format($totalExpense,2,'.',''),
                            'total_remaining_amount'       => number_format($TotalremainingBalance,2,'.',''),
                            'is_type'       => 'total'
                             );
                      
                      
                  
                 }    
                 
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function getReturnreport(){
             
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "101";
                  $report['report_name'] = "Sale Return";
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  $report_lines =  $this->model_reports_reports->sale_Returnreport($post_data);
                  $category = "";
                  $ret_cost = 0;
                  $qty = $sales = $discount = $total_revenue = $sale = $cost = $quantity = $saless = 0;$convqty=0;
             $return_discount=$return_sale=$return_sales = 0;     
            foreach ($report_lines as $result) {

              if($category                !=  $result['category']){
                  
                  $category   =  $result['category'];
                $report['records'][]      =   array( 
                  'return_category_name'  =>  $category,                         
                  'is_type'               =>  'return_category'
                );
                $cat_change               =   true;
              }


              if($result['qty']!=="0"){

               if($post_data['show_in_coton']==true)
                      {
                         $convfrom=$this->model_reports_reports->get_last_convfrom($result['id']);
                         if($convfrom==0)
                         {
                           $convqty=$result['qty'];
                         }
                         else{
                           $convqty=$result['qty']/$convfrom;
                         }
                       
                      }
                      else{
                        $convqty=$result['qty'];
                      } 
                  $returnSalePrice = $result['sale'];
               $saless = $result['sale'] - $result['discount'];
               $report['records'][]    =    array( 
                'return_product_name' =>   $result['product'],
                'return_qty'          =>   number_format($convqty,2,'.',''),
                'return_sale_price'   =>   number_format($returnSalePrice,2,'.',''),
                'return_discount'     =>   number_format(-1*$result['discount'],2,'.',''),
                'return_sale'         =>   number_format($saless,2,'.',''),
                'return_cost'         =>   number_format(-1*$result['cost'],2,'.',''),
                'return_revenue'         =>   number_format($saless-$result['cost'],2,'.',''),
                'is_type'             =>   'return_product'
                );
              }


              $qty = $qty + $convqty;
              $sales = $sales + $returnSalePrice;
              $discount = $discount + (-1*$result['discount']);
              $sale = $sale + $saless;
              $cost = $cost + (-1*$result['cost']);
              $total_revenue = $total_revenue + ($saless - $result['cost']);
            }
           
               $_sale_return_dis = $this->model_reports_reports->total_sale_return_dis($post_data);
                
                  $report['records'][] =      array( 
                    'sale_return'        =>   'Sale Return',                    
                    'return_quantities'         =>   number_format($qty,2,'.',''), 
                    'return_sale_total'  =>   number_format($sales,2,'.',''),
                    'return_discounts'    =>   number_format($discount+$_sale_return_dis,2,'.',''),
                    'return_sales'       =>   number_format($sale-$_sale_return_dis,2,'.',''),                         
                    'return_costs'        =>    number_format($cost,2,'.',''),
                    'return_total_revenue'   =>    number_format($total_revenue-(-1*$_sale_return_dis),2,'.',''),
                    'is_type'            =>    'total_return_sale'
                   );
                  
                }

             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
        // public function DailySaleReport(){
        //      $report = array();
        //      if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
        //           $post_data=$this->request->post;
        //           $this->load->model('reports/reports');
        //           $report['report_id'] = "12";
        //           $report['report_name'] = $post_data['report_name'];
        //           $report['start_date'] = $post_data['start_date'];
        //           $report['end_date'] = $post_data['end_date'];                  
        //           $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
        //           $report_lines =  $this->model_reports_reports->daily_sale_report($post_data);
        //           $total_invoices = $total_qty = $total_amount = $total_days = $quantity = 0;
        //           foreach ($report_lines as $result) {
        //               $date = explode(" ", $result['date']);
        //               $returnData =  $this->model_reports_reports->daily_sale_return_report($date[0]." 00:00:00");
        //               $invoices = $result['invoices'];
        //               $amount = $result['amount']-($returnData['amounts']);
        //               $qty =  $this->model_reports_reports->daily_sale_qty_report($date[0]." 00:00:00");
        //               if(is_float($qty + 0 )){
        //                  $quantity = number_format($qty,2,'.',''); 
        //               } else {
        //                  $quantity = $qty; 
        //               }
        //               $report['records'][] = array( 
        //                 'date'       =>  $date[0],
        //                 'invoices'       =>$invoices,
        //                 'qty'       =>$quantity,
        //                 'amount'       =>number_format($amount,2,'.',''),
        //                 'is_type'       => 'daily'
        //             );
        //             $total_days = $total_days + 1;
        //             $total_invoices = $total_invoices + $invoices;
        //             $total_qty = $total_qty + $quantity;
        //             $total_amount = $total_amount + $amount;
        //           }
                  
        //           $report['records'][] = array( 
        //                 'total_days'       =>'Total ' . $total_days . ' Days',                        
        //                 'total_invoices'       =>$total_invoices,
        //               'total_qty'       =>$total_qty,
        //               'total_amount'       =>number_format($total_amount,2,'.',''),
        //                 'is_type'       => 'total'
        //             );
        //      }    
             
        //      $this->load->library('json');
        //      $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
        //  }
         public function DailySaleReport(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "12";
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];                  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $report_lines =  $this->model_reports_reports->daily_sale_report($post_data);
                  $total_invoices = $total_qty = $total_amount = $total_days = $quantity = 0; 
                  $total_date  ='';$region='';$regions='';$region_qty=0;$regionInvoices=0;
                  foreach ($report_lines as $result) {
                      $date = explode(" ", $result['date']);

                      $returnData =  $this->model_reports_reports->daily_sale_return_report($date[0]." 00:00:00");
                      $invoices = $result['invoices'];
                      $amount = $result['amount'];
                      $qty =  $this->model_reports_reports->daily_sale_qty_report($date[0]." 00:00:00");
                      $total_amount_invoice =  $this->model_reports_reports->total_amount_invoice($invoices);
                     
                          if($region !=$result['region'])
                          {
                             
                            if($region_qty!=0){

                               $report['records'][] = array( 
                        'total_reg'       =>'Total '.$region,
                        'reg_qty'       =>$region_qty,
                        'is_type'       => 'region'
                                );
                      $region_qty=0;$total_days=0;
                               
                            }
                             $region=$result['region'];
                             $reg_invoice=$result['invoices'];
                             // echo $reg_invoice;
                            $report['records'][] = array( 
                        'date'       =>  $date[0],
                        'invoices'       =>$total_amount_invoice['no'],
                        'qty'       =>$result['qty'],
                        'amount'       =>number_format($total_amount_invoice['amount'],2,'.',''),
                        'is_type'       => 'daily'
                    ); 
                          }
                      
                    
                    
                 
                    $total_days = $total_days + 1;
                    $total_invoices = $total_invoices + $result['no'];
                    $total_qty = $total_qty + $result['qty'];
                    $region_qty = $region_qty + $result['qty'];
                    $total_amount = $total_amount + $total_amount_invoice['amount'];
                  }
                       $report['records'][] = array( 
                        'total_reg'       =>'Total '.$region,
                        'reg_qty'       =>$region_qty,
                        'is_type'       => 'region'
                    );
                          
                  $report['records'][] = array( 
                        'total_days'       =>'Total ' . $total_days . ' Days',                        
                        'total_invoices'       =>$total_invoices,
                      'total_qty'       =>$total_qty,
                      'total_amount'       =>number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function getRepreport(){
             $report = array();
             $rep_name = "";
             $cat_name = "";
             $category = "";
             $item_id=0;
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "2";
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];                  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  if($post_data['show_invoice_detail']=='0'){
                    $report['report_name'] = $post_data['report_name'];
                  } else {
                    $report['report_name'] = $post_data['report_name'] . " Summary";    
                  }
                  $category_qty = $category_amount = $representative_qty = $representative_amount = 0;$category_name='';
                  $rep_qty = $rep_amount = $total_qty = $total_amount = 0; 
                  $cat_qty = $cat_amount = 0;
                  $report_lines =  $this->model_reports_reports->sale_rep_report($post_data);
                    foreach ($report_lines as $result) {
                    $cat =  $this->model_reports_reports->sale_rep_report_cat($result['inv_id'],$post_data);
                    
                    $rep_value =   $this->model_reports_reports->sale_rep_report_rep_values($result['inv_id'],$post_data);  
                    foreach ($cat as $category) {
                        
                     
                      if($item_id=$category['item_id']){
                        $item_id=$category['item_id'];
                        
                           if($category_name !=$category['cat_name'])
                      {
                           if($category_amount!=0)
                           {
                             $report['records'][]    = array( 
                              'cat_name'       => 'Total ' . $category_name,
                              'cat_qty'        => $category_qty,
                              'cat_amount'        => number_format(($category_amount),2,'.',''),
                              'is_type'         => 'cat_name'
                         );  
                         
//                         $category_qty=0;$category_amount=0;
                           }
                      $category_qty=0;$category_amount=0; 
                       $category_name=$category['cat_name'];
                      } 
                      
                      }
                       
                    $item =  $this->model_reports_reports->sale_rep_report_item($item_id);
                    $cat_value =  $this->model_reports_reports->sale_rep_report_cat_values($category['item_id'],$result['rep_id']);
                    foreach ($item as $items) {
                      $item_data = $this->model_reports_reports->sale_rep_report_item_data($items['id'],$result['rep_id'],$post_data);
                      $unit_1 = $this->model_reports_reports->sale_rep_units($items['id'],0);
                      $unit_2 = $this->model_reports_reports->sale_rep_units($items['id'],1);
                      $unit_3 = $this->model_reports_reports->sale_rep_units($items['id'],2);
                    
                      if($unit_1>0){
                        $item_unit_1 = number_format(($item_data[0]['qty'] / $unit_1),2,'.',''); 
                      } else {
                        $item_unit_1 = '---';  
                      }
                      
                      if($unit_2>0){
                        $item_unit_2 = number_format(($item_data[0]['qty'] / $unit_2),2,'.',''); 
                      } else {
                        $item_unit_2 = '---';  
                      }
                      
                      
                      if($unit_3>0){
                        $item_unit_3 = number_format(($item_data[0]['qty'] / $unit_3),2,'.',''); 
                      } else {
                        $item_unit_3 = '---';  
                      }
                      $report['records'][]    = array( 
                              'item_name'       => $items['item_name'],
                              'item_qty'        => $item_data[0]['qty'],
                              'item_unit_1'     => $item_unit_1,
                              'item_unit_2'     => $item_unit_2,
                              'item_unit_3'     => $item_unit_3,
                              'item_amount'     => number_format(($item_data[0]['sale']-$item_data[0]['discount']),2,'.',''),
                              'is_type'         => 'item_name'
                         );
                    
//                  
                    $category_qty = $category_qty+ $item_data[0]['qty'];
                    $category_amount = $category_amount + ($item_data[0]['sale']-$item_data[0]['discount']);  
                    $total_qty = $total_qty + $item_data[0]['qty'];
                    $total_amount = $total_amount + ($item_data[0]['sale']-$item_data[0]['discount']);
                    
                    
                      }
                   
                    }
//                    $category_qty=0;$category_amount=0;
                     }
                    $report['records'][]    = array( 
                              'cat_name'       => 'Total ' . $category['cat_name'],
                              'cat_qty'        => $category_qty,
                              // 'cat_amount'        => number_format(($cat_value[0]['sale']-$cat_value[0]['discount']),2,'.',''),
                              'cat_amount'        => number_format(($category_amount),2,'.',''),
                              'is_type'         => 'cat_name'
                         );
                  $report['records'][]    = array( 
                              'rep_name'       => 'Total ' . $result['rep_name'],
                              'rep_qty'        => $rep_value[0]['qty'],
                              'rep_amount'        => number_format(($rep_value[0]['sale']-$rep_value[0]['discount']),2,'.',''),
                              'is_type'         => 'rep_name'
                         );   
                $report['records'][]    = array( 
                              'total_name'       => 'Total ',
                              'total_qty'        => $total_qty,
                              'total_amount'        => number_format($total_amount,2,'.',''),
                              'is_type'         => 'total'
                         );    
             }    
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         
         public  function getUserSalereport(){
              $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "6";
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];                  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  if($post_data['product_id']!="" || $post_data['category_id']!=""){
                      $report_lines =  $this->model_reports_reports->sale_user_item_report($post_data);
                      
                  } else {
                      $report_lines =  $this->model_reports_reports->sale_user_report($post_data);
                  }
                  
                  $total_sales = 0;
                  $total_sales_return = 0;
                  $net_sale_total = 0;
                  foreach ($report_lines as $result) {
                      $sale = $result['sale'];
                      $sale_return = $result['sale_return'];
                      $net_sale=$sale+$sale_return;
                      $report['records'][] = array( 
                        'user_id'       =>$result['user_id'],
                        'user_name'       =>$result['username'],
                        'sales'       =>number_format($sale,2,'.',''),
                        'sales_return'       =>number_format($sale_return,2,'.',''),
                        'net_sale'       =>number_format($net_sale,2,'.',''),
                        'is_type'       => 'entry'
                    );
                    $total_sales = $total_sales + $sale;
                    $total_sales_return = $total_sales_return + $sale_return;
                    $net_sale_total = $net_sale_total + $net_sale;
                  }
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_sales'       =>number_format($total_sales,2,'.',''),
                        'total_sales_return' =>number_format($total_sales_return,2,'.',''),
                        'net_sale_total' =>number_format($net_sale_total,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function getInventorySummaryReprot(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];  
                 $warehouse=$post_data['warehouse'];                
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 // $report_lines =  $this->model_reports_reports->get_inventory_items($post_data);
                
                  $report_lines =  $this->model_reports_reports->get_warehouse_items_qty($post_data);
                 
                 
                 $category = "";
                 $warehouse_name='';
                 $item_name='';
                 $warehouses="";
                 $category_qty = $category_asset_value = $category_retail_value=0;
                 $warehouse_qty = $warehouse_asset_value = $warehouse_retail_value=0;
                 $total_qty = $total_asset_value=$total_retail_value=0;$totalRetail=0;$totalAsset=0;$fixSaleValue=0;$fixAssetValue=0;$category_totalAsset_value=0;
                 $qty='';$category_totalRetail_value=0;$netTotalAsset=0;$netTotalRetail=0;
                 $below_zero=$post_data['below_zero_quantity']; 
                 foreach ($report_lines as $result) {
                  $qty=$result['qty'];
                  

                    
                      if($category!=$result['category']){
                        if($below_zero==0)
                        {
                          $below=$category_qty>0;
                        }else{
                          $below=$category_qty!=0;                          
                        }

                          if($below){                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$category,   
                                  'cat_qty'       => number_format($category_qty,2,'.',''),                                     
                                  'cat_asset_value'       =>number_format($category_asset_value,2,'.',''),                         
                                  'cat_retail_value'       =>number_format($category_retail_value,2,'.',''),                                                           
                                  'cat_totalretail_value'       =>number_format($category_totalRetail_value,2,'.',''),                                                           
                                  'cat_totalasset_value'       =>number_format($category_totalAsset_value,2,'.',''),                                                           
                                  'is_type'       => 'cat_total'
                             );                            
                             $category_qty = $category_asset_value = $category_retail_value=$category_totalRetail_value=$category_totalAsset_value=0;                             
                        }
                        
                        $category = $result['category'];
                        if($post_data['print_category_report']=='0'){
                           if($below){
                            $report['records'][] = array( 
                              'category_id'       =>$result['category_id'],    
                             'category_name'       =>$category,                         
                             'is_type'       => 'category'
                           );  }
                        }
                     }
                     // $get_purchase = array('item_id' => $result['id'],
                     //                       'post_data'=>$post_data  );
                     //  $purchase_qty = $this->model_reports_reports->get_purchase_items($get_purchase);
                     
                     if($post_data['report_id']==31){
                         if($below_zero==0)
                        {
                          $below=$qty>0;
                        }else{
                          $below=$qty!='';                     
                        }
                        if($below){

                           if($warehouses !=$result['w_name'])
                        {

                          if($warehouse_qty !=0)
                          {                          
                             $report['records'][] = array( 
                                  'ware_total'       =>'Total '.$warehouses,   
                                  'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                  'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                  'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                  'is_type'       => 'ware_total'
                             );                            
                             $warehouse_qty = $warehouse_asset_value = $warehouse_retail_value=0;                             
                        
                        
                          }

                         $warehouses=$result['w_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }
                         if($post_data['show_in_coton']==true)
                      {
                        $convfrom=$this->model_reports_reports->get_last_convfrom($result['id']);
                          
                         if($convfrom==0)
                         {
                           $convqty=$qty;
                         }
                         else{
                           $convqty=$qty/$convfrom;
                         }
                      }
                      else{
                        $convqty=$qty;
                      }
                     
                         $fixAssetValue=$result['avg_cost']*$qty;
                          $fixSaleValue=$result['sale_price']*$qty;
                           if($qty>0)
                      {
                        $totalAssetRetail=$this->model_reports_reports->get_totalAssetRetailValue();
                        $totalRetail=($fixSaleValue / $totalAssetRetail['sprice']*100);
                        $totalAsset=($fixAssetValue / $totalAssetRetail['cost']*100);
                        // $totalAsset=$totalAsset+($result['avg_cost']*$qty);
                      }
                      else{
                        $totalRetail=0;
                        $totalAsset=0;
                      }

                            // if($post_data['print_category_report']=='0'){
                       
                           $report['records'][] = array( 
                             'item_id'       =>$result['id'],
                             'item_name'       =>$result['item_name'],
                             'item_barcode'       =>$result['item_code'],
                             'item_qty'       =>number_format($convqty,2,'.',''),
                             'item_avg_cost'       =>number_format($result['avg_cost'],2,'.',''),
                             'item_sale_price'       =>number_format($result['sale_price'],2,'.',''),
                             'item_asset_value'      => number_format($fixAssetValue,2,'.',''),
                             'item_percent_asset_value'      => number_format($totalAsset,1,'.',''),
                             'item_retail_value'      => number_format($fixSaleValue,2,'.',''),
                             'item_percent_retail_value'      => number_format($totalRetail,1,'.',''),
                             'is_type'       => 'entry'
                            );  //}
                             $category_qty = $category_qty + $convqty;
                             $category_asset_value = $category_asset_value + ($result['avg_cost']*$qty);
                             $category_retail_value = $category_retail_value + ($result['sale_price']*$qty);
                             $category_totalAsset_value = $category_totalAsset_value + $totalAsset;
                             $category_totalRetail_value = $category_totalRetail_value + $totalRetail;

                             //warehouse total
                             $warehouse_qty = $warehouse_qty + $convqty;
                             $warehouse_asset_value = $warehouse_asset_value + ($result['avg_cost']*$qty);
                             $warehouse_retail_value = $warehouse_retail_value + ($result['sale_price']*$qty);

                             $total_qty = $total_qty + $convqty;
                             $total_asset_value = $total_asset_value +($result['avg_cost']*$qty);
                             $total_retail_value = $total_retail_value + ($result['sale_price']*$qty);
                              $netTotalAsset = $netTotalAsset + $totalAsset;
                             $netTotalRetail = $netTotalRetail + $totalRetail;
                             // $warehouses=$warehouse_name;

                         }
                     }
                    else if($post_data['report_id']==60){
                         if($below_zero==0)
                        {
                          $below=$qty>0;
                        }else{
                          $below=$qty!=0;                     
                        }


                           //if($qty!=0){

                              if($warehouses !=$result['w_name'])
                        {

                          if($warehouse_qty !=0)
                          {                          
                             $report['records'][] = array( 
                                  'ware_total'       =>'Total '.$warehouses,   
                                  'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                  'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                  'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                  'is_type'       => 'ware_total'
                             );                            
                             $warehouse_qty = $warehouse_asset_value = $warehouse_retail_value=0;                             
                        
                        
                          }

                         $warehouses=$result['w_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }
                            if($post_data['show_in_coton']==true)
                      {
                        $convfrom=$this->model_reports_reports->get_last_convfrom($result['id']);
                        if($convfrom==0)
                         {
                           $convqty=$qty;
                         }
                         else{
                           $convqty=$qty/$convfrom;
                         }
                      }
                      else{
                        $convqty=$qty;
                      }
                           $report['records'][] = array( 
                             'item_id'       =>$result['id'],
                             'item_name'       =>$result['item_name'],
                             'warehouse'       =>$result['w_name'],
                             'item_barcode'       =>$result['item_code'],
                             'item_qty'       =>number_format($convqty,2,'.',''),
                             'item_avg_cost'       =>number_format($result['avg_cost'],2,'.',''),
                             'item_sale_price'       =>number_format($result['sale_price'],2,'.',''),
                             'item_asset_value'      => number_format($result['avg_cost']*$qty,2,'.',''),
                             'item_retail_value'      => number_format($result['sale_price']*$qty,2,'.',''),
                             'is_type'       => 'entry'
                           );  
                             $category_qty = $category_qty + $convqty;
                             $category_asset_value = $category_asset_value + ($result['avg_cost']*$qty);
                             $category_retail_value = $category_retail_value + ($result['sale_price']*$qty);

                                 //warehouse total
                             $warehouse_qty = $warehouse_qty + $convqty;
                             $warehouse_asset_value = $warehouse_asset_value + ($result['avg_cost']*$qty);
                             $warehouse_retail_value = $warehouse_retail_value + ($result['sale_price']*$qty);

                             $total_qty = $total_qty + $convqty;
                             $total_asset_value = $total_asset_value +($result['avg_cost']*$qty);
                             $total_retail_value = $total_retail_value + ($result['sale_price']*$qty);
                             // }
                     }
                     
                     else if($post_data['report_id']==37){
                         if($qty<0){

                                if($warehouses !=$result['w_name'])
                        {

                          if($warehouse_qty !=0)
                          {                          
                             $report['records'][] = array( 
                                  'ware_total'       =>'Total '.$warehouses,   
                                  'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                  'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                  'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                  'is_type'       => 'ware_total'
                             );                            
                             $warehouse_qty = $warehouse_asset_value = $warehouse_retail_value=0;                             
                        
                        
                          }

                         $warehouses=$result['w_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }


                           $report['records'][] = array( 
                             'item_id'       =>$result['id'],
                             'item_name'       =>$result['item_name'],
                              'warehouse'       =>$result['w_name'],
                             'item_barcode'       =>$result['item_code'],
                             'item_qty'       =>number_format($qty,2,'.',''),
                             'item_avg_cost'       =>number_format($result['avg_cost'],2,'.',''),
                             'item_sale_price'       =>number_format($result['sale_price']*$qty,2,'.',''),
                             'item_asset_value'      => number_format($result['avg_cost']*$qty,2,'.',''),
                             'item_retail_value'      => number_format($result['sale_price']*$qty,2,'.',''),
                             'is_type'       => 'entry'
                           );  
                             $category_qty = $category_qty + $qty;
                             $category_asset_value = $category_asset_value + ($result['avg_cost']*$qty);
                             $category_retail_value = $category_retail_value + ($result['sale_price']*$qty);
                                 //warehouse total
                             $warehouse_qty = $warehouse_qty + $qty;
                             $warehouse_asset_value = $warehouse_asset_value + ($result['avg_cost']*$qty);
                             $warehouse_retail_value = $warehouse_retail_value + ($result['sale_price']*$qty);

                             $total_qty = $total_qty + $qty;
                             $total_asset_value = $total_asset_value +($result['avg_cost']*$qty);
                             $total_retail_value = $total_retail_value + ($result['sale_price']*$qty);

                         }
                     }
                    
                    
                                                              
                  } 
                 

                  if($post_data['report_id']==31){
                    if($category_qty>0){
                      $report['records'][] = array( 
                                      'cat_total'       =>'Total '.$category,   
                                      'cat_qty'       => number_format($category_qty,2,'.',''),                                     
                                      'cat_asset_value'       =>number_format($category_asset_value,2,'.',''),                         
                                      'cat_retail_value'       =>number_format($category_retail_value,2,'.',''),
                                      'cat_totalretail_value'       =>number_format($category_totalRetail_value,1,'.',''),                                                           
                                      'cat_totalasset_value'       =>number_format($category_totalAsset_value,1,'.',''),                                                            
                                      'is_type'       => 'cat_total'
                               );
                    }
                  }


                  if($post_data['report_id']==60){
                    if($category_qty>0){
                      $report['records'][] = array( 
                                      'cat_total'       =>'Total '.$category,   
                                      'cat_qty'       => number_format($category_qty,2,'.',''),                                     
                                      'cat_asset_value'       =>number_format($category_asset_value,2,'.',''),                         
                                      'cat_retail_value'       =>number_format($category_retail_value,2,'.',''),                                                           
                                      'is_type'       => 'cat_total'
                               );
                    }
                  }

                    else if($post_data['report_id']==37){
                     if($category_qty<0){
                      $report['records'][] = array( 
                                      'cat_total'       =>'Total '.$category,   
                                      'cat_qty'       => number_format($category_qty,2,'.',''),                                     
                                      'cat_asset_value'       =>number_format($category_asset_value,2,'.',''),                         
                                      'cat_retail_value'       =>number_format($category_retail_value,2,'.',''),                                                           
                                      'is_type'       => 'cat_total'
                               );
                    } 
                  }
                   
                    //for warehouse total quantity
                   if($post_data['report_id']==31){
                    if($warehouse_qty>0){
                      $report['records'][] = array( 
                                      'ware_total'       =>'Total '.$warehouses,   
                                      'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                      'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                      'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                      'is_type'       => 'ware_total'
                               );
                    }
                  }


                        if($post_data['report_id']==60){
                    if($warehouse_qty>0){
                      $report['records'][] = array( 
                                      'ware_total'       =>'Total '.$warehouses,   
                                      'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                      'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                      'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                      'is_type'       => 'ware_total'
                               );
                    }
                  }
                
                     else if($post_data['report_id']==37){
                    if($warehouse_qty<0){
                      $report['records'][] = array( 
                                      'ware_total'       =>'Total '.$warehouses,   
                                      'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                      'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                      'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                      'is_type'       => 'ware_total'
                               );
                    }
                  }    
                         
                          
                 
                  $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_qty'       =>       number_format($total_qty,2,'.',''),
                        'total_asset_value'       =>number_format($total_asset_value,2,'.',''),
                        'total_retail_value'       =>number_format($total_retail_value,2,'.',''),
                        'net_total_asset'       =>number_format($netTotalAsset,1,'.',''),
                        'net_total_retail'       =>number_format($netTotalRetail,1,'.',''),
                        'is_type'       => 'total'
                    );  

              

                if($post_data['report_id']==31){
                    if($post_data['print_category_report']=='1'){
                        $report['category_total_assets'] = number_format($total_asset_value,2,'.','');
                        $report['category_total_retail'] = number_format($total_retail_value,2,'.','');
                    }
                }  
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         
         public function getSalesOrderSummary(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "31";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 
                 $report_lines =  $this->model_reports_reports->get_sales_order($post_data);                 
                 $no = 1 ;
                 $balance = 0;
                 $group = "";
                 $discount_invoice = 0;
                 $net_total=$net_remaining=$net_discount=$net_paid=0;
                 $total_bill = $total_discount=$total_paid=$total_remaining=$total_balance=0;
                 foreach ($report_lines as $result) {
                    if($group!=$result['region_name']){
                        if($total_bill!=0){
                            $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,   
                                'inv_total'       => number_format($total_bill,2,'.',''),                                                                       
                                  'inv_total_discount'       => number_format($total_discount,2,'.',''),                                                                       
                                  'inv_total_paid'       => number_format($total_paid,2,'.',''),                                                                       
                                  'inv_total_balance'       => number_format($total_remaining,2,'.',''),        
                                  'is_type'       => 'region_total'
                             );
                                      $total_bill=$total_discount=$total_paid=$total_remaining=0;                    
                        }
                        $group = $result['region_name'];
                                $report['records'][] = array(                              
                                 'region_name'       =>$group,                         
                                 'is_type'       => 'region'
                        );
                                                  
                     }    
                    
                        if($result['invoice_type']=='1' || $result['invoice_type']=='2'){
                            $discount = $result['discount']+$result['discount_invoice'];
                            $discount_invoice = $result['discount_invoice'];
                            // $total    = $result['invoice_total'];
                            $total    = $result['invoice_total']+$result['discount'];
                            $paid     = $result['invoice_paid'];
                            $balance  = $total-$discount-$paid;
                        } else if ($result['invoice_type']=='3' || $result['invoice_type']=='4'){
                            $discount = -1*$result['discount'];
                            $total    = -1*$result['invoice_total'];
                            $paid     = -1*$result['invoice_paid'];
                            $total_balance = $result['invoice_total']-$result['discount']-$result['invoice_paid'];
                            $balance  = -1*$total_balance; 
                        }
                    
                        
                         $report['records'][] = array( 
                          'no'       =>$no,
                          'invoiceno'       => $this->getInvoiceDetail($result),
                          'customer'       => $result['cust_name'],
                          'total'       => number_format($total,2,'.',''),
                          'discount'       => number_format($discount,2,'.',''),
                          'paid'      => number_format((float)$paid,2,'.',''),
                          'balance'      => number_format($balance,2,'.',''),
                          'is_type'       => 'entry'
                        ); 
                        $total_bill = $total_bill + $total;
                        $total_discount = $total_discount + $discount+$discount_invoice;
                        $total_paid = $total_paid + $paid;
                        $total_remaining = $total_remaining + $balance;

                         $net_total = $net_total + $total;
                        $net_discount = $net_discount + $discount+$discount_invoice;;
                        $net_paid = $net_paid + $paid;
                        $net_remaining = $net_remaining + $balance;
                      
                    
                        $no = $no + 1 ; 
                      
                        
                    } 
                   if($total_bill!=0){
                            $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,   
                                  'inv_total'       => number_format($total_bill,2,'.',''),                                                                       
                                  'inv_total_discount'       => number_format($total_discount,2,'.',''),                                                                       
                                  'inv_total_paid'       => number_format($total_paid,2,'.',''),                                                                       
                                  'inv_total_balance'       => number_format($total_remaining,2,'.',''),        
                                  'is_type'       => 'region_total'
                             );
                                                          
                        }
                  
                  
                         
                  $report['records'][] = array( 
                                  'cat_total'       =>'Total',   
                                  'inv_total'       => number_format($net_total,2,'.',''),                                                                       
                                  'inv_total_discount'       => number_format($net_discount,2,'.',''),                                                                       
                                  'inv_total_paid'       => number_format($net_paid,2,'.',''),                                                                       
                                  'inv_total_balance'       => number_format($net_remaining,2,'.',''),        
                                  'is_type'       => 'cat_total'
                             );  
                
                  $report['records'][] = array( 
                        'total'             =>'Grand Total',
                        'total_total'             =>number_format($net_total,2,'.',''),                        
                        'total_discount'       =>       number_format($net_discount,2,'.',''),
                        'total_paid'       =>number_format($net_paid,2,'.',''),
                        'total_balance'       =>number_format($net_remaining,2,'.',''),
                        'is_type'       => 'total'
                    );
                 
             }  
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
             
         }
         
         private function getPaidAmount ($data,$post_data){
             $amount = 0;
             if($data['invoice_type']=="1"){
                 $amount = $data['invoice_paid'];
             }
             else{
                $amount =  $this->model_reports_reports->get_paid_amount($data,$post_data);  
             }
             return $amount;
         }
         
         private function getInvoiceDetail($data){
             $invoice_string = "";
             if($data["invoice_type"]==1){
                 $invoice_string = "POS Invoice #".$data["invoice_no"];
             }
             else if($data["invoice_type"]==3){
                 $invoice_string = "POS Sale Return #".$data["invoice_no"];
             }
             else if($data["invoice_type"]==2){
                 $invoice_string = "Sale Invoice #".$data["invoice_no"];
             }else if($data["invoice_type"]==4){
                 $invoice_string = "Sale Invoice Return #".$data["invoice_no"];
             }
             return $invoice_string;
         }
         
         public function getItemDetailReprot(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "32";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_inventory_items_units($post_data);
                 $category = "";
                 $category_qty =0;
                 $total_qty = 0;
                 $sno =1 ;
                 $avg_cost=0;
                 $avg_qty=0;
                 $warehouse_retail_value=0;
                 $warehouse_asset_value=0;
                 $warehouse_qty=0;
                 $warehouses='';
                 foreach ($report_lines as $result) {
                  $qty=$result['qty'];

                                          
                     if($qty!=0)
                     {
                      if($category!=$result['category'])
                      {
                        if($category_qty!=0){
                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$category,   
                                  'cat_qty'       => number_format($category_qty,2,'.',''),                                                                      
                                  'is_type'       => 'cat_total'
                             );                            
                          $category_qty =0;                                
                        } 
                      }
                        
                            if($warehouses !=$result['warehouse_name'])
                        {

                          if($warehouse_qty !=0)
                          {                          
                             $report['records'][] = array( 
                                  'ware_total'       =>'Total '.$warehouses,   
                                  'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                  'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                  'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                  'is_type'       => 'ware_total'
                             );                            
                             $warehouse_qty = $warehouse_asset_value = $warehouse_retail_value=0;                             
                        
                        
                          }

                         $warehouses=$result['warehouse_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }

                          if($category!=$result['category']){
                        // echo $result['unit_name'];exit;
                                             
                        $category = $result['category'];
                        
                            $report['records'][] = array( 
                             'category_name'       =>$category,                         
                             'is_type'       => 'category'
                        ); 
                                                                         
                     }

                             $report['records'][] = array( 
                      'item_sno'        => $sno,
                      'item_name'       =>$result['item_name'],                      
                      'ware_name'       =>$result['warehouse_name'],                      
                      'item_qty'       =>number_format($qty,2,'.',''),                      
                      'item_avg_cost'       =>$result['avg_cost'],
                      'item_sale_price'       =>number_format($result['sale_price'],2,'.',''),
                      'item_normal_price'       =>number_format($result['avg_cost'],2,'.',''),
                      'item_barcode'       =>$result['item_code'],
                      'item_unit'      =>$result['u_name'],
                      'is_type'       => 'entry'
                    );  
                      $category_qty =$category_qty+$qty;                        
                      $total_qty = $total_qty + $qty;    
                      $sno = $sno + 1;

                    $warehouse_qty = $warehouse_qty + $qty;
                     $warehouse_asset_value = $warehouse_asset_value + ($result['avg_cost']*$qty);
                     $warehouse_retail_value = $warehouse_retail_value + ($result['sale_price']*$qty);
                     } 
             
                                                              
                  } 
                      $report['records'][] = array( 
                      'cat_total'       =>'Total '.$category,   
                      'cat_qty'       => number_format($category_qty,2,'.',''),                                                                         
                        'is_type'       => 'cat_total'
                             );
                  
                      $report['records'][] = array( 
                                      'ware_total'       =>'Total '.$warehouses,   
                                      'ware_qty'       => number_format($warehouse_qty,2,'.',''),                                     
                                      'ware_asset_value'       =>number_format($warehouse_asset_value,2,'.',''),                         
                                      'ware_retail_value'       =>number_format($warehouse_retail_value,2,'.',''),                                                           
                                      'is_type'       => 'ware_total'
                               );
                  
                  $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_qty'       => number_format($total_qty,2,'.',''),                        
                        'is_type'       => 'total'
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         private function getNo($str,$reg_id){
            $custom_no = '';
            if($reg_id>0){
                $reg_id = str_pad($reg_id, 4, "0", STR_PAD_LEFT);
                $custom_no =$str.$reg_id;
            }
            return $custom_no;
        }
        public function getSaleByCustomer(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "31";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $group = "";
                 $group_amount=0;
                 $report_lines =  $this->model_reports_reports->get_sale_customer($post_data);
                 
                 $total_amount = 0;
                 
                  foreach ($report_lines as $result) {
                       if($group!=$result['group_name']){
                        if($group_amount!=0){
                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,                                     
                                  'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                                  'is_type'       => 'cat_total'
                             );
                            
                             $group_amount=0;                             
                        }
                        
                        $group = $result['group_name'];
                            $report['records'][] = array(                              
                             'category_name'       =>$group,                         
                             'is_type'       => 'category'
                        );
                                                  
                     } 
                     $amount = $result['amount'];
                      $report['records'][] = array( 
                        'cust_id'     => $this->getNo("CUST",$result['cust_id']),
                        'cust_name'   =>$result['cust_name'],
                        'bill_date'   =>$result['bill_date'],
                        'cust_group'   =>$result['group_name'],    
                        'amount'       =>number_format($amount,2,'.',''),
                        'is_type'       => 'entry'
                    );
                    $group_amount = $group_amount + $amount;
                    $total_amount = $total_amount + $amount;
                    
                    
                  }
                  $report['records'][] = array( 
                        'cat_total'       =>'Total '.$group,                                     
                        'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                        'is_type'       => 'cat_total'
                  );
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_amount'       =>number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }
        public function getCustomers(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "31";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $region = "";
                 $report_lines =  $this->model_reports_reports->getCustomers($post_data);
                 
                 $sno =1 ;
                  foreach ($report_lines as $result) {
                       if($region!=$result['cust_region']){
                        $region = $result['cust_region'];
                            $report['records'][] = array(                              
                             'region_name'       =>$region,                         
                             'is_type'       => 'region'
                        );
                            
                       
                                                  
                     } 

                       $openbalance =  $this->model_reports_reports->getOpeningBalance($result['acc_id']);
                          //  $this->load->model('common/common'); 
                          //  $data = array('acc_id' =>$result['acc_id']);            
                          // $cust_balance = number_format($this->model_common_common->getBalance($data),2,'.','');
                      if($result['balance']>$result['cradit_limit'] AND $result['cradit_limit'] !=0)
                      {
                        $color='yellow';
                      }
                      else{
                        $color='white';
                      }

                      $report['records'][] = array( 
                         'no'           => $sno,
                        'cust_name'      =>$result['cust_name'],
                        'cust_region'      =>$result['cust_region'],
                        'cust_mobile'    =>$result['cust_mobile'],    
                        'cust_phone'     =>$result['cust_phone'],
                        'cradit_limit'     =>$result['cradit_limit'],
                        'over_limit'     =>$result['balance'],
                        'openbalance'     =>$openbalance,
                        'color'     =>$color,
                        'is_type'        => 'customer'
                    );
                    
                    $sno = $sno + 1 ; 
                  }
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }
        
        public function getSaleByCustomerItem(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $group = "";
                 $group_amount=0;
                 if($post_data['product_id']!="" || $post_data['category_id']!=""){
                      $report_lines =  $this->model_reports_reports->get_sale_item_customer_item($post_data);
                      
                  } else {
                      $report_lines =  $this->model_reports_reports->get_sale_customer_item($post_data);
                  }
                 
                 $total_amount = 0;
                 $sno = 1;
                  foreach ($report_lines as $result) {
                       if($group!=$result['group_name']){
                        if($group_amount!=0){
                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,                                     
                                  'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                                  'is_type'       => 'cat_total'
                             );
                            
                             $group_amount=0;                             
                        }
                        
                        $group = $result['group_name'];
                            $report['records'][] = array(                              
                             'category_name'       =>$group,                         
                             'is_type'       => 'category'
                        );
                                                  
                     }  
                      $report['records'][] = array( 
                        'cust_id'     => $this->getNo("CUST",$result['cust_id']),
                        'sno'         => $sno,    
                        'cust_name'   =>$result['cust_name'],
                        'cust_group'   =>$result['group_name'], 
                        'cust_type'   =>$result['cust_type'],   
                        'amount'       =>number_format($result['amount'],2,'.',''),
                        'is_type'       => 'entry'
                    );
                    $group_amount = $group_amount + $result['amount'];
                    $total_amount = $total_amount + $result['amount'];
                    $sno = $sno + 1;
                    
                  }
                  $report['records'][] = array( 
                        'cat_total'       =>'Total '.$group,                                     
                        'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                        'is_type'       => 'cat_total'
                  );
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_amount'       =>number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
        }
        
        public  function getInventoryValuation(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "33";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_inventory_items($post_data);
                 $cust_name="";
                 $category = "";
                 $category_qty = $category_asset_value = $category_retail_value=0;
                 $total_qty = $total_asset_value=$total_retail_value=0;$avg_cost=0; 
                 foreach ($report_lines as $result) {
                      if($category!=$result['item_name']){

                        if($category_qty!=0){
                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$category,   
                                  'cat_qty'       => $category_qty,                                     
                                  'cat_asset_value'       =>number_format($category_asset_value,2,'.',''),                         
                                  'cat_on_hand'       => number_format($category_qty,2,'.',''),                          
                                  'is_type'       => 'cat_total'
                             );
                            
                             $category_qty = $category_asset_value = $category_retail_value=0;                             
                        }
                        
                        $category = $result['item_name'];
                            $report['records'][] = array( 
                             'category_name'       =>$category,                         
                             'is_type'       => 'category'
                        );
                         
                         //$cat_change = true;
                     }
                     
                     $result_item = $this->model_reports_reports->get_valuation_detail($result['id'],$post_data);
                     
                     $sdate = date('Y-m-d', strtotime('-1 day', strtotime($post_data['start_date'])));
                     $startdate = $post_data['start_date'];
                     $enddate = $post_data['end_date'];
                     // $_data = array("category_id" => $result['category_id'],"product_id"=>$result['id'],"end_date" =>$enddate,"start_date"=>$startdate,"ware_id"=>$post_data['warehouse']);                     
                       $_data = array("category_id" => $result['category_id'],"product_id"=>$result['id'],"end_date" => $sdate);    
                     $purchase_qty =   $this->model_reports_reports->get_purchase_items($result['id'],$_data); 
                     // echo $purchase_qty;exit;                   
                     $sale_qty =      $this->model_reports_reports->get_sale_items($result['id'],$_data);
                     $adjust_qty =     $this->model_reports_reports->get_adjust_items($result['id'],$_data);
                     $date_add = date("Y-m-d",strtotime($result['added_date']));
                     $result_qty = (strtotime($sdate) >= strtotime($date_add)) ? $result['quantity'] : 0;
                     
                     // $qtyonhand = $result_qty+$adjust_qty+$purchase_qty-$sale_qty;                         
                     $qtyonhand =$adjust_qty+$purchase_qty-$sale_qty;                         
                     
                      // echo $purchase_qty;exit;
                                        
                     // var_dump($avg_cost);exit;
                      foreach ($result_item as $rec) {  

                          
                          if($rec['inv_id']<0){
                              $cust_name = $this->model_reports_reports->get_cust_name($rec['inv_id']);
                              // echo $cust_name;

                          } 
                           else if($rec['type']=='A'){
                              $cust_name = "Stock Adjustment";
                          }
                          else if($rec['inv_id']==0){
                              $cust_name = "Stock Entry";
                          }
                           elseif(strpos($rec['inv_id'], 'A') !== false){
                              $cust_name = "Adjustment";
                          } else {
                              $cust_name = $this->model_reports_reports->get_vend_name($rec['inv_id']);
                          }
                        $item_qty = $this->getQty($rec,$post_data['warehouse']); 
                        $qtyonhand = $qtyonhand + $item_qty;
                        // echo $qtyonhand;
                        // $qtyonhand = $qtyonhand ;
                        // echo $item_qty;
                        $cost = $this->getCost($rec,$item_qty);
                      


                        if($rec['type']=='E')
                        {
                          $open_cost= $this->model_reports_reports->get_openStockPrice($result['id'],$startdate,$enddate);
                          if($item_qty==0)
                          {
                             $avg_cost=$open_cost/1;
                          }
                          else{
                             $avg_cost=$open_cost/$item_qty;
                          }
                         
                        }
                        else if($rec['type']=='S' || $rec['type']=='SALE_RET')
                        {
                           $avg_cost= $this->model_reports_reports->get_PriceByInvoice($rec['inv_id'],$result['id']);
                        }
                        elseif ($rec['type']=='P') {
                         $purchase = $this->model_reports_reports->get_PriceByPOInvoice($result['id']);
                          if($rec['inv_id']==$purchase['inv_id'])
                          {
                             $avg_cost=$purchase['inv_item_price']/$purchase['conv_from'];
                          }
                          else{
                            $avg_cost = $this->model_reports_reports->updateAvgCost($result['id'],$sdate); 
                          }
                        }
                        elseif ($rec['type']=='PO_RET') {
                            $purchase_ret = $this->model_reports_reports->get_PriceByPORetInvoice($result['id'],$rec['inv_id']);
                          if($rec['inv_id']==$purchase_ret['inv_id'])
                          {
                             $avg_cost=$purchase_ret['inv_item_price']/$purchase_ret['conv_from'];
                          }
                          else{
                            $avg_cost = $this->model_reports_reports->updateAvgCost($result['id'],$sdate); 
                          }
                        }
                        elseif ($rec['type']=='A') {
                             $adjust_cost= $this->model_reports_reports->get_AdjustStockPrice($result['id'],$rec['inv_id'],$startdate,$enddate);
                             // echo $adjust_cost;
                             if($item_qty !=0)
                             {
                              $avg_cost=-1* $adjust_cost/$item_qty;    
                             }
                             else{
                              $avg_cost = $this->model_reports_reports->updateAvgCost($result['id'],$sdate);
                             }
                          

                        }
                        else{
                         $avg_cost = $this->model_reports_reports->updateAvgCost($result['id'],$sdate);   
                        }
                $asset_value = $avg_cost * $qtyonhand;
                        if($item_qty!=0){
                        $report['records'][] = array( 
                          'item_id'       =>$rec['journal_id'],
                          'item_detail'       =>$this->getItemDetail($rec),
                          'num'       =>    $this->getNum($rec),
                          'item_date'       =>date($this->language->get('date_format'), strtotime($rec['entry_date'])),
                          'item_qty'       =>  number_format($item_qty,2,'.',''),
                          'cust_name'     =>  $cust_name,
                          'item_cost'       =>$cost!=0?bcdiv($cost,1,2):"",
                          'item_avg_cost'       =>number_format($avg_cost, 2, '.',''),                                                      
                          // 'item_avg_cost'       =>bcdiv($avg_cost, 1, 2),                                                      
                          'item_on_hand'       =>number_format($qtyonhand,2,'.',''),  
                          'item_asset_value'      => bcdiv($asset_value,1,2) ,                          
                          'is_type'       => 'entry'
                        );        
                        $category_qty = $qtyonhand;
                        $category_asset_value = $asset_value;
                        }
                      } 
                        if( $category_qty==0){
                            $_l = count($report['records']);
                            array_splice($report['records'],$_l-1,1);
                        }
                        $total_qty= $total_qty + $category_qty;
                        $total_asset_value = $total_asset_value + $category_asset_value;
                                                              
                  } 
                  if($category_qty>0){
                    $report['records'][] = array( 
                            'cat_total'       =>'Total '.$category,   
                            'cat_qty'       => $category_qty,                                     
                            'cat_asset_value'       =>number_format($category_asset_value,2,'.',''),                         
                            'cat_on_hand'       => number_format($category_qty,2,'.',''),                                                                                               
                            'is_type'       => 'cat_total'
                     );
                  }
                  $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_qty'       =>       $total_qty,
                        'total_asset_value'       =>number_format($total_asset_value,2,'.',''),
                        'total_on_hand'       =>       number_format($total_qty,2,'.',''),
                        'is_type'       => 'total'
                    );
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
        }
        private function getAvgCost($data,$qtyonhand,$avg_cost,$item_qty,$cost){
             if($data['type']=='P'){
                 $avg_cost = (($qtyonhand*$avg_cost) +($item_qty*$cost))/($qtyonhand+$item_qty);
             }
             return $avg_cost;
        }
        private function getCost($data,$qty){
            $cost = 0;
            if($data['type']=='P' || $data['type']=='PO_RET'){
                $cost = $this->model_reports_reports->get_po_cost($data['inv_id'],$data['item_id']);
            }
            return $cost;
        }
        private function getNum($data){
            $num = "";
            if($data['type']=='P' || $data['type']=='PO_RET'){
                $num = $this->model_reports_reports->getPurchaseInvoiceNo($data['inv_id']);
            }
            else if($data['type']=='S' || $data['type']=='POS' || $data['type']=='POS_RET' || $data['type']=='SALE_RET'){
                $num = $this->model_reports_reports->getInvoiceNo($data['inv_id']*-1);
            }
            return $num;
        }
        
        private function getQty($data,$ware_id){
            $qty = 0;
            if($data['type']=='E'){
                $qty = $this->model_reports_reports->get_item_qty($data['item_id'],$ware_id);
                // echo $qty;exit;
            }
            else if($data['type']=='S' || $data['type']=='POS' || $data['type']=='POS_RET' || $data['type']=='SALE_RET'){
               $qty = $this->model_reports_reports->get_so_qty($data['inv_id']*-1,$data['item_id'],$ware_id)*-1;
            }
            else if($data['type']=='P' || $data['type']=='PO_RET'){
               $qty = $this->model_reports_reports->get_po_qty($data['inv_id'],$data['item_id'],$ware_id);
            }
            else if($data['type']=='A'){
                $adj_id = (int) substr($data['inv_id'],1);
                $qty = $this->model_reports_reports->get_adjust_qty($adj_id,$data['item_id'],$ware_id);
            }
            return $qty;
        }
        private function getItemDetail($data){
            $detail = "";
             if($data['type']=='E'){
                 $detail = "Item Stock Entry";
             } 
             else if($data['type']=='S'){
               $detail = "Sale Invoice";
            }
            else if( $data['type']=='POS'){
                $detail = "POS Invoice";
            }
            else if( $data['type']=='POS_RET' ){
                $detail = "POS Sale return";
            }
            else if( $data['type']=='SALE_RET' ){
                $detail = "Sale return";
            }
            else if( $data['type']=='PO_RET' ){
                $detail = "Purchase return";
            }
            else if($data['type']=='P'){
               $detail = "Bill";
            }
            else if($data['type']=='A'){                
                 $detail = "Inventory Adjust";
            }
            return $detail;
        }
        
        public function getAccountReceivable(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "42";
                 $report['report_name'] = 'Account Receivable';
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date']; 
                 $report['over_limit'] =$post_data['over_limit_detail'];                
                 $report['last_payment'] =$post_data['last_payment'];                
                 $report['company_name'] =  $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_account_receivable($post_data);
                 $total_amount = 0;$total_paid=0;
                 $group = "";
                 $group_amount=0;$group_paid=0;
                 $order_date=0;
                 $sno = 1;
                 $catno=1;
                 $category1="";$customer='';
                 $price=$post_data['below_zero_price'];
                  foreach ($report_lines as $result) {
                    if($group!=$result['group_name']){

                        if($group_amount !=0){
                            $report['records'][] = array( 
                             'category_id'       =>$result['cust_group_id'],    
                             'category_name'       =>$group,                         
                             'is_type'       => 'category'
                           );

                             $report['records'][] = array( 
                                  'cat_num'         =>$catno, 
                                  'cat_total'       =>'Total '.$group,                                     
                                  'cat_amount'       =>number_format($group_amount,2,'.',''),
                                  'catLast_amount'       =>number_format($group_paid,2,'.',''),                                                           
                                  'is_type'       => 'cat_total'
                             );
                            
                             $group_amount=0;$group_paid=0;
                             
                       
                             
                                                         
                        }

                         $group = $result['group_name'];

                                                  
                     }  

                          if($category1!=$result['group_name']){
                              $category1 = $result['group_name'];

                          $report['records'][] = array( 
                           'category_name' =>$category1,                         
                           'is_type'       => 'category'
                          );
                        }

                      $amount = $this->model_reports_reports->getBalance($result['cust_acc_id'],$post_data);
                      $last_payment = $this->model_reports_reports->getLastPayment($result['cust_acc_id'],$post_data);
                         $last=-1*$last_payment['amount'];
                      
                    if($last_payment['date']==0)
                    {
                      $order_date='';
                    }
                    else{
                      $time = strtotime($last_payment['date']); 
                     
                     $order_date = date("d-m-y",$time );
                    }
                      if($price==0)
                      {
                        if($post_data['CustBelowZero']==0)
                        {
                          $below=$amount !=0;
                        }
                        else{
                        $below=$amount>6;  
                        }
                        // 
                         
                      }
                      // else{
                      //   $below=$amount !=0;
                      // }
                      if($below){
                        if($result['cust_credit_limit']<$amount && $result['cust_credit_limit'] !=0) 
                        {
                          $color='background-color:yellow';
                          $class='color';
                        }
                        else
                         {
                          $color=''; 
                           $class='';
                         } 
                         


                          $report['records'][] = array( 
                              'sno'         => $sno,    
                              'cust_id'     => $this->getNo("CUST",$result['cust_id']),
                              'cust_name'   =>$result['cust_name'],
                              'cust_mobile'   =>$result['cust_mobile'],
                              'cust_limit'   =>$result['cust_credit_limit'],
                              'cust_type'   =>$result['type_name'],  
                              'amount'       =>number_format($amount,2,'.',''),
                              'last_payment' =>number_format($last,2,'.',''),
                              'last_date' =>$order_date,
                              'color' =>$color,
                              'class' =>$class,
                              'is_type'       => 'entry'
                          );
                          $group_amount = $group_amount + $amount;  
                          $group_paid = $group_paid + $last;  
                          $total_amount = $total_amount + $amount;
                          $total_paid = $total_paid + $last;
                          $sno = $sno +1;
                      }
                  }
                  if($group_amount !=0)
                  {
                  $report['records'][] = array( 
                        'cat_num'         =>$catno,
                        'cat_total'       =>'Total '.$group,                                     
                        'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                        'catLast_amount'       =>number_format($group_paid,2,'.',''),                                                           
                        'is_type'       => 'cat_total'
                   );   
                  $catno=$catno+1;
                }
                  
                  
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_amount'       =>number_format($total_amount,2,'.',''),
                        'totalLast_amount'       =>number_format($total_paid,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }
        
        public function getAccountPayable(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "43";
                 $report['report_name'] = 'Account Payable';
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_account_payable($post_data);
                 $total_amount = 0;
                 $group = "";
                 $group_amount=0;
                 $sno = 1;
                  foreach ($report_lines as $result) {    
                       $opening_balance = $this->model_reports_reports->getVendorOpeningBalance($result['vendor_acc_id']);
                                      // $opening_balance=  $opening_bal['opening_balance']==NULL?0:$opening_bal['opening_balance'];
                        $amount = $this->model_reports_reports->getBillPayable($result['vendor_acc_id'],$post_data);

                      
                      $amount_credit = $amount["credit"]*-1;
                      $amount_debit = $amount["debit"]; 
                      $total = $opening_balance + $amount_credit;
                      $amount_balance = $total - $amount_debit;


                      if($amount_balance !=0){
                            $report['records'][] = array( 
                              'sno'         => $sno,    
                              'vendor_id'     => $this->getNo("VENDOR",$result['vendor_id']),
                              'vendor_name'   =>$result['vendor_name'],                              
                              'amount'       =>number_format($amount_balance,2,'.',''),
                              'is_type'       => 'entry'
                          );
                          $group_amount = $group_amount + $amount_balance;  
                          $total_amount = $total_amount + $amount_balance;
                          $sno = $sno +1;
                      }
                  }                 
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_amount'       =>number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }
        public function getexpensereport(){
          $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "47";
                 $report['report_name'] = 'Expenses';
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_expenses($post_data);
                 $net_total_expenses = $total_expenses = $account_name = 0;  
                 $sno='1'; $account_name=""; $amount=0;
                    foreach ($report_lines as $result) {
                        
                        if($account_name!=$result['account_name']){
                            if($total_expenses!=0){
                            $report['records'][] = array( 
                            'title'       =>'Total '.$account_name,   
                            'amount'       => number_format($total_expenses,2,'.',''),                           
                            'is_type'       => 'total_expenses'
                             );
                              $total_expenses =0; 
                         }
                         if($post_data['print_category_report']=='0'){
                          $report['records'][] = array( 
                           'acc_name'       =>$result['account_name'],                         
                           'is_type'       => 'account_name'
                          );
                         }
                       }
                       $account_name = $result['account_name'];
                      $amount = $result['amount']<0 ? $result['amount']*-1:$result['amount'];
                      if($post_data['print_category_report']=='0'){
                      $report['records'][] = array( 
                        'sno'                => $sno,
                        'account_title'       =>$result['account_name'],
                         'account_date'       =>$result['date'],
                        'account_des'       =>$result['journal_details'], 
                        'account_type'      => $this->model_reports_reports->account_type($result['ref_id']),
                        'account_amount' => number_format($amount,2,'.',','),
                        'is_type'       => 'expense'                            
                      ); }
                     $sno = $sno +1;
                     $total_expenses = $total_expenses + $amount;
                      $net_total_expenses = $net_total_expenses + $amount;
                     }
                      

                      $report['records'][] = array( 
                            'title'       =>'Total '.$account_name,   
                            'amount'       => number_format($total_expenses,2,'.',''),                           
                            'is_type'       => 'total_expenses'
                      );
                      
                      
                  
                 }    
                 $report['records'][] = array( 
                            'title'       =>'Total Expenses',   
                            'amount'       => number_format($net_total_expenses,2,'.',''),                           
                            'is_type'       => 'net_total_expenses'
                       );
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));  
        }
        public function getOwnerShip(){
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "42";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report =  $this->model_reports_reports->get_ownership($post_data);
                                  
                      
                $this->load->library('json');
                $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
            }
        }
        
        public function getInventoryReport(){
             
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "1";
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  // $report_lines =  $this->model_reports_reports->sale_report($post_data);
                  $report_lines =  $this->model_reports_reports->get_stock_inventory($post_data);
                  $category = "";$display='';
                  $category_opening_stock = $category_qty_balance  = $category_total_value = $category_amount = $category_quantity= $category_onhand= $category_value=$category_total_qty= $category_total_sold=0;$onhand=0;$totalPurchaseQty=0;$totalSaleReturnQty=0;
                  $total_opening_stock = $total_qty_balance = $total_total_value  =  $total_amount= $total_quantity = $total_onhand= $t_total_value =0;
                  
                  foreach ($report_lines as $result) {

                      if($category!=$result['category']){

                         if($category_quantity!=0){
                              $report['records'][] = array( 
                        'cat_total'       =>'Total '.$category,   
                        'cat_opening_stock'       => number_format($category_opening_stock,2,'.',''),                                      
                        'cat_qty_balance'       => number_format($category_qty_balance,2,'.',''),                                      
                        'cat_total_qty'       =>number_format($category_total_qty,2,'.',''),                         
                        'cat_total_value'       =>number_format($category_total_value,2,'.',''),                                                            
                        'cat_total_sold'       =>number_format($category_total_sold,2,'.',''),                                                            
                        'cat_total_amount'       =>number_format($category_amount,2,'.',''),                                                            
                        'cat_onhand'       =>number_format($category_onhand,2,'.',''),                                                            
                        'cat_value'       =>number_format($category_value,2,'.',''),                                                            
                        'is_type'       => 'cat_total'
                  );
                              $category_opening_stock = $category_qty_balance = $category_total_value =$category_quantity = $category_onhand= $category_value=$category_total_qty=$category_total_sold=0; 
                         }
                          $category = $result['category'];
                          $report['records'][] = array( 
                           'category_name'       =>$category,                         
                           'is_type'       => 'category'
                          );
                          $cat_change = true;
                      }

                     //$discount =  $result['discount'];
                     
                     if($result['qty']!=="0"){
                         
                        // $o_purchase_qty = $this->model_reports_reports->get_purchase_items($result['id'],$post_data,$post_data['start_date']);
                        // $o_sale_qty = $this->model_reports_reports->get_sale_items($result['id'],$post_data,$post_data['start_date']);
                        // $o_adjust_qty = $this->model_reports_reports->get_adjust_items($result['id'],$post_data,$post_data['start_date']);
                         
                        // $purchase_qty = $this->model_reports_reports->get_purchase_items_interval($result['id'],$post_data);                              

                        $sqlOpenStockqty= $this->model_reports_reports->sqlOpenStockqty($result['id'],$post_data);  

                        $sqlRetqty= $this->model_reports_reports->getSaleRetqty($result['id'],$post_data);                                                  

                        $open_qty = $this->model_reports_reports->get_open_qty($result['id'],$post_data);                                                                                 
                        $purchase_qty = $this->model_reports_reports->get_purchase_qty($result['id'],$post_data);                                                                                 
                        $purchaseRet_qty = $this->model_reports_reports->get_purchaseRet_qty($result['id'],$post_data);

                        $adjuststockQty=$this->model_reports_reports->getadjuststockQty($result['id'],$post_data);
                        //list($date1, $time1) =explode(" ",$post_data['start_date']);  
                        //list($date2, $time2) =explode(" ",$result['added_date']);  
                        
                        /*if(strtotime($date1)==strtotime($date2)){
                            $o_qty = $o_adjust_qty+$o_purchase_qty-$o_sale_qty;     
                            $opening_qty = $result['quantity'];
                        }   
                        else{*/
                            $o_qty = $open_qty;
                        //}
                        
                        $qty = $result['qty'] + $o_qty;                        
                        $trade=$result['trade'];
                        $totalPurchaseQty=$purchase_qty-$purchaseRet_qty;                            
                        $totalSaleReturnQty=$result['qty']-$sqlRetqty;                            
                        $total_value = $result['sale'] * $qty;
                        $total_qty = $purchase_qty-$purchaseRet_qty+$o_qty;
                        // $total_qty = $open_qty+$purchase_qty-$purchaseRet_qty;
                        $amount = $result['qty'] * $result['sale_price'];
                        $total_cost = $total_qty * $result['trade'];
                       
                        $rvalue = $result['sale_price'] * $onhand;
                        if($o_qty<=0)
                        {
                          $display='';
                           $onhand = $total_qty - $result['qty']+$sqlRetqty+$adjuststockQty+$sqlOpenStockqty;

                        }
                        else{
                          $display='none';
                           $onhand = $total_qty - $result['qty']+$sqlRetqty+$adjuststockQty;
                        }
                        $report['records'][] = array( 
                              'product_name'       => $result['product'],
                              'opening_stock'      => number_format($o_qty,2,'.',''),  
                              'sale_price'         => number_format($result['trade'],2,'.',''),
                              'purchase_qty'       => number_format($purchase_qty-$purchaseRet_qty,2,'.',''),                               
                              'purchaseRet_qty'    => number_format($purchaseRet_qty,2,'.',''),   
                              'total_qty'          => number_format($total_qty,2,'.',''),
                              'total_value'        => number_format($total_cost,2,'.',''),
                              'sold_qty'           => number_format($result['qty']-$sqlRetqty,2,'.',''),  
                              'saleRet_qty'        => number_format($sqlRetqty,2,'.',''),  
                              'adjuststockQty'     => number_format($adjuststockQty,2,'.',''),  
                              'OpenStockqty'       => number_format($sqlOpenStockqty,2,'.',''),  
                              'amount'             => number_format($amount,2,'.',''),  
                              'onhand'             => number_format($onhand,2,'.',''),
                              'display'             => $display,
                              'value'              => number_format($rvalue,2,'.',''),                                                    
                              'is_type'            => 'product'
                         );
                     }
                      $category_opening_stock = $category_opening_stock + $o_qty; 
                      $category_qty_balance = $category_qty_balance + $totalPurchaseQty;       

                      $category_total_value = $category_total_value + $total_cost; 

                      $category_total_sold=$category_total_sold+$totalSaleReturnQty;    

                      $category_total_qty = $category_total_qty + $total_qty;                                                    
                      $category_quantity = $category_quantity + $result['qty'];
                      // $category_quantity = $category_quantity + $o_sale_qty;
                      $category_amount = $category_amount + $amount;
                      $category_onhand = $category_onhand + $onhand;
                      $category_value = $category_value + $rvalue;

                      $total_opening_stock = $total_opening_stock + $o_qty;
                      $total_qty_balance = $total_qty_balance + $totalPurchaseQty;
                      $total_total_value = $total_total_value + $total_cost;                                                                  
                      // $total_total_value = $total_total_value + $total_value;                                                                  
                      $total_quantity = $total_quantity + $totalSaleReturnQty;
                      // $total_quantity = $total_quantity + $o_sale_qty;
                      $total_amount = $total_amount + $amount;
                      $total_onhand = $total_onhand + $onhand;
                      $t_total_value = $t_total_value + $rvalue;
                  }
                  
                  $report['records'][] = array( 
                        'cat_total'       =>'Total '.$category,   
                        'cat_opening_stock'       => number_format($category_opening_stock,2,'.',''),                                      
                        'cat_qty_balance'       => number_format($category_qty_balance,2,'.',''),                                      
                        'cat_total_qty'       =>number_format($category_total_qty,2,'.',''),                         
                        'cat_total_value'       =>number_format($category_total_value,2,'.',''),                                                            
                        'cat_total_sold'       =>number_format($category_total_sold,2,'.',''),                                                            
                        'cat_total_amount'       =>number_format($category_amount,2,'.',''),                                                            
                        'cat_onhand'       =>number_format($category_onhand,2,'.',''),                                                            
                        'cat_value'       =>number_format($category_value,2,'.',''),                                                            
                        'is_type'       => 'cat_total'
                  );                 
                  
                  $report['records'][] = array( 
                    'grand_total'       =>'Grand Total',
                    'total_opening_stock' =>      number_format($total_opening_stock,2,'.',''),  
                    'total_qty_balance' =>      number_format($total_qty_balance,2,'.',''),   
                    'total_total_value'       =>number_format($total_total_value,2,'.',''),                         
                    'total_total_sale'       =>number_format($total_quantity,2,'.',''),                         
                    'total_amount'       =>number_format($total_amount,2,'.',''),                         
                    'total_onhand'       =>number_format($total_onhand,2,'.',''),                         
                    'total_value'       =>number_format($t_total_value,2,'.',''),                           
                    'is_type'       => 'total'
                   );                  
                  
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         
         public function getLowStockReport(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "36";
                 $report['report_name'] = $post_data['report_name'];                 
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_inventory_items_lowstock($post_data);
                 $category = "";
                 $warehouses="";
                 $category_qty = $category_asset_value = $category_retail_value=0;
                 $total_qty = $total_asset_value=$total_retail_value=0;
                 foreach ($report_lines as $result) {
                     
                     $qty = $result['qty'];                                              
                     
                      if($qty <= $result['reorder_point']){

                         if($warehouses !=$result['warehouse_name'])
                        {


                         $warehouses=$result['warehouse_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }

                          if($category!=$result['category']){
                        // echo $result['unit_name'];exit;
                                             
                        $category = $result['category'];
                        
                            $report['records'][] = array( 
                             'category_name'       =>$category,                         
                             'is_type'       => 'category'
                        ); 
                                                                         
                     }








                        $report['records'][] = array( 
                          'item_id'       =>$result['id'],                          
                          'item_name'       =>$result['item_name'],
                          'item_reorder_value'       =>$result['reorder_point'],                          
                          'item_qty'       =>$qty,      
                          'item_category'=>$result['category'],      
                          'is_type'       => 'product'
                        );  
                          $category_qty = $category_qty + $qty;
                          $category_asset_value = $category_asset_value + ($result['avg_cost']*$qty);
                          $category_retail_value = $category_retail_value + ($result['sale_price']*$qty);

                          $total_qty = $total_qty + $qty;
                          $total_asset_value = $total_asset_value +($result['avg_cost']*$qty);
                          $total_retail_value = $total_retail_value + ($result['sale_price']*$qty);
                      }                    
                  } 
                  
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function getSaleByInvoicesProfit(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "31";
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 
                 $report_lines =  $this->model_reports_reports->sale_invoice_profit_report($post_data);                 
                 $no = 1 ;
                 $id = 0;
                 $revenue = 0;
                 $total_percent = 0;
                 $group = "";
                 $total_bill = $total_cost=$total_revenue=$cost=$region_total_bill=$region_total_cost=$region_total_revenue=0;
                 foreach ($report_lines as $result) {
                    if($group!=$result['region_name']){
                        if($total_bill!=0){
                            $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,   
                                  'inv_total'       => number_format($region_total_bill,2,'.',''),                                                                               
                                  'inv_cost'        => number_format($region_total_cost,2,'.',''),                                                                       
                                  'inv_revenue'     => number_format($region_total_revenue,2,'.',''),        
                                  'is_type'         => 'region_total'
                             );
                              $region_total_bill =   $region_total_cost =   $region_total_revenue = 0;                       
                        }
                        $group = $result['region_name'];
                                $report['records'][] = array(                              
                                 'region_name'       =>$group,                         
                                 'is_type'       => 'region'
                        );
                                                  
                     }    
                    
                         
                    $invoice_cost=  $this->model_reports_reports->get_invoice_cost($result['invoice_id']);
                        $cost = $invoice_cost;
                        // $total = $result['invoice_total']-$result['discount_invoice'];
                        $total = $result['invoice_total']-$result['discount_invoice'];
                        $revenue = $total-$cost;
                        $report['records'][] = array( 
                          'no'       =>$no,
                          'invoiceno'       => $this->getInvoiceDetail($result),
                          'customer'       => $result['cust_name'],
                          'total'       => number_format($total,2,'.',''),
                          'cost'      => number_format($cost,2,'.',''),
                          'revenue'      => number_format($revenue,2,'.',''),
                          'is_type'       => 'entry'
                        ); 
                        $region_total_bill = $region_total_bill + $total;
                        $region_total_cost = $region_total_cost + $cost;
                        $region_total_revenue = $region_total_revenue + $revenue;
                        
                        $total_bill = $total_bill + $total;
                        $total_cost = $total_cost + $cost;
                        $total_revenue = $total_revenue + $revenue;
                      
                        $no = $no + 1; 
                      
                        
                    } 
                    
                    $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,   
                                  'inv_total'       => number_format($region_total_bill,2,'.',''),                                                                               
                                  'inv_cost'       => number_format($region_total_cost,2,'.',''),                                                                       
                                  'inv_revenue'       => number_format($region_total_revenue,2,'.',''),        
                                  'is_type'       => 'region_total'
                             );
                   
                     $report['records'][] = array( 
                        'total'             =>'Grand Total',
                        'total_total'             =>number_format($total_bill,2,'.',''),       
                        'total_cost'       =>number_format($total_cost,2,'.',''),
                        'total_revenue'       =>number_format($total_revenue,2,'.',''),
                        'is_type'       => 'total'
                    );
                 
             }  
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
             
         }
         public function getSaleSummaryRegion(){
              $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "1";
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                 $group = "";
                 $group_amount=0;$group_qty=0;$group_discount=0; $total_discount=0; $_discount=0;
                 $report_lines =  $this->model_reports_reports->sale_summary_report($post_data);
                 $total_amount = 0;$total_qty = 0;
                  foreach ($report_lines as $result) {
                       if($group!=$result['group_name']){
                        if($group_amount!=0){
                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,                       
                                  'cat_qty'       =>number_format($group_qty,2,'.',''),
                                  'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                                  'is_type'       => 'cat_total'
                             );
                            
                             $group_qty = $group_amount=0;                             
                        }
                        
                        $group = $result['group_name'];
                            $report['records'][] = array(                              
                             'category_name'       =>$group,                         
                             'is_type'       => 'category'
                        );
                                                  
                     }  
                      $report['records'][] = array( 
                        'item_id'     => $result['item_id'],
                        'item_name'   =>$result['item_name'],
                        'item_qty'   => number_format($result['qty'],1,'.',''),    
                        'item_net_price' =>number_format($result['total_val'],2,'.',''),
                        'is_type'       => 'entry'
                    );
                    $group_qty = $group_qty + $result['qty'];    
                    $group_amount = $group_amount + $result['total_val'];
                    //$group_discount = $group_discount + $result['discount'];
                    $total_amount = $total_amount + $result['total_val'];
                    //$total_discount = $total_discount + $result['discount'];
                    $total_qty = $total_qty + $result['qty'];
                    
                    
                  }
                  $report['records'][] = array( 
                        'cat_total'       =>'Total '.$group,                        
                        'cat_qty'       =>number_format($group_qty,2,'.',''),
                        'cat_amount'       =>number_format($group_amount,2,'.',''),                                                           
                        'is_type'       => 'cat_total'
                  );
                  $_discount = $this->model_reports_reports->total_discount($post_data);
                  $report['records'][] = array( 
                        'discount_title'       =>'Discount On Invoices ',                        
                        'discount'       =>number_format($_discount,2,'.',''),                                                           
                        'is_type'       => 'discount'
                  );
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_qty'       =>number_format($total_qty,2,'.',''), 
                        'total_amount'       =>number_format($total_amount-$_discount,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
            
         }
         public function getVendorRegisterReport(){
                $post_data=$this->request->post;
                $this->load->model('reports/reports');
                $report['report_name'] = $post_data['report_name'];
                $report['start_date'] = $post_data['start_date'];
                $report['end_date'] = $post_data['end_date'];
                $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                $report_lines =  $this->model_reports_reports->vendor_register_report($post_data);
                
                //foreach($report_lines as $result) {
                    $report['records'][] = array( 
                        'date'       => 'Date',  
                        'po_no'       => '1',                              
                        'vendor'       => 'Vendor',
                        'account'       => 'Account',                      
                        'description'       => 'Description',
                        'billed'       => 'Billed',
                        'paid'       => 'paid',
                        'balance'       => 'Balance',
                        'is_type'       => 'entry'
                    );
                //}
                $this->load->library('json');
                $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function getRegisterReport(){
             
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = "1";
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  $report_lines =  $this->model_reports_reports->register_report($post_data);
                  $group = "";$group1 = "";
                  $customer = "";
                  $group_paid = $group_balance = 0;
                  $total_paid = $customer_balance=$total=$c_percent=0;
                  $sno =1;
                  $total_balance=1;
                  $paid= 0;
                  $balance= 0;
                  $group_total = 0;
                  $group_paid =0;
                  $total_percent =0;
                  $c_total_percent=0;   
                  $total_rbalance=0;   
                  $net=0;
                  $representative='';
                  foreach($report_lines as $result) {

                      if($group!=$result['group_name'] && (isset($result['sale_representative']) && $result['sale_representative'] !='NULL')){

                         if($group_total!=0){
                                $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,                            
                                  'category_total'       =>number_format($group_total,2,'.',''),                         
                                  'cat_paid'       =>number_format($group_paid,2,'.',''),                         
                                  'cat_balance'       =>number_format($group_balance,2,'.',''),                                                
                                  'cat_percent'       =>number_format($c_total_percent,2,'.',''),                                                
                                  'is_type'       => 'cat_total'
                            );
                              $group_paid = $group_balance =$group_total=$group_paid=0; 
                         
                  
                        }
                                $group = $result['group_name'];
                          
                        
                      }

                        if($group1!=$result['group_name'] && (isset($result['sale_representative']) && $result['sale_representative'] !='NULL')){
                              $group1 = $result['group_name'];
                               //$cat_change = true;
                          $report['records'][] = array( 
                           'group_name'       =>$group1,                         
                           'is_type'       => 'category'
                          );
                        } 

                      if($customer !=$result['customer_name']){
                          $pre_row = $this->model_reports_reports->getPreviousCustomerWithoutDate($result['acc_id']);
                          $p_amount = $this->model_reports_reports->getPaidAmountWithDate($result['acc_id'],$post_data);
                           // var_dump($p_amount); exit;
                          // $customer_balance = $pre_row["pre_total"];
                          $balance = $pre_row["pre_total"];
                          // print_r($p_amount['type']);exit;
                          $customer = $result['customer_name'];
                      }
                      if($post_data['non_collected']==true)
                      {
                          if($p_amount['type']=="CUST_PAYME" && $p_amount['type']!=NULL){
                        $paid =$p_amount['journal_amount']*-1;
                         $total = $balance+$paid;
                         $c_percent=$paid/$total*100;
                    }
                    else{
                      $c_percent=0;
                      $paid=0;
                      $total = $balance;
                    }
                     
                      if($total==0)
                      {
                        $net=1;
                      }
                      else{
                        $net=$total;
                      }
                      $customer_balance = $total-$paid;
                      
                      // $balance=$balance+$result['journal_amount'];
                      // var_dump($customer_balance);
                      if($p_amount['sale_representative']==NULL)
                      {
                        $representative='---';
                      }
                      else{
                        $representative=$p_amount['sale_representative'];
                      }
                      // if($result['type']=="CUST_PAYME"){                    
                        // $paid = 50;
                      if($total==null)
                      {
                        $total=0;
                      }
                      else{
                        $total=$total;
                      }
                      if($paid==0)
                      {
                        $date=date($this->language->get('date_format'), strtotime($post_data['start_date']));
                      }
                      else{
                         $date=date($this->language->get('date_format'), strtotime($p_amount['entry_date']));
                      }
                        $report['records'][] = array( 
                                'sno'       => $sno,  
                                'custName'       => $result['customer_name'],                              
                                'date'       => $date,
                                'balance'    =>number_format($total,2,'.',''),
                                'paid'       => number_format($paid,2,'.',''),                      
                                'saleRep'       =>$representative,                      
                                'r_balance'       => number_format($customer_balance,2,'.',''),                              
                                'c_percent'       => bcdiv($c_percent, 1, 2),                              
                                'is_type'       => 'entry'
                         );    

                                         
                         $sno = $sno + 1;
                         // var_dump($customer_balance);
                          $group_balance = $group_balance+$customer_balance;
                          $total_rbalance = $total_rbalance +$customer_balance;
                          
                          if($total_balance==0)
                          {
                            $total_balance =1;
                          }
                          else{
                          $total_balance =$total_balance+$total;  
                          }    
                          $group_total = $group_total +$total;
                          $group_paid = $group_paid +$paid;
                          if($group_total==0)
                          {
                           $c_total_percent=$group_paid/1*100;  
                          }
                          else{
                            $c_total_percent=$group_paid/$group_total*100;  
                           
                          }
                              
                       // }
                       // else{
                       //     $paid = 0;
                       // }
                       
                       
                     
                      //$group_paid = $group_paid + $paid;                      
                      // $group_balance =  $customer_balance;
                       // $group_balance = $group_balance+ $customer_balance;
                      

                      $total_paid = $total_paid + $paid;
                      

                      $total_percent=$total_paid/$total_balance*100;

                    }
                    else{
                       $total = $pre_row['pre_total'] + $result['journal_amount']*-1;
                      if($total==0)
                      {
                        $net=1;
                      }
                      else{
                        $net=$total;
                      }
                      $customer_balance = $total - $result['journal_amount']*-1;
                      $c_percent=$result['journal_amount']*-1/$net*100;
                      // $balance=$balance+$result['journal_amount'];
                      // var_dump($customer_balance);
                      
                      if($result['type']=="CUST_PAYME" ){                    
                        $paid =  $result['journal_amount']*-1;
                        $report['records'][] = array( 
                                'sno'       => $sno,  
                                'custName'       => $result['customer_name'],                              
                                'date'       => date($this->language->get('date_format'), strtotime($result['entry_date'])),
                                'balance'    =>number_format($total,2,'.',''), 
                                'paid'       => number_format($paid,2,'.',''),                      
                                'saleRep'       =>$result['sale_representative'],                      
                                'r_balance'       => number_format($customer_balance,2,'.',''),                              
                                'c_percent'       => number_format($c_percent,2,'.',''),                              
                                'is_type'       => 'entry'
                         );                         
                         $sno = $sno + 1;
                         // var_dump($customer_balance);
                          $group_balance = $group_balance+$customer_balance;
                          $total_rbalance = $total_rbalance +$customer_balance;
                          
                          if($total_balance==0)
                          {
                            $total_balance =1;
                          }
                          else{
                          $total_balance =$total_balance+$total;  
                          }    
                          $group_total = $group_total +$total;
                          $group_paid = $group_paid +$paid;
                          $c_total_percent=$group_paid/$group_total*100;   
                       }
                       else{
                           $paid = 0;
                       }
                       
                       
                     
                      //$group_paid = $group_paid + $paid;                      
                      // $group_balance =  $customer_balance;
                       // $group_balance = $group_balance+ $customer_balance;
                      

                      $total_paid = $total_paid + $paid;
                      

                      $total_percent=$total_paid/$total_balance*100;

                    }
                  }
                
                 
                 $report['records'][] = array( 
                        'cat_total'       =>'Total '.$group,
                        'category_total'       =>number_format($group_total,2,'.',''),                            
                        'cat_balance'       =>number_format($group_balance,2,'.',''),                         
                        'cat_paid'       =>number_format($group_paid,2,'.',''),                                                        
                        'cat_percent'       =>bcdiv($c_total_percent, 1, 2),                                                
                        'is_type'       => 'cat_total'
                  );
                 
                  $report['records'][] = array( 
                    'grand_total'       =>'Grand Total',                    
                    'total_balance'       =>number_format($total_balance-1,2,'.',''),                         
                    'total_paid'       =>number_format($total_paid,2,'.',''),                         
                    'total_rbalance'       =>number_format($total_rbalance,2,'.',''),                                             
                    'total_percent'       =>bcdiv($total_percent, 1, 2),                                             
                    'is_type'       => 'total'
                   );
                  
                  
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function incomestatment(){
             
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reports');
                  $report['report_id'] = $post_data['report_id'];
                  $report['report_name'] = $post_data['report_name'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $sale =  $this->model_reports_reports->get_sale($post_data);
                  $cost =  $this->model_reports_reports->get_cost($post_data);
                  $discount =  $this->model_reports_reports->get_discount($post_data);
                  $sales = $sale-$discount;
                  
                  
                  
                 
                 $margin = $sales-$cost;
                 if($cost>"0"){
                     $per = ($margin/$sales) * 100; 
                  } else { 
                     $per = ($margin/1) * 100; 
                  }
                 $report['records'][] = array( 
                        'description'               =>'SALES',                            
                        'total_sale_amount'         =>number_format($sale,2,'.',''),                         
                        'discount'                  =>number_format($discount,2,'.',''),
                        'sale_amount'               =>number_format($sales,2,'.',''),
                        'purchase_amount'           =>number_format($cost,2,'.',''),
                        'margin_amount'             =>number_format($margin,2,'.',''),
                        'Profit_lost_per'           =>number_format($per,2,'.',''),
                        'is_type'                   =>'income_sale'
                  );
                $sale_return =  $this->model_reports_reports->get_sale_return($post_data);
                if($sale_return!=0){
                $cost_return =  $this->model_reports_reports->get_cost_return($post_data);
                $discount_return =  $this->model_reports_reports->get_discount_return($post_data);
                $sales_return = $sale_return-$discount_return;
                // $margin_return = $sales_return+$cost_return;
                $margin_return = $sales_return-$cost_return;
                $mar_cost= (-1*$cost_return);
                  // echo $mar_cost;exit;
                if($mar_cost>"0"){
                     $ret_per = ($margin_return/$mar_cost) * 100; 
                  } else { 
                     $ret_per = ($margin_return/1) * 100; 
                  }
                 
                $report['records'][] = array( 
                        'description'               =>'SALES RETURN',                            
                        'total_sale_return_amount'         =>number_format($sale_return,2,'.',''),                         
                        'discount_return'                  =>number_format($discount_return,2,'.',''),
                        'sale_return_amount'               =>number_format($sales_return,2,'.',''),
                        'purchase_return_amount'           =>number_format($cost_return,2,'.',''),
                        'margin_return_amount'             =>number_format($margin_return,2,'.',''),
                        'ret_Profit_lost_per'             =>number_format($ret_per,2,'.',''),
                        'is_type'                   =>'income_sale_return'
                  );
                 
                $net_sale = $sale-$sale_return;
                $net_discount = $discount-$discount_return;
                $net_sales = $sales-$sales_return;
                // $net_cost = $cost-$cost_return;
                $net_cost = $cost-$cost_return;
                $net_margin = $margin-$margin_return;
                // if($cost>"0"){
                // $per_net = ($margin-$margin_return)/($cost) * 100;
                // } else {
                // $per_net = ($margin-$margin_return)/(1) * 100;    
                // }

                if($net_cost>"0"){
                $per_net = $net_margin/($net_sales) * 100;
                } else {
                $per_net = $net_margin/(1) * 100;    
                }
                $report['records'][] = array( 
                        'description'               =>'NET SALES',                            
                        'total_sale_net_amount'         =>number_format($net_sale,2,'.',''),                         
                        'discount_net'                  =>number_format($net_discount,2,'.',''),
                        'sale_net_amount'               =>number_format($net_sales,2,'.',''),
                        'purchase_net_amount'           =>number_format($net_cost,2,'.',''),
                        'margin_net_amount'             =>number_format($net_margin,2,'.',''),
                        'net_per'                       =>number_format($per_net,2,'.',''),
                        'is_type'                   =>'income_net_sale'
                  );
                }  
                 $expences =  $this->model_reports_reports->get_expense($post_data);
                 $total_expense = 0;
                 foreach ($expences as $result) {                    
                    $amount = $result['amount']<0 ? $result['amount']*-1:$result['amount']; 
                    $report['records'][] = array( 
                      'title'       =>$result['account_name'],                         
                      'amount'       =>number_format(($amount*-1),2,'.',','),                                                       
                      'is_type'       => 'expense'                            
                     );                        
                    $total_expense = $total_expense + $amount;
                 } 
                 if($sale_return>0){
                 $total_amount = $net_margin-$total_expense;
                 if($net_cost>"0"){
                 $total_per = ($total_amount/$net_sales)*100;
                 } else {
                 $total_per = ($total_amount/1)*100;    
                 }
                 } else {
                 $total_amount = $margin-$total_expense;
                 if($cost>"0"){
                   $total_per = ($total_amount/$sales)*100;  
                 } else {
                    $total_per = ($total_amount/1)*100; 
                 }  
                 }
                 $report['records'][] = array( 
                    'title'       =>'Total Income',                         
                    'amount'     =>number_format($total_amount,2,'.',','),
                    'total_per'     =>number_format($total_per,2,'.',','),
                    'is_type'       => 'total_income'
                 ); 
             }
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         public function getVendorTransSummary(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "21";
                 $report['report_name'] = $post_data['report_name'];                 
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_account_payable($post_data);
                 $total_amount_credit = 0;
                 $total_amount_debit = 0;
                 $total_amount_balance = 0;
                 $total_total = "";
                 $group = "";
                 $total = "";
                 $total_opening_balance = "";
                 $group_amount=0;
                 $sno = 1;
                 $opening_balance=0;
                 $qty=0;
                 $i_qty=0;
                  foreach ($report_lines as $result) {                      
                      $amount = $this->model_reports_reports->getBillPayable($result['vendor_acc_id'],$post_data);
                      $opening_balance = $this->model_reports_reports->getOpeningBalance($result['vendor_acc_id']);
                      $qty = $this->model_reports_reports->get_vendor_qty($post_data,$result['vendor_id']);
                      // echo $qty;exit;
                     
                      
                      $amount_credit = $amount["credit"]*-1;
                      $amount_debit = $amount["debit"]; 
                      $total = $opening_balance + $amount_credit;
                      $amount_balance = $total - $amount_debit;
                      if($amount_balance>0){
                            $report['records'][] = array( 
                              'sno'         => $sno,    
                              'vendor_id'     => $this->getNo("VENDOR",$result['vendor_id']),
                              'vendor_name'   =>$result['vendor_name'],
                              'opening_balance' =>number_format($opening_balance,2,'.',''),
                              'quantity'        =>number_format($qty,2,'.',''),
                              'amount_credit'       =>number_format($amount_credit,2,'.',''),
                              'total'               =>  number_format($total,2,'.',''),
                              'amount_debit'       =>number_format($amount_debit,2,'.',''),
                              'balance'       =>number_format($amount_balance,2,'.',''),
                              'is_type'       => 'entry'
                          );                          
                          $total_amount_credit = $total_amount_credit + $amount_credit;
                          $total_amount_debit = $total_amount_debit + $amount_debit;
                          $total_amount_balance = $total_amount_balance + $amount_balance;
                          $total_total = $total + $total_total;
                          $total_opening_balance = $total_opening_balance + $opening_balance;
                          $sno = $sno +1;
                      }
                      
                  }   
                  
                  
                  $report['records'][] = array( 
                        'total'       =>'Total', 
                      'total_opening_balance'       =>$total_opening_balance,
                        'total_amount_credit'       =>number_format($total_amount_credit,2,'.',''),
                      'total_total'                 =>$total_total,
                        'total_amount_debit'        =>number_format($total_amount_debit,2,'.',''),
                        'total_amount_balance'      =>number_format($total_amount_balance,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
         }
         public function getVendorPaymentSummary(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "23";
                 $report['report_name'] = $post_data['report_name'];                 
                 $report['end_date'] = $post_data['end_date'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_vendor_payment($post_data);
                 $vendor_total_pay_amount = 0;
                 $total_pay_amount = 0;
                 $sno = 1;
                 $vendor="";
                 foreach ($report_lines as $result) {

                    if($vendor!=$result['vendor_name']){
                        if($vendor_total_pay_amount!=0){
                        $report['records'][] = array( 
                            'text'       =>'Total ' .$vendor,                        
                            'vendor_total_pay_amount'       =>number_format($vendor_total_pay_amount,2,'.',''),
                            'is_type'       => 'vendor_total'
                        );
                        $vendor_total_pay_amount = 0;
                        }
                    }
                    $vendor=$result['vendor_name'];  
                    if($result['journal_amount']!=="0"){
                        $report['records'][] = array( 
                            'sno'         => $sno,
                            'vendor_name'   =>$result['vendor_name'],
                            'pay_method' =>$this->model_reports_reports->getVendorPayType($result['ref_id']),
                            'pay_date'       =>date($this->language->get('date_format'), strtotime($result['entry_date'])),
                            'pay_amount'               =>  $result['journal_amount'],
                            'des'       =>$result['journal_details'],
                            'is_type'       => 'entry'
                        );
                     }
                        $vendor_total_pay_amount = $vendor_total_pay_amount + $result['journal_amount'];
                        $total_pay_amount = $total_pay_amount + $result['journal_amount'];
                        $sno = $sno +1;
                    }   
                  $report['records'][] = array( 
                            'text'       =>'Total ' .$vendor,                        
                            'vendor_total_pay_amount'       =>number_format($vendor_total_pay_amount,2,'.',''),
                            'is_type'       => 'vendor_total'
                        );
                  $report['records'][] = array(                        
                        'total_pay_amount'       =>number_format($total_pay_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
                  
                 
                  
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
         }
         public function getPurchaseOrderSummary(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "24";
                 $report['show_invoice_detail'] = $post_data['show_invoice_detail'];
                 if($post_data['show_invoice_detail']=="0"){
                 $report['report_name'] = $post_data['report_name'];
                 } else {
                 $report['report_name'] = 'Purchase Invoice Detail Summary';    
                 }
                 $report['end_date'] = $post_data['end_date'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 if($post_data['show_invoice_detail']=="0"){
                 $report_lines =  $this->model_reports_reports->get_purchase_order_summary($post_data);
                 $total_vend_po_amount = $total_vend_po_qty = $all_vend_total_po_amount = $all_vend_total_po_qty = 0;
                 $sno = 1;
                 foreach ($report_lines as $result) {
                    $qty = $this->model_reports_reports->getPurchaseInvoiceQty($result['po_id']);
                    $vendor=$result['po_vend_name'];  
                    if($result['po_amount']!=="0"){
                        $date = explode(" ", $result['po_date']);
                        $report['records'][] = array( 
                            'sno'                   => $sno,
                            'po_date'               =>$date[0],
                            'po_vend_name'          => $result['po_vend_name'],
                            'po_no'                 => $result['po_no'],
                            'po_amount'             =>  $result['po_amount'],
                            'po_qty'                =>$qty,
                            'is_type'               => 'entry'
                        );
                     }
                        $total_vend_po_amount = $total_vend_po_amount + $result['po_amount'];
                        $total_vend_po_qty = $total_vend_po_qty + $qty;
                        
                        $all_vend_total_po_amount = $all_vend_total_po_amount + $result['po_amount'];
                        $all_vend_total_po_qty = $all_vend_total_po_qty + $qty;
                        $sno = $sno +1;
                    }   
                  $report['records'][] = array(                        
                        'all_vend_total_po_amount'       =>number_format($all_vend_total_po_amount,2,'.',''),
                        'all_vend_total_po_qty'       =>number_format($all_vend_total_po_qty,2,'.',''),
                        'is_type'       => 'total'
                    );
                  
             } else {
                 $report_lines =  $this->model_reports_reports->get_purchase_order_detail_summary($post_data);
                 $inv_sub_total = $total = $inv_total_qty = $total_qty = $invoice_no = 0;
                 foreach ($report_lines as $result){
                     
                     if($invoice_no!=$result['po_no']){
                         if($inv_sub_total>0){
                            $report['records'][] = array(                        
                                   'inv_sub_total'       =>$inv_sub_total,
                                'inv_total_qty'      => $inv_total_qty,
                                   'is_type'             => 'inv_sub_total'
                               );
                         }
                            $inv_sub_total= $inv_total_qty = 0;
                            $invoice_no=$result['po_no'];
                 }
                 
                 $date = explode(" ", $result['po_date']);
                 $report['records'][] = array( 
                            'date'                   => $date[0],
                            'vendor_name'               =>$result['po_vend_name'],
                            'item_name'          => $result['item_name'],
                            'barcode'                 => $result['code'],
                            'invoice_no'             =>  $result['po_no'],
                            'purchase_price'                =>$result['inv_item_price'],
                            'sale_price'                =>$result['inv_item_sprice'],
                            'quantity'                =>$result['inv_item_quantity'],
                            'sub_total'                =>$result['inv_item_subTotal'],
                            'is_type'               => 'purchase_invoice_detail'
                        );
                        $inv_sub_total = $inv_sub_total + $result['inv_item_subTotal'];
                        $total = $total + $result['inv_item_subTotal'];
                        $inv_total_qty = $inv_total_qty + $result['inv_item_quantity'];
                        $total_qty = $total_qty + $result['inv_item_quantity'];
                        
                 }
                 $report['records'][] = array(                        
                                   'inv_sub_total'       =>number_format($inv_sub_total,2,'.',''),
                                    'inv_total_qty'      => $inv_total_qty,
                                   'is_type'             => 'inv_sub_total'
                 );
                 
                 $report['records'][] = array(                        
                                   'total'       =>number_format($total,2,'.',''),
                                    'total_qty'                    => $total_qty,
                                   'is_type'             => 'total'
                 );
             }
                  
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
         }
         public function getVendorWiseSaleReport(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "25";
                 $report['show_invoice_detail'] = $post_data['show_invoice_detail'];
                 if($post_data['show_invoice_detail']=='0'){
                 $report['report_name'] = $post_data['report_name'];
                 } else {
                 $report['report_name'] = $post_data['report_name'] . " Summary";    
                 }
                 $report['end_date'] = $post_data['end_date'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_vendor_wise_saleReport_summary($post_data);
                  $per = ""; $vendor_name = "";
                  
                    
                 $vand_total_sold_qty = $vand_total_amount = $vand_total_cost = $vand_total_margin = 0;
                 $vand_grand_total_sold_qty = $vand_grand_total_amount = $vand_grand_total_cost = $vand_grand_total_margin  = 0;
                 foreach ($report_lines as $result) {
                     $detail =  $this->model_reports_reports->get_vendor_wise_saleReport_summary_detail($post_data,$result['item_id']);
                     $detail_return =  $this->model_reports_reports->get_vendor_wise_saleReturnReport_summary_detail($post_data,$result['item_id']);
                     
                     
                     $sale_qty = $detail[0]['sold_qty'];
                     $sale_price = $detail[0]['amount']-$detail[0]['discount'];
                     $sale_cost = $detail[0]['cost'];
                     
                     $return_qty = -1*$detail_return[0]['sold_qty'];
                     $return_price = (-1*$detail_return[0]['amount'])-(-1*$detail_return[0]['discount']);
                     $return_cost = -1*$detail_return[0]['cost'];
                     
                     $qty = $sale_qty - $return_qty;
                     $sale = $sale_price - $return_price;
                     $cost = $sale_cost - $return_cost;
                     
                     $margin = $sale - $cost;
                     if($sale < 1 ){
                         $per = (($sale - $cost)/1)*100;
                     } else {
                         $per = (($sale - $cost)/$sale)*100;
                     }
                      
                     if($vendor_name!=$result['vendor_name']){
                         if($vand_total_sold_qty>0){
                     $report['records'][] = array( 
                            'vendor_name'       =>  $vendor_name,
                            'vand_total_sold_qty'     =>$vand_total_sold_qty,
                            'vand_total_amount'       =>number_format($vand_total_amount,2,'.',''),
                            'vand_total_cost'       =>number_format($vand_total_cost,2,'.',''),
                            'vand_total_margin'       =>number_format($vand_total_margin,2,'.',''),
                            'is_type'                 => 'vand_total'
                        );
                     
                     }
                     $vand_total_sold_qty = $vand_total_amount = $vand_total_cost = $vand_total_margin = 0;
                     $vendor_name = $result['vendor_name'];
                     }
                     if($qty>0){
                        $report['records'][] = array( 
                            'item_name'             => $result['item_name'],
                            'barcode'              =>  $result['barcode'],
                            'sold_qty'              =>  $qty,
                            'amount'                =>  number_format($sale,2,'.',''),
                            'cost'                  =>  number_format($cost,2,'.',''),
                            'margin'                =>  number_format($margin,2,'.',''),
                            'per'                =>  number_format($per,4,'.',''),
                            'is_type'               => 'entry'
                        );
                    
                        $vand_total_sold_qty        = $vand_total_sold_qty + $qty;
                        $vand_total_amount          = $vand_total_amount + $sale;
                        $vand_total_cost            = $vand_total_cost + $cost;
                        $vand_total_margin          = $vand_total_margin + $margin;
                        
                        
                        $vand_grand_total_sold_qty        = $vand_grand_total_sold_qty + $qty;
                        $vand_grand_total_amount          = $vand_grand_total_amount + $sale;
                        $vand_grand_total_cost            = $vand_grand_total_cost + $cost;
                        $vand_grand_total_margin          = $vand_grand_total_margin + $margin;
                       } 
                         
                 }
                    if($vand_total_sold_qty>0){
                        $report['records'][] = array(  
                            'vendor_name'       =>  $vendor_name,
                            'vand_total_sold_qty'     =>$vand_total_sold_qty,
                            'vand_total_amount'       =>number_format($vand_total_amount,2,'.',''),
                            'vand_total_cost'       =>number_format($vand_total_cost,2,'.',''),
                            'vand_total_margin'       =>number_format($vand_total_margin,2,'.',''),
                            'is_type'                 => 'vand_total'
                        );
                    }
                        $report['records'][] = array(                        
                            'vand_grand_total_sold_qty'     =>$vand_grand_total_sold_qty,
                            'vand_grand_total_amount'       =>number_format($vand_grand_total_amount,2,'.',''),
                            'vand_grand_total_cost'       =>number_format($vand_grand_total_cost,2,'.',''),
                            'vand_grand_total_margin'       =>number_format($vand_grand_total_margin,2,'.',''),
                            'is_type'                 => 'vand_grand_total'
                        );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
         }
         public function getLoanPayReciev(){
             $report = array();
             $report_lines;
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "48";
                 if($post_data['print_loan_report']==0){
                    $report['report_name'] = 'Payable Loans Report';
                 } else {
                     $report['report_name'] = 'Receivable Loans Report';
                 }
                 $report['print_category_report'] = $post_data['print_loan_report'];
                 $report['start_date'] = $post_data['start_date'];                 
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 
                 if($post_data['print_loan_report']==0){
                    $report_lines =  $this->model_reports_reports->getPayableLoan($post_data);
                 } else {
                     $report_lines =  $this->model_reports_reports->getReceivableLoan($post_data);
                 }
                 $total= 0; $sno='1';
                    foreach ($report_lines as $result) {
                        if($result['amount']!=0){
                            $report['records'][] = array( 
                                'sno'                => $sno,
                                'account_title'       =>$result['acc_name'],
                                'account_amount' => number_format($result['amount'],2,'.',','),
                                'is_type'       => 'loan'                            
                              ); 
                            }
                     $sno = $sno +1;
                     $total = $total + $result['amount'];
                    }
                      

                    $report['records'][] = array(
                             'title'       =>'Total',
                            'total_amount'       => number_format($total,2,'.',''),                           
                            'is_type'       => 'total_loan'
                             );
                      
                      
                  
                 }    
                 
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }

         public function getVendors(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "21";
                 $report['report_name'] = $post_data['report_name'];                 
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->getVendors($post_data);
                 
                 $sno = 1;
                  foreach ($report_lines as $result) {  
                            $report['records'][] = array( 
                              'sno'         => $sno,    
                              'vendor_name'   =>$result['vendor_name'],                              
                              'vendor_mobile'   =>$result['vendor_mobile'],
                              'vendor_phone'   =>$result['vendor_phone'],
                              'is_type'       => 'vendor'
                          );                          
                          $sno = $sno +1;
                      
                  }   
                  
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
         }
         
         public function getCustomerTransSummary(){         
            $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = "8";
                 $report['report_name'] = $post_data['report_name'];                 
                 //$report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];                  
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $report_lines =  $this->model_reports_reports->get_account_receivable($post_data,false,true);
                 $total_amount_debit = 0;
                 $total_amount_credit = 0;
                 $total_amount_balance = 0;
                 $group = "";
                 $group_amount_credit=0;
                 $group_amount_debit=0;
                 $group_amount_balance=0;
                 $amount_credit = 0;
                 $amount_debit = 0;
                 $amount_balance = 0;
                 $sno = 1;
                  foreach ($report_lines as $result) {
                    if($group!=$result['group_name']){
                        
                            if($group_amount_debit>1 || $group_amount_credit <0){
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$group,                                     
                                  'cat_amount_debit'       =>number_format($group_amount_debit,2,'.',''),
                                  'cat_amount_credit'       =>number_format($group_amount_credit,2,'.',''),
                                  'cat_amount_balance'       =>number_format($group_amount_balance,2,'.',''),  
                                  'is_type'       => 'cat_total'
                             );
                            }
                            
                             $group_amount_debit=0;
                             $group_amount_credit=0;                             
                             $group_amount_balance = 0;
                        
                        $group = $result['group_name'];
                            $report['records'][] = array( 
                             'category_id'       =>$result['cust_group_id'],    
                             'category_name'       =>$group,                         
                             'is_type'       => 'category'
                        );
                                                  
                     }  
                      $amount_row = $this->model_reports_reports->getBillReceivable($result['cust_acc_id'],$post_data);
                      $amount_debit = $amount_row["debit"];
                      $amount_credit = $amount_row["credit"]*-1;
                      $amount_balance = number_format($amount_debit,2,'.','') - number_format($amount_credit,2,'.','');
                      
                      if($amount_balance!=0){
                        $report['records'][] = array( 
                            'sno'         => $sno,    
                            'cust_id'     => $this->getNo("CUST",$result['cust_id']),
                            'cust_name'   =>$result['cust_name'],
                            'opening_balance' =>number_format($result['opening_balance'],2,'.',''),
                            'cust_type'   =>$result['type_name'],  
                            'amount_debit'       =>number_format($amount_debit,2,'.',''),
                            'amount_credit'       =>number_format($amount_credit,2,'.',''),
                            'amount_balance'       =>number_format($amount_balance,2,'.',''),
                            'is_type'       => 'entry'
                        );
                      
                      $group_amount_credit = $group_amount_credit + $amount_credit;  
                      $group_amount_debit = $group_amount_debit + $amount_debit;  
                      $group_amount_balance = $group_amount_balance + $amount_balance;  
                      
                      $total_amount_debit = $total_amount_debit + $amount_debit;
                      $total_amount_credit = $total_amount_credit + $amount_credit;
                      $total_amount_balance = $total_amount_balance + $amount_balance;
                      $sno = $sno +1;
                      }
                  }
                  $report['records'][] = array( 
                        'cat_total'       =>'Total '.$group,                                     
                        'cat_amount_debit'       =>number_format($group_amount_debit,2,'.',''),
                        'cat_amount_credit'       =>number_format($group_amount_credit,2,'.',''),
                        'cat_amount_balance'       =>number_format($group_amount_balance,2,'.',''),  
                        'is_type'       => 'cat_total'
                   );
                  
                  //Print walk in customer
                  $amount_walkincustomer =  $this->model_reports_reports->getWalkinCustomer($post_data); 
                  $report['records'][] = array( 
                          'sno'         => $sno,    
                          'cust_id'     => $this->getNo("CUST",0),
                          'cust_name'   =>'Walk In Customer',
                          'cust_type'   => 'Default',  
                          'amount_debit'       =>number_format($amount_walkincustomer,2,'.',''),
                          'amount_credit'       =>number_format($amount_walkincustomer,2,'.',''),
                          'amount_balance'       =>number_format(0,2,'.',''),
                          'is_type'       => 'unknown'
                      );
                  $total_amount_debit = $total_amount_debit + $amount_walkincustomer;
                  $total_amount_credit = $total_amount_credit + $amount_walkincustomer;
                  
                  $report['records'][] = array( 
                        'total'       =>'Total',                        
                        'total_debit'       =>number_format($total_amount_debit,2,'.',''),
                        'total_credit'       =>number_format($total_amount_credit,2,'.',''),
                        'total_balance'       =>number_format($total_amount_balance,2,'.',''),
                        'is_type'       => 'total'
                    );
             }    
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }

        public function getstocktransfer()
        {
          $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];  
                 $warehouse=$post_data['warehouse'];                
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');

                    $report_lines =  $this->model_reports_reports->get_stock_transfer($post_data);
                 
                 
                 $category = "";
                 $w_invoice = "";
                 $category_qty = 0;
                 $total_qty = 0;
                 $qty='';
                 foreach ($report_lines as $result) {


                      if($post_data['warehouse_type']==1)
                      {
                         if($w_invoice!=$result['invoice_no']){  
                            $w_invoice = $result['invoice_no'];
                             $report['records'][] = array( 
                                  'cat_nvoice'       =>'Inv#'. $w_invoice,                                                           
                                  'is_type'       => 'ware_invoice'
                             );                                            
                         
                     }
                       
                      }
                      else{
                        
                       
                         if($category!=$result['category']){
                          if($category_qty!=0){                            
                             $report['records'][] = array( 
                                  'cat_total'       =>'Total '.$category,   
                                  'cat_qty'       => number_format($category_qty,2,'.',''),                                                           
                                  'is_type'       => 'cat_total'
                             );                            
                             $category_qty =0;                             
                        }
                        
                        $category = $result['category'];
                           $report['records'][] = array( 
                           'category_name' =>$category,                         
                           'is_type'       => 'category'
                          );
                     }
                      }

                        $cotton=$result['unitname'].'('.$result['conv_from'].')';
                          $report['records'][] = array( 
                              'product_name'       => $result['item_name'],
                              'from_warehouse'       => $result['from_warehouse'],  
                              'qty'           => number_format($result['qty'],2,'.',''),
                              'cotton'           => $cotton,
                              'to_warehouse'        =>$result['to_warehouse'],                                                   
                              'date'        =>$result['date'],                                                   
                              'is_type'       => 'product'
                         );
                         $category_qty = $category_qty + $result['qty']; 
                         $total_qty = $total_qty + $result['qty'];

                          }
                         if($category_qty>0){
                      $report['records'][] = array( 
                                      'cat_total'       =>'Total '.$category,   
                                      'cat_qty'       => number_format($category_qty,2,'.',''),        
                                      'is_type'       => 'cat_total'
                               );
                    }


                  $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_qty'       =>       number_format($total_qty,2,'.',''),
                        'is_type'       => 'total'
                    );  
                     


                 $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));  

        }

      }

      public function getreorderingpoint()
      {
        $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];
                 $warehouse=$post_data['warehouse'];   
                 $category="";  
                 $warehouses="";
                 $vendor='';           
                 $qty='';           
                 $p_price='';           
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');

                  $report_lines =  $this->model_reports_reports->get_stock_reordering_point($post_data);

                  foreach ($report_lines as $result) {

                       $item_data = $this->model_reports_reports->getlast_vendor($result['item_id']);
                        $qty = $this->model_reports_reports->get_reoder_item_qty($result['item_id'],$result['warehouse_id']);
                         if($post_data['below_order_point']==1)
                        {
                          if($qty<$result['reorder_qty'])
                          {
                       if($item_data[0]['vendor_name']==NULL)
                       {
                        $vendor='----';
                       }
                       else{
                        $vendor=$item_data[0]['vendor_name'];
                       }
                         if($item_data[0]['purchase_price']==NULL)
                       {
                        $p_price='0';
                       }
                       else{
                        $p_price=$item_data[0]['purchase_price'];
                       }

                      if($warehouses !=$result['warehouse_name'])
                        {
                        

                         $warehouses=$result['warehouse_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }

                       if($category!=$result['category']){
                         
                        $category = $result['category'];
                           $report['records'][] = array( 
                           'category_name' =>$category,                         
                           'is_type'       => 'category'
                          );
                     }
                       
                             $report['records'][] = array( 
                              'product_name'       => $result['item_name'],
                              'category'       => $result['category'],
                              'last_vendor'       => $vendor,  
                              'current_qty'           => $qty,
                              // 'sale_price'           => number_format($trade,2,'.',''),
                              'reorder_point'        =>$result['reorder_qty'],                                                   
                              'unit_price'        =>$p_price,                                                   
                              'is_type'       => 'product'
                         );     
                          }
                      
                        }
                        else{
                          if($item_data[0]['vendor_name']==NULL)
                       {
                        $vendor='----';
                       }
                       else{
                        $vendor=$item_data[0]['vendor_name'];
                       }
                         if($item_data[0]['purchase_price']==NULL)
                       {
                        $p_price='0';
                       }
                       else{
                        $p_price=$item_data[0]['purchase_price'];
                       }

                      if($warehouses !=$result['warehouse_name'])
                        {
                        

                         $warehouses=$result['warehouse_name'];
                          $report['records'][]= array('warehouse_name' =>$warehouses ,
                                                      'is_type'       =>'warehouse'
                           );
                           
                        }

                       if($category!=$result['category']){
                         
                        $category = $result['category'];
                           $report['records'][] = array( 
                           'category_name' =>$category,                         
                           'is_type'       => 'category'
                          );
                     }
                       
                             $report['records'][] = array( 
                              'product_name'       => $result['item_name'],
                              'category'       => $result['category'],
                              'last_vendor'       => $vendor,  
                              'current_qty'           => $qty,
                              // 'sale_price'           => number_format($trade,2,'.',''),
                              'reorder_point'        =>$result['reorder_qty'],                                                   
                              'unit_price'        =>$p_price,                                                   
                              'is_type'       => 'product'
                         );     
                        }
                       
                  }
               }
               $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));  
      }

      public function getCustomerAging()
      {

        $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                  $this->load->model('account/register'); 
                   $this->load->model('common/common'); 
                 $report['report_id'] = $post_data['report_id'];
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];       
                 $report['company_name'] =  $this->config->get('config_owner');
                 $invoice=$payment=$balance =$add_sale=0;$thirty=0;$overninty=0;
                 $sale_return = false;
                 $des=$show=$customer=$class='';$accID=0;
                 $prev=$sub1=$sub=$inc1=$inc=$i=$current=$lessthen30=$alldec=$inc2=$inc3=$inc4=$lessthen60=$lessthen90=$over90=$alldec1=$alldec2=$alldec3=$alldec4=0;
                 $sixty=0;$ninty=0;$thirty=0;$overninty=0;
                 $sql="SELECT * FROM customer WHERE cust_id=".$post_data['customer_id']."";
                 $query = $this->db->query($sql);
                 $row= $query->row;
                  $results = $this->model_reports_reports->get_customer_RegisterPaid($post_data); 
                   $pre_row = $this->model_reports_reports->getPreviousCustBalance($post_data);
                    if($customer!=$row['cust_name'])
                        {
                          $customer=$row['cust_name'];
                           $report['records'][] = array(                                                        
                                 'payee'=> $customer,
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => '',
                            'account'       => '',         
                            'detail'       =>  '',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => '',
                            'class'       => '',
                            'is_type'       =>'customer'
                         );
                        } 
                 if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                  $prev=$pre_row["pre_total"];
                 }
                 else{
                  $prev=0;
                 }
                    // $sdate = isset($post_data['start_date']) ? date($this->language->get('date_format_short'), strtotime($post_data['start_date']) ):"";
                 
                    $report['records'][] = array(                                  
                            'payee'=> $customer,
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => '',
                            'account'       => '',         
                            'detail'       =>  'Opening Balance',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => number_format($prev,2,'.',''),
                            'class'       => 'invoice',
                            'is_type'       =>'previous' 
                    );
                    $balance = $pre_row["pre_total"];
                 foreach ($results as $result) {                                      
                    $increase = $result['journal_amount']>0?$result['journal_amount']:0;
                    $decrease =  $result['journal_amount']<0?-1*$result['journal_amount']:0;
                    $balance = $balance + $increase + -1*($decrease);                   
                   if( $result["num"]>0 &&  $i+1 < count($results) && $results[$i+1]["num"]==$result["num"] && (($results[$i+1]["acc_id"]==$result["acc_id"] && ($results[$i+1]["acc_id"]=="5"  || $results[$i + 1]["acc_id"] == "11")) || $results[$i+1]["journal_type"]=="DIS")){    
                      
                           if($results[$i]["journal_type"]=="DIS"){
                           $add_sale = $add_sale - $increase ;

                       }
                       else{
                           if($increase>0){
                               $add_sale = $add_sale -$increase ; 
                               // echo $add_sale;
                               // echo $increase;                      
                           }
                           else{

                               $add_sale = $add_sale -$decrease ;                       
                               $sale_return = true;

                           }
                       } 


                                      
                       
                   }
                   else{                               
                         if($sale_return==false){                                                   
                            $increase = $increase -$add_sale;
                            $add_sale = 0; 
                            if($result["journal_type"]=="DIS" && $result['num']!=0){                                                                                    
                                $increase = $increase - $decrease;
                                $decrease = 0;
                            }
                            // else{
                            //   $decrease = -1*($decrease - $increase);
                            //     $increase = 0;
                            // }
                        }
                        else{
                            $sale_return = false;
                            $decrease = $decrease -$add_sale;
                            $add_sale = 0; 
                            if($result["journal_type"]=="DIS"){                                                                                    
                                $decrease = $decrease - $increase;
                                $increase = 0;
                            }
                        }


                        $todayDate= date($this->language->get('date_format'), strtotime($post_data['end_date']));
                        $paymentDate= date($this->language->get('date_format'), strtotime($result['entry_date']));
                        $date1=date_create($todayDate);
                        $date2=date_create($paymentDate);
                        $diff=date_diff($date1,$date2);
                        $days=$diff->format("%a");
                        // echo $days.',';
                        // $alldec +=$decrease;
                        if($days==0)
                        {
                          $alldec+=$decrease;
                          $inc +=$increase;
                          $current=$inc;
                        } elseif($days>0 && $days<=30)
                        {
                          $alldec4+=$decrease;
                          $inc4 +=$increase;
                          $lessthen30=$inc4;
                          // echo $lessthen30.',';
                        } elseif($days>30 && $days<=60)
                        {
                          $alldec3+=$decrease;
                          $inc3 +=$increase;
                          $lessthen60=$inc3;
                        } elseif($days>60 && $days<=90)
                        {
                          $alldec2+=$decrease;
                          $inc2 +=$increase;
                          $lessthen90=$inc2;
                        }
                        else{
                          $alldec1+=$decrease;
                          $inc1 +=$increase;
                         $over90=$inc1;
                        }
                        
                        // echo $alldec.',';
                        $payment=$this->model_reports_reports->getlast_payment($result['cust_acc_id']);
                        // var_dump($payment);exit;
                        if($payment==NULL){ $payment=0; }
                        if($payment<0) {$payment=-1*$payment; }
                        else{ $payment=$payment;}

                        if($over90!=0)
                        {
                          $overninty=$inc1-$payment;
                          if($overninty<0)
                           {
                            $over90=0;
                           }else{
                            $over90=$overninty;
                           } 
                        }
                        elseif($lessthen90!=0)
                        {
                         
                          if($over90<0)
                           {
                             $ninty=$inc2-$overninty;
                             if($ninty<0)
                             {
                              $lessthen90=0;
                             }else{
                            $lessthen90=$ninty; 
                             }

                            
                           }else{
                             $ninty=$inc2-$payment;
                               if($ninty<0)
                           {
                            $lessthen90=0;
                           }else{
                            $lessthen90=$ninty;
                           } 
                           } 
                        }
                        elseif($lessthen60!=0)
                        {
                         if($ninty<0)
                           {
                            $sixty=$inc3+$ninty;
                              if($sixty<0)
                           {
                            $lessthen60=0;
                           }else{
                            $lessthen60=$sixty;
                           }  
                            
                           }
                           else{
                            $sixty=$inc3-$payment;
                               if($sixty<0)
                           {
                            $lessthen60=0;
                           }else{
                            $lessthen60=$sixty;
                           } 
                           }
                          
                        }
                       elseif($lessthen30!=0)
                        {
                           
                           if($sixty<0)
                           {
                            $thirty=$inc4+$sixty;
                              if($thirty<0)
                           {
                            $lessthen30=0;
                           }else{
                            $lessthen30=$thirty;
                           }  
                            
                           }
                           else{
                            $thirty=$inc4-$payment;
                               if($thirty<0)
                           {
                            $lessthen30=0;
                           }else{
                            $lessthen30=$thirty;
                           } 
                           }
                          
                        }
                        else
                        {
                          if($thirty<0)
                          {
                          $current=$inc+$thirty; 
                          }
                          elseif($sixty<0)
                          {
                            $current=$inc+$sixty;
                          } 
                          elseif($ninty<0)
                          {
                            $current=$inc+$ninty;
                          } 
                          elseif($overninty<0)
                          {
                            $current=$inc+$overninty;
                          }
                          else{
                         $current=$inc+$payment;   
                         // echo $payment;
                          }
                          
                        }
                      

                         if($result['journal_type']=="DIS" && $result['num']!=0)
                        {
                        $des='Sale Inv';
                       }
                       elseif($result['journal_type']=="SALE_RET")
                       {
                         $des='S/Return Inv';
                       }
                       elseif($result['journal_type']=="CUST_OB")
                       {
                         $des='Uncategorized Income';
                       }
                       elseif($result['journal_type']=="SALE_RET_I")
                       {
                         $des='Income On S/R';
                       }
                       elseif($result['journal_type']=="S"  && $result['num']==0)
                       {
                         $des='Customer Register Charge';
                       }

                       elseif($result['journal_type']=="POS" && $result['item_id']!=0)
                       {
                         $des='POS Inv';
                       }

                       //  elseif($result['journal_type']=="S" && $result['description']=="Payment")
                       // {
                       //   $des='POS Inv Payment';
                       // }
                        elseif($result['journal_type']=="DIS" && $result['num']==0)
                       {
                         $des='Customer Register Discounts';
                       }
                        elseif($result['journal_type']=="CUST_PAYME")
                       {
                         $des='Customer Register Payment';
                       }
                        elseif($result['journal_type']=="S" && $result['description']=="Payment")
                       {
                         $des='Sale-Inv-Payment';
                       }
                       else{
                        $des=$result['journal_type'];
                           }                          
                        
                        $description = $result['num']?$this->model_account_register->getDescriptionSO($result['num']):$result['description'];
                        $salesrepdetail = $this->model_account_register->getSalesRepName($result['ref_id']);
                       
                     

                       if( $result['journal_type']=="DIS"  && $result['num']==0 || $result['journal_type']=="S"  && $result['num']==0 || $result['journal_type']=="CUST_PAYME" || $result['journal_type']=="CUST_OB" || $result['description']=="Payment")
                       {
                        $show=$des;
                        $class='invoice sale';
                       
                       }
                       else{
                        $show=$this->model_reports_reports->getCustInvNo($result['num']);
                        $class='sale'; 
                       }
                        $report['records'][] = array(                                                        
                                 'payee'=> $result['cust_name'],
                                 'acc_id' => $result["acc_id"],
                                 'number'=> "",                            
                                 'ref_id'=> $result['ref_id'],                            
                                 'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                                 'account'       => $result['acc_name'],                            
                                 'detail'       =>   $show,
                                 'increase'       => $increase==0?'':$increase,
                                 'decrease'       =>  $decrease==0?'':$decrease ,
                                 'balance'       => $balance,
                                 'class'       => $class,
                                 'is_type'       =>'invoice' 
                         );

                     if($result['journal_type']=="S" && $result['description'] !='Payment' || $result['journal_type']=="DIS" && $result['num']!=0 || $result['journal_type']=="POS" || $result['journal_type']=="SALE_RET" || $result['journal_type']=="POS_RET")
                        {
                        $des='Inv #'.$result['num'];
                          $report_lines =  $this->model_reports_reports->get_customer_aging($result['num']);
                           foreach ($report_lines as $item) {
                         $discount=number_format($item['discount'],2,'.','');
                         $netprice=$item['unit_price']-$discount;   
                         $net=$item['qty']*$netprice;
                          $report['records'][] = array(                                                        
                                 'payee'=> "",
                                 'acc_id' => "",
                                 'number'=> "",                            
                                 'ref_id'=> "",                            
                                 'date'      => "",
                                 'account'       => "",                            
                                'detail'         =>''.$item['item'].', '.$item['qty'].' @ RS '.$netprice.'='.$net,
                                 'increase'       => "",
                                 'decrease'       =>  "",
                                 'balance'       => "",
                                 'class'       => "",
                                 'is_type'       =>'items' 
                         );
                        }
                       }
                       else{
                        $des=$result['journal_type'];
                           }    
                   } 
                   $i = $i + 1;
                   // $accID=$result['acc_id'];

                }
                  // var_dump($accID);exit;
                      $report['records'][]=array(
                  'current'   =>    $current,
                  'thirtydays'    =>    $lessthen30,
                  'sixtydays'    =>    $lessthen60,
                  'nintydays'    =>    $lessthen90,
                  'overninty'    =>    $over90,
                  'amountDue' =>  number_format($this->model_reports_reports->getCustBalance($post_data),2,'.',''),
                  'is_type'   =>  'statement'
                );
      }
        $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
    }

    public function getVendorAging()
    {
      $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                 $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];
                 $warehouse=$post_data['warehouse'];   
                 $category="";  
                 $warehouses="";
                 $vendor='';           
                 $qty='';           
                 $p_price='';           
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $invoice=0;
                 $payment=0;
                 $balance = 0;
                 $add_sale=0;
                 $sale_return = false;
                 $i=0;
                 $des='';
                 $show='';
                 $vendor='';
                 $class='';
                 $prev=0;
                 $increase=0;
                 $decrease=0;
                 $po_return =0;
                 $sql="SELECT * FROM vendor WHERE vendor_id=".$post_data['vendor_id']."";
                 $query = $this->db->query($sql);
                 $row= $query->row;
                  $results = $this->model_reports_reports->get_vendor_RegisterPaid($post_data); 
                   $pre_row = $this->model_reports_reports->getPreviousVendorBalance($post_data);
                    if($vendor!=$row['vendor_name'])
                        {
                          $vendor=$row['vendor_name'];
                           $report['records'][] = array(                                                        
                                 'payee'=> $vendor,
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => '',
                            'account'       => '',         
                            'detail'       =>  '',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => '',
                            'class'       => '',
                            'is_type'       =>'vendor'
                         );
                        }

                       if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                  $prev=$pre_row["pre_total"];
                 }
                 else{
                  $prev=0;
                 }
                 
                    $report['records'][] = array(                                  
                            'payee'=> $vendor,
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => '',
                            'account'       => '',         
                            'detail'       =>  'Opening Balance',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => number_format($prev* -1,2,'.',''),
                            'class'       => 'invoice',
                            'is_type'       =>'previous' 
                    );
                    $balance = $pre_row["pre_total"]* -1;

                    foreach ($results as $result) {           
                   
                       
                   // if(isset($data['loans']) && $data['loans']==1) {
                   //     $decrease = $result['journal_amount']>0?$result['journal_amount']:0;
                   //     $increase =  $result['journal_amount']<0?-1*$result['journal_amount']:0;                   
                   // }
                   // else{
                        $increase = $result['journal_amount']<0?-1*$result['journal_amount']:0;
                        $decrease =  $result['journal_amount']>0?$result['journal_amount']:0;                   
                   // }
                   
                   if($result['num']){
                       $number = $result['num']<0 ? -1*$result['num']:$result['num'];
                   }

                   if($result["journal_type"]=="P_DIS"){
                        $increase = -1 * $increase;
                   }
                   $balance = $balance + $increase + -1*($decrease);                   
                   if( $result["num"]>0 && $i+1 < count($results) && $results[$i+1]["num"]==$result["num"] && $results[$i+1]["acc_id"]==$result["acc_id"] && $results[$i+1]["acc_id"]=="1"){
                       if($increase>0){
                        $add_sale = $add_sale +$increase;
                       }
                       else{
                           $po_return = true;
                           $add_sale = $add_sale +$decrease;
                       }
                   }
                   else{
                       
                       if($po_return==false){
                           $increase = $increase +$add_sale;
                       }
                       else{
                           $po_return = false;
                           $decrease = $decrease +$add_sale;
                       }

                       if($result["acc_id"]==10 && $increase<0){
                            $increase = -1 * $increase;
                       }
                       
                       $add_sale = 0;
                       // $salesrepdetail = $this->model_account_register->getSalesRepName($result['ref_id']);
                       $report['records'][] = array(
                            'payee'=> $result['vendor_name'],
                                 'acc_id' => $result["acc_id"],
                                 'number'=> "",                            
                                 'ref_id'=> $result['ref_id'],                            
                                 'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                                 'account'       => $result['acc_name'],                            
                                 'detail'       =>   $result['description'],
                                 'increase'       => $increase==0?'':$increase,
                                 'decrease'       =>  $decrease==0?'':$decrease ,
                                 'balance'       => $balance,
                                 'class'       => '',
                                 'is_type'       =>'invoice' 
                    );
                  }
                  $i = $i + 1;
            
               }
             }
                    $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
    }

    public function getItemList()
    {
       $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                 $report['report_id'] = $post_data['report_id'];
                  $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];       
                 $report['show_price'] =$post_data['show_price']; 
                 $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $category=''; $price0 = $price1 = $price2 = $price3 = 0;
                   $report_lines =  $this->model_reports_reports->get_item_list($post_data);
                   foreach ($report_lines as $result) {
                        $unit = explode(",", $result['item_unit_id']);
                        $price = explode(",", $result['item_sale_price']);
                        
                        $price0 = isset($price[0]) ? $price[0] : null;
                        $price1 = isset($price[1]) ? $price[1] : null;
                        $price2 = isset($price[2]) ? $price[2] : null;
                        $price3 = isset($price[3]) ? $price[3] : null;
                        
                            if($category!=$result['category']){
                         
                        $category = $result['category'];
                           $report['records'][] = array( 
                           'category_name' =>$category,                         
                           'is_type'       => 'category'
                          );
                             }
                           $report['records'][] = array( 
                              'product_name'       => $result['item_name'],
                              'category'       => $result['category'],
                              'purchase_price'           => number_format($result['normal_price'],2,'.','') ,
                              'avg_cost'           =>  number_format($result['avg_cost'],2,'.',''),
                              'sale_price'           =>  number_format($result['sale_price'],2,'.',''), 
                              'unit0_price'           =>  number_format($price0,2,'.',''), 
                               'unit1_price'           =>  number_format($price1,2,'.',''),
                               'unit2_price'           =>  number_format($price2,2,'.',''),
                               'unit3_price'           =>  number_format($price3,2,'.',''),
                              'is_type'       => 'product'
                         ); 
                   }
               }
               $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
    }

    public function getAssetAccountRecord()
    {
       $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                 $category='';$cat_qty =0;$total_amount=0;
                   $report_lines =  $this->model_reports_reports->get_accountListRecord($post_data);
                   foreach ($report_lines as $result) {

                           
                          if($category !=$result['acc_name'])
                          {

                             if($cat_qty>0)
                            {

                              $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_total'       => number_format($cat_qty,2,'.',''), 
                                   'is_type'       => 'cat_total'
                              );
                                $cat_qty= 0; 
                            }

                           $category = $result['acc_name'];
                           $report['records'][] = array( 
                           'account_name' =>$category,                         
                           'is_type'       => 'category'
                          );
                          }

                           $report['records'][] = array( 
                              'asset_name'       => $result['journal_details'],
                              'amount'           => $result['journal_amount'],
                              'date'           => $result['entry_date'],                              
                              'is_type'       => 'product'
                         ); 

                            $cat_qty=$cat_qty+$result['journal_amount'];

                            $total_amount=$total_amount+$result['journal_amount'];
                   }
                     $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_total'       => number_format($cat_qty,2,'.',''), 
                                   'is_type'       => 'cat_total'
                              ); 

                      $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_amount'       =>       number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    ); 
               }
                   $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
               }

        public function getPurchaseSummaryReport()
        {
           $report = array();
            if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
              $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');

                  $report_lines =  $this->model_reports_reports->getPurchaseSummaryRecord($post_data);
             foreach ($report_lines as $result) {
               $time = strtotime($result['invoice_date']); 
                $date=date('Y-m-d',$time);

                      $report['records'][] = array( 
                              'vendor_name'       => $result['vendor_name'],
                              'orderNo'           => $result['invoice_no'],
                              'date'           => $date,                              
                              'amount'           => $result['invoice_total'],                              
                              'is_type'       => 'bill'
                         );
                    }
            }


            $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 

        }       

        public function getPurchaseReport()
        {

                $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $category='';$vendor='';$cat_amount=0;$vendor_amount=0;$total_amount=0;
                  $report_lines =  $this->model_reports_reports->getPurchaseRecord($post_data);
                   foreach ($report_lines as $result) {

                          

                             if($category !=$result['category'])
                          {
                                  if($cat_amount>0)
                            {

                              $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_total'       => number_format($cat_amount,2,'.',''), 
                                   'is_type'       => 'cat_total'
                              );
                                $cat_amount= 0; 
                            }
                           $category = $result['category'];
                           $report['records'][] = array( 
                           'category_name' =>$category,                         
                           'is_type'       => 'category'
                          );

                          }

                               if($vendor !=$result['vendor'])
                          {
                            if($vendor_amount>0)
                            {
                               $report['records'][] = array( 
                                   'vendor_name'       =>'Total '.$vendor,   
                                   'vendor_total'       => number_format($vendor_amount,2,'.',''), 
                                   'is_type'       => 'vendor_total'
                              );


                               $vendor_amount=0;
                            }
                          $vendor = $result['vendor'];
                           $report['records'][] = array( 
                           'vendor_name' =>$vendor,                         
                           'is_type'       => 'vendor'
                          );
                           }
                          


                    $amount=$result['amount'];
                     $report['records'][] = array( 
                              'item_name'       => $result['item_name'],
                              'qty'           => $result['qty'],
                              'price'           => $result['price'],                              
                              'amount'           => $amount,                              
                              'is_type'       => 'product'
                         ); 

                     $cat_amount=$cat_amount+$amount;
                     $vendor_amount=$vendor_amount+$amount;
                     $total_amount=$total_amount+$amount;
                   }
                    $report['records'][] = array( 
                                   'vendor_name'       =>'Total '.$vendor,   
                                   'vendor_total'       => number_format($vendor_amount,2,'.',''), 
                                   'is_type'       => 'vendor_total'
                              );
                       $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_total'       => number_format($cat_amount,2,'.',''), 
                                   'is_type'       => 'cat_total'
                              );

                           $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_amount'       =>       number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
                         
                }

            $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
        }            

         public function getPurchaseReturnReport()
        {

                $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $category='';$vendor='';$cat_amount=0;$vendor_amount=0;$total_amount=0;
                  $report_lines =  $this->model_reports_reports->getPurchaseReturnRecord($post_data);
                   foreach ($report_lines as $result) {
                 if($category !=$result['category'])
                          {
                                  if($cat_amount>0)
                            {

                              $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_total'       => number_format($cat_amount,2,'.',''), 
                                   'is_type'       => 'cat_total'
                              );
                                $cat_amount= 0; 
                            }
                           $category = $result['category'];
                           $report['records'][] = array( 
                           'category_name' =>$category,                         
                           'is_type'       => 'category'
                          );

                          }

                               if($vendor !=$result['vendor'])
                          {
                            if($vendor_amount>0)
                            {
                               $report['records'][] = array( 
                                   'vendor_name'       =>'Total '.$vendor,   
                                   'vendor_total'       => number_format($vendor_amount,2,'.',''), 
                                   'is_type'       => 'vendor_total'
                              );


                               $vendor_amount=0;
                            }
                          $vendor = $result['vendor'];
                           $report['records'][] = array( 
                           'vendor_name' =>$vendor,                         
                           'is_type'       => 'vendor'
                          );
                           }
                          


                    $amount=$result['qty']*$result['price'];
                     $report['records'][] = array( 
                              'item_name'       => $result['item_name'],
                              'qty'           => $result['qty'],
                              'price'           => $result['price'],                              
                              'amount'           => $amount,                              
                              'is_type'       => 'product'
                         ); 

                     $cat_amount=$cat_amount+$amount;
                     $vendor_amount=$vendor_amount+$amount;
                     $total_amount=$total_amount+$amount;
                   }
                    $report['records'][] = array( 
                                   'vendor_name'       =>'Total '.$vendor,   
                                   'vendor_total'       => number_format($vendor_amount,2,'.',''), 
                                   'is_type'       => 'vendor_total'
                              );
                       $report['records'][] = array( 
                                   'cat_name'       =>'Total '.$category,   
                                   'cat_total'       => number_format($cat_amount,2,'.',''), 
                                   'is_type'       => 'cat_total'
                              );

                           $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_amount'       =>       number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
                         
                }

            $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
        }           


        public function getSaleReturnReport()
        {

                $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  
                  $report_lines =  $this->model_reports_reports->SaleReturn_report($post_data);
                  $category = "";
                  $category1 = "";
                  $category_qty = $category_sale = $category_discount = $category_sales = $category_cost = $category_revenue = 0;
                  $warehouse_qty = $warehouse_sale = $warehouse_discount = $warehouse_sales = $warehouse_cost = $warehouse_revenue = 0;
                  $total_qty = $total_sale = $total_discount = $total_sales = $total_cost = $total_revenue = 0;
                  $qty = $s_qty=$sale = $discount = $sales = $cost = $revenue = 0;
                  $warehouses='';
                  $service='';
                  $m_cat='';
                  $result_cat='';
                  $sub1='';
                  $no=1;
                  $netreturn=0;
                  foreach ($report_lines as $result) {


                      if($category!=$result['category']){

                         if($category_sales!=0){
                            $report['records'][]      = array( 
                                   'cat_total'          =>'Total '.$category,   
                                   'category_qty'       => number_format($category_qty,2,'.',''),   
                                   'category_sale'      => number_format($category_sale,2,'.',''),
                                   'category_discount'  =>number_format($category_discount,2,'.',''),
                                   'category_sales'     =>number_format($category_sales,2,'.',''),                         
                                   'category_cost'      =>number_format($category_cost,2,'.',''),                         
                                   'category_revenue'   =>number_format($category_revenue,2,'.',''),                           
                                   'is_type'            => 'cat_total'
                              );

                            $category_qty = $category_sale = $category_discount = $category_sales = $category_cost = $category_revenue = 0;
                         }
                             $category = $result['category'];
                      }
                          
                            if($category1!=$result['category']){
                              $category1 = $result['category'];

                          $report['records'][] = array( 
                           'category_name' =>$category1,                         
                           'is_type'       => 'category'
                          );
                        }

                     $qty      = $result['qty'];
                     $s_qty      = -1* $result['s_qty'];
                     $sale     = -1*$result['sale'];
                     $discount =  $result['discount'];
                     $sales    = -1*$result['sale']+$discount;
                     $cost     =-1* $result['item_cost']/$s_qty;
                     $cost1     = $cost*$s_qty;
                     $revenue  = $sales-$cost1;
                      $margin = $sales-$cost1;
                 if($cost1>"0"){
                      if($sales>0)
                      {
                         $per = ($margin/$sales) * 100; 
                      }
                      else{
                         $per = ($margin/1) * 100; 
                      }
                    
                  } else { 
                     $per = ($margin/1) * 100; 
                  }
                     //print_r($result['product']);exit();
                     if($s_qty!=="0"){
                      if($post_data['show_in_coton']==true)
                      {
                         $convfrom=$this->model_reports_reports->get_last_convfrom($result['id']);
                         if($convfrom==0)
                         {
                           $convqty=$s_qty;
                         }
                         else{
                           $convqty=$s_qty/$convfrom;
                         }
                       
                      }
                      else{
                        $convqty=$s_qty;
                      }
                       
                        $report['records'][]   = array( 
                              'count'   => $no,
                              'product_name'   => $result['product'],
                              'qty'            => number_format($convqty,2,'.',''),
                              'sale'           => number_format($sale,2,'.',''),
                              'discount'       => number_format($discount,2,'.',''),                      
                              'sales'          =>  number_format($sales,2,'.',''), 
                              'cost'           =>  number_format($cost1,2,'.',''),
                              'avg_cogs'           =>  number_format($cost,2,'.',''),
                              'revenue'        => number_format($revenue,2,'.',''),
                              'revenue_percent'        => number_format($per,1,'.',''),
                              'is_type'        => 'product'
                         );
                     }
                     $no=$no+1;
                     $category_qty       = $category_qty + $convqty;
                     $category_sale      = $category_sale + $sale;
                     $category_discount  = $category_discount + $discount;
                     $category_sales     = $category_sales + $sales;
                     $category_cost      = $category_cost + $cost1;
                     $category_revenue   = $category_revenue + $revenue;
                      
                     $total_qty          = $total_qty + $convqty;
                     $total_sale         = $total_sale + $sale;
                     $total_discount     = $total_discount + $discount;
                     $total_sales        = $total_sales + $sales;
                     $total_cost         = $total_cost + $cost1;
                     $total_revenue      = $total_revenue + $revenue;
                    }
                $report['records'][]      = array( 
                         'cat_total'          =>'Total '.$category,   
                         'category_qty'       => number_format($category_qty,2,'.',''),   
                         'category_sale'      => number_format($category_sale,2,'.',''),
                         'category_discount'  =>number_format($category_discount,2,'.',''),
                         'category_sales'     =>number_format($category_sales,2,'.',''),                         
                         'category_cost'      =>number_format($category_cost,2,'.',''),                         
                         'category_revenue'   =>number_format($category_revenue,2,'.',''),                           
                         'is_type'            => 'cat_total'
                    );

            
                   
                 $_discount = $this->model_reports_reports->total_Deduction($post_data);

                 // print_r($_discount);exit;
                 if($_discount!=0){
                  $report['records'][]  = array( 
                    'grand_total'       =>'Deduction on Invoice',                    
                    'total_discount'    =>number_format($_discount,2,'.',''),                       
                    'sale_minus'        =>number_format($_discount ,2,'.',''),                       
                    'revenue_minus'     =>number_format($_discount ,2,'.',''),                       
                    'is_type'           => 'total_discount'
                   );
                 }
                 $grand_disc = $total_discount+$_discount;
                 $grand_sale = $total_sales+$_discount;

           

                  $report['records'][]    = array( 
                    'grand_total'         =>'Grand Total',
                    'total_qty'           =>   number_format($total_qty,2,'.',''),
                    'total_sale'          => number_format($total_sale,2,'.',''),
                    'total_disc'          =>number_format($grand_disc,2,'.',''),                         
                    'total_sales'         =>number_format($grand_sale,2,'.',''),                         
                    'total_cost'          =>number_format($total_cost,2,'.',''),                         
                    'total_revenue'       =>number_format($total_revenue+$_discount,2,'.',''),                           
                    'is_type'             => 'total'
                   );

                }

                $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 

        } 

        public function getItemSaleDetail()
        {
               $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                 $report['report_name'] = 'Sale By Item Detail';  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $product='';$netprice=0;$item_amount=0;$total_amount=0;
                  $report_lines =  $this->model_reports_reports->getItemSaleDetail($post_data);

                  foreach ($report_lines as $result) {
                      if($product !=$result['item_name'])
                      {
                                if($item_amount>0)
                            {

                              $report['records'][] = array( 
                                   'pamout_name'       =>'Total '.$product,   
                                   'item_total'       => number_format($item_amount,2,'.',''), 
                                   'is_type'       => 'item_total'
                              );
                                $item_amount= 0; 
                            }
                        $product=$result['item_name'];
                          $report['records'][] = array( 
                           'product_name' =>$product,                         
                           'is_type'      => 'item_name'
                          );
                      }
                      $time = strtotime($result['date']); 
                $date=date('Y-m-d',$time);
                $discount=number_format($result['discount'],2,'.','');
                if($result['subtotal']==0)
                {
                  $netprice=$result['price']-$discount/$result['qty'];
                }
                else{
                  $netprice=$result['subtotal']/$result['qty'];
                }
                
                 $report['records'][]   = array( 
                    'item_id'        =>   $result['item_id'],
                    'invoice'        =>   'Inv-'. $result['invno'],
                    'date'           =>    $date,
                    'customer'       =>    $result['customer'],
                    'qty'            => number_format($result['qty'],2,'.',''),
                    'price'          => number_format($netprice,2,'.',''),
                    'balance'        => number_format($result['subtotal'],2,'.',''),    
                    'is_type'        => 'product'
               );

                 $item_amount=$item_amount+$result['subtotal'];
                  $total_amount=$total_amount+$result['subtotal'];
                  }

                         $report['records'][] = array( 
                                   'pamout_name'       =>'Total '.$product,   
                                   'item_total'       => number_format($item_amount,2,'.',''), 
                                   'is_type'       => 'item_total'
                              );

                           $report['records'][] = array( 
                        'total'             =>'Total',                        
                        'total_amount'       =>       number_format($total_amount,2,'.',''),
                        'is_type'       => 'total'
                    );
                 }
                 $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }

        public function get_VendorWiseSaleReport()
        {

            $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                      $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                    $vendor="";$newVendor="";
                      $report_lines =  $this->model_reports_reports->get_VendorWiseSaleReport($post_data);

                        foreach ($report_lines as $result) {


                          // $lastVendor=$this->model_reports_reports->get_lastVendor($result['item_id']);
                           if($result['vendor']==NULL)
                           {
                             $newVendor='No Vendor';
                           
                           }
                           else{
                            $newVendor=$result['vendor'];
                           }

                               if($vendor!=$newVendor){
                              $vendor = $newVendor;

                          $report['records'][] = array( 
                           'vendor_name' =>$vendor,                         
                           'is_type'       => 'vendor'
                          );
                        }

                     $report['records'][]   = array( 
                    'item_name'        =>   $result['item_name'],
                    'inv_no'           =>   $result['invno'],
                    'inv_date'           =>   $result['date'],
                    'qty'              =>   $result['qty'],
                    'price'            => number_format($result['price'],2,'.',''),
                    'amount'           => number_format($result['subtotal'],2,'.',''),  
                    'is_type'          => 'product'
               );
                        }

                }

                  $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));    
        }

        public function getSaleRepCollection()
        {
              $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                      $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                    $represntative="";$rep_total=0;$netamt=0;
                      $report_lines =  $this->model_reports_reports->getSaleRepCollection($post_data);

           foreach ($report_lines as $result) {


                    
                               if($represntative!=$result['name']){

                                  if($rep_total !=0)
                                  {

                                     $report['records'][] = array( 
                        'cat_name'       =>'Total '.$represntative,   
                        'rep_totalamt'       => number_format($rep_total,2,'.',''),  
                        'is_type'       => 'rep_total'
                          );
                                  }

                         $rep_total  =0;      
                        $represntative = $result['name'];

                          $report['records'][] = array( 
                           'represntative_name' =>$represntative,                         
                           'is_type'       => 'represntative'
                          );
                        }
                        $time = strtotime($result['date']); 
                     
                     $order_date = date("d-m-y",$time );
                     $report['records'][]   = array( 
                    'customer'        =>   $result['customer'],
                    'amount'          =>   $result['amount'],
                    'date'            =>   $order_date,
                    'is_type'         =>     'cash_detail'
               );

                       $rep_total=$rep_total+$result['amount'];
                       $netamt=$netamt+$result['amount'];
                        }

                           $report['records'][] = array( 
                        'cat_name'       =>'Total '.$represntative,   
                        'rep_totalamt'       => number_format($rep_total,2,'.',''),  
                        'is_type'       => 'rep_total'
                          );

                        $report['records'][] =      array( 
                    'net_amount'       =>   'Net Total',                    
                    'net_rep_totalamt'         =>   number_format($netamt,2,'.',''),
                    'is_type'           =>    'net_total'
                   );    

                }


                  $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
        }

        public function getDailySaleCashRecieve()
        {
            $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                      $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $customer='';$invTotal=0;$InvNo='';$cust_total=0;$grand_total=0;$expense_total=0;$cust_id=0;$cashRecievePayment=0;$accWithInvoice=0;$receive_total=0;$net_recTotal=0;$g_recTotal=0;$total_qty=0; $allcustomer=0;$netallcustomer=0;$allrecCustomer =0;$cashRecieve=0;$PInvNo=0;$PinvTotal=0;$vendor='';$vendTotal=0;
                  $report_lines =  $this->model_reports_reports->getDailySaleCashRecieve($post_data);
                   foreach ($report_lines as $result) {

                          
                       if($InvNo !=$result['InvNo'])
                        {
                            if($invTotal !=0)
                            {
                              $report['records'][] = array( 
                           'invoice_total' =>'Inv # '.$InvNo,                         
                           'invoice_amount' =>$invTotal,                         
                           'is_type'       => 'invTotal'
                          );
                            }
                            $invTotal=0;
                            $InvNo=$result['InvNo'];
                         }
                          if($customer!=$result['cust_name']){
     
                          if($cust_total!=0)
                          {
                           $report['records'][] = array( 
                           'cust_total' =>'Total '.$customer,                         
                           'cust_amount' =>$cust_total,                         
                           'is_type'       => 'customer_total'
                          );
                          }
                        
                        
                         //   if($cashRecievePayment !=0)
                         // {
                         //   $report['records'][] = array( 
                         //   'cashRep_name' =>$cashRecieve['rep_name'],                         
                         //   'cashRec_name' =>$cashRecieve['amount'],                         
                         //   'is_type'       => 'Recieve'
                         //  );
                         //    $cashRecievePayment=0;
                         // }

                          $cust_total=0;
                          $customer = $result['cust_name'];

                          $report['records'][] = array( 
                           'cust_name' =>'Customer '. $customer,                         
                           'is_type'       => 'customer'
                          );

                       }
                            if($cust_id !=$result['account_id'])
                          {
                            $cust_id=$result['account_id'];
                                   $cashRecieve=$this->model_reports_reports->getCashRecieve($cust_id,$post_data);
                          foreach($cashRecieve as $repwiseRec)
                      {

                            if($repwiseRec['amount'] !=0)
                    {
                      $cashRecievePayment=$repwiseRec['amount'];
                      $report['records'][] = array( 
                           'cashRep_name' =>$repwiseRec['rep_name'],                         
                           'cashRec_name' =>$repwiseRec['amount'],                         
                           'is_type'       => 'Recieve'
                          );

                    }
                      } 

                          } 


                     $qty        = $result['qty'];
                     // $amount     = $result['amount'];
                     $sale_price = $result['sale_price'];
                     $discount   = $result['discount'];
                     $sales      = $result['sale_price']-$discount;
                     if($qty>0)
                     {
                     $cost       = $result['purchase_price']/$qty;

                     }else{
                     $cost       = $result['purchase_price']/1; 
                     }
                     
                     $cost1      = $cost*$qty;
                     // $revenue    = $sales-$cost1;
                      $margin    = $sales-$cost1;
                 if($cost1>"0"){
                      if($sales>0)
                      {
                         $per = ($margin/$sales) * 100; 
                      }
                      else{
                         $per = ($margin/1) * 100; 
                      }
                    
                  } else { 
                     $per = ($margin/1) * 100; 
                  }
                         
                           // var_dump($cashRecieve);
                          $report['records'][]   = array( 
                            'item'        =>   $result['item_name'],
                            'qty'         =>   $result['qty'],
                            'amount'      =>   $result['amount'],
                            'percent'      =>  number_format($per,2,'.',''),
                            'invno'       =>   $result['InvNo'],
                            'date'        =>   $result['date'],
                            'is_type'     =>     'invoice_detail'
                             );


                     $invTotal=$invTotal+$result['amount'];
                     $cust_total=$cust_total+$result['amount'];
                     $grand_total=$grand_total+$result['amount'];
                     $accWithInvoice=$accWithInvoice.','.$cust_id;
                     $total_qty=$total_qty+$result['qty'];
                     $allcustomer=$allcustomer.','.$cust_id;

                          // var_dump($result['account_id']);
                      
                   } 
                    $report['records'][] = array( 
                           'invoice_total' =>'Inv # '.$InvNo,                         
                           'invoice_amount' =>$invTotal,                         
                           'is_type'       => 'invTotal'
                          );
                    
                    $report['records'][] = array( 
                           'cust_total' =>'Total '.$customer,                         
                           'cust_amount'=> $cust_total,                         
                           'is_type'    => 'customer_total'
                          );
                  
                

                      $report['records'][] = array( 
                           'g_total' =>'Grand Total ',                         
                           'g_amount'=> $grand_total,                         
                           'g_qty'=> $total_qty,                         
                           'is_type'    => 'grand_total'
                          );
                      // $total_qty=$total_qty+$result['qty']; 
                     
                     
                      
                     $expences=$this->model_reports_reports->getDailyExpenses($post_data); 
                     
                      foreach ($expences as $expence) {
                         $report['records'][]   = array( 
                          'expense_name'        =>   $expence['account'],
                          'exp_amount'         =>   $expence['amount'],
                          'exp_Repname'         =>   $expence['saleRep'],
                          'exp_date'      =>   $expence['date'],
                          'is_type'     =>     'expense_detail'
                        );
                      $expense_total=$expense_total+$expence['amount'];
                      }

                      $report['records'][] = array( 
                           'exp_total' =>'Total Expenses',                         
                           'expTotal_amount'=> $expense_total,                         
                           'is_type'    => 'expense_total'
                          );

                      // echo $accWithInvoice;
                      $groupReg='';
                      $receive_total_region=0;
                      $$receive_total=0;
                         $report['records'][]   = array( 
                                    'groupName'           =>   $groupReg,
                                    'Recieve_rep'         =>   '',
                                    'Recieve_amount'      =>   '',
                                    'Recieve_date'        =>   '',
                                    'is_type'             =>   'recevible_group'
                                  );
//                             $report['records'][] = array( 
//                           'region_total' =>'Total Region',                         
//                           'regionTotal_amount'=> $receive_total,                         
//                           'is_type'    => 'region_total'
//                          );
                       $cashRecievable=$this->model_reports_reports->getcashRecievable($accWithInvoice,$post_data);
                        foreach ($cashRecievable as $Recieve) {
                            
                            if($groupReg !=$Recieve['group_name']){
                                if( $receive_total !=0)
                                {
                                      $report['records'][] = array( 
                           'region_total' =>'Total '.$groupReg,                         
                           'regionTotal_amount'=> $receive_total,                         
                           'is_type'    => 'region_total'
                          );  
                                      $receive_total=0;
                                }
                                        
                                 $groupReg=$Recieve['group_name'];
                                 
                                   $report['records'][]   = array( 
                                    'groupName'           => 'Amount Recieve From '.  $groupReg,
                                    'Recieve_rep'         =>   '',
                                    'Recieve_amount'      =>   '',
                                    'Recieve_date'        =>   '',
                                    'is_type'             =>   'recevible_group'
                                  );
                                
//                            $receive_total_region=$Recieve['amount'];
                            }   
                                
                           
                         $report['records'][]   = array( 
                          'Recieve_name'        =>   $Recieve['customer'],
                          'Recieve_rep'         =>   $Recieve['rep_name'],
                          'Recieve_amount'      =>   $Recieve['amount'],
                          'Recieve_date'        =>   $Recieve['date'],
                          'is_type'             =>   'recevible_detail'
                        );
                     
                      
                        $receive_total=$receive_total+$Recieve['amount'];
                         $cust_total=$cust_total+$result['amount'];
                      }
                      
                       
                      $report['records'][] = array( 
                           'region_total' =>'Total '.$groupReg,                          
                           'regionTotal_amount'=> $receive_total,                         
                           'is_type'    => 'region_total'
                          );
//                                  
                      $net_recTotal=$this->model_reports_reports->getAllcashRecievable($post_data);
                      $net_total=$grand_total-$expense_total+$net_recTotal;

                      $TotalremainingBalance = $this->model_reports_reports->getTotalRemainingBalance($post_data);
                      $netPercent=$net_recTotal/$TotalremainingBalance*100;
                      $report['records'][] = array( 
                           'rec_total' =>'Recieve Total',                         
                           'TotalRemAmount' =>number_format($TotalremainingBalance,2,'.',''),                         
                           'rec_percent' =>number_format($netPercent,2,'.',''),                         
                           'rec_expense' =>$expense_total,                         
                           'rec_amount'=> $net_recTotal,                         
                           'netrec_amount'=>$net_recTotal-$expense_total ,                         
                           'is_type'    => 'rec_total'
                          );
                      $dailyPurchase=$this->model_reports_reports->getDailyPurchase($post_data);
                      foreach($dailyPurchase as $P_result)
                      {
                           if($PInvNo !=$P_result['InvNo'])
                        {
                            if($PinvTotal !=0)
                            {
                              $report['records'][] = array( 
                           'Pinvoice_total' =>'Purchase Inv # '.$PInvNo,                         
                           'Pinvoice_amount' =>$PinvTotal,                         
                           'is_type'       => 'PinvTotal'
                          );
                            }
                            $PinvTotal=0;
                            $PInvNo=$P_result['InvNo'];
                         }
                         if($vendor!=$P_result['vendor_name']){
     
                          if($vendTotal!=0)
                          {
                           $report['records'][] = array( 
                           'vend_total' =>'Total '.$vendor,                         
                           'cust_amount' =>$vendTotal,                         
                           'is_type'       => 'vendor_total'
                          );
                          }
                          $vendTotal=0;
                          $vendor = $P_result['vendor_name'];

                          $report['records'][] = array( 
                           'vendor_name' =>'Vendor '. $vendor,                         
                           'is_type'       => 'vendor'
                          );

                       } 

                        $report['records'][]   = array( 
                            'Pitem'        =>   $P_result['item_name'],
                            'Pqty'         =>   $P_result['qty'],
                            'Pamount'      =>   $P_result['amount'],
                            'Ppercent'      =>  number_format('0',2,'.',''),
                            'Pinvno'       =>   $P_result['InvNo'],
                            'Pdate'        =>   $P_result['date'],
                            'is_type'     =>     'P_invoice_detail'
                             );
                          $PinvTotal=$PinvTotal+$P_result['amount'];
                          $vendTotal=$vendTotal+$P_result['amount'];

                          // var_dump($result['account_id']);
                      
                   } 
                    $report['records'][] = array( 
                           'Pinvoice_total' =>'Inv # '.$PInvNo,                         
                           'Pinvoice_amount' =>$PinvTotal,                         
                           'is_type'       => 'PinvTotal'
                          );
                    
                    $report['records'][] = array( 
                           'vend_total' =>'Total '.$vendor,                         
                           'cust_amount' =>$vendTotal,                         
                           'is_type'       => 'vendor_total'
                          );  

                      $report['records'][] = array( 
                           'net_total' =>'Net Total',                         
                           'net_amount'=> $net_total,                         
                           'is_type'    => 'net_total'
                          );
                
              }

                  $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
        }

        public function getCashBalance()
        {
            $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                 $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                      $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $InvoiceAmt=$this->model_reports_reports->getAllInvoicesPayment($post_data);
                  $total=$InvoiceAmt['total']-$InvoiceAmt['discount']+$InvoiceAmt['SRETtotal']+$InvoiceAmt['deduction'];
                  $paid=$InvoiceAmt['total']-$InvoiceAmt['discount']-$InvoiceAmt['paid']+$InvoiceAmt['SRETtotal']+$InvoiceAmt['deduction'];
                  $vendorPayment=$InvoiceAmt['vendorAmount'];
                  // $balanceAmt=$total-$InvoiceAmt['expense']-$paid-$vendorPayment;
                  $totalAmt=$total-$InvoiceAmt['expense']-$vendorPayment;
                  
                          $report['records'][] = array( 
                           'InvoiceAmt' =>'TOTAL SALE INVOICES PAYMENT',                         
                           'Invoice_amount'=> number_format($InvoiceAmt['total'],2,'.',''),                         
                           'is_type'    => 'InvoiceAmt'
                          );

                          $report['records'][] = array( 
                           'STInvoiceAmt' =>'TOTAL SALE RETURN INVOICES PAYMENT',                         
                           'STInvoice_amount'=> number_format($InvoiceAmt['SRETtotal'],2,'.',''),                         
                           'is_type'    => 'STInvoiceAmt'
                          );

                            $report['records'][] = array( 
                           'InvoiceDisc' =>'TOTAL DISCOUNT IN SALE INVOICES',                         
                           'Invoice_discount'=> number_format($InvoiceAmt['discount'],2,'.',''),                         
                           'is_type'    => 'InvoiceDisc'
                          );
                            $report['records'][] = array( 
                           'InvoiceDeduc' =>'TOTAL DEDUCTION IN SALE RETURN',                         
                           'Invoice_deduction'=> number_format($InvoiceAmt['deduction'],2,'.',''),                         
                           'is_type'    => 'InvoiceDeduc'
                          );

                            $report['records'][] = array( 
                           'AfterTotal' =>'TOTAL',                         
                           'after_discount'=>  number_format($total,2,'.',''),                         
                           'is_type'    => 'AfterTotal'
                          );
                          //   $report['records'][] = array( 
                          //  'CurrentDues' =>' CURRENT DUES',                         
                          //  'current_dues'=> number_format($paid,2,'.',''),                         
                          //  'is_type'    => 'CurrentDues'
                          // );
                            $report['records'][] = array( 
                           'expense' =>'EXPENSE',                         
                           'expense_amt'=> number_format($InvoiceAmt['expense'],2,'.',''),                         
                           'is_type'    => 'expense'
                          );

                            $report['records'][] = array( 
                           'profit' =>'PROFIT',                         
                           'profit_amt'=> number_format($InvoiceAmt['NetProfit'],2,'.',''),                         
                           'is_type'    => 'PROFIT'
                          );
                        
                            $report['records'][] = array( 
                           'TotalCash' =>'TOTAL CASH',                         
                           'total_cash'=> number_format($InvoiceAmt['total']-$InvoiceAmt['discount'],2,'.',''),                         
                           'is_type'    => 'TotalCash'
                          );
                          //   $report['records'][] = array( 
                          //  'receive' =>' CASH RECIEVE',                         
                          //  'recieve_amt'=> number_format($InvoiceAmt['paid'],2,'.',''),                         
                          //  'is_type'    => 'receive'
                          // );
                            $report['records'][] = array( 
                           'vendor' =>' VENDOR PAYMENT',                         
                           'vendor_amt'=> number_format($vendorPayment,2,'.',''),                         
                           'is_type'    => 'vendor'
                          );
                          //   $report['records'][] = array( 
                          //  'balanceAmt' =>' BALANCE AMOUNT',                         
                          //  'balance_amt'=> number_format($balanceAmt,2,'.',''),                         
                          //  'is_type'    => 'balanceAmt'
                          // );

                            $report['records'][] = array( 
                           'totalAmt' =>' TOTAL AMOUNT',                         
                           'total_amt'=> number_format($totalAmt,2,'.',''),                         
                           'is_type'    => 'totalAmt'
                          );
                }
                $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
        }

        function getExpenses()
        {
           $report = array();
         if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
          $post_data=$this->request->post;
                 $this->load->model('reports/reports');
                   $report['report_id'] = $post_data['report_id'];
                 $report['start_date'] = $post_data['start_date'];
                    $report['end_date'] = $post_data['end_date'];
                 $report['print_category_report'] = $post_data['print_category_report'];
                      $report['report_name'] = $post_data['report_name'];  
                  $report['company_name'] = "<img src='".HTTP_SERVER."images/" . $this->config->get('config_logo')."' />" . $this->config->get('config_owner');
                  $expenseHead='';
                  $Expenses=$this->model_reports_reports->getAllExpenses($post_data);

                    foreach ($Expenses as $Expense) {
                           if($expenseHead!=$Expense['acc_name']){

                        $expenseHead = $Expense['acc_name'];

                          $report['records'][] = array( 
                           'expHead_name' =>$expenseHead,                         
                           'is_type'       => 'expense_head'
                          );
                        }  
                         $report['records'][]   = array( 
                          'Expense_name'        =>   $Expense['acc_name'],
                          'Amount'         =>   $Expense['journal_amount'],
                          'date'      =>   $Expense['date'],
                          'is_type'             =>   'expense_detail'
                        );
                     
                      
                        // $receive_total=$receive_total+$Recieve['amount'];
                         // $cust_total=$cust_total+$result['amount'];
                      }
        }


                  $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression')); 
  }

}
?>
