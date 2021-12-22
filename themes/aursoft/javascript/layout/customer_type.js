({
    id: 'customer-type-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.customertypepanel.heading_title,
    listeners:{
        beforeclose:function(){
           homePage();
        }
        ,
        afterrender:function (){
              
        
        }
    }
    ,
    defaults:{
        border:false
    },
    items: [{
     region:'north',
     height:100,
     layout:'fit',
     items:[{
            xtype: 'fieldset',
            title: labels_json.customertypepanel.text_search_type,
            collapsible: false,
            margin:'0 5 5 5',
            padding:10,
            layout:'anchor',
            defaults: {
                labelWidth: 100,
                anchor: '100%',
                layout: {
                    type: 'hbox',
                    defaultMargins: {top: 0, right: 5, bottom: 0, left: 0}
                }
            },
            items:[
                {
                   xtype:'textfield',
                   fieldLabel:labels_json.customertypepanel.text_name,
                   id:'customer_type_name_search',
                   listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("search_cust_type").fireHandler();
                      }
                     }
                   }
                },
                {
                    layout:'border',
                    border:false,
                    height:22,
                    bodyBorder:false,
                    defaults:{
                        border:false
                    },
                    items:[{
                        region:'center',
                        items:[
                        {
                                 xtype:'button',
                                 text:labels_json.customertypepanel.button_show_all,
                                 style:'float:right;',
                                 width:80,
                                 listeners:{
                                     click:function(){
                                         Ext.getCmp("customer-type-panel-grid").store.load();
                                     }
                                 }
                            },
                        {
                             xtype:'button',
                             text:labels_json.customertypepanel.button_search,
                             style:'float:right;margin-right:10px',
                             id:'search_cust_type',
                             width:80,
                             listeners:{
                                 click:function(){
                                     Ext.getCmp("customer-type-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("customer_type_name_search").getValue()
                                         }
                                     });
                                 }
                             }
                        }]
                    }]

                }

            ]

        }]
    },
    {
     region:'center',
     layout:'fit',
     border:false,                                
     bodyBorder:false,
     items:[{
            xtype:"gridpanel",
            id:"customer-type-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_customers_type,
                    reader:{
                        type:"json",
                        root: 'types',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("CustomerTypeModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "cust_type_code",                    
                    "cust_type_name",                    
                    "cust_type_isdefault"
                    ]
            }) && "CustomerTypeModel",
            autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {
                //this.superclass.afterRender.call(this);
                             
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
                
                 Ext.getCmp("customer-type-panel-grid").store.on("load",function(){
                    var data = Ext.pluck(Ext.getCmp("customer-type-panel-grid").store.data.items,'data');
                    customer_type_store.loadData(data);                        
                    customer_type_store_withall.loadData(data);  
                    customer_type_store_withall.insert(0,{
                            "id":"-1", "cust_type_name":"All",
                              "cust_type_isdefault":"0" ,"cust_type_code":"00000"
                        });
                    });   
            }

          },
          selModel: Ext.create('Ext.selection.CheckboxModel', {
                listeners: {
                    selectionchange: function(sm, selections) {
                        if(selections.length==1){
                            Ext.getCmp("editTypeCustBtn").setDisabled(false);
                            Ext.getCmp("deleteTypeCustBtn").setDisabled(false);
                        }
                        else if(selections.length>1){
                            Ext.getCmp("editTypeCustBtn").setDisabled(true);
                            Ext.getCmp("deleteTypeCustBtn").setDisabled(false);
                        }
                        else{
                            Ext.getCmp("editTypeCustBtn").setDisabled(true);
                            Ext.getCmp("deleteTypeCustBtn").setDisabled(true);
                        }
                    }
                }
          }),
          columnLines: true,
          columns:[
            {header:labels_json.customertypepanel.col_type_code,dataIndex:"cust_type_code",width:100},
            {header:labels_json.customertypepanel.col_type_name,dataIndex:"cust_type_name",flex:1},            
            {header:labels_json.customertypepanel.col_type_default,dataIndex:"cust_type_isdefault",width:80,renderer:function(val,meta,record){
                    return (val=="1")? labels_json.customertypepanel.text_yes:""
            }}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.customertypepanel.button_new,
             iconCls: 'new',
             tooltip:labels_json.customertypepanel.tooltip_new,
             listeners:{
                 click:function(){
                      winMode =0;
                      type_form.setTitle(labels_json.customertypepanel.text_creat_new);
                      type_form.show();
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.customertypepanel.button_edit,
             iconCls: 'edit',
             id:'editTypeCustBtn',
             disabled:true,
             tooltip:labels_json.customertypepanel.tooltip_edit,
             listeners:{
                 click:function(){
                     winMode =1;
                     type_form.setTitle(labels_json.customertypepanel.text_eidt_new);
                     type_form.show();
                      
                 }
             }
           }
           ,
           { xtype: 'button', 
             text: labels_json.customertypepanel.button_delete,
             id:'deleteTypeCustBtn',
             tooltip:labels_json.customertypepanel.tooltip_delete,
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Delete',action_urls.delete_cust_type,Ext.getCmp("customer-type-panel-grid"));
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.customertypepanel.button_close,
             tooltip:labels_json.customertypepanel.tooltip_close,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})