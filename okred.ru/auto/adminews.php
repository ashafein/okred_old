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
echo "<head><title>����������������� - �������: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$error = "";
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
if ($_GET['action'] == '') {$action=$_POST['action'];}
elseif ($_GET['action'] != '') {$action=$_GET['action'];}
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
if ($_FILES['file2']['name'] == 'none') {$file2 = '';}
if ($_FILES['file2']['name'] != '') {$file2 = $_FILES['file2']['name'];}
if ($_FILES['file3']['name'] == 'none') {$file3 = '';}
if ($_FILES['file3']['name'] != '') {$file3 = $_FILES['file3']['name'];}
if ($_FILES['file4']['name'] == 'none') {$file4 = '';}
if ($_FILES['file4']['name'] != '') {$file4 = $_FILES['file4']['name'];}
if ($_FILES['file5']['name'] == 'none') {$file5 = '';}
if ($_FILES['file5']['name'] != '') {$file5 = $_FILES['file5']['name'];}
$err22 = "���������� ������ ����� ���������� *.jpg ���� *.gif<br>";
$err23 = "���������� ������ ����� ������ �� ����� $MAX_FILE_SIZE ����!<br>";
$error = "";

echo "<center><p><strong><big>����������������� - �������</strong></big>";
echo ("
<table class=tbl1 border=0><tr><td>
<a class=menu href=adminews.php?action=add>�������� �������</a> |
<a class=menu href=adminews.php?action=view>�������� / �������� ��������</a> |
</td>
</tr>
</table>
");
?>

<script>
//����� �� ���������� ����� � ��� ������� ��� �� ���� � ����������� �������� Q true ���� ���� ��������� ������ � false ���� ���
if (document.selection||document.getSelection) {Q=true} else {var Q=false} 
//���������� ����������
var txt=''
//������� �����������
function copyQ(Tag,Tag2) { 
//����� ���������� ����������
txt='' 
//������� �� ������� � ���������� ���������� txt ����������� ����������
if (document.getSelection) {txt=document.getSelection()} 
else if (document.selection) {txt=document.selection.createRange().text;} 
//����� ��������� � ���� � ���������������
txt=Tag+txt+Tag2
}

//function pasteQ(){if(document.postform.post)document.postform.post.value += txt} 
//������� setCaret � ��� ������� ��� ����������� �������� textObj ��������� ������ � ������������� ����������� ��������� ���  ��� ?
function setCaret (textObj) { 
if (textObj.createTextRange) { 
textObj.caretPos = document.selection.createRange().duplicate(); 
} 
} 

//������� ������� ������ textObj- ��� �� ��� ���� ���������, � textFieldValue - ��� ���� �������� ��� ���������� �����
function insertAtCaret (textObj, textFieldValue) { 
if(document.all){ 
// ��� ��� �� ����� ������� ��� ��� �� ������� if (textObj.createTextRange && textObj.caretPos && !window.opera) � ��� ����� ��� ��� ����������� ��������
if (textObj.createTextRange && textObj.caretPos && !window.opera) { 
var caretPos = textObj.caretPos; //����� ����������� caretPos ���������� ����� 
//��� �������� ������������ ��� ����� ��������� ���� ������ ������ ��� ������������� ������
caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?textFieldValue + ' ' : textFieldValue; 
}else{ 
textObj.value += textFieldValue; //����� ������ ��������� ���������
} 
}else{ 
//��� � ����� ������� ��� ����� ��� ���
if(textObj.selectionStart){ 
var rangeStart = textObj.selectionStart; 
var rangeEnd = textObj.selectionEnd; 
var tempStr1 = textObj.value.substring(0,rangeStart); 
var tempStr2 = textObj.value.substring(rangeEnd, textObj.value.length); 
textObj.value = tempStr1 + textFieldValue + tempStr2; 
textObj.selectionStart=textObj.selectionEnd=rangeStart+textFieldValue.length;
}else{ 
textObj.value+=textFieldValue; 
} 
} 
}

//������� �������
function pasteQ(){
//���� txt �� ������ � ??? �� ��������� � ���� �������� ��� txt
if (txt!='' && document.getElementById('post')) 
insertAtCaret(document.getElementById("post"),txt); 
} 


function link(a){
var url = "[url="+topic_url+a+"]"+topic_title+"[/url]";
prompt('���������� �����.', url);
}
</script>

<?
if(isset($action)=="" || !$action)
 {
//wellcome
 }
//############################################ ADD ######################
elseif($action=="add")
 {
   $year=date('Y');
   $month=date('m');
   $day=date('d');
   $now_date = $year."-".$month."-".$day;
   $time=date('H:i');
?>

<form action=adminews.php method=post enctype=multipart/form-data name=formata>


..:: ���������� ������� ::.. 
<table class=tbl1 cellpadding=5 cellspacing=0 border=0 width=100%>
  <tr>
    <td width=10%>����:</td>
    <td><input type=text name=datum style="width: 100px;" value="<?=$now_date?>"></td>
  </tr>
  <tr>
    <td>���������:</td>
    <td><input type=text name=title style="width: 80%;"></td>
  </tr>
  <tr>
    <td></td>
    <td>
      <a onmouseover="copyQ('[cut]','\n ');" href="javascript:pasteQ();" title="������ ��� �������� ����������" class=buten>cut</a>
      <a onmouseover="copyQ('<b>','</b>');" href="javascript:pasteQ();" title="���������� �����" class=buten>b</a>
      <a onmouseover="copyQ('<i>','</i>');" href="javascript:pasteQ();" title="������" class=buten>i</a>
      <a onmouseover="copyQ('<u>','</u>');" href="javascript:pasteQ();" title="�������������" class=buten>u</u>
      <a onmouseover="copyQ('<center>','</center>');" href="javascript:pasteQ();" title="" class=buten>center</a>
      <a onmouseover="copyQ('<ul>','</ul>');" href="javascript:pasteQ();" title="������" class=buten>ul</a>
      <a onmouseover="copyQ('<li>','</li>');" href="javascript:pasteQ();" title="������� ������" class=buten>li</a>
      <a onmouseover="copyQ('&laquo;','&raquo;');" href="javascript:pasteQ();" title="�������" class=buten>&laquo; &raquo;</a>
      <a onmouseover="copyQ('\n<br>','\n ');" href="javascript:pasteQ();" title="������� ������" class=buten>br</a>
      <a onmouseover="copyQ('\n<p>','\n ');" href="javascript:pasteQ();" title="�����" class=buten>�����</a>
      <a onmouseover="copyQ('<a href=>','</a>');" href="javascript:pasteQ();" title="������" class=buten>������</a>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      ���� [cut] � ������ ���������� �������, �� � ������ ������ ������ ���������� ��������.<br>
      ���� [cut] � �������� ������, �� ���������� ������� '��������� &raquo;'.<br>
      ���� [cut] �����������, �� � ������ ��������� ������ ����� �������.
    </td>
  </tr>
  <tr>
    <td valign=top>����������:</td>
    <td><textarea name=content style="height: 250px; width: 100%; padding: 5px;" id="post" onselect="setCaret(this);" onclick="setCaret(this);" onkeyup="setCaret(this);"></textarea><br>��� ������� � ����� ���������� �������� � ������ ����� ��������� ����x, ��� x - ����� ���� (�������� ���� ����, �������� ����3). ����������� ���������� �������. ����� �����, � ��������� ����, �������� ����������� ���������� ��� ��������.</td>
  </tr>
<tr><td colspan=2>
<input type=hidden name=action1 value=1>
����1: <input type=file name=file1 size=30><br>
����2: <input type=file name=file2 size=30><br>
����3: <input type=file name=file3 size=30><br>
����4: <input type=file name=file4 size=30><br>
����5: <input type=file name=file5 size=30><br>
</td></tr>
  <tr>
    <td valign=top></td>
    <td>
<input type=button OnClick="window.open('adminhv.php',this.target,'width=700,height=350,'+'location=no,toolbar=no,menubar=no,status=yes,resizeable=yes,scrollbars=yes');return false;"  value="������������ ������">
<input type=submit class=btn value="���������"></td>
  </tr>
</table>
    <input type=hidden name=do value="save">
    <input type=hidden name=action value="add_on">
    <input type=hidden name=time value="<?=$time?>">
</form>
<?
}
//############## add on
elseif(isset($action) && $action=="add_on")
{
$time=$_POST['time'];
$datum=$_POST['datum'];
$title=$_POST['title'];
$content=$_POST['content'];

if ($file1 != "") {
$file1 = $HTTP_POST_FILES['file1']['name'];
$filesize1 = $HTTP_POST_FILES['file1']['size']; 
$temp1 = $HTTP_POST_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file2 != "") {
$file2 = $HTTP_POST_FILES['file2']['name'];
$filesize2 = $HTTP_POST_FILES['file2']['size']; 
$temp2 = $HTTP_POST_FILES['file2']['tmp_name'];
$fileres2=strtolower(basename($file2));
if ($file2 != "" and !eregi("\.jpg$",$fileres2) and !eregi("\.gif$",$fileres2)){$error .= "$err22";}
if ($filesize2 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file3 != "") {
$file3 = $HTTP_POST_FILES['file3']['name'];
$filesize3 = $HTTP_POST_FILES['file3']['size']; 
$temp3 = $HTTP_POST_FILES['file3']['tmp_name'];
$fileres3=strtolower(basename($file3));
if ($file3 != "" and !eregi("\.jpg$",$fileres3) and !eregi("\.gif$",$fileres3)){$error .= "$err22";}
if ($filesize3 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file4 != "") {
$file4 = $HTTP_POST_FILES['file4']['name'];
$filesize4 = $HTTP_POST_FILES['file4']['size']; 
$temp4 = $HTTP_POST_FILES['file4']['tmp_name'];
$fileres4=strtolower(basename($file4));
if ($file4 != "" and !eregi("\.jpg$",$fileres4) and !eregi("\.gif$",$fileres4)){$error .= "$err22";}
if ($filesize4 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file5 != "") {
$file5 = $HTTP_POST_FILES['file5']['name'];
$filesize5 = $HTTP_POST_FILES['file5']['size']; 
$temp5 = $HTTP_POST_FILES['file5']['tmp_name'];
$fileres5=strtolower(basename($file5));
if ($file5 != "" and !eregi("\.jpg$",$fileres5) and !eregi("\.gif$",$fileres5)){$error .= "$err22";}
if ($filesize5 > $MAX_FILE_SIZE){$error .= "$err23";}
}

   if(isset($title)   && $title!=""   && !eregi(".[^ ]{40}",$title) &&
      isset($content) && $content!="" && !eregi(".[^ ]{70}",$content) && $error == '' &&
      isset($datum)   && $datum!=""
      )
   {
     $visible='on';
     $ip=getenv("REMOTE_ADDR")."::".getenv("HTTP_X_FORWARDED_FOR");
     $brouser=getenv("HTTP_USER_AGENT");

     $content = str_replace("\"","&quot;", $content);

function untag ($string) {
//$string = ereg_replace("<","&lt;",$string);
//$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
$string = ereg_replace("<script>","",$string);
return $string;
}
$title = untag($title);
$content = untag($content);

     $title   = str_replace("\"","&quot;", $title);


if ($file1 != "" or $file2 != "" or $file3 != "" or $file4 != "" or $file5 != "") {
$result1 = @mysql_query("SELECT idnum FROM $newstable order by idnum DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$fid=$myrow["idnum"];
}
$fid=$fid+1;
$updir=$news_dir;
$path1 = $upath."$updir";
$fileres1=@substr($fileres1,-3,3);
$fileres2=@substr($fileres2,-3,3);
$fileres3=@substr($fileres3,-3,3);
$fileres4=@substr($fileres4,-3,3);
$fileres5=@substr($fileres5,-3,3);
$source_name1="";
$source_name2="";
$source_name3="";
$source_name4="";
$source_name5="";
if ($file1 != "") {$source_name1 = "news".$fid."_1.$fileres1";}
if ($file2 != "") {$source_name2 = "news".$fid."_2.$fileres2";}
if ($file3 != "") {$source_name3 = "news".$fid."_3.$fileres3";}
if ($file4 != "") {$source_name4 = "news".$fid."_4.$fileres4";}
if ($file5 != "") {$source_name5 = "news".$fid."_5.$fileres5";}
if($error == ""){
$dest1 = $path1.$source_name1;
$dest2 = $path1.$source_name2;
$dest3 = $path1.$source_name3;
$dest4 = $path1.$source_name4;
$dest5 = $path1.$source_name5;
if ($file1 != "") {
@copy("$temp1","$dest1");$foto1=$updir."$source_name1";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres1=='jpg') or (ImageTypes() & IMG_GIF and $fileres1=='gif'))
{ //small img
if ($fileres1=='jpg') {$image = ImageCreateFromJPEG($foto1);}
if ($fileres1=='gif') {$image = ImageCreateFromGIF($foto1);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres1=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name1);}
if ($fileres1=='gif') {ImageGIF($thumb, $updir.'s'.$source_name1);}
}} //small img
}
if ($file2 != "") {
@copy("$temp2","$dest2");$foto2=$updir."$source_name2";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres2=='jpg') or (ImageTypes() & IMG_GIF and $fileres2=='gif'))
{ //small img
if ($fileres2=='jpg') {$image = ImageCreateFromJPEG($foto2);}
if ($fileres2=='gif') {$image = ImageCreateFromGIF($foto2);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres2=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name2);}
if ($fileres2=='gif') {ImageGIF($thumb, $updir.'s'.$source_name2);}
}} //small img
}
if ($file3 != "") {
@copy("$temp3","$dest3");$foto3=$updir."$source_name3";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres3=='jpg') or (ImageTypes() & IMG_GIF and $fileres3=='gif'))
{ //small img
if ($fileres3=='jpg') {$image = ImageCreateFromJPEG($foto3);}
if ($fileres3=='gif') {$image = ImageCreateFromGIF($foto3);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres3=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name3);}
if ($fileres3=='gif') {ImageGIF($thumb, $updir.'s'.$source_name3);}
}} //small img
}
if ($file4 != "") {
@copy("$temp4","$dest4");$foto4=$updir."$source_name4";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres4=='jpg') or (ImageTypes() & IMG_GIF and $fileres4=='gif'))
{ //small img
if ($fileres4=='jpg') {$image = ImageCreateFromJPEG($foto4);}
if ($fileres4=='gif') {$image = ImageCreateFromGIF($foto4);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres4=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name4);}
if ($fileres4=='gif') {ImageGIF($thumb, $updir.'s'.$source_name4);}
}} //small img
}
if ($file5 != "") {
@copy("$temp5","$dest5");$foto5=$updir."$source_name5";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres5=='jpg') or (ImageTypes() & IMG_GIF and $fileres5=='gif'))
{ //small img
if ($fileres5=='jpg') {$image = ImageCreateFromJPEG($foto5);}
if ($fileres5=='gif') {$image = ImageCreateFromGIF($foto5);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres5=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name5);}
if ($fileres5=='gif') {ImageGIF($thumb, $updir.'s'.$source_name5);}
}} //small img
}
}
}

