<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for creating and managing all member objects. Provides acessors.
*/
class Copilot
{
	private 	$log 						;
	private 	$db_local 					;
	private 	$data 						;
	private 	$api 						;
	private 	$ready 			= NULL 	;

	public  	$totaltime 					;

	public 		$queryFields 	= array(1) 	;
	public 		$queryFilters 	= array(2) 	;

	static private $_instance 	= NULL 		;


	/**
	* Copilot may only be a singleton.
	*/
	public static function & Instance($muteOutput = FALSE)
	{
		if (is_null(self::$_instance)) { self::$_instance = new self($muteOutput); }
		return self::$_instance;
	}


	/**
	* CONSTRUCTOR
	*/
	public function __construct($muteOutput = FALSE) 
	{
		//Script timer. 
			$mtime = explode(" ",microtime()); 
			$this->starttime = $mtime[1] + $mtime[0] ;
		
		// Core classes.
			$this->log = new Log() ;
			//DATABASE//$this->db_local = new DB($this->log, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASS_LOCAL) ;
			$this->data = new Data($this->log) ;

		// API class.
			$this->api = new API($this->log) ;

		if($muteOutput == TRUE)
		{
			$this->mute = TRUE ;
		}
		else
		{
			$this->mute = DEV_MUTE ;
		}
	}


	/**
	* Function interpretQuery
	*
	* Public function which assembles, enables, and times the api. It also chooses how to output the results.
	*/
	public function ready()
	{
		// Parse the query string.
			$this->interpretQuery() ;

		// Load the API.
			$this->api->buildRoutes() ;
			$this->api->enableSlim() ;
			if($this->ready === NULL) $this->ready = $this->api->callExecuted ;

		// End the script timer.
			$mtime = explode(" ",microtime()); 
			$this->totaltime = (($mtime[1] + $mtime[0]) - $this->starttime);
			$this->log->timer = $this->totaltime ;
 
		// Output
			if($this->mute)
			{
				// do nothing once loaded
			}
			elseif($this->ready === TRUE) 							// if a call was made
			{
				header('Content-Type: application/json');
				echo $this->getData() ;
			}
			else 													// if no slim call was executed (default or otherwise)
			{
				echo $this->getData() ;
				echo "<br><br>", "Something went terribly, terribly wrong. (and took " . $this->totaltime . " to do so.)" ;
			}
	}


	public function obfuscate($action, $string, $key = 'unset')
	{
		if($key !== 'unset')
		{
			$output = false;

			$iv = md5(md5($key));

			if( $action == 'encrypt' )
			{
				$output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
				$output = base64_encode($output);
			}
			else if( $action == 'decrypt' )
			{
				$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
				$output = rtrim($output, "\0");
			}
			return $output;
		}
		else
		{
			return "INVALID KEY" ;
		}
	}


