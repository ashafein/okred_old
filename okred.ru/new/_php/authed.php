<div class="mailbox-inner-wrapper">
	<a href="<?php echo HOST.'/users/profile/'.(!empty($_COOKIE["auth_nickname"])?$_COOKIE["auth_nickname"]:$_COOKIE["auth_id"]) ?>">Профиль</a>
	<br/>
	<a href="javascript:;" onclick="var setc = $.cookie; setc('auth', null);setc('auth_fio', null);setc('auth_nickname', null);setc('auth_id', null); setc('auth_sid', null); setTimeout(function() {document.location.href = '/';}, 500);">Выйти</a>
    <script type="text/javascript">
        $(document).ready(function(){$('#mail-widget').css({width: '100px', height: '50px'})});
    </script>
</div>