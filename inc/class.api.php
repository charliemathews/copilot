<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* This class builds and manages the API.
*/
class API
{
	private 	$log 						;
	private 	$slim 						;
	private 	$routeIndex 	= array() 	;
	public 		$callExecuted 	= NULL 		;

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
			$this->addRouteToIndex($httpMethod, $requestRouteAppend, $callbackMethod) ;
		}
		elseif(strlen($requestRoute) > 1 && substr($requestRoute, -1) == '/')
		{
			$requestRouteAppend = substr_replace($requestRoute, "", -1) ;
			$this->addRouteToIndex($httpMethod, $requestRouteAppend, $callbackMethod) ;
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
	public function addRouteToIndex($httpMethod, $requestRoute, $callbackMethod)
	{
		$this->routeIndex[] = array('httpMethod'=>$httpMethod, 'requestRoute'=>$requestRoute, 'callbackMethod'=>$callbackMethod) ;
	}


	/**
	* Function buildRoutes
	*
	* Runs the methods for building statically and dynamically created routes.
	*/
	public function buildRoutes()
	{
		$this->buildStaticRoutes() ;
		$this->buildDynamicRoutes() ;
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

		$this->addRoute('get', '/', function() use($apiBits)
		{
			$apiBits['log']->add(APP_NAME ." is online.", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;

		$this->addRoute('get', '/'.API_VERSION, function() use($apiBits)
		{
			$apiBits['log']->add("API Version ".API_VERSION." is online.", CP_STATUS) ;
			$apiBits['status'] = TRUE ;
		}) ;

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
	private function buildDynamicRoutes()
	{
		foreach($this->routeIndex as $singleRoute)
		{
			if($singleRoute['httpMethod'] == 'get')
			{
				$this->slim->get($singleRoute['requestRoute'], $singleRoute['callbackMethod']) ;
			}
		}
	}


	/**

	*/
	public function returnRoutes()
	{
		return $routeIndex ;
	}
}

?>
