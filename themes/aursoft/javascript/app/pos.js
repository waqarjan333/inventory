/* Point of sale */
var json_string = "";
var port = "COM3";
var searchCall = null;
var returnMode = false;
var customer_loaded = false;

function setStoreName(){
    if(!isDisplayPole){ return false;}
    $.ajax({
            type: 'GET',
            url: urls.display_total,
            data:{port:port,command:'sname',p1:'Gulista',p2:'n Mega ',p3:'Mart'},
                            //data:{command:'sname',p1:'Muhamm',p2:'ad',p3:' Asmir'},
            success: function(data){

            }
      });
}
function thankMessage(){
    if(!isDisplayPole){ return false;}
    $.ajax({
            type: 'GET',
            url: urls.display_total,
            data:{port:port,command:'thank',p1:'Thank ',p2:'u for S',p3:'hopping'},
            success: function(data){

            }
      });
}
function paidMessage(){
    if(!isDisplayPole){ return false;}
    $.ajax({
            type: 'GET',
            url: urls.display_total,
            data:{port:port,command:'thank',p1:'Paid',p2:'',p3:''},
            success: function(data){

            }
      });
}
$(function(){
    $(".top_close").click(function(){
       if(isPOSUser==="1"){
        $.cookie('pos_mode',"icon-barcode", { expires: 365 });
            window.location = urls.logout; 
        }
        else{
             $.cookie('pos_mode',"icon-barcode", { expires: 365 });
            window.location = urls.home; 
        }
    });
    $(".today_report").click(function(){
        
        $('#report_modal').modal('show');

        $.ajax({
                  type: 'POST',
                  url: urls.getTodaySale,
                  async: false,
                  dataType:'json',
                  data:{},
                  success: function(data){ 
                    // console.log(data);
                    $('#tod_sales').val(data.sale);
                    $('#tod_discount').val(data.discount);
                    $('#tod_return').val(data.ret_sale);
                    $('#tod_deduction').val(data.deduction);
                    $('#tod_paid').val(data.paid);
                    $('#tod_unpaid').val(data.unpaid);
                  }
                }); 
      
      // alert()
    });
    function resize(){
        var h = $(document).height() - ($(".navbar-fixed-top").height()+2);        
        $(".maincols").css("height",h+"px");        
        setWidth();
    }
    function setWidth(){
        var w = $(document).width() - ($("#leftpane").width()+5);
        $("#rightpane").css("width",w+"px");
    }
    resize();
    // $("#welcome-screen").fadeIn(function(){
    //                     $("#barcode-textfield").focus();
    //                 });
    aursoft_pos.init();
    if($.cookie('pos_mode') && $.cookie('pos_mode')=="icon-barcode"){
        $("#mode_switch").click();
    }
    //setStoreName();
    $(window).resize(setWidth);
});

var items_list = null,all_item_list=null;
var invoice_list = {};
var selected_order = "order_"+INVOICE_NO;
var selected_item = null;
var oTable = null;
var price_level = null;
var pos_stat = "";
var cust_data = {};

