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
		$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YISGRAND');
		
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
			case "getDbfLgota"://применяется
			      $this->sql='SELECT t1.*  FROM YIS.LG_KVARTPLATA as t1 WHERE t1.`osmd_id` = '.$this->osmd_id.' and t1.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") ';			  
			break;	
			case "getPort"://применяется
				  $this->sql='SELECT *  FROM YIS.PORT';
			break;
			case "getPrivatBank"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.PRIVATBANK_OPLATA as t1  WHERE t1.`osmd_id` = '.$this->osmd_id.'';
					// print_r($this->sql); 
			break;
			case "getGerz"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.GERZ_OPLATA';
			break;
			case "subsidia"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.SUBSID';
			break;
			case "getOplataOrg":			
			      $this->sql='SELECT * FROM YISGRAND.DEBET  ORDER BY YISGRAND.DEBET.`data` ';

			break;
			case "getOplataData":			
			$this->sql='SELECT * FROM YISGRAND.DEBET  WHERE  EXTRACT(YEAR_MONTH FROM YISGRAND.DEBET.`data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ';

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
			case "getSprUtszn"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.SPR_UTSZN ORDER BY  YISGRAND.SPR_UTSZN.`gr`';			
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
			case "getBankOrg"://применяется
				  $this->sql='SELECT *  FROM YISGRAND.BANKO WHERE  YISGRAND.BANKO.`org_id` = '.$this->org_id.'';			
			break;
			case "getLgota":		
			      $this->sql='SELECT  `lgota_id`, `category`, `lgota`, `lgota_ua`, `percent`, `gr`, CONCAT("(гр",`gr`,") ",`law_article`) as law_article '
												.' FROM YIS.LGOTA  ORDER BY YIS.LGOTA.`category`  ';
			break;
			case "getLgota":		
			      $this->sql='SELECT  `lgota_id`, `category`, `lgota`, `lgota_ua`, `percent`, `gr`, CONCAT("(гр",`gr`,") ",`law_article`) as law_article '
												.' FROM YIS.LGOTA  ORDER BY YIS.LGOTA.`category`  ';
			break;
			case "tabLgotnik":		
			      $this->sql='SELECT  t1.*,CONCAT(t1.`surname`," ",t1.`firstname`," ",t1.`lastname` ) as fio ,(SELECT t2.`law_article` FROM YIS.LGOTA as t2 WHERE  t2.`lgota_id` = t1.`lgota_id` ) as law_article,DATE_FORMAT(t1.data_in,"%Y-%m-%d") as data_in FROM YIS.LGOTAMEN as t1 WHERE  t1.`data_in` > DATE_SUB(CURDATE(), INTERVAL 3 MONTH) OR  t1.vkl = "да"  ORDER BY t1.`address_id` ';
			break;
			case "update_lgota_from_utszn":		
			      $this->sql='SELECT  t1.*,CONCAT(t1.`surname`," ",t1.`firstname`," ",t1.`lastname` ) as fio ,(SELECT t2.`law_article` FROM YIS.LGOTA as t2 WHERE  t2.`lgota_id` = t1.`lgota_id` ) as law_article,DATE_FORMAT(t1.data_in,"%Y-%m-%d") as data_in FROM YISGRAND.LGOTAMEN as t1 WHERE t1.vkl = "да" ORDER BY t1.`address_id` ';
			break;
			case "insert_lgota_from_utszn":		
			      $this->sql='SELECT  t1.*,CONCAT(t1.`surname`," ",t1.`firstname`," ",t1.`lastname` ) as fio ,(SELECT t2.`law_article` FROM YIS.LGOTA as t2 WHERE  t2.`lgota_id` = t1.`lgota_id` ) as law_article,DATE_FORMAT(t1.data,"%Y-%m-%d") as data FROM YIS.LGOTAMEN as t1 WHERE t1.`pr` in(3,1)  ORDER BY t1.`address_id` ';
			break;
			case "tabLgotnikHouse":		
			      $this->sql='SELECT  t1.*,CONCAT(t1.`surname`," ",t1.`firstname`," ",t1.`lastname` ) as fio ,DATE_FORMAT(t1.`data`,"%Y-%m-%d") as data FROM YIS.LGOTAMEN as t1 WHERE t1.`house_id` = '.$this->house_id.' AND (t1.`vkl` = "да"  OR t1.`data` > DATE_SUB(CURDATE(), INTERVAL 3 MONTH))  ORDER BY t1.`address_id`  ';

			break;
			case "getSubsidiaVozvrat":		
			      $this->sql='SELECT  * FROM YIS.SUBSIDV_TEMP as t1 WHERE 1 ORDER BY t1.`data` DESC ';

			break;
			case "getSubsidiaUtszn":		
			      $this->sql='SELECT  * FROM YISGRAND.SKV as t1 WHERE  t1.`osmd_id` = '.$this->osmd_id.' and t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") ORDER BY t1.`address_id`';

			break;
			/*
			case "getControlSubsidiaUtszn":		
			      $this->sql='SELECT  t1.* FROM YISGRAND.SKV as t1  WHERE   t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") and ' 
			      .' ((t1.dolg != t1.zadol + t1.perer - t1.oplata  - t1.doplata)  or (t1.`nachisleno` != t1.`perer`) OR (t1.fin != t1.st- t1.doplata))';
					// print_r($this->sql); 

			break;
			*/
			case "getSubsidia"://применяется
			      $this->sql='SELECT t1.*  FROM YIS.SUBS_KVARTPLATA as t1 WHERE t1.`osmd_id` = '.$this->osmd_id.' and t1.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") ';			  
			break;
			case "getControlSubsidiaUtszn":		
			       $this->sql='SELECT  t1.* FROM YISGRAND.SKV as t1 ,YISGRAND.SKV as t2  WHERE   t1.`address_id` = t2.`address_id` and '
				      .' t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") and ' 
			      .' t2.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB("'.$this->data.'", INTERVAL 1 MONTH)),"01") and ' 
			      .' (t1.dolg != t1.zadol + t1.perer - t1.oplata  - t1.doplata  or t1.`nachisleno` != t1.`perer` OR t1.fin != t1.st- t1.doplata or t1.zadol != t2.dolg)';
			break;
			case "getControlLgotaUtszn":		
			      $this->sql='SELECT  t1.* FROM YISGRAND.BKV as t1 ,YISGRAND.BKV as t2  WHERE   t1.`lgotnik_id` = t2.`lgotnik_id` and '
				      .' t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") and ' 
			      .' t2.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM DATE_SUB("'.$this->data.'", INTERVAL 1 MONTH)),"01") and ' 
			      .' (t1.dolg != t1.zadol + t1.perer - t1.oplata  - t1.doplata  or t1.`nachisleno` != t1.`perer` OR t1.fin != t1.st- t1.doplata or t1.zadol != t2.dolg)';
					// print_r($this->sql); 

			break;
			case "getLgotaUtszn":		
			      $this->sql='SELECT  * FROM YISGRAND.BKV as t1   WHERE t1.`osmd_id` = '.$this->osmd_id.' and t1.`data` =CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") ORDER BY t1.`gr`,t1.`address_id`';
					// print_r($this->sql); 

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
			case "getOrgPhones":		
			      $this->sql='SELECT YISGRAND.TM_PHONES.`phone_id`,'
					  .'YISGRAND.TM_PHONES.`org_id`,'
					  .'YISGRAND.TM_PHONES.`phone`,'
					  .'YISGRAND.TM_PHONES.`pname`'					 
					  .' FROM YISGRAND.TM_PHONES '
					  .' WHERE YISGRAND.TM_PHONES.`org_id` = "'.$this->org_id.'" ORDER BY pname';
					  //print_r($this->sql); 
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
		case "getDbfLgota"://применяется
			
				    $sql = 'INSERT INTO YISGRAND.DBF_OSMD (`cdpr`, `idcode`, `fio`, `ppos`, `rs`, `yearin`, `monthin`, `lgcode`, `data1`, `data2`,'
										.'`lgkol`, `lgkat`, `lgprc`, `summ`, `fact`, `tarif`, `flag`, `house`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
				    $stmt->bind_param('issssiiissisidddis',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house);
				    $cdpr	=  $params->cdpr;
				    $idcode	=  $params->idcode;
				    $fio	=  $params->fio;
				    $ppos	=  $params->ppos;
				    $rs		=  $params->rs;
				    $yearin	=  $params->yearin;
				    $monthin	=  $params->monthin;
				    $lgcode	=  $params->lgcode;
				    $data1	=  $params->data1;
				    $data2	=  $params->data2;
				    $lgkol	=  $params->lgkol;
				    $lgkat	=  $params->lgkat;
				    $lgprc	=  $params->lgprc;
				    $summ	=  $params->summ;
				    $fact	=  $params->fact;
				    $tarif	=  $params->tarif;
				    $flag	=  $params->flag;
				    $house	=  $params->house;
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
			  case "getSprUtszn"://применяется
			      $sql = 'INSERT INTO YISGRAND.SPR_UTSZN (gr,lgota ) VALUES (?,?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('is',$gr,$lgota);

				    $lgota =  $params->lgota;
				    $gr =  $params->gr;

				    $stmt->execute();
				    $stmt->close();
			  break;

			case "getObjNrv":			
			      $sql = 'INSERT INTO YISGRAND.SPR_TYPES (nrxv, nrgv, nrv,nrnogv,pstoki,uxt,  name ,edizm  ) VALUES (?,?,?,?,?,?,?,?)';

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ddddddss', $nrxv, $nrgv, $nrv,$nrnogv,$pstoki,$uxt, $name,$edizm);

				    $edizm  = $params->edizm;
				    $name   = $params->name;
				    $nrxv   = $params->nrxv;
				    $nrgv   = $params->nrgv;
				    $nrv    = $params->nrv;
				    $nrnogv = $params->nrnogv;
				    $pstoki = $params->pstoki;
				    $uxt    = $params->uxt;
				
				    $stmt->execute();
				    $stmt->close();
			  break;

			case "getTypeHot"://применяется
			      $sql = 'INSERT INTO YISGRAND.SPR_TYPESH (name,uxt,koef_30,temp_in,temp_out,temp_r,temp_gvs,temp_w,temp_s,day_hot,day_gvs,pr ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
