<div id="sidebar">
 <ul class="nav">
    <li id="dashboard"><a class="headitem dashboards"><?php echo $text_dashboard; ?></a>
    <ul><li><a href="<?php echo $home; ?>"><?php echo $text_dashboard; ?></a></li></ul>
    </li> 
    
    <li id="cms" style="display: none" ><a class="headitem cms"><?php echo $text_cms; ?></a>
      <ul>
      	<li><a href="<?php echo $cmsblocks; ?>">Blocks</a></li> 
      	<li><a href="<?php echo $cms; ?>"><?php echo $text_cms; ?></a></li> 
        <li><a href="<?php echo $cmsmenu; ?>"><?php echo $text_cmsmenu; ?></a></li> 
        <!--<li><a href="<?php echo $homeslider; ?>">Home slider</a></li>  
        <li><a href="<?php echo $news; ?>"><?php echo $text_news; ?></a></li> 
        <li><a href="<?php echo $faqs; ?>"><?php echo $text_faqs; ?></a></li>-->
      </ul>
    </li>  
     
    
     <li id="users"><a class="headitem member"><?php echo $text_user; ?></a>
          <ul>
            <li><a href="index.php?route=user/siteusers">Site user</a></li>
            <li><a href="<?php echo $user; ?>"><?php echo $text_users; ?></a></li>
            <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li> 
          </ul>
    </li> 
    <li id="system"><a class="headitem system"><?php echo $text_system; ?></a>
      <ul>
        <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li> 
         <li><a href="index.php?route=seo/seo">Custom seo url</a></li>  
        <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
        <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
      </ul>
    </li>
    
    <li style="display: none"><a class="headitem localization"><?php echo $text_localisation; ?></a>
          <ul> 
            <li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li> 
            <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li> 
            <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li> 
          </ul>
     </li>
    
     <li id="helps"><a class="headitem helps"><?php echo $txt_helps; ?></a>
      <ul>
        <li><a href="<?php echo $helps; ?>"><?php echo $txt_helps; ?></a></li>
      </ul>
      </li>
  </ul> 
</div>
