<?php

class QueryOrg
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
	public function createRecord(stdClass $params) // ================================= CREATE RECORD
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
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int)($params->what_id);
		} else {
		  $this->id = null;
		}



		switch ($this->what) {
			case "OrgPhones"://CREATE RECORD


			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = $_db->real_escape_string($params->org_id);
			} else {
			  $this->org_id = '';
			}

			if(isset($params->filial_id) && ($params->filial_id)) {
			  $this->filial_id = $_db->real_escape_string($params->filial_id);
			} else {
			  $this->filial_id = '';
			}

			if(isset($params->phone) && ($params->phone)) {
			  $this->phone = $_db->real_escape_string($params->phone);
			} else {
			  $this->phone = '';
			}

			if(isset($params->pname) && ($params->pname)) {
			  $this->pname = $_db->real_escape_string($params->pname);
			} else {
			  $this->pname = '';
			}

			 $this->sql='INSERT INTO TM_PHONES SET '
			      .'org_id="'.$this->org_id.'", '
			      .'filial_id="'.$this->filial_id.'", '
			      .'phone="'.$this->phone.'", '
			      .'pname="'.$this->pname.'"'
			      .'';
			   //  print_r($this->sql); 

			break;


			case "OrgDog"://CREATE RECORD


			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = $_db->real_escape_string($params->org_id);
			} else {
			  $this->org_id = '';
			}

			if(isset($params->number) && ($params->number)) {
			  $this->number = $_db->real_escape_string($params->number);
			} else {
			  $this->number = '';
			}

			if(isset($params->data_start) && ($params->data_start)) {
			  $this->data_start = $_db->real_escape_string($params->data_start);
			} else {
			  $this->data_start = '';
			}

			if(isset($params->data_end) && ($params->data_end)) {
			  $this->data_end = $_db->real_escape_string($params->data_end);
			} else {
			  $this->data_end = '';
			}

			if(isset($params->active) && ($params->active)) {
			  $this->active = (int)($params->active);
			} else {
			  $this->active = '0';
			}

			if(isset($params->tarif_gkal_inshi) && ($params->tarif_gkal_inshi)) {
			  $this->tarif_gkal_inshi = $_db->real_escape_string($params->tarif_gkal_inshi);
			} else {
			  $this->tarif_gkal_inshi = '';
			}

			if(isset($params->tarif_gkal_nasel) && ($params->tarif_gkal_nasel)) {
			  $this->tarif_gkal_nasel = $_db->real_escape_string($params->tarif_gkal_nasel);
			} else {
			  $this->tarif_gkal_nasel = '';
			}

			 $this->sql='INSERT INTO TM_ORG_DOGOVOR SET '
			      .'org_id="'.$this->org_id.'", '
			      .'number="'.$this->number.'", '
			      .'data_start="'.$this->data_start.'", '
			      .'data_end="'.$this->data_end.'", '
			      .'active="'.$this->active.'" '
			     // .'tarif_gkal_inshi="'.$this->tarif_gkal_inshi.'", '
			    //  .'tarif_gkal_nasel="'.$this->tarif_gkal_nasel.'"'
			      .'';
			   //  print_r($this->sql); 

			break;



			case "OrgDogFil":  //CREATE RECORD
			
			if(isset($params->filial_id) && ($params->filial_id)) {
			  $this->filial_id = $_db->real_escape_string($params->filial_id);
			} else {
			  $this->filial_id = '';
			}

			if(isset($params->dog_id) && ($params->dog_id)) {
			  $this->dog_id = $_db->real_escape_string($params->dog_id);
			} else {
			  $this->dog_id = '';
			}

			//CREATE RECORD

$this->sql=' INSERT INTO TM_ORG_FILIAL_DOG 
(filial_id, address_id, raion_id, street_id, house_id, is_flat, sobstv_id_type, sobstv_id_type_name, naznach_type, naznach_type_name, appartment, address, org_id, area, people, rwork_id, rwork_name, dteplomer_id, gvoda, otoplenie, name, dogovor_id, gkal_h_ot, gkal_h_gvs, gkal_year_ot, gkal_year_gvs, vkl_podorg, vkl_otopl, vkl_hvodomer, vkl_gvodomer, vkl_teplomer, tarif_podogrev, tarif_otopl) 
SELECT 
TM_ORG_FILIAL.filial_id, 
TM_ORG_FILIAL.address_id, 
TM_ORG_FILIAL.raion_id, 
TM_ORG_FILIAL.street_id , 
TM_ORG_FILIAL.house_id, 
TM_ORG_FILIAL.is_flat, 
TM_ORG_FILIAL.sobstv_id_type, 
(SELECT SPR_SOBSTV.name FROM SPR_SOBSTV WHERE SPR_SOBSTV.stype_id=TM_ORG_FILIAL.sobstv_id_type) AS sobstv_id_type_name, 
TM_ORG_FILIAL.naznach_type, 
(SELECT SPR_TYPES.name FROM SPR_TYPES WHERE SPR_TYPES.nazn_id=TM_ORG_FILIAL.naznach_type) AS naznach_type_name, 
TM_ORG_FILIAL.appartment, 
TM_ORG_FILIAL.address, 
TM_ORG_FILIAL.org_id, 
TM_ORG_FILIAL.area, 
TM_ORG_FILIAL.people, 
TM_ORG_FILIAL.rwork_id, 
(SELECT SPR_RWORK.name FROM SPR_RWORK WHERE SPR_RWORK.rwork_id=TM_ORG_FILIAL.rwork_id) AS rwork_name, 
TM_ORG_FILIAL.dteplomer_id, 
TM_ORG_FILIAL.gvoda, 
TM_ORG_FILIAL.otoplenie, 
TM_ORG_FILIAL.name, 
'.$this->dog_id.',
TM_ORG_FILIAL.gkal_h_ot, 
TM_ORG_FILIAL.gkal_h_gvs, 
TM_ORG_FILIAL.gkal_year_ot, 
TM_ORG_FILIAL.gkal_year_gvs, 
TM_ORG_FILIAL.vkl_podorg, 
TM_ORG_FILIAL.vkl_otopl, 
TM_ORG_FILIAL.vkl_hvodomer, 
TM_ORG_FILIAL.vkl_gvodomer, 
TM_ORG_FILIAL.vkl_teplomer, 
(SELECT TM_TARIF.tarif_pod FROM TM_TARIF WHERE TM_TARIF.stype_id=TM_ORG_FILIAL.sobstv_id_type LIMIT 1) AS tarif_podogrev,
(SELECT TM_TARIF.tarif_ot FROM TM_TARIF WHERE TM_TARIF.stype_id=TM_ORG_FILIAL.sobstv_id_type LIMIT 1) AS tarif_otopl
FROM 
TM_ORG_FILIAL WHERE TM_ORG_FILIAL.filial_id="'.$this->id.'"';
    // print_r($this->sql); 
			 
			break;



			case "OrgCateg"://CREATE RECORD


			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			 $this->sql='INSERT INTO TM_ORG_CAT SET '
			      .'name="'.$this->name.'"'
			      .'';
			   //  print_r($this->sql); 

			break;


			case "FilNaznCateg"://CREATE RECORD


			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			 $this->sql='INSERT INTO SPR_TYPES SET '
			      .'name="'.$this->name.'"'
			      .'';
			   //  print_r($this->sql); 

			break;


			case "FilSobstvCateg"://CREATE RECORD


			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			 $this->sql='INSERT INTO  SPR_SOBSTV SET '
			      .'name="'.$this->name.'"'
			      .'';
			   //  print_r($this->sql); 

			break;



			case "FilRworkCateg"://CREATE RECORD


			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			 $this->sql='INSERT INTO  SPR_RWORK SET '
			      .'name="'.$this->name.'"'
			      .'';
			   //  print_r($this->sql); 

			break;



			case "OrgDogTarifs"://CREATE RECORD

