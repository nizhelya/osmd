<?php
if    (isset($_GET['osmd_id']) && !empty($_GET['osmd_id'])) {//код подтверждения 
			$osmd_id = $_GET['osmd_id'];
}else{
			$osmd_id = 0;

}
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
    		//$_db->options(MYSQL_OPT_LOCAL_INFILE,1);

		return $_db;
	}

	

	function import_dbf($name,$dbf_file)
	{

		$_db = $this->__construct();	
				$_sql_trancate ='TRUNCATE TABLE YISGRAND.PRIVATBANK_IMPORT'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 
		 $terminated=";";
		 $enclosed='"';
		 $escaped="\\\\";
		 $line="\\n";
		//print($name);

		if (!$dbf = dbase_open ($dbf_file, 0)){ die("Could not open $dbf_file for import."); }
$num_rec = dbase_numrecords($dbf);
$num_fields = dbase_numfields($dbf);
$fields = array();
//$this->results = $num_rec;

for ($i=1; $i<=$num_rec; $i++){
$row = @dbase_get_record_with_names($dbf,$i);
$this->results = $row;

$q = 'INSERT INTO YISGRAND.PRIVATBANK_IMPORT (`nomer`,`data`, `fio`, `address_id`,`address`,`summa`,`prixod`)  values (';
foreach ($row as $key => $val){
if ($key == 'NUMBER' OR $key == 'OPERDAY' OR  $key == 'FIO' OR $key == 'LS' OR $key == 'ADDRESS'  OR $key == 'SUM' OR $key == 'PEROPL'  ){ 
#$q .= "'" . addslashes(trim($val)) . "',"; 
#$q .= "'" . addslashes(trim(convert_cyr_string(utf8_2_win1251($val),"w","a"))) . "',"; 
$q .= "'" . addslashes(trim(mb_convert_encoding($val, "UTF-8","cp866"))) . "',"; 

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

		
		    $_sql='CALL OSBB.input_privatbank('.$osmd_id.')';
		    $_results = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    
		    
		 //$rows=mysqli_affected_rows($_db);
		
		 return true;
		
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

