<?php

class QueryForm
{
	private $_db;
	protected $res;
	protected $what;
	protected $table;
	protected $sql;
	protected $sql_total;
	protected $id;
	protected $period;
	protected $usluga;
	public $results;
	
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', 'cthubq' ,'hfljyt;crbq', 'YIS');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}
	
	public function getResults($params)
	{

		if(isset($params[0]) && ($params[0])) { //what_id
		  $this->id = (int) $params[0];
		} else {
		  $this->id = 0;
		}
		if(isset($params[1]) && ($params[1])) { //what
		 $this->what = $params[1];
		} else {
		   $this->what = null;
		}
		/*if(isset($params[2]) && ($params[2])) { //period
		  $_year= $params[2];
		} else {
		   $_year= date('Y');
		}
*/
		if(isset($params[2]) && ($params[2])) { //period
		  $this->period= $params[2];
		} else {
		   $this->period== '00000000';
		}

		if(isset($params[3]) && ($params[3])) { //usluga
		      //print_r($params->usluga); 
		      
		      switch($params[3]){
			    case "вода":
			     $this->table='VODA'; 
			    break;
			    case "стоки":
			     $this->table='STOKI'; 
			    break;
			    case "отопление":
			     $this->table='OTOPLENIE'; 
			    break;
			    case "подогрев":
			     $this->table='PODOGREV'; 
			    break;
			    case "квартплата":
			     $this->table='KVARTPLATA'; 
			    break;
			    case "т.б.о.":
			     $this->table='TBO'; 
			    break;
			}
		} else {
		    $this->table=null;
		}
		
/*
		$_id =$params[0];  // get the requested page 
		$_what =  $params[1]; // get how many rows we want to have into the grid 
		//print_r($params);
*/	
//$_id=6314;
//$_table='VODA'; 
//$_what="NachDetail";

		switch ( $this->what) {
   
		  
	case "Appartment":
	      $this->sql= 'SELECT `raion_id`, `address_id`,`address`,`lift`,`fio` as owner ,`order`,DATE_FORMAT(`data`,"%d-%m-%Y") as fdate_order,`privat`,`room`,`area_full`,`area_life`,`area_balk`,`area_dop`, `nanim`,`tenant`,`absent`,`podnan`,`lgotchik`,`lgotchik` as lgota, `vxvoda`,`vgvoda`, `teplomer`,`boiler`,`kvartplata`,`otoplenie`,`podogrev`,`voda`,`stoki`,`tbo`, `subsidia`,aggr_voda,aggr_teplo,aggr_tbo,aggr_kv,`tarif_kv`,`tarif_ot`,`tarif_gv`,`tarif_xv`,`tarif_st`,`tarif_tbo`,`what_change`,DATE_FORMAT(`data_change`,"%d-%m-%Y") as fdate_change FROM APPARTMENT WHERE `address_id`='.$this->id.' order by `data_in` limit 1'; 
			  break;
	case "TekOplata":
			
		$this->sql='SELECT *,DATE_FORMAT(data,"%d-%m-%Y") as fdate FROM OPLATA WHERE `address_id`='.$this->id.' ORDER BY `data` DESC limit 1'; 
			  //  print_r($this->sql); 
					   
		    break;
		        
	case "AppService":
		$this->sql= 'SELECT ADDRESS.address_id,ADDRESS.address,ADDRESS.lift,ADDRESS.room,APP_DEV.vxvoda,APP_DEV.vgvoda,APP_DEV.teplomer,APP_DEV.boiler,APP_SERV.kvartplata,APP_SERV.otoplenie, 							APP_SERV.podogrev,APP_SERV.xvoda,APP_SERV.stoki,APP_SERV.tbo,APP_SERV.subsidia FROM ADDRESS,APP_DEV,APP_SERV WHERE ADDRESS.address_id='.$this->id.'  
			  and APP_DEV.address_id= '.$this->id.' and APP_SERV.address_id= '.$this->id.''; 
			// print($_sql);
			  break;

	case "NachDetail":
			 //print_r($_period); 
	      $this->sql='SELECT * FROM '.$this->table.' WHERE address_id='.$this->id.' and data=DATE_FORMAT("'.$this->period.'","%Y-%m-%d")'; 
					   //  print($_sql);
		    break;

//По огранизациям

	case "CompanyInfo":
			 //print_r($_period); 
			  $_sql_total=null; 
			 $this->sql='SELECT COMPANY_LIST.id_company AS id, COMPANY_LIST.id_parent, COMPANY_LIST.okpo, COMPANY_LIST.inn, COMPANY_LIST.shortname, COMPANY_LIST.fullname, COMPANY_LIST.uaddress AS address, COMPANY_LIST.faddress AS post_addr, COMPANY_LIST.map AS map_file, COMPANY_PAGE.full_description FROM COMPANY_LIST, COMPANY_PAGE WHERE COMPANY_LIST.id_company='.$this->id.' AND COMPANY_PAGE.id_company='.$this->id.' LIMIT 1'; 
					   //  print($_sql);
		    break;

		    } // End of Switch ($what)
		
		$_db = $this->__construct();

		//print_r($_sql);
		$this->res = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		  

		$_array=array();

		

		$results = array();
		$results['success'] = true;
		while ($row = $this->res->fetch_assoc()) {
			$results['data'] = $row;
		}
		//$results['data']	= '3';
		
		return $results;
	}
	
	
	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}