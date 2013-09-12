<?php

if (!empty($_REQUEST['trackname'])) {

        include_once '../_php/db.php';
        
        $_REQUEST['trackname'] = preg_replace("/[\W]+/ui", '', $_REQUEST['trackname']);

        $q = $db->query('SELECT `summary`,`num` FROM `music_votes` WHERE `trackname`="' . $db->escape($_REQUEST['trackname']) . '" LIMIT 1');
        if( empty($q[0]['num']) )
                echo 0;
        else
                echo round(max(min($q[0]['summary'] / $q[0]['num'], 5), 1) * 10) / 10;
} else {
        if (!headers_sent())
                header("HTTP/1.0 400 Bad Request");
        die('Bad request.');
}