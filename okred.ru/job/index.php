<?
session_start();
include("top.php");
?>
    <table class="table-frame">
        <tbody>
        <tr>
            <td width="45%" valign="top">
                <div class="job-vac">
                    <h2>Вакансии в Москве</h2>
                </div>
                <ul class="job-vac-list-left">
                    <?php
                    $prof_area_result = @mysql_query('SELECT id, name FROM '.$cattable.' ORDER BY name');
                    $i = 0;
                    $y = round(mysql_num_rows($prof_area_result)/2);
                    while($prof_area_row = @mysql_fetch_assoc($prof_area_result)){
                        echo '<li><a href="/searchr.php?category='.$prof_area_row['id'].'">'.$prof_area_row['name'].'</a></li>';
                        $i++;
                        if($i == $y) echo '</ul><ul class="job-vac-list-right">';
                    }
                    ?>
                </ul>
                <div class="clear"></div>
                <a href="/searchv.php" class="last-link-vac">Расширенный поиск</a>
            </td>
            <td width="25%" valign="top">
                <div class="job-news">
                    <h2>Новости</h2>
                    <?php
                    $news_result = @mysql_query('SELECT idnum, title FROM '.$newstable.' ORDER BY datum');
                    while($news_row = @mysql_fetch_assoc($news_result)){
                        echo '<a href="/news.php?link='.$news_row['idnum'].'">'.$news_row['title'].'</a>';
                    }
                    ?>
                    <div class="clear"></div>
                    <a href="/news.php" class="last-link-news">Все новости</a>
                </div>
            </td>
            <td width="30%" valign="top" class="paddingright">
                <div class="job-best">
                    <h2>Лучшие работодатели</h2>
                    <ul class="job-best-list">
                        <?php
                        $zav_result = @mysql_query('SELECT id, name, comment, foto1 FROM '.$zavtable.' WHERE category="best job" ORDER BY date');
                        while($zav_row = @mysql_fetch_assoc($zav_result)){
                            echo '<li><a href="/zav.php?link='.$zav_row['id'].'"><img src="'.$afishadir.$zav_row['foto1'].'" alt="'.$zav_row['name'].'" /></a></li>';
                        }
                        ?>
                    </ul>
                    <div class="clear"></div>
                    <a href="/zav.php" class="last-link-best">Все работодатели</a>
                </div>
            </td>
            <td class="right200">
            <?php include("_php/user_link.php"); ?>
                <a class="job-right-banner"></a>
            </td>
        </tr>

        <tr>
            <td width="45%">
                <div class="job-sovety">
                    <h2>Советы по поиску работы</h2>
                    <p><img src="/job/_images/job/job-sovety.jpg" alt=""/>Совет прост: обновляйте резюме не реже одного раза в сутки. Создайте несколько резюме, но с разными названиями, скорректируйте содержание своего CV под каждую должность и делайте рассылку на подходящие вакансии – не менее десяти в день. Вот увидите – результат не заставит себя ждать. Простая математика: если из 10 разосланных резюме ответ будет получен на 5 – это очень хорошо.</p>
                    <a href="#" class="last-link">Все советы</a>
                </div>
            </td>
            <td width="65%" colspan="2" class="paddingright">
                <div class="job-issledovaniya">
                    <h2>Исследования</h2>
                    <p><img src="/job/_images/job/job-issledovaniya.jpg" alt=""/>В апреле 2013 г. количество размещенных вакансий на рынке труда Москвы увеличилось на 7% по сравнению с предыдущим месяцем. При этом относительно января 2008 года наблюдался прирост вакансий на 142%. Количество размещенных резюме снизилось по сравнению с предыдущим месяцем на 45%. Отчасти это связано с тем, что в марте была отмечена нетипично высокая соискательская активность. В основном же снижение количества размещенных резюме в апреле является типичной тенденцией на московском рынке труда для каждого года. Рынок входит в стадию традиционного снижения или замедления показателей соискательской.</p>
                    <a href="#" class="last-link">Все исследования</a>
                </div>
            </td>
            <td class="right200"></td>
        </tr>
        </tbody>
    </table>
<?php include("../_php/footer.php"); ?>
</body>
</html>
