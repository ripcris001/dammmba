<?php
class Builder {
	public  $counter,
			$qselect,
			$qselectparam,
			$qselecttable,
			$qupdatetable,
			$qupdateset,
			$qinserttable,
			$qinsertfield,
			$qinsertvalue,
			$qwhere,
			$qlj,
			$qorder,
			$qlimit,
			$qoffset;
	public function __construct(){
		$this->reset();
	}
	public function reset(){
		$this->counter = new stdClass();
		$this->counter->select = 0;
		$this->counter->where = 0;
		$this->counter->set = 0;
		$this->counter->leftjoin = 0;
		$this->counter->update = 0;
		$this->counter->insert = 0;
		$this->counter->ifield = 0;
		$this->counter->delete = 0;

		$this->qselect = null;
		$this->qselectparam = null;
		$this->qselecttable = null;
		$this->qupdatetable = null;
		$this->qupdateset = null;
		$this->qinserttable = null;
		$this->qinsertfield = null;
		$this->qinsertvalue = null;
		$this->qwhere = null;
		$this->qlj = null;
		$this->qorder = null;
		$this->qlimit = null;
		$this->qoffset = null;
	}
	public function select($table, $param = null){
		$this->qselect = "SELECT ";
		$type = gettype($table);
		if($type == 'string'){
			$this->qselectparam = " * ";
			$this->qselecttable = " FROM `$table`";
		}else if($type == 'array' || $type == 'object'){
			$count = count((array)$table);
			$ct = 0;
			foreach($table as $key => $value) {
				$ct++;
				$oKey = $key;
				$oValue = $value;
				$cValue = 0;
				$cKey = 0;
				$keyType = 0;
				if(gettype($key) == 'string'){
					$value = explode('.', $value);
					$key = explode('.', $key);
					$cValue = count($value);
					$cKey = count($key);
					$keyType = 1;
				}
				if($keyType != 1){
					if($ct == 1){
						$this->qselectparam = $this->qselectparam." `$value` ";
					}else{
						$this->qselectparam = $this->qselectparam.", `$value` ";
					}
				}else{
					if($ct == 1){
						if($oKey == $oValue){
							$this->qselectparam = $cValue == 1 ? $this->qselectparam." `$value[0]` " : $this->qselectparam." `$value[0]`.`$value[1]` ";
						}else{
							$this->qselectparam = $cKey == 1 ? $this->qselectparam." `$key[0]` as `$value[0]` " : $this->qselectparam." `$key[0]`.`$key[1]` as `$value[0]` ";	
						}
					}else{
						if($oKey == $oValue){
							$this->qselectparam = $cValue == 1 ? $this->qselectparam.", `$value[0]` " : $this->qselectparam.", `$value[0]`.`$value[1]` ";
						}else{
							$this->qselectparam = $cKey == 1 ? $this->qselectparam.", `$key[0]` as `$value[0]` " : $this->qselectparam.", `$key[0]`.`$key[1]` as `$value[0]` ";
						}
					}
				}
			}
			$this->qselecttable = $this->qselecttable." FROM `$param`";
		}
		$this->counter->select = 1;
		return $this;
	}
	public function count($param = null){
		$type = gettype($param);
		if($type == 'string'){
			$this->qselectparam = " count(`$param`) as `result` ";
		}else if($type == 'array'){
			$this->qselectparam = " count(`$param[0]`) as `$param[1]` ";
		}
		$this->counter->select = 1;
		return $this;
	}
	public function sum($param = null){
		$type = gettype($param);
		if($type == 'string'){
			$this->qselectparam = " sum(`$param`) as `result` ";
		}else if($type == 'array'){
			$this->qselectparam = " sum(`$param[0]`) as `$param[1]` ";
		}
		$this->counter->select = 1;
		return $this;
	}
	public function where($param){
		$count = count($param);
		foreach ($param as $key => $value) {
			if(!$this->counter->where){
				$this->qwhere = $this->qwhere." WHERE ";
			}else{
				$this->qwhere = $this->qwhere." AND ";
			}
			$this->qwhere = $this->qwhere." `$value[0]` $value[1] '$value[2]' ";
			$this->counter->where += 1;	
		}
		return $this;
	}
	public function leftjoin($p1, $p2, $p3){
		$p2 = explode(".",$p2);
		$p3 = explode(".",$p3);
		$this->qlj = $this->qlj." LEFT JOIN `$p1` on `$p2[0]`.`$p2[1]` = `$p3[0]`.`$p3[1]` ";
		$this->counter->leftjoin += 1;
		return $this;
	}
	public function limit($param){
		$this->qlimit = $this->qlimit." limit $param ";
		return $this;
	}
	public function offset($param){
		$this->qlimit = $this->qlimit." offset $param ";
		return $this;
	}
	public function order($param, $ord){
		$type = gettype($param);
		if($type == 'string'){
			$this->qorder = $this->qorder." order by `$param` $ord ";
		}else if($type == 'array'){
			$this->qorder = $this->qorder." order by `$param[0]` $param[1] ";
		}
		return $this;
	}
	public function update($table, $param = null){
		$this->qupdatetable = "UPDATE `$table` ";
		if(gettype($param) == 'array' && count($param) > 0){
			foreach ($param as $key => $value) {
				if(!$this->counter->set){
					$this->qupdateset = $this->qupdateset." SET `$key` = '$value' ";
				}else{
					$this->qupdateset = $this->qupdateset.", SET `$key` = '$value' ";
				}
				$this->counter->set += 1;
			}
		}
		$this->counter->update = 1;
		return $this;
	}
	
	public function set($param = null){
		if(gettype($param) == 'array' && count($param) > 0){
			foreach ($param as $key => $value) {
				if(!$this->counter->set){
					$this->qupdateset = $this->qupdateset." SET `$key` = '$value' ";
				}else{
					$this->qupdateset = $this->qupdateset.", SET `$key` = '$value' ";
				}
				$this->counter->set += 1;
			}
		}
		return $this;
	}
	public function insert($table, $param = null){
		$this->qinserttable = "INSERT INTO `$table` ";
		if(gettype($param) == 'array' && count($param) > 0){
			foreach ($param as $key => $value) {
				if(!$this->counter->ifield){
					$this->qinsertfield = $this->qinsertfield." `$key` ";
					$this->qinsertvalue = $this->qinsertvalue." '$value' ";
				}else{
					$this->qinsertfield = $this->qinsertfield.", `$key` ";
					$this->qinsertvalue = $this->qinsertvalue.", '$value' ";
				}
				$this->counter->ifield += 1;
			}
		}
		$this->counter->insert = 1;
		return $this;
	}
	public function build(){
		$query = '';
		if($this->counter->select){
			$query = $this->qselect.
				$this->qselectparam.
				$this->qselecttable.
				$this->qlj.
				$this->qwhere.
				$this->qorder.
				$this->qlimit.
				$this->qoffset;
		}else if($this->counter->update){
			$query = $this->qupdatetable.
				$this->qupdateset.
				$this->qwhere;
		}else if($this->counter->insert){
			$query = $this->qinserttable.
				" (".$this->qinsertfield.") ".
				" VALUES (".$this->qinsertvalue.") ".
				$this->qwhere;
		}else if($this->counter->delete){

		}
		return $query;
	}
	public function string(){
		$query = $this->build();
		$this->reset();
		return $query;
	}
}

?>