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
                          <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                          <td><input type="text" name="title" value="<?php echo $title; ?>" />
                            <?php if ($error_title) { ?>
                            <span class="error"><?php echo $error_title; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_code; ?></td>
                          <td><input type="text" name="code" value="<?php echo $code; ?>" />
                            <?php if ($error_code) { ?>
                            <span class="error"><?php echo $error_code; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_symbol_left; ?></td>
                          <td><input type="text" name="symbol_left" value="<?php echo $symbol_left; ?>" /></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_symbol_right; ?></td>
                          <td><input type="text" name="symbol_right" value="<?php echo $symbol_right; ?>" /></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_decimal_place; ?></td>
                          <td><input type="text" name="decimal_place" value="<?php echo $decimal_place; ?>" /></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_value; ?></td>
                          <td><input type="text" name="value" value="<?php echo $value; ?>" /></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_status; ?></td>
                          <td><select name="status">
                              <?php if ($status) { ?>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                              <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_enabled; ?></option>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                            </select></td>
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