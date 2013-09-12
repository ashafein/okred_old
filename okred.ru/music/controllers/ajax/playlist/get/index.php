<?php

/*
 * Метод полного получения плейлиста. требует get-параметры: id плейлиста и указатель трека
 * возвращает id плейлиста в случае успешного сохранения или http ошибку
 */

if (!empty($_REQUEST['id'])) {

        include_once '../_php/db.php';
        
        $q = $db->find('music_playlists', array('id', $_REQUEST['id']), array('id', 'name', 'tracks'));
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