if (eregi('����1',$content) and $source_name1 != ""){if (file_exists($news_dir.'s'.$source_name1)) {$wfoto1="s$source_name1";} elseif (!file_exists($news_dir.'s'.$source_name1)) {$wfoto1="$source_name1";} $content=@str_replace('����1',"<a href=$news_dir$source_name1 target=_blank><img src=$news_dir$wfoto1 border=0 height=$smallfotoheight align=left></a>",$content);}
if (eregi('����2',$content) and $source_name2 != ""){if (file_exists($news_dir.'s'.$source_name2)) {$wfoto2="s$source_name2";} elseif (!file_exists($news_dir.'s'.$source_name2)) {$wfoto2="$source_name2";} $content=@str_replace('����2',"<a href=$news_dir$source_name2 target=_blank><img src=$news_dir$wfoto2 border=0 height=$smallfotoheight align=left></a>",$content);}
if (eregi('����3',$content) and $source_name3 != ""){if (file_exists($news_dir.'s'.$source_name3)) {$wfoto3="s$source_name3";} elseif (!file_exists($news_dir.'s'.$source_name3)) {$wfoto3="$source_name3";} $content=@str_replace('����3',"<a href=$news_dir$source_name3 target=_blank><img src=$news_dir$wfoto3 border=0 height=$smallfotoheight align=left></a>",$content);}
if (eregi('����4',$content) and $source_name4 != ""){if (file_exists($news_dir.'s'.$source_name4)) {$wfoto4="s$source_name4";} elseif (!file_exists($news_dir.'s'.$source_name4)) {$wfoto4="$source_name4";} $content=@str_replace('����4',"<a href=$news_dir$source_name4 target=_blank><img src=$news_dir$wfoto4 border=0 height=$smallfotoheight align=left></a>",$content);}
if (eregi('����5',$content) and $source_name5 != ""){if (file_exists($news_dir.'s'.$source_name5)) {$wfoto5="s$source_name5";} elseif (!file_exists($news_dir.'s'.$source_name5)) {$wfoto5="$source_name5";} $content=@str_replace('����5',"<a href=$news_dir$source_name5 target=_blank><img src=$news_dir$wfoto5 border=0 height=$smallfotoheight align=left></a>",$content);}

     mysql_query("insert into $newstable
            values(null,
                  \"$time\",
                  \"$datum\",
                  \"$title\",
                  \"$content\",
                  \"$visible\",
                  \"$ip\",
                  \"$brouser\")")or die(mysql_error());
     echo "<font color=green>������ �������!!!</font><hr>";
     $raz=explode("-",$datum);
     echo "<nobr><a href='adminews.php?action=view&year=".$raz[0]."&today=".$raz[2]."&month=".$raz[1]."' ";
     echo "class=buten>� �������� &raquo;</a></nobr>";
   }
   else
   {
      echo "���������� �� ����� ���� ���������, �� ����� �������� ������<br>$error<ul>";
      if(!isset($title)   || $title==""){echo "<li>���� \"���������\" ������ ���� ��������� �����������!</li>";}
      if(!isset($content) || $content==""){echo "<li>\"����������\" ������ ���� ��������� �����������!</li>";}
      if(eregi(".[^ ]{70}",$content)){echo "<li>���������� ���������� ������� � ���������� �������!</li>";}
      if(eregi(".[^ ]{40}",$title)){echo "<li>���������� ���������� ������� � ��������� �������!</li>";}
      if(!isset($datum)   || $datum==""){echo "<li>���� \"����\" ������ ���� ��������� �����������!</li>";}
      echo "</ul><hr size=1 color=black noshade></a><a href=javascript:history.back(2) class=menu><< ���������� ��� ���.</a>";
   }
}
//########### add stop

