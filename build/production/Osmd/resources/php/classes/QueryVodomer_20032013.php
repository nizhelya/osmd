<?php

class QueryVodomer
{

	private $_db;
	protected $login;
	protected $password;
	protected $result;
	protected $address_id;
	protected $what;
	protected $vodomer_id;
	protected $res_callback;
	protected $sql;	
	protected $sql_callback;
	protected $row;	
	protected $pok_id;	
	protected $type;
	protected $pokaz;
	protected $pred;
	protected $tek;
	protected $st;
	protected $kub;
	protected $data=NULL;
	protected $res=array();	
	public	  $results=array();
	
		
	public function connect($login,$password)	{
		
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
		  $this->what = '';
		}
		if(isset($params->address_id) && ($params->address_id)) {
		 $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->what_id) && ($params->what_id)) {
		  $this->id = (int) $params->what_id;
		} else {
		  $this->id = 0;
		}
		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		 $this->vodomer_id = (int) $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
	     if(isset($params->pok_id) && ($params->pok_id)) {
		  $this->pok_id = (int) $params->pok_id;
		} else {
		  $this->pok_id = 0;
		}

		if(isset($params->filial_id) && ($params->filial_id)) {
		  $this->filial_id = (int) $params->filial_id;
		} else {
		  $this->filial_id = 0;
		}
		if(isset($params->house_id) && ($params->house_id)) {
		  $this->house_id = (int) $params->house_id;
		} else {
		  $this->house_id = 0;
		}

		if(isset($params->dvodomer_id) && ($params->dvodomer_id)) {
		 $this->dvodomer_id = (int) $params->dvodomer_id;
		} else {
		  $this->dvodomer_id = 0;
		}
