<?php

class ControllerReportsAccreports extends Controller {

	private $error = array(); 
	public function index() {
           if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
           }
           
           $this->data['get_url_balancesheet'] = HTTP_SERVER.'index.php?route=reports/accReports/getBalanceSheet';
           $this->data['get_url_trialbalancesheet'] = HTTP_SERVER.'index.php?route=reports/accReports/getTrail';
           $this->data['get_url_profitandloss'] = HTTP_SERVER.'index.php?route=reports/accReports/getProfitAndLoss';           
           $this->data['get_url'] = HTTP_SERVER;
           if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/reports/sale_reports.tpl')) { 
                    $this->template = $this->config->get('config_template') . '/template/reports/account_reports.tpl';
            } else {
                    $this->template = 'default/template/login/login.tpl';
            } 
            
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
        
         public function getBalanceSheet(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reportsAccounts');
                  $report['report_id'] = "1";
                  $report['report_name'] = $post_data['report_name'];                  
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] =  $this->config->get('config_owner');
                  
                  $report_lines =  $this->model_reports_reportsAccounts->get_assets($post_data);                                   
                  $total_assets = $total_cur_assets = 0;
                  $report_line_salereturn = 0;
                  $receiveable_loans = 0;
                  
                  $report['records'][] = array( 
                      'title'       =>'ASSETS',                         
                      'is_type'       => 'head_asset'
                  );
                  if(count($report_lines)>0){                    
                    $report['records'][] = array( 
                      'title'       =>'Current Assets',                         
                      'is_type'       => 'current_asset'
                     );                  
                    $report['records'][] = array( 
                      'title'       =>'Other Current Assets',                         
                      'is_type'       => 'other_asset'
                     );         
                     $acc_rec = 0;
                     foreach ($report_lines as $result) {
                        if($result['type_id']!=1){
                            if($result['type_id']==14){
                                $receiveable_loans = $receiveable_loans + $result['amount'];
                            }
                            else{
                                $report['records'][] = array( 
                                  'title'       =>$result['account_name'],                         
                                  'amount'       =>number_format($result['amount'],2,'.',','),                                                       
                                  'is_type'       => 'asset'                            
                                 );  
                            }
                          }
                          else{
                              $acc_rec = $acc_rec + $result['amount'];
                          }
                          $total_cur_assets = $total_cur_assets + $result['amount'];
                          $total_assets = $total_assets + $result['amount'];
                     }

                                          
                                          
                     if($acc_rec!=0){
                        $report['records'][] = array( 
                           'title'       =>'Account Receivable',                         
                           'amount'       =>number_format($acc_rec,2,'.',','),                                                     
                           'is_type'       => 'asset'                            
                          ); 
                     }
                     
                     if($receiveable_loans!=0){
                          $report['records'][] = array( 
                           'title'       =>'Receivable Loans',                         
                           'amount'       =>number_format($receiveable_loans,2,'.',','),                                                     
                           'is_type'       => 'asset'                            
                          ); 
                     }
                     
                     $report['records'][] = array( 
                      'title'       =>'Total Current Assets',                         
                      'amount'     =>number_format($total_cur_assets-$report_line_salereturn,2,'.',','),                         
                      'is_type'       => 'total_cur_asset'
                     );
                   }
                   $report['records'][] = array( 
                    'title'       =>'TOTAL ASSETS',    
                    'amount'     =>number_format($total_assets-$report_line_salereturn,2,'.',','),   
                    'is_type'       => 'total_asset'
                   );
                  
                 
                   
                 $report['records'][] = array( 
                    'title'       =>'LIABILITIES & EQUITY',                         
                    'is_type'       => 'head_leq'
                   );  
                 $report_lines =  $this->model_reports_reportsAccounts->get_liabilities($post_data); 
                 $total_liabilities = $total_cur_liabilities = 0;
                 $payable_loans = 0;
                 if(count($report_lines)>0){
                    $report['records'][] = array( 
                       'title'       =>'Liabilities',                         
                       'is_type'       => 'head_l'
                      ); 
                     $report['records'][] = array( 
                       'title'       =>'Current Liabilities',                         
                       'is_type'       => 'current_l'
                      );
                     $acc_payable = 0;
                     foreach ($report_lines as $result) {
                         if($result['type_id']!=2){
                           if($result['type_id']==15){
                                $payable_loans = $payable_loans + $result['amount'];
                            }
                            else{  
                                $report['records'][] = array( 
                                  'title'       =>$result['account_name'],                         
                                  'amount'       =>number_format($result['amount'],2,'.',','),                              
                                  'is_type'       => 'liability'
                                 );  
                            }
                         }
                         else{
                            $acc_payable = $acc_payable + $result['amount']; 
                         }
                           $total_cur_liabilities = $total_cur_liabilities + $result['amount'];
                           $total_liabilities = $total_liabilities + $result['amount'];
                      }

                      
                     if($acc_payable!=0){ 
                        $report['records'][] = array( 
                           'title'       =>'Account Payable',                         
                           'amount'       =>number_format(-1*$acc_payable,2,'.',','),                                                     
                           'is_type'       => 'liability'                            
                          );  

                     }
                     if($payable_loans!=0){
                         $report['records'][] = array( 
                           'title'       =>'Payable Loans',                         
                           'amount'       =>number_format($payable_loans,2,'.',','),                                                     
                           'is_type'       => 'liability'                            
                          );  
                     }
                     $report['records'][] = array( 
                       'title'       =>'Total Current Liabilities',            
                        'amount'     =>number_format($total_cur_liabilities,2,'.',','),  
                       'is_type'       => 'total_cur_l'
                      ); 
                     $report['records'][] = array( 
                       'title'       =>'Total Liabilities',                         
                       'amount'     =>number_format($total_liabilities,2,'.',','),  
                       'is_type'       => 'total_l'
                      ); 
                 }
                 $report_lines =  $this->model_reports_reportsAccounts->get_equity($post_data);     
                 $total_equities = 0;
                 if(count($report_lines)>0){
                    $report['records'][] = array( 
                      'title'       =>'Equity',                         
                      'is_type'       => 'head_equity'
                     );                     
                    
                    foreach ($report_lines as $result) {
                          $report['records'][] = array( 
                            'title'       =>$result['account_name'],                         
                            'amount'       =>number_format($result['amount']*-1,2,'.',','),                           
                            'is_type'       => 'equities'
                           );                          
                          $total_equities = $total_equities + $result['amount'];
                     }
                     
                    }
                    
                    $net_income = $this->model_reports_reportsAccounts->get_netIcome($post_data);
                                      
                    if($net_income!=0){
                        $report['records'][] = array( 
                            'title'       =>'Net Income',                         
                            'amount'       =>number_format($net_income*-1,2,'.',','),                           
                            'is_type'       => 'equities'
                           );                         
                        $total_equities = $total_equities + $net_income;
                    }
                    
                    
                    if($total_equities!=0){
                        $report['records'][] = array( 
                          'title'       =>'Total Equity',                         
                          'amount'     =>number_format($total_equities*-1,2,'.',','),   
                          'is_type'       => 'total_equity'
                         ); 
                    }
                 
                  $total_liabilities_equites = $total_equities + $total_liabilities;
                  $report['records'][] = array( 
                    'title'       =>'TOTAL LIABILITIES & EQUITY',             
                    'amount'     =>number_format($total_liabilities_equites*-1,2,'.',','),     
                    'is_type'       => 'total_le'
                   ); 
                  
             }
             //$report_lines =  $this->model_reports_reportsAccounts->getTrail($post_data);
                
             /*$report['records'][] = array(
                 'title' => 'Account1',
                 'debit' => '100',
                 'credit' => '0',
                 'is_type' => 'name',
                 
             );
             $report['records'][] = array(
                 'title' => 'Account2',
                 'debit' => '200',
                 'credit' => '100',
                 'is_type' => 'name2',
                 
             );
             $report['records'][] = array(
                 'title' => 'Account3',
                 'debit' => '0',
                 'credit' => '400',
                 'is_type' => 'name3',
                 
             );*/
             
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
         }
         
              public function getTrail(){
                  $report = array();
                  if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reportsAccounts');
                  $report['report_id'] = "1";
                  $report['report_name'] = $post_data['report_name'];                  
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] =  $this->config->get('config_owner');
             
            $results = $this->model_reports_reportsAccounts->getTrail($this->request->get);
            //$report = array();
            $adjust_ammount_debit = 0;
            $adjust_ammount_credit = 0;
            $acc_name = 0;
            $acc_payable_name = $this->model_reports_reportsAccounts->getTypeName(7);
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
                        if($result['acc_id']==5 && $credit>0){
                            $acc_name = $this->model_reports_reportsAccounts->getSaleReturnValue(11);
                            $credit_text =$credit-$acc_name;//." (S+R=".$credit.")"
                       }  
                        if($result['acc_id']==11 && $debit>0){
                            // $debit_text =-1*$debit;
                            // echo $debit_text;exit;
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
                       $report['trail'][] = array(
                                'id' => $result['acc_id'],
                                'account_name'      => $this->replace($result['acc_name']),
                                'is_type' =>        $acc_type,
                                'debit' => $debit_text,
                                'credit' => $credit_text

                        );
                   }
                   if($adjust_ammount_debit!=0 || $adjust_ammount_credit!=0){
                    $_bal = $adjust_ammount_debit-$adjust_ammount_credit;  
                    $_debit = $_bal>0?$_bal:0; 
                    $_credit = $_bal<0?$_bal:0;
                    $report['trail'][] = array(
                                 'id' => '-1',
                                 'account_name'      => 'Adjustments',
                                 'is_type' =>        'Amanat Adjustment',
                                 'debit' => number_format($_debit,2,'.',''),
                                 'credit' => number_format($_credit,2,'.','')

                     );
                   }    
                }
               }
            $this->load->library('json');
            $this->response->setOutput(Json::encode($report ), $this->config->get('config_compression'));
        }   
            function replace($replace){
               return str_replace("VENDOR_","",str_replace("(V)", "",str_replace("CUST_","",str_replace("(C)","", $replace))));
           }
         public function getProfitAndLoss(){
             $report = array();
             if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                  $post_data=$this->request->post;
                  $this->load->model('reports/reportsAccounts');
                  $report['report_id'] = "1";
                  $report['report_name'] = $post_data['report_name'];                  
                  $report['start_date'] = $post_data['start_date'];
                  $report['end_date'] = $post_data['end_date'];
                  $report['company_name'] =  $this->config->get('config_owner');
                  $total_income = $total_cur_income = 0;                  
                  
                  $report_lines =  $this->model_reports_reportsAccounts->get_income($post_data);
                  $report_lines_exp =  $this->model_reports_reportsAccounts->get_expense($post_data);
                  $report['records'][] = array( 
                      'title'       =>'INCOME',                         
                      'is_type'       => 'head_income'
                  );
              
                  foreach ($report_lines as $result) {                                          
                    $report['records'][] = array( 
                      'title'       =>$result['account_name'],                         
                      'amount'       =>number_format($result['amount'],2,'.',','),                                                       
                      'is_type'       => 'income'                            
                     ); 
                    
                     $total_cur_income = $total_cur_income + $result['amount'];     
                    
                 }
                 
                 foreach ($report_lines_exp as $result) {                    
                    if($result['account_id']=="10"){ 
                        $amount = $result['amount']; 
                        $report['records'][] = array( 
                          'title'       =>"Sale Discount",                         
                          'amount'       =>number_format(-1*$amount,2,'.',','),                                                       
                          'is_type'       => 'expense'                            
                         );                        
                        $total_cur_income = $total_cur_income - $result['amount'];                                                                    
                    }
                 }  

                 
                 /*$report_lines =  $this->model_reports_reportsAccounts->get_oincome($post_data);
                 if(count($report_lines)>0){                        
                        foreach ($report_lines as $result) {                                          
                           $report['records'][] = array( 
                             'title'       =>$result['account_name'],                         
                             'amount'       =>number_format($result['amount'],2,'.',','),                                                       
                             'is_type'       => 'income'                            
                            );                        
                           $total_cur_income = $total_cur_income + $result['amount'];                                            
                        }                         
                    }*/
                    $report['records'][] = array( 
                        'title'       =>'Total Income',                         
                        'amount'     =>number_format($total_cur_income,2,'.',','),                         
                        'is_type'       => 'total_cur_income'
                     );

                 $total_sale_return = 0;
                /* $report_lines =  $this->model_reports_reportsAccounts->get_salereturn($post_data);
                 if(count($report_lines)>0){
                    $report['records'][] = array( 
                       'title'       =>'Sale Return',                         
                       'amount'     =>number_format($total_cur_income,2,'.',','),                         
                       'is_type'       => 'head_return'
                    );
                    
                    foreach ($report_lines as $result) {                                          
                       $report['records'][] = array( 
                         'title'       =>$result['account_name'],                         
                         'amount'       =>"(".number_format($result['amount'],2,'.',',').")",                                                       
                         'is_type'       => 'sale_return'                            
                        );                        
                       $total_sale_return = $total_sale_return + $result['amount'];                                            
                    }
                    
                     $report['records'][] = array( 
                       'title'       =>'Total Sale Return',                         
                       'amount'     =>number_format($total_sale_return,2,'.',','),                         
                       'is_type'       => 'total_return'
                    );
                 }*/
                                  
                 $report_lines =  $this->model_reports_reportsAccounts->get_cogs($post_data);
                 $total_cogs = $t_cogs= 0;
                 foreach ($report_lines as $result) {                                                                        
                    $t_cogs = $t_cogs + $result['amount'];
                  }
                 $report_lines2 =  $this->model_reports_reportsAccounts->get_cogs_return($post_data);
                 // var_dump($report_lines2);exit;
                 $t_cogs_return= 0;
                 $cogs_return = 0;

                 foreach ($report_lines2 as $result2) {          
                    $cogs_return =  $result2['amount'];
                    // $t_cogs_return = $t_cogs_return + $cogs_return;
                    $t_cogs_return = $t_cogs_return - $cogs_return;
                  }              
                  $saleReturnAmount = 0;
                  if(count($report_lines)>0 && $t_cogs!=0){
                    $report['records'][] = array( 
                       'title'       =>'Cost of goods Sold',                         
                       'amount'     =>number_format($total_cur_income,2,'.',','),                         
                       'is_type'       => 'head_cogs'
                    );

                    foreach ($report_lines as $result) {                    
                         $report['records'][] = array( 
                           'title'       =>$result['account_name'],                         
                           'amount'       =>number_format($result['amount'],2,'.',','),                                                       
                           'is_type'       => 'cogs'                            
                          );                                              
                         $total_cogs = $total_cogs + $result['amount'];
                    }

                    
                    foreach ($report_lines2 as $result2) { 
                        $saleReturnAmount = $result2['amount'];
                         $report['records'][] = array( 
                           'title'       =>'Cost Of Sale Return',                         
                        // 'amount'       =>number_format('-' . $saleReturnAmount,2,'.',','),                                                      
                           'amount'       =>number_format( $saleReturnAmount,2,'.',','),                                                      
                           'is_type'       => 'cogs'                            
                          );                                            
                    }
                    $report['records'][] = array( 
                       'title'       =>'Total Cost of goods Sold',                         
                       'amount'     =>number_format($total_cogs+ (-$t_cogs_return),2,'.',','),                         
                       'is_type'       => 'total_cogs'
                    );
                 }

                 $total_income = $total_cur_income - ($total_cogs+ (-$t_cogs_return)) ;
                 
                 $report['records'][] = array( 
                    'title'       =>'Total Gross Profit',    
                    'amount'     =>number_format($total_income,2,'.',','),   
                    'is_type'       => 'total_income'
                   );
                 
                 $report['records'][] = array( 
                    'title'       =>'EXPENSE',                         
                    'is_type'       => 'head_expense'
                  );  
                                  
                 $total_cur_expense = $total_expense = 0;
                 foreach ($report_lines_exp as $result) {                    
                    if($result['account_id']!="10"){ 
                        $amount = $result['amount']<0 ? $result['amount']*-1:$result['amount']; 
                        $report['records'][] = array( 
                          'title'       =>$result['account_name'],                         
                          'amount'       =>number_format($amount,2,'.',','),                                                       
                          'is_type'       => 'expense'                            
                         );                        
                        $total_cur_expense = $total_cur_expense + $amount;
                        $total_expense = $total_expense + $amount;
                    }
                 }                  
                 $report['records'][] = array( 
                    'title'       =>'Total Expense',                         
                    'amount'     =>number_format($total_expense,2,'.',','),                         
                    'is_type'       => 'total_expense'
                 );
                 
                 $report['records'][] = array( 
                    'title'       =>'Net Income',                         
                    'amount'     =>number_format($total_income-$total_expense,2,'.',','),                         
                    'is_type'       => 'net_income'
                 );
             }
             $this->load->library('json');
             $this->response->setOutput(Json::encode($report), $this->config->get('config_compression'));
             
         }
         
         
        
         
}
?>
