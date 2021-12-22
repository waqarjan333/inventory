<?php echo $header; 
/* Copyright (c) 2011 
 * View for dashboar to buy and sell currency
 * Created Date: 10/10/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 */
?>
<?php echo $column_left; ?>  
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/layout/Center.js"></script> 
<script langauge="text/javascript">
    var inv_prefix='INV-';
    var inv_posfix='';
    var poinv_prefix='POINV-';
    var poinv_posfix='';
    var openedMenu =null;
    var timeObj = null;
    var active_layout = '';
    var win = null;
    var rem = null;
    var type_store = null;
    var update_password_win = null;
    var category_store=null,cattree_store_with_all=null;
    var type_store=null;
    var loadingMask = null;
    var OBJ_Action = null;
    var defaultMsg = "<?php echo $msg_loadings ?>";
    var invoice_pay_form = null;
    var emptyRows = 16;
    var chartStore = null;
    var account_form=null,new_item_form=null,new_vendor_form=null,new_customer_form=null,multi_items_form=null,inv_customize_form=null;
    var category_form=null;
    var winMode = 0;
    var typeModel = null;
    var customer_store= null, customer_store_account=null,customer_store_withall=null;customer_group_store=null;
    var vendor_store=null, vendor_store_active = null,vendor_store_withall=null;
    var bank_store = bank_store_active=null;
    var account_model_main = null;
    var account_selected_combo = null;
    var account_store= null;
    var user_store= null,unit_store=null;
    var account_store2= null;
    var so_method_store = account_head_store = null;
    var warehouse_store = null;
    var pricelevel_store = null;
    var editModel = null;
    var editModelSO = null;
    var po_receive_item_store= null,so_receive_item_store= null,uom_store_temp=null,lb_uom_store_temp=null;
    var editModelPO=editModelTransfer=null;
    var temp_unit_price=null;
    var warehouse_form = null;
    var editItem = {"id":-1,type:''};
    var itemsArray = new Array();
    var user_access_json = null;
    var payment_management_win = null;
    var payment_management_editModel = null;
    var sms_manual_form = null;
    var batch_array = [];
    
    var register_pay_form = expense_create_form = null;
    var payment_method_store =[{"method_id":"-1","method_name":"Cash","balance":0}];
    var sale_invoice_mode = 0;
    var purchase_invoice_return_mode = 0;
    var settings ={};
    var user_type = "<?php echo $user_type; ?>";
    if(user_type=="1"){
           window.location.href = "<?php echo $url_logout; ?>"
    }
    var update_pass = "<?php echo $update_pass; ?>";
    var user_id = "<?php echo $current_user_id; ?>";
    var user_right = "<?php echo $user_right; ?>";
    var customer_id= "<?php echo $customer_id; ?>";
    var userAccessJSON = "<?php echo $userAccessJSON; ?>";
    var enableCustomReport = "<?php echo $enable_custom_reports ?>";
    var enableCustomRegions = "<?php echo $enable_custom_regions ?>";
    var enableWarehouse = "<?php echo $enable_warehouse ?>";
    var enableUom = "<?php echo $enable_uom ?>";
    var bonusQuantity = "<?php echo $enable_bonus_quantity ?>";
    var enable_regTooltip = "<?php echo $enable_regTooltip ?>";
    var enable_InvRegister = "<?php echo $enable_InvRegister ?>";
    var RequiredWarehouse = "<?php echo $RequiredWarehouse ?>";
    // var enableAvgQty = "<?php// echo $enable_avgQty ?>";
    //var user_access_json = "<?php echo $user_access_json; ?>";
    var last_id = { "sale_last_invoice":"<?php echo $last_sale_id; ?>","po_last_invoice":"<?php echo $last_po_id; ?>","transfer_last_invoice":"<?php echo $last_transfer_id; ?>" };
    var payment_balances = { "-1": 0 };
    var current_user_id = "<?php echo $current_user_id ?>";
    var json_urls = {
                     "home":"<?php echo $json_home; ?>",
                     "items":"<?php echo $json_items; ?>",
                     "item_list":"<?php echo $json_item_list; ?>",
                     "items_adjust_list":"<?php echo $json_items_adjust_list; ?>",
                     "stock_transfer":"<?php echo $json_stock_transfer; ?>",   
                     "warehouse_list":"<?php echo $json_warehouse_list; ?>",
                     //"accounts_list":"<?php echo $json_accounts_list; ?>",
                     "expense_list":"<?php echo $json_expense_list; ?>",
                     "sale_invoice":"<?php echo $json_sale_invoice; ?>",
                     "order_list":"<?php echo $json_order_list; ?>",
                     "customers":"<?php echo $json_customers; ?>",
                     "customer_list":"<?php echo $json_customer_list; ?>",
                     "purchase_invoice":"<?php echo $json_purchase_invoice; ?>",
                     "purchase_list":"<?php echo $json_purchase_list; ?>",
                     "vendors":"<?php echo $json_vendors; ?>",
                     "vendor_list":"<?php echo $json_vendor_list; ?>",
                     "dashboard":"<?php echo $json_dashboard; ?>",
                     "accounts":"<?php echo $json_accounts; ?>",
                     "accounts_journal":"<?php echo $json_journal; ?>",
                     "accounts_journal_View":"<?php echo $json_journalView; ?>",
                     "accounts_register":"<?php echo $json_register; ?>",
                     "reports":"<?php echo $json_reports; ?>",
                     "settings":"<?php echo $json_settings; ?>",
                     "reminders":"<?php echo $json_reminders; ?>",
                     "price_level":"<?php echo $json_price_level; ?>",
                     "batch_sales_invoices":"<?php echo $json_batch_sales; ?>",
                     "sales_return_invoices":"<?php echo $json_sale_return; ?>",
                     "customer_group":"<?php echo $json_customer_group; ?>",
                     "customer_type":"<?php echo $json_customer_type; ?>",
                     "vendor_group":"<?php echo $json_vendor_group; ?>",
                     "salesrep" : "<?php echo $json_salesrep; ?>",
                     "user_access" : "<?php echo $json_user_access; ?>",
                     "print_label":"<?php echo $print_label; ?>"
        
                    };
    var action_urls={
              "url_PurchasesaveExpense":"<?php echo $url_PurchasesaveExpense ?>",  
              "url_getcat":"<?php echo $url_getcat ?>",  
              "unit_price_uom":"<?php echo $unit_price_uom ?>",  
             "url_saleinvoice_save":"<?php echo $url_saleinvoice_save ?>",
             "save_transfer":"<?php echo $url_save_transfer ?>",        
             "get_warehouses_2":"<?php echo $url_get_warehouses_2 ?>",        
             "get_item_warehouse":"<?php echo $url_get_item_warehouse ?>",      
             "warehouse_adjusted_items":"<?php echo $url_warehouse_adjusted_items ?>",      
             "get_item_warehouse_qty":"<?php echo $url_get_item_warehouse_qty ?>",      
             "save_settings":"<?php echo $url_save_settings ?>",        
             "get_settings":"<?php echo $url_get_settings ?>",
             "get_items":"<?php echo $url_get_items; ?>",
             "get_purchase_items":"<?php echo $url_get_purchase_items; ?>",
             "get_accounts":"<?php echo $url_get_accounts; ?>",
             "get_income_accounts":"<?php echo $url_get_income_accounts; ?>",
             "get_account_types":"<?php echo $url_get_account_types; ?>",
             "generate_item_barcode":"<?php echo $url_item_generate_barcode ?>",
             "adjust_item_barcode":"<?php echo $url_adjust_barcode ?>",
             "saveupdate_account":"<?php echo $url_saveupdate_account; ?>",
             "url_backup":"<?php echo $url_url_backup; ?>",
             "deactivate_account":"<?php echo $url_deactivate_account; ?>",
             "get_credit_merchant":"<?php echo $url_get_credit_merchant; ?>",
             "url_getrights":"<?php echo $url_getrights; ?>",
             "delete_account":"<?php echo $url_delete_account; ?>",
             "get_allaccount_types":"<?php echo $url_account_types; ?>",
             "saveupdate_types":"<?php echo $url_account_type_saveupdate; ?>",
             "delete_type":"<?php echo $url_delete_type; ?>",
             "get_customers":"<?php echo $url_get_customers; ?>",
             "get_payment_methods":"<?php echo $url_get_payment_methods; ?>",
             "get_so":"<?php echo $url_get_so; ?>",
             "get_stockTransfer":"<?php echo $url_get_stockTransfer; ?>",
             "get_so_record":"<?php echo $url_get_so_record; ?>",
             "get_transfer_record":"<?php echo $url_get_transfer_record; ?>",
             "get_item_record":"<?php echo $url_get_item_record; ?>",
             "get_customer_record":"<?php echo $url_get_customer_record; ?>",
             "get_vendor_record":"<?php echo $url_get_vendor_record; ?>",
             "get_vendors":"<?php echo $url_get_vendors; ?>",
             "get_po":"<?php echo $url_get_po; ?>",
             "get_po_record":"<?php echo $url_get_po_record; ?>",
             "get_bl_po_record":"<?php echo $url_get_bl_po_record; ?>",
             "get_bl_purchase_invoice_no":"<?php echo $url_get_bl_purchase_invoice_no; ?>",
             "get_bl_purchase_invoice_items":"<?php echo $url_get_bl_purchase_invoice_items; ?>",
             "get_bl_barcodes":"<?php echo $url_get_bl_barcodes; ?>",
             "save_item_category":"<?php echo $url_item_category_save; ?>",
             "get_reports":"<?php echo $get_url_reports; ?>",
             "item_upload_image":"<?php echo $url_item_upload_image; ?>",
             "get_warehouses":"<?php echo $url_get_warehouses; ?>",             
             "saveupdate_warehouse":"<?php echo $url_warehouses_saveupdate ?>",
             "deactivate_warehouses":"<?php echo $url_warehouses_deactivate ?>",
             "delete_category":"<?php echo $url_item_category_delete ?>",
             "print_label_item":"<?php echo $url_print_label_item ?>",
             "get_pricelevels":"<?php echo $url_get_pricelevels; ?>",
             "saveupdate_pricelevel":"<?php echo $url_save_pricelevels; ?>",
             "delete_pricelevels" :"<?php echo $url_delete_pricelevels; ?>",
             "get_pricelevel_items" : "<?php echo $url_get_pricelevels_items; ?>",
             "po_pay" : "<?php echo $url_po_pay; ?>",
             "so_pay" : "<?php echo $url_so_pay; ?>",
             "po_pay_del" : "<?php echo $url_po_pay_del; ?>",
             "so_pay_del" : "<?php echo $url_so_pay_del; ?>",
             "get_po_payments":"<?php echo $url_get_po_payments; ?>",
             "get_me_uom":"<?php echo $get_me_uom; ?>",
             "update_po_remarks":"<?php echo $update_po_remarks; ?>",
             "po_uom_price":"<?php echo $po_unit_uom_price; ?>",
             "get_so_payments":"<?php echo $url_get_so_payments; ?>",
             "get_region_customers":"<?php echo $url_get_region_customers; ?>",
             "get_customer_regRecord":"<?php echo $url_get_customer_regRecord; ?>",
             "get_vendor_regRecord":"<?php echo $url_get_vendor_regRecord; ?>",
             "get_batch_invoices":"<?php echo $url_get_batch_orders; ?>",
             "get_sale_return_invoices":"<?php echo $url_sale_return_invoices; ?>",
             "get_batch_detail":"<?php echo $url_get_batch_detail; ?>",
             "get_customers_group":"<?php echo $url_get_customers_group; ?>",
             "saveupdate_groups":"<?php echo $url_save_customers_group; ?>",
             "delete_cust_group":"<?php echo $url_delete_customers_group; ?>",
             "get_customers_type":"<?php echo $url_get_customers_type ?>",
             "saveupdate_cust_type":"<?php echo $url_save_customers_type; ?>",
             "delete_cust_type":"<?php echo $url_delete_customers_type; ?>",
             "delete_so_invoice":"<?php echo $url_delete_so_invoice; ?>",
             "delete_st_invoice":"<?php echo $url_delete_st_invoice; ?>",
             "delete_po_invoice":"<?php echo $url_delete_po_invoice; ?>",
             "get_sale_chart" : "<?php echo $url_chart_sale; ?>",
             "get_product_chart" : "<?php echo $url_chart_product; ?>",
             "get_customer_chart" : "<?php echo $url_chart_customer; ?>",
             "get_salesrep" : "<?php echo $url_get_salesrep; ?>",
             "saveupdate_salesrep": "<?php echo $url_save_salesrep; ?>",
             "delete_salesrep": "<?php echo $url_delete_salesrep; ?>",
             "deactivate_salesrep": "<?php echo $url_deactivate_salesrep; ?>",
             "save_items": "<?php echo $url_save_items; ?>",
             "get_mapping_items": "<?php echo $url_get_map_items; ?>",
             "get_journal": "<?php echo $url_get_journal; ?>",
             "get_register": "<?php echo $url_get_register; ?>",
             "getCustomerPrevious": "<?php echo $url_getCustomerPrevious; ?>",
             "get_SaleInvoiceRegister": "<?php echo $url_get_SaleInvoiceRegister; ?>",
             "save_journal_entry":"<?php echo $url_save_journal; ?>",
             "save_journal_invoice":"<?php echo $url_save_journal_invoice; ?>",
             "previous_journal_invoice":"<?php echo $url_previous_journal_invoice; ?>",
             "next_journal_invoice":"<?php echo $url_next_journal_invoice; ?>",
             "delete_journal_invoice":"<?php echo $url_delete_journal_invoice; ?>",
             "retrieve_journal_invoice":"<?php echo $url_retrieve_journal_invoice; ?>",
             "retrieve_journal_details":"<?php echo $url_retrieve_journal_details; ?>",
             "delete_journal_entry":"<?php echo $url_delete_journal; ?>",
             "get_account_reports" : "<?php echo $get_url_account_reports; ?>",
             "get_custom_reports" : "<?php echo $get_url_custom_reports; ?>",
             "get_so_pricelevel": "<?php echo $url_get_pricelevel; ?>",
             "get_stock_items":"<?php echo $url_get_stock_items; ?>",
             "post_adjusted_items":"<?php echo $url_post_stock_items; ?>",
             "get_stockadjust_batchcount":"<?php echo $url_get_batch_count; ?>",
             "get_stockadjust_batch":"<?php echo $url_get_batch_adjust; ?>",
             "receivable_pay":"<?php echo $url_receivable_pay; ?>",
             "sendsms":"<?php echo $url_sendsms; ?>",             
             "get_security_question":"<?php echo $url_security_question ?>",
             "get_banks":"<?php echo $url_get_banks; ?>",
             "get_expenses":"<?php echo $url_get_expenses; ?>",
             "get_all_expenses":"<?php echo $url_get_all_expenses; ?>",
             "get_all_loans":"<?php echo $url_get_all_loans; ?>",
             "save_update_user":"<?php echo $url_save_users; ?>",
             "get_users":"<?php echo $url_get_users; ?>",
             "delete_user":"<?php echo $url_delete_users; ?>",
             "get_balance":"<?php echo $url_get_balance; ?>",
             "get_units":"<?php echo $url_get_units; ?>",
             "save_update_unit":"<?php echo $url_save_units; ?>",
             "delete_unit":"<?php echo $url_delete_unit; ?>",
             "save_uom":"<?php echo $url_save_uom; ?>",
             "delete_uom_unit":"<?php echo $url_delete_unit_uom; ?>",
             "save_security_question":"<?php echo $url_save_security_question; ?>",
             "get_item_uom":"<?php echo $url_get_item_uom; ?>",
             "get_item_warehouse_reorder":"<?php echo $get_item_warehouse_reorder; ?>",
             "get_item_warehouse_reorder_qty":"<?php echo $get_item_warehouse_reorder_qty; ?>",
             "save_vendor":"<?php echo $url_vendor_save; ?>",
             "Updateunit_price_uom":"<?php echo $url_Updateunit_price_uom; ?>",
             // "save_uom_price2":"<?php echo $url_save_uom_price2; ?>",
             // "save_uom_price3":"<?php echo $url_save_uom_price3; ?>",
             "save_inv_description":"<?php echo $url_save_inv_description; ?>",
             
    };
    var panel_form_actions = { "item-panel":{ "save":"<?php echo $url_item_save; ?>","save_service":"<?php echo $url_item_service_save; ?>","copy":"<?php echo $url_item_copy;?>","deactivate":"<?php echo $url_item_deactivate;?>"},
                               "customer-panel":{ "save":"<?php echo $url_customer_save; ?>","deactivate":"<?php echo $url_customer_deactivate;?>"},
                               "sale-invoice-panel":{ "save":"<?php echo $url_saleinvoice_save?>"},
                               "vendor-panel":{ "save":"<?php echo $url_vendor_save; ?>","deactivate":"<?php echo $url_vendor_deactivate;?>"},
                               "purchase-invoice-panel":{ "save":"<?php echo $url_purchaseinvoice_save?>"}                                
                                                              
                             };
    var labels_json = {
            "_url" : "<?php echo $url_labels; ?>" ,
            "button_save":"<?php echo $button_save; ?>",
            "button_search_all":"<?php echo $button_show_all; ?>",
            "button_search":"<?php echo $button_search; ?>",
            "button_cancel":"<?php echo $button_cancel; ?>",
            "text_loading":"<?php echo $text_loading; ?>",
            "text_error":"<?php echo $text_error; ?>",
            "label_from_date":"<?php echo $label_from_date; ?>",
            "label_end_date":"<?php echo $label_end_date; ?>",
            "button_pay":"<?php echo $button_pay; ?>",
            "pay_order":"<?php echo $pay_order; ?>",
            "date_paid":"<?php echo $date_paid; ?>",
            "payment_method":"<?php echo $payment_method; ?>",
            "remarks":"<?php echo $remarks; ?>",
            "customertypewindow":{                 
                 "text_type_name":"<?php echo $text_type_name; ?>",
                 "text_type_default":"<?php echo $text_type_default; ?>"
            },
             "customergroupwindow":{
                 "text_group_name":"<?php echo $text_group_name; ?>",
                 "text_group_default":"<?php echo $text_group_default; ?>"
            },
            "msg_send_sms":"<?php echo $msg_send_sms; ?>",
            "msg_saving":"<?php echo $msg_saving; ?>",
            "add_customers":"<?php echo $label_add_new_customer; ?>",
            "label_name":"<?php echo $label_name; ?>",
            "label_obalance":"<?php echo $label_obalance; ?>",
            "label_group":"<?php echo $label_group; ?>",
            "label_payment_term":"<?php echo $label_payment_term; ?>",
            "label_credit_limit":"<?php echo $label_credit_limit; ?>",
            "label_phone":"<?php echo $label_phone; ?>",
            "label_mobile":"<?php echo $label_mobile; ?>",
            "label_address":"<?php echo $label_address; ?>",
            "label_save":"<?php echo $button_save; ?>",
            "label_cancel":"<?php echo $button_cancel; ?>",
            "label_name_emptytext":"<?php echo $label_name_emptytext; ?>",
            
            "text_add_item":"<?php echo $text_add_item; ?>",
            "text_type":"<?php echo $text_type; ?>",
            "text_name":"<?php echo $text_name; ?>",
            "text_name_placeholder":"<?php echo $text_name_placeholder; ?>",
            "text_category":"<?php echo $text_category; ?>",
            "text_description":"<?php echo $text_description; ?>",
            "text_qty_on_hand":"<?php echo $text_qty_on_hand; ?>",
            "text_bar_code":"<?php echo $text_bar_code; ?>",
            "text_generate":"<?php echo $text_generate; ?>",
            "text_purchase_price":"<?php echo $text_purchase_price; ?>",
            "text_sales_price":"<?php echo $text_sales_price; ?>",
            "inv_customization":"<?php echo $inv_customization; ?>",
            
            "text_prevbalance":"<?php echo $text_prevbalance; ?>",
            "text_gatepass":"<?php echo $text_gatepass; ?>",
            "text_showregister_print":"<?php echo $text_showregister_print; ?>",
            "text_showregister_inv":"<?php echo $text_showregister_inv; ?>",
            "text_send_message_cust":"<?php echo $text_send_message_cust; ?>",
            "text_send_message_salerep":"<?php echo $text_send_message_salerep; ?>",
            
            
            
            "salesrepwindow":{
                 "label_title":"<?php echo $label_title; ?>",
                 "label_name":"<?php echo $label_name; ?>",
                 "label_address":"<?php echo $label_address; ?>",
                 "label_phone":"<?php echo $label_phone; ?>",
                 "label_mobile":"<?php echo $label_mobile; ?>",
                 "label_email":"<?php echo $label_email; ?>",
                 "label_active":"<?php echo $label_active; ?>",
                 "msg_please_wait":"<?php echo $msg_please_wait; ?>",
                 "msg_loadings":"<?php echo $msg_loadings; ?>",
                 "label_all":"<?php echo $label_all; ?>",
                 "label_add_new_customer":"<?php echo $label_add_new_customer; ?>",
                 "add_new_salerep_button":"<?php echo $add_new_salerep_button; ?>",
                 "add_new_vendor":"<?php echo $add_new_vendor; ?>"
            } 
    }        
    function encodeHTML(str) {
    if(typeof(str)!=="undefined"){        
        str = str.replace(/\'/g, "&#39;");        
        str = str.replace(/\"/g, "&quot;");
        str = str.replace(/\‘/g,"&#8216;");
    }
    else{
        str = "";
    }
    return str;
}  
// console.log(defaultMsg);
function decodeHTML(str) {
//decoding HTML entites to show in textfield and text area              
    if(typeof(str)!=="undefined"){
        str = str.replace(/&amp;/g, "&");
        str = str.replace(/&#58;/g, ":");
        str = str.replace(/&#39;/g, "\'");                
        str = str.replace(/&#40;/g, "(");
        str = str.replace(/&#41;/g, ")");
        str = str.replace(/&lt;/g, "<");
        str = str.replace(/&gt;/g, ">");
        str = str.replace(/&gt;/g, ">");                
        str = str.replace(/&#9;/g, "\t");
        str = str.replace(/&nbsp;/g, " ");
        str = str.replace(/&quot;/g, "\"");
        str = str.replace(/&#8216;/g, "‘");      
        str = str.replace(/&#61;/g, "=");    
    }
    else{
        str = "";
    }
return str;
}

/* Get Account balances */
  function getBalance(acc_id,val,neg){
      Ext.Ajax.request({
        url: action_urls.get_balance,
        method : 'GET',
        params:{ acc_id:acc_id },
        success: function (response) {          
          var result = Ext.decode(response.responseText);
          if(val){
            val.balance = result.balance;                        
            if(neg){
                val.balance = val.balance * neg;
            }    
          }
          else if(typeof(payment_balances[acc_id])!=="undefined"){
                payment_balances[acc_id] = parseFloat(result.balance);
                if(neg){
                    payment_balances[acc_id] = payment_balances[acc_id] * neg;
                }
          }
          
        },
        failure: function () {
        }
     });
  }
    Ext.ns('dialog');
    
        
    
    window.onbeforeunload = function (evt) {
    if(evt && active_layout==="sale-invoice-panel"){
        return "Are you sure you want to leave this page?";
    } else if (evt && active_layout==="purchase-invoice-panel"){
        return "Are you sure you want to leave this page?";
    }
    }
    
    Ext.onReady(function(){ 

    loadingMask = new Ext.LoadMask(Ext.getBody(), { msg:defaultMsg });
    loadingMask.show();
    getPanel(json_urls.home);
    
    if(user_right==="3"){
        sale_invoice_mode = 2;
        Ext.getCmp("left_panel").setVisible(false);
        
        getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});  
        // getPanel(json_urls.stock_transfer,'stock-invoice-panel',{grids:['sale-invoice-panel-grid']});  
    }
    
    var map = new Ext.util.KeyMap({
        target:Ext.getDoc(),
        binding: [{
                    key: 67, 
                    alt:true,                    
                    fn: function(){
                        if(active_layout==="sale-invoice-panel"){
                            OBJ_Action.saveme();
                            return false;
                        }
                    }
                },
                {
                   key: 80,  
                   alt:true,                   
                   fn: function(){
                       if(active_layout==="sale-invoice-panel"){
                             OBJ_Action.saveme({print:1});
                             return false;
                       }
                    }
                },
                {
                   key: 78,  
                   alt:true,                   
                   fn: function(){
                       if(active_layout==="sale-invoice-panel"){
                             OBJ_Action.makeNew({'save_other':OBJ_Action.saveme});
                             return false;
                       }
                    }
                }
        ]
    });
        Ext.Ajax.request({      
            url: action_urls.get_settings,      
            method : 'GET',     
            params:{},      
            success: function (response) {                  
              var result = Ext.decode(response.responseText);       
              settings["sale"] = result;                
            },      
            failure: function () {      
            }       
         });
      //End ready 
      Ext.define('common', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'id'},
            {name: 'name', type:'string'}
           
         ]
        });
       typeModel= Ext.define("accountTypeModel", {
            extend:"Ext.data.Model",
            fields:[
                "id",
                "type",
                "head_id",
                "status",
                "status_id",
                "type_type",
                "type_type_text",
                ]
        }) && "accountTypeModel";
        
        account_model_main =Ext.define("accountModelMain", {
            extend:"Ext.data.Model",
            fields:[
                "id",
                "acc_name",
                "status",
                "acc_type_id",
                "acc_head_id"               
                ]
        }) && "accountModelMain";
        
        account_store = new Ext.data.Store({
                proxy:{
                    type:"ajax",
                    url: '<?php echo $url_get_accounts; ?>',
                    reader:{
                        type:"json",
                        root: 'accounts',
                        idProperty: 'id'
                    }
                },
                sorters: 'acc_name',
                autoLoad: true,
                model:'accountModelMain'         

        });
        
        account_store.on("load",function(){
              account_store.insert(0,{"id":"-2","acc_name":"Add New..."});
            
       });
       
       income_account_store = new Ext.data.Store({
                proxy:{
                    type:"ajax",
                    url: '<?php echo $url_get_income_accounts; ?>',
                    reader:{
                        type:"json",
                        root: 'accounts',
                        idProperty: 'id'
                    }
                },
                sorters: 'acc_name',
                autoLoad: true,
                model:'accountModelMain'         

        });
        
        income_account_store.on("load",function(){
              income_account_store.insert(0,{"id":"-2","acc_name":"Add New..."});
            
       });
       
       
       
       //Store Data for Debit Store and Credit Store
       store_data = [
                <?php if(isset($accounts_list)){
                for ($count=0,$size=count($accounts_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $accounts_list[$count]['id']?>",
                     "acc_name":"<?php echo $accounts_list[$count]['acc_name']?>",
                      "acc_type":"<?php echo $accounts_list[$count]['acc_type']?>", 
                      "acc_status":"<?php echo $accounts_list[$count]['acc_status']?>", 
                      "acc_type_id":"<?php echo $accounts_list[$count]['acc_type_id']?>",
                    }
                    <?php if($count < count($accounts_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
            
        
       //Debit Store for Journal
        debit_store = Ext.create('Ext.data.Store', {
            fields: ['id', 'acc_name','acc_type','acc_status','acc_type_id'],
            data : store_data
          });  
        debit_store.insert(0,{"id":"-2","acc_name":"Add New..."});
       
       //Credit Store for Journal
        credit_store = Ext.create('Ext.data.Store',{
            fields: ['id', 'acc_name','acc_type','acc_status','acc_type_id'],
            data : store_data
          });  
        credit_store.insert(0,{"id":"-2","acc_name":"Add New..."});
        
        //Accounts Store for Journal View Grid Row
        journal_account_store = Ext.create('Ext.data.Store',{
            fields: ['id', 'acc_name','acc_type','acc_status','acc_type_id'],
            data : store_data
          });
        //journal_account_store.insert(0,{"id":"-2","acc_name":"Add New..."});
        
        //Name Store for Journal View Grid Row
        journal_name_store = Ext.create('Ext.data.Store',{
            fields: ['id', 'acc_name','acc_type','acc_status','acc_type_id'],
            data : store_data
          });
        //journal_name_store.insert(0,{"id":"-2","acc_name":"Add New..."});
        
        //Store for Journal View Grid
        journal_view_store = Ext.create('Ext.data.Store',{
            fields: ['acc_name', 'debit_amount','credit_amount','memo','name'],
            data : []
          });
        
        //Store to Save Journal View Grid
        journal_view_store_2 = Ext.create('Ext.data.Store',{
            fields: ['acc_name', 'debit_amount','credit_amount','memo','name'],
            data : []
          });
          
        //Store for Journal View Entry List
        journal_view_time = Ext.create('Ext.data.Store',{
            fields: ['date'],
            data : [{'date':'Today'},
                    {'date':'Select Date'},
                    {'date':'Last 7 Days'},
                    {'date':'Last 10 Days'},
                    {'date':'Last 15 Days'},
                    {'date':'Last 30 Days'},
                    {'date':'Last 60 Days'},
                    {'date':'Last 90 Days'},
                    {'date':'Last 365 Days'}],
          });
          
        journal_view_generalgrid = Ext.create('Ext.data.Store',{
            fields: ['date', 'entry_id','adj','account','memo','amount'],
            data : []
          });
          
        
       
       //Creating head store for accounts
       account_head_store = new Ext.data.Store({
                proxy:{
                    type:"ajax",
                    url: '<?php echo $url_get_account_heads; ?>',
                    reader:{
                        type:"json",
                        root: 'heads',
                        idProperty: 'id'
                    }
                },
                autoLoad: false,
                model:Ext.define("accountHeadModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            "id",
                            "head_title",
                            "head_status"
                            ]
                    }) && "accountHeadModel"         

        });

       cat_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.url_getcat,
                reader:{
                    type:"json",
                    root: 'categories',
                    idProperty: 'id',
                }
            },           
        buffered: false,        
        leadingBufferZone: 150,    
        pageSize: 50,    
        model:Ext.define("itemCatModel", {
            extend:"Ext.data.Model",
            fields:[
                "id",
                "name",
                "parent"
               ]
        }) && "itemCatModel"
       }) ;  

       category_store = new Ext.data.Store({
                proxy:{
                    type:"ajax",
                    url: '<?php echo $url_getcategories; ?>',
                    reader:{
                        type:"json",
                        root: 'categories',
                        idProperty: 'id'
                    }
                },
                autoLoad: true,
                model:'common'         

        });
       category_storeWithAll = new Ext.data.Store({
            model:'common',
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    root: 'categories'
                }
            }   
       });
       category_store.on("load",function(){
            category_storeWithAll.loadData(Ext.pluck(category_store.data.items,'data'));                        
            category_storeWithAll.insert(0,{"id":"0","name":labels_json.salesrepwindow.label_all});
            category_store.insert(0,{"id":"-1","name":"Add New Category..."});
            
       });
       
       cattree_store = Ext.create('Ext.data.TreeStore', {
            proxy: {
                type: 'ajax',
                url: '<?php echo $url_gettreecategories; ?>'
            },
            root: {
                text: 'Default',                    
                expanded: true,
                iconCls :'root-icon',
                id:'1'
            },
            folderSort: true,
            model:Ext.define("CategoryTreeModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "name",
                    "description",
                    "parent_id",
                    "status"
                   ]
            }) && "CategoryTreeModel"
            
        });             
        cattree_store.on("load",function(){
            if(Ext.getCmp("cat_form_tree")){
                Ext.getCmp("cat_form_tree").columns[1].hide();
                Ext.getCmp("cat_form_tree").columns[1].show();
                // Ext.getCmp("cat_form_tree").columns[1];
            }
            if(Ext.getCmp("_item_cat_tree")){
                Ext.getCmp("_item_cat_tree").columns[1].hide();
                Ext.getCmp("_item_cat_tree").columns[1].show();
            }
        });
        cattree_store_with_all = Ext.create('Ext.data.TreeStore', {
            model:"CategoryTreeModel",
            folderSort: true,
            root: {
                    text: 'All',                    
                    expanded: true,
                    name : 'All',
                    id:'-1'
                },
            proxy:{
                type:"memory"
                
            },
       });
        cattree_store.on("load",function(){            
            var nodes = cattree_store.getRootNode().copy(labels_json.customertypewindow.text_type_default,true);      
                         
            var rootNode = cattree_store_with_all.getRootNode();
             rootNode.removeAll();            
            rootNode.appendChild(nodes);                                      
            rootNode.childNodes[0].expand();  
            rootNode.childNodes[0].set({"text":labels_json.customertypewindow.text_type_default,"iconCls":"","name":labels_json.customertypewindow.text_type_default,"id":"1"});
            
       });
       
       store_adjust = Ext.create('Ext.data.Store', { 
           proxy:{
                    type:"ajax",
                    url: action_urls.get_stock_items,
                    reader:{
                        type:"json",
                        root: 'items',
                        idProperty: 'id',
                        totalProperty: 'totalCount'
                    },
                    simpleSortMode: true
            },
            buffered: false,
            leadingBufferZone: 300,            
            pageSize: 300,
            model:Ext.define("adjustItemsModel", {
                extend:"Ext.data.Model",
                fields:[
                    "adjust_id",
                    "id",
                    "item",
                    "qty",
                    "salePrice",
                    "avg_cost",
                    "purchasePrice",
                    "item_description",
                    "item_units",
                    "newQty",
                    "totalValue",
                    "qtyDiff",
                    "newValue",
                    "conv_from"
                    ]
            }) && "adjustItemsModel",
            autoLoad:false,       
            remoteFilter: true
          } ); 
         
        item_store_ware = new Ext.data.Store( {
                  proxy:{
                      type:"ajax",
                      url: action_urls.get_item_warehouse,
                      reader:{
                          type:"json",
                          root: 'items',
                          idProperty: 'id'
                      }
                  },           
              buffered: false,        
              leadingBufferZone: 150,    
              pageSize: 50,    
              model:Ext.define("itemWareModel", {
                  extend:"Ext.data.Model",
                  fields:[
                      "id",
                      "item",
                      "type",
                      "nprice",
                      "navg_cost",
                      "weight",
                      "sprice",
                      "qty",
                      "barcode",
                      "purchase_item_uom",
                      "sale_item_uom",
                      "item_units",
                      "item_Plevel",
                      "item_warehouses"
                     ]
              }) && "itemWareModel"
             }) ;
             
             
       item_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                async: true,
                url: action_urls.get_items,
                extraParams:{status:1},
                reader:{
                    type:"json",
                    root: 'items',
                    idProperty: 'id',
                    totalProperty: 'totalCount'
                }
            },           
        buffered: false,        
        leadingBufferZone: 150,    
        pageSize: 50,
        autoLoad: true,
        // pageSize: utilsObj.scrollValue,
        remoteFilter:true,    
        model:Ext.define("itemInvoiceModel", {
            extend:"Ext.data.Model",
            fields:[
                "id",
                "item",
                "type",
                "nprice",
                "navg_cost",
                "weight",
                "sprice",
                "qty",
                "barcode",
                "purchase_item_uom",
                "sale_item_uom",
                "item_units",
                "item_Plevel",
                "item_warehouses"
               ]
        }) && "itemInvoiceModel"
       }) ;               
       
          item_store1 = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                async: true,
                url: action_urls.get_items,
                extraParams:{status:1},
                reader:{
                    type:"json",
                    root: 'items',
                    idProperty: 'id',
                    totalProperty: 'totalCount'
                }
            },           
        buffered: false,        
        leadingBufferZone: 150,    
        pageSize: 550,    
        model:Ext.define("itemInvoiceModel1", {
            extend:"Ext.data.Model",
            fields:[
                "id",
                "item",
                "type",
                "nprice",
                "navg_cost",
                "weight",
                "sprice",
                "qty",
                "barcode",
                "purchase_item_uom",
                "sale_item_uom",
                "item_units",
                "item_Plevel",
                "item_warehouses"
               ]
        }) && "itemInvoiceModel"
       }) ;               
       
       item_store.on("datachanged",function(store,opt){
            if(Ext.getBody().select(".x-boundlist").elements.length){    
                Ext.getBody().select(".x-boundlist").elements[0].style.visibility = "visible";
            }
            if(OBJ_Action && OBJ_Action.searchChange==1){
                if(active_layout==="sale-invoice-panel" && store.data.length==1){
                    var selected_item  = store.data.items[0].get("id");
                    Ext.getCmp("item_name_so").select(store.data.items[0]);
                    Ext.getCmp("item_quantity_so").focus(true,100);                    
                    Ext.defer(function(){
                        Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                        OBJ_Action.searchChange = OBJ_Action.searchKeyPress = 0;
                    },200)
                }   
                 if(active_layout==="stock-transfer-panel" && store.data.length==1){
                    var selected_item  = store.data.items[0].get("id");
                    Ext.getCmp("item_name_so").select(store.data.items[0]);
                    Ext.getCmp("item_quantity_so").focus(true,100);                    
                    Ext.defer(function(){
                        Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                        OBJ_Action.searchChange = OBJ_Action.searchKeyPress = 0;
                    },200)
                }

                else if(active_layout==="purchase-invoice-panel"){
                    if(store.data.length==1){
                        var selected_item  = store.data.items[0].get("id");
                        Ext.getCmp("item_name_po").select(store.data.items[0]);
                        Ext.getCmp("item_quantity_po").focus(true,100);                    
                        Ext.defer(function(){
                            Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                            OBJ_Action.searchChange = OBJ_Action.searchKeyPress = 0;
                        },200)
                    }
                    else if(store.data.length===0){
                        Ext.Msg.show({
                         title:'No Item Found',
                         msg: 'Item you are looking for didn\'t exist, Do you want to create item?',
                         buttons: Ext.Msg.YESNOCANCEL,
                         icon: Ext.Msg.QUESTION,
                         fn:function(btn,text){
                             if(btn=='no'){
                                  editModelPO.cancelEdit();                                 
                             }
                             else if(btn=='yes'){
                                new_item_form.show();
                                Ext.getCmp("new_win_item_barcode").setValue(Ext.getCmp("item_name_po").getValue());
                                editModelPO.cancelEdit();
                                Ext.getCmp("new_win_item_name").focus();
                             }
                             
                         }
                        });
                        
                    }
                }
               
                
                
            }            
       });
                
        
       
       item_purchase_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_purchase_items,
                extraParams:{status:1},
                reader:{
                    type:"json",
                    root: 'items',
                    idProperty: 'id',
                    totalProperty: 'totalCount'
                }
            },           
        buffered: false,        
        leadingBufferZone: 150,    
        pageSize: 50,    
        model:Ext.define("itemInvoiceModel", {
            extend:"Ext.data.Model",
            fields:[
                "id",
                "item",
                "type",
                "nprice",
                "navg_cost",
                "weight",
                "sprice",
                "qty",
                "barcode",
                "purchase_item_uom",
                "sale_item_uom",
                "item_units",
                "item_warehouses"
               ]
        }) && "itemInvoiceModel"
       }) ;               
       
       item_purchase_store.on("datachanged",function(store,opt){
            if(Ext.getBody().select(".x-boundlist").elements.length){    
                Ext.getBody().select(".x-boundlist").elements[0].style.visibility = "visible";
            }
            if(OBJ_Action && OBJ_Action.searchChange==1){
                if(active_layout==="sale-invoice-panel" && store.data.length==1){
                    var selected_item  = store.data.items[0].get("id");
                    Ext.getCmp("item_name_so").select(store.data.items[0]);
                    Ext.getCmp("item_quantity_so").focus(true,100);                    
                    Ext.defer(function(){
                        Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                        OBJ_Action.searchChange = OBJ_Action.searchKeyPress = 0;
                    },200)
                }   
                 if(active_layout==="stock-transfer-panel" && store.data.length==1){
                    var selected_item  = store.data.items[0].get("id");
                    Ext.getCmp("item_name_so").select(store.data.items[0]);
                    Ext.getCmp("item_quantity_so").focus(true,100);                    
                    Ext.defer(function(){
                        Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                        OBJ_Action.searchChange = OBJ_Action.searchKeyPress = 0;
                    },200)
                }

                else if(active_layout==="purchase-invoice-panel"){
                    if(store.data.length==1){
                        var selected_item  = store.data.items[0].get("id");
                        Ext.getCmp("item_name_po").select(store.data.items[0]);
                        Ext.getCmp("item_quantity_po").focus(true,100);                    
                        Ext.defer(function(){
                            Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                            OBJ_Action.searchChange = OBJ_Action.searchKeyPress = 0;
                        },200)
                    }
                    else if(store.data.length===0){
                        Ext.Msg.show({
                         title:'No Item Found',
                         msg: 'Item you are looking for didn\'t exist, Do you want to create item?',
                         buttons: Ext.Msg.YESNOCANCEL,
                         icon: Ext.Msg.QUESTION,
                         fn:function(btn,text){
                             if(btn=='no'){
                                  editModelPO.cancelEdit();                                 
                             }
                             else if(btn=='yes'){
                                new_item_form.show();
                                Ext.getCmp("new_win_item_barcode").setValue(Ext.getCmp("item_name_po").getValue());
                                editModelPO.cancelEdit();
                                Ext.getCmp("new_win_item_name").focus();
                             }
                             
                         }
                        });
                        
                    }
                }
               
                
                
            }            
       });
       
       
       uom_store_temp = Ext.create('Ext.data.Store', {
            fields: ['item_id','uom_id','unit_id','unit_name','conv_qty','nprice','sprice','conv_from'],
            data : [
                {"item_id":"0","uom_id":"0", "unit_id":"1", "unit_name":"ea","conv_qty":"1", "nprice":"1", "sprice":"1", "conv_from":"1"}
            ]
      }); 
            temp_unit_price = Ext.create('Ext.data.Store', {
            fields: ['sale_price','head'],
            data : [
                {"sale_price":"0","head":"Base Price"}
            ]
      }); 
          temp_unit_price_uom = Ext.create('Ext.data.Store', {
            fields: ['sale_price','head'],
            data : [
                {"sale_price":"0","head":"Base Price"}
            ]
      }); 
      
       lb_uom_store_temp = Ext.create('Ext.data.Store', {
            fields: ['barcode'],
            data : [
            ]
      });
       

       customer_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_customers,
                extraParams:{
                    fororder:0
                },
                reader:{
                    type:"json",
                    root: 'customers',
                    idProperty: 'cust_id'
                }
        },
        model:Ext.define("customers_model", {
            extend:"Ext.data.Model",
            idProperty: "cust_id",
            fields:[
               "cust_id",
               "cust_contact",
               "cust_phone",
               "cust_name",
               "cust_mobile",
               "cust_status_id",
               "cust_credit_limit",
               "cust_group",
               "account_id"
               ]
        }) && "customers_model" ,
         autoLoad:false
       });   


       customer_store_withall = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:customers_model
       });   
       customer_store_account = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:customers_model
       });   
       customer_store_active = new Ext.data.Store({
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    idProperty: 'cust_id'
                }
            },
            model:customers_model
       });  
        customer_store_active_reg = new Ext.data.Store({
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    idProperty: 'cust_id'
                }
            },
            model:customers_model
       });   
       customer_store.on("datachanged",function(){       
            var records = Ext.pluck(customer_store.data.items,'data');
            customer_store_withall.removeAll();                        
            customer_store_active.removeAll();  
            customer_store_active_reg.removeAll();  
            customer_store_account.removeAll();
            for(var i=0;i <records.length;i++){
                if(records[i].cust_status_id==1){
                    customer_store_active.add(records[i])
                    customer_store_active_reg.add(records[i])
                    customer_store_account.add(records[i])                    
                    customer_store_withall.add(records[i]);                        
                }
            }
            customer_store_account.removeAt(0,1);
            customer_store_withall.insert(0,{"cust_id":"-1","cust_name":labels_json.salesrepwindow.label_all});
            customer_store_active.insert(0,{"cust_id":"-2","cust_name":labels_json.salesrepwindow.label_add_new_customer})
            
            if(user_right=="3"){
                Ext.getCmp("customers_combo").setValue(customer_id);
            }
       });
       //Pay Method store for sale invoice
       
       so_method_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_payment_methods,
                extraParams:{
                    fororder:1
                },
                reader:{
                    type:"json",
                    root: 'methods',
                    idProperty: 'method_id'
                }
        },
        model:Ext.define("pay_methods_model", {
            extend:"Ext.data.Model",
            fields:[
               "method_id",
               "method_name",
               "mehtod_type_id"               
               ]
        }) && "pay_methods_model" ,
         autoLoad:false
       }); 
    security_question_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_security_question,
                
                reader:{
                    type:"json",
                    root: 'question',
                    idProperty: 'id'
                }
        },
        model:Ext.define("security_question_model", {
            extend:"Ext.data.Model",
            fields:[
               "id",
               "question"              
               ]
        }) && "security_question_model" ,
         autoLoad:false
       });
       
       security_question_store_2 = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_security_question,
                
                reader:{
                    type:"json",
                    root: 'question',
                    idProperty: 'id'
                }
        },
        model:Ext.define("security_question_model_2", {
            extend:"Ext.data.Model",
            fields:[
               "id",
               "question"              
               ]
        }) && "security_question_model_2" ,
         autoLoad:false
       });
