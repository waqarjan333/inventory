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
                        <div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                          <div id="tab_general" class="page">
                            <table class="form">
                              <tr>
                                <td><?php echo $entry_limit; ?></td>
                                <td><input type="text" name="news_limit" value="<?php echo $news_limit; ?>" size="1" /></td>
                              </tr> 
                              <tr>
                                <td width="25%"><?php echo $entry_position; ?></td>
                                <td><select name="news_position">
                                    <?php if ($news_position == 'left') { ?>
                                    <option value="left" selected="selected"><?php echo $text_left; ?></option>
                                    <?php } else { ?>
                                    <option value="left"><?php echo $text_left; ?></option>
                                    <?php } ?>
                                    <?php if ($news_position == 'right') { ?>
                                    <option value="right" selected="selected"><?php echo $text_right; ?></option>
                                    <?php } else { ?>
                                    <option value="right"><?php echo $text_right; ?></option>
                                    <?php } ?>
                                    <?php if ($news_position == 'homepage') { ?>
                                    <option value="homepage" selected="selected"><?php echo $text_homepage; ?></option>
                                    <?php } else { ?>
                                    <option value="homepage"><?php echo $text_homepage; ?></option>
                                    <?php } ?>
                                  </select></td>
                              </tr>
                              <tr>
                                <td><?php echo $entry_status; ?></td>
                                <td><select name="news_status">
                                    <?php if ($news_status) { ?>
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
                                <td><input type="text" name="news_sort_order" value="<?php echo $news_sort_order; ?>" size="1" /></td>
                              </tr>
                            </table>
  					</div>
				</form>
                	</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> <script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>

