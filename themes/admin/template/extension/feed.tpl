<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2> 
                    <?php if ($error) { ?>
                    <div class="message warning"><?php echo $error; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                    <div class="message success"><?php echo $success; ?></div>
                    <?php } ?>
                    <table class="list">
                      <thead>
                        <tr>
                          <td class="left"><?php echo $column_name; ?></td>
                          <td class="left"><?php echo $column_status; ?></td>
                          <td class="right"><?php echo $column_action; ?></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($extensions) { ?>
                        <?php foreach ($extensions as $extension) { ?>
                        <tr>
                          <td class="left"><?php echo $extension['name']; ?></td>
                          <td class="left"><?php echo $extension['status'] ?></td>
                          <td class="right"><?php foreach ($extension['action'] as $action) { ?>
                            [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                            <?php } ?></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                          <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table> 
 		</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  