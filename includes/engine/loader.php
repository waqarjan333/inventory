<?php
final class Loader {
	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
	
	public function library($library) {
		$file = DIR_INC . 'lib/' . $library . '.php';
		
		if (file_exists($file)) {
			include_once($file);
		} else {
			exit('Error: Could not load library ' . $library . '!');
		}
	}
	
	public function model($model) {
		$file  = DIR_APP . 'model/' . $model . '.php';
		$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
		
		if (file_exists($file)) {
			include_once($file);
			
			$this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
		} else {
			exit('Error: Could not load model ' . $model . '!');
		}
	}
	 
	public function database($driver, $hostname, $username, $password, $database, $prefix = NULL, $charset = 'UTF8') {
		$file  = DIR_INC . 'database/' . $driver . '.php';
		$class = 'Database' . preg_replace('/[^a-zA-Z0-9]/', '', $driver);
		echo $file;
		if (file_exists($file)) {
			include_once($file);
			
			$this->registry->set(str_replace('/', '_', $driver), new $class());
		} else {
			exit('Error: Could not load database ' . $driver . '!'); 
		}
	}
	
	public function helper($helper) {
		$file = DIR_INC . 'lib/' . $helper . '.php';
	
		if (file_exists($file)) {
			include_once($file);
		} else {
			exit('Error: Could not load helper ' . $helper . '!');
		}
	}
	
	public function config($config) {
		$this->config->load($config);
	}
	
	public function language($language) {
		$this->language->load($language);
	}
	
} 
?>