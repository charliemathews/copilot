<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for compiling the response queue and interpreting submissions into json.
*/
class Data {

	private $dataQueue ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$log) {

		$this->dataQueue = array() ;

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

		$encoded_input = array() ;
		$header = array() ;
	
		$header['app'] = APP_NAME ;
		$header['version'] = APP_VERSION ;
		$header['token'] = "xxxx-xxxx-xxxx-xxxx" ;

		$encoded_input['header'] = $header ;
		$encoded_input['data'] = $input ;

		$this->dataQueue[] = json_encode($encoded_input) ;

	}

	/**
	* Function returnStream
	*
	* Returns the JSON response.
	*/

	public function returnStream() {

		foreach($this->dataQueue as $dataPart) {
			return $dataPart ;
		}
		
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
