<?php
final class DB {
	private $driver;
	
	public function __construct($driver, $hostname, $username, $password, $database) { 
		if (version_compare(phpversion(), '5.1.0', '>') ) {
			file_exists( DIR_DB. $driver . '.php');
			require_once(DIR_DB . $driver . '.php');
		} else {
			//exit('Error: Could not load database file ' . $driver . '!');
			file_exists( DIR_DB. $driver . '5.php');
			require_once(DIR_DB . $driver . '5.php');
		}
				
		$this->driver = new $driver($hostname, $username, $password, $database);
	}
		
  	public function query($sql) {
		return $this->driver->query($sql);
  	}
        
	
	public function escape($value) {
		return $this->driver->escape($value);
	}
	
  	public function countAffected() {
		return $this->driver->countAffected();
  	}

  	public function getLastId() {
		return $this->driver->getLastId();
  	}	
        
        //Helping function for app user
        public function limit($data) {
            $query = '';
            if (isset($data['start']) || isset($data['limit'])) {
                    if ($data['start'] < 0) {
                            $data['start'] = 0;
                    } 
                    if ($data['limit'] < 1) {
                            $data['limit'] = 20;
                    }	 
                    $query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }	 
            return $query;
  	}
}
?>