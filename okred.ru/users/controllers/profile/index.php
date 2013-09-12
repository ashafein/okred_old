<?php

include_once '../_php/db.php';
//include_once '../_php/authorization_control.php';
//(!empty($_COOKIE['auth']) && check_sid())

$id = ( !empty($_GET['_params'][0]) ? $_GET['_params'][0] : ( !empty($_COOKIE['auth_id']) ? $_COOKIE['auth_id'] : null ) );

if( !$id ) {
	echo 'Bad request.';
} else {
	if( preg_match("/\D/", $id) ) {
		$user = $db->findSingle('users', array('nickname', $id, 'OR', 'fio', $id));
	}
	else {
		$user = $db->findSingle('users', array('id', $id));
	}
	$user = is_array($user)?$user[0]:$user;
	
	$user['nickname'] = empty($user['nickname'])?$user['fio']:$user['nickname'];
}