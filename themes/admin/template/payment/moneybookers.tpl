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
                      <td><?php echo $entry_email; ?></td>
                      <td><input type="text" name="moneybookers_email" value="<?php echo $moneybookers_email; ?>" />
                        <?php if ($error_email) { ?>
                        <span class="error"><?php echo $error_email; ?></span>
                        <?php } ?></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_order_status; ?></td>
                      <td><select name="moneybookers_order_status_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $moneybookers_order_status_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_order_status_pending; ?></td>
                      <td><select name="moneybookers_order_status_pending_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $moneybookers_order_status_pending_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_order_status_canceled; ?></td>
                      <td><select name="moneybookers_order_status_canceled_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $moneybookers_order_status_canceled_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_order_status_failed; ?></td>
                      <td><select name="moneybookers_order_status_failed_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $moneybookers_order_status_failed_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_order_status_chargeback; ?></td>
                      <td><select name="moneybookers_order_status_chargeback_id">
                          <?php foreach ($order_statuses as $order_status) { ?>
                          <?php if ($order_status['order_status_id'] == $moneybookers_order_status_chargeback_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_geo_zone; ?></td>
                      <td><select name="moneybookers_geo_zone_id">
                          <option value="0"><?php echo $text_all_zones; ?></option>
                          <?php foreach ($geo_zones as $geo_zone) { ?>
                          <?php if ($geo_zone['geo_zone_id'] == $moneybookers_geo_zone_id) { ?>
                          <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_status; ?></td>
                      <td><select name="moneybookers_status">
                          <?php if ($moneybookers_status) { ?>
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
                      <td><input type="text" name="moneybookers_sort_order" value="<?php echo $moneybookers_sort_order; ?>" size="3" /></td>
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