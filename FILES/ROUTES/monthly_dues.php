<?php
	class monthly_dues extends Core {
		
		public function _generate($param){
			$response = $this->newClass();
			$response->status = false;
			$response->message = "";
			$year = $param->params["year"];
			$month = $param->params["month"];
			$amount = $param->params["amount"];
			$response->year = $year;
			$response->month = $month;
			$getRecord = $this->builder->select("monthly_dues_record")->where([["year", "=", $year], ["month", "=", $month]])->string();
			$getRecordQuery = $this->execQuery("fetch", $getRecord, true);
			if($getRecordQuery){
				if($getRecordQuery->data && count($getRecordQuery->data) > 0){
					$genMonthlyDueMemberObject = $this->newClass();
					$genMonthlyDueMemberObject->id = 'record_id';
					$genMonthlyDueMember = $this->builder->select("organization_member", $genMonthlyDueMemberObject)->string();
					$genMonthlyDueMemberQuery = $this->execQuery("fetch", $genMonthlyDueMember, true);
					for($a = 0; $a < count($genMonthlyDueMemberQuery->data); $a++){
						$object = array();
						$object[0] = ["year", "=", $year];
						$object[1] = ["month", "=", $month];
						$object[2] = ["member_id", "=", $genMonthlyDueMemberQuery->data[$a]['id']];
						$checkMonthlyDue = $this->builder->select("monthly_dues")->where($object)->count('id')->string();
						$checkMonthlyDueQuery = $this->execQuery("fetch", $checkMonthlyDue);
						if($checkMonthlyDueQuery && !$checkMonthlyDueQuery->data->result){
							$insertDue = array();
							$insertDue['month'] = $month;
							$insertDue['year'] = $year;
							$insertDue['amount'] = $genMonthlyDueMemberQuery->data[$a]['monthly_due_fee'];
							$insertDue['balance'] = $genMonthlyDueMemberQuery->data[$a]['monthly_due_fee'];
							$insertDue['member_id'] = $genMonthlyDueMemberQuery->data[$a]['id'];
							$insertDue['dues_record_id'] = $getRecordQuery->data[0]['id'];
							$genMonthlyDue = $this->builder->insert("monthly_dues", $insertDue)->string();
							$genMonthlyDueQuery = $this->execQuery("insert", $genMonthlyDue);
						}else{

						}
					}
				}
			}
			$this->response($response);
		}
	}
?>