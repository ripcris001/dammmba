<?php
	class admin_dashboard extends Core {
		public function _dashboard($param){
			$this->enable_admin = 1;
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/ADMIN/PAGES/dashboard.html");
			$this->render();
		}
		public function _helper($param){
			$this->enable_admin = 1;
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/ADMIN/PAGES/helper.html");
			$this->__data->plugin = $this->pluginlist(1);
			$this->render();
		}
		public function _user($param){
			
			$this->enable_admin = 1;
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/ADMIN/PAGES/user.html");
			$input = $this->newClass();
			$input->query = "SELECT * FROM user";
			$query = $this->execQuery("fetch",$input->query, 1);
			if($query->status){
				$this->__data->user = $query->data;
			}else{
				$this->__data->user = array();
			}
			$this->render();
		}
		public function _routes($param){
			$this->enable_admin = 1;
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/ADMIN/PAGES/routes.html");
			$input = $this->newClass();
			$input->query = "SELECT * FROM routes";
			$query = $this->execQuery("fetch",$input->query, 1);
			if($query->status){
				$this->__data->routes = $query->data;
			}else{
				$this->__data->routes = array();
			}
			$this->render();
		}
	}
?>