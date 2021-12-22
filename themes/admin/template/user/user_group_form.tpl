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
                          <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                          <td><input type="text" name="name" value="<?php echo $name; ?>" />
                            <?php if ($error_name) { ?>
                            <span class="error"><?php echo $error_name; ?></span>
                            <?php  } ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_access; ?></td>
                          <td><div class="scrollbox">
                              <?php $class = 'odd'; ?>
                              <?php foreach ($permissions as $permission) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div class="<?php echo $class; ?>">
                                <?php if (in_array($permission, $access)) { ?>
                                <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" checked="checked" />
                                <?php echo $permission; ?>
                                <?php } else { ?>
                                <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" />
                                <?php echo $permission; ?>
                                <?php } ?>
                              </div>
                              <?php } ?>
                            </div></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_modify; ?></td>
                          <td><div class="scrollbox">
                              <?php $class = 'odd'; ?>
                              <?php foreach ($permissions as $permission) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div class="<?php echo $class; ?>">
                                <?php if (in_array($permission, $modify)) { ?>
                                <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" checked="checked" />
                                <?php echo $permission; ?>
                                <?php } else { ?>
                                <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" />
                                <?php echo $permission; ?>
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