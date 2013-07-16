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

	public $queryFields = array(1) ;
	public $queryFilters = array(2) ;

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

		// Parse the query string.
		$this->interpretQuery($_SERVER['QUERY_STRING']) ;

		// Load the API.
			$this->api->buildRoutes() ;
			$this->api->enableSlim() ;

		// End the script timer.
			$mtime = explode(" ",microtime()); 
			$this->totaltime = (($mtime[1] + $mtime[0]) - $this->starttime);
			$this->log->timer = $this->totaltime ;

		// Output
			if(DEV_GUI) {

				require_once(SERVER_DOCRT.'/view/splash.php') ;

				echo $this->getData() ;

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
	public function interpretQuery($querystring = NULL) {

		/*

		/user/joe?@(firstname,lastname)
		/users?@(firstname,lastname):&(postcode=07869)
		/users?&(postcode=07869)
		/query?&(postcode=07869,gender=male):@(firstname,lastname)
		
		http://localhost/copilot/v1/query?&()::@()

		& FILTERS
		@ FIELDS

		Anything between () MUST be url encoded.
		
		*/

		$queryParts = array() ;
		$rawQuery = array() ;
		$parsedQuery = array() ;
		$urlError = FALSE ; // currently unused. returns malformed url error.
		$callError = FALSE ;


		// If use didn't pass in a query string then get one by default.
		if($querystring == NULL || isset($querystring) == FALSE) { 
			$querystring == $_SERVER['QUERY_STRING'] ; 
			$callError = TRUE ;
		}


		// Check how many pairs of () there are. If there are more than 2 pairs or any unpaired sides, trigger error.
		preg_match_all("#\([^()]*\)#", $querystring, $matches) ;
		
		if(count($matches[0]) >= 1 && count($matches[0]) <= 2 && $callError == FALSE) {

			if(strpos($querystring, "::") !== FALSE && substr_count($querystring, ":") == 2 && 
				(substr_count($querystring, "@(") > 0 || substr_count($querystring, "&(") > 0)) {		// two possible input parts

				// There should be something on boths sides of '::'
				$rawQuery = explode("::", $querystring) ;

			} elseif(substr_count($querystring, ":") == 0 && 
				(substr_count($querystring, "@(") > 0 || substr_count($querystring, "&(") > 0)) { 		// one possible input part

				$rawQuery[0] = $querystring ;
				$rawQuery[1] = NULL ;

			} else { 																					// no good input parts - saftey net. preg_match_all should catch this.

				$rawQuery[0] = NULL ;
				$rawQuery[1] = NULL ;

			}

			if($rawQuery[0] !== NULL || $rawQuery[1] !== NULL) foreach($rawQuery as $rawQueryPart) {

					// Check the rawQueryPart for '()'
					preg_match_all("#\([^()]*\)#", $rawQueryPart, $matches) ;
					
					// If there was only one pair of '()', process the side.
					if(count($matches[0]) == 1) {

						if(strpos($rawQueryPart, "&(") !== FALSE && isset($queryParts['filters']['isset']) == FALSE) {

							$queryParts['filters']['isset'] = TRUE ;
							$queryParts['filters']['data']['raw'] = trim(str_replace(array('(', ')'), '', $matches[0][0])) ;
							$queryParts['filters']['data']['parsed'] = NULL ;
							
						} elseif(strpos($rawQueryPart, "@(") !== FALSE) {

							$queryParts['fields']['isset'] = TRUE ;
							$queryParts['fields']['data']['raw'] = trim(str_replace(array('(', ')'), '', $matches[0][0])) ;
							$queryParts['fields']['data']['parsed'] = NULL ;

						}

					}

				} else { $urlError = TRUE ; }

				// We now have raw data or null in output[0] and output[1]



			} else { $urlError = TRUE ; }

			if($callError == TRUE) {

				$this->log->add("Input was expected. The action you attempted may not have completed and you may receive the call's default response fields.", CP_WARN) ;

			}

			if($urlError == TRUE && $callError == FALSE) {

				$this->log->add("Received a malformed URL.", CP_ERR) ;

				return NULL ;

			} else { // replace this else statement with an elseif which will replace the if statement below.

				// !!!!! TEMPORARY !!!!!
				if(isset($queryParts['filters']['data'])) { 
					echo $queryParts['filters']['data']['raw'], PHP_EOL ;
					$this->queryFilters = $queryParts['filters']['data']['raw'] ;
				}
				if(isset($queryParts['fields']['data'])) { 
					echo $queryParts['fields']['data']['raw'], PHP_EOL ; 
					$this->queryFields = $queryParts['fields']['data']['raw'] ;
				}

					
				if($parsedQuery !== NULL) {

					//$this->queryFields = $queryParts['fields']['data']['parsed'] ;
					//$this->queryFilters = $queryParts['filters']['data']['parsed'] ;

					return $parsedQuery ;

				} else {

					return NULL ;

				}

			}
	
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
	* Public passthrough function which adds a datablock to the return stream.
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
	* Public passthrough function which get's the json encoded return data stream.
	*/
	public function getData() {

		return $this->data->returnStream() ;

	}

	/**
	* Function returnRoutes
	*
	* Public passthrough function which returns all the known API routes.
	*/
	public function returnRoutes() {

		$routes = $this->api->getRoutes() ;

		

	}

	public function __clone() {

		trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);

	}

	public function __wakeup() {

		trigger_error('Unserializing instances of this class is forbidden.', E_USER_ERROR);
		
	}

}

?>
