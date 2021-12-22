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
                              <td><?php echo $entry_position; ?></td>
                              <td><select name="cms_position">
                                  <?php if ($cms_position == 'left') { ?>
                                  <option value="left" selected="selected"><?php echo $text_left; ?></option>
                                  <?php } else { ?>
                                  <option value="left"><?php echo $text_left; ?></option>
                                  <?php } ?>
                                  <?php if ($cms_position == 'right') { ?>
                                  <option value="right" selected="selected"><?php echo $text_right; ?></option>
                                  <?php } else { ?>
                                  <option value="right"><?php echo $text_right; ?></option>
                                  <?php } ?>
                                </select></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_status; ?></td>
                              <td><select name="cms_status">
                                  <?php if ($cms_status) { ?>
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
                              <td><input type="text" name="cms_sort_order" value="<?php echo $cms_sort_order; ?>" size="1" /></td>
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