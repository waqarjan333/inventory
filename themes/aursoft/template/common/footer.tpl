<?php  
/* Copyright (c) 2011 AurSoft
 * Footer side of App
 * Created Date: 11 October 2012
 * Craeted By: Umair shahid
 * Modified Date: 
 */
?>
<script type="text/javascript">
  Ext.onReady(function(){
  });
  var print_url = {
        "print_list":"<?php echo $printlist ?>" 
    }
</script>
<iframe src="<?php echo $print ?>" height="1px" width="1px" id="print_iframe" class="print-frame" frameborder="0" ></iframe>
<iframe src="<?php echo $print_journal ?>" height="1px" width="1px" id="print_journal"  frameborder="0" ></iframe>
<iframe src="<?php echo $print ?>" height="1px" width="1px" id="print_batch_iframe" class="print-frame" frameborder="0" ></iframe>
<iframe src="<?php echo $print_register ?>" height="1px" width="1px" id="print_register_iframe" class="print-frame" frameborder="0" ></iframe>
<iframe src="<?php echo $print_register_payment ?>" height="1px" width="1px" id="print_register__payment_iframe" class="print-frame" frameborder="0" ></iframe>
<iframe src="<?php echo $create_pdf ?>" height="1px" width="1px" id="print_pdf_iframe" class="pdf-frame" frameborder="0" ></iframe>


</body>
</html>