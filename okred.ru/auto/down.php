<br><br><div align=center><table><tr><td><g:plusone size="small"></g:plusone></td><td><script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script> <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div></td></tr></table></div>

<!-- нижний рекламный блок начало -->
<center><?
if ($qwerypromo == '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'index' or place = 'all') order by allcity DESC,RAND() limit $promodownlimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'vac' or place = 'all') order by allcity DESC,RAND() limit $promodownlimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'res' or place = 'all') order by allcity DESC,RAND() limit $promodownlimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'other' or place = 'all') order by allcity DESC,RAND() limit $promodownlimit");}
}
if ($qwerypromo != '')
{
if (!eregi('.php',$n) or eregi('/index.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'index' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promodownlimit");}
elseif (eregi('/listvac.php',$n) or eregi('/linkvac.php',$n) or eregi('/searchv.php',$n) or eregi('/orderv.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'vac' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promodownlimit");}
elseif (eregi('/listres.php',$n) or eregi('/linkres.php',$n) or eregi('/searchr.php',$n) or eregi('/orderr.php',$n)) {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'res' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promodownlimit");}
else {$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'down' and (place = 'other' or place = 'all') $qwerypromo order by city DESC,date DESC limit $promodownlimit");}
}

 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
echo "<div align=center>";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
if ($pfoto != '') {echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a>";}
if ($pfoto == '') {echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$plink\" title='$ptitle' target=_blank class=tbl1>$ptitle</a>";}
}
echo "</div>";
}
if ($rows==0 or $rows < $promodownlimit) {echo "<a href=\"promoadd.php\" title=\"Добавить рекламу на это место\"></a>";}
?></center>
<!-- нижний рекламный блок конец -->


 </div><!--/middle-->




<div class="clear"></div>


<div id="footer">
<div class="foottext">&copy;  Сайт газеты «Все вакансии»<br />
    
    Контактный телефон: (495) 215-10-20<br />
    E-mail: <a href="mailto:info@all-vacancies.ru">info@all-vacancies.ru</a><br />
 </div>
 
 
 <table width="60%" border="0">
  <tr>
    <td valign="top"><div class="footlinks">
    <h2>Работодателям</h2>
     <ul>
<li><a href="addvac.php">Публикация вакансий</a></li>

<li><a href="http://all-vacancies.ru/text.php?link=1">Условия размещения</a></li>
         </ul>
         </div></td>
   <td valign="top"><div class="footlinks">
    <h2>Соискателям</h2>
     <ul>
<li><a href="#">Продвижение резюме</a></li>
<li><a href="#">Защита персональных данных</a></li>
<li></li>
         </ul>
         </div></td>
  </tr>
</table>
    <!--footlinks-->
             
    <div class="clear"></div>
</div>
<?php include("../_php/footer.php"); ?><!--/ footer-->
</div><!--/ conteiner-->
<div class="strip"> </div>
</body>
</html>
