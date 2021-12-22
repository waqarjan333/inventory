<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <form method="post" action="pdf.php"  id="report_pdf_form">
        <input type="hidden" name="report_id" />
        <input type="hidden" name="report_name" />
        <input type="hidden" name="report_file" id="report_file" />
        <input type="hidde" name="server_path" id="server_path" />
	<input type="hidden" name="report_html" id="report_html" value="<html><body>No Data Found </body></html>" />        
    </form>  

</body>
</html>

