<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP\API ;

/**
* Points API calls to actual functions.
*/
class Adapter {

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$app) {

		$this->app = $app ;
		$this->app->log->add_method(__METHOD__) ;

	}

	public function testGet1($f1) {
		echo "hello! " . $f1 ;
	}

	public function testGet2($vars) {
		foreach($vars as $var) {
				echo $var."<br>";
			}
	}

	public function doPost($input) {

	}

	public function doPut($input) {

	}

	public function doDelete($input) {

	}

}

?>
