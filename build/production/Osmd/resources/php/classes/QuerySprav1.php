<?php
include_once './yis_config.php';

class QuerySprav
{
	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $sql_total;
	protected $total;
	protected $key;
	protected $count;
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


	public function getResults(stdClass $params)  // ================================= GET RESULTS
	{
		$_db = $this->__construct();

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
			case "kvartplata1"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_KVARTPLATA1 ';
			break;	
			case "kvartplata3"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_KVARTPLATA3   ';
			break;
			case "kvartplata4"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_KVARTPLATA4   ';
			break;
			case "podogrev"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_PODOGREV  ';
			break;
			case "otoplenie"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_OTOPLENIE  ';
			break;
			case "voda"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_VODA  ';
			break;
			case "tbo"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.DBF_TBO  ';
			break;
			case "port"://применяется
				  $this->sql='SELECT *  FROM YIS.PORT';
			break;
			case "subsidia"://применяется
				  $this->sql='SELECT *  FROM YIS.SUBSID';
			break;
			case "getPrixod"://применяется
				  $this->sql='SELECT *  FROM YIS.PRIXOD ORDER BY YIS.PRIXOD.`prixod` ';
			break;	
			case "getVmodel"://применяется
				  $this->sql='SELECT *  FROM YIS.VMODEL ORDER BY YIS.VMODEL.`model` ';
			break;	
			case "getTmodel"://применяется
				  $this->sql='SELECT *  FROM YIS.TMODEL ORDER BY YIS.TMODEL.`model` ';			
			break;
			case "getCatSobstv"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.SPR_SOBSTV ORDER BY YISGRAND.SPR_SOBSTV.`name`';			
			break;
			case "getObjNrv"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.SPR_TYPES ORDER BY `type_id` DESC';			
			break;	

			case "getTypeHot"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.SPR_TYPESH ORDER BY `name` ';
			
			break;
			case "getGrafikWorkDays":			
			      $this->sql='SELECT * FROM YISGRAND.SPR_GRAFIK  ORDER BY YISGRAND.SPR_GRAFIK.`data` DESC';

			break;
			case "getTemperature":			
			      $this->sql='SELECT * FROM YISGRAND.SPR_TEMPERATURE  ORDER BY YISGRAND.SPR_TEMPERATURE.`data` DESC';

			break;
			case "getLgota":		
			      $this->sql='SELECT  `lgota_id`, `category`, `lgota`, `lgota_ua`, `percent`, `gr`, CONCAT("(гр",`gr`,") ",`law_article`) as law_article '
												.' FROM YIS.LGOTA  ORDER BY YIS.LGOTA.`category`  ';
			break;
			case "tabLgotnik":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article,DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN  ORDER BY YIS.LGOTAMEN.`address_id`  ';
			break;
					case "tabLgotnikHouse":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article ,DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`house_id` = '.$this->house_id.' ORDER BY YIS.LGOTAMEN.`address_id`  ';

			break;
					case "tabLgotnikLgota":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article ,DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`lgota_id` = '.$this->lgota_id.' ORDER BY YIS.LGOTAMEN.`house_id`  ';

			break;
			case "tabLgotnikGroup":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article ,DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`gr` = '.$this->gr.' ORDER BY YIS.LGOTAMEN.`house_id`  ';

			break;
			case "tabLgotnikIzm":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article, DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`data_in` BETWEEN  "'.$this->data_from.'" AND "'.$this->data_to.'" ORDER BY YIS.LGOTAMEN.`address_id`  ';

			break;
			case "tabLgotnikEnd":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article, DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`finish` BETWEEN  "'.$this->data_from.'" AND "'.$this->data_to.'" ORDER BY YIS.LGOTAMEN.`address_id`';

			break;
			case "editAddPort":		
			      $this->sql='SELECT  *,CONCAT(YIS.LGOTAMEN.`surname`," ",YIS.LGOTAMEN.`firstname`," ",YIS.LGOTAMEN.`lastname` ) as fio ,(SELECT YIS.LGOTA.`law_article` FROM YIS.LGOTA WHERE  YIS.LGOTA.`lgota_id` = YIS.LGOTAMEN.`lgota_id` ) as law_article, DATE_FORMAT(data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`data_in` BETWEEN  "'.$this->data_from.'" AND "'.$this->data_to.'" ORDER BY YIS.LGOTAMEN.`address_id`  ';

			break;
			case "OrgPhones":		
			      $this->sql='SELECT YISGRAND.TM_PHONES.`phone_id`,'
					  .'YISGRAND.TM_PHONES.`org_id`,'
					  .'YISGRAND.TM_PHONES.`phone`,'
					  .'YISGRAND.TM_PHONES.`pname`'					 
					  .' FROM YISGRAND.TM_PHONES '
					  .' WHERE YISGRAND.TM_PHONES.`org_id` = "'.$this->org_id.'" ORDER BY pname';
					  //print_r($this->sql); 
			break;
				case "checkVoda"://применяется
									$this->sql='SELECT sum(YIS.VODA.`nachisleno`) as voda  FROM YIS.VODA  WHERE `address_id` = '.$this->address_id.'';
							break;
					case "checkStoki"://применяется
									$this->sql='SELECT sum(YIS.STOKI.`nachisleno`) as stoki  FROM YIS.STOKI  WHERE `address_id` = '.$this->address_id.'';
							break;
					case "checkOtoplenie"://применяется
									$this->sql='SELECT sum(YIS.OTOPLENIE.`nachisleno`) as otoplenie  FROM YIS.OTOPLENIE  WHERE `address_id` = '.$this->address_id.'';
							break;
					case "checkPodogrev"://применяется
									$this->sql='SELECT sum(YIS.PODOGREV.`nachisleno`) as podogrev  FROM YIS.PODOGREV  WHERE `address_id` = '.$this->address_id.'';
							break;
					case "checkKvartplata"://применяется
									$this->sql='SELECT sum(YIS.KVARTPLATA.`nachisleno`) as kvartplata  FROM YIS.KVARTPLATA  WHERE `address_id` = '.$this->address_id.'';
							break;
					case "checkTbo"://применяется
									$this->sql='SELECT sum(YIS.TBO.`nachisleno`) as tbo  FROM YIS.TBO  WHERE `address_id` = '.$this->address_id.'';
							break;
					case "checkOplata"://применяется
									$this->sql='SELECT sum(YIS.OPLATA.`summa`) as oplata  FROM YIS.OPLATA  WHERE `address_id` = '.$this->address_id.'';
							break;

		} 	
		$_result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
		
