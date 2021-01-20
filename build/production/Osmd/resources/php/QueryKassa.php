<?php

class QueryKassa
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $id;
	protected $what;
	protected $nomer;
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $t; 
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
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

		
		if(isset($params->what) && ($params->what)) {
		 $this->what = $_db->real_escape_string($params->what);
		} else {
		  $this->what = null;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->org_id) && ($params->org_id)) {
		  $this->org_id = (int) $params->org_id;
		} else {
		  $this->org_id = 0;
		}
		if(isset($params->raion_id) && ($params->raion_id)) {
		  $this->raion_id = (int) $params->raion_id;
		} else {
		  $this->raion_id = 0;
		}
		if(isset($params->data) && ($params->data)) {
		  $this->data =$params->data;
		 // $this->data =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$params->data);
		} else {
		  $this->data= date("Ymd");
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
		}
		$this->t= date('Ymd');
		
		switch ($this->what) {

			case "OplataApp":			
			      $this->sql='SELECT * FROM YIS.OPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.OPLATA.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "OtoplenieApp":			
			      $this->sql='SELECT * FROM YIS.OTOPLENIE WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.OTOPLENIE.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "OtoplenieAppAll":			
			      $this->sql='SELECT * FROM YIS.OTOPLENIE WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.OTOPLENIE.`data` DESC' ;
			     // print_r($this->sql); 
			break;
			case "PodogrevApp":			
			      $this->sql='SELECT * FROM YIS.PODOGREV WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.PODOGREV.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "PodogrevAppAll":			
			      $this->sql='SELECT * FROM YIS.PODOGREV WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.PODOGREV.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "VodaApp":			
			      $this->sql='SELECT * FROM YIS.VODA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.VODA.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "VodaAppAll":			
			      $this->sql='SELECT * FROM YIS.VODA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.VODA.`data` DESC' ;
			     // print_r($this->sql); 
			break;
			case "StokiApp":			
			      $this->sql='SELECT * FROM YIS.STOKI WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.STOKI.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "StokiAppAll":			
			      $this->sql='SELECT * FROM YIS.STOKI WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.STOKI.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "KvartplataApp":			
			      $this->sql='SELECT * FROM YIS.KVARTPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.KVARTPLATA.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "KvartplataAppAll":			
			      $this->sql='SELECT * FROM YIS.KVARTPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.KVARTPLATA.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "TboApp":			
			      $this->sql='SELECT * FROM YIS.TBO WHERE `address_id` = '.$this->address_id.'  ORDER BY YIS.TBO.`data` DESC LIMIT 12' ;
			     // print_r($this->sql); 
			break;
			case "TboAppAll":			
			      $this->sql='SELECT * FROM YIS.TBO WHERE `address_id` = '.$this->address_id.'  ORDER BY YIS.TBO.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
			case "LgotaNachVoda":			
			      $this->sql='SELECT * FROM YIS.BVODA WHERE `address_id` = '.$this->address_id.'  AND YIS.BVODA.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachVodaData":			
			      $this->sql='SELECT * FROM YIS.BVODA WHERE `address_id` = '.$this->address_id.'  AND YIS.BVODA.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachStoki":			
			      $this->sql='SELECT * FROM YIS.BSTOKI WHERE `address_id` = '.$this->address_id.'  AND YIS.BSTOKI.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachStokiData":			
			      $this->sql='SELECT * FROM YIS.BSTOKI WHERE `address_id` = '.$this->address_id.'  AND YIS.BSTOKI.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachPodogrev":			
			      $this->sql='SELECT * FROM YIS.BPODOGREV WHERE `address_id` = '.$this->address_id.'  AND YIS.BPODOGREV.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachPodogrevData":			
			      $this->sql='SELECT * FROM YIS.BPODOGREV WHERE `address_id` = '.$this->address_id.'  AND YIS.BPODOGREV.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachOtoplenie":			
			      $this->sql='SELECT * FROM YIS.BOTOPLENIE WHERE `address_id` = '.$this->address_id.'  AND YIS.BOTOPLENIE.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachOtoplenieData":			
			      $this->sql='SELECT * FROM YIS.BOTOPLENIE WHERE `address_id` = '.$this->address_id.'  AND YIS.BOTOPLENIE.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachKvartplata":			
			      $this->sql='SELECT * FROM YIS.BKVARTPLATA WHERE `address_id` = '.$this->address_id.'  AND YIS.BKVARTPLATA.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachKvartplataData":			
			      $this->sql='SELECT * FROM YIS.BKVARTPLATA WHERE `address_id` = '.$this->address_id.'  AND YIS.BKVARTPLATA.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "LgotaNachTbo":			
			      $this->sql='SELECT * FROM YIS.BTBO WHERE `address_id` = '.$this->address_id.'  AND YIS.BTBO.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachTboData":			
			      $this->sql='SELECT * FROM YIS.BTBO WHERE `address_id` = '.$this->address_id.'  AND YIS.BTBO.`data`= "'.$this->data.'"' ;
			     //print_r($this->sql); 
			break;
			case "TekNachAllApp":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")';
			 //  print_r($this->sql); 

				}
		    break;

	case "TekNachAllApp1":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")';
				}
		    break;

