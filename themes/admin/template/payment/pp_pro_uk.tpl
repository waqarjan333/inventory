<?php echo $header; ?>
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
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                      <table class="form">
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_vendor; ?></td>
                          <td><input type="text" name="pp_pro_uk_vendor" value="<?php echo $pp_pro_uk_vendor; ?>" />
                            <?php if ($error_vendor) { ?>
                            <span class="error"><?php echo $error_vendor; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_user; ?></td>
                          <td><input type="text" name="pp_pro_uk_user" value="<?php echo $pp_pro_uk_user; ?>" />
                            <?php if ($error_user) { ?>
                            <span class="error"><?php echo $error_user; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
                          <td><input type="text" name="pp_pro_uk_password" value="<?php echo $pp_pro_uk_password; ?>" />
                            <?php if ($error_password) { ?>
                            <span class="error"><?php echo $error_password; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_partner; ?></td>
                          <td><input type="text" name="pp_pro_uk_partner" value="<?php echo $pp_pro_uk_partner; ?>" />
                            <?php if ($error_partner) { ?>
                            <span class="error"><?php echo $error_partner; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_test; ?></td>
                          <td><?php if ($pp_pro_uk_test) { ?>
                            <input type="radio" name="pp_pro_uk_test" value="1" checked="checked" />
                            <?php echo $text_yes; ?>
                            <input type="radio" name="pp_pro_uk_test" value="0" />
                            <?php echo $text_no; ?>
                            <?php } else { ?>
                            <input type="radio" name="pp_pro_uk_test" value="1" />
                            <?php echo $text_yes; ?>
                            <input type="radio" name="pp_pro_uk_test" value="0" checked="checked" />
                            <?php echo $text_no; ?>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_transaction; ?></td>
                          <td><select name="pp_pro_uk_transaction">
                              <?php if (!$pp_pro_uk_transaction) { ?>
                              <option value="0" selected="selected"><?php echo $text_authorization; ?></option>
                              <?php } else { ?>
                              <option value="0"><?php echo $text_authorization; ?></option>
                              <?php } ?>
                              <?php if ($pp_pro_uk_transaction) { ?>
                              <option value="1" selected="selected"><?php echo $text_sale; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_sale; ?></option>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_order_status; ?></td>
                          <td><select name="pp_pro_uk_order_status_id">
                              <?php foreach ($order_statuses as $order_status) { ?>
                              <?php if ($order_status['order_status_id'] == $pp_pro_uk_order_status_id) { ?>
                              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                              <?php } else { ?>
                              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_geo_zone; ?></td>
                          <td><select name="pp_pro_uk_geo_zone_id">
                              <option value="0"><?php echo $text_all_zones; ?></option>
                              <?php foreach ($geo_zones as $geo_zone) { ?>
                              <?php if ($geo_zone['geo_zone_id'] == $pp_pro_uk_geo_zone_id) { ?>
                              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                              <?php } else { ?>
                              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_status; ?></td>
                          <td><select name="pp_pro_uk_status">
                              <?php if ($pp_pro_uk_status) { ?>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                              <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_enabled; ?></option>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_sort_order; ?></td>
                          <td><input type="text" name="pp_pro_uk_sort_order" value="<?php echo $pp_pro_uk_sort_order; ?>" size="1" /></td>
                        </tr>
                      </table>
                    </form>
 			</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  