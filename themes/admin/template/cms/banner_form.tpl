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
          <td><span class="required">*</span> Banner name</td>
          <td><input name="name" value="<?php echo $sponsors['banner_description']; ?>" />
            <?php if ($error_name) { ?>
            <span class="error"><?php echo $error_name; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> URL</td>
          <td><input name="sponsor_url" value="<?php echo $sponsors['banner_url']; ?>" />
            <?php if ($error_name) { ?>
            <span class="error"><?php echo $error_url; ?></span>
            <?php } ?></td>
        </tr> 
        <tr>
          <td>Image</td>
          <td>
          	
          	<input type="hidden" name="sponsor_image" value="<?php //echo $banner_image; ?>" id="image" />
            <img src="<?php echo $preview; ?>" alt="" id="preview" style="border: 1px solid #EEEEEE;" />&nbsp;<img src="../themes/admin/image/image.png" alt="" style="cursor: pointer;" align="top" onclick="image_upload('image', 'preview');" /></td>
        	<!-- 
        	<input type="file" name="sponsor_image" /> 
        	-->
        </tr>
        <tr>
        	<td>
            	<?php echo $entry_type ?>
            </td>
            <td>
            	
                <select name="banner_type">
                	<option value="1" <?php if($sponsors['banner_type'] == 1) echo "selected"; ?> >Website</option>
                    <option value="2" <?php if($sponsors['banner_type'] == 2) echo "selected"; ?> >Internal URL</option>
                	<option value="3" <?php if($sponsors['banner_type'] == 3) echo "selected"; ?> >Document</option>
                </select>
                
            </td>
        </tr>
        <tr>
        	<td>
            	<?php echo $entry_internal ?>
            </td>
            <td>
            	<input type="text" name="internal_url" value="<?=$sponsors['internal_url'] ?>" />
            </td>
        </tr>
        <tr>
        	<td>
            	<?php echo $entry_document ?>
            </td>
            <td>
            	<input type="file" name="banner_document" />
            </td>
        </tr>
        <tr>
          <td>Status</td>
          <td>
          	<select name="banner_status">
          		<option <?php if($sponsors['banner_status'] == 1) echo "selected" ?>  value ="1">Enable</option>
          		<option <?php if($sponsors['banner_status'] == 0) echo "selected" ?> value ="0">Disable</option>	
          	</select>
          </td>
        </tr>
        <tr>
        	<td>
            	Position
            </td>
            <td>
            	<select name="banner_position">
                	<option <?php if($sponsors['banner_position'] == "Top") echo "Selected" ?> value="Top" >Top</option>
                    <option <?php if($sponsors['banner_position'] == "Left") echo "Selected" ?> value="Left" >Left</option>
                    <option <?php if($sponsors['banner_position'] == "Right") echo "Selected" ?> value="Right" >Right</option>
                    <option <?php if($sponsors['banner_position'] == "Bottom") echo "Selected" ?> value="Bottom" >Bottom</option>
                </select>
            </td>
        </tr>
      </table>
    </form>
			 </div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper-->
  <script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>
<script type="text/javascript"><!--
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