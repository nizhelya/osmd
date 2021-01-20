<?php
class Registration
{
	private $_db;	
	public $results;
	
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YISGRAND');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}

	

	public function active($name,$kod,$remember)
	{

		$_db = $this->__construct();	
		 $_login=$name;
		 $_key=$kod;
		 $_sql_update='UPDATE USERS SET active=1 WHERE login="'.$_login.'" and keysend="'.$_key.'"'; 	
		 // print($_sql_update);
		 $_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 $rows=mysqli_affected_rows($_db);
		// $rows=1;

		 return $rows;
		
	}
}	

      try {
		if    (isset($_GET['code']) && !empty($_GET['code'])) {//код подтверждения 
			$code=$_GET['code'];
		 } else {     
			//print($_GET['code']);
			throw new Exception('Вы  зашли на страницу без кода подтверждения!');
		}
		 if    (isset($_GET['login']) && !empty($_GET['login'])){ //код подтверждения 
			$login=$_GET['login'];
		 } else {           
			throw new Exception("Вы    зашли на страницу без логина!");
		}
			
		   $obj = new Registration();
		   $active=$obj->active($login,$code);
		 //   print_r($active);

		
		if ($active){
		  
		// header( 'Location: http://localhost/is/index.php?login="'.$login.'"', true, 301 );
		//$r['login'] =header('Location: http://is.yuzhny.com/is/index.php?login="'.$login.'"', true, 301 );
		$r['login'] =header('Location: http://is.yuzhny.com/is/index.php?login='.$login.'&code='.$code.'', true, 301 );
		} else {
		
			throw new Exception("Не удалось зарегистрироватся");
		}
		
	}
	catch(Exception $e){
		$r['message'] = $e->getMessage();
		
	}

	return print_r($r);


