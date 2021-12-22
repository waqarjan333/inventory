<!DOCTYPE html>
<html lang="en">
<head>
<title>Forget Password</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/font-awesome.min.css" />
<style>
p {
    padding-left: 15px;
}
.hide{
    display: none;
}
.Absolute-Center {
  margin: auto;
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
}

.Absolute-Center.is-Responsive {
  width: 80%; 
  height: 50%;
  min-width: 200px;
  max-width: 800px;
  padding: 40px;
  margin-top: 50px;
}


</style>
</head>
<body>
    <div class="container-fluid" style="background: #e9ecef; padding: 10px;">
        <div class="row">
            <div class="col-sm-3">
                <img src="<?php echo $theme; ?>/images/aursoft_logo.png" alt=""/>
            </div>
            <div class="col-sm-3">
                
            </div>
        </div>
    </div>
 <div class="container">
  <div class="row">
    <div class="Absolute-Center is-Responsive">
        <div class="alert alert-success alert-dismissible fade show hide" id="msgAlertSuccess" role="alert" style="margin-left: 15px; width: 80%; height: 30px; padding: 0px;">
            <p id="msgSuccess"></p>
        </div>
        <div class="alert alert-danger alert-dismissible fade show hide" id="msgAlertError" role="alert" style="margin-left: 15px; width: 80%; height: 30px; padding: 0px;">
            <p id="msgError"></p>
            
        </div>
        
      <div class="col-sm-12 col-md-10 col-md-offset-1">
          
          <div id="showUsername">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control input-small" style=" height: 30px; padding: 0;" type="text" id="username" name='username' placeholder="username"/>          
          </div>
          <div class="form-group">
              <button type="button" id="usernameButton" class="col-sm-2 btn btn-def btn-block" style="float: right; color: #FFFFFF; background: #006dcc; margin-left: 10px; height: 30px; padding: 1px; margin-top: -10px;">Next</button>
              <a href="<?php echo $base_url; ?>" class="col-sm-3 btn" id="backToLogin1" style="float: right; color: #FFFFFF; background: #0044cc; height: 30px; padding: 1px; margin-top: -10px;">Back To Login</a>
              
          </div>
          </div>
          <div style="display: none;" id="showAnswer">
            <div class="form-group input-group" id="question1">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input class="form-control" type="text" value="" style=" height: 30px; padding: 0;" name='question1' id="question_1" readonly="readonly"/>          
          </div>
          <div class="form-group input-group" id="answer1">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input class="form-control" type="text" name='answer_1' style=" height: 30px; padding: 0;" id="answer_1" placeholder="Answer"/>          
          </div>
          <div class="form-group input-group" id="question2">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input class="form-control" type="text" value="" style=" height: 30px; padding: 0;" name='question2' id="question_2" readonly="readonly"/>          
          </div>
          <div class="form-group input-group" id="answer2">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input class="form-control" type="text" style=" height: 30px; padding: 0;" name='answer_2' id="answer_2" placeholder="Answer"/>          
          </div>
              <input class="form-control" type="hidden" name='answer1hidden' id="answer1hidden"/>
              <input class="form-control" type="hidden" name='answer2hidden' id="answer2hidden"/>
              <input class="form-control" type="hidden" name='user_hidden_id' id="user_hidden_id"/>
          <div class="form-group">
              <button type="button" id="questionButton" class="col-sm-2 btn btn-def btn-block" style="float: right; color: #FFFFFF; background: #006dcc; margin-left: 10px; height: 30px; padding: 1px; margin-top: -10px;">Next</button>
              <a href="<?php echo $base_url; ?>" class="col-sm-3 btn" id="backToLogin2" style="float: right; color: #FFFFFF; background: #0044cc; height: 30px; padding: 1px; margin-top: -10px;">Back To Login</a>
          </div>
          </div>
          <div style="display: none;" id="showPassword">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input class="form-control" type="password" style=" height: 30px; padding: 0;" name='password' id="pass1" placeholder="New Password"/>     
          </div>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input class="form-control" type="password" name='password' style=" height: 30px; padding: 0;" id="pass2" placeholder="Conform Password"/>     
          </div>
          <div class="form-group">
              <button type="button" class="col-sm-3 btn btn-def btn-block" id="changePass" style="float: right; color: #FFFFFF; background: #006dcc; margin-left: 10px; height: 30px; padding: 1px; margin-top: -10px;">Change Password</button>
              <a href="<?php echo $base_url; ?>" class="col-sm-3 btn" id="backToLogin2" style="float: right; color: #FFFFFF; background: #0044cc; height: 30px; padding: 1px; margin-top: -10px;">Back To Login</a>
          </div> 
          
          </div>
          <div class="form-group" style="display: none;" id="logbtn">
              <input class="form-control" type="hidden" name='updPassword' id="updPassword"/>
              
              <button type="button" class="col-sm-3 btn btn-def btn-block" id="loginBtn" style="float: right; color: #FFFFFF; background: #006dcc; margin-left: 10px; height: 30px; padding: 1px; margin-top: -10px;">Login</button>
              <a href="<?php echo $base_url; ?>" class="col-sm-3 btn" id="backToLogin2" style="float: right; color: #FFFFFF; background: #0044cc; height: 30px; padding: 1px; margin-top: -10px;">Back To Login</a>
              
          </div>
      </div>  
    </div>    
  </div>
