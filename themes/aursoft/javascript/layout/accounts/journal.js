_journal={
    id: 'journal-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:"Account Journal",
    
    listeners:{
        beforeclose:function(){
           homePage();           
        }
        ,
        afterrender:function (){
                                                                   
        
        },
        beforerender:function(){
          reports_obj = {                 
                getDateMysqlFormatWithTime: function (objDate){                    
                    var currentdate =  objDate;
                    var cdate = "";
                    if(objDate){
                        var cdate = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+"-"+currentdate.getDate()+' '+currentdate.getHours()+':'+currentdate.getMinutes()+':'+currentdate.getSeconds();
                    }
                    return cdate;
                },
                editEntry:function(){
                    var grid = Ext.getCmp("journal-panel-grid");
                    var selectedRow = grid.selModel.getSelection()[0];
                    var secondRow = null;
                    secondRow = grid.store.getById((parseInt(selectedRow.get("id"))+1).toString());
                    if(!secondRow  || selectedRow.get("ref_id")!=secondRow.get("ref_id")){
                       secondRow = grid.store.getById((parseInt(selectedRow.get("id"))-1).toString());
                    }
                    Ext.getCmp("j_date").setValue(reports_obj.jsDate(selectedRow.get("date")));
                    Ext.getCmp("j_description").setValue(selectedRow.get("details"))
                    
                    reports_obj.setEntries(selectedRow);
                    reports_obj.setEntries(secondRow);  
                },
                setEntries:function(model){                                        
                    if(model.get("credit")==""){
                        var d_amount = model.get("debit");
                        Ext.getCmp("j_debit_amount").setValue(d_amount)
                        Ext.getCmp("acc_debit_id").setValue(model.get("acc_id"))
                        Ext.getCmp("debit_entry_id").setValue(model.get("r_id"))
                    }
                    else{
                        var c_amount = model.get("credit");
                        Ext.getCmp("j_credit_amount").setValue(c_amount)
                        Ext.getCmp("acc_credit_id").setValue(model.get("acc_id"));
                        Ext.getCmp("credit_entry_id").setValue(model.get("r_id"))
                    }
                },
                jsDate:function (strDate){
                    var dateArray = strDate.split("/");
                    var dateObj = new Date(dateArray[2],parseInt(dateArray[1])-1,dateArray[0]);
                    return dateObj;
                },
                deleteEntry:function(){
                     Ext.Msg.show({
                        title:'Delete',
                        msg: 'Are you really want to delete entry?',
                        buttons: Ext.Msg.YESNOCANCEL,
                        icon: Ext.Msg.QUESTION,
                        fn:function(btn,text){
                            if(btn=='yes'){
                                Ext.Ajax.request({
                                    url: action_urls.delete_journal_entry,
                                    method : 'POST',
                                    params:{_ids:getSelection(Ext.getCmp("journal-panel-grid"))},
                                    success: function (response) {

                                        var data = Ext.JSON.decode(response.responseText);
                                        if(data.message==="success"){
                                           Ext.getCmp("journal-panel-grid").store.load({
                                                 params:{
                                                     start_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_start_date").getValue()),
                                                     end_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_end_date").getValue())
                                                 }
                                             });                                 
                                             Ext.getCmp("edit_journal_btn").setDisabled(false);
                                             Ext.getCmp("delete_journal_btn").setDisabled(false);
                                        }
                                    },
                                    failure: function () {}
                                });
                            }
                        }
                   });
                    
                }
             };  
        }
    },
    defaults:{
        border:false
    },
    items: [{
                         region:'north',
                         height:100,                         
                         layout:'fit',
                         items: new Ext.FormPanel({
                                id:'journal-form',
                                layout:'column',
                                defaults: {
                                   layout: 'anchor',
                                   defaults: {
                                       anchor: '100%'
                                   }
                                },
                                items:[{
                                   columnWidth: 1/2,
                                   baseCls:'x-plain',
                                   padding:10,
                                   defaults:{
                                       layout: {
                                           type: 'hbox',
                                           defaultMargins: {top: 0, right: 5, bottom: 0, left: 0}
                                       }
                                   },
                                   items:[
                                     {
                                           xtype : 'fieldcontainer',
                                           combineErrors: true,
                                           msgTarget: 'side',
                                           id:'j_debit_field',
                                           fieldLabel: 'Date',
                                           defaults: {
                                               hideLabel: true
                                           },
                                           items : [
                                               {
                                                   xtype:'datefield',
                                                   fieldLabel:'Date',
                                                   name:'j_date',
                                                   id:'j_date',
                                                   flex:1,
                                                   value: new Date(),
                                                   maxValue: new Date(),
                                                   format: 'd-m-Y',
                                                   listeners:{
                                                        change:function(){


                                                        }
                                                    }  
                                                },
                                               {
                                                   xtype:'combo',
                                                   fieldLabel:'Debit Account',
                                                   displayField: 'acc_name',
                                                   id:'acc_debit_id',                                            
                                                   store: debit_store,
                                                   anyMatch: true,
                                                   emptyText: 'Select Debit Account',
                                                   queryMode: 'local',
                                                   forceSelection: true,
                                                   flex : 1,
                                                   valueField:'id',                                            
                                                   allowBlank: false,
                                                   editable:true,
                                                   typeAhead: true,
                                                   listeners:{
                                                        specialkey: function(box, event){
                                                            if (event.getKey() == event.ENTER) {
                                                                this.replace_Credit_Item(this.getValue());
                                                            }
                                                        },
                                                        select: function(){
                                                            this.replace_Credit_Item(this.getValue());
                                                        }
                                                        
                                                    }, 
                                                    replace_Credit_Item(value){
                                                        credit_store.loadData(store_data);
                                                        credit_store.insert(0,{"id":"-2","acc_name":"Add New..."});
                                                        if((this.getValue())==-2){
                                                            account_selected_combo = this.getId();
                                                            this.setValue(null);
                                                            winMode =0;
                                                            account_form.show();
                                                            return true;
                                                        }
                                                        credit_store.removeAt(credit_store.find('id', value));
                                                    }
                                                },
                                               {
                                                   xtype: 'textfield',
                                                   flex : 1,
                                                   emptyText: 'Debit Amount',
                                                   name : 'debit_amount',
                                                   id : 'j_debit_amount',
                                                   fieldLabel: 'Debit',
                                                   maskRe: /([0-9\s\.]+)$/,
                                                   regex: /[0-9]/,
                                                   allowBlank: false
                                               },
                                               {
                                                xtype:'hidden',                                                
                                                id:'debit_entry_id',
                                                value:'0'
                                               }
                                           ]
                                     },
                                     {
                                           xtype : 'fieldcontainer',
                                           combineErrors: true,
                                           msgTarget: 'side',
                                           id:'j_credit_field',
                                           fieldLabel: 'Description',
                                           defaults: {
                                               hideLabel: true
                                           },
                                           items : [
                                               {
                                                   xtype: 'textfield',
                                                   flex : 1,
                                                   id : 'j_description',                                            
                                                   emptyText:'Description',
                                                   fieldLabel: 'descrption'
                                               },
                                               {
                                                   xtype:'combo',
                                                   fieldLabel:'Credit Account',
                                                   displayField: 'acc_name',
                                                   id:'acc_credit_id',                                            
                                                   store: credit_store,
                                                   emptyText: 'Select Credit Account',
                                                   queryMode: 'local',
                                                   forceSelection: true,
                                                   anyMatch: true,
                                                   flex : 1,
                                                   valueField:'id',                                            
                                                   allowBlank: false,
                                                   editable:true,
                                                   typeAhead: true,
                                                   enableKeyEvents: true,
                                                   listeners:{
                                                        specialkey: function(box, event){
                                                            if (event.getKey() == event.ENTER ) {
                                                                this.replace_Debit_Item(this.getValue());
                                                            }
                                                        },
                                                        select: function(){
                                                            this.replace_Debit_Item(this.getValue());
                                                        },
                                                        
                                                    } ,
                                                    replace_Debit_Item: function(value){
                                                        debit_store.loadData(store_data);
                                                        debit_store.insert(0,{"id":"-2","acc_name":"Add New..."});
                                                        if((this.getValue())==-2){
                                                                account_selected_combo = this.getId();
                                                                this.setValue(null);
                                                                winMode =0;
                                                                account_form.show();
                                                                return true;
                                                        }
                                                        debit_store.removeAt(debit_store.find('id', value));
                                                    },
                                                    
                                                },
                                                
                                               {
                                                   xtype: 'textfield',
                                                   flex : 1,
                                                   emptyText: 'Credit Amount',
                                                   id : 'j_credit_amount',
                                                   fieldLabel: 'Credit Amount',
                                                   allowBlank: false,
                                                   maskRe: /([0-9\s\.]+)$/,
                                                   regex: /[0-9]/
                                               }
                                               ,
                                               {
                                                xtype:'hidden',                                                
                                                id:'credit_entry_id',
                                                value:'0'
                                               }
                                           ],
                                       },
                                       {
                                       layout:{
                                           type: 'table',
                                           columns:1,
                                           tableAttrs:{
                                             width:'85px'  ,
                                             align:'right'
                                           }
                                       },
                                       border:false,
                                       bodyBorder:false,                                       
                                       margin:'0 0 0 -4',                                                                
                                           items:[{
                                                xtype:'button',
                                                text:'Save',
                                                iconCls:'save',
                                                id:'save_j',                                         
                                                width:80,
                                                listeners:{
                                                    click:function(){
                                                        if (Ext.getCmp("journal-form").getForm().isValid()) {
                                                            if(Ext.getCmp("j_credit_amount").getValue() == Ext.getCmp("j_debit_amount").getValue()){
                                                                if(Ext.getCmp("j_debit_amount").getValue() > 0){
                                                                    Ext.Ajax.request({
                                                                       url: action_urls.save_journal_entry,
                                                                       method : 'POST',
                                                                       params:{
                                                                               debit_entry_id:0,
                                                                               entry_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_date").getValue()),
                                                                               acc_0 : Ext.getCmp("acc_debit_id").getValue(),
                                                                               debit_amount : Ext.getCmp("j_debit_amount").getValue(),
                                                                               desc : Ext.getCmp("j_description").getValue(),
                                                                               acc_1 : Ext.getCmp("acc_credit_id").getValue(),
                                                                               credit_amount : Ext.getCmp("j_credit_amount").getValue(),
                                                                               debit_entry_id: Ext.getCmp("debit_entry_id").getValue(),
                                                                               credit_entry_id: Ext.getCmp("credit_entry_id").getValue()    

                                                                           },
                                                                       success: function (response) {

                                                                           var data = Ext.JSON.decode(response.responseText);
                                                                           if(data.message==="success"){
                                                                              Ext.getCmp("journal-panel-grid").store.load({
                                                                                    params:{
                                                                                        start_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_start_date").getValue()),
                                                                                        end_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_end_date").getValue())
                                                                                    }
                                                                                }); 
                                                                               Ext.getCmp("edit_journal_btn").setDisabled(false);
                                                                               Ext.getCmp("delete_journal_btn").setDisabled(false); 
                                                                               Ext.getCmp("journal-form").getForm().reset(); 
                                                                           }
                                                                       },
                                                                       failure: function () {}
                                                                   });
                                                               }
                                                            }
                                                       }
                                                    }
                                                }
                                           }
                                      ]


                                   }
                                   ]
                                },
                                {
                                   columnWidth: 1/2,
                                   baseCls:'x-plain',
                                   margin:'5 6 0 0',
                                   height:157,
                                   layout: {
                                       type: 'table',
                                       columns: 1,
                                        tableAttrs: {
                                           width:'230px',
                                           style:'float:right'
                                       }
                                   },
                                   items:[{
                                           xtype: 'fieldset',
                                           collapsible: false,
                                           padding:'5 5 0 5',
                                           defaults:{labelWidth:60},                                                                     
                                           items:[
                                           {
                                              xtype:'datefield',
                                              fieldLabel:'From Date',                                       
                                              id:'j_start_date',
                                              value: new Date(),              
                                              maxValue: new Date(),
                                              format: 'd-m-Y',
                                              listeners:{
                                                   change:function(){                                                

                                                   }
                                               }  
                                           },
                                           {
                                              xtype:'datefield',
                                              fieldLabel:'End Date',                                       
                                              id:'j_end_date',
                                              value: new Date(),    
                                              maxValue: new Date(),
                                              format: 'd-m-Y',
                                              listeners:{
                                                   change:function(){


                                                   }
                                               }  
                                           },
                                           {
                                                   xtype:'button',
                                                   text:'Search',
                                                   style:'float:left;margin-left:63px;margin-bottom:5px;',
                                                   width:80,
                                                   listeners:{
                                                       click:function(){
                                                           Ext.getCmp("journal-panel-grid").store.load({
                                                               params:{
                                                                   start_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_start_date").getValue()),
                                                                   end_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("j_end_date").getValue())
                                                               }
                                                           });
                                                       }
                                                   }
                                              }

                                          ]
                                     }


                                   ]
                                }
                              ]
                         })
                    },
    {
     region:'center',
     layout:'fit',
     items:[{
            xtype:"gridpanel",
            id:"journal-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url:action_urls.get_journal,
                    reader:{
                        type:"json",
                        root: 'journal',
                        idProperty: 'register_id'
                    }
            },
            model:Ext.define("JournalModel", {
                extend:"Ext.data.Model",
                fields:[
                    "register_id",
                    "ref_id",
                    "acc_id",
                    "account",
                    "details",
                    "invoice_id",
                    "date",
                    "debit",
                    "credit",
                    "r_id",
                    "acc_type",
                    ]
            }) && "JournalModel"
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
                            if((selections[0].data.details) == ''){
                                Ext.getCmp("edit_journal_btn").setDisabled(false);
                                Ext.getCmp("delete_journal_btn").setDisabled(false);
                            }
                            else{
                                Ext.getCmp("edit_journal_btn").setDisabled(true);
                                Ext.getCmp("delete_journal_btn").setDisabled(false);
                            }
                        }
                        else if(selections.length>1){
                            Ext.getCmp("edit_journal_btn").setDisabled(true);
                            for(var i=0;i<selections.length;i++){
                                if((selections[i].data.details) == ''){
                                    Ext.getCmp("delete_journal_btn").setDisabled(false);
                                }
                                else{
                                    Ext.getCmp("delete_journal_btn").setDisabled(false);
                                    break;
                                }
                            }
                        }
                        else{
                            Ext.getCmp("edit_journal_btn").setDisabled(true);
                            Ext.getCmp("delete_journal_btn").setDisabled(true);
                        }
                    }
                }
          }),
          columnLines: true,
          columns:[
                {text: "Register", width:100, sortable: true, dataIndex: 'register_id'},
                {text: "Account Name",width:140, sortable: false, dataIndex: 'account'},
                {text: "Invoice#",width:120, sortable:false, dataIndex: 'invoice_id'},
                {text: "Debit", width: 100, sortable: false, dataIndex: 'debit',renderer: Ext.util.Format.numberRenderer('0.00'),tdCls:'debit_color'},
                {text: "Credit", width: 100, sortable: false, dataIndex: 'credit',renderer: Ext.util.Format.numberRenderer('0.00'),tdCls:'credit_color'},            
                {text: "Description",flex:1, sortable: false, dataIndex: 'details'},                
                {text: "Date", width: 90, sortable: false, dataIndex: 'date'}
                
            ]
          }]
    }
  ]
  
  ,
    tbar: [
           { xtype: 'button', 
             text: 'New',
             iconCls: 'new',
             tooltip:'Create a new entry.',
             listeners:{
                 click:function(){
                     if(user_right==1 || user_right==3 ){
                        Ext.getCmp("journal-form").getForm().reset(); 
                     } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.journal.actions.create){ 
                           Ext.getCmp("journal-form").getForm().reset(); 
                       }else{
                           Ext.Msg.show({
                               title:'User Access Conformation',
                               msg:'You have no access to Create New Entry',
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
           '-',
           { xtype: 'button', 
             text: 'Journal Report',
             iconCls: 'new',
             tooltip:'Create a Journal entry.',
             listeners:{
                 click:function(){
                      winMode =0;
                      getPanel(json_urls.accounts_journal_View,'journal-view-panel');

                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: 'Edit',
             iconCls: 'edit',
             disabled:true,
             id : 'edit_journal_btn',
             tooltip:'Edit selected journal entry.',
             listeners:{
                 click:function(){
                     if(user_right==1 || user_right==3 ){
                        reports_obj.editEntry(); 
                     } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.journal.actions.edit){ 
                           reports_obj.editEntry(); 
                       }else{
                           Ext.Msg.show({
                               title:'User Access Conformation',
                               msg:'You have no access to Create New Entry',
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
           },
           { xtype: 'button', 
             text: 'Delete',
             id : 'delete_journal_btn',
             iconCls: 'delete',
             disabled:true,             
             tooltip:'Delete selected journal entry.',
             listeners:{
                 click:function(){
                      reports_obj.deleteEntry();
                 }
             }
           },
           '-',
           { xtype: 'button', 
             text: 'Close',
             tooltip:'Close Journal.',
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
}
