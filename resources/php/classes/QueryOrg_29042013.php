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
		//                 'hostname', 'username','password', 'database'
		$_db = new mysqli('localhost', $login,$password, 'YISGRAND');
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
			if(isset($params->utype) && ($params->utype)) {
			  $this->utype = (int) $params->utype;
			} else {
			  $this->utype = 0;
			}


		switch ($this->what) {
			case "OrgPhones"://CREATE RECORD


			if(isset($params->org_id) && ($params->org_id)) {
			  $this->org_id = $_db->real_escape_string($params->org_id);
			} else {
			  $this->org_id = 0;
			}

			if(isset($params->filial_id) && ($params->filial_id)) {
			  $this->filial_id = $_db->real_escape_string($params->filial_id);
			} else {
			  $this->filial_id = 0;
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


			if(isset($params->person) && ($params->person)) {
			  $this->person = $_db->real_escape_string($params->person);
			} else {
			  $this->person = '';
			}

			if(isset($params->person_place) && ($params->person_place)) {
			  $this->person_place = $_db->real_escape_string($params->person_place);
			} else {
			  $this->person_place = '';
			}

			if(isset($params->person_doc) && ($params->person_doc)) {
			  $this->person_doc = $_db->real_escape_string($params->person_doc);
			} else {
			  $this->person_doc = '';
			}

			if(isset($params->subarend) && ($params->subarend)) {
			  $this->subarend = $_db->real_escape_string($params->subarend);
			} else {
			  $this->subarend = '';
			}
			

			if(isset($params->drugie) && ($params->drugie)) {
			  $this->drugie = $_db->real_escape_string($params->drugie);
			} else {
			  $this->drugie = '';
			}
			



/*
			if(isset($params->utype) && ($params->utype)) {
			  $this->utype = (int) $params->utype;
			} else {
			  $this->utype = 0;
			}
*/

if ($this->utype == 1) {
			 $this->sql='INSERT INTO DOGOVOR_YTKE SET '
			      .'org_id="'.$this->org_id.'", '
			      .'number="'.$this->number.'", '
			      .'data_start="'.$this->data_start.'", '
			      .'data_end="'.$this->data_end.'", '
			      .'active="'.$this->active.'", '
			      .'person="'.$this->person.'", '
			      .'person_place="'.$this->person_place.'", '
			      .'person_doc="'.$this->person_doc.'", '
			      .'subarend="'.$this->subarend.'", '
			      .'drugie="'.$this->drugie.'" '
			     // .'tarif_gkal_inshi="'.$this->tarif_gkal_inshi.'", '
			    //  .'tarif_gkal_nasel="'.$this->tarif_gkal_nasel.'"'
			      .'';
			   //  print_r($this->sql); 
}

if ($this->utype == 2) {
			 $this->sql='INSERT INTO DOGOVOR_VIK SET '
			      .'org_id="'.$this->org_id.'", '
			      .'number="'.$this->number.'", '
			      .'data_start="'.$this->data_start.'", '
			      .'data_end="'.$this->data_end.'", '
			      .'active="'.$this->active.'" '
			     // .'tarif_gkal_inshi="'.$this->tarif_gkal_inshi.'", '
			    //  .'tarif_gkal_nasel="'.$this->tarif_gkal_nasel.'"'
			      .'';
			   //  print_r($this->sql); 
}

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

			if(isset($params->id) && ($params->id)) {
			  $this->id = $_db->real_escape_string($params->id);
			} else {
			  $this->id = 0;
			}


			//CREATE RECORD


if ($this->utype == 1) {
$this->sql=' INSERT INTO FILIAL_DOG_YTKE 
(filial_id, kod, org_id, golovnoe, org, address_id, raion_id, street_id, house_id, dteplomer_id, dteplomer, is_flat, sobstv_id, type_id, typeh_id, appartment, address, area, visota, volume, people, rwork_id, tarif_gv, tarif_xv, tarif_st, tarif_ot, name, fname, `dogovor_id`, gkal_h_ot, gkal_hs_gvs, gkal_hw_gvs, gkal_yw_gvs, gkal_y_ot, gkal_ys_gvs, nrx_gvs_d, vkl_gvoda, vkl_otopl, vkl_xvoda, vkl_stoki, xvodomer, gvodomer, teplomer, vibor, operator ) 
SELECT 
`filial_id`, `kod`, `org_id`, `golovnoe`, `org`, `address_id`, `raion_id`, `street_id`, `house_id`, `dteplomer_id`, `dteplomer`, `is_flat`, `sobstv_id`, `type_id`, `typeh_id`, `appartment`, `address`, `area`, `visota`, `volume`, `people`, `rwork_id`, `tarif_gv`, `tarif_xv`, `tarif_st`, `tarif_ot`, `name`, `fname`, "'.$this->dog_id.'", `gkal_h_ot`, `gkal_hs_gvs`, `gkal_hw_gvs`, `gkal_yw_gvs`, `gkal_y_ot`, `gkal_ys_gvs`, `nrx_gvs_d`, `vkl_gvoda`, `vkl_otopl`, `vkl_xvoda`, `vkl_stoki`, `xvodomer`, `gvodomer`, `teplomer`, `vibor`, `operator`  
FROM 
TM_ORG_FILIAL WHERE TM_ORG_FILIAL.filial_id="'.$this->filial_id.'"';
    // print_r($this->sql); 
			 }

if ($this->utype == 2) {
$this->sql=' INSERT INTO FILIAL_DOG_VIK 
(filial_id, kod, org_id, golovnoe, org, address_id, raion_id, street_id, house_id, dteplomer_id, dteplomer, is_flat, sobstv_id, type_id, typeh_id, appartment, address, area, visota, volume, people, rwork_id, tarif_gv, tarif_xv, tarif_st, tarif_ot, name, fname, `dogovor_id`, gkal_h_ot, gkal_hs_gvs, gkal_hw_gvs, gkal_yw_gvs, gkal_y_ot, gkal_ys_gvs, nrx_gvs_d, vkl_gvoda, vkl_otopl, vkl_xvoda, vkl_stoki, xvodomer, gvodomer, teplomer, vibor, operator ) 
SELECT 
`filial_id`, `kod`, `org_id`, `golovnoe`, `org`, `address_id`, `raion_id`, `street_id`, `house_id`, `dteplomer_id`, `dteplomer`, `is_flat`, `sobstv_id`, `type_id`, `typeh_id`, `appartment`, `address`, `area`, `visota`, `volume`, `people`, `rwork_id`, `tarif_gv`, `tarif_xv`, `tarif_st`, `tarif_ot`, `name`, `fname`, "'.$this->dog_id.'", `gkal_h_ot`, `gkal_hs_gvs`, `gkal_hw_gvs`, `gkal_yw_gvs`, `gkal_y_ot`, `gkal_ys_gvs`, `nrx_gvs_d`, `vkl_gvoda`, `vkl_otopl`, `vkl_xvoda`, `vkl_stoki`, `xvodomer`, `gvodomer`, `teplomer`, `vibor`, `operator`  
FROM 
TM_ORG_FILIAL WHERE TM_ORG_FILIAL.filial_id="'.$this->filial_id.'"';
    // print_r($this->sql); 
			 }


			break;




			case "OrgDogFil_all":  //CREATE RECORD
			
			if(isset($params->dog_id) && ($params->dog_id)) {
			  $this->dog_id = $_db->real_escape_string($params->dog_id);
			} else {
			  $this->dog_id = '';
			}

			if(isset($params->id) && ($params->id)) {
			  $this->id = $_db->real_escape_string($params->id);
			} else {
			  $this->id = 0;
			}


			//CREATE RECORD


if ($this->utype == 1) {
$this->sql=' INSERT INTO FILIAL_DOG_YTKE 
(filial_id, kod, org_id, golovnoe, org, address_id, raion_id, street_id, house_id, dteplomer_id, dteplomer, is_flat, sobstv_id, type_id, typeh_id, appartment, address, area, visota, volume, people, rwork_id, tarif_gv, tarif_xv, tarif_st, tarif_ot, name, fname, `dogovor_id`, gkal_h_ot, gkal_hs_gvs, gkal_hw_gvs, gkal_yw_gvs, gkal_y_ot, gkal_ys_gvs, nrx_gvs_d, vkl_gvoda, vkl_otopl, vkl_xvoda, vkl_stoki, xvodomer, gvodomer, teplomer, vibor, operator ) 
SELECT 
`filial_id`, `kod`, `org_id`, `golovnoe`, `org`, `address_id`, `raion_id`, `street_id`, `house_id`, `dteplomer_id`, `dteplomer`, `is_flat`, `sobstv_id`, `type_id`, `typeh_id`, `appartment`, `address`, `area`, `visota`, `volume`, `people`, `rwork_id`, `tarif_gv`, `tarif_xv`, `tarif_st`, `tarif_ot`, `name`, `fname`, "'.$this->dog_id.'", `gkal_h_ot`, `gkal_hs_gvs`, `gkal_hw_gvs`, `gkal_yw_gvs`, `gkal_y_ot`, `gkal_ys_gvs`, `nrx_gvs_d`, `vkl_gvoda`, `vkl_otopl`, `vkl_xvoda`, `vkl_stoki`, `xvodomer`, `gvodomer`, `teplomer`, `vibor`, `operator`  
FROM 
TM_ORG_FILIAL WHERE TM_ORG_FILIAL.org_id=(SELECT YISGRAND.DOGOVOR_YTKE.`org_id` FROM YISGRAND.DOGOVOR_YTKE WHERE YISGRAND.DOGOVOR_YTKE.`dog_id` = "'.$this->dog_id.'")';
    // print_r($this->sql); 
			 }

if ($this->utype == 2) {
$this->sql=' INSERT INTO FILIAL_DOG_VIK 
(filial_id, kod, org_id, golovnoe, org, address_id, raion_id, street_id, house_id, dteplomer_id, dteplomer, is_flat, sobstv_id, type_id, typeh_id, appartment, address, area, visota, volume, people, rwork_id, tarif_gv, tarif_xv, tarif_st, tarif_ot, name, fname, `dogovor_id`, gkal_h_ot, gkal_hs_gvs, gkal_hw_gvs, gkal_yw_gvs, gkal_y_ot, gkal_ys_gvs, nrx_gvs_d, vkl_gvoda, vkl_otopl, vkl_xvoda, vkl_stoki, xvodomer, gvodomer, teplomer, vibor, operator ) 
SELECT 
`filial_id`, `kod`, `org_id`, `golovnoe`, `org`, `address_id`, `raion_id`, `street_id`, `house_id`, `dteplomer_id`, `dteplomer`, `is_flat`, `sobstv_id`, `type_id`, `typeh_id`, `appartment`, `address`, `area`, `visota`, `volume`, `people`, `rwork_id`, `tarif_gv`, `tarif_xv`, `tarif_st`, `tarif_ot`, `name`, `fname`, "'.$this->dog_id.'", `gkal_h_ot`, `gkal_hs_gvs`, `gkal_hw_gvs`, `gkal_yw_gvs`, `gkal_y_ot`, `gkal_ys_gvs`, `nrx_gvs_d`, `vkl_gvoda`, `vkl_otopl`, `vkl_xvoda`, `vkl_stoki`, `xvodomer`, `gvodomer`, `teplomer`, `vibor`, `operator`  
FROM 
TM_ORG_FILIAL WHERE TM_ORG_FILIAL.org_id=(SELECT YISGRAND.DOGOVOR_VIK.`org_id` FROM YISGRAND.DOGOVOR_VIK WHERE YISGRAND.DOGOVOR_VIK.`dog_id` = "'.$this->dog_id.'")';
    // print_r($this->sql); 
			 }


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

			$this->sql='INSERT INTO YISGRAND.SPR_TEMPERATURE SET YISGRAND.SPR_TEMPERATURE.`data` = CURDATE()';
			//      print_r($this->sql); 
			break;

		      case "WorkGrafik":	//CREATE RECORD

			if(isset($params->data) && ($params->data)) {
			  $this->data = $params->data;
			} else {
			  $this->data = '';
			}
			if(isset($params->kalendar_hour) && ($params->kalendar_hour)) {
			  $this->kalendar_hour = $_db->real_escape_string($params->kalendar_hour);
			} else {
			  $this->kalendar_hour = 0;
			}
			if(isset($params->grafik_hour) && ($params->grafik_hour)) {
			  $this->grafik_hour = $_db->real_escape_string($params->grafik_hour);
			} else {
			  $this->grafik_hour = 0;
			}
			if(isset($params->work_day) && ($params->work_day)) {
			  $this->work_day = $_db->real_escape_string($params->work_day);
			} else {
			  $this->work_day = 0;
			}
			} // END OF SWITCH //CREATE RECORD 


		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. '-'.$this->utype.' (' .  $this->sql . ') ' . $_db->connect_error);

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
		if(isset($params->query) && ($params->query)) {
		 $this->query = $params->query;
		} else {
		  $this->query = "";
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
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

		if(isset($params->utype) && ($params->utype)) {
		  $this->utype = (int) $params->utype;
		} else {
		  $this->utype = 0;
		}

		if(isset($params->fd_id) && ($params->fd_id)) {
		  $this->fd_id = (int) $params->fd_id;
		} else {
		  $this->fd_id = 0;
		}


		switch ($this->what) {
		
// GET RESULT

			case "StOrg"://in use			
			      $this->sql='SELECT '
					  .'YISGRAND.TM_ORG.`org_id`, '
					  .'YISGRAND.TM_ORG.`sname` '
	//				  .'YISGRAND.TM_ORG.`fname`, '
					  .' FROM YISGRAND.TM_ORG '
					  .' WHERE  YISGRAND.TM_ORG.`sname` like "%'.$this->filial_id.'%" ORDER BY YISGRAND.TM_ORG.`sname`';
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
// GET RESULT

			case "OrgPhones":		
			      $this->sql='SELECT YISGRAND.TM_PHONES.`phone_id`,'
					  .'YISGRAND.TM_PHONES.`org_id`,'
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
			case "OtoplenieOrg":			
			      $this->sql='SELECT * FROM YISGRAND.OTOPLENIE WHERE `filial_id` = '.$this->filial_id.' AND YISGRAND.OTOPLENIE.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1' ;
			     // print_r($this->sql); 
			break;
			case "PodogrevOrg":			
			      $this->sql='SELECT * FROM YISGRAND.PODOGREV WHERE `filial_id` = '.$this->filial_id.' AND YISGRAND.PODOGREV.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1' ;
			     // print_r($this->sql); 
			break;
			case "VodaOrg":			
			      $this->sql='SELECT * FROM YISGRAND.VODA WHERE `filial_id` = '.$this->filial_id.' AND YISGRAND.VODA.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1' ;
			     // print_r($this->sql); 
			break;
			case "StokiOrg":			
			      $this->sql='SELECT * FROM YISGRAND.STOKI WHERE `filial_id` = '.$this->filial_id.' AND YISGRAND.STOKI.`data` = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1' ;
			     // print_r($this->sql); 
			break;
			case "TekNachFilial":			  
			   $this->sql='SELECT filial_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol,edizm, qty, tarif, sum(nachisleno) as nachisleno, sum(perer) as perer,  sum(itogo) as itogo, sum(oplacheno) as oplacheno,  sum(dolg) as dolg,  hdolg FROM('
				  .'(SELECT 1 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN xkub+gkub > 0 THEN "куб" ELSE "чел" END as edizm,CASE WHEN xkub+gkub+pkub > 0 THEN xkub+gkub+pkub ELSE people END as qty,tarif,'
				  .'YISGRAND.VODA.nachisleno-YISGRAND.VODA.perer-YISGRAND.VODA.pnds as nachisleno,YISGRAND.VODA.perer+YISGRAND.VODA.pnds as perer,'
				  .' YISGRAND.VODA.nachisleno as itogo, YISGRAND.VODA.oplacheno, YISGRAND.VODA.dolg,0 as hdolg FROM YISGRAND.VODA  WHERE filial_id='.$this->filial_id.' '
				  .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN xkub+gkub > 0 THEN "куб" ELSE "чел" END as edizm,CASE WHEN xkub+gkub+pkub > 0 THEN xkub+gkub+pkub ELSE people END as qty,tarif,'
				  .'YISGRAND.STOKI.nachisleno-YISGRAND.STOKI.perer-YISGRAND.STOKI.pnds as nachisleno,YISGRAND.STOKI.perer+YISGRAND.STOKI.pnds as perer,'
				  .' YISGRAND.STOKI.nachisleno as itogo, YISGRAND.STOKI.oplacheno, YISGRAND.STOKI.dolg,0 as hdolg FROM YISGRAND.STOKI  WHERE filial_id='.$this->filial_id.' '
				  .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 3 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'"Гкал"  as edizm,gkal as qty,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.PODOGREV  WHERE filial_id='.$this->filial_id.' '
				  .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'") ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 4 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'"Гкал"  as edizm,CASE WHEN gkal=0 THEN square ELSE gkal END as qty,CASE WHEN gkal=0 THEN tarif ELSE tarif END as tarif,'
				  .'nachisleno-perer as nachisleno,perer,nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg '
				   .'FROM YISGRAND.OTOPLENIE  WHERE filial_id='.$this->filial_id.' '
				    .'AND EXTRACT(YEAR_MONTH FROM `data`) = EXTRACT(YEAR_MONTH FROM "'.$this->data.'")  ORDER BY data DESC LIMIT 1 )'
				  .' ORDER BY data DESC,p) AS a group by p with rollup';
			//print($this->sql); 
			break;

			case "TekNachAllApp":			  
			  
			   $this->sql='SELECT address_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol ,edizm, qty, tarif, sum(nachisleno) as nachisleno, sum(perer) as perer, sum(budjet) as budjet, sum(itogo) as itogo, sum(oplacheno) as oplacheno, sum(subsidia) as subsidia, sum(dolg) as dolg,  hdolg FROM((SELECT 1 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+pkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.VODA  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+pkub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.STOKI  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) UNION '
				  .' (SELECT 3 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,kub+people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.PODOGREV  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 4 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN gkal=0 THEN "м2" ELSE "Гкал" END as edizm,CASE WHEN gkal=0 THEN square ELSE gkal END as qty,CASE WHEN gkal=0 THEN tarif ELSE tarif_gkal END as tarif,'
				  .'nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg '
				   .'FROM YIS.OTOPLENIE  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 5 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,"м2" as edizm,square as qty,tarif,'
				   .'nachisleno-perer-dop as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.KVARTPLATA  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) UNION '    
				  .' (SELECT 6 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'"чел" as edizm,people as qty,tarif,nachisleno-perer as nachisleno,perer,-(budjet+pbudjet) as budjet,'
				  .'nachisleno+perer+budjet+pbudjet as itogo,oplacheno,subsidia,dolg,0 as hdolg FROM YIS.TBO  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 )  ORDER BY data DESC ,p) AS a group by p with rollup';
			//  print($this->sql);
		    break;
			case "FilialToDog":			
			      $this->sql='SELECT * FROM TM_ORG_FILIAL WHERE TM_ORG_FILIAL.filial_id="'.$this->id.'" LIMIT 1';
			      //print_r($this->sql); 
			break;

			case "OrgDog":	

			      if ($this->utype == 1) {
						  $this->sql='SELECT * FROM DOGOVOR_YTKE WHERE org_id='.$this->id.' ORDER BY data_start DESC';
						  }
			
			      if ($this->utype == 2) {
						  $this->sql='SELECT * FROM DOGOVOR_VIK WHERE org_id='.$this->id.' ORDER BY data_start DESC';
						  }
	
		     
		      //print_r($this->sql); 
			break;
// GET RESULT


			case "OrgDogFil":

			      if ($this->utype == 1) {


			$this->sql='SELECT '
					  .'fd_id, '
					  .'filial_id, '
					  .'org_id, '
					  .'golovnoe, '
					  .'org, '
					  .'address_id, '
					  .'raion_id, '
					  .'street_id, '
					  .'house_id, '
					  .'house_id AS hid, '
					  .'(SELECT YIS.HOUSE.`house` FROM YIS.HOUSE WHERE YIS.HOUSE.`house_id` = hid LIMIT 1) AS house, ' 
					  .'dteplomer_id, '
					  .'dteplomer, '
					  .'is_flat, '
					  .'sobstv_id, '
					  .'(SELECT YISGRAND.SPR_SOBSTV.`name` FROM YISGRAND.SPR_SOBSTV WHERE YISGRAND.SPR_SOBSTV.`sobstv_id` = sobstv_id LIMIT 1) AS sobstv, ' 
					  .'type_id, '
					  .'(SELECT YISGRAND.SPR_TYPES.`name` FROM YISGRAND.SPR_TYPES WHERE YISGRAND.SPR_TYPES.`type_id` = type_id LIMIT 1) AS ob_water, ' 
					  .'typeh_id, ' 
					  .'(SELECT YISGRAND.SPR_TYPESH.`name` FROM YISGRAND.SPR_TYPESH WHERE YISGRAND.SPR_TYPESH.`type_id` = typeh_id LIMIT 1) AS ob_teplo, ' 
					  .'appartment, '
					  .'address, '
					  .'area, '
					  .'visota, '
					  .'volume, '
					  .'people, '
					  .'rwork_id, '
					  .'(SELECT YISGRAND.SPR_RWORK.`name` FROM YISGRAND.SPR_RWORK WHERE YISGRAND.SPR_RWORK.`rwork_id` = rwork_id LIMIT 1) AS rwork, ' 
					  .'tarif_gv, '
					  .'tarif_xv, '
					  .'tarif_st, '
					  .'tarif_ot, '
					  .'name, '
					  .'fname, '
					  .'dogovor_id, '
					  .'gkal_h_ot, '
					  .'gkal_hs_gvs, '
					  .'gkal_hw_gvs, '
					  .'gkal_yw_gvs, '
					  .'gkal_y_ot, '
					  .'gkal_ys_gvs, '
					  .'nrx_gvs_d, '
					  .'vkl_gvoda, '
					  .'vkl_otopl, '
					  .'vkl_xvoda, '
					  .'vkl_stoki, '
					  .'xvodomer, '
					  .'gvodomer, '
					  .'teplomer '
					  .' FROM YISGRAND.FILIAL_DOG_YTKE '
					  .' WHERE YISGRAND.FILIAL_DOG_YTKE.dogovor_id='.$this->id;

						//  $this->sql='SELECT * FROM FILIAL_DOG_YTKE WHERE dogovor_id='.$this->id.' ORDER BY name';
						  }
	// GET RESULT
		
			      if ($this->utype == 2) {

			$this->sql='SELECT '
					  .'fd_id, '
					  .'filial_id, '
					  .'org_id, '
					  .'golovnoe, '
					  .'org, '
					  .'address_id, '
					  .'raion_id, '
					  .'street_id, '
					  .'house_id, '
					  .'house_id AS hid, '
					  .'(SELECT YIS.HOUSE.`house` FROM YIS.HOUSE WHERE YIS.HOUSE.`house_id` = hid LIMIT 1) AS house, ' 
					  .'dteplomer_id, '
					  .'dteplomer, '
					  .'is_flat, '
					  .'sobstv_id, '
					  .'(SELECT YISGRAND.SPR_SOBSTV.`name` FROM YISGRAND.SPR_SOBSTV WHERE YISGRAND.SPR_SOBSTV.`sobstv_id` = sobstv_id LIMIT 1) AS sobstv, ' 
					  .'type_id, '
					  .'(SELECT YISGRAND.SPR_TYPES.`name` FROM YISGRAND.SPR_TYPES WHERE YISGRAND.SPR_TYPES.`type_id` = type_id LIMIT 1) AS ob_water, ' 
					  .'typeh_id, ' 
					  .'(SELECT YISGRAND.SPR_TYPESH.`name` FROM YISGRAND.SPR_TYPESH WHERE YISGRAND.SPR_TYPESH.`type_id` = typeh_id LIMIT 1) AS ob_teplo, ' 
					  .'appartment, '
					  .'address, '
					  .'area, '
					  .'visota, '
					  .'volume, '
					  .'people, '
					  .'rwork_id, '
					  .'(SELECT YISGRAND.SPR_RWORK.`name` FROM YISGRAND.SPR_RWORK WHERE YISGRAND.SPR_RWORK.`rwork_id` = rwork_id LIMIT 1) AS rwork, ' 
					  .'tarif_gv, '
					  .'tarif_xv, '
					  .'tarif_st, '
					  .'tarif_ot, '
					  .'name, '
					  .'fname, '
					  .'dogovor_id, '
					  .'gkal_h_ot, '
					  .'gkal_hs_gvs, '
					  .'gkal_hw_gvs, '
					  .'gkal_yw_gvs, '
					  .'gkal_y_ot, '
					  .'gkal_ys_gvs, '
					  .'nrx_gvs_d, '
					  .'vkl_gvoda, '
					  .'vkl_otopl, '
					  .'vkl_xvoda, '
					  .'vkl_stoki, '
					  .'xvodomer, '
					  .'gvodomer, '
					  .'teplomer '
					  .' FROM YISGRAND.FILIAL_DOG_YTKE'
					  .' WHERE YISGRAND.FILIAL_DOG_YTKE.dogovor_id='.$this->id;

						//  $this->sql='SELECT * FROM FILIAL_DOG_VIK WHERE dogovor_id='.$this->id.' ORDER BY name';
						  }
// GET RESULT


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
// GET RESULT


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
			;

			case "FmFilialDog"://in use	


			      if ($this->utype == 1) {
			$this->sql='SELECT '
					  .'fd_id, '
					  .'filial_id, '
					  .'org_id, '
					  .'golovnoe, '
					  .'org, '
					  .'address_id, '
					  .'raion_id, '
					  .'street_id, '
					  .'house_id, '
					  .'dteplomer_id, '
					  .'dteplomer, '
					  .'is_flat, '
					  .'sobstv_id, '
					  .'(SELECT YISGRANG.SPR_SOBSTV.`name` FROM YISGRANG.SPR_SOBSTV WHERE YISGRANG.SPR_SOBSTV.`sobstv_id` = sobstv_id LIMIT 1) AS sobstv, ' 
					  .'type_id, '
					  .'(SELECT YISGRANG.SPR_TYPES.`name` FROM YISGRANG.SPR_TYPES WHERE YISGRANG.SPR_TYPES.`type_id` = type_id LIMIT 1) AS ob_water, ' 
					  .'typeh_id, ' 
					  .'(SELECT YISGRANG.SPR_TYPESH.`name` FROM YISGRANG.SPR_TYPESH WHERE YISGRANG.SPR_TYPESH.`type_id` = typeh_id LIMIT 1) AS ob_teplo, ' 
					  .'appartment, '
					  .'address, '
					  .'area, '
					  .'visota, '
					  .'volume, '
					  .'people, '
					  .'rwork_id, '
					  .'(SELECT YISGRANG.SPR_RWORK.`name` FROM YISGRANG.SPR_RWORK WHERE YISGRANG.SPR_RWORK.`rwork_id` = rwork_id LIMIT 1) AS rwork, ' 
					  .'tarif_gv, '
					  .'tarif_xv, '
					  .'tarif_st, '
					  .'tarif_ot, '
					  .'name, '
					  .'fname, '
					  .'dogovor_id, '
					  .'gkal_h_ot, '
					  .'gkal_hs_gvs, '
					  .'gkal_hw_gvs, '
					  .'gkal_yw_gvs, '
					  .'gkal_y_ot, '
					  .'gkal_ys_gvs, '
					  .'nrx_gvs_d, '
					  .'vkl_gvoda, '
					  .'vkl_otopl, '
					  .'vkl_xvoda, '
					  .'vkl_stoki, '
					  .'xvodomer, '
					  .'gvodomer, '
					  .'teplomer '
					  .' FROM YISGRAND.FILIAL_DOG_YTKE '
					  .' WHERE YISGRAND.FILIAL_DOG_YTKE.filial_id='.$this->fd_id.' LIMIT 1';
						  }
// GET RESULT
			
			      if ($this->utype == 2) {
			$this->sql='SELECT '
					  .'fd_id, '
					  .'filial_id, '
					  .'org_id, '
					  .'golovnoe, '
					  .'org, '
					  .'address_id, '
					  .'raion_id, '
					  .'street_id, '
					  .'house_id, '
					  .'dteplomer_id, '
					  .'dteplomer, '
					  .'is_flat, '
					  .'sobstv_id, '
					  .'(SELECT YISGRANG.SPR_SOBSTV.`name` FROM YISGRANG.SPR_SOBSTV WHERE YISGRANG.SPR_SOBSTV.`sobstv_id` = sobstv_id LIMIT 1) AS sobstv, ' 
					  .'type_id, '
					  .'(SELECT YISGRANG.SPR_TYPES.`name` FROM YISGRANG.SPR_TYPES WHERE YISGRANG.SPR_TYPES.`type_id` = type_id LIMIT 1) AS ob_water, ' 
					  .'typeh_id, ' 
					  .'(SELECT YISGRANG.SPR_TYPESH.`name` FROM YISGRANG.SPR_TYPESH WHERE YISGRANG.SPR_TYPESH.`type_id` = typeh_id LIMIT 1) AS ob_teplo, ' 
					  .'appartment, '
					  .'address, '
					  .'area, '
					  .'visota, '
					  .'volume, '
					  .'people, '
					  .'rwork_id, '
					  .'(SELECT YISGRANG.SPR_RWORK.`name` FROM YISGRANG.SPR_RWORK WHERE YISGRANG.SPR_RWORK.`rwork_id` = rwork_id LIMIT 1) AS rwork, ' 
					  .'tarif_gv, '
					  .'tarif_xv, '
					  .'tarif_st, '
					  .'tarif_ot, '
					  .'name, '
					  .'fname, '
					  .'dogovor_id, '
					  .'gkal_h_ot, '
					  .'gkal_hs_gvs, '
					  .'gkal_hw_gvs, '
					  .'gkal_yw_gvs, '
					  .'gkal_y_ot, '
					  .'gkal_ys_gvs, '
					  .'nrx_gvs_d, '
					  .'vkl_gvoda, '
					  .'vkl_otopl, '
					  .'vkl_xvoda, '
					  .'vkl_stoki, '
					  .'xvodomer, '
					  .'gvodomer, '
					  .'teplomer '
					  .' FROM YISGRAND.FILIAL_DOG_YTKE'
					  .' WHERE YISGRAND.FILIAL_DOG_YTKE.filial_id='.$this->fd_id.' LIMIT 1';
						  }
	
// GET RESULT
	
					  // print_r($this->sql); 
			break;


			case "StOrgFil"://in use			
			      $this->sql='SELECT '
					  .'filial_id, '
					  .'name, '
					  .'fname '
					  .' FROM YISGRAND.TM_ORG_FILIAL '
					  .' WHERE YISGRAND.TM_ORG_FILIAL.org_id='.$this->org_id;
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

			      $array = (array) $params;
			      foreach ( $array as $key => $value )  {
					if(isset($value)) { 
					if (is_int($value)) { $this->$key= (int)$value;}
					else if (is_float($value)) { $this->$key= $value;}
					else {$this->$key =$_db->real_escape_string($value);}
					}
			      }		      

			      switch ($this->what) {
		      
			case "FmOrgInfo": 
			      $this->sql='UPDATE TM_ORG SET boss="'
			      .$this->boss.'", cat_id="'
			      .$this->cat_id.'", edrpou="'
			      .$this->edrpou.'", faddress="'
			      .$this->faddress.'", fname="'
			      .$this->fname.'", gbuh="'
			      .$this->gbuh.'", inn="'
			      .$this->inn.'", nds="'
			      .$this->nds.'", rwork_id="'
			      .$this->rwork_id.'", sname="'
			      .$this->sname.'", statut="'
			      .$this->statut.'", svid_fdata="'
			      .$this->svid_fdata.'", svid_nds="'
			      .$this->svid_nds.'", svid_sdata="'
			      .$this->svid_sdata.'", uaddress="'
			      .$this->uaddress.'" WHERE org_id='
			      .$this->org_id.' LIMIT 1';
			break;
			case "OrgDog": 
				if ($this->utype == 1) {
				      $this->sql='UPDATE DOGOVOR_YTKE SET '
				      .'number="'.$this->number.'", '
				      .'data_start="'.$this->data_start.'", '
				      .'data_end="'.$this->data_end.'", '
				      .'active="'.$this->active.'", '
				      .'tarif_gkal_inshi="'.$this->tarif_gkal_inshi.'", '
				      .'tarif_gkal_nasel="'.$this->tarif_gkal_nasel.'",'
				      .'bank_id='.$this->bank_id.','
				      .'rs="'.$this->rs.'",'
				      .'person="'.$this->person.'", '
				      .'person_place="'.$this->person_place.'", '
				      .'person_doc="'.$this->person_doc.'", '
				      .'subarend="'.$this->subarend.'", '
				      .'drugie="'.$this->drugie.'" '
				      .' WHERE dog_id="'.$this->dog_id.'" LIMIT 1';
				}
				if ($this->utype == 2) {
				      $this->sql='UPDATE DOGOVOR_VIK SET '
				      .'number="'.$this->number.'", '
				      .'data_start="'.$this->data_start.'", '
				      .'data_end="'.$this->data_end.'", '
				      .'active="'.$this->active.'", '
				      .'tarif_gkal_inshi="'.$this->tarif_gkal_inshi.'", '
				      .'tarif_gkal_nasel="'.$this->tarif_gkal_nasel.'"'
				      .' WHERE dog_id="'.$this->dog_id.'" LIMIT 1';
				}			   
			break;

			case "OrgPhones":
				$this->sql='UPDATE TM_PHONES SET '
			      .'phone="'.$this->phone.'", '
			      .'pname="'.$this->pname.'" '
			      .'WHERE phone_id="'.$this->phone_id.'" '.' LIMIT 1';
			break;
			case "OrgCateg":
				$this->sql='UPDATE TM_ORG_CAT SET '
			      .'name="'.$this->name.'" '
			      .'WHERE cat_id="'.$this->cat_id.'" '.' LIMIT 1';
			break;
			case "FilNaznCateg":
				$this->sql='UPDATE SPR_TYPES SET '
			      .'name="'.$this->name.'" '
			      .'WHERE nazn_id="'.$this->nazn_id.'" '.' LIMIT 1';
			break;
			case "FilSobstvCateg":
				$this->sql='UPDATE SPR_SOBSTV SET '
			      .'name="'.$this->name.'" '
			      .'WHERE stype_id="'.$this->stype_id.'" '.' LIMIT 1';
			break;
			case "FilRworkCateg":
				$this->sql='UPDATE SPR_RWORK SET '
			      .'name="'.$this->name.'" '
			      .'WHERE rwork_id="'.$this->rwork_id.'" '.' LIMIT 1';
			break;
			case "OrgDogTarifs":
				$this->sql='UPDATE TM_TARIF SET '
			      .'stype_id="'.$this->stype_id.'", '
			      .'stype_name=(SELECT SPR_SOBSTV.name from SPR_SOBSTV WHERE stype_id="'.$this->stype_id.'"),'
			      .'tarif_pod="'.$this->tarif_pod.'", '
			      .'tarif_ot="'.$this->tarif_ot.'" '
			      .'WHERE tarif_id="'.$this->tarif_id.'" '.' LIMIT 1';
			break;
			case "addFilialDvodomer"://in use			
			        $this->sql='UPDATE YISGRAND.TM_ORG_FILIAL SET YISGRAND.TM_ORG_FILIAL.dvodomer_id='
				.$this->dvodomer_id.',YISGRAND.TM_ORG_FILIAL.dvodomer=1  WHERE YISGRAND.TM_ORG_FILIAL.filial_id='.$this->filial_id.' LIMIT 1';
				
			break;
			case "delFilialDvodomer"://in use			
			        $this->sql='UPDATE YISGRAND.TM_ORG_FILIAL SET YISGRAND.TM_ORG_FILIAL.dvodomer_id=0 , YISGRAND.TM_ORG_FILIAL.dvodomer=0 '
				.' WHERE YISGRAND.TM_ORG_FILIAL.filial_id='.$this->filial_id.' LIMIT 1';
				
			break;
			case "addFilialDteplomer"://in use			
			        $this->sql='UPDATE YISGRAND.TM_ORG_FILIAL SET YISGRAND.TM_ORG_FILIAL.dteplomer_id='
				.$this->dteplomer_id.',YISGRAND.TM_ORG_FILIAL.dteplomer=1  WHERE YISGRAND.TM_ORG_FILIAL.filial_id='.$this->filial_id.' LIMIT 1';
				
			break;
			case "delFilialDteplomer"://in use			
			        $this->sql='UPDATE YISGRAND.TM_ORG_FILIAL SET YISGRAND.TM_ORG_FILIAL.dteplomer_id=0 , YISGRAND.TM_ORG_FILIAL.dteplomer=0 '
				.' WHERE YISGRAND.TM_ORG_FILIAL.filial_id='.$this->filial_id.' LIMIT 1';
				
			break;
			case "OrgServTypes":
				$this->sql='UPDATE TM_SERVICES_TYPES SET '
			      .'serv_type_name="'.$this->serv_type_name.'" '
			      .'WHERE serv_type_id="'.$this->serv_type_id.'" '.' LIMIT 1';
			break;
			case "FilServ":
				$this->sql='UPDATE TM_SERVICES_TYPES SET '
			      .'serv_type_id="'.$this->serv_type_id.'", '
			      .'serv_volume1="'.$this->serv_volume1.'", '
			      .'serv_volume2="'.$this->serv_volume2.'", '
			      .'serv_volume3="'.$this->serv_volume3.'", '
			      .'serv_volume4="'.$this->serv_volume4.'" '
			      .'WHERE fsevr_id="'.$this->fsevr_id.'" '.' LIMIT 1';
			break;
			case "Bank":
				$this->sql='UPDATE YISGRAND.BANKS SET '
			      .'bname="'.$this->bname.'", '
			      .'mfo="'.$this->mfo.'", '
			      .'city="'.$this->city.'" '
			      .'WHERE bank_id="'.$this->bank_id.'" '.' LIMIT 1';
			break;
			case "OrgVodaIns":
				$this->sql='UPDATE YISGRAND.VODA SET zadol='
				.$this->zadol.',YISGRAND.VODA.people='
				.$this->people.',YISGRAND.VODA.nrx_xv_d='
				.$this->nrx_xv_d.',YISGRAND.VODA.nrx_gvs_d='
				.$this->nrx_gvs_d.',YISGRAND.VODA.day_xv='
				.$this->day_xv.',YISGRAND.VODA.day_gv='
				.$this->day_gv.',YISGRAND.VODA.xkub='
				.$this->xkub.',YISGRAND.VODA.gkub='
				.$this->gkub.',YISGRAND.VODA.pkub='
				.$this->pkub.',YISGRAND.VODA.tarif='
				.$this->tarif.',YISGRAND.VODA.norma_xv='
				.$this->norma_xv.',YISGRAND.VODA.norma_gv='
				.$this->norma_gv.',YISGRAND.VODA.xvoda='
				.$this->xvoda.',YISGRAND.VODA.gvoda='
				.$this->gvoda.',YISGRAND.VODA.nds='
				.$this->nds.',YISGRAND.VODA.perer='
				.$this->perer.',YISGRAND.VODA.pnds='
				.$this->pnds.',YISGRAND.VODA.nachisleno='
				.$this->nachisleno.',YISGRAND.VODA.oplacheno='
				.$this->oplacheno.',YISGRAND.VODA.dolg='
				.$this->dolg.',YISGRAND.VODA.operator="'
				.$this->login.'",YISGRAND.VODA.data_in= CURDATE() WHERE YISGRAND.VODA.filial_id='
				.$this->filial_id.' AND YISGRAND.VODA.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
			case "OrgStokiIns":
				$this->sql='UPDATE YISGRAND.STOKI SET zadol='
				.$this->zadol.',YISGRAND.STOKI.people='
				.$this->people.',YISGRAND.STOKI.nrx_xv_d='
				.$this->nrx_xv_d.',YISGRAND.STOKI.nrx_gvs_d='
				.$this->nrx_gvs_d.',YISGRAND.STOKI.day_xv='
				.$this->day_xv.',YISGRAND.STOKI.day_gv='
				.$this->day_gv.',YISGRAND.STOKI.xkub='
				.$this->xkub.',YISGRAND.STOKI.gkub='
				.$this->gkub.',YISGRAND.STOKI.pkub='
				.$this->pkub.',YISGRAND.STOKI.tarif='
				.$this->tarif.',YISGRAND.STOKI.norma_xv='
				.$this->norma_xv.',YISGRAND.STOKI.norma_gv='
				.$this->norma_gv.',YISGRAND.STOKI.xvoda='
				.$this->xvoda.',YISGRAND.STOKI.gvoda='
				.$this->gvoda.',YISGRAND.STOKI.nds='
				.$this->nds.',YISGRAND.STOKI.perer='
				.$this->perer.',YISGRAND.STOKI.pnds='
				.$this->pnds.',YISGRAND.STOKI.nachisleno='
				.$this->nachisleno.',YISGRAND.STOKI.oplacheno='
				.$this->oplacheno.',YISGRAND.STOKI.dolg='
				.$this->dolg.',YISGRAND.STOKI.operator="'
				.$this->login.'",YISGRAND.STOKI.data_in= CURDATE() WHERE YISGRAND.STOKI.filial_id='
				.$this->filial_id.' AND YISGRAND.STOKI.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
			case "OrgPodogrevIns":
				$this->sql='UPDATE YISGRAND.PODOGREV SET zadol='
				.$this->zadol.',YISGRAND.PODOGREV.people='
				.$this->people.',YISGRAND.PODOGREV.kub='
				.$this->kub.',YISGRAND.PODOGREV.pkub='
				.$this->pkub.',YISGRAND.PODOGREV.toc='
				.$this->toc.',YISGRAND.PODOGREV.day_gv='
				.$this->day_gv.',YISGRAND.PODOGREV.nrx_gvs_d='
				.$this->nrx_gvs_d.',YISGRAND.PODOGREV.tarif='
				.$this->tarif.',YISGRAND.PODOGREV.norma='
				.$this->norma.',YISGRAND.PODOGREV.podogrev='
				.$this->podogrev.',YISGRAND.PODOGREV.gkal='
				.$this->gkal.',YISGRAND.PODOGREV.gkal_perer='
				.$this->gkal_perer.',YISGRAND.PODOGREV.nds='
				.$this->nds.',YISGRAND.PODOGREV.perer='
				.$this->perer.',YISGRAND.PODOGREV.pnds='
				.$this->pnds.',YISGRAND.PODOGREV.nachisleno='
				.$this->nachisleno.',YISGRAND.PODOGREV.oplacheno='
				.$this->oplacheno.',YISGRAND.PODOGREV.dolg='
				.$this->dolg.',YISGRAND.PODOGREV.operator="'
				.$this->login.'" WHERE YISGRAND.PODOGREV.filial_id='
				.$this->filial_id.' AND YISGRAND.PODOGREV.data = CONCAT(EXTRACT(YEAR_MONTH FROM "'.$this->data.'"),"01") LIMIT 1';
			    //print_r($this->sql); 
			break;
			case "Temperature":	
				$this->sql='UPDATE YISGRAND.SPR_TEMPERATURE SET `temp`='
				.$this->temp.' WHERE EXTRACT(YEAR_MONTH FROM `data`)= EXTRACT(YEAR_MONTH FROM "'.$this->data.'") LIMIT 1';
			break;
			case "WorkGrafik":	
				$this->sql='UPDATE YISGRAND.SPR_GRAFIK SET `kalendar_hour`='
				.$this->kalendar_hour.',`grafik_hour`='
				.$this->grafik_hour.',`work_day`='
				.$this->work_day.' WHERE EXTRACT(YEAR_MONTH FROM `data`)= EXTRACT(YEAR_MONTH FROM "'.$this->data.'") LIMIT 1';
			break;
		} // End of Switch ($what)  

		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what. ' (' .  $this->sql . ') ' . $_db->connect_error);
	
		$rows=mysqli_affected_rows($_db);

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
		if(isset($params->utype) && ($params->utype)) {
		  $this->utype = (int) $params->utype;
		} else {
		  $this->utype = 0;
		}

		$qtype=''; // сброс типа запроса
		$important=null; // сброс важности запроса

		switch ($this->what) {
// DESTROY RECORD
		
			
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
// DESTROY RECORD


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

// DESTROY RECORD

			case "OrgDog": 
			
			if(isset($params->dog_id) && ($params->dog_id)) {
			  $this->dog_id = $_db->real_escape_string($params->dog_id);
			} else {
			  $this->dog_id = '';
			}

  			      if ($this->utype == 1) {
			$this->sql[0]='DELETE FROM DOGOVOR_YTKE WHERE dog_id="'.$this->dog_id.'"'.' LIMIT 1 ';
			$this->sql[1]='DELETE FROM FILIAL_DOG_YTKE WHERE dogovor_id='.$this->dog_id.''; // Филиалы
//			$this->sql[2]='DELETE FROM TM_DOG_TARIFS WHERE TM_DOG_TARIFS.dog_id='.$this->dog_id.''; // тарифы

						    }
			  
			      if ($this->utype == 2) {
			$this->sql[0]='DELETE FROM DOGOVOR_VIK WHERE dog_id="'.$this->dog_id.'"'.' LIMIT 1 ';
			$this->sql[1]='DELETE FROM FILIAL_DOG_VIK WHERE dogovor_id='.$this->dog_id.''; // Филиалы
//			$this->sql[2]='DELETE FROM TM_DOG_TARIFS WHERE TM_DOG_TARIFS.dog_id='.$this->dog_id.''; // тарифы
						    }

			$important=null;		
			$important[0]=0; // Запрос по которому ставится Успех
			   //  print_r($this->sql); 
			     
			 break;


			case "OrgDogFil":
// DESTROY RECORD
			if(isset($params->fd_id) && ($params->fd_id)) {
			  $this->fd_id = $_db->real_escape_string($params->fd_id);
			} else {
			  $this->fd_id = '';
			}

			      if ($this->utype == 1) {
						  $this->sql[0]='DELETE FROM FILIAL_DOG_YTKE WHERE fd_id='.$this->fd_id.' LIMIT 1'; // Филиал
						    }
			  
			      if ($this->utype == 2) {
						  $this->sql[0]='DELETE FROM FILIAL_DOG_VIK WHERE fd_id='.$this->fd_id.' LIMIT 1'; // Филиал
						    }
			$important=null;	
			$important[0]=0; // Запрос по которому ставится Успех
			// print_r($this->sql[0]); 
			break;


// DESTROY RECORD

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

// DESTROY RECORD

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

// DESTROY RECORD

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

// DESTROY RECORD

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

// DESTROY RECORD

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

// DESTROY RECORD

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

// DESTROY RECORD

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


// DESTROY RECORD

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

// DESTROY RECORD

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
			case "WorkGrafik":	

	      if(isset($params->data) && ($params->data)) {
		  $this->data =preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$1-$2-$3",$params->data);
		} else {
		  $this->data= '';
		}
		
			$this->sql[0]='DELETE FROM YISGRAND.SPR_GRAFIK WHERE EXTRACT(YEAR_MONTH FROM `data`)= EXTRACT(YEAR_MONTH FROM "'.$this->data.'") LIMIT 1';
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
			  $this->login= "";
			}		
			if(isset($params->password) && ($params->password)) {
			  $this->password= $params->password;
			} else {
			  $this->password= 0;
			}


			$_db = $this->connect($this->login,$this->password);

			$array = (array) $params;
			foreach ( $array as $key => $value ) {
				if(isset($value) ) { 
				if (is_int($value)) { $this->$key= (int)$value;}
				else if (is_float($value)) { $this->$key= $value;}
				else {$this->$key =$_db->real_escape_string($value);}
				} 
			}
			if(isset($params->address_id) && ($params->address_id)) {
			  $this->address_id= $params->address_id;
			} else {
			  $this->address_id= 0;
			}
			switch ($this->what) {
			case "addFilial": /* обновлена: добавлен typeh_id */
			$this->sql='CALL YISGRAND.add_filial("'.$this->golovnoe.'","'.$this->org_id.'","'.$this->raion_id.'","'.$this->street_id.'","'.$this->house_id.'","'.$this->address_id.'","'
						.$this->is_flat.'","'.$this->sobstv_id.'","'.$this->type_id.'","'
						.$this->typeh_id.'","'.$this->area.'","'.$this->visota.'","'.$this->people.'","'.$this->rwork_id.'","'
						.$this->fname.'","'.$this->name.'","'.$this->vkl_otopl.'","'.$this->vkl_xvoda.'","'.$this->vkl_stoki.'","'
						.$this->vkl_gvoda.'","'.$this->gvodomer.'","'.$this->xvodomer.'","'.$this->teplomer.'","'.$this->nrx_gvs_d.'","'
						.$this->nrx_xv_d.'","'.$this->pstoki.'","'.$this->qty_hour.'","'.$this->rteplo.'","'.$this->rvoda.'",@filial_id,@success,@msg)';
						//print($this->sql);
			break;
			case "updateFilial": /* обновлена: добавлен typeh_id */
			$this->sql='CALL YISGRAND.update_filial('.$this->filial_id.',"'.$this->golovnoe.'","'.$this->org_id.'","'.$this->raion_id.'","'.$this->street_id.'","'.$this->house_id.'","'.$this->address_id.'",'
						.$this->is_flat.',"'.$this->sobstv_id.'","'.$this->type_id.'","'
						.$this->typeh_id.'",'.$this->area.','.$this->visota.','.$this->people.',"'.$this->rwork_id.'","'.$this->dvodomer.'","'.$this->dvodomer_id.'",'.$this->dteplomer.',"'
						.$this->dteplomer_id.'","'.$this->fname.'","'.$this->name.'",'.$this->vkl_otopl.','.$this->vkl_xvoda.','.$this->vkl_stoki.','
						.$this->vkl_gvoda.','.$this->gvodomer.','.$this->xvodomer.','.$this->teplomer.','.$this->nrx_gvs_d.','
						.$this->nrx_xv_d.','.$this->pstoki.','.$this->qty_hour.','.$this->rteplo.','.$this->rvoda.',@success,@msg)';
						//print($this->sql);
			break;


			case "nachGvsFilial":
			$this->sql='CALL YISGRAND.nachGvsFilial('.$this->filial_id.','.$this->org_id.','.$this->raion_id.','.$this->street_id.','.$this->house_id.','.$this->address_id.','
						 .$this->is_flat.','.$this->sobstv_id.','
						.$this->type_id.','.$this->area.','.$this->visota.','.$this->people.','.$this->rwork_id.','.$this->dteplomer.','
						.$this->dteplomer_id.',"'.$this->fname.'","'.$this->name.'",'.$this->vkl_otopl.','.$this->vkl_xvoda.','.$this->vkl_stoki.','
						.$this->vkl_gvoda.','.$this->gvodomer.','.$this->xvodomer.','.$this->teplomer.','.$this->nrx_gvs_d.',@success,@msg)';
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