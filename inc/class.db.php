<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Database connection.
*/
class DB {

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$log, $host, $dbname, $user, $pass) {

		$this->log = $log ;

		try {

			// MySQL with PDO_MYSQL
			$DBH = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

			// Set strict error mode.
			$DBH->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

			$this->log->add("Initializing database connection at " . $host . ".", 'LOG') ;

		}
		catch(PDOException $e){

			echo $e->getMessage();

			$this->log->add("Database connection to " . $host . " failed.", 'LOG') ;

		}

	}

	public function close() {

		$this->DBH = null ;

	}

}