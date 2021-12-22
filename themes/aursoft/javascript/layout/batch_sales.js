({
    id: 'batch-sales-panel',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.batchsalespanel.heading_batch,
    listeners:{
        beforeclose:function(){
           homePage();
           
        },
        afterrender:function(){                        
            
        },
        beforerender:function(){
          customer_store.load();     
        },
        show:function(){
            OBJ_Action_batch = {};
            OBJ_Action_batch.setPrintMode = function(){
               var print_iframe = Ext.get("print-batch-list");
               if(print_iframe && print_iframe.dom && print_iframe.dom.contentWindow && print_iframe.dom.contentWindow.$){
                   
                    var print_list_iframe = print_iframe.dom.contentWindow;
                    var jsonBatchInvoiceData = Ext.getCmp('batch-sales-panel-grid').selModel.getSelection();//Ext.pluck(Ext.getCmp('batch-sales-panel-grid').store.data.items,'data');
                    print_list_iframe.$(".from-invoice-date").html(Ext.Date.format(Ext.getCmp("from_date_sale_invoice").getValue(),'d-m-Y'));
                    print_list_iframe.$(".to-invoice-date").html(Ext.Date.format(Ext.getCmp("end_date_sale_invoice").getValue(),'d-m-Y'));
                    print_list_iframe.$(".region_customer").html(Ext.getCmp("batch_order_group_list").getRawValue());
                    print_list_iframe.$(".type-customer").html(Ext.getCmp("batch_order_type_list").getRawValue());
                    var invoices_html = "";
                    var invoices_total = 0;
                    for(var i=0;i<jsonBatchInvoiceData.length;i++){
                        if(parseFloat(jsonBatchInvoiceData[i].get("so_total").replace(/,/g,""))!==0){
                            invoices_html +="<tr>";
                            invoices_html +="<td>"+jsonBatchInvoiceData[i].get("so_date")+"</td>";
                            invoices_html +="<td>INV-"+jsonBatchInvoiceData[i].get("id")+"</td>";
                            invoices_html +="<td>"+jsonBatchInvoiceData[i].get("cust_name")+"</td>";                            
                            invoices_html +="<td style='text-align:right'>"+jsonBatchInvoiceData[i].get("so_total")+"</td>";
                            invoices_html +="</tr>";
                            invoices_total += parseFloat(jsonBatchInvoiceData[i].get("so_total").replace(/,/g,"")) 
                        }
                    }
                    print_list_iframe.$(".receipt-large-body").html(invoices_html);
                    print_list_iframe.$(".total_amount").html(Ext.util.Format.number(invoices_total, "0.00")+" Rs.");
                    print_list_iframe.print();
               }
               else{
                   setTimeout("OBJ_Action_batch.setPrintMode()",200);
               }
           }
           Ext.getCmp('batch-sales-panel-grid').store.removeAll();
        }
    },
    items:[{
            region:'north',
            height:100,
            items: new Ext.FormPanel({
                layout:'column',
                frame: false,
                border:false,                                
                bodyBorder:false,
                id:'batch-grid-form',
                bodyBorder:false,
                defaults: {
                       layout: 'anchor',
                       border:false,
                       bodyBorder:false,
                       defaults: {
                                anchor: '100%',
                                margin:5 
                       }
                },
            items:[{
                  columnWidth: 1/2,
                  items:[ {                
                        xtype:'datefield',
                        fieldLabel:labels_json.label_from_date,
                        id:'from_date_sale_invoice',
                        value: new Date(),
                        maxValue: new Date(),
                        format: 'd-m-Y'
                     },{
                        xtype:'datefield',
                        fieldLabel:labels_json.label_end_date,
                        id:'end_date_sale_invoice',
                        value: new Date(),
                        maxValue: new Date(),
                        format: 'd-m-Y'
                     },
                     {
                            xtype:'combo',
                            fieldLabel:labels_json.batchsalespanel.label_customer,
                            displayField: 'cust_name',
                            valueField:'cust_id',
                            id:'batch_order_customer_list',
                            queryMode: 'local',
                            value:"-1",
                            typeAhead: true,
                            store: customer_store_withall
                         }
                    ]
                },
                {
                 columnWidth:1/2,
                 items:[
                 {
                    xtype:'combo',
                    fieldLabel:labels_json.batchsalespanel.label_customer_type,
                    displayField: 'cust_type_name',
                    valueField:'id',
                    id:'batch_order_type_list',
                    queryMode: 'local',
                    value:'-1',
                    typeAhead: true,
                    store: customer_type_store_withall
                 },
                 {
                    xtype:'combo',
                    fieldLabel:labels_json.batchsalespanel.label_group,
                    displayField: 'cust_group_name',
                    valueField:'id',
                    id:'batch_order_group_list',
                    queryMode: 'local',
                    value:'-1',
                    typeAhead: true,
                    store: customer_group_store_withall
                 },{
                     layout:'border',
                     border:false,
                     bodyBorder:false,
                     height:22,
                     defaults:{
                         border:false
                     },
                     items:[{
                         region:'center',
                         items:[{
                              xtype:'button',
                              text:labels_json.batchsalespanel.button_search,
                              style:'float:right;',
                              width:80,
                              listeners:{
                                  click:function(){
                                   Ext.getCmp("batch-sales-panel-grid").store.load({
                                         params:{
                                         search_from_date:Ext.Date.format(Ext.getCmp("from_date_sale_invoice").getValue(),'Y-m-d H:i:s'),
                                         search_end_date:Ext.Date.format(Ext.getCmp("end_date_sale_invoice").getValue(),'Y-m-d H:i:s'),
                                         search_customer:Ext.getCmp("batch_order_customer_list").getValue(),
                                         search_group:Ext.getCmp("batch_order_group_list").getValue(),
                                         search_type:Ext.getCmp("batch_order_type_list").getValue()
                                        }
                                     });
                                  }
                              }
                         }]
                     }]

                 }]
                }         
             
            ]})
        },{
            region:'center',
            layout:'fit',
            bodyBorder:false,
            border:false,
            items:[{xtype:"gridpanel",
                    id:"batch-sales-panel-grid",
                    
                    store:{
                      proxy:{
                        type:"ajax",
                        url: action_urls.get_batch_invoices,
                        reader:{
                            type:"json",
                            root: 'orders',
                            idProperty: 'inv_no'
                        }
                    },
                    model:Ext.define("orderBatchListModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            {name:"inv_no",type:'string',convert:function(v,r){
                                   return  inv_prefix+v;
                            }
                            },
                            "id",
                            "so_date",
                            "so_status",
                            "cust_name",
                            "cust_id",
                            "so_due_date",
                            "so_total",
                            "so_paid",
                            "so_balance"
                            
                            ]
                    }) && "orderBatchListModel"
                    
          },
          listeners:{
            afterRender : function() {               
               Ext.getCmp("batch-sales-panel-grid").store.on("load",function(){
                var grid = Ext.getCmp("batch-sales-panel-grid");
                var jsonBatchInvoiceData = Ext.encode(Ext.pluck(Ext.getCmp('batch-sales-panel-grid').store.data.items,'data'));
                    for(var i=0;i<jsonBatchInvoiceData.length;i++){
                        grid.getSelectionModel().select(i,true);
                    }
               });
            }
            ,itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("id");
                //getPanel(json_urls.sale_invoice,'sale-invoice-panel');
            }
          },
           selModel: Ext.create('Ext.selection.CheckboxModel', {
                listeners: {
                    selectionchange: function(sm, selections) {
                       if(selections.length>=1){
                           Ext.getCmp("startBatchPrinting").setDisabled(false);
                           Ext.getCmp("batchListPrinting").setDisabled(false);
                       }
                       else{
                           Ext.getCmp("startBatchPrinting").setDisabled(true);
                           Ext.getCmp("batchListPrinting").setDisabled(true);
                       }
                    }
                }
          }),
          columnLines: true,
          columns:[
            {header:labels_json.batchsalespanel.col_order_no,dataIndex:"inv_no",width:80,renderer:function(v,r,a,n){                                
                                
                                return v;
                            }},
            {header:labels_json.batchsalespanel.col_order_date,dataIndex:"so_date",width:120},            
            {header:labels_json.batchsalespanel.col_customer,dataIndex:"cust_name",flex:1},
            {header:labels_json.batchsalespanel.col_due_date,dataIndex:"so_due_date",width:120},
            {header:labels_json.batchsalespanel.col_total,dataIndex:"so_total",width:150}
            ]
          }]
        }]
 ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.batchsalespanel.button_start_printing,
             id:'startBatchPrinting',
             disabled:true,
             iconCls: 'print',
             tooltip: labels_json.batchsalespanel.tooltip_start_printing,
             listeners:{
                 click:function(){
                    LoadingMask.showMessage( labels_json.batchsalespanel.msg_loading_batch);
                    Ext.Ajax.request({
                        url: action_urls.get_batch_detail,
                        params:{
                            selected:getSelection(Ext.getCmp("batch-sales-panel-grid"))                          
                        },
                        success: function (response) {
                             batch_array = Ext.decode( response.responseText );
                             LoadingMask.hideMessage();

                             if(batch_array.action=='success'){
                                 
                                 printBatch(0);
                             }else{
                                 Ext.Msg.show({
                                     title:'Error',
                                     msg: batch_array.msg,
                                     buttons: Ext.Msg.OK,
                                     icon: Ext.Msg.ERROR
                                });
                             }

                        },
                        failure: function () {
                             LoadingMask.hideMessage();
                        }
                   });
                 }
             }
           },
           { xtype: 'button', 
             text: labels_json.batchsalespanel.button_print_list,
             disabled:true,
             id:'batchListPrinting',
             tooltip:labels_json.batchsalespanel.tooltip_print_list,
             iconCls: 'print',
             listeners:{
                 click:function(){
                    if(!Ext.get("print-batch-list")){
                        Ext.DomHelper.append(Ext.getBody(), {tag: 'iframe',height:'1px',width:'1px', cls: 'print-frame', id: 'print-batch-list',frameborder:'0',src:print_url.print_list});                         
                    }
                    OBJ_Action_batch.setPrintMode();
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.batchsalespanel.button_close,
             tooltip:labels_json.batchsalespanel.tooltip_close_batch,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})
