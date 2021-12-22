<?php
	#########################################################################
	#           Inventory Flow Developed by AURSoft.COM                     #
	#                   Developed by AURSoft team                           #
        #                       Copy right 2011 - 				#
	#########################################################################
          
//load database setting and check for the db installed correctly
require_once (ROOT . DS . 'db_config.php');

//load other setting

  // Require configuration  which include database related stuffs
   require(ROOT . DS . 'includes' . DS .'config.php');
  //setting the memory and ini etc setting
   require(ROOT . DS . 'includes' . DS .'app_globalsetting.php');
	/*FIX ME: remove this part
	  if (isset($_REQUEST['check_https'])) {
		  die(defined('HTTPS') ? 'OK' : '');
	  }
	//include all class
	#class files
	$dh = @opendir(DIR_ROOT . DS ."includes". DS ."classes");
	while (($file = @readdir($dh)) !== false) {
		if($file<>"." && $file<>".." && substr($file,0,1)<>"_") {
				require_once(DIR_ROOT . DS ."includes". DS ."classes".DS.$file);
		}
	}
	@closedir($dh);
	*/ 

	//load now the files which are needed 
	require_once(DIR_INC . 'engine/action.php'); 
	require_once(DIR_INC . 'engine/controller.php');
	require_once(DIR_INC . 'engine/front.php');
	require_once(DIR_INC . 'engine/loader.php'); 
	require_once(DIR_INC . 'engine/model.php');
	require_once(DIR_INC . 'engine/registry.php');
	
	// Common
	require_once(DIR_INC . 'lib/seourl.php');
	require_once(DIR_INC . 'lib/cache.php');
	require_once(DIR_INC . 'lib/config.php');
	require_once(DIR_INC . 'lib/db.php');
	require_once(DIR_INC . 'lib/document.php');
	require_once(DIR_INC . 'lib/image.php');
	require_once(DIR_INC . 'lib/language.php');
	require_once(DIR_INC . 'lib/log.php');
	require_once(DIR_INC . 'lib/mail.php');
	
	require_once(DIR_INC . 'lib/request.php');
	require_once(DIR_INC . 'lib/response.php');
	require_once(DIR_INC . 'lib/session.php');
	require_once(DIR_INC . 'lib/template.php');
	
	// Application Classes
        # A - Over All admin
        # S - Site Admin 
	if(ADMIN=='A' || ADMIN=='S'){
		require_once(DIR_INC . 'lib/user.php');
		require_once(DIR_INC . 'lib/pagination.php');
	} 
        else {
		require_once(DIR_INC . 'lib/siteusers.php');
		require_once(DIR_INC . 'lib/sitemap.php');
	}
	require_once(DIR_INC . 'lib/currency.php');	
	
	$loc = 1;
?>
