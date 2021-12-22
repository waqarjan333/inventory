({
id: 'sale-invoice-panel',
layout: 'border',
closable: true,
height: '100%',
frame: true,
title:labels_json.saleinvoicepanel["heading_title_"+sale_invoice_mode],
listeners: {
beforeclose: function () {
if(win.closeMe) {
win.closeMe = false;
return true;
}
if(Ext.getCmp("sale_invoice_grid").store.getCount() > 0 && Ext.getCmp("so_hidden_id").getValue() == "0"){

Ext.Msg.show({
         title:'Close confirmation'
        ,msg:'Are you sure you want to close the invoice?'
        ,buttons:Ext.Msg.YESNO
        ,callback:function(btn) {
            if('yes' === btn) {
                sale_invoice_return_mode = 0;
                 //homePage();
                 window.location.reload();
            }
        }
    });
} else {
sale_invoice_return_mode = 0;
 homePage();
 //window.location.reload();
}
return false; 
},
hide:function(){
if(user_right=="3")  {
window.location.href = urls.logout;
}
},
beforerender: function () {
customer_store.load();



if(enableCustomRegions==1){
Ext.getCmp("_cust_group_name_").setVisible(true);
} else {
Ext.getCmp("_cust_group_name_").setVisible(false);
} 

if(Ext.getCmp("so_hidden_id").getValue() == 0 || Ext.getCmp("so_hidden_id").getValue() == '' ) {
  Ext.getCmp("so_remove_all_item").setDisabled(false); 
} else {
Ext.getCmp("so_remove_all_item").setDisabled(true); 
}
//Show OR Hide Warehouse Column
if(enableWarehouse==1){
Ext.getCmp('sale_invoice_grid').columns[5].hidden = false;
} else {
Ext.getCmp('sale_invoice_grid').columns[5].hidden = true;
}
//Show OR Hide UOM Column
if(enableUom==1){
Ext.getCmp('sale_invoice_grid').columns[4].hidden = false;
} else {
Ext.getCmp('sale_invoice_grid').columns[4].hidden = true;
}
if(bonusQuantity==1)
{
Ext.getCmp('sale_invoice_grid').columns[3].hidden = false;
} else {
Ext.getCmp('sale_invoice_grid').columns[3].hidden = true;
}
},
afterrender: function (obj) {

editModelSO = Ext.getCmp("sale_invoice_grid").plugins[0];
editModelPick = Ext.getCmp("pick_invoice_grid").plugins[0];



var _view = Ext.getCmp("sale_invoice_grid").getView();
if(user_right!=="3")  {
Ext.create('Ext.tip.ToolTip', {        
title: '<h3 class="popover-title">'+labels_json.saleinvoicepanel.item_info+'</h3>',                        
target: _view.el,
delegate:"img.y-action-col-icon",
anchor: 'left',
cls:'callout',
trackMouse: true,
html: null,
width: 250,
autoHide: true,
closable: true,                
listeners: {                    
    beforeshow: function updateTipBody(tip) {                        
        OBJ_Action.populateTooltip(tip);                        
    }
}
});
}
},
show: function () {
Ext.getCmp("sale_invoice_grid").store.removeAll();
Ext.getCmp("pick_invoice_grid").store.removeAll();
Ext.getCmp("invoice_invoice_grid").store.removeAll();
Ext.getCmp('_so_weight').setVisible(false);
Ext.getCmp('weightEl').setVisible(false);

Ext.getCmp("customers_combo").focus();
try{
Ext.get("so_paid-inputEl").on("mousedown", function (e, t) {
e.stopPropagation();
if (Ext.getCmp("so_hidden_id").getValue() !== "0") {
    var pay_window = invoice_pay_form.down('form').getForm();
    if(Ext.getCmp("so_total_balance").getValue()>0){
        invoice_pay_form.show();
        }
    pay_window.findField("G_order_type").setValue('2');
    pay_window.findField("G_invoice_id").setValue(Ext.getCmp("so_hidden_id").getValue());
    pay_window.findField("G_vendor_id").setValue(Ext.getCmp("customers_combo").getValue());
}
});

}
catch(e){ }

Ext.get("so_discount_invoice-inputEl").on("mousedown", function (e, t) {
e.stopPropagation();
if (!OBJ_Action.getform().hasInvalidField()) {
   if(Ext.getCmp("so_total_balance").getValue().replace('-','') != "0.00"){
        discount_form.show();
    } 
    
}
});
if(!Ext.getCmp("customers_combo").getValue()){
Ext.getCmp("load_estimates_button").setDisabled(false);
}
if(user_right==="3" && !isNaN(parseInt(customer_id))){
setTimeout(function(){
    Ext.getCmp("customers_combo").setValue(customer_id);
    Ext.getCmp("customers_combo").setReadOnly(true);
    Ext.getCmp("order_customer_search").setValue(customer_id);
    Ext.getCmp("order_customer_search").setReadOnly(true);
    Ext.getCmp("so__create_item").setVisible(false);
    Ext.getCmp("so_create_invoice").setVisible(false);
},1000)
}

/*Pay window*/
discount_form = Ext.widget('window', {
title: 'Discount',
width: 600,
height: 200,
id:'discount_form',
minHeight: 200,
closeAction: 'hide',
layout: 'fit',
resizable: true,
modal: true,
listeners: {
    afterrender:function(){
    
    var discount_form = new Ext.util.KeyMap("discount_form", [
        {
            key: [10,13],
            fn: function(){ 
                Ext.getCmp("save_discount").fireHandler();
            }
        }
    ]);  
},
    show: function () {
        var me = this.down('form').getForm();
        me.reset();
        me.findField("so_discount_total").focus(true, 100);
        var _total = Ext.getCmp("so_total").getValue();
        me.findField("so_paid_total").setValue(_total);
        var _discount = Ext.getCmp("so_discount_invoice").getValue();
        me.findField("so_discount_total").setValue(_discount);
        if(sale_invoice_mode=='1'){
        me.findField("so_discount_total").setFieldLabel('Deduction');
        me.findField("so_total_after_discount").setFieldLabel('After Deduction');
        me.findField("so_total_after_discount").setValue(Ext.util.Format.number(parseFloat(_total)+parseFloat(-1*_discount), "0.00"));
        } else {
        me.findField("so_discount_total").setFieldLabel('Discount');
        me.findField("so_total_after_discount").setFieldLabel('After Discount');
        me.findField("so_total_after_discount").setValue(Ext.util.Format.number(_total - _discount, "0.00"));
        }
        
        
        
    }
},
items: Ext.widget('form', {
    layout: 'anchor',
    border: false,
    bodyPadding: 10,
    defaults: {
        border: false,
        anchor: '100%',
        labelWidth: 150,
    },
    items: [{
            fieldLabel: 'Total',
            cls: 'pay',
            xtype: 'textfield',
            id: 'so_paid_total',
            readOnly: true,
            name: 'so_paid_total',
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
            fieldLabel: 'Discount',
            xtype: 'textfield',
            id: 'so_discount_total',
            name: 'so_discount_total',
//                            maskRe: /([0-9\s\.]+)$/,
//                            regex: /[0-9]/,
            enableKeyEvents: true,
            value:'0.00',
            listeners: {
                change: function (f, obj) {
                    if (sale_invoice_mode == "1") {
                        var value = parseFloat(f.getValue());
                        if (value > 0) {
                            f.setValue(value * -1);
                        }
                    }
                },
                keyup: function () {
                    var _discount = parseFloat(Ext.getCmp("so_discount_total").getValue());
                    var _total = parseFloat(Ext.getCmp("so_paid_total").getValue());
                    if(sale_invoice_mode=='1'){
                       if (_discount) { 
                        Ext.getCmp("so_total_after_discount").setValue(Ext.util.Format.number(_total+(-1*_discount), "0.00"));
                        }
                        else {
                            Ext.getCmp("so_total_after_discount").setValue(Ext.util.Format.number(_total, "0.00"));
                        }
                    } else {
                        if (_discount) { 
                        Ext.getCmp("so_total_after_discount").setValue(Ext.util.Format.number(_total - _discount, "0.00"));
                        }
                        else {
                            Ext.getCmp("so_total_after_discount").setValue(Ext.util.Format.number(_total, "0.00"));
                        }
                    }
                    
                }
            }
        },
        {
            fieldLabel: 'After Discount',
            xtype: 'textfield',
            cls: 'pay',
            readOnly:true,
            id: 'so_total_after_discount',
            name: 'so_total_after_discount',
            maskRe: /([0-9\s\.]+)$/,
            regex: /[0-9]/,
            validateValue: function (value) {
                var isValid = true;
                if (value == 0) {
                    isValid = false;
                }
                return isValid;
            },
            value: '0.00',
            enableKeyEvents: true,
            listeners: {
                keyup: function () {
                    var _total = Ext.getCmp("so_paid_total").getValue();
                    var _after_discount = Ext.getCmp("so_total_after_discount").getValue();
                    if(sale_invoice_mode=='1'){
                        Ext.getCmp("so_discount_total").setValue(Ext.util.Format.number(parseFloat(_total)+parseFloat(_after_discount), "0.00"));
                    } else { 
                        Ext.getCmp("so_discount_total").setValue(Ext.util.Format.number(parseFloat(_total) - parseFloat(_after_discount), "0.00"));
                    }
                    
                }
            }
        },
        {
            xtype: 'hidden',
            name: 'so_invoice_id',
            id: 'so_invoice_id',
            value: '0'
        }
    ],
    buttons: [{
            text: 'Done',
            id:'save_discount',
            handler: function () {
                var me = this.up('form').getForm();
                if (me.isValid()) {
                    var discount_val = Ext.getCmp("so_discount_total").getValue();
                    discount_val = (discount_val == "") ? 0 : discount_val;
                    Ext.getCmp("so_discount_invoice").setValue(Ext.util.Format.number(parseFloat(discount_val), "0.00"));
                    
                    OBJ_Action.calc.calTotalSubTotal();
                    this.up('window').hide();
                }
            }
        },{
            text: 'Cancel',
            handler: function () {
                this.up('form').getForm().reset();
                this.up('window').hide();
            }
        }]
})
});
/*End Discount window*/

OBJ_Action.addMewInvoiceRow = false;
OBJ_Action.searchKeyPress = 0;
OBJ_Action.searchChange = 0;
OBJ_Action.shiftFocus = false;
OBJ_Action.tabpressed = false;
OBJ_Action.previousOrderID = last_id.sale_last_invoice;

OBJ_Action.myfunc = function (data) {

if (Ext.getCmp("so_hidden_id").getValue() == 0) {
    last_id.sale_last_invoice = data.obj_id;
}
Ext.getCmp("so_hidden_id").setValue(data.obj_id);
Ext.getCmp("so_already_shipped").setValue(data.already_shipped);
// Ext.getCmp("_cust_group_name_").setValue(5);
OBJ_Action.nextOrderID = data.next_order_id;
OBJ_Action.previousOrderID = data.pre_order_id;
Ext.getCmp("next_sale_order_btn").setDisabled((data.next_order_id == 0) ? true : false);
Ext.getCmp("pre_sale_order_btn").setDisabled((data.pre_order_id == 0) ? true : false);
Ext.getCmp("delete_so_invoice").setDisabled(false);
if(sale_invoice_mode==2){                    
    Ext.getCmp("so_id").setValue("EST-" + data.inv_no);                         
    Ext.getCmp("so_create_invoice").setDisabled(false);                           
}
else{
    Ext.getCmp("so_id").setValue(inv_prefix + data.inv_no);
}
Ext.getCmp("so_estimate_id").setValue('0');
OBJ_Action.onComplete();
}

OBJ_Action.getDateMysqlFormatWithTime = function (objDate) {
var currentdate = objDate;
var cdate = "";
if (objDate) {
    var cdate = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + "-" + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
}
return cdate;
}

OBJ_Action.updateOnlineStatus = function (event) {
if(event.type=='online'){
    alert('Your are Online');
}

if(event.type=='offline'){
    alert('Your are Offline');
}

}  
OBJ_Action.saveme = function (extra, byPassCreditLimit) {

editModelSO.cancelEdit();
editModelPick.cancelEdit();

var _data = Ext.getCmp('sale_invoice_grid').store.data;
if (_data.items.length == 0) {
    return false;
}

var jsonInvoiceData = Ext.pluck(_data.items, 'data');
var isvalid = true;
for (var i = 0; i < jsonInvoiceData.length; i++) {
    if (!jsonInvoiceData[i].item_name || !jsonInvoiceData[i].item_id) {
        isvalid = false;
        break;
    }
}
if (isvalid == false) {
    Ext.Msg.show({
        title: 'Error Occured',
        msg: 'One of the item row is empty, please delete or fill item to continue.',
        buttons: Ext.Msg.OK,
        icon: Ext.Msg.ERROR
    });
    return false;
}

jsonInvoiceData = Ext.encode(jsonInvoiceData);
var jsonPickData = Ext.encode(Ext.pluck(Ext.getCmp('pick_invoice_grid').store.data.items, 'data'));

var status_val = 0;
// workaround for now
Ext.getCmp("so_total_pick").setValue(Ext.getCmp("so_total_ordered").getValue());

var _total_pick = parseFloat(Ext.getCmp("so_total_pick").getValue());
var _total_order = parseFloat(Ext.getCmp("so_total_ordered").getValue());
var _sub_total = parseFloat(Ext.getCmp("sub_total_total_so").getValue());

var _total_amount = parseFloat(Ext.getCmp("so_total").getValue());
var _total_paid = parseFloat(Ext.getCmp("so_paid").getValue());
var _discount = parseFloat(Ext.getCmp("so_discount_invoice").getValue())
var _credit_limit = parseFloat(customer_store_active.getById(Ext.getCmp("customers_combo").getValue()).get("cust_credit_limit"));
var _grand_total = parseFloat(Ext.getCmp("grand_total_balance").getValue());
var _net_paid = parseFloat(Ext.getCmp("paid_total").getValue());
var _net=Number(_net_paid)+Number(_discount);
if (!byPassCreditLimit && Ext.getCmp("so_hidden_id").getValue() == "0" && _credit_limit && _grand_total > _credit_limit) {
    Ext.Msg.show({
        title: 'Credit Limit',
        msg: 'Customer credit Limit exceeds provided limit <b>"' + Ext.util.Format.number(_credit_limit, "0.00") + ' Rs.</b>"',
        buttons: Ext.Msg.YESNO,
        icon: Ext.Msg.WARNING,
        fn: function (btn, text) {
            if (btn == 'yes') {
                OBJ_Action.saveme(false, true)
            }
        }
    });
    return false;
}
var c_total_amount = _total_amount;
if (sale_invoice_mode == 1) {
    c_total_amount = -1 * _total_amount;
    _total_paid = -1* _total_paid;
    _discount = -1* _discount;
}
if (sale_invoice_mode !== 2) {
    if (Ext.getCmp("customers_combo").getValue() === "0" && _total_paid + _discount < c_total_amount) {
        Ext.Msg.show({
            title: 'Payment',
            msg: 'Walk in customer need to pay complete amount.',
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR
        });
        return false;
    }

    if (_total_paid + _discount > c_total_amount) {
        Ext.Msg.show({
            title: 'Payment',
            msg: 'Please pay the exact amount.',
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR
        });
        return false;
    }
}


if (_total_paid == 0) {
    status_val = 2;
}
else if (_total_paid+_discount<_sub_total) {
    status_val = 4;
} 
 else if (_total_amount == _total_paid+_discount) {
    status_val = 3;
}
if (sale_invoice_mode == 1) {
    status_val = 3;
} else if (sale_invoice_mode == 2){
    status_val = 1;
}
var save_new=2;
Ext.getCmp("so_order_status").setValue(status_val);
Ext.getCmp("so_status").setValue(OBJ_Action.SaleinvoiceStatus['_' + status_val]);
Ext.get("img_stamp").dom.className = "stamps " + OBJ_Action.SaleinvoiceStatusImage['_' + status_val];
var extraParms = {
    trans: jsonInvoiceData,
    pick: jsonPickData,
    so_status_val: status_val,
    save_new:save_new,
}
if (extra && extra.print) {
    extraParms["print"] = extra.print;
}
else if (extra && extra.makenew) {
    extraParms["makenew"] = extra.makenew;
}
extraParms["so_date_time"] = Ext.Date.format(Ext.getCmp("so_date").getValue(), 'Y-m-d') + ' ' + Ext.Date.format(new Date(), 'H:i:s');
Ext.getCmp("so_datetime_hidden").setValue(Ext.Date.format(Ext.getCmp("so_date").getValue(), 'Y-m-d') + ' ' + Ext.Date.format(new Date(), 'H:i:s'));


OBJ_Action.save(extraParms);


}

OBJ_Action.printme = function () { 
if (parseInt(Ext.getCmp('so_hidden_id').getValue()) !== 0) {
    var print_iframe = Ext.get("print_iframe").dom.contentWindow;
     var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety']; 
//    function inWords (num) {
//     if ((num = num.toString()).length > 9) return 'overflow';
//     var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
//     if (!n) return; var str = '';
//     str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
//     str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
//     str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
//     str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
//     str += (n[5] != 0) ? ((str != '') ? 'And ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Only ' : '';
//     return str;
// }
    print_iframe.$(".invoice-date").html(Ext.Date.format(Ext.getCmp("so_date").getValue(), 'd/m/Y h:i A'));
    // print_iframe.$(".invoice-date").html(Ext.getCmp("so_datetime_hidden").getValue());
    print_iframe.$(".print-invoice-date").html(Ext.Date.format(new Date(), 'd/m/Y h:i A'));
    print_iframe.$(".invoice-no").html(Ext.getCmp("so_id").getValue());                    
    print_iframe.$(".region_customer").html(Ext.getCmp("so_cust_group").getValue());
    //print_iframe.$(".warehouse_customer").html(Ext.getCmp("warehouse_so").getRawValue());
    print_iframe.$(".salsrep_name").html(Ext.getCmp("so_sale_rep_assign").getRawValue());
    if(sale_invoice_mode!=2){
        print_iframe.$(".bill_to_text").html(labels_json.saleinvoicepanel.text_bill_to);
        print_iframe.$(".customers_address").html(Ext.getCmp("so_cust_address").getValue());
        print_iframe.$(".cust_mobile_text").html(labels_json.saleinvoicepanel.text_cust_mobile);
        print_iframe.$(".invoice_no").html(labels_json.saleinvoicepanel.text_invoice_no);
        print_iframe.$(".inv-head").html(labels_json.saleinvoicepanel.text_invoice);
        print_iframe.$(".so_hide").show();
        print_iframe.$(".invoice_no1").hide();

        print_iframe.$(".bill_to_pur").html(Ext.getCmp("customers_combo").getRawValue());
        print_iframe.$(".bill_to").html(Ext.getCmp("customers_combo").getRawValue());
        print_iframe.$(".customers_mobile").html(Ext.getCmp("customer_mobile").getValue());
        print_iframe.$(".so_invoice_detail").show(); 
        if(settings.sale && settings.sale["config_saleterms"]){
            print_iframe.$(".terms_conditions").show();
            print_iframe.$(".terms_condtion_text").html(settings.sale["config_saleterms"]);
        }
        else
        {
            print_iframe.$(".terms_conditions").hide();
        }
    }
    else{ 
        print_iframe.$(".bill_to_text").html("Name");
        print_iframe.$(".invoice_no").html("Estimate#");
        print_iframe.$(".inv-head").html("ESTIMATE");
        print_iframe.$(".so_hide").hide();
        print_iframe.$(".so_invoice_detail").show();
       print_iframe.$(".bill_to_pur").html(Ext.getCmp("customers_combo").getRawValue());
        print_iframe.$(".bill_to").html(Ext.getCmp("customers_combo").getRawValue());
         print_iframe.$(".customers_mobile").html(Ext.getCmp("customer_mobile").getValue());
        print_iframe.$(".terms_conditions").hide();
       
    }
    if(Ext.getCmp("so_gate_pass").getValue()==1){
        print_iframe.$(".td-rate").hide();
        print_iframe.$(".td-discount").hide();
        print_iframe.$(".net_price").hide();
        print_iframe.$(".td-amount").hide();
        print_iframe.$(".total_amount").hide();
        print_iframe.$(".tfoot_").hide();
        print_iframe.$(".invoice_no").html("Gate Pass #");
        print_iframe.$(".inv-head").html("GATE PASS");
        print_iframe.$(".total_table").hide();
    } else {
        print_iframe.$(".td-rate").show();
        print_iframe.$(".td-discount").show();
        print_iframe.$(".net_price").show();
        print_iframe.$(".td-amount").show();
        print_iframe.$(".total_amount").show();
        print_iframe.$(".total_table").show();
        print_iframe.$(".tfoot_").show();
    }
    var sale_grid = Ext.pluck(Ext.getCmp('sale_invoice_grid').store.data.items, 'data');
    var tbody_html = "";
    var _total = 0, _quantity = 0, _discount = 0, _disInv=0; _sub_total = 0, _dPrice = 0;                    
    for (var i = 0; i < sale_grid.length; i++) {
        if(Ext.getCmp("so_gate_pass").getValue()==1){
        tbody_html += "<tr><td  align='left' width='10%'>" + (i + 1) + "</td>";
        tbody_html += "<td align='left' width='60%'>" + sale_grid[i].item_name + "</td>";
        tbody_html += "<td align='left' width='15%'>" + sale_grid[i].item_quantity + "</td>";
        tbody_html += "<td align='left' width='15%'>" + sale_grid[i].unit_name + "</td>";
        } else {
        tbody_html += "<tr><td  align='left'><div class='cell-text'>" + (i + 1) + "</div></td>";
        tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].item_name + "</div></td>";
        tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].item_quantity + "</div></td>";
        if(enableUom==1)
        {
            tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].unit_name + "</div></td>";
        }
        else{
            tbody_html += "<td align='left'><div class='cell-text'></div></td>";
        }
        
        tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].unit_price + "</div></td>";
        tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].discount + "</div></td>";
        tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].net_price + "</div></td>";
        tbody_html += "<td align='left'><div class='cell-text'>" + sale_grid[i].sub_total + "</div></td></tr>";
        }
        _sub_total = _sub_total + parseFloat(sale_grid[i].sub_total);
        _dPrice = parseFloat(sale_grid[i].unit_price) - (parseFloat(sale_grid[i].unit_price) * parseFloat(sale_grid[i].discount) / 100);
        _total = _total + parseFloat(sale_grid[i].sub_total);
        _quantity = _quantity + parseFloat(sale_grid[i].item_quantity);

    }
    
    _discount = parseFloat(Ext.getCmp("so_discount").getValue());
    _disInv = parseFloat(Ext.getCmp("so_discount_invoice").getValue());
    var _paid = Ext.getCmp("so_paid").getValue();
    var _balance = Ext.getCmp("so_total_balance").getValue();
    var _weight = Ext.getCmp("_so_weight").getValue();
     var register_print=Ext.getCmp("show_register_print").getValue();
     var register_record=Ext.getCmp('customer_transections');

     if(register_print=="1")
     {
        print_iframe.$(".register_table").show();
        print_iframe.$(".registerbody").html(register_record.body.dom.lastChild.lastChild.innerHTML);
     }
     else{
        print_iframe.$(".register_table").hide();
     }
    print_iframe.$(".receipt-large-body").html(tbody_html);
    print_iframe.$(".sub_total_qty,.total_qty").html(_quantity);
    print_iframe.$(".sub_total").html(Ext.util.Format.number(_sub_total, "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    print_iframe.$(".total_amount").html(Ext.util.Format.number(_total, "0.00"));
    print_iframe.$(".discount").html(Ext.util.Format.number(_discount+_disInv, "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    if (parseFloat(_weight) > 0) {
        print_iframe.$(".wieght_row").show();
    }
    else {
        print_iframe.$(".wieght_row").hide();
    }
    // var Inwords=inWords(Number(_balance));
    // console.log();
    print_iframe.$(".weight").html(Ext.util.Format.number(_weight, "0.00") + " Kg");
    print_iframe.$(".paid").html(Ext.util.Format.number(_paid, "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    print_iframe.$(".balance").html(Ext.util.Format.number(_balance, "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    print_iframe.$(".pre_balance").html(Ext.util.Format.number(Ext.getCmp("prev_total_balance").getValue(), "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    print_iframe.$(".grand_total").html(Ext.util.Format.number(Ext.getCmp("grand_total_balance").getValue(), "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    // print_iframe.$(".inWordsnum").html(Inwords);
    //print_iframe.$(".status").html(Ext.get("img_stamp").dom.className = "stamps " + OBJ_Action.SaleinvoiceStatusImage['_' + Ext.get("so_status").getValue()]);
    
    print_iframe.$(".total_recpt_large").html(Ext.util.Format.number(_total, "0.00") + " "+labels_json.saleinvoicepanel.text_rs);
    if(Ext.getCmp("customers_combo").getValue()=="0"){
        print_iframe.$(".balanced").hide();
        print_iframe.$(".pre_balanced").hide();
        print_iframe.$(".grand_totaled").hide();
        print_iframe.$(".warehoused").hide();
    } else {
        print_iframe.$(".balanced").show();
        print_iframe.$(".pre_balanced").show();
        print_iframe.$(".grand_totaled").show();
        print_iframe.$(".warehoused").show();
    }
    if (Ext.getCmp("so_remarks").getValue()) {
        print_iframe.$(".custom").show();
        print_iframe.$(".custom").html(Ext.getCmp("so_remarks").getValue());
    } else {
        print_iframe.$(".custom").hide();
        print_iframe.$(".custom").html('');
    }
// console.log(Ext.getCmp("customers_combo").getValue());
    if (Ext.getCmp("so_allow_prevbalance").getValue()==true && Ext.getCmp("customers_combo").getValue()!="0") {
        print_iframe.$(".previous_balance-area").hide();
         print_iframe.$(".pre_balanced").removeClass( "prevoiusHide" );
        print_iframe.$(".previous_balance").html(Ext.getCmp("prev_total_balance").getValue());
    }
    else {
        // console.log('Hide True');
        print_iframe.$(".previous_balance").hide();
        print_iframe.$(".pre_balanced").addClass( "prevoiusHide" );

        print_iframe.$(".previous_balance-area").hide();
    }
    
    
                                        

    print_iframe.print();

}
else {
    Ext.Msg.show({
        title: 'Error Occured',
        msg: 'You cann\'t perform this action without saving.',
        buttons: Ext.Msg.OK,
        icon: Ext.Msg.ERROR
    });
}
}

OBJ_Action.editRecordRow = function(e,obj){

if (parseInt(Ext.getCmp("so_order_status").getValue()) === 4) {
    editModelSO.cancelEdit();
    return false;
}
else {
    item_store.pageSize=50;
    if(user_right!=="3")  {
    Ext.defer(function(){
        Ext.create('Ext.tip.ToolTip', {        
        title: '<h3 class="popover-title">'+labels_json.saleinvoicepanel.item_info+'</h3>',                        
        target: Ext.select(".x-grid-row-editor .y-action-col-icon").elements[0],                                                                        
        anchor: 'left',
        cls:'callout',
        trackMouse: true,
        html: null,
        width: 250,
        autoHide: true,
        closable: true,                                                                            
        listeners: {
            'render': function(){},
            beforeshow: function updateTipBody(tip) {
                OBJ_Action.populateTooltip(tip)
            }
        }
    });
   },200);
    }
    if (!OBJ_Action.addMewInvoiceRow) {      
    item_store.pageSize=1000;                                                                                                                                          
        Ext.getCmp("item_quantity_so").setDisabled(false);
        // Ext.getCmp("bonus_quantity_so").setDisabled(false);
        Ext.getCmp("item_price_so").setDisabled(false);
        Ext.getCmp("item_discount_so").setDisabled(false);
        Ext.getCmp("item_net_so").setDisabled(false);
        Ext.getCmp("item_subtotal_so").setDisabled(false);
        Ext.getCmp("item_name_so").setEditable(false); 
       
        if(enableUom==1)
        {
              Ext.getCmp("sale_item_uom").setDisabled(false);
        }
          if(enableWarehouse==1)
        {
             Ext.getCmp("warehouse_so").setDisabled(false);
        }
         if(bonusQuantity==1)
        {
             Ext.getCmp("bonus_quantity_so").setDisabled(false);
        }
       
                                                        
        //set uom on edit.
        var grid = e.grid;
        var rec = grid.getStore().getAt(obj.rowIdx);                                                                                                                                      
        var data = rec.raw.item_units;
        if(data){
            uom_store_temp.removeAll();
            for(var i=0;i<data.length;i++){
                uom_store_temp.add(data[i]);                                                                                                                                                                
            }                                                                    
        }
    }
    else {
        // item_store.pageSize=50;
        OBJ_Action.addMewInvoiceRow = false;
    }                                                                    
}
}
OBJ_Action.clearOtherChanges = function () {
Ext.defer(function () {
    Ext.getCmp("customers_combo").focus();
    Ext.getCmp("customers_combo").setValue('');

}, 50)
Ext.getCmp("sale_invoice_grid").store.removeAll();
Ext.getCmp("pick_invoice_grid").store.removeAll();
OBJ_Action.previousOrderID = last_id.sale_last_invoice;
OBJ_Action.nextOrderID = 0;
Ext.getCmp("pre_sale_order_btn").setDisabled(false);
Ext.getCmp("next_sale_order_btn").setDisabled(true);
Ext.getCmp("delete_so_invoice").setDisabled(true);
if(sale_invoice_mode==2){
    Ext.getCmp("so_create_invoice").setDisabled(true);
}
OBJ_Action.setDisableControls(true);
//Ext.getCmp("so_tab_panel").child('#so_pick_panel').tab.show();
//Ext.getCmp("so_tab_panel").child('#so_payment_panel').tab.show();
//Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText('Sale Return');
Ext.get("img_stamp").dom.className = "stamps open";
Ext.getCmp("tb_btn_save").show();
if(user_right==="3"){
     setTimeout(function(){
         Ext.getCmp("customers_combo").setValue(customer_id)
     },100);
}
}
OBJ_Action.onComplete = function () {
OBJ_Action.setDisableControls();
};

OBJ_Action.invoiceTP=function() {

  Ext.defer(function(){
        Ext.create('Ext.tip.ToolTip', {        
        title: '<h3 class="popover-title">'+labels_json.saleinvoicepanel.invoice_info+'</h3>',                        
        target : toolTipId,                                                                      
        anchor: 'left',
        cls:'callout',
        trackMouse: true,
        html: null,
        width: 250,
        autoHide: true,
        closable: true,                                                                            
        listeners: {
            'render': function(){},
            beforeshow: function updateTipBody(invtip ) {
                OBJ_Action.populateInvTooltip(invtip)
            }
        }
    });
   },200);
}
OBJ_Action.changeItemName = function (record) {
Ext.getCmp("item_quantity_so").setDisabled(false);                                                                        
Ext.getCmp("bonus_quantity_so").setDisabled(false);                                                                        
Ext.getCmp("item_price_so").setDisabled(false);
Ext.getCmp("item_discount_so").setDisabled(false);
Ext.getCmp("item_net_so").setDisabled(false);
Ext.getCmp("item_subtotal_so").setDisabled(false);
Ext.getCmp("item_name_so").setEditable(false);
Ext.getCmp("warehouse_so").setDisabled(false);
Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));                                                                                                                                                        
var adj = OBJ_Action.getAdjustedPrice(record);
Ext.getCmp("item_discount_so").setValue(adj.discount + "%");
var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
sel.set("item_id", record.get("id"));
sel.set("item_weight", parseFloat(record.get("weight")));
sel.set("discount", parseFloat(adj.discount));
OBJ_Action.recordChange();
OBJ_Action.calc.calRowSubTotal();                                                                            
Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);
}
OBJ_Action.setDisableControls = function (isNew) {
/*if(parseInt(Ext.getCmp("so_order_status").getValue())==4){
 Ext.getCmp("customers_combo").disable();
 Ext.getCmp("customer_mobile").disable();
 Ext.getCmp("customer_contact").disable();
 Ext.getCmp("so_date").disable();                                        
 Ext.getCmp("so_remarks").disable();                                        
 Ext.getCmp("so_payment_paid").disable();
 Ext.getCmp("so_new_item").disable();
 Ext.getCmp("so_del_item").disable();
 Ext.getCmp("tb_btn_copy").disable();
 Ext.getCmp("tb_btn_save").disable();
 Ext.getCmp("tb_btn_save_new").disable();
 Ext.getCmp("tb_btn_reopen").enable();
 Ext.getCmp("so_autofill_rec_btn").disable();
 Ext.getCmp("so_complete_rec_btn").disable();
 }
 else{
 Ext.getCmp("customers_combo").enable();
 Ext.getCmp("customer_mobile").enable();
 Ext.getCmp("customer_contact").enable();
 Ext.getCmp("so_date").enable();                                        
 Ext.getCmp("so_remarks").enable();                                        
 Ext.getCmp("so_payment_paid").enable();
 Ext.getCmp("so_new_item").enable();
 Ext.getCmp("so_del_item").enable();
 Ext.getCmp("tb_btn_copy").enable();
 Ext.getCmp("tb_btn_save").enable();
 Ext.getCmp("tb_btn_save_new").enable();
 Ext.getCmp("tb_btn_reopen").disable();
 if(Ext.getCmp("so_hidden_id").getValue()!==""){
 Ext.getCmp("so_tab_panel").down('#so_pick_panel').setDisabled(false);
 Ext.getCmp("so_tab_panel").down('#so_payment_panel').setDisabled(false);
 }
 if(isNew){
 Ext.getCmp("so_tab_panel").down('#so_pick_panel').setDisabled(true);
 Ext.getCmp("so_tab_panel").down('#so_payment_panel').setDisabled(true);
 Ext.getCmp("so_tab_panel").setActiveTab(0);
 }
 }*/

}
OBJ_Action.calc = {
calRowSubTotal: function () {
    var discount = 0;
    var p = parseFloat(Ext.getCmp("item_price_so").getValue());
    var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
    var rec = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0].get("discount_complete");
    rec = rec ? parseFloat(rec):0;
    var d = rec ? rec : parseFloat(Ext.getCmp("item_discount_so").getValue());
       // console.log(p);console.log(d);                 
    var dPrice = p - (p * d / 100);
    discount = discount + (p * d / 100);
    var total = q * dPrice;
    if (isNaN(total) == false) {                        
        Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(dPrice, "0.00"))                             
        Ext.getCmp("item_subtotal_so").setValue(Ext.util.Format.number(total, "0.00"));
    }
    else{
    }
    OBJ_Action.calc.calTotalSubTotal();
},
calRowDiscount: function () {
    var p = parseFloat(Ext.getCmp("item_price_so").getValue());
    var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
    var d_value = parseFloat(Ext.getCmp("item_net_so").getValue());
    var d;   
    if(d_value<p){
        d = ((p - d_value) / p) * 100;
    } else {
        d = 0;
    }
    if (isNaN(d) == false) {
        Ext.getCmp("item_discount_so").setValue(Ext.util.Format.number(d, "0.00") + "%");
        Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0].set("discount_complete",d);
        var total = q * d_value;                           
        Ext.getCmp("item_subtotal_so").setValue(Ext.util.Format.number(total, "0.00"));
    }
},
calcRowFromSubtotal: function (){                     
    var subtotal = parseFloat(Ext.getCmp("item_subtotal_so").getValue());
    if(subtotal) {
        var p = parseFloat(Ext.getCmp("item_price_so").getValue());
        var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
        var d_value = parseFloat(Ext.getCmp("item_net_so").getValue());
        //var p = parseFloat(Ext.getCmp("item_price_so").getValue());
        //if(Ext.getCmp("item_quantity_so").getValue() < 0 ){
          //  var q = parseFloat(Ext.getCmp("item_quantity_so").getValue() * (-1));
        //} else {
          //  var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
        //}
        var d = ((p - d_value) / p) * 100;
        if(subtotal / q < p && subtotal / q != 0 ) {
            var ePrice = subtotal / q;
            var d = ((p - ePrice) / p) * 100;
            
            Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(ePrice, "0.00"));
            if (isNaN(d) == false) {
                Ext.getCmp("item_discount_so").setValue(Ext.util.Format.number(d, "0.00") + "%");
                var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];                                                                        
                sel.set("discount_complete", d);
            }
        } 
        else if (subtotal / q > p) {
            var ePrice = subtotal / q;
            Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(ePrice, "0.00"));
            Ext.getCmp("item_discount_so").setValue(Ext.util.Format.number(0, "0.00") + "%");                            
        }
        else {
            Ext.getCmp("item_discount_so").setValue(Ext.util.Format.number(0, "0.00") + "%");
        }
    } else if (isNaN(subtotal) == false || subtotal == 0) {
        Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(0, "0.00"));
                Ext.getCmp("item_discount_so").setValue(Ext.util.Format.number(100, "0.00") + "%");
                var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];                                                                        
                sel.set("discount_complete", 100);
    }
},
calGrid: function () {
    var grid_items = Ext.getCmp('sale_invoice_grid').store.data.items;
    var discount = 0;
    var _weight = 0;
    for (var i = 0; i < grid_items.length; i++) {
        var p = parseFloat(grid_items[i].get("unit_price"));
        var q = parseFloat(grid_items[i].get("item_quantity"));
        var d = parseFloat(grid_items[i].get("discount"));
        var c_d = parseFloat(grid_items[i].get("discount_complete"));
        var sub_total = parseFloat(grid_items[i].get("sub_total"));
        var dPrice = p - (p * c_d / 100);
        var total = q * dPrice;
        discount = discount + (p * d / 100);
        grid_items[i].set("net_price", Ext.util.Format.number(dPrice, "0.00"));
        grid_items[i].set("sub_total", Ext.util.Format.number(sub_total, "0.00"));

        try {
            if (grid_items[0].get("weight")) {
                _weight = _weight + parseFloat(grid_items[i].get("weight")) * q;
            }
            else {
                _weight = _weight + parseFloat(item_store.getById(grid_items[i].get("item_id")).get("weight") * q)
            }
        }
        catch (e) {

        }
    }
    Ext.getCmp("so_discount_items").setValue(Ext.util.Format.number(discount, "0.00"));
    Ext.getCmp('_so_weight').setValue(Ext.util.Format.number(_weight, "0.00"));
    if (_weight > 0) {
        //Ext.getCmp('sale_invoice_grid').columns[3].setVisible(true);                       
        Ext.Function.defer(OBJ_Action.calc.showHideWeight, 400, this, [true]);
    }


},
showHideWeight: function (flag) {
    if (flag) {
        Ext.getCmp('_so_weight').setVisible(true);
        Ext.getCmp('weightEl').setVisible(true);
        Ext.getCmp('bottom_frame').setHeight(125);
    }
    else {
        Ext.getCmp('_so_weight').setVisible(false);
        Ext.getCmp('weightEl').setVisible(false);
        Ext.getCmp('bottom_frame').setHeight(125);
    }
},
calTotalSubTotal: function () {                    
    var _total = 0; _total_2 = 0; _discount_before_total = 0; _total_unit_price_so = 0;_conv_from =0;_discount_on_items=0;
    var _total_quantity = 0, _weight = 0, _total_weight = 0;
    var _data = Ext.getCmp('sale_invoice_grid').store.data;
    _data = Ext.pluck(_data.items, 'data');

    for (var i = 0; i < _data.length; i++) {
        _total = _total + parseFloat(_data[i].sub_total);
        _total_quantity = _total_quantity + parseFloat(_data[i].item_quantity);
        _total_unit_price_so = _total_unit_price_so + parseFloat(_data[i].unit_price*_data[i].item_quantity);
        if(parseFloat(_data[i].net_price)<parseFloat(_data[i].unit_price)){
            _discount_before_total += parseFloat(_data[i].item_quantity) * parseFloat(_data[i].unit_price);
            _total_2 = _total_2 + parseFloat(_data[i].sub_total);
        }
        
        if (_data[i].item_weight) {
            _weight = _data[i].item_weight * parseFloat(_data[i].item_quantity);
            _total_weight = _total_weight + _weight;
        }
    }
    if(_data.length!=0){
       Ext.getCmp("sub_item_so").setValue(Ext.util.Format.number(_data.length), "0.00"); 
    } else {
       Ext.getCmp("sub_item_so").setValue('0.00'); 
    }
    var invoice_discount = parseFloat(Ext.getCmp("so_discount_invoice").getValue());
    _total = Ext.util.Format.number(parseFloat(_total), "0.00");
    Ext.getCmp("sub_total_total_so").setValue(_total);
    
    _total_quantity = Ext.util.Format.number(parseFloat(_total_quantity), "0");
    _conv_from = Ext.util.Format.number(parseFloat(_conv_from), "0");
    if(_total_quantity!=0){
        Ext.getCmp("sub_qty_so").setValue(Ext.util.Format.number(_total_quantity), "0.00");
    } else {
        Ext.getCmp("sub_qty_so").setValue('0.00');
    }
    
    
    _total_unit_price_so = Ext.util.Format.number(parseFloat(_total_unit_price_so), "0.00");
    
    if(_total_unit_price_so!=0){
       Ext.getCmp("unit_price_so").setValue(Ext.util.Format.number(_total_unit_price_so), "0.00"); 
    } else {
       Ext.getCmp("unit_price_so").setValue('0.00'); 
    }
    
    
    
    
    
    
    Ext.getCmp("so_total").setValue(_total);                    
    if (parseFloat(Ext.getCmp("so_hidden_id").getValue()) === 0) {
        //Ext.getCmp("so_paid").setValue(_total);
    }
    if (_total_weight > 0) {
        //Ext.getCmp('sale_invoice_grid').columns[3].setVisible(true);
        Ext.getCmp('_so_weight').setVisible(true);
        Ext.getCmp('weightEl').setVisible(true);
        Ext.getCmp('bottom_frame').setHeight(180);
        Ext.getCmp('_so_weight').setValue(_total_weight);
    }
    else {
        //Ext.getCmp('sale_invoice_grid').columns[3].setVisible(false);
        Ext.getCmp('_so_weight').setVisible(false);
        Ext.getCmp('weightEl').setVisible(false);
        Ext.getCmp('bottom_frame').setHeight(125);
    }
    Ext.getCmp("est_subtotal").setValue(Ext.util.Format.number(_discount_before_total, "0.00"));
    Ext.getCmp("est_total").setValue(_total);
    Ext.getCmp("so_discount").setValue(Ext.util.Format.number(_discount_before_total - _total_2, "0.00"));
    if (sale_invoice_mode == "1") {
    Ext.getCmp("so_total_balance").setValue(Ext.util.Format.number(-1*(_total - invoice_discount), "0.00"));
} else {
    Ext.getCmp("so_total_balance").setValue(Ext.util.Format.number(_total - invoice_discount, "0.00"));
}
    Ext.getCmp("so_total_ordered").setValue(_total_quantity);
    OBJ_Action.calc.calcBalance();

},
calcBalance: function () {
    var _total = Ext.getCmp("so_total").getValue();
    _total = parseFloat(_total);
    
    var _paid = parseFloat(Ext.getCmp("so_paid").getValue());
    
    var _dis = parseFloat(Ext.getCmp("so_discount_invoice").getValue());
    
    var _balance = _total - _paid - _dis;
    _balance = Ext.util.Format.number(parseFloat(_balance), "0.00");
    Ext.getCmp("so_total_balance").setValue(_balance);
    var prev=Ext.getCmp("prev_total_balance").getValue();
    var grand_total = parseFloat(_balance) + parseFloat(Ext.getCmp("prev_total_balance").getValue())
    //console.log(prev)
    Ext.getCmp("grand_total_balance").setValue(Ext.util.Format.number(grand_total, "0.00"))
    

    OBJ_Action.recordChange();
},
removeRecord: function (grid_id) {
    Ext.getCmp(grid_id).store.remove(Ext.getCmp(grid_id).getSelectionModel().getSelection()[0]);
    OBJ_Action.calc.calTotalSubTotal();
    OBJ_Action.recordChange();
}
}
OBJ_Action.editme = function () {
if (editItem.id > 0) {
    LoadingMask.showMessage(labels_json.saleinvoicepanel.msg_loading);
    Ext.Ajax.request({
        url: action_urls.get_so_record,
        params: {
            so_id: editItem.id
        },
        method: 'GET',
        success: function (response) {

            editItem.loadMode = 1;
            var jObj = Ext.decode(response.responseText);
            Ext.getCmp("so_hidden_id").setValue(jObj.so_id);
            Ext.getCmp("customers_combo").setValue(jObj.cust_id);
            // Ext.getCmp("_cust_group_name_").setValue();
            if(enable_InvRegister==1)
            {
                  if(jObj.cust_id !=0)
            {
             OBJ_Action.getCustomeRegister(jObj.cust_id,jObj.reg_date,edit=1);   
            } 
            }
            else{
                 Ext.getCmp("prev_total_balance").setValue(Ext.util.Format.number(jObj.so_previous_invoice, "0.00"));
            }
         
            
                 // var r = Ext.ComponentQuery.query('#_cust_group_name_');
              // r[0].suspendEvents();
            Ext.getCmp("_cust_group_name_").suspendEvent('change');
              Ext.getCmp("_cust_group_name_").setValue(jObj.region);
            Ext.getCmp("_cust_group_name_").resumeEvent('change');
            
            Ext.getCmp("customer_contact").setValue(jObj.so_cust_name);
            Ext.getCmp("customer_mobile").setValue(jObj.so_cust_mobile);
            Ext.getCmp("so_cust_address").setValue(jObj.so_cust_address);
            if(sale_invoice_mode==2){
                Ext.getCmp("so_id").setValue("EST-" + jObj.inv_no);
            }
            else{
                Ext.getCmp("so_id").setValue(inv_prefix + jObj.inv_no);
            }
            Ext.getCmp("so_status").setValue(OBJ_Action.SaleinvoiceStatus['_' + jObj.so_status_id]);
            Ext.get("img_stamp").dom.className = "stamps " + OBJ_Action.SaleinvoiceStatusImage['_' + jObj.so_status_id]
            Ext.getCmp("so_date").setValue(jObj.so_date);
            Ext.getCmp("so_datetime_hidden").setValue(jObj.so_date_time);
            // console.log(jObj.reg_date)
            Ext.getCmp("sub_total_total_so").setValue(jObj.so_total);
            Ext.getCmp("so_total").setValue(jObj.so_total);
            Ext.getCmp("so_payment_paid").setValue(jObj.so_paid);
            Ext.getCmp("so_payment_total_balance").setValue(jObj.so_balance);
            Ext.getCmp("so_due_date").setValue(jObj.so_paid_date);
            Ext.getCmp("so_remarks").setValue(jObj.so_custom);
          
            Ext.getCmp("so_discount_invoice").setValue(jObj.so_discount_invoice);

            // Ext.getCmp("so_discount_new").setValue('100');
            Ext.getCmp("so_sales_rep").setValue(jObj.so_salesrep);
            //
            if(salesrep_store.getById(jObj.so_salesrep)){
                Ext.getCmp("so_sale_rep_assign").setRawValue(salesrep_store.getById(jObj.so_salesrep).get("salesrep_name"));
            }
            //Ext.getCmp("warehouse_so").setValue(jObj.so_location_id == "0" ? "1" : jObj.so_location_id);
            
            if (jObj.order_details) {
                if (editItem.type !== "") {
                    for (var i = 0; i < jObj.order_details.length; i++) {
                        jObj.order_details[i].item_quantity = -1 * parseFloat(jObj.order_details[i].item_quantity);
                    }
                }
                Ext.getCmp("sale_invoice_grid").store.loadData(jObj.order_details);
            }
            else {
                Ext.getCmp("sale_invoice_grid").store.loadData([]);
            }
            // Ext.getCmp("so_allow_print").setValue(jObj.so_is_print);
            Ext.getCmp("so_allow_email").setValue(jObj.so_is_email);
            if (jObj.pick_details) {
                Ext.getCmp("pick_invoice_grid").store.loadData(jObj.pick_details);
            }
            else {
                Ext.getCmp("pick_invoice_grid").store.loadData([]);
            }
            Ext.getCmp("so_already_shipped").setValue(jObj.so_shipped);
            Ext.getCmp("so_order_status").setValue(jObj.so_status_id);
            OBJ_Action.nextOrderID = jObj.next_order_id;
            OBJ_Action.previousOrderID = jObj.pre_order_id;
            Ext.getCmp("next_sale_order_btn").setDisabled((jObj.next_order_id == 0) ? true : false);
            Ext.getCmp("pre_sale_order_btn").setDisabled((jObj.pre_order_id == 0) ? true : false);
            Ext.getCmp("delete_so_invoice").setDisabled(false);
            Ext.getCmp("so_remove_all_item").setDisabled(true);
            if(sale_invoice_mode==2){
                Ext.getCmp("so_create_invoice").setDisabled(false);
                
            }
            editItem.id = '0';

            OBJ_Action.onComplete();
            OBJ_Action.calc.calGrid();
            OBJ_Action.calc.calTotalSubTotal();
            OBJ_Action.countReceived(true);

            Ext.getCmp("so_paid").setValue(jObj.so_paid);
            Ext.getCmp("so_paid").setReadOnly(true);
            Ext.getCmp("so_tab_panel").down('#so_pick_panel').setDisabled(false);
            Ext.getCmp("so_tab_panel").down('#so_payment_panel').setDisabled(false);
            Ext.getCmp("so_tab_panel").setActiveTab(0);

            editItem.loadMode = 0;

            LoadingMask.hideMessage();
            OBJ_Action.resetChanges();
            if (editItem.type !== "") {
                Ext.getCmp("so_tab_panel").child('#so_pick_panel').tab.hide();
                Ext.getCmp("so_tab_panel").child('#so_payment_panel').tab.hide();
                Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText('Sale Return');
                Ext.getCmp("tb_btn_save").hide();
                Ext.getCmp("so_order_status").setValue(3);
                OBJ_Action.recordChange();
            }
            else {
                //Ext.getCmp("so_tab_panel").child('#so_pick_panel').tab.show();
                //Ext.getCmp("so_tab_panel").child('#so_payment_panel').tab.show();
                //Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText('Sale');
                Ext.getCmp("tb_btn_save").show();
            }
            if(Ext.getCmp("so_estimate_id").getValue()!="0"){
                Ext.getCmp("so_id").setValue('');                                  
                Ext.getCmp("so_hidden_id").setValue(0);
            }
        },
        failure: function () {
            LoadingMask.hideMessage();
        }
    });
}
else {
    Ext.getCmp("so_paid").setReadOnly(false);
}
}
OBJ_Action.editme();

