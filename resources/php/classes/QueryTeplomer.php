<?php
include_once './yis_config.php';

class QueryTeplomer
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $teplomer_id;
	protected $dteplomer_id;
	protected $pok_id;
	protected $address_id;
	protected $what;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
		
	public function __construct()
	{
		//                 'hostname', 'username' ,'password', 'database'
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');
		
		if ($_db->connect_error) {
			die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		}
		$_db->set_charset("utf8");
    
		return $_db;
	}
	public function getResults(stdClass $params)
{
		$_db = $this->__construct();	

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
	      
		switch ($this->what) {
//   КВАРТИРНЫЙ ТЕПЛОМЕР
			case "TekPokTeplomera":			
			      $this->sql='SELECT '
					.'YIS.TEPLOMER.teplomer_id,'
					.'YIS.TEPLOMER.dteplomer_id,'
					.'YIS.TEPLOMER.address_id,'
					.'YIS.TEPLOMER.house_id,'					
					.'YIS.TEPLOMER.nomer,'
					.'YIS.TEPLOMER.model_id,'
					.'YIS.TEPLOMER.model,'
					.'YIS.TEPLOMER.edizm,'
					.'YIS.TEPLOMER.out,'
					.'YIS.PTEPLOMER.pok_id,'
					.'YIS.PTEPLOMER.data,'
					.'YIS.TEPLOMER.sdate,'
					.'YIS.TEPLOMER.pdate,'
					.'YIS.PTEPLOMER.data as fdate,'
					.'YIS.PTEPLOMER.pred,'
					.'YIS.PTEPLOMER.tek as tekp,'
					.'YIS.PTEPLOMER.tek,'
					.'YIS.PTEPLOMER.qty,'
					.'YIS.PTEPLOMER.koef,'
					.'YIS.PTEPLOMER.gkal,'
					.'YIS.PTEPLOMER.tarif,'
					.'YIS.PTEPLOMER.area,'
					.'YIS.PTEPLOMER.area_lg,'
					.'YIS.PTEPLOMER.gkm2,'
					.'YIS.PTEPLOMER.otoplenie,'
					.'YIS.PTEPLOMER.budjet,'
					.'YIS.PTEPLOMER.operator '
					.' FROM YIS.TEPLOMER ,YIS.PTEPLOMER '
					.' WHERE YIS.TEPLOMER.teplomer_id='.$this->teplomer_id.''					
					.' AND YIS.PTEPLOMER.teplomer_id='.$this->teplomer_id.' '
					.' ORDER BY YIS.PTEPLOMER.data_in DESC limit 1 ';
					//print($this->sql);
			break;
			case "AllPokTeplomera":			
				 $this->sql='SELECT * FROM YIS.PTEPLOMER '		
					.' WHERE YIS.PTEPLOMER.teplomer_id='.$this->teplomer_id.''
					.' ORDER BY YIS.PTEPLOMER.data_in DESC  ';
			break;
			
			case "AppTeplomer"://применяется
				  $this->sql='SELECT '
					.'YIS.TEPLOMER.address_id,'
					.'YIS.TEPLOMER.teplomer_id,'
					.'YIS.TEPLOMER.dteplomer_id,'
					.'YIS.TEPLOMER.house_id,'
					.'YIS.TEPLOMER.address,'
					.'YIS.TEPLOMER.nomer,'
					.'YIS.TEPLOMER.model_id,'
					.'YIS.TEPLOMER.model,'
					.'YIS.TEPLOMER.koef,'
					.'YIS.TEPLOMER.area,'
					.'YIS.TEPLOMER.edizm, '
					.'YIS.TEPLOMER.sdate,'
					.'YIS.TEPLOMER.pdate,'
					.'YIS.TEPLOMER.note, '
					.'YIS.TEPLOMER.out, '
					.'YIS.TEPLOMER.operator '
					.' FROM YIS.TEPLOMER '
					.' WHERE YIS.TEPLOMER.address_id='.$this->address_id.' '
					.' AND YIS.TEPLOMER.spisan=0 ';
					//print($this->sql); 
			break;
			case "AppHTeplomer"://применяется
				  $this->sql='SELECT '
					.'YIS.TEPLOMER.address_id,'
					.'YIS.TEPLOMER.teplomer_id,'
					.'YIS.TEPLOMER.dteplomer_id,'
					.'YIS.TEPLOMER.house_id,'
					.'YIS.TEPLOMER.address,'
					.'YIS.TEPLOMER.nomer,'
					.'YIS.TEPLOMER.model_id,'
					.'YIS.TEPLOMER.model,'
					.'YIS.TEPLOMER.koef,'
					.'YIS.TEPLOMER.area,'
					.'YIS.TEPLOMER.edizm, '
					.'YIS.TEPLOMER.sdate,'
					.'YIS.TEPLOMER.pdate,'
					.'YIS.TEPLOMER.data_spis as data_spis,'
					.'YIS.TEPLOMER.note, '
					.'YIS.TEPLOMER.out, '
					.'YIS.TEPLOMER.operator '
					.' FROM YIS.TEPLOMER '
					.' WHERE YIS.TEPLOMER.address_id='.$this->address_id.' '
					.' AND YIS.TEPLOMER.spisan=1 ';
					//print($this->sql);
					
			break;	
			case "TekNachAppTeplomera":			  
			   $this->sql='SELECT address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,'
				  .'"Гкал" as edizm,gkal as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg FROM YIS.OTOPLENIE WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ';
			//print($this->sql); 
			break;

		
		} // End of Switch ($what)	
		
//		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ')');

		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}

	
	public function delPokTeplomera(stdClass $params)
	{

	
		$_db = $this->__construct();	

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}

		switch ($this->what) {
			case "ATeplomer":			
			     $this->sql='CALL YISGRAND.delete_pokaz_ateplomera('.$this->pok_id.',@success,@msg)';
		//print($this->sql);
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
	public function newPokTeplomera(stdClass $params)
	{

	
		$_db = $this->__construct();	

		$array = (array) $params;
		foreach ( $array as $key => $value ) 
		  {
		  if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
		  }
		}
		/*NewPokTeplomera*/
		switch ($this->what) {
			case "ATeplomer":			
			    $this->sql='CALL YISGRAND.input_new_pokaz_ateplomera('.$this->address_id.', '.$this->teplomer_id.','.$this->tek.','
									     .$this->newValue.', @success,@msg)';
		//print($this->sql);
			break;
		

		}
		
		//print($this->sql);
//		$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);


		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}
			
		return $this->results;

	}


public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}