<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
<title>Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if($direction=="rtl"){ ?>    
        <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/print_rtl.css" />    
        <?php if($this->config->get('config_language')=="ar"){ ?>    
    <style>
            @font-face
            {
                font-family: AL-Mohanad;
                src: url('<?php echo $theme; ?>/stylesheet/fonts/al-mohanad-bold.ttf');
            } 
            .x-body, *{
                font-family:'AL-Mohanad',AL-Mohanad,Arial,Tahoma !important;
            }
    </style>
    <?php } else { ?>
        <style>
                @font-face
                {
                    font-family: nafees-nastaleeq;
                    src: url('<?php echo $theme; ?>/stylesheet/fonts/NafeesWeb.ttf');
                } 
                .x-body, *{
                    font-family:'nafees-nastaleeq',nafees-nastaleeq,Arial,Tahoma !important;
                }
        </style>
    <?php } ?>  
    <?php } else { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/print.css" />    
        
     <?php } ?>   
    
    <script>
        function batchPrint(){
           if(jsPrintSetup){
            //jsPrintSetup.setOption('printSilent', 1);
            jsPrintSetup.print();            
            jsPrintSetup.clearSilentPrint();
           }
        }
    </script>
</head>
<body>
    <div class="dot-matrix" >  

       <div style="border: 1px solid gray;padding-left: 5px;padding-top: 5px;padding-bottom: 0px; margin-bottom: 5px !important;">
            <div class="inv-header" >
            <div class="headbar logo so_invoice_detail urdu2"  style="position: absolute;top: -0.5%;"><h2><?php echo $this->config->get('config_owner') ?></h2></div>
            <?php if($direction=="rtl"){ ?>  
                <div class="invoice-address" style="margin-top: 10px !important;font-size: 14px;" ><?php echo $this->config->get('config_address') ?></div> <br/>
            <?php } ?>
             <?php if($direction!="rtl"){ ?>  
            <div class="headbar inv-head"  style="font-size:16px;font-weight: bold;"  ><!-- <?php echo $text_invoice; ?> --></div>
            <?php } else{ ?>
            <div class="headbar inv-head"  style="position: absolute;top: 1%;left: 10%;"  ><!-- <?php echo $text_invoice; ?> --></div>
            <?php } ?>
        </div>
        <div style="clear:both">
            <table class="header-table">
                <tr>
                   
                    <div class="line1"  style="border-left: 1px solid #9B9B9B;border-left-style: dashed; height: 70px;position: absolute;left: 200px;top: 45px">
                        
                    </div>
                    <td class="so_invoice_detail urdu3">
                        <div class="block po" style="width:180px">
                             <?php if($direction!="rtl"){ ?>  
                                <b ><?php echo $this->config->get('config_address') ?></b> <br/>
                             <?php } ?>
                            <?php if($this->config->get('config_telephone')!="") { ?>
                                <b><?php echo $text_telephone; ?>: </b><?php echo $this->config->get('config_telephone') ?><br/>
                            <?php } ?>    
                            <?php if($this->config->get('config_mobile_2')!="") { ?>
                                <b><?php echo $text_mobile; ?> </b><?php echo $this->config->get('config_mobile') ?><br/>
                            <?php } ?>    
                            <?php if($this->config->get('config_mobile_2')!="") { ?>
                                <b><?php echo $text_mobile2; ?> </b><?php echo $this->config->get('config_mobile_2') ?>
                            <?php } ?>    
                        </div>
                    </td>
                    <td >

                        <div  class="block bottom-space urdu english">

                               <?php if($direction!="rtl"){ ?>
                            <b><span class="bill_to_text"><?php
                        echo $text_bill_to ?></span> <span style="font-size: 14px;" class="bill_to"></span></b>
                              <?php }
                               else{?>
                              <b><span class="bill_to_text"><?php
                        echo $text_bill_to ?></span> <span style="font-size: 20px;" class="bill_to_pur"></span></b> <br>
                            <b class="customers_add_pos"></b>
                       <?php } ?>
                                 
                               <?php if($direction!="rtl"){ ?>
                            <b class="customers_address_pos"></b> <br>   
                          <b><span class="cust_mobile_text" ><?php echo $text_cust_mobile; ?></span><span class="customers_mobile"></span></b>
                              <?php } else { ?>
                             <b class="customers_address_pos"></b> 
                          <b style=""><span class="cust_mobile_text" ><?php echo $text_cust_mobile; ?></span><span class="customers_mobile"></span></b>
                       <?php } ?>
                            
                       
                        <?php if($direction!="rtl"){ ?>
                            <b class="customers_address_pos"></b> <br>   
                          <b><span class="text_cust_address" ><?php echo $text_cust_address; ?></span><span class="customers_address"></span></b>
                              <?php } else { ?>
                             <b class="customers_address_pos"></b><br>
                          <b class=""><span class="text_cust_address" ><?php echo $text_cust_address; ?></span><span class="customers_address"></span></b>
                       <?php } ?>
                       
                       
                               <?php if($direction!="rtl"){ ?>
                            <div class="dates">
                                <b class="so_hide" style="font-size: 9px;"><?php echo $text_invoice_date; ?>: <span class="invoice-date" style="font-size: 9px;"></span></b><br/>
                            <b style="font-size: 9px;"><?php echo $text_printed_date; ?>: <span class="print-invoice-date" style="font-size: 9px;"></span></b><br>
                           <b class="so_hide" ><span class="invoice_no1"></span> <span class="invoice-no1"></span></b>
                           <b class="inv"></b>
                            </div>
                              <?php } else{?>
                              <div class="dates_pos" >
                                <b class="so_hide invDate"><?php echo $text_invoice_date; ?>: <span class="invoice-date"></span></b><br/>
                            <b class="invDatePrint"><?php echo $text_printed_date; ?>: <span class="print-invoice-date"></span></b><br>
                           <b class="so_hide"><span class="invoice_no1"></span> <span class="invoice-no1"></span></b>
                           <b class="inv"></b>
                            </div>
                       <?php } ?>

                         

                        </div>
                      <!--   <div class="block bottom-space" style="position: absolute;top: 70px !important;">
                            
                        </div> -->
                       <!--  <div class="block bottom-space" style="position: absolute;top: 95px !important;">
                          
                        </div> -->
                    </td>
                    <div class="line" style="border-left: 1px solid #9B9B9B;border-left-style: dashed; height: 70px;position: absolute;left: 505px;top: 45px">
                    <td class="so_invoice_detail so_hide urdu1">
                        <div class="block bottom-space" style="font-size: 10px;word-break: break-all;">
                            <b><?php echo $text_region; ?>: <span class="region_customer"></span></b>
                        </div>
                         <div class="block bottom-space">
                            <b><span class="invoice_no"></span>: <span class="invoice-no"></span></b>
                        </div>
                        <div class="block bottom-space" style="font-size: 10px;word-break: break-all;">
                            <b><?php echo $text_salesrep; ?>: <span class="salsrep_name"></span></b>
                        </div>
                        <div class="block bottom-space previous_balance-area" style="display: none">
                            <b><?php echo $text_pre_balance; ?>: <span class="previous_balance"></span></b>
                        </div>
                    </td>

                </tr>
            </table> 
        </div>
       </div>
            
        <div class="invoice-body">
             <table class="inv-heading">
                 <thead>
                <tr> 
                    <th class="td-sno" width="8" align='left'>
                        <?php echo $text_s_no; ?>
                    
                    </th>           
                       <?php if($this->config->get('config_uom')==1) { ?>                                           
                    <th class="td-description" width="80%" style="">
                        <?php echo $text_description; ?>
                    
                    </th> 
                    <?php }else{ ?>
                      <th class="td-description" width="80%" style="padding-right: 310px !important;">
                        <?php echo $text_description; ?>
                    
                    </th> 
                        <?php }?>
                    
                     <th class="td-qty" width="10%"  align='left'>
                        <?php echo $text_qty; ?>
                        
                    </th> 
                   
                      <?php if($this->config->get('config_uom')==1) { ?>
                    <th class="td-uom" style="padding-left: 10px !important;" width="10%"  align='left'>
                        <?php echo $text_uom; ?>
                        
                    </th>
                    <?php }else{ ?>
                     <th class="td-uom" style="padding-left: 10px !important;" width="10%"  align='left'></th>
                    <?php }?>
                        
                    
                    <th class="td-rate" width="10%" style="padding-left: 13px !important;"  align='left'>
                        <?php echo $text_rate; ?>
                        
                    </th>
                    <th class="td-discount" width="10%"  style="padding-left: 10px !important;"  align='left'>
                        <?php echo $text_discount; ?>
                        
                    </th>
                    <th class="td-rate so_invoice_detail" width="10%" style="padding-left: 13px !important;"  align='left'>
                        <?php echo $text_net; ?>
                        
                    </th>
                    <th class="td-amount"  width="10%" style="padding-left: 5px !important;"  align='left' ><?php echo $text_amount; ?>
                       
                    </th>

                </tr>   
                <tr>
                    <?php if($direction!="rtl"){ ?>  
                <td colspan="9" style="border-bottom: 1px solid black;border-bottom-style: dashed; "></td>
                 <?php } else{ ?>
                <td colspan="9" style="border-bottom: 1px solid black;border-bottom-style: dashed; "></td>
                <?php } ?>
                </tr>
                </thead>
                <tbody class="receipt-large-body"></tbody>                            
                <tfoot>
                    <tr>
                  <?php if($direction!="rtl"){ ?>  
                <td colspan="9" style="border-bottom: 1px solid black;border-bottom-style: dashed; "><!-- --------------------------------------------------------------------------------------------------------------------------------------------- --></td>
                 <?php } else{ ?>
                <td colspan="9" style="border-bottom: 1px solid black;border-bottom-style: dashed; "><!-- --------------------------------------------------------------------------------------------------------------------------------------------- --></td>
                <?php } ?>
                    </tr>
                    <tr>
                        <td colspan="2"><!-- <div>--------------------------------------------------------</div>  --><div class="total_text"> <?php echo $text_total; ?>:</div></td>
                <td><!-- <div>--</div> --><div class="total_qty" align='left'>1</div></td>
                <td><!-- <div>---</div><div>&nbsp;</div> --></td>
                <td><!-- <div class="tfoot_">------</div><div>&nbsp;</div> --></td>
                <td><!-- <div class="tfoot_">------</div><div>&nbsp;</div> --></td>  
                <td class="so_invoice_detail"><!-- <div class="tfoot_">--------</div><div>&nbsp;</div> --></td>  
                <td><!-- <div class="tfoot_">--------<?php if($direction=="rtl"){ echo '--------------'; } ?></div>  --><div class="total_amount">122</div></td>
                    </tr>
                    
                </tfoot>
             </table>
               <?php if($direction!="rtl"){ ?>  
            <div class="bottom-divider" style="margin-bottom: -5px !important;border-bottom: 1px solid black;border-bottom-style: dashed; "></div>
             <?php } else{ ?>       
             <div class="bottom-divider" style="float: right;width: 100% !important;margin-bottom: -15px !important; border-bottom: 1px solid black;border-bottom-style: dashed;"></div>
             <?php } ?>     
            <table align="<?php if($direction=='rtl'){ print('left'); } else { print('right'); } ?>" class="total_table" >
                <tbody>                    
                    <tr>
                       <!-- <td><?php echo $text_sub_total; ?>:</td><td class="pos-right-align sub_total" ></td> -->
                    </tr>
                    <tr><td><?php echo $text_discount; ?>:</td><td class="pos-right-align discount">
                        0.00 <?php echo $text_rs; ?>
                    </td></tr>
                    <tr class="wieght_row so_invoice_detail so_hide" style="display:none"><td><?php echo $text_weight; ?>:</td><td class="pos-right-align weight">
                        0.00 Kg
                    </td>
                    </tr>
                    <tr class="emph so_invoice_detail"><td><?php echo $text_total; ?>:</td><td class="pos-right-align total_recpt_large">
                        0.00 <?php echo $text_rs; ?>
                    </td></tr>
                    <tr class="so_invoice_detail so_hide"><td><?php echo $text_paid; ?>:</td><td class="pos-right-align paid">
                        0.00 <?php echo $text_rs; ?>
                    </td></tr>
                    <tr class="so_invoice_detail so_hide balanced"><td><?php echo $text_balance; ?>:</td><td class="pos-right-align balance">
                        0.00 <?php echo $text_rs; ?>
                    </td></tr>
                    <tr class="so_invoice_detail so_hide pre_balanced "><td><?php echo $text_pre_balance; ?>:</td><td class="pos-right-align pre_balance">
                        0.00 <?php echo $text_rs; ?>
                    </td></tr>
                    <tr class="so_hide grand_totaled"><td><?php echo $text_grand_total; ?>:</td><td class="pos-right-align grand_total">
                        0.00 <?php echo $text_rs; ?>
                    </td></tr>
                    <tr class="so_invoice_detail so_hide  ">
                        <!-- <td colspan="2" class="inWordsnum"></td> -->
                    </tr>
                </tbody>
            </table>
            <div class="registerbody"></div>
            <div class="status"></div>
            <!-- <table class="register_table">
                <thead>
                       <tr>
                        <th>Date</th>
                        <th>Number</th>
                        <th>Account</th>
                        <th>Amt Charge</th>
                        <th>Amt Paid</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody class="registerbody">
                 
                    @sci
                </tbody>
            </table> -->
             <div class="custom" style="display:none;margin-top: 50px !important;">
        </div>
            <div class="terms_conditions" style="display:none">
            <div class="terms_condition_heading">Terms & Conditons</div>
            <div class="terms_condtion_text" style="font-size: 15px !important;"></div>
           
        </div>
      
         <div class="thank_message" style="">                                                               
            <div class="aursoft_marekting">
                <?php echo $text_footer; ?>                
            </div>
        </div>
      
    </div>
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script> 
</body>
</html>    