/*
			if(isset($params->dog_id) && ($params->dog_id)) {
			  $this->dog_id = $_db->real_escape_string($params->dog_id);
			} else {
			  $this->dog_id = '';
			}
*/
			 $this->sql='INSERT INTO TM_TARIF SET '
			      .'stype_name="Новый тариф"'
			      .'';
			   //  print_r($this->sql); 

			break;


			case "OrgServTypes"://CREATE RECORD


			if(isset($params->serv_type_name) && ($params->serv_type_name)) {
			  $this->serv_type_name = $_db->real_escape_string($params->serv_type_name);
			} else {
			  $this->serv_type_name = '';
			}

			 $this->sql='INSERT INTO TM_SERVICES_TYPES SET '
			      .'serv_type_name="'.$this->serv_type_name.'"'
			      .'';
			   //  print_r($this->sql); 

			break;



			case "FilServ"://CREATE RECORD

			 $this->sql='INSERT INTO TM_ORG_FILIAL_SERVICES SET '
			      .'filial_id="'.$this->id.'"'
			      .'';
			   //  print_r($this->sql); 

			break;



			case "Bank"://CREATE RECORD

			 $this->sql='INSERT INTO YISGRAND.BANKS SET bname="Название"';
			   //  print_r($this->sql); 

			break;


			case "Temperature":	//CREATE RECORD

			$this->sql='INSERT INTO YISGRAND.SPR_TEMPERATURE SET `data` = CURDATE()';
			//      print_r($this->sql); 
			break;




			} // END OF SWITCH //CREATE RECORD 


		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);

		//$rows=mysqli_affected_rows($_db);
		$newid= mysqli_insert_id($_db);
