<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
         <div class="jquery_tab">
            <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2> 
                     <div class="topbuttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
                     </div>
                      <?php if ($error_warning) { ?>
                   		 	<div class="message warning"><?php echo $error_warning; ?></div>
                   	 <?php } ?>
                     <?php if ($success) { ?>
                   			 <div class="message success"><?php echo $success; ?></div>
                     <?php } ?>
                     
                     <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                      <table class="list">
                        <thead>
                          <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                            <td class="left"><?php echo $column_title; ?></td>
                            <td class="left"><?php echo $column_user_type; ?></td>
                            <td class="left"><?php echo $column_package_type; ?></td>
                            <td class="left"><?php echo $column_price; ?></td>
                            <td class="right"><?php echo $column_action; ?></td>
                            
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($packages) { ?>
                          <?php foreach ($packages as $package) { ?>
                          <tr>
                            <td style="text-align: center;"><?php if ($package['selected']) { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $package['package_id']; ?>" checked="checked" />
                              <?php } else { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $package['package_id']; ?>" />
                              <?php } ?></td>
                            <td class="left"><?php echo $package['title']; ?></td>
                            <td class="left"><?php echo $package['user_type']; ?></td>
                            <td class="left"><?php echo $package['package_type']; ?></td>
                            <td class="left">$<?php echo $package['price']; ?> USD</td>
                            <td class="right"><?php foreach ($package['action'] as $action) { ?>
                              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                              <?php } ?>
                            </td>
                          </tr>
                          <?php } ?>
                          <?php } else { ?>
                          <tr>
                            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </form>
                     <div class="pagination"><?php //echo $pagination; ?></div>
                  </div><!--end content_block-->  
           </div><!--end jquery tab--> 
        </div><!--end content--> 
        </div><!--end main--> 
        <?php echo $left_col; ?>
      </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  
 