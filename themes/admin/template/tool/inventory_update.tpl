<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_update; ?></span></a></div>
   					 <?php if ($error_warning) { ?>
                   		 <div class="message warning"><?php echo $error_warning; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                   			 <div class="message success"><?php echo $success; ?></div>
                    <?php } ?> 
                     <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                     <?php echo $entry_file; ?> <input type="file" name="import" size="60px" /><br />
                     <div style="margin:5px 0 10px 25px;">
                     <?php echo $text_id_field; ?><br />
                     <input type="radio" name="id_field" value="model" <?php echo (isset($id_field) ? ($id_field == "model" ? "CHECKED" : "") : ""); ?>/><b><?php echo $entry_model; ?></b><br />
                     <input type="radio" name="id_field" value="sku" <?php echo (isset($id_field) ? ($id_field == "sku" ? "CHECKED" : "") : ""); ?>/><b><?php echo $entry_sku; ?></b><br />
                     </div>
                      <?php if (isset($error_id_field)) { ?>
                     <span class="error"><?php echo $error_id_field; ?></span>
                     <?php } ?>		
                                 
                     <?php if (isset($error_file)) { ?>
                     <span class="error"><?php echo $error_file; ?></span>
                     <?php } ?>		
                     <?php if (isset($error_filedata)) { ?>
                     <hr />
                     <span class="error"><?php echo $error_filedata; ?></span>
                     <hr />
                     <?php } ?> 
                     <p><?php echo $text_howto ; ?></p>
                     </form>
 			</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  