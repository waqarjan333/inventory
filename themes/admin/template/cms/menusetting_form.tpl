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
                            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                            <td><input name="tm_title" value="<?php echo isset($tm_title) ? $tm_title : ''; ?>" />
                              <?php if (isset($error_title)) { ?>
                              <span class="error"><?php echo $error_title; ?></span>
                              <?php } ?></td>
                          </tr> 
                          <tr>
                            <td><span class="required">*</span> <?php echo $entry_url; ?></td>
                            <td><input name="tm_url" value="<?php echo isset($tm_url) ? $tm_url : ''; ?>" />
                              <?php if (isset($error_murl)) { ?>
                              <span class="error"><?php echo $error_murl; ?></span>
                              <?php } ?></td>
                          </tr>
                          <tr>
                          	<td>
                          		Parent
                          	</td>
                          	<td>
                          		
                          		<select name="parent_id" id="parent_id">
                          			<option value=""></option>
                          			<?php foreach($menus as $m){?>
	                          		<option <?php if($parent_id == $m['tm_id']){ echo "selected";} ?> value="<?php echo $m['tm_id']?>"><?php echo $m['tm_title']?></option>
                                    
                                    <?php if (!empty($m['children'])) {?>
    	                          		<?php foreach ($m['children'] as $children) { ?>
                                    		<option <?php if($parent_id == $children['tm_id']){ echo "selected";} ?> value="<?php echo $children['tm_id']?>"> - <?php echo $children['tm_title']?></option>
	                                    <?php }//end children foreach?>
                                    <?php }//end children if?>
                                    
	                          		<?php }?>	
                          		</select>
                          	</td>
                          </tr>
                          <tr>
                              <td>
                                  <?php echo $entry_for; ?>
                              </td>
                              <td>
                                  <select name="tm_for" id="tm_for">
                                      <option <?php if($tm_for == 1)echo "selected"; ?> value="1"><?php echo $option_allusers; ?></option>
                                      <option <?php if($tm_for == 2)echo "selected"; ?> value="2"><?php echo $option_providers; ?></option>
                                      <option <?php if($tm_for == 3)echo "selected"; ?> value="3"><?php echo $option_seekers; ?></option>
                                      <option <?php if($tm_for == 5)echo "selected"; ?> value="5"><?php echo $option_not_providers; ?></option>
                                      <option <?php if($tm_for == 4)echo "selected"; ?> value="4"><?php echo $option_not_seekers; ?></option>
                                  </select>
                              </td>
                          </tr>
                          <tr>
                          <td><?php echo $entry_dir; ?></td>
                          <td>
                          	
                             <select name="tm_dir" id="tm_dir">
                                
                                    <option <?php if($tm_dir == 1)echo "selected"; ?> value="1">Top | Main Navigation</option>
                                    <option <?php if($tm_dir == 2)echo "selected"; ?> value="2">Left</option>
                                    <option <?php if($tm_dir == 3)echo "selected"; ?> value="3">Right</option>
                                    <option <?php if($tm_dir == 4)echo "selected"; ?> value="4">Member</option>
                                    <option <?php if($tm_dir == 5)echo "selected"; ?> value="5">Bottom | Company</option>
                                	<option <?php if($tm_dir == 6)echo "selected"; ?> value="6">Bottom | Learn More</option>
                                	<option <?php if($tm_dir == 7)echo "selected"; ?> value="7">Bottom | Follow Us</option>
                             </select>
                          </td>
                        </tr>
                          <tr>
                          <td><?php echo $entry_sort_order; ?></td>
                            <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
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