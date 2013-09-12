<?php

if (!empty($_COOKIE['auth_id']) && !empty($_REQUEST['vote']) && !empty($_REQUEST['trackname'])) {

        include_once '../_php/db.php';
        include_once '../_php/authorization_control.php';

        if (!check_sid()) {
                if (!headers_sent())
                        header("HTTP/1.0 401 Unauthorized");
                die('Unauthorized.');
        }
        
        $_REQUEST['trackname'] = preg_replace("/[\W]+/ui", '', $_REQUEST['trackname']);
        $_REQUEST['vote'] = max(min($_REQUEST['vote'], 5), 1);

        //define('db', new db);
        //$user = $db->anyfrom("USER");
        /*
         * TODO var validation (sql escape)/ complite
         */
        $q = $db->query('SELECT count(*), uids FROM `music_votes` WHERE `trackname`="' . $_REQUEST['trackname'] . '" LIMIT 1');
        if ((int) $q[0]['count(*)'] < 1) {
                $db->insert('music_votes', array(
                    'trackname' => $_REQUEST['trackname'],
                    'summary' => (int) $_REQUEST['vote'],
                    'num' => 1,
                    'uids' => $_COOKIE['auth_id'] . ':' . (int) $_REQUEST['vote'] . ','
                ));
        } else {
                if (false === ($pos = strpos($q[0]['uids'], $_COOKIE['auth_id'] . ':'))) {
                        $db->update(
                                'music_votes', array(
                            'summary' => array('+', (int) $_REQUEST['vote']),
                            'num' => array('+', 1),
                            'uids' => array('+', $_COOKIE['auth_id'] . ':' . (int) $_REQUEST['vote'] . ',')
                                ), array('trackname', $_REQUEST['trackname']), 1
                        );
                } else {
                        $vpos = strpos($q[0]['uids'], ':', $pos) + 1;
                        $old_vote = substr($q[0]['uids'], $vpos, 1);
                        $q[0]['uids'] = substr($q[0]['uids'], 0, $vpos) . $_REQUEST['vote'] . substr($q[0]['uids'], $vpos + 1);
                        $db->update(
                                'music_votes', array(
                            'summary' => array('+', (int) $_REQUEST['vote'] - (int) $old_vote),
                            'uids' => $q[0]['uids']
                                ), array('trackname', $_REQUEST['trackname']), 1
                        );
                }
        }
        $q = $db->query('SELECT `summary`,`num` FROM `music_votes` WHERE `trackname`="' . $_REQUEST['trackname'] . '" LIMIT 1');
        echo round(max(min($q[0]['summary'] / $q[0]['num'], 5), 1) * 10) / 10;
} else {
        if (!headers_sent())
                header("HTTP/1.0 400 Bad Request");
        die('Bad request.');
}