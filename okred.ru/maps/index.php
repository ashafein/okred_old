<?php include("../_php/beaver.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php meta_data('META'); ?>
 <script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU"
            type="text/javascript"></script>
    <script type="text/javascript">
        // Как только будет загружен API и готов DOM, выполняем инициализацию
        ymaps.ready(init);

        function init () {
            var myMap = new ymaps.Map('map', {
                    center: [53.734, 34.248],
                    zoom: 6,
                    type: 'yandex#hybrid'
                });
          
            ymaps.route(['Москва', 'Киев'])
                .then(function (route) {
                    myMap.geoObjects.add(route);
                    var points = route.getWayPoints();
                     points.get(0).options.set({
                            iconLayout: 'default#image',
                            iconImageHref: '/i/maps/moscow-emblem.png',
                            iconImageSize: [70, 90],
                            iconImageOffset: [-40, -95]
                        });
                        points.get(1).options.set({
                            iconLayout: 'default#image',
                            iconImageHref: '/i/maps/kiev-emblem.png',
                            iconImageSize: [70, 90],
                            iconImageOffset: [-37, -97]
                        });
                 },
                 function (error) {
                     alert('Возникла ошибка: ' + error.message);
                 });
            
            myMap.balloon.open([53.191, 34.605], {
                contentHeader:'Дорога',
                contentBody:'Дорога длинная была <br><img width = "120px" height align="50px" src = "/i/maps/doroga.jpg"/>'
            });
            
            myMap.controls
                .add('zoomControl')
                .add('typeSelector')
                .add('mapTools')
                .add('searchControl');
        }
    </script>
</head>
<body>
<?php include('../_php/top-menu.php');?>
    	<table class="table-frame">
        	<tbody>
                <tr class="searchbox-holder">
                	<td id="form" class="a" colspan="8">
                    <div id="search_f">
                    	<?php include('../_html/f.html'); ?>
                    </div>
                    </td>
        		</tr>
                <tr class="content-holder">
                	<td class="a"><p>БЛОК РЕКЛАМЫ</p>
<div style="width:250px; height:450px; border:1px #FF0000 solid">
рекламка google
</div></td>
                    <td class="m20"><div class="td-margin-20"></div></td>
                    <td colspan="4"><div id='map' style='width:700px; height:550px'></div></td>
                    <td class="m20"><div class="td-margin-20"></div></td>
        		</tr>
        	</tbody>
        </table>

<?php include('../_php/footer.php'); ?>
</body>
</html>
