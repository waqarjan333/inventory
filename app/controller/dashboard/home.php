<?php 
/* Copyright (c) 2012- AURSoft
 * Crontroller for dashboard to welcome POS users
 * Created Date: 28/09/2011
 * Craeted By: Umair shahid
 * Modified Date: 
 * Last Modified By: 
 */
class ControllerDashboardHome extends Controller { 
        public function index() {
            //Load Controller                      
            if (!$this->siteusers->isLogged()) {
                $this->redirect($this->seourls->rewrite(HTTPS_SERVER . 'index.php?route=login/login'));
            }            
                      
            $this->getHomePage();
        
      }
        public function getHomePage(){
            // Load language from service provider directory
            $this->language->load('dashboard/home');
            // Load common model
            $this->load->model('common/common');
            
            $this->data['button_cancel'] = $this->language->get('button_cancel');
            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_search'] = $this->language->get('button_search');
            $this->data['button_show_all'] = $this->language->get('button_show_all');
            $this->data['text_loading'] = $this->language->get('text_loading');
            $this->data['text_type_name'] = $this->language->get('text_type_name');
            $this->data['text_type_default'] = $this->language->get('text_type_default');
            $this->data['text_group_name'] = $this->language->get('text_group_name');
            $this->data['text_group_default'] = $this->language->get('text_group_default');
            $this->data['text_error'] = $this->language->get('text_error');
            $this->data['button_pay'] = $this->language->get('button_pay');
            $this->data['pay_order'] = $this->language->get('pay_order');
            $this->data['date_paid'] = $this->language->get('date_paid');
            $this->data['payment_method'] = $this->language->get('payment_method');
            $this->data['remarks'] = $this->language->get('remarks');
            $this->data['label_from_date'] = $this->language->get('label_from_date');
            $this->data['label_end_date'] = $this->language->get('label_end_date');
            
            $this->data['label_title'] = $this->language->get('label_title');
            $this->data['label_name'] = $this->language->get('label_name');
            $this->data['label_name_emptytext'] = $this->language->get('label_name_emptytext');
            $this->data['label_address'] = $this->language->get('label_address');
            $this->data['label_phone'] = $this->language->get('label_phone');
            $this->data['label_mobile'] = $this->language->get('label_mobile');
            $this->data['label_email'] = $this->language->get('label_email');
            $this->data['label_active'] = $this->language->get('label_active');
            $this->data['label_add_new_customer'] = $this->language->get('label_add_new_customer'); 
            $this->data['label_all'] = $this->language->get('label_all'); 
            $this->data['add_new_vendor'] = $this->language->get('add_new_vendor');
            $this->data['msg_loadings'] = $this->language->get('msg_loadings');
            $this->data['msg_please_wait'] = $this->language->get('msg_please_wait');
            $this->data['msg_send_sms'] = $this->language->get('msg_send_sms');
            $this->data['msg_saving'] = $this->language->get('msg_saving');
            
            $this->data['label_obalance'] = $this->language->get('label_cust_obalance');
            $this->data['label_group'] = $this->language->get('label_cust_group'); 
            $this->data['label_credit_limit'] = $this->language->get('label_cust_credit_limit');
            $this->data['label_payment_term'] = $this->language->get('label_cust_payment_term');
            
            $this->data['text_add_item'] = $this->language->get('text_add_item'); 
            $this->data['text_type'] = $this->language->get('text_type');   
            $this->data['text_name'] = $this->language->get('text_name'); 
            $this->data['text_name_placeholder'] = $this->language->get('text_name_placeholder');
            $this->data['text_category'] = $this->language->get('text_category');
            $this->data['text_description'] = $this->language->get('text_description');
            $this->data['text_qty_on_hand'] = $this->language->get('text_qty_on_hand'); 
            $this->data['text_bar_code'] = $this->language->get('text_bar_code');   
            $this->data['text_generate'] = $this->language->get('text_generate'); 
            $this->data['text_purchase_price'] = $this->language->get('text_purchase_price'); 
            $this->data['text_sales_price'] = $this->language->get('text_sales_price'); 
            $this->data['add_new_salerep_button'] = $this->language->get('add_new_salerep_button');
            
            $this->data['inv_customization'] = $this->language->get('inv_customization');
            
            $this->data['text_prevbalance'] = $this->language->get('text_prevbalance'); 
            $this->data['text_gatepass'] = $this->language->get('text_gatepass'); 
            $this->data['text_showregister_inv'] = $this->language->get('text_showregister_inv');
            $this->data['text_showregister_print'] = $this->language->get('text_showregister_print');
            $this->data['text_send_message_cust'] = $this->language->get('text_send_message_cust'); 
            $this->data['text_send_message_salerep'] = $this->language->get('text_send_message_salerep');
            
            //Setting labels array to set on view page (tpl)
            $this->document->title = $this->language->get('heading_title');
            $this->data['heading_title'] = $this->language->get('heading_title'); 
            $this->data['json_home'] = HTTP_SERVER. "themes/aursoft/javascript/layout/home.js";
            $this->data['json_items'] = HTTP_SERVER. "themes/aursoft/javascript/layout/items.js";
            $this->data['json_item_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/item_list.js";
            $this->data['json_sale_invoice'] = HTTP_SERVER. "themes/aursoft/javascript/layout/sale_invoice.js";
            $this->data['json_order_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/order_list.js";
            $this->data['json_customers'] = HTTP_SERVER. "themes/aursoft/javascript/layout/customers.js";
            $this->data['json_customer_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/customer_list.js";
            $this->data['json_purchase_invoice'] = HTTP_SERVER. "themes/aursoft/javascript/layout/purchase_invoice.js";
            $this->data['json_purchase_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/purchase_list.js";
            $this->data['json_vendors'] = HTTP_SERVER. "themes/aursoft/javascript/layout/vendors.js";
            $this->data['json_vendor_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/vendor_list.js";
            $this->data['json_dashboard'] = HTTP_SERVER. "themes/aursoft/javascript/layout/dashboard.js";
            $this->data['json_accounts'] = HTTP_SERVER. "themes/aursoft/javascript/layout/accounts.js";
            $this->data['json_journal'] = HTTP_SERVER. "themes/aursoft/javascript/layout/accounts/journal.js";
            $this->data['json_journalView'] = HTTP_SERVER. "themes/aursoft/javascript/layout/accounts/journalView.js";
            $this->data['json_register'] = HTTP_SERVER. "themes/aursoft/javascript/layout/accounts/regz.js";
            $this->data['json_settings'] = HTTP_SERVER. "themes/aursoft/javascript/layout/settings.js";
            $this->data['json_reminders'] = HTTP_SERVER. "themes/aursoft/javascript/layout/reminders.js";
            $this->data['json_price_level'] = HTTP_SERVER. "themes/aursoft/javascript/layout/price_level.js";
            $this->data['json_reports'] = HTTP_SERVER. "themes/aursoft/javascript/layout/reports.js";
            $this->data['json_warehouse_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/warehouses.js";
            $this->data['json_expense_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/expenses.js";
            $this->data['json_stock_transfer'] = HTTP_SERVER. "themes/aursoft/javascript/layout/stock_transfer.js";
            $this->data['json_batch_sales'] = HTTP_SERVER. "themes/aursoft/javascript/layout/batch_sales.js";
            $this->data['json_sale_return'] = HTTP_SERVER. "themes/aursoft/javascript/layout/sale_return.js";
            $this->data['json_customer_group'] = HTTP_SERVER. "themes/aursoft/javascript/layout/customer_group.js";
            $this->data['json_customer_type'] = HTTP_SERVER. "themes/aursoft/javascript/layout/customer_type.js";
            $this->data['json_vendor_group'] = HTTP_SERVER. "themes/aursoft/javascript/layout/vendor_group.js";
            $this->data['json_salesrep'] = HTTP_SERVER. "themes/aursoft/javascript/layout/salesrep.js";
            $this->data['json_items_adjust_list'] = HTTP_SERVER. "themes/aursoft/javascript/layout/adjust_stock.js";
            $this->data['json_user_access']= HTTP_SERVER. 'vendor/userRights/access.json';
            
            $this->data['url_labels'] = HTTP_SERVER. "index.php?route=common/labels/";
            
            $this->data['url_get_warehouses_2']= HTTP_SERVER.'index.php?route=dashboard/warehouses/get_warehouses_2';
            $this->data['url_save_transfer']= HTTP_SERVER.'index.php?route=dashboard/item/savestocktransfer';
            $this->data['url_get_item_warehouse']= HTTP_SERVER.'index.php?route=dashboard/item/warehouseitemslist';
            $this->data['url_warehouse_adjusted_items']= HTTP_SERVER.'index.php?route=dashboard/item/getwarehouseitems';
            $this->data['url_get_item_warehouse_qty']= HTTP_SERVER.'index.php?route=dashboard/item/get_item_warehouse_qty';
            $this->data['url_get_items']= HTTP_SERVER.'index.php?route=dashboard/item/getitems';
            $this->data['url_get_purchase_items']= HTTP_SERVER.'index.php?route=dashboard/item/getPurchaseItems';
            $this->data['url_get_accounts']= HTTP_SERVER.'index.php?route=dashboard/account/getaccounts';
            $this->data['url_get_income_accounts']= HTTP_SERVER.'index.php?route=dashboard/account/getincomeaccounts';
            $this->data['url_get_account_types']= HTTP_SERVER.'index.php?route=dashboard/account/getAccountTypes';
            $this->data['url_get_account_heads']= HTTP_SERVER.'index.php?route=dashboard/account/getAccountHeads';
            $this->data['url_saveupdate_account']= HTTP_SERVER.'index.php?route=dashboard/account/saveupdate';
            $this->data['url_delete_account']= HTTP_SERVER.'index.php?route=dashboard/account/deleteaccount';
            $this->data['url_deactivate_account']= HTTP_SERVER.'index.php?route=dashboard/account/deactivateaccount';          
            $this->data['url_get_credit_merchant']= HTTP_SERVER.'index.php?route=dashboard/account/getCreditMerchantAccount';          
            $this->data['url_getrights'] = HTTP_SERVER.'index.php?route=common/rights/getUserRight';
            $this->data['unit_price_uom'] = HTTP_SERVER.'index.php?route=dashboard/item/unit_price_uom';
            $this->data['url_item_save'] = HTTP_SERVER.'index.php?route=dashboard/item/saveitem';
            $this->data['url_item_service_save'] = HTTP_SERVER.'index.php?route=dashboard/item/saveitem';
            $this->data['url_save_uom'] = HTTP_SERVER.'index.php?route=dashboard/item/saveuom';
            $this->data['url_delete_unit_uom'] = HTTP_SERVER.'index.php?route=dashboard/item/deleteUnitUom';
            $this->data['url_item_copy'] = HTTP_SERVER.'index.php?route=dashboard/item/copyitem';
            $this->data['get_me_uom']= HTTP_SERVER.'index.php?route=common/common/getUnits';
            $this->data['update_po_remarks']= HTTP_SERVER.'index.php?route=common/common/updateRemarks';
            $this->data['print_label']= HTTP_SERVER.'index.php?route=common/common/printLabel';
            $this->data['po_unit_uom_price']= HTTP_SERVER.'index.php?route=dashboard/po/getPoUnitsPrice';
            $this->data['url_item_deactivate'] = HTTP_SERVER.'index.php?route=dashboard/item/changeState';
            $this->data['url_item_upload_image'] = HTTP_SERVER.'index.php?route=dashboard/item/uploadimage';
            $this->data['url_item_generate_barcode'] = HTTP_SERVER.'index.php?route=dashboard/item/gbarcode';
            $this->data['url_adjust_barcode'] = HTTP_SERVER.'index.php?route=dashboard/item/adjustBarcode';
            $this->data['url_getcategories'] = HTTP_SERVER.'index.php?route=dashboard/home/getCategories';
            $this->data['url_getcat'] = HTTP_SERVER.'index.php?route=dashboard/item/getCat';
            $this->data['url_gettreecategories'] = HTTP_SERVER.'index.php?route=dashboard/home/getTree';
            $this->data['url_gettypes'] = HTTP_SERVER.'index.php?route=dashboard/home/getTypes';
            $this->data['url_account_types'] = HTTP_SERVER.'index.php?route=dashboard/account/getAccountTypes';
            $this->data['url_account_type_saveupdate'] = HTTP_SERVER.'index.php?route=dashboard/account/saveupdatetypes';
            $this->data['url_delete_type'] = HTTP_SERVER.'index.php?route=dashboard/account/deletetype';
            $this->data['url_item_category_save'] = HTTP_SERVER.'index.php?route=dashboard/item/savecateogory';
            $this->data['url_item_category_delete'] = HTTP_SERVER.'index.php?route=dashboard/item/deletecategory';
            $this->data['url_print_label_item'] = HTTP_SERVER.'index.php?route=dashboard/item/printlabelItem';
            $this->data['url_save_items'] = HTTP_SERVER.'index.php?route=dashboard/item/createItems';
            $this->data['url_get_map_items'] = HTTP_SERVER.'index.php?route=dashboard/item/getMapItems';
            $this->data['url_get_batch_count']=HTTP_SERVER.'index.php?route=dashboard/item/batchCount';
            $this->data['url_get_batch_adjust']=HTTP_SERVER.'index.php?route=dashboard/item/getBatchAdjust';
            $this->data['url_url_backup'] = HTTP_SERVER.'index.php?route=common/common/export_database';
            $this->data['url_get_customers']= HTTP_SERVER.'index.php?route=dashboard/customer/getCustomers';
            $this->data['url_customer_save'] = HTTP_SERVER.'index.php?route=dashboard/customer/saveCustomer';
            $this->data['url_get_customers_group'] = HTTP_SERVER.'index.php?route=dashboard/cgroup/getGroup';
            $this->data['url_save_customers_group'] = HTTP_SERVER.'index.php?route=dashboard/cgroup/saveupdate';
            $this->data['url_delete_customers_group'] = HTTP_SERVER.'index.php?route=dashboard/cgroup/deleteGroup';
          
            
            
            $this->data['url_get_customers_type'] = HTTP_SERVER.'index.php?route=dashboard/customertype/getType';
            $this->data['url_save_customers_type'] = HTTP_SERVER.'index.php?route=dashboard/customertype/saveupdate';
            $this->data['url_delete_customers_type'] = HTTP_SERVER.'index.php?route=dashboard/customertype/deleteType';
            
            $this->data['url_get_payment_methods'] = HTTP_SERVER.'index.php?route=dashboard/home/getPaymentMethods';
            $this->data['url_saleinvoice_save'] = HTTP_SERVER.'index.php?route=dashboard/so/save';
            $this->data['url_get_so'] = HTTP_SERVER.'index.php?route=dashboard/so/getSO';
            $this->data['url_get_stockTransfer'] = HTTP_SERVER.'index.php?route=dashboard/so/get_stockTransfer';
            $this->data['url_get_so_record'] = HTTP_SERVER.'index.php?route=dashboard/so/getSaleInvoice';
            $this->data['url_get_transfer_record'] = HTTP_SERVER.'index.php?route=dashboard/so/getTransferInvoice';
            $this->data['url_so_pay'] = HTTP_SERVER.'index.php?route=dashboard/so/paySO';
            $this->data['url_so_pay_del'] = HTTP_SERVER.'index.php?route=dashboard/so/payDelSO';
            $this->data['url_get_so_payments'] = HTTP_SERVER.'index.php?route=dashboard/so/getPayments';
            $this->data['url_save_inv_description'] = HTTP_SERVER.'index.php?route=common/common/saveInvoiceDescription';
            $this->data['url_get_region_customers'] = HTTP_SERVER.'index.php?route=dashboard/customer/getRegionCustomer';
            $this->data['url_get_batch_orders'] = HTTP_SERVER.'index.php?route=dashboard/so/getBatchInvoices';
            $this->data['url_sale_return_invoices'] = HTTP_SERVER.'index.php?route=dashboard/so/getSaleReturnInvoices';
            $this->data['url_get_batch_detail'] = HTTP_SERVER.'index.php?route=dashboard/so/getBatchDetail';
            $this->data['url_delete_so_invoice'] = HTTP_SERVER.'index.php?route=dashboard/so/delete';
            $this->data['url_delete_st_invoice'] = HTTP_SERVER.'index.php?route=dashboard/so/deleteStockTransfer';
            $this->data['url_get_pricelevel'] = HTTP_SERVER.'index.php?route=dashboard/so/getPriceLevel';
            
            $this->data['url_get_item_record'] = HTTP_SERVER.'index.php?route=dashboard/item/getItem';

            $this->data['url_get_item_uom'] = HTTP_SERVER.'index.php?route=dashboard/item/getuom';
             $this->data['get_item_warehouse_reorder']= HTTP_SERVER.'index.php?route=dashboard/item/get_warehouse_reorder';
            $this->data['get_item_warehouse_reorder_qty']= HTTP_SERVER.'index.php?route=dashboard/item/get_item_warehouse_reorder_qty';

            $this->data['url_get_stock_items'] = HTTP_SERVER.'index.php?route=dashboard/item/getStockItems';
            $this->data['url_get_customer_record'] = HTTP_SERVER.'index.php?route=dashboard/customer/getCustomer';
            $this->data['url_customer_deactivate'] = HTTP_SERVER.'index.php?route=dashboard/customer/changeState';
            $this->data['url_post_stock_items']= HTTP_SERVER.'index.php?route=dashboard/item/saveAdjustedStock';
            
            $this->data['url_vendor_save'] = HTTP_SERVER.'index.php?route=dashboard/vendor/saveVendor';
            $this->data['url_get_vendors']= HTTP_SERVER.'index.php?route=dashboard/vendor/getVendors';
            $this->data['url_get_vendor_record'] = HTTP_SERVER.'index.php?route=dashboard/vendor/getVendor';
            $this->data['url_vendor_deactivate'] = HTTP_SERVER.'index.php?route=dashboard/vendor/changeState';
            
            $this->data['url_purchaseinvoice_save'] = HTTP_SERVER.'index.php?route=dashboard/po/save';
            $this->data['url_get_po'] = HTTP_SERVER.'index.php?route=dashboard/po/getPO';            
            $this->data['url_get_po_record'] = HTTP_SERVER.'index.php?route=dashboard/po/getPurchaseInvoice';
            $this->data['url_get_bl_po_record'] = HTTP_SERVER.'index.php?route=dashboard/po/bl_getPurchaseInvoice';
            $this->data['url_get_bl_purchase_invoice_no'] = HTTP_SERVER.'index.php?route=dashboard/po/bl_getPurchaseInvoiceNo';
            $this->data['url_get_bl_purchase_invoice_items'] = HTTP_SERVER.'index.php?route=dashboard/po/bl_getPurchaseInvoiceItems';
            $this->data['url_get_bl_barcodes'] = HTTP_SERVER.'index.php?route=dashboard/po/bl_getBarcodes';
            $this->data['url_po_pay'] = HTTP_SERVER.'index.php?route=dashboard/po/payPO';
            $this->data['url_po_pay_del'] = HTTP_SERVER.'index.php?route=dashboard/po/payDelPO';
            $this->data['url_get_po_payments'] = HTTP_SERVER.'index.php?route=dashboard/po/getPayments';
            $this->data['url_delete_po_invoice'] = HTTP_SERVER.'index.php?route=dashboard/po/delete';
              $this->data['url_PurchasesaveExpense'] = HTTP_SERVER.'index.php?route=dashboard/po/SavePurcahseExpense';
            $this->data['get_url_reports'] = HTTP_SERVER.'index.php?route=reports/reports';
            $this->data['get_url_account_reports'] = HTTP_SERVER.'index.php?route=reports/accReports';
            $this->data['get_url_custom_reports'] = HTTP_SERVER.'index.php?route=reports/custom';
            
            $this->data['url_get_warehouses']= HTTP_SERVER.'index.php?route=dashboard/warehouses/getWarehouses';
            $this->data['url_warehouses_saveupdate'] = HTTP_SERVER.'index.php?route=dashboard/warehouses/saveupdate';
            $this->data['url_warehouses_deactivate'] = HTTP_SERVER.'index.php?route=dashboard/warehouses/deactivateWarehouse';
            
            $this->data['url_get_pricelevels']= HTTP_SERVER.'index.php?route=dashboard/pricelevel/getPriceLevels';
            $this->data['url_save_pricelevels']= HTTP_SERVER.'index.php?route=dashboard/pricelevel/saveupdate';
            $this->data['url_delete_pricelevels']= HTTP_SERVER.'index.php?route=dashboard/pricelevel/deletePriceLevel';
            $this->data['url_get_pricelevels_items']= HTTP_SERVER.'index.php?route=dashboard/pricelevel/itemsPriceLevel';
            
            $this->data['url_chart_sale']= HTTP_SERVER.'index.php?route=dashboard/dashboard/saleChart';
            $this->data['url_chart_product']= HTTP_SERVER.'index.php?route=dashboard/dashboard/topProductChart';
            $this->data['url_chart_customer']= HTTP_SERVER.'index.php?route=dashboard/dashboard/topCustomerChart';
                        
            $this->data['url_get_salesrep']= HTTP_SERVER.'index.php?route=dashboard/salesrep/getSalesreps';
            $this->data['url_save_salesrep']= HTTP_SERVER.'index.php?route=dashboard/salesrep/saveupdate';
            $this->data['url_delete_salesrep']= HTTP_SERVER.'index.php?route=dashboard/salesrep/deleteSalerep';
            $this->data['url_deactivate_salesrep']= HTTP_SERVER.'index.php?route=dashboard/salesrep/deactivateSalerep';
            
            $this->data['url_get_journal'] = HTTP_SERVER. 'index.php?route=account/journal/getJournal';            
            $this->data['url_save_journal'] = HTTP_SERVER. 'index.php?route=account/journal/save_update';
            $this->data['url_delete_journal'] = HTTP_SERVER. 'index.php?route=account/journal/delete';
            $this->data['url_save_journal_invoice'] = HTTP_SERVER. 'index.php?route=account/journalview/save_update_invoice';
            $this->data['url_previous_journal_invoice'] = HTTP_SERVER. 'index.php?route=account/journalview/previous_invoice';
            $this->data['url_next_journal_invoice'] = HTTP_SERVER. 'index.php?route=account/journalview/next_invoice';
            $this->data['url_delete_journal_invoice'] = HTTP_SERVER. 'index.php?route=account/journalview/delete_invoice';
            $this->data['url_retrieve_journal_invoice'] = HTTP_SERVER. 'index.php?route=account/journalview/retrieve_invoice';
            $this->data['url_retrieve_journal_details'] = HTTP_SERVER. 'index.php?route=account/journalview/retrieve_invoice_details';
            
            $this->data['url_get_customer_regRecord'] = HTTP_SERVER.'index.php?route=account/regz/getRegionCustomer';
            $this->data['url_get_vendor_regRecord'] = HTTP_SERVER.'index.php?route=account/regz/getVendorRegister';
            $this->data['url_get_register'] = HTTP_SERVER. 'index.php?route=account/regz/getRegister';
            $this->data['url_getCustomerPrevious'] = HTTP_SERVER. 'index.php?route=account/regz/getCustomerPrevious';
            $this->data['url_get_SaleInvoiceRegister'] = HTTP_SERVER. 'index.php?route=account/regz/get_SaleInvoiceRegister';
            $this->data['url_save_register'] = HTTP_SERVER. 'index.php?route=account/regz/save_update';
            $this->data['url_delete_register'] = HTTP_SERVER. 'index.php?route=account/regz/delete';            
            $this->data['url_receivable_pay'] = HTTP_SERVER. 'index.php?route=account/regz/pay';
            $this->data['url_sendsms'] = HTTP_SERVER. 'index.php?route=common/common/sendSMS';
            $this->data['url_security_question'] = HTTP_SERVER. 'index.php?route=common/common/securityQuestion';
            $this->data['url_save_security_question'] = HTTP_SERVER. 'index.php?route=common/common/saveSecurityQuestion';
            $this->data['url_get_banks']= HTTP_SERVER.'index.php?route=dashboard/bank/getBanks';            
            $this->data['url_get_expenses']= HTTP_SERVER.'index.php?route=dashboard/expense/getExpenses';
            $this->data['url_get_all_expenses']= HTTP_SERVER.'index.php?route=dashboard/expense/getAllExpenses';
            
            $this->data['url_get_all_loans']= HTTP_SERVER.'index.php?route=dashboard/expense/getAllLoans';
            
            $this->data['url_get_users']= HTTP_SERVER.'index.php?route=users/users/getUsers';            
            $this->data['url_save_users']= HTTP_SERVER.'index.php?route=users/users/saveUser';
            $this->data['url_delete_users']= HTTP_SERVER.'index.php?route=users/users/deleteUser';
            
            $this->data['url_get_units']= HTTP_SERVER.'index.php?route=settings/settings/getUnits';
                       
            $this->data['url_save_units']= HTTP_SERVER.'index.php?route=settings/settings/saveUnit';
            $this->data['url_delete_unit']= HTTP_SERVER.'index.php?route=settings/settings/deleteUnit';
            
            $this->data['url_get_balance']= HTTP_SERVER.'index.php?route=common/common/getBalance';
            
            $this->data['url_save_settings']= HTTP_SERVER.'index.php?route=common/common/saveSettings';
            $this->data['url_get_settings']= HTTP_SERVER.'index.php?route=common/common/getSettings';

            $this->data['url_Updateunit_price_uom']= HTTP_SERVER.'index.php?route=dashboard/item/Updateunit_price_uom';
            // $this->data['url_save_uom_price2']= HTTP_SERVER.'index.php?route=dashboard/item/save_uom_price2';
            // $this->data['url_save_uom_price3']= HTTP_SERVER.'index.php?route=dashboard/item/save_uom_price3';
           
            
            
            $this->data['url_logout'] = $this->seourls->rewrite(HTTP_SERVER . 'index.php?route=dashboard/logout');
            
            $this->data['current_user_id']= $this->session->data['su_id'];            
            $this->data['user_type'] = $this->session->data['su_type'];
            $this->data['update_pass'] = $this->session->data['update_pass'];
            $this->data['user_right'] = $this->session->data['user_right'];
            $this->data['customer_id'] =$this->model_common_common->getCustomerId($this->session->data['su_id']);
            $this->data['userAccessJSON'] = $this->model_common_common->getUserAccess($this->session->data['su_id']);
            $this->data['user_access_json'] = $this->model_common_common->getUserAccess($this->session->data['su_id']);
            
            $this->data['warehouse_list'] = $this->model_common_common->getWarehouses();
            $this->data['accounts_list'] = $this->model_common_common->getAccounts();
            $this->data['pricelevel_list'] = $this->model_common_common->getPriceLevels();
            $this->data['cust_group_list'] = $this->model_common_common->getCustomerGroup();
            $this->data['cust_type_list'] = $this->model_common_common->getCustomerType();           
            $this->data['salesrep_list'] = $this->model_common_common->getSalesrep();                                    
            $this->data['asset_acountlist'] = $this->model_common_common->getAssetAccount();                                    
            $this->data['last_sale_id'] = $this->model_common_common->getLastSaleId();
            $this->data['last_transfer_id'] = $this->model_common_common->getLastTransferId();
            $this->data['last_po_id'] = $this->model_common_common->getLastPOId();
            $this->data['enable_custom_reports'] = $this->config->get('config_customreport');
            $this->data['enable_custom_regions'] = $this->config->get('config_customregion');
            $this->data['enable_avgQty'] = $this->config->get('config_averageQty');
            $this->data['enable_warehouse'] = $this->config->get('config_warehouse');
            $this->data['enable_uom'] = $this->config->get('config_uom');
            $this->data['enable_bonus_quantity'] = $this->config->get('config_BonusQty');
            $this->data['enable_regTooltip'] = $this->config->get('config_regTooltip');
            $this->data['enable_InvRegister'] = $this->config->get('config_InvRegister');
            $this->data['RequiredWarehouse'] = $this->config->get('config_Reqwarehouse');
           // $this->data['so_pay_methods'] = $this->model_common_common->getSOPayMethods();
            //$this->data['po_pay_methods'] = $this->model_common_common->getPOPayMethods();
            
            //Load template for current control 
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/dashboard/home.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/dashboard/home.tpl';
            } else {
                    $this->template = 'default/template/dashboard/home.tpl';
            }

            // Merge header, footer, right etc in php array
            $this->children = array(
                    'common/header',
                    'common/footer',
                    'common/column_left'
            );
            // Render final out put to view.    
            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));            
        }
        
        public function getCategories(){
            $this->load->model('common/common');
            $results = $this->model_common_common->getCategories();
            $category_list = array();
            if(isset($this->request->get['showAll'])){
                $category_list['categories'][] = array(
                        'id'             => "0",
                        'name'             => 'All'
                    );
            }
            foreach ($results as $result) {                                 
                    $category_list['categories'][] = array(
                        'id'             => $result['id'],
                        'name'             => $result['name']
                    );
            }
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($category_list), $this->config->get('config_compression'));
            
        }
        public function getTree(){
            $this->load->model('common/common');
            $data = $this->model_common_common->getTreeCategories();     
            $this->load->library('json');
            $this->response->setOutput(Json::encode($data[0]), $this->config->get('config_compression'));
        }
         
       public function getUserRight(){            
            $this->load->model('common/rights');
            
            $data = $this->request->get;            
            $userid = $data["user_id"];
            
            $result_array = array();
            $result =  $this->model_common_rights->getUser($userid);                        
            $result_array["user_id"] = $result['user_id'];
            $result_array["user_rights"] = $result['user_rigths'];
                        
            $this->load->library('json'); 
            $this->response->setOutput(Json::encode($result_array), $this->config->get('config_compression'));
        }
        
        public function getTypes(){
            $this->load->model('common/common');
            $results = $this->model_common_common->getTypes();
            $type_list = array();
            foreach ($results as $result) {                                 
                    $type_list['types'][] = array(
                        'id'             => $result['id'],
                        'name'             => $result['name']
                    );
            }
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($type_list), $this->config->get('config_compression'));
            
        }
        
        public function getPaymentMethods(){
            $this->load->model('common/common');
            $results = $this->model_common_common->getSOPayMethods();
            $type_list = array();
            foreach ($results as $result) {                                 
                    $type_list['methods'][] = array(
                        'method_id'             => $result['acc_id'],
                        'method_name'             => $result['acc_name'],
                        'method_type_id'             => $result['acc_type_id']
                    );
            }
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($type_list), $this->config->get('config_compression'));
        }
        
        
    }
?>