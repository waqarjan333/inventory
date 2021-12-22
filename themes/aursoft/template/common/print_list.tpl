<!DOCTYPE html>
<html lang="">
<head>
<title>Invoice List </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/print.css" />        
</head>
<body>
    <div class="dot-matrix full" >  
        <div class="inv-header">
            <div class="headbar logo"><img src="<?php echo $site_logo; ?>" class="invoice-logo" /><?php echo $this->config->get('config_owner') ?></div>            
        </div>
        <div style="clear:both">
            <table class="header-table">
                <tr>                   
                    <td>
                        <div class="block bottom-space">
                            <b>From Date: <span class="from-invoice-date"></span></b><br/>
                            <b style="margin-top:5px;display:inline-block">To Date: <span class="to-invoice-date"></span></b>                            
                        </div> 
                    </td>
                    <td >
                        <div class="block bottom-space">
                            <b>Region: <span class="region_customer"></span></b>
                        </div>
                        <div class="block bottom-space">
                            <b>Type: <span class="type-customer"></span></b>
                        </div>
                    </td>

                </tr>
            </table> 
        </div>
        <b class="top-divider full">------------------------------------------------------------------------------------------------------------------------------------------------------</b>       
        <div class="invoice-body full">
             <table class="inv-heading" cellpadding="0" cellspacing="0" style="width:800px">
                 <thead>
                <tr> 
                    <th class="td-qty" width="110px">
                        Date
                       <div style="width:110px; overflow: hidden;">------------------</div>
                    </th>                       
                    <th class="td-sno" width="120px">
                        Invoice No.
                    <div style="width:120px; overflow: hidden;">---------------------</div> 
                    </th>                                            
                    <th class="td-description" width="100%">
                        Customer Name
                    <div style="width:440px; overflow: hidden;">---------------------------------------------------------------------------</div> 
                    </th>                                            
                    
                    <th class="td-amount" width="130px">Amount
                        <div style="width:130px; overflow: hidden;">----------------------</div>
                    </th>
                </tr>                                    
                </thead>
                <tbody class="receipt-large-body"></tbody>                            
                 <tfoot>
                    <td colspan="3" style='padding:0px !important;'><div style="width:670px; overflow: hidden;">---------------------------------------------------------------------------------------------------------------------------------------</div> <div class="total_text"> Total:</div></td>                                        
                    <td style='padding:0px !important;'><div style="width:130px; overflow: hidden;">--------------------------------</div> <div class="total_amount" style="text-align:right">122</div></td>
                </tfoot>
             </table>
            <div class="bottom-divider full">------------------------------------------------------------------------------------------------------------------------------------------------------------------</div>            
            
        </div>
         <div class="thank_message">                                                               
            <div class="aursoft_marekting">
                -------------------------<br/>
                Developed by Aursoft <br/>
                http://www.aursoft.com
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.min.js"></script> 
</body>
</html>    