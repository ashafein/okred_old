<?php
include("../_php/beaver.php");
include("var.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php echo"<title>$sitename</title>"; ?>
<META HTTP-EQUIV="Cache-Control" CONTENT="No-Cache">
<meta HTTP-EQUIV="Content-Type" Content="text/html; Charset=utf-8">
<?php meta_data('META'); ?>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'ru'}
</script>
<script type="text/javascript">
	$(function() {
		$('.topmenu').topmenu('.poisk > li', {effect: 'fade', fadeOutSpeed: 300});
	});
</script> 
</head>
<body>
<?php
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$n = getenv('REQUEST_URI');

if ($deltext == 'TRUE'){
	$delvac=mysql_query("update $restable set status='archive',archivedate = now() where (status != 'archive' and (date + INTERVAL 86400*period SECOND) < now())");
	$delres=mysql_query("update $vactable set status='archive',archivedate = now() where (status != 'archive' and (date + INTERVAL 86400*period SECOND) < now())");
}
$srcitymy=$_COOKIE['srcitymy'];
if (isset($srcitymy) and $srcitymy != '' and !isset($srcity))
	$srcity=$srcitymy;
if ($srcity != ''){ // city
	if (eregi("^[r]",$srcity)) {
		$srcityshow1=@substr($srcity,1,1000);
		$qwerypromo="and (country = '$srcityshow1' or country = '0')";
	}
	if (eregi("^[p]",$srcity)) {
		$srcityshow1=@substr($srcity,1,1000);
		$qwerypromo="and (region = '$srcityshow1' or region = '0')";
	}
	if (eregi("^[c]",$srcity)) {
		$srcityshow1=@substr($srcity,1,1000);
		$qwerypromo="and (city = '$srcityshow1' or city = '0')";
	}
} // city
if ($srcity == "")
	$qwerypromo='';
$srcitymy=$_COOKIE['srcitymy'];
if (isset($srcitymy) and $srcitymy != '' and !isset($srcity))
	$srcity=$srcitymy;
if ($srcity == '')
	$srcityshowtop = 'Все города';
if ($srcity != ''){ // city
	if (eregi("^[r]",$srcity)){
	$srcityshow=@substr($srcity,1,1000);
	$resultadd2 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srcityshow' LIMIT 1");
		while($myrow1=mysql_fetch_array($resultadd2)) {
			$srcityshowtop=$myrow1["razdel"];
		}
	}
	if (eregi("^[p]",$srcity)) {
		$srcityshow=@substr($srcity,1,1000);
		$resultadd2 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srcityshow' LIMIT 1");
		while($myrow1=mysql_fetch_array($resultadd2)) {
			$srcityshowtop=$myrow1["podrazdel"];
		}
	}
	if (eregi("^[c]",$srcity)) {
		$srcountryshow=@substr($srcity,1,1000);
		$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srcountryshow' LIMIT 1");
		while($myrow2=mysql_fetch_array($resultadd1)) {
			$srcityshowtop=$myrow2["categ"];
		}    
	}
} // city
?>
<?php include("../_php/top-menu.php"); ?>
<table class="table-frame">
    <tbody>
    <tr>
        <td align="center" valign="top" class="paddingright">
            <a style="float: left" href="/" class="job-top-banner"><img src="_images/job/banner-top.jpg" alt="" /></a>
            <form action="/searchv.php?search" method="get" target="_self">
                <table class="maxsearch" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td class="maxsearch-holder-logo-td">
                            <div class="maxsearch-holder-logo">
                                <a href="/" class="logo"></a>
                            </div>
                        </td>
                        <td class="maxsearch-holder-td">
                            <div class="maxsearch-holder">
                                <label for="maxsearch-input" id="maxsearch-label"></label>
                                <input id="maxsearch-input" class="b-form-input__input" maxlength="400" autocomplete="off" name="search" tabindex="1" autofocus type="text" value="">
                            </div>
                        </td>
                        <td class="maxsearch-holder-ok-td">
                            <div class="maxsearch-holder-ok">
                                <a href="" onclick="" class="maxsearch-ok" tabindex="2">поиск</a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </td>
        <td class="right200" valign="top">
            <div class="job-rabotodatelyam">
                <h2>Работодателям:</h2>
                <ul>
                    <li><a id="job-rabotodatelyam1" href="#">Разместить вакансию</a></li>
                    <li><a id="job-rabotodatelyam2" href="#">Стоимость услуг</a></li>
                </ul>
            </div>
            <a class="add-resume"></a>
        </td>
    </tr>
    </tbody>
</table>