case "TekNachAllApp2":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")';
				}
		    break;
case "TekNachAllApp3":		  
			   if($this->raion_id == 2 ||  $this->raion_id == 5 || $this->raion_id == 10){ 
				  $this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2,'
					      .' t1.zadol as zadol1,t2.zadol as zadol2,'
					      .' t1.zadol + t2.zadol as zadol ,'
					      .' t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,'
					      .' t1.nachisleno + t2.nachisleno  as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,'
					      .' t1.budjet+t1.pbudjet + t2.budjet+t2.pbudjet as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,'
					      .' t1.oplacheno+t2.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01") ';
				} else {
								$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t2.mec,t2.god) as period2, CONCAT_WS(" ",t3.mec,t3.god) as period3,'
					      .'CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5, CONCAT_WS(" ",t6.mec,t6.god) as period6,'
					      .'t1.zadol as zadol1,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol as zadol6,'
					      .'(t1.zadol + t2.zadol + t3.zadol + t4.zadol + t5.zadol + t6.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno as nachisleno6,'
					      .'t1.nachisleno + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno as nachisleno,'
					      .' (t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .' (t4.budjet+t4.pbudjet) as budjet4,(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,'
					      .' ((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .' (t4.budjet+t4.pbudjet) + (t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,'
					      .' t1.oplacheno+t2.oplacheno+t3.oplacheno+ t4.oplacheno+t5.oplacheno+t6.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .'t4.subsidia as subsidia4,t5.subsidia as subsidia5,t6.subsidia as subsidia6, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t4.subsidia+t5.subsidia+t6.subsidia as subsidia, '
					      .'t1.dolg as dolg1,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,'
					      .'t1.dolg +t2.dolg+t3.dolg +t4.dolg +t5.dolg+t6.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2,YIS.PODOGREV as t3,YIS.OTOPLENIE as t4 ,YIS.KVARTPLATA as t5,YIS.TBO as t6  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 3 MONTH)),"01")';
				}
		    break;
			case "AppTekOplata":
			 $this->sql='SELECT rec_id,address_id,address, god, data,kvartplata,otoplenie,podogrev,voda,stoki,tbo,summa,prixod,kassa,nomer,operator,data_in ,CASE WHEN data = "'
			.$this->t.'" AND operator = "'.$this->login.'" THEN 1 ELSE 0 END as chek FROM YIS.OPLATA  WHERE YIS.OPLATA.address_id='.$this->id.' ORDER BY YIS.OPLATA.data DESC LIMIT 1';
			// print($this->sql);   
		    break;
	    case "AppTekOplataFive":
			 $this->sql='SELECT rec_id,address, god, data,kvartplata,otoplenie,podogrev,voda,stoki,tbo,summa,prixod,kassa,nomer,operator,data_in ,CASE WHEN data = "'
			.$this->t.'" AND operator = "'.$this->login.'" THEN 1 ELSE 0 END as chek FROM YIS.OPLATA  WHERE YIS.OPLATA.address_id='.$this->id.' ORDER BY YIS.OPLATA.data DESC LIMIT 5';
			// print($this->sql);   
		    break;
			case "AppVodomerKassa"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.out,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model_id,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->id.'  AND YIS.VODOMER.spisan=0 AND YIS.VODOMER.out=0';
			break;

			case "TekPokTeplomerov":			
			      $this->sql='SELECT YIS.VODOMER.address_id,YIS.VODOMER.type,UCASE(YIS.VODOMER.place) as place,YIS.VODOMER.nomer,YIS.VODOMER.model,DATE_FORMAT(max(YIS.WATER.data),"%d-%m-%Y") as fdate,'
				      .'max(YIS.WATER.pred) as pred,max(YIS.WATER.tek) as tek,YIS.WATER.operator FROM YIS.VODOMER,YIS.WATER  WHERE YIS.VODOMER.address_id='.$this->id.' AND YIS.VODOMER.nomer= YIS.WATER.nomer AND '
				      .'YIS.WATER.address_id='.$this->id.' GROUP BY YIS.VODOMER.nomer,data ORDER BY YIS.WATER.data DESC ';
			       //print_r($this->sql); 
			break;
		} // End of Switch ($what)
		
	
		

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}

