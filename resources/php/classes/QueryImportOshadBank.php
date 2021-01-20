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
	$_sql_trancate ='TRUNCATE TABLE YIS.SUB_OSHADBANK'; 
	$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
	$table="YIS.SUB_OSHADBANK";
	$terminated=";";
	$enclosed='"';
	$escaped="\\\\";
	$line="\\n";
	if (!$dbf = dbase_open ($dbf_file, 0)){ die("Could not open $dbf_file for import."); }
	$num_rec = dbase_numrecords($dbf);
	$num_fields = dbase_numfields($dbf);
	$fields = array();
	for ($i=1; $i<=$num_rec; $i++){
	$row = @dbase_get_record_with_names($dbf,$i);
	$this->results = $row;
	$q = 'INSERT INTO '.$table.'(`utszn_id`,`oshad_id`,`fio`,`address_id`,`nachisleno`,`dolg`,`oplata`)  values (';
	foreach ($row as $key => $val){
	if (  $key == 'F1' OR $key == 'F2' OR $key == 'F3'  OR $key == 'F4' OR $key == 'F5' OR $key == 'F6' OR $key == 'F7' ){ 
	$q .= "'" . addslashes(trim($val)) . "',"; 
	}
	}
	$q = substr($q, 0, -1);
	$q .= ')';
	$_result = $_db->query($q) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
	}
	return $this->results;
	}
	}	
	$fileName = $_FILES['filedata']['name'];
	$tmpName  = $_FILES['filedata']['tmp_name'];
	$fileSize = $_FILES['filedata']['size'];
	$fileType = $_FILES['filedata']['type'];
	$table = 'YIS.SUB_'.$fileName.''; 
	if(is_uploaded_file($_FILES['filedata']['tmp_name']))
	{
	// Если файл загружен успешно, перемещаем его
	// из временной директории в конечную
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
	$active=$obj->import_dbf($fileName,'/tmp/'.$fileName);
	echo json_encode(array("success" => true));
		}
