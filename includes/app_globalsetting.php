<?php
        #########################################################################
	#                   Inventory Tool AURSoft.COM                          #
	#                   Developed by AURSoft team                           #
        #                       Copy right 2011 - 				#
	#########################################################################
   //Global application setting
  //error_reporting(E_ALL ^ E_NOTICE);
   // error_reporting(0);
  // Set maximum memory limit
  @ini_set('memory_limit', '128M');
  // Set maximum time limit for script execution
  @set_time_limit(3600); 
  // Register Globals
	if (ini_get('register_globals')) {
		ini_set('session.use_cookies', 'On');
		ini_set('session.use_trans_sid', 'Off'); 
		session_set_cookie_params(0, '/');
		session_start(); 
		$globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES); 
		foreach ($globals as $global) {
			foreach(array_keys($global) as $key) {
				unset($$key);
			}
		}
 	}
  // Magic Quotes Fix
	if (ini_get('magic_quotes_gpc')) {  
		function clean($data) {
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					$data[clean($key)] = clean($value);
				}
			} else {
				$data = stripslashes($data);
			}
		
			return $data;
		}			
		$_GET = clean($_GET);
		$_POST = clean($_POST);
		$_COOKIE = clean($_COOKIE);
    } 
	if (!ini_get('date.timezone')) {
		date_default_timezone_set('UTC');
	}
	// set other related stuff
	  // Windows IIS Compatibility  
		if (!isset($_SERVER['DOCUMENT_ROOT'])) { 
			if (isset($_SERVER['SCRIPT_FILENAME'])) {
				$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
			}
		}
		
		if (!isset($_SERVER['DOCUMENT_ROOT'])) {
			if (isset($_SERVER['PATH_TRANSLATED'])) {
				$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
			}
		}
		
		if (!isset($_SERVER['REQUEST_URI'])) { 
			$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1); 
			
			if (isset($_SERVER['QUERY_STRING'])) { 
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING']; 
			} 
		}
?>