OBJ_Action.autoFillReceive = function () {
var sale_grid = Ext.pluck(Ext.getCmp('sale_invoice_grid').store.data.items, 'data');
var pick_purchase_grid = Ext.pluck(Ext.getCmp('pick_invoice_grid').store.data.items, 'data');
var fill_data = [];
var data = null;

if (pick_purchase_grid.length === 0) {
    for (var i = 0; i < sale_grid.length; i++) {
        data = {};
        data.item_id = sale_grid[i].item_id;
        data.item_name = sale_grid[i].item_name;
        data.item_quantity = sale_grid[i].item_quantity;
        data.conv_from = sale_grid[i].conv_from;
        //data.item_location = Ext.getCmp("warehouse_so").getRawValue();
        data.date_picked = new Date();
        data.item_location_id = '1';
        data.is_picked = '';
        fill_data.push(data);
    }
    Ext.getCmp("pick_invoice_grid").store.loadData(fill_data);
}
else {
    for (var i = 0; i < sale_grid.length; i++) {
        var quantity_exits = 0;

        Ext.each(pick_purchase_grid, function (v, k) {
            if (v.item_id == sale_grid[i].item_id) {
                quantity_exits = quantity_exits + parseFloat(v.item_quantity)
            }
        });

        var quantity_diff = 0;
        if (quantity_exits) {
            quantity_diff = parseFloat(sale_grid[i].item_quantity) - parseFloat(quantity_exits);
        }

        if (!quantity_exits || quantity_diff > 0) {
            data = {};
            data.item_id = sale_grid[i].item_id;
            data.item_name = sale_grid[i].item_name;
            data.item_quantity = (!quantity_exits) ? sale_grid[i].item_quantity : quantity_diff;
            data.conv_from = sale_grid[i].conv_from;
            //data.item_location = Ext.getCmp("warehouse_so").getRawValue();
            data.item_location_id = '1';
            data.date_picked = new Date();
            data.is_picked = '';
            fill_data.push(data);
        }

    }
    if (fill_data.length) {
        Ext.getCmp("pick_invoice_grid").store.loadData(fill_data, true);
    }
}


OBJ_Action.countReceived();
OBJ_Action.recordChange();

}
OBJ_Action.countReceived = function (fill) {
var receive_items = 0;
var pick_invoice_grid = Ext.pluck(Ext.getCmp('pick_invoice_grid').store.data.items, 'data');
for (var i = 0; i < pick_invoice_grid.length; i++) {
    if (pick_invoice_grid[i].is_picked) {
        receive_items = receive_items + parseFloat(pick_invoice_grid[i].item_quantity);
    }
}
Ext.getCmp("so_total_pick").setValue(receive_items);
if (fill && receive_items == parseFloat(Ext.getCmp("so_total_ordered").getValue())) {
    Ext.getCmp("so_autofill_rec_btn").disable();
    Ext.getCmp("so_complete_rec_btn").disable();
}
else {
    Ext.getCmp("so_autofill_rec_btn").enable();
    Ext.getCmp("so_complete_rec_btn").enable();
}
}

