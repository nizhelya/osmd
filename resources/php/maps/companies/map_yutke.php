<?php
//echo 'helo!';
/*
if    (isset($_GET['center']) && $_GET['center']) {// центр карты
			$center=$_GET['center'];
		 } else {           
			$center = "";
		}

if    (isset($_GET['placemark']) && $_GET['placemark']) {// отметка
			$placemark=$_GET['placemark'];
		 } else {           
			$placemark = "";
		}


if    (isset($_GET['balloonContent']) && $_GET['balloonContent']) {// содержание описания
			$balloonContent=$_GET['balloonContent'];
		 } else {           
			$balloonContent = "";
		}

if    (isset($_GET['iconContent']) && $_GET['iconContent']) {// содержимое значка
			$iconContent=$_GET['iconContent'];
		 } else {           
			$iconContent = "";
		}

*/


$center = "31.104960392743614, 46.62313075238445";

$placemark = "31.10529513255966, 46.62400028196112";

$balloonContent ="ЖЭК";

$iconContent = "1234567";


echo '
    
   
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<div id="ymaps-map-id_1339839551074831111366" style="width: 600px; height: 450px;"></div>
<div style="width: 600px; text-align: right;"></div>
<script type="text/javascript">
function fid_1339839551074831111366(ymaps) {
    var map = new ymaps.Map("ymaps-map-id_1339839551074831111366", {
        center: ['.$center.'],
        zoom: 16,
        type: "yandex#publicMap"
    });
    map.controls
        .add("zoomControl")
        .add("mapTools")
      //  .add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
    map.geoObjects
        .add(new ymaps.Placemark(['.$placemark.'], {
            balloonContent: "'.$balloonContent.'",
            iconContent: "Офис ЮТКЕ" /*'.$iconContent.'*/
        }, {
            preset: "twirl#blueStretchyIcon"
        }));
};
</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_1339839551074831111366"></script>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->
	

';




?>
