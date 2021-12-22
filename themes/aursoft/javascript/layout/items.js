_items={
    id: 'item-panel',
    layout: 'border',
    closable:true,
    closeAction:'hide',
    frame:true,
    title:labels_json.itempanel.text_name,
    listeners:{
        beforeclose:function(){
            homePage();
            
        },
        beforerender: function () {
            vendor_store.load();
            if(enableUom==0)
            {
                Ext.getCmp("uom1_collapes").hide();
                Ext.getCmp("uom2_collapes").hide();
                Ext.getCmp("uom3_collapes").hide();
            }
           
            
             
       
        },
        afterrender:function(){
                  // unit_store.load();  
                Ext.getCmp("itemNameExtra").setVisible(false);
            

            // addUnitWindow = Ext.create('widget.window', {
            //     title: 'Add/Update Unit',
            //     width: 350,
            //     height: 120,
            //     id:'new_unit_form',
            //     minWidth: 300,
            //     minHeight: 100,
            //     layout: 'fit',
            //     closeAction: 'hide',
            //     modal: true,
            //     listeners: {
            //         afterrender:function(){
                    
            //         var unit_form = new Ext.util.KeyMap("new_unit_form", [
            //             {
            //                 key: [10,13],
            //                 fn: function(){ 
            //                     Ext.getCmp("save_unit").fireHandler();
            //                 }
            //             }
            //         ]);  
            //     },
            //         show: function () {
            //             var me = this.down('form').getForm();
            //             if (winMode && winMode > 0) {
            //                 var selectionModel = Ext.getCmp("unit-grid").selModel.getSelection()[0];
            //                 me.findField('unit_name').setValue(selectionModel.get("name"));
            //                 me.findField('unit_hidden_id').setValue(selectionModel.get("id"));
            //                 me.findField("unit_name").focus(true,100);
            //             } else {
            //                 me.reset();
            //                 me.findField('unit_hidden_id').setValue(0);
            //                 me.findField("unit_name").focus(true,100);
            //             }
            //         }
            //     },
            //     items: Ext.create('Ext.form.Panel', {
            //         url: 'save-form.php',
            //         bodyStyle: 'padding:5px 5px 0',
            //         fieldDefaults: {
            //             msgTarget: 'side',
            //             labelWidth: 75
            //         },
            //         defaults: {
            //             anchor: '100%'
            //         },
            //         items: [
            //             {
            //                 xtype: 'fieldset',
            //                 title: 'UoM',
            //                 collapsible: false,
            //                 hidden: false,
            //                 defaultType: 'textfield',
            //                 cls: 'fieldset_text_username',
            //                 layout: 'anchor',
            //                 defaults: {
            //                     anchor: '100%',
            //                     labelWidth: 100
            //                 },
            //                 items: [
            //                     {
            //                         xtype: 'textfield',
            //                         id: 'aur_unitname',
            //                         name: 'unit_name',
            //                         fieldLabel: 'New Unit',
            //                         emptyText: 'Enter unit name',
            //                         allowBlank: false
            //                     }

            //                 ]
            //             }, {
            //                 xtype: 'hidden',
            //                 name: 'unit_hidden_id',
            //                 id: 'unit_hidden_id',
            //                 value: '0'
            //             }
            //         ],
            //         buttons: [{
            //                 text: 'Save',
            //                 id:'save_unit',
            //                 handler: function () {
            //                     console.log('Save Units')
            //                     if (this.up('form').getForm().isValid()) {
            //                         LoadingMask.showMessage('Please wait..');
            //                         this.up('form').getForm().submit({
            //                             clientValidation: true,
            //                             url: action_urls.save_update_unit,
            //                             params: {
            //                             },
            //                             success: function (form, action) {
            //                                 LoadingMask.hideMessage();
            //                                 // if (unit_store.load) {
            //                                     unit_store.load();
            //                                     unit_store_1.load()

            //                                 // }
            //                                 addUnitWindow.hide();
            //                             },
            //                             failure: function (form, action) {
            //                                 LoadingMask.hideMessage();
            //                                 failureMessages(form, action);

            //                             }
            //                         });
            //                     }
            //                 }
            //             }, {
            //                 text: 'Cancel',
            //                 handler: function () {
            //                     this.up('form').getForm().reset();
            //                     this.up('window').hide();

            //                 }
            //             }]
            //     })

            // });
            Ext.getCmp("_item_reorder_point").setDisabled(true);

            cattree_store.on("load",function(){
                Ext.getCmp("cat_form_tree").setHeight(300);

                
            }); 
            category_form = Ext.widget('window', {
                title: labels_json.itempanel.manage_cat,
                width: 530,
                height:450,
                minHeight: 400,
                closeAction:'hide',
                layout: 'fit',
                resizable: true,
                modal: true,
                listeners:{
                    show:function(){
                        var me = this.down('form').getForm();
                        me.reset();
                        Ext.get("style_div")
                    }
                },
                items: Ext.widget('form', {
                    layout: {
                        type: 'vbox',
                        align: 'stretch'
                    },
                    border: false,
                    bodyPadding: 10,

                    fieldDefaults: {
                        labelAlign: 'top',
                        labelWidth: 100,
                        labelStyle: 'font-weight:bold'
                    },
                    defaults: {
                        margins: '0 0 10 0'
                    },
                    items: [ {
                        xtype: 'textfield',
                        fieldLabel: labels_json.itempanel.text_new_cat,
                        name:'category_name',
                        id:'new_category_name',
                        allowBlank: false
                    },{
                        xtype:'treepanel',
                        height: 300,                          
                        title:labels_json.itempanel.text_categories,
                        rootVisible: true,                            
                        id:'cat_form_tree',
                        useArrows: false,
                        collapsible: false,
                        singleExpand: false,
                        searchable:true,
                        store:  cattree_store,      
                        listeners:{
                            itemclick: {
                                fn: function(view, record, item, index, event) {                                                                                                                       
                                }
                            },
                            beforeitemcollapse:{
                                fn:function(node){                                       
                                    return false;
                                }
                            }
                               
                        },
                        tbar: [
                               
                        {
                            xtype: 'button', 
                            text:labels_json.itempanel.text_delete, 
                            iconCls: 'delete',
                            listeners:{
                                click:function(){
                                    if(OBJ_Action.checkCategorySelection()){
                                        var selection = OBJ_Action.checkCategorySelection();
                                        Ext.Ajax.request({
                                            url: action_urls.delete_category,
                                            params:{
                                                id:selection[0].get("id"),
                                                parent_id:selection[0].get("parent_id")
                                            },
                                            success: function (response) {
                                                Ext.getCmp("cat_form_tree").getRootNode().removeAll();
                                                Ext.getCmp("_item_cat_tree").getRootNode().removeAll();
                                                Ext.getCmp("_item_cat_tree").expandAll();
                                                Ext.getCmp("cat_form_tree").expandAll();
                                                cattree_store.load();      
                                            },
                                            failure: function () {}
                                        });
                                    }
                                }
                            }
                        }
                    ],
                    columns: [{
                        xtype: 'treecolumn', 
                        text: labels_json.itempanel.text_catname,
                        flex: 1,
                        sortable: false,
                        dataIndex: 'name'
                    },{
                        text:labels_json.itempanel.text_catdesc,
                        flex: 2,
                        dataIndex: 'description',
                        sortable: false
                    }]
                            
                            
                }
                ],

                buttons: [{
                    text: labels_json.itempanel.text_save,
                    handler: function() {
                        if (this.up('form').getForm().isValid()) {
                            LoadingMask.showMessage('Please wait..');
                            var tree_selection=Ext.getCmp("cat_form_tree").getSelectionModel().getSelection();
                            var parent_cat_id = tree_selection.length?tree_selection[0].get("id"):"1";                                 
                            this.up('form').getForm().submit({
                                clientValidation: true,
                                url: action_urls.save_item_category,
                                params: {
                                    cat_parent_id:parent_cat_id    
                                },
                                success: function(form, action) {
                                    LoadingMask.hideMessage();
                                    if(action.result.success){
                                        if(action.result.data)
                                        {
                                            var me = category_form.down("form").getForm();
                                            me.reset();
                                            category_store.loadData(action.result.data);
                                            category_store.insert(0,{
                                                "id":"-1",
                                                "name":"Add New Category..."
                                            });
                                            Ext.getCmp("cat_form_tree").getRootNode().removeAll(); 
                                            Ext.getCmp("_item_cat_tree").getRootNode().removeAll();
                                            cattree_store.load();                                                    
                                                    
                                        }

                                    //category_form.hide();
                                    }
                                            
                                },
                                failure: function(form, action) {
                                    LoadingMask.hideMessage();
                                    failureMessages(form, action);
                                            
                                }
                            });
                                    
                        }
                    }
                },{
                    text: labels_json.itempanel.text_cancel,
                    handler: function() {
                        this.up('form').getForm().reset();
                        this.up('window').hide();
                    }
                }]
                })
            });
               
        style_form = Ext.widget('window', {
            title: labels_json.itempanel.text_style,
            width: 846,
            height:525,
            minHeight: 400,
            closeAction:'hide',
            layout: 'fit',
            resizable: false,
            modal: true,
            listeners:{
                show:function(){                            
                    var me = this.down('form').getForm();
                    me.reset();           
                    Ext.getCmp("style_item_name").setValue(Ext.getCmp("_item_name").getValue());
                    var val = "",editcls;
                    if(OBJ_Action.mapping){
                        return false;
                    }
                    Ext.get("style_div").select(".main-container .top-header div").each(function(){
                        this.destroy()
                    });
                    Ext.get("style_div").select(".main-container .bottom-footer div").each(function(){
                        this.destroy()
                    });
                    ;
                    Ext.get("style_div").select(".main-container .left-header div").each(function(){
                        this.destroy()
                    });
                    ;
                    Ext.get("style_div").select(".main-container .right-header div").each(function(){
                        this.destroy()
                    });
                    ;
                    Ext.get("style_div").select(".main-container .data-container div").each(function(){
                        this.destroy()
                    });
                    Ext.get("style_div").select(".main-container .left-header,.main-container .data-container,.main-container .right-header").setStyle("top","0px");
                    Ext.get("style_div").select(".main-container .top-header,.main-container .data-container,.main-container .bottom-footer").setStyle("left","0px")
                            
                    for(var i=1;i<=50;i++){
                                
                        if(i<3){                                    
                            val =(i==1)?"&lt;Blank&gt;":"Click to Add";                                                                       
                            editcls = "editme";
                        }
                        else{
                            val="";
                            editcls = "";
                        }
                        var _display = "inline-block";
                        Ext.get("style_div").select(".main-container .top-header").appendChild({
                            tag:"div",
                            style:'display:'+_display,
                            cls:"block light-gray "+editcls,
                            id:"top_"+i,
                            html:val
                        })
                        Ext.get("style_div").select(".main-container .bottom-footer").appendChild({
                            tag:"div",
                            style:'display:'+_display,
                            cls:"block dark-gray",
                            id:"bottom_"+i,
                            html:""
                        })
                    }
                    for(var i=1;i<=50;i++){
                        if(i<3){                                    
                            val =(i==1)?"&lt;Blank&gt;":"Click to Add";                                                                       
                            editcls = "editme";
                        }
                        else{
                            val="";
                            editcls = "";
                        }
                        var _display = "inline-block";
                        Ext.get("style_div").select(".main-container .left-header").appendChild({
                            tag:"div",
                            style:'display:'+_display,
                            cls:"block light-gray "+editcls,
                            id:"left_"+i,
                            html:val
                        })
                        Ext.get("style_div").select(".main-container .right-header").appendChild({
                            tag:"div",
                            style:'display:'+_display,
                            cls:"block dark-gray",
                            id:"right_"+i,
                            html:""
                        })
                    }
                    var c=1,r=1;
                    for(var i=1;i<=2500;i++){     
                        var edit_class = (c==1 && r==1)?"editme":"";                                
                        Ext.get("style_div").select(".main-container .data-container").appendChild({
                            tag:"div",
                            cls:"block light-gray "+edit_class,
                            id:"cell_"+r+"_"+c,
                            html:""
                        })                                                                
                        c++;
                        if(i%50==0){
                            r++;
                            c=1;
                        }
                    }
                    var top_header_count = function(){
                        return Ext.get("style_div").select(".main-container .top-header .editme").getCount();
                    }
                    var left_header_count = function(){
                        return Ext.get("style_div").select(".main-container .left-header .editme").getCount();
                    }
                    var scrollDown = function(e,t){
                        var move = t ?!Ext.get(t).hasCls("jspDisabled"):true;
                        if(move){                                        
                            var cur_pos = -1*parseInt(Ext.get("style_div").select(".main-container .left-header").elements[0].style.top);
                            cur_pos = cur_pos + 24;
                            if(cur_pos<888){
                                Ext.get("style_div").select(".main-container .left-header,.main-container .data-container,.main-container .right-header").setStyle("top","-"+cur_pos+"px")
                            }
                            if(cur_pos>=24){
                                Ext.get("sizingForm-innerCt").select(".jspArrowUp").removeCls("jspDisabled") 
                            }
                        }
                    }
                    var scrollUp = function(e,t){
                        if(!Ext.get(t).hasCls("jspDisabled")){
                            var cur_pos = parseInt(Ext.get("style_div").select(".main-container .left-header").elements[0].style.top);
                            cur_pos = cur_pos + 24;
                            Ext.get("style_div").select(".main-container .left-header,.main-container .data-container,.main-container .right-header").setStyle("top",cur_pos+"px")
                            if(cur_pos==0){
                                Ext.get("sizingForm-innerCt").select(".jspArrowUp").addCls("jspDisabled") 
                            }
                            else{
                                Ext.get("sizingForm-innerCt").select(".jspArrowUp").removeCls("jspDisabled") 
                            }
                        }
                    }
                    var scrollRight = function(e,t){
                        var move = t?!Ext.get(t).hasCls("jspDisabled"):true
                        if(move){
                            var cur_pos = -1*parseInt(Ext.get("style_div").select(".main-container .top-header").elements[0].style.left);
                            cur_pos = cur_pos + 80;
                            if(cur_pos<3360){
                                Ext.get("style_div").select(".main-container .top-header,.main-container .data-container,.main-container .bottom-footer").setStyle("left","-"+cur_pos+"px");
                            }
                            if(cur_pos>=80){
                                Ext.get("sizingForm-innerCt").select(".jspArrowLeft").removeCls("jspDisabled") 
                            }
                                        
                        }
                    }    
                    var scrollLeft = function(e,t){
                        if(!Ext.get(t).hasCls("jspDisabled")){
                            var cur_pos = parseInt(Ext.get("style_div").select(".main-container .top-header").elements[0].style.left);
                            cur_pos = cur_pos + 80;                                        
                            Ext.get("style_div").select(".main-container .top-header,.main-container .data-container,.main-container .bottom-footer").setStyle("left",cur_pos+"px");
                            if(cur_pos==0){
                                Ext.get("sizingForm-innerCt").select(".jspArrowLeft").addCls("jspDisabled") 
                            }
                            else{
                                Ext.get("sizingForm-innerCt").select(".jspArrowLeft").removeCls("jspDisabled") 
                            }
                        }
                    }   
                    if(Ext.get("sizingForm-innerCt").select(".jspVerticalBar").getCount()==0){
                        var disable_right = top_header_count()>=8 ?"":"jspDisabled";
                        var disable_down = left_header_count()>=13 ?"":"jspDisabled";
                        Ext.get("sizingForm-innerCt").appendChild({
                            tag:"div",
                            cls:"jspVerticalBar",
                            html:'<div class="jspArrow jspDisabled jspArrowUp">ã</div><div class="jspTrack trackVertical"></div><div class="jspArrow '+disable_down+' jspArrowDown">ä</div>'
                            })
                        Ext.get("sizingForm-innerCt").appendChild({
                            tag:"div",
                            cls:"jspHorizontalBar",
                            html:'<div class="jspArrow jspDisabled jspArrowLeft">ç</div><div class="jspArrow '+disable_right+' jspArrowRight">ê</div>'
                            })
                        //Down arrow click handle
                        Ext.get("sizingForm-innerCt").select(".jspArrowDown").on("click",scrollDown)
                        //Up arrow click handle
                        Ext.get("sizingForm-innerCt").select(".jspArrowUp").on("click",scrollUp)
                        //Right arrow click handle
                        Ext.get("sizingForm-innerCt").select(".jspArrowRight").on("click",scrollRight)
                        //Left arrow click handle
                        Ext.get("sizingForm-innerCt").select(".jspArrowLeft").on("click",scrollLeft)
                    }
                    else{
                        Ext.get("sizingForm-innerCt").select(".jspArrowDown,.jspArrowUp,.jspArrowRight,.jspArrowLeft").addCls("jspDisabled");
                    }
                    var create_header = function(e,t){
                        var val =t.value;
                        if(val!==""){
                            var _div = Ext.get(t).findParent("div.editme");
                            if(Ext.get(t).findParent(".top-header") || Ext.get(t).findParent(".left-header")){
                                Ext.get(t).remove();
                                Ext.get(_div).update(val)
                                var header =_div.id.split("_")
                                var next_ele = Ext.get(header[0]+"_"+(parseInt(header[1])+1) );
                                if(next_ele && !next_ele.hasCls("editme")){
                                    next_ele.addCls("editme").update("Click to Add")
                                    var x = 1;
                                    if(header[0]=="top"){                                                
                                        while(Ext.get("cell_"+x+"_"+(parseInt(header[1])-1)).hasCls("editme") ){
                                            Ext.get("cell_"+x+"_"+header[1]).addCls("editme");                                                    
                                            x++;
                                        }
                                        if(top_header_count()-8>0){
                                            Ext.get("sizingForm-innerCt").select(".jspArrowRight").removeCls("jspDisabled"); 
                                            scrollRight();
                                        }
                                        else{
                                            Ext.get("sizingForm-innerCt").select(".jspArrowRight").addCls("jspDisabled");
                                        }
                                    }
                                    else if(header[0]=="left"){                                                
                                        while(Ext.get("cell_"+(parseInt(header[1])-1)+"_"+x).hasCls("editme") ){                                                    
                                            Ext.get("cell_"+header[1]+"_"+x).addCls("editme");
                                            x++;
                                        }
                                        if(left_header_count()-13>0){
                                            Ext.get("sizingForm-innerCt").select(".jspArrowDown").removeCls("jspDisabled"); 
                                            scrollDown();
                                        }
                                        else{
                                            Ext.get("sizingForm-innerCt").select(".jspArrowUp").addCls("jspDisabled");
                                        }
                                    }
                                }


                            }
                        }
                        else{
                            if(Ext.get(t).findParent(".top-header") || Ext.get(t).findParent(".left-header")){
                                Ext.get(t).remove();
                                var _div = Ext.get(t).findParent("div.editme");                                        
                            }
                        }
                    }
                    Ext.get("style_div").select(".main-container .light-gray").addListener('click', function(e,t) {
                        var obj = Ext.get(t.id);                                    
                        if(e.tagName!=="INPUT"){
                            if(obj.hasCls("editme")){
                                var _val = Ext.get(t).getHTML();
                                _val = (_val=="&lt;Blank&gt;" || _val=="Click to Add")?"":_val;
                                obj.update("")                                        
                                obj.appendChild({
                                    tag:"input",
                                    cls:"editme",
                                    type:"text",
                                    value:_val
                                })
                                obj.select("input.editme").focus();                                        
                                obj.select("input.editme").on("click",function(e,t){
                                    e.stopPropagation();
                                })                                        
                                obj.select("input.editme").on("keydown",function(e,t){
                                    if(e.getKey()==13){
                                        create_header(e,t);
                                    }                        
                                            
                                })
                                        
                                obj.select("input.editme").on("blur",create_header)
                                if(Ext.get(t).findParent(".data-container")){
                                    obj.select("input.editme").on("keyup",input_keyup)
                                }
                                        
                            }
                        }
                    })
                            
                    var input_keyup = function(e,t) {
                        var _div = Ext.get(t).findParent("div.editme");                                
                        var cell = _div.id.split("_");
                        var right_total = 0,bottom_total=0;
                        var x =1;
                        while(Ext.get("cell_"+cell[1]+"_"+x).hasCls("editme")){
                            if(Ext.get("cell_"+cell[1]+"_"+x).child("input")){ 
                                var _val = Ext.get("cell_"+cell[1]+"_"+x).select("input").elements[0].value;  
                                if(!isNaN(parseFloat(_val))){
                                    right_total = right_total + parseFloat(_val);
                                }
                            }
                            x++
                        }
                                
                        x =1;
                        while(Ext.get("cell_"+x+"_"+cell[2]).hasCls("editme")){
                            if(Ext.get("cell_"+x+"_"+cell[2]).child("input")){
                                var _val = Ext.get("cell_"+x+"_"+cell[2]).select("input").elements[0].value;  
                                if(!isNaN(parseFloat(_val))){
                                    bottom_total = bottom_total + parseFloat(_val);
                                }                                        
                            }
                            x++
                        }
                                
                        Ext.get("right_"+cell[1]).update(right_total)
                        Ext.get("bottom_"+cell[2]).update(bottom_total)
                    }
                            
                    if(Ext.getCmp("item_map_hidden_id").getValue()!="0"){
                        LoadingMask.showMessage('Please wait..');    
                        Ext.Ajax.request({
                            url: action_urls.get_mapping_items,
                            method:'GET',
                            params:{
                                mapping_id : Ext.getCmp("item_map_hidden_id").getValue()                                        
                            },
                            success: function (response) {
                                var data = Ext.JSON.decode(response.responseText);
                                var top_head=0,left_head=0;
                                for(var i=0;i<data.mapping_details.length;i++){
                                    var _id = data.mapping_details[i].cell_id.split("_");
                                    Ext.get(data.mapping_details[i].cell_id).addCls("editme").set({
                                        "edit_id":data.mapping_details[i].item_id
                                        });
                                    Ext.get(data.mapping_details[i].cell_id).appendChild({
                                        tag:"input",
                                        cls:"editme",
                                        type:"text",
                                        value:data.mapping_details[i].qty
                                        });
                                    Ext.get("left_"+_id[1]).update(data.mapping_details[i].left_head).addCls("editme");
                                    Ext.get("top_"+_id[2]).update(data.mapping_details[i].top_head).addCls("editme");
                                    if(parseInt(_id[1])>left_head){
                                        left_head = parseInt(_id[1]);
                                    }
                                    if(parseInt(_id[2])>top_head){
                                        top_head = parseInt(_id[2]);
                                    }
                                            
                                }
                                Ext.get("style_div").select(".main-container .data-container input.editme").on("keyup",input_keyup);
                                Ext.get("top_"+(top_head+1)).update("Click to Add").addCls("editme");
                                Ext.get("left_"+(left_head+1)).update("Click to Add").addCls("editme");
                                for(var c=1;c<=top_head;c++){
                                    var total = 0;
                                    for(var i=1;i<=left_head;i++){
                                        var _val = Ext.get("cell_"+i+"_"+c).select("input").elements[0].value;  
                                        total = total + parseInt(_val);
                                    }
                                    Ext.get("bottom_"+c).update(total);
                                }
                                for(var r=1;r<=left_head;r++){
                                    var total = 0;
                                    for(var i=1;i<=top_head;i++){
                                        var _val = Ext.get("cell_"+r+"_"+i).select("input").elements[0].value;  
                                        total = total + parseInt(_val);
                                    }
                                    Ext.get("right_"+r).update(total);
                                }
                                if(top_header_count()>=8){
                                    Ext.get("sizingForm-innerCt").select(".jspArrowRight").removeCls("jspDisabled");
                                }
                                        
                                if(left_header_count()>=13){
                                    Ext.get("sizingForm-innerCt").select(".jspArrowDown").removeCls("jspDisabled");                                            
                                }
                                        
                                        
                                LoadingMask.hideMessage();
                            },
                            failure: function () {
                                LoadingMask.hideMessage();
                            }
                        });
                    }
                    OBJ_Action.mapping = 1;
                }
            },
            items: Ext.widget({
                xtype: 'form',
                id: 'sizingForm',                                                                                 
                bodyPadding: '5 5 0',
                width: 600,
                fieldDefaults: {                                
                    msgTarget: 'side',
                    hideLabel:false                                
                },

                items: [{
                    xtype: 'container',
                    anchor: '100%',
                    layout: 'anchor',
                    items:[{
                        xtype:'textfield',
                        fieldLabel: labels_json.itempanel.heading_title,                                        
                        allowBlank: false,
                        cls:'style-input',
                        id : 'style_item_name',
                        readOnly:true,
                        name: 'item_name',
                        afterLabelTextTpl:'<span style="color:red;font-weight:bold" data-qtip="Required">*</span>',
                        anchor:'80%'
                                   
                    }]
                }, {
                    xtype: 'panel',
                    id: 'style_div',  
                    padding:'10 0 0 0',
                    style:'width:802px',
                    title:'Attributes ->',
                    height: 396,
                    width:802,                                
                    html:'<div class="main-container"><div class="left-top block dark-gray">Sizes</div><div class="left-bottom block dark-gray">Total</div><div class="right-bottom block dark-gray"></div><div class="right-top block dark-gray">Total</div><div class="slider-top-header"><div class="top-header"></div></div><div class="slider-left-header"><div class="left-header"></div></div><div class="slider-right-header"><div class="right-header"></div></div><div class="slider-bottom-footer"><div class="bottom-footer"></div></div><div class="slider-data-container"><div class="data-container"></div></div></div>'
                }],

                buttons: [{
                    text: labels_json.itempanel.text_save,
                    handler: function() {
                        if (this.up('form').getForm().isValid()) {
                            LoadingMask.showMessage('Please wait..');                                   
                            //Code to send save items call
                            var params = {
                                "items":""
                            };
                            var _items = [];
                            var init_name = "";
                            Ext.select(".data-container div.editme").each(function(){
                                var _id = this.getAttribute("id");
                                var _qty = this.select("input").getCount()?this.select("input").elements[0].value:"";
                                var edit_id = this.getAttribute("edit_id")?this.getAttribute("edit_id"):"0";
                                var form_values = Ext.getCmp("item-panel-form").getForm().getValues();
                                             
                                if(form_values.item_map_hidden_id =="0"){
                                    init_name = form_values.name?form_values.name:Ext.getCmp("style_item_name").getValue();
                                }
                                else{
                                    var name_array = form_values.name.split(" ");                                                
                                    init_name = name_array.splice(0,name_array.length-2).join(" ");
                                }
                                var _top = Ext.get("top_"+_id.split("_")[2]).getHTML();
                                var _left = Ext.get("left_"+_id.split("_")[1]).getHTML();
                                _items.push(Ext.apply(form_values,
                                {
                                    "id":_id,
                                    "top":_top,
                                    "left":_left,
                                    "quantity":_qty,
                                    "edit_id":edit_id,
                                    "item_hidden_id":edit_id,
                                    "item_color":_top,
                                    "item_size":_left,
                                    "entry_date":Ext.Date.format(new Date(),'Y-m-d H:i:s'),
                                    "name":init_name+" "+_top+" "+_left
                                    }))
                            })                                        
                            params["items"] = Ext.encode(_items);
                            params["map_id"] = Ext.getCmp("item_map_hidden_id").getValue();
                                        
                            //
                            this.up('form').getForm().submit({
                                clientValidation: true,
                                url: action_urls.save_items,
                                params:params,
                                success: function(form, action) {
                                    LoadingMask.hideMessage();
                                    if(action.result.success){                                                
                                        Ext.Object.each(action.result,function(key,value){
                                            if(key.indexOf("cell_")>-1){
                                                Ext.get(key).set({
                                                    "edit_id":value
                                                });
                                            }
                                        });
                                        if(Ext.getCmp("item_hidden_id").getValue()=="0"){    
                                            var newItemName = init_name+" " + Ext.get("top_1").getHTML() + " "+Ext.get("left_1").getHTML();
                                            Ext.getCmp("style_item_name").setValue(newItemName);
                                            Ext.getCmp("_item_name").setValue(newItemName)    
                                        }
                                        Ext.getCmp("item_map_hidden_id").setValue(action.result.map_id);    
                                        Ext.getCmp("item_hidden_id").setValue(action.result["cell_1_1"]);    
                                        style_form.hide();
                                    }                                            
                                },
                                failure: function(form, action) {
                                    LoadingMask.hideMessage();
                                    failureMessages(form, action);
                                            
                                }
                            });
                                    
                        }
                    }
                },{
                    text: labels_json.itempanel.text_cancel,
                    handler: function() {
                        this.up('form').getForm().reset();
                        this.up('window').hide();
                    }
                }]
            })
        });
    },
    show:function(){
        
        Ext.getCmp("item_tab_panel").setActiveTab(0);
        OBJ_Action.afterFailAciton=function(){
            Ext.getCmp("_item_name").markInvalid('Item already exists with same name.')  ;
        };            
        OBJ_Action.changeStatus=function(act_deactive,data){
            var btn_activate = Ext.getCmp("item_btn_activate");
            if(act_deactive==1){
                btn_activate.setIconCls('deactivate');
                btn_activate.setText(labels_json.itempanel.text_deactive);
                btn_activate.setTooltip(labels_json.itempanel.text_deactive_info);
            }
            else{
                btn_activate.setIconCls('activate');
                btn_activate.setText(labels_json.itempanel.text_active);
                btn_activate.setTooltip(labels_json.itempanel.text_active_info);
            }
            if(data){
                item_store.loadData(data.items);
            }
            
            
            var item_hidden_id = Ext.getCmp("item_hidden_id").getValue();
            Ext.getCmp("item_id").setValue(item_hidden_id);
            if(item_hidden_id!=0 || item_hidden_id!=""){
                Ext.getCmp('extra_info_panel').enable();
                Ext.getCmp('_item_quantity').enable();
                Ext.getCmp('_item_avgcost_show').disable();
                // Ext.getCmp('_item_nprice').disable();
                //Ext.getCmp('extra_info_panel_tab').setValue('Active');
               
            } else {
                    Ext.getCmp('extra_info_panel').disable();
               Ext.getCmp('_item_quantity').enable();
                Ext.getCmp('_item_avgcost_show').enable();
                Ext.getCmp('_item_nprice').enable();
               //Ext.getCmp('extra_info_panel_tab').setValue('Deactive'); 
               
            }
        }
        OBJ_Action.changeStatus(1);
        OBJ_Action.myfunc=function(id,data,img){
            Ext.getCmp("item_hidden_id").setValue(id);
            if(data){
                //item_store.loadData(data.items);                
            }
            if(img){
                OBJ_Action.setImage(img);
            }
        }
        OBJ_Action.upc_message = function(barcode, textfield){
            Ext.Msg.show({
            title:labels_json.itempanel.text_error,
            msg: labels_json.itempanel.text_this + '"' + barcode + '"' + labels_json.itempanel.text_already,
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR,
            fn: function (btn, text) {
            if (btn == 'ok') {
                Ext.getCmp(textfield).setValue("");
                Ext.getCmp(textfield).focus();
                }
              }
           });
        }
        OBJ_Action.makeService = function(t){
            if(t==3){
                Ext.getCmp("_item_nprice").setValue(0);
                Ext.getCmp("_item_income_id").setValue('5');
                Ext.getCmp("_item_nprice").setReadOnly(true);
                Ext.getCmp("so_purchase_fieldset").setVisible(false);
                Ext.getCmp("so_inventory_part").setVisible(true);
                Ext.getCmp("_item_partno").setVisible(false);
            }
            else{
                Ext.getCmp("_item_nprice").setValue('');
                Ext.getCmp("_item_nprice").setReadOnly(false);
                Ext.getCmp("so_purchase_fieldset").setVisible(true);
                Ext.getCmp("so_inventory_part").setVisible(true);
            }
        }
        OBJ_Action.resetItemUnit = function(uom){
            
            
            var item_id = Ext.getCmp("item_hidden_id").getValue();
            
            Ext.Ajax.request({
                url: action_urls.delete_uom_unit,
                method : 'POST',
                params:{"item_id":item_id,"uom":uom,"unit_id":Ext.getCmp("purchase_uom_combo").getValue()},
                success: function (response) {                                                                    
                    var result = Ext.decode( response.responseText);                                                 
                    alert(result.message);
                    Ext.getCmp("uom_combo_"+uom).setValue("");
                    Ext.getCmp("_base_uom_conv_"+uom).setValue("");
                    Ext.getCmp("_item_con_unit_"+uom).setValue("");

                    Ext.getCmp("upc_unit_"+uom).setValue("");
                    Ext.getCmp("alt_lookup_unit_"+uom).store.removeAll();

                    Ext.getCmp("qty_on_hand_unit_"+uom).setValue("");
                    Ext.getCmp("sale_price_unit_"+uom).setValue("");
                    Ext.getCmp("avg_cost_unit_"+uom).setValue("");
                    
                    Ext.getCmp("purchase_uom_combo").setValue(Ext.getCmp("sale_uom_combo").getValue());
                    Ext.getCmp("uom"+uom+"_collapes").collapse(true);
                },
                    failure: function () {}
                });
        }
        OBJ_Action.saveme= function(obj){
        var  base_lookup =   OBJ_Action.alt_lookup_unit({grid:'upc_basic_lookup'});
        var  uom_1_lookup =   OBJ_Action.alt_lookup_unit({grid:'alt_lookup_unit_1'});
        var uom_2_lookup  =  OBJ_Action.alt_lookup_unit({grid:'alt_lookup_unit_2'});
        var uom_3_lookup =    OBJ_Action.alt_lookup_unit({grid:'alt_lookup_unit_3'});
            
            var extra_info_panel_tab = Ext.getCmp("extra_info_panel_tab").getValue();
            if(extra_info_panel_tab=="Active"){
                
            var basic_uom_combo = Ext.getCmp('basic_uom_combo').getValue();
            var item_id = Ext.getCmp("item_id").getValue();
            var _base_uom_conv_1 = Ext.getCmp("_base_uom_conv_1");
            var _base_uom_conv_2 = Ext.getCmp("_base_uom_conv_2");
            var _base_uom_conv_3 = Ext.getCmp("_base_uom_conv_3");
        
        
            var uom_base_uom_id = Ext.getCmp("uom_base").getValue();
            var uom_1_uom_id = Ext.getCmp("uom_1").getValue();
            var uom_2_uom_id = Ext.getCmp("uom_2").getValue();
            var uom_3_uom_id = Ext.getCmp("uom_3").getValue();
        
        if(uom_base_uom_id=="" && basic_uom_combo!="" && item_id!="" ){
                Ext.getCmp("uom_base").setValue('0');
        }  
       
        if(uom_1_uom_id=="" && _base_uom_conv_1!="" && item_id!="" ){
             Ext.getCmp("uom_1").setValue('1');
        }
        
        if(uom_2_uom_id=="" && _base_uom_conv_2!="" && item_id!="" ){
             Ext.getCmp("uom_2").setValue('2');
        }
        
        if(uom_3_uom_id=="" && _base_uom_conv_3!="" && item_id!="" ){
             Ext.getCmp("uom_3").setValue('3');
        }
        
        var uom_base_mapping_id = Ext.getCmp("uom_base_mapping_id").getValue();
        var uom_1_mapping_id = Ext.getCmp("uom_1_mapping_id").getValue();
        var uom_2_mapping_id = Ext.getCmp("uom_2_mapping_id").getValue();
        var uom_3_mapping_id = Ext.getCmp("uom_3_mapping_id").getValue();
        
        
        Ext.getCmp("item-panel-form2").getForm().applyToFields({disabled:false});
        
        
        
        
        if(uom_base_mapping_id!="" || uom_1_mapping_id!="" || uom_2_mapping_id!="" || uom_3_mapping_id!="" || extra_info_panel_tab=="Active"){
            // console.log('working...uom')
            console.log(Ext.getCmp("item-panel-form2").getForm());
             LoadingMask.showMessage('Saving UOM...');
            Ext.getCmp("item-panel-form2").getForm().submit({
                url: action_urls.save_uom,
                params: { lookup_base: Ext.encode(base_lookup),lookup_1: Ext.encode(uom_1_lookup),lookup_2: Ext.encode(uom_2_lookup),lookup_3: Ext.encode(uom_3_lookup) },
                success: function(form, action) {
                   
        //Ext.getCmp('qty_on_hand').disable();
        //Ext.getCmp('upc_avg_cost').disable();
        if(Ext.getCmp("_base_uom_conv_1")==""){
           OBJ_Action.disabledd({status:'1'}); 
        } else {
        Ext.getCmp("qty_on_hand_unit_1").disable();
        Ext.getCmp("avg_cost_unit_1").disable();
       }
        if(Ext.getCmp("_base_uom_conv_2")==""){
            OBJ_Action.disabledd({status:'2'}); 
        } else {
        Ext.getCmp("qty_on_hand_unit_2").disable();
        Ext.getCmp("avg_cost_unit_2").disable();
       }
       if(Ext.getCmp("_base_uom_conv_3")==""){
            OBJ_Action.disabledd({status:'3'}); 
        } else {
        Ext.getCmp("qty_on_hand_unit_3").disable();
        Ext.getCmp("avg_cost_unit_3").disable();
       }
        LoadingMask.hideMessage();
        },
            failure: function(form, action) {
            failureMessages(form, action);
        }
                    });   
        } 
                
            } else {
                
            
            
            Ext.getCmp('extra_info_panel').enable();
            var item_barcode = Ext.getCmp("_item_barcode").getValue();
            var item_qty = Ext.getCmp("_item_quantity").getValue();
            var purcahse_price = parseFloat(Ext.getCmp("_item_nprice").getValue());
            var saleprice_price = parseFloat(Ext.getCmp("_item_sprice").getValue());
            
             
            
            Ext.getCmp('upc_basic').setValue(item_barcode);
            Ext.getCmp('qty_on_hand').setValue(item_qty);
            Ext.getCmp('upc_avg_cost').setValue(purcahse_price);
            Ext.getCmp('upc_sale_price').setValue(saleprice_price);
            
            if(saleprice_price < purcahse_price){
                Ext.Msg.show({
                    title:labels_json.itempanel.text_confirm,
                    msg: labels_json.itempanel.text_confirm_info,
                    buttons: Ext.Msg.YESNOCANCEL,
                    icon: Ext.Msg.QUESTION,
                    fn:function(btn,text){
                        if(btn=='yes'){
                           if(obj){
                            OBJ_Action.save(obj);
                           }
                           else{
                               OBJ_Action.save();
                           }
                        }
                    }
               });
           }
           else{
                if(obj){
                    OBJ_Action.save(obj); 
                   }
                   else{ 
                       OBJ_Action.save();
                   }
           }
           
       
        }
 
        }
        OBJ_Action.checkCategorySelection=function(){
            var isSelected = true;
            var tree_selection=Ext.getCmp("cat_form_tree").getSelectionModel().getSelection();
            if(tree_selection.length && tree_selection[0].get("id")!=="1"){
                isSelected = tree_selection;
            }
            else{
                Ext.Msg.show({
                    title:labels_json.itempanel.text_category,
                    msg: labels_json.itempanel.text_category_info,
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.ERROR
                });
                isSelected = false;
            }
            return isSelected;
        }
        OBJ_Action.clearOtherChanges=function(){          
            Ext.defer(function(){
                Ext.getCmp("_item_name").focus();                
                
            },50)
            OBJ_Action.setImage('');                
            OBJ_Action.mapping = 0;
            Ext.getCmp("_item_cat_id").setValue("Default");
            Ext.getCmp("item_cat_hidden_id").setValue("1");
            Ext.getCmp("_item_quantity").setDisabled(false);
            Ext.getCmp("cat_form_tree").getRootNode().removeAll();
            if(Ext.getCmp("_item_cat_tree")){
                Ext.getCmp("_item_cat_tree").getRootNode().removeAll();                
            }
            cattree_store.load();                                                    
        }
        OBJ_Action.setImage=function(img_path){
            if(img_path){
                document.getElementById("item_image_url").innerHTML = '<img src="'+img_path+'" class="item_img"  />';
                Ext.getCmp("item_image_path").setValue(img_path);
            }
            else{
                document.getElementById("item_image_url").innerHTML ="&nbsp;";
                Ext.getCmp("item_image_path").setValue("");
            }
                 
        } 
        OBJ_Action.editme=function(){
            
            if(editItem.id>0){                    
                LoadingMask.showMessage('Loading...');
                Ext.Ajax.request({
                        
                    url: action_urls.get_item_record,
                    params:{
                        item_id:editItem.id
                    },
                    method:'GET',
                    success: function (response) {
                        Ext.getCmp("_item_reorder_point").setDisabled(false);
                        //alert(Ext.getCmp("extra_info_panel_tab").getValue());

                       if(Ext.getCmp("extra_info_panel_tab").getValue()=="Active"){
                           Ext.getCmp("item-panel-form").getForm().reset();
                           Ext.getCmp("item-panel-form2").getForm().reset();
                           Ext.getCmp("extra_info_panel_tab").setValue("Active");
                       } else {
                           Ext.getCmp("item-panel-form").getForm().reset();
                           Ext.getCmp("item-panel-form2").getForm().reset();
                       }
                       
                        
                        Ext.getCmp("upc_basic_lookup").store.removeAll();
                        Ext.getCmp("alt_lookup_unit_1").store.removeAll();
                        Ext.getCmp("alt_lookup_unit_2").store.removeAll();
                        Ext.getCmp("alt_lookup_unit_3").store.removeAll();
                        
                        
                        if(Ext.getCmp("extra_info_panel_tab").getValue()=="Active")
                        OBJ_Action.combo_remove({status:'1'});
                         Ext.getCmp("itemNameExtra").setVisible(true);
                        
                        jObj = Ext.decode( response.responseText );
                        Ext.getCmp("item_hidden_id").setValue(jObj.item_id);
                        Ext.getCmp("_item_name").setValue(decodeHTML(jObj.item_name));
                        Ext.getCmp("itemNameExtra").setValue(decodeHTML(jObj.item_name));
                        
                        Ext.getCmp("_item_type").setValue(jObj.item_type);

                        OBJ_Action.makeService(parseInt(jObj.item_type));

                          if(jObj.preferd_vendor>0)
                        {
                         Ext.getCmp("_item_vender_id").setValue(jObj.preferd_vendor);   
                        }
                       
                       
                        //var c_path = cattree_store.getNodeById(jObj.item_cat_id).getPath('name'," → ").substr(5);                     
                        Ext.getCmp("item_cat_hidden_id").setValue(jObj.item_cat_id);
                        if(jObj.item_cat_id!=="1" && cattree_store.getNodeById(jObj.item_cat_id)){                            
                            var c_path = cattree_store.getNodeById(jObj.item_cat_id).getPath('name'," → ").substr(5);    
                            Ext.getCmp("_item_cat_id").setValue(c_path);
                            
                        }
                        else{
                            Ext.getCmp("_item_cat_id").setValue("Default");
                        }
                         
                        Ext.getCmp("_item_quantity").setValue(jObj.item_quantity);
                        if(parseInt(jObj.item_quantity)==0){
                            Ext.getCmp("_item_quantity").setDisabled(false);
                        }
                        else{
                            Ext.getCmp("_item_quantity").setDisabled(true);
                        }
                        //Ext.getCmp('extra_info_panel').enable();
                        Ext.getCmp("upc_basic").setValue(jObj.item_barcode);
                        Ext.getCmp("qty_on_hand").setValue(jObj.item_quantity);
                        Ext.getCmp("upc_avg_cost").setValue(jObj.item_nprice);
                        Ext.getCmp("upc_sale_price").setValue(jObj.item_sprice);

                        if(jObj.item_type==3){
                            Ext.getCmp('_item_nprice').disable();
                            Ext.getCmp('_item_avgcost').disable();
                            Ext.getCmp('_item_avgcost_show').setVisible(false);
                            Ext.getCmp("_item_quantity").disable();
                        } else {
                            Ext.getCmp('_item_nprice').enable();
                            Ext.getCmp('_item_avgcost').enable();
                            Ext.getCmp('_item_avgcost_show').enable();
                            Ext.getCmp("_item_quantity").enable();
                        }
                        Ext.getCmp("_item_nprice").setValue(jObj.item_nprice);
                        Ext.getCmp("_item_avgcost").setValue(jObj.item_avgcost);
                        Ext.getCmp("_item_avgcost_show").setValue(jObj.item_avgcost);
                        Ext.getCmp("_item_sprice").setValue(jObj.item_sprice);
                        Ext.getCmp("_item_partno").setValue(jObj.item_part_no);
                        if(jObj.item_vendor_id!="0"){
                            Ext.getCmp("_item_vender_id").setValue(jObj.item_vendor_id);
                        }
                        Ext.getCmp("upc_basic").setValue("");
                        Ext.getCmp("_item_unit").setValue(jObj.item_unit);
                        Ext.getCmp("item_map_hidden_id").setValue(jObj.item_map_id)
                        if(jObj.item_reorder_point){
                            Ext.getCmp("_item_reorder_point").setValue(jObj.item_reorder_point);
                        }
                        if(jObj.item_weight){
                            Ext.getCmp("_item_weight").setValue(jObj.item_weight);
                        }
                        
                        if(jObj.item_cogs_acc!=0){
                            Ext.getCmp("_item_COGS_id").setValue(jObj.item_cogs_acc);
                        }
                        if(jObj.item_sale_acc!=0){
                            Ext.getCmp("_item_income_id").setValue(jObj.item_sale_acc);
                        }
                        if(jObj.item_asset_acc!=0){
                            Ext.getCmp("_item_asset_id").setValue(jObj.item_asset_acc);
                        }
                         
                        if(jObj.item_color){
                            Ext.getCmp("_item_color").setValue(jObj.item_color);
                        }
                        if(jObj.item_size){
                            Ext.getCmp("_item_size").setValue(jObj.item_size);
                        }
                        if(jObj.item_brand){
                            Ext.getCmp("_item_brand").setValue(jObj.item_brand);
                        }
                         if(jObj.item_id){
                            Ext.getCmp("_item_id").setValue(jObj.item_id);
                        }
                        if(jObj.item_warehouses_reorder){
                            Ext.getCmp("_warehouse_hidden_qty").setValue(jObj.item_warehouses_reorder);
                        } 

                        Ext.getCmp("sale_uom_combo").store.removeAll();
                        Ext.getCmp("purchase_uom_combo").store.removeAll();
                        for(var i=0;i<jObj.item_units.length;i++){ 
                            Ext.getCmp("sale_uom_combo").store.add({id:jObj.item_units[i].unit_id,name:jObj.item_units[i].unit_name});
                            Ext.getCmp("purchase_uom_combo").store.add({id:jObj.item_units[i].unit_id,name:jObj.item_units[i].unit_name});
                        }
                           
                        
                        // Ext.getCmp("warehouse_reoder").store.removeAll();
                        //  for(var i=0;i<jObj.item_warehouses.length;i++){ 
                        //     Ext.getCmp("warehouse_name").setValue(jObj.item_warehouses[i].warehouse_name);
                           
                        // }
                        if(jObj.sale_unit){
                            Ext.getCmp("sale_uom_combo").setValue(jObj.sale_unit);
                        }
                        if(jObj.purchase_unit){
                            Ext.getCmp("purchase_uom_combo").setValue(jObj.purchase_unit);
                        }
                        /////////////////////////////
                        /////////Base Unit//////////
                        if(jObj.uom_base_mapping_id){
                            Ext.getCmp("uom_base_mapping_id").setValue(jObj.uom_base_mapping_id);
                            Ext.getCmp("qty_on_hand").disable();
                            Ext.getCmp("upc_avg_cost").disable();
                        }
                        if(jObj.uom_base_item_id){
                            Ext.getCmp("uom_base_item_id").setValue(jObj.uom_base_item_id);
                        }
                        if(jObj.uom_base_uom_id){
                            Ext.getCmp("uom_base").setValue(jObj.uom_base_uom_id);
                        }
                        if(jObj.uom_base_unit_id){
                            Ext.getCmp("basic_uom_combo").setValue(jObj.uom_base_unit_id);
                        }
                        if(jObj.uom_base_qty_on_hand){
                            Ext.getCmp("qty_on_hand").setValue(parseFloat(jObj.item_quantity).toFixed(2));
                        }
                        if(jObj.uom_base_sale_price){
                            Ext.getCmp("upc_sale_price").setValue(parseFloat(jObj.uom_base_sale_price).toFixed(2));
                        }
                        if(jObj.uom_base_avg_cost){
                            Ext.getCmp("upc_avg_cost").setValue(parseFloat(jObj.item_avgcost).toFixed(2));
                        }
                        
                        /////////////////////////////
                        ///////////UOM 1////////////
                        if(jObj.uom_1_mapping_id){
                           Ext.getCmp("uom1_collapes").expand(true);
                            Ext.getCmp("uom_1_mapping_id").setValue(jObj.uom_1_mapping_id);
                            Ext.getCmp("qty_on_hand_unit_1").setDisabled(true); 
                            Ext.getCmp("avg_cost_unit_1").setDisabled(true);
                        }else {
                           Ext.getCmp("uom1_collapes").collapse(true);
                           Ext.getCmp("_base_uom_conv_1").setDisabled(true);
                           Ext.getCmp("_item_con_unit_1").setDisabled(true);
                           Ext.getCmp("qty_on_hand_unit_1").setDisabled(true); 
                           Ext.getCmp("avg_cost_unit_1").setDisabled(true);
                           Ext.getCmp("upc_unit_1").setDisabled(true);
                        } 
                        if(jObj.uom_1_item_id){
                            Ext.getCmp("uom_1_item_id").setValue(jObj.uom_1_item_id);
                        }
                        if(jObj.uom_1_uom_id){
                            Ext.getCmp("uom_1").setValue(jObj.uom_1_uom_id);
                        }
                        if(jObj.uom_1_unit_id){
                            Ext.getCmp("uom_combo_1").setValue(jObj.uom_1_unit_id);
                        }
                        if(jObj.uom_1_conv_from){
                            Ext.getCmp("_base_uom_conv_1").setValue(jObj.uom_1_conv_from);
                        }
                        if(jObj.uom_1_conv_to){
                            Ext.getCmp("_item_con_unit_1").setValue(jObj.uom_1_conv_to);
                        }
                        if(jObj.uom_1_qty_on_hand){
                            Ext.getCmp("qty_on_hand_unit_1").setValue(parseFloat(jObj.item_quantity/jObj.uom_1_conv_from).toFixed(2));
                        }
                        if(jObj.uom_1_sale_price){
                            Ext.getCmp("sale_price_unit_1").setValue(parseFloat(jObj.uom_1_sale_price).toFixed(2));
                        }
                        if(jObj.uom_1_avg_cost){
                            Ext.getCmp("avg_cost_unit_1").setValue(parseFloat(jObj.item_avgcost*jObj.uom_1_conv_from).toFixed(5));
                        }
                        
                        /////////////////////////////
                        ///////////UOM 2////////////
                        if(jObj.uom_2_mapping_id){
                            Ext.getCmp("uom2_collapes").expand(true);
                            Ext.getCmp("uom_2_mapping_id").setValue(jObj.uom_2_mapping_id);
                            Ext.getCmp("qty_on_hand_unit_2").setDisabled(true); 
                           Ext.getCmp("avg_cost_unit_2").setDisabled(true);
                        }else {
                            Ext.getCmp("uom2_collapes").collapse(true);
                           Ext.getCmp("_base_uom_conv_2").setDisabled(true); 
                           Ext.getCmp("_item_con_unit_2").setDisabled(true);
                           Ext.getCmp("qty_on_hand_unit_2").setDisabled(true); 
                           Ext.getCmp("avg_cost_unit_2").setDisabled(true);
                           Ext.getCmp("upc_unit_2").setDisabled(true);
                        }
                        if(jObj.uom_2_item_id){
                            Ext.getCmp("uom_2_item_id").setValue(jObj.uom_2_item_id);
                        }
                        if(jObj.uom_2_uom_id){
                            Ext.getCmp("uom_2").setValue(jObj.uom_2_uom_id);
                        }
                        if(jObj.uom_2_unit_id){
                            Ext.getCmp("uom_combo_2").setValue(jObj.uom_2_unit_id);
                        }
                        if(jObj.uom_2_conv_from){
                            Ext.getCmp("_base_uom_conv_2").setValue(jObj.uom_2_conv_from);
                        }
                        if(jObj.uom_2_conv_to){
                            Ext.getCmp("_item_con_unit_2").setValue(jObj.uom_2_conv_to);
                        }
                        if(jObj.uom_2_qty_on_hand){
                            Ext.getCmp("qty_on_hand_unit_2").setValue(parseFloat(jObj.item_quantity/jObj.uom_2_conv_from).toFixed(2));
                        }
                        if(jObj.uom_2_sale_price){
                            Ext.getCmp("sale_price_unit_2").setValue(parseFloat(jObj.uom_2_sale_price).toFixed(2));
                        }
                        if(jObj.uom_2_avg_cost){
                            Ext.getCmp("avg_cost_unit_2").setValue(parseFloat(jObj.item_avgcost*jObj.uom_2_conv_from).toFixed(5));
                        }
                        
                        /////////////////////////////
                        ///////////UOM 3////////////
                        if(jObj.uom_3_mapping_id){
                            Ext.getCmp("uom3_collapes").expand(true);
                            Ext.getCmp("uom_3_mapping_id").setValue(jObj.uom_3_mapping_id);
                            Ext.getCmp("qty_on_hand_unit_3").setDisabled(true); 
                           Ext.getCmp("avg_cost_unit_3").setDisabled(true);
                        }else {
                            Ext.getCmp("uom3_collapes").collapse(true);
                           Ext.getCmp("_base_uom_conv_3").setDisabled(true); 
                           Ext.getCmp("_item_con_unit_3").setDisabled(true);
                           Ext.getCmp("qty_on_hand_unit_3").setDisabled(true); 
                           Ext.getCmp("avg_cost_unit_3").setDisabled(true);
                           Ext.getCmp("upc_unit_3").setDisabled(true);
                        }
                        if(jObj.uom_3_item_id){
                            Ext.getCmp("uom_3_item_id").setValue(jObj.uom_3_item_id);
                        }
                        if(jObj.uom_3_uom_id){
                            Ext.getCmp("uom_3").setValue(jObj.uom_3_uom_id);
                        }
                        if(jObj.uom_3_unit_id){
                            Ext.getCmp("uom_combo_3").setValue(jObj.uom_3_unit_id);
                        }
                        if(jObj.uom_3_conv_from){
                            Ext.getCmp("_base_uom_conv_3").setValue(jObj.uom_3_conv_from);
                        }
                        if(jObj.uom_3_conv_to){
                            Ext.getCmp("_item_con_unit_3").setValue(jObj.uom_3_conv_to);
                        }
                        if(jObj.uom_3_qty_on_hand){
                            Ext.getCmp("qty_on_hand_unit_3").setValue(parseFloat(jObj.item_quantity/jObj.uom_3_conv_from).toFixed(2));
                        }
                        if(jObj.uom_3_sale_price){
                            Ext.getCmp("sale_price_unit_3").setValue(parseFloat(jObj.uom_3_sale_price).toFixed(2));
                        }
                        if(jObj.uom_3_avg_cost){
                            Ext.getCmp("avg_cost_unit_3").setValue(parseFloat(jObj.item_avgcost*jObj.uom_3_conv_from).toFixed(5));
                        }
                        
                        ////////////////////////////////////////
                        ///////Base Unit UPC start ////////////
                        if(jObj.Uombase_upc){
                            Ext.getCmp("_item_barcode").setValue(jObj.Uombase_upc);
                            Ext.getCmp("upc_basic").setValue(jObj.Uombase_upc);
                        } else {
                            Ext.getCmp("_item_barcode").setValue(jObj.item_barcode);
                            Ext.getCmp("upc_basic").setValue(jObj.item_barcode);
                        }
                        if(jObj.Uom1_upc){
                            Ext.getCmp("upc_unit_1").setValue(jObj.Uom1_upc);
                        }
                        if(jObj.Uom2_upc){
                            Ext.getCmp("upc_unit_2").setValue(jObj.Uom2_upc);
                        }
                        if(jObj.Uom3_upc){
                            Ext.getCmp("upc_unit_3").setValue(jObj.Uom3_upc);
                        }
                        ////////////////////////////////////////
                        ///////Base Unit Lookup start //////////
                        OBJ_Action.edit_uom_lookup({status:jObj.Uombase_lookup,value:'upc_basic_lookup'});
                        OBJ_Action.edit_uom_lookup({status:jObj.uom_1_lookup,value:'alt_lookup_unit_1'});
                        OBJ_Action.edit_uom_lookup({status:jObj.uom_2_lookup,value:'alt_lookup_unit_2'});
                        OBJ_Action.edit_uom_lookup({status:jObj.uom_3_lookup,value:'alt_lookup_unit_3'});
                        
                        ////////////////////////////////////////
                        ///////////Base Unit Lookup End/////////
                        
                        
                        
                        OBJ_Action.setImage(jObj.item_picture);
                        OBJ_Action.changeStatus(jObj.item_status);
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
                Ext.getCmp("_item_quantity").setDisabled(false);
                Ext.getCmp("_item_nprice").setDisabled(false);
                Ext.getCmp("_item_cat_id").setValue("Default");
            }
            OBJ_Action.mapping = 0;
        }
            
        OBJ_Action.loadCategoryDialog=function(){
                
        }
        OBJ_Action.setImage('');
        OBJ_Action.editme();
            
        Ext.defer(function(){
            Ext.getCmp("_item_name").focus();                
                
        },50)
    }
},
items: [{
    region: 'west',
    width: 250,
    title:labels_json.itempanel.text_search,
    split: true,
    collapsible: true,
    collapsed:true,
    id:'item_left_panel',
    layout:'border',
    listeners:{
        expand:function()  {
            var jstore = Ext.getCmp("item-panel-grid").store;
            // jstore.load();
            Ext.defer(function(){Ext.getCmp("item_name_search").focus(true)},200); 
                var map_register = new Ext.util.KeyMap("item_left_panel", [
               {
                   key: [10,13],
                   fn: function(){ Ext.getCmp("item_search_btn").fireHandler();}
                   }
               ]);            
            if(Ext.getCmp('item_category_search').getValue()=="0"){   
                Ext.getCmp("category_search_tree").setValue("All");
                Ext.getCmp('item_category_search').setValue("0");   
            }
        }
    },
    items:[{
        region:'north',
        layout:'anchor',
        height:165,
        defaults: {
            anchor: '100%',
            margin:'5'
        },
        items:[
            {
                 xtype:'combo',
                fieldLabel:labels_json.itempanel.text_type,
                id:'_item_type_search',
                allowBlank: false,
                valueField:'type_id_search',
                displayField:'type_name_search',
                name:'item_type_search',
                value:'1',
                store: Ext.create('Ext.data.Store', {
                    fields: ['type_id_search', 'type_name_search'],
                    data : [
                    {
                        "type_id_search":"1", 
                        "type_name_search":"Stackable"
                    },

                    {
                        "type_id_search":"3", 
                        "type_name_search":"Service"
                    }
                    ]
                }),
                queryMode:'local',
                listeners:{
                    change:function(e,t){
                    }
                } 
            },
        {
            xtype:'textfield',
            fieldLabel:labels_json.itempanel.text_name,
            id:'item_name_search'
        },
        {
            xtype:'textfield',
            fieldLabel: labels_json.itempanel.text_bar_code,//labels_json.itempanel.text_description,
            id:'item_description_search',
            listeners:{
                change:function(){
                     Ext.getCmp("item-panel-grid").store.load({
                        params:{
                            search:'1',
                            search_name:Ext.getCmp("item_name_search").getValue(),
                            search_barcode:Ext.getCmp("item_description_search").getValue(),
                            search_category:Ext.getCmp("item_category_search").getValue(),
                            search_type:Ext.getCmp("_item_type_search").getValue()

                        }
                    });
                }
            } 
        },
        {
            xtype:'hidden',
            name:'cat_id',
            id:'item_category_search',
            value:'0'
        },
        
        {
            xtype:'pickerfield',
            fieldLabel:labels_json.itempanel.text_category,
            allowBlank: false,
            id:'category_search_tree',
            editable:false,
            typeAhead: true,
            autoScroll: false,
            createPicker: function() {
                return Ext.create('Ext.tree.Panel', {
                    floating: true,
                    minHeight: 300,
                    width:300,
                    height:300,
                    rootVisible: true,
                    collapsible: false,
                    id:'_item_cat_tree_search',
                    useArrows:false,                   
                    store:  cattree_store_with_all,
                    columns: [{
                        xtype: 'treecolumn', 
                        text:  labels_json.itempanel.text_name,
                        flex: 1,
                        sortable: false,
                        dataIndex: 'name'
                    }],
                    listeners:{
                        select: function(thisTree, record, index, obj ){                            
                            var selected_cat = "All";
                            if( record.data.id==1){
                                selected_cat = "Default";
                            }
                            else if(record.data.id!=-1){
                                selected_cat = record.getPath('name'," → ").substr(9);                            
                            }
                            Ext.getCmp('category_search_tree').setValue(selected_cat);
                            if(record.data.id!=-1){
                                Ext.getCmp('item_category_search').setValue(record.data.id);
                            }
                            else{
                                Ext.getCmp('item_category_search').setValue("0");
                            }
                            Ext.getCmp('category_search_tree').collapse();

                        },
                        render:function(){

                        }
                        ,
                        show:function(thisTree,obj){                              
                            var select_cat = Ext.getCmp("item_category_search").getValue();                                                                                                                              
                            var record = this.getStore().getNodeById(select_cat);
                            this.getSelectionModel().select(record);   
                        },                                                           
                        beforeitemcollapse:{
                            fn:function(node){                                       
                                return false;
                            }
                        }
                    }
                    });
            },
            listeners:{
                change:function(obj,n,o,e){
                    if(n==-1){
                        obj.setValue(o);

                    //category_form.show();
                    }            
                }
            } 
        }, {
                 xtype:'combo',
                fieldLabel:'Item Status',
                id:'_item_status_search',
                allowBlank: false,
                valueField:'status_id_search',
                displayField:'status_name_search',
                name:'item_status_search',
                value:'1',
                store: Ext.create('Ext.data.Store', {
                    fields: ['status_id_search', 'status_name_search'],
                    data : [
                    {
                        "status_id_search":"1", 
                        "status_name_search":"Activated"
                    },

                    {
                        "status_id_search":"0", 
                        "status_name_search":"Deactivated"
                    }
                    ]
                }),
                queryMode:'local',
                listeners:{
                    change:function(e,t){
                    }
                } 
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
                    text:labels_json.button_search_all,
                    style:'float:right',
                    width:80,
                    listeners:{
                        click:function(){
                            Ext.getCmp("item-panel-grid").store.load();
                        }
                    }
                },{
                    xtype:'button',
                    text:labels_json.button_search,
                    style:'float:right;margin-right:10px;',
                    width:80,
                    id:'item_search_btn',
                    listeners:{
                        click:function(){
                            Ext.getCmp("item-panel-grid").store.load({
                                params:{
                                    search:'1',
                                    search_name:Ext.getCmp("item_name_search").getValue(),
                                    search_barcode:Ext.getCmp("item_description_search").getValue(),
                                    search_category:Ext.getCmp("item_category_search").getValue(),
                                    search_type:Ext.getCmp("_item_type_search").getValue(),
                                    search_status:Ext.getCmp("_item_status_search").getValue()
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
        items:[{
            xtype:"gridpanel",
            id:"item-panel-grid",
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
                leadingBufferZone: 150,
                leadingBufferZone: 400,
                pageSize: 50,
                model:Ext.define("itemSearchModel", {
                    extend:"Ext.data.Model",
                    fields:[
                    "category",
                    "item",
                    "nprice",
                    "sprice",
                    "type",
                    "id"
                    ]
                }) && "itemSearchModel"
            },
            listeners:{
                afterRender : function(cmp) {
                    //this.superclass.afterRender.call(this);
                    var jstore = cmp.store; 
                    jstore.on('load', function(store, records, successful,operation, options) {
                        var loadJsonData = {
                            "type":'',
                            "category":'',
                            "item":'',
                            "nprice":'',
                            "sprice":'',
                            "id":''
                        };
                        //createEmptyRows(store,loadJsonData,16);
                    });
                    this.nav = new Ext.KeyNav(this.getEl(),{
                        del: function(e){
                        }
                    });
                },
                itemdblclick:function(v,r,item,index,e,args){
                    if(user_right==1){
                        editItem.id = r.get("id");
                        OBJ_Action.editme();
                    } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.item.actions.edit){ 
                            editItem.id = r.get("id");
                            OBJ_Action.editme();
                        } else {
                            Ext.Msg.show({
                                title:labels_json.itempanel.text_user_access,
                                msg:labels_json.itempanel.text_user_access_info,
                                buttons:Ext.Msg.OK,
                                callback:function(btn) {
                                    if('ok' === btn) {
                                    }
                                }
                            });
                        }
                    }
                },
                beforeprefetch: function(store, operation) {
                    if (operation.groupers && operation.groupers.length) {
                        delete operation.sorters;
                    }
                }
                
            },
            selModel: {
                pruneRemoved: false
            },
            multiSelect: true,
            columnLines: true,
            columns:[
            {
                header:labels_json.itempanel.col_item_category,
                dataIndex:"category",
                width:80,
                sortable: false
            },

            {
                header:labels_json.itempanel.col_item_item,
                dataIndex:"item",
                flex:1,
                sortable: false
            }
            ]
        }]
    }]
        
}, {
    region: 'center',
    xtype: 'tabpanel',
    id:'item_tab_panel',
    tabPosition:'bottom',
    
    items: [
        {
        title: labels_json.itempanel.text_tab_info,
        listeners:{
        show:function(){
            //alert('clicked');
            Ext.getCmp('extra_info_panel_tab').setValue("");
        var qty_on_hand = Ext.getCmp("qty_on_hand").getValue();
        var upc_basic = Ext.getCmp("upc_basic").getValue();
        var upc_avg_cost = Ext.getCmp("upc_avg_cost").getValue();
        var upc_sale_price = Ext.getCmp("upc_sale_price").getValue();
        
        Ext.getCmp('_item_barcode').setValue(upc_basic);
        Ext.getCmp('_item_quantity').setValue(qty_on_hand);
        Ext.getCmp('_item_nprice').setValue(upc_avg_cost);
        Ext.getCmp('_item_sprice').setValue(upc_sale_price);
        
        }
        },
        items: new Ext.FormPanel({
            layout:'column',
            frame: false,
            border:false,
            id:'item-panel-form',
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
                    title: labels_json.itempanel.text_basic,
                    cls:'fieldset_text',
                    collapsible: false,
                    padding:10,
                    layout:'anchor',
                    defaults: {
                        labelWidth: 110,
                        anchor: '100%',
                        layout: {
                            type: 'hbox',
                            defaultMargins: {
                                top: 0, 
                                right: 5, 
                                bottom: 0, 
                                left: 0
                            }
                        }
                    },
                    items:[
                    {
                        xtype:'combo',
                        fieldLabel:labels_json.itempanel.text_type,
                        id:'_item_type',
                        allowBlank: false,
                        valueField:'type_id',
                        displayField:'type_name',
                        name:'item_type',
                        value:'1',
                        store: Ext.create('Ext.data.Store', {
                            fields: ['type_id', 'type_name'],
                            data : [
                            {
                                "type_id":"1", 
                                "type_name":"Stackable"
                            },

                            {
                                "type_id":"3", 
                                "type_name":"Service"
                            }
                            ]
                        }),
                        queryMode:'local',
                        listeners:{
                            change:function(e,t){
                                OBJ_Action.recordChange();                                
                                OBJ_Action.makeService(t);
                                if (this.value == 1 ){
                                    Ext.getCmp('_item_income_id').bindStore(account_store);
                                }
                                else{
                                    Ext.getCmp('_item_income_id').bindStore(income_account_store);
                                }
                            }
                        } 
                    },
                    {
                        xtype:'textfield',
                        fieldLabel:labels_json.itempanel.text_name,
                        allowBlank: false,
                        id:'_item_name',
                        emptyText: labels_json.itempanel.text_name_placeholder,
                        name:'name',
                        validation:true,
                        enableKeyEvents:true,
                        listeners:{
                            change:function(){
                                OBJ_Action.recordChange();
                            },
                            blur:function()
                            {
                                if(this.getValue()!='')
                                {
                                    Ext.getCmp("itemNameExtra").setVisible(true);
                                    Ext.getCmp("itemNameExtra").setValue(this.getValue());
                                }
                            }
                        } 
                    },
                    {
                        xtype:'hidden',
                        name:'cat_id',
                        id:'item_cat_hidden_id',
                        value:'1'
                    },
                    {
                        xtype:'hidden',
                        name:'item_image_path',
                        id:'item_image_path',
                        value:'1'
                    },
                    {
                        xtype:'pickerfield',
                        fieldLabel:labels_json.itempanel.text_category,
                        allowBlank: false,
                        id:'_item_cat_id',
                        editable:false,
                        searchable:false,
                        typeAhead: true,
                        autoScroll: false,
                        createPicker: function() {
                            return Ext.create('Ext.tree.Panel', {
                                floating: true,
                                minHeight: 300,
                                height:300,
                                rootVisible: true,
                                collapsible: false,
                                id:'_item_cat_tree',
                                useArrows:false,
                                               
                                tbar: [
                                {
                                    xtype: 'button', 
                                    text: labels_json.itempanel.manage_cat, 
                                    iconCls: 'new',
                                    listeners:{
                                        click:function(){
                                            Ext.getCmp('_item_cat_id').collapse();
                                            category_form.show();
                                                            
                                        }
                                    }
                                }
                            ],
                        store:  cattree_store,

                            columns: [{
                                xtype: 'treecolumn', 
                                text:  labels_json.itempanel.text_name,
                                flex: 1,
                                sortable: false,
                                dataIndex: 'name'
                            },{
                                text: labels_json.itempanel.text_description,
                                flex: 2,
                                dataIndex: 'description',
                                sortable: false
                            }],
                            listeners:{
                                select: function(thisTree, record, index, obj ){
                                                            
                                    var selected_cat = record.getPath('name'," → ").substr(5);
                                    if(record.data.id==1){
                                        selected_cat = "Default";
                                    }
                                    Ext.getCmp('_item_cat_id').setValue(selected_cat);
                                    Ext.getCmp('item_cat_hidden_id').setValue(record.data.id);
                                    Ext.getCmp('_item_cat_id').collapse();
                                                            
                                },
                                render:function(){
                                                               
                                }
                                ,
                                show:function(thisTree,obj){
                                    var select_cat = Ext.getCmp("item_cat_hidden_id").getValue();                                                                                                                              
                                    var record = this.getStore().getNodeById(select_cat);
                                    this.getSelectionModel().select(record);                                                                                                                                                                                                
                                                           
                                },                                                           
                                beforeitemcollapse:{
                                    fn:function(node){                                       
                                        return false;
                                    }
                                }
                            }
                            });
                    },
                    listeners:{
                        change:function(obj,n,o,e){
                            if(n==-1){
                                obj.setValue(o);
                                                    
                            //category_form.show();
                            }
                            OBJ_Action.recordChange();
                        }
                    } 
                }
                                    
                                    
                ]
                           
            },{
                xtype: 'fieldset',
                title: labels_json.itempanel.text_inventory,
                cls:'fieldset_text',
                collapsible: false,
                id:'so_inventory_part',
                padding:'10 10 5 10',
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_part_no,
                    name:'part_number',                                       
                    id:'_item_partno',
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_qty_on_hand,
                    name:'quantity',                                       
                    id:'_item_quantity',
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    maxLength: 10,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_avgcost,
                    name:'avgcost_show',                                       
                    id:'_item_avgcost_show',
                    readOnly:true,
                    cls:'avgCostClass'
                    
                },
                {
                    xtype:'hidden',
                    name:'avgcost',                                       
                    id:'_item_avgcost',
                    readOnly:true,
                    cls:'avgCostClass'
                }
                                    
                                    
                ]
                          
            },{
                xtype: 'fieldset',
                title: labels_json.itempanel.text_bar_code,
                cls:'fieldset_text',
                collapsible: false,
                padding:'10 10 5 10',
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    xtype: 'fieldcontainer',
                    fieldLabel: labels_json.itempanel.text_bar_code,
                    combineErrors: true,
                    msgTarget : 'side',
                    layout: 'hbox',
                    defaults: {
                        hideLabel: true
                    },
                    items: [
                    {
                        xtype:'textfield',
                        fieldLabel:labels_json.itempanel.text_bar_code,
                        name:'barcode',
                        margin: '0 5 0 0',
                        id:'_item_barcode',
                        flex: 4,                                                     
                        enableKeyEvents:true,
                        listeners:{
                            change:function(){
                                OBJ_Action.recordChange();
                            }
                        } 
                    },
                    {
                        xtype:'button',
                        text:labels_json.itempanel.text_generate,   
                        flex: 1,
                        id:'barcode_new_btn',
                        width:80,
                        listeners:{
                            click:function(){                                                            
                                Ext.Ajax.request({
                                    url: action_urls.generate_item_barcode,
                                    params:{},
                                    success: function (response) {                                                                    
                                        var barcode_Obj = Ext.decode( response.responseText);
                                        Ext.getCmp("_item_barcode").setValue(barcode_Obj.code);  
                                        OBJ_Action.recordChange();
                                    },
                                    failure: function () {}
                                });   
                                                            
                            }
                        }
                    }
                    ]
                }
                                    
                                    
                ]
                          
            },
            {
                xtype: 'fieldset',
                title: labels_json.itempanel.text_purchase_info,
                cls:'fieldset_text',
                id:'so_purchase_fieldset',
                collapsible: false,
                padding:'10 10 5 10',
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_purchase_price,
                    name:'nprice',
                    maxLength: 10,
                    id:'_item_nprice',
                    allowBlank: false,
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                {
                    xtype:'combo',
                    fieldLabel:labels_json.itempanel.text_cogs_account,
                    displayField: 'acc_name',
                    name:'acc_cogs_id',
                    cls:'combo_for_add',
                    id:'_item_COGS_id',
                    store: account_store,
                    emptyText: labels_json.itempanel.text_cogsinfo,
                    queryMode: 'local',
                    valueField:'id',
                    value:'2',
                    allowBlank: false,
                    editable:false,
                    typeAhead: true,
                    listeners:{
                        change:function(obj,n,o,e){
                            if(n==-1){
                                account_selected_combo = obj.getId();
                                obj.setValue(o);
                                winMode =0;
                                account_form.show();
                            }
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                {
                    xtype:'combo',
                    fieldLabel:'Preffered Vendor',
                    displayField: 'vendor_name',
                    name:'acc_vendor_id',
                    cls:'combo_for_add',
                    //hidden:true,
                    id:'_item_vender_id',
                    store: vendor_store_active,
                    emptyText: 'Select preferred vendor',
                    queryMode: 'local',
                    valueField:'vendor_id',                                        
                    editable:false,
                    typeAhead: true,
                    listeners:{
                        change:function(obj,n,o,e){                            
                            OBJ_Action.recordChange();
                        }
                    } 
                }
                                   
                ]
                           
            },{
                xtype: 'fieldset',
                title: labels_json.itempanel.text_sales_info,
                cls:'fieldset_text',
                collapsible: false,
                padding:10,
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                                    
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_sales_price,
                    id:'_item_sprice',
                    name:'sprice',
                    maxLength: 11,                    
                    allowBlank: false,
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    } 
                },
                {
                    xtype:'combo',
                    fieldLabel:labels_json.itempanel.text_income_account,
                    displayField: 'acc_name',
                    name:'acc_income_id',
                    id:'_item_income_id',
                    store: account_store,
                    emptyText:labels_json.itempanel.text_accountinfo,
                    queryMode: 'local',
                    valueField:'id',
                    editable:false,
                    value:'5',
                    allowBlank: false,
                    typeAhead: true,
                    listeners:{
                        change:function(obj,n,o,e){
                            if(n==-2){
                                account_selected_combo = obj.getId();
                                // console.log(account_selected_combo);
                                obj.setValue(o);
                                winMode =0;
                                account_form.show();
                            }
                            OBJ_Action.recordChange();
                        }
                    } 
                },{
                    xtype:'hidden',
                    name:'warehouse_hidden_qty',
                    id:'_warehouse_hidden_qty',
                    value:'0'
                },{
                    xtype:'hidden',
                    name:'item_hidden_id',
                    id:'item_hidden_id',
                    value:'0'
                },{
                    xtype:'hidden',
                    name:'item_map_hidden_id',
                    id:'item_map_hidden_id',
                    value:'0'
                },
                {
                    xtype:'hidden',
                    name:'entry_date',
                    id:'item_entry_date',
                    value:''
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
                title: labels_json.itempanel.text_picture,
                cls:'fieldset_text',
                collapsible: false,
                padding:10,
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    xtype:'box',
                    autoEl:{
                        tag:'div',
                        html:'&nbsp;',
                        cls:'picture_box'
                    },
                    height:100,
                    id:'item_image_url',
                    margin:'0 0 0 0'
                },
                                     
                {
                    xtype: 'filefield',
                    name: 'item_image',
                    fieldLabel: labels_json.itempanel.text_upload_picture,
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
                title: labels_json.itempanel.text_inventory_info,
                cls:'fieldset_text',
                collapsible: false,
                padding:10,
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    xtype:'combo',
                    fieldLabel:labels_json.itempanel.text_asset_account,
                    displayField: 'acc_name',
                    name:'acc_asset_id',
                    id:'_item_asset_id',
                    store: account_store,
                    queryMode: 'local',
                    emptyText: labels_json.itempanel.text_assetinfo,
                    valueField:'id',
                    value:'1',
                    allowBlank: false,
                    editable:false,
                    typeAhead: true,
                    listeners:{
                        change:function(obj,n,o,e){
                            if(n==-1){
                                account_selected_combo = obj.getId();
                                obj.setValue(o);
                                winMode =0;
                                account_form.show();
                            }
                            OBJ_Action.recordChange();
                        }
                    } 
                }
                ]

            },
            {
                xtype: 'fieldset',
                title: labels_json.itempanel.text_storage_info,
                cls:'fieldset_text',
                collapsible: false,
                padding:10,
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                 {
                    xtype: 'hidden',
                    name: 'item_id',
                    id: '_item_id',
                    value: '0'
                    },
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_reorder_point,
                    name:'reorder_point',
                    id:'_item_reorder_point',
                    allowBlank: true,
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        },
                           render: function() {
                this.getEl().on('dblclick', function(e, t, eOpts) {
                     Ext.define('User', {
                            extend: 'Ext.data.Model',
                            fields: [{
                                name: 'warehouse_id',
                                type: 'string'
                            }, {
                                name: 'reorder_qty',
                                type: 'string'
                            }, {
                                name: 'warehouse_name',
                                type: 'string'
                            }]
                        });
                            var warehouse_url=0;
                         var item_id= Ext.getCmp("_item_id").getValue();
                         var warehouse_qty_reorder= Ext.getCmp("_warehouse_hidden_qty").getValue();
                         if(warehouse_qty_reorder==0)
                         {
                            warehouse_url=1;
                         }
                         else{
                          warehouse_url=2;  
                         }

                        var warehouse_store_reoder = new Ext.data.Store({

                            model: 'User',
                            proxy: {
                               type:"ajax",
                               extraParams:{
                                  item_id:item_id,
                                  warehouse_url:warehouse_url
                                            },
                                url: action_urls.get_item_warehouse_reorder_qty,
                                reader: {
                                    type: 'json',
                                    root: 'reorder'
                                }
                            }
                        });
                    warehouse_store_reoder.load();
                    var myForm = new Ext.form.Panel({
                               region:'center',
                             layout:'fit',
                            width: 300,
                            height: 200,
                            title: labels_json.itempanel.text_warehouse_reorder,
                            id:'warehouse_reoder',
                            floating: true,
                            closable : true,
                            items:[{
                                 xtype:"gridpanel",
                                id:"reorder-panel-grid",
                                loadMask: true,
                                  plugins: [Ext.create('Ext.grid.plugin.CellEditing', {
                        clicksToEdit: 2,
                        listeners:{

                           // afterrender:function(){
                           //  alert()
                           //   // Ext.Ajax.request({
                           //   //              url: action_urls.get_item_warehouse_reorder_qty,
                           //   //              method:'POST',
                           //   //              params:{
                           //   //                  item_id:item_id,                                    
                           //   //                      },
                           //   //              success: function (response) {
                           //   //              }
                           //   //           })
                           // }
                          },

                      })],
                         store:warehouse_store_reoder,         
                            columns:[
                             {
                             header:labels_json.itempanel.text_warehouse,dataIndex:"warehouse_name", flex:1,sortable: false
                            },
                         {header:labels_json.itempanel.text_reoder_qty,dataIndex:"reorder_qty",width:100,sortable: false, editor: {
                        xtype: 'textfield',
                        id:'item_quantity_new',
                        allowBlank: false,
                        maxLength: 8,
                        maskRe: /([0-9\s\.]+)$/,
                        regex: /[0-9]/,
                        enableKeyEvents:true,
                        listeners:{
                            blur:function(){
                                var sel = Ext.getCmp('reorder-panel-grid').getSelectionModel().getSelection()[0];
                                var item_id= Ext.getCmp("_item_id").getValue();
                                var qty= Ext.getCmp("item_quantity_new").getValue(); 
                                 Ext.Ajax.request({
                                          url: action_urls.get_item_warehouse_reorder,
                                          method:'POST',
                                          params:{
                                              item_id:item_id,  
                                              warehouse_id : sel.get('warehouse_id'),
                                              qty:qty                                      
                                                  },
                                          success: function (response) {
                                            warehouse_store_reoder.load();
                                          }
                                       })

                                       
                            }
                        }                                 

            }}]
                            }],
               buttons: [{
                  text:labels_json.itempanel.text_close,
                  handler: function(){
                     myForm.close();}
               }],
               buttonAlign: 'center',
                        });
                        myForm.show();
                });
                        
            }
                    }     
                }
                ]

            },{
                xtype: 'fieldset',
                title: labels_json.itempanel.text_measurement,
                cls:'fieldset_text',
                collapsible: false,
                padding:10,
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    
                    xtype: 'combo',
                    fieldLabel:labels_json.itempanel.text_unit,
                    emptyText: 'Select a Unit...',
                    id: '_item_unit',
                    allowBlank: false,  
                    name: '_item_unit',
                    valueField: 'id',
                    displayField: 'name',
                    store: unit_store,
                    value: '1',                                        
                    queryMode: 'local',
                    listeners: {
                    }
                  }
                ]

            },{
                xtype: 'fieldset',
                title: labels_json.itempanel.text_custom_field,
                cls:'fieldset_text',
                collapsible: false,
                padding:10,
                layout:'anchor',
                defaults: {
                    labelWidth: 110,
                    border:false,
                    anchor: '100%',
                    layout: {
                        type: 'hbox',
                        defaultMargins: {
                            top: 0, 
                            right: 5, 
                            bottom: 0, 
                            left: 0
                        }
                    }
                },
                items:[
                {
                    hidden:false,
                    layout: {
                        type: 'table',                            
                        columns: 2,
                        width:"100%",
                        tdAttrs: {
                            align: 'center',
                            valign: 'center',
                            width:'100%'
                        },
                        defaults:{
                            border:false                                                
                        }
                    },
                    items:[{                                               
                        xtype:'textfield',
                        fieldLabel:labels_json.itempanel.text_color,
                        name:'item_color',
                        id:'_item_color',                                                  
                        labelWidth: 110,   
                        cls:'sizing',
                        enableKeyEvents:true,
                        listeners:{
                            change:function(){
                                OBJ_Action.recordChange();
                            }
                        }     
                    },
                    {
                        rowspan: 2,
                        width:"100px",
                        xtype:'button',
                        text:labels_json.itempanel.text_style,  
                        id : 'styling_button',
                        disabled:false,
                        style:'margin:-7px 5px 0px 5px',
                        id:'style_new_btn',
                        width:80,
                        listeners:{
                            click:function(){
                                if(Ext.getCmp("_item_name").getValue()!=="" && Ext.getCmp("_item_nprice").getValue()!=="" && Ext.getCmp("_item_sprice").getValue()!==""){ 
                                    Ext.getCmp("_item_barcode").setValue("");
                                    style_form.show();     
                                }
                                else{
                                    Ext.Msg.show({
                                        title:labels_json.itempanel.text_name,
                                        msg: labels_json.itempanel.text_name_info,
                                        buttons: Ext.Msg.OK,
                                        icon: Ext.Msg.INFO
                                    }); 
                                }

                            }
                        }
                    },      
                    {
                        xtype:'textfield',
                        fieldLabel:labels_json.itempanel.text_size,
                        name:'item_size',
                        cls:'sizing',
                        labelWidth: 110,                                                
                        id:'_item_size',
                        enableKeyEvents:true,
                        listeners:{
                            change:function(){
                                OBJ_Action.recordChange();
                            }
                        }     
                    }
                                             
                    ]  
                }
                ,
                {
                    xtype:'textfield',
                    hidden:true,
                    fieldLabel:labels_json.itempanel.text_brand,
                    name:'item_brand',
                    id:'_item_brand',
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    }     
                },
                {
                    xtype:'textfield',
                    fieldLabel:labels_json.itempanel.text_weight,
                    name:'item_weight',
                    id:'_item_weight',
                    maskRe: /([0-9\s\.]+)$/,
                    regex: /[0-9]/,
                    enableKeyEvents:true,
                    listeners:{
                        change:function(){
                            OBJ_Action.recordChange();
                        }
                    }     
                }
                ]

            }]
        }]
        })
},
{
    
    
    title: labels_json.itempanel.extra_info,
    id : 'extra_info_panel',
    disabled:true,
    layout:'fit',
    listeners:{
    show:function(){
        Ext.getCmp('extra_info_panel_tab').setValue('Active');
        
        var basic_uom_combo = Ext.getCmp("basic_uom_combo").getValue();
        unit_store_1.removeAt(unit_store_1.indexOfId(basic_uom_combo));
        unit_store_2.removeAt(unit_store_2.indexOfId(basic_uom_combo));
        unit_store_3.removeAt(unit_store_3.indexOfId(basic_uom_combo));
        
        var grid = Ext.getCmp("basic_uom_combo");
        var project1 = grid.findRecord('id', basic_uom_combo);
        var name1 =  "";
        if(project1){
            name1 = project1.get('name');
        }
       
        
       if (!Ext.getCmp("sale_uom_combo").getStore().getCount() && !Ext.getCmp("purchase_uom_combo").getStore().getCount()) {
            Ext.getCmp("sale_uom_combo").store.add({id:basic_uom_combo,name:name1});
            Ext.getCmp("sale_uom_combo").setValue(basic_uom_combo);
            Ext.getCmp("purchase_uom_combo").store.add({id:basic_uom_combo,name:name1});
            Ext.getCmp("purchase_uom_combo").setValue(basic_uom_combo);
        }
        
        OBJ_Action.combo_remove({status:''});
        
        Ext.getCmp("_item_quantity").enable();
        var item_qty = Ext.getCmp("_item_quantity").getValue();
        var purcahse_price = Ext.getCmp("_item_nprice").getValue();
        var saleprice_price = Ext.getCmp("_item_sprice").getValue();
        if(item_qty=="" || item_qty=="0"){
            Ext.getCmp('qty_on_hand').setValue("0");
        } else {
        Ext.getCmp('qty_on_hand').setValue(item_qty);
        }
        Ext.getCmp('upc_avg_cost').setValue(purcahse_price);
        Ext.getCmp('upc_sale_price').setValue(saleprice_price);
        
        var item_hidden_id = Ext.getCmp("item_hidden_id").getValue();
        Ext.getCmp("item_id").setValue(item_hidden_id);
       Ext.getCmp("_item_quantity").disable();
       
       OBJ_Action.enable_disable({enable:'enable'});
       
       
       var base_item_qty = parseFloat(Ext.getCmp('qty_on_hand').getValue());
       var conv_from_1 = Ext.getCmp("_base_uom_conv_1").getValue();
       var conv_from_2 = Ext.getCmp("_base_uom_conv_2").getValue();
       var conv_from_3 = Ext.getCmp("_base_uom_conv_3").getValue();
       
       var qty_on_hand_1 = (Math.round((base_item_qty/conv_from_1)*100)/100).toFixed(2);
       if(qty_on_hand_1=='NaN' || qty_on_hand_1=='Infinity'){ Ext.getCmp("qty_on_hand_unit_1").setValue(''); } else { Ext.getCmp("qty_on_hand_unit_1").setValue(qty_on_hand_1); }
       
       
       var qty_on_hand_2 = (Math.round((base_item_qty/conv_from_2)*100)/100).toFixed(2);
       if(qty_on_hand_2=='NaN' || qty_on_hand_2=='Infinity'){ Ext.getCmp("qty_on_hand_unit_2").setValue(''); } else { Ext.getCmp("qty_on_hand_unit_2").setValue(qty_on_hand_2); }
       
       var qty_on_hand_3 = (Math.round((base_item_qty/conv_from_3)*100)/100).toFixed(2);
       if(qty_on_hand_3=='NaN' || qty_on_hand_3=='Infinity'){ Ext.getCmp("qty_on_hand_unit_3").setValue(''); } else { Ext.getCmp("qty_on_hand_unit_3").setValue(qty_on_hand_3); }
       
       OBJ_Action.enable_disable({enable:'disable'});
       
    }
    }, 
    items: new Ext.FormPanel({
        layout:'column',
        frame: false,
        border:false,
        id:'item-panel-form2',
        bodyBorder:false,
        defaults: {
            layout: 'anchor',
            defaults: {
                anchor: '100%'                            
            }
        },
        
        items:[
          {
                columnWidth: 2/3,
                baseCls:'x-plain',
                bodyStyle:'padding:5px',
                items:[                    
                    {
                       xtype: 'fieldset',
                        title:labels_json.itempanel.basic_uom,
                        cls:'fieldset_text',
                        collapsible: false,
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
                        items:[
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                items: [
                                    {
                                        xtype: 'combo',
                                        fieldLabel: "Unit",
                                        emptyText: labels_json.itempanel.unit_placeholder,
                                        id: 'basic_uom_combo',
                                        allowBlank: false,
                                        readOnly:true,                                        
                                        //forceSelection: true,
                                        name: 'uom_combo_base',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: unit_store_0,
                                        value: '1',
                                        queryMode: 'local',
                                        listeners: {
                                         change: function (obj,newValue,oldValue,eOpt) {
                                             OBJ_Action.add_remove_unit({oldValue:oldValue,field:'basic_uom_combo',unit_1:'1',unit_2:'2',unit_3:'3',unit:'',units:''});
                                         }
                                        }
                                    },
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        {
                                            xtype:'hidden',
                                            name:'conv_from_base',
                                            id:'conv_from_base',
                                            value:'0'
                                        },
                                        {
                                            xtype:'hidden',
                                            name:'conv_to_base',
                                            id:'conv_to_base',
                                            value:'0' 
                                        }
                                        ]
                                    }
                                    
                                ]
                            },
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                items: [
                                    
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
                                        xtype: 'textfield',
                                        fieldLabel:labels_json.itempanel.text_upc,
                                        flex:1,
                                        name: 'upc_base',
                                        id: 'upc_basic',
                                        listeners:{
                                            blur: function(d) {
                                                OBJ_Action.check_lookup({val:this.value,value:'upc_basic_lookup',field:'upc_basic'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_1',field:'upc_basic'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_2',field:'upc_basic'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_3',field:'upc_basic'});
                                                OBJ_Action.check_upc({value:this.value,upc_1:'unit_1',upc_2:'unit_2',upc_3:'unit_3',field:'upc_basic'});
                                              }
                                             }
                                            },
                                            {
                                            xtype: 'container',
                                            margins: '0 4',
                                            layout: {
                                            type: 'vbox',
                                            pack: 'center'
                                            },
                                           items:[
                                             {
                                              xtype: 'button',                                                        
                                              iconCls: 'barcodes',
                                              id:'barcode_new_btn2',
                                              navBtn: true,                                            
                                              margin: '2 0 0 8',
                                              width:22,
                                              listeners:{
                                                        click:function(){ 
                                                            OBJ_Action.generate_barcode_button({unit:'basic'});  
                                                            }
                                                        }
                                                    }
                                                ]
                                            }
                                        ]
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
                                            xtype: 'multiselect',                                            
                                            flex:1,
                                            height:55,
                                            fieldLabel: labels_json.itempanel.text_lookup,                                            
                                            queryMode: 'local',
                                            id: 'upc_basic_lookup',
                                            name: 'upc_basic_lookup',
                                            store: new Ext.data.Store({
                                                fields: ['id'],                                                
                                                    data: []
                                                
                                            }),
                                            valueField:'id',
                                            displayField:'id',
                                            value : [],
                                            listeners:{ 
                                                  change:function(){
                                                      OBJ_Action.delete_enable_disable({lookup:'upc_basic_lookup',button:'basic_uom_delete'});
                                                    
                                                  }
                                                }
                                            
                                            
                                        },
                                        {
                                            xtype: 'container',
                                            margins: '0 4',
                                            layout: {
                                                type: 'vbox',
                                                pack: 'center'
                                            },
                                            items:[
                                                {
                                              xtype: 'button',
                                              tooltip:labels_json.itempanel.text_lookup,                                                                                        
                                              iconCls: 'new',
                                              id:'basic_uom_add',
                                              navBtn: true,                                            
                                              margin: '2 0 0 5',
                                              listeners:{
                                                  click:function(){
                                                      base_barcode_form.show();
                                                  }
                                                  
                                                }
                                            },
                                            {
                                              xtype: 'button',
                                              tooltip:labels_json.itempanel.text_removlookup,
                                              disabled:true,
                                              id:'basic_uom_delete',
                                              iconCls: 'delete',
                                              navBtn: true,                                            
                                              margin: '4 0 0 5',
                                             listeners:{
                                             click:function(){
                                                 OBJ_Action.remove_lookup({lookup:'upc_basic_lookup',button:'basic_uom_delete'});
                                                }
                                            }
                                          }
                                        ]
                                            
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
                                        fieldLabel:labels_json.itempanel.text_uomqty,
                                        disabled:true,
                                        name: 'qty_on_hand_base',
                                        id: 'qty_on_hand',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                       {
                                        xtype: 'textfield',
                                        fieldLabel: labels_json.itempanel.text_uomsale,
                                        name: 'sale_price_base',
                                        id: 'upc_sale_price',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/ 
                                       }
                                       ,
                                       {
                                        xtype: 'textfield',
                                        disabled:true,
                                        fieldLabel: labels_json.itempanel.text_uomavg,
                                        name: 'avg_cost_base',
                                        id: 'upc_avg_cost',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       }
                                ]   
                            }
                            
                         ] 
                    },

                    {
                       xtype: 'fieldset',
                        title:labels_json.itempanel.text_uom1,
                        cls:'fieldset_text fieldset_border',
                        collapsible: true,
                        collapsed : true,
                        padding:10,
                        id: 'uom1_collapes',
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
                                        fieldLabel: labels_json.itempanel.text_unit,
                                        emptyText:labels_json.itempanel.unit_placeholder,
                                        id: 'uom_combo_1',
                                        allowBlank: true,                                        
                                        //forceSelection: true,
                                        name: 'uom_combo_1',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: unit_store_1,
                                        value: '',                                        
                                        queryMode: 'local',
                                        listeners: {
                                         change: function (obj,newValue,oldValue,eOpt) {
                                            var n=this.getValue();
                                            // console.log(n)
                                            OBJ_Action.add_remove_unit({newValue:newValue,oldValue:oldValue,field:'uom_combo_1',unit_1:'basic',unit_2:'2',unit_3:'3',unit:'1',units:'3'});
                                                          if(n==-2){
                                            account_selected_combo = obj.getId();
                                            obj.setValue('');                
                                            addUnitWindow.show();
                                        }
                                             
                                         },
                                         focus:function(obj,newValue,oldValue,eOpt){
                                            account_selected_combo = obj.getId();
                                            // console.log(account_selected_combo)
                                            Ext.getCmp('uom_combo_1').bindStore(unit_store_1);
                                             // OBJ_Action.add_remove_unit({newValue:newValue,oldValue:oldValue,field:'uom_combo_1',unit_1:'basic',unit_2:'2',unit_3:'3',unit:'1',units:'3'});

                                         }
                                        }
                                    },                                    
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        {
                                            xtype:'textfield',
                                            disabled: true,
                                            fieldLabel:labels_json.itempanel.text_conv1,
                                            name:'conv_from_1',
                                            margin: '0 5 0 0',
                                            id:'_base_uom_conv_1',
                                            flex:1,  
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                    if(this.value=="" || this.value=="0"){
                                                      Ext.getCmp('qty_on_hand_unit_1').setValue("0");  
                                                    }else {
                                                        OBJ_Action.conv_from({status:'1',con_qty:this.value});
                                                    }
                                                  
                                                }
                                            }
                                        },
                                        {
                                            xtype:'textfield',
                                            fieldLabel:"----",
                                            name:'conv_to_1',
                                            disabled: true,
                                            margin: '0 5 0 0',
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            id:'_item_con_unit_1',
                                            flex:1,  
                                            value:'1',
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                  
                                                }
                                            } 
                                        }
                                        
                                        ]
                                    },
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        
                                        {
                                            xtype: 'button', 
                                            text: labels_json.itempanel.text_reset,
                                            cls: 'reset',
                                            tooltip:labels_json.itempanel.text_reset_info,
                                            listeners:{
                                                click:function(){
                                                    OBJ_Action.uom_reset({uom:'1',value:Ext.getCmp("uom_combo_1").getValue()});
                                                    
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
                                items: [
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
                                        xtype: 'textfield',
                                        fieldLabel: labels_json.itempanel.text_upc,
                                        flex:1,
                                        width:177,
                                        disabled: true,
                                        name: 'upc_1',
                                        labelWidth: 55,
                                        id: 'upc_unit_1',
                                        listeners:{
                                            blur: function(d) {
                                                OBJ_Action.check_lookup({val:this.value,value:'upc_basic_lookup',field:'upc_unit_1'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_1',field:'upc_unit_1'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_2',field:'upc_unit_1'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_3',field:'upc_unit_1'});
                                                OBJ_Action.check_upc({value:this.value,upc_1:'basic',upc_2:'unit_2',upc_3:'unit_3',field:'upc_unit_1'});
                                            }
                                          }
                                        },
                                            {
                                            xtype: 'container',
                                            margins: '0 4',
                                            layout: {
                                            type: 'vbox',
                                            pack: 'center'
                                            },
                                           items:[
                                             {
                                              xtype: 'button',
                                              tooltip: labels_json.itempanel.text_new_barcode,
                                              disabled:true,
                                              iconCls: 'barcodes',
                                              id:'barcode_new_btn3',
                                              navBtn: true,                                            
                                              margin: '2 0 0 8',
                                              width : 22,
                                              listeners:{
                                                        click:function(){ 
                                                            OBJ_Action.generate_barcode_button({unit:'unit_1'});  
                                                            }
                                                        }
                                                    }
                                                ]
                                            }
                                        ]
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
                                            height:55,
                                            fieldLabel: labels_json.itempanel.text_lookup,                                            
                                            queryMode: 'local',
                                            id: 'alt_lookup_unit_1',
                                            name: 'alt_lookup_unit_1',
                                            store: new Ext.data.Store({
                                                fields: ['id'],                                                
                                                data: [
                                                    
                                                ]
                                            }),
                                            valueField:'id',
                                            displayField:'id',
                                            value : [],
                                            listeners:{
                                                  change:function(){
                                                    OBJ_Action.delete_enable_disable({lookup:'alt_lookup_unit_1',button:'remove_button_uom1'});
                                                  }
                                                }
                                            
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
                                              id:'add_button_uom1',
                                              tooltip: labels_json.itempanel.text_altlookup,                                               
                                              iconCls: 'new',
                                              navBtn: true,                                            
                                              margin: '2 0 2 5',
                                               listeners:{
                                                 click:function(){
                                                     uom1_barcode_form.show();
                                                  }
                                               }
                                            },
                                            {
                                              xtype: 'button',
                                              id:'remove_button_uom1',
                                              tooltip:labels_json.itempanel.text_removlookup,                                                                                        
                                              iconCls: 'delete',
                                              disabled: true,
                                              navBtn: true,                                            
                                              margin: '4 0 0 5',
                                              listeners:{
                                             click:function(){
                                                OBJ_Action.remove_lookup({lookup:'alt_lookup_unit_1',button:'remove_button_uom1'});
                                                }
                                             }
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
                                        disabled:true,
                                        fieldLabel:labels_json.itempanel.text_uomqty,
                                        name: 'qty_on_hand_1',
                                        id: 'qty_on_hand_unit_1',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                       
                                           {
                                        xtype: 'textfield',
                                        //disabled: true,
                                        width:50,
                                        fieldLabel:labels_json.itempanel.text_uomsale,
                                        name: 'sale_price_1',
                                        id: 'sale_price_unit_1',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                        {
                                              xtype: 'button',
                                              tooltip:'save price',                                                                                        
                                              text: 'Save Unit Price',
                                              id:'new_uom_price_1',
                                              navBtn: true, 
                                              width:'36px',                                           
                                              margin: '-3 0 0 229',
                                              listeners:{
                                                  click:function(){
                                                        Ext.Ajax.request({
                                                    url: action_urls.Updateunit_price_uom,
                                                    params:{
                                                        item_id : Ext.getCmp("_item_id").getValue(),
                                                        uom_id    : 1,
                                                        unit_id   :Ext.getCmp("uom_combo_1").getValue(),
                                                        conv_from   :Ext.getCmp("_base_uom_conv_1").getValue(),
                                                        price     : Ext.getCmp("sale_price_unit_1").getValue()
                                                    },
                                                success: function (response) {
                                                       Ext.Msg.show({
                                                    title: 'Success',
                                                    msg: 'Operation Successfully Done.',
                                                    buttons: Ext.Msg.OK,
                                                    icon: Ext.Msg.INFO
                                                });
                                                },
                                                failure: function () {}
                                            });
                                                  }
                                                  
                                                }
                                            },
                                               
                                       {
                                        xtype: 'textfield',
                                        disabled:true,
                                        fieldLabel: labels_json.itempanel.text_uomavg,
                                        name: 'avg_cost_1',
                                        id: 'avg_cost_unit_1',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       }
                                ]   
                            }
                            
                         ] 
                    },
                    {
                       xtype: 'fieldset',
                        title:labels_json.itempanel.text_uom2,
                        cls:'fieldset_text fieldset_border',
                        collapsible: true,
                        collapsed : true,
                        padding:10,
                        id: 'uom2_collapes',
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
                                items: [
                                    {
                                        xtype: 'combo',
                                        fieldLabel:labels_json.itempanel.text_unit,
                                        id: 'uom_combo_2',
                                        emptyText:labels_json.itempanel.unit_placeholder,
                                        allowBlank: true,                                        
                                        //forceSelection: true,
                                        name: 'uom_combo_2',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: unit_store_2,
                                        value: '',                                        
                                        queryMode: 'local',
                                        listeners: {
                                          change: function (obj,newValue,oldValue,eOpt) {
                                               var n=this.getValue();
                                            // console.log(n)
                                           OBJ_Action.add_remove_unit({newValue:newValue,oldValue:oldValue,field:'uom_combo_2',unit_1:'basic',unit_2:'1',unit_3:'3',unit:'2',units:'4'});
                                                          if(n==-2){
                                            account_selected_combo = obj.getId();
                                            obj.setValue('');                
                                            // addUnitWindow.show()
                                             
                                          }

                                      },
                                         focus:function(obj,newValue,oldValue,eOpt){
                                            account_selected_combo = obj.getId();
                                            console.log(account_selected_combo)
                                            Ext.getCmp('uom_combo_2').bindStore(unit_store_2);
                                             // OBJ_Action.add_remove_unit({newValue:newValue,oldValue:oldValue,field:'uom_combo_2',unit_1:'basic',unit_2:'1',unit_3:'3',unit:'2',units:'4'});
                                         }
                                     }
                                    },                                    
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        {
                                            xtype:'textfield',
                                            disabled:true,
                                            fieldLabel:labels_json.itempanel.text_conv2,
                                            name:'conv_from_2',
                                            margin: '0 5 0 0',
                                            id:'_base_uom_conv_2',
                                            flex:1,              
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                    if(this.value=="" || this.value=="0"){
                                                      Ext.getCmp('qty_on_hand_unit_2').setValue("0.00");  
                                                    }else {
                                                       OBJ_Action.conv_from({status:'2',con_qty:this.value}); 
                                                    }
                                                  
                                                }
                                            }
                                        },
                                        {
                                            xtype:'textfield',
                                            disabled:true,
                                            fieldLabel:"----",
                                            name:'conv_to_2',
                                            margin: '0 5 0 0',
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            id:'_item_con_unit_2',
                                            flex:1,  
                                            value:'1',
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                  
                                                }
                                            } 
                                        }
                                        ]
                                    }
                                    ,
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        
                                        {
                                            xtype: 'button', 
                                            text: labels_json.itempanel.text_reset,
                                            cls: 'reset',
                                            tooltip:'Reset this unit.',
                                            listeners:{
                                                click:function(){
                                                    OBJ_Action.uom_reset({uom:'2',value:Ext.getCmp("uom_combo_2").getValue()});
                                                    
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
                                items: [
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
                                        xtype: 'textfield',
                                        fieldLabel:labels_json.itempanel.text_upc,
                                        flex:1,
                                        width:177,
                                        disabled: true,
                                        name: 'upc_2',
                                        labelWidth: 55,
                                        id: 'upc_unit_2',
                                        listeners:{
                                            blur: function(d) {
                                                OBJ_Action.check_lookup({val:this.value,value:'upc_basic_lookup',field:'upc_unit_2'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_1',field:'upc_unit_2'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_2',field:'upc_unit_2'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_3',field:'upc_unit_2'});
                                                OBJ_Action.check_upc({value:this.value,upc_1:'basic',upc_2:'unit_1',upc_3:'unit_3',field:'upc_unit_2'});
                                                
                                                }
                                                  
                                                }
                                            },
                                            {
                                            xtype: 'container',
                                            margins: '0 4',
                                            layout: {
                                            type: 'vbox',
                                            pack: 'center'
                                            },
                                           items:[
                                             {
                                              xtype: 'button',
                                              tooltip:labels_json.itempanel.text_new_barcode,                                                                                        
                                              iconCls: 'barcodes',
                                              disabled: true,
                                              id:'barcode_new_btn4',
                                              navBtn: true,                                            
                                              margin: '2 0 0 8',
                                              width : 22,
                                              listeners:{
                                                        click:function(){ 
                                                            OBJ_Action.generate_barcode_button({unit:'unit_2'});  
                                                            }
                                                        }
                                                    }
                                                ]
                                            }
                                        ]
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
                                            height:55,
                                            fieldLabel:labels_json.itempanel.text_lookup,                                            
                                            queryMode: 'local',
                                            id: 'alt_lookup_unit_2',
                                            name: 'alt_lookup_unit_2',
                                            store: new Ext.data.Store({
                                                fields: ['id'],                                                
                                                data: [ ]
                                            }),
                                            valueField:'id',
                                            displayField:'id',
                                            value : [],
                                            listeners:{
                                                  change:function(){
                                                    OBJ_Action.delete_enable_disable({lookup:'alt_lookup_unit_2',button:'remove_button_uom2'});
                                                  }
                                                }
                                            
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
                                              tooltip:labels_json.itempanel.text_altlookup,
                                              id: 'add_button_uom2',
                                              iconCls: 'new',
                                              navBtn: true,                                            
                                              margin: '2 0 0 5',
                                              listeners:{
                                                  click:function(){
                                                      uom2_barcode_form.show();
                                                  }
                                               }
                                              
                                            },
                                            {
                                              xtype: 'button',
                                              tooltip:labels_json.itempanel.text_removlookup,
                                              id: 'remove_button_uom2',
                                              disabled:true,
                                              iconCls: 'delete',
                                              navBtn: true,                                            
                                              margin: '4 0 0 5',
                                               listeners:{
                                             click:function(){
                                                 OBJ_Action.remove_lookup({lookup:'alt_lookup_unit_2',button:'remove_button_uom2'});
                                                 }
                                             }
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
                                        fieldLabel: labels_json.itempanel.text_uomqty,
                                        disabled:true,
                                        name: 'qty_on_hand_2',
                                        id: 'qty_on_hand_unit_2',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                       {
                                        xtype: 'textfield',
                                        //disabled:true,
                                        fieldLabel: labels_json.itempanel.text_uomsale,
                                        name: 'sale_price_2',
                                        id: 'sale_price_unit_2',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },{
                                              xtype: 'button',
                                              tooltip:'save price',                                                                                        
                                              text: 'Save Unit Price',
                                              id:'new_uom_price_2',
                                              navBtn: true, 
                                              width:'36px',                                           
                                              margin: '-3 0 0 229',
                                              listeners:{
                                                  click:function(){
                                                        Ext.Ajax.request({
                                                    url: action_urls.Updateunit_price_uom,
                                                    params:{
                                                        item_id : Ext.getCmp("_item_id").getValue(),
                                                        uom_id    : 2,
                                                        unit_id   :Ext.getCmp("uom_combo_2").getValue(), 
                                                        conv_from   :Ext.getCmp("_base_uom_conv_2").getValue(),
                                                        price     : Ext.getCmp("sale_price_unit_2").getValue()
                                                    },
                                                success: function (response) {
                                                   Ext.Msg.show({
                                                    title: 'Success',
                                                    msg: 'Operation Successfully Done.',
                                                    buttons: Ext.Msg.OK,
                                                    icon: Ext.Msg.INFO
                                                });  
                                                },
                                                failure: function () {}
                                            });
                                                  }
                                                  
                                                }
                                            },

                                       {
                                        xtype: 'textfield',
                                        disabled:true,
                                        fieldLabel:labels_json.itempanel.text_uomavg,
                                        name: 'avg_cost_2',
                                        id: 'avg_cost_unit_2',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       }
                                ]   
                            }
                            
                         ] 
                    },
                    {
                       xtype: 'fieldset',
                        title:labels_json.itempanel.text_uom3,
                        cls:'fieldset_text fieldset_border',
                        collapsible: true,
                        collapsed : true,
                        padding:10,
                        id: 'uom3_collapes',
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
                                        emptyText: labels_json.itempanel.unit_placeholder,
                                        id: 'uom_combo_3',
                                        allowBlank: true,                                        
                                        //forceSelection: true,
                                        name: 'uom_combo_3',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: unit_store_3,
                                        value: '',                                        
                                        queryMode: 'local',
                                       listeners: {
                                          change: function (obj,newValue,oldValue,eOpt) {
                                             var n=this.getValue();
                                              OBJ_Action.add_remove_unit({newValue:newValue,oldValue:oldValue,field:'uom_combo_3',unit_1:'basic',unit_2:'1',unit_3:'2',unit:'3',units:'5'});
                                                     if(n==-2){
                                            account_selected_combo = obj.getId();
                                            obj.setValue('');                
                                            // addUnitWindow.show()
                                             
                                          }
                                          },
                                           focus:function(obj,newValue,oldValue,eOpt){
                                            account_selected_combo = obj.getId();
                                            console.log(account_selected_combo)
                                            Ext.getCmp('uom_combo_3').bindStore(unit_store_3);
                                            // OBJ_Action.add_remove_unit({newValue:newValue,oldValue:oldValue,field:'uom_combo_3',unit_1:'basic',unit_2:'1',unit_3:'2',unit:'3',units:'5'});
                                         }
                                      }
                                    },                                    
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        {
                                            xtype:'textfield',
                                            fieldLabel:labels_json.itempanel.text_conv3,
                                            name:'conv_from_3',
                                            margin: '0 5 0 0',
                                            disabled:true,
                                            id:'_base_uom_conv_3',
                                            flex:1,              
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                    if(this.value=="" || this.value=="0"){
                                                      Ext.getCmp('qty_on_hand_unit_3').setValue("0.00");  
                                                    }else {
                                                        OBJ_Action.conv_from({status:'3',con_qty:this.value});
                                                    }
                                                }
                                            } 
                                        },
                                        {
                                            xtype:'textfield',
                                            fieldLabel:"----",
                                            disabled:true,
                                            name:'conv_to_3',
                                            margin: '0 5 0 0',
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            id:'_item_con_unit_3',
                                            flex:1, 
                                            value:'1',
                                            enableKeyEvents:true,
                                            listeners:{
                                                change:function(){
                                                  
                                                }
                                            } 
                                        }
                                        ]
                                    }
                                    ,
                                    {
                                        xtype: 'panel',      
                                        border:false,
                                        layout: 'hbox',                                        
                                        defaults: {
                                            hideLabel: false,
                                            labelWidth: 80
                                        },
                                        items: [
                                        
                                        {
                                            xtype: 'button', 
                                            text: labels_json.itempanel.text_reset,
                                            cls: 'reset',
                                            tooltip:labels_json.itempanel.text_reset_info,
                                            listeners:{
                                                click:function(){
                                                    OBJ_Action.uom_reset({uom:'3',value:Ext.getCmp("uom_combo_3").getValue()});
                                                    
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
                                items: [
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
                                        xtype: 'textfield',
                                        fieldLabel:labels_json.itempanel.text_upc,
                                        flex:1,
                                        width:177,
                                        disabled: true,
                                        name: 'upc_3',
                                        labelWidth: 55,
                                        id: 'upc_unit_3',
                                        listeners:{
                                            blur: function(d){
                                                OBJ_Action.check_lookup({val:this.value,value:'upc_basic_lookup',field:'upc_unit_3'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_1',field:'upc_unit_3'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_2',field:'upc_unit_3'});
                                                OBJ_Action.check_lookup({val:this.value,value:'alt_lookup_unit_3',field:'upc_unit_3'});
                                                OBJ_Action.check_upc({value:this.value,upc_1:'basic',upc_2:'unit_1',upc_3:'unit_2',field:'upc_unit_3'});
                                              }
                                             }
                                            },
                                            {
                                            xtype: 'container',
                                            margins: '0 4',
                                            layout: {
                                            type: 'vbox',
                                            pack: 'center'
                                            },
                                           items:[
                                             {
                                              xtype: 'button',
                                              tooltip:labels_json.itempanel.text_new_barcode,                                                                                        
                                              iconCls: 'barcodes',
                                              disabled: true,
                                              id:'barcode_new_btn5',
                                              navBtn: true,                                            
                                              margin: '2 0 0 8',
                                              width : 22,
                                              listeners:{
                                                        click:function(){ 
                                                            OBJ_Action.generate_barcode_button({unit:'unit_3'});  
                                                            }
                                                        }
                                                    }
                                                ]
                                            }
                                        ]
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
                                            height:55,
                                            fieldLabel:labels_json.itempanel.text_lookup,                                            
                                            queryMode: 'local',
                                            id: 'alt_lookup_unit_3',
                                            name: 'alt_lookup_unit_3',
                                            store: new Ext.data.Store({
                                                fields: ['id'],                                                
                                                data: [ ]
                                            }),
                                            valueField:'id',
                                            displayField:'id',
                                            value : [],
                                            listeners:{
                                                  change:function(){
                                                    OBJ_Action.delete_enable_disable({lookup:'alt_lookup_unit_3',button:'remove_button_uom3'});
                                                  }
                                                }
                                            
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
                                              tooltip:labels_json.itempanel.text_altlookup, 
                                              id:'add_button_uom3',
                                              iconCls: 'new',
                                              navBtn: true,                                            
                                              margin: '2 0 0 5',
                                              listeners:{
                                                click:function(){
                                                    uom3_barcode_form.show();
                                                  }
                                               }
                                            },
                                            {
                                              xtype: 'button',
                                              disabled:true,
                                              id:'remove_button_uom3',
                                              tooltip:labels_json.itempanel.text_removlookup,                                                                                        
                                              iconCls: 'delete',
                                              navBtn: true,                                            
                                              margin: '4 0 0 5',
                                               listeners:{
                                             click:function(){
                                                OBJ_Action.remove_lookup({lookup:'alt_lookup_unit_3',button:'remove_button_uom3'});
                                            }
                                             }
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
                                        disabled:true,
                                        fieldLabel:labels_json.itempanel.text_uomqty,
                                        name: 'qty_on_hand_3',
                                        id: 'qty_on_hand_unit_3',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                       {
                                        xtype: 'textfield',
                                        //disabled:true,
                                        fieldLabel:labels_json.itempanel.text_uomsale,
                                        name: 'sale_price_3',
                                        id: 'sale_price_unit_3',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       },
                                       {
                                              xtype: 'button',
                                              tooltip:'save price',                                                                                        
                                              text: 'Save Unit Price',
                                              id:'new_uom_price_3',
                                              navBtn: true, 
                                              width:'36px',                                           
                                              margin: '-3 0 0 229',
                                              listeners:{
                                                  click:function(){
                                                        Ext.Ajax.request({
                                                    url: action_urls.Updateunit_price_uom,
                                                    params:{
                                                        item_id : Ext.getCmp("_item_id").getValue(),
                                                        uom_id    : 3,
                                                        unit_id   :Ext.getCmp("uom_combo_3").getValue(),
                                                        conv_from   :Ext.getCmp("_base_uom_conv_3").getValue(),
                                                        price     : Ext.getCmp("sale_price_unit_3").getValue()
                                                    },
                                                success: function (response) {
                                                       Ext.Msg.show({
                                                    title: 'Success',
                                                    msg: 'Operation Successfully Done.',
                                                    buttons: Ext.Msg.OK,
                                                    icon: Ext.Msg.INFO
                                                });
                                                },
                                                failure: function () {}
                                            });
                                                  }
                                                  
                                                }
                                            },
                                       
                                       {
                                        xtype: 'textfield',
                                        disabled:true,
                                        fieldLabel:labels_json.itempanel.text_uomavg,
                                        name: 'avg_cost_3',
                                        id: 'avg_cost_unit_3',
                                        maskRe: /([0-9\s\.]+)$/,
                                        regex: /[0-9]/
                                       }
                                ]   
                            }
                            
                         ] 
                    }
                 ]
              },
               {
                xtype:'hidden',
                name:'uom_base_mapping_id',
                id:'uom_base_mapping_id',
                value:''
            },
            {
                xtype:'hidden',
                name:'extra_info_panel_tab',
                id:'extra_info_panel_tab',
                value:''
            },
             {
                xtype:'hidden',
                name:'uom_base_item_id',
                id:'uom_base_item_id',
                value:''
            },
            {
                xtype:'hidden',
                name:'uom_1_mapping_id',
                id:'uom_1_mapping_id',
                value:''
            },
             {
                xtype:'hidden',
                name:'uom_1_item_id',
                id:'uom_1_item_id',
                value:''
            },
            {
                xtype:'hidden',
                name:'uom_2_mapping_id',
                id:'uom_2_mapping_id',
                value:''
            },
             {
                xtype:'hidden',
                name:'uom_2_item_id',
                id:'uom_2_item_id',
                value:''
            },
            {
                xtype:'hidden',
                name:'uom_3_mapping_id',
                id:'uom_3_mapping_id',
                value:''
            },
             {
                xtype:'hidden',
                name:'uom_3_item_id',
                id:'uom_3_item_id',
                value:''
            },
             {
                    xtype:'hidden',
                    name:'item_id',
                    id:'item_id',
                    value:'0'
                }, 
            {
                xtype:'hidden',
                name:'uom_base',
                id:'uom_base',
                value:''
            },
            {
                xtype:'hidden',
                name:'uom_1',
                id:'uom_1',
                value:''
            },
            {
                xtype:'hidden',
                name:'uom_2',
                id:'uom_2',
                value:''
            },
            {
                xtype:'hidden',
                name:'uom_3',
                id:'uom_3',
                value:''
            },
            {
                columnWidth: 1/3,
                baseCls:'x-plain',
                bodyStyle:'padding:5px',
                items:[{
                       xtype: 'fieldset',
                        title: labels_json.itempanel.orderandsale,
                        cls:'fieldset_text',
                        collapsible: false,
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
                                 columnWidth: 1 / 2,
                                 baseCls: 'x-plain',
                                 padding: 10,  
                                 items: [
                                     {
                                        xtype: 'combo',
                                        fieldLabel:labels_json.itempanel.text_saleunit,
                                        id: 'sale_uom_combo',
                                        width:200,
                                        name: 'sale_uom_combo',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: new Ext.data.Store({
                                                fields: ['id','name'],                                                
                                                    data: []
                                                
                                            }),
                                        value: '',                                        
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                               
                                           
                                            }
                                        }
                                    },
                                    {
                                        xtype: 'combo',
                                        fieldLabel:labels_json.itempanel.text_purchaseunit,
                                        id: 'purchase_uom_combo',                                        
                                        //forceSelection: true,
                                        //disabled:true,
                                        name: 'purchase_uom_combo',
                                        valueField: 'id',
                                        displayField: 'name',
                                        store: new Ext.data.Store({
                                                fields: ['id','name'],                                                
                                                    data: []
                                                
                                            }),
                                        value: '',                                        
                                        queryMode: 'local',
                                       listeners: {
                                            change: function (f, obj) {
                                               
                                           
                                            }
                                        }
                                    },
                                         {
                                xtype:'textfield',
                                 fieldLabel:'Item Name',
                                 value: '',
                                 id:'itemNameExtra',
                                 cls: 'total_digit_field',
                                  style: 'margin-top:20px;',
                                 readOnly:true

                               }
                                ]
                               }

                               
                        ]
                    }]
            }             
        ]
    })  
}
, {
    title: labels_json.itempanel.text_tab_order,
    layout:'fit',
    disabled:true,
    items:[{
        xtype:"gridpanel",
        id:"order_grid",
        margin:5,
        store:{
            proxy:{
                type:"memory",
                reader:{
                    type:"json"
                }
            },
            model:Ext.define("MyModel", {
                extend:"Ext.data.Model",
                fields:[
                "type",
                "order_id",
                "vendor_name",
                "order_date",
                "order_status",
                "order_total",
                "quantity",
                "unit_price",
                "sub_total"
                                
                ]
            }) && "MyModel",
            data:[]
        },
        listeners:{
            afterRender : function() {
                // this.superclass.afterRender.call(this);
                this.nav = new Ext.KeyNav(this.getEl(),{
                    del: function(e){
                         
                    }
                });
            }
  
        },

        columnLines: true,
        columns:[
        {
            header:"Type",
            dataIndex:"type",
            width:80
        },

        {
            header:"Order #",
            dataIndex:"order_id",
            width:80
        },

        {
            header:"Vendor/Customer Name",
            dataIndex:"vendor_name",
            flex:1
        },

        {
            header:"Order Date",
            dataIndex:"order_date",
            width:80
        },

        {
            header:"Order Status",
            dataIndex:"order_status",
            width:80
        },

        {
            header:"Order Total",
            dataIndex:"order_total",
            width:80
        },

        {
            header:"Quantity",
            dataIndex:"quantity",
            width:80
        },

        {
            header:"Unit Price",
            dataIndex:"unit_price",
            width:80
        },

        {
            header:"Sub-Total",
            dataIndex:"sub_total",
            width:80
        }
        ]
        }]
}],
tbar: [
    
{
    xtype: 'button', 
    text: labels_json.itempanel.text_new,
    iconCls: 'new',
    tooltip:labels_json.itempanel.text_new_info,
    listeners:{
        click:function(){
            var extra_info_panel_tab = Ext.getCmp("extra_info_panel_tab").getValue();
            if(extra_info_panel_tab==""){
             OBJ_Action.makeNew();
            Ext.getCmp("item-panel-form2").getForm().reset();
            Ext.getCmp("upc_basic_lookup").store.removeAll();
            Ext.getCmp("alt_lookup_unit_1").store.removeAll();
            Ext.getCmp("alt_lookup_unit_2").store.removeAll();
            Ext.getCmp("alt_lookup_unit_3").store.removeAll();
            Ext.getCmp("purchase_uom_combo").store.removeAll();
            Ext.getCmp("sale_uom_combo").store.removeAll();
            Ext.getCmp('extra_info_panel_tab').setValue("");
            Ext.getCmp('extra_info_panel').enable();
            Ext.getCmp("_item_quantity").enable();
            Ext.getCmp('_item_nprice').enable();
            } else {
            Ext.getCmp("item-panel-form").getForm().reset();
            Ext.getCmp("item-panel-form2").getForm().reset();
            Ext.getCmp("upc_basic_lookup").store.removeAll();
            Ext.getCmp("alt_lookup_unit_1").store.removeAll();
            Ext.getCmp("alt_lookup_unit_2").store.removeAll();
            Ext.getCmp("alt_lookup_unit_3").store.removeAll();
            Ext.getCmp("purchase_uom_combo").store.removeAll();
            Ext.getCmp("sale_uom_combo").store.removeAll();
            Ext.getCmp('extra_info_panel_tab').setValue("");
            Ext.getCmp("_item_quantity").enable();
            Ext.getCmp('_item_nprice').enable();
            Ext.getCmp("_item_cat_id").setValue("Default");
            var tabPanel = Ext.getCmp("item_tab_panel");
            var currentTab = tabPanel.getActiveTab();
            tabPanel.setActiveTab(0);
            Ext.getCmp('extra_info_panel').disable();
        }
                             
        }
    }
}
,
{
    xtype: 'button', 
    text: labels_json.itempanel.text_save,
    iconCls: 'save',
    tooltip:labels_json.itempanel.text_save_info,
    listeners:{
        click:function(){
            if(user_right==1){
                Ext.getCmp("item_entry_date").setValue(Ext.Date.format(new Date(),'Y-m-d H:i:s'));
                OBJ_Action.saveme();
                    } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.item.actions.new){ 
                        Ext.getCmp("item_entry_date").setValue(Ext.Date.format(new Date(),'Y-m-d H:i:s'));
                        OBJ_Action.saveme();
                        } else {
                            Ext.Msg.show({
                                title:labels_json.itempanel.text_user_access,
                                msg:labels_json.itempanel.text_user_access_info,
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
{
    xtype: 'button', 
    text: labels_json.itempanel.text_saveandnew,
    iconCls: 'save',
    tooltip:labels_json.itempanel.text_saveandnew_info,
    listeners:{
        click:function(){
            if(user_right==1){
                Ext.getCmp("item_entry_date").setValue(Ext.Date.format(new Date(),'Y-m-d H:i:s'));
                OBJ_Action.saveme({ makenew:1 });
                    } else {
                        if(Ext.decode(decodeHTML(userAccessJSON)).user_access.item.actions.new){ 
                        Ext.getCmp("item_entry_date").setValue(Ext.Date.format(new Date(),'Y-m-d H:i:s'));
                        OBJ_Action.saveme({ makenew:1 });
                        } else {
                            Ext.Msg.show({
                                title:labels_json.itempanel.text_user_access,
                                msg:labels_json.itempanel.text_user_access_info,
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
,'-',
{xtype: 'button',
                    text: labels_json.itempanel.text_print_lbl,
                    id : 'print_label',
                    iconCls: 'print',
                    tooltip: labels_json.itempanel.text_print_lbl_info,
                    listeners: {
                        click: function () {
                            Ext.Ajax.request({
                                    url: action_urls.print_label_item,
                                    params:{
                                        item_name : Ext.getCmp("_item_name").getValue(),
                                        quantity : Ext.getCmp("_item_quantity").getValue(),
                                        barcode : Ext.getCmp("_item_barcode").getValue(),
                                        price : Ext.getCmp("_item_sprice").getValue(),
                                        user_key    : userKey_barcodeLabel,
                                        barcodeLabel : barcodeLabel,
                                        store_name : store_name,
                                        userKey_barcodeLabel : userKey_barcodeLabel,
                                        label_design_1 : label_design_1,
                                        label_design_2 : label_design_2,
                                        label_design_3 : label_design_3,
                                        label_design_4 : label_design_4,
                                        label_design_5 : label_design_5
                                    },
                                    success: function (response) {

                                    },
                                    failure: function () {}
                                });
                        }
                    }
                },
{
    xtype: 'button', 
    text: labels_json.itempanel.text_copy,
    iconCls: 'copy',
    tooltip:labels_json.itempanel.text_copy_info,
    listeners:{
        click:function(){
            OBJ_Action.copy('item_hidden_id','_item_name');
        }
    }
}
,
{
    xtype: 'button', 
    text: labels_json.itempanel.text_deactive,
    tooltip:labels_json.itempanel.text_deactive_info,
    iconCls: 'deactivate',
    id:'item_btn_activate',
    listeners:{
        click:function(btn,e,opt){
            var getID =  parseInt(Ext.getCmp("item_hidden_id").getValue());
            if(getID!==0){
                var active = btn.iconCls == 'deactivate'?0:1;
                OBJ_Action.deactive(getID,active);
            }
            else{
                Ext.Msg.show({
                    title:labels_json.itempanel.text_error,
                    msg: labels_json.itempanel.text_error_info,
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.ERROR
                });
            }
        }
    }
},
{
    xtype: 'button', 
    text: labels_json.itempanel.text_close,
    tooltip:labels_json.itempanel.text_close_info,
    iconCls: 'close',
    listeners:{
        click:function(){
            Ext.getCmp("item-panel-form").getForm().reset();
            Ext.getCmp("item-panel-form2").getForm().reset();
            Ext.getCmp("upc_basic_lookup").store.removeAll();
            Ext.getCmp("alt_lookup_unit_1").store.removeAll();
            Ext.getCmp("alt_lookup_unit_2").store.removeAll();
            Ext.getCmp("alt_lookup_unit_3").store.removeAll();
            Ext.getCmp("purchase_uom_combo").store.removeAll();
            Ext.getCmp("sale_uom_combo").store.removeAll();
            Ext.getCmp('extra_info_panel_tab').setValue("");
            Ext.getCmp("_item_quantity").enable();
            Ext.getCmp('_item_nprice').enable();
            Ext.getCmp("_item_cat_id").setValue("Default");
            OBJ_Action.close();
            
        }
    }
}

]

}
]
}
