<?php
include_once './yis_config.php';

class QueryUserLogin
{
	private $_db;
	protected $login;
	protected $password ;	
	protected $sql;
	public $results  ;
	

	public function connect($login,$password)
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', $login ,$password, 'YISGRAND');
		if ($_db->connect_error) {
			return false;
		} else {		
		$_db->set_charset("utf8");    
		return $_db;
		}
	}

		public function login(stdClass $params)
	{
    
		if(isset($params->login) && ($params->login)) {
		  $this->login= addslashes($params->login);
		} else {
		   $this->login= null;
		}
		
		if(isset($params->password) && ($params->password)) {
		  $this->password= $params->password;
		} else {
		   $this->password= null;
		}


		$_db = $this->connect($this->login,$this->password);
		if(isset($params->memorize) && ($params->memorize)) {
		  $this->remember= $params->memorize;
		} else {
		   $this->remember=0;
		}		

		if($_db){

$this->sql='SELECT t1.`login`,t1.`user_id`,t1.`role`,t1.`org_id` as prixod_id FROM YISGRAND.COMMUN_USERS as t1 WHERE t1.`login` = "'.$this->login.'" and t1.`password` = password("'.$this->password.'") ' ; 
		 $_result = $_db->query($this->sql) or die('Connect Error (' . $this->sql. ') ' . $_db->connect_error);		
		 $results = new stdClass();
		if	($rows=mysqli_affected_rows($_db)){
		      while ($row = $_result->fetch_assoc()) {
			$results->user_id = $row['user_id'];
			$results->login	= $row['login'];
			$results->password = $this->password;
			$results->role= $row['role'];
			$results->prixod_id= $row['prixod_id'];
			$results->success = true;
			}
		} else{
			$results->success = false;
		}
		
		
		}else{
		  $results->success = false;
		}
		return $results;
	}
}
