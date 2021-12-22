({
    id: 'expenses-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:labels_json.expensespanel.text_expense,
    listeners:{
        beforeclose:function(){
           homePage();
        }
        ,
        afterrender:function (){      
            
        },
        show:function(){
            /*Pay window*/
            if(expense_create_form==null){
             expense_create_form = Ext.widget('window', {
                title: 'Create Expense',
                width: 450,
                height: 160,
                minHeight: 160,
                closeAction:'hide',
                layout: 'fit',
                id:'expense_create_window',
                resizable: true,
                modal: true,
                listeners:{
                    show:function(){
                        var me = this.down('form').getForm();              
                        me.reset();
                        me.findField("acc_name").focus(true,100);  
                        if(winMode && winMode>0){
                            var selectionModel = Ext.getCmp("expense-panel-grid").selModel.getSelection()[0];                                                                                                     
                            me.findField("acc_name").setValue(selectionModel.get('expense_name'));
                            me.findField("acc_description").setValue(selectionModel.get('expense_description'));
                            me.findField("account_id").setValue(selectionModel.get('id'));
                            me.findField('acc_status').setValue(selectionModel.get('expense_status'));
                        }
                    },
                    afterrender: function(){
                        var map_expenses_window = new Ext.util.KeyMap("expense_create_window", [
                        {
                            key: [10,13],
                            fn: function(){ Ext.getCmp("expense_win_button").fireHandler();}
                        }
                    ]);  
                    }
                },
                items: Ext.widget('form', {
                    layout: 'anchor',
                    border: false,
                    bodyPadding: 10,
                    defaults: {
                        border:false,
                        anchor: '100%'
                    },
                    items: [
                    {
                        fieldLabel:labels_json.expensespanel.text_name,                        
                        xtype:'textfield',                                             
                        id:'expense_name',
                        name:'acc_name',
                        value:'',
                        emptyText:labels_json.expensespanel.text_name_placeholder
                    }, {
                        xtype: 'textfield',
                        fieldLabel: labels_json.expensespanel.text_description,
                        name:'acc_description'
                    },
                    {
                        xtype:'hidden',
                        name:'account_id',
                        id:'expense_id',
                        value:'0'
                    },
                    {
                        xtype:'hidden',
                        name:'acc_type_id',
                        id:'expense_type_id',
                        value:'5'
                    },
                    {
                        xtype:'hidden',
                        name:'acc_obalance',
                        id:'expense_balance_id',
                        value:'0'
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: labels_json.expensespanel.text_expstatus,
                        value:'1',
                        queryMode: 'local',
                        displayField: 'type',
                        valueField:'id',
                        name:'acc_status',
                        editable:false,
                        queryMode: 'local',
                        store:{
                            proxy:{
                                type:"memory",
                                reader:{
                                    type:"json"
                                }
                        },
                        model:Ext.define("accountStatusModel", {
                            extend:"Ext.data.Model",
                            fields:[
                                "id",
                                "type"
                                ]
                        }) && "accountStatusModel",
                         data:[{id:'1',type:'Enabled'},{id:'0',type:'Disabled'}
                         ]}
                    }
                    ],

                    buttons: [{
                        text: 'Save',
                        id:'expense_win_button',
                        handler: function() {
                            var me = this.up('form').getForm();
                            if (me.isValid()) {
                                var _url = action_urls.saveupdate_account;                                
                                if(_url){
                                    LoadingMask.showMessage('Please wait..');
                                    this.up('form').getForm().submit({
                                        clientValidation: true,
                                        url: _url,
                                        params: {
                                            
                                        },
                                        success: function(form, action) {
                                            LoadingMask.hideMessage();                                                                     
                                            if(action.result.success){
                                               expense_create_form.hide();                                                 
                                                Ext.getCmp("expense-panel-grid").store.load({
                                                    params:{                                                                                                            
                                                    }
                                                });                                                                       
                                            }
                                            else{
                                                Ext.Msg.show({
                                                    title:'Failure',
                                                    msg: 'Ooops some thing went wrong. Please try again.',
                                                    buttons: Ext.Msg.OK,
                                                    icon: Ext.Msg.ERROR
                                                });
                                            }
                                        },
                                        failure: function(form, action) {
                                            LoadingMask.hideMessage();
                                            failureMessages(form, action);
                                        }
                                    });
                                }   
                            }
                        }
                    },{
                        text: 'Cancel',
                        handler: function() {
                            this.up('form').getForm().reset();
                            this.up('window').hide();
                        }
                    }]
                })
            });  
           } 
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
            title: 'Search Expense',
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
                   fieldLabel:'Expense Name',
                   id:'expense_name_search'
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
                                 text:'Show All',
                                 style:'float:right;',
                                 width:80,
                                 listeners:{
                                     click:function(){
                                         Ext.getCmp("expense-panel-grid").store.load();
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
                                     Ext.getCmp("expense-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("expense_name_search").getValue()
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
            id:"expense-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_expenses,
                    reader:{
                        type:"json",
                        root: 'expenses',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("ExpenseModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "expense_name",                                        
                    "expense_status",
                    "expense_description"
                    ]
            }) && "ExpenseModel",
            autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {                
                             
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
                            Ext.getCmp("editAccountBtn_expense").setDisabled(false);
                            Ext.getCmp("deactAccountBtn_expense").setDisabled(false);
                        }
                        else if(selections.length>1){
                            Ext.getCmp("editAccountBtn_expense").setDisabled(true);
                            Ext.getCmp("deactAccountBtn_expense").setDisabled(false);
                        }
                        else{
                            Ext.getCmp("editAccountBtn_expense").setDisabled(true);
                            Ext.getCmp("deactAccountBtn_expense").setDisabled(true);
                        }
                    }
                }
          }),
          columnLines: true,
          columns:[            
            {header:"Expense Name",dataIndex:"expense_name",flex:1},
            {header:"Status",dataIndex:"expense_status",width:120,renderer:function(val,meta,record){
                    return (val=="1")? 'Enabled':"Disabled"
            }}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: labels_json.expensespanel.text_new,
             iconCls: 'new',
             tooltip:labels_json.expensespanel.text_new_tooltip,
             listeners:{
                 click:function(){
                     winMode =0;
                     expense_create_form.setTitle(labels_json.expensespanel.text_new_expense);
                     expense_create_form.show();
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.expensespanel.text_edit,
             iconCls: 'copy',
             id:'editAccountBtn_expense',
             disabled:true,
             tooltip:labels_json.expensespanel.text_edit_tooltip,
             listeners:{
                 click:function(){
                    winMode =1;
                    expense_create_form.setTitle(labels_json.expensespanel.text_edit_model);
                    expense_create_form.show();
                      
                 }
             }
           }
           ,
           { xtype: 'button', 
             text: labels_json.expensespanel.text_deactive,
             id:'deactAccountBtn_expense',
             tooltip:labels_json.expensespanel.text_deactive_detail,
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Deactivate',action_urls.deactivate_account,Ext.getCmp("expense-panel-grid"));
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: labels_json.expensespanel.text_close,
             tooltip:labels_json.expensespanel.text_close_info,
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})