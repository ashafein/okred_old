<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>maps.okred.ru</title>
</head>
    <!--
        Подключаем API карт 2.x
        Параметры:
          - load=package.full - полная сборка;
	      - lang=ru-RU - язык русский.
    -->
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
<body>
<div id="search_f">
<form action="http://maps.okred.ru/" method="get" target="_self">
<table class="searchbox-container">
    <tbody>
        <tr class="searchbox-menu">
            <td class="a" colspan="7"><div class="searchbox-menu-a">
                <ul class="maxsearchmenu">
                    <li style="float:left" class="m1 current">
                        <a><span>Поиск</span></a>
                    </li>
                    <li style="float:left" class="m2">
                        <a href="http://maps.okred.ru"><span>Карты</span></a>
                    </li>
                    <li style="float:left" class="m3">
                        <a href="http://music.okred.ru"><span>Музыка</span></a>
                    </li>
                    <li style="float:left" class="m4">
                        <a href="http://video.okred.ru"><span>Видео</span></a>
                    </li>
                    <li style="float:left" class="m5">
                        <a href="http://job.okred.ru"><span>Работа</span></a>
                    </li>
                    <li style="float:left" class="m6">
                        <a href="http://games.okred.ru"><span>Игры</span></a>
                    </li>
                </ul>
            </div></td>
        </tr>
        <tr>
            <td class="a"><div class="searchbox-a"><a href="/" title="Перейти на главную"><img id="logo" src="images/logo.png" /></a></div></td>
            <td class="b"><div class="searchbox-b">
                <label for="maxsearch-input" id="maxsearch-label">Для чего бобру мощный хвост</label>
                <input id="maxsearch-input" class="b-form-input__input" maxlength="400" autocomplete="off" name="text" tabindex="1" autofocus type="text">
            </div></td>
            <td class="c"><div class="searchbox-c">
                <div class="ztooltip-e" id="maxsearch-clear" original-title="Очистить строку поиска"></div>
                </div></td>
            <td class="d"></td>
            <td class="e"><div class="searchbox-e"><input class="maxsearch-ok b-form-button__input" type="submit" tabindex="20" value=""></div></td>
            <td class="f"><div class="searchbox-f"></div></td>
        </tr>
    </tbody>
</table>
</form>
</div>

<div id='map' style='width:700px; height:550px'></div>
</body>
</html>