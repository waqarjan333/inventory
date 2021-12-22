({
    id: 'customer-group-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.customergrouppanel.heading_title,
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
            title: labels_json.customergrouppanel.text_search_group,
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
                   fieldLabel:labels_json.customergrouppanel.text_name,
                   id:'customer_group_name_search',
                   listeners:{
                        specialkey: function(field, e){
                        if (e.getKey() == e.ENTER) {
                        Ext.getCmp("search_cust_group").fireHandler();
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
                                 text:labels_json.customergrouppanel.button_show_all,
                                 style:'float:right;',
                                 width:80,
                                 listeners:{
                                     click:function(){
                                         Ext.getCmp("customer-group-panel-grid").store.load();
                                     }
                                 }
                            },
                        {
                             xtype:'button',
                             text:labels_json.customergrouppanel.button_search,
                             style:'float:right;margin-right:10px',
                             id: 'search_cust_group',
                             width:80,
                             listeners:{
                                 click:function(){
                                     Ext.getCmp("customer-group-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("customer_group_name_search").getValue()
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
            id:"customer-group-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_customers_group,
                    reader:{
                        type:"json",
                        root: 'groups',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("CustomerGroupModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "cust_group_code",                    
                    "cust_group_name",                    
                    "cust_group_isdefault"
                    ]
            }) && "CustomerGroupModel",
            autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {
                //this.superclass.afterRender.call(this);
                             
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
                
                 Ext.getCmp("customer-group-panel-grid").store.on("load",function(){
                    var data = Ext.pluck(Ext.getCmp("customer-group-panel-grid").store.data.items,'data');
                    customer_group_store.loadData(data);                        
                    customer_group_store_withall.loadData(data);  
                    customer_group_store_withall.insert(0,{
                            "id":"-1", "cust_group_name":"All",
                              "cust_group_isdefault":"0" ,"cust_group_code":"00000"
                        });
                    });   
            }

          },
          selModel: Ext.create('Ext.selection.CheckboxModel', {
                listeners: {
                    selectionchange: function(sm, selections) {
                        if(selections.length==1){
                            Ext.getCmp("editGroupCustBtn").setDisabled(false);
                            Ext.getCmp("deleteGroupCustBtn").setDisabled(false);
                        }
                        else if(selections.length>1){
                            Ext.getCmp("editGroupCustBtn").setDisabled(true);
                            Ext.getCmp("deleteGroupCustBtn").setDisabled(false);
                        }
                        else{
                            Ext.getCmp("editGroupCustBtn").setDisabled(true);
                            Ext.getCmp("deleteGroupCustBtn").setDisabled(true);
                        }
                    }
                }
          }),
          columnLines: true,
          columns:[
            {header:labels_json.customergrouppanel.col_group_code,dataIndex:"cust_group_code",width:100},
            {header:labels_json.customergrouppanel.col_group_name,dataIndex:"cust_group_name",flex:1},            
            {header:labels_json.customergrouppanel.col_group_default,dataIndex:"cust_group_isdefault",width:80,renderer:function(val,meta,record){
                    return (val=="1")? labels_json.customergrouppanel.text_yes:""
            }}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.customergrouppanel.button_new,
             iconCls: 'new',
             tooltip:labels_json.customergrouppanel.tooltip_new,
             listeners:{
                 click:function(){
                      winMode =0;
                      group_form.setTitle(labels_json.customergrouppanel.text_creat_new);
                      group_form.show();
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.customergrouppanel.button_edit,
             iconCls: 'copy',
             id:'editGroupCustBtn',
             disabled:true,
             tooltip:labels_json.customergrouppanel.tooltip_edit,
             listeners:{
                 click:function(){
                     winMode =1;
                     group_form.setTitle(labels_json.customergrouppanel.text_eidt_new);
                     group_form.show();
                      
                 }
             }
           }
           ,
           { xtype: 'button', 
             text: labels_json.customergrouppanel.button_delete,
             id:'deleteGroupCustBtn',
             tooltip:labels_json.customergrouppanel.tooltip_delete,
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Delete',action_urls.delete_cust_group,Ext.getCmp("customer-group-panel-grid"));
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.customergrouppanel.button_close,
             tooltip:labels_json.customergrouppanel.tooltip_close,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})