//print($sql);

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sddddddddiii',$name,$uxt,$koef_30,$temp_in,$temp_out,$temp_r,$temp_gvs,$temp_w,$temp_s,$day_hot,$day_gvs,$pr);

				    $name =  	$params->name;
				    $uxt =   	$params->uxt;
				    $koef_30 =  $params->koef_30;
				    $temp_r =  $params->temp_r;
				    $temp_in =  $params->temp_in;
				    $temp_out = $params->temp_out;
				    $temp_gvs = $params->temp_gvs;
				    $temp_w = $params->temp_w;
				    $temp_s = $params->temp_s;
				    $day_hot =  $params->day_hot;
				    $day_gvs =  $params->day_gvs;
				    $pr =  $params->pr;				    
				    $stmt->execute();
				    $stmt->close();
			  break;
			
			case "getBankOrg":	//CREATE RECORD
			$sql = 'INSERT INTO YISGRAND.BANKO SET  mfo = ? ,org_id = ?, filial_id = ?, rs = ?,schet=?,osn = ?,'
						      .'sname = (SELECT YISGRAND.BANKS.`sname` FROM YISGRAND.BANKS WHERE YISGRAND.BANKS.`mfo` = ?),'
						      .'filial = (SELECT YISGRAND.TM_ORG_FILIAL.`name` FROM YISGRAND.TM_ORG_FILIAL WHERE YISGRAND.TM_ORG_FILIAL.`filial_id` = ?)';

