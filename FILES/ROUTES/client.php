<?php
	class client extends Core {
		// public function _init($param){
		// 	$checkSession = $this->checkSession();
		// 	if(!$checkSession){
		// 		$this->__template->cTitle = 'Login Page';
		// 		$this->__tConfig->template = "/TEMPLATE/Default/blank.html";
		// 		$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/About.html");
		// 		$this->render();
		// 	}else{
		// 		$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Login/home.html");
		// 		$this->__data->name = "hello";
		// 		$this->__data->test = array("hello","world");
		// 		$this->render();
		// 	}
		// }
		public function _profile($param){
			$this->__template->cTitle = 'Profile Page';
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/profile.html");
			$this->__data->name = "hello";
			$this->__data->test = array("hello","world");
			$this->render();
		}
		public function _assets($param){
			// $this->response($this->pluginlist(1));
			//$this->response($this->getServerSetting('maintenance'));
			$this->response($this->updateServerSetting('server_value', 1, 'server_function', 'gateway'));
		}
	}
?>