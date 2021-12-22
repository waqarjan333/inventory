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
                          <td>Title<span class="required">*</span></td>
                          <td><input name="title" value="<?php echo $title; ?>" />
                            <?php if ($error_name) { ?>
                            <span class="error"><?php echo $error_name; ?></span>
                            <?php } ?></td>
                        </tr>  
                         <tr>
                          <td>Description</td>
                          <td><textarea name="description" id="description"><?php echo $description; ?>"</textarea></td>
                        </tr>  
                        <tr>
                          <td><?php echo $entry_sort_order; ?></td>
                          <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
                        </tr>
                      </table>
                    </form>
			 </div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper-->
  <script type="text/javascript" src="../themes/admin/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!-- 
CKEDITOR.replace('description'); 
//--></script>
<?php echo $footer; ?>