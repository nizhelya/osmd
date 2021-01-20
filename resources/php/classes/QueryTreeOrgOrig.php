<?php
$isForm = false;
$isUpload = false;

$param='';
$cat=0;
$login='';
$password='';


if(isset($_GET['filter']) && ($_GET['filter'])) {
	$param = $_GET['filter'];

} else {
	$param=0;
}
if(isset($_GET['org']) && ($_GET['org'])) {
	$org = $_GET['org'];

} else {
	$org=0;
}

if(isset($_GET['cat']) && ($_GET['cat'])) {
	$cat = $_GET['cat'];
} else {
         $cat=0;
}

//	print($_GET['filter']);
//	print($cat);


$a = new QueryTreeOrg;
$b = $a->getTreeOrg($org, $param,$cat);
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

	public function connect()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YISGRAND');
		if ($_db->connect_error) {
			return false;
		} else {		
		$_db->set_charset("utf8");    
		return $_db;
		}
	}

public function getTreeOrg( $org,$param, $cat)
	{
$_db = $this->connect();		
$this->results = '['; 
		$count_company = 0;
 $where='';
 $where_cat='';
 
		if ($org)  {
			  $filter= '  `org_id` =  "'.$org.'" ';
 
 		} else if ($cat)  {
			  $filter= '  `inn` like "'.$param.'%" OR `edrpou` like "'.$param.'%" ';
		} else if ($param) {
			  $filter= ' `sname` like "%'.$param.'%" ';
		} else {
			  $filter= ' `sname`= "z" ';
		}
		
		$this->sql='SELECT `org_id`, `sname` FROM TM_ORG WHERE '.$filter.''; 
		
//print($filter);
		$_result_company = $_db->query($this->sql) or die('Connect Error (' . print_r($this->sql) . ') ' . $_db->connect_error);
		while ($row_company = $_result_company->fetch_assoc()) {
		    $count_company++;
		    if ($count_company > 1) {$this->results.=',';}
		    $str1 = str_replace("'", "", $row_company['sname']);
		   //print($row_company['sname']);

		    $str2 = str_replace("\"", "", $str1);
		    $this->results.='{id:"cat'.$row_company['org_id'].'",';
		    $this->results.='orig_id:"'.$row_company['org_id'].'",';
		    $this->results.='text:"'.$str2.'",';
		    $this->results.='what:"category",';
		    $this->results.='icon:"resources/css/images/folders/BlueFolder.png",';
		    $this->results.='expanded:false,';

$this->results.='subcategories:"1",';

$child2 =1;  
		    $_result_depts = $_db->query('SELECT filial_id, name,golovnoe,ind FROM TM_ORG_FILIAL WHERE org_id = '.$row_company['org_id'].'') or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$this->results.='children:[';
				$this->results.='{id:"Add-fil'.$row_company['org_id'].'",';
				$this->results.='orig_id:"'.$row_company['org_id'].'",';
				$this->results.='text:"Доб.помещ.",';
				$this->results.='what:"addfil",';
				$this->results.='icon:"resources/css/images/ico/add.png",';
				$this->results.='expanded:false,';
				$this->results.='leaf:true';
				$this->results.=' },';
$count_dept = 0;
while ($row_depts = $_result_depts->fetch_assoc()) {
				
if ($child2 == 1) { $child2 = $child2 + 1;}
				$count_dept++;
				if ($count_dept > 1) {$this->results.=',';}
				if ($row_depts['golovnoe']=="1"){
				    $str3 = str_replace(array("'","\""), "",'<span style="color:green; font-weight:bold;">'. $row_depts['name'].'</span>');
				} else if ($row_depts['ind']=="1"){
				    $str3 = str_replace(array("'","\""), "",'<span style="color:red; font-weight:bold;">'. $row_depts['name'].'</span>');
				} else {
				    $str3 = str_replace(array("'","\""), "", $row_depts['name']);
				}
				
				$this->results.='{id:"subcat'.$row_depts['filial_id'].'",';
				$this->results.='orig_id:"'.$row_depts['filial_id'].'",';
				$this->results.='text:"'.$str3.'",';
				$this->results.='golovnoe:"'.$row_depts['golovnoe'].'",';
				$this->results.='ind:"'.$row_depts['ind'].'",';
				$this->results.='what:"subcategory",';
				if ($row_depts['golovnoe']=="1"){
				    $this->results.='icon:"resources/css/images/folders/GreenFolder.png",';
				} else if ($row_depts['ind']=="1"){
				    $this->results.='icon:"resources/css/images/folders/RedFolder.png",';
				} else {
				    $this->results.='iconCls:"task",';
				}
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

