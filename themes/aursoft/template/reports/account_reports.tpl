<!DOCTYPE html>
<html lang="en">
<head>
<title>Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $get_url; ?><?php echo $theme; ?>/stylesheet/reports.css" />

</head>
<body>
    <div class="mainContainer accounts">
        <div class="middle">
            <div class="header">            
                <div id="company_name">
                </div>
                <div id="report_name">
                </div>            
                <div id="div_end_date">

                </div>
            </div>
            <div class="body">

            </div>
       </div>      
    </div>
    <form method="post" action="" id="report_form">
        <input type="hidden" name="report_id" />
        <input type="hidden" name="report_name" />        
        <input type="hidden" name="start_date" /> 
        <input type="hidden" name="end_date" />   
        <input type="hidden" name="customer_id" />
        <input type="hidden" name="customer_region" />
    </form> 
     <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script>     
     <script type="text/javascript">
    /*if(top.reports_obj){
        top.reports_obj.unMask();
        top.reports_obj.isLoaded=true;
    }*/
    var server_url = "<?php echo $get_url; ?>";
    $(function(){
        top.reports_obj.getAccountReport();
    });
    function generate_report(params){
        if(params){            
            $("input[name='report_id']").val(params.report_id);
            $("input[name='report_name']").val(params.report_name);            
            $("input[name='end_date']").val(params.end_date);  
            if(params.start_date){
                $("input[name='start_date']").val(params.start_date);     
            }
            if(params.customer_id){
                $("input[name='customer_id']").val(params.customer_id);     
            }
            if(params.customer_region){
                $("input[name='customer_region']").val(params.customer_region);     
            }
        }
        if(params.report_id==41){
            $.post("<?php echo $get_url_balancesheet; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data); 
                console.log(result);
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    var _date = new Date();                    
                    $("#div_end_date").html("As of <span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#company_name").html(result.company_name);
                    var report_table = "<table class='report_table accounts'>";                    
                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="head_asset"){
                                report_table += "<tr class='head-asset'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="current_asset"){
                                report_table += "<tr class='current-asset'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="other_asset"){
                                report_table += "<tr class='othter-asset'><td colspan='2' ><div>"+result.records[r].title+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="asset"){
                                report_table += "<tr class='cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_cur_asset"){
                                report_table += "<tr class='total-cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_asset"){
                                report_table += "<tr class='total-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            
                            else if(result.records[r].is_type=="head_leq"){
                                report_table += "<tr class='head-leq'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                            }
                            
                            else if(result.records[r].is_type=="head_l"){
                                report_table += "<tr class='head-l'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                            } 
                            else if(result.records[r].is_type=="current_l"){
                                report_table += "<tr class='current-l'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                            }                            
                            else if(result.records[r].is_type=="liability"){
                                report_table += "<tr class='cur-liability'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_cur_l"){
                                report_table += "<tr class='total-cur-l'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_l"){
                                report_table += "<tr class='total-l'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            
                            else if(result.records[r].is_type=="head_equity"){
                                report_table += "<tr class='head-equity'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="equities"){
                                report_table += "<tr class='cur-equity'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_equity"){
                                report_table += "<tr class='total-equity'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            }
                            
                            
                            else if(result.records[r].is_type=="total_le"){
                                report_table += "<tr class='total-le'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                            } 
                        }
                    }
                    report_table += "</tbody></table>";
                    
                    $(".body").children().remove();
                    $(".body").append($(report_table))                    
                }
                
                top.reports_obj.reportReady();
            });
        }
        
       else if(params.report_id==54){
            $.post("<?php echo $get_url_trialbalancesheet; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data); 
                console.log(result);
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    var _date = new Date();                    
                    $("#div_end_date").html("As of <span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#company_name").html(result.company_name);
                    var debitTotal = 0;
                    var creditTotal = 0;
                    var acc_payable = "";
                    var payable_total = 0;
                    var acc_receivable = "";
                    var receivable_total = 0;
                    var acc_expense = "";
                    var expense_total = 0;
                    var rows = "";
                        for(var r=0; r < result.trail.length;r++){
                            if(result.trail[r]){
                                if((result.trail[r].is_type) == 'Account Payable'){
                                    if(result.trail[r].debit != 0 && result.trail[r].debit != null){
                                        acc_payable += "<tr class=''><td style='width: 60%'><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td style='width: 20%; padding-right: 3%'><div class='acc-value'>"+result.trail[r].debit+"</div></td><td style='width: 20%'><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                    }
                                    if(result.trail[r].credit != 0 && result.trail[r].credit != null){
                                        acc_payable += "<tr class=''><td style='width: 60%'><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td style='width: 20%'><div class='acc-value'>"+result.trail[r].debit+"</div></td><td style='width: 20%; padding-right: 0%'><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                    }
                                    if(result.trail[r].debit != null && result.trail[r].debit != ""){
                                        payable_total -= parseFloat(result.trail[r].debit);
                                    }
                                    if(result.trail[r].credit != null && result.trail[r].credit != ""){
                                        payable_total += parseFloat(result.trail[r].credit);
                                    }
                                }
                                else if((result.trail[r].is_type) == 'Account Receivable'){
                                    if(result.trail[r].debit != 0 && result.trail[r].debit != null){
                                        acc_receivable += "<tr class=''><td style='width: 60%'><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td style='width: 20%; padding-right: 3%'><div class='acc-value'>"+result.trail[r].debit+"</div></td><td style='width: 20%'><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                     }
                                     if(result.trail[r].credit != 0 && result.trail[r].credit != null){
                                        acc_receivable += "<tr class=''><td style='width: 60%'><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td style='width: 20%'><div class='acc-value'>"+result.trail[r].debit+"</div></td><td style='width: 20%;padding-right:0px'><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                     }
                                     if(result.trail[r].debit != null && result.trail[r].debit != ""){
                                        receivable_total -= parseFloat(result.trail[r].debit);
                                    }
                                    if(result.trail[r].credit != null && result.trail[r].credit != ""){
                                        receivable_total += parseFloat(result.trail[r].credit);
                                    }
                                }  
                                 else if((result.trail[r].is_type) == 'Expenses'){
                                    if(result.trail[r].debit != 0 && result.trail[r].debit != null){
                                        acc_expense += "<tr class=''><td style='width: 60%'><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td style='width: 20%; padding-right: 3%'><div class='acc-value'>"+result.trail[r].debit+"</div></td><td style='width: 20%'><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                     }
                                     if(result.trail[r].credit != 0 && result.trail[r].credit != null){
                                        acc_expense += "<tr class=''><td style='width: 60%'><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td style='width: 20%'><div class='acc-value'>"+result.trail[r].debit+"</div></td><td style='width: 20%;padding-right:0px'><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                     }
                                     if(result.trail[r].debit != null && result.trail[r].debit != ""){
                                        expense_total -= parseFloat(result.trail[r].debit);
                                    }
                                    if(result.trail[r].credit != null && result.trail[r].credit != ""){
                                        expense_total += parseFloat(result.trail[r].credit);
                                    }
                                }
                                else{
                                    if(result.trail[r].debit != 0 && result.trail[r].debit != null){
                                       rows += "<tr class=''><td><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td><div class='acc-value'>"+result.trail[r].debit+"</div></td><td><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                    }
                                    if(result.trail[r].credit != 0 && result.trail[r].credit != null){
                                       rows += "<tr class=''><td><div class='acc-name'>"+result.trail[r].account_name+"</div></td><td><div class='acc-value'>"+result.trail[r].debit+"</div></td><td><div class='acc-value'>"+result.trail[r].credit+"</div></td></tr>";
                                    }
                                }
                                if(result.trail[r].debit != null && result.trail[r].debit != "" && result.trail[r].id !=11){
                                    debitTotal += parseFloat(result.trail[r].debit);
                                }
                                if(result.trail[r].credit != null && result.trail[r].credit != ""){
                                    creditTotal += parseFloat(result.trail[r].credit);
                                }
                            }
                            
                            //report_table += " <tr><td>"+trial_result[r].acc_name+"</td><td>"+trial_result[r].debit+"</td><td>"+trial_result[r].credit+"</td></tr>";
                        }
                    var report_table = "<table class='report_table accounts'>";                    
                    report_table += "<tbody>";
                    //var trial_result = [{"acc_name": "Account 1","debit": "100","credit": "0"}, {"acc_name": "Account 2","debit": "100","credit": "0"}, {"acc_name": "Account 3","debit": "0","credit": "200"}, {"acc_name": "Account 4","debit": "50","credit": "0"}, {"acc_name": "Account 5","debit": "0","credit": "50"}];
                    report_table += "  <tr><td></td><td><div class='tital-name'>Debit</div></td><td><div class='tital-name'>Credit</div></td></tr>"; //Heading row
                    
                    //Receivable Accounts Accordion
                    if(acc_receivable != ""){
                        if(receivable_total <= 0){
                            receivable_total*= -1;
                            report_table += "<tr><td colspan='3'><button class='accordion' ><b>Account Receivable </b> <span style= 'font-weight: bold; color: black; float: right; margin-right: 23.5%' class='acc-val'>"+(receivable_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_receivable+"</table></div></td></tr>";
                        }
                        else{
                            report_table += "<tr><td colspan='3'><button class='accordion' ><b>Account Receivable </b> <span style= 'font-weight: bold; color: black; float: right' class='acc-val'>"+(receivable_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_receivable+"</table></div></td></tr>";
                        }
                    }
                    else{
                        report_table += "<tr><td colspan='3'><button class='accordionzero' ><b>Account Receivable </b> <span style= 'font-weight: bold; color: black; float: right' class='acc-val'>"+(receivable_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_receivable+"</table></div></td></tr>";
                    }
                    
                    //payable Accounts Accordion
                    if(acc_payable != ""){
                        if(payable_total < 0){
                            payable_total*= -1;
                            report_table += "<tr><td colspan='3'><button class='accordion' ><b>Account Payable</b> <span style= 'font-weight: bold; color: black; float: right; margin-right: 23.5%' class='acc-val'>"+(payable_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_payable+"</table></div></td></tr>";
                        }
                        else{
                            report_table += "<tr><td colspan='3'><button class='accordion' ><b>Account Payable</b> <span style= 'font-weight: bold; color: black; float: right' class='acc-val'>"+(payable_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_payable+"</table></div></td></tr>";
                        }
                    }
                    else{
                        report_table += "<tr><td colspan='3'><button class='accordionzero' ><b>Account Payable</b> <span style= 'font-weight: bold; color: black; float: right' class='acc-val'>"+(payable_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_payable+"</table></div></td></tr>";
                    } 
                    //Expense Accounts Accordion
                    if(acc_expense != ""){
                        if(expense_total < 0){
                            expense_total*= -1;
                            report_table += "<tr><td colspan='3'><button class='accordion' ><b>Account Expenses</b> <span style= 'font-weight: bold; color: black; float: right; margin-right: 23.5%' class='acc-val'>"+(expense_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_expense+"</table></div></td></tr>";
                        }
                        else{
                            report_table += "<tr><td colspan='3'><button class='accordion' ><b>Account Expenses</b> <span style= 'font-weight: bold; color: black; float: right' class='acc-val'>"+(expense_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_expense+"</table></div></td></tr>";
                        }
                    }
                    else{
                        report_table += "<tr><td colspan='3'><button class='accordionzero' ><b>Account Expenses</b> <span style= 'font-weight: bold; color: black; float: right' class='acc-val'>"+(expense_total).toFixed(2)+"</span></button><div class='panel'><table style='width: 100%; border-spacing:0px'>"+acc_expense+"</table></div></td></tr>";
                    }
                    
                    //Other Accounts Rows
                    report_table += rows;
                    
                    report_table += "<tr><td><div class='total-tital'>Total</div></td><td><hr><div class='total-text'>"+(debitTotal).toFixed(2)+"</div></td><td><hr><div class='total-text'>"+(creditTotal).toFixed(2)+"</div></td></tr></tbody></table>";
                    
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                }
                var acc = document.getElementsByClassName("accordion");
                var i;
                for (i = 0; i < acc.length; i++) {
                  acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    //var panel = document.querySelector('.panel');
                    //console.log(panel);
                    if (panel.style.maxHeight) {
                      panel.style.maxHeight = null;
                    } else {
                      panel.style.maxHeight = panel.scrollHeight + "px";
                    } 
                  });
                }
                top.reports_obj.reportReady();
            });
        }
        
        else if(params.report_id==44){
            $.post("<?php echo $get_url_profitandloss; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data); 
                $("#report_name").html("<i>"+result.report_name+"</i>");                
                $("#div_end_date").html("<span class='date'>"+getDateFromSql(result.start_date)+"</span> to <span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                $("#company_name").html("<b>"+result.company_name+"</b>");
                 var report_table = "<table class='report_table accounts'>";                    
                    report_table += "<tbody>";
                        report_table += "<tr class='head-report'><td colspan='2'><div>Ordinary Income/Expense</div></td></tr>";
                        if(result.records){ 
                            for(var r=0;r<result.records.length;r++){
                                if(result.records[r].is_type=="head_income"){
                                    report_table += "<tr class='head-asset'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                                }else if(result.records[r].is_type=="income"){
                                    report_table += "<tr class='cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="total_cur_income"){
                                    report_table += "<tr class='total-cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }else if(result.records[r].is_type=="head_return"){
                                    report_table += "<tr class='head-return'><td><div>"+result.records[r].title+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="sale_return"){
                                    report_table += "<tr class='cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="total_return"){
                                    report_table += "<tr class='total-cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="head_cogs"){
                                    report_table += "<tr class='head-cogs'><td><div>"+result.records[r].title+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="cogs"){
                                    report_table += "<tr class='cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="total_cogs"){
                                    report_table += "<tr class='total-cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="total_income"){
                                    report_table += "<tr class='total-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                } 
                                else if(result.records[r].is_type=="head_expense"){
                                    report_table += "<tr class='head-leq'><td colspan='2'><div>"+result.records[r].title+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="expense"){
                                    report_table += "<tr class='cur-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="total_expense"){
                                    report_table += "<tr class='total-asset'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="net_income"){
                                    report_table += "<tr class='net_income'><td><div>"+result.records[r].title+"</div></td><td><div class='right'>"+result.records[r].amount+"</div></td></tr>";
                                }
                            }
                        }
                    report_table += "</tbody>";
                    report_table += "</table>";    
                    $(".body").children().remove();
                    $(".body").append($(report_table))      
                    
                top.reports_obj.reportReady();
            });
        }     
  
        
    }
    var month_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    function getDate(_date){        
        return _date.getDate()+" "+month_array[_date.getMonth()]+" "+_date.getFullYear();
    }
    
    function getDateFromSql(d){
        var _date = "";
        if(d){
            var dt = d.split(" ");
            var split_date = dt[0].split("-");
            _date =  month_array[parseInt(split_date[1])-1]+" "+split_date[2] +", "+split_date[0];
        }
        return _date;
    }
    
    
   </script>
</body>
</html>