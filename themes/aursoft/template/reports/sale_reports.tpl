<!DOCTYPE html>
<html lang="en">
<head>
<title>Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $get_url; ?><?php echo $theme; ?>/stylesheet/reports.css" />
</head>
    <?php if($this->config->get('config_language')=="ur"){ ?>  
        <style>
            .prod_name{
                direction: rtl;
                float: left;

            }
           
        </style>
    <?php }?> 

     <?php if($this->config->get('config_warehouse')==0){ ?>  
        <style>
            .warehouse_row{
               display: none !important;

            }
           
        </style>
    <?php }?>
    <style>
    .cashBalance{
      font-weight: bold;
      color: orange;
      letter-spacing: 2px;
    }
     .cashBalanceTotal{
      font-weight: bold;
      color: #005E00;
      font-size: 16px;
      background: #DBDBDB;
      letter-spacing: 2px;
    }
      .cashProftTotal{
      font-weight: bold;
      color: #005E00;
      font-size: 16px;
      background: #D2F0DF;
      letter-spacing: 2px;
    }
    .cashExpense{
      font-weight: bold;
      color: red;
      letter-spacing: 2px;
    }
    .cashRecieve{
      font-weight: bold;
      color: green;
      letter-spacing: 2px;
    }
     .cashTotal{
      font-weight: bold;
      color: blue;
      letter-spacing: 2px;
    }
    .blanAmt{
      font-weight: bold;
      font-size: 20px;
      color: green
    }
        /* Base styling*/
.infotable {
    table-layout: auto !important;
    width: 100% !important;    
  border: 1px dashed gray !important;
  /*border-style: dotted;*/
  border-collapse: collapse !important;
}
.infotable td{
    border:1px dashed gray !important;
    /*border-style: dotted;*/
     white-space: nowrap !important;
}
.popover__title {
  font-size: 24px;
  line-height: 36px;
  text-decoration: none;
  color: rgb(228, 68, 68);
  text-align: center;
  padding: 15px 0;
}

.popover__wrapper {
  position: relative;
  margin-top: -0.5rem;
  display: inline-block;
}
.popover__content {
  opacity: 0;
  visibility: hidden;
  position: absolute;
  left: -130px;
  transform: translate(0, 10px);
  background-color: hsl(0, 0%, 96%);;
  padding: 1.5rem;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
  width: auto;
 margin-left: 43px !important;
 margin-top: 25px !important;
}
.popover__content:before {
  position: absolute;
  z-index: -1;
  content: "";
  right: calc(50% - 10px);
  top: -8px;
  border-style: solid;
  border-width: 0 10px 10px 10px;
  border-color: transparent transparent #bfbfbf transparent;
  transition-duration: 0.3s;
  transition-property: transform;
}
.popover__wrapper:hover .popover__content {
  z-index: 10;
  opacity: 1;
  visibility: visible;
  transform: translate(0, -20px);
  transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}
.popover__message {
  text-align: center;
}

.fixed-header {
      text-align: left;
  position: relative;
  border-collapse: collapse; 
}
.fixed-header tr td { 
   background: #7E8FA0;
   color: white !important;
  position: sticky;
  top: 0; /* Don't forget this, required for the stickiness */
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}

    </style>
<style>
    table.report_table tbody td.ware_total
{
    background-color: #DB9B44 !important;
     font-size: 10px;
     font-weight: bold;
     color:#fff;
}
table.report_table .aging_report  td{
       border-left: 1px solid #C7C7C7 !important;
    border-right: 1px solid #C7C7C7 !important;
    padding: 0px;
    padding-left: 3px;  
}
table.report_table .Vendorpayment_report  td{
       border: 1px solid #C7C7C7 !important;
    /*border-right: 1px solid #C7C7C7 !important;*/
    padding: 0px;
    padding-left: 3px;  
}
table.report_table .aging_detail  td{
  
     border: 1px solid #C7C7C7 !important;
    /*padding-left: 3px;
}
table.report_table .summary  td{
  
     /*border: 1px solid #C7C7C7 !important;*/
    padding: 10px;
    font-weight: bold;
    font-size: 12px;
}
table.report_table .head td{
  
     /*font-weight: bold;
     font-size: 15px;
     padding: 4px;*/
    padding-left: 3px;
}

.ware_name{
    background-color: #C0E6BF !important;
}
.ware_color{
    background-color: #DAD3D6 !important;
}
.service{
    background-color: #CDEBED !important;
    font-weight: bold;
    font-size: 17px;
}
.recevice_total{
    background-color: #F7CBAC !important;
    font-weight: bold;
    font-size: 17px;
}
.reciveCash_total{
    background-color: #FEE0E4 !important;
    /*font-weight: bold;*/
    font-size: 12px;
}
table.report_table tbody td.cust_name {
   font-size: 13px;
    line-height: 24px;
    background-color: #F6F6F6;
    color: #100000;
    border-bottom: 1px solid #C7C7C7;
    font-weight: 600;
    text-align: center;
    letter-spacing: 5px;
}
table.report_table tbody td.invoice {
  
    border-bottom: 1px solid #C7C7C7;
    border-top: 1px solid #C7C7C7;
        padding: 0px;
    padding-left: 3px;
}
table.report_table tbody .agingsummary {
  
    /*border-bottom: 1px solid #C7C7C7;*/
    border-top: 1px solid #C7C7C7;
        /*padding: 0px;
    padding-left: 3px;*/
}
table.report_table tbody .sale td {
    border-top: 1px solid #C7C7C7;
}


 
</style>
<style>
@page {
  /*size: 7in 9.25in;*/
  margin: 5mm 1mm 5mm 1mm;
}
    @media print
        
        {
            *{
                padding: 0;
                margin: 0;
            }
           

            
        .header #col_left   {
          margin-top: -8px !important;

           } 

           .body .report_table{
            margin-top: 1px !important;
           }

           a{
            text-decoration: none;
            color:#000;
           } 

           .color{
            background: yellow !important;
           }
           .cat_name,.cat_total,.grand_total{
            background: white !important;
           }

    table.report_table thead td {
    border-bottom: 2px solid hsl(0deg 0% 58%) !important;
    border-top: 2px solid hsl(0deg 0% 58%) !important;
    color: hsl(0deg 0% 58%) !important;
    font-weight: bold !important;
    text-transform: uppercase !important;
    /* padding: 3px 7px; */
    }  
    .vendorSummary {
    border:1px solid gray;
}
        }
        </style>


