<?php
include_once('../_php/global_config.php');
include_once('../_php/beaver.php');
include_once('config.php');
include_once('api.php');
include_once('../_php/authorization_control.php');

define('is_xmlrequest', isset($_SERVER['HTTP_X_REQUESTED_WITH']));

if (empty($_GET['dir']))
        $_GET['dir'] = '';
/*
if (!isset($_GET['dir'])) {
        $_GET['dir'] = 'index.php';
}
 */
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
if (!isset($_REQUEST['_params']))
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
?>
<?php if (!is_xmlrequest) { ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
                <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <?php //meta_data('META');    ?>
                        <title>Музыка на okred.ru</title>

                        <link href="<?php echo HOST; ?>/_css/jquery-ui.css?2" rel="stylesheet" type="text/css" />
                        <link href="<?php echo HOST; ?>/_css/base.css?2" rel="stylesheet" type="text/css" />
                        <link href="<?php echo COMPONENT_HOST; ?>/css/client.css" rel="stylesheet" type="text/css" />
                        <?php if (file_exists('css' . $controllerDir . preg_replace("/\.\w*$/ui", '.css', $fname) )) : ?>
                                <link href="<?php echo 'css' . $controllerDir . preg_replace("/\.\w*$/ui", '.css', $fname); ?>" rel="stylesheet" type="text/css" />
                        <?php endif; ?>
            <!--            <link href="<?php echo HOST; ?>/_css/tipsy.css" rel="stylesheet" type="text/css" />
                        <link rel="stylesheet" type="text/css" href="<?php echo HOST; ?>/source/jquery.fancybox.css?v=2.1.4" media="screen" />-->

                        <script src="<?php echo HOST; ?>/_js/jquery-1.8.3.js"></script>
                        <script src="<?php echo HOST; ?>/_js/jquery-ui.js"></script>
                        <script src="<?php echo HOST; ?>/_js/jquery.mousewheel.min.js"></script>
                        <script src="<?php echo HOST; ?>/_js/jquery.cookie.js"></script>
                        <?php if (file_exists('js' . $controllerDir . preg_replace("/\.\w*$/ui", '.js', $fname) )) : ?>
                                <script src="<?php echo 'js' . $controllerDir . preg_replace("/\.\w*$/ui", '.js', $fname); ?>"></script>
                        <?php endif; ?>

                        <script type="text/javascript">
                                var HOST = '<?php echo HOST; ?>';
                                var COMPONENT_HOST = 'http://okred.ru/msu';
                                if(document.location.href.search('logout').length != -1)
                                {
        <?php echo (empty($_GET['logout']) ? $cooks : ''); ?>
                                                }
                                                if (window.top == window)
                                                {
                                                        console.log(document.location.href);
                                                        console.log(document.location.href.replace(COMPONENT_HOST+'/', '').replace(/#.*$/i, '').replace(/\/(index|client).php$/i, '/')<?php echo isset($_GET['dir']) ? '.replace(/' . addcslashes($_GET['dir'], "\\\'\"&\n\r<>\/.") . '(.*)$/i, "#!/' . addcslashes($_GET['dir'], "\\\'\"&\n\r<>\/.") . '$1")' : ''; ?>);
                                                        document.location = '<?php echo (strpos($_SERVER['HTTP_HOST'], 'music') === false ? '/music' : '/'); ?>' + document.location.href.replace(COMPONENT_HOST+'/', '').replace(/#.*$/i, '').replace(/\/(index|client).php$/i, '/')<?php echo isset($_GET['dir']) ? '.replace(/' . addcslashes($_GET['dir'], "\\\'\"&\n\r<>\/.") . '(.*)$/i, "#!/' . addcslashes($_GET['dir'], "\\\'\"&\n\r<>\/.") . '$1")' : ''; ?>;
                                                } 
                                                else
                                                {
                                                        if (typeof window.parent.newHash == "function")
                                                                window.parent.newHash();
                                                }
                        </script>

                        <script src="<?php echo COMPONENT_HOST; ?>/js/client.js"></script>

                </head>
                <body>
                        <a class="scroll-btn" onclick="$('html,body').animate({scrollTop: 0});"></a>
                        <div id="dialog-message"></div>
                        <div id="forjs" style="display: none"><div id="1"></div><div id="2"></div><!--что-то вроде временного блока, в котором будут парсится html при ajax запросах--></div>
                        <?php include_once('../_php/top-menu.php'); ?>

                        <div class="content-wrapper">
                                <?php
                        }
                        //echo 'controllers' . $controllerDir . $fname . '<small><pre> $_GET: ' . print_r($_GET, true) . '</pre></small><hr/>';
                        if (file_exists('controllers' . $controllerDir . $fname)) {
                                include_once 'controllers' . $controllerDir . $fname;
                                if (file_exists('view' . $controllerDir . $fname))
                                        include_once 'view' . $controllerDir . $fname;
                        } else {
                                echo '<h1>There was an error, damn!</h1>';
                        }

                        $db->close();
                        ?>
                        <?php if (!is_xmlrequest) { ?>
                        </div>
                        <?php include_once('../_php/footer.php'); ?>
                </body>
        </html>
<?php }
?>                                                                                                                                                                                                  		