// Question Store End
       //po stores
       po_receive_item_store = Ext.create('Ext.data.Store', {
            fields: ['item_id','item_name','item_quantity','item_weight','unit_price','discount','sub_total'],
            data : []
        });          
       so_receive_item_store = Ext.create('Ext.data.Store', {
            fields: ['item_id','item_name','item_quantity','item_weight','unit_price','discount','sub_total'],
            data : []
        }); 
                  
       //warehouse store
        warehouse_store = Ext.create('Ext.data.Store', {
            fields: ['id', 'warehouse_name','warehouse_isactive','warehouse_code','warehouse_contact_name','warehouse_phone','warehouse_mobile','warehouse_ddi_number','warehouse_isdefault','warehouse_address','warehouse_street','warehouse_city','warehouse_state','warehouse_country','warehouse_postalcode','warehouse_isactive'],
            data : [{
                    "id":"-1", "warehouse_name":labels_json.salesrepwindow.label_all
                },
                <?php if(isset($warehouse_list)){
                for ($count=0,$size=count($warehouse_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $warehouse_list[$count]['id']?>", "warehouse_name":"<?php echo $warehouse_list[$count]['warehouse_name']?>",
                      "warehouse_isactive":"<?php echo $warehouse_list[$count]['warehouse_isactive']?>", "warehouse_code":"<?php echo $warehouse_list[$count]['warehouse_code']?>",
                      "warehouse_contact_name":"<?php echo $warehouse_list[$count]['warehouse_contant_name']?>", "warehouse_phone":"<?php echo $warehouse_list[$count]['warehouse_phone']?>",
                      "warehouse_mobile":"<?php echo $warehouse_list[$count]['warehouse_mobile']?>", "warehouse_ddi_number":"<?php echo $warehouse_list[$count]['warehouse_ddi_number']?>",   
                      "warehouse_isdefault":"<?php echo $warehouse_list[$count]['warehouse_isdefault']?>", "warehouse_address":"<?php echo $warehouse_list[$count]['warehouse_address']?>",   
                      "warehouse_street":"<?php echo $warehouse_list[$count]['warehouse_street']?>", "warehouse_city":"<?php echo $warehouse_list[$count]['warehouse_city']?>", 
                      "warehouse_state":"<?php echo $warehouse_list[$count]['warehouse_state']?>", "warehouse_country":"<?php echo $warehouse_list[$count]['warehouse_country']?>",   
                      "warehouse_postalcode":"<?php echo $warehouse_list[$count]['warehouse_postalcode']?>", "warehouse_isactive":"<?php echo $warehouse_list[$count]['warehouse_isactive']?>"  
                    }
                    <?php if($count < count($warehouse_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });

      warehouse_store_all= Ext.create('Ext.data.Store', {
            fields: ['id', 'warehouse_name','warehouse_isactive','warehouse_code','warehouse_contact_name','warehouse_phone','warehouse_mobile','warehouse_ddi_number','warehouse_isdefault','warehouse_address','warehouse_street','warehouse_city','warehouse_state','warehouse_country','warehouse_postalcode','warehouse_isactive'],
            data : [
                <?php if(isset($warehouse_list)){
                for ($count=0,$size=count($warehouse_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $warehouse_list[$count]['id']?>", "warehouse_name":"<?php echo $warehouse_list[$count]['warehouse_name']?>",
                      "warehouse_isactive":"<?php echo $warehouse_list[$count]['warehouse_isactive']?>", "warehouse_code":"<?php echo $warehouse_list[$count]['warehouse_code']?>",
                      "warehouse_contact_name":"<?php echo $warehouse_list[$count]['warehouse_contant_name']?>", "warehouse_phone":"<?php echo $warehouse_list[$count]['warehouse_phone']?>",
                      "warehouse_mobile":"<?php echo $warehouse_list[$count]['warehouse_mobile']?>", "warehouse_ddi_number":"<?php echo $warehouse_list[$count]['warehouse_ddi_number']?>",   
                      "warehouse_isdefault":"<?php echo $warehouse_list[$count]['warehouse_isdefault']?>", "warehouse_address":"<?php echo $warehouse_list[$count]['warehouse_address']?>",   
                      "warehouse_street":"<?php echo $warehouse_list[$count]['warehouse_street']?>", "warehouse_city":"<?php echo $warehouse_list[$count]['warehouse_city']?>", 
                      "warehouse_state":"<?php echo $warehouse_list[$count]['warehouse_state']?>", "warehouse_country":"<?php echo $warehouse_list[$count]['warehouse_country']?>",   
                      "warehouse_postalcode":"<?php echo $warehouse_list[$count]['warehouse_postalcode']?>", "warehouse_isactive":"<?php echo $warehouse_list[$count]['warehouse_isactive']?>"  
                    }
                    <?php if($count < count($warehouse_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });  
        


       //price leve store
        pricelevel_store = Ext.create('Ext.data.Store', {
            fields: ['id', 'level_name','level_type','level_dir','level_per','level_round','level_compare_price','level_detail'],
            data : [
                <?php if(isset($pricelevel_list)){
                for ($count=0,$size=count($pricelevel_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $pricelevel_list[$count]['id']?>", "level_name":"<?php echo $pricelevel_list[$count]['level_name']?>",
                      "level_type":"<?php echo $pricelevel_list[$count]['level_type']?>", "level_dir":"<?php echo $pricelevel_list[$count]['level_dir']?>",
                      "level_per":"<?php echo $pricelevel_list[$count]['level_per']?>", "level_round":"<?php echo $pricelevel_list[$count]['level_round']?>",
                      "level_compare_price":"<?php echo $pricelevel_list[$count]['level_compare_price']?>", "level_detail":"<?php echo $pricelevel_list[$count]['level_detail']?>"  
                    }
                    <?php if($count < count($pricelevel_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });        
          
        //customer group store
        customer_group_store = Ext.create('Ext.data.Store', {
            fields: ['id','cust_group_code', 'cust_group_name','cust_group_isdefault'],
            data : [
                <?php if(isset($cust_group_list)){
                for ($count=0,$size=count($cust_group_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $cust_group_list[$count]['id']?>", "cust_group_name":"<?php echo $cust_group_list[$count]['cust_group_name']?>",
                      "cust_group_isdefault":"<?php echo $cust_group_list[$count]['cust_group_isdefault']?>" ,"cust_group_code":"<?php echo $cust_group_list[$count]['cust_group_code']?>"
                    }
                    <?php if($count < count($cust_group_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });
          
           customer_group_store_withall = Ext.create('Ext.data.Store', {
            fields: ['id','cust_group_code', 'cust_group_name','cust_group_isdefault'],
            data : [{
                    "id":"-1", "cust_group_name":labels_json.salesrepwindow.label_all,
                      "cust_group_isdefault":"0" ,"cust_group_code":"00000"
                },
                <?php if(isset($cust_group_list)){
                for ($count=0,$size=count($cust_group_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $cust_group_list[$count]['id']?>", "cust_group_name":"<?php echo $cust_group_list[$count]['cust_group_name']?>",
                      "cust_group_isdefault":"<?php echo $cust_group_list[$count]['cust_group_isdefault']?>" ,"cust_group_code":"<?php echo $cust_group_list[$count]['cust_group_code']?>"
                    }
                    <?php if($count < count($cust_group_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });

             asset_account_withall = Ext.create('Ext.data.Store', {
            fields: ['acc_id','acc_name'],
            data : [{
                    "acc_id":"-1", "acc_name":labels_json.salesrepwindow.label_all
                },
                <?php if(isset($asset_acountlist)){
                for ($count=0,$size=count($asset_acountlist);$count<$size;$count++): ?>
                    {"acc_id":"<?php echo $asset_acountlist[$count]['acc_id']?>" ,"acc_name":"<?php echo $asset_acountlist[$count]['acc_name']?>"
                    }
                    <?php if($count < count($asset_acountlist)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });         
          
          
        //customer type store
        customer_type_store = Ext.create('Ext.data.Store', {
            fields: ['id','cust_type_code', 'cust_type_name','cust_type_isdefault'],
            data : [
                <?php if(isset($cust_type_list)){
                for ($count=0,$size=count($cust_type_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $cust_type_list[$count]['id']?>", "cust_type_name":"<?php echo $cust_type_list[$count]['cust_type_name']?>",
                      "cust_type_isdefault":"<?php echo $cust_type_list[$count]['cust_type_isdefault']?>" ,"cust_type_code":"<?php echo $cust_type_list[$count]['cust_type_code']?>"
                    }
                    <?php if($count < count($cust_type_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });
          
           customer_type_store_withall = Ext.create('Ext.data.Store', {
            fields: ['id','cust_type_code', 'cust_type_name','cust_type_isdefault'],
            data : [{
                    "id":"-1", "cust_type_name":labels_json.salesrepwindow.label_all,
                      "cust_type_isdefault":"0" ,"cust_type_code":"00000"
                },
                <?php if(isset($cust_type_list)){
                for ($count=0,$size=count($cust_type_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $cust_type_list[$count]['id']?>", "cust_type_name":"<?php echo $cust_type_list[$count]['cust_type_name']?>",
                      "cust_type_isdefault":"<?php echo $cust_type_list[$count]['cust_type_isdefault']?>" ,"cust_type_code":"<?php echo $cust_type_list[$count]['cust_type_code']?>"
                    }
                    <?php if($count < count($cust_type_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });
          
          salesrep_storeWithAll = Ext.create('Ext.data.Store', {
            fields: ['id','salesrep_name','salesrep_status'],
            data : [
                {
                    "id":"-1", "salesrep_name":labels_json.salesrepwindow.label_all,
                      "salesrep_status":"1" 
                },
                <?php if(isset($salesrep_list)){
                for ($count=0,$size=count($salesrep_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $salesrep_list[$count]['id']?>", "salesrep_name":"<?php echo $salesrep_list[$count]['salesrep_name']?>",
                    "salesrep_status":"<?php echo $salesrep_list[$count]['salesrep_status']?>"
                    }
                    <?php if($count < count($salesrep_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]
          });
          
          salesrep_store = Ext.create('Ext.data.Store', {
            fields: ['id','salesrep_name','salesrep_status','salesrep_mobile'],
            data : [
              {
                    "id":"-1", "salesrep_name":labels_json.salesrepwindow.add_new_salerep_button,
                      "salesrep_status":"1" 
                },
                <?php if(isset($salesrep_list)){
                for ($count=0,$size=count($salesrep_list);$count<$size;$count++): ?>
                    {"id":"<?php echo $salesrep_list[$count]['id']?>", "salesrep_name":"<?php echo $salesrep_list[$count]['salesrep_name']?>",
                    "salesrep_status":"<?php echo $salesrep_list[$count]['salesrep_status']?>",
                    "salesrep_mobile":"<?php echo $salesrep_list[$count]['salesrep_mobile']?>"
                    }
                    <?php if($count < count($salesrep_list)-1 ) { echo ',';}?>
                <?php endfor; 

                } ?>
            ]


          });
          salesrep_store.filter([   
                {filterFn: function(item) { return item.get("salesrep_status")=="1" ; } }
            ]);
            
       //Load users in start
       user_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_users,
                extraParams:{
                    fororder:1
                },
                reader:{
                    type:"json",
                    root: 'users',
                    idProperty: 'user_id'
                }
        },
        model:Ext.define("aur_users_model", {
            extend:"Ext.data.Model",
            fields:[
                    "user_id",
                    "user_name",
                    "user_group_id",                    
                    "user_status",
                    "user_firstname",
                    "user_lastname",
                    "user_status_text",
                    "customer_id",
                    "user_right",
                    "user_type"
                 ]
        }) && "aur_users_model" ,
         autoLoad:true
       });
       
       user_store_expect = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:aur_users_model
       });   
       user_store_withall = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:aur_users_model
       });   
       
       user_store.on("datachanged",function(){
           var records = Ext.pluck(user_store.data.items,'data');
           user_store_withall.loadData(records);
           user_store_withall.insert(0,{"user_id":"-1","user_name":labels_json.salesrepwindow.label_all});     
           user_store_expect.removeAll();
            for(var i=0;i <records.length;i++){
                if(records[i].user_id!==current_user_id){
                    user_store_expect.add(records[i])
                }
            }
       }); 
        
        
        
        
        unit_store = new Ext.data.Store({
                proxy:{
                type:"ajax",
                async:true,
                url: action_urls.get_units,
                
                reader:{
                    type:"json",
                    root: 'units',
                    idProperty: 'id'
                }
            },
                autoLoad: true,
                model:'common',
             sorters: [{
                 property: 'id',
                 direction: 'ASC'
             }  ]          

        });
        unit_store.on("load",function(){
              // unit_store.insert(0,{"id":"-2","name":"Add New..."});
       unit_store_0 = new Ext.data.Store({
            model:'common',
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    root: 'units'
                }
            },  sorters: [{
                 property: 'id',
                 direction: 'ASC'
             }  ]          

       });

       unit_store_1  = new Ext.data.Store({
            model:'common',
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    root: 'units'
                }
            } , sorters: [{
                 property: 'id',
                 direction: 'ASC'
             }  ]          

             
            
       });  

       });
       unit_store_2  = new Ext.data.Store({
            model:'common',
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    root: 'units'
                }
            },  sorters: [{
                 property: 'id',
                 direction: 'ASC'
             }  ]          
   
       });
       unit_store_3  = new Ext.data.Store({
            model:'common',
            proxy:{
                type:"memory",
                reader:{
                    type:"json",
                    root: 'units'
                }
            },  sorters: [{
                 property: 'id',
                 direction: 'ASC'
             }  ]          
   
       });
       
       unit_store.on("load",function(){
            unit_store_0.loadData(Ext.pluck(unit_store.data.items,'data'));
            unit_store_1.loadData(Ext.pluck(unit_store.data.items,'data'));
            unit_store_2.loadData(Ext.pluck(unit_store.data.items,'data'));
            unit_store_3.loadData(Ext.pluck(unit_store.data.items,'data'));
            
        });
        
       vendor_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_vendors,
                extraParams:{
                    fororder:1
                },
                reader:{
                    type:"json",
                    root: 'vendors',
                    idProperty: 'vendor_id'
                }
        },
        model:Ext.define("vendors_model", {
            extend:"Ext.data.Model",
            fields:[
                    "vendor_id",
                    "vendor_contact",
                    "vendor_name",
                    "vendor_mobile",
                    "vendor_status_id",
                    "vendor_acc_id"
                 ]
        }) && "vendors_model" ,
         autoLoad:false
       });   
       vendor_store_withall = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:vendors_model
       });   
       vendor_store_active = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:vendors_model
       });   
       vendor_store.on("datachanged",function(){
           var records = Ext.pluck(vendor_store.data.items,'data');
           vendor_store_withall.loadData(records);
           vendor_store_withall.insert(0,{"vendor_id":"-1","vendor_name":labels_json.salesrepwindow.label_all});
           vendor_store_active.removeAll();
            for(var i=0;i <records.length;i++){
                if(records[i].vendor_status_id==1){
                    vendor_store_active.add(records[i])
                }
            }
            vendor_store_active.insert(0,{"vendor_id":"-2","vendor_name":labels_json.salesrepwindow.add_new_vendor});
       });      
       
       /*****************************Bank Account*****************/       
       bank_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_banks,
                extraParams:{                 
                },
                reader:{
                    type:"json",
                    root: 'banks',
                    idProperty: 'bank_id'
                }
        },
        model:Ext.define("banks_model", {
            extend:"Ext.data.Model",
            fields:[
                    "bank_id",
                    "bank_name",
                    "bank_status",
                    "balance"
                 ]
        }) && "banks_model",
         autoLoad:false
       });         
       
       bank_store_active = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:banks_model
       });                        
       bank_store.on("datachanged",function(){           
           var records = Ext.pluck(bank_store.data.items,'data');                      
           bank_store_active.removeAll();           
            for(var i=0;i <records.length;i++){
                if(records[i].bank_status=="1"){
                    bank_store_active.add(records[i]);                    
                    payment_method_store.push({"method_id":records[i].bank_id,"method_name":"Bank ("+records[i].bank_name+")","balance":+records[i].balance});
                    if(Ext.getCmp("payment__mode_combo")){
                        Ext.getCmp("payment__mode_combo").store.loadData(payment_method_store);
                        payment_balances[records[i].bank_id] = 0;
                    }
                }
            }
            bank_store_active.insert(0,{"bank_id":"-1","bank_name":"Cash","bank_status":"1"})
       });      
       
       
       /*****************************Expense Accounts*****************/       
       expense_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_all_expenses,
                extraParams:{                 
                },
                reader:{
                    type:"json",
                    root: 'expenses',
                    idProperty: 'expense_id'
                }
        },
        model:Ext.define("expenses_model", {
            extend:"Ext.data.Model",
            fields:[
                    "expense_id",
                    "expense_name",
                    "expense_status"                    
                 ]
        }) && "expenses_model",
         autoLoad:false
       });         
       expense_store_withall = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:expenses_model
       });
       expense_store_active = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:expenses_model
       });                        
       expense_store.on("datachanged",function(){           
           var records = Ext.pluck(expense_store.data.items,'data'); 
           expense_store_withall.loadData(records);
           expense_store_withall.insert(0,{"expense_id":"-1","expense_name":labels_json.salesrepwindow.label_all});
           expense_store_withall.removeAt(2);
           expense_store_active.removeAll();           
            for(var i=0;i <records.length;i++){
                if(records[i].expense_status=="1" && records[i].expense_id!="9"){
                    expense_store_active.add(records[i]);                                                            
                }
            }
       });    
       
        /*****************************Loan Accounts*****************/       
       loan_store = new Ext.data.Store( {
            proxy:{
                type:"ajax",
                url: action_urls.get_all_loans,
                extraParams:{                 
                },
                reader:{
                    type:"json",
                    root: 'loans',
                    idProperty: 'loan_id'
                }
        },
        model:Ext.define("loans_model", {
            extend:"Ext.data.Model",
            fields:[
                    "loan_id",
                    "loan_name",
                    "loan_type",
                    "loan_status"                    
                 ]
        }) && "loans_model",
         autoLoad:false
       });         
       
       loan_store_active = new Ext.data.Store( {
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:loans_model
       });                        
       loan_store.on("datachanged",function(){           
           var records = Ext.pluck(loan_store.data.items,'data');                      
           loan_store_active.removeAll();           
            for(var i=0;i <records.length;i++){
                if(records[i].loan_status=="1"){
                    loan_store_active.add(records[i]);                                                            
                }
            }
       });   
       
       
       /*****************************Setting Wizard*****************/  
       
        win = Ext.create('widget.window', {
                title: 'General Settings',
                closable: true,
                closeAction: 'hide',
                resizable:false,
                width: 750,
                minWidth: 350,
                height: 450,
                layout: 'card',
                modal:true
            });
        rem = Ext.create('widget.window', {
                title: 'Reminders',
                closable: true,
                closeAction: 'hide',
                resizable:false,
                width: 50,
                minWidth: 350,
                height: 450,
                layout: 'card',
                modal:true
            });
      typeStore = new Ext.data.JsonStore({
            proxy:{
                   type:"ajax",
                   url: action_urls.get_account_types,
                   reader:{
                       type:"json",
                       root: 'types',
                       idProperty: 'id'
                   }
           },
           model:typeModel
       });
     typeStore.load();
     /****************** New Dailogs ***************************/
     new_vendor_form = Ext.widget('window', {
        title: labels_json.salesrepwindow.add_new_vendor,
        width: 430,
        height: 240,
        id:'new_vend_form',
        minHeight: 430,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        
        listeners:{
            afterrender:function(){
                    
                    var new_vend_form = new Ext.util.KeyMap("new_vend_form", [
                        {
                            key: [10,13],
                            fn: function(){ 
                                Ext.getCmp("save_vendor").fireHandler();
                            }
                        }
                    ]);  
                },
            show:function(){              
                  var me = this.down('form').getForm();
                  me.reset();              
                   me.findField("vendor_name").focus(true,200);
              
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold; font-size:14px; padding-right:5px; padding-bottom:5px;'
        },
        defaults: {
            margins: '0 0 10 0'
        },
        items: [
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.label_name,
                    name:'vendor_name',
                    id:'_vendor_name',
                    emptyText: labels_json.label_name_emptytext,
                    allowBlank: false,
                    validation:true,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                        OBJ_Action.recordChange();
                        }
                    } 
                },
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.label_obalance,
                    value:'',
                    name:'vendor_obalance',
                    id:'_vendor_obalance',
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    validation:true,
                    emptyText: '0.00',
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.label_phone,
                    name:'vendor_phone',
                    id:'_vendor_phone',
                    maskRe: /([0-9]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                            }
                        } 
                },
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.label_mobile,
                    name:'vendor_mobile',
                    id:'_vendor_mobile',
                    maskRe: /([0-9]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                            }
                        } 
                },
                {
                    xtype:'textarea',
                    fieldLabel:labels_json.label_address,
                    grow:false,
                    height:100,
                    id:'_vendor_address',
                    name:'vendor_address',
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                            }
                        } 
                }
            ],

            buttons: [{
                text: labels_json.label_save,
                id:'save_vendor',
                handler: function() {
                    if (this.up('form').getForm().isValid()) {
                       LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                       this.up('form').getForm().submit({
                            clientValidation: true,
                            url: panel_form_actions["vendor-panel"].save,
                            params: {
                                vendor_ct_name:'',vendor_email:'',vendor_fax:'',vendor_hidden_id:''
                            },
                            success: function(form, action) {
                                LoadingMask.hideMessage();                                
                                new_vendor_form.hide();
                                vendor_store.loadData(action.result.data.vendors);
                                if(active_layout==="purchase-invoice-panel"){
                                    Ext.getCmp("vendors_combo").setValue(""+action.result.obj_id);
                                }
                               
                            },
                            failure: function(form, action) {
                                LoadingMask.hideMessage();
                                failureMessages(form, action);

                            }
                        });

                    }
                }
            },{
                text: labels_json.label_cancel,
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   }); 
   
   function barcode_message(barcode, textfield){
        Ext.Msg.show({
            title:'Error',
            msg: 'This ' + barcode + ' is  already Exit',
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR,
            fn: function (btn, text) {
            if (btn == 'ok') {
                Ext.getCmp(textfield).focus();
                }
              }
           });
    };  
   function isInArray(value, array) {
        return array.indexOf(value) > -1;
   }
   function errorMess(barcode,field) {
        Ext.Msg.show({
            title:'Error',
            msg: 'This ' + barcode + ' is  already Exit',
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR,
            fn: function (btn, text) {
                if (btn == 'ok') {
                    Ext.getCmp(field).focus();
                }
              }
            });
   }
   base_barcode_form = Ext.widget('window', {
        title: 'Barcode add to Base UOM Lookup',
        width: 440,
        height: 150,
        minHeight: 150,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
                Ext.getCmp("base_barcode").focus(true,200);
              
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold'
        },
        
        items: [                
           {
            xtype: 'panel',      
            border:false,
            layout: 'hbox',                                        
            defaults: {
            hideLabel: false,
            labelWidth: 55
            },
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'Barcode',
                    name:'base_barcode',
                    id:'base_barcode',
                    width:300,
                    allowBlank: false,
                    listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("save-base").fireHandler();
                      }
                     }
                   }
                },
                {
                    xtype: 'container',
                    margins: '15 4',
                    layout: {
                    type: 'hbox',
                    pack: 'center'
                    },
                    items:[
                    {
                        xtype: 'button',                                                        
                        iconCls: 'barcode',
                        tooltip: 'Click to generate Barcode',
                        id:'barcode_new_btn_base_barcode',
                        navBtn: true,                                            
                        margin: '2 0 0 8',
                        width:50,
                        listeners:{
                        click:function(){ 
                        Ext.Ajax.request({
                            url: action_urls.generate_item_barcode,
                            params:{},
                            success: function (response) {                                                                    
                                var barcode_Obj = Ext.decode( response.responseText);
                                Ext.getCmp("base_barcode").setValue(barcode_Obj.code); 
                                Ext.getCmp("base_barcode").focus();
                                OBJ_Action.recordChange();
                                },
                                failure: function () {}
                               });  
                             }
                           }
                        },
                        {
                        xtype: 'button',                                                        
                        text: 'Adj',
                        tooltip: 'Click to disabled old item and import stock',
                        id:'barcode_new_btn_adjust_barcode',                        
                        margin: '2 0 0 8',
                        width:30,
                        listeners:{
                        click:function(){ 
                                var barcode_val = Ext.getCmp("base_barcode").getValue();
                                var item_id = Ext.getCmp("item_hidden_id").getValue();
                                if(barcode_val){
                                    Ext.Ajax.request({
                                        url: action_urls.adjust_item_barcode,
                                        method : 'POST',
                                        params:{"barcode":barcode_val,"item_id":item_id},
                                        success: function (response) {                                                                    
                                            var result = Ext.decode( response.responseText);                                                 
                                            alert(result.message);
                                        },
                                        failure: function () {}
                                    });  
                                }
                                else{
                                    alert("Please enter a barcode to adjust.")
                                }
                             }
                           }
                        }
                       ]
                     }
                    ]
                  }
            ],

            buttons: [{
                text: 'Add',
                id: 'save-base',
                handler: function() {
               var base_barcode = Ext.getCmp("base_barcode").getValue();
               var upc_base = Ext.getCmp("upc_basic").getValue();
               var upc_1 = Ext.getCmp("upc_unit_1").getValue();
               var upc_2 = Ext.getCmp("upc_unit_2").getValue();
               var upc_3 = Ext.getCmp("upc_unit_3").getValue();
               var base_uom_code = [];
               base_uom_code.push(upc_base,upc_1,upc_2,upc_3);
               
               var grid_base = Ext.getCmp("upc_basic_lookup").getStore();
               var allRecords_base = grid_base.snapshot || grid_base.data;
               var lookup_base_code = [];
               allRecords_base.each(function(record_uom) {
                    lookup_base_code.push(record_uom.get('id'));
                  });  
               var grid_uom1 = Ext.getCmp("alt_lookup_unit_1").getStore();
               var allRecords_uom1 = grid_uom1.snapshot || grid_uom1.data;
               var lookup_uom1_code = [];
               allRecords_uom1.each(function(record_uom1) {
                    lookup_uom1_code.push(record_uom1.get('id'));
                  });
                  
               var grid_uom2 = Ext.getCmp("alt_lookup_unit_2").getStore();
               var allRecords_uom2 = grid_uom2.snapshot || grid_uom2.data;
               var lookup_uom2_code = [];
               allRecords_uom2.each(function(record_uom2) {
                    lookup_uom2_code.push(record_uom2.get('id'));
                  });
                var grid_uom3 = Ext.getCmp("alt_lookup_unit_3").getStore();
               var allRecords_uom3 = grid_uom3.snapshot || grid_uom3.data;
               var lookup_uom3_code = [];
               allRecords_uom3.each(function(record_uom3) {
                    lookup_uom3_code.push(record_uom3.get('id'));
                  });
                var code = base_uom_code.concat(lookup_base_code, lookup_uom1_code, lookup_uom2_code, lookup_uom3_code);
                var status = isInArray(base_barcode, code);
                if(status==false){
                    Ext.getCmp("upc_basic_lookup").store.add({id:base_barcode});
                    Ext.getCmp("base_barcode").setValue("");            
                    Ext.getCmp("base_barcode").focus();
                } else {
                    errorMess(base_barcode, "base_barcode");
                }
             }
            },{
                text: 'Cancel',
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   });
   /*SMS Window*/
   sms_manual_form = Ext.widget('window', {
        title: 'Send SMS',
        width: 450,
        height: 260,
        minHeight: 200,
        closeAction: 'hide',
        id: 'sms_pay_window',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners: {
            afterrender: function () {
                var map_pay_window = new Ext.util.KeyMap("sms_pay_window", [
                    {
                        key: [10, 13],
                        fn: function () {
                            Ext.getCmp("send_win_button").fireHandler();
                        }
                    }
                ]);
            },
            show: function () {
                var me = this.down('form').getForm();
                me.reset();
                me.findField("mobile_number").focus(true, 100);
                if(Ext.getCmp("register_Type") && Ext.getCmp("register_Type").getValue() == "0" || Ext.getCmp("register_Type").getValue() == "1"){
                    me.findField("mobile_number").setValue(Ext.getCmp("cust_mobile").getValue());
                }                

            }
        },
        items: Ext.widget('form', {
            layout: 'anchor',
            border: false,
            bodyPadding: 10,
            defaults: {
                border: false,
                anchor: '100%'


            },
            items: [
                , {
                    fieldLabel: 'Mobile#',
                    xtype: 'textfield',
                    id: 'mobile_number',
                    allowBlank: false,
                    name: 'mobile_number',                                                    
                    maskRe: /([0-9]+)$/,
                    regex: /[0-9]/,
                    value: ''
                },                            
                {
                    xtype: 'textarea',
                    style: 'margin-top:10px',
                    fieldLabel: 'SMS',
                    allowBlank: false,
                    height: 150,
                    name: 'sms_remarks',
                    id: 'sms_remarks'
                }
            ],

            buttons: [{
                    text: 'Send',
                    id: 'send_win_button',
                    handler: function () {
                        var me = this.up('form').getForm();
                        if (me.isValid()) {
                            LoadingMask.showMessage(labels_json.msg_send_sms);
                            Ext.Ajax.request({
                                url: action_urls.sendsms,
                                params: {
                                    username: api_username,
                                    password: api_password,
                                    from: masking,
                                    user_id: user_id,
                                    user_type: 'customer',
                                    to: me.findField("mobile_number").getValue(),
                                    message: me.findField("sms_remarks").getValue()
                                },
                                success: function () {
                                    LoadingMask.hideMessage();
                                    sms_manual_form.hide();
                                },
                                failure: function () {
                                    LoadingMask.hideMessage();
                                }
                            });
                        }
                    }
                }, {
                    text: 'Cancel',
                    handler: function () {
                        this.up('form').getForm().reset();
                        this.up('window').hide();
                    }
                }]
        })
    });
   uom1_barcode_form = Ext.widget('window', {
        title: 'UOM 1 Barcode',
        width: 400,
        height: 150,
        minHeight: 150,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
                Ext.getCmp("uom1_barcode").focus(true,200);
              
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold'
        },
        
        items: [                
           {
            xtype: 'panel',      
            border:false,
            layout: 'hbox',                                        
            defaults: {
            hideLabel: false,
            labelWidth: 55
            },
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'Barcode',
                    name:'uom1_barcode',
                    id:'uom1_barcode',
                    width:300,
                    allowBlank: false,
                    listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("uom1-base").fireHandler();
                      }
                     }
                   }
                },
                {
                    xtype: 'container',
                    margins: '15 4',
                    layout: {
                    type: 'vbox',
                    pack: 'center'
                    },
                    items:[
                    {
                        xtype: 'button',                                                        
                        iconCls: 'barcode',
                        tooltip: 'Click to generate Barcode',
                        id:'barcode_new_btn_uom1_barcode',
                        navBtn: true,                                            
                        margin: '2 0 0 8',
                        width:50,
                        listeners:{
                        click:function(){ 
                        Ext.Ajax.request({
                            url: action_urls.generate_item_barcode,
                            params:{},
                            success: function (response) {                                                                    
                                var barcode_Obj = Ext.decode( response.responseText);
                                Ext.getCmp("uom1_barcode").setValue(barcode_Obj.code); 
                                Ext.getCmp("uom1_barcode").focus();
                                OBJ_Action.recordChange();
                                },
                                failure: function () {}
                               });  
                             }
                           }
                        }
                       ]
                     }
                    ]
                  }
            ],

            buttons: [{
                text: 'Add',
                id: 'uom1-base',
                handler: function() {
                var base_barcode = Ext.getCmp("uom1_barcode").getValue();
               var upc_base = Ext.getCmp("upc_basic").getValue();
               var upc_1 = Ext.getCmp("upc_unit_1").getValue();
               var upc_2 = Ext.getCmp("upc_unit_2").getValue();
               var upc_3 = Ext.getCmp("upc_unit_3").getValue();
               var base_uom_code = [];
               base_uom_code.push(upc_base,upc_1,upc_2,upc_3);
               
               var grid_base = Ext.getCmp("upc_basic_lookup").getStore();
               var allRecords_base = grid_base.snapshot || grid_base.data;
               var lookup_base_code = [];
               allRecords_base.each(function(record_uom) {
                    lookup_base_code.push(record_uom.get('id'));
                  });  
               var grid_uom1 = Ext.getCmp("alt_lookup_unit_1").getStore();
               var allRecords_uom1 = grid_uom1.snapshot || grid_uom1.data;
               var lookup_uom1_code = [];
               allRecords_uom1.each(function(record_uom1) {
                    lookup_uom1_code.push(record_uom1.get('id'));
                  });
                  
               var grid_uom2 = Ext.getCmp("alt_lookup_unit_2").getStore();
               var allRecords_uom2 = grid_uom2.snapshot || grid_uom2.data;
               var lookup_uom2_code = [];
               allRecords_uom2.each(function(record_uom2) {
                    lookup_uom2_code.push(record_uom2.get('id'));
                  });
                var grid_uom3 = Ext.getCmp("alt_lookup_unit_3").getStore();
               var allRecords_uom3 = grid_uom3.snapshot || grid_uom3.data;
               var lookup_uom3_code = [];
               allRecords_uom3.each(function(record_uom3) {
                    lookup_uom3_code.push(record_uom3.get('id'));
                  });
                var code = base_uom_code.concat(lookup_base_code, lookup_uom1_code, lookup_uom2_code, lookup_uom3_code);
                var status = isInArray(base_barcode, code);
                if(status==false){
                    Ext.getCmp("alt_lookup_unit_1").store.add({id:base_barcode});
                    Ext.getCmp("uom1_barcode").setValue("");            
                    Ext.getCmp("uom1_barcode").focus();
                } else {
                    errorMess(base_barcode, "uom1_barcode");
                }
            }
            },{
                text: 'Cancel',
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   });  
   uom2_barcode_form = Ext.widget('window', {
        title: 'UOM 2 Barcode',
        width: 400,
        height: 150,
        minHeight: 150,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
                Ext.getCmp("uom2_barcode").focus(true,200);
              
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold'
        },
        
        items: [                
           {
            xtype: 'panel',      
            border:false,
            layout: 'hbox',                                        
            defaults: {
            hideLabel: false,
            labelWidth: 55
            },
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'Barcode',
                    name:'uom2_barcode',
                    id:'uom2_barcode',
                    width:300,
                    allowBlank: false,
                    listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("uom2-base").fireHandler();
                      }
                     }
                   }
                },
                {
                    xtype: 'container',
                    margins: '15 4',
                    layout: {
                    type: 'vbox',
                    pack: 'center'
                    },
                    items:[
                    {
                        xtype: 'button',                                                        
                        iconCls: 'barcode',
                        tooltip: 'Click to generate Barcode',
                        id:'barcode_new_btn_uom2_barcode',
                        navBtn: true,                                            
                        margin: '2 0 0 8',
                        width:50,
                        listeners:{
                        click:function(){ 
                        Ext.Ajax.request({
                            url: action_urls.generate_item_barcode,
                            params:{},
                            success: function (response) {                                                                    
                                var barcode_Obj = Ext.decode( response.responseText);
                                Ext.getCmp("uom2_barcode").setValue(barcode_Obj.code); 
                                Ext.getCmp("uom2_barcode").focus();
                                OBJ_Action.recordChange();
                                },
                                failure: function () {}
                               });  
                             }
                           }
                        }
                       ]
                     }
                    ]
                  }
            ],

            buttons: [{
                text: 'Add',
                id: 'uom2-base',
                 handler: function() {
                    var base_barcode = Ext.getCmp("uom2_barcode").getValue();
               var upc_base = Ext.getCmp("upc_basic").getValue();
               var upc_1 = Ext.getCmp("upc_unit_1").getValue();
               var upc_2 = Ext.getCmp("upc_unit_2").getValue();
               var upc_3 = Ext.getCmp("upc_unit_3").getValue();
               var base_uom_code = [];
               base_uom_code.push(upc_base,upc_1,upc_2,upc_3);
               
               var grid_base = Ext.getCmp("upc_basic_lookup").getStore();
               var allRecords_base = grid_base.snapshot || grid_base.data;
               var lookup_base_code = [];
               allRecords_base.each(function(record_uom) {
                    lookup_base_code.push(record_uom.get('id'));
                  });  
               var grid_uom1 = Ext.getCmp("alt_lookup_unit_1").getStore();
               var allRecords_uom1 = grid_uom1.snapshot || grid_uom1.data;
               var lookup_uom1_code = [];
               allRecords_uom1.each(function(record_uom1) {
                    lookup_uom1_code.push(record_uom1.get('id'));
                  });
                  
               var grid_uom2 = Ext.getCmp("alt_lookup_unit_2").getStore();
               var allRecords_uom2 = grid_uom2.snapshot || grid_uom2.data;
               var lookup_uom2_code = [];
               allRecords_uom2.each(function(record_uom2) {
                    lookup_uom2_code.push(record_uom2.get('id'));
                  });
                var grid_uom3 = Ext.getCmp("alt_lookup_unit_3").getStore();
               var allRecords_uom3 = grid_uom3.snapshot || grid_uom3.data;
               var lookup_uom3_code = [];
               allRecords_uom3.each(function(record_uom3) {
                    lookup_uom3_code.push(record_uom3.get('id'));
                  });
                var code = base_uom_code.concat(lookup_base_code, lookup_uom1_code, lookup_uom2_code, lookup_uom3_code);
                var status = isInArray(base_barcode, code);
                if(status==false){
                    Ext.getCmp("alt_lookup_unit_2").store.add({id:base_barcode});
                    Ext.getCmp("uom2_barcode").setValue("");            
                    Ext.getCmp("uom2_barcode").focus();
                } else {
                    errorMess(base_barcode, "uom2_barcode");
                }
                }
            },{
                text: 'Cancel',
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   });
   uom3_barcode_form = Ext.widget('window', {
        title: 'UOM 3 Barcode',
        width: 400,
        height: 150,
        minHeight: 150,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
                Ext.getCmp("uom3_barcode").focus(true,200);
              
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold'
        },
        
        items: [                
           {
            xtype: 'panel',      
            border:false,
            layout: 'hbox',                                        
            defaults: {
            hideLabel: false,
            labelWidth: 55
            },
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'Barcode',
                    name:'uom3_barcode',
                    id:'uom3_barcode',
                    width:300,
                    allowBlank: false,
                    listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("uom3-base").fireHandler();
                      }
                     }
                   }
                },
                {
                    xtype: 'container',
                    margins: '15 4',
                    layout: {
                    type: 'vbox',
                    pack: 'center'
                    },
                    items:[
                    {
                        xtype: 'button',                                                        
                        iconCls: 'barcode',
                        tooltip: 'Click to generate Barcode',
                        id:'barcode_new_btn_uom3_barcode',
                        navBtn: true,                                            
                        margin: '2 0 0 8',
                        listeners:{
                        click:function(){ 
                        Ext.Ajax.request({
                            url: action_urls.generate_item_barcode,
                            params:{},
                            success: function (response) {                                                                    
                                var barcode_Obj = Ext.decode( response.responseText);
                                Ext.getCmp("uom3_barcode").setValue(barcode_Obj.code); 
                                Ext.getCmp("uom3_barcode").focus();
                                OBJ_Action.recordChange();
                                },
                                failure: function () {}
                               });  
                             }
                           }
                        }
                       ]
                     }
                    ]
                  }
            ],

            buttons: [{
                text: 'Add',
                id: 'uom3-base',
                 handler: function() {
                    var base_barcode = Ext.getCmp("uom3_barcode").getValue();
               var upc_base = Ext.getCmp("upc_basic").getValue();
               var upc_1 = Ext.getCmp("upc_unit_1").getValue();
               var upc_2 = Ext.getCmp("upc_unit_2").getValue();
               var upc_3 = Ext.getCmp("upc_unit_3").getValue();
               var base_uom_code = [];
               base_uom_code.push(upc_base,upc_1,upc_2,upc_3);
               
               var grid_base = Ext.getCmp("upc_basic_lookup").getStore();
               var allRecords_base = grid_base.snapshot || grid_base.data;
               var lookup_base_code = [];
               allRecords_base.each(function(record_uom) {
                    lookup_base_code.push(record_uom.get('id'));
                  });  
               var grid_uom1 = Ext.getCmp("alt_lookup_unit_1").getStore();
               var allRecords_uom1 = grid_uom1.snapshot || grid_uom1.data;
               var lookup_uom1_code = [];
               allRecords_uom1.each(function(record_uom1) {
                    lookup_uom1_code.push(record_uom1.get('id'));
                  });
                  
               var grid_uom2 = Ext.getCmp("alt_lookup_unit_2").getStore();
               var allRecords_uom2 = grid_uom2.snapshot || grid_uom2.data;
               var lookup_uom2_code = [];
               allRecords_uom2.each(function(record_uom2) {
                    lookup_uom2_code.push(record_uom2.get('id'));
                  });
                var grid_uom3 = Ext.getCmp("alt_lookup_unit_3").getStore();
               var allRecords_uom3 = grid_uom3.snapshot || grid_uom3.data;
               var lookup_uom3_code = [];
               allRecords_uom3.each(function(record_uom3) {
                    lookup_uom3_code.push(record_uom3.get('id'));
                  });
                var code = base_uom_code.concat(lookup_base_code, lookup_uom1_code, lookup_uom2_code, lookup_uom3_code);
                var status = isInArray(base_barcode, code);
                if(status==false){
                    Ext.getCmp("alt_lookup_unit_3").store.add({id:base_barcode});
                    Ext.getCmp("uom3_barcode").setValue("");            
                    Ext.getCmp("uom3_barcode").focus();
                } else {
                    errorMess(base_barcode, "uom3_barcode");
                }
                }
            },{
                text: 'Cancel',
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   });
   
     new_customer_form = Ext.widget('window', {
        title: labels_json.add_customers,
        width: 400,
        height: 590,
        minHeight: 590,
        closeAction:'hide',
        id:'new_cust_form',
        layout: 'fit',
        closable:true,
        resizable: true,
        modal: true,
        listeners:{
        afterrender:function(){
                    
                    var new_cust_form = new Ext.util.KeyMap("new_cust_form", [
                        {
                            key: [10,13],
                            fn: function(){ 
                                Ext.getCmp("save_cust").fireHandler();
                            }
                        }
                    ]);  
                },
            show:function(){                                      
                  var me = this.down('form').getForm();
                  me.reset();                  
                  me.findField("cust_name").focus(true,200);
              
              
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold; font-size:14px; padding-right:5px; padding-bottom:5px;'
        },
        defaults: {
            margins: '0 0 10 0'
        },
        items: [
        {
                    xtype: 'textfield',
                    fieldLabel: labels_json.label_name,
                    name:'cust_name',
                    emptyText: labels_json.label_name_emptytext,
                    allowBlank: false,
                },
                {
                    xtype: 'textfield',
                    fieldLabel: labels_json.label_obalance,
                    name:'cust_obalance',
                    emptyText: '0.00',
                    value:''
                },
                {
                    xtype:'combo',
                    fieldLabel: labels_json.label_group,
                    displayField: 'cust_group_name',
                    name:'cust_group_name',
                    id:'_cust_group_name',
                    store: customer_group_store,
                    emptyText: 'Select Customer Group',
                    queryMode: 'local',
                    valueField:'id',
                    value:'1',
                    editable:true,                                       
                    typeAhead: true,
                    listeners:{
                        change:function(obj,n,o,e){                                                
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                                {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.label_payment_term,
                                       name:'cust_payment_terms',
                                       id:'_cust_payment_terms',
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },
                                     {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.label_credit_limit,
                                       name:'cust_credit_limit',
                                       id:'_cust_credit_limit',
                                       maskRe: /([0-9\s\.]+)$/,
                                       regex: /[0-9]/,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },
                {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.label_phone,
                                       name:'cust_phone',
                                       id:'_cust_phone',
                                       maskRe: /([0-9]+)$/,
                                       regex: /[0-9]/,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    }
                                    ,
                                     {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.label_mobile,
                                       name:'cust_mobile',
                                       id:'_cust_mobile',
                                       maskRe: /([0-9]+)$/,
                                       regex: /[0-9]/,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },
                                    {
                                       xtype:'textarea',
                                       fieldLabel:labels_json.label_address,
                                       grow:false,
                                       height:100,
                                       id:'_cust_address',
                                       name:'cust_address',
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                       
                                       
                                    }
        ],

            buttons: [{
                text: labels_json.label_save,
                id:'save_cust',
                handler: function() {
                    if (this.up('form').getForm().isValid()) {
                       LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                       this.up('form').getForm().submit({
                            clientValidation: true,
                            url: panel_form_actions["customer-panel"].save,
                            params: {
                                entry_date: getDateMysqlFormatWithTime(new Date()),
                                 cust_price_level:0,cust_group_name:1,cust_type_name:1,cust_ct_name:'',cust_email:'',cust_credit_limit:'',cust_fax:'',
                             cust_hidden_id:-1
                            },
                            success: function(form, action) {
                                LoadingMask.hideMessage();                                                                
                                new_customer_form.hide();
                                customer_store.loadData(action.result.data.customers);
                                if(active_layout==="sale-invoice-panel"){
                                    Ext.getCmp("customers_combo").setValue(""+action.result.obj_id);
                                }
                               
                            },
                            failure: function(form, action) {
                                LoadingMask.hideMessage();
                                failureMessages(form, action);

                            }
                        });

                    }
                }
            },{
                text: labels_json.label_cancel,
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   }); 


  inv_customize_form = Ext.widget('window', {
         title: labels_json.inv_customization,
         width: 400,
         height: 300,
         minHeight: 300,
         closeAction:'hide',
         id:'inv_customization_form',
         layout: 'fit',
         closable:true,
         resizable: true,
         modal: true,
         listeners:{
         afterrender:function(){
            var map_pay_window = new Ext.util.KeyMap("inv_customization_form", [{
                key: [10,13],
                fn: function(){ 
                    Ext.getCmp("save_inv_cust").fireHandler();
            }
        }
        ]);  
      }
    },
         items: Ext.widget('form', {
         layout: {
             type: 'vbox',
             align: 'stretch'
         },
         border: false,
         bodyPadding: 10,

         fieldDefaults: {
             labelAlign: 'top',
             labelWidth: 100,
             labelStyle: 'font-weight:bold'
         },
         defaults: {
             margins: '0 0 10 0'
         },
        items: [
            {
                boxLabel: labels_json.text_prevbalance,
                name: 'so_allow_prevbalance',
                margin: '0 0 0 0',
                inputValue: '1',
                checked: true,
                xtype: 'checkboxfield',
                id: 'so_allow_prevbalance',
                listeners: {
                    change: function () {}
                }
            },
            {
                boxLabel: labels_json.text_gatepass,
                name: 'so_gate_pass',
                inputValue: '1',
                checked: false,
                xtype: 'checkboxfield',
                id: 'so_gate_pass',
                listeners: {
                    change: function (checkbox, newValue, oldValue, eOpts) {
                        OBJ_Action.recordChange();
                    }
                }
            },
            {
                boxLabel: labels_json.text_showregister_inv,
                name: 'so_register_inv',
                inputValue: '1',
                checked: true,
                xtype: 'checkboxfield',
                id: 'so_register_inv',
                listeners: {
                    change: function (checkbox, newValue, oldValue, eOpts) {
                        if(newValue) {
                            Ext.getCmp("show_register_inv").setValue('1'); 
                        } else {
                            Ext.getCmp("show_register_inv").setValue('0');
                        }
                    }
                }
            },{
                boxLabel: labels_json.text_showregister_print,
                name: 'so_register_print',
                inputValue: '1',
                checked: true,
                xtype: 'checkboxfield',
                id: 'so_register_print',
                listeners: {
                    change: function (checkbox, newValue, oldValue, eOpts) {
                        if(newValue) {
                            Ext.getCmp("show_register_print").setValue('1'); 
                        } else {
                            Ext.getCmp("show_register_print").setValue('0');
                        }
                    }
                }
            },
            {
                boxLabel: labels_json.salesrepwindow.label_email,
                name: 'so_allow_email',
                id: 'so_allow_email',
                margin: '0 0 0 0',
                inputValue: '1',
                xtype: 'checkboxfield',
                checked: false,
                id: 'so_allow_email',
                listeners: {
                    change: function () {
                        OBJ_Action.recordChange();
                    }
                }
            },
            {
                boxLabel: labels_json.text_send_message_cust,
                name: 'so_send_message_cust',
                id: 'so_send_message_cust',
                margin: '0 0 0 0',
                inputValue: '1',
                xtype: 'checkboxfield',
                checked: true,
                id: 'so_send_message_cust',
                listeners: {
                    change: function () {
                        OBJ_Action.recordChange();
                    }
                }
            },
            {
                boxLabel: labels_json.text_send_message_salerep,
                name: 'so_send_message_salerep',
                id: 'so_send_message_salerep',
                margin: '0 0 0 0',
                inputValue: '1',
                xtype: 'checkboxfield',
                checked: false,
                id: 'so_send_message_salerep',
                listeners: {
                    change: function () {
                        OBJ_Action.recordChange();
                    }
                }
            }
        ],

             buttons: [{
                 text: labels_json.button_cancel,
                 handler: function() {
                     this.up('window').hide();
                 }
             }]
         })
    }); 


    new_item_form = Ext.widget('window', {
        title: labels_json.text_add_item,
        width: 400,
        height: 500,
        minHeight: 480,
        closeAction:'hide',
        layout: 'fit',
        id:'item_create_window',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){              
                  var me = this.down('form').getForm();
                  me.reset();                          
                  Ext.getCmp("__item_cat_id").setValue(labels_json.customertypewindow.text_type_default);
                  me.findField("name").focus(true,100);
                  
                  if(active_layout==="purchase-invoice-panel"){
                    me.findField("quantity").setDisabled(true);
                  }
                  else{
                    me.findField("quantity").setDisabled(false);  
                  }
            },
            afterrender:function(){

                   var map_pay_window = new Ext.util.KeyMap("item_create_window", [
                       {
                           key: [10,13],
                           fn: function(){ Ext.getCmp("item_create_button").fireHandler();}
                       }
                   ]);  
           }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,
        id:'new_item_form_window',
        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold;  font-size:14px; padding-right:5px; padding-bottom:5px;'
        },
        defaults: {
            margins: '0 0 10 0'
        },
        items: [                
                {
                xtype:'combo',
                fieldLabel:labels_json.text_type,
                id:'_item_type_search',
                allowBlank: false,
                valueField:'type_id_search',
                displayField:'type_name_search',
                name:'item_type_search',
                value:'1',
                allowBlank: false,
                forceSelection : true,
                store: Ext.create('Ext.data.Store', {
                    fields: ['type_id_search', 'type_name_search'],
                    data : [
                    {
                        "type_id_search":"1", 
                        "type_name_search":"Stackable"
                    },

                    {
                        "type_id_search":"3", 
                        "type_name_search":"Service"
                    }
                    ]
                }),
                queryMode:'local',
                listeners:{
                    change:function(e,t){
                        if (t == 1){
                            Ext.getCmp('quantity').show()
                            Ext.getCmp('nprice').show()
                            Ext.getCmp('item_type').setValue(1)
                            //Ext.getCmp('item_create_window').setHeight(470)
                        }
                        else{
                            Ext.getCmp('quantity').hide()
                            Ext.getCmp('nprice').hide()
                            Ext.getCmp('item_type').setValue(3)
                            Ext.getCmp('nprice').setValue(1)
                            Ext.getCmp('quantity').setValue(1)
                            //Ext.getCmp('item_create_window').setHeight(150)
                        }
                    }
                } 
                
            },{
                xtype: 'textfield',
                fieldLabel: labels_json.text_name,
                emptyText: labels_json.text_name_placeholder,
                id:'new_win_item_name',
                name:'name',
                allowBlank: false
            },{
                xtype:'hidden',
                name:'item_image_path',              
                value:'1'
            },
            {
                xtype:'hidden',
                name:'cat_id',
                id:'__item_cat_hidden_id',
                value:'1'
            },{
                        xtype:'pickerfield',
                        fieldLabel:labels_json.text_category,
                        allowBlank: false,
                        id:'__item_cat_id',
                        editable:false,
                        typeAhead: true,
                        autoScroll: false,
                        createPicker: function() {
                            return Ext.create('Ext.tree.Panel', {
                                floating: true,
                                minHeight: 300,
                                height:300,
                                rootVisible: true,
                                collapsible: false,
                                id:'_item_cat_tree',
                                useArrows:false,
                            store:  cattree_store,
                            columns: [{
                                xtype: 'treecolumn', 
                                text: labels_json.text_name,
                                style: 'font-weight:bold; font-size:14px; padding-right:15px; width:30%;',
                                flex: 1,
                                sortable: false,
                                dataIndex: 'name'
                            },{
                                text: labels_json.text_description,
                                style: 'font-weight:bold;  font-size:14px; padding-right:10px; width:70%;',
                                flex: 2,
                                dataIndex: 'description',
                                sortable: false
                            }],
                            listeners:{
                                select: function(thisTree, record, index, obj ){
                                                            
                                    var selected_cat = record.getPath('name'," → ").substr(5);
                                    if(record.data.id==1){
                                        selected_cat = labels_json.customertypewindow.text_type_default;
                                    }
                                    Ext.getCmp('__item_cat_id').setValue(selected_cat);  
                                    Ext.getCmp('__item_cat_hidden_id').setValue(record.data.id);
                                    Ext.getCmp('__item_cat_id').collapse();
                                                            
                                },
                                render:function(){
                                                               
                                }
                                ,
                                show:function(thisTree,obj){
                                    var select_cat = Ext.getCmp("__item_cat_hidden_id").getValue();                                                                                                                              
                                    var record = this.getStore().getNodeById(select_cat);
                                    this.getSelectionModel().select(record);                      
                                                           
                                },                                                           
                                beforeitemcollapse:{
                                    fn:function(node){                                       
                                        return false;
                                    }
                                }
                            }
                            });
                    },
                    listeners:{
                        change:function(obj,n,o,e){
                            if(n==-1){
                                obj.setValue(o);
                                                    
                            //category_form.show();
                            }                            
                        }
                    } 
                }, {
                xtype: 'textfield',
                fieldLabel: labels_json.text_qty_on_hand,
                name:'quantity',
                id:'quantity',
                maskRe: /([0-9\s\.]+)$/,
                regex: /[0-9]/
            }, {
                    xtype: 'fieldcontainer',
                    fieldLabel: labels_json.text_bar_code,
                    combineErrors: true,
                    msgTarget : 'side',
                    layout: 'hbox',
                    defaults: {
                        hideLabel: true
                    },
                    items: [
                    {
                        xtype:'textfield',
                        fieldLabel:labels_json.text_bar_code,
                        name:'barcode',
                        margin: '0 5 0 0',
                        id:'new_win_item_barcode',
                        flex: 4
                    },
                    {
                        xtype:'button',
                        text:labels_json.text_generate,    
                        flex: 1,                        
                        width:80,
                        listeners:{
                            click:function(){                                                            
                                Ext.Ajax.request({
                                    url: action_urls.generate_item_barcode,
                                    params:{},
                                    success: function (response) {                                                                    
                                        var barcode_Obj = Ext.decode( response.responseText);
                                        Ext.getCmp("new_win_item_barcode").setValue(barcode_Obj.code);  
                                        OBJ_Action.recordChange();
                                    },
                                    failure: function () {}
                                });   
                                                            
                            }
                        }
                    }
                    ]
                }, {
                xtype: 'textfield',
                fieldLabel: labels_json.text_purchase_price,
                id: 'nprice',
                name:'nprice',
                maxLength: 7,
                allowBlank: false,                
                maskRe: /([0-9\s\.]+)$/,
                regex: /[0-9]/
            }, {
                xtype: 'textfield',
                fieldLabel: labels_json.text_sales_price,
                name:'sprice',
                allowBlank: false,                
                maxLength: 7,
                maskRe: /([0-9\s\.]+)$/,
                regex: /[0-9]/
            },
            {
                xtype: 'hiddenfield',                
                name:'avgcost'
            },
            {
                xtype: 'hiddenfield',                
                name:'part_number',
                value:''
            },
            {
                xtype: 'hiddenfield',
                value: '1',
                id: 'item_type',
                name:'item_type'
            },
            {
                xtype: 'hiddenfield',
                value: '2',
                name:'acc_cogs_id'
            },
            {
                xtype: 'hiddenfield',
                value: '5',
                name:'acc_income_id'
            },{
                xtype:'hidden',
                name:'item_hidden_id',
                value:'0'
            },{
                xtype:'hidden',
                name:'item_map_hidden_id',                
                value:'0'
            },
                                     
                {
                    xtype: 'filefield',
                    name: 'item_image',
                    hidden:true,
                    fieldLabel: '',
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    } 
                },{
                xtype:'hidden',
                name:'acc_asset_id',                
                value:'1'
            },{
                xtype:'hidden',
                name:'reorder_point',                
                value:'0'
            },{
                xtype:'hidden',
                name:'_item_unit',                
                value:'1'
            },{
                xtype:'hidden',
                name:'item_weight',                
                value:'0'
            }
            ],

            buttons: [{
                text: labels_json.button_save,
                id: 'item_create_button',
                handler: function() {
                    if (this.up('form').getForm().isValid()) {
                       var salePrice=  parseFloat(this.up('form').getForm().findField("sprice").getValue())
                       var purchasePrice = parseFloat(this.up('form').getForm().findField("nprice").getValue())
                       if(purchasePrice>salePrice){
                           Ext.Msg.show({
                                title:'Confirm',
                                msg: 'Purchase price is greater than sale price, Are you sure you want to proceed?',
                                buttons: Ext.Msg.YESNO,
                                icon: Ext.Msg.QUESTION,
                                fn:function(btn,text){
                                    if(btn=='yes'){                                       
                                        saveItemFromDialog();                                                                              
                                    }
                                }
                           });
                       }
                       else{
                           saveItemFromDialog();
                       }    
                    }
                }
            },{
                text: labels_json.button_cancel,
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   });
   
    
     update_password_win = Ext.widget('window', {
        title: '',
        width: '100%',
        height: 675,
        header: false,
        minHeight: 675,
        closeAction:'hide',
        layout: 'fit',
        id:'update_password_window',
        resizable: false,
        modal: true,
        listeners:{
        beforeclose:function(win) {
                return false;
                },
            show:function(){              
                  var me = this.down('form').getForm();
                  me.reset();                          
                  me.findField("update_username").focus(true,100);
                 
            },
            afterrender:function(){

                   var map_pay_window = new Ext.util.KeyMap("update_password_window", [
                       {
                           key: [10,13],
                           fn: function(){ Ext.getCmp("update_password_button").fireHandler();}
                       }
                   ]);  
           },
           beforerender:function(){
                security_question_store.load();
                security_question_store_2.load();
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,
        id:'update_password_form_window',
        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold'
        },
        defaults: {
            margins: '0 0 10 0'
        },
        items: [{
            xtype: 'fieldset',
            title: '<h3 style="color:#177EE5;">Change Default Password</h3>',
            style: 'width:300px; padding-top: 5px; padding-bottom: 15px; margin-left:400px;margin-right:400px;',
            width: 300,
            items: [{
                xtype: 'hidden',
                id:'user_id',
                name:'user_id',
                value:user_id,
                width: 500,
            },                
                {
                xtype: 'textfield',
                fieldLabel: 'User Name (<small>Change / update your username</small>)',
                id:'update_username',
                name:'update_username',
                width: 500,
            },{
                xtype: 'textfield',
                fieldLabel: 'New Password (<small>Please Enter New Password, new Pass should not be "1234"</small>)',
                name:'new_password',
                id:'new_password',
                inputType: 'password',
                msgTarget : 'under',
                inputAttrTpl: " data-qtip='Password Pattern<br> Abc@123' ",
                allowBlank: false,
                regex: /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/,
                width: 500,
            }, {
                xtype: 'textfield',
                fieldLabel: 'Conform Password (<small>This Password should be same as you enter above</small>)',
                name:'conform_password',
                id:'conform_password',
                allowBlank: false, 
                msgTarget : 'under',
                inputAttrTpl: " data-qtip='Password Pattern<br> Abc@123' ",
                inputType: 'password',
                regex: /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/,
                width: 500,
            },{
                xtype: 'combo',
                fieldLabel: 'Question No 1',
                allowBlank: false,
                id:'question_1',
                displayField: 'question',
                editable:false,
                valueField:'id',
                queryMode: 'local',
                name:'question_1',
                value:'',
                emptyText: 'Select a Question',
                store:security_question_store,
                width: 500,
                listeners:{
                    change:function(obj,newValue,oldValue,eOpt){
                       var grid = Ext.getCmp('question_1'); 
                       var project = grid.findRecord('id', oldValue);                       
                       security_question_store_2.removeAt(security_question_store_2.indexOfId(newValue));
                       if(project){
                       var question =  project.get('question');
                       Ext.getCmp('question_2').store.add({id:oldValue,question:question});
                        }  
                    }
                } 
            },{
                xtype: 'textfield',
                fieldLabel: 'Answer No 1',
                allowBlank: false,
                id:'answer_1',
                name:'answer_1',
                width: 500,
            },{
                xtype: 'combo',
                fieldLabel: 'Question No 2',
                allowBlank: false,
                id:'question_2',
                displayField: 'question',
                editable:false,
                valueField:'id',
                queryMode: 'local',
                name:'question_2',
                value:'',
                emptyText: 'Select a Question',
                width: 500,
                store:security_question_store_2,
                listeners:{
                    change:function(obj,newValue,oldValue,eOpt){
                       var grid = Ext.getCmp('question_2'); 
                       var project = grid.findRecord('id', oldValue);                       
                       security_question_store.removeAt(security_question_store.indexOfId(newValue));
                       if(project){
                       var question =  project.get('question');
                       Ext.getCmp('question_2').store.add({id:oldValue,question:question});
                        }  
                    }
                } 
            },{
                xtype: 'textfield',
                fieldLabel: 'Answer No 2',
                allowBlank: false,
                id:'answer_2',
                name:'answer_2',
                width: 500,
            },{
                xtype:'button',
                text:'Update',
                id:'update_password_button',
                style:'margin-left:420px; margin-top:10px',
                width: 80,
                listeners:{
                    click:function(){
                        if (this.up('form').getForm().isValid()) {
                       LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                       this.up('form').getForm().submit({
                            clientValidation: true,
                            url: action_urls.save_security_question,
                            params: {
                            },
                            success: function(form, action) {
                                LoadingMask.hideMessage();
                                
                                if(action.result.success==1){
                                    Ext.Msg.show({
                                            title:'Update Password',
                                            msg: action.result.msg,
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.INFO,
                                            fn:function(btn,text){
                                                if(btn=='ok'){
                                                    update_password_win.hide();
                                                }
                                            }
                                        });
                                     } else {
                                     Ext.Msg.show({
                                            title:'Error',
                                            msg: action.result.msg,
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.ERROR,
                                            fn: function (btn,text) {
                                            if (btn=='ok') {
                                                Ext.getCmp("update_username").setValue("");
                                                Ext.getCmp("new_password").setValue("");
                                                Ext.getCmp("conform_password").setValue("");
                                                Ext.getCmp("answer_1").setValue("");
                                                Ext.getCmp("answer_2").setValue("");
                                                Ext.getCmp("update_username").focus(true,200);
                                                }
                                              }
                                           });
                                    }
                               
                            },
                            failure: function(form, action) {
                                LoadingMask.hideMessage();
                                failureMessages(form, action);

                            }
                        });

                    }
                    }
                }
            }]
        }]
        })
   });  
        if(update_pass==0){
             update_password_win.show();
         } 
        
   function saveItemFromDialog(){
        if(Ext.getCmp('item_type').value == 1){
            var set_url = panel_form_actions["item-panel"].save
        }
        else{
            var set_url = panel_form_actions["item-panel"].save_service
        } 
        LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
        Ext.getCmp("new_item_form_window").getForm().submit({
             clientValidation: true,
             url: set_url,
             params: {
                 entry_date: getDateMysqlFormatWithTime(new Date()),
                 items:"",
                 map_id:"0",
                 vendor_id:"",
                 acc_vendor_id:""
             },
             success: function(form, action) {
                 LoadingMask.hideMessage();
                 document.documentElement.scrollTop=0;
                 var item_name = Ext.getCmp("new_win_item_name").getValue();
                 new_item_form.hide();
                 // console.log(item_name)                                                               
                  OBJ_Action.addRecord();
                  if(active_layout==="sale-invoice-panel" ){
                     Ext.getCmp("item_name_so").doQuery(item_name)
                     //    

                     // Ext.defer(function(){
                     //     Ext.getCmp("item_name_so").setValue(item_name);                                                         
                     //     Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100); 
                     //      OBJ_Action.searchKeyPress = OBJ_Action.searchKeyPress + 1;
                     //    OBJ_Action.searchChange = OBJ_Action.searchChange + 1;   
                     //    OBJ_Action.shiftFocus = false;
                     //     // Ext.getBody().select(".x-boundlist").setStyle("display","none");
                     // },100)
                        Ext.defer(function(){
                         Ext.getCmp("item_name_so").setValue(item_name); 
                         Ext.getCmp("item_quantity_so").focus();  

                         // Ext.getBody().select(".x-boundlist").setStyle("visibility","hidden");
                     })
                   
                    
                 }
                 else if(active_layout==="purchase-invoice-panel"){
                     Ext.getCmp("item_name_po").doQuery(item_name,true)                                    
                     Ext.defer(function(){
                         Ext.getCmp("item_name_po").setValue(item_name); 
                         Ext.getCmp("item_quantity_po").focus();  

                         Ext.getBody().select(".x-boundlist").setStyle("display","none");
                     },300)
                 }                                 


             },
             failure: function(form, action) {
                 LoadingMask.hideMessage();
                 failureMessages(form, action);
             }
         });
   }
     
     account_form = Ext.widget('window', {
        title: 'Account',
        width: 400,
        height: 380,
        minHeight: 380,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              if(winMode && winMode>0){
                  var selectionModel = Ext.getCmp("accounts-panel-grid").selModel.getSelection()[0];
                  var me = this.down('form').getForm();
                  me.findField('acc_name').setValue(selectionModel.get('acc_name'));
                  me.findField('acc_description').setValue(selectionModel.get('acc_desc'));
                  me.findField('acc_type_id').setValue(selectionModel.get('acc_type_id'));
                  me.findField('acc_obalance').setValue(selectionModel.get('acc_balance'));
                  me.findField('acc_obalance').setDisabled(true);                  
                  me.findField('acc_status').setValue(selectionModel.get('acc_status_id'));
                  me.findField('account_id').setValue(selectionModel.get('id'));
                  
                  if(selectionModel.get('acc_type_id')=="16"){
                  account_form.setHeight(420);
                  Ext.Ajax.request({
                    url: action_urls.get_credit_merchant,
                    method : 'GET',
                    params:{acc_id:selectionModel.get('id')},
                    success: function (response) {          
                        var result = Ext.decode(response.responseText);                      
                        Ext.getCmp("credit_card_percentage").setDisabled(false);
                        Ext.getCmp("percentage_to_from").setDisabled(false);
                        Ext.getCmp("credit_card_percentage").setValue(result.percentage);
                        Ext.getCmp("percentage_to_from").setValue(result.fromto);
                        
                    },
                    failure: function () {
                    }
                 });
                 }
                 else{
                    account_form.setHeight(380);
                 }
              } 
              else{
                  var me = this.down('form').getForm();
                  me.reset();
                  me.findField('account_id').setValue(0);
                  me.findField('acc_obalance').setDisabled(false);
              }
              me.findField("acc_name").focus(true,100);
            }
        },
        items: Ext.widget('form', {
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        border: false,
        bodyPadding: 10,

        fieldDefaults: {
            labelAlign: 'top',
            labelWidth: 100,
            labelStyle: 'font-weight:bold'
        },
        defaults: {
            margins: '0 0 10 0'
        },
        items: [{
                xtype: 'combo',
                fieldLabel: 'Account Type',
                allowBlank: false,
                id:'account_type_store',
                displayField: 'type',
                editable:false,
                valueField:'id',
                queryMode: 'local',
                name:'acc_type_id',
                value:'1',
                store:typeStore,
                listeners:{
                    change:function(obj,val){
                        if(val=="16"){
                            Ext.getCmp("credit_merchant_area").setVisible(true);
                            Ext.getCmp("credit_card_percentage").setDisabled(false);
                            Ext.getCmp("percentage_to_from").setDisabled(false);
                            account_form.setHeight(420);
                        }
                        else{
                             Ext.getCmp("credit_merchant_area").setVisible(false);
                             Ext.getCmp("credit_card_percentage").setDisabled(true);
                             Ext.getCmp("percentage_to_from").setDisabled(true);
                             account_form.setHeight(380);
                        }
                        var enable_opening_balance = ["1", "2", "6", "8","14", "15","17"];                        
                        if(enable_opening_balance.indexOf(val)>-1){
                            Ext.getCmp('field_acc_obalance').setDisabled(false);        
                        }
                        else{
                            Ext.getCmp('field_acc_obalance').setDisabled(true);        
                        } 
                    }
                } 
            },
                {
                    xtype: 'hiddenfield',
                    name: 'account_id',
                    value: '0'
                },
                {
                xtype: 'textfield',
                fieldLabel: 'Account Name',
                name:'acc_name',
                allowBlank: false
            }, {
                xtype: 'textarea',
                grow:false,
                height:70,
                fieldLabel: 'Description',
                name:'acc_description'
            }, 
            
             {
                xtype: 'fieldcontainer',
                    fieldLabel: '',
                    combineErrors: true,
                    msgTarget : 'side',
                    id:'credit_merchant_area',
                    hidden:true,
                    layout: 'hbox',
                    defaults: {
                        hideLabel: true
                    },
                    items: [
                    {
                        xtype:'textfield',
                        fieldLabel:'Percentage',
                        name:'percentage',
                        disabled:true,
                        margin: '0 5 0 0',
                        maskRe: /([0-9\s\.]+)$/,
                        regex: /[0-9]/,
                        allowBlank: false,
                        id:'credit_card_percentage',
                        flex: 2,
                        emptyText: 'Percentage'
                    },
                    {
                     xtype:'box',      
                     autoEl:{tag:"div", html:'%',cls:""},
                     width:'20'
                    }
                    , 
                    {
                      xtype:'combo',
                      queryMode:'local',
                      displayField:'name',
                      id : 'percentage_to_from',
                      value : "1",
                      disableddisabled:true,
                      allowBlank: false,
                      name:'per_to_from',
                      flex: 2,
                      fieldLabel:'Charge',
                      store: Ext.create('Ext.data.Store', {
                              fields: ['id', 'name'],
                              data : [
                                      {"id":"1", "name":"Business"},
                                      {"id":"2", "name":"Customer"}
                              ]
                          }),
                      valueField:'id'                      
                  }
                    ]
                }
            
            , {
                xtype: 'textfield',
                fieldLabel: 'Opening Balance',
                name:'acc_obalance',
                id : 'field_acc_obalance',
                maskRe: /([0-9\s\.]+)$/,
                regex: /[0-9]/
            },
            {
                xtype: 'combo',
                fieldLabel: 'Account Status',
                value:'1',
                queryMode: 'local',
                displayField: 'type',
                valueField:'id',
                name:'acc_status',
                editable:false,
                queryMode: 'local',
                store:{
                    proxy:{
                        type:"memory",
                        reader:{
                            type:"json"
                        }
                },
                model:Ext.define("accountStatusModel", {
                    extend:"Ext.data.Model",
                    fields:[
                        "id",
                        "type"
                        ]
                }) && "accountStatusModel",
                 data:[{id:'1',type:'Enabled'},{id:'0',type:'Disabled'}
                 ]}
            }
            ],

            buttons: [{
                text: 'Save',
                handler: function() {
                    if (this.up('form').getForm().isValid()) {
                       LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                       this.up('form').getForm().submit({
                            clientValidation: true,
                            url: action_urls.saveupdate_account,
                            params: {
                                entry_date: getDateMysqlFormatWithTime(new Date())
                            },
                            success: function(form, action) {
                                LoadingMask.hideMessage();
                                account_store.loadData(action.result.data.accounts);
                                account_store.insert(0,{"id":"-1","acc_name":"Add New..."});
                                
                                if(account_selected_combo){
                                   Ext.getCmp(account_selected_combo).setValue(action.result.obj_id);
                                   
                                   account_selected_combo = null;
                                }
                                if(Ext.getCmp("accounts-panel-grid")){
                                    Ext.getCmp("accounts-panel-grid").store.load();
                                }
                                
                                account_form.hide();
                               
                            },
                            failure: function(form, action) {
                                LoadingMask.hideMessage();
                                failureMessages(form, action);

                            }
                        });

                    }
                }
            },{
                text: 'Cancel',
                handler: function() {
                    this.up('form').getForm().reset();
                    this.up('window').hide();
                }
            }]
        })
   });  
   /*Pay window*/
   invoice_pay_form = Ext.widget('window', {
        title: labels_json.pay_order,
        width: 450,
        height: 200,
        minHeight: 270,
        closeAction:'hide',
        id:'invoice_pay_window',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var me = this.down('form').getForm();              
              me.reset();
              me.findField("paid_total").focus(true,100);              
              if(sale_invoice_mode==1){
                  me.findField("paid_total").setReadOnly(true)              
              }
              else{
                 me.findField("paid_total").setReadOnly(false)              
              }
            },
            afterrender:function(){
                    
                    var map_pay_window = new Ext.util.KeyMap("invoice_pay_window", [
                        {
                            key: [10,13],
                            fn: function(){ 
                               
                                Ext.getCmp("invoice_pay").fireHandler();
                            }
                        }
                    ]);  
                },
            beforerender:function(){
                so_method_store.load();
            }
        },
        items: Ext.widget('form', {
        layout: 'anchor',
        border: false,
        bodyPadding: 10,
        defaults: {
            border:false,
            anchor: '100%'
           
        },
        items: [{
                xtype:'datefield',
                fieldLabel:labels_json.date_paid,
                value: new Date(),                
                id:'payment_paid_date',
                name:'payment_paid_date',
                maxValue: new Date(),
                format: 'd-m-Y'  
          },
          {
                xtype:'hidden',
                value: new Date(),                
                id:'po_pay_time',
                name:'po_pay_time',
                maxValue: new Date(),
                format: 'H:i:s'  
          },
          {
                   xtype:'combo',
                   fieldLabel:labels_json.payment_method,
                   id:'payment__methods_combo',
                   allowBlank: false,
                   valueField:'method_id',
                   displayField:'method_name',
                   name:'payment_method',
                   value:'-1',
                   store: so_method_store,
                   queryMode:'local',
                   listeners:{}
            },{
                  xtype: 'panel',
                  html: '',
                  id:'alreadypaid',
                  cls: 'paidtext'
              },
                {
                fieldLabel:labels_json.button_pay,
                cls:'pay',
                xtype:'textfield',                                             
                id:'paid_total',
                name:'paid_total',
                maskRe: /([0-9\s\.]+)$/,
                regex: /[0-9]/,
                validateValue : function(value){
                    var isValid = true;
                    if(value==0){
                        isValid=false;
                    }
                    return isValid;
                },
                value:'0.00',
                listeners: {
                    
                   change: function (obj,newValue,oldValue,eOpt) { 
                    var value = parseFloat(Ext.getCmp("paid_total").getValue());
                       if (sale_invoice_mode == "1" || purchase_invoice_return_mode == "1") {
                            if (value > 0) {
                                Ext.getCmp("paid_total").setValue(value * -1);
                            }
                            
                        } 
                        var oldV= "";
                        if(Ext.getCmp("G_order_type").getValue()=='1'){
                        var status_val = ""; var _total_amount = ""; var payment = "";
                        var  _total_paid = parseFloat(Ext.getCmp("po_payment_paid").getValue());
                        if(purchase_invoice_return_mode === 1){
                            _total_amount = parseFloat(-1*Ext.getCmp("po_total").getValue());
                            payment = (-1*value)+(_total_paid);
                        } else {
                            _total_amount = parseFloat(Ext.getCmp("po_total").getValue());
                            payment = value+_total_paid;
                        }
                        
                        if(payment>0 && payment<_total_amount){
                            Ext.getCmp("po_order_pay_status").setValue('2') 
                        } else if (payment > 0 && payment == _total_amount ) {
                            Ext.getCmp("po_order_pay_status").setValue('3')
                        } 
                            oldV = Ext.getCmp("po_payment_total_balance").getValue().replace('-','');
                        } else {
                            oldV = Ext.getCmp("so_total_balance").getValue().replace('-','');
                        } 
                       var newV = Ext.getCmp("paid_total").getValue().replace('-','');
                       
                       if(oldV >"0" &&  parseFloat(newV) > parseFloat(oldV) ){
                                Ext.getCmp("paid_total").setValue(Ext.getCmp("so_total_balance").getValue());
                             }
                   }
                }
            },
            {
                xtype:'textarea',
                style:'margin-top:10px',
                fieldLabel:labels_json.remarks,
                height:80,                
                name:'payment_remarks',
                id:'payment_remarks'
            },{
                xtype:'hidden',
                name:'G_order_type',
                id:'G_order_type',
                value:'0'
           },
           {
                xtype:'hidden',
                name:'po_order_status',
                id:'po_order_pay_status',
                value:'0'
           },
           {
                xtype:'hidden',
                name:'G_invoice_id',
                id:'G_invoice_id',
                value:'0'
           },
           {
                xtype:'hidden',
                name:'G_vendor_id',
                id:'G_vendor_id',
                value:'0'
           }
          ],

        buttons: [{
            text: labels_json.button_pay,
            id:'invoice_pay',
            handler: function() {
                var me = this.up('form').getForm();
                if (me.isValid()) {                    
                    var _url = "";
                    var pay_type = me.findField("G_order_type").getValue();
                    var pay_total = 0;
                    
                    if(pay_type=="1"){
                        if(Ext.getCmp("po_hidden_id").getValue() !== "0"){
                            _url = action_urls.po_pay;
                            var pay_payments = me.findField("paid_total").getValue().replace('-','');
                            pay_total=Ext.util.Format.number(parseFloat(pay_payments)+parseFloat(Ext.getCmp("po_payment_paid").getValue()),"0.00");                          
                          } else { 
                                
                                _url = "";                                        
                                invoice_pay_form.hide();
                                var pay_payments = me.findField("paid_total").getValue().replace('-','');
                                pay_total = Ext.util.Format.number(parseFloat(pay_payments)+parseFloat(Ext.getCmp("po_payment_paid").getValue()),"0.00");
                                Ext.getCmp("po_payment_paid").setValue(parseFloat(Ext.getCmp("po_payment_paid").getValue()) + parseFloat(Ext.getCmp("paid_total").getValue()));
                                
                                OBJ_Action.saveme();

                          }
                        }
                        else if(pay_type == "2"){
                        var _total_paid = parseFloat(Ext.getCmp("so_paid").getValue());
                            if(Ext.getCmp("so_hidden_id").getValue() !== "0"){ 
                                
                                var so_balance = Ext.util.Format.number(Ext.getCmp("sub_total_total_so").getValue());
                                var customer_pre_balance = Ext.util.Format.number(Ext.getCmp("prev_total_balance").getValue());
                                var _grand_total = +so_balance + +customer_pre_balance;
                                var pay = Ext.util.Format.number(parseFloat(Ext.getCmp("so_paid").getValue()), "0.00");
                                var paid = Ext.util.Format.number(parseFloat(Ext.getCmp("paid_total").getValue()), "0.00");
                                var customer_mobile = Ext.getCmp("customer_mobile").getValue();
                                var payment = Ext.util.Format.number(parseFloat(+pay + +paid), "0.00");
                                var remaining = Ext.util.Format.number(parseFloat(_grand_total - payment), "0.00");
                                var message = "Sale Inv Amount = " + so_balance + " Rs" + "\nPrev Amount = " + customer_pre_balance + " Rs" + "\nTotal Amount = " + _grand_total + " Rs" + "\nYou Paid = " + payment + " Rs" + " \nRem Bal = " + remaining + " Rs" + "\nThank you \n" + store_name;
                                
                                
                                
                                if(use_message=='1' && customer_mobile!=''){
                                    Ext.Ajax.request({
                                                url             : action_urls.sendsms,
                                                params:{
                                                    username    : api_username,
                                                    password    : api_password,
                                                    from        : masking,
                                                    user_id     : user_id,
                                                    user_type   : 'customer',
                                                    to          : customer_mobile,
                                                    message     : message
                                                },
                                                success         : function () { },
                                                failure         : function () { }
                                            }); 
                                    }
                                _url = action_urls.so_pay;
                                var pay_payments = me.findField("paid_total").getValue().replace('-','');
                                Ext.getCmp("so_paid").setValue(pay_payments);
                                pay_total = Ext.util.Format.number(parseFloat(pay_payments)+parseFloat(Ext.getCmp("so_payment_paid").getValue()),"0.00");
                            } else { 
                                var so_balance = Ext.util.Format.number(Ext.getCmp("sub_total_total_so").getValue());
                                var customer_pre_balance = Ext.util.Format.number(Ext.getCmp("prev_total_balance").getValue());
                                var _grand_total = +so_balance + +customer_pre_balance;
                                var pay = Ext.util.Format.number(parseFloat(Ext.getCmp("so_paid").getValue()), "0.00");
                                var paid = Ext.util.Format.number(parseFloat(Ext.getCmp("paid_total").getValue()), "0.00");
                                var customer_mobile = Ext.getCmp("customer_mobile").getValue();
                                var payment = Ext.util.Format.number(parseFloat(+pay + +paid), "0.00");
                                if(Ext.getCmp("customers_combo").getValue()=="0"){ 
                                    var remaining = Ext.util.Format.number(parseFloat(_grand_total - payment), "0.00");
                                } else {
                                    var remaining = Ext.util.Format.number(parseFloat(_grand_total - paid), "0.00");
                                }
                                
                                var message = "Sale Inv Amount = " + so_balance + " Rs" + "\nPrev Amount = " + customer_pre_balance + " Rs" + "\nTotal Amount = " + _grand_total + " Rs" + "\nYou Paid = " + payment + " Rs" + " \nRem Bal = " + remaining + " Rs" + "\nThank you \n" + store_name;
                                
                                if(use_message=='1' && customer_mobile!=''){
                                        //alert(message);
                                    Ext.Ajax.request({
                                                url             : action_urls.sendsms,
                                                params:{
                                                    username    : api_username,
                                                    password    : api_password,
                                                    from        : masking,
                                                    user_id     : user_id,
                                                    user_type   : 'customer',
                                                    to          : customer_mobile,
                                                    message     : message
                                                },
                                                success         : function () {},
                                                failure         : function () {}
                                            }); 
                                    }
                                _url = "";                                        
                                invoice_pay_form.hide();
                                var pay_payments = me.findField("paid_total").getValue().replace('-','');
                                pay_total = Ext.util.Format.number(parseFloat(pay_payments)+parseFloat(Ext.getCmp("so_payment_paid").getValue()),"0.00");
                                Ext.getCmp("so_paid").setValue(parseFloat(Ext.getCmp("so_paid").getValue()) + parseFloat(Ext.getCmp("paid_total").getValue()));
                                var soPaymentId = Ext.getCmp("payment__methods_combo").getValue();
                                if(typeof(soPaymentId)!=="number"){
                                   soPaymentId = -1;
                                }                    
                                Ext.getCmp("so_payment_id").setValue(soPaymentId);
                                OBJ_Action.saveme();

                          }  
                        }       
                                        
                    if(_url){
                    LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                    this.up('form').getForm().submit({
                         clientValidation: true,
                         url: _url,
                         params: {
                             payment_time:Ext.Date.format(new Date(),'H:i:s')
                         },
                         success: function(form, action) {

                             LoadingMask.hideMessage(); 
                             // OBJ_Action.saveme();                            
                             invoice_pay_form.hide();

                             if(action.result.success){
                                Ext.Msg.show({
                                   title:'Success',
                                   msg: action.result.msg,
                                   buttons: Ext.Msg.OK,
                                   icon: Ext.Msg.INFO
                                });
                                                        
                               
                                // Ext.getCmp("tb_btn_po_save").setDisabled(true)   
                             // Ext.getCmp("tb_btn_po_save_new").setDisabled(true) 
                             // Ext.getCmp("delete_po_invoice").setDisabled(true) 
                                if(pay_type=="1"){
                                    Ext.getCmp("po_payment_paid").setValue(pay_total);
                                    var status_val = Ext.getCmp("po_order_pay_status").getValue();
                                    Ext.getCmp("po_order_status").setValue(status_val);
                                    Ext.getCmp("po_status").setValue(OBJ_Action.invoiceStatus['_' + status_val]);
                                    Ext.get("img_stamp_po").dom.className = "stamps " + OBJ_Action.invoiceStatusImage['_' + status_val];
                                    
                                }
                                else if(pay_type=="2"){
                                    Ext.getCmp("so_payment_paid").setValue(pay_total);
                                    Ext.getCmp("so_paid").setValue(parseFloat(Ext.getCmp("so_paid").getValue()) + parseFloat(Ext.getCmp("paid_total").getValue()));
                                     // console.log(pay_total)
                                    Ext.getCmp("so_paid").setValue(parseFloat(Ext.getCmp("sub_total_total_so").getValue()));
                                    // Ext.getCmp("so_total_balance").setValue(pay_total);
                                   
                                    OBJ_Action.editme(); 
                                }
                            }
                            else{
                                Ext.Msg.show({
                                   title:'Success',
                                   msg: 'Ooops some thing went wrong. Please try again.',
                                   buttons: Ext.Msg.OK,
                                   icon: Ext.Msg.ERROR
                                });
                            }
                         },
                         failure: function(form, action) {
                             LoadingMask.hideMessage();
                             failureMessages(form, action);

                         }
                     });
                  }   
                }
            }
        },{
            text: labels_json.button_cancel,
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
   });  
   /*End Pay window*/
   
   /***Start of payment management ****/   
   payment_management_win= Ext.widget('window', {
        title: 'Payment Details',
        width: 750,
        height: 500,
        minHeight: 400,
        closeAction:'hide',
        modal: true,
        layout: 'border',
        listeners:{
            show:function(){

            }
        },
        resizable: true,
        items:[{
            region:'center',
            layout:'fit',
            items:[{
                xtype:"gridpanel",
                id:"m_payment_grid",
                plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                clicksToMoveEditor: 1,
                                autoCancel: false,
                                 listeners:{
                      
                                    'edit': function(e) {                                              
                                        var p_date = Ext.getCmp("m_date").getValue();
                                        var p_method='1';//Ext.getCmp("m_pay_method").getValue();
                                        var p_remarks= Ext.getCmp("m_remarks").getValue();
                                        var p_amount= parseFloat(Ext.getCmp("m_pay_amount").getValue());
                                        var p_invoice_id = Ext.getCmp("payment_invoice_id").getValue();
                                        if(p_amount>0){
                                         var sm = Ext.getCmp("m_payment_grid").getSelectionModel();   
                                         var id = sm.getSelection()[0].get('payment_id');
                                         var  save_payment = ""
                                         if(Ext.getCmp("G_payment_type").getValue()=="1"){
                                            save_payment = action_urls.po_pay
                                         }
                                         else{
                                            save_payment = action_urls.so_pay
                                         }

                                             Ext.Ajax.request({
                                                url: save_payment,
                                                params:{
                                                    invoice_id : id,
                                                    G_invoice_id:p_invoice_id,
                                                    payment_method:p_method,
                                                    paid_total:p_amount,
                                                    payment_remarks : p_remarks,
                                                    payment_paid_date: p_date
                                                },
                                                success: function (response) {
                                                    var data = Ext.JSON.decode(response.responseText);
                                                    var _store= Ext.getCmp("m_payment_grid").store;
                                                    var last_record = null;
                                                    if(id=="0"){
                                                        last_record = _store.data.items[_store.getCount()-1];
                                                        last_record.set("ref_no",data.ref_no);
                                                        last_record.set("payment_id",data.ref_no);
                                                    }
                                                    OBJ_Action.payment_update();
                                                    OBJ_Action.editme();
                                                   // Ext.getCmp("m_payment_grid").store.load(response);
                                                },
                                                failure: function () {}
                                            });

                                       }
                                    },
                                   'canceledit':function(e){
                                       if(parseFloat(Ext.getCmp("m_pay_amount").getValue())==0){
                                           var sm = e.grid.getSelectionModel();
                                            Ext.getCmp("m_payment_grid").store.remove(sm.getSelection());
                                            if ( Ext.getCmp("m_payment_grid").store.getCount() > 0) {
                                                sm.select(0);
                                            }
                                       }
                                   },
                                   'beforeedit':function(e){
                                       //payment_management_editModel.cancelEdit();                                       
                                   }
                               }
                                
                        })],
                        margin:'0 0 2 0',
                         store:{
                                proxy:{
                                        type:"memory",
                                        reader:{
                                                type:"json",
                                                idProperty: 'payment_id'
                                        }
                        },                        
                        model:Ext.define("modelPaymentManagement", {
                                extend:"Ext.data.Model",
                                fields:[
                                        "payment_id",
                                        {name:"payment_date",type:'date',format:'d-m-Y'},
                                        "payment_method",
                                        "payment_method_id",
                                        "ref_no",
                                        "payment_remarks",                                        
                                        {name:"payment_amount",type:'number'}
                                        

                                        ]
                        }) && "modelPaymentManagement",
                        data:[]
                },
                listeners:{
                afterRender : function(cmp) {
                        payment_management_editModel = Ext.getCmp("m_payment_grid").plugins[0];
                        //this.superclass.afterRender.call(this);
                        this.nav = new Ext.KeyNav(this.getEl(),{
                                del: function(e){

                                }
                        });
                        cmp.getSelectionModel().on('selectionchange', function(selModel, selections){
                            if(selections.length === 1){
                                Ext.getCmp('delete_payments').setDisabled(false);
                            }
                            else{
                                Ext.getCmp('delete_payments').setDisabled(true);
                            }
                        });
                       
                }

                },

                columnLines: true,
                columns:[
                {header:"Date",dataIndex:"payment_date",width:150,renderer:Ext.util.Format.dateRenderer('d-m-Y') ,  
                    editor: {     
                                    xtype:'datefield',                                                                          
                                    id:'m_date',
                                    allowBlank: false,
                                    value: new Date(),
                                    maxValue: new Date(),
                                    format: 'd-m-Y'                                                                                
                            }
                },
                {header:"Method",dataIndex:"payment_method",width:100,
                        editor: {
                                xtype: 'combo',
                                allowBlank: false,
                                queryMode:'local',
                                displayField:'method_name',                                                
                                store: Ext.create('Ext.data.Store', {
                                fields: ['method_id', 'method_name'],
                                data : [
                                    {"method_id":"1", "method_name":"Cash"}
                                ]
                                }),
                                valueField:'method_name',
                                value:'method_id',
                                id:'m_pay_method',
                                listeners:{
                                   change:function(f,obj){                                           
                                        var record = f.findRecordByValue(f.getValue());
                                        if(record){                                            
                                            var sel = Ext.getCmp('m_payment_grid').getSelectionModel().getSelection()[0];
                                            sel.set("payment_method_id",record.get("method_id"));

                                        } 
                                    }
                                }
                        }
                }, 
                {
                    header: 'Ref #',
                    dataIndex:"ref_no",
                    width:100
                }
                ,
                 {header:"Remarks",dataIndex:"payment_remarks",flex:1,
                         editor: {
                                xtype: 'textfield',
                                id:'m_remarks',                                
                                enableKeyEvents:true,
                                listeners:{
                                    keyup:function(){
                                            
                                    }
                                }                                 

                        }
                   },
                   {header:"Amount",dataIndex:"payment_amount",width:200,renderer:function(v){return Ext.util.Format.number(v,"0.00")},
                        editor: {
                               xtype: 'textfield',
                               id:'m_pay_amount',                             
                               maskRe: /([0-9\s\.]+)$/,
                               regex: /[0-9]/,
                               enableKeyEvents:true,
                               listeners:{
                                   keyup:function(){
                                           
                                   }
                               }                                 

                        }
                    }
                ],
                 dockedItems: [{
                            xtype: 'toolbar',
                            items: [{
                                text: 'Pay',
                                iconCls: 'new',
                                tooltip:'Make a new payment',
                                handler: function(){
                                    payment_management_editModel.cancelEdit();
                                     var r = Ext.create('modelPaymentManagement', {
                                        payment_date: new Date(),
                                        payment_method: 'Cash',
                                        payment_method_id:'1',
                                        payment_remarks:'',
                                        payment_amount:'0.00',
                                        payment_id : "0"
                                    });
                                    var pay_count =  Ext.getCmp("m_payment_grid").store.getCount();
                                    Ext.getCmp("m_payment_grid").store.insert(pay_count, r);                                    
                                    payment_management_editModel.startEdit(pay_count, 0);
                                    
                                }
                            }, '-', {
                                id:'delete_payments',
                                text: 'Delete',
                                iconCls: 'delete',
                                tooltip:'Delete payment',
                                disabled: true,
                                handler: function(){
                                    payment_management_editModel.cancelEdit();
                                    var sm = Ext.getCmp("m_payment_grid").getSelectionModel();
                                    var del_payment = "";
                                    if(Ext.getCmp("G_payment_type").getValue()=="1"){
                                         del_payment = action_urls.po_pay_del
                                    }
                                    else{
                                         del_payment = action_urls.so_pay_del
                                    }
                                    
                                    if (sm.getSelection().length==1) {
                                        var _pay_del_id = sm.getSelection()[0].get('payment_id');
                                        Ext.getCmp("m_payment_grid").store.remove(sm.getSelection()[0]);
                                        Ext.Ajax.request({
                                            url: del_payment,
                                            params:{
                                                id:_pay_del_id
                                            },
                                            success: function (response) {
                                                 OBJ_Action.payment_update();
                                            },
                                            failure: function () {}
                                        });
                                    }
                                }
                            }]
                        }]
            }
           ]
         },{
            region:'south',
            layout:'fit',
            style:'background-color:#fff',
            border:false,
            bodyBorder:false,
            padding:'0 10 0 5',
            defaults:{
                    border:false,
                    bodyBorder:false
                },
            height:80,
            items:[{
                        layout:{
                             type: 'table',
                             columns:2,
                             tableAttrs:{
                               width:'200px',
                               style:'float:right'
                             }
                       },
                       items:[{
                             xtype:'box',    
                             autoEl:{tag:'div',html:'Total Paid:',cls:'sub_total_text'}
                     },
                     {
                             xtype:'textfield',     
                             style:'float:right',
                             cls:'total_digit_field',
                             readOnly:true,
                             width:100,
                             id:'m_total_paid',
                             name:'m_total_paid',
                             value:'0.00'
                     },
                     {
                             xtype:'box',    
                             autoEl:{tag:'div',html:'Balance:',cls:'sub_total_text'}
                     },
                     {
                             xtype:'textfield',    
                             style:'float:right',
                             id:'m_balance',
                             name:'m_balance',
                             readOnly:true,
                             cls:'total_digit_field',
                             value:'0.00',
                             width:100,
                             enableKeyEvents:true,
                                     listeners:{
                                             
                                     }  
                     },
                     {
                             xtype:'box',    
                             autoEl:{tag:'div',html:'Invoice Total:',cls:'sub_total_text'}
                     },
                     {
                             xtype:'textfield',     
                             style:'float:right',
                             cls:'total_digit_field',
                             readOnly:true,
                             width:100,
                             value:'0.00',
                             id:'m_invoice_total'
                     }
                    ]
                },{
                xtype:'hidden',
                id:'G_payment_type',
                value:'0'
                },{
                xtype:'hidden',
                id:'payment_invoice_id',
                value:'0'
                }
              ]
            
         }],
        buttons: [{
            text: 'Close',
            handler: function() {                
                this.up('window').hide();
            }
        }]
   });
   /* End of Payment Management*/
   testing = Ext.widget('window', {
    
});
   /* Warehouse  start window */
   warehouse_form = Ext.widget('window', {
        title: 'Warehouse',
        width: 800,
        height: 280,
        minHeight: 200,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var me = this.down('form').getForm();
              if(winMode && winMode>0){
                  var selectionModel = Ext.getCmp("warehouse-panel-grid").selModel.getSelection()[0];
            
                  me.findField('warehouse_name').setValue(selectionModel.get("warehouse_name"));
                  me.findField('warehouse_code').setValue(selectionModel.get("warehouse_code"));
                  me.findField('warehouse_contact_name').setValue(selectionModel.get("warehouse_contact_name"));
                  me.findField('warehouse_phone').setValue(selectionModel.get("warehouse_phone"));
                  me.findField('warehouse_mobile').setValue(selectionModel.get("warehouse_mobile"));
                  me.findField('warehouse_ddi_number').setValue(selectionModel.get("warehouse_ddi_number"));
                  me.findField('warehouse_address').setValue(selectionModel.get("warehouse_address"));
                  me.findField('warehouse_street').setValue(selectionModel.get("warehouse_street"));
                  me.findField('warehouse_city').setValue(selectionModel.get("warehouse_city"));
                  me.findField('warehouse_state').setValue(selectionModel.get("warehouse_state"));
                  me.findField('warehouse_country').setValue(selectionModel.get("warehouse_country"));
                  me.findField('warehouse_postalcode').setValue(selectionModel.get("warehouse_postalcode"));
                  me.findField('warehouse_isactive').setValue(selectionModel.get("warehouse_isactive"));
                  me.findField('warehouse_isdefault').setValue(selectionModel.get("warehouse_isdefault"));
                  me.findField('w_isactive').setValue(selectionModel.get("warehouse_isactive"));
                  me.findField('w_isdefault').setValue(selectionModel.get("warehouse_isdefault"));
                  me.findField('warehouse_id').setValue(selectionModel.get("id"));
              } 
              else{
                  me.reset();
                  me.findField('warehouse_id').setValue(0);
              }
            }
        },
        items: Ext.widget('form', {
        layout:'column',
        border: false,
        bodyPadding: 10,
        defaults: {
                layout: 'anchor',
                border:false,
                defaults: {
                   anchor: '95%'
                }
        },
        items: [
           {
            columnWidth: 1/2,
            baseCls:'x-plain',
        
                marginBottom:10,
            items:[{
                    xtype: 'hiddenfield',
                    name: 'warehouse_id',
                    value: '0'
                },{
                        xtype:'textfield',
                        fieldLabel:'Warehouse Name',
                        name:'warehouse_name',
                        id:'warehouse_name',
                        allowBlank: false
                },
                {
                        xtype:'textfield',
                        fieldLabel:'Warehouse Code',
                        name:'warehouse_code',
                        id:'warehouse_code',
                        allowBlank: false
                },{
                       xtype:'textfield',
                       fieldLabel:'Contact Name',
                       name:'warehouse_contact_name',
                       id:'warehouse_contact_name' 
                },{
                       xtype:'textfield',
                       fieldLabel:'Phone Number',
                       name:'warehouse_phone',
                       id:'warehouse_phone' 
                },{
                       xtype:'textfield',
                       fieldLabel:'Mobile Number',
                       name:'warehouse_mobile',
                       id:'warehouse_mobile' 
                },{
                       xtype:'textfield',
                       fieldLabel:'DDI Number',
                       name:'warehouse_ddi_number',
                       id:'warehouse_ddi_number' 
                },{
                       xtype:'checkboxfield',
                       fieldLabel:'Default',
                       name:'w_isdefault',
                       id:'w_isdefault' ,
                       listeners:{
                           change:function(){
                                var is_default = this.getValue()?1:0;
                                this.up('form').getForm().findField('warehouse_isdefault').setValue(is_default);
                           }
                      }
                },
                {
                    xtype: 'hiddenfield',
                    name: 'warehouse_isdefault',
                    id: 'warehouse_isdefault',
                    value: '0'
                }
             ]
            },
            
            {
            columnWidth: 1/2,
            baseCls:'x-plain',
            items:[{
                       xtype:'textfield',
                       fieldLabel:'Address Name',
                       name:'warehouse_address',
                       id:'warehouse_address' 
                },{
                       xtype:'textfield',
                       fieldLabel:'Street Address',
                       name:'warehouse_street',
                       id:'warehouse_street' 
                },{
                       xtype:'textfield',
                       fieldLabel:'Town / City',
                       name:'warehouse_city',
                       id:'warehouse_city' 
                },{
                       xtype:'textfield',
                       fieldLabel:'State / Region',
                       name:'warehouse_state',
                       id:'warehouse_state' 
                },{
                       xtype:'textfield',
                       fieldLabel:'Country',
                       name:'warehouse_country',
                       id:'warehouse_country' 
                },{
                       xtype:'textfield',
                       fieldLabel:'Postal Code',
                       name:'warehouse_postalcode',
                       id:'warehouse_postalcode' 
                },{
                       xtype:'checkboxfield',
                       fieldLabel:'Active',
                       name:'w_isactive',
                       id:'w_isactive',
                       checked:true,
                       listeners:{
                           change:function(){
                                var is_active = this.getValue()?1:0;
                                this.up('form').getForm().findField('warehouse_isactive').setValue(is_active);
                           }
                      } 
                }, {
                    xtype: 'hiddenfield',
                    name: 'warehouse_isactive',
                    id: 'warehouse_isactive',
                    value: '1'
                }]
            }
        ],

        buttons: [{
            text: labels_json.button_save,
            handler: function() {
                if (this.up('form').getForm().isValid()) {
                   LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                   this.up('form').getForm().submit({
                        clientValidation: true,
                        url: action_urls.saveupdate_warehouse,
                        params: {

                        },
                        success: function(form, action) {
                            LoadingMask.hideMessage();
                            warehouse_store.loadData(action.result.data);
                            //account_store.insert(0,{"id":"-1","warehouse_name":"Add New..."});
                            if(Ext.getCmp("warehouse-panel-grid")){
                                Ext.getCmp("warehouse-panel-grid").store.load();
                            }

                            warehouse_form.hide();

                        },
                        failure: function(form, action) {
                            LoadingMask.hideMessage();
                            failureMessages(form, action);

                        }
                    });

                }
            }
        },{
            text: labels_json.button_cancel,
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
   });  
   /*Warehosue window end*/
   
   
   
   /********* sales rep window *******////////
   
   /* Warehouse  start window */
   salesrep_form = Ext.widget('window', {
        title: '',
        width: 700,
        height: 280,
        minHeight: 200,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var me = this.down('form').getForm();
              if(winMode && winMode>0){
                  var selectionModel = Ext.getCmp("salesrep-panel-grid").selModel.getSelection()[0];
            
                  me.findField('salesrep_name').setValue(selectionModel.get("salesrep_name"));                  
                  me.findField('salesrep_title').setValue(selectionModel.get("salesrep_title"));
                  me.findField('salesrep_phone').setValue(selectionModel.get("salesrep_phone"));
                  me.findField('salesrep_mobile').setValue(selectionModel.get("salesrep_mobile"));                  
                  me.findField('salesrep_address').setValue(selectionModel.get("salesrep_address"));
                  me.findField('salesrep_email').setValue(selectionModel.get("salesrep_email"));
                  me.findField('salesrep_status').setValue(selectionModel.get("salesrep_status"));                  
                  me.findField('rep_isactive').setValue(selectionModel.get("salesrep_status"));                  
                  me.findField('salesrep_id').setValue(selectionModel.get("id"));
              } 
              else{
                  me.reset();
                  me.findField('salesrep_id').setValue(0);
              }
            }
        },
        items: Ext.widget('form', {
        layout:'column',
        border: false,
        bodyPadding: 10,
        defaults: {
                layout: 'anchor',
                border:false,
                defaults: {
                   anchor: '95%'
                }
        },
        items: [
           {
            columnWidth: 1/2,
            baseCls:'x-plain',
        
                marginBottom:10,
            items:[{
                    xtype: 'hiddenfield',
                    name: 'salesrep_id',
                    value: '0'
                },
                {
                    xtype:'combo',
                    fieldLabel:labels_json.salesrepwindow.label_title,
                    id:'salesrep_title',
                    allowBlank: false,
                    valueField:'type_id',
                    displayField:'type_name',
                    name:'salesrep_title',
                    value:'1',
                    store: Ext.create('Ext.data.Store', {
                        fields: ['type_id', 'type_name'],
                        data : [
                                {"type_id":"1", "type_name":"Mr."},
                                {"type_id":"2", "type_name":"Miss"},
                                {"type_id":"3", "type_name":"Mrs."}
                        ]
                    }),
                    queryMode:'local'
                }
                ,{
                        xtype:'textfield',
                        fieldLabel:labels_json.salesrepwindow.label_name,
                        name:'salesrep_name',
                        allowBlank: false,
                        id:'salesrep_name',
                        allowBlank: false
                },
                {
                    xtype: 'textareafield',
                    name: 'salesrep_address',
                    fieldLabel: labels_json.salesrepwindow.label_address,
                    value: ''
                }
               
             ]
            },
            
            {
            columnWidth: 1/2,
            baseCls:'x-plain',
            items:[{
                       xtype:'textfield',
                       fieldLabel:labels_json.salesrepwindow.label_phone,
                       name:'salesrep_phone',
                       id:'salesrep_phone' 
                },{
                       xtype:'textfield',
                       fieldLabel:labels_json.salesrepwindow.label_mobile,
                       name:'salesrep_mobile',
                       id:'salesrep_mobile' 
                
                },
                {
                       xtype:'textfield',
                       fieldLabel:labels_json.salesrepwindow.label_email,
                       name:'salesrep_email',
                       id:'salesrep_email' 
                
                }
                ,{
                       xtype:'checkboxfield',
                       fieldLabel:labels_json.salesrepwindow.label_active,
                       name:'rep_isactive',
                       id:'rep_isactive',
                       checked:true,
                       listeners:{
                           change:function(){
                                var is_active = this.getValue()?1:0;
                                this.up('form').getForm().findField('salesrep_status').setValue(is_active);
                           }
                      } 
                }, {
                    xtype: 'hiddenfield',
                    name: 'salesrep_status',
                    id: 'salesrep_status',
                    value: '1'
                }]
            }
        ],

        buttons: [{
            text: labels_json.button_save,
            handler: function() {
                if (this.up('form').getForm().isValid()) {
                   LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                   this.up('form').getForm().submit({
                        clientValidation: true,
                        url: action_urls.saveupdate_salesrep,
                        params: {

                        },
                        success: function(form, action) {
                            LoadingMask.hideMessage();
                            // console.log(action.result.data)
                            salesrep_store.loadData(action.result.data);
                            // customer_store.loadData(action.result.data.customers);   
                               if(active_layout==="sale-invoice-panel"){
                                    Ext.getCmp("so_sale_rep_assign").setValue(""+action.result.obj_id);
                                }                         
                            if(Ext.getCmp("salesrep-panel-grid")){
                                Ext.getCmp("salesrep-panel-grid").store.load();
                            }

                            salesrep_store.insert(0,{"id":"-1","salesrep_name":labels_json.salesrepwindow.add_new_salerep_button,"salesrep_status":"1"})
                           salesrep_form.hide();

                        },
                        failure: function(form, action) {
                            LoadingMask.hideMessage();
                            failureMessages(form, action);

                        }
                    });

                }
            }
        },{
            text: labels_json.button_cancel,
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
   });  
   /*Sales Rep window end*/
   
   
   
    /* Group  start window */
   group_form = Ext.widget('window', {
        title: '',
        width: 400,
        height: 200,
        minHeight: 200,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var me = this.down('form').getForm();
              if(winMode && winMode>0){
                  var selectionModel = Ext.getCmp("customer-group-panel-grid").selModel.getSelection()[0];            
                  me.findField('group_name').setValue(selectionModel.get("cust_group_name"));                                    
                  me.findField('g_isdefault').setValue(selectionModel.get("cust_group_isdefault"));
                  me.findField('group_id').setValue(selectionModel.get("id"));
              } 
              else{
                  me.reset();
                  me.findField('group_id').setValue(0);
              }
            }
        },
        items: Ext.widget('form', {
        layout:'anchor',
        border: false,
        bodyPadding: 10,        
        defaults: {
            anchor: '95%',
            border:false
        },
        items: [
               {
                    xtype: 'hiddenfield',
                    name: 'group_id',
                    value: '0'
                },{
                        xtype:'textfield',
                        fieldLabel:labels_json.customergroupwindow.text_group_name,
                        name:'group_name',
                        id:'group_name',
                        allowBlank: false,
                        listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("add_cust_group").fireHandler();
                      }
                     }
                   }
                },{
                       xtype:'checkboxfield',
                       fieldLabel:labels_json.customergroupwindow.text_group_default,
                       name:'g_isdefault',
                       id:'g_isdefault' ,
                       listeners:{
                           specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("add_cust_group").fireHandler();
                      }
                     },
                           change:function(){
                                var is_default = this.getValue()?1:0;
                                this.up('form').getForm().findField('group_isdefault').setValue(is_default);
                           }
                      }
                },
                {
                    xtype: 'hiddenfield',
                    name: 'group_isdefault',
                    id: 'group_isdefault',
                    value: '0'
                }                         
                        
        ],

        buttons: [{
            text: labels_json.button_save,
            id:'add_cust_group',
            handler: function() {
                if (this.up('form').getForm().isValid()) {
                   LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                   this.up('form').getForm().submit({
                        clientValidation: true,
                        url: action_urls.saveupdate_groups,
                        params: {

                        },
                        success: function(form, action) {
                            LoadingMask.hideMessage();                            
                            if(Ext.getCmp("customer-group-panel-grid")){
                                Ext.getCmp("customer-group-panel-grid").store.load();
                            }

                            group_form.hide();

                        },
                        failure: function(form, action) {
                            LoadingMask.hideMessage();
                            failureMessages(form, action);

                        }
                    });

                }
            }
        },{
            text: labels_json.button_cancel,
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
   });  
   /*Group window end*/
   
   
   
    /* Type  start window */
   type_form = Ext.widget('window', {
        title: '',
        width: 400,
        height: 150,
        minHeight: 200,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var me = this.down('form').getForm();
              if(winMode && winMode>0){
                  var selectionModel = Ext.getCmp("customer-type-panel-grid").selModel.getSelection()[0];            
                  me.findField('type_name').setValue(selectionModel.get("cust_type_name"));                                    
                  me.findField('t_isdefault').setValue(selectionModel.get("cust_type_isdefault"));
                  me.findField('type_id').setValue(selectionModel.get("id"));
              } 
              else{
                  me.reset();
                  me.findField('type_id').setValue(0);
              }
            }
        },
        items: Ext.widget('form', {
        layout:'anchor',
        border: false,
        bodyPadding: 10,        
        defaults: {
            anchor: '95%',
            border:false
        },
        items: [
               {
                    xtype: 'hiddenfield',
                    name: 'type_id',
                    value: '0'
                },{
                        xtype:'textfield',
                        fieldLabel:labels_json.customertypewindow.text_type_name,
                        name:'type_name',
                        id:'type_name',
                        allowBlank: false,
                        listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("add_cust_type").fireHandler();
                      }
                     }
                   }
                },{
                       xtype:'checkboxfield',
                       fieldLabel:labels_json.customertypewindow.text_type_default,
                       name:'t_isdefault',
                       id:'t_isdefault' ,
                       listeners:{
                           specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("add_cust_type").fireHandler();
                      }
                     },
                           change:function(){
                                var is_default = this.getValue()?1:0;
                                this.up('form').getForm().findField('type_isdefault').setValue(is_default);
                           }
                      }
                },
                {
                    xtype: 'hiddenfield',
                    name: 'type_isdefault',
                    id: 'type_isdefault',
                    value: '0'
                }                         
                        
        ],

        buttons: [{
            text: labels_json.button_save,
            id:'add_cust_type',
            handler: function() {
                if (this.up('form').getForm().isValid()) {
                   LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                   this.up('form').getForm().submit({
                        clientValidation: true,
                        url: action_urls.saveupdate_cust_type,
                        params: {

                        },
                        success: function(form, action) {
                            LoadingMask.hideMessage();                            
                            if(Ext.getCmp("customer-type-panel-grid")){
                                Ext.getCmp("customer-type-panel-grid").store.load();
                            }

                            type_form.hide();

                        },
                        failure: function(form, action) {
                            LoadingMask.hideMessage();
                            failureMessages(form, action);

                        }
                    });

                }
            }
        },{
            text: labels_json.button_cancel,
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
   });  
   /*Type window end*/
   
   /* Estimates Window Load Start */
   estimates_window = Ext.widget('window', {
        title: 'Choose Estimate to Make Sale Invoice',
        width: 830,
        height: 400,
        minHeight: 200,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var cust_id = Ext.getCmp("customers_combo").getValue();
              Ext.getCmp("estimate_customer_list").setValue(cust_id?cust_id:"-1");  
              Ext.getCmp("estimate-panel-grid").store.load({
                    params:{                        
                        search_invoice_id:Ext.getCmp("estimate_no_search").getValue(),
                        search_customer:Ext.getCmp("estimate_customer_list").getValue(),
                        search_status:'0',
                        salereturn: '2',
                        search:true
                    }
              });  
              var me = this.down('form').getForm();
              
            }
        },
        items: Ext.widget('form', {
        layout: 'border',
        border: false,
        id:'_price_level_form',
        bodyPadding: 5,
        defaults:{
                border:false
        },
        items: [{
        region:'north',
        height:120,
        layout:'fit',
        items:[{
               xtype: 'fieldset',
               title: 'Search Estimate',
               collapsible: false,
               margin:'0 5 5 5',
               padding:10,
               layout:'anchor',
               defaults: {
                   labelWidth: 100,
                   anchor: '100%',
                   layout: {
                       type: 'hbox',
                       defaultMargins: {top: 0, right: 5, bottom: 0, left: 0}
                   }
               },
               items:[
                   
                    {
                      xtype:'combo',
                      fieldLabel:'Customer',
                      displayField: 'cust_name',
                      valueField:'cust_id',
                      id:'estimate_customer_list',
                      queryMode: 'local',
                      value:"-1",
                      typeAhead: true,
                      store: customer_store_withall
                   },
                   {
                      xtype:'textfield',
                      fieldLabel:'Estimate#',
                      id:'estimate_no_search'
                   },
                   {
                       layout:'border',
                       border:false,
                       height:22,
                       bodyBorder:false,
                       defaults:{
                           border:false
                       },
                       items:[{
                           region:'center',
                           items:[
                           {
                                    xtype:'button',
                                    text:'Show All',
                                    style:'float:right;',
                                    width:80,
                                    listeners:{
                                        click:function(){
                                            Ext.getCmp("estimate-panel-grid").store.load({
                                                params:{
                                                    search:'true',
                                                    search_invoice_id:'',
                                                    search_customer:'-1',
                                                    salereturn: '2',
                                                    search_status:'0'
                                                }
                                            });
                                        }
                                    }
                               },
                           {
                                xtype:'button',
                                text:'Search',
                                style:'float:right;margin-right:10px',
                                width:80,
                                listeners:{
                                    click:function(){
                                        Ext.getCmp("estimate-panel-grid").store.load({
                                            params:{
                                                search:'true',
                                                search_invoice_id:Ext.getCmp("estimate_no_search").getValue(),
                                                search_customer:Ext.getCmp("estimate_customer_list").getValue(),
                                                salereturn: '2',
                                                search_status:'0'
                                            }
                                        });
                                    }
                                }
                           }]
                       }]

                   }

               ]

           }]
       },
       {
        region:'center',
        layout:'fit',
        border:false,                                
        bodyBorder:false,
        items:[{
               xtype:"gridpanel",
               id:"estimate-panel-grid",
               margin:'0 5 5 5',
               store:{
                   proxy:{
                       type:"ajax",
                       url: action_urls.get_so,
                       reader:{
                           type:"json",
                           root: 'orders',
                           idProperty: 'so_id'
                       }
               },
               model:Ext.define("EstimatesModel", {
                   extend:"Ext.data.Model",
                   fields:[
                       {
                        name: "inv_no",
                        type: 'string',
                        convert: function (v, r) {
                            return "EST-" + v;
                        }
                       },
                       "so_id",
                        "id",                        
                        "so_date",
                        "so_status",
                        "cust_name",
                        "cust_id",
                        "so_due_date",
                        "so_total",
                        "so_paid",
                        "so_balance",
                        "order_date"
                       ]
               }) && "EstimatesModel",
               autoLoad:false
             },
             listeners:{
               afterRender : function(cmp) {                   
                   this.nav = new Ext.KeyNav(this.getEl(),{
                       del: function(e){
                       }
                   });
               }

             },
             selModel: Ext.create('Ext.selection.CheckboxModel', {
                   mode:'SINGLE', 
                   listeners: {
                       selectionchange: function(sm, selections) {
                           if(selections.length==1){
                               Ext.getCmp("load_estimate_btn").setDisabled(false);                               
                           }
                           else if(selections.length>1){
                               Ext.getCmp("load_estimate_btn").setDisabled(true);                               
                           }
                           
                       }
                   }
             }),
             columnLines: true,
             columns:[
               {header:"Estimate#",dataIndex:"inv_no",width:80},
                {header:"Date",dataIndex:"so_date",width:120},               
                {header:"Customer",dataIndex:"cust_name",flex:1},                
                {header:"Total",dataIndex:"so_total",width:120}                               
               ]
             }]
          }
        ],
        buttons: [{
            text: 'Load',
            id:'load_estimate_btn',
            disabled:true,
            handler: function() {
                if (this.up('form').getForm().isValid()) {
                   var parms_obj = {};                               
                   var rec = Ext.getCmp("estimate-panel-grid").getSelectionModel().getSelection()[0];
                   editItem.id = rec.get("id");
                   editItem.type = "";
                   Ext.getCmp("so_estimate_id").setValue(editItem.id);                   
                   OBJ_Action.editme();
                   this.up('window').hide();
                }
            }
        },{
            text: 'Cancel',
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
    });
   
   /* Price Level  start window */
   price_level_form = Ext.widget('window', {
        title: 'Price',
        width: 930,
        height: 480,
        minHeight: 200,
        closeAction:'hide',
        layout: 'fit',
        resizable: true,
        modal: true,
        listeners:{
            show:function(){
              var me = this.down('form').getForm();
              Ext.getCmp("item-level-grid").selModel.deselectAll();
              var item_store = Ext.getCmp("item-level-grid").store;
              var count = item_store.count();
              for(var i = 0;i<count;i++){
                 item_store.getAt(i).set("cust_price","");
              }
              if(winMode && winMode>0){
                  var selectionModel = Ext.getCmp("price_level-panel-grid").selModel.getSelection()[0];
            
                  me.findField('level_name').setValue(selectionModel.get("level_name"));
                  me.findField('level_type').setValue(selectionModel.get("level_type"));
                  me.findField('level_from_date').setValue(selectionModel.get("level_from_date"));
                  me.findField('level_to_date').setValue(selectionModel.get("level_to_date"));
                  
                  if(selectionModel.get("level_type")=="1"){
                    me.findField('fix_level_value').setValue(selectionModel.get("level_dir"));
                    me.findField('fix_level_percentage').setValue(selectionModel.get("level_per")); 
                  }
                  else{                    
                    me.findField('peritem_level_value').setValue(selectionModel.get("level_dir"));
                    me.findField('peritem_level_percentage').setValue(selectionModel.get("level_per"));
                    me.findField('peritem_level_field').setValue(selectionModel.get("level_compare_price"));
                    
                    setTimeout('Ext.getCmp("item-level-grid").setLoading('+labels_json.salesrepwindow.msg_loadings+')',20);
                    Ext.Ajax.request({
                        url: action_urls.get_pricelevel_items,
                        method : 'GET',
                        params:{ level_id:selectionModel.get("id") },
                        success: function (response) {
                          Ext.getCmp("item-level-grid").setLoading(false); 
                          var items = Ext.decode(response.responseText);
                          for(var i=0;i<items.length;i++){
                            var index = Ext.getCmp("item-level-grid").store.indexOfId(items[i].item_id);
                            Ext.getCmp("item-level-grid").getView().select(index,true);
                            var _store = Ext.getCmp("item-level-grid").store;
                            _store.getById(items[i].item_id).set("percentage",parseFloat(items[i].item_per_level).toFixed(2));           
                            
                            var price = (selectionModel.get("level_compare_price")=="1")?_store.getById(items[i].item_id).get("sprice"):_store.getById(items[i].item_id).get("nprice");
                            var diff = parseFloat(price) * (parseFloat(items[i].item_per_level)/100);
                            var custom_val = parseFloat(_store.getById(items[i].item_id).get("sprice")) + diff;                            
                            _store.getById(items[i].item_id).set("cust_price",custom_val.toFixed(2));
                            
                            
                          }
                          //Ext.getCmp("pricelevel_adjust_btn").fireEvent('click');
                        },
                        failure: function () {
                        }
                    });
                    
                  }
                  me.findField('price_level_rounding').setValue(selectionModel.get("level_round"));
                  me.findField('pricelevel_id').setValue(selectionModel.get("id"));
                 
              } 
              else{
                  me.reset();
                  me.findField('pricelevel_id').setValue(0);
              }
            }
        },
        items: Ext.widget('form', {
        layout: 'border',
        border: false,
        id:'_price_level_form',
        bodyPadding: 5,
        defaults:{
                border:false
        },
        items: [{
                    region:'north',
                    height:180,
                    layout:'column',
                    bodyBorder:false,
                    defaults: {
                           layout: 'anchor',
                           border:false,
                           defaults: {
                                   anchor: '100%'
                           }
                    },
                    items:[{
                           columnWidth: 2/3,
                           baseCls:'x-plain',
                           padding:10,
                           items:[
                                {
                                     xtype:'textfield',
                                     fieldLabel:'Price Level Name',
                                     name:'level_name',
                                     allowBlank: false,
                                     id:'price_level_name_field'
                                },{
                                xtype:'combo',
                                fieldLabel:'Price Level Type',
                                id:'price_level_type_field',
                                name:'level_type',
                                displayField:'name',
                                queryMode: 'local',
                                typeAhead: true,
                                valueField:'id',
                                value:'1',
                                store: new Ext.data.Store({
                                   fields: ['id', 'name'],
                                     data : [
                                         { "id":"1", "name":"Fixed %" },
                                         { "id":"2", "name":"Per Item" }
                                     ]
                                 }),
                                listeners:{
                                    change:function(obj,nv,ov,e){                                        
                                        if(nv=="2"){
                                            Ext.getCmp("peritem-price-panel").setVisible(true);
                                            Ext.getCmp("fixed-price-panel").setVisible(false);
                                            Ext.getCmp("item_category").setVisible(true);
                                            Ext.getCmp("fix_level_percentage").setValue(0);
                                            Ext.getCmp("peritem_level_percentage").setValue('');
                                        }
                                        else{
                                            Ext.getCmp("fixed-price-panel").setVisible(true);
                                            Ext.getCmp("peritem-price-panel").setVisible(false);
                                            Ext.getCmp("item_category").setVisible(false);
                                            Ext.getCmp("peritem_level_percentage").setValue(0);
                                            Ext.getCmp("fix_level_percentage").setValue('');
                                            
                                        }                                        
                                    }
                                } 
                            },{
                                   xtype:'combo',
                                   fieldLabel:'Item Category',
                                   id:'item_category',
                                   name:'item_category',
                                   hidden: true,
                                   displayField:'name',
                                   queryMode: 'local',
                                   typeAhead: true,
                                   valueField:'name',
                                   value: 'All',
                                   //multiSelect:true,
                                   store: category_storeWithAll,
                                   listeners:{
                                        change:function(obj,n,o,e){                             
                                            var grid = Ext.getCmp("item-level-grid");
                                            console.log(grid)
                                            //temp_store = grid.store;
                                            /*grid.store.clearFilter(true);
                                            grid.store.load();
                                            if(n != 'All'){
                                                grid.store.filter('category',n,true);
                                            }*/
                                            /*temp_store.each(function(record){
                                                grid.store.add(record.copy())
                                            });*/
                                            grid.store.load();
                                            temp_store = grid.store;
                                            grid.store.removeAll();
                                            var temp_array;
                                            var j = 0
                                            grid.store.clearFilter(true);
                                                grid.store.load();
                                                if(n != 'All'){
                                                    grid.store.filter('category',n,true);
                                                }
                                            /*if(n.length > 1){
                                                for(i=0; i<n.length; i++){ 
                                                   temp_store.clearFilter(true);
                                                   if(n[i]!= 'All'){
                                                       temp_store.filter('category',n[i],true);
                                                   }
                                                   else {
                                                        grid.store.removeAll();
                                                        grid.store.load();
                                                        break;
                                                   }
                                                   temp_store.each(function(record){
                                                        grid.store.insert(j,record)
                                                        //temp_array = record.data;
                                                        //grid.store.add(record.data);
                                                        j++;
                                                        console.log(record.data)
                                                   });
                                                }
                                                //grid.store.add(temp_array);
                                            }
                                            else{
                                                grid.store.clearFilter(true);
                                                grid.store.load();
                                                if(n != 'All'){
                                                    grid.store.filter('category',n,true);
                                                }
                                            }*/
                                        }
                                    }
                            },{
                                xtype: 'datefield',
                                fieldLabel: 'From',
                                id: 'from_date',
                                name: 'level_from_date',
                                format: 'Y-m-d',
                                value: new Date()
                            }, {
                                xtype: 'datefield',
                                fieldLabel: 'To',
                                id: 'to_date',
                                format: 'Y-m-d',
                                name: 'level_to_date',
                                value: new Date()
                            },{
                                xtype:'hidden',
                                name:'pricelevel_id',
                                id:'pricelevel_id',
                                value:'0'
                             }
                           ]
                    },
                    {
                           columnWidth: 1/3,
                           baseCls:'x-plain',
                           margin:'10 10 0 0',
                           height:100,
                           layout: {
                                   type: 'table',
                                   columns: 1,
                                    tableAttrs: {
                                           width:'230px',
                                           style:'float:right'
                                   }
                           },
                           items:[
                           ]
                    }
              ]
           },
           {
                region:'center',
                id:'item_center_panel',
                bodyBorder:false,
                defaults: {
                  border:false
                },
                items:[{
                    xtype:'panel',
                    id:'fixed-price-panel',
                    hidden:false,
                    layout:'anchor',
                     bodyBorder:false,
                        defaults: {
                          border:false
                        },
                    items:[{
                         layout: {
                            type: 'hbox',
                            defaultMargins: { top: 0, right: 5, bottom: 0, left: 10 }
                        }
                        ,
                        items:[{
                                    width:          300,
                                    fieldLabel:'This price level will',
                                    xtype:          'combo',
                                    labelWidth:     120,
                                    mode:           'local',
                                    value:          '-1',
                                    name:           'fix_level_value',
                                    triggerAction:  'all',
                                    forceSelection: true,
                                    editable:       false,
                                    displayField:   'name',
                                    valueField:     'value',
                                    queryMode: 'local',
                                    store:          Ext.create('Ext.data.Store', {
                                        fields : ['name', 'value'],
                                        data   : [
                                            { name : 'Decrease',   value: '-1' },
                                            { name : 'Increase',  value: '1' }
                                        ]
                                    })
                                },
                                {
                                    xtype:'textfield',
                                    width:130,
                                    labelWidth: 80,                                    
                                    emptyText: '0.0',
                                    style:{
                                        marginLeft:0
                                    },                                    
                                    fieldLabel:'item price by',
                                    name:'fix_level_percentage',
                                    id:'fix_level_percentage',
                                    allowBlank: false,
                                    maskRe: /([0-9\s\.]+)$/,
                                    regex: /[0-9]/
                               }
                               ,{
                                xtype: 'label',
                                text: '%',
                                margins: '0 0 0 0'
                               }
                       ]   

                   }]
                                
                      
                },
                {
                    xtype:'panel',
                    id:'peritem-price-panel',
                    layout:'anchor',
                    hidden:true,
                    bodyBorder:false,
                    defaults: {
                      border:false
                    },
                    items:[{
                                xtype:"gridpanel",                                                                
                                id:"item-level-grid",
                                height:158,
                                bodyBorder:true,
                                border:true,
                                style:"margin-bottom:8px;",
                                plugins: [
                                    Ext.create('Ext.grid.plugin.CellEditing', {
                                        clicksToEdit: 1,
                                        autoCancel: false,
                                        listeners: {
                                            beforeedit: function(editor, e) {
                                               
                                            }
                                         }
                                    })
                                ],
                                 store:{
                                    proxy:{
                                        type:"ajax",
                                        url: action_urls.get_items,
                                        extraParams:{p_level:1},
                                        reader:{
                                            type:"json",
                                            root: 'items',
                                            idProperty: 'id'
                                        }
                                },
                                model:Ext.define("itemModel", {
                                    extend:"Ext.data.Model",
                                    fields:[
                                        "item_status",
                                        "item",
                                        "nprice",
                                        "navg_cost",
                                        "category",
                                        "sprice",
                                        "type",                                        
                                        "cust_price",
                                        "id",
                                        "percentage"
                                        ]
                                }) && "itemModel",
                                autoLoad:false
                      },
                       selModel: Ext.create('Ext.selection.CheckboxModel', {
                            listeners: {
                                
                            }
                      }),
                      listeners:{
                           'itemclick':function(v,r,item,index,e,args){
                                var me = Ext.getCmp("_price_level_form").getForm();                                                           
                                var _value = parseFloat(r.get("percentage"))<0 ? (-1*parseFloat(r.get("percentage"))):parseFloat(r.get("percentage"));var _dir = parseFloat(r.get("percentage"))<0 || r.get("percentage") =="" ? "-1":"1";
                                me.findField('peritem_level_percentage').setValue(isNaN(_value)?"":_value);me.findField('peritem_level_value').setValue(_dir);
                             } 
                      }
                      ,
                        tbar: [
                               {
                              width: 500,
                              fieldLabel: 'Search Item',
                              labelWidth: 80,
                              id:'search_field_item',
                              xtype: 'searchfield',
                              store: store_adjust, 
                                triggers: {
                                clear: {
                                              cls: 'x-form-clear-trigger',
                                             displayTpl: new Ext.XTemplate('X'),
                                              handler:function(field) { field.reset(); }
                            }
                          },             
                              listeners: {
                                  change: function (obj,val) {                                                
                                      var grid = Ext.getCmp("item-level-grid"); 
                                      var cat = Ext.getCmp('item_category').value;
                                      grid.store.clearFilter(true);
                                       grid.store.load();
                                        if(val){
                                            if(cat != 'All'){
                                                grid.store.filter([{property: 'item', value: val, anyMatch: true },
                                                                {property: 'category', value: cat , anyMatch: true}]);
                                            }
                                            else{
                                                grid.store.filter([{property: 'item', value: val, anyMatch: true }]);
                                            }
                                        }
                                        else{
                                            if(cat != 'All'){
                                                grid.store.filter([{property: 'category', value: cat , anyMatch: true}]);
                                            }
                                        }
                                  }
                              }
                          }
                        ],
                      columnLines: true,
                      columns:[
                        
                        {
                        header:"Item",
                        dataIndex:"item",
                        flex:1
                        },
                        {
                        header:"Category",
                        dataIndex:"category",
                        width:120
                        },
                        {
                        header:"Cost",
                        dataIndex:"nprice",
                        width:80
                        },
                        {
                        header:"Sale Price",
                        dataIndex:"sprice",
                        width:80
                        }, 
                        {
                        header: 'Per %',
                        dataIndex:"percentage",
                        width:200,
                        editor: {
                            xtype: 'container',
                            layout: 'hbox',
                            flex: 1,
                            items: [{
                                xtype: 'numberfield',
                                width: 100,
                                allowBlank: false,
                            }, {
                                xtype: 'combobox',
                                label: 'Choose',
                                width: 90,
                                queryMode: 'local',
                                displayField: 'name',
                                valueField: 'id',
                                store: [
                                    { name: 'Per', id: '1' },
                                    { name: 'Disc', id: '2' }
                                ]
                            }]
                          }
                        },                            
                        {
                            header:"Custom Price",
                            dataIndex:"cust_price",
                            width:80,
                            editor: {
                                xtype: 'numberfield',
                                allowBlank: false,
                                listeners:{
                                    change: function(obj, val){
                                        var _selection = Ext.getCmp("item-level-grid").selModel.getSelection();
                                        var me = this.up('form').getForm();
                                        var price = (me.findField("peritem_level_field").getValue()=="1")?_selection[0].get("sprice"):_selection[0].get("nprice");
                                        if(val < price){
                                            var temp = parseFloat((val*100)/price)
                                            temp = parseFloat(temp * -1)
                                            _selection[0].set("percentage",temp.toFixed(2));
                                        }
                                        else{
                                            var temp = val - price;
                                            temp = parseFloat((temp*100)/price)
                                            _selection[0].set("percentage",temp.toFixed(2));
                                        }
                                        val = parseFloat(val)
                                        _selection[0].set("cust_price",val.toFixed(2));
                                    }
                                }
                            }
                        }
                        ]
                      },
                        {
                         layout: {
                            type: 'hbox',
                            defaultMargins: {
                                top: 0, right: 5, bottom: 0, left: 10
                            }
                        }
                        ,
                        items:[{
                                    xtype:'textfield',
                                    width:280,
                                    labelWidth: 200,
                                    fieldLabel:'Adjust price of marked items to be',
                                    name:'peritem_level_percentage',
                                    id:'peritem_level_percentage',
                                    emptyText: '0.0',
                                    value:'0',
                                    allowBlank: true,
                                    maskRe: /([0-9\s\.]+)$/,
                                    regex: /[0-9]/
                               },{
                                xtype: 'label',
                                text: '%',
                                margins: '0 0 0 0'
                               },{
                                    width:          100,
                                    fieldLabel:'',
                                    xtype:          'combo',
                                    label:          false,
                                    mode:           'local',
                                    value:          '-1',                                    
                                    name:'peritem_level_value',
                                    triggerAction:  'all',
                                    forceSelection: true,
                                    editable:       false,                                    
                                    style:{
                                        marginLeft:0
                                    },                                    
                                    displayField:   'name',
                                    valueField:     'value',
                                    queryMode: 'local',
                                    store:          Ext.create('Ext.data.Store', {
                                        fields : ['name', 'value'],
                                        data   : [
                                            {name : 'Lower',   value: '-1'},
                                            {name : 'Higher',  value: '1'}
                                        ]
                                    })
                                },
                                {
                                    width:          200,
                                    labelWidth:     55,
                                    fieldLabel:     'than its',
                                    xtype:          'combo',                                    
                                    mode:           'local',
                                    value:          '1',
                                    name:           'peritem_level_field',
                                    triggerAction:  'all',
                                    forceSelection: true,
                                    editable:       false,                                    
                                    style:{
                                        marginLeft:0
                                    },                                    
                                    displayField:   'name',
                                    valueField:     'value',
                                    queryMode: 'local',
                                    store:          Ext.create('Ext.data.Store', {
                                        fields : ['name', 'value'],
                                        data   : [
                                            {name : 'Sale price',   value: '1'},
                                            {name : 'Cost',  value: '2'}
                                        ]
                                    })
                                },
                                {
                                    xtype:'button',
                                    text:'Adjust',
                                    id:'pricelevel_adjust_btn',
                                    style:'margin-right:0px',
                                    width:80,
                                    listeners:{
                                        click:function(){
                                            var _selection = Ext.getCmp("item-level-grid").selModel.getSelection();
                                            var me = this.up('form').getForm();                                            
                                            if(_selection.length){
                                                for(var r=0;r<_selection.length;r++){
                                                    var price = (me.findField("peritem_level_field").getValue()=="1")?_selection[r].get("sprice"):_selection[r].get("nprice");
                                                    var percentage_of = me.findField("peritem_level_percentage").getValue();
                                                    var adjust = me.findField("peritem_level_value").getValue();
                                                    
                                                    var diff = parseFloat(price) * (parseFloat(percentage_of)/100);
                                                    var custom_val = parseFloat(_selection[r].get("sprice")) + (parseFloat(adjust)*diff);
                                                    _selection[r].set("cust_price",custom_val.toFixed(2));
                                                    var _per = parseFloat(adjust)*parseFloat(percentage_of);
                                                    _selection[r].set("percentage",_per.toFixed(2));
                                                }                                                
                                            }
                                        }
                                    }
                               },
                               {
                                    xtype:'button',
                                    text:'Clear',
                                    id:'pricelevel_clear_btn',                                    
                                    width:60,
                                    listeners:{
                                        click:function(){
                                            var _selection = Ext.getCmp("item-level-grid").selModel.getSelection();
                                            var me = this.up('form').getForm();                                            
                                            if(_selection.length){
                                                for(var r=0;r<_selection.length;r++){                                                                                                        
                                                    _selection[r].set("cust_price","");                                                    
                                                    _selection[r].set("percentage","");
                                                }                                                
                                            }
                                        }
                                    }
                               }
                       ]   

                   }]
                }
                ,{
                         layout: {
                            type: 'hbox',
                            defaultMargins: {top: 10, right: 5, bottom: 0, left: 10}
                        }
                        ,
                        items:[{
                                    width:          350,
                                    fieldLabel:     'Round up to nearest',
                                    xtype:          'combo',
                                    labelWidth:     120,
                                    mode:           'local',
                                    value:          '0',
                                    triggerAction:  'all',
                                    forceSelection: true,
                                    editable:       false,                                    
                                    displayField:   'name',
                                    valueField:     'value',
                                    name:'price_level_rounding',
                                    queryMode: 'local',
                                    store:          Ext.create('Ext.data.Store', {
                                        fields : ['name', 'value'],
                                        data   : [
                                            {name : 'no rounding',   value: '0'},
                                            {name : '.01',   value: '0.01'},
                                            {name : '.02',   value: '0.02'},
                                            {name : '.05',   value: '0.05'},    
                                            {name : '.10',   value: '0.10'},    
                                            {name : '.25',   value: '0.25'},    
                                            {name : '.50',   value: '0.50'},    
                                            {name : '1.00',   value: '1'},    
                                        ]
                                    })
                                }
                                
                       ]   

                   }
              ]
           }
        ],
        buttons: [{
            text: 'Save',
            handler: function() {
                if (this.up('form').getForm().isValid()) {
                   var parms_obj = {}; 
                   if(this.up('form').getForm().findField("level_type").getValue()=="2"){
                    //var item_selection = getSelection(Ext.getCmp("item-level-grid"));
                    var item_selection = "[";
                    var _items = Ext.getCmp('item-level-grid').store.data.items;
                    for(var i=0;i<_items.length;i++){
                        if(_items[i].get("percentage")){
                            item_selection +='{"id":"' + _items[i].get("id") + '","per_level":"'+_items[i].get("percentage") +'"},';
                        }
                    }                    
                    if(item_selection!="["){
                       item_selection = item_selection.substring(0,item_selection.length-1);
                    }
                    item_selection +="]";
                    if(item_selection=="[]"){
                        Ext.Msg.show({
                             title:'Apply Price level',
                             msg: 'Please select atleast one item to apply price level.',
                             buttons: Ext.Msg.OK,
                             icon: Ext.Msg.ERROR
                        });
                        return false;
                    }
                    else{
                        parms_obj.selected = item_selection;
                    }
                   }
                   
                   LoadingMask.showMessage(labels_json.salesrepwindow.msg_please_wait);
                   this.up('form').getForm().submit({
                        clientValidation: true,
                        url: action_urls.saveupdate_pricelevel,
                        params: parms_obj,
                        success: function(form, action) {
                            LoadingMask.hideMessage();                            
                            if(Ext.getCmp("price_level-panel-grid")){
                                Ext.getCmp("price_level-panel-grid").store.load();
                            }
                            price_level_form.hide();

                        },
                        failure: function(form, action) {
                            LoadingMask.hideMessage();
                            failureMessages(form, action);

                        }
                    });
                }
            }
        },{
            text: 'Cancel',
            handler: function() {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
     })
   });  
   /*Price level window end*/
    
   (function(){
        var action = Ext.extend(Object,{
            isChanged: false,
            dialogName : '',
            isSaved:false,
             SaleinvoiceStatus:{"_0":"Open","_1":"Pending","_2":"unpaid","_3":"Paid","_4":"partial"},
             // SaleinvoiceStatus:{"_0":"Open","_1":"Pending","_2":"Unfulfilled/Unpaid","_3":"Fulfilled/Partial","_4":"Fulfilled/Paid"},
              invoiceStatus:{"_0":"Open","_1":"Unpaid","_2":"Partial","_3":"Paid","_4":"Fulfilled/Partial","_5":"Fulfilled/Partial"},
             SaleinvoiceStatusImage:{"_0":"open","_1":"pending","_2":"unpaid","_3":"paid","_4":"partial"},
             // SaleinvoiceStatusImage:{"_0":"open","_1":"pending","_2":"fulfilled_unpaid","_3":"fulfilled_partial","_4":"fulfilled_paid"},
            invoiceStatusImage:{"_0":"open","_1":"unpaid","_2":"partial","_3":"paid"},
            constructor: function(config){
                Ext.apply(this, config)
            },
            getform:function(){
              return Ext.getCmp(this.dialogName+'-form').getForm();  
            },
            recordChange:function(){
              this.isChanged = true;  
            },
            makeNew: function(options){
            
                if(this.isChanged){  
                    
                if(options && options.skip){
                    OBJ_Action.clearChanges();
                } else {
                    Ext.Msg.show({
                         title:'Save Changes?',
                         msg: 'Your changes haven\'t been saved yet. Would you like to save your changes?',
                         buttons: Ext.Msg.YESNOCANCEL,
                         icon: Ext.Msg.QUESTION,
                         fn:function(btn,text){
                             if(btn=='no'){
                                 OBJ_Action.clearChanges();                                 
                             }
                             else if(btn=='yes'){
                                 if(options && options.save_other){
                                    options.save_other();
                                 }
                                 else{
                                    OBJ_Action.save();
                                 }
                             }
                             
                         }
                    });
                    }
                }
                if(!this.isChanged){
                    this.clearChanges();
                    
                    this.isSaved=false;
                }
            },
           
            clearChanges:function(){
                try{
                    this.getform().reset();
                }
                catch(e){
                    this.getform().reset();
                }
                if(this.clearOtherChanges){
                   this.clearOtherChanges(); 
                }
                Ext.Function.defer(OBJ_Action.resetChanges,200);
            },
            resetChanges:function(){
                OBJ_Action.isChanged=false;
            },
            
            edit_uom:function(obj){
                if(jObj.uom_1_mapping_id){
                    Ext.getCmp("uom1_collapes").expand(true);
                    Ext.getCmp("uom_1_mapping_id").setValue(jObj.uom_1_mapping_id);
                    Ext.getCmp("qty_on_hand_unit_1").setDisabled(true); 
                    Ext.getCmp("avg_cost_unit_1").setDisabled(true);
                }else {
                    Ext.getCmp("uom1_collapes").collapse(true);
                    Ext.getCmp("_base_uom_conv_1").setDisabled(true);
                    Ext.getCmp("_item_con_unit_1").setDisabled(true);
                    Ext.getCmp("qty_on_hand_unit_1").setDisabled(true); 
                    Ext.getCmp("avg_cost_unit_1").setDisabled(true);
                    Ext.getCmp("upc_unit_1").setDisabled(true);
                } 
                if(jObj.uom_1_item_id){
                    Ext.getCmp("uom_1_item_id").setValue(jObj.uom_1_item_id);
                }
                if(jObj.uom_1_uom_id){
                    Ext.getCmp("uom_1").setValue(jObj.uom_1_uom_id);
                }
                if(jObj.uom_1_unit_id){
                    Ext.getCmp("uom_combo_1").setValue(jObj.uom_1_unit_id);
                }
                if(jObj.uom_1_conv_from){
                    Ext.getCmp("_base_uom_conv_1").setValue(jObj.uom_1_conv_from);
                }
                if(jObj.uom_1_conv_to){
                    Ext.getCmp("_item_con_unit_1").setValue(jObj.uom_1_conv_to);
                }
                if(jObj.uom_1_qty_on_hand){
                    Ext.getCmp("qty_on_hand_unit_1").setValue(parseFloat(jObj.item_quantity/jObj.uom_1_conv_from).toFixed(2));
                }
                if(jObj.uom_1_sale_price){
                    Ext.getCmp("sale_price_unit_1").setValue(jObj.uom_1_sale_price);
                }
                if(jObj.uom_1_avg_cost){
                    Ext.getCmp("avg_cost_unit_1").setValue(parseFloat(jObj.item_avgcost*jObj.uom_1_conv_from).toFixed(2));
                }
            },
            edit_uom_lookup:function(obj){
                if(obj.status){
                    var upc_uom =  obj.status;
                    Ext.each(upc_uom, function(uom_lookup) {
                    Ext.getCmp(obj.value).store.add({id:uom_lookup}); 
                }, this);
               }
            },
            alt_lookup_unit:function(obj){
                var grid = Ext.getCmp(obj.grid);
                var Store = grid.getStore();    
                var selected = Store.getRange(); 
                var uom_lookup = [];
                Ext.each(selected, function(item) {
                   uom_lookup.push(item.get('id')); 
                }, this);
                return uom_lookup;
            },
            check_lookup:function(obj){
                var grid = Ext.getCmp(obj.value);
                var Store = grid.getStore();
                var allRecords = Store.snapshot || Store.data;
                allRecords.each(function(record) {
                    if (obj.val!="" && record.get('id')==obj.val) { OBJ_Action.upc_message(obj.val, obj.field); }
                });
            },
            check_upc:function(obj){
                if(obj.value!=""){
                if(obj.value==Ext.getCmp("upc_"+obj.upc_1).getValue() || obj.value==Ext.getCmp("upc_"+obj.upc_2).getValue() || obj.value==Ext.getCmp("upc_"+obj.upc_3).getValue()){
                    OBJ_Action.upc_message(obj.value, obj.field); 
                }
            }
            },
            conv_from:function(obj){
                var qty = parseFloat(Ext.getCmp('qty_on_hand').getValue());

                var sale = Ext.getCmp('upc_sale_price').getValue();
                var avg = Ext.getCmp('upc_avg_cost').getValue();
                var conv_qty = (Math.round((qty/obj.con_qty)*100)/100).toFixed(2);
                var conv_sale = (Math.round((sale*obj.con_qty)*100)/100).toFixed(2);
                var avg_cost = (Math.round((avg*obj.con_qty)*100)/100).toFixed(2);
                Ext.getCmp('qty_on_hand_unit_'+obj.status).setValue(conv_qty);
                Ext.getCmp('sale_price_unit_'+obj.status).setValue(conv_sale);
                Ext.getCmp('avg_cost_unit_'+obj.status).setValue(avg_cost);
            },
            add_remove_unit:function(obj){
                var grid = Ext.getCmp(obj.field); 
                var project = grid.findRecord('id', obj.oldValue);
                var abc = grid.getRawValue();
                var xyz = grid.getValue();
                console.log(abc+"1");                       
                if(project==false){
                if(obj.field=="basic_uom_combo"){                         
                    unit_store_1.removeAt(unit_store_1.indexOfId(obj.newValue));
                    unit_store_2.removeAt(unit_store_2.indexOfId(obj.newValue));
                    unit_store_3.removeAt(unit_store_3.indexOfId(obj.newValue));
                } else if(obj.field=="uom_combo_1"){
                    unit_store_0.removeAt(unit_store_0.indexOfId(obj.newValue));
                    unit_store_2.removeAt(unit_store_2.indexOfId(obj.newValue));
                    unit_store_3.removeAt(unit_store_3.indexOfId(obj.newValue));
                } else if(obj.field=="uom_combo_2"){
                    unit_store_0.removeAt(unit_store_0.indexOfId(obj.newValue));
                    unit_store_1.removeAt(unit_store_1.indexOfId(obj.newValue));
                    unit_store_3.removeAt(unit_store_3.indexOfId(obj.newValue));
                } else if(obj.field=="uom_combo_3"){
                    unit_store_0.removeAt(unit_store_0.indexOfId(obj.newValue));
                    unit_store_1.removeAt(unit_store_1.indexOfId(obj.newValue));
                    unit_store_2.removeAt(unit_store_2.indexOfId(obj.newValue));
                } else {}                          
                var project1 = grid.findRecord('id', obj.newValue);
                var name1 =  project1.get('name');
                Ext.getCmp("purchase_uom_combo").store.add({id:obj.newValue,name:name1});
                Ext.getCmp("purchase_uom_combo").setValue(obj.newValue);
                Ext.getCmp("sale_uom_combo").store.add({id:obj.newValue,name:name1});
                if(obj.field=="basic_uom_combo"){ 
                    Ext.getCmp("sale_uom_combo").setValue(obj.newValue);
                    }
                }else{
                var name =  project.get('name');
                if(obj.field=="basic_uom_combo"){ 
                    Ext.getCmp("uom_combo_"+obj.unit_1).store.add({id:obj.oldValue,name:name});
                } else {
                    Ext.getCmp(obj.unit_1+"_uom_combo").store.add({id:obj.oldValue,name:name});
                }
                    Ext.getCmp("uom_combo_"+obj.unit_2).store.add({id:obj.oldValue,name:name});
                    Ext.getCmp("uom_combo_"+obj.unit_3).store.add({id:obj.oldValue,name:name});
                                          
                
                                          
                Ext.getCmp("purchase_uom_combo").store.add({id:xyz,name:abc});
                Ext.getCmp("sale_uom_combo").store.add({id:xyz,name:abc});
                Ext.getCmp("purchase_uom_combo").setValue(xyz);
                if(obj.field=="basic_uom_combo"){
                Ext.getCmp("sale_uom_combo").setValue(xyz);
                }
                if(obj.field=="basic_uom_combo"){                         
                    unit_store_1.removeAt(unit_store_1.indexOfId(xyz));
                    unit_store_2.removeAt(unit_store_2.indexOfId(xyz));
                    unit_store_3.removeAt(unit_store_3.indexOfId(xyz));
                } else if(obj.field=="uom_combo_1"){
                    unit_store_0.removeAt(unit_store_0.indexOfId(xyz));
                    unit_store_2.removeAt(unit_store_2.indexOfId(xyz));
                    unit_store_3.removeAt(unit_store_3.indexOfId(xyz));
                } else if(obj.field=="uom_combo_2"){
                    unit_store_0.removeAt(unit_store_0.indexOfId(xyz));
                    unit_store_1.removeAt(unit_store_1.indexOfId(xyz));
                    unit_store_3.removeAt(unit_store_3.indexOfId(xyz));
                } else if(obj.field=="uom_combo_3"){
                    unit_store_0.removeAt(unit_store_0.indexOfId(xyz));
                    unit_store_1.removeAt(unit_store_1.indexOfId(xyz));
                    unit_store_2.removeAt(unit_store_2.indexOfId(xyz));
                } else {}                         
                var purchase_uom_combo = Ext.getCmp("purchase_uom_combo");
                purchase_uom_combo.store.removeAt(purchase_uom_combo.store.indexOfId(obj.oldValue));
                                            
                var sale_uom_combo = Ext.getCmp("sale_uom_combo");
                sale_uom_combo.store.removeAt(sale_uom_combo.store.indexOfId(obj.oldValue));
                }
                
                if(obj.unit!="" && obj.units!=''){
                    console.log(abc+"2");
                Ext.getCmp('_item_con_unit_'+obj.unit).setFieldLabel(abc);
                Ext.getCmp("_base_uom_conv_"+obj.unit).enable();
                Ext.getCmp("_item_con_unit_"+obj.unit).enable();
                Ext.getCmp("upc_unit_"+obj.unit).enable();
                Ext.getCmp("barcode_new_btn"+obj.units).enable();
                }
            },
                
            
            generate_barcode_button:function(obj){
                Ext.Ajax.request({
                    url: action_urls.generate_item_barcode,
                    params:{},
                        success: function (response) {                                                                    
                            var barcode_Obj = Ext.decode( response.responseText);
                            Ext.getCmp("upc_"+obj.unit).setValue(barcode_Obj.code);
                            Ext.getCmp("upc_"+obj.unit).focus();
                            OBJ_Action.recordChange();
                        },
                        failure: function () {}
                });
            },
            delete_enable_disable:function(obj){
                var grid = Ext.getCmp(obj.lookup);
                var sm = grid.getSelected();
                if (sm.length) {
                    Ext.getCmp(obj.button).enable();
                } else {
                    Ext.getCmp(obj.button).disable();
                }
            },
            remove_lookup:function(obj){
                var grid = Ext.getCmp(obj.lookup);
                var record = grid.getSelected();
                var count = grid.store.getCount();
                var index = grid.store.indexOf(record);
                Ext.getCmp(obj.lookup).store.remove(record);
                Ext.getCmp(obj.button).disable();
            },
            uom_reset:function(obj){
                var purchase_uom_combo = Ext.getCmp("purchase_uom_combo");
                purchase_uom_combo.store.removeAt(obj.value);
                
                Ext.Msg.show({
                    title:'Confirm',
                    msg: 'Are you sure you wanty to delete this unit?',
                    buttons: Ext.Msg.YESNOCANCEL,
                    icon: Ext.Msg.QUESTION,
                    fn:function(btn,text){
                        if(btn=='yes'){
                            OBJ_Action.resetItemUnit(obj.uom);
                        }
                    }
                });
            },
            disabledd:function(obj){
                Ext.getCmp("_base_uom_conv_"+obj.status).disable();
                Ext.getCmp("_item_con_unit_"+obj.status).disable();
                Ext.getCmp("upc_unit_"+obj.status).disable();
                Ext.getCmp("qty_on_hand_unit_"+obj.status).disable();
                Ext.getCmp("sale_price_unit_"+obj.status).disable();
                Ext.getCmp("avg_cost_unit_"+obj.status).disable();
            },
            enable_disable:function(obj){
                if(obj.enable=="enable"){ 
                    console.log(obj.enable);
                    Ext.getCmp("qty_on_hand").enable();
                    Ext.getCmp("qty_on_hand_unit_1").enable();
                    Ext.getCmp("qty_on_hand_unit_2").enable();
                    Ext.getCmp("qty_on_hand_unit_3").enable();
                } else {
                    console.log(obj.enable);
                    Ext.getCmp("qty_on_hand").disable();
                    Ext.getCmp("qty_on_hand_unit_1").disable();
                    Ext.getCmp("qty_on_hand_unit_2").disable();
                    Ext.getCmp("qty_on_hand_unit_3").disable();
                }
            },
            combo_remove:function(obj){
                if(obj.status == "1"){
                var basic_uom_combo = Ext.getCmp("basic_uom_combo").getValue();
                unit_store_1.removeAt(unit_store_1.indexOfId(basic_uom_combo));
                unit_store_2.removeAt(unit_store_2.indexOfId(basic_uom_combo));
                unit_store_3.removeAt(unit_store_3.indexOfId(basic_uom_combo));
                } 
                var uom_1_combo = Ext.getCmp("uom_combo_1").getValue();
                unit_store_0.removeAt(unit_store_0.indexOfId(uom_1_combo));
                unit_store_2.removeAt(unit_store_2.indexOfId(uom_1_combo));
                unit_store_3.removeAt(unit_store_3.indexOfId(uom_1_combo));

                var uom_2_combo = Ext.getCmp("uom_combo_2").getValue();
                unit_store_0.removeAt(unit_store_0.indexOfId(uom_2_combo));
                unit_store_1.removeAt(unit_store_1.indexOfId(uom_2_combo));
                unit_store_3.removeAt(unit_store_3.indexOfId(uom_2_combo));

                var uom_3_combo = Ext.getCmp("uom_combo_3").getValue();
                unit_store_0.removeAt(unit_store_0.indexOfId(uom_3_combo));
                unit_store_1.removeAt(unit_store_1.indexOfId(uom_3_combo));
                unit_store_2.removeAt(unit_store_2.indexOfId(uom_3_combo));

            },
            save: function(extraParms){            
                if(this.isChanged && !this.getform().hasInvalidField()){
                    LoadingMask.showMessage(labels_json.msg_saving);
                    this.getform().submit({
                        clientValidation: true,
                        url: panel_form_actions[this.dialogName].save,
                        params: extraParms,
                        success: function(form, action) {
                            LoadingMask.hideMessage();
                            if(action.result.success){                                                             
                                if(OBJ_Action.myfunc){
                                    if(action.result.data)
                                    {
                                        var _image = action.result.picture_path ? action.result.picture_path: '';
                                        OBJ_Action.myfunc(action.result.obj_id,action.result.data,_image);    
                                    }
                                    else{                                    
                                       if(typeof(action.result.next_order_id)!=="undefined"){
                                            OBJ_Action.myfunc(action.result);
                                       }
                                       else{
                                            OBJ_Action.myfunc(action.result.obj_id,false,action.result.already_shipped);     
                                       }
                                    }

                                }
                                OBJ_Action.resetChanges();
                                if(extraParms && extraParms.print){
                                    OBJ_Action.printme();
                                }
                                else if(extraParms && extraParms.makenew){
                                    if(extraParms.makenew==1){
                                        OBJ_Action.makeNew();
                                        if(extraParms.onNew){
                                            OBJ_Action.onNew()
                                        }
                                    }
                                    else{
                                         OBJ_Action.makeNew({'save_other':extraParms.makenew});
                                    }
                                }
                            }
                            
                        },
                        failure: function(form, action) {
                            failureMessages(form, action);
                        }
                    });
                }
            },
            copy:function(hidden_id,copy_field){
                if(parseInt(Ext.getCmp(hidden_id).getValue())!==0){
                    Ext.getCmp(hidden_id).setValue('0');
                    Ext.getCmp(copy_field).setValue('');
                    Ext.Msg.show({
                         title:'Copy Created',
                         msg: 'A copy is created with same information. You can save it by pressing \'Save\' button.',
                         buttons: Ext.Msg.OK,
                         icon: Ext.Msg.INFO
                    });
                }
                else{
                     Ext.Msg.show({
                         title:'Error Occured',
                         msg: 'You cann\'t perform this action without saving.',
                         buttons: Ext.Msg.OK,
                         icon: Ext.Msg.ERROR
                    });
                }
                
            },
            payment_update:function(){
                if(Ext.getCmp("m_payment_grid")){
                    var total = Ext.getCmp("m_payment_grid").store.sum("payment_amount");
                    Ext.getCmp("m_total_paid").setValue(Ext.util.Format.number(total,"0.00"));
                    var balance = parseFloat(Ext.getCmp("m_invoice_total").getValue())-total;
                    Ext.getCmp("m_balance").setValue(Ext.util.Format.number(balance,"0.00"));
                     
                    if(Ext.getCmp("G_payment_type").getValue()=="1"){
                        Ext.getCmp("po_payment_paid").setValue(Ext.util.Format.number(total,"0.00"));
                    }
                    else{
                        Ext.getCmp("so_payment_paid").setValue(Ext.util.Format.number(total,"0.00"));
                    }
               }
            },
            deactive:function(id,act_de){
                var msg = act_de ==1? 'Activating...':'Deactivating...';
                LoadingMask.showMessage(msg);
                Ext.Ajax.request({
                    url: panel_form_actions[this.dialogName].deactivate,
                    params:{
                        _id:id,
                        _state:act_de
                    },
                    success: function (response) {
                         jObj = Ext.decode( response.responseText );
                         if(jObj.action=='success'){
                             if(OBJ_Action.changeStatus){
                                OBJ_Action.changeStatus(jObj.msg,jObj.data);
                             }
                         }else{
                             Ext.Msg.show({
                                 title:jObj.action,
                                 msg: jObj.msg,
                                 buttons: Ext.Msg.OK,
                                 icon: Ext.Msg.ERROR
                            });
                         }
                         
                         LoadingMask.hideMessage();
                    },
                    failure: function () {
                         LoadingMask.hideMessage();
                    }
               });
            },
            
            close:function(status){
                //alert(item);
                if(status=="sale" || status=="purchase"){
                if(rowNumbers > 0){
                    Ext.Msg.show({
                         title:'Save Changes?',
                         msg: 'Your changes haven\'t been saved yet. Are you sure you want to leave this page?',
                         buttons: Ext.Msg.YESNO,
                         icon: Ext.Msg.QUESTION,
                         fn:function(btn,text){
                             if(btn=='yes'){
                                homePage();                                 
                             } else if(btn=='no'){
                                 return false;
                             }
                           }
                    });
                }
                if(!this.isChanged){
                    homePage();
                }
            } else {
                homePage();
            }
        }
        });

        dialog.Action = action;
    })();
     
    });
    
    
    function failureMessages(form, action){
        LoadingMask.hideMessage();
        switch (action.failureType) {
            case Ext.form.action.Action.CLIENT_INVALID:
                Ext.Msg.alert('Failure', 'Form fields may not be submitted with invalid values');
                break;
            case Ext.form.action.Action.CONNECT_FAILURE:
                Ext.Msg.alert('Failure', 'Ajax communication failed');
                break;
            case Ext.form.action.Action.SERVER_INVALID:{
                Ext.Msg.show({
                     title:'Error Occured',
                     msg: action.result.msg,
                     buttons: Ext.Msg.OK,
                     icon: Ext.Msg.ERROR
                });
                if(OBJ_Action && OBJ_Action.afterFailAciton)
                {
                    OBJ_Action.afterFailAciton();    
                }
            }
       }
    }
    function hideMenus(){
        Ext.get("vendor_menu1").setStyle("display","none");
        Ext.get("vendor_menu").setStyle("display","none");
        Ext.get("vendor_menu2").setStyle("display","none");        
        Ext.get("po_menu").setStyle("display","none");
        Ext.get("po_menu2").setStyle("display","none");
        Ext.get("items_menu").setStyle("display","none");
        Ext.get("items_menu2").setStyle("display","none");
        Ext.get("so_menu").setStyle("display","none");
        Ext.get("so_menu2").setStyle("display","none");
        Ext.get("customer_menu").setStyle("display","none");
        Ext.get("customer_menu2").setStyle("display","none");
   
    }
    function showMenu(attachItem){
        timeObj = Ext.Function.defer(showMenuTimeout,400,this,[attachItem]);
    }
    function clearTime(){
        window.clearTimeout(timeObj);
    }
    function showMenuTimeout(attachItem){
        if(openedMenu && openedMenu!=attachItem){
            Ext.select(openedMenu).fadeOut();
            Ext.select(openedMenu).setStyle("display","none");
        }
        Ext.select(attachItem).setStyle("display","block");
        Ext.select(attachItem).fadeIn({
            endOpacity: 1,
            duration: 1000
        });
        openedMenu = attachItem;
    }
    //Show window
    function showWindow(title){
       if(title){
        win.setTitle(title);
       }
       win.show();
    }
     function showRemWindow(title){
       if(title){
        rem.setTitle(title);
       }
       rem.show();
    }
    //make dialog action object
    function makeObject(dialog_name){
        OBJ_Action = new dialog.Action();
        OBJ_Action.dialogName = dialog_name;
        OBJ_Action.makeNew();
    }
    //Get panel using ajax call
    function getPanel(panel_url,panel_id,opt){
       LoadingMask.showMessage(defaultMsg); 
       if(Ext.getCmp(panel_id)){
           if(opt && opt.viewType=='window'){
                // console.log(panel_url)
              showWindow();
           }
           else{
               activeLayout(panel_id);   
               if(opt && opt.grids){
                   loadGrids(opt.grids);
               }
           }
       }
       else{  
        if(panel_id !='reminder-panel')
        {
        loadLabels(panel_id);    
        }
        
        Ext.Ajax.request({
        url: panel_url,
        success: function (response) {
        jObj = Ext.decode( response.responseText );
         if(opt && opt.viewType=='window'){
            
            if(jObj.id=="reminder-panel")
            {
             // console.log(jObj);
            makeRemWindow(jObj)  
            showRemWindow() 
            }
            else{
                // console.log(jObj);
             makeWindow(jObj);   
             showWindow();

            }
             
         }else{
            makelayout(jObj);
            activeLayout(jObj.id);
         }
        },
        failure: function () {
        
        }
       });
      } 
    
    }
    
    function loadLabels(id){
    // console.log(id)        
        var url = id ? id.replace(/-/g,"") : 'home';          
        var xmlhttp;        
        if (window.XMLHttpRequest)
          {
            xmlhttp=new XMLHttpRequest();
          }
        else
          {
             xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {   
              //labels are getting here.     
              jObj = Ext.decode(xmlhttp.responseText);

              labels_json[url] = jObj;
              // console.log(labels_json[url])
          }
        }
        xmlhttp.open("GET",labels_json._url+url,false);
        xmlhttp.send();         
    }
    //Make Layouts from json in center panel
    function makelayout(jsonObj){
        var centerPanel = Ext.getCmp("main_center_panel");
        var centerItems = new Ext.Panel (jsonObj);
        centerPanel.add(centerItems);
        centerPanel.doLayout();      
        hideMenus();
    }
    function makeWindow(jsonObj){
        var windowItems = new Ext.Panel (jsonObj);
        win.add(windowItems);
        win.doLayout();   
    }
    function makeRemWindow(jsonObj){
        var windowItems = new Ext.Panel (jsonObj);
        // console.log(windowItems)
        rem.add(windowItems);
        rem.doLayout();   
    }
    function showWindow(){
        LoadingMask.hideMessage();
        win.show();
    }
     function showRemWindow(){
        LoadingMask.hideMessage();
        rem.show();
    }
    //Active layout according to action
    function activeLayout(p){        
        if(p=="center-panel"){
            //Ext.get("inventory_flow_logo").setStyle("display","block");
            Ext.get("aursoft_logo").setStyle("display","block");
            Ext.get("store_name").setStyle("display","block");
            Ext.getCmp("main_left_panel").show();
        }
        else{
            //Ext.get("inventory_flow_logo").setStyle("display","none");
            Ext.get("aursoft_logo").setStyle("display","none");
            Ext.getCmp("main_left_panel").hide();
            Ext.get("store_name").setStyle("display","none");
            if(Ext.getCmp(p+"-form")){
                makeObject(p);
            }
        }
        active_layout = p;
        var centerPanel = Ext.getCmp("main_center_panel");
        centerPanel.layout.setActiveItem(p);
        centerPanel.doLayout();
        LoadingMask.hideMessage();
        
    }
    //Go to home links
    function homePage(){
        activeLayout("center-panel");
     }
    function createEmptyRows(store,loadJsonData,rowsCount){
       var dataCount = store.totalCount;
       var rCount = rowsCount ? rowsCount: emptyRows;
       var emptyr= rCount-parseInt(dataCount);
       if(emptyr>0){
           for(var i=0;i<=emptyr;i++){
               store.add(loadJsonData);
           }
      }
    }
    var LoadingMask = {
        showMessage:function(Msg){
            loadingMask.msg=Msg;
            loadingMask.show();
        },
        hideMessage:function (){
            loadingMask.hide();
        }
    };
    function loadGrids(grids){
        for(var i=0;i<grids.length;i++){
            Ext.getCmp(grids[i]).store.load();
        }
    }
        
   
    function getSelection(grid,key){        
        var id_list = "";
        if(grid){
            var sel = grid.selModel.getSelection();            
            for(var i=0;i<sel.length; i++){
                id_list +=  sel[i].get(key?key:'id');
                if(i<sel.length-1){
                    id_list +=',';
                }
            }
        }
        return id_list;
    }
    function performAction(action,url,grid,callback,opt){
         var selected = grid ? getSelection(grid,opt.key) : opt.id;
         Ext.Msg.show({
             title:action,
             msg: 'Are you really want to perform this '+action+' action?',
             buttons: Ext.Msg.YESNOCANCEL,
             icon: Ext.Msg.QUESTION,
             fn:function(btn,text){
                 if(btn=='yes'){
                     Ext.Ajax.request({
                        url: url,
                        params:{selected:selected},
                        success: function (response) {
                            if(grid){
                                grid.store.load();
                            }
                            if(opt && opt.store){
                                opt.store.load();
                            }
                            if(callback){
                                var data = Ext.JSON.decode(response.responseText);
                                callback(data);
                            }
                        },
                        failure: function () {}
                    });
                 }
             }
        });
    }
    
    function printBatch(j){
        
        var order = batch_array.orders[j];
        var print_iframe = Ext.get("print_batch_iframe").dom.contentWindow;
        print_iframe.$(".invoice-date").html(order.so_date);
        print_iframe.$(".print-invoice-date").html(Ext.Date.format(new Date(),'d-m-Y'));
        print_iframe.$(".invoice-no").html(order.so_id);
        print_iframe.$(".bill_to").html(order.cust_name);
        print_iframe.$(".region_customer").html(order.so_region);
        print_iframe.$(".warehouse_customer").html(order.so_warehouse?order.so_warehouse:"Default Location");

        var sale_grid = order.items;   
        var tbody_html = "";
        var _total =0, _quantity=0,  _discount = 0, _sub_total=0;
        for(var i=0;i<sale_grid.length;i++){
            tbody_html +="<tr><td align='center'>"+(i+1)+"</td>";
            tbody_html +="<td>"+sale_grid[i].item_name+"</td>";
            tbody_html +="<td align='center'>"+sale_grid[i].item_quantity+"</td>";
            tbody_html +="<td align='center'>"+sale_grid[i].unit_name+"</td>";
            tbody_html +="<td align='center'>"+sale_grid[i].unit_price+"</td>";
            tbody_html +="<td align='center'>"+sale_grid[i].discount+"</td>";
            tbody_html +="<td align='center'>"+sale_grid[i].net_price+"</td>";
            tbody_html +="<td  align='center'>"+sale_grid[i].sub_total+"</td></tr>";

            _total = _total + parseFloat(sale_grid[i].sub_total);
            _sub_total = _sub_total + (parseFloat(sale_grid[i].item_quantity)*parseFloat(sale_grid[i].net_price));
            _quantity = _quantity + parseFloat(sale_grid[i].item_quantity);
            if(settings.sale && settings.sale["config_saleterms"]){
                print_iframe.$(".terms_conditions").show();
                print_iframe.$(".terms_condtion_text").html(settings.sale["config_saleterms"]);
            } else {
                print_iframe.$(".terms_conditions").hide();
            }
        if(order.cust_id=="0"){
            print_iframe.$(".balanced").hide();
            print_iframe.$(".pre_balanced").hide();
            print_iframe.$(".grand_totaled").hide();
            print_iframe.$(".warehoused").hide();
        } else {
            print_iframe.$(".balanced").show();
            print_iframe.$(".pre_balanced").show();
            print_iframe.$(".grand_totaled").show();
            print_iframe.$(".warehoused").show();
        }
        }
        _discount = order.discount;
        var balance = _sub_total-order.so_paid;
        print_iframe.$(".receipt-large-body").html(tbody_html);    
        print_iframe.$(".sub_total_qty,.total_qty").html(_quantity);    
        print_iframe.$(".sub_total").html(Ext.util.Format.number(_sub_total,"0.00")+" Rs.");
        print_iframe.$(".total_amount").html(Ext.util.Format.number(_sub_total,"0.00"));
        print_iframe.$(".discount").html(Ext.util.Format.number(_discount,"0.00")+" Rs.");
        print_iframe.$(".paid").html(Ext.util.Format.number(order.so_paid,"0.00")+" Rs.");
        print_iframe.$(".pre_balance").html(Ext.util.Format.number(order.pre_balance,"0.00")+" Rs.");
        print_iframe.$(".balance").html(Ext.util.Format.number(balance,"0.00")+" Rs.");
        print_iframe.$(".total_recpt_large").html(Ext.util.Format.number(_total, "0.00")+" Rs.");
        print_iframe.$(".grand_total").html(Ext.util.Format.number(parseFloat(order.pre_balance)+balance, "0.00")+" Rs.");
        
            print_iframe.print();
        
        j = j + 1;
        if(j<batch_array.orders.length){
            setTimeout("printBatch("+j+")",5000);
        }
    }
    
</script>
<?php echo $footer; ?> 