//print($newid);
		//if ($rows) {
		$this->results['success'] = true;
		$this->results['new_id'] = mysqli_insert_id($_db);
		//} else {
		//$this->results['success'] = false;
		//}
		return $this->results;



	} // END OF FN CREATE









	public function getResults(stdClass $params)  // ==================== GET RESULTS
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
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
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
		if(isset($params->data) && ($params->data)) {
		  $this->data =$params->data;
		 // $this->data =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$params->data);
		} else {
		  $this->data= date("Ymd");
		}
		if(isset($params->param1) && ($params->param1)) {
		  $this->param1 = $_db->real_escape_string($params->param1);
		} else {
		  $this->param1 = '';
		}

		if(isset($params->param1) && ($params->param2)) {
		  $this->param2 = $_db->real_escape_string($params->param2);
		} else {
		  $this->param2 = '';
		}

		if(isset($params->param3) && ($params->param3)) {
		  $this->param3 = $_db->real_escape_string($params->param3);
		} else {
		  $this->param3 = '';
		}

		if(isset($params->param4) && ($params->param4)) {
		  $this->param4 = $_db->real_escape_string($params->param4);
		} else {
		  $this->param4 = '';
		}

		switch ($this->what) {
		
// GET RESULT

			case "StOrg"://in use			
			      $this->sql='SELECT '
					  .'YISGRAND.TM_ORG.`org_id`, '
					  .'YISGRAND.TM_ORG.`sname` '
	//				  .'YISGRAND.TM_ORG.`fname`, '
					  .' FROM YISGRAND.TM_ORG '
					  .' WHERE 1 ORDER BY YISGRAND.TM_ORG.`sname`';
					  // print_r($this->sql); 
			break;

		   
			case "FmFilial"://in use			
			      $this->sql='SELECT * '
					  .' FROM YISGRAND.TM_ORG_FILIAL '
					  .' WHERE YISGRAND.TM_ORG_FILIAL.filial_id='.$this->filial_id.' LIMIT 1';
					  // print_r($this->sql); 
			break;
			case "FmOrgInfo": //in use			
			      $this->sql='SELECT  '
			      .'org_id, '
			      .'boss, '
			      .'cat_id, '
			      .'edrpou, '
			      .'faddress, '
			      .'fname, '
			     .' gbuh, '
			     .' inn, '
			     .' nds, '
			      .'rwork, '
			     .' sname, '
			     .' statut, '
			     .'DATE_FORMAT(svid_fdata,"%d-%m-%Y") as svid_fdata, '
			     .' svid_nds, '
			     .'DATE_FORMAT(svid_sdata,"%d-%m-%Y") as svid_sdata, '
			     .' uaddress, '
			      .' operator '
			     .' FROM TM_ORG WHERE org_id='.$this->org_id.' LIMIT 1';
			      //print_r($this->sql); 
			break;
			case "OrgPhones":		
			      $this->sql='SELECT YISGRAND.TM_PHONES.`phone_id` ,'
					  .'YISGRAND.TM_PHONES.`org_id` ,'
					  .'YISGRAND.TM_PHONES.`filial_id`,'
					  .'YISGRAND.TM_PHONES.`phone`,'
					  .'YISGRAND.TM_PHONES.`pname`,'
					  .'YISGRAND.TM_ORG_FILIAL.`name` '
					  .' FROM YISGRAND.TM_PHONES '
					  .' LEFT JOIN YISGRAND.TM_ORG_FILIAL '
					  .' ON YISGRAND.TM_PHONES.`filial_id` = YISGRAND.TM_ORG_FILIAL.`filial_id`'
					  .' WHERE YISGRAND.TM_PHONES.`org_id` = '.$this->org_id.' ORDER BY name';
					  //print_r($this->sql); 
			break;
			case "TekNachFilial":			  
			   $this->sql='SELECT filial_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol ,edizm, qty, tarif, sum(nachisleno) as nachisleno, sum(perer) as perer,  sum(itogo) as itogo, sum(oplacheno) as oplacheno,  sum(dolg) as dolg,  hdolg FROM('
				  .'(SELECT 1 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.VODA  WHERE filial_id='.$this->filial_id.' '
				  .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.STOKI  WHERE filial_id='.$this->filial_id.' '
				  .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 3 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,kub+people as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno ,dolg,0 as hdolg FROM YISGRAND.PODOGREV  WHERE filial_id='.$this->filial_id.' '
				  .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 4 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN gkal+gkal_perer=0 THEN "м2" ELSE "Гкал" END as edizm,CASE WHEN gkal+gkal_perer=0 THEN square ELSE gkal+gkal_perer END as qty,tarif,'
				  .'nachisleno-perer as nachisleno,perer,nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg '
				   .'FROM YISGRAND.OTOPLENIE  WHERE filial_id='.$this->filial_id.' '
				    .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'")  ORDER BY data DESC LIMIT 1 )'
				  .' ORDER BY data DESC ,p) AS a group by p with rollup';
			//print($this->sql); 
			break;
/*
			case "TekNachFilial":			  
			   $this->sql='SELECT filial_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol ,edizm, qty, tarif, sum(nachisleno) as nachisleno, sum(perer) as perer,  sum(itogo) as itogo, sum(oplacheno) as oplacheno,  sum(dolg) as dolg,  hdolg FROM('
				  .'(SELECT 1 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.VODA  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.STOKI  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 ) UNION '
				  .' (SELECT 3 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,kub+people as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno ,dolg,0 as hdolg FROM YISGRAND.PODOGREV  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 ) UNION '
				  .' (SELECT 4 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN gkal=0 THEN "м2" ELSE "Гкал" END as edizm,CASE WHEN gkal=0 THEN square ELSE gkal END as qty,CASE WHEN gkal=0 THEN tarif ELSE tarif END as tarif,'
				  .'nachisleno-perer as nachisleno,perer,nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg '
				   .'FROM YISGRAND.OTOPLENIE  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 )'
				  .' ORDER BY data DESC ,p) AS a group by p with rollup';
			//print($this->sql); 
			break;
*/
			case "FilialToDog":			
			      $this->sql='SELECT * FROM TM_ORG_FILIAL WHERE TM_ORG_FILIAL.filial_id="'.$this->id.'" LIMIT 1';
			      //print_r($this->sql); 
			break;

			case "OrgDog":			
			      $this->sql='SELECT * FROM TM_ORG_DOGOVOR WHERE TM_ORG_DOGOVOR.org_id='.$this->id.' ORDER BY data_start';
			      //print_r($this->sql); 
			break;


			case "OrgDogFil":			
			      $this->sql='SELECT * FROM TM_ORG_FILIAL_DOG WHERE TM_ORG_FILIAL_DOG.dogovor_id='.$this->id.' ORDER BY name';
			      //print_r($this->sql); 
			break;

			case "OrgCateg":			
			      $this->sql= 'SELECT `sobstv_id` AS cat_id, name FROM SPR_SOBSTV ORDER BY `sobstv_id`';
			      //'SELECT * FROM SPR_SOBSTV ORDER BY `sobstv_id` DESC';
			      //print_r($this->sql); 
			break;

			case "FilNaznCateg":			
			      $this->sql='SELECT * FROM SPR_TYPES ';
			      //print_r($this->sql); 
			break;


			case "FilSobstvCateg":			
			      $this->sql='SELECT * FROM SPR_SOBSTV ';
			      //print_r($this->sql); 
			break;

			case "FilRworkCateg":			
			      $this->sql='SELECT * FROM SPR_RWORK ';
			      //print_r($this->sql); 
			break;

			case "OrgDogTarifs":			


			$this->sql='SELECT * FROM TM_TARIF ORDER BY `tarif_id` DESC';
			     // print_r($this->sql); 
			break;


			case "OrgServTypes":			
			      $this->sql='SELECT * FROM  TM_SERVICES_TYPES ORDER BY `serv_type_id` DESC';
			      //print_r($this->sql); 
			break;

			

			case "FilServ":			
			      $this->sql='SELECT * FROM TM_ORG_FILIAL_SERVICES WHERE filial_id="'.$this->id.'"ORDER BY `fsevr_id` DESC' ;
			      //print_r($this->sql); 
			break;


			case "Bank":			
			      $this->sql='SELECT * FROM YISGRAND.BANKS ORDER BY bname';
			     // print_r($this->sql); 
			break;
 //GET RESULT
			case "Temperature":			
			      $this->sql='SELECT * FROM YISGRAND.SPR_TEMPERATURE ORDER BY `data` DESC';
			     // print_r($this->sql); 
			break;

		} // End of Switch ($what)
		
	
		

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}

		$this->results['data']	= $this->res;
		
		return $this->results;
	} // END OF GET RESULTS

	public function updateRecords(stdclass $params)   // ================================= UPDATE RECORDS

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
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
		}

