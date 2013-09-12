<?php

/*
 * Автор: NeZeD
 *
 * Метод для создание плейлиста. Возвращает ID созданного листа или http ошибку
 */

if (!empty($_COOKIE['auth_id']) && !empty($_REQUEST['name'])) {

        include_once '../_php/db.php';
        include_once '../_php/authorization_control.php';

        if (!check_sid()) {
                if (!headers_sent())
                        header("HTTP/1.0 401 Unauthorized");
                die('Unauthorized.');
        }
        $num_playlists = $db->query('SELECT COUNT(*) FROM `music_playlists` WHERE `creator`=' . $db->escape($_COOKIE['auth_id']));

        if ($num_playlists[0]['COUNT(*)'] > 50) {
                if (!headers_sent())
                        header("HTTP/1.0 403 Forbidden");
                die('Forbidden.');
        }

        $t = time();
        $_REQUEST['tracks'] = (!empty($_REQUEST['tracks'])) ? $_REQUEST['tracks'] : '[]';
        $_REQUEST['tracks'] = (@json_decode($_REQUEST['tracks'])) ? $_REQUEST['tracks'] : '[]';
        $_REQUEST['tracks'] = str_ireplace(array('>', '<'), array('&lt;', '&gt; '), $_REQUEST['tracks']);

        if ($db->insert('music_playlists', array('name' => htmlspecialchars($_REQUEST['name']), 'creator' => $_COOKIE['auth_id'],
                    'tracks' => $_REQUEST['tracks'], 'num' => 0, 'create' => $t, 'lastupdate' => $t))) {
                $q = $db->query('SELECT last_insert_id()');
                echo $q[0]['last_insert_id()'];
        } else {
                if (!headers_sent())
                        header("HTTP/1.0 500 Internal Server Error");
                die('Internal Server Error.');
        }
} else {
        if (!headers_sent())
                header("HTTP/1.0 400 Bad Request");
        die('Bad request.');
}