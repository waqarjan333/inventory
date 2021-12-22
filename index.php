<?php 

	#########################################################################
        #                   Inventory Tool AURSoft.COM                          #
	#                   Developed by AURSoft team                           #
        #                       Copy right 2012 - 				#
	#########################################################################
        
//SAY NO TO IE6
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')){
	header("Location:ie6.html");
}
#Checking compatibility and declaring product version:
define('VERSION', '1.0.0');  
// Error Reporting
//FIX ME::::if development then  show else restric
error_reporting(E_ERROR | E_PARSE);
 
// Check Version
if (version_compare(phpversion(), '5.1.0', '<') == TRUE) {
  exit('website required atleast -----PHP5.1+');
} 
define('ADMIN','C');
#Declare the Global variables: 
define('DS', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(dirname(__FILE__)));
define('ROOT', dirname(__FILE__));
//load other setting
require_once (ROOT . DS .'includes' . DS . 'bootstrap.php');  
// Registry
$registry = new Registry(); 
// Loader
$loader = new Loader($registry);
$registry->set('load', $loader); 
// Config
$config = new Config();
$registry->set('config', $config); 
// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db); 
// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting"); 
foreach ($query->rows as $setting) {
	$config->set($setting['key'], $setting['value']);
} 
define('HTTP_SERVER', $config->get('config_url'));
define('HTTP_IMAGE', HTTP_SERVER . 'images/'); 
if ($config->get('config_ssl')) {
	define('HTTPS_SERVER', 'https://' . substr($config->get('config_url'), 7));
	define('HTTPS_IMAGE', HTTPS_SERVER . 'images/');	
} else {
	define('HTTPS_SERVER', HTTP_SERVER);
	define('HTTPS_IMAGE', HTTP_IMAGE);	
} 
// Log 
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);  
set_error_handler('error_handler'); 
// Request
$request = new Request();
$registry->set('request', $request); 
// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response); 
// Cache
$registry->set('cache', new Cache()); 
// Session
$session = new Session();
$registry->set('session', $session); 
// Document
$registry->set('document', new Document()); 
// Language Detection
$languages = array(); 
$query = $db->query("SELECT * FROM " . DB_PREFIX . "language");  
foreach ($query->rows as $result) {
	$languages[$result['code']] = array(
		'language_id' => $result['language_id'],
		'name'        => $result['name'],
		'code'        => $result['code'],
		'locale'      => $result['locale'],
		'directory'   => $result['directory'],
		'filename'    => $result['filename']
	);
} 
$detect = ''; 
if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && ($request->server['HTTP_ACCEPT_LANGUAGE'])) { 
	$browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']); 
	foreach ($browser_languages as $browser_language) {
		foreach ($languages as $key => $value) {
			$locale = explode(',', $value['locale']); 
			if (in_array($browser_language, $locale)) {
				$detect = $key;
			}
		}
	}
} 



$code = $config->get('config_language');
if (!isset($session->data['language']) || $session->data['language'] != $code) {
	$session->data['language'] = $code;
} 
if (!isset($request->cookie['language']) || $request->cookie['language'] != $code) {	  
	setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
} 

$config->set('config_language_id', $languages[$code]['language_id']); 
$language = new Language($languages[$code]['directory']);
$language->load($languages[$code]['filename']);		
$registry->set('language', $language); 


// Customer
$registry->set('siteusers', new Siteusers($registry)); 

$registry->set('sitemap', new sitemaps($registry)); 
// Currency
$registry->set('currency', new Currency($registry));  
// Cart

//Set themes variable globally
$themes = 'themes/'.$config->get('config_template');
$registry->set('themes', $themes);

//Seo url class
$seourls = new Seourl($registry);
$registry->set('seourls', $seourls);
$seourls->cleanurl();  // change of the above controller call
// Front Controller  
$controller = new Front($registry);  
// Router
if (isset($request->get['route'])) {
        //echo $request->get['route'];
	$action = new Action($request->get['route']);
} else {
	$action = new Action('login/login');
} 
// Dispatch
$controller->dispatch($action, new Action('error/not_found')); 
// Output
$response->output(); 
// Error Handler
function error_handler($errno, $errstr, $errfile, $errline) {
	global $config, $log; 
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	} 
	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	} 
	return TRUE;
} 
// Error Handler
?>