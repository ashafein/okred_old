<?php

include_once('authorization_control.php');
?>
<div id="mail-widget" class="mail-widget"  style="display: none;">
<?php if (!authorized): ?>
        <?php include('auth.php'); ?>
<?php else: ?>
                <?php include('authed.php'); ?>
        <?php endif; ?>
</div>
<table class="wrapper" cellpadding="0" cellspacing="0">
        <tbody>
                <tr class="topbar-tr">
                        <td class="topbar-left"></td>
                        <td class="topbar" valign="top" align="left">

                                <div class="topbar-authblock-wrapper">
                                        <div class="topbar-authblock">
                                                <div class="topbar-authblock-inner-borders">
<?php if (!authorized): ?>
                                                                <a id="topbar-authblock-link" class="topbar-authblock-link" href="javascript:$('#mail-widget').css({display: 'block'});">Авторизация</a>
<?php else: ?>
                                                                <a id="topbar-authblock-link" class="topbar-authblock-link" ><?php if (!empty($_COOKIE["auth_nickname"])) echo $_COOKIE['auth_nickname']; elseif (!empty($_COOKIE['auth_fio'])) echo $_COOKIE['auth_fio']; else echo $_COOKIE['auth_id']; ?></a>
                                                        <?php endif; ?>

                                                </div>
                                        </div>
                                                        <?php
                                                        $url_f = $_SERVER['SERVER_NAME'];
                                                        $poddomen = '';
                                                        if (strpos($url_f, 'job') > -1)
                                                                $poddomen = 'job';
                                                        if (strpos($url_f, 'auto') > -1)
                                                                $poddomen = 'auto';
                                                        if (strpos($url_f, 'music') > -1)
                                                                $poddomen = 'music';
                                                        if (strpos($url_f, 'games') > -1)
                                                                $poddomen = 'games';
                                                        if (strpos($url_f, 'maps') > -1)
                                                                $poddomen = 'maps';
                                                        if (strpos($url_f, 'video') > -1)
                                                                $poddomen = 'video';
                                                        if (strpos($url_f, 'pochta') > -1)
                                                                $poddomen = 'pochta';
                                                        if (empty($poddomen))
                                                                $poddomen = 'okred';
                                                        ?>
                                </div>
                                <ul class="topbar-icons">
                                        <li><a class="toolbar-icon toolbar-icon-search<?php if ($poddomen == 'okred') echo ' toolbar-icon-active'; ?>" href="http://okred.ru">поиск</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-map<?php if ($poddomen == 'maps') echo ' toolbar-icon-active'; ?>" href="http://maps.okred.ru">карты</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-music<?php if ($poddomen == 'music') echo ' toolbar-icon-active'; ?>" href="http://music.okred.ru">музыка</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-video<?php if ($poddomen == 'video') echo ' toolbar-icon-active'; ?>" href="http://video.okred.ru">видео</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-games<?php if ($poddomen == 'games') echo ' toolbar-icon-active'; ?>" href="http://games.okred.ru">игры</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-job<?php if ($poddomen == 'job') echo ' toolbar-icon-active'; ?>" href="http://job.okred.ru">работа</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-auto<?php if ($poddomen == 'auto') echo ' toolbar-icon-active'; ?>" href="http://auto.okred.ru">авто</a></li>
                                        <li><a class="toolbar-icon toolbar-icon-mail<?php if ($poddomen == 'pochta') echo ' toolbar-icon-active'; ?>" href="http://pochta.okred.ru">почта</a></li>
                                </ul>

                        </td>
                        <td class="topbar-right"></td>
                </tr>
                <tr>
                        <td class="contentbar-left"></td>
                        <td align="center" id="searchbar">