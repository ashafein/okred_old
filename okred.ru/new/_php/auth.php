<div class="mailbox-inner-wrapper">
	<div class="mailbox-widget-signinwith">
		<h3>Войти при помощи:<a class="none" id="none" style="text-decoration: none; margin-top: -20px;padding-left: 2px;" onclick="javascript:$('#mail-widget').css({display: 'none'});">[x]</a></h3>
		<script src="//ulogin.ru/js/ulogin.js"></script>
                <div id="uLogin" data-ulogin="display=small;fields=first_name,last_name,email;optional=bdate,nickname,sex,phone,photo,city,country;providers=vkontakte,odnoklassniki,facebook,twitter,googleplus,google,yandex,mailru,livejournal;hidden=;redirect_uri=<?php echo rawurlencode('http://'. $_SERVER['HTTP_HOST']).rawurlencode(strpos($_SERVER['HTTP_HOST'], 'music') !== false ? '/client.php' : $_SERVER['PHP_SELF']).''?>"></div> 
	</div>
</div>