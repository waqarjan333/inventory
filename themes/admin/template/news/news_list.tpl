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
                        <td class="left" ><?php if ($sort == 'cd.title') { ?>
                          <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                          <?php } else { ?>
                          <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                          <?php } ?></td>
                        <td class="right"><?php echo $column_status; ?></td>
                        <td class="right"><?php echo $column_sort_order; ?></td>
                        <td class="right" style="width:150px"><?php echo $column_action; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($newsp) { ?>
                      <?php foreach ($newsp as $news) { ?>
                      <tr>
                        <td style="text-align: center;"><?php if ($news['selected']) { ?>
                          <input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" checked="checked" />
                          <?php } else { ?>
                          <input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" />
                          <?php } ?></td>
                        <td class="left"><?php echo $news['title']; ?></td>
                        <td class="right"><?php echo $news['status']; ?></td>
                         <td class="right"><?php echo $news['sort_order']; ?></td>
                         <td class="right"><?php foreach ($news['action'] as $action) { ?>
                          [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                          <?php } ?></td>
                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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