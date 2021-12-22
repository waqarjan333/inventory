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
                            <?php foreach ($languages as $language) { ?>
                            <tr>
                              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                              <td><input name="order_status[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($order_status[$language['language_id']]) ? $order_status[$language['language_id']]['name'] : ''; ?>" />
                                <img src="themes/admin/images/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                <?php if (isset($error_name[$language['language_id']])) { ?>
                                <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                                <?php } ?></td>
                            </tr>
                            <?php } ?>
                          </table>
                        </form>
  			</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  