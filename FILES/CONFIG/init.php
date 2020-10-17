<?php

/* STD CLASSES */
	/* Declare Object */
	$o_template = new stdClass();
	$s_var = new stdClass();
	$output = new stdClass();
	
	/* routing */
	$route = new stdClass();
	$route->POST = new stdClass();
	$route->GET = new stdClass();
	$route->DELETE = new stdClass();
	$route->PUT = new stdClass();
	
	/* database */
	$dbcon = new stdClass();
	
	/* server */
	$server = new stdClass();

/* CLASSES */
	/* Declare Class Object */
	$loader = new Core();
	$connection = new Connection();
	$connection->connectDB();
	$handler = new handler();
	$dbcon->status = $connection->MySQL->Connection;
	$dbcon->error = $connection->MySQL->Error;

/* Default Value */
	$server->lock = $loader->controlInterface('server_lock');
	$server->maintenance = $loader->controlInterface('server_maintenance');
	$server->gateway = $loader->controlInterface('server_gateway');

?>