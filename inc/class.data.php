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
	* Queues up data that the program wishes to return.
	*
	* @param string $input contains the new data array or object to add to queue.
	*/
	public function add($input) {
		$this->dataQueue[] = $input ;
	}

	/**
	* Function encode
	*
	* Encodes returning data stream into json and adds relevant authentication data.
	*/
	private function encoder() {

		$output = array() ;
		$header = array() ;
	
		$header['app'] = APP_NAME ;
		$header['version'] = APP_VERSION ;
		$header['token'] = "xxxx-xxxx-xxxx-xxxx" ;

		$output['header'] = $header ;

		foreach($this->dataQueue as $dataPart) {
			$output['data'][] = $dataPart ;
		}

		return json_encode($output) ;

	}

	/**
	* Function returnStream
	*
	* Returns the JSON response.
	*/
	public function returnStream() {

		return $this->encoder() ;
		
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
