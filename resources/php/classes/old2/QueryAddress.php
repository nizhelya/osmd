<?php

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
			  $_sql='SELECT * FROM YIS.RAION ORDER BY raion';
			   //print($_sql); 
		    break;
		     case "street":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.STREET ';
			    
		    break;
		      case "house":
			  $_sql_total=null; 
			  $_sql='SELECT * FROM YIS.HOUSE';
	      //print($_sql);
			    
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

		    case "HousesFromStreet":
			  $_sql_total=null; 
			  if ($_id == 0) {
			    $_sql='SELECT raion_id,street_id,house_id,house,raion,house,house as item FROM YIS.HOUSE ORDER BY house';
			  }  else if($this->privat) {
			    $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment,address as item,cast(appartment as unsigned) as app FROM YIS.ADDRESS WHERE street_id= '.$_id.' ORDER BY app';
			   } else {
			    $_sql='SELECT raion_id,street_id,house_id,house,raion,house,house as item FROM YIS.HOUSE WHERE street_id= '.$_id.' ORDER BY house';
			  }   
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
			  $_sql='SELECT raion_id,street_id,house_id,address_id,house,raion,house,street,address,appartment FROM YIS.ADDRESS WHERE house_id='.$_id.' AND appartment="'.$this->appartment.'" LIMIT 1';
			 //print($_sql);  
		    break;
		    case "HistoryAppartment":
			  $_sql_total=null; 
			  $_sql= 'SELECT `raion_id`, `address_id`,`address`,`lift`,`fio` as owner ,`order`,DATE_FORMAT(`data`,"%d-%m-%Y") as fdate_order,`privat`,'
				  .'`room`,`area_full`,`area_life`,`area_balk`,`area_dop`, `nanim`,`tenant`,`absent`,`podnan`,`lgotchik`,`lgotchik` as lgota, `vxvoda`,'
				  .'`vgvoda`, `teplomer`,`boiler`,`kvartplata`,`otoplenie`,`podogrev`,`voda`,`stoki`,`tbo`,`subsidia`,aggr_voda,' .'aggr_teplo,aggr_tbo,aggr_kv,`tarif_kv`,`tarif_ot`,`tarif_gv`,`tarif_xv`,`tarif_st`,`tarif_tbo`,'
				  .'`what_change`,DATE_FORMAT(`data_change`,"%d-%m-%Y") as fdate_change FROM YIS.APP_HISTORY WHERE `address_id`='.$_id.' order by `data_in` DESC'; 
//print($_sql);
		    break;
		    case "Appartment":
			  $_sql_total=null; 
			  $_sql= 'SELECT `raion_id`, `address_id`,`address`,`lift`,`fio` as owner ,`order`,DATE_FORMAT(`data`,"%d-%m-%Y") as fdate_order,`privat`,'
				  .'`room`,`area_full`,`area_life`,`area_balk`,`area_dop`, `nanim`,`tenant`,`absent`,`podnan`,`lgotchik`,`lgotchik` as lgota, `vxvoda`,'
				  .'`vgvoda`, `teplomer`,`boiler`,`kvartplata`,`otoplenie`,`podogrev`,`voda`,`stoki`,`tbo`,`subsidia`,aggr_voda,' .'aggr_teplo,aggr_tbo,aggr_kv,`tarif_kv`,`tarif_ot`,`tarif_gv`,`tarif_xv`,`tarif_st`,`tarif_tbo`,'
				  .'`what_change`,DATE_FORMAT(`data_change`,"%d-%m-%Y") as fdate_change FROM YIS.APPARTMENT WHERE `address_id`='.$_id.' order by `data_in` limit 1'; 
//print($_sql);  
		 break;
		    case "Lgotnik"://применяется
			 // $_sql_total='SELECT * FROM VODOMER WHERE address_id='.$_id.''; 
			   $_sql='SELECT YIS.LGOTAMEN.`address_id`, YIS.LGOTAMEN.`address`, YIS.LGOTAMEN.`kartochka`, YIS.LGOTAMEN.`inn`, YIS.LGOTAMEN.`passport`, '
				  .' CONCAT(YIS.LGOTAMEN.`surname`,\' \', SUBSTRING(YIS.LGOTAMEN.`firstname`,1,1),\'.\',SUBSTRING(YIS.LGOTAMEN.`lastname`,1,1),\'.\') as fio, '
				  .' YIS.LGOTAMEN.`surname`, YIS.LGOTAMEN.`firstname`, YIS.LGOTAMEN.`lastname`, YIS.LGOTAMEN.`surname_ua`, YIS.LGOTAMEN.`firstname_ua`, YIS.LGOTAMEN.`lastname_ua`, '
				  .' YIS.LGOTAMEN.`document`, YIS.LGOTAMEN.`lgota`, YIS.LGOTAMEN.`category`, YIS.LGOTAMEN.`people`, YIS.LGOTAMEN.`percent`, YIS.LGOTAMEN.`given`, YIS.LGOTAMEN.`data`, '
				  .' DATE_FORMAT(YIS.LGOTAMEN.data,"%d-%m-%Y") as fdate, YIS.LGOTAMEN.`gr`, YIS.LGOTAMEN.`vkl`, YIS.LGOTAMEN.`raion`, YIS.LGOTAMEN.`operator`, YIS.LGOTAMEN.`data_in` '
				  .' FROM YIS.LGOTAMEN WHERE  YIS.LGOTAMEN.address_id='.$_id.'';
			//print($_sql); 

	 
		    break;
		     case "TekNach":			  
			  $_sql_total='SELECT * FROM YIS.KVARTPLATA  WHERE address_id='.$_id.''; 
			   $_sql='(SELECT 1 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.VODA  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.STOKI  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '
				  .' (SELECT 3 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.PODOGREV  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 4 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN gkal=0 THEN "м2" ELSE "Гкал" END as edizm,CASE WHEN gkal=0 THEN square ELSE gkal END as qty,CASE WHEN gkal=0 THEN tarif ELSE tarif_gkal END as tarif,'
				  .'nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg '
				   .'FROM YIS.OTOPLENIE  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 5 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,"м2" as edizm,square as qty,tarif,'
				   .'nachisleno-perer-raznoe as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.KVARTPLATA  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 6 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'"чел" as edizm,people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.TBO  WHERE address_id='.$_id.' ORDER BY data DESC LIMIT 1 )  ORDER BY data DESC ,p';
//print($_sql);
		    break;
		       case "YearNachisleno":
			  $_sql_total=null; 
			  $_sql='SELECT god FROM YIS.VODA    GROUP BY god DESC'; 
					    
		    break;
		       case "NachDetail":
			 //print_r($_period); 
			  $_sql_total=null; 
			  $_sql='SELECT * FROM '.$_table.' WHERE address_id='.$_id.' and data=DATE_FORMAT("'.$_period.'","%Y-%m-%d")'; 
				//	      print($_sql);
		    break;

		} // End of Switch ($what)
		
	
		  $_db = $this->connect($this->login,  $this->password);
		if($_db){
		

		$_result = $_db->query($_sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

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
	
	
	}