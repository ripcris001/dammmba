<?php
	$root = __DIR__;
	include('CONFIG/config.php'); // config files
	include('CLASSES/class.connection.php'); // connection
	include('CLASSES/class.theme.php'); // theme
	include('CLASSES/class.core.php'); // core class
	include('CLASSES/class.requesthandler.php');
	include('CONFIG/init.php'); 
	include('CONFIG/routes.php'); 
	$output->err404 = $loader->loadTemplate("/TEMPLATE/SYSTEM/ERROR/404.html");
	$output->err403 = $loader->loadTemplate("/TEMPLATE/SYSTEM/ERROR/403.html");
	$output->connection = $dbcon;
	$output->route = $route->list;
	$output->server = $server;
	foreach($route->routeFile as $keys => $value){
		$class = $value;
		$class = str_replace('.php', '', $class);
		$className = 'route_'.$class;
		$localRoutePath = array('ROUTES','SYSTEM/ROUTES','SYSTEM/ADMIN_ROUTES','ROUTES/API','ROUTES/API/TABLE');
		$match = 0;
		foreach($localRoutePath as $rkeys => $rvalue){
			if($loader->checkFile("$rvalue/$value")){
				include("$rvalue/$value");
				$output->$className = new $class;
				$match++;
			}
		}
		if(!$match){
			$loader->SystemExit("File: [$value] doesnt exist on system. please remove this file to avoid error", "$root\CONFIG","routes.php");
		}
	}
?>