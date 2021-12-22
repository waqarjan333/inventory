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
                      <div id="tabs" class="htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_data"><?php echo $tab_data; ?></a><a tab="#tab_menu"><?php echo $tab_menu; ?></a></div>
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                         <div id="tab_general">
                          <div id="languages" class="htabs">
                            <?php foreach ($languages as $language) { ?>
                            <?php if ($language['status']) { ?>
                            <a tab="#language<?php echo $language['language_id']; ?>"><img src="../images/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                            <?php } ?>
                            <?php } ?>
                          </div>
                          <?php foreach ($languages as $language) { ?>
                          <?php if ($language['status']) { ?>
                          <div id="language<?php echo $language['language_id']; ?>">
                            <table class="form">
                              <tr>
                                <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                                <td><input name="cms_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($cms_description[$language['language_id']]) ? $cms_description[$language['language_id']]['title'] : ''; ?>" />
                                  <?php if (isset($error_title[$language['language_id']])) { ?>
                                  <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
                                  <?php } ?></td>
                              </tr>
                              <tr>
                                <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                                <td><textarea name="cms_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($cms_description[$language['language_id']]) ? $cms_description[$language['language_id']]['description'] : ''; ?></textarea>
                                  <?php if (isset($error_description[$language['language_id']])) { ?>
                                  <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
                                  <?php } ?></td>
                              </tr>
                            </table>
                          </div>
                          <?php } ?>
                          <?php } ?>
                           </div>
                          <div id="tab_data">
                          <table class="form"> 
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
                          <div id="tab_menu">
						  	<table class="form">
								<tr>
									<td>
										Menu Title
									</td>
									<td>
										<input name="tm_title" value="<?php echo $tm_title;?>" size="15" />
									</td>
								</tr>
								<tr>
									<td>
										Menu Parent
									</td>
									<td>
										<select name="parent_id" id="parent_id">
		                          			<option value=""></option>
		                          			<?php foreach($menus as $m){?>
			                          		<option <?php if($menus['parent_id']==$parent_id) {?> selected="selected"<?php  } ?> value="<?php echo $m['tm_id']?>"><?php echo $m['tm_title']?></option>
			                          		<?php }?>	
		                          		</select>
									</td>
								</tr>
								<tr>
									<td>Position</td>
									<td>
                                     <select name="tm_dir" id="tm_dir">
                                        <?php foreach ($menudirs as $md => $v) { ?>
                                        <option value="<?php echo $v; ?>" <?php if($v==$tm_dir){ echo "'selected'"; } ?>><?php echo $md; ?></option>
                                        <?php } ?>
                                      </select>
                                  </td>
								</tr>
								<tr>
									<td>Sort Order</td>
                                    <td><input name="msort_order" value="<?php echo $msort_order; ?>" size="1" /></td>
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
<?php foreach ($languages as $language) { 
if ($language['status']) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
<?php } ?>
<?php } ?>
//--></script>
<script type="text/javascript"><!--
$.tabs('#tabs a'); 
$.tabs('#languages a');
//--></script>
<?php echo $footer; ?>