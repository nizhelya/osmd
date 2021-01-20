<?php

class QueryExport
{
	private $_db;
	protected $_result;
	protected $_visit;
	protected $_msg;
	protected $_stmt;
	protected $_id;
	protected $login;
	protected $password;
	protected $smtp = "91.192.128.1"; // SMTP сервер
	protected $reply_email ='yis@yuzhny.com';
	protected $name_send='ОСМД';
	protected $msg_html ; 
	protected $msg_txt ; 
	protected $_mphone;
	protected $address;
	protected $address_id;
	protected $user_id;
	protected $sql;
	public $results;

	
	
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

			
		switch ($_what) {
		 
		     case "registration":
			$_sql='SELECT user_id,login,surname,firstname,lastname,email,mphone,role,active,visit,remember FROM YISGRAND.USERS WHERE YISGRAND.USERS.user_id='.$_id.''; 
			//print($_sql);    
		    break;
		      case "login":
			$_sql='SELECT user_id,login,surname,firstname,lastname,email,mphone,role,active,visit,remember FROM YISGRAND.USERS WHERE YISGRAND.USERS.user_id='.$_id.''; 
			//print($_sql);    
		    break;
	    
		    case "activation":
			$_sql='SELECT user_id,login,surname,firstname,lastname,email,mphone,role,active,visit,remember FROM YISGRAND.USERS WHERE YISGRAND.USERS.login="'.$_login.'" and YISGRAND.USERS.keysend="'.$_keysend.'"'; 
			//$_sql='SELECT user_id,login,surname,firstname,lastname,email,mphone,role,active,visit,remember FROM USERS WHERE login="'.$_login.'"'; 
			//print($_sql);    
		    break;
				
		} // End of Switch ($what)
		
		
		
