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

           <h1>Расширенный поиск</h1>
            <form action="/">
            <table class="inputsset addsmthleft width700">
                <tbody>
                <tr>
                    <td width="40%">
                        <label for="z0">Название вакансии:</label>
                    </td>
                    <td width="60%" align="right">
                        <input id="z0" type="text" />
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z1">Профессиональная область:</label>
                    </td>
                    <td width="60%" align="right">
                        <input class="input-with-button" id="z1" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="#select-gorod">Выбрать</a>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z2">Регион:</label>
                    </td>
                    <td width="60%" align="right">
                        <input class="input-with-button" id="z2" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="#select-gorod">Выбрать</a>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z3-1">Уровень </label><label for="z3-2">заработной платы</label>:
                    </td>
                    <td width="60%" align="right">
                        от&nbsp;<input class="input-double" id="z3-1" type="text" />&nbsp;&nbsp;до&nbsp;<input class="input-double" id="z3-2" type="text" />&nbsp;рублей<br /><br />
                        <input class="zcheckbox" id="z3-3" type="checkbox" /><label for="z3-3">не показывать «по договоренности»</label>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z4">Требуемый опыт работы:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z4">
                            <option>не имеет значения</option>
                            <option>от 1 года до 3 лет</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%" valign="top">
                        Тип занятости:
                    </td>
                    <td width="60%" align="left">
                        <div class="alignleft-set">
                            <div><input class="zcheckbox" id="z5-1" type="checkbox" /><label for="z5-1">Полная занятость</label></div>
                            <div><input class="zcheckbox" id="z5-2" type="checkbox" /><label for="z5-2">Частичная занятость</label></div>
                            <div><input class="zcheckbox" id="z5-3" type="checkbox" /><label for="z5-3">Проектная / Временная работа</label></div>
                            <div><input class="zcheckbox" id="z5-4" type="checkbox" /><label for="z5-4">Волонтерство</label></div>
                            <div><input class="zcheckbox" id="z5-5" type="checkbox" /><label for="z5-5">Стажировка</label></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="40%" valign="top">
                        График работы:
                    </td>
                    <td width="60%" align="left">
                        <div class="alignleft-set">
                            <div><input class="zcheckbox" id="z6-1" type="checkbox" /><label for="z6-1">Полный день</label></div>
                            <div><input class="zcheckbox" id="z6-2" type="checkbox" /><label for="z6-2">Сменный график</label></div>
                            <div><input class="zcheckbox" id="z6-3" type="checkbox" /><label for="z6-3">Гибкий график</label></div>
                            <div><input class="zcheckbox" id="z6-4" type="checkbox" /><label for="z6-4">Удаленная работа</label></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z7">Опубликовано за:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z7">
                            <option>24 часа</option>
                            <option>3 дня</option>
                            <option>неделю</option>
                            <option>все время</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z8">Ваш возраст:</label>
                    </td>
                    <td width="60%" align="right">
                        <input id="z8" type="text" />
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z9">Пол:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z9">
                            <option>не имеет значения</option>
                            <option>мужской</option>
                            <option>женский</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z9">Образование:</label>
                    </td>
                    <td width="60%" align="right">
                        <select id="z9">
                            <option>не имеет значения</option>
                            <option>среднее</option>
                            <option>высшее</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%" valign="top">
                        Водительские права категории:
                    </td>
                    <td width="60%" align="left">
                        <div class="alignleft-set">
                            <input class="zcheckbox" id="z6-1" type="checkbox" /><label for="z6-1">A</label>&nbsp;&nbsp;&nbsp;
                            <input class="zcheckbox" id="z6-2" type="checkbox" /><label for="z6-2">B</label>&nbsp;&nbsp;&nbsp;
                            <input class="zcheckbox" id="z6-3" type="checkbox" /><label for="z6-3">C</label>&nbsp;&nbsp;&nbsp;
                            <input class="zcheckbox" id="z6-4" type="checkbox" /><label for="z6-4">D</label>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
                <table class="inputsset addsmthleft width700">
                    <tbody>
                    <tr>
                        <td colspan="2" width="100%" align="right">
                            <a class="common-button">очистить форму</a><a class="common-button">найти</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
<?php include('_php/footer.php'); ?>
</body>
</html>
