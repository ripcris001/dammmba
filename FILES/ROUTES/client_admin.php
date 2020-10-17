<?php
	class client_admin extends Core {
		public function _dashboard($param){
			$this->__plugin->blacklist = array('/data-tables/js/dataTables.select.min.js');
			$this->__plugin->use = array('data_tables','');
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/admin/user.html");
			$this->__data->edit = $param->role->write ? 1 : 0;
			$this->__data->addButton = $this->genButton($param->role->write, false, false);
			$this->__data->addUserModal = '';
			$input = $this->newClass();
			$input->query = "SELECT * FROM user";
			$query = $this->execQuery("fetch",$input->query, 1);
			if($query->status){
				$that = $this;
				$tempData = array();
				foreach ($query->data as $key => $value) {
					$loopData = $value;
					$loopData["code"] = $that->encrypt($loopData['user_id']);
					$loopData["action"] = $this->genButton(false, $param->role->write, $param->role->delete, $loopData["code"]);
					array_push($tempData, $loopData);
				}
				$this->__data->users = $tempData;
			}else{
				$this->__data->users = array();
			}
		}	
		public function _user($param){
			$this->__template->cTitle = 'Manage User';
			$this->__plugin->blacklist = array('/data-tables/js/dataTables.select.min.js');
			$this->__plugin->use = array('data_tables');
			$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/admin/user.html");
			$this->__data->edit = $param->role->write ? 1 : 0;
			$this->__data->addButton = $this->genButton($param->role->write, false, false);
			$this->__data->addUserModal = isset($param->role->write) && $param->role->write ? $this->loadTemplate("/TEMPLATE/Pages/modal/addUser.html"): '';
			$this->__data->editUserModal = isset($param->role->write) && $param->role->write ? $this->loadTemplate("/TEMPLATE/Pages/modal/editUser.html"): '';
			$tempUL = $this->getUser(false, true);
			if($tempUL->status){
				// additional plugin when user has write role
				if(isset($param->role->write) && $param->role->write){
					array_push($this->__plugin->use, 'jquery_validation');
				}
				$that = $this;
				$tempData = array();
				foreach ($tempUL->data as $key => $value) {
					$loopData = $value;
					$loopData["code"] = $that->encrypt($loopData['user_id']);
					$loopData["action"] = $this->genButton(false, $param->role->write, $param->role->delete, $loopData["code"]);
					$loopData["user_role"] = $this->getRole($loopData["user_role"])->data->role_name;
					$loopData["branch_id"] = $this->getBranch($loopData["branch_id"])->data->branch;
					$loopData["user_id"] = null;
					array_push($tempData, $loopData);
				}
				$this->__data->users = $tempData;
			}else{
				$this->__data->users = array();
			}
			$TempUR = $this->getRole(false, true);
			$tempURData = array();
			foreach ($TempUR->data as $key => $value) {
				$loopData = new stdClass();
				$loopData->id = $that->encrypt($value['role_id']);
				$loopData->name = $value['role_name'];
				array_push($tempURData, $loopData);
			}
			$TempBranch = $this->getBranch(false, true);
			$tempBranchData = array();
			foreach ($TempBranch->data as $key => $value) {
				$loopData = new stdClass();
				$loopData->id = $that->encrypt($value['branch_id']);
				$loopData->name = $value['branch'];
				array_push($tempBranchData, $loopData);
			}
			$this->__data->branch_list = $tempBranchData;
			$this->__data->role_list = $tempURData;
			$this->render();
		}

		// api fo users 
		public function _api_get_user($param){
			$response = $this->newClass();
			$response->status = false;
			$user_id = $this->decrypt($param->body['id']);
			$iquery = "SELECT * FROM user WHERE user_id = '$user_id'";
			$query = $this->execQuery("fetch",$iquery);
			if($query->status){
				$response->message = "Successfully gather user information";
				$response->status = true;
				$response->data = $query->data;
			}else{
				$response->message = "User Doest exist!";
				$response->status = false;
			}
			$this->response($response);
		}
		public function _api_add_user($param){
			$response = $this->newClass();
			$response->status = false;
			$response->message = "";
			$input = $this->newClass();
			if(isset($param->body)){
				foreach ($param->body as $key => $value) {
					$input->$key = $value;
				}
				$input->query = "SELECT * FROM user WHERE username = '$input->username'";
				if($this->execQuery("fetch",$input->query)->status){
					$response->message = "Username already exist";
				}else{
					$input->query = "SELECT * FROM user WHERE email='$input->email'";
					if($this->execQuery("fetch",$input->query)->status){
						$response->message = "email already exist";
					}else{
						$input->password = $this->encrypt($input->password);
						$input->user_role = $this->decrypt($input->user_role);
						$input->branch_id = $this->decrypt($input->branch_id);
						$input->query = "INSERT INTO user (username, password, name, email, user_role, branch_id) VALUES ('$input->username','$input->password','$input->name','$input->email','$input->role','$input->branch_id')";
						$query = $this->execQuery("insert",$input->query);
						if($query->status){
							$response->status = true;
							$response->message = "Successfully added new user.";
						}else{
							$response->message = "Failed to add new user.";
						}
					}
				}
			}else{
				$response->message = "Please input data.";
			}
			$this->response($response);
		}
		public function _api_delete_user($param){
			$response = $this->newClass();
			$response->status = false;
			$response->message = "";
			$input = $this->newClass();
			if(isset($param->body)){
				foreach ($param->body as $key => $value) {
					$input->$key = $value;
				}
				$input->id = $this->decrypt($input->id);
				$input->query = "SELECT * FROM user WHERE user_id = '$input->id'";
				if($this->execQuery("fetch",$input->query)->status){
					$input->query = "DELETE FROM user WHERE user_id = '$input->id'";
					if($this->execQuery("delete",$input->query)->status){
						$response->status = true;
						$response->message = "Successfully delete user";
					}else{
						$response->message = "Failed to delete user";
					}
				}else{
					$response->message = "Username doesnt exist";
				}
			}else{
				$response->message = "Please input data.";
			}
			$this->response($response);
		}
		public function _test($param){
			$response = $this->newClass();
			
			$response->data = $this->genMonthlyDuesRecord();
			
			$this->response($response);
		}
	}
?>