		while ($this->row = $_result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		$this->results['total']	= $this->total;

		
		return $this->results;
	}  // ================================= GET RESULTS




	public function createRecord(stdClass $params) // ================================= CREATE RECORD
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
			case "kvartplata1":
			      $sql = 'INSERT INTO YISGRAND.DBF_KVARTPLATA1 (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "kvartplata3":
			      $sql = 'INSERT INTO YISGRAND.DBF_KVARTPLATA3 (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "kvartplata4":
			      $sql = 'INSERT INTO YISGRAND.DBF_KVARTPLATA4 (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "otoplenie":
			      $sql = 'INSERT INTO YISGRAND.DBF_OTOPLENIE (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "podogrev":
			      $sql = 'INSERT INTO YISGRAND.DBF_PODOGREV (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "voda":
			      $sql = 'INSERT INTO YISGRAND.DBF_VODA (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "tbo":
			      $sql = 'INSERT INTO YISGRAND.DBF_TBO (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "getVmodel"://применяется
			      $sql = 'INSERT INTO YIS.VMODEL (model ) VALUES (?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('s',$model);

				    $model =  $params->model;
				
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "getPrixod"://применяется
			      $sql = 'INSERT INTO YIS.PRIXOD (prixod ) VALUES (?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('s',$prixod);

