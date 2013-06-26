<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Handles all published errors and messages (logs).
*/
class Log {

	private $messages ;

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
	* Function add_method
	*
	* Logs method creation.
	*
	* @param string $method should contain __METHOD__.
	*/
	public function add_method($method) {

		$this->messages[] = array('msg'=>($method. ' initiated.'), 'type'=>'LOG') ;

	}

	/**
	* Function display
	*
	* Returns messages and errors based on the requested $type.
	*
	* @param string $type defines what type of message is being returned.
	*/
	public function display($type) {

		for($i = 0 ; $i < count($this->messages); $i++) {

			if($type == '*') {

				$cached_msg = $this->messages[$i]['msg'] ;
				$cached_type = $this->messages[$i]['type'] ;

			} elseif($this->messages[$i]['type'] == $type) {

				$cached_msg = $this->messages[$i]['msg'] ;
				$cached_type = $this->messages[$i]['type'] ;

			}

			$cache[] = array('msg'=>$cached_msg, 'type'=>$cached_type) ;
		}

		return json_encode($cache) ;

	}

	/**
	* Function display_fancy
	*
	* Returns messages and errors based on the requested $type, pre-formatted for html.
	*
	* @param string $type defines what type of message is being returned.
	*/
	public function display_fancy($type) {

		for($i = 0 ; $i < count($this->messages); $i++) {
			if($type == '*') {

				$cached_msg = $this->messages[$i]['msg'] ;
				$cached_type = $this->messages[$i]['type'] ;

			} elseif($this->messages[$i]['type'] == $type) {

				$cached_msg = $this->messages[$i]['msg'] ;
				$cached_type = $this->messages[$i]['type'] ;

			}

			echo $cached_type . ': ' . $cached_msg . '<br>', PHP_EOL ;
		}

	}

}

?>
