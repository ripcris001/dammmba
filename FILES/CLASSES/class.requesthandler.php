<?php
	class handler extends Core{		
		public function parseString($string){
			$object = array();
			$parseUrl = strstr($string, '?');
			$parseUrl = substr($parseUrl, 1);
			$output_string = str_replace('%20', ' ', $parseUrl);
			$output_string = str_replace('=', ':', $output_string);
			$output_string = str_replace('&', ',', $output_string);
			$output_string = str_replace('::', '==', $output_string);
			if(strlen($output_string)){
				$output_string = explode(",",$output_string);
				if(count($output_string) > 0){
					foreach ($output_string as $key => $value) {
						$loopdata = explode(":", $value);
						$loopIndex = $loopdata[0];
						$loopValue = $loopdata[1];
						$object[$loopIndex] = $loopValue;
					}
				}
			}
			return $object;
		}
		public function handleRequest($server, $post, $get, $value){
			$localClass = '';
			$localFunction = '';
			$localMaintenance = 0;
			$localRequireLogin = 0;
			$localBackend = 0;
			$localRequireRole = 0;
			$localRole = null;
			$localAllowMaintenance = null;
			$findCount = 0;
			$findHome = 0;
			$localRoleRead = array();
			$localRoleWrite = array();
			$localRoleDelete = array();
			$findHomeMaintenance = 0;
			$url = $server['REQUEST_URI'];
			$method = $server['REQUEST_METHOD'];
			$get = $this->parseString($url);
			foreach($value->route as $keys => $values){
				if(!isSet($server['REDIRECT_URL'])){
					if($values->route == '/'){
						$findHome++;
						if($values->maintenance){
							$findHomeMaintenance++;
							$localAllowMaintenance = $values->allow_user_maintenance;
						}
					}else{
						$localClass = 'route_'.$values->class;
						$localFunction = $values->function;
						$localMaintenance = $values->maintenance;
						$localRequireLogin = $values->require_login;
						$localBackend = $values->backend;
						$localRequireRole = $values->require_user_role;
						$localRole = $values->allow_user_role;
						$localAllowMaintenance = $values->allow_user_maintenance;
						$localRoleRead = $values->role_read;
						$localRoleWrite = $values->role_write;
						$localRoleDelete = $values->role_delete;
						$findCount++;
					}
				}else if($server['REDIRECT_URL'] == $values->route && $values->route != '/'){
					$localClass = 'route_'.$values->class;
					$localFunction = $values->function;
					$localMaintenance = $values->maintenance;
					$localRequireLogin = $values->require_login;
					$localBackend = $values->backend;
					$localRequireRole = $values->require_user_role;
					$localRole = $values->allow_user_role;
					$localAllowMaintenance = $values->allow_user_maintenance;
					$localRoleRead = $values->role_read;
					$localRoleWrite = $values->role_write;
					$localRoleDelete = $values->role_delete;
					$findCount++;
				}
			}
			$input = new stdClass();
			$input->role = new stdClass();
			$input->role->read = $this->roleValidator($localRoleRead, $this->getSessionVar('user_role')) ? true : false;
			$input->role->write = $this->roleValidator($localRoleWrite, $this->getSessionVar('user_role')) ? true : false;
			$input->role->delete = $this->roleValidator($localRoleDelete, $this->getSessionVar('user_role')) ? true : false;
			if($findHome || $findCount){
				if($value->server->maintenance){
					$input->body = $post;
					$input->params = $get;
					$value->route_system_pages->maintenance($input);
				}else if($value->server->lock){
					$input->body = $post;
					$input->params = $get; 
					$value->route_system_pages->lock($input);
				}else{
					$checkGW = $this->checkGateway();
					if($value->server->gateway && !$checkGW){
						$input->body = $post;
						$input->params = $get; 
						$input->method = $method;
						$value->route_system_pages->_gateway($input);
					}else{
						if($findHome){
							if($findHomeMaintenance){
								$checkSession = $this->checkSession();
								if($checkSession){
									$fineRole = array_search($this->getSessionVar("user_id"), $localAllowMaintenance);
									if(gettype($fineRole) == 'integer' && $fineRole >= 0){
										$input->body = $post;
										$input->params = $get;
										$value->route_system_home->_init($input);
									}else{
										$input->body = $post;
										$input->params = $get; 
										$value->route_system_pages->maintenance($input);
									}
								}else{
									$input->body = $post;
									$input->params = $get; 
									$value->route_system_pages->maintenance($input);
								}
							}else{
								$input->body = $post;
								$input->params = $get; 
								$value->route_system_home->_init($input);
							}
						}else if($findCount){
							// for backend Process
							if($localBackend > 0){
								if($localBackend && $method == 'GET'){
									$input->body = $post;
									$input->params = $get;
									$value->route_system_pages->err404($input);
								}else{
									if($localRequireRole > 0){
										$response = $this->newClass();
										$response->status = false;
										$checkSession = $this->checkSession();
										if($checkSession){
											$fineRole = array_search($this->getSessionVar("user_role"), $localRole);
											if(gettype($fineRole) == 'integer' && $fineRole >= 0){
												$input->body = $post;
												$input->params = $get;
												$value->$localClass->$localFunction($input);
											}else{
												$response->message = "You have proper permission for this!";
												$response->code = 'PERMISSIONERROR';
												$this->response($response);
											}
										}else{
											$response->message = "You need to login first!";
											$this->response($response);
										}
									}else if($localMaintenance > 0){
										$response = $this->newClass();
										$response->status = false;
										$checkSession = $this->checkSession();
										if($checkSession){
											$fineRole = array_search($this->getSessionVar("user_id"), $localAllowMaintenance);
											if(gettype($fineRole) == 'integer' && $fineRole >= 0){
												$input->body = $post;
												$input->params = $get;
												$value->$localClass->$localFunction($input);
											}else{
												$response->code = 'FEATUREERROR';
												$response->message = "This feature is temporary disable! Contact the developer to fix the issue!";
												$this->response($response);
											}
										}else{
											$response->code = 'FEATUREERROR';
											$response->message = "This feature is temporary disable! Contact the developer to fix the issue!";
											$this->response($response);
										}
									}else{
										$input->body = $post;
										$input->params = $get;
										$value->$localClass->$localFunction($input);
									}
								}
							}else{
								if($localMaintenance > 0){
									$checkSession = $this->checkSession();
									if($checkSession){
										$fineRole = array_search($this->getSessionVar("user_id"), $localAllowMaintenance);
										if(gettype($fineRole) == 'integer' && $fineRole >= 0){
											$input->body = $post;
											$input->params = $get;
											$value->$localClass->$localFunction($input);
										}else{
											$input->body = $post;
											$input->params = $get; 
											$value->route_system_pages->maintenance($input);
										}
									}else{
										$input->body = $post;
										$input->params = $get; 
										$value->route_system_pages->maintenance($input);
									}
								}else{
									if($localRequireLogin > 0){
										$checkSession = $this->checkSession();
										if($checkSession){
											if($localRequireRole > 0){
												$fineRole = array_search($this->getSessionVar("user_role"), $localRole);
												if(gettype($fineRole) == 'integer' && $fineRole >= 0){
													$input->body = $post;
													$input->params = $get;
													$value->$localClass->$localFunction($input);
												}else{
													$value->route_system_pages->err401($input);
												}
											}else{
												$input->body = $post;
												$input->params = $get; 
												$value->$localClass->$localFunction($input);
											}
										}else{
											$input->body = $post;
											$input->params = $get; 
											$value->route_system_login->_login($input);
										}
									}else{
										if($localRequireRole > 0){
											$fineRole = array_search($this->getSessionVar("user_role"), $localRole);
											if(gettype($fineRole) == 'integer' && $fineRole >= 0){
												$input->body = $post;
												$input->params = $get;
												$value->$localClass->$localFunction($input);
											}else{
												$value->route_system_pages->err401($input);
											}
										}else{
											$input->body = $post;
											$input->params = $get; 
											$value->$localClass->$localFunction($input);
										}
									}
								}
							}
						}else{
							$input->body = $post;
							$input->params = $get; 
							$value->route_system_pages->err404($input);
						}
					}
				}
			}else{
				$input->body = $post;
				$input->params = $get; 
				$value->route_system_pages->err404($input);
			}
		}
	}
?>