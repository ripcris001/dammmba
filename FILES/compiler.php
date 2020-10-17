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
		if($loader->checkFile("ROUTES/$value")){
			include("ROUTES/$value");
			$output->$className = new $class;
		}else if($loader->checkFile("SYSTEM/ROUTES/$value")){
			include("SYSTEM/ROUTES/$value");
			$output->$className = new $class;
		}else if($loader->checkFile("SYSTEM/ADMIN_ROUTES/$value")){
			include("SYSTEM/ADMIN_ROUTES/$value");
			$output->$className = new $class;
		}else{
			$loader->SystemExit("File: [$value] doesnt exist on system. please remove this file to avoid error", "$root\CONFIG","routes.php");
		}
	}
?>