//==================КВАРТИРНЫЕ ВОДОМЕРЫ=============================//

		switch ($this->what) {
			case "TekPokVodomera":			
			      $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					  .'YIS.VODOMER.address_id,'
					  .'YIS.VODOMER.house_id,'
					  .'YIS.VODOMER.address,'
					  .'YIS.VODOMER.sdate,'
					  .'YIS.VODOMER.pdate,'
					  .'YIS.VODOMER.voda,'
					  .'YIS.VODOMER.st,'
		      			  .'YIS.VODOMER.voda as type,'
					  .'UCASE(YIS.VODOMER.place) as place,'
					  .'YIS.VODOMER.nomer,'
					  .'YIS.VODOMER.model,'
					  .'YIS.VODOMER.position,'
					  .'YIS.WATER.pok_id,'
					  .'YIS.WATER.data,'
					  .'DATE_FORMAT(YIS.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YIS.WATER.pred,'
					  .'YIS.WATER.tek as tekp,'
					  .'YIS.WATER.tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,'
					  .'YIS.WATER.xkub_lg,'
					  .'YIS.WATER.gkub_lg,'
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'YIS.WATER.operator '
					  .' FROM YIS.VODOMER,YIS.WATER  '
					  .' WHERE YIS.VODOMER.vodomer_id='.$this->vodomer_id.' AND '
					  .' YIS.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YIS.WATER.data DESC limit 1';
			break;
			
			case "AllPokVodomera":			
				$this->sql='SELECT YIS.WATER.pok_id,'
					  .'YIS.WATER.vodomer_id,'
					  .'YIS.WATER.nomer,'
					  .'YIS.WATER.address_id,'
					  .'YIS.WATER.address,'
					  .'DATE_FORMAT(YIS.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YIS.WATER.pred,'
					  .'YIS.WATER.tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,'
					  .'YIS.WATER.xkub_lg,'
					  .'YIS.WATER.gkub_lg,'
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'YIS.WATER.operator '
					  .' FROM YIS.WATER  '
					  .' WHERE YIS.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YIS.WATER.data DESC  LIMIT 4 ';
					//  print($this->sql);
			break;
			case "TekPokVodomerov":			
				 $this->sql='SELECT YIS.VODOMER.address_id,'
					  .'YIS.VODOMER.voda as type,'
					  .'UCASE(YIS.VODOMER.place) as place,'
					  .'YIS.VODOMER.nomer,YIS.VODOMER.nomer AS vn,'
					  .'YIS.VODOMER.model,'
					  .'YIS.VODOMER.st,'
					  .'DATE_FORMAT(max(YIS.WATER.data),"%d-%m-%Y") as fdate,'
					  .'max(YIS.WATER.pred) as pred,'
					  .'max(YIS.WATER.tek) as tek,'
					  .'YIS.WATER.kub,'
					  .'YIS.WATER.tarif_xv,'
					  .'YIS.WATER.xvoda,'
					  .'YIS.WATER.tarif_gv,'
					  .'YIS.WATER.gvoda,'
					  .'YIS.WATER.tarif_st,'
					  .'YIS.WATER.stoki,' 
					  .'YIS.WATER.lgota_xv,'
					  .'YIS.WATER.lgota_gv,'
					  .'YIS.WATER.lgota_st,'
					  .'(SELECT YIS.WATER.operator '
					  .' FROM YIS.WATER '
					  .' WHERE YIS.WATER.nomer=vn '
					  .' ORDER BY YIS.WATER.data DESC LIMIT 1) AS operator '
					  .' FROM YIS.VODOMER,YIS.WATER  '
					  .' WHERE YIS.VODOMER.address_id='.$this->address_id.' AND '
					  .' YIS.VODOMER.nomer= YIS.WATER.nomer AND '
					  .' YIS.WATER.address_id='.$this->address_id.'' 
					  .' GROUP BY YIS.VODOMER.nomer ' 
					  .' ORDER BY YIS.WATER.data DESC';
			break;
			case "AppVodomer"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.sdate,'
					    .'YIS.VODOMER.pdate,'
					    .'YIS.VODOMER.out,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model_id,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->address_id.' '
					    .' AND YIS.VODOMER.spisan=0 '
					    .' ORDER BY YIS.VODOMER.vodomer_id DESC';
					// print($this->sql); 
			break;
			
			case "AppHVodomer"://применяется
				  $this->sql='SELECT YIS.VODOMER.vodomer_id,'
					    .'YIS.VODOMER.address_id,'
					    .'YIS.VODOMER.address,'
					    .'YIS.VODOMER.house_id,'
					    .'YIS.VODOMER.sdate,'
					    .'YIS.VODOMER.pdate,'
					    .'YIS.VODOMER.voda,'
					    .'YIS.VODOMER.st,'
					    .'YIS.VODOMER.place,'
					    .'YIS.VODOMER.nomer,'
					    .'YIS.VODOMER.model,'
					    .'YIS.VODOMER.note,'
					    .'YIS.VODOMER.position '
					    .' FROM YIS.VODOMER '
					    .' WHERE YIS.VODOMER.address_id='.$this->address_id.' '
					    .' AND YIS.VODOMER.spisan=1 '
					    .' ORDER BY YIS.VODOMER.vodomer_id DESC';
					  // print($this->sql); 
					
			break;	
			case "TekNachAppVodomera":			  
			   $this->sql='SELECT address_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol ,edizm, qty,gkub,tarif,'
					.'sum(norma) as norma,sum(xvoda) as xvoda,sum(gvoda) as gvoda,sum(perer) as perer ,sum(nachisleno) as nachisleno,'
					.'sum(budjet) as budjet,sum(pbudjet) as pbudjet, sum(oplacheno) as oplacheno,sum(subsidia) as subsidia, sum(dolg) as dolg,hdolg '
					.' FROM ( '
					.'(SELECT 1 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,'
					.'SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
					.'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,xkub_lg+gkub_lg as gkub,tarif,'
					.'norma,xvoda, gvoda ,perer,nachisleno,budjet,pbudjet,oplacheno,subsidia,dolg,0 as hdolg '
					.' FROM YIS.VODA  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) '
					.' UNION '
					.' (SELECT 2 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,'
					.' SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
					.'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,xkub_lg+gkub_lg as gkub,tarif,'					
					.'norma,xvoda, gvoda ,perer,nachisleno,budjet,pbudjet,oplacheno,subsidia,dolg,0 as hdolg '
					.' FROM YIS.STOKI  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) ' 
					.' UNION '
					.' (SELECT 3 as p,address_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,'
					.' SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
					.'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,kub+people as qty,gkub_lg as gkub,tarif,'
					.'norma,0 as xvoda, podogrev as gvoda ,perer,nachisleno,budjet,pbudjet,oplacheno,subsidia,dolg,0 as hdolg '
					.' FROM YIS.PODOGREV  WHERE address_id='.$this->address_id.' ORDER BY data DESC LIMIT 1 ) ' 
					.' ORDER BY data DESC ,p) AS a group by p with rollup';
			//print($this->sql); 
			break;

// =============ВОДОМЕРЫ ОРГАНИЗАЦИИ==================== // 

		
			case "TekPokOVodomera":			
			      $this->sql='SELECT YISGRAND.VODOMER.vodomer_id,'
					  .'YISGRAND.VODOMER.filial_id,'
					  .'YISGRAND.VODOMER.org_id,'
					  .'YISGRAND.VODOMER.house_id,'
					  .'YISGRAND.VODOMER.address_id,'
					  .'YISGRAND.VODOMER.address,'
					  .'YISGRAND.VODOMER.out, '
					  .'YISGRAND.VODOMER.obr, '
					  .'YISGRAND.VODOMER.sdate,'
					  .'YISGRAND.VODOMER.pdate,'
					  .'YISGRAND.VODOMER.voda,'
					  .'YISGRAND.VODOMER.st,'
					  .'YISGRAND.VODOMER.joint,'
					  .'YISGRAND.VODOMER.voda as type,'
					  .'UCASE(YISGRAND.VODOMER.place) as place,'
					  .'YISGRAND.VODOMER.nomer,'
					  .'YISGRAND.VODOMER.model,'
					  .'YISGRAND.VODOMER.position,'
					  .'YISGRAND.WATER.pok_id,'
					  .'YISGRAND.WATER.data,'
					  .'DATE_FORMAT(YISGRAND.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YISGRAND.WATER.pred,'
					  .'YISGRAND.WATER.tek as tekp,'
					  .'YISGRAND.WATER.tek,'
					  .'YISGRAND.WATER.kub,'
					  .'YISGRAND.WATER.gkal,'
					  .'YISGRAND.WATER.tarif_xv,'
					  .'YISGRAND.WATER.xvoda,'
					  .'YISGRAND.WATER.tarif_gv,'
					  .'YISGRAND.WATER.gvoda,'
					  .'YISGRAND.WATER.tarif_st,'
					  .'YISGRAND.WATER.stoki,'					  
					  .'YISGRAND.WATER.operator '
					  .' FROM YISGRAND.VODOMER,YISGRAND.WATER  '
					  .' WHERE YISGRAND.VODOMER.vodomer_id='.$this->vodomer_id.' AND '
					  .' YISGRAND.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YISGRAND.WATER.data_in DESC limit 1';
 //print($this->sql);
			break;
			
			case "AllPokOVodomera":			
				$this->sql='SELECT YISGRAND.WATER.pok_id,'
					  .'YISGRAND.WATER.vodomer_id,'
					  .'YISGRAND.WATER.nomer,'
					  .'YISGRAND.WATER.filial_id,'
					  .'DATE_FORMAT(YISGRAND.WATER.data,"%d-%m-%Y") as fdate,'
					  .'YISGRAND.WATER.pred,'
					  .'YISGRAND.WATER.tek,'
					  .'YISGRAND.WATER.kub,'
					  .'YISGRAND.WATER.tarif_xv,'
					  .'YISGRAND.WATER.xvoda,'
					  .'YISGRAND.WATER.tarif_gv,'
					  .'YISGRAND.WATER.gvoda,'
					  .'YISGRAND.WATER.tarif_st,'
					  .'YISGRAND.WATER.stoki,'
					  .'YISGRAND.WATER.gkal,'
					  .'YISGRAND.WATER.gkal,'
					  .'YISGRAND.WATER.obr, '
					  .'YISGRAND.WATER.operator '
					  .' FROM YISGRAND.WATER  '
					  .' WHERE YISGRAND.WATER.vodomer_id='.$this->vodomer_id.''
					  .' ORDER BY YISGRAND.WATER.data_in DESC ';
					 // print($this->sql);
			break;

			case "OrgVodomer"://применяется
				  $this->sql='SELECT '
					    .'YISGRAND.FVODOMER.`vodomer_id`, '
					    .'YISGRAND.VODOMER.filial_id,'
					    .'YISGRAND.VODOMER.org_id,'
					    .'YISGRAND.VODOMER.house_id,'
					    .'YISGRAND.VODOMER.address_id,'
					    .'YISGRAND.VODOMER.address,'
					    .'YISGRAND.VODOMER.sdate,'
					    .'YISGRAND.VODOMER.voda,'
					    .'YISGRAND.VODOMER.st,'
					    .'YISGRAND.VODOMER.place,'
					    .'YISGRAND.VODOMER.nomer,'
					    .'YISGRAND.VODOMER.model_id,'
					    .'YISGRAND.VODOMER.model,'
					    .'YISGRAND.VODOMER.position, '
					    .'YISGRAND.VODOMER.out, '
					    .'YISGRAND.VODOMER.obr, '
					    .'YISGRAND.VODOMER.joint '
					    .' FROM YISGRAND.FVODOMER LEFT JOIN YISGRAND.VODOMER USING (vodomer_id) '
					    .' WHERE YISGRAND.FVODOMER.filial_id='.$this->filial_id.' '
					    .' AND YISGRAND.VODOMER.spisan=0 '
					    .' ORDER BY YISGRAND.FVODOMER.vodomer_id DESC';
					//  print($this->sql); 
			break;

			case "AboutVodomer"://применяется
				  $this->sql='SELECT GROUP_CONCAT( '
					    .'"Объект код: ", YISGRAND.TM_ORG_FILIAL.`filial_id`, '
					    .' " Название: " , YISGRAND.TM_ORG_FILIAL.`name` '
					    .' SEPARATOR "<br>") AS filials '
					    .' FROM YISGRAND.TM_ORG_FILIAL '
					    .' WHERE YISGRAND.TM_ORG_FILIAL.`filial_id` IN '
					    .' (SELECT YISGRAND.FVODOMER.`filial_id` FROM YISGRAND.FVODOMER WHERE YISGRAND.FVODOMER.`vodomer_id`='.$this->vodomer_id.')';
					//  print($this->sql); 
			break;

			case "ExistentVod"://применяется
				  $this->sql='SELECT '
					    .'YISGRAND.VODOMER.`vodomer_id`, '
					    .'YISGRAND.VODOMER.`nomer`'
					    .' FROM YISGRAND.VODOMER '
					    .' WHERE YISGRAND.VODOMER.`house_id`='.$this->house_id.' AND YISGRAND.VODOMER.`joint`=1'
					    .' ORDER BY YISGRAND.VODOMER.`nomer` ';
					 //  print($this->sql); 
			break;
			
			case "OrgHVodomer"://применяется
				  $this->sql='SELECT YISGRAND.VODOMER.vodomer_id,'
					    .'YISGRAND.VODOMER.filial_id,'
					    .'YISGRAND.VODOMER.org_id,'
					    .'YISGRAND.VODOMER.house_id,'
					    .'YISGRAND.VODOMER.address_id,'
					    .'YISGRAND.VODOMER.address,'
					    .'YISGRAND.VODOMER.sdate,'
					    .'YISGRAND.VODOMER.voda,'
					    .'YISGRAND.VODOMER.st,'
					    .'YISGRAND.VODOMER.joint,'
					    .'YISGRAND.VODOMER.place,'
					    .'YISGRAND.VODOMER.nomer,'
					    .'YISGRAND.VODOMER.model,'
					    .'YISGRAND.VODOMER.position, '
					    .'YISGRAND.VODOMER.out, '
					    .'YISGRAND.VODOMER.obr '
					    .' FROM YISGRAND.VODOMER '
					    .' WHERE YISGRAND.VODOMER.filial_id='.$this->filial_id.' '
					    .' AND YISGRAND.VODOMER.spisan=1 '
					    .' ORDER BY YISGRAND.VODOMER.vodomer_id DESC';
					   //print($this->sql); 
					
			break;	
			case "TekNachOrgVodomera":			  
			   $this->sql='SELECT filial_id, data, fdate, usluga, period, sum(zadol) as zadol, hzadol ,edizm, qty,gkal, tarif, sum(nachisleno) as nachisleno, sum(perer) as perer,  sum(itogo) as itogo, sum(oplacheno) as oplacheno,  sum(dolg) as dolg,  hdolg FROM((SELECT 1 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,0 as gkal,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.VODA  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 ) UNION ' 
				  .' (SELECT 2 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,xkub+gkub+people as qty,0 as gkal,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno,dolg,0 as hdolg FROM YISGRAND.STOKI  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 ) UNION '
				  .' (SELECT 3 as p,filial_id,data,DATE_FORMAT(data,"%m-%Y") as fdate,SUBSTRING(`usluga`,1,5) as usluga,CONCAT_WS(" ",mec,god) as period,zadol,0 as hzadol,'
				  .'CASE WHEN people=0 THEN "куб" ELSE "чел" END as edizm,kub+people as qty,gkal,tarif,nachisleno-perer as nachisleno,perer,'
				  .'nachisleno+perer as itogo,oplacheno ,dolg,0 as hdolg FROM YISGRAND.PODOGREV  WHERE filial_id='.$this->filial_id.' ORDER BY data DESC LIMIT 1 ) '
				  .' ORDER BY data DESC ,p) AS a group by p with rollup';
			//print($this->sql); 
			break;
		

// ========== Домовые водомеры ===========

			case "StDvodomer"://применяется			
			$this->sql='SELECT '
					.'YIS.DVODOMER.dvodomer_id,'
					.'YIS.DVODOMER.house_id,'
					.'YIS.DVODOMER.house,'
					.'YIS.DVODOMER.appartment,'
					.'YIS.DVODOMER.nomer,'
					.'YIS.DVODOMER.model_id,'
					.'YIS.DVODOMER.model,'
					.'YIS.DVODOMER.sdate,'
					.'YIS.DVODOMER.pdate,'
					.'YIS.DVODOMER.note ,'
					.'YIS.DVODOMER.out ,'
					.'YIS.DVODOMER.operator '
					.' FROM YIS.DVODOMER '
					.' WHERE YIS.DVODOMER.house_id='.$this->house_id.''
					.' AND YIS.DVODOMER.spisan=0 ';
					//print( $this->sql);  
		      break;	

		      case "StHDVodomer"://применяется			
			     $this->sql='SELECT '
					.'YIS.DVODOMER.dvodomer_id,'
					.'YIS.DVODOMER.house_id,'
					.'YIS.DVODOMER.house,'
					.'YIS.DVODOMER.appartment,'
					.'YIS.DVODOMER.nomer,'
					.'YIS.DVODOMER.model_id,'
					.'YIS.DVODOMER.model,'
					.'YIS.DVODOMER.koef,'
					.'YIS.DVODOMER.sdate,'
					.'YIS.DVODOMER.pdate,'
					.'YIS.DVODOMER.note, '
					.'YIS.DVODOMER.out ,'
					.'YIS.DVODOMER.operator '
					.' FROM YIS.DVODOMER '
					.' WHERE YIS.DVODOMER.house_id='.$this->house_id.''
					.' AND YIS.DVODOMER.spisan=1 ';
			//print( $this->sql);  
		      break;


			  case "StTekPokDVodomera"://применяется	
			    $this->sql='SELECT '
					.'YIS.DVODOMER.dvodomer_id,'
					.'YIS.DVODOMER.house_id,'
					.'YIS.DVODOMER.house,'
					.'YIS.DVODOMER.appartment,'
					.'YIS.DVODOMER.nomer,'
					.'YIS.DVODOMER.model,'
					.'YIS.DVODOMER.note,'
					.'YIS.PDVODOMER.pok_id,'
					.'YIS.PDVODOMER.data,'
					//.'DATE_FORMAT(YIS.PDVODOMER.pdata,"%d-%m-%Y") as fdate,'
					.'DATE_FORMAT(YIS.PDVODOMER.data,"%d-%m-%Y") as fdate,'
					.'YIS.PDVODOMER.pred,'
					.'YIS.PDVODOMER.tek as tekp,'
					.'YIS.PDVODOMER.gkal,'
					.'YIS.PDVODOMER.tek,'
					.'YIS.PDVODOMER.operator '
					.' FROM YIS.PDVODOMER ,YIS.DVODOMER'
					.' WHERE YIS.PDVODOMER.dvodomer_id=YIS.DVODOMER.dvodomer_id AND '
					.' YIS.PDVODOMER.dvodomer_id='.$this->dvodomer_id.' '
					.' ORDER BY YIS.PDVODOMER.data DESC limit 1 ';
					//print_r($this->sql); 
			  break;

			case "StAllPokDVodomera":			
				$this->sql='SELECT YIS.PDVODOMER.pok_id,'
					  .'YIS.PDVODOMER.dvodomer_id,'
					  .'YIS.PDVODOMER.nomer,'
					  .'DATE_FORMAT(YIS.PDVODOMER.data,"%d-%m-%Y") as fdate,'
					  .'YIS.PDVODOMER.pred,'
					  .'YIS.PDVODOMER.tek,'
					  .'YIS.PDVODOMER.kub,'
					  .'YIS.PDVODOMER.gkal,'
					  .'YIS.PDVODOMER.operator '
					  .' FROM YIS.PDVODOMER  '
					  .' WHERE YIS.PDVODOMER.dvodomer_id='.$this->dvodomer_id.''
					  .' ORDER BY YIS.PDVODOMER.data_in DESC ';
					 // print($this->sql);
			break;

			  case "StOrgByDvodomer":// применяется	
			    $this->sql='SELECT '
					.'YISGRAND.TM_ORG_FILIAL.filial_id,'
					.'YISGRAND.TM_ORG_FILIAL.name,'
					.'YISGRAND.TM_ORG_FILIAL.people, '
					.'YISGRAND.TM_ORG_FILIAL.vkl_otopl, '
					.'YISGRAND.TM_ORG_FILIAL.vkl_xvoda, '
					.'YISGRAND.TM_ORG_FILIAL.vkl_stoki, '
					.'YISGRAND.TM_ORG_FILIAL.vkl_gvoda, '
					.'YISGRAND.TM_ORG_FILIAL.gvodomer, '
					.'YISGRAND.TM_ORG_FILIAL.xvodomer, '
					.'YISGRAND.TM_ORG_FILIAL.teplomer, '
					.'YISGRAND.TM_ORG_FILIAL.dteplomer, '
					.'YISGRAND.TM_ORG_FILIAL.nrx_gvs_d, '
					.'YISGRAND.TM_ORG_FILIAL.tarif_gv, '
					.'(SELECT YISGRAND.PODOGREV.`gkal` FROM YISGRAND.PODOGREV '
					.' WHERE YISGRAND.PODOGREV.filial_id = YISGRAND.TM_ORG_FILIAL.filial_id '
					.' ORDER BY YISGRAND.PODOGREV.data DESC LIMIT 1 ) as gkal_podogrev  '
					.' FROM YISGRAND.TM_ORG_FILIAL '
					.' WHERE YISGRAND.TM_ORG_FILIAL.house_id ='.$this->house_id.' '
					.' AND YISGRAND.TM_ORG_FILIAL.dteplomer_id ='.$this->dvodomer_id.'';
					//print_r($this->sql); 
			  break;




		} // End of Switch ($what)	      StWaterHouse
		
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'( '.$this->sql.' )' . $_db->connect_error);
		
		while ($this->row = $this->result->fetch_assoc()) {
			array_push($this->res, $this->row);
		}
		$this->results['data']	= $this->res;
		
		return $this->results;
	}
	public function addVodomer(stdClass $params)
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
		if(isset($params->data_ins) && ($params->data_ins)) {
		  $this->data_ins =$params->data_ins;
		} else {
		  $this->data_ins= '00000000';
		}	
		if(isset($params->nomer) && ($params->nomer)) {
		 $this->nomer = $params->nomer;
		} else {
		  $this->nomer = "";
		}
		 if(isset($params->model_id) && ($params->model_id)) {
		 $this->model_id = $params->model_id;
		} else {
		  $this->model_id = 0;
		}
		 if(isset($params->position) && ($params->position)) {
		 $this->position = $params->position;
		} else {
		  $this->position = "гориз";
		}
		if(isset($params->place) && ($params->place)) {
		 $this->place = $params->place;
		} else {
		  $this->place = "санузел";
		}
		if(isset($params->filial_id) && ($params->filial_id)) {
		  $this->filial_id = (int) $params->filial_id;
		} else {
		  $this->filial_id = 0;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->house_id) && ($params->house_id)) {
		  $this->house_id = (int) $params->house_id;
		} else {
		  $this->house_id = 0;
		}
		if(isset($params->voda) && ($params->voda)) {
		  $this->voda =  $params->voda;
		} else {
		  $this->voda = "Хвода";
		}
		
		if(isset($params->tek) && ($params->tek)) {
		 $this->tek = $params->tek;
		} else {
		  $this->tek = 0;
		}
		if(isset($params->joint) && ($params->joint)) {
		  $this->joint = (int) $params->joint;
		} else {
		  $this->joint = 0;
		}

		if(isset($params->isjoint) && ($params->isjoint)) {
		  $this->isjoint = (int) $params->isjoint;
		} else {
		  $this->isjoint = 0;
		}
		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		 $this->vodomer_id = $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		if(isset($params->joint_id) && ($params->joint_id)) {
		  $this->joint_id = (int) $params->joint_id;
		} else {
		  $this->joint_id = 0;
		}
		if(isset($params->st) ) {
		 $this->st = (int) $params->st;
		} else {
		  $this->st = 1;
		}
		if(isset($params->vd) ) {
		 $this->vd = (int) $params->vd;
		} else {
		  $this->vd = 1;
		}
		if(isset($params->obr) && ($params->obr)) {
		  $this->obr = (int) $params->obr;
		} else {
		  $this->obr = 0;
		}

		switch ($this->what) {
			case "addAppVodomer":
			    $this->sql='CALL YISGRAND.add_avodomer('
							    .$this->house_id.','
							    .$this->address_id.',"'
							    .$this->data_ins.'","'
							    .$this->nomer.'" ,'
							    .$this->model_id.',"'
							    .$this->place.'","'
							    .$this->position.'","'
							    .$this->voda.'",'
							    .$this->st.','
							    .$this->tek.','
							    .'@vodomer_id,@success,@msg)';
			break;
			case "editAppVodomer":			
			      $this->sql='CALL YISGRAND.update_avodomer('
							    .$this->vodomer_id.',"'
							    .$this->data_ins.'","'
							    .$this->nomer.'", '
							    .$this->model_id.',"'
							    .$this->place.'", "'
							    .$this->position.'","'
							    .$this->voda.'", '
							    .$this->st.','
							    .$this->tek.', '
							    .'@success,@msg)';
			break;	
			case "changeAppVodomer":			
			    $this->sql='CALL YISGRAND.change_avodomer('
							    .$this->vodomer_id.','
							    .$this->address_id.',"'
							    .$this->data_ins.'","'
							    .$this->nomer.'",'
							    .$this->model_id.',"'
							    .$this->place.'","'
							    .$this->position.'","'
							    .$this->voda.'",'
							    .$this->st.','
							    .$this->tek.', '
							    .'@vodomer_id,@success,@msg)';
			break;	             
			case "addOrgVodomer":			
			    $this->sql='CALL YISGRAND.add_ovodomer('
							    .$this->joint.','
							    .$this->isjoint.','
							    .$this->joint_id.','
							    .$this->filial_id.',"'
							    .$this->data_ins.'","'
							    .$this->nomer.'",'
							    .$this->model_id.',"'
							    .$this->place.'","'
							    .$this->position.'",'
							    .$this->obr.', "'
							    .$this->voda.'",'
							    .$this->st.','
							    .$this->vd.','
							    .$this->tek.','
							    .'@vodomer_id,@success,@msg)';
			break;	
			case "changeOrgVodomer":			
			    $this->sql='CALL YISGRAND.change_ovodomer('
							    .$this->vodomer_id.','
							    .$this->joint.','
							    .$this->filial_id.',"'
							    .$this->data_ins.'","'
							    .$this->nomer.'",'
							    .$this->model_id.',"'
							    .$this->place.'","'
							    .$this->position.'",'
							    .$this->obr.', "'
							    .$this->voda.'",'
							    .$this->st.','
							    .$this->vd.','
							    .$this->tek.','
							    .'@vodomer_id,@success,@msg)';
			break;	
			case "editOrgVodomer":			
			      $this->sql='CALL YISGRAND.update_ovodomer('
							    .$this->vodomer_id.',"'
							    .$this->data_ins.'","'
							    .$this->nomer.'", '
							    .$this->model_id.','
							    .$this->joint.', "'
							    .$this->place.'", "'
							    .$this->position.'",'
							    .$this->obr.',"'
							    .$this->voda.'",'
							    .$this->st.','
							    .$this->vd.','
							    .$this->tek.', '
							    .'@success,@msg)';

//print($this->sql);
			break;	             

			case "addDVodomer":			
			    $this->sql='CALL YIS.add_dvodomer()';
			break;	    
		}
		$this->result = $_db->query($this->sql) or die('Connect Error in '.$this->what.'(' .  $this->sql . ') ' . $_db->connect_error);

		
		$this->sql_callback='SELECT @vodomer_id,@success,@msg';

		$this->res_callback = $_db->query($this->sql_callback) or die('Connect Error in '.$this->what.'(' .  $this->sql_callback . ') ' . $_db->connect_error);
		
		while ($this->row = $this->res_callback->fetch_assoc()) {
			$this->results['vodomer_id'] = $this->row['@vodomer_id'];
			$this->results['success'] = $this->row['@success'];
			$this->results['msg']	=$this->row['@msg'];
		}			
		return $this->results;

	}
	 public function updateVodomer(stdClass $params)
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

		 if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		 $this->vodomer_id = $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		if(isset($params->nomer) && ($params->nomer)) {
		 $this->nomer = $params->nomer;
		} else {
		  $this->nomer = "";
		}
		 if(isset($params->model_id) && ($params->model_id)) {
		 $this->model_id = (int) $params->model_id;
		} else {
		  $this->model_id = 0;
		}
		 if(isset($params->position) && ($params->position)) {
		 $this->position = $params->position;
		} else {
		  $this->position = "гориз";
		}
		if(isset($params->place) && ($params->place)) {
		 $this->place = $params->place;
		} else {
		  $this->place = "санузел";
		}
		if(isset($params->voda) && ($params->voda)) {
		  $this->voda =  $params->voda;
		} else {
		  $this->voda = "Хвода";
		}
		if(isset($params->st) && ($params->st)) {
		  $this->st = (int) $params->st;
		} else {
		  $this->st = 1;
		}
		if(isset($params->vd) && ($params->vd)) {
		  $this->vd = (int) $params->vd;
		} else {
		  $this->vd = 1;
		}
		if(isset($params->joint) && ($params->joint)) {
		  $this->joint = (int) $params->joint;
		} else {
		  $this->joint = 0;
		}
		if(isset($params->tek) && ($params->tek)) {
		 $this->tek = $params->tek;
		} else {
		  $this->tek = 0;
		}
		if(isset($params->obr) && ($params->obr)) {
		  $this->obr = (int) $params->obr;
		} else {
		  $this->obr = 0;
		}
		
		switch ($this->what) {
			case "AVodomer":
			       $this->sql='CALL YIS.update_avodomer('
							    .$this->vodomer_id.',"'.$this->nomer.'", '
							    .$this->model_id.','
							    .$this->joint.', "'
							    .$this->place.'", "'
							    .$this->position.'",'
							    .$this->obr.',"'
							    .$this->voda.'", '
							    .$this->st.','
							    .'@success,@msg)';				    
			break;
			
			case "DVodomer":			
			     $this->sql='CALL YIS.update_dvodomer('
							    .$this->vodomer_id.',"'.$this->nomer.'", '
							    .$this->model_id.','
							    .$this->joint.', "'
							    .$this->place.'", "'
							    .$this->position.'",'
							    .$this->obr.',"'
							    .$this->voda.'", '
							    .$this->st.','
							    .'@success,@msg)';
			
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

	public function delVodomer(stdClass $params)
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
		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		  $this->vodomer_id = (int) $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		if(isset($params->dvodomer_id) && ($params->dvodomer_id)) {
		  $this->dvodomer_id = (int) $params->dvodomer_id;
		} else {
		  $this->dvodomer_id = 0;
		}
		switch ($this->what) {
			case "AVodomer":
			      $this->sql='CALL YISGRAND.del_avodomer('.$this->vodomer_id.',@success,@msg)';
			break;
			case "OVodomer":			
			      $this->sql='CALL YISGRAND.del_ovodomer('.$this->vodomer_id.',@success,@msg)';
			break;	    
			case "DVodomer":			
			    $this->sql='CALL YIS.del_dvodomer()';
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
		public function spisanVodomer(stdClass $params)
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
		if(isset($params->filial_id) && ($params->filial_id)) {
		  $this->filial_id = (int) $params->filial_id;
		} else {
		  $this->filial_id = 0;
		}
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->filial_id = 0;
		}

		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		  $this->vodomer_id = (int) $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		if(isset($params->dvodomer_id) && ($params->dvodomer_id)) {
		  $this->dvodomer_id = (int) $params->dvodomer_id;
		} else {
		  $this->dvodomer_id = 0;
		}
		
		switch ($this->what) {
			case "AVodomer":
			      $this->sql='CALL YISGRAND.spisan_avodomer('.$this->vodomer_id.',@success,@msg)';
			break;
			case "AVodomerBack":
			      $this->sql='CALL YISGRAND.back_spisan_avodomer('.$this->vodomer_id.',@success,@msg)';
			break;
			case "OVodomer":			
			      $this->sql='CALL YISGRAND.spisan_ovodomer('.$this->filial_id.','.$this->vodomer_id.',@success,@msg)';
			break;	    
			case "DVodomer":			
			      $this->sql='CALL YIS.spisan_dvodomer('.$this->house_id.','.$this->dvodomer_id.',@success,@msg)';
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

public function inVodomerHistory(stdClass $params)
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
		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		  $this->vodomer_id = (int) $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		if(isset($params->dvodomer_id) && ($params->dvodomer_id)) {
		  $this->dvodomer_id = (int) $params->dvodomer_id;
		} else {
		  $this->dvodomer_id = 0;
		}
		
		switch ($this->what) {
			case "AVodomer":
			      $this->sql='CALL YISGRAND.in_avodomer_history('.$this->vodomer_id.',@success,@msg)';
			break;
			case "OVodomer":			
			      $this->sql='CALL YISGRAND.in_ovodomer_history('.$this->vodomer_id.',@success,@msg)';
			break;	    
			case "DVodomer":			
			      $this->sql='CALL YIS.in_dvodomer_history('.$this->dvodomer_id.',@success,@msg)';
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
public function outVodomerHistory(stdClass $params)
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
		if(isset($params->dvodomer_id) && ($params->dvodomer_id)) {
		  $this->dvodomer_id = (int) $params->dvodomer_id;
		} else {
		  $this->dvodomer_id = 0;
		}		
		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		  $this->vodomer_id = (int) $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		
		switch ($this->what) {
			case "AVodomer":
			      $this->sql='CALL YISGRAND.out_avodomer_history('.$this->vodomer_id.',@success,@msg)';
			break;
			case "OVodomer":			
			      $this->sql='CALL YISGRAND.out_ovodomer_history('.$this->vodomer_id.',@success,@msg)';
			break;	    
			case "DVodomer":			
			      $this->sql='CALL YIS.out_dvodomer_history('.$this->dvodomer_id.',@success,@msg)';
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

public function delPokVodomera(stdClass $params)
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
		 if(isset($params->pok_id) && ($params->pok_id)) {
		 $this->pok_id = (int) $params->pok_id;
		} else {
		  $this->pok_id = 0;
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


		switch ($this->what) {
			case "AVodomer":
			      $this->sql='CALL YISGRAND.delete_pokaz_avodomera('.$this->pok_id.','.$this->address_id.',@success,@msg)';
			break;
			case "OVodomer":			
			      $this->sql='CALL YISGRAND.delete_pokaz_ovodomera('.$this->pok_id.','.'@success,@msg)';
			break;	    
			case "DVodomer":			
			      $this->sql='CALL YIS.delete_pokaz_dvodomera('.$this->pok_id.','.$this->house_id.',@success,@msg)';
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
	public function newPokVodomera(stdClass $params)
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
		if(isset($params->nomer) && ($params->nomer)) {
		 $this->nomer = $params->nomer;
		} else {
		  $this->nomer = "";
		}
		 if(isset($params->tek) && ($params->tek)) {
		 $this->tek = $params->tek;
		} else {
		  $this->tek = 0;
		}
		 if(isset($params->newValue) && ($params->newValue)) {
		 $this->pokaz = $params->newValue;
		} else {
		  $this->pokaz = 0;
		}
		if(isset($params->type) && ($params->type)) {
		 $this->type = $params->type;
		} else {
		  $this->type = '';
		}
		
		if(isset($params->address_id) && ($params->address_id)) {
		  $this->address_id = (int) $params->address_id;
		} else {
		  $this->address_id = 0;
		}
		if(isset($params->house_id) && ($params->house_id)) {
		  $this->house_id = (int) $params->house_id;
		} else {
		  $this->house_id = 0;
		}	
		if(isset($params->filial_id) && ($params->filial_id)) {
		  $this->filial_id = (int) $params->filial_id;
		} else {
		  $this->filial_id = 0;
		}
		if(isset($params->vodomer_id) && ($params->vodomer_id)) {
		  $this->vodomer_id = (int) $params->vodomer_id;
		} else {
		  $this->vodomer_id = 0;
		}
		if(isset($params->out) && ($params->out)) {
		  $this->out = (int) $params->out;
		} else {
		  $this->out = 0;
		}
		if(isset($params->days) && ($params->days)) {
		  $this->days = (int) $params->days;
		} else {
		  $this->days = 0;
		}
		switch ($this->what) {
			case "AVodomer":
			      $this->sql='CALL YISGRAND.input_new_pokaz_avodomer('.$this->vodomer_id.','
										  .$this->address_id.',"'										 
										  .$this->type.'",'
										  .$this->tek.','
										  .$this->pokaz.',@success,@msg)';
			break;
			case "insTekPokOrgVod":			
			      $this->sql='CALL YISGRAND.input_new_pokaz_ovodomer('.$this->vodomer_id.',"'
										    .$this->type.'",'
										    .$this->tek.','
										    .$this->pokaz.',@success,@msg)';
			break;
			case "insMiddle":			
			      $this->sql='CALL YISGRAND.input_middle_pokaz_ovodomer('
										      .$this->vodomer_id.','
										      .$this->filial_id.',"'
										      .$this->type.'",'
										      .$this->tek.','
										      .$this->days.','
										      .' @success,@msg)';
			break;	    
			case "insHandOrg":			
			      $this->sql='CALL YISGRAND.input_hand_pokaz_ovodomer('
										    .$this->vodomer_id.','
										    .'"'.$this->type.'",'
										    .$this->tek.','
										    .$this->pokaz
										    .',@success,@msg)';
			break;

			case "insHandApp":			
			      $this->sql='CALL YISGRAND.input_hand_pokaz_avodomer('
										    .$this->vodomer_id.','
										   .$this->address_id.','
										    .'"'.$this->type.'",'
										    .$this->tek.','
										    .$this->pokaz
										    .',@success,@msg)';
			break;

			case "DVodomer":			
			      $this->sql='CALL YIS.input_new_pokaz_dvodomer('.$this->vodomer_id.','.$this->house_id.','
			      .$this->address_id.',"'.$this->nomer.'","'.$this->type.'",'.$this->tek.','.$this->pokaz.',@success,@msg)';

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






/*	public function __destruct()
	{
		$_db = $this->connect($this->login,$this->password);
		$_db->close();
		
		return $this;
	}*/
}