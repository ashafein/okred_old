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
if ($place=='all') {$place='��� ��������';}
if ($place=='index') {$place='������ �������';}
if ($place=='vac') {$place='������ ��������';}
if ($place=='res') {$place='������ ������';}
if ($place=='other') {$place='���������, ����� �������, ��������, ������';}
if ($wheres=='top') {$where='���� ��������';}
if ($wheres=='comp') {$where='������� ��������';}
if ($wheres=='menu') {$where='����� �������';}
if ($wheres=='right') {$where='������ �������';}
if ($wheres=='down') {$where='��� ��������';}
if ($wheres=='beforenew') {$where='����� ����������-������ ���';}
if ($wheres=='afterhot') {$where='����� ������ ��������';}
if ($wheres=='rassilka') {$where='� ��������';}

// ������ � ���������� �� 5 ����
if ($totdayost == '5') {
$res2 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res2))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="������������, $fio!<br><br>���� ���� �������� ��������� �����: \"<b>$where - $place</b>\" �� <b>$expir</b> (����� ����������) �� ����� <a href=$siteadress/>$sitename</a>.<br>������������� ���� ������ ������� �������. ������� ����� ������� ����� 5 ����, ���� �� �� �������� �� �� ������: <a href=$siteadress/promodel.php>��������� ���������� �����</a>.<br><br><br>------------<br>C ���������,<br>����� ������� ����� \"$sitename\"";
mail($blockemail,"�������� ����� ������� ����� 5 ����",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
// ������ � ���������� �� 5 ����

// ������ � ���������� �� 4 ���
if ($totdayost == '4') {
$res2 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res2))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="������������, $fio!<br><br>���� ���� �������� ��������� �����: \"<b>$where - $place</b>\" �� <b>$expir</b> (����� ����������) �� ����� <a href=$siteadress/>$sitename</a>.<br>������������� ���� ������ ������� �������. ������� ����� ������� ����� 4 ���, ���� �� �� �������� �� �� ������: <a href=$siteadress/promodel.php>��������� ���������� �����</a>.<br><br><br>------------<br>C ���������,<br>����� ������� ����� \"$sitename\"";
mail($blockemail,"�������� ����� ������� ����� 4 ���",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
// ������ � ���������� �� 4 ���

// ������ � ���������� �� 3 ���
if ($totdayost == '3') {
$res2 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res2))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="������������, $fio!<br><br>���� ���� �������� ��������� �����: \"<b>$where - $place</b>\" �� <b>$expir</b> (����� ����������) �� ����� <a href=$siteadress/>$sitename</a>.<br>������������� ���� ������ ������� �������. ������� ����� ������� ����� 3 ���, ���� �� �� �������� �� �� ������: <a href=$siteadress/promodel.php>��������� ���������� �����</a>.<br><br><br>------------<br>C ���������,<br>����� ������� ����� \"$sitename\"";
mail($blockemail,"�������� ����� ������� ����� 3 ���",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
// ������ � ���������� �� 3 ���

// ������ � ���������� �� 2 ���
if ($totdayost == 2) {
$res3 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res3))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="������������, $fio!<br><br>���� ���� �������� ��������� �����: \"<b>$where - $place</b>\" �� <b>$expir</b> (����� ����������) �� ����� <a href=$siteadress/>$sitename</a>.<br>������������� ���� ������ ������� �������. ������� ����� ������� ����� 2 ���, ���� �� �� �������� �� �� ������: <a href=$siteadress/promodel.php>��������� ���������� �����</a>.<br><br><br>------------<br>C ���������,<br>����� ������� ����� \"$sitename\"";
mail($blockemail,"�������� ����� ������� ����� 2 ���",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}

// ������ � ���������� �� 2 ���

// ������ � ���������� �� 1 ����
if ($totdayost == 1) {
$res3 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res3))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="������������, $fio!<br><br>���� ���� �������� ��������� �����: \"<b>$where - $place</b>\" �� <b>$expir</b> (����� ����������) �� ����� <a href=$siteadress/>$sitename</a>.<br>������������� ���� ������ ������� �������. ������� ����� ������� ����� 1 ����, ���� �� �� �������� �� �� ������: <a href=$siteadress/promodel.php>��������� ���������� �����</a>.<br><br><br>------------<br>C ���������,<br>����� ������� ����� \"$sitename\"";
mail($blockemail,"�������� ����� ������� ����� 1 ����",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}

// ������ � ���������� �� 1 ����


// ����������
if ($totdayost < 1) {
$res3 = @mysql_query("SELECT ID,email,fio FROM $autortable WHERE ID='$aid'");
while ($myrow1=@mysql_fetch_array($res3))
{
$fio=$myrow1["fio"];
$blockemail=$myrow1["email"];
}
$blocktxt1="������������, $fio!<br><br>���� ���� �������� ��������� �����: \"<b>$where - $place</b>\" �� <b>$expir</b> (����� ����������) �� ����� <a href=$siteadress/>$sitename</a>.<br>������� ������������� ���� ���������� ������� �������. ��� ���������� ����� ������� � ����� � ������� �����.<br>� ��� ���� ��� ������� �������, ����� �������� ���� �������� ���������� �����.<br><br><br>------------<br>C ���������,<br>����� ������� ����� \"$sitename\"";
mail($blockemail,"���� ������� ������� ����� �������",$blocktxt1,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
@unlink($upath.$promo_dir.$foto);
//$delvac=mysql_query("delete from $promotable where ID='$ID'");
}
// ����������

} //1
} //delfirm

?>
