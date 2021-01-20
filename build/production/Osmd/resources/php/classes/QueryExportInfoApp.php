<?php
include_once './yis_config.php';
require("../phpmailer/class.phpmailer.php");

class QueryExportInfoApp
{

	private $_db;
	public $json;
	protected $login;

	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $sql_callback_send;
	protected $res_callback_send;
	protected $sql_callback_chek;
	protected $res_callback_chek;
	protected $row;	
	protected $row_send;
	protected $row_email;	


	protected $id;
	protected $what;
	protected $nomer;
	protected $type;
	
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	public	  $results_send=array();

	protected $_visit;
	protected $_msg;
	protected $_stmt;
	protected $_id;
	
	protected $smtp = "91.192.128.1"; // SMTP сервер
	protected $reply_email ='yis@yuzhny.com';
	protected $email ='nizhelskiy.sergey@gmail.com';
	protected $name_send='ОСББ';
	protected $msg_html ; 
	protected $msg_txt ; 
	protected $_mphone;
	
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

	

	public function exportToEmail(stdClass $params)
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
		
		
		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
		$this->sql='';

		switch ($this->what) {
		case "EmailInfoApp":		
		      $this->sql_callback_send='SELECT t1.`address_id`, t1.`address`,t1.`email`,t1.`href` FROM YISGRAND.INFO_EMAIL as t1 WHERE t1.`osmd_id` = '.$this->osmd_id.' and t1.`chek` = 0 ';
		      $this->res_callback_send = $_db->query($this->sql_callback_send) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		      $rows=mysqli_affected_rows($_db); 
		      if($rows){ 
		      $mail = new PHPMailer();
		      $mail->IsSMTP();// отсылать используя SMTP
		      #$mail->IsSendmail();// отсылать используя SMTP
		      $mail->Host = '91.192.128.1'; // SMTP сервер
		      $mail->SMTPAuth = true;     // включить SMTP аутентификацию
		      $mail->Username = 'yis';                 // SMTP username
		      $mail->Password = 'yis2018';      // SMTP password
		      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		      $mail->Port = 587;       
		      $mail->From     = 'yis@yuzhny.com'; // укажите от кого письмо							
		      $mail->FromName = 'Южненская Коммунальная Информационная Система -ЮКИС'; // имя отправителя
		      #$mail->AddReplyTo('ykis.osbb@gmail.com','Info'); // е-мэил того кому прейдет ответ на ваше письмо
		      $mail->WordWrap = 350;// set word wrap
		      //$mail->AddAttachment($filename);         // add attachments
		      $mail->IsHTML(true);// отправить в html формате
		      $mail->CharSet    = 'utf-8';
		      $mail->Subject  =  'Информация по квартире';// тема письма
		      #$mail->AltBody  =  'Распечатка'; // тело письма текстовое
		      while ($this->row_send = $this->res_callback_send->fetch_assoc()) {
			      $cloned = clone $mail;	      
			      $cloned->AddAddress( $this->row_send['email'],$mail->FromName); // е-мэил кому отправлять
			      $cloned->Body     =  'Доброго времени суток!<br>
			      Вы получили это письмо,так как являетесь потребителем коммунальных услуг программного комплекса «ЮКИС».<br>
			      Перейдя по ссылке <a href="'.$this->row_send['href'].'">"'.$this->row_send['address'].'"</a>, Вы всегда будете видеть актуальную информацию по Вашей квартире."'.$this->row_send['email'].'".<br>
			      Для Вашего удобства — сохраните ссылку в закладках браузера на компьютере.<br>
			      В случае каких-либо изменений,  Вам придет новое сообщение.<br><br>
			      До новых встреч!<br>
			      С уважением, «ЮКИС»!<br><br>
			      Доброго часу доби!<br>Ви отримали цей лист, тому що є споживачем комунальних послуг програмного комплексу «ЮКІС».<br>
			      Перейшовши за посиланням <a href="'.$this->row_send['href'].'">"'.$this->row_send['address'].'"</a>, Ви завжди будете бачити актуальну інформацію по Вашій квартирі.<br>
			      Для Вашої зручності - збережіть посилання в закладках браузера на комп`ютері.<br>
			      У разі будь-яких змін, Вам прийде нове повідомлення.<br><br>
			      До нової зустрічі!<br>
			      З повагою, «ЮКІС»!' ; 
			      $this->sql_callback_chek='UPDATE  YISGRAND.INFO_EMAIL as t1 SET t1.chek = 1 WHERE t1.address_id = '. $this->row_send['address_id'].'' ;
			      $this->res_callback_chek = $_db->query($this->sql_callback_chek) or die('Connect Error >>>  '. $this->row_send['address_id'].' <<< ' . $_db->connect_error); 
			      if(!$cloned->Send()) {
				  $this->sql_callback_chek='UPDATE  YISGRAND.INFO_EMAIL as t1 SET t1.chek = 2 WHERE t1.address_id = '. $this->row_send['address_id'].'' ;
				  $this->res_callback_chek = $_db->query($this->sql_callback_chek) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);				  
				  $cloned->ClearAllRecipients(); 
				  $cloned->ClearAddresses(); 
				  $cloned->ClearAttachments();  
				  } else {
				  $this->sql_callback_chek='UPDATE  YISGRAND.INFO_EMAIL as t1 SET t1.chek = 1 WHERE t1.address_id = '. $this->row_send['address_id'].'' ; 
				  $this->res_callback_chek = $_db->query($this->sql_callback_chek) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);				  
				  $cloned->ClearAllRecipients(); 
				  $cloned->ClearAddresses(); 
				  $cloned->ClearAttachments();  
				  }
				unset( $cloned ); 
			      }
			      $this->results['msg'] = "Почта отправлена";
			      $this->results['success'] = 1;
			      }else {
				$this->results['msg'] = "Нет данных для отправки почты";
				$this->results['success'] = 0;
			      }
				break;
				}
				return $this->results;
				}
}