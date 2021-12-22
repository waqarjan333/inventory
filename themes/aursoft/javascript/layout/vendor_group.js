({
    id: 'warehouses-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:'Manage Warehouses',
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
            title: 'Search Warehouse',
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
                   fieldLabel:'Warehouse Name',
                   id:'warehouse_name_search'
                },
                {
                    layout:'border',
                    border:false,
                    bodyBorder:false,
                    defaults:{
                        border:false
                    },
                    items:[{
                        region:'center',
                        items:[
                        {
                                 xtype:'button',
                                 text:'Show All',
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
                             text:'Search',
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
                this.superclass.afterRender.call(this);
                             
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
            {header:"Warehouse Code",dataIndex:"warehouse_code",width:100},
            {header:"Warehouse Name",dataIndex:"warehouse_name",flex:1},
            {header:"Status",dataIndex:"warehouse_isactive",width:120,renderer:function(val,meta,record){
                    return (val=="1")? 'Enabled':"Disabled"
            }},
            {header:"Default",dataIndex:"warehouse_isdefault",width:80,renderer:function(val,meta,record){
                    return (val=="1")? 'Yes':""
            }}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: 'New',
             iconCls: 'new',
             tooltip:'Create a new warehouse.',
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
             text: 'Edit',
             iconCls: 'copy',
             id:'editAccountBtn',
             disabled:true,
             tooltip:'Edit selected account.',
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
             text: 'Deactivate',
             id:'deactAccountBtn',
             tooltip:'Deactivate this warehouse so that it will not <br/> be shown in other screens such as Sales <br/> order. Deactivated warehouses can be <br/> reactivated again in future.',
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
             text: 'Close',
             tooltip:'Close Warehouse Management.',
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})