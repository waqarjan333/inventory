<?php
class ControllerAccountRegz extends Controller {  
 public function save_update() {
  $save_update_array = array(); 
  $this->load->model('account/register');                 
  if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $data = $this->request->post;
                        if($data['debit_entry_id']==0){    
                            $last_id=$this->model_account_register->addEntry($data); 
                        }
                        else{
                            $last_id= $this->model_account_register->updateEntry($data); 
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
  $this->load->model('account/register');                 
  if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $data = $this->request->post;
                        $id_array = explode(",",$data['_ids']); 
                        foreach ( $id_array as $id) {
                            $this->model_account_register->deleteEntry($id);
                        } 
                                                
                        $delete_array['message'] ='success';
   $delete_array['action'] = '1';
                        
  } 
                
                $this->load->library('json');
                $this->response->setOutput(Json::encode($delete_array), $this->config->get('config_compression'));
  
 }

        public function get_SaleInvoiceRegister()
        {
             $this->load->model('account/register'); 
            $data = $this->request->get;            
            $accounts_array = array();    
            $date=0;        
            $balance = 0;
            $limit_date='';
                $results = $this->model_account_register->getRegisterListForSaleInvoice($data); 
                foreach ($results as $date) {
                  $limit_date=$date['entry_date']; break;
                  
                }
                // var_dump($limit_date);
                // echo $limit_date;exit;
                $date=$this->model_account_register->getLastDate($data);
                if($limit_date !='')
                {
                   $data['reg_date']= $limit_date ;
                }  
                elseif($date[0]==0)
                {
                   $data['reg_date']= $data['start_date'] ;
                }
                else{
                    $data['reg_date']= $date[1];
                }
            
                $pre_row = $this->model_account_register->getPreviousRowForSaleInvoice($data); 
                $i=0;
                $add_sale = 0;
                $sale_return = false;
                if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                
                      $prev=$pre_row["pre_total"];
                    $sdate = isset($data['start_date']) ? date($this->language->get('date_format_short'), strtotime($data['start_date']) ):"";
                    $accounts_array['register'][] = array(
                            'id' => '',                                                        
                            'payee'=> $pre_row['cust_name'],
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => $sdate,
                            'account'       => '',         
                            'detail'       =>  'Previous Balance',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => $prev
                    );
                    $balance = $prev;
                }
                
          
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
                               $add_sale = $add_sale +$increase ;                       
                           }
                           else{
                               $add_sale = $add_sale +$decrease ;                       
                               $sale_return = true;
                           }
                       }                        
                       
                   }
                   else{                                
                        if($sale_return==false){                                                   
                            $increase = $increase +$add_sale;
                            $add_sale = 0; 
                            if($result["journal_type"]=="DIS"){                                                                                    
                                $increase = $increase - $decrease;
                                $decrease = 0;
                            }
                        }
                        else{
                            $sale_return = false;
                            $decrease = $decrease +$add_sale;
                            $add_sale = 0; 
                            if($result["journal_type"]=="DIS"){                                                                                    
                                $decrease = $decrease - $increase;
                                $increase = 0;
                            }
                        }

                        
                        $description = $result['num']?$this->model_account_register->getDescriptionSO($result['num']):$result['description'];
                        $salesrepdetail = $this->model_account_register->getSalesRepName($result['ref_id']);
                        $accounts_array['register'][] = array(
                                 'id' => $result['journal_id'],                                                        
                                 'payee'=> $result['cust_name'],
                                 'cust_mobile'=> $result['cust_mobile'],
                                 'acc_id' => $result["acc_id"],
                                 'number'=> $result['num']?$this->model_account_register->getInvoiceNo($result['num']):"",                            
                                 'ref_id'=> $result['ref_id'],                            
                                 'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                                 'account'       => $result['acc_name'],                            
                                 'detail'       =>  $description . $salesrepdetail,
                                 'increase'       => $increase==0?'':$increase,
                                 'decrease'       =>  $decrease==0?'':$decrease ,
                                 'balance'       => $balance
                         );
                   } 
                   $i = $i + 1;
                 }

                    $this->load->library('json');
            $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
        }

        public function getCustomerPrevious()
        {
           $this->load->model('account/register'); 
            $data = $this->request->get;            
            $accounts_array = array();
            $pre_row = $this->model_account_register->getCustomerPrevious($data); 
               if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                    $sdate = isset($data['start_date']) ? date($this->language->get('date_format_short'), strtotime($data['start_date']) ):"";
                    $accounts_array['register'][] = array(
                            'balance'       => $pre_row["pre_total"]
                    );
                    // $balance = $pre_row["pre_total"];
                }

                $this->load->library('json');
            $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
        }
      
        public function getRegister(){
            $this->load->model('account/register'); 
            $data = $this->request->get;            
            $accounts_array = array();    
            $date=0;        
            $balance = 0;
             if($data["type_id"]==1){
                $results = $this->model_account_register->getRegisterList2($data); 
                $pre_row = $this->model_account_register->getPreviousRow2($data); 
                $i=0;
                $add_sale = 0;
                $sale_return = false;
                if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                    $sdate = isset($data['start_date']) ? date($this->language->get('date_format_short'), strtotime($data['start_date']) ):"";
                    $accounts_array['register'][] = array(
                            'id' => '',                                                        
                            'payee'=> $pre_row['cust_name'],
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => $sdate,
                            'account'       => '',         
                            'detail'       =>  'Previous Balance',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => $pre_row["pre_total"]
                    );
                    $balance = $pre_row["pre_total"];
                }
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
                               $add_sale = $add_sale +$increase ;                       
                           }
                           else{
                               $add_sale = $add_sale +$decrease ;                       
                               $sale_return = true;
                           }
                       }                        
                       
                   }
                   else{                                
                        if($sale_return==false){                                                   
                            $increase = $increase +$add_sale;
                            $add_sale = 0; 
                            if($result["journal_type"]=="DIS"){                                                                                    
                                $increase = $increase - $decrease;
                                $decrease = 0;
                            }
                        }
                        else{
                            $sale_return = false;
                            $decrease = $decrease +$add_sale;
                            $add_sale = 0; 
                            if($result["journal_type"]=="DIS"){                                                                                    
                                $decrease = $decrease - $increase;
                                $increase = 0;
                            }
                        }

                        
                        $description = $result['num']?$this->model_account_register->getDescriptionSO($result['num']):$result['description'];
                        $salesrepdetail = $this->model_account_register->getSalesRepName($result['ref_id']);
                        $accounts_array['register'][] = array(
                                 'id' => $result['journal_id'],                                                        
                                 'payee'=> $result['cust_name'],
                                 'cust_mobile'=> $result['cust_mobile'],
                                 'acc_id' => $result["acc_id"],
                                 'number'=> $result['num']?$this->model_account_register->getInvoiceNo($result['num']):"",                            
                                 'ref_id'=> $result['ref_id'],                            
                                 'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                                 'account'       => $result['acc_name'],                            
                                 'detail'       =>  $description . $salesrepdetail,
                                 'increase'       => $increase==0?'':$increase,
                                 'decrease'       =>  $decrease==0?'':$decrease ,
                                 'balance'       => $balance
                         );
                   } 
                   $i = $i + 1;
                }
            }
            else if($data["type_id"]==2){
                $results = $this->model_account_register->getRegisterList3($data); 
                $pre_row = $this->model_account_register->getPreviousRow3($data) ; 
                $number ="" ;
                $i = 0;
                $add_sale = 0;
                $po_return = false;
                if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                    $sdate = isset($data['start_date']) ? date($this->language->get('date_format_short'), strtotime($data['start_date']) ):"";
                    $accounts_array['register'][] = array(
                            'id' => '',                                                        
                            'payee'=> $pre_row['vendor_name'],
                            'acc_id' => '',
                            'number'=> "",                            
                            'ref_id'=> "",                            
                            'date'      => $sdate,
                            'account'       => '',                            
                            'detail'       =>  'Previous Balance',
                            'increase'       => "",
                            'decrease'       => "",
                            'balance'       => $pre_row["pre_total"]* -1
                    );
                    $balance = $pre_row["pre_total"] * -1;
                }
                foreach ($results as $result) {           
                   
                   if(isset($data['loans']) && $data['loans']==1) {
                       $decrease = $result['journal_amount']>0?$result['journal_amount']:0;
                       $increase =  $result['journal_amount']<0?-1*$result['journal_amount']:0;                   
                   }
                   else{
                        $increase = $result['journal_amount']<0?-1*$result['journal_amount']:0;
                        $decrease =  $result['journal_amount']>0?$result['journal_amount']:0;                   
                   }
                    
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
                       $salesrepdetail = $this->model_account_register->getSalesRepName($result['ref_id']);
                       $accounts_array['register'][] = array(
                            'id' => $result['journal_id'],                                                        
                            'payee'=> $result['vendor_name'],
                            'number'=> $result['num']?$this->model_account_register->getPOInvoiceNo($number):"",       
                            'acc_id' => $result["acc_id"],
                            'ref_id'=> $result['ref_id'],                            
                            'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                            'account'       => $result['acc_name'],   
                            'detail'       => $result['description'].$salesrepdetail,
                            'increase'       => $increase==0?'':$increase,
                            'decrease'       =>  $decrease==0?'':$decrease ,
                            'balance'       => $balance
                    );
                  }
                  $i = $i + 1;
                }
            }
            else if($data["type_id"]==3){
                $results = $this->model_account_register->getRegisterList1($data);    
                $pre_row = $this->model_account_register->getPreviousRow1($data) ; 
                $i=0;
                $add_sale = 0;
                $sale_return = false;
                if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                   $sdate = isset($data['start_date']) ? date($this->language->get('date_format_short'), strtotime($data['start_date']) ):"";
                   $accounts_array['register'][] = array(
                           'id' => '',                                                        
                           'payee'=> $pre_row['acc_name'],
                           'acc_id' => '',
                           'number'=> "",                            
                           'ref_id'=> "",                            
                           'date'      => $sdate,
                           'account'       => $pre_row['acc_name'] .' Account',                            
                           'detail'       =>  'Previous Balance',
                           'increase'       => "",
                           'decrease'       => "",
                           'balance'       => $pre_row["pre_total"]
                   );
                   $balance = $pre_row["pre_total"];
               }
                foreach ($results as $result) {                  
                   $amount = -1 * $result['journal_amount'];
                   $increase = ($amount < 0) ? -1 * $amount : 0;
                   $decrease = $amount > 0 ? $amount : 0;

                   $balance = $balance + $increase + -1 * ($decrease);

                   if ($result["num"] > 0 && $i + 1 < count($results) && $results[$i + 1]["num"] == $result["num"] && (($results[$i + 1]["acc_id"] == $result["acc_id"] && ($results[$i + 1]["acc_id"] == "5" || $results[$i + 1]["acc_id"] == "11")) || $results[$i + 1]["journal_type"] == "DIS")) {
                       if ($results[$i]["journal_type"] == "DIS") {
                           $add_sale = $add_sale - $increase;
                       } else {
                           if ($increase > 0) {
                               $add_sale = $add_sale + $increase;
                           } else {
                               $add_sale = $add_sale + $decrease;
                               $sale_return = true;
                           }
                       }
                   } else {
                       if($add_sale>0){
                        if ($sale_return == false) {
                            $increase = $increase + $add_sale;
                            $add_sale = 0;
                            if ($result["journal_type"] == "DIS") {
                                $increase = $increase - $decrease;
                                $decrease = 0;
                            }
                        } else {
                            $sale_return = false;
                            $decrease = $decrease + $add_sale;
                            $add_sale = 0;
                            if ($result["journal_type"] == "DIS") {
                                $decrease = $decrease - $increase;
                                $increase = 0;
                            }
                        }
                       }
                       $description = $result['details'];
                       $acc_name = $result['o_acc_name'];
                       if($data['account_id']==-1){
                            if($result['num']){
                                $sale_invoce_details = $this->model_account_register->getDescriptionSO($result['num']);
                                $description = $this->model_account_register->getInvoiceNo($result['num']) . " - ".$sale_invoce_details;
                                if ($result["journal_type"] == "DIS") {
                                     $acc_name = "Sales";
                                }
                            }
                            else if($result['journal_type']=='CUST_PAYME'){
                                if($description==""){
                                    $description = "RECEIVED FROM CUSTOMER";
                                }
                                else{
                                 $description = "RECEIVED FROM CUSTOMER ( ". $description ." )";
                                }
                            }
                            else if($result['journal_type']=='VENDOR_PAY'){
                                if($description==""){
                                    $description = "PAID TO VENDOR";
                                }
                                else{
                                 $description = "PAID TO VENDOR ( ". $description ." )";
                                }
                            }
                            else if($result['num'] ==0 && $result['journal_type']=='S'){
                                if($description==""){
                                    $description = "CUSTOMER CHARGED";
                                }
                                else{
                                 $description = "CUSTOMER CHARGED ( ". $description ." )";
                                }
                            }else if($result['num'] ==0 && $result['journal_type']=='P'){
                                if($description==""){
                                    $description = "VENDOR CHARGED";
                                }
                                else{
                                 $description = "VENDOR CHARGED ( ". $description ." )";
                                }
                            }
                       }
                       $accounts_array['register'][] = array(
                           'id' => $result['journal_id'],
                           'payee' => $result['acc_name'],
                           'number' => '',
                           'ref_id' => $result['ref_id'],
                           'date' => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                           'detail' => $description,
                           'account' =>$acc_name,
                           'increase' => $increase == 0 ? '' : $increase,
                           'decrease' => $decrease == 0 ? '' : $decrease,
                           'balance' => $balance
                       );
                   }
                   $i = $i + 1;
               }
            }
            else if($data["type_id"]==4){
             $results = $this->model_account_register->getRegisterList4($data);    
             $pre_row = $this->model_account_register->getPreviousRow4($data) ; 
             if($pre_row["pre_total"]!=NULL and $pre_row["pre_total"]!=0 ){
                $sdate = isset($data['start_date']) ? date($this->language->get('date_format_short'), strtotime($data['start_date']) ):"";
                $accounts_array['register'][] = array(
                        'id' => '',                                                        
                        'payee'=> $pre_row['acc_name'],
                        'acc_id' => '',
                        'number'=> "",                            
                        'ref_id'=> "",                            
                        'date'      => $sdate,
                        'account'       => $pre_row['acc_name'] .' Account',                            
                        'detail'       =>  'Previous Balance',
                        'increase'       => "",
                        'decrease'       => "",
                        'balance'       => $pre_row["pre_total"]
                );
                $balance = $pre_row["pre_total"];
            }
             foreach ($results as $result) {                  
                   $amount=-1*$result['journal_amount'];
                   $increase = ($amount<0)?-1*$amount:0;
                   $decrease =  $amount>0?$amount:0;
                  
                   $balance = $balance + $increase + -1*($decrease);
                   $accounts_array['register'][] = array(
                            'id' => $result['journal_id'],                                                        
                            'payee'=> $result['acc_name'],
                            'number'=> '',                            
                            'ref_id'=> $result['ref_id'],                            
                            'date'      => date($this->language->get('date_format_short'), strtotime($result['entry_date'])),
                            'detail'       =>  $result['details'],
                            'account'       => $result['acc_name'] .' Account',                            
                            'increase'       => $increase==0?'':$increase,
                            'decrease'       =>  $decrease==0?'':$decrease ,
                            'balance'       => $balance
                    );
                }
            }    
            $this->load->library('json');
            $this->response->setOutput(Json::encode($accounts_array), $this->config->get('config_compression'));
        }

        public function getVendorRegister()
        {
           $this->load->model('account/register');   
           $customerReg_array = array();    
           $data = $this->request->get;  
           $purchase=0;$paid=0; $balance=0; $discount=0; $reg_disc=0; $netSale=0;$show='none';$openbal=0;$show_return='none';$show_charge='none';
           $show_regdisc='none';$purchase_Ret=0;$vendorAmount=0;
           $amount=0; $return=0; $profit=0;$returnProfit=0; $purchaseAmout=0;$returnpurchaseAmount=0; $inv_id= 0;$all_ids=''; $return_ids=0;
            $dis_return=0;$charge=0;
        
         $results = $this->model_account_register->getAllRegisterRecord($data); 
             foreach($results as $result)
             {
            
              $amount=-1*$result['journal_amount'];
             $balance=$balance+$amount;
               if($result['type']=='VEND_OB')
              {
                 $openbal=$result['journal_amount'];
            
              } 
                elseif($result['type']=='P' && $result['inv_id'] !=0)
              {
                 $purchase=$purchase+$amount;
            
              } 

                elseif($result['type']=='PO_RET' && $result['inv_id'] !=0)
              {
                 $purchase_Ret=$purchase_Ret+$amount;
            
              }
               elseif($result['type']=='VENDOR_PAY')
              {
                 $vendorAmount=$vendorAmount+$amount;
            
              }
            }
                 $customerReg_array['vendorReg'][] = array(
                            'openbal'          => number_format( $openbal,2,'.',''),
                            'purchase'         => number_format( $purchase,2,'.',''),    
                            'purchase_Ret'     =>  number_format( -1*$purchase_Ret,2,'.',''),
                            'vendorAmount'     =>  number_format( -1*$vendorAmount,2,'.',''),
                            'balance'          => number_format( $balance,2,'.','') ,
                            'reg_type'         => 'customer'
                    );

                           $this->load->library('json');
                $this->response->setOutput(Json::encode($customerReg_array), $this->config->get('config_compression'));
        }

        public function getRegionCustomer()
        {
          $this->load->model('account/register');   
           $customerReg_array = array();    
           $data = $this->request->get;  
           $sale=0;$paid=0; $balance=0; $discount=0; $reg_disc=0; $netSale=0;$show='none';$openbal=0;$show_return='none';$show_charge='none';
           $show_regdisc='none';$purchase_Ret=0;$vendorAmount=0;
           $amount=0; $return=0; $profit=0;$returnProfit=0; $purchaseAmout=0;$returnpurchaseAmount=0; $inv_id= 0;$all_ids=''; $return_ids=0;
            $dis_return=0;$charge=0;

               $results = $this->model_account_register->getAllRegisterRecord($data); 
             foreach($results as $result)
             {
             
            
              $amount=$result['journal_amount'];
              $balance=$balance+$amount;
              if($result['type']=='S' && $result['item_id'] !=0 && $result['inv_id'] !=0)
              {
                
               
                 $sale=$sale+$amount;
            
              }
              if($result['type'] =='S')
                {
                  if(isset($result['type']) && $result['type']=='S')
                  {
                    $all_ids=$all_ids.','.$result['inv_id'];
                  }
                  else{
                    $all_ids=NULL;
                  }
                  
                  
               
                }

               elseif($result['type']=='DIS' && $result['inv_id'] !=0)
                {

                  $discount=$discount-$result['journal_amount'];
                  // $netSale=$sale-$discount;
                } 
                  elseif($result['type']=='DIS' && $result['inv_id'] ==0)
                {

                  $reg_disc=$reg_disc-$result['journal_amount'];
                  if($reg_disc>0)
                  {
                    $show_regdisc='show';
                  }
                  else{
                   $show_regdisc='none'; 
                  }
                  // $netSale=$sale-$discount;
                }
                elseif($result['type']=='SALE_RET')
                {
                  $return_ids=$return_ids.','.$result['inv_id'];
                  $return=$return-$result['journal_amount'];
                  if($return>0)
                  {
                    $show_return="show";
                  }
                  else{
                   $show_return="none"; 
                  }
                  // $netSale=$netSale+($return);
                }
                  elseif($result['type']=='SALE_RET_I')
                {
                  $dis_return=$dis_return+$result['journal_amount'];
                  // $netSale=$netSale+($return);
                }
              elseif($result['type']=='CUST_PAYME'|| $result['journal_details']=='Payment' ||($result['inv_id']==0 && $result['item_id']==0))
              {
                $paid=$paid+$amount*-1;
              }
              
               elseif($result['type']=='CUST_OB')
              {

                $openbal=$result['journal_amount'];
                if($openbal>0)
                {
                  $show='show';
                }
                else{
                  $show='none';
                }
              }
             if($result['type']=='S' && $result['inv_id']==0)
              {
                $charge=$charge+$result['journal_amount'];
                if($charge>0)
                {
                  $show_charge='show';
                }
                else{
                  $show_charge='none';
                }
              }
             }  
             // echo $all_ids;
              // $ids=implode(',',$all_ids);
                // echo $inv_id;

             
             
              if($all_ids !=NULL)
              {
                $inv_id=ltrim($all_ids,',');
                         $purchase=$this->model_account_register->getAllPurchaseAmount( $inv_id);
               $returncost=$this->model_account_register->getAllReturnPurchaseAmount($return_ids);
                 $purchaseAmout=$purchaseAmout+$purchase; 
                 // echo $reg_disc;
                 $returnpurchaseAmount=$returnpurchaseAmount+ (-1*$returncost);
              }
      
             $netSale=$sale-$discount;
             // $netSale=$sale-$discount-($return)+$dis_return;
             $profit=$netSale-$purchaseAmout-$reg_disc;
              $return=$return-$dis_return;
             $returnProfit=$return-$returnpurchaseAmount;
            
                 $customerReg_array['customerReg'][] = array(
                            'openbal'          => number_format( $openbal,2,'.',''), 
                            'sale'             => number_format( $netSale,2,'.','') ,
                            'sale_return'      => number_format( $return,2,'.',''),
                            'purchase'         => number_format( $purchaseAmout,2,'.',''),                            
                            'returncost'       => number_format( $returnpurchaseAmount,2,'.','') ,                            
                            'reg_disc'         => number_format( $reg_disc,2,'.','') ,                            
                            'profit'           => number_format( $profit,2,'.','') ,
                            'returnProfit'     => number_format( -1*$returnProfit,2,'.','') ,
                            'paid'             => number_format( $paid,2,'.','') ,
                            'charge'           => number_format( $charge,2,'.','') ,
                            'balance'          => number_format( $balance,2,'.','') ,
                            'show'             => $show,
                            'show_return'      => $show_return,
                            'show_regdisc'     => $show_regdisc,
                            'show_charge'      => $show_charge,
                            'reg_type'         => 'customer'
                    );

                    $this->load->library('json');
                $this->response->setOutput(Json::encode($customerReg_array), $this->config->get('config_compression'));
        }

        public function pay(){
            $pay_array = array(); 
  $this->load->model('account/register');                 
  if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $data = $this->request->post;     
                        if($data['type']=="1"){
                            $this->model_account_register->savePayment($data);                        
                        }
                        else if($data['type']=="2"){
                            $this->model_account_register->saveVendorPayment($data);                        
                        }
                         else if($data['type']=="3"){
                            $this->model_account_register->saveBankPayment($data);                        
                        }
                        else if($data['type']=="4"){
                            $this->model_account_register->saveExpense($data);                        
                        }
                        $pay_array['success'] =true;
   $pay_array['action'] = '1';                        
  } 
                
                $this->load->library('json');
                $this->response->setOutput(Json::encode($pay_array), $this->config->get('config_compression'));
        }
        
          
 
}
?>