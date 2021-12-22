<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_send; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
   <?php if ($error_warning) { ?>
                    <div class="message warning"><?php echo $error_warning; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                    <div class="message success"><?php echo $success; ?></div>
                    <?php } ?>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                      <table class="form">
                        <tr>
                          <td><?php echo $entry_site; ?></td>
                          <td><select name="site_id">
                              <option value="0"><?php echo $text_default; ?></option>
                              <?php foreach ($sites as $site) { ?>
                              <?php if ($site['site_id'] == $site_id) { ?>
                              <option value="<?php echo $site['site_id']; ?>"><?php echo $site['name']; ?></option>
                              <?php } else { ?>
                              <option value="<?php echo $site['site_id']; ?>"><?php echo $site['name']; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td><?php echo $entry_to; ?></td>
                          <td><select name="group">
                              <option value=""></option>
                              <?php if ($group == 'newsletter') { ?>
                              <option value="newsletter" selected="selected"><?php echo $text_newsletter; ?></option>
                              <?php } else { ?>
                              <option value="newsletter"><?php echo $text_newsletter; ?></option>
                              <?php } ?>
                              <?php if ($group == 'siteusers') { ?>
                              <option value="siteusers" selected="selected"><?php echo $text_siteusers; ?></option>
                              <?php } else { ?>
                              <option value="siteusers"><?php echo $text_siteusers; ?></option>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td><table width="100%">
                              <tr>
                                <td style="padding: 0;" colspan="3"><input type="text" id="search" value="" style="margin-bottom: 5px;" />
                                  <a onclick="getCustomers();" style="margin-bottom: 5px;" class="button"><span><?php echo $text_search; ?></span></a></td>
                              </tr>
                              <tr>
                                <td width="49%" style="padding: 0;"><select multiple="multiple" id="siteusers" size="10" style="width: 100%; margin-bottom: 3px;">
                                  </select></td>
                                <td width="2%" style="text-align: center; vertical-align: middle;"><input type="button" value="--&gt;" onclick="addCustomer();" />
                                  <br />
                                  <input type="button" value="&lt;--" onclick="removeCustomer();" /></td>
                                <td width="49%" style="padding: 0;"><select multiple="multiple" id="to" size="10" style="width: 100%; margin-bottom: 3px;">
                                    <?php foreach ($siteusers as $siteusers) { ?>
                                    <option value="<?php echo $siteusers['su_id']; ?>"><?php echo $siteusers['name']; ?></option>
                                    <?php } ?>
                                  </select></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_subject; ?></td>
                          <td><input name="subject" value="<?php echo $subject; ?>" />
                            <?php if ($error_subject) { ?>
                            <span class="error"><?php echo $error_subject; ?></span>
                            <?php } ?></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> <?php echo $entry_message; ?></td>
                          <td><textarea name="message" id="message"><?php echo $message; ?></textarea>
                            <?php if ($error_message) { ?>
                            <span class="error"><?php echo $error_message; ?></span>
                            <?php } ?></td>
                        </tr>
                      </table>
                      <div id="siteusers_to">
                        <?php foreach ($siteusers as $siteusers) { ?>
                        <input type="hidden" name="to[]" value="<?php echo $siteusers['su_id']; ?>" />
                        <?php } ?>
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
CKEDITOR.replace('message');
//--></script>
<script type="text/javascript"><!--
function addCustomer() {
	$('#siteusers :selected').each(function() {
		$(this).remove();
		
		$('#to option[value=\'' + $(this).attr('value') + '\']').remove();
		
		$('#to').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');
		
		$('#siteusers_to').append('<input type="hidden" name="to[]" value="' + $(this).attr('value') + '" />');
	});
}

function removeCustomer() {
	$('#to :selected').each(function() {
		$(this).remove();
		
		$('#siteusers_to input[value=\'' + $(this).attr('value') + '\']').remove();
	});
}

function getCustomers() {
	$('#siteusers option').remove();
	
	$.ajax({
		url: 'index.php?route=sale/contact/siteusers&keyword=' + encodeURIComponent($('#search').attr('value')),
		dataType: 'json',
		success: function(data) {
			for (i = 0; i < data.length; i++) {
	 			$('#siteusers').append('<option value="' + data[i]['su_id'] + '">' + data[i]['name'] + '</option>');
			}
		}
	});
}
//--></script>
<?php echo $footer; ?>