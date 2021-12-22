<?php  
class ControllerCommonLabels extends Controller {
    public function index() { 
            
                        
    } 
        
        public function home() { 
            $this->load->language('dashboard/home');
            $_labels = array();
            $_labels['text_inventory'] = $this->language->get('text_inventory');
           
            $_labels['text_adjust_stock'] = $this->language->get('text_adjust_stock');
            $_labels['text_adjust_stock_detail'] = $this->language->get('text_adjust_stock_detail');
            $_labels['text_stock_transfer'] = $this->language->get('text_stock_transfer');
            $_labels['text_stock_transfer_detail'] = $this->language->get('text_stock_transfer_detail');            
            $_labels['text_warehouses'] = $this->language->get('text_warehouses');
            $_labels['text_warehouses_detail'] = $this->language->get('text_warehouses_detail');            
            $_labels['text_newproduct'] = $this->language->get('text_newproduct');
            $_labels['text_newproduct_detail'] = $this->language->get('text_newproduct_detail');
            $_labels['text_productlist'] = $this->language->get('text_productlist');
            $_labels['text_productlist_detail'] = $this->language->get('text_productlist_detail');
            $_labels['text_add_new_customer'] = $this->language->get('text_add_new_customer'); 
            $_labels['text_all'] = $this->language->get('text_all'); 
            $_labels['text_sale_order'] = $this->language->get('text_sale_order');
            $_labels['text_batch_print'] = $this->language->get('text_batch_print');
            $_labels['text_batch_print_detail'] = $this->language->get('text_batch_print_detail');            
            $_labels['text_sale_return'] = $this->language->get('text_sale_return');
            $_labels['text_sale_return_detail'] = $this->language->get('text_sale_return_detail'); 
            $_labels['text_sale_estimate'] = $this->language->get('text_sale_estimate');
            $_labels['text_sale_estimate_detail'] = $this->language->get('text_sale_estimate_detail'); 
            $_labels['text_sale_invoice'] = $this->language->get('text_sale_invoice');
            $_labels['text_sale_invoice_detail'] = $this->language->get('text_sale_invoice_detail');
            $_labels['text_sale_invoice_list'] = $this->language->get('text_sale_invoice_list');
            $_labels['text_sale_invoice_list_detail'] = $this->language->get('text_sale_invoice_list_detail');
            $_labels['msg_loadings'] = $this->language->get('msg_loadings');
            $_labels['text_customer'] = $this->language->get('text_customer');
            $_labels['text_customer_type'] = $this->language->get('text_customer_type');
            $_labels['text_customer_type_detail'] = $this->language->get('text_customer_type_detail');
            $_labels['text_customer_group'] = $this->language->get('text_customer_group');
            $_labels['text_customer_group_detail'] = $this->language->get('text_customer_group_detail');
            $_labels['text_new_customer'] = $this->language->get('text_new_customer');
            $_labels['text_new_customer_detail'] = $this->language->get('text_new_customer_detail');
            $_labels['text_customer_list'] = $this->language->get('text_customer_list');
            $_labels['text_customer_list_detail'] = $this->language->get('text_customer_list_detail');
            
            $_labels['label_name'] = $this->language->get('label_name');
            $this->data['label_name_emptytext'] = $this->language->get('label_name_emptytext');
            $_labels['label_address'] = $this->language->get('label_address');
            $_labels['label_phone'] = $this->language->get('label_phone');
            $_labels['label_mobile'] = $this->language->get('label_mobile');
            $_labels['label_email'] = $this->language->get('label_email');
            $_labels['label_obalance'] = $this->language->get('label_cust_obalance');
            $_labels['label_group'] = $this->language->get('label_cust_group');
            $_labels['label_payment_term'] = $this->language->get('label_cust_payment_term');
            $_labels['label_credit_limit'] = $this->language->get('label_cust_credit_limit');
            
            $_labels['button_cancel'] = $this->language->get('button_cancel');
            $_labels['button_save'] = $this->language->get('button_save');
            $_labels['button_add'] = $this->language->get('button_add');
            $_labels['button_pay'] = $this->language->get('button_pay');
            $_labels['pay_order'] = $this->language->get('pay_order');
            $_labels['date_paid'] = $this->language->get('date_paid');
            $_labels['payment_method'] = $this->language->get('payment_method');
            $_labels['remarks'] = $this->language->get('remarks');
            $_labels['text_purchase_order'] = $this->language->get('text_purchase_order');            
            $_labels['text_new_purchase_order'] = $this->language->get('text_new_purchase_order');
            $_labels['text_new_purchase_order_detail'] = $this->language->get('text_new_purchase_order_detail');
            $_labels['text_purchase_order_list'] = $this->language->get('text_purchase_order_list');
            $_labels['text_purchase_order_list_detail'] = $this->language->get('text_purchase_order_list_detail');
            $_labels['text_purchase_return'] = $this->language->get('text_purchase_return');
            $_labels['text_purchase_return_detail'] = $this->language->get('text_purchase_return_detail');
            
            $_labels['msg_please_wait'] = $this->language->get('msg_please_wait'); 
            $_labels['text_vendor'] = $this->language->get('text_vendor');            
            $_labels['text_new_vendor'] = $this->language->get('text_new_vendor');
            $_labels['text_new_vendor_detail'] = $this->language->get('text_new_vendor_detail');
            $_labels['text_vendor_list'] = $this->language->get('text_vendor_list');
            $_labels['text_vendor_list_detail'] = $this->language->get('text_vendor_list_detail');
            $_labels['text_expense_management'] = $this->language->get('text_expense_management');
            $_labels['text_expense_management_detail'] = $this->language->get('text_expense_management_detail');
            
            $_labels['text_add_item'] = $this->language->get('text_add_item'); 
            $_labels['text_type'] = $this->language->get('text_type');   
            $_labels['text_name'] = $this->language->get('text_name'); 
            $_labels['text_name_placeholder'] = $this->language->get('text_name_placeholder');
            $_labels['text_category'] = $this->language->get('text_category');
            $_labels['text_description'] = $this->language->get('text_description');
            $_labels['text_qty_on_hand'] = $this->language->get('text_qty_on_hand'); 
            $_labels['text_bar_code'] = $this->language->get('text_bar_code');   
            $_labels['text_generate'] = $this->language->get('text_generate'); 
            $_labels['text_purchase_price'] = $this->language->get('text_purchase_price'); 
            $_labels['text_sales_price'] = $this->language->get('text_sales_price'); 
            
            $_labels['text_type_default'] = $this->language->get('text_type_default');
            $_labels['add_new_salerep_button'] = $this->language->get('add_new_salerep_button');
            $_labels['add_new_vendor'] = $this->language->get('add_new_vendor');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    } 
        
