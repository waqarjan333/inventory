_po_list={
    id: 'purchase-grid',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.purchasegrid.purchase_list,
    listeners:{
        beforeclose:function(){
           homePage();
        },
        beforerender:function(){        
        vendor_store.load();
        }
    },
    items:[{
            region:'north',
            height:115,
            items: new Ext.FormPanel({
                layout:'anchor',
                frame: false,
                border:false,
                id:'purchase-grid-form',
                bodyBorder:false,
                defaults: {
                        anchor: '100%',
                        margin:'5'
                },
                listeners:{
                    afterrender:function(){
                    
                    var purchase_grid_form = new Ext.util.KeyMap("purchase-grid-form", [
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
               fieldLabel:labels_json.purchasegrid.purchase_order,
               id:'purchase_no_list'
            },
            {
               xtype:'combo',
               fieldLabel:labels_json.purchasegrid.purchase_list_status,
               id:'purchase_order_status_list',
               displayField:'name',
               queryMode: 'local',
               typeAhead: true,
               valueField:'id',
               value:'0',
               store: new Ext.data.Store({
                  fields: ['id', 'name'],
                    data : [
                        {"id":"0", "name":"All"},
                        {"id":"1", "name":"Open"},
                        {"id":"2", "name":"In Progress"},
                        {"id":"3", "name":"Completed"}
                    ]
                })
            },
             {
               xtype:'combo',
               fieldLabel:labels_json.purchasegrid.purchase_list_vendor,
               displayField: 'vendor_name',
               valueField:'vendor_id',
               id:'purchase_order_vendor_list',
               queryMode: 'local',
               value:'-1',
               typeAhead: true,
               store: vendor_store_withall
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
                         text:labels_json.purchasegrid.purchase_list_showall,
                         style:'float:right',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("purchase-grid-grid").store.load();
                             }
                         }
                    },{
                         xtype:'button',
                         text:labels_json.purchasegrid.purchase_list_search,
                         id:'search',
                         style:'float:right;margin-right:10px',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("purchase-grid-grid").store.load({
                                   params:{search:'1',
                                   search_invoice_id:Ext.getCmp("purchase_no_list").getValue(),
                                   search_status:Ext.getCmp("purchase_order_status_list").getValue(),
                                   search_vendor:Ext.getCmp("purchase_order_vendor_list").getValue()
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
            border:false,
            bodyBorder:false,
            items:[{xtype:"gridpanel",
                    id:"purchase-grid-grid",
                     store:{
                      proxy:{
                        type:"ajax",
                        url: action_urls.get_po,
                        reader:{
                            type:"json",
                            root: 'orders',
                            idProperty: 'inv_no'
                        }
                    },
                    model:Ext.define("poListModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            {name:"inv_no",type:'string',convert:function(v,r){
                                   return  poinv_prefix+v;
                            }
                            },
                            "id",
                            "po_date",
                            "po_status",
                            "vendor_name",
                            "vendor_id",
                            "po_due_date",
                            "po_total",
                            "po_paid",
                            "po_balance"
                            
                            ]
                    }) && "poListModel",
                    autoLoad:true
                    
          },
          listeners:{
            afterRender : function() {
                //this.superclass.afterRender.call(this);
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
            },itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("id");
                getPanel(json_urls.purchase_invoice,'purchase-invoice-panel');
            }

          },

          columnLines: true,
         columns:[
            {header:labels_json.purchasegrid.purchase_order,dataIndex:"inv_no",width:80},
            {header:labels_json.purchasegrid.purchase_list_date,dataIndex:"po_date",width:120},
            {header:labels_json.purchasegrid.purchase_list_status,dataIndex:"po_status",width:100},
            {header:labels_json.purchasegrid.purchase_list_vendor,dataIndex:"vendor_name",flex:1},
            {header:labels_json.purchasegrid.text_due_date,dataIndex:"po_due_date",width:120},
            {header:labels_json.purchasegrid.text_total,dataIndex:"po_total",width:80},
            {header:labels_json.purchasegrid.purchase_list_paid,dataIndex:"po_paid",width:80},
            {header:labels_json.purchasegrid.purchase_list_balance,dataIndex:"po_balance",width:80}
            ]
          }]
        }]
}