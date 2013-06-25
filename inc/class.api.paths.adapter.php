<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

namespace CP\API ;

/**
* Constructs the API.
*/
class Adapter {

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {

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