		$_db = $this->__construct();
		
		
		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$rows=mysqli_affected_rows($_db);
		$_array=array();
		$results = array();		
		if($rows){
		    while ($row = $_result->fetch_assoc()) {			
			array_push($_array, $row);
			$results['success']= true;
			$results['data']= $_array;
		   }
		}else{
			$results['success']	= false;
			
		}
		
		
		return $results;
	}
	public function exportToEmail(stdClass $params)
	{
						function utf8_2_win1251 ($str_src)
							{
							$str_dst = "";
							$i = 0;
							while ($i<strlen($str_src))
							{
							$code_dst = 0;
							$code_src1 = ord($str_src[$i]);
							$i++;

							if ($code_src1<=127)
							{
							$str_dst .= chr($code_src1);
							continue;
							}
							else
							if (($code_src1 & 0xE0) == 0xC0)
							{
							$code_src2 = ord($str_src[$i++]);
							if (($code_src2 & 0xC0) != 0x80)
							continue;

							$code_dst = ( ($code_src1 & 0x1F) << 6) + ($code_src2 & 0x3F);
							}
							else
							if (($code_src1 & 0xF0) == 0xE0)
							{
							$code_src2 = ord($str_src[$i++]);
							if (($code_src2 & 0xC0) != 0x80)
							continue;

							$code_src3 = ord($str_src[$i++]);
							if (($code_src3 & 0xC0) != 0x80)
							continue;

							$code_dst = ( ($code_src1 & 0x1F) << 12) + ( ($code_src2 & 0x3F) << 6) + ($code_src3 & 0x3F);
							}
							else
							if (($code_src1 & 0xF8) == 0xF0)
							{
							$code_src2 = ord($str_src[$i++]);
							if (($code_src2 & 0xC0) != 0x80)
							continue;

							$code_src3 = ord($str_src[$i++]);
							if (($code_src3 & 0xC0) != 0x80)
							continue;

							$code_src4 = ord($str_src[$i++]);
							if (($code_src4 & 0xC0) != 0x80)
							continue;

							$code_dst = ( ($code_src1 & 0x1F) << 18) + ( ($code_src2 & 0x3F) << 12) + ( ($code_src3 & 0x3F) << 6) + ($code_src4 & 0x3F);
							}
							else
							{
							continue;
							}

							if ($code_dst)
							{
							if ($code_dst==0x401)
							{ 
							$str_dst .= "";
							} 
							else
							if ($code_dst==0x451)
							{ 
							$str_dst .= "";
							} 
							else 
							if ( ($code_dst>=0x410) && ($code_dst<=0x44F) )
							{ 
							$str_dst .= chr ($code_dst-848);
							}
							else
							$str_dst .= "&#{$code_dst};";
							}
							}
							return $str_dst;
							} 
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
					if(isset($params->what) && ($params->what)) {
					$this->what = $params->what;
					} else {
						$this->what = null;
						}
					$_db = $this->connect($this->login,$this->password);

					$array = (array) $params;
					foreach ( $array as $key => $value ) 
						{
						if(isset($value)) { 
								if (is_int($value)) { $this->$key= (int)$value;}
								else if (is_float($value)) { $this->$key= $value;}
								else {$this->$key =$_db->real_escape_string($value);}
						}
					}
					$_db = $this->connect($this->login,$this->password);

					require("../phpmailer/class.phpmailer.php");
//print($this->what);
					switch ($this->what) {
					case "ExportEmail":
					switch($this->vibor)
					{
						case 'utszn':
						$filename = "/tmp/osmd.dbf";
						  $this->sql='SELECT *  FROM YISGRAND.DBF_OSMD as t1 WHERE  t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01")';	    
						break;
						
						case 'port':
						$filename = "/tmp/port.csv";
						$this->sql='SELECT  YIS.PORT.address_id,YIS.PORT.tabn,YIS.PORT.uderzhat,DATE_FORMAT(YIS.PORT.data,"%Y-%m-%d")  FROM YIS.PORT';
						break;
						case 'oshadbank':
						$filename = "/tmp/kvartplata.csv";
						$this->sql='SELECT t1.`utszn_id` ,t1.`oshad_id`,t1.`fio`,t1.`address_id`,t1.`nachisleno`,t1.`dolg`
						FROM YIS.SUBS_KVARTPLATA as t1 WHERE t1.`osmd_id` ='.$this->osmd_id.' and t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01")';
						break;
						case 'oshadbank_lgota':
						$filename = "/tmp/kvartplata.csv";
						$this->sql='SELECT t1.`utszn_id` ,t1.`oshad_id`,t1.`fio`,t1.`address_id`,t1.`nachisleno`,t1.`dolg`
						FROM YIS.LG_KVARTPLATA as t1 WHERE t1.`osmd_id` ='.$this->osmd_id.' and t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01")';
						break;
						case 'privatbank':
						$m = substr($this->data,5,2);
						$god = substr($this->data,2,2);
						$terminated=";";
						$enclosed='"';
						$escaped='"';
						$line='\r\n';
						$filename = '/tmp/39520809.csv';
						$this->sql_trancate='CALL YISGRAND.privatbank_insert_newdata('.$this->osmd_id.')';
						$_result_trancate = $_db->query($this->sql_trancate) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

						$this->sql='SELECT "LS", "FIO", "STREET", "BULDING", "FLAT", "SERVICECOD", "SUM" UNION ALL SELECT YISGRAND.DBF_PRIVATBANK.LS,YISGRAND.DBF_PRIVATBANK.FIO,YISGRAND.DBF_PRIVATBANK.STREET,
						YISGRAND.DBF_PRIVATBANK.BUILDING, YISGRAND.DBF_PRIVATBANK.FLAT, YISGRAND.DBF_PRIVATBANK.SERVICECOD, YISGRAND.DBF_PRIVATBANK.SUM FROM YISGRAND.DBF_PRIVATBANK';	

						break;
					}
						$_result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
						$_success = 1;
						
						switch($this->vibor) {
						case 'utszn':
						
						$dbf_lgota =Array(
						Array ("CDPR", "N", 12,0),
						Array ("IDCODE", "C", 10),
						Array ("FIO", "C", 50),
						Array ("PPOS", "C", 15),
						Array ("RS", "C", 25),
						Array ("YEARIN", "N", 4,0),
						Array ("MONTHIN", "N", 2,0),
						Array ("LGCODE", "N", 4,0),
						Array ("DATA1", "D"),
						Array ("DATA2", "D"),
						Array ("LGKOL", "N", 2,0),
						Array ("LGKAT", "C", 3),
						Array ("LGPRC", "N", 3,0),
						Array ("SUMM", "N", 8,2),
						Array ("FACT", "N", 19,6),
						Array ("TARIF", "N", 14,7),
						Array ("FLAG", "N", 1,0));
						if (! dbase_create($filename, $dbf_lgota)) {
						$_msg = "Error db_lgota";
						$_success = 0;
						exit();
						}
						$db = dbase_open($filename,2);
						if ($db) {
						$row_no   = 0;
						 while ($row = $_result->fetch_row()) {
							$record=array();
							for ($i = 0; $i < $_result->field_count-8; ++$i) {
							$record[]= convert_cyr_string(utf8_2_win1251($row[$i]),"w","a");
							}
						$row_no++;
						if(! dbase_add_record($db,$record)) {
						$_msg = "Error db append";
							$_success = 0;
							exit () ;
						} else {
							$_msg = "db append";
							$_success = 1;
						}
						}
						}else {
							$_msg = 'Error db open '.$filename;
							$_success = 0;
						}
							dbase_close($db);
							break;
							case 'port':
							case 'privatbank':
							case 'oshadbank':
							case 'oshadbank_lgota':

							if ($handle = fopen($filename, 'w')) {
							}else {		
							throw new Exception("Cannot open file '.$filename");
							}
							$fields_cnt = $_result->field_count;
							$csv_terminated = "\r\n";;
							$csv_separator = ";";
							$csv_enclosed = '"';
							$csv_escaped = "\\";
							while ($row = $_result->fetch_array()) {
							$svod =$csv_enclosed;
							for ($j = 0; $j < $fields_cnt; $j++) {
							//$svod .= convert_cyr_string(utf8_2_win1251($row[$j]),"w","a");
							$svod .= $row[$j];
							if ($j < $fields_cnt-1) {
							$svod .= $csv_enclosed.$csv_separator.$csv_enclosed;
							}
							} // end for
							if (fwrite($handle,$svod.$csv_enclosed.$csv_terminated) === FALSE) {
							echo 'Не могу записать файл '.$filename;
							exit;
							} 
							
							}
							fclose($handle);																	
							break;
							
							}
							if($_success ) {
							$mail = new PHPMailer();
							  $mail->IsSMTP();// отсылать используя SMTP
							  $mail->Host = '91.192.128.1'; // SMTP сервер
							  $mail->SMTPAuth = true;     // включить SMTP аутентификацию
							  $mail->Username = 'yis';                 // SMTP username
							  $mail->Password = 'yis2018';      // SMTP password
							  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
							  $mail->Port = 587;       
							  $mail->From     = 'yis@yuzhny.com'; // укажите от кого письмо							
							  $mail->FromName = 'Южненская Коммунальная Информационная Система -ЮКИС'; // имя отправителя
							  $mail->AddAddress($this->subjectTo); // е-мэил кому отправлять
							  $mail->AddReplyTo($this->subjectFrom,"Info"); // е-мэил того кому прейдет ответ на ваше письмо
							  $mail->WordWrap = 350;// set word wrap
							  $mail->AddAttachment($filename);         // add attachments
							  $mail->IsHTML(false);// отправить в html формате
							  $mail->CharSet    = 'utf-8';

							  $mail->Subject  =  $this->tema; // тема письма
							  $mail->Body     =   $this->message; // тело письма в html формате
							$mail->AltBody  =  $this->message; // тело письма текстовое
							if(!$mail->Send()) {
								$_msg = "Ошибка. Файл не отправлен";
								$_success = 0;
							} else {
								$_msg = "Файл отправлен";
								$_success = 1;
							}																			
							} else {
							  $_msg = "файл начислений на бюджет  не создан";
							  $_success = 0;
							}
						break;
			
		} // End of Switch ($what)  
				
			$this->results['success'] = $_success;
			$this->results['msg'] = $_msg;
					
		return $this->results;
	}



}