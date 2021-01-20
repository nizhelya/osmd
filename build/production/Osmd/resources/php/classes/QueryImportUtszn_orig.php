<?php

class QueryUpload
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

	function import_dbf($name,$dbf_file)
{

$_db = $this->__construct();	

	switch($name)
	{
	case "gek1.DBF":
				$_sql_trancate ='TRUNCATE TABLE YIS.SUB_GEK1'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$table="YIS.SUB_GEK1";
	break;
	case "gek3.DBF":
				$_sql_trancate ='TRUNCATE TABLE YIS.SUB_GEK3'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$table="YIS.SUB_GEK3";
	break;
	case "gek4.DBF":
				$_sql_trancate ='TRUNCATE TABLE YIS.SUB_GEK4'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$table="YIS.SUB_GEK4";
	break;
	case "utke.DBF":
				$_sql_trancate ='TRUNCATE TABLE YIS.SUB_TEPLO'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$table="YIS.SUB_TEPLO";
	break;
	case "vik.DBF":
				$_sql_trancate ='TRUNCATE TABLE YIS.SUB_VODA'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$table="YIS.SUB_VODA";
	break;
	case "ugtrans.DBF":
				$_sql_trancate ='TRUNCATE TABLE YIS.SUB_TBO'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
				$table="YIS.SUB_TBO";
	break;
}
	 $terminated=";";
		 $enclosed='"';
		 $escaped="\\\\";
		 $line="\\n";

if (!$dbf = dbase_open ($dbf_file, 0)){ die("Could not open $dbf_file for import."); }
$num_rec = dbase_numrecords($dbf);
$num_fields = dbase_numfields($dbf);
$fields = array();
//$this->results = $num_rec;

for ($i=1; $i<=$num_rec; $i++){
$row = @dbase_get_record_with_names($dbf,$i);
$this->results = $row;

$q = 'INSERT INTO '.$table.' (`address_id`, `kvartplata`, `otoplenie`,`podogrev`,`voda`, `tbo`, `stoki`,`kv`, `ot`,`gv`,`xv`,`tb`,`st`,`summa` )  values (';
foreach ($row as $key => $val){
if ( $key == 'RASH' OR $key == 'SM1' OR  $key == 'SM2' OR $key == 'SM3' OR $key == 'SM4' OR $key == 'SM7' OR $key == 'SM8' OR $key == 'OB1' OR $key == 'OB2' OR $key == 'OB3' OR $key == 'OB4' OR $key == 'OB7' OR $key == 'OB8'  OR $key == 'SUMMA' ){ 
$q .= "'" . addslashes(trim($val)) . "',"; 
}
/*
if ($key == 'NAME_V' OR $key == 'BLD' OR $key == 'FLAT' OR $key == 'RASH' OR $key == 'SM1' OR $key == 'SM2' OR $key == 'SM3' OR $key == 'SM4' OR $key == 'SM7' OR $key == 'SM8' OR $key == 'SUMMA'  ){ 
$q .= "'" . addslashes(trim(convert_cyr_string(utf8_2_win1251($val),"w","a"))) . "',"; 
}
*/
}
$q = substr($q, 0, -1);
$q .= ')';
$_result = $_db->query($q) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

}
//$this->results = $q;

     return $this->results;
}

}	
    $fileName = $_FILES['filedata']['name'];
    $tmpName  = $_FILES['filedata']['tmp_name'];
    $fileSize = $_FILES['filedata']['size'];
    $fileType = $_FILES['filedata']['type'];
	  $table = 'YIS.SUB_'.$fileName.''; 


   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES['filedata']['tmp_name']))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
     move_uploaded_file($_FILES["filedata"]["tmp_name"], "/tmp/".$_FILES["filedata"]["name"]);
   } else {
      echo("Ошибка загрузки файла");
   }
	//	print($fileName);
	//	print($tmpName);
	//	print($fileSize);

	 if($_FILES['filedata']['size'] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   } else {
            $obj = new QueryUpload();
						$active=$obj->import_dbf($fileName,'/tmp/'.$fileName);
					echo json_encode(array("success" => true));
		}
