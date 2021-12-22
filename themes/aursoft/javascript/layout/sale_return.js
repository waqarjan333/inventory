({
    id: 'sales-return-panel',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.salesreturnpanel.heading,
    listeners:{
        beforeclose:function(){
           // homePage();
           window.location.reload();
           
        },
        afterrender:function(){                        
            
        },
        show:function(){
            OBJ_Action_batch = {};
            OBJ_Action_batch.setPrintMode = function(){
               var print_iframe = Ext.get("print-batch-list");
               if(print_iframe && print_iframe.dom && print_iframe.dom.contentWindow && print_iframe.dom.contentWindow.$){
                   
                    var print_list_iframe = print_iframe.dom.contentWindow;
                    var jsonBatchInvoiceData = Ext.getCmp('sales-return-panel-grid').selModel.getSelection();//Ext.pluck(Ext.getCmp('sales-return-panel-grid').store.data.items,'data');
                    print_list_iframe.$(".from-invoice-date").html(Ext.Date.format(Ext.getCmp("from_date_sale_return").getValue(),'d-m-Y'));
                    print_list_iframe.$(".to-invoice-date").html(Ext.Date.format(Ext.getCmp("end_date_sale_return").getValue(),'d-m-Y'));
                    print_list_iframe.$(".region_customer").html(Ext.getCmp("sale_return_group_list").getRawValue());
                    print_list_iframe.$(".type-customer").html(Ext.getCmp("sale_return_type_list").getRawValue());
                    // print_list_iframe.$(".inv-head").html(labels_json.salesreturnpanel.text_invoice);
                    var invoices_html = "";
                    var invoices_total = 0;
                    for(var i=0;i<jsonBatchInvoiceData.length;i++){
                        if(parseFloat(jsonBatchInvoiceData[i].get("so_total").replace(/,/g,""))!==0){
                            invoices_html +="<tr>";
                            invoices_html +="<td>"+jsonBatchInvoiceData[i].get("so_date")+"</td>";
                            invoices_html +="<td>SR.INV-"+jsonBatchInvoiceData[i].get("id")+"</td>";
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
           Ext.getCmp('sales-return-panel-grid').store.removeAll();
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
                        id:'from_date_sale_return',
                        value: new Date(),
                        maxValue: new Date(),
                        format: 'd-m-Y'
                     },{
                        xtype:'datefield',
                        fieldLabel:labels_json.label_end_date,
                        id:'end_date_sale_return',
                        value: new Date(),
                        maxValue: new Date(),
                        format: 'd-m-Y'
                     },
                     {
                            xtype:'combo',
                            fieldLabel:labels_json.salesreturnpanel.label_customer,
                            displayField: 'cust_name',
                            valueField:'cust_id',
                            id:'sale_return_customer_list',
                            queryMode: 'local',
                            value:'-1',
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
                    fieldLabel:labels_json.salesreturnpanel.label_customer_type,
                    displayField: 'cust_type_name',
                    valueField:'id',
                    id:'sale_return_type_list',
                    queryMode: 'local',
                    value:'-1',
                    typeAhead: true,
                    store: customer_type_store_withall
                 },
                 {
                    xtype:'combo',
                    fieldLabel:labels_json.salesreturnpanel.label_group,
                    displayField: 'cust_group_name',
                    valueField:'id',
                    id:'sale_return_group_list',
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
                              text:labels_json.salesreturnpanel.button_search,
                              style:'float:right;',
                              width:80,
                              listeners:{
                                  click:function(){
                                   Ext.getCmp("sales-return-panel-grid").store.load({
                                         params:{
                                         search_from_date:Ext.Date.format(Ext.getCmp("from_date_sale_return").getValue(),'Y-m-d H:i:s'),
                                         search_end_date:Ext.Date.format(Ext.getCmp("end_date_sale_return").getValue(),'Y-m-d H:i:s'),
                                         search_customer:Ext.getCmp("sale_return_customer_list").getValue(),
                                         search_group:Ext.getCmp("sale_return_group_list").getValue(),
                                         search_type:Ext.getCmp("sale_return_type_list").getValue()
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
                    id:"sales-return-panel-grid",
                    
                    store:{
                      proxy:{
                        type:"ajax",
                        url: action_urls.get_sale_return_invoices,
                        reader:{
                            type:"json",
                            root: 'orders',
                            idProperty: 'so_id'
                        }
                    },
                    model:Ext.define("orderBatchListModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            {name:"so_id",type:'string',convert:function(v,r){
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
               Ext.getCmp("sales-return-panel-grid").store.on("load",function(){
                var grid = Ext.getCmp("sales-return-panel-grid");                
               });
            }
            ,itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("id");
                //getPanel(json_urls.sale_invoice,'sale-invoice-panel');
            }
          },
          columnLines: true,
          columns:[
            {header:labels_json.salesreturnpanel.col_order_no,dataIndex:"so_id",width:80,renderer:function(v,r,a,n){                                
                                
                                return v;
                            }},
            {header:labels_json.salesreturnpanel.col_order_date,dataIndex:"so_date",width:120},            
            {header:labels_json.salesreturnpanel.col_customer,dataIndex:"cust_name",flex:1},
            {header:labels_json.salesreturnpanel.col_due_date,dataIndex:"so_due_date",width:120},
            {header:labels_json.salesreturnpanel.col_total,dataIndex:"so_total",width:150},
            {
                header: '',
                renderer: function (v, m, r) {
                var id = Ext.id();                   
                    Ext.defer(function () {
                        Ext.widget('button', {
                            renderTo: id,
                            text: labels_json.salesreturnpanel.col_return,
                            cls:'receive_btn',
                            width: 90,
                            handler: function () {
                                editItem.id = r.get("id");
                                editItem.type = "SALE_RET";
                                getPanel(json_urls.sale_invoice,'sale-invoice-panel');
                            }
                        });
                    }, 50);                   
                    return Ext.String.format('<div id="{0}"></div>', id);
                }
            }
            ]
          }]
        }]
 ,
    tbar: [           
           { xtype: 'button', 
             text: labels_json.salesreturnpanel.button_close,
             tooltip:labels_json.salesreturnpanel.tooltip_close_batch,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     // homePage();
                     window.location.reload();
                 }
             }
           }

    ]
})