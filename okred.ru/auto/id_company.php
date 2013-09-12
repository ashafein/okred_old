
<?php
echo "<html><head>";
include("var.php");
echo "<title>Проверка регистрации организации : $sitename</title>";
@$db=mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$n = getenv('REQUEST_URI');
$srfirm=$_GET['srfirm'];
$srinn=$_GET['srinn'];
?>

<form name=delreg method=get action=id_company.php?search>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="191" align="right">Введите название организации: </td>
    <td width="273"><input name="srfirm" type="text" size="40" /></td>
    <td width="36">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">или ИНН организации:</td>
    <td><input name="srinn" type="text" size="20" /> <input type="submit" name="submit" value="Найти" /></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<?

if (isset($_GET['submit']))
{//0
if ($srfirm != '') {$qweryfirm="and firm REGEXP '$srfirm'";}
if ($srfirm == '') {$qweryfirm="";}
if ($srinn != '') {$qweryinn="and inn REGEXP '$srinn'";}
if ($srinn == '') {$qweryinn="";}
$resultfr = @mysql_query("SELECT * FROM $autortable WHERE (category = 'rab' or category='agency') $qweryfirm $qweryinn");
if (mysql_num_rows($resultfr) != 0)
{ //has
while($myrow=mysql_fetch_array($resultfr)) {
$ID=$myrow["ID"];
$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];

$bold=$myrow["bold"];
$boldstl='';
if ($bold != '0000-00-00 00:00:00') {$boldstl="style=\"font-weight: bold;\"";}

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$firm=$myrow["firm"];
$fio=$myrow["fio"];
$deyat=$myrow["deyat"];
$email=$myrow["email"];
$hidemail=$myrow["hidemail"];
$telephone=$myrow["telephone"];
$url=$myrow["url"];
$adress=$myrow["adress"];
$date=$myrow["date"];
$foto2=$myrow["foto2"];
$inn==$myrow["inn"];
$vac = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalvac = @mysql_num_rows($vac);
echo ("
<table border=0>
<tr><td align=left $boldstl>
");
if ($foto2 != '')
{
$fotourl=$foto2;
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl"; $height=$smalllogoheight;}
if (!file_exists($photodir.'s'.$fotourl)) {
$PicSrc=$photodir.$fotourl;
$ar=GetImageSize($PicSrc);
$w=$ar[0];
$h=$ar[1];
if ($h > $smalllogoheight) {$height=$smalllogoheight;}
if ($h <= $smalllogoheight) {$height=$h;}
}
echo "<img src=\"$photodir$fotourl\" height=$height alt=\"$firm\" border=0><br>";
}
echo ("
</td><td $boldstl align=left>
<span class=\"style5\">$firm</span><br><span class=\"style8\">$citys</span><hr align=left width=80% /></td></tr>
<tr><td align=left>Адрес:</td><td align=left>
");
if ($adress != '') {echo "&nbsp$adress";}
echo "</td></tr>";
if ($telephone != '') {echo "<tr><td align=left>Телефон:</td><td align=left>$telephone</td></tr>";}
if ($email != '' and $hidemail != 'checked') {echo "<tr><td align=left>Email:</td><td align=left><a href=mailto:$email>$email</a></td></tr>";}
if ($email != '' and $hidemail == 'checked') {echo "<tr><td align=left>Email:</td><td align=left><a href=\"send.php?sendid=$ID\">Написать письмо</a></td></tr>";}
if ($url != '') {echo "<tr><td align=left>Web-сайт:</td><td align=left><a href=$url>$url</a></td></tr>";}
if ($inn != '') {echo "<tr><td align=left>ИНН:</td><td align=left>$inn</td></tr>";}
if ($fio != '') {echo "<tr><td align=left>Контактное лицо:</td><td align=left>$fio</td></tr>";}
if ($deyat != '') {echo "<tr><td colspan=2 align=left>Описание компании:<br>$deyat</td></tr>";}
echo ("
</table><br><br>
");    
}
} //has
if (mysql_num_rows($resultfr) == 0)
{ //has
echo "<br><br><b>Совпадений не найдено</b>";
} //
} //0
?>