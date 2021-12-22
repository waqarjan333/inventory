<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                            <?php if ($success) { ?>
                            <div class="message success"><?php echo $success; ?></div>
                            <?php } ?>
                                 <table class="list">
                                  <thead>
                                    <tr>
                                      <td class="left"><?php echo $column_name; ?></td>
                                      <td class="left"><?php echo $column_model; ?></td>
                                      <td class="right"><?php echo $column_viewed; ?></td>
                                      <td class="right"><?php echo $column_percent; ?></td>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php if ($products) { ?>
                                    <?php foreach ($products as $product) { ?>
                                    <tr>
                                      <td class="left"><?php echo $product['name']; ?></td>
                                      <td class="left"><?php echo $product['model']; ?></td>
                                      <td class="right"><?php echo $product['viewed']; ?></td>
                                      <td class="right"><?php echo $product['percent']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <tr>
                                      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
            		<div class="pagination"><?php echo $pagination; ?></div>
          </div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  