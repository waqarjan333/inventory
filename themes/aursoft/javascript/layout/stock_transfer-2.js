_tstrock={
    id: 'stock-transfer-panel',
    layout: 'border',
    closable: true,
    closeAction: 'hide',
    frame: true,
    title:"Stock Transfer",
    listeners: {
        
        hide:function(){
          if(user_right=="3")  {
              window.location.href = urls.logout;
          }
        },
        afterrender: function (obj) {
            editModelSO = Ext.getCmp("stock-transfer-grid").plugins[0];
            // editModelPick = Ext.getCmp("pick_invoice_grid").plugins[0];
            
            var _view = Ext.getCmp("stock-transfer-grid").getView();
            if(user_right!=="3")  {
            Ext.create('Ext.tip.ToolTip', {        
                title: '<h3 class="popover-title">Item Info.</h3>',                        
                target: _view.el,
                delegate:"img.y-action-col-icon",
                anchor: 'left',
                cls:'callout',
                trackMouse: true,
                html: null,
                width: 250,
                autoHide: true,
                closable: true,                
                listeners: {                    
                    beforeshow: function updateTipBody(tip) {                        
                        OBJ_Action.populateTooltip(tip);                        
                    }
                }
            });
        }
            

        },
        show: function () {
            Ext.getCmp("stock-transfer-grid").store.removeAll();
            // Ext.getCmp("pick_invoice_grid").store.removeAll();
            // Ext.getCmp("invoice_invoice_grid").store.removeAll();
           
            // if(!Ext.getCmp("customers_combo").getValue()){
            //     Ext.getCmp("load_estimates_button").setDisabled(false);
            // }
          

            /*Pay window*/
           
            /*End Discount window*/
            OBJ_Action.addMewInvoiceRow = false;
            OBJ_Action.searchKeyPress = 0;
            OBJ_Action.searchChange = 0;
            OBJ_Action.shiftFocus = false;
            OBJ_Action.tabpressed = false;
            // OBJ_Action.previousOrderID = last_id.sale_last_invoice;
        
            OBJ_Action.getDateMysqlFormatWithTime = function (objDate) {
                var currentdate = objDate;
                var cdate = "";
                if (objDate) {
                    var cdate = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + "-" + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
                }
                return cdate;
            }


            
            OBJ_Action.editRecordRow = function(e,obj){
                
                if (parseInt(Ext.getCmp("so_order_status").getValue()) === 4) {
                    editModelSO.cancelEdit();
                    return false;
                }
                else {

                    if(user_right!=="3")  {
                    Ext.defer(function(){
                        Ext.create('Ext.tip.ToolTip', {        
                        title: '<h3 class="popover-title">Item Info.</h3>',                        
                        target: Ext.select(".x-grid-row-editor .y-action-col-icon").elements[0],                                                                      
                        anchor: 'left',
                        cls:'callout',
                        trackMouse: true,
                        html: null,
                        width: 250,
                        autoHide: true,
                        closable: true,                                                                            
                        listeners: {
                            'render': function(){},
                            beforeshow: function updateTipBody(tip) {
                                OBJ_Action.populateTooltip(tip)
                            }
                        }
                    });
                   },200);
                    }
                    if (!OBJ_Action.addMewInvoiceRow) {                                                                                                                                                
                        Ext.getCmp("item_quantity_so").setDisabled(false);
                        Ext.getCmp("item_price_so").setDisabled(false);
                        Ext.getCmp("item_discount_so").setDisabled(false);
                        Ext.getCmp("item_net_so").setDisabled(false);
                        Ext.getCmp("item_subtotal_so").setDisabled(false);
                        Ext.getCmp("item_name_so").setEditable(false); 
                        Ext.getCmp("sale_item_uom").setDisabled(false);
                        Ext.getCmp("warehouse_so").setDisabled(false);                                                
                        //set uom on edit.
                        var grid = e.grid;
                        var rec = grid.getStore().getAt(obj.rowIdx);                                                                                                                                      
                        var data = rec.raw.item_units;
                        if(data){
                            uom_store_temp.removeAll();
                            for(var i=0;i<data.length;i++){
                                uom_store_temp.add(data[i]);                                                                                                                                                                
                            }                                                                    
                        }
                    }
                    else {
                        OBJ_Action.addMewInvoiceRow = false;
                    }                                                                    
                }
            }
   
            OBJ_Action.onComplete = function () {
                OBJ_Action.setDisableControls();
            };

            
            OBJ_Action.changeItemName = function (record) {
                Ext.getCmp("item_quantity_so").setDisabled(false);                                                                        
                Ext.getCmp("item_price_so").setDisabled(false);
                Ext.getCmp("item_discount_so").setDisabled(false);
                Ext.getCmp("item_net_so").setDisabled(false);
                Ext.getCmp("item_subtotal_so").setDisabled(false);
                Ext.getCmp("item_name_so").setEditable(false);
                Ext.getCmp("warehouse_so").setDisabled(false);
                Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
                Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));                                                                                                                                                        
                var adj = OBJ_Action.getAdjustedPrice(record);
                Ext.getCmp("item_discount_so").setValue(adj.discount + "%");
                var sel = Ext.getCmp('stock-transfer-grid').getSelectionModel().getSelection()[0];
                sel.set("item_id", record.get("id"));
                sel.set("item_weight", parseFloat(record.get("weight")));
                sel.set("discount", parseFloat(adj.discount));
                OBJ_Action.recordChange();
                // OBJ_Action.calc.calRowSubTotal();                                                                            
                Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);
            }
            OBJ_Action.setDisableControls = function (isNew) {
                /*if(parseInt(Ext.getCmp("so_order_status").getValue())==4){
                 Ext.getCmp("customers_combo").disable();
                 Ext.getCmp("customer_mobile").disable();
                 Ext.getCmp("customer_contact").disable();
                 Ext.getCmp("so_date").disable();                                        
                 Ext.getCmp("so_remarks").disable();                                        
                 Ext.getCmp("so_payment_paid").disable();
                 Ext.getCmp("so_new_item").disable();
                 Ext.getCmp("so_del_item").disable();
                 Ext.getCmp("tb_btn_copy").disable();
                 Ext.getCmp("tb_btn_save").disable();
                 Ext.getCmp("tb_btn_save_new").disable();
                 Ext.getCmp("tb_btn_reopen").enable();
                 Ext.getCmp("so_autofill_rec_btn").disable();
                 Ext.getCmp("so_complete_rec_btn").disable();
                 }
                 else{
                 Ext.getCmp("customers_combo").enable();
                 Ext.getCmp("customer_mobile").enable();
                 Ext.getCmp("customer_contact").enable();
                 Ext.getCmp("so_date").enable();                                        
                 Ext.getCmp("so_remarks").enable();                                        
                 Ext.getCmp("so_payment_paid").enable();
                 Ext.getCmp("so_new_item").enable();
                 Ext.getCmp("so_del_item").enable();
                 Ext.getCmp("tb_btn_copy").enable();
                 Ext.getCmp("tb_btn_save").enable();
                 Ext.getCmp("tb_btn_save_new").enable();
                 Ext.getCmp("tb_btn_reopen").disable();
                 if(Ext.getCmp("so_hidden_id").getValue()!==""){
                 Ext.getCmp("so_tab_panel").down('#so_pick_panel').setDisabled(false);
                 Ext.getCmp("so_tab_panel").down('#so_payment_panel').setDisabled(false);
                 }
                 if(isNew){
                 Ext.getCmp("so_tab_panel").down('#so_pick_panel').setDisabled(true);
                 Ext.getCmp("so_tab_panel").down('#so_payment_panel').setDisabled(true);
                 Ext.getCmp("so_tab_panel").setActiveTab(0);
                 }
                 }*/

            }
            OBJ_Action.calc = {
               
               
                calGrid: function () {
                    var grid_items = Ext.getCmp('stock-transfer-grid').store.data.items;
                    var discount = 0;
                    var _weight = 0;
                    for (var i = 0; i < grid_items.length; i++) {
                        var p = parseFloat(grid_items[i].get("unit_price"));
                        var q = parseFloat(grid_items[i].get("item_quantity"));
                        var d = parseFloat(grid_items[i].get("discount"));
                        var sub_total = parseFloat(grid_items[i].get("sub_total"));
                        var dPrice = p - (p * d / 100);
                        var total = q * dPrice;
                        discount = discount + (p * d / 100);
                        grid_items[i].set("net_price", Ext.util.Format.number(dPrice, "0.00"));
                        grid_items[i].set("sub_total", Ext.util.Format.number(sub_total, "0.00"));

                        try {
                            if (grid_items[0].get("weight")) {
                                _weight = _weight + parseFloat(grid_items[i].get("weight")) * q;
                            }
                            else {
                                _weight = _weight + parseFloat(item_store.getById(grid_items[i].get("item_id")).get("weight") * q)
                            }
                        }
                        catch (e) {

                        }
                    }
                    Ext.getCmp("so_discount_items").setValue(Ext.util.Format.number(discount, "0.00"));
                    Ext.getCmp('_so_weight').setValue(Ext.util.Format.number(_weight, "0.00"));
                    if (_weight > 0) {
                        //Ext.getCmp('stock-transfer-grid').columns[3].setVisible(true);                       
                        Ext.Function.defer(OBJ_Action.calc.showHideWeight, 400, this, [true]);
                    }


                }
                ,
                calcBalance: function () {
                    var _total = Ext.getCmp("so_total").getValue();
                    _total = parseFloat(_total);
                    
                    var _paid = parseFloat(Ext.getCmp("so_paid").getValue());
                    
                    // var _dis = parseFloat(Ext.getCmp("so_discount_invoice_2").getValue());
                    var _dis = parseFloat(Ext.getCmp("so_discount_invoice").getValue());
                    
                    var _balance = _total - _paid - _dis;
                    _balance = Ext.util.Format.number(parseFloat(_balance), "0.00");
                    Ext.getCmp("so_total_balance").setValue(_balance);
                    var grand_total = parseFloat(_balance) + parseFloat(Ext.getCmp("prev_total_balance").getValue())
                    Ext.getCmp("grand_total_balance").setValue(Ext.util.Format.number(grand_total, "0.00"))
                    

                    OBJ_Action.recordChange();
                }
                ,
                removeRecord: function (grid_id) {
                    Ext.getCmp(grid_id).store.remove(Ext.getCmp(grid_id).getSelectionModel().getSelection()[0]);
                    OBJ_Action.calc.calTotalSubTotal();
                    OBJ_Action.recordChange();
                }
            }
               
            OBJ_Action.addRecord = function () {
                if(Ext.getCmp("customers_combo").getValue()){
                var current_tab = Ext.getCmp("so_tab_panel").items.indexOf(Ext.getCmp("so_tab_panel").getActiveTab());
                if (current_tab == 0) {
                    editModelSO.cancelEdit();       
                    Ext.getCmp("item_quantity_so").setDisabled(true);
                    Ext.getCmp("item_price_so").setDisabled(true);
                    Ext.getCmp("item_discount_so").setDisabled(true);
                    Ext.getCmp("item_net_so").setDisabled(true);
                    Ext.getCmp("item_subtotal_so").setDisabled(true);
                    Ext.getCmp("item_name_so").setEditable(true);
                    Ext.getCmp("warehouse_so").setDisabled(true);
                    editModelSO.cancelEdit();
                    var r = Ext.create('modelSaleInvoice', {
                        item_name: '----------------',
                        item_quantity: sale_invoice_mode==1 ? '-1' : '1',
                        unit_id:"1",
                        unit_name:"Each",
                        warehouse_name:"Default Location",
                        unit_price: '0.00',
                        normal_price: '0.00',
                        net_price: '0.00',
                        discount: '0%',
                        sub_total: '0.00'
                    });
                    OBJ_Action.addMewInvoiceRow = true;
                    var startEditAt = Ext.getCmp("stock-transfer-grid").store.getCount();
                    
                    Ext.getCmp("stock-transfer-grid").store.insert(startEditAt, r);
                    
                    editModelSO.startEdit(startEditAt, 0);
                    
                    Ext.getCmp("item_name_so").focus(true, 10, function () {
                        Ext.getCmp("item_name_so").setValue("");
                        var sel = Ext.getCmp('stock-transfer-grid').getSelectionModel().getSelection()[0];
                        console.log(sel);
                        sel.set("item_name", '');                        
                        Ext.getCmp("item_name_so").allowBlank=false;
                        item_store.removeAll();
                        item_store.clearFilter();
                        item_store.load({query:''});
                        OBJ_Action.shiftFocus = false;
                        OBJ_Action.searchKeyPress = 0;
                        OBJ_Action.searchChange = 0;    
                        if(Ext.getBody().select(".x-boundlist").elements.length){    
                        Ext.getBody().select(".x-boundlist").elements[0].style.display="none";
                      }
                    });
                    
                   
                   
                }
            }
            }


        }
    },
   
    items: [{
            region: 'west',
            width: 250,
            title: "Search",
            split: true,
            collapsible: true,
            collapsed: true,
            id: 'sale_left_panel',
            layout: 'border',
            listeners: {
                
            }

        }, {
            region: 'center',
            layout: 'fit',
            border: false,
            bodyBorder: false,
            items: new Ext.FormPanel({
                layout: 'border',
                id: 'stock-transfer-panel-form',
                bodyBorder: false,
                defaults: {
                    border: false
                }
                ,
                items: [{
                        region: 'north',
                        height: 100,
                        layout: 'column',
                        defaults: {
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%'
                            }
                        },
                        items: [{
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                defaults: {
                            layout: {
                                type: 'hbox',
                                defaultMargins: {
                                    top: 0,
                                    right: 5,
                                    bottom: 0,
                                    left: 0
                                }
                            }
                        },
                                items: [
                                    {
                                        xtype: 'fieldcontainer',
                                        combineErrors: true,
                                        msgTarget: 'side',
                                        id: 'customer_region',
                                        fieldLabel: "Customer",
                                        defaults: {
                                            hideLabel: true
                                        },
                                items: [
                                    {
                                        xtype: 'combo',
                                        fieldLabel: '',
                                        id: 'customers_combo',
                                        name: 'customer_id',
                                        allowBlank: false,
                                        forceSelection: true,
                                        valueField: 'cust_id',
                                        tabIndex: 1,
                                        flex: 1,
                                        displayField: 'cust_name',
                                        emptyText: 'Select a Customer...',
                                        store: customer_store_active,
                                        queryMode: 'local',
                                        listeners: {
                                        }
                                    }
                                ]
                            },
                                    {
                                        layout: {
                                            type: 'table',
                                            columns: 3,
                                            tableAttrs: {
                                                width: '200px'
                                            }
                                        },
                                        border: false,
                                        bodyBorder: false,
                                        id: 'so_action_btn_panel',
                                        margin: '12 0 0 0',
                                        items: [ {
                                                xtype: 'button',
                                                text: "Add Item",
                                                iconCls: 'add_new',                                                
                                                id: 'so_new_item',
                                                width: 100,
                                                listeners: {
                                                    click: function () {
                                                        OBJ_Action.addRecord();
                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'button',
                                                text: "Delete",
                                                margin: '0 0 0 5',
                                                iconCls: 'delete',
                                                id: 'so_del_item',
                                                width: 110,
                                                listeners: {
                                                    click: function () {
                                                        var current_tab = Ext.getCmp("so_tab_panel").items.indexOf(Ext.getCmp("so_tab_panel").getActiveTab());
                                                        if (current_tab == 0) {
                                                            OBJ_Action.calc.removeRecord('stock-transfer-grid');
                                                        }
                                                        else {
                                                            // OBJ_Action.calc.removeRecord('pick_invoice_grid');
                                                        }
                                                    }
                                                }
                                            },{
                                                xtype: 'button',
                                                text: "Create Item",
                                                id: 'so__create_item',
                                                margin: '0 0 0 5',
                                                iconCls: 'new',
                                                width: 90,
                                                listeners: {
                                                    click: function () {
                                                        new_item_form.show();
                                                    }
                                                }
                                            }]


                                    }
                                ]
                            }
                        ]
                    }, {
                        region: 'center',
                        xtype: 'tabpanel',
                        tabPosition: 'bottom',
                        id: 'so_tab_panel',
                        bodyBorder: false,
                        border: false,
                        defaults: {
                            border: false,
                            bodyBorder: false,
                            listeners: {
                                // activate: function (tab, eOpts) {
                                //     if (tab.title === "Sale") {
                                //         Ext.get("so_action_btn_panel").setStyle("display", "block");
                                //     }
                                //     else if (tab.title === "Pick") {
                                //         Ext.get("so_action_btn_panel").setStyle("display", "block");
                                //         var _data = Ext.getCmp('stock-transfer-grid').store.data;
                                //         so_receive_item_store.loadData(Ext.pluck(_data.items, 'data'));
                                //     }
                                //     else if (tab.title === "Invoice") {
                                //         Ext.get("so_action_btn_panel").setStyle("display", "none");
                                //         OBJ_Action.payment();
                                //     }
                                // }
                            }
                        },
                        items: [
                            {
                                title: "Transfer",
                                layout: 'border',
                                bodyBorder: false,
                                id: 'so_sale_panel',
                                border: false,
                                defaults: {
                                    border: false,
                                    bodyBorder: false
                                },
                                items: [
                                    {
                                        region: 'center',
                                        layout: 'fit',
                                        items: [{
                                                xtype: "gridpanel",
                                                tabIndex: 4,
                                                id: "stock-transfer-grid",
                                                plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                                        clicksToMoveEditor: 1,
                                                        autoCancel: false,
                                                        listeners: {
                                                            'canceledit': function (e) {
                                                                OBJ_Action.searchKeyPress = 0;
                                                                OBJ_Action.searchChange = 0;
                                                                OBJ_Action.shiftFocus = false;
                                                                
                                                                if (Ext.getCmp("item_name_so").getValue() === "----------------") {                                                                
                                                                    
                                                                    var grid = e.grid;
                                                                    var rowIndex = -1;
                                                                    var _data = Ext.getCmp('stock-transfer-grid').store.data;
                                                                    var _items = _data.items;
                                                                    for(var i=0;i<_items.length;i++){
                                                                        if(_items[i].get("item_name")==""){
                                                                            rowIndex = i;
                                                                        }
                                                                    }
                                                                    if(rowIndex!==-1){
                                                                        var rec = grid.getStore().getAt(rowIndex);
                                                                        grid.store.remove(rec);
                                                                        if (e.grid.store.getCount() > 0) {
                                                                            //sm.select(0);
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            ,
                                                            'edit': function (e) {
                                                                var qty = parseFloat(Ext.getCmp("item_quantity_so").getValue());
                                                                var unit_price = parseFloat(Ext.getCmp("item_net_so").getValue());                                      
                                                                var sel = e.grid.getSelectionModel().getSelection()[0];
                                                                var ware_qty='';    
                                                                var ware_name='';  
                                                                var other_ware='';  
                                                                var record = item_store.getById(sel.get("item_id")); 
                                                                var data=record.get('item_warehouses');
                                                                        for(var i=0;i<data.length;i++){

                                                                            other_ware +="<li>"+data[i].warehouse_name+": "+data[i].qty+" </li>";
                                                                            if(sel.get("ware_id")==data[i].ware_id){
                                                                                  ware_qty=data[i].qty;  
                                                                                  ware_name=data[i].warehouse_name;  
                                                                                     }
                                                                            }                                                              
                                                                try{
                                                                    if(record.get("type")!=="3"){
                                                                    
                                                                    
                                                                    if ( qty > parseFloat(ware_qty/sel.get("conv_from"))) {
                                                                        
                                                                        
                                                                        Ext.Msg.show({
                                                                            title: 'Stock Warning',
                                                                            msg: 'You have ' + parseFloat(ware_qty/sel.get("conv_from")).toFixed(2) + ' quantity in '+ware_name+' Warehouse for "' + Ext.getCmp("item_name_so").getValue() + '".'+
                                                                             'Do you want to continue with entered quantity?<br>'+
                                                                              'Your Other Warehouses <b>"'+Ext.getCmp("item_name_so").getValue()+'"</b> Quantity is Present in <ol>'+other_ware+'</ol> ',
                                                                            buttons: Ext.Msg.YESNO,
                                                                            icon: Ext.Msg.WARNING,
                                                                            fn: function (btn, text) {
                                                                                if (btn == 'no') {
                                                                                    editModelSO.startEdit(sel, 1);
                                                                                    return false;
                                                                                }
                                                                                OBJ_Action.calc.calTotalSubTotal();
                                                                                OBJ_Action.addRecord();
                                                                            }
                                                                        });                                                                    
                                                                    }


                                                                    else if ( unit_price < parseFloat(sel.get("normal_price"))) {
                                                                        Ext.Msg.show({
                                                                            title: 'Price Warning',
                                                                            msg: 'Net price ' + unit_price + ' is less than purchase price "' + sel.get("normal_price") + '". Do you want to continue?',
                                                                            buttons: Ext.Msg.YESNO,
                                                                            icon: Ext.Msg.WARNING,
                                                                            fn: function (btn, text) {
                                                                                if (btn == 'no') {
                                                                                    editModelSO.startEdit(sel, 1);
                                                                                    return false;
                                                                                }
                                                                                OBJ_Action.calc.calTotalSubTotal();
                                                                                OBJ_Action.addRecord();
                                                                            }
                                                                        });   
                                                                    }
                                                                    else {                                                                            
                                                                        OBJ_Action.calc.calTotalSubTotal();
                                                                        OBJ_Action.addRecord();
                                                                    }
                                                                }
                                                                else{
                                                                        OBJ_Action.calc.calTotalSubTotal();
                                                                        OBJ_Action.addRecord();
                                                                }
                                                                    
                                                                }
                                                                catch(e){                                                                    
                                                                    OBJ_Action.calc.calTotalSubTotal();
                                                                    OBJ_Action.addRecord();
                                                                }
                                                            },
                                                            'beforeedit': function (e,obj) {
                                                             
                                                                        OBJ_Action.editRecordRow(e,obj); 
                                                             },       
                                                            validateedit: function(){
                                                                if(OBJ_Action.searchKeyPress > OBJ_Action.searchChange){
                                                                    return false;
                                                                }

                                                            }
                                                        }
                                                    })],
                                                margin: '2 5 2 5',
                                                store: {
                                                    proxy: {
                                                        type: "memory",
                                                        reader: {
                                                            type: "json"
                                                        }
                                                    },
                                                    model: Ext.define("modelSaleInvoice", {
                                                        extend: "Ext.data.Model",
                                                        fields: [
                                                            "item_name",
                                                            "item_id",
                                                            "item_quantity",
                                                            "conv_from",
                                                            "unit_name",
                                                            "unit_id",
                                                            "unit_price"
                                                            {
                                                                name: "sub_total",
                                                                type: 'float',
                                                                convert: function (v, rec) {
                                                                    return Ext.util.Format.number(v, "0.00")
                                                                }
                                                            }

                                                        ]
                                                    }) && "modelSaleInvoice",
                                                    data: []
                                                },
                                                listeners: {
                                                    afterRender: function (obj) {
                                                        //this.superclass.afterRender.call(this);
                                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                                            del: function (e) {
                                                                OBJ_Action.calc.removeRecord('stock-transfer-grid');
                                                            }
                                                        });                                                                                                                                                                                                                               
                                                    },
                                                    beforecellclick: function(){
                                                        Ext.getCmp("item_name_so").focus(true);
                                                        return false;
                                                    },
                                                    containerclick: function () {
                                                        editModelSO.cancelEdit();
                                                        OBJ_Action.addRecord();
                                                    },
                                                    itemmouseenter: function (view, record, item,index) {
                                                        OBJ_Action.mouseOverRow = index;                                                                                                                                                                 
                                                    }

                                                },
                                                columnLines: true,
                                                columns: [
                                                    {
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        iconCls:"y-action-col-icon",                                                        
                                                        items: [{                                                                
                                                            icon: 'themes/aursoft/images/star.png'

                                                        }]
                                                        
                                                    },{
                                                        header: "Item",
                                                        dataIndex: "item_name",
                                                        flex: 1,
                                                        editor: {
                                                            xtype: 'combo',
                                                            allowBlank: true,
                                                            listConfig : {
                                                                itemTpl : '<li class="item-row-li"><span> {item} </span> <strong> {barcode} </strong></li>',
                                                            },
                                                            queryMode: 'remote',
                                                            minChars: 2,
                                                            queryDelay: 100,
                                                            displayField: 'item',
                                                            store: item_store,
                                                            triggerAction: 'all',
                                                            pageSize: 50,
                                                            enableKeyEvents:true,
                                                            valueField: 'item',
                                                            emptyText: 'Select an Item...',
                                                            typeAhead: true,
                                                            id: 'item_name_so',
                                                            listeners: {
                                                                change: function (f, obj) {                                                                    
                                                                    if(f.getValue()==""){
                                                                        OBJ_Action.searchKeyPress = 0;
                                                                        OBJ_Action.searchChange = 0;                                                                        
                                                                    }
                                                                    else{
                                                                        OBJ_Action.searchChange = OBJ_Action.searchChange + 1;      
                                                                    }                                                                                                                                                                                                     
                                                                    var record = f.findRecordByValue(f.getValue());                                                                                                                                                
                                                                    
                                                                    
                                                                    if(record){
                                                                        Ext.getCmp("item_quantity_so").setDisabled(false);                                                                        
                                                                        Ext.getCmp("item_price_so").setDisabled(false);
                                                                        Ext.getCmp("sale_item_uom").setDisabled(false);
                                                                            var data =  record.get("item_units");
                                                                            uom_store_temp.removeAll();
                                                                            for(var i=0;i<data.length;i++){
                                                                                uom_store_temp.add(data[i]);
                                                                                if(record.get("sale_item_uom")==data[i].unit_id){
                                                                                    Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));
                                                                                    Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));
                                                                                    Ext.getCmp("sale_item_uom").setValue(data[i].unit_name);
                                                                                    var sel = Ext.getCmp('stock-transfer-grid').getSelectionModel().getSelection()[0];
                                                                                    sel.set("unit_id", data[i].unit_id);
                                                                                    sel.set("unit_name", data[i].unit_name);
                                                                                    sel.set("conv_from", data[i].conv_from);
                                                                                    sel.set("normal_price", Ext.util.Format.number(data[i].nprice, "0.00"));
                                                                                }
                                                                            }
                                                                        
                                                                        var adj = OBJ_Action.getAdjustedPrice(record);
                                                                                        Ext.getCmp("item_discount_so").setValue(adj.discount + "%");
                                                                                        var sel = Ext.getCmp('stock-transfer-grid').getSelectionModel().getSelection()[0];
                                                                                        
                                                                                        sel.set("item_id", record.get("id"));
                                                                                        
                                                                                        sel.set("barcode",record.get("barcode"));
                                                                                        sel.set("qty_on_hand",record.get("qty"));
                                                                                        sel.set("discount", parseFloat(adj.discount));
                                                                                        OBJ_Action.recordChange();
                                                                                        // OBJ_Action.calc.calRowSubTotal();    
                                                                                        
                                                                                        if(OBJ_Action.shiftFocus){                                                                            
                                                                                            Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);                                                                                                                                                                                                                             
                                                                                            OBJ_Action.shiftFocus = false;
                                                                                             OBJ_Action.searchKeyPress = 0;
                                                                                             OBJ_Action.searchChange = 0;       
                                                                                        }
                                                                        } else{
                                                                        Ext.getCmp("item_quantity_so").setDisabled(true);                                                                        
                                                                        Ext.getCmp("item_price_so").setDisabled(true);
                                                                        Ext.getCmp("sale_item_uom").setDisabled(true);
                                                                    }
                                                                    
                                                                },
                                                                keydown: function(obj,e,opts){                                                                    
                                                                    if (e.getKey() == Ext.EventObject.TAB || e.getKey() == Ext.EventObject.ENTER) {
                                                                        OBJ_Action.shiftFocus = true;                                                                        
                                                                    }
                                                                    else{
                                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchKeyPress + 1;                                                                                                                                        
                                                                    }
                                                                },
                                                                focus: function(){                                                                    
                                                                    OBJ_Action.searchKeyPress = 0;
                                                                    OBJ_Action.searchChange = 0;
                                                                    OBJ_Action.shiftFocus = false;
                                                                    Ext.defer(function(){Ext.getCmp("item_name_so").setEditable(true)},100);
                                                                },
                                                                click: function(){
                                                                    OBJ_Action.shiftFocus = false;
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {
                                                        header: "Quantity",
                                                        dataIndex: "item_quantity",
                                                        width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_quantity_so',
                                                            disabled: true,
                                                            maxLength: 9,
                                                            allowBlank: false,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                    // OBJ_Action.calc.calRowSubTotal();
                                                                },
                                                                blur: function () {                                                                    
                                                                    // OBJ_Action.calc.calRowSubTotal();
                                                                },
                                                                change: function (f, obj) {
                                                                    if (sale_invoice_mode == "1") {
                                                                        var value = parseFloat(f.getValue());
                                                                        if (value > 0) {
                                                                            f.setValue(value * -1);
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    },
                                                    {
                                                        header: "Unit",
                                                        dataIndex: "unit_name",
                                                        width: 100,                                                       
                                                        editor: {
                                                            xtype: 'combo',
                                                            allowBlank: true,                                                            
                                                            disabled: true,
                                                            queryMode: 'local',
                                                            id: 'sale_item_uom',
                                                            displayField: 'unit_name',
                                                            store: uom_store_temp,
                                                            enableKeyEvents:true,
                                                            valueField: 'unit_name',
                                                            emptyText: 'UOM',
                                                            listeners: {
                                                                change: function (f, obj) {
                                                                    if(f.getValue()==""){
                                                                        OBJ_Action.searchKeyPress = 0;
                                                                        OBJ_Action.searchChange = 0;                                                                        
                                                                    }
                                                                    else{
                                                                        OBJ_Action.searchChange = OBJ_Action.searchChange + 1;      
                                                                    }
                                                                    var record = f.findRecordByValue(f.getValue());
                                                                        Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
                                                                        Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));

                                                                        var p = parseFloat(Ext.getCmp("item_net_so").getValue());
                                                                        var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
                                                                        var d = parseFloat(Ext.getCmp("item_discount_so").getValue());
                                                                        var dPrice = p - (p * d / 100);
                                                                        var total = q * dPrice;
                                                                        Ext.getCmp("item_subtotal_so").setValue(Ext.util.Format.number(Ext.getCmp("item_quantity_so").getValue()*record.get("sprice"), "0.00"));
                                                                
                                                                        var sel = Ext.getCmp('stock-transfer-grid').getSelectionModel().getSelection()[0];
                                                                        
                                                                        sel.set("unit_id", record.get("unit_id"));
                                                                        sel.set("unit_name", record.get("unit_name"));
                                                                        sel.set("conv_from", record.get("conv_from"));
                                                                        sel.set("normal_price", Ext.util.Format.number(record.get("nprice"), "0.00"));
                                                                        OBJ_Action.recordChange();
                                                                        // OBJ_Action.calc.calRowSubTotal();    
                                                                        if(OBJ_Action.shiftFocus){                                                                            
                                                                        Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);                                                                                                                                                                                                                             
                                                                        OBJ_Action.shiftFocus = false;
                                                                        OBJ_Action.searchKeyPress = 0;
                                                                        OBJ_Action.searchChange = 0;       
                                                                       }
                                                                    
                                                                  },
                                                                  keydown: function(obj,e,opts){                                                                    
                                                                    if (e.getKey() == Ext.EventObject.TAB || e.getKey() == Ext.EventObject.ENTER) {
                                                                        OBJ_Action.shiftFocus = true;                                                                        
                                                                    }
                                                                    else{
                                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchKeyPress + 1;                                                                                                                                        
                                                                    }
                                                                },
                                                                focus: function(){                                                                    
                                                                    OBJ_Action.searchKeyPress = 0;
                                                                    OBJ_Action.searchChange = 0;
                                                                    OBJ_Action.shiftFocus = false;
                                                                    Ext.defer(function(){Ext.getCmp("sale_item_uom").setEditable(true)},100);
                                                                },
                                                                click: function(){
                                                                    OBJ_Action.shiftFocus = false;
                                                                }
                                                            }
                                                        }
                                                    },
                                              {
                                                        header: "Unit Price",
                                                        dataIndex: "unit_price",
                                                        width: 80,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_price_so',
                                                            allowBlank: false,
                                                            disabled: true,
                                                            readOnly: false,
                                                            maxLength: 9,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                    // OBJ_Action.calc.calRowSubTotal();
                                                                }
                                                            }
                                                        }
                                                    },{
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        items: [{
                                                                icon: 'themes/aursoft/images/remove_new.png',
                                                                tooltip: 'Delete',
                                                                
                                                                handler: function (grid, rowIndex, colIndex) {
                                                                    if(grid.editingPlugin.editing===false){
                                                                        var rec = grid.getStore().getAt(rowIndex);
                                                                        grid.store.remove(rec);
                                                                        OBJ_Action.calc.calTotalSubTotal();
                                                                        OBJ_Action.recordChange();
                                                                    }
                                                                    //alert("Terminate " + rec);
                                                                }
                                                            }]
                                                    }

                                                ]
                                            }]
                                    }
                                ]
                            }
            })
            

        }
    ]
}

