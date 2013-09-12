<?php //error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(__FILE__));
define('DEFAULT_ERROR_MESSAGE', 'Сервис временно недоступен.');

include implode(DS, array(
    BASEDIR, '_php', 'swing', 'Gy.php'
));
include implode(DS, array(
    BASEDIR, '_php', 'db.php'
));

Gy::app(array(
    'debugMode'=>true,
    'developerMode'=>array(
        'state'=>false,
        /*'ipFilters'=>array(
            '188.168.92.125',
            '95.37.81.202',
        ),*/
    ),
    'charset'=>'utf-8',
    'templatesPath'=>BASEDIR. DS .'_php'. DS .'templates',
    'mainTemplate'=>'layouts'. DS .'index.php',
    'classAutoloadDirs'=>array(
        '_php.controllers',
        '_php.swing',
        '_php',
    ),
    'yandexRequestParams'=>array(
        'host'=>'http://xmlsearch.yandex.com/xmlsearch',
        'user'=>'okred666',
        'key'=>'03.220929676:082022c635db15ee106328c3ac4637ca',
    ),
    'googleRequestParams'=>array(
        'host'=>'http://ajax.googleapis.com/ajax/services/search/web',
        'key'=>'AIzaSyBRwETzaVS-EsPYjFbidXdJjmXJmLm1b2M',
    ),
));


/*
include("_php/beaver.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php meta_data('META'); ?>
</head>
<body>
<?php include('_php/top-menu.php');?>

	<?php include('_php/form_search.php'); ?>
<h1>Сервис временно недоступен</h1>
<?php include('_php/footer.php'); ?>
</body>
</html>*/?>
