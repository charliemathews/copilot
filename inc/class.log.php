<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Handles all published errors and messages (logs).
*
* This object is currently being initialized public so that anyone anywhere can access it.
*/
class Log {

	private $messages ;
	public $timer ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {

		$this->messages = array() ;
		
	}


	/**
	* Function add
	*
	* Logs messages and errors based on their $type.
	*
	* @param string $msg contains message to be logged.
	* @param string $type defines what kind of message is being logged.
	*/
	public function add($msg, $type) {

		$this->messages[] = array('msg'=>$msg, 'type'=>$type) ;

	}


	/**
	* Function addMethod
	*
	* Logs method creation.
	*
	* @param string $method should contain __METHOD__.
	*/
	public function addMethod($method) {

		$this->messages[] = array('msg'=>($method. ' initiated.'), 'type'=>'LOG') ;

	}


	private function parseLog($row, $type) {

		if($type == '*' || $this->messages[$row]['type'] == $type) {

			return array($this->messages[$row]['msg'], $this->messages[$row]['type']) ;

		} else {

			return array(null, null) ;

		}

	}


	/**
	* Function display
	*
	* Returns messages and errors based on the requested $type.
	*
	* @param string $type defines what type of message is being returned.
	*/
	public function display($type) {

		$cache = array() ;

		$msgCount = count($this->messages) ;

		for($i = 0 ; $i < $msgCount; ++$i) {

			$temp = $this->parseLog($i, $type) ;

			if($temp[0] != null) $cache[] = array('msg'=>$temp[0], 'type'=>$temp[1]) ;
		}

		return $cache ;

	}


	/**
	* Function display_fancy
	*
	* Returns messages and errors based on the requested $type, pre-formatted for html.
	*
	* @param string $type defines what type of message is being returned.
	*/
	public function displayFancy($type) {

		for($i = 0 ; $i < count($this->messages); ++$i) {

			$temp = $this->parseLog($i, $type) ;	

			echo '<span style="font-weight: bold;">' . $temp[1] . '</span>: ' . $temp[0] . '<br>', PHP_EOL ;

		}

	}

}

?>
