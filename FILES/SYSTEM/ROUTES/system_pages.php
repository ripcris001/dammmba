<?php
	class system_pages extends Core {
		public function lock($param){
			$this->__tConfig->template = "/TEMPLATE/Default/lock-no-login.html";
			$this->__data->name = 'Server is lock';
			$this->__data->img = 'images/biohazard--v1.png';
			$this->render();
		}
		public function maintenance($param){
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/MISC/maintenance.html";
			$this->__data->name = "kim den";
			$this->__data->img = 'images/biohazard--v1.png';
			$this->render();
		}
		public function err404($param){
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/ERROR/404.html";
			$this->__data->img = 'images/biohazard--v1.png';
			$this->render();
		}
		public function err403($param){
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/ERROR/403.html";
			$this->__data->img = 'images/biohazard--v1.png';
			$this->render();
		}
		public function err401($param){
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/ERROR/401.html";
			$this->__data->img = 'images/biohazard--v1.png';
			$this->render();		
		}
		public function not_login($param){
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/ERROR/404.html";
			$this->__data->img = 'images/biohazard--v1.png';
			$this->render();
		}
		public function _gateway($param){
			if($param && $param->method && $param->method == "GET"){
				$this->__tConfig->template = "/TEMPLATE/SYSTEM/MISC/gateway.html";
				$this->__data->name = "Gateway Required";
				$this->__data->img = 'images/biohazard--v1.png';
				$this->render();
			}else if($param && $param->method && $param->method == "POST"){
				$input = $this->newClass();
				$response = $this->newClass();
				$response->status = false;
				$response->message = "";
				if($param->body && $param->body["type"] == "gateway"){
					$input_gateway = $this->encrypt($param->body["gateway"]);
					$input->query = "SELECT * FROM user_gateway WHERE gateway_key = '$input_gateway'";
					$query = $this->execQuery("fetch",$input->query);
					if($query->status){
						$set = $this->setGateway($query->data);
						$response->message = $set->message;
						$response->status = $set->status;
						$this->response($response);
					}else{
						$response->message = "Gateway key doest exist!";
						$response->status = false;
						$this->response($response);
					}					
				}else{
					$response->message = "Not a gateway request.";
					$this->response($response);
				}
				
			}else{
				$this->__tConfig->template = "/TEMPLATE/SYSTEM/ERROR/404.html";
				$this->render();
			}
		}
		public function _logoutGateway($param){
			$logout = $this->setLogoutGateway();
			$this->response($logout);
		}
	}
?>