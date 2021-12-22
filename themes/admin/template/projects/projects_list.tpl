<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
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
                            <td class="left"><?php if ($sort == 'pd.project_title') { ?>
                              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                              <?php } ?></td> 
                             <td class="left">category name</td> 
                             <td class="left"><?php echo $column_name; ?></td>   
                             <td class="left"><?php if ($sort == 'p.status') { ?>
                              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                              <?php } ?></td>
                            <td class="left"><?php if ($sort == 'i.approved') { ?>
                              <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?></a>
                              <?php } ?></td>              
                            <td class="left"><?php if ($sort == 'i.created_date') { ?>
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
                            <td><input type="text" name="filter_title" value="<?php echo $filter_title; ?>" /></td>
                            <td></td>  
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
                          <?php if ($projectss) { ?>
                          <?php foreach ($projectss as $p) { ?>
                          <tr>
                            <td style="text-align: center;"><?php if (false){//$idea['selected']) { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $p['project_id']; ?>" checked="checked" />
                              <?php } else { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $p['project_id']; ?>" />
                              <?php } ?></td>
                            <td class="left"><a href="javascript:void(0);" onclick="return viewidea('<?php echo $p['project_id']; ?>')" ><?php echo $p['project_name']; ?></a></td> 
                            <td class="left"><?php echo $p['category_name']; ?></td>
                            <td class="left"><?php echo $p['fullname']; ?></td> 
                            <td class="left"><?php echo $p['status']; ?></td>
                            <td class="left"><?php echo $p['approved']; ?></td>
                            <td class="left" colspan="2"><?php echo $p['created_date']; ?></td> 
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

function viewidea(id){ 
	window.open('index.php?route=projects/projects/details&id='+id,'User idea','width=800px, left=100, top=100,scrollbars=1'); 
} 
function filter() {
	url = 'index.php?route=ideas/ideas'; 
	var filter_title = $('input[name=\'filter_title\']').attr('value'); 
	if (filter_title) {
		url += '&filter_title=' + encodeURIComponent(filter_name);
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