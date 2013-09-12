<?php

if (empty($_GET['_params'][0]))
        die('Bad request');


$q = $db->findSingle('music_playlists', array('id', $_GET['_params'][0]), array('tracks'));
if (sizeof($q) < 1) {
        if (!headers_sent())
                header("HTTP/1.0 404 Not Found");
        die('Not Found.');
}
$playlist = json_decode($q[0]['tracks'], true);

foreach ($playlist as $value) {
        echo 'see this track on Y.M: http://music.yandex.ru/fragment/track/'.substr( strrchr($value['sd'], '.') , 1).'/album/'.$value['aid'].'<br/>';
}