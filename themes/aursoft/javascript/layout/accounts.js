_account={
    id: 'accounts-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.accountspanel.text_title,
    listeners:{
        beforeclose:function(){
           homePage();
        }
        ,
        afterrender:function (){
           
            typeStore.load();
            typeStore2 = new Ext.data.JsonStore({
                 proxy:{
                    type:"ajax",
                    url: action_urls.get_account_types,
                    extraParams:{flag:'all'},
                    reader:{
                        type:"json",
                        root: 'types',
                        idProperty: 'id'
                    }
                },
                model:typeModel
            });
           
               
               editModel =  Ext.create('Ext.grid.plugin.RowEditing',{
                   listeners:{
                      
                        'edit': function(e) {                       
                            var type_name = Ext.getCmp("edit_name_type").getValue();
                            var type_status= Ext.util.Format.lowercase(Ext.getCmp("edit_status_type").getValue());
                            var type_head= Ext.getCmp("edit_account_head").getValue();
                            type_status = type_status=="enabled" ? 1:0;                            
                            if(type_name!=""){
                             var sm = Ext.getCmp("types_grid").getSelectionModel();   
                             var id = sm.getSelection()[0].get('id');

                                 Ext.Ajax.request({
                                    url: action_urls.saveupdate_types,
                                    params:{
                                        id:id,
                                        name:type_name,
                                        status:type_status,
                                        head : type_head
                                    },
                                    success: function (response) {
                                        Ext.getCmp("types_grid").store.load();
                                    },
                                    failure: function () {}
                                });
                                
                           }
                        },
                       'canceledit':function(e){
                           if(Ext.getCmp("edit_name_type").getValue()==""){
                               var sm = e.grid.getSelectionModel();
                                typeStore2.remove(sm.getSelection());
                                if (typeStore2.getCount() > 0) {
                                    sm.select(0);
                                }
                           }
                       },
                       'beforeedit':function(e){
                           editModel.cancelEdit();
                           if(parseInt(e.record.get("type_type"))===1){
                                return false;
                           }
                       }
                   }
               });
               account_type_management= Ext.widget('window', {
                    title: 'Account Types Management',
                    width: 600,
                    height: 400,
                    minHeight: 400,
                    closeAction:'hide',
                    modal: true,
                    layout: 'fit',
                    iconCls: 'types',
                    listeners:{
                        show:function(){
                            typeStore2.load();
                        }
                    },
                    resizable: true,
                    items:Ext.create('Ext.grid.Panel', {
                        plugins: [editModel],
                        id:'types_grid',
                        listeners:{
                            afterrender:function(cmp){
                                cmp.getSelectionModel().on('selectionchange', function(selModel, selections){
                                    if(selections.length === 1 && parseInt(selections[0].get('type_type'))!==1){
                                     Ext.getCmp('delete_types').setDisabled(false);
                                    }
                                    else{
                                        Ext.getCmp('delete_types').setDisabled(true);
                                    }
                                });
                            }
                        },
                        store:typeStore2,
                        columns: [ {
                            text: 'Type Name',
                            flex: 1,
                            sortable: true,
                            dataIndex: 'type',
                            allowBlank: false,
                            field: {
                                xtype: 'textfield',
                                id:"edit_name_type"
                            }
                        }, {
                            text: 'Type',
                            width: 120,
                            sortable: true,
                            dataIndex: 'type_type_text',
                          
                        },{
                            header: 'Head',
                            width: 120,
                            sortable: true,
                            dataIndex: 'head_id',
                            renderer: function(v, m, rec, row, c, s, gv){
                                return (v)?account_head_store.getById(v).get("head_title"):"1";
                            },
                            field: {
                                xtype: 'combobox',
                                typeAhead: true,
                                editable:false,
                                triggerAction: 'all',
                                selectOnTab: true,
                                displayField:'head_title',
                                id:"edit_account_head",
                                valueField:'id',
                                allowBlank: false,
                                store:account_head_store
                            }
                        },
                        {
                            header: 'Status',
                            width: 120,
                            sortable: true,
                            dataIndex: 'status',
                            field: {
                                xtype: 'combobox',
                                typeAhead: true,
                                editable:false,
                                triggerAction: 'all',
                                selectOnTab: true,
                                displayField:'name',
                                id:"edit_status_type",
                                valueField:'id',
                                  store:{
                                        proxy:{
                                            type:"memory",
                                            reader:{
                                                type:"json"
                                            }
                                    },
                                    model:Ext.define("temp", {
                                        extend:"Ext.data.Model",
                                        fields:[
                                            "id",
                                            "name"
                                            ]
                                    }) && "temp",
                                    data:[{id:'1',name:'Enabled'},{id:'0',name:'Disabled'}]
                                  }
                            }
                        }
                        
                        ],
                        dockedItems: [{
                            xtype: 'toolbar',
                            items: [{
                                text: 'Add Type',
                                iconCls: 'new',
                                tooltip:'Add new account type.',
                                handler: function(){
                                    editModel.cancelEdit();
                                     var r = Ext.create('accountTypeModel', {
                                        type: '',
                                        status: 'Enabled',
                                        status_id:'1',
                                        type_type:0,
                                        type_type_text:'User Defined'
                                    });
                                    typeStore2.insert(0, r);
                                    editModel.startEdit(0, 0);
                                }
                            }, '-', {
                                id:'delete_types',
                                text: 'Delete',
                                iconCls: 'delete',
                                tooltip:'Delete selected account type.',
                                disabled: true,
                                handler: function(){
                                    editModel.cancelEdit();
                                    var sm = Ext.getCmp("types_grid").getSelectionModel();
                                    
                                    if (sm.getSelection().length==1) {
                                        Ext.Ajax.request({
                                            url: action_urls.delete_type,
                                            params:{
                                                id:sm.getSelection()[0].get("id")
                                            },
                                            success: function (response) {
                                                typeStore2.load();
                                            },
                                            failure: function () {}
                                        });
                                    }
                                }
                            }]
                        }]
                    })
                        
               });
               
        
        }
    },
    defaults:{
        border:false
    },
    items: [{
     region:'north',
     height:100,
     layout:'fit',
     items:[{
            xtype: 'fieldset',
            title: labels_json.accountspanel.text_search_account,
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
                   fieldLabel:labels_json.accountspanel.text_account_name,
                   id:'acct_name_search'
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
                                         Ext.getCmp("accounts-panel-grid").store.load();
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
                                     Ext.getCmp("accounts-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("acct_name_search").getValue()
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
            id:"accounts-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_accounts,
                    reader:{
                        type:"json",
                        root: 'accounts',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("AccountModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "acc_name",
                    "acc_type",
                    "acc_desc",
                    "acc_balance",
                    "acc_status",
                    "acc_type_id",
                    "acc_status_id"
                    ]
            }) && "AccountModel",
            autoLoad:true,
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
            {header:"Name",dataIndex:"acc_name",flex:1},
            {header:"Type",dataIndex:"acc_type",width:120},
            {header:"Status",dataIndex:"acc_status",width:120},
            {header:"Opening Balance",dataIndex:"acc_balance",width:120}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.accountspanel.text_new,
             iconCls: 'new',
             tooltip:labels_json.accountspanel.text_new_info,
             listeners:{
                 click:function(){
                     if(user_right==1 || user_right==3 ){
                        winMode =0;
                        account_form.setTitle(labels_json.accountspanel.text_new_info);
                        account_form.show();
                     } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.account_management.actions.create){ 
                           winMode =0;
                           account_form.setTitle(labels_json.accountspanel.text_new_info);
                           account_form.show();
                       }else{
                           Ext.Msg.show({
                               title:'User Access Conformation',
                               msg:'You have no access to Create New Account',
                               buttons:Ext.Msg.OK,
                               callback:function(btn) {
                                   if('ok' === btn) {
                                   }
                               }
                           });
                       }
                   }
                 }
             }
           }
           ,'-',
           { xtype: 'button', 
             text: labels_json.accountspanel.text_account_type,
             iconCls: 'types',
             hidden:true,
             tooltip:'Manage account types. You can add, delete and edit account types.',
             listeners:{
                 click:function(){
                     account_type_management.show();
                 }
             }      
           },           
           { xtype: 'button', 
             text:  labels_json.accountspanel.text_edit,
             iconCls: 'copy',
             id:'editAccountBtn',
             disabled:true,
             tooltip:labels_json.accountspanel.text_edit_info,
             listeners:{
                 click:function(){
                     if(user_right==1 || user_right==3 ){
                        winMode =1;
                        account_form.setTitle('Edit/Update Account');
                         account_form.show();
                     } else {
                            if(Ext.decode(decodeHTML(userAccessJSON)).user_access.account_management.actions.edit){ 
                               winMode =1;
                               account_form.setTitle('Edit/Update Account');
                                account_form.show();
                           }else{
                               Ext.Msg.show({
                                   title:'User Access Conformation',
                                   msg:'You have no access to Edit Account',
                                   buttons:Ext.Msg.OK,
                                   callback:function(btn) {
                                       if('ok' === btn) {
                                       }
                                   }
                               });
                           }
                       }
                      
                 }
             }
           }
           ,
           { xtype: 'button', 
             text: 'Deactivate',
             style:'display:none',
             id:'deactAccountBtn',
             tooltip:'Deactivate this account so that it will not <br/> be shown in other screens such as Sales <br/> order. Deactivated products can be <br/> reactivated again in future.',
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Deactivate',action_urls.deactivate_account,Ext.getCmp("accounts-panel-grid"));
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.accountspanel.text_close,
             tooltip:labels_json.accountspanel.text_close_info,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
}
