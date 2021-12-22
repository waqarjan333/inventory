<!DOCTYPE html>
<html lang="en">
<head>
<title>Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $get_url; ?><?php echo $theme; ?>/stylesheet/reports.css" />
</head>
<body>    
    <form method="post" action="<?php echo $get_url_custom; ?>" id="report_form">
        <input type="hidden" name="report_id" />
        <input type="hidden" name="report_name" />        
        <input type="hidden" name="start_date" /> 
        <input type="hidden" name="end_date" />           
    </form>  
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script>     
<script type="text/javascript">
    
    $(function(){ 
        if(top.reports_obj){            
            top.reports_obj.unMask();
            top.reports_obj.isLoaded=true;      
            top.reports_obj.getCustomReport();
        }
    });
    function generate_report(params){
        if(params){            
            $("input[name='report_id']").val(params.report_id);
            $("input[name='report_name']").val(params.report_name);            
            $("input[name='end_date']").val(params.end_date);  
            if(params.start_date){
                $("input[name='start_date']").val(params.start_date);     
            }
            
            $("#report_form")[0].submit();
        }
                 
        
    }
    var month_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    function getDate(_date){        
        return _date.getDate()+" "+month_array[_date.getMonth()]+" "+_date.getFullYear();
    }
    
    function getDateFromSql(d){
        var _date = "";
        if(d){
            var dt = d.split(" ");
            var split_date = dt[0].split("-");
            _date =  month_array[parseInt(split_date[1])-1]+" "+split_date[2] +", "+split_date[0];
        }
        return _date;
    }
</script>
</body>
</html>