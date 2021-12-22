Ext.onReady(function(){  
   var leftPanel = Ext.getCmp('main_left_panel');
   var leftItems = new Ext.Panel ({
        layout: {
            type: 'table',
            columns: 1
        },
        bodyCls:'left-panel',        
        border: false,       
        id:'left_panel',
        items:[
            {
             xtype:'box',      
             autoEl:{tag:"a", html:linktext.home,cls:"left-panel-link icon_home"},             
             listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault();
                        homePage();
                    }
                }
            }
          },
          // {
          //    xtype:'box',      
          //    autoEl:{tag:"a",html:linktext.reminders, cls:"left-panel-link icon_reminder"},
          //    // y:70,
          //    listeners: {
          //       el: {
          //           click: function(ev){
          //               ev.preventDefault();
          //                // 
          //                   if(user_right==1){
          //                   getPanel(json_urls.reminders,'reminder-panel',{viewType:'window'});  
          //               } else {
          //                   if(Ext.decode(decodeHTML(userAccessJSON)).user_access.salesrep.actions.access){
          //                   getPanel(json_urls.reminders,'reminder-panel',{viewType:'window'});
          //                   } else {
          //                       Ext.Msg.show({
          //                           title:'User Access Conformation',
          //                           msg:'You have no access to open this Page',
          //                           buttons:Ext.Msg.OK,
          //                           callback:function(btn) {
          //                               if('ok' === btn) {
          //                               }
          //                           }
          //                       });
          //                   }
          //               }
          //           }
          //       }
          //   }
          // },
          {
             xtype:'box',      
             autoEl:{tag:"a", html:linktext.pos,cls:"left-panel-link icon_pos"},
             listeners:{
                 el:{
                     click:function(ev){                         
                         if(user_right==1){
                                window.location.href = urls.pos;
                            } else {
                                if(Ext.decode(decodeHTML(userAccessJSON)).user_access.pos.actions.access){
                                    window.location.href = urls.pos;
                                } else {
                                    Ext.Msg.show({
                                        title:'User Access Conformation',
                                        msg:'You have no access to open this POS',
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
          },{
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.dashboard,cls:"left-panel-link icon_dashboard"},
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault();
                    if(user_right==1){
                        getPanel(json_urls.dashboard,'dashboard-panel');  
                    } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.dashboard.actions.access){
                        getPanel(json_urls.dashboard,'dashboard-panel');
                        } else {
                            Ext.Msg.show({
                                title:'User Access Conformation',
                                msg:'You have no access to open this Page',
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
        },
       
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.reports,cls:"left-panel-link icon_reports"},         
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault(); 
                    getPanel(json_urls.reports,'reports-panel');
                }
            }
        }
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.price_level,cls:"left-panel-link icon_level"},
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault(); 
                    if(user_right==1){
                        getPanel(json_urls.price_level,'price_level-panel');  
                    } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.dashboard.actions.access){
                        getPanel(json_urls.price_level,'price_level-panel');
                        } else {
                            Ext.Msg.show({
                                title:'User Access Conformation',
                                msg:'You have no access to open this Page',
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
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.settings,cls:"left-panel-link icon_settings"},
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault(); 
                    if(user_right==1){
                        getPanel(json_urls.settings,'settings-panel',{viewType:'window'});
                    } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.settings.actions.access){
                        getPanel(json_urls.settings,'settings-panel',{viewType:'window'});
                        } else {
                            Ext.Msg.show({
                                title:'User Access Conformation',
                                msg:'You have no access to Settings',
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
         
        },{
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.salesreps,cls:"left-panel-link icon_sales_rep"},         
         listeners: {
            el: {
                    click: function(ev){
                        ev.preventDefault();
                        if(user_right==1){
                            getPanel(json_urls.salesrep,'salesrep-panel');  
                        } else {
                            if(Ext.decode(decodeHTML(userAccessJSON)).user_access.salesrep.actions.access){
                            getPanel(json_urls.salesrep,'salesrep-panel');
                            } else {
                                Ext.Msg.show({
                                    title:'User Access Conformation',
                                    msg:'You have no access to open this Page',
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
        }, {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.accounts,cls:"left-panel-link icon_accounts"},         
         listeners: {
            el: {
                    click: function(ev){
                        ev.preventDefault();
                        if(user_right==1){
                            getPanel(json_urls.accounts,'accounts-panel',{grids:['accounts-panel-grid']}); 
                        } else {
                            if(Ext.decode(decodeHTML(userAccessJSON)).user_access.account_management.actions.access){
                            getPanel(json_urls.accounts,'accounts-panel',{grids:['accounts-panel-grid']});
                            } else {
                                Ext.Msg.show({
                                    title:'User Access Conformation',
                                    msg:'You have no access to open this Page',
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
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.journal,cls:"left-panel-link icon_accounts"},         
         listeners: {
            el: {
                    click: function(ev){
                        ev.preventDefault();
                        if(user_right==1){
                     getPanel(json_urls.accounts_journal,'journal-panel',{grids:['journal-panel-grid']});
                } else {
                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.journal.actions.access){
                       getPanel(json_urls.accounts_journal,'journal-panel',{grids:['journal-panel-grid']});  
                    } else {
                      Ext.Msg.show({
                        title:'User Access Conformation',
                        msg:'You have no access to open Journal',
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
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.register,cls:"left-panel-link icon_accounts"},         
         listeners: {
            el: {
                    click: function(ev){
                        ev.preventDefault();
                        if(user_right==1){
                     getPanel(json_urls.accounts_register,'register-panel',{grids:['register-panel-grid']});
                } else {
                    if(Ext.decode(decodeHTML(userAccessJSON)).user_access.register.actions.access){
                       getPanel(json_urls.accounts_register,'register-panel',{grids:['register-panel-grid']});  
                    } else {
                      Ext.Msg.show({
                        title:'User Access Conformation',
                        msg:'You have no access to open Dashboard',
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
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.sms,cls:"left-panel-link icon_sms"},         
         listeners: {
            el: {
                    click: function(ev){
                        ev.preventDefault();     
                        if(Ext.getCmp("cust_mobile")){
                            Ext.getCmp("cust_mobile").setValue('');
                        }
                         sms_manual_form.show();                         
                    }
                }
            }
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.logout,cls:"left-panel-link icon_logout",href:urls.logout}         
        }]
    });
   if(leftPanel.items != undefined){
      leftPanel.items.each(function(item){
            leftPanel.remove(item, true);
      });  
   }   
  var main_panel_center = Ext.getCmp('main_center_panel');
  //leftPanel.margin$.bottom = 30;
  main_panel_center .margin$.right=0;
  leftPanel.setWidth(200);
  //leftPanel.setHeight(630);
  leftPanel.add(leftItems);
  leftPanel.doLayout();      
   
});