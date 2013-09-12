<?php
include("var.php");
echo "<html><head>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);


if ($delpromo == 'TRUE')
{
$res1 = @mysql_query("SELECT ID,foto,date,period FROM $promotable WHERE ((date + INTERVAL 86400*period SECOND) < now())");
while ($myrow=@mysql_fetch_array($res1))
{
$ID=$myrow["ID"];
$foto=$myrow["foto"];
@unlink($upath.$promo_dir.$foto);
}
$delvac=mysql_query("delete from $promotable where ((date + INTERVAL 86400*period SECOND) < now())");
}


if ($delpromo == 'TRUE')
{ //delfirm

//$res1 = @mysql_query("SELECT *,(TO_DAYS(now()) - TO_DAYS(date)) AS totday FROM $promotable WHERE status='ok'");
//$res1 = @mysql_query("SELECT *,(DATEDIFF(now(),date)) as totday FROM $promotable WHERE status='ok'");
$res1 = @mysql_query("SELECT *,(date + INTERVAL 86400*period SECOND) as expir,CURRENT_DATE,(DATEDIFF(CURRENT_DATE,date)) as totday FROM $promotable WHERE status='ok'");

while ($myrow=@mysql_fetch_array($res1))
{ //1
$ID=$myrow["ID"];
$aid=$myrow["aid"];
$foto=$myrow["foto"];
$totday=$myrow["totday"];
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$date=$myrow["date"];
$expir=$myrow["expir"];
$period=$myrow["period"];
$totdayost=$period-$totday;
if ($place=='all') {$place='Все страницы';}
if ($place=='index') {$place='Только главная';}
if ($place=='vac') {$place='Только вакансии';}
if ($place=='res') {$place='Только резюме';}
if ($place=='other') {$place='Остальные, кроме главной, вакансий, резюме';}
if ($wheres=='top') {$where='Верх страницы';}
if ($wheres=='comp') {$where='Ведущие компании';}
if ($wheres=='menu') {$where='Левая колонка';}
if ($wheres=='right') {$where='Правая колонка';}
if ($wheres=='down') {$where='Низ страницы';}
if ($wheres=='beforenew') {$where='Перед вакансиями-резюме дня';}
if ($wheres=='afterhot') {$where='Перед блоком новостей';}
if ($wheres=='rassilka') {$where='В рассылке';}

// письмо о блокировке за 5 дней
if ($totdayost == '5') {
$res2 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res2))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="Здравствуйте, $fio!<br><br>Вами было оплачено рекламное место: \"<b>$where - $place</b>\" до <b>$expir</b> (время московское) на сайте <a href=$siteadress/>$sitename</a>.<br>Заканчивается срок показа данного баннера. Реклама будет удалена через 5 дней, если вы не продлите ее по ссылке: <a href=$siteadress/promodel.php>продление рекламного блока</a>.<br><br><br>------------<br>C уважением,<br>Отдел рекламы сайта \"$sitename\"";
mail($blockemail,"Удаление Вашей рекламы через 5 дней",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
// письмо о блокировке за 5 дней

// письмо о блокировке за 4 дня
if ($totdayost == '4') {
$res2 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res2))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="Здравствуйте, $fio!<br><br>Вами было оплачено рекламное место: \"<b>$where - $place</b>\" до <b>$expir</b> (время московское) на сайте <a href=$siteadress/>$sitename</a>.<br>Заканчивается срок показа данного баннера. Реклама будет удалена через 4 дня, если вы не продлите ее по ссылке: <a href=$siteadress/promodel.php>продление рекламного блока</a>.<br><br><br>------------<br>C уважением,<br>Отдел рекламы сайта \"$sitename\"";
mail($blockemail,"Удаление Вашей рекламы через 4 дня",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
// письмо о блокировке за 4 дня

// письмо о блокировке за 3 дня
if ($totdayost == '3') {
$res2 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res2))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="Здравствуйте, $fio!<br><br>Вами было оплачено рекламное место: \"<b>$where - $place</b>\" до <b>$expir</b> (время московское) на сайте <a href=$siteadress/>$sitename</a>.<br>Заканчивается срок показа данного баннера. Реклама будет удалена через 3 дня, если вы не продлите ее по ссылке: <a href=$siteadress/promodel.php>продление рекламного блока</a>.<br><br><br>------------<br>C уважением,<br>Отдел рекламы сайта \"$sitename\"";
mail($blockemail,"Удаление Вашей рекламы через 3 дня",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
// письмо о блокировке за 3 дня

// письмо о блокировке за 2 дня
if ($totdayost == 2) {
$res3 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res3))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="Здравствуйте, $fio!<br><br>Вами было оплачено рекламное место: \"<b>$where - $place</b>\" до <b>$expir</b> (время московское) на сайте <a href=$siteadress/>$sitename</a>.<br>Заканчивается срок показа данного баннера. Реклама будет удалена через 2 дня, если вы не продлите ее по ссылке: <a href=$siteadress/promodel.php>продление рекламного блока</a>.<br><br><br>------------<br>C уважением,<br>Отдел рекламы сайта \"$sitename\"";
mail($blockemail,"Удаление Вашей рекламы через 2 дня",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}

// письмо о блокировке за 2 дня

// письмо о блокировке за 1 день
if ($totdayost == 1) {
$res3 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res3))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="Здравствуйте, $fio!<br><br>Вами было оплачено рекламное место: \"<b>$where - $place</b>\" до <b>$expir</b> (время московское) на сайте <a href=$siteadress/>$sitename</a>.<br>Заканчивается срок показа данного баннера. Реклама будет удалена через 1 день, если вы не продлите ее по ссылке: <a href=$siteadress/promodel.php>продление рекламного блока</a>.<br><br><br>------------<br>C уважением,<br>Отдел рекламы сайта \"$sitename\"";
mail($blockemail,"Удаление Вашей рекламы через 1 день",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}

// письмо о блокировке за 1 день


// блокировка
if ($totdayost < 1) {
$res3 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res3))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="Здравствуйте, $fio!<br><br>Вами было оплачено рекламное место: \"<b>$where - $place</b>\" до <b>$expir</b> (время московское) на сайте <a href=$siteadress/>$sitename</a>.<br>Сегодня заканчивается срок размещения данного баннера. Вся информация будет удалена с сайта в течении суток.<br>У Вас есть еще немного времени, чтобы продлить срок действия рекламного блока.<br><br><br>------------<br>C уважением,<br>Отдел рекламы сайта \"$sitename\"";
mail($blockemail,"Ваша реклама сегодня будет удалена",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
@unlink($upath.$promo_dir.$foto);
//$delvac=mysql_query("delete from $promotable where ID='$ID'");
}
// блокировка

} //1
} //delfirm

?>
