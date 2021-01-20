<?php

		if    (isset($_GET['login']) && !empty($_GET['login'])) {//код подтверждения 
			$login=$_GET['login'];
		 } else {     
			//print($_GET['code']);
			throw new Exception('Вы  зашли на страницу без кода подтверждения!');
		}
		 if    (isset($_GET['password']) && !empty($_GET['password'])){ //код подтверждения 
			$password=$_GET['password'];
		 } else {     }

      
		 if    (isset($_GET['dog_id']) && !empty($_GET['dog_id'])){ // договор
			$dog_id=$_GET['dog_id'];
		 } else {     }

 if ($login==1 and $password==1 and $dog_id==1) {


echo '

<!DOCTYPE html>

<!-- Auto Generated with Sencha Architect -->
<!-- Modifications to this file will be overwritten. -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>kommuna</title>
</head>
<body>


<table id="1">
<tbody>
<tr>
<td>
<div id="yui" class="">
<a>10/и</a>
</div>
</td>
</tr>
</tbody>
</table>

<table id="3">
<tbody>
<tr>
<td>
<div id="yu" class="">
<a>15/01/2005</a>
</div>
</td>
</tr>
</tbody>
</table>

<table id="FIO">
<tbody>
<tr>
<td>
Иванов
</td>
</tr>
</tbody>
</table>


</body>
</html>

';



}