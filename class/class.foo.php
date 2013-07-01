<?php

namespace app\test ;

class foo {
	
	private $msgLog ;

	public function __construct() {

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
