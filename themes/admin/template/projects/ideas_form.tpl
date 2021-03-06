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
                              <td><span class="required">*</span> <span class="entry"><?php echo $entry_firstname; ?></span></td>
                              <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
                                <?php if ($error_firstname) { ?>
                                <span class="error"><?php echo $error_firstname; ?></span>
                                <?php } ?></td>
                            </tr>
                            <tr>
                              <td><span class="required">*</span> <span class="entry"><?php echo $entry_lastname; ?></span></td>
                              <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
                                <?php if ($error_lastname) { ?>
                                <span class="error"><?php echo $error_lastname; ?></span>
                                <?php } ?></td>
                            </tr>
                            <tr>
                              <td><span class="required">*</span> <?php echo $entry_email; ?></td>
                              <td><input type="text" name="email" value="<?php echo $email; ?>" />
                                <?php if ($error_email) { ?>
                                <span class="error"><?php echo $error_email; ?></span>
                                <?php  } ?></td>
                            </tr>
                            <tr>
                              <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
                              <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
                                <?php if ($error_telephone) { ?>
                                <span class="error"><?php echo $error_telephone; ?></span>
                                <?php  } ?></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_fax; ?></td>
                              <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_password; ?></td>
                              <td><input type="password" name="password" value="<?php echo $password; ?>"  />
                                <br />
                                <?php if ($error_password) { ?>
                                <span class="error"><?php echo $error_password; ?></span>
                                <?php  } ?></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_confirm; ?></td>
                              <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
                                <?php if ($error_confirm) { ?>
                                <span class="error"><?php echo $error_confirm; ?></span>
                                <?php  } ?></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_newsletter; ?></td>
                              <td><select name="newsletter">
                                  <?php if ($newsletter) { ?>
                                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                  <option value="0"><?php echo $text_disabled; ?></option>
                                  <?php } else { ?>
                                  <option value="1"><?php echo $text_enabled; ?></option>
                                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                  <?php } ?>
                                </select></td>
                            </tr>
                            <tr>
                              <td><?php echo $entry_siteusers_group; ?></td>
                              <td><select name="siteusers_group_id">
                                  <?php foreach ($siteusers_groups as $siteusers_group) { ?>
                                  <?php if ($siteusers_group['siteusers_group_id'] == $siteusers_group_id) { ?>
                                  <option value="<?php echo $siteusers_group['siteusers_group_id']; ?>" selected="selected"><?php echo $siteusers_group['name']; ?></option>
                                  <?php } else { ?>
                                  <option value="<?php echo $siteusers_group['siteusers_group_id']; ?>"><?php echo $siteusers_group['name']; ?></option>
                                  <?php } ?>
                                  <?php } ?>
                                </select></td>
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
                          </table>
                        </form>
 			</div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper--> 
<?php echo $footer; ?>  