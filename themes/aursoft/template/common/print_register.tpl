<!DOCTYPE html>
<html lang="">
<head>
<title>Register </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/print.css" />        
</head>
<body>
    <style>
    </style>
    <div class="dot-matrix full" >  
        <div class="inv-header">
            <div class="headbar logo"><img src="<?php echo $site_logo; ?>" class="invoice-logo" style="width:300px !important;height:120px !important;" /><?php echo $this->config->get('config_owner') ?></div>            
        </div>
        <div style="clear:both">
            <table class="header-table">
                 <tr>                   
                    <td>
                         <div class="block bottom-space" style="width:400px !important">
                           <!--  <b>Register for: <span class="register_customer" id="name"></span></b> -->
                        </div>
                        
                    </td>
                    <td style="display:none">
                        <div class="block bottom-space">
                            <b>From Date: <span class="from-invoice-date"></span></b><br/>
                            <b style="margin-top:5px;display:inline-block">To Date: <span class="to-invoice-date"></span></b>                            
                        </div> 
                       
                    </td>

                </tr>
            </table> 
        </div>        
        <div class="invoice-body full">
            <table class="inv-heading" border="1" cellpadding="1" cellspacing="1" style="width:800px">
                 <thead>
                    <tr>
                        <th colspan="8"> <b style="padding:10px;"><span class="register_customer" style="font-size:20px;letter-spacing: 5px" id="name"></span></b></th>
                    </tr>
                <tr> 
                    <th class="td-qty" style="border-bottom:1px solid black" width="14%">
                        Date
                       <!-- <div style="style="border-bottom:1px solid black" width:100px; overflow: hidden;">-------------</div> -->
                    </th>                       
                    <th class="td-sno" style="border-bottom:1px solid black" width="8%">
                        No.
                    <!-- <div style="style="border-bottom:1px solid black" width:60px; overflow: hidden;">----------</div>  -->
                    </th>                                            
                    <th class="td-description" style="border-bottom:1px solid black" width="17%">Payee
                    <!-- <div style="style="border-bottom:1px solid black" width:60px; overflow: hidden;">----------</div>  -->
                    </th>
                    <th class="td-account" style="border-bottom:1px solid black" width="10%">Account
                    <!-- <div style="style="border-bottom:1px solid black" width:120px; overflow: hidden;">-------------------</div>  -->
                    </th>
                    <th class="td-amount" style="border-bottom:1px solid black" width="20%">Description
                        <!-- <div style="style="border-bottom:1px solid black" width:20px; overflow: hidden;">----------------------</div> -->
                    </th>
                    <th class="td-amount" style="border-bottom:1px solid black" width="13%">Amt Chrged
                        <!-- <div style="style="border-bottom:1px solid black" width:80px; overflow: hidden;">-------------</div> -->
                    </th>
                    <th class="td-amount" style="border-bottom:1px solid black" width="8%">Amt Paid
                        <!-- <div style="style="border-bottom:1px solid black" width:80px; overflow: hidden;">-------------</div> -->
                    </th>
                    <th class="td-amount" style="border-bottom:1px solid black" width="10%">Balance
                        <!-- <div style="width:100px; overflow: hidden;">--------------</div> -->
                    </th>
                </tr>                                    
                </thead>
                <tbody class="register-large-body"></tbody>                            
                 <tfoot>
                    
                </tfoot>
             </table>      
            
        </div><br>
         <div class="thank_message" style="margin-top:20px">                                                               
            <div class="aursoft_marekting">
                -------------------------<br/>
                Developed by  <br/>
                http://www.aursoft.com
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script> 
</body>
</html>    