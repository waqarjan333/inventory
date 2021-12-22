_po = {
    id: 'purchase-invoice-panel',
    layout: 'border',
    closable: true,
    closeAction: 'hide',
    frame: true,
    title:labels_json.purchaseinvoicepanel.heading_title_0,
    listeners: {
        beforeclose: function () {
            if(win.closeMe) {
                win.closeMe = false;
                return true;
            }
            if(Ext.getCmp("purchase_invoice_grid").store.getCount() > 0 && Ext.getCmp("po_hidden_id").getValue() == "0" && Ext.getCmp("po_payment_paid").getValue() =='0'){                
                Ext.Msg.show({
                         title:'Close confirmation'
                        ,msg:'Are you sure to close the invoice without Saving?'
                        ,buttons:Ext.Msg.YESNO
                        ,callback:function(btn) {
                            if('yes' === btn) {
                                purchase_invoice_return_mode = 0;
                                // homePage();
                                window.location.reload();
                            }
                        }
                    });
            } else {
                purchase_invoice_return_mode = 0;
                 homePage();
                //window.location.reload();
            }
           return false; 
        },
       
        afterrender: function () {
            expense_store.load();
            Ext.getCmp("insertExpense").setVisible(false);
             Ext.getCmp("expenseAmount").setVisible(false);
             Ext.getCmp("pur_expense_combo").setVisible(false);
              //Show OR Hide Warehouse Column
            if(enableWarehouse==1){
                Ext.getCmp('purchase_invoice_grid').columns[4].setVisible(true);
            } else {
                Ext.getCmp('purchase_invoice_grid').columns[4].setVisible(false);
            }
            if(enableUom==0) {
                Ext.getCmp('purchase_invoice_grid').columns[3].setVisible(false); 
            }
            if(bonusQuantity==1)
                {
                  Ext.getCmp('purchase_invoice_grid').columns[2].setVisible(true);
                } else {
                  Ext.getCmp('purchase_invoice_grid').columns[2].setVisible(false);
                }
             
            editModelPO = Ext.getCmp("purchase_invoice_grid").plugins[0];
            editModelReceive = Ext.getCmp("expense_invoice_grid").plugins[0];
              // var current_tab =  Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
            // console.log(editModelReceive);
            // if(current_tab =='0')
            // {
            //  Ext.getCmp('vendors_combo').setVisible(false);    
            //  Ext.getCmp('vendor_mobile').setVisible(false);    
            // }
                 
            
            selected_m_rows = null;
            multi_items_form = Ext.widget('window', {
                title: labels_json.purchaseinvoicepanel.select_item_emptyText, 
                width: 830,
                height: 450,
                minHeight: 200,
                closeAction: 'hide',
                layout: 'fit',
                resizable: true,
                modal: true,
                listeners: {
                    show: function () {
                        var me = this.down('form').getForm();
                        me.findField("m_item_name").focus(true,200);

                        me.reset();
                    }
                },
                items: Ext.widget('form', {
                    layout: 'border',
                    border: false,
                    id: '_multiple_items_form',
                    bodyPadding: 5,
                    defaults: {
                        border: false
                    },
                    items: [{
                            region: 'north',
                            height: 42,
                            layout: 'column',
                            bodyBorder: false,
                            defaults: {
                                layout: 'anchor',
                                border: false,
                                defaults: {
                                    anchor: '100%'
                                }
                            },
                            items: [{
                                    columnWidth: 1,
                                    baseCls: 'x-plain',
                                    padding: 10,
                                    items: [
                                        {
                                            xtype: 'textfield',
                                            fieldLabel: labels_json.purchaseinvoicepanel.button_search, 
                                            name: 'm_item_name',
                                            allowBlank: false,
                                            id: 'm_items_name',
                                            listeners: {
                                                change: function (obj, val) {
                                                    var grid = Ext.getCmp("m-store-item-grid");
                                                    if (val.length > 2) {
                                                        grid.store.load({params: {
                                                                search_name: val,
                                                                search: 1

                                                            }
                                                        });
                                                    } else if (val.length <= 2) {
                                                        grid.store.removeAll();
                                                    }
                                                }
                                            }
                                        }, {
                                            xtype: 'combo',
                                            hidden: true,
                                            fieldLabel: 'Search By Category',
                                            id: 'm_items_category',
                                            labelWidth: 120,
                                            name: 'level_type',
                                            displayField: 'name',
                                            queryMode: 'local',
                                            typeAhead: true,
                                            valueField: 'id',
                                            value: '1',
                                            store: new Ext.data.Store({
                                                fields: ['id', 'name'],
                                                data: [
                                                ]
                                            }),
                                            listeners: {
                                                change: function (obj, nv, ov, e) {

                                                }
                                            }
                                        },
                                        {
                                            xtype: 'hidden',
                                            name: 'm_items_id',
                                            value: '0'
                                        }
                                    ]
                                },
                                {
                                    columnWidth: 1 / 3,
                                    baseCls: 'x-plain',
                                    margin: '10 10 0 0',
                                    height: 100,
                                    layout: {
                                        type: 'table',
                                        columns: 1,
                                        tableAttrs: {
                                            width: '230px',
                                            style: 'float:right'
                                        }
                                    },
                                    items: [
                                    ]
                                }
                            ]
                        },
                        {
                            region: 'center',
                            bodyBorder: false,
                            defaults: {
                                border: false
                            },
                            items: [
                                {
                                    xtype: 'panel',
                                    layout: 'anchor',
                                    hidden: false,
                                    bodyBorder: false,
                                    defaults: {
                                        border: false
                                    },
                                    items: [{xtype: "gridpanel",
                                            id: "m-store-item-grid",
                                            height: 330,
                                            bodyBorder: true,
                                            border: true,
                                            style: "margin-bottom:8px;",
                                            plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                                    clicksToMoveEditor: 1,
                                                    autoCancel: false,
                                                    listeners: {
                                                        'canceledit': function (e) {

                                                        }
                                                        ,
                                                        'edit': function (e) {

                                                        }
                                                        ,
                                                        'beforeedit': function (e, obj) {
                                                            Ext.getCmp("m_item_quantity_po").setDisabled(false);
                                                            Ext.getCmp("m_item_price_po").setDisabled(false);
                                                            Ext.getCmp("m_item_sale_price_po").setDisabled(false);
                                                            Ext.getCmp("m_purchase_item_uom").setDisabled(false);
                                                            var sel_model =  Ext.getCmp('m-store-item-grid').getSelectionModel();
                                                            selected_m_rows = sel_model.getSelection();
                                                            Ext.defer(function () {
                                                                if(selected_m_rows.length){
                                                                    for(var i=0;i<selected_m_rows.length;i++){
                                                                        sel_model.select(selected_m_rows[i].index,true);
                                                                    }
                                                                }
                                                            }, 150);
                                                            var grid = e.grid;
                                                            var rec = grid.getStore().getAt(obj.rowIdx);
                                                            var data = rec.raw.item_units;
                                                            if (data) {
                                                                uom_store_temp.removeAll();
                                                                for (var i = 0; i < data.length; i++) {
                                                                    uom_store_temp.add(data[i]);                                                                    
                                                                }
                                                            } else {
                                                                Ext.getCmp("m_purchase_item_uom").setDisabled(true);
                                                                Ext.Ajax.request({
                                                                    url: action_urls.get_me_uom,
                                                                    method: 'POST',
                                                                    params: {
                                                                        id: rec.get("id")
                                                                    },
                                                                    success: function (response) {
                                                                        var data = Ext.JSON.decode(response.responseText);
                                                                        uom_store_temp.removeAll();
                                                                        rec.raw.item_units = data;
                                                                        Ext.getCmp("m_purchase_item_uom").setDisabled(false);
                                                                        for (var i = 0; i < data.length; i++) {
                                                                            uom_store_temp.add(data[i]);
                                                                            if (rec.get("purchase_item_uom") == data[i].unit_id) {
                                                                                Ext.getCmp("m_item_sale_price_po").setValue(data[i].sprice);
                                                                                Ext.getCmp("m_item_price_po").setValue(data[i].conv_from*rec.raw.nprice);
                                                                                Ext.getCmp("m_purchase_item_uom").setValue(data[i].unit_name);

                                                                                rec.set("unit_id", data[i].unit_id);
                                                                                rec.set("unit_name", data[i].unit_name);
                                                                                rec.set("conv_from", data[i].conv_from);
                                                                                rec.set("normal_price", parseFloat(data[i].conv_from*rec.raw.nprice));
                                                                            }

                                                                        }
                                                                        Ext.defer(function () {
                                                                            Ext.getCmp("m_item_quantity_po").focus(true);
                                                                        }, 100);


                                                                    },
                                                                    failure: function () {}
                                                                });
                                                            }
                                                        },
                                                        validateedit: function () {

                                                        }
                                                    }
                                                })],
                                            store: {
                                                proxy: {
                                                    type: "ajax",
                                                    url: action_urls.get_items,
                                                    reader: {
                                                        type: "json",
                                                        root: 'items',
                                                        idProperty: 'id'
                                                    }
                                                },
                                                model: Ext.define("itemModel", {
                                                    extend: "Ext.data.Model",
                                                    fields: [
                                                        "item_status",
                                                        "item",
                                                        "purchase_item_uom",
                                                        {name: 'quantity', type: 'double', defaultValue: 1},
                                                        "nprice",
                                                        "category",
                                                        {name: 'unit_id', type: 'integer', convert: function (v, rec) {
                                                                v = 1;
                                                                var item_units = rec.raw.item_units;
                                                                if (item_units && item_units.length) {
                                                                    for (var i = 0; i < item_units.length; i++) {
                                                                        if (item_units[i].unit_id == rec.raw.purchase_unit) {
                                                                            v = item_units[i].unit_id;
                                                                            var avg_cost = item_units[i].conv_from*rec.raw.nprice;
                                                                            rec.set("unit_name", item_units[i].unit_name);
                                                                            rec.set("conv_from", item_units[i].conv_from);
                                                                            rec.set("normal_price", avg_cost);
                                                                            rec.set("sprice", item_units[i].sprice);
                                                                            rec.set("nprice", item_units[i].conv_from*rec.raw.nprice);
                                                                            rec.set("sub_total", Ext.util.Format.number(avg_cost*parseFloat(rec.get("quantity")),"0.00"));
                                                                            rec.set("base_avg_cost", rec.raw.nprice);
                                                                        }
                                                                    }
                                                                }
                                                                return v;
                                                            }},
                                                        "unit_name",
                                                        "conv_from",
                                                        "sprice",
                                                        "cust_price",
                                                        "id",
                                                        "sub_total"
                                                    ]
                                                }) && "itemModel",
                                                autoLoad: false
                                            },
                                            selModel: Ext.create('Ext.selection.CheckboxModel', {                                                                                               
                                                checkOnly:true,
                                                listeners: {
                                                    
                                                }
                                            }),
                                            listeners: {
                                            }
                                            ,
                                            columnLines: true,
                                            columns: [
                                                {header: labels_json.purchaseinvoicepanel.col_item, dataIndex: "item", flex: 1},
                                                {header: labels_json.purchaseinvoicepanel.col_quantity, dataIndex: "quantity", width: 80,
                                                    editor: {
                                                        xtype: 'textfield',
                                                        id: 'm_item_quantity_po',
                                                        allowBlank: false,
                                                        maxLength: 8,
                                                        disabled: true,
                                                        readOnly: false,
                                                        maskRe: /([0-9\s\.]+)$/,
                                                        regex: /[0-9]/,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            keyup: function (obj, e) {
                                                                OBJ_Action.calc.calMRowSubTotal();
                                                            },
                                                            change: function (f) {
                                                                if (purchase_invoice_return_mode == "1") {
                                                                    var value = parseFloat(f.getValue());
                                                                    if (value > 0) {
                                                                        f.setValue(value * -1);
                                                                    }
                                                                }
                                                            }
                                                        }

                                                    }
                                                },
                                                {header: labels_json.purchaseinvoicepanel.col_item_uom, dataIndex: "unit_name", width: 80,
                                                    editor: {
                                                        xtype: 'combo',
                                                        allowBlank: true,
                                                        disabled: true,
                                                        queryMode: 'local',
                                                        id: 'm_purchase_item_uom',
                                                        enableKeyEvents: true,
                                                        displayField: 'unit_name',
                                                        store: uom_store_temp,
                                                        valueField: 'unit_name',
                                                        emptyText: 'UOM',
                                                        value: '1',
                                                        listeners: {
                                                            change: function (f, obj) {
                                                                var record = f.findRecordByValue(f.getValue());
                                                                if (record) {
                                                                    var sel_model =  Ext.getCmp('m-store-item-grid').getSelectionModel().getSelection()[0];
                                                                    
                                                                    var avg_cost = sel_model.data.base_avg_cost;
                                                                    Ext.getCmp("m_item_price_po").setValue(record.get("conv_from")*avg_cost);
                                                                    Ext.getCmp("m_item_sale_price_po").setValue(record.get("sprice"));                                                                                                                                                                                                           
                                                                }
                                                            }
                                                        }
                                                    }
                                                },
                                                {header: labels_json.purchaseinvoicepanel.col_unit_price, dataIndex: "nprice", width: 100,
                                                    editor: {
                                                        xtype: 'textfield',
                                                        id: 'm_item_price_po',
                                                        allowBlank: false,
                                                        disabled: true,
                                                        readOnly: false,
                                                        maxLength: 9,
                                                        maskRe: /([0-9\s\.]+)$/,
                                                        regex: /[0-9]/,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            keyup: function () {
                                                                OBJ_Action.calc.calMRowSubTotal();
                                                            }
                                                        }
                                                    }
                                                },
                                                {header: labels_json.purchaseinvoicepanel.col_sale_price, dataIndex: "sprice", width: 100,
                                                    editor: {
                                                        xtype: 'textfield',
                                                        id: 'm_item_sale_price_po',
                                                        allowBlank: false,
                                                        maxLength: 9,
                                                        disabled: true,
                                                        readOnly: false,
                                                        maskRe: /([0-9\s\.]+)$/,
                                                        regex: /[0-9]/,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            keyup: function () {
                                                            }
                                                        }
                                                    }
                                                },
                                                {header: labels_json.purchaseinvoicepanel.col_sub_total, dataIndex: "sub_total", width: 100,
                                                    editor: {
                                                        xtype: 'textfield',
                                                        cls: 'grid_look',
                                                        id: 'm_item_subtotal_po',
                                                        disabled: false,
                                                        readOnly: true,
                                                        allowBlank: false,
                                                        maskRe: /([0-9\s\.]+)$/,
                                                        regex: /[0-9]/,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            
                                                        }
                                                    }
                                                }

                                            ]
                                        }
                                    ]
                                }

                            ]
                        }
                    ],
                    buttons: [{
                            text: labels_json.purchaseinvoicepanel.button_add,
                            handler: function () {
                                if (this.up('form').getForm().isValid()) {
                                    var selected_items = [];
                                    var sel = Ext.getCmp('m-store-item-grid').getSelectionModel().getSelection();
                                    if (sel.length) {
                                        for (var i = 0; i < sel.length; i++) {
                                            var selected_item = {
                                                "item_id": sel[i].get("id"),
                                                "item_name": sel[i].get("item"),
                                                "unit_name": sel[i].get("unit_name"),
                                                "unit_id": sel[i].get("unit_id"),
                                                "ware_id": sel[i].get("item_warehouse"),
                                                "item_quantity": sel[i].get("quantity"),
                                                "conv_from": sel[i].get("conv_from"),
                                                "unit_price": sel[i].get("nprice"),
                                                "sale_price": sel[i].get("sprice"),
                                                "discount": "0%",
                                                "sub_total": Ext.util.Format.number(parseFloat(sel[i].get("quantity")) * parseFloat(sel[i].get("nprice")), "0.00"),
                                                "item_units": sel[i].raw.item_units
                                            }
                                            //selected_items.push();

                                            Ext.getCmp("purchase_invoice_grid").store.add(selected_item);
                                        }
                                        //Ext.getCmp("purchase_invoice_grid").store.loadData(selected_items);
                                        OBJ_Action.calc.calGrid();
                                        OBJ_Action.calc.calTotalSubTotal();
                                        this.up('form').getForm().reset();
                                        this.up('window').hide();
                                        OBJ_Action.addRecord();
                                    } else {
                                        Ext.Msg.show({
                                            title: 'Selection',
                                            msg: 'Please select item rows to continue.',
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.ERROR
                                        });
                                    }
                                }
                            }
                        }, {
                            text: labels_json.purchaseinvoicepanel.button_cancel, 
                            handler: function () {
                                this.up('form').getForm().reset();
                                this.up('window').hide();
                            }
                        }]
                })
            });
            
            purchase_invoice_barcode_lable = Ext.widget('window', {
                title: 'Purchase Invoice Barcode Lable',
                width: Ext.getBody().getViewSize().width-50,
                height: Ext.getBody().getViewSize().height-50,
                closeAction: 'hide',
                layout: 'fit',
                resizable: true,
                modal: true,
                listeners: {
                    show: function () {
                        var me = this.down('form').getForm();
                        me.findField("lb_purchase_order_vendor_search").focus(true,200);
                        me.reset();
                        Ext.Ajax.request({
                                    url: action_urls.get_bl_po_record,
                                    params: {
                                        inv_id: Ext.getCmp("po_hidden_id").getValue(),
                                        search : 0
                                    },
                                    success: function (response, opts) {
                                        Ext.getCmp("purchase-invoice-lable-store-item-grid").store.removeAll();
                                        jObj = Ext.decode(response.responseText);
                                        Ext.getCmp("purchase-invoice-lable-store-item-grid").store.loadData(jObj.order_details);
                                    }
                        });
                        
                    }
                },
                items: Ext.widget('form', {
                    layout: 'border',
                    border: false,
                    id: '_purchase_invoice_barcode_form',
                    bodyPadding: 5,
                    defaults: {
                        border: false
                    },
                    items: [{
                            region: 'north',
                            height: 40,
                            layout: 'column',
                            bodyBorder: false,
                            defaults: {
                                layout: 'anchor',
                                border: false,
                                defaults: {
                                    anchor: '100%'
                                }
                            },
                            items: [{
                                    columnWidth: 1/3,
                                    baseCls: 'x-plain',
                                    padding: 10,
                                    items: [
                                        {
                                            xtype: 'combo',
                                            fieldLabel: labels_json.purchaseinvoicepanel.text_vendor,
                                            displayField: 'vendor_name',
                                            valueField: 'vendor_id',
                                            emptyText: labels_json.purchaseinvoicepanel.text_vendor_text,
                                            id: 'lb_purchase_order_vendor_search',
                                            queryMode: 'local',
                                            value: '',
                                            name : 'lb_purchase_order_vendor_search',
                                            typeAhead: true,
                                            store: vendor_store_withall,
                                            listeners: {
                                                change: function (obj,newValue,oldValue,eOpt) {

                                                Ext.Ajax.request({
                                                            url: action_urls.get_bl_purchase_invoice_no,
                                                            params: {
                                                                vend_id: newValue
                                                            },
                                                            success: function (response, opts) {
                                                                Ext.getCmp("search_barcode_lable_invoice_no").store.removeAll();
                                                                jObj = Ext.decode(response.responseText);
                                                                
                                                                Ext.getCmp("search_barcode_lable_invoice_no").store.loadData(jObj.inv_no);
                                                                //Ext.getCmp("search_barcode_lable_invoice_no").store.insert(0,{"id":"0","name":"All"});
                                                            },
                                                            failure: function (response) {
                                                                Ext.getCmp("search_barcode_lable_invoice_no").store.removeAll();
                                                            }
                                                });
                                                }
                                            }

                                        }
                                    ]
                                },{
                                    columnWidth: 1/3,
                                    baseCls: 'x-plain',
                                    padding: 10,
                                    items: [
                                        {
                                            xtype: 'combo',
                                            fieldLabel: labels_json.purchaseinvoicepanel.text_order_no,
                                            id: 'search_barcode_lable_invoice_no',
                                            width:200,
                                            emptyText: labels_json.purchaseinvoicepanel.text_order_no_text,
                                            name: 'search_barcode_lable_invoice_no',
                                            valueField: 'id',
                                            displayField: 'name',
                                            store: new Ext.data.Store({
                                                    fields: ['id','name'],                                                
                                                        data: []

                                                }),                                        
                                            queryMode: 'local',
                                            listeners: {
                                                change: function (f, obj) {


                                                }
                                            }
                                        }
                                    ]
                                },
                                
                                {
                                    columnWidth: 1/3,
                                    baseCls: 'x-plain',
                                    padding: 10,
                                    items: [
                                        {
                                            xtype:'combo',
                                            queryMode:'local',
                                            displayField:'name',
                                            id : 'lb_barcode_label_purchase_invoice_search',
                                            value : "0",
                                            fieldLabel:'Search/Add',
                                            name:'lb_barcode_label_purchase_invoice_search',
                                            store: Ext.create('Ext.data.Store', {
                                                    fields: ['id', 'name'],
                                                    data : [
                                                            {"id":"0", "name":"Please Select"},
                                                            {"id":"1", "name":"Search"},
                                                            {"id":"2", "name":"Add"}
                                                    ]
                                                }),
                                            valueField:'id',
                                            listeners: {
                                                change: function (obj,newValue,oldValue,eOpt) {
                                                    Ext.Ajax.request({
                                                        url: action_urls.get_bl_po_record,
                                                        params: {
                                                            vend_id: Ext.getCmp("lb_purchase_order_vendor_search").getValue(),
                                                            inv_id: Ext.getCmp("search_barcode_lable_invoice_no").getValue(),
                                                            search : 1
                                                        },
                                                        success: function (response, opts) {
                                                            if(newValue=='1'){
                                                                Ext.getCmp("purchase-invoice-lable-store-item-grid").store.removeAll();
                                                                jObj = Ext.decode(response.responseText);
                                                                Ext.getCmp("purchase-invoice-lable-store-item-grid").store.loadData(jObj.order_details);
                                                            } else {
                                                                jObj = Ext.decode(response.responseText);
                                                                Ext.getCmp("purchase-invoice-lable-store-item-grid").store.add(jObj.order_details);
                                                            }
                                                                
                                                        }
                                                    });

                                                }
                                            }
                                        }
                                    ]
                                },
                                
                                {
                                    columnWidth: 1 / 3,
                                    baseCls: 'x-plain',
                                    margin: '10 10 0 0',
                                    height: 100,
                                    layout: {
                                        type: 'table',
                                        columns: 1,
                                        tableAttrs: {
                                            width: '230px',
                                            style: 'float:right'
                                        }
                                    },
                                    items: [
                                    ]
                                }
                            ]
                        },
                        {
                            region: 'center',
                            bodyBorder: false,
                            defaults: {
                                border: false
                            },
                            items: [
                                {
                                    xtype: 'panel',
                                    layout: 'anchor',
                                    hidden: false,
                                    bodyBorder: false,
                                    defaults: {
                                        border: false
                                    },
                                    items: [{xtype: "gridpanel",
                                            id: "purchase-invoice-lable-store-item-grid",
                                            bodyBorder: true,
                                            border: true,
                                            style: "margin-bottom:8px;",
                                            plugins: [Ext.create('Ext.grid.plugin.CellEditing', {
                                                    clicksToEdit: 2,
                                                    //autoCancel: false,
                                                    listeners: {
                                                        'canceledit': function (e) {},
                                                        'edit': function (editor, e, eOpts) { },
                                                        'beforeedit': function (e, obj) {
                                                            var grid = e.grid;
                                                            var rec = grid.getStore().getAt(obj.rowIdx);
                                                            var data = rec.raw.barcode_lable_item_units;
                                                            if (data) {
                                                                uom_store_temp.removeAll();
                                                                for (var i = 0; i < data.length; i++) {
                                                                    uom_store_temp.add(data[i]);                                                                    
                                                                }
                                                            }
                                                            Ext.Ajax.request({
                                                                    url: action_urls.get_bl_barcodes,
                                                                    params: {
                                                                        item_id: rec.data.barcode_lable_item_id,
                                                                        uom_id: rec.data.barcode_lable_item_unit_uom
                                                                    },
                                                                    success: function (response, opts) {
                                                                            lb_uom_store_temp.removeAll();
                                                                            jObj = Ext.decode(response.responseText);
                                                                            lb_uom_store_temp.loadData(jObj.barcodes);
                                                                    }
                                                                });
                                                        
                                                        },
                                                        validateedit: function () {}
                                                    }
                                                })],
                                            store: {
                                                proxy: {
                                                        type: "memory",
                                                        reader: {
                                                            type: "json",
                                                            idProperty: 'item_id'
                                                        }
                                                },
                                                model: Ext.define("bl_itemModel", {
                                                    extend: "Ext.data.Model",
                                                    fields: [
                                                        "barcode_lable_item_id",
                                                        "barcode_lable_item_name",
                                                        "barcode_lable_unit_id",
                                                        "barcode_lable_unit_name",
                                                        "barcode_lable_barcode",
                                                        "barcode_lable_color",
                                                        "barcode_lable_size",
                                                        "barcode_lable_sale_price",
                                                        "barcode_lable_qty",
                                                        "barcode_lable_qty_on_hand",
                                                        "barcode_lable_total_qty",
                                                        "barcode_lable_no_of_copies",
                                                        "barcode_lable_custom_copies",
                                                        "barcode_lable_item_unit_uom"
                                                    ]
                                                }) && "bl_itemModel",
                                                data: []
                                            },
                                            selModel: Ext.create('Ext.selection.CheckboxModel', {                                                                                               
                                                checkOnly:true,
                                                listeners: { }
                                            }),
                                            listeners: {},
                                            columnLines: true,
                                            columns: [
                                                {header: "Item Name", dataIndex: "barcode_lable_item_name",  flex: 1, sortable: false},
                                                {header: "UoM", dataIndex: "barcode_lable_unit_name",
                                                    editor: {
                                                        xtype:'combo',
                                                        queryMode:'local',
                                                        displayField:'unit_name',
                                                        id : 'lb_uom',
                                                        name:'lb_uom',
                                                        store: uom_store_temp,
                                                        valueField:'unit_name',
                                                        listeners: {
                                                            change : function (f , obj){
                                                                var record = f.findRecordByValue(f.getValue());
                                                                Ext.Ajax.request({
                                                                    url: action_urls.get_bl_barcodes,
                                                                    params: {
                                                                        item_id: record.get("item_id"),
                                                                        uom_id: record.get("uom_id")
                                                                    },
                                                                    success: function (response, opts) {
                                                                            lb_uom_store_temp.removeAll();
                                                                            jObj = Ext.decode(response.responseText);
                                                                            lb_uom_store_temp.loadData(jObj.barcodes);
                                                                            var sel = Ext.getCmp('purchase-invoice-lable-store-item-grid').getSelectionModel().getSelection()[0];
                                                                            sel.set("barcode_lable_item_unit_uom", record.get("uom_id"));
                                                                            sel.set("barcode_lable_sale_price", record.get("sprice"));
                                                                            
                                                                            sel.set("barcode_lable_qty", sel.raw.barcode_lable_inv_qty/record.get("conv_from"));
                                                                            sel.set("barcode_lable_qty_on_hand", sel.raw.barcode_qty_on_hand/record.get("conv_from"));
                                                                            sel.set("barcode_lable_total_qty", (parseInt(sel.data.barcode_lable_qty_on_hand) + parseInt(sel.data.barcode_lable_qty)));
                                                                            sel.set("barcode_lable_no_of_copies", (parseInt(sel.data.barcode_lable_qty_on_hand) + parseInt(sel.data.barcode_lable_qty)));
                                                                            sel.set("barcode_lable_custom_copies", (parseInt(sel.data.barcode_lable_qty_on_hand) + parseInt(sel.data.barcode_lable_qty)));
                                                                            

                                                                    }
                                                                });
                                                            }
                                                        }
                                                    }
                                                },
                                                {header: "Barcode", dataIndex: "barcode_lable_barcode",
                                                    editor: {
                                                        xtype:'combo',
                                                        displayField:'barcode',
                                                        id : 'bl_barcode',
                                                        name:'bl_barcode',
                                                        valueField:'barcode',
                                                        store: lb_uom_store_temp,
                                                        queryMode:'local',
                                                        listeners: {}
                                                    }
                                                },
                                                {header: "Color", dataIndex: "barcode_lable_color", sortable: false},
                                                {header: "Size", dataIndex: "barcode_lable_size", sortable: false},
                                                {header: "Sale Price", dataIndex: "barcode_lable_sale_price", sortable: false},
                                                {header: "Inv Qty", dataIndex: "barcode_lable_qty", sortable: false},
                                                {header: "Qty On Hand", dataIndex: "barcode_lable_qty_on_hand",  sortable: false},
                                                {header: "Total Qty", dataIndex: "barcode_lable_total_qty", sortable: false},
                                                {header: "No Of Copies", dataIndex: "barcode_lable_no_of_copies",  sortable: false},
                                                {header: "Cust Copies", dataIndex: "barcode_lable_custom_copies", 
                                                    editor: {
                                                        xtype: 'textfield',
                                                        id: 'bl_custom_copies',
                                                        allowBlank: false,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            change : function(obj,newValue,oldValue,eOpt){
                                                                var sel = Ext.getCmp('purchase-invoice-lable-store-item-grid').getSelectionModel().getSelection()[0];
                                                                sel.set("barcode_lable_custom_copies", newValue);
                                                            }
                                                        }
                                                    }
                                                },
                                                {
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        items: [{
                                                                icon: 'themes/aursoft/images/remove_new.png',
                                                                tooltip: 'Delete',
                                                                handler: function (grid, rowIndex, colIndex) {
                                                                    var rec = grid.getStore().getAt(rowIndex);
                                                                    grid.store.remove(rec);
                                                                }
                                                            }]
                                                    }
                                            ]
                                        }
                                    ]
                                }

                            ]
                        }
                    ],
                    buttons: [{
                            xtype: 'button', 
                            text: 'Prnint Label',
                            iconCls: 'print',
                            tooltip:'Print label for product.',
                            listeners:{
                                click:function(){
                                    var data = Ext.getCmp('purchase-invoice-lable-store-item-grid').store.data;
                                    var JSONitemData = Ext.encode(Ext.pluck(data.items, 'data'));
                                    Ext.Ajax.request({
                                    url: json_urls.print_label,
                                    params:{
                                        item_data : JSONitemData,
                                        user_key    : userKey_barcodeLabel,
                                        barcodeLabel : barcodeLabel,
                                        userKey_barcodeLabel : userKey_barcodeLabel,
                                        label_design_1 : label_design_1,
                                        label_design_2 : label_design_2,
                                        label_design_3 : label_design_3,
                                        label_design_4 : label_design_4,
                                        label_design_5 : label_design_5
                                    },
                                    success: function (response) {

                                    },
                                    failure: function () {}
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
        },
        beforerender: function () {
            vendor_store.load();
            
        },
        show: function () {
            Ext.get("po_payment_paid-inputEl").on("mousedown",function(e,t){
             e.stopPropagation(); 
             var status = parseInt(Ext.getCmp("po_order_status").getValue());
             if(status == 1 || status == 2){
                var pay_window = invoice_pay_form.down('form').getForm();
                invoice_pay_form.show();
                pay_window.findField("G_order_type").setValue('1');
                pay_window.findField("G_invoice_id").setValue(Ext.getCmp("po_hidden_id").getValue());
                pay_window.findField("G_vendor_id").setValue(Ext.getCmp("vendors_combo").getValue());
            }
             });
                   Ext.get("po_discount_invoice-inputEl").on("mousedown", function (e, t) {
                e.stopPropagation();
                if (!OBJ_Action.getform().hasInvalidField()) {
                   if(Ext.getCmp("po_payment_total_balance").getValue().replace('-','') != "0.00"){
                        discount_form.show();
                    } 
                    
                }
            });
            
               /*Pay window*/
            discount_form = Ext.widget('window', {
                type: 'hbox',
                 align: 'stretch',
                title: 'Discount',
                width: 600,
                height: 230,
                id:'discount_form',
                minHeight: 200,
                closeAction: 'hide',
//                layout: 'fit',

                
                resizable: true,
                modal: true,
                listeners: {
                    afterrender:function(){
                    
                    var discount_form = new Ext.util.KeyMap("discount_form", [
                        {
                            key: [10,13],
                            fn: function(){ 
                                Ext.getCmp("save_discount").fireHandler();
                            }
                        }
                    ]);  
                },
                    show: function () {
                        var me = this.down('form').getForm();
                        me.reset();
                        me.findField("po_discount_total").focus(true, 100);
                        var _total = Ext.getCmp("po_total").getValue();
                        me.findField("po_paid_total").setValue(_total);
                        var _discount = Ext.getCmp("po_discount_invoice").getValue();
                        me.findField("po_discount_total").setValue(_discount);
                      
                        me.findField("po_discount_total").setFieldLabel('Discount');
                        me.findField("po_total_after_discount").setFieldLabel('After Discount');
                        me.findField("po_total_after_discount").setValue(Ext.util.Format.number(_total - _discount, "0.00"));
                        
                        
                        
                        
                    }
                },
                items: Ext.widget('form', {
                    border: false,
                    bodyPadding: 10,
                    defaults: {
                        border: false,
                        anchor: '100%',
                        labelWidth: 150,
                    },
                    items: [{
                            
                            fieldLabel: 'Total',
                            cls: 'pay',
                            xtype: 'textfield',
                            id: 'po_paid_total',
                            readOnly: true,
                            name: 'po_paid_total',
                            maskRe: /([0-9\s\.]+)$/,
                            regex: /[0-9]/,
                            validateValue: function (value) {
                                var isValid = true;
                                if (value == 0) {
                                    isValid = false;
                                }
                                return isValid;
                            },
                            value: '0.00'
                        },
                        {
                            fieldLabel: 'Discount',
                            xtype: 'textfield',
                            id: 'po_discount_total',
                            name: 'po_discount_total',
//                            maskRe: /([0-9\s\.]+)$/,
//                            regex: /[0-9]/,
                            enableKeyEvents: true,
                            value:'0.00',
                            listeners: {
                                keyup: function () {
                                    var _discount = parseFloat(Ext.getCmp("po_discount_total").getValue());
                                    var _total = parseFloat(Ext.getCmp("po_paid_total").getValue());
                                    var _amtPercent=_discount/_total*100;
                                    //console.log(_amtPercent)
                                       if (_discount>0) { 
                                        Ext.getCmp("po_total_after_discount").setValue(Ext.util.Format.number(_total+(-1*_discount), "0.00"));
                                       
                                         Ext.getCmp("po_discountper_total").setValue(Ext.util.Format.number(_amtPercent,"0.00")+ "%");   
                                        
                                         
                                         
                                        }
                                        else {
                                            Ext.getCmp("po_total_after_discount").setValue(Ext.util.Format.number(_total, "0.00"));
                                        }
                                       
                                      if (this.getValue().trim().length == 0) {
                                              Ext.getCmp("po_discountper_total").setValue(Ext.util.Format.number("0.00"));   
                                            }
                                    
                                },
                                blur:function()
                                {
                                    var _discount = parseFloat(Ext.getCmp("po_discount_total").getValue());
                                    console.log(this.getValue().trim().length)
                                     if (this.getValue().trim().length == 0) {
                                              Ext.getCmp("po_discountper_total").setValue(Ext.util.Format.number("0.00"));   
                                            }
                                            
                                        
                                }
                            }
                        },
                         {
                                 fieldLabel: 'Discount In %',
                            xtype: 'textfield',
                            id: 'po_discountper_total',
                            name: 'po_discountper_total',
//                            maskRe: /([0-9\s\.]+)$/,
//                            regex: /[0-9]/,
                            enableKeyEvents: true,
                            value:'0.00',
                            listeners:{
                                keyup: function () {
                                     var _discount = parseFloat(Ext.getCmp("po_discountper_total").getValue());
                                    var _total = parseFloat(Ext.getCmp("po_paid_total").getValue());
                                    var _percent_amt=(_discount/100)*_total;
                                       if (_discount) { 
                                        Ext.getCmp("po_total_after_discount").setValue(Ext.util.Format.number(_total+(-1*_percent_amt), "0.00"));
                                        Ext.getCmp("po_discount_total").setValue(Ext.util.Format.number((_percent_amt), "0.00"));
                                        }
                                        else {
                                            Ext.getCmp("po_total_after_discount").setValue(Ext.util.Format.number(_total, "0.00"));
                                        }
                                           if (this.getValue().trim().length == 0) {
                                              Ext.getCmp("po_discount_total").setValue(Ext.util.Format.number("0.00"));   
                                            }
                                },
                                 blur:function(){
                                    var val=this.getValue();
                                     Ext.getCmp("po_discountper_total").setValue(Ext.util.Format.number(val)+"%"); 
                                      if (this.getValue().trim().length == 0) {
                                              Ext.getCmp("po_discount_total").setValue(Ext.util.Format.number("0.00"));   
                                            }
                                 },
                                 focus:function()
                                 {
                                      var val=this.getValue();
                                        var fix=val.replace(/%+$/,'');
                                     Ext.getCmp("po_discountper_total").setValue(Ext.util.Format.number(fix)); 
                                 }
                                                               
                                },
                                  
                                
                            },
                            
                        {
                            fieldLabel: 'After Discount',
                            xtype: 'textfield',
                            cls: 'pay',
                            readOnly:true,
                            id: 'po_total_after_discount',
                            name: 'po_total_after_discount',
                            maskRe: /([0-9\s\.]+)$/,
                            regex: /[0-9]/,
                            validateValue: function (value) {
                                var isValid = true;
                                if (value == 0) {
                                    isValid = false;
                                }
                                return isValid;
                            },
                            value: '0.00',
                            enableKeyEvents: true,
                            listeners: {
                                keyup: function () {
                                    var _total = Ext.getCmp("po_paid_total").getValue();
                                    var _after_discount = Ext.getCmp("po_total_after_discount").getValue();
                                    if(sale_invoice_mode=='1'){
                                        Ext.getCmp("po_discount_total").setValue(Ext.util.Format.number(parseFloat(_total)+parseFloat(_after_discount), "0.00"));
                                    } else { 
                                        Ext.getCmp("po_discount_total").setValue(Ext.util.Format.number(parseFloat(_total) - parseFloat(_after_discount), "0.00"));
                                    }
                                    
                                }
                            }
                        },
                        {
                            xtype: 'hidden',
                            name: 'po_invoice_id',
                            id: 'po_invoice_id',
                            value: '0'
                        }
                    ],
                    buttons: [{
                            text: 'Done',
                            id:'save_discount',
                            handler: function () {
                                var me = this.up('form').getForm();
                                if (me.isValid()) {
                                    var discount_val = Ext.getCmp("po_discount_total").getValue();
                                    discount_val = (discount_val == "") ? 0 : discount_val;
                                    Ext.getCmp("po_discount_invoice").setValue(Ext.util.Format.number(parseFloat(discount_val), "0.00"));
                                    
                                    OBJ_Action.calc.calTotalSubTotal();
                                    this.up('window').hide();
                                }
                            }
                        },{
                            text: 'Cancel',
                            handler: function () {
                                this.up('form').getForm().reset();
                                this.up('window').hide();
                            }
                        }]
                })
            });
            /*End Discount window*/
            //Ext.getCmp("search_barcode_lable_item_category").removeAt(Ext.getCmp("search_barcode_lable_item_category").indexOfId('-1'));
            if(barcodeLabel==1){
                Ext.get("print_label").setStyle("display", "block");
            } else {
                Ext.get("print_label").setStyle("display", "none");
            }
            
            Ext.getCmp("purchase_invoice_grid").store.removeAll();
            Ext.getCmp("expense_invoice_grid").store.removeAll();
            OBJ_Action.previousOrderID = last_id.po_last_invoice;
            OBJ_Action.searchKeyPress = 0;
            OBJ_Action.searchChange = 0;
            OBJ_Action.shiftFocus = false;
            OBJ_Action.addMewInvoiceRow = false;
             // Ext.getCmp("po_tab_panel").down('#po_expense_panel').setDisabled(true);
            OBJ_Action.myfunc = function (data) {
                Ext.getCmp("po_id").setValue( data.inv_no);
                if (Ext.getCmp("po_hidden_id").getValue() == 0) {
                    last_id.po_last_invoice = data.obj_id;
                }
                Ext.getCmp("po_hidden_id").setValue(data.obj_id);
                OBJ_Action.nextOrderID = data.next_order_id;
                OBJ_Action.previousOrderID = data.pre_order_id;
                Ext.getCmp("next_po_order_btn").setDisabled((data.next_order_id == 0) ? true : false);
                Ext.getCmp("pre_po_order_btn").setDisabled((data.pre_order_id == 0) ? true : false);
                
            }
            OBJ_Action.saveme = function (_extraParms) {
                editModelPO.cancelEdit();
                var _data = Ext.getCmp('purchase_invoice_grid').store.data;

                var jsonInvoiceData = Ext.encode(Ext.pluck(_data.items, 'data'));
                // console.log(jsonInvoiceData);
                var jsonExpenseData = Ext.encode(Ext.pluck(Ext.getCmp('expense_invoice_grid').store.data.items, 'data'));
                var status_val = 1;

                
                var _total_amount = parseFloat(Ext.getCmp("po_total").getValue());
                var _total_paid = parseFloat(Ext.getCmp("po_payment_paid").getValue());
                //console.log(_total_paid);
                if (_total_paid == 0) {
                    status_val = 1; // Unpaid
                } else if (_total_paid>0 && _total_paid < _total_amount) {
                    status_val = 2; // Partail
                } else if (_total_paid>0 && _total_paid == _total_amount) {
                    status_val = 3; // Paid
                } 

                if (purchase_invoice_return_mode == 1) {
                    status_val = 3;
                }
                
                var extraParms = {
                    trans: jsonInvoiceData,
                    exp: jsonExpenseData,
                    po_status_val: status_val,
                    makenew: (_extraParms && _extraParms.makenew) ? _extraParms.makenew : null,
                    po_time: Ext.Date.format(new Date(), 'H:i:s')
                }
                  if (purchase_invoice_return_mode == 1) {
                     extraParms["vendor_id"]=Ext.getCmp("vendors_combo").getValue()
                }
                

                Ext.getCmp("po_order_status").setValue(status_val);
                Ext.getCmp("po_status").setValue(OBJ_Action.invoiceStatus['_' + status_val]);
                Ext.get("img_stamp_po").dom.className = "stamps " + OBJ_Action.invoiceStatusImage['_' + status_val];
                // console.log(extraParms);
                OBJ_Action.save(extraParms);
                OBJ_Action.onComplete();
                
            }
             OBJ_Action.printme = function () {
                if (parseInt(Ext.getCmp('po_hidden_id').getValue()) !== 0) {
                    try {
                        var print_iframe = Ext.get("print_iframe").dom.contentWindow;
                        print_iframe.$(".invoice-date").html(Ext.Date.format(Ext.getCmp("po_date").getValue(), 'd/m/Y'));
                        print_iframe.$(".print-invoice-date").html(Ext.Date.format(new Date(), 'd/m/Y'));
                        print_iframe.$(".inv").html(Ext.getCmp("po_id").getValue());
                        print_iframe.$(".bill_to").html(Ext.getCmp("vendors_combo").getRawValue());
                        print_iframe.$(".bill_to").css({'font-size':'20px','position':'absolute','top':'2%','left':'4%'});
                         print_iframe.$(".customers_mobile").html(Ext.getCmp("vendor_mobile").getRawValue());
                        print_iframe.$(".dates").css({'position':'absolute','top':'4%','left':'80%'});
                        print_iframe.$(".line1").css({'position':'absolute','top':'1%','left':'45%'});
                        // print_iframe.$(".invoice_no").css({'position':'absolute','top':'1%','right':'25%'});
                        // print_iframe.$(".bill_to_text").html("Vendor");
                         print_iframe.$(".customers_mobile_pos").html(Ext.getCmp("vendor_mobile").getRawValue());
                         print_iframe.$(".customers_add_pos").html(Ext.getCmp("vendor_group").getRawValue());
                         print_iframe.$(".customers_address_pos").html(Ext.getCmp("vendor_group").getRawValue());
                         // print_iframe.$(".inv").css({'margin-top':'20px'});
                        // print_iframe.$(".bill_to").hide();
                        // print_iframe.$(".dates").hide();
                        // print_iframe.$(".customers_mobile").hide();
                        print_iframe.$(".bill_to_text").hide();
                        print_iframe.$(".line").css({'display':'none'});
                        print_iframe.$(".line1").css({'display':'none'});
                        print_iframe.$(".invoice-address").hide();
                        print_iframe.$(".bill_to_pur").html(Ext.getCmp("vendors_combo").getRawValue());
                        print_iframe.$(".bill_to_pur").css({'font-size':'20px','position':'absolute','top':'-30px','left':'240px','width':'100%'});
                        print_iframe.$(".dates_pos").css({'position':'absolute','top':'25%','right':'50%','width':'100%'});
                        print_iframe.$(".customers_mobile_pos").css({'position':'absolute','top':'12px','left':'75%','width':'100%'});
                        print_iframe.$(".cust_mobile_text_pos").css({'position':'absolute','top':'12px','left':'90%','width':'100%'});
                        print_iframe.$(".customers_add_pos").css({'position':'absolute','top':'-7px','left':'90%','width':'100%'});
                        print_iframe.$(".customers_address_pos").css({'position':'absolute','top':'4%','left':'5%','width':'100%'});

                        
                        if(purchase_invoice_return_mode==1)
                        {
                             print_iframe.$(".inv-head").html(labels_json.purchaseinvoicepanel.purchase_return);
                             // print_iframe.$(".inv-head").css({'position':'absolute','top':'2%'});
                              print_iframe.$(".invoice_no1").html(labels_json.purchaseinvoicepanel.purchase_invoice_ret);
                        }
                        else{
                             print_iframe.$(".inv-head").html(labels_json.purchaseinvoicepanel.purchase);
                             print_iframe.$(".invoice_no1").html(labels_json.purchaseinvoicepanel.purchase_invoice);
                        }

                        var purchase_grid = Ext.pluck(Ext.getCmp('purchase_invoice_grid').store.data.items, 'data');
                        var tbody_html = "";
                        var _total = 0, _quantity = 0, _discount = 0, _sub_total = 0, _dPrice = 0;
                        for (var i = 0; i < purchase_grid.length; i++) {
                            tbody_html += "<tr><td  align='left'>" + (i + 1) + "</td>";
                            tbody_html += "<td align='left'>" + purchase_grid[i].item_name + "</td>";
                            tbody_html += "<td align='left'>" + purchase_grid[i].item_quantity + "</td>";
                            tbody_html += "<td align='left'>" + purchase_grid[i].unit_name + "</td>";
                            tbody_html += "<td align='left'>" + purchase_grid[i].unit_price + "</td>";
                            tbody_html += "<td align='left'>" + purchase_grid[i].discount + "</td>";
                            tbody_html += "<td align='left'>" + purchase_grid[i].sub_total + "</td></tr>";

                            _sub_total = _sub_total + parseFloat(purchase_grid[i].sub_total);
                            _dPrice = parseFloat(purchase_grid[i].unit_price) - (parseFloat(purchase_grid[i].unit_price) * parseFloat(purchase_grid[i].discount) / 100);
                            _total = _total + parseFloat(purchase_grid[i].sub_total);
                            _quantity = _quantity + parseFloat(purchase_grid[i].item_quantity);

                        }
                        _discount = _sub_total - _total;

                        print_iframe.$(".receipt-large-body").html(tbody_html);
                        print_iframe.$(".sub_total_qty,.total_qty").html(_quantity);
                        print_iframe.$(".sub_total").html(Ext.util.Format.number(_sub_total, "0.00") + " Rs.");
                        print_iframe.$(".total_amount").html(Ext.util.Format.number(_total, "0.00"));
                        print_iframe.$(".discount").html(Ext.util.Format.number(_discount, "0.00") + " Rs.");
                        print_iframe.$(".grand_total").html(Ext.util.Format.number(_total, "0.00") + " Rs.");

                        if (Ext.getCmp("po_remarks").getValue()) {
                            print_iframe.$(".custom").show();
                            print_iframe.$(".custom").html(Ext.getCmp("po_remarks").getValue());
                        }

                        print_iframe.$(".so_invoice_detail").hide();
                        print_iframe.$(".previous_balance-area").hide();
                        print_iframe.$(".terms_conditions").hide();
                        print_iframe.$(".line").hide();


                        print_iframe.print();
                    } catch (e) {
                        alert(e);
                    }
                } else {
                    Ext.Msg.show({
                        title: 'Error Occured',
                        msg: 'You cann\'t perform this action without saving.',
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.ERROR
                    });
                }
            }
            OBJ_Action.editRecordRow = function(e,obj){
                if (!OBJ_Action.addMewInvoiceRow) {                                                                                                                                                
                    Ext.getCmp("item_quantity_po").setDisabled(false);                                                                        
                    Ext.getCmp("bonus_qty_po").setDisabled(false);                                                                        
                    Ext.getCmp("item_price_po").setDisabled(false);
                    Ext.getCmp("item_sale_price_po").setDisabled(false);
                    Ext.getCmp("item_discount_po").setDisabled(false);                                                                        
                    Ext.getCmp("item_subtotal_po").setDisabled(false);
                    Ext.getCmp("purchase_item_uom").setDisabled(false);
                    if(enableWarehouse==1)
                        {
                            Ext.getCmp("warehouse_po").setDisabled(false);
                        }
                    
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
            OBJ_Action.clearOtherChanges = function () {
                Ext.defer(function () {
                    Ext.getCmp("vendors_combo").focus();
                    Ext.getCmp("vendors_combo").setValue('');

                }, 50)
                Ext.getCmp("purchase_invoice_grid").store.removeAll();
                Ext.getCmp("expense_invoice_grid").store.removeAll();
                OBJ_Action.previousOrderID = last_id.po_last_invoice;
                OBJ_Action.nextOrderID = 0;
                OBJ_Action.setDisableControls(true);
                Ext.get("img_stamp_po").dom.className = "stamps open";
            }
            OBJ_Action.onComplete = function () {
                OBJ_Action.setDisableControls();
            };
            OBJ_Action.setDisableControls = function (isNew) {
                var status = parseInt(Ext.getCmp("po_order_status").getValue());
                try {
                    if(status == 0 || status == 1){
                         // Ext.getCmp("po_tab_panel").down('#po_expense_panel').setDisabled(true);
                        Ext.getCmp("vendors_combo").enable();
                        Ext.getCmp("vendor_mobile").enable();
                        //Ext.getCmp("po_date").enable();
                        Ext.getCmp("po_due_date").enable();
                        Ext.getCmp("po_new_item").enable();
                        Ext.getCmp("po_del_item").enable();
                        Ext.getCmp("po_new_items").enable();
                        Ext.getCmp("po__create_item").enable();
                        Ext.getCmp("delete_po_invoice").enable();
                    } else if(status == 2 || status == 3){
                         // Ext.getCmp("po_tab_panel").down('#po_expense_panel').setDisabled(false);
                        Ext.getCmp("delete_po_invoice").enable();
                        Ext.getCmp("vendors_combo").disable();
                        Ext.getCmp("vendor_mobile").disable();
                        //Ext.getCmp("po_date").disable();
                        Ext.getCmp("po_due_date").enable();
                        Ext.getCmp("po_new_item").disable();
                        Ext.getCmp("po_del_item").disable();
                        Ext.getCmp("po_new_items").disable();
                        Ext.getCmp("po__create_item").disable();
                    } 
                } catch (e) {
                    alert(e.message);
                }
            }
            OBJ_Action.calc = {
                calRowSubTotal: function () {
                    var subtotal = parseFloat(Ext.getCmp("item_subtotal_po").getValue());
                    var p = parseFloat(Ext.getCmp("item_price_po").getValue());
                    var q = parseFloat(Ext.getCmp("item_quantity_po").getValue());
                    var d = parseFloat(Ext.getCmp("item_discount_po").getValue());
                   
                           var dPrice = p - (p * d / 100);
                          
                           // console.log(disc)
                            var   total = q * dPrice;
                        Ext.getCmp("item_subtotal_po").setValue(Ext.util.Format.number(total, "0.00"));
                         
                    OBJ_Action.calc.calTotalSubTotal();   
 
                     var rec = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0].get("discount_complete");
                    rec = rec? parseFloat(rec):0;
                    var dis = rec ? rec : parseFloat(Ext.getCmp("item_discount_po").getValue());
                      var ePrice = subtotal / q;
                           var disc = ((p - ePrice) / p) * 100;
                    Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0].set("discount_complete",disc);
                    //xt.getCmp("item_price_po").setValue(Ext.util.Format.number(dPrice, "0.00"));
                    

                },
                calExpenseRowSubTotal:function(){
                    var subtotal = parseFloat(Ext.getCmp("rec_item_subtotal").getValue());
                    var p = parseFloat(Ext.getCmp("rec_item_newPrice").getValue());
                    var q = parseFloat(Ext.getCmp("item_rec_quantity_po").getValue());
//                    var d = parseFloat(Ext.getCmp("item_discount_po").getValue());
                   
//                           var dPrice = p - (p * d / 100);
                          
                           // console.log(disc)
                            var   total = q * p;
                        Ext.getCmp("rec_item_subtotal").setValue(Ext.util.Format.number(total, "0.00"));
                        OBJ_Action.calc.calTotalExpense();
                },
                calMRowSubTotal: function () {
                    var p = parseFloat(Ext.getCmp("m_item_price_po").getValue());
                    var q = parseFloat(Ext.getCmp("m_item_quantity_po").getValue());                                        
                    var total = q * p;
                    if(!isNaN(total)){
                        Ext.getCmp("m_item_subtotal_po").setValue(Ext.util.Format.number(total, "0.00"));                    
                    }
                    else{
                        Ext.getCmp("m_item_subtotal_po").setValue(Ext.util.Format.number(0, "0.00"));                    
                    }

                },
                calGrid: function () {
                    var grid_items = Ext.getCmp('purchase_invoice_grid').store.data.items;
                    for (var i = 0; i < grid_items.length; i++) {
                        var p = parseFloat(grid_items[i].get("unit_price"));
                        var q = parseFloat(grid_items[i].get("item_quantity"));
                        var d = parseFloat(grid_items[i].get("discount"));
                        var dPrice = p - (p * d / 100);
                        var total = q * dPrice;
                        grid_items[i].set("sub_total", Ext.util.Format.number(parseFloat(grid_items[i].get("sub_total")), "0.00"));

                    }

                    //OBJ_Action.calc.calTotalSubTotal();
                }
                ,
                calTotalSubTotal: function () {
                    var _total = 0;
                    var _total_quantity = 0;
                    var _base_total_quantity = 0;
                    var _total_uprice = 0;
                    var _discount_before_total=0;
                    var _total_2=0;
                    var _data = Ext.getCmp('purchase_invoice_grid').store.data;
                    var _sale_total = 0;
                    _data = Ext.pluck(_data.items, 'data');
                    for (var i = 0; i < _data.length; i++) {
                        _total = _total + parseFloat(_data[i].sub_total);
                        _total_quantity = _total_quantity + parseFloat(_data[i].item_quantity);
                        _total_uprice = _total_uprice + parseFloat(_data[i].unit_price)*parseFloat(_data[i].item_quantity);
                        _base_total_quantity = _base_total_quantity + parseFloat(_data[i].item_quantity*_data[i].conv_from);
                        _sale_total = _sale_total + (parseFloat(_data[i].item_quantity) * parseFloat(_data[i].sale_price));
                        _discount_before_total += parseFloat(_data[i].item_quantity) * parseFloat(_data[i].unit_price);
                            _total_2 = _total_2 + parseFloat(_data[i].sub_total);
                    }
                    
                    
                    if(_data.length!=0){
                       Ext.getCmp("sub_total_item_po").setValue(Ext.util.Format.number(_data.length), "0.00"); 
                    } else {
                       Ext.getCmp("sub_total_item_po").setValue('0.00'); 
                    }
                    //console.log(_total_uprice)
                    _total = Ext.util.Format.number(parseFloat(_total), "0.00");
                    Ext.getCmp("sub_total_total_po").setValue(_total);
                    Ext.getCmp("sub_total_qty_po").setValue(_total_quantity);
                    Ext.getCmp("sub_total_base_qty_po").setValue(_base_total_quantity);
                    Ext.getCmp("sub_total_unit_price_po").setValue(_total_uprice);
                     Ext.getCmp("sub_total_discount_po").setValue(Ext.util.Format.number(_discount_before_total - _total_2, "0.00"));
                    Ext.getCmp("po_total").setValue(Ext.util.Format.number(_total, "0.00"));
                    Ext.getCmp("sale_total").setValue(Ext.util.Format.number(_sale_total, "0.00"));
                    
                    OBJ_Action.calc.calcBalance();
                },
                calTotalExpense:function(){
                    var _total = 0;
                    var _oldtotal=0;
                    var _qty=0;
                    var _total_uprice=0;
                    var _data = Ext.getCmp('expense_invoice_grid').store.data;
                     var Expenseamount = Ext.getCmp('expenseAmount').getValue();
                    // console.log(_data);
                      _data = Ext.pluck(_data.items, 'data');
                    for (var i = 0; i < _data.length; i++) {
                        _total = _total + parseFloat(_data[i].inv_item_subTotal);
                        _oldtotal = _oldtotal + parseFloat(_data[i].unit_price);
                       _total_uprice = _total_uprice + parseFloat(_data[i].unit_price)*parseFloat(_data[i].item_quantity);
                        // _qty = _qty + parseFloat(_data[i].inv_item_subTotal);
                    }
                    // console.log();
                    var _afterTotal=_total-_total_uprice;
                    if(_afterTotal>Expenseamount)
                    {
                                Ext.Msg.show({
                                         title:'Warning',
                                         msg: "Amount Not Be Greater Then "+Expenseamount,
                                         buttons: Ext.Msg.OK,
                                         icon: Ext.Msg.WARNING
                                    });
                        // console.log('Your Amount is Greater...');
                    }
                      _total = Ext.util.Format.number(parseFloat(_total), "0.00");
                      _oldtotal = Ext.util.Format.number(parseFloat(_oldtotal), "0.00");

                    Ext.getCmp("po_total_received").setValue(_total);
                },
                calcBalance: function () {
                    var _total
                    if (purchase_invoice_return_mode === 1) {
                         _total = -1*Ext.getCmp("po_total").getValue();
                    } else {
                         _total = Ext.getCmp("po_total").getValue();
                    }
                    _total = parseFloat(_total);
                    if (_total > 0) {
                        var _paid = parseFloat(Ext.getCmp("po_payment_paid").getValue());
                         var _dis = parseFloat(Ext.getCmp("po_discount_invoice").getValue());
                        var _balance = _total - _paid - _dis;
                        _balance = Ext.util.Format.number(parseFloat(_balance), "0.00");
                        Ext.getCmp("po_payment_total_balance").setValue(_balance);
                    } else {
                        Ext.getCmp("po_payment_total_balance").setValue("0.00");
                    }
                    OBJ_Action.recordChange();
                },
                calcRowFromSubtotal: function () {
                    var subtotal = parseFloat(Ext.getCmp("item_subtotal_po").getValue());
                    if (subtotal) {
                        var p = parseFloat(Ext.getCmp("item_price_po").getValue());
                        var q = parseFloat(Ext.getCmp("item_quantity_po").getValue());
                        var new_p = subtotal / q;
                        Ext.getCmp("item_price_po").setValue(Ext.util.Format.number(new_p, "0.00"));

                        var rec = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0].get("discount_complete");
                    rec = rec? parseFloat(rec):0;
                    var dis = rec ? rec : parseFloat(Ext.getCmp("item_discount_po").getValue());
                      var ePrice = subtotal / q;
                           var disc = ((p - ePrice) / p) * 100;
                    Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0].set("discount_complete",disc);
                    }

                }
                ,
                removeRecord: function (grid_id) {
                    Ext.getCmp(grid_id).store.remove(Ext.getCmp(grid_id).getSelectionModel().getSelection()[0]);
                    if (grid_id == "purchase_invoice_grid") {
                        OBJ_Action.calc.calTotalSubTotal();
                    }
                    OBJ_Action.recordChange();
                }
            }
            OBJ_Action.editme = function () {
                if (editItem.id > 0) {
                    LoadingMask.showMessage('Loading...');
                    Ext.Ajax.request({
                        url: action_urls.get_po_record,
                        params: {
                            po_id: editItem.id
                        },
                        method: 'GET',
                        success: function (response) {
                            jObj = Ext.decode(response.responseText);
                            Ext.getCmp("po_hidden_id").setValue(jObj.po_id);
                            Ext.getCmp("vendors_combo").setValue(jObj.vendor_id);
                            Ext.getCmp("po_id").setValue( jObj.inv_no);
                            Ext.getCmp("po_status").setValue(OBJ_Action.invoiceStatus['_' + jObj.po_status_id]);
                            Ext.get("img_stamp_po").dom.className = "stamps " + OBJ_Action.invoiceStatusImage['_' + jObj.po_status_id];
                            Ext.getCmp("po_date").setValue(jObj.po_date);
                            Ext.getCmp("sub_total_total_po").setValue(jObj.po_total);
                            Ext.getCmp("po_total").setValue(jObj.po_total);
                            Ext.getCmp("po_payment_paid").setValue(jObj.po_paid);
                            Ext.getCmp("po_due_date").setValue(jObj.po_paid_date);
                            Ext.getCmp("po_remarks").setValue(jObj.custom);
                            Ext.getCmp("po_payment_total_balance").setValue(jObj.po_balance);
                            //Ext.getCmp("po_paid_date").setValue(jObj.po_paid_date);
                            Ext.getCmp("purchase_invoice_grid").store.loadData(jObj.order_details);
                             if (jObj.expense_details) {
                                Ext.getCmp("expense_invoice_grid").store.loadData(jObj.expense_details);
                                //alert(expense_invoice_grid);

                            } else {
                                Ext.getCmp("expense_invoice_grid").store.loadData([]);
                            }
                            Ext.getCmp("po_order_status").setValue(jObj.po_status_id);
                            OBJ_Action.nextOrderID = jObj.next_order_id;
                            OBJ_Action.previousOrderID = jObj.pre_order_id;
                            Ext.getCmp("next_po_order_btn").setDisabled((jObj.next_order_id == 0) ? true : false);
                            Ext.getCmp("pre_po_order_btn").setDisabled((jObj.pre_order_id == 0) ? true : false);
                            Ext.getCmp("print_label").setDisabled(false);
                            editItem.id = '0';
                            OBJ_Action.onComplete();
                            OBJ_Action.calc.calGrid();
                            OBJ_Action.calc.calTotalSubTotal();

                            Ext.getCmp("po_tab_panel").setActiveTab(0);
                            LoadingMask.hideMessage();
                            OBJ_Action.resetChanges();
                             // Ext.getCmp("po_tab_panel").down('#po_expense_panel').setDisabled(false);
                            var paidAmount=Ext.getCmp('po_payment_paid').getValue();
                              if(paidAmount>0)
                            {
                             Ext.getCmp("tb_btn_po_save").setDisabled(true)   
                             Ext.getCmp("tb_btn_po_save_new").setDisabled(true)   
                             Ext.getCmp("delete_po_invoice").setDisabled(false)   
                            }
                        },
                        failure: function () {
                            LoadingMask.hideMessage();
                        }
                    });
                }
            }
            OBJ_Action.editme();
            OBJ_Action.autoFillReceive = function () {
                  if(enableWarehouse==1){
              Ext.getCmp('expense_invoice_grid').columns[2].setVisible(true);
            } else {
                 Ext.getCmp('expense_invoice_grid').columns[2].setVisible(false);
            }
                var purchase_grid = Ext.pluck(Ext.getCmp('purchase_invoice_grid').store.data.items, 'data');
                var expense_purchase_grid = Ext.pluck(Ext.getCmp('expense_invoice_grid').store.data.items, 'data');
                var fill_data = [];
                var data = null;

                if (expense_invoice_grid.length === 0) {
                    for (var i = 0; i < purchase_grid.length; i++) {
                        data = {};
                        data.item_id = purchase_grid[i].item_id;
                        data.item_name = purchase_grid[i].item_name;
                        data.item_quantity = purchase_grid[i].item_quantity;
                        data.unit_price = purchase_grid[i].unit_price;
                        data.unit_price = 0;
                        data.unit_id = purchase_grid[i].unit_id;
                        data.conv_from = purchase_grid[i].conv_from;
                        data.sub_total = purchase_grid[i].sub_total;
                        // data.item_location = Ext.getCmp("warehouse_po").getValue();
                        if(enableWarehouse==1){
                        data.warehouse_name = purchase_grid[i].warehouse_name;
                    }
                        data.date_received = new Date();
                         data.item_location_id = purchase_grid[i].ware_id;
                        // data.item_location_id = '1';
                        data.is_received = '';
                        fill_data.push(data);

                    }
                    Ext.getCmp("expense_invoice_grid").store.loadData(fill_data);
                } else {
                    for (var i = 0; i < purchase_grid.length; i++) {
                        var quantity_exits = 0;

                        Ext.each(expense_purchase_grid, function (v, k) {
                            if (v.item_id == purchase_grid[i].item_id) {
                                quantity_exits = quantity_exits + parseFloat(v.item_quantity)
                            }
                        });

                        var quantity_diff = 0;
                        if (quantity_exits) {
                            quantity_diff = parseFloat(purchase_grid[i].item_quantity) - parseFloat(quantity_exits);
                        }

                        if (!quantity_exits || quantity_diff > 0) {
                            data = {};
                            data.item_id = purchase_grid[i].item_id;
                            data.item_name = purchase_grid[i].item_name;
                            data.sub_total = purchase_grid[i].sub_total;
                            data.item_quantity = (!quantity_exits) ? purchase_grid[i].item_quantity : quantity_diff;
                            data.unit_id = purchase_grid[i].unit_id;
                            data.conv_from = purchase_grid[i].conv_from;
                            // data.item_location = Ext.getCmp("warehouse_po").getValue();
                            data.rec_warehouse_name =purchase_grid[i].ware_id;
                            data.date_received = new Date();
                            // data.warehouse_name = purchase_grid[i].warehouse_name;
                               if(enableWarehouse==1){
                             data.warehouse_name = purchase_grid[i].warehouse_name;
                               }
                            data.is_received = '';
                            fill_data.push(data);
                        }

                    }
                    if (fill_data.length) {
                        Ext.getCmp("expense_invoice_grid").store.loadData(fill_data, true);
                    }
                }


                OBJ_Action.countReceived();
                OBJ_Action.recordChange();
            }
               OBJ_Action.countReceived = function (fill) {
                var receive_items = 0;
                var expense_purchase_grid = Ext.pluck(Ext.getCmp('expense_invoice_grid').store.data.items, 'data');
                for (var i = 0; i < expense_purchase_grid.length; i++) {
                    if (expense_purchase_grid[i].is_received) {
                        receive_items = receive_items + parseFloat(expense_purchase_grid[i].item_quantity);
                    }
                }
                Ext.getCmp("po_total_received").setValue(receive_items);
                if (fill && receive_items == parseFloat(Ext.getCmp("po_total_ordered").getValue())) {
                    // Ext.getCmp("po_autofill_rec_btn").disable();
                    Ext.getCmp("po_complete_rec_btn").disable();
                } else {
                    // Ext.getCmp("po_autofill_rec_btn").enable();
                    Ext.getCmp("po_complete_rec_btn").enable();
                }
            }
              OBJ_Action.receiveItem = function () {
                //var sel = Ext.getCmp('receive_invoice_grid').getSelectionModel().getSelection()[0];
                //sel.set("is_received", true);
                OBJ_Action.countReceived();

                if (Ext.getCmp("po_total_received").getValue() == Ext.getCmp("po_total_ordered").getValue()) {
                    Ext.Msg.show({
                        title: 'Mark Fully Received',
                        msg: 'Mark this order as fully received?',
                        buttons: Ext.Msg.YESNO,
                        icon: Ext.Msg.QUESTION,
                        fn: function (btn, text) {
                            if (btn == 'yes') {
                                OBJ_Action.saveme();
                            } 
                        }
                    });
                }
                OBJ_Action.recordChange();
            }

            OBJ_Action.completeOrder = function () {
                var expense_purchase_grid = Ext.getCmp('expense_invoice_grid').store.data.items;
                for (var i = 0; i < expense_purchase_grid.length; i++) {
                    expense_purchase_grid[i].set("is_received", true)
                }
                OBJ_Action.countReceived();
                OBJ_Action.recordChange();
            }
            OBJ_Action.payment = function () {
                    var purchase_grid = Ext.pluck(Ext.getCmp('purchase_invoice_grid').store.data.items, 'data');
                    Ext.getCmp('sub_total_payment_po').setValue(Ext.getCmp("sub_total_total_po").getValue());
                    Ext.getCmp('po_payment_total').setValue(Ext.getCmp("po_total").getValue());
            
            }
            
            OBJ_Action.openItemWindow = function(){
                
            }

            OBJ_Action.addRecord = function () {
                if(Ext.getCmp("po_order_status").getValue()<3){
                if(Ext.getCmp("vendors_combo").getValue()){
                var current_tab = Ext.getCmp("po_tab_panel").items.indexOf(Ext.getCmp("po_tab_panel").getActiveTab());
                if (current_tab == 0) {

                    editModelPO.cancelEdit();
                    var r = Ext.create('modelPurchaseInvoice', {
                        item_name: '----------------',
                        item_quantity: purchase_invoice_return_mode ? -1 : 1,
                        unit_id:"1",
                        unit_name:"Each",
                        warehouse_name:labels_json.purchaseinvoicepanel.default_location,
                        unit_price: '0.00',
                        sale_price: '0.00',
                        discount: '0%',
                        sub_total: '0.00',
                    });
                    var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                    OBJ_Action.addMewInvoiceRow = true;
                    Ext.getCmp("purchase_invoice_grid").store.insert(startEditAt, r);
                    editModelPO.startEdit(startEditAt, 0);
                    Ext.getCmp("item_name_po").focus(true, 10, function () {
                        Ext.getCmp("item_name_po").setValue("");
                        var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
                        sel.set("item_name", '');
                        Ext.getCmp("item_name_po").allowBlank = false;
                        // item_store.proxy.extraParams = { show_type: '1'};
                        item_purchase_store.removeAll();
                        item_purchase_store.clearFilter();
                        item_purchase_store.load({query: ''});
                        OBJ_Action.shiftFocus = false;
                        OBJ_Action.searchKeyPress = 0;
                        OBJ_Action.searchChange = 0;
                        if (Ext.getBody().select(".x-boundlist").elements.length) {
                            Ext.getBody().select(".x-boundlist").elements[0].style.display = "none";
                        }
                    });

                }
                 } 
                 else if (current_tab == 1) {
                    if (Ext.getCmp("po_total_received").getValue() == Ext.getCmp("po_total_ordered").getValue()) {
                        return false;
                    } else {
                    editModelReceive.cancelEdit();
                    var r = Ext.create('modelReceiveInvoice', {
                        item_name: '----------------',
                        item_quantity: purchase_invoice_return_mode ? '-1' : '1',
                        warehouse_name: "Test",
                        unit_price:'0.00',
                        sale_price:"0.00",
                        new_price:'0.00',
                        item_location_id: 'ware_id',
                        inv_item_subTotal: "0.00"
                    });
                    var startEditAt = Ext.getCmp("receive_invoice_grid").store.getCount();
                    Ext.getCmp("receive_invoice_grid").store.insert(startEditAt, r);
                    editModelReceive.startEdit(startEditAt, 0);
                    Ext.getCmp("item_rec_name_po").focus(true, 10, function () {
                        Ext.getCmp("item_rec_name_po").setValue("");
                        var sel = Ext.getCmp('expense_invoice_grid').getSelectionModel().getSelection()[0];
                        sel.set("item_name", '');
                    });
                    }
                }
                 else {
                    Ext.defer(function () {
                        Ext.getCmp("vendors_combo").focus();
                        Ext.getCmp("vendors_combo").setValue('');

                    }, 50);
                }
            }
            }
            Ext.defer(function () {
                Ext.getCmp("vendors_combo").focus();
                Ext.getCmp("vendors_combo").setValue('');

            }, 50);
            if (!document.getElementById("img_stamp_po")) {
                Ext.get("stamp-column_po").appendChild({
                    tag: "div",
                    id: "img_stamp_po",
                    cls: 'stamps open'
                })
            } else {
                document.getElementById("img_stamp_po").className = "stamps open";
            }

            if (purchase_invoice_return_mode === 1) {
                Ext.getCmp("po_due_date").setVisible(false);
                Ext.getCmp("po_status").setVisible(false);
                Ext.get("img_stamp_po").dom.style.display = "none";

                Ext.getCmp('purchase_invoice_grid').columns[7].setText(labels_json.purchaseinvoicepanel.col_deduction);
                Ext.getCmp("purchase-invoice-panel").setTitle(labels_json.purchaseinvoicepanel.heading_title_1);
                Ext.getCmp("po_tab_panel").child('#po_sale_panel').tab.setText(labels_json.purchaseinvoicepanel.heading_title_1);
                // Ext.getCmp("po_tab_panel").child('#po_expense_panel').tab.hide();
                Ext.getCmp("purchase_order_status_search").setVisible(false);

                Ext.getCmp("next_po_order_btn").setVisible(false);
                Ext.getCmp("pre_po_order_btn").setVisible(false);
            } else {
                Ext.getCmp("po_due_date").setVisible(true);
                Ext.getCmp("po_status").setVisible(false);
                Ext.get("img_stamp_po").dom.style.display = "block";

                Ext.getCmp('purchase_invoice_grid').columns[7].setText(labels_json.purchaseinvoicepanel.col_discount);

                Ext.getCmp("purchase-invoice-panel").setTitle(labels_json.purchaseinvoicepanel.heading_title_0);
                Ext.getCmp("po_tab_panel").child('#po_sale_panel').tab.setText(labels_json.purchaseinvoicepanel.heading_title_0);
                Ext.getCmp("po_tab_panel").child('#po_expense_panel').tab.show();
                Ext.getCmp("purchase_order_status_search").setVisible(true);
                Ext.getCmp("next_po_order_btn").setVisible(true);
                Ext.getCmp("pre_po_order_btn").setVisible(true);
            }
            Ext.getCmp("po_type").setValue(purchase_invoice_return_mode);
            
            OBJ_Action.onComplete();
        }

    },
    items: [
        {
            region: 'west',
            width: 255,
            title: labels_json.purchaseinvoicepanel.button_search,
            split: true,
            collapsible: true,
            collapsed: true,
            id: 'purchase_left_panel',
            layout: 'border',
            listeners: {
                expand: function () {
                    var s = Ext.getCmp("purchase-invoice-panel-grid").store;
                    s.load({params: {poreturn: purchase_invoice_return_mode}});
                    Ext.defer(function () {
                        Ext.getCmp("purchase_order_number_search").focus(true)
                    }, 200);
                    var map_register = new Ext.util.KeyMap("purchase_left_panel", [
                        {
                            key: [10, 13],
                            fn: function () {
                                Ext.getCmp("po_search_btn").fireHandler();
                            }
                        }
                    ]);
                }
            },
            items: [{
                    region: 'north',
                    layout: 'anchor',
                    height: 115,
                    items: [
                        {
                            xtype: 'textfield',
                            fieldLabel: labels_json.purchaseinvoicepanel.text_order_no,
                            id: 'purchase_order_number_search'
                        },
                        {
                            xtype: 'combo',
                            
                            fieldLabel: labels_json.purchaseinvoicepanel.text_status,
                            id: 'purchase_order_status_search',
                            displayField: 'name',
                            queryMode: 'local',
                            typeAhead: true,
                            valueField: 'id',
                            value: '0.00',
                            store: new Ext.data.Store({
                                fields: ['id', 'name'],
                                data: [
                                    {"id": "0", "name": "All"},
                                    {"id": "1", "name": "Open"},
                                    {"id": "2", "name": "In Progress"},
                                    {"id": "3", "name": "Completed"}
                                ]
                            })
                        },
                        {
                            xtype: 'combo',
                            
                            fieldLabel: labels_json.purchaseinvoicepanel.text_vendor,
                            displayField: 'vendor_name',
                            valueField: 'vendor_id',
                            id: 'purchase_order_vendor_search',
                            allowBlank: false,
                            queryMode: 'local',
                            value: '-1',
                            typeAhead: true,
                            store: vendor_store_withall

                        }, 
                        {
                            layout: 'border',
                            border: false,
                            bodyBorder: false,
                            height: 22,
                            defaults: {
                                border: false
                            },
                            items: [{
                                    region: 'center',
                                    items: [{
                                            xtype: 'button',
                                            
                                            text: labels_json.purchaseinvoicepanel.button_show_all,
                                            style: 'float:right',
                                            width: 80,
                                            listeners: {
                                                click: function () {
                                                    Ext.getCmp("purchase-invoice-panel-grid").store.load({params: {poreturn: purchase_invoice_return_mode}});
                                                }
                                            }
                                        }, {
                                            xtype: 'button',
                                            
                                            text: labels_json.purchaseinvoicepanel.button_search,
                                            style: 'float:right;margin-right:10px',
                                            width: 80,
                                            id: 'po_search_btn',
                                            listeners: {
                                                click: function () {
                                                    Ext.getCmp("purchase-invoice-panel-grid").store.load({
                                                        params: {search: '1',
                                                            search_invoice_id: Ext.getCmp("purchase_order_number_search").getValue(),
                                                            search_status: Ext.getCmp("purchase_order_status_search").getValue(),
                                                            search_vendor: Ext.getCmp("purchase_order_vendor_search").getValue(),
                                                            poreturn: purchase_invoice_return_mode
                                                        }
                                                    });
                                                }
                                            }
                                        }]
                                }]

                        }
                    ]
                }, {
                    region: 'center',
                    layout: 'fit',
                    border: false,
                    bodyBorder: false,
                    id: 'item_center_panel',
                    items: [{xtype: "gridpanel",
                            style:'width:100%',
                            id: "purchase-invoice-panel-grid",
                            store: {
                                proxy: {
                                    type: "ajax",
                                    url: action_urls.get_po,
                                    reader: {
                                        type: "json",
                                        root: 'orders',
                                        idProperty: 'po_id'
                                    }
                                },
                                model: Ext.define("poorderListSearchModel", {
                                    extend: "Ext.data.Model",
                                    fields: [
                                        {name: "po_id", type: 'string', convert: function (v, r) {
                                                return  v;
                                            }
                                        },
                                        "id",
                                        "po_date",
                                        "inv_no",
                                        "po_status",
                                        "vendor_name",
                                        "vendor_id",
                                        "po_due_date",
                                        "po_total",
                                        "po_paid",
                                        "po_balance",
                                        "order_date"

                                    ]
                                }) && "poorderListSearchModel"

                            },
                            listeners: {
                                afterRender: function () {
                                    //this.superclass.afterRender.call(this);
                                    this.nav = new Ext.KeyNav(this.getEl(), {
                                        del: function (e) {
                                        }
                                    });
                                }, itemdblclick: function (v, r, item, index, e, args) {
                                    if(user_right==1){
                                        editItem.id = r.get("id");
                                        OBJ_Action.editme();
                                    } else {
                                        if(purchase_invoice_return_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_invoice.actions.edit){ 
                                        editItem.id = r.get("id");
                                        OBJ_Action.editme();
                                    } else if(purchase_invoice_return_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_return.actions.edit){ 
                                        editItem.id = r.get("id");
                                        OBJ_Action.editme();
                                    }  else {
                                        Ext.Msg.show({
                                            title:'User Access Conformation',
                                            msg:'You have no access to Edit this invoice',
                                            buttons:Ext.Msg.OK,
                                            callback:function(btn) {
                                                if('ok' === btn) {
                                                }
                                            }
                                        });
                                    }
                                    }
                                    
                                }

                            },
                            columnLines: true,
                            columns: [
                                {header: labels_json.purchaseinvoicepanel.text_order_no, dataIndex: "inv_no", width: 60},
                                {header: labels_json.purchaseinvoicepanel.text_vendor, dataIndex: "vendor_name", width: 135},
                                {header: labels_json.purchaseinvoicepanel.text_date, dataIndex: "order_date", width: 60}

                            ]
                        }]
                }]

        },
        {
            region: 'center',
            layout: 'fit',
            items: new Ext.FormPanel({
                layout: 'border',
                
                id: 'purchase-invoice-panel-form',
                bodyBorder: false,
                defaults: {
                    border: false
                },
                items: [{
                        region: 'north',
                        height: 90,
                        layout: 'column',
                        bodyBorder: false,
                        defaults: {
                            layout: 'anchor',
                            border: false,
                            defaults: {
                                anchor: '100%'
                            }
                        },
                        items: [
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 5,
                                items: [
                                    {
                                        xtype: 'combo',
                                        tabIndex: 1,
                                        //fieldLabel: labels_json.purchaseinvoicepanel.text_vendor,
                                        id: 'vendors_combo',
                                        allowBlank: false,
                                        emptyText: labels_json.purchaseinvoicepanel.text_vendor_text,
                                        // forceSelection: true,
                                        name: 'vendor_id',
                                        valueField: 'vendor_id',
                                        displayField: 'vendor_name',
                                        value: labels_json.purchaseinvoicepanel.text_vendor_text,
                                        enableKeyEvents:true,
                                        store: vendor_store_active,
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                                if (f.getValue() !== "-2") {
                                                    Ext.getCmp("vendor_info").setValue(f.getValue());
                                                    Ext.getCmp("vendor_name_save").setValue(f.getRawValue());
                                                 
                                                    var record = f.findRecordByValue(f.getValue());
                                                    if (record) {
                                                        this.up("form").getForm().findField("vendor_contact").setValue(record.get("vendor_contact"));
                                                        this.up("form").getForm().findField("vendor_mobile").setValue(record.get("vendor_mobile"));
                                                        this.up("form").getForm().findField("vendor_group").setValue(record.get("vendor_address"));
                                                        OBJ_Action.recordChange();
                                                    }
                                                } else {
                                                    new_vendor_form.show();
                                                    // Ext.getCmp("vendors_combo").setValue("");
                                                }

                                            },
                                       keyup: function (obj, e, opts) {
                                        var data=this.getValue();
                                        var vendor=Ext.getCmp("vendor_info").getValue();

                                        console.log(vendor);
                                        if(data ==null)
                                        {
                                            // console.log(data)
                                            e.preventDefault();
                                           
                                        }
                                        else if(Ext.isNumeric(vendor)){
                                             e.preventDefault();
                                        }
                                        else{
                                             if (e.getKey() == Ext.EventObject.ENTER) {

                                                      var myForm = new Ext.form.Panel({
                                        title: 'Customer Not Found',
                                        region:'left',
                                        layout:'fit',
                                        
                                        cls: 'quickAdd',
                                        width: 400,
                                        bodyStyle:{"padding": "5px;","background":"#b1b7ff61"},
                                        height: 150,
                                        id:'customer_add',
                                        floating: true,
                                        closable : true,
                                        html: '<span class="info"></span><p>Name Not in the customer list!.<br> To Automatically add new customer job click Quick Add <br> To Enter the Detail information click Setup.</p>',
                                        renderTo: Ext.getBody(),
                                         buttons: [{

                                          text:"Quick Add",
                                          style:{"background":"#B7DCFB;","padding": "5px;","font-size": "18px !important;"},
                                          handler: function(){
                                               Ext.Ajax.request({
                                            url: action_urls.save_vendor,
                                            method: 'POST',
                                            params: {
                                                vendor_name: Ext.getCmp("vendor_name_save").getValue(),
                                                add_type: 1,
                                                vendor_obalance: 0
                                            },
                                            success: function (response) {
                                                var action = Ext.JSON.decode(response.responseText);
                                                console.log(action.data);
                                                Ext.getCmp("vendors_combo").store.loadData(action.data.vendors);
                                                 Ext.getCmp("vendors_combo").setValue(""+action.obj_id);
                                                myForm.close();
                                            },
                                            failure: function () {}
                                        });
                                          }
                                       },
                                       {

                                          text:"Set Up",
                                          
                                          style:{"padding": "5px;"},
                                          handler: function(){
                                             new_vendor_form.show();
                                          }
                                       },{
                                          text:"Cancel",
                                          
                                           style:{"padding": "5px;"},
                                          handler: function(){
                                             myForm.close();
                                          }
                                      }
                                       ],
                                        buttonAlign: 'left',
                                    });
                                               
                                    myForm.show(); 
                                          }        
                                        }

                                },
                                    }
                                    },
                                    {
                                        xtype: 'textfield',
                                        fieldLabel: labels_json.purchaseinvoicepanel.text_contact,
                                        
                                        name: 'vendor_contact',
                                        id: 'vendor_contact',
                                        hidden:true,
                                    },
                                    {
                                        xtype: 'textfield',
                                        emptyText: labels_json.purchaseinvoicepanel.text_mobile,
                                        name: 'vendor_mobile',
                                        id: 'vendor_mobile'
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'po_hidden_id',
                                        id: 'po_hidden_id',
                                        value: '0'
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'vendor_info',
                                        id: 'vendor_info',
                                        value: '0',
                                    },
                                     {
                                        xtype: 'hidden',
                                        name: 'vendor_name_save',
                                        id: 'vendor_name_save',
                                        value: '0',
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'po_type',
                                        id: 'po_type',
                                        value: '',
                                        listeners: {
                                            change: function (obj) {
                                                obj.setValue(purchase_invoice_return_mode);
                                            }
                                        }
                                    }, {
                                        xtype: 'hidden',
                                        name: 'po_already_shipped',
                                        id: 'po_already_shipped',
                                        value: '0'
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'vendor_group',
                                        id: 'vendor_group',
                                        value: '1'
                                    },

                                     {
                                        xtype: 'hidden',
                                        name: 'po_order_status',
                                        id: 'po_order_status',
                                        value: '0'
                                    }, {
                                        layout: {
                                            type: 'table',
                                            columns: 5,
                                            tableAttrs: {
                                                width: '200px'
                                            }
                                        },
                                        border: false,
                                        bodyBorder: false,
                                        id: 'po_action_btn_panel',
                                        margin: '5 0 0 0',
                                        items: [
                                            {
                                                xtype: 'button',
                                                tooltip: labels_json.purchaseinvoicepanel.button_add_item,
                                                id: 'po_new_item',
                                                iconCls: 'add_new',
                                                width: 25,
                                                listeners: {
                                                    click: function () {
                                                        OBJ_Action.addRecord();
                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'button',
                                                tooltip: labels_json.purchaseinvoicepanel.button_delete_item,
                                                margin: '0 0 0 5',
                                                id: 'po_del_item',
                                                 
                                                iconCls: 'delete',
                                                width: 25,
                                                listeners: {
                                                    click: function () {
                                                        var current_tab = Ext.getCmp("po_tab_panel").items.indexOf(Ext.getCmp("po_tab_panel").getActiveTab());
                                                        if (current_tab == 0) {
                                                            OBJ_Action.calc.removeRecord('purchase_invoice_grid');
                                                        } else {
                                                            OBJ_Action.calc.removeRecord('expense_invoice_grid');
                                                        }

                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'button',
                                                tooltip: labels_json.purchaseinvoicepanel.button_add_items,
                                                id: 'po_new_items',
                                                margin: '0 0 0 5',
                                                iconCls: 'add_m_items',
                                                width: 25,
                                                listeners: {
                                                    click: function () {
                                                        if(Ext.getCmp("vendors_combo").getValue()){
                                                            multi_items_form.show();
                                                        }
                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'button',
                                                tooltip: labels_json.purchaseinvoicepanel.button_create_item,
                                                 
                                                id: 'po__create_item',
                                                margin: '0 0 0 5',
                                                iconCls: 'new',
                                                width: 25,
                                                listeners: {
                                                    click: function () {
                                                        if(Ext.getCmp("vendors_combo").getValue()){
                                                        editModelPO.cancelEdit();
                                                        new_item_form.show();
                                                    }
                                                    }
                                                }
                                            },
                                        {
                                                xtype: 'button',
                                                //text: labels_json.saleinvoicepanel.button_delete_item,
                                                margin: '0 0 0 25',
                                                tabIndex:-1,
                                                iconCls: 'remove',
                                                tooltip: labels_json.purchaseinvoicepanel.button_delete_item_all,
                                                id: 'po_remove_all_item',
                                                width: 25,
                                                listeners: {
                                                    click: function () {
                                                        if(Ext.getCmp("purchase_invoice_grid").store.getCount() > 0){
                                                            Ext.Msg.show({
                                                                title: 'Item List Warning',
                                                                msg: 'Are you sure you want to remove all items from list?',
                                                                buttons: Ext.Msg.YESNO,
                                                                icon: Ext.Msg.WARNING,
                                                                fn: function (btn, text) {
                                                                    if (btn == 'no') {
                                                                        return false;
                                                                    } else {
                                                                        Ext.getCmp('purchase_invoice_grid').store.removeAll();
                                                                        Ext.getCmp("sub_total_total_po").setValue("0.00");
                                                                        Ext.getCmp("sale_total").setValue("0.00");
                                                                        Ext.getCmp("po_payment_paid").setValue("0.00");
                                                                        Ext.getCmp("po_payment_total_balance").setValue("0.00");
                                                                        Ext.getCmp("sub_total_item_po").setValue("0.00");
                                                                        Ext.getCmp("sub_total_qty_po").setValue("0.00");
                                                                        Ext.getCmp("sub_total_base_qty_po").setValue("0.00");
                                                                        Ext.getCmp("sub_total_unit_price_po").setValue("0.00");
                                                                        Ext.getCmp("sub_total_discount_po").setValue("0.00");
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                          return false;  
                                                        }
                                                        
                                                     }
                                                }
                                            }]


                                    }
                                ]
                            }, 
                            {
                columnWidth: 1 / 4,
                baseCls: 'x-plain',
                padding: 5,
                items: [
                     {
                    xtype: 'combo',
                    fieldLabel: '',
                    id: 'pur_expense_combo',
                    // allowBlank: false,
                    emptyText: 'Select a Expense...',
                    // forceSelection: true,
                    // hidden: true,
                    name: 'expense_id',
                    valueField: 'expense_id',
                    displayField: 'expense_name',
                    value: 'Select Expense',
                    store: expense_store_active,
                    queryMode: 'local',
                    listeners: {
                        change: function (f, obj) {
                           
                        }
                    }
                },
                    {
                        xtype: 'textfield',
                        name: 'salerep_mobile',
                        emptyText: 'Enter Expense',
                        value:'',
                        width:'100%',
                        maxWidth:'100%',
                        id: 'expenseAmount',
                        listeners: {
                            click: function () {
//                                OBJ_Action.recordChange();            
                            }
                        }
                    },
                    {
                        xtype:'button',
                        text:'Insert Expense',
                        id:'insertExpense',
                          listeners: {
                            click: function (f) {
                                    var amount = Ext.getCmp('expenseAmount').getValue();
                                    var expenseType = Ext.getCmp('pur_expense_combo').getValue();
                                  Ext.Ajax.request({
                                url: action_urls.url_PurchasesaveExpense,
                                method: 'POST',
                                params: {
                                    amount:amount,
                                    expenseType:expenseType,
                                    payment_time: Ext.Date.format(new Date(), 'H:i:s'),
                                    payment_date: Ext.Date.format(new Date(), 'd-m-Y')

                                },
                                success: function (response) {
                                        // alert(response)
                                     var jObj = Ext.decode(response.responseText);
                                                Ext.Msg.show({
                                         title:'Success',
                                         msg: jObj.msg,
                                         buttons: Ext.Msg.OK,
                                         icon: Ext.Msg.INFO
                                    });
                                },
                                failure: function () {
                                    LoadingMask.hideMessage();
                                }
                            });
                                    
                            }
                        }
                    }
                    
                ]
            },
                            {
                                columnWidth: 0.6 / 3,
                                baseCls: 'x-plain',
                                id: 'stamp-column_po',
                                height: 98,
                                padding: 5,
                                items: [
                                    
                                ]
                            },
                            {
                                columnWidth: 1.4 / 3,
                                baseCls: 'x-plain',
                                margin: '5 2 0 0',
                                id: 'date-column-po',
                                style: 'position:relative;float:right',
                                height: 90,
                                layout: {
                                    type: 'table',
                                    columns: 1,
                                    tableAttrs: {
                                        width: '230px',
                                        style: 'float:right'
                                    }
                                },
                                items: [{
                                        xtype: 'fieldset',
                                        collapsible: false,
                                        padding: '1 3 0 5',
                                        defaults: {labelWidth: 60},
                                        items: [{
                                                xtype: 'textfield',
                                                fieldLabel: labels_json.purchaseinvoicepanel.text_order_no,
                                                readOnly: true,
                                                cls: 'readonly',
                                                
                                                id: 'po_id',
                                                name: 'po_id',
                                                enableKeyEvents: true,
                                                listeners: {
                                                    change: function () {
                                                        OBJ_Action.recordChange();

                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: labels_json.purchaseinvoicepanel.text_date,
                                                name: 'po_date',
                                                 
                                                id: 'po_date',
                                                value: new Date(),
                                                maxValue: new Date(),
                                                format: 'd-m-Y',
                                                submitFormat: 'Y-m-d'
                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: labels_json.purchaseinvoicepanel.text_due_date,
                                                name: 'po_due_date',
                                                 
                                                id: 'po_due_date',
                                                value: Ext.Date.add(new Date(), Ext.Date.DAY, 7),
                                                format: 'd-m-Y',
                                                submitFormat: 'Y-m-d'
                                            }
                                            ,
                                            {
                                                xtype: 'textfield',
                                                fieldLabel: labels_json.purchaseinvoicepanel.text_status,
                                                value: 'Open',
                                                 
                                                id: 'po_status',
                                                name: 'po_status',
                                                readOnly: true,
                                                cls: 'readonly',
                                                hidden:true
                                            }]
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        region: 'center',
                        xtype: 'tabpanel',
                        tabPosition: 'bottom',
                        bodyBorder: false,
                        border: false,
                        id: 'po_tab_panel',
                        defaults: {
                            border: false,
                            bodyBorder: false
                        },
                        items: [
                            {
                                title: labels_json.purchaseinvoicepanel.tab_purchase,
                                layout: 'border',
                                style: 'font-size:16px;',
                                id: 'po_sale_panel',
                                bodyBorder: false,
                                border: false,
                                defaults: {
                                    border: false,
                                    bodyBorder: false
                                },
                                listeners:{
                                    show:function(){
                                        Ext.get("po_action_btn_panel").setStyle("display", "block");
                                        Ext.getCmp("vendors_combo").setVisible(true);
                                        Ext.getCmp("vendor_mobile").setVisible(true);
                                        Ext.getCmp("insertExpense").setVisible(false);
                                        Ext.getCmp("expenseAmount").setVisible(false);
                                        Ext.getCmp("pur_expense_combo").setVisible(false);
                                    }
                                },
                                items: [{
                                        region: 'center',
                                        layout: 'fit',
                                        items: [{
                                              features: [{
                                                    ftype: 'summary',
                                                     dock: 'bottom'
                                                }],
                                                xtype: "gridpanel",
                                                tabIndex:3,
                                                id: "purchase_invoice_grid",
                                                plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                                        clicksToMoveEditor: 1,
                                                        autoCancel: false,
                                                        listeners: {
                                                            'canceledit': function (e) {
                                                                var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                                                                if(startEditAt>0){
                                                                    Ext.getCmp("tb_btn_po_new").setDisabled(false);
                                                                    Ext.getCmp("tb_btn_po_save").setDisabled(false);
                                                                    Ext.getCmp("tb_btn_po_save_new").setDisabled(false);  
                                                                } else {
                                                                    Ext.getCmp("tb_btn_po_new").setDisabled(true);
                                                                    Ext.getCmp("tb_btn_po_save").setDisabled(true);
                                                                    Ext.getCmp("tb_btn_po_save_new").setDisabled(true);  
                                                                }
                                                                OBJ_Action.searchKeyPress = 0;
                                                                OBJ_Action.searchChange = 0;
                                                                OBJ_Action.shiftFocus = false;
                                                                if (Ext.getCmp("item_name_po").getValue() === "----------------") {
                                                                    var grid = e.grid;
                                                                    var rowIndex = -1;
                                                                    var _data = Ext.getCmp('purchase_invoice_grid').store.data;
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
                                                                OBJ_Action.calc.calTotalSubTotal();
                                                                OBJ_Action.addRecord();
                                                            }
                                                            ,
                                                            'beforeedit': function (e,obj) { 
                                                                Ext.getCmp("tb_btn_po_new").setDisabled(true);
                                                                Ext.getCmp("tb_btn_po_save").setDisabled(true);
                                                                Ext.getCmp("tb_btn_po_save_new").setDisabled(true);
                                                                
                                                                if(user_right==1 || user_right==3){
                                                                    OBJ_Action.editRecordRow(e,obj);
                                                                } else {
                                                                    if(purchase_invoice_return_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_invoice.actions.edit)
                                                                    { 
                                                                        OBJ_Action.editRecordRow(e,obj);
                                                                    } 
                                                                    else if(purchase_invoice_return_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_return.actions.edit)
                                                                    { 
                                                                        OBJ_Action.editRecordRow(e,obj);
                                                                    } 
                                                                    else 
                                                                    {
                                                                        Ext.Msg.show({
                                                                            title:'User Access Conformation',
                                                                            msg:'You have no access to Edit this invoice',
                                                                            buttons:Ext.Msg.OK,
                                                                            callback:function(btn) {
                                                                                if('ok' === btn) {
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                            },
                                                            validateedit: function () {
                                                                if (OBJ_Action.searchKeyPress > OBJ_Action.searchChange) {
                                                                    return false;
                                                                }
                                                            } 
                                                        }
                                                    })],
                                                store: {
                                                    proxy: {
                                                        type: "memory",
                                                        reader: {
                                                            type: "json",
                                                            idProperty: 'item_id'
                                                        }
                                                    },
                                                    model: Ext.define("modelPurchaseInvoice", {
                                                        extend: "Ext.data.Model",
                                                        fields: [
                                                            "item_name",
                                                            "item_id",
                                                            "item_quantity",
                                                            "bonus_quantity",
                                                            "conv_from",                                                            
                                                            "unit_name",
                                                            "warehouse_name",
                                                            "ware_id",
                                                            "unit_id",
                                                            "unit_price",
                                                            "sale_price",
                                                            "discount",
                                                            "discount_complete",
                                                            {name: "sub_total", type: 'float', convert: function (v, rec) {
                                                                    return Ext.util.Format.number(v, "0.00")
                                                                }}
                                                        ]
                                                    }) && "modelPurchaseInvoice",
                                                    data: []
                                                },
                                                listeners: {
                                                    afterRender: function () {
                                                        //this.superclass.afterRender.call(this);
                                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                                            del: function (e) {
                                                                OBJ_Action.calc.removeRecord('purchase_invoice_grid');
                                                            }
                                                        });
                                                    },
                                                    beforecellclick: function(){
                                                        Ext.getCmp("item_name_po").focus(true);
                                                        return false;
                                                    }
                                                    ,
                                                    containerclick: function () {
                                                        
                                                        editModelPO.cancelEdit();
                                                        OBJ_Action.addRecord();
                                                    },
                                                     itemmouseenter: function (view, record, item,index) {
                                                        OBJ_Action.mouseOverRow = index;                                                                                                                                                                 
                                                    }

                                                },
                                                columnLines: true,
                                                columns: [
                                                    {header: labels_json.purchaseinvoicepanel.col_item, dataIndex: "item_name", flex: 1,
                                                     
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
                                                            store: item_purchase_store,
                                                            triggerAction: 'all',
                                                            pageSize: 50,
                                                            enableKeyEvents:true,
                                                            valueField: 'item',
                                                            emptyText: labels_json.purchaseinvoicepanel.select_item_emptyText,
                                                            typeAhead: true,
                                                            id: 'item_name_po',
                                                            listeners: {
                                                                beforeRender: function(){
                                                                    
                                                                },
                                                                
                                                                change: function (f, obj) {
                                                                    if (f.getValue() == "") {
                                                                        OBJ_Action.searchKeyPress = 0;
                                                                        OBJ_Action.searchChange = 0;
                                                                    } else {
                                                                        OBJ_Action.searchChange = OBJ_Action.searchChange + 1;
                                                                    }
                                                                    OBJ_Action.shiftFocus = true;
                                                                    var record = f.findRecordByValue(f.getValue());
                                                                    if (record) {
                                                                        Ext.getCmp("item_quantity_po").setDisabled(false);                                                                        
                                                                        Ext.getCmp("bonus_qty_po").setDisabled(false);                                                                        
                                                                        Ext.getCmp("item_price_po").setDisabled(false);
                                                                        Ext.getCmp("item_sale_price_po").setDisabled(false);
                                                                        Ext.getCmp("item_discount_po").setDisabled(false);                                                                        
                                                                        Ext.getCmp("item_subtotal_po").setDisabled(false); 
                                                                        Ext.getCmp("purchase_item_uom").setDisabled(false);
                                                                          if(enableWarehouse==1)
                                                                            {
                                                                                  Ext.getCmp("warehouse_po").setDisabled(false);
                                                                            }
                                                                           
                                                                        var data = record.get("item_units");
                                                                        uom_store_temp.removeAll();
                                                                        for(var i=0;i<data.length;i++){
                                                                            uom_store_temp.add(data[i]);
                                                                            if(record.get("purchase_item_uom")==data[i].unit_id){
                                                                            var avg_cost = Ext.util.Format.number(data[i].nprice, "0.00");
                                                                            Ext.getCmp("item_sale_price_po").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));                                                                            
                                                                            Ext.getCmp("item_price_po").setValue(Ext.util.Format.number(avg_cost, "0.00"));
                                                                            Ext.getCmp("purchase_item_uom").setValue(data[i].unit_name);
                                                                            var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
                                                                            sel.set("unit_id", data[i].unit_id);
                                                                            sel.set("unit_name", data[i].unit_name);
                                                                            sel.set("conv_from", data[i].conv_from);
                                                                            sel.set("normal_price", avg_cost);                                                                            
                                                                            sel.set("base_avg_cost", Ext.util.Format.number(record.get("nprice"), "0.00"))
                                                                          }


                                                                        }
                                                                        var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        sel.set("item_id", record.get("id"));
                                                                        sel.set("ware_id", 1);
                                                                        OBJ_Action.recordChange();
                                                                        OBJ_Action.calc.calRowSubTotal();
                                                                            if (OBJ_Action.shiftFocus) {
                                                                                Ext.defer(function () {
                                                                                Ext.getCmp("item_quantity_po").focus(true)
                                                                            }, 100);
                                                                                OBJ_Action.shiftFocus = false;
                                                                                OBJ_Action.searchKeyPress = 0;
                                                                                OBJ_Action.searchChange = 0;
                                                                            }
                                                                        
                                                                        
                                                                        
                                                                    }
                                                                    else{
                                                                        Ext.getCmp("item_quantity_po").setDisabled(true);                                                                        
                                                                        Ext.getCmp("bonus_qty_po").setDisabled(true);                                                                        
                                                                        Ext.getCmp("item_price_po").setDisabled(true);
                                                                        Ext.getCmp("item_sale_price_po").setDisabled(true);
                                                                        Ext.getCmp("item_discount_po").setDisabled(true);                                                                        
                                                                        Ext.getCmp("item_subtotal_po").setDisabled(true);
                                                                        Ext.getCmp("purchase_item_uom").setDisabled(true);

                                                                       if(enableWarehouse==1)
                                                                            {
                                                                                  Ext.getCmp("warehouse_po").setDisabled(false);
                                                                            }
                                                                    }
                                                                },
                                                                paste: {
                                                                    element: 'inputEl',
                                                                    fn: function(event, inputEl,obj) {
                                                                    if(event.type == "paste"){
                                                                     OBJ_Action.searchChange = 1;
                                                                     }
                                                                    }
                                                                    },
                                                                keydown: function (obj, e, opts) {
                                                                    if (e.getKey() == Ext.EventObject.TAB || e.getKey() == Ext.EventObject.ENTER) {
                                                                        OBJ_Action.shiftFocus = true;
                                                                    } else {
                                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchKeyPress + 1;
                                                                    }
                                                                },
                                                                
                                                                focus: function () {
                                                                    OBJ_Action.searchKeyPress = 0;
                                                                    OBJ_Action.searchChange = 0;
                                                                    OBJ_Action.shiftFocus = false;
                                                                    Ext.defer(function () {
                                                                        Ext.getCmp("item_name_po").setEditable(true)
                                                                    }, 100);
                                                                    //console.log(Ext.getCmp('item_name_po').store.totalCount)
                                                                    //item_store.remove(item_store.findRecord('type', '3'));
                                                                },
                                                                click: function () {
                                                                    OBJ_Action.shiftFocus = false;
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_quantity, dataIndex: "item_quantity", width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_quantity_po',
                                                            allowBlank: false,
                                                            maxLength: 8,
                                                            readOnly: false,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function (obj, e) {
                                                                    if (e.getKey() == Ext.EventObject.ENTER) {
                                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchChange = 0;
                                                                    }
                                                                    OBJ_Action.calc.calRowSubTotal();
                                                                },
                                                                change: function (f) {
                                                                    if (purchase_invoice_return_mode == "1") {
                                                                        var value = parseFloat(f.getValue());
                                                                        if (value > 0) {
                                                                            f.setValue(value * -1);
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    },
                                                      {header: "Bonus Qty", dataIndex: "bonus_quantity", width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'bonus_qty_po',
                                                            allowBlank: true,
                                                            maxLength: 8,
                                                            readOnly: false,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function (obj, e) {
                                                                    if (e.getKey() == Ext.EventObject.ENTER) {
                                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchChange = 0;
                                                                    }
                                                                    // OBJ_Action.calc.calRowSubTotal();
                                                                },
                                                                change: function (f) {
                                                                    if (purchase_invoice_return_mode == "1") {
                                                                        var value = parseFloat(f.getValue());
                                                                        if (value > 0) {
                                                                            f.setValue(value * -1);
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_item_uom, dataIndex: "unit_name", width: 100,
                                                        editor: {
                                                            xtype: 'combo',
                                                            allowBlank: true,
                                                            queryMode: 'local',
                                                            id: 'purchase_item_uom',
                                                            enableKeyEvents: true,
                                                            displayField: 'unit_name',
                                                            store: uom_store_temp,
                                                            valueField: 'unit_name',
                                                            emptyText: 'UOM',
                                                            value:'1',
                                                            listeners: {
                                                                change: function (f, obj) {
                                                                    if (f.getValue() == "") {
                                                                        OBJ_Action.searchKeyPress = 0;
                                                                        OBJ_Action.searchChange = 0;
                                                                    } else {
                                                                        OBJ_Action.searchChange = OBJ_Action.searchChange + 1;
                                                                    }
                                                                    var record = f.findRecordByValue(f.getValue());
                                                                    if (record) {
                                                                        var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        var avg_cost = parseFloat(record.get("nprice"));
                                                                        Ext.getCmp("item_price_po").setValue(Ext.util.Format.number(avg_cost, "0.00"));
                                                                        Ext.getCmp("item_sale_price_po").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));

                                                                        var p = parseFloat(Ext.getCmp("item_sale_price_po").getValue());
                                                                        var q = parseFloat(Ext.getCmp("item_quantity_po").getValue());
                                                                        var d = parseFloat(Ext.getCmp("item_discount_po").getValue());
                                                                        var dPrice = p - (p * d / 100);
                                                                        var total = q * dPrice;
                                                                        
                                                                        Ext.getCmp("item_subtotal_po").setValue(Ext.util.Format.number(Ext.getCmp("item_quantity_po").getValue()*record.get("sprice"), "0.00"));
                                                                        
                                                                        sel.set("unit_id", record.get("unit_id"));
                                                                        sel.set("unit_name", record.get("unit_name"));
                                                                        sel.set("conv_from", record.get("conv_from"));
                                                                        sel.set("normal_price", Ext.util.Format.number(avg_cost, "0.00"));
                                                                        sel.set("base_avg_cost", Ext.util.Format.number(record.get("nprice")));
                                                                        OBJ_Action.recordChange();
                                                                        OBJ_Action.calc.calRowSubTotal();
                                                                        if (OBJ_Action.shiftFocus) {
                                                                            Ext.defer(function () {
                                                                                Ext.getCmp("item_quantity_po").focus(true)
                                                                            }, 100);
                                                                            OBJ_Action.shiftFocus = false;
                                                                            OBJ_Action.searchKeyPress = 0;
                                                                            OBJ_Action.searchChange = 0;
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {
                                                    header: labels_json.purchaseinvoicepanel.text_warehouse, dataIndex: "warehouse_name", width: 100,
                                                     editor:{
                                                            xtype: 'combo',
                                                            allowBlank: true,
                                                            queryMode: 'local',
                                                            id: 'warehouse_po',
                                                            enableKeyEvents: true,
                                                            displayField: 'warehouse_name',
                                                            store: warehouse_store_all,
                                                            valueField: 'warehouse_name',
                                                            emptyText: 'Warehouse',
                                                            value:'1',
                                                             listeners: {
                                                                change: function (f, obj) {
                                                                    var record = f.findRecordByValue(f.getValue());
                                                                    if (record) {
                                                                        var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        sel.set("ware_id", record.get("id"));
                                                                        OBJ_Action.recordChange();
                                                                    }
                                                                }
                                                            }

                                                     }
                                                     
                                                   
                                                     
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_unit_price, dataIndex: "unit_price", width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_price_po',
                                                            allowBlank: false,
                                                            readOnly: false,
                                                            maxLength: 9,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                    OBJ_Action.calc.calRowSubTotal();
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_sale_price, dataIndex: "sale_price", width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_sale_price_po',
                                                            allowBlank: false,
                                                            maxLength: 9,
                                                            readOnly: false,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_discount, dataIndex: "discount", width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_discount_po',
                                                            allowBlank: false,
                                                            readOnly: false,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                    OBJ_Action.calc.calRowSubTotal();
                                                                },
                                                                  change:function(f){                                                                    
                                                                     var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];                                                                        
                                                                     sel.set("discount_complete", '');
                                                                },
                                                                blur: function (field) {
                                                             //Ext.getCmp("item_discount_po").setValue(Ext.util.Format.number(0, "0.00") + "%"); 
                                                                 //  var d = parseFloat(Ext.getCmp("item_discount_po").getValue());
                                                                 //  var q = parseFloat(Ext.getCmp("item_quantity_po").getValue());
                                                                 // if(d==0)
                                                                 // {
                                                                 //       var sel = Ext.getCmp('purchase_invoice_grid').getSelectionModel().getSelection()[0];
                                                                 //        var nprice=sel.get("normal_price");
                                                                 //      var total=nprice*q;
                                                                 //      Ext.getCmp("item_subtotal_po").setValue(Ext.util.Format.number(total, "0.00"));
                                                                 //         OBJ_Action.calc.calTotalSubTotal();   
                                                                 // }
                                                             }
                                                            }

                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_sub_total, dataIndex: "sub_total", width: 200,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            cls: 'grid_look',

                                                            id: 'item_subtotal_po',
                                                            readOnly: false,
                                                            allowBlank: false,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                    OBJ_Action.calc.calcRowFromSubtotal();
                                                                    
                                                                },
                                                                 'keypress': function (field) {
                                                                  Ext.getCmp("item_discount_po").setValue(Ext.util.Format.number(0, "0.00") + "%"); 
                                                               },
                                                                change: function (f) {
                                                                    if (purchase_invoice_return_mode == "1") {
                                                                        var value = parseFloat(f.getValue());
                                                                        if (value > 0) {
                                                                            f.setValue(value * -1);
                                                                        }
                                                                    }
                                                                }


                                                            }
                                                        }
                                                    }, {
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        items: [{
                                                                icon: 'themes/aursoft/images/remove_new.png',
                                                                tooltip: 'Delete',
                                                                handler: function (grid, rowIndex, colIndex) {
                                                                    var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                                                                    if(startEditAt>1){
                                                                        Ext.getCmp("tb_btn_po_new").setDisabled(false);
                                                                        Ext.getCmp("tb_btn_po_save").setDisabled(false);
                                                                        Ext.getCmp("tb_btn_po_save_new").setDisabled(false);  
                                                                    } else {
                                                                        Ext.getCmp("tb_btn_po_new").setDisabled(true);
                                                                        Ext.getCmp("tb_btn_po_save").setDisabled(true);
                                                                        Ext.getCmp("tb_btn_po_save_new").setDisabled(true);  
                                                                    }
                                                                    var status = parseInt(Ext.getCmp("po_order_status").getValue());
                                                                    if(status<3){
                                                                    if(grid.editingPlugin.editing===false){
                                                                        var rec = grid.getStore().getAt(rowIndex);
                                                                        grid.store.remove(rec);
                                                                        OBJ_Action.calc.calTotalSubTotal();
                                                                        OBJ_Action.recordChange();             
                                                                    }
                                                                }
                                                                }
                                                            }]
                                                    }
                                                ]
                                            }]
                                    },
                                    {
                                        region: 'south',
                                        height: 100,
                                        maxHeight:100,
                                        autoHeight: false,
                                        layout: 'fit',
                                        items: [{
                                                layout: 'border',
                                                margin: '0 2 2 0',
                                                border: false,
                                                defaults: {
                                                    border: false,
                                                    bodyBoder: false
                                                },
                                                items: [
                                                    {
                                                        region: 'west',
                                                        width: 500,
                                                        layout: 'fit',
                                                        items: [{
                                                                border: false,
                                                                bodyStyle: 'border:0px;background-color:#e0e0e0;',
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 1,
                                                                    tableAttrs: {
                                                                        width: '100%',
                                                                        style: 'margin-top:2px; margin-bottom:2px',
                                                                    }
                                                                },
                                                                items: [{
                                                                        xtype: 'textarea',
                                                                        //fieldLabel: labels_json.purchaseinvoicepanel.text_remarks,
                                                                        height: 93,
                                                                        width: '100%',
                                                                        name: 'po_remarks',
                                                                        id: 'po_remarks',
                                                                        listeners: {
                                                                            blur: function (f, obj) {
                                                                                var val = f.getValue();
                                                                                if(Ext.getCmp("po_hidden_id").getValue()!='0'){
                                                                                    Ext.Ajax.request({
                                                                                        url: action_urls.save_inv_description,
                                                                                        method: 'POST',
                                                                                        params: {
                                                                                            id: Ext.getCmp("po_hidden_id").getValue(),
                                                                                            desc : val,
                                                                                            table : 'po'
                                                                                        },
                                                                                        success: function (response) {},
                                                                                        failure: function () {}
                                                                                    });
                                                                                }
                                                                                
                                                                                if (val && val.substring(val.length - 1) !== ',') {
                                                                                    f.setValue(val + ',');
                                                                                }
                                                                            },
                                                                            change: function () {
                                                                                OBJ_Action.recordChange();

                                                                            }
                                                                        }
                                                                    }, {
                                                                        xtype: 'button',
                                                                        hidden: true,
                                                                        text: labels_json.purchaseinvoicepanel.text_cancel_order,
                                                                        id: 'po_cancel_reopen_btn',
                                                                        width: 150,
                                                                        listeners: {
                                                                            click: function () {
                                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                                    //Ext.getCmp("po_payment_paid").setValue(Ext.getCmp("po_total").getValue());
                                                                                    //OBJ_Action.saveme();
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                ]
                                                            }]
                                                    },
                                                    
                                                    {
                                                        region: 'east',
                                                        width: 250,
                                                        layout: 'fit',
                                                        items: [{
                                                                bodyStyle: 'border-left:0px;background-color:#e0e0e0;',
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 2,
                                                                    style: 'margin-bottom: 2px;',
                                                                    tableAttrs: {
                                                                        width: '100%',
                                                                        style: 'margin-bottom: 2px; margin-left:10px;',
                                                                    }
                                                                },
                                                                items: [
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_total_item, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'sub_total_item_po',
                                                                        name: 'sub_total_item_po',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_total_qty, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'sub_total_qty_po',
                                                                        name: 'sub_total_qty_po',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_total_base_qty, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '0.00',
                                                                        id: 'sub_total_base_qty_po'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_total_unitprice, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '0.00',
                                                                        id: 'sub_total_unit_price_po'
                                                                    },
                                                                      {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_total_discount, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '0.00',
                                                                        id: 'sub_total_discount_po'
                                                                    }


                                                                ]
                                                            }]
                                                    },
                                                    
                                                    {
                                                        region: 'east',
                                                        width: 220,
                                                        layout: 'fit',
                                                        items: [{
                                                                bodyStyle: 'border-left:0px;background-color:#e0e0e0',
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 2,
                                                                    style: 'margin-bottom: 2px;',
                                                                    tableAttrs: {
                                                                        width: '100%',
                                                                        style: 'margin-bottom: 2px;',
                                                                    }
                                                                },
                                                                items: [

                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'po_total',
                                                                        hidden : true,
                                                                        name: 'po_total',
                                                                        value: '0.00'
                                                                    },
                                                                      
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_sub_total, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'sub_total_total_po',
                                                                        name: 'sub_total_total_po',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        id: 'discount_field_po',
                                                                        autoEl: {
                                                                            tag: 'div',
                                                                            html: 'Discount',
                                                                            cls: 'sub_total_text'
                                                                        }
                                                                    },
                                                                      {
                                                                        xtype: 'textfield',
                                                                        cls: 'total_digit_field',
                                                                        id: 'po_discount_invoice',
                                                                        name: 'po_discount_invoice',
                                                                        width: 100,
                                                                        readOnly: true,
                                                                        value: '0.00',
                                                                        maskRe: /([0-9\s\.]+)$/,
                                                                        regex: /[0-9]/
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_sale_total, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'sale_total',
                                                                        name: 'sale_total',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                         
                                                                        id: 'po_paid_link',
                                                                        autoEl: {
                                                                            tag: 'a',
                                                                            html: labels_json.purchaseinvoicepanel.purchase_list_paid,
                                                                            cls: 'sub_total_text pay_link'
                                                                        },
                                                                        listeners: {
                                                                            el: {
                                                                                click: function (ev) {
                                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                                    var status = parseInt(Ext.getCmp("po_order_status").getValue());
                                                                                    if(status == 1 || status == 2){
                                                                                        var pay_window = invoice_pay_form.down('form').getForm();
                                                                                        invoice_pay_form.show();
                                                                                        pay_window.findField("G_order_type").setValue("1");
                                                                                        pay_window.findField("G_invoice_id").setValue(Ext.getCmp("po_hidden_id").getValue());
                                                                                        pay_window.findField("G_vendor_id").setValue(Ext.getCmp("vendors_combo").getValue());
                                                                                        Ext.getCmp("paid_total").setValue(Ext.util.Format.number(Ext.getCmp("po_payment_total_balance").getValue(), "0.00"));
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                }
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        id: 'po_payment_paid',
                                                                        
                                                                        name: 'po_paid',
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        value: '0.00',
                                                                        maskRe: /([0-9\s\.]+)$/,
                                                                        regex: /[0-9]/,
                                                                        width: 100,
                                                                        enableKeyEvents: true,
                                                                        listeners: {
                                                                            keyup: function () {
                                                                                OBJ_Action.calc.calcBalance();
                                                                                OBJ_Action.recordChange();

                                                                            },
                                                                            change: function () {
                                                                                try {
                                                                                    OBJ_Action.calc.calcBalance();
                                                                                    OBJ_Action.recordChange();
                                                                                } catch (e) {
                                                                                }
                                                                            },
                                                                            focus:function(){
                                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                                    var status = parseInt(Ext.getCmp("po_order_status").getValue());
                                                                                    if(status == 1 || status == 2){
                                                                                        var pay_window = invoice_pay_form.down('form').getForm();
                                                                                        invoice_pay_form.show();
                                                                                        pay_window.findField("G_order_type").setValue("1");
                                                                                        pay_window.findField("G_invoice_id").setValue(Ext.getCmp("po_hidden_id").getValue());
                                                                                        pay_window.findField("G_vendor_id").setValue(Ext.getCmp("vendors_combo").getValue());
                                                                                        Ext.getCmp("paid_total").setValue(Ext.util.Format.number(Ext.getCmp("po_payment_total_balance").getValue(), "0.00"));
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.purchase_list_balance, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '0.00',
                                                                        id: 'po_payment_total_balance'
                                                                    }

                                                                ]
                                                            }]
                                                    }
                                                ]
                                            }]
                                    }
                                ]
                            },
                             {
                                title: labels_json.purchaseinvoicepanel.tab_expense,
                                layout: 'border',
                                id: 'po_expense_panel',
                                bodyBorder: false,
                                border: false,
                                defaults: {
                                    border: false,
                                    bodyBorder: false
                                },
                                listeners:{
                                    show:function(){
                                        Ext.get("po_action_btn_panel").setStyle("display", "none");
                                        Ext.getCmp("vendors_combo").setVisible(false);
                                        Ext.getCmp("vendor_mobile").setVisible(false);
                                        Ext.getCmp("insertExpense").setVisible(true);
                                        Ext.getCmp("expenseAmount").setVisible(true);
                                        Ext.getCmp("pur_expense_combo").setVisible(true);
                                        var _data = Ext.getCmp('purchase_invoice_grid').store.data;
                                        po_receive_item_store.loadData(Ext.pluck(_data.items, 'data'));
                                        // OBJ_Action.autoFillReceive();
                                        if (Ext.getCmp("po_total_received").getValue() == Ext.getCmp("po_total_ordered").getValue()) {
                                            Ext.getCmp("po_complete_rec_btn").disable();
                                        }
                                    }
                                },
                                items: [{
                                        region: 'center',
                                        layout: 'fit',
                                        items: [{
                                                xtype: "gridpanel",
                                                id: "expense_invoice_grid",
                                                plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                                        clicksToMoveEditor: 1,
                                                        autoCancel: false,
                                                        listeners: {
                                                            'canceledit': function (e) {
                                                                if (Ext.getCmp("item_rec_name_po").getValue() === "----------------") {
                                                                    var sm = e.grid.getSelectionModel();
                                                                    e.grid.store.remove(sm.getSelection());
                                                                    if (e.grid.store.getCount() > 0) {
                                                                        sm.select(0);
                                                                    }
                                                                }

                                                            }
                                                            ,
                                                            'edit': function (e) {

                                                            }
                                                            ,
                                                            'renderer':function()
                                                            {
                                                                console.log('working..')
                                                            },
                                                            'beforeedit': function (e) {
                                                                if (Ext.getCmp("po_total_received").getValue() == Ext.getCmp("po_total_ordered").getValue()) {
                                                                    return false;
                                                                }
                                                                

                                                                /*if(parseInt(Ext.getCmp("po_order_status").getValue())===3 ){    
                                                                 editModelReceive.cancelEdit();                                                                                           
                                                                 return false;
                                                                 }*/
                                                            }
                                                        }


                                                    })],
                                                margin: '5 5 2 5',
                                                store: {
                                                    proxy: {
                                                        type: "memory",
                                                        reader: {
                                                            type: "json",
                                                            idProperty: 'item_id'
                                                        }
                                                    },
                                                    model: Ext.define("modelExpenseInvoice", {
                                                        extend: "Ext.data.Model",
                                                        fields: [
                                                            "item_name",
                                                            "item_id",
                                                            "item_quantity",
                                                            "unit_price",
                                                            "sale_price",
                                                            "new_price",
                                                            "unit_id",
                                                            "conv_from",
                                                            "inv_item_subTotal",
                                                            "item_location",
                                                            "warehouseName",
                                                            "item_location_id",
                                                            {
                                                                name: "date_received", type: 'date', format: 'd-m-Y'},
                                                            "is_received"

                                                        ]
                                                    }) && "modelExpenseInvoice",
                                                    data: []
                                                },
                                                listeners: {
                                                    afterRender: function () {
                                                        //this.superclass.afterRender.call(this);
                                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                                            del: function (e) {
                                                                OBJ_Action.calc.removeRecord('purchase_invoice_grid');
                                                            }
                                                        });
                                                    }

                                                },
                                                columnLines: true,
                                                columns: [
                                                    {header: labels_json.purchaseinvoicepanel.col_item, dataIndex: "item_name", flex: 1,
                                                        editor: {
                                                            xtype: 'combo',
                                                            allowBlank: false,
                                                            queryMode: 'local',
                                                            displayField: 'item_name',
                                                            store: po_receive_item_store,
                                                            valueField: 'item_name',
                                                            value: 'Select Item',
                                                            id: 'item_rec_name_po',
                                                            listeners: {
                                                                change: function (f, obj) {
                                                                    var record = f.findRecordByValue(f.getValue());
                                                                    if (record) {
                                                                        Ext.getCmp("item_rec_quantity_po").setValue(record.get("item_quantity"));
                                                                        var sel = Ext.getCmp('expense_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        sel.set("item_id", record.get("item_id"));

                                                                    }
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_quantity, dataIndex: "item_quantity", width: 100,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'item_rec_quantity_po',
                                                            allowBlank: false,
                                                            maskRe: /([0-9]+)$/,
                                                            readOnly: true,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                keyup: function () {
                                                                    OBJ_Action.calc.calRowSubTotal();
                                                                }
                                                            }

                                                        }
                                                    },
                                                    {header: labels_json.purchaseinvoicepanel.col_location, dataIndex: "warehouseName", width: 120,
                                                        editor: {
                                                            xtype: 'combo',
                                                            allowBlank: false,
                                                            queryMode: 'local',
                                                            displayField: 'warehouse_name',
                                                            store: warehouse_store,
                                                            valueField: 'warehouse_name',
                                                            value: 'Default Location',
                                                            id: 'item_rec_warehouse_location',
                                                            listeners: {
                                                                change: function (f, obj) {
                                                                    var record = f.findRecordByValue(f.getValue());
                                                                    if (record) {
                                                                        var sel = Ext.getCmp('expense_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        sel.set("item_location_id", record.get("id"));
                                                                        OBJ_Action.recordChange();
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    },
                                                         {
                                                            header: "Unit Price", dataIndex: "unit_price", width: 120,
                                                        editor: {
                                                             header: "Unit Price",
                                                            dataIndex: "unit_price",
                                                            width: 100,
                                                            editor: {
                                                                xtype: 'textfield',
                                                                id: 'rec_unit_price',
                                                                disabled: true,
                                                                maxLength: 9,
                                                                allowBlank: false,
                                                                maskRe: /([0-9\s\.]+)$/,
                                                                regex: /[0-9]/,
                                                                enableKeyEvents: true,
                                                                listeners: {
                                                                    keyup: function () {
                    //                                                    OBJ_Action.calc.calRowSubTotal();
                                                                    },
                                                                    blur: function () {                                                                    
                    //                                                    OBJ_Action.calc.calRowSubTotal();
                                                                    }
                                                                }

                                                            }

                                                        }
                                                    },
                                                     {
                                                            header: "Sale Price", dataIndex: "sale_price", width: 120,
                                                        editor: {
                                                             header: "Sale Price",
                                                            dataIndex: "sale_price",
                                                            width: 100,
                                                            editor: {
                                                                xtype: 'textfield',
                                                                id: 'rec_sale_price',
                                                                disabled: true,
                                                                maxLength: 9,
                                                                allowBlank: false,
                                                                maskRe: /([0-9\s\.]+)$/,
                                                                regex: /[0-9]/,
                                                                enableKeyEvents: true,
                                                                listeners: {
                                                                    keyup: function () {
                    //                                                    OBJ_Action.calc.calRowSubTotal();
                                                                    },
                                                                    blur: function () {                                                                    
                    //                                                    OBJ_Action.calc.calRowSubTotal();
                                                                    }
                                                                }

                                                            }

                                                        }
                                                    },
                                                          {
                                        header: "New Price",
                                        dataIndex: "new_price",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'rec_item_newPrice',
                                            // disabled: true,
                                            maxLength: 9,
                                            allowBlank: false,
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents: true,
                                            listeners: {
                                                keyup: function () {
                                                   OBJ_Action.calc.calExpenseRowSubTotal();
                                                },
                                                blur: function () {          
                                                OBJ_Action.calc.calExpenseRowSubTotal();                                                          
//                                                    OBJ_Action.calc.calRowSubTotal();
                                                }
                                            }

                                        }
                                    },
                                                    {header: "Sub Total", dataIndex: "inv_item_subTotal", width: 150 ,
                                                          editor: {
                                                        xtype: 'textfield',
                                                        id: 'rec_item_subtotal',
                                                        // disabled: true,
                                                        maxLength: 9,
                                                        allowBlank: false,
                                                        maskRe: /([0-9\s\.]+)$/,
                                                        regex: /[0-9]/,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            keyup: function () {
            //                                                    OBJ_Action.calc.calRowSubTotal();
                                                            },
                                                            blur: function () {                                                                    
            //                                                    OBJ_Action.calc.calRowSubTotal();
                                                            }
                                                        }

                                                    }
                                                    }
                                                ]
                                            }]
                                    },
                                    {
                                        region: 'south',
                                        height: 70,
                                        layout: 'fit',
                                        items: [{
                                                layout: 'border',
                                                margin: '0 5 5 5',
                                                border: false,
                                                defaults: {
                                                    border: false,
                                                    bodyBoder: false
                                                },
                                                items: [
                                                    {
                                                        region: 'west',
                                                        layout: 'fit',
                                                        items: [{
                                                                width: 350,
                                                                margin: '8 5 0 0',
                                                                border: false,
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 1,
                                                                    tableAttrs: {
                                                                        width: '100%'
                                                                    }
                                                                },
                                                                items: [
                                                                    {
                                                                        xtype: 'button',
                                                                        text: labels_json.purchaseinvoicepanel.button_auto_fill,
                                                                        style: 'align:right;margin-top:10px; display:none;',
                                                                        cls: 'big_btn',
                                                                        id: 'po_autofill_rec_btn',
                                                                        listeners: {
                                                                            click: function () {
                                                                                //fill the receive Grid 
                                                                                //OBJ_Action.autoFillReceive();
                                                                            }
                                                                        }
                                                                    }
                                                                ]
                                                            }]
                                                    },
                                                    {
                                                        region: 'center',
                                                        layout: 'fit',
                                                        height: 90,
                                                        items: [{
                                                                border: false,
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 1,
                                                                    tableAttrs: {
                                                                        width: '100%',
                                                                        style: 'float:right;margin:15px 5px 0 0px'
                                                                    },
                                                                    tdAttrs: {
                                                                        align: 'right',
                                                                        valign: 'bottom'

                                                                    }
                                                                },
                                                                items: [{
                                                                        xtype: 'button',
                                                                        text: 'Save Expense',
                                                                        style: 'margin-top:10px;',
                                                                        id: 'po_complete_rec_btn',
                                                                        cls: 'big_btn',
                                                                        listeners: {
                                                                            click: function () {
                                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                                    OBJ_Action.autoFillReceive();
                                                                                    OBJ_Action.completeOrder();
                                                                                    OBJ_Action.receiveItem();
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                ]
                                                            }]
                                                    },
                                                    {
                                                        region: 'east',
                                                        width: 250,
                                                        layout: 'fit',
                                                        items: [{
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 2,
                                                                    tableAttrs: {
                                                                        width: '100%'
                                                                    }
                                                                },
                                                                items: [{
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_ordered_quantity, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'po_total_ordered',
                                                                        name: 'po_total_ordered',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: labels_json.purchaseinvoicepanel.text_received_quantity, cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'total_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '100',
                                                                        id: 'po_total_received'
                                                                    }
                                                                ]
                                                            }]
                                                    }
                                                ]
                                            }]
                                    }
                                ]
                            }
                        ]
                    }
                ]
            })
            ,
            tbar: [
                {
                    xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_new,
                    iconCls: 'new',
                    id: 'tb_btn_po_new',
                    tooltip: labels_json.purchaseinvoicepanel.button_new_tooltip,
                    listeners: {
                        click: function () {
                            Ext.getCmp("tb_btn_po_save").setDisabled(false)   
                             Ext.getCmp("tb_btn_po_save_new").setDisabled(false) 
                            var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                            if(Ext.getCmp("vendors_combo").getValue() && startEditAt>0 ){
                            var status = parseInt(Ext.getCmp("po_order_status").getValue());
                            if(status<3 && Ext.getCmp("po_payment_paid").getValue() =='0'){
                                OBJ_Action.makeNew({'save_other': OBJ_Action.saveme});
                            } else {
                                OBJ_Action.clearChanges();
                            }
                        } else {
                            OBJ_Action.addRecord();
                        }

                        }
                    }
                }
                ,
                {
                    xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_print,
                    iconCls: 'print',
                    tooltip: labels_json.purchaseinvoicepanel.button_print_tooltip,
                    listeners: {
                        click: function () {
                            var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                            if(Ext.getCmp("vendors_combo").getValue() && startEditAt>0){
                                    if(user_right==1){
                                        OBJ_Action.printme();
                                    } else {
                                        if(purchase_invoice_return_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_invoice.actions.print)
                                    { 
                                        OBJ_Action.printme();
                                    } else if (purchase_invoice_return_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.purchase_return.actions.print) 
                                    {
                                        OBJ_Action.printme();
                                    } else {
                                        Ext.Msg.show({
                                                    title:'User Access Conformation',
                                                    msg:'You have no access to Print this invoice',
                                                    buttons:Ext.Msg.OK,
                                                    callback:function(btn) {
                                                        if('ok' === btn) {
                                                        }
                                                    }
                                                });
                                }
                                    }
                            } else {
                                return false;
                            }
                            
                        }
                    }
                }
                ,
                {
                    xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_save,
                    iconCls: 'save',
                    id: 'tb_btn_po_save',
                    tooltip: labels_json.purchaseinvoicepanel.button_save_tooltip,
                    listeners: {
                        click: function () {
                            var status = parseInt(Ext.getCmp("po_order_status").getValue());
                            if(Ext.getCmp("vendors_combo").getValue()){
                            if(status<3){
                            var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                            // console.log(startEditAt);
                            if(startEditAt>0){  
                                OBJ_Action.saveme();
                            } else { 
                                OBJ_Action.addRecord();
                            }
                        } else if(status==3 || status==4 || status==5){
                            LoadingMask.showMessage('Loading...');
                            Ext.Ajax.request({
                                url: action_urls.update_po_remarks,
                                method: 'POST',
                                params: {
                                    remarks: Ext.getCmp("po_remarks").getValue(),
                                    inv_id: Ext.getCmp("po_hidden_id").getValue()
                                },
                                success: function (response) {
                                    jObj = Ext.decode(response.responseText);
                                    console.log(jObj);
                                    if(jObj.success==1){
                                    LoadingMask.hideMessage();
                                    }
                                },
                                failure: function () {}
                            });
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                        }
                    }
                }
                ,
                {
                    xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_save_new,
                    iconCls: 'save',
                    id: 'tb_btn_po_save_new',
                    
                    tooltip: labels_json.purchaseinvoicepanel.button_saveandnew_tooltip,
                    listeners: {
                        click: function () {
                            var status = parseInt(Ext.getCmp("po_order_status").getValue());
                            if(Ext.getCmp("vendors_combo").getValue()){
                            if(status<3){
                            var startEditAt = Ext.getCmp("purchase_invoice_grid").store.getCount();
                            if(startEditAt>0){  
                                OBJ_Action.saveme({makenew: OBJ_Action.saveme});
                            } else { 
                                OBJ_Action.addRecord();
                            }
                        } else if(status==3 || status==4 || status==5){
                            LoadingMask.showMessage('Saving...');
                            Ext.Ajax.request({
                                url: action_urls.update_po_remarks,
                                method: 'POST',
                                params: {
                                    remarks: Ext.getCmp("po_remarks").getValue(),
                                    inv_id: Ext.getCmp("po_hidden_id").getValue()
                                },
                                success: function (response) {
                                    jObj = Ext.decode(response.responseText);
                                    if(jObj.success==1){
                                        LoadingMask.hideMessage();
                                        OBJ_Action.makeNew({ skip:'1' });
                                    }
                                },
                                failure: function () {}
                            });
                        } else {
                            return false;
                        }
                            } else {
                                return false;
                            }
                          }
                    }
                },
                {
                    xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_label_print,
                    id : 'print_label',
                    iconCls: 'print',
                    tooltip: labels_json.purchaseinvoicepanel.button_label_print_tooltip,
                    listeners: {
                        click: function () {
                            if(Ext.getCmp("po_hidden_id").getValue() > '0'){
                                purchase_invoice_barcode_lable.show();
                            }
                        }
                    }
                },
                {
                    xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_copy,
                    style: 'display:none',
                    iconCls: 'copy',
                    id: 'tb_btn_po_copy',
                    tooltip: labels_json.purchaseinvoicepanel.button_copy_tooltip,
                    menu: [{
                            text: 'Copy PO',
                            listeners: {
                                click: function () {
                                    OBJ_Action.copy('po_hidden_id', 'po_id');
                                }
                            }
                        },
                        {
                            text: 'Copy SO',
                            disabled: true
                        }]
                }, 
                {
                    xtype: 'button',
                    iconCls: labels_json.purchaseinvoicepanel.button_reopen,
                    style: 'display:none',
                    id: 'tb_btn_po_reopen',
                    tooltip: 'Re-open order will reverse all inventory moments and payment records.',
                    text: 'Re-Open Order',
                    listeners: {
                        click: function () {

                        }
                    }
                }
                , '-',
                {xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_delete,
                    iconCls: 'deactivate',
                     
                    id: 'delete_po_invoice',
                    tooltip: labels_json.purchaseinvoicepanel.button_delete_tooltip,
                    listeners: {
                        click: function () {
                            if (Ext.getCmp("po_hidden_id").getValue() != "0") {
                                performAction('Delete', action_urls.delete_po_invoice, false, function (data) {
                                    OBJ_Action.resetChanges();
                                    OBJ_Action.makeNew();
                                    OBJ_Action.previousOrderID = data.pre_order_id;
                                }, {id: Ext.getCmp("po_hidden_id").getValue()});
                            }
                        }
                    }
                }
                , '-',
                {xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_close,
                    iconCls: 'close',
                    
                    tooltip: labels_json.purchaseinvoicepanel.button_close_tooltip,
                    listeners: {
                        click: function () {
                           if(Ext.getCmp("purchase_invoice_grid").store.getCount() > 0 && Ext.getCmp("po_hidden_id").getValue() == "0"){
                
                            Ext.Msg.show({
                                     title:'Close confirmation'
                                    ,msg:'Are you sure to close the invoice without Saving?'
                                    ,buttons:Ext.Msg.YESNO
                                    ,callback:function(btn) {
                                        if('yes' === btn) {
                                            purchase_invoice_return_mode = 0;
                                            // homePage();
                                            window.location.reload();
                                        }
                                    }
                                });
                        } else {
                            purchase_invoice_return_mode = 0;
                             homePage();
                            //window.location.reload();
                        }
                       return false;
                        }
                    }
                },
                {xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_next,
                    id: 'next_po_order_btn',
                    iconCls: 'next-order-icon',
                     
                    cls: 'next-order',
                    tooltip: labels_json.purchaseinvoicepanel.button_next_tooltip,
                    listeners: {
                        click: function () {
                            if (OBJ_Action.nextOrderID) {
                                editItem.id = OBJ_Action.nextOrderID;
                                OBJ_Action.editme();
                            }
                        }
                    }
                },
                {xtype: 'button',
                    text: labels_json.purchaseinvoicepanel.button_previous,
                     
                    iconCls: 'previous-order-icon',
                    cls: 'previous-order',
                    id: 'pre_po_order_btn',
                    tooltip: labels_json.purchaseinvoicepanel.button_previous_tooltip,
                    listeners: {
                        click: function () {
                            if (OBJ_Action.previousOrderID) {
                                editItem.id = OBJ_Action.previousOrderID;
                                OBJ_Action.editme();
                            }
                        }
                    }
                }

            ]

        }
    ]
}
