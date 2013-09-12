
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OKred - Новая поисковая система</title>

<link href="_css/base.css" rel="stylesheet" type="text/css" />
<link href="_css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="_css/tipsy.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.4" media="screen" />

<script src="_js/jquery-1.8.3.js"></script>
<script src="_js/jquery-ui.js"></script>
<script src="_js/jquery.mousewheel.min.js"></script>
<script src="_js/jquery.cookie.js"></script>
<script src="_js/jquery.listen.js"></script>
<script src="_js/search-input.js"></script>
<script src="_js/tipsy.js"></script>
<script src="source/jquery.fancybox.js?v=2.1.4"></script>
<script src="_js/js.js"></script></head>
<script type="text/javascript">
   	var redirect = '/{uri_for_now_url}';
	//history.pushState('', '', redirect);
</script>
<script type="text/javascript">
function change_content(link) {

	$.ajax({
        type: 'POST',
        url: '/'+link,
        dataType: "html",
        success: function (a) {
        	history.pushState('', '', '/'+link);
            $('#searchbar').html(a);
            $(".toolbar-icon-active").removeClass("toolbar-icon-active");
            $("#link_"+link).addClass("toolbar-icon-active");
        },
        error: function (a, b) {alert("error");}
    })

	return false;
}
</script>
<body>
<div id="mail-widget" class="mail-widget"  style="display: none;">
        <div class="mailbox-inner-wrapper">
	<div class="mailbox-widget-signinwith">
		{auth_form_in}
	</div>
</div></div>
<table class="wrapper" cellpadding="0" cellspacing="0">
        <tbody>
                <tr class="topbar-tr">
                        <td class="topbar-left"></td>
                        <td class="topbar" valign="top" align="left">

                                <div class="topbar-authblock-wrapper">
                                        <div class="topbar-authblock">
                                                <div class="topbar-authblock-inner-borders">
                                                                <a id="topbar-authblock-link" class="topbar-authblock-link" href="javascript:$('#mail-widget').css({display: 'block'});">{auth_block_text}</a>
                                                </div>
                                        </div>
                                                                                        </div>
                                <ul class="topbar-icons">
                                	
                                        <li><a id="link_" class="toolbar-icon toolbar-icon-search toolbar-icon-active" href="/" onclick="return change_content('')">поиск</a></li>
                                        <li><a id="link_maps" class="toolbar-icon toolbar-icon-map" href="/maps" onclick="return change_content('maps')">карты</a></li>
                                        <li><a id="link_music" class="toolbar-icon toolbar-icon-music" href="/maps" onclick="return change_content('music')">музыка</a></li>
                                        <li><a id="link_video" class="toolbar-icon toolbar-icon-video" href="http://video.okred.ru" onclick="return change_content('video')">видео</a></li>
                                        <li><a id="link_games" class="toolbar-icon toolbar-icon-games" href="http://games.okred.ru" onclick="return change_content('games')">игры</a></li>
                                        <li><a id="link_work" class="toolbar-icon toolbar-icon-job" href="http://job.okred.ru">работа</a></li>
                                        <!--<li><a id="link_music" class="toolbar-icon toolbar-icon-mail" href="http://pochta.okred.ru">почта</a></li>-->
                                </ul>

                        </td>
                        <td class="topbar-right"></td>
                </tr>
                <tr>
                        <td class="contentbar-left"></td>
                        <td align="center" id="searchbar">
					{content}
		</td>
		<td class="contentbar-right"></td>
	</tr>
	<tr class="bottom-tr" valign="bottom">
    <td class="bottombar-left"></td>
        <td class="bottombar" align="left">


                    <ul class="bottombar-right-icons">
                        <li><a class="bottombar-right-icon bottombar-right-icon-contacts" href="/">контакты</a></li>
                        <li><a class="bottombar-right-icon bottombar-right-icon-help" href="/">помощь</a></li>
                        <li><a class="bottombar-right-icon bottombar-right-icon-partners" href="/">партнерам</a></li>
                        <li><a class="bottombar-right-icon bottombar-right-icon-partners maxexpand-a" href="#maxzoom">fancybox</a></li>
                    </ul>


                <ul class="bottombar-icons">
                    <li><a class="social-icon social-icon-facebook" href="/"></a></li>
                    <li><a class="social-icon social-icon-vkontakte" href="/"></a></li>
                    <li><a class="social-icon social-icon-linkedin" href="/"></a></li>
                    <li><a class="social-icon social-icon-twitter" href="/"></a></li>
                    <li><a class="social-icon social-icon-google" href="/"></a></li>
					<li class="zstats">
                    </li>
                </ul>

        </td>
    <td class="bottombar-right"></td>
    </tr>
    </tbody>
</table>
</body>
</html>
