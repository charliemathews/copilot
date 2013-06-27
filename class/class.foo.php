<?php

namespace test ;

class foo {

	private $greeting ;

	public function __construct() {

		$this->greeting = "Hello world." ;
		echo $this->greeting ;

	}

	public static function test() {
		echo "wow" ;
	}

}

?>
