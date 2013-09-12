<?
session_start();
session_name()
?>
<?php
include("var.php");
echo "<head><title>Закладки : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";

$pr=$_GET['pr'];

if ($pr != 'print') {include("top.php");}
if ($pr == 'print') {
echo ("
<SCRIPT language=\"JavaScript1.2\">
<!--
function doPrint()
{
if (window.print)
	{
		window.print();
	}
	else
	{
		alert('Press Ctrl+P. Please, update your browser...');
	}
}
-->
</SCRIPT>
<body onLoad = doPrint()>
");
}
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$view=$_GET['view'];
$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
// ------------basket------------
//
if (isset($p) and $p != "")
{ //additem
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$p and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{
$sql="insert into $resordertable (user,unit,number,date,status) values ('$REMOTE_ADDR',$p,1,now(),'basket')";
$addresult=@mysql_query($sql,$db);
}
} //additem
elseif (isset($d) and $d != "")
{ //removeitem
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
if (@mysql_num_rows($selectresult) != 0)
{
$delresult=@mysql_query("delete from $resordertable where (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
}
} //removeitem
if (isset($bn) and $bn != "")
{ //count
for ($ib=0;$ib<count($bn);$ib++){
if (eregi("[0-9]+",$bn[$ib]) and $bn[$ib] != 0)
{$result=@mysql_query("update $resordertable set number=$bn[$ib],date=now() WHERE ID=$mess[$ib]");}
unset($result);
}
} //count
//
// ------------basket------------
//
//---------------main--------------
//
if ($_SERVER[QUERY_STRING] != "send")
{ //nosend
//--------------step1-------------
// basketshow
if ($pr != 'print') {
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1><tr bgcolor=$maincolor><td>Отобранные резюме&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>
");
if ($view != 'full') {echo "<a href=orderr.php?view=full>Подробный&nbsp;просмотр</a>";}
if ($view == 'full') {echo "<a href=orderr.php>Краткий&nbsp;вид</a>";}
echo ("
&nbsp;/&nbsp;<a href=orderr.php?view=$view&pr=print target=_blank>Печать</a></b></td></tr></table></td></tr></table><br>
");
}
$basketselectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and status='basket') order by ID DESC");
if (@mysql_num_rows($basketselectresult) != 0)
{
if ($view != 'full')
{ // short
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><a href=orderr.php><img src=\"picture/basket.gif\" alt=\"Закладки\" border=0></a></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td></tr>
");
$bpos=0;
while ($myrow=mysql_fetch_array($basketselectresult)) 
{
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $restable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$aid=$myrow["aid"];
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$prof=$myrow1["prof"];
$gender=$myrow1["gender"];
$age=$myrow1["age"];
$category=$myrow1["category"];
}
if ($category == 'agency')
{
$age=$myrow["age"];
$gender=$myrow["gender"];
$prof=$myrow["prof"];
}
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='Добавить закладку';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='Удалить закладку';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><a href=\"orderr.php?$al=$ID\"><img src=\"picture/$pic\" alt=\"$sst\" border=0></a></td>
<td valign=top><a href=linkres.php?link=$ID><b>$profecy</b></a><br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp";}
if ($age != 0) {$br=1; echo "$age лет(года);&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {if ($br==1) {echo "<br>";} $br=1; echo "$grafic";}
if ($prof != '') {if ($br==1) {echo "<br>";} echo "Проф.навыки: $prof";}
echo ("
</td>
<td valign=top>
");
if ($zp != 0) {echo "<b>\$$zp</b>";}
elseif ($zp == 0) {echo "";}
echo ("
</td>
<td valign=top>$date<br><a href=linkres.php?link=$ID><small>Подробнее...</small></a></td>
</tr>
");
} //4
}
echo "</table></td></tr></table>";
} //short 

if ($view == 'full')
{ // full
$bpos=0;
while ($myrow=mysql_fetch_array($basketselectresult)) 
{
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as ID FROM $restable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$uslov=$myrow["uslov"];
$comment=$myrow["comment"];
$aid=$myrow["aid"];
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$expir1org=$myrow["expir1org"];
$expir1perfmonth=$myrow["expir1perfmonth"];
$expir1perfyear=$myrow["expir1perfyear"];
$expir1pertmonth=$myrow["expir1pertmonth"];
$expir1pertyear=$myrow["expir1pertyear"];
$expir1dol=$myrow["expir1dol"];
$expir1obyaz=$myrow["expir1obyaz"];
$expir2org=$myrow["expir2org"];
$expir2perfmonth=$myrow["expir2perfmonth"];
$expir2perfyear=$myrow["expir2perfyear"];
$expir2pertmonth=$myrow["expir2pertmonth"];
$expir2pertyear=$myrow["expir2pertyear"];
$expir2dol=$myrow["expir2dol"];
$expir2obyaz=$myrow["expir2obyaz"];
$expir3org=$myrow["expir3org"];
$expir3perfmonth=$myrow["expir3perfmonth"];
$expir3perfyear=$myrow["expir3perfyear"];
$expir3pertmonth=$myrow["expir3pertmonth"];
$expir3pertyear=$myrow["expir3pertyear"];
$expir3dol=$myrow["expir3dol"];
$expir3obyaz=$myrow["expir3obyaz"];
$expir4org=$myrow["expir4org"];
$expir4perfmonth=$myrow["expir4perfmonth"];
$expir4perfyear=$myrow["expir4perfyear"];
$expir4pertmonth=$myrow["expir4pertmonth"];
$expir4pertyear=$myrow["expir4pertyear"];
$expir4dol=$myrow["expir4dol"];
$expir4obyaz=$myrow["expir4obyaz"];
$expir5org=$myrow["expir5org"];
$expir5perfmonth=$myrow["expir5perfmonth"];
$expir5perfyear=$myrow["expir5perfyear"];
$expir5pertmonth=$myrow["expir5pertmonth"];
$expir5pertyear=$myrow["expir5pertyear"];
$expir5dol=$myrow["expir5dol"];
$expir5obyaz=$myrow["expir5obyaz"];
$edu1sel=$myrow["edu1sel"];
$edu1school=$myrow["edu1school"];
$edu1year=$myrow["edu1year"];
$edu1fac=$myrow["edu1fac"];
$edu1spec=$myrow["edu1spec"];
$edu2sel=$myrow["edu2sel"];
$edu2school=$myrow["edu2school"];
$edu2year=$myrow["edu2year"];
$edu2fac=$myrow["edu2fac"];
$edu2spec=$myrow["edu2spec"];
$edu3sel=$myrow["edu3sel"];
$edu3school=$myrow["edu3school"];
$edu3year=$myrow["edu3year"];
$edu3fac=$myrow["edu3fac"];
$edu3spec=$myrow["edu3spec"];
$edu4sel=$myrow["edu4sel"];
$edu4school=$myrow["edu4school"];
$edu4year=$myrow["edu4year"];
$edu4fac=$myrow["edu4fac"];
$edu4spec=$myrow["edu4spec"];
$edu5sel=$myrow["edu5sel"];
$edu5school=$myrow["edu5school"];
$edu5year=$myrow["edu5year"];
$edu5fac=$myrow["edu5fac"];
$edu5spec=$myrow["edu5spec"];
$lang1=$myrow["lang1"];
$lang1uroven=$myrow["lang1uroven"];
$lang2=$myrow["lang2"];
$lang2uroven=$myrow["lang2uroven"];
$lang3=$myrow["lang3"];
$lang3uroven=$myrow["lang3uroven"];
$lang4=$myrow["lang4"];
$lang4uroven=$myrow["lang4uroven"];
$lang5=$myrow["lang5"];
$lang5uroven=$myrow["lang5uroven"];

$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$email=$myrow1["email"];
$hidemail=$myrow["hidemail"];
$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow1["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$telephone=$myrow1["telephone"];
$adress=$myrow1["adress"];
$url=$myrow1["url"];
$firm=$myrow1["firm"];
$cfio=$myrow1["fio"];
$gender=$myrow1["gender"];
$family=$myrow1["family"];
$civil=$myrow1["civil"];
$prof=$myrow1["prof"];
$dopsved=$myrow1["dopsved"];
$age=$myrow1["age"];
$category=$myrow1["category"];
$foto1=$myrow1["foto1"];
$foto2=$myrow1["foto2"];
$foto3=$myrow1["foto3"];
$foto4=$myrow1["foto4"];
$foto5=$myrow1["foto5"];
}
$w='a';
if ($category == 'agency')
{
$w='r';
$age=$myrow["age"];
$fio=$myrow["fio"];
$gender=$myrow["gender"];
$family=$myrow["family"];
$civil=$myrow["civil"];
$prof=$myrow["prof"];
$dopsved=$myrow["dopsved"];
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$foto3=$myrow["foto3"];
$foto4=$myrow["foto4"];
$foto5=$myrow["foto5"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='Добавить закладку';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='Удалить закладку';}

echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>Резюме $ID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><a href=listres.php?r=$razdel>$razdel1</a> : <a href=listres.php?r=$razdel&c=$podrazdel>$podrazdel1</a></td></tr>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Желаемая должность:</b> $profecy</b>.
");
if ($zp != 0) {echo "Зарплата от <font color=blue><b>$zp</b></font> $valute";}
echo ("
</td></tr>
");
if ($category == 'agency') {
echo "<tr bgcolor=$maincolor><td align=center colspan=2><b>Резюме представляет агентство";
if ($firm != '') {echo "&nbsp;<a href=agency.php?id=$aid><font color=green>$firm</font></a>";}
echo "</b></td></tr>";
echo "<tr bgcolor=$maincolor><td colspan=2>";
$fr=0;
if ($citys != '') {$fr=1; echo "$citys&nbsp;";}
if ($adress != '') {$fr=1;echo "$adress&nbsp;";}
if ($telephone != '') {if ($fr==1) {echo "<br>";} $fr=1; echo "тел.$telephone";}
if ($email != '' and $hidemail == 'checked') {if ($fr==1) {echo "<br>";} $fr=1; echo "<b>Email:</b> <a href=\"send.php?sendid=$aid\">Написать письмо</a><br>";}
if ($email != '' and $hidemail != 'checked') {if ($fr==1) {echo "<br>";} $fr=1; echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
if ($url != '') {if ($fr==1) {echo "<br>";} $fr=1; echo "Url: <a href=$url target=_blank>$url</a>";}
if ($cfio != '') {if ($fr==1) {echo "<br>";} $fr=1; echo "Контактное лицо: $cfio";}
echo "</td></tr>";
}
echo ("
<tr bgcolor=$maincolor><td align=center colspan=2><b>Персональные данные</b></td></tr>
<tr bgcolor=$maincolor><td align=top>
");
if ($foto1 != '' or $foto2 != '' or $foto3 != '' or $foto4 != '' or $foto5 != '')
{
if ($foto1 != "") {$fotourl=$foto1;}
else {if ($foto2 != "") {$fotourl=$foto2;}
else {if ($foto3 != "") {$fotourl=$foto3;}
else {if ($foto4 != "") {$fotourl=$foto4;}
else {if ($foto5 != "") {$fotourl=$foto5;}
}}}}
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl";}
echo "<a href=\"photo.php?link=$ID&f=$photodir$fotourl&w=$w\" target=_blank><img src=\"$photodir$fotourl\" height=$smallfotoheight alt=\"Увеличить\" border=0></a>";
}
elseif ($foto1 == '' and $foto2 == '' and $foto3 == '' and $foto4 == '' and $foto5 == '')
{
echo "<img src=picture/showphoto.gif alt=\"Нет фотографии\" border=0>";
}
echo "</td><td valign=top width=100%>";
if ($fio != '' and $category=='agency') {echo "<b>ФИО</b>: $fio<br>";}
if ($cfio != '' and $category=='soisk') {echo "<b>ФИО</b>: $cfio<br>";}
if ($gender == 'Мужской') {echo "<b>Пол</b>: Мужской<br>";}
if ($gender == 'Женский') {echo "<b>Пол</b>: Женский<br>";}
if ($age != 0) {echo "<b>Возраст</b>: $age лет(года)<br>";}
if ($family != '') {echo "<b>Семейное положение</b>: $family<br>";}
if ($civil != '') {echo "<b>Гражданство</b>: $civil<br>";}
if ($category == 'soisk')
{
if ($citys != '') {echo "<b>Город проживания</b>: $citys<br>";}
if ($telephone != '') {echo "<b>Тел:</b>: $telephone<br>";}
if ($email != '' and $hidemail == 'checked') {echo "<b>Email:</b> <a href=\"send.php?sendid=$aid\">Написать письмо</a><br>";}
if ($email != '' and $hidemail != 'checked') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
}
echo "</tr><tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Условия труда:</b></td></tr>";
if ($zanatost != '' and !eregi("важно",$zanatost)) {echo "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {echo "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {echo "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {echo "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($uslov != '') {echo "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}

echo "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Опыт работы:</b>";
if ($expir5org != '' or $expir5perfmonth != '' or $expir5perfyear != '' or $expir5pertmonth != '' or $expir5pertyear != '' or $expir5dol != '' or $expir5obyaz != '') 
{
echo "<br><br>$expir5perfmonth $expir5perfyear";
if ($expir5pertmonth != '' or $expir5pertyear != '') {echo " - $expir5pertmonth $expir5pertyear";}
if ($expir5org != '') {echo " &nbsp;&nbsp;<b>$expir5org</b>";}
if ($expir5dol != '') {echo " <br>Должность: <b>$expir5dol</b>";}
if ($expir5obyaz != '') {$expir5obyaz = ereg_replace("\n","<br>",$expir5obyaz); echo "<br><br>$expir5obyaz";}
}
if ($expir4org != '' or $expir4perfmonth != '' or $expir4perfyear != '' or $expir4pertmonth != '' or $expir4pertyear != '' or $expir4dol != '' or $expir4obyaz != '') 
{
echo "<br><br>$expir4perfmonth $expir4perfyear";
if ($expir4pertmonth != '' or $expir4pertyear != '') {echo " - $expir4pertmonth $expir4pertyear";}
if ($expir4org != '') {echo " &nbsp;&nbsp;<b>$expir4org</b>";}
if ($expir4dol != '') {echo " <br>Должность: <b>$expir4dol</b>";}
if ($expir4obyaz != '') {$expir4obyaz = ereg_replace("\n","<br>",$expir4obyaz); echo "<br><br>$expir4obyaz";}
}
if ($expir3org != '' or $expir3perfmonth != '' or $expir3perfyear != '' or $expir3pertmonth != '' or $expir3pertyear != '' or $expir3dol != '' or $expir3obyaz != '') 
{
echo "<br><br>$expir3perfmonth $expir3perfyear";
if ($expir3pertmonth != '' or $expir3pertyear != '') {echo " - $expir3pertmonth $expir3pertyear";}
if ($expir3org != '') {echo " &nbsp;&nbsp;<b>$expir3org</b>";}
if ($expir3dol != '') {echo " <br>Должность: <b>$expir3dol</b>";}
if ($expir3obyaz != '') {$expir3obyaz = ereg_replace("\n","<br>",$expir3obyaz); echo "<br><br>$expir3obyaz";}
}
if ($expir2org != '' or $expir2perfmonth != '' or $expir2perfyear != '' or $expir2pertmonth != '' or $expir2pertyear != '' or $expir2dol != '' or $expir2obyaz != '') 
{
echo "<br><br>$expir2perfmonth $expir2perfyear";
if ($expir2pertmonth != '' or $expir2pertyear != '') {echo " - $expir2pertmonth $expir2pertyear";}
if ($expir2org != '') {echo " &nbsp;&nbsp;<b>$expir2org</b>";}
if ($expir2dol != '') {echo " <br>Должность: <b>$expir2dol</b>";}
if ($expir2obyaz != '') {$expir2obyaz = ereg_replace("\n","<br>",$expir2obyaz); echo "<br><br>$expir2obyaz";}
}
if ($expir1org != '' or $expir1perfmonth != '' or $expir1perfyear != '' or $expir1pertmonth != '' or $expir1pertyear != '' or $expir1dol != '' or $expir1obyaz != '') 
{
echo "<br><br>$expir1perfmonth $expir1perfyear";
if ($expir1pertmonth != '' or $expir1pertyear != '') {echo " - $expir1pertmonth $expir1pertyear";}
if ($expir1org != '') {echo " &nbsp;&nbsp;<b>$expir1org</b>";}
if ($expir1dol != '') {echo " <br>Должность: <b>$expir1dol</b>";}
if ($expir1obyaz != '') {$expir1obyaz = ereg_replace("\n","<br>",$expir1obyaz); echo "<br><br>$expir1obyaz";}
}
echo "</td></tr>";

if ($prof != '')
{
$prof = ereg_replace("\n","<br>",$prof);
echo "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Профессиональные навыки и знания:</b></td></tr>";
echo "<tr bgcolor=$maincolor><td colspan=2><a align=justify>$prof</p></td></tr>";
}

echo "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Образование:</b>";
if ($edu5sel != '' or $edu5school != '' or $edu5year != '' or $edu5fac != '' or $edu5spec != '')
{
echo "<br><br><b>$edu5sel</b>";
if ($edu5year != '') {echo " $edu5year";}
if ($edu5school != '') {echo " &nbsp;&nbsp;<b>$edu5school</b>";}
if ($edu5fac != '') {echo " <br><b>Факультет</b>: $edu5fac";}
if ($edu5spec != '') {echo " <br><b>Специальность</b>: $edu5spec";}
}
if ($edu4sel != '' or $edu4school != '' or $edu4year != '' or $edu4fac != '' or $edu4spec != '')
{
echo "<br><br><b>$edu4sel</b>";
if ($edu4year != '') {echo " $edu4year";}
if ($edu4school != '') {echo " &nbsp;&nbsp;<b>$edu4school</b>";}
if ($edu4fac != '') {echo " <br><b>Факультет</b>: $edu4fac";}
if ($edu4spec != '') {echo " <br><b>Специальность</b>: $edu4spec";}
}
if ($edu3sel != '' or $edu3school != '' or $edu3year != '' or $edu3fac != '' or $edu3spec != '')
{
echo "<br><br><b>$edu3sel</b>";
if ($edu3year != '') {echo " $edu3year";}
if ($edu3school != '') {echo " &nbsp;&nbsp;<b>$edu3school</b>";}
if ($edu3fac != '') {echo " <br><b>Факультет</b>: $edu3fac";}
if ($edu3spec != '') {echo " <br><b>Специальность</b>: $edu3spec";}
}
if ($edu2sel != '' or $edu2school != '' or $edu2year != '' or $edu2fac != '' or $edu2spec != '')
{
echo "<br><br><b>$edu2sel</b>";
if ($edu2year != '') {echo " $edu2year";}
if ($edu2school != '') {echo " &nbsp;&nbsp;<b>$edu2school</b>";}
if ($edu2fac != '') {echo " <br><b>Факультет</b>: $edu2fac";}
if ($edu2spec != '') {echo " <br><b>Специальность</b>: $edu2spec";}
}
if ($edu1sel != '' or $edu1school != '' or $edu1year != '' or $edu1fac != '' or $edu1spec != '')
{
echo "<br><br><b>$edu1sel</b>";
if ($edu1year != '') {echo " $edu1year";}
if ($edu1school != '') {echo " &nbsp;&nbsp;<b>$edu1school</b>";}
if ($edu1fac != '') {echo " <br><b>Факультет</b>: $edu1fac";}
if ($edu1spec != '') {echo " <br><b>Специальность</b>: $edu1spec";}
}
echo "</td></tr>";

echo "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Знание иностранных языков:</b>";
if ($lang5 != '' or $lang5uroven != '') 
{
echo "<br>$lang5";
if ($lang5uroven != '') {echo "&nbsp;-&nbsp;$lang5uroven";}
}
if ($lang4 != '' or $lang4uroven != '') 
{
echo "<br>$lang4";
if ($lang4uroven != '') {echo "&nbsp;-&nbsp;$lang4uroven";}
}
if ($lang3 != '' or $lang3uroven != '') 
{
echo "<br>$lang3";
if ($lang3uroven != '') {echo "&nbsp;-&nbsp;$lang3uroven";}
}
if ($lang2 != '' or $lang2uroven != '') 
{
echo "<br>$lang2";
if ($lang2uroven != '') {echo "&nbsp;-&nbsp;$lang2uroven";}
}
if ($lang1 != '' or $lang1uroven != '') 
{
echo "<br>$lang1";
if ($lang1uroven != '') {echo "&nbsp;-&nbsp;$lang1uroven";}
}
echo "</td></tr>";

if ($dopsved != '')
{
$dopsved = ereg_replace("\n","<br>",$dopsved);
echo "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Дополнительные сведения:</b></td></tr>";
echo "<tr bgcolor=$maincolor><td colspan=2><a align=justify>$dopsved</p></td></tr>";
}
if ($comment != '')
{
$comment = ereg_replace("\n","<br>",$comment);
echo "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Комментарий к резюме:</b></td></tr>";
echo "<tr bgcolor=$maincolor><td colspan=2><a align=justify>$comment</p></td></tr>";
}
echo ("
<tr bgcolor=$maincolor><td align=right colspan=2><b><a href=\"orderr.php?view=$view&$al=$ID\">$sst</a></b></td></tr>
</table></td></tr></table><br><br>
");
} //4
}
} // full 

$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and (category='rab' or category='agency'))");
if ((isset($slogin) and isset($spass)) and @mysql_num_rows($result) != 0)
{ // авторизирован

$resultres = @mysql_query("SELECT ID,profecy,aid,status FROM $vactable WHERE aid = '$sid' and status='ok'");

if (@mysql_num_rows($resultres) == 0) {
echo ("
<p align=center>
Вы не добавили ни одной вакансии. Чтобы предложить свою вакансию соискателю <a href=addvac.php>добавьте вакансию</a>
</p>
");
}

if (@mysql_num_rows($resultres) == 1) {
while($myrow=mysql_fetch_array($resultres)) {
$vacID=$myrow["ID"];
}
echo ("
<form name=form method=post action=orderr.php?send ENCTYPE=multipart/form-data>
<p align=center>
<input type=hidden name=p value=$link>
<input type=hidden name=link value=$link>
<input type=hidden name=vacID value=$vacID>
<input type=submit value=\"Предложить свою вакансию соискателю\" name=\"send\" class=i3>
</p>
</form>
");
}

if (@mysql_num_rows($resultres) > 1) {
echo ("
<form name=form method=post action=orderr.php?send ENCTYPE=multipart/form-data>
<p align=center>
<input type=hidden name=p value=$link>
<input type=hidden name=link value=$link>
<select name=vacID size=1>
");
while($myrow=mysql_fetch_array($resultres)) {
$vacID=$myrow["ID"];
$vacprofecy=$myrow["profecy"];
echo ("
<option value=\"$vacID\">$vacprofecy</option>
");
}
echo ("
</select>
<input type=submit value=\"Предложить выбраную вакансию соискателю\" name=\"send\" class=i3>
</p>
</form>
");
}

} // авторизирован

if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo ("
<p align=center>
Для предложения своей вакансии соискателю <a href=autor.php>авторизируйтесь как работодатель или агентство</a>
</p>
");
}

}
elseif (@mysql_num_rows($basketselectresult) == 0)
{
echo "<p align=center><b>Закладок нет</b></p><br><br>";
}
// basketshow
//
//--------------step1-------------
//
} //nosend
if ($_SERVER[QUERY_STRING] == "send")
{ //send

$vacID=$_POST['vacID'];

$body='';
$txtdown = "<br>Спасибо за пользование нашим сайтом!<br><a href=$siteadress>$sitename</a>";
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$id'");
while ($myrow=mysql_fetch_array($resultaut)) {
$category=$myrow["category"];
$email=$myrow["email"];
$hidemail=$myrow["hidemail"];
$acountry=$myrow["country"];
$aregion=$myrow["region"];
$acity=$myrow["city"];

$citytar=$acity;
if ($acity=='0') {$citytar=$aregion;}
if ($aregion=='0' and $acity=='0') {$citytar=$acountry;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$acitys=$myrowc["categ"];
if ($acity=='0') {$acitys=$myrowc["podrazdel"];}
if ($acity=='0' and $aregion=='0') {$acitys=$myrowc["razdel"];}
}

$telephone=$myrow["telephone"];
$aadress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$afirm=$myrow["firm"];
}

$resultvac = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as vID FROM $vactable WHERE ID=$vacID and status='ok' LIMIT 1");
if (@mysql_num_rows($resultvac) != 0)
{ //вакансия
while ($myrow=@mysql_fetch_array($resultvac)) 
{
$vID=$myrow["vID"];
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$zp=$myrow["zp"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$stage=$myrow["stage"];
$treb=$myrow["treb"];
$obyaz=$myrow["obyaz"];
$uslov=$myrow["uslov"];
$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$adress=$myrow["adress"];
$firm=$myrow["firm"];
$aid=$myrow["aid"];
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}

$body .= ("
<div align=left><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>Вакансия $vID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Предлагаемая должность:</b> $profecy</b>. Зарплата от <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td align=center colspan=2><b>Требования и условия</b></td></tr>
");
if ($agemin != 0 and $agemax == 0) {$body .= "<tr bgcolor=$maincolor><td>Возраст:</td><td>от $agemin лет</td></tr>";}
if ($agemin == 0 and $agemax != 0) {$body .= "<tr bgcolor=$maincolor><td>Возраст:</td><td>до $agemax лет</td></tr>";}
if ($agemin != 0 and $agemax != 0) {$body .= "<tr bgcolor=$maincolor><td>Возраст:</td><td>от $agemin до $agemax лет</td></tr>";}
if ($gender == 'Мужской') {$body .= "<tr bgcolor=$maincolor><td>Пол:</td><td>Мужской</td></tr>";}
if ($gender == 'Женский') {$body .= "<tr bgcolor=$maincolor><td>Пол:</td><td>Женский</td></tr>";}
if ($edu != '' and !eregi("важно",$edu)) {$body .= "<tr bgcolor=$maincolor><td>Образование:</td><td>$edu</td></tr>";}
if ($edu != '' and eregi("важно",$edu)) {$body .= "<tr bgcolor=$maincolor><td>Образование:</td><td>Любое</td></tr>";}
if ($zanatost != '' and !eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($stage != '') {$body .= "<tr bgcolor=$maincolor><td>Опыт работы:</td><td>$stage</td></tr>";}
if ($treb != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Требования:</td><td>$treb</td></tr>";}
if ($obyaz != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Обязанности:</td><td>$obyaz</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}
if ($citys != '' or $adress !='') {$body .= "<tr bgcolor=$maincolor><td valign=top>Место&nbsp;работы:</td><td>$citys $adress</td></tr>";}
if ($firm != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Организация (место работы):</td><td valign=top>$firm</td></tr>";}
} // вакансия

$body .= ("
<tr bgcolor=$maincolor><td colspan=2><a href=$siteadress/linkvac.php?link=$vacID>Просмотр вакансии</a></td></tr>
</table></td></tr></table></div>
");

$basketselectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and status='basket') order by ID DESC");
if (@mysql_num_rows($basketselectresult) != 0)
{ //s2
while ($myrow=mysql_fetch_array($basketselectresult)) 
{ //s3
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT ID,aid,profecy FROM $restable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //s4
$resID=$myrow["ID"];
$resaid=$myrow["aid"];
$resprofecy=$myrow["profecy"];
$txttop = ("
Здравствуйте!<br>
На ваше резюме <a href=\"$siteadress/linkres.php?link=$resID\"><b>$resprofecy</b></a><br>
размещенное на сайте <a href=$siteadress>$sitename</a> отправлена вакансия.<br><br>
");
$resultaut = @mysql_query("SELECT ID,email FROM $autortable WHERE ID='$resaid'");
while ($myrow=mysql_fetch_array($resultaut)) 
{ //s5
$resemail=$myrow["email"];
$rastext = $txttop.$body.$txtdown;
mail($resemail,"Вакансия на ваше резюме с сайта $sitename",$rastext,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
} //s5
} //s4
} //s3
} //s2
echo "<h3 align=center class=tbl1>Вакансия отправлена!</h3><br><br>";
} //send
//---------------main--------------
echo "<p align=center class=tbl1><a href=autor.php>Вернуться в авторский раздел</a></p>";
}//1
if ($pr != 'print') {include("down.php");}
?>