({
    id: 'order-grid',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.ordergrid.heading_title,
    listeners:{
        beforeclose:function(){
           homePage();
        },
        beforerender:function(){        
        customer_store.load();
        }
    },
    items:[{
            region:'north',
            height:115,
            items: new Ext.FormPanel({
                layout:'anchor',
                frame: false,
                border:false,
                id:'order-grid-form',
                bodyBorder:false,
                defaults: {
                        anchor: '100%',
                        margin:'5'
                },
                listeners:{
                    afterrender:function(){
                    
                    var order_grid_form = new Ext.util.KeyMap("order-grid-form", [
                        {
                            key: [10,13],
                            fn: function(){ 
                                Ext.getCmp("search").fireHandler();
                            }
                        }
                    ]);  
                },
                    dirtychange:function(o,d,p){
                        OBJ_Action.recordChange();
                    }
                },
            items:[{
               xtype:'textfield',
               fieldLabel:labels_json.ordergrid.text_order,
               id:'order_no_list'
            },
            {
               xtype:'combo',
               fieldLabel:labels_json.ordergrid.text_status,
               id:'order_status_list',
               displayField:'name',
               queryMode: 'local',
               typeAhead: true,
               valueField:'id',
               value:'0',
               store: new Ext.data.Store({
                  fields: ['id', 'name'],
                    data : [
                        {"id":"0", "name":"All"},
                        {"id":"3", "name":"Paid"},
                        {"id":"2", "name":"Un-Paid"},
                        {"id":"4", "name":"Partial"}
                    ]
                })
            },
            {
                xtype: 'combo',
                fieldLabel:labels_json.ordergrid.text_customer,
                displayField: 'cust_name',
                valueField: 'cust_id',
                id: 'order_customer_list',
                queryMode: 'local',
                value: '-1',
                typeAhead: true,
                store: customer_store_withall

            },

             {
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
                         text:'Show',
                         style:'float:right',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("order-grid-grid").store.load();
                             }
                         }
                    },{
                         xtype:'button',
                         text:"Search",
                         id:'search',
                         style:'float:right;margin-right:10px',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("order-grid-grid").store.load({
                                   params:{search:'1',
                                   search_invoice_id:Ext.getCmp("order_no_list").getValue(),
                                   search_status:Ext.getCmp("order_status_list").getValue(),
                                   search_customer:Ext.getCmp("order_customer_list").getValue()
                                  }
                               });
                             }
                         }
                    }]
                }]
                
            }
            ]})
        },{
            region:'center',
            layout:'fit',
            items:[{xtype:"gridpanel",
                    id:"order-grid-grid",
                    
                    store:{
                      proxy:{
                        type:"ajax",
                        url: action_urls.get_so,
                        reader:{
                            type:"json",
                            root: 'orders',
                            idProperty: 'so_id'
                        }
                    },
                    model:Ext.define("orderListModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            {name:"inv_no",type:'string',convert:function(v,r){
                                   return  inv_prefix+v;
                            }
                            },
                            "so_id",
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
                    }) && "orderListModel",
                    autoLoad:true
                    
          },
          listeners:{
            afterRender : function() {
                //this.superclass.afterRender.call(this);
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
            }
            ,itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("id");
                getPanel(json_urls.sale_invoice,'sale-invoice-panel');
            }
          },

          columnLines: true,
          columns:[
            {header:labels_json.ordergrid.text_order,dataIndex:"inv_no",width:80},
            {header:labels_json.ordergrid.text_orderDate,dataIndex:"so_date",width:120},
            {header:labels_json.ordergrid.text_status,dataIndex:"so_status",width:100},
            {header:labels_json.ordergrid.text_customer,dataIndex:"cust_name",flex:1},
            {header:labels_json.ordergrid.text_dueDate,dataIndex:"so_due_date",width:120},
            {header:labels_json.ordergrid.text_total,dataIndex:"so_total",width:80},
            {header:labels_json.ordergrid.text_paid,dataIndex:"so_paid",width:80},
            {header:labels_json.ordergrid.text_balance,dataIndex:"so_balance",width:80}
            ]
          }]
        }]
})