<body>

    <div class="mainContainer" id="report_data">
        <div class="header ">
            <div id="col_left">
                <div id="report_name">
                </div>
                <div id="print_date" class="date_row">
                </div>
                <div id="div_start_date" class="date_row">
                    
                </div>
                <div id="div_end_date" class="date_row">
                    
                </div>
                    
            </div>
            <div id="col_right" class="logo">
                
            </div>
            <input type="hidden" value="" id="item_sdate">
            <input type="hidden" value="" id="item_edate">
        </div>
        <div class="body">
            
        </div>
    </div>
    <form method="post" action="<?php echo $get_url_report; ?>"  id="report_form">
        <input type="hidden" name="report_id" />
        <input type="hidden" name="report_name" />
        <input type="hidden" name="start_date" />
        <input type="hidden" name="end_date" />
        <input type="hidden" name="product_id" />
        <input type="hidden" name="category_id" />
        <input type="hidden" name="warehouse" />
        <input type="hidden" name="print_category_report" />
        <input type="hidden" name="show_in_coton" />
        
        <input type="hidden" name="rep_id" />
        <input type="hidden" name="user_id" />
        <input type="hidden" name="customer_id" />
        <input type="hidden" name="invoice_type" />
        <input type="hidden" name="customer_type" />
        <input type="hidden" name="customer_region" />
        
        <input type="hidden" name="print_loan_report" />
        <input type="hidden" name="report_expense_combo" />
        <input type="hidden" name="item_code" />
        <input type="hidden" name="vendor_id" />
        <input type="hidden" name="show_invoice_detail" />
        <input type="hidden" name="units" />
        <input type="hidden" name="All" />
        <input type="hidden" name="to_warehouse" />
        <input type="hidden" name="over_limit_detail" />
        <input type="hidden" name="below_order_point" />
        <input type="hidden" name="below_zero_quantity" />
        <input type="hidden" name="below_zero_price" />
        <input type="hidden" name="last_payment" />
        <input type="hidden" name="non_collected" />
        <input type="hidden" name="show_price" />
        
        <input type="hidden" name="asset_id" />
        <input type="hidden" name="cat_id" />
        <input type="hidden" id="item_id" name="item_id" />
        <input type="hidden" id="warehouse_type" name="warehouse_type" />
        <input type="hidden" id="cust_saleDetail" name="cust_saleDetail" />
        <input type="hidden" id="CustBelowZero" name="CustBelowZero" />
        <input type="hidden" id="product_search" name="product_search" />
        
    </form>  
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script>  
<script type="text/javascript">
    var server_url = "<?php echo $get_url; ?>";    
    $(function(){ 
        if(top.reports_obj){
            //alert('hello');
            top.reports_obj.unMask();
            top.reports_obj.isLoaded=true;
            top.reports_obj.getSaleReport();
        }
    });
   
    function generate_report(params){
        //console.log(params);
        if(params){
            $("input[name='report_id']").val(params.report_id);
            $("input[name='report_name']").val(params.report_name);
            $("input[name='start_date']").val(params.start_date);
            $("input[name='end_date']").val(params.end_date);
            $("input[name='category_id']").val(params.category_id);
            $("input[name='product_id']").val(params.product_id);
            $("input[name='product_search']").val(params.product_search);
            if(params.print_category_report){
                $("input[name='print_category_report']").val(params.print_category_report);
            }
            
            if(params.report_expense_combo){
                $("input[name='report_expense_combo']").val(params.report_expense_combo);
            }
            if(params.print_loan_report){
                $("input[name='print_loan_report']").val(params.print_loan_report);
            }
            if(params.rep_id){
                $("input[name='rep_id']").val(params.rep_id);
            }
            if(params.user_id){
                $("input[name='user_id']").val(params.user_id);
            }
            if(params.customer_id){
                $("input[name='customer_id']").val(params.customer_id);
                $("input[name='invoice_type']").val(params.invoice_type);
                $("input[name='customer_type']").val(params.customer_type);                
            }
            if(params.customer_region){
                $("input[name='customer_region']").val(params.customer_region);
            }            
            if(params.item_code){
                $("input[name='item_code']").val(params.item_code);
            }
             if(params.vendor_id){
                $("input[name='vendor_id']").val(params.vendor_id);
            }
            if(params.units){
                $("input[name='units']").val(params.units);
            }
              if(params.warehouse){
                $("input[name='warehouse']").val(params.warehouse);
            }
              if(params.to_warehouse){
                $("input[name='to_warehouse']").val(params.to_warehouse);
            }  
             if(params.over_limit_detail){
                $("input[name='over_limit_detail']").val(params.over_limit_detail);
            }
            if(params.below_order_point){
                $("input[name='below_order_point']").val(params.below_order_point);
            } 
            if(params.below_zero_quantity){
                $("input[name='below_zero_quantity']").val(params.below_zero_quantity);
            }
             if(params.below_zero_price){
                $("input[name='below_zero_price']").val(params.below_zero_price);
            }
               if(params.last_payment){
                $("input[name='last_payment']").val(params.last_payment);
            }
              if(params.non_collected){
                $("input[name='non_collected']").val(params.non_collected);
            }
              if(params.show_price){
                $("input[name='show_price']").val(params.show_price);
            } 
            if(params.show_in_coton){
                $("input[name='show_in_coton']").val(params.show_in_coton);
            }
            if(params.asset_id){
                $("input[name='asset_id']").val(params.asset_id);
            } if(params.cat_id){
                $("input[name='cat_id']").val(params.cat_id);
            }
            if(params.item_id){
                $("input[name='item_id']").val(params.item_id);
            }
             if(params.warehouse_type){
                $("input[name='warehouse_type']").val(params.warehouse_type);
            }
            if(params.cust_saleDetail){
                $("input[name='cust_saleDetail']").val(params.cust_saleDetail);
            } 
             if(params.CustBelowZero){
                $("input[name='CustBelowZero']").val(params.CustBelowZero);
            }  
           
            
        }
        if(params.report_id==101){
           
            $.post("<?php echo $get_url_Returnreport; ?>", $("#report_form").serialize(),
            
            function(data) {            
                var result = jQuery.parseJSON(data);
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table' id='report_table'>";
                    report_table +="<thead><tr><td><?= $text_product; ?></td><td><?= $text_qty; ?></td><td><?= $text_sale_price; ?></td><td><?= $text_deduction; ?></td><td><?= $text_sale; ?></td><td><?= $text_cost; ?></td><td><?= $text_revenue; ?></td></tr></thead>";
                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            
                             if(result.records[r].is_type=="return_category"){
                                report_table += "<tr><td colspan='7' class='cat_name'><div>"+result.records[r].return_category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="return_product"){
                                report_table += "<tr><td><div class='prod_name'>"+result.records[r].return_product_name+"</div></td>";
                                report_table += "<td>"+result.records[r].return_qty+"</td>";
                                report_table += "<td>"+result.records[r].return_sale_price+"</td>";
                                report_table += "<td>"+result.records[r].return_discount+"</td>";
                                report_table += "<td>"+result.records[r].return_sale+"</td>";
                                report_table += "<td>"+result.records[r].return_cost+"</td>";
                                report_table += "<td>"+result.records[r].return_revenue+"</td>";
                            }
                            else if(result.records[r].is_type=="total_return_sale"){
                                report_table += "<tr><td id='show_return_detail'  class='grand_total sale_return_row'><div>"+result.records[r].sale_return+"</div></td>";
                                report_table +="<td  class='grand_total sale_return_row'>"+result.records[r].return_quantities+"</td>"
                                report_table +="<td  class='grand_total sale_return_row'>"+result.records[r].return_sale_total+"</td>"
                                report_table +="<td  class='grand_total sale_return_row'>"+result.records[r].return_discounts+"</td>"
                                report_table +="<td  class='grand_total sale_return_row'>"+result.records[r].return_sales+"</td>"
                                report_table +="<td  class='grand_total sale_return_row'>"+result.records[r].return_costs+"</td>"
                                report_table +="<td  class='grand_total sale_return_row'>"+result.records[r].return_total_revenue+"</td>"
                                
                            }
                         }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    
                }

                top.reports_obj.reportReadyreturn();
            });
        }  

            if(params.report_id==99){
           
            $.post("<?php echo $get_VendorWiseSaleReport; ?>", $("#report_form").serialize(),
            
            function(data) {            
                var result = jQuery.parseJSON(data);
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table' id='report_table'>";
                    report_table +="<thead><tr><td>Product Name</td><td>Date</td><td>Inv#</td><td>Qty</td><td>U.Price</td><td>Amount</td></tr></thead>";
                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            
                             if(result.records[r].is_type=="vendor"){
                                report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].vendor_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="product"){
                                report_table += "<tr><td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                report_table += "<td>"+result.records[r].inv_date+"</td>";
                                report_table += "<td>Inv# "+result.records[r].inv_no+"</td>";
                                report_table += "<td>"+result.records[r].qty+"</td>";
                                report_table += "<td>"+result.records[r].price+"</td>";
                                report_table += "<td>"+result.records[r].amount+"</td></tr>";
                            }
                       
                         }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    
                }

                top.reports_obj.reportReadyreturn();
            });
        }

        
         if(params.report_id==1){
            $.post($("#report_form").attr("action"), $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    $('#item_sdate').val(result.start_date);
                    $('#item_edate').val(result.end_date);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='30%'><?= $text_product; ?></td><td width='10%'><?= $text_qty; ?></td><td width='10%'><?= $text_net_price; ?></td><td width=10%'><?= $text_discount; ?></td><td width='10%'><?= $text_sub_total; ?></td><td width='10%'><?= $text_cost; ?></td><td width=10%'><?= $text_revenue; ?></td><td width='10%'><?= $text_revenue_per; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="product"){
                                if(result.print_category_report!=1){
                                    report_table += "<tr> <td id='show_item_detail' data-id='"+result.records[r].item_id+"' style='cursor: pointer; cursor: hand;'><a href='#'  style='text-decoration:none'> </span> "+result.records[r].product_name+"</div></a></td>";
                                    report_table += "<td>"+result.records[r].qty+"</td>";
                                    report_table += "<td>"+result.records[r].sale+"</td>";
                                    report_table += "<td>"+result.records[r].discount+"</td>";
                                    report_table += "<td>"+result.records[r].sales+"</td>";                                
                                    report_table += "<td>"+result.records[r].cost+"</td>";
                                    //report_table += "<td>"+result.records[r].avg_cogs+"</td>";
                                    report_table += "<td>"+result.records[r].revenue+"</td>";
                                    report_table += "<td>"+result.records[r].revenue_percent +"%</td></tr>";
                                }
                            }
                            else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr class='ware_name warehouse_row'><td colspan='8' >"+result.records[r].warehouse+"</td></tr>";
                            } 
                            else if(result.records[r].is_type=="service"){
                                report_table += "<tr class='service'><td colspan='8' >"+result.records[r].service+"</td></tr>";
                            }
                             else if(result.records[r].is_type=="ware_total"){
                                report_table += "<tr class='warehouse_row'><td class='ware_total'><div><?= $text_total; ?> "+result.records[r].ware_total+"</div></td>";
                                report_table +="<td class='ware_total'>"+result.records[r].warehouse_qty+"</td>";
                                report_table +="<td class='ware_total'>"+result.records[r].warehouse_sale+"</td>";
                                report_table +="<td class='ware_total'>"+result.records[r].warehouse_discount+"</td>";
                                report_table += "<td class='ware_total'>"+result.records[r].warehouse_sales+"</td>";
                                report_table += "<td class='ware_total'>"+result.records[r].warehouse_cost+"</td>";
                                report_table += "<td class='ware_total'>"+result.records[r].warehouse_revenue+"</td>";
                                report_table += "<td class='ware_total'></td></tr>";
                            } 
                            else if(result.records[r].is_type=="category"){
                                if(result.print_category_report!=1){
                                    report_table += "<tr><td colspan='8' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                }
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total'><div><?= $text_total; ?> "+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>"+result.records[r].category_qty+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].category_sale+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].category_discount+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].category_sales+"</td>";                               
                                report_table +="<td class='cat_total'>"+result.records[r].category_cost+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].category_revenue+"</td>";
                                report_table +="<td class='cat_total'></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_discount"){
                                report_table += "<tr><td class='cat_total'><div><?= $text_discount_on_invoice; ?></div></td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].total_discount+"</td>";
                                report_table +="<td class='cat_total'>(-"+result.records[r].sale_minus+")</td>";
                                report_table +="<td class='cat_total'></td>";
                                report_table +="<td class='cat_total'>(-"+result.records[r].revenue_minus+")</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td></tr>"
                            }
                            else if(result.records[r].is_type=="total"){
                                report_table += "<tr><td class='grand_total'><div><?= $text_grand_total; ?></div></td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_sale+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_disc+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_sales+"</td>";                                
                                report_table +="<td class='grand_total'>"+result.records[r].total_cost+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_revenue+"</td>";
                                report_table +="<td class='grand_total'></td></tr>";
                            }
                            else if(result.records[r].is_type=="total_return_sale"){
                                
                                report_table += "<tr><a href='#'><td  id='show_return_detail'  style='cursor: pointer; cursor: hand;' class='sale_return_row'><div><?= $text_sale_return; ?></div></td></a>";
                                report_table +=" <td  id='show_return_detail' class='sale_return_row'>"+result.records[r].return_qty+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='sale_return_row'>"+result.records[r].return_sale+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='sale_return_row'>"+result.records[r].return_discount+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='sale_return_row'>"+result.records[r].return_sales+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='sale_return_row'>"+result.records[r].return_cost+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='sale_return_row'>"+result.records[r].return_revenues+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='sale_return_row'></td></tr></a>"
                            }
                            else if(result.records[r].is_type=="net_total"){
                                var net_revenue = parseFloat(result.records[r].net_sales-result.records[r].net_cost);
                                report_table += "<tr><a href='#'><td  id='show_return_detail' class='net_income'><div><?= $text_net_total; ?></div></td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='net_income'>"+result.records[r].net_qty+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='net_income'>"+result.records[r].net_salee+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='net_income'>"+result.records[r].net_discount+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='net_income'>"+result.records[r].net_sales+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='net_income'>"+result.records[r].net_cost+"</td></a>";
                                report_table +="<a href='#'><td  id='show_return_detail' class='net_income'>"+net_revenue.toFixed(2)+"</td></a>";
                                report_table +="<a href='#'></a><a href='#'><td  id='show_return_detail' class='net_income'></td></a></tr>";
                            }
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='8'><?= $text_no_record_found; ?></td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    $("#show_return_detail").click(function(){
                        // alert('hello')
                        parent.reports_obj.params.report_id =101;
                        generate_report(params);
                        //show window with iframe

                        });

                    $(document).on('dblclick','#show_item_detail',function(){
                        var name=$(this).data('id');
                        var sdate=$('#item_sdate').val();
                        var edate=$('#item_edate').val();
                        var start_date=$()
                         $('#item_id').val(name);
                         $('#start_date').val(sdate);
                         $('#end_date').val(edate);
                          $('#report_name').text('Sales By Item Detail');  
                        // alert(name);
                        parent.reports_obj.params.report_id =14;
                        generate_report(params);
                    })
                    
                }
                // $('head title', window.parent.document).text('Sale Report');
                top.reports_obj.reportReady();
            });
        }
        else if(params.report_id==12){
            $.post("<?php echo $get_url_daily_sale_report; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_date; ?></td><td align='center'><?= $text_no_of_invoice; ?></td><td align='center'><?= $text_sold_quantities; ?></td><td align='center'><?= $text_amount; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            
                            
                            if(result.records[r].is_type==="daily"){
                                    report_table += "<tr><td class='cat_total'>"+result.records[r].date+"</td>";
                                    report_table +="<td class='cat_total' align='center'>"+result.records[r].invoices+"</td>";
                                    report_table +="<td class='cat_total' align='center'>"+result.records[r].qty+"</td>";
                                    report_table +="<td class='cat_total' align='center'>"+result.records[r].amount+"</td></tr>";
                                
                            } 
                             if(result.records[r].is_type==="region"){
                                    report_table += "<tr><td class='ware_total'>"+result.records[r].total_reg+"</td>";
                                    report_table +="<td class='ware_total' align='center'></td>";
                                    report_table +="<td class='ware_total' align='center'>"+result.records[r].reg_qty+"</td>";
                                    report_table +="<td class='ware_total' align='center'></td></tr>";
                                
                            }
                            else if(result.records[r].is_type==="total"){
                                report_table += "<tr><td class='net_income'>"+result.records[r].total_days+"</td>";
                                report_table +="<td class='net_income' align='center'>"+result.records[r].total_invoices+"</td>";
                                report_table +="<td class='net_income' align='center'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='net_income' align='center'>"+result.records[r].total_amount+"</td></tr>";;
                            }
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    
                    
                }

                top.reports_obj.reportReady();
            });
        }
          else if(params.report_id==11){
            $.post("<?php echo $get_url_category_wise_report; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_cat_name; ?></td><td><?= $text_qty; ?></td><td><?= $text_qty; ?> %</td><td><?= $text_total_sale; ?></td><td><?= $text_total_sale; ?> %</td><td><?= $text_cost; ?></td><td><?= $text_revenue; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            
                            
                            if(result.records[r].is_type==="cat_total"){
                                if(result.qty_per==='0.00'){
                                    report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_name+"</div></td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>";
                                    report_table +="<td class='cat_total'> 0.00 %</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_sale+"</td>";
                                    report_table +="<td class='cat_total'> 0.00 %</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_cost+"</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_revenue+"</td></tr>";
                                } else {
                                    var quantity_per = (result.records[r].cat_qty/result.qty_per)*100;
                                    var sales_per = (result.records[r].cat_sale/result.sale_per)*100;
                                    report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_name+"</div></td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>";
                                    report_table +="<td class='cat_total'> "+quantity_per.toFixed(4)+" %</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_sale+"</td>";
                                    report_table +="<td class='cat_total'> "+sales_per.toFixed(4)+" %</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_cost+"</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_revenue+"</td></tr>";
                                }
                            }
                            else if(result.records[r].is_type==="net_total"){
                                report_table += "<tr><a href='#'><td class='net_income'><div>"+result.records[r].total_sales+"</div></td></a>";
                                report_table +="<a href='#'><td class='net_income'>"+result.records[r].total_qty+"</td></a>";
                                report_table +="<a href='#'><td class='net_income'>&nbsp;</td></a>";
                                report_table +="<a href='#'><td class='net_income'>"+result.records[r].total_sale+"</td></a>";
                                report_table +="<a href='#'><td class='net_income'>&nbsp;</td></a>";
                                report_table +="<a href='#'><td class='net_income'>"+result.records[r].total_cost+"</td></a>";
                                report_table +="<a href='#'><td class='net_income'>"+result.records[r].total_revenue+"</td></a></tr>";
                            }
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    
                    
                }

                top.reports_obj.reportReady();
            });
        }
        //stock Transfer Report
         else if(params.report_id==49){
            $.post("<?php echo $get_url_stocktransfer; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_s_no; ?></td><td><?= $text_product; ?></td><td><?= $text_from_warehouse; ?></td><td><?= $text_qty; ?> </td><td><?= $text_unit; ?></td><td><?= $text_to_warehouse; ?></td><td><?= $text_date; ?></td></tr></thead>";
                  var s_no =1;      
                  if(result.records){ 
                        for(var r=0;r<result.records.length;r++){

                           
                             if(result.records[r].is_type=="product"){
                                report_table += "<tr><td width='10%'>"+s_no+"</td>";
                                report_table += "<td width='25%'><div class='prod_name'>"+result.records[r].product_name+"</div></td>";
                                report_table += "<td>"+result.records[r].from_warehouse+"</td>";
                                report_table += "<td>"+result.records[r].qty+"</td>";
                                report_table += "<td>"+result.records[r].cotton+"</td>";
                                report_table += "<td>"+result.records[r].to_warehouse+"</td>";
                                report_table += "<td>"+result.records[r].date+"</td></tr>"; 
                                s_no = s_no +1;                               
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td  colspan='7' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                             else if(result.records[r].is_type=="ware_invoice"){
                               
                                report_table += "<tr><td  colspan='7' class='cat_name'><div>"+result.records[r].cat_nvoice+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                if(result.print_category_report==0){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table += "<td class='cat_total'></td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>"
                                
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td></tr>";
                             } 
                                
                            }
                          
                            else if(result.records[r].is_type=="total"){
                                
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table += "<td class='grand_total'></td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td></tr>";
                            
                            }

                        }    
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='6'>No Record Found</td></tr>";
                    }
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    
                    
                }

                top.reports_obj.reportReady();
            });
        }
        //Stock Transfer end here

        //Stock Reordering Report start here
        else if(params.report_id==63){
            $.post("<?php echo $get_url_stockreorderingreport; ?>", $("#report_form").serialize(),
            function(data) {            
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_s_no; ?></td><td><?= $text_product; ?></td><td><?= $text_cat_name; ?></td><td><?= $text_last_vendor; ?></td><td><?= $text_current_qty; ?></td><td><?= $text_reordering_point; ?></td><td style='text-align:center'><?= $text_unit_price; ?></td></tr></thead>";
                  var s_no =1;      
                  if(result.records){ 
                        for(var r=0;r<result.records.length;r++){

                           
                             if(result.records[r].is_type=="product"){
                                report_table += "<tr><td width='10%'>"+s_no+"</td>";
                                report_table += "<td width='25%'><div class='prod_name'>"+result.records[r].product_name+"</div></td>";
                                report_table += "<td>"+result.records[r].category+"</td>";
                                report_table += "<td>"+result.records[r].last_vendor+"</td>";
                                report_table += "<td style='width:10%'>"+result.records[r].current_qty+"</td>";
                                report_table += "<td style='font-weight:bold;font-size:17px;background-color:#FFFFCA;width:10%;text-align:center'>"+result.records[r].reorder_point+"</td>"; 
                                report_table += "<td style='text-align:center'>"+result.records[r].unit_price+"</td></tr>"; 
                                s_no = s_no +1;                               
                            }

                             else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr class='ware_name'><td colspan='7' >"+result.records[r].warehouse_name+"</td></tr>";
                            } 
                                                       else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td  colspan='7' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }

                        }    
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='6'>No Record Found</td></tr>";
                    }
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                    
                    
                }

                top.reports_obj.reportReady();
            });
        }
        //Stock Reordering Report End Here
        
        else if(params.report_id==2){
            $.post("<?php echo $get_url_rep_report; ?>", $("#report_form").serialize(),
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_product; ?></td><td><?= $text_total_qty; ?></td><td><?= $text_unit; ?> 1</td><td><?= $text_unit; ?> 2</td><td><?= $text_unit; ?> 3</td><td><?= $text_amount; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="item_name"){
                                report_table += "<tr><td>"+result.records[r].item_name+"</td>";
                                report_table +="<td>"+result.records[r].item_qty+"</td>";
                                report_table +="<td>"+result.records[r].item_unit_1+"</td>";
                                report_table +="<td>"+result.records[r].item_unit_2+"</td>";
                                report_table +="<td>"+result.records[r].item_unit_3+"</td>";
                                report_table += "<td>"+result.records[r].item_amount+"</td></tr>";
                                
                            } 
                            else if(result.records[r].is_type=="cat_name"){ 
                                report_table += "<tr><td class='cat_total'>"+result.records[r].cat_name+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table += "<td class='cat_total'>"+result.records[r].cat_amount+"</td></tr>";
                            }
                            else if(result.records[r].is_type=="rep_name"){ 
                                report_table += "<tr><td class='grand_total' style='background-color: rgb(255, 167, 43) !important; color: white;'>"+result.records[r].rep_name+"</td>";
                                report_table +="<td class='grand_total'style='background-color: rgb(255, 167, 43) !important; color: white;'>"+result.records[r].rep_qty+"</td>";
                                report_table +="<td class='grand_total'style='background-color: rgb(255, 167, 43) !important; color: white;'>&nbsp;</td>";
                                report_table +="<td class='grand_total'style='background-color: rgb(255, 167, 43) !important; color: white;'>&nbsp;</td>";
                                report_table +="<td class='grand_total'style='background-color: rgb(255, 167, 43) !important; color: white;'>&nbsp;</td>";
                                report_table += "<td class='grand_total'style='background-color: rgb(255, 167, 43) !important; color: white;'>"+result.records[r].rep_amount+"</td></tr>";
                            } 
                            else if(result.records[r].is_type=="total"){ 
                                report_table += "<tr><td class='grand_total' style='background-color:green !important; color: white;'>"+result.records[r].total_name+"</td>";
                                report_table +="<td class='grand_total'style='background-color:green !important; color: white;'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='grand_total'style='background-color:green !important; color: white;'>&nbsp;</td>";
                                report_table +="<td class='grand_total'style='background-color:green !important; color: white;'>&nbsp;</td>";
                                report_table +="<td class='grand_total'style='background-color:green !important; color: white;'>&nbsp;</td>";
                                report_table += "<td class='grand_total'style='background-color:green !important; color: white;'>"+result.records[r].total_amount+"</td></tr>";
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='6'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                       
        }
        else if(params.report_id==6){
            $.post("<?php echo $get_url_usersale_report; ?>", $("#report_form").serialize(),
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_user_id; ?></td><td><?= $text_user_name; ?></td><td><?= $text_sale; ?></td><td><?= $text_sale_return; ?></td> <td><?= $text_net_sale; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td>"+result.records[r].user_id+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].user_name+"</div></td>";
                                report_table += "<td>"+result.records[r].sales+"</td>";                                
                                report_table += "<td>"+result.records[r].sales_return+"</td>";                                
                                report_table += "<td>"+result.records[r].net_sale+"</td></tr>";                                
                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>"
                                report_table += "<td class='grand_total'>"+result.records[r].total_sales+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_sales_return+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].net_sale_total+"</td></tr>";                                
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                       
        }
        else if(params.report_id==9){
            $.post("<?php echo $get_url_sale_by_invoices_profit; ?>", $("#report_form").serialize(),
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_s_no; ?></td><td><?= $text_invoice_no; ?></td><td><?= $text_customer_name; ?></td><td><?= $text_total; ?></td><td><?= $text_cost; ?></td><td><?= $text_revenue; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             
                            if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td>"+result.records[r].no+"</td>";
                                report_table += "<td>"+result.records[r].invoiceno+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].customer+"</div></td>";
                                report_table += "<td>"+result.records[r].total+"</td>";
                                report_table += "<td>"+result.records[r].cost+"</td>";
                                report_table += "<td>"+result.records[r].revenue+"</td></tr>";
                            } else if(result.records[r].is_type=="region_total"){
                                report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td>";                                
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total+"</td>"                               
                                report_table +="<td class='cat_total'>"+result.records[r].inv_cost+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].inv_revenue+"</td></tr>"
                            } else if(result.records[r].is_type=="region"){
                                report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].region_name+"</div></td></tr>";
                            } else if(result.records[r].is_type=="total"){                                
                            report_table += "<tr><td class='grand_total' colspan='3'><div class='prod_name'>"+result.records[r].total+"</div></td>";                         
                                report_table +="<td class='grand_total'>"+result.records[r].total_total+"</td>" 
                                report_table +="<td class='grand_total'>"+result.records[r].total_cost+"</td>"
                                report_table += "<td class='grand_total'>"+result.records[r].total_revenue+"</td></tr>";                                
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='6'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                       
        }
        else if(params.report_id==10){
            $.post("<?php echo $get_url_customers; ?>", $("#report_form").serialize(),
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead ><tr><td width='5%'><?= $text_s_no; ?></td><td width='30%'><?= $text_customer_name; ?></td><td width='10%'><?= $text_opening_balance; ?></td><td width='15%'><?= $text_region; ?></td><td width='10%'><?= $text_mobile; ?></td><td width='10%'><?= $text_phone; ?></td><td width='10%'><?= $text_credit_limit; ?></td><td width='10%'><?= $text_over_limit; ?></td></tr></thead>";

                    report_table += "<tbody >";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             if(result.records[r].over_limit >result.records[r].cradit_limit)
                             {
                                // console.log('Hello')
                                // $("#over_limit").addClass("over_limit");
                                // $('.over_limit').css('background-color','yellow');
                             }

                            if(result.records[r].is_type=="customer"){
                                report_table += "<tr style='background-color:"+result.records[r].color+"'><td>"+result.records[r].no+"</td>";
                                report_table += "<td>"+result.records[r].cust_name+"</td>";
                                report_table += "<td>"+result.records[r].openbalance+"</td>";
                                report_table += "<td>"+result.records[r].cust_region+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].cust_mobile+"</div></td>";
                                report_table += "<td>"+result.records[r].cust_phone+"</td>";
                                report_table += "<td>"+result.records[r].cradit_limit+"</td>";
                                report_table += "<td>"+result.records[r].over_limit+"</td>";
                            } else if(result.records[r].is_type=="region"){
                                report_table += "<tr><td colspan='8' class='cat_name'><div>"+result.records[r].region_name+"</div></td></tr>";
                            } 
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                       
        }
        else if(params.report_id==4){
            $.post("<?php echo $get_url_get_sales_order_summary; ?>", $("#report_form").serialize(),
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("<?= $text_start_date; ?>:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_s_no; ?></td><td><?= $text_invoice_no; ?></td><td><?= $text_customer_name; ?></td><td><?= $text_total; ?></td><td><?= $text_discount; ?></td><td><?= $text_paid; ?></td><td><?= $text_balance; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             
                            if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td>"+result.records[r].no+"</td>";
                                report_table += "<td>"+result.records[r].invoiceno+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].customer+"</div></td>";
                                report_table += "<td>"+result.records[r].total+"</td>";
                                report_table += "<td>"+result.records[r].discount+"</td>";
                                report_table += "<td>"+result.records[r].paid+"</td>";
                                report_table += "<td>"+result.records[r].balance+"</td></tr>";
                            } else if(result.records[r].is_type=="region_total"){
                                report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td>";                                
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total_discount+"</td>"                                
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total_paid+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total_balance+"</td></tr>"
                            } else if(result.records[r].is_type=="region"){
                                report_table += "<tr><td colspan='7' class='cat_name'><div>"+result.records[r].region_name+"</div></td></tr>";
                            }  else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='7' class='cat_name'><div>"+result.records[r].payment_total+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td>";                                
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total_discount+"</td>"                                
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total_paid+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].inv_total_balance+"</td></tr>"
                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total' colspan='3'><div class='prod_name'>"+result.records[r].total+"</div></td>";                         
                                report_table +="<td class='grand_total'>"+result.records[r].total_total+"</td>"                                
                                report_table +="<td class='grand_total'>"+result.records[r].total_discount+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_paid+"</td>"
                                report_table += "<td class='grand_total'>"+result.records[r].total_balance+"</td></tr>";                                
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                       
        }
        else if(params.report_id==31){

             $.post("<?php echo $get_url_inventory_summary_report; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    if(result.print_category_report==0){
                    report_table +="<thead><tr><td><?= $text_name; ?></td><td><?= $text_barcode; ?></td> <td><?= $text_on_hand; ?></td><td><?= $text_avg_cost; ?></td><td><?= $text_assets_value; ?></td><td>% of Tot Asset</td><td><?= $text_sale_price; ?></td><td><?= $text_retail_value; ?></td><td>% of Tot Retail</td></tr></thead>";
                    } else {
                    report_table +="<thead><tr><td>Category Name</td><td>Quantity</td><td>Cost Total</td><td>Cost Total %</td><td>Sale Total</td></tr></thead>";    
                    }
                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){

                           
                             if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td><div class='prod_name' style='font-size:11px !important;'>"+result.records[r].item_name+"</div></td>";
                                report_table += "<td>"+result.records[r].item_barcode+"</td>";
                                report_table += "<td>"+result.records[r].item_qty+"</td>";
                                report_table += "<td>"+result.records[r].item_avg_cost+"</td>";                                
                                report_table += "<td>"+result.records[r].item_asset_value+"</td>";                                
                                report_table += "<td>"+result.records[r].item_percent_asset_value+"%</td>";                                
                                report_table += "<td>"+result.records[r].item_sale_price+"</td>";                                
                                report_table += "<td>"+result.records[r].item_retail_value+"</td>";                                
                                report_table += "<td>"+result.records[r].item_percent_retail_value+"%</td></tr>";                                
                            }
                             else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr><td colspan='9 class='ware_color warehouse_row' style='font-size:10px;background:#DAD3D6;color:blue'><div>"+result.records[r].warehouse_name+"</div></td></tr>";
                            }
                               else if(result.records[r].is_type=="ware_total"){
                                report_table += "<tr class='warehouse_row'><td class='ware_total'><div>"+result.records[r].ware_total+"</div></td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_qty+"</td>"
                                report_table +="<td class='ware_total'>&nbsp;</td>"
                                report_table +="<td class='ware_total'>"+result.records[r].ware_asset_value+"</td>"
                                report_table +="<td class='ware_total'>&nbsp;</td>"
                                report_table +="<td class='ware_total'>"+result.records[r].ware_retail_value+"</td></tr>"
                             
                                
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                if(result.print_category_report==0){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table += "<td class='cat_total'></td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>"
                                report_table +="<td class='cat_total'>&nbsp;</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_asset_value+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_totalasset_value+"%</td>"
                                report_table +="<td class='cat_total'></td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_retail_value+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_totalretail_value+"%</td></tr>"
                             } else {
                                 var asset_per = (result.records[r].cat_asset_value/result.category_total_assets)*100;
                                 var retail_per = (result.records[r].cat_retail_value/result.category_total_retail)*100;
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_asset_value+"</td>"
                                report_table +="<td class='cat_total'>"+asset_per.toFixed(4)+" % </td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_retail_value+"</td>"
                             }
                                
                            }
                          
                            else if(result.records[r].is_type=="total"){
                                if(result.print_category_report==0){
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table += "<td class='grand_total'></td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_asset_value+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].net_total_asset+"%</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table += "<td class='grand_total'>"+result.records[r].total_retail_value+"</td>"; 
                                report_table += "<td class='grand_total'>"+result.records[r].net_total_retail+"%</td></tr>"; 
                            } else {
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_asset_value+"</td>";
                                report_table +="<td class='grand_total'>100</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table += "<td class='grand_total'>"+result.records[r].total_retail_value+"</td>";
                                report_table += "<td class='grand_total'>100</td></tr>";
                            }
                            }

                        }    
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='6'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
                    
              });  
        }
        else if(params.report_id==60){
             $.post("<?php echo $get_url_inventory_summary_report; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_s_no; ?></td><td><?= $text_product; ?></td><td class='warehouse_row'><?= $text_warehouse; ?></td><td><?= $text_sale_price; ?></td><td><?= $text_avg_cost; ?></td><td><?= $text_on_hand; ?></td><td><?= $text_qty_diffrence; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        var s_no =1;
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td>"+s_no+"</td><td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                report_table += "<td class='warehouse_row'>"+result.records[r].warehouse+"</td>";
                                report_table += "<td>"+result.records[r].item_sale_price+"</td>";
                                report_table += "<td>"+result.records[r].item_avg_cost+"</td>";                                  
                                report_table += "<td>"+result.records[r].item_qty+"</td>";
                                report_table += "<td></td>";
                                s_no = s_no +1;
                            }
                                else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr><td colspan='7' class='ware_name warehouse_row'><div>"+result.records[r].warehouse_name+"</div></td></tr>";
                            }
                               else if(result.records[r].is_type=="ware_total"){
                                report_table += "<tr class='warehouse_row'><td class='ware_total'><div>"+result.records[r].ware_total+"</div></td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_retail_value+"</td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_asset_value+"</td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_qty+"</td>";
                                report_table += "<td class='ware_total'></td></tr>";
                                
                            }
                            
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_retail_value+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_asset_value+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>";
                                report_table += "<td class='cat_total'></td>";
                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_retail_value+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_asset_value+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table += "<td class='grand_total'></td>";
                                
                            }
                        }    
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='6'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              });  
        }
        else if(params.report_id==37){
             $.post("<?php echo $get_url_inventory_summary_report; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("<?= $text_report_printed; ?>:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_end_date").html("<?= $text_end_date; ?>:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td><?= $text_s_no; ?></td><td><?= $text_product; ?></td><td><?= $text_on_hand; ?></td><td><?= $text_avg_cost; ?></td><td><?= $text_assets_value; ?></td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        var s_no =1;
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td>"+s_no+"</td><td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                report_table += "<td>"+result.records[r].item_qty+"</td>";
                                report_table += "<td>"+result.records[r].item_avg_cost+"</td>";                                
                                report_table += "<td>"+result.records[r].item_asset_value+"</td></tr>";                                
                                //report_table += "<td>"+result.records[r].item_sale_price+"</td>";                                
                                //report_table += "<td>"+result.records[r].item_retail_value+"</td>"; 
                                s_no = s_no + 1;
                            }

                                  else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr><td colspan='6' class='cat_name warehouse_row'><div>"+result.records[r].warehouse_name+"</div></td></tr>";
                            }
                               else if(result.records[r].is_type=="ware_total"){
                                report_table += "<tr class='warehouse_row'><td class='ware_total'><div>"+result.records[r].ware_total+"</div></td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_qty+"</td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_asset_value+"</td></tr>";
                                
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='2'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>"
                                report_table +="<td class='cat_total'>&nbsp;</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_asset_value+"</td></tr>"
                                //report_table +="<td class='cat_total'>&nbsp;</td>"
                                //report_table +="<td class='cat_total'>"+result.records[r].cat_retail_value+"</td>"
                                
                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total' colspan='2'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_asset_value+"</td></tr>";
                                //report_table +="<td class='grand_total'>&nbsp;</td>";
                                //report_table += "<td class='grand_total'>"+result.records[r].total_retail_value+"</td>";                                
                            }
                        }    
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              });  
        }
        
        else if(params.report_id==32){
             // var units = ["kg","gr","tonne","ml","meter","foot","inch","each","dozan","pack","packet","yard","feet","weight","height","width","length","box","bag"];
             var units = ["ea","cotton"];
             $.post("<?php echo $get_url_inventory_detail_report; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                    
                    //$("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Name</td><td class='warehouse_row'>Warehouse</td><td>Qty</td><td>Barcode</td><td>Unit</td><td>Purchase Price</td><td>Sale Price </td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td style='width:10%'>"+result.records[r].item_sno+"</td>";
                                report_table +="<td><div >"+result.records[r].item_name+"</div></td>";
                                report_table +="<td class='warehouse_row'><div >"+result.records[r].ware_name+"</div></td>";
                                report_table +="<td><div class=''>"+result.records[r].item_qty+"</div></td>";
                                report_table += "<td>"+result.records[r].item_barcode+"</td>";
                                // report_table += "<td>"+units[parseInt(result.records[r].item_unit)-1]+"</td>";
                                report_table += "<td>"+result.records[r].item_unit+"</td>";
                                report_table += "<td>"+result.records[r].item_normal_price+"</td>";                                
                                report_table += "<td>"+result.records[r].item_sale_price+"</td></tr>";                                
                                
                            }

                             else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr class='ware_name warehouse_row'><td colspan='8' >"+result.records[r].warehouse_name+"</td></tr>";
                            }
                             else if(result.records[r].is_type=="ware_total"){
                                report_table += "<tr class='warehouse_row'><td class='ware_total'><div>"+result.records[r].ware_total+"</div></td>";
                                report_table +="<td class='ware_total'>&nbsp;</td>";
                                report_table +="<td class='ware_total'>&nbsp;</td>";
                                report_table +="<td class='ware_total'>"+result.records[r].ware_qty+"</td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table += "<td class='ware_total'></td>";
                                report_table += "<td class='ware_total'>"+result.records[r].ware_asset_value+"</td>";
                                report_table += "<td class='ware_total'>"+result.records[r].ware_retail_value+"</td>";
                            } 

                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='8' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                             
                             else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total warehouse_row'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty+"</td>";
                                report_table += "<td class='cat_total'></td>";
                                report_table += "<td class='cat_total'></td>";
                                report_table += "<td class='cat_total'></td>";
                                report_table += "<td class='cat_total'></td>";
                            }

                              
                              else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total warehouse_row'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table += "<td class='grand_total'></td>";
                                report_table += "<td class='grand_total'></td>";
                                report_table += "<td class='grand_total'></td>";
                                report_table += "<td class='grand_total'></td>";
                                
                            }                          
                        }    
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              });  
        } 
        else if(params.report_id==33){
            $.post("<?php echo $get_url_inventory_valuation_detail; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                    
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>&nbsp;</td><td>Date</td><td>Num</td><td>Qty</td><td>Cost</td><td>Name</td><td>On Hand</td><td>Avg Cost</td><td>Asset Value</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td><div class='prod_name'>"+result.records[r].item_detail+"</div></td>";
                                    report_table += "<td>"+result.records[r].item_date+"</td>";
                                    report_table += "<td>"+result.records[r].num+"</td>";
                                    report_table += "<td>"+result.records[r].item_qty+"</td>";
                                    report_table += "<td>"+result.records[r].item_cost+"</td>";
                                    report_table += "<td>"+result.records[r].cust_name+"</td>";
                                    report_table += "<td>"+result.records[r].item_on_hand+"</td>";                                
                                    report_table += "<td>"+result.records[r].item_avg_cost+"</td>";                                
                                    report_table += "<td>"+result.records[r].item_asset_value+"</td></tr>";                                                                
                                }
                                else if(result.records[r].is_type=="category"){
                                    report_table += "<tr><td colspan='9' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="cat_total"){
                                    report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_on_hand+"</td>"
                                    report_table +="<td class='cat_total'>&nbsp;</td>"
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_asset_value+"</td>"

                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_on_hand+"</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].total_asset_value+"</td></tr>";                                
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='8'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==35){
            $.post("<?php echo $get_url_sale_inventory_summary; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                    
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Product</td><td>Opening Stock</td><td>Avg Cost</td><td>Purchase QTY</td><td>Total QTY</td><td>Value</td><td>Sold Qty</td><td>Amount</td><td>Qty on Hand</td><td>Current Value</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="product"){
                                $opening_qty = result.records[r].opening_stock;
                                $total_qty = result.records[r].qty_balance;
                                $beforeAdustqty=result.records[r].onhand - result.records[r].adjuststockQty-result.records[r].OpenStockqty;
                                $beforePurchaseRetqty=Number(result.records[r].purchase_qty) + Number(result.records[r].purchaseRet_qty);
                                $beforeSaleRetqty=Number(result.records[r].sold_qty) + Number(result.records[r].saleRet_qty);
                                // $purchase_qty = $total_qty - $opening_qty;
                                report_table += "<tr><td><div class='prod_name'>"+result.records[r].product_name+"</div></td>";
                                report_table += "<td>"+result.records[r].opening_stock+"</td>";
                                report_table += "<td>"+result.records[r].sale_price+"</td>";
                                report_table += "<td style='cursor: pointer; cursor: hand;'><div class='popover__wrapper'><a href='#' id='buttonId'>"+result.records[r].purchase_qty+"</a><div class='popover__content'><table class='infotable'> <tbody><tr><td>Purchase Qty</td><td style='font-weight:bold;color:blue'>"+$beforePurchaseRetqty+"</td><tr><tr><td>Purchase Ret Qty</td><td style='font-weight:bold;color:blue'>"+result.records[r].purchaseRet_qty+"</td></tr></tbody> </table></div></div></td>";
                                report_table += "<td>"+result.records[r].total_qty+"</td>";
                                report_table += "<td>"+result.records[r].total_value+"</td>";
                                report_table += "<td style='cursor: pointer; cursor: hand;'><div class='popover__wrapper'><a href='#' id='buttonId'>"+result.records[r].sold_qty+"</a><div class='popover__content'><table class='infotable'> <tbody><tr><td>Sale Qty</td><td style='font-weight:bold;color:blue'>"+$beforeSaleRetqty+"</td><tr><tr><td>Sale Ret Qty</td><td style='font-weight:bold;color:blue'>"+result.records[r].saleRet_qty+"</td></tr></tbody> </table></div></div></td>";
                                report_table += "<td>"+result.records[r].amount+"</td>";  

                                   report_table += "<td style='cursor: pointer; cursor: hand;'><div class='popover__wrapper'><a href='#' id='buttonId'>"+result.records[r].onhand+"</a><div class='popover__content'><table class='infotable'> <tbody><tr><td>On Hand Qty</td><td style='font-weight:bold;color:blue'>"+$beforeAdustqty +"</td><tr><tr><td>Adjust Qty</td><td style='font-weight:bold;color:blue'>"+result.records[r].adjuststockQty+"</td></tr><tr style='display:"+result.records[r].display+"'><td>Opening Qty</td><td style='font-weight:bold;color:blue'>"+result.records[r].OpenStockqty+"</td></tr></tbody> </table></div></div></td>";

                                report_table += "<td>"+result.records[r].value+"</td></tr>";
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='10' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                $opening_stock1 = result.records[r].cat_opening_stock;
                                // $total_quantity1 = result.records[r].cat_qty_balance;
                                // $quantity1 = $total_quantity1 - $opening_stock1;
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>"+$opening_stock1+"</td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_qty_balance+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total_qty+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total_value+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total_sold+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total_amount+"</td>";                                
                                report_table +="<td class='cat_total'>"+result.records[r].cat_onhand+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_value+"</td></tr>";
                            }                           
                            else if(result.records[r].is_type=="total"){
                                $opening_stock = result.records[r].total_opening_stock;
                                $total_quantity = Number(result.records[r].total_qty_balance)+Number($opening_stock);
                                $quantity = $total_quantity - $opening_stock;
                                report_table += "<tr><td class='grand_total'><div>"+result.records[r].grand_total+"</div></td>";
                                report_table +="<td class='grand_total'>"+$opening_stock+"</td>";
                                report_table +="<td class='grand_total'>&nbsp;</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty_balance+"</td>";
                                report_table +="<td class='grand_total'>"+$total_quantity+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_total_value+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_total_sale+"</td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_amount+"</td>";                                
                                report_table +="<td class='grand_total'>"+result.records[r].total_onhand+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_value+"</td></tr>"
                            }
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
                        
                          }); 
        }
        else if(params.report_id==36){
            $.post("<?php echo $get_url_low_inventory; ?>", $("#report_form").serialize(),
                function(data) {  
                    var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Product</td><td class='warehouse_row'>Warehouse</td><td>Category</td><td>Re-order Qty</td><td>On Hand</td></tr></thead>";
                    report_table += "<tbody>";
                    var counter =1;
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="product"){
                                report_table += "<tr><td>"+counter+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                report_table += "<td>"+result.records[r].item_category+"</td>";
                                report_table += "<td>"+result.records[r].item_reorder_value+"</td>";
                                report_table += "<td>"+result.records[r].item_qty+"</td></tr>";
                                counter = counter + 1;
                            }
                            else if(result.records[r].is_type=="warehouse"){
                                report_table += "<tr class='ware_total warehouse_row'><td colspan='5' ><div>"+result.records[r].warehouse_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='5' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                                                                        
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==3){
            $.post("<?php echo $get_url_sale_by_customer_report; ?>", $("#report_form").serialize(),
               
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("End Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Customer Name</td><td>Amount</td><td>Date</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             if(result.records[r].is_type=="entry"){                                
                                report_table += "<tr><td><div class='prod_name'>"+result.records[r].cust_name+"</div></td>";
                                report_table += "<td>"+result.records[r].amount+"</td>";                                
                                report_table += "<td>"+result.records[r].bill_date+"</td></tr>";                                
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='3' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";                                    
                                report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>"
                                report_table +="<td class='cat_total'></td>"

                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";                                
                                report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td>";                                
                                report_table += "<td class='grand_total'></td></tr>";                                
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='3'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                      
                    
        }
        else if(params.report_id==7){
            $.post("<?php echo $get_url_sale_by_customer_item_report; ?>", $("#report_form").serialize(),
             function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("End Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Customer Name</td><td>Region</td><td>Amount</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             if(result.records[r].is_type=="entry"){                                
                                report_table += "<tr><td >"+result.records[r].sno+"</td>"; 
                                report_table += "<td ><div class='prod_name'>"+result.records[r].cust_name+"</div></td>";
                                report_table += "<td >"+result.records[r].cust_group+"</td>"; 
                                report_table += "<td>"+result.records[r].amount+"</td></tr>";                                
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='4' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td>";                                    
                                report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>"

                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total' colspan='3'><div class='prod_name'>"+result.records[r].total+"</div></td>";                                
                                report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";                                
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });    
        }
        
        else if(params.report_id==5){
            $.post("<?php echo $get_url_sale_by_region_report; ?>", $("#report_form").serialize(),
            function(data) {  
                var result = jQuery.parseJSON(data);    
                if(result.report_id){
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("End Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);

                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Item Name</td><td>Qty.</td><td>Net Amount</td></tr></thead>";
                    var item_count = 1;
                    report_table += "<tbody>";
                    if(result.records){                        
                        for(var r=0;r<result.records.length;r++){
                             if(result.records[r].is_type=="entry"){                                
                                 report_table += "<tr><td>"+item_count+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                report_table += "<td>"+result.records[r].item_qty+"</td>";
                                report_table += "<td>"+result.records[r].item_net_price+"</td></tr>";                                
                                item_count = item_count + 1;
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='4' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='2'><div>"+result.records[r].cat_total+"</div></td>";        
                                report_table += "<td class='cat_total'>"+result.records[r].cat_qty+"</td>";
                                report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>"

                            }
                            else if(result.records[r].is_type=="discount"){
                                report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].discount_title+"</div></td>";
                                report_table +="<td class='cat_total'>-"+result.records[r].discount+"</td>"

                            }
                            else if(result.records[r].is_type=="total"){                                
                                report_table += "<tr><td class='grand_total' colspan='2'><div class='prod_name'>"+result.records[r].total+"</div></td>";                                
                                report_table += "<td class='grand_total'>"+result.records[r].total_qty+"</td>";
                                report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";                                
                            }
                        }                        
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));                     
                 }   
                 top.reports_obj.reportReady();
            });          
                    
        }
        else if(params.report_id==42){
            $.post("<?php echo $get_url_account_receivable_detail; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    if(result.last_payment !="" && result.over_limit !="")
                    {
                         report_table +="<thead><tr><td>S.No</td><td>Customer Name</td><td>Mobile</td><td class='not-show-in-print'>Over Limit</td><td>LP</td><td>LP Date</td><td>Balance</td><td class='show-in-print' style='display:none'>Received</td></tr></thead>";
                       
                    }  

                    else if(result.last_payment !="" && result.over_limit =="")
                    {
                          report_table +="<thead><tr><td>S.No</td><td>Customer Name</td><td>Mobile</td><td>LP</td><td>LP Date</td><td>Balance</td><td class='show-in-print' style='display:none'>Received</td></tr></thead>";
                       
                    }
                    else if(result.over_limit !="" && result.last_payment =="")
                    {
                         report_table +="<thead><tr><td>S.No</td><td>Customer Name</td><td>Mobile</td><td class='not-show-in-print'>Over Limit</td><td>LP</td><td>LP Date</td><td>Balance</td><td class='show-in-print' style='display:none'>Received</td></tr></thead>";
                     }
                    else{
                       report_table +="<thead class='acc_rec'><tr><td>S.No</td><td>Customer Name</td><td>Mobile</td><td>Balance</td><td class='show-in-print' style='display:none'>Received</td></tr></thead>"; 
                    }
                    

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){

                                      if(result.over_limit =='true')
                                      {
                                        var extClass=result.records[r].class;
                                      }
                                    report_table += "<tr><td class='show-border' style='width:3%'>"+result.records[r].sno+"</td>";
                                    report_table += "<td class='show-border "+extClass+"' style='width:33%;'><div class='prod_name'>"+result.records[r].cust_name+"</div></td>";
                                    // report_table += "<td class='show-border "+extClass+"' style='width:40%;margin-right:20px;'><div class='prod_name'>"+result.records[r].cust_name.split(/\s+/).slice(0,7).join(' ')+"</div></td>";
                                    report_table += "<td class='show-border' style='width:15%;'>"+result.records[r].cust_mobile+"</td>";
                                    if(result.over_limit !="" && result.last_payment !="")
                                    {
                                        report_table += "<td class='not-show-in-print' style='width:10%;"+result.records[r].color+"'>"+result.records[r].cust_limit+"</td>";
                                        report_table += "<td class='show-border show-in-print' style='width:10%'>"+result.records[r].last_payment+"</td>";
                                        report_table += "<td class='show-border show-in-print' style='width:10%'>"+result.records[r].last_date+"</td>";
                                    }
                                    if(result.over_limit !="" && result.last_payment =="")
                                    {
                                        report_table += "<td class='not-show-in-print' style='width:10%;"+result.records[r].color+"'>"+result.records[r].cust_limit+"</td>";
                                        report_table += "<td class='not-show-in-print' style='width:10%'></td>";
                                        report_table += "<td class='not-show-in-print' style='width:10%'></td>";
                                    }
                                      else if(result.last_payment !="" && result.over_limit =="")
                                    {
                                        report_table += "<td class='show-border' style='width:10%'>"+result.records[r].last_payment+"</td>";                                                                
                                        report_table += "<td class='show-border' style='width:10%'>"+result.records[r].last_date+"</td>";
                                    }

                                                                                                       
                                    report_table += "<td class='show-border ' style='width:10%'>"+result.records[r].amount+"</td>";                                                                
                                    report_table += "<td class='show-border show-in-print' style='display:none;width:10%'>&nbsp;</td>";                                                                
                                    report_table += "<td class='not-show-in-print show-border'  style='display:none; width:10%'>&nbsp;</td>";                                                                
                                    report_table += "<td class='not-show-in-print show-border'  style='display:none; width:10%'>&nbsp;</td></tr>";                                                                
                                }
                                else if(result.records[r].is_type=="category"){
                                    if(result.over_limit =="true" && result.last_payment =="")
                                    {
                                    report_table += "<tr><td colspan='7'  class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                    }
                                     else if(result.over_limit =="true" && result.last_payment =="true")
                                    {
                                    report_table += "<tr><td colspan='7'  class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                    }
                                    else if(result.over_limit !="true" && result.last_payment =="true"){
                                         report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                    }
                                    else{
                                         report_table += "<tr><td colspan='4'  class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                    }
                                }
                                else if(result.records[r].is_type=="cat_total"){
                                     if(result.over_limit =="true" && result.last_payment =="true")
                                    {
                                    report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td><td class='cat_total not-show-in-print'></td><td class='cat_total not-show-in-print'></td><td class='cat_total not-show-in-print'></td>";
                                    
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>";
                                    report_table += "<td class='cat_total show-in-print' style='display:none;width:10%'>&nbsp;</td>";

                                }
                                  else if(result.over_limit =="true" && result.last_payment !="true")
                                    {
                                    report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td><td class='cat_total not-show-in-print'></td><td class='cat_total not-show-in-print'></td><td class='cat_total not-show-in-print'></td>";
                                    
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>";
                                    report_table += "<td class='cat_total show-in-print' style='display:none;width:10%'>&nbsp;</td>";
                                }
                                else if(result.last_payment=="true" && result.over_limit !="true")
                                {
                                       report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td><td class='cat_total not-show-in-print'></td></td><td class='cat_total not-show-in-print'></td>";
                                    
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>";
                                      report_table +="<td class='not-show-in-print cat_total'  style='display:none'>&nbsp;</td>";
                                }
                                else{
                                     report_table += "<tr><td class='cat_total' colspan='2'><div>"+result.records[r].cat_total+"</div></td><td class='cat_total '>";
                                    
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_amount+"</td>";

                                }   
                            
                                  
                                    report_table +="<td  class='not-show-in-print cat_total'  style='display:none'>&nbsp;</td></tr>";
                                    

                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";                                                      
                                   if(result.last_payment=="true" && result.over_limit=="true")
                                   {
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='show-in-print grand_total'  style='display:none'>-----</td>";
                                    report_table +="<td class='show-in-print grand_total'  style='display:none'>-----</td>";
                                   }
                                     else if(result.last_payment=="true" && result.over_limit!="true")
                                   {
                                     report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='show-in-print grand_total'  style='display:none'>-----</td>";
                                    report_table +="<td class='show-in-print grand_total'  style='display:none'>-----</td>";
                                   }
                                    
                                    else if(result.over_limit =="true" && result.last_payment!="true")
                                    {
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    report_table +="<td class='show-in-print grand_total' style='display:none'>-----</td>";
                                    report_table +="<td class='show-in-print grand_total' style='display:none'>-----</td>";
                                    }
                                    else{
                                    report_table +="<td class='grand_total not-show-in-print'>&nbsp;</td>";
                                    }
                                   
                                    report_table +="<td class='show-in-print grand_total'  style='display:none'>-----</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_amount+"</td>";
                                    
                                  
                                    report_table += "<td class='show-in-print grand_total'  style='display:none'>-----</td></tr>";                                
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='8'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==43){
            $.post("<?php echo $get_url_account_payable_detail; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Serial#</td><td>Vendor Id</td><td>Vendor Name</td><td>Balance</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td>"+result.records[r].sno+"</td>";
                                     report_table += "<td>"+result.records[r].vendor_id+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].vendor_name+"</div></td>";                                    
                                    report_table += "<td>"+result.records[r].amount+"</td></tr>";                                                                
                                    
                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";                                    
                                    report_table +="<td class='grand_total'>&nbsp;</td>";                                                                        
                                    report_table +="<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==34){
            $.post("<?php echo $get_url_get_ownership_detail; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:&nbsp;<span class='date'>"+getDate(_date)+"</span>");                                        
                    //$("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    
                    if(result.records){ 
                        var report_table = "<table class='report_table'>";
                        report_table +="<thead><tr><td>No#</td><td>Type</td><td>Customer/Vendor Name</td><td>Total</td><td>Dated</td></tr></thead>";
                        report_table += "<tbody>";                            
                        for(var r=0;r<result.records.length;r++){                            
                            report_table += "<tr><td>"+result.records[r].invoice_id+"</td>";
                            report_table += "<td>"+result.records[r].is_type+"</td>";
                            report_table += "<td><div class='prod_name'>"+result.records[r].cust_name+"</div></td>";
                            report_table += "<td>"+result.records[r].invoice_total+"</td>";                                    
                            report_table += "<td>"+result.records[r].invoice_date+"</td></tr>";                                                                                                                            
                        }
                       report_table +="</tbody></table>"; 
                    }
                    else{
                        report_table ="<table class='report_table'><tr><td class='noresult' >No Record Found</td></tr></table>";
                    }
                    
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        } 
        else if(params.report_id==45){
            $.post("<?php echo $get_url_cashregister; ?>", $("#report_form").serialize(),
            function(data) {            
                    var result = jQuery.parseJSON(data); 
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                
                var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='5%'>S#</td><td width='10%'>Date</td><td width='30%'>Customer</td><td width='10%'>Balance</td><td width='10%'>Amount Paid</td><td width='10%'>Sale Rep</td><td width='15%'>Remaining Balance</td><td width='10%'>Collection %</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="entry"){
                                report_table += "<tr><td>"+result.records[r].sno+"</td>";
                                report_table += "<td style='font-size:9px'>"+result.records[r].date+"</td>";
                                report_table += "<td><div style='font-size:11px'>"+result.records[r].custName+"</div></td>";
                                report_table += "<td style='font-size:11px'>"+result.records[r].balance+"</td>";
                                report_table += "<td style='font-size:11px'>"+result.records[r].paid+"</td>";                                
                                report_table += "<td style='font-size:9px'>"+result.records[r].saleRep+"</td>";                                
                                report_table += "<td style='font-size:11px'>"+result.records[r].r_balance+"</td>";
                                report_table += "<td style='font-size:11px'>"+result.records[r].c_percent+' %'+"</td></tr>";
                            }
                            else if(result.records[r].is_type=="category"){
                                report_table += "<tr><td colspan='8' class='cat_name'><div>"+result.records[r].group_name+"</div></td></tr>";
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='3'><div>"+result.records[r].cat_total+"</div></td>";                                
                                report_table +="<td class='cat_total'>"+result.records[r].category_total+"</td>"                                
                                report_table +="<td class='cat_total'>"+result.records[r].cat_paid+"</td>"                                
                                report_table +="<td class='cat_total'></td>"                                
                                report_table +="<td class='cat_total'>"+result.records[r].cat_balance+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].cat_percent+' %'+"</td></tr>"
                            }                            
                            else if(result.records[r].is_type=="total"){
                                report_table += "<tr><td class='grand_total' colspan='3'><div>"+result.records[r].grand_total+"</div></td>";                                                                                                                             
                                report_table +="<td class='grand_total'>"+result.records[r].total_balance+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_paid+"</td>"
                                report_table +="<td class='grand_total'></td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_rbalance+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_percent+' %'+"</td></tr>"
                            }
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='8'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                   top.reports_obj.reportReady();
            });
        }
        else if(params.report_id==46){
            $.post("<?php echo $get_url_incomestatment; ?>", $("#report_form").serialize(),
            function(data) {            
                    var result = jQuery.parseJSON(data); 
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                
                var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Description</td><td>Total Sale Amount</td><td>Discount</td><td>Sale Amount</td><td>Purchase Amount</td><td>Revenue</td><td>P/L %</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="income_sale"){
                                report_table += "<tr style='color:#4991D8;'><td><b>"+result.records[r].description+"</b></td>";
                                report_table += "<td>"+result.records[r].total_sale_amount+"</td>";
                                report_table += "<td>"+result.records[r].discount+"</td>";
                                report_table += "<td>"+result.records[r].sale_amount+"</td>";                                
                                report_table += "<td>"+result.records[r].purchase_amount+"</td>";
                                report_table += "<td>"+result.records[r].margin_amount+"</td>";                                
                                report_table += "<td>"+result.records[r].Profit_lost_per+" %</td></tr>"
                            } else if(result.records[r].is_type=="income_sale_return"){
                                report_table += "<tr style='color:#4991D8;'><td><b>"+result.records[r].description+"</b></td>";
                                report_table += "<td>"+result.records[r].total_sale_return_amount+"</td>";
                                report_table += "<td>"+result.records[r].discount_return+"</td>";
                                report_table += "<td>"+result.records[r].sale_return_amount+"</td>";                                
                                report_table += "<td>"+result.records[r].purchase_return_amount+"</td>";
                                report_table += "<td>"+result.records[r].margin_return_amount+"</td>";                                
                                report_table += "<td></td></tr>"
                            } else if(result.records[r].is_type=="income_net_sale"){
                                report_table += "<tr style='color:#4991D8; background-color:#ECECEC;'><td><b>"+result.records[r].description+"</b></td>";
                                report_table += "<td>"+result.records[r].total_sale_net_amount+"</td>";
                                report_table += "<td>"+result.records[r].discount_net+"</td>";
                                report_table += "<td>"+result.records[r].sale_net_amount+"</td>";                                
                                report_table += "<td>"+result.records[r].purchase_net_amount+"</td>";
                                report_table += "<td>"+result.records[r].margin_net_amount+"</td>";                                
                                report_table += "<td>"+result.records[r].net_per+" %</td></tr>"
                            }  else if(result.records[r].is_type=="expense"){
                                report_table += "<tr><td><i>"+result.records[r].title+"</i></td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";                                
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>"+result.records[r].amount+"</td>";                                
                                report_table += "<td>&nbsp;</td></tr>"
                            } else if(result.records[r].is_type=="total_income"){
                                report_table += "<tr style='background-color:#FFA72B; font-size:16px;'><td><b>"+result.records[r].title+"</b></td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";                                
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>"+result.records[r].amount+"</td>";                                
                                report_table += "<td>"+result.records[r].total_per+" % </td></tr>"
                            }
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                   top.reports_obj.reportReady();
            });
        }
        else if(params.report_id==47){
            $.post("<?php echo $get_url_expensereport; ?>", $("#report_form").serialize(),
            function(data) {            
                    var result = jQuery.parseJSON(data); 
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                
                var report_table = "<table class='report_table'>";
                if(result.print_category_report==0){
                    report_table +="<thead><tr><td style='width:15%'>S.No</td><td style='width:15%'>Account Title</td><td style='width:20%'>Date</td><td style='width:20%'>Description</td><td style='width:20%'>Account Type</td><td style='width:10%'>Amount</td></tr></thead>";
                } else {
                    report_table +="<thead><tr><td>Account Name</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Amount</td></tr></thead>";
                }
                    report_table += "<tbody>";
                    if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type==="expense"){
                                report_table += "<tr><td><b>"+result.records[r].sno+"</b></td>";
                                report_table += "<td>"+result.records[r].account_title+"</td>";
                                report_table += "<td>"+result.records[r].account_date+"</td>";
                                report_table += "<td>"+result.records[r].account_des+"</td>";
                                report_table += "<td>"+result.records[r].account_type+"</td>";
                                report_table += "<td>"+result.records[r].account_amount+"</td></tr>"
                            }
                            else if(result.records[r].is_type==="account_name"){
                                report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].acc_name+"</div></td></tr>";
                            } else if(result.records[r].is_type==="total_expenses"){
                                report_table += "<tr style='color:#4991D8;'><td><b>"+result.records[r].title+"</b></td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td><b>"+result.records[r].amount+"</b></td>";
                            } else if(result.records[r].is_type==="net_total_expenses"){
                                report_table += "<tr style='color:#FFFFFF; background:#FFA72B; font-size:18px'><td><b>"+result.records[r].title+"</b></td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td>&nbsp;</td>";
                                report_table += "<td><b>"+result.records[r].amount+"</b></td>";
                            }
                            
                             
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));
                   top.reports_obj.reportReady();
            });
        }
        else if(params.report_id==48){
            $.post("<?php echo $get_url_loan_pay_reciev_detail; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Serial#</td><td>Account Name</td><td>Balance</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="loan"){
                                    report_table += "<tr><td>"+result.records[r].sno+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].account_title+"</div></td>";                                    
                                    report_table += "<td>"+result.records[r].account_amount+"</td></tr>";                                                                
                                    
                                }
                                else if(result.records[r].is_type=="total_loan"){                                
                                    report_table += "<tr><td class='grand_total'>"+result.records[r].title+"</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";                                                                        
                                    report_table +="<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='3'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==21){
            $.post("<?php echo $get_url_vendor_transaction_summary; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Vendor Name</td><td>Opening Balance</td><td>Quantity</td><td>Charged</td><td>Total</td><td>Paid</td><td>Remaining</td></tr></thead>";
                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td>"+result.records[r].sno+"</td>";
                                    //report_table += "<td>"+result.records[r].vendor_id+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].vendor_name+"</div></td>";                                    
                                    report_table += "<td>"+result.records[r].opening_balance+"</td>";
                                    report_table += "<td>"+result.records[r].quantity+"</td>";
                                    report_table += "<td>"+result.records[r].amount_credit+"</td>";
                                    report_table += "<td>"+result.records[r].total+"</td>";
                                    report_table += "<td>"+result.records[r].amount_debit+"</td>";
                                    report_table += "<td>"+result.records[r].balance+"</td></tr>";
                                    
                                }
                                else if(result.records[r].is_type=="unknown"){                                
                                    report_table += "<tr><td>&nbsp;</td>";
                                    report_table +="<td>&nbsp;</td>";
                                    //report_table += "<td>"+result.records[r].vendor_id+"</td>";
                                    report_table += "<td><div class='prod_name exp_row'>"+result.records[r].text+"</div></td>";                                    
                                    report_table += "<td class='exp_row'>"+result.records[r].unknown_credit+"</td>";
                                    report_table +="<td>&nbsp;</td>";
                                    report_table += "<td class='exp_row'>"+result.records[r].unknown_debit+"</td>";
                                    report_table += "<td class='exp_row'>"+result.records[r].unknown_balance+"</td></tr>";
                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_opening_balance+"</td>";
                                    report_table +="<td class='grand_total'></td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_amount_credit+"</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_total+"</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_amount_debit+"</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_amount_balance+"</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==22){
            $.post("<?php echo $get_url_vendor; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Vendor Name</td><td>Mobile</td><td>Phone</td></tr></thead>";
                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="vendor"){
                                    report_table += "<tr><td>"+result.records[r].sno+"</td>";
                                    //report_table += "<td>"+result.records[r].vendor_id+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].vendor_name+"</div></td>";                                    
                                    report_table += "<td>"+result.records[r].vendor_mobile+"</td>";
                                    report_table += "<td>"+result.records[r].vendor_phone+"</td>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==23){
            $.post("<?php echo $get_url_vendor_payment_summary; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table' border='1' cellpadding='1'>";
                    report_table +="<thead><tr><td>S#</td><td>Vendor Name</td><td>Pay Method</td><td>Date</td><td>Amount</td><td>Remarks</td></tr></thead>";
                    report_table += "<tbody class='Vendorpayment_report'>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td style='width:5%;'>"+result.records[r].sno+"</td>";
                                    report_table += "<td style='width:30%;'><div class='prod_name'>"+result.records[r].vendor_name+"</div></td>";                                    
                                    report_table += "<td style='width:10%;'>"+result.records[r].pay_method+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].pay_date+"</td>";
                                    report_table += "<td style='width:10%;'>"+result.records[r].pay_amount+"</td>";
                                    report_table += "<td style='width:30%;'>"+result.records[r].des+"</td></tr>";
                                    
                                }
                                else if(result.records[r].is_type=="vendor_total"){                                
                                    report_table += "<tr><td class='cat_total' colspan='3'>"+result.records[r].text+"</td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table += "<td class='cat_total'>"+result.records[r].vendor_total_pay_amount+"</td>";
                                    report_table += "<td class='cat_total'>&nbsp;</td></tr>";
                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";;
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].total_pay_amount+"</td>";
                                    report_table += "<td class='grand_total'>&nbsp;</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==24){
            $.post("<?php echo $get_url_purchase_order_summary; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    if(result.show_invoice_detail==0){
                        report_table +="<thead><tr><td>S#</td><td>Date</td><td>Vendor Name</td><td>PO #</td><td>Amount</td><td>Qty</td></tr></thead>";
                    } else {
                        report_table +="<thead><tr><td>Date</td><td>Vendor Name</td><td>Item Name</td><td>Barocde</td><td>PO #</td><td>P Price</td><td>Sale Price</td><td>Qty</td><td>Sub Total</td></tr></thead>";
                    }
                    report_table += "<tbody>";
                    if(result.show_invoice_detail==0){
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td style='width:5%;'>"+result.records[r].sno+"</td>";
                                    report_table += "<td style='width:20%;'><div class='prod_name'>"+result.records[r].po_date+"</div></td>";                                    
                                    report_table += "<td style='width:45%;'>"+result.records[r].po_vend_name+"</td>";
                                    report_table += "<td style='width:10%;'>"+result.records[r].po_no+"</td>";
                                    report_table += "<td style='width:10%;'>"+result.records[r].po_amount+"</td>";
                                    report_table += "<td style='width:10%;'>"+result.records[r].po_qty+"</td></tr>";
                                    
                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";;
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].all_vend_total_po_amount+"</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].all_vend_total_po_qty+"</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='4'>No Record Found</td></tr>";
                    } 
                    } else {
                       if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            
                              if(result.records[r].is_type=="purchase_invoice_detail"){
                                report_table += "<tr><td>"+result.records[r].date+"</td>";
                                report_table += "<td><div class='prod_name'>"+result.records[r].vendor_name+"</div></td>";
                                report_table += "<td>"+result.records[r].item_name+"</td>";
                                report_table += "<td>"+result.records[r].barcode+"</td>";
                                report_table += "<td>"+result.records[r].invoice_no+"</td>";
                                report_table += "<td>"+result.records[r].purchase_price+"</td>";
                                report_table += "<td>"+result.records[r].sale_price+"</td>";
                                report_table += "<td>"+result.records[r].quantity+"</td>";
                                report_table += "<td>"+result.records[r].sub_total+"</td></tr>";
                            }
                            else if(result.records[r].is_type=="inv_sub_total"){                                
                                    report_table += "<tr><td class='cat_total' colspan='7'>Invoce Total</td>";
                                    report_table += "<td class='cat_total'>"+result.records[r].inv_total_qty+"</td>";
                                    report_table += "<td class='cat_total'>"+result.records[r].inv_sub_total+"</td></tr>";
                                }
                            else if(result.records[r].is_type=="total"){
                                report_table += "<tr><td class='net_income' colspan='7'><div>Total</div></td>";
                                report_table +="<td class='net_income'>"+result.records[r].total_qty+"</td>";
                                report_table +="<td class='net_income'>"+result.records[r].total+"</td>"
                            }
                         }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='9'>No Record Found</td></tr>";
                    } 
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==25){
            $.post("<?php echo $get_url_vendor_wise_sale_report; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    if(result.show_invoice_detail==0){
                        report_table +="<thead><tr><td colspan='2'>Vendor Name</td><td>Sold Qty</td><td>Sale Amount</td><td>Cost Amount</td><td>Margin</td><td>Percentage</td></tr></thead>";
                    } else {
                        report_table +="<thead><tr><td>Item Name</td><td>Barcode</td><td>Sold Quantity</td><td>Amount</td><td>Cost</td><td>Margin</td><td>Percentage</td></tr></thead>";
                    }
                    
                        report_table += "<tbody>";
                        if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    if(result.show_invoice_detail==1){
                                    report_table += "<tr><td style='width:30%; font-weight:bold;'>"+result.records[r].item_name+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].barcode+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].sold_qty+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].amount+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].cost+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].margin+"</td>";
                                    report_table += "<td style='width:10%;'>"+result.records[r].per+"</td></tr>";
                                }
                                }
                                else if(result.records[r].is_type=="vand_total"){                                
                                    report_table += "<tr><td class='grand_total' colspan='2'>"+result.records[r].vendor_name+"</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].vand_total_sold_qty+"</td>";;
                                    report_table +="<td class='grand_total'>"+result.records[r].vand_total_amount+"</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].vand_total_cost+"</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].vand_total_margin+"</td>";
                                    report_table += "<td class='grand_total'>"+(((result.records[r].vand_total_amount - result.records[r].vand_total_cost)/result.records[r].vand_total_amount)*100).toFixed(4)+"</td></tr>";
                                    
                                }
                                
                                else if(result.records[r].is_type=="vand_grand_total"){                                
                                    report_table += "<tr><td class='grand_total' style='background-color:green !important;'>&nbsp;</td>";
                                    report_table += "<td class='grand_total' style='background-color:green !important;'>&nbsp;</td>";
                                    report_table +="<td class='grand_total' style='background-color:green !important; color:white;'>"+result.records[r].vand_grand_total_sold_qty+"</td>";;
                                    report_table +="<td class='grand_total' style='background-color:green !important; color:white;'>"+result.records[r].vand_grand_total_amount+"</td>";
                                    report_table += "<td class='grand_total' style='background-color:green !important; color:white;'>"+result.records[r].vand_grand_total_cost+"</td>";
                                    report_table += "<td class='grand_total' style='background-color:green !important; color:white;'>"+result.records[r].vand_grand_total_margin+"</td>";
                                    report_table += "<td class='grand_total' style='background-color:green !important; color:white;'>"+(((result.records[r].vand_grand_total_amount - result.records[r].vand_grand_total_cost)/result.records[r].vand_grand_total_amount)*100).toFixed(4)+"</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    } 
                    
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==26){
            $.post("<?php echo $get_url_vendor_register; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");
                    $("#div_start_date").html("Start Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Date</td><td>Transaction Type</td><td>Num</td><td>Location</td><td>Bill Qty</td><td>Bill Amount</td><td>Paid</td><td>Total</td></tr></thead>";
                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td style='width:10%; font-weight:bold;'>"+result.records[r].date+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].po_no+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].vendor+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].account+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].description+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].billed+"</td>";
                                    report_table += "<td style='width:15%;'>"+result.records[r].paid+"</td>";
                                    report_table += "<td style='width:10%;'>"+result.records[r].balance+"</td></tr>";
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='8'>No Record Found</td></tr>";
                    } 
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==8){
            $.post("<?php echo $get_url_cust_transaction_summary; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>");                                        
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>S#</td><td>Customer Name</td><td>Opening Balance</td><td class='not-show-in-print'>Customer Type</td><td>Debit</td><td>Credit</td><td >Balance</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="entry"){
                                    report_table += "<tr><td>"+result.records[r].sno+"</td>";                                     
                                    report_table += "<td><div class='prod_name'>"+result.records[r].cust_name+"</div></td>";
                                    report_table += "<td>"+result.records[r].opening_balance+"</td>"; 
                                    report_table += "<td>"+result.records[r].cust_type+"</td>";                                    
                                    report_table += "<td>"+result.records[r].amount_debit+"</td>";                                                                
                                    report_table += "<td>"+result.records[r].amount_credit+"</td>";                                                                
                                    report_table += "<td>"+result.records[r].amount_balance+"</td></tr>";                                                                
                                }
                                else if(result.records[r].is_type=="category"){
                                    report_table += "<tr><td colspan='7' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                }
                                else if(result.records[r].is_type=="cat_total"){
                                    report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";                                                                                                          
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>&nbsp;</td>";
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_amount_debit+"</td>"
                                    report_table +="<td class='cat_total'>"+result.records[r].cat_amount_credit+"</td>";
                                    report_table +="<td  class='cat_total'>"+result.records[r].cat_amount_balance+"</td></tr>";                                    
                                }
                                else if(result.records[r].is_type=="unknown"){                                
                                    report_table += "<tr><td>&nbsp;</td>";                                    
                                    report_table += "<td><div class='prod_name exp_row'>"+result.records[r].cust_name+"</div></td>";
                                    report_table +="<td>&nbsp;</td>";
                                    report_table += "<td class='exp_row'>"+result.records[r].cust_type+"</td>";
                                    report_table += "<td class='exp_row'>"+result.records[r].amount_debit+"</td>";
                                    report_table += "<td class='exp_row'>"+result.records[r].amount_credit+"</td>";
                                    report_table += "<td class='exp_row'>"+result.records[r].amount_balance+"</td></tr>";
                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";                                    
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>&nbsp;</td>";
                                    report_table +="<td class='grand_total'>"+result.records[r].total_debit+"</td>";
                                    report_table +="<td class='grand_total' >"+result.records[r].total_credit+"</td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].total_balance+"</td></tr>";                                
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='7'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }
        else if(params.report_id==55){
            $.post("<?php echo $get_url_amount_recieved_expense_saleRep; ?>", $("#report_form").serialize(),
                function(data) {  
                var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Serial#</td><td>Sale Rep Name</td><td>Amount Recieved</td><td>Expense</td><td>Balance</td></tr></thead>";

                    report_table += "<tbody>";
                    if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="amount"){
                                    report_table += "<tr><td>"+result.records[r].sno+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].salRepName+"</div></td>";
                                    report_table += "<td>"+result.records[r].recieve_amount+"</td>";
                                    report_table += "<td>"+result.records[r].expense_amount+"</td>";
                                    report_table += "<td>"+result.records[r].remaining_amount+"</td></tr>";                                                                
                                    
                                }
                                else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total sale_return_row'>"+result.records[r].title+"</td>";
                                    report_table += "<td class='grand_total sale_return_row'></td>";
                                    report_table += "<td class='grand_total sale_return_row'>"+result.records[r].total_recieve_amount+"</td>";
                                    report_table += "<td class='grand_total sale_return_row'>"+result.records[r].total_expense_amount+"</td>";
                                    report_table += "<td class='grand_total sale_return_row'>"+result.records[r].total_remaining_amount+"</td></tr>"; 
                                    
                                }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
              }); 
        }

        else if(params.report_id==80){
            $.post("<?php echo $get_url_cust_anging_report; ?>", $("#report_form").serialize(),
                function(data) {  
                     var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td >Date</td><td >Transaction</td><td >Debit</td><td >Credit</td><td /td><td >Balance</td></tr></thead>";
                     report_table += "<tbody class='aging_report'>";
                            if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                                     if(result.records[r].is_type=="customer") {
                                          report_table += "<tr >";
                                   
                                    report_table += "<td  class='cust_name' colspan='6'>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].payee+"</div></td>";
                                   
                                    report_table += "</tr>";
                                     }    
                                     if(result.records[r].is_type=="previous") {
                                    report_table += "<tr ><td class='"+result.records[r].class+"'>"+result.records[r].date+"</td>";
                                   
                                    report_table += "<td style='font-weight:bold' class='"+result.records[r].class+"'>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].detail+"</div></td>";
                                   
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].increase+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].decrease+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'></td>";
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].balance+"</td></tr>";
                                      }
                                        if(result.records[r].is_type=="invoice") {
                                    report_table += "<tr class='"+result.records[r].class+"'><td >"+result.records[r].date+"</td>";
                                   
                                    report_table += "<td style='font-weight:bold'>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].detail+"</div></td>";
                                   
                                    report_table += "<td >"+result.records[r].increase+"</td>";
                                    report_table += "<td >"+result.records[r].decrease+"</td>";
                                    report_table += "<td ></td>";
                                    report_table += "<td >"+result.records[r].balance+"</td></tr>";
                                      } 

                                         if(result.records[r].is_type=="items") {
                                    report_table += "<tr class='items' style='height:10px'><td >"+result.records[r].date+"</td>";
                                   
                                    report_table += "<td style='font-size:10px;padding:0px;padding-left:3px;'>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].detail+"</div></td>";
                                   
                                    report_table += "<td>"+result.records[r].increase+"</td>";
                                    report_table += "<td>"+result.records[r].decrease+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'></td>";
                                    report_table += "<td>"+result.records[r].balance+"</td></tr>";
                                      }  
                                   
                                    
                            
                            
                        }
                    }
                    report_table +="</tbody><tfoot><tr> <td colspan='5' style='border-top:1px solid #C7C7C7'></td> </tr>";
                       if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                    if(result.records[r].is_type=="statement") {

                   report_table+= "<tr class='aging_detail head'><td>Current</td><td>1-30 DAYS PAST DUE</td><td>31-60 DAYS PAST DUE</td><td>61-90 DAYS PAST DUE</td><td>OVER 90 DAYS PAST DUE</td><td>Amount Due</td></tr><tr class='aging_detail summary'><td>"+result.records[r].current+"</td><td>"+result.records[r].thirtydays+"</td><td>"+result.records[r].sixtydays+"</td><td>"+result.records[r].nintydays+"</td><td>"+result.records[r].overninty+"</td><td>"+result.records[r].amountDue+"</td></tr>";
                    }
                }
            }
                   report_table+= "</tfoot></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
                });
            }
  else if(params.report_id==81){
            $.post("<?php echo $get_url_vendor_anging_report; ?>", $("#report_form").serialize(),
                function(data) {  
                     var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='10%'>Date</td><td>Transaction</td><td>Debit</td><td>Credit</td><td>Balance</tr></thead>";
                     report_table += "<tbody class='aging_report'>";
                     if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                                     if(result.records[r].is_type=="vendor") {
                                          report_table += "<tr >";
                                   
                                    report_table += "<td  class='cust_name' colspan='5'>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].payee+"</div></td>";
                                   
                                    report_table += "</tr>";
                                     }
                                   if(result.records[r].is_type=="previous") {
                                    report_table += "<tr ><td class='"+result.records[r].class+"'>"+result.records[r].date+"</td>";
                                   
                                    report_table += "<td style='font-weight:bold' class='"+result.records[r].class+"'>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].detail+"</div></td>";
                                   
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].increase+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].decrease+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].balance+"</td></tr>";
                                      }
                                      
                                     if(result.records[r].is_type=="invoice") {
                                    report_table += "<tr ><td class='"+result.records[r].class+"'>"+result.records[r].date+"</td>";
                                   
                                    report_table += "<td style='font-weight:bold' class=''>";
                                    // if(result.records[r].is_type=="items"){
                                    report_table += "<div>"+result.records[r].detail+"</div></td>";
                                   
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].increase+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].decrease+"</td>";
                                    report_table += "<td class='"+result.records[r].class+"'>"+result.records[r].balance+"</td></tr>";
                                      }       

                                     }
                                     }   
                
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
                });
            }

         else if(params.report_id==75){
            $.post("<?php echo $get_url_item_list; ?>", $("#report_form").serialize(),
                function(data) {  
                     var result = jQuery.parseJSON(data);    
                    $("#report_name").html(result.report_name);
                    
                    var _date = new Date();
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                    var report_table = "<table class='report_table'>";
                    if(result.show_price =="true")
                    {
                    report_table +="<thead><tr><td width='10%'>S.#</td><td>Item Name</td><td>Category</td><td>Sale Price</td></tr></thead>";
                  }
                  else{
                   report_table +="<thead><tr><td width='10%'>S.#</td><td>Item Name</td><td>Category</td><td> Unit 1</td><td> Unit 2</td><td> Unit 3</td><td> Unit 4</td></tr></thead>"; 
                  }
                    var item_count = 1;
                     report_table += "<tbody>";
                      if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="product"){
                                    report_table += "<tr><td>"+item_count+"</td>";
                                    // report_table += "<td><div class='prod_name'>"+result.records[r].product_name+"</div></td>";
                                      report_table += "<td style='cursor: pointer; cursor: hand;'><div class='popover__wrapper'><a href='#' id='buttonId'>"+result.records[r].product_name+"</a><div class='popover__content'><table class='infotable'> <tbody><tr><td>Purchase Price</td><td style='font-weight:bold;color:blue'>"+result.records[r].purchase_price+"</td><tr><tr><td>Avg Cost</td><td style='font-weight:bold;color:blue'>"+result.records[r].avg_cost+"</td></tr></tbody> </table></div></div></td>";
                                    report_table += "<td>"+result.records[r].category+"</td>";
                                    if(result.show_price =="true")
                                    {
                                    // report_table += "<td>"+result.records[r].purchase_price+"</td>";
                                    // report_table += "<td>"+result.records[r].avg_cost+"</td>"; 
                                    report_table += "<td>"+result.records[r].sale_price+"</td></tr>";
                                    } else {
                                    report_table += "<td>"+result.records[r].unit0_price+"</td>";
                                    report_table += "<td>"+result.records[r].unit1_price+"</td>";
                                    report_table += "<td>"+result.records[r].unit2_price+"</td>";
                                    report_table += "<td>"+result.records[r].unit3_price+"</td></tr>";
                                    }
                                    
                                    
                                     item_count = item_count + 1;
                                }

                          else if(result.records[r].is_type=="warehouse"){
                                if(result.show_price=="true")
                                {
                                report_table += "<tr class='ware_name'><td colspan='6' >"+result.records[r].warehouse_name+"</td></tr>";
                                }
                                else{
                                report_table += "<tr class='ware_name'><td colspan='7' >"+result.records[r].warehouse_name+"</td></tr>";

                                }
                            }       
                         else if(result.records[r].is_type=="category"){
                          if(result.show_price=="true")
                                {
                            report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                          }
                          else{
                           report_table += "<tr><td colspan='7' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>"; 
                          }
                        }
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }
                    report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));      
                    top.reports_obj.reportReady();
                });
            }

            else if(params.report_id==90){
                 $.post("<?php echo $getAssetAccountRecord; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                    var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                      var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='10%'>S.#</td><td>Asset Name</td><td>Amount</td><td>Date</td></tr></thead>";
                      var item_count = 1;
                       report_table += "<tbody>";
                         if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="product"){
                                    report_table += "<tr><td>"+item_count+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].asset_name+"</div></td>";
                                    report_table += "<td>"+result.records[r].amount+"</td>";
                                    report_table += "<td>"+result.records[r].date+"</td></tr>";
                                     item_count = item_count + 1;
                                }
                         else if(result.records[r].is_type=="category"){
                            report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].account_name+"</div></td></tr>";
                        }
                         else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='2'><div>"+result.records[r].cat_name+"</div></td>";                                    
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total+"</td><td class='cat_total'></td></tr>";

                            }

                          else if(result.records[r].is_type=="total"){                                
                                    report_table += "<tr><td class='grand_total' colspan='2'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td><td class='grand_total'></td></tr>";                                
                                }    
                            }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }

                       report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));   
                    top.reports_obj.reportReady();
                     });
            }

             else if(params.report_id==91){
                       $.post("<?php echo $getPurchaseReport; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                    var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                       var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='10%'>S.#</td><td>Product Name</td><td>Quantities</td><td>Unit Price</td><td>Amount</td></tr></thead>";
                     var item_count = 1;
                       report_table += "<tbody>";
                             if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="product"){
                                    report_table += "<tr><td>"+item_count+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                    report_table += "<td>"+result.records[r].qty+"</td>";
                                    report_table += "<td>"+result.records[r].price+"</td>";
                                    report_table += "<td>"+result.records[r].amount+"</td></tr>";
                                     item_count = item_count + 1;
                                }
                         else if(result.records[r].is_type=="category"){
                            report_table += "<tr><td colspan='5' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                        }  else if(result.records[r].is_type=="vendor"){
                            report_table += "<tr><td colspan='5' class='ware_name'><div>"+result.records[r].vendor_name+"</div></td></tr>";
                        }  
                            else if(result.records[r].is_type=="vendor_total"){
                                report_table += "<tr><td class='ware_total' colspan='4'><div>"+result.records[r].vendor_name+"</div></td>"; report_table +="<td class='ware_total'>"+result.records[r].vendor_total+"</td></tr>";

                                 }
                        
                        else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='4'><div>"+result.records[r].cat_name+"</div></td>";                                    
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total+"</td></tr>";
                                         }

                       else if(result.records[r].is_type=="total"){                                
                            report_table += "<tr><td class='grand_total' colspan='4'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                            report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";                                
                        } 
                        }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }

                     report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();
                     });
             } 
               else if(params.report_id==98){
                       $.post("<?php echo $getPurchaseSummaryReport; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                    var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                       var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='10%'>S.#</td><td>Vendor Name</td><td>Order #</td><td>Date</td><td>Amount</td></tr></thead>";
                     var item_count = 1;
                       report_table += "<tbody>";
                   
                                 if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="bill"){
                                    report_table += "<tr><td>"+item_count+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].vendor_name+"</div></td>";
                                    report_table += "<td>Inv# "+result.records[r].orderNo+"</td>";
                                    report_table += "<td>"+result.records[r].date+"</td>";
                                    report_table += "<td>"+result.records[r].amount+"</td></tr>";
                                     item_count = item_count + 1;
                                }
                              }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }
                     report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();
                     });
             }

             else if(params.report_id==92){
                       $.post("<?php echo $getPurchaseReturnReport; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                    var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                       var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td width='10%'>S.#</td><td>Product Name</td><td>Return Qty</td><td>Purchase Price</td><td>Amount</td></tr></thead>";
                     var item_count = 1;
                       report_table += "<tbody>";
                             if(result.records){ 
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type){                                                            
                                if(result.records[r].is_type=="product"){
                                    report_table += "<tr><td>"+item_count+"</td>";
                                    report_table += "<td><div class='prod_name'>"+result.records[r].item_name+"</div></td>";
                                    report_table += "<td>"+result.records[r].qty+"</td>";
                                    report_table += "<td>"+result.records[r].price+"</td>";
                                    report_table += "<td>"+result.records[r].amount+"</td></tr>";
                                     item_count = item_count + 1;
                                }
                         else if(result.records[r].is_type=="category"){
                            report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                        }  else if(result.records[r].is_type=="vendor"){
                            report_table += "<tr><td colspan='6' class='ware_name'><div>"+result.records[r].vendor_name+"</div></td></tr>";
                        }  
                            else if(result.records[r].is_type=="vendor_total"){
                                report_table += "<tr><td class='ware_total' colspan='4'><div>"+result.records[r].vendor_name+"</div></td>"; report_table +="<td class='ware_total'>"+result.records[r].vendor_total+"</td></tr>";

                                 }
                        
                        else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total' colspan='4'><div>"+result.records[r].cat_name+"</div></td>";                                    
                                report_table +="<td class='cat_total'>"+result.records[r].cat_total+"</td></tr>";
                                         }

                       else if(result.records[r].is_type=="total"){                                
                            report_table += "<tr><td class='grand_total' colspan='4'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                            report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";                                
                        } 
                        }
                        }
                    }
                    else{
                        report_table +="<tr><td class='noresult' colspan='5'>No Record Found</td></tr>";
                    }

                     report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();
                     });
             }

         else if(params.report_id==13)
         {
               $.post("<?php echo $getSaleReturnReport; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                    var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);
                        var report_table = "<table class='report_table'>";
                    report_table +="<thead><tr><td>Product Name</td><td>Qty</td><td>Net Price </td><td>Deduction</td><td>Sub Total</td><td>Cost</td><td>Revenue Loss</td><td>Revenue Loss %</td></tr></thead>";
                                 report_table += "<tbody>";
                      if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="product"){
                                if(result.print_category_report!=1){
                                    report_table += "<tr><td><div class='prod_name'>"+result.records[r].product_name+"</div></td>";
                                    report_table += "<td>"+result.records[r].qty+"</td>";
                                    report_table += "<td>"+result.records[r].sale+"</td>";
                                    report_table += "<td>"+result.records[r].discount+"</td>";
                                    report_table += "<td>"+result.records[r].sales+"</td>";
                                    report_table += "<td>"+result.records[r].cost+"</td>";
                                    report_table += "<td>"+result.records[r].revenue+"</td>";
                                    report_table += "<td>"+result.records[r].revenue_percent +"%</td></tr>";
                                }
                            }
                            else if(result.records[r].is_type=="category"){
                                if(result.print_category_report!=1){
                                    report_table += "<tr><td colspan='8' class='cat_name'><div>"+result.records[r].category_name+"</div></td></tr>";
                                }
                            }
                            else if(result.records[r].is_type=="cat_total"){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].cat_total+"</div></td>";
                                report_table +="<td class='cat_total'>"+result.records[r].category_qty+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].category_sale+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].category_discount+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].category_sales+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].category_cost+"</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].category_revenue+"</td>"
                                report_table +="<td class='cat_total'></td></tr>"
                            }
                            else if(result.records[r].is_type=="total_discount"){
                                report_table += "<tr><td class='cat_total'><div>"+result.records[r].grand_total+"</div></td>";
                                report_table +="<td class='cat_total'>&nbsp;</td>"
                                report_table +="<td class='cat_total'>&nbsp;</td>"
                                report_table +="<td class='cat_total'>"+result.records[r].total_discount+"</td>"
                                report_table +="<td class='cat_total'></td>"
                                report_table +="<td class='cat_total'>("+result.records[r].sale_minus+")</td>"
                                report_table +="<td class='cat_total'>("+result.records[r].revenue_minus+")</td>"
                                report_table +="<td class='cat_total'>&nbsp;</td></tr>"
                            }
                            else if(result.records[r].is_type=="total"){
                                report_table += "<tr><td class='grand_total'><div>"+result.records[r].grand_total+"</div></td>";
                                report_table +="<td class='grand_total'>"+result.records[r].total_qty+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_sale+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_disc+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_sales+"</td>"
                                report_table +="<td class='grand_total'>"+result.records[r].total_cost+"</td>" 
                                report_table +="<td class='grand_total'>"+result.records[r].total_revenue+"</td>"
                                report_table +="<td class='grand_total'></td></tr>"
                            }
                            
                        }
                    }
                    else{
                         report_table +="<tr><td class='noresult' colspan='9'>No Record Found</td></tr>";
                    }  
                     report_table +="</tbody></table>";
                    $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();
                });
         }    

          else if(params.report_id==14)
         {
               $.post("<?php echo $getItemSaleDetail; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                      var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name); 
                    var report_table = "<table class='report_table'>";  
                      report_table +="<div ><thead ><tr><td>Inv No</td><td>Date</td><td>Customer Name</td><td>Qty</td><td>Amount</td><td>Balance</td></tr></thead>";
                                 report_table += "<tbody >";
                      if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="product"){
                                if(result.print_category_report!=1){
                                    report_table += "<tr><td><div class='prod_name'>"+result.records[r].invoice+"</div></td>";
                                    report_table += "<td>"+result.records[r].date+"</td>";
                                    report_table += "<td>"+result.records[r].customer+"</td>";
                                    report_table += "<td>"+result.records[r].qty+"</td>";
                                    report_table += "<td>"+result.records[r].price+"</td>";                                
                                    report_table += "<td>"+result.records[r].balance+"</td></tr>";
                                }
                            }   
                             else if(result.records[r].is_type=="item_name"){
                                if(result.print_category_report!=1){
                                    report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].product_name+"</div></td></tr>";
                                }
                            }
                            else if(result.records[r].is_type=="item_total"){
                                report_table += "<tr><td class='cat_total' colspan='5'><div>"+result.records[r].pamout_name+"</div></td>";                                    
                                report_table +="<td class='cat_total'>"+result.records[r].item_total+"</td></tr>";
                                         }

                       else if(result.records[r].is_type=="total"){                                
                            report_table += "<tr><td class='grand_total' colspan='5'><div class='prod_name'>"+result.records[r].total+"</div></td>";
                            report_table += "<td class='grand_total'>"+result.records[r].total_amount+"</td></tr>";                                
                        }
                        }
                    }

                             $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();

                      });

           }
 else if(params.report_id==104)
         {
               $.post("<?php echo $getSaleRepCollection; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                      var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);   
                     var report_table = "<table class='report_table'>";
                      report_table +="<thead><tr><td>Sr No</td><td>Customer Name</td><td>Amount</td><td>Date</td></tr></thead>";
                                 report_table += "<tbody>";
                                   var item_count = 1;
                      if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="cash_detail"){
                                    report_table += "<tr><td><div class='prod_name'>"+item_count+"</div></td>";
                                    report_table += "<td>"+result.records[r].customer+"</td>";
                                    report_table += "<td>"+result.records[r].amount+"</td>";
                                    report_table += "<td>"+result.records[r].date+"</td></tr>";
                                  item_count +=1;
                            }   
                             else if(result.records[r].is_type=="represntative"){
                                    report_table += "<tr><td colspan='4' class='cat_name'><div>"+result.records[r].represntative_name+"</div></td></tr>";
                                }
                                 else if(result.records[r].is_type=="rep_total"){
                                    report_table += "<tr><td class='ware_total'><div>"+result.records[r].cat_name+"</div></td>";
                                    report_table += "<td class='ware_total'></td>";
                                    report_table += "<td class='ware_total'>"+result.records[r].rep_totalamt+"</td>";
                                    report_table += "<td class='ware_total'></td></tr>";
                                }

                                 else if(result.records[r].is_type=="net_total"){
                                    report_table += "<tr><td class='grand_total'><div>"+result.records[r].net_amount+"</div></td>";
                                    report_table += "<td class='grand_total'></td>";
                                    report_table += "<td class='grand_total'>"+result.records[r].net_rep_totalamt+"</td>";
                                    report_table += "<td class='grand_total'></td></tr>";
                                }
                            
                        }
                    }

                             $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();

                      });

           }

            else if(params.report_id==105) {
               $.post("<?php echo $getDailySaleCashRecieve; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                      var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);   
                     var report_table = "<table class='report_table'>";
                      report_table +="<thead class='acc_rec'><tr><td>Item Name</td><td>Qty</td><td>Amount</td><td>Revenue %</td><td>InvNo</td><td>Date</td></tr></thead>";
                                 report_table += "<tbody>";
                                   // var item_count = 1;
                            if(result.records){
                        for(var r=0;r<result.records.length;r++){
                            if(result.records[r].is_type=="invoice_detail"){
                                    report_table += "<tr><td><div class='prod_name'>"+result.records[r].item+"</div></td>";
                                    report_table += "<td>"+result.records[r].qty+"</td>";
                                    report_table += "<td>"+result.records[r].amount+"</td>";
                                    report_table += "<td>"+result.records[r].percent+"%</td>";
                                    report_table += "<td>"+result.records[r].invno+"</td>";
                                    report_table += "<td>"+result.records[r].date+"</td></tr>";
                            }
                            else if(result.records[r].is_type=="invTotal"){
                                    report_table += "<tr><td  class='cat_total'><div>"+result.records[r].invoice_total+"</div></td>";
                                    report_table += "<td  class='cat_total'><div></td>";
                                    report_table += "<td  class='cat_total'><div>"+result.records[r].invoice_amount+"</div></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td></tr>";
                                }

                            else if(result.records[r].is_type=="Recieve"){
                                    report_table += "<tr><td  class='recevice_total'><div>"+result.records[r].cashRep_name+"</div></td>";
                                    report_table += "<td  class='recevice_total'><div></td>";
                                    report_table += "<td  class='recevice_total'><div>"+result.records[r].cashRec_name+"</div></td>";
                                    report_table += "<td  class='recevice_total'></td>";
                                    report_table += "<td  class='recevice_total'></td>";
                                    report_table += "<td  class='recevice_total'></td></tr>";
                                }

                            else if(result.records[r].is_type=="customer_total"){
                                    report_table += "<tr><td  class='ware_total'><div>"+result.records[r].cust_total+"</div></td>";
                                    report_table += "<td  class='ware_total'><div></td>";
                                    report_table += "<td  class='ware_total' style='font-size:15px !important'><div>"+result.records[r].cust_amount+"</div></td>";
                                    report_table += "<td  class='ware_total'></td>";
                                    report_table += "<td  class='ware_total'></td>";
                                    report_table += "<td  class='ware_total'></td></tr>";
                                }

                            else if(result.records[r].is_type=="customer"){
                                    report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].cust_name+"</div></td></tr>";
                                }
                            else if(result.records[r].is_type=="grand_total"){
                                    report_table += "<tr><td  class='grand_total'><div>"+result.records[r].g_total+"</div></td>";
                                    report_table += "<td  class='grand_total'>"+result.records[r].g_qty+"<div></td>";
                                    report_table += "<td  class='grand_total'><div>"+result.records[r].g_amount+"</div></td>";
                                    report_table += "<td  class='grand_total'></td>";
                                    report_table += "<td  class='grand_total'></td>";
                                    report_table += "<td  class='grand_total'></td></tr>";
                                }
                            else if(result.records[r].is_type=="expense_detail"){
                                      report_table += "<tr><td  class='ware_name'><div>"+result.records[r].expense_name+"</div></td>";
                                      report_table += "<td  class='ware_name'><div></td>";
                                      report_table += "<td  class='ware_name'><div>"+result.records[r].exp_amount+"</div></td>";
                                      report_table += "<td  class='ware_name'>"+result.records[r].exp_Repname+"</td>";
                                      report_table += "<td  class='ware_name' colspan='2' style='text-align:center;'>"+result.records[r].exp_date+"</td></tr>";
                                  }

                              else if(result.records[r].is_type=="expense_total"){
                                      report_table += "<tr><td  class='grand_total'><div>"+result.records[r].exp_total+"</div></td>";
                                      report_table += "<td  class='grand_total'><div></td>";
                                      report_table += "<td  class='grand_total'><div>"+result.records[r].expTotal_amount+"</div></td>";
                                       report_table += "<td  class='grand_total'><div></td>";
                                      report_table += "<td  class='grand_total'></td>";
                                      report_table += "<td  class='grand_total'></td></tr>";
                                  } 
                               else if(result.records[r].is_type=="rec_total"){
                                      report_table += "<tr><td  class='grand_total'><div>"+result.records[r].rec_total+"</div></td>";
                                      report_table += "<td  class='grand_total'>"+result.records[r].TotalRemAmount+"<div></td>";
                                      report_table += "<td  class='grand_total'><div>"+result.records[r].rec_amount+"<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;("+result.records[r].rec_percent+"%)</span></div></td>";
                                      report_table += "<td  class='grand_total'>"+result.records[r].rec_expense+"</td>";
                                      report_table += "<td  class='grand_total'>"+result.records[r].netrec_amount+"</td>";
                                      report_table += "<td  class='grand_total'></td></tr>";
                                  }
                              else if(result.records[r].is_type=="recevible_group"){
                                      report_table += "<tr><td  class='cat_name'><div>"+result.records[r].groupName+"</div></td>";
                                      report_table += "<td  class='cat_name'><div></td>";
                                      report_table += "<td  class='cat_name'><div></div></td>";
                                      report_table += "<td  class='cat_name'></td>";
                                      report_table += "<td  class='cat_name'  colspan='2' style='text-align:center;'></td></tr>";
                                  }
     
                             else if(result.records[r].is_type=="recevible_detail"){
                                      report_table += "<tr><td  class='reciveCash_total'><div>"+result.records[r].Recieve_name+"</div></td>";
                                      report_table += "<td  class='reciveCash_total'><div></td>";
                                      report_table += "<td  class='reciveCash_total'><div>"+result.records[r].Recieve_amount+"</div></td>";
                                      report_table += "<td  class='reciveCash_total'>"+result.records[r].Recieve_rep+"</td>";
                                      report_table += "<td  class='reciveCash_total'  colspan='2' style='text-align:center;'>"+result.records[r].Recieve_date+"</td></tr>";
                                  }
                                  
                                 else if(result.records[r].is_type=="totalregiontotal"){
                                    report_table += "<tr><td  class='cat_total'><div>"+result.records[r].region_total_region+"</div></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'><div>"+result.records[r].region_Total_amount+"</div></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td></tr>";
                                }
                                
                                 else if(result.records[r].is_type=="region_total"){
                                    report_table += "<tr><td  class='cat_total'><div>"+result.records[r].region_total+"</div></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'><div>"+result.records[r].regionTotal_amount+"</div></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td></tr>";
                                }
                                 else if(result.records[r].is_type=="P_invoice_detail"){
                                     report_table += "<tr><td><div class='prod_name'>"+result.records[r].Pitem+"</div></td>";
                                    report_table += "<td>"+result.records[r].Pqty+"</td>";
                                    report_table += "<td>"+result.records[r].Pamount+"</td>";
                                    report_table += "<td>"+result.records[r].Ppercent+"%</td>";
                                    report_table += "<td>"+result.records[r].Pinvno+"</td>";
                                    report_table += "<td>"+result.records[r].Pdate+"</td></tr>";
                                }
                                 else if(result.records[r].is_type=="PinvTotal"){
                                    report_table += "<tr><td  class='cat_total'><div>"+result.records[r].Pinvoice_total+"</div></td>";
                                    report_table += "<td  class='cat_total'><div></td>";
                                    report_table += "<td  class='cat_total'><div>"+result.records[r].Pinvoice_amount+"</div></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td>";
                                    report_table += "<td  class='cat_total'></td></tr>";
                                }
                                 else if(result.records[r].is_type=="vendor"){
                                    report_table += "<tr><td colspan='6' class='cat_name'><div>"+result.records[r].vendor_name+"</div></td></tr>";
                                }

                             else if(result.records[r].is_type=="net_total"){
                                      report_table += "<tr><td  class='service'><div>"+result.records[r].net_total+"</div></td>";
                                      report_table += "<td  class='service'><div></td>";
                                      report_table += "<td  class='service'><div>"+result.records[r].net_amount+"</div></td>";
                                      report_table += "<td  class='service'></td>";
                                      report_table += "<td  class='service'></td>";
                                      report_table += "<td  class='service'></td></tr>";
                                  }
                           
                            
                        }
                    }

                             $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();

                      });

           }
            else if(params.report_id==106)
         {
               $.post("<?php echo $getCashBalance; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                      var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);   
                     var report_table = "<table class='report_table'>";
                      report_table +="<thead><tr><td></td><td>Amount Type</td><td>Balance</td></tr></thead>";
                                 report_table += "<tbody>";
                                   // var item_count = 1;
                      if(result.records){
                        for(var r=0;r<result.records.length;r++){
                              if(result.records[r].is_type=="InvoiceAmt"){
                                    report_table += "<tr><td><div class='prod_name'></div></td>";
                                    report_table += "<td class='cashBalance'>"+result.records[r].InvoiceAmt+"</td>";
                                    report_table += "<td>"+result.records[r].Invoice_amount+"</td></tr>";
                                  // item_count +=1;
                            }   
                              else if(result.records[r].is_type=="InvoiceDisc"){
                                   report_table += "<tr><td><div class='prod_name'></div></td>";
                                    report_table += "<td class='cashBalance'>"+result.records[r].InvoiceDisc+"</td>";
                                    report_table += "<td >"+result.records[r].Invoice_discount+"</td></tr>";
                                }

                              else if(result.records[r].is_type=="STInvoiceAmt"){
                                    report_table += "<tr><td><div class='prod_name'></div></td>";
                                    report_table += "<td class='cashBalance'>"+result.records[r].STInvoiceAmt+"</td>";
                                    report_table += "<td>"+result.records[r].STInvoice_amount+"</td></tr>";
                                  // item_count +=1;
                            }  
                              else if(result.records[r].is_type=="InvoiceDeduc"){
                                    report_table += "<tr><td><div class='prod_name'></div></td>";
                                    report_table += "<td class='cashBalance'>"+result.records[r].InvoiceDeduc+"</td>";
                                    report_table += "<td>"+result.records[r].Invoice_deduction+"</td></tr>";
                                  // item_count +=1;
                            }     
                              else if(result.records[r].is_type=="AfterTotal"){
                               report_table += "<tr><td ><div class='prod_name'></div></td>";
                                report_table += "<td class='cashBalanceTotal'>"+result.records[r].AfterTotal+"</td>";
                                report_table += "<td class='cashBalanceTotal'>"+result.records[r].after_discount+"</td></tr>";
                            }
                             
                              else if(result.records[r].is_type=="PROFIT"){
                               report_table += "<tr><td><div class='prod_name'></div></td>";
                                report_table += "<td class='cashProftTotal'>"+result.records[r].profit+"</td>";
                                report_table += "<td class='cashProftTotal'>"+result.records[r].profit_amt+"</td></tr>";
                            }
                              
                              else if(result.records[r].is_type=="expense"){
                               report_table += "<tr><td><div class='prod_name'></div></td>";
                                report_table += "<td class='cashExpense'>"+result.records[r].expense+"</td>";
                                report_table += "<td >"+result.records[r].expense_amt+"</td></tr>";
                            }
                              

                              else if(result.records[r].is_type=="vendor"){
                               report_table += "<tr><td><div class='prod_name'></div></td>";
                                report_table += "<td class='cashExpense'>"+result.records[r].vendor+"</td>";
                                report_table += "<td >"+result.records[r].vendor_amt+"</td></tr>";
                            }
                            
                              else if(result.records[r].is_type=="totalAmt"){
                                report_table += "<tr><td class='grand_total'><div></div></td>";
                                report_table += "<td class='grand_total'>"+result.records[r].totalAmt+"</td>";
                                report_table += "<td class='grand_total'>"+result.records[r].total_amt+"</td></tr>";
                            }
                            
                        }
                    }

                             $(".body").children().remove();
                    $(".body").append($(report_table));  
                     top.reports_obj.reportReady();

                      });

           }

          else if(params.report_id==107)
         {
               $.post("<?php echo $getExpenses; ?>", $("#report_form").serialize(),
                      function(data) {  
                     var result = jQuery.parseJSON(data);    
                      var _date = new Date();
                     $("#report_name").html(result.report_name);
                    $("#print_date").html("Report Printed:<span class='date'>"+getDate(_date)+"</span>"); 
                    $("#div_start_date").html("From Date:<span class='date'>"+getDateFromSql(result.start_date)+"</span>");
                    $("#div_end_date").html("To Date:<span class='date'>"+getDateFromSql(result.end_date)+"</span>");
                    $("#col_right").html(result.company_name);   
                     var report_table = "<table class='report_table'>";
                      report_table +="<thead><tr><td>Account Name</td><td>Amount</td><td>Date</td></tr></thead>";
                                 report_table += "<tbody>";
                      if(result.records){
                        for(var r=0;r<result.records.length;r++){
                             if(result.records[r].is_type=="expense_detail"){
                              report_table += "<tr><td><div class='prod_name'>"+result.records[r].Expense_name+"</div></td>";
                              report_table += "<td>"+result.records[r].Amount+"</td>";
                              report_table += "<td>"+result.records[r].date+"</td></tr>";
                            }
                            else if(result.records[r].is_type=="expense_head"){
                                    report_table += "<tr><td  class='cat_total'><div>"+result.records[r].expHead_name+"</div></td>";
                                    report_table += "<td  class='cat_total'><div></td>";
                                    report_table += "<td  class='cat_total'></td></tr>";
                                }
                        }
                         
                    }

                             $(".body").children().remove();
                    $(".body").append($(report_table));  
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
            _date = split_date[2] + " " +month_array[parseInt(split_date[1])-1]+" "+split_date[0];
        }
        return _date;
    }

     
$(window).scroll(function(){
  // alert()
    $('tbody').attr('id', 'fixBody');     
  $('thead').attr('id', 'fixeHead');     
   $('tbody').addClass('content'); 

    if ($(window).scrollTop() >= 100) {
        $('#fixeHead').addClass('fixed-header');
        $('#fixedAcc').addClass('acc_rec');
        $('#fixBody').addClass('fixed-body');
    }
    else {
        $('#fixeHead').removeClass('fixed-header');
         $('#fixBody').removeClass('fixed-body');
          $('#fixedAcc').removeClass('acc_rec');
    }
});


</script>


</body>
</html>