        public function accountspanel() { 
            $this->load->language('dashboard/account');
            $_labels = array();          
            
             $_labels['text_title'] = $this->language->get('text_title');  
             $_labels['text_new'] = $this->language->get('text_new');  
             $_labels['text_close'] = $this->language->get('text_close');  
             $_labels['text_edit'] = $this->language->get('text_edit');  
             $_labels['text_edit_info'] = $this->language->get('text_edit_info');  
             $_labels['text_close_info'] = $this->language->get('text_close_info');  
             $_labels['text_search_account'] = $this->language->get('text_search_account');  
             $_labels['text_account_name'] = $this->language->get('text_account_name');  
             $_labels['text_new_info'] = $this->language->get('text_new_info');  
             $_labels['text_description'] = $this->language->get('text_description');  
             $_labels['text_op_balance'] = $this->language->get('text_op_balance');  
             $_labels['text_account_status'] = $this->language->get('text_account_status');  
             $_labels['text_percent'] = $this->language->get('text_percent');  
             $_labels['text_charge'] = $this->language->get('text_charge');  
             $_labels['text_account_type'] = $this->language->get('text_account_type');  
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        public function stocktransferpanel() { 
            $this->load->language('dashboard/so');
            $_labels = array();          
               $_labels['heading_title_0'] = $this->language->get('heading_title_0');  
             $_labels['text_new'] = $this->language->get('text_new');  
             $_labels['text_close'] = $this->language->get('text_close');  
             $_labels['text_edit'] = $this->language->get('text_edit');  
             $_labels['text_edit_info'] = $this->language->get('text_edit_info');  
             $_labels['text_close_info'] = $this->language->get('text_close_info');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        public function dashboardpanel() { 
            $this->load->language('dashboard/dashboard');
            $_labels = array();          
            $_labels['heading_title'] = $this->language->get('heading_title');            
            $_labels['text_sales'] = $this->language->get('text_sales');            
            $_labels['text_top_items'] = $this->language->get('text_top_items');            
            $_labels['text_top_customers'] = $this->language->get('text_top_customers');            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        public function reportspanel() { 
            $this->load->language('dashboard/reports');
            
            $_labels = array();          
            $_labels['heading_title'] = $this->language->get('heading_title'); 
            $_labels['text_cancel'] = $this->language->get('text_cancel');
            $_labels['text_sales_reports'] = $this->language->get('text_sales_reports'); 
            $_labels['text_sales_by_category'] = $this->language->get('text_sales_by_category');            
            $_labels['text_sales_return_by_category'] = $this->language->get('text_sales_return_by_category');            
            $_labels['text_sales_by_item_detail'] = $this->language->get('text_sales_by_item_detail');            
            $_labels['text_category_wise_sale_report_summary'] = $this->language->get('text_category_wise_sale_report_summary');            
            $_labels['text_daily_sale_report_summary'] = $this->language->get('text_daily_sale_report_summary'); 
            $_labels['text_sales_by_sale_rep'] = $this->language->get('text_sales_by_sale_rep');            
            $_labels['text_collection_by_sale_rep'] = $this->language->get('text_collection_by_sale_rep');            
            $_labels['text_sales_by_customer_summary'] = $this->language->get('text_sales_by_customer_summary');            
            $_labels['text_sales_order_summary'] = $this->language->get('text_sales_order_summary');            
            $_labels['text_sales_summary_by_group_region'] = $this->language->get('text_sales_summary_by_group_region');
            $_labels['text_sales_by_user'] = $this->language->get('text_sales_by_user');            
            $_labels['text_sales_by_customer'] = $this->language->get('text_sales_by_customer');
            $_labels['text_customer_transaction_summary'] = $this->language->get('text_customer_transaction_summary');            
            $_labels['text_sales_by_invoices_profit'] = $this->language->get('text_sales_by_invoices_profit');
            $_labels['text_customer_list'] = $this->language->get('text_customer_list');            
            $_labels['text_customer_agging_report'] = $this->language->get('text_customer_agging_report');
            $_labels['text_dailySaleCashRecieve'] = $this->language->get('text_dailySaleCashRecieve');
            $_labels['text_CashBalance'] = $this->language->get('text_CashBalance');
            $_labels['text_ExepenseList'] = $this->language->get('text_ExepenseList');
            $_labels['text_vendor_wise_sale'] = $this->language->get('text_vendor_wise_sale');
            $_labels['text_purchase_title_reports'] = $this->language->get('text_purchase_title_reports');
            $_labels['text_purchase_reports'] = $this->language->get('text_purchase_reports');
            $_labels['text_purchase_detail_reports'] = $this->language->get('text_purchase_detail_reports');
            $_labels['text_purchase_return_reports'] = $this->language->get('text_purchase_return_reports');
            $_labels['text_vendor_transaction_summary'] = $this->language->get('text_vendor_transaction_summary');            
            $_labels['text_vendor_list'] = $this->language->get('text_vendor_list');            
            $_labels['text_vendor_payment_summary'] = $this->language->get('text_vendor_payment_summary');            
            $_labels['text_purchase_order_summary'] = $this->language->get('text_purchase_order_summary');
            $_labels['text_vendor_wise_sale_report'] = $this->language->get('text_vendor_wise_sale_report');            
            $_labels['text_vendor_register_report'] = $this->language->get('text_vendor_register_report');
            $_labels['text_vendor_agging_report'] = $this->language->get('text_vendor_agging_report');            
            $_labels['text_purchase_order_status'] = $this->language->get('text_purchase_order_status');
            $_labels['text_product_cost_report'] = $this->language->get('text_product_cost_report');            
            $_labels['text_vendor_product_list'] = $this->language->get('text_vendor_product_list');
            
            $_labels['text_inventory_reports'] = $this->language->get('text_inventory_reports');
            $_labels['text_inventory_summary'] = $this->language->get('text_inventory_summary');            
            $_labels['text_inventory_item_summary'] = $this->language->get('text_inventory_item_summary');            
            $_labels['text_negative_inventory_summary'] = $this->language->get('text_negative_inventory_summary');            
            $_labels['text_inventory_detail_report'] = $this->language->get('text_inventory_detail_report');
            $_labels['text_inventory_valuation_detail'] = $this->language->get('text_inventory_valuation_detail');            
            $_labels['text_inventory_sale_purchase_stock_report'] = $this->language->get('text_inventory_sale_purchase_stock_report');
            $_labels['text_low_stock_report'] = $this->language->get('text_low_stock_report');
            $_labels['text_check_ownership_item'] = $this->language->get('text_check_ownership_item');             
            $_labels['text_stock_transfer_report'] = $this->language->get('text_stock_transfer_report');
            $_labels['text_stock_reordering_report'] = $this->language->get('text_stock_reordering_report');            
            $_labels['text_item_list_report'] = $this->language->get('text_item_list_report');
            
            $_labels['text_accounts_reports'] = $this->language->get('text_accounts_reports');
            $_labels['text_balance_sheet'] = $this->language->get('text_balance_sheet');            
            $_labels['text_trial_balance'] = $this->language->get('text_trial_balance');            
            $_labels['text_account_receivable'] = $this->language->get('text_account_receivable');            
            $_labels['text_account_payable'] = $this->language->get('text_account_payable');
            $_labels['text_profit_and_loss'] = $this->language->get('text_profit_and_loss');            
            $_labels['text_cash_register'] = $this->language->get('text_cash_register');
            $_labels['text_income_statement_summary_report'] = $this->language->get('text_income_statement_summary_report');
            $_labels['text_expence_report'] = $this->language->get('text_expence_report');             
            $_labels['text_loan_payable_recievable_report'] = $this->language->get('text_loan_payable_recievable_report');
            $_labels['text_amount_recieved_expense_by_sale_rep'] = $this->language->get('text_amount_recieved_expense_by_sale_rep');            
            $_labels['text_essets_report'] = $this->language->get('text_essets_report');
            $_labels['text_general_ledger'] = $this->language->get('text_general_ledger');
            $_labels['text_journal_entries'] = $this->language->get('text_journal_entries');
            
            $_labels['text_custom_reports'] = $this->language->get('text_custom_reports');
            $_labels['text_invoices_report'] = $this->language->get('text_invoices_report');
            $_labels['text_stock_report'] = $this->language->get('text_stock_report');
            $_labels['text_customers_report'] = $this->language->get('text_customers_report');
            
            $_labels['text_export'] = $this->language->get('text_export');
            $_labels['text_print'] = $this->language->get('text_print');
            $_labels['text_back'] = $this->language->get('text_back');
            $_labels['text_export_emptyText'] = $this->language->get('text_export_emptyText');
            $_labels['text_print_emptyText'] = $this->language->get('text_print_emptyText');
            $_labels['text_back_emptyText'] = $this->language->get('text_back_emptyText');
            
            $_labels['text_generating_pdf'] = $this->language->get('text_generating_pdf');
            $_labels['text_generating_report'] = $this->language->get('text_generating_report');
            $_labels['text_generate_report'] = $this->language->get('text_generate_report');
            $_labels['text_date_fieldset'] = $this->language->get('text_date_fieldset');            
            $_labels['text_products_fieldset'] = $this->language->get('text_products_fieldset');            
            $_labels['text_other_fieldset'] = $this->language->get('text_other_fieldset');
            $_labels['text_customize_fieldset'] = $this->language->get('text_customize_fieldset');            
            $_labels['customer_fieldset'] = $this->language->get('customer_fieldset');
            $_labels['account_fieldset'] = $this->language->get('account_fieldset'); 
            
            
            $_labels['text_select_item'] = $this->language->get('text_select_item');            
            $_labels['text_select_category'] = $this->language->get('text_select_category');            
            $_labels['text_units'] = $this->language->get('text_units');            
            $_labels['text_select_warehouse'] = $this->language->get('text_select_warehouse');
            $_labels['text_to_warehouse'] = $this->language->get('text_to_warehouse'); 
            
            $_labels['text_below_order_point'] = $this->language->get('text_below_order_point');            
            $_labels['text_below_zero'] = $this->language->get('text_below_zero');   
            $_labels['text_category_report'] = $this->language->get('text_category_report'); 
            $_labels['text_item_code'] = $this->language->get('text_item_code');            
            $_labels['text_enter_item_code'] = $this->language->get('text_enter_item_code');
            $_labels['text_customize_report'] = $this->language->get('text_customize_report');
            $_labels['text_show_in_coton'] = $this->language->get('text_show_in_coton');
            $_labels['text_yes'] = $this->language->get('text_yes');
            $_labels['text_no'] = $this->language->get('text_no');
            
            $_labels['text_select_customer'] = $this->language->get('text_select_customer');            
            $_labels['text_invoice_type'] = $this->language->get('text_invoice_type');   
            $_labels['text_all'] = $this->language->get('text_all'); 
            $_labels['text_sale_invoice'] = $this->language->get('text_sale_invoice');            
            $_labels['text_sale_return_invoice'] = $this->language->get('text_sale_return_invoice');
            $_labels['text_group_region'] = $this->language->get('text_group_region');
            $_labels['text_customer_type'] = $this->language->get('text_customer_type');
            $_labels['text_expenses'] = $this->language->get('text_expenses');
            $_labels['text_select_a_expense'] = $this->language->get('text_select_a_expense');
            $_labels['text_over_due_customer'] = $this->language->get('text_over_due_customer');
            $_labels['text_select_rep'] = $this->language->get('text_select_rep');
            $_labels['text_select_user'] = $this->language->get('text_select_user');
            $_labels['text_select_vendor'] = $this->language->get('text_select_vendor');
            
            $_labels['text_accounts'] = $this->language->get('text_accounts');
            $_labels['text_loan_report'] = $this->language->get('text_loan_report');
            $_labels['text_loan_payable'] = $this->language->get('text_loan_payable');
            $_labels['text_loan_receivable'] = $this->language->get('text_loan_receivable');
            $_labels['text_show_last_payment'] = $this->language->get('text_show_last_payment');
            $_labels['text_non_collected_customer'] = $this->language->get('text_non_collected_customer');
            $_labels['text_select_user'] = $this->language->get('text_select_user');
            $_labels['text_select_vendor'] = $this->language->get('text_select_vendor');
            
            
            
            $_labels['text_select_start_date'] = $this->language->get('text_select_start_date');
            $_labels['text_select_to_date'] = $this->language->get('text_select_to_date');
            //Report Heading
            $_labels['text_product'] = $this->language->get('text_product');
           
            
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
        public function price_levelpanel() { 
            $this->load->language('dashboard/pricelevel');
            $_labels = array();          
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
        public function settingspanel() { 
            $this->load->language('dashboard/settings');
            $_labels = array();          
            
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
      
        
        public function registerpanel() { 
            $this->load->language('dashboard/account');
            $_labels = array();          
            
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
        public function customertypepanel() { 
            $this->load->language('dashboard/customertype');
            $_labels = array();         
            $_labels['heading_title'] = $this->language->get('heading_title');            
            $_labels['button_new'] = $this->language->get('button_new');   
            $_labels['button_edit'] = $this->language->get('button_edit');
            $_labels['button_delete'] = $this->language->get('button_delete');
            $_labels['button_close'] = $this->language->get('button_close');            
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            
            $_labels['tooltip_new'] = $this->language->get('tooltip_new');   
            $_labels['tooltip_edit'] = $this->language->get('tooltip_edit');
            $_labels['tooltip_delete'] = $this->language->get('tooltip_delete');
            $_labels['tooltip_close'] = $this->language->get('tooltip_close');
            
            $_labels['text_yes'] = $this->language->get('text_yes');
            
            $_labels['text_name'] = $this->language->get('text_name');
            $_labels['text_search_type'] = $this->language->get('text_search_type');
            
            $_labels['text_creat_new'] = $this->language->get('text_creat_new');
            $_labels['text_eidt_new'] = $this->language->get('text_eidt_new');
            
            $_labels['col_type_code'] = $this->language->get('col_type_code');            
            $_labels['col_type_name'] = $this->language->get('col_type_name');
            $_labels['col_type_default'] = $this->language->get('col_type_default');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
        public function customergrouppanel() { 
            $this->load->language('dashboard/cgroup');
            $_labels = array();          
            $_labels['heading_title'] = $this->language->get('heading_title');            
            $_labels['button_new'] = $this->language->get('button_new');   
            $_labels['button_edit'] = $this->language->get('button_edit');
            $_labels['button_delete'] = $this->language->get('button_delete');
            $_labels['button_close'] = $this->language->get('button_close');            
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            
            $_labels['tooltip_new'] = $this->language->get('tooltip_new');   
            $_labels['tooltip_edit'] = $this->language->get('tooltip_edit');
            $_labels['tooltip_delete'] = $this->language->get('tooltip_delete');
            $_labels['tooltip_close'] = $this->language->get('tooltip_close');
            
            $_labels['text_yes'] = $this->language->get('text_yes');
            
            $_labels['text_name'] = $this->language->get('text_name');
            $_labels['text_search_group'] = $this->language->get('text_search_group');
            
            $_labels['text_creat_new'] = $this->language->get('text_creat_new');
            $_labels['text_eidt_new'] = $this->language->get('text_eidt_new');
            
            $_labels['col_group_code'] = $this->language->get('col_group_code');            
            $_labels['col_group_name'] = $this->language->get('col_group_name');
            $_labels['col_group_default'] = $this->language->get('col_group_default');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
         public function customerpanel() { 
            $this->load->language('dashboard/customer');
            $_labels = array();          
            
            $_labels['heading_title'] = $this->language->get('heading_title');            
            $_labels['button_new'] = $this->language->get('button_new');   
            $_labels['button_save'] = $this->language->get('button_save');   
            $_labels['button_copy'] = $this->language->get('button_copy');
            $_labels['button_deactivate'] = $this->language->get('button_deactivate');
            $_labels['button_activate'] = $this->language->get('button_activate');
            $_labels['button_close'] = $this->language->get('button_close');   
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            $_labels['label_current_balance'] = $this->language->get('label_current_balance');
            
            $_labels['text_search'] = $this->language->get('text_search');
            $_labels['field_label_basic'] = $this->language->get('field_label_basic');
            $_labels['field_label_contact'] = $this->language->get('field_label_contact');
            $_labels['field_label_address'] = $this->language->get('field_label_address');
            $_labels['field_label_purchaseinfo'] = $this->language->get('field_label_purchaseinfo');
            $_labels['field_label_additioninfo'] = $this->language->get('field_label_additioninfo');
            
            $_labels['label_cust_type'] = $this->language->get('label_cust_type');
            $_labels['label_cust_name'] = $this->language->get('label_cust_name');
            $_labels['label_cust_obalance'] = $this->language->get('label_cust_obalance');
            $_labels['label_cust_group'] = $this->language->get('label_cust_group');
            $_labels['label_cust_cont_name'] = $this->language->get('label_cust_cont_name');
            $_labels['label_cust_cont_phone'] = $this->language->get('label_cust_cont_phone');
            $_labels['label_cust_cont_mobile'] = $this->language->get('label_cust_cont_mobile');
            $_labels['label_cust_cont_fax'] = $this->language->get('label_cust_cont_fax');
            $_labels['label_cust_cont_email'] = $this->language->get('label_cust_cont_email');
            $_labels['label_cust_payment_term'] = $this->language->get('label_cust_payment_term');
            $_labels['label_cust_payment_discount'] = $this->language->get('label_cust_payment_discount');
            $_labels['label_cust_price_level'] = $this->language->get('label_cust_price_level');
            $_labels['label_cust_credit_limit'] = $this->language->get('label_cust_credit_limit');
            $_labels['label_cust_payment_term'] = $this->language->get('label_cust_payment_term');
            
            $_labels['col_cust_name'] = $this->language->get('col_cust_name');
            
            $_labels['tab_cust_info'] = $this->language->get('tab_cust_info');
            $_labels['tab_order_info'] = $this->language->get('tab_order_info');
            
            $_labels['col_order_no'] = $this->language->get('col_order_no');
            $_labels['col_order_date'] = $this->language->get('col_order_date');
           
            $_labels['col_order_status'] = $this->language->get('col_order_status');
            $_labels['col_order_total'] = $this->language->get('col_order_total');
            $_labels['col_order_paid'] = $this->language->get('col_order_paid');
            $_labels['col_order_balance'] = $this->language->get('col_order_balance');
            
            $_labels['tooltip_new'] = $this->language->get('tooltip_new');   
            $_labels['tooltip_save'] = $this->language->get('tooltip_save');
            $_labels['tooltip_copy'] = $this->language->get('tooltip_copy');
            $_labels['tooltip_deactivate'] = $this->language->get('tooltip_deactivate');
            $_labels['tooltip_activate'] = $this->language->get('tooltip_activate');
            $_labels['tooltip_close'] = $this->language->get('tooltip_close');
            
            $_labels['msg_name_exists'] = $this->language->get('msg_name_exists');
            $_labels['msg_error'] = $this->language->get('msg_error');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        public function customergrid() { 
            $this->load->language('dashboard/customer');
            $_labels = array();          
            
            $_labels['heading_title_list'] = $this->language->get('heading_title_list'); 
            $_labels['label_cust_name'] = $this->language->get('label_cust_name');
            $_labels['label_contact'] = $this->language->get('field_label_contact');
            $_labels['label_cust_cont_mobile'] = $this->language->get('label_cust_cont_mobile');
            
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            
            $_labels['col_cust_name'] = $this->language->get('col_cust_name');
            $_labels['col_cust_status'] = $this->language->get('col_cust_status');
            $_labels['col_cust_contact'] = $this->language->get('col_cust_contact');
            $_labels['col_cust_region'] = $this->language->get('col_cust_region');
            $_labels['col_cust_mobile'] = $this->language->get('col_cust_mobile');
            $_labels['col_cust_phone'] = $this->language->get('col_cust_phone');
            $_labels['col_cust_email'] = $this->language->get('col_cust_email');
            $_labels['col_cust_fax'] = $this->language->get('col_cust_fax');
            $_labels['col_cust_address'] = $this->language->get('col_cust_address');
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
        public function batchsalespanel() { 
            $this->load->language('dashboard/so');
            $_labels = array();   
            
            $_labels['heading_batch'] = $this->language->get('heading_batch'); 
            $_labels['button_close'] = $this->language->get('button_close');   
            $_labels['button_start_printing'] = $this->language->get('button_start_printing');   
            $_labels['button_print_list'] = $this->language->get('button_print_list');
            $_labels['button_search'] = $this->language->get('button_search');
            
            $_labels['label_customer'] = $this->language->get('label_customer');
            $_labels['label_customer_type'] = $this->language->get('label_customer_type');
            $_labels['label_group'] = $this->language->get('label_group');
            
            $_labels['col_order_no'] = $this->language->get('col_order_no');
            $_labels['col_order_date'] = $this->language->get('col_order_date');
            $_labels['col_customer'] = $this->language->get('col_customer');
            $_labels['col_due_date'] = $this->language->get('col_due_date');
            $_labels['col_total'] = $this->language->get('col_total');
            
            $_labels['tooltip_start_printing'] = $this->language->get('tooltip_start_printing');
            $_labels['tooltip_print_list'] = $this->language->get('tooltip_print_list');
            $_labels['tooltip_close_batch'] = $this->language->get('tooltip_close_batch');
            $_labels['msg_loading_batch'] = $this->language->get('msg_loading_batch');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        public function salesreturnpanel() { 
            $this->load->language('dashboard/salereturn');
            $_labels = array();   
            
            $_labels['heading'] = $this->language->get('heading'); 
            $_labels['button_close'] = $this->language->get('button_close');               
            $_labels['button_search'] = $this->language->get('button_search');
            
            $_labels['label_customer'] = $this->language->get('label_customer');
            $_labels['label_customer_type'] = $this->language->get('label_customer_type');
            $_labels['label_group'] = $this->language->get('label_group');
            
            $_labels['col_order_no'] = $this->language->get('col_order_no');
            $_labels['col_order_date'] = $this->language->get('col_order_date');
            $_labels['col_customer'] = $this->language->get('col_customer');
            $_labels['col_due_date'] = $this->language->get('col_due_date');
            $_labels['col_total'] = $this->language->get('col_total');
            $_labels['col_return'] = $this->language->get('col_return');
                        
            $_labels['tooltip_close_batch'] = $this->language->get('tooltip_close');
            $_labels['msg_loading_batch'] = $this->language->get('msg_loading_batch');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        
        public function saleinvoicepanel() { 
            $this->load->language('dashboard/so');
            $this->load->language('dashboard/stock_transfer');
            $this->load->language('common/print');
            $_labels = array();
            
            $_labels['text_transfer_title'] = $this->language->get('text_transfer_title');
            $_labels['heading_title_0'] = $this->language->get('heading_title_0');
            $_labels['heading_title_1'] = $this->language->get('heading_title_1');
            $_labels['heading_title_2'] = $this->language->get('heading_title_2');
            $_labels['s_invoice'] = $this->language->get('s_invoice');
            $_labels['sr_invoice'] = $this->language->get('sr_invoice');
            $_labels['sr_invoiceno'] = $this->language->get('sr_invoiceno');
            $_labels['s_invoiceno'] = $this->language->get('s_invoiceno');
            $_labels['button_new'] = $this->language->get('button_new'); 
            $_labels['button_create_sale_invoice'] = $this->language->get('button_create_sale_invoice'); 
            $_labels['button_print'] = $this->language->get('button_print');                          
            $_labels['button_save'] = $this->language->get('button_save');            
            $_labels['button_delete'] = $this->language->get('button_delete'); 
            $_labels['button_invCust'] = $this->language->get('button_invCust');
            $_labels['button_invCust_text'] = $this->language->get('button_invCust_text');
            $_labels['button_copy'] = $this->language->get('button_copy');   
            $_labels['button_close'] = $this->language->get('button_close');  
            $_labels['button_reopen'] = $this->language->get('button_reopen');  
            $_labels['button_next'] = $this->language->get('button_next');  
            $_labels['button_previous'] = $this->language->get('button_previous');  
            $_labels['button_save_print'] = $this->language->get('button_save_print'); 
            $_labels['button_save_new'] = $this->language->get('button_save_new');  
            $_labels['button_load_estimate'] = $this->language->get('button_load_estimate');
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            $_labels['msg_loading'] = $this->language->get('msg_loading');
            $_labels['msg_send_sms'] = $this->language->get('msg_send_sms');
            $_labels['msg_saving'] = $this->language->get('msg_saving');
            $_labels['text_status'] = $this->language->get('text_status');            
            $_labels['text_empty_region'] = $this->language->get('text_empty_region');  
            $_labels['text_empty_customer'] = $this->language->get('text_empty_customer'); 
            $_labels['text_empty_mobile'] = $this->language->get('text_empty_mobile'); 
            $_labels['text_empty_contact'] = $this->language->get('text_empty_contact'); 
            $_labels['text_empty_mobile_rep'] = $this->language->get('text_empty_mobile_rep'); 
            $_labels['text_add_new_customer'] = $this->language->get('text_add_new_customer'); 
            $_labels['text_all'] = $this->language->get('text_all'); 
            $_labels['text_customer'] = $this->language->get('text_customer');
            $_labels['text_contact'] = $this->language->get('text_contact');
            $_labels['text_mobile'] = $this->language->get('text_mobile');
            $_labels['text_cust_address'] = $this->language->get('text_address');
            $_labels['text_warehouse'] = $this->language->get('text_warehouse');
            $_labels['button_add_item'] = $this->language->get('button_add_item');
            $_labels['button_create_item'] = $this->language->get('button_create_item');
            $_labels['button_delete_item'] = $this->language->get('button_delete_item');
            $_labels['button_delete_item_all'] = $this->language->get('button_delete_item_all');
            $_labels['button_auto_fill'] = $this->language->get('button_auto_fill');
            $_labels['button_complete'] = $this->language->get('button_complete');
            $_labels['button_cancel'] = $this->language->get('button_cancel');
            $_labels['button_save'] = $this->language->get('button_save');
            $_labels['button_add'] = $this->language->get('button_add');
            $_labels['text_order_no'] = $this->language->get('text_order_no');
            $_labels['text_order_no_text'] = $this->language->get('text_order_no_text');
             $_labels['text_order_customer'] = $this->language->get('col_order_customer');
            $_labels['text_date'] = $this->language->get('text_date');            
            $_labels['text_due_date'] = $this->language->get('text_due_date');
            $_labels['text_rep'] = $this->language->get('text_rep');
            $_labels['col_item'] = $this->language->get('col_item');
            $_labels['col_quantity'] = $this->language->get('col_quantity');
            $_labels['col_item_uom'] = $this->language->get('col_item_uom');
            $_labels['col_unit_price'] = $this->language->get('col_unit_price');
            $_labels['col_net_price'] = $this->language->get('col_net_price');
            $_labels['col_sale_price'] = $this->language->get('col_sale_price');
            $_labels['col_weight'] = $this->language->get('col_weight');
            $_labels['col_discount'] = $this->language->get('col_discount');            
            $_labels['col_deduction'] = $this->language->get('col_deduction'); 
            $_labels['default_location'] = $this->language->get('default_location'); 
            $_labels['col_sub_total'] = $this->language->get('col_sub_total');
            
            $_labels['total_items'] = $this->language->get('total_items');
            $_labels['total_quantities'] = $this->language->get('total_quantities');            
            $_labels['total_unit_amount'] = $this->language->get('total_unit_amount');            
            $_labels['total_item_discount'] = $this->language->get('total_item_discount');
            
            $_labels['item_purchase_cost'] = $this->language->get('item_purchase_cost');
            $_labels['item_avg_cost'] = $this->language->get('item_avg_cost');            
            $_labels['qty_on_hand'] = $this->language->get('qty_on_hand');            
            $_labels['item_barcode'] = $this->language->get('item_barcode');
            $_labels['item_info'] = $this->language->get('item_info');
            $_labels['invoice_info'] = $this->language->get('invoice_info');
            $_labels['col_location'] = $this->language->get('col_location');
            $_labels['col_dated_picked'] = $this->language->get('col_dated_picked');
            $_labels['col_picked'] = $this->language->get('col_picked');
            
            
            $_labels['reg_date'] = $this->language->get('reg_date');
            $_labels['reg_number'] = $this->language->get('reg_number');
            $_labels['reg_account'] = $this->language->get('reg_account');
            $_labels['reg_amt_paid'] = $this->language->get('reg_amt_paid');
            $_labels['reg_amt_charge'] = $this->language->get('reg_amt_charge');
            $_labels['reg_balance'] = $this->language->get('reg_balance');
            $_labels['select_item_emptyText'] = $this->language->get('select_item_emptyText');
            $_labels['inv_purchase_cost'] = $this->language->get('inv_purchase_cost');
            $_labels['inv_sale_price'] = $this->language->get('inv_sale_price');
            $_labels['inv_discount'] = $this->language->get('inv_discount');
            $_labels['inv_total_sale'] = $this->language->get('inv_total_sale');
            $_labels['inv_profit'] = $this->language->get('inv_profit');
            $_labels['inv_base_unit'] = $this->language->get('inv_base_unit');
            
            $_labels['text_sub_total'] = $this->language->get('text_sub_total');
            $_labels['text_total'] = $this->language->get('text_total');
            $_labels['text_cancel_order'] = $this->language->get('text_cancel_order');
            $_labels['text_invoice_discount'] = $this->language->get('text_invoice_discount');   
            $_labels['text_invoice_deduction'] = $this->language->get('text_invoice_deduction');   
            $_labels['text_allow_invoice'] = $this->language->get('text_allow_invoice');
            
            $_labels['button_new_tooltip'] = $this->language->get('button_new_tooltip');
            $_labels['button_print_tooltip'] = $this->language->get('button_print_tooltip');
            $_labels['button_save_tooltip'] = $this->language->get('button_save_tooltip');
            $_labels['button_saveandnew_tooltip'] = $this->language->get('button_saveandnew_tooltip');
            $_labels['button_label_print_tooltip'] = $this->language->get('button_label_print_tooltip');
            $_labels['button_load_estimates_tooltip'] = $this->language->get('button_load_estimates_tooltip');
            $_labels['button_save_print_tooltip'] = $this->language->get('button_save_print_tooltip');
            $_labels['button_delete_tooltip'] = $this->language->get('button_delete_tooltip');
            $_labels['button_close_tooltip'] = $this->language->get('button_close_tooltip');
            $_labels['button_next_tooltip'] = $this->language->get('button_next_tooltip');
            $_labels['button_previous_tooltip'] = $this->language->get('button_previous_tooltip');
            $_labels['button_copy_tooltip'] = $this->language->get('button_copy_tooltip');
            
            $_labels['text_paid'] = $this->language->get('text_paid');
            $_labels['text_unpaid'] = $this->language->get('text_unpaid');
            $_labels['text_partial'] = $this->language->get('text_partial');
            $_labels['text_balance'] = $this->language->get('text_balance');
            $_labels['text_pre_balance'] = $this->language->get('text_pre_balance');
            $_labels['text_grand_total'] = $this->language->get('text_grand_total');
            
            $_labels['text_batch_printing'] = $this->language->get('text_batch_printing');
            $_labels['text_email'] = $this->language->get('text_email');
            $_labels['text_gatepass'] = $this->language->get('text_gatepass');
            $_labels['text_showregister'] = $this->language->get('text_showregister');
            $_labels['text_prevbalance'] = $this->language->get('text_prevbalance');
            
            $_labels['text_remarks'] = $this->language->get('text_remarks');
            
            $_labels['tab_sale'] = $this->language->get('tab_sale');
            $_labels['tab_pick'] = $this->language->get('tab_pick');
            $_labels['tab_invoice'] = $this->language->get('tab_invoice');
            
            $_labels['text_ordered_quantity'] = $this->language->get('text_ordered_quantity');
            $_labels['text_picked_quantity'] = $this->language->get('text_picked_quantity');
            
            $_labels['text_invoice'] = $this->language->get('text_invoice');
            $_labels['text_bill_to'] = $this->language->get('text_bill_to');
            $_labels['text_invoice_no'] = $this->language->get('text_invoice_no');            
            $_labels['text_cust_mobile'] = $this->language->get('text_mobile');
            $_labels['text_cust_address'] = $this->language->get('text_cust_address');
            $_labels['text_rs'] = $this->language->get('text_rs');
            
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));
            
    }
        public function ordergrid() { 
            $this->load->language('dashboard/order_list');
            $_labels = array();          
            $_labels['heading_title'] = $this->language->get('heading_title');
            $_labels['text_order'] = $this->language->get('text_order');
            $_labels['text_status'] = $this->language->get('text_status');
            $_labels['text_customer'] = $this->language->get('text_customer');
            $_labels['text_orderDate'] = $this->language->get('text_orderDate');
            $_labels['text_dueDate'] = $this->language->get('text_dueDate');
            $_labels['text_total'] = $this->language->get('text_total');
            $_labels['text_paid'] = $this->language->get('text_paid');
            $_labels['text_balance'] = $this->language->get('text_balance');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function warehousespanel() { 
            $this->load->language('dashboard/warehouses');
            $_labels = array();          
            $_labels['warehouse_head'] = $this->language->get('warehouse_head');
         $_labels['warehouse_search'] = $this->language->get('warehouse_search');
         $_labels['text_warehouse_name'] = $this->language->get('text_warehouse_name');
         $_labels['text_search'] = $this->language->get('text_search');
         $_labels['text_deactive'] = $this->language->get('text_deactive');
         $_labels['text_active'] = $this->language->get('text_active');
         $_labels['show_all'] = $this->language->get('show_all');
         $_labels['text_new'] = $this->language->get('text_new');
         $_labels['text_close'] = $this->language->get('text_close');
         $_labels['text_edit'] = $this->language->get('text_edit');
         $_labels['warehouse_code'] = $this->language->get('warehouse_code');
         $_labels['text_status'] = $this->language->get('text_status');
         $_labels['text_default'] = $this->language->get('text_default');
         $_labels['text_new_info'] = $this->language->get('text_new_info');
         $_labels['text_close_info'] = $this->language->get('text_close_info');
         $_labels['text_edit_info'] = $this->language->get('text_edit_info');
         $_labels['text_deactive_info'] = $this->language->get('text_deactive_info');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function expensespanel() { 
            $this->load->language('dashboard/expense');
            $_labels = array();          
            $_labels['text_expense'] = $this->language->get('text_expense');
            $_labels['text_new'] = $this->language->get('text_new');
            $_labels['text_new_tooltip'] = $this->language->get('text_new_tooltip');
            $_labels['text_close'] = $this->language->get('text_close');
            $_labels['text_close_info'] = $this->language->get('text_close_info');
            $_labels['text_edit'] = $this->language->get('text_edit');
            $_labels['text_edit_tooltip'] = $this->language->get('text_edit_tooltip');
            $_labels['text_edit_model'] = $this->language->get('text_edit_model');
            $_labels['text_active'] = $this->language->get('text_active');
            $_labels['text_deactive'] = $this->language->get('text_deactive');
            $_labels['text_deactive_detail'] = $this->language->get('text_deactive_detail');
            $_labels['text_status'] = $this->language->get('text_status');
            $_labels['text_search_expense'] = $this->language->get('text_search_expense');
            $_labels['show_all'] = $this->language->get('show_all');
            $_labels['text_search'] = $this->language->get('text_search');
            $_labels['text_name'] = $this->language->get('text_name');
            $_labels['text_description'] = $this->language->get('text_description');
            $_labels['text_expstatus'] = $this->language->get('text_expstatus');
            $_labels['text_new_expense'] = $this->language->get('text_new_expense');
            $_labels['text_expense_name'] = $this->language->get('text_expense_name');
            $_labels['text_name_placeholder'] = $this->language->get('text_name_placeholder');
            $_labels['labels_json.expensespanel.text_deactive'] = $this->language->get('labels_json.expensespanel.text_deactive');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function itempanel() { 
            $this->load->language('dashboard/item');
            $_labels = array();   
            
            $_labels['text_title'] = $this->language->get('text_title'); 
            $_labels['manage_cat'] = $this->language->get('manage_cat'); 
            $_labels['text_close'] = $this->language->get('text_close'); 
            $_labels['text_close_info'] = $this->language->get('text_close_info'); 
            $_labels['text_deactive'] = $this->language->get('text_deactive'); 
            $_labels['text_deactive_info'] = $this->language->get('text_deactive_info'); 
            $_labels['text_active'] = $this->language->get('text_active'); 
            $_labels['text_active_info'] = $this->language->get('text_active_info'); 
            $_labels['text_error'] = $this->language->get('text_error'); 
            $_labels['text_error_info'] = $this->language->get('text_error_info'); 
            $_labels['text_copy'] = $this->language->get('text_copy'); 
            $_labels['text_copy_info'] = $this->language->get('text_copy_info'); 
            $_labels['text_print_lbl'] = $this->language->get('text_print_lbl'); 
            $_labels['text_print_lbl_info'] = $this->language->get('text_print_lbl_info'); 
            $_labels['text_saveandnew'] = $this->language->get('text_saveandnew'); 
            $_labels['text_saveandnew_info'] = $this->language->get('text_saveandnew_info'); 
            $_labels['text_user_access'] = $this->language->get('text_user_access'); 
            $_labels['text_save'] = $this->language->get('text_save'); 
            $_labels['text_save_info'] = $this->language->get('text_save_info'); 
            $_labels['text_user_access_info'] = $this->language->get('text_user_access_info'); 
            $_labels['text_new'] = $this->language->get('text_new'); 
            $_labels['text_new_info'] = $this->language->get('text_new_info'); 
            $_labels['text_new_cat'] = $this->language->get('text_new_cat'); 
            $_labels['text_categories'] = $this->language->get('text_categories'); 
            $_labels['text_delete'] = $this->language->get('text_delete'); 
            $_labels['text_catname'] = $this->language->get('text_catname'); 
            $_labels['text_catdesc'] = $this->language->get('text_catdesc'); 
            $_labels['text_cancel'] = $this->language->get('text_cancel'); 
            $_labels['text_style'] = $this->language->get('text_style'); 
            $_labels['text_this'] = $this->language->get('text_this'); 
            $_labels['text_already'] = $this->language->get('text_already'); 
            $_labels['text_confirm'] = $this->language->get('text_confirm'); 
            $_labels['text_confirm_info'] = $this->language->get('text_confirm_info'); 
            $_labels['heading_title'] = $this->language->get('heading_title'); 
            $_labels['text_basic'] = $this->language->get('text_basic');   
            $_labels['text_type'] = $this->language->get('text_type');   
            $_labels['text_name'] = $this->language->get('text_name');   
            $_labels['extra_info'] = $this->language->get('extra_info');   
            $_labels['unit_placeholder'] = $this->language->get('unit_placeholder');   
            $_labels['basic_uom'] = $this->language->get('basic_uom');   
            $_labels['text_upc'] = $this->language->get('text_upc');   
            $_labels['text_lookup'] = $this->language->get('text_lookup');   
            $_labels['text_altlookup'] = $this->language->get('text_altlookup');   
            $_labels['text_removlookup'] = $this->language->get('text_removlookup');   
            $_labels['text_uomqty'] = $this->language->get('text_uomqty');   
            $_labels['text_uomsale'] = $this->language->get('text_uomsale');   
            $_labels['text_uomavg'] = $this->language->get('text_uomavg');   
            $_labels['text_uom1'] = $this->language->get('text_uom1');   
            $_labels['text_uom2'] = $this->language->get('text_uom2');   
            $_labels['text_uom3'] = $this->language->get('text_uom3');   
            $_labels['text_conv1'] = $this->language->get('text_conv1');   
            $_labels['text_conv2'] = $this->language->get('text_conv2');   
            $_labels['text_conv3'] = $this->language->get('text_conv3');   
            $_labels['text_reset'] = $this->language->get('text_reset');   
            $_labels['orderandsale'] = $this->language->get('orderandsale');   
            $_labels['text_saleunit'] = $this->language->get('text_saleunit');   
            $_labels['text_purchaseunit'] = $this->language->get('text_purchaseunit');   
            $_labels['text_reset_info'] = $this->language->get('text_reset_info');   
            $_labels['text_new_barcode'] = $this->language->get('text_new_barcode');   
            $_labels['text_name_placeholder'] = $this->language->get('text_name_placeholder');   
            $_labels['text_avgcost'] = $this->language->get('text_avgcost');   
            $_labels['text_cogsinfo'] = $this->language->get('text_cogsinfo');   
            $_labels['text_accountinfo'] = $this->language->get('text_accountinfo');   
            $_labels['text_assetinfo'] = $this->language->get('text_assetinfo');   
            $_labels['text_warehouse'] = $this->language->get('text_warehouse');   
            $_labels['text_warehouse_reorder'] = $this->language->get('text_warehouse_reorder');   
            $_labels['text_reoder_qty'] = $this->language->get('text_reoder_qty');   
            $_labels['text_name_info'] = $this->language->get('text_name_info');   
            $_labels['text_category'] = $this->language->get('text_category');   
            $_labels['text_category_info'] = $this->language->get('text_category_info');   
            // $_labels['text_name'] = $this->language->get('text_name');   
            $_labels['text_description'] = $this->language->get('text_description');   
            $_labels['text_inventory'] = $this->language->get('text_inventory');   
            $_labels['text_part_no'] = $this->language->get('text_part_no');   
            $_labels['text_qty_on_hand'] = $this->language->get('text_qty_on_hand');   
            $_labels['text_bar_code'] = $this->language->get('text_bar_code');   
            $_labels['text_generate'] = $this->language->get('text_generate');   
            $_labels['text_purchase_info'] = $this->language->get('text_purchase_info');   
            $_labels['text_purchase_price'] = $this->language->get('text_purchase_price');   
            $_labels['text_cogs_account'] = $this->language->get('text_cogs_account');   
            $_labels['text_sales_info'] = $this->language->get('text_sales_info');   
            $_labels['text_sales_price'] = $this->language->get('text_sales_price');   
            $_labels['text_income_account'] = $this->language->get('text_income_account');   
            $_labels['text_picture'] = $this->language->get('text_picture');   
            $_labels['text_upload_picture'] = $this->language->get('text_upload_picture');   
            $_labels['text_inventory_info'] = $this->language->get('text_inventory_info');   
            $_labels['text_asset_account'] = $this->language->get('text_asset_account');   
            $_labels['text_storage_info'] = $this->language->get('text_storage_info');   
            $_labels['text_reorder_point'] = $this->language->get('text_reorder_point');   
            $_labels['text_measurement'] = $this->language->get('text_measurement');   
            $_labels['text_unit'] = $this->language->get('text_unit');   
            $_labels['text_custom_field'] = $this->language->get('text_custom_field');   
            $_labels['text_color'] = $this->language->get('text_color');   
            $_labels['text_size'] = $this->language->get('text_size');   
            $_labels['text_style'] = $this->language->get('text_style');   
            $_labels['text_brand'] = $this->language->get('text_brand');   
            $_labels['text_weight'] = $this->language->get('text_weight');   
            $_labels['text_tab_info'] = $this->language->get('text_tab_info');  
            $_labels['text_tab_order'] = $this->language->get('text_tab_order');
            
            $_labels['col_item_type'] = $this->language->get('col_item_type');  
            $_labels['col_item_order'] = $this->language->get('col_item_order');  
            $_labels['col_item_odate'] = $this->language->get('col_item_odate');  
            $_labels['col_item_ostatus'] = $this->language->get('col_item_ostatus');  
            $_labels['col_item_total'] = $this->language->get('col_item_total');  
            $_labels['col_item_quantity'] = $this->language->get('col_item_quantity');  
            $_labels['col_item_uprice'] = $this->language->get('col_item_uprice');  
            $_labels['col_item_stotal'] = $this->language->get('col_item_stotal');  
            
            $_labels['col_item_category'] = $this->language->get('col_item_category');  
            $_labels['col_item_item'] = $this->language->get('col_item_item');  
                        
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        public function itemgrid() { 
            $this->load->language('dashboard/item');
            $_labels = array();          
             $_labels['product_list'] = $this->language->get('product_list');
             $_labels['product_list_name'] = $this->language->get('product_list_name');
             $_labels['text_description'] = $this->language->get('text_description');
             $_labels['text_category'] = $this->language->get('text_category');
             $_labels['text_status'] = $this->language->get('text_status');
             $_labels['heading_title'] = $this->language->get('heading_title');
             $_labels['text_normal'] = $this->language->get('text_normal');
             $_labels['text_sale'] = $this->language->get('text_sale');
             $_labels['show_all'] = $this->language->get('show_all');
             $_labels['text_search'] = $this->language->get('text_search');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function purchaseinvoicepanel() { 
            $this->load->language('dashboard/po');
            $_labels = array();  
            
            $_labels['heading_title_0'] = $this->language->get('heading_title_0'); 
            $_labels['heading_title_1'] = $this->language->get('heading_title_1'); 
            $_labels['purchase'] = $this->language->get('purchase'); 
            $_labels['purchase_return'] = $this->language->get('purchase_return'); 
            $_labels['purchase_invoice'] = $this->language->get('purchase_invoice'); 
            $_labels['purchase_invoice_ret'] = $this->language->get('purchase_invoice_ret'); 
            $_labels['button_new'] = $this->language->get('button_new'); 
            $_labels['button_print'] = $this->language->get('button_print');                          
            $_labels['button_save'] = $this->language->get('button_save');
            $_labels['button_save_print'] = $this->language->get('button_save_print');
            $_labels['button_delete'] = $this->language->get('button_delete');   
            $_labels['button_copy'] = $this->language->get('button_copy');   
            $_labels['button_close'] = $this->language->get('button_close');  
            $_labels['button_reopen'] = $this->language->get('button_reopen');  
            $_labels['button_next'] = $this->language->get('button_next');  
            $_labels['button_previous'] = $this->language->get('button_previous');  
            $_labels['button_save_new'] = $this->language->get('button_save_new');
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            $_labels['button_label_print'] = $this->language->get('button_label_print');
            $_labels['text_status'] = $this->language->get('text_status');            
            
            
            $_labels['button_new_tooltip'] = $this->language->get('button_new_tooltip');
            $_labels['button_print_tooltip'] = $this->language->get('button_print_tooltip');
            $_labels['button_save_tooltip'] = $this->language->get('button_save_tooltip');
            $_labels['button_saveandnew_tooltip'] = $this->language->get('button_saveandnew_tooltip');
            $_labels['button_label_print_tooltip'] = $this->language->get('button_label_print_tooltip');
            $_labels['button_load_estimates_tooltip'] = $this->language->get('button_load_estimates_tooltip');
            $_labels['button_save_print_tooltip'] = $this->language->get('button_save_print_tooltip');
            $_labels['button_delete_tooltip'] = $this->language->get('button_delete_tooltip');
            $_labels['button_close_tooltip'] = $this->language->get('button_close_tooltip');
            $_labels['button_next_tooltip'] = $this->language->get('button_next_tooltip');
            $_labels['button_previous_tooltip'] = $this->language->get('button_previous_tooltip');
            $_labels['button_copy_tooltip'] = $this->language->get('button_copy_tooltip');
            $_labels['text_vendor_text'] = $this->language->get('text_vendor_text');
            $_labels['button_delete_item_all'] = $this->language->get('button_delete_item_all');
            $_labels['button_cancel'] = $this->language->get('button_cancel');
            $_labels['button_save'] = $this->language->get('button_save');
            $_labels['button_add'] = $this->language->get('button_add');
            $_labels['text_vendor'] = $this->language->get('text_vendor');            
            $_labels['text_p_o_no'] = $this->language->get('text_p_o_no');            
            $_labels['text_contact'] = $this->language->get('text_contact');            
            $_labels['text_mobile'] = $this->language->get('text_mobile');
            $_labels['text_warehouse'] = $this->language->get('text_warehouse');
            $_labels['button_add_item'] = $this->language->get('button_add_item');
            $_labels['button_add_items'] = $this->language->get('button_add_items');
            $_labels['button_create_item'] = $this->language->get('button_create_item');
            $_labels['button_delete_item'] = $this->language->get('button_delete_item');
            $_labels['button_auto_fill'] = $this->language->get('button_auto_fill');
            $_labels['button_complete'] = $this->language->get('button_complete');
            $_labels['select_item_emptyText'] = $this->language->get('select_item_emptyText');
            $_labels['text_order_no'] = $this->language->get('text_order_no');
            $_labels['text_order_no_text'] = $this->language->get('text_order_no_text');
            $_labels['text_date'] = $this->language->get('text_date');            
            $_labels['text_due_date'] = $this->language->get('text_due_date');
            $_labels['text_rep'] = $this->language->get('text_rep');
            $_labels['col_item'] = $this->language->get('col_item');
            $_labels['col_quantity'] = $this->language->get('col_quantity');
            $_labels['col_item_uom'] = $this->language->get('col_item_uom');
            $_labels['col_unit_price'] = $this->language->get('col_unit_price');
            $_labels['col_sale_price'] = $this->language->get('col_sale_price');
            $_labels['col_discount'] = $this->language->get('col_discount');            
            $_labels['col_deduction'] = $this->language->get('col_deduction'); 
            $_labels['default_location'] = $this->language->get('default_location');
            $_labels['col_sub_total'] = $this->language->get('col_sub_total');
            
            $_labels['col_location'] = $this->language->get('col_location');
            $_labels['col_dated_picked'] = $this->language->get('col_dated_picked');
            $_labels['col_picked'] = $this->language->get('col_picked');
            
            $_labels['text_sub_total'] = $this->language->get('text_sub_total');
            $_labels['text_sale_total'] = $this->language->get('text_sale_total');
            $_labels['text_total'] = $this->language->get('text_total');
            $_labels['text_cancel_order'] = $this->language->get('text_cancel_order');
            $_labels['text_allow_invoice'] = $this->language->get('text_allow_invoice');
            
            $_labels['purchase_list_paid'] = $this->language->get('purchase_list_paid');
            $_labels['purchase_list_balance'] = $this->language->get('purchase_list_balance');
            
            $_labels['text_batch_printing'] = $this->language->get('text_batch_printing');
            $_labels['text_email'] = $this->language->get('text_email');
            
            $_labels['text_remarks'] = $this->language->get('text_remarks');
            
            $_labels['tab_purchase'] = $this->language->get('tab_purchase');
            $_labels['tab_receive'] = $this->language->get('tab_receive');
            $_labels['tab_expense'] = $this->language->get('tab_expense');
            $_labels['tab_payment'] = $this->language->get('tab_payment');
            
            $_labels['text_ordered_quantity'] = $this->language->get('text_ordered_quantity');
            $_labels['text_total_item'] = $this->language->get('text_total_item');
            $_labels['text_total_qty'] = $this->language->get('text_total_qty');
            $_labels['text_total_base_qty'] = $this->language->get('text_total_base_qty');
            $_labels['text_total_unitprice'] = $this->language->get('text_total_unitprice');
            $_labels['text_total_discount'] = $this->language->get('text_total_discount');
            $_labels['text_received_quantity'] = $this->language->get('text_received_quantity');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function purchasegrid() { 
            $this->load->language('dashboard/po');
            $_labels = array();          
            $_labels['purchase_list'] = $this->language->get('purchase_list');
            $_labels['purchase_order'] = $this->language->get('purchase_order');
            $_labels['purchase_list_status'] = $this->language->get('purchase_list_status');
            $_labels['purchase_list_vendor'] = $this->language->get('purchase_list_vendor');
            $_labels['purchase_list_search'] = $this->language->get('purchase_list_search');
            $_labels['purchase_list_showall'] = $this->language->get('purchase_list_showall');
            $_labels['text_due_date'] = $this->language->get('text_due_date');
            $_labels['text_total'] = $this->language->get('text_total');
            $_labels['purchase_list_paid'] = $this->language->get('purchase_list_paid');
            $_labels['purchase_list_balance'] = $this->language->get('purchase_list_balance');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function vendorpanel() { 
            $this->load->language('dashboard/vendor');
            $_labels = array();          
            $_labels['text_vendor'] = $this->language->get('text_vendor');
            $_labels['text_new'] = $this->language->get('text_new');
            $_labels['text_close'] = $this->language->get('text_close');
            $_labels['text_deactive'] = $this->language->get('text_deactive');
            $_labels['text_active'] = $this->language->get('text_active');
            $_labels['text_save'] = $this->language->get('text_save');
            $_labels['text_save_info'] = $this->language->get('text_save_info');
            $_labels['text_save_new'] = $this->language->get('text_save_new');
            $_labels['text_save_new_info'] = $this->language->get('text_save_new_info');
            $_labels['text_current_balance'] = $this->language->get('text_current_balance');
            $_labels['text_copy'] = $this->language->get('text_copy');
            $_labels['text_search'] = $this->language->get('text_search');
            $_labels['text_vendor_info'] = $this->language->get('text_vendor_info');
            $_labels['text_order_history'] = $this->language->get('text_order_history');
            $_labels['text_basic'] = $this->language->get('text_basic');
            $_labels['text_opening_balance'] = $this->language->get('text_opening_balance');
            $_labels['text_vendor_name'] = $this->language->get('text_vendor_name');
            $_labels['text_contact'] = $this->language->get('text_contact');
            $_labels['text_phone'] = $this->language->get('text_phone');
            $_labels['text_mobile'] = $this->language->get('text_mobile');
            $_labels['text_fax'] = $this->language->get('text_fax');
            $_labels['text_email'] = $this->language->get('text_email');
            $_labels['text_address'] = $this->language->get('text_address');
            $_labels['text_purchase_info'] = $this->language->get('text_purchase_info');
            $_labels['show_all'] = $this->language->get('show_all');
            $_labels['text_term'] = $this->language->get('text_term');
            $_labels['text_order_no'] = $this->language->get('text_order_no');
            $_labels['text_order_no_text'] = $this->language->get('text_order_no_text');
            $_labels['text_order_date'] = $this->language->get('text_order_date');
            $_labels['text_order_status'] = $this->language->get('text_order_status');
            $_labels['text_order_total'] = $this->language->get('text_order_total');
            $_labels['text_amountpaid'] = $this->language->get('text_amountpaid');
            $_labels['text_balancedue'] = $this->language->get('text_balancedue');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        public function vendorgrid() { 
            $this->load->language('dashboard/vendor');
            $_labels = array();          
            $_labels['vendor_list_head'] = $this->language->get('vendor_list_head');
            $_labels['text_vendor_name'] = $this->language->get('text_vendor_name');
             $_labels['text_mobile'] = $this->language->get('text_mobile');
              $_labels['text_phone'] = $this->language->get('text_phone');
             $_labels['text_contact'] = $this->language->get('text_contact');
             $_labels['show_all'] = $this->language->get('show_all');
             $_labels['text_search'] = $this->language->get('text_search');
             $_labels['vendor_status'] = $this->language->get('vendor_status');
             $_labels['text_email'] = $this->language->get('text_email');
             $_labels['text_fax'] = $this->language->get('text_fax');
             $_labels['vendor_address'] = $this->language->get('vendor_address');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
         public function stockadjustpanel() {  
         $this->load->language('dashboard/adjust_stock');           
            $_labels = array();          
             $_labels['text_heading'] = $this->language->get('text_heading');
             $_labels['text_new'] = $this->language->get('text_new');
             $_labels['text_close'] = $this->language->get('text_close');
             $_labels['text_close_info'] = $this->language->get('text_close_info');
             $_labels['text_new_info'] = $this->language->get('text_new_info');
             $_labels['adjustement_date'] = $this->language->get('adjustement_date');
             $_labels['refno'] = $this->language->get('refno');
             $_labels['memos'] = $this->language->get('memos');
             $_labels['select_category'] = $this->language->get('select_category');
             $_labels['select_warehouse'] = $this->language->get('select_warehouse');
             $_labels['text_adjust'] = $this->language->get('text_adjust');
             $_labels['text_prev'] = $this->language->get('text_prev');
             $_labels['text_prev_info'] = $this->language->get('text_prev_info');
             $_labels['text_next'] = $this->language->get('text_next');
             $_labels['text_next_info'] = $this->language->get('text_next_info');
             $_labels['text_search'] = $this->language->get('text_search');
             $_labels['text_item'] = $this->language->get('text_item');
             $_labels['text_category'] = $this->language->get('text_category');
             $_labels['text_purchase_price'] = $this->language->get('text_purchase_price');
             $_labels['text_sales_price'] = $this->language->get('text_sales_price');
             $_labels['text_uom'] = $this->language->get('text_uom');
             $_labels['text_current_qty'] = $this->language->get('text_current_qty');
             $_labels['text_new_qty'] = $this->language->get('text_new_qty');
             $_labels['text_diff_qty'] = $this->language->get('text_diff_qty');
             $_labels['adjust_account'] = $this->language->get('adjust_account');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
    }
        
        public function salesreppanel(){
            $this->load->language('dashboard/salesrep');
            $_labels = array();          
            $_labels['heading_title'] = $this->language->get('heading_title'); 
            $_labels['button_new'] = $this->language->get('button_new');   
            $_labels['button_edit'] = $this->language->get('button_edit');
            $_labels['button_deactivate'] = $this->language->get('button_deactivate');
            $_labels['button_close'] = $this->language->get('button_close');            
            $_labels['button_search'] = $this->language->get('button_search');
            $_labels['button_show_all'] = $this->language->get('button_show_all');
            
            $_labels['tooltip_new'] = $this->language->get('tooltip_new');   
            $_labels['tooltip_edit'] = $this->language->get('tooltip_edit');
            $_labels['tooltip_deactivate'] = $this->language->get('tooltip_deactivate');
            $_labels['tooltip_close'] = $this->language->get('tooltip_close');                       
            
            $_labels['fieldlabel_salesrep'] = $this->language->get('fieldlabel_salesrep');
            $_labels['label_salesrep_name'] = $this->language->get('label_salesrep_name');
            
            $_labels['col_name'] = $this->language->get('col_name');
            $_labels['col_phone'] = $this->language->get('col_phone');
            $_labels['col_mobile'] = $this->language->get('col_mobile');
            $_labels['col_address'] = $this->language->get('col_address');
            $_labels['col_active'] = $this->language->get('col_active');
            
            $_labels['label_createrep'] = $this->language->get('label_createrep');
            $_labels['label_editrep'] = $this->language->get('label_editrep');
            $_labels['text_yes'] = $this->language->get('text_yes');
            
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
        }
        public function journalpanel() { 
             $this->load->language('common/journal');
            $_labels = array();          
            $_labels['heading_title'] = $this->language->get('heading_title');
            $this->load->library('json');
            $this->response->setOutput(Json::encode($_labels), $this->config->get('config_compression'));            
        }

        
       
}
?>