var aursoft_pos = {
     order_no : INVOICE_NO,
     sel_invoice_id : -1,
     newOrder : 0,
     oldOrder : 0,
     cat_id : 0,
     keyUpCount : 0,
     draggableArray : [],
     init:function(){         
         this.events();
         this.fetchDetails(); 
          $.cookie('pos_mode',"icon-barcode", { expires: 365 });        
         $(".pos").fadeIn();  
         aursoft_pos.createNewInvoice();
         //aursoft_pos.loadCustomer(0);
     },
     initCall:function(){       
       aursoft_pos.drawTable(2);        
     },
     drawTable:function(filterBy){
        oTable = $('#invoice_list_table').dataTable( {
                "bProcessing": true,
                "bSort": false,
                "processing": true,
                "sScrollY": "290px",
                "serverSide": true,
                "ajax": {
                    "url":  urls.fetch_list_invoice,
                    "type": "POST",
                    "data": function ( d ) {
                        var inprocess_orders = '';
                        $.each(invoice_list,function(key){
                           inprocess_orders += " AND pos_inv.invoice_id!="+key.substring(6);
                        })                        
                        d.filterBy = filterBy?filterBy:'2';
                        d.inprocess = inprocess_orders;
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "invoice_no" },
                    { "data": "title" },
                    { "data": "invoice_customer" },
                    { "data": "status" },
                    { "data": "invoice_total" },
                    { "data": "invoice_date" }
                ],
                 "columnDefs": [
                        {                            
                            "render": function ( data, type, row ) {
                                return '<input type="checkbox" value="'+row["id"]+'"/ class="invoice_check" data-status="'+row["status"]+'">';
                                
                            },
                            "targets": 0
                        }
                    ]
                ,"sPaginationType": "full_numbers"
        } );
        var status_str= [{"id":-1,"value":"All"},{"id":1,"value":"In Process"},{"id":2,"value":"Completed"},{"id":3,"value":"Sale Return"}]
        $(".dataTables_length").before($('<button class="btn btn-danger" id="delete_invoices" title="Delete Invoice(s)" style="float:left;margin-right:20px;" ><i class="icon-trash icon-white"></i> </button>'));
        var select_str = '<div class="filter-by-div"><label>Filter By: <select class="filter-by">';
        $.each(status_str,function(key,value){
            var selected_flag = "";
            if(value.id==filterBy){
                selected_flag=' selected ="selected" ';
            }
            select_str += '<option value="'+value.id+'" '+selected_flag+'>'+value.value+'</option>'; 
        })
        select_str +='</select></label></div>';
        $(".dataTables_length").before($(select_str));
        $("#table_check_all").prop("checked",false);
        $("#table_check_all").change(function(){
           $(".invoice_check").prop("checked",this.checked);          
        });
       
        $(".filter-by").change(function(){
            $("#invoice_list_table").DataTable().destroy();
            //$("#invoice_list_table tbody").remove();
            aursoft_pos.drawTable($(this).val());
        }) ;       
        $("#invoice_list_table_wrapper [type='search']").attr("placeholder","Search Invoices...").css("width","230px")  
       $("#delete_invoices").click(function(){
          if($(".invoice_check:checked").length){
              var idSelector = function() { return $(this).val(); };
              var selected_items = $(".invoice_check:checked").map(idSelector).get().toString();
              if($(".invoice_check:checked[data-status='Completed']").length){
                  alert("Completed Invoices can't be delete, Please uncheck all completed inovices.");
                  return;
              }
              if(selected_items && confirm("Are you sure and want to delete selected invoices ?")){                  
                   $.ajax({
                    type: 'POST',
                    url: urls.delete_invoice,
                    data:{                           
                        selected:selected_items
                    },
                    success: function(data){                        
                        var _invoice = jQuery.parseJSON(data);
                        if(_invoice.success){
                            if(oTable){
                                oTable.fnDestroy();
                            }
                            aursoft_pos.drawTable(filterBy);
                        }
                    }
                  });
              }
          } 
          else{
              alert('Please select any invoice to perform this action');
          }
       });
     },
     events:function(){
         //Cash journal button
         $(".paypad-button").click(function(e){
             /*if(aursoft_pos.isOrderCompleted()){
                 return false;
             }*/
             if($(this).attr("cash-register-id")=="1"){               
                aursoft_pos.paymentWindow(e);               
              }
              else if($(this).attr("cash-register-id")=="2"){ 
                aursoft_pos.hideAll();
                $("#onaccount-screen,.pos-actionbar").fadeIn();
                $(".print").hide();
                aursoft_pos.disableAction();
                $(".payment").fadeIn();
                $("#validate_payment").hide();
                $("#backtocategory").removeClass("disabled");                
              }
         });
         
         //Back Button
         $("#backtocategory").click(function(){
             if(!$(this).hasClass("disabled")){
                pos_stat="";
                //$("#payment-discount").html("0.00 Rs.");
                aursoft_pos.hideAll();
                aursoft_pos.enableActions();
                if($.cookie('pos_mode') && $.cookie('pos_mode')=="icon-barcode"){
                   $("#products-screen").hide();   
                    $("#welcome-screen").fadeIn(function(){
                        $("#barcode-textfield").focus();
                    });
               }
               else{
                    $("#products-screen").fadeIn();
                }
                delete invoice_list[selected_order]["received"];
                setTimeout(function(){
                    $(".cash-received").blur();
                },100);
             }
         });
         
         $(".category-simple-button").click(this.fetchDetails);
         //$(".oe-pos-categories-list").click(this.fetchBreadCrums);
         
         $(".cash-tendered").keyup(function(e){            
            var total_due = parseFloat($(".cash-received").val());
            var tendered =  parseFloat($(this).val());
            var difference = tendered-total_due;
            if(difference>=0){
               $("#payment-change").html(aursoft_pos.format(difference,2)+" Rs.")
            }
            else{
                $("#payment-change").html("")
            }                                         
            if(e.keyCode==13){
                if(tendered!=0 && difference<0){
                    alert('Please tender at least required cash!')
                    return;
                }
                invoice_list[selected_order]["received"] = aursoft_pos.format($(".cash-received").val(),2);
                aursoft_pos.calcCash(this,e); 
                if(e.shiftKey && e.ctrlKey){
                    setTimeout(function(){     
                       window.print();
                       $("#next-order").click();
                   },200)                
                }
                else if(e.shiftKey){
                   setTimeout(function(){                    
                       $("#next-order").click();
                   },200)                
                }
            }
             
             e.preventDefault();
             e.stopPropagation();
         })
         
         $(".cash-paid,.cash-received").keyup(function(e){
             var total = parseFloat($("#total_sale").text());
             if($(this).val()>total){
                $(this).val(aursoft_pos.format(total,2)); 
             }
             if($("#customerchoosen").val()==="0"){
                if($(this).val() == total){
                        $("#payment-discount").val("");
                        $("#payment-discount_discount").val("");
                        $("#payment-remaining").html("0.00 Rs.");
                    } else {
                        var remaining =  total - $(this).val();
                        var discounted = remaining*100/total;
                        $("#payment-discount").val(aursoft_pos.format(remaining,2));
                        if(discounted % 1 === 0){
                           $("#payment-discount_discount").val(aursoft_pos.format(discounted,2));
                            $("#payment-remaining").html("0.00 Rs."); 
                        } else {
                        $("#payment-discount_discount").val(aursoft_pos.format(discounted,4));
                        $("#payment-remaining").html("0.00 Rs.");
                        }
                    }
                } else{
                    if (!$(this).val() || $(this).val().length == "0"){
                        if($("#payment-discount_discount").val()=="" || $("#payment-discount_discount").val()=="0"){
                            $("#payment-remaining").html(total+" Rs.");
                            } else {
                                if (!$(this).val() || $(this).val().length == "0"){
                                    var remaining =  parseFloat($("#payment-discount-total").text());
                                    $("#payment-remaining").html(remaining+" Rs.");
                                } else {
                                    var remaining =  parseFloat($(this).val())+parseFloat($("#payment-discount").val());
                                    var rem_val = total-remaining;
                                    $("#payment-remaining").html(rem_val+" Rs.");
                                }
                                
                            }
                        } else {
                        if($("#payment-discount_discount").val()=="" || $("#payment-discount_discount").val()=="0"){
                        var remainings =  total-parseFloat($(this).val());
                        $("#payment-remaining").html(remainings+" Rs.");
                        } else {
                            var remaining =  parseFloat($(this).val())+parseFloat($("#payment-discount").val());
                            var rem_val = total-remaining;
                            $("#payment-remaining").html(rem_val+" Rs.");
                        }
                    }
                                        
                                       
              }
             
             invoice_list[selected_order]["received"] = aursoft_pos.format($(this).val(),2);
             aursoft_pos.calcCash(this,e);
             
             //Short cut keys
             if(e.keyCode==13){
                if(e.shiftKey && e.ctrlKey){
                    setTimeout(function(){     
                       window.print();
                       $("#next-order").click();
                   },200)                
                }
                else if(e.shiftKey){
                   setTimeout(function(){                    
                       $("#next-order").click();
                   },200)                
                }
            }
             
             e.preventDefault();
             e.stopPropagation();
         });
         
         $("#payment-discount").keyup(function(){
             var rem = 0;
             var descount = 0;
             if($(this).val()>parseFloat($("#total_sale").text())){
                        $(".cash-received").val(parseFloat($("#total_sale").text()).toFixed(2));
                        $("#payment-discount").val("");
                        $("#payment-discount_discount").val("");
                        $("#payment-remaining").html("0.00 Rs.");
                    }
              if($("#customerchoosen").val()==="0"){                 
                 if ($("#payment-discount").val().length != 0){
                    rem = parseFloat($("#total_sale").text())-parseFloat($(this).val());
                    descount = parseFloat($(this).val())/parseFloat($("#total_sale").text())*100;
                    $(".cash-received").val(rem.toFixed(2));
                    $("#payment-discount_discount").val(descount.toFixed(4));
                    $("#payment-remaining").html("");
                } else {
                    $(".cash-received").val(parseFloat($("#total_sale").text()).toFixed(2));
                    $("#payment-discount").val("");
                    $("#payment-discount_discount").val("");
                    $("#payment-remaining").html("");
                }
              } else {                                   
                  if ($("#payment-discount").val().length != 0){
                    var rem_cust = parseFloat($("#total_sale").text())-parseFloat($(this).val());
                    var descount_cust = parseFloat($(this).val())/parseFloat($(".cash-received").val())*100;
                    var total_price = rem_cust-rem_cust;  
                    $(".cash-received").val(rem_cust.toFixed(2));
                    $("#payment-discount-total").html(rem_cust.toFixed(2) +" Rs.");
                    $("#payment-discount_discount").val(descount_cust.toFixed(4));
                    $("#payment-remaining").html(total_price.toFixed(2)+" Rs.");
                } else {
                    $(".cash-received").val(parseFloat($("#total_sale").text()).toFixed(2));
                    $("#payment-discount-total").html(parseFloat($("#total_sale").text()).toFixed(2) +" Rs.");
                    $("#payment-discount").val("");
                    $("#payment-discount_discount").val("");
                    $("#payment-remaining").html("");
                }
              }
             
         })
         
         $("#payment-discount_discount").keyup(function(){
             
             
            var total = parseFloat($("#total_sale").text());
            var paid = $(".cash-received").val();
            var des = $(this).val().length==0? 0 :parseFloat($(this).val());            
            var per = total * des / 100;
            var remain = parseFloat($("#total_sale").text())-parseFloat(per);
            
            
            if($("#customerchoosen").val()==="0"){
                if($(this).val()>100){
                $(".cash-received").val(parseFloat($("#total_sale").text()));
                $("#payment-discount").val("");
                $("#payment-discount_discount").val("");
                $("#payment-remaining").html("0.00 Rs.");
                } else {
                $(".cash-received").val(remain.toFixed(2));
                $("#payment-discount").val(per.toFixed(2));
                $("#payment-remaining").html("0.00");
             }
            } else {
                if($(this).val()>100){
                    $(".cash-received").val(parseFloat($("#total_sale").text()));
                    $("#payment-discount-total").html(parseFloat($("#total_sale").text()));                    
                    $("#payment-discount").val("");
                    $("#payment-discount_discount").val("");
                    $("#payment-remaining").html("0.00 Rs.");
                } else {
                var rem_val = total-(remain+per);
                    $(".cash-received").val(remain.toFixed(2));
                    $("#payment-discount-total").html(remain.toFixed(2));
                    $("#payment-discount").val(per.toFixed(2));
                    $("#payment-remaining").html("0.00");
              }
            }
             
         })
         $("#invoies_list_modal").keyup(function(e){
             e.preventDefault();
             e.stopPropagation();    
         });
         $(".cancel-order").click(aursoft_pos.deleteInvoice);
         //Validate Button
          $("#validate_payment").click(function(){
              if(!$(this).hasClass("disabled")){                  
               if(aursoft_pos.checkTenderAmount() && aursoft_pos.validate_cash()){
                    invoice_list[selected_order]['pay_method'] = $("#methodchoosen").val();
                    $("#payment_modal").modal("hide"); 
                    $("#backtocategory").removeClass("disabled");
                    paidMessage();                                //thankMessage();
                }
              }    
            });
          
          $('#payment_modal').on('hide', function () {              
            aursoft_pos.keyUpCount = 0
          })
          //Print 
          
          $("#receipt-print").click(function(){
             window.print(); 
          });
          
          window.onbeforeunload = function() {
            $.ajax({
                  type: 'POST',
                  url: urls.reset_pos,
                  async: false,
                  data:{},
                  success: function(data){            
                  }
                });  
            return "Are you sure you wish to leave the page?";
          }
          
          //Next order
          $("#receipt-print-next").click(function(){
              window.print();
              $("#next-order").click();
          })
          $("#next-order").click(function(){
              thankMessage();
              aursoft_pos.hideAll();
              aursoft_pos.enableActions();              
              if($.cookie('pos_mode') && $.cookie('pos_mode')=="icon-barcode"){
                   $("#products-screen").hide();   
                    $("#welcome-screen").fadeIn(function(){
                        $("#barcode-textfield").focus();
                    });
              }
              else{
                  $("#products-screen").show();   
                  //$("#cat_nav_1").click();
              }
              var customer_id = invoice_list[selected_order]['customer'];
              var sale_rep = $("#salerep_choosen").val();
              var invoice_no = invoice_list[selected_order]["invoice_no"];
              var printInvoice = invoice_list[selected_order]['completed'];
              var pay_method = invoice_list[selected_order]['pay_method'];
              delete invoice_list[selected_order];                    
              var inv_id = selected_order.split("_")[1];
              var _invoice_count = 0;
              var order_no_first = "";
                                    
              $.each(invoice_list,function(i,o){
                _invoice_count = _invoice_count +1 ;  
                order_no_first = i;
              })
              
              if(!printInvoice){
                $.ajax({
                  type: 'POST',
                  url: urls.save_invoice,
                  async: false,
                  data:{
                          action:"complete",
                          invoice_date:aursoft_pos.getDateMysqlFormatWithTime(new Date()),
                          paymethod:'1',
                          invoice_status:'2',
                          cust_id:customer_id,
                          sale_rep:sale_rep,
                          salereturn:returnMode,
                          sales_detail:json_string,
                          invoice_paid:$(".cash-received").val(),
                          discount:aursoft_pos.format(parseFloat($("#payment-discount").val()),2),
                          discount_invoice:parseFloat($('.discount').html()),
                          invoice_total:parseFloat($("#total_sale").html()),
                          invoice_id:inv_id,
                          invoice_no:invoice_no,
                          pay_method: pay_method
                  },
                  success: function(data){
                      var _invoice = jQuery.parseJSON(data);                            
                      $("#"+selected_order).parents("li").remove();
                      if(returnMode){                                            
                          INVOICE_NO = parseInt(_invoice.nexInvoice_no); 
                          var invoice_id = "";
                          var invoice_count =0;
                          $.each(invoice_list,function(key,val){
                              var invoice_id = key;
                              var items = 0;
                              invoice_count = invoice_count + 1;
                              $.each(this,function(key,val){
                                  items = items +1;
                              });
                              if(items==0){
                                 delete  invoice_list[invoice_id];
                                 $("#orders #"+invoice_id).parents("li").remove();
                              }
                          });
                          if(invoice_count<=1){
                            $(".neworder-button").click();
                          }
                          $(".pos-mode .selected-mode").removeClass("selected-mode");
                          $(".sale-mode").addClass("selected-mode");
                          $("#customer_name").hide();
                      }
                      else{                          
                          if(_invoice_count==0){
                                aursoft_pos.createNewInvoice();                      
                            }
                            else{                               
                              selected_order = order_no_first;  
                              $("#"+selected_order).click();
                            }                            
                            if(_invoice['last_completed']){
                                $(".last-amount").html(aursoft_pos.format(_invoice['last_completed'],2)+" Rs.");
                            }
                      }
                      $("#choose_form1").show();
                      returnMode = false;
                  }
                });
              }
              pos_stat="";
              //$("#payment-paid-total,#payment-change,#payment-remaining").html("0.00 Rs.");
              //$("#payment-discount").val("");
              //$(".cash-received").val("0.00");              
              if(!printInvoice){
                
                
              }else{
                  selected_order = $(".selected-order").attr("id");
              }
          });
          //Attach scroll bar 
          $('.content-container').jScrollPane(
            {
                    showArrows: true,
                    horizontalGutter: 48,
                    verticalGutter: 4
            }
           );
         // Add function price, quantity and discount
         $(".function").click(function(){
             $(".function").removeClass("selected-mode");
             $(this).addClass("selected-mode");
             if($(".orderlines li.selected").length){
                var ide = $(".orderlines li.selected").attr("id").split("_")[2];
                var unit_id = $(".orderlines li.selected .selected_unit_combo").val();
                var id = aursoft_pos.checkItemExists(ide,unit_id);
               
                invoice_list[selected_order][id]["isChanged"] = false;
             }
         });
         
         $(".input-button").click(aursoft_pos.handleKeyPad);
         
         $(".neworder-button").click(function(){
             aursoft_pos.createNewInvoice();
         });
         
         $("#invoice_btn").click(this.createInvoice);
         
         $('#invoice_modal').on('hidden', function () {
              if($("#orders > li").length==0){
                setTimeout("aursoft_pos.initInvoiceDialog()",200);
              }
         });
         $("#invoies_list_modal").on('hidden', function () {
              $(".invoice_check:checked").attr("checked",false); 
         });
         
         $("#new_customer_modal").on('hidden', function () {
             if(!customer_loaded){
                 $("#customerchoosen").val("0").trigger("chosen:updated");
                 $("#customerchoosen").change();
             }
             else{
                 customer_loaded = false;
             }
         });
         
          $('#invoies_list_modal').on('shown', function () {
               if(oTable){
                oTable.fnDestroy();
               }
               aursoft_pos.initCall();
         });
         
         $("#product-search").keyup(function(e){
             if(e.keyCode==13 && $.trim($(this).val())==""){                        
                aursoft_pos.paymentWindow(e);
              }
              else{
                aursoft_pos.fetchResults(e);
              }
              aursoft_pos.keyUpCount = 0;
         });
         
         $("#close_search").click(this.removeSearch);
         $("#search_form_product").submit(function(){
             return false;
         })
         $("#mode_switch").click(function(){
            var anchor_tag = $(this).find("i");
            if(anchor_tag.hasClass("icon-barcode")){                
                aursoft_pos.hideAll();
                $("#welcome-screen").fadeIn(function(){
                    $("#barcode-textfield").focus();
                });
                anchor_tag[0].className ="icon-shopping-cart";
                $.cookie('pos_mode',"icon-barcode", { expires: 365 });
                $("#product-search").hide();
                $("#product-search-list").show();
            }
            else{
                
                $("#welcome-screen").hide();
                aursoft_pos.enableActions();
                $("#products-screen").fadeIn();                
                anchor_tag[0].className ="icon-barcode";
                $.cookie('pos_mode',"icon-shopping-cart", { expires: 365 });
                $("#product-search").show();
                $("#product-search-list").hide();
            }
         });
         $("#barcode-textfield").change(function(e){            
            //aursoft_pos.scanItem(); 
            e.preventDefault();
            e.stopPropagation();
            return false;
         });
         
         $("#barcode-textfield").keyup(function(e){
            
            if(e.keyCode==13 && $(this).val()==""){                        
                aursoft_pos.paymentWindow(e);
            }
            if(e.keyCode===13){
                aursoft_pos.scanItem(); 
            }
            else if(e && e.keyCode===115){
                $("#mode_switch").click();
                $(this).val('');
            }
            
            
            return false;
         });
         
         $(".chzn-select").chosen({width:'200px'}); 
         $(".chzn-select-salerep").chosen({width:'155px;'});
         $(".chzn-select-group").chosen({width:'83%;'});
         
         $("#choose_form1").change(function(){
             var selected_val = $(".chzn-select").val();
                         
             aursoft_pos.loadCustomer(selected_val,true);
          
         });
         
         $("#show_list_toolbar").click(function(){
             $(".sale-mode").click();
             $("#invoies_list_modal").modal({backdrop: 'static',keyboard: false});
         });
         
         var itemSearch = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,            
            remote: {
              url: urls.search_items+"&search=%QUERY",
              wildcard: '%QUERY'
            }
          });

         $('#product-search-list').typeahead(null, {            
            display: 'item_name',
            source: itemSearch,
            highlight: true,
            limit: 15,
            minLength: 2
          });
          $('#product-search-list').keyup(function(e){
              if(e.keyCode==13 && $.trim($(this).val())==""){                        
                aursoft_pos.paymentWindow(e);
              }
              aursoft_pos.keyUpCount = 0;
              e.preventDefault();
              e.stopPropagation();
                return false;
          });
           $('#product-search-list').bind('typeahead:selected', function(obj, datum, name) {                      
                //alert(JSON.stringify(datum)); // contains datum value, tokens and custom fields                              
                aursoft_pos.displayItem(datum,'fromSearch');
            });
         
         
         $("#validate_btn").click(function(){
            var order_no = $("#return_invoice_id").val(); 
              if(order_no && typeof(parseInt(order_no))=="number"){
                    $("#return_modal").modal("hide"); 
                    $.ajax({
                        type: 'GET',
                        url: urls.get_invoice_detail+"&invoice_id="+order_no+"&isReturnMode=true", 
                        success: function(data){
                            var _invoice = jQuery.parseJSON(data);
                            var number = _invoice.invoice_id;
                            var invoiceName = _invoice.invoice_name;
                            var _order ="order_"+number;
                            if($("#"+_order).length==0 &&  _invoice.invoice_status=="complete" && _invoice.invoice_type=="1"){
                                var complete_invoice = _invoice.invoice_status;
                                var invoiceTab = $('<li class="order-selector-button"><div class="btn-group '+complete_invoice+'"><button class="btn" id="order_'+number+'">Sale Return-'+number+'</button></div></li>');
                                $(".pos-mode").append(invoiceTab);                
                                invoice_list[_order] = {};
                                var inv_details = _invoice.detail;
                                for (var i=0;i<inv_details.length;i++){
                                    var inv_key = aursoft_pos.getTimeStamp()+"_"+inv_details[i].id;
                                    invoice_list[_order][inv_key] = {};
                                    invoice_list[_order][inv_key]["name"] = inv_details[i].name;
                                    invoice_list[_order][inv_key]["id"] = inv_details[i].id;
                                    invoice_list[_order][inv_key]["discount"] = inv_details[i].discount;
                                    invoice_list[_order][inv_key]["price"] = inv_details[i].price;                                          
                                    invoice_list[_order][inv_key]["a_price"] = inv_details[i].sale_price;
                                    invoice_list[_order][inv_key]["normal_price"] = inv_details[i].normal_price;
                                    invoice_list[_order][inv_key]["quantity"] = inv_details[i].quantity;                                    
                                    invoice_list[_order][inv_key]["t_discount"] = inv_details[i].discount;
                                    invoice_list[_order][inv_key]["sale_price"] = inv_details[i].sale_price;
                                    invoice_list[_order][inv_key]["uom_unit_array"] = inv_details[i].item_unit;
                                    invoice_list[_order][inv_key]["conv_from"] = inv_details[i].conv_from;
                                    invoice_list[_order][inv_key]["uom_unit"] = inv_details[i].sale_unit;
                                    invoice_list[_order][inv_key]["unit_name"] = inv_details[i].unit_name;
                                    invoice_list[_order][inv_key]["sale_uom_default"] = inv_details[i].sale_unit;
                                    invoice_list[_order][inv_key]["isChanged"] = false;
                                    invoice_list[_order][inv_key]["sale_return_mode"] = true;
                                }                      
                                invoice_list[_order]['customer'] = _invoice.cust_id
                                invoice_list[_order]['dateCreated'] = _invoice.created_date
                                $("#order_"+number).click(aursoft_pos.selectInvoice);
                                
                                $("#order_"+number).click();
                            }
                            else{
                                alert('Please provide valid invoice number.')
                            }
                        }
                  }); 
              }
              else{
                  alert('Please provide valid invoice number.')
              }
         });
         
        $(".total-invoice-calc").mouseover(function(){
           var offset = $(this).offset();
           var t_purchase_cost = 0 , t_sale_cost=0, t_profit =0;
           $.each(invoice_list[selected_order],function(key,val){          
                if(typeof(val)==='object'){
                    t_purchase_cost = t_purchase_cost + (parseFloat(val.normal_price) * parseFloat(val.quantity));
                    t_sale_cost = t_sale_cost + (parseFloat(val.sale_price) * parseFloat(val.quantity));
                    t_profit = t_sale_cost - t_purchase_cost;
                }
            });
           if(t_purchase_cost && t_sale_cost){ 
               $(".popover-title").html("Invoice Margin");
               $(".popover-content").html("<div>Purchase Cost: "+aursoft_pos.format(t_purchase_cost,2)+" Rs.</div><div>Total Sales: "+aursoft_pos.format(t_sale_cost,2)+" Rs.</div><div><b>Total Profit: "+aursoft_pos.format(t_profit,2)+" Rs.</b></div>")
               $(".popover").fadeIn("fast").css({top:offset.top-80,left:offset.left+20}); 
           }
        }).mouseout(function(){
            $(".popover").fadeOut("fast");
        });
        
         $("#load_invoice_btn").click(function(){
              if($(".invoice_check:checked").length){
                  if($(".invoice_check:checked").length>1 && $(".invoice_check:checked[data-status='Completed']").length){
                    alert("Completed Invoices can't be loaded for edit, Please uncheck all completed inovices.");
                    return;
                  }
                  var cInvoice = $(".invoice_check:checked[data-status='Completed']").length;
                  $(".invoice_check:checked").each(function(){
                      var invoice_id = $(this).val();
                      if($("#order_"+invoice_id).length==0){
                        $.ajax({
                              type: 'GET',
                              url: urls.get_invoice_detail+"&invoice_id="+invoice_id, 
                              success: function(data){
                                  var _invoice = jQuery.parseJSON(data);
                                  var number = _invoice.invoice_id;
                                  var invoiceName = _invoice.invoice_name;
                                  var _order ="order_"+number;
                                  if($("#"+_order).length==0){
                                      var complete_invoice = _invoice.invoice_status;
                                      var invoiceTab = $('<li class="order-selector-button"><div class="btn-group '+complete_invoice+'"><button class="btn" id="order_'+number+'">'+invoiceName+'</button><button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li id="order-rename_'+number+'"><a href="#">'+_labels.text_rename+'</a></li><li id="order-del_'+number+'"><a href="#">'+_labels.text_delete+'</a></li><li id="order-close_'+number+'"><a href="#">'+_labels.text_hold+'</a></li></ul></div></li>');
                                      if(cInvoice!==1){
                                        $("#orders").append(invoiceTab);                
                                      }

                                      invoice_list[_order] = {};
                                      var inv_details = _invoice.detail;
                                      for (var i=0;i<inv_details.length;i++){
                                          var inv_key = aursoft_pos.getTimeStamp(i)+"_"+inv_details[i].id;

                                          invoice_list[_order][inv_key] = {};
                                          invoice_list[_order][inv_key]["name"] = inv_details[i].name;
                                          invoice_list[_order][inv_key]["id"] = inv_details[i].id;
                                          invoice_list[_order][inv_key]["discount"] = inv_details[i].discount;
                                          invoice_list[_order][inv_key]["price"] = inv_details[i].price;                                          
                                          invoice_list[_order][inv_key]["a_price"] = inv_details[i].price;
                                          invoice_list[_order][inv_key]["quantity_on_hand"] = inv_details[i].qty_on_hand;
                                          invoice_list[_order][inv_key]["unit_qty"] = inv_details[i].qty_on_hand/inv_details[i].conv_from;
                                          invoice_list[_order][inv_key]["barcode"] = inv_details[i].item_code;
                                          invoice_list[_order][inv_key]["normal_price"] = inv_details[i].normal_price;
                                          invoice_list[_order][inv_key]["quantity"] = inv_details[i].quantity;
                                          invoice_list[_order][inv_key]["t_discount"] = inv_details[i].discount;
                                          invoice_list[_order][inv_key]["sale_price"] = inv_details[i].price;
                                          invoice_list[_order][inv_key]["uom_unit_array"] = inv_details[i].item_unit;
                                          invoice_list[_order][inv_key]["conv_from"] = inv_details[i].conv_from;
                                          invoice_list[_order][inv_key]["uom_unit"] = inv_details[i].sale_unit;
                                          invoice_list[_order][inv_key]["unit_name"] = inv_details[i].unit_name;
                                          invoice_list[_order][inv_key]["sale_uom_default"] = inv_details[i].sale_unit;
                                          invoice_list[_order][inv_key]["isChanged"] = false;
                                      }                      
                                      invoice_list[_order]['customer'] = _invoice.cust_id
                                      if(_invoice.invoice_status=="complete"){
                                          invoice_list[_order]['dateCreated'] = _invoice.created_date;
                                      } else {
                                      invoice_list[_order]['dateCreated'] = aursoft_pos.getDateTime(new Date(), "dddd, mmmm dS, yyyy, h:MM TT");//_invoice.created_date;
                                        }
                                      invoice_list[_order]['invoice_no'] = _invoice.invoice_no;
                                      invoice_list[_order]['invoice_discount'] = _invoice.invoice_discount;
                                      invoice_list[_order]['invoice_paids'] = _invoice.invoice_paids;
                                      invoice_list[_order]['invoice_remaining'] = _invoice.invoice_remaining;
                                      if(cInvoice!==1){
                                        $("#order_"+number).click(aursoft_pos.selectInvoice);
                                        $("#order-rename_"+number).click(aursoft_pos.editInvoiceName);
                                        $("#order-del_"+number).click(aursoft_pos.deleteInvoice);
                                        $("#order-close_"+number).click(aursoft_pos.closeInvoice);
                                      }
                                      else{
                                          invoice_list[_order]['completed'] = true;
                                          selected_order = "order_"+number;                                                  
                                          aursoft_pos.validate_cash(true,invoiceName);
                                      }
                                  }
                              }
                        });
                      }
                  });
                  
                 $("#invoies_list_modal").modal("hide"); 
              }
         });
         
         $(".print_settings").click(function(){
                if($("input[name='print_size']:checked").val()=="print_a4"){
                    $(".pos-sale-ticket").attr("style","display:none !important");
                    $(".pos-large-ticket").attr("style","display:inline-block !important");
                    $(".dot-matrix").attr("style","display:none !important");
                }
                else if($("input[name='print_size']:checked").val()=="print_th"){
                    $(".pos-sale-ticket").attr("style","display:inline-block !important");
                    $(".pos-large-ticket").attr("style","display:none !important");
                    $(".dot-matrix").attr("style","display:none !important");
                }
                else {
                    $(".pos-sale-ticket").attr("style","display:none !important");
                    $(".pos-large-ticket").attr("style","display:none !important");
                    $(".dot-matrix").attr("style","display:inline-block !important");
                }
         });
         $("#return_invoice_id").on('keyup',function(e){
            e.preventDefault();
            e.stopPropagation();
            return false;
         })          
         $(document.body).scannerDetection({
             onComplete:function(){   
               
               setTimeout(function(){aursoft_pos.keyUpCount = 0},200);
             },
             stopPropagation:true,
             onReceive : function(){
                if($( document.activeElement )[0].tagName=="BODY"){
                   aursoft_pos.keyUpCount =  aursoft_pos.keyUpCount + 1;
                }
             }
         });
        $(document.body).on('keyup',function(e){                       
           setTimeout(function(){aursoft_pos.keyUpBody(e)},100);                        
        });
                         
        $("#new_item_modal,#new_customer_modal").keyup(function(e){
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
        
        $("#new_item_modal input").keyup(function(e){
            if(e && e.keyCode===13){
                $("#add_item_btn").click();
            }
        });
        
        $("#new_customer_name").keyup(function(e){
            if(e && e.keyCode===13){
                $("#save_customer_btn").click();
            }
            
        });
        $("#new_invoice_name").keyup(function(e){
           if(e && e.which == 13) {
             $("#invoice_btn").click();   
             e.preventDefault();
             e.stopPropagation();
             return false;
           } 
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
        
        
        $(".pos-mode button").focus(function(){
            $(this).blur();
        });
        $(".pos-mode button").click(function(){
            if(!$(this).hasClass("selected-mode")){
                if($(".orderlines .orderline").length>0){
                    alert('Please remove items from cart to perform this acitons.');
                    return false;
                }
                $(this).addClass("selected-mode");
                if($(this).hasClass("btn return-mode")){                                         
                    $(".orderline.empty").html(_labels.empty_return);
                    $("#customer_name").html(_labels.text_sale_return).show();
                    $(".sale-return-total").html(_labels.text_total+" "+_labels.text_sale_return+":");
                    $("body").addClass("sale-return");                    
                    returnMode = true;
                }
                else{                    
                    returnMode = false;
                }
            }
            else{
                $("body").removeClass("sale-return");
                $(".orderline.empty").html(_labels.empty_cart);
                $("#customer_name").hide();
                $(".pos-mode button").removeClass("selected-mode");
                $(".sale-return-total").html(_labels.text_total+":");                
                returnMode = false;
            }
        });
        $(".cash-received,#payment-discount,#payment-discount_discount,.cash-tendered").ForceFloatingOnly(); 
        $("#newitem-saleprice,#newitem-purchaseprice,#newitem-qty_on_hand").ForceFloatingOnly(); 
        var option_category = "";
        for(var c=0;c<categories.length;c++){
            option_category +='<option value="'+categories[c].id+'">'+categories[c].name+'</option>';
        }
        $("#newitem-category").html(option_category);
        
        // New dialogs Logic
        
        $("#add_item_btn").click(function(){
            if($(this).hasClass("disabled")){return false};
            var item_name = $.trim($("#newitem-itemname").val());
            var sale_price = $("#newitem-saleprice").val();
            var purchase_price = $("#newitem-purchaseprice").val();
            
            if(item_name!=="" && sale_price!=="" && purchase_price!==""){
                $("#new_item_modal input").attr("disabled",true);
                $("#add_item_btn").addClass("disabled");
                var barcode = $("#newitem-barcode").val();
                $.ajax({
                        type: 'POST',
                        url: urls.save_item,
                        data:{name:item_name,
                            barcode:barcode,
                            cat_id:$("#newitem-category").val(),
                            item_date:aursoft_pos.getDateMysqlFormatWithTime(new Date()),
                            nprice:purchase_price,
                            sprice:sale_price,
                            quantity:$("#newitem-qty_on_hand").val()
                        },
                        success: function(data){                        
                            $("#new_item_modal input").attr("disabled",false);
                            $("#add_item_btn").removeClass("disabled");
                            var result = jQuery.parseJSON(data);
                            $(".loading").hide();         
                            if(result.success===1){
                                $("#new_item_modal").modal('hide');      
                                aursoft_pos.scanItem(barcode);
                            }                    
                            else{
                                alert(result.msg);
                            }
                        }
                  });
          }
        });
        
        $("#customerchoosen").change(function(){
            if($(this).val()=="-1"){
                $("#new_customer_modal").modal({backdrop: 'static',keyboard: false});
                setTimeout('$("#new_customer_name").val("").focus()',100);
            }
            else{
                invoice_list[selected_order]["customer"] = $(this).val();
                setTimeout("$('.chosen-search input').blur()",50);
            }            
        });
        
        $("#salerep_choosen").change(function(){
           setTimeout("$('.chosen-search input').blur()",50);            
        });
      
        
        $("#save_customer_btn").click(function(){
            if($(this).hasClass("disabled")){return false};
            var customer_name = $.trim($("#new_customer_name").val());
            var customer_obalance = $.trim($("#new_customer_obalance").val());
            var customer_phone = $.trim($("#new_customer_phone").val());
            var customer_mobile = $.trim($("#new_customer_mobile").val());
            var customer_address = $.trim($("#new_customer_address").val());
            if(customer_name!==""){
                $("#new_customer_name,#save_customer_btn").attr("disabled",true);
                $("#save_customer_btn").addClass("disabled");
                $.ajax({
                        type: 'POST',
                        url: urls.save_customer,
                        data:{cust_name:customer_name,                            
                             cust_price_level:0,cust_group_name:1,cust_type_name:1,cust_ct_name:'',cust_phone:customer_phone,cust_mobile:customer_mobile,cust_email:'',cust_credit_limit:'',cust_fax:'',cust_address:customer_address,
                             cust_obalance:customer_obalance,cust_hidden_id:-1
                        },
                        success: function(data){                        
                            $("#new_customer_name,#save_customer_btn").attr("disabled",false);
                            $("#save_customer_btn").removeClass("disabled");
                            var result = jQuery.parseJSON(data);
                            $(".loading").hide();         
                            if(result.success===1){
                                customer_loaded = true;
                                $("#new_customer_modal").modal('hide');   
                                $("#customerchoosen").append('<option value="'+result.obj_id+'" selected="selected">'+customer_name+'</option>');
                                $("#customerchoosen").trigger("chosen:updated");
                                
                            }                    
                            else{
                                alert(result.msg);                                
                            }
                        }
                  });
          }
        });
        
        this.initDrop();
     },
     keyUpBody : function(e){ 
        if(aursoft_pos.keyUpCount<=2){         
        aursoft_pos.keyUpCount = 0;
        if(e.ctrlKey) {  
             switch(e && e.keyCode){                    
                  case 80: //ctrl +p
                       $("#receipt-print").click(); 
                       e.preventDefault();
                       e.stopPropagation();
                   break; 
                 default:
                     break;
             }

         }

          if(e && e.keyCode===113){
                $("#product-search").focus();
           }
           else if(e && e.keyCode===115){
                $("#mode_switch").click();
           }
           if(e && e.shiftKey){
               if(e.keyCode===74){
                  $(".paypad-button[cash-register-id=1]").click();
                  e.preventDefault();
                  e.stopPropagation(); 
               }
           }

         if(e && e.keyCode===13){
             if(pos_stat){
                 if(pos_stat==="print_next"){
                     $("#receipt-print-next").click();
                     pos_stat="";                        
                 }
                 else if(pos_stat==="printing"){
                     alert("Please wait printing invoice");
                 }
                 else if(pos_stat==="finish"){
                     pos_stat="";
                     $("#next-order").click();
                 }
                 else if(pos_stat==="print"){
                     $("#receipt-print").click();
                     pos_stat="printing";
                     setTimeout('aursoft_pos.printDone()',2000);
                 }
                 e.preventDefault();
                 e.stopPropagation();
                 return false;
             }

         }
         else if(e && e.keyCode===39){
             if(pos_stat==="print_next"){
                 $("#receipt-print-next").removeClass("selected");
                 $("#next-order").addClass("selected");
                 pos_stat="finish";
             }
             else if(pos_stat==="print"){
                 $("#receipt-print").removeClass("selected");
                 $("#receipt-print-next").addClass("selected");
                 pos_stat="print_next";
             }
         }
         else if(e && e.keyCode===37){
             if(pos_stat==="finish"){
                 $("#next-order").removeClass("selected");
                 $("#receipt-print-next").addClass("selected");
                 pos_stat="print_next";
             } else{
                 $("#receipt-print-next").removeClass("selected");
                 $("#receipt-print").addClass("selected");
                 pos_stat="print";
             }
         }

         if($("#products-screen").css("display")=="block" || $("#welcome-screen").css("display")=="block"){
             if($(e.target).attr("id")=="barcode-textfield"  || $(".modal.in").length){
                 return false;
             }
             if(e){
                 if(e.keyCode==48 || e.keyCode==96){
                     $("#numpad button[data-mode='0']").click();                                                                        
                 }
                 else if(e.keyCode==49 || e.keyCode==97){
                     $("#numpad button[data-mode='1']").click();                                                                        
                 }
                 else if(e.keyCode==50 || e.keyCode==98){
                     $("#numpad button[data-mode='2']").click();                                                                        
                 }
                 else if(e.keyCode==51 || e.keyCode==99){
                     $("#numpad button[data-mode='3']").click();                                                                        
                 }
                 else if(e.keyCode==52 || e.keyCode==100){
                     $("#numpad button[data-mode='4']").click();                                                                        
                 }
                 else if(e.keyCode==53 || e.keyCode==101){
                     $("#numpad button[data-mode='5']").click();                                                                        
                 }
                 else if(e.keyCode==54 || e.keyCode==102){
                     $("#numpad button[data-mode='6']").click();                                                                        
                 }
                 else if(e.keyCode==55 || e.keyCode==103){
                     $("#numpad button[data-mode='7']").click();                                                                        
                 }
                 else if(e.keyCode==56 || e.keyCode==104){
                     $("#numpad button[data-mode='8']").click();                                                                        
                 }
                 else if(e.keyCode==57 || e.keyCode==105){
                     $("#numpad button[data-mode='9']").click();                                                                        
                 }
                 else if(e.keyCode==190 || e.keyCode==110){
                     $("#numpad button[data-mode='.']").click();                                                                        
                 }
                 else if(e.keyCode==46){
                     $("#numpad button[data-mode='del']").click();                                                                        
                 }
                 else if(e.keyCode==9){
                     var selected_element = $(".selected-mode");
                     selected_element.removeClass("selected-mode");
                     if(selected_element.attr("data-mode")=="quantity"){
                         $("[data-mode='discount']").click();
                     }
                     else if(selected_element.attr("data-mode")=="discount"){
                         $("[data-mode='price']").click();
                     }
                     else if(selected_element.attr("data-mode")=="price"){
                         $("[data-mode='quantity']").click();
                     }
                     setTimeout('$("#aursoft_logo").focus()',10);
                 }
                 else if(e.keyCode==38){
                     var selected_li = $(".orderlines li.selected");
                     var prev_li = selected_li.prev();
                     if(prev_li.length){
                         prev_li.addClass("selected");
                         selected_li.removeClass("selected");
                     }                        
                 }
                 else if(e.keyCode==40){
                     var selected_li = $(".orderlines li.selected");
                     var next_li = selected_li.next();
                     if(next_li.length){
                         next_li.addClass("selected");
                         selected_li.removeClass("selected");
                     }
                 }
                 else if(e.keyCode==13){                        
                     aursoft_pos.paymentWindow(e);

                 }
                 else if(e.keyCode==39){
                     var selected_item = $("#products-screen-ol .selected_item");
                     if(selected_item.length==0){
                        $("#products-screen-ol li:first-child").addClass("selected_item"); 
                     }
                     else{
                         var next_item = selected_item.next();
                         if(next_item.length!==0){
                             selected_item.removeClass("selected_item");
                             next_item.addClass("selected_item");
                         }
                     }
                 }else if(e.keyCode==37){
                     var selected_item = $("#products-screen-ol .selected_item");
                     if(selected_item.length==0){
                        $("#products-screen-ol li:last-child").addClass("selected_item"); 
                     }
                     else{
                         var prev_item = selected_item.prev();
                         if(prev_item.length!==0){
                             selected_item.removeClass("selected_item");
                             prev_item.addClass("selected_item");
                         }
                     }
                 }
                 else if(e.keyCode==32){
                     $("#products-screen-ol .selected_item").click();
                 }else if(e.keyCode==27){
                     if($(".modal.in").length){
                         $(".modal.in").modal("hide");
                     }
                 }

                 e.preventDefault();
                 e.stopPropagation();
                 return false;
             }
         }            
        }        
     },
     checkTenderAmount: function(){
        var checked = true;
        if($("#customerchoosen").val()=="0"){
            var total_due = parseFloat($(".cash-received").val());
            var tendered =  parseFloat($(".cash-tendered").val());
            var difference = tendered-total_due;
            if(tendered!=0 && difference<0){
                alert('Please tender at least required cash!')
                checked = false;
            }
        }
        
        return checked;
     },
     paymentWindow: function(e){
        var total =0;                        
        $.each(invoice_list[selected_order],function(key,val){ 
            if($(".pos-mode button").hasClass("selected-mode")){
                $("#payment-discount").attr("placeholder", "Deduction in");
                $("#payment-discount_discount").attr("placeholder", "Deduction in");
                $(".discount_text").text("Deduction :");
                $(".received_text").text("Paid :");
                $(".small-text").text("(After Deduction)");
            } else {
                $("#payment-discount").attr("placeholder", "Discount in");
                $("#payment-discount_discount").attr("placeholder", "Discount in");
                $(".discount_text").text("Discount :");
                if($("#customerchoosen").val()==="0"){      
                    $(".received_text").text("Due :");
                }
                else{
                    $(".received_text").text("Received :");
                }
                $(".small-text").text("(After Discount)");
            }
            if(typeof(val)==='object'){
               var _price = parseFloat(val.a_price) * parseFloat(val.quantity);
               if(val.discount>0){
                _price = _price - (_price * (parseFloat(val.discount)/100));
               }
               total = total + _price;
            }   
         });
         total = aursoft_pos.format(total,2);
         if(parseInt(total)){
            $("#payment_modal").modal({backdrop: 'static',keyboard: false});
            $(".cash-paid").val(total);
            $("#payment-discount-total").html(total+" Rs.")
            setTimeout(function(){$(".cash-received").focus().val(total).select()},200);
            invoice_list[selected_order]["received"] = total;
            $(".cash-received")[0].select();
            $("#payment-paid-total").html(total+" Rs.");
            $("#payment-discount").val("");
            $("#payment-discount_discount").val("");
            $("#payment-remaining").html("0.00 Rs.");
            if($("#customerchoosen").val()!=="0"){                
                $(".payment-tendered").hide();
                $(".grand-total-row").show();
            }
            else{
                $(".payment-tendered input").val('0.00');
                $("#payment-change").html('');                
                if(returnMode){
                    $(".payment-tendered").hide();
                }
                else{
                    $(".payment-tendered").show();
                }
                $(".grand-total-row").hide();
            }
            
            $("#validate_payment").prop("disabled",false).removeClass("disabled");
        }  
     },
     getAllItems:function(){
       var URL = urls.get_all_items;
       jQuery.getJSON(URL,  function(tsv, state, xhr){
            all_item_list = jQuery.parseJSON(xhr.responseText);
            aursoft_pos.createItemsSearch(all_item_list);
         });  
     },
     searchItems:function(val){
       var URL = urls.search_items+"&search="+val;    
       if(searchCall){
        searchCall.abort();           
       }
       $("#search-container").width("100%");
       $("#search-container .search-loading").remove();
       $("#search-container").append($('<div class="loading search-loading"><p>Loading...</p></div>'));
       searchCall = jQuery.getJSON(URL,  function(tsv, state, xhr){
           searchCall = null;
           $("#search-container .search-loading").remove();
            all_item_list = jQuery.parseJSON(xhr.responseText);
            aursoft_pos.createItemsSearch(all_item_list);
         });  
     },
     initDragSort:function(){    
        if($.inArray(aursoft_pos.cat_id,aursoft_pos.draggableArray)==-1)
         {                                          
            aursoft_pos.draggableArray.push(aursoft_pos.cat_id);
        }
        $("#items-container .product-list").sortable({                      
        revert:false,                
        placeholder:'placeHolder',
        cursor:"move",    
                helper:"clone",
                handle: '.drag',
                scroll:false,
                appendTo:'body',
                start:function(event, ui) {
                   aursoft_pos.oldOrder=$(ui.item).parent().children().index(ui.item)+1;
                },
                stop: function( event, ui ) {
                    aursoft_pos.newOrder = $(ui.item).parent().children().index(ui.item)+1;
                    if(aursoft_pos.newOrder===aursoft_pos.oldOrder) return false;                    
                    var params = {}
                    params.new_order =aursoft_pos.newOrder;
                    params.old_order =aursoft_pos.oldOrder; 
                    params.id    =$(ui.item).attr("id").split("_")[1];
                    params.cat_id    =aursoft_pos.cat_id;
                    $.ajax({
                        type: 'POST',
                        url:  urls.set_item_order,
                        data:params,
                        success: function(data){
                            
                        }
                     });
                }
    }).disableSelection();
        
         $("#items-container .product").draggable({     
                    helper:"clone",
                    revert:"invalid",
                    cancel: ".drag",
                    opacity:0.95,
                    cursor:"move",
                    scroll:false,
                    appendTo:'body',
                    drag:function(){
                        /*if(returnMode){
                            alert('You are in sale return mode.');
                            return false;
                        }*/
                    }
            });             
    },
    initDrop:function(){
       $(".orderlines").droppable({            
            hoverClass: "state-hover",
            drop: function( event, ui ) {
                 var currentId = $(ui.draggable).attr("id");
                 if($(ui.draggable).hasClass("search")){
                     $("#search-container #"+currentId).click();
                 }
                 else{
                    $("#items-container #"+currentId).click();
                 }
                 return false;
            }
        });  
    },
    initDrag:function(){
        $("#search-container .product").draggable({     
                    helper:"clone",
                    revert:"invalid",
                    cancel: ".drag",
                    opacity:0.95,
                    cursor:"move",
                    scroll:false,
                    appendTo:'body',
                    drag:function(){
                        /*if(returnMode){
                            alert('You are in sale return mode.');
                            return false;
                        }*/
                    }
            });    
            
            
        
    },
     printDone:function(){
         pos_stat="finish";
         $(".print").removeClass("selected");
         $("#next-order").addClass("selected");
     }
     ,
     loadCustomer:function(selected_val,combo){
       if(selected_val==-1){return false;}
       
       if(cust_data['cust_'+selected_val]){
           var result = cust_data['cust_'+selected_val];
           $("#customerchoosen_chzn .chzn-single span").html($("#customerchoosen option[value='"+selected_val+"']").text());
           aursoft_pos.loadCustomerInfo(selected_val,result,combo);
       }
       else{
       $.ajax({
                type: 'GET',
                url: urls.get_customer+"&cust_id="+selected_val, 
                success: function(data){
                    var result = jQuery.parseJSON(data);
                    cust_data['cust_'+selected_val] = result;
                    aursoft_pos.loadCustomerInfo(selected_val,result,combo);
                }
          });
       }   
     },
     loadCustomerInfo:function(selected_val,result,combo){
        if(combo && invoice_list[selected_order]){
            invoice_list[selected_order]['customer'] = selected_val; 
        }
        $("#customer_id").val(selected_val);
        $("#customer_address").val(result.cust_address);
        price_level = null;
        if(result.cust_price_level){
            price_level = {}
            price_level['p_level'] = result.cust_price_level;
        }
        if(result.cust_price_level_items){
            price_level['level_items'] = result.cust_price_level_items;
        }
        if(combo){
            aursoft_pos.refreshPrice();
        }
     }
     ,
     initInvoiceDialog:function(){
          aursoft_pos.sel_invoice_id=-1;        
          aursoft_pos.setInvoiceName();
          $("#invoice_modal").modal({backdrop: 'static',keyboard: false});
          setTimeout('$("#new_invoice_name").focus().select()',100);
     },
     createNewInvoice:function(){   
          aursoft_pos.sel_invoice_id=-1;        
          aursoft_pos.setInvoiceName();
          aursoft_pos.createInvoice();
     },
     editInvoiceName:function(){
         aursoft_pos.sel_invoice_id=$(this).attr("id").split("_")[1];
         aursoft_pos.setInvoiceName();
         $("#invoice_modal").modal({backdrop: 'static',keyboard: false});
         setTimeout('$("#new_invoice_name").focus().select()',100);
     },
     deleteInvoice:function(){
        var btn_id = $(this).attr("id").split("_");
        var inv_id = btn_id[1];
        var _invoice = "order_" + inv_id;
        if(!invoice_list[_invoice].completed){
            if(confirm("Are you sure you want to delete this invoice.")){            
                delete invoice_list[_invoice];
                $("#"+_invoice).parents("li").remove();
                aursoft_pos.activateNewInvoiceDialog();
                pos_stat="";
                $.ajax({
                    type: 'POST',
                    url: urls.save_invoice,
                    data:{
                            action:"del_invoice",                       
                            invoice_id:inv_id
                    },
                    success: function(data){}
                  });
               if(btn_id[0]=="del-order"){   
                $("#backtocategory").click();   
               }
            }
        }
        else{
           if(btn_id[0]=="del-order"){   
             $("#next-order").click();   
           }
        }
     },
     closeInvoice:function(){        
        var btn_id = $(this).attr("id").split("_");
        var inv_id = btn_id[1];
        var _invoice = "order_" + inv_id;
        delete invoice_list[_invoice];
        $("#"+_invoice).parents("li").remove();
        aursoft_pos.activateNewInvoiceDialog();
        pos_stat="";            
        if(btn_id[0]=="close-order"){   
            $("#backtocategory").click();   
       }        
     }
     ,
     fetchResults:function(e){
         if(e && e.keyCode===113){
             $(this).blur();
             return false;
         }
         var search = $("#product-search").val();
         if($.trim(search)!=="" && $.trim(search).length>=3) {
            search = search.toLowerCase();
            $("#close_search").fadeIn();
            $("#items-container").hide();
            $("#search-container").show();
            aursoft_pos.searchItems(search);
            
            
            /*var found_items = $("#products-screen-ol-search li.search").filter(function() {                                                               
                return $(this).find("div.product-name").text().toLowerCase().indexOf(search) > -1;
            }).show();*/            
            
         }
         else{
            if(searchCall){
                searchCall.abort();
            }
            $("#items-container").show();
            $("#search-container").hide();
            $("#close_search").fadeOut(); 
            
         }
         e.preventDefault();
         e.stopPropagation();
         return false;
     },
     removeSearch:function(){
            $("#close_search").fadeOut(); 
            $("#product-search").val('');
            $("#items-container").show();
            $("#search-container").hide();
     }
     ,
     fetchDetails:function(){
         var cat_id = 1;
         if($(this).attr("id")){
            cat_id = $(this).attr("id").split("_")[2];
            var cat_name = $(this).text();            
            $(".category-tray").append('<li id="cat_nav_'+cat_id+'" class="oe-pos-categories-list"><img class="bc-arrow" src="themes/aursoft/images/bc-arrow.png"><a >'+cat_name+'</a></li>');
         }
         aursoft_pos.removeSearch();
         var URL = urls.details + "&cat_id=" +  cat_id;
         
         aursoft_pos.cat_id = cat_id;
         $("#cat_nav_"+cat_id).click(aursoft_pos.fetchBreadCrums);
         jQuery.getJSON(URL,  function(tsv, state, xhr){
            var _details = jQuery.parseJSON(xhr.responseText);
            aursoft_pos.createCategory( _details["cats"]);
            aursoft_pos.createItems( _details["items"]);
            aursoft_pos.initDragSort();
         });
     },
     fetchBreadCrums:function(){
         var cat_id = $(this).attr("id").split("_")[2];
         $("#cat_nav_"+cat_id).nextAll("li").remove(); 
         aursoft_pos.removeSearch();
         var URL = urls.details + "&cat_id=" +  cat_id;
         aursoft_pos.cat_id = cat_id;
         jQuery.getJSON(URL,  function(tsv, state, xhr){
            var _details = jQuery.parseJSON(xhr.responseText);
            aursoft_pos.createCategory( _details["cats"]);
            aursoft_pos.createItems( _details["items"]);
            aursoft_pos.initDragSort();
         });
     }
     ,createCategory:function(cats){
         $(".category-list").children().remove();
         for(var i=0;i<cats.length;i++){
           var cat_button= $('<li id="cat_btn_'+cats[i].id+'" class="category-simple-button">'+cats[i].name+'</li>');
           $(".category-list").append(cat_button);
         }
         $(".category-simple-button").click(this.fetchDetails);

     },
     createItems:function(_items){
        $("#products-screen-ol").children().remove();  
        items_list = _items;        
        for(var i=0;i<_items.length;i++){
            var serviceDiv = _items[i].type_id=='3'?'<div class="service"></div>':'';
            var li_item = $('<li class="product" id="item_'+_items[i].id+'" order="'+_items[i].sort_order+'"><div class="drag"></div><a href="#">'+serviceDiv+'<img src="'+_items[i].picture+'"><span class="price-tag"> '+_items[i].sale_price+' Rs. </span><span class="qty-tag"> '+_items[i].quantity+'</span></div><div class="product-name"> '+_items[i].item_name+' </div></a></li>')
            $("#products-screen-ol").append(li_item);
        }
        
        if(_items.length){
            $("#items-container .jspVerticalBar").show();
            var api = $('#items-container.content-container').data('jsp');        
            api.reinitialise();
        }
        if(_items.length==0){
            $("#items-container .jspVerticalBar").hide();
        }
        
        $("#items-container .product").click(aursoft_pos.attachItem);
     },
     createItemsSearch:function(_items){
        $("#products-screen-ol-search").children().remove();  
        all_item_list = _items;        
        var length = _items.length>50?50:_items.length;
        for(var i=0;i<length;i++){
            var serviceDiv = _items[i].type_id=='3'?'<div class="service"></div>':'';
            var li_item = $('<li class="product search" id="item_'+_items[i].id+'" order="'+_items[i].sort_order+'"><a href="#">'+serviceDiv+'<img src="'+_items[i].picture+'"><span class="price-tag"> '+_items[i].sale_price+' Rs. </span><span class="qty-tag"> '+_items[i].quantity+'</span></div><div class="product-name"> '+_items[i].item_name+' </div></a></li>')
            $("#products-screen-ol-search").append(li_item);
        }
                
        if(_items.length){
            $("#search-container .jspVerticalBar").show();
            var api = $('#search-container.content-container').data('jsp');        
            api.reinitialise();
        }
        if(_items.length==0){
            $("#search-container .jspVerticalBar").hide();
        }
        
        $("#search-container .product").click(aursoft_pos.attachItem);
        aursoft_pos.initDrag();
     },
     drawSearchItems:function(){
         
     },
     saveItems:function(_data){
          $.ajax({
                type: 'POST',
                url: urls.save_invoice,
                data:_data,
                success: function(data){
                    var result = jQuery.parseJSON(data);     
                    invoice_list[selected_order]["invoice_no"] = result["invoice_no"]
                }
          });
     },
     deleteItem:function(item_id){
         $.ajax({
                type: 'POST',
                url: urls.delete_item_invoice,
                data:{
                    "invoice_id":selected_order.split("_")[1],
                    "item_id":item_id
                },
                success: function(data){
                    
                }
          });
     },
     attachItem:function(){
         /*if(returnMode){
             alert('You are in sale return mode.')
             return;
         }*/
         var item_id = $(this).attr("id").split("_")[1];
         var search = $(this).hasClass("search")?true:false; 
         var item_obj = aursoft_pos.getItem(item_id,search);
         var unit_id = item_obj.sale_unit;
         var _item_id = aursoft_pos.checkItemExists(item_id,unit_id);
         if(_item_id){
             var quantity =parseFloat(invoice_list[selected_order][_item_id]["quantity"]);
             invoice_list[selected_order][_item_id]["quantity"] = quantity +1;
             selected_item = "invoice_item_"+item_id;
         }
         else{
             var sale_default_unit =item_obj.sale_unit; 
             for(var i=0;i<item_obj.item_unit.length;i++){
                 if(item_obj.sale_unit==item_obj.item_unit[i].unit_id){
                    item_obj.sale_unit = item_obj.item_unit[i].unit_id;
                    item_obj.unit_name = item_obj.item_unit[i].unit_name;
                    item_obj.sale_price = item_obj.item_unit[i].sale_price;
                    item_obj.conv_from = item_obj.item_unit[i].conv_from;
                    item_obj.qty = item_obj.quantity/item_obj.item_unit[i].conv_from;
                    // item_obj.normal_price = item_obj.item_unit[i].normal_price;
                    item_obj.normal_price = item_obj.avg_cost*item_obj.item_unit[i].conv_from;
                    item_obj.base_avg_cost = item_obj.avg_cost;
                 }
             }
                
           var s_price = item_obj.sale_price;
            if(price_level){
               s_price =  aursoft_pos.getAdjustedPrice(item_obj);
            }
            invoice_list[selected_order][aursoft_pos.getTimeStamp()+"_"+item_id] = {"name":item_obj.item_name,"id":item_obj.id,"quantity":1,"normal_price":item_obj.normal_price,"price":aursoft_pos.format(s_price,2),"a_price":item_obj.sale_price,"sale_price":item_obj.sale_price,"discount":0,"isChanged":false,"t_discount":0,barcode:item_obj.item_code,quantity_on_hand:item_obj.qty,unit_qty:item_obj.qty,conv_from:item_obj.conv_from,uom_unit:sale_default_unit,unit_name:item_obj.unit_name,sale_uom_default:sale_default_unit,uom_unit_array:item_obj.item_unit};            
            selected_item = null;
         }         
         if(!invoice_list[selected_order]['customer']){
           invoice_list[selected_order]['customer'] = $("#customerchoosen").val();
         }
         if(!invoice_list[selected_order]['dateCreated']){
             invoice_list[selected_order]['dateCreated'] = aursoft_pos.getDateTime();
         }
         aursoft_pos.drawInvoice();
            var _tot = $("#total_sale").text().substring(0,$("#total_sale").text().length-4);
            if(isDisplayPole){      
                $.ajax({
                    type: 'GET',
                    url: urls.display_total,
                    data:{port:port,command:'price',total:aursoft_pos.format(item_obj.sale_price,2),ttext:'Price',gtotal:_tot},
                    success: function(data){

                    }
              }); 
            }
     },
     scanItem:function(val){         
         var item_code = val?val:$("#barcode-textfield").val();         
         if(item_code && item_code.indexOf("+")==-1){
             var URL = urls.scan_item + "&barcode=" +  item_code;
             jQuery.getJSON(URL,  function(tsv, state, xhr){
               var _item = jQuery.parseJSON(xhr.responseText);
               if(_item.item_id){
                    for(var i=0;i<_item.item_unit.length;i++){
                        if(_item.item_uom==_item.item_unit[i].uom_id){
                            _item.sale_unit = _item.item_unit[i].unit_id;
                            _item.sale_price = _item.item_unit[i].sale_price;
                            _item.qty = _item.quantity/_item.item_unit[i].conv_from;
                            // _item.normal_price = _item.item_unit[i].normal_price;
                            _item.normal_price = _item.avg_cost*_item.item_unit[i].conv_from;
                            _item.base_avg_cost = _item.avg_cost;
                        }
                    }
                aursoft_pos.displayItem(_item);
                setTimeout('$("#barcode-textfield").val("")',300);
               }
               else{
                   $("#barcode-textfield").val('');
                   if(confirm("Item not found, Do you want to add it?")){
                       $("#new_item_modal input").val('');
                       $("#new_item_modal").modal({backdrop: 'static',keyboard: false});
                       setTimeout(function(){
                           $("#newitem-itemname").focus();
                           $("#newitem-barcode").val(item_code);
                       },100);
                   }
               }
            });
         }
         else{
             $("#barcode-textfield").val('').focus();
         }
     },
     displayItem:function(_item){
        
        var _id = _item.id ? _item.id:_item.item_id;
        var _item_unit = _item.sale_unit;
        var _item_id = aursoft_pos.checkItemExists(_id,_item_unit);  
        var s_price = 0; 
        if(_item_id){
             var quantity =parseFloat(invoice_list[selected_order][_item_id]["quantity"]);
             invoice_list[selected_order][_item_id]["quantity"] = quantity +1;
             s_price = parseFloat(invoice_list[selected_order][_item_id]["price"]);
             selected_item = "invoice_item_"+_id;
         }
         else{
             var sale_default_unit =_item.sale_unit; 
             for(var i=0;i<_item.item_unit.length;i++){
                 if(_item.sale_unit==_item.item_unit[i].unit_id){
                    _item.sale_unit = _item.item_unit[i].unit_id;
                    _item.unit_name = _item.item_unit[i].unit_name;
                    _item.conv_from = _item.item_unit[i].conv_from;
                    _item.sale_price = _item.item_unit[i].sale_price;
                    _item.qty = _item.quantity/_item.item_unit[i].conv_from;
                    // _item.normal_price = _item.item_unit[i].normal_price;
                     _item.normal_price = _item.avg_cost*_item.item_unit[i].conv_from;
                    _item.base_avg_cost = _item.avg_cost;
                 }
             }
            s_price = _item.sale_price;
            if(price_level){
               s_price =  aursoft_pos.getAdjustedPrice(_item);
            }
            invoice_list[selected_order][aursoft_pos.getTimeStamp()+"_"+_id] = {"name":_item.item_name,"id":_id,"quantity":1,"normal_price":_item.normal_price,"price":aursoft_pos.format(s_price,2),"a_price":_item.sale_price,"sale_price":_item.sale_price,"discount":0,"isChanged":false,"t_discount":0,barcode:_item.item_code,quantity_on_hand:_item.qty,unit_qty:_item.qty,conv_from:_item.conv_from,uom_unit:sale_default_unit,unit_name:_item.unit_name,sale_uom_default:sale_default_unit,uom_unit_array:_item.item_unit};
            selected_item = null;
         }
         if(!invoice_list[selected_order]['customer']){
             invoice_list[selected_order]['customer'] = $("#customerchoosen").val();
         }
         if(!invoice_list[selected_order]['dateCreated']){
             invoice_list[selected_order]['dateCreated'] = aursoft_pos.getDateTime();
         }

        aursoft_pos.drawInvoice();
        var _tot = $("#total_sale").text().substring(0,$("#total_sale").text().length-4);
        if(isDisplayPole){      
            $.ajax({
                           type: 'GET',
                           url: urls.display_total,
                           data:{port:port,command:'price',total:aursoft_pos.format(s_price,2),ttext:'Price',gtotal:_tot},
                           success: function(data){                                             
                           }
             });
        }
         setTimeout("$('#product-search-list').typeahead('val', '');",50);
     },
     getAdjustedPrice:function(item){
         var price = parseFloat(item.sale_price);
         if(price_level && !aursoft_pos.isOrderCompleted()){
             var sale_price = item.sale_price;
             var percentage_of = price_level.p_level.level_per;
             var adjust =price_level.p_level.level_dir;            
             
             var diff = parseFloat(sale_price) * (parseFloat(percentage_of)/100); 
             
             if(price_level.p_level.level_type=="2"){
                sale_price = (price_level.p_level.level_compare_price=="1")?item.sale_price:item.normal_price;                
                var itemExists = false;
                var _per = 0;
                for(var i=0;i<price_level.level_items.length;i++){
                    if(price_level.level_items[i].item_id==item.id){
                        itemExists = true;
                        _per = price_level.level_items[i].item_per_level;
                        break;
                    }
                }
                if(itemExists){
                    diff = parseFloat(sale_price) * (parseFloat(_per)/100); 
                    price = parseFloat(item.sale_price) + diff;
                }
             }
             else{
                
                 price = parseFloat(item.sale_price) + (parseFloat(adjust)*diff);
             }
             
             
             
         }
         return price.toFixed(2);
     },
     refreshPrice : function(){
         $.each(invoice_list[selected_order],function(key,val){    
            if(typeof(val)==='object'){              
             var _item ={
                 "sale_price": invoice_list[selected_order][key].a_price,
                 "normal_price": invoice_list[selected_order][key].normal_price,
                 "id": invoice_list[selected_order][key].id
             };
             
             invoice_list[selected_order][key].price = aursoft_pos.getAdjustedPrice(_item);
            }
         });
         
        aursoft_pos.drawInvoice();  
     }
     ,
     drawInvoice:function(){
        var total = 0;
        
        json_string ="[";
        $(".orderlines").children().remove();
        var li_no = 0;
        var _price = 0;
        $.each(invoice_list[selected_order],function(key,val){          
            if(typeof(val)==='object'){
                if(parseFloat(val.t_discount)==0 && parseFloat(val.sale_price)>0){
                    val.discount = ((parseFloat(val.sale_price)-parseFloat(val.price))/parseFloat(val.sale_price)) * 100;                    
                }
                else{
                    val.discount =parseFloat(val.t_discount);
                }
                if(val.discount<0){
                    val.discount = 0;
                    val.a_price = parseFloat(val.price);
                }
                if(parseFloat(val.a_price)>parseFloat(val.sale_price) && parseFloat(val.a_price)!==parseFloat(val.price)){
                    _price = parseFloat(val.sale_price) * parseFloat(val.quantity);
                    val.a_price = parseFloat(val.sale_price)
                }
                else{
                    _price = parseFloat(val.a_price) * parseFloat(val.quantity);
                }
                json_string +=JSON.stringify(val)+",";            
                var li_detail ="";
                if(parseFloat(val.quantity)> 0 || val.uom_unit_array.length > 1){
                    var selected_val = "";
                    var unit_text = "";
                    if(val.uom_unit_array.length>1){
                    var select_box = "<select id='selected_unit_combo' class='selected_unit_combo' style='width:100px' data-unit='"+val.uom_unit+"'>";
                    for(var i=0;i<val.uom_unit_array.length;i++){                        
                        if(val.uom_unit==val.uom_unit_array[i].unit_id){
                            selected_val = "selected='selected'";
                            var unit_text = val.uom_unit_array[i].unit_name;
                            select_box += "<option value="+val.uom_unit_array[i].unit_id+" "+selected_val+" >"+val.uom_unit_array[i].unit_name+"</option>";
                        } else { 
                            selected_val = "";
                        select_box += "<option value="+val.uom_unit_array[i].unit_id+" >"+val.uom_unit_array[i].unit_name+"</option>";
                        }
                        
                    }
                        select_box += "</select>";
                    li_detail +='<li class="info"><em>'+parseFloat(val.quantity)+'</em> '+select_box+' '+_labels.text_at+' '+aursoft_pos.format(parseFloat(+val.a_price),2)+' Rs. / '+unit_text+'</li>'
                   }
                   else{
                       if(parseFloat(val.quantity)>1){
                        li_detail +='<li class="info"><em>'+parseFloat(val.quantity)+'</em> '+ _labels.text_units +' '+_labels.text_at+' '+aursoft_pos.format(parseFloat(+val.a_price),2)+' Rs. / '+_labels.text_units+'</li>'
                       }
                       else{
                        li_detail +='';   
                       }
                   }
                }
                if(parseFloat(val.discount)>100 ){
                   val.discount =100;  
                }                
                if(parseFloat(val.discount)!==0){
                    li_detail +='<li class="info">'+_labels.text_with+' '+_labels.text_a+' <em>'+aursoft_pos.format(parseFloat(val.discount),2)+' %</em> '+_labels.text_discount.toLowerCase()+' </li>'
                    _price = _price - (_price * (parseFloat(val.discount)/100));
                }
                
                total = total + _price;
                var lowQtyClass= (returnMode==false && parseFloat(val.quantity_on_hand) - parseFloat(val.quantity) <0) ? "low-quantity":"";
                var li_html = $('<li class="orderline '+lowQtyClass+'" id="invoice_item_'+val.id+'" data-itemcode="'+key+'"><div class="info-icon" style="display:inline-block"><i class="icon-star"></i></div><span class="product-name">'+val.name+'</span><span class="price">'+aursoft_pos.format(_price,2)+' Rs.</span><ul class="info-list">'+li_detail+'</ul></li>');
                $(".orderlines").append(li_html); 
                li_html.find(".selected_unit_combo").change(aursoft_pos.changeUOMValue);
                li_no = li_no +1; 
                $(".selected_unit_combo").chosen({
            disable_search_threshold: 10,
            width:100
          });
            }            
        });
        if(selected_item){            
            $(".orderlines #"+selected_item).addClass("selected");
            var container = $('.orderlines'),
                scrollTo =  $(".orderlines #"+selected_item);

            container.scrollTop(
                scrollTo.offset().top - container.offset().top + container.scrollTop()
            );
        }
        else{
            $(".orderlines .orderline:last").addClass("selected");
            $(".orderlines").scrollTop($(".orderlines")[0].scrollHeight);
        }
        $("#total_sale").html(total.toFixed(2)+" Rs.");
        if(total==0 && li_no==0){
            $(".orderlines").append('<li class="empty" style="margin-top:15px">'+_labels.empty_cart+'</li>');
            var json_to_save = {
                                "action":"sale",
                                "invoice_total":total,
                                "cust_id":'0',
                                "sales_detail":'[]',
                                "invoice_date":aursoft_pos.getDateMysqlFormatWithTime(new Date()),
                                "invoice_id":selected_order.split("_")[1],
                                "invoice_status":"0",
                                "invoice_paid":"0"
                               };
            $(".paypad-button[cash-register-id=1]").prop("disabled",true).addClass("disabled");                    
        }
        else{
            $(".orderlines li").click(aursoft_pos.selectInvoiceItem);
            $(".info-icon").mouseover(function(){            
                var offset = $(this).offset();
                var li_parent = $(this).parents(".orderline");
                var selected_item = invoice_list[selected_order][li_parent.attr("data-itemcode")];
                console.log(selected_item)
                var purchase_cost = selected_item.normal_price , qty_on_hand=selected_item.unit_qty, bar_code =selected_item.barcode;                      
                $(".popover-title").html("Item Info.");
                $(".popover-content").html("<div>Purchase Cost: "+aursoft_pos.format(purchase_cost,2)+" Rs.</div><div>Qty on Hand: "+aursoft_pos.format(qty_on_hand,2)+"</div><div>Bar Code: "+bar_code+" </div>")
                $(".popover").fadeIn("fast").css({top:offset.top-80,left:offset.left+20}); 

             }).mouseout(function(){
                 $(".popover").hide();
             });
            json_string = json_string.substring(0,json_string.length-1);
            json_string +="]"
            var json_to_save = {
                "action":"sale",
                "invoice_total":total,
                "cust_id":invoice_list[selected_order]['customer'],
                "sales_detail":json_string,
                "invoice_date":aursoft_pos.getDateMysqlFormatWithTime(new Date()),
                "invoice_id":selected_order.split("_")[1],
                "invoice_status":(aursoft_pos.isOrderCompleted())?"2":"1",
                "invoice_paid":"0"
               };
            $(".paypad-button[cash-register-id=1]").prop("disabled",false).removeClass("disabled");
        }
        
        if(typeof(invoice_list[selected_order]["received"])=="undefined"){
            $(".cash-received,#payment-discount").val('');
            $("#payment-paid-total,#payment-change,#payment-remaining").html("0.00 Rs.");
            
        }
        else{
            $(".cash-received").val(invoice_list[selected_order]["received"]);
            aursoft_pos.calcCash();
            
        }
       
        json_to_save['returnMode'] = returnMode ? 1:"";
        //if(total!==0){
            aursoft_pos.saveItems(json_to_save);
        //}
       
     },
     isOrderCompleted:function(){
       return $(".selected-order").parent(".btn-group").hasClass("complete") ;
     },
     validate_cash:function(printOnly,invoiceName){
        if(!printOnly){
            var total = parseFloat($("#total_sale").text());
            if(total<=0){
                alert("Inovice Total cannot be 0.");
                return false;
            }
            else{
                var recevied_total = parseFloat($(".cash-received").val());
                if(total>0 && (recevied_total==0 || isNaN(recevied_total) )){
                 //$(".cash-received").val(aursoft_pos.format(total,2));    
                 invoice_list[selected_order]["received"] =  aursoft_pos.format(total,2);
                }
            }
        }
        aursoft_pos.hideAll();
        $(".payment").hide();
        aursoft_pos.disableAction();
        $("#receipt-screen,.pos-actionbar").fadeIn(function(){
            var scrollHeight = $("#receipt-screen").height()-($("#receipt-screen header").height()+2);
            $("#receipt-screen .pos-scroll-bar").height(scrollHeight);
        });
        if(invoice_list[selected_order]["completed"]){
            $(".print").fadeIn();
            $("#backtocategory").hide();
        }
        else{
            $(".print,#backtocategory").fadeIn();
        }
        $(".print").removeClass("selected");
        $("#receipt-print-next").addClass("selected");
        $(".cancel-order").attr("id","del-"+selected_order);
        var _recptdata = "";
        var __recptdata= "";
        
        var total=0, _total_qty =0;
        var total_discount_val = 0;
        var sub_total_price = 0;
        var item_qty = 0;
        $.each(invoice_list[selected_order],function(key,val){
           
            if(typeof(val)==='object'){             
                var  _unit = "";
                for(var i=0;i<val.uom_unit_array.length;i++){
                    if(val.uom_unit==val.uom_unit_array[i].unit_id){
                        _unit =  val.uom_unit_array[i].unit_name;
                    }
                }
                // Don't show each in print invoice
                if(val.uom_unit_array.length>1){
                    _unit = "("+_unit+")";
                }
                else{
                    _unit = "";
                }
                var _price = parseFloat(val.a_price) * parseFloat(val.quantity);
                var discount_text = '';            
                if(val.discount>0){                 
                    var discounted_val = (_price * (parseFloat(val.discount)/100));
                    total_discount_val = total_discount_val + discounted_val;
                    _price = _price - discounted_val;
                    if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){ 
                        discount_text = '<div class="discount_small">'+_labels.text_with+' '+aursoft_pos.format(val.discount,2)+'% Deduction</div>';
                        } else {
                        discount_text = '<div class="discount_small">'+_labels.text_with+' '+aursoft_pos.format(val.discount,2)+'% '+_labels.text_discount+'</div>';
                    }

                }
                _total_qty = _total_qty + parseFloat(val.quantity);
                total = total + _price;
                sub_total_price = sub_total_price +  parseFloat(val.a_price);
                if($(".pos-mode button").hasClass("selected-mode")){
                    item_qty = (val.quantity)*(-1);
                } else {
                    item_qty = val.quantity;
                }
                _recptdata +='<tr><td class="td-description">'+val.name+'<span class="small-text"> '+_unit+' </span>'+discount_text+'</td><td class="pos-right-align qty">'+aursoft_pos.format(item_qty,1)+'</td><td class="pos-right-align pad1 rate">'+aursoft_pos.format(parseFloat(val.a_price),2)+'</td><td class="pos-right-align amount">'+aursoft_pos.format(_price,2)+'</td></tr>';
                __recptdata+='<tr><td class="td-description">'+val.name+'<span class="small-text"> '+_unit+' </span>'+'</td><td class="td-qty">'+aursoft_pos.format(item_qty)+'</td><td class="td-price">'+aursoft_pos.format(val.a_price,2)+'</td><td class="td-amount">'+aursoft_pos.format(_price,2)+'</td></tr>';
            }
        });        
        var discount = invoice_list[selected_order]["invoice_discount"]?parseFloat(invoice_list[selected_order]["invoice_discount"]):0;
        var txt_discount = parseFloat($("#payment-discount").val());
        if(txt_discount){
            discount = txt_discount;
        } 
        if($(".pos-mode button").hasClass("selected-mode")){
            $("#sub_total_recpt,.total_large_recpt").html( aursoft_pos.format((-1)*total,2) +" Rs.");
            $("#journal_total_recpt,#total_recpt,.total_recpt_large").html(aursoft_pos.format((-1)*(total-discount),2) +" Rs.");
            $(".invoice-discount-deduction").html("Deduction on Invoice:");
        } else if(invoiceName=="Sale Return"){
            $("#sub_total_recpt,.total_large_recpt").html( aursoft_pos.format(total,2) +" Rs.");
            $("#journal_total_recpt,#total_recpt,.total_recpt_large").html(aursoft_pos.format(total+discount,2) +" Rs.");
            $(".invoice-discount-deduction").html("Deduction on Invoice:");
        } else {
            $("#sub_total_recpt,.total_large_recpt").html( aursoft_pos.format(total,2) +" Rs.");
            $("#journal_total_recpt,#total_recpt,.total_recpt_large").html( aursoft_pos.format(total-discount,2) +" Rs.");
            $(".invoice-discount-deduction").html("Discount on Invoice:");
        }
        if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){
            if(total_discount_val){
                $(".item_discounts").html("Items Deduction: "+aursoft_pos.format(total_discount_val,2));
                $(".discount-explain").html("("+aursoft_pos.format(total+total_discount_val,2)+" - "+aursoft_pos.format(total_discount_val,2)+")")
                }
                else{
                    $(".item_discounts").html("");
                    $(".discount-explain").html("");
                }
            
        } else {
            if(total_discount_val){
                $(".item_discounts").html("Items Discount: "+aursoft_pos.format(total_discount_val,2));
                $(".discount-explain").html("("+aursoft_pos.format(total+total_discount_val,2)+" - "+aursoft_pos.format(total_discount_val,2)+")")
                }
                else{
                    $(".item_discounts").html("");
                    $(".discount-explain").html("");
                }
            
        }
        
        $(".discount").html(aursoft_pos.format(discount,2) +" Rs.");
        $(".rate_qty_total").html(aursoft_pos.format(total+total_discount_val,2));
        $("#receipt-body").html(_recptdata);
        $(".receipt-large-body").html(__recptdata);
        $(".sub_total_qty").html(aursoft_pos.format(_total_qty,2));
        
                
        $(".invoice-no").html(aursoft_pos.pad(aursoft_pos.order_no,4));
                
        
        if(parseFloat($(".cash-tendered").val())==0){
            $("#total_cash").html($(".cash-received").val() +" Rs.");
            $("#total_change").html('0.00 Rs.');
        }
        else{
            $("#total_cash").html($(".cash-tendered").val() +" Rs.");
            $("#total_change").html($("#payment-change").html());
        }
        
        
        if($("#customerchoosen").val()=="0" && invoice_list[selected_order]['customer']=="0"){
            $("#print_paid").hide();            
            $("#print_remining").hide();
            if(returnMode){
               $(".cash-fields").hide();
            }
            else{
               $(".cash-fields").show(); 
            }
            
        }  else if($("#customerchoosen").val()!="0" && invoice_list[selected_order]['customer']=="0") {
                $("#print_paid").show();
                $(".cash-fields").hide();
                $("#print_remining").show();
            if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){
                $("#total_paid_print").html("-"+ aursoft_pos.format($(".cash-received").val(),2) + " Rs");
                $("#total_remaining_print").html("-"+ aursoft_pos.format($("#payment-remaining").text(),2) + " Rs");
            }else{
                $("#total_paid_print").html(aursoft_pos.format($(".cash-received").val(),2) + " Rs");
                $("#total_remaining_print").html(aursoft_pos.format($("#payment-remaining").text(),2) + " Rs");
            }    
                    
        } else if($("#customerchoosen").val()!="0" && invoice_list[selected_order]['customer']!="0") {
                $("#print_paid").show();
                $(".cash-fields").hide();
                $("#print_remining").show();
             if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){                 
                $("#total_paid_print").html("-"+ aursoft_pos.format($(".cash-received").val(),2) + " Rs");
                $("#total_remaining_print").html("-"+ aursoft_pos.format($("#payment-remaining").text(),2) + " Rs");
            }else{
                $("#total_paid_print").html(aursoft_pos.format($(".cash-received").val(),2) + " Rs");
                $("#total_remaining_print").html(aursoft_pos.format($("#payment-remaining").text(),2) + " Rs");
            }
        } else if($("#customerchoosen").val()=="0" && invoice_list[selected_order]['customer']!="0") {
                $("#print_paid").show();
                $(".cash-fields").hide();
                $("#print_remining").show();
            if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){                
                $("#total_paid_print").html("-"+ aursoft_pos.format(invoice_list[selected_order]["invoice_paids"], 2) + " Rs");
                $("#total_remaining_print").html("-"+ aursoft_pos.format(invoice_list[selected_order]["invoice_remaining"], 2) + " Rs");
            }else{
                $("#total_paid_print").html(aursoft_pos.format(invoice_list[selected_order]["invoice_paids"], 2) + " Rs");
                $("#total_remaining_print").html(aursoft_pos.format(invoice_list[selected_order]["invoice_remaining"], 2) + " Rs");
            }    
                    
        } else {
            $(".cash-fields").show();
            $("#print_paid").hide();
            $("#print_remining").hide();
        }
        if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){
            if(!printOnly){
                $("#inv_header").html("<div style='float:left'>"+$("#"+selected_order).html()+"</div>   Sale Return Invoice#:"+aursoft_pos.pad(invoice_list[selected_order]["invoice_no"],4));
            }
            else{
                $("#inv_header").html("<div style='float:left'>"+invoiceName+"</div>   Sale Return Invoice#:"+aursoft_pos.pad(invoice_list[selected_order]["invoice_no"],4));
            }
        } else {
            if(!printOnly){
                $("#inv_header").html("<div style='float:left'>"+$("#"+selected_order).html()+"</div>   "+_labels.text_invoice+":"+aursoft_pos.pad(invoice_list[selected_order]["invoice_no"],4));
            }
            else{
                $("#inv_header").html("<div style='float:left'>"+invoiceName+"</div>   "+_labels.text_invoice+":"+aursoft_pos.pad(invoice_list[selected_order]["invoice_no"],4));
            }
        }
        
        $(".print-invoice-date").html(aursoft_pos.getDateTime());
        $(".invoice-date").html(invoice_list[selected_order]["dateCreated"]);
        if($(".pos-mode button").hasClass("selected-mode") || invoiceName=="Sale Return"){
                $("#money_saved").html("");
            } else {
                if(total_discount_val > 0){
                    $("#money_saved").html("You saved "+aursoft_pos.format(total_discount_val+discount,2)+" Rs. today. <br/>");
                }
                else{
                    $("#money_saved").html("");
                }
            }
        if(invoice_list[selected_order].completed){
            $(".cash-fields").hide();
        }
        if($("#customer_id").val()=="0"){
            $(".bill_to").html("Walk In Customer "+"("+$("#"+selected_order).html()+")");
        }
        else{
            var address_str = $("#customer_name").html() +"<br/>";
            address_str += aursoft_pos.filter($("#customer_address").val());                        
            $(".bill_to").html(address_str);    
        }  
        pos_stat = "print_next";
        return true;
     },
     calcCash:function(obj,e){
         if(e && e.which == 13) {
             $(".cash-received").blur();
             $("#validate_payment").click();
             return;
         }
         else if(e && e.which==27){
             $("#payment_modal").modal("hide");
             return;
         }
         var paid = (obj)?$(obj).val():parseFloat($(".cash-received").val());
         $("#payment-paid-total").html(paid+" Rs.");
         var total = parseFloat($("#total_sale").text());
         if(total==0){
             $(".cash-received,#payment-discount,#payment-discount_discount").val("");
            $("#payment-paid-total,#payment-remaining,#payment-change").html("0.00 Rs.");
            $("#validate_payment").removeClass("disabled");
         }
        
     },
     selectInvoiceItem:function(){
         $(".orderlines li").removeClass("selected");
         $(this).addClass("selected");
     }
     ,
     getItem:function(item_id,search){
         var obj_item = null;
         var items = (search)?all_item_list:items_list;
         for(var i=0;i<items.length;i++){
             if(items[i].id==item_id){
                 obj_item = items[i];
                 break;
             }
         }
         return obj_item;
     }
     ,hideAll:function(){
         $(".screen,.pos-actionbar").hide();
     },
     changeUOMValue: function(){
        var id = $(".orderlines li.selected").attr("id").split("_")[2];
        var search = $(".orderlines li.selected").hasClass("search")?true:false; 
        var item_obj = aursoft_pos.getItem(id,search);
        var unit_id = $(this).data("unit");
        var id = aursoft_pos.checkItemExists(id,unit_id);
        var selected_item = invoice_list[selected_order][id];
        selected_item["uom_unit"] = $(this).val();        
        $(this).data("unit",$(this).val());
        var sale_price = selected_item["sale_price"];
        console.log(selected_item["unit_qty"]);
        $.each(selected_item["uom_unit_array"], function( i, val ) {
            if(val.unit_id===selected_item["uom_unit"]){
                 sale_price = val.sale_price;
                 selected_item["unit_qty"] = aursoft_pos.format(selected_item["quantity_on_hand"]/val.conv_from,2);
                 // selected_item["normal_price"] = val.normal_price;
                 selected_item["normal_price"] = aursoft_pos.format(selected_item["base_avg_cost"]*val.conv_from,2)
                 selected_item["conv_from"] = val.conv_from;
            }
        });
        var pre_val = selected_item["sale_price"];
        selected_item["sale_price"] = sale_price;        
        selected_item["a_price"] = sale_price;
        selected_item["price"] = sale_price;
        
        if(pre_val!=sale_price){
            aursoft_pos.drawInvoice();
        }
     },
     handleKeyPad:function(e){
         var flag= true;
         if($(".orderlines li.selected").length){
            var keyType = $(this).attr("id");
            selected_item = $(".orderlines li.selected").attr("id");
            if(keyType=="numpad-backspace"){
                aursoft_pos.backSpace()    
            }else if(keyType=="numpad-minus"){
                aursoft_pos.changeSign();
            }
            else if($(this).attr("data-mode")){
                var val = $(this).text();
                flag = aursoft_pos.numKey(val);
            }
            else{
                flag=false;
            }
            if(flag){
                aursoft_pos.drawInvoice();
                var _tot = $("#total_sale").text().substring(0,$("#total_sale").text().length-4);
                var _price = $("li.orderline.selected .price").text().substring(0,$("li.orderline.selected .price").text().length-4);
                if(isDisplayPole){      
                    $.ajax({
                            type: 'GET',
                            url: urls.display_total,
                            data:{port:port,command:'price',total:aursoft_pos.format(_price,2),ttext:'Price',gtotal:_tot},
                            success: function(data){

                            }
                      });
                }
            }                        
         }
         $(".input-button").blur();
     },
     numKey:function(val){
        var id = $(".orderlines li.selected").attr("id").split("_")[2];
        var unit_id = $(".orderlines li.selected .selected_unit_combo").val(); 
        var id = aursoft_pos.checkItemExists(id,unit_id);
        var drawInvoice = true;
         
         var mode = this.getMode();         
         var previousVal = invoice_list[selected_order][id][mode];
         if(invoice_list[selected_order][id]["isChanged"]){
            invoice_list[selected_order][id][mode] = invoice_list[selected_order][id][mode] + "" +val;
         }
         else{
            invoice_list[selected_order][id][mode] = val;
            invoice_list[selected_order][id]["isChanged"] = true;
         }    
         if(mode=="price"){
             invoice_list[selected_order][id]["t_discount"]=0;
         }
         else if(mode=="discount") {
             invoice_list[selected_order][id]["price"]=invoice_list[selected_order][id]["a_price"];
         }
         var value = invoice_list[selected_order][id][mode];
         var val = value.split(".");
             val =  val[0].toString().length;
         if(mode=="quantity"){             
             if(val>5){
                 drawInvoice=false;
             invoice_list[selected_order][id][mode] = previousVal;
            }
         }
         else if(mode=="price"){
             if(val>6){
                 drawInvoice=false;
                 invoice_list[selected_order][id][mode] = previousVal;
            }
         }
         
         return drawInvoice;
     }
     ,
     getMode:function(){
         var mode = $(".function.selected-mode").attr("data-mode");
         mode = mode=="discount"?"t_discount":mode;
         return mode;
     },
     changeSign:function(){
        var mode = this.getMode(); 
        var id = $(".orderlines li.selected").attr("id").split("_")[2];
        var unit_id = $(".orderlines li.selected .selected_unit_combo").val(); 
        var id = aursoft_pos.checkItemExists(id, unit_id);       
        var val = ""+invoice_list[selected_order][id][mode];
        if(val.indexOf("-")==-1){
             invoice_list[selected_order][id][mode] = "-"+val;
        }
        else{
            invoice_list[selected_order][id][mode] = val.replace("-","");
        }
         
     },
     backSpace:function(){
         var id = $(".orderlines li.selected").attr("id").split("_")[2]; 
        var unit_id = $(".orderlines li.selected .selected_unit_combo").val();
        var id = aursoft_pos.checkItemExists(id,unit_id);
        
         var mode = this.getMode();
         var val = ""+invoice_list[selected_order][id][mode];
         if(mode=="quantity" && invoice_list[selected_order][id][mode].length==1 && parseFloat(invoice_list[selected_order][id][mode])>1){
            invoice_list[selected_order][id][mode] = "1"; 
         }
         else{
            invoice_list[selected_order][id][mode] = val.substr(0,val.length-1);
         }
         
         var _selected_val = invoice_list[selected_order][id][mode];
         if(_selected_val.substr(_selected_val.length-1)=='.'){
             invoice_list[selected_order][id][mode] = _selected_val.substr(0,_selected_val.length-1);
         }
         
         
         if(invoice_list[selected_order][id][mode].length==1 && parseFloat(invoice_list[selected_order][id][mode])==1 && mode!=="price"){
             invoice_list[selected_order][id]["isChanged"] = false;
         }
         
         if(invoice_list[selected_order][id][mode].length===0){
             invoice_list[selected_order][id][mode] = "0";
             if(mode=="quantity"){
                 delete invoice_list[selected_order][id];
                 selected_item = null;                
             }
         }
         
     },
     setInvoiceName:function(){
         var _name = "";
         var number = $("#orders > li").length+1;
         if(aursoft_pos.sel_invoice_id==-1){
             _name = _labels.text_untitled+" "+number;
             $("#invoice_btn").html("New Invoice");
         }
         else{
             _name = $("#order_"+aursoft_pos.sel_invoice_id).html();
             $("#invoice_btn").html("Rename");
         }
         $("#new_invoice_name").val(_name);
     },
     createInvoice:function(){
         setStoreName();
         var invoiceName = $.trim($("#new_invoice_name").val());
         var invoic_action = 'new';
         if(invoiceName){
           if(aursoft_pos.sel_invoice_id==-1){
               $(".loading").show();                
                selected_item = null;
                $(".selected-order").removeClass("selected-order"); 
                $(".active_invoice").removeClass("active_invoice"); 
                var invoiceTab = $('<li class="order-selector-button active_invoice"><div class="btn-group"><button class="btn selected-order" id="order_temp">'+invoiceName+'</button><button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li id="order-rename_temp"><a href="#">'+_labels.text_rename+'</a></li><li id="order-del_temp"><a href="#">'+_labels.text_delete+'</a></li><li id="order-close_temp"><a href="#">'+_labels.text_hold+'</a></li></ul></div></li>');
                $("#orders").append(invoiceTab);  
                
                $("#customerchoosen").val('0');
                $("#customerchoosen_chzn .chzn-single span").html($("#customerchoosen option[value='0']").text());                                
                aursoft_pos.loadCustomer('0');
                                
                aursoft_pos.hideAll();
                // back from return of sale
                $("body").removeClass("sale-return");                                
                $(".pos-mode button").removeClass("selected-mode");
                $(".sale-return-total").html(_labels.text_total+":");
                returnMode = false;
                $("#choose_form1").show();
                aursoft_pos.enableActions();
                if($.cookie('pos_mode') && $.cookie('pos_mode')=="icon-barcode"){
                   $("#products-screen").hide();   
                    $("#welcome-screen").fadeIn(function(){
                        $("#barcode-textfield").focus();
                    });
               }
               else{
                $("#products-screen").show();
                }               
            }
            else{
                invoic_action = 'rename';
                $("#order_"+aursoft_pos.sel_invoice_id).html(invoiceName);
            }
            $("#invoice_modal").modal("hide");            
             $.ajax({
                    type: 'POST',
                    url: urls.save_invoice,
                    data:{action:invoic_action,
                        invoice_name:invoiceName,
                        cust_id:'0',
                        invoice_date:aursoft_pos.getDateMysqlFormatWithTime(new Date()),
                        paymethod:'1',
                        invoice_status:'0',
                        invoice_id:aursoft_pos.sel_invoice_id
                    },
                    success: function(data){                        
                        var result = jQuery.parseJSON(data);
                        $(".loading").hide();
                        if(invoic_action=="new"){                            
                            INVOICE_NO = result.nexInvoice_no;
                            $("#order_temp").attr("id","order_"+result.curInvoice_no);
                            $("#order-rename_temp").attr("id","order-rename_"+result.curInvoice_no);
                            $("#order-del_temp").attr("id","order-del_"+result.curInvoice_no);
                            $("#order-close_temp").attr("id","order-close_"+result.curInvoice_no);
                            selected_order ="order_"+result.curInvoice_no;
                            invoice_list[selected_order] = {customer:0};
                            aursoft_pos.drawInvoice();                            
                            $("#order_"+result.curInvoice_no).click(aursoft_pos.selectInvoice);
                            $("#order-rename_"+result.curInvoice_no).click(aursoft_pos.editInvoiceName);
                            $("#order-del_"+result.curInvoice_no).click(aursoft_pos.deleteInvoice);
                            $("#order-close_"+result.curInvoice_no).click(aursoft_pos.closeInvoice);
                             $("#customerchoosen").trigger("chosen:updated");
                        }
                        
                    }
              });
         }
         try{
         $("[data-mode='quantity']").click();
         }
         catch(e){}
     },
     selectInvoice:function(){
       if(!$(this).hasClass("selected-order"))  {
         $(".selected-order").parents(".active_invoice").removeClass("active_invoice");
        $(".selected-order").removeClass("selected-order");     
        
        selected_order = $(this).attr("id"); 
        var c_id = invoice_list[selected_order]['customer']?invoice_list[selected_order]['customer']:0 ;
                    
        $("#customerchoosen").val(c_id).trigger("chosen:updated");;
        $("#customerchoosen_chzn .chzn-single span").html($("#customerchoosen option[value='"+c_id+"']").text());                                
        aursoft_pos.loadCustomer(c_id);
        
        $(this).parents(".order-selector-button").addClass("active_invoice");
        $(this).addClass("selected-order");
        selected_item = null;
        aursoft_pos.hideAll();
        aursoft_pos.enableActions();
        if($.cookie('pos_mode') && $.cookie('pos_mode')=="icon-barcode"){
            $("#products-screen").hide();   
             $("#welcome-screen").fadeIn(function(){
                 $("#barcode-textfield").focus();
             });
        }
        else{
         $("#products-screen").show();
         }
        aursoft_pos.drawInvoice();   
        var _tot = $("#total_sale").text().substring(0,$("#total_sale").text().length-4);
        if(isDisplayPole){      
        $.ajax({
            type: 'GET',
            url: urls.display_total,
            
            data:{port:port,command:'total',total:_tot,ttext1:'Grand ',ttext2:'Total:'},
                success: function(data){
                                        
                }
          });
              }
        
       }
     },
     getTime:function(h,m){
        var h = h ;
        var ampm = "AM";
        if(h>12){
            h = h % 12;
            ampm = "PM"
        }
        if(h==0){
            h =12;
        }
        return (this.pad(h,2)+":"+this.pad(m,2)+" "+ampm);
     },
     getTimeStamp:function(order){
         var s = order ? order : "";
         var D = new Date();
         var stamp = D.getUTCFullYear()+''+ D.getUTCMonth()+ D.getUTCDate()+  D.getUTCHours()+D.getUTCMinutes()+  D.getUTCSeconds()+s;
         return stamp;
     },
     getDateTime:function(){
         var D = new Date();
         var stamp =  this.pad(D.getDate(),2)+'/'+ this.pad(D.getMonth()+1,2)+'/'+this.pad(D.getFullYear(),2)+ " "+ this.getTime(D.getHours(),D.getMinutes());
         return stamp;
     },
     checkItemExists:function(item_id,unit_id){         
        var _id = 0;
        var inv_list = invoice_list[selected_order];
        if(typeof(unit_id)==="undefined"){
            jQuery.each(inv_list, function(key,value) {
                if(key.split("_")[1]==item_id){
                    _id = key;
                }
            });
        }
        else{
            jQuery.each(inv_list, function(key,value) {
                if(key.split("_")[1]==item_id && value.uom_unit==unit_id){
                    _id = key;
                }
            });
        }
        return _id;
     },
     pad :function(str,size){
      if(typeof(size) !== "number"){size = 2;}
      var s = String(str);
      while (s.length < size) s = "0" + s;
      return s;
    },
    filter:function(str){       
        str = str.replace(/\n/g, "<br />");
        return str;
    },
    format:function(str,digit){
        var _n = parseFloat (str);
        return _n.toFixed(digit);
    },
    getDateMysqlFormatWithTime: function (objDate){
        var currentdate =  objDate;
        var cdate = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+"-"+currentdate.getDate()+' '+currentdate.getHours()+':'+currentdate.getMinutes()+':'+currentdate.getSeconds();
        return cdate;
    },
    activateNewInvoiceDialog : function(){
        if($("#orders > li").length==0){
        setTimeout("aursoft_pos.initInvoiceDialog()",200);
       }
       else{
            $("#orders li:first button:first").click();
       }
    },
    enableActions: function(){
        $(".search_bar").show();
        $("#leftpane footer button").prop("disabled",false);
        $(".cash-received").prop("disabled",false);
        $("#rightheader .blocker,#branding .blocker").remove();
    },
    disableAction:function(){
        $(".search_bar").hide();
        $("#leftpane footer button").prop("disabled",true);
        $(".cash-received").prop("disabled",true);
        if($("#rightheader .blocker").length==0){
            $("#rightheader,#branding").append('<div class="blocker"></div>');
        }
    }

}