	/**
	* Function interpretQuery
	*
	* Public function which interprets the query string and also determines if the request was malformed.
	*
	* @param string $querystring contains $_SERVER['QUERY_STRING'] (by default, if not set).
	*/
	public function interpretQuery($querystring = NULL)
	{
		/*

		http://localhost/copilot/v1/query?&(field1=asdf,field2=hjkl)::@(firstname,lastname,home_phone)

		/user/joe?@(firstname,lastname)
		/users?@(firstname,lastname):&(postcode=07869)
		/users?&(postcode=07869)
		/query?&(postcode=07869,gender=male):@(firstname,lastname)
		

		http://localhost/copilot/v1/query?&()::@()

		@ FIELDS
		& FILTERS

		Anything between () MUST be url encoded.
		
		*/

		$queryParts 						= 	array() 	;
		$rawQuery 							= 	array() 	;
		$parsedQuery 						= 	NULL		;

		$urlError 							= 	FALSE 		; // for malformed url
		$callWarning 						= 	FALSE 		; // for messy call
		$URLcallBlank						= 	FALSE 		; // for empty url call
		$POSTcallBlank						= 	FALSE 		;
		$PUTcallBlank						= 	FALSE 		;

		$callWarningMsg						=	"Unsanitary input received." ;
		$urlErrorMsg						=	"Received a malformed URL." ;
		$callBlankMsg						= 	"Empty query received." ;

		$queryParts['fields']['isset'] 		= 	NULL 		;
		$queryParts['filters']['isset'] 	= 	NULL 		;

		$fieldDelimiter 					= 	"@" 		;
		$filterDelimiter 					= 	"&" 		;


		// If use didn't pass in a query string then get one by default.
		if(isset($_POST['QUERY']))
		{
			$token = CP_DEFAULT_KEY ;

			$encoded_json_base64 	= 	$_POST['QUERY'] ;
			$decoded_json 			= 	$this->obfuscate('decrypt', $encoded_json_base64, $token) ;
			$decoded 				= 	json_decode($decoded_json, TRUE) ;

			$this->addLog("QUERY", $decoded) ;

			// Rebuild filters and fields.
			$this->queryFilters = $decoded['FILTERS'] ;
			$this->queryFields = $decoded['FIELDS'] ;
		}
		else
		{
			$POSTcallblank = TRUE ;
		}

		if(($_SERVER['QUERY_STRING'] !== "" && isset($_SERVER['QUERY_STRING']) == TRUE) || ($querystring !== NULL && isset($querystring) == TRUE))
		{
			if($querystring == NULL || isset($querystring) !== TRUE) $querystring = $_SERVER['QUERY_STRING'] ;

			// Check how many pairs of () there are. If there are more than 2 pairs or any unpaired sides, trigger error.
			preg_match_all("#\([^()]*\)#", $querystring, $matches) ;

			if(count($matches[0]) >= 1 && count($matches[0]) <= 2)
			{
				if(
					strpos($querystring, "::") !== FALSE && substr_count($querystring, ":") == 2 && 
				  	(substr_count($querystring, ($fieldDelimiter."(")) > 0 || substr_count($querystring, ($filterDelimiter."(")) > 0)
				  )
				{// two possible input parts
					// There should be something on boths sides of '::'
					$rawQuery = explode("::", $querystring) ;
				}
				elseif(
						substr_count($querystring, ":") == 0 && 
					  	(substr_count($querystring, ($fieldDelimiter."(")) > 0 || substr_count($querystring, ($filterDelimiter."(")) > 0)
					  )
				{// one possible input part
					$rawQuery[0] = $querystring ;
					$rawQuery[1] = NULL ;
				}
				else
				{// no good input parts - saftey net. preg_match_all should catch this.
					$rawQuery[0] = NULL ;
					$rawQuery[1] = NULL ;
				}

				if($rawQuery[0] !== NULL || $rawQuery[1] !== NULL) foreach($rawQuery as $rawQueryPart)
				{
					// Check the rawQueryPart for '()'
					preg_match_all("#\([^()]*\)#", $rawQueryPart, $matches) ;
					
					// If there was only one pair of '()', process the side.
					if(count($matches[0]) == 1)
					{
						if(strpos($rawQueryPart, $filterDelimiter."(") !== FALSE && isset($queryParts['filters']['isset']) == FALSE)
						{
							$queryParts['filters']['isset'] = TRUE ;
							$queryParts['filters']['data']['raw'] = trim(str_replace(array('(', ')'), '', $matches[0][0])) ;
							$queryParts['filters']['data']['parsed'] = NULL ;

							if($filterDelimiter.$matches[0][0] !== $rawQueryPart) { $callWarning = TRUE ; }
						}
						elseif(strpos($rawQueryPart, $fieldDelimiter."(") !== FALSE)
						{
							$queryParts['fields']['isset'] = TRUE ;
							$queryParts['fields']['data']['raw'] = trim(str_replace(array('(', ')'), '', $matches[0][0])) ;
							$queryParts['fields']['data']['parsed'] = NULL ;

							if($fieldDelimiter.$matches[0][0] !== $rawQueryPart) { $callWarning = TRUE ; }
						}
					}
				}
				else
				{
					$urlErrorTrigger = TRUE ;
				}

				// We now have raw data or null in queryParts[filters] and queryParts[fields]

				if($queryParts['filters']['isset'] !== NULL) // Parse filters.
				{ 
					$tempRAW = array() ;
					$tempParsed = array() ;

					$tempRAW = urldecode($queryParts['filters']['data']['raw']) ;
					$tempRAW = explode(',', $tempRAW) ;

					for($i = 0; $i < count($tempRAW); ++$i)
					{
						$tempRAW[$i] = explode('=', $tempRAW[$i]) ;
						if(count($tempRAW[$i]) > 1)
						{
							$tempParsed[trim($tempRAW[$i][0])] = trim($tempRAW[$i][1]) ;
						}
						else
						{
							$tempParsed[$i][0] = trim($tempRAW[$i][0]) ;
						}
					}
					
					$queryParts['filters']['data']['parsed'] = $tempParsed ;
				}

				if($queryParts['fields']['isset'] !== NULL) // Parse fields.
				{ 
					$temp = urldecode($queryParts['fields']['data']['raw']) ;
					$temp = explode(',', $temp) ;
					for($i = 0; $i < count($temp); ++$i) { $temp[$i] = trim($temp[$i]) ; }
					$queryParts['fields']['data']['parsed'] = $temp ;
				}

				if($queryParts['filters']['isset'] !== NULL)
				{
					$this->queryFilters = $queryParts['filters']['data']['parsed'] ;
				}

				if($queryParts['fields']['isset'] !== NULL)
				{
					$this->queryFields = $queryParts['fields']['data']['parsed'] ;
				}

				$parsedQuery = array('fields'=>$this->queryFields, 'filters'=>$this->queryFilters) ;
			}
			else
			{
				$urlErrorTrigger = TRUE ;
			}
		}
		else
		{
			$URLcallBlank = TRUE ;
		}

		if($URLcallBlank == FALSE && $urlErrorTrigger == TRUE)
		{
			$urlError = TRUE ;
		}
		
		

		if($URLcallBlank == TRUE && $POSTcallBlank == TRUE && $PUTcallBlank == TRUE) 									// If there was a blank query. (only in DEV mode)
		{					
			//if(DEV) { $this->log->add($callBlankMsg, CP_WARN) ; }
			return NULL ;
		}
		elseif($callWarning == TRUE) 								// If there was a warning.
		{
			$this->log->add($callWarningMsg, CP_WARN) ;
			return NULL ;
		}
		elseif($urlError == TRUE) 									// If there was a malformed query.
		{
			$this->log->add($urlErrorMsg, CP_ERR) ;
			return NULL ;
		}
		else
		{
			if($parsedQuery !== NULL)
			{
				$this->log->add("Query parsed successfully.", CP_MSG) ;
				return $parsedQuery ;
			}
			else
			{
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
	* @param lambda $callbackMethod contains the call_user_method() compatible lambda function.
	* @param lambda $requestedCallback contains a call_user_method() compatible lambda function which runs just before the main callback method.
	*/
	public function createRoute($httpMethod, $requestRoute, $callbackMethod, $requestedCallback = NULL)
	{
		$func = new \ReflectionFunction($callbackMethod);
		$func = $func->getParameters() ;
		$paramCount = count($func) ;
		$readyPointer = &$this->ready ;


		/*
		echo $httpMethod, " ", $requestRoute, " ", $paramCount, PHP_EOL ;
		print_r($func) ;
		echo PHP_EOL ;

		//call_user_func_array($callbackMethod, $func) ;
		*/

		if($paramCount == 1)
		{
			$this->api->addRoute($httpMethod, '/'.API_VERSION.$requestRoute, function($param) use ($callbackMethod, $requestedCallback, &$readyPointer)
			{
				if($requestedCallback !== NULL)
				{
					call_user_func($requestedCallback) ;
				}
				call_user_func($callbackMethod, $param) ;

				$readyPointer = TRUE ;
			}) ;
		}
		elseif($paramCount == 0)
		{
			$this->api->addRoute($httpMethod, '/'.API_VERSION.$requestRoute, function() use ($callbackMethod, $requestedCallback, &$readyPointer)
			{
				if($requestedCallback !== NULL)
				{
					call_user_func($requestedCallback) ;
				}
				call_user_func($callbackMethod) ;

				$readyPointer = TRUE ;
			}) ;
		}
		else
		{
			// See above comments for ideas on how to handle several parameters.
		}
	}


	/**
	* Function addData
	*
	* Public passthrough function which adds a datablock to the return stream.
	*
	* @param string $name contains the name of the data block.
	* @param string $input contains the new block of data.
	*/
	public function addBlock($name, $input)
	{
		$this->data->add($name, $input) ;
	}


	/**
	* Function addData
	*
	* Public passthrough function which gets the json encoded return data stream.
	*/
	public function getData()
	{
		return $this->data->returnStream() ;
	}


	/**
	* Function returnRoutes
	*
	* Public passthrough function which returns all the known API routes.
	*/
	public function returnRoutes()
	{
		return $this->api->getRoutes() ;
	}


	/**
	* Function addLog
	*
	* Public passthrough function which allows adding logs externally.
	*/
	public function addLog($msg = NULL, $type = NULL)
	{
		if($msg !== NULL && $type !== NULL) $this->log->add($msg, $type) ;
	}


	public function __clone()
	{
		trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);
	}


	public function __wakeup()
	{
		trigger_error('Unserializing instances of this class is forbidden.', E_USER_ERROR);
	}

}

?>
