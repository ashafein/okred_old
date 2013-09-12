<?php

function _security_hash($a, $b, $c) {
        return md5('%^&*(Fn'.$a.'\\'.$c.'=+'.$b);
}
function check_sid() {
        global $db;
	if( empty($_COOKIE['auth_id']) )
		return false;
        $_COOKIE['auth_id'] = mysqli_real_escape_string($db->connection, $_COOKIE['auth_id']);
        $q = $db->query('SELECT `email`, `pass` FROM `users` WHERE `id`=\''.$_COOKIE['auth_id'].'\' LIMIT 1;');
        return ($_COOKIE['auth_sid'] == _security_hash($_COOKIE['auth_id'], $q[0]['email'], $q[0]['pass']));
}



/*
 * АХАХАХАХАХААХА
 * NeZeD и SwInG не несут ответственности за этот говнокодище, так как не являются авторами =D
 */
$cooks = '';
include_once 'global_config.php';
include_once 'db.php';
//include_once 'authorization_control.php';

$domain = explode('.', $_SERVER['HTTP_HOST']);
$domain = '.' . $domain[count($domain) - 2] . '.' . $domain[count($domain) - 1]; //узнаем корневой домен

define('month', 3600 * 24 * 30);
define('domain', $domain);

if (!function_exists('_cookie_')) {

        function _cookie_($name, $val, $exp = month, $path = '/', $domain = domain) {
                global $cooks;
                $cooks .= '$.cookie("' . $name . '", null);'.PHP_EOL;
                $cooks .= '$.cookie("' . $name . '", "' . $val . '", {expires: ' . $exp . ', path: "' . $path . '", domain: "' . $domain . '"});' . PHP_EOL;

                $_COOKIE[$name] = $val;
                if (!headers_sent()) {
                        setcookie($name, $val, time() + $exp, $path, $domain);
                }
                return;
        }

}

$_SERVER['HTTP_HOST'] = str_replace('www', '', $_SERVER['HTTP_HOST']);

/*
 * Если переход с формы авторизации в соц. сети сервисом ulogin
 */
//$db -> show_query = true;
if (!empty($_POST['token'])) {
        //file_put_contents('token.log', $_POST['token'] . PHP_EOL, FILE_APPEND);
        /*
         * получаем информацию авторизации с сервера
         */
        $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $user = json_decode($s, true);

        //var_dump($user);
        // выполняем запрос проверки существования пользователя в базе
        $sql = 'SELECT count(*), email, fio, nickname,id,pass FROM users WHERE email="' . $user['email'] . '" LIMIT 1;';
        $db = new db;
        $res = $db->query($sql);
        if ($res[0]['count(*)'] > 0) {
                _cookie_("auth", 1);
                //_cookie_("auth_email", $res[0]['email']);
                _cookie_("auth_fio", $res[0]['fio']);
                _cookie_("auth_nickname", $res[0]['nickname']);
                _cookie_("auth_id", $res[0]['id']);
                _cookie_('auth_sid', _security_hash($res[0]['id'], $res[0]['email'], $res[0]['pass']));
        } else {
                // если новый пользователь
                $sql_arr = array();
                $sql_arr['email'] = $user['email'];
                $sql_arr['pass'] = substr(strrchr($user['identity'], '/'), 1);
                $sql_arr['fio'] = $user['first_name'] . ' ' . $user['last_name'];
                $sql_arr['network'] = $user['network'];
                if (!empty($user['nickname']))
                        $sql_arr['nickname'] = $user['nickname'];
                if (!empty($user['sex'])) {
                        if ($user['sex'] == 2)
                                $sql_arr['gender'] = "Мужской";
                        else
                                $sql_arr['gender'] = "Женский";
                }
                if (!empty($user['phone']))
                        $sql_arr['telephone'] = $user['phone'];
                if ((!empty($user['photo'])) and ($user['photo'] != 'https://ulogin.ru/img/photo.png'))
                        $sql_arr['foto1'] = $user['photo'];
                // записываем в БД и получаем его новоиспеченный id
                if ($db->insert('users', $sql_arr)) {
                        $q = $db->query('SELECT `id`,`pass` FROM `users` WHERE `email`=\'' . $user['email'] . '\' LIMIT 1;');
                }
                // куячив в кукис
                _cookie_("auth", 1);
                //_cookie_("auth_email", $user['email']);
                _cookie_("auth_fio", $user['first_name'] . ' ' . $user['last_name']);
                _cookie_("auth_nickname", $user['nickname']);
                _cookie_("auth_id", $q[0]['id']);
                _cookie_('auth_sid', _security_hash($q[0]['id'], $user['email'], $q[0]['pass']));

                //header('Location: /');
                //$cooks .= 'window.location.href = "/";'.PHP_EOL;
        }
        file_put_contents('ayth.log', $_SERVER['REQUEST_URI'].' '.$_POST['token'].PHP_EOL.$cooks);
} else if (isset($_POST['passwd'])) {
        $_POST['login'] = trim($_POST['login']);
        $db = new db;
        $sql = 'SELECT count(*), email, fio, nickname,id,pass FROM users WHERE (`email`=\'' . $_POST['login'] . '\' OR `nickname` = \'' . $_POST['login'] . '\') AND (`pass`=\'' . $_POST['passwd'] . '\') LIMIT 1;';
        $res = $db->query($sql);
        if ($res[0]['count(*)'] > 0) {
                _cookie_("auth", 1);
                //_cookie_("auth_email", $res[0]['email']);
                _cookie_("auth_fio", $res[0]['fio']);
                _cookie_("auth_nickname", $res[0]['nickname']);
                _cookie_("auth_id", $res[0]['id']);
                _cookie_('auth_sid', _security_hash($res[0]['id'], $res[0]['email'], $res[0]['pass']));
        } else {
                echo '<script>alert("Вы ввели неправильный пароль")</script>';
        }
}

define('authorized', (!empty($_COOKIE['auth']) && check_sid()));