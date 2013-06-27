<?php

namespace app\test ;

class foo {

	private $greeting ;
	private $msgLog ;

	public function __construct() {

		$this->msgLog = array() ;

		$this->greeting = "Hello world." ;
		$this->msgLog[] = $this->greeting ;

	}

	public static function staticfunctiontest() {
		$this->msgLog[] = __METHOD__ ;
	}

	public function childfunctiontest() {
		$this->msgLog[] = __METHOD__ ;
	}

	public function returnLog() { return $this->msgLog; }

}

?>
