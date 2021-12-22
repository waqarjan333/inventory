({
    id: 'vendor-grid',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.vendorgrid.vendor_list_head,
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
                id:'vendor-grid-form',
                bodyBorder:false,
                defaults: {
                        anchor: '100%',
                        margin:'5'
                },
                listeners:{
                    afterrender:function(){
                    
                    var vendor_grid_form = new Ext.util.KeyMap("vendor-grid-form", [
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
               fieldLabel:labels_json.vendorgrid.text_vendor_name,
               id:'vendor_name_list'
            },
            {
               xtype:'textfield',
               fieldLabel:labels_json.vendorgrid.text_contact,
               id:'vendor_contact_list'
            },
             {
               xtype:'textfield',
               fieldLabel:labels_json.vendorgrid.text_mobile,
               id:'vendor_mobile_list'
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
                    items:[
                        {
                         xtype:'button',
                         text:labels_json.vendorgrid.show_all,
                         style:'float:right',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("vendor-grid-grid").store.load();
                             }
                         }
                    },{
                         xtype:'button',
                         id:'search',
                         text:labels_json.vendorgrid.text_search,
                         style:'float:right;margin-right:10px',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("vendor-grid-grid").store.load({
                                   params:{search:'1',
                                   search_name:Ext.getCmp("vendor_name_list").getValue(),
                                   search_contact:Ext.getCmp("vendor_contact_list").getValue(),
                                   search_mobile:Ext.getCmp("vendor_mobile_list").getValue(),
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
                      id:'vendor-grid-grid',
                      store:{
                        proxy:{
                            type:"ajax",
                            url: action_urls.get_vendors,
                            reader:{
                                type:"json",
                                root: 'vendors',
                                idProperty: 'vendor_id'
                            }
                    },
                    model:Ext.define("vendorListModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            "vendor_id",
                            "vendor_name",
                            "vendor_contact",
                            "vendor_phone",
                            "vendor_email",
                            "vendor_fax",
                            "vendor_mobile",
                            "vendor_status",
                            "vendor_address"
                            ]
                    }) && "vendorListModel",
                    autoLoad:true
          },
          listeners:{
            afterRender : function() {
                //this.superclass.afterRender.call(this);
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
            },
            itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("vendor_id");  
                getPanel(json_urls.vendors,'vendor-panel');
            }

          },

          columnLines: true,
          columns:[
             {header:"Status",dataIndex:"vendor_status",width:120,renderer:function(v){
                    var html = '';
                    if(v!=''){
                        html ='<div class="'+((v.toLowerCase()=='active')?'activate':'deactivate')+' _grid_icon1">'+v+'</div>'
                    }
                    return html;
            }},
            {header:labels_json.vendorgrid.text_vendor_name,dataIndex:"vendor_name",flex:2},
            {header:labels_json.vendorgrid.text_contact,dataIndex:"vendor_contact",width:140},
            {header:labels_json.vendorgrid.text_mobile,dataIndex:"vendor_mobile",width:120},
            {header:labels_json.vendorgrid.text_phone,dataIndex:"vendor_phone",width:120},
            {header:labels_json.vendorgrid.text_email,dataIndex:"vendor_email",width:150},
            {header:labels_json.vendorgrid.text_fax,dataIndex:"vendor_fax",width:80},
            {header:labels_json.vendorgrid.vendor_address,dataIndex:"vendor_address",flex:1}
            
            ]
          }]
        }]
})