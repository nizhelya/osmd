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
    		//$_db->options(MYSQL_OPT_LOCAL_INFILE,1);

		return $_db;
	}

	

	public function upload($name)
	{

		$_db = $this->__construct();	
				$_sql_trancate ='TRUNCATE TABLE YISGRAND.GERZ_IMPORT'; 
				$_result_trancate = $_db->query($_sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 
		 $terminated=";";
		 $enclosed='"';
		 $escaped="\\\\";
		 $line="\\n";
		//print($name);

		
		 $_sql_update='LOAD LOCAL DATA INFILE "/tmp/'.$name.'" REPLACE INTO TABLE YISGRAND.GERZ_IMPORT  FIELDS TERMINATED BY "'.$terminated.'" ENCLOSED BY \''.$enclosed.'\' ESCAPED BY "'.$escaped.'" LINES TERMINATED BY "'.$line.'"  IGNORE 1 LINES (rec_id,gerz_id,firma_id,org_id,usluga_id,address_id, @Pdate,@Date_ob,@Dateb,@Datee,fio,rec1,rec2,rec3,rec4,rec5,rec6,rec7, rec8, rec9,rec10,rec11,summa,summap) SET pdate = STR_TO_DATE(@Pdate, "%d.%m.%Y"),date_ob = STR_TO_DATE(@Date_ob, "%d.%m.%Y"),sdate = STR_TO_DATE(@Dateb, "%d.%m.%Y"),fdate = STR_TO_DATE(@Datee, "%d.%m.%Y")';
		 $_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		
		    $_sql='CALL YISGRAND.input_gerz(@success, @msg)';
		    $_results = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		    
		    
		 //$rows=mysqli_affected_rows($_db);
		
		 return true;
		
	}
}	
    $fileName = $_FILES['filedata']['name'];
    $tmpName  = $_FILES['filedata']['tmp_name'];
    $fileSize = $_FILES['filedata']['size'];
    $fileType = $_FILES['filedata']['type'];


   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES['filedata']['tmp_name']))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
     move_uploaded_file($_FILES["filedata"]["tmp_name"], "/tmp/".$_FILES["filedata"]["name"]);
   } else {
      echo("Ошибка загрузки файла");
   }
	//print($fileName);
	//print($tmpName);
	//print($fileSize);

	 if($_FILES['filedata']['size'] > 1024*3*1024) {
	 echo ("Размер файла превышает три мегабайта");
	 exit;
	 } else {
            $obj = new QueryUpload();
            $active=$obj->upload($fileName);
            echo json_encode(array(
            "success" => true
            ));
            }