//###################### VIEW #########################################
elseif(isset($action) && $action=="view")
{

   // �������� ������
  if($_POST['delete'] == "on")
   {
$id=$_POST['id'];
    if (isset($id))
     {
      mysql_query("delete from $newstable where idnum = ".$id."");
      echo "<font color=red>������ ������ �������!!!</font><hr size=1><br>";
     }
   }

   echo "..:: �������� �������� ::..<hr>";


   echo "<table class=tbl1 border=1 width=100% bordercolor=#BDD7D6 cellpadding=10><tr><td valign=top width=170>";



   //������� �� �����
if (isset($_GET['month'])) {
   $month = $_GET['month'];
   $month = ereg_replace ("[[:space:]]", "", $month);
   $month = ereg_replace ("[[:punct:]]", "", $month);
   $month = ereg_replace ("[[:alpha:]]", "", $month);
   if ($month < 1) { $month = 12; }
   if ($month > 12) { $month = 1; }
   }

if (isset($_GET['year'])) {
   $year = $_GET['year'];
   $year = ereg_replace ("[[:space:]]", "", $year);
   $year = ereg_replace ("[[:punct:]]", "", $year);
   $year = ereg_replace ("[[:alpha:]]", "", $year);
   if ($year < 1990) { $year = 1990; }
   if ($year > 2035) { $year = 2035; }
   }

if (isset($_GET['today'])) {
   $today = $_GET['today'];
   $today = ereg_replace ("[[:space:]]", "", $today);
   $today = ereg_replace ("[[:punct:]]", "", $today);
   $today = ereg_replace ("[[:alpha:]]", "", $today);
   }

function denned_to_rus($denned)
{
 if($denned==0) $denned=7;
 return $denned;
}

$month = (isset($month)) ? $month : date("n",time());
$year  = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong   = date("l",mktime(1,1,1,$month,$today,$year)); //���� ������ ����� ����.
$monthlong = date("F",mktime(1,1,1,$month,$today,$year)); //�������� ������ ����.
$dayone    = date("w",mktime(1,1,1,$month,1,$year)); //���� ������ ������
$numdays   = date("t",mktime(1,1,1,$month,1,$year)); //���������� ���� � ������
$alldays   = array('��','��','��','��','��','<font color=red>��</font>','<font color=red>��</font>');
$next_year = $year + 1;
$last_year = $year - 1;
$next_month = $month + 1;
$last_month = $month - 1;
if ($today > $numdays) { $today--; }
        if($month == "1" ){$month_ru="������";}
    elseif($month == "2" ){$month_ru="�������";}
    elseif($month == "3" ){$month_ru="����";}
    elseif($month == "4" ){$month_ru="������";}
    elseif($month == "5" ){$month_ru="���";}
    elseif($month == "6" ){$month_ru="����";}
    elseif($month == "7" ){$month_ru="����";}
    elseif($month == "8" ){$month_ru="������";}
    elseif($month == "9" ){$month_ru="��������";}
    elseif($month == "10"){$month_ru="�������";}
    elseif($month == "11"){$month_ru="������";}
    elseif($month == "12"){$month_ru="�������";}

$denned1day = denned_to_rus(date("w",mktime(1,1,1,$month,1,$year)));
$dennedNOWday = denned_to_rus(date("w",mktime(1,1,1,$month,$today,$year)));
$dennedLASTday = denned_to_rus(date("w",mktime(1,1,1,$month,$numdays,$year)));

$num_of_zero_days = 7 - $dennedLASTday;

$days=array();

echo "<table class=tbl1 border=0 cellpadding=4 cellspacing=1 width=170>";

//������� �������� ����
echo "<tr bgcolor=#E7EBEF>
      <td align=center><a href=adminews.php?year=".$last_year."&today=".$today."&month=".$month."&action=view>&laquo;</a></td>";
echo "<td width=100% class=\"cellbg\" colspan=\"5\" valign=\"middle\" align=\"center\">
      <b>".$year." �.</b></td>\n";
echo "<td align=center><a href=adminews.php?year=".$next_year."&today=".$today."&month=".$month."&action=view>&raquo;</a></td>";
echo "</tr>\n<tr>\n</table>";

//������� �������� ������
echo "<table class=tbl1 border=0 cellpadding=4 cellspacing=1 width=170>";
echo "<tr bgcolor=#E7EBEF>
      <td align=center><a href=adminews.php?year=".$year."&today=".$today."&month=".$last_month."&action=view>&laquo;</a></td>";
echo "<td width=100% class=\"cellbg\" colspan=\"5\" valign=\"middle\" align=\"center\">
      <b>".$month_ru."</b></td>\n";
echo "<td align=center><a href=adminews.php?year=".$year."&today=".$today."&month=".$next_month."&action=view>&raquo;</a></td>";
echo "</tr>\n<tr>\n</table>";

echo "<table class=tbl1 border=0 cellpadding=2 cellspacing=1 width=170><tr>";
//������� ��� ������
foreach($alldays as $value) {
  echo "<td valign=\"middle\" align=\"center\" width=\"10%\">
        <b>".$value."</b></td>\n";
}
echo "</tr>\n<tr>\n";


//������� ������ ��� ������ ��� �������
echo "<tr>\n";
for($z=1;$z<$denned1day;$z++)
{
  echo "<td valign=\"middle\" align=\"center\">&nbsp;</td>\n";
}


//������� ��� ������
for($d=1;$d<=$numdays;$d++)
{
  $days[$d]=denned_to_rus(date("w",mktime(1,1,1,$month,$d,$year)));
  if($days[$d]==1) echo "<tr>\n";
  if ($d == $today)
  {
    echo "<td valign=\"middle\" align=\"center\" bgcolor=#B9D7D5>";
          $news_date = $year."-".$month."-".$d;
          $news_result = mysql_query("select * from $newstable where datum = '".$news_date."'");
          $news_rows = mysql_num_rows($news_result);
          if($news_rows >0) {
           echo "<a class=linkz href=\"adminews.php?year=$year&today=$d&month=$month&action=view\">".$d."</a>";
           }
          else {
           echo $d;
           }
          echo "</td>\n";
  }
  else {
    echo "<td valign=\"middle\" align=\"center\">";
          $news_date = $year."-".$month."-".$d;
          $news_result = mysql_query("select * from $newstable where datum = '".$news_date."'");
          $news_rows = mysql_num_rows($news_result);
          if($news_rows >0) {
           echo "<a class=linkz href=\"adminews.php?year=".$year."&today=".$d."&month=".$month."&action=view\">".$d."</a>";
          }
          else {
           echo $d;
           }
          echo "</td>\n";
  }
  if($days[$d]==7) echo "</tr>\n\n";
}

for($z=0;$z<$num_of_zero_days;$z++)
{
  echo "<td valign=\"middle\" align=\"center\">&nbsp;</td>\n";
}
echo "</tr>\n";
echo "</table>";


   echo "</td><td valign=top>";
   $sql_date = $year."-".$month."-".$today;

   $result = mysql_query("select * from $newstable where datum='".$sql_date."' order by datum desc");
   $rows = mysql_num_rows($result);


   if($rows > 0 && !isset($_GET['long']))
   {
      ?>
      <table class=tbl1 width=100% cellpadding=4 border=0 cellspacing=2>
      <?
      for($k=0;$k < $rows;$k++)
      {
        $time=mysql_result($result, $k , "time");
        $datum=mysql_result($result, $k , "datum");
        $title=mysql_result($result, $k , "title");
        $idnum=mysql_result($result, $k , "idnum");

        $datun=explode("-",$datum);
            if($datun[1] == "1" || $datun[1] == "01"){$month="������";}
        elseif($datun[1] == "2" || $datun[1] == "02"){$month="�������";}
        elseif($datun[1] == "3" || $datun[1] == "03"){$month="�����";}
        elseif($datun[1] == "4" || $datun[1] == "04"){$month="������";}
        elseif($datun[1] == "5" || $datun[1] == "05"){$month="���";}
        elseif($datun[1] == "6" || $datun[1] == "06"){$month="����";}
        elseif($datun[1] == "7" || $datun[1] == "07"){$month="����";}
        elseif($datun[1] == "8" || $datun[1] == "08"){$month="�������";}
        elseif($datun[1] == "9" || $datun[1] == "09"){$month="��������";}
        elseif($datun[1] == "10"){$month="�������";}
        elseif($datun[1] == "11"){$month="������";}
        elseif($datun[1] == "12"){$month="�������";}

        if(($k % 2) == 0){$bgcol="#F7F8FC";}
        else{$bgcol="#EBEBEC";}
        $kp=$k+1;
        ?>
         <tr bgcolor=<?=$bgcol?>>
           <td><?=$kp?></td>
           <td><?=$time?></td>
           <td><nobr><?=$datun[2]?> <?=$month?> <?=$datun[0]?> </nobr></td>
           <td><a href="<? echo "adminews.php?idnum=".$idnum; ?>&action=view&long=ok&year=<?=$year?>&today=<?=$today?>&month=<?=$month?>"><?=$title?></a></td>
         <?
           echo "<form method=post action=adminews.php?action=izm name=izm".$k." style=\"margin: 0px; padding: 0px;\">
                 <td width=50 valign=top>";
           echo "<input style=\"width: 40px; background-color: green; color: white;\"
                  type=submit value=\"Edit\">";
           echo "<input type=hidden name=action value=izm>";
           echo "<input type=hidden name=idnum value=".$idnum.">";
           echo "</td></form>";
          ?>
           <td width=50>
           <form method=post action=adminews.php?year=<?=$year?>&today=<?=$today?>&month=<?=$datun[1]?>
             name=dela<?=$k?> style="margin: 0px;">
             <input style="width: 50px; background: red; color: white;"
              type=button value="Delete" OnClick="dela<?=$k?>.submit();">
             <input type=hidden name=delete value=on>
             <input type=hidden name=action value=view>
             <input type=hidden name=id value=<?=$idnum?>>
           </form>
           </td>
         </tr>
         <?
        }
        echo "</table>";
      }
      elseif(isset($_GET['long']))
      {
$idnum=$_GET['idnum'];
         $result = mysql_query("select * from $newstable where idnum='".$idnum."'  limit 1");
         $rows = mysql_num_rows($result);

         $datum=mysql_result($result, 0 , "datum");
         $title=mysql_result($result, 0 , "title");
         $idnum=mysql_result($result, 0 , "idnum");
         $ip=mysql_result($result, 0 , "ip");
         $time=mysql_result($result, 0 , "time");
         $brouser=mysql_result($result, 0 , "brouser");
         $content=mysql_result($result, 0 , "content");
         $content = ereg_replace("\n","<br>",$content);
         $content=str_replace("admin/","../admin/",$content);
         ?>

         <hr>
         <table class=tbl1 width=100% cellpadding=2 border=0 cellspacing=0 style="border: solid 1 px gray;">
           <tr>
             <td class=header bgcolor="#F0F0F0">����: <b><?=$datum?></b> | �����: <b><?=$time?></b></td>
           </tr>
           <tr>
             <td class=header bgcolor="#F0F0F0">���������: <b><?=$title?></b></td>
           </tr>
           <tr>
             <td class=header bgcolor="#F0F0F0">IP ����� ������: <b><?=$ip?></b></td>
           </tr>
           <tr>
             <td class=header bgcolor="#F0F0F0">�������: <b><?=$brouser?></b></td>
           </tr>
           <tr>
             <td>
              <table class=tbl1 style="text-align: justify; border: solid 1 px black; padding: 10px; width: 100%">
              <tr><td>
              <?=$content?>
              </td></tr>
              </table>
             </td>
           </tr>
         </table>
         <hr>
         <a href="javascript: history.back(2)">&laquo; �����</a>
         <?
      }

  echo "</td></tr></table>";

}
//############################################ IZM ######################
elseif($action=="izm" && isset($_POST['idnum']))
 {
$idnum=$_POST['idnum'];

 $result = mysql_query("select * from $newstable where idnum='".$idnum."'");
 $rows = mysql_num_rows($result);

         $datum=mysql_result($result, 0 , "datum");
         $time=mysql_result($result, 0 , "time");
         $title=mysql_result($result, 0 , "title");
         $content=mysql_result($result, 0 , "content");
         $content = ereg_replace("\n","<br>",$content);
         $idnum=mysql_result($result, 0 , "idnum");

?>

<form action=adminews.php method=post enctype=multipart/form-data name=formata>

..:: ��������� ������� ::.. <hr>
<table class=tbl1 cellpadding=5 cellspacing=0 border=0 width=100%>
  <tr>
    <td width=10%>�����:</td>
    <td><input type=text name=time style="width: 100px;" value="<?=$time?>"></td>
  </tr>
  <tr>
    <td width=10%>����:</td>
    <td><input type=text name=datum style="width: 100px;" value="<?=$datum?>"></td>
  </tr>
  <tr>
    <td>���������:</td>
    <td><input type=text name=title style="width: 80%;" value="<?=$title?>">></td>
  </tr>
  <tr>
    <td></td>
    <td>
      <a onmouseover="copyQ('[cut]','\n ');" href="javascript:pasteQ();" title="������ ��� �������� ����������" class=buten>cut</a>
      <a onmouseover="copyQ('<b>','</b>');" href="javascript:pasteQ();" title="���������� �����" class=buten>b</a>
      <a onmouseover="copyQ('<i>','</i>');" href="javascript:pasteQ();" title="������" class=buten>i</a>
      <a onmouseover="copyQ('<u>','</u>');" href="javascript:pasteQ();" title="�������������" class=buten>u</u>
      <a onmouseover="copyQ('<center>','</center>');" href="javascript:pasteQ();" title="" class=buten>center</a>
      <a onmouseover="copyQ('<ul>','</ul>');" href="javascript:pasteQ();" title="������" class=buten>ul</a>
      <a onmouseover="copyQ('<li>','</li>');" href="javascript:pasteQ();" title="������� ������" class=buten>li</a>
      <a onmouseover="copyQ('&laquo;','&raquo;');" href="javascript:pasteQ();" title="�������" class=buten>&laquo; &raquo;</a>
      <a onmouseover="copyQ('\n<br>','\n ');" href="javascript:pasteQ();" title="������� ������" class=buten>br</a>
      <a onmouseover="copyQ('\n<p>','\n ');" href="javascript:pasteQ();" title="�����" class=buten>�����</a>
      <a onmouseover="copyQ('<a href=>','</a>');" href="javascript:pasteQ();" title="������" class=buten>������</a>
    </td>
  </tr>
  <tr>
    <td valign=top>����������:</td>
    <td><textarea name=content style="height: 250px; width: 100%; padding: 5px;" id="post" onselect="setCaret(this);" onclick="setCaret(this);" onkeyup="setCaret(this);"><?=$content?></textarea></td>
  </tr>
  <tr>
    <td valign=top></td>
    <td>
<input type=button OnClick="window.open('adminhv.php',this.target,'width=700,height=350,'+'location=no,toolbar=no,menubar=no,status=yes,resizeable=yes,scrollbars=yes');return false;"  value="������������ ������">
<input type=submit class=btn value="���������"></td>
  </tr>
</table>
    <input type=hidden name=do value="save">
    <input type=hidden name=idnum value="<?=$idnum?>">
    <input type=hidden name=action value="izm_on">
</form>
<?
}
//############## izm  on
elseif(isset($action) && $action=="izm_on")
{
$time=$_POST['time'];
$idnum=$_POST['idnum'];
$datum=$_POST['datum'];
$title=$_POST['title'];
$content=$_POST['content'];
   if(isset($title)   && $title!=""   && !eregi(".[^ ]{40}",$title) &&
      isset($content) && $content!="" && !eregi(".[^ ]{70}",$content) &&
      isset($time)    && $time!=""    &&
      isset($datum)   && $datum!=""
      )
   {

function untag ($string) {
//$string = ereg_replace("<","&lt;",$string);
//$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
$string = ereg_replace("<script>","",$string);
return $string;
}
$title = untag($title);
$content = untag($content);

     mysql_query("update $newstable set
                  datum = \"".$datum."\",
                  time  = \"".$time."\",
                  title = \"".$title."\",
                  content =\"".$content."\" where idnum = \"".$idnum."\" ") or die(mysql_error());
     echo "<font color=green>������ �������!!!</font><hr>";
     $raz=explode("-",$datum);
     echo "<nobr><a href='adminews.php?action=view&year=".$raz[0]."&today=".$raz[2]."&month=".$raz[1]."' ";
     echo "class=buten>� �������� &raquo;</a></nobr>";
   }
   else
   {
      echo "���������� �� ����� ���� ���������, �� ����� �������� ������<br><ul>";
      if(!isset($title)   || $title==""){echo "<li>���� \"���������\" ������ ���� ��������� �����������!</li>";}
      if(!isset($content) || $content==""){echo "<li>\"����������\" ������ ���� ��������� �����������!</li>";}
      if(eregi(".[^ ]{70}",$content)){echo "<li>���������� ���������� ������� � ���������� �������!</li>";}
      if(eregi(".[^ ]{40}",$title)){echo "<li>���������� ���������� ������� � ��������� �������!</li>";}
      if(!isset($time)    || $time==""){echo "<li>���� \"�����\" ������ ���� ��������� �����������!</li>";}
      if(!isset($datum)   || $datum==""){echo "<li>���� \"����\" ������ ���� ��������� �����������!</li>";}
      echo "</ul><hr size=1 color=black noshade></a><a href=javascript:history.back(2) class=menu><< ���������� ��� ���.</a>";
   }
}


} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>