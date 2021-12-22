 <?php echo $header; ?>
 <style>
ul {
  list-style-type: none;
}

li {
  display: inline-block;
}

input[type="checkbox"][id^="label_design"] {
  display: none;
}

label {
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked + label {
  border-color: #ddd;
}

:checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

:checked + label img {
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;
}
 </style>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    <?php if ($error_warning) { ?>
                    <div class="message warning"><?php echo $error_warning; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                    <div class="message success"><?php echo $success; ?></div>
                    <?php } ?>
    <div id="tabs" class="htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_site"><?php echo $tab_site; ?></a><a tab="#tab_local"><?php echo $tab_local; ?></a><a tab="#tab_option"><?php echo $tab_option; ?></a><a tab="#tab_image"><?php echo $tab_image; ?></a><a tab="#tab_mail"><?php echo $tab_mail; ?></a><a tab="#tab_server"><?php echo $tab_server; ?></a><a tab="#tab_other"><?php echo $tab_other; ?></a><a tab="#tab_message"><?php echo $tab_message; ?></a><a tab="#tab_userKey"><?php echo $barcode_label; ?></a></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab_general">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input type="text" name="config_name" value="<?php echo $config_name; ?>" />
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_url; ?></td>
            <td><input type="text" name="config_url" value="<?php echo $config_url; ?>" />
              <?php if ($error_url) { ?>
              <span class="error"><?php echo $error_url; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_owner; ?></td>
            <td><input type="text" name="config_owner" value="<?php echo $config_owner; ?>" />
              <?php if ($error_owner) { ?>
              <span class="error"><?php echo $error_owner; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required"></span> <?php echo $entry_store_description; ?></td>
            <td><input type="text" name="config_store_description" value="<?php echo $config_store_description; ?>" />
              
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_address; ?></td>
            <td><textarea name="config_address" cols="40" rows="5"><?php echo $config_address; ?></textarea>
              <?php if ($error_address) { ?>
              <span class="error"><?php echo $error_address; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><input type="text" name="config_email" value="<?php echo $config_email; ?>" />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>" />
              <?php if ($error_telephone) { ?>
              <span class="error"><?php echo $error_telephone; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_mobile; ?></td>
            <td><input type="text" name="config_mobile" value="<?php echo $config_mobile; ?>" />
            </td>
          </tr>
          <tr>
            <td> <?php echo $entry_mobile_2; ?></td>
            <td>
                <input type="text" name="config_mobile_2" value="<?php echo $config_mobile_2; ?>" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><input type="text" name="config_fax" value="<?php echo $config_fax; ?>" /></td>
          </tr> 
          <tr>
            <td><?php echo $entry_receipt_title; ?></td>
            <td><input type="text" name="config_receipt_title" value="<?php echo $config_receipt_title; ?>" /></td>
          </tr> 
          <tr>
            <td><?php echo $entry_thanks_note; ?></td>
            <td><input type="text" name="config_thanks_note" value="<?php echo $config_thanks_note; ?>" /></td>
          </tr> 
        </table>
      </div>
      <div id="tab_site">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><input type="text" name="config_title" value="<?php echo $config_title; ?>" />
              <?php if ($error_title) { ?>
              <span class="error"><?php echo $error_title; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_description; ?></td>
            <td><textarea name="config_meta_description" cols="40" rows="5"><?php echo $config_meta_description; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_template; ?></td>
            <td><select name="config_template" onchange="$('#template').load('index.php?route=setting/setting/template&template=' + encodeURIComponent(this.value));">
                <?php foreach ($templates as $template) { ?>
                <?php if ($template == $config_template) { ?>
                <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
                <?php } else { ?>
                <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_meta_policy; ?></td>
            <td><textarea name="config_meta_policy" cols="40" rows="5"><?php echo $config_meta_policy; ?></textarea></td>
          </tr>
          
        </table> 
      </div>
      <div id="tab_local">
        <table class="form">
          <tr>
            <td><?php echo $entry_country; ?></td>
            <td><select name="config_country_id" id="country" onchange="$('#zone').load('index.php?route=setting/setting/zone&country_id=' + this.value + '&zone_id=<?php echo $config_zone_id; ?>');">
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $config_country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?></td>
            <td><select name="config_zone_id" id="zone">
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_language; ?></td>
            <td><select name="config_language">
                <?php foreach ($languages as $language) { ?>
                <?php if ($language['code'] == $config_language) { ?>
                <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr style="display:none">
            <td><?php echo $entry_admin_language; ?></td>
            <td><select name="config_admin_language">
                <?php foreach ($languages as $language) { ?>
                <?php if ($language['code'] == $config_admin_language) { ?>
                <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>          
          <tr  style="display:none">
            <td><?php echo $entry_currency; ?></td>
            <td><select name="config_currency">
                <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency['code'] == $config_currency) { ?>
                <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr  style="display:none">
            <td><?php echo $entry_currency_auto; ?></td>
            <td><?php if ($config_currency_auto) { ?>
              <input type="radio" name="config_currency_auto" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_currency_auto" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_currency_auto" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_currency_auto" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr> 
        </table>
      </div>
   <div id="tab_option">
        <table class="form">
          <tr>
            <td>Invoice Print Size:<span class="help">Select your invoice printing option</span></td>
            <td><?php if ($config_invoice_printer) { ?>
              <input type="radio" name="config_invoice_printer" value="1" checked="checked" />
              <?php echo $text_small_print; ?>
              <input type="radio" name="config_invoice_printer" value="0" />
              <?php echo $text_large_print; ?>
              <?php } else { ?>
              <input type="radio" name="config_invoice_printer" value="1" />
              <?php echo $text_small_print; ?>
              <input type="radio" name="config_invoice_printer" value="0" checked="checked" />
              <?php echo $text_large_print; ?>
              <?php } ?></td>
          </tr> 
          
          <tr>
            <td>Barcode Settngs:<span class="help">Barcode Digits</span></td>
            <td><?php if ($config_barcdoe_digits==5) { ?>
              <input type="radio" name="config_barcdoe_digits" value="11" />
              <?php echo $text_eleven_digits; ?>
              <input type="radio" name="config_barcdoe_digits" value="5" checked="checked" />
              <?php echo $text_five_digits; ?>
              <?php } else { ?>
              <input type="radio" name="config_barcdoe_digits" value="11" checked="checked"/>
              <?php echo $text_eleven_digits; ?>
              <input type="radio" name="config_barcdoe_digits" value="5"  />
              <?php echo $text_five_digits; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td>Enable Custom Reports</td>
            <td><?php if ($config_customreport) { ?>
              <input type="radio" name="config_customreport" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customreport" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_customreport" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customreport" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          
          <tr>
            <td>Show Customer Regions</td>
            <td><?php if ($config_customregion) { ?>
              <input type="radio" name="config_customregion" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customregion" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_customregion" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_customregion" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr> 

             <tr>
            <td>Show Warehouse</td>
            <td><?php if ($config_warehouse) { ?>
              <input type="radio" name="config_warehouse" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_warehouse" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_warehouse" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_warehouse" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
             <tr>
            <td>Show UOM</td>
            <td><?php if ($config_uom) { ?>
              <input type="radio" name="config_uom" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_uom" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_uom" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_uom" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
           <tr>
            <td>Enable Avg & Qty</td>
            <td><?php if ($config_averageQty) { ?>
              <input type="radio" name="config_averageQty" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_averageQty" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_averageQty" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_averageQty" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
           <tr>
            <td>Enable Register Tooltip</td>
            <td><?php if ($config_regTooltip) { ?>
              <input type="radio" name="config_regTooltip" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_regTooltip" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_regTooltip" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_regTooltip" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr> 
          <tr>
            <td>Enable Invoice Register</td>
            <td><?php if ($config_InvRegister) { ?>
              <input type="radio" name="config_InvRegister" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_InvRegister" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_InvRegister" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_InvRegister" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td>Enable Bonus Quantity</td>
            <td><?php if ($config_BonusQty) { ?>
              <input type="radio" name="config_BonusQty" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_BonusQty" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_BonusQty" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_BonusQty" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
                 <tr>
            <td>Required Warehouse In Invoice</td>
            <td><?php if ($config_Reqwarehouse) { ?>
              <input type="radio" name="config_Reqwarehouse" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_Reqwarehouse" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_Reqwarehouse" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_Reqwarehouse" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><?php if ($config_tax) { ?>
              <input type="radio" name="config_tax" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_tax" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_tax" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_tax" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_invoice; ?></td>
            <td><input type="text" name="config_invoice_id" value="<?php echo $config_invoice_id; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_invoice_prefix; ?></td>
            <td><input type="text" name="config_invoice_prefix" value="<?php echo $config_invoice_prefix; ?>" size="3" /></td>
          </tr> 
           <tr>
            <td>Refer friend message</td>
            <td><input type="text" name="config_refer_friend_message" value="<?php echo $config_refer_friend_message; ?>" /></td>
          </tr>  
          <tr>
            <td>Home page message block</td>
            <td><select name="config_homepagemessage">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($cmsblocks as $cb) { ?>
                <?php if ($cb['block_id'] == $config_homepagemessage) { ?>
                <option value="<?php echo $cb['block_id']; ?>" selected="selected"><?php echo $cb['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $cb['block_id']; ?>"><?php echo $cb['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>  
          <tr>
            <td>Footer follow us</td>
            <td><select name="config_footerfollowus">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($cmsblocks as $cb) { ?>
                <?php if ($cb['block_id'] == $config_footerfollowus) { ?>
                <option value="<?php echo $cb['block_id']; ?>" selected="selected"><?php echo $cb['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $cb['block_id']; ?>"><?php echo $cb['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>  
          <tr>
            <td>Auto Approve New User:<span class="help">Don't allow new user to login until their account has been approved.</span></td>
            <td><?php if ($config_siteusers_approval) { ?>
              <input type="radio" name="config_siteusers_approval" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_siteusers_approval" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_siteusers_approval" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_siteusers_approval" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr> 
          <tr>
            <td>Auto Approve New Job-post:</td>
            <td><?php if ($config_jobpost_approval) { ?>
              <input type="radio" name="config_jobpost_approval" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_jobpost_approval" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_jobpost_approval" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_jobpost_approval" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr> 
          <tr>
            <td><?php echo $entry_account; ?></td>
            <td><select name="config_account_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($cmss as $cms) { ?>
                <?php if ($cms['cms_id'] == $config_account_id) { ?>
                <option value="<?php echo $cms['cms_id']; ?>" selected="selected"><?php echo $cms['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $cms['cms_id']; ?>"><?php echo $cms['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_checkout; ?></td>
            <td><select name="config_checkout_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($cmss as $cms) { ?>
                <?php if ($cms['cms_id'] == $config_checkout_id) { ?>
                <option value="<?php echo $cms['cms_id']; ?>" selected="selected"><?php echo $cms['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $cms['cms_id']; ?>"><?php echo $cms['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>  
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="config_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>  
          <tr>
            <td><span class="required">*</span> <?php echo $entry_intial_points; ?></td>
            <td><input type="text" name="config_intial_points" value="<?php echo $config_intial_points; ?>" size="3" />
              <?php if ($error_intial_points) { ?>
              <span class="error"><?php echo $error_intial_points; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_admin_limit; ?></td>
            <td><input type="text" name="config_admin_limit" value="<?php echo $config_admin_limit; ?>" size="3" />
              <?php if ($error_admin_limit) { ?>
              <span class="error"><?php echo $error_admin_limit; ?></span>
              <?php } ?></td>
          </tr>
      <tr>
            <td><span class="required">*</span> <?php echo $entry_catalog_limit; ?></td>
            <td><input type="text" name="config_front_limit" value="<?php echo $config_front_limit; ?>" size="3" />
              <?php if ($error_front_limit) { ?>
              <span class="error"><?php echo $error_front_limit; ?></span>
              <?php } ?></td>
          </tr> 
      
        </table>
      </div> 
      <div id="tab_image">
        <table class="form">
          <tr>
            <td><?php echo $entry_logo; ?></td>
            <td><input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" id="logo" />
              <img src="<?php echo $preview_logo; ?>" alt="" id="preview_logo" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="../themes/admin/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('logo', 'preview_logo');" /></td>
          </tr>
          <tr style="display:none">
            <td><?php echo $entry_icon; ?></td>
            <td><input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" id="icon" />
              <img src="<?php echo $preview_icon; ?>" alt="" id="preview_icon" style="margin: 4px 0px; border: 1px solid #EEEEEE;" />&nbsp;<img src="../themes/admin/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('icon', 'preview_icon');" /></td>
          </tr>
          <tr style="display:none">
            <td><span class="required">*</span> <?php echo $entry_image_thumb; ?></td>
            <td><input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" />
              x
              <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" />
              <?php if ($error_image_thumb) { ?>
              <span class="error"><?php echo $error_image_thumb; ?></span>
              <?php } ?></td>
          </tr>
          <tr style="display:none">
            <td><span class="required">*</span> <?php echo $entry_image_popup; ?></td>
            <td><input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" />
              x
              <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" />
              <?php if ($error_image_popup) { ?>
              <span class="error"><?php echo $error_image_popup; ?></span>
              <?php } ?></td>
          </tr> 
        </table>
      </div>
      <div id="tab_mail">
        <table class="form">
          <tr>
            <td><?php echo $entry_mail_protocol; ?></td>
            <td><select name="config_mail_protocol">
                <?php if ($config_mail_protocol == 'mail') { ?>
                <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
                <?php } else { ?>
                <option value="mail"><?php echo $text_mail; ?></option>
                <?php } ?>
                <?php if ($config_mail_protocol == 'smtp') { ?>
                <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
                <?php } else { ?>
                <option value="smtp"><?php echo $text_smtp; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_host; ?></td>
            <td><input type="text" name="config_smtp_host" value="<?php echo $config_smtp_host; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_username; ?></td>
            <td><input type="text" name="config_smtp_username" value="<?php echo $config_smtp_username; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_password; ?></td>
            <td><input type="text" name="config_smtp_password" value="<?php echo $config_smtp_password; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_port; ?></td>
            <td><input type="text" name="config_smtp_port" value="<?php echo $config_smtp_port; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_smtp_timeout; ?></td>
            <td><input type="text" name="config_smtp_timeout" value="<?php echo $config_smtp_timeout; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_alert_mail; ?></td>
            <td><?php if ($config_alert_mail) { ?>
              <input type="radio" name="config_alert_mail" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_alert_mail" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_alert_mail" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_alert_mail" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
        </table>
      </div>
      <div id="tab_server">
        <table class="form">
          <tr>
            <td><?php echo $entry_ssl; ?></td>
            <td><?php if ($config_ssl) { ?>
              <input type="radio" name="config_ssl" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_ssl" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_ssl" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_ssl" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_encryption; ?></td>
            <td><input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_seo_url; ?></td>
            <td><?php if ($config_seo_url) { ?>
              <input type="radio" name="config_seo_url" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_seo_url" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_seo_url" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_seo_url" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_compression; ?></td>
            <td><input type="text" name="config_compression" value="<?php echo $config_compression; ?>" size="3" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_display; ?></td>
            <td><?php if ($config_error_display) { ?>
              <input type="radio" name="config_error_display" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_display" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_error_display" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_display" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_error_log; ?></td>
            <td><?php if ($config_error_log) { ?>
              <input type="radio" name="config_error_log" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_log" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="config_error_log" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="config_error_log" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_error_filename; ?></td>
            <td><input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" />
              <?php if ($error_error_filename) { ?>
              <span class="error"><?php echo $error_error_filename; ?></span>
              <?php } ?></td>
          </tr>
        </table>
      </div> 
      <div id="tab_other">
        <table class="form">
          <tr>
            <td><?php echo $entry_pjc; ?></td>
            <td><input type="text" name="config_pjc" value="<?php echo $config_pjc; ?>" /></td>
          </tr> 
          <tr>
            <td><?php echo $entry_inc; ?></td>
            <td><input type="text" name="config_inc" value="<?php echo $config_inc; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_pssmall; ?></td>
            <td><input type="text" name="config_pssmall" value="<?php echo $config_pssmall; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_psmedium; ?></td>
            <td><input type="text" name="config_psmedium" value="<?php echo $config_psmedium; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_pslarge; ?></td>
            <td><input type="text" name="config_pslarge" value="<?php echo $config_pslarge; ?>" /></td>
          </tr> 
        </table>
      </div> 
        
        <div id="tab_message">
        <table class="form">
          
          <tr>
            <td><?php echo $entry_message; ?></td>
            <td><select name="config_message" onchange="emptyMessagesFields(this.value)" id="config_message">
                    <?php if ($config_message == '0') { ?>
                    <option value="0" selected="selected">No</option>
                    <?php } else { ?>
                    <option value="0">No</option>
                    <?php } ?>
                    <?php if ($config_message == '1') { ?>
                    <option value="1" selected="selected">Yes</option>
                    <?php } else { ?>
                    <option value="1">Yes</option>
                    <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td>API Username</td>
            <td><input type="text" name="api_username" id="api_username" value="<?php echo $api_username; ?>" /></td>
          </tr>
          <tr>
            <td>API Password</td>
            <td><input type="password" name="api_password" id="api_password" value="<?php echo $api_password; ?>" /></td>
          </tr>
          <tr>
            <td>Masking</td>
            <td><input type="text" name="masking" id="masking" value="<?php echo $masking; ?>" /></td>
          </tr>
        </table>
      </div><!-- tab_other end -->
      <div id="tab_userKey">
        <table class="form">
          <tr>
             <td> 
                <?php if ($barcodeLabel == '1') { ?>
                    <input type="checkbox" name="barcodeLabel" value="1"  checked="checked" id="barcodeLabel">
                <?php } else { ?>
                    <input type="checkbox" name="barcodeLabel" value="0" id="barcodeLabel">
                <?php } ?> 
                <span style="margin-left: 10px;"><?php echo $barcode_label; ?></span> 
             </td>
          </tr>
          
        </table>
          <table>
              <tr>
              <td id="barcode_label_designs_table" style="<?php if ($barcodeLabel == 0) { echo 'display:none'; }?>">
                  <label><?php echo $tab_userKey; ?></label>
                  <input type="text" name="userKey_barcodeLabel" id="userKey_barcodeLabel" value="<?php echo $userKey_barcodeLabel; ?>" />
                  <!--
                  <input type="text" name="barcodeDesignJson" id="barcodeDesignJson" value="<?php echo $barcodeDesignJson; ?>" />
                  -->
              </td>
              </tr>
          </table>
          <table>
              <tr>
                  <ul id="barcode_label_designs_images_table" style="<?php if ($barcodeLabel == 0) { echo 'display:none'; }?>">
                    <li>
                        <?php if ($label_design_1 == '1') { ?>
                            <input type="checkbox" id="label_design_1" name="label_design_1" checked="checked" value="1"  />
                        <?php } else { ?>
                            <input type="checkbox" id="label_design_1" name="label_design_1" value="0"  />
                        <?php } ?>
                        <label for="label_design_1"><img src="../themes/admin/image/barcodeLabel.png" /></label>
                    </li>
                    <li>
                        <?php if ($label_design_2 == '1') { ?>
                            <input type="checkbox" id="label_design_2" name="label_design_2" checked="checked" value="1"  />
                        <?php } else { ?>
                            <input type="checkbox" id="label_design_2" name="label_design_2" value="0"  />
                        <?php } ?>
                        <label for="label_design_2"><img src="../themes/admin/image/barcodeLabel.png" /></label>
                    </li>
                    <li>
                        <?php if ($label_design_3 == '1') { ?>
                            <input type="checkbox" id="label_design_3" name="label_design_3" checked="checked" value="1"  />
                        <?php } else { ?>
                            <input type="checkbox" id="label_design_3" name="label_design_3" value="0"  />
                        <?php } ?>
                        <label for="label_design_3"><img src="../themes/admin/image/barcodeLabel.png" /></label>
                    </li>
                    <li>
                        <?php if ($label_design_4 == '1') { ?>
                            <input type="checkbox" id="label_design_4" name="label_design_4" checked="checked" value="1"  />
                        <?php } else { ?>
                            <input type="checkbox" id="label_design_4" name="label_design_4" value="0"  />
                        <?php } ?>
                        <label for="label_design_4"><img src="../themes/admin/image/barcodeLabel.png" /></label>
                    </li>
                    <li>
                        <?php if ($label_design_5 == '1') { ?>
                            <input type="checkbox" id="label_design_5" name="label_design_5" checked="checked" value="1"  />
                        <?php } else { ?>
                            <input type="checkbox" id="label_design_5" name="label_design_5" value="0"  />
                        <?php } ?>
                        <label for="label_design_5"><img src="../themes/admin/image/barcodeLabel.png" /></label>
                    </li>
                  </ul>
              </tr>
          </table>
          
          
          
      </div><!-- tab_other end -->
    </form>
  </div><!--end content_block-->  
       </div><!--end jquery tab-->  
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper-->
<script type="text/javascript" src="../themes/admin/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
<?php } ?>  
//--></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>
<script type="text/javascript"><!--
function image_upload(field, preview) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image',
          type: 'POST',
          data: 'image=' + encodeURIComponent($('#' + field).val()),
          dataType: 'text',
          success: function(data) {
            $('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" style="border: 1px solid #EEEEEE;" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 700,
    height: 400,
    resizable: false,
    modal: false
  });
};

    function emptyMessagesFields(val){
        if(val=='0'){
            $("#api_username").val('');
            $("#api_password").val('');
            $("#masking").val('');
        } else {
            $("#api_username").val('waqarjan333');
            $("#api_password").val('5777697ahmad');
            $("#masking").val('Aursoft');
        }
    }
    
    $(function () {
          $('#barcodeLabel').click(function() {
           if(this.checked){
               $('#barcodeLabel').val("1");
               $("#barcode_label_designs_table").show();
               $("#barcode_label_designs_images_table").show();
           } else {
               $('#barcodeLabel').val("0");
               //$("#barcodeDesignJson").val("");
               $("#barcode_label_designs_table").hide();
               $("#barcode_label_designs_images_table").hide();
               $('#label_design_1').attr('checked', false);
               $('#label_design_2').attr('checked', false); 
               $('#label_design_3').attr('checked', false);
               $('#label_design_4').attr('checked', false);
               $('#label_design_5').attr('checked', false);
               $('#label_design_1').val("0");
               $('#label_design_2').val("0"); 
               $('#label_design_3').val("0");
               $('#label_design_4').val("0");
               $('#label_design_5').val("0");
            }
          });
          $('#label_design_1').click(function() {
           if(this.checked){
               $('#label_design_2').attr('checked', false); 
               $('#label_design_3').attr('checked', false);
               $('#label_design_4').attr('checked', false);
               $('#label_design_5').attr('checked', false);
               $('#label_design_1').val("1");
               $('#label_design_2').val("0"); 
               $('#label_design_3').val("0");
               $('#label_design_4').val("0");
               $('#label_design_5').val("0");
               
           }
          });
          $('#label_design_2').click(function() {
           
           if(this.checked){
               $('#label_design_1').attr('checked', false); 
               $('#label_design_3').attr('checked', false);
               $('#label_design_4').attr('checked', false);
               $('#label_design_5').attr('checked', false);
               $('#label_design_1').val("0");
               $('#label_design_2').val("1"); 
               $('#label_design_3').val("0");
               $('#label_design_4').val("0");
               $('#label_design_5').val("0");
           }
          });
          $('#label_design_3').click(function() {
            
           if(this.checked){
               $('#label_design_2').attr('checked', false); 
               $('#label_design_1').attr('checked', false);
               $('#label_design_4').attr('checked', false);
               $('#label_design_5').attr('checked', false);
               $('#label_design_1').val("0");
               $('#label_design_2').val("0"); 
               $('#label_design_3').val("1");
               $('#label_design_4').val("0");
               $('#label_design_5').val("0");
           }
          });
          $('#label_design_4').click(function() {
           if(this.checked){
               $('#label_design_2').attr('checked', false); 
               $('#label_design_3').attr('checked', false);
               $('#label_design_1').attr('checked', false);
               $('#label_design_5').attr('checked', false);
               $('#label_design_1').val("0");
               $('#label_design_2').val("0"); 
               $('#label_design_3').val("0");
               $('#label_design_4').val("1");
               $('#label_design_5').val("0");
           }
          });
          $('#label_design_5').click(function() {
           if(this.checked){
               $('#label_design_2').attr('checked', false); 
               $('#label_design_3').attr('checked', false);
               $('#label_design_1').attr('checked', false);
               $('#label_design_4').attr('checked', false);
               $('#label_design_1').val("0");
               $('#label_design_2').val("0"); 
               $('#label_design_3').val("0");
               $('#label_design_4').val("0");
               $('#label_design_5').val("1");
           }
          });
    });
    
//--></script>
<script type="text/javascript"><!--
$('#template').load('index.php?route=setting/setting/template&template=' + encodeURIComponent($('select[name=\'config_template\']').attr('value')));

$('#zone').load('index.php?route=setting/setting/zone&country_id=<?php echo $config_country_id; ?>&zone_id=<?php echo $config_zone_id; ?>');
//--></script>
<script type="text/javascript"><!--
$.tabs('#tabs a');
$.tabs('#languages a');
//--></script>
<?php echo $footer; ?>