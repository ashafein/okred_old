<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<?php
include("var.php");

$link=$_GET['link'];

if(!isset($link))
	echo"<title>Все учреждения : $sitename</title>";
if(isset($link)){
	$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
	@mysql_select_db($bdname,$db);
	$result = @mysql_query("SELECT ID,name FROM $zavtable WHERE ID = '$link'");
	while ($myrow=mysql_fetch_array($result))
		$name=$myrow["name"];
	echo"<title>$name : $sitename</title>";
}
include("top.php");
?>
<center><table width="100%" border="0" cellspacing="2" cellpadding="1">
<?php
if(!isset($link)){
	$result = mysql_query("select * from $zavtable order by name");
	$rows = mysql_num_rows($result);
	for($k=0;$k < $rows;$k++){
		$name=mysql_result($result, $k , "name");
		$adress=mysql_result($result, $k , "adress");
		$telephone=mysql_result($result, $k , "telephone");
		$idnum=mysql_result($result, $k , "ID");
		$email=mysql_result($result, $k , "email");
		$url=mysql_result($result, $k , "url");
		$category=mysql_result($result, $k , "category");
		echo "<tr><td class=reptbl><a href=\"zav.php?link=$idnum\"><h3>$name</h3></a>";
		if ($category != '') {echo "Категория: <b>$category</b><br>";}
		if ($adress != '') {echo "$adress<br>";}
		if ($telephone != '') {echo "тел: $telephone<br>";}
		if ($email != '') {echo "Email: <a href=mailto:$email>$email</a><br>";}
		if ($url != '') {echo "<a href=\"$url\">$url</a><br>";}
		echo "</td></tr><tr><td height=15 class=reptbltop></td></tr>";
	}
}elseif(isset($link) && $link != ""){
	echo "<tr><td class=reptbl>";
	$result = mysql_query("select *,DATE_FORMAT(date,'%d.%m.%Y') as date from $zavtable where ID='".$link."'  limit 1");
	$rows = mysql_num_rows($result);
	if($rows > 0){
		while ($myrow=@mysql_fetch_array($result)) 
			$date=$myrow["date"];
		$name=mysql_result($result, 0 , "name");
		$adress=mysql_result($result, 0 , "adress");
		$telephone=mysql_result($result, 0 , "telephone");
		$idnum=mysql_result($result, 0 , "ID");
		$email=mysql_result($result, 0 , "email");
		$url=mysql_result($result, 0 , "url");
		$category=mysql_result($result, 0 , "category");
		$detail = mysql_result($result, 0 , "comment");
		$foto1=mysql_result($result, 0 , "foto1");
		$foto2=mysql_result($result, 0 , "foto2");
		$foto3=mysql_result($result, 0 , "foto3");
		$foto4=mysql_result($result, 0 , "foto4");
		$foto5=mysql_result($result, 0 , "foto5");
		if ($detail != ""){
			$detail = ereg_replace("\n","<br><br>",$detail);
			$detail = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$detail);
			if (eregi('ФОТО1',$detail) and $foto1 != "")
				$detail=@str_replace('ФОТО1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$detail);
			if (eregi('ФОТО2',$detail) and $foto2 != "")
				$detail=@str_replace('ФОТО2',"<img src=\"$afishadir$foto2\" border=0 align=left class=image>",$detail);
			if (eregi('ФОТО3',$detail) and $foto3 != "")
				$detail=@str_replace('ФОТО3',"<img src=\"$afishadir$foto3\" border=0 align=right class=image>",$detail);
			if (eregi('ФОТО4',$detail) and $foto4 != "")
				$detail=@str_replace('ФОТО4',"<img src=\"$afishadir$foto4\" border=0 align=left class=image>",$detail);
			if (eregi('ФОТО5',$detail) and $foto5 != "")
				$detail=@str_replace('ФОТО5',"<img src=\"$afishadir$foto5\" border=0 align=right class=image>",$detail);
		}
	?>
      <table width=100% border=0 cellpadding=3 cellspacing=0>
        <tr>
          <td>
<?
		echo ("
<h3>$name</h3>
<p align=justify class=text>
");
		if ($category != '')
			echo "Категория: <b>$category</b><br>";
		if ($adress != '')
			echo "<big>$adress</big><br>";
		if ($telephone != '')
			echo "<big>тел: $telephone</big><br>";
		if ($email != '')
			echo "Email: <a href=mailto:$email>$email</a><br>";
		if ($url != '')
			echo "<a href=\"$url\">$url</a><br>";
		echo ("</p>
<p align=justify class=text>$detail</p>
");
echo "</p>";
?>
          </td>
        </tr>
      </table><br>
    <?
	}
	echo "</td></tr>";
}
?>
</table>
<?
include("down.php");
?>