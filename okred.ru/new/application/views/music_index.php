<?php
	include_once('/_php/global_config.php');
	include_once('./config.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo isset($title) ? $title : 'Загрузка...'; ?></title>
		<script src="<?php echo HOST; ?>/_js/jquery-1.8.3.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery-ui.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery.cookie.js"></script>
		<link href="<?php echo HOST; ?>/_css/jquery-ui.css?2" rel="stylesheet" type="text/css" />
		
		<script src="<?php echo COMPONENT_HOST; ?>/js/mediaelement/mediaelement-and-player.js"></script>
		<link rel="stylesheet" href="<?php echo COMPONENT_HOST; ?>/js/mediaelement/mediaelementplayer.css" />
		
		
		<script src="<?php echo COMPONENT_HOST; ?>/js/rating/jquery.rating.pack.js"></script>
		<link rel="stylesheet" href="<?php echo COMPONENT_HOST; ?>/js/rating/jquery.rating.css" />
                
                
		<script src="<?php echo COMPONENT_HOST; ?>/js/main_index.js"></script>
		<link rel="stylesheet" href="<?php echo COMPONENT_HOST; ?>/css/main_index.css" />
	</head>
	<body>
		<div id="dialog-message"></div>
		<a href="http://nezed.ru" id="nezed">NeZeD - Web site developer</a>
		<a href="http://freelance.ru/users/swing1991" id="swing">SwInG - (PHP, JS, Flash) developer</a>
		<div id="frame_box">
				<iframe src="./client.php" width="100%" height="100%"></iframe>
		</div>
		<div id="audio" style="display: none" class="selected">
			<audio id="player" src="http://elisto07d.music.yandex.ru/get-mp3/5d60f9909bbad21c87b20d6b0c6715ad/13fa49c576c/9/data-0.12:105898766848:8111332?track-id=3747481&from=service-search" type="audio/mp3"/>
		</audio>	
	</div>
	<script type="text/javascript">
		var HOST = '<?php echo HOST; ?>';
		var COMPONENT_HOST = '<?php echo COMPONENT_HOST; ?>';
	</script>
</body>
</html>
