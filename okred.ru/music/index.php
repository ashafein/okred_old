<?php
	include_once('../_php/global_config.php');
	include_once('config.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo isset($title) ? $title : 'Загрузка...'; ?></title>
		<script src="<?php echo HOST; ?>/_js/jquery-1.8.3.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery-ui.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery.cookie.js"></script>
		<script src="/js/uploadPage.jquery.js"></script>
		<link href="<?php echo HOST; ?>/_css/jquery-ui.css?2" rel="stylesheet" type="text/css" />
		<link href="/css/mine_page.css" rel="stylesheet" type="text/css">
		
		<script src="<?php echo COMPONENT_HOST; ?>/js/mediaelement/mediaelement-and-player.js"></script>
		<link rel="stylesheet" href="<?php echo COMPONENT_HOST; ?>/js/mediaelement/mediaelementplayer.css" />
		
		
		<script src="<?php echo COMPONENT_HOST; ?>/js/rating/jquery.rating.pack.js"></script>
		<link rel="stylesheet" href="<?php echo COMPONENT_HOST; ?>/js/rating/jquery.rating.css" />
                
                
		<script src="<?php echo COMPONENT_HOST; ?>/js/main_index.js"></script>
		<link rel="stylesheet" href="<?php echo COMPONENT_HOST; ?>/css/main_index.css" />
		<script>
			$(document).ready(function (){
				$('.upload_page').uploadPage();
				$('.select_search').click(function (){
					alert('вызов');
					//$(this).find('.list_param_search').css('display','inline-block');
				});
			});

			function load_params(t,s){
				if(s == 'select'){
					t.parents('.list_param_search').prev('.selected').text(t.text());
					t.parents('.list_param_search').prev('.selected').attr('id',t.attr('id'));
					$(t.parents('.list_param_search').find('p')).each(function (){
						$(this).removeClass('selected');
					});
					t.addClass('selected');
					t.find('.list_param_search').css('display','none');
					t.removeClass('active');
				}
				else{
					t.addClass('active');
					t.find('.list_param_search').css('display','inline-block');
				}
			}
		</script>
	</head>
	<body>
		<header>
			<menu>
				<li id="search"><a href="http://okred.ru">поиск</a></li>
			<!--<li id="maps"><a href="http://maps.okred.ru">карты</a></li> -->
				<li class="active" id="music">музыка</li>
			<!--<li id="video"><a href="http://video.okred.ru">видео</a></li>
				<li id="games"><a href="http://games.okred.ru">игры</a></li> -->
				<li id="job"><a href="http://job.okred.ru">работа</a></li>
			<!--<li id="auto"><a href="http://auto.okred.ru">авто</a></li>
				<li id="mail"><a href="http://mail.okred.ru">почта</a></li>
				<li id="auth">авторизация</li> -->
			</menu>
		</header>
     <!-- <div id="content_page">
			<div class="search">
				<input type="text" placeholder="Введите запрос">
				<div class="select_search" onclick="load_params($(this))">
					<p class="selected">по исполнителю</p>
					<div class="list_param_search">
						<p class="selected" id="artist" onclick="load_params($(this),'select')">по исполнителю</p>
						<p id="name" onclick="load_params($(this),'select')">по названию</p>
					</div>
				</div>
			</div>
			<div class="content">
				<p>Контент</p>
			</div>
			<div class="filtr">
				<ul>
					<li>Музыка</li>
					<li>Под атмосферу</li>
					<li>Мои плэйлисты</li>
					<li>Подкасты</li>
					<li>Радиостанции</li>
					<li>Добавить трэк</li>
				</ul>
			</div>
		</div> -->
		<footer>
		</footer>
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
		var COMPONENT_HOST = 'http://okred.ru/music';
	</script
</body>
</html>
