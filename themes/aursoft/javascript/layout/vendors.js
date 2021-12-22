({
    id: 'vendor-panel',
    layout: 'border',
    closable:true,
    frame:true,
    title:labels_json.vendorpanel.text_vendor,
    closeAction:'hide',
    listeners:{
        beforeclose:function(){
           homePage();
        },
        show:function(){
            Ext.getCmp("vendor_panel_tab").setActiveTab(0);
            OBJ_Action.afterFailAciton=function(){
              Ext.getCmp("_vendor_name").markInvalid('Vendor already exists with same name.')  ;
            };
            OBJ_Action.changeStatus=function(act_deactive,data){
                var btn_activate = Ext.getCmp("vendor_btn_activate");
                if(act_deactive==1){
                    btn_activate.setIconCls('deactivate');
                    btn_activate.setText(labels_json.vendorpanel.text_deactive);
                    btn_activate.setTooltip('Deactivate this vendor so that it will not <br/> be shown in other screens such as Sales <br/> order. Deactivated vendors can be <br/> reactivated again in future.');
                }
                else{
                    btn_activate.setIconCls('activate');
                    btn_activate.setText(labels_json.vendorpanel.text_active);
                    btn_activate.setTooltip('Activate this vendor so that it will  <br/> be shown in other screens such as Purchase <br/> order.');
                }
                if(data){
                    vendor_store.loadData(data.vendors);
                }
            }
            OBJ_Action.changeStatus(1);
            OBJ_Action.myfunc=function(_id,data){
               var save_id=Ext.getCmp("_vendor_save").getValue();
                Ext.getCmp("vendor_hidden_id").setValue(_id);
                 if(save_id==1)
                  {
                    Ext.getCmp("_vendor_obalance").setDisabled(false);
                  }
                if(vendor_store && data){
                    vendor_store.loadData(data.vendors);
                    account_store.loadData(data.accounts.accounts);
                }                 
            }
            OBJ_Action.onNew=function(){
                 Ext.defer(function(){
                    Ext.getCmp("_vendor_name").focus();                

                },50)
                Ext.getCmp("_vendor_obalance").setDisabled(false);
            }
            OBJ_Action.editme=function(){
               
                if(editItem.id>0){
                 
                    Ext.getCmp("_vendor_obalance").setDisabled(false);
                  
                    
                    LoadingMask.showMessage('Loading...');
                    Ext.Ajax.request({
                        
                        url: action_urls.get_vendor_record,
                        params:{
                            vendor_id:editItem.id
                        },
                        method:'GET',
                        success: function (response) {

                         jObj = Ext.decode( response.responseText );
                         Ext.getCmp("vendor_hidden_id").setValue(jObj.vendor_id);
                         Ext.getCmp("_vendor_name").setValue(decodeHTML(jObj.vendor_name));
                         Ext.getCmp("_vendor_obalance").setValue(jObj.vendor_obalance);
                         Ext.getCmp("_current_obalance").setValue(jObj.vendor_balance);
                         Ext.getCmp("_vendor_contact").setValue(jObj.vendor_contact);
                         Ext.getCmp("_vendor_acc_id").setValue(jObj.vendor_acc_id);
                         Ext.getCmp("_vendor_phone").setValue(jObj.vendor_phone);
                         Ext.getCmp("_vendor_mobile").setValue(jObj.vendor_mobile);
                         Ext.getCmp("_vendor_fax").setValue(jObj.vendor_fax);
                         Ext.getCmp("_vendor_address").setValue(jObj.vendor_address);
                         Ext.getCmp("_vendor_email").setValue(jObj.vendor_email);
                         OBJ_Action.changeStatus(jObj.vendor_status);
                         editItem.id = '0';
                         OBJ_Action.resetChanges();
                         LoadingMask.hideMessage();
                        },
                        failure: function () {
                             LoadingMask.hideMessage();
                        }
                   });
                }
                else{
                    Ext.getCmp("_vendor_obalance").setDisabled(false);
                }
            }
            OBJ_Action.editme();
            Ext.defer(function(){
                Ext.getCmp("_vendor_name").focus();                

            },50)
        }//End of Show
    },
    items: [{
        region: 'west',
        width: 250,
        title:labels_json.vendorpanel.text_search,
        split: true,
        collapsible: true,
        collapsed:true,
        id:'vendor_grid_leftbar',
        layout:'border',
        listeners:{
          expand:function()  {
              var jstore = Ext.getCmp("vendor_grid_search").store;
              jstore.load();
              Ext.defer(function(){Ext.getCmp("vendor_name_search").focus(true)},200); 
                var map_register = new Ext.util.KeyMap("vendor_grid_leftbar", [
               {
                   key: [10,13],
                   fn: function(){ Ext.getCmp("vendor_search_btn").fireHandler();}
                   }
               ]);
          }
        },
        items:[{
            region:'north',
            layout:'anchor',
            height:125,
            defaults: {
                anchor: '100%',
                margin:'5'
            },
            items:[{
               xtype:'textfield',
               fieldLabel:labels_json.vendorpanel.text_vendor_name,
               labelWidth:60,
               id:'vendor_name_search'
            },
            {
               xtype:'textfield',
               fieldLabel:labels_json.vendorpanel.text_contact,
               labelWidth:60,
               id:'vendor_contact_search'
            },
             {
               xtype:'textfield',
               fieldLabel:labels_json.vendorpanel.text_mobile,
               labelWidth:60,
               id:'vendor_mobile_search'
            }
            ,{
                layout:'border',
                border:false,
                bodyBorder:false,
                height:22,
                defaults:{
                    border:false
                },
                items:[{
                    region:'center',
                    items:[{
                         xtype:'button',
                         text:labels_json.vendorpanel.show_all,
                         style:'float:right',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("vendor_grid_search").store.load();
                             }
                         }
                    },{
                         xtype:'button',
                         text:labels_json.vendorpanel.text_search,
                         style:'float:right;margin-right:10px',
                         width:80,
                         id:'vendor_search_btn',
                         listeners:{
                             click:function(){
                               Ext.getCmp("vendor_grid_search").store.load({
                                   params:{search:'1',
                                   search_name:Ext.getCmp("vendor_name_search").getValue(),
                                   search_contact:Ext.getCmp("vendor_contact_search").getValue(),
                                   search_mobile:Ext.getCmp("vendor_mobile_search").getValue(),
                                  }
                               });
                             }
                         }
                    }]
                }]
                
            }
            ]
        },{
            region:'center',
            layout:'fit',
            border:false,
            bodyBorder:false,
            items:[{xtype:"gridpanel",
                    id:"vendor_grid_search",
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
                    model:Ext.define("vendorSearchModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            "vendor_name",
                            "vendor_id"
                            ]
                    }) && "vendorSearchModel"
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
                if(user_right==1){
                    editItem.id = r.get("vendor_id");
                    OBJ_Action.editme();  
                } else {
                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.newvendor.actions.edit){
                    editItem.id = r.get("vendor_id");
                    OBJ_Action.editme();
                    } else {
                    Ext.Msg.show({
                    title:'User Access Conformation',
                    msg:'You have no access to Edit',
                    buttons:Ext.Msg.OK,
                    callback:function(btn) {
                        if('ok' === btn) {}
                    }
                   });
                }
              }
            }

          },

          columnLines: true,
          columns:[
            {header:labels_json.vendorpanel.text_vendor_name,dataIndex:"vendor_name",flex:1}
            
            ]
          }]
        }]
        
    }, {
            region: 'center',
            xtype: 'tabpanel',
            id:'vendor_panel_tab',
            tabPosition:'bottom',
            items: [{
                title: labels_json.vendorpanel.text_vendor_info,
                items: new Ext.FormPanel({
                    layout:'column',
                    frame: false,
                    border:false,
                    id:'vendor-panel-form',
                    bodyBorder:false,
                    defaults: {
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        }
                    },
                    items: [{
                        columnWidth: 1/2,
                        baseCls:'x-plain',
                        bodyStyle:'padding:5px',
                        items:[{
                                xtype: 'fieldset',
                                title: labels_json.vendorpanel.text_basic,
                                cls:'fieldset_text',
                                collapsible: false,
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
                                       fieldLabel:labels_json.vendorpanel.text_vendor_name,
                                       name:'vendor_name',
                                       id:'_vendor_name',
                                       emptyText: 'Type Vendor Name here...',
                                       allowBlank: false,
                                       validation:true,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },{
                                    layout: 'hbox',
                                    flex: 1,
                                    bodyStyle: 'border:none',
                                    items: [{
                                       
                                        xtype:'textfield',
                                        flex: 1,
                                       fieldLabel:labels_json.vendorpanel.text_opening_balance,
                                       value:'0.00',
                                       name:'vendor_obalance',
                                       id:'_vendor_obalance',
                                       maskRe: /([0-9\s\.]+)$/,
                                       regex: /[0-9]/,
                                       validation:true,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    }, {
                                         
                                        xtype:'textfield',
                                        flex: 1,
                                       fieldLabel:labels_json.vendorpanel.text_current_balance,
                                       value:'0.00',
                                       readOnly: true,
                                       padding:'0 0 0 5',
                                       name:'current_obalance',
                                       id:'_current_obalance',
                                       maskRe: /([0-9\s\.]+)$/,
                                       regex: /[0-9]/,
                                       validation:true,
                                       enableKeyEvents:true,
                                        listeners:{
                                          
                                        }
                                    }]
                                }
                                    
                                ]
                           
                        },
                        {
                                xtype: 'fieldset',
                                title: labels_json.vendorpanel.text_contact,
                                cls:'fieldset_text',
                                collapsible: false,
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
                                       fieldLabel:labels_json.vendorpanel.text_vendor_name,
                                       name:'vendor_ct_name',
                                       id:'_vendor_contact',
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },
                                     {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.vendorpanel.text_phone,
                                       name:'vendor_phone',
                                       id:'_vendor_phone',
                                       maskRe: /([0-9]+)$/,
                                       regex: /[0-9]/,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    }
                                    ,
                                     {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.vendorpanel.text_mobile,
                                       name:'vendor_mobile',
                                       id:'_vendor_mobile',
                                       maskRe: /([0-9]+)$/,
                                       regex: /[0-9]/,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },
                                     {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.vendorpanel.text_fax,
                                       name:'vendor_fax',
                                       id:'_vendor_fax',
                                       maskRe: /([0-9]+)$/,
                                       regex: /[0-9]/,
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },
                                     {
                                       xtype:'textfield',
                                       fieldLabel:labels_json.vendorpanel.text_email,
                                       name:'vendor_email',
                                       id:'_vendor_email',
                                       vtype:'email',
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                    },{
                                   xtype:'hidden',
                                   name:'vendor_acc_id',
                                   id:'_vendor_acc_id'
                                    
                              },{
                                   xtype:'hidden',
                                   name:'vendor_save',
                                   id:'_vendor_save',
                                   value:'0'
                                    
                              }
                                ]
                           
                        }
                    ]
                    },{
                        columnWidth: 1/2,
                        baseCls:'x-plain',
                        bodyStyle:'padding:5px',
                        items:[{
                                xtype: 'fieldset',
                                title: labels_json.vendorpanel.text_address,
                                cls:'fieldset_text',
                                collapsible: false,
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
                                       xtype:'textarea',
                                       grow:false,
                                       height:100,
                                       id:'_vendor_address',
                                       name:'vendor_address',
                                       enableKeyEvents:true,
                                        listeners:{
                                            change:function(){
                                                OBJ_Action.recordChange();
                                            }
                                        } 
                                       
                                       
                                    }
                                ]
                           
                        },
                        {
                            xtype: 'fieldset',
                            title: labels_json.vendorpanel.text_purchase_info,
                            cls:'fieldset_text',
                            collapsible: false,
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
                                   fieldLabel:labels_json.vendorpanel.text_term,
                                   name:'vendor_payment_terms',
                                   id:'_vendor_payment_terms'
                                },{
                                   xtype:'hidden',
                                   name:'vendor_hidden_id',
                                   id:'vendor_hidden_id',
                                   value:'0'
                              }
                            ]

                    }]
                   }]
                })
            }, {
                title: labels_json.vendorpanel.text_order_history,
                layout:'fit',
                items:[{xtype:"gridpanel",
                        id:"order_grid",
                        margin:5,
                         store:{
                            proxy:{
                                type:"memory",
                                reader:{
                                    type:"json"
                                }
                        },
                        model:Ext.define("customerOrderHistorModel", {
                            extend:"Ext.data.Model",
                            fields:[
				"order_id",
                                "order_date",
                                "order_status",
                                "order_total",
                                "order_paid",
                                "order_balance"
                                
        			]
                        }) && "customerOrderHistorModel",
                        data:[]
              },
              listeners:{
                afterRender : function() {
                    //this.superclass.afterRender.call(this);
                    this.nav = new Ext.KeyNav(this.getEl(),{
                        del: function(e){
                         
                        }
                    });
                }
  
              },

              columnLines: true,
              columns:[
		{header:labels_json.vendorpanel.text_order_no,dataIndex:"order_id",width:80},
                {header:labels_json.vendorpanel.text_order_date,dataIndex:"order_date",width:100},
                {header:labels_json.vendorpanel.text_order_status,dataIndex:"order_status",width:100},
                {header:labels_json.vendorpanel.text_order_total,dataIndex:"order_total",width:100},
                {header:labels_json.vendorpanel.text_amountpaid,dataIndex:"order_paid",width:100},
                {header:labels_json.vendorpanel.text_balancedue,dataIndex:"order_balance",flex:1}
                ]}]
            }],
           tbar: [
                   { xtype: 'button', 
                     text: labels_json.vendorpanel.text_new,
                     iconCls: 'new',
                     tooltip:'Create a new Vendor.',
                     listeners:{
                         click:function(){
                             OBJ_Action.makeNew();
                             if(OBJ_Action.onNew){
                                OBJ_Action.onNew();
                             }
                         }
                     }
                   }
                   ,
                   { xtype: 'button', 
                     text: labels_json.vendorpanel.text_save,
                     iconCls: 'save',
                     tooltip:labels_json.vendorpanel.text_save_info,
                     listeners:{
                         click:function(){
                          Ext.getCmp("_vendor_save").setValue('1');
                             if(user_right==1){
                                OBJ_Action.save();  
                                } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.newvendor.actions.new){
                                OBJ_Action.save();
                                    } else {
                                    Ext.Msg.show({
                                    title:'User Access Conformation',
                                    msg:'You have no access to Add',
                                    buttons:Ext.Msg.OK,
                                    callback:function(btn) {
                                        if('ok' === btn) {}
                                    }
                                   });
                                }
                              }
                         }
                     }
                   } ,
                   { xtype: 'button', 
                     text: labels_json.vendorpanel.text_save_new,
                     iconCls: 'save',
                     tooltip:labels_json.vendorpanel.text_save_new_info,
                     listeners:{
                         click:function(){
                             if(user_right==1){
                               
                                 OBJ_Action.save({
                                makenew: OBJ_Action.save
                            }); 

                                } else {
                                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.newvendor.actions.new){
                                OBJ_Action.save();
                                    } else {
                                    Ext.Msg.show({
                                    title:'User Access Conformation',
                                    msg:'You have no access to Add',
                                    buttons:Ext.Msg.OK,
                                    callback:function(btn) {
                                        if('ok' === btn) {}
                                    }
                                   });
                                }
                              }
                         }
                     }
                   }
                   ,'-',
                   { xtype: 'button', 
                     text: labels_json.vendorpanel.text_copy,
                     iconCls: 'copy',
                     tooltip:'Create a new vendor with same basic <br/> information as the current vendor.',
                     listeners:{
                         click:function(){
                             OBJ_Action.copy('vendor_hidden_id','_vendor_name');
                             Ext.getCmp("_vendor_obalance").setDisabled(false);
                         }
                     }
                   }
                   ,
                   { xtype: 'button', 
                     text: labels_json.vendorpanel.text_deactive,
                     iconCls: 'deactivate',
                     id:'vendor_btn_activate',
                     tooltip:'Deactivate this vendor so that it will not <br/> be shown in other screens such as Sales <br/> order. Deactivated vendors can be <br/> reactivated again in future.',
                     iconCls: 'deactivate',
                     listeners:{
                         click:function(btn,e,opt){
                             var getID =  parseInt(Ext.getCmp("vendor_hidden_id").getValue());
                             if(getID!==0){
                                var active = btn.iconCls == 'deactivate'?0:1;
                                OBJ_Action.deactive(getID,active);
                             }
                             else{
                                Ext.Msg.show({
                                 title:'Error',
                                 msg: 'System cann\'t perform this action. Please save vendor first.' ,
                                 buttons: Ext.Msg.OK,
                                 icon: Ext.Msg.ERROR
                                });
                             }
                         }
                     }
                   },'-',
                   { xtype: 'button', 
                     text: labels_json.vendorpanel.text_close,
                     iconCls: 'close',
                     tooltip:'Close this vendor and switch back to home page.',
                     listeners:{
                         click:function(){
                             OBJ_Action.close();
                         }
                     }
                   }

            ]

        }
    ]
}
)