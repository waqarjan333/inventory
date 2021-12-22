<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
<title><?php echo $heading_title;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/ui-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/chosen.css" />
    <?php if($direction=="rtl"){ ?>    
        <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/pos-rtl.css" />
        <?php if($this->config->get('config_language')=="ar"){ ?>    
    <style>
            @font-face
            {
                font-family: AL-Mohanad;
                src: url('<?php echo $theme; ?>/stylesheet/fonts/al-mohanad-bold.ttf');
            } 
            .x-body, *{
                font-family:'AL-Mohanad',AL-Mohanad,Arial,Tahoma !important;
            }
           
    </style>
    <?php } else { ?>
        <style>
                @font-face
                {
                    font-family: nafees-nastaleeq;
                    src: url('<?php echo $theme; ?>/stylesheet/fonts/Fajer Noori Nastalique 15-12-2006.ttf');
                } 
                .x-body, *{
                    /*font-family:'nafees-nastaleeq',nafees-nastaleeq,Arial,Tahoma !important;*/
                }
        </style>
    <?php } ?>  
    <?php } else { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/pos.css" />
        
     <?php } ?>   
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/table.css" />
   <style>
        #receipt-body tr {
                border-bottom: 1px solid #D7D2D2;
                border-bottom-style: dashed;
            }
   </style>
