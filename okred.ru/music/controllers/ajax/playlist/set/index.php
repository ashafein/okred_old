<?php

	/*
		* Метод добавления трека в плейлист. требует get-параметры: id плейлиста и указатель трека
		* возвращает id плейлиста в случае успешного сохранения или http ошибку
	*/
		if (!empty($_COOKIE['auth_id']) && !empty($_REQUEST['id'])) {
			
			include_once '../_php/db.php';
			include_once '../_php/authorization_control.php';
			
			if (!check_sid()) {
				if (!headers_sent())
					header("HTTP/1.0 401 Unauthorized");
				die('Unauthorized.');
			}
			
			$q = $db->findSingle('music_playlists', array('id', $_REQUEST['id'], 'AND', 'creator', $_COOKIE['auth_id']), array('tracks', 'creator'));
			if(sizeof($q) < 1) {
				if (!headers_sent())
					header("HTTP/1.0 404 Not Found");
				die('Not Found.');
			}
                        
                        if( ($q[0]['creator'] != $_COOKIE['auth_id']) || strlen($_REQUEST['name']) > 131070 ) {
                                if (!headers_sent())
                                        header("HTTP/1.0 403 Forbidden");
                                die('Forbidden.');
                        }
			
			$_REQUEST['name'] = htmlspecialchars($_REQUEST['name']);
			if(isset($_REQUEST['tracks']))
			{
				$_REQUEST['tracks'] = (@json_decode($_REQUEST['tracks']))?$_REQUEST['tracks']:'[]';
				$_REQUEST['tracks'] = str_ireplace(array('>', '<'), array('&lt;', '&gt; '), $_REQUEST['tracks']);
				
				if($db->update('music_playlists', array('tracks' => $_REQUEST['tracks'], 'name' => $_REQUEST['name'], 'lastupdate' => time()), array('id', $_REQUEST['id']), 1)) {
					echo $_REQUEST['id'];
				} 
			}
			else if(!empty($_REQUEST['name']))
			{
				if($db->update('music_playlists', array('name' => $_REQUEST['name']), array('id', $_REQUEST['id']), 1)) {
					echo $_REQUEST['id'];
				} 
			}
			
        /*
			*  Переименование
		*/
			if( $_REQUEST['name'] ) {
				$db->update('music_playlists', array('name' => $_REQUEST['name']), array('id', $_REQUEST['id']), 1);
			}
		} else {
			if (!headers_sent())
				header("HTTP/1.0 400 Bad Request");
			die('Bad request.');
		}	