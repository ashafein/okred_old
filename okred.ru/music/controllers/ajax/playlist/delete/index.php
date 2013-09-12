<?php

if (!empty($_COOKIE['auth_id']) && !empty($_REQUEST['id'])) {

        include_once '../_php/db.php';
        include_once '../_php/authorization_control.php';

        if (!check_sid()) {
                if (!headers_sent())
                        header("HTTP/1.0 401 Unauthorized");
                die('Unauthorized.');
        }
        $creator = $db->findSingle('music_playlists', array('id', $_REQUEST['id']), array('creator'));
        if( $creator[0]['creator'] != $_COOKIE['auth_id'] ) {
                if (!headers_sent())
                        header("HTTP/1.0 403 Forbidden");
                die('Forbidden.');
        } else {
                echo $db->delete('music_playlists', array('id', $_REQUEST['id']), 1);
        }

} else {
        if (!headers_sent())
                header("HTTP/1.0 400 Bad Request");
        die('Bad request.');
}