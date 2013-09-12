<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<?php
echo "<head>";
include("var.php");
@$db=mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$link=$_GET['link'];
$g=$_GET['g'];
$p=$_GET['p'];
if ($link == ''){
	if (!isset($g) or $g == '')
		echo "<title>Статьи : $sitename</title>";
	if ($g != '')
		echo "<title>$g : $sitename</title>";
}
if ($link != '') {
	$resulttl = @mysql_query("SELECT ID,title FROM $textable where ID='$link'");
	while($myrow=mysql_fetch_array($resulttl))
		$title=$myrow["title"];
	echo "<title>$title : $sitename</title>";
}
include("top.php");
echo "<div class=tbl1>";
$maxThread=$maxtext;
$n = getenv('REQUEST_URI');
if (!isset($link)){ //link
	if (!isset($g)){
		echo "<center><br><br><b>Выберите жанр статей:</b><br><br>";
		$result = @mysql_query("SELECT * FROM $textcatable order by genre");
		while($myrow=mysql_fetch_array($result)) {
			$genre=$myrow["genre"];
			$genreID=$myrow["ID"];
			echo "<a href=\"text.php?g=$genre\">$genre</a><br>";
		}
	}else{ //1
		$result = @mysql_query("SELECT ID,title,genre,status FROM $textable WHERE genre REGEXP '$g' and status='ok' order by ID DESC");
		$totaltexts=@mysql_num_rows($result);
		$page=$_GET['page'];
		if(!isset($page))
			$page = 1;
		if( $totaltexts <= $maxThread )
			$totalPages = 1;
		elseif( $totaltexts % $maxThread == 0 )
			$totalPages = $totaltexts / $maxThread;
		else 
			$totalPages = ceil( $totaltexts / $maxThread );
		if( $totaltexts == 0 )
			$threadStart = 0;
		else
			$threadStart = $maxThread * $page - $maxThread + 1;
		if( $page == $totalPages )
			$threadEnd = $totaltexts;
		else
			$threadEnd = $maxThread * $page;
		$initialMsg = $maxThread * $page - $maxThread;
		$pages = (int) (($totaltexts + $maxThread - 1) / $maxThread);
		$line = "Страница: |";
		for ($k = 1; $k <= $pages; $k++) {
		  if ($k != $page)
			$line .= "<a href=\"text.php?g=$g&page=$k\"> $k </a>|";
		  if ($k == $page)
			$line .= " $k |";
		}
		if (!isset($link)){ //3
			echo "<table width=100% border=0 class=tbl1><tr><td width=50%>&nbsp;</td><td bgcolor=$altcolor align=left><b><big>$gshow <font color=$maincolor>:.</font></big></b></td></tr></table><br>";
			if ($totaltexts == 0)
				echo "<center>В данном разделе пока нет статей!<br><br><a href=# onClick=history.go(-1)>Вернуться назад</a><br><br>";
			else{ //2
				echo "<center>Всего статей в данном разделе: <b>$totaltexts</b><br><br>$line<br><br>";
				$result = @mysql_query("SELECT * FROM $textable WHERE genre REGEXP '$g' and status='ok' order by ID DESC LIMIT $initialMsg, $maxThread");
				while ($myrow=mysql_fetch_array($result)){ //4
					$ID=$myrow["ID"];
					$title=$myrow["title"];
					$genre=$myrow["genre"];
					$theme=$myrow["theme"];
					$size=$myrow["size"];
					$preview=$myrow["preview"];
					$date=$myrow["date"];
					if ($theme != '')
						$themeline="<tr bgcolor=$maincolor><td align=left colspan=2>Тема: <b>$theme</b></td></tr>";
					if ($theme == '')
						$themeline="";
					$totalpage=(int) ($size / ($maxpagesize/1000));
					$totalpage = $totalpage + 1;
					echo ("
<div align=right><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$altcolor><td width=70% align=left colspan=2><a href=\"text.php?link=$ID\"><b><big>$title</big></b></a></td></tr>
$themeline
</table></td></tr></table></div><br><br>
");
				} //4
				echo "<center>$line<br><br>";
			} //2
		} //3
	}//1
} //link
if (isset($link)){
//echo "<table width=100% border=0 class=tbl1><tr><td align=right bgcolor=$altcolor><a href=print.php?ID=$link><img src=picture/print.gif border=0 alt=\"Версия для печати\"></a></td></tr></table><br>";
	unset($result);
	$result = @mysql_query("SELECT * FROM $textable WHERE ID = $link");
	if (@mysql_num_rows($result) == 0)
		echo "<center>Cтатья не определена!<br><br><a href=# onClick=history.go(-1)>Вернуться назад</a><br><br>";
	else{
		while ($myrow=mysql_fetch_array($result)){
			$ID=$myrow["ID"];
			$title=$myrow["title"];
			$genre=$myrow["genre"];
			$text=$myrow["text"];
			$text = ereg_replace("\n","<br>",$text);
			$date=$myrow["date"];
			$foto1=$myrow["foto1"];
			$foto2=$myrow["foto2"];
			$foto3=$myrow["foto3"];
			$foto4=$myrow["foto4"];
			$foto5=$myrow["foto5"];
		}
		echo "<h3 align=center>$title</h3><blockquote>";
		$totaltexts1=strlen($text);
		if(!isset($p))
			$p = 1;
		if( $totaltexts1 <= $maxpagesize )
			$totalPages1 = 1;
		elseif( $totaltexts1 % $maxpagesize == 0 )
			$totalPages1 = $totaltexts1 / $maxpagesize;
		else
			$totalPages1 = ceil( $totaltexts1 / $maxpagesize );
		if( $totaltexts1 == 0 )
			$threadStart1 = 0;
		else
			$threadStart1 = $maxpagesize * $p - $maxpagesize + 1;
		if( $p == $totalPages1 )
			$threadEnd1 = $totaltexts1;
		else
			$threadEnd1 = $maxpagesize * $p;
		$initialMsg1 = $maxpagesize * $p - $maxpagesize;
		$initialMsg2=$initialMsg1+$maxpagesize;
		$ps = (int) (($totaltexts1 + $maxpagesize - 1) / $maxpagesize);
		if ($ps==1)
			$line1="";
		if ($ps != 1) {
			$line1 = "Страница: |";
			for ($l = 1; $l <= $ps; $l++) {
				if ($l != $p)
					$line1 .= "<a href=\"text.php?g=$g&link=$link&p=$l\"> $l </a>|";
				if ($l == $p)
					$line1 .= " $l |";
			}
		}
		echo "<center>$line1<p align=justify>";
		if (eregi('ФОТО1',$text) and $foto1 != "")
			$text=@str_replace('ФОТО1',"<img src=$photodir$foto1 border=0 align=left width=100%>",$text);
		if (eregi('ФОТО2',$text) and $foto2 != "")
			$text=@str_replace('ФОТО2',"<img src=$photodir$foto2 border=0 align=left width=100%>",$text);
		if (eregi('ФОТО3',$text) and $foto3 != "")
			$text=@str_replace('ФОТО3',"<a href=$photodir$foto3 target=_blank><img src=$photodir$foto3 border=0 align=left width=100%>></a>",$text);
		if (eregi('ФОТО4',$text) and $foto4 != "")
			$text=@str_replace('ФОТО4',"<a href=$photodir$foto4 target=_blank><img src=$photodir$foto4 border=0 align=left width=100%>></a>",$text);
		if (eregi('ФОТО5',$text) and $foto1 != "")
			$text=@str_replace('ФОТО5',"<a href=$photodir$foto5 target=_blank><img src=$photodir$foto5 border=0 align=left width=100%>></a>",$text);
		for ($m=$initialMsg1; $m<$initialMsg2;$m++)
			echo "$text[$m]";
		$next=$p+1;
		if ($next>$ps)
			echo "</p>";
		else{
			if (!eregi(" ",$text[$m]))
				echo "<a href=\"$n&p=$next\">&gt;&gt;</a>";
			echo"</p><p align=right>$line1&nbsp;&nbsp;&nbsp;<a href=\"$n&p=$next\">Дальше&gt;&gt;</a></p>";
		}
		if ($commenttrue == 'TRUE') {
			$resultcom = @mysql_query("SELECT tid FROM $commentstable WHERE tid = $ID");
			$totalcomment=@mysql_num_rows($resultcom);
			$commentline="<a href=comment.php?ID=$ID>Комментарий к статье</a> ($totalcomment)&nbsp;|&nbsp;";
		}
		else {$commentline="";}
//echo ("
//<p align=right><b>$sitename</b><br>$date</p>
//<p align=left>$commentline<a href=print.php?ID=$ID>Версия для печати</a>&nbsp;|&nbsp;<a href=text.php?g=$g>К списку статей</a><br><br></p>
//");
	}
}
echo "</div>";
include("down.php");
?>