<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for creating and managing all member objects. Provides acessors.
*/
class Copilot {

	private $log ;
	private $db_local ;
	private $data ;
	private $api ;

	static private $_instance = null;

	/**
	* Copilot may only be a singleton.
	*/
	public static function & Instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {

		//Script timer. 
			$mtime = explode(" ",microtime()); 
			$this->starttime = $mtime[1] + $mtime[0] ;
		
		// Core classes.
			$this->log = new Log() ;
			//DATABASE//$this->db_local = new DB($this->log, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASS_LOCAL) ;
			$this->data = new Data($this->log) ;

		// API class.
			$this->api = new API($this->log) ;

	}

	/**
	* Function interpretQuery
	*
	* Public function which assembles, enables, and times the api. It also chooses how to output the results.
	*/
	public function ready() {

		// Load the API.
			$this->api->buildRoutes() ;
			$this->api->enableSlim() ;

		// End the script timer.
			$mtime = explode(" ",microtime()); 
			$this->totaltime = (($mtime[1] + $mtime[0]) - $this->starttime);
			$this->log->timer = $this->totaltime ;

		// Output
			if(DEV_GUI) {

				$this->log->add($this->getData(), CP_RESPONSE) ;

				require_once(SERVER_DOCRT.'/view/splash.php') ;

			} else {

				header('Content-Type: application/json');

				echo $this->getData() ;

			}

	}

	/**
	* Function interpretQuery
	*
	* Public function which interprets the query string and also determines if the request was malformed.
	*
	* @param string $querystring contains $_SERVER['QUERY_STRING'] (by default, if not set).
	*/
	public function interpretQuery($querystring = null) {

		/* a properly formed query string contains either fields or filters.
		   an example of each:
				fields
					/user/joe?(firstname,lastname)
				fields and filters
					/users?(firstname,lastname):(postcode=07869)
				filters
					/users?(postcode=07869)

			Query Composure Ideas
				??????????????
		*/

		$querystring = isset($querystring) ? $querystring : $_SERVER['QUERY_STRING'] ;

		$output = str_replace(array('(', ')'), '', trim(urldecode($querystring))) ;

		$output = explode(':', $output) ;

		for($i = 0; $i < 2; ++$i) {

			$temp = explode(',', $output[$i]) ;

			for($j = 0; $j < count($temp); ++$j) {

				$temp[$j] = explode('=', $temp[$j]) ;

			}

			$output[$i] = $temp ;

		}

		$output['filters'] = $output[0] ;

		$output['fields'] = $output[1] ;

		unset($output[0], $output[1]) ;

		return $output ;
	}

	/**
	* Function createRoute
	*
	* Public function which allows external methods to be bound to the API using api\addRoute().
	*
	* @param string $httpMethod contains the http method - i.e. get, post, put, delete.
	* @param string $requestRoute contains the url parameter which calls this route.
	* @param string $callbackMethod contains the call_user_method() compatible function name.
	*/
	public function createRoute($httpMethod, $requestRoute, $callbackMethod) {

		$this->api->addRoute($httpMethod, '/'.API_VERSION.$requestRoute, $callbackMethod) ;

	}

	/**
	* Function addData
	*
	* Public pasthrough function which adds a datablock to the return stream.
	*
	* @param string $name contains the name of the data block.
	* @param string $input contains the new block of data.
	*/
	public function addData($name, $input) {

		$this->data->add($name, $input) ;

	}

	/**
	* Function addData
	*
	* Public pasthrough function which get's the json encoded return data stream.
	*/
	public function getData() {

		return $this->data->returnStream() ;

	}

	public function __clone() {

		trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);

	}

	public function __wakeup() {

		trigger_error('Unserializing instances of this class is forbidden.', E_USER_ERROR);
		
	}

}

?>
