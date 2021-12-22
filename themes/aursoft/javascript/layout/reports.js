({
    id: 'reports-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.reportspanel.heading_title,
    listeners:{
        beforeclose:function(){
           homePage();
        },
        beforerender:function(){     
          item_store.load();
          cat_store.load();
          warehouse_store.load();
          customer_store.load(); 
          expense_store.load();
          vendor_store.load();
          reports_obj = {
                 isLoaded:false,
                 params:null,
                 unMask : function(){
                 var cpanel = Ext.getCmp("reports_body").getEl();
                 cpanel.unmask();
                },
                maskMe:function(msg){
                    var cpanel = Ext.getCmp("reports_body").getEl();
                    cpanel.mask(msg);
                },
                getDateMysqlFormatWithTime: function (objDate){                    
                    var currentdate =  objDate;
                    var cdate = "";
                    if(objDate){
                        var cdate = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+"-"+currentdate.getDate()+' '+currentdate.getHours()+':'+currentdate.getMinutes()+':'+currentdate.getSeconds();
                    }
                    return cdate;
                },
                reportReady:function(){
                    Ext.getCmp("report_print_btn").enable();
                    Ext.getCmp("report_export_btn").enable();
                    this.unMask();
                },
                reportReadyreturn:function(){
                    Ext.getCmp("back_button").enable();
                    this.unMask();
                },
                getSaleReport:function(){                    
                     Ext.get("report_frame").dom.contentWindow.generate_report(reports_obj.params);  
                     reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report); 
                     
                },
                generateAccountReport:function(){                    
                     Ext.getCmp("report_print_btn").disable();
                     Ext.getCmp("report_export_btn").disable();
                     Ext.getCmp("back_button").disable();
                     document.getElementById("report_frame").src=action_urls.get_account_reports;
                      if(reports_obj.select_id==41){
                        reports_obj.params = {
                            report_name : reports_obj.report_name,
                            report_id : reports_obj.select_id,
                            end_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_end_date").getValue()),
                         };                       
                        reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);
                      }                           
                     else if(reports_obj.select_id==54){
                        reports_obj.params = {
                            report_name : reports_obj.report_name,
                            report_id : reports_obj.select_id,
                            end_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_end_date").getValue()),
                        };                       
                        reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);
                      }
                      else if(reports_obj.select_id==44){
                        reports_obj.params = {
                            report_name : reports_obj.report_name,
                            report_id : reports_obj.select_id,                                                        
                            start_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_start_date").getValue()),
                            end_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_end_date").getValue())
                        };                       
                        reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);  
                      }
                      
                      
                },
                generateCustomReport:function(){                    
                     Ext.getCmp("report_print_btn").disable();
                     Ext.getCmp("report_export_btn").disable();
                     Ext.getCmp("back_button").disable();
                     document.getElementById("report_frame").src=action_urls.get_custom_reports;
                      if(reports_obj.select_id==51){
                        reports_obj.params = {
                            report_name : reports_obj.report_name,
                            report_id : reports_obj.select_id,
                            start_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_start_date").getValue()),
                            end_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_end_date").getValue())
                            
                        };                       
                        reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);
                      }
                      else if(reports_obj.select_id==52 ||reports_obj.select_id==53){
                        reports_obj.params = {
                            report_name : reports_obj.report_name,
                            report_id : reports_obj.select_id,                                                                                    
                            end_date : reports_obj.getDateMysqlFormatWithTime(new Date())
                        };                       
                        reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);  
                      }                      
                      
                },
                getAccountReport:function(){
                    reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);                                                    
                    Ext.get("report_frame").dom.contentWindow.generate_report(reports_obj.params);                                                                      
                },
                getCustomReport:function(){
                    reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);                                                    
                    Ext.get("report_frame").dom.contentWindow.generate_report(reports_obj.params);                                                                      
                }
             };  
        },
        show:function(){
          if(!reports_obj.isLoaded){
           }
           reports_obj.select_id = 0;
        },
        afterrender:function(){
             cat_store.load();
             reportWindow = Ext.create('widget.window', {
                title: labels_json.reportspanel.text_generate_report,
                width: 550,
                height:270,
                minWidth: 100,
                minHeight: 50,
                layout: 'fit',
                closeAction:'hide',
                modal:true,
                items:Ext.create('Ext.form.Panel', {
                        url:'save-form.php',
                        bodyStyle:'padding:5px 5px 0',
                        fieldDefaults: {
                            msgTarget: 'side',
                            labelWidth: 75
                        },
                        defaults: {
                            anchor: '100%'
                        },

                        items: [
                            {
                                xtype:'fieldset',
                                title: labels_json.reportspanel.text_date_fieldset,
                                collapsible: false,
                                id:'date_fieldset',
                                defaultType: 'textfield',
                                cls:'fieldset_text_report',
                                layout: 'anchor',
                                defaults: {
                                    anchor: '100%',
                                    labelWidth:100
                                },
                                items :[
                                    {
                                        xtype:'datefield',
                                        fieldLabel:labels_json.reportspanel.text_select_start_date,
                                        maxValue: new Date(),
                                        value: new Date(),
                                        id:'report_start_date',
                                        emptyText:'Select Start Date',
                                        format: 'd-m-Y'
                                    },
                                    {
                                        xtype:'datefield',
                                        fieldLabel:labels_json.reportspanel.text_select_to_date,
                                        id:'report_end_date',
                                        value: new Date(),
                                        maxValue: new Date(),
                                        format: 'd-m-Y'

                                    }
                                ]
                        },
                            {
                                xtype:'fieldset',
                                title: labels_json.reportspanel.text_products_fieldset,
                                collapsible: false,
                                id:'products_fieldset',
                                defaultType: 'textfield',
                                cls:'fieldset_text_report',
                                layout: 'anchor',
                                defaults: {
                                    anchor: '100%',
                                    labelWidth:100
                                },
                                items :[
                                 {
                                        xtype:'textfield',
                                        queryMode:'remote',
                                        typeAheadDelay:20,
                                        displayField:'item',
                                        id : 'report_search_item',
                                        fieldLabel:"Search Item",
                                        emptyText:"Search Item",                                                                        
                                        typeahead:true,
                                        listeners:{
                                        }
                                    },

                                    {
                                        xtype:'combo',
                                        queryMode:'remote',
                                        typeAheadDelay:20,
                                        displayField:'item',
                                        id : 'report_item_id',
                                        fieldLabel:labels_json.reportspanel.text_select_item,
                                        store:item_store,
                                        pageSize:50,
                                        valueField:'id',
                                        emptyText:labels_json.reportspanel.text_select_item,                                                                        
                                        typeahead:true,
                                        listeners:{
                                            change:function(obj){                                            
                                               if(isNaN(parseInt(obj.getValue()))){
                                                   var val = "";
                                                   var items = Ext.pluck(obj.store.data.items,'data');
                                                   for(var i=0;i<items.length;i++){
                                                       if(items[i].item==obj.getValue()){
                                                           val = items[i].id;
                                                           break;
                                                       }
                                                   }
                                                   //obj.setValue(val);
                                               }

                                            }
                                        } 
                                    }, 
                                    {
                                        xtype:'hidden',
                                        name:'cat_id',
                                        id:'item_category_search',
                                        value:'0'
                                    },
                                    {
                                        xtype:'combo',
                                        queryMode:'remote',
                                         listConfig : {
                                                        itemTpl : '<li class="item-row-li" style="width:100%; float:left;"><span style="width:60%; float:left;"> <input type="checkbox" value="{id}" />{name} </span> <strong style="width:40%; float:left;"> {parent} </strong></li>',
                                                    },
                                        typeAheadDelay:20,
                                        displayField:'name',
                                        id : 'report_cat_id',
                                        multiSelect: true,
                                        fieldLabel:labels_json.reportspanel.text_select_category,
                                        store:cat_store,
                                        pageSize:50,
                                        valueField:'id',
                                        emptyText:labels_json.reportspanel.text_select_category,                                                                        
                                        typeahead:true,
                                        listeners:{
                                            change:function(obj){                                            
                                               if(isNaN(parseInt(obj.getValue()))){
                                                   var val = "";
                                                   var categories = Ext.pluck(obj.store.data.categories,'data');
                                                   for(var i=0;i<categories.length;i++){
                                                       if(categories[i].name==obj.getValue()){
                                                           val = categories[i].id;
                                                           break;
                                                       }
                                                   }
                                                   //obj.setValue(val);
                                               }
                                               // alert(this.getValue())
                                            }
                                        } 
                                    },

                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_units,
                                        id:'units',
                                        name:'units',
                                        displayField:'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        valueField:'id',
                                        value:'0',
                                        store:  new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":"Base Unit"},
                                                 {"id":"1", "name":"Last Unit"}
                                             ]
                                         })
                                     },
                                    {
                                      xtype:'combo',
                                      fieldLabel:labels_json.reportspanel.text_select_warehouse,
                                      id:'warehouse',
                                      name:'warehouse',
                                      displayField:'warehouse_name',
                                      queryMode: 'local',
                                      typeAhead: true,
                                      valueField:'id',
                                      store: warehouse_store,
                                      value:'-1',
                                       listeners: {}
                                   },
                                    {
                                      xtype:'combo',
                                      fieldLabel:labels_json.reportspanel.text_to_warehouse,
                                      id:'to_warehouse',
                                      name:'to_warehouse',
                                      displayField:'warehouse_name',
                                      queryMode: 'local',
                                      typeAhead: true,
                                      valueField:'id',
                                      store: warehouse_store,
                                      value:'-1',
                                       listeners: {}
                                   },
                                    {
                                      xtype:'combo',
                                      fieldLabel:"Report Type",
                                      id:'warehouse_type',
                                      name:'warehouse_type',
                                      displayField:'name',
                                      queryMode: 'local',
                                      typeAhead: true,
                                      valueField:'id',
                                      value:'0',
                                        store:  new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":"Product Wise"},
                                                 {"id":"1", "name":"Invoice Wise"}
                                             ]
                                         })
                                   }
                                ]
                            },
                            {
                                xtype:'fieldset',
                                title: labels_json.reportspanel.text_other_fieldset,
                                collapsible: false,
                                id:'other_fieldset',
                                defaultType: 'textfield',
                                cls:'fieldset_text_report',
                                layout: 'anchor',
                                defaults: {
                                    anchor: '100%',
                                    labelWidth:100
                                },
                                items :[
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_below_order_point,
                                        id:'below_order_point',
                                        name:'below_order_point',
                                        displayField:'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        valueField:'id',
                                        value:'0',
                                        store: new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":labels_json.reportspanel.text_no},
                                                 {"id":"1", "name":labels_json.reportspanel.text_yes}
                                             ]
                                         })
                                     },
                                    {
                                      xtype:'combo',
                                      fieldLabel:labels_json.reportspanel.text_below_zero,
                                      id:'below_zero_quantity',
                                      name:'below_zero_quantity',
                                      displayField:'name',
                                      queryMode: 'local',
                                      typeAhead: true,
                                      valueField:'id',
                                      value:'0',
                                      store: new Ext.data.Store({
                                         fields: ['id', 'name'],
                                           data : [
                                               {"id":"0", "name":labels_json.reportspanel.text_no},
                                                 {"id":"1", "name":labels_json.reportspanel.text_yes}
                                           ]
                                       })
                                   }, 
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_category_report,
                                        id:'category_report',
                                        name:'category_report',
                                        displayField:'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        valueField:'id',
                                        value:'0',
                                        store: new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":labels_json.reportspanel.text_no},
                                                 {"id":"1", "name":labels_json.reportspanel.text_yes}
                                             ]
                                         }),
                                         listeners: {
                                           change: function(f, obj){
                                               if(f.getValue()=="0"){
                                                   Ext.getCmp("report_item_id").show();
                                                   reportWindow.setHeight(450);
                                               } else if (f.getValue()=="1"){
                                                   Ext.getCmp("report_item_id").hide();
                                                   reportWindow.setHeight(420);
                                               }
                                           }  
                                         }
                                     },
                                    {
                                        xtype:'textfield',                                    
                                        id : 'item_code_report',
                                        fieldLabel:labels_json.reportspanel.text_item_code,                                    
                                        emptyText:labels_json.reportspanel.text_enter_item_code,
                                        allowBlank: true
                                    }
                            ]
                        },
                            {
                                xtype:'fieldset',
                                title: labels_json.reportspanel.customer_fieldset,
                                collapsible: false,
                                hidden:true,
                                id:'customer_fieldset',
                                defaultType: 'textfield',
                                cls:'fieldset_text_report',
                                layout: 'anchor',
                                defaults: {
                                    anchor: '100%',
                                    labelWidth:100
                                },
                                items :[                                  
                                    {
                                        xtype:'combo',
                                        queryMode:'local',
                                        displayField:'cust_name',
                                        id : 'customer_report_combo',
                                        fieldLabel: labels_json.reportspanel.text_select_customer,
                                        store:customer_store_withall,
                                        valueField:'cust_id',                                    
                                        value:'-1',                                    
                                        emptyText: labels_json.reportspanel.text_select_customer
                                    }, 
                                    {
                                        xtype:'combo',
                                        queryMode:'local',
                                        displayField:'name',
                                        id : 'report_invoice_type',
                                        fieldLabel:labels_json.reportspanel.text_invoice_type,
                                        store: Ext.create('Ext.data.Store', {
                                                fields: ['id', 'name'],
                                                data : [
                                                        {"id":"-1", "name":labels_json.reportspanel.text_all},
                                                        {"id":"1", "name":labels_json.reportspanel.text_sale_invoice},
                                                        {"id":"2", "name":labels_json.reportspanel.text_sale_return_invoice}
                                                ]
                                            }),
                                        valueField:'id',
                                        emptyText:'Select Type',
                                        value:'-1'
                                    },
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_group_region,
                                        displayField: 'cust_group_name',
                                        valueField:'id',
                                        id:'report_group_list_sales',
                                        queryMode: 'local',
                                        value:'-1',
                                        typeAhead: true,
                                        store: customer_group_store_withall
                                     },
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_customer_type,
                                        displayField: 'cust_type_name',
                                        valueField:'id',
                                        id:'report_type_list',
                                        queryMode: 'local',
                                        value:'-1',
                                        typeAhead: true,
                                        store: customer_type_store_withall
                                     },
                                      {
                                        xtype:'combo',
                                        fieldLabel:'Below Customers',
                                        id:'CustBelowZero',
                                        name:'CustBelowZero',
                                        displayField:'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        valueField:'id',
                                        value:'1',
                                        store: new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":'Yes'},
                                                 {"id":"1", "name":'No'}
                                             ]
                                         })
                                     }
                                     ,{
                                        xtype:'combo',
                                        fieldLabel:'Detail Report',
                                        id:'CustSaleDetail',
                                        name:'CustSaleDetail',
                                        displayField:'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        valueField:'id',
                                        value:'0',
                                        store: new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":'Summary'},
                                                 {"id":"1", "name":'Date Wise Detail'}
                                             ]
                                         })
                                     },
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_expenses,
                                        id:'report_expense_combo',
                                        emptyText: labels_json.reportspanel.text_select_a_expense,
                                        typeAhead: true,
                                        name:'report_expense_combo',
                                        valueField:'expense_id',
                                        value:'-1',
                                        displayField:'expense_name',
                                        store: expense_store_withall,
                                        queryMode:'local'
                                    },
                                    {
                                            xtype:'combo',
                                            queryMode:'local',
                                            displayField:'salesrep_name',
                                            id : 'sales_rep_combo',
                                            fieldLabel:labels_json.reportspanel.text_select_rep,
                                            store:salesrep_storeWithAll,
                                            valueField:'id',                                    
                                            value:'-1',
                                            hidden:true,
                                            emptyText:labels_json.reportspanel.text_select_rep
                                        }, 
                                    {
                                        xtype:'combo',
                                        queryMode:'local',
                                        displayField:'user_name',
                                        id : 'sales_user_combo',
                                        fieldLabel:labels_json.reportspanel.text_select_user,
                                        store:user_store_withall,
                                        valueField:'user_id',                                    
                                        value:'-1',
                                        hidden:true,
                                        emptyText:labels_json.reportspanel.text_select_user
                                    },
                                    {
                                        xtype:'combo',
                                        queryMode:'local',
                                        displayField:'vendor_name',
                                        id : 'vendor_report_combo',
                                        fieldLabel:labels_json.reportspanel.text_select_vendor,
                                        store:vendor_store_withall,
                                        valueField:'vendor_id',                                    
                                        value:'All',                                    
                                        emptyText:labels_json.reportspanel.text_select_vendor
                                    }
                                ]
                            },
                            {
                                xtype:'fieldset',
                                title: labels_json.reportspanel.account_fieldset,
                                collapsible: false,
                                id:'account_fieldset',
                                defaultType: 'textfield',
                                cls:'fieldset_text_report',
                                layout: 'anchor',
                                defaults: {
                                    anchor: '100%',
                                    labelWidth:100
                                },
                                items :[
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_accounts,
                                        displayField: 'acc_name',
                                        valueField:'acc_id',
                                        id:'account_list',
                                        queryMode: 'local',
                                        value:'-1',
                                        typeAhead: true,
                                        store: asset_account_withall
                                     },
                                    {
                                        xtype:'combo',
                                        fieldLabel:labels_json.reportspanel.text_loan_report,
                                        id:'print_loan_report',
                                        name:'print_loan_report',
                                        displayField:'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        valueField:'id',
                                        value:'0',
                                        store: new Ext.data.Store({
                                           fields: ['id', 'name'],
                                             data : [
                                                 {"id":"0", "name":labels_json.reportspanel.text_loan_payable},
                                                 {"id":"1", "name":labels_json.reportspanel.text_loan_receivable}
                                             ]
                                         })
                                     } 
                                ]
                            },
                            {
                                    xtype:'fieldset',
                                    title: labels_json.reportspanel.text_customize_fieldset,
                                    collapsible: false,
                                    id:'customize_fieldset',
                                    defaultType: 'textfield',
                                    cls:'fieldset_text_report',
                                    layout: 'anchor',
                                    defaults: {
                                        anchor: '100%',
                                        labelWidth:100
                                    },
                                    items :[
                                        {
                                        xtype: 'checkboxgroup',
                                        id : 'text_customize_report',
                                        fieldLabel: labels_json.reportspanel.text_customize_report,
                                        columns: 1,
                                        allowBlank: true,
                                        itemId: '',
                                        items: [
                                            {
                                                xtype:'checkbox',
                                                boxLabel:labels_json.reportspanel.text_over_due_customer,
                                                id:'over_limit_detail',
                                                name:'over_limit_detail',
                                                inputValue: '0'
                                                
                                             },
                                             {
                                                    xtype: 'checkbox',
                                                    boxLabel: labels_json.reportspanel.text_show_last_payment,
                                                    name: 'last_payment',
                                                    id: 'last_payment',
                                                    inputValue: '1'
                                             },
                                             {
                                                xtype: 'checkbox',
                                                boxLabel: labels_json.reportspanel.text_non_collected_customer,
                                                name: 'non_collected',
                                                id: 'non_collected',
                                                checked: false,
                                                inputValue: '1'
                                            },
                                            {
                                                xtype: 'checkbox',
                                                boxLabel: labels_json.reportspanel.text_show_in_coton,
                                                name: 'show_in_coton',
                                                id: 'show_in_coton',
                                                checked: false,
                                                inputValue: '1'
                                            },
                                             {
                                                xtype: 'checkbox',
                                                boxLabel: 'Show Price',
                                                name: 'show_price',
                                                id: 'show_price',
                                                checked: true,
                                                inputValue: '1'
                                            }
                                         
                                        ]
                                    }
                                ]
                            }
                        ],
                        buttons: [
                            {
                            text: labels_json.reportspanel.text_generate_report,
                            handler: function() { 
                              // console.log(this.up('form').getForm().isValid())
                                if (this.up('form').getForm().isValid()) {
                                  Ext.getCmp("report_print_btn").disable();
                                  Ext.getCmp("report_export_btn").disable();
                                  Ext.getCmp("back_button").disable();
                                  document.getElementById("report_frame").src=action_urls.get_reports;
                                  reports_obj.params = {
                                      report_name : reports_obj.report_name,
                                      report_id : reports_obj.select_id,
                                      start_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_start_date").getValue()),
                                      end_date : reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("report_end_date").getValue()),
                                     
                                  };
                                  if(reports_obj.select_id==1 || reports_obj.select_id==13 || reports_obj.select_id==14 || reports_obj.select_id==11){
                                      reports_obj.params['product_id'] = Ext.getCmp("report_item_id").getValue();
                                      reports_obj.params['category_id'] = Ext.getCmp("report_cat_id").getValue();
                                      reports_obj.params['warehouse'] = Ext.getCmp("warehouse").getValue();
                                      reports_obj.params['print_category_report'] = Ext.getCmp("category_report").getValue();                                   
                                      reports_obj.params['show_in_coton'] = Ext.getCmp("show_in_coton").getValue();
                                      reports_obj.params['vendor_id'] = Ext.getCmp("vendor_report_combo").getValue();                                     
                                                                          
                                  } 
                                    if(reports_obj.select_id==105){
                                      reports_obj.params['customer_id'] = Ext.getCmp("customer_report_combo").getValue();
                                      reports_obj.params['customer_region'] = Ext.getCmp("report_group_list_sales").getValue();
                                        reports_obj.params['rep_id'] = Ext.getCmp("sales_rep_combo").getValue();                              
                                                                          
                                  } 
                                  else if(reports_obj.select_id==2 || reports_obj.select_id==91 || reports_obj.select_id==92
                                   || reports_obj.select_id==98 || reports_obj.select_id==21 || reports_obj.select_id==22 ||
                                    reports_obj.select_id==23 || reports_obj.select_id==24 || reports_obj.select_id==25 ||
                                     reports_obj.select_id==26 || reports_obj.select_id==81 || reports_obj.select_id==104){
                                      reports_obj.params['product_id'] = Ext.getCmp("report_item_id").getValue();
                                      reports_obj.params['category_id'] = Ext.getCmp("report_cat_id").getValue();
                                      reports_obj.params['rep_id'] = Ext.getCmp("sales_rep_combo").getValue();
                                      reports_obj.params['vendor_id'] = Ext.getCmp("vendor_report_combo").getValue();
                                  }
                                    else if(reports_obj.select_id==98){
                                      reports_obj.params['vendor_id'] = Ext.getCmp("vendor_report_combo").getValue();
                                  }
                                  else if(reports_obj.select_id==3 || reports_obj.select_id==4){
                                      reports_obj.params['customer_id'] = Ext.getCmp("customer_report_combo").getValue();            
                                      reports_obj.params['invoice_type'] = Ext.getCmp("report_invoice_type").getValue();
                                      reports_obj.params['customer_region'] = Ext.getCmp("report_group_list_sales").getValue();                                      
                                      reports_obj.params['cust_saleDetail'] = Ext.getCmp("CustSaleDetail").getValue();                                      
                                  }
                                  else if(reports_obj.select_id==5 || reports_obj.select_id==6 || reports_obj.select_id==7 || reports_obj.select_id==8 || reports_obj.select_id==9 || reports_obj.select_id==10 || reports_obj.select_id==80){
                                      reports_obj.params['product_id'] = Ext.getCmp("report_item_id").getValue();
                                      reports_obj.params['category_id'] = Ext.getCmp("report_cat_id").getValue();
                                      reports_obj.params['customer_id'] = Ext.getCmp("customer_report_combo").getValue();            
                                      reports_obj.params['invoice_type'] = Ext.getCmp("report_invoice_type").getValue();
                                      reports_obj.params['customer_region'] = Ext.getCmp("report_group_list_sales").getValue();
                                      reports_obj.params['user_id'] = Ext.getCmp("sales_user_combo").getValue();
                                       reports_obj.params['customer_type'] = Ext.getCmp("report_type_list").getValue();
                                      reports_obj.params['over_limit_detail'] = Ext.getCmp("over_limit_detail").getValue();
                                  }
                                  else  if(reports_obj.select_id==24 || reports_obj.select_id==25 || reports_obj.select_id==26 || reports_obj.select_id==43){
                                      reports_obj.params['vendor_id'] = Ext.getCmp("vendor_report_combo").getValue();                                      
                                      // reports_obj.params['show_invoice_detail'] = Ext.getCmp("show_invoice_detail").getValue();
                                  }
                                  else if(reports_obj.select_id==31 || reports_obj.select_id==32 || reports_obj.select_id==33 || reports_obj.select_id==35 || reports_obj.select_id==36 || reports_obj.select_id==60 || reports_obj.select_id==37 || reports_obj.select_id==49 ||reports_obj.select_id==63 || reports_obj.select_id==75){
                                      reports_obj.params['product_id'] = Ext.getCmp("report_item_id").getValue();
                                      reports_obj.params['product_search'] = Ext.getCmp("report_search_item").getValue();
                                      reports_obj.params['category_id'] = Ext.getCmp("report_cat_id").getValue();
                                      reports_obj.params['warehouse'] = Ext.getCmp("warehouse").getValue(); 
                                      reports_obj.params['to_warehouse'] = Ext.getCmp("to_warehouse").getValue();
                                      reports_obj.params['warehouse_type'] = Ext.getCmp("warehouse_type").getValue();
                                      reports_obj.params['below_order_point'] = Ext.getCmp("below_order_point").getValue();
                                      reports_obj.params['show_in_coton'] = Ext.getCmp("show_in_coton").getValue();
                                      reports_obj.params['show_price'] = Ext.getCmp("show_price").getValue();
                                      reports_obj.params['below_zero_quantity'] = Ext.getCmp("below_zero_quantity").getValue();
                                      reports_obj.params['vendor_id'] = Ext.getCmp("vendor_report_combo").getValue();
                                      reports_obj.params['units'] = Ext.getCmp("units").getValue();
                                  } 
                                  else if(reports_obj.select_id==42 || reports_obj.select_id==45 || reports_obj.select_id==12){   
                                      reports_obj.params['customer_id'] = Ext.getCmp("customer_report_combo").getValue();
                                      reports_obj.params['over_limit_detail'] = Ext.getCmp("over_limit_detail").getValue(); 
                                      reports_obj.params['customer_type'] = Ext.getCmp("report_type_list").getValue();
                                      reports_obj.params['customer_region'] = Ext.getCmp("report_group_list_sales").getValue();
                                      reports_obj.params['non_collected'] = Ext.getCmp("non_collected").getValue();                                     
                                      reports_obj.params['last_payment'] = Ext.getCmp("last_payment").getValue();                                      
                                      reports_obj.params['customer_type'] = Ext.getCmp("report_type_list").getValue();                                      
                                      reports_obj.params['CustBelowZero'] = Ext.getCmp("CustBelowZero").getValue();                                      
                                  }
                                  else if(reports_obj.select_id==47){
                                     reports_obj.params['report_expense_combo'] = Ext.getCmp("report_expense_combo").getValue();
                                  }
                                  
                                  else  if(reports_obj.select_id==48){
                                      reports_obj.params['print_loan_report'] = Ext.getCmp("print_loan_report").getValue()
                                      
                                  }
                                   else if(reports_obj.select_id==55){
                                    reports_obj.params['rep_id'] = Ext.getCmp("sales_rep_combo").getValue();
                                  }
                                  
                                  else  if(reports_obj.select_id==90){
                                      reports_obj.params['asset_id'] = Ext.getCmp("account_list").getValue()
                                  }
                                  
                                    else if(reports_obj.select_id==91 || reports_obj.select_id==92 || reports_obj.select_id==98|| reports_obj.select_id==99){
                                      reports_obj.params['vendor_id'] = Ext.getCmp("vendor_report_combo").getValue() 
                                      reports_obj.params['product_id'] = Ext.getCmp("report_item_id").getValue() 
                                      reports_obj.params['category_id'] = Ext.getCmp("report_cat_id").getValue() 
                                      
                                  }
                                  reports_obj.maskMe(reports_obj.report_name + ' ' + labels_json.reportspanel.text_generating_report);
                                  if(reports_obj.select_id == 41 || reports_obj.select_id == 44 || reports_obj.select_id == 54){
                                    reports_obj.generateAccountReport();
                                  }
                                  else if (reports_obj.select_id == 51 || reports_obj.select_id == 52 || reports_obj.select_id == 53){
                                     reports_obj.generateCustomReport();
                                  }
                                  this.up('window').hide(); 
                                  
                                }
                            }
                        },
                            {
                                text: labels_json.reportspanel.text_cancel,
                                handler: function() {
                                     this.up('form').getForm().reset();
                                    this.up('window').hide();  

                                }
                            }
                        ]
                    }),
                    listeners:{
                        show:function()  {

                            if(Ext.getCmp('item_category_search').getValue()=="0"){   
                                Ext.getCmp('item_category_search').setValue("0");   
                            }
                        }
                    },
               
            });
            
        }
    },
    defaults:{
        border:false
    },
    items: [
     {
      region:'west',
      width:300,
      margins:'5 0 5 5',
      split:true,
      id:'reports_left_panel',
      width: 210,
      hideCollapseTool:true ,
      layout:'accordion',
      items: [
         {
            title: labels_json.reportspanel.text_sales_reports,
            cls :'reports_table',
            layout: {
                type: 'table',
                columns: 1,
                 tableAttrs: {
                    width:'100%'
                }
                
            },
            defaults:{border:false,
              listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault();
                        if(user_right==1){
                        if(this.dom.className.indexOf("active-report")>-1){
                            reports_obj.select_id = this.getAttribute("report_id");
                            reports_obj.report_name = this.getHTML();
                            if(reports_obj.select_id==1 || reports_obj.select_id==13){    
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").show();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").show();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").show();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(520);
                            } 
                            else if(reports_obj.select_id==14){    
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(300);
                            }
                            else if(reports_obj.select_id==11){    
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(270);
                            }
                            else if(reports_obj.select_id==12){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(270); 
                            }
                            else if(reports_obj.select_id==2){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").show();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(350); 
                                
                            }   
                            else if(reports_obj.select_id==3){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("CustSaleDetail").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").show();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(320); 
                            }
                             else if(reports_obj.select_id==4 || reports_obj.select_id==9){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").show();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(320); 
                            }
                            else if(reports_obj.select_id==5){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").show();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(400);  
                            } 
                            else if(reports_obj.select_id==6){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").show();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(350);
                                
                            }
                            else if(reports_obj.select_id==7){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(370);
                                
                            }    
                            else if(reports_obj.select_id==8){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").show();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(300);                                 
                            }
                            else if(reports_obj.select_id==10){
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").show();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(240); 
                            }
                            else if(reports_obj.select_id==80){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                // Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(240); 
                            }    
                              else if(reports_obj.select_id==99){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(350); 
                            }
                             else if(reports_obj.select_id==104){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").show();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(250); 
                            }
                                else if(reports_obj.select_id==105){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").show();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(300); 
                            }
                               else if(reports_obj.select_id==106){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(150); 
                            }
                               else if(reports_obj.select_id==107){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(150); 
                            }
                             else if(reports_obj.select_id==108){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(250); 
                            }
                            reportWindow.setTitle(this.dom.innerHTML);
                            reportWindow.show();
                            
                            
                        }
                        }
                    }
                }
            }
            },
            items:[
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_category,"cls":"active-report","report_id":1}
            },
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_return_by_category,"cls":"active-report","report_id":13}
            },
            
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_item_detail,"cls":"active-report","report_id":14}
            },
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_category_wise_sale_report_summary,"cls":"active-report","report_id":11}
            },
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_daily_sale_report_summary,"cls":"active-report","report_id":12}
            },
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_sale_rep,"cls":"active-report","report_id":2}
            },
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_collection_by_sale_rep,"cls":"active-report","report_id":104}
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_customer_summary,"cls":"active-report","report_id":3}
            },            
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_order_summary,"cls":"active-report","report_id":4}
               
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_summary_by_group_region,"cls":"active-report","report_id":5}
               
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_user,"cls":"active-report","report_id":6}
               
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_customer,"cls":"active-report","report_id":7}
               
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_customer_transaction_summary,"cls":"active-report","report_id":8}
               
            },
            {
              xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_sales_by_invoices_profit,"cls":"active-report","report_id":9}
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_customer_list,"cls":"active-report","report_id":10}
               
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_customer_agging_report,"cls":"active-report","report_id":80}
               
            },  {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_wise_sale,"cls":"active-report","report_id":99}
               
            },{
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_dailySaleCashRecieve,"cls":"active-report","report_id":105}
               
            },{
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_CashBalance,"cls":"active-report","report_id":106}
               
            },
            {
               xtype:'box', autoEl:{tag:"a", html:labels_json.reportspanel.text_ExepenseList,"cls":"active-report","report_id":107}
            },   

             {
               xtype:'box', autoEl:{tag:"a", html:"Daily Invoices Summary","cls":"active-report","report_id":108}
               
            }
            
            ]
         },
         {
            title: labels_json.reportspanel.text_purchase_title_reports,
            cls :'reports_table',
            layout: {
                type: 'table',
                columns: 1,
                 tableAttrs: {
                    width:'100%'
                }
                
            },
            defaults:{border:false,
                listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault();
                        if(user_right==1){
                        if(this.dom.className.indexOf("active-report")>-1){
                            reports_obj.select_id = this.getAttribute("report_id");
                            reports_obj.report_name = this.getHTML();
                            if(reports_obj.select_id==91 || reports_obj.select_id==92){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("vendor_report_combo").setValue("-1");
                                reportWindow.setHeight(350);
                            }
                             else if(reports_obj.select_id==98){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("vendor_report_combo").setValue("-1");
                                reportWindow.setHeight(250);
                            }
                            else if(reports_obj.select_id==21 || reports_obj.select_id==23 || reports_obj.select_id==26 || reports_obj.select_id==81){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("vendor_report_combo").setValue("-1");
                                reportWindow.setHeight(240);
                            }
                            else if(reports_obj.select_id==22){
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("vendor_report_combo").setValue("-1");
                                reportWindow.setHeight(140);
                            }
                            else if(reports_obj.select_id==24 || reports_obj.select_id==25){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("vendor_report_combo").setValue("-1");
                                reportWindow.setHeight(360);
                            }
                            reportWindow.setTitle(this.dom.innerHTML);
                            reportWindow.show();
                            
                            
                        }
                        } 
                    }
                }
            }
            },
            items:[
               {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_purchase_reports,"cls":"active-report","report_id":98}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_purchase_detail_reports,"cls":"active-report","report_id":91}      
              },  {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_purchase_return_reports,"cls":"active-report","report_id":92}      
              }, {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_transaction_summary,"cls":"active-report","report_id":21}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_list,"cls":"active-report","report_id":22}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_payment_summary,"cls":"active-report","report_id":23}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_purchase_order_summary,"cls":"active-report","report_id":24}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_wise_sale_report,"cls":"active-report","report_id":25}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_register_report,"cls":"active-report","report_id":26}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_agging_report,"cls":"active-report","report_id":81}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_purchase_order_status}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_product_cost_report}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_vendor_product_list}      
              }
            ]
         },
         {
            title: labels_json.reportspanel.text_inventory_reports,
            cls :'reports_table',
            layout: {
                type: 'table',
                columns: 1,
                 tableAttrs: {
                    width:'100%'
                }
                
            },
            defaults:{border:false,
                listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault(); 
                        if(user_right==1){
                        if(this.dom.className.indexOf("active-report")>-1){
                            reports_obj.select_id = this.getAttribute("report_id");
                            reports_obj.report_name = this.getHTML();
                            if(reports_obj.select_id==31){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").show();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").show();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").show();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(500);
                            }  
                            else if(reports_obj.select_id==60){
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").show();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").show();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").show();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(350);
                            }
                            else if(reports_obj.select_id==37){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(270);
                            }
                            else if(reports_obj.select_id==32){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").show();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(270);
                            }
                            else if(reports_obj.select_id==33 || reports_obj.select_id==35){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(310);                               
                            }
                            else if(reports_obj.select_id==36){
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(200);
                                  
                            }
                            else if(reports_obj.select_id==34){                                                               
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").show();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").show();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(150);
                            }
                            else if(reports_obj.select_id==49){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").show();
                                Ext.getCmp("warehouse_type").show();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(330);
                            }
                            else if(reports_obj.select_id==63){
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").hide();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").show();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(200);
                                  
                            }  
                            else if(reports_obj.select_id==75){
                                Ext.getCmp("date_fieldset").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").show();
                                Ext.getCmp("report_item_id").show();
                                Ext.getCmp("report_search_item").show();
                                Ext.getCmp("report_cat_id").show();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").show();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(250);
                                  
                            } 
                            reportWindow.setTitle(this.dom.innerHTML);
                            reportWindow.show();
                        }
                        }
                    }
                }
            }
           
            }, items:[{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_inventory_summary,"cls":"active-report","report_id":31}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_inventory_item_summary,"cls":"active-report","report_id":60}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_negative_inventory_summary,"cls":"active-report","report_id":37}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_inventory_detail_report,"cls":"active-report","report_id":32}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_inventory_valuation_detail,"cls":"active-report","report_id":33}      
              },{
               xtype:'box',      
                autoEl:{tag:"a", html:labels_json.reportspanel.text_inventory_sale_purchase_stock_report,"cls":"active-report","report_id":35}      
              },{
               xtype:'box',      
                autoEl:{tag:"a", html:labels_json.reportspanel.text_low_stock_report,"cls":"active-report","report_id":36}      
              },{
               xtype:'box',      
                autoEl:{tag:"a", html:labels_json.reportspanel.text_check_ownership_item,"cls":"active-report","report_id":34}      
              },{
               xtype:'box',      
                autoEl:{tag:"a", html:labels_json.reportspanel.text_stock_transfer_report,"cls":"active-report","report_id":49}      
              },{
               xtype:'box',      
                autoEl:{tag:"a", html:labels_json.reportspanel.text_stock_reordering_report,"cls":"active-report","report_id":63}      
              },{
               xtype:'box',      
                autoEl:{tag:"a", html:labels_json.reportspanel.text_item_list_report,"cls":"active-report","report_id":75}      
              }
            ]
         },
         {
            title: labels_json.reportspanel.text_accounts_reports,
            cls :'reports_table',
            layout: {
                type: 'table',
                columns: 1,
                 tableAttrs: {
                    width:'100%'
                }
                
            },
            defaults:{border:false,
                listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault(); 
                        if(user_right==1){
                        if(this.dom.className.indexOf("active-report")>-1){                            
                            reports_obj.select_id = this.getAttribute("report_id");
                            reports_obj.report_name = this.getHTML();
                            if(reports_obj.select_id==41 || reports_obj.select_id==54){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").hide();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(150);
                            }
                            else if(reports_obj.select_id==42){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").show();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").show();
                                Ext.getCmp("last_payment").show();
                                Ext.getCmp("non_collected").show();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").show();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(400); 
                            }
                            else if(reports_obj.select_id==43){
                               Ext.getCmp("date_fieldset").show();
                               Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").show();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("vendor_report_combo").setValue("-1");
                                reportWindow.setHeight(220);  
                            }
                            else if(reports_obj.select_id==44 || reports_obj.select_id==46){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(180);                                 
                            }
                            else if(reports_obj.select_id==45){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").show();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").show();
                                Ext.getCmp("report_type_list").show();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").show();
                                Ext.getCmp("text_customize_report").show();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").show();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("customer_report_combo").setValue("-1");
                                reportWindow.setHeight(370);                               
                            }
                            else if(reports_obj.select_id==47){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").show();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("report_expense_combo").setValue("-1");
                                reportWindow.setHeight(250);                              
                            }
                            else if(reports_obj.select_id==48){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").hide();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").show();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").show();
                                reportWindow.setHeight(220);
                            }
                            else if(reports_obj.select_id==55){
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").show();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").show();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(250);
                            }
                            else if(reports_obj.select_id==90){
                               Ext.getCmp("date_fieldset").show();
                               Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("customize_fieldset").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("account_fieldset").show();
                                Ext.getCmp("account_list").show();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                reportWindow.setHeight(250);
                            }
                             
                             reportWindow.setTitle(this.dom.innerHTML);
                             reportWindow.show();
                        }
                        } 
                    }
                }
            }
            
            }, items:[{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_balance_sheet,"cls":"active-report","report_id":41}      
              },
              {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_trial_balance,"cls":"active-report","report_id":54}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_account_receivable,"cls":"active-report","report_id":42}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_account_payable,"cls":"active-report","report_id":43}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_profit_and_loss,"cls":"active-report","report_id":44}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_cash_register,"cls":"active-report","report_id":45}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_income_statement_summary_report,"cls":"active-report","report_id":46}      
              },
              {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_expence_report,"cls":"active-report","report_id":47}      
              },
              {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_loan_payable_recievable_report,"cls":"active-report","report_id":48}      
              },
              {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_amount_recieved_expense_by_sale_rep,"cls":"active-report","report_id":55}
               
               }, {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_essets_report,"cls":"active-report","report_id":90}
               
               },
                {
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_general_ledger}      
                },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_journal_entries}      
              }
            ]
         },
         {
            title: labels_json.reportspanel.text_custom_reports,
            cls :'reports_table',
            hidden:enableCustomReport=="1"?false:true,
            layout: {
                type: 'table',
                columns: 1,
                 tableAttrs: {
                    width:'100%'
                }
                
            },
            defaults:{border:false,
                listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault(); 
                        
                        if(this.dom.className.indexOf("active-report")>-1){                            
                            reports_obj.select_id = this.getAttribute("report_id");
                            reports_obj.report_name = this.getHTML();
                            if(reports_obj.select_id==51){                                
                                Ext.getCmp("date_fieldset").show();
                                Ext.getCmp("CustSaleDetail").hide();
                                Ext.getCmp("report_start_date").show();
                                Ext.getCmp("report_end_date").show();
                                Ext.getCmp("products_fieldset").hide();
                                Ext.getCmp("report_item_id").hide();
                                Ext.getCmp("report_cat_id").hide();
                                Ext.getCmp("units").hide();
                                Ext.getCmp("warehouse").hide();
                                Ext.getCmp("to_warehouse").hide();
                                Ext.getCmp("warehouse_type").hide();
                                Ext.getCmp("other_fieldset").hide();
                                Ext.getCmp("below_order_point").hide();
                                Ext.getCmp("below_zero_quantity").hide();
                                Ext.getCmp("show_in_coton").hide();
                                Ext.getCmp("category_report").hide();
                                Ext.getCmp("text_customize_report").hide();
                                Ext.getCmp("item_code_report").hide();
                                Ext.getCmp("customer_fieldset").hide();
                                Ext.getCmp("customer_report_combo").hide();
                                Ext.getCmp("report_invoice_type").hide();
                                Ext.getCmp("report_group_list_sales").hide();
                                Ext.getCmp("report_type_list").hide();
                                Ext.getCmp("report_expense_combo").hide();
                                Ext.getCmp("over_limit_detail").hide();
                                Ext.getCmp("sales_rep_combo").hide();
                                Ext.getCmp("sales_user_combo").hide();
                                Ext.getCmp("vendor_report_combo").hide();
                                Ext.getCmp("account_fieldset").hide();
                                Ext.getCmp("account_list").hide();
                                Ext.getCmp("print_loan_report").hide();
                                Ext.getCmp("CustBelowZero").hide();

                                Ext.getCmp("last_payment").hide();
                                Ext.getCmp("non_collected").hide();
                                Ext.getCmp("show_price").hide();
                                reportWindow.setHeight(170);
                                reportWindow.setTitle(this.dom.innerHTML);
                                reportWindow.show();
                            }
                            else if(reports_obj.select_id==52){                               
                                reports_obj.generateCustomReport();
                            }
                            else if(reports_obj.select_id==53){
                                reports_obj.generateCustomReport();
                            }
                           
                        }
                        
                    }
                }
            }
            
            }, items:[{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_invoices_report,"cls":"active-report","report_id":51}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_stock_report,"cls":"active-report","report_id":52}      
              },{
               xtype:'box',      
               autoEl:{tag:"a", html:labels_json.reportspanel.text_customers_report,"cls":"active-report","report_id":53}      
              }
            ]
         }
     ]
    },
    {
     region:'center',
     layout:'fit',
     id:'reports_body',
     items:[{
        xtype:'component',
        id:'report_frame',
        autoEl:{
         tag:'iframe',         
         frameborder:0,
         src:'about:blank'
        }     
     }],
     tbar: [{
            xtype: 'buttongroup',
            columns: 3,
            items: [{
                xtype:'button',
                text: labels_json.reportspanel.text_back,
                tooltip:labels_json.reportspanel.text_back_emptyText,
                id:'back_button',
                scale: 'large',
                disabled:true,
                rowspan: 3,
                iconCls: 'back_24',
                iconAlign: 'top',
                listeners: {
                    click:function(){
                        reports_obj.params.report_id =1;
                        reports_obj.getSaleReport();
                        
                    }
                }
            },{
                text: labels_json.reportspanel.text_print,
                tooltip:labels_json.reportspanel.text_print_emptyText,
                scale: 'large',
                id : 'report_print_btn',
                rowspan: 3, 
                iconCls: 'print_24',
                disabled:true,
                iconAlign: 'top',
                listeners: {
                    click:function(){
                        // console.log('Print...')
                         // Ext.getCmp("print").setValue('1')
                         // element.classList.remove("fixed-header");
                        Ext.get("report_frame").dom.contentWindow.print();    

                    }
                }
            },{
                xtype:'button',
                text: labels_json.reportspanel.text_export,
                tooltip:labels_json.reportspanel.text_export_emptyText,
                scale: 'large',
                id : 'report_export_btn',
                disabled:true,
                rowspan: 3,
                iconCls: 'export_24',
                iconAlign: 'top',
                listeners: {
                    click:function(){
                        reports_obj.maskMe(labels_json.reportspanel.text_generating_pdf); 
                        var report_frame = Ext.get("report_frame").dom.contentWindow;
                        var html = report_frame.$("html");
                        var _html =  html.clone();
                        _html.find("script").remove();
                        var report_file_name = reports_obj.report_name.replace("/","-") +"_"+Ext.Date.format(new Date(),'Ymd_His');
                        
                        var pdf_iframe = Ext.get("print_pdf_iframe").dom.contentWindow;
                        pdf_iframe.document.getElementById("server_path").value = report_frame.server_url;
                        pdf_iframe.document.getElementById("report_file").value = report_file_name;
                        pdf_iframe.document.getElementById("report_html").value=_html[0].outerHTML;
                        pdf_iframe.document.getElementById("report_pdf_form").submit();
                    }
                }
            }]
        }]
    }
    
  ]
    
})
