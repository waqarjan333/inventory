({
    id: 'warehouses-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.warehousespanel.warehouse_head,
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
            title: labels_json.warehousespanel.warehouse_search,
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
                   fieldLabel:labels_json.warehousespanel.text_warehouse_name,
                   id:'warehouse_name_search'
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
                                 text:labels_json.warehousespanel.show_all,
                                 style:'float:right;',
                                 width:80,
                                 listeners:{
                                     click:function(){
                                         Ext.getCmp("warehouse-panel-grid").store.load();
                                     }
                                 }
                            },
                        {
                             xtype:'button',
                             text:labels_json.warehousespanel.text_search,
                             style:'float:right;margin-right:10px',
                             width:80,
                             listeners:{
                                 click:function(){
                                     Ext.getCmp("warehouse-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("warehouse_name_search").getValue()
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
            id:"warehouse-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_warehouses,
                    reader:{
                        type:"json",
                        root: 'warehouses',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("WarehouseModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "warehouse_name",
                    "warehouse_code",
                    "warehouse_isdefault",
                    "warehouse_isactive",
                    "warehouse_contact_name",
                    "warehouse_phone",
                    "warehouse_mobile",
                    "warehouse_ddi_number",
                    "warehouse_address",
                    "warehouse_street",
                    "warehouse_state",
                    "warehouse_city",
                    "warehouse_country",
                    "warehouse_postalcode"
                    ]
            }) && "WarehouseModel",
            autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {
                //this.superclass.afterRender.call(this);
                             
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
            }

          },
          selModel: Ext.create('Ext.selection.CheckboxModel', {
                listeners: {
                    selectionchange: function(sm, selections) {
                        if(selections.length==1){
                            Ext.getCmp("editAccountBtn").setDisabled(false);
                            Ext.getCmp("deactAccountBtn").setDisabled(false);
                        }
                        else if(selections.length>1){
                            Ext.getCmp("editAccountBtn").setDisabled(true);
                            Ext.getCmp("deactAccountBtn").setDisabled(false);
                        }
                        else{
                            Ext.getCmp("editAccountBtn").setDisabled(true);
                            Ext.getCmp("deactAccountBtn").setDisabled(true);
                        }
                    }
                }
          }),
          columnLines: true,
          columns:[
            {header:labels_json.warehousespanel.warehouse_code,dataIndex:"warehouse_code",width:100},
            {header:labels_json.warehousespanel.text_warehouse_name,dataIndex:"warehouse_name",flex:1},
            {header:labels_json.warehousespanel.text_status,dataIndex:"warehouse_isactive",width:120,renderer:function(val,meta,record){
                    return (val=="1")? 'Enabled':"Disabled"
            }},
            {header:labels_json.warehousespanel.text_default,dataIndex:"warehouse_isdefault",width:80,renderer:function(val,meta,record){
                    return (val=="1")? 'Yes':""
            }}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.warehousespanel.text_new,
             iconCls: 'new',
             tooltip:labels_json.warehousespanel.text_new_info,
             listeners:{
                 click:function(){
                      winMode =0;
                      warehouse_form.setTitle('Create New Warehouse');
                      warehouse_form.show();
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.warehousespanel.text_edit,
             iconCls: 'copy',
             id:'editAccountBtn',
             disabled:true,
             tooltip:labels_json.warehousespanel.text_edit_info,
             listeners:{
                 click:function(){
                     winMode =1;
                     warehouse_form.setTitle('Edit/Update Warehouse');
                     warehouse_form.show();
                      
                 }
             }
           }
           ,
           { xtype: 'button', 
             text: labels_json.warehousespanel.text_deactive,
             id:'deactAccountBtn',
             tooltip:labels_json.warehousespanel.text_deactive_info,
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Deactivate',action_urls.deactivate_warehouses,Ext.getCmp("warehouse-panel-grid"));
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.warehousespanel.text_close,
             tooltip:labels_json.warehousespanel.text_close_info,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})