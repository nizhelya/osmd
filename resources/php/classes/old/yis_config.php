<?php 
function get_client_ip() {
     $ipaddress = '';
     if (isset($_SERVER['HTTP_CLIENT_IP']) AND ($_SERVER['HTTP_CLIENT_IP']))
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND ($_SERVER['HTTP_X_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_X_FORWARDED']) AND ($_SERVER['HTTP_X_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if(isset($_SERVER['HTTP_FORWARDED_FOR']) AND ($_SERVER['HTTP_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_FORWARDED']) AND ($_SERVER['HTTP_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if(isset($_SERVER['REMOTE_ADDR']) AND ($_SERVER['REMOTE_ADDR']))
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = '10.1.0.104';
     return $ipaddress; 
}
$ip = get_client_ip();
switch ($ip) {
#Мой
case "127.0.0.1":
case "10.1.0.104":
#Artushkina
case "195.138.90.24":
#УТиСЗН
case "195.5.5.205":
#Львова
case "10.3.1.70":

#$house_id="2,3,4,7,10,11,16,17,20,28,29,32,33,34,35,40,41,42,44,46,48,50,51,52,188";
#$osmd_id = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24";
$house_id="28,29";
$osmd_id = "11";
break;
#Строителей 21
case "10.0.4.234":
case "10.4.0.234":
$house='35';
$osmd = "17";
break;
#Шевченко 5
case "10.1.0.57":
case "10.0.128.22":
$house_id="2";
$osmd_id = "1";
break;
#Шевченко 7
case "85.238.103.208":
$house_id="3";
$osmd_id = "7";
break;
#Шевченко 9
case "10.1.0.227":
$house_id="4";
$osmd_id = "2";
break;
#Химиков 18
case "10.4.0.166":
case "185.177.243.102":
$house_id="44";
$osmd_id = "20";
break;
#НБ-30
case "10.0.0.112":
$house_id="52";
$osmd_id = "23";
break;
#Миру 16 
case "91.222.83.14":
$house_id="7";
$osmd_id = "8";
break;
#Миру 26 
case "91.222.80.13":
$house_id="16";
$osmd_id = "3";
break;
#Химиков 10
case "10.0.0.84":
$house_id="41";
$osmd_id = "6";
break;
#Химиков 12
case "10.0.0.14":
$house_id="42";
$osmd_id = "19";
break;

#Химиков 22
case "10.4.0.64":
case "10.4.1.42":
$house_id="46";
$osmd_id = "21";
break;
#Строителей 3
case "10.1.1.242":
$house_id="32";
$osmd_id = "15";
break;
#Строителей 9
case "91.222.81.152":
case "188.115.130.174":
case "10.3.0.57":
$house_id="33";
$osmd_id = "16";

break;
#Строителей 13
case "185.177.243.18":
$house_id="34";
$osmd_id = "4";
break;
#Приморская 21 
case "10.2.1.127":
case "10.2.0.77":
case "10.2.0.13":
$house_id="51";
$osmd_id = "12";
break;
#Приморская 13 
case "195.138.71.7":
$house_id="48";
$osmd_id = "5";
break;
#АОСББ
case "195.138.91.135":
case "195.138.92.215":
case "78.26.206.155":
case "178.33.149.43":
$house_id="2,3,10,17,40,42,44,50";
$osmd_id = "1,7,9,13,18,19,20,22";
break;
#Гр.Десанта 24,26
case "91.222.81.150":
case "91.222.83.13":
$house_id="28,29";
$osmd_id = "11";
break;
#Гр.Десанта 14
case "10.3.0.3":
$house_id="20";
$osmd_id = "14";
break;
#ДОБРОБУТ
case "10.0.128.3":
case "10.0.128.22":
case "10.0.128.23":
case "194.143.137.137":
$house_id="4,16,34,41,48";
$osmd_id = "24";
break;
}
 define('LOGIN',	'cthubq');
 define('PASSWORD',	'hfljyt;crbq');
 define('OSMD',$osmd_id);
 define('HOUSE',$house_id); 

?>