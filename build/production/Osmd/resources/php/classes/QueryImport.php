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

	

	public function upload($name)
	{

		$_db = $this->__construct();	

		 
		 $terminated=";";
		 $enclosed='"';
		 $escaped="\\\\";
		 $line="\\n";

		 $_sql_update='LOAD DATA  INFILE "/tmp/'.$name.'" REPLACE INTO TABLE YIS.PORT FIELDS TERMINATED BY "'.$terminated.'" ENCLOSED BY \''.$enclosed.'\' ESCAPED BY "'.$escaped.'" LINES TERMINATED BY "'.$line.'" (address_id,fio,nachisleno,dolg,uderzhat,uderzhano,tabn,izm,data ,raion_id,house_id,house,address,rec_id) SET house = "address"';


		//print($_sql_update);
		 $_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		 $rows=mysqli_affected_rows($_db);
		
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
	//	print($fileName);
	//	print($tmpName);
	//	print($fileSize);

	 if($_FILES['filedata']['size'] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   } else {
            $obj = new QueryUpload();
						$active=$obj->upload($fileName);
							echo json_encode(array(
            "success" => true
					));
		}
