<style>
div.yandex_nav{
    text-align: left;
}
ul.pager{
    color: #1A3DC1;
}

.yandex_nav *{
    margin-left:0;
    padding-left:0;
}

.yandex_nav li{
    display: inline;
}

.yandex_nav ul li *{
    margin-left: 5px;
    width: 25px;
    padding: .15em .3em;
}

.current_page{
    font-weight: 400;
    cursor: default;
    text-decoration: none;
    color: #000!important;
    background: #e8e9ec;
}

.yandex_nav a{
    color: #00c;
}

.yandex_nav a:hover{
    color: #f00;
}

span.pages{
    font: .8em Arial,Helvetica,sans-serif;
    color: #000;
    font-size: 130%;
}

.yandex_nav_pages{
    font: .8em Arial,Helvetica,sans-serif;
    color: #000;
    font-weight: bold;
    font-size: 130%;
}
</style>
<?php
//$pageDocs = 10;
//$page = 15 //Номер страницы
//$resultsCount = 134207
//$totalPages //Общее количество страниц
$buttonsCount = 8;//Количество отображаемых номеров страниц


if($page <= 0)
    $page = 1;
elseif($page >= $totalPages)
    $page = $totalPages;

$center = floor($pageDocs / 2);//Средняя кнопка = 5

$diff = $page - $center;//разность = 10

$firstButtonNo = 1;//$diff < 1 ? 1 : $diff;

$leftNavPageNo = $page - $buttonsCount < 1 ? 1 :  $page - $buttonsCount;
$rightNavPageNo = $page + $buttonsCount > $totalPages ? $totalPages : $page + $buttonsCount;

$navLeft = '<ul class="pager">'. ($firstButtonNo == 1 ? '' : '<li><a href="'. $leftNavPageNo .'">...</a></li>');
$navRight = ($firstButtonNo + $buttonsCount > $totalPages ? '' : '<li><a href="'. $rightNavPageNo .'">...</a></li>') .'</ul>';

$buttons = array();

$nextPage = $page + 1 >= $totalPages ? '<span class="current_page">следующая</span>' : '<a href="'. ($page + 1) .'">следующая</a>';
$prevPage = $page - 1 < 1 ? '<span class="current_page">предыдущая</span>' : '<a href="'. ($page - 1) .'">предыдущая</a>';

for($i = $firstButtonNo; $i <= ($firstButtonNo + $buttonsCount - 1); $i++)
{
    if($i > $totalPages)
        break;
    
    $buttons[] = '<li>'. ($i == $page ? '<span class="current_page">'. $i .'</span>' : '<a href="'. $i .'">'. $i .'</a>') .'</li>';
}
?>
<div class="yandex_nav">
<ul>
    <li class="yandex_nav_pages">Страницы</li>
    <li><?php echo $prevPage; ?></li>
    <li><?php echo $nextPage; ?></li>
    <li></li>
</ul>
<?php echo $pager = $navLeft . implode('', $buttons) . $navRight; ?>
</div>