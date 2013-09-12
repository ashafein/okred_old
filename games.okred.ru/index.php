<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<title>Документ без названия</title>
</head>
<body>
<div id="search_f">
<form action="http://games.okred.ru/" method="get" target="_self">
<table class="searchbox-container">
    <tbody>
        <tr class="searchbox-menu">
            <td class="a" colspan="7"><div class="searchbox-menu-a">
                <ul class="maxsearchmenu">
                    <li style="float:left" class="m1 current">
                        <a><span>Поиск</span></a>
                    </li>
                    <!-- <li style="float:left" class="m2">
                        <a href="http://maps.okred.ru"><span>Карты</span></a>
                    </li> -->
                    <li style="float:left" class="m3">
                        <a href="http://music.okred.ru"><span>Музыка</span></a>
                    </li>
                   <!-- <li style="float:left" class="m4">
                        <a href="http://video.okred.ru"><span>Видео</span></a>
                    </li>-->
                    <li style="float:left" class="m5">
                        <a href="http://job.okred.ru"><span>Работа</span></a>
                    </li>
                    <!-- <li style="float:left" class="m6">
                        <a href="http://games.okred.ru"><span>Игры</span></a>
                    </li> -->
                </ul>
            </div></td>
        </tr>
        <tr>
            <td class="a"><div class="searchbox-a"><a href="/" title="Перейти на главную"><img id="logo" src="images/logo.png" /></a></div></td>
            <td class="b"><div class="searchbox-b">
                <label for="maxsearch-input" id="maxsearch-label">Для чего бобру мощный хвост</label>
                <input id="maxsearch-input" class="b-form-input__input" maxlength="400" autocomplete="off" name="text" tabindex="1" autofocus type="text">
            </div></td>
            <td class="c"><div class="searchbox-c">
                <div class="ztooltip-e" id="maxsearch-clear" original-title="Очистить строку поиска"></div>
                </div></td>
            <td class="d"></td>
            <td class="e"><div class="searchbox-e"><input class="maxsearch-ok b-form-button__input" type="submit" tabindex="20" value=""></div></td>
            <td class="f"><div class="searchbox-f"></div></td>
        </tr>
    </tbody>
</table>
</form>
</div>
<?
$game=$_GET['game'];$cat=$_GET['cat'];$start=$_GET['start'];$top=$_GET['top'];$sea=$_GET['sea'];$site_url=$_SERVER["HTTP_HOST"];$papka=$_SERVER["REQUEST_URI"];if(empty($game) && empty($cat) && empty($top) && empty($sea)){$text=file_get_contents("http://itsmygame.ru/pp/title.php?site=$site_url&papka=$papka");}if(!empty($game) && empty($cat) && empty($top)){$text=file_get_contents("http://itsmygame.ru/pp/title.php?site=$site_url&papka=$papka&game=$game");}if(empty($game) && !empty($cat) && empty($top)){$text=file_get_contents("http://itsmygame.ru/pp/title.php?site=$site_url&papka=$papka&cat=$cat&start=$start");}if(empty($game) && empty($cat) && !empty($top)){$text=file_get_contents("http://itsmygame.ru/pp/title.php?top=".$top."&site=$site_url&papka=$papka");}if(empty($game) && empty($cat) && empty($top) && !empty($sea)){$text=file_get_contents("http://itsmygame.ru/pp/title.php?site=$site_url&papka=$papka&sea=$sea");}$title_pages=$text;if(empty($title_pages))$title_pages="$site_url - îíëàéí èãðû";

// $title_pages  - Â ýòîé ïåðåìåííîé ñîäåðæèòñÿ çàãîëîâîê ñòðàíèöû, âû ìîæåòå âñòàâèòü åãî â html-êîä âàøåãî ñàéòà

print "<html><head><title>$title_pages</title></head>"; // -- îáðàòèòå âíèìàíèå íà ýòó ñòðîêó !!!

?>



<!-- Çäåñü Âû ìîæåòå âñòàâèòü html-øàáëîí "øàïêè" Âàøåãî ñàéòà -->




<?if(empty($game) && empty($cat) && empty($top) && empty($sea)){$text=file_get_contents("http://itsmygame.ru/pp/index.php?site=$site_url&papka=$papka");}if(!empty($game) && empty($cat) && empty($top)){$text=file_get_contents("http://itsmygame.ru/pp/game.php?site=$site_url&papka=$papka&game=$game");}if(empty($game) && !empty($cat) && empty($top)){$text=file_get_contents("http://itsmygame.ru/pp/game.php?site=$site_url&papka=$papka&cat=$cat&start=$start");}if(empty($game) && empty($cat) && !empty($top)){$text=file_get_contents("http://itsmygame.ru/pp/".$top.".php?site=$site_url&papka=$papka&cat=$top=$top");}if(empty($game) && empty($cat) && empty($top) && !empty($sea)){$text=file_get_contents("http://itsmygame.ru/pp/search.php?site=$site_url&papka=$papka&sea=$sea");}$text=str_replace("itsmygame.com.ua","itsmygame.ru",$text);if(!empty($sea)){$text=str_replace("name=sea","name=sea value=$sea",$text);}


