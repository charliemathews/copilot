<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for compiling responses and interpreting submissions into json.
*/
class Data {

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$m) {

		$this->m = $m ;
		$this->m->add_method(__METHOD__) ;

	}

	/**
	* Function encode
	*
	* Encodes returning data stream into json and adds relevant authentication data.
	*
	* @param string $data contains array of data to be encoded.
	*/
	public function encode(&$data) {

		return json_encode($data) ;

	}

	/**
	* Function decode
	*
	* Decodes received data stream into json.
	*
	* @param string $data contains array of data to be decoded.
	*/
	public function decode(&$data) {

		return json_decode($data) ;

	}


}

?>
