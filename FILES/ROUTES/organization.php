<?php
	class organization extends Core {
		public function _init($param){
			$that = $this;
			$this->templateSetter($this->checkSession());
			if(isset($param->params['organization'])){
				$getOrg = $this->getOrganization($this->decrypt($param->params['organization']));
				if($getOrg->status){
					foreach ($getOrg->data as $key => $value) {
						$this->__data->$key = $value;
					}
					$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/organization/details.html");
				}else{
					$this->__template->cContent = $this->loadTemplate("/TEMPLATE/SYSTEM/COMPONENT/ERROR/404.html");
				}
			}else{
				$this->__plugin->blacklist = array('/data-tables/js/dataTables.select.min.js');
				$this->__plugin->use = array('data_tables');
				$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/organization/home.html");
				$this->__data->edit = $param->role->write ? 1 : 0;
				$this->__data->addButton = $this->genButton($param->role->write, false, false);
				$this->__data->addOrgModal = isset($param->role->write) && $param->role->write ? $this->loadTemplate("/TEMPLATE/Pages/modal/addOrganization.html") : "";
				$input = $this->newClass();
				$input->query = "SELECT * FROM organization";
				$query = $this->execQuery("fetch",$input->query, 1);
				if($query->status){
					// additional plugin when user has write role
					if(isset($param->role->write) && $param->role->write){
						array_push($this->__plugin->use, 'jquery_validation');
					}
					$tempData = array();
					foreach ($query->data as $key => $value) {
						$loopData = $value;
						$loopData["code"] = $that->encrypt($loopData['id']);
						$loopData["action"] = $this->genButton(false, $param->role->write, $param->role->delete, $loopData["code"]);
						$loopData['id'] = null;
						array_push($tempData, $loopData);
					}
					$this->__data->organization = $tempData;
				}else{
					$this->__data->organization = array();
				}
				$lhData = $this->getLandHoldings(false, true);
				$tempLHData = array();
				foreach ($lhData->data as $key => $value) {
					$loopData = new stdClass();
					$loopData->id = $that->encrypt($value['id']);
					$loopData->name = $value['landholdings_name'];
					array_push($tempLHData, $loopData);
				}
				$this->__data->lh_list = $tempLHData;
			}
			$this->render();
		}

		public function _member($param){
			$that = $this;
			$this->templateSetter($this->checkSession());
			if(isset($param->params['organization'])){
				$getOrg = $this->getOrganization($this->decrypt($param->params['organization']));
				if($getOrg->status){
					foreach ($getOrg->data as $key => $value) {
						$this->__data->$key = $value;
					}
					$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/organization/member.html");
				}else{
					$this->__template->cContent = $this->loadTemplate("/TEMPLATE/SYSTEM/COMPONENT/ERROR/404.html");
				}
			}else{
				$this->__plugin->blacklist = array('/data-tables/js/dataTables.select.min.js');
				$this->__plugin->use = array('data_tables');
				$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/organization/member.html");
				$this->__data->edit = $param->role->write ? 1 : 0;
				$this->__data->addButton = $this->genButton($param->role->write, false, false);
				$this->__data->addOrgModal = isset($param->role->write) && $param->role->write ? $this->loadTemplate("/TEMPLATE/Pages/modal/addOrganization.html") : "";
				$input = $this->newClass();
				$input->query = "SELECT * FROM organization_member";
				$query = $this->execQuery("fetch",$input->query, 1);
				if($query->status){
					// additional plugin when user has write role
					if(isset($param->role->write) && $param->role->write){
						array_push($this->__plugin->use, 'jquery_validation');
					}
					$tempData = array();
					foreach ($query->data as $key => $value) {
						$loopData = $value;
						$orgname = $this->getOrganization($loopData["organization_id"])->data;
						$encOrg = $this->encrypt($loopData["organization_id"]);
						$loopData["code"] = $that->encrypt($loopData['id']);
						$loopData["action"] = $this->genButton(false, $param->role->write, $param->role->delete, $loopData["code"]);
						$loopData["organization_id"] = '<a href="/organization?organization='.$encOrg.'">'."$orgname->organization_name [$orgname->acroname]</a>";
						$loopData['id'] = null;
						array_push($tempData, $loopData);
					}
					$this->__data->organization_member = $tempData;
				}else{
					$this->__data->organization_member = array();
				}
				$lhData = $this->getLandHoldings(false, true);
				$tempLHData = array();
				foreach ($lhData->data as $key => $value) {
					$loopData = new stdClass();
					$loopData->id = $that->encrypt($value['id']);
					$loopData->name = $value['landholdings_name'];
					array_push($tempLHData, $loopData);
				}
				$this->__data->lh_list = $tempLHData;
			}
			$this->render();
		}

		/* =========== api client side =========== */
		public function _api_add_org($param){
			$response = $this->newClass();
			$response->status = false;
			$response->message = "";
			$input = $this->newClass();
			if(isset($param->body)){
				foreach ($param->body as $key => $value) {
					$input->$key = $value;
				}
				$input->landholdings_id = $this->decrypt($input->landholdings_id);
				$input->query = "SELECT * FROM organization WHERE organization_name = '$input->organization_name'";
				if($this->execQuery("fetch",$input->query)->status){
					$response->message = "Organization already exist";
				}else{
					$input->query = "INSERT INTO organization (landholdings_id, organization_name, acroname, municipality, address, registration_number, registration_agency, date_registered, accridited_number, date_accridited, for_registration) VALUES ('$input->landholdings_id','$input->organization_name','$input->acroname','$input->municipality','$input->address','$input->registration_number','$input->registration_agency','$input->date_registered','$input->accridited_number','$input->date_accridited','$input->for_registration')";
					$query = $this->execQuery("insert",$input->query);
					if($query->status){
						$response->status = true;
						$response->message = "Successfully added new landholding.";
					}else{
						$response->message = "Failed to add new landholding.";
					}
				}
			}else{
				$response->message = "Please input data.";
			}
			$this->response($response);
		}
	}
?>