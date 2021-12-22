<?php echo $nlheader; ?>
        <div id="login"> 
                    <h1 class="logo">
                        <a href="../index.php">&nbsp;</a>
                    </h1> 
                     <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="login-form"> 
                    <p>
                        <label for="name"><?php echo $entry_username; ?></label>
                        <input class="input-flex" type="text" value="<?php echo $username; ?>" name="username" id="username" onfocus="if (this.value == 'User name is required') { this.value = ''; this.style.color='#666666';}"/>
                    </p>
                    <p>
                        <label for="password"><?php echo $entry_password; ?></label>
                        <input class="input-flex" type="password" value="<?php echo $password; ?>" name="password" id="password"/>
                    </p>
                
                    <p class="remember" style="display:none;">
                        <label for="checkbox1" class="inline">Remember me?</label>
                        <input type="checkbox" value="1" name="checkbox1" id="checkbox1" /> 
                    </p>
                    <div class="forgot_pw" style="display:none;"><a href="#">Forgot password?</a></div>
                    <p class="clearboth"><a onclick="return validate();" class="button"><span><?php echo $button_login; ?></span></a></p>
                    </form>
         </div>
        <?php if ($error_warning) { ?> 
                <div class="login_message message error">
                  <p><?php echo $error_warning; ?></p>
                </div>
        <?php } ?>
<script type="text/javascript"><!--
function validate(){
	   var efinds=false;
	   var msg="";
		if ($("#username").val() == '' || $("#username").val() =='User name is required'){  
			$("#username").val('User name is required');
			$("#username").css("color","#FE4800");
			efinds=true;
		} else {
			$("#username").css("color","#666666"); 
		}
		 if ($("#password").val() == ''){  
			$("#password").css("color","#FE4800");
			efinds=true;
		} else{
			$("#password").css("color","#666666"); 
		}
		 if(efinds){ 
				//$.jGrowl(msg,{ life: 10000 });
				return false; 
		 } else { 
			$('#login-form').submit();
		 } 

	
}
	$('#login-form input').keydown(function(e) {
		if (e.keyCode == 13) {
			validate();
		}
	});
	//--></script>
<?php //echo $footer; ?> </body></html>