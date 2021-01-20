<?php

class QueryReport
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $id;
	protected $what;
	protected $nomer;
	protected $type_id;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
	/*public function connect($this->login,$this->password)
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YISGRAND');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}*/
	
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


	    public function getResults(stdClass $params)
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
	
		if(isset($params->what) && ($params->what)) {
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}


// num
$this->cat_id=0;
$this->raion_id=0;
$this->dog_id=0;
$this->house_id=0;
$this->org_id=0;
$this->cat_yes=0;
$this->raion_yes=0;
$this->house_yes=0;
$this->org_yes=0;
//string
$this->date_from='';
$this->date_to='';

$array = (array) $params;
foreach ( $array as $key => $value ) 
  {
   if(isset($value)) {  
			$t = strtotime($value);
			$m = date('m',$t);
			$d = date('d',$t);
			$y = date('Y',$t);
			$chd= checkdate ($m, $d, $y);
			if ($chd) { $this->$key =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$value);} 
			else if (is_int($value)) { $this->$key= (int)$value;}
			else if (is_float($value)) { $this->$key= $value;}
			else {$this->$key =$_db->real_escape_string($value);}
   }
}
$this->sql='';
		switch ($this->what) {

			case "tabOtSvNach":			
			      $this->sql='CALL YISGRAND.tabOtSvNach('
			      .$this->cat_id.', '
			      .$this->raion_id.', '
			      .$this->house_id.', '
			      .$this->org_id.', '
			      .$this->cat_yes.', '
			      .$this->raion_yes.', '
			      .$this->house_yes.', '
			      .$this->org_yes.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_org":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_org('
			      .$this->cat_id.', '
			      .$this->raion_id.', '
			      .$this->house_id.', '
			      .$this->org_id.', '
			      .$this->cat_yes.', '
			      .$this->raion_yes.', '
			      .$this->house_yes.', '
			      .$this->org_yes.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_money":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_money('
			      .$this->cat_id.', '
			      .$this->raion_id.', '
			      .$this->house_id.', '
			      .$this->org_id.', '
			      .$this->cat_yes.', '
			      .$this->raion_yes.', '
			      .$this->house_yes.', '
			      .$this->org_yes.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_org_money":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_org_money('
			      .$this->cat_id.', '
			      .$this->raion_id.', '
			      .$this->house_id.', '
			      .$this->org_id.', '
			      .$this->cat_yes.', '
			      .$this->raion_yes.', '
			      .$this->house_yes.', '
			      .$this->org_yes.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;


			case "SvodOtNasel":			
			      $this->sql='CALL YISGRAND.SvodOtNasel('
			      .'"'.$this->date_from.'", '
			      .'@content,@success)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_perer":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_perer('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "schetUtke":			
			      $this->sql='CALL YISGRAND.schetUtke('
			      .$this->org_id.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

// VIK 

			case "OtVikOrg_perer":			
			      $this->sql='CALL YISGRAND.vik_perer('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "schetVik":			
			      $this->sql='CALL YISGRAND.schetVik('
			      .$this->org_id.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

		
			case "VikOtchSvodn":			
			      $this->sql='CALL YISGRAND.VikOtchSvodn('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "DogovorYtke":			
			      $this->sql='CALL YISGRAND.YtkeDogovor('
			      .'"'.$this->dog_id.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;


		}
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @head,@content,@foot,@success';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['head'] = $this->row['@head'];
			$this->results['content'] = $this->row['@content'];
			$this->results['foot'] = $this->row['@foot'];
			$this->results['success'] = $this->row['@success'];
		}
			
		/*include_once('absent_file.php')*/


		return $this->results;




}





}