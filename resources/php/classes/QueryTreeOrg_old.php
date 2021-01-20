<?php
$isForm = false;
$isUpload = false;

$param1='';
$param2='';
$param3='';
$login='';
$password='';

if(isset($_GET['login'])) {
		$login = $_GET['login'];
		} else {
		  $login='';
		}

if(isset($_GET['password'])) {
		$password = $_GET['password'];
		} else {
		  $password='';
		}

if ((strlen($login)+strlen($password))<1) {die('Connect Error');}


if(isset($_GET['cat'])) {
		$param1 = $_GET['cat'];
		} else {
		  $param1='';
		}
if(isset($_GET['filter'])) {
		$param2 = $_GET['filter'];
		} else {
		  $param2='';
		}
if(isset($_GET['org_id'])) {
		$param3 = $_GET['org_id'];
		} else {
		  $param3='';
		}
$a = new QueryTreeOrg;
$b = $a->getTreeOrg($login, $password, $param1, $param2, $param3);
echo $b;

class QueryTreeOrg
{
	private $_db;
	protected $_result;
	protected $_total;
	protected $_count;
	protected $_sql;
	protected $_sql_total;
	protected $_limit;
	protected $_start;
	protected $_page;
	protected $_array;
	protected $_what;
	protected $_year;
	protected $_date;
	protected $_usluga;
	protected $_table;
	protected $_place;
	protected $_type;
	public $results='';
	public $count_company = 0;
	public $count_dept = 0;
	public $count_pers = 0;

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

public function getTreeOrg($login, $password, $param1, $param2, $param3)
	{
				$_db = $this->connect($login, $password);		
$this->results = '['; 
		$count_company = 0;
 $where='';
 $where_cat='';
 $and='';
 $like='';
 		if ($param3) {
			  $filter= ' `sname` like "%'.$param2.'%" OR `inn` like "%'.$param2.'%" OR `edrpou` like "%'.$param2.'%" ';
			     /* $filter = ' `org_id` ="'.$param3.'" AND ';*/
			      } 
		else if ($param2) {
			      $filter= ' `sname` like "%'.$param2.'%" OR `inn` like "%'.$param2.'%" OR `edrpou` like "%'.$param2.'%" ';
			         }
		else if ($param1) {
				$filter= ' `sname` like "%'.$param2.'%" OR `inn` like "%'.$param2.'%" OR `edrpou` like "%'.$param2.'%"  ';
			      /*$filter = ' `cat_id`='.$param1.' AND ';*/
				  } 
		else {$filter = '';}
		$this->sql='SELECT `org_id`, `sname` FROM TM_ORG WHERE '.$filter.' LIMIT 50'; /*  (TM_ORG.vibor ="utke" OR TM_ORG.vibor ="all") */
		//print_r($this->sql); 

		$_result_company = $_db->query($this->sql) or die('Connect Error (' . print_r($this->sql) . ') ' . $_db->connect_error);
		while ($row_company = $_result_company->fetch_assoc()) {
		    $count_company++;
		    if ($count_company > 1) {$this->results.=',';}
		    $str1 = str_replace("'", "", $row_company['sname']);
		    $str2 = str_replace("\"", "", $str1);
		    $this->results.='{id:"cat'.$row_company['org_id'].'",';
		    $this->results.='orig_id:"'.$row_company['org_id'].'",';
		    $this->results.='text:"'.$str2.'",';
		    $this->results.='what:"category",';
		    $this->results.='date:"",';
		    $this->results.='icon:"resources/css/images/folders/BlueFolder.png",';
		    $this->results.='expanded:false,';

/*$_result_articles = $_db->query('SELECT filial_id FROM TM_ORG_FILIAL WHERE org_id = '.$row_company['org_id'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
$row=mysqli_affected_rows($_db);
$this->results.='subcategories:"'.$row.'",';*/
$this->results.='subcategories:"1",';

$child2 =1;  
		    $_result_depts = $_db->query('SELECT filial_id, name FROM TM_ORG_FILIAL WHERE org_id = '.$row_company['org_id'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$this->results.='children:[';
				$this->results.='{id:"Add-fil'.$row_company['org_id'].'",';
				$this->results.='orig_id:"'.$row_company['org_id'].'",';
				$this->results.='text:"Доб.помещ.",';
				$this->results.='what:"addfil",';
				$this->results.='date:"",';
				$this->results.='icon:"resources/css/images/ico/add.png",';
				$this->results.='expanded:false,';
				$this->results.='leaf:true';
				$this->results.=' },';
$count_dept = 0;
while ($row_depts = $_result_depts->fetch_assoc()) {
				
if ($child2 == 1) { $child2 = $child2 + 1;}
				$count_dept++;
				if ($count_dept > 1) {$this->results.=',';}
				$str3 = str_replace(array("'","\""), "", $row_depts['name']);
				$this->results.='{id:"subcat'.$row_depts['filial_id'].'",';
				$this->results.='orig_id:"'.$row_depts['filial_id'].'",';
				$this->results.='text:"'.$str3.'",';
				$this->results.='what:"subcategory",';
				$this->results.='date:"",';
				$this->results.='iconCls:"task",';
				$this->results.='expanded:false,';
				$this->results.='leaf:true';
				$this->results.='}';
		}
  if ($child2 > 1) { } else {
$this->results= trim($this->results,',');
}
			   $this->results.=']';
			   $this->results.='}'; 
}
		  $this->results.=']'; 
	  $results = Array();
$results = $this->results;
		return $results;
	}
}

