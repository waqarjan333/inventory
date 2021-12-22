<!DOCTYPE html>
<html lang="">
<head>
<title>Register Payment </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/print.css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <style type="text/css">
        table tr{
            padding-top: 30px !important;
        }
    </style>
    <!-- <div class="dot-matrix full" >   -->
        <div class="inv-header" style="text-align: center; margin-bottom: 20px;">
            <div style="padding: 5px; text-transform: uppercase;"><?php echo $this->config->get('config_owner') ?></div>
            <div style="border: 1px solid black; padding: 5px; width: 50%; clear: both; margin-left: 25%; margin-bottom: 6px;">CASH / CASH EQUIVELANT RECIEPT</div>
            <div>Print Date : <span id="print_date">01/01/2018</span></div>
        </div>
        <hr>

        <div class="container" style="margin-top: 20px;">
            <table >
                <thead>
                    <tr>
                        <th width="20%" align="left">Name:</th>
                        <td width="30%" id="name"></td>
                        <th width="20%" align="left">Type:</th>
                        <td width="30%" id="type"></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <th width="20%" align="left">Amount:</th>
                        <td width="30%" id="amount"></td>
                        <th width="20%" align="left">Amount In Word:</th>
                        <td width="30%" id="inWord"></td> 
                    </tr>
                    
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <th align="left">Remarks:</th>
                        <td colspan="3" id="remarks" ></td>
                    </tr>
                </tbody>
            </table>
        </div>       
        <div class="invoice-body full" >
       
            
            <div class="form-group" style="margin-top: 20px !important;">
                <label for="amount" class="control-label col-xs-8">Note : <br> 1) This Reciept is NOT VALID unless Signed / Stamped </label>
                <div class="col-xs-4" style="text-align: center; margin-top: 50px;">
                    <p style="margin-bottom: -3px;">=============================</p>
                    <p style="margin-bottom: -3px;">  Sign / Stamp</p>
                    <p>  <?php echo $this->config->get('config_owner') ?></p>
                </div>
            </div>
        </div>
        <br><br>
         <div class="thank_message">                                                               
            <div class="aursoft_marekting">
                -------------------------<br/>
                Developed by  <br/>
                http://www.aursoft.com
            </div>
        </div>
    <!-- </div> -->
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script> 
</body>
</html>    