//print_r($this->id.$this->login);
		switch ($this->what) {
		
			case "FmOrgInfo": //UPDATE RECORDS


			      if(isset($params->boss) && ($params->boss)) {
				$this->boss = $_db->real_escape_string($params->boss);
			      } else {
				$this->boss = '';
			      }

			      if(isset($params->cat_id) && ($params->cat_id)) {
				$this->cat_id = $_db->real_escape_string($params->cat_id);
			      } else {
				$this->cat_id = '';
			      }

			      if(isset($params->edrpou) && ($params->edrpou)) {
				$this->edrpou = $_db->real_escape_string($params->edrpou);
			      } else {
				$this->edrpou = '';
			      }

			      if(isset($params->faddress) && ($params->faddress)) {
				$this->faddress = $_db->real_escape_string($params->faddress);
			      } else {
				$this->faddress = '';
			      }
		      
			      if(isset($params->fname) && ($params->fname)) {
				$this->fname = $_db->real_escape_string($params->fname);
			      } else {
				$this->fname = '';
			      }

			      if(isset($params->gbuh) && ($params->gbuh)) {
				$this->gbuh = $_db->real_escape_string($params->gbuh);
			      } else {
				$this->gbuh = '';
			      }

			      if(isset($params->inn) && ($params->inn)) {
				$this->inn = $_db->real_escape_string($params->inn);
			      } else {
				$this->inn = '';
			      }

			      if(isset($params->nds) && ($params->nds)) {
				$this->nds = $_db->real_escape_string($params->nds);
			      } else {
				$this->nds = '';
			      }

			      if(isset($params->org_id) && ($params->org_id)) {
				$this->org_id = $_db->real_escape_string($params->org_id);
			      } else {
				$this->org_id = '';
			      }

			      if(isset($params->rwork_id) && ($params->rwork_id)) {
				$this->rwork_id = $_db->real_escape_string($params->rwork_id);
			      } else {
				$this->rwork_id = '';
			      }

			      if(isset($params->sname) && ($params->sname)) {
				$this->sname = $_db->real_escape_string($params->sname);
			      } else {
				$this->sname = '';
			      }
//print_r($this->sname);
			      if(isset($params->statut) && ($params->statut)) {
				$this->statut = $_db->real_escape_string($params->statut);
			      } else {
				$this->statut = '';
			      }


			      if(isset($params->svid_fdata) && ($params->svid_fdata)) {
				$this->svid_fdata = $_db->real_escape_string($params->svid_fdata);
			      } else {
				$this->svid_fdata = '';
			      }

			      if(isset($params->svid_nds) && ($params->svid_nds)) {
				$this->svid_nds = $_db->real_escape_string($params->svid_nds);
			      } else {
				$this->svid_nds = '';
			      }

			      if(isset($params->svid_sdata) && ($params->svid_sdata)) {
				$this->svid_sdata = $_db->real_escape_string($params->svid_sdata);
			      } else {
				$this->svid_sdata = '';
			      }

			      if(isset($params->uaddress) && ($params->uaddress)) {
				$this->uaddress = $_db->real_escape_string($params->uaddress);
			      } else {
				$this->uaddress = '';
			      }

			      $this->sql='UPDATE TM_ORG SET boss="'.$this->boss.'", cat_id="'.$this->cat_id.'", edrpou="'.$this->edrpou.'", faddress="'.$this->faddress.'", fname="'.$this->fname.'", gbuh="'.$this->gbuh.'", inn="'.$this->inn.'", nds="'.$this->nds.'", rwork_id="'.$this->rwork_id.'", sname="'.$this->sname.'", statut="'.$this->statut.'", svid_fdata="'.$this->svid_fdata.'", svid_nds="'.$this->svid_nds.'", svid_sdata="'.$this->svid_sdata.'", uaddress="'.$this->uaddress.'" WHERE org_id='.$this->org_id.' LIMIT 1';
			    // print_r($this->sql); 
			      break;




			case "OrgDog": //UPDATE RECORDS
			

			if(isset($params->dog_id) && ($params->dog_id)) {
			  $this->dog_id = $_db->real_escape_string($params->dog_id);
			} else {
			  $this->dog_id = '';
			}
/*
			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = $_db->real_escape_string($params->org_id);
			} else {
			  $this->org_id = '';
			}
*/
			if(isset($params->number) && ($params->number)) {
			  $this->number = $_db->real_escape_string($params->number);
			} else {
			  $this->number = '';
			}

			if(isset($params->data_start) && ($params->data_start)) {
			  $this->data_start = $_db->real_escape_string($params->data_start);
			} else {
			  $this->data_start = '';
			}

			if(isset($params->data_end) && ($params->data_end)) {
			  $this->data_end = $_db->real_escape_string($params->data_end);
			} else {
			  $this->data_end = '';
			}

			if(isset($params->active) && ($params->active)) {
			  $this->active = (int)($params->active);
			} else {
			  $this->active = 0;
			}

			if(isset($params->tarif_gkal_inshi) && ($params->tarif_gkal_inshi)) {
			  $this->tarif_gkal_inshi = $_db->real_escape_string($params->tarif_gkal_inshi);
			} else {
			  $this->tarif_gkal_inshi = '';
			}

			if(isset($params->tarif_gkal_nasel) && ($params->tarif_gkal_nasel)) {
			  $this->tarif_gkal_nasel = $_db->real_escape_string($params->tarif_gkal_nasel);
			} else {
			  $this->tarif_gkal_nasel = '';
			}
			
			      //UPDATE RECORDS
			      $this->sql='UPDATE TM_ORG_DOGOVOR SET '
			      .'number="'.$this->number.'", '
			      .'data_start="'.$this->data_start.'", '
			      .'data_end="'.$this->data_end.'", '
			      .'active="'.$this->active.'", '
			      .'tarif_gkal_inshi="'.$this->tarif_gkal_inshi.'", '
			      .'tarif_gkal_nasel="'.$this->tarif_gkal_nasel.'"'
			      .' WHERE dog_id="'.$this->dog_id.'" LIMIT 1';
			   //  print_r($this->sql); 
			     
		      break;



			case "OrgPhones":

			if(isset($params->phone) && ($params->phone)) {
			  $this->phone = $_db->real_escape_string($params->phone);
			} else {
			  $this->phone = '';
			}

			if(isset($params->pname) && ($params->pname)) {
			  $this->pname = $_db->real_escape_string($params->pname);
			} else {
			  $this->pname = '';
			}

			if(isset($params->phone_id) && ($params->phone_id)) {
			  $this->phone_id = $_db->real_escape_string($params->phone_id);
			} else {
			  $this->phone_id = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE TM_PHONES SET '
			      .'phone="'.$this->phone.'", '
			      .'pname="'.$this->pname.'" '
			      .'WHERE phone_id="'.$this->phone_id.'" '.' LIMIT 1';

		//echo($this->sql); 

			break;



			case "OrgCateg":

			if(isset($params->cat_id) && ($params->cat_id)) {
			  $this->cat_id = $_db->real_escape_string($params->cat_id);
			} else {
			  $this->cat_id = '';
			}

			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE TM_ORG_CAT SET '
			      .'name="'.$this->name.'" '
			      .'WHERE cat_id="'.$this->cat_id.'" '.' LIMIT 1';

		//echo($this->sql); FilNaznCateg

			break;



			case "FilNaznCateg":

			if(isset($params->nazn_id) && ($params->nazn_id)) {
			  $this->nazn_id = $_db->real_escape_string($params->nazn_id);
			} else {
			  $this->nazn_id = '';
			}

			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE SPR_TYPES SET '
			      .'name="'.$this->name.'" '
			      .'WHERE nazn_id="'.$this->nazn_id.'" '.' LIMIT 1';

		//echo($this->sql); 

			break;


			case "FilSobstvCateg":

			if(isset($params->stype_id) && ($params->stype_id)) {
			  $this->stype_id = $_db->real_escape_string($params->stype_id);
			} else {
			  $this->stype_id = '';
			}

			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE SPR_SOBSTV SET '
			      .'name="'.$this->name.'" '
			      .'WHERE stype_id="'.$this->stype_id.'" '.' LIMIT 1';

		//echo($this->sql); 

			break;


			case "FilRworkCateg":

			if(isset($params->rwork_id) && ($params->rwork_id)) {
			  $this->rwork_id = $_db->real_escape_string($params->rwork_id);
			} else {
			  $this->rwork_id = '';
			}

			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE SPR_RWORK SET '
			      .'name="'.$this->name.'" '
			      .'WHERE rwork_id="'.$this->rwork_id.'" '.' LIMIT 1';

		//echo($this->sql); OrgDogTarifs

			break;


			case "OrgDogTarifs":

			if(isset($params->tarif_id) && ($params->tarif_id)) {
			  $this->tarif_id = $_db->real_escape_string($params->tarif_id);
			} else {
			  $this->tarif_id = '';
			}

			if(isset($params->stype_id) && ($params->stype_id)) {
			  $this->stype_id = $_db->real_escape_string($params->stype_id);
			} else {
			  $this->stype_id = '';
			}


			if(isset($params->stype_name) && ($params->stype_name)) {
			  $this->stype_name = $_db->real_escape_string($params->stype_name);
			} else {
			  $this->stype_name = '';
			}

			if(isset($params->tarif_pod) && ($params->tarif_pod)) {
			  $this->tarif_pod = $_db->real_escape_string($params->tarif_pod);
			} else {
			  $this->tarif_pod = '';
			}

			if(isset($params->tarif_ot) && ($params->tarif_ot)) {
			  $this->tarif_ot = $_db->real_escape_string($params->tarif_ot);
			} else {
			  $this->tarif_ot = '';
			}


			//UPDATE RECORDS
			$this->sql='UPDATE TM_TARIF SET '
			      .'stype_id="'.$this->stype_id.'", '
			      .'stype_name=(SELECT SPR_SOBSTV.name from SPR_SOBSTV WHERE stype_id="'.$this->stype_id.'") ,'
			      .'tarif_pod="'.$this->tarif_pod.'", '
			      .'tarif_ot="'.$this->tarif_ot.'" '
			      .'WHERE tarif_id="'.$this->tarif_id.'" '.' LIMIT 1';

		//echo($this->sql); 

			break;


			case "OrgServTypes":

			if(isset($params->serv_type_id) && ($params->serv_type_id)) {
			  $this->serv_type_id = $_db->real_escape_string($params->serv_type_id);
			} else {
			  $this->serv_type_id = '';
			}

			if(isset($params->serv_type_name) && ($params->serv_type_name)) {
			  $this->serv_type_name = $_db->real_escape_string($params->serv_type_name);
			} else {
			  $this->serv_type_name = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE TM_SERVICES_TYPES SET '
			      .'serv_type_name="'.$this->serv_type_name.'" '
			      .'WHERE serv_type_id="'.$this->serv_type_id.'" '.' LIMIT 1';

		//echo($this->sql); 

			break;


			case "FilServ":

			if(isset($params->fsevr_id) && ($params->fsevr_id)) {
			  $this->fsevr_id = $_db->real_escape_string($params->fsevr_id);
			} else {
			  $this->fsevr_id = '';
			}

			if(isset($params->serv_type_id) && ($params->serv_type_id)) {
			  $this->serv_type_id = $_db->real_escape_string($params->serv_type_id);
			} else {
			  $this->serv_type_id = '';
			}


			if(isset($params->serv_volume1) && ($params->serv_volume1)) {
			  $this->serv_volume1 = $_db->real_escape_string($params->serv_volume1);
			} else {
			  $this->serv_volume1 = '';
			}

			if(isset($params->serv_volume2) && ($params->serv_volume2)) {
			  $this->serv_volume2 = $_db->real_escape_string($params->serv_volume2);
			} else {
			  $this->serv_volume2 = '';
			}

			if(isset($params->serv_volume3) && ($params->serv_volume3)) {
			  $this->serv_volume3 = $_db->real_escape_string($params->serv_volume3);
			} else {
			  $this->serv_volume3 = '';
			}

			if(isset($params->serv_volume4) && ($params->serv_volume4)) {
			  $this->serv_volume4 = $_db->real_escape_string($params->serv_volume4);
			} else {
			  $this->serv_volume4 = '';
			}

			//UPDATE RECORDS
			$this->sql='UPDATE TM_SERVICES_TYPES SET '
			      .'serv_type_id="'.$this->serv_type_id.'", '
			      .'serv_volume1="'.$this->serv_volume1.'", '
			      .'serv_volume2="'.$this->serv_volume2.'", '
			      .'serv_volume3="'.$this->serv_volume3.'", '
			      .'serv_volume4="'.$this->serv_volume4.'" '
			      .'WHERE fsevr_id="'.$this->fsevr_id.'" '.' LIMIT 1';

	
			break;
			case "Bank":

			if(isset($params->bank_id) && ($params->bank_id)) {
			  $this->bank_id = $_db->real_escape_string($params->bank_id);
			} else {
			  $this->bank_id = '';
			}

			if(isset($params->bname) && ($params->bname)) {
			  $this->bname = $_db->real_escape_string($params->bname);
			} else {
			  $this->bname = '';
			}

			if(isset($params->mfo) && ($params->mfo)) {
			  $this->mfo = $_db->real_escape_string($params->mfo);
			} else {
			  $this->mfo = '';
			}

			if(isset($params->city) && ($params->city)) {
			  $this->city = $_db->real_escape_string($params->city);
			} else {
			  $this->city = '';
			}


			//UPDATE RECORDS
			$this->sql='UPDATE YISGRAND.BANKS SET '
			      .'bname="'.$this->bname.'", '
			      .'mfo="'.$this->mfo.'", '
			      .'city="'.$this->city.'" '
			      .'WHERE bank_id="'.$this->bank_id.'" '.' LIMIT 1';

			   //  print_r($this->sql); 
			break;


			//UPDATE RECORDS
			case "Temperature":	


		if(isset($params->temp) && ($params->temp)) {

		if (is_float($params->temp)) {  $this->temp =  $params->temp;} else {
		  $this->temp= (int) $params->temp;}
							      } else {
		  $this->temp= 0;
		}


	      if(isset($params->data) && ($params->data)) {
		  $this->data =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$1-$2-$3",$params->data);
		} else {
		  $this->data= '';
		}
		
			$this->sql='UPDATE YISGRAND.SPR_TEMPERATURE SET `temp`='.$this->temp.' WHERE EXTRACT(YEAR_MONTH FROM `data`)= EXTRACT(YEAR_MONTH FROM "'.$this->data.'") LIMIT 1';
			//      print_r($this->sql); 
			break;


		} // End of Switch ($what)  


		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);
	
		$rows=mysqli_affected_rows($_db);
//$results = array();
		if ($rows) {
		
		$results->success	= true;

		} else {
$results->success	= false;
}
return $results;
	} // END OF UPDATE






	
		public function destroyRecord(stdClass $params)      // ================================= DESTROY RECORD
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
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
		}


		$qtype=''; // сброс типа запроса
		$important=null; // сброс важности запроса

		switch ($this->what) {
		
			
			case "FmOrgInfo":

			$this->sql='CALL YISGRAND.delete_org('.$this->id.')';
			$qtype='proc';
			$important=null;		
			$important[0]=4; // Запрос по которому ставится Успех
			break;


			case "FmFilial":

			$this->sql[0]='DELETE FROM TM_ORG_FILIAL WHERE TM_ORG_FILIAL.filial_id='.$this->id.''; // Филиал
			$this->sql[1]='DELETE FROM TM_PHONES WHERE TM_PHONES.filial_id='.$this->id.''; // Телефоны филиала
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "OrgPhones":


			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = $_db->real_escape_string($params->org_id);
			} else {
			  $this->org_id = '';
			}

			if(isset($params->filial_id) && ($params->filial_id)) {
			  $this->filial_id = $_db->real_escape_string($params->filial_id);
			} else {
			  $this->filial_id = '';
			}

			if(isset($params->phone) && ($params->phone)) {
			  $this->phone = $_db->real_escape_string($params->phone);
			} else {
			  $this->phone = '';
			}

			if(isset($params->phone_id) && ($params->phone_id)) {
			  $this->phone_id = $_db->real_escape_string($params->phone_id);
			} else {
			  $this->phone_id = '';
			}

			if(isset($params->pname) && ($params->pname)) {
			  $this->pname = $_db->real_escape_string($params->pname);
			} else {
			  $this->pname = '';
			}

			 $this->sql[0]='DELETE FROM TM_PHONES WHERE '
			      .'phone_id="'.$this->phone_id.'" '
			      .' LIMIT 1 ';
			//echo($this->sql[0]); 
			$important=null;		
			$important[0]=0; // Запрос по которому ставится Успех

			break;


			case "OrgDog": 
			
			if(isset($params->dog_id) && ($params->dog_id)) {
			  $this->dog_id = $_db->real_escape_string($params->dog_id);
			} else {
			  $this->dog_id = '';
			}

			$this->sql[0]='DELETE FROM TM_ORG_DOGOVOR WHERE '
			      .'dog_id="'.$this->dog_id.'"'.' LIMIT 1 ';
			$this->sql[1]='DELETE FROM TM_ORG_FILIAL_DOG WHERE TM_ORG_FILIAL_DOG.dogovor_id='.$this->dog_id.''; // Филиалы
			$this->sql[2]='DELETE FROM TM_DOG_TARIFS WHERE TM_DOG_TARIFS.dog_id='.$this->dog_id.''; // тарифы
			      
			$important=null;		
			$important[0]=0; // Запрос по которому ставится Успех
			   //  print_r($this->sql); 
			     
			 break;


			case "OrgDogFil":

			if(isset($params->fd_id) && ($params->fd_id)) {
			  $this->fd_id = $_db->real_escape_string($params->fd_id);
			} else {
			  $this->fd_id = '';
			}


			$this->sql[0]='DELETE FROM TM_ORG_FILIAL_DOG WHERE TM_ORG_FILIAL_DOG.fd_id='.$this->fd_id.' LIMIT 1'; // Филиал
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;



			case "OrgCateg":

			if(isset($params->cat_id) && ($params->cat_id)) {
			  $this->cat_id = $_db->real_escape_string($params->cat_id);
			} else {
			  $this->cat_id = '';
			}


			$this->sql[0]='DELETE FROM TM_ORG_CAT WHERE TM_ORG_CAT.cat_id='.$this->cat_id.' LIMIT 1'; // Категория орг.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "FilNaznCateg":

			if(isset($params->nazn_id) && ($params->nazn_id)) {
			  $this->nazn_id = $_db->real_escape_string($params->nazn_id);
			} else {
			  $this->nazn_id = '';
			}


			$this->sql[0]='DELETE FROM SPR_TYPES WHERE SPR_TYPES.nazn_id='.$this->nazn_id.' LIMIT 1'; // Категория назначений филиала.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "FilSobstvCateg":

			if(isset($params->stype_id) && ($params->stype_id)) {
			  $this->stype_id = $_db->real_escape_string($params->stype_id);
			} else {
			  $this->stype_id = '';
			}


			$this->sql[0]='DELETE FROM  SPR_SOBSTV WHERE  SPR_SOBSTV.stype_id='.$this->stype_id.' LIMIT 1'; // Категория типов собственности филиала.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "FilRworkCateg":

			if(isset($params->rwork_id) && ($params->rwork_id)) {
			  $this->rwork_id = $_db->real_escape_string($params->rwork_id);
			} else {
			  $this->rwork_id = '';
			}

			$this->sql[0]='DELETE FROM SPR_RWORK WHERE  SPR_RWORK.rwork_id='.$this->rwork_id.' LIMIT 1'; // Категория типов режимов работы филиала.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "OrgDogTarifs":

			if(isset($params->tarif_id) && ($params->tarif_id)) {
			  $this->tarif_id = $_db->real_escape_string($params->tarif_id);
			} else {
			  $this->tarif_id = '';
			}

			$this->sql[0]='DELETE FROM TM_TARIF WHERE tarif_id='.$this->tarif_id.' LIMIT 1'; // Тариф по договору.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "OrgServTypes":

			if(isset($params->serv_type_id) && ($params->serv_type_id)) {
			  $this->serv_type_id = $_db->real_escape_string($params->serv_type_id);
			} else {
			  $this->serv_type_id = '';
			}
			
			if ($this->serv_type_id==1 || $this->serv_type_id==2) {die('Connect Error (Restricted to remove)');} else {
			$this->sql[0]='DELETE FROM TM_SERVICES_TYPES WHERE  TM_SERVICES_TYPES.serv_type_id='.$this->serv_type_id.' LIMIT 1';} // Виды услуг.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "FilServ":

			if(isset($params->fsevr_id) && ($params->fsevr_id)) {
			  $this->fsevr_id = $_db->real_escape_string($params->fsevr_id);
			} else {
			  $this->fsevr_id = '';
			}
			

			$this->sql[0]='DELETE FROM TM_ORG_FILIAL_SERVICES WHERE  TM_ORG_FILIAL_SERVICES.fsevr_id='.$this->fsevr_id.' LIMIT 1'; // Услуги филиалу.
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;



			case "Bank":

			if(isset($params->bank_id) && ($params->bank_id)) {
			  $this->bank_id = $_db->real_escape_string($params->bank_id);
			} else {
			  $this->bank_id = '';
			}
			

			$this->sql[0]='DELETE FROM YISGRAND.BANKS WHERE bank_id='.$this->bank_id.' LIMIT 1'; // .
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


			case "Temperature":	

	      if(isset($params->data) && ($params->data)) {
		  $this->data =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$1-$2-$3",$params->data);
		} else {
		  $this->data= '';
		}
		
			$this->sql[0]='DELETE FROM YISGRAND.SPR_TEMPERATURE WHERE EXTRACT(YEAR_MONTH FROM `data`)= EXTRACT(YEAR_MONTH FROM "'.$this->data.'") LIMIT 1';
			$important[0]=0; // Запрос по которому ставится Успех
			$qtype='query';
			//      print_r($this->sql); 
			break;




		} // End of Switch ($what)  

