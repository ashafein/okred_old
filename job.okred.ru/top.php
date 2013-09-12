<meta HTTP-EQUIV="Content-Type" Content="text/html; Charset=Windows-1251">

<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'ru'}
</script>

<link href="style.css" rel="stylesheet" type="text/css" />
<script src='js/jquery.js' type='text/javascript'></script>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript">
	$(function() {
		$('.topmenu').topmenu('.poisk > li', {effect: 'fade', fadeOutSpeed: 300});
	});
</script> 
<title>Все вакансии</title>


</head>
<body>
<!--/sprypay.tag.check:4fc7408b2d370/-->
<?
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$n = getenv('REQUEST_URI');

if ($deltext == 'TRUE')
{
$delvac=mysql_query("update $restable set status='archive',archivedate = now() where (status != 'archive' and (date + INTERVAL 86400*period SECOND) < now())");
$delres=mysql_query("update $vactable set status='archive',archivedate = now() where (status != 'archive' and (date + INTERVAL 86400*period SECOND) < now())");
}

$srcitymy=$_COOKIE['srcitymy'];
if (isset($srcitymy) and $srcitymy != '' and !isset($srcity)) {$srcity=$srcitymy;}
if ($srcity != '')
{ // city
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
if ($srcity == "") {$qwerypromo='';}

?>

<?
$srcitymy=$_COOKIE['srcitymy'];
if (isset($srcitymy) and $srcitymy != '' and !isset($srcity)) {$srcity=$srcitymy;}
if ($srcity == '') {$srcityshowtop = 'Все города';}
if ($srcity != '')
{ // city
if (eregi("^[r]",$srcity)) {
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


<div class="strip"> </div>
<div id="conteiner">		  
  <div id="header">

<div id="apSkid">
  <div class="rabot"><a href="autor.php"></a></div>
  <ul>
    <li><a href="addvac.php">Разместить вакансию </a></li>
    <li><a href="#">Стоимость услуг</a></li>
  </ul>
  </div>
<div id="logo"><a href="index.php"><img src="images/logo.jpg" width="277" height="87" title="на главную" /></a></div><!--/лого-->
    
      
 <div id="apPhone"> </div>     

</div><!--/header-->

 <div id="header2">
<ul id="apMenu"> 
                <li> <a href="listvac.php" class="catalog">Каталог вакансий</a>    </li>  <!-- -->

 </ul>
<ul class="topmenu">
    
<li><a href="#">Вакансии</a>  </li>
               <li><a href="#">Сотрудники</a>  </li>
				<li><a href="#">Поиск компании</a>  </li>
				<li><a href="#">Поиск агентства</a>  </li>

</ul>

<ul class="poisk">
	<li>

<form method=GET name=search action="searchv.php?search">
<input type=hidden name=submit value=submit>
<table width="100%" border="0">
  <tr>
    <td colspan="5">Например, <a class="g-switcher" href="#" onclick="document.getElementById('main-search-applicant').value = 'водитель'; return false;">водитель</a></td>
  </tr>
  <tr>
    <td colspan="4" ><input id="main-search-applicant" type="text" name="srprofecy" value="" class="search__field" />
    </td>
    <td width="162px">
    <input class="but-se" name="ok" type="submit" value=" " />
    </td>
  </tr>
<tr class="searchbox">
                                     <td colspan="4"><div class="seach-poz">

<?
echo ("
<select class=for name=srrazdel size=1 class=\"sel-vac\">
<option selected value=\"$razdel\">$razdel</option>
");
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel1ID=$myrow["ID"];
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select>
");
?>

</div>                                      
                                      Зарплата:
<input name="srzp" value="" class="zp" /> руб.</td>
  <td class="rassh"><a href="searchv.php">расширенный поиск</a></td>
        </tr>
</table></form> </li>

	<li><!--сотрудники-->
<form method=GET action="searchr.php?search">
<input type=hidden name=submit value=submit>
<table width="100%" border="0">
  <tr>
    <td colspan="5">Например, <a class="g-switcher" href="#" onclick="document.getElementById('main-search-applicant').value = 'водитель'; return false;">водитель</a></td>
  </tr>
  <tr>
    <td colspan="4" ><input id="main-search-applicant" type="text" name="srprofecy" value="" class="search__field" />
    </td>
    <td width="162px">
    <input class="but-se" name="ok" type="submit" value=" " />
     <tr ><td colspan="5" class="rassh"><a href="searchr.php">расширенный поиск</a></td> </tr>
  </tr>

</table></form> </li>

	<li><!--компании-->
<form method=GET action="rab.php">
<table width="100%" border="0">
  <tr>
    <td colspan="5">Например, <a class="g-switcher" href="#" onclick="document.getElementById('main-search-applicant').value = 'Билайн'; return false;">Билайн</a></td>
  </tr>
  <tr>
    <td colspan="4" ><input id="main-search-applicant" type="text" name="srtext" value="" class="search__field" />
    </td>
    <td width="162px">
    <input class="but-se" name="ok" type="submit" value=" " />
     <tr ><td colspan="5" class="rassh"><a href="rab.php">расширенный поиск</a></td> </tr>
  </tr>

</table></form> </li>

<li><!--агентство-->

<form method=GET action="agency.php">
<table width="100%" border="0">
  <tr>
    <td colspan="5">Например, <a class="g-switcher" href="#" onclick="document.getElementById('main-search-applicant').value = 'Билайн'; return false;">Аттика</a></td>
  </tr>
  <tr>
    <td colspan="4" ><input id="main-search-applicant" type="text" name="srtext" value="" class="search__field" />
    </td>
    <td width="162px">
    <input class="but-se" name="ok" type="submit" value=" " />
     <tr ><td colspan="5" class="rassh"><a href="agency.php">расширенный поиск</a></td> </tr>
  </tr>

</table></form> </li>
	
</ul><!--/poisk-->


<div class="login">


<?
if (isset($_COOKIE['sid'])) {$sid=$_COOKIE['sid'];}
if (isset($_COOKIE['slogin'])) {$slogin=$_COOKIE['slogin'];}
if (isset($_COOKIE['spass'])) {$spass=$_COOKIE['spass'];}
if (!isset($sid) or $sid == '') {$sid=$_SESSION['sid'];}
if (!isset($slogin) or $slogin == '') {$slogin=$_SESSION['slogin'];}
if (!isset($spass) or $spass == '') {$spass=$_SESSION['spass'];}
if ($_SERVER[QUERY_STRING] == "autor") {
$alogin=$_POST['alogin'];
$apass=$_POST['apass'];
$resultaut1 = @mysql_query("SELECT ID,email,fio,pass,status,category FROM $autortable WHERE (email = '$alogin' and pass = '$apass' and status != 'wait')");
if (@mysql_num_rows($resultaut1) != 0) {
if (!isset($spass) or $spass == '') {$_SESSION['spass']=$apass;}
if (!isset($slogin) or $slogin == '') {$_SESSION['slogin']=$alogin;}
$resultaut = @mysql_query("SELECT ID,email,fio,pass,status,category FROM $autortable WHERE (email = '$alogin' and pass = '$apass' and status != 'wait')");
while ($myrow=mysql_fetch_array($resultaut)) {
$_SESSION['sid']=$myrow["ID"];
$categoryaut=$myrow["category"];
}
}
}
$resultaut = @mysql_query("SELECT ID,email,fio,pass,status,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and status != 'wait')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($resultaut) == 0)
{ // no aut
echo ("
<form method=post action=\"autor.php?autor\">
");
?>

<table width="100%" border="0" class="padd">
  <tr >
    <td colspan="2">Электронная почта</td>
  </tr>
  <tr>
    <td colspan="2"> <input class="input-mail" name="alogin" type="text" value=""  /></td>
  </tr>
  <tr>
    <td>Пароль</td>
    <td><a href="recpass.php">Напомнить</a></td>
  </tr>
  <tr>
    <td colspan="2"><input class="input-mail" name="apass" type="text" value=""  /></td>
  </tr>
  <tr>
    <td>
     <div class="lit-font"><input type="checkbox" name="remme" value="checked" class="checkbox" /> Запомнить</div>
    </td>
    <td>
    <input class="but" name="ok" type="submit" value="" />
    </td>
  </tr>
  <tr>
    <td colspan="2">     
    <div class="registr"><a href="registr.php">Зарегистрироваться</a></div></td>
  </tr>
</table>

<?
echo ("
</form>
");
} // no aut

elseif ((isset($slogin) and isset($spass)) and @mysql_num_rows($resultaut) != 0)
{ // aut
while ($myrow=mysql_fetch_array($resultaut)) {
$categoryaut=$myrow["category"];
$fioaut=$myrow["fio"];
if ($fioaut != '') {$fioaut = " <b>$fioaut</b>";}
}
if ($categoryaut=='soisk') {$categaut='Соискатель';}
if ($categoryaut=='rab') {$categaut='Работодатель';}
if ($categoryaut=='agency') {$categaut='Агентство';}
if ($categoryaut=='user') {$categaut='Пользователь';}
?>

<table width="100%" border="0" class="padd">
  <tr ><td valign=top>

<?
echo ("
<a href=autor.php><h6>Личная папка</h6></a>
<a href=regchan.php>Регистрационные данные</a><br>
");
if ($categoryaut == 'soisk' or $categoryaut == 'agency' or $categoryaut == 'user') {
echo "<a href=orderv.php>Просмотр отобранных вакансий</a><br>";
echo "<a href=subsv.php>Подписка на новые вакансии</a><br>";
}
if ($categoryaut == 'rab' or $categoryaut == 'agency' or $categoryaut == 'user') {
echo "<a href=orderr.php>Просмотр отобранных резюме</a><br>";
echo "<a href=subsr.php>Подписка на новые резюме</a><br>";
}

if ($categoryaut != 'user')
{ //no user
if ($categoryaut == 'rab' or $categoryaut == 'agency')
{
$result = @mysql_query("SELECT aid,status FROM $vactable WHERE aid = '$sid' and status='ok'");
$totaltexts1=@mysql_num_rows($result);
$result = @mysql_query("SELECT aid,status FROM $vactable WHERE aid = '$sid' and status='wait'");
$totalwait1=@mysql_num_rows($result);
$totaltextsb = $totaltexts1 + $totalwait1;
}
if ($categoryaut == 'soisk' or $categoryaut == 'agency')
{
$result = @mysql_query("SELECT aid,status FROM $restable WHERE aid = '$sid' and status='ok'");
$totaltexts2=@mysql_num_rows($result);
$result = @mysql_query("SELECT aid,status FROM $restable WHERE aid = '$sid' and status='wait'");
$totalwait2=@mysql_num_rows($result);
$totaltextss = $totaltexts2 + $totalwait2;
}
} // no user
$resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($resultban) != 0) {
while($myrow=mysql_fetch_array($resultban)) {
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
}
echo "<p align=center><font color=red>Доступ к функциям авторского раздела для вас, к сожалению, закрыт!</font></p><blockquote><p align=justify><b>Причина:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) {
if ($categoryaut != 'user')
{ // no user
if ($categoryaut == 'rab' or $categoryaut == 'agency')
{
echo ("
<a href=mylistv.php>Мои вакансии</a> ($totaltextsb)<br>
<a href=addvac.php>Добавить вакансию</a><br>
");
}

if ($categoryaut == 'soisk' or $categoryaut == 'agency')
{
echo ("
<a href=mylistr.php>Мои резюме</a> ($totaltextss)<br>
<a href=addres.php>Добавить резюме</a><br>
");
}
} // no user
}

// сообщения
if ($sendmessages == 'TRUE')
{
if (!isset($_GET['link']) or $_GET['link'] == '0') {$linsel='99999999';}
if (isset($_GET['link']) and $_GET['link'] != '0') {$linsel=$_GET['link'];}
if ($_GET['link'] != '0' and $linsel != '99999999') {$result12 = @mysql_query("UPDATE $messagetable set showed='1' WHERE tid = '$sid' and aid = '$linsel' and showed=0");}
if ($_GET['link']=='0' and $linsel == '99999999') {$result12 = @mysql_query("UPDATE $messagetable set showed='1' WHERE tid = '$sid' and aid = '0' and showed=0");}

$result123 = @mysql_query("SELECT aid,tid,showed FROM $messagetable WHERE tid = '$sid' and showed=0");
$totmesnewtop=@mysql_num_rows($result123);
if ($totmesnewtop > 0) {echo "<a href=message.php><b>Сообщения&nbsp;($totmesnewtop)</b></a>";}
if ($totmesnewtop == 0) {echo "<a href=message.php>Сообщения</a><br><br>";}
}
// сообщения

echo ("
<form method=post action=\"logout.php\">
<input type=submit name=logout value=Выйти class=viiti>

</form>

  </td></tr>
</table>
");

} // aut
?>

</div><!--/login-->

</div><!--/header2-->





<?
if (eregi('/searchv.php',$n) or eregi('/listvac.php',$n))
{ // вакансии
?>

<div id="left">


<div class="leftbox">

  <h4>Регион: <a href="city.php" title="выбрать другой регион"><? echo "$srcityshowtop";?></a></h4>
   <div class="metro">

<?

if ($srcity != '')
{ // city
if (eregi("^[r]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1m="and country = '$srcityshow1'";
}
if (eregi("^[p]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1m="and region = '$srcityshow1'";
}
if (eregi("^[c]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1m="and city = '$srcityshow1'";
}
} // city
if ($srcity == "") {$qwery1m='';}

$result5 = @mysql_query("SELECT * FROM $metrotable WHERE metro != '' $qwery1m order by metro");
if (@mysql_num_rows($result5) != 0) {
echo ("
   <h5>Линии метро:</h5>
     <ul>
");

while($myrow=mysql_fetch_array($result5)) {
$metro_top=$myrow["metro"];
echo "<li><a style=\"color:#666\" href=\"searchv.php?submit=submit&srmetro=$metro_top\">$metro_top</a></li>";
}
echo "</ul>";
}
?>

 <h5>Тип занятости:</h5>
 
      <ul>
       <li><a href="searchv.php?submit=submit&srzanatost=Полная">Полная</a></li>
       <li><a href="searchv.php?submit=submit&srzanatost=По&nbsp;совместительству">По&nbsp;совместительству</a></li>
 </ul>
 <h5>График работы:</h5>
 <ul>
       <li><a href="searchv.php?submit=submit&srgrafic=Полный&nbsp;день">Полный&nbsp;день</a></li>
       <li><a href="searchv.php?submit=submit&srgrafic=Неполный&nbsp;день">Неполный&nbsp;день</a></li>
       <li><a href="searchv.php?submit=submit&srgrafic=Свободный&nbsp;график">Свободный&nbsp;график</a></li>
       <li><a href="searchv.php?submit=submit&srgrafic=Удаленная&nbsp;работа">Удаленная&nbsp;работа</a></li>

         
 </ul>
    

     </ul>


<!-- реклама под меню начало -->

<?
if ($qwerypromo == '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'index' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'vac' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'res' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'other' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
}
if ($qwerypromo != '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'index' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'vac' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'res' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'other' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
}

 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
echo "<br>";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
if ($pfoto != '') {echo "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";}
if ($pfoto == '') {echo "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank>$ptitle</a></td></tr></table></td></tr></table><br>";}
}
}
?>

<!-- реклама под меню конец -->

   </div>
</div>
</div><!--/LEFT-->

<?
} //вакансии
?>

<?
if (eregi('/searchr.php',$n) or eregi('/listres.php',$n))
{ // резюме
?>

<div id="left">


<div class="leftbox">

  <h4>Регион: <a href="city.php" title="выбрать другой регион"><? echo "$srcityshowtop";?></a></h4>
   <div class="metro">

 <h5>Тип занятости:</h5>
 
      <ul>
       <li><a href="searchr.php?submit=submit&srzanatost=Полная">Полная</a></li>
       <li><a href="searchr.php?submit=submit&srzanatost=По&nbsp;совместительству">По&nbsp;совместительству</a></li>
 </ul>
 <h5>График работы:</h5>
 <ul>
       <li><a href="searchr.php?submit=submit&srgrafic=Полный&nbsp;день">Полный&nbsp;день</a></li>
       <li><a href="searchr.php?submit=submit&srgrafic=Неполный&nbsp;день">Неполный&nbsp;день</a></li>
       <li><a href="searchr.php?submit=submit&srgrafic=Свободный&nbsp;график">Свободный&nbsp;график</a></li>
       <li><a href="searchr.php?submit=submit&srgrafic=Удаленная&nbsp;работа">Удаленная&nbsp;работа</a></li>

         
 </ul>
    

     </ul>


<!-- реклама под меню начало -->

<?
if ($qwerypromo == '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'index' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'vac' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'res' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'other' or place = 'all') order by allcity DESC,RAND() limit $promomenulimit");}
}
if ($qwerypromo != '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'index' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'vac' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'res' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' and (place = 'other' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promomenulimit");}
}

 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
echo "<br>";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
if ($pfoto != '') {echo "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";}
if ($pfoto == '') {echo "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank>$ptitle</a></td></tr></table></td></tr></table><br>";}
}
}
?>

<!-- реклама под меню конец -->

   </div>
</div>
</div><!--/LEFT-->

<?
} //резюме
?>

<div id="right">

                        
<div class="leftbox">

<div id="flashContent">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="200" height="150" id="машина эфф шторы" align="middle">
				<param name="movie" value="recl.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#e3e3e3" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="window" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="recl.swf" width="200" height="150">
					<param name="movie" value="recl.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#e3e3e3" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="window" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Загрузить Adobe Flash Player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>

<?
if (eregi('/news.php',$n) and !eregi('/adminews.php',$n))
{

$now_month = date("n",time());
$now_year  = date("Y",time());
$now_today = date("j", time());

function denned_to_rus($denned)
{
 if($denned==0) $denned=7;
 return $denned;
}

//очистка
if (isset($_GET['month'])) {
   $month = $_GET['month'];
   $month = ereg_replace ("[[:space:]]", "", $month);
   $month = ereg_replace ("[[:punct:]]", "", $month);
   $month = ereg_replace ("[[:alpha:]]", "", $month);
   if ($month < 1) { $month = 12; }
   if ($month > 12) { $month = 1; }
   }

if (isset($_GET['year'])) {
   $year = $_GET['year'];
   $year = ereg_replace ("[[:space:]]", "", $year);
   $year = ereg_replace ("[[:punct:]]", "", $year);
   $year = ereg_replace ("[[:alpha:]]", "", $year);
   if ($year < 1990) { $year = 1990; }
   if ($year > 2035) { $year = 2035; }
   }

if (isset($_GET['today'])) {
   $today = $_GET['today'];
   $today = ereg_replace ("[[:space:]]", "", $today);
   $today = ereg_replace ("[[:punct:]]", "", $today);
   $today = ereg_replace ("[[:alpha:]]", "", $today);
   }

$month = (isset($month)) ? $month : date("n",time());
$year  = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong   = date("l",mktime(1,1,1,$month,$today,$year)); //день недели текст англ.
$monthlong = date("F",mktime(1,1,1,$month,$today,$year)); //название месяца англ.
$dayone    = date("w",mktime(1,1,1,$month,1,$year)); //день недели цифрой
$numdays   = date("t",mktime(1,1,1,$month,1,$year)); //количество дней в месяце
$alldays   = array('Пн','Вт','Ср','Чт','Пт','<font color=red>Сб</font>','<font color=red>Вс</font>');
$next_year = $year + 1;
$last_year = $year - 1;
$next_month = $month + 1;
$last_month = $month - 1;
if ($today > $numdays) { $today--; }
        if($month == "1" ){$month_ru="январь";}
    elseif($month == "2" ){$month_ru="февраль";}
    elseif($month == "3" ){$month_ru="март";}
    elseif($month == "4" ){$month_ru="апрель";}
    elseif($month == "5" ){$month_ru="май";}
    elseif($month == "6" ){$month_ru="июнь";}
    elseif($month == "7" ){$month_ru="июль";}
    elseif($month == "8" ){$month_ru="август";}
    elseif($month == "9" ){$month_ru="сентябрь";}
    elseif($month == "10"){$month_ru="октябрь";}
    elseif($month == "11"){$month_ru="ноябрь";}
    elseif($month == "12"){$month_ru="декабрь";}
echo "<table border=0 cellpadding=4 cellspacing=1 width=170 class=tbl1>";

//выводим название года
echo "<tr bgcolor=#E7EBEF>
      <td align=center><a href=news.php?year=".$last_year."&today=".$today."&month=".$month.">&laquo;</a></td>";
echo "<td width=100% colspan=\"5\" valign=\"middle\" align=\"center\">
      <b>".$year." г.</b></td>\n";
echo "<td align=center><a href=news.php?year=".$next_year."&today=".$today."&month=".$month.">&raquo;</a></td>";
echo "</tr></table>";

//выводим название месяца
echo "<table border=0 cellpadding=4 cellspacing=1 width=170 class=tbl1>";
echo "<tr bgcolor=#E7EBEF>
      <td align=center><a href=news.php?year=".$year."&today=".$today."&month=".$last_month.">&laquo;</a></td>";
echo "<td width=100% colspan=\"5\" valign=\"middle\" align=\"center\">
      <b>".$month_ru."</b></td>\n";
echo "<td align=center><a href=news.php?year=".$year."&today=".$today."&month=".$next_month.">&raquo;</a></td>";
echo "</tr></table>";

$denned1day = denned_to_rus(date("w",mktime(1,1,1,$month,1,$year)));
$dennedNOWday = denned_to_rus(date("w",mktime(1,1,1,$month,$today,$year)));
$dennedLASTday = denned_to_rus(date("w",mktime(1,1,1,$month,$numdays,$year)));

$num_of_zero_days = 7 - $dennedLASTday;

$days=array();

echo "<table border=0 cellpadding=2 cellspacing=1 width=170 class=tbl1><tr>";

//выводим дни недели
foreach($alldays as $value) {
  echo "<td valign=\"middle\" align=\"center\" width=\"10%\">
        <b>".$value."</b></td>\n";
}
echo "</tr>\n<tr>\n";


//выводим пустые дни месяца как пробелы
echo "<tr>\n";
for($z=1;$z<$denned1day;$z++)
{
  echo "<td valign=\"middle\" align=\"center\">&nbsp;</td>\n";
}



//выводим дни месяца
for($d=1;$d<=$numdays;$d++)
{
  $days[$d]=denned_to_rus(date("w",mktime(1,1,1,$month,$d,$year)));
  if($days[$d]==1) echo "<tr>\n";
  if ($d == $today)
  {
    echo "<td valign=\"middle\" align=\"center\" bgcolor=#B9D7D5>";
          $news_date = $year."-".$month."-".$d;
          $news_result = mysql_query("select * from $newstable where datum = '".$news_date."'");
          $news_rows = mysql_num_rows($news_result);
          if($news_rows >0) {
           echo "<a href=\"".$_SERVER['PHP_SELF']."?year=".$year."&today=".$d."&month=".$month."\">".$d."</a>";
           }
          else {
           echo $d;
           }
          echo "</td>\n";
  }
  else {
    echo "<td valign=\"middle\" align=\"center\">";
          $news_date = $year."-".$month."-".$d;
          $news_result = mysql_query("select * from $newstable where datum = '".$news_date."'");
          $news_rows = mysql_num_rows($news_result);
          if($news_rows >0) {
           echo "<a href=\"".$_SERVER['PHP_SELF']."?year=".$year."&today=".$d."&month=".$month."\">".$d."</a>";
          }
          else {
           echo $d;
           }
          echo "</td>\n";
  }
  if($days[$d]==7) echo "</tr>\n\n";
}

for($z=0;$z<$num_of_zero_days;$z++)
{
  echo "<td valign=\"middle\" align=\"center\">&nbsp;</td>\n";
}
echo "</tr>\n";
echo "</table>";

//выводим сегодняшнюю дату с ссылкой
echo "<table border=0 cellpadding=4 cellspacing=1 width=170 class=tbl1>";
echo "<tr bgcolor=#E7EBEF>
      <td width=100% align=center><a href=news.php?year=".$now_year."&today=".$now_today."&month=".$now_month.">
       <font color=red>.: Сегодня: ".$now_today.".".$now_month.".".$now_year." :.</font></a></td>";
echo "</tr></table>";
?>

<?
}
?>


<!-- реклама правая сторона страницы начало -->
<?
if ($qwerypromo == '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'index' or place = 'all') order by allcity DESC,RAND() LIMIT $promorightlimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'vac' or place = 'all') order by allcity DESC,RAND() LIMIT $promorightlimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'res' or place = 'all') order by allcity DESC,RAND() LIMIT $promorightlimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'other' or place = 'all') order by allcity DESC,RAND() LIMIT $promorightlimit");}
}
if ($qwerypromo != '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'index' or place = 'all') $qwerypromo order by city DESC,date DESC LIMIT $promorightlimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'vac' or place = 'all') $qwerypromo order by city DESC,date DESC LIMIT $promorightlimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'res' or place = 'all') $qwerypromo order by city DESC,date DESC LIMIT $promorightlimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'right' and (place = 'other' or place = 'all') $qwerypromo order by city DESC,date DESC LIMIT $promorightlimit");}
}
 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
if ($pfoto != '') {echo "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";}
if ($pfoto == '') {echo "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank>$ptitle</a></td></tr></table></td></tr></table><br>";}
}
}
?>
<!-- реклама правая сторона страницы конец -->

<p></p>

</div>


<!--brand-->


<!---->
</div><!-- right-->
<!--<div class="news_info"></div>-->


<?
if (eregi('/listvac.php',$n) or eregi('/listres.php',$n) or eregi('/searchr.php',$n) or eregi('/searchv.php',$n))
{
echo "<div id=\"middle2\">";
}
elseif (eregi('/addvac.php',$n) or eregi('/addres.php',$n) or eregi('/changer.php',$n) or eregi('/changev.php',$n) or eregi('/admincr.php',$n) or eregi('/admincv.php',$n) or eregi('/linkvac.php',$n) or eregi('/linkres.php',$n))
{
echo "<div id=\"middle-inner\">";
}
else
{
echo "<div id=\"middle-main\">";
}

?>



<!-- верхний рекламный блок начало -->
<?
if ($qwerypromo == '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'index' or place = 'all') order by allcity DESC,RAND() limit $promotoplimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'vac' or place = 'all') order by allcity DESC,RAND() limit $promotoplimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'res' or place = 'all') order by allcity DESC,RAND() limit $promotoplimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'other' or place = 'all') order by allcity DESC,RAND() limit $promotoplimit");}
}
if ($qwerypromo != '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'index' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promotoplimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'vac' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promotoplimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'res' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promotoplimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'top' and (place = 'other' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promotoplimit");}
}
 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
$pcity=$myrow["city"];
if ($pfoto != '') {echo "<a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt='$ptitle' border=0></a>";}
if ($pfoto == '') {echo "<div align=left><table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank>$ptitle</a></td></tr></table></td></tr></table></div><br>";}
}
}
?>
<!-- верхний рекламный блок конец -->


<!-- блок рекламы компаний начало -->
<?
if ($qwerypromo == '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'comp' order by allcity DESC,RAND() limit $promocomplimit");}
}
if ($qwerypromo != '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'comp' $qwerypromo order by city DESC,date DESC limit $promocomplimit");}
}
echo ("
<div align=center>
");
$rows = mysql_num_rows($resultprtop);
$st=0;
if($rows != 0)
{
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
if ($st==4) {
$st=0;
if ($pfoto != '') {echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a>";}
if ($pfoto == '') {echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$plink\" title='$ptitle' target=_blank class=tbl1>$ptitle</a>";}
$st=$st+1;}
elseif ($st < 4) {
if ($pfoto != '') {echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a>";}
if ($pfoto == '') {echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$plink\" title='$ptitle' target=_blank class=tbl1>$ptitle</a>";}
$st=$st+1;}
}
}
echo "</div><br>";
?>
<!-- блок рекламы компаний конец -->

