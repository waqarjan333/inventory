({
    id: 'stock-adjust-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.stockadjustpanel.text_heading,
    listeners:{
        beforeclose:function(){
           homePage();
           
        }
        ,
        afterrender:function (){
           editModelAdjustStock = Ext.getCmp("stockadjust-panel-grid").plugins[0];
           
              // console.log(editModelAdjustStock.grid.store.data.items.data);
            var grid = Ext.getCmp("stockadjust-panel-grid");
            grid.columns[8].hide();
            grid.columns[9].hide();                                   
        },
        beforerender:function(){
            
             if(enableWarehouse==1)
             {
               Ext.getCmp("adj_warehouse").setVisible(true);
             }
             else{
               Ext.getCmp("adj_warehouse").setVisible(false);
             }
            // store_adjust.load(); 
           
            reports_obj = {
               getDateMysqlFormatWithTime: function (objDate){                    
                        var currentdate =  objDate;
                        var curtime = new Date();
                        var cdate = "";
                        if(objDate){
                            var cdate = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+"-"+currentdate.getDate()+' '+curtime.getHours()+':'+curtime.getMinutes()+':'+curtime.getSeconds();
                        }
                        return cdate;
                    }
                    
           }
        },
        show:function(){
            OBJ_Adjust = {};
         
            OBJ_Adjust.next = function(){
                var batch_id = parseInt(Ext.getCmp("a_batch_next").getValue());
                if(batch_id>0){
                     OBJ_Adjust.loadBatch(batch_id)
                }
            }
            OBJ_Adjust.previous = function(){
                var batch_id = parseInt(Ext.getCmp("a_batch_pre").getValue());
                if(batch_id>0){
                    OBJ_Adjust.loadBatch(batch_id)
                }
            }
            
            OBJ_Adjust.loadBatch = function(batch_id){
                LoadingMask.showMessage('Loading...'); 
                Ext.Ajax.request({
                url: action_urls.get_stockadjust_batch,
                method : 'GET',
                params:{batch_id:batch_id},
                success: function (response) {                                      
                  var items = Ext.decode(response.responseText);
                  LoadingMask.hideMessage();
                  Ext.getCmp("a_batch_pre").setValue(items.prev);
                  Ext.getCmp("a_batch_next").setValue(items.next);
                  if(items.batch[0]){
                    Ext.getCmp("adj_date").setValue(items.batch[0].updated_date);
                    Ext.getCmp("adj_account").setValue(items.batch[0].acc_id)
                    Ext.getCmp("adj_memo").setValue(items.batch[0].memo)
                  }                  
                  Ext.getCmp("next_adjust_btn").setDisabled((items.next==0)?true:false);
                  Ext.getCmp("pre_adjust_btn").setDisabled(true);
                  
                  var grid = Ext.getCmp("stockadjust-panel-grid");
                  
                  grid.columns[5].hide();
                  grid.columns[4].hide();
                  
                  
                  var record = null;
                  var gridItems = Ext.pluck(grid.store.data.items,'data');
                  // for(var i=0;i<gridItems.length;i++){
                  //     record = grid.store.getById(gridItems[i].id);
                  //     // record.set("qtyDiff","");
                  //     console.log(record);
                  // }
                  // record = null;
                  // for(var i=0;i<items.batch.length;i++){
                  //     record = grid.store.getById(items.batch[i].item_id);
                  //     record.set("qtyDiff",items.batch[i].qty);
                  //     record.set("adjust_id",items.batch[i].adjust_id);
                  //     record.set("purchasePrice",items.batch[i].purchasePrice);
                  //     record.set("salePrice",items.batch[i].salePrice);
                  // }
                  
                },
                failure: function () {
                    LoadingMask.hideMessage();
                }
            });
            }
            
            OBJ_Adjust.loadBatchCount = function(){
                 Ext.Ajax.request({
                    url: action_urls.get_stockadjust_batchcount,
                    method : 'GET',
                    params:{},
                    success: function (response) {                  
                      var items = Ext.decode(response.responseText);
                      Ext.getCmp("a_batch_pre").setValue(items.batch_count);
                      Ext.getCmp("a_batch_next").setValue(0);                      
                      Ext.getCmp("next_adjust_btn").setDisabled(true);
                      Ext.getCmp("pre_adjust_btn").setDisabled(true);
                    },
                    failure: function () {
                    }
                });
            }
            OBJ_Adjust.loadBatchCount();
        }
    }
    ,
    defaults:{
        border:false
    },
    items: [{
     region:'north',
     height:130,     
     layout:'fit',
     layout:'column',
     items:[{
            columnWidth: 1/2,
            baseCls:'x-plain',
            items:[{
                   xtype: 'fieldset',
                   title: '&nbsp;',
                   collapsible: false,
                   margin:'0 5 5 5',
                   padding:'5 10 0 10',
                   layout:'anchor',
                   defaults: {
                       labelWidth: 150,
                       anchor: '85%',
                       layout: {
                           type: 'hbox',
                           defaultMargins: {top: 0, right: 5, bottom: 0, left: 0}
                       }
                   },
                   items:[
                           {
                               xtype:'combo',
                               fieldLabel:"Adjustement Type",
                               name:'adj_type',
                               id:'adj_type',
                               queryMode: 'local',
                               displayField:'name',
                                typeAhead: true,
                                valueField:'id',
                               value:'0',
                              store: new Ext.data.Store({
                                 fields: ['id', 'name'],
                                   data : [
                                       {"id":"0", "name":'Quantity'},
                                       {"id":"1", "name":'Total Value'},
                                       {"id":"2", "name":'Qunatity & Total Value'},
                                   ]
                               }),
                               listeners:{
                                   change:function(val){                                 
                                    var value=this.value;
                                     var grid = Ext.getCmp("stockadjust-panel-grid");
                                      
                  
                                    if(value==1)
                                    {
                                      Ext.getCmp("adjustType").setValue('2');
                                      grid.columns[6].hide();
                                      grid.columns[7].hide();
                                    }
                                    else{
                                     grid.columns[6].show();
                                      grid.columns[7].show(); 
                                    }
                                    if(value==0)
                                    {
                                      Ext.getCmp("adjustType").setValue('1');
                                     grid.columns[8].hide();
                                      grid.columns[9].hide(); 
                                    }
                                    else{
                                      grid.columns[8].show();
                                      grid.columns[9].show();  
                                    }
                                    if(value==3)
                                    {
                                       Ext.getCmp("adjustType").setValue('3');
                                            grid.columns[6].show();
                                            grid.columns[7].show();     
                                            grid.columns[8].show();
                                            grid.columns[9].show(); 
                                    }
                                   }
                                }  
                            },
                             {
                               xtype:'datefield',
                               fieldLabel:labels_json.stockadjustpanel.adjustement_date,
                               name:'adj_date',
                               id:'adj_date',
                               value: new Date(),
                               maxValue: new Date(),
                               format: 'd-m-Y',
                               listeners:{
                                   change:function(){                                 

                                   }
                                }  
                            },
                           {
                               xtype:'textfield',
                               fieldLabel:labels_json.stockadjustpanel.refno,
                               name:'adj_ref_no',                        
                               id:'adj_ref_no',
                               value:''
                           },                
                           {
                               xtype:'combo',
                               fieldLabel:labels_json.stockadjustpanel.adjust_account,
                               id:'adj_account',
                               name:'adj_account',
                               allowBlank: false,
                               valueField:'id',                         
                               displayField:'acc_name',
                               value:'6',
                               emptyText: 'Select adjustement Account...',                                   
                               store:  account_store,
                               queryMode:'local',   
                               listeners:{
                                   change:function(obj,n,o,e){
                                        if(n==-1){
                                            account_selected_combo = obj.getId();
                                            obj.setValue(o);
                                            winMode =0;
                                            account_form.show();
                                        }                                        
                                    }
                               }
                          },
                           {
                            xtype:'hidden',
                            name:'a_batch_pre',
                            id:'a_batch_pre',
                            value:0
                        }
                        ,
                         {
                            xtype:'hidden',
                            name:'a_batch_next',
                            id:'a_batch_next',
                            value:0
                        }


                   ]

               }]
        },{
            columnWidth: 1/2,
            baseCls:'x-plain',
            items:[{
                 layout:'border',
                 margin:'0 5 15 5',
                 padding:'10 10 4 10',
                 border:false,                                
                 height:120,
                 bodyBorder:false,
                 items:[
                     {
                      region:'north',
                      border:false,                                
                      bodyBorder:false,
                      
                     items:[{
                               xtype:'textfield',
                               fieldLabel:labels_json.stockadjustpanel.memos,
                               name:'adj_memo',                        
                               id:'adj_memo',
                               value:'',
                               width:500
                           },
                            {
                               xtype:'combo',
                               fieldLabel:labels_json.stockadjustpanel.select_category,
                               id:'adj_category',
                               name:'adj_category',
                               allowBlank: false,                               
                               store:category_storeWithAll,
                               valueField:'id',           
                               displayField:'name',
                               value:'0',
                               emptyText: 'Select Category...',                                                                  
                               queryMode:'local',   
                               width:500,
                               listeners:{
                                   change:function(obj,n,o,e){  
                                        var warehouse_id= Ext.getCmp("adj_warehouse").getValue();
                                        // alert(warehouse_id);                                     
                                        var grid = Ext.getCmp("stockadjust-panel-grid");
                                         grid.store.load({
                                             params:{
                                                 category_id : n,
                                                 warehouse_id : warehouse_id
                                             }
                                         });                                                                                   
                                    }
                               }
                           },
                           {
                            
                               xtype:'combo',
                               fieldLabel:labels_json.stockadjustpanel.select_warehouse,
                               id:'adj_warehouse',
                               name:'adj_warehouse',
                               allowBlank: false,                               
                               store:warehouse_store,
                               valueField:'id',           
                               displayField:'warehouse_name',
                               value:'1',
                               emptyText: 'Select Warehouse...',                                                                  
                               queryMode:'local',   
                               width:500,
                               listeners:{
                                    change:function(obj,n,o,e){                                        
                                        var grid = Ext.getCmp("stockadjust-panel-grid");
                                         grid.store.load({
                                             params:{
                                                 warehouse_id : n
                                             }
                                         });                                                                                   
                                    }
                               }
                           
                           },
                           {
                        xtype: 'hidden',
                        id: 'adjustType',
                        name: 'adjustType',
                        value:'1'
                    }]
                     },{
                      region:'center',
                      border:false,                                
                      bodyBorder:false,
                      style:'width:300px;',
                      items:[{
                             xtype:'button',
                             text:labels_json.stockadjustpanel.text_adjust,
                             style:'float:left;margin-bottom:10px;',
                             width:80,
                             listeners:{
                                 click:function(){
                                     var adjusted_items = Ext.getCmp("stockadjust-panel-grid").store.getModifiedRecords();
                                     var AdjustType=Ext.getCmp("adjustType").getValue();

                                     if(Ext.getCmp("adj_account").isValid() && adjusted_items.length && AdjustType=='1'){
                                        LoadingMask.showMessage('Please wait..');                                            
                                        Ext.Ajax.request({
                                          url: action_urls.post_adjusted_items,
                                          method:'POST',
                                          params:{
                                              adjusted_items : Ext.encode(Ext.pluck(adjusted_items,'data')),
                                              warehouse_id: Ext.getCmp("adj_warehouse").getValue(),
                                              date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("adj_date").getValue()),
                                              refno : Ext.getCmp("adj_ref_no").getValue(),
                                              memo : Ext.getCmp("adj_memo").getValue(),
                                              adjust_account:Ext.getCmp("adj_account").getValue(),
                                              adjustType:AdjustType
                                          },
                                          success: function (response) {
                                              var grid = Ext.getCmp("stockadjust-panel-grid");
                                              OBJ_Adjust.loadBatchCount();
                                              Ext.getCmp("adj_memo").setValue('');
                                              Ext.getCmp("noofadjustitem").setValue('0');
                                              grid.store.load( {params:{
                                                 category_id : Ext.getCmp("adj_category").getValue()
                                                }
                                                });
                                              grid.columns[5].show();
                                              grid.columns[4].show();                                                                  
                                              LoadingMask.hideMessage();
                                          }
                                       })
                                     }
                                     else if(Ext.getCmp("adj_account").isValid() && adjusted_items.length && AdjustType=='2'){
                                         LoadingMask.showMessage('Please wait..');                                            
                                        Ext.Ajax.request({
                                          url: action_urls.post_adjusted_items,
                                          method:'POST',
                                          params:{
                                              adjusted_items : Ext.encode(Ext.pluck(adjusted_items,'data')),
                                              warehouse_id: Ext.getCmp("adj_warehouse").getValue(),
                                              date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("adj_date").getValue()),
                                              refno : Ext.getCmp("adj_ref_no").getValue(),
                                              memo : Ext.getCmp("adj_memo").getValue(),
                                              adjust_account:Ext.getCmp("adj_account").getValue(),
                                              adjustValue:Ext.getCmp("new_value").getValue(),
                                              adjustType:AdjustType
                                          },
                                          success: function (response) {
                                              var grid = Ext.getCmp("stockadjust-panel-grid");
                                              OBJ_Adjust.loadBatchCount();
                                              Ext.getCmp("adj_memo").setValue('');
                                              Ext.getCmp("noofadjustitem").setValue('0');
                                              grid.store.load( {params:{
                                                 category_id : Ext.getCmp("adj_category").getValue()
                                                }
                                                });
                                              grid.columns[5].show();
                                              grid.columns[4].show();                                                                  
                                              LoadingMask.hideMessage();
                                          }
                                       })
                                             
                                     }
                                 }
                             }
                        }

                        ]
                 }]
            }]
        }]  
    },
    {
     region:'center',
     layout:'fit',
     border:false,
     bodyBorder:false,
     items:[{
            xtype:"gridpanel",
            id:"stockadjust-panel-grid",
            loadMask: true,
            margin:'0 5 5 5',
            plugins: [Ext.create('Ext.grid.plugin.CellEditing', {
                        clicksToEdit: 1,
                        listeners:{
                            'edit':function(editor, e, eOpts){
                                if(e.column.dataIndex=="newQty"){
                                    if(parseFloat(e.record.get("newQty"))!==0){
                                        e.record.set("qtyDiff",parseFloat(e.record.get("newQty"))-parseFloat(e.record.get("qty")));
                                    }
                                }
                                else if(e.column.dataIndex=="qtyDiff"){
                                    if(parseFloat(e.record.get("qtyDiff"))!==0){
                                        e.record.set("newQty",parseFloat(e.record.get("qtyDiff"))+parseFloat(e.record.get("qty")));
                                  
                                    }
                                }
                             }
                        }
            })],
            store:store_adjust,
          listeners:{

            beforerender:function(){
              
               
            },
            afterRender : function(cmp) {

              if(enableUom==0)
              {
                   cmp.store.on("load",function(){
                    cmp.columns[5].show();             
                    cmp.columns[4].hide();   
                });
              }
              else{
                   cmp.store.on("load",function(){
                    cmp.columns[5].show();             
                    cmp.columns[4].show();   
                });
              }
             
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
                
               
            }

          },
          multiSelect: true,
          columnLines: true,
          selModel: {
            selType: 'cellmodel'
          },
          tbar: [
                 {
                width: 500,
                fieldLabel: labels_json.stockadjustpanel.text_search,
                labelWidth: 80,
                id:'search_field_stock_adj',
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
                        var grid = Ext.getCmp("stockadjust-panel-grid"); 
                        if(val.length>3){
                            grid.store.load({params:{
                                query : val,
                                category_id : Ext.getCmp("adj_category").getValue(),
                                warehouse_id : Ext.getCmp("adj_warehouse").getValue()
                              }
                            });
                        }
                    }
                }
            }
          ],

          columns:[
            {header:labels_json.stockadjustpanel.text_item,dataIndex:"item",width:400,sortable: false,editor:{
                     xtype: 'textfield',
                    id:'item_name',
                    allowBlank: true,
                    readOnly: true,
                    enableKeyEvents:true,
                    listeners:{
                        focus:function(){
                            
                             var sel = Ext.getCmp('stockadjust-panel-grid').getSelectionModel().getSelection()[0]; 
                             //alert(sel.get("id"))
                             // console.log(sel)
                             var Qty=sel.get('qty');
                             var Qtydiff=sel.get('qtyDiff');
                             // console.log(Qtydiff)
                             var cost=sel.get('avg_cost');
                             var total_qty=Number(Qtydiff)+Number(Qty);
                              var value=Number(total_qty) * Number(cost);
                             var adjustValue=Number(Qtydiff) * Number(cost);
                             Ext.getCmp("QtyOnHand").setValue(total_qty)
                             Ext.getCmp("AvgCostPerItem").setValue(cost)
                             Ext.getCmp("total_value").setValue(value)
                             Ext.getCmp("adjustqty_value").setValue(adjustValue)
                             Ext.getCmp("QtyBeforeAdjustment").setValue(Qty)
                             Ext.getCmp("AdjustQty").setValue(Qtydiff)
                             
                             
                        }
                        }
                    } 
                },
            {header:labels_json.stockadjustpanel.text_category,dataIndex:"item_description",flex:1,sortable: false},
            
            {header:labels_json.stockadjustpanel.text_purchase_price,dataIndex:"purchasePrice",width:120,sortable: false},
            {header:labels_json.stockadjustpanel.text_sales_price,dataIndex:"salePrice",width:120,sortable: false},

            {header:labels_json.stockadjustpanel.text_uom,dataIndex:"unit_name",width:120,sortable: false,editor:
            {
                xtype: 'combo',
                allowBlank: true,
                queryMode: 'local',      
                queryMode: 'local',
                store: uom_store_temp,
                id: 'sale_item_uom',
                displayField: 'unit_name',
                enableKeyEvents:true,
                valueField: 'unit_name',
                  listeners:{
                       focus: function() {
                        var sel = Ext.getCmp('stockadjust-panel-grid').getSelectionModel().getSelection()[0];
                        // console.log(sel.get("id"));
                        Ext.Ajax.request({
                                          url: action_urls.get_item_uom,
                                          method:'POST',
                                          params:{
                                              item_id :sel.get("id")
                                          },
                                          success: function (response) {
                                            var data = Ext.JSON.decode(response.responseText);
                                            // console.log(data)
                                            uom_store_temp.removeAll();
                                            Ext.getCmp("sale_item_uom").store.loadData(data.units);

                                            // data=data.units;
                                            // var conv_from=0;
                                            //   for(var i=0;i<data.length;i++){
                                            //      conv_from=data[i].conv_from;
                                                 

                                            //     // Ext.getCmp("item_quantity_new").setValue(data[i].conv_from);
                                            //   }
                                            //   var current_qty=sel.get('qty');
                                            //    var conv_qty=current_qty/conv_from;
                                            //  sel.set("qty", conv_qty);
                                              // console.log(conv_qty);
                                          }
                                       })

            // Ext.MessageBox.alert('Alert box', 'Mouse over event is called');
         },
         change:function(f)
         {
           var sel = Ext.getCmp('stockadjust-panel-grid').getSelectionModel().getSelection()[0];
          var record = f.findRecordByValue(f.getValue()); 
          var conv_qty =  record.get("conv_qty");
          var conv_from =  record.get("conv_from");
           // var current_qty=sel.get('qty');
                  // console.log(record)

                   // Ext.getCmp('current_qty').setValue(conv_from)
           //         var conv_qty=current_qty/conv_from;
                   sel.set("qty", conv_qty);
                   sel.set("conv_from", conv_from);
                    var newqty=sel.get("newQty");
                    // console.log(newqty)
                    if(newqty!=0)
                    {
                    var quantity= sel.get("qty");
                    var total=parseInt(newqty)-parseInt(quantity);
                    // console.log(parseInt(total))
                    sel.set("qtyDiff",parseInt(total));
                    }
         }
                    } 
            }},

            {header:labels_json.stockadjustpanel.text_current_qty,dataIndex:"qty",id:"current_qty", width:120,sortable: false},
            {header:labels_json.stockadjustpanel.text_new_qty,dataIndex:"newQty",width:120,sortable: false, editor: {
                    xtype: 'textfield',
                    id:'item_quantity_new',
                    allowBlank: false,
                    maxLength: 8,
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        keyup:function(){

                           var sel = Ext.getCmp('stockadjust-panel-grid').getSelectionModel().getSelection()[0];
                          
                          var query=this.getValue();
                          sel.set("newQty",query);
                               // Ext.getCmp('sale_item_uom').setDisabled(true)
                        },
                        blur:function(){

                                          var i=Ext.getCmp("noofadjustitem").getValue();
                                         
           var sele = Ext.getCmp('stockadjust-panel-grid').getSelectionModel().getSelection()[0];
           var sumNewVal=Number(sele.get('avg_cost'))+Number(sele.get('totalValue'));
                          // console.log(sumNewVal)
                            sele.set("newValue",sumNewVal);
             var sel = this.getValue() 
            
             
                if(sel ==0)
                {
                    this.setValue('0.00');
                   
                }
                else if(sel !='0.00' )
                {   
                      i=Number(i)+1;
                   Ext.getCmp("noofadjustitem").setValue(i)  
                }
                        },
            focus:function(){
                 var sele = Ext.getCmp('stockadjust-panel-grid').getSelectionModel().getSelection()[0];
                 var sel = this.getValue() 
                 var j=Ext.getCmp("noofadjustitem").getValue();
                 
//                   console.log(old)
                 if(sel !=0)
                     {
                         
                         
                       j=Number(j)-1;
                    Ext.getCmp("noofadjustitem").setValue(j);   
                     }
                 
            },
                    }                                 

            }},

                        
            {header:labels_json.stockadjustpanel.text_diff_qty,dataIndex:"qtyDiff",width:120,sortable: false, editor: {
                    xtype: 'textfield',
                    id:'item_quantity_diff',
                    allowBlank: false,
                    maskRe: /([0-9\s\.-]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        focus:function(){
                
                                  
                        }
                    }                                 

            }},
            {header:"Total Value",width:120,dataIndex:"totalValue",id:"TotalValue",sortable: false},
             {header:"New Value",width:120,dataIndex:"newValue",sortable: false, editor: {
                    xtype: 'textfield',
                    id:'new_value',
                    allowBlank: false,
                    maskRe: /([0-9\s\.-]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        focus:function(){
                
                                  
                        }
                    }                                 

            }}
            ]
          }]
    },
    {
                                        region: 'south',
                                        height: 85,
                                        maxHeight:85,
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
                                                        title: 'Item Info After Adjustement',
                                                        items: [{
                                                                bodyStyle: 'border-left:0px;background-color:#e0e0e0;',
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 4,
                                                                    style: 'margin-bottom: 2px;',
                                                                    tableAttrs: {
                                                                        width: '100%',
                                                                        style: 'margin-bottom: 2px; margin-left:10px;',
                                                                    }
                                                                },
                                                                 
                                                                items: [
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Qty Before Adjustment', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'QtyBeforeAdjustment',
                                                                        name: 'QtyBeforeAdjustment',
                                                                        value: '0.00'
                                                                    },
                                                                     {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Adjust Qty', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'AdjustQty',
                                                                        name: 'sub_total_item_po',
                                                                        value: '0.00'
                                                                    },
                                                                     {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Qty On Hand', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'QtyOnHand',
                                                                        name: 'QtyOnHand',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Avg Cost Per Item', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'AvgCostPerItem',
                                                                        name: 'sub_total_qty_po',
                                                                        value: '0.00'
                                                                    },
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Adjust Qty Value', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '0.00',
                                                                        id: 'adjustqty_value'
                                                                    },
                                                                      {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Total Value', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        value: '0.00',
                                                                        id: 'total_value'
                                                                    }


                                                                ]
                                                            }]
                                                    },
                                                    {
                                                        region: 'east',
                                                        width: 300,
                                                        layout: 'fit',
                                                        items: [{
                                                                bodyStyle: 'border-left:0px;background-color:#e0e0e0;',
                                                                layout: {
                                                                    type: 'table',
                                                                    columns: 2,
                                                                    style: 'margin-top: 20px;',
                                                                    tableAttrs: {
                                                                        width: '100%',
                                                                        style: 'margin-top: 20px; margin-left:10px;',
                                                                    }
                                                                },
                                                                 
                                                                items: [
                                                                    
                                                                    {
                                                                        xtype: 'box',
                                                                        autoEl: {tag: 'div', html: 'Number Of adjustement Items', cls: 'sub_total_text'}
                                                                    },
                                                                    {
                                                                        xtype: 'textfield',
                                                                        style: 'float:right',
                                                                        cls: 'subtotal_digit_field',
                                                                        readOnly: true,
                                                                        width: 100,
                                                                        id: 'noofadjustitem',
                                                                        name: 'sub_total_qty_po',
                                                                        value: '0.00'
                                                                    }
                                                                   


                                                                ]
                                                            }]
                                                    }
                                                    
                                                    
                                                ]
                                            }]
                                    }
                                    
  ]
  ,
    tbar: [ {
            xtype: 'button', 
            text: labels_json.stockadjustpanel.text_new,
            iconCls: 'new',
            tooltip:labels_json.stockadjustpanel.text_new_info,
            listeners:{
                click:function(){
                    var grid = Ext.getCmp("stockadjust-panel-grid");
                    grid.columns[5].show();
                    grid.columns[4].show();                    
                    OBJ_Adjust.loadBatchCount();
                    Ext.getCmp("adj_memo").setValue('');
                    grid.store.load({params:{
                                                 category_id : Ext.getCmp("adj_category").getValue()
                                                }
                                                });
                }
            }
           }, 
           { xtype: 'button', 
             text: labels_json.stockadjustpanel.text_close,
             tooltip:labels_json.stockadjustpanel.text_close_info,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }
           ,
            { xtype: 'button', 
              text: labels_json.stockadjustpanel.text_next,   
              id:'next_adjust_btn',
              iconCls: 'next-order-icon',
              cls:'next-order',
              disabled:true,
              tooltip:labels_json.stockadjustpanel.text_next_info,
              listeners:{
                  click:function(){
                      OBJ_Adjust.next();
                  }
              }
            },
            { xtype: 'button', 
              text: labels_json.stockadjustpanel.text_prev,                     
              iconCls: 'previous-order-icon',
              cls:'previous-order',
              disabled:true,
              id:'pre_adjust_btn',
              tooltip:labels_json.stockadjustpanel.text_prev_info,
              listeners:{
                  click:function(){
                      OBJ_Adjust.previous();
                  }
              }
            }
             

    ]
    
})