OBJ_Action.receiveItem = function () {
var sel = Ext.getCmp('pick_invoice_grid').getSelectionModel().getSelection()[0];
sel.set("is_picked", true);
OBJ_Action.countReceived();

if (Ext.getCmp("so_total_pick").getValue() == Ext.getCmp("so_total_ordered").getValue()) {
    Ext.Msg.show({
        title: 'Mark Fully Picked',
        msg: 'Mark this order as fully picked?',
        buttons: Ext.Msg.YESNO,
        icon: Ext.Msg.QUESTION,
        fn: function (btn, text) {
            if (btn == 'yes') {
                Ext.getCmp("so_autofill_rec_btn").disable();
                Ext.getCmp("so_complete_rec_btn").disable();
            }
        }
    });
}
OBJ_Action.recordChange();
}

OBJ_Action.completeOrder = function () {
var receive_purchase_grid = Ext.getCmp('pick_invoice_grid').store.data.items;
for (var i = 0; i < receive_purchase_grid.length; i++) {
    receive_purchase_grid[i].set("is_picked", true)
}
OBJ_Action.countReceived();
Ext.getCmp("so_autofill_rec_btn").disable();
Ext.getCmp("so_complete_rec_btn").disable();

OBJ_Action.recordChange();
}

OBJ_Action.payment = function () {
if (Ext.getCmp("so_total_pick").getValue() == Ext.getCmp("so_total_ordered").getValue()) {
    var sale_grid = Ext.pluck(Ext.getCmp('sale_invoice_grid').store.data.items, 'data');
    Ext.getCmp('invoice_invoice_grid').store.loadData(sale_grid);
    Ext.getCmp('sub_total_payment_so').setValue(Ext.getCmp("sub_total_total_so").getValue());
    Ext.getCmp('so_payment_total').setValue(Ext.getCmp("so_total").getValue());
}
}

OBJ_Action.addRecord = function () {
    item_store.pageSize=50;
if(Ext.getCmp("customers_combo").getValue()){
var unit="";    
var warehouse_name="";    
var current_tab = Ext.getCmp("so_tab_panel").items.indexOf(Ext.getCmp("so_tab_panel").getActiveTab());
if (current_tab == 0) {
    editModelSO.cancelEdit();       
    Ext.getCmp("item_quantity_so").setDisabled(true);
    // Ext.getCmp("bonus_quantity_so").setDisabled(true);
    Ext.getCmp("item_price_so").setDisabled(true);
    Ext.getCmp("item_discount_so").setDisabled(true);
    Ext.getCmp("item_net_so").setDisabled(true);
    Ext.getCmp("item_subtotal_so").setDisabled(true);
    Ext.getCmp("item_name_so").setEditable(true);
    if(enableWarehouse==1)
    {
         Ext.getCmp("warehouse_so").setDisabled(true);
    }
   if(bonusQuantity==1)
        {
             Ext.getCmp("bonus_quantity_so").setDisabled(true);
        }
    editModelSO.cancelEdit();
    if(enableUom==1) {
        unit="Each";
        // warehouse_name:"Six Location";
    } else{
        unit="ea";
        warehouse_name:"";
    }
     if(RequiredWarehouse==1) {
        warehouse_name:"";
    } else{
        warehouse_name:"Default Location";
    }
    var r = Ext.create('modelSaleInvoice', {
        item_name: '----------------',
        item_quantity: sale_invoice_mode==1 ? '-1' : '1',
        bonus_quantity: '0',
        unit_id:"1",
        unit_name:unit,
        warehouse_name:warehouse_name,
        unit_price: '0.00',
        normal_price: '0.00',
        net_price: '0.00',
        discount: '0%',
        sub_total: '0.00'
    });
    OBJ_Action.addMewInvoiceRow = true;
    var startEditAt = Ext.getCmp("sale_invoice_grid").store.getCount();
    Ext.getCmp("sale_invoice_grid").store.insert(startEditAt, r);
    
    editModelSO.startEdit(startEditAt, 0);
    
    Ext.getCmp("item_name_so").focus(true, 10, function () {
        Ext.getCmp("item_name_so").setValue("");
        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
        sel.set("item_name", '');                        
        Ext.getCmp("item_name_so").allowBlank=false;
        item_store.removeAll();
        item_store.clearFilter();
        item_store.load({query:''});
        OBJ_Action.shiftFocus = false;
        OBJ_Action.searchKeyPress = 0;
        OBJ_Action.searchChange = 0;    
        if(Ext.getBody().select(".x-boundlist").elements.length){    
        Ext.getBody().select(".x-boundlist").elements[0].style.display="none";
      }
    });
    
   
   
}
else if (current_tab == 1) {

    editModelPick.cancelEdit();
    var r = Ext.create('modelPickedInvoice', {
        item_name: '',
        item_quantity: sale_invoice_mode==1 ? '-1' : '1',
        item_location_id: '1',
        //item_location: Ext.getCmp("warehouse_so").getRawValue(),
        date_picked: new Date()
    });
    var startEditAt = Ext.getCmp("pick_invoice_grid").store.getCount();
    Ext.getCmp("pick_invoice_grid").store.insert(startEditAt, r);
    editModelPick.startEdit(startEditAt, 0);
}
} else {
   Ext.defer(function () {
        Ext.getCmp("customers_combo").focus();
        Ext.getCmp("customers_combo").setValue('');

    }, 50);
  }
}
OBJ_Action.save_new = function (extra, byPassCreditLimit) {
var save=Ext.getCmp("so_hidden_id").getValue();
if(save ==0)
{
    editModelSO.cancelEdit();
    editModelPick.cancelEdit();

var _data = Ext.getCmp('sale_invoice_grid').store.data;
if (_data.items.length == 0) {
    return false;
}

var jsonInvoiceData = Ext.pluck(_data.items, 'data');
var isvalid = true;
for (var i = 0; i < jsonInvoiceData.length; i++) {
    if (!jsonInvoiceData[i].item_name || !jsonInvoiceData[i].item_id) {
        isvalid = false;
        break;
    }
}
if (isvalid == false) {
    Ext.Msg.show({
        title: 'Error Occured',
        msg: 'One of the item row is empty, please delete or fill item to continue.',
        buttons: Ext.Msg.OK,
        icon: Ext.Msg.ERROR
    });
    return false;
}

jsonInvoiceData = Ext.encode(jsonInvoiceData);
var jsonPickData = Ext.encode(Ext.pluck(Ext.getCmp('pick_invoice_grid').store.data.items, 'data'));

var status_val = 2;
// workaround for now
Ext.getCmp("so_total_pick").setValue(Ext.getCmp("so_total_ordered").getValue());

var _total_pick = parseFloat(Ext.getCmp("so_total_pick").getValue());
var _total_order = parseFloat(Ext.getCmp("so_total_ordered").getValue());

var _total_amount = parseFloat(Ext.getCmp("so_total").getValue());
var _total_paid = parseFloat(Ext.getCmp("so_paid").getValue());
var _discount = parseFloat(Ext.getCmp("so_discount_invoice").getValue());
var _credit_limit = parseFloat(customer_store_active.getById(Ext.getCmp("customers_combo").getValue()).get("cust_credit_limit"));
var _grand_total = parseFloat(Ext.getCmp("grand_total_balance").getValue());
   var _net_paid = parseFloat(Ext.getCmp("paid_total").getValue());
var _net=Number(_net_paid)+Number(_discount);
if (!byPassCreditLimit && Ext.getCmp("so_hidden_id").getValue() == "0" && _credit_limit && _grand_total > _credit_limit) {
    Ext.Msg.show({
        title: 'Credit Limit',
        msg: 'Customer credit Limit exceeds provided limit <b>"' + Ext.util.Format.number(_credit_limit, "0.00") + ' Rs.</b>"',
        buttons: Ext.Msg.YESNO,
        icon: Ext.Msg.WARNING,
        fn: function (btn, text) {
            if (btn == 'yes') {
                OBJ_Action.save_new(false, true)
            }
        }
    });
    return false;
}
var c_total_amount = _total_amount;
if (sale_invoice_mode == 1) {
    c_total_amount = -1 * _total_amount;
    _total_paid = -1* _total_paid;
    _discount = -1* _discount;
}
if (sale_invoice_mode !== 2) {
    if (Ext.getCmp("customers_combo").getValue() === "0" && _total_paid + _discount < c_total_amount) {
        Ext.Msg.show({
            title: 'Payment',
            msg: 'Walk in customer need to pay complete amount.',
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR
        });
        return false;
    }

    if (_total_paid + _discount > c_total_amount) {
        Ext.Msg.show({
            title: 'Payment',
            msg: 'Please pay the exact amount.',
            buttons: Ext.Msg.OK,
            icon: Ext.Msg.ERROR
        });
        return false;
    }
}


if (_total_pick == 0) {
    status_val = 2;
}
else if (_total_pick > 0 && _total_pick <= _total_order && _total_paid == 0) {
    status_val = 2;
}
else if (_total_pick > 0 && _total_pick == _total_order && _net > 0 && _net < _total_amount) {
    status_val = 3;
}
else if (_total_amount >= _net) {
    status_val = 4;
}
if (sale_invoice_mode == 1) {
    status_val = 3;
}
else if (sale_invoice_mode == 2){
    status_val = 1;
}
so_date_time = Ext.Date.format(Ext.getCmp("so_date").getValue(), 'Y-m-d') + ' ' + Ext.Date.format(new Date(), 'H:i:s');
Ext.getCmp("so_order_status").setValue(status_val);
Ext.getCmp("so_datetime_hidden").setValue(so_date_time);
Ext.getCmp("so_status").setValue(OBJ_Action.SaleinvoiceStatus['_' + status_val]);
Ext.get("img_stamp").dom.className = "stamps " + OBJ_Action.SaleinvoiceStatusImage['_' + status_val];
   if (extra && extra.print) {
    print = extra.print;
}
    var formPanel=  Ext.getCmp("sale-invoice-panel-form");
    var form = Ext.encode(formPanel.getValues());
        // var values = formPanel.getFieldValues();
    
    var save_new=1;   
    Ext.Ajax.request({
    url: action_urls.url_saleinvoice_save,
    method: 'POST',
    params: {
        data:form,
         trans: jsonInvoiceData,
            pick: jsonPickData,
            save_new:save_new
    },
    success: function (response) {
      var myStore = Ext.getCmp('sale_invoice_grid').store;
       fields=Ext.getCmp("sale-invoice-panel-form").query('[isFormField][name!="cust_group_name"][name!="so_sale_rep_assign"]');
      for (var i = 0, len = fields.length; i < len; i++) {
                        fields[i].reset();
                    }
         myStore.load();                    
    },
    failure: function () {
        LoadingMask.hideMessage();
    }
});

}
else{
     var myStore = Ext.getCmp('sale_invoice_grid').store;
     myStore.load();   
     OBJ_Action.makeNew({
                'save_other': OBJ_Action.saveme
            });                  
}

}

OBJ_Action.getPriceLevel = function (cust_id) {
//LoadingMask.showMessage('Loading Price Level...'); 

Ext.Ajax.request({
    url: action_urls.get_so_pricelevel,
    method: 'GET',
    params: {
        cust_id: cust_id
    },
    success: function (response) {
        //LoadingMask.hideMessage();
        var data = Ext.JSON.decode(response.responseText);
        OBJ_Action.price_level = null;
        if(sale_invoice_mode==0){
            if (data.cust_estimate_count!=="0") {
                Ext.getCmp("load_estimates_button").setDisabled(false);
            }
            else{
                Ext.getCmp("load_estimates_button").setDisabled(true);
            }
        }
        if (data.cust_price_level) {
            OBJ_Action.price_level = {}
            OBJ_Action.price_level['p_level'] = data.cust_price_level;
        }
        if (data.cust_price_level_items) {
            OBJ_Action.price_level['level_items'] = data.cust_price_level_items;
        }
        OBJ_Action.refreshPrice();
    },
    failure: function () {
        LoadingMask.hideMessage();
    }
});
OBJ_Action.getPreviousBalance(cust_id,date=null);
}

