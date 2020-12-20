<?php
	function addRoute($data){
		$local = new stdClass();
		$local->route = $data['route'];
		$local->class = $data['file_name'];
		$local->function = $data['function'];
		$local->maintenance = $data['maintenance'];
		$local->require_login = $data['require_login'];
		$local->backend = $data['is_backend'];
		$local->require_user_role = $data['require_user_role'];
		$local->allow_user_role = isset($data['allow_user_role']) ? explode(",",$data['allow_user_role']) : array();
		$local->allow_user_maintenance = isset($data['allow_user_maintenance']) ? explode(",",$data['allow_user_maintenance']) : array();
		$local->role_read = isset($data['role_read']) ? explode(",",$data['role_read']) : array();
		$local->role_write = isset($data['role_write']) ? explode(",",$data['role_write']) : array();
		$local->role_delete = isset($data['role_delete']) ? explode(",",$data['role_delete']) : array();
		return $local;
	}
	function setRoute($data){
		array_push($local_routes, $data);
		return true;
	};
	$route->routeFile = array(
		"system_home.php", 
		"system_pages.php", 
		"system_login.php",
		"client.php",
		"landholding.php",
		"organization.php",
		"admin_dashboard.php",
		"client_admin.php",
		"monthly_dues.php"
	);
	$local_routes = array();
	$routeList = $loader->getRoute()->data;
	foreach($routeList as $keys => $value){
		if($keys > -1){
			array_push($local_routes,addRoute($value));
		}
	}
	$route->list = $local_routes;
?>