<?php
	class system_login extends Core {
		public function _login($param){
			$this->__template->cTitle = 'Login Page';
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/LAYOUT/login.html";
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/login.html");
			$this->render();
		}
		public function _forgot_password($param){
			$this->__template->cTitle = 'Login Page';
			$this->__tConfig->template = "/TEMPLATE/SYSTEM/LAYOUT/login.html";
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/SYSTEM/MISC/forgot_password.html");
			$this->render();
		}
		public function _logout($param){
			$logout = $this->setLogout();
			$this->response($logout);
		}	
		public function _apiLogin($param){
			$response = $this->newClass(); // create object;
			$input = $this->newClass();
			$input->username = $param->body['username']; 
			$input->password = $this->encrypt($param->body['password']);
			if($this->checkGateway()){
				$branch_id = $_SESSION['branch_id'];
				$input->query = "SELECT * FROM user WHERE username = '$input->username' AND password = '$input->password' AND branch_id = '$branch_id'";
			}else{
				$input->query = "SELECT * FROM user WHERE username = '$input->username' AND password = '$input->password'";
			}
			$query = $this->execQuery("fetch",$input->query);
			if($query->status){
				$response->message = "Success login!";
				$response->status = true;
				$response->redirect = '';
				$this->setLogin($query->data);
			}else{
				$response->message = "User Doest exist!";
				$response->status = false;
			}
			$this->response($response);
		}
	}
?>