_register = {
    id: 'register-panel',
    closable: true,
    closeAction: 'hide',
    layout: 'border',
    frame: true,
    title: 'Account Register',
    listeners: {
        beforeclose: function () {
            homePage();
            account_store.clearFilter();
        }
        ,
        afterrender: function () {

        },
        keyup: function (e, obj) {
            console.log(e)
            console.log(obj)
        },
        show: function () {
            
            register_obj = {};
            register_obj.showDiscount = true;
            register_obj.balance = 0;
            account_store.filter([
                {
                    filterFn: function (item) {
                        return item.get("acc_head_id") != "4" && item.get("acc_head_id") != "5"
                    }
                }
            ])
            
            Ext.defer(function () {
                Ext.getCmp("reg_customers_combo").focus();
                Ext.getCmp("reg_customers_combo").setValue('');
                Ext.getCmp("send_register_btn").setDisabled(true);

            }, 50)

            var map_register = new Ext.util.KeyMap("register-panel", [
                {
                    key: [10, 13],
                    fn: function () {

                        Ext.getCmp("new_register_btn").fireHandler();
                    }
                }, {
                    key: "abc",
                    fn: function () {}
                }, {
                    key: "\t",
                    ctrl: true,
                    shift: true,
                    fn: function () { }
                }
            ]);

            register_obj.lessBalance = function (me, balance) {
                Ext.Msg.show({
                    title: 'Insufficient Funds',
                    msg: 'You avaible amount is <b>Rs. ' + balance + '</b> for pay method ' + Ext.getCmp("payment__mode_combo").getRawValue() + ', are you want to continue?',
                    buttons: Ext.Msg.YESNO,
                    icon: Ext.Msg.QUESTION,
                    fn: function (btn, text) {
                        if (btn == 'yes') {
                            payInProcess = false;
                            register_obj.payfunc(me, true, '1');
                        }
                    }
                });
            }
            var payInProcess = false;
            register_obj.payfunc = function (me, byPass, print) {                
                if (me.isValid()) {
                    if (payInProcess) {
                        return false;
                    }
                    payInProcess = true;
                    var _url = "";
                    var pay_type = me.findField("R_order_type").getValue();
                    _url = action_urls.receivable_pay;
                    if (Ext.getCmp("register_Type").getValue() == "2") {
                        if (Ext.getCmp("reg_banks_combo").getValue() == Ext.getCmp("payment__mode_combo").getValue()) {
                            Ext.Msg.show({
                                title: 'Error',
                                msg: 'Ooops Both accounts cann\'t be the same.',
                                buttons: Ext.Msg.OK,
                                icon: Ext.Msg.ERROR
                            });

                            return false;
                        }
                    }
                    if (!byPass) {
                        var payment_type = me.findField("payment_type").getValue();
                        var pay_method = Ext.getCmp("payment__mode_combo").getValue();
                        var pay_total = me.findField("paid_total").getValue();
                        var loan_id = me.findField("loans_id").getValue();
                        if (loan_id == 0) {
                            if (pay_type == 2 && payment_type != 2 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                register_obj.lessBalance(me, payment_balances[pay_method]);
                                return false;
                            }
                        } else if (payment_type == 2 && parseFloat(pay_total) > payment_balances[pay_method]) {
                            register_obj.lessBalance(me, payment_balances[pay_method]);
                            return false;
                        }

                    }

                    if (_url) {
                        LoadingMask.showMessage('Please wait..');
                        me.submit({
                            clientValidation: true,
                            url: _url,
                            params: {
                                type: pay_type,
                                payment_time: Ext.Date.format(new Date(), 'H:i:s')
                            },
                            success: function (form, action) {
                                payInProcess = false;
                                LoadingMask.hideMessage();
                                if (action.result.success) {
                                    if(print=='1'){ 
                                        console.log('hello');
                                        reports_obj.printPayment(); 
                                    }
                                    
                                    register_pay_form.hide();
                                    var type_id = 1, account_id = 0;
                                    var loans = 0;
                                    if (Ext.getCmp("register_Type").getValue() == "0") {
                                        var customer_account = customer_store_account.getById(Ext.getCmp("reg_customers_combo").getValue());
                                        if (customer_account) {
                                            account_id = customer_account.get("account_id");
                                        }
                                        type_id = "1";
                                    } else if (Ext.getCmp("register_Type").getValue() == "1") {
                                        var vendor_account_id = vendor_store_active.getById(Ext.getCmp("reg_vendors_combo").getValue())
                                        if (vendor_account_id) {
                                            account_id = vendor_account_id.get("vendor_acc_id");
                                        }
                                        type_id = "2";
                                    } else if (Ext.getCmp("register_Type").getValue() == "2") {
                                        account_id = Ext.getCmp("reg_banks_combo").getValue();
                                        type_id = "3";
                                    } else if (Ext.getCmp("register_Type").getValue() == "3") {
                                        account_id = Ext.getCmp("reg_expense_combo").getValue();
                                        type_id = "4";
                                    } else if (Ext.getCmp("register_Type").getValue() == "4") {
                                        account_id = Ext.getCmp("reg_loans_combo").getValue();
                                        loans = 1;
                                        type_id = loan_store_active.getById(Ext.getCmp("reg_loans_combo").getValue()).get("loan_type") == "14" ? "1" : "2";
                                    }
                                    if (type_id == 2) {
                                        getBalance(account_id, register_obj, -1);
                                    } else {
                                        getBalance(account_id, register_obj);
                                    }
                                    if (account_id) {
                                        Ext.getCmp("register-panel-grid").store.load({
                                            params: {
                                                account_id: account_id,
                                                type_id: type_id,
                                                loans: loans,
                                                start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                            }
                                        });
                                        Ext.getCmp("reg_customers_combo").focus(true, 100);
                                    } else {
                                        Ext.Msg.show({
                                            title: 'Invalid Account',
                                            msg: 'Account Id is invalid. Please check name.',
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.ERROR
                                        });
                                    }


                                } else {
                                    Ext.Msg.show({
                                        title: 'Failure',
                                        msg: 'Ooops some thing went wrong. Please try again.',
                                        buttons: Ext.Msg.OK,
                                        icon: Ext.Msg.ERROR
                                    });
                                }
                            },
                            failure: function (form, action) {
                                LoadingMask.hideMessage();
                                payInProcess = false;
                                failureMessages(form, action);
                            }
                        });
                    }
                }
            }
            
            /*Pay window*/
            if (register_pay_form == null) {
                register_pay_form = Ext.widget('window', {
                    title: 'Account Receivable',
                    width: 450,
                    height: 270,
                    minHeight: 200,
                    closeAction: 'hide',
                    id: 'register_pay_window',
                    layout: 'fit',
                    resizable: true,
                    modal: true,
                    listeners: {
                        afterrender: function () {

                            var map_pay_window = new Ext.util.KeyMap("register_pay_window", [
                                {
                                    key: [10, 13],
                                    fn: function () {
                                        Ext.getCmp("pay_win_button").fireHandler();
                                    }
                                }
                            ]);
                        },
                        show: function () {
                            var me = this.down('form').getForm();
                            me.reset();
                            me.findField("paid_total").focus(true, 100);
                            getBalance(-1);
                            var type_id = 1, account_id = 0;
                            if (Ext.getCmp("register_Type").getValue() == "0" || (Ext.getCmp("register_Type").getValue() == "4" && loan_store_active.getById(Ext.getCmp("reg_loans_combo").getValue()).get("loan_type") == "14")) {
                                if (Ext.getCmp("register_Type").getValue() == "4") {
                                    account_id = Ext.getCmp("reg_loans_combo").getValue();
                                    me.findField("loans_id").setValue(1);
                                } else {
                                    account_id = customer_store_account.getById(Ext.getCmp("reg_customers_combo").getValue()).get("account_id");
                                }
                                type_id = "1";
                            } else if (Ext.getCmp("register_Type").getValue() == "1" || (Ext.getCmp("register_Type").getValue() == "4" && loan_store_active.getById(Ext.getCmp("reg_loans_combo").getValue()).get("loan_type") == "15")) {
                                if (Ext.getCmp("register_Type").getValue() == "4") {
                                    account_id = Ext.getCmp("reg_loans_combo").getValue();
                                    me.findField("loans_id").setValue(2);
                                } else {
                                    account_id = vendor_store_active.getById(Ext.getCmp("reg_vendors_combo").getValue()).get("vendor_acc_id");
                                }
                                type_id = "2";
                            } else if (Ext.getCmp("register_Type").getValue() == "2") {
                                account_id = Ext.getCmp("reg_banks_combo").getValue();
                                type_id = "3";
                            } else if (Ext.getCmp("register_Type").getValue() == "3") {
                                account_id = Ext.getCmp("reg_expense_combo").getValue();
                                type_id = "4";
                            }
                            Ext.getCmp("R_caccount_id").setValue(account_id);
                            Ext.getCmp("balance_total").setVisible(false);

                            if (type_id == "1") {
                                register_pay_form.setTitle("Account Receivable");
                                Ext.getCmp("balance_total").setVisible(true);
                                Ext.getCmp("balance_total").setValue(register_obj.balance);
                                Ext.getCmp("payment__methods_combo").setVisible(true);
                                Ext.getCmp("payment__mode_combo").setVisible(true);
                                Ext.getCmp("paid_total").setFieldLabel("Pay");
                                Ext.getCmp("pay_win_button").setText("Pay");
                                register_pay_form.setHeight(320);
                            } else if (type_id == "2") {
                                register_pay_form.setTitle("Account Payable");
                                Ext.getCmp("payment__methods_combo").setVisible(true);
                                Ext.getCmp("balance_total").setVisible(true);
                                Ext.getCmp("balance_total").setValue(register_obj.balance);
                                Ext.getCmp("payment__mode_combo").setVisible(true);
                                Ext.getCmp("paid_total").setFieldLabel("Pay");
                                Ext.getCmp("pay_win_button").setText("Pay");
                                register_pay_form.setHeight(320);
                            } else if (type_id == "3") {
                                register_pay_form.setTitle("Bank Deposite");
                                Ext.getCmp("payment__methods_combo").setVisible(false);
                                Ext.getCmp("payment__mode_combo").setVisible(true);
                                Ext.getCmp("paid_total").setFieldLabel("Deposite");
                                Ext.getCmp("pay_win_button").setText("Deposite");
                                register_pay_form.setHeight(280);
                            } else if (type_id == "4") {
                                register_pay_form.setTitle("Expense");
                                Ext.getCmp("payment__methods_combo").setVisible(true);
                                Ext.getCmp("payment__mode_combo").setVisible(true);
                                Ext.getCmp("paid_total").setFieldLabel("Pay");
                                Ext.getCmp("pay_win_button").setText("Paid");
                                register_pay_form.setHeight(300);
                            }

                            me.findField("R_order_type").setValue(type_id);

                        }
                    },
                    items: Ext.widget('form', {
                        layout: 'anchor',
                        border: false,
                        bodyPadding: 10,
                        defaults: {
                            border: false,
                            anchor: '100%'


                        },
                        items: [{
                                xtype: 'datefield',
                                fieldLabel: 'Date Paid',
                                value: new Date(),
                                id: 'payment_paid_date',
                                name: 'payment_paid_date',
                                maxValue: new Date(),
                                format: 'd-m-Y'
                            },
                            {
                                xtype: 'combo',
                                fieldLabel: 'Type',
                                id: 'payment__methods_combo',
                                allowBlank: false,
                                valueField: 'method_id',
                                displayField: 'method_name',
                                name: 'payment_type',
                                value: '1',

                                store: Ext.create('Ext.data.Store', {
                                    fields: ['method_id', 'method_name'],
                                    filters: [function (record, id) {

                                            return true;
                                        }],
                                    data: [
                                        {
                                            "method_id": "1",
                                            "method_name": "PMT"
                                        },
                                        {
                                            "method_id": "2",
                                            "method_name": "Charge"
                                        },
                                        {
                                            "method_id": "3",
                                            "method_name": "Discount"
                                        }
                                    ]
                                }),
                                queryMode: 'local',
                                listeners: {}
                            }, {
                                fieldLabel: 'Balance',
                                xtype: 'textfield',
                                id: 'balance_total',
                                name: 'balance_total',
                                readOnly: true,
                                value: '0.00'
                            }, {
                                fieldLabel: 'Pay',
                                cls: 'pay',
                                xtype: 'textfield',
                                id: 'paid_total',
                                name: 'paid_total',
                                maskRe: /([0-9\s\.]+)$/,
                                regex: /[0-9]/,
                                validateValue: function (value) {
                                    var isValid = true;
                                    if (value == 0) {
                                        isValid = false;
                                    }
                                    return isValid;
                                },
                                value: '0.00'
                            },
                            {
                                layout: 'hbox',
                                items: [{
                                        xtype: 'combo',
                                        flex:1,
                                        fieldLabel: 'Payment Method',
                                        id: 'payment__mode_combo',
                                        allowBlank: false,
                                        valueField: 'method_id',
                                        displayField: 'method_name',
                                        name: 'payment_method',
                                        value: '-1',
                                        store: Ext.create('Ext.data.Store', {
                                            fields: ['method_id', 'method_name', 'balance'],
                                            data: payment_method_store
                                        }),
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (obj, n, o, e) {
                                                var val = obj.getValue();
                                                getBalance(val);
                                            }
                                        }
                                    }, {
                                        xtype: 'combo',
                                        fieldLabel: "", 
                                        hidden:false,
                                        style: 'margin-left:10px',
                                        id: 'register_sale_rep_assign',
                                        displayField: 'salesrep_name',                                        
                                        queryMode: 'local',
                                        name:'salesrep_id',
                                        typeAhead: true,
                                        valueField: 'id',
                                        labelSeparator: '',
                                        width:172,
                                        listeners: {
                                            
                                        },
                                        value: '1',
                                        store: salesrep_store
                                    }]

                            },
                            {
                                xtype: 'textarea',
                                style: 'margin-top:10px',
                                fieldLabel: 'Remarks',
                                height: 80,
                                name: 'payment_remarks',
                                id: 'payment_remarks'
                            }, {
                                xtype: 'hidden',
                                name: 'R_order_type',
                                id: 'R_order_type',
                                value: '1'
                            },
                            {
                                xtype: 'hidden',
                                name: 'R_caccount_id',
                                id: 'R_caccount_id',
                                value: '0'
                            },
                            {
                                xtype: 'hidden',
                                name: 'loans_id',
                                id: 'loans_id',
                                value: '0'
                            }
                        ],

                        buttons: [
                            
                            {
                                text: 'Pay',
                                id: 'pay_win_button',
                                handler: function () {
                                    var me = this.up('form').getForm();
                                    if (me.isValid()) {
                                        var pay_type = me.findField("R_order_type").getValue();
                                        var pay_total = me.findField("paid_total").getValue();
                                        var payment_type = me.findField("payment_type").getValue();
                                        var pay_method = Ext.getCmp("payment__mode_combo").getValue();
                                        var loan_id = me.findField("loans_id").getValue();
                                        if (loan_id == 0) {
                                            if ((payment_type == 1 || payment_type == 3) && (pay_type == 1 || pay_type == 2))
                                            {
                                                if (parseFloat(pay_total) > register_obj.balance) {
                                                    Ext.Msg.show({
                                                        title: 'Payment exceeded',
                                                        msg: 'You are paying more than balance, are you sure you want to proceed?',
                                                        buttons: Ext.Msg.YESNO,
                                                        icon: Ext.Msg.QUESTION,
                                                        fn: function (btn, text) {
                                                            if (btn == 'yes') {
                                                                register_obj.payfunc(me, flase, '1');
                                                            }
                                                        }
                                                    });
                                                } else {

                                                    if (pay_type == 2 && payment_type != 2 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                                        register_obj.lessBalance(me, payment_balances[pay_method]);
                                                    } else {
                                                        register_obj.payfunc(me, true, '1');
                                                    }
                                                }
                                            } else if (pay_type == 4) {
                                                if (parseFloat(pay_total) > payment_balances[pay_method]) {
                                                    register_obj.lessBalance(me, payment_balances[pay_method]);
                                                } else {
                                                    register_obj.payfunc(me, true, '1');
                                                }
                                            } else {
                                                register_obj.payfunc(me, false, '1');
                                            }
                                        } else {
                                            //Loans Payments
                                            if (loan_id == 1) {
                                                //Accounts receivable check
                                                if (payment_type == 1 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                                    register_obj.lessBalance(me, payment_balances[pay_method]);
                                                } else if (payment_type == 2 && parseFloat(pay_total) > register_obj.balance) {
                                                    Ext.Msg.show({
                                                        title: 'Payment exceeded',
                                                        msg: 'You are paying more than balance, are you sure you want to proceed?',
                                                        buttons: Ext.Msg.YESNO,
                                                        icon: Ext.Msg.QUESTION,
                                                        fn: function (btn, text) {
                                                            if (btn == 'yes') {
                                                                register_obj.payfunc(me, false, '1');
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    register_obj.payfunc(me, false, '1');
                                                }
                                            } else if (loan_id == 2) {
                                                //Accounts payable check

                                                if (payment_type == 2 && parseFloat(pay_total) > register_obj.balance) {
                                                    Ext.Msg.show({
                                                        title: 'Payment exceeded',
                                                        msg: 'You are paying more than balance, are you sure you want to proceed?',
                                                        buttons: Ext.Msg.YESNO,
                                                        icon: Ext.Msg.QUESTION,
                                                        fn: function (btn, text) {
                                                            if (btn == 'yes') {
                                                                register_obj.payfunc(me, false, '1');
                                                            }
                                                        }
                                                    });
                                                } else if (payment_type == 2 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                                    register_obj.lessBalance(me, payment_balances[pay_method]);
                                                } else {
                                                    register_obj.payfunc(me, false, '1');
                                                }
                                            }

                                        }
                                        if (navigator.onLine) {
                                            var user_id = Ext.getCmp("reg_customers_combo").getValue();
                                            if (use_message == '1' && Ext.getCmp("cust_mobile").getValue() != '') {
                                                if (payment_type == 1) {
                                                    var remaining_balance = me.findField("balance_total").getValue() - pay_total;
                                                    var message = "Your Balance was = " + me.findField("balance_total").getValue() + " Rs" + "\nNow You Paid = " + pay_total + " Rs" + "\nYour Current Balance is = " + remaining_balance + " Rs" + "\nThank you \n" + store_name;

                                                    Ext.Ajax.request({
                                                        url: action_urls.sendsms,
                                                        params: {
                                                            username: api_username,
                                                            password: api_password,
                                                            from: masking,
                                                            user_id: user_id,
                                                            user_type: 'customer',
                                                            to: Ext.getCmp("cust_mobile").getValue(),
                                                            message: message
                                                        },
                                                        success: function () {},
                                                        failure: function () {}
                                                    });
                                                } else if (payment_type == 2) {
                                                    var remaining_balance = +me.findField("balance_total").getValue() + +pay_total;
                                                    var message = "Your Balance was = " + me.findField("balance_total").getValue() + " Rs" + "\nNow You Charge = " + pay_total + " Rs" + "\nYour Current Balance is = " + remaining_balance + " Rs" + "\nThank you \n" + store_name;

                                                    Ext.Ajax.request({
                                                        url: action_urls.sendsms,
                                                        params: {
                                                            username: api_username,
                                                            password: api_password,
                                                            from: masking,
                                                            user_id: user_id,
                                                            user_type: 'customer',
                                                            to: Ext.getCmp("cust_mobile").getValue(),
                                                            message: message
                                                        },
                                                        success: function () {},
                                                        failure: function () {}
                                                    });

                                                } else {

                                                }
                                            }
                                        } else {
                                            Ext.Msg.show({
                                                title: 'Message',
                                                msg: 'You have no internet Connection!',
                                                buttons: Ext.Msg.OK,
                                                callback: function (btn) {
                                                    if ('ok' === btn) {
                                                    }
                                                }
                                            });
                                        }
                                    }
                                }
                            }, 
                            {
                                text: 'Pay and Print',
                                handler: function () {
                                    var me = this.up('form').getForm();
                                    if (me.isValid()) {
                                        var pay_type = me.findField("R_order_type").getValue();
                                        var pay_total = me.findField("paid_total").getValue();
                                        var payment_type = me.findField("payment_type").getValue();
                                        var pay_method = Ext.getCmp("payment__mode_combo").getValue();
                                        var loan_id = me.findField("loans_id").getValue();
                                        if (loan_id == 0) {
                                            if ((payment_type == 1 || payment_type == 3) && (pay_type == 1 || pay_type == 2))
                                            {
                                                if (parseFloat(pay_total) > register_obj.balance) {
                                                    Ext.Msg.show({
                                                        title: 'Payment exceeded',
                                                        msg: 'You are paying more than balance, are you sure you want to proceed?',
                                                        buttons: Ext.Msg.YESNO,
                                                        icon: Ext.Msg.QUESTION,
                                                        fn: function (btn, text) {
                                                            if (btn == 'yes') {
                                                                register_obj.payfunc(me, false, '1');
                                                            }
                                                        }
                                                    });
                                                } else {

                                                    if (pay_type == 2 && payment_type != 2 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                                        register_obj.lessBalance(me, payment_balances[pay_method]);
                                                    } else {
                                                        register_obj.payfunc(me, true, '1');
                                                    }
                                                }
                                            } else if (pay_type == 4) {
                                                if (parseFloat(pay_total) > payment_balances[pay_method]) {
                                                    register_obj.lessBalance(me, payment_balances[pay_method]);
                                                } else {
                                                    register_obj.payfunc(me, true, '1');
                                                }
                                            } else {
                                                register_obj.payfunc(me, false, '1');
                                            }
                                        } else {
                                            //Loans Payments
                                            if (loan_id == 1) {
                                                //Accounts receivable check
                                                if (payment_type == 1 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                                    register_obj.lessBalance(me, payment_balances[pay_method]);
                                                } else if (payment_type == 2 && parseFloat(pay_total) > register_obj.balance) {
                                                    Ext.Msg.show({
                                                        title: 'Payment exceeded',
                                                        msg: 'You are paying more than balance, are you sure you want to proceed?',
                                                        buttons: Ext.Msg.YESNO,
                                                        icon: Ext.Msg.QUESTION,
                                                        fn: function (btn, text) {
                                                            if (btn == 'yes') {
                                                                register_obj.payfunc(me, false, '1');
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    register_obj.payfunc(me, false, '1');
                                                }
                                            } else if (loan_id == 2) {
                                                //Accounts payable check

                                                if (payment_type == 2 && parseFloat(pay_total) > register_obj.balance) {
                                                    Ext.Msg.show({
                                                        title: 'Payment exceeded',
                                                        msg: 'You are paying more than balance, are you sure you want to proceed?',
                                                        buttons: Ext.Msg.YESNO,
                                                        icon: Ext.Msg.QUESTION,
                                                        fn: function (btn, text) {
                                                            if (btn == 'yes') {
                                                                register_obj.payfunc(me, false, '1');
                                                            }
                                                        }
                                                    });
                                                } else if (payment_type == 2 && parseFloat(pay_total) > payment_balances[pay_method]) {
                                                    register_obj.lessBalance(me, payment_balances[pay_method]);
                                                } else {
                                                    register_obj.payfunc(me, false, '1');
                                                }
                                            }

                                        }
                                        if (navigator.onLine) {
                                            var user_id = Ext.getCmp("reg_customers_combo").getValue();
                                            if (use_message == '1' && Ext.getCmp("cust_mobile").getValue() != '') {
                                                if (payment_type == 1) {
                                                    var remaining_balance = me.findField("balance_total").getValue() - pay_total;
                                                    var message = "Your Balance was = " + me.findField("balance_total").getValue() + " Rs" + "\nNow You Paid = " + pay_total + " Rs" + "\nYour Current Balance is = " + remaining_balance + " Rs" + "\nThank you \n" + store_name;

                                                    Ext.Ajax.request({
                                                        url: action_urls.sendsms,
                                                        params: {
                                                            username: api_username,
                                                            password: api_password,
                                                            from: masking,
                                                            user_id: user_id,
                                                            user_type: 'customer',
                                                            to: Ext.getCmp("cust_mobile").getValue(),
                                                            message: message
                                                        },
                                                        success: function () {},
                                                        failure: function () {}
                                                    });
                                                } else if (payment_type == 2) {
                                                    var remaining_balance = +me.findField("balance_total").getValue() + +pay_total;
                                                    var message = "Your Balance was = " + me.findField("balance_total").getValue() + " Rs" + "\nNow You Charge = " + pay_total + " Rs" + "\nYour Current Balance is = " + remaining_balance + " Rs" + "\nThank you \n" + store_name;

                                                    Ext.Ajax.request({
                                                        url: action_urls.sendsms,
                                                        params: {
                                                            username: api_username,
                                                            password: api_password,
                                                            from: masking,
                                                            user_id: user_id,
                                                            user_type: 'customer',
                                                            to: Ext.getCmp("cust_mobile").getValue(),
                                                            message: message
                                                        },
                                                        success: function () {},
                                                        failure: function () {}
                                                    });

                                                } else {

                                                }
                                            }
                                        } else {
                                            Ext.Msg.show({
                                                title: 'Message',
                                                msg: 'You have no internet Connection!',
                                                buttons: Ext.Msg.OK,
                                                callback: function (btn) {
                                                    if ('ok' === btn) {
                                                    }
                                                }
                                            });
                                        }
                                    }
                                }
                            },
                            {
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
        beforerender: function () {
            customer_store.load();
            vendor_store.load();
            bank_store.load();
            expense_store.load();
            loan_store.load();
            reports_obj = {
                getDateMysqlFormatWithTime: function (objDate) {
                    var currentdate = objDate;
                    var cdate = "";
                    if (objDate) {
                        var cdate = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + "-" + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
                    }
                    return cdate;
                },
                editEntry: function () {
                    var grid = Ext.getCmp("journal-panel-grid");
                    var selectedRow = grid.selModel.getSelection()[0];
                    var secondRow = null;
                    secondRow = grid.store.getById((parseInt(selectedRow.get("id")) + 1).toString());
                    if (!secondRow || selectedRow.get("ref_id") != secondRow.get("ref_id")) {
                        secondRow = grid.store.getById((parseInt(selectedRow.get("id")) - 1).toString());
                    }
                    Ext.getCmp("j_date").setValue(reports_obj.jsDate(selectedRow.get("date")));
                    Ext.getCmp("j_description").setValue(selectedRow.get("details"))

                    reports_obj.setEntries(selectedRow);
                    reports_obj.setEntries(secondRow);
                },
                setEntries: function (model) {
                    if (model.get("credit") == "") {
                        var d_amount = model.get("debit");
                        Ext.getCmp("j_debit_amount").setValue(d_amount)
                        Ext.getCmp("acc_debit_id").setValue(model.get("acc_id"))
                        Ext.getCmp("debit_entry_id").setValue(model.get("r_id"))
                    } else {
                        var c_amount = model.get("credit");
                        Ext.getCmp("j_credit_amount").setValue(c_amount)
                        Ext.getCmp("acc_credit_id").setValue(model.get("acc_id"));
                        Ext.getCmp("credit_entry_id").setValue(model.get("r_id"))
                    }
                },
                jsDate: function (strDate) {
                    var dateArray = strDate.split("/");
                    var dateObj = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]);
                    return dateObj;
                },
                deleteEntry: function () {
                    Ext.Msg.show({
                        title: 'Delete',
                        msg: 'Are you really want to delete entry?',
                        buttons: Ext.Msg.YESNOCANCEL,
                        icon: Ext.Msg.QUESTION,
                        fn: function (btn, text) {
                            if (btn == 'yes') {
                                Ext.Ajax.request({
                                    url: action_urls.delete_journal_entry,
                                    method: 'POST',
                                    params: {
                                        _ids: getSelection(Ext.getCmp("journal-panel-grid"))
                                    },
                                    success: function (response) {

                                        var data = Ext.JSON.decode(response.responseText);
                                        if (data.message === "success") {
                                            Ext.getCmp("journal-panel-grid").store.load({
                                                params: {
                                                    start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                    end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                                }
                                            });
                                            Ext.getCmp("edit_register_btn").setDisabled(false);
                                            Ext.getCmp("delete_register_btn").setDisabled(false);
                                        }
                                    },
                                    failure: function () {}
                                });
                            }
                        }
                    });

                },
                printme: function () {
                    var Register_type = Ext.getCmp("register_Type").getValue();
                    var print_iframe = Ext.get("print_register_iframe").dom.contentWindow;
                    var _grid = Ext.pluck(Ext.getCmp('register-panel-grid').store.data.items, 'data');
                    var tbody_html = "";
                    var _dec = 0, _inc = 0;
                    console.log(_grid);
                    for (var i = 0; i < _grid.length; i++) {
                        _inc = _grid[i].increase ? Ext.util.Format.number(_grid[i].increase, "0.00") : "";
                        _dec = _grid[i].decrease ? Ext.util.Format.number(_grid[i].decrease, "0.00") : "";
                        tbody_html += "<tr><td  align='center'>" + _grid[i].date + "</td>";
                        tbody_html += "<td>" + _grid[i].number + "</td>";
                        tbody_html += "<td align='left'>" + _grid[i].payee + "</td>";
                        tbody_html += "<td align='left'>" + _grid[i].account + "</td>";
                        tbody_html += "<td align='left'>" + _grid[i].detail + "</td>";
                        tbody_html += "<td align='left'>" + _inc + "</td>";
                        tbody_html += "<td align='left'>" + _dec + "</td>";
                        tbody_html += "<td align='right'>" + Ext.util.Format.number(_grid[i].balance, "0.00") + "</td></tr>";
                    }
                    if(Register_type=='0'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_customers_combo").getRawValue());
                    }
                    else if(Register_type=='1'){
                      print_iframe.$("#name").html(Ext.getCmp("reg_vendors_combo").getRawValue()); 
                    } else if(Register_type=='3'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_banks_combo").getRawValue());
                    }else if(Register_type=='4'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_expense_combo").getRawValue());
                    }else if(Register_type=='4'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_loans_combo").getRawValue());                    }
                    // print_iframe.$(".register_customer").html(Ext.getCmp("acc_register_id").getRawValue())
                    print_iframe.$(".register-large-body").html(tbody_html);
                    print_iframe.print();
                },
                printpaymentInvoice: function () {
                    var print_iframe = Ext.get("print_register__payment_iframe").dom.contentWindow;
                    var sel = Ext.getCmp('register-panel-grid').getSelectionModel().getSelection();
                    console.log(sel.length);
                    for (var i = 0; i < sel.length; i++) {
                        var inWord = "";
                        var amount = "";
                        if(sel[i].get("increase")==""){
                            amount = sel[i].get("decrease");
                            inWord = inWords(sel[i].get("decrease")); 
                        } else {
                            amount = sel[i].get("increase");
                            inWord = inWords(sel[i].get("increase"));
                        }
                        print_iframe.$("#print_date").html(sel[i].get("date"));
                        print_iframe.$("#name").html(sel[i].get("payee"));
                        print_iframe.$("#type").html(sel[i].get("account"));
                        print_iframe.$("#amount").html(amount+" Rs");
                        print_iframe.$("#inWord").html(inWord);
                        print_iframe.$("#remarks").html(sel[i].get("detail"));
                        print_iframe.print();
                        
                    }
                },
                printPayment: function () {
                    var Register_type = Ext.getCmp("register_Type").getValue();
                    var print_iframe = Ext.get("print_register__payment_iframe").dom.contentWindow;
                    var inWord = inWords(Ext.getCmp("paid_total").getValue());
                    print_iframe.$("#print_date").html(Ext.getCmp("payment_paid_date").getRawValue());
                    if(Register_type=='0'){
                      print_iframe.$("#name").html(Ext.getCmp("reg_customers_combo").getRawValue());
                      print_iframe.$("#type").html(Ext.getCmp("payment__methods_combo").getRawValue());
                    } else if(Register_type=='1'){
                      print_iframe.$("#name").html(Ext.getCmp("reg_vendors_combo").getRawValue()); 
                      print_iframe.$("#type").html(Ext.getCmp("payment__methods_combo").getRawValue());
                    } else if(Register_type=='3'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_banks_combo").getRawValue());
                        print_iframe.$("#type").html('---');
                    }else if(Register_type=='4'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_expense_combo").getRawValue());
                        print_iframe.$("#type").html(Ext.getCmp("payment__methods_combo").getRawValue());
                    }else if(Register_type=='4'){
                        print_iframe.$("#name").html(Ext.getCmp("reg_loans_combo").getRawValue());
                        print_iframe.$("#type").html('---');
                    }
                    
                    print_iframe.$("#amount").html(Ext.getCmp("paid_total").getValue()+" Rs");
                    print_iframe.$("#inWord").html(inWord);
                    print_iframe.$("#remarks").html(Ext.getCmp("payment_remarks").getValue());
                    print_iframe.print();
                },
                
                
            };
           var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
            var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety']; 
           function inWords (num) {
            if ((num = num.toString()).length > 9) return 'overflow';
            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return; var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
            return str;
        }
        }
    },
    defaults: {
        border: false
    },
    items: [{
            region: 'north',
            height: 100,
            layout: 'fit',
            items: new Ext.FormPanel({
                id: 'register-form',
                layout: 'column',
                defaults: {
                    layout: 'anchor',
                    defaults: {
                        anchor: '100%'
                    }
                },
                items: [{
                        columnWidth: 1 / 2,
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
                                xtype: 'fieldcontainer',
                                combineErrors: true,
                                msgTarget: 'side',
                                id: 'register_for',
                                fieldLabel: 'Register for',
                                defaults: {
                                    hideLabel: true
                                },
                                items: [
                                    {
                                        xtype: 'combo',
                                        fieldLabel: 'Type',
                                        id: 'register_Type',
                                        displayField: 'name',
                                        queryMode: 'local',
                                        typeAhead: true,
                                        editable: false,
                                        valueField: 'id',
                                        value: '0',
                                        listeners: {
                                            change: function (obj, n, o, e) {
                                                var type = obj.getValue();
                                                console.log("type===" + type);
                                                Ext.getCmp("register-panel-grid").getStore().removeAll();
                                                Ext.getCmp("r_start_date").setValue(Ext.Date.add(new Date(), Ext.Date.DAY, -10));
                                                Ext.getCmp("send_register_btn").setDisabled(true);
                                                if (type == "0") {
                                                    Ext.getCmp("payment__methods_combo").store.loadData([{"method_id": "1", "method_name": "PMT"}, {"method_id": "2", "method_name": "Charge"}, {"method_id": "3", "method_name": "Discount"}]);
                                                    Ext.getCmp("reg_customers_combo").setVisible(true);
                                                    Ext.getCmp("reg_vendors_combo").setVisible(false);
                                                    Ext.getCmp("reg_banks_combo").setVisible(false);
                                                    Ext.getCmp("reg_expense_combo").setVisible(false);
                                                    Ext.getCmp("reg_loans_combo").setVisible(false);
                                                    Ext.getCmp("reg_customers_combo").clearValue();                                                    
                                                    Ext.getCmp("register-panel-grid").columns[1].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").columns[2].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").columns[3].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Customer");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Account");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(6).setText("Amt Chrg");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(7).setText("Amt Paid");
                                                } else if (type == "1") {
                                                    Ext.getCmp("payment__methods_combo").store.loadData([{"method_id": "1", "method_name": "PMT"}, {"method_id": "2", "method_name": "Charge"}, {"method_id": "3", "method_name": "Discount"}]);
                                                    Ext.getCmp("reg_customers_combo").setVisible(false);
                                                    Ext.getCmp("reg_vendors_combo").setVisible(true);
                                                    Ext.getCmp("reg_banks_combo").setVisible(false);
                                                    Ext.getCmp("reg_expense_combo").setVisible(false);
                                                    Ext.getCmp("reg_loans_combo").setVisible(false);
                                                    Ext.getCmp("reg_vendors_combo").clearValue();
                                                    Ext.getCmp("register-panel-grid").columns[1].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").columns[2].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").columns[3].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Vendor");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Account");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(6).setText("Billed");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(7).setText("Paid");
                                                } else if (type == "2") {
                                                    Ext.getCmp("payment__methods_combo").store.loadData([{"method_id": "1", "method_name": "PMT"}, {"method_id": "2", "method_name": "Charge"}]);
                                                    Ext.getCmp("reg_customers_combo").setVisible(false);
                                                    Ext.getCmp("reg_vendors_combo").setVisible(false);
                                                    Ext.getCmp("reg_banks_combo").setVisible(true);
                                                    Ext.getCmp("reg_expense_combo").setVisible(false);
                                                    Ext.getCmp("reg_loans_combo").setVisible(false);
                                                    Ext.getCmp("reg_banks_combo").clearValue();
                                                    Ext.getCmp("register-panel-grid").columns[1].setVisible(false);
                                                    Ext.getCmp("register-panel-grid").columns[2].setVisible(false);
                                                    Ext.getCmp("register-panel-grid").columns[3].setVisible(true);
                                                    //Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(2).setText("Bank");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(2).setText("Account");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Deposited");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(5).setText("Paid");
                                                    Ext.getCmp("r_start_date").setValue(new Date());
                                                } else if (type == "3") {
                                                    Ext.getCmp("payment__methods_combo").store.loadData([{"method_id": "1", "method_name": "PMT"}]);
                                                    Ext.getCmp("reg_customers_combo").setVisible(false);
                                                    Ext.getCmp("reg_vendors_combo").setVisible(false);
                                                    Ext.getCmp("reg_banks_combo").setVisible(false);
                                                    Ext.getCmp("reg_loans_combo").setVisible(false);
                                                    Ext.getCmp("reg_expense_combo").setVisible(true);
                                                    Ext.getCmp("reg_expense_combo").clearValue();
                                                    Ext.getCmp("register-panel-grid").columns[1].setVisible(false);
                                                    Ext.getCmp("register-panel-grid").columns[2].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").columns[3].setVisible(true);
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(2).setText("Expense");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Account");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(5).setText("Deposited");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(6).setText("Paid");
                                                } else if (type == "4") {

                                                    Ext.getCmp("payment__methods_combo").store.loadData([{"method_id": "1", "method_name": "PMT"}, {"method_id": "2", "method_name": "Returned"}]);
                                                    Ext.getCmp("reg_customers_combo").setVisible(false);
                                                    Ext.getCmp("reg_vendors_combo").setVisible(false);
                                                    Ext.getCmp("reg_banks_combo").setVisible(false);
                                                    Ext.getCmp("reg_expense_combo").setVisible(false);
                                                    Ext.getCmp("reg_loans_combo").setVisible(true);
                                                    Ext.getCmp("reg_loans_combo").clearValue();
                                                    Ext.getCmp("register-panel-grid").columns[1].setVisible(false);
                                                    Ext.getCmp("register-panel-grid").columns[2].setVisible(false);

                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(2).setText("Payment Type");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Description");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Paid");
                                                    Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(5).setText("Returned");
                                                }
                                                Ext.getCmp("new_register_btn").setDisabled(true);
                                            }
                                        },
                                        store: new Ext.data.Store({
                                            fields: ['id', 'name'],
                                            data: [
                                                {
                                                    "id": "0",
                                                    "name": "Customer"
                                                },

                                                {
                                                    "id": "1",
                                                    "name": "Vendor"
                                                },

                                                {
                                                    "id": "2",
                                                    "name": "Cash & Bank"
                                                },
                                                {
                                                    "id": "3",
                                                    "name": "Expense"
                                                },
                                                {
                                                    "id": "4",
                                                    "name": "Loans"
                                                }
                                            ]
                                        })
                                    },
                                    {
                                        xtype: 'combo',
                                        fieldLabel: '',
                                        id: 'reg_customers_combo',
                                        name: 'customer_id',
                                        allowBlank: false,
                                        forceSelection: true,
                                        valueField: 'cust_id',
                                        tabIndex: 1,
                                        flex: 1,
                                        displayField: 'cust_name',
                                        emptyText: 'Select a Customer...',
                                        store: customer_store_account,
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                                var record = f.findRecordByValue(f.getValue());
                                                if (record) {

                                                    Ext.getCmp("cust_mobile").setValue(record.get("cust_mobile"));
                                                    Ext.getCmp("new_register_btn").setDisabled(false);
                                                    Ext.getCmp("send_register_btn").setDisabled(false);
                                                    getBalance(record.get("account_id"), register_obj);
                                                    Ext.getCmp("register-panel-grid").store.load({
                                                        params: {
                                                            account_id: record.get("account_id"),
                                                            type_id: "1",
                                                            start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                            end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    },
                                    {
                                        xtype: 'combo',
                                        fieldLabel: '',
                                        id: 'reg_vendors_combo',
                                        allowBlank: false,
                                        emptyText: 'Select a Vendor...',
                                        forceSelection: true,
                                        hidden: true,
                                        name: 'vendor_id',
                                        flex: 1,
                                        valueField: 'vendor_id',
                                        displayField: 'vendor_name',
                                        value: 'Select Vendor',
                                        store: vendor_store_active,
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                                var record = f.findRecordByValue(f.getValue());
                                                if (f.getValue() !== "-2") {
                                                    if (record) {                                                        
                                                        Ext.getCmp("new_register_btn").setDisabled(false);
                                                        Ext.getCmp("cust_mobile").setValue(record.get("vendor_mobile"));
                                                        getBalance(record.get("vendor_acc_id"), register_obj, -1);
                                                        Ext.getCmp("send_register_btn").setDisabled(false);
                                                        Ext.getCmp("register-panel-grid").store.load({
                                                            params: {
                                                                account_id: record.get("vendor_acc_id"),
                                                                type_id: "2",
                                                                start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                                end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                                            }
                                                        });
                                                    }
                                                } else {
                                                    new_vendor_form.show();
                                                    Ext.getCmp("vendors_combo").setValue("");
                                                }
                                            }
                                        }
                                    },
                                    {
                                        xtype: 'combo',
                                        fieldLabel: '',
                                        id: 'reg_banks_combo',
                                        allowBlank: false,
                                        emptyText: 'Select a Bank...',
                                        forceSelection: true,
                                        hidden: true,
                                        name: 'bank_id',
                                        flex: 1,
                                        valueField: 'bank_id',
                                        displayField: 'bank_name',
                                        value: 'Select Bank',
                                        store: bank_store_active,
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                                if (f.getValue()) {

                                                    Ext.getCmp("new_register_btn").setDisabled(false);
                                                    Ext.getCmp("register-panel-grid").store.load({
                                                        params: {
                                                            account_id: f.getValue(),
                                                            type_id: "3",
                                                            start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                            end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    },
                                    {
                                        xtype: 'combo',
                                        fieldLabel: '',
                                        id: 'reg_expense_combo',
                                        allowBlank: false,
                                        emptyText: 'Select a Expense...',
                                        forceSelection: true,
                                        hidden: true,
                                        name: 'expense_id',
                                        flex: 1,
                                        valueField: 'expense_id',
                                        displayField: 'expense_name',
                                        value: 'Select Expense',
                                        store: expense_store_active,
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                                if (f.getValue()) {
                                                    Ext.getCmp("new_register_btn").setDisabled(false);
                                                    Ext.getCmp("register-panel-grid").store.load({
                                                        params: {
                                                            account_id: f.getValue(),
                                                            type_id: "4",
                                                            start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                            end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    },
                                    {
                                        xtype: 'combo',
                                        fieldLabel: '',
                                        id: 'reg_loans_combo',
                                        allowBlank: false,
                                        emptyText: 'Select Loan Account...',
                                        forceSelection: true,
                                        hidden: true,
                                        name: 'loan_id',
                                        flex: 1,
                                        valueField: 'loan_id',
                                        displayField: 'loan_name',
                                        value: 'Select Account',
                                        store: loan_store_active,
                                        queryMode: 'local',
                                        listeners: {
                                            change: function (f, obj) {
                                                if (f.getValue()) {
                                                    Ext.getCmp("new_register_btn").setDisabled(false);
                                                    var record = f.findRecordByValue(f.getValue());
                                                    if (record.get("loan_type") == 14) {
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Paid");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(5).setText("Returned");
                                                        getBalance(f.getValue(), register_obj);
                                                    } else {
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Received");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(5).setText("Returned");
                                                        getBalance(f.getValue(), register_obj, -1);
                                                    }

                                                    Ext.getCmp("register-panel-grid").store.load({
                                                        params: {
                                                            account_id: f.getValue(),
                                                            type_id: record.get("loan_type") == 14 ? "1" : "2",
                                                            loans: 1,
                                                            start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                            end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue())
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    }
                                    ,
                                    {
                                        xtype: 'combo',
                                        fieldLabel: 'Select Account',
                                        displayField: 'acc_name',
                                        hidden: true,
                                        id: 'acc_register_id',
                                        store: account_store,
                                        emptyText: 'Select Account',
                                        queryMode: 'local',
                                        flex: 1,
                                        valueField: 'id',
                                        allowBlank: true,
                                        editable: true,
                                        typeAhead: true,
                                        listeners: {
                                            change: function (obj, n, o, e) {
                                                if (n == -1) {
                                                    account_selected_combo = obj.getId();
                                                    obj.setValue(o);
                                                    winMode = 0;
                                                    account_form.show();
                                                } else {
                                                    var type_id = account_store.getById(obj.getValue()).get("acc_type_id")
                                                    Ext.getCmp("register-panel-grid").store.load({
                                                        params: {
                                                            //start_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                            //end_date:reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue()),
                                                            account_id: obj.getValue(),
                                                            type_id: type_id
                                                        }
                                                    });
                                                    if (type_id == "1") {
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Customer");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Account");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(6).setText("Amt Chrg");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(7).setText("Amt Paid");
                                                        Ext.getCmp("new_register_btn").setDisabled(false);
                                                    } else if (type_id == "2") {
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Vendor");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Account");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(6).setText("Billed");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(7).setText("Paid");
                                                        Ext.getCmp("new_register_btn").setDisabled(false);
                                                    } else {
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(3).setText("Payee");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(4).setText("Account");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(6).setText("Increase");
                                                        Ext.getCmp("register-panel-grid").getView().getHeaderAtIndex(7).setText("Decrease");
                                                        Ext.getCmp("new_register_btn").setDisabled(true);
                                                    }
                                                }

                                            }

                                        }
                                    }, {
                                        xtype: 'hidden',
                                        name: 'cust_mobile',
                                        id: 'cust_mobile',
                                        value: '0'
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        columnWidth: 1 / 2,
                        baseCls: 'x-plain',
                        margin: '5 8 0 0',
                        height: 157,
                        layout: {
                            type: 'table',
                            columns: 1,
                            tableAttrs: {
                                width: '230px',
                                style: 'float:right'
                            }
                        },
                        items: [{
                                xtype: 'fieldset',
                                collapsible: false,
                                padding: '5 5 0 5',
                                defaults: {
                                    labelWidth: 60
                                },
                                items: [
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'From Date',
                                        id: 'r_start_date',
                                        value: Ext.Date.add(new Date(), Ext.Date.DAY, -10),
                                        maxValue: new Date(),
                                        format: 'd-m-Y',
                                        listeners: {
                                            change: function () {

                                            }
                                        }
                                    },
                                    {
                                        xtype: 'datefield',
                                        fieldLabel: 'End Date',
                                        id: 'r_end_date',
                                        value: new Date(),
                                        maxValue: new Date(),
                                        format: 'd-m-Y',
                                        listeners: {
                                            change: function () {


                                            }
                                        }
                                    },
                                    {
                                        xtype: 'button',
                                        text: 'Search',
                                        style: 'float:left;margin-left:63px;margin-bottom:5px;',
                                        width: 80,
                                        listeners: {
                                            click: function () {
                                                var type_id = 1;
                                                var account_id = 0;
                                                var loans = 0;
                                                if (Ext.getCmp("register_Type").getValue() == "0") {
                                                    type_id = 1;
                                                    account_id = customer_store_account.getById(Ext.getCmp("reg_customers_combo").getValue()).get("account_id");
                                                } else if (Ext.getCmp("register_Type").getValue() == "1") {
                                                    type_id = 2;
                                                    account_id = vendor_store_active.getById(Ext.getCmp("reg_vendors_combo").getValue()).get("vendor_acc_id");
                                                } else if (Ext.getCmp("register_Type").getValue() == "2") {
                                                    type_id = 3;
                                                    account_id = Ext.getCmp("reg_banks_combo").getValue();
                                                } else if (Ext.getCmp("register_Type").getValue() == "3") {
                                                    type_id = 4;
                                                    account_id = Ext.getCmp("reg_expense_combo").getValue();
                                                } else if (Ext.getCmp("register_Type").getValue() == "4") {
                                                    account_id = Ext.getCmp("reg_loans_combo").getValue();
                                                    loans = 1;
                                                    type_id = loan_store_active.getById(Ext.getCmp("reg_loans_combo").getValue()).get("loan_type") == "14" ? "1" : "2";
                                                }
                                                Ext.getCmp("register-panel-grid").store.load({
                                                    params: {
                                                        type_id: type_id,
                                                        loans: loans,
                                                        start_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_start_date").getValue()),
                                                        end_date: reports_obj.getDateMysqlFormatWithTime(Ext.getCmp("r_end_date").getValue()),
                                                        account_id: account_id
                                                    }
                                                });
                                            }
                                        }
                                    }

                                ]
                            }


                        ]
                    }
                ]
            })
        },
        {
            region: 'center',
            layout: 'fit',
            items: [{
                    xtype: "gridpanel",
                    id: "register-panel-grid",
                    margin: '0 5 5 5',
                    store: {
                        proxy: {
                            type: "ajax",
                            url: action_urls.get_register,
                            reader: {
                                type: "json",
                                root: 'register',
                                idProperty: 'id',
                                totalProperty: 'totalCount'
                            }
                        },
                        model: Ext.define("RegisterModel", {
                            extend: "Ext.data.Model",
                            fields: [
                                "id",
                                "ref_id",
                                "payee",
                                "account",
                                "date",
                                "increase",
                                "date",
                                "decrease",
                                "number",
                                "detail",
                                "balance"
                            ]
                        }) && "RegisterModel"
                    },
                    listeners: {
                        afterRender: function (cmp) {
                            //this.superclass.afterRender.call(this);

                            this.nav = new Ext.KeyNav(this.getEl(), {
                                del: function (e) {
                                }
                            });
                        }

                    },
                    selModel: Ext.create('Ext.selection.CheckboxModel', {
                        listeners: {
                            selectionchange: function (sm, selections) {
                                /*if(selections.length==1){
                                 Ext.getCmp("edit_register_btn").setDisabled(false);
                                 Ext.getCmp("delete_register_btn").setDisabled(false);
                                 }
                                 else if(selections.length>1){
                                 Ext.getCmp("edit_register_btn").setDisabled(true);
                                 Ext.getCmp("delete_register_btn").setDisabled(false);
                                 }
                                 else{
                                 Ext.getCmp("edit_register_btn").setDisabled(false);
                                 Ext.getCmp("delete_register_btn").setDisabled(false);
                                 }*/
                                    if(selections.length>0){
                                        Ext.getCmp("print_register_entry_btn").setDisabled(false);
                                    } else {
                                        Ext.getCmp("print_register_entry_btn").setDisabled(true);
                                    }
                            }
                        }
                    }),
                    columnLines: true,
                    columns: [
                        {
                            text: "Date",
                            width: 90,
                            sortable: true,
                            dataIndex: 'date'
                        },

                        {
                            text: "Number",
                            width: 90,
                            sortable: false,
                            dataIndex: 'number'
                        },

                        {
                            text: "Customer",
                            flex: 3,
                            sortable: false,
                            dataIndex: 'payee'
                        },

                        {
                            text: "Account",
                            flex: 3,
                            sortable: false,
                            dataIndex: 'account'
                        },
                        {
                            text: "Description",
                            flex: 3,
                            sortable: false,
                            dataIndex: 'detail'
                        },

                        {
                            text: "Amt Chrg",
                            width: 120,
                            sortable: false,
                            dataIndex: 'increase',
                            renderer: Ext.util.Format.numberRenderer('0.00'),
                            tdCls: 'debit_color'
                        },

                        {
                            text: "Amt Paid",
                            width: 120,
                            sortable: false,
                            dataIndex: 'decrease',
                            renderer: Ext.util.Format.numberRenderer('0.00'),
                            tdCls: 'credit_color'
                        },

                        {
                            text: "Balance",
                            width: 120,
                            sortable: false,
                            dataIndex: 'balance',
                            renderer: Ext.util.Format.numberRenderer('0.00')
                        }

                    ]
                }]
        }
    ]
    ,
    tbar: [
        {
            xtype: 'button',
            text: 'New',
            iconCls: 'new',
            disabled: true,
            id: 'new_register_btn',
            tooltip: 'Create a new register entry.',
            listeners: {
                click: function () {
                    var isValid = false;
                    var account_id = 0;
                    var register_type = Ext.getCmp("register_Type").getValue();
                    var salesrepbox = Ext.getCmp("register_sale_rep_assign");
                    salesrepbox.setVisible(false);
                    if (register_type === "0" && Ext.getCmp("reg_customers_combo").getValue()) {
                        isValid = true;
                        var customer_account = customer_store_account.getById(Ext.getCmp("reg_customers_combo").getValue());
                        if (customer_account) {
                            account_id = customer_account.get("account_id");
                        }
                        salesrepbox.setVisible(true);
                    } else if (register_type === "1" && Ext.getCmp("reg_vendors_combo").getValue()) {
                        var vendor_account_id = vendor_store_active.getById(Ext.getCmp("reg_vendors_combo").getValue())
                        if (vendor_account_id) {
                            account_id = vendor_account_id.get("vendor_acc_id");                            
                        }
                        salesrepbox.setVisible(true);
                        isValid = true;
                    } else if (register_type === "2" && Ext.getCmp("reg_banks_combo").getValue()) {
                        isValid = true;
                        account_id = 1;
                    } else if (register_type === "3" && Ext.getCmp("reg_expense_combo").getValue()) {
                        isValid = true;
                        account_id = 1;
                    } else if (register_type === "4" && Ext.getCmp("reg_loans_combo").getValue()) {
                        isValid = true;
                        account_id = 1;
                    }
                    if (!account_id) {
                        Ext.Msg.show({
                            title: 'Invalid Account',
                            msg: 'Account Id is invalid. Please check name.',
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.ERROR
                        });
                        isValid = false;
                    }
                    if (isValid) {
                        register_pay_form.show();
                    }
                }

            }
        },
        {
            xtype: 'button',
            text: 'Print',
            iconCls: 'print',
            tooltip: 'Print this register.',
            listeners: {
                click: function () {
                    reports_obj.printme();
                }
            }
        }
        ,
        '-',
        {
            xtype: 'button',
            text: 'Edit',
            iconCls: 'edit',
            disabled: true,
            id: 'edit_register_btn',
            tooltip: 'Edit selected entry.',
            listeners: {
                click: function () {
                    reports_obj.editEntry();
                }
            }
        },
        {
            xtype: 'button',
            text: 'Delete',
            id: 'delete_register_btn',
            iconCls: 'delete',
            disabled: true,
            tooltip: 'Delete selected entry.',
            listeners: {
                click: function () {
                    reports_obj.deleteEntry();
                }
            }
        },
        {
            xtype: 'button',
            text: 'Print Entry',
            id: 'print_register_entry_btn',
            iconCls: 'print',
            disabled: true,
            tooltip: 'Print selected entry.',
            listeners: {
                click: function () {
                    reports_obj.printpaymentInvoice();
                }
            }
        },
        {
            xtype: 'button',
            text: 'Send SMS',
            id: 'send_register_btn',
            iconCls: 'sms',
            disabled: true,
            tooltip: 'Send Manual SMS',
            listeners: {
                click: function () {
                    sms_manual_form.show();
                }
            }
        },

        '-',
        {
            xtype: 'button',
            text: 'Close',
            tooltip: 'Close Register.',
            iconCls: 'close',
            listeners: {
                click: function () {
                    homePage();
                }
            }
        }

    ]
}