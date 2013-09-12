<?php
include_once('../_php/global_config.php');
include_once('../_php/beaver.php');

define('is_xmlrequest', isset($_SERVER['HTTP_X_REQUESTED_WITH'])); //убрал проверку какой именно x-request, потому как самые популярные: flash, air, xmlhttp, а это все ajax по сути

if (empty($_GET['dir']))
        $_GET['dir'] = '';
?>
<?php if (!is_xmlrequest) { ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
                <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <?php //meta_data('META');  ?>
                        <title>Профиль пользователя</title>

                        <link href="<?php echo HOST; ?>/_css/base.css?2" rel="stylesheet" type="text/css" />
						<link href="/users/css/users.css" rel="stylesheet" type="text/css" />

                                <!--            <link href="<?php echo HOST; ?>/_css/tipsy.css" rel="stylesheet" type="text/css" />
                                <link rel="stylesheet" type="text/css" href="<?php echo HOST; ?>/source/jquery.fancybox.css?v=2.1.4" media="screen" />-->

                </head>
                <body>
                        <div id="forjs" style="display: none"><div id="1"></div><div id="2"></div><!--что-то вроде временного блока, в котором будут парсится html при ajax запросах--></div>
                        <?php include_once('../_php/top-menu.php'); ?>

                        <div class="content-wrapper">
                        <?php
                        }

                        error_reporting(E_ALL - E_NOTICE);
                        if (!isset($_GET['dir'])) {
                                $_GET['dir'] = 'index.php';
                        }
                        $DIR = explode('/', trim($_GET['dir'], '/'));
                        $i = 0;
                        $len = sizeof($DIR);

                        // Узнаем какая честь пути относится к расположению .php
                        $controllerDir = '';
                        while (isset($DIR[$i]) && is_dir('controllers' . $controllerDir . '/' . $DIR[$i]) && $i < $len) {
                                $controllerDir .= '/' . $DIR[$i++];
                        }
                        $controllerDir = rtrim($controllerDir, '/') . '/';
                        // получаем название исполняемого .php
                        if (isset($DIR[$i]) && (strpos($DIR[$i], '.') !== false) && file_exists('controllers' . $controllerDir . $DIR[$i])) {
                                $fname = $DIR[$i];
                                $i++;
                        } else {
                                $fname = 'index.php';
                        }
                        if(!isset($_REQUEST['_params']))
                                $_REQUEST['_params'] = array();
                        // вносим параметры в $_GET
                        for ($j = $i; $j < $len; $j++) {
                                $sepratorPos = strpos($DIR[$j], ':');
                                if ($sepratorPos === false) {
                                        $_GET['_params'][] = $DIR[$j];
                                        $_REQUEST['_params'][] = $DIR[$j];
                                } else {
                                        $_REQUEST[substr($DIR[$j], 0, $sepratorPos)] = $_GET[substr($DIR[$j], 0, $sepratorPos)] = substr($DIR[$j], $sepratorPos + 1, strlen($DIR[$j]));
                                }
                        }

                        //echo 'controllers' . $controllerDir . $fname . '<small><pre> $_GET: ' . print_r($_GET, true) . '</pre></small><hr/>';
                        if (file_exists('controllers' . $controllerDir . $fname)) {
                                include_once 'controllers' . $controllerDir . $fname;
                                if (file_exists('view' . $controllerDir . $fname))
                                        include_once 'view' . $controllerDir . $fname;
                        } else {
                                echo '<h1>There was an error, damn!</h1>';
                        }
                        ?>
                <?php if (!is_xmlrequest) { ?>
                        </div>
        <?php include_once('../_php/footer.php'); ?>
                </body>
        </html>
<?php }
?>                                                                                                                                                                                                  