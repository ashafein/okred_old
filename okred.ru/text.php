﻿<?php
function db_connect($qwerty) {
$host='localhost';
$user='root';
$pw='gfhjkm';
$dbname='okred';

$connect=mysql_connect($host,$user,$pw);
$db=mysql_select_db($dbname,$connect);
$res=mysql_query($qwerty,$connect);
return $res;
}
function text(){
	$q="select id, name, translate from text where id=2";
	$res=db_connect($q);
	while($a=mysql_fetch_array($res)){
		$h=$a['name'];
		$url="remont-komputerov-".$a['translate'];
		$text="<h1>Ремонт компьютеров ".$h."</h1><p>Опытные специалисты Сервисного центра осуществляют квалифицированный ремонт компьютеров как на выезде (в офисе, на дому), так и в стационарном Сервисном центре.</p><p>Мастер прибудет в назначенное время и качественно отремонтируют Ваш компьютер, устранив причину неисправности. Если диагностика выявит серьезные нарушения в системе или компоненте, мы быстро решим проблему в собственном Сервисном центре. К оплате принимается наличный и безналичный расчет.</p><p>Наши специалисты производят ремонт компьютеров любой сложности: ремонт и замена видеокарты, жесткого диска, портов, шлейфов, приводов, замена материнской платы, процессора, памяти, системы охлаждения и многое другое.</p><h3>Компьютерная помощь ".$h."</h3><p>Вы также можете воспользоваться услугами профессиональной компьютерной помощи: удаление всех видов вирусов и баннеров, установка и настройка антивируса, восстановление данных с поврежденного носителя, чистка системы охлаждения, установка и переустановка ОС, устранение системных ошибок Windows, создание локальной сети, подключение периферии, подключение и настройка Интернет и многое другое.</p><p>По окончанию работ каждому нашему клиенту вручается гарантийный сертификат на оказанные услуги сроком до 3-х лет.</p>";
	$q="update text set translate='".$url."', text='".$text."' where id=".$a['id'];
	$b=db_connect($q);
	$a['id'].'<br />';
	}
}
//text();	
?>
<body>
<style type="text/css">
  html, body {height: 100%; margin: 0px; padding: 0px; text-align: center;}
  .page {min-height: 100%; height: auto !important; height: 100%; background: gray;}
  .wrap {padding-bottom: 122px;}
  .footer {height: 122px; margin-top: -122px; background: #c3c3c3;}
</style>
<div class="page">
  <div class="wrap">
          Я пример контента. Можете вставить в меня много много тегов 
&lt;br&gt; и убедиться, что футер находится всегда внизу</div>
</div>
<div class="footer">Я футер!!!</div>
</body>