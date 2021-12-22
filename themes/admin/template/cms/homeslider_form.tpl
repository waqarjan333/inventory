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
                          <td><input name="name" value="<?php echo $name; ?>" />
                            <?php if ($error_name) { ?>
                            <span class="error"><?php echo $error_name; ?></span>
                            <?php } ?></td>
                        </tr> 
                        <tr>
                          <td>Link to</td>
                          <td><input name="linkto" value="<?php echo $linkto; ?>" /></td>
                        </tr> 
                        <tr>
                          <td>Short description</td>
                          <td><input name="short_description" value="<?php echo $short_description; ?>" /></td>
                        </tr> 
                         <tr>
                          <td>Description</td>
                          <td><textarea name="description" id="description"><?php echo $description; ?></textarea></td>
                        </tr> 
                        <tr>
                          <td>Image</td>
                          <td><input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                            <img src="<?php echo $preview; ?>" alt="" id="preview" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="../themes/admin/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('image', 'preview');" /></td>
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
  <script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>
<script type="text/javascript"><!-- 
CKEDITOR.replace('description');
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" style="border: 1px solid #EEEEEE;" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<?php echo $footer; ?>