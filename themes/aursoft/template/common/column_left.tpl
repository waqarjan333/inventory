<?php  
/* Copyright (c) 2011 AurSoft
 * Left side of App
 * Created Date: 11 October 2012
 * Craeted By: Umair shahid
 * Modified Date: 
 */
?>
<script type="text/javascript">
    var urls = {
                logout:'<?php echo $url_logout; ?>',
                pos : '<?php echo $url_pos; ?>',
                };
    var linktext ={};
    linktext.home = '<?php echo $text_home ?>';
    linktext.reminders = 'Reminders';
    linktext.pos = '<?php echo $text_pos ?>';
    linktext.dashboard = '<?php echo $text_dashboard ?>';
    linktext.accounts = '<?php echo $text_accounts ?>';
    linktext.price_level = '<?php echo $text_price_level ?>';
    linktext.salesreps = '<?php echo $text_salesreps ?>';
    linktext.journal = '<?php echo $text_journal ?>';
    linktext.register = '<?php echo $text_register ?>';
    linktext.reports = '<?php echo $text_reports ?>';
    linktext.settings = '<?php echo $text_settings ?>';
    linktext.sms = '<?php echo $text_sms ?>';
    linktext.logout = '<?php echo $text_logout ?>';
</script>
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/app/left_column.js"></script>  

