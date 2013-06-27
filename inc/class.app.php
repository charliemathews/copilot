<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP\APP ;

/**
* Encapsulation of classes in the cp\app namespace.
*/
class APP {

	public $log ;
	public $data ;
	public $db_local ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {
		
		//Initiate APP
		$this->log = new Log() ;
		$this->db_local = new DB($this->log, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASS_LOCAL) ;
		$this->data = new Data($this->log) ;

	}

}

?>
