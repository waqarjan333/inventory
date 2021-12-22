var test= {
                       xtype: 'fieldset',
                        title: "Unit of Meausre 3",
                        cls:'fieldset_text',
                        collapsible: true,
                        collapsed : true,
                        padding:10,
                        layout: 'column',
                        bodyBorder: false,
                        defaults: {
                            layout: 'anchor',
                            border: false,
                            defaults: {
                                anchor: '100%',
                                labelWidth: 80,
                            }
                        },
                        items:[{
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                items: [{
                                        xtype: 'combo',
                                        fieldLabel: "Unit",
                                        id: 'uom_combo_3',
                                        allowBlank: true,                                        
                                        forceSelection: true,
                                        name: 'uom_id_3',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: unit_store,
                                        value: '1',                                        
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                               
                                            }
                                        }
                                    },                                    
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 55
                                        },
                                        items: [
                                        {
                                            xtype:'textfield',
                                            fieldLabel:"Conv. 3",
                                            name:'base_conv_3',
                                            margin: '0 5 0 0',
                                            id:'_base_uom_conv_3',
                                            flex:2,              
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                  
                                                }
                                            } 
                                        },
                                        {
                                            xtype:'textfield',
                                            fieldLabel:"Dozen = ",
                                            name:'con_unit_3',
                                            margin: '0 5 0 0',
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            id:'_item_con_unit_3',
                                            flex:2,                                                     
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                  
                                                }
                                            } 
                                        }
                                        ]
                                    }
                                ]
                            },
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                items: [{
                                        xtype: 'textfield',
                                        fieldLabel: 'UPC',
                                        name: 'upc_unit_3',
                                        labelWidth: 55,
                                        id: 'upc_unit_3'
                                       },
                                       {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 55
                                        },
                                        items: [
                                        {   xtype: 'multiselect',                                            
                                            flex:1,
                                            height:50,
                                            fieldLabel: 'Lookups',
                                             queryMode: 'local',
                                            store: new Ext.data.Store({
                                                fields: ['id', 'name'],                                                
                                                data: [
                                                    
                                                ]
                                            }),
                                            valueField:'id',
                                            displayField:'name',
                                            id:'alt_lookup_unit_3',
                                            value : []
                                            
                                        },
                                        {
                                            xtype: 'container',
                                            margins: '0 4',
                                            layout: {
                                                type: 'vbox',
                                                pack: 'center'
                                            },
                                            items:[{
                                              xtype: 'button',
                                              tooltip: "Add Alternate Lookup",                                               
                                              iconCls: 'new',
                                              navBtn: true,                                            
                                              margin: '2 0 0 5'      
                                            },
                                            {
                                              xtype: 'button',
                                              tooltip: "Remove Alternate Lookup",                                                                                        
                                              iconCls: 'delete',
                                              navBtn: true,                                            
                                              margin: '4 0 0 5'      
                                            }
                                        ]
                                            
                                        }
                                        ]
                                    }
                                ]   
                            }
                            ,
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                items: [{
                                        xtype: 'textfield',
                                        fieldLabel: 'Qty on Hand',
                                        name: 'qty_on_hand_unit_3',
                                        id: 'qty_on_hand_unit_3',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                       {
                                        xtype: 'textfield',
                                        fieldLabel: 'Sale Price',
                                        name: 'sale_price_unit_3',
                                        id: 'sale_price_unit_3',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       }
                                       ,
                                       {
                                        xtype: 'textfield',
                                        fieldLabel: 'Avg Cost.',
                                        name: 'avg_cost_unit_3',
                                        id: 'avg_cost_unit_3',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       }
                                ]   
                            }
                            
                         ] 
                    } 