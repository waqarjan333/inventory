<?php echo $header; ?>
  		<div class="link-left">
  			<div class="brands-detail float-l">
           <div class="float-l pricing">
              <?php if ($success) { ?>
                   <div class="success"><?php echo $success; ?></div>
              <?php } ?>
              <?php if ($error) { ?>
                <div class="warning"><?php echo $error; ?></div>
              <?php } ?>  
             <div class="settings-center" style="width:305px;">
             	<div class="form">
               		 <div class="form-b"><img src="themes/Dijeecom/images/form-tl.gif" width="10" height="10" class="float-left" /><img src="themes/Dijeecom/images/form-tr.gif" width="10" height="10" class="float-right" /><br class="clear" /></div>
                  	<div id="formsss" class="form-area">
                    	<div class="div2 float-l">
            				<h3 class="brd-btm mar-btm"><?php echo $text_i_am_new_siteusers; ?></h3>
                  		 	 <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="account">
                              <?php if ($redirect) { ?>
                                            <input type="hidden" name="redirectreg" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
                                <?php } ?>
                                <p><?php echo $text_checkout; ?></p>
                                <p>
                                  <?php if ($account == 'register') { ?>
                                  <input type="radio" name="account" value="register" id="register" checked="checked" />
                                  <?php } else { ?>
                                  <input type="radio" name="account" value="register" id="register" />
                                  <?php } ?>
                                  <?php echo $text_account; ?> 
                                <br />
                                <?php if ($guest_checkout) { ?> 
                                  <?php if ($account == 'guest') { ?>
                                  <input type="radio" name="account" value="guest" id="guest" checked="checked" />
                                  <?php } else { ?>
                                  <input type="radio" name="account" value="guest" id="guest" />
                                  <?php } ?>
                                  <?php echo $text_guest; ?> 
                                <?php } ?>
                                </p>
                                <br />
                                <p><?php echo $text_create_account; ?></p>
                                <div style="text-align: right; padding-top:8px;"><a onclick="$('#account').submit();" class="button"><span><?php echo $button_continue; ?></span></a></div>
                  			 </form> 
                    	</div>
               			<!-- content ends -->
                		<div class="clear"></div>
            		</div>
        		<div class="form-b"><img src="themes/Dijeecom/images/form-bl.gif" width="10" height="10" class="float-left" /><img src="themes/Dijeecom/images/form-br.gif" width="10" height="10" class="float-right" /><br class="clear" /></div>
                	</div>
				 	<h1>&nbsp;</h1>
              </div> 
              <div class="settings-center" style="width:305px; padding-left:5px;">
					<div class="form">
				    		<div class="form-b"><img src="themes/Dijeecom/images/form-tl.gif" width="10" height="10" class="float-left" /><img src="themes/Dijeecom/images/form-tr.gif" width="10" height="10" class="float-right" /><br class="clear" /></div>
				          	<div id="form" class="form-area">
				            	<!-- Content here -->
				            		<div class="div2 float-l">
					                   <h3 class="brd-btm mar-btm"><?php echo $text_returning_siteusers; ?></h3>
					                   <p><?php echo $text_i_am_returning_siteusers; ?></p>
					                   <div id="contact">
                                           <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="login-form">  
                                            <input type="text" onblur="if (this.value == '') {this.value = '<?php echo $entry_email; ?>';}" onfocus="if (this.value == '<?php echo $entry_email; ?>') {this.value = '';}" id="email" name="email" value="<?php echo $entry_email; ?>" class="contact-txt" /> 
                                            <input type="password" onblur="if (this.value == '') {this.value = '';}" onfocus="if (this.value == '<?php echo $entry_password; ?>') {this.value = '';}" id="password" name="password" value="" class="contact-txt" />
                                            <br /> 
                                            <div style="text-align: right; padding-top: 12px;" ><a onclick="$('#login-form').submit();" class="button" ><span><?php echo $button_login; ?></span></a></div>
                                            <div style="text-align:right; float:right; padding-top: 13px; margin-right: 25px;"> <a href="<?php echo str_replace('&', '&amp;', $forgotten); ?>" ><?php echo $text_forgotten_password; ?></a></div>
                                            <?php if ($redirect) { ?>
                                            <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
                                            <?php } ?>
                                          </form> 
					                   </div>  
					                </div> 
				            	<!-- content ends -->
                        		<div class="clear"></div>
                    		</div>
				    		<div class="form-b"><img src="themes/Dijeecom/images/form-bl.gif" width="10" height="10" class="float-left" /><img src="themes/Dijeecom/images/form-br.gif" width="10" height="10" class="float-right" /><br class="clear" /></div> 
				 			</div>
				 			<h1>&nbsp;</h1>
					</div>  
           	  </div>
     </div>
  		</div>
    	<!-- Left Area -->
    
    <!-- Right Area -->
    <?php echo $right?>

<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script>
<?php echo $footer; ?> 