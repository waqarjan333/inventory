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
                          <td><span class="required">*</span>Main url</td>
                          <td><input name="mainurl" value="<?php echo $mainurl; ?>" /></td>
                        </tr>
                        <tr>
                          <td><span class="required">*</span> Seo URL</td>
                          <td><input name="seourl" value="<?php echo $seourl; ?>" /></td>
                        </tr> 
                        <tr>
                          <td> Seo Title</td>
                          <td><input name="seotitle" value="<?php echo $seotitle; ?>" /></td>
                        </tr>  
                        <tr>
                          <td> Seo keywords</td>
                          <td><textarea name="seokeywords" cols="40" rows="5"><?php echo $seokeywords; ?></textarea></td>
                        </tr>  
                         <tr>
                          <td> Seo Description</td>
                          <td><textarea name="seodescription" cols="40" rows="5"><?php echo $seodescription; ?></textarea></td>
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