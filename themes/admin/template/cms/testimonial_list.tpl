<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div> 
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
                            <td class="left"><?php if ($sort == 'title') { ?>
                              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Title</a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_name; ?>">title</a>
                              <?php } ?></td>
                            <td class="right"><?php if ($sort == 'sort_order') { ?>
                              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                              <?php } ?></td>
                            <td class="right"><?php echo $column_action; ?></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($testimonials) { ?>
                          <?php foreach ($testimonials as $t) { ?>
                          <tr>
                            <td style="text-align: center;"><?php if ($t['selected']) { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $t['t_id']; ?>" checked="checked" />
                              <?php } else { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $t['t_id']; ?>" />
                              <?php } ?></td>
                            <td class="left"><?php echo $t['title']; ?></td>
                            <td class="right"><?php echo $t['sort_order']; ?></td>
                            <td class="right"><?php foreach ($t['action'] as $action) { ?>
                              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                              <?php } ?></td>
                          </tr>
                          <?php } ?>
                          <?php } else { ?>
                          <tr>
                            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </form>
       <div class="pagination"><?php echo $pagination; ?></div>
 		</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  