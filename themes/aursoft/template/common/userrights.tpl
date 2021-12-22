<!DOCTYPE html>
<html>
<head>
<title>User Rights API</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/ui-responsive.css" />   
    <style>
        .right-check label{
            margin-right:10px;
            float: left;
        }
        .clearboth{
            clear: both;
        }
        h6{
            clear:both;
        }
    </style>
   
</head>
<body style="margin: 20px;">
    
    <h3>
        User Rights Access
    </h3>
    <div class="rights_panel">
        
    </div>
    <hr />
    <div>
        <textarea style="width:800px;height:300px" id="json" readonly="readonly" ></textarea>
    </div>
    <button class="btn btn-primary btn-update"> Update Rights</button>
    
    
        
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script> 
    <script type="text/javascript">
        var user_rights = null;
        $(function(){
              $.ajax({
                type: 'GET',
                url: "<?php echo $url_getrights; ?>",
                data:{                           
                    user_id:32
                },
                success: function(data){
                    //alert(data);
                    var user_access = jQuery.parseJSON(data);
                    $("#json").val(decodeHTML(user_access.user_rights));
                    user_rights = jQuery.parseJSON(decodeHTML(user_access.user_rights));
                    //alert(JSON.stringify(user_rights.user_access));
                    var rights_html = "";
                    $.each( user_rights.user_access, function( key, value ) {
                        rights_html = "<div class='"+key+"'><h6>"+value.label+"</h6>";
                        
                        if(value.actions){
                            rights_html +="<div class='right-check'>";
                            $.each(value.actions,function(k,val){
                                var checked = val ? "checked":"";
                                rights_html += "<label><input type='checkbox' "+checked+" data-parentkey='"+key+"' data-key='"+k+"' /> "+k+"</label>";
                            })
                            
                            rights_html +="</div>";
                        }
                        rights_html +="</div>";
                        if(!value.parent){
                            $(".rights_panel").append(rights_html);
                            $(".rights_panel").append("<hr class='clearboth' />");
                        }
                        else{
                            $(".rights_panel ."+value.parent).append(rights_html);
                        }
                    });
                    
                    $(".rights_panel input[type='checkbox']").change(function(){
                        var checkbox = $(this);
                        //alert(JSON.stringify(checkbox));
                        user_rights.user_access[checkbox.data("parentkey")].actions[checkbox.data("key")] = this.checked;    
                        $("#json").val(JSON.stringify(user_rights));
                    })
                }
              });
              
              $(".btn-update").click(function(){
                  
                  $.ajax({
                    type: 'POST',
                    url: "<?php echo $url_saverights; ?>",
                    data:{                           
                        user_id:32,
                        user_rights: $("#json").val()
                    },
                    success: function(data){                        
                        var result = jQuery.parseJSON(data);
                        if(result.success=="1"){
                            alert('Rights updated Successfully')
                        }
                        else{
                            alert(result.error);
                        }

                    }
                  });
                  
              })
        });
        
        function decodeHTML(str) {
        //decoding HTML entites to show in textfield and text area 				
            if(typeof(str)!=="undefined"){
                str = str.replace(/&amp;/g, "&");
                str = str.replace(/&#58;/g, ":");
                str = str.replace(/&#39;/g, "\'");                
                str = str.replace(/&#40;/g, "(");
                str = str.replace(/&#41;/g, ")");
                str = str.replace(/&lt;/g, "<");
                str = str.replace(/&gt;/g, ">");
                str = str.replace(/&gt;/g, ">");                
                str = str.replace(/&#9;/g, "\t");
                str = str.replace(/&nbsp;/g, " ");
                str = str.replace(/&quot;/g, "\"");
                str = str.replace(/&#8216;/g, "‘");      
                str = str.replace(/&#61;/g, "=");    
            }
            else{
                str = "";
            }
        return str;
        }
        
    </script>
    
</body>
</html>