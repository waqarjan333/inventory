_journalReport={
    id: 'journal-view-panel',
    closable:true,
    closeAction:'hide',
    layout: 'border',
    frame:true,
    title:'Journal View',
    layout:'fit',
    listeners:{
        close: function() {
            getPanel(json_urls.accounts_journal,'journal-panel');
        },
        beforerender: function(){
            
        },
        afterLayout: function(){
            var grid = Ext.getCmp('view_grid')
            var width = grid.columns[0].getWidth()
            var width_debit = grid.columns[1].getWidth()
            Ext.getCmp('total_label').setWidth(width - 10)
            Ext.getCmp('total_debit').setWidth(width_debit)
            Ext.getCmp('total_credit').setWidth(width_debit)
            var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -0);
            var current = Ext.Date.format(dt2, 'Y-m-d')
            Ext.getCmp('journal-view-panel').retrieve(current)
            Ext.getCmp('selected_jouranl_so').setValue('Today')
            
            
        }
    },
    
    refresh:function(){
        Ext.getCmp('journal_view').getForm().reset()
        Ext.getCmp('view_grid').getStore().removeAll()
        Ext.getCmp('btn_prev').setDisabled(false)
    },
    
    delete:function(id){
        Ext.Ajax.request({
            url: action_urls.delete_journal_invoice,
            method : 'POST',
            jsonData:{
                    entry_id : id,
            },
            
            success: function (response) {
                var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -0);
                var current = Ext.Date.format(dt2, 'Y-m-d')
                Ext.getCmp('journal-view-panel').retrieve(current)
                Ext.getCmp('selected_jouranl_so').setValue('Today')
            },
            failure: function () {
                console.log('failed')
            }
        });
    },
    next: function(){
        Ext.Ajax.request({
            url: action_urls.next_journal_invoice,
            method : 'POST',
            jsonData:{
                    entry_id : Ext.getCmp('entry_id').value,
            },
            
            success: function (response) {
                var response = JSON.parse(response.responseText)
                Ext.getCmp('entry_id').setValue(response['entry_id'])
                Ext.getCmp('current_date').setValue(response['inv_date'])
                journal_view_store.loadData(response['details'])
                if(Ext.getCmp('entry_id').value == response['min']){
                    Ext.getCmp('btn_prev').setDisabled(true)
                }
                else{
                    Ext.getCmp('btn_prev').setDisabled(false)
                }
                if(Ext.getCmp('entry_id').value == response['max']){
                    Ext.getCmp('btn_next').setDisabled(true)
                }
                var grid = Ext.getCmp('view_grid')
                grid.calculate_total(grid)
            },
            failure: function () {
                console.log('failed')
            }
        });
        
        
    },
    
    previous: function(){
        Ext.Ajax.request({
            url: action_urls.previous_journal_invoice,
            method : 'POST',
            jsonData:{
                    entry_id : Ext.getCmp('entry_id').value,
            },
            
            success: function (response) {
                var response = JSON.parse(response.responseText)
                Ext.getCmp('entry_id').setValue(response['entry_id'])
                Ext.getCmp('current_date').setValue(response['inv_date'])
                journal_view_store.loadData(response['details'])
                if(Ext.getCmp('entry_id').value == response['min']){
                    Ext.getCmp('btn_prev').setDisabled(true)
                }
                if(Ext.getCmp('entry_id').value == response['max']){
                    Ext.getCmp('btn_next').setDisabled(true)
                }
                else{
                    Ext.getCmp('btn_next').setDisabled(false)
                }
                var grid = Ext.getCmp('view_grid')
                grid.calculate_total(grid)
            },
            failure: function () {
                console.log('failed')
            }
        });
        
        
    },
    save: function(){
        var jsonData = Ext.encode(Ext.pluck(journal_view_store.data.items, 'data'))
        
        Ext.Ajax.request({
            url: action_urls.save_journal_invoice,
            method : 'POST',
            
            jsonData:{
                    data: jsonData,
                    entry_id : Ext.getCmp('entry_id').value,
                    
            },
            success: function (response) {
                    Ext.getCmp('current_date').setValue(new Date())
                    grid = Ext.getCmp('view_grid')
                    grid.calculate_total(grid)
                    Ext.Msg.alert('Status', 'Saved successfully.')
            },
            failure: function () {
                console.log('failed')
            }
        });
    },
    retrieve: function(date){
        
        Ext.Ajax.request({
            url: action_urls.retrieve_journal_invoice,
            method : 'POST',
            
            jsonData:{
                    date: date,
            },
            success: function (response) {
                var response = JSON.parse(response.responseText)
                journal_view_generalgrid.loadData(response)
            },
            failure: function () {
                console.log('failed')
            }
        });
    },
    retrieve_details: function(id){
        Ext.Ajax.request({
            url: action_urls.retrieve_journal_details,
            method : 'POST',
            jsonData:{
                    entry_id : id,
            },
            
            success: function (response) {
                var response = JSON.parse(response.responseText)
                Ext.getCmp('entry_id').setValue(response['entry_id'])
                Ext.getCmp('current_date').setValue(response['inv_date'])
                journal_view_store.loadData(response['details'])
                if(Ext.getCmp('entry_id').value == response['min']){
                    Ext.getCmp('btn_prev').setDisabled(true)
                }
                if(Ext.getCmp('entry_id').value == response['max']){
                    Ext.getCmp('btn_next').setDisabled(true)
                }
                else{
                    Ext.getCmp('btn_next').setDisabled(false)
                }
                var grid = Ext.getCmp('view_grid')
                grid.calculate_total(grid)
            },
            failure: function () {
                console.log('failed')
            }
        });
    },
                    
                    
    
    items:[{
            region: 'center',
            layout: 'fit',
            border: false,
            bodyBorder: false,
            items: new Ext.FormPanel({
                layout: 'border',
                id: 'journal_view',
                bodyBorder: false,
                defaults: {
                    border: false,
                    layout: 'anchor',
                    defaults:{
                        anchor: '100%'
                    }
                },
                items: [{
                        region: 'north',
                        height: 70,
                        layout: 'column',
                        defaults: {
                            layout: 'anchor',
                            defaults: {
                                anchor: '100%'
                            }
                        },
                        items: [{
                                columnWidth: 2 / 3,
                                baseCls: 'x-plain',
                                padding: 10,
                                defaults: {
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
                                items: [
                                    {
                                        layout: {
                                            type: 'table',
                                            columns: 3,
                                            tableAttrs: {
                                                width: '200px'
                                            }
                                        },
                                        border: false,
                                        bodyBorder: false,
                                        id: 'add_del_btn_panel',
                                        margin: '30 0 0 0',
                                        items: [ {
                                                xtype: 'button',
                                                text: "Add Item Row",
                                                iconCls: 'add_new',                                                
                                                id: 'add_row',
                                                width: 100,
                                                listeners: {
                                                    click: function(){
                                                        grid = Ext.getCmp('view_grid')
                                                        if(Ext.getCmp('hidden_val').value == -1 ){
                                                            grid.addRow()
                                                            Ext.getCmp('hidden_val').setValue(1)
                                                        }
                                                    }
                                                }
                                            },
                                            {
                                                xtype: 'button',
                                                text: "Delete Item Row",
                                                margin: '0 0 0 5',
                                                iconCls: 'delete',
                                                id: 'del_item',
                                                width: 110,
                                                listeners: {
                                                    click: function(){ 
                                                        var grid = Ext.getCmp('view_grid')
                                                        var selection = grid.getView().getSelectionModel().getSelection()[0]
                                                        if (selection) {
                                                            Ext.getCmp('view_grid').getStore().remove(selection)
                                                        }
                                                        grid.calculate_total(grid)
                                                    }
                                                }
                                            }/*,{
                                                xtype: 'button',
                                                text: "New Item",
                                                id: 'so__create_item',
                                                margin: '0 0 0 5',
                                                iconCls: 'new',
                                                width: 90,
                                                listeners: {
                                                    
                                                }
                                            }*/
                                        ]
                                    }
                                ]
                            }, 
                            {
                                columnWidth: 1 / 3,
                                baseCls: 'x-plain',
                                style: 'position:relative',
                                id: 'box_date',
                                margin: '5 10 0 0',
                                height: 160,
                                layout: {
                                    type: 'table',
                                    columns: 1,
                                    itemCls: 'right-panel',
                                    tableAttrs: {
                                        width: '230px',
                                        cls: 'right-panel'
                                    }
                                },
                                items: [{
                                        xtype: 'fieldset',
                                        collapsible: false,
                                        padding: '5 5 0 5',
                                        defaults: {
                                            labelWidth: 60
                                        },
                                        items: [{
                                                xtype: 'textfield',
                                                fieldLabel: "Entry #",
                                                readOnly: true,
                                                cls: 'readonly',
                                                id: 'entry_id',
                                                name: 'so_id',
                                                value: null,
                                                enableKeyEvents: true,
                                                listeners: {
                                                    
                                                }
                                            },
                                            {
                                                xtype: 'datefield',
                                                fieldLabel: "Date",
                                                name: 'so_date',
                                                id: 'current_date',
                                                value: new Date(),
                                                //maxValue: new Date(),
                                                format: 'd-m-Y H:i:s',
                                            },
                                            {
                                                xtype: 'hidden',
                                                id: 'hidden_val',
                                                value: -1,
                                            },{
                                                xtype: 'frame',
                                                id: 'hidden_frame',
                                                
                                            }
                                            ]
                                    }
                                ]
                            }
                        ]
                    }, {
                        region: 'center',
                        xtype: 'tabpanel',
                        tabPosition: 'bottom',
                        id: 'center_panel',
                        bodyBorder: false,
                        border: false,
                        defaults: {
                            border: false,
                            bodyBorder: false,
                            listeners: {
                                
                            }
                        },
                        items: [
                            {
                                title: "Add Report Panel",
                                layout: 'border',
                                bodyBorder: false,
                                id: 'report_panel',
                                border: false,
                                
                                defaults: {
                                    border: false,
                                    bodyBorder: false
                                },
                                items: [
                                    {
                                        region: 'center',
                                        layout: 'fit',
                                        items: [{
                                                xtype: "gridpanel",
                                                tabIndex: 4,
                                                id: "view_grid",
                                                margin: '2 5 2 5',
                                                columnLines: true,
                                                store: journal_view_store,
                                                scrollable: true,
                                                selModel: 'rowmodel',
                                                plugins: {
                                                    ptype: 'rowediting',
                                                    clicksToEdit: 1,
                                                    //editing: true,
                                                    //autocancel: false,
                                                    listeners:{
                                                        edit: function(){
                                                            grid = Ext.getCmp('view_grid')
                                                            var selection = grid.getView().getSelectionModel().getSelection()[0]
                                                            row = this.view.focusedRow.rowIndex
                                                            grid.calculate_total(grid)
                                                            if (!((selection.data.acc_name == 'Account Payable' || selection.data.acc_name == 'Account Receivable')&& (selection.data.name == ''))){
                                                                if (selection.data.acc_name != ''){
                                                                    if(!(selection.data.debit_amount > 0 && selection.data.credit_amount > 0)){
                                                                        if (selection.data.debit_amount > 0 || selection.data.credit_amount > 0){
                                                                            if(!((selection.data.debit_amount == null && selection.data.credit_amount == null) || (selection.data.debit_amount == 0 && selection.data.credit_amount == 0))){
                                                                                if(Ext.getCmp('hidden_val').value === 1 || Ext.getCmp('hidden_val').value === 0 || this.view.focusedRow.rowIndex === (grid.store.data.length)-1){
                                                                                    grid.calculate_total(grid)
                                                                                    if(this.view.focusedRow.rowIndex === (grid.store.data.length)-1){
                                                                                        grid.addRow()
                                                                                        Ext.getCmp('hidden_val').setValue(0)
                                                                                    }
                                                                                }
                                                                            }
                                                                            else{
                                                                                grid.plugins[0].startEdit(row , 0);
                                                                                Ext.getCmp('account_debit').markInvalid('Please Enter Debit or Credit Amount')
                                                                                Ext.getCmp('account_credit').markInvalid('Please Enter Debit or Credit Amount')
                                                                            }
                                                                        }
                                                                        else{
                                                                            grid.store.getAt(row).set('debit_amount', '' )
                                                                            grid.store.getAt(row).set('credit_amount', '' )
                                                                            grid.plugins[0].startEdit(row , 0);
                                                                            Ext.getCmp('account_debit').markInvalid('Please Enter Debit or Credit Amount ')
                                                                            Ext.getCmp('account_credit').markInvalid('Please Enter Debit or Credit Amount ')
                                                                        }
                                                                    }
                                                                    else{
                                                                        grid.store.getAt(row).set('debit_amount', '' )
                                                                        grid.store.getAt(row).set('credit_amount', '' )
                                                                        grid.plugins[0].startEdit(row , 0);
                                                                        Ext.getCmp('account_debit').markInvalid('Please Enter only Debit or Credit Amount ')
                                                                        Ext.getCmp('account_credit').markInvalid('Please Enter only Debit or Credit Amount ')
                                                                    }
                                                                }
                                                                else{
                                                                    grid.plugins[0].startEdit(row , 0);
                                                                    Ext.getCmp('grid_account_combo').markInvalid('Please Select an account ')
                                                                }
                                                            }
                                                            else{
                                                                grid.plugins[0].startEdit(row , 0);
                                                                Ext.getCmp('name_so').markInvalid('Please Select any Vendor')
                                                            }
                                                            grid.calculate_total(grid)
                                                            //grid.replace_Item(grid, selection.data.acc_name);
                                                            
                                                        },
                                                        canceledit: function(){
                                                           if(Ext.getCmp('hidden_val').value == 0 || Ext.getCmp('hidden_val').value == 1){
                                                                var grid = Ext.getCmp('view_grid')
                                                                var selection = grid.getView().getSelectionModel().getSelection()[0]
                                                                Ext.getCmp('view_grid').getStore().remove(selection)
                                                                grid.calculate_total(grid)
                                                                Ext.getCmp('hidden_val').setValue(-1)
                                                           }
                                                           
                                                        }
                                                    }
                                                },
                                                listeners:{
                                                    containerclick: function(e){
                                                        grid = Ext.getCmp('view_grid')
                                                        if(Ext.getCmp('hidden_val').value == -1 ){
                                                            grid.addRow()
                                                            Ext.getCmp('hidden_val').setValue(1)
                                                        }
                                                    }  
                                                },
                                                addRow: function(){
                                                    grid = Ext.getCmp('view_grid')
                                                    var last = grid.store.data.length
                                                    grid.getStore().add(1)
                                                    var set_total_debit = parseFloat(Ext.getCmp('total_debit').value)
                                                    var set_total_credit = parseFloat(Ext.getCmp('total_credit').value)
                                                    if(set_total_debit > set_total_credit){
                                                        grid.store.getAt(last).set('credit_amount', set_total_debit - set_total_credit )
                                                    }
                                                    else if(set_total_credit > set_total_debit){
                                                        grid.store.getAt(last).set('debit_amount', set_total_credit - set_total_debit )
                                                    }
                                                    grid.plugins[0].startEdit(last , 1);
                                                },
                                                replace_Item: function(grid, value){
                                                    journal_account_store.removeAt(journal_account_store.find('acc_name', value));
                                                },
                                                calculate_total: function(grid){
                                                    var total_debit = 0
                                                    var total_credit = 0
                                                    var gridStore = grid.getStore()
                                                    for(var count = 0 ; count < gridStore.data.length; count++){
                                                        var debit = parseFloat(gridStore.data.items[count].data.debit_amount)
                                                        var  credit = parseFloat(gridStore.data.items[count].data.credit_amount)
                                                        if(!debit){
                                                            debit = 0
                                                        }
                                                        if (!credit){
                                                             credit = 0
                                                        }
                                                        var total_debit = total_debit + debit
                                                        var total_credit = total_credit +  credit
                                                    }
                                                    var set_total_debit = Ext.getCmp('total_debit')
                                                    var set_total_credit = Ext.getCmp('total_credit')
                                                    set_total_debit.setValue(total_debit)
                                                    set_total_credit.setValue(total_credit)
                                                    if(set_total_debit.value === set_total_credit.value){
                                                        if (set_total_debit.value > 0){
                                                            Ext.getCmp('btn_delete').setDisabled(false);
                                                            Ext.getCmp('btn_save').setDisabled(false);
                                                            Ext.getCmp('btn_copy').setDisabled(false);
                                                            Ext.getCmp('btn_print').setDisabled(false);
                                                            journal_account_store.loadData(store_data);
                                                        }
                                                        else{
                                                            Ext.getCmp('btn_save').setDisabled(true)
                                                            Ext.getCmp('btn_copy').setDisabled(true)
                                                            Ext.getCmp('btn_print').setDisabled(true)
                                                        }
                                                    }
                                                    else{
                                                        Ext.getCmp('btn_save').setDisabled(true)
                                                        Ext.getCmp('btn_copy').setDisabled(true)
                                                    }
                                                    
                                                },
                                                columns: [
                                                    {
                                                        header: "Account",
                                                        id: 'grid_account',
                                                        dataIndex: "acc_name",
                                                        flex: 1,
                                                        sortable: false,
                                                        hideable: false,
                                                        editor: {
                                                            xtype: 'combobox',
                                                            emptyText: 'Select an Account...',
                                                            typeAhead: true,
                                                            id: 'grid_account_combo',
                                                            store: journal_account_store,
                                                            displayField: 'acc_name',
                                                            valueField: 'acc_name',
                                                            allowBlank: true,
                                                            anyMatch: true,
                                                            queryMode: 'local',
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                            }
                                                        }
                                                    },
                                                    {
                                                        header: "Debit",
                                                        id: 'grid_debit',
                                                        dataIndex: "debit_amount",
                                                        width: 100,
                                                        sortable: false,
                                                        hideable: false,
                                                        editor: {
                                                            xtype: 'numberfield',
                                                            id: 'account_debit',
                                                            allowBlank: true,
                                                            value: 0.00,
                                                            enableKeyEvents: true,
                                                            hideTrigger: true,
                                                            keyNavEnabled: false,
                                                            mouseWheelEnabled: false,
                                                            listeners: {
                                                            
                                                            }
                                                            
                                                        }
                                                    },
                                                    {
                                                        header: "Credit",
                                                        id: 'grid_credit',
                                                        dataIndex: "credit_amount",
                                                        width: 100,
                                                        sortable: false,
                                                        hideable: false,
                                                        editor: {
                                                            xtype: 'numberfield',
                                                            id: 'account_credit',
                                                            allowBlank: true,
                                                            //value: 0.00,
                                                            enableKeyEvents: true,
                                                            hideTrigger: true,
                                                            keyNavEnabled: false,
                                                            mouseWheelEnabled: false,
                                                            listeners: {
                                                                
                                                            }

                                                        }
                                                    },
                                                    {
                                                        header: "Memo",
                                                        dataIndex: "memo",
                                                        flex: 1,
                                                        sortable: false,
                                                        hideable: false,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'account_memo',
                                                            allowBlank: true,
                                                            listeners: {
                                                                
                                                            }

                                                        }
                                                    },
                                                    {
                                                        header: "Name",
                                                        id: 'grid_name',
                                                        dataIndex: "name",
                                                        flex: 1,
                                                        sortable: false,
                                                        hideable: false,
                                                        editor: {
                                                            xtype: 'combobox',
                                                            emptyText: 'Select Account Name',
                                                            displayField: 'acc_name',
                                                            typeAhead: true,
                                                            id: 'name_so',
                                                            store: journal_account_store,
                                                            //valueField: 'id',
                                                            allowBlank: true,
                                                            anyMatch: true,
                                                            queryMode: 'local',
                                                            enableKeyEvents: true,
                                                            listeners: {
                                                                change: function(f){
                                                                    
                                                                }
                                                            }
                                                        }
                                                    }, 
                                                    {
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        sortable: false,
                                                        hideable: false,
                                                        items: [{
                                                            icon: 'themes/aursoft/images/remove_new.png',
                                                            tooltip: 'Delete',
                                                        }],
                                                        handler: function (g, rowIndex) {
                                                            var grid = Ext.getCmp('view_grid')
                                                            var rec = grid.getStore().getAt(rowIndex)
                                                            grid.store.remove(rec)
                                                            grid.calculate_total(grid)
                                                        }
                                                    }
                                                ]
                                            }
                                        ]
                                    },{
                                        region: 'south',
                                        items:[
                                            {  
                                                padding: '0 5 0 5',
                                                defaults:{
                                                    type: 'hbox',
                                                },
                                                items:
                                                [
                                                    {   
                                                        type: 'hbox',
                                                        layout:'column',
                                                        anchor: '100%',
                                                        //bodyStyle: 'margin-left: 20%; border:none 0px; background-color: transparent;',
                                                        //padding: '0 0 0 275',
                                                        items:[
                                                            {
                                                                xtype: 'label',
                                                                id: 'total_label',
                                                                text: 'Total',
                                                                style:"font-weight: bold; text-align: right",
                                                                padding: '4 0 0 0',
                                                                width: 100,
                                                            },{
                                                                xtype: 'textfield',
                                                                enableKeyEvents:true,
                                                                value: 0,
                                                                id: 'total_debit',
                                                                emptyText: 'Debit',
                                                                typeAhead: true,
                                                                width: 100,
                                                                padding: '0 0 0 5',
                                                                border:false,
                                                                fieldStyle:"border:none 0px; background-color: transparent; font-weight: bold; background-image: none ",
                                                                readOnly: true,
                                                                listeners: {
                                                                    
                                                                }
                                                            },{
                                                                xtype: 'textfield',
                                                                enableKeyEvents:true,
                                                                value: 0,
                                                                id: 'total_credit',
                                                                emptyText: 'Credit',
                                                                typeAhead: true,
                                                                labelAlign: 'right',
                                                                width: 100,
                                                                padding: '0 0 0 5',
                                                                border:false,
                                                                fieldStyle:"border:none 0px; background-color: transparent; font-weight: bold; background-image: none ",
                                                                readOnly: true,
                                                                listeners: {
                                                                    
                                                                }
                                                            }
                                                        ]
                                                    } ,{
                                                        xtype: 'combo',
                                                        allowBlank: true,
                                                        minChars: 2,
                                                        fieldLabel: 'List of Selected General Journal Enteries',
                                                        triggerAction: 'all',
                                                        enableKeyEvents:true,
                                                        store: journal_view_time,
                                                        displayField: 'date',
                                                        anyMatch: true,
                                                        typeAhead: true,
                                                        queryMode: 'local',
                                                        id: 'selected_jouranl_so',
                                                        labelWidth: 220,
                                                        padding: '4 0 0 0',
                                                        listeners: {
                                                            change: function(){
                                                                if(this.value == 'Today'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -0);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                if(this.value == 'Select Date'){
                                                                    var date_dialogue = new Ext.Window({
                                                                        width: 300,
                                                                        height: 100,
                                                                        title: 'Select Date',
                                                                        items: [{
                                                                            xtype: 'datefield',
                                                                            fieldLabel: "Select Date",
                                                                            id: 'from_date',
                                                                            value: new Date(),
                                                                            maxValue: new Date(),
                                                                            format: 'd-m-Y',
                                                                            style: 'margin-top: 5px; margin-left: 15px'
                                                                        },{
                                                                           xtype: 'button', 
                                                                           text: 'Done',
                                                                           style: 'margin-left: 40%; margin-top: 5px',
                                                                           listeners: {
                                                                               click: function(){
                                                                                    var current = Ext.Date.format(Ext.getCmp('from_date').value, 'Y-m-d')
                                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                                    date_dialogue.close()
                                                                                }
                                                                           }
                                                                        }],
                                                                    }).show()
                                                                }
                                                                else if(this.value == 'Last 7 Days'){
                                                                    var dt3 = Ext.Date.add(new Date(), Ext.Date.DAY, -7);
                                                                    var current = Ext.Date.format(dt3, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                else if(this.value == 'Last 10 Days'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -10);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                else if(this.value == 'Last 15 Days'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -15);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                else if(this.value == 'Last 30 Days'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -30);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                else if(this.value == 'Last 60 Days'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -60);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                else if(this.value == 'Last 90 Days'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -90);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                else if(this.value == 'Last 365 Days'){
                                                                    var dt2 = Ext.Date.add(new Date(), Ext.Date.DAY, -365);
                                                                    var current = Ext.Date.format(dt2, 'Y-m-d')
                                                                    Ext.getCmp('journal-view-panel').retrieve(current)
                                                                }
                                                                
                                                            }
                                                        }
                                                    }
                                                ]
                                            },{
                                                xtype: "gridpanel",
                                                tabIndex: 6,
                                                id: "general_journal_grid",
                                                height: 150,
                                                margin: '0 5 0 5',
                                                store: journal_view_generalgrid,
                                                columnLines: true,
                                                columns: [
                                                    {
                                                        header: "Date",
                                                        dataIndex: "date",
                                                        width: 150,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'date',
                                                            allowBlank: true,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {

                                                            }

                                                        }
                                                    },{
                                                        header: "Entry No.",
                                                        dataIndex: "entry_id",
                                                        width: 150,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'entry_no',
                                                            allowBlank: true,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {

                                                            }

                                                        }
                                                    },{
                                                        header: "ADJ",
                                                        dataIndex: "adj",
                                                        width: 150,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'Adj',
                                                            allowBlank: true,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {

                                                            }

                                                        }
                                                    },{
                                                        header: "Account",
                                                        dataIndex: "account",
                                                        flex: 1,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'journal_account',
                                                            allowBlank: true,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {

                                                            }

                                                        }
                                                    },{
                                                        header: "Memo",
                                                        dataIndex: "memo",
                                                        flex: 1,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'journal_memo',
                                                            allowBlank: true,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {

                                                            }

                                                        }
                                                    },{
                                                        header: "Debit/Credit (+/-)",
                                                        dataIndex: "amount",
                                                        flex: 1,
                                                        editor: {
                                                            xtype: 'textfield',
                                                            id: 'journal_debit_credit',
                                                            allowBlank: true,
                                                            maskRe: /([0-9\s\.]+)$/,
                                                            regex: /[0-9]/,
                                                            enableKeyEvents: true,
                                                            listeners: {

                                                            }

                                                        }
                                                    },{
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        items: [{
                                                                icon: 'themes/aursoft/images/edit.png',
                                                                tooltip: 'Edit',
                                                            }],
                                                        handler: function(g, rowIndex){
                                                            var rec = g.getStore().getAt(rowIndex)
                                                            Ext.getCmp('journal-view-panel').retrieve_details(rec.data.entry_id)
                                                        }
                                                    },{
                                                        xtype: 'actioncolumn',
                                                        width: 21,
                                                        items: [{
                                                                icon: 'themes/aursoft/images/remove_new.png',
                                                                tooltip: 'Delete',
                                                            }],
                                                        handler: function(g, rowIndex){
                                                            var rec = g.getStore().getAt(rowIndex)
                                                            Ext.MessageBox.confirm('Delete', 'Are you sure ?', function(btn){
                                                                if(btn === 'yes'){
                                                                    Ext.getCmp('journal-view-panel').delete(rec.data.entry_id)
                                                                }
                                                                else{

                                                                }
                                                              });
                                                        }
                                                    }

                                                ]

                                            }
                                        ]

                                    }
                                ]
                            }
                        ]
                    }
                ]
            })
        }
    ],
    tbar: [
           { xtype: 'button', 
             text: 'New',
             iconCls: 'new',
             tooltip:'Create a new entry.',
             listeners:{
                click: function(){
                    Ext.getCmp('journal-view-panel').refresh()
                    Ext.getCmp('current_date').setValue(new Date())
                    grid = Ext.getCmp('view_grid')
                    grid.calculate_total(grid)
                }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             id: 'btn_save',
             text: 'Save',
             iconCls: 'save',
             tooltip:'Save New Entry',
             disabled: true,
             listeners:{
                 click:function(){
                    Ext.getCmp('journal-view-panel').save()
                    Ext.getCmp('journal-view-panel').refresh()
                 }
             }
           }
           ,
           '-',
           { xtype: 'button', 
             text: 'Delete',
             id: 'btn_delete',
             iconCls: 'delete',
             tooltip:'Delete Selected Entry',
             disabled: true,
             listeners:{
                 click:function(){
                     Ext.MessageBox.confirm('Delete', 'Are you sure ?', function(btn){
                        if(btn === 'yes'){
                            Ext.getCmp('journal-view-panel').delete(Ext.getCmp('entry_id').value)
                            Ext.getCmp('journal-view-panel').refresh()
                        }
                        else{
                           
                        }
                      });
                    
                 }
             }
           },
           '-',
           { xtype: 'button', 
             text: 'Create a Copy',
             id: 'btn_copy',
             tooltip:'Copy New Entry',
             iconCls: 'copy',
             disabled: true,
             listeners:{
                 click:function(){
                     Ext.getCmp('journal-view-panel').save()
                 }
             }
           },
           '-',
           { xtype: 'button', 
             id : 'btn_print',
             text: 'Print',
             tooltip:'Print New Entry',
             iconCls: 'print',
             disabled: true,
             listeners:{
                 click:function(){
                    
                     
                     var print_iframe = Ext.get("print_journal").dom.contentWindow
                     var tbody_html = "";
                     tbody_html += '<html><head><title>AURSoft</title></head>'
                     tbody_html += '<body><h2 style="text-align: center;">AURSoft</h2>'
                     tbody_html += '<h3 style="text-align: center;">General Journal Transaction</h3>'
                     tbody_html += '<h5 style="text-align: center;">'+Ext.getCmp('current_date').value +'</h5>'
                     tbody_html += '<table style="align-self: center; width: 100%"> <tr><th style="border-bottom: 1px solid #ddd"> Account Name</th> <th style="border-bottom: 1px solid #ddd"> Debit Amount</th> <th style="border-bottom: 1px solid #ddd"> Credit Amount</th> <th style="border-bottom: 1px solid #ddd"> Memo</th> <th style="border-bottom: 1px solid #ddd"> Name </th></tr>'
                     for (i=0; i<journal_view_store.data.items.length; i++){
                        if (journal_view_store.data.items[i].data.debit_amount == null){
                            journal_view_store.data.items[i].data.debit_amount = ''
                        }
                        if (journal_view_store.data.items[i].data.credit_amount == null){
                            journal_view_store.data.items[i].data.credit_amount = ''
                        }
                        tbody_html += '<tr><td style="border-bottom: 1px solid #ddd;text-align: center"> '+ journal_view_store.data.items[i].data.acc_name +'</td> <td style="border-bottom: 1px solid #ddd;text-align: center">'+ journal_view_store.data.items[i].data.debit_amount +'</td> <td style="border-bottom: 1px solid #ddd;text-align: center">'+ journal_view_store.data.items[i].data.credit_amount +'</td> <td style="border-bottom: 1px solid #ddd;text-align: center">'+ journal_view_store.data.items[i].data.memo +'</td> <td style="border-bottom: 1px solid #ddd;text-align: center">'+ journal_view_store.data.items[i].data.name +'</td></tr>'
                    }
                     
                     tbody_html += '<tr><td></td> <td></td> <td></td> <td></td> <td></td></tr>'
                     tbody_html += '<tr><td></td> <td></td> <td></td> <td></td> <td></td></tr>'
                     tbody_html += '<tr><td></td> <td></td> <td></td> <td></td> <td></td></tr>'
                     tbody_html += '<tr><th style="text-align: center"> Total</th> <th style="text-align: center">'+ Ext.getCmp('total_debit').value +'</th> <th style="text-align: center">'+ Ext.getCmp('total_credit').value +'</th> <th></th> <th></th></tr>'
                     tbody_html += '</table> </body>'
                     
                     print_iframe.$(".journal_body").html(tbody_html);
                     print_iframe.print()
                    
                 }
                
             }
           },
            { xtype: 'button', 
              text: 'Next',
              id: 'btn_next',
              iconCls: 'next-order-icon',
              cls:'next-order',
              tooltip:'Open Next Entry',
              disabled: true,
              listeners:{
                  click:function(){
                      Ext.getCmp('journal-view-panel').next()
                  }
              }
            },
            { xtype: 'button', 
              id: 'btn_prev',
              text: 'Prev',                     
              iconCls: 'previous-order-icon',
              cls:'previous-order',
              tooltip:'Open Previous Entry',
              listeners:{
                  click:function(){
                      Ext.getCmp('journal-view-panel').previous()
                  }
              }
            }


    ]
}
