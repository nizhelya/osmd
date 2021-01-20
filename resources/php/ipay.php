<?php
include_once 'ipay.class.php';
include_once 'ipay_config.php';
include_once 'XmlToArray.php';

$b = fopen("/tmp/ipay.txt", "w"); 
$kod = 0;
try {
if    (isset($_POST['xml']) && !empty($_POST['xml'])) {//код подтверждения 
			$code = $_POST['xml'];
			// ==================== XML TO ARRAY
			$xmlresult = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $code );
			$array = XML2Array::createArray($xmlresult);
			$paym = $array['payment'];
			$pid = $paym['@attributes']['id'];
			$pstatus = $paym['status'];
			$psalt = $paym['salt'];
			$psign = $paym['sign'];


			$iPay = new iPay(  MID , MKEY ,SKEY );
			$iPay->set_urls('http://yis.yuzhny.com/kommuna/php','http://is.yuzhny.com/is/');
			if ($iPay->check_sign($psalt,$psign)) { 
			  if ($pstatus == 5) {

					$_db = new mysqli('localhost', LOGIN ,PASSWORD, 'YIS');		
								if ($_db->connect_error) {
						die('Connection Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
					}
					$_db->set_charset("utf8");
    

					$sql='SELECT count(YIS.PAYMENT.`payment_id`) as cnt	FROM YIS.PAYMENT 	WHERE '
								.' YIS.PAYMENT.`pay_id`="'.$pid.'" AND '
								.' YIS.PAYMENT.`status`<> 5 ';

					$result = $_db->query($sql) or die('Connect Error in  (' .  $sql . ') ' . $_db->connect_error);
					$row_cnt = $result->num_rows;
					if ($row_cnt > 0 ) {
									$_sql_update='UPDATE YIS.PAYMENT SET YIS.PAYMENT.`status` = "'.$pstatus.'" WHERE  '
								.' YIS.PAYMENT.`pay_id`="'.$pid.'"  LIMIT 1';
										$_result = $_db->query($_sql_update) or die('Connect Error (' . $_db->connect_errno . ') ' . $_db->connect_error);
										$rows=mysqli_affected_rows($_db);
									if ($rows > 0 ) {
														$sql_opl='CALL YISGRAND.OplataPaymentApp("'.$pid.'", @success, @msg)';
														$result_opl = $_db->query($sql_opl) or die('Connect Error (' . $sql_opl . ') ' . $_db->connect_error);				    
														$result_opl_callback='SELECT @success, @msg';
														$res_opl_callback = $_db->query($result_opl_callback) or die('Connect Error in (' .  $result_opl_callback . ') ' . $_db->connect_error);										
														while ($res_row = $res_opl_callback->fetch_assoc()) {
															$results['success'] = $res_row['@success'];
															$results['msg']	=$res_row['@msg'];
														}	
																if ($results['success'] == "1") {
																		$kod =  '200';
																}

									}else{
											throw new Exception('Процедура оплаты не выполнена!');
									}
					}else{
						throw new Exception('Не найден платеж со статусом 1');
					}
			} else {
					throw new Exception('Статус платежа '.$pstatus.'');
			}

		 } else {     
		throw new Exception('Верификация поступившей нотификации не прошла проверку ');
		}

} else {     
		throw new Exception('Нет нотификации POST пустой');
		}
}
catch(Exception $e){
		$r['message'] = $e->getMessage();
		
	}
fwrite($b,print_r($r)); 
	  return print($kod);

?>