</head>
<body>
    <div class="loading" style='display:none'><p>Creating Invoice...</p></div>
    <div class="navbar navbar-fixed-top" >
        <div class="navbar-inner">
            <div id="branding">
                <div id="aursoft_logo" class="aursoft_logo" ></div> 
                
                <div class="btn-group toolbar" >
                    <a class="btn" title="Show Invoices" id="show_list_toolbar"><i class="icon-align-justify"></i></a>
                </div>
                 <span class="username">
                       <?php echo $full_name ?>
                 </span>
            </div>
    
            <div id="rightheader">  
                <div id="order-selector">
                    <button class="neworder-button">+</button>
                    <ol id="orders" class="btn-toolbar">
                        
                    </ol>
                </div>
                <div class="header-button top_close">
                    <?php echo $button_close;?>
                </div>
                <div class="header-button today_report">
                    Today Sale
                </div>
           </div>     
           
        </div>
    </div>
    <div class="pos" style="display:none">
        <div class="row">
            <div class="span4 maincols" id="leftpane">
                <div class="order-container">
                    <div class="order-scroller" style="width: 100%;">
                        <div class="order">
                            
                            <form id="choose_form1" style="display: inline; position: absolute; top: 5px; left: 5px; z-index: 1000;">
                                <select id="customerchoosen" data-placeholder="Choose a Customer..." class="chzn-select" style="max-width: 160px; float: left;">
                                    <option value="-1">Add New Customer...</option>
                                     <?php if(isset($list_customers)){
                                        for ($count=0,$size=count($list_customers);$count<$size;$count++): ?>
                                            <?php if($list_customers[$count]['cust_status']==1) { ?>
                                                <option value="<?php echo $list_customers[$count]['cust_id']?>" <?php if($list_customers[$count]['cust_id']=='0') echo 'selected="selected"' ?> ><?php echo $list_customers[$count]['cust_name']?></option>
                                           <?php } ?> 
                                      <?php endfor; 
                                     } ?>                                           
                                </select> 
                             </form>
                            <div id="customer_name" class="customer-container" style="display:none">Sale Return</div>
                            <ul class="orderlines">
                                <li class="empty" style="margin-top:15px"> <?php echo $text_empty_cart; ?></li>                                
                            </ul>
                            <div class="summary">
                                <div class="total-invoice-calc"><i class="icon-info-sign"></i></div>
                                <div class="line empty">
                                    <div class="entry total">
                                        <span class="sale-return-total"><?php echo $text_total; ?>: </span> <span class="value" id="total_sale">0.00 Rs.</span>
                                        
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer>                                        
                    <div id="paypad">
                       <!--<button class="btn paypad-button" cash-register-id="1"><?php echo $text_cash_journal; ?></button>
                       <br/>
                       <button class="btn paypad-button" cash-register-id="2"><?php echo $text_on_account; ?></button>
                       <br/>-->
                       <div class="pos-step-container">
                        <div class="pos-payment-container" style="min-height:190px;"> 
                            <form id="choose_form1" style="display: inline; position: absolute; left: 32px; z-index: 1000;">
                            <select id="salerep_choosen" data-placeholder="Choose Sale Rep" class="chzn-select-salerep">
                                    <?php if(isset($list_salerep)){
                                        for ($count=0,$size=count($list_salerep);$count<$size;$count++): ?>
                                            <option value="<?php echo $list_salerep[$count]['salesrep_id']?>" <?php if($list_salerep[$count]['salesrep_id']=='0') echo 'selected="selected"' ?> ><?php echo $list_salerep[$count]['salesrep_name']?></option>
                                      <?php endfor; 
                                     } ?> 
                                </select>
                            </form>
                            <button class="btn paypad-button disabled" cash-register-id="1" style="margin-top:40px; margin-left: 6px;" disabled="disabled"><?php echo $text_cash_payment; ?></button>
                            <div class="last-amount-container">
                                <div class="last-amount-text"><?php echo $text_last_completed; ?></div>
                                <div class="last-amount"><?php echo $last_completed_invoice ?> Rs.</div>                                    
                            </div>
                        </div>
                    </div>                       
                    </div>
                    <div id="numpad">
                        <button class="btn input-button number-char" data-mode="1" tabindex="-1">1</button>
                        <button class="btn input-button number-char" data-mode="2" tabindex="-1">2</button>
                        <button class="btn input-button number-char" data-mode="3" tabindex="-1">3</button>
                        <button data-mode="quantity" class="btn function selected-mode" tabindex="-1"><?php echo $text_qty; ?></button>
                        <br>
                        <button class="btn input-button number-char" data-mode="4" tabindex="-1">4</button>
                        <button class="btn input-button number-char" data-mode="5" tabindex="-1">5</button>
                        <button class="btn input-button number-char" data-mode="6" tabindex="-1">6</button>
                        <button data-mode="discount" class="btn function" tabindex="-1"><?php echo $text_disc ?></button>
                        <br>
                        <button class="btn input-button number-char" data-mode="7" tabindex="-1">7</button>
                        <button class="btn input-button number-char" data-mode="8" tabindex="-1">8</button>
                        <button class="btn input-button number-char" data-mode="9" tabindex="-1">9</button>
                        <button data-mode="price" class="btn function" tabindex="-1"><?php echo $text_price; ?></button>
                        <br>
                        <button id="numpad-return" class="btn input-button" data-mode="ret"  tabindex="-1"><?php echo $text_ret; ?></button>
                        <button class="btn input-button number-char"  data-mode="0"  tabindex="-1">0</button>
                        <button class="btn input-button number-char"  data-mode="."  tabindex="-1">.</button>
                        <button id="numpad-backspace" class="btn input-button"  data-mode="del"  tabindex="-1">
                            <img width="24" height="21" src="<?php echo $theme; ?>/images/backspace.png">
                        </button>
                        <br>
                    </div>
                </footer>
            </div>
            <div class="maincols" id="rightpane">
                <div class="search_bar">
                    <a class="btn" href="#" style="padding:1px 7px" id="mode_switch">
                        <i class="icon-barcode"></i>
                    </a>
                    <form style="position:relative;display:inline-block" id="search_form_product">
                        <i class="icon-search in_field" ></i>
                        <input type="text" class="input-medium search-query" id="product-search" placeholder="<?php echo $text_search_products;?>">
                        <input type="text" class="input-medium search-query" id="product-search-list" placeholder="Select product by search...." style="width:300px;display:none">                        
                        <i class="icon-remove-sign in_field_close" id="close_search" ></i>
                    </form>
                    
                </div>
                <div id="products-screen" class="screen" style="display: block; bottom: 0px;">
                    <table class="layout-table">
                        <tr class="header-row">
                            <td class="header-cell">
                                <header>
                                   <ol class="breadcrumb pos-mode">
                                        <!--<li><div class="btn-group"><button class="btn selected-mode sale-mode">Sale Mode</button></div></li>-->                                          
                                        <li ><div class="btn-group" style=""><button class="btn return-mode" style=""><?php echo $text_sale_return ?></button></div></li>        
                                    </ol>
                                </header>
                                <header>
                                   <ol class="breadcrumb category-tray">
                                        <li class="oe-pos-categories-list" id="cat_nav_1">
                                            <a href="javascript:void(0)">
                                                <img src="<?php echo $theme; ?>/images/home_small.png" class="homeimg">
                                            </a>
                                        </li>
                                    </ol>
                                </header>
                                <div id="categories">
                                    <div class="shadow-top"></div>
                                    <ol class="category-list">
                                     
                                             
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr class="content-row">
                            <td class="content-cell">
                                <div class="content-container" id="items-container">
                                    <ol id="products-screen-ol" class="product-list">
                                                
                                     </ol>
                                </div>
                                <div class="content-container" id="search-container" style="display:none">
                                    <ol id="products-screen-ol-search" class="product-list">
                                                
                                     </ol>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div id="payment-screen" class="screen" style="display: none; bottom: 105px;">
                    
                    <header><h2><?php echo $text_paid; ?></h2></header>
                    
                </div>
                
                <div id="receipt-screen" class="screen" style="display: none; bottom: 105px;">
                     <?php  
                            $invoice_a4 ="";
                            $invoice_th ="";
                            $invoice_a4_dispaly ="";
                            $invoice_th_dispaly ="";
                            if($this->config->get('config_invoice_printer')) { 
                                $invoice_a4 ="";
                                $invoice_th ="checked='checked'";
                                $invoice_a4_dispaly ="display:none !important";
                                $invoice_th_dispaly ="display:inline-block";
                            }
                            else{
                                $invoice_a4 ="checked='checked'";
                                $invoice_th ="";
                                $invoice_a4_dispaly ="display:inline-block";
                                $invoice_th_dispaly ="display:none !important";
                            }
                     ?>
                    <header>                           
                        <ul class="nav nav-pills menus">
                            <li class="dropdown">
                              <a href="#" data-toggle="dropdown" class="dropdown-toggle menu_item"><?php echo $text_layout; ?> <b class="caret"></b></a>
                              <ul class="dropdown-menu">
                                <li class="print_settings">
                                    <a><label class="radio">
                                        <input type="radio" <?php echo $invoice_a4; ?> value="print_a4" id="option_a4" name="print_size">
                                        <?php echo $text_layout_a4; ?>
                                    </label>
                                    </a>
                                </li>
                                <li class="print_settings">
                                    <a><label class="radio">
                                        <input type="radio" <?php echo $invoice_th; ?> value="print_th" id="option_a4" name="print_size">
                                        <?php echo $text_layout_small; ?>
                                    </label>
                                     </a>    
                                </li>
                                <li class="print_settings">
                                    <a><label class="radio">
                                        <input type="radio" value="print_dot" id="option_dot" name="print_size">
                                        <?php echo $text_layout_dotmatrix; ?>
                                    </label>
                                     </a>    
                                </li>
                              </ul>
                            </li>
                          </ul>
                        <h2 style="display:inline-block"><?php echo $text_receipt; ?></h2>
                    </header>
                    <div class="pos-scroll-bar">
                    <div class="pos-step-container">
                        <div class="pos-receipt-container">
                            
                           <div class="pos-sale-ticket" style="<?php echo $invoice_th_dispaly; ?>">
                               
                               <div class="invoice-title"><?php echo $this->config->get('config_receipt_title'); ?></div>
                               <div class="pos-right-align" id="inv_header"></div>                               
                               <table cellpadding="0" cellspacing="0" <?php if(substr_count($site_logo, 'aursoft_logo_size')==1){ ?> class="hideimage" <?php } ?> >
                                   <tr>
                                       <td>
                                           <div class="company_info" >
                                            <img src="<?php echo $site_logo; ?>" class="invoice-logo" style="width:40px;height:50px"/>                                  
                                            <b><?php echo $this->config->get('config_owner') ?></b><br/>
                                            <div class="address-area"><?php echo $this->config->get('config_address') ?></div>
                                            <b><?php echo $text_contact; ?>: </b><?php echo $this->config->get('config_telephone') ?><br/>
                                            <?php echo $text_user; ?>:  <?php echo $full_name ?><br>
                                            </div>
                                       </td>
                                       <td valign="bottom">
                                           <div class="invoice-dates">
                                                <b><?php echo $text_dated; ?>:</b> <span class="invoice-date"></span><br/>
                                                <b><?php echo $text_print; ?>:</b> <span class="print-invoice-date" style="margin-left: 7px;"></span>
                                           </div>
                                       </td>   
                                   </tr>
                               </table>
                               
                               
                                <table class="inv-heading border-bottom">
                                    <tr >
                                        <td class="td-description">
                                            <?php echo $text_inv_des; ?>
                                        </td>
                                        <td class="pos-center-align qty-head">
                                            <?php echo $text_inv_qty; ?>
                                        </td>    
                                        <td class="pos-center-align pad1">
                                            <?php echo $text_inv_rate; ?>
                                        </td>
                                        <td class="pos-center-align"><?php echo $text_inv_amount; ?></td>
                                    </tr>
                                </table>
                                <table class="border-bottom">                                  
                                    <tbody id="receipt-body"></tbody></table>
                                <table class="border-bottom bottom-total">
                                    <tr >
                                        <td class="td-description item_discounts">
                                            &nbsp;
                                        </td>
                                        <input type="hidden" class="tot_discount" value="">
                                        <td class="pos-center-align sub_total_qty">
                                            &nbsp;
                                        </td>    
                                        <td class="rate_qty_total">
                                            &nbsp;
                                        </td>
                                        <td class="bottom-spacer">&nbsp;</td>
                                    </tr>
                                </table>    
                                
                                <table>
                                    <tbody>
                                        <!--<tr class="total-qty"><td class="align-right"><?php echo $text_inv_totalqty; ?>:</td><td class="pos-right-align sub_total_qty">
                                       
                                        </td></tr>-->
                                        <tr><td class="align-right"><?php echo $text_inv_subtotal; ?> <span class="discount-explain"></span>:</td><td class="pos-right-align" id="sub_total_recpt">
                                       
                                        </td></tr>
                                   
                                    <tr><td class="align-right invoice-discount-deduction"><?php echo $text_discount_invoice; ?>:</td><td class="pos-right-align discount">
                                        <span class="deduction_invoice"> Rs.
                                        </td></tr>
                                    <tr class="emph"><td class="align-right"><?php echo $text_total; ?>:</td><td class="pos-right-align" id="total_recpt">
                                        0 Rs.
                                        </td>
                                    </tr>
                                    <tr class="cash-fields"><td class="align-right" style="padding-top:5px"><?php echo $text_cash; ?>:</td><td class="pos-right-align" style="padding-top:5px" id="total_cash">
                                        0 Rs.
                                        </td>
                                    </tr>
                                    <tr class="cash-fields"><td class="align-right"><?php echo $text_change; ?>:</td><td class="pos-right-align" id="total_change">
                                        0 Rs.
                                        </td>
                                    </tr>
                                    <tr class="emph" id="print_paid"><td class="align-right"><?php echo $text_paid; ?>:</td><td class="pos-right-align" id="total_paid_print">
                                        0.00 Rs.
                                        </td></tr>
                                    <tr class="emph" id="print_remining"><td class="align-right"><?php echo $text_remaining; ?>:</td><td class="pos-right-align" id="total_remaining_print">
                                        0.00 Rs.
                                        </td></tr>
                                </tbody></table>
                                <!--<br>
                                <table>
                                    <tbody><tr>
                                        <td class="align-right">
                                            <?php echo $text_cash_journal; ?>
                                        </td>
                                        <td class="pos-right-align" id="journal_total_recpt">
                                            
                                        </td>
                                    </tr>
                                </tbody></table>-->                                
                                <table>
                                    <tbody><!--<tr><td class="align-right"><?php echo $text_change; ?>:</td><td class="pos-right-align" id="change-cash">
                                        0.00 Rs.
                                        </td></tr>-->
                                        <tr><td colspan="2">
                                                <div class="thank_message">
                                                <span id="money_saved"></span>    
                                                <?php echo $this->config->get('config_thanks_note'); ?><br/>                                                
                                                <div class="aursoft_marekting">
                                                    <?php echo $text_aursoft_footer; ?>
                                                </div>
                                                </div>
                                                <?php if(!empty($pos_policy)){ ?>
                                                <div class="pos_policy">
                                                    <?php echo html_entity_decode($pos_policy); ?>
                                                </div>
                                                <?php } ?>
                                            </td></tr>
                                </tbody>
                                </table>
                        </div>
                        
                         <div class="pos-large-ticket" style="<?php echo $invoice_a4_dispaly; ?>">  
                                <div class="inv-header">
                                    <div class="headbar logo"><img src="<?php echo $site_logo; ?>" class="invoice-logo" /><?php echo $this->config->get('config_owner') ?></div>
                                    <div class="headbar inv-head"><?php echo $text_invoice; ?></div>
                                </div>
                                <div style="clear:both">
                                    <table class="header-table">
                                        <tr>
                                            <td width="180px">
                                                <div class="block">
                                                    <b><?php echo $this->config->get('config_address') ?></b><br/>
                                                    <b><?php echo $text_contact; ?>: </b><?php echo $this->config->get('config_telephone') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="block bottom-space dates-div">
                                                    <b><?php echo $text_invoice_date; ?>:</b> <span class="invoice-date"></span><br/>
                                                    <b><?php echo $text_print_date; ?>:</b> <span class="print-invoice-date"></span>
                                                </div>
                                                <div class="block bottom-space">
                                                    <b><?php echo $text_invoice; ?> #:</b> <span class="invoice-no"></span>
                                                </div>
                                                <div class="block bottom-space">
                                                    <b><?php echo $text_billto; ?>:</b> <span class="bill_to"></span>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    </table> 
                                </div>
                                <div class="invoice-body">
                                     <table class="inv-heading">
                                         <thead>
                                        <tr>                                            
                                            <th class="td-description">
                                                <?php echo $text_inv_des; ?>
                                            </th>                                            
                                             <th class="td-qty">
                                               <?php echo $text_inv_qty; ?>
                                            </th>   
                                            <th class="td-rate">
                                                <?php echo $text_inv_rate; ?>
                                            </th>
                                            <th class="td-amount"><?php echo $text_inv_amount; ?></th>
                                        </tr>                                    
                                        </thead>
                                        <tbody class="receipt-large-body"></tbody>
                                     </table>
                                    <br/>
                                    <table align="right" class="total_table">
                                        <tbody>
                                            <tr>
                                               <td><?php echo $text_inv_totalqty; ?>:</td><td class="pos-right-align sub_total_qty" ></td>
                                            </tr>
                                            <tr>
                                               <td><?php echo $text_inv_subtotal; ?>:</td><td class="pos-right-align total_large_recpt"></td>
                                            </tr>
                                            <tr><td><?php echo $text_discount; ?>:</td><td class="pos-right-align discount">
                                                0.00 Rs.
                                            </td></tr>
                                            <tr class="emph"><td><?php echo $text_total; ?>:</td><td class="pos-right-align total_recpt_large" >
                                                0.00 Rs.
                                            </td></tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          
                          
                            <div class="pos-large-ticket dot-matrix" style="display:none !important">  
                                <div class="inv-header">
                                    <div class="headbar logo"><img src="<?php echo $site_logo; ?>" class="invoice-logo" /><?php echo $this->config->get('config_owner') ?></div>
                                    <div class="headbar inv-head"><?php echo $text_invoice; ?></div>
                                </div>
                                <div style="clear:both">
                                    <table class="header-table">
                                        <tr>
                                            <td width="180px">
                                                <div class="block">
                                                    <b><?php echo $this->config->get('config_address') ?></b> <br/>
                                                    <b><?php echo $text_contact; ?>: </b><?php echo $this->config->get('config_telephone') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="block bottom-space dates-div">
                                                    <b><?php echo $text_invoice_date; ?>:</b> <span class="invoice-date"></span><br/>
                                                    <b><?php echo $text_print_date; ?>:</b> <span class="print-invoice-date"></span>
                                                </div>
                                                <div class="block bottom-space">
                                                    <b><?php echo $text_invoice; ?> #:</b> <span class="invoice-no"></span>
                                                </div>
                                                <div class="block bottom-space">
                                                    <b><?php echo $text_billto; ?>:</b> <span class="bill_to"></span>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    </table> 
                                </div>
                                <div class="invoice-body">
                                     <table class="inv-heading">
                                         <thead>
                                        <tr>                                            
                                            <th class="td-description">
                                                <?php echo $text_inv_des; ?>
                                            </th>                                            
                                             <th class="td-qty">
                                                <?php echo $text_inv_qty; ?>
                                            </th>   
                                            <th class="td-rate">
                                                <?php echo $text_inv_rate; ?>
                                            </th>
                                            <th class="td-amount"><?php echo $text_inv_amount; ?></th>
                                        </tr>                                    
                                        </thead>
                                        <tbody class="receipt-large-body"></tbody>
                                     </table>
                                    <br/>
                                    <table align="right" class="total_table">
                                        <tbody>
                                            <tr>
                                               <td><?php echo $text_inv_totalqty; ?>:</td><td class="pos-right-align sub_total_qty" ></td>
                                            </tr>
                                            <tr>
                                               <td><?php echo $text_inv_subtotal; ?>:</td><td class="pos-right-align total_large_recpt" ></td>
                                            </tr>
                                            <tr><td><?php echo $text_discount; ?>:</td><td class="pos-right-align discount">
                                                0.00 Rs.
                                            </td></tr>
                                            <tr class="emph"><td><?php echo $text_total; ?>:</td><td class="pos-right-align total_recpt_large">
                                                0.00 Rs.
                                            </td></tr>
                                            
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                      </div>
                    </div>
                   </div>  
                   
                </div>
                
                <div id="welcome-screen" class="welcome-screen screen" style="display: none;">
                    <header>
                        <ol class="breadcrumb pos-mode">
                                        <!--<li><div class="btn-group"><button class="btn selected-mode sale-mode">Sale Mode</button></div></li>-->                                          
                                        <li ><div class="btn-group" style=""><button class="btn return-mode" style=""><?php echo $text_sale_return ?></button></div></li>        
                                    </ol>
                                </header>
                        <h2><?php echo $text_welcome; ?></h2>
                    </header>
                    <div class="dialog">
                        <img src="<?php echo $theme; ?>/images/scan.png">
                        <p> <input type="text" class="input-xlarge" id="barcode-textfield"/> </p>
                        <p> <?php echo $text_scan_item; ?></p>
                    </div>
                </div>
                
                <div id="onaccount-screen" class="onaccount-screen screen" style="display: none;">
                    <header>
                        <h2><?php echo $text_on_account; ?></h2>
                    </header>
                    <div class="dialog">
                            <table>
                            <tbody><tr>
                                <td>
                                    <div class="account-title">
                                        <?php echo $text_select_customer; ?>
                                    </div>
                                </td>
                                <td class="pos-right-align">
                                      
                                </td>
                            </tr>
                                 <tr>
                                <td class="account-title" colspan="2">
                                    <?php echo $text_address; ?>:
                                </td>
                            </tr>
                             <tr>
                                <td colspan="2">
                                  <textarea id="customer_address" class="input-xlarge" rows="3" style="width: 455px; height: 132px;"></textarea>
                                </td>
                            </tr>
                           
                        </tbody></table>
                    </div>
                </div>
                
                <div class="goodbye-message" style="display: none;">
                    <p><?php echo $text_thanks_note; ?></p>
                </div>
                
                <div class="pos-actionbar" style="display: none;">
                    <ul class="pos-actionbar-button-list">
                        <li class="button payment" id="backtocategory">
                            <div class="icon">
                                <div class="image back"></div>
                                <div class="iconlabel"><?php echo $text_back; ?></div>
                            </div>
                            
                        </li>
                        <!--<li class="button selected payment disabled " id="validate_payment">
                            <div class="icon">
                                <img src="<?php echo $theme; ?>/images/validate.png">
                                <div class="iconlabel"><?php echo $text_validate; ?></div>
                            </div>
                        </li>-->                        
                        <li class="button print" id="receipt-print">
                            <div class="icon">
                                <img src="<?php echo $theme; ?>/images/printer.png">
                                <div class="iconlabel"><?php echo $button_print; ?></div>
                            </div>
                        </li>
                        <li class="button print" id="receipt-print-next">
                            <div class="icon">
                                <img src="<?php echo $theme; ?>/images/printer-next.png">
                                <div class="iconlabel"><?php echo $button_print_next; ?></div>
                            </div>
                        </li>
                        <li class="button selected print" id="next-order">
                            <div class="icon">
                                <div class="image next"></div>
                                <div class="iconlabel"><?php echo $text_next_order; ?></div>
                            </div>
                        </li>
                        <li class="button print cancel-order" style="float:right">
                            <div class="icon">
                                <img src="<?php echo $theme; ?>/images/cancel.png">
                                <div class="iconlabel"><?php echo $button_cancel; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>    

        <input type="hidden" id="customer_id" name="customer_id" value="0" />
        <input type="hidden" id="customer_details" name="customer_details" />
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script> 
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.cookie.js"></script> 
    <script>
        var isDisplayPole = false;
        var urls = {
            home:"<?php echo $url_dashboard; ?>",
            logout:"<?php echo $url_logout; ?>",
            details:"<?php echo $url_getdetails; ?>",
            search:"<?php echo $url_search; ?>",
            scan_item:"<?php echo $url_scan_item; ?>",
            get_all_items:"<?php echo $url_get_items; ?>",
            search_items:"<?php echo $url_search_items; ?>",
            get_customer:"<?php echo $url_get_customer; ?>",
            save_invoice:"<?php echo $url_save_invoice; ?>",
            list_invoices:"<?php echo $url_invoices_list; ?>",
            get_invoice_detail : "<?php echo $url_invoice_details ?>",
            delete_item_invoice : "<?php echo $url_del_item_invoice ?>",
            delete_invoice : "<?php echo $url_del_invoice ?>",
            display_total : "<?php echo $url_display_total ?>",
            set_item_order: "<?php echo $url_set_item_order ?>",
            fetch_list_invoice:"<?php echo $url_fetch_invoice_list ?>",
            save_item: "<?php echo $url_save_item ?>",
            save_customer: "<?php echo $url_save_customer ?>",
            reset_pos: "<?php echo $url_reset_pos ?>",
            getTodaySale: "<?php echo $url_getTodaySale ?>"
           
        }
        var _labels = {
                "empty_cart": "<?php echo $text_empty_cart; ?>",
                "text_units":"<?php echo $text_units; ?>",
                "text_at":"<?php echo $text_at; ?>",
                "text_a":"<?php echo $text_a; ?>",
                "text_with":"<?php echo $text_with; ?>",
                "text_discount":"<?php echo $text_discount; ?>",
                "text_deduction":"<?php echo $text_deduction; ?>",
                "text_discount_in":"<?php echo $text_discount_in; ?>",
                "text_deduction_in":"<?php echo $text_deduction_in; ?>",
                "text_invoice" : "<?php echo $text_invoice; ?>",
                "text_rename":"<?php echo $text_menu_rename; ?>",
                "text_delete":"<?php echo $text_menu_delete; ?>",
                "text_hold" : "<?php echo $text_menu_hold; ?>",
                "text_close" : "<?php echo $text_close; ?>",
                "text_untitled": "<?php echo $text_untitled; ?>",
                "empty_return":"<?php echo $text_empty_return; ?>",
                "text_sale_return":"<?php echo  $text_sale_return ?>",
                "text_total":"<?php echo $text_total; ?>"
       }
        var categories = <?php echo $categories ?>;
        var INVOICE_NO=1;//"<?php echo $invoice_no ?>";
        var isPOSUser = "<?php echo $user_type ?>";
    </script>
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/app/pos.js"></script>
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/bootstrap.js"></script>    
    <script type="text/javascript" language="javascript" src="<?php echo $theme; ?>/javascript/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/typeahead.js"></script>    
    
    <!--Invoice Name Modal -->
    <div id="invoice_modal" class="modal hide fade">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3><?php echo $text_invoice_name ?></h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12">
                    <input type="text" value="" class="input_dialog"  name="total" id="new_invoice_name" style="width:80%;margin:auto 0px;" />
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" id="invoice_btn"><?php echo $text_new_invoice ?></a>
            <a href="#" class="btn" data-dismiss="modal" ><?php echo $text_close; ?></a>            
        </div>
    </div>

        <div id="report_modal" class="modal hide fade">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3>Today Report</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span10">
                     <label for="">Today's Sale</label>
                     <input type="text" readonly id="tod_sales" value="" style="width:50%;margin:auto 0px;font-weight: bold;color: darkred;font-size: 17px;">

                     <label for="">Today's Discount</label>
                     <input type="text" readonly id="tod_discount" value="" style="width:50%;margin:auto 0px;font-weight: bold;color: darkred;font-size: 17px;">
                     
                     <label for="">Today's Return</label>
                     <input type="text" readonly id="tod_return" value="" style="width:50%;margin:auto 0px;font-weight: bold;color: darkred;font-size: 17px;">

                     <label for="">Today's Deduction</label>
                     <input type="text" readonly id="tod_deduction" value="" style="width:50%;margin:auto 0px;font-weight: bold;color: darkred;font-size: 17px;">
                     <label for="">Today's Paid Amount</label>
                     <input type="text" readonly id="tod_paid" value="" style="width:50%;margin:auto 0px;font-weight: bold;color: darkred;font-size: 17px;">
                     <label for="">Today's Unpaid Amount</label>
                    <input type="text" readonly id="tod_unpaid" value="" style="width:50%;margin:auto 0px;font-weight: bold;color: darkred;font-size: 17px;">
                </div>

            </div>            
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal" >Close</a>            
        </div>
    </div>
    
    <div id="return_modal" class="modal hide fade">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3>Return order</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12">
                    <input type="text" class="input_dialog"  name="total" placeholder="Order No..." id="return_invoice_id" style="width:80%;margin:auto 0px;" />
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" id="validate_btn">Validate</a>
            <a href="#" class="btn" data-dismiss="modal" ><?php echo $text_close; ?></a>            
        </div>
    </div>
    
    <div id="new_customer_modal" class="modal hide fade">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3><?php echo $new_customer_add ?></h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12">
                    <input type="text" class="input_dialog"  name="new_customer" placeholder="<?php echo $plcholder_customer_name ?>" id="new_customer_name" style="width:80%;margin-left:0px;" />
                </div>
                <div class="span12" style="margin-left:0px;">
                    <input type="text" class="input_dialog"  name="new_customer_obalance" placeholder="<?php echo $plcholder_customer_obalance ?>" id="new_customer_obalance" style="width:80%;margin-left:0px;" />
                </div>
                <div class="span12" style="margin-left:0px;">
                    <select id="groupchoosen" data-placeholder="Choose a Group..." class="chzn-select-group" style="margin-left:0px;">
                        <?php if(isset($list_group)){
                                for ($count=0,$size=count($list_group);$count<$size;$count++): ?>
                                    <option value="<?php echo $list_group[$count]['group_id']?>" ><?php echo $list_group[$count]['group_name']?></option>
                                <?php endfor; } ?>                                           
                    </select>
                </div>
                <div class="span12" style="margin-left:0px;">
                    <input type="text" class="input_dialog"  name="new_customer_phone" placeholder="<?php echo $plcholder_customer_phone ?>" id="new_customer_phone" style="width:80%;margin-left:0px;" />
                </div>
                <div class="span12" style="margin-left:0px;">
                    <input type="text" class="input_dialog"  name="new_customer_mobile" placeholder="<?php echo $plcholder_customer_mobile ?>" id="new_customer_mobile" style="width:80%;margin-left:0px;" />
                </div>
                <div class="span12" style="margin-left:0px;">
                    <textarea style="width:80%;" id="new_customer_address"></textarea>
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" id="save_customer_btn"><?php echo $button_save ?></a>
            <a href="#" class="btn" data-dismiss="modal" ><?php echo $text_close; ?></a>            
        </div>
    </div>
    
    <div id="invoies_list_modal" class="modal hide fade" style="width:900px;left:40%;">
         <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3><?php echo $text_load_invoices ?></h3>
        </div>
        <div class="modal-body">                    
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="invoice_list_table">
            <thead>
                <tr>
                    <th width="20px"></th>  
                    <th width="20px">No.</th>  
                    <th width="150px"><?php echo $col_name ?></th>
                    <th width="220px"><?php echo $col_customer ?></th>
                    <th width="100px"><?php echo $col_status ?></th>
                    <th width="100px"><?php echo $col_amount ?></th>
                    <th width="120px"><?php echo $col_date ?></th>    
                </tr>
            </thead>            
        </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" id="load_invoice_btn" ><?php echo $button_load ?></a>
            <a href="#" class="btn" data-dismiss="modal" ><?php echo $text_close; ?></a>            
        </div>
    </div>
    <div id="new_item_modal" class="modal hide fade" style="width:500px;left:52%;">
         <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3><?php echo $new_item_add ?></h3>
        </div>
        <div class="modal-body">                                
            <div>
                <form action="#">
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="itemname"><?php echo $label_item_name ?></label>
                            <input type="text" class="form-control" id="newitem-itemname" placeholder="<?php echo $plcholder_item_name ?>">
                        </div>
                        <div class="span6">
                            <label for="category"><?php echo $label_item_category ?></label>
                            <select placeholder="<?php echo $plcholder_item_category ?>" id="newitem-category">
                                <option>Category</option>
                            </select>
                        </div>                            
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="qty_on_hand"><?php echo $label_item_qty_on_hand ?> </label>
                            <input type="text" class="form-control" id="newitem-qty_on_hand" placeholder="<?php echo $plcholder_qty_on_hand ?>" maxlength="9">
                        </div>
                        <div class="span6">
                            <label for="barcode"><?php echo $label_item_bar_code ?></label>
                            <input type="text" class="form-control" id="newitem-barcode" placeholder="<?php echo $plcholder_barcode ?>">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <label for="purchaseprice"><?php echo $label_item_purchase_price ?></label>
                            <input type="text" class="form-control" id="newitem-purchaseprice" placeholder="<?php echo $plcholder_purchase_price ?>" maxlength="9">
                        </div>
                        <div class="span6">
                            <label for="saleprice"><?php echo $label_item_sale_price ?> </label>
                            <input type="text" class="form-control" id="newitem-saleprice" placeholder="<?php echo $plcholder_sale_price ?>" maxlength="9">
                        </div>                        
                    </div>
                </form>
            </div>            
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-info" id="add_item_btn" ><?php echo $button_save ?></a>
            <a href="#" class="btn" data-dismiss="modal" ><?php echo $text_close; ?></a>            
        </div>
    </div>
    <div id="payment_modal" class="modal hide fade" style="width:455px;left:54%;">
         <div class="modal-header">
          <a class="close" data-dismiss="modal" >&times;</a>
          <h3><?php echo $title_payment ?></h3>
        </div>
        <div class="modal-body">   
            <div class="pos-payment-container">
            <table id="paymentlines" width="420px" align="center">
                <tbody>
                    <tr class="paymentline">
                        <td class="paymentline-type" width="120px"> <?php echo $text_cash_journal; ?> :  </td>
                        <td class="paymentline-amount pos-right-align">
                            <input type="text" value="0.00" class="cash-paid" style="width:88% !important;" readonly="readonly">
                        </td>
                    </tr>
                    <tr class="paymentline">  
                        <td>
                             <b><?php echo $text_pay_method; ?> :  </b>
                        </td>
                        <td class="paymentline-method pos-right-align">
                             <select id="methodchoosen" data-placeholder="Choose a Payment type..." class="" style="width:93% !important;">                                    
                                    <?php if(isset($methods)){
                                       for ($count=0,$size=count($methods);$count<$size;$count++): ?>
                                       <option value="<?php echo $methods[$count]['acc_id']?>"> <?php echo $methods[$count]['acc_name'] ?></option>
                                     <?php endfor; 
                                    } ?>                                           
                               </select>   
                        </td>
                    </tr>
                    <tr class="paymentline ">                                        
                        <td class="paymentline-type">
                            <b class="discount_text"><?php echo $text_discount; ?> :  </b>
                        </td>
                        <td class="paymentline-amount pos-right-align double-input">
                             <div class="input-append">
                                <input class="input-mini" placeholder="<?php echo $text_discount_in; ?>" id="payment-discount" type="text"><span class="add-on">Rs.</span>
                              </div>
                              <div class="input-append">
                                <input class="input-mini" placeholder="<?php echo $text_discount_in; ?>" id="payment-discount_discount" size="10" type="text"><span class="add-on">%</span>
                              </div>                            
                        </td>
                    </tr>
                    <tr class="paymentline muted-row grand-total-row" style="display:none;padding-bottom: 5px">                                        
                        <td class="paymentline-type">
                            <b><?php echo $text_total_after_discount; ?>:</b>
                        </td>
                        <td class="paymentline-amount pos-right-align">
                            <span id="payment-discount-total" class="right-block">0.00 Rs.</span>
                        </td>
                    </tr>
                    <tr class="paymentline payment-received-row">                                        
                        <td class="paymentline-type">
                            <b  class="received_text"><?php echo $text_received; ?> :  </b>
                        </td>
                        <td class="paymentline-amount pos-right-align">
                            <input type="text" value="0.00" class="cash-received" style="width:88% !important;" tabindex="1">
                        </td>
                    </tr>
                    
                    <tr class="paymentline payment-tendered-row payment-tendered">                                        
                        <td class="paymentline-type">
                            <b  class="tendered_text"><?php echo $text_tendered; ?> :  </b>
                        </td>
                        <td class="paymentline-amount pos-right-align">
                            <input type="text" value="0.00" class="cash-tendered" style="width:88% !important;" tabindex="1" >
                        </td>
                    </tr>                    
                    <tr class="paymentline change-row payment-tendered" >                                        
                        <td class="paymentline-type">
                            <b><?php echo $text_change; ?> :  </b>
                        </td>
                        <td class="paymentline-amount pos-right-align">
                            <span id="payment-change" class="right-block">0.00 Rs.</span>
                        </td>
                    </tr>
                    
                    <tr class="paymentline muted-row" style="display:none">                                        
                        <td class="paymentline-type">
                            <b><?php echo $text_paid; ?> :  </b>
                        </td>
                        <td class="paymentline-amount pos-right-align">
                            <span id="payment-paid-total" class="right-block">0.00 Rs.</span>
                        </td>
                    </tr>
                    
                    <tr class="paymentline muted-row grand-total-row" style="display:none;padding-bottom: 5px">                                        
                        <td class="paymentline-type">
                            <b><?php echo $text_remaining; ?> :  </b>
                        </td>
                        <td class="paymentline-amount pos-right-align">
                            <span id="payment-remaining" class="right-block">0.00 Rs.</span>
                        </td>
                    </tr>                    
                    

                </tbody>
            </table>
            </div>
                
                <!--<button class="btn paypad-button" id="validate_payment" tabindex="-1"><?php echo $text_validate; ?></button>-->
            
        </div>    
        <div class="modal-footer">
            <a class="btn btn-info" id="validate_payment" ><?php echo $button_pay ?></a>
            <a class="btn" data-dismiss="modal" ><?php echo $text_close; ?></a>            
        </div>
    </div>
    
    <div class="popover right" >
      <div class="arrow"></div>
      <h3 class="popover-title"><?php echo $text_invoice_margin ?></h3>
      <div class="popover-content">
          <div>Purchase Cost: 0</div>
          <div>Total Sales: 0</div>
          <div>Total Profit: 0</div>
      </div>
    </div>   
        
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/chosen.jquery.js"></script> 
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/scannerdetection.js"></script> 
</body>
</html>