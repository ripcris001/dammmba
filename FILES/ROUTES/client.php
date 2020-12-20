<?php
	class client extends Core {
		public function _profile($param){
			$this->__template->cTitle = 'Profile Page';
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/profile.html");
			$this->__data->name = "hello";
			$this->__data->test = array("hello","world");
			$this->render();
		}
		public function _assets($param){
			$this->response($this->updateServerSetting('server_value', 1, 'server_function', 'gateway'));
		}
		public function _qbuilder($param){
	
			$object = array();
			$object["member_name"] = "Versus";
			$query = $this->builder->select('organization_member')->
				toString();
			$Org = $this->execQuery("fetch",$query, true);
			$this->response($Org);
		}
		public function _qbuilderDisplay($param){
			$object = array();
			$object["organization_id"] = "1";
			$object["member_name"] = "Test1";
			$object["gender"] = "Female";
			$object["position"] = "1";
			$object["membership_fee"] = "500";
			$object["address"] = "Address";
			$query = $this->builder->insert('organization_member', $object)->string();
			$this->response($query);
		}
	}
?>