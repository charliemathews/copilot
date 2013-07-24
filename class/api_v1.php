<?php

/**
$defaultIncludes is a callback function to help you save time if you need something in almost every API call.
*/

$defaultIncludes = function () use ($__CP)
{
	// Add query parameters to the return json stream.
	$__CP->addBlock("query", array("filters"=>$__CP->queryFilters, "fields"=>$__CP->queryFields)) ;
	
	// Default Pilot Includes
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
};


/* $__CP->createRoute({http request type}, {url path}, {ACTION callback function}, {REQUESTED callback function})

		{type} 		can be get, post, put, delete

		{path} 		This is what comes after "YOURURL.com/API_VERSION". for example, you could enter "/this/is/an/api/call"

		{ACTION} 	This is where you put a function callback containing whatever logic your API user is expecting to be run such as a query.

		{REQUESTED} This is where you can include an extra function callback which will run just before the rest of the call. 
					It's for including code that you're finding yourself repeating in every call, such as include() statements.
*/


/**

* CLASS.TSS.MAIN

*/

$__CP->createRoute('get', '/users/technician', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("technicians", $instance->get_technician_list()) ;
},$defaultIncludes);


/**
Projects has session var. Due to lack of default value, talk to dave about this specific separation.
*/
$__CP->createRoute('get', '/projects', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("projects", $instance->get_project_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/customers', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("customers", $instance->get_customer_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/distance', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("distance", $instance->get_distance_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/priority', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("priority", $instance->get_priority_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/substatus', function() use($__CP) 
{
	if(isset( $__CP->queryFilters['status'] ) !== FALSE)
	{
		$instance = new tss_main() ;
		$__CP->addBlock("substatus", $instance->get_substatus_list( $__CP->queryFilters['status'] )) ;
	}
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/role', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("role", $instance->get_role_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/type', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("type", $instance->get_service_type_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/status', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("status", $instance->get_status_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/state', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("state", $instance->get_state_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/event/tabs', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("event_tabs", $instance->get_event_tabs()) ;
}, $defaultIncludes);


$__CP->createRoute('put', '/event/log', function() use($__CP) 
{
	if(isset( $__CP->queryFilters['id'] ) && isset( $__CP->queryFilters['desc'] ) && isset( $__CP->queryFilters['userid'] ))
	{
		$instance = new tss_main() ;
		$instance->append_to_log( $__CP->queryFilters['id'], $__CP->queryFilters['desc'], $__CP->queryFilters['userid'] ) ;
		$__CP->addBlock("event_log", array("true", "true")) ;
	}
	else {
		$__CP->addLog("Required input was not present.", CP_ERR) ;
	}
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/timezone', function() use($__CP) 
{
	$instance = new tss_main() ;
	$__CP->addBlock("timezone", $instance->get_timezone_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/definition/filetype', function() use($__CP) 
{
	if(isset( $__CP->queryFilters['type'] ) !== FALSE)
	{
		$instance = new tss_main() ;
		$__CP->addBlock("filetype", $instance->get_permitted_file_extensions( $__CP->queryFilters['type'] )) ;
	}
}, $defaultIncludes);


/**

* CLASS.TSS.MATERIAL

*/

$__CP->createRoute('get', '/material/:id', function($id) use($__CP) 
{
	if(isset( $id ) !== FALSE)
	{
		require_once(SERVER_DOCRT.'/class/class.tss.material.php') ;
		$instance = new tss_material() ;

		if(isset( $__CP->queryField['creator'] ) !== FALSE)
		{
			$instance->load( $id ) ;
			$__CP->addBlock("material_creator", $instance->get_creator_name( $__CP->queryField['creator'] )) ;
		}
		else
		{
			$__CP->addBlock("material", $instance->load( $id )) ;
		}
	}
}, $defaultIncludes);


$__CP->createRoute('delete', '/material/:id', function($id) use($__CP) 
{
	if(isset( $id ) !== FALSE)
	{
		require_once(SERVER_DOCRT.'/class/class.tss.material.php') ;
		$instance = new tss_material() ;

		$instance->load( $id ) ;
		$__CP->addBlock("material", $instance->del()) ;
	}
}, $defaultIncludes);


/**

* CLASS.TSS.USER

*/

$__CP->createRoute('get', '/users', function() use($__CP)
{															// view all
	$instance = new tss_main() ;
	$__CP->addBlock("users", $instance->get_user_list()) ;
}, $defaultIncludes);


$__CP->createRoute('get', '/user/:id', function($id) use($__CP) 
{																// view one
	if(isset( $id ) !== FALSE)
	{
		require_once(SERVER_DOCRT.'/class/class.tss.user.php') ;
		$instance = new tss_user() ;
		$__CP->addBlock("user:".$id, $instance->load( $id )) ;
	}
}, $defaultIncludes);


$__CP->createRoute('put', '/users', function() use($__CP) 
{															// create
	if(	isset( $__CP->queryFilter['email'] ) 		&& 
		isset( $__CP->queryFilter['phone'] ) 		&& 
		isset( $__CP->queryFilter['first_name'] ) 	&& 
		isset( $__CP->queryFilter['last_name'] ) 	&& 
		isset( $__CP->queryFilter['notes'] ) 		&& 
		isset( $__CP->queryFilter['hourly_rate'] ) 	&& 
		isset( $__CP->queryFilter['timezone'] )		&& 
		isset( $__CP->queryFilter['roles'] )		&& 
		isset( $__CP->queryFilter['projects'] )
		)
	{
		require_once(SERVER_DOCRT.'/class/class.tss.user.php') ;
		$instance = new tss_user() ;
		$__CP->addBlock("user_created", $instance->add(	$__CP->queryFilter['email']			, 
														$__CP->queryFilter['phone']			,
														$__CP->queryFilter['first_name']	,
														$__CP->queryFilter['last_name']		,
														$__CP->queryFilter['notes']			,
														$__CP->queryFilter['hourly_rate']	,
														$__CP->queryFilter['timezone']		,
														$__CP->queryFilter['roles']			,
														$__CP->queryFilter['projects']
														) ) ;
	}
	else
	{
		$__CP->addBlock("user_created", array(false, false)) ;
	}
}, $defaultIncludes);


$__CP->createRoute('post', '/user/:id', function($id) use($__CP) 
{																// update
	if( isset( $id) )
	{
		if(	isset( $__CP->queryFilter['email'] ) 		&& 
			isset( $__CP->queryFilter['phone'] ) 		&& 
			isset( $__CP->queryFilter['first_name'] ) 	&& 
			isset( $__CP->queryFilter['last_name'] ) 	&& 
			isset( $__CP->queryFilter['notes'] ) 		&& 
			isset( $__CP->queryFilter['hourly_rate'] ) 	&& 
			isset( $__CP->queryFilter['timezone'] )		&& 
			isset( $__CP->queryFilter['roles'] )		&& 
			isset( $__CP->queryFilter['projects'] )
			)
		{
			require_once(SERVER_DOCRT.'/class/class.tss.user.php') ;
			$instance = new tss_user() ;
			$__CP->addBlock("user_updated", $instance->add(	$__CP->queryFilter['email']			, 
															$__CP->queryFilter['phone']			,
															$__CP->queryFilter['first_name']	,
															$__CP->queryFilter['last_name']		,
															$__CP->queryFilter['notes']			,
															$__CP->queryFilter['hourly_rate']	,
															$__CP->queryFilter['timezone']		,
															$__CP->queryFilter['roles']			,
															$__CP->queryFilter['projects']
															) ) ;
		}
		else
		{
			$__CP->addBlock("user_updated", array(false, false)) ;
		}
	}
}, $defaultIncludes);


$__CP->createRoute('delete', '/user/:id', function($id) use($__CP) 
{																	// delete
	if(isset( $id ) !== FALSE)
	{
		require_once(SERVER_DOCRT.'/class/class.tss.user.php') ;
		$instance = new tss_user() ;
		$__CP->addBlock("user_deleted", $instance->del( $id )) ;
	}
}, $defaultIncludes);


$__CP->createRoute('post', '/user/:id/password', function($id) use($__CP) 
{																// update password (needs to be integrated with the update function at some point)
	if( isset( $id ) )
	{
		if(	isset( $__CP->queryFilter['password'] ) )
		{
			require_once(SERVER_DOCRT.'/class/class.tss.user.php') ;
			$instance = new tss_user() ;
			$__CP->addBlock("user_updated", $instance->change_password(	$__CP->queryFilter['password']	) ) ;
		}
		else
		{
			$__CP->addBlock("user_updated", array(false, false)) ;
		}
	}
}, $defaultIncludes);


?>
