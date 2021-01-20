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
case "195.138.87.207":

#УТиСЗН
case "178.93.2.148":
#Львова
case "10.3.1.70":
case "85.238.102.47";
case "213.174.21.193";
case "85.238.103.44";
#Офис
case "10.3.0.74":

$house_id="2,3,4,7,8,10,11,16,17,20,23,24,28,29,30,31,37,38,32,33,34,35,39,40,41,42,43,44,45,46,47,48,50,51,52,188";
$osmd_id = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,35,37";

break;
case "10.4.0.234":
$house_id="35";
$osmd_id = "17";
break;
#Шевченко 5
case "10.1.0.57":
case "10.0.128.22":
$house_id="2";
$osmd_id = "1";
break;
#Шевченко 7
case "85.238.103.238":
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
case "195.138.94.178":
case "195.66.207.186":
case "45.130.2.225":
case "10.10.0.3":
case "10.10.25.27":

$house_id="52";
$osmd_id = "23";
break;
#Миру 16 
case "91.222.83.14":
case "195.138.88.161":
$house_id="7";
$osmd_id = "8";
break;
#Миру 17 
case "10.5.1.50":
$house_id="8";
$osmd_id = "25";
break;
#Десанта20
case "10.5.0.121":
$house_id="23";
$osmd_id = "26";
break;
#Миру 28 
case "91.222.82.101":
$house_id="17";
$osmd_id = "13";
break;
#Миру 26 
case "195.138.90.24":
$house_id="16";
$osmd_id = "3";
break;
#Миру 21 
case "10.5.0.68":
$house_id="11";
$osmd_id = "10";
break;
#Химиков 10
case "10.0.0.84":
$house_id="41";
$osmd_id = "6";
break;
#Химиков 12
case "10.0.0.14":
case "10.0.1.88":

$house_id="42";
$osmd_id = "19";
break;
#Химиков 20
case "188.115.184.181":
$house_id="45";
$osmd_id = "29";
break;
#Химиков 22
case "10.4.0.64":
case "10.4.1.42":
case "10.2.0.105":
case "10.23.1.1":
case "10.23.1.2":

$house_id="2,3,8,10,17,40,42,44,46,50";
$osmd_id = "1,7,9,13,18,19,20,21,22,25";
break;
#Химиков 2,4
case "10.0.128.38":
case "10.5.1.72":
$house_id="37,38";
$osmd_id = "32,30";
break;
#Химиков 4
case "10.0.0.164":
$house_id="38";
$osmd_id = "30";
break;
#Строителей 3
case "10.1.1.242":
$house_id="32";
$osmd_id = "15";
break;
#Строителей 9
case "91.222.81.152":
case "91.222.81.22":
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
case "10.2.0.105":
case "10.1.1.57":
case "10.23.1.1":
case "10.23.1.2":

case "10.4.0.152":
case "78.26.206.155":
case "178.33.149.43":
$house_id="2,4,3,8,10,40,42,44,45,46,50";
$osmd_id = "1,2,7,9,18,19,20,21,22,25,29";

break;
#Гр.Десанта 24,26
case "91.222.81.150":
case "10.0.128.60":
case "91.222.83.13":
$house_id="28,29,17";
$osmd_id = "11,13";
break;
#Гр.Десанта 12
case "91.222.83.251":
$house_id="19";
$osmd_id = "39";
break;
#Гр.Десанта 14
case "10.3.0.62":
$house_id="20";
$osmd_id = "14";
break;
#ДОБРОБУТ
case "10.0.128.3":
case "10.0.128.22":
case "10.0.128.23":
case "194.143.137.137":
$house_id="34,41,48,24,3";
$osmd_id = "24,7";
break;
}
 define('LOGIN',	'cthubq');
 define('PASSWORD',	'hfljyt;crbq');
 define('OSMD',$osmd_id);
 define('HOUSE',$house_id); 

?>