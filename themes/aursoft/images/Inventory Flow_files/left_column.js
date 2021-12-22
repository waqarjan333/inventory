Ext.onReady(function(){  
   var leftPanel = Ext.getCmp('main_left_panel');
   var leftItems = new Ext.Panel ({
        layout: 'absolute',
        bodyCls:'left-panel',
        border: false,
        defaults:{
                  height:30,
                  x:20},
        items:[
            {
             xtype:'box',      
             autoEl:{tag:"a", html:linktext.home,cls:"left-panel-link icon_home"},
             y:20,
             listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault();
                        homePage();
                    }
                }
            }
          },{
             xtype:'box',      
             autoEl:{tag:"a",html:linktext.reminders, cls:"left-panel-link icon_reminder"},
             y:70,
             listeners: {
                el: {
                    click: function(ev){
                        ev.preventDefault();
                         getPanel(json_urls.reminders,'reminder-panel',{viewType:'window'});
                    }
                }
            }
          },
          {
             xtype:'box',      
             autoEl:{tag:"a", html:linktext.pos,cls:"left-panel-link icon_pos",href:urls.pos},
             y:120
          },{
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.dashboard,cls:"left-panel-link icon_dashboard"},
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault();
                    getPanel(json_urls.dashboard,'dashboard-panel');
                }
            }
        },
         y:170
        },
       
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.reports,cls:"left-panel-link icon_reports"},
         y:220,
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
         y:270,
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault(); 
                    getPanel(json_urls.price_level,'price_level-panel');
                }
            }
        }
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.settings,cls:"left-panel-link icon_settings"},
         y:320,
         listeners: {
            el: {
                click: function(ev){
                    ev.preventDefault(); 
                    getPanel(json_urls.settings,'settings-panel',{viewType:'window'});
                }
            }
        }
         
        }, {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.accounts,cls:"left-panel-link icon_accounts"},
         y:370,
         listeners: {
            el: {
                    click: function(ev){
                        ev.preventDefault();
                        getPanel(json_urls.accounts,'accounts-panel',{grids:['accounts-panel-grid']});
                    }
                }
            }
        },
        {
         xtype:'box',      
         autoEl:{tag:"a", html:linktext.logout,cls:"left-panel-link icon_logout",href:urls.logout},
         y:420
        }]
    });
   if(leftPanel.items != undefined){
      leftPanel.items.each(function(item){
            leftPanel.remove(item, true);
      });  
   }   
  var main_panel_center = Ext.getCmp('main_center_panel');
  leftPanel.margin$.bottom = 30;
  main_panel_center .margin$.right=0;
  leftPanel.setWidth(200);
  leftPanel.add(leftItems);
  leftPanel.doLayout();      
   
});