<?php

$fileName = $_FILES['filedata']['name'];
$tmpName  = $_FILES['filedata']['tmp_name'];
$fileSize = $_FILES['filedata']['size'];
$fileType = $_FILES['filedata']['type'];
// Проверяем загружен ли файл
if(is_uploaded_file($_FILES['filedata']['tmp_name']))
  {
    // Если файл загружен успешно, перемещаем его  из временной директории в конечную
    move_uploaded_file($_FILES["filedata"]["tmp_name"], "/tmp/".$_FILES["filedata"]["name"]);
  } else {
    echo("Ошибка загрузки файла");
  }
if($_FILES['filedata']['size'] > 1024*3*1024)
  {
     echo ("Размер файла превышает три мегабайта");
     exit;
   } else {
   $obj = new QueryUpload();
   $active=$obj->import_dbf('/tmp/'.$fileName);
   echo json_encode(array("success" => true));
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
    
		return $_db;
	}
	

	function import_dbf($dbf_file)
	{
	    $_db = $this->__construct();
	    $_sql_trancate ='TRUNCATE TABLE YISGRAND.LGOTNIK';
	    $_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
	    $terminated=";";
	    $enclosed='"';
	    $escaped="\\\\";
	    $line="\\n";
	      if (!$dbf = dbase_open($dbf_file, 0))
	      { 
		  die("Could not open $dbf_file for import."); 
	      }
	      $num_rec = dbase_numrecords($dbf);
	      $num_fields = dbase_numfields($dbf);
	      $fields = array();
	      for ($i=1; $i<=$num_rec; $i++)
	      {
		$row = @dbase_get_record_with_names($dbf,$i);
		$this->results = $row;
		$q = 'INSERT INTO YISGRAND.LGOTNIK( `edrpou`, `kartochka`,`inn`,`passport`, `fio`,street,house,build, `appartment`,`category`, `start`, `finish` )  values (';
		foreach ($row as $key => $val)
		{
		    if ( $key == 'CDPR' OR $key == 'NCARD' OR $key == 'IDPIL'  OR $key == 'PASPPIL' OR $key == 'FIOPIL' OR $key == 'CDUL' OR $key == 'HOUSE' OR $key == 'BUILD'  OR $key == 'APT'  OR $key == 'KAT'  OR $key == 'DATEIN' OR $key == 'DATEOUT' )
		    {
			//$q .= "'" . addslashes(trim($val)) . "',";
			//$q .= "'" . addslashes(trim(convert_cyr_string($val,"i","k"))) . "',";
			//$q .= "'" . addslashes(trim(mb_convert_encoding($val, "cp866","UTF-8"))) . "',"; 
			$q .= "'" . addslashes(trim(mb_convert_encoding($val, "UTF-8","cp866"))) . "',"; 
		    }
		}
		$q = substr($q, 0, -1);
		$q .= ')';
		$_result = $_db->query($q) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		
		$_sql_call='CALL YISGRAND.update_lgota_from_utszn(@success,@msg)';
		$_result_call = $_db->query($_sql_call) or die('Connect Error in ('.$_sql_call.') ' . $_db->connect_error);		
		$_sql_callback='SELECT @success, @msg';
		$_res_callback = $_db->query($_sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		while ($_row = $_res_callback->fetch_assoc()) {
			$this->results['success'] = $_row['@success'];
			$this->results['msg'] = $_row['@msg'];			
		}
		return $this->results;
	}
}
?>