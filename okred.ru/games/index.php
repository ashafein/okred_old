<?php include("../_php/beaver.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php meta_data('META'); ?>
<script language="javascript" type="text/javascript">
	$(".maxexpand-a").fancybox({
				padding: 20,
				openEffect : 'elastic',
				openSpeed  : 300,	
				openOpacity : true,
				closeEffect : 'elastic',
				closeSpeed  : 150,
				closeClick : true,
				helpers : {
					overlay : {
						css : {
							'background' : 'rgba(0,0,0,0.46)'
						}
					}
				}
			});
</script>
</head>
<body>
<?php include('../_php/top-menu.php');?>
    	<table class="table-frame">
        	<tbody>
                <tr class="searchbox-holder">
                	<td id="form" class="a" colspan="8">
                    <div id="search_f">
                    	<?php include('../_html/f.html'); ?>
                    </div>
                    </td>
        		</tr>
                <tr class="content-holder">
                	<td class="a">
<p>БЛОК РЕКЛАМЫ</p>
<div style="width:250px; height:450px; border:1px #FF0000 solid">
рекламка google
</div></td>
                    <td class="m20"><div class="td-margin-20"></div></td>
                    <td colspan="5"><?
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

";?></td>
                    <td class="m20"><div class="td-margin-20"></div></td>
        		</tr>
        	</tbody>
        </table>

<?php include('../_php/footer.php'); ?>

<div id="maxzoom-video" style="display: none; overflow: hidden; z-index: 9999;">
<div style="display:inline-block; background:#00C; float:left;"><iframe id="video" width="420" height="315" src="http://www.youtube.com/embed/go5HMP3KtqI" frameborder="0" allowfullscreen></iframe></div>
<div style="width:150px; height:315px; background:#FF0000;display:inline-block; overflow:auto;"><?php SmallPreviewGen($XmlArray); ?></div>
</div>
</body>
</html>
