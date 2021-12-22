_settings = {
    id: 'settings-panel',
    layout: 'border',
    listeners: {
        beforeclose: function () {

        },
        beforerender: function () {
            // console.log(enableUom);
            if(enableUom==0)
            {
               Ext.getCmp('units').setVisible(false)
            }
            unit_store.load();
            customer_store.load();   
            if(user_type!=2){
                Ext.getCmp("users_setting").hide();
                Ext.getCmp("users-card").hide();
                Ext.getCmp("references-card").addCls("selected");
            var spanel = Ext.getCmp("settings_center_panel")
            spanel.layout.setActiveItem('references-card');
            spanel.doLayout();
            }
            
        },
        show: function () {
        },
        afterrender: function () {
          
            userManagementWindow = Ext.create('widget.window', {
                title: 'Add/Update User',
                width: 1100,
                height: 600,
                minWidth: 100,
                minHeight: 50,
                layout: 'fit',
                closeAction: 'hide',
                modal: true,
                listeners: {
                    show: function () {
                        var me = this.down('form').getForm();
                        if (winMode && winMode > 0) {                            
                            var selectionModel = Ext.getCmp("user-grid").selModel.getSelection()[0];
                            me.findField('username').setValue(selectionModel.get("user_name"));
                            me.findField('password').setValue('11');
                            me.findField('status').setValue(selectionModel.get("user_status"));
                            if (selectionModel.get("user_type") == "POS User") {
                                Ext.getCmp("pos_user_type").setValue(true);
                            } else {
                                Ext.getCmp("system_user_type").setValue(true);
                            }
                            if (selectionModel.get("user_right") == "No Access") {
                                Ext.getCmp("no_access").setValue(true);
                            } else if (selectionModel.get("user_right") == "Full Access") {
                                Ext.getCmp("full_access").setValue(true);
                            } else if(selectionModel.get("user_right") == "Selective Access") {
                                Ext.getCmp("selective_access").setValue(true);
                            } else if(selectionModel.get("user_right") == "Customer Access") {
                                Ext.getCmp("customer_access").setValue(true);
                                Ext.getCmp("user_customers_combo").setValue(selectionModel.get("customer_id"))
                            } else {
                                Ext.getCmp("no_access").setValue(true);
                            }
                            me.findField('user_hidden_id').setValue(selectionModel.get("user_id"));
                            setTimeout(function(){ me.findField('password').setValue(''); }, 200);
                        } else {
                            me.reset();
                            me.findField('user_hidden_id').setValue(0);
                        }
                        
                        var id = Ext.getCmp('user_hidden_id').getValue();
                            if(id!="" && id>0 && selectionModel.get("user_right") == "Selective Access"){ 
                                Ext.Ajax.request({
                                    url: action_urls.url_getrights,
                                    method : 'GET',
                                    params:{user_id:Ext.getCmp('user_hidden_id').getValue()},
                                    success: function (data) {
                                        var user_access = Ext.decode(data.responseText);
                                        var user_rights = Ext.decode(decodeHTML(user_access.user_rights));
                                        user_access_json = user_rights;
                                        Ext.getCmp('userRights').setValue(JSON.stringify(user_rights));
                                        access_modules = user_rights.user_access;
                                        var rights_html = "<div class='rights_panel'>";
                                            Ext.Object.each( user_rights.user_access, function( key, value ) {
                                                if(value.parentlabel){
                                                rights_html += "<div style='font-family:Arial, Helvetica, sans-serif; float: left; width:100%; background-color:#e8e8e8; height:25px; padding:5px; font-weight: bold; font-size:14px;'>"+value.parentlabel+"</div>";
                                            }
                                            
                                            if(value.label){
                                                if(!value.hide){
                                                rights_html += "<div class='"+key+"' style='width:20%; float: left; border:2px solid #e8e8e8; padding:10px 5px; border-radius:10px;'>";
                                                if(value.actions){
                                                    rights_html += "<div style='font-family:Arial, Helvetica, sans-serif; float: left; margin-left:5px; font-weight: bold; font-size:12px;'>"+value.label+"</div><br>";
                                                    Ext.Object.each(value.actions,function(k,val){
                                                            var checked = val ? "checked":"";
                                                            if(k=='view'){
                                                                rights_html += "<label style='float:left; margin-right:10px;  margin-top:3px;'><input class='view' type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' style='width: 15px;' />"+k.charAt(0).toUpperCase()+k.slice(1)+"</label>";
                                                            }
                                                            else if(k=='access'){
                                                                rights_html += "<label style='float:left; margin-right:10px;  margin-top:3px;'><input class='access' type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' style='width: 15px;' />"+k.charAt(0).toUpperCase()+k.slice(1)+"</label>";
                                                            }
                                                            else{
                                                                rights_html += "<label style='float:left; margin-right:10px;  margin-top:3px;'><input class='other' type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' style='width: 15px;' />"+k.charAt(0).toUpperCase()+k.slice(1)+"</label>";
                                                            }
                                                        })
                                                }
                                                rights_html +="</div>";
                                            } 
                                        }
                                            });
                                            rights_html +="</div>";
                                         Ext.getCmp('selective_rigths_form').body.dom.innerHTML = rights_html;
                                         Ext.get("selective_rigths_form").select(".rights_panel input[type='checkbox']").on("change", function(){
                                            var element = Ext.get( this );
                                            user_access_json.user_access[element.getAttribute("data-parentkey")].actions[element.getAttribute("data-key")] = this.checked;
                                            
                                        });
                                    },
                                    failure: function () {
                                    }
                                 });
                            } else{ 
                                Ext.Ajax.request({
                                    url: json_urls.user_access,
                                    success: function (response, options) {
                                        var user_rights = Ext.decode(response.responseText);
                                        user_access_json = user_rights;
                                        access_modules = user_rights.user_access;
                                        Ext.getCmp('userRights').setValue(JSON.stringify(user_rights));
                                        var rights_html = "<div class='rights_panel'>";
                                            Ext.Object.each( user_rights.user_access, function( key, value ) {
                                                if(value.parentlabel){
                                                rights_html += "<div style='font-family:Arial, Helvetica, sans-serif; float: left; width:100%; background-color:#e8e8e8; height:25px; padding:5px; font-weight: bold; font-size:14px;'>"+value.parentlabel+"</div>";
                                            }
                                            if(value.label){
                                                if(!value.hide){
                                                rights_html += "<div class='"+key+"' style='width:20%; float: left; border:2px solid #e8e8e8; padding:10px 5px; border-radius:10px;'>";
                                                if(value.actions){
                                                    rights_html += "<div style='font-family:Arial, Helvetica, sans-serif; float: left; margin-left:5px; font-weight: bold; font-size:12px;'>"+value.label+"</div><br>";
                                                    Ext.Object.each(value.actions,function(k,val){
                                                            var checked = val ? "checked":"";
                                                            if(k=='view'){
                                                                rights_html += "<label style='float:left; margin-right:10px;  margin-top:3px;'><input class='view' type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' style='width: 15px;' />"+k.charAt(0).toUpperCase()+k.slice(1)+"</label>";
                                                            }
                                                            else if(k=='access'){
                                                                rights_html += "<label style='float:left; margin-right:10px;  margin-top:3px;'><input class='access' type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' style='width: 15px;' />"+k.charAt(0).toUpperCase()+k.slice(1)+"</label>";
                                                            }
                                                            else{
                                                                rights_html += "<label style='float:left; margin-right:10px;  margin-top:3px;'><input class='other' type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' style='width: 15px;' />"+k.charAt(0).toUpperCase()+k.slice(1)+"</label>";
                                                            }
                                                        })
                                                }
                                                rights_html +="</div>";
                                            }
                                            } 
                                            });
                                            rights_html +="</div>";
                                         Ext.getCmp('selective_rigths_form').body.dom.innerHTML = rights_html;
                                         Ext.get("selective_rigths_form").select(".rights_panel  input[type='checkbox']").on("change", function(){
                                            var element = Ext.get( this );
                                            user_access_json.user_access[element.getAttribute("data-parentkey")].actions[element.getAttribute("data-key")] = this.checked;
                                        });
                                         
                                        
                                    },
                                       failure: function(response, options){
                                      }
                                    });  
                                    }
                            
                    }
                },
                items: Ext.create('Ext.form.Panel', {
                    url: 'save-form.php',
                    bodyStyle: 'padding:5px 5px 0',
                    fieldDefaults: {
                        msgTarget: 'side',
                        labelWidth: 75
                    },
                    defaults: {
                        anchor: '100%'
                    },
                    items: [
                        {
                            xtype: 'fieldset',
                            title: 'User Details',
                            collapsible: false,
                            hidden: false,
                            defaultType: 'textfield',
                            cls: 'fieldset_text_username',
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 100
                            },
                            items: [
                                {
                                    xtype: 'textfield',
                                    id: 'aur_username',
                                    name: 'username',
                                    fieldLabel: 'User name',
                                    emptyText: 'Enter user name',
                                    allowBlank: false
                                },
                                {
                                    xtype: 'textfield',
                                    id: 'aur_username_password',
                                    fieldLabel: 'Password',
                                    name: 'password',
                                    inputType: 'password',
                                    allowBlank: true
                                },
                                {
                                    xtype: 'combo',
                                    fieldLabel: 'Status',
                                    value: '1',
                                    queryMode: 'local',
                                    displayField: 'type',
                                    valueField: 'id',
                                    name: 'status',
                                    editable: false,
                                    queryMode: 'local',
                                            store: {
                                                proxy: {
                                                    type: "memory",
                                                    reader: {
                                                        type: "json"
                                                    }
                                                },
                                                model: Ext.define("userStatusModel", {
                                                    extend: "Ext.data.Model",
                                                    fields: [
                                                        "id",
                                                        "type"
                                                    ]
                                                }) && "userStatusModel",
                                                data: [{id: '1', type: 'Enabled'}, {id: '0', type: 'Disabled'}
                                                ]}
                                }

                            ]
                        },
                        {
                            xtype: 'fieldset',
                            title: 'User Type',
                            collapsible: false,
                            hidden: false,
                            defaultType: 'textfield',
                            cls: 'fieldset_type_username',
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 100
                            },
                            items: [
                                {
                                    xtype      : 'fieldcontainer',
                                    fieldLabel : '',
                                    defaultType: 'radiofield',
                                    defaults: {
                                        flex: 1
                                    },
                                    layout: 'hbox',
                            items: [
                                {
                                    xtype: 'radiofield',
                                    name: 'usertype',
                                    inputValue: 3,
                                    checked: true,
                                    id: 'system_user_type',
                                    fieldLabel: 'User Type',
                                    labelSeparator: '',
                                    hideEmptyLabel: false,
                                    boxLabel: 'System User'
                                },{
                                    xtype: 'radiofield',
                                    name: 'usertype',
                                    inputValue: 1,
                                    id: 'pos_user_type',
                                    fieldLabel: '',
                                    boxLabel: 'POS User',
                                    handler: function(ctl, val) {
                                        if(val==true){ 
                                            Ext.getCmp('selective_access').setDisabled(true);
                                            Ext.getCmp('selective_rigths_form').hide(true);
                                            Ext.getCmp('no_access').setValue(true);
                                        } else {
                                            Ext.getCmp('selective_access').setDisabled(false);
                                        }
                                    }
                                }

                            ]
                             } 
                            ]
                        }, 
                        {
                            xtype: 'fieldset',
                            title: 'User Rights',
                            collapsible: false,
                            hidden: false,
                            defaultType: 'textfield',
                            cls: 'fieldset_type_userights',
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 100
                            },
                            items: [
                                {
                                    xtype      : 'fieldcontainer',
                                    fieldLabel : 'User Rights',
                                    defaultType: 'radiofield',
                                    defaults: {
                                        flex: 1
                                    },
                                    layout: 'hbox',
                                    items: [
                                        {
                                            xtype: 'radiofield',
                                            name: 'user_rights',
                                            inputValue: 0,
                                            id: 'no_access',
                                            checked: true,
                                            fieldLabel: '',
                                            boxLabel: 'No Access'
                                        }, {
                                            xtype: 'radiofield',
                                            name: 'user_rights',
                                            inputValue: 1,
                                            id: 'full_access',
                                            fieldLabel: '',
                                            boxLabel: 'Full Access'
                                        }, {
                                            xtype: 'radiofield',
                                            name: 'user_rights',
                                            inputValue: 2,
                                            id:'selective_access',
                                            fieldLabel: '',
                                            boxLabel: 'Selective Access',
                                            handler: function(ctl, val) {
                                                if(val==true){ 
                                                    Ext.getCmp('selective_rigths_form').show();
                                                } else {
                                                    Ext.getCmp('selective_rigths_form').hide();
                                                }
                                            }
                                        }, {
                                            xtype: 'radiofield',
                                            name: 'user_rights',
                                            inputValue: 3,
                                            id: 'customer_access',
                                            fieldLabel: '',
                                            boxLabel: 'Customer Access',
                                            handler: function(ctl, val) {
                                                if(val==true){ 
                                                    Ext.getCmp('select_customer_area').show();                                                    
                                                } else {
                                                    Ext.getCmp('select_customer_area').hide();
                                                }
                                            }
                                        }
                                    ]
                                } 
                            ]
                        },
                        {
                            xtype : 'panel',
                            title : 'User Rights Access',
                            id : 'selective_rigths_form',
                            hidden: true,
                            width: 800,
                            height: 280,
                            preventHeader: true,
                            mnHeight: 280,
                            minHeight: 300,
                            autoScroll: true,
                            layout: {
                            type: 'hbox',
                            align: 'stretch'
                            },
                            renderTo: document.body,
                            items: [],
                            
                            listeners: {
                                click: {
                                    element: 'el',
                                    fn: function(e, t) {
                                        Ext.select(".view").on("change",function(e,t){
                                            parent = (t.getAttribute("data-parentkey"))
                                           if(t.checked == false){
                                                Ext.Object.each(Ext.select(".other").elements,function(k,val){
                                                    if(val.getAttribute("data-parentkey") == parent){
                                                        Ext.select(".other").elements[k].checked = false;
                                                        Ext.select(".other").elements[k].disabled = true;
                                                    }
                                                });
                                                Ext.Object.each(user_access_json,function(k,val){
                                                    Ext.Object.each(val,function(j,value){
                                                        if(j == parent){
                                                            Ext.Object.each(value.actions,function(i,action){
                                                                value.actions[i] = false
                                                            });
                                                        }
                                                    });
                                                });
                                            }
                                            else{
                                                Ext.Object.each(Ext.select(".other").elements,function(k,val){
                                                    if(val.getAttribute("data-parentkey") == parent){
                                                        Ext.select(".other").elements[k].disabled = false;
                                                    }
                                                });
                                            }
                                        });
                                        Ext.select(".access").on("change",function(e,t){
                                            parent = (t.getAttribute("data-parentkey"))
                                           if(t.checked == false){
                                                Ext.Object.each(Ext.select(".other").elements,function(k,val){
                                                    if(val.getAttribute("data-parentkey") == parent){
                                                        Ext.select(".other").elements[k].checked = false;
                                                        Ext.select(".other").elements[k].disabled = true;
                                                    }
                                                });
                                                Ext.Object.each(user_access_json,function(k,val){
                                                    Ext.Object.each(val,function(j,value){
                                                        if(j == parent){
                                                            Ext.Object.each(value.actions,function(i,action){
                                                                value.actions[i] = false
                                                            });
                                                        }
                                                    });
                                                });
                                                //console.log(Ext.select(".view").elements[0].checked)
                                            }
                                            else{
                                                Ext.Object.each(Ext.select(".other").elements,function(k,val){
                                                    if(val.getAttribute("data-parentkey") == parent){
                                                        Ext.select(".other").elements[k].disabled = false;
                                                    }
                                                });
                                            }
                                        });
                                        
                                    },
                                }
                            },
                            
                          },
                        {
                            xtype : 'panel',
                            title : 'Select Customer',
                            id : 'select_customer_area',
                            hidden: true,
                            width: 800,
                            height: 280,
                            preventHeader: true,
                            mnHeight: 280,
                            minHeight: 300,                            
                            layout: 'anchor',
                            bodyStyle: 'padding: 100px 250px;',
                            items: [{
                                xtype:'combo',
                                fieldLabel:'Select Customer to Create Login',
                                id:'user_customers_combo',
                                name:'customer_id',
                                labelWidth:200,
                                width:500,                                
                                valueField:'cust_id', 
                                tabIndex:1,
                                flex : 1,
                                displayField:'cust_name',                        
                                emptyText: 'Select a Customer...',                                   
                                store: customer_store_account,
                                queryMode:'local',   
                                listeners:{
                                    change:function(f,obj){                            
                                       
                                    }
                                }
                            }]
                          },
                        
                        {
                            xtype: 'hidden',
                            name: 'user_hidden_id',
                            id: 'user_hidden_id',
                            value: '0'
                        },
                        {
                            xtype     : 'hidden',
                            name      : 'userRights',
                            id:    'userRights',
                            value: '',
                        }
                    ],
                    buttons: [{
                            text: 'Save',
                            handler: function () {
                                if (this.up('form').getForm().isValid()) {
                                    LoadingMask.showMessage('Please wait..');
                                    this.up('form').getForm().submit({
                                        clientValidation: true,
                                        url: action_urls.save_update_user,
                                        params: {
                                            user_access_json : JSON.stringify(user_access_json)
                                        },
                                        success: function (form, action) {
                                            LoadingMask.hideMessage();
                                            if (user_store.load) {
                                                user_store.load();
                                            }
                                            userManagementWindow.hide();
                                        },
                                        failure: function (form, action) {
                                            LoadingMask.hideMessage();
                                            failureMessages(form, action);

                                        }
                                    });
                                }
                            }
                        }, {
                            text: 'Cancel',
                            handler: function () {
                                this.up('form').getForm().reset();
                                this.up('window').hide();

                            }
                        }]
                })

            });

            
            
            //Unit of measure dialog

            unitManagementWindow = Ext.create('widget.window', {
                title: 'Add/Update Units of measurements',
                width: 550,
                height: 400,
                minWidth: 100,
                minHeight: 50,
                layout: 'fit',
                closeAction: 'hide',
                modal: true,
                listeners: {
                    show: function () {
                        var me = this.down('form').getForm();

                    }
                },
                items: Ext.create('Ext.form.Panel', {
                    url: 'save-form.php',
                    bodyStyle: 'padding:5px 5px 0',
                    fieldDefaults: {
                        msgTarget: 'side',
                        labelWidth: 75
                    },
                    defaults: {
                        anchor: '100%'
                    },
                    items: [
                        {
                            id: 'units-card',
                            items: [{
                                    xtype: 'box',
                                    autoEl: {tag: 'div', html: 'Units of Measurement:', cls: "heading1"}
                                },
                                {
                                    layout: 'border',
                                    margin: '10 15 10 15',
                                    border: false,
                                    height: 250,
                                    defaults: {
                                        border: false
                                    },
                                    items: [{
                                            region: 'north',
                                            height: 30,
                                            items: [{
                                                    xtype: 'button',
                                                    text: 'Add Unit',
                                                    id: 'new_unit',
                                                    width: 80,
                                                    listeners: {
                                                        click: function () {
                                                            winMode = 0;
                                                            addUnitWindow.show();
                                                        }
                                                    }
                                                }, {
                                                    xtype: 'button',
                                                    text: 'Edit Unit',
                                                    id: 'edit_unit',
                                                    margin: '0 0 0 5',
                                                    disabled: true,
                                                    width: 80,
                                                    listeners: {
                                                        click: function () {
                                                            winMode = 1;
                                                            addUnitWindow.show();
                                                        }
                                                    }
                                                },
                                                {
                                                    xtype: 'button',
                                                    text: 'Delete',
                                                    disabled: true,
                                                    margin: '0 0 0 5',
                                                    id: 'remove_unit',
                                                    width: 80,
                                                    listeners: {
                                                        click: function () {
                                                            performAction('Delete', action_urls.delete_unit, Ext.getCmp("unit-grid"), false, {key: 'id', store: unit_store});
                                                        }
                                                    }
                                                }]

                                        }, {
                                            region: 'center',
                                            layout: 'fit',
                                            items: [{
                                                    xtype: "gridpanel",
                                                    id: 'unit-grid',
                                                    store: unit_store,
                                                    columnLines: true,
                                                    selModel: Ext.create('Ext.selection.CheckboxModel', {
                                                        listeners: {
                                                            selectionchange: function (sm, selections) {
                                                                if (selections.length == 1) {
                                                                    Ext.getCmp("edit_unit").setDisabled(false);
                                                                    Ext.getCmp("remove_unit").setDisabled(false);
                                                                } else if (selections.length > 1) {
                                                                    Ext.getCmp("edit_unit").setDisabled(true);
                                                                    Ext.getCmp("remove_unit").setDisabled(false);
                                                                } else {
                                                                    Ext.getCmp("edit_unit").setDisabled(true);
                                                                    Ext.getCmp("remove_unit").setDisabled(true);
                                                                }
                                                            }
                                                        }
                                                    }),
                                                    columns: [
                                                        {header: "Name", dataIndex: "name", flex: 1}

                                                    ]
                                                }]
                                        }]
                                }
                            ]
                        }
                    ],
                    buttons: [{
                            text: 'Close',
                            handler: function () {
                                this.up('form').getForm().reset();
                                this.up('window').hide();

                            }
                        }]

                })

            });
            
            
            // Add/Edit Unit of Measurement. 

            addUnitWindow = Ext.create('widget.window', {
                title: 'Add/Update Unit',
                width: 350,
                height: 120,
                id:'new_unit_form',
                minWidth: 300,
                minHeight: 100,
                layout: 'fit',
                closeAction: 'hide',
                modal: true,
                listeners: {
                    afterrender:function(){
                    
                    var unit_form = new Ext.util.KeyMap("new_unit_form", [
                        {
                            key: [10,13],
                            fn: function(){ 
                                Ext.getCmp("save_unit").fireHandler();
                            }
                        }
                    ]);  
                },
                    show: function () {
                        var me = this.down('form').getForm();
                        if (winMode && winMode > 0) {
                            var selectionModel = Ext.getCmp("unit-grid").selModel.getSelection()[0];
                            me.findField('unit_name').setValue(selectionModel.get("name"));
                            me.findField('unit_hidden_id').setValue(selectionModel.get("id"));
                            me.findField("unit_name").focus(true,100);
                        } else {
                            me.reset();
                            me.findField('unit_hidden_id').setValue(0);
                            me.findField("unit_name").focus(true,100);
                        }
                    }
                },
                items: Ext.create('Ext.form.Panel', {
                    url: 'save-form.php',
                    bodyStyle: 'padding:5px 5px 0',
                    fieldDefaults: {
                        msgTarget: 'side',
                        labelWidth: 75
                    },
                    defaults: {
                        anchor: '100%'
                    },
                    items: [
                        {
                            xtype: 'fieldset',
                            title: 'UoM',
                            collapsible: false,
                            hidden: false,
                            defaultType: 'textfield',
                            cls: 'fieldset_text_username',
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%',
                                labelWidth: 100
                            },
                            items: [
                                {
                                    xtype: 'textfield',
                                    id: 'aur_unitname',
                                    name: 'unit_name',
                                    fieldLabel: 'New Unit',
                                    emptyText: 'Enter unit name',
                                    allowBlank: false
                                }

                            ]
                        }, {
                            xtype: 'hidden',
                            name: 'unit_hidden_id',
                            id: 'unit_hidden_id',
                            value: '0'
                        }
                    ],
                    buttons: [{
                            text: 'Save',
                            id:'save_unit',
                            handler: function () {
                                if (this.up('form').getForm().isValid()) {
                                    LoadingMask.showMessage('Please wait..');
                                    this.up('form').getForm().submit({
                                        clientValidation: true,
                                        url: action_urls.save_update_unit,
                                        params: {
                                        },
                                        success: function (form, action) {
                                            LoadingMask.hideMessage();
                                            if (unit_store.load) {
                                                unit_store.load();
                                            }
                                            addUnitWindow.hide();
                                        },
                                        failure: function (form, action) {
                                            LoadingMask.hideMessage();
                                            failureMessages(form, action);

                                        }
                                    });
                                }
                            }
                        }, {
                            text: 'Cancel',
                            handler: function () {
                                this.up('form').getForm().reset();
                                this.up('window').hide();

                            }
                        }]
                })

            });

            termsConditionWindow = Ext.create('widget.window', {
                title: 'Update Terms & Conditions',
                width: 550,
                height: 345,
                minWidth: 300,
                minHeight: 300,
                layout: 'fit',
                closeAction: 'hide',
                modal: true,
                listeners: {
                    show: function () {
                        var me = this.down('form').getForm();
                        me.findField('config_saleterms_value').setValue(settings.sale["config_saleterms"]);
                    }
                },
                items: Ext.create('Ext.form.Panel', {
                    url: action_urls.save_settings,
                    bodyStyle: 'padding:5px 5px 0',
                    fieldDefaults: {
                        msgTarget: 'side',
                        labelWidth: 75
                    },
                    defaults: {
                        anchor: '100%'
                    },
                    items: [
                        {
                            xtype: 'htmleditor',
                            id: 'html_condtions',
                            enableLinks: false,
                            enableSourceEdit: false,
                            enableFont: false,
                            enableFontSize:false,
                            enableColors: false,
                            height: 270,
                            width: '100%',
                            name:'config_saleterms_value'

                        }, {
                            xtype: 'hidden',
                            name: 'key',
                            id: 'setting_hidden_key',
                            value: 'config_saleterms'
                        }
                    ],
                    buttons: [{
                            text: 'Save',
                            handler: function () {
                                var me = this.up('form').getForm();
                                if (me.isValid()) {             
                                    if(me.findField('config_saleterms_value').getValue()=="<br>"){
                                        me.findField('config_saleterms_value').setValue('');
                                    }
                                    LoadingMask.showMessage('Please wait..');
                                     this.up('form').getForm().submit({
                                     clientValidation: true,
                                     url: action_urls.save_settings,
                                     params: {
                                         
                                     },
                                     success: function(form, action) {
                                        LoadingMask.hideMessage();                                                                                       
                                        settings.sale["config_saleterms"] = me.findField('config_saleterms_value').getValue();
                                        termsConditionWindow.hide();
                                     },
                                     failure: function(form, action) {
                                        LoadingMask.hideMessage();
                                        failureMessages(form, action);

                                        }
                                     });
                                }
                            }
                        }, {
                            text: 'Cancel',
                            handler: function () {
                                this.up('form').getForm().reset();
                                this.up('window').hide();

                            }
                        }]
                })

            });
        }
    },
    defaults: {
        border: false
    },
    items: [{
            region: 'west',
            width: 120,
            split: false,
            collapsible: false,
            bodyCls: 'settings_left_bar',
            floatable: false,
            layout: {
                type: 'table',
                columns: 1,
                tableAttrs: {
                    width: '100%',
                    id: 'settings_side_panel_table'
                }

            },
            defaults: {
                border: false,
                listeners: {
                    el: {
                        click: function (ev) {
                            if(user_type==2){
                                ev.preventDefault();
                                if (!this.hasCls("selected")) {
                                    var card_token = this.id.split("_")[0];
                                    var selectedId = Ext.get("settings_side_panel_table").query(".selected")[0].id;
                                    Ext.getCmp(selectedId).removeCls('selected');
                                    this.addCls("selected");
                                    var spanel = Ext.getCmp("settings_center_panel")
                                    spanel.layout.setActiveItem(card_token + '-card');
                                    spanel.doLayout();
                                }
                            } 

                        }
                    }
                }
            },
            items: [{
                    xtype: 'box',
                    hidden: 'true',
                    id: 'company_setting',
                    autoEl: {tag: 'div', html: 'Company', cls: 'company_ico'}
                }, {
                    xtype: 'box',
                    id: 'users_setting',
                    autoEl: {tag: 'div', html: 'Users', cls: 'users_ico selected'}
                }, {
                    xtype: 'box',
                    id: 'references_setting',
                    autoEl: {tag: 'div', html: 'References', cls: 'refrences_ico'}
                }, {
                    xtype: 'box',
                    hidden: 'true',
                    id: 'docnumbsers_setting',
                    autoEl: {tag: 'div', html: 'Doc Numbers', cls: 'docnumbers_ico'}
                }, {
                    xtype: 'box',
                    hidden: 'true',
                    id: 'backup_setting',
                    autoEl: {tag: 'div', html: 'Auto Backup', cls: 'backup_ico'}
                }]
        }, {
            region: 'center',
            layout: 'fit',
            items: Ext.widget('form', {
                layout: 'border',
                items: [{
                        region: 'center',
                        id: 'settings_center_panel',
                        activeItem: 0,
                        defaults: {border: false},
                        layout: 'card',
                        items: [{
                                id: 'users-card',
                                items: [{
                                        xtype: 'box',
                                        autoEl: {tag: 'div', html: 'Users:', cls: "heading1"}
                                    },
                                    {
                                        xtype: 'box',
                                        autoEl: {tag: 'div', html: 'Give multiple people accounts  and limit their rights.', cls: "description1"}
                                    },
                                    {
                                        xtype: 'fieldset',
                                        cls: 'fieldset_text',
                                        flex: 1,
                                        hidden: true,
                                        defaultType: 'checkbox',
                                        layout: 'anchor',
                                        defaults: {
                                            anchor: '100%',
                                            hideEmptyLabel: false,
                                            labelWidth: 200
                                        },
                                        items: [{
                                                fieldLabel: 'Require Login every time?',
                                                boxLabel: '',
                                                margin: '0 0 5 5',
                                                labelSeparator: '',
                                                name: 'login_require'
                                            }]
                                    }, {
                                        layout: 'border',
                                        margin: '10 15 10 15',
                                        border: false,
                                        height: 250,
                                        defaults: {
                                            border: false
                                        },
                                        items: [{
                                                region: 'north',
                                                height: 30,
                                                items: [{
                                                        xtype: 'button',
                                                        text: 'Add User',
                                                        id: 'new_user',
                                                        width: 80,
                                                        listeners: {
                                                            click: function () {
                                                                winMode = 0;
                                                                userManagementWindow.show();
                                                            }
                                                        }
                                                    }, {
                                                        xtype: 'button',
                                                        text: 'Edit User',
                                                        id: 'edit_user',
                                                        margin: '0 0 0 5',
                                                        disabled: true,
                                                        width: 80,
                                                        listeners: {
                                                            click: function () {
                                                                winMode = 1;
                                                                userManagementWindow.show();
                                                            }
                                                        }
                                                    },
                                                    {
                                                        xtype: 'button',
                                                        text: 'Deactive',
                                                        disabled: true,
                                                        margin: '0 0 0 5',
                                                        id: 'remove_user',
                                                        width: 80,
                                                        listeners: {
                                                            click: function () {
                                                                performAction('Deactive', action_urls.delete_user, Ext.getCmp("user-grid"), false, {key: 'user_id', store: user_store});
                                                            }
                                                        }
                                                    }]

                                            }, {
                                                region: 'center',
                                                layout: 'fit',
                                                items: [{
                                                        xtype: "gridpanel",
                                                        id: 'user-grid',
                                                        store: user_store_expect,
                                                        columnLines: true,
                                                        selModel: Ext.create('Ext.selection.CheckboxModel', {
                                                            listeners: {
                                                                selectionchange: function (sm, selections) {
                                                                    if (selections.length == 1) {
                                                                        Ext.getCmp("edit_user").setDisabled(false);
                                                                        Ext.getCmp("remove_user").setDisabled(false);
                                                                    } else if (selections.length > 1) {
                                                                        Ext.getCmp("edit_user").setDisabled(true);
                                                                        Ext.getCmp("remove_user").setDisabled(false);
                                                                    } else {
                                                                        Ext.getCmp("edit_user").setDisabled(true);
                                                                        Ext.getCmp("remove_user").setDisabled(true);
                                                                    }
                                                                }
                                                            }
                                                        }),
                                                        columns: [
                                                            {header: "Name", dataIndex: "user_name", flex: 1},
                                                            {header: "Active", dataIndex: "user_status_text", width: 50},
                                                            {header: "Rights", dataIndex: "user_right", width: 100},
                                                            {header: "Type", dataIndex: "user_type", width: 100}

                                                        ]
                                                    }]
                                            }]
                                    }
                                ]
                            }, {
                                id: 'company-card',
                                xtype: 'tabpanel',
                                items: [{
                                        title: 'Company Info',
                                        bodyPadding: 5,
                                        fieldDefaults: {
                                            labelWidth: 100,
                                            anchor: '100%'
                                        },
                                        layout: {
                                            type: 'vbox',
                                            align: 'stretch'  // Child items are stretched to full width
                                        },
                                        items: [{
                                                border: false,
                                                layout: {
                                                    type: 'table',
                                                    columns: 3,
                                                    tableAttrs: {
                                                        width: '100%'
                                                    }
                                                },
                                                defaults: {
                                                    border: false
                                                },
                                                items: [{
                                                        html: 'Logo:',
                                                        cls: 'label_cell',
                                                        width: 100
                                                    }, {
                                                        xtype: 'box',
                                                        autoEl: {tag: 'div', html: '', cls: 'picture_box'}
                                                    }, {
                                                        layout: 'absolute',
                                                        width: 100,
                                                        cls: 'label_cell',
                                                        height: 100,
                                                        items: [{
                                                                xtype: 'button',
                                                                text: 'Browse',
                                                                width: 90,
                                                                x: 0,
                                                                y: 5
                                                            }, {
                                                                xtype: 'button',
                                                                text: 'Clear',
                                                                width: 90,
                                                                x: 0,
                                                                y: 30
                                                            }]
                                                    }]
                                            }, {
                                                xtype: 'textfield',
                                                fieldLabel: 'Company Name',
                                                name: 'company_name'
                                            }, {
                                                xtype: 'textfield',
                                                fieldLabel: 'Address',
                                                name: 'company_address'
                                            }, {
                                                xtype: 'textfield',
                                                fieldLabel: '&nbsp;',
                                                labelSeparator: '',
                                                name: 'company_address_line2'
                                            },
                                            {
                                                layout: 'column',
                                                border: false,
                                                autoScroll: true,
                                                defaults: {
                                                    layout: 'anchor',
                                                    defaults: {
                                                        anchor: '100%',
                                                        border: false
                                                    }
                                                },
                                                items: [{
                                                        columnWidth: 1 / 2,
                                                        baseCls: 'x-plain',
                                                        items: [{
                                                                xtype: 'textfield',
                                                                fieldLabel: 'City',
                                                                name: 'company_city'
                                                            }, {
                                                                xtype: 'textfield',
                                                                fieldLabel: 'Country',
                                                                name: 'company_country'
                                                            }]
                                                    }, {
                                                        columnWidth: 1 / 2,
                                                        baseCls: 'x-plain',
                                                        items: [{
                                                                xtype: 'textfield',
                                                                fieldLabel: 'State',
                                                                name: 'company_state',
                                                                labelWidth: 80,
                                                                margin: '0 0 5 5'
                                                            }, {
                                                                xtype: 'textfield',
                                                                fieldLabel: 'Post Code',
                                                                name: 'company_zip',
                                                                labelWidth: 80,
                                                                margin: '0 0 5 5'
                                                            }]
                                                    }]
                                            }
                                            , {
                                                xtype: 'textfield',
                                                fieldLabel: 'Phone',
                                                name: 'company_phone'
                                            }, {
                                                xtype: 'textfield',
                                                fieldLabel: 'Fax',
                                                name: 'company_fax'
                                            }, {
                                                xtype: 'textfield',
                                                fieldLabel: 'Email',
                                                name: 'company_email'
                                            }, {
                                                xtype: 'textfield',
                                                fieldLabel: 'Web Site',
                                                name: 'company_website'
                                            }]/*Company info tab items*/
                                    }, {
                                        title: 'Products',
                                        items: [{
                                                xtype: 'container',
                                                layout: 'hbox',
                                                margin: '20',
                                                items: [{
                                                        xtype: 'fieldset',
                                                        cls: 'fieldset_text',
                                                        flex: 1,
                                                        defaultType: 'checkbox',
                                                        layout: 'anchor',
                                                        defaults: {
                                                            anchor: '100%',
                                                            hideEmptyLabel: false,
                                                            labelWidth: 200
                                                        },
                                                        items: [{
                                                                fieldLabel: 'Show Product Description',
                                                                boxLabel: '',
                                                                name: 'show_product_description',
                                                                inputValue: 'show_desc'
                                                            }, {
                                                                boxLabel: '',
                                                                fieldLabel: 'Show Product Unit',
                                                                name: 'show_product_unit',
                                                                inputValue: 'show_unit'
                                                            }]
                                                    }]
                                            }]
                                    }, {
                                        title: 'Pricing',
                                        items: [{
                                                xtype: 'container',
                                                layout: 'hbox',
                                                margin: '20',
                                                items: [
                                                    {
                                                        xtype: 'fieldset',
                                                        cls: 'fieldset_text',
                                                        flex: 1,
                                                        layout: 'anchor',
                                                        defaults: {
                                                            anchor: '100%',
                                                            hideEmptyLabel: false,
                                                            labelWidth: 100
                                                        },
                                                        items: [{
                                                                fieldLabel: 'Currency',
                                                                xtype: 'combo',
                                                                name: 'curreny'
                                                            }]
                                                    }]
                                            }]
                                    }]
                            }, {
                                id: 'references-card',
                                layout: 'border',
                                border: false,
                                defaults: {border: false},
                                items: [{
                                        region: 'north',
                                        height: 90,
                                        layout: {
                                            type: 'vbox',
                                            align: 'stretch'
                                        },
                                        fieldDefaults: {
                                            anchor: '100%'
                                        },
                                        items: [{
                                                xtype: 'box',
                                                autoEl: {tag: 'div', html: 'References:', cls: "heading1"}
                                            },
                                            {
                                                xtype: 'box',
                                                autoEl: {tag: 'div', html: 'AURSoft Inventory Flow saves the options you’ve entered for these fields, but you can manually adjust the list  here.', cls: "description1"}
                                            }]
                                    }, {
                                        region: 'center',
                                        layout: 'column',
                                        autoScroll: true,
                                        defaults: {
                                            layout: 'anchor',
                                            defaults: {
                                                anchor: '100%'
                                            }
                                        },
                                        items: [{
                                                columnWidth: 1 / 3,
                                                baseCls: 'x-plain',
                                                bodyStyle: 'padding:5px 0 15px 15px',
                                                items: [{
                                                        xtype: 'button',
                                                        text: 'Countries',
                                                        hidden: true,
                                                        margin: '10 0 5 0',
                                                        width: 120
                                                    }, {
                                                        xtype: 'button',
                                                        text: 'Payment Methods',
                                                        hidden: true,
                                                        margin: '10 0 5 0',
                                                        width: 120
                                                    }, {
                                                        xtype: 'button',
                                                        text: 'Units',
                                                        id:'units',
                                                        margin: '10 0 5 0',
                                                        width: 120,
                                                        listeners: {
                                                            click: function () {
                                                                unitManagementWindow.show();
                                                            }
                                                        }
                                                    }, {
                                                        xtype: 'button',
                                                        text: 'Terms & Conditions',
                                                        margin: '10 0 5 0',
                                                        width: 120,
                                                        listeners: {
                                                            click: function () {
                                                                termsConditionWindow.show();
                                                            }
                                                        }
                                                    }, {
                                                        xtype: 'button',
                                                        text: 'Download Backup',
                                                        margin: '10 0 5 0',
                                                        width: 120,
                                                        listeners: {
                                                            click: function () {
                                                                LoadingMask.showMessage('Downloading Backup.....');
                                                                    Ext.Ajax.request({
                                                                        url: action_urls.url_backup,
                                                                        params:{},
                                                                        success: function (data) {
                                                                            LoadingMask.hideMessage();
                                                                        },
                                                                        failure: function () {
                                                                        }
                                                                     });
                                                            }
                                                        }
                                                    }
                                                ]
                                            }, {
                                                columnWidth: 2 / 3,
                                                baseCls: 'x-plain',
                                                bodyStyle: 'padding:10px 0 15px 15px',
                                                items: [{
                                                        xtype: 'box',
                                                        hidden: true,
                                                        margin: '5 0 5 0',
                                                        autoEl: {tag: 'div', html: 'You can enter new countries.'}
                                                    }, {
                                                        xtype: 'box',
                                                        hidden: true,
                                                        margin: '24 0 5 0',
                                                        autoEl: {tag: 'div', html: 'Payment methods for invoices  and payments.'}
                                                    }
                                                    , {
                                                        xtype: 'box',
                                                        margin: '7 0 5 0',
                                                        autoEl: {tag: 'div', html: 'Units of measurement for products.'}
                                                    }, {
                                                        xtype: 'box',
                                                        margin: '24 0 5 0',
                                                        autoEl: {tag: 'div', html: 'Define terms & condition for sale invoice.'}
                                                    }]
                                            }]
                                    }]
                            }, {
                                id: 'docnumbsers-card',
                                layout: 'border',
                                border: false,
                                defaults: {border: false},
                                items: [{
                                        region: 'north',
                                        height: 90,
                                        layout: {
                                            type: 'vbox',
                                            align: 'stretch'
                                        },
                                        fieldDefaults: {
                                            anchor: '100%'
                                        },
                                        items: [{
                                                xtype: 'box',
                                                autoEl: {tag: 'div', html: 'Document Numbers:', cls: 'heading1'}
                                            },
                                            {
                                                xtype: 'box',
                                                autoEl: {tag: 'div', html: 'Set the pattern number of documents here. You can attach prefix and suffix to the numbers, and can see a preview of how it will look in the preview.', cls: "description1"}
                                            }]

                                    }, {
                                        region: 'center',
                                        layout: {
                                            type: 'table',
                                            columns: 5,
                                            tableAttrs: {
                                                width: '100%',
                                                cellpadding: 0,
                                                id: 'settings_document_number_table'
                                            },
                                            tdAttrs: {
                                                align: 'center'
                                            }
                                        },
                                        defaults: {
                                            border: false
                                        },
                                        items: [{
                                                html: '&nbsp;',
                                                width: 60
                                            },
                                            {
                                                html: 'Prefix',
                                                width: 50,
                                                cls: 'bottom_border'
                                            },
                                            {
                                                html: 'Next Number',
                                                width: 100,
                                                cls: 'bottom_border'
                                            },
                                            {
                                                html: 'Suffix',
                                                width: 50,
                                                cls: 'bottom_border'
                                            },
                                            {
                                                html: 'Preview',
                                                width: 100
                                            }
                                        ]
                                    }]

                            }, {
                                id: 'backup-card',
                                layout: 'border',
                                border: false,
                                defaults: {border: false},
                                items: [{
                                        region: 'north',
                                        height: 40,
                                        layout: {
                                            type: 'vbox',
                                            align: 'stretch'
                                        },
                                        fieldDefaults: {
                                            anchor: '100%'
                                        },
                                        items: [{
                                                xtype: 'box',
                                                autoEl: {tag: 'div', html: 'Auto Backups:', cls: 'heading1'}
                                            }
                                        ]

                                    }, {
                                        region: 'center',
                                        items: [{
                                            }]
                                    }]

                            }],
                        buttons: [{
                                text: 'Save & Close',
                                width: 100,
                                hidden: true,
                                handler: function () {
                                    if (this.up('form').getForm().isValid()) {
                                        LoadingMask.showMessage('Please wait..');
                                        this.up('form').getForm().submit({
                                            clientValidation: true,
                                            url: action_urls.saveupdate_account,
                                            params: {
                                            },
                                            success: function (form, action) {
                                                LoadingMask.hideMessage();
                                                Ext.getCmp("accounts-panel-grid").store.load();
                                                account_form.hide();
                                            },
                                            failure: function (form, action) {
                                                LoadingMask.hideMessage();
                                                failureMessages(form, action);

                                            }
                                        });

                                    }
                                }
                            }, {
                                text: 'Cancel',
                                width: 100,
                                handler: function () {
                                    this.up('form').getForm().reset();
                                    this.up('window').hide();
                                }
                            }]
                    }]
            })
        }]

}