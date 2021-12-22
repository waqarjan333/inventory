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
   		 <div id="tabs" class="htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_data"><?php echo $tab_data; ?></a></div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
              <div id="tab_general">
                <div id="languages" class="htabs">
                  <?php foreach ($languages as $language) { ?>
                  <?php if ($language['status']) { ?>
                  <a tab="#language<?php echo $language['language_id']; ?>"><img src="../themes/admin/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php foreach ($languages as $language) { ?>
                <?php if ($language['status']) { ?>
                <div id="language<?php echo $language['language_id']; ?>">
                  <table class="form">
                    <tr>
                      <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                      <td><input name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" />
                        <?php if (isset($error_name[$language['language_id']])) { ?>
                        <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                        <?php } ?></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_meta_description; ?></td>
                      <td><textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_description; ?></td>
                      <td><textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea></td>
                    </tr>
                  </table>
                </div>
                <?php } ?>
                <?php } ?>
              </div>
              <div id="tab_data">
                <table class="form">
                  <tr>
                    <td>Parent category</td>
                    <td><select name="parent_id">
                        <option value="0"><?php echo $text_none; ?></option>
                        <?php foreach ($categories as $cat) { ?>
                        <?php if ($cat['category_id'] == $parent_id) { ?>
                        <option value="<?php echo $cat['category_id']; ?>" selected="selected"><?php echo $cat['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select></td>
                  </tr> 
                  <tr>
                    <td><?php echo $entry_keyword; ?></td>
                    <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_status; ?></td>
                    <td><select name="status">
                        <?php if ($status) { ?>
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
                    <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
                  </tr>
                </table>
              </div>
            </form>
 </div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper-->  
<script type="text/javascript" src="../themes/admin/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
<?php if ($language['status']) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
<?php } ?>
<?php } ?>
//--></script>
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
<script type="text/javascript"><!--
$.tabs('#tabs a'); 
$.tabs('#languages a');
//--></script>
<?php echo $footer; ?>