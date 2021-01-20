<?php




class QueryPayment
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

		if(isset($params->ins_id) && ($params->ins_id)) {
		  $this->ins_id = (int) $params->ins_id;
		} else {
		  $this->ins_id = 0;
		}

		$this->t= date('Ymd');
		
		switch ($this->what) {

		

			case "PaymentStatus":			
			      $this->sql='SELECT YIS.PAYMENT.`status` FROM YIS.PAYMENT WHERE YIS.PAYMENT.payment_id='.$this->ins_id.' LIMIT 1 ';
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

		
		 $this->sql='CALL YISGRAND.newPaymentApp('
		.$this->address_id.','
		.$this->cbDo1.','
		.$this->cbDo2.', '
		.$this->cbDo3.','
		.$this->cbDo4.','
		.$this->cbDo5.', '
		.$this->cbDo6.','
		.$this->cbNext1.','
		.$this->cbNext2.', '
		.$this->cbNext3.','
		.$this->cbNext4.','
		.$this->cbNext5.', '
		.$this->cbNext6.','
		.$this->zadol1.','
		.$this->zadol2.', '
		.$this->zadol3.','
		.$this->zadol4.','
		.$this->zadol5.', '
		.$this->zadol6.','
		.$this->dolg1.','
		.$this->dolg2.', '
		.$this->dolg3.','
		.$this->dolg4.','
		.$this->dolg5.', '
		.$this->dolg6.','
		.$this->newOplata.','
		.$this->user_id.','
		.$this->prixod_id.',"'
		.$this->date_oplata.'",'
		.'@kvartplata, @otoplenie, @podogrev, @voda, @stoki, @tbo, '
		.' @ins_id, @success, @msg)';
		
		
//print( $this->sql);
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @kvartplata, @otoplenie, @podogrev, @voda, @stoki, @tbo, @ins_id, @success, @msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['ins_id'] = $this->row['@ins_id'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
			
			
			$this->results['kvartplata']= floor($this->row['@kvartplata'] *100);
			$this->results['otoplenie']= floor($this->row['@otoplenie'] *100);
			$this->results['podogrev']= floor($this->row['@podogrev'] *100);
			$this->results['voda']= floor($this->row['@voda'] *100);
			$this->results['stoki']= floor($this->row['@stoki'] *100);
			$this->results['tbo']= floor($this->row['@tbo'] *100);
		
		}	
		
	
include 'ipay.class.php';
	
if ($this->results['success'] > 0) {

$iPay = new iPay( '492' , '8c762811f976b8e7877eb140b1e76559f2d954f8' , '074088db69889f6919d7542555f4a26a41b1fc62' );
$iPay->set_urls('http://ipay.ua/good/','http://ipay.ua/bad/');


// TRANSACTIONS
if ($this->results['kvartplata'] >0) {

$iPay->set_transaction(492, $this->results['kvartplata'] ,'Квартплата, договор #00000');

}

if ($this->results['otoplenie'] >0) {

$iPay->set_transaction(492, $this->results['otoplenie'],'Отопление, договор #00000');

}

if ($this->results['podogrev'] >0) {

$iPay->set_transaction(492, $this->results['podogrev'],'Отопление, договор #00000');

}

if ($this->results['voda'] >0) {

$iPay->set_transaction(492, $this->results['voda'],'Водоснабжение, договор #00000');

}

if ($this->results['stoki'] >0) {

$iPay->set_transaction(492, $this->results['stoki'],'Водоотведение, договор #00000');

}

if ($this->results['tbo'] >0) {

$iPay->set_transaction(492, $this->results['tbo'],'Вывоз ТБО, договор #00000');

}
// TRANSACTIONS

$xml_result = $iPay->create_payment();
//$this->xmlresult = $iPay->outdata;
$this->xmlresult = $xml_result;
//echo $this->xmlresult;

 // ==================== XML TO ARRAY
$this->xmlresult = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $this->xmlresult );
include 'XmlToArray.php';
$array = XML2Array::createArray($this->xmlresult);
//print_r($array);
//print_r($array['payment']['transactions']['transaction']);
//print_r($paym);
//$pid = $paym['@attributes']['id'];
//$pident = $paym['ident'];
//$pamount = $paym['amount'];
//$ptimestamp = $paym['timestamp'];

$paym = $array['payment'];
$pid = $paym['pid'];
$pstatus = $paym['status'];
$url = $paym['url'];

$psalt = $paym['salt'];
$psign = $paym['sign'];

// =========== TRANSACTIONS 
/*	$i=-1;
	$res=array();
	
	foreach($array['payment']['transactions']['transaction'] as $tr){
	$i = $i + 1;
	
	$res[$i]['trid']= $tr['@attributes']['id'];
	$res[$i]['type']= $tr['type'];
	$res[$i]['status']= $tr['status'];
	//print_r($tr);	
	}
	//print_r($res);*/
// =========== TRANSACTIONS 
// ==================== XML TO ARRAY

$this->results['url'] = $paym['url'];
$this->results['status'] = $paym['status'];

}	







$this->up_stat ='UPDATE YIS.PAYMENT SET YIS.PAYMENT.`status`="1", YIS.PAYMENT.`pay_id`="'.$pid.'", YIS.PAYMENT.`salt`="'.$psalt.'", YIS.PAYMENT.`sign`="'.$psign.'"  
WHERE YIS.PAYMENT.`payment_id`="'.$this->results['ins_id'].'" LIMIT 1';
$this->upd_status = $_db->query($this->up_stat) or die('Connect Error in '.$this->what.'(' .  $this->up_stat . ') ' . $_db->connect_error);






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
		 $this->sql='CALL YISGRAND.delOplataApp('
		.$this->address_id.','
		.$this->kvartplata.','
		.$this->otoplenie.', '
		.$this->podogrev.','
		.$this->voda.','
		.$this->stoki.', '
		.$this->tbo.','
		.$this->summa.',"'
		.$this->data.'","'
		.$this->operator.'",'
		.' @success, @msg)';
	
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

		if($this->raion_id == 2 || $this->raion_id == 5 ){ 
		      $this->sql='CALL YISGRAND.raspechatkaOplataAppVoda('.$this->address_id.',@success,@content)';
		} else {
		      $this->sql='CALL YISGRAND.raspechatkaOplataApp('.$this->address_id.',@success,@content)';
		}
			//  print($this->sql);

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