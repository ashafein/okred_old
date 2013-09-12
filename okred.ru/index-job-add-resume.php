<?php include("_php/beaver.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php meta_data('META'); ?>
<link href="/_css/job.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('_php/top-menu.php');?>

<table class="table-frame-nm">
    <tbody>
    <tr>
        <td align="center" valign="top" class="paddingright">
            <a href="/" class="job-top-banner"><img src="_images/job/banner-top.jpg" alt="" /></a>
            <?php include('_php/form_search.php'); ?>
        </td>
        <td class="right200" valign="top">
            <div class="job-rabotodatelyam">
                <h2>Работодателям:</h2>
                <ul>
                    <li><a id="job-rabotodatelyam1" href="#">Разместить вакансию</a></li>
                    <li><a id="job-rabotodatelyam2" href="#">Стоимость услуг</a></li>
                </ul>
            </div>
            <a class="add-resume"></a>
        </td>
    </tr>
    </tbody>
</table>
<table class="table-frame">
    <tbody>
    <tr>
        <td align="left" valign="top" class="paddingright">

            <div class="steps">
                <a id="add-resume-step3" class="common-button">Шаг 3</a>
                <a id="add-resume-step2" class="common-button">Шаг 2</a>
                <a id="add-resume-step1" class="common-button step-active">Шаг 1</a>
                <h1 id="add-resume-form-top">Добавление резюме</h1>
            </div>

            <form action="/">
            <div id="add-resume-step1-panel">
                <h3 class="lightred">Общие данные</h3>
                <table class="inputsset addsmthleft width700">
                <tbody>
                <tr>
                    <td width="40%">
                        <label for="z1">Фамилия, имя и отчество:</label>
                    </td>
                    <td width="60%" align="right">
                        <input id="z1" type="text" />
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z2">Пол:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z2">
                            <option>мужской</option>
                            <option>женский</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z3-1">Дата рождения:</label><label for="z3-2"></label><label for="z3-3"></label>
                    </td>
                    <td width="60%" align="right">
                        <select class="select-bdate" id="z3-1">
                            <option>1</option>
                            <option>2</option>
                        </select>
                        <select class="select-bdate" id="z3-2">
                            <option>май</option>
                            <option>июнь</option>
                        </select>
                        <select class="select-bdate" id="z3-2">
                            <option>1985</option>
                            <option>1986</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z4">Город:</label>
                    </td>
                    <td width="60%" align="right">
                        <input class="input-with-button" id="z4" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="#select-gorod">Выбрать</a>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z5">Разрешение на работу:</label>
                    </td>
                    <td width="60%" align="right">
                        <input id="z5" type="text" />
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z6">Переезд:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z6">
                            <option>возможен</option>
                            <option>невозможен</option>
                            <option>желатен</option>
                            <option>нежелатен</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z7">Командировки:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z7">
                            <option>возможны</option>
                            <option>невозможны</option>
                            <option>желательны</option>
                            <option>нежелатльны</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        Водительские права:
                    </td>
                    <td width="60%" align="right">
                        <input id="z8-1" type="checkbox" />&nbsp;<label for="z8-1">A</label>
                        <input id="z8-2" type="checkbox" />&nbsp;<label for="z8-2">B</label>
                        <input id="z8-3" type="checkbox" />&nbsp;<label for="z8-3">C</label>
                        <input id="z8-4" type="checkbox" />&nbsp;<label for="z8-4">D</label>
                        <input id="z8-5" type="checkbox" />&nbsp;<label for="z8-5">E</label>
                    </td>
                </tr>
                </tbody>
            </table>
                <h3 class="lightred">Желаемая должность и зарплата</h3>
                <table class="inputsset addsmthleft width700">
                    <tbody>
                    <tr>
                        <td width="40%">
                            <label for="z9">Профобласть и профессия:</label>
                        </td>
                        <td width="60%" align="right">
                            <input class="input-with-button" id="z9" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="#select-gorod">Выбрать</a>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%">
                            <label for="z10">Желаемая зарплата:</label>
                        </td>
                        <td width="60%" align="right">
                            <input id="z10" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td width="40%">
                            <label for="z11">Занятость:</label>
                        </td>
                        <td width="60%" align="right">
                            <select id="z11">
                                <option>полная</option>
                                <option>частичная</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="40%">
                            <label for="z12">График:</label>
                        </td>
                        <td width="60%" align="right">
                            <input id="z12" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" width="100%" align="right">
                            <a id="add-resume-step2b" class="common-button savebutton" >сохранить и перейти к следующему шагу</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div id="add-resume-step2-panel">
                    <h3 class="lightred">Образование</h3>
                    <div id="obrazovanie">
                    <table class="inputsset addsmthleft width700">
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="z13">Уровень образования:</label>
                            </td>
                            <td width="60%" align="right">
                                <select id="z13">
                                    <option>высшее</option>
                                    <option>среднее</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">
                                <label for="z14">Учебное заведение:</label>
                            </td>
                            <td width="60%" align="right">
                                <input id="z14" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">
                                <label for="z15">Факультет:</label>
                            </td>
                            <td width="60%" align="right">
                                <input id="z15" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">
                                <label for="z16">Специальность:</label>
                            </td>
                            <td width="60%" align="right">
                                <input id="z16" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">
                                <label for="z17">Год окончания:</label>
                            </td>
                            <td width="60%" align="right">
                                <select id="z17">
                                    <option>2007</option>
                                    <option>2006</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">

                            </td>
                            <td width="60%" align="right">
                                <a class="form-button">Добавить еще образование</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <h3 class="lightred">Владение языками</h3>
                    <div id="vladenie-yazikami">
                        <table class="inputsset addsmthleft width700">
                            <tbody>
                            <tr>
                                <td width="40%">
                                    <label for="z18">Язык:</label>
                                </td>
                                <td width="60%" align="right">
                                    <select id="z18">
                                        <option>английский</option>
                                        <option>немецкий</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z19">Уровень владения:</label>
                                </td>
                                <td width="60%" align="right">
                                    <select id="z19">
                                        <option>очень хорошо</option>
                                        <option>хорошо</option>
                                        <option>средне</option>
                                        <option>плохо</option>
                                        <option>перевожу со словарем</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">

                                </td>
                                <td width="60%" align="right">
                                    <a class="form-button">Добавить еще язык</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="lightred">Опыт работы</h3>
                    <div id="opit-raboty">
                        <table class="inputsset addsmthleft width700">
                            <tbody>
                            <tr>
                                <td width="40%">
                                    <label for="z20">Организация:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input id="z20" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z21">Сфера деятельности:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-with-button" id="z21" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="#select-gorod">Выбрать</a>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z22-1">Дата начала работы:</label><label for="z22-2"></label>
                                </td>
                                <td width="60%" align="right">
                                    <select class="select-j1date" id="z22-1">
                                        <option>май</option>
                                        <option>июнь</option>
                                    </select>
                                    <select class="select-j2date" id="z22-2">
                                        <option>2007</option>
                                        <option>2006</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td width="40%">
                                    <label for="z23-1">Дата окончания работы:</label><label for="z23-2"></label>
                                </td>
                                <td width="60%" align="right">
                                    <select class="select-j1date" id="z23-1">
                                        <option></option>
                                        <option>июнь</option>
                                    </select>
                                    <select class="select-j2date" id="z23-2">
                                        <option>по настоящее время</option>
                                        <option>2006</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z24">Занимаемая должность:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input id="z24" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z25">Исполняемые обязанности:</label>
                                </td>
                                <td width="60%" align="right">
                                    <textarea id="z25" rows="20" cols="60"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">

                                </td>
                                <td width="60%" align="right">
                                    <a class="form-button">Добавить еще опыт работы</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="inputsset addsmthleft width700">
                        <tbody>
                        <tr>
                            <td colspan="2" width="100%" align="right">
                                <a id="add-resume-step1b" class="common-button savebutton">назад</a><a id="add-resume-step3b" class="common-button savebutton">сохранить и перейти к следующему шагу</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            </div>

            <div id="add-resume-step3-panel">
                    <h3 class="lightred">Контактные данные</h3>
                    <table class="inputsset addsmthleft width700">
                            <tbody>
                            <tr>
                                <td width="40%">
                                    <label for="z26">Мобильный телефон:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-phone" id="z26" type="text" /><input class="zcheckbox" id="z27" type="checkbox" /><label for="z27">предпочтительно</label>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z28-1">Предпочтительное время связи:</label><label for="z28-2"></label>
                                </td>
                                <td width="60%" align="right">
                                    c&nbsp;<select class="select-h1date" id="z28-1">
                                        <option>09-00</option>
                                        <option>09-30</option>
                                    </select>&nbsp;&nbsp;до&nbsp;<select class="select-h2date" id="z28-2">
                                        <option>22-00</option>
                                        <option>22-30</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z29">Домашний телефон:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-phone" id="z29" type="text" /><input class="zcheckbox" id="z30" type="checkbox" /><label for="z30">предпочтительно</label>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z31-1">Предпочтительное время связи:</label><label for="z31-2"></label>
                                </td>
                                <td width="60%" align="right">
                                    c&nbsp;<select class="select-h1date" id="z31-1">
                                        <option>09-00</option>
                                        <option>09-30</option>
                                    </select>&nbsp;&nbsp;до&nbsp;<select class="select-h2date" id="z31-2">
                                        <option>22-00</option>
                                        <option>22-30</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z32">Электронная почта*:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-phone" id="z32" type="text" /><input class="zcheckbox" id="z33" type="checkbox" /><label for="z33">предпочтительно</label>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z34">ICQ:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-phone" id="z34" type="text" /><input class="zcheckbox" id="z35" type="checkbox" /><label for="z35">предпочтительно</label>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z36">Skype:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-phone" id="z36" type="text" /><input class="zcheckbox" id="z37" type="checkbox" /><label for="z37">предпочтительно</label>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z36-1">Другое:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input class="input-phone" id="z36-1" type="text" /><input class="zcheckbox" id="z37-1" type="checkbox" /><label for="z37-1">предпочтительно</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    <h3 class="lightred">Рекомендация с предыдущего места работы</h3>
                    <div id="rekomendatsii">
                        <table class="inputsset addsmthleft width700">
                            <tbody>
                            <tr>
                                <td width="40%">
                                    <label for="z38">ФИО рекомендодателя:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input id="z38" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z39">Должность рекомендодателя:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input id="z39" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z40">Контактные данные рекомендодателя:</label>
                                </td>
                                <td width="60%" align="right">
                                    <input id="z40" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">

                                </td>
                                <td width="60%" align="right">
                                    <a>Добавить еще рекомендодателя</a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <h3 class="lightred">О себе</h3>
                    <table class="inputsset addsmthleft width700">
                            <tbody>
                            <tr>
                                <td width="40%">
                                    <label for="z41">Ключевые навыки:</label>
                                </td>
                                <td width="60%" align="right">
                                    <textarea id="z41" rows="20" cols="60"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <label for="z42">Свободно о себе:</label>
                                </td>
                                <td width="60%" align="right">
                                    <textarea id="z42" rows="20" cols="60"></textarea>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    <table class="inputsset addsmthleft width700">
                        <tbody>
                        <tr>
                            <td colspan="2" width="100%" align="right">
                                <a id="add-resume-step22b" class="common-button savebutton">назад</a><a class="common-button savebutton">сохранить и опубликовать</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

             </div>
            </form>



        </td>
        <td class="right200" valign="top">
            <div class="advanced-search">

            </div>
            <a class="job-right-banner"></a>
        </td>
    </tr>

    </tbody>
</table>


<div id="select-gorod">
    <h2>Выберите область и город</h2>
    <table class="select-doljnost-table">
        <tbody>
        <tr>
            <td>
                <div class="tbl-a">
                    <div class="tbl-f-overlay"></div>
                    <div class="tbl-f">
                        <a>Груши<span class="tbl-arrow"></span></a>
                        <a>Арбузы<span class="tbl-arrow"></span></a>
                        <a class="selected">Бананы<span class="tbl-arrow"></span></a>
                        <a>Яблоки<span class="tbl-arrow"></span></a>
                        <a>Ананасы<span class="tbl-arrow"></span></a>
                        <a>Лимоны<span class="tbl-arrow"></span></a>
                        <a>Груши<span class="tbl-arrow"></span></a>
                        <a>Арбузы<span class="tbl-arrow"></span></a>
                        <a>Бананы<span class="tbl-arrow"></span></a>
                        <a>Яблоки<span class="tbl-arrow"></span></a>
                        <a>Ананасы<span class="tbl-arrow"></span></a>
                        <a>Лимоны<span class="tbl-arrow"></span></a>
                        <a>Груши<span class="tbl-arrow"></span></a>
                        <a>Арбузы<span class="tbl-arrow"></span></a>
                        <a>Бананы<span class="tbl-arrow"></span></a>
                        <a>Яблоки<span class="tbl-arrow"></span></a>
                        <a>Ананасы<span class="tbl-arrow"></span></a>
                        <a>Лимоны<span class="tbl-arrow"></span></a>
                        <a>Груши<span class="tbl-arrow"></span></a>
                        <a>Арбузы<span class="tbl-arrow"></span></a>
                        <a>Бананы<span class="tbl-arrow"></span></a>
                        <a>Яблоки<span class="tbl-arrow"></span></a>
                        <a>Ананасы<span class="tbl-arrow"></span></a>
                        <a>Лимоны<span class="tbl-arrow"></span></a>
                    </div>
                </div>
            </td>
            <td>
                <div class="tbl-a">
                    <div class="tbl-f-overlay"></div>
                    <div class="tbl-f">
                        <a>Груши<span class="tbl-plus"></span></a>
                        <a>Арбузы<span class="tbl-plus"></span></a>
                        <a>Бананы<span class="tbl-plus"></span></a>
                        <a>Яблоки<span class="tbl-plus"></span></a>
                        <a class="selected">Ананасы<span class="tbl-plus"></span></a>
                        <a>Лимоны<span class="tbl-plus"></span></a>
                    </div>
                </div>
            </td>
            <td>
                <div class="tbl-a">
                    <div class="tbl-f-overlay"></div>
                    <div class="tbl-f tbl-f-last">
                        <a>Лимоны<span class="tbl-minus"></span></a>
                        <a>Бананы<span class="tbl-minus"></span></a>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<?php include('_php/footer.php'); ?>
</body>
</html>