if ($qtype=='proc') {

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);
		$this->sql_callback='SELECT @success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		return $this->results;

		}

} else {

		$this->result = $_db->query($this->sql[0]) or die('Connect Error  in '.$this->what. ' (' . $this->sql[0]. ') ' . $_db->connect_error);
		$rows[0]=mysqli_affected_rows($_db);

/*		$i = 0;
		do { // удаляем все данные
		//print_r($this->sql[$i]);
		$this->result = $_db->query($this->sql[$i]) or die('Connect Error  in '.$this->what. ' (' . $this->sql[$i]. ') ' . $_db->connect_error);
		$rows[$i]=mysqli_affected_rows($_db);
		$i ++;
		} while ($this->sql[$i]);*/

		if ($rows[$important[0]]) {
		$this->results['success'] = true;
		} else {
		$this->results['success'] = false;
		}
		

return $this->results;
	}
	
		//$results->success = true;
		//return $results;

		} // END OF DESTROY METHOD
public function Org(stdClass $params)
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

			if(isset($params->boss) && ($params->boss)) {
			  $this->boss = $_db->real_escape_string($params->boss);
			} else {
			  $this->boss = '';
			}
			if(isset($params->what) && ($params->what)) {
			  $this->what = $_db->real_escape_string($params->what);
			} else {
			  $this->what ="";
			}
			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = (int) $params->org_id;
			} else {
			  $this->org_id = 0;
			}
			if(isset($params->cat_id) && ($params->cat_id)) {
			  $this->cat_id = (int) $params->cat_id;
			} else {
			  $this->cat_id = 0;
			}

			if(isset($params->edrpou) && ($params->edrpou)) {
			  $this->edrpou = $params->edrpou;
			} else {
			  $this->edrpou = "";
			}

			if(isset($params->faddress) && ($params->faddress)) {
			  $this->faddress = $_db->real_escape_string($params->faddress);
			} else {
			  $this->faddress = '';
			}
		
			if(isset($params->fname) && ($params->fname)) {
			  $this->fname = $_db->real_escape_string($params->fname);
			} else {
			  $this->fname = '';
			}

			if(isset($params->gbuh) && ($params->gbuh)) {
			  $this->gbuh = $_db->real_escape_string($params->gbuh);
			} else {
			  $this->gbuh = '';
			}

			if(isset($params->inn) && ($params->inn)) {
			  $this->inn =  $params->inn;
			} else {
			  $this->inn = "";
			}

			if(isset($params->nds) && ($params->nds)) {
			  $this->nds = (int) $params->nds;
			} else {
			  $this->nds = 0;
			}
			
			if(isset($params->rwork) && ($params->rwork)) {
			  $this->rwork = $_db->real_escape_string($params->rwork);
			} else {
			  $this->rwork = '';
			}

			if(isset($params->sname) && ($params->sname)) {
			  $this->sname = $_db->real_escape_string($params->sname);
			} else {
			  $this->sname = '';
			}

			if(isset($params->statut) && ($params->statut)) {
			  $this->statut = $_db->real_escape_string($params->statut);
			} else {
			  $this->statut = '';
			}


			if(isset($params->svid_fdata) && ($params->svid_fdata)) {
			  $this->svid_fdata =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$params->svid_fdata);
			} else {
			  $this->svid_fdata = '';
			}

			if(isset($params->svid_nds) && ($params->svid_nds)) {
			  $this->svid_nds = $_db->real_escape_string($params->svid_nds);
			} else {
			  $this->svid_nds = '';
			}

			if(isset($params->svid_sdata) && ($params->svid_sdata)) {
			  $this->svid_sdata = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$params->svid_sdata);
			} else {
			  $this->svid_sdata = '';
			}

			if(isset($params->uaddress) && ($params->uaddress)) {
			  $this->uaddress = $_db->real_escape_string($params->uaddress);
			} else {
			  $this->uaddress = '';
			}

		switch ($this->what) {
			case "addOrg":
			$this->sql='CALL YISGRAND.add_org('.$this->cat_id.',"'.$this->boss.'","'.$this->gbuh.'","'.$this->sname.'","'.$this->fname.'","'.$this->uaddress.'",'
						.'"'.$this->faddress.'","'.$this->statut.'","'.$this->svid_sdata.'","'.$this->svid_fdata.'",'
						.''.$this->nds.',"'.$this->svid_nds.'","'.$this->edrpou.'","'.$this->rwork.'",'
						.'"'.$this->inn.'",@org_id,@success,@msg)';
						//print($this->sql);
			break;
			case "updateOrg":
			$this->sql='CALL YISGRAND.update_org('.$this->org_id.','.$this->cat_id.',"'.$this->boss.'","'.$this->gbuh.'","'.$this->sname.'","'.$this->fname.'","'.$this->uaddress.'",'
						.'"'.$this->faddress.'","'.$this->statut.'","'.$this->svid_sdata.'","'.$this->svid_fdata.'",'
						.''.$this->nds.',"'.$this->svid_nds.'","'.$this->edrpou.'","'.$this->rwork.'","'.$this->inn.'",@success,@msg)';
						//print($this->sql);
			break;
			case "deleteOrg":
			$this->sql='CALL YISGRAND.delete_org('.$this->org_id.',@success,@msg)';
						//print($this->sql);
			break;
		}
			$this->result = $_db->query($this->sql) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
			$this->sql_callback='SELECT @org_id,@success,@msg';	
			$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['org_id'] = $this->row['@org_id'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}
			
		return $this->results;

	}
	public function Filial(stdClass $params)
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
			  $this->what ="";
			}
			if(isset($params->address_id) && ($params->address_id)) {
			  $this->address_id = (int) $params->address_id;
			} else {
			  $this->address_id = 0;
			}
			if(isset($params->raion_id) && ($params->raion_id)) {
			  $this->raion_id = (int) $params->raion_id;
			} else {
			  $this->raion_id = 0;
			}
			if(isset($params->filial_id) && ($params->filial_id)) {
			  $this->filial_id = (int) $params->filial_id;
			} else {
			  $this->filial_id = 0;
			}
			if(isset($params->street_id) && ($params->street_id)) {
			  $this->street_id = (int) $params->street_id;
			} else {
			  $this->street_id = 0;
			}
			if(isset($params->house_id) && ($params->house_id)) {
			  $this->house_id =(int) $params->house_id;
			} else {
			  $this->house_id = 0;
			}
			if(isset($params->is_flat) && ($params->is_flat)) {
			  $this->is_flat =(int) $params->is_flat;
			} else {
			  $this->is_flat = 0;
			}
			if(isset($params->sobstv_id) && ($params->sobstv_id)) {
			  $this->sobstv_id = (int) $params->sobstv_id;
			} else {
			  $this->sobstv_id = 0;
			}
			if(isset($params->type_id) && ($params->type_id)) {
			  $this->type_id =(int) $params->type_id;
			} else {
			  $this->type_id = 0;
			}
			if(isset($params->typeh_id) && ($params->typeh_id)) {
			  $this->typeh_id =(int) $params->typeh_id;
			} else {
			  $this->typeh_id = 0;
			}
			if(isset($params->appartment) && ($params->appartment)) {
			  $this->appartment = $_db->real_escape_string($params->appartment);
			} else {
			  $this->appartment = '';
			}
			if(isset($params->address) && ($params->address)) {
			  $this->address = $_db->real_escape_string($params->address);
			} else {
			  $this->address = '';
			}
			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = (int) $params->org_id;
			} else {
			  $this->org_id = 0;
			}
			if(isset($params->area) && ($params->area)) {
			  $this->area = $params->area;
			} else {
			  $this->area = 0;
			}
			if(isset($params->people) && ($params->people)) {
			  $this->people = (int) $params->people;
			} else {
			  $this->people = 0;
			}
			if(isset($params->rwork_id) && ($params->rwork_id)) {
			  $this->rwork_id =(int) $params->rwork_id;
			} else {
			  $this->rwork_id = 0;
			}
			if(isset($params->dteplomer_id) && ($params->dteplomer_id)) {
			  $this->dteplomer_id = (int) $params->dteplomer_id;
			} else {
			  $this->dteplomer_id = 0;
			}
			if(isset($params->dteplomer) && ($params->dteplomer)) {
			  $this->dteplomer = (int) $params->dteplomer;
			} else {
			  $this->dteplomer = 0;
			}
			if(isset($params->fname) && ($params->fname)) {
			  $this->fname = $_db->real_escape_string($params->fname);
			} else {
			  $this->fname = '';
			}
			if(isset($params->name) && ($params->name)) {
			  $this->name = $_db->real_escape_string($params->name);
			} else {
			  $this->name = '';
			}
			if(isset($params->visota) && ($params->visota)) {
			  $this->visota = $params->visota;
			} else {
			  $this->visota = 0;
			}			
			if(isset($params->dogovor_id) && ($params->dogovor_id)) {
			  $this->dogovor_id = (int) $params->dogovor_id;
			} else {
			  $this->dogovor_id = 0;
			}			
			
			if(isset($params->vkl_xvoda) && ($params->vkl_xvoda)) {
			  $this->vkl_xvoda = (int) $params->vkl_xvoda;
			} else {
			  $this->vkl_xvoda = 0;
			}
			if(isset($params->vkl_stoki) && ($params->vkl_stoki)) {
			  $this->vkl_stoki =(int) $params->vkl_stoki;
			} else {
			  $this->vkl_stoki = 0;
			}
			if(isset($params->vkl_gvoda) && ($params->vkl_gvoda)) {
			  $this->vkl_gvoda = (int) $params->vkl_gvoda;
			} else {
			  $this->vkl_gvoda = 0;
			}
			if(isset($params->vkl_otopl) && ($params->vkl_otopl)) {
			  $this->vkl_otopl =(int) $params->vkl_otopl;
			} else {
			  $this->vkl_otopl = 0;
			}
			if(isset($params->xvodomer) && ($params->xvodomer)) {
			  $this->xvodomer =(int) $params->xvodomer;
			} else {
			  $this->xvodomer = 0;
			}
			if(isset($params->gvodomer) && ($params->gvodomer)) {
			  $this->gvodomer =(int) $params->gvodomer;
			} else {
			  $this->gvodomer = 0;
			}
			if(isset($params->teplomer) && ($params->teplomer)) {
			  $this->teplomer = (int) $params->teplomer;
			} else {
			  $this->teplomer = 0;
			}			
			if(isset($params->nrx_gvs_d) && ($params->nrx_gvs_d)) {
			  $this->nrx_gvs_d = $params->nrx_gvs_d;
			} else {
			  $this->nrx_gvs_d = 0;
			}

		switch ($this->what) {
			case "addFilial": /* обновлена: добавлен typeh_id */
			$this->sql='CALL YISGRAND.add_filial('.$this->org_id.','.$this->raion_id.','.$this->street_id.','.$this->house_id.','.$this->address_id.','
						.'"'.$this->address.'","'.$this->appartment.'",'.$this->is_flat.','.$this->sobstv_id.','.$this->type_id.','
						.''.$this->typeh_id.','.$this->area.','.$this->visota.','.$this->people.','.$this->rwork_id.','.$this->dteplomer.','
						.''.$this->dteplomer_id.',"'.$this->fname.'","'.$this->name.'",'.$this->vkl_otopl.','.$this->vkl_xvoda.','.$this->vkl_stoki.','
						.''.$this->vkl_gvoda.','.$this->gvodomer.','.$this->xvodomer.','.$this->teplomer.','.$this->nrx_gvs_d.',@filial_id,@success,@msg)';
						//print($this->sql);
			break;
			case "updateFilial": /* обновлена: добавлен typeh_id */
			$this->sql='CALL YISGRAND.update_filial('.$this->filial_id.','.$this->org_id.','.$this->raion_id.','.$this->street_id.','.$this->house_id.','.$this->address_id.','
						.'"'.$this->address.'","'.$this->appartment.'",'.$this->is_flat.','.$this->sobstv_id.','.$this->type_id.','
						.''.$this->typeh_id.','.$this->area.','.$this->visota.','.$this->people.','.$this->rwork_id.','.$this->dteplomer.','
						.''.$this->dteplomer_id.',"'.$this->fname.'","'.$this->name.'",'.$this->vkl_otopl.','.$this->vkl_xvoda.','.$this->vkl_stoki.','
						.''.$this->vkl_gvoda.','.$this->gvodomer.','.$this->xvodomer.','.$this->teplomer.','.$this->nrx_gvs_d.',@success,@msg)';
						//print($this->sql);
			break;
			case "nachGvsFilial":
			$this->sql='CALL YISGRAND.nachGvsFilial('.$this->filial_id.','.$this->org_id.','.$this->raion_id.','.$this->street_id.','.$this->house_id.','.$this->address_id.','
						.'"'.$this->address.'","'.$this->appartment.'",'.$this->is_flat.','.$this->sobstv_id.','
						.''.$this->type_id.','.$this->area.','.$this->visota.','.$this->people.','.$this->rwork_id.','.$this->dteplomer.','
						.''.$this->dteplomer_id.',"'.$this->fname.'","'.$this->name.'",'.$this->vkl_otopl.','.$this->vkl_xvoda.','.$this->vkl_stoki.','
						.''.$this->vkl_gvoda.','.$this->gvodomer.','.$this->xvodomer.','.$this->teplomer.','.$this->nrx_gvs_d.',@success,@msg)';
						//print($this->sql);
			break;
			case "deleteFilial":
			$this->sql='CALL YISGRAND.delete_filial('.$this->filial_id.',@success,@msg)';
						//print($this->sql);
			break;
		}
			$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.' ( ' . $this->sql . ' ) ' . $_db->connect_error);
			$this->sql_callback='SELECT @filial_id,@success,@msg';	
			$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['filial_id'] = $this->row['@filial_id'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
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