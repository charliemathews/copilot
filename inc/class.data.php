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
	public function __construct(Log &$log) {

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
	public function add($name, $input) {
		$this->dataQueue[] = array("name"=>$name, "data"=>$input) ;
	}

	/**
	* Function encode
	*
	* Encodes returning data stream into json and adds relevant authentication data.
	*/
	private function encoder() {

		$output = array() ;

		$token = $this->random_text("alnum", 32) ;

		$output['header'] = array(	'app'=>APP_NAME, 
									'version'=>APP_VERSION,
									'time'=>$this->log->timer,
									'token'=>$token // every transaction is issued a token by the API. The server remains stateless, this is just a historical tracking tool.
								 );

		foreach($this->dataQueue as $dataPart) {
			$output['blocks'][] = $dataPart ;
		}

		$logOutput = $this->log->display('*') ;

		foreach($logOutput as $log) {
			$output['log'][] = $log ;
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

	function random_text( $type = 'alnum', $length = 8 ) {

		switch ( $type ) {
			case 'alnum':
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'alpha':
				$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'hexdec':
				$pool = '0123456789abcdef';
				break;
			case 'numeric':
				$pool = '0123456789';
				break;
			case 'nozero':
				$pool = '123456789';
				break;
			case 'distinct':
				$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
				break;
			default:
				$pool = (string) $type;
				break;
		}
 
		$crypto_rand_secure = function ( $min, $max ) {
			$range = $max - $min;
			if ( $range < 0 ) return $min; // not so random...
			$log    = log( $range, 2 );
			$bytes  = (int) ( $log / 8 ) + 1; // length in bytes
			$bits   = (int) $log + 1; // length in bits
			$filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ( $rnd >= $range );
			return $min + $rnd;
		};
 
		$token = "";
		$max   = strlen( $pool );
		for ( $i = 0; $i < $length; $i++ ) {
			$token .= $pool[$crypto_rand_secure( 0, $max )];
		}
		return $token;

	}

}

?>
