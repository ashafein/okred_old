<?php

/*
 * Метод получения плейлистов пользователя. Возвращает массив в формате json из объектов вида {id: 123} или http ошибку
 * без параметров возвращает для текущего пользователя. требует авторизации
 */

if (!empty($_COOKIE['auth_id'])) {
include_once '../_php/db.php';
        include_once '../_php/authorization_control.php';

        if (!check_sid()) {
                if (!headers_sent())
                        header("HTTP/1.0 401 Unauthorized");
                die('Unauthorized.');
        }
        
        $q = $db->find('music_playlists', array('creator', ( !empty($_REQUEST['id']) ? $_REQUEST['id'] : $_COOKIE['auth_id'])), array('id', 'name'));
        if( is_array($q) ) {
                echo json_encode($q);
        } else 
        {
                if (!headers_sent())
                        header("HTTP/1.0 500 Internal Server Error");
                die('Internal Server Error.');
        }

} else {
        if (!headers_sent())
                header("HTTP/1.0 400 Bad Request");
        die('Bad request.');
}