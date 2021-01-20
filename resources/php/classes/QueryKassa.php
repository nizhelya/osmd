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
		if(isset($params->filial_id) && ($params->filial_id)) {
		  $this->filial_id = (int) $params->filial_id;
		} else {
		  $this->filial_id = 0;
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
			      $this->sql='SELECT * FROM YIS.OPLATA as t1  WHERE t1.`address_id` = '.$this->address_id.' ORDER BY t1.`rec_id` DESC ' ;
			     // print_r($this->sql); 
			break;
						
			
			case "KvartplataApp":			
			      $this->sql='SELECT * FROM YIS.KVARTPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.KVARTPLATA.`data` DESC LIMIT 22' ;
			     // print_r($this->sql); 
			break;
			case "KvartplataAppAll":			
			      $this->sql='SELECT * FROM YIS.KVARTPLATA WHERE `address_id` = '.$this->address_id.' ORDER BY YIS.KVARTPLATA.`data` DESC ' ;
			     // print_r($this->sql); 
			break;
						
			case "LgotaNachKvartplata":			
			      $this->sql='SELECT * FROM YIS.BKVARTPLATA WHERE `address_id` = '.$this->address_id.'  AND YIS.BKVARTPLATA.data=CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			     // print_r($this->sql); 
			break;
			case "LgotaNachKvartplataData":			
			      $this->sql='SELECT * FROM YIS.BKVARTPLATA WHERE `address_id` = '.$this->address_id.'  AND YIS.BKVARTPLATA.`data`= "'.$this->data.'"' ;
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
					      .' t1.subs as subs1,t2.subs as subs2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.subs + t2.subs as subs,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") ';
				} else {
					$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t1.mec,t1.god) as period8, CONCAT_WS(" ",t2.mec,t2.god) as period2,' 
					      .'CONCAT_WS(" ",t3.mec,t3.god) as period3,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t1.rzadol as zadol8,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol  as zadol6,'
					      .'t7.zadol as zadol7,'
					      .'(t1.zadol + t1.rzadol + t2.zadol + t3.zadol + t4.zadol  + t5.zadol + t6.zadol  + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t1.remont as nachisleno8,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno  as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t1.remont + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t1.roplacheno as oplacheno8,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .' t1.oplacheno+ t1.roplacheno + t2.oplacheno+t3.oplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .' t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .' t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t1.rdolg as dolg8,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg  as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t1.rdolg + t2.dolg+t3.dolg +t4.dolg   +t5.dolg+t6.dolg  +t7.dolg  as dolg '					      
					      .'FROM YIS.KVARTPLATA as t1,YIS.VODA as t2,YIS.STOKI as t3,YIS.PODOGREV as t4,YIS.OTOPLENIE as t5,YIS.TBO as t6 ,YIS.PTN as t7  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t7.address_id='.$this->id.' AND t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01") AND t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM curdate()),"01")';
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
					      .' t1.subs as subs1,t2.subs as subs2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.subs + t2.subs as subs,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") ';
				} else {
				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t1.mec,t1.god) as period8, CONCAT_WS(" ",t2.mec,t2.god) as period2,' 
					      .'CONCAT_WS(" ",t3.mec,t3.god) as period3,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t1.rzadol as zadol8,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol  as zadol6,'
					      .'t7.zadol as zadol7,'
					      .'(t1.zadol + t1.rzadol + t2.zadol + t3.zadol + t4.zadol  + t5.zadol + t6.zadol  + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t1.remont as nachisleno8,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno  as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t1.remont + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t1.roplacheno as oplacheno8,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .' t1.oplacheno+ t1.roplacheno + t2.oplacheno+t3.oplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .' t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .' t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t1.rdolg as dolg8,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg  as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t1.rdolg + t2.dolg+t3.dolg +t4.dolg   +t5.dolg+t6.dolg  +t7.dolg  as dolg '					      
					      .'FROM YIS.KVARTPLATA as t1,YIS.VODA as t2,YIS.STOKI as t3,YIS.PODOGREV as t4,YIS.OTOPLENIE as t5,YIS.TBO as t6 ,YIS.PTN as t7  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t7.address_id='.$this->id.' AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01") AND '
					      .'t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")  AND '
					      .'t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 1 MONTH)),"01")';
			 //  print_r($this->sql); 
			 //  print_r($this->sql); 

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
					      .' t1.subs as subs1,t2.subs as subs2,'
					      .' t1.subsidia+t2.subsidia as subsidia,'
					      .' t1.subs + t2.subs as subs,'
					      .' t1.dolg as dolg1,t2.dolg as dolg2,'
					      .' t1.dolg +t2.dolg as dolg '					      
					      .'FROM YIS.VODA as t1,YIS.STOKI as t2'
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.'  AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") ';
				} else {
				$this->sql='SELECT CONCAT_WS(" ",t1.mec,t1.god) as period1, CONCAT_WS(" ",t1.mec,t1.god) as period8, CONCAT_WS(" ",t2.mec,t2.god) as period2,' 
					      .'CONCAT_WS(" ",t3.mec,t3.god) as period3,CONCAT_WS(" ",t4.mec,t4.god) as period4, CONCAT_WS(" ",t5.mec,t5.god) as period5,'
					      .'CONCAT_WS(" ",t6.mec,t6.god) as period6, CONCAT_WS(" ",t7.mec,t7.god) as period7,'
					      .'t1.zadol as zadol1,t1.rzadol as zadol8,t2.zadol as zadol2,t3.zadol as zadol3,t4.zadol as zadol4,t5.zadol as zadol5,t6.zadol  as zadol6,'
					      .'t7.zadol as zadol7,'
					      .'(t1.zadol + t1.rzadol + t2.zadol + t3.zadol + t4.zadol  + t5.zadol + t6.zadol  + t7.zadol) as zadol ,'
					      .'t1.nachisleno as nachisleno1,t1.remont as nachisleno8,t2.nachisleno as nachisleno2,t3.nachisleno as nachisleno3,'
					      .'t4.nachisleno  as nachisleno4,t5.nachisleno as nachisleno5,t6.nachisleno  as nachisleno6,t7.nachisleno as nachisleno7,'
					      .'t1.nachisleno + t1.remont + t2.nachisleno + t3.nachisleno + t4.nachisleno + t5.nachisleno + t6.nachisleno + t7.nachisleno as nachisleno,'
					      .'(t1.budjet+t1.pbudjet) as budjet1,(t2.budjet+t2.pbudjet) as budjet2,(t3.budjet+t3.pbudjet) as budjet3,'
					      .'(t5.budjet+t5.pbudjet) as budjet5,(t6.budjet+t6.pbudjet) as budjet6,(t7.budjet+t7.pbudjet) as budjet7,'
					      .'((t1.budjet+t1.pbudjet) + (t2.budjet+t2.pbudjet)+(t3.budjet+t3.pbudjet) +'
					      .'(t5.budjet+t5.pbudjet) +(t6.budjet+t6.pbudjet) + (t7.budjet+t7.pbudjet)) as budjet ,'
					      .' t1.oplacheno as oplacheno1,t1.roplacheno as oplacheno8,t2.oplacheno as oplacheno2,t3.oplacheno as oplacheno3, '
					      .' t4.oplacheno  as oplacheno4,t5.oplacheno as oplacheno5,t6.oplacheno as oplacheno6,t7.oplacheno as oplacheno7,'
					      .' t1.oplacheno+ t1.roplacheno + t2.oplacheno+t3.oplacheno + t4.oplacheno +t5.oplacheno+t6.oplacheno +t7.oplacheno as oplacheno,'
					      .' t1.subsidia as subsidia1,t2.subsidia as subsidia2,t3.subsidia as subsidia3,'
					      .' t5.subsidia as subsidia5,t6.subsidia as subsidia6, t7.subsidia as subsidia7,'
					      .' t1.subs as subs1,t2.subs as subs2,t3.subs as subs3,t5.subs as subs5,t6.subs as subs6,t7.subs as subs7, '
					      .' t1.subsidia+t2.subsidia+t3.subsidia+t5.subsidia+t6.subsidia +t7.subsidia as subsidia,t1.subs+t2.subs+t3.subs+t4.subs+t5.subs+t6.subs +t7.subs as subs,'
					      .'t1.dolg as dolg1,t1.rdolg as dolg8,t2.dolg as dolg2,t3.dolg as dolg3,t4.dolg  as dolg4,t5.dolg as dolg5,t6.dolg as dolg6 ,t7.dolg as dolg7 ,'
					      .'t1.dolg +t1.rdolg + t2.dolg+t3.dolg +t4.dolg   +t5.dolg+t6.dolg  +t7.dolg  as dolg '					      
					      .'FROM YIS.KVARTPLATA as t1,YIS.VODA as t2,YIS.STOKI as t3,YIS.PODOGREV as t4,YIS.OTOPLENIE as t5,YIS.TBO as t6 ,YIS.PTN as t7  '
					      .' WHERE t1.address_id='.$this->id.'  AND t2.address_id='.$this->id.' AND t3.address_id='.$this->id.'  AND t4.address_id='.$this->id.' AND '
					      .' t5.address_id='.$this->id.'  AND t6.address_id='.$this->id.' AND t7.address_id='.$this->id.' AND '
					      .'t1.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t2.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01") AND '
					      .'t3.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t4.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t5.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t6.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")  AND '
					      .'t7.data=CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB(curdate(), INTERVAL 2 MONTH)),"01")';
			  }
		    break;

		  
			case "AppTekOplata":
			 $this->sql='SELECT rec_id,address_id,address, god, data,kvartplata,remont,ptn,otoplenie,podogrev,voda,stoki,tbo,summa,prixod,kassa,nomer,operator,data_in ,CASE WHEN data = "'
			.$this->t.'" AND operator = "'.$this->login.'" THEN 1 ELSE 0 END as chek FROM YIS.OPLATA  WHERE YIS.OPLATA.address_id='.$this->id.' ORDER BY YIS.OPLATA.rec_id DESC LIMIT 1';
			// print($this->sql);   
		    break;
	    case "AppTekOplataFive":
			 $this->sql='SELECT rec_id,address, god, data,kvartplata,remont,ptn,otoplenie,podogrev,voda,stoki,tbo,summa,prixod,kassa,nomer,operator,data_in ,CASE WHEN data = "'
			.$this->t.'" AND operator = "'.$this->login.'" THEN 1 ELSE 0 END as chek FROM YIS.OPLATA  WHERE YIS.OPLATA.address_id='.$this->id.' ORDER BY YIS.OPLATA.rec_id DESC LIMIT 5';
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
				      .'YIS.WATER.address_id='.$this->id.' GROUP BY YIS.VODOMER.nomer,data ORDER BY YIS.WATER.pok_id DESC ';
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
		
		if(isset($params->cbNext1) && ($params->cbNext1)) {
		  $this->cbNext1 = (int) $params->cbNext1;
		} else {
		  $this->cbNext1 = 0;
		}
		
		if(isset($params->zadol1) && ($params->zadol1)) {
		  $this->zadol1 =  $params->zadol1;
		} else {
		  $this->zadol1 = 0;
		}
		
		if(isset($params->dolg1) && ($params->dolg1)) {
		  $this->dolg1 =  $params->dolg1;
		} else {
		  $this->dolg1 = 0;
		}
		if(isset($params->cbDo2) && ($params->cbDo2)) {
		  $this->cbDo2 = (int) $params->cbDo2;
		} else {
		  $this->cbDo2 = 0;
		}
		
		if(isset($params->cbNext2) && ($params->cbNext2)) {
		  $this->cbNext2 = (int) $params->cbNext2;
		} else {
		  $this->cbNext2 = 0;
		}
		
		if(isset($params->zadol8) && ($params->zadol8)) {
		  $this->zadol8 =  $params->zadol8;
		} else {
		  $this->zadol8 = 0;
		}
		
		if(isset($params->dolg8) && ($params->dolg8)) {
		  $this->dolg8 =  $params->dolg8;
		} else {
		  $this->dolg8 = 0;
		}
		
		if(isset($params->newOplata) && ($params->newOplata)) {
		  $this->newOplata =  $params->newOplata;
		} else {
		  $this->newOplata = 0;
		}
		if(isset($params->newOplataOrg) && ($params->newOplataOrg)) {
		  $this->newOplataOrg =  $params->newOplataOrg;
		} else {
		  $this->newOplataOrg = 0;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->filial_id) && ($params->filial_id)) {
		  $this->filial_id = (int) $params->filial_id;
		} else {
		  $this->filial_id = 0;
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
		
		switch ($this->what) {

			case "AppTekOplata":			
			      $this->sql='CALL YISGRAND.newOplataAppOsmd("'
					.$this->address_id.'","'
					.$this->cbDo1.'","'					
					.$this->cbNext1.'","'					
					.$this->zadol1.'","'					
					.$this->dolg1.'","'	
					.$this->cbDo2.'","'					
					.$this->cbNext2.'","'					
					.$this->zadol8.'","'					
					.$this->dolg8.'","'	
					.$this->newOplata.'","'
					.$this->user_id.'","'
					.$this->prixod_id.'","'
					.$this->date_oplata.'",'
					.' @success, @msg)';
			break;
			
		}
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
		$this->sql='';
		switch ($this->what) {
			case "delOplataApp":
			      $this->sql='CALL YISGRAND.delOplataApp('.$this->rec_id.',@success, @msg)';

			break;
			case "delOplataOrg":			
			      		 $this->sql='CALL YISGRAND.delOplataOrg('.$this->rec_id.', @success, @msg)';

			break;
			
			}
	
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
			case "raspechatkaOplataApp":
			      if($this->raion_id == 2 || $this->raion_id == 5 || $this->raion_id == 10){ 
				      $this->sql='CALL YISGRAND.raspechatkaOplataAppVoda('.$this->address_id.',@success,@content)';
			      } else {
				      $this->sql='CALL YISGRAND.raspechatkaOplataApp('.$this->address_id.',@success,@content)';
			      }
			break;
			case "raspechatkaOplataOrg":			
				      $this->sql='CALL YISGRAND.raspechatkaOplataOrgVoda('.$this->filial_id.',@success,@content)';
//print( $this->sql);

			break;
			case "schetVik":			
				      $this->sql='CALL YISGRAND.schetVik('.$this->rec_id.',"'.$this->sdata.'",@success,@content)';

			break;
			case "AktSubsUtszn":
				      $this->sql='CALL YISGRAND.AktSubsUtszn('.$this->rec_id.',@success,@content)';
			 //   print_r($this->sql); 
			break;
		
			case "AktLgotaUtszn":
				      $this->sql='CALL YISGRAND.AktLgotaUtsznOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@content)';
			 //   print_r($this->sql); 
			break;
			case "ReestrLgotaUtsznAll":
				      $this->sql='CALL YISGRAND.ReestrLgotaUtsznAll_kv('.$this->osmd_id.',"'.$this->data.'",@success,@content)';
			    //print_r($this->sql); 
			break;
		
			case "ReestrSubsidiaUtsznAll":
				      $this->sql='CALL YISGRAND.ReestrSubsidiaUtsznAll_kv('.$this->osmd_id.',"'.$this->data.'",@success,@content)';
			  //  print_r($this->sql); 
			break;
			
			
			case "AktLgotaUtsznAll":
				      $this->sql='CALL YISGRAND.AktLgotaUtsznAll_kv('.$this->osmd_id.',"'.$this->data.'",@success,@content)';
			 //   print_r($this->sql); 
			break;
			
			case "Forma3LgotaUtszn":
				      $this->sql='CALL YISGRAND.Forma3LgotaUtszn_kv('.$this->osmd_id.',"'.$this->data.'",@success,@content)';
			    //print_r($this->sql); 
			break;
			case "AktSubsidiaUtsznAll":
				      $this->sql='CALL YISGRAND.AktSubsidiaUtsznAll_kv('.$this->osmd_id.',"'.$this->data.'",@success,@content)';
			 //   print_r($this->sql); 
			break;
			case "AktSubsidiaOsmd":
				      $this->sql='CALL YISGRAND.AktSubsidiaOsmd("'.$this->osmd_id.'","'.$this->address_id.'",@success,@content)';
			  //  print_r($this->sql); 
			break;
			case "ReestrToOshadBank":
				
				      $this->sql='CALL YISGRAND.ReestrOshadBank_osmd("0",'.$this->osmd_id.',"'.$this->data.'",@success,@content)';
				
			break;
			case "ReestrFromOshadBank":
				
				      $this->sql='CALL YISGRAND.ReestrOshadBank_osmd("1",'.$this->osmd_id.',"'.$this->data.'",@success,@content)';
				
			break;
			case "ReestrToOshadBankLgota":
				
				      $this->sql='CALL YISGRAND.ReestrLgotaOshadBank_osmd("0",'.$this->osmd_id.',"'.$this->data.'",@success,@content)';
				
			break;
			case "ReestrFromOshadBankLgota":
				
				      $this->sql='CALL YISGRAND.ReestrLgotaOshadBank_osmd("1",'.$this->osmd_id.',"'.$this->data.'",@success,@content)';
				
			break;
			}
	
		

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