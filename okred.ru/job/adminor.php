<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME=ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
$maxThread = 20;
echo "<title>Администрирование - Одобрение резюме: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err1="Неверный пароль!<br>";
$err2="Не выбрано ни одного объявления!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
echo "<center><p><strong><big>Администрирование - Одобрение резюме</strong></big>";
echo "<form name=delreg method=post action=adminor.php?confirm>";
if ($_SERVER[QUERY_STRING] != "confirm") 
{
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $restable WHERE status='wait' order by date DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0 and $textconfirm == 'TRUE') {echo "<center><b>Нет объявлений для одобрения!</b>";}
elseif ($totaltexts == 0 and $textconfirm == 'FALSE') {echo "<center><b>Функция одобрения отключена!</b>";}
else
{ //2
echo "<center>Для одобрения резюме пометьте их галочкой и нажмите кнопку \"Одобрить\"<br>Всего резюме для одобрения: <b>$totaltexts</b><br><br>";
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td><td>Опции</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$id=$myrow["ID"];
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
$status=$myrow["status"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
if ($status=='ok') {$statusline='<font color=green>Доступна</font>';}
if ($status=='wait') {$statusline='<font color=red>На проверке</font>';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=confmes[] value=$id></td>
<td valign=top><a href=adminlr.php?link=$id target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp;";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp;";}
if ($age != 0) {$br=1; echo "$age лет(года);&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {if ($br==1) {echo "<br>";} $br=1; echo "$grafic";}
if ($prof != '') {if ($br==1) {echo "<br>";} echo "Проф.навыки: $prof";}
echo ("
</td>
<td valign=top>
");
if ($zp != 0) {echo "<b>$zp</b> $valute";}
elseif ($zp == 0) {echo "";}
echo ("
</td>
<td valign=top>$date<br><a href=adminlr.php?link=$id target=_blank><small>Подробнее...</small></a></td>
<td valign=top>
<a href=admincr.php?texid=$id>Правка</a>
");
if ($category == 'agency') {echo "<br><a href=admincf.php?texid=$id>Фотографии</a>";}
echo ("
</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo ("
<br><center><input type=submit value='Одобрить отмеченные' name=conf>&nbsp;<input type=submit name=delete value='Удалить отмеченные'>
<br><br><input type=submit name=sendwarn value='Отправить отмеченным письмо с текстом ниже'><br>
<textarea rows=3 name=send_mess cols=28>Ваше резюме не соответсвует требованиям сайта. Пожалуйста отредактируйте его. В противном случае объявление будет удалено из базы сайта!</textarea><br><small>Примечание: приветствие и реквизиты сайта подставляются автоматически.</small>
");
} //2
echo "</form>";
}
}
if ($_SERVER[QUERY_STRING] == "confirm"){
$confmes=$_POST['confmes'];
$send_mess=$_POST['send_mess'];
if (count($confmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['conf'])) {
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $restable SET status='ok' WHERE ID=$confmes[$i]");
$res2 = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as nID FROM $restable WHERE ID=$confmes[$i]");
while($myrow2=mysql_fetch_array($res2)) {
$ID=$myrow2["ID"];
$nID=$myrow2["nID"];
$profecy=$myrow2["profecy"];
$zp=$myrow2["zp"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$uslov=$myrow2["uslov"];
$comment=$myrow2["comment"];
$aid=$myrow2["aid"];
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow11=mysql_fetch_array($resultaut)) {
$emailto=$myrow11["email"];
$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow11["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$telephone=$myrow11["telephone"];
$adress=$myrow11["adress"];
$url=$myrow11["url"];
$firm=$myrow11["firm"];
$cfio=$myrow11["fio"];
$gender=$myrow11["gender"];
$family=$myrow11["family"];
$civil=$myrow11["civil"];
$prof=$myrow11["prof"];
$dopsved=$myrow11["dopsved"];
$age=$myrow11["age"];
$category=$myrow11["category"];
$foto1=$myrow11["foto1"];
$foto2=$myrow11["foto2"];
}
$w='a';
if ($category == 'agency')
{
$w='r';
$age=$myrow2["age"];
$fio=$myrow2["fio"];
$gender=$myrow2["gender"];
$family=$myrow2["family"];
$civil=$myrow2["civil"];
$prof=$myrow2["prof"];
$dopsved=$myrow2["dopsved"];
$foto1=$myrow2["foto1"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow13=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow13["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow13=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow13["razdel"];
}
}
$body = ("
<div align=center><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>Резюме $nID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Желаемая должность:</b> $profecy</b>.
");
if ($zp != 0) {$body .= "Зарплата от <font color=blue><b>$zp</b></font> $valute";}
$body .= ("
</td></tr>
");
$body .= ("
<tr bgcolor=$maincolor><td align=center colspan=2><b>Персональные данные</b></td></tr>
<tr bgcolor=$maincolor><td valign=top colspan=2 width=100%>
");
if ($fio != '' and $category=='agency') {$body .= "<b>ФИО</b>: $fio<br>";}
if ($cfio != '' and $category=='soisk') {$body .= "<b>ФИО</b>: $cfio<br>";}
if ($gender == 'Мужской') {$body .= "<b>Пол</b>: Мужской<br>";}
if ($gender == 'Женский') {$body .= "<b>Пол</b>: Женский<br>";}
if ($age != 0) {$body .= "<b>Возраст</b>: $age лет(года)<br>";}
if ($family != '') {$body .= "<b>Семейное положение</b>: $family<br>";}
if ($civil != '') {$body .= "<b>Гражданство</b>: $civil<br>";}
if ($category == 'soisk')
{
if ($citys != '') {$body .= "<b>Город проживания</b>: $citys<br>";}
}
$body .= "</td></tr><tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Условия труда:</b></td></tr>";
if ($zanatost != '' and !eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}
if ($prof != '')
{
$prof = ereg_replace("\n","<br>",$prof);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Профессиональные навыки и знания:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$prof</p></td></tr>";
}
if ($dopsved != '')
{
$dopsved = ereg_replace("\n","<br>",$dopsved);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Дополнительные сведения:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$dopsved</p></td></tr>";
}
if ($comment != '')
{
$comment = ereg_replace("\n","<br>",$comment);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Комментарий к резюме:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$comment</p></td></tr>";
}
$body .= ("
<tr bgcolor=$maincolor><td align=right colspan=2><a href=$siteadress/linkres.php?link=$ID>Подробнее...</a></td></tr>
</table></td></tr></table></div><br>
");

$txt="Здравствуйте!<br><br>Ваше резюме было проверено и добавлено в базу объявлений сайта <a href=$siteadress>$sitename</a>!<br><br>$body<br><br>Спасибо за пользование нашим сайтом!<br><br>-----------<br>$siteadress<br>$adminemail";
mail($emailto,"Резюме добавлено - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<br><br><h3 align=center>Выбранные резюме одобрены и добавлены в общую базу!</h3><br><br>";

if ($textconfirm == 'TRUE')
{ // confirm
$result1 = @mysql_query("SELECT ID FROM $restable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$lastid=$myrow["ID"];
}
$resl = @mysql_query("SELECT name,status FROM $rassilka WHERE name='admin'");
while ($myrow=mysql_fetch_array($resl)) 
{
$rstatus=$myrow["status"];
}
if ($rstatus == 'on')
{ //ras

function XMail( $from, $to, $subj, $text, $filename) { 
    $f         = fopen($filename,"rb"); 
    $un        = strtoupper(uniqid(time())); 
    $head      = "From: $from\n"; 
    $head     .= "To: $to\n"; 
    $head     .= "Subject: $subj\n"; 
    $head     .= "X-Mailer: PHPMail Tool\n"; 
    $head     .= "Reply-To: $from\n"; 
    $head     .= "Mime-Version: 1.0\n"; 
    $head     .= "Content-Type:multipart/mixed;"; 
    $head     .= "boundary=\"----------".$un."\"\n\n"; 
    $zag       = "------------".$un."\nContent-Type:text/html;charset=windows-1251\n"; 
    $zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n"; 

    $zag      .= "------------".$un."\n"; 
    $zag      .= "Content-Type: application/octet-stream;"; 
    $zag      .= "name=\"".basename($filename)."\"\n"; 
    $zag      .= "Content-Transfer-Encoding:base64\n";
    $zag      .= "Content-ID: <promo>\n";
    $zag      .= "Content-Disposition:attachment;";
    $zag      .= "filename=\"".basename($filename)."\"\n\n"; 
    $zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n"; 
     
    return @mail("$to", "$subj", $zag, $head); 
} 

$result = mysql_query("SELECT * FROM $rasres");
if (mysql_num_rows($result) != 0)
{ //has
while ($myrow=mysql_fetch_array($result)) 
{ //while
$srprofecy=$myrow["srprofecy"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$srzp=$myrow["srzp"];
$srgender=$myrow["srgender"];
$srgrafic=$myrow["srgrafic"];
$srzanatost=$myrow["srzanatost"];
$srcountry=$myrow["srcountry"];
$srregion=$myrow["srregion"];
$srcity=$myrow["srcity"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$autoraid=$myrow["aid"];
$lsrrazdel='';
$lsrpodrazdel='';
$lsrcountry='';
$lsrregion='';
$lsrcity='';
$lsrprofecy='';
$lsragemin='';
$lsragemax='';
$lsrzp='';
$lsrzanatost='';
$lsrgrafic='';
$lsrgender='';
$lsrcomment='';
if ($podrazdel != '' and $podrazdel != '0' and $podrazdel != '%')
{
$lsrpodrazdel="and podrazdel = $podrazdel";
}
if ($razdel != '' and $razdel != '0' and $razdel != '%')
{
$lsrrazdel="and razdel = $razdel";
}
if ($srcountry != "0" and $srcountry != '') {$lsrcountry="and country = '$srcountry'";}
if ($srregion != "0" and $srregion != '') {$lsrregion="and region = '$srregion'";}
if ($srcity != "0" and $srcity != '') {$lsrcity="and city = '$srcity'";}
if ($srprofecy != "%" and $srprofecy != '') {$srprofecy = ereg_replace(" ","*.",$srprofecy); $lsrprofecy="and profecy REGEXP '$srprofecy'";}
if ($agemin != "0" and $agemin != '') {$lsragemin="and (birth = '0000-00-00' or (YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) >= $agemin)";}
if ($agemax != "0" and $agemax != '') {$lsragemax="and (birth = '0000-00-00' or (YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) <= $agemax)";}
if ($srzp != "" and $srzp != '%' and $srzp != 0) {$lsrzp="and (zp <= $srzp or zp=0)";}
if ($srzanatost != "%" and $srzanatost != '') {
if ($srzanatost == 'Полная') {$lsrzanatost="and (zanatost REGEXP 'Полная' or zanatost = '' or zanatost REGEXP 'важно')";}
if (eregi ('совместительству',$srzanatost)) {$lsrzanatost="and (zanatost REGEXP 'совместительству' or zanatost = '' or zanatost REGEXP 'важно')";}
}
if ($srgrafic != "%" and $srgrafic != '') {
if ($srgrafic == 'Полный&nbsp;день') {$lsrgrafic="and (grafic REGEXP 'Полный&nbsp;день' or grafic = '' or grafic REGEXP 'важно')";}
if (eregi ('Неполный',$srgrafic)) {$lsrgrafic="and (grafic REGEXP 'Неполный' or grafic = '' or grafic REGEXP 'важно')";}
if (eregi ('Свободный',$srzanatost)) {$lsrgrafic="and (grafic REGEXP 'Свободный' or grafic = '' or grafic REGEXP 'важно')";}
if (eregi ('Удаленная',$srzanatost)) {$lsrgrafic="and (grafic REGEXP 'Удаленная' or grafic = '' or grafic REGEXP 'важно')";}
}
if ($srgender != "%" and $srgender != '') {
if ($srgender == 'Мужской') {$lsrgender="and gender REGEXP 'Мужской'";}
if ($srgender == 'Женский') {$lsrgender="and gender REGEXP 'Женский'";}
}
$resultsr = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as nID FROM $restable WHERE status='ok' $lsrrazdel $lsrpodrazdel $lsrcountry $lsrregion $lsrcity $lsrprofecy $lsragemin $lsragemax $lsrzp $lsrzanatost $lsrgrafic $lsrgender and ID='$lastid'");
if (mysql_num_rows($resultsr) != 0)
{ // есть совпадение
while ($myrow2=@mysql_fetch_array($resultsr)) 
{ // while2

if ($rasfull == 'FALSE')
{ // short
$ID=$myrow2["ID"];
$profecy=$myrow2["profecy"];
$zp=$myrow2["zp"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$aid=$myrow2["aid"];
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow11=mysql_fetch_array($resultaut)) {
$prof=$myrow11["prof"];
$gender=$myrow11["gender"];
$age=$myrow11["age"];
$category=$myrow11["category"];
}
if ($category == 'agency')
{
$age=$myrow2["age"];
$gender=$myrow2["gender"];
$prof=$myrow2["prof"];
}
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow3=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow3["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow3=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow3["razdel"];
}
$body=("
<a href=$siteadress/linkres.php?link=$ID><b>$profecy</b></a>
");
if ($zp != 0) {$body .="&nbsp;-&nbsp;\$$zp";}
$body .="<br>";
$br=0;
$br=0;
if ($gender == 'Мужской') {$br=1; $body .="Мужчина&nbsp";}
if ($gender == 'Женский') {$br=1; $body .="Женщина&nbsp";}
if ($age != 0 and $age != 0) {$br=1; $body .="$age лет(года);&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {if ($br==1) {$body .="<br>";} $br=1; $body .="$grafic";}
if ($prof != '') {if ($br==1) {$body .="<br>";} $body .="Проф.навыки: $prof";}
$body .= ("
<br><a href=$siteadress/linkres.php?link=$ID>Подробнее...</a><br><br>
");
} // short

if ($rasfull == 'TRUE')
{ // full
$ID=$myrow2["ID"];
$nID=$myrow2["nID"];
$profecy=$myrow2["profecy"];
$zp=$myrow2["zp"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$uslov=$myrow2["uslov"];
$comment=$myrow2["comment"];
$aid=$myrow2["aid"];
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow11=mysql_fetch_array($resultaut)) {
$email=$myrow11["email"];
$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow11["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$telephone=$myrow11["telephone"];
$adress=$myrow11["adress"];
$url=$myrow11["url"];
$firm=$myrow11["firm"];
$cfio=$myrow11["fio"];
$gender=$myrow11["gender"];
$family=$myrow11["family"];
$civil=$myrow11["civil"];
$prof=$myrow11["prof"];
$dopsved=$myrow11["dopsved"];
$age=$myrow11["age"];
$category=$myrow11["category"];
$foto1=$myrow11["foto1"];
$foto2=$myrow11["foto2"];
}
$w='a';
if ($category == 'agency')
{
$w='r';
$age=$myrow2["age"];
$fio=$myrow2["fio"];
$gender=$myrow2["gender"];
$family=$myrow2["family"];
$civil=$myrow2["civil"];
$prof=$myrow2["prof"];
$dopsved=$myrow2["dopsved"];
$foto1=$myrow2["foto1"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow13=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow13["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow13=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow13["razdel"];
}
$body = ("
<div align=center><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>Резюме $nID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Желаемая должность:</b> $profecy</b>.
");
if ($zp != 0) {$body .= "Зарплата от <font color=blue><b>$zp</b></font> $valute";}
$body .= ("
</td></tr>
");
$body .= ("
<tr bgcolor=$maincolor><td align=center colspan=2><b>Персональные данные</b></td></tr>
<tr bgcolor=$maincolor><td valign=top colspan=2 width=100%>
");
if ($fio != '' and $category=='agency') {$body .= "<b>ФИО</b>: $fio<br>";}
if ($cfio != '' and $category=='soisk') {$body .= "<b>ФИО</b>: $cfio<br>";}
if ($gender == 'Мужской') {$body .= "<b>Пол</b>: Мужской<br>";}
if ($gender == 'Женский') {$body .= "<b>Пол</b>: Женский<br>";}
if ($age != 0) {$body .= "<b>Возраст</b>: $age лет(года)<br>";}
if ($family != '') {$body .= "<b>Семейное положение</b>: $family<br>";}
if ($civil != '') {$body .= "<b>Гражданство</b>: $civil<br>";}
if ($category == 'soisk')
{
if ($citys != '') {$body .= "<b>Город проживания</b>: $citys<br>";}
}
$body .= "</td></tr><tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Условия труда:</b></td></tr>";
if ($zanatost != '' and !eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}
if ($prof != '')
{
$prof = ereg_replace("\n","<br>",$prof);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Профессиональные навыки и знания:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$prof</p></td></tr>";
}
if ($dopsved != '')
{
$dopsved = ereg_replace("\n","<br>",$dopsved);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Дополнительные сведения:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$dopsved</p></td></tr>";
}
if ($comment != '')
{
$comment = ereg_replace("\n","<br>",$comment);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Комментарий к резюме:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$comment</p></td></tr>";
}
$body .= ("
<tr bgcolor=$maincolor><td align=right colspan=2><a href=$siteadress/linkres.php?link=$ID>Подробнее...</a></td></tr>
</table></td></tr></table></div><br>
");
} // full

} //while2
$resultb = mysql_query("SELECT * FROM $rasres where aid='$autoraid'");
while ($myrow4=mysql_fetch_array($resultb)) 
{$txt=$myrow4["txt"];}

//<!-- рекламный блок рассылки -->

$promotxt='';

 $resultprtop = mysql_query("select * from $promotable where wheres = 'rassilka' order by RAND() limit 1");
 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
$promotxt="<div align=center>";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
$promotxt .= "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=1 width=100%><tr bgcolor=$maincolor><td><a href=\"$plink\" target=_blank><img src=\"cid:promo\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";
}
$promotxt .= "</div>";
}


//<!-- рекламный блок рассылки -->

$body = $txt.$body;
$resultras = mysql_query("UPDATE $rasres SET txt='$body',sum=sum+1 WHERE aid='$autoraid'");
} // есть совпадение
} //while
} //has

$resultsend = mysql_query("SELECT * FROM $rasres WHERE sum >= $sendcount");
if (mysql_num_rows($resultsend) != 0)
{ //send
$txttop="Здравствуйте!<br>Это письмо отправлено Вам в связи с вашей подпиской на новые резюме сайта <a href=$siteadress>$sitename</a><br><br>Список последних $sendcount резюме:<br><br>";
$txtdown = "<br>Спасибо за пользование нашим сайтом!<br><a href=$siteadress>$sitename</a>";
while ($myrow=mysql_fetch_array($resultsend)) 
{ //while3
$said=$myrow["aid"];
$hID=$myrow["ID"];
$txtbody=$myrow["txt"];
$bodyfull=$promotxt.$txttop.$txtbody.$txtdown;
$resl2 = @mysql_query("SELECT email,ID FROM $autortable WHERE ID='$said'");
while ($myrow5=mysql_fetch_array($resl2)) 
{
$rassemail=$myrow5["email"];
}
Xmail($adminemail,$rassemail,"Новые резюме на сайте $sitename",$bodyfull,"$promo_dir$pfoto");
$resultdel = mysql_query("UPDATE $rasres SET sum=0,txt='' WHERE ID = '$hID'");
} //while3
} //send

} //ras
} // confirm

}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['delete'])) {
for ($i=0;$i<count($confmes);$i++){
$res2 = @mysql_query("SELECT * FROM $restable WHERE ID=$confmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$emaid=$myrow["aid"];
$foto1=$myrow["foto1"];
}
$res2 = @mysql_query("SELECT ID,email FROM $autortable WHERE ID=$emaid");
while($myrow=mysql_fetch_array($res2)) {
$emailto=$myrow["email"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
unset($result);
$result=@mysql_query("delete from $restable where ID=$confmes[$i]");
$txt="Здравствуйте!<br><br>Приносим свои извинения, но Ваше резюме было удалено из базы объявлений сайта <a href=$siteadress>$sitename</a>!<br>Причина: несоответствие требованиям сайта!<br><br>С уважением,!<br>-----------<br>$siteadress<br>$adminemail";
@mail($emailto,"Резюме удалено - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<br><br><h3 align=center>Выбранные резюме удалены!</h3><br><br>";
}

if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['sendwarn'])) {
for ($i=0;$i<count($confmes);$i++){
$res2 = @mysql_query("SELECT * FROM $restable WHERE ID=$confmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$emaid=$myrow["aid"];
}
$res2 = @mysql_query("SELECT ID,email FROM $autortable WHERE ID=$emaid");
while($myrow=mysql_fetch_array($res2)) {
$emailto=$myrow["email"];
}
$txt="Здравствуйте!<br><br>$send_mess<br><br>С уважением,!<br>-----------<br>$siteadress<br>$adminemail";
@mail($emailto,"Резюме не одобрено - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<br><br><h3 align=center>Письма на выбранные резюме разосланы!</h3><br><br>";
}

}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>