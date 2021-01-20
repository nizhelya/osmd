<?php
$text = <<<EOL
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Загружаем API-->
        <script src="http://api-maps.yandex.ru/2.0/?load=package.full&mode=debug&lang=ru-RU" type="text/javascript"></script>
        <script type="text/javascript">
            /* При успешной загрузке API выполняется
               соответствующая функция */
	      ymaps.ready(function () { 
		/* Создание экземпляра карты и его привязка   к контейнеру с id="YMapsID" */
		    var myMap = new ymaps.Map("ymaps-map-id_134009097390396115204", {
			
				center: [31.10066966036335, 46.62406618904821],	// Центр карты			
				zoom: 10,			// Коэффициент масштабирования			
				type: "yandex#publicMap" 	// Тип карты
    }
);
            });
        </script> 
    </head>
<>
<div id="ymaps-map-id_134009097390396115204" style="width: 800px; height: 600px;"></div>
<div style="width: 600px; text-align: right;"><a href="http://n.maps.yandex.ru/" target="_blank" style="color: #1A3DC1; font: 13px Arial,Helvetica,sans-serif;">Создано с помощью сервиса Яндекса Народная карта.</a></div>
</html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<div id="ymaps-map-id_134009097390396115204" style="width: 800px; height: 600px;"></div>
<div style="width: 600px; text-align: right;"><a href="http://n.maps.yandex.ru/" target="_blank" style="color: #1A3DC1; font: 13px Arial,Helvetica,sans-serif;">Создано с помощью сервиса Яндекса Народная карта.</a></div>
<script type="text/javascript">
function fid_134009097390396115204(ymaps) {
    var map = new ymaps.Map("ymaps-map-id_134009097390396115204", {
        center: [31.10066966036335, 46.62406618904821],
        zoom: 15,
        type: "yandex#publicMap"
    });
    map.controls                // Добавляем панели инструментов
        .add("zoomControl")
        .add("mapTools")
        .add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
    map.geoObjects             // Добавляем объекты на карту
        .add(new ymaps.Placemark([31.099114694215835, 46.623661609339585], {
	    iconContent: 'КП тс Южтеплокоммунэнерго',
            balloonContent: "Адрес"
        }, {
	    preset: 'twirl#blueStretchyIcon'
          
        }))
        .add(new ymaps.Placemark([31.101947106935555, 46.62410511866905], {
            balloonContent: "Текст2"
        }, {
            preset: "twirl#lightblueDotIcon"
        }))
        .add(new ymaps.Placemark([31.100788392641114, 46.62236062754624], {
            balloonContent: "Текст3"
        }, {
            preset: "twirl#lightblueDotIcon"
        }));
};
</script>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_134009097390396115204"></script>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->

EOL;

echo $text;

?>