//print($sql);

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('siissisi', $mfo, $org_id,$filial_id , $rs,$schet,$osn, $mfo, $filial_id );

				    $filial_id	=  $params->filial_id;
				    $schet	=  $params->schet;
				    $org_id	=  $params->org_id;
				    $rs		=  $params->rs;
				    $mfo	=  $params->mfo;
				    $osn	=  $params->osn;



				    $stmt->execute();
				    $stmt->close();
			  break;
			  case "getGrafikWorkDays":	//CREATE RECORD
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
			  case "getTemperature":	//CREATE RECORD
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
				case "getOrgPhones"://CREATE RECORD


			
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

			case "getObjNrv":	
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
			case "getGrafikWorkDays":
	
				$id = $params->rec_id;

				$sql = 'DELETE FROM YISGRAND.SPR_GRAFIK WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  

			 break;
			case "getTemperature":
	
				$id = $params->rec_id;

				$sql = 'DELETE FROM YISGRAND.SPR_TEMPERATURE WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  

			 break;
			 case "getPrixod":
			$this->sql='SELECT count(YIS.OPLATA.`address_id`)  FROM YIS.PRIXOD,YIS.OPLATA WHERE YIS.PRIXOD.`prixod_id`= '.$this->prixod_id.' AND YIS.PRIXOD.`prixod` = YIS.OPLATA.`prixod`';
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
			 case "getSprUtszn":
					  $this->sql='SELECT count(t1.`gr`) FROM YISGRAND.LGOTA_UTSZN as t1 WHERE t1.`gr`= '.$this->gr;
					  $_result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					  $row = $_result->fetch_array();
					  $total = $row[0]; // всего записей
					  if ($total) { 
						 $this->results['success']= false;
						 $this->results['msg']= 'Невозможно удалить: модель тепломера уже используется';

						  return $this->results;

					  } else  {
							$id = $params->rec_id;
							$this->sql = 'DELETE FROM YISGRAND.SPR_UTSZN WHERE rec_id = ? LIMIT 1';
					
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
			case "getDbfLgota"://применяется
				
					  $id = $params->rec_id;
					  $sql = 'DELETE FROM YISGRAND.DBF_OSMD WHERE rec_id = ? LIMIT 1';			
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();
				    
			break;	

			case "getOrgPhones":

				$id = $params->phone_id;
				$sql = 'DELETE FROM YISGRAND.TM_PHONES  WHERE phone_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			 case "getBankOrg":

				$id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.BANKO  WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			 case "getPrivatBank":

		    $id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.PRIVATBANK_OPLATA  WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
				case "getPort":

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
				$sql = 'DELETE FROM YISGRAND.SUBSID  WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			 	case "getGerz":

		    $id = $params->rec_id;
				$sql = 'DELETE FROM YISGRAND.GERZ_OPLATA  WHERE rec_id = ? LIMIT 1';
					  $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					  $stmt->bind_param('i', $id);
					  $stmt->execute();
					  $stmt->close();					 
				  
			 break;
			 case "getOplataOrg":

		    $id = $params->rec_id;
		    		    				  						 //   print($id);

				$sql = 'DELETE FROM YISGRAND.DEBET  WHERE rec_id = ? LIMIT 1';
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
			case "getDbfLgota"://применяется
					    $sql = 'UPDATE YISGRAND.DBF_OSMD SET `cdpr` = ?, `idcode` = ?, `fio` = ?, `ppos` = ?, `rs` = ?,'
					    .'`yearin` = ?, `monthin` = ?, `lgcode` = ?, `data1` = ?, `data2` = ?,`lgkol` = ?, `lgkat` = ?, `lgprc` = ?,'
					    .'`summ` = ?, `fact` = ?, `tarif` = ?, `flag` = ?, `house` = ?  WHERE YISGRAND.DBF_OSMD.`rec_id` = ? ';
					    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);
					    $stmt->bind_param('issssiiissisidddisi',$cdpr, $idcode, $fio, $ppos, $rs, $yearin, $monthin, $lgcode, $data1, $data2,$lgkol, $lgkat, $lgprc, $summ, $fact, $tarif, $flag, $house,$rec_id);
					    $rec_id	=  $params->rec_id;
					    $cdpr	=  $params->cdpr;
					    $idcode	=  $params->idcode;
					    $fio	=  $params->fio;
					    $ppos	=  $params->ppos;
					    $rs		=  $params->rs;
					    $yearin	=  $params->yearin;
					    $monthin	=  $params->monthin;
					    $lgcode	=  $params->lgcode;
					    $data1	=  $params->data1;
					    $data2	=  $params->data2;
					    $lgkol	=  $params->lgkol;
					    $lgkat	=  $params->lgkat;
					    $lgprc	=  $params->lgprc;
					    $summ	=  $params->summ;
					    $fact	=  $params->fact;
					    $tarif	=  $params->tarif;
					    $flag	=  $params->flag;
					    $house	=  $params->house;
					    $stmt->execute();
					    $stmt->close();
				 break;	
			
			case "getObjNrv":

				    $sql = 'UPDATE YISGRAND.SPR_TYPES SET nrxv=?, nrgv=?, nrv=?,nrnogv = ?,pstoki =?,uxt =?,  name = ? ,edizm = ? WHERE YISGRAND.SPR_TYPES.type_id=? ';
 // $sql = 'UPDATE YISGRAND.SPR_TYPES SET nrxv='.$params->nrxv.', nrgv='.$params->nrgv.', nrv='.$params->nrv.',nrnogv = '.$params->nrnogv.',pstoki ='.$params->pstoki.',uxt ='.$params->uxt.',  name = '.$params->name.' ,edizm = '.$params->edizm.' WHERE YISGRAND.SPR_TYPES.type_id='.$params->type_id.' ';