OBJ_Action.getCustomeRegister = function (cust_id,date,edit)
{
var table='';
// Ext.Ajax.setTimeout(5000);
Ext.Ajax.request({
    url: action_urls.get_SaleInvoiceRegister,
    method: 'GET',
    params: {
        account_id: customer_store_active.getById(cust_id).get("account_id"),
        type_id: 1,
        register_for:'sale_invoice',
        start_date: OBJ_Action.getDateMysqlFormatWithTime(new Date()),
        end_date: date
    },
    success: function (response) {
        var data = Ext.JSON.decode(response.responseText);
        if(data.length==0)
        {
            Ext.getCmp("prev_total_balance").setValue("0.00");
           Ext.getCmp('customer_transections').update('');   
               OBJ_Action.calc.calGrid();
            OBJ_Action.calc.calTotalSubTotal();
        }
        else{
           if (data && data.register) {
            var len = data.register.length;
            
            var count=0;
                if(len<=5) { count=0; }
                // else if(len==6) {  count=len-5;  }
                // else if(len==7) {  count=len-5;  }
                // else if(len==8) {  count=len-5;  }
                // else if(len==9) {  count=len-5;  }
                else{
                    count=len-5;
                  }
             
                 table = '<table class="register_table"><thead><tr><th>'+labels_json.saleinvoicepanel.reg_date+'</th><th>'+labels_json.saleinvoicepanel.reg_number+'</th><th>'+labels_json.saleinvoicepanel.reg_account+'</th><th>'+labels_json.saleinvoicepanel.reg_amt_charge+'</th><th>'+labels_json.saleinvoicepanel.reg_amt_paid+'</th><th>'+labels_json.saleinvoicepanel.reg_balance+'</th></tr></thead><tbody>';
                 var regbal=0;
                 var label='';
            for ( var i = count;  i < len; i++) {
                if(data.register[i].account=='Discount' && data.register[i].detail!='Sale Invoice total')
                {
                    label='Register Discount';
                }
                else if(data.register[i].account=='Discount' && data.register[i].detail=='Sale Invoice total')
                {
                    label='Sales Discount';
                }
                else{
                    label=data.register[i].account;
                }
            table += '<tr><td>'+data.register[i].date+'</td><td>'+data.register[i].number+'</td><td>'+label+'</td><td>'+data.register[i].increase+'</td><td>'+data.register[i].decrease+'</td><td>'+Ext.util.Format.number(parseFloat(data.register[i].balance), "0.00")+'</td></tr>';
                
               regbal=data.register[i].balance;
            }
            table += '</tbody></table>';
            Ext.getCmp('customer_transections').update(table); 
                //console.log(regbal)
            if(edit==0)
            {
                   Ext.getCmp("prev_total_balance").setValue(Ext.util.Format.number(parseFloat(data.register[data.register.length - 1].balance), "0.00"));
            OBJ_Action.calc.calGrid();
            OBJ_Action.calc.calTotalSubTotal();
        } else{
             Ext.getCmp("prev_total_balance").setValue(Ext.util.Format.number(parseFloat(regbal), "0.00"));
              OBJ_Action.calc.calGrid();
            OBJ_Action.calc.calTotalSubTotal();
        }
            }
            else {
            Ext.getCmp("prev_total_balance").setValue("0.00");
        }  
        }
       
         

    },
    failure: function () {
        Ext.getCmp("prev_total_balance").setValue("0.00");
        LoadingMask.hideMessage();
    }
});


}  

if(enable_InvRegister==0)
{
  OBJ_Action.getPreviousBalance = function (cust_id) {
if (cust_id === "0") {
    Ext.getCmp("prev_total_balance").setValue("0.00");
    return false;
}
Ext.Ajax.request({
    url: action_urls.getCustomerPrevious,
    method: 'GET',
    params: {
        account_id: customer_store_active.getById(cust_id).get("account_id"),
        type_id: 1,
        start_date: OBJ_Action.getDateMysqlFormatWithTime(new Date()),
        end_date: OBJ_Action.getDateMysqlFormatWithTime(new Date())
    },
    success: function (response) {
        //LoadingMask.hideMessage();
        var data = Ext.JSON.decode(response.responseText);
        if (data && data.register) {
            Ext.getCmp("prev_total_balance").setValue(Ext.util.Format.number(parseFloat(data.register[data.register.length - 1].balance), "0.00"));
        }
        else {
            Ext.getCmp("prev_total_balance").setValue("0.00");
        }

    },
    failure: function () {
        Ext.getCmp("prev_total_balance").setValue("0.00");
        LoadingMask.hideMessage();
    }
});
}
}  else{
OBJ_Action.getPreviousBalance = function (cust_id) {
if (cust_id === "0") {
    Ext.getCmp("prev_total_balance").setValue("0.00");
    return false;
}
OBJ_Action.getCustomeRegister(cust_id,date=null,edit=0);

}
}

OBJ_Action.getAdjustedPrice = function (item) {
var price = parseFloat(item.get("sprice"));
var discount = 0;
if (OBJ_Action.price_level) {
    var sale_price = item.get("sprice");
    var percentage_of = OBJ_Action.price_level.p_level.level_per;
    var adjust = OBJ_Action.price_level.p_level.level_dir;

    var diff = parseFloat(sale_price) * (parseFloat(percentage_of) / 100);

    if (OBJ_Action.price_level.p_level.level_type == "2") {
        sale_price = (OBJ_Action.price_level.p_level.level_compare_price == "1") ? item.get("sprice") : item.get("unit_price");
        var _per = 0;
        var itemExists = false;
        for (var i = 0; i < OBJ_Action.price_level.level_items.length; i++) {
            if (OBJ_Action.price_level.level_items[i].item_id == item.get("id")) {
                itemExists = true;
                _per = OBJ_Action.price_level.level_items[i].item_per_level;
                break;
            }
        }
        if (itemExists) {
            diff = parseFloat(sale_price) * (parseFloat(_per) / 100);
            price = parseFloat(item.get("sprice")) + diff;
            discount = parseFloat(_per) < -1 ? -1 * parseFloat(_per) : parseFloat(_per);
        }
    }
    else {

        price = parseFloat(item.get("sprice")) + (parseFloat(adjust) * diff);
        discount = percentage_of;
    }



}
return {
    p: price.toFixed(2),
    discount: discount
};
}

OBJ_Action.refreshPrice = function () {
var grid_items = Ext.getCmp('sale_invoice_grid').store.data.items;
for (var i = 0; i < grid_items.length; i++) {
    var adj = OBJ_Action.getAdjustedPrice(item_store.getById(grid_items[i].get("item_id")));
    grid_items[i].set("discount", adj.discount + "%");
    var sub_total = adj.p * parseFloat(grid_items[i].get("item_quantity"));
    grid_items[i].set("sub_total", sub_total);

}

}
OBJ_Action.mouseOverRow = null;
OBJ_Action.populateTooltip = function(tip){
var record = null;
var record2 = null;
var purchasePrice = 0;
var barcode = "N/A";
var avg_cost=0;
var ware_qty='';    
  var ware_name=''; 
 var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
var qty = 0;
if(enableUom==1)
{
 if(tip.triggerElement===true){
    var editSelectBox = Ext.getCmp("item_name_so");
    if(editSelectBox.getValue()){
        record = editSelectBox.findRecordByValue(editSelectBox.getValue());
    }
    var editSelectBox2 = Ext.getCmp("sale_item_uom");
    if(editSelectBox2.getValue()){
        record2 = editSelectBox2.findRecordByValue(editSelectBox2.getValue());
    }
    if(record){ 
            var data=record.get('item_warehouses');
      for(var i=0;i<data.length;i++){

        if(sel.get("ware_id")==data[i].ware_id){
              ware_qty=data[i].qty;  
              ware_name=data[i].warehouse_name;  
                 }
               }
        qty = parseFloat(ware_qty/record2.get("conv_from"));
        avg_cost =parseFloat(record.get("navg_cost")*record2.get("conv_from"));
        purchasePrice = parseFloat(record.get("nprice")*record2.get("conv_from"));
        barcode = record.get("barcode");                    
    }
}
else{                    
    record = Ext.getCmp("sale_invoice_grid").store.data.items[OBJ_Action.mouseOverRow];
    if(record){                        
        qty = parseFloat(ware_qty/record2.get("conv_from"));
        avg_cost =parseFloat(record.get("navg_cost")/record2.get("conv_from"));
        purchasePrice = parseFloat(record.get("nprice")*record2.get("conv_from")) ;
        barcode = record.get("barcode");
             }
    
} 
}
else{
 var editSelectBox = Ext.getCmp("item_name_so");
    if(editSelectBox.getValue()){
        record = editSelectBox.findRecordByValue(editSelectBox.getValue());
    }
        qty = parseFloat(record.get("qty"));
        avg_cost =parseFloat(record.get("navg_cost"));
        purchasePrice = parseFloat(record.get("nprice")) ;
        barcode = record.get("barcode");
}
       
if(record){  
    tip.update('<div class="popover-content"><table class="table"><tbody><tr><td>'+labels_json.saleinvoicepanel.item_purchase_cost+' </td><td>:</td><td>'+purchasePrice+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.item_avg_cost+' </td><td>:</td><td>'+avg_cost+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.qty_on_hand+'</td><td>:</td><td>'+qty.toFixed(2)+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.item_barcode+' </td><td>:</td><td>'+barcode+'</td></tr></tbody></table></div>');
    //tip.update('<div class="popover-content"><div>Purchase Cost: '+purchasePrice+'</div><div>Average Cost: '+avg_cost+'</div><div>Quantity on Hand: '+qty.toFixed(2)+'</div><div>Bar Code: '+barcode+'</div></div>');
}
else{
    tip.hide();
}

}
OBJ_Action.populateInvTooltip=function(invtip) {
// var record=null;
var _qty=0;
 var _conv_from=0;
var _sum=0;
var _avgcost=0;
var tot=0;
 var sale_grid = Ext.pluck(Ext.getCmp('sale_invoice_grid').store.data.items, 'data');
 for (var i = 0; i < sale_grid.length; i++) {

        _qty =  parseFloat(sale_grid[i].item_quantity);
         _conv_from=_conv_from+parseFloat(sale_grid[i].item_quantity*sale_grid[i].conv_from);
        _avgcost =  parseFloat(sale_grid[i].normal_price);
        _sum=_qty*_avgcost;
        tot=tot+_sum;

    }
_conv_from = Ext.util.Format.number(parseFloat(_conv_from), "0");
 var purchaseCost =tot;
var SalePrice =Ext.getCmp("unit_price_so").getValue();
var discount=parseInt(Ext.getCmp("so_discount").getValue())+parseInt(Ext.getCmp("so_discount_invoice").getValue());
var sale = SalePrice-discount;
var Total_Profit=sale-purchaseCost;
 invtip.update('<div class="popover-content"><table class="invtable"><tbody><tr><td style="width: 50%;">'+labels_json.saleinvoicepanel.inv_purchase_cost+'</td><td style="width: 10%;">:</td><td style="width: 40%;">'+purchaseCost+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.inv_sale_price+'</td><td>:</td><td>'+SalePrice+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.inv_discount+'</td><td>:</td><td>'+discount+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.inv_total_sale+'</td><td>:</td><td>'+sale+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.inv_profit+'</td><td>:</td><td>'+Total_Profit+'</td></tr><tr><td>'+labels_json.saleinvoicepanel.inv_base_unit+'</td><td>:</td><td>'+_conv_from +'</td></tr></tbody></table></div>');
}

if (!document.getElementById("img_stamp")) {
Ext.get("stamp-column").appendChild({
    tag: "div",
    id: "img_stamp",
    cls: 'stamps open'
})
}
else {
document.getElementById("img_stamp").className = "stamps open";
}
OBJ_Action.setInvoiceMode = function(conv){
if (sale_invoice_mode === 1) {

Ext.getCmp("so_due_date").setVisible(false);
Ext.getCmp("so_status").setVisible(false);
Ext.get("img_stamp").dom.style.display = "none";
Ext.getCmp('sale_invoice_grid').columns[7].setText(labels_json.saleinvoicepanel.col_deduction);
Ext.getCmp('sale-invoice-panel-grid').columns[0].setText(labels_json.saleinvoicepanel.text_order_no);
Ext.get("so_discount_invoice-labelEl").dom.innerHTML = labels_json.saleinvoicepanel.text_invoice_deduction;
Ext.get("discount_field_so").dom.innerHTML = labels_json.saleinvoicepanel.col_deduction;
Ext.getCmp("sale-invoice-panel").setTitle(labels_json.saleinvoicepanel.heading_title_1);
Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText(labels_json.saleinvoicepanel.heading_title_1);
//Ext.getCmp("so_right_bottom_panel").setVisible(false);
Ext.getCmp("order_status_search").setVisible(false);
Ext.getCmp("next_sale_order_btn").setVisible(false);
Ext.getCmp("pre_sale_order_btn").setVisible(false);
Ext.getCmp("so_allow_prevbalance").setVisible(false);
Ext.getCmp("so__create_item").setVisible(false);
Ext.getCmp("order_no_search").setFieldLabel(labels_json.saleinvoicepanel.text_order_no);
Ext.getCmp("so_id").setFieldLabel(labels_json.saleinvoicepanel.text_order_no);
Ext.getCmp("so_paid_link").setVisible(true);
Ext.getCmp("so_paid").setVisible(true);
Ext.getCmp("so_balance_text").setVisible(true);
Ext.getCmp("so_total_balance").setVisible(true);
Ext.getCmp("prev_total_balance_text").setVisible(true);
Ext.getCmp("prev_total_balance").setVisible(true);
Ext.getCmp("so_grand_total_text").setVisible(true);
Ext.getCmp("grand_total_balance").setVisible(true);
Ext.getCmp("so_create_invoice").setVisible(false);
Ext.getCmp("load_estimates_button").setVisible(false);
//Ext.get("sub_total_bar").dom.style.visibility="visible";
Ext.get("so_discount_invoice").dom.style.visibility="visible";
Ext.getCmp("est_total_text").setVisible(false);
Ext.getCmp("est_total").setVisible(false);
//Ext.getCmp("est_subtotal_text").setVisible(false);
//Ext.getCmp("est_subtotal").setVisible(false);

}
else if(sale_invoice_mode === 0) {

if(conv===true){
    Ext.getCmp("so_id").setValue('');  
    Ext.getCmp("so_estimate_id").setValue(Ext.getCmp("so_hidden_id").getValue());
    Ext.getCmp("so_hidden_id").setValue(0);
}                
Ext.getCmp("so_due_date").setVisible(true);
Ext.getCmp("so_status").setVisible(false);
//Ext.getCmp("so_right_bottom_panel").setVisible(true);
Ext.get("img_stamp").dom.style.display = "block";
Ext.getCmp('sale_invoice_grid').columns[7].setText(labels_json.saleinvoicepanel.col_discount);
Ext.getCmp('sale-invoice-panel-grid').columns[0].setText(labels_json.saleinvoicepanel.text_order_no);
Ext.get("so_discount_invoice-labelEl").dom.innerHTML = labels_json.saleinvoicepanel.text_invoice_discount;
Ext.get("discount_field_so").dom.innerHTML = labels_json.saleinvoicepanel.col_discount;
Ext.getCmp("sale-invoice-panel").setTitle(labels_json.saleinvoicepanel.heading_title_0);
Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText(labels_json.saleinvoicepanel.heading_title_0);
Ext.getCmp("order_status_search").setVisible(true);
Ext.getCmp("next_sale_order_btn").setVisible(true);
Ext.getCmp("pre_sale_order_btn").setVisible(true);
Ext.getCmp("so_allow_prevbalance").setVisible(true);
Ext.getCmp("so__create_item").setVisible(true);
Ext.getCmp("order_no_search").setFieldLabel(labels_json.saleinvoicepanel.text_order_no);
Ext.getCmp("so_id").setFieldLabel(labels_json.saleinvoicepanel.text_order_no);
Ext.getCmp("so_paid_link").setVisible(true);
Ext.getCmp("so_paid").setVisible(true);
Ext.getCmp("so_balance_text").setVisible(true);
Ext.getCmp("so_total_balance").setVisible(true);
Ext.getCmp("prev_total_balance_text").setVisible(true);
Ext.getCmp("prev_total_balance").setVisible(true);
Ext.getCmp("so_grand_total_text").setVisible(true);
Ext.getCmp("grand_total_balance").setVisible(true);
Ext.getCmp("so_create_invoice").setVisible(false);
Ext.getCmp("load_estimates_button").setVisible(true);
//Ext.get("sub_total_bar").dom.style.visibility="visible";
Ext.get("so_discount_invoice").dom.style.visibility="visible";
Ext.getCmp("est_total_text").setVisible(false);
Ext.getCmp("est_total").setVisible(false);
//Ext.getCmp("est_subtotal_text").setVisible(false);
//Ext.getCmp("est_subtotal").setVisible(false);
    

}
else if(sale_invoice_mode === 2){
                                
Ext.getCmp("so_due_date").setVisible(false);
Ext.getCmp("so_status").setVisible(false);
Ext.get("img_stamp").dom.style.display = "none"; 
//Ext.getCmp("so_right_bottom_panel").setVisible(false);
Ext.getCmp('sale_invoice_grid').columns[6].setText(labels_json.saleinvoicepanel.col_discount);
Ext.getCmp('sale-invoice-panel-grid').columns[0].setText(labels_json.saleinvoicepanel.heading_title_2+"#");
Ext.get("so_discount_invoice-labelEl").dom.innerHTML = labels_json.saleinvoicepanel.text_invoice_discount;
Ext.get("discount_field_so").dom.innerHTML = labels_json.saleinvoicepanel.col_discount;
Ext.getCmp("sale-invoice-panel").setTitle(labels_json.saleinvoicepanel.heading_title_2);
Ext.getCmp("so_tab_panel").child('#so_sale_panel').tab.setText(labels_json.saleinvoicepanel.heading_title_2);
Ext.getCmp("order_status_search").setVisible(false);
Ext.getCmp("next_sale_order_btn").setVisible(false);
Ext.getCmp("pre_sale_order_btn").setVisible(false);
Ext.getCmp("so_allow_prevbalance").setVisible(false);
Ext.getCmp("order_no_search").setFieldLabel(labels_json.saleinvoicepanel.heading_title_2+"#");
Ext.getCmp("so_id").setFieldLabel(labels_json.saleinvoicepanel.heading_title_2+"#");
Ext.getCmp("so_paid_link").setVisible(false);
Ext.getCmp("so_paid").setVisible(false);
Ext.getCmp("so_balance_text").setVisible(false);
Ext.getCmp("so_total_balance").setVisible(false);
Ext.getCmp("prev_total_balance_text").setVisible(false);
Ext.getCmp("prev_total_balance").setVisible(false);
Ext.getCmp("so_grand_total_text").setVisible(false);
Ext.getCmp("grand_total_balance").setVisible(false);
Ext.getCmp("so_create_invoice").setVisible(true);                
Ext.getCmp("load_estimates_button").setVisible(false);
//Ext.get("sub_total_bar").dom.style.visibility="hidden";
Ext.get("so_discount_invoice").dom.style.visibility="hidden";
Ext.getCmp("est_total_text").setVisible(true);
Ext.getCmp("est_total").setVisible(true);
//Ext.getCmp("est_subtotal_text").setVisible(true);
//Ext.getCmp("est_subtotal").setVisible(true);


}
Ext.getCmp("so_type").setValue(sale_invoice_mode);
}

OBJ_Action.setInvoiceMode();
}
},

