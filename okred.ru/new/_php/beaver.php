<?php
//База данных
function db_connect($qwerty) {
$host = "localhost";
$dbname = "service-toshiba_okred";
$login = "service-toshiba";
$pass = "nixon2012";

$connect=@mysql_connect($host,$login,$pass);
$db=@mysql_select_db($dbname,$connect);
$res=@mysql_query($qwerty,$connect);
return $res;
}
//Мета данные

function poddomen(){
	$url_f = $_SERVER['SERVER_NAME'];

	$poddomen = '';
	if(strpos($url_f, 'job') > -1)
		$poddomen = 'job';
	if(strpos($url_f, 'auto') > -1)
		$poddomen = 'auto';
	if(strpos($url_f, 'music') > -1)
		$poddomen = 'music';
	if(strpos($url_f, 'games') > -1)
		$poddomen = 'games';
	if(strpos($url_f, 'maps') > -1)
		$poddomen = 'maps';
	if(strpos($url_f, 'video') > -1)
		$poddomen = 'video';
	if(strpos($url_f, 'pochta') > -1)
		$poddomen = 'pochta';
	if(empty($poddomen))
		$poddomen = 'okred';
	return $poddomen;
}
function meta_data($type){
	switch($type){
		case 'META': 
			switch(poddomen()){
				case 'okred': echo('<title>OKred - Новая поисковая система</title>

<link href="_css/base.css" rel="stylesheet" type="text/css" />
<link href="_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="_js/jquery-1.8.3.js"></script>
<script src="_js/jquery-ui.js"></script>
<script src="_js/jquery.mousewheel.min.js"></script>
<script src="_js/jquery.cookie.js"></script>
<script src="_js/jquery.listen.js"></script>
<script src="_js/search-input.js"></script>
<script src="_js/tipsy.js"></script>
<script src="source/jquery.fancybox.js?v=2.1.4"></script>
<script src="_js/js.js"></script>');
				break;
				case 'job': echo('
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="_css/job.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
				case 'maps': echo('<title>maps.OKred - Новая поисковая система</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
				case 'music': echo('<title>Музыка на okred.ru</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
				case 'video': echo('<title>Видео на okred.ru</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
				case 'games': echo('<title>Игры на okred.ru</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
				case 'pochta': echo('<title>Почта на okred.ru</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
				case 'auto': echo('<title>Автомобили на okred.ru</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="http://okred.ru/_js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/_js/jquery-ui.js"></script>
<script src="http://okred.ru/_js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/_js/jquery.cookie.js"></script>
<script src="http://okred.ru/_js/jquery.listen.js"></script>
<script src="http://okred.ru/_js/search-input.js"></script>
<script src="http://okred.ru/_js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/_js/js.js"></script>');
				break;
			}
		break;
	}
}

//Авторизация и Cookie
if(empty($_COOKIE)){
	setcookie("search", "y");
}
?>