public function newOplata(stdClass $params)
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

		if(isset($params->what) && ($params->what)) {
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}
		if(isset($params->cbDo1) && ($params->cbDo1)) {
		  $this->cbDo1 = (int) $params->cbDo1;
		} else {
		  $this->cbDo1 = 0;
		}
		if(isset($params->cbDo2) && ($params->cbDo2)) {
		  $this->cbDo2 = (int) $params->cbDo2;
		} else {
		  $this->cbDo2 = 0;
		}
		if(isset($params->cbDo3) && ($params->cbDo3)) {
		  $this->cbDo3 = (int) $params->cbDo3;
		} else {
		  $this->cbDo3 = 0;
		}
		if(isset($params->cbDo4) && ($params->cbDo4)) {
		  $this->cbDo4 = (int) $params->cbDo4;
		} else {
		  $this->cbDo4 = 0;
		}
		if(isset($params->cbDo5) && ($params->cbDo5)) {
		  $this->cbDo5 = (int) $params->cbDo5;
		} else {
		  $this->cbDo5 = 0;
		}
		if(isset($params->cbDo6) && ($params->cbDo6)) {
		  $this->cbDo6 = (int) $params->cbDo6;
		} else {
		  $this->cbDo6 = 0;
		}
		if(isset($params->cbNext1) && ($params->cbNext1)) {
		  $this->cbNext1 = (int) $params->cbNext1;
		} else {
		  $this->cbNext1 = 0;
		}
		if(isset($params->cbNext2) && ($params->cbNext2)) {
		  $this->cbNext2 = (int) $params->cbNext2;
		} else {
		  $this->cbNext2 = 0;
		}
		if(isset($params->cbNext3) && ($params->cbNext3)) {
		  $this->cbNext3 = (int) $params->cbNext3;
		} else {
		  $this->cbNext3 = 0;
		}
		if(isset($params->cbNext4) && ($params->cbNext4)) {
		  $this->cbNext4 = (int) $params->cbNext4;
		} else {
		  $this->cbNext4 = 0;
		}
		if(isset($params->cbNext5) && ($params->cbNext5)) {
		  $this->cbNext5 = (int) $params->cbNext5;
		} else {
		  $this->cbNext5 = 0;
		}
		if(isset($params->cbNext6) && ($params->cbNext6)) {
		  $this->cbNext6 = (int) $params->cbNext6;
		} else {
		  $this->cbNext6 = 0;
		}
		if(isset($params->zadol1) && ($params->zadol1)) {
		  $this->zadol1 =  $params->zadol1;
		} else {
		  $this->zadol1 = 0;
		}
		if(isset($params->zadol2) && ($params->zadol2)) {
		  $this->zadol2 =  $params->zadol2;
		} else {
		  $this->zadol2 = 0;
		}
		if(isset($params->zadol3) && ($params->zadol3)) {
		  $this->zadol3 =  $params->zadol3;
		} else {
		  $this->zadol3 = 0;
		}
		if(isset($params->zadol4) && ($params->zadol4)) {
		  $this->zadol4 =  $params->zadol4;
		} else {
		  $this->zadol4 = 0;
		}
		if(isset($params->zadol5) && ($params->zadol5)) {
		  $this->zadol5 =  $params->zadol5;
		} else {
		  $this->zadol5 = 0;
		}
		if(isset($params->zadol6) && ($params->zadol6)) {
		  $this->zadol6 =  $params->zadol6;
		} else {
		  $this->zadol6 = 0;
		}
		if(isset($params->dolg1) && ($params->dolg1)) {
		  $this->dolg1 =  $params->dolg1;
		} else {
		  $this->dolg1 = 0;
		}
		if(isset($params->dolg2) && ($params->dolg2)) {
		  $this->dolg2 =  $params->dolg2;
		} else {
		  $this->dolg2 = 0;
		}
		if(isset($params->dolg3) && ($params->dolg3)) {
		  $this->dolg3 =  $params->dolg3;
		} else {
		  $this->dolg3 = 0;
		}
		if(isset($params->dolg4) && ($params->dolg4)) {
		  $this->dolg4 =  $params->dolg4;
		} else {
		  $this->dolg4 = 0;
		}
		if(isset($params->dolg5) && ($params->dolg5)) {
		  $this->dolg5 =  $params->dolg5;
		} else {
		  $this->dolg5 = 0;
		}
		if(isset($params->dolg6) && ($params->dolg6)) {
		  $this->dolg6 =  $params->dolg6;
		} else {
		  $this->dolg6 = 0;
		}
		if(isset($params->newOplata) && ($params->newOplata)) {
		  $this->newOplata =  $params->newOplata;
		} else {
		  $this->newOplata = 0;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->prixod_id) && ($params->prixod_id)) {
		  $this->prixod_id = (int) $params->prixod_id;
		} else {
		  $this->prixod_id = 0;
		}
		if(isset($params->user_id) && ($params->user_id)) {
		  $this->user_id = (int) $params->user_id;
		} else {
		  $this->user_id = 0;
		}
		if(isset($params->date_oplata) && ($params->date_oplata)) {
		  $this->date_oplata= $params->date_oplata;
		} else {
		   $this->date_oplata='';
		}	

		 $this->sql='CALL YISGRAND.newOplataApp("'
		.$this->address_id.'","'
		.$this->cbDo1.'","'
		.$this->cbDo2.'","'
		.$this->cbDo3.'","'
		.$this->cbDo4.'","'
		.$this->cbDo5.'","'
		.$this->cbDo6.'","'
		.$this->cbNext1.'","'
		.$this->cbNext2.'","'
		.$this->cbNext3.'","'
		.$this->cbNext4.'","'
		.$this->cbNext5.'","'
		.$this->cbNext6.'","'
		.$this->zadol1.'","'
		.$this->zadol2.'","'
		.$this->zadol3.'","'
		.$this->zadol4.'","'
		.$this->zadol5.'","'
		.$this->zadol6.'","'
		.$this->dolg1.'","'
		.$this->dolg2.'","'
		.$this->dolg3.'","'
		.$this->dolg4.'","'
		.$this->dolg5.'","'
		.$this->dolg6.'","'
		.$this->newOplata.'","'
		.$this->user_id.'","'
		.$this->prixod_id.'","'
		.$this->date_oplata.'",'
		.' @success, @msg)';
//print( $this->sql);
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}			
		return $this->results;
	      }
public function delOplata(stdClass $params)
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
		 $this->sql='CALL YISGRAND.delOplataApp('.$this->rec_id.', @success, @msg)';
	
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}			
		return $this->results;
	      }
	    public function getRaspechatka(stdClass $params)
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
	
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
  //print($this->address_id);
		if(isset($params->raion_id) && ($params->raion_id)) {
		  $this->raion_id = (int) $params->raion_id;
		} else {
		  $this->raion_id = 0;
		}

		if($this->raion_id == 2 || $this->raion_id == 5 || $this->raion_id == 10){ 
		      $this->sql='CALL YISGRAND.raspechatkaOplataAppVoda('.$this->address_id.',@success,@content)';
		} else {
		      $this->sql='CALL YISGRAND.raspechatkaOplataApp('.$this->address_id.',@success,@content)';
		}
			// print($this->sql);

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @content,@success';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['content'] = $this->row['@content'];
			$this->results['success'] = $this->row['@success'];
			$this->results['sql'] = $this->sql;
		}
		return $this->results;




}
/*	public function __destruct()
	{
		$_db = $this->connect($this->login,$this->password);
		$_db->close();
		
		return $this;
	}*/
}