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
                      <td><span class="required">*</span> <?php echo $entry_package_type; ?></td>
                      <td><select name="package_type">
                        <option value="1" <?php if($package_type==1){echo "selected=\"selected\"";}?>><?php echo $entry_monthly; ?></option>
                        <option value="2" <?php if($package_type==2){echo "selected=\"selected\"";}?>><?php echo $entry_demand; ?></option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                      <td><input name="title" value="<?php echo $title; ?>" />
                        <?php if (isset($error_name)) { ?>
                        <span class="error"><?php echo $error_name; ?></span>
                        <?php } ?></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_type; ?></td>
                      <td><select name="service_id">
                         <option value="2" <?php if($service_id==2){echo "selected=\"selected\"";}?>><?php echo $entry_providers; ?></option>
                         <option value="1" <?php if($service_id==1){echo "selected=\"selected\"";}?>><?php echo $entry_seekers; ?></option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_description; ?></td>
                        <td><textarea name="description" cols="40" rows="5"><?php echo $description; ?></textarea></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_price; ?></td>
                      <td>$<input name="price" id="price" value="<?php echo $price; ?>"></input> USD</td>
                    </tr>
                  </table>
                </div>
                <?php } ?>
                <?php } ?>
              
         
            </form>
 </div><!--end content_block-->  
       </div><!--end jquery tab--> 
    </div><!--end content--> 
    </div><!--end main--> 
    <?php echo $left_col; ?>
  </div><!--end bg_wrapper-->  
<script type="text/javascript"><!--
$.tabs('#tabs a'); 
$.tabs('#languages a');
//--></script>
<?php echo $footer; ?>