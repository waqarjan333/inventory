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
                            <td><input name="c_name" value="<?php echo isset($c_name) ? $c_name : ''; ?>" />
                              <?php if (isset($error_title)) { ?>
                              <span class="error"><?php echo $error_title; ?></span>
                              <?php } ?></td>
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