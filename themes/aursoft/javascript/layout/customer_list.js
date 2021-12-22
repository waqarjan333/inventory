({
    id: 'customer-grid',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.customergrid.heading_title_list,
    listeners:{
        beforeclose:function(){
           homePage();
        }
    },
    items:[{
         region:'north',
         height:115,
         items: new Ext.FormPanel({
                layout:'anchor',
                frame: false,
                border:false,
                id:'customer-grid-form',
                bodyBorder:false,
                defaults: {
                        anchor: '100%',
                        margin:'5'
                },
                listeners:{
                    afterrender:function(){
                    
                    var customer_grid_form = new Ext.util.KeyMap("customer-grid-form", [
                        {
                            key: [10,13],
                            fn: function(){ 
                                Ext.getCmp("search_cust_list").fireHandler();
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
               fieldLabel:labels_json.customergrid.label_cust_name,
               id:'customer_name_list',
               listeners:{
                     
                   }
            },
            {
               xtype:'textfield',
               fieldLabel:labels_json.customergrid.label_contact,
               id:'customer_contact_list',
               listeners:{
                      
                   }
            },
             {
               xtype:'textfield',
               fieldLabel:labels_json.customergrid.label_cust_cont_mobile,
               id:'customer_mobile_list',
               listeners:{
                
                   }
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
                    width:'100%',
                    items:[
                        {
                         xtype:'button',
                         text:labels_json.customergrid.button_show_all,
                         style:'float:right',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("customer-grid-grid").store.load();
                             }
                         }
                    },{
                         xtype:'button',
                         text:labels_json.customergrid.button_search,
                         id: 'search_cust_list',
                         style:'float:right;margin-right:10px',
                         width:80,                         
                         listeners:{
                             click:function(){
                               Ext.getCmp("customer-grid-grid").store.load({
                                   params:{search:'1',
                                   search_name:Ext.getCmp("customer_name_list").getValue(),
                                   search_contact:Ext.getCmp("customer_contact_list").getValue(),
                                   search_mobile:Ext.getCmp("customer_mobile_list").getValue(),
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
            id:'customer_list_center_panel',
            items:[{xtype:"gridpanel",                                                
                    bodyBorder:false,
                     id:'customer-grid-grid',
                     store:{
                        proxy:{
                            type:"ajax",
                            url: action_urls.get_customers,
                            reader:{
                                type:"json",
                                root: 'customers',
                                idProperty: 'cust_id'
                            }
                    },
                    model:Ext.define("customerListModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            "cust_id",
                            "cust_name",
                            "cust_contact",
                            "cust_group",
                            "cust_phone",
                            "cust_email",
                            "cust_fax",
                            "cust_mobile",
                            "cust_status",
                            "cust_address"
                            ]
                    }) && "customerListModel",
                    autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {
                //this.superclass.afterRender.call(this);
                var jstore = cmp.store; 
                jstore.on('load', function(store, records, successful,operation, options) {
                   var loadJsonData = {"cust_id":''};
                   //createEmptyRows(store,loadJsonData);
                });

                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
            },
            itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("cust_id");
               
                getPanel(json_urls.customers,'customer-panel');
            }

          },

          columnLines: true,
          columns:[
            {header:labels_json.customergrid.col_cust_status,dataIndex:"cust_status",width:120,renderer:function(v){
                    var html = '';
                    if(v!=''){
                        html ='<div class="'+((v.toLowerCase()=='active')?'activate':'deactivate')+' _grid_icon1">'+v+'</div>'
                    }
                    return html;
            }},
            {header:labels_json.customergrid.col_cust_name,dataIndex:"cust_name",flex:2},
            {header:labels_json.customergrid.col_cust_contact,dataIndex:"cust_contact",width:140},
            {header:labels_json.customergrid.col_cust_region,dataIndex:"cust_group",width:140},
            {header:labels_json.customergrid.col_cust_mobile,dataIndex:"cust_mobile",width:120},
            {header:labels_json.customergrid.col_cust_phone,dataIndex:"cust_phone",width:120},
            {header:labels_json.customergrid.col_cust_email,dataIndex:"cust_email",width:150},
            {header:labels_json.customergrid.col_cust_fax,dataIndex:"cust_fax",width:80},
            {header:labels_json.customergrid.col_cust_address,dataIndex:"cust_address",flex:1}
            
            ]
          }]
        }]
})