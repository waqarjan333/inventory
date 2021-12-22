<?php echo $header; ?>
  <div id="content">
            <div id="content_container">
                <div id="content_area">
                                        
                     <div class="info_table_buttons" style="float:right;padding-right:50px">
                                <div class="grey_button">
                                    <div class="grey_button_right">
                                        <a href="javascript:void(0)" onclick="addFriend()"><?php echo $button_add_friend; ?></a>
                                    </div>
                                </div>
                                <div class="grey_button">
                                    <div class="grey_button_right">
                                        <a onclick="removeFriend()" href="javascript:void(0)"><?php echo $button_remove; ?></a>
                                    </div>
                                </div>

                             </div>
                         
                        <?php if ($error_warning) { ?>
                        <div class="warning"><?php echo $error_warning; ?></div>
                        <?php } ?>
                        <h1><?php echo $heading_title;?></h1>
                        <br/>
                        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="friends">   
                        <div class="clear"></div>
                            <label for="project_name" class="request_label"><?php echo $entry_friend; ?>*</label>
                            <div class="form_textinput alignleft">
                                <input type="text" name="friend[]" value="<?php echo $friend; ?>" size="30" maxlength="45" title="Email"/>
                                <?php if ($error_friend) { ?>
                                <span class="error"><?php echo $error_friend; ?></span>
                                <?php } ?>
                            </div>
                            
                            <?php if ($friends) { ?>
                            <?php foreach ($friends as $result) { ?>
                                <label for="project_name" class="request_label"><?php echo $entry_friend; ?>*</label>
                                    <div class="form_textinput alignleft">
                                        <input type="text" name="friend[]" value="<?php echo $result;?>" size="30" maxlength="45" />
                                        <?php if ($error_friend) { ?>
                                        <span class="error"><?php echo $error_friend; ?></span>
                                        <?php } ?>
                                    </div>
                             <?php } ?>
                            <?php } ?>
                            <div id="request_container">     
                                                            
                            </div>
                            <div class="clear"></div>
                                                    
                            <label class="request_label">&nbsp;</label>
                            <input type="image" name="submit" value="Submit" onclick="$('#friends').submit();" src="themes/hawklink/images/send.png" class="alignleft"/>
                            <div class="clear"></div>
                        </form>                                       
                    <div class="clear"></div>
                </div><!--#content_area-->
            </div><!--#content_container-->
        </div><!--#content-->

<div class="clear"></div> 


<script type="text/javascript"><!--
function addFriend() {
       var html = '<div class="clear"> </div>';
           html += '<label for="project_name" class="request_label"><?php echo $entry_friend; ?>*</label>';
           html +='<div class="form_textinput alignleft">'
           html +='<input type="text" name="friend[]" value="" size="30" maxlength="45" title="Email"/></div>';
          $('#request_container').append(html);
}       

function removeFriend() {
    for(var i=0;i<=2;i++){
    $('#request_container').children(":last").remove();
    }

}
//--></script>
<?php echo $footer; ?>
