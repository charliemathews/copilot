<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* This class builds and manages the API.
*/
class API
{
	private 	$log 							;
	private 	$slim 							;
	private 	$routeIndex 		= array() 	;
	private 	$routeIndexMirror	= array() 	;
	public 		$callExecuted 		= "NULL" 		;

	/**
	* CONSTRUCTOR
	*/
	public function __construct(Log &$log)
	{
		$this->log = $log ;

		\Slim\Slim::registerAutoloader();
		$this->slim = new \Slim\Slim() ;
	}


	/**
	* Function enableSlim
	*
	* Enables the slim instance.
	*/
	public function enableSlim()
	{
		$this->slim->run();
	}


	/**

	*/
	public function addRoute($httpMethod, $requestRoute, $callbackMethod)
	{
		$requestRoute = trim($requestRoute) ;
		$this->addRouteToIndex($httpMethod, $requestRoute, $callbackMethod) ;

		if(strlen($requestRoute) > 1 && substr($requestRoute, -1) != '/')
		{
			$requestRouteAppend = $requestRoute.'/' ; 
			$this->addRouteToIndex($httpMethod, $requestRouteAppend, $callbackMethod, TRUE) ;
		}
		elseif(strlen($requestRoute) > 1 && substr($requestRoute, -1) == '/')
		{
			$requestRouteAppend = substr_replace($requestRoute, "", -1) ;
			$this->addRouteToIndex($httpMethod, $requestRouteAppend, $callbackMethod, TRUE) ;
		}
	}


	/**
	* Function addRouteToIndex
	*
	* Adds any desired route to the routeIndex which is dynamically added to the API.
	*
	* @param string $httpMethod contains the http method - i.e. get, post, put, delete.
	* @param string $requestRoute contains the url parameter which calls this route.
	* @param string $callbackMethod contains the call_user_method() compatible function name.
	*/
	public function addRouteToIndex($httpMethod, $requestRoute, $callbackMethod, $mirror = FALSE)
	{
		if($mirror == FALSE) $this->routeIndex[] = array('httpMethod'=>$httpMethod, 'requestRoute'=>$requestRoute, 'callbackMethod'=>$callbackMethod) ;
		elseif($mirror == TRUE) $this->routeIndexMirror[] = array('httpMethod'=>$httpMethod, 'requestRoute'=>$requestRoute, 'callbackMethod'=>$callbackMethod) ;
	}


	/**
	* Function buildRoutes
	*
	* Runs the methods for building statically and dynamically created routes.
	*/
	public function buildRoutes()
	{
		$this->buildStaticRoutes() ;
		$this->buildDynamicRoutes($this->routeIndex) ;
		$this->buildDynamicRoutes($this->routeIndexMirror) ;
	}


	/**
	* Function buildStaticRoutes
	*
	* Submits staticly programmed routes into slim.
	*/
	private function buildStaticRoutes()
	{
		$apiBits = array() ;
		$apiBits['log'] = &$this->log ;
		$apiBits['status'] = &$this->callExecuted ;


		// Test route for whatever.
		$this->addRoute('post', '/test', function() use($apiBits)
		{
			$apiBits['log']->add("Test call executed.", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;


		// This route returns a cryptographically secure, pseudo-random string.
		$this->addRoute('get', '/key', function() use($apiBits)
		{
			include(SERVER_DOCRT."/inc/func.rand.php") ;
			$apiBits['log']->add(random_text('distinct'), "KEY") ;
			$apiBits['status'] = TRUE ;
		}) ;


		// Default routes.
		$this->addRoute('get', '/', function() use($apiBits)
		{
			$apiBits['log']->add(APP_NAME ." is online. (GET)", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;
		$this->addRoute('post', '/', function() use($apiBits)
		{
			$apiBits['log']->add(APP_NAME ." is online. (POST)", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;
		$this->addRoute('put', '/', function() use($apiBits)
		{
			$apiBits['log']->add(APP_NAME ." is online. (PUT)", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;
		$this->addRoute('delete', '/', function() use($apiBits)
		{
			$apiBits['log']->add(APP_NAME ." is online. (DELETE)", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;


		// API Default Route
		$this->addRoute('get', '/'.API_VERSION, function() use($apiBits)
		{
			$apiBits['log']->add("API Version ".API_VERSION." is online.", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;


		// 404 Route.
		$this->slim->notFound(function () use($apiBits)
		{
    		$apiBits['log']->add("Unknown call.", CP_STATUS) ;
    		$apiBits['status'] = TRUE ;
		});
	}


	/**
	* Function buildDynamicRoutes
	*
	* Submits dynamically programmed routes into slim.
	*/
	private function buildDynamicRoutes($theIndex)
	{
		foreach($theIndex as $singleRoute)
		{
			if($singleRoute['httpMethod'] == 'get' || $singleRoute['httpMethod'] == 'GET')
			{
				$this->slim->get($singleRoute['requestRoute'], $singleRoute['callbackMethod']) ;
			} 
			elseif($singleRoute['httpMethod'] == 'post' || $singleRoute['httpMethod'] == 'POST')
			{
				$this->slim->post($singleRoute['requestRoute'], $singleRoute['callbackMethod']) ;
			} 
			elseif($singleRoute['httpMethod'] == 'put' || $singleRoute['httpMethod'] == 'PUT')
			{
				$this->slim->put($singleRoute['requestRoute'], $singleRoute['callbackMethod']) ;
			} 
			elseif($singleRoute['httpMethod'] == 'delete' || $singleRoute['httpMethod'] == 'DELETE')
			{
				$this->slim->delete($singleRoute['requestRoute'], $singleRoute['callbackMethod']) ;
			}
		}
	}


	/**

	*/
	public function getRoutes()
	{
		foreach($this->routeIndex as $route)
		{
			$routeIndexOutput[] = array('httpMethod'=>$route['httpMethod'], 'requestRoute'=>$route['requestRoute']) ;
		}
		return $routeIndexOutput ;
	}
}

?>
