 <?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="$('#resite').submit();" class="button"><span><?php echo $button_resite; ?></span></a><a onclick="$('#backup').submit();" class="button"><span><?php echo $button_backup; ?></span></a></div>
    			 <?php if ($error_warning) { ?>
                    <div class="message warning"><?php echo $error_warning; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                    <div class="message success"><?php echo $success; ?></div>
                    <?php } ?>
                    <form action="<?php echo $resite; ?>" method="post" enctype="multipart/form-data" id="resite">
                      <table class="form">
                        <tr>
                          <td><?php echo $entry_resite; ?></td>
                          <td><input type="file" name="import" /></td>
                        </tr>
                      </table>
                    </form>
                    <form action="<?php echo $backup; ?>" method="post" enctype="multipart/form-data" id="backup">
                      <table class="form">
                        <tr>
                          <td><?php echo $entry_backup; ?></td>
                          <td><div class="scrollbox" style="margin-bottom: 5px;">
                              <?php $class = 'odd'; ?>
                              <?php foreach ($tables as $table) { ?>
                              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                              <div class="<?php echo $class; ?>">
                                <input type="checkbox" name="backup[]" value="<?php echo $table; ?>" checked="checked" />
                                <?php echo $table; ?> </div>
                              <?php } ?>
                            </div>
                            <a onclick="$('input[name*=\'backup\']').attr('checked', 'checked');"><u><?php echo $text_select_all; ?></u></a> / <a onclick="$('input[name*=\'backup\']').attr('checked', '');"><u><?php echo $text_unselect_all; ?></u></a></td>
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