<?php echo $header; ?>
 <div id="bg_wrapper"> 
   <div id="main"> 
      <div id="content">
        <div class="jquery_tab">
              <div class="content_block">
                     <h2 class="jquery_tab_title"><?php echo $heading_title; ?></h2>
                      <div class="topbuttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div> 
                    <?php if ($error_warning) { ?>
                    <div class="message warning"><?php echo $error_warning; ?></div>
                    <?php } ?>
                    <?php if ($success) { ?>
                    <div class="message success"><?php echo $success; ?></div>
                    <?php } ?>
                    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                      <table class="list">
                        <thead>
                          <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                            <td class="left"><?php if ($sort == 'tm_title') { ?>
                              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                              <?php } else { ?>
                              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                              <?php } ?></td>
                            <td class="left"><?php echo $column_url; ?></td>
                            <td class="left"><?php echo $column_dir; ?></td>
                            <td class="left"><?php echo $column_for; ?></td>
                            <td class="right"><?php echo $column_sort_order; ?></td>
                            <td class="right"><?php echo $column_status; ?></td>
                            <td class="right"><?php echo $column_action; ?></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($menus) { ?>
                          <?php foreach ($menus as $menu) { ?>
                          <tr>
                            <td style="text-align: center;"><?php if ($menu['selected']) { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $menu['tm_id']; ?>" checked="checked" />
                              <?php } else { ?>
                              <input type="checkbox" name="selected[]" value="<?php echo $menu['tm_id']; ?>" />
                              <?php } ?></td>
                            <td class="left"><?php echo $menu['tm_title']; ?></td> 
                            <td class="left"><?php echo $menu['tm_url']; ?></td>
                            <td class="left">
                            	<?php if($menu['tm_dir']=='1'){ echo 'Top | Main Navigation'; } 
                                	else if($menu['tm_dir']=='2'){ echo 'Left'; } 
                                    else if($menu['tm_dir']=='3'){ echo 'Right'; } 
                                    else if($menu['tm_dir']=='4'){ echo 'Member'; } 
                                    else if ($menu['tm_dir'] == '5'){ echo "Bottom | Company";}
                                     else if($menu['tm_dir']=='6'){ echo 'Bottom | Learn More'; } 
                                      else if($menu['tm_dir']=='7'){ echo 'Bottom | Follow Us'; } 
                                     ?>
                                    
                             </td>
                             <td class="left">
                                 <?php if($menu['tm_for']=='1'){ echo $option_allusers; } 
                                    else if($menu['tm_for']=='2'){ echo $option_providers; } 
                                    else if($menu['tm_for']=='3'){ echo $option_seekers; }  
                                    else if($menu['tm_for']=='4'){ echo $option_not_seekers; }  
                                    else if($menu['tm_for']=='5'){ echo $option_not_providers; }  
                                     ?>
                             </td>
                            <td class="right"><?php echo $menu['sort_order']; ?></td>
                            <td class="right"><?php echo $menu['status']; ?></td>
                            <td class="right"><?php foreach ($menu['action'] as $action) { ?>
                              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                              <?php } ?></td>
                          </tr>
                              <?php if (!empty($menu['children'])) {?>
                              		<?php foreach ($menu['children'] as $children) { ?>
                                    		<tr>
                                                <td style="text-align: center;"><?php if ($children['selected']) { ?>
                                                  <input type="checkbox" name="selected[]" value="<?php echo $children['tm_id']; ?>" checked="checked" />
                                                  <?php } else { ?>
                                                  <input type="checkbox" name="selected[]" value="<?php echo $children['tm_id']; ?>" />
                                                  <?php } ?></td>
                                                <td class="left"> - <?php echo $children['tm_title']; ?></td> 
                                                <td class="left"><?php echo $children['tm_url']; ?></td>
                                                <td class="left">
                                                    <?php if($children['tm_dir']=='1'){ echo 'Top | Main Navigation'; } 
                                                        else if($children['tm_dir']=='2'){ echo 'Left'; } 
                                                        else if($children['tm_dir']=='3'){ echo 'Right'; } 
                                                        else if($children['tm_dir']=='4'){ echo 'Member'; } 
                                                        else if ($children['tm_dir'] == '5'){ echo "Bottom | Company";}
                                                         else if($children['tm_dir']=='6'){ echo 'Bottom | Learn More'; } 
                                                          else if($children['tm_dir']=='7'){ echo 'Bottom | Follow Us'; } 
                                                         ?>
                                                        
                                                 </td>
                                                 <td class="left">
                                                     <?php if($children['tm_for']=='1'){ echo $option_allusers; } 
                                                        else if($children['tm_for']=='2'){ echo $option_providers; } 
                                                        else if($children['tm_for']=='3'){ echo $option_seekers; }  
                                                         ?>
                                                 </td>
                                                <td class="right"><?php echo $children['sort_order']; ?></td>
                                                <td class="right"><?php echo $children['status']; ?></td>
                                                <td class="right"><?php foreach ($children['action'] as $action) { ?>
                                                  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                                                  <?php } ?></td>
                                              </tr>
                              		<?php }//end children foreach?>
                              <?php }//end children if?>
                          
                          <?php } ?>
                          <?php } else { ?>
                          <tr>
                            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
<?php echo $footer; ?>  