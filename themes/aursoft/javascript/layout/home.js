({
    id: 'center-panel',
    layout: 'ux.center',
    listeners:{
           afterrender:function (){
            var adjpos=0
            if(enableWarehouse==0)
            {
            Ext.getCmp('showWarehouse').setVisible(false)                                   
            Ext.getCmp('transfer').setVisible(false) 
            // Ext.getCmp('adjust').setVisible(false) 
            Ext.get('adjust').setStyle('padding-top', '120px');
           }
            else{
            }
                                             
        }
    },
    items: {               
        bodyStyle: 'padding:20px 0px;',
        layout: 'fit',    
        id:'main-menu-center',
        width: 850,        
        border:false,
        items: [ 
                {
                border:false,
                layout: 'absolute',
                items:[
                    {
                    xtype: 'box',
                    width:320,
                    height:118,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-arrows icon_arrow_orange'},
                    x:100,
                    y:100
                    },
                    {
                    xtype: 'box',
                    width:320,
                    height:118,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-arrows icon_arrow_orange'},
                    x:460,
                    y:100
                    },
                    {
                    xtype: 'box',
                    width:317,
                    height:121,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-arrows-green icon_arrow_green'},
                    x:100,
                    y:340
                    },
                    {
                    xtype: 'box',
                    width:317,
                    height:121,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-arrows-green icon_arrow_green'},
                    x:460,
                    y:340
                    },
                    {
                    xtype: 'box',
                    autoEl: {tag:'a',html:labels_json.home.text_vendor,cls:'center-menus icon_vendors'},
                    x:60,
                    y:230,
                    listeners: {
                        el: {
                            mouseover: function(ev){
                                ev.preventDefault();
                                showMenu('#vendor_menu,,#vendor_menu1');
                            },
                            mouseout:function(ev){
                                ev.preventDefault();
                                clearTime();
                            }
                        }
                    }
                }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'vendor_menu1',
                    x:60,
                    y:150,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_expense_management +'<div>'+labels_json.home.text_expense_management_detail+'</div></a>', 
                        listeners:{
                            el:{
                                click:function(){
                                   if(user_right==1){
                                        getPanel(json_urls.expense_list,'expenses-panel',{grids:['expense-panel-grid']});  
                                    } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.expenses.actions.access){
                                        getPanel(json_urls.expense_list,'expenses-panel',{grids:['expense-panel-grid']});
                                    } else {
                                        Ext.Msg.show({
                                            title:'User Access Conformation',
                                            msg:'You have no access to open this Page',
                                            buttons:Ext.Msg.OK,
                                            callback:function(btn) {
                                                if('ok' === btn) {
                                                }
                                            }
                                        });
                                    }
                                }
                                                                        
                                    
                                }
                            }
                        }
                    }]
                },{

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'vendor_menu2',
                    x:60,
                    y:140,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>Groups <div>Manage Vendor <br/>in groups.</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                   getPanel(json_urls.vendors_group,'vendor-group-panel');                                    
                                }
                            }
                        }
                    }]
                }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'vendor_menu',
                    x:60,
                    y:350,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_new_vendor +'<div>'+labels_json.home.text_new_vendor_detail+'</div></a>', 
                        listeners:{
                            el:{
                                click:function(){
                                    
                                    if(user_right==1){
                                        getPanel(json_urls.vendors,'vendor-panel');   
                                    } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.newvendor.actions.view){
                                        getPanel(json_urls.vendors,'vendor-panel');
                                    } else {
                                        Ext.Msg.show({
                                            title:'User Access Conformation',
                                            msg:'You have no access to open this Page',
                                            buttons:Ext.Msg.OK,
                                            callback:function(btn) {
                                                if('ok' === btn) {
                                                }
                                            }
                                        });
                                    }
                                }
                                    
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_vendor_list +'<div>'+labels_json.home.text_vendor_list_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    
                                    if(user_right==1){
                                        getPanel(json_urls.vendor_list,'vendor-grid',{grids:['vendor-grid-grid']});  
                                    } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.customervendorlist.actions.access){
                                        getPanel(json_urls.vendor_list,'vendor-grid',{grids:['vendor-grid-grid']});
                                    } else {
                                        Ext.Msg.show({
                                            title:'User Access Conformation',
                                            msg:'You have no access to open this Page',
                                            buttons:Ext.Msg.OK,
                                            callback:function(btn) {
                                                if('ok' === btn) {
                                                }
                                            }
                                        });
                                    }
                                }
                                }
                            }
                        }
                    }]
                },
                {
                    xtype: 'box',
                    width:81,
                    height:9,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-dots icon_dots_orange'},
                    x:140,
                    y:265
                 }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'po_menu2',
                    x:210,
                    y:150,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_purchase_return +'<div>'+labels_json.home.text_purchase_return_detail+'</div></a>', 
                        listeners:{
                            el:{
                                click:function(){
                                    purchase_invoice_return_mode = 1;
                                    if(user_right==1){
                                     getPanel(json_urls.purchase_invoice,'purchase-invoice-panel');   
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_return.actions.view){
                                        getPanel(json_urls.purchase_invoice,'purchase-invoice-panel');
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });
                                        }
                                    }
                                    
                                    
                                }
                            }
                        }
                    }]
                },
               {
                    xtype: 'box',
                    autoEl: {tag:'a',html:labels_json.home.text_purchase_order,cls:'center-menus icon_po'},
                    y:230,
                    x:210,
                    listeners: {
                        el: {
                            mouseover: function(ev){
                                ev.preventDefault();
                                showMenu('#po_menu,#po_menu2');

                            },
                            mouseout:function(ev){
                                ev.preventDefault();
                                clearTime();
                            }
                        }
                    }
                }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'po_menu',
                    x:210,
                    y:350,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_new_purchase_order +'<div>'+labels_json.home.text_new_purchase_order_detail+'</div></a>', 
                        listeners:{
                            el:{
                                click:function(){
                                    purchase_invoice_return_mode = 0;
                                    if(user_right==1){
                                    getPanel(json_urls.purchase_invoice,'purchase-invoice-panel');    
                                    } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_invoice.actions.view){
                                        getPanel(json_urls.purchase_invoice,'purchase-invoice-panel');
                                    } else {
                                        Ext.Msg.show({
                                            title:'User Access Conformation',
                                            msg:'You have no access to open this Page',
                                            buttons:Ext.Msg.OK,
                                            callback:function(btn) {
                                                if('ok' === btn) {
                                                }
                                            }
                                        });
                                    }
                                }
                                    
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_purchase_order_list +'<div>'+labels_json.home.text_purchase_order_list_detail+'</div></a>',
                         listeners:{
                            el:{
                                click:function(){
                                    
                                    if(user_right==1){
                                        getPanel(json_urls.purchase_list,'purchase-grid');  
                                    } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_order_list.actions.access){
                                        getPanel(json_urls.purchase_list,'purchase-grid');
                                    } else {
                                        Ext.Msg.show({
                                            title:'User Access Conformation',
                                            msg:'You have no access to open this Page',
                                            buttons:Ext.Msg.OK,
                                            callback:function(btn) {
                                                if('ok' === btn) {
                                                }
                                            }
                                        });
                                    }
                                }
                                }
                            }
                        }
                    }]
                },
                {
                    xtype: 'box',
                    width:81,
                    height:9,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-dots icon_dots_orange'},
                    x:310,
                    y:265
                 },{
                    xtype: 'box',
                    autoEl: {tag:'a',html:labels_json.home.text_inventory,cls:'center-menus icon_items'},
                    y:230,
                    x:400,
                    listeners: {
                        el: {
                            mouseover: function(ev){
                                ev.preventDefault();
                                showMenu('#items_menu,#items_menu2');
                                
                            },
                            mouseout:function(ev){
                                ev.preventDefault();
                                clearTime();
                            }
                        }
                    }
                }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'items_menu2',
                    x:400,
                    y:10,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        id:'adjust',
                        html: '<a>'+labels_json.home.text_adjust_stock +'<div>'+labels_json.home.text_adjust_stock_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                     getPanel(json_urls.items_adjust_list,'stock-adjust-panel',{grids:['stockadjust-panel-grid']});   
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.adjuststock.actions.access){
                                        getPanel(json_urls.items_adjust_list,'stock-adjust-panel',{grids:['stockadjust-panel-grid']});   
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        id:'transfer',
                        html: '<a>'+labels_json.home.text_stock_transfer +'<div>'+labels_json.home.text_stock_transfer_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                        getPanel(json_urls.stock_transfer,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.stocktransfer.actions.access){
                                        getPanel(json_urls.stock_transfer,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});   
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                    
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        id:'showWarehouse',
                        html: '<a>'+labels_json.home.text_warehouses +'<div>'+labels_json.home.text_warehouses_detail+'</div></a>' ,
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                            getPanel(json_urls.warehouse_list,'warehouses-panel',{grids:['warehouse-panel-grid']});
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.warehouses.actions.access){
                                            getPanel(json_urls.warehouse_list,'warehouses-panel',{grids:['warehouse-panel-grid']});
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                     
                                }
                            }
                        }
                    }]
                },{

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'items_menu',
                    x:400,
                    y:350,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_newproduct +'<div>'+labels_json.home.text_newproduct_detail+'</div></a>' ,
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                     getPanel(json_urls.items,'item-panel',{grids:['item-panel-grid']});   
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.item.actions.view){
                                        getPanel(json_urls.items,'item-panel',{grids:['item-panel-grid']});
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });
                                        }
                                    }
                                    
                                    
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_productlist +'<div>'+labels_json.home.text_productlist_detail+'</div></a>' ,
                        listeners:{
                            el:{
                                click:function(){
                                    
                                    if(user_right==1){
                                            getPanel(json_urls.item_list,'item-grid',{grids:['item-grid-grid']});
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.productlist.actions.access){
                                            getPanel(json_urls.item_list,'item-grid',{grids:['item-grid-grid']});;
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                }
                            }
                        }
                    }]
                },
                {
                    xtype: 'box',
                    width:81,
                    height:9,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-dots icon_dots_green'},
                    x:485,
                    y:265
                 },{
                    xtype: 'box',
                    autoEl: {tag:'a',html:labels_json.home.text_sale_order,cls:'center-menus icon_so'},
                    y:230,
                    x:570,
                    listeners: {
                        el: {
                            mouseover: function(ev){
                                ev.preventDefault();
                                showMenu('#so_menu,#so_menu2');

                            },
                            mouseout:function(ev){
                                ev.preventDefault();
                                clearTime();
                            }
                        }
                    }
                },{

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'so_menu2',
                    x:570,
                    y:10,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                                xtype: 'component',
                                autoEl: 'li',
                                html: '<a>'+labels_json.home.text_batch_print +'<div>'+labels_json.home.text_batch_print_detail+'</div></a>',
                                listeners:{
                                    el:{
                                        click:function(){  
                                            if(user_right==1){
                                            getPanel(json_urls.batch_sales_invoices,'batch-sales-panel',{grids:[]});
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.batch_printing.actions.access){
                                            getPanel(json_urls.batch_sales_invoices,'batch-sales-panel',{grids:[]});
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                             
                                        }
                                    }
                                }
                            },
                            {
                                xtype: 'component',
                                autoEl: 'li',
                                html: '<a>'+labels_json.home.text_sale_return +'<div>'+labels_json.home.text_sale_return_detail+'</div></a>',
                                listeners:{
                                    el:{
                                        click:function(){                     
                                            sale_invoice_mode = 1; //Set 1 for Sale Return
                                            if(user_right==1){
                                               getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']}); 
                                            } else {
                                                if(Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_return.actions.view){
                                                    getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});
                                                    } else {
                                                        Ext.Msg.show({
                                                    title:'User Access Conformation',
                                                    msg:'You have no access to open this Page',
                                                    buttons:Ext.Msg.OK,
                                                    callback:function(btn) {
                                                        if('ok' === btn) {
                                                        }
                                                    }
                                                });
                                            }
                                            }
                                        }
                                    }
                                }
                            },
                            {
                                xtype: 'component',
                                autoEl: 'li',
                                html: '<a>'+labels_json.home.text_sale_estimate +'<div>'+labels_json.home.text_sale_estimate_detail+'</div></a>',
                                listeners:{
                                    el:{
                                        click:function(){                     
                                            sale_invoice_mode = 2; //Set 2 for estimate
                                            if(user_right==1){
                                             getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});   
                                            } else {
                                                if(Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_estimate.actions.view){
                                                    getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});
                                                    } else {
                                                        Ext.Msg.show({
                                                    title:'User Access Conformation',
                                                    msg:'You have no access to open this Page',
                                                    buttons:Ext.Msg.OK,
                                                    callback:function(btn) {
                                                        if('ok' === btn) {
                                                        }
                                                    }
                                                });
                                                    }
                                            }
                                                                                         
                                        }
                                    }
                                }
                            }
                    ]
                }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'so_menu',
                    x:570,
                    y:350,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_sale_invoice +'<div>'+labels_json.home.text_sale_invoice_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    sale_invoice_mode = 0;
                                    if(user_right==1){
                                      getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});  
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.view){
                                            getPanel(json_urls.sale_invoice,'sale-invoice-panel',{grids:['sale-invoice-panel-grid']});
                                            } else {
                                                Ext.Msg.show({
                                                    title:'User Access Conformation',
                                                    msg:'You have no access to open this Page',
                                                    buttons:Ext.Msg.OK,
                                                    callback:function(btn) {
                                                        if('ok' === btn) {
                                                        }
                                                    }
                                                });
                                            }
                                    }
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_sale_invoice_list +'<div>'+labels_json.home.text_sale_invoice_list_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                            getPanel(json_urls.order_list,'order-grid',{grids:['order-grid-grid']});
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_order_list.actions.access){
                                            getPanel(json_urls.order_list,'order-grid',{grids:['order-grid-grid']});
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                    
                                    
                                }
                            }
                        }
                    }]
                },
                {
                    xtype: 'box',
                    width:81,
                    height:9,
                    autoEl: {tag:'div',html:'&nbsp;',cls:'center-dots icon_dots_green'},
                    x:660,
                    y:265
                 },{
                    xtype: 'box',
                    autoEl: {tag:'a',html:labels_json.home.text_customer,cls:'center-menus icon_customers'},
                    y:230,
                    x:740,
                    listeners: {
                        el: {
                            mouseover: function(ev){
                                ev.preventDefault();
                                showMenu('#customer_menu,#customer_menu2');

                            },
                            mouseout:function(ev){
                                ev.preventDefault();
                                clearTime();
                            }
                        }
                    }
                },{

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'customer_menu2',
                    x:740,
                    y:70,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [
                            {
                            xtype: 'component',
                            autoEl: 'li',
                            html: '<a>'+labels_json.home.text_customer_type +'<div>'+labels_json.home.text_customer_type_detail+'</div></a>',
                            listeners:{
                                el:{
                                    click:function(){
                                        if(user_right==1){
                                            getPanel(json_urls.customer_type,'customer-type-panel');
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.customertypegroup.actions.access){
                                            getPanel(json_urls.customer_type,'customer-type-panel');
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                                                           
                                    }
                                }
                            }
                        }
                        ,{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_customer_group +'<div>'+labels_json.home.text_customer_group_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                            getPanel(json_urls.customer_group,'customer-group-panel');
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.customertypegroup.actions.access){
                                            getPanel(json_urls.customer_group,'customer-group-panel');
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                                                       
                                }
                            }
                        }
                    }]
                }, {

                    xtype: 'container',
                    autoEl: 'ul',
                    id:'customer_menu',
                    x:740,
                    y:350,
                    width:140,
                    cls: 'ux-unordered-list menu',
                    items: [{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_new_customer +'<div>'+labels_json.home.text_new_customer_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                            getPanel(json_urls.customers,'customer-panel');
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.newcustomer.actions.access){
                                            getPanel(json_urls.customers,'customer-panel');
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                    
                                    
                                }
                            }
                        }
                    },{
                        xtype: 'component',
                        autoEl: 'li',
                        html: '<a>'+labels_json.home.text_customer_list +'<div>'+labels_json.home.text_customer_list_detail+'</div></a>',
                        listeners:{
                            el:{
                                click:function(){
                                    if(user_right==1){
                                            getPanel(json_urls.customer_list,'customer-grid',{grids:['customer-grid-grid']});
                                    } else {
                                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.customervendorlist.actions.access){
                                            getPanel(json_urls.customer_list,'customer-grid',{grids:['customer-grid-grid']});
                                        } else {
                                            Ext.Msg.show({
                                                title:'User Access Conformation',
                                                msg:'You have no access to open this Page',
                                                buttons:Ext.Msg.OK,
                                                callback:function(btn) {
                                                    if('ok' === btn) {
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                    
                                    
                                }
                            }
                        }
                    }]
                }


            ],
            listeners: {

                }
            }]
    }
})