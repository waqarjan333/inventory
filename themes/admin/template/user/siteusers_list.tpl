<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="$('form').attr('action', '<?php echo $approve; ?>'); $('form').submit();" class="button"><span><?php echo $button_approve; ?></span></a><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
					<?php if ($error_warning) { ?>
                    		<div class="message warning"><?php echo $error_warning; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                    		<div class="message success"><?php echo $success; ?></div>
                    <?php } ?>
                    <form action="" method="post" enctype="multipart/form-data" id="form">
                      <table class="list">
                        <thead>
                          <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                            <td class="left"><?php if ($sort == 'name') { ?>
                              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                              <?php } ?></td> 
                            <td class="left"><?php if ($sort == 'c.email') { ?>
                              <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_username; ?> / <?php echo $column_email; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_email; ?>"><?php echo $column_username; ?> / <?php echo $column_email; ?></a>
                              <?php } ?></td>
                            <td class="left"><?php if ($sort == 'user_type') { ?>
                              <a href="<?php echo $sort_user_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_user_type; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_user_type; ?>"><?php echo $column_user_type; ?></a>
                              <?php } ?></td>
                             <td class="left">Referal</td>              
                            <td class="left"><?php if ($sort == 'c.status') { ?>
                              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                              <?php } ?></td>
                            <td class="left"><?php if ($sort == 'c.approved') { ?>
                              <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?></a>
                              <?php } ?></td>              
                            <td class="left"><?php if ($sort == 'c.date_added') { ?>
                              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                              <?php } ?></td>
                            <td class="right"><?php echo $column_action; ?></td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="filter">
                            <td></td>
                            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td> 
                            <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
                            <td><select name="filter_siteusers_type">
                                <option value="*"></option>
                                <?php foreach ($userstypes as $keys=>$utype) { ?>
                                <?php if ($keys == $filter_siteusers_type) { ?>
                                <option value="<?php echo $keys; ?>" selected="selected"><?php echo $utype; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $keys; ?>"><?php echo $utype; ?></option>
                                <?php } ?>
                                <?php } ?>
                              </select></td>
                              <td></td>
                            <td><select name="filter_status">
                                <option value="*"></option>
                                <?php if ($filter_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <?php } ?>
                                <?php if (!is_null($filter_status) && !$filter_status) { ?>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                              </select></td>
                            <td><select name="filter_approved">
                                <option value="*"></option>
                                <?php if ($filter_approved) { ?>
                                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_yes; ?></option>
                                <?php } ?>
                                <?php if (!is_null($filter_approved) && !$filter_approved) { ?>
                                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                <?php } else { ?>
                                <option value="0"><?php echo $text_no; ?></option>
                                <?php } ?>
                              </select></td>              
                            <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
                            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
                          </tr>
                          <?php if ($siteusers) { ?>
                          <?php foreach ($siteusers as $su) { ?>
                          <tr>
                            <td style="text-align: center;"><?php if ($su['selected']) { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $su['su_id']; ?>" checked="checked" />
                              <?php } else { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $su['su_id']; ?>" />
                              <?php } ?></td>
                            <td class="left"><?php echo $su['name']; ?></td> 
                            <td class="left"><?php echo $su['email']; ?></td>
                            <td class="left"><?php echo $su['user_type']; ?></td>
                            <td class="left"><?php echo $su['referal']; ?>
                            <td class="left"><?php echo $su['status']; ?></td>
                            <td class="left"><?php echo $su['approved']; ?></td>
                            <td class="left"><?php echo $su['date_added']; ?></td>
                            <td class="right"><?php foreach ($su['action'] as $action) { ?>
                              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                              <?php } ?></td>
                          </tr>
                          <?php } ?>
                          <?php } else { ?>
                          <tr>
                            <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
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
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=user/siteusers'; 
	var filter_name = $('input[name=\'filter_name\']').attr('value'); 
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	} 
	var filter_email = $('input[name=\'filter_email\']').attr('value'); 
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	} 
	var filter_siteusers_type = $('select[name=\'filter_siteusers_type\']').attr('value'); 
	if (filter_siteusers_type != '*') {
		url += '&filter_siteusers_type=' + encodeURIComponent(filter_siteusers_type);
	} 
	var filter_status = $('select[name=\'filter_status\']').attr('value'); 
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	} 
	var filter_approved = $('select[name=\'filter_approved\']').attr('value');
	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}	 
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value'); 
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	} 
	location = url;
}
//--></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?>