<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 11/06/2005       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>����������������� - �������� ������������: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="�� ������� �� ������ �����������!<br>";
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
$result = @mysql_query("SELECT ID,tid FROM $commentstable");
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
  if ($k != $page) {$line .= "<a href=\"$n?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>����������������� - �������� ������������</strong></big><p>�������� �������� �����������, ������� ����� �������, ������� ��� � ������ �������������� � ������� �� ������ \"������� ����������\".<p>";
echo "����� ������������: <b>$totalThread</b><br>$line</p>";
echo "<form name=delreg method=post action=adminc.php?del><table border=0 width=95% bgcolor=$bordercolor><tr><td><table width=100% border=0 cellspacing=1 cellpadding=4>";
echo "<tr bgcolor=$altcolor><td><strong>&nbsp;</strong></td><td><strong>�����������</strong></td><td><strong>������</strong></td><td><strong>�����</strong></td></tr>";
$result = @mysql_query("SELECT ID,tid,name,email,comment FROM $commentstable order by tid DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$tid=$myrow["tid"];
$name=$myrow["name"];
$email=$myrow["email"];
$comment=$myrow["comment"];
$res = @mysql_query("SELECT ID,title FROM $textable WHERE ID='$tid'");
while($myrow1=mysql_fetch_array($res)) {
$title=$myrow1["title"];
}
if ($email=="") {$nameline=$name;}
if ($email != "") {$nameline="<a href=mailto:$email>$name</a>";}
echo "<tr><td bgcolor=$maincolor><input type=checkbox name=delmes[] value=$ID></td>";
echo "<td bgcolor=$maincolor>$comment</td>";
echo "<td bgcolor=$maincolor>$title</td>";
echo "<td bgcolor=$maincolor>$nameline</td></tr>";
}
echo "<tr><td colspan=4 bgcolor=#FFFF99 align=right>����� ������������: <b>$totalThread</b></td></tr></td></tr></table></table>";
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
$result=@mysql_query("delete from $commentstable WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ����������� �������!</b><br><a href=adminc.php>���������</a><p><br><br><br><br>";
}
}
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
} //ok
include("down.php");
?>