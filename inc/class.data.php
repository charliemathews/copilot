<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for compiling the response queue and interpreting submissions into json.
*/
class Data {

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$log) {

		$this->log = $log ;

	}

	/**
	* Function encode
	*
	* Encodes returning data stream into json and adds relevant authentication data.
	*
	* @param string $data contains array of data to be encoded.
	*/
	public function encode(&$input) {

		return json_encode($input) ;

	}

	/**
	* Function decode
	*
	* Decodes received data stream into json.
	*
	* @param string $data contains array of data to be decoded.
	*/
	public function decode(&$input) {

		return json_decode($input) ;

	}


}

?>
