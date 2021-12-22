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
                              <td><?php echo $entry_limit; ?></td>
                              <td><input type="text" name="featured_limit" value="<?php echo $featured_limit; ?>" size="1" /></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_position; ?></td>
                              <td><select name="featured_position">
                                  <?php if ($featured_position == 'left') { ?>
                                  <option value="left" selected="selected"><?php echo $text_left; ?></option>
                                  <?php } else { ?>
                                  <option value="left"><?php echo $text_left; ?></option>
                                  <?php } ?>
                                  <?php if ($featured_position == 'right') { ?>
                                  <option value="right" selected="selected"><?php echo $text_right; ?></option>
                                  <?php } else { ?>
                                  <option value="right"><?php echo $text_right; ?></option>
                                  <?php } ?>
                                </select></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_status; ?></td>
                              <td><select name="featured_status">
                                  <?php if ($featured_status) { ?>
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
                              <td><input type="text" name="featured_sort_order" value="<?php echo $featured_sort_order; ?>" size="1" /></td>
                            </tr>
                            <tr>
                            <td><?php echo $entry_product; ?></td>
                            <td><div class="scrollbox">
                                <?php $class = 'odd'; ?>
                                <?php foreach ($products as $product) { ?>
                                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                <div class="<?php echo $class; ?>">
                                  <?php if (in_array($product['deal_id'], $featured_product)) { ?>
                                  <input type="checkbox" name="featured_product[]" value="<?php echo $product['deal_id']; ?>" checked="checked" />
                                  <?php echo $product['name']; ?>
                                  <?php } else { ?>
                                  <input type="checkbox" name="featured_product[]" value="<?php echo $product['deal_id']; ?>" />
                                  <?php echo $product['name']; ?>
                                  <?php } ?>
                                </div>
                                <?php } ?>
                              </div></td>
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