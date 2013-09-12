 <?php
                if (isset($_COOKIE['auth_id']) or isset($_SESSION['auth_id'])){ // aut
				echo '<div class="job-rabotodatelyam" style="">';
				$sid = $_COOKIE['auth_id'];
				$resultaut = @mysql_query("SELECT ID,email,fio,pass,status,category FROM $autortable WHERE id=".$sid);
                    while ($myrow=mysql_fetch_array($resultaut)) {
                        $categoryaut=$myrow["category"];
                        $fioaut=$myrow["fio"];
                        if ($fioaut != '')
                            $fioaut = " <b>$fioaut</b>";
                    }
                    if ($categoryaut=='soisk')
                        $categaut='Соискатель';
                    if ($categoryaut=='rab')
                        $categaut='Работодатель';
                    if ($categoryaut=='agency')
                        $categaut='Агентство';
                    if ($categoryaut=='user')
                        $categaut='Пользователь';
                    echo ("<ul style='float: left'>
<li><a href=regchan.php>Регистрационные данные</a><br></li>
");
                    if ($categoryaut == 'soisk' or $categoryaut == 'agency' or $categoryaut == 'user') {
                        echo "<li><a href=orderv.php>Просмотр отобранных вакансий</a></li>";
                        echo "<li><a href=subsv.php>Подписка на новые вакансии</a></li>";
                    }
                    if ($categoryaut == 'rab' or $categoryaut == 'agency' or $categoryaut == 'user') {
                        echo "<li><a href=orderr.php>Просмотр отобранных резюме</a></li>";
                        echo "<li><a href=subsr.php>Подписка на новые резюме</a></li>";
                    }
                    echo "</ul><ul>";
                    if ($categoryaut != 'user'){ //no user
                        if ($categoryaut == 'rab' or $categoryaut == 'agency'){
                            $result = @mysql_query("SELECT aid,status FROM $vactable WHERE aid = '$sid' and status='ok'");
                            $totaltexts1=@mysql_num_rows($result);
                            $result = @mysql_query("SELECT aid,status FROM $vactable WHERE aid = '$sid' and status='wait'");
                            $totalwait1=@mysql_num_rows($result);
                            $totaltextsb = $totaltexts1 + $totalwait1;
                        }
                        if ($categoryaut == 'soisk' or $categoryaut == 'agency'){
                            $result = @mysql_query("SELECT aid,status FROM $restable WHERE aid = '$sid' and status='ok'");
                            $totaltexts2=@mysql_num_rows($result);
                            $result = @mysql_query("SELECT aid,status FROM $restable WHERE aid = '$sid' and status='wait'");
                            $totalwait2=@mysql_num_rows($result);
                            $totaltextss = $totaltexts2 + $totalwait2;
                        }
                    } // no user
                    $resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
                    if (@mysql_num_rows($resultban) != 0){
                        while($myrow=mysql_fetch_array($resultban)){
                            $bunsip=$myrow["bunsip"];
                            $bunwhy=$myrow["why"];
                        }
                        echo "<p align=center><span color=red>Доступ к функциям авторского раздела для вас, к сожалению, закрыт!</span></p><blockquote><p align=justify><b>Причина:</b> $bunwhy</p><br><br>";
                    }elseif (@mysql_num_rows($resultban) == 0){
                        if ($categoryaut != 'user'){ // no user
                            if ($categoryaut == 'rab' or $categoryaut == 'agency')
                                echo ("
<li><a href=mylistv.php>Мои вакансии</a> ($totaltextsb)</li>
<li><a href=addvac.php>Добавить вакансию</a></li>
");
                            if ($categoryaut == 'soisk' or $categoryaut == 'agency')
                                echo ("
<li><a href=mylistr.php>Мои резюме</a> ($totaltextss)</li>
<li><a href=addres.php>Добавить резюме</a></li>
");
                        } // no user
                    }
// сообщения
                    if ($sendmessages == 'TRUE'){
                        if (!isset($_GET['link']) or $_GET['link'] == '0')
                            $linsel='99999999';
                        if (isset($_GET['link']) and $_GET['link'] != '0')
                            $linsel=$_GET['link'];
                        if ($_GET['link'] != '0' and $linsel != '99999999')
                            $result12 = @mysql_query("UPDATE $messagetable set showed='1' WHERE tid = '$sid' and aid = '$linsel' and showed=0");
                        if ($_GET['link']=='0' and $linsel == '99999999')
                            $result12 = @mysql_query("UPDATE $messagetable set showed='1' WHERE tid = '$sid' and aid = '0' and showed=0");
                        $result123 = @mysql_query("SELECT aid,tid,showed FROM $messagetable WHERE tid = '$sid' and showed=0");
                        $totmesnewtop=@mysql_num_rows($result123);
                        if ($totmesnewtop > 0)
                            echo "<li><a href=message.php><b>Сообщения&nbsp;($totmesnewtop)</b></a></li>";
                        if ($totmesnewtop == 0)
                            echo "<li><a href=message.php>Сообщения</a></li>";
                    }// Сообщения
					echo  '</div><!--/login-->';
                } // aut
                ?>