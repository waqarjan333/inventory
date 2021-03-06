<?php 
	#########################################################################
	#           Asset Management Tool AURSoft.COM       			#
	#              Developed by AURSoft team                                #
	#              copy right 2009 - 					#
	#########################################################################
#Checking compatibility and declaring product version:
define('VERSION', '1.0.0'); 
// Error Reporting
//FIX ME::::if development then  show else restric
error_reporting(E_ALL);  
// Check Version
if (version_compare(phpversion(), '5.1.0', '<') == TRUE) {
  exit('Website required atleast -----PHP5.1+ ----- to be installed on your server');
} 
#Declare the Global variables: 
define('ADMIN','A');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
require_once (ROOT . DS . 'includes' . DS . 'bootstrap.php');  
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
// Session
$registry->set('session', new Session()); 
// Cache
$registry->set('cache', new Cache()); 
// Document
$registry->set('document', new Document()); 
// Language
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
$config->set('config_language_id', $languages[$config->get('config_admin_language')]['language_id']); 
$language = new Language($languages[$config->get('config_admin_language')]['directory']);
$language->load($languages[$config->get('config_admin_language')]['filename']);	
$registry->set('language', $language); 
// Currency
$registry->set('currency', new Currency($registry)); 
// User
$registry->set('user', new User($registry)); 
// Front Controller
$controller = new Front($registry); 
// Login
$controller->addPreAction(new Action('common/home/login')); 
// Permission
$controller->addPreAction(new Action('common/home/permission')); 
// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/home');
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