//print($sql);

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ddddddssi', $nrxv, $nrgv, $nrv,$nrnogv,$pstoki,$uxt, $name,$edizm,$type_id);

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
			case "getPort":

				    $sql = 'UPDATE YIS.PORT SET tabn=?, fio=?, dolg=?,nachisleno = ?,uderzhat =?,uderzhano =?,  izm = ?  WHERE YIS.PORT.rec_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isddddii', $tabn, $fio, $dolg,$nachisleno,$uderzhat,$uderzhano, $izm,$rec_id);

				    $tabn  = $params->tabn;
				    $fio   = $params->fio;
				    $dolg   = $params->dolg;
				    $nachisleno   = $params->nachisleno;
				    $uderzhat    = $params->uderzhat;
				    $uderzhano = $params->uderzhano;
				    $izm = $params->izm;
				    $rec_id= $params->rec_id;

				    $stmt->execute();
				    $stmt->close();			

			break;
			case "getPrivatBank":


				  $sql = 'UPDATE YISGRAND.PRIVATBANK_OPLATA SET summa = ? summa = ?,pr = ? WHERE YISGRAND.PRIVATBANK_OPLATA.rec_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('ddi', $summa,$pr,$rec_id);

				    $summa  = $params->summa;
				    $pr  = $params->pr;				   

				    $rec_id= $params->rec_id;

				    $stmt->execute();
				    $stmt->close();			

			break;
			case "subsidia":

				    $sql = 'UPDATE YISGRAND.SUBSID SET kvartplata=? ,summa = ? WHERE YISGRAND.SUBSID.rec_id=? ';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('dddddddi', $kvartplata,$summa,$rec_id);

				    $summa  = $params->summa;
				    $kvartplata   = $params->kvartplata;
				    $rec_id= $params->rec_id;
				    $stmt->execute();
				    $stmt->close();			

			break;
			case "getGerz":

				  $sql = 'UPDATE YISGRAND.GERZ_OPLATA SET kvartplata=?, otoplenie = ?, podogrev =?, voda =?, stoki = ? ,tbo = ? ,summa = ? WHERE YISGRAND.GERZ_OPLATA.rec_id=? ';

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

				    $sql = 'UPDATE YISGRAND.SPR_TYPESH SET name = ?,uxt = ?,koef_30 = ?,temp_in = ?,temp_out = ?,temp_r = ?,
				    temp_gvs = ?,temp_w = ?,temp_s = ?,day_gvs = ?,day_hot = ?,pr = ? WHERE YISGRAND.SPR_TYPESH.type_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sddddddddiiii',$name,$uxt,$koef_30,$temp_in,$temp_out,$temp_r,$temp_gvs,$temp_w,$temp_s,$day_gvs,$day_hot,$pr,$type_id);
				    $name =   	$params->name;
				    $uxt =   	$params->uxt;
				    $koef_30 =  $params->koef_30;
				    $temp_r =  $params->temp_r;
				    $temp_in =  $params->temp_in;
				    $temp_out = $params->temp_out;
				    $temp_gvs = $params->temp_gvs;
				    $temp_w = $params->temp_w;
				    $temp_s = $params->temp_s;
				    $day_hot =  $params->day_hot;
				    $day_gvs =  $params->day_gvs;
				    $pr =  $params->pr;				
				    $type_id =  $params->type_id;


				    $stmt->execute();
				    $stmt->close();

			break;
			case "getSubsidiaUtszn":	

				    $sql = 'UPDATE YISGRAND.SUBSID_UTSZN SET st = ?,subsidia = ?,oplata = ?,doplata = ?,fin = ? WHERE YISGRAND.SUBSID_UTSZN.rec_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('dddddi',$st,$subsidis,$oplata,$doplata,$fin,$rec_id);
				    $st =   	$params->st;
				    $subsidis =	$params->subsidis;
				    $oplata =  $params->oplata;
				    $doplata =  $params->doplata;
				    $fin =  $params->fin;
				    $rec_id = $params->rec_id;
				    $stmt->execute();
				    $stmt->close();

			break;
			case "getBankOrg":	//CREATE RECORD
			$sql = 'UPDATE YISGRAND.BANKO SET  mfo = ? , filial_id = ?, rs = ?, schet = ?,osn = ?,'
						      .'sname = (SELECT YISGRAND.BANKS.`sname` FROM YISGRAND.BANKS WHERE YISGRAND.BANKS.`mfo` = ?),'
						      .'filial = (SELECT YISGRAND.TM_ORG_FILIAL.`name` FROM YISGRAND.TM_ORG_FILIAL WHERE YISGRAND.TM_ORG_FILIAL.`filial_id` = ?) '
						      .' WHERE YISGRAND.BANKO.`rec_id` = ?';

//print($sql);

			      $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('sissisii', $mfo,$filial_id , $rs,$schet ,$osn,  $mfo, $filial_id,$id );

				    $filial_id	=  $params->filial_id;
				    $schet	=  $params->schet;
				    $osn	=  $params->osn;
				    $rs		=  $params->rs;
				    $mfo	=  $params->mfo;
				    $id = $params->rec_id;



				    $stmt->execute();
				    $stmt->close();
			  break;
			case "getGrafikWorkDays":

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
			case "getSprUtszn":

				    $sql = 'UPDATE YISGRAND.SPR_UTSZN SET gr=?,lgota=? WHERE YISGRAND.SPR_UTSZN.rec_id=?';

				    $stmt = $_db->prepare($sql) or die('Connect Error in '.$this->what.' ( ' . $sql . ' ) ' . $_db->connect_error);

				    $stmt->bind_param('isi', $gr,$lgota,$rec_id);
				    $gr	 =  $params->gr;
				    $lgota	 =  $params->lgota;
				    $rec_id	 =  $params->rec_id;


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
			case "getTemperature":

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
			case "getOrgPhones":
			
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