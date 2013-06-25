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
	public function __construct(&$m, $host, $dbname, $user, $pass) {

		try {

			// MySQL with PDO_MYSQL
			$DBH = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

			// Set strict error mode.
			$DBH->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

			$this->m = $m ;
			$this->m->add_method(__METHOD__) ;

		}
		catch(PDOException $e){

			echo $e->getMessage();

			$m->add("DB connection failed.", 'LOG') ;

		}

	}

	public function close() {

		$this->DBH = null ;

	}

}