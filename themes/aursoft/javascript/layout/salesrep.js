({
    id: 'salesrep-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.salesreppanel.heading_title,
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
            title: labels_json.salesreppanel.fieldlabel_salesrep,
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
                   fieldLabel:labels_json.salesreppanel.label_salesrep_name,
                   id:'salesrep_name_search'
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
                                 text:labels_json.salesreppanel.button_show_all,
                                 style:'float:right;',
                                 width:80,
                                 listeners:{
                                     click:function(){
                                         Ext.getCmp("salesrep-panel-grid").store.load();
                                     }
                                 }
                            },
                        {
                             xtype:'button',
                             text:labels_json.salesreppanel.button_search,
                             style:'float:right;margin-right:10px',
                             width:80,
                             listeners:{
                                 click:function(){
                                     Ext.getCmp("salesrep-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("salesrep_name_search").getValue()
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
            id:"salesrep-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_salesrep,
                    reader:{
                        type:"json",
                        root: 'salesreps',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("SalesrepModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "salesrep_name",
                    "salesrep_title",                    
                    "salesrep_status",                    
                    "salesrep_phone",
                    "salesrep_email",
                    "salesrep_mobile",                    
                    "salesrep_address"
                    ]
            }) && "SalesrepModel",
            autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {                
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
                            
               Ext.getCmp("salesrep-panel-grid").store.on("load",function(){
                   Ext.getCmp("salesrep-panel-grid").getSelectionModel().deselectAll();
               });
            
            }

          },
          selModel: Ext.create('Ext.selection.CheckboxModel', {
                listeners: {
                    selectionchange: function(sm, selections) {
                        if(selections.length==1){
                            Ext.getCmp("editSaleRepBtn").setDisabled(false);
                            Ext.getCmp("deactSaleRepBtn").setDisabled(false);
                            //Ext.getCmp("deleteSaleRepBtn").setDisabled(false);
                        }
                        else if(selections.length>1){
                            Ext.getCmp("editSaleRepBtn").setDisabled(true);
                            Ext.getCmp("deactSaleRepBtn").setDisabled(false);
                            //Ext.getCmp("deleteSaleRepBtn").setDisabled(false);
                        }
                        else{
                            Ext.getCmp("editSaleRepBtn").setDisabled(true);
                            Ext.getCmp("deactSaleRepBtn").setDisabled(true);
                            //Ext.getCmp("deleteSaleRepBtn").setDisabled(true);
                        }
                    }
                }
          }),
          columnLines: true,
          columns:[
            {header:labels_json.salesreppanel.col_name,dataIndex:"salesrep_name",flex:1},
            {header:labels_json.salesreppanel.col_phone,dataIndex:"salesrep_phone",width:150},
            {header:labels_json.salesreppanel.col_mobile,dataIndex:"salesrep_mobile",width:150},
            {header:labels_json.salesreppanel.col_address,dataIndex:"salesrep_address",flex:2},
            {header:labels_json.salesreppanel.col_active,dataIndex:"salesrep_status",width:100,renderer:function(val,meta,record){
                    return (val=="1")? labels_json.salesreppanel.text_yes:""
            }}            
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.salesreppanel.button_new,
             iconCls: 'new',
             tooltip:labels_json.salesreppanel.tooltip_new,
             listeners:{
                 click:function(){
                      winMode =0;
                      salesrep_form.setTitle(labels_json.salesreppanel.label_createrep);
                      salesrep_form.show();
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.salesreppanel.button_edit,
             iconCls: 'copy',
             id:'editSaleRepBtn',
             disabled:true,
             tooltip:labels_json.salesreppanel.tooltip_edit,
             listeners:{
                 click:function(){
                     winMode =1;
                     salesrep_form.setTitle(labels_json.salesreppanel.label_editrep);
                     salesrep_form.show();
                      
                 }
             }
           }
           
           ,
           { xtype: 'button', 
             text: labels_json.salesreppanel.button_deactivate,
             id:'deactSaleRepBtn',
             tooltip:labels_json.salesreppanel.tooltip_deactivate,
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Deactivate',action_urls.deactivate_salesrep,Ext.getCmp("salesrep-panel-grid"),function(data){
                         salesrep_store.loadData(data.data); 
                     });
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.salesreppanel.button_close,
             tooltip:labels_json.salesreppanel.tooltip_close,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})