				    $prixod =  $params->prixod;
				
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "getTmodel"://применяется
			      $sql = 'INSERT INTO YIS.TMODEL (model,edizm,koef ) VALUES (?,?,?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ssi',$model,$edizm,$koef);

				    $model =  $params->model;
				    $edizm =  $params->edizm;
				    $koef =   $params->koef;

				    $stmt->execute();
				    $stmt->close();
			  break;

			case "StObjNrv":			
			      $sql = 'INSERT INTO YISGRAND.SPR_TYPES (name ) VALUES (?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('s',$name);

				    $name =  $params->name;
				
				    $stmt->execute();
				    $stmt->close();
			  break;

			case "getTypeHot"://применяется
			      $sql = 'INSERT INTO YISGRAND.SPR_TYPESH (name,uxt,koef_30,temp_r,temp_in,temp_out,day_hot,pr ) VALUES (?,?,?,?,?,?,?,?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sddddii',$name,$uxt,$koef_30,$temp_r,$temp_in,$temp_out,$day_hot,$pr);

				    $name =  	$params->name;
				    $uxt =   	$params->uxt;
				    $koef_30 =  $params->koef_30;
				    $temp_r =  $params->temp_r;
				    $temp_in =  $params->temp_in;
				    $temp_out = $params->temp_out;
				    $day_hot =  $params->day_hot;
				    $pr =  $params->pr;				    
				    $stmt->execute();
				    $stmt->close();
			  break;
			
			break;	
			case "insGrafikWorkDays":	//CREATE RECORD
			      $sql = 'INSERT INTO YISGRAND.SPR_GRAFIK (god, data, kalendar_hour, grafik_hour, work_day) VALUES (?, ?, ?, ?, ?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isiii', $god, $data, $kalendar_hour,$grafik_hour,$work_day);

				    $god		 =  $params->god;
				    $data		 =  $params->data;
				    $kalendar_hour	 =  $params->kalendar_hour;
				    $grafik_hour	 =  $params->grafik_hour;
				    $work_day		 =  $params->work_day;

				    $stmt->execute();
				    $stmt->close();
			  break;
			  case "insTemperature":	//CREATE RECORD
			      $sql = 'INSERT INTO YISGRAND.SPR_TEMPERATURE (god, data, temp, otoplenie ,day_ot,day_gv) VALUES (?, ?, ?, ? ,? , ?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isdiii', $god, $data, $temp,$otoplenie,$day_ot,$day_gv);

				    $god	 =  $params->god;
				    $data	 =  $params->data;
				    $temp	 =  $params->temp;
				    $otoplenie	 =  $params->otoplenie;
				    $day_ot	 =  $params->day_ot;
				    $day_gv	 =  $params->day_gv;

				    $stmt->execute();
				    $stmt->close();
			  break;
			   case "getCatSobstv":	//CREATE RECORD
			      $sql = 'INSERT INTO YISGRAND.SPR_SOBSTV (name, tarif_gv, tarif_xv, tarif_st ,tarif_ot) VALUES ( ?, ?, ? ,? , ?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sdddd', $name, $tarif_gv, $tarif_xv,$tarif_st,$tarif_ot);

				    $name	 =  $params->name;
				    $tarif_gv	 =  $params->tarif_gv;
				    $tarif_xv	 =  $params->tarif_xv;
				    $tarif_st	 =  $params->tarif_st;
				    $tarif_ot	 =  $params->tarif_ot;
				    $stmt->execute();
				    $stmt->close();
			  break;
				case "InsertPhones"://CREATE RECORD


			
			 		  $sql = 'INSERT INTO YISGRAND.TM_PHONES (org_id, phone, pname) VALUES (?, ?, ?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('iss', $org_id, $phone, $pname);

				    $org_id	 =  $params->org_id;
				    $phone	 =  $params->phone;
				    $pname	 =  $params->pname;
				    
						$stmt->execute();
				    $stmt->close();
			  break;
			  case "getLgota":	//CREATE RECORD
			      $sql = 'INSERT INTO YIS.LGOTA (category, lgota, lgota_ua, percent ,gr,law_article) VALUES (?, ?, ?, ? ,? , ?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('issiis', $category, $lgota, $lgota_ua,$percent,$gr,$law_article);

				    $category	 =  $params->category;
				    $lgota	 =  $params->lgota;
				    $lgota_ua	 =  $params->lgota_ua;
				    $percent	 =  $params->percent;
				    $gr	 =  $params->gr;
				    $law_article	 =  $params->law_article;

				    $stmt->execute();
				    $stmt->close();
			  break;
		}

		return $this;

	} // ================================= CREATE RECORD


		public function destroyRecord(stdClass $params)      // ================================= DESTROY RECORD
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

			case "StObjNrv":	
			       $this->sql='SELECT count(YISGRAND.TM_ORG_FILIAL.`filial_id`) FROM YISGRAND.TM_ORG_FILIAL WHERE YISGRAND.TM_ORG_FILIAL.`type_id`= '.$this->type_id;
					  $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: тип используется';

						  return $this->results;

					  } else  {
						  $id = $params->type_id;
						  $this->sql='DELETE FROM YISGRAND.SPR_TYPES WHERE YISGRAND.SPR_TYPES.type_id=? LIMIT 1';
						  $stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();	
					  }
						  //  print($this->sql);
			 break;


			case "getTypeHot":	
			       $this->sql='SELECT count(YISGRAND.TM_ORG_FILIAL.`filial_id`) FROM YISGRAND.TM_ORG_FILIAL WHERE YISGRAND.TM_ORG_FILIAL.`typeh_id`= '.$this->type_id;
					 // $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					 						//   print($this->sql);

					    $_result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);

					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: тип используется';

						  return $this->results;

					  } else  {
					  	  $id = $params->type_id;
						  $this->sql='DELETE FROM YISGRAND.SPR_TYPESH WHERE YISGRAND.SPR_TYPESH.type_id=? LIMIT 1';
						  $stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();	
					  }
						//   print($this->sql);
			 break;
			case "delGrafikWorkDays":
	
				$id = $params->rec_id;

				$sql = 'DELETE FROM YISGRAND.SPR_GRAFIK WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  

			 break;
			case "delTemperature":
	
				$id = $params->rec_id;

				$sql = 'DELETE FROM YISGRAND.SPR_TEMPERATURE WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  

			 break;
			 case "getPrixod":
						$this->sql='SELECT count(YIS.PRIXOD.`prixod_id`) FROM YIS.PRIXOD WHERE YIS.PRIXOD.`prixod_id`= '.$this->prixod_id;
					  $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: вид оплаты уже используется';

						  return $this->results;

					  } else  {
							$id = $params->prixod_id;
							$this->sql = 'DELETE FROM YIS.PRIXOD WHERE prixod_id = ? LIMIT 1';
	
									$stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();		
								
						}
						  //  print($this->sql);

			 break;
			case "getVmodel":
						$this->sql='SELECT count(YIS.VODOMER.`vodomer_id`) FROM YIS.VODOMER WHERE YIS.VODOMER.`model_id`= '.$this->model_id;
					  $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: модель водомера уже используется';

						  return $this->results;

					  } else  {
							$id = $params->model_id;
							$this->sql = 'DELETE FROM YIS.VMODEL WHERE model_id = ? LIMIT 1';
	
									$stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();		
								
						}
						  //  print($this->sql);

			 break;
			 
			case "getTmodel":
						$this->sql='SELECT count(YIS.TEPLOMER.`teplomer_id`) FROM YIS.TEPLOMER WHERE YIS.TEPLOMER.`model_id`= '.$this->model_id;
					  $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: модель тепломера уже используется';

						  return $this->results;

					  } else  {
							$id = $params->model_id;
							$this->sql = 'DELETE FROM YIS.TMODEL WHERE model_id = ? LIMIT 1';
					
									$stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();		
									
					}
						  //  print($this->sql);

			 break;
			 case "getCatSobstv":
					  $this->sql='SELECT count(YISGRAND.TM_ORG_FILIAL.`sobstv_id`) FROM YISGRAND.TM_ORG_FILIAL WHERE YISGRAND.TM_ORG_FILIAL.`sobstv_id`= '.$this->sobstv_id;
					  $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: категория  уже используется';

						  return $this->results;

					  } else  {
							$id = $params->sobstv_id;
							$this->sql = 'DELETE FROM YISGRAND.SPR_SOBSTV WHERE YISGRAND.SPR_SOBSTV.`sobstv_id` = ? LIMIT 1';
	
									$stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();		
								
						}
						  //  print($this->sql);

			 break;
			case "getLgota":	
			       $this->sql='SELECT count(YIS.LGOTAMEN.`lgota_id`) FROM YIS.LGOTAMEN WHERE YIS.LGOTAMEN.`lgota_id`= '.$this->lgota_id;
					 // $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					    $_result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);

					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: льгота уже используется';

						  return $this->results;

					  } else  {
							$id = $params->lgota_id;
							$this->sql = 'DELETE FROM YIS.LGOTA WHERE lgota_id = ? LIMIT 1';
							
									$stmt = $_db->prepare($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->close();		
									
						}				 
			break;
				case "kvartplata1":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_KVARTPLATA1 WHERE rec_id = ? LIMIT 1';
			
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			case "kvartplata3":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_KVARTPLATA3 WHERE rec_id = ? LIMIT 1';				
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
	case "kvartplata4":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_KVARTPLATA4 WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
			 break;
	case "otoplenie":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_OTOPLENIE WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
	case "podogrev":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_PODOGREV WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
	case "voda":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_VODA WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
	case "tbo":	
				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.DBF_TBO WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			case "deletePhones":

		    $id = $params->phone_id;
				$sql = 'DELETE FROM YISGRAND.TM_PHONES  WHERE phone_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
				case "port":

		    $id = $params->rec_id;
		    				  						   // print($id);

				$sql = 'DELETE FROM YIS.PORT  WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 

			 break;
				case "subsidia":

		    $id = $params->rec_id;
				$sql = 'DELETE FROM YIS.SUBSID  WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			} 

		  return $this;

		} 
		public function updateRecords(stdClass $params)      // ================================= UPDATE RECORD
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
			case "kvartplata1":
			      $sql = 'UPDATE YISGRAND.DBF_KVARTPLATA1 SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_KVARTPLATA1.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
	case "kvartplata3":
			      $sql = 'UPDATE YISGRAND.DBF_KVARTPLATA3 SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_KVARTPLATA3.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
	case "kvartplata4":
			      $sql = 'UPDATE YISGRAND.DBF_KVARTPLATA4 SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_KVARTPLATA4.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
	case "otoplenie":
			      $sql = 'UPDATE YISGRAND.DBF_OTOPLENIE SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_OTOPLENIE.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
