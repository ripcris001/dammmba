<?php
class Connection extends mysqli implements settings {
	public $MySQL;
    public function __construct(){
        $this->connectDB();
    }
	public function initMySql() 
	{
        $this->MySQL = new stdClass();
        $this->MySQL->Connection = null;
        $this->MySQL->TotalQuery = 0;
        $this->MySQL->Configurations = null;
		$this->MySQL->Error = null;
	}
	
	public function connectDB() {
		$this->initMySql();
        parent::__construct(settings::db_host, settings::db_user, settings::db_pass, settings::db_database);
        if (mysqli_connect_error()){
			$this->SystemExit("Error: [" . mysqli_connect_errno() ."] ". mysqli_connect_error(), __LINE__, __FILE__);
			$this->MySQL->Connection = false;
			$this->MySQL->Error = "mysqli_connect_errno() . mysqli_connect_error()";
        }else{
			$this->MySQL->Connection = true;
		}
    }
	
	public function DBase($type, $params) {
        if (!$this->MySQL->Connection)
        $this->SystemExit('No available MySQLi connection', __LINE__, __FILE__);
        
        switch (strtolower($type)) {
        case 'query':
            if ($Query = parent::query($params)) {
                $this->MySQL->TotalQuery++;
                return $Query;
            } else
            $this->SystemExit('MySQLi failed to query: ' . $params, __LINE__, __FILE__);
            break;
        case 'prepare':
            if ($Query = parent::prepare($params)) {
                $this->MySQL->TotalQuery++;
                return $Query;
            } else
            $this->SystemExit('MySQLi failed to prepare: ' . $params, __LINE__, __FILE__);
            break;
        case 'escapestring':                
            if ($Escape = parent::real_escape_string($params))
            return $Escape;
            else
            $this->SystemExit('MySQLi failed to escape: ' . $params, __LINE__, __FILE__);                
            break;
        }
    }
	
	public function SystemExit($text, $line, $file = null) {
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: text/plain');
        print ("$text - " . date("F j, Y, g:i a"));
        //print ("\nLocation: $file ($line)");
        exit(1);
    }
}
?>