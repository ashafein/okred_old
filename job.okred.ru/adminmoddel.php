<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>����������������� - �������� �����������: $sitename</title>";
echo "<META NAME=ROBOTS CONTENT=\"NOINDEX, NOFOLLOW\">";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="�� ������� �� ����� �������!<br>";
$error = "";
$maxThread=$maxtext;
$result = @mysql_query("SELECT pass,main FROM $admintable where main='main'");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT * FROM $admintable where main != 'main'");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxThread ) $totalPages = 1;
elseif( $totalThread % $maxThread == 0 ) $totalPages = $totalThread / $maxThread;
else $totalPages = ceil( $totalThread / $maxThread );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totalThread + $maxThread - 1) / $maxThread);
$line = "��������: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"adminmoddel.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>����������������� - �������� �����������</strong></big><p>�������� �������� �����, ������� ����� �������, ������� ��� � ������ �������������� � ������� �� ������ \"������� ����������\".<p>";
echo "(����� ������: <b>$totalThread</b>)<br>$line</p>";
echo "<form name=delreg method=post action=adminmoddel.php?del><table border=0 width=95% bgcolor=$bordercolor><tr><td><table width=100% border=0 cellspacing=1 cellpadding=4 class=tbl1>";
echo "<tr bgcolor=$altcolor><td><strong>&nbsp;</strong></td><td><strong>������</strong></td><td><strong>�����</strong></td><td><strong>����/�����������</strong></td></tr>";
$result = @mysql_query("SELECT * FROM $admintable where main != 'main' order by ID DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$login=$myrow["login"];
$pass=$myrow["pass"];
$date=$myrow["date"];
$comment=$myrow["comment"];
$vacconfirm=$myrow["vacconfirm"];
$vacdel=$myrow["vacdel"];
$resconfirm=$myrow["resconfirm"];
$resdel=$myrow["resdel"];
$userdel=$myrow["userdel"];
$userconfirm=$myrow["userconfirm"];
$moderadd=$myrow["moderadd"];
$catalogadd=$myrow["catalogadd"];
$mess=$myrow["mess"];
$textadd=$myrow["textadd"];
$textdel=$myrow["textdel"];
$textcomment=$myrow["textcomment"];
$faq=$myrow["faq"];
$news=$myrow["news"];
$promoadd=$myrow["promoadd"];
$promodel=$myrow["promodel"];
$promoconfirm=$myrow["promoconfirm"];
if ($vacconfirm == 'checked') {$vacconfirml="��������� ��������<br>";}
if ($resconfirm == 'checked') {$resconfirml="��������� ������<br>";}
if ($vacdel == 'checked') {$vacdell="�������� ��������<br>";}
if ($resdel == 'checked') {$resdell="�������� ������<br>";}
if ($userdel == 'checked') {$userdell="�������� �������������<br>";}
if ($userconfirm == 'checked') {$userconfirm="��������� �������������<br>";}
if ($catalogadd == 'checked') {$catalogadd="���������/���������� �� �������� �������� � �������������<br>";}
if ($moderadd == 'checked') {$moderadd="���������� ����������<br>";}
if ($mess == 'checked') {$mess="��������� �������������<br>";}
if ($textadd == 'checked') {$textadd="�������� ������<br>";}
if ($textdel == 'checked') {$textdel="������� ������<br>";}
if ($textcomment == 'checked') {$textcomment="������� ����������� � �������<br>";}
if ($faq == 'checked') {$faq="FAQ<br>";}
if ($news == 'checked') {$news="�������<br>";}
if ($promoadd == 'checked') {$promoadd="�������� ��������� ����<br>";}
if ($promodel == 'checked') {$promodel="�������� ��������� ������<br>";}
if ($promoconfirm == 'checked') {$promoconfirm="�������� ��������� ����� �������������<br>";}
echo "<tr><td bgcolor=$maincolor><input type=checkbox name=delmes[] value=$ID></td>";
echo "<td bgcolor=$maincolor>$login<br>$pass</td>";
echo "<td bgcolor=$maincolor>$vacconfirml $vacdell $resconfirml $resdell $userdell $reklamal $newsl $textl</td>";
echo "<td bgcolor=$maincolor>$date<br>$comment</td>";
echo "</tr>";
}
echo "</table></td></tr></table>";
echo "<p><center>$line<p>";
echo ("
<center><input type=submit value='������� ����������' name=submit></form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if (count($delmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $admintable WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ���������� �������!</b><br><a href=adminmoddel.php>���������</a><p><br><br><br><br>";
}
}
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
} //ok
include("down.php");
?>