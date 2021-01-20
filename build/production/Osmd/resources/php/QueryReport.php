<?php

class QueryReport
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
	protected $type_id;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
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
		 $this->what = $params->what;
		} else {
		  $this->what = null;
		}


// num
$this->cat_id=0;
$this->raion_id=0;
$this->address_id=0;
$this->dog_id=0;
$this->house_id=0;
$this->org_id=0;
$this->cat_yes=0;
$this->raion_yes=0;
$this->house_yes=0;
$this->org_yes=0;
//string
$this->date_from='';
$this->date_to='';
$this->nr='';
$this->ddata='';



$array = (array) $params;
foreach ( $array as $key => $value )  {
   if(isset($value)) {  
		  if (is_int($value)) { 
					$this->$key= (int)$value;}
			else if (is_float($value)) { 
					$this->$key= $value;}
			else if (is_array($value)) { 
					$this->$key= (array)$value;}
			else {
					$this->$key =$_db->real_escape_string($value);
			}
  }
}
		$this->sql='';
		$this->vod=implode(':',$this->vodomer);
		//print($this->vod);
		switch ($this->what) {

// ЮТКЭ БЮДЖЕТ
			case "NagruzkaYtke":			
					switch ($this->razv) {
	case "1": 
		$this->sql='CALL YISGRAND.NagruzkaRazvYtke("'.$this->date_from.'",@content,@success,@msg)';
	break;
	case "0": 
		$this->sql='CALL YISGRAND.NagruzkaYtke("'.$this->date_from.'",@content,@success,@msg)';
	break;
	}	
	break;
			
			case "ItogBudjetPoGroupYtke":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupYtke('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;	
			case "ItogBudjetPoGroupMgkc":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupMgkc('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "ItogBudjetPoGroupVik":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupVik('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "ItogBudjetPoGroupUgtrans":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupUgtrans('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
	   case "ItogBudjetPoGroupRazvYtke":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupRazvYtke('
						.'"'.$this->lgota_yes.'", '
						.'"'.$this->gr.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;

	   case "ItogBudjetPoGroupRazvMgkc":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupRazvMgkc('
						.'"'.$this->lgota_yes.'", '
						.'"'.$this->gr.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
	   case "ItogBudjetPoGroupRazvVik":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupRazvVik('
						.'"'.$this->lgota_yes.'", '
						.'"'.$this->gr.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;

	   case "ItogBudjetPoGroupRazvUgtrans":			
			      $this->sql='CALL YISGRAND.ItogBudjetPoGroupRazvUgtrans('
						.'"'.$this->lgota_yes.'", '
						.'"'.$this->gr.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "tabOtSvNach":	

			    $this->cat_id=0;
			    $this->raion_id=0;
			    $this->address_id=0;
			    $this->dog_id=0;
			    $this->house_id=0;
			    $this->org_id=0;
			    $this->cat_yes=0;
			    $this->raion_yes=0;
			    $this->house_yes=0;
			    $this->org_yes=0;


		
			      $this->sql='CALL YISGRAND.tabOtSvNach('
			      .$this->cat_id.', '
			      .$this->raion_id.', '
			      .$this->house_id.', '
			      .$this->org_id.', '
			      .$this->cat_yes.', '
			      .$this->raion_yes.', '
			      .$this->house_yes.', '
			      .$this->org_yes.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_org":	

			    $this->cat_id=0;
			    $this->raion_id=0;
			    $this->address_id=0;
			    $this->dog_id=0;
			    $this->house_id=0;
			    $this->org_id=0;
			    $this->cat_yes=0;
			    $this->raion_yes=0;
			    $this->house_yes=0;
			    $this->org_yes=0;

		
			      $this->sql='CALL YISGRAND.tabOtSvNach_org('
			      .$this->cat_id.', '
			      .$this->raion_id.', '
			      .$this->house_id.', '
			      .$this->org_id.', '
			      .$this->cat_yes.', '
			      .$this->raion_yes.', '
			      .$this->house_yes.', '
			      .$this->org_yes.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_money":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_money('
			      .'"'.$this->cat_id.'", '
			      .'"'.$this->raion_id.'", '
			      .'"'.$this->house_id.'", '
			      .'"'.$this->org_id.'", '
			      .'"'.$this->cat_yes.'", '
			      .'"'.$this->raion_yes.'", '
			      .'"'.$this->house_yes.'", '
			     .'"'.$this->org_yes.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;

			case "tabOtSvNach_org_money":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_org_money('
			      .'"'.$this->cat_id.'", '
			      .'"'.$this->raion_id.'", '
			      .'"'.$this->house_id.'", '
			      .'"'.$this->org_id.'", '
			      .'"'.$this->cat_yes.'", '
			      .'"'.$this->raion_yes.'", '
			      .'"'.$this->house_yes.'", '
			     .'"'.$this->org_yes.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;


			case "SvodOtoplenieGkal":			
			      $this->sql='CALL YISGRAND.SvodOtoplenieGkal("'.$this->date_from.'",@content,@success,@msg)';
			//  print($this->sql);
			break;
			case "SvodOtoplenieSm2":			
			      $this->sql='CALL YISGRAND.SvodOtoplenieSm2("'.$this->date_from.'",@content,@success,@msg)';
			//  print($this->sql);
			break;
			case "tabOtSvNach_perer":			
			      $this->sql='CALL YISGRAND.tabOtSvNach_perer('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;



			case "YkteHistoryGkal":			
			      $this->sql='CALL YISGRAND.YkteHistoryGkal('
			      .$this->org_id.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;



			case "schetUtke":			
			      $this->sql='CALL YISGRAND.schetUtke('
			      .$this->org_id.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
			case "qtyMecPokazAppVodXvoda":			
			      $this->sql='CALL YISGRAND.qtyMecPokazAppVodXvoda("'.$this->house_id.'",'.$this->start.',"'.$this->date_from.'",@head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
		case "NachislenoAllHouseVik":			
			      $this->sql='CALL YISGRAND.NachislenoAllHouseVik("'.$this->house_id.'", "'.$this->date_from.'","'.$this->date_to.'",@head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
			case "courseMapAppVik":			
			      $this->sql='CALL YISGRAND.courseMapAppVik("'.$this->house_id.'", "'.$this->date_from.'",@head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
			case "naPoverkuAppVik":			
			      $this->sql='CALL YISGRAND.naPoverkuAppVik("'.$this->house_id.'", "'.$this->date_from.'",@head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
		case "courseMapAppYtke":			
			      $this->sql='CALL YISGRAND.courseMapAppYtke("'.$this->house_id.'", "'.$this->date_from.'",@head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;

			case "KassaReestrYtke":		
			      $this->sql='CALL YISGRAND.KassaReestrYtke('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "KassaReestrVik":		
			      $this->sql='CALL YISGRAND.KassaReestrVik('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
		case "KassaReestrMgkc":		
			      $this->sql='CALL YISGRAND.KassaReestrMgkc('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;

			case "KassirReestrDayYtke":		
			      $this->sql='CALL YISGRAND.KassirReestrDayYtke('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->kassir.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "KassirReestrDayVik":		
			      $this->sql='CALL YISGRAND.KassirReestrDayVik('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->kassir.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
		case "KassirReestrDayMgkc":		
			      $this->sql='CALL YISGRAND.KassirReestrDayMgkc('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->kassir.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;

			case "KassirReestrYtke":		
			      $this->sql='CALL YISGRAND.KassirReestrYtke('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->kassir.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "KassirReestrVik":		
			      $this->sql='CALL YISGRAND.KassirReestrVik('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->kassir.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
		case "KassirReestrMgkc":		
			      $this->sql='CALL YISGRAND.KassirReestrMgkc('
			      .'"'.$this->prixod_id.'", '
			      .'"'.$this->kassir.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
	case "NachislenoPodogrevAllYtke":		
			      $this->sql='CALL YISGRAND.NachislenoPodogrevAllYtke('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
case "NachislenoOtoplenieAllYtke":		
			      $this->sql='CALL YISGRAND.SvodOtNasel('
			      .'"'.$this->date_from.'", '
			      .'@content,@success,@msg)';
			//  print($this->sql);
			break;
			case "NachislenoAllMgkc":		
			      $this->sql='CALL YISGRAND.NachislenoAllMgkc('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "NachislenoAllVik":		
			      $this->sql='CALL YISGRAND.NachislenoAllVik('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "NachislenoAllUgtrans":		
			      $this->sql='CALL YISGRAND.NachislenoAllUgtrans('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "CityHousesMgkc":		
			      $this->sql='CALL YISGRAND.CityHousesMgkc(@content,@success,@msg)';
			break;
			case "CityHousesVik":		
			      $this->sql='CALL YISGRAND.CityHousesVik(@content,@success,@msg)';
			break;
			case "CityHousesUgtrans":		
			      $this->sql='CALL YISGRAND.CityHousesUgtrans(@content,@success,@msg)';
			break;
			case "CityHousesYtke":		
			      $this->sql='CALL YISGRAND.CityHousesYtke(@content,@success,@msg)';
			break;
			case "AppHistory":		
			      $this->sql='CALL YISGRAND.AppHistory("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "LgotnikData":		
			      $this->sql='CALL YISGRAND.LgotnikData("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ItogMonthYtke":		
			      $this->sql='CALL YISGRAND.ItogMonthYtke("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ItogMonthVik":		
			      $this->sql='CALL YISGRAND.ItogMonthVik("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ItogMonthMgkc":		
			      $this->sql='CALL YISGRAND.ItogMonthMgkc("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ItogMonthUgtrans":		
			      $this->sql='CALL YISGRAND.ItogMonthUgtrans("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "controlLgot":
			      $this->sql='CALL YISGRAND.controlLgot("'.$this->rbUsluga.'","'.$this->data.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ControlUgtrans":		
			      $this->sql='CALL YISGRAND.ControlUgtrans("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ControlVik":		
			      $this->sql='CALL YISGRAND.ControlVik("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ControlMgkc":		
			      $this->sql='CALL YISGRAND.ControlMgkc("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "ControlYtke":		
			      $this->sql='CALL YISGRAND.ControlYtke("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "reportLgotnik":		
			      $this->sql='CALL YISGRAND.reportLgotnik("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "reportLgotnikEnd":		
			      $this->sql='CALL YISGRAND.reportLgotnikEnd("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "reportLgotnikLgota":		
			      $this->sql='CALL YISGRAND.reportLgotnikLgota("'.$this->lgota_id.'", @head,@content,@foot,@success,@msg)';
			break;
			case "reportLgotnikIzm":		
			      $this->sql='CALL YISGRAND.reportLgotnikIzm("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			break;
			case "reportLgotnikGroup":		
			      $this->sql='CALL YISGRAND.reportLgotnikGroup("'.$this->gr.'", @head,@content,@foot,@success,@msg)';
			break;
			case "reportLgotnikHouse":		
			      $this->sql='CALL YISGRAND.reportLgotnikHouse("'.$this->house_id.'", @head,@content,@foot,@success,@msg)';
			break;
			case "YtkeDolgi":			
					switch ($this->city_yes) {
						case "1": 
									switch ($this->rbDolg) {
									case "1": 
												$this->sql='CALL YISGRAND.DolgSummaCityYtke('.$this->start.','.$this->finish.',"'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthCityYtke('.$this->start.',"'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
						case "0": 
								 switch ($this->rbDolg) {
									case "1": 
											$this->sql='CALL YISGRAND.DolgSummaYtke('
											.'"'.$this->raion_yes.'", '
											.'"'.$this->raion_id.'", '
											.'"'.$this->house_yes.'", '
											.'"'.$this->house_id.'", '
											.'"'.$this->start.'",'
											.'"'.$this->date_from.'",'
											.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthYtke('
												.'"'.$this->raion_yes.'", '
												.'"'.$this->raion_id.'", '
												.'"'.$this->house_yes.'", '
												.'"'.$this->house_id.'", '
												.'"'.$this->start.'",'
												.'"'.$this->date_from.'",'
												.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
			}
			break;
				case "MgkcDolgi":			
					switch ($this->city_yes) {
						case "1": 
									switch ($this->rbDolg) {
									case "1": 
												$this->sql='CALL YISGRAND.DolgSummaCityMgkc("'.$this->start.'","'.$this->finish.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthCityMgkc("'.$this->start.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
						case "0": 
								 switch ($this->rbDolg) {
									case "1": 
											$this->sql='CALL YISGRAND.DolgSummaMgkc('
											.'"'.$this->raion_yes.'", '
											.'"'.$this->raion_id.'", '
											.'"'.$this->house_yes.'", '
											.'"'.$this->house_id.'", '
											.'"'.$this->start.'",'
											.'"'.$this->date_from.'",'
											.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthMgkc('
												.'"'.$this->raion_yes.'", '
												.'"'.$this->raion_id.'", '
												.'"'.$this->house_yes.'", '
												.'"'.$this->house_id.'", '
												.'"'.$this->start.'",'
												.'"'.$this->date_from.'",'
												.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
			}
			break;

			case "ControlCubov":			
					$this->sql='CALL YISGRAND.ControlCubov("'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';								
				
			break;
			case "CityVodomer":			
					$this->sql='CALL YISGRAND.CityVodomer(@content,@success,@msg)';								
				
			break;
				case "VikDolgi":			
					switch ($this->city_yes) {
						case "1": 
									switch ($this->rbDolg) {
									case "1": 
												$this->sql='CALL YISGRAND.DolgSummaCityVik("'.$this->start.'","'.$this->finish.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthCityVik("'.$this->start.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
		// print($this->sql);

									break;
									}	
						break;

						case "0": 
								 switch ($this->rbDolg) {
									case "1": 
											$this->sql='CALL YISGRAND.DolgSummaVik('
											.'"'.$this->raion_yes.'", '
											.'"'.$this->raion_id.'", '
											.'"'.$this->house_yes.'", '
											.'"'.$this->house_id.'", '
											.'"'.$this->start.'",'
											.'"'.$this->finish.'",'
											.'"'.$this->date_from.'",'
											.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthVik('
												.'"'.$this->raion_yes.'", '
												.'"'.$this->raion_id.'", '
												.'"'.$this->house_yes.'", '
												.'"'.$this->house_id.'", '
												.'"'.$this->start.'",'
												.'"'.$this->date_from.'",'
												.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
			}
			break;


				case "UgtransDolgi":			
					switch ($this->city_yes) {
						case "1": 
									switch ($this->rbDolg) {
									case "1": 
												$this->sql='CALL YISGRAND.DolgSummaCityUgtrans("'.$this->start.'","'.$this->finish.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthCityUgtrans("'.$this->start.'","'.$this->date_from.'","'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
						case "0": 
								 switch ($this->rbDolg) {
									case "1": 
											$this->sql='CALL YISGRAND.DolgSummaUgtrans('
											.'"'.$this->raion_yes.'", '
											.'"'.$this->raion_id.'", '
											.'"'.$this->house_yes.'", '
											.'"'.$this->house_id.'", '
											.'"'.$this->start.'",'
											.'"'.$this->date_from.'",'
											.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									case "0": 
												$this->sql='CALL YISGRAND.DolgMonthUgtrans('
												.'"'.$this->raion_yes.'", '
												.'"'.$this->raion_id.'", '
												.'"'.$this->house_yes.'", '
												.'"'.$this->house_id.'", '
												.'"'.$this->start.'",'
												.'"'.$this->date_from.'",'
												.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
									break;
									}	
						break;
			}
			break;
			
			case "YtkeWarning":			
			    	switch ($this->rbDolg) {
						case "1": 
									$this->sql='CALL YISGRAND.DolgWarningSummaYtke('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						case "0": 
									$this->sql='CALL YISGRAND.DolgWarningMonthYtke('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						}	
			break;

			case "VikWarning":			
			    	switch ($this->rbDolg) {
						case "1": 
									$this->sql='CALL YISGRAND.DolgWarningSummaVik('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						case "0": 
									$this->sql='CALL YISGRAND.DolgWarningMonthVik('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						}	
			break;
			case "MgkcWarning":			
			    	switch ($this->rbDolg) {
						case "1": 
									$this->sql='CALL YISGRAND.DolgWarningSummaMgkc('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						case "0": 
									$this->sql='CALL YISGRAND.DolgWarningMonthMgkc('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						}	
			break;
			case "UgtransWarning":			
			    	switch ($this->rbDolg) {
						case "1": 
									$this->sql='CALL YISGRAND.DolgWarningSummaUgtrans('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						case "0": 
									$this->sql='CALL YISGRAND.DolgWarningMonthUgtrans('
									.'"'.$this->raion_yes.'", '
									.'"'.$this->raion_id.'", '
									.'"'.$this->house_yes.'", '
									.'"'.$this->house_id.'", '
									.'"'.$this->start.'",'
									.'"'.$this->date_from.'",'
									.'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						break;
						}	
			break;
			case "VikPerer":			
			      $this->sql='CALL YISGRAND.VikPerer('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;

			case "schetVik":			
			      $this->sql='CALL YISGRAND.schetVik('
			      .$this->org_id.', '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;

		
			case "VikSvodn":		
					if ($this->org_yes  == "1"  ) {		
			      $this->sql='CALL YISGRAND.VikSvodn_org('
			      .'"'.$this->org_id.'",'
			      .'"'.$this->org_yes.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
						} else {
			      $this->sql='CALL YISGRAND.VikSvodn("'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';						
						}
			//  print($this->sql);
			break;


			case "VikBuh":			
			      $this->sql='CALL YISGRAND.VikBuh('
			      .'"'.$this->cat_id.'", '
			      .'"'.$this->raion_id.'", '
			      .'"'.$this->house_id.'", '
			      .'"'.$this->org_id.'", '
			      .'"'.$this->cat_yes.'", '
			      .'"'.$this->raion_yes.'", '
			      .'"'.$this->house_yes.'", '
			      .'"'.$this->org_yes.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;



			case "VikBuhOrg":			
			      $this->sql='CALL YISGRAND.VikBuhOrg('
			      .'"'.$this->cat_id.'", '
			      .'"'.$this->raion_id.'", '
			      .'"'.$this->house_id.'", '
			      .'"'.$this->org_id.'", '
			      .'"'.$this->cat_yes.'", '
			      .'"'.$this->raion_yes.'", '
			      .'"'.$this->house_yes.'", '
			      .'"'.$this->org_yes.'", '
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;



			case "VikVodHouses":			
			      $this->sql='CALL YISGRAND.VikVodHouses('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
			
			
			case "VikVodOrg":			
			      $this->sql='CALL YISGRAND.VikVodOrg('
			      .'"'.$this->date_from.'", '
			      .'"'.$this->date_to.'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
			



			case "DogovorYtke":			
			      $this->sql='CALL YISGRAND.YtkeDogovor('
			      .'"'.$this->dog_id.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;


			case "DogovorYtke_mb":			
			      $this->sql='CALL YISGRAND.YtkeDogovor_mb('
			      .'"'.$this->dog_id.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;


			case "DogovorYtke_flat":			
			      $this->sql='CALL YISGRAND.YtkeDogovorFlat('
			      .'"'.$this->address_id.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;

			case "VikDogovorFlat":			
			      $this->sql='CALL YISGRAND.VikDogovorFlat('
			      .'"'.$this->address_id.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;



			case "HistoryFlatPayment":			
			      $this->sql='CALL YISGRAND.HistoryFlatPayment('
			      .'"'.$this->address_id.'", '
			      .'"", '
			      .'"", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;
			case "AktRasplombirovkiVodomer":			
			      $this->sql='CALL YISGRAND.AktRasplombirovkiVodomer('.$this->address_id.',"'.implode(',',$this->vodomer).'", @head,@content,@foot,@success,@msg)';
			 // print($this->sql);
			break;
			case "AktOplombirovkiVodomer":			
			      $this->sql='CALL YISGRAND.AktOplombirovkiVodomer('.$this->address_id.',"'.implode(',',$this->vodomer).'", @head,@content,@foot,@success,@msg)';
			//  print($this->sql);
			break;
			case "FlatRaspechatkaVik":			
			      $this->sql='CALL YISGRAND.FlatRaspechatkaVik('.$this->address_id.',"'.$this->date_from.'","'.$this->date_to.'",@content,@success,@msg)';

			break;
			case "FlatRaspechatkaYtke":			
			      $this->sql='CALL YISGRAND.FlatRaspechatkaYtke('.$this->address_id.',"'.$this->date_from.'","'.$this->date_to.'",@content,@success,@msg)';

			  //print($this->sql);
			break;
			case "FlatRaspechatkaMgkc":			
			      $this->sql='CALL YISGRAND.FlatRaspechatkaMgkc('.$this->address_id.',"'.$this->date_from.'","'.$this->date_to.'",@content,@success,@msg)';

			break;
			case "FlatRaspechatkaUgtrans":
			      $this->sql='CALL YISGRAND.FlatRaspechatkaUgtrans('.$this->address_id.',"'.$this->date_from.'","'.$this->date_to.'",@content,@success,@msg)';
			
			break;
			case "HouseRaspechatkaMgkc":
			      $this->sql='CALL YISGRAND.HouseRaspechatkaMgkc('.$this->house_id.',"'.$this->sdata.'",@head,@content,@foot,@success,@msg)';
			  //  print_r($this->sql); 
			break;
			case "HouseKvRaspechatkaMgkc":
			      $this->sql='CALL YISGRAND.HouseKvRaspechatkaMgkc('.$this->house_id.',"'.$this->address_ot.'","'.$this->address_do.'","'.$this->sdata.'",@head,@content,@foot,@success,@msg)';
			  //  print_r($this->sql); 
			break;

			case "DogovorYtke_flat_update":	


		if(isset($params->ddata) && ($params->ddata)) {
		 $this->ddata = $params->ddata;
		} else {
		  $this->ddata = null;
		}

		
			      $this->sql='CALL YISGRAND.YtkeDogovorFlatUpdate('
			      .$this->address_id.', '
			      .'"'.$this->nr.'", '
			      .'"'.$this->ddata.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;



			case "DogovorVik_flat_update":	


		if(isset($params->ddata) && ($params->ddata)) {
		 $this->ddata = $params->ddata;
		} else {
		  $this->ddata = null;
		}

		
			      $this->sql='CALL YISGRAND.VikDogovorFlatUpdate('
			      .$this->address_id.', '
			      .'"'.$this->nr.'", '
			      .'"'.$this->ddata.'", '
			      .' @head,@content,@foot)';
			//  print($this->sql);
			break;

		}
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_error);
		
		$this->sql_callback='SELECT @head,@content,@foot,@success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['head'] = $this->row['@head'];
			$this->results['content'] = $this->row['@content'];
			$this->results['sql'] = $this->sql;
			$this->results['foot'] = $this->row['@foot'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg'] = $this->row['@msg'];

		}
			
		/*include_once('absent_file.php')*/


		return $this->results;

}


}