items: [
{
region: 'west',
width: 250,
title: labels_json.saleinvoicepanel.button_search,
split: true,
collapsible: true,
collapsed: true,
id: 'sale_left_panel',
layout: 'border',
listeners: {
expand: function () {
    var s = Ext.getCmp("sale-invoice-panel-grid").store;
    // s.load({params: {salereturn: sale_invoice_mode}});
    // console.log(s)
    Ext.defer(function(){Ext.getCmp("order_no_search").focus(true)},200); 
     var map_register = new Ext.util.KeyMap("sale_left_panel", [
    {
        key: [10,13],
        fn: function(){ Ext.getCmp("so_search_btn").fireHandler();}
        }
    ]);
},
collapse: function(){
    Ext.defer(function(){Ext.getCmp("customers_combo").focus(true)},100); 
}
},
items: [
{
    region: 'north',
    layout: 'anchor',
    height: 115,
    defaults: {
        anchor: '100%',
        margin: '5'
    },
    items: [
        {
            xtype: 'textfield',
            fieldLabel: labels_json.saleinvoicepanel.text_order_no,
            id: 'order_no_search'
        },
        {
            xtype: 'combo',
            fieldLabel: labels_json.saleinvoicepanel.text_status,
            id: 'order_status_search',
            displayField: 'name',
            queryMode: 'local',
            typeAhead: true,
            valueField: 'id',
            value: '0',
            store: new Ext.data.Store({
                fields: ['id', 'name'],
                data: [
                    {
                        "id": "0",
                        "name": "All"
                    },
                    {
                        "id": "1",
                        "name": "Open"
                    },
                    {
                        "id": "2",
                        "name": "Pending"
                    },
                    {
                        "id": "3",
                        "name": "Completed"
                    }
                ]
            })
        },
        {
            xtype: 'combo',
            fieldLabel: labels_json.saleinvoicepanel.text_customer,
            displayField: 'cust_name',
            valueField: 'cust_id',
            id: 'order_customer_search',
            queryMode: 'local',
            value: '-1',
            typeAhead: true,
            store: customer_store_withall

        },
        {
            layout: 'border',
            border: false,
            bodyBorder: false,
            height: 22,
            defaults: {
                border: false
            },
            items: [{
                    region: 'center',
                    items: [
                        {
                            xtype: 'button',
                            id: 'so_search_btn_btn',
                            text: labels_json.saleinvoicepanel.button_show_all,
                            style: 'float:right',
                            width: 80,
                            listeners: {
                                click: function () {
                                    var params = {salereturn: sale_invoice_mode};
                                    if(user_right==3){
                                        params["search_customer"] = customer_id;
                                        params["search"] = 1;
                                       params["search_status"] = 0;
                                    }
                                    Ext.getCmp("sale-invoice-panel-grid").store.load({params: params});
                                }
                            }
                        }, {
                            xtype: 'button',
                            text: labels_json.saleinvoicepanel.button_search,
                            id: 'so_search_btn',
                            style: 'float:right;margin-right:10px',
                            width: 80,
                            listeners: {
                                click: function () {
                                    Ext.getCmp("sale-invoice-panel-grid").store.load({
                                        params: {
                                            search: '1',
                                            search_invoice_id: Ext.getCmp("order_no_search").getValue(),
                                            search_status: Ext.getCmp("order_status_search").getValue(),
                                            search_customer: Ext.getCmp("order_customer_search").getValue(),
                                            salereturn: sale_invoice_mode
                                        }
                                    });
                                }
                            }
                        }]
                }]

        }
    ]
}, 
{
    border: false,
    bodyBorder: false,
    region: 'center',
    layout: 'fit',
    items: [{
            xtype: "gridpanel",
            id: "sale-invoice-panel-grid",
            store: {
                proxy: {
                    type: "ajax",
                    url: action_urls.get_so,
                    reader: {
                        type: "json",
                        root: 'orders',
                        idProperty: 'so_id'
                    }
                },
                model: Ext.define("orderListSearchModel", {
                    extend: "Ext.data.Model",
                    fields: [
                        {
                            name: "inv_no",
                            type: 'string',
                            convert: function (v, r) {
                                return  sale_invoice_mode=="2"?"EST-" + v:inv_prefix + v;
                            }
                        },
                        "id",
                        "so_date",
                        "so_id",
                        "so_status",
                        "cust_name",
                        "cust_id",
                        "so_due_date",
                        "so_total",
                        "so_paid",
                        "so_balance"

                    ]
                }) && "orderListSearchModel"

            },
            listeners: {
                afterRender: function () {
                    //this.superclass.afterRender.call(this);
                    this.nav = new Ext.KeyNav(this.getEl(), {
                        del: function (e) {

                        }
                    });
                },
                itemdblclick: function (v, r, item, index, e, args) {
                        if(user_right==1 || user_right==3){
                            editItem.id = r.get("id");
                            // alert(editItem.id)
                            editItem.type = "";
                            OBJ_Action.editme(); 
                        } else {
                        if(sale_invoice_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.edit){ 
                            editItem.id = r.get("id");
                            editItem.type = "";
                            OBJ_Action.editme();
                        } else if(sale_invoice_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_return.actions.edit){ 
                            editItem.id = r.get("id");
                            editItem.type = "";
                            OBJ_Action.editme();
                        } else if(sale_invoice_mode == "2" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_estimate.actions.edit){ 
                            editItem.id = r.get("id");
                            editItem.type = "";
                            OBJ_Action.editme();
                        } else {
                            Ext.Msg.show({
                                title:'User Access Conformation',
                                msg:'You have no access to Edit this invoice',
                                buttons:Ext.Msg.OK,
                                callback:function(btn) {
                                    if('ok' === btn) {
                                    }
                                }
                            });
                        }
                    }
                    
                }

            },
            columnLines: true,
            columns: [
                {
                    header: labels_json.saleinvoicepanel.text_order_no,
                    dataIndex: "inv_no",
                    flex: 70
                },
                 {
                    header: labels_json.saleinvoicepanel.text_customer,
                    dataIndex: "cust_name",
                    flex: 90
                },
                {
                    header: labels_json.saleinvoicepanel.text_date,
                    dataIndex: "so_date",
                    width: 80
                }

            ]
        }]
}]

},
{
region: 'center',
layout: 'fit',
border: false,
bodyBorder: false,
items: new Ext.FormPanel({
layout: 'border',
id: 'sale-invoice-panel-form',
bodyBorder: false,
defaults: {
    border: false
},
items: [
    {
        region: 'north',
        height: 90,
        layout: 'column',
        defaults: {
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            }
        },
        items: [
            {
                columnWidth: 1.2 / 4,
                baseCls: 'x-plain',
                padding: 5,
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
                        id: 'customer_region',
                        //fieldLabel: labels_json.saleinvoicepanel.text_customer,
                        defaults: {
                            hideLabel: true
                        },
                items: [
                    {
                        xtype: 'combo',
                        tabIndex: -1,
                        //fieldLabel: labels_json.saleinvoicepanel.text_customer,
                        id: '_cust_group_name_',
                        name: 'cust_group_name',
                        allowBlank: false,
                        valueField: 'id',
                        width:'30%',
                        maxWidth:'30%',
                        value:'-1',
                        editable:false,  
                        forceSelection: true,                                     
                        typeAhead: true,
                        displayField: 'cust_group_name',
                        emptyText: labels_json.saleinvoicepanel.text_empty_region,
                        store: customer_group_store_withall,
                        queryMode: 'local',
                        listeners: {
                              change: function (f, obj) {
                              Ext.Ajax.request({
                                url: action_urls.get_region_customers,
                                method: 'GET',
                                params: {
                                    region_id: this.value
                                },
                                success: function (response) {
                                var data = Ext.JSON.decode(response.responseText);
                                customer_store_active.removeAll();
                                Ext.getCmp("customers_combo").clearValue();
                                Ext.getCmp("customer_mobile").setValue('');
                                Ext.getCmp("customers_combo").store.loadData(data.customers);
                                Ext.getCmp("customers_combo").store.insert(0,{"cust_id":"-2","cust_name":labels_json.saleinvoicepanel.text_add_new_customer});
                                },
                                failure: function () {
                                }
                            });  
                            },

                        }
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: '',
                        cls:'customers_combo',
                        id: 'customers_combo',
                        name: 'customer_id',
                        allowBlank: false,
                        width:'70%',
                        maxWidth:'70%',
                        forceSelection: true,
                        valueField: 'cust_id',
                        tabIndex: 1,
                        flex: 1,
                        displayField: 'cust_name',
                        emptyText: labels_json.saleinvoicepanel.text_empty_customer,
                        store: customer_store_active,
                        queryMode: 'local',
                        listeners: {
                            change: function (f, obj) {
                                Ext.getCmp('customer_transections').update(' '); 
                                if (f.getValue() !== "-2") {
                                    this.up("form").getForm().findField("customer_contact").setValue('');
                                    
                                    var record = f.findRecordByValue(f.getValue());
                                    if (record.get) {
                                        if (f.getValue() !== "0") {
                                            // console.log(record);
                                            this.up("form").getForm().findField("customer_contact").setValue(record.get("cust_phone"));
                                            this.up("form").getForm().findField("customer_mobile").setValue(record.get("cust_mobile"));
                                            this.up("form").getForm().findField("so_cust_group").setValue(record.get("cust_group"));
                                            this.up("form").getForm().findField("so_cust_address").setValue(record.get("cust_address"));
                                        
                                        }
                                        if(f.getValue()=="0"){
                                            //Ext.getCmp("so_balance_text").hide();
                                            //Ext.getCmp("so_total_balance").hide();
                                            Ext.getCmp("prev_total_balance_text").hide();
                                            Ext.getCmp("prev_total_balance").hide();
                                            Ext.getCmp("so_grand_total_text").hide();
                                            Ext.getCmp("grand_total_balance").hide();
                                            Ext.getCmp('customer_transections').update('');
                                        } else {
                                            //Ext.getCmp("so_balance_text").show();
                                            //Ext.getCmp("so_total_balance").show();
                                            Ext.getCmp("prev_total_balance_text").show();
                                            Ext.getCmp("prev_total_balance").show();
                                            Ext.getCmp("so_grand_total_text").show();
                                            Ext.getCmp("grand_total_balance").show();
                                        }
                                        if (!editItem.loadMode) {
                                            OBJ_Action.getPriceLevel(f.getValue());
                                        }
                                        OBJ_Action.recordChange();
                                        f.doQuery('');
                                        f.collapse();
                                    }                                                
                                }
                                else {
                                    new_customer_form.show();
                                    Ext.getCmp("customers_combo").setValue("");
                                }
                                if(!Ext.getCmp("customers_combo").getValue()){
                                    Ext.getCmp("load_estimates_button").setDisabled(false);
                                }
                                
                                // Ext.getCmp("order_customer_search").setValue(Ext.getCmp("customers_combo").getValue());
                                // Ext.getCmp("sale-invoice-panel-grid").store.load({
                                //     params: {
                                //         search: '1',
                                //         search_invoice_id: Ext.getCmp("order_no_search").getValue(),
                                //         search_status: Ext.getCmp("order_status_search").getValue(),
                                //         search_customer: Ext.getCmp("order_customer_search").getValue(),
                                //         salereturn: sale_invoice_mode
                                //     }
                                // });
                                // Ext.getCmp("so_search_btn").fireHandler();
                            }
                        }
                    }
                ]
            },
            {
                        xtype: 'fieldcontainer',
                        combineErrors: true,
                        msgTarget: 'side',
                        width:'100%',
                        maxWidth:'100%',
                        defaults: {
                            hideLabel: true
                        },
                items: [
                    {
                        xtype: 'textfield',
                        fieldLabel:'Mob',
                        name: 'customer_mobile',
                        width:'50%',
                        maxWidth:'50%',
                        value:'',
                        emptyText: labels_json.saleinvoicepanel.text_empty_mobile,
                        id: 'customer_mobile',
                        listeners: {
                            click: function () {
                                OBJ_Action.recordChange();
                            }
                        }
                    },{
                        xtype: 'textfield',
                        //fieldLabel:labels_json.saleinvoicepanel.text_empty_contact,
                        name: 'customer_contact',
                        emptyText: labels_json.saleinvoicepanel.text_empty_contact,
                        width:'50%',
                        maxWidth:'50%',
                        id: 'customer_contact',
                        listeners: {
                            click: function () {
                                OBJ_Action.recordChange();
                            }
                        }
                    }
                ]
            },
            
                    {
                        xtype: 'hidden',
                        name: 'so_hidden_id',
                        id: 'so_hidden_id',
                        value: '0'
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_estimate_id',
                        id: 'so_estimate_id',
                        value: '0'
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_payment_id',
                        id: 'so_payment_id',
                        value: '-1'
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_type',
                        id: 'so_type',
                        value: '',
                        listeners: {
                            change: function (obj) {
                                obj.setValue(sale_invoice_mode);
                            }
                        }
                    }, 
                    {
                        xtype: 'hidden',
                        name: 'so_already_shipped',
                        id: 'so_already_shipped',
                        value: '0'
                    }, 
                    {
                        xtype: 'hidden',
                        name: 'so_order_status',
                        id: 'so_order_status',
                        value: '1'
                    }, 
                    {
                        xtype: 'hidden',
                        name: 'so_cust_group',
                        id: 'so_cust_group',
                        value: '1'
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_cust_address',
                        id: 'so_cust_address',
                        value: '1'
                    },
                    {
                        layout: {
                            type: 'table',
                            columns: 4
                        },
                        border: false,
                        bodyBorder: false,
                        id: 'so_action_btn_panel',
                        margin: '10 0 0 0',
                        items: [ 
                            {
                                xtype: 'button',
                                //text: labels_json.saleinvoicepanel.button_add_item,
                                iconCls: 'add_new',
                                tabIndex:-1,                                                
                                id: 'so_new_item',
                                tooltip: labels_json.saleinvoicepanel.button_add_item,
                                width: 25,
                                listeners: {
                                    click: function () {
                                        OBJ_Action.addRecord();
                                    }
                                }
                            },
                            {
                                xtype: 'button',
                                //text: labels_json.saleinvoicepanel.button_delete_item,
                                margin: '0 0 0 5',
                                tabIndex:-1,
                                iconCls: 'delete',
                                tooltip: labels_json.saleinvoicepanel.button_delete_item,
                                id: 'so_del_item',
                                width: 25,
                                listeners: {
                                    click: function () {
                                        var current_tab = Ext.getCmp("so_tab_panel").items.indexOf(Ext.getCmp("so_tab_panel").getActiveTab());
                                        if (current_tab == 0) {
                                            OBJ_Action.calc.removeRecord('sale_invoice_grid');
                                        }
                                        else {
                                            OBJ_Action.calc.removeRecord('pick_invoice_grid');
                                        }
                                    }
                                }
                            },{
                                xtype: 'button',
                                //text: labels_json.saleinvoicepanel.button_create_item,
                                id: 'so__create_item',
                                margin: '0 0 0 5',
                                tabIndex:-1,
                                iconCls: 'new',
                                tooltip: labels_json.saleinvoicepanel.button_create_item,
                                width: 25,
                                listeners: {
                                    click: function () {
                                        if(user_right==1 || user_right==3 ){
                                            new_item_form.show();
                                         } else {
                                                if(Ext.decode(decodeHTML(userAccessJSON)).user_access.item.actions.new){ 
                                                   new_item_form.show();
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
                            },
                        {
                                xtype: 'button',
                                //text: labels_json.saleinvoicepanel.button_delete_item,
                                margin: '0 0 0 25',
                                tabIndex:-1,
                                iconCls: 'remove',
                                tooltip: labels_json.saleinvoicepanel.button_delete_item_all,
                                id: 'so_remove_all_item',
                                width: 25,
                                listeners: {
                                    click: function () {
                                        if(Ext.getCmp("sale_invoice_grid").store.getCount() > 0){
                                            Ext.Msg.show({
                                                title: 'Item List Warning',
                                                msg: 'Are you sure you want to remove all items from list?',
                                                buttons: Ext.Msg.YESNO,
                                                icon: Ext.Msg.WARNING,
                                                fn: function (btn, text) {
                                                    if (btn == 'no') {
                                                        return false;
                                                    } else {
                                                        Ext.getCmp('sale_invoice_grid').store.removeAll();
                                                        Ext.getCmp("sub_item_so").setValue("0.00");
                                                        Ext.getCmp("sub_qty_so").setValue("0.00");
                                                        Ext.getCmp("unit_price_so").setValue("0.00");
                                                        Ext.getCmp("so_discount").setValue("0.00");
                                                        Ext.getCmp("sub_total_total_so").setValue("0.00");
                                                        Ext.getCmp("so_discount_invoice").setValue("0.00");
                                                        Ext.getCmp("so_total_balance").setValue("0.00");
                                                        Ext.getCmp("grand_total_balance").setValue("0.00");
                                                    }
                                                }
                                            });
                                        } else {
                                          return false;  
                                        }
                                        
                                     }
                                }
                            }]


                    }
                ]
            }, 
            {
                columnWidth: 1 / 4,
                baseCls: 'x-plain',
                padding: 5,
                items: [
                    {
                        xtype: 'combo',
                        id: 'so_sale_rep_assign',
                        width:'100%',
                        maxWidth:'100%',
                        name: 'so_sale_rep_assign',
                        displayField: 'salesrep_name',
                        queryMode: 'local',
                        typeAhead: true,
                        valueField: 'id',
                        listeners: {
                            blur: function (obj, e, opt) {
                                if (OBJ_Action.tabpressed) {
                                    OBJ_Action.tabpressed = false;
                                    editModelSO.cancelEdit();
                                    OBJ_Action.addRecord();
                                }

                            },
                            specialkey: function (obj, e) {

                                if (e.getKey() == Ext.EventObject.TAB) {
                                    OBJ_Action.tabpressed = true;
                                }
                            },
                            change: function (f, obj) {
                                var record = f.findRecordByValue(f.getValue());
                                 if (f.getValue() !== "-1") {
                                      if (record.get) {
                                    OBJ_Action.recordChange();
                                    f.doQuery('');
                                    Ext.getCmp("so_sales_rep").setValue(record.get("id")); 
                                    Ext.getCmp("salerep_mobile").setValue(record.get("salesrep_mobile"));
                                      // this.up("form").getForm().findField("customer_mobile").setValue(record.get("cust_mobile"));
                                    f.collapse();
                                }
                                 }
                                 else{
                                    salesrep_form.show();
                                    Ext.getCmp("so_sale_rep_assign").setValue("");
                                 }

                              
                            }
                        },
                        value: '1',
                        store: salesrep_store
                    },
                    {
                        xtype: 'textfield',
                        name: 'salerep_mobile',
                        emptyText: labels_json.saleinvoicepanel.text_empty_mobile_rep,
                        value:'',
                        width:'100%',
                        maxWidth:'100%',
                        id: 'salerep_mobile',
                        listeners: {
                            click: function () {
                                OBJ_Action.recordChange();
                            }
                        }
                    }
                ]
            },
            {
                columnWidth: 0.8 / 4,
                baseCls: 'x-plain',
                id: 'stamp-column',
                height: 98,
                padding: 5,
                items: [
                    
                ]
            },
            {
                columnWidth: 1 / 4,
                baseCls: 'x-plain',
                style: 'position:relative;float:right',
                id: 'date-column',
                margin: '2 5 0 0',
                layout: {
                    type: 'table',
                    columns: 1,
                    itemCls: 'right-panel',
                    tableAttrs: {
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
                        items: [
                            {
                                xtype: 'textfield',
                                fieldLabel: labels_json.saleinvoicepanel.text_order_no,
                                readOnly: true,
                                cls: 'readonly',
                                id: 'so_id',
                                name: 'so_id',
                                enableKeyEvents: true,
                                listeners: {
                                    change: function () {
                                        OBJ_Action.recordChange();

                                    }
                                }
                            },
                            {
                                xtype: 'datefield',
                                fieldLabel: labels_json.saleinvoicepanel.text_date,
                                name: 'so_date',
                                id: 'so_date',
                                value: new Date(),
                                // maxValue: new Date(),
                                format: 'd-m-Y',
                                listeners: {
                                    change: function () {
                                        OBJ_Action.recordChange();

                                    }
                                }
                            },
                            {
                                xtype: 'datefield',
                                fieldLabel: labels_json.saleinvoicepanel.text_due_date,
                                name: 'so_due_date',
                                id: 'so_due_date',
                                value: Ext.Date.add(new Date(), Ext.Date.DAY, 7),
                                format: 'd-m-Y',
                                listeners: {
                                    change: function () {
                                        OBJ_Action.recordChange();

                                    }
                                }
                            },
                            {
                                xtype: 'textfield',
                                fieldLabel: labels_json.saleinvoicepanel.text_status,
                                value: 'Open',
                                hidden:true,
                                id: 'so_status',
                                name: 'so_status',
                                readOnly: true,
                                cls: 'readonly'
                            }]
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_salesrep',
                        id: 'so_sales_rep',
                        value: '1'
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_datetime_hidden',
                        id: 'so_datetime_hidden',
                        value: ''
                    },  {
                        xtype: 'hidden',
                        name: 'show_register_inv',
                        id: 'show_register_inv',
                        value: '1'
                    },  {
                        xtype: 'hidden',
                        name: 'show_register_print',
                        id: 'show_register_print',
                        value: '1'
                    }
                    
                ]
            }
        ]
    },
     {
        region: 'center',
        xtype: 'tabpanel',
        tabPosition: 'bottom',
        id: 'so_tab_panel',
        bodyBorder: false,
        border: false,
        defaults: {
            border: false,
            bodyBorder: false,
            listeners: {
                activate: function (tab, eOpts) {
                    if (tab.title === "Sale Order") {
                        Ext.get("so_action_btn_panel").setStyle("display", "block");
                    }
                    else if (tab.title === "Pick") {
                        Ext.get("so_action_btn_panel").setStyle("display", "block");
                        var _data = Ext.getCmp('sale_invoice_grid').store.data;
                        so_receive_item_store.loadData(Ext.pluck(_data.items, 'data'));
                    }
                    else if (tab.title === "Invoice") {
                        Ext.get("so_action_btn_panel").setStyle("display", "none");
                        OBJ_Action.payment();
                    }
                }
            }
        },
        items: [
            {
                title: labels_json.saleinvoicepanel.tab_sale,
                layout: 'border',
                bodyBorder: false,
                id: 'so_sale_panel',
                border: false,
                defaults: {
                    border: false,
                    bodyBorder: false
                },
                items: [
                    {
                        region: 'center',
                        layout: 'fit',
                        height: '100%',
                        maxHeight:'100%',
                        autoHeight: false,
                        items: [{
                          features: [{
                            ftype: 'summary',
                             dock: 'bottom'
                        }],
                                xtype: "gridpanel",
                                tabIndex: 4,
                                id: "sale_invoice_grid",
                                cls: "sale_invoice_grid",
                                plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                        clicksToMoveEditor: 1,
                                        autoCancel: false,
                                        listeners: {
                                            'canceledit': function (e) {
                                                OBJ_Action.searchKeyPress = 0;
                                                OBJ_Action.searchChange = 0;
                                                OBJ_Action.shiftFocus = false;
                                                
                                                if (Ext.getCmp("item_name_so").getValue() === "----------------") {                                                                
                                                    
                                                    var grid = e.grid;
                                                    var rowIndex = -1;
                                                    var _data = Ext.getCmp('sale_invoice_grid').store.data;
                                                    var _items = _data.items;
                                                    for(var i=0;i<_items.length;i++){
                                                        if(_items[i].get("item_name")==""){
                                                            rowIndex = i;
                                                        }
                                                    }
                                                    if(rowIndex!==-1){
                                                        var rec = grid.getStore().getAt(rowIndex);
                                                        grid.store.remove(rec);
                                                        if (e.grid.store.getCount() > 0) {
                                                            //sm.select(0);
                                                        }
                                                    }
                                                }
                                                
                                            },
                                            'edit': function (e) {

                                                // item_store.pageSize=1000; 
                                                var qty = parseFloat(Ext.getCmp("item_quantity_so").getValue());
                                                var unit_price = parseFloat(Ext.getCmp("item_net_so").getValue());                                      
                                                var item_price_so = parseFloat(Ext.getCmp("item_price_so").getValue());                                      
                                                var item_subtotal_so = parseFloat(Ext.getCmp("item_subtotal_so").getValue());                                      
                                                var sel = e.grid.getSelectionModel().getSelection()[0];
                                                var record = item_store.getById(sel.get("item_id"));
                                                // console.log(record)
                                                var sumSubTotal=qty*unit_price;
                                                var ware_qty=0;    
                                                var ware_name='';  
                                                var other_ware='';  
                                                var conv_from=0;
                                                if(enableWarehouse==1)
                                                {
                                                       var data=record.get('item_warehouses');
                                                        for(var i=0;i<data.length;i++){

                                                            other_ware +="<li>"+data[i].warehouse_name+": "+data[i].qty+" </li>";
                                                            if(sel.get("ware_id")==data[i].ware_id){
                                                                  ware_qty=data[i].qty;  
                                                                  ware_name=data[i].warehouse_name;  
                                                            }
                                                            }

                                                }
                                                else
                                                {
                                                    if(record !=null)
                                                    {
                                                         ware_qty=record.get("qty");
                                                    }
                                                    
                                                }
                                                try{
                                                    if(record.get("type")!=="3"){       
                                                        if ( qty > parseFloat(ware_qty/sel.get("conv_from"))) {
                                                            if(enableWarehouse==1){
                                                                Ext.Msg.show({
                                                                  title: 'Stock Warning',
                                                                  msg: 'You have ' + parseFloat(ware_qty/sel.get("conv_from")).toFixed(2) + ' quantity in '+ware_name+' Warehouse for "' + Ext.getCmp("item_name_so").getValue() + '".'+
                                                                  'Do you want to continue with entered quantity?<br>'+
                                                                   'Your Other Warehouses <b>"'+Ext.getCmp("item_name_so").getValue()+'"</b> Quantity is Present in <ol>'+other_ware+'</ol> ',
                                                                  buttons: Ext.Msg.YESNO,
                                                                  icon: Ext.Msg.WARNING,
                                                                  fn: function (btn, text) {
                                                                      if (btn == 'no') {
                                                                          editModelSO.startEdit(sel, 1);
                                                                          return false;
                                                                      }
                                                                      OBJ_Action.calc.calTotalSubTotal();
                                                                      OBJ_Action.addRecord();
                                                                  }
                                                            });
                                                        } else {
                                                            Ext.Msg.show({
                                                                title: 'Stock Warning',
                                                                msg: 'You have ' + parseFloat(ware_qty/sel.get("conv_from")).toFixed(2) + ' quantity in Stock for "' + Ext.getCmp("item_name_so").getValue() + '".'+
                                                                 'Do you want to continue with entered quantity?',
                                                                buttons: Ext.Msg.YESNO,
                                                                icon: Ext.Msg.WARNING,
                                                                fn: function (btn, text) {
                                                                    if (btn == 'no') {
                                                                        editModelSO.startEdit(sel, 1);
                                                                        return false;
                                                                    }
                                                                    OBJ_Action.calc.calTotalSubTotal();
                                                                    OBJ_Action.addRecord();
                                                                }
                                                            });
                                                        }
                                                        } else if ( unit_price < parseFloat(sel.get("normal_price"))) {
                                                            Ext.Msg.show({
                                                                title: 'Price Warning',
                                                                msg: 'Net price ' + unit_price + ' is less than purchase price "' + sel.get("normal_price") + '". Do you want to continue?',
                                                                buttons: Ext.Msg.YESNO,
                                                                icon: Ext.Msg.WARNING,
                                                                fn: function (btn, text) {
                                                                    if (btn == 'no') {
                                                                        editModelSO.startEdit(sel, 1);
                                                                        return false;
                                                                    }
                                                                    OBJ_Action.calc.calTotalSubTotal();
                                                                    OBJ_Action.addRecord();
                                                                }
                                                            });   
                                                        } 
                                                        else if(item_subtotal_so<sumSubTotal)
                                                        {
                                                            Ext.Msg.show({
                                                                title: 'Calculation Warning',
                                                                msg: 'Subtotal Is Incorrect. Do you want to continue?',
                                                                buttons: Ext.Msg.YESNO,
                                                                icon: Ext.Msg.WARNING,
                                                                fn: function (btn, text) {
                                                                    if (btn == 'no') {
                                                                        editModelSO.startEdit(sel, 1);
                                                                        return false;
                                                                    }
                                                                    OBJ_Action.calc.calTotalSubTotal();
                                                                    OBJ_Action.addRecord();
                                                                }
                                                            }); 
                                                        }
                                                        else {                                                                            
                                                            OBJ_Action.calc.calTotalSubTotal();
                                                            OBJ_Action.addRecord();
                                                        }
                                                    } else {
                                                        OBJ_Action.calc.calTotalSubTotal();
                                                        OBJ_Action.addRecord();
                                                    }
                                                }
                                                catch(e){                                                                    
                                                    OBJ_Action.calc.calTotalSubTotal();
                                                    OBJ_Action.addRecord();
                                                }
                                            },
                                            'beforeedit': function (e,obj) {

                                                if(user_right==1 || user_right==3){
                                                        OBJ_Action.editRecordRow(e,obj); 
                                                    } else {
                                                    if(sale_invoice_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.edit){ 
                                                        OBJ_Action.editRecordRow(e,obj);
                                                    } else if(sale_invoice_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_return.actions.edit){ 
                                                        OBJ_Action.editRecordRow(e,obj);
                                                    } else if(sale_invoice_mode == "2" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_estimate.actions.edit){ 
                                                        OBJ_Action.editRecordRow(e,obj);
                                                    } else {
                                                        Ext.Msg.show({
                                                            title:'User Access Conformation',
                                                            msg:'You have no access to Edit this Invoice',
                                                            buttons:Ext.Msg.OK,
                                                            callback:function(btn) {
                                                                if('ok' === btn) {
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                                

                                            },
                                             validateedit: function(){
                                                if(OBJ_Action.searchKeyPress > OBJ_Action.searchChange){
                                                    return false;
                                                }

                                            }
                                        }
                                    })],
                                margin: '2 5 2 5',
                                store: {
                                    proxy: {
                                        type: "memory",
                                        reader: {
                                            type: "json"
                                        }
                                    },
                                    model: Ext.define("modelSaleInvoice", {
                                        extend: "Ext.data.Model",
                                        fields: [
                                            "item_name",
                                            "item_id",
                                            "type",
                                            "item_quantity",
                                            "bonus_quantity",
                                            "conv_from",
                                            "unit_name",
                                            "unit_id",
                                            "warehouse_name",
                                            "ware_id",
                                            "weight",
                                            "unit_price",
                                            "normal_price",
                                            "net_price",
                                            "discount",
                                            "barcode",
                                            "qty_on_hand",
                                            "discount_complete",
                                            {
                                                name: "sub_total",
                                                type: 'float',
                                                convert: function (v, rec) {
                                                    return Ext.util.Format.number(v, "0.00")
                                                }
                                            }

                                        ]
                                    }) && "modelSaleInvoice",
                                    data: []
                                },
                                listeners: {
                                    afterRender: function (obj) {
                                        //this.superclass.afterRender.call(this);
                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                            del: function (e) {
                                                OBJ_Action.calc.removeRecord('sale_invoice_grid');
                                            }
                                        });                                                                                                                                                                                                   
                                    },
                                    beforecellclick: function(){

                                        
                                        Ext.getCmp("item_name_so").focus(true);
                                        return false;
                                    },
                                    containerclick: function () {
                                        // item_store.pageSize=50;
                                        editModelSO.cancelEdit();
                                        OBJ_Action.addRecord();
                                    },

                                    itemmouseenter: function (view, record, item,index) {
                                        OBJ_Action.mouseOverRow = index;                                                                                                                                                                 
                                    }

                                },
                                columnLines: true,
                                
                                columns: [
                                    {
                                        xtype: 'actioncolumn',
                                        width: 21,
                                        iconCls:"y-action-col-icon",                                                        
                                        items: [{                                                                
                                            icon: 'themes/aursoft/images/star.png'

                                        }]
                                        
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_item,
                                        dataIndex: "item_name",
                                        flex: 1,
                                        editor: {
                                            xtype: 'combo',
                                            allowBlank: true,
                                            listConfig : {
                                                itemTpl : '<li class="item-row-li"><span> {item} </span> <strong> {barcode} </strong></li>',
                                            },
                                            queryMode: 'remote',
                                            minChars: 2,
                                            queryDelay: 100,
                                            displayField: 'item',
                                            store: item_store,
                                            triggerAction: 'all',
                                            pageSize: 50,
                                            enableKeyEvents:true,
                                            valueField: 'item',
                                            emptyText: labels_json.saleinvoicepanel.select_item_emptyText,
                                            typeAhead: true,
                                            id: 'item_name_so',
                                            listeners: {
                                                change: function (f, obj) {                                                                    
                                                    if(f.getValue()==""){
                                                        // OBJ_Action.shiftFocus = false;
                                                        OBJ_Action.searchKeyPress = 0;
                                                        OBJ_Action.searchChange = 0;                                                                        
                                                    }
                                                    else{
                                                        // OBJ_Action.shiftFocus = true;
                                                        OBJ_Action.searchChange = OBJ_Action.searchChange + 1;      
                                                    }                                                                                                                                                                                                     
                                                    var record = f.findRecordByValue(f.getValue());                                                                                                                                                
                                                    
                                                    
                                                    if(record){
                                                        Ext.getCmp("item_quantity_so").setDisabled(false);                                                                        
                                                        // Ext.getCmp("bonus_quantity_so").setDisabled(false);                                                                        
                                                        Ext.getCmp("item_price_so").setDisabled(false);
                                                        Ext.getCmp("item_discount_so").setDisabled(false);
                                                        Ext.getCmp("item_net_so").setDisabled(false);
                                                        Ext.getCmp("item_subtotal_so").setDisabled(false);
                                                        // var item_qty=record.get('qty');
                                                        // if(item_qty<0)
                                                        // {
                                                        //   Ext.select('.x-grid-cell').setStyle('background-color','#FFC1C1');
                                                        // }
                                                        if(bonusQuantity==1)
                                                        {
                                                             Ext.getCmp("bonus_quantity_so").setDisabled(false);
                                                        }
                                                         
                                                        if(enableWarehouse==1)
                                                        {
                                                             Ext.getCmp("warehouse_so").setDisabled(false);
                                                              if(RequiredWarehouse==1)
                                                        {
                                                             Ext.getCmp("warehouse_so").setValue('');
                                                        }
                                                        else{
                                                            Ext.getCmp("warehouse_so").setValue('Default Location');
                                                        }
                                                        }
                                                         var data =  record.get("item_Plevel");
                                                            temp_unit_price.removeAll();
                                                            for(var i=0;i<data.length;i++){
                                                                temp_unit_price.add(data[i]);
                                                            }    
                                                        if(enableUom==1)
                                                        {
                                                            Ext.getCmp("sale_item_uom").setDisabled(false);
                                                            var data =  record.get("item_units");
                                                            uom_store_temp.removeAll();
                                                            for(var i=0;i<data.length;i++){
                                                                uom_store_temp.add(data[i]);
                                                                if(record.get("sale_item_uom")==data[i].unit_id){
                                                    Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));

                                                    Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));
                                                    Ext.getCmp("sale_item_uom").setValue(data[i].unit_name);
                                                    
                                                    var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                    sel.set("unit_id", data[i].unit_id);
                                                    sel.set("unit_name", data[i].unit_name);
                                                    sel.set("conv_from", data[i].conv_from);
                                                    sel.set("normal_price", Ext.util.Format.number(data[i].nprice, "0.00"));
                                                                }
                                                            }
                                                        }
                                                        else{
                                                             var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                             sel.set("conv_from","1");
                                                            sel.set("normal_price", Ext.util.Format.number(record.get("nprice"), "0.00"));
                                                             Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
                                                            Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
                                                            Ext.getCmp("so_singleQty").setValue(record.get("qty"));
                                                            
                                                        }
                                                       
                                                        var adj = OBJ_Action.getAdjustedPrice(record);
                                                                        Ext.getCmp("item_discount_so").setValue(adj.discount + "%");
                                                                        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                                        sel.set("ware_id", "1");
                                                                        sel.set("type", record.get("type"));
                                                                        sel.set("item_id", record.get("id"));
                                                                        sel.set("item_weight", parseFloat(record.get("weight")));
                                                                        
                                                                        sel.set("barcode",record.get("barcode"));
                                                                        sel.set("qty_on_hand",record.get("qty"));
                                                                        sel.set("discount", parseFloat(adj.discount));
                                                                        OBJ_Action.recordChange();
                                                                        OBJ_Action.calc.calRowSubTotal();    
                                                                        
                                                                        if(OBJ_Action.shiftFocus){                                                                            
                                                                            Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);                                                                                                                                                                                                                             
                                                                         OBJ_Action.shiftFocus = false;
                                                                         OBJ_Action.searchKeyPress = 0;
                                                                         OBJ_Action.searchChange = 0;       
                                                                        }
                                                        } else{
                                                        Ext.getCmp("item_quantity_so").setDisabled(true);                                                                        
                                                        // Ext.getCmp("bonus_quantity_so").setDisabled(true);                                                                        
                                                        Ext.getCmp("item_price_so").setDisabled(true);
                                                        Ext.getCmp("item_discount_so").setDisabled(true);
                                                        Ext.getCmp("item_net_so").setDisabled(true);
                                                        Ext.getCmp("item_subtotal_so").setDisabled(true);
                                                        
                                                        if(enableUom==1)
                                                        {
                                                            Ext.getCmp("sale_item_uom").setDisabled(true);
                                                        } 
                                                         if(enableWarehouse==1)
                                                        {
                                                            Ext.getCmp("warehouse_so").setDisabled(true);
                                                        }
                                                           if(bonusQuantity==1)
                                                  {
                                                       Ext.getCmp("bonus_quantity_so").setDisabled(true);
                                                  }
                                                              var wareRequired  = Ext.getCmp('warehouse_so');
                                                            if(RequiredWarehouse == 1){
                                                                Ext.apply(wareRequired,{allowBlank:false});
                                                            }else  {
                                                                Ext.apply(wareRequired,{allowBlank:true});
                                                            }
                                                        
                                                    }
                                                    
                                                },
                                                keydown: function(obj,e,opts){                                                                    
                                                    if (e.getKey() == Ext.EventObject.TAB || e.getKey() == Ext.EventObject.ENTER) {
                                                        
                                                        OBJ_Action.shiftFocus = true; 
                                                        // item_store.pageSize=50;                                                                      
                                                    }
                                                    else{
                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchKeyPress + 1;                                                                                                                                        
                                                    }
                                                },
                                                focus: function(){                                                                  
                                                    OBJ_Action.searchKeyPress = 0;
                                                    OBJ_Action.searchChange = 0;
                                                    OBJ_Action.shiftFocus = false;
                                                    Ext.defer(function(){Ext.getCmp("item_name_so").setEditable(true)},100);
                                                   

                                                },
                                                click: function(){
                                                    OBJ_Action.shiftFocus = false;
                                                },
                                                blur:function(){
                                                    // item_store.pageSize=50;   
                                                }
                                            }
                                        }
                                    }, {
                                        header: labels_json.saleinvoicepanel.col_quantity,
                                        dataIndex: "item_quantity",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'item_quantity_so',
                                            disabled: true,
                                            maxLength: 9,
                                            allowBlank: false,
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents: true,
                                            listeners: {
                                                keyup: function () {
                                                    OBJ_Action.calc.calRowSubTotal();
                                                },
                                                blur: function () {                                                                    
                                                    OBJ_Action.calc.calRowSubTotal();
                                                },
                                               
                                                change: function (f, obj) {
                                                    if (sale_invoice_mode == "1") {
                                                        var value = parseFloat(f.getValue());
                                                        
                                                        if (value > 0) {
                                                            f.setValue(value * -1);
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    },
                                    {
                                        header: "Bonus Qty",
                                        dataIndex: "bonus_quantity",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'bonus_quantity_so',
                                            disabled: true,
                                            maxLength: 9,
                                            allowBlank: true,
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents: true,
                                            listeners: {
                                                change: function (f, obj) {
                                                    if (sale_invoice_mode == "1") {
                                                        var value = parseFloat(f.getValue());
                                                        
                                                        if (value > 0) {
                                                            f.setValue(value * -1);
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_item_uom,
                                        dataIndex: "unit_name",
                                        width: 100,                                                       
                                        editor: {
                                            xtype: 'combo',
                                            allowBlank: true,                                                            
                                            disabled: true,
                                            queryMode: 'local',
                                            id: 'sale_item_uom',
                                            displayField: 'unit_name',
                                            store: uom_store_temp,
                                            enableKeyEvents:true,
                                            valueField: 'unit_name',
                                            emptyText: 'UOM',
                                            listeners: {
                                                change: function (f, obj) {
                                                    
                                                     var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                    // console.log(sel.get('unit_price'));
                                                      // var record2 = f.findRecordByValue(f.getValue());

                                                    if(f.getValue()==""){
                                                        OBJ_Action.searchKeyPress = 0;
                                                        OBJ_Action.searchChange = 0;                                                                        
                                                    }
                                                    else{
                                                        OBJ_Action.searchChange = OBJ_Action.searchChange + 1;      
                                                    }
                                                    var record = f.findRecordByValue(f.getValue());
                                                                if(sel.get('item_id')!='')
                                                                {
                                                                          Ext.Ajax.request({
                                                            url: action_urls.unit_price_uom,
                                                            method: 'POST',
                                                            params: {
                                                                unit_id:record.get("unit_id"),
                                                                item_id:sel.get('item_id')
                                                            },
                                                            success: function (response) {
                                                                var data = Ext.JSON.decode(response.responseText);
                                                                // Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(data[0].sale_price, "0.00"));
                                                                // Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(data[0].sale_price, "0.00"));
                                                                   temp_unit_price.removeAll();
                                                            for(var i=0;i<data.length;i++){
                                                                temp_unit_price.add(data[i]);
                                                            }
          
                                                            },
                                                            failure: function () {
                                                            }
                                                                    });
                                                                }
                                                                if(enableUom==1)
                                                                {
                                                                    item_store.pageSize=1000;
                                                                    // console.log(sel)
                                                                    
                                                                      var record2 = item_store.getById(sel.get("item_id"));
                                                                      // console.log(item_store);
                                                              if(record2 !=null)
                                                              {
                                                                 var data =  record2.get("item_units");
                                                            uom_store_temp.removeAll();
                                                            for(var i=0;i<data.length;i++){
                                                                uom_store_temp.add(data[i]);
                                                                if(record.get('unit_id')==data[i].unit_id){
                                                    Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));

                                                    Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(data[i].sprice, "0.00"));
                                                    Ext.getCmp("sale_item_uom").setValue(data[i].unit_name);
                                                    
                                                    var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                    sel.set("unit_id", data[i].unit_id);
                                                    sel.set("unit_name", data[i].unit_name);
                                                    sel.set("conv_from", data[i].conv_from);
                                                    sel.set("normal_price", Ext.util.Format.number(data[i].nprice, "0.00"));
                                                                }
                                                            }
                                                        }else{
                                                            var record2 = item_store.getById(sel.get("item_id"));
                                                            
                                                            Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
                                                            Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00")); 
                                                        }  
 
                                                                }
                                                             else{
                                                                  Ext.getCmp("item_price_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00"));
                                                            Ext.getCmp("item_net_so").setValue(Ext.util.Format.number(record.get("sprice"), "0.00")); 
                                                             }
                                                           
                                                        

                                                        var p = parseFloat(Ext.getCmp("item_net_so").getValue());
                                                        // console.log(p)
                                                        var q = parseFloat(Ext.getCmp("item_quantity_so").getValue());
                                                        var d = parseFloat(Ext.getCmp("item_discount_so").getValue());
                                                        var dPrice = p - (p * d / 100);
                                                        var total = q * dPrice;
                                                        Ext.getCmp("item_subtotal_so").setValue(Ext.util.Format.number(Ext.getCmp("item_quantity_so").getValue()*record.get("sprice"), "0.00"));
                                                
                                                        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                        
                                                        sel.set("unit_id", record.get("unit_id"));
                                                        sel.set("unit_name", record.get("unit_name"));
                                                        sel.set("conv_from", record.get("conv_from"));
                                                        sel.set("normal_price", Ext.util.Format.number(record.get("nprice"), "0.00"));
                                                        OBJ_Action.recordChange();
                                                        OBJ_Action.calc.calRowSubTotal();    
                                                        if(OBJ_Action.shiftFocus){                                                                            
                                                        Ext.defer(function(){Ext.getCmp("item_quantity_so").focus(true)},100);                                                                                                                                                                                                                             
                                                        OBJ_Action.shiftFocus = false;
                                                        OBJ_Action.searchKeyPress = 0;
                                                        OBJ_Action.searchChange = 0;       

                                                        
                                                       }

                                                    
                                                  },
                                                  keydown: function(obj,e,opts){                                                                    
                                                    if (e.getKey() == Ext.EventObject.TAB || e.getKey() == Ext.EventObject.ENTER) {
                                                        // item_store.pageSize=50;
                                                        OBJ_Action.shiftFocus = true;                                                                        
                                                    }
                                                    else{
                                                        OBJ_Action.searchKeyPress = OBJ_Action.searchKeyPress + 1;                                                                                                                                        
                                                    }
                                                },
                                                focus: function(){              
                                                      item_store.pageSize=1000;
                                                         item_store.load();                                               
                                                    OBJ_Action.searchKeyPress = 0;
                                                    OBJ_Action.searchChange = 0;
                                                    OBJ_Action.shiftFocus = false;
                                                    Ext.defer(function(){Ext.getCmp("sale_item_uom").setEditable(true)},100);
                                                    
                                                    // alert()
                                                },
                                                click: function(){
                                                    // item_store.pageSize=1000;
                                                    // alert()
                                                    OBJ_Action.shiftFocus = false;
                                                }
                                            }
                                        }
                                    },
                                    {

                                    header: labels_json.saleinvoicepanel.text_warehouse,
                                     dataIndex: "warehouse_name", width: 100,
                                     editor:{
                                            xtype: 'combo',
                                             allowBlank: true,                                                            
                                            disabled: true,
                                            queryMode: 'local',
                                            id: 'warehouse_so',
                                            enableKeyEvents: true,
                                            displayField: 'warehouse_name',
                                            store: warehouse_store_all,
                                            valueField: 'warehouse_name',
                                            emptyText: 'Warehouse',
                                            value:'',
                                             listeners: {
                                                change: function (f, obj) {
                                                    var record = f.findRecordByValue(f.getValue());
                                                    if (record) {
                                                        var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];
                                                        sel.set("ware_id", record.get("id"));
                                                        OBJ_Action.recordChange();
                                                    }
                                                }
                                                
                                            }

                                     }
                                     
                                   
                                     
                                    },
                                      {

                                    header: labels_json.saleinvoicepanel.col_unit_price,
                                     dataIndex: "unit_price", width: 200,
                                     editor:{
                                            xtype: 'combo',
                                             allowBlank: true, 
                                             listConfig : {
                                                itemTpl : '<li class="item-row-li"><span> {sale_price} </span><small>{head}</small></li>',
                                            },                                                          
                                            disabled: true,
                                            queryMode: 'local',
                                            id: 'item_price_so',
                                            enableKeyEvents: true,
                                            displayField: 'sale_price',
                                            store: temp_unit_price,
                                            valueField: 'sale_price',
                                            emptyText: 'Unit Price',
                                            value:'',
                                             listeners: {
                                                 keyup: function () {
                                                    OBJ_Action.calc.calRowSubTotal();
                                                },
                                                blur: function () {                                                                    
                                                    OBJ_Action.calc.calRowSubTotal();
                                                },
                                                change: function () {                                                                    
                                                    OBJ_Action.calc.calRowSubTotal();
                                                },
                                            }


                                     }
                                     
                                   
                                     
                                    },
                                    {
                                        header: sale_invoice_mode === 1 ? labels_json.saleinvoicepanel.col_deduction : labels_json.saleinvoicepanel.col_discount,
                                        dataIndex: "discount",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'item_discount_so',
                                            allowBlank: false,
                                            disabled: true,
                                            enableKeyEvents: true,
                                            listeners: {
                                                keyup: function () {
                                                    OBJ_Action.calc.calRowSubTotal();
                                                },
                                                change:function(f){                                                                    
                                                     var sel = Ext.getCmp('sale_invoice_grid').getSelectionModel().getSelection()[0];                                                                        
                                                     sel.set("discount_complete", '');
                                                }
                                            }

                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_net_price,
                                        dataIndex: "net_price",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'item_net_so',
                                            disabled: true,
                                            allowBlank: false,
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents: true,
                                            listeners: {
                                                keyup: function () {
                                                    OBJ_Action.calc.calRowDiscount();
                                                }
                                            }
                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_sub_total,
                                        dataIndex: "sub_total",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            cls: 'grid_look',
                                            id: 'item_subtotal_so',
                                            disabled: true,
                                            readOnly: false,
                                            allowBlank: false,
                                            maskRe: /([0-9\s\.]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents: true,
                                            listeners: {
                                                keyup: function () {
                                                    OBJ_Action.calc.calcRowFromSubtotal();
                                                },
                                                change: function (f, obj) {
                                                   if (sale_invoice_mode == "1") {
                                                        var value = parseFloat(f.getValue());
                                                        if (value > 0) {
                                                            f.setValue(value * -1);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }, 
                                    {
                                        xtype: 'actioncolumn',
                                        width: 21,
                                        items: [{
                                                icon: 'themes/aursoft/images/remove_new.png',
                                                tooltip: 'Delete',
                                                
                                                handler: function (grid, rowIndex, colIndex) {
                                                    if(grid.editingPlugin.editing===false){
                                                        var rec = grid.getStore().getAt(rowIndex);
                                                        grid.store.remove(rec);
                                                        OBJ_Action.calc.calTotalSubTotal();
                                                        OBJ_Action.recordChange();
                                                    }
                                                    //alert("Terminate " + rec);
                                                }
                                            }]
                                    }

                                ]
                            }]
                    },
                    {
                        region: 'south',
                        height: 125,
                        maxHeight:125,
                        autoHeight: false,
                        id: 'bottom_frame',
                        layout: 'fit',
                        items: [
                            {
                                layout: 'border',
                                margin: '0 5 2 5',
                                border: false,
                                defaults: {
                                    border: false,
                                    bodyBoder: false
                                },
                                items: [
                                    {
                                        region: 'west',
                                        width: 550,
                                        style : 'margin: 2px 5px 3px 2px;',
                                        layout: 'fit',
                                        items: [{
                                                width: '90%',
                                                bodyPadding: 2,
                                                renderTo: Ext.getBody(),
                                                layout: {
                                                    type: 'hbox',
                                                },
                                                items: [
                                                    {
                                                        tag: "div",
                                                        id:'customer_transections',
                                                        width: 550,
                                                        html: ''
                                                    }
                                                ]
                                            }]
                                    },
                                    {
                                        region: 'east',
                                        width: 270,
                                        layout: 'fit',
                                        items: [{
                                                bodyStyle: 'border:0px;background-color:#e0e0e0',
                                                layout: {
                                                    type: 'table',
                                                    columns: 1,
                                                    tableAttrs: {
                                                        width: '100%',
                                                        style: 'margin-top:4px; margin-bottom:2px',
                                                    }
                                                },
                                                items: [
                                                    {
                                                        xtype: 'textarea',
                                                        height: 115,
                                                        width: '100%',
                                                        value:'',
                                                        name: 'so_remarks',
                                                        id: 'so_remarks',
                                                        listeners: {
                                                            blur: function (f, obj) {
                                                                var val = f.getValue();
                                                                if(Ext.getCmp("so_hidden_id").getValue()!='0'){
                                                                    Ext.Ajax.request({
                                                                        url: action_urls.save_inv_description,
                                                                        method: 'POST',
                                                                        params: {
                                                                            id: Ext.getCmp("so_hidden_id").getValue(),
                                                                            desc : val,
                                                                            table : 'pos'
                                                                        },
                                                                        success: function (response) {},
                                                                        failure: function () {
                                                                        }
                                                                    });
                                                                }
                                                                
                                                                if (val && val.substring(val.length - 1) !== ',') {
                                                                    f.setValue(val + ',');
                                                                }
                                                            },
                                                            focus:function()
                                                            {
                                                                
                                                            },
                                                            change: function () {
                                                                OBJ_Action.recordChange();
                                                            }
                                                        }
                                                    }

                                                ]
                                            }]
                                    },
    {
        region: 'east',
        width: 250,
        layout: 'fit',
        items: [
            {
                bodyStyle: 'border:0px;background-color:#e0e0e0',
                layout: {
                    type: 'table',
                    columns: 2,
                    style: 'margin-bottom: 2px;',
                    tableAttrs: {
                        width: '100%',
                        style: 'margin-bottom: 2px; margin-left:10px;',
                    }
                },
                items: [
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.total_items,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'subtotal_digit_field',
                        readOnly: true,
                        width: 120,
                        id: 'sub_item_so',
                        name: 'sub_item_so',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.total_quantities,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'subtotal_digit_field',
                        readOnly: true,
                        width: 120,
                        id: 'sub_qty_so',
                        name: 'sub_qty_so',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.total_unit_amount,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'subtotal_digit_field',
                        readOnly: true,
                        width: 120,
                        id: 'unit_price_so',
                        name: 'unit_price_so',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.total_item_discount,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'subtotal_digit_field',
                        // readOnly: true,
                        width: 120,
                        id: 'so_discount',
                        name: 'so_discount',
                        maskRe: /([0-9\s\.]+)$/,
                        regex: /[0-9]/,
                        value: '0.00'
                    }, 
                    {
                        xtype: 'button',
                        iconCls: 'info',
                        id:'toolTipId',
                        cls: 'invoice_icon',
                        // style : 'position:absolute;bottom:20%;left:40%;',
                        //style : 'margin-top:25px;',
                        // tooltip: 'Save the current sales invoice.',
                        listeners: {
                            mouseover: function (obj) {
                                OBJ_Action.invoiceTP();
                            }
                        }
                    }
                ]
            }]
    },
    {
        region: 'east',
        width: 220,
        layout: 'fit',
        items: [{
                bodyStyle: 'border-left:0px;background-color:#e0e0e0',
                layout: {
                    type: 'table',
                    columns: 2,
                    style: 'margin-bottom: 2px;',
                    tableAttrs: {
                        width: '100%',
                        style: 'margin-bottom: 2px;',
                    }
                },
                items: [
                    {
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_total,
                            cls: 'sub_total_text',
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        value: '0.00',
                        id: 'sub_total_total_so'
                    },
                    {
                        xtype: 'box',
                        hidden: true,
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_total,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        hidden: true,
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        id: 'so_total',
                        name: 'so_total',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        id: 'weightEl',
                        hidden: true,
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.col_weight,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        readOnly: true,
                        hidden: true,
                        width: 100,
                        id: '_so_weight',
                        name: 'so_weight',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        id: 'est_subtotal_text',
                        hidden: true,
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_total,
                            cls: 'sub_total_text',
                        }
                    },
                    {
                        xtype: 'textfield',
                        hidden: true,
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        id: 'est_subtotal',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        id: 'discount_field_so',
                        autoEl: {
                            tag: 'div',
                            html: sale_invoice_mode === 1 ? labels_json.saleinvoicepanel.col_deduction : labels_json.saleinvoicepanel.col_discount,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'hidden',
                        name: 'so_discount_items',
                        id: 'so_discount_items',
                        value: '0'
                    }, {
                        xtype: 'hidden',
                        name: 'so_singleQty',
                        id: 'so_singleQty',
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        id: 'so_discount_invoice',
                        name: 'so_discount_invoice',
                        width: 100,
                        readOnly: true,
                        value: '0.00',
                        maskRe: /([0-9\s\.]+)$/,
                        regex: /[0-9]/
                    },
                    {
                        xtype: 'box',
                        id: 'est_total_text',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_total,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        id: 'est_total',
                        name: 'est_total',
                        value: '0.00'
                    },
                    {
                        xtype: 'box',
                        id: 'so_paid_link',
                        autoEl: {
                            tag: 'a',
                            html: labels_json.saleinvoicepanel.text_paid,
                            cls: 'sub_total_text pay_link'
                        },
                        listeners: {
                            el: {
                                click: function (ev) {
                                    if (!OBJ_Action.getform().hasInvalidField()) {
                                        var pay_window = invoice_pay_form.down('form').getForm();
                                        if(Ext.getCmp("so_total_balance").getValue().replace('-','') != "0.00"){
                                        invoice_pay_form.show();
                                    }
                                        
                                        pay_window.findField("G_order_type").setValue('2');
                                        pay_window.findField("G_invoice_id").setValue(Ext.getCmp("so_hidden_id").getValue());
                                        pay_window.findField("G_vendor_id").setValue(Ext.getCmp("customers_combo").getValue());
                                        
                                        var remaining_total = parseFloat(Ext.getCmp("so_total").getValue()) - parseFloat(Ext.getCmp("so_payment_paid").getValue());
                                        if(sale_invoice_mode==1){
                                            remaining_total = -1 * remaining_total;
                                        }
                                        else {
                                            remaining_total =  remaining_total - parseFloat(Ext.getCmp("so_discount_invoice").getValue())
                                        }
                                        Ext.getCmp("paid_total").setValue(Ext.util.Format.number(Ext.getCmp("so_total_balance").getValue(), "0.00"));
                                        
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'textfield',
                        id: 'so_paid',
                        name: 'so_paid',
                        readOnly: true,
                        cls: 'total_digit_field ',
                        value: '0.00',                                                                        
                        maskRe: /([0-9\s\.]+)$/,
                        regex: /[0-9]/,
                        width: 100,
                        enableKeyEvents: true,
                        
                        listeners: {
                            keyup: function () {
                                OBJ_Action.calc.calcBalance();
                                OBJ_Action.recordChange();

                            },
                            change: function () {
                                try {
                                    OBJ_Action.calc.calcBalance();
                                    OBJ_Action.recordChange();
                                }
                                catch (e) {
                                }
                            },
                            focus:function(){
                                if (!OBJ_Action.getform().hasInvalidField()) {
                                    var pay_window = invoice_pay_form.down('form').getForm();
                                    
                                    
                                    if(Ext.getCmp("so_total_balance").getValue().replace('-','') != "0.00"){
                                        invoice_pay_form.show();
                                    }
                                    pay_window.findField("G_order_type").setValue('2');
                                    pay_window.findField("G_invoice_id").setValue(Ext.getCmp("so_hidden_id").getValue());
                                    
                                    var remaining_total = parseFloat(Ext.getCmp("so_total").getValue()) - parseFloat(Ext.getCmp("so_payment_paid").getValue());
                                    if(sale_invoice_mode==1){
                                        remaining_total = -1 * remaining_total;
                                    }
                                    else {
                                        remaining_total =  remaining_total - parseFloat(Ext.getCmp("so_discount_invoice").getValue())
                                    }
                                    Ext.getCmp("paid_total").setValue(Ext.util.Format.number(Ext.getCmp("so_total_balance").getValue(), "0.00"));
                                    
                                }
                            }
                        }
                    },
                    {
                        xtype: 'box',
                        id: 'so_balance_text',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_balance,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        id: 'so_total_balance',
                        name: 'so_total_balance',
                        value: '0.00'
                    },
                    {
                        id:'prev_total_balance_text',
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_pre_balance,
                            cls: 'sub_total_text'
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        value: '0.00',
                        id: 'prev_total_balance',
                        name: 'prev_total_balance'
                    },
                    {
                        xtype: 'box',
                        id:'so_grand_total_text',
                        autoEl: {
                            tag: 'div',
                            html: labels_json.saleinvoicepanel.text_grand_total,
                            cls: 'sub_total_text',
                        }
                    },
                    {
                        xtype: 'textfield',
                        cls: 'total_digit_field',
                        readOnly: true,
                        width: 100,
                        value: '0.00',
                        id: 'grand_total_balance',
                    }

                ]
            }]
    }
    
    
]
}]
                    }
                ]
            },
            {
                title: labels_json.saleinvoicepanel.tab_pick,
                layout: 'border',
                hidden: true,
                id: 'so_pick_panel',
                bodyBorder: false,
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
                                id: "pick_invoice_grid",
                                plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                        clicksToMoveEditor: 1,
                                        autoCancel: false,
                                        listeners: {
                                            'canceledit': function (e) {
                                                if (Ext.getCmp("item_rec_name_so").getValue() == "") {
                                                    var sm = e.grid.getSelectionModel();
                                                    e.grid.store.remove(sm.getSelection());
                                                    if (e.grid.store.getCount() > 0) {
                                                        sm.select(0);
                                                    }
                                                }
                                            }
                                            ,
                                            'edit': function (e) {

                                            }
                                            ,
                                            'beforeedit': function (e) {
                                                if (parseInt(Ext.getCmp("so_order_status").getValue()) === 3 || e.record.get("is_picked")) {
                                                    editModelPick.cancelEdit();
                                                    return false;
                                                }
                                            }
                                        }
                                    })],
                                margin: '5 5 2 5',
                                store: {
                                    proxy: {
                                        type: "memory",
                                        reader: {
                                            type: "json",
                                            idProperty: 'item_id'
                                        }
                                    },
                                    model: Ext.define("modelPickedInvoice", {
                                        extend: "Ext.data.Model",
                                        fields: [
                                            "item_name",
                                            "item_id",
                                            "item_quantity",
                                            "unit_name",
                                            "unit_id",
                                            "item_location",
                                            "item_location_id",
                                            {
                                                name: "date_picked",
                                                type: 'date',
                                                format: 'd-m-Y'
                                            },
                                            "is_picked"

                                        ]
                                    }) && "modelPickedInvoice",
                                    data: []
                                },
                                listeners: {
                                    afterRender: function () {
                                        //this.superclass.afterRender.call(this);
                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                            del: function (e) {

                                                OBJ_Action.calc.removeRecord('sale_invoice_grid');
                                            }
                                        });
                                    }

                                },
                                columnLines: true,
                                columns: [
                                    {
                                        header: labels_json.saleinvoicepanel.col_item,
                                        dataIndex: "item_name",
                                        flex: 1,
                                        editor: {
                                            xtype: 'combo',
                                            allowBlank: false,
                                            queryMode: 'local',
                                            displayField: 'item_name',
                                            store: so_receive_item_store,
                                            valueField: 'item_name',
                                            value: labels_json.saleinvoicepanel.select_item_emptyText,
                                            id: 'item_rec_name_so',
                                            listeners: {
                                                change: function (f, obj) {
                                                    var record = f.findRecordByValue(f.getValue());
                                                    if (record) {
                                                        Ext.getCmp("item_rec_quantity_so").setValue(record.get("item_quantity"));
                                                        var sel = Ext.getCmp('pick_invoice_grid').getSelectionModel().getSelection()[0];
                                                        sel.set("item_id", record.get("item_id"));

                                                    }
                                                }
                                            }
                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_quantity,
                                        dataIndex: "item_quantity",
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'item_rec_quantity_so',
                                            allowBlank: false,
                                            maskRe: /([0-9]+)$/,
                                            regex: /[0-9]/,
                                            enableKeyEvents: true,
                                            listeners: {
                                                keyup: function () {
                                                    OBJ_Action.calc.calRowSubTotal();
                                                }
                                            }

                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_location,
                                        dataIndex: "item_location",
                                        width: 120,
                                        editor: {
                                            xtype: 'combo',
                                            allowBlank: false,
                                            queryMode: 'local',
                                            displayField: 'warehouse_name',
                                            store: warehouse_store,
                                            valueField: 'warehouse_name',
                                            value: 'Default Location',
                                            id: 'item_rec_warehouse_location_so',
                                            listeners: {
                                                change: function (f, obj) {
                                                    var record = f.findRecordByValue(f.getValue());
                                                    if (record) {
                                                        var sel = Ext.getCmp('pick_invoice_grid').getSelectionModel().getSelection()[0];
                                                        sel.set("item_location_id", record.get("id"));
                                                        OBJ_Action.recordChange();
                                                    }
                                                }
                                            }

                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_dated_picked,
                                        dataIndex: "date_picked",
                                        width: 150,
                                        renderer: Ext.util.Format.dateRenderer('d-m-Y'),
                                        editor: {
                                            xtype: 'datefield',
                                            id: 'so_receive_date',
                                            allowBlank: false,
                                            value: new Date(),
                                            maxValue: new Date(),
                                            format: 'd-m-Y'
                                        }
                                    },
                                    {
                                        header: labels_json.saleinvoicepanel.col_picked,
                                        renderer: function (v, m, r) {
                                            var id = Ext.id();
                                            if (!r.get("is_picked")) {
                                                Ext.defer(function () {
                                                    Ext.widget('button', {
                                                        renderTo: id,
                                                        text: labels_json.saleinvoicepanel.col_picked,
                                                        cls: 'receive_btn',
                                                        width: 90,
                                                        handler: function () {
                                                            OBJ_Action.receiveItem();
                                                        }
                                                    });
                                                }, 50);
                                            }
                                            else {
                                                Ext.defer(function () {
                                                    Ext.widget('box', {
                                                        renderTo: id,
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: '',
                                                            cls: 'receive_icon'
                                                        }
                                                    });
                                                }, 50);
                                            }

                                            return Ext.String.format('<div id="{0}"></div>', id);
                                        }
                                    }
                                ]
                            }]
                    },
                    {
                        region: 'south',
                        height: 120,
                        layout: 'fit',
                        items: [{
                                layout: 'border',
                                margin: '0 5 5 5',
                                border: false,
                                defaults: {
                                    border: false,
                                    bodyBoder: false
                                },
                                items: [
                                    {
                                        region: 'west',
                                        layout: 'fit',
                                        items: [{
                                                width: 350,
                                                margin: '8 5 0 0',
                                                border: false,
                                                layout: {
                                                    type: 'table',
                                                    columns: 1,
                                                    tableAttrs: {
                                                        width: '100%'
                                                    }
                                                },
                                                items: [
                                                    {
                                                        xtype: 'button',
                                                        text: labels_json.saleinvoicepanel.button_auto_fill,
                                                        style: 'align:right;margin-top:10px;',
                                                        cls: 'big_btn',
                                                        id: 'so_autofill_rec_btn',
                                                        listeners: {
                                                            click: function () {
                                                                //fill the receive Grid 
                                                                OBJ_Action.autoFillReceive();
                                                            }
                                                        }
                                                    }
                                                ]
                                            }]
                                    },
                                    {
                                        region: 'center',
                                        layout: 'fit',
                                        height: 130,
                                        items: [{
                                                border: false,
                                                layout: {
                                                    type: 'table',
                                                    columns: 1,
                                                    tableAttrs: {
                                                        width: '100%',
                                                        style: 'float:right;margin:15px 5px 0 0px'
                                                    },
                                                    tdAttrs: {
                                                        align: 'right',
                                                        valign: 'bottom'

                                                    }
                                                },
                                                items: [{
                                                        xtype: 'button',
                                                        text: labels_json.saleinvoicepanel.button_complete,
                                                        style: 'margin-top:10px;',
                                                        id: 'so_complete_rec_btn',
                                                        cls: 'big_btn',
                                                        listeners: {
                                                            click: function () {
                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                    OBJ_Action.completeOrder();
                                                                    //OBJ_Action.saveme();
                                                                }
                                                            }
                                                        }
                                                    }
                                                ]
                                            }]
                                    },
                                    {
                                        region: 'east',
                                        width: 250,
                                        layout: 'fit',
                                        items: [{
                                                layout: {
                                                    type: 'table',
                                                    columns: 2,
                                                    tableAttrs: {
                                                        width: '100%'
                                                    }
                                                },
                                                items: [{
                                                        xtype: 'box',
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: labels_json.saleinvoicepanel.text_ordered_quantity,
                                                            cls: 'sub_total_text'
                                                        }
                                                    },
                                                    {
                                                        xtype: 'textfield',
                                                        style: 'float:right',
                                                        cls: 'total_digit_field',
                                                        readOnly: true,
                                                        width: 100,
                                                        id: 'so_total_ordered',
                                                        name: 'so_total_ordered',
                                                        value: '0.00'
                                                    },
                                                    {
                                                        xtype: 'box',
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: labels_json.saleinvoicepanel.text_picked_quantity,
                                                            cls: 'sub_total_text'
                                                        }
                                                    },
                                                    {
                                                        xtype: 'textfield',
                                                        style: 'float:right',
                                                        cls: 'total_digit_field',
                                                        readOnly: true,
                                                        width: 100,
                                                        value: '0.00',
                                                        id: 'so_total_pick'
                                                    }
                                                ]
                                            }]
                                    }
                                ]
                            }]
                    }

                ]
            },
            {
                title: labels_json.saleinvoicepanel.tab_invoice,
                layout: 'border',
                id: 'so_payment_panel',
                bodyBorder: false,
                hidden: true,
                border: false,
                defaults: {
                    border: false,
                    bodyBorder: false
                },
                items: [{
                        region: 'center',
                        layout: 'fit',
                        items: [{
                                xtype: "gridpanel",
                                id: "invoice_invoice_grid",
                                margin: '5 5 2 5',
                                store: {
                                    proxy: {
                                        type: "memory",
                                        reader: {
                                            type: "json"
                                        }
                                    },
                                    model: Ext.define("modelSalePayInvoice", {
                                        extend: "Ext.data.Model",
                                        fields: [
                                            "item_name",
                                            "item_id",
                                            "item_quantity",
                                            "unit_name",
                                            "unit_id",
                                            "warehouse_name",
                                            "ware_id",
                                            "unit_price",
                                            "discount",
                                            {
                                                name: "sub_total",
                                                type: 'float',
                                                convert: function (v, rec) {
                                                    return Ext.util.Format.number(v, "0.00")
                                                }
                                            }

                                        ]
                                    }) && "modelSalePayInvoice",
                                    data: []
                                },
                                listeners: {
                                    afterRender: function () {
                                        // this.superclass.afterRender.call(this);
                                        this.nav = new Ext.KeyNav(this.getEl(), {
                                            del: function (e) {
                                                OBJ_Action.calc.removeRecord('invoice_invoice_grid');
                                            }
                                        });
                                    }

                                },
                                columnLines: true,
                                columns: [
                                    {
                                        header: "Item",
                                        dataIndex: "item_name",
                                        flex: 1
                                    },
                                    {
                                        header: "Quantity",
                                        dataIndex: "item_quantity",
                                        width: 100
                                    },
                                    {
                                        header: "UOM",
                                        dataIndex: "unit_name",
                                        width: 100
                                    },
                                   {
                                    header: "Warehouse",
                                    dataIndex: "warehouse_name",
                                    width: 100
                                    },
                                    {
                                        header: "Unit Price",
                                        dataIndex: "unit_price",
                                        width: 100
                                    },
                                    {
                                        header: "Discount",
                                        dataIndex: "discount",
                                        width: 100
                                    },
                                    {
                                        header: "Sub-Total",
                                        dataIndex: "sub_total",
                                        width: 200
                                    }
                                ]
                            }]
                    },
                    {
                        region: 'south',
                        height: 120,
                        layout: 'fit',
                        items: [{
                                layout: 'border',
                                margin: '0 5 5 5',
                                border: false,
                                defaults: {
                                    border: false,
                                    bodyBoder: false
                                },
                                items: [{
                                        region: 'north',
                                        height: 25,
                                        id: 'payment_bar',
                                        items: [{
                                                layout: {
                                                    type: 'table',
                                                    columns: 2,
                                                    tableAttrs: {
                                                        width: '200px',
                                                        style: 'float:right'
                                                    }
                                                },
                                                items: [{
                                                        xtype: 'box',
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: 'Sub-Total',
                                                            cls: 'sub_total_text'
                                                        }
                                                    },
                                                    {
                                                        xtype: 'textfield',
                                                        style: 'float:right',
                                                        cls: 'subtotal_digit_field',
                                                        readOnly: true,
                                                        width: 100,
                                                        value: '0.00',
                                                        id: 'sub_total_payment_so'
                                                    }
                                                ]
                                            }, {
                                                xtype: 'box',
                                                autoEl: {
                                                    tag: 'a',
                                                    html: 'Payment Details',
                                                    cls: 'pay_detail_link',
                                                    hidden: true
                                                },
                                                listeners: {
                                                    el: {
                                                        click: function (ev) {
                                                            ev.preventDefault();
                                                            payment_management_win.show();
                                                            Ext.getCmp("G_payment_type").setValue("2");
                                                            Ext.getCmp("payment_invoice_id").setValue(Ext.getCmp("so_hidden_id").getValue());
                                                            Ext.Ajax.request({
                                                                url: action_urls.get_so_payments,
                                                                method: 'GET',
                                                                params: {
                                                                    so_id: Ext.getCmp("so_hidden_id").getValue()
                                                                },
                                                                success: function (response) {
                                                                    LoadingMask.hideMessage();
                                                                    var data = Ext.JSON.decode(response.responseText);
                                                                    Ext.getCmp("m_payment_grid").store.loadData(data.so_payments);
                                                                    OBJ_Action.payment_update();
                                                                },
                                                                failure: function () {
                                                                }
                                                            });
                                                            Ext.getCmp("m_invoice_total").setValue(Ext.getCmp("so_total").getValue());
                                                        }
                                                    }
                                                }
                                            }
                                        ]
                                    },
                                    {
                                        region: 'west',
                                        layout: 'fit',
                                        items: [{
                                                width: 350,
                                                margin: '2 5 0 0',
                                                border: false,
                                                layout: {
                                                    type: 'table',
                                                    columns: 1,
                                                    tableAttrs: {
                                                        width: '100%'
                                                    }
                                                },
                                                items: [{
                                                        xtype: 'button',
                                                        text: 'Paid in Full',
                                                        id: 'po_paid_btn',
                                                        cls: 'big_btn',
                                                        listeners: {
                                                            click: function () {
                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                    var pay_window = invoice_pay_form.down('form').getForm();
                                                                    if(Ext.getCmp("so_total_balance").getValue()>0){
                                                                        invoice_pay_form.show();
                                                                    }
                                                                    pay_window.findField("G_order_type").setValue('2');
                                                                    pay_window.findField("G_invoice_id").setValue(Ext.getCmp("so_hidden_id").getValue());
                                                                    
                                                                }
                                                            }
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        region: 'center',
                                        layout: 'fit',
                                        height: 120,
                                        items: [{
                                                border: false,
                                                layout: {
                                                    type: 'table',
                                                    columns: 1,
                                                    tableAttrs: {
                                                        width: '200px',
                                                        style: 'float:right;margin:5px 5px 0 0px'
                                                    },
                                                    tdAttrs: {
                                                        align: 'right',
                                                        valign: 'bottom'

                                                    }
                                                },
                                                items: [
                                                    {
                                                        xtype: 'button',
                                                        fieldLabel: 'Pay',
                                                        scale: 'large',
                                                        cls: 'big_btn',
                                                        id: 'so_paid_button',
                                                        text: 'Pay Order',
                                                        listeners: {
                                                            'click': function () {
                                                                if (!OBJ_Action.getform().hasInvalidField()) {
                                                                    var pay_window = invoice_pay_form.down('form').getForm();
                                                                    if(Ext.getCmp("so_total_balance").getValue()>0){
                                                                    invoice_pay_form.show();
                                                                    }
                                                                    pay_window.findField("G_order_type").setValue('2');
                                                                    pay_window.findField("G_invoice_id").setValue(Ext.getCmp("so_hidden_id").getValue());
                                                                }
                                                            }
                                                        }
                                                    }
                                                ]
                                            }]
                                    },
                                    {
                                        region: 'east',
                                        width: 200,
                                        layout: 'fit',
                                        items: [{
                                                layout: {
                                                    type: 'table',
                                                    columns: 2,
                                                    tableAttrs: {
                                                        width: '100%'
                                                    }
                                                },
                                                items: [{
                                                        xtype: 'box',
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: 'Total',
                                                            cls: 'sub_total_text'
                                                        }
                                                    },
                                                    {
                                                        xtype: 'textfield',
                                                        style: 'float:right',
                                                        cls: 'total_digit_field',
                                                        readOnly: true,
                                                        width: 100,
                                                        id: 'so_payment_total',
                                                        name: 'so_payment_total',
                                                        value: '0.00'
                                                    },
                                                    {
                                                        xtype: 'box',
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: 'Paid',
                                                            cls: 'sub_total_text'
                                                        }
                                                    },
                                                    {
                                                        xtype: 'textfield',
                                                        style: 'float:right',
                                                        id: 'so_payment_paid',
                                                        readOnly: true,
                                                        cls: 'sub_total_digit_field',
                                                        value: '0.00',
                                                        maskRe: /([0-9\s\.]+)$/,
                                                        regex: /[0-9]/,
                                                        width: 100,
                                                        enableKeyEvents: true,
                                                        listeners: {
                                                            keyup: function () {
                                                                OBJ_Action.calc.calcBalance();
                                                                OBJ_Action.recordChange();

                                                            },
                                                            change: function () {
                                                                try {
                                                                    OBJ_Action.calc.calcBalance();
                                                                    OBJ_Action.recordChange();
                                                                }
                                                                catch (e) {
                                                                }
                                                            }
                                                        }
                                                    },
                                                    {
                                                        xtype: 'box',
                                                        autoEl: {
                                                            tag: 'div',
                                                            html: 'Balance',
                                                            cls: 'sub_total_text'
                                                        }
                                                    },
                                                    {
                                                        xtype: 'textfield',
                                                        style: 'float:right',
                                                        cls: 'total_digit_field',
                                                        readOnly: true,
                                                        width: 100,
                                                        value: '0.00',
                                                        id: 'so_payment_total_balance'
                                                    }
                                                ]
                                            }]
                                    }
                                ]
                            }]
                    }
                ]
            }
        ]
    }
]
})
,
tbar: [
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_new,
    iconCls: 'new',
    tooltip: labels_json.saleinvoicepanel.button_new_tooltip,
    listeners: {
        click: function () {
            Ext.getCmp("so_paid").setReadOnly(false);
            Ext.getCmp("so_remove_all_item").setDisabled(false);
            if(Ext.getCmp("sale_invoice_grid").store.getCount() > 0 && Ext.getCmp("so_hidden_id").getValue() == "0"){
            OBJ_Action.makeNew({
                'save_other': OBJ_Action.saveme
            }); 
        }
        else{
            OBJ_Action.clearChanges();     
        }
                                

        }
    }
},
{
    xtype: 'button',
    tabIndex: -1,
    id:'so_create_invoice',
    text: labels_json.saleinvoicepanel.button_create_sale_invoice,                    
    disabled: true,
    iconCls:'estimateinto',
    tooltip: labels_json.saleinvoicepanel.button_create_sale_invoice,
    listeners: {
        click: function () {
            if(user_right==1){
                        sale_invoice_mode = 0;
                        OBJ_Action.setInvoiceMode(true);
               } else {
                   if(Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.edit){
                         sale_invoice_mode = 0;
                         OBJ_Action.setInvoiceMode(true);
                       } else {
                           Ext.Msg.show({
                            title:'User Access Conformation',
                            msg:'You have no access to perform this action',
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
},'-',
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_print,
    iconCls: 'print',
    tooltip: labels_json.saleinvoicepanel.button_print_tooltip,
    listeners: {
        click: function () {
            if(user_right==1 || user_right==3 ){
                OBJ_Action.printme();
            } else {
            if(sale_invoice_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.print){ 
                OBJ_Action.printme();
            } else if(sale_invoice_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_return.actions.print){ 
                OBJ_Action.printme();
            } else if(sale_invoice_mode == "2" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_estimate.actions.print){ 
                OBJ_Action.printme();
            } else {
                Ext.Msg.show({
                    title:'User Access Conformation',
                    msg:'You have no access to print this invoice',
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
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_save,
    iconCls: 'save',
    id: 'tb_btn_save',
    tooltip: labels_json.saleinvoicepanel.button_save_tooltip,
    listeners: {
        click: function () {
            
            /////////Start Code For Sending Messages ////////////
            Ext.getCmp("so_remove_all_item").setDisabled(true);
           var so_balance = Ext.util.Format.number(Ext.getCmp("so_total").getValue());
            var customer_pre_balance = Ext.util.Format.number(Ext.getCmp("prev_total_balance").getValue());
            var pay = Ext.util.Format.number(parseFloat(Ext.getCmp("so_paid").getValue()), "0.00");
            var _grand_total = +so_balance + +customer_pre_balance;
            var customer_mobile = Ext.getCmp("customer_mobile").getValue();
            var invoice_status = Ext.getCmp("so_status").getValue();

            var remaining = Ext.util.Format.number(parseFloat(_grand_total - pay), "0.00");
            var message = "Sale Inv Amount = " + so_balance + " Rs" + "\nPrev Amount = " + customer_pre_balance + " Rs" + "\nTotal Amount = " + _grand_total + " Rs" + "\nYou Paid = " + pay + " Rs" + " \nRem Bal = " + remaining + " Rs" + "\nThank you \n" + store_name;
            var user_id = Ext.getCmp("customers_combo").getValue();
            if ( navigator.onLine ) {
                if(use_message=='1' && customer_mobile!='' && invoice_status!="Completed" && user_id!="0"){
                    if(Ext.getCmp("so_send_message_cust").getValue()==true){
                        Ext.Ajax.request({
                                url             : action_urls.sendsms,
                                params:{
                                    username    : api_username,
                                    password    : api_password,
                                    from        : masking,
                                    user_id     : user_id,
                                    user_type   : 'customer',
                                    to          : customer_mobile,
                                    message     : message
                                },
                                success         : function () {},
                                failure         : function () {}
                            });
                    } 
                }
            } else {
                    var status = navigator.onLine;
                if (status) {
                      Ext.Msg.show({
                        title:'Message',
                        msg:'You have no internet Connection!',
                        buttons:Ext.Msg.OK,
                        callback:function(btn) {
                            if('ok' === btn) {
                            }
                        }
                    });
                } 
                  
           }
            OBJ_Action.saveme();
            
        }
    }
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_save_new,
    iconCls: 'save',
    id: 'tb_btn_save_new',
    tooltip: labels_json.saleinvoicepanel.button_saveandnew_tooltip,
    listeners: {
        click: function (data) {
             /////////Start Code For Sending Messages ////////////
            var myStore = Ext.getCmp('sale_invoice_grid').store;
           var so_balance = Ext.util.Format.number(Ext.getCmp("so_total").getValue());
            var customer_pre_balance = Ext.util.Format.number(Ext.getCmp("prev_total_balance").getValue());
            var pay = Ext.util.Format.number(parseFloat(Ext.getCmp("so_paid").getValue()), "0.00");
            var _grand_total = +so_balance + +customer_pre_balance;
            var customer_mobile = Ext.getCmp("customer_mobile").getValue();
            var invoice_status = Ext.getCmp("so_status").getValue();
            var remaining = Ext.util.Format.number(parseFloat(_grand_total - pay), "0.00");
            var message = "Sale Inv Amount = " + so_balance + " Rs" + "\nPrev Amount = " + customer_pre_balance + " Rs" + "\nTotal Amount = " + _grand_total + " Rs" + "\nYou Paid = " + pay + " Rs" + " \nRem Bal = " + remaining + " Rs" + "\nThank you \n" + store_name;
            
            var user_id = Ext.getCmp("customers_combo").getValue();
            if ( navigator.onLine ) {
                //alert(performance.now());
                if(use_message=='1' && customer_mobile!='' && invoice_status!="Completed" && user_id!="0"){
                        //alert(message);
                    Ext.Ajax.request({
                                url             : action_urls.sendsms,
                                params:{
                                    username    : api_username,
                                    password    : api_password,
                                    from        : masking,
                                    user_id     : user_id,
                                    user_type   : 'customer',
                                    to          : customer_mobile,
                                    message     : message
                                },
                                success         : function () {},
                                failure         : function () {}
                            }); 
                    }
                    /////////End Code For Sending Messages ////////////
            } else {
                      var status = navigator.onLine;
                if (status) {
                      Ext.Msg.show({
                        title:'Message',
                        msg:'You have no internet Connection!',
                        buttons:Ext.Msg.OK,
                        callback:function(btn) {
                            if('ok' === btn) {
                            }
                        }
                    });
                } 
                }
            /////////End Code For Sending Messages ////////////
            // OBJ_Action.saveme({
            //     makenew: OBJ_Action.saveme
               
            // });
            //
            OBJ_Action.save_new();
             // OBJ_Action.saveme();
             // var fields =Ext.getCmp("sale-invoice-panel-form").query('[isFormField][name!="cust_group_name"]');
          
              

              // OBJ_Action.clear(); 
             // for (var i = 0, len = fields.length; i < len; i++) {
             //            fields[i].reset();
             //        }
             //   myStore.load();
           // OBJ_Action.saveme();

        }

    }
}, '-',
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_load_estimate,
    id: 'load_estimates_button',
    iconCls: 'estimates', 
    tooltip : labels_json.saleinvoicepanel.button_load_estimates_tooltip,
    width: 120,                                                
    listeners: {
        click: function () {
            estimates_window.show();
        }
    }
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_save_print,
    id: 'tb_btn_save_print',
    tooltip: labels_json.saleinvoicepanel.button_save_print_tooltip,
    listeners: {
        click: function () {
            if(user_right==1 || user_right==3 ){
               OBJ_Action.saveme({ print: 1 }); 
            } else {
                if(sale_invoice_mode == "0" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_invoice.actions.print){ 
                    OBJ_Action.saveme({
                    print: 1
                });
                } else if(sale_invoice_mode == "1" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_return.actions.print){ 
                    OBJ_Action.saveme({
                    print: 1
                });
                } else if(sale_invoice_mode == "2" && Ext.decode(decodeHTML(userAccessJSON)).user_access.sale_estimate.actions.print){ 
                    OBJ_Action.saveme({
                    print: 1
                });
                } else {
                    Ext.Msg.show({
                        title:'User Access Conformation',
                        msg:'You have no access to print this invoice',
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
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_delete,
    iconCls: 'deactivate',
    id: 'delete_so_invoice',
    disabled: true,
    tooltip: labels_json.saleinvoicepanel.button_delete_tooltip,
    listeners: {
        click: function () {
            if (Ext.getCmp("so_hidden_id").getValue() != "0") {
                performAction('Delete', action_urls.delete_so_invoice, false, function (data) {
                    OBJ_Action.resetChanges();
                    OBJ_Action.makeNew();
                    OBJ_Action.previousOrderID = data.pre_order_id
                }, {
                    id: Ext.getCmp("so_hidden_id").getValue()
                });
            }
        }
    }
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_invCust,
    id: 'customize_so_invoice',
    tooltip: labels_json.saleinvoicepanel.button_invCust_text,
    listeners: {
        click: function () {
            inv_customize_form.show();
        }
    }
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_copy,
    style: 'display:none',
    iconCls: 'copy',
    id: 'tb_btn_copy',
    tooltip: labels_json.saleinvoicepanel.button_copy_tooltip,
    menu: [
        {
            text: 'Copy SO',
            tooltip: 'Copy current Sale order with same information.',
            listeners: {
                click: function () {
                    OBJ_Action.copy('so_hidden_id', 'so_id');

                }
            }


        }, {
            text: 'Copy PO',
            tooltip: 'Copy current Sale order as purchase order with same information.',
            disabled: true
        }]
},
{
    xtype: 'button',
    disabled: true,
    tabIndex: -1,
    style: 'display:none',
    iconCls: 're-open',
    id: 'tb_btn_reopen',
    tooltip: 'Re-open order will reverse all inventory moments and payment records.',
    text: 'Re-Open Order',
    listeners: {
        click: function () {

        }
    }
}, '-',
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_close,
    iconCls: 'close',
    tooltip: labels_json.saleinvoicepanel.button_close_tooltip,
    listeners: {
        click: function () {
            if(Ext.getCmp("sale_invoice_grid").store.getCount() > 0 && Ext.getCmp("so_hidden_id").getValue() == "0"){

                Ext.Msg.show({
                         title:'Close confirmation'
                        ,msg:'Are you sure you want to close the invoice?'
                        ,buttons:Ext.Msg.YESNO
                        ,callback:function(btn) {
                            if('yes' === btn) {
                                if(user_right=="3")  {
                                    window.location.href = urls.logout;
                                }
                                else{
                                    sale_invoice_return_mode = 0;
                                    // homePage();
                                     window.location.reload();
                                }
                            }
                        }
                    });
            } else {
                if(user_right=="3")  {
                    window.location.href = urls.logout;
                }
                else{
                    sale_invoice_return_mode = 0;
                     homePage();
                     //window.location.reload();
                }
            }
           return false;
        }
    }
},                
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_next,
    id: 'next_sale_order_btn',
    iconCls: 'next-order-icon',
    cls: 'next-order',
    disabled: true,
    tooltip: labels_json.saleinvoicepanel.button_next_tooltip,
    listeners: {
        click: function () {
            if (OBJ_Action.nextOrderID) {
                 Ext.getCmp("prev_total_balance").setValue("0.00");
                editItem.id = OBJ_Action.nextOrderID;
                editItem.type = "";
                OBJ_Action.editme();
                
            }
        }
    }
},
{
    xtype: 'button',
    tabIndex: -1,
    text: labels_json.saleinvoicepanel.button_previous,
    iconCls: 'previous-order-icon',
    cls: 'previous-order',
    id: 'pre_sale_order_btn',
    tooltip: labels_json.saleinvoicepanel.button_previous_tooltip,
    listeners: {
        click: function () {
            if (OBJ_Action.previousOrderID) {
                Ext.getCmp("prev_total_balance").setValue("0.00");
                editItem.id = OBJ_Action.previousOrderID;
                editItem.type = "";
                OBJ_Action.editme();
            }
        }
    }
}

]

}
]
}
)