</div>
        
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script>
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/bootstrap.min.js"></script>
<script type="text/javascript">
    var checkUsername = '<?php echo $url_checkUserName ?>';
    var updatePass = '<?php echo $url_updatePass ?>';
    var url_login = '<?php echo $url_login; ?>';
    var url_home = '<?php echo $url_home; ?>';
    var url_pos = '<?php echo $url_pos; ?>';

    $(document).ready(function(){
        $("#usernameButton").click(function(){
            $.ajax({
                type: 'POST',
                url: checkUsername,
                data:{
                    username:$("#username").val(),
                },
                success: function(res){
                    var data = jQuery.parseJSON(res);
                    if(data.success==1){
                        $("#showAnswer").show();
                        $("#msgAlertSuccess").show();
                        $("#question_1").val(data['question_1']);
                        $("#question_2").val(data['question_2']);
                        $("#answer1hidden").val(data['answer_1']);
                        $("#answer2hidden").val(data['answer_2']);
                        $("#user_hidden_id").val(data['user_hidden_id']);
                        $("#msgSuccess").text(data['msg']);
                        $('#username').attr('readonly', true);
                        $("#msgAlertError").hide();
                        $("#usernameButton").hide();
                        $("#backToLogin1").hide();
                    } else if(data.success==0){
                        $("#showAnswer").hide();
                        $("#msgAlertError").show();
                        $("#msgAlertSuccess").hide();
                        $("#msgError").text(data['msg']);
                        $("#username").val("").focus();
                    } else {
                        $("#showAnswer").hide();
                        $("#msgAlertError").show();
                        $("#msgAlertSuccess").hide();
                        $("#msgError").text("Something Went Wrong Please Contact Aursoft Company Administrator");
                    }
                }
            });
        });
        
        $("#questionButton").click(function(){
           if($("#answer_1").val()!=$("#answer1hidden").val()){
               $("#msgAlertError").show();
               $("#msgAlertSuccess").hide();
               $("#msgError").text("Answer 1 is wrong Please Enter Correct Answer");
            } else if($("#answer_2").val()!=$("#answer2hidden").val()){
                $("#msgAlertError").show();
                $("#msgAlertSuccess").hide();
               $("#msgError").text("Answer 2 is wrong Please Enter Correct Answer");
            } else if ($("#answer_1").val()==$("#answer1hidden").val() && $("#answer_2").val()==$("#answer2hidden").val()){
                $("#msgAlertError").hide();
               $("#msgAlertSuccess").show();
               $("#msgSuccess").text("Now Enter New Password");
               $("#questionButton").hide();
               $("#showPassword").show();
               $("#backToLogin2").hide();
               $('#answer_1').attr('readonly', true);
               $('#answer_2').attr('readonly', true);
            }
           
        });
        
        $("#changePass").click(function(){
           if($("#pass1").val()!=$("#pass2").val()){
               $("#msgAlertError").show();
               $("#msgAlertSuccess").hide();
               $("#msgError").text("Password Does Not Matching! Please Enter Same Password");
            } else if($("#pass1").val()!="" && $("#pass2").val()!="" & $("#pass1").val()==$("#pass2").val()){
               $.ajax({
                type: 'POST',
                url: updatePass,
                data:{
                    pass:$("#pass2").val(),
                    user_hidden_id : $("#user_hidden_id").val(),
                },
                success: function(res){
                  var data = jQuery.parseJSON(res);
                    $("#showAnswer").show();
                    $("#msgAlertSuccess").show();
                    $("#showUsername").hide();
                    $("#showPassword").hide();
                    $("#showAnswer").hide();
                    $("#logbtn").show();
                    $("#msgSuccess").text(data['msg']);
                    $("#updPassword").val(data['updPassword']);
                }
            }); 
            } else if($("#pass1").val()=="") {
              $("#msgAlertError").show();
              $("#msgAlertSuccess").hide();
               $("#msgError").text("Please Enter New Password");  
            } else if($("#pass").val()=="") {
                $("#msgAlertError").show();
               $("#msgAlertSuccess").hide();
               $("#msgError").text("Please Enter Conform Password");
            } else {
                $("#msgAlertError").show();
               $("#msgAlertSuccess").hide();
               $("#msgError").text("Something went Wrong! Please Contact Aursoft Company");
            }
           
        });
        
        $("#loginBtn").click(function(){
            $.ajax({
                type: 'POST',
                url: url_login,
                data:{
                    username:$("#username").val(),
                    password:$("#updPassword").val(),
                },
                success: function(data){
                    var obj = jQuery.parseJSON(data);
                    if(obj.success && obj.success===true){
                    if(obj.type=="1"){
                        window.location = url_pos;
                    } 
                    else{
                        window.location = url_home;
                    }
                  }
                }
            });
        });
     });
</script>
    </body>
</html>