print "<div id=itsmygame.ru><table align=center width=98%><tr><td>$text</td></tr></table></div>




<style>

* {margin:0; line-height: 130%;}

BODY {
        FONT-WEIGHT: regular; FONT-SIZE: 12px; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none;  margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right:0px;
}




.itsmygameA:active {
        FONT-SIZE: 18px; COLOR: #3B7ED1; TEXT-DECORATION: underline;
}
.itsmygameA:visited {
        FONT-SIZE: 12px; COLOR: #4AA1EA; TEXT-DECORATION: underline;
}
.itsmygameA:link {
         FONT-SIZE: 12px; COLOR: #2F66AA; TEXT-DECORATION: underline;
}
.itsmygameA:hover {
        FONT-SIZE: 12px; COLOR: #2FAA89; TEXT-DECORATION: none;
}

.itsmygamemenu:active {
        FONT-SIZE: 13px; COLOR: #545859; TEXT-DECORATION: none;
}
.itsmygamemenu:visited {
        FONT-SIZE: 13px; COLOR: #545859; TEXT-DECORATION: none;
}
.itsmygamemenu:link {
         FONT-SIZE: 13px; COLOR: #545859; TEXT-DECORATION: none;
}
.itsmygamemenu:hover {
        FONT-SIZE: 13px; COLOR: #2FAA89; TEXT-DECORATION: none;
}




.itsmygameh2blok {
        FONT-WEIGHT: regular; FONT-SIZE: 16px; COLOR: #FFFFFF; FONT-WEIGHT:bold; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none; overflow:hidden;
}

.itsmygameP {
  FONT-SIZE: 12px; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none
}

.itsmygameP.low {
  FONT-SIZE: 12px; COLOR: #555555; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none ; line-height:16px;
}

.itsmygameP.p18h {
  FONT-SIZE: 12px; COLOR: #555555; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none ; line-height:18px;
}

.itsmygamesort {
  FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #908890; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none ; line-height:16px;
}

.itsmygameLi {
  FONT-SIZE: 12px; COLOR: #555555; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none ; line-height:18px;
}




.itsmygameh1name
{
FONT-WEIGHT: lighter; FONT-SIZE: 23px; COLOR: #1A5169; FONT-WEIGHT:bold; FONT-FAMILY: Arial, Tahoma, Verdana; TEXT-DECORATION: none;
}

.itsmygamepage:visited{
        background-color:#f8f8f8;
        font-size : 13px;
        font-family : Verdana;
        color:#606060;
        text-decoration:none;
        font-weight:lighter;
        padding:2px 2px 2px 2px;
}
.itsmygamepage:link{
        background-color:#f8f8f8;
        font-size : 13px;
        font-family : Verdana;
        color:#606060;
        text-decoration:none;
        font-weight:lighter;
        padding:2px 2px 2px 2px;
        }
.itsmygamepage:hover{
        background-color:#DDF3E3;
        font-size : 13px;
        font-family : Verdana;
        color:#ffffff;
        text-decoration:none;
        font-weight:lighter;
        padding:2px 2px 2px 2px;
}




img
{
border:0px none;
}


.itsmygamedivb{
        background-color: silver;
        border-left:1px solid #D1DCE2;
        border-right:1px solid #D1DCE2;
        padding:5px;
        margin-bottom:0px
        color: #FFFFFF;
}




.itsmygamenavi:visited{
        background-color:#f8f8f8;
        font-size : 13px;
        color:#699D1E;
        text-decoration:none;
        font-weight:lighter;
        padding:10;
}
.itsmygamenavi:link{
        background-color:#f8f8f8;
        font-size : 13px;
        color:#699D1E;
        text-decoration:none;
        font-weight:lighter;
        padding:10;
        }
.itsmygamenavi:hover{
        background-color:#F5E8E8;
        font-size : 13px;
        color:#699D1E;
        text-decoration:none;
        font-weight:lighter;
        padding:10;
}

.itsmygamepages
{
        font-size : 12px;

        color:#1FC2FE;
}


.itsmygameH1 {
        FONT-WEIGHT: bold; FONT-SIZE: 16px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px;  PADDING-TOP: 0px; margin-left:0px; margin-top:0px; margin-bottom:0px; margin-right:0px;
}
.itsmygameH2 {
        FONT-WEIGHT: bold; FONT-SIZE: 15px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px;  PADDING-TOP: 0px; margin-left:0px; margin-top:0px; margin-bottom:0px; margin-right:0px;
}
.itsmygameH3 {
        FONT-WEIGHT: bold; FONT-SIZE: 14px; PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; margin-left:0px; margin-top:0px; margin-bottom:0px; margin-right:0px;
}

</style>

";?>




<!-- Çäåñü Âû ìîæåòå âñòàâèòü html-øàáëîí "õâîñòà" Âàøåãî ñàéòà -->
</body>
</html>
