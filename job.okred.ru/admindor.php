<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 10/03/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>����������������� - ������ ���: $sitename</title>";
echo "<META NAME=ROBOTS CONTENT=\"NOINDEX, NOFOLLOW\">";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="�� ������� �� ����� ������!<br>";
$error = "";
$maxThread=$maxtext;
$result = @mysql_query("SELECT pass FROM $admintable");
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
echo "<center><p><strong><big>����������������� - ������ ���</strong></big>";
$srname=$_GET['srname'];
echo ("
<form name=sr method=get action=admindor.php>
������ ��� ������ (�� ������ ��� ���������): <input type=text name=srname size=10>&nbsp;<input type=submit name=submit value='�����'></form><br><br>
");
echo "<form name=delreg method=post action=admindor.php?del>";
$result = @mysql_query("SELECT ID,profecy,zp,status,dayof,LPAD(ID,8,'0') as tID FROM $restable WHERE dayof='yes' order by ID DESC");
$totalThread = @mysql_num_rows($result);
if ($totalThread == 0){echo "<b>�� ����������� ������ ���</b><br><br>";}
if ($totalThread != 0){
echo ("
<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$maincolor><td colspan=4><b>������ ���</b></td></tr>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" alt=\"�������\" border=0></td><td>#</td><td>���������</td><td>��������</td></tr>
");
while($myrow=mysql_fetch_array($result)) {
$tID=$myrow["tID"];
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
echo "<tr bgcolor=$maincolor><td><input type=checkbox name=delmes[] value=$ID></td><td>$tID</td><td><a href=adminlr.php?link=$ID><b>$profecy</b></a></td>";
if ($zp != 0) {echo "<td><font color=#777777>$zp</font> $valute</td>";}
if ($zp == 0) {echo "<td></td>";}
}
echo "</table></td></tr></table><br><input type=submit value='������ ������ ���' name=delete><br><br>";
}
echo "�������� ������, ������� ������� ������ ��� (���������� �� ������ ��������):<br><br>";
unset($result);
if ($srname != "") {$srname = ereg_replace(" ","*.",$srname); $qwery2="and (ID = '$srname' or profecy REGEXP '$srname')";}
if (!isset($srname) or $srname == "") {$qwery2='';}
$result = @mysql_query("SELECT * FROM $restable WHERE dayof='' $qwery2 order by ID DESC");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page) or $page == '') $page = 1;
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
  if ($k != $page) {$line .= "<a href=\"admindor.php?srname=$srname&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
if ($totalThread == 0){echo "<b>��� ������</b><br>";}
if ($totalThread != 0){
echo ("
<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" alt=\"�������\" border=0></td><td>#</td><td>���������</td><td>��������</td></tr>
");
$result = @mysql_query("SELECT ID,profecy,zp,status,dayof,LPAD(ID,8,'0') as tID FROM $restable WHERE dayof='' order by ID DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$tID=$myrow["tID"];
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
echo "<tr bgcolor=$maincolor><td><input type=checkbox name=addmes[] value=$ID></td><td>$tID</td><td><a href=adminlr.php?link=$ID><b>$profecy</b></a></td>";
if ($zp != 0) {echo "<td><font color=#777777>$zp</font> $valute</td>";}
if ($zp == 0) {echo "<td></td>";}
}
echo "</table></td></tr></table><br><center>$line<br><br><input type=submit value='�����������' name=addto><br><br>";
}
echo ("
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
$addmes=$_POST['addmes'];
if (isset($_POST['delete']) and count($delmes)==0) {
	$error .= "$err2";}
if (isset($_POST['addto']) and count($addmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($_POST['delete']))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable SET dayof='' WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ���������!</b><br><a href=admindor.php>���������</a><p><br><br><br><br>";
}
if (isset($_POST['addto'])){
unset($result);
for ($i=0;$i<count($addmes);$i++){
$result=@mysql_query("update $restable SET dayof='yes' WHERE ID=$addmes[$i]");
}
echo "<center><b>��������� ���������!</b><br><a href=admindor.php>���������</a><p><br><br><br><br>";
}
}
}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>