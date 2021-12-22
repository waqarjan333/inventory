({
    id: 'dashboard-panel',
    closable:true,
    closeAction:'hide',
    frame:true,
    title:labels_json.dashboardpanel.heading_title,
    listeners:{
        beforeclose:function(){
           homePage();
        },
        afterrender:function(){           
            
        },
        show:function(){
            OBJ_Action_chart = {};
            OBJ_Action_chart.saleChart= function(type){
                type = Ext.getCmp("best_sale_range").getValue();
                var params ={type_id:type,cur_datetime:Ext.Date.format(new Date(),'Y-m-d H:i:s')};
                 if(type=="1"){
                    params["cur_hour"] = (new Date()).getHours();
                 }
                 else if(type=="6"){
                    params["dur_day"] =7;   
                 }
                 else if(type=="7"){
                    params["dur_day"] =30;   
                 }
                 else if(type=="8"){
                    params["dur_day"] =60;   
                 }
                 else if(type=="9"){
                    params["dur_day"] =90;   
                 }
                 else if(type=="10"){
                    params["dur_day"] =365;   
                 }
                 Ext.Ajax.request({                        
                        url: action_urls.get_sale_chart,
                        params:params,
                        method:'GET',
                        success: function (response) {                            
                            var jObj = Ext.decode( response.responseText );                                        
                            if(jObj.data){
                                Ext.getCmp("barChart-dashboard").store.loadData(jObj.data);
                                
                            }else{
                                
                               Ext.getCmp("barChart-dashboard").store.loadData([{'xData':'No Data Found','yData':'0'}]);
                                
                            }
                        },
                        failure: function () {
                             LoadingMask.hideMessage();
                        }
                   });
            }
            OBJ_Action_chart.saleChart("2");
            
            OBJ_Action_chart.topProductChart= function(){
                var type = Ext.getCmp("top_product_range").getValue();
                var params ={type_id:type,cur_datetime:Ext.Date.format(new Date(),'Y-m-d H:i:s'),scale:Ext.getCmp("top_product_scale").getValue()};
               
                if(type=="1"){
                    params["cur_hour"] = (new Date()).getHours();
                 }
                 else if(type=="6"){
                    params["dur_day"] =7;   
                 }
                 else if(type=="7"){
                    params["dur_day"] =30;   
                 }
                 else if(type=="8"){
                    params["dur_day"] =60;   
                 }
                 else if(type=="9"){
                    params["dur_day"] =90;   
                 }
                 else if(type=="10"){
                    params["dur_day"] =365;   
                 }
                Ext.Ajax.request({                        
                    url: action_urls.get_product_chart,
                    params:params,
                    method:'GET',
                    success: function (response) {                            
                        var jObj = Ext.decode( response.responseText );                                        
                        if(jObj.data){
                            Ext.getCmp("topproducts-chart").store.loadData(jObj.data);

                        }else{

                           Ext.getCmp("topproducts-chart").store.loadData([{'xData':'No Data Found','yData':'0'}]);

                        }
                    },
                    failure: function () {
                         LoadingMask.hideMessage();
                    }
               });
            }
            
            OBJ_Action_chart.topProductChart()
            
            OBJ_Action_chart.topCustomerChart= function(){
                var type = Ext.getCmp("top_customer_range").getValue();
                var params ={type_id:type,cur_datetime:Ext.Date.format(new Date(),'Y-m-d H:i:s')};
               
                if(type=="1"){
                    params["cur_hour"] = (new Date()).getHours();
                 }
                 else if(type=="6"){
                    params["dur_day"] =7;   
                 }
                 else if(type=="7"){
                    params["dur_day"] =30;   
                 }
                 else if(type=="8"){
                    params["dur_day"] =60;   
                 }
                 else if(type=="9"){
                    params["dur_day"] =90;   
                 }
                 else if(type=="10"){
                    params["dur_day"] =365;   
                 }
                Ext.Ajax.request({                        
                    url: action_urls.get_customer_chart,
                    params:params,
                    method:'GET',
                    success: function (response) {                            
                        var jObj = Ext.decode( response.responseText );                                        
                        if(jObj.data){
                            Ext.getCmp("topcustomer-chart").store.loadData(jObj.data);

                        }else{

                           Ext.getCmp("topcustomer-chart").store.loadData([{'xData':'No Data Found','yData':'0'}]);

                        }
                    },
                    failure: function () {
                         LoadingMask.hideMessage();
                    }
               });
            }
            
            OBJ_Action_chart.topCustomerChart()
        }
        
    },
    layout: {
            type: 'vbox',
            pack: 'start',
            align: 'stretch'
        },
        defaults:{
            frame:false,
            border:false
        },
    items: [{
            flex: 5,            
            layout:'fit',            
            items:[{
                title:labels_json.dashboardpanel.text_sales,    
                margin:'5 5 5 5',                                             
                layout: {
                    type: 'table',                      
                    columns: 1,
                    tdAttrs: {
                        align: 'center',
                        valign: 'bottom'
                    },
                    tableAttrs:{
                        align: 'center'
                    }
                },
                defaults:{
                    border:false
                },
                items:[                
                 {
                   xtype:'combo',
                    tdAttrs: {
                        align: 'right'                      
                    },
                   displayField: 'name',
                   width: 300,
                   margin:'10 0 0 0',
                   labelWidth: 40,                   
                   fieldLabel:'Date',
                   editable:false,
                   value:'2',
                   queryMode: 'local',
                   id:'best_sale_range',
                   valueField:'id', 
                   listeners:{
                        change:function(f,obj){                           
                           OBJ_Action_chart.saleChart(f.getValue());
                        }
                     },
                   store:{
                        proxy:{
                            type:"memory",
                            reader:{
                                type:"json"
                            }
                    },
                    model:Ext.define("dateModel", {
                        extend:"Ext.data.Model",
                        fields:[
                            "id",
                            "name"
                            ]
                    }) && "dateModel",
                    data:[{id:'1',name:'Today'},{id:'2',name:'This Week'},{id:'3',name:'This Month'},{id:'4',name:'This Quarter'},
                        {id:'5',name:'This Year'},{id:'6',name:'Last 7 Days'},{id:'7',name:'Last 30 Days'},{id:'8',name:'Last 60 Days'},{id:'9',name:'Last 90 Days'},{id:'10',name:'Last 365 Days'}
                    ]}
                },
                {                    
                    layout:'fit',   
                    width:790,
                    height:240,
                    items: Ext.create('widget.panel', {
                        layout: 'fit',
                        border:false,
                        bodyBoder:false,
                        items: {
                            id: 'barChart-dashboard',
                            xtype: 'chart',
                            style: 'background:#fff',
                            animate: true,
                            shadow: true,
                            store: Ext.create('Ext.data.JsonStore', {
                                                fields: ['xData', 'yData'],
                                                data: [
                                                       ]
                                             }),
                            axes: [{
                                type: 'Numeric',
                                position: 'left',
                                fields: ['yData'],
                                label: {
                                    renderer: Ext.util.Format.numberRenderer('0,0')
                                },
                                grid: true,
                                minimum: 0,
                                adjustMaximumByMajorUnit: true
                            }, {
                                type: 'Category',
                                position: 'bottom',
                                fields: ['xData']
                            }],
                            series: [{
                                type: 'column',
                                axis: 'left',
                                highlight: true,
                                tips: {
                                  trackMouse: true,
                                  width: 140,
                                  height: 28,
                                  renderer: function(storeItem, item) {
                                    this.setTitle(storeItem.get('xData') + ': ' + storeItem.get('yData') + ' Rs.');
                                  }
                                },
                                label: {
                                    display: 'insideEnd',
                                    'text-anchor': 'top',
                                    field: 'yData',
                                    renderer: Ext.util.Format.numberRenderer('0'),
                                    orientation: 'vertical',
                                    color: '#fff'
                                },
                                xField: 'xData',
                                yField: 'yData',
                                 renderer: function(sprite, record, attr, index, store) {                                                
                                    return Ext.apply(attr, {
                                        fill: "#519ed6"
                                    });
                                }
                            }]
                        }
                    })
                } 
            ]
          }]
        }, {
            flex: 4,
            layout:'fit',
            items:[{
                    margin:'0 5 5 5',                    
                    layout:'column',
                    border:false,
                    items:[{
                          margin:'0 5 0 0',  
                          columnWidth: 1/2,
                          title:labels_json.dashboardpanel.text_top_items,
                          layout: {
                            type: 'table',                      
                            columns: 2,
                            tdAttrs: {
                                align: 'center',
                                valign: 'bottom'
                            },
                            tableAttrs:{
                                align: 'center',
                                width:'100%'
                            }
                          },
                          defaults:{
                            border:false
                          },
                          items:[
                                {
                                xtype:'combo',
                                 tdAttrs: {
                                     align: 'left'                      
                                 },
                                displayField: 'name',
                                width: 200,
                                margin:'5 0 0 5',
                                labelWidth: 40,                   
                                fieldLabel:'',
                                valueField:'id',
                                editable:false,                                
                                value:'item_price',
                                id:'top_product_scale',
                                queryMode: 'local',
                                valueField:'id',
                                listeners:{
                                  change:function(f,obj){                           
                                    OBJ_Action_chart.topProductChart();
                                 }
                                },
                                store:{
                                     proxy:{
                                         type:"memory",
                                         reader:{
                                             type:"json"
                                         }
                                 },
                                 model:Ext.define("dateModel", {
                                     extend:"Ext.data.Model",
                                     fields:[
                                         "id",
                                         "name"
                                         ]
                                 }) && "dateModel",
                                 data:[{id:'item_price',name:'Amount'},{id:'item_quantity',name:'Units'}
                                 ]}
                           },{
                                xtype:'combo',
                                 tdAttrs: {
                                     align: 'right'                      
                                 },
                                displayField: 'name',
                                width: 200,
                                valueField:'id',
                                margin:'5 5 0 0',
                                labelWidth: 40,                   
                                fieldLabel:'',
                                editable:false,
                                valueField:'id',
                                id:'top_product_range',
                                value:'2',
                                listeners:{
                                    change:function(f,obj){                           
                                      OBJ_Action_chart.topProductChart();
                                    }
                                },
                                queryMode: 'local',
                                store:{
                                     proxy:{
                                         type:"memory",
                                         reader:{
                                             type:"json"
                                         }
                                 },
                                 model:Ext.define("dateModel", {
                                     extend:"Ext.data.Model",
                                     fields:[
                                         "id",
                                         "name"
                                         ]
                                 }) && "dateModel",
                                 data:[{id:'1',name:'Today'},{id:'2',name:'This Week'},{id:'3',name:'This Month'},{id:'4',name:'This Quarter'},
                                     {id:'5',name:'This Year'},{id:'6',name:'Last 7 Days'},{id:'7',name:'Last 30 Days'},{id:'8',name:'Last 60 Days'},{id:'9',name:'Last 90 Days'},{id:'10',name:'Last 365 Days'}
                                 ]}
                           },
                            {                    
                                layout:'fit',     
                                width:440,
                                height:200,
                                colspan:2,
                                tdAttrs: {
                                     align: 'center'
                                     
                                },
                                items: Ext.create('widget.panel', {
                                    layout: 'fit',
                                    border:false,
                                    bodyBoder:false,
                                    items: {
                                        id: 'topproducts-chart',
                                        xtype: 'chart',
                                        style: 'background:#fff',
                                        animate: true,
                                        shadow: true,
                                        store: Ext.create('Ext.data.JsonStore', {
                                                fields: ['xData', 'yData'],
                                                data: []
                                             }),
                                        axes: [{
                                            type: 'Numeric',
                                            position: 'bottom',
                                            fields: ['yData'],
                                            label: {
                                                renderer: Ext.util.Format.numberRenderer('0,0')
                                            },
                                            grid: true,
                                            minimum: 0,
                                            adjustMaximumByMajorUnit: true
                                        }, {
                                            type: 'Category',
                                            position: 'left',
                                            fields: ['xData']
                                        }],
                                        series: [{
                                            type: 'bar',
                                            axis: 'bottom',
                                            highlight: true,
                                            tips: {
                                                trackMouse: true,
                                                width: 140,
                                                height: 28,
                                                renderer: function(storeItem, item) {
                                                  this.setTitle( storeItem.get('yData') + (Ext.getCmp("top_product_scale").getRawValue()=="Amount"?" Rs.":" Unit"));
                                                }
                                            },
                                            label: {
                                              display: 'insideEnd',
                                               'text-anchor': 'middle',
                                                field: 'yData',
                                                renderer: Ext.util.Format.numberRenderer('0'),
                                                orientation: 'horizontal',
                                                color: '#333'
                                            },
                                            xField: 'xData',
                                            yField: ['yData'],
                                            renderer: function(sprite, record, attr, index, store) {
                                                return Ext.apply(attr, {
                                                    fill: '#94b272'
                                                });
                                            }
                                        }]
                                    }
                                })
                            } 
                           
                       ] 
                    },{
                        columnWidth: 1/2,
                        margin:'0 0 0 5',  
                        title:labels_json.dashboardpanel.text_top_customers,
                         layout: {
                            type: 'table',                      
                            columns: 1,
                            tdAttrs: {
                                align: 'center',
                                valign: 'bottom'
                            },
                            tableAttrs:{
                                align: 'center',
                                width:'100%'
                            }
                          },
                          defaults:{
                            border:false
                          },
                          items:[
                                {
                                xtype:'combo',
                                 tdAttrs: {
                                     align: 'right'                      
                                 },
                                displayField: 'name',
                                width: 200,
                                valueField:'id',
                                margin:'5 5 0 0',
                                labelWidth: 40,                   
                                fieldLabel:'',
                                editable:false,
                                value:'2',
                                queryMode: 'local',
                                id:'top_customer_range',
                                listeners:{
                                    change:function(f,obj){                           
                                      OBJ_Action_chart.topCustomerChart();
                                    }
                                },
                                store:{
                                     proxy:{
                                         type:"memory",
                                         reader:{
                                             type:"json"
                                         }
                                 },
                                 model:Ext.define("dateModel", {
                                     extend:"Ext.data.Model",
                                     fields:[
                                         "id",
                                         "name"
                                         ]
                                 }) && "dateModel",
                                 data:[{id:'1',name:'Today'},{id:'2',name:'This Week'},{id:'3',name:'This Month'},{id:'4',name:'This Quarter'},
                                     {id:'5',name:'This Year'},{id:'6',name:'Last 7 Days'},{id:'7',name:'Last 30 Days'},{id:'8',name:'Last 60 Days'},{id:'9',name:'Last 90 Days'},{id:'10',name:'Last 365 Days'}
                                 ]}
                           },
                            {                    
                                layout:'fit',     
                                width:440,
                                height:200,                                
                                tdAttrs: {
                                     align: 'center'
                                     
                                },
                                items: Ext.create('widget.panel', {
                                    layout: 'fit',
                                    border:false,
                                    bodyBoder:false,
                                    items: {
                                        id: 'topcustomer-chart',
                                        xtype: 'chart',
                                        style: 'background:#fff',
                                        animate: true,
                                        shadow: true,
                                        store: Ext.create('Ext.data.JsonStore', {
                                                fields: ['xData', 'yData'],
                                                data: []
                                             }),
                                        axes: [{
                                            type: 'Numeric',
                                            position: 'bottom',
                                            fields: ['yData'],
                                            label: {
                                                renderer: Ext.util.Format.numberRenderer('0,0')
                                            },
                                            grid: true,
                                            minimum: 0,
                                            adjustMaximumByMajorUnit: true
                                        }, {
                                            type: 'Category',
                                            position: 'left',
                                            fields: ['xData']
                                        }],
                                        series: [{
                                            type: 'bar',
                                            axis: 'bottom',
                                            highlight: true,
                                            tips: {
                                                trackMouse: true,
                                                width: 140,
                                                height: 28,
                                                renderer: function(storeItem, item) {
                                                  this.setTitle(storeItem.get('yData') + ' Rs.');
                                                }
                                            },
                                            label: {
                                              display: 'insideEnd',
                                               'text-anchor': 'middle',
                                                field: 'yData',
                                                renderer: Ext.util.Format.numberRenderer('0'),
                                                orientation: 'horizontal',
                                                color: '#333'
                                            },
                                            xField: 'xData',
                                            yField: ['yData'],
                                            renderer: function(sprite, record, attr, index, store) {
                                                return Ext.apply(attr, {
                                                    fill: '#CCCC99'
                                                });
                                            }
                                        }]
                                    }
                                })
                            } 
                           
                       ]
                    }]
		}]
        }]
})
