({
    id: 'sale-invoice-panel',
    layout: 'border',
    closable: true,
    closeAction: 'hide',
    frame: true,
    title:"labels_json.stocktransferpanel.text_title",
    listeners: {
        beforeclose: function () {
            if(win.closeMe) {
                win.closeMe = false;
                return true;
            }
            if(Ext.getCmp("sale_invoice_grid").store.getCount() > 0 && Ext.getCmp("so_hidden_id").getValue() == "0"){
                
                Ext.Msg.show({
                         title:'Close confirmation'
                        ,msg:'Are you sure you want to close the invoice?'
                        ,buttons:Ext.Msg.YESNO
                        ,callback:function(btn) {
                            if('yes' === btn) {
                                sale_invoice_return_mode = 0;
                                // homePage();
                                window.location.reload();
                                 // location.reload(true);
                            }
                        }
                    });
            } else {
                sale_invoice_return_mode = 0;
                // homePage();
                window.location.reload();
            }
           return false; 
        },
        hide:function(){
          if(user_right=="3")  {
              window.location.href = urls.logout;
          }
        },
        afterrender: function (obj) {
            editModelSO = Ext.getCmp("sale_invoice_grid").plugins[0];
          

        },
        show: function () {
            Ext.getCmp("sale_invoice_grid").store.removeAll();

            Ext.getCmp("from_warehouse").focus();
     
           
            /*End Discount window*/
            OBJ_Action.addMewInvoiceRow = false;
            OBJ_Action.searchKeyPress = 0;
            OBJ_Action.searchChange = 0;
            OBJ_Action.shiftFocus = false;
            OBJ_Action.tabpressed = false;
            OBJ_Action.previousOrderID = last_id.transfer_last_invoice;
            OBJ_Action.myfunc = function (data) {
               
                Ext.getCmp("so_hidden_id").setValue(data.obj_id);
                Ext.getCmp("so_already_shipped").setValue(data.already_shipped);
                OBJ_Action.nextOrderID = data.next_order_id;
                OBJ_Action.previousOrderID = data.pre_order_id;
                Ext.getCmp("next_sale_order_btn").setDisabled((data.next_order_id == 0) ? true : false);
                Ext.getCmp("pre_sale_order_btn").setDisabled((data.pre_order_id == 0) ? true : false);
               
            }
            OBJ_Action.getDateMysqlFormatWithTime = function (objDate) {
                var currentdate = objDate;
                var cdate = "";
                if (objDate) {
                    var cdate = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + "-" + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
                }
                return cdate;
            }

            // Ext.getCmp("so_tab_panel").down('#so_pick_panel').setDisabled(true);
            // Ext.getCmp("so_tab_panel").down('#so_payment_panel').setDisabled(true);
            OBJ_Action.updateOnlineStatus = function (event) {
        if(event.type=='online'){
            alert('Your are Online');
        }

        if(event.type=='offline'){
            alert('Your are Offline');
        }
        
      }
            OBJ_Action.saveme = function (extra, byPassCreditLimit) {
                
                editModelSO.cancelEdit();
                // editModelPick.cancelEdit();
                
                var _data = Ext.getCmp('sale_invoice_grid').store.data;
                if (_data.items.length == 0) {
                    return false;
                }

                var jsonInvoiceData = Ext.pluck(_data.items, 'data');
                var isvalid = true;
                for (var i = 0; i < jsonInvoiceData.length; i++) {
                    if (!jsonInvoiceData[i].item_name || !jsonInvoiceData[i].item_id) {
                        isvalid = false;
                        break;
                    }
                }
                if (isvalid == false) {
                    Ext.Msg.show({
                        title: 'Error Occured',
                        msg: 'One of the item row is empty, please delete or fill item to continue.',
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.ERROR
                    });
                    return false;
                }
                
                jsonInvoiceData = Ext.encode(jsonInvoiceData);
                // var jsonPickData = Ext.encode(Ext.pluck(Ext.getCmp('pick_invoice_grid').store.data.items, 'data'));

                // var status_val = 2;
                
                // Ext.getCmp("so_order_status").setValue(status_val);
                // Ext.getCmp("so_status").setValue(OBJ_Action.invoiceStatus['_' + status_val]);
                // Ext.get("img_stamp").dom.className = "stamps " + OBJ_Action.invoiceStatusImage['_' + status_val];
                var extraParms = {
                    trans: jsonInvoiceData,
                    pick: jsonPickData,
                }
                if (extra && extra.print) {
                    extraParms["print"] = extra.print;
                }
                else if (extra && extra.makenew) {
                    extraParms["makenew"] = extra.makenew;
                }
                extraParms["so_date_time"] = Ext.Date.format(Ext.getCmp("so_date").getValue(), 'Y-m-d') + ' ' + Ext.Date.format(new Date(), 'H:i:s');
                Ext.getCmp("so_datetime_hidden").setValue(Ext.Date.format(Ext.getCmp("so_date").getValue(), 'd/m/Y') + ' ' + Ext.Date.format(new Date(), 'h:i A'));
                

                OBJ_Action.save(extraParms);
               


               
            }

             OBJ_Action.editme = function () {
                if (editItem.id > 0) {
                    LoadingMask.showMessage(labels_json.saleinvoicepanel.msg_loading);
                    Ext.Ajax.request({
                        url: action_urls.get_transfer_record,
                        params: {
                            so_id: editItem.id
                        },
                        method: 'GET',
                        success: function (response) {

                            editItem.loadMode = 1;
                            var jObj = Ext.decode(response.responseText);
                            Ext.getCmp("hidden_id").setValue('1');
                            Ext.getCmp("from_warehouse").setValue(jObj.from_warehouse);
                            Ext.getCmp("to_warehouse").setValue(jObj.to_warehouse);
                            Ext.getCmp("so_date").setValue(jObj.date);
                            Ext.getCmp("str_id").setValue(jObj.inv_no);
                          
                           // Ext.getCmp("so_discount_invoice").setValue(jObj.so_discount_invoice);

                            //Ext.getCmp("warehouse_so").setValue(jObj.so_location_id == "0" ? "1" : jObj.so_location_id);
                            
                            if (jObj.transfer_details) {
                                // if (editItem.type !== "") {
                                    var total_qty=0;
                                    for (var i = 0; i < jObj.transfer_details.length; i++) {
                                        total_qty +=  parseFloat(jObj.transfer_details[i].item_quantity);
                                    }

                                        // console.log(total_qty)
                                       Ext.getCmp("sub_total_total_so").setValue(total_qty);  
                                // }
                                Ext.getCmp("sale_invoice_grid").store.loadData(jObj.transfer_details);
                            }
                            // else {
                            //     Ext.getCmp("sale_invoice_grid").store.loadData([]);
                            // }
                            OBJ_Action.nextOrderID = jObj.next_order_id;
                            OBJ_Action.previousOrderID = jObj.pre_order_id;
                            Ext.getCmp("next_sale_order_btn").setDisabled((jObj.next_order_id == 0) ? true : false);
                            Ext.getCmp("pre_sale_order_btn").setDisabled((jObj.pre_order_id == 0) ? true : false);
                            Ext.getCmp("delete_st_invoice").setDisabled(false);
                            editItem.id = '0';
                            editItem.loadMode = 0;

                            LoadingMask.hideMessage();
                            
                        },
                        failure: function () {
                            LoadingMask.hideMessage();
                        }
                    });
                }
            }
          
            
            OBJ_Action.editRecordRow = function(e,obj){
                
                if (parseInt(Ext.getCmp("so_order_status").getValue()) === 4) {
                    editModelSO.cancelEdit();
                    return false;
                }
                else {

         
                    if (!OBJ_Action.addMewInvoiceRow) {                                                                                                                                                
                        Ext.getCmp("item_quantity_so").setDisabled(false);
                        Ext.getCmp("item_price_so").setDisabled(false);
                        // Ext.getCmp("item_discount_so").setDisabled(false);
                        // Ext.getCmp("item_net_so").setDisabled(false);
                        // Ext.getCmp("item_subtotal_so").setDisabled(false);
                        Ext.getCmp("item_name_so").setEditable(false); 
                        Ext.getCmp("sale_item_uom").setDisabled(false);
                        // Ext.getCmp("warehouse_so").setDisabled(false);                                                
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
            OBJ_Action.clearOtherChanges = function () {
          
                Ext.getCmp("sale_invoice_grid").store.removeAll();
                OBJ_Action.previousOrderID = last_id.transfer_last_invoice;
                OBJ_Action.nextOrderID = 0;
                Ext.getCmp("pre_sale_order_btn").setDisabled(false);
                Ext.getCmp("next_sale_order_btn").setDisabled(true);
                
                
            }

            
            OBJ_Action.changeItemName = function (record) {
                Ext.getCmp("item_quantity_so").setDisabled(false);                                                                        
                Ext.getCmp("item_price_so").setDisabled(false);
                Ext.getCmp("item_name_so").setEditable(false);
                // Ext.getCmp("warehouse_so").setDisabled(false);
                Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));                                                                                                                                                   
                // var adj = OBJ_Action.getAdjustedPrice(record);
                var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                sel.set("item_id", record.get("id"));
                OBJ_Action.recordChange();
                // OBJ_Action.calc.calRowSubTotal();                                                                            
                Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);
            }
            OBJ_Action.calc = {
               
              
                 calTotalSubTotal: function () {
                    var _total_quantity = 0;
                    var _data = Ext.getCmp('sale_invoice_grid').store.data;
                    _data = Ext.pluck(_data.items, 'data');
                    for (var i = 0; i < _data.length; i++) {
                        _total_quantity = _total_quantity + parseFloat(_data[i].item_quantity);
                    }
                    Ext.getCmp("sub_total_total_so").setValue(_total_quantity);
                }
                
                ,
                removeRecord: function (grid_id) {
                    Ext.getCmp(grid_id).store.remove(Ext.getCmp(grid_id).getSelectionModel().getSelection()[0]);
                    OBJ_Action.calc.calTotalSubTotal();
                    OBJ_Action.recordChange();
                }
            }
            OBJ_Action.editme();
               
            OBJ_Action.addRecord = function () {
                if(Ext.getCmp("from_warehouse").getValue() && Ext.getCmp("to_warehouse").getValue()){
                var current_tab = Ext.getCmp("so_tab_panel").items.indexOf(Ext.getCmp("so_tab_panel").getActiveTab());
                // console.log(current_tab);
                if (current_tab == 0) {
                    editModelSO.cancelEdit();       
                    Ext.getCmp("item_quantity_so").setDisabled(true);
                    Ext.getCmp("item_price_so").setDisabled(true);
                    // Ext.getCmp("item_discount_so").setDisabled(true);
                    // Ext.getCmp("item_net_so").setDisabled(true);
                    // Ext.getCmp("item_subtotal_so").setDisabled(true);
                    Ext.getCmp("item_name_so").setEditable(true);
                    // Ext.getCmp("warehouse_so").setDisabled(true);
                    editModelSO.cancelEdit();
                    var r = Ext.create('modelSaleInvoice', {
                        item_name: '----------------',
                        item_quantity:'1',
                        unit_id:"1",
                        unit_name:"Each",
                        unit_price: '0.00',
                        warehouse_name:''
                    });
                    OBJ_Action.addMewInvoiceRow = true;
                    var startEditAt = Ext.getCmp("sale_invoice_grid").store.getCount();
                    // console.log(startEditAt)
                    Ext.getCmp("sale_invoice_grid").store.insert(startEditAt, r);
                    
                    editModelSO.startEdit(startEditAt, 0);
                    
                    Ext.getCmp("item_name_so").focus(true, 10, function () {
                        Ext.getCmp("item_name_so").setValue("");
                        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                        console.log(sel);
                        sel.set("item_name", '');                        
                        Ext.getCmp("item_name_so").allowBlank=false;
                      //   item_store.removeAll();
                      //   item_store.clearFilter();
                      //   item_store.load({query:''});
                      //   OBJ_Action.shiftFocus = false;
                      //   OBJ_Action.searchKeyPress = 0;
                      //   OBJ_Action.searchChange = 0;    
                      //   if(Ext.getBody().select(".x-boundlist").elements.length){    
                            
                      //   Ext.getBody().select(".x-boundlist").elements[0].style.display="none";
                      // }
                    });
                    
                   
                   
                }
              
            }
            else{
                   Ext.defer(function () {
                        Ext.getCmp("from_warehouse").focus();
                        // Ext.getCmp("from_warehouse").setValue('');

                    }, 50);
            }
            }


            OBJ_Action.mouseOverRow = null;
         
            OBJ_Action.setInvoiceMode = function(conv){
          
             if(sale_invoice_mode === 0) {
                Ext.getCmp('sale-invoice-panel-grid').columns[0].setText("Order #");
                Ext.getCmp("sale-invoice-panel").setTitle("STOCK TRANSFER");
                Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText("Stock Transfer");
                Ext.getCmp("order_no_search").setFieldLabel("Order");
                Ext.getCmp("str_id").setFieldLabel("Order #");
                Ext.get("sub_total_bar").dom.style.visibility="visible";
                    
                
            }
          
            Ext.getCmp("so_type").setValue(sale_invoice_mode);
           }
           
           OBJ_Action.setInvoiceMode();

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
                expand: function () {
                    // var s = Ext.getCmp("sale-invoice-panel-grid").store;
                    // var params = {salereturn: sale_invoice_mode};
                    // if(user_right==3){
                    //     params["search_customer"] = customer_id;
                    //     params["search"] = 1;
                    //    params["search_status"] = 0;
                    // }
                    // s.load({params: params });
                    // Ext.defer(function(){Ext.getCmp("order_no_search").focus(true)},200); 
                    //  var map_register = new Ext.util.KeyMap("sale_left_panel", [
                    // {
                    //     key: [10,13],
                    //     fn: function(){ Ext.getCmp("so_search_btn").fireHandler();}
                    //     }
                    // ]);
                },
                collapse: function(){
                    Ext.defer(function(){Ext.getCmp("from_warehouse").focus(true)},100); 
                }
            },
            items: [{
                    region: 'north',
                    layout: 'anchor',
                    height: 115,
                    defaults: {
                        anchor: '100%',
                        margin: '5'
                    },
                    items: [{
                            xtype: 'textfield',
                            fieldLabel: "Order No",
                            id: 'order_no_search'
                        },
                        {
                            xtype: 'combo',
                            fieldLabel: "From Warehouse",
                            displayField: 'warehouse_name',
                            valueField: 'id',
                            id: 'order_warehouse_search',
                            queryMode: 'local',
                            value: '-1',
                            typeAhead: true,
                            store: warehouse_store_all

                        }
                        , {
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
                                            text: "Show All",
                                            style: 'float:right',
                                            width: 80,
                                            listeners: {
                                                click: function () {
                                                     var params = {inv_no: 0};
                                                        params["search_warehouse"] = -1;
                                                        params["search"] =0;
                                                    Ext.getCmp("sale-invoice-panel-grid").store.load({params: params});
                                                }
                                            }
                                        }, {
                                            xtype: 'button',
                                            text: "Search",
                                            id: 'so_search_btn',
                                            style: 'float:right;margin-right:10px',
                                            width: 80,
                                            listeners: {
                                                click: function () {
                                                    Ext.getCmp("sale-invoice-panel-grid").store.load({
                                                        params: {
                                                            search: '1',
                                                            inv_no: Ext.getCmp("order_no_search").getValue(),
                                                            // search_status: Ext.getCmp("order_status_search").getValue(),
                                                            search_warehouse: Ext.getCmp("order_warehouse_search").getValue()
                                                        }
                                                    });
                                                }
                                            }
                                        }]
                                }]

                        }
                    ]
                }, {
                    border: false,
                    bodyBorder: false,
                    region: 'center',
                    layout: 'fit',
                    items: [{
                            xtype: "gridpanel",
                            id: "sale-invoice-panel-grid",
                            store: {
                                proxy: {
                                    type: "ajax",
                                    url: action_urls.get_stockTransfer,
                                    reader: {
                                        type: "json",
                                        root: 'orders',
                                        idProperty: 'str_id'
                                    }
                                },
                                model: Ext.define("orderListSearchModel", {
                                    extend: "Ext.data.Model",
                                    fields: [
                                        {
                                            name: "inv_no",
                                            type: 'string',
                                            convert: function (v, r) {
                                                return  sale_invoice_mode=="2"?"EST-" + v: ''+ v;
                                            }
                                        },
                                        "so_date",
                                        "str_id",
                                        "inv_no",
                                        "warehouse_name",
                                        "warehouse_id"

                                    ]
                                }) && "orderListSearchModel"

                            },
                            listeners: {
                                afterRender: function () {
                                    //this.superclass.afterRender.call(this);
                                    this.nav = new Ext.KeyNav(this.getEl(), {
                                        del: function (e) {

                                        }
                                    });
                                },
                                itemdblclick: function (v, r, item, index, e, args) {
                                            editItem.id = r.get('inv_no');
                                            // alert(r.get('inv_no'))
                                            editItem.type = "";
                                            OBJ_Action.editme(); 
                                    
                                }

                            },
                            columnLines: true,
                            columns: [
                                {
                                    header: "Order #",
                                    dataIndex: "inv_no",
                                    width: 40
                                },

                                {
                                    header: "Warehouse",
                                    dataIndex: "warehouse_name",
                                    width: 160
                                },
                                {
                                    header: "Date",
                                    dataIndex: "so_date",
                                    width: 80
                                }
                                

                            ]
                        }]
                }]

        }, {
            region: 'center',
            layout: 'fit',
            border: false,
            bodyBorder: false,
            items: new Ext.FormPanel({
                layout: 'border',
                id: 'sale-invoice-panel-form',
                bodyBorder: false,
                defaults: {
                    border: false
                }
                ,
                items: [{
                        region: 'north',
                        height: 120,
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
                              anchor: '100%'
                                  },
                                
                                items: [
                                    {
                                   xtype:'combo',
                                   fieldLabel:'From',
                                   id:'from_warehouse',
                                   allowBlank: false,
                                displayField: 'warehouse_name',
                                  queryMode: 'local',
                                  typeAhead: true,
                                  valueField: 'id',
                                  emptyText: ' From Warehouse',
                                   queryMode:'local',
                                   store:warehouse_store_all,
                                     listeners: {
                                            change: function (f, obj) {
                                                var hidden_id=Ext.getCmp("hidden_id").getValue();
                                              Ext.Ajax.request({
                                                url: action_urls.get_item_warehouse,
                                                method: 'GET',
                                                params: {
                                                    ware_id: this.value
                                                },
                                                success: function (response) {
                                                var data = Ext.JSON.decode(response.responseText);
                                                item_store.removeAll();
                                                Ext.getCmp("item_name_so").clearValue();
                                                Ext.getCmp("item_name_so").store.loadData(data.items);
                                                },
                                                failure: function () {
                                                }
                                            });
                                                    if(hidden_id==0){
                                                          Ext.Ajax.request({
                                                url: action_urls.get_warehouses_2,
                                                method: 'GET',
                                                params: {
                                                    ware_id: this.value
                                                },
                                                success: function (response) {
                                                var data = Ext.JSON.decode(response.responseText);
                                                item_store.removeAll();
                                                Ext.getCmp("to_warehouse").clearValue();
                                                Ext.getCmp("to_warehouse").store.loadData(data.warehouses2);
                                                },
                                                failure: function () {
                                                }
                                            });   
                                                    }



                                                    

                                                  

                                            }
                                        }
                                   },
                                    {
                                  xtype:'combo',
                                  fieldLabel:'To',
                                  id:'to_warehouse',
                                  displayField: 'warehouse_name',
                                  queryMode: 'local',
                                   typeAhead: true,
                                valueField: 'id',
                                  emptyText: ' To Warehouse',
                                 queryMode:'local',
                                 store: warehouse_store_all
                                },
                                
                               
                                    {
                                        xtype: 'hidden',
                                        name: 'so_type',
                                        id: 'so_type',
                                        value: '',
                                        listeners: {
                                            change: function (obj) {
                                                obj.setValue(sale_invoice_mode);
                                            }
                                        }
                                    }, {
                                        xtype: 'hidden',
                                        name: 'so_already_shipped',
                                        id: 'so_already_shipped',
                                        value: '0'
                                    }, {
                                        xtype: 'hidden',
                                        name: 'so_order_status',
                                        id: 'so_order_status',
                                        value: '1'
                                    }, {
                                        xtype: 'hidden',
                                        name: 'so_cust_group',
                                        id: 'so_cust_group',
                                        value: '1'
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
                                                text: "New",
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

                                                        // var current_tab = Ext.getCmp("so_tab_panel").items.indexOf(Ext.getCmp("so_tab_panel").getActiveTab());
                                                        // if (current_tab == 0) {
                                                            OBJ_Action.calc.removeRecord('sale_invoice_grid');
                                                        // }
                                                        // else {
                                                        //     OBJ_Action.calc.removeRecord('pick_invoice_grid');
                                                        // }
                                                    }
                                                }
                                            }]


                                    }
                                ]
                            }, {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                width: 400,
                                items: [
                                    {
                                        xtype: 'textareafield',
                                        id: 'stock_remarks',
                                        displayField: '',
                                        emptyText:'Comments.......',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        width: 100,
                                        listeners: {
                                           
                                        }
                                    }
                                    

                                ]
                            },
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                style: 'position:relative',
                                id: 'date-column',
                                margin: '5 10 0 0',
                                height: 160,
                                layout: {
                                    type: 'table',
                                    columns: 1,
                                    itemCls: 'right-panel',
                                    tableAttrs: {
                                        width: '230px',
                                        cls: 'right-panel'
                                    }
                                },
                                items: [{
                                        xtype: 'fieldset',
                                        collapsible: false,
                                        padding: '5 5 0 5',
                                        defaults: {
                                            labelWidth: 60
                                        },
                                        items: [{
                                                xtype: 'textfield',
                                                fieldLabel: "Order #",
                                                readOnly: true,
                                                cls: 'readonly',
                                                id: 'str_id',
                                                name: 'str_id',
                                                enableKeyEvents: true,
                                                listeners: {
                                                    change: function () {
                                                        OBJ_Action.recordChange();

                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: "Date",
                                                name: 'so_date',
                                                id: 'so_date',
                                                value: new Date(),
                                                maxValue: new Date(),
                                                format: 'd-m-Y',
                                                listeners: {
                                                    change: function () {
                                                        OBJ_Action.recordChange();

                                                    }
                                                }
                                            }]
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'so_salesrep',
                                        id: 'so_sales_rep',
                                        value: '1'
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'so_datetime_hidden',
                                        id: 'so_datetime_hidden',
                                        value: ''
                                    },
                                    {
                                        xtype: 'hidden',
                                        name: 'hidden_id',
                                        id: 'hidden_id',
                                        value: '0'
                                    },
                                    
                                ]
                            }
                        ]
                    },


                     {
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
                                activate: function (tab, eOpts) {
                                    if (tab.title === "Sale") {
                                        Ext.get("so_action_btn_panel").setStyle("display", "block");
                                    }
                                    else if (tab.title === "Pick") {
                                        Ext.get("so_action_btn_panel").setStyle("display", "block");
                                        console.log('test')
                                        var _data = Ext.getCmp('sale_invoice_grid').store.data;
                                        so_receive_item_store.loadData(Ext.pluck(_data.items, 'data'));
                                    }
                                    else if (tab.title === "Invoice") {
                                        Ext.get("so_action_btn_panel").setStyle("display", "none");
                                        OBJ_Action.payment();
                                    }
                                }
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
                                                id: "sale_invoice_grid",
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
                                                                    var _data = Ext.getCmp('sale_invoice_grid').store.data;
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
                                                                // var unit_price = parseFloat(Ext.getCmp("item_net_so").getValue());                                      
                                                                var sel = e.grid.getSelectionModel().getSelection()[0];
                                                                  
                                                                var ware_name=Ext.getCmp("from_warehouse").getValue();  
                                                                var other_ware='';  
                                                                var record = item_store_ware.getById(sel.get("item_id")); 
                                                                var ware_qty=record.get("qty"); 
                                                                var convert=sel.get("conv_from");
                                                                // alert(ware_qty);

                                                                // var data=record.get('item_warehouses');
                                                                        // for(var i=0;i<data.length;i++){

                                                                        //     other_ware +="<li>"+data[i].warehouse_name+": "+data[i].qty+" </li>";
                                                                        //     if(sel.get("ware_id")==data[i].ware_id){
                                                                        //           ware_qty=data[i].qty;  
                                                                        //           ware_name=data[i].warehouse_name;  
                                                                        //     /         }
                                                                         //   }   //                                                           
                                                                try{
                                                                    if(record.get("type")!=="3"){
                                                                    
                                                                    
                                                                    if ( qty > parseFloat(ware_qty/sel.get("conv_from"))) {
                                                                        
                                                                        
                                                                        Ext.Msg.show({
                                                                            title: 'Stock Warning',
                                                                            msg: 'You have ' + parseFloat(ware_qty/sel.get("conv_from")).toFixed(2) + ' quantity Of '+sel.get("unit_name")+' In  Warehouse for "' + Ext.getCmp("item_name_so").getValue() + '".'+
                                                                             'Do you want to continue with entered quantity?<br>',
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
                                                                if(user_right==1 || user_right==3){
                                                                        OBJ_Action.editRecordRow(e,obj); 
                                                                    } else {
                                                                    if(sale_invoice_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.edit){ 
                                                                        // console.log('Hello')
                                                                        OBJ_Action.editRecordRow(e,obj);
                                                                    } else if(sale_invoice_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_return.actions.edit){ 
                                                                        OBJ_Action.editRecordRow(e,obj);
                                                                    } else if(sale_invoice_mode == "2" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_estimate.actions.edit){ 
                                                                        OBJ_Action.editRecordRow(e,obj);
                                                                    } else {
                                                                        Ext.Msg.show({
                                                                            title:'User Access Conformation',
                                                                            msg:'You have no access to Edit this Invoice',
                                                                            buttons:Ext.Msg.OK,
                                                                            callback:function(btn) {
                                                                                if('ok' === btn) {
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                                

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
                                                            "unit_price",
                                                            "warehouse_name"

                                                        ]
                                                    }) && "modelSaleInvoice",
                                                    data: []
                                                },
                                                listeners: {
                                                    afterRender: function (obj) {
                                                        //this.superclass.afterRender.call(this);
                                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                                            del: function (e) {
                                                                OBJ_Action.calc.removeRecord('sale_invoice_grid');
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
                                                        // console.log(OBJ_Action.addRecord())
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
                                                            store: item_store_ware,
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
                                                                        // Ext.getCmp("item_discount_so").setDisabled(false);
                                                                        // Ext.getCmp("item_net_so").setDisabled(false);
                                                                        // Ext.getCmp("item_subtotal_so").setDisabled(false);
                                                                        Ext.getCmp("sale_item_uom").setDisabled(false);
                                                                        // Ext.getCmp("warehouse_so").setDisabled(false);
                                                                            var data =  record.get("item_units");
                                                                            uom_store_temp.removeAll();
                                                                            for(var i=0;i<data.length;i++){
                                                                                uom_store_temp.add(data[i]);
                                                                                if(record.get("sale_item_uom")==data[i].unit_id){
                                                                                    Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));
                                                                                    // Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));
                                                                                    Ext.getCmp("sale_item_uom").setValue(data[i].unit_name);
                                                                                    var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                                                    sel.set("unit_id", data[i].unit_id);
                                                                                    sel.set("unit_name", data[i].unit_name);
                                                                                    sel.set("conv_from", data[i].conv_from);
                                                                                    sel.set("normal_price", Ext.util.Format.number(data[i].nprice, "0.00"));
                                                                                }
                                                                            }
                                                                        
                                                                        //var adj = OBJ_Action.getAdjustedPrice(record);
                                                                                        // Ext.getCmp("item_discount_so").setValue(adj.discount + "%");
                                                                                        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                                                        sel.set("ware_id", "1");
                                                                                        sel.set("item_id", record.get("id"));
                                                                                        sel.set("item_weight", parseFloat(record.get("weight")));
                                                                                        
                                                                                        sel.set("barcode",record.get("barcode"));
                                                                                        sel.set("qty_on_hand",record.get("qty"));
                                                                                       // sel.set("discount", parseFloat(adj.discount));
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
                                                                        // Ext.getCmp("item_discount_so").setDisabled(true);
                                                                        // Ext.getCmp("item_net_so").setDisabled(true);
                                                                        // Ext.getCmp("item_subtotal_so").setDisabled(true);
                                                                        Ext.getCmp("sale_item_uom").setDisabled(true);
                                                                        // Ext.getCmp("warehouse_so").setDisabled(true);
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
                                                                       item_store_ware.load({
                                                                        params: {ware_id: 1}
                                                                    }); 
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
                                                        header: "UOM",
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
                                                                        // Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));

                                                                        // var p = parseFloat(Ext.getCmp("item_net_so").getValue());
                                                                        var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
                                                                        // var d = parseFloat(Ext.getCmp("item_discount_so").getValue());
                                                                        // var dPrice = p - (p * d / 100);
                                                                        // var total = q * dPrice;
                                                                        // Ext.getCmp("item_subtotal_so").setValue(Ext.util.Format.number(Ext.getCmp("item_quantity_so").getValue()*record.get("sprice"), "0.00"));
                                                                
                                                                        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        
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
                                    },
                                    {
                                        region: 'south',
                                        height: 110,
                                        id: 'bottom_frame',
                                        layout: 'fit',
                                        items: [{
                                                layout: 'border',
                                                margin: '0 5 5 5',
                                                border: false,
                                                defaults: {
                                                    border: false,
                                                    bodyBoder: false
                                                },
                                                items: [{
                                                        region: 'north',
                                                        height: 35,
                                                        id:'sub_total_bar',
                                                        bodyCls: 'subtotal_bar',
                                                        layout: {
                                                            type: 'table',
                                                            columns: 2,
                                                            tableAttrs: {
                                                                width: '250px',
                                                                cls: 'floatright'
                                                            }
                                                        },
                                                        items: [{
                                                                xtype: 'box',
                                                                autoEl: {
                                                                    tag: 'div',
                                                                    html: "Total Quantity",
                                                                    cls: 'sub_total_text',
                                                                    style : 'padding-bottom: 3px'
                                                                }
                                                            },
                                                            {
                                                                xtype: 'textfield',
                                                                cls: 'subtotal_digit_field floatright',
                                                                readOnly: true,
                                                                width: 115,
                                                                value: '0.00',
                                                                id: 'sub_total_total_so'
                                                            }
                                                        ]
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
                    text: "New",
                    iconCls: 'new',
                    tooltip: 'Create a new sales invoice.',
                    listeners: {
                        click: function () {
                           Ext.getCmp('from_warehouse').setValue('');
                          Ext.getCmp('to_warehouse').setValue('');
                            // Ext.getCmp("so_paid").setReadOnly(false);
                            
                            OBJ_Action.makeNew({
                                'save_other': OBJ_Action.saveme
                            }); 
                                                
                            // Ext.getCmp("so_remarks").setValue(' ');
                        }
                    }
                }
                ,
                {
                    xtype: 'button',
                    text: "Save",
                    iconCls: 'save',
                    id: 'tb_btn_save',
                    tooltip: 'Save the current sales invoice.',
                    listeners: {
                        click: function (grid) {
                             /////////Start Code For Sending Messages ////////////
                            // alert()
                            var myStore = Ext.getCmp('sale_invoice_grid').store;
                             // Ext.getCmp("sale_invoice_grid").store.removeAll();
                              var _data = Ext.getCmp('sale_invoice_grid').store.data;
                          if (_data.items.length == 0) {
                              return false;
                          }

                          var jsonInvoiceData = Ext.pluck(_data.items, 'data');
                          var isvalid = true;
                          for (var i = 0; i < jsonInvoiceData.length; i++) {
                              if (!jsonInvoiceData[i].item_name || !jsonInvoiceData[i].item_id) {
                                  isvalid = false;
                                  break;
                              }
                          }
                             if (isvalid == false) {
                    Ext.Msg.show({
                        title: 'Error Occured',
                        msg: 'One of the item row is empty, please delete or fill item to continue.',
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.ERROR
                    });
                    return false;
                }
                            jsonInvoiceData = Ext.encode(jsonInvoiceData);
                              var from_warehouse=Ext.getCmp('from_warehouse').getValue();
                                var to_warehouse=Ext.getCmp('to_warehouse').getValue();
                                var so_date=Ext.Date.format(Ext.getCmp("so_date").getValue(), 'Y-m-d');
                      Ext.Ajax.request({
                        url: action_urls.save_transfer,
                        method: 'POST',
                        params: {
                            from_warehouse: from_warehouse,
                            to_warehouse: to_warehouse,
                            so_date: so_date,
                            trans:jsonInvoiceData
                        },
                        success: function (response) {
                          var data = Ext.JSON.decode(response.responseText);
                          // Ext.getCmp('from_warehouse').setValue('');
                          // Ext.getCmp('to_warehouse').setValue('');
                        // var data = Ext.JSON.decode(response.responseText);
                        // customer_store_active.removeAll();
                           Ext.Msg.show({
                        title: 'Success',
                        msg: 'Quantity Transfer.',
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.INFO,
                         fn: function (btn, text) {
                        if (btn == 'ok') {
                            myStore.load();
                           }
                         }
                    });
                           
                        },
                        failure: function () {
                        }

                    });  
                              
                              // alert(to_warehouse);
                            // OBJ_Action.saveme();
                          
                        }
                    }
                },
                {
                    xtype: 'button',
                    text: 'Save & New',
                    iconCls: 'save',
                    id: 'tb_btn_save_new',
                    tooltip: 'Save the current sales invoice and ready for new',
                    listeners: {
                        click: function () {
                             /////////Start Code For Sending Messages ////////////
                            
                           var so_balance = Ext.util.Format.number(Ext.getCmp("so_total").getValue());
                            var customer_pre_balance = Ext.util.Format.number(Ext.getCmp("prev_total_balance").getValue());
                            // var pay = Ext.util.Format.number(parseFloat(Ext.getCmp("so_paid").getValue()), "0.00");
                            var _grand_total = +so_balance + +customer_pre_balance;
                            // var customer_mobile = Ext.getCmp("customer_mobile").getValue();
                             var so_discount = Ext.getCmp("so_discount").getValue();
                             // var so_discount_invoice = Ext.getCmp("so_discount_invoice_2").getValue();
                             var so_discount_invoice = Ext.getCmp("so_discount_invoice").getValue();
                            var invoice_status = Ext.getCmp("so_status").getValue();
                            
                            var remaining = Ext.util.Format.number(parseFloat(_grand_total - pay), "0.00");
                            var message = "Sale Inv Amount = " + so_balance + " Rs" + "\nPrev Amount = " + customer_pre_balance + " Rs" + "\nTotal Amount = " + _grand_total + " Rs" + "\nYou Paid = " + pay + " Rs" + " \nRem Bal = " + remaining + " Rs" + "\nThank you \n" + store_name;
                            
                            var user_id = Ext.getCmp("customers_combo").getValue();
                     
                            /////////End Code For Sending Messages ////////////
                            OBJ_Action.saveme({
                                makenew: OBJ_Action.saveme
                            });
                        }
                    }
                },
                
                {
                    xtype: 'button',
                    disabled: true,
                    style: 'display:none',
                    iconCls: 're-open',
                    id: 'tb_btn_reopen',
                    tooltip: 'Re-open order will reverse all inventory moments and payment records.',
                    text: 'Re-Open Order',
                    listeners: {
                        click: function () {

                        }
                    }
                },
                {
                xtype: 'button',
                tabIndex: -1,
                text: 'Delete',
                iconCls: 'deactivate',
                id: 'delete_st_invoice',
                disabled: true,
                tooltip: 'Delete Current Invoice.',
                listeners: {
                    click: function () {
                        if (Ext.getCmp("hidden_id").getValue() != "0") {
                            performAction('Delete', action_urls.delete_st_invoice, false, function (data) {
                                // OBJ_Action.resetChanges();
                                // OBJ_Action.makeNew();
                                 OBJ_Action.clearChanges();      
                                OBJ_Action.previousOrderID = data.pre_order_id
                            }, {
                                id: Ext.getCmp("hidden_id").getValue()
                            });
                        }
                    }
                }
            }
                , '-',
                {
                    xtype: 'button',
                    text: "Close",
                    iconCls: 'close',
                    tooltip: 'Close this sales order and switch back to home page.',
                    listeners: {
                        click: function () {
                            if(Ext.getCmp("sale_invoice_grid").store.getCount() > 0 && Ext.getCmp("so_hidden_id").getValue() == "0"){
                
                                Ext.Msg.show({
                                         title:'Close confirmation'
                                        ,msg:'Are you sure you want to close the invoice?'
                                        ,buttons:Ext.Msg.YESNO
                                        ,callback:function(btn) {
                                            if('yes' === btn) {
                                                if(user_right=="3")  {
                                                    window.location.href = urls.logout;
                                                }
                                                else{
                                                    sale_invoice_return_mode = 0;
                                                    // homePage();
                                                    window.location.reload();
                                                      // window.location.href = '';
                                                    // location.reload();
                                                }
                                            }
                                        }
                                    });
                            } else {
                                if(user_right=="3")  {
                                    window.location.href = urls.logout;
                                }
                                else{
                                    sale_invoice_return_mode = 0;
                                    // homePage();
                                    window.location.reload();
                                }
                            }
                           return false;
                        }
                    }
                },
                  {
                    xtype: 'button',
                    tabIndex: -1,
                    text: labels_json.saleinvoicepanel.button_next,
                    id: 'next_sale_order_btn',
                    iconCls: 'next-order-icon',
                    cls: 'next-order',
                    disabled: true,
                    tooltip: "Go To Next Stock Transfer Invoice",
                    listeners: {
                        click: function () {
                            if (OBJ_Action.nextOrderID) {
                                editItem.id = OBJ_Action.nextOrderID;
                                editItem.type = "";
                                OBJ_Action.editme();
                                
                            }
                        }
                    }
                },
                {
                    xtype: 'button',
                    tabIndex: -1,
                    text: labels_json.saleinvoicepanel.button_previous,
                    iconCls: 'previous-order-icon',
                    cls: 'previous-order',
                    id: 'pre_sale_order_btn',
                    tooltip: "Go To Previous Stock Transfer Invoice",
                    listeners: {
                        click: function () {
                            if (OBJ_Action.previousOrderID) {
                                editItem.id = OBJ_Action.previousOrderID;
                                //alert(editItem.id)
                                editItem.type = "";
                                 OBJ_Action.editme();
                            }
                        }
                    }
                }

            ]

        }
    ]
}
)
