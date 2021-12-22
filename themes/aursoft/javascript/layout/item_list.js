_items_list={
    id: 'item-grid',
    layout: 'border',
    frame:true,
    closable:true,
    closeAction:'hide',
    title:labels_json.itemgrid.product_list,
    listeners:{
        beforeclose:function(){
           homePage();
        }
    },
    items:[{
            region:'north',
            height:115,
            items: new Ext.FormPanel({
                    layout:'anchor',
                    frame: false,
                    border:false,
                    id:'item-grid-form',
                    bodyBorder:false,
                    defaults: {
                            anchor: '100%',
                            margin:'5'
                    },
            items:[{
               xtype:'textfield',
               fieldLabel:labels_json.itemgrid.product_list_name,
               id:'item_name_list',
               name:'item_name_list'
            },
            {
               xtype:'textfield',
               fieldLabel:labels_json.itemgrid.text_description,
               id:'item_description_list'
            },
             {
               xtype:'combo',
               fieldLabel:labels_json.itemgrid.text_category,
               displayField: 'name',
               store: category_storeWithAll,
               queryMode: 'local',
               valueField:'id',
               value:'0',
               id:'item_category_list',
               typeAhead: true
            },{
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
                         text:labels_json.itemgrid.show_all,
                         style:'float:right',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("item-grid-grid").store.load();
                             }
                         }
                    },{
                         xtype:'button',
                         text:labels_json.itemgrid.text_search,
                         style:'float:right;margin-right:10px',
                         width:80,
                         listeners:{
                             click:function(){
                               Ext.getCmp("item-grid-grid").store.load({
                                   params:{search:'1',
                                   search_name:Ext.getCmp("item_name_list").getValue(),
                                   search_category:Ext.getCmp("item_category_list").getValue()
                                  }
                               });
                             }
                         }
                    }]
                }]
                
            }
            ]})
        },{
            region:'center',
            layout:'fit',
            border:false,                
            bodyBorder:false,            
            items:[{xtype:"gridpanel",
                    id:"item-grid-grid",
                   loadMask: true,
                     store:{
                        proxy:{
                            type:"ajax",
                            url: action_urls.get_items,
                            reader:{
                                type:"json",
                                root: 'items',
                                idProperty: 'id',
                                totalProperty: 'totalCount'
                            }
                    },
                    buffered: true,
                    leadingBufferZone: 300,
                    pageSize: 100,
                    model:Ext.define("itemModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            "item_status",
                            "item_status_id",
                            "item",
                            "nprice",
                            "category",
                            "sprice",
                            "type",
                            "id"
                            ]
                    }) && "itemModel",
                    autoLoad:true
          },
          listeners:{
            afterRender : function(cmp) {
                //this.superclass.afterRender.call(this);
                var jstore = cmp.store; 
                jstore.on('load', function(store, records, successful,operation, options) {
                   var loadJsonData = {"type":'',"category":'',"item":'',"nprice":'',"sprice":'',"id":''};
                   //createEmptyRows(store,loadJsonData);
                });
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                    }
                });
            }  ,itemdblclick:function(v,r,item,index,e,args){
                editItem.id = r.get("id");
                getPanel(json_urls.items,'item-panel');
            }

          },

          columnLines: true,
          columns:[
            {header:labels_json.itemgrid.text_status,dataIndex:"item_status",width:120,renderer:function(v,r){
              // console.log(r.record.data.item_status_id);
                  var status=r.record.data.item_status_id;
                    var html = '';

                    if(status!=''){
                        html ='<div class="'+((status=='1')?'activate':'deactivate')+' _grid_icon1">'+v+'</div>'
                    }
                    return html;
            }},
            {header:labels_json.itemgrid.heading_title,dataIndex:"item",flex:1},
            {header:labels_json.itemgrid.text_category,dataIndex:"category",width:120},
            {header:labels_json.itemgrid.text_normal,dataIndex:"nprice",width:80},
            {header:labels_json.itemgrid.text_sale,dataIndex:"sprice",width:80}
            
            
            ]
          }]
        }]
}