<?php 
	#########################################################################
	#                   Inventory Tool AURSoft.COM                          #
	#                   Developed by AURSoft team                           #
        #                       Copy right 2012 - 				#
	#########################################################################
#  
# MAIN APPLICATION SETTINGS
#
# A - Over All admin
# S - Site Admin 
if(ADMIN=='A'){
	define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/'); 
	//define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/admin/'); 
	define('HTTP_CATALOG', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/'); 
	// HTTPS
        
	define('HTTPS_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/');
	//define('HTTPS_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/admin/');
	define('HTTPS_IMAGE', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/admin','/',rtrim(dirname($_SERVER['PHP_SELF']), '/.\\')) . '/images/');
	define('HTTP_IMAGE', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/images/');
	define('DIR_APP', ROOT . '/admin/'); 
	define('DIR_LANGUAGE', DIR_APP. 'language/');
	define('DIR_TEMPLATE', ROOT. '/themes/admin/template/');
       
        
} 
else if (ADMIN =='S'){
         define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/'); 
	//define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/admin/'); 
	define('HTTP_CATALOG', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/'); 
	// HTTPS
        
	define('HTTPS_SERVER', 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/');
	//define('HTTPS_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/admin/');
	define('HTTPS_IMAGE', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/admin','/',rtrim(dirname($_SERVER['PHP_SELF']), '/.\\'))  . '/images/');
	define('HTTP_IMAGE', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/images/');
	define('DIR_APP', ROOT . '/sadmin/'); 
	define('DIR_LANGUAGE', DIR_APP. 'language/');
	define('DIR_TEMPLATE', ROOT. '/themes/sadmin/template/');
}
else {
        
	define('DIR_APP', ROOT . '/app/'); 
	define('DIR_TEMPLATE', ROOT. '/themes/');
	define('DIR_LANGUAGE', DIR_APP. '/language/');
        define('INVOICE_STR', 'INVOICE-');
        define('COMPLETE_URL', 'http://' . $_SERVER['HTTP_HOST']  . $_SERVER["REQUEST_URI"]);
} 
// Defin Kannel Host.

define("CONFIG_KANNEL_HOST","115.167.32.74");

define('DIR_INC',  ROOT .'/includes/');
define('DIR_DB',  DIR_INC .'database/');
define('DIR_CACHE',  ROOT .'/cache/');
define('DIR_DOWNLOAD',  ROOT .'/download/');
define('DIR_LOGS', DIR_INC .'logs/');
define('DIR_IMAGE', ROOT . '/images/');
define('DIR_THUMBNAILS', DIR_IMAGE . 'thumbnails/'); 
define('DIR_CONFIG',  ROOT .'/config/');
define('DIR_CATALOG', ROOT .'/');
define('DIR_UPLOAD', 'files/');
//Defining users types with codes
define('USER_ADMIN', '1');
define('USER_MUNSHI', '2');
// path and other configurations
$configs = array(); 

# Define host directory depending on the current connection
$configs['current_path'] = (HTTPS) ? HTTPS_PATH: HTTP_PATH;
//paths of the 
$configs['http_location'] = 'http://' .HTTP_HOST . HTTP_PATH;
$configs['https_location'] = 'https://' . HTTPS_HOST .HTTPS_PATH;
$configs['current_location'] = (HTTPS) ? $configs['https_location'] : $configs['http_location'];

# List of forbinned file extensions (for uploaded files)
$configs['forbidden_file_extensions'] = array (
	'php',
	'php3',
	'pl',
	'com',
	'exe',
	'bat',
	'cgi',
	'htaccess'
);

# Locations that can be viewed via secure connection (siteusers area)
$configs['secure_controllers'] = array (
	'checkout',
	'payment_notification',
	'auth',
	'profiles',
	'image_verification',
	'orders',
	'pages'
);

#
# Misc options
#
$configs['compression'] = array (
	'js_compression' => false // enables compession to reduce size of javascript files
);
// Key for sensitive data encryption
$configs['en_key'] = 'haha';

//FIX ME: Set configuration options from config.php to registry
//Registry::set('config', $config);
//unset($config);
 


#  
# SOME Static options 
# 

// Week days
define('SUNDAY',    0);
define('MONDAY',    1);
define('TUESDAY',   2);
define('WEDNESDAY', 3);
define('THURSDAY',  4);
define('FRIDAY',    5);
define('SATURDAY',  6);

// Controller return statuses
define('REDIRECT', 302);
define('STATUS_OK', 200);
define('NO_PAGE', 404);
define('DENIED', 403);
// Maximum number of items in "Last edited items" list (administrative area)
define('LAST_EDITED_ITEMS_COUNT', 10);

// Product filters settings
define('FILTERS_RANGES_COUNT', 10);
define('FILTERS_RANGES_MORE_COUNT', 20);

// Meta description auto generation
define('AUTO_META_DESCRIPTION', true);

// Session name
define('SESS_NAME', 'sess_id');

// SEF urls delimiter
define('SEO_DELIMITER', '-');

// Live time for permanent cookies (currency, language, etc...)
define('COOKIE_ALIVE_TIME', 60 * 60 * 24 * 7); // one week

// Session live time
define('SESSION_ALIVE_TIME', 60 * 60 * 2); // 2 hours

// Sessions storage live time
define('SESSIONS_STORAGE_ALIVE_TIME',  60 * 60 * 24 * 7 * 2); // 2 weeks

// Number of seconds after last session update, while user considered as online
define('SESSION_ONLINE', 60 * 5); // 5 minutes

// Number of seconds before installation script will be redirected to itself to avoid server timeouts
define('INSTALL_DB_EXECUTION', 60 * 60); // 1 hour

// Uncomment this line if you experience problems with mysql5 server (disables strict mode)
//define('MYSQL5', true);

// The number of seconds after which the execution of query is considered to be long
define('LONG_QUERY_TIME', 3);

if (defined('MYSQL5')) {
	//db_query("set @@sql_mode = ''");
}


?>