case "podogrev":
			      $sql = 'UPDATE YISGRAND.DBF_PODOGREV SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_PODOGREV.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
case "voda":
			      $sql = 'UPDATE YISGRAND.DBF_VODA SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_VODA.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
case "tbo":
			      $sql = 'UPDATE YISGRAND.DBF_TBO SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?, `yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,'
										.'`lgkol` = ?, `lgkat` = ?, `lgprc` = ?, `summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_TBO.`rec_id` = ? ';
			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);

				    $rec_id		 =  $params->rec_id;
				    $cdpr		 =  $params->cdpr;
				    $idcode		 =  $params->idcode;
				    $fio	 =  $params->fio;
				    $ppos	 =  $params->ppos;
				    $rs		 =  $params->rs;
						$yearin		 =  $params->yearin;
				    $monthin		 =  $params->monthin;
				    $lgcode	 =  $params->lgcode;
				    $data1	 =  $params->data1;
				    $data2		 =  $params->data2;
						$lgkol		 =  $params->lgkol;
				    $lgkat		 =  $params->lgkat;
				    $lgprc	 =  $params->lgprc;
				    $summ	 =  $params->summ;
				    $fact		 =  $params->fact;
						$tarif		 =  $params->tarif;
				    $flag		 =  $params->flag;
				    $house	 =  $params->house;
				    $stmt->execute();
				    $stmt->close();
			  break;
			case "StObjNrv":

				    $sql = 'UPDATE YISGRAND.SPR_TYPES SET nrxv=?, nrgv=?, nrv=?,nrnogv = ?,pstoki =?,uxt =?,  name = ? ,edizm = ? WHERE YISGRAND.SPR_TYPES.type_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ddddssi', $nrxv, $nrgv, $nrv,$nrnogv,$pstoki,$uxt, $name,$edizm,$type_id);

				    $edizm  = $params->edizm;
				    $name   = $params->name;
				    $nrxv   = $params->nrxv;
				    $nrgv   = $params->nrgv;
				    $nrv    = $params->nrv;
				    $nrnogv = $params->nrnogv;
				    $pstoki = $params->pstoki;
				    $uxt    = $params->uxt;
				    $type_id= $params->type_id;

				    $stmt->execute();
				    $stmt->close();			

			break;
			case "getCatSobstv":

				    $sql = 'UPDATE YISGRAND.SPR_SOBSTV SET name=?, tarif_gv=?, tarif_xv=?,tarif_st = ?,tarif_ot =? WHERE YISGRAND.SPR_SOBSTV.sobstv_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sddddi', $name, $tarif_gv, $tarif_xv,$tarif_st,$tarif_ot,$sobstv_id);

				    $name   = $params->name;
				    $tarif_gv   = $params->tarif_gv;
				    $tarif_xv  = $params->tarif_xv;
				    $tarif_st    = $params->tarif_st;
				    $tarif_ot = $params->tarif_ot;
				    $sobstv_id= $params->sobstv_id;

				    $stmt->execute();
				    $stmt->close();	
				    $sql = 'UPDATE YISGRAND.TM_ORG_FILIAL SET  tarif_gv=?, tarif_xv=?,tarif_st = ?,tarif_ot =? WHERE YISGRAND.TM_ORG_FILIAL.sobstv_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ddddi',  $tarif_gv, $tarif_xv,$tarif_st,$tarif_ot,$sobstv_id);			   

				    $stmt->execute();
				    $stmt->close();	
				   
			break;
			case "port":

				    $sql = 'UPDATE YIS.PORT SET tabn=?, fio=?, dolg=?,nachisleno = ?,uderzhat =?,uderzhano =?,  izm = ? ,data = ? WHERE YIS.PORT.rec_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isddddisi', $tabn, $fio, $dolg,$nachisleno,$uderzhat,$uderzhano, $izm,$data,$rec_id);

				    $tabn  = $params->tabn;
				    $fio   = $params->fio;
				    $dolg   = $params->dolg;
				    $nachisleno   = $params->nachisleno;
				    $uderzhat    = $params->uderzhat;
				    $uderzhano = $params->uderzhano;
				    $izm = $params->izm;
				    $data    = $params->data;
				    $rec_id= $params->rec_id;

				    $stmt->execute();
				    $stmt->close();			

			break;

			case "subsidia":

				    $sql = 'UPDATE YIS.SUBSID SET kvartplata=?, otoplenie = ?, podogrev =?, voda =?, stoki = ? ,tbo = ? ,summa = ? WHERE YIS.SUBSID.rec_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('dddddddi', $kvartplata,$otoplenie,$podogrev,$voda, $stoki,$tbo,$summa,$rec_id);

				    $summa  = $params->summa;
				    $kvartplata   = $params->kvartplata;
				    $otoplenie   = $params->otoplenie;
				    $podogrev    = $params->podogrev;
				    $voda = $params->voda;
				    $stoki = $params->stoki;
				    $tbo    = $params->tbo;
				    $rec_id= $params->rec_id;

				    $stmt->execute();
				    $stmt->close();			

			break;
			case "getTypeHot":	

				    $sql = 'UPDATE YISGRAND.SPR_TYPESH SET name = ?,uxt = ?,koef_30 = ?,temp_r = ?,temp_in = ?,temp_out = ?,day_hot = ?,pr = ? WHERE YISGRAND.SPR_TYPESH.type_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sdddddiii',$name,$uxt,$koef_30,$temp_r,$temp_in,$temp_out,$day_hot,$pr,$type_id);
				    $name =  	$params->name;
				    $uxt =   	$params->uxt;
				    $koef_30 =  $params->koef_30;
    				    $temp_r =   $params->temp_r;
				    $temp_in =  $params->temp_in;
				    $temp_out = $params->temp_out;
				    $day_hot =  $params->day_hot;	
				    $type_id =  $params->type_id;
				    $pr      =  $params->pr;				    


				    $stmt->execute();
				    $stmt->close();

			break;

			case "updateGrafikWorkDays":

				    $sql = 'UPDATE YISGRAND.SPR_GRAFIK SET god=?, data=?, kalendar_hour=?,grafik_hour = ?, work_day = ? WHERE YISGRAND.SPR_GRAFIK.rec_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isiiii', $god, $data, $kalendar_hour,$grafik_hour,$work_day, $rec_id);

				    $god		 =  $params->god;
				    $data		 =  $params->data;
				    $kalendar_hour	 =  $params->kalendar_hour;
				    $grafik_hour	 =  $params->grafik_hour;
				    $work_day		 =  $params->work_day;
				    $rec_id		 =  $params->rec_id;

				    $stmt->execute();
				    $stmt->close();
			
			break;
			case "getTmodel":

				    $sql = 'UPDATE YIS.TMODEL SET model=?, edizm=?, koef=? WHERE YIS.TMODEL.model_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ssdi', $model, $edizm, $koef,$model_id);

				    $model	 =  $params->model;
				    $edizm	 =  $params->edizm;
				    $koef		 =  $params->koef;
				    $model_id	 =  $params->model_id;


				    $stmt->execute();
				    $stmt->close();
			
			break;
			case "getPrixod":

				    $sql = 'UPDATE YIS.PRIXOD SET prixod=? WHERE YIS.PRIXOD.prixod_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('si', $prixod,$prixod_id);

				    $prixod	 =  $params->prixod;
				    $prixod_id	 =  $params->prixod_id;


				    $stmt->execute();
				    $stmt->close();
			
			break;
			case  "getVmodel":

				    $sql = 'UPDATE YIS.VMODEL SET model=? WHERE YIS.VMODEL.model_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('si', $model,$model_id);

				    $model	 =  $params->model;
				    $model_id	 =  $params->model_id;


				    $stmt->execute();
				    $stmt->close();
			
			break;
			case "updateTemperature":

				    $sql = 'UPDATE YISGRAND.SPR_TEMPERATURE SET god=?, data=?, temp=?, otoplenie = ? , day_ot = ? , day_gv = ? WHERE YISGRAND.SPR_TEMPERATURE.rec_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isdiiii', $god, $data, $temp, $otoplenie,$day_ot,$day_gv, $rec_id);

				    $god	 =  $params->god;
				    $data	 =  $params->data;
				    $temp	 =  $params->temp;
				    $otoplenie	 =  $params->otoplenie;
				    $day_ot	 =  $params->day_ot;
				    $day_gv	 =  $params->day_gv;
				    $rec_id	 =  $params->rec_id;


				    $stmt->execute();
				    $stmt->close();
			
			break;
			case "getLgota":

				    $sql = 'UPDATE YIS.LGOTA SET category=?, lgota=?, lgota_ua=?, percent = ? , gr = ? , law_article = ? WHERE YIS.LGOTA.lgota_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('issiisi', $category, $lgota, $lgota_ua,$percent,$gr,$law_article,$lgota_id);

				    $lgota_id	 =  $params->lgota_id;
				    $category	 =  $params->category;
				    $lgota	 =  $params->lgota;
				    $lgota_ua	 =  $params->lgota_ua;
				    $percent	 =  $params->percent;
				    $gr	 =  $params->gr;
				    $law_article	 =  $params->law_article;

				    $stmt->execute();
				    $stmt->close();
			
			break;
			case "UpdatePhones":
			
				    $sql = 'UPDATE YISGRAND.TM_PHONES SET phone=?, pname=? WHERE YISGRAND.TM_PHONES .phone_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ssi', $phone, $pname, $phone_id);

				    $phone_id	 =  $params->phone_id;
				    $phone	 =  $params->phone;
				    $pname	 =  $params->pname;
				 
				    $stmt->execute();
				    $stmt->close();
			break;

		} 

		return $this;

	} // ================================= UPDATE RECORD








	public function __destruct()
	{
		$_db = $this->__construct();
		$_db->close();
		
		return $this;
	}
}