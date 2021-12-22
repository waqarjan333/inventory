({
    id: 'price_level-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:'Price Level List',
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
            title: 'Search Price Level',
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
                   fieldLabel:'Price Level Name',
                   id:'price_level_name_search'
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
                                         Ext.getCmp("price_level_name_search").setValue('');
                                         Ext.getCmp("price_level-panel-grid").store.load();
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
                                     Ext.getCmp("price_level-panel-grid").store.load({
                                         params:{
                                             search:Ext.getCmp("price_level_name_search").getValue()
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
            id:"price_level-panel-grid",
            margin:'0 5 5 5',
            store:{
                proxy:{
                    type:"ajax",
                    url: action_urls.get_pricelevels,
                    reader:{
                        type:"json",
                        root: 'pricelevels',
                        idProperty: 'id'
                    }
            },
            model:Ext.define("PriceLevelModel", {
                extend:"Ext.data.Model",
                fields:[
                    "id",
                    "level_name",
                    "level_type",
                    "level_dir",
                    "level_per",
                    "level_round",
                    "level_compare_price",
                    "level_detail",
                    "level_from_date",
                    "level_to_date"
                    ]
            }) && "PriceLevelModel",
            autoLoad:true,
            listeners:{
                'load':function(){
                    pricelevel_store.loadData(Ext.pluck(Ext.getCmp("price_level-panel-grid").store.data.items,'data'));
                }
            }
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
            {header:"Name",dataIndex:"level_name",flex:1},
            {header:"Type",dataIndex:"level_type",width:150,renderer:function(val,meta,record){
                    return (val=="1")? 'Fixed %':"Per Item"
            }},
            {header:"Details",dataIndex:"level_detail",width:120}
            ]
          }]
    }
  ]
  ,
    tbar: [
           { xtype: 'button', 
             text: 'New',
             iconCls: 'new',
             tooltip:'Create a new Price Level.',
             listeners:{
                 click:function(){
                      if(user_right==1 || user_right==3 ){
                        winMode =0;
                        price_level_form.setTitle('Create New Price Level');
                        price_level_form.show();
                     } else {
                            if(Ext.decode(decodeHTML(userAccessJSON)).user_access.price_level.actions.create){ 
                               winMode =0;
                               price_level_form.setTitle('Create New Price Level');
                               price_level_form.show();
                           }else{
                               Ext.Msg.show({
                                   title:'User Access Conformation',
                                   msg:'You have no access to Create New',
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
             text: 'Edit',
             iconCls: 'copy',
             id:'editAccountBtn',
             disabled:true,
             tooltip:'Edit selected account.',
             listeners:{
                 click:function(){
                     winMode =1;
                     price_level_form.setTitle('Edit/Update Price Level');
                     price_level_form.show();
                      
                 }
             }
           }
           ,
           { xtype: 'button', 
             text: 'Delete',
             id:'deactAccountBtn',
             tooltip:'Delete a price level',
             iconCls: 'deactivate',
             disabled:true,
             listeners:{
                 click:function(){
                     performAction('Delete',action_urls.delete_pricelevels,Ext.getCmp("price_level-panel-grid"));
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: 'Close',
             tooltip:'Close Price Level Management',
             iconCls: 'close',
             listeners:{
                 click:function(){
                     homePage();
                 }
             }
           }

    ]
})