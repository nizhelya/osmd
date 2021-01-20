<?php
include_once './yis_config.php';

class QueryLoad
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $what_id;
	protected $what;
	protected $nomer;
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $kub;
	protected $data=NULL;
	protected $res=array();	
	protected $base = BASE;
	protected $raion_id = RAION;
	protected $street_id = STREET;
	protected $house_id = HOUSE;
	protected $osmd_id = OSMD;

	public	  $results=array();
	

	public function connect()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YISGRAND');
		if ($_db->connect_error) {
			return false;
		} else {		
		$_db->set_charset("utf8");    
		return $_db;
		}
	}



	public function getResults(stdClass $params)
	{

				
		$_db = $this->connect();

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$value;}
		  }
		}

		switch ($this->what) {

			
	case "Tarif":
				$this->sql='SELECT * FROM YISGRAND.TARIF ORDER BY YISGRAND.TARIF.`raion`';
					    //print($_sql); 
		break;
		case "TarifFromRaion":
				$this->sql='SELECT * FROM YISGRAND.TARIF as t1 WHERE t1.`raion` ='.$this->raion_id.' ORDER BY t1.`house_id`';
					   // print($_sql); 
		break;
		case "TarifFromHouse":
				$this->sql='SELECT * FROM YISGRAND.TARIF as t1 WHERE t1.`house_id` ='.$this->house_id.' ORDER BY t1.`data` DESC LIMIT 1';
					 //  print($this->sql); 
		break;
		case "TarifFromHouseOsmd":
				$this->sql='SELECT * FROM YISGRAND.TARIF as t1 WHERE t1.`house_id` ='.$this->house_id.' ORDER BY t1.`data` DESC LIMIT 12';
					   // print($_sql); 
		break;
		case "TarifFromHouses":
				$this->sql='SELECT * FROM YISGRAND.TARIF as t1 WHERE t1.`house_id` in( '.$this->house_id.') and  t1.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM CURDATE()),"01")' ;
					 //  print($this->sql); 
		break;
		case "TarifFromHouseAll":
				$this->sql='SELECT * FROM YISGRAND.TARIF as t1 WHERE t1.`house_id` ='.$this->house_id.' ORDER BY t1.`data` DESC';
					   // print($_sql); 
		break;
		 case "kvartira":
			 
			    $this->sql='SELECT raion_id,street_id,osmd_id,house_id,address_id,house,raion,house,street,address,appartment,address as item,cast(appartment as unsigned) as app FROM YIS.ADDRESS WHERE house_id='.$this->house_id.' ORDER BY app';
			 					   // print( $this->sql); 

		break;
		case "raion":
				$this->sql='SELECT * FROM YIS.RAION WHERE raion_id NOT IN(5,8,9,10) ';
					    //print($_sql); 
		break;
		/*
		case "street":
				$this->sql='SELECT * FROM YIS.STREET WHERE YIS.STREET.`street_id` = '.$this->street_id.'';
			    
		break;
		*/
		case "osmd":
				$this->sql='SELECT t1.osmd_id as org_id,t1.* FROM YISGRAND.OSMD as t1 WHERE t1.`osmd_id`  in('.$this->osmd_id.')';
					  // print($this->sql); 
		break;
		case "house":
				$this->sql='SELECT * FROM YIS.HOUSE as t1 WHERE t1.`house_id`  in('.$this->house_id.')';
					  //  print($this->sql); 
		break;

		case "getHousesOsmd":
				$this->sql='SELECT * FROM YIS.HOUSE as t1 WHERE t1.`osmd_id` ='.$this->osmd_id.'';
					  //  print($this->sql); 
		break;
		case "getOsmd":
				$this->sql='SELECT t1.`osmd_id`,t1.`osmd`,t1.`edrpou` FROM YISGRAND.OSMD as t1 WHERE t1.`osmd_id`  in('.$this->osmd_id.')' ;
					 //  print($_sql);
		break;
		case "Prixod":			
			      $this->sql='SELECT * FROM YIS.PRIXOD WHERE  1' ;
			    
		break;
		case "StreetsFromRaion":
				if ($this->what_id==0) {
				    $this->sql='SELECT * FROM YIS.STREET ORDER BY street';
				} else {
				    $this->sql='SELECT YIS.STREET.street_id,'
						.'YIS.STREET.street '
						.' FROM YIS.STREET,YIS.HOUSE '
						.' WHERE YIS.STREET.street_id=YIS.HOUSE.street_id '
						.' AND YIS.HOUSE.raion_id='.$this->raion_id.''
						.' GROUP BY YIS.STREET.street_id '
						.' ORDER BY YIS.STREET.street';
				}
				  // print($this->sql);

		break;
		case "HousesFromRaion":
				$this->sql='SELECT raion_id,street_id,house_id,raion,house,house as item FROM YIS.HOUSE WHERE raion_id='.$this->raion_id.' ORDER BY house';
			    
		break;
		case "HousesFromStreet":
				if ($this->what_id == 0) { 
				    $this->sql='SELECT * FROM YIS.HOUSE ORDER BY house ';
				} else {
				    $this->sql='SELECT * FROM YIS.HOUSE WHERE street_id= '.$this->street_id.'';
				}  
				  // print($this->sql);
		break;
		case "AddressFromHouses":
				 $this->sql='SELECT `address_id`, `address`,cast(appartment as unsigned) as app '
						 . 'FROM YIS.ADDRESS '
						 .' WHERE YIS.ADDRESS.`house_id` in('.$this->house_id.') '
						 .' ORDER BY app ';
				//print($this->sql);
			 
		    break;
	case "AddressFromHousesTarif":
			 
					$this->sql='SELECT * FROM YIS.APPARTMENT as t1 WHERE t1.`house_id` = '.$this->what_id.'';
			   //print($this->sql);
			  
		    break;
		


			

		} // End of Switch ($what)
		
	
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);

//		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}


/*	public function __destruct()
	{
		$_db = $this->connect($this->login,$this->password);
		$_db->close();
		
		return $this;
	}*/
}