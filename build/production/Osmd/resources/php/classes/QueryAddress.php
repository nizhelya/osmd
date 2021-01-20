<?php
include_once './yis_config.php';

class QueryAddress
{
	private $_db;
	protected $_result;
	protected $address_id;
	protected $private;
	protected $appartment;
	protected $_total;
	protected $_count;
	protected $_sql;
	
	protected $house_id = HOUSE;
	protected $osmd_id = OSMD;

	protected $_sql_total;
	protected $_limit;
	protected $login;
	protected $password;
	protected $_array;
	protected $_id;
	protected $_what;	
	protected $_place;
	protected $_type;
	public $results;
	
/*
public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YISGRAND');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}
*/
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
		 $_what = $params->what;
		} else {
		  $_what = null;
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $_id = (int) $params->what_id;
		} else {
		  $_id = 0;
		}

		if(isset($params->address_id) && ($params->address_id)) {
		 $this->address_id = $params->address_id;
		} else {
		  $this->address_id = null;
		}
	
		if(isset($params->privat) && ($params->privat)) {
		 $this->privat = $params->privat;
		} else {
		  $this->privat = 0;
		}
		if(isset($params->appartment) && ($params->appartment)) {
		 $this->appartment = $params->appartment;
		} else {
		  $this->appartment = null;
		}

		switch ($_what) {
	//inuse
	  case "raion":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.RAION WHERE YIS.RAION.`raion_id` in('.$this->raion_id.')';
			   //print($_sql); 
		    break;
		     case "street":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.STREET WHERE YIS.STREET.`street_id` in('.$this->street_id.')';
			    
		    break;
		      case "house":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.HOUSE WHERE YIS.HOUSE.`house_id`  in('.$this->house_id.')';
	    //  print($_sql);
			    
		    break;
		  case "StreetsFromRaion":
			$_sql_total=null; 
			if ($_id==0) {
			  $_sql='SELECT * FROM YIS.STREET ORDER BY street';
			} else {
			  $_sql='SELECT YIS.STREET.street_id, YIS.STREET.street FROM YIS.STREET, YIS.HOUSE WHERE YIS.STREET.street_id=YIS.HOUSE.street_id AND YIS.HOUSE.raion_id='.$_id.' GROUP BY YIS.STREET.street_id ORDER BY YIS.STREET.street';
			}
			    
		    break;

		    case "HousesFromRaion":
			  $_sql_total=null; 
			  $_sql='SELECT raion_id,street_id,house_id,raion,house,house as item FROM YIS.HOUSE WHERE raion_id= '.$_id.' ORDER BY house';
			    
		    break;

		  case "kvartira":
			 
			    $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment,
			    address as item,cast(appartment as unsigned) as app FROM YIS.ADDRESS WHERE house_id in('.$this->house_id.') ORDER BY app';
			 
//print($_sql);
		    break;

		       case "AddressFromHouses":
			  $_sql_total=null; 
			  if ($_id == 0) { $_sql='SELECT address_id, address FROM YIS.ADDRESS ORDER BY address';
			  } else {
			  $_sql='SELECT * FROM YIS.ADDRESS WHERE house_id= '.$_id.'';
			    //print($_sql);
			  }
		    break;
			
		     case "address":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.ADDRESS  WHERE address_id='.$_id.' LIMIT 1';
			    
		    break;


		    case "CheckFlat":

			  $_sql_total=null; 
			  $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment FROM YIS.ADDRESS WHERE house_id='.$this->house_id.' AND appartment="'.$this->appartment.'" LIMIT 1';
			// print($_sql);  
		    break;
		    case "HistoryAppartment":
			  $_sql_total=null; 
			  $_sql= 'SELECT *  FROM YIS.APP_HISTORY WHERE `address_id`='.$_id.' order by `data_in` DESC'; 
//print($_sql);
		    break;
		     case "Appartment":
			  $_sql_total=null; 
	 $_sql= 'SELECT t1.*,t1.`fio` as owner,(CASE WHEN t1.`lgotchik` > 0 THEN 1 ELSE 0 END ) as lgota FROM YIS.APPARTMENT as t1 WHERE t1.`address_id`='.$_id.' order by t1.`data_in` limit 1'; 
//print($_sql);  
//print($_sql);  
		 break;
		    case "Lgotnik"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$_id.''; 
			   $_sql='SELECT * , CONCAT(YIS.LGOTAMEN.`surname`,\' \', SUBSTRING(YIS.LGOTAMEN.`firstname`,1,1),\'.\',SUBSTRING(YIS.LGOTAMEN.`lastname`,1,1),\'.\') as fio  FROM YIS.LGOTAMEN WHERE  YIS.LGOTAMEN.address_id='.$_id.' AND YIS.LGOTAMEN.vkl = "да"';
			break;
		  case "Famaly"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$_id.''; 
			   $_sql='SELECT t1.*  FROM YISGRAND.FAMALY as t1 WHERE  t1.address_id='.$_id.' AND t1.vkl = "да" order by t1.`rodstvo`';
			   			   	//print($_sql);  

			break;
			case "HistoryFamaly"://применяется
			   $_sql='SELECT *  FROM YISGRAND.FAMALY WHERE  YISGRAND.FAMALY.address_id='.$_id.'';
		    break;  
		     case "Owner"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$_id.''; 
			   $_sql='SELECT t1.*  FROM YISGRAND.REESTR_OWNER as t1 WHERE  t1.address_id='.$_id.' AND t1.vkl = "да" order by t1.`rodstvo`';
			   			   	//print($_sql);  

			break;
			case "HistoryOwner"://применяется
			   $_sql='SELECT t1.*  FROM YISGRAND.REESTR_OWNER as t1 WHERE  t1.address_id='.$_id.'';
		    break;  
		   case "getDogovorVik"://применяется
			   $_sql='SELECT * FROM YIS.DOGOVOR_VIK WHERE  YIS.DOGOVOR_VIK.address_id='.$this->address_id.' ';
			   	//print($_sql);  

			break;
			   case "getDogovorYtke"://применяется
			   $_sql='SELECT * FROM YIS.DOGOVOR_YTKE WHERE  YIS.DOGOVOR_YTKE.address_id='.$this->address_id.' ';
			   	//print($_sql);  

			break;
	    case "HistoryLgotnik"://применяется
			   $_sql='SELECT * , CONCAT(YIS.LGOTAMEN.`surname`,\' \', SUBSTRING(YIS.LGOTAMEN.`firstname`,1,1),\'.\',SUBSTRING(YIS.LGOTAMEN.`lastname`,1,1),\'.\') as fio FROM YIS.LGOTAMEN WHERE  YIS.LGOTAMEN.address_id='.$_id.'';
		    break;
		  
		
		 case "TabHouseResidents":
			$_sql= 'SELECT t1.* , cast(t2.`appartment` as unsigned) as  app FROM YIS.APPARTMENT as t1 LEFT JOIN YIS.ADDRESS as t2 USING(`address_id`)  WHERE t1.`house_id`='.$_id.' order by app' ; 
//print($_sql);  
		 break;

		} // End of Switch ($what)
		
	
		if($_db){
		

		$_result = $_db->query($_sql) or die('Connect Error in '. $_what .'  (    ' .  $_sql . '    ) ' . $_db->connect_error);

		$_array=array();
		while ($row = $_result->fetch_assoc()) {
			array_push($_array, $row);
		}
		$results = array();
		$results['success']= true;


		//if ($results['total']	= $_total;
		$results['total']= null;
		/*if(isset($results['total') && ($results['total')) {
		 $results['total' = $results['total';
		} else {
		   $results['total'= null;
		}*/


		$results['data']= $_array;
		}else{
		 $results['success']= false;
		}
		return $results;
	}
	public function updateRecords(stdClass $params)      // ================================= UPDATE RECORDS
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
		//$this->recs=implode(',',$params->rec);
		//$this->recs=implode('":"',$this->rec);

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
		
				//print($this->recs);

		switch ($this->what) {
	   
	case "AppartmentUpdateBti":
		 $this->sql='CALL YISGRAND.AppartmentUpdateBti("'
		.$this->address_id.'","'
		.$this->house_id.'","'
		.$this->tenant.'","'
		.$this->absent.'","'
		.$this->podnan.'","'		
		.$this->nanim.'", "'
		.$this->owner.'", "'
		.$this->inn.'", "'
		.$this->passport.'", "'
		.$this->vidan.'", "'
		.$this->viddata.'", "'
		.$this->privat.'", "'
		.$this->order.'", "'
		.$this->data_ordera.'","'
		.$this->what_change.'", "'
		.$this->data_change.'", "'
		.$this->info.'", "'
		.$this->phone.'", "'
		.$this->email.'","'
		.$this->chdata.'",'
		.' @success, @msg)';
			 // print($this->sql);
	break;
	case "AppartmentUpdate":
		 $this->sql='CALL YISGRAND.AppartmentUpdate("'
		.$this->address_id.'","'
		.$this->tenant.'","'
		.$this->absent.'","'
		.$this->podnan.'","'
		.$this->area_balk.'","'
		.$this->area_dop.'","'
		.$this->area_full.'","'
		.$this->area_life.'","'
		.$this->room.'","'
		.$this->lift.'","'		
		.$this->kvartplata.'", '		
		.' @success, @msg)';
			 // print($this->sql);
	break;
 case "AppartmentChangeBti":
		 $this->sql='CALL YISGRAND.AppartmentChangeBti("'
		.$this->address_id.'","'
		.$this->house_id.'","'		
		.$this->tenant.'","'
		.$this->absent.'","'
		.$this->podnan.'","'
		.$this->nanim.'", "'
		.$this->owner.'", "'
		.$this->inn.'", "'
		.$this->passport.'", "'
		.$this->vidan.'", "'
		.$this->viddata.'", "'
		.$this->privat.'", "'
		.$this->order.'", "'
		.$this->data_ordera.'","'
		.$this->what_change.'", "'
		.$this->data_change.'", "'
		.$this->info.'", "'
		.$this->phone.'","'
		.$this->email.'","'
		.$this->operator.'","'
		.$this->chdata.'", '
		.' @success, @msg)';
			// print($this->sql);
		break;
			case "AppKvartplataIns":
				 $this->sql='UPDATE YIS.KVARTPLATA as t1 SET '
				.'t1.zadol="'.$this->zadol.'",'
				.'t1.rzadol="'.$this->rzadol.'",'
				.'t1.dzadol="'.$this->dzadol.'",'
				.'t1.fzadol="'.$this->fzadol.'",'
				.'t1.square="'.$this->square.'",'
				.'t1.kvartplata="'.$this->kvartplata.'",'
				.'t1.dop="'.$this->dop.'",'
				.'t1.remont="'.$this->remont.'",'
				.'t1.tarif="'.$this->tarif.'",'
				.'t1.perer="'.$this->perer.'",'
				.'t1.nachisleno="'.$this->nachisleno.'",'
				.'t1.square_lg="'.$this->square_lg.'",'
				.'t1.budjet="'.$this->budjet.'",'
				.'t1.pbudjet="'.$this->pbudjet.'",'
				.'t1.subsidia="'.$this->subsidia.'",'
				.'t1.lg="'.$this->lg.'",'				
				.'t1.foplacheno="'.$this->foplacheno.'",'
				.'t1.doplacheno="'.$this->doplacheno.'",'
				.'t1.roplacheno="'.$this->roplacheno.'",'
				.'t1.oplacheno="'.$this->oplacheno.'",'
				.'t1.rdolg="'.$this->rdolg.'",'
				.'t1.ddolg="'.$this->ddolg.'",'
				.'t1.fdolg="'.$this->fdolg.'",'
				.'t1.dolg="'.$this->dolg.'",'
				.'t1.info="'.$this->info.'",'
				.'t1.operator="'.$this->login.'",'
				.'t1.data_in= CURDATE() '
				.' WHERE t1.address_id='.$this->address_id.' AND '
				.' t1.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
			
			
			case "addLgotaKvartplata":
			      $this->sql='CALL YISGRAND.addLgotaKvartplata('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
										      .$this->address.'","'
										      .$this->fio.'","'
										      .$this->lgota.'","'
										      .$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->chekInput.'","'
										      .$this->checkType.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
			
			case "addLgotaPererKvartplata":
			      $this->sql='CALL YISGRAND.addLgotaPererKvartplata('
										      .$this->lgotnik_id.','
										      .$this->lgota_id.','
										      .$this->house_id.','
										      .$this->address_id.',"'
													.$this->address.'","'
										      .$this->fio.'","'
													.$this->lgota.'","'
													.$this->percent.'","'
										      .$this->inn.'","'
										      .$this->people.'","'
										      .$this->category.'","'
										      .$this->pok_id.'","'
										      .$this->gr.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	
	case "editLgotaKvartplata":
			      $this->sql='CALL YISGRAND.editLgotaKvartplata('
										      .$this->rec_id.','
										      .$this->address_id.',"'
										      .$this->people.'","'
										      .$this->qty.'","'
										      .$this->tarif.'","'
										      .$this->data.'","'
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->summa.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
			break;
	
		case "addLgotnik":
			      $this->sql='CALL YISGRAND.addLgotnik("'
										      .$this->lgota_id.'","'
										      .$this->address_id.'","'
										      .$this->address.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->surname_ua.'","'
										      .$this->firstname_ua.'","'
										      .$this->lastname_ua.'","'
										      .$this->kartochka.'","'
										      .$this->inn.'","'
										      .$this->passport.'","'
										      .$this->document.'","'
										      .$this->data.'","'
										      .$this->start.'","'
										      .$this->finish.'","'
										      .$this->given.'","'
										      .$this->people.'","'
										      .$this->percent.'","'
										      .$this->vkl.'",'
										      .'@success,@msg)';
			break;
				
			case "editLgotnik":
			      $this->sql='CALL YISGRAND.editLgotnik("'
										      .$this->lgotnik_id.'","'
										      .$this->lgota_id.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->surname_ua.'","'
										      .$this->firstname_ua.'","'
										      .$this->lastname_ua.'","'
										      .$this->kartochka.'","'
										      .$this->inn.'","'
										      .$this->passport.'","'
										      .$this->document.'","'
										      .$this->data.'","'
										      .$this->start.'","'
										      .$this->finish.'","'
										      .$this->given.'","'
										      .$this->people.'","'
										      .$this->percent.'","'
										      .$this->vkl.'",'
										      .'@success,@msg)';
										      			 //  print_r($this->sql); 

			break;
			case "editCitizen":
			      $this->sql='CALL YISGRAND.editCitizen("'
										      .$this->rec_id.'","'
										      .$this->address_id.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->born.'","'
										      .$this->datap.'","'
										      .$this->inn.'","'
										      .$this->subsidia.'","'
										      .$this->document.'","'
										      .$this->datapasp.'","'
										      .$this->seria.'","'
										      .$this->nomer.'","'
										      .$this->organ.'","'
										      .$this->rodstvo.'","'
										      .$this->vkl.'","'
										      .$this->absent.'",'
										      .'@success,@msg)';
										      			 //  print_r($this->sql); 

			break;
			case "editOwner":
			      $this->sql='CALL YISGRAND.editOwner("'
										      .$this->rec_id.'","'
										      .$this->address_id.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->datap.'","'
										      .$this->datav.'","'
										      .$this->inn.'","'
										      .$this->square.'","'
										      .$this->document.'","'
										      .$this->phone.'","'
										      .$this->seria.'","'
										      .$this->nomer.'","'
										      .$this->part.'","'
										      .$this->rodstvo.'","'
										      .$this->vkl.'",'
										      .'@success,@msg)';
										      			 //  print_r($this->sql); 

			break;
			case "addCitizen":
			      $this->sql='CALL YISGRAND.addCitizen("'
										      .$this->address_id.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->born.'","'					      										      .$this->datap.'","'
										      .$this->inn.'","'
										      .$this->subsidia.'","'
										      .$this->document.'","'
										      .$this->datapasp.'","'
										      .$this->seria.'","'
										      .$this->nomer.'","'
										      .$this->organ.'","'					      										      .$this->rodstvo.'","'
										      .$this->vkl.'","'
										      .$this->absent.'",'
										      .'@success,@msg)';
										      			 //  print_r($this->sql); 

			break;
			case "addOwner":
			      $this->sql='CALL YISGRAND.addOwner("'
										      .$this->rec_id.'","'
										      .$this->address_id.'","'
										      .$this->surname.'","'
										      .$this->firstname.'","'
										      .$this->lastname.'","'
										      .$this->datap.'","'					      										      .$this->datav.'","'
										      .$this->inn.'","'
										      .$this->square.'","'
										      .$this->document.'","'
										      .$this->phone.'","'
										      .$this->seria.'","'
										      .$this->nomer.'","'
										      .$this->part.'","'
										      .$this->rodstvo.'",'
										      .'@success,@msg)';
										      			 //  print_r($this->sql); 

			break;
			case "editOsmd":
			      $this->sql='CALL YISGRAND.editOsmd("'
										      .$this->osmd_id.'","'
										      .$this->osmd.'","'
										      .$this->fname.'","'
										      .$this->faddress.'","'
										      .$this->uaddress.'","'
										      .$this->bank.'","'
										      .$this->edrpou.'","'			      										      .$this->account.'","'			      										            .$this->daccount.'","'
										      .$this->boss.'","'
										      .$this->glavbuh.'","'
										      .$this->buh.'","'
										      .$this->vosobi.'","'
										      .$this->kassa.'","'
										      .$this->phone.'","'
										      .$this->mfo.'","'
										      .$this->ipay.'","'
										      .$this->pb.'",'
										      .'@success,@msg)';
										      			 //  print_r($this->sql); 

			break;
			case "editOplataApp":
		  $this->sql='CALL YISGRAND.editOplataApp('
		  .$this->rec_id.','
		  .$this->address_id.',"'
		  .$this->kvartplata.'","'
		  .$this->remont.'","'
		  .$this->otoplenie.'","'
		  .$this->ptn.'","'
		  .$this->podogrev.'","'
		  .$this->voda.'","'.
		  $this->stoki.'","'
		  .$this->tbo.'","'
		  .$this->summa.'","'
		  .$this->god.'","'
		  .$this->prixod.'","'
		  .$this->kassa.'","'
		  .$this->data.'","'
		  .$this->pr.'","'
		  .$this->nomer.'","'
		  .$this->data_in.'",@success,@msg)';
//print($this->sql);
			break;
			case "editDbfLgota":
			      $this->sql='CALL YISGRAND.editDbfLgotaOsmd('.$this->rec_id.',"'.$this->lgotnik_id.'","'.$this->data.'","'.$this->monthin.'","'.$this->yearin.'","'.$this->data1.'","'.$this->data2.'","'.$this->lgcode.'","'.$this->flag.'","'.$this->summ.'","'.$this->fact.'","'.$this->tarif.'",@success,@msg)';
//print($this->sql);
			break;
			case "input_oplata_privatbank":
			      $this->sql='CALL YISGRAND.input_oplata_privatbank('.$this->osmd_id.',@success,@msg)';
			break;
			case "addDbfLgota":
			      $this->sql='CALL YISGRAND.addDbfLgotaOsmd("'.$this->lgotnik_id.'","'.$this->data.'","'.$this->monthin.'","'.$this->yearin.'","'.$this->data1.'","'.$this->data2.'","'.$this->lgcode.'","'.$this->flag.'","'.$this->summ.'","'.$this->fact.'","'.$this->tarif.'",@success,@msg)';
//print($this->sql);
			break;
			case "AddAddressNachislKvartplata":			
			    $this->sql='CALL YISGRAND.AddAddressNachisl("kvartplata",'.$this->address_id.','.'@success,@msg)';
			break;
			case "delLgotaKvartplata":
			      $this->sql='CALL YISGRAND.delLgotaKvartplata('.$this->rec_id.',@success,@msg)';
			break;
   			case "delLgotaKvartplataPerer":
			      $this->sql='CALL YISGRAND.delLgotaKvartplataPerer('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaKvartplataPerer":
			      $this->sql='CALL YISGRAND.delLgotaKvartplataPerer('.$this->rec_id.',@success,@msg)';
			break;
   			case "delDbfLgota":
			      $this->sql='CALL YISGRAND.delDbfLgotaOsmd('.$this->rec_id.',@success,@msg)';
			break;
			case "delLgotaUtszn":
			      $this->sql='CALL YISGRAND.delLgotaUtszn_kv('.$this->rec_id.',@success,@msg)';
			break;	
			case "delSubsidiaUtszn":
			      $this->sql='CALL YISGRAND.delSubsidiaUtszn_kv('.$this->rec_id.',@success,@msg)';
			break;	
			//print($this->sql);
			case "update_fio_lgota":
			      $this->sql='CALL YISGRAND.update_fio_lgota('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			  break;
			case "update_vozvrat_subsidia":
			      $this->sql='CALL YISGRAND.update_vozvrat_subsidia_kv('.$this->osmd_id.',"'.$this->sdate.'","'.$this->fdate.'",@success,@msg)';
			      //print_r($this->sql); 
			      break;
			 case "insOplataSubsidiaVozvrat":
		        	    $this->sql='CALL YISGRAND.VozvratSubsidiaOplata_kv('.$this->osmd_id.',@success,@msg)';
		         break;
		case "update_fio_subsidia":
			      $this->sql='CALL YISGRAND.update_fio_subsidiaOsmd("'.$this->data.'",@success,@msg)';
			      			 // print_r($this->sql); 
			      			 break;
		 case "update_lgota_from_utszn":
			      $this->sql='CALL YISGRAND.update_lgota_from_utszn(@success,@msg)';
			      			// print_r($this->sql); 
			      			 break;
		case "insert_lgota_from_utszn":
			      $this->sql='CALL YISGRAND.insert_lgota_from_utszn(@success,@msg)';
			      			 // print_r($this->sql); 
			      			 break;
		case "update_utszn_subsidia":
			      $this->sql='CALL YISGRAND.update_utszn_subsidia_kv( "'.$this->osmd_id.'", "'.$this->data.'",@success,@msg)';
			      			 //print_r($this->sql); 
			      			 break;
		case "update_utszn_lgota":
			      $this->sql='CALL YISGRAND.update_utszn_lgota_kv( "'.$this->osmd_id.'","'.$this->data.'",@success,@msg)';
			      			 //print_r($this->sql); 
			      			 break;
		case "editSubsidiaUtszn":
			 $this->sql='CALL YISGRAND.editSubsidiaUtszn_kv('.$this->rec_id.',"'.$this->data.'","'.$this->inn.'","'.$this->st.'","'.$this->zadol.'","'.$this->nachisleno.'","'.$this->perer.'","'.$this->norma.'",' .'"'.$this->oplata.'","'.$this->poplata.'","'.$this->doplata.'","'.$this->dolg.'","'.$this->fin.'",@success,@msg)';
			break;
		case "editLgotaUtszn":
			       $this->sql='CALL YISGRAND.editLgotaUtszn_kv('.$this->rec_id.',"'.$this->data.'","'.$this->inn.'","'.$this->st.'","'.$this->zadol.'","'.$this->nachisleno.'","'.$this->perer.'","'.$this->norma.'",'
			       .'"'.$this->oplata.'","'.$this->poplata.'","'.$this->doplata.'","'.$this->dolg.'","'.$this->fin.'",@success,@msg)';
			break;
		case "insOplatalgotaUtszn_kv":
			      $this->sql='CALL YISGRAND.insOplatalgotaUtszn_kv("'.$this->osmd_id.'","'.$this->data.'","'.$this->oplata.'","'.$this->pr.'",@success,@msg)';
		//print($this->sql);	
	
			break;
		case "insOplataSubsidiaUtszn_kv":
			      $this->sql='CALL YISGRAND.insOplataSubsidiaUtszn_kv("'.$this->osmd_id.'","'.$this->data.'","'.$this->oplata.'","'.$this->pr.'",@success,@msg)';
			break;
		

		
		
		case "input_subsidia":
			      $this->sql='CALL YISGRAND.input_subsidOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;
		case "input_lgota":
			      $this->sql='CALL YISGRAND.input_lgotaOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;
		case "control_subsidiaOsmd":
			      $this->sql='CALL YISGRAND.control_subsidiaOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;
		case "importOshadBank"://применяется
			      $this->sql='CALL YISGRAND.subsidia_import_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;	
		case "importOshadBankLgota"://применяется
			      $this->sql='CALL YISGRAND.lgota_import_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;
		case "input_subsidia_oshadbank"://применяется
			      $this->sql='CALL YISGRAND.subsidia_oplata_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';				  	
			break;	
		case "input_lgota_oshadbank"://применяется
			      $this->sql='CALL YISGRAND.lgota_oplata_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';				  	
			break;	
		case "otkat_oplata_subsidia_oshad"://применяется 
			      $this->sql='CALL YISGRAND.subsidia_oplata_otkat_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';				  	
			break;	
		case "otkat_oplata_lgota_oshad"://применяется 
			      $this->sql='CALL YISGRAND.lgota_oplata_otkat_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';				  	
			break;	
		case "otkat_oplata_subsidiaOsmd":
			      $this->sql='CALL YISGRAND.otkat_oplata_subsidiaOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;
			case "otkat_oplata_lgotaOsmd":
			      $this->sql='CALL YISGRAND.otkat_oplata_lgotaOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			break;
		case "nachislenie_kvartplata_now":
			       $this->sql='CALL YISGRAND.nachislenie_kvartplata_osmd_now("'.$this->house_id.'",@success,@msg)';		
			    // print($this->sql);	
			      $this->results['res'] = 1;
			break;
		case "nachislenie_kvartplata_prev":
			       $this->sql='CALL YISGRAND.nachislenie_kvartplata_osmd_prev("'.$this->house_id.'",@success,@msg)';		
			    // print($this->sql);	
			      $this->results['res'] = 1;

		break;
		case "vvod_tarif_kv":
			       $this->sql='UPDATE YISGRAND.TARIF as t1  SET t1.'.$this->name_tar.' = '.$this->new_tar.' WHERE t1.`house_id` = '.$this->house_id.' AND t1.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
			       $this->results['res'] = 1;
			       break;
		case "clear_pr_kv":
			      $this->sql='UPDATE YISGRAND.TARIF as t1 SET t1.`pr` = 0 WHERE t1.`house_id` = '.$this->house_id.' AND t1.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")';
									    //  print_r($this->sql); 

						$this->results['res'] = 1;	
		break;
		case "AktLgotaUtsznAll":
		$this->sql='INSERT INTO YISGRAND.TMP_TABLE SET YISGRAND.TMP_TABLE.`rec_id` = '.$this->rec_id.'';
		$this->results['res'] = 1;	
		break;
		case "ReestrSubsidiaUtsznAll":
		$this->sql='INSERT INTO YISGRAND.TMP_TABLE SET YISGRAND.TMP_TABLE.`rec_id` = '.$this->rec_id.'';
		$this->results['res'] = 1;	
		break;
		case "ReestrLgotaUtsznAll":
		$this->sql='INSERT INTO YISGRAND.TMP_TABLE SET YISGRAND.TMP_TABLE.`rec_id` = '.$this->rec_id.'';
		$this->results['res'] = 1;	
		break;
		case "PrintForma3Utszn":		
		$this->sql='INSERT INTO YISGRAND.TMP_TABLE SET YISGRAND.TMP_TABLE.`rec_id` = '.$this->rec_id.'';
		$this->results['res'] = 1;	
		break;
		case "PrintAktSubsidiaOsmd":
		
		 $this->sql='INSERT INTO YISGRAND.TMP_TABLE SET YISGRAND.TMP_TABLE.`rec_id` = '.$this->address_id.'';
		$this->results['res'] = 1;	
		break;
		case "exportOshadBank"://применяется
		$this->sql='CALL YISGRAND.subsidia_export_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
		break;	
		case "exportOshadBankLgota"://применяется
		$this->sql='CALL YISGRAND.lgota_export_kvartplata('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
		break;	
			case "pereraschet_kvartplata":
			      $this->sql='CALL YISGRAND.pereraschet_kvartplata_osmd("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->tarif_manual.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'							    								      
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->kv9.'","'
										      .$this->ch_kv9.'","'
										      .$this->kv9f1.'","'
										      .$this->ch_kv9f1.'","'
										      .$this->kv16.'","'
										      .$this->ch_kv16.'","'
										      .$this->kv16f1.'","'
										      .$this->ch_kv16f1.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
										      			   //  print($this->sql);	


			break;
			case "nachislenie_dop_osmd":
			      $this->sql='CALL YISGRAND.nachislenie_dop_osmd("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'							    								      
										      .$this->sdata.'","'
										      .$this->fdata.'","'					     										      .$this->info.'",'
										      .'@success,@msg)';
										      			   //  print($this->sql);	


			break;
			case "nachislenie_remont_osmd":
			      $this->sql='CALL YISGRAND.nachislenie_remont_osmd("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'							    								      
										      .$this->sdata.'","'
										      .$this->fdata.'","'					     										      .$this->info.'",'
										      .'@success,@msg)';
										      			   //  print($this->sql);	


			break;
		case "pereraschet_nachislenie_kvartplata":
			      $this->sql='CALL YISGRAND.pereraschet_nahcislenie_osmd("'
										      .$this->house_id.'","'
										      .$this->allkv.'","'
										      .$this->tarif_manual.'","'
										      .$this->address_ot.'","'
										      .$this->address_do.'","'							    								      
										      .$this->sdata.'","'
										      .$this->fdata.'","'
										      .$this->kv9.'","'
										      .$this->ch_kv9.'","'
										      .$this->kv9f1.'","'
										      .$this->ch_kv9f1.'","'
										      .$this->kv16.'","'
										      .$this->ch_kv16.'","'
										      .$this->kv16f1.'","'
										      .$this->ch_kv16f1.'","'
										      .$this->info.'",'
										      .'@success,@msg)';
										      			//     print($this->sql);	


			break;
	

	      case "ExportBudjetEmail":
			      $this->sql='CALL YISGRAND.ExportBudjetEmailOsmd('.$this->osmd_id.',"'.$this->data.'",@success,@msg)';
			    //print_r($this->sql); 

			break;
			case "EmailInfoApp":
			      $this->sql='CALL YISGRAND.EmailInfoApp("'.$this->osmd_id.'",@success)';
		      break;

		} // End of Switch ($what)  

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ('.$this->sql.') ' . $_db->connect_errno);
		
		$this->sql_callback='SELECT @new_id,@new_name,@success, @msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error >>>  ' . $_db->connect_errno . '  <<< ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg'] = $this->row['@msg'];
			$this->results['new_id'] = $this->row['@new_id'];
			$this->results['new_name'] = $this->row['@new_name'];
		}
		
		return $this->results;

	} // ================================= UPDATE RECORDS


	}