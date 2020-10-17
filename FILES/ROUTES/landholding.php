<?php
	class landholding extends Core {
		public function _init($param){
			$this->templateSetter($this->checkSession());
			if(isset($param->params['landholdings'])){
				$getLH = $this->getLandHoldings($this->decrypt($param->params['landholdings']));
				if($getLH->status){
					$this->__data->landholdings_name = $getLH->data->landholdings_name;
					$this->__data->landowner_name = $getLH->data->landowner_name;
					$this->__data->title_number = $getLH->data->title_number;
					$this->__data->lot_number = $getLH->data->lot_number;
					$this->__data->lot_area = $getLH->data->lot_area;
					$this->__data->landholdings_address = $getLH->data->barangay. ", ".$getLH->data->municipality;
					$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/landholding/details.html");
				}else{
					$this->__template->cContent = $this->loadTemplate("/TEMPLATE/SYSTEM/COMPONENT/ERROR/404.html");
				}
			}else{
				$this->__plugin->blacklist = array('/data-tables/js/dataTables.select.min.js');
				$this->__plugin->use = array('data_tables');
				$this->__template->cContent = $this->loadTemplate("/TEMPLATE/Pages/landholding/home.html");
				$this->__data->edit = $param->role->write ? 1 : 0;
				$this->__data->addButton = $this->genButton($param->role->write, false, false);
				$this->__data->addLandholdingModal = isset($param->role->write) && $param->role->write ? $this->loadTemplate("/TEMPLATE/Pages/modal/addlandholding.html") : "";
				$query = $this->getLandHoldings(false, true);
				if($query->status){
					// additional plugin when user has write role
					if(isset($param->role->write) && $param->role->write){
						array_push($this->__plugin->use, 'jquery_validation');
					}
					$that = $this;
					$tempData = array();
					foreach ($query->data as $key => $value) {
						$loopData = $value;
						$loopData["code"] = $that->encrypt($loopData['id']);
						$loopData["action"] = $this->genButton(false, $param->role->write, $param->role->delete, $loopData["code"]);
						$loopData["id"] = null;
						array_push($tempData, $loopData);
					}
					$this->__data->landholding = $tempData;
				}else{
					$this->__data->landholding = array();
				}
			}
			$this->render();
		}
		public function _api_add_lh($param){
			$response = $this->newClass();
			$response->status = false;
			$response->message = "";
			$input = $this->newClass();
			if(isset($param->body)){
				foreach ($param->body as $key => $value) {
					$input->$key = $value;
				}
				$input->query = "SELECT * FROM landholdings WHERE landholdings_name = '$input->landholdings_name'";
				if($this->execQuery("fetch",$input->query)->status){
					$response->message = "Landholding already exist";
				}else{
					$input->query = "INSERT INTO landholdings (municipality, barangay, landholdings_name, landowner_name, title_number, lot_number, lot_area) VALUES ('$input->municipality','$input->barangay','$input->landholdings_name','$input->landowner_name','$input->title_number','$input->lot_number','$input->lot_area')";
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