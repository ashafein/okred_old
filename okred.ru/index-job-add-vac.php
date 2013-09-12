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

            <h1>Добавление вакансии</h1>
            <form action="/">
            <table class="inputsset addsmthleft">
                <tbody>
                <tr>
                    <td width="40%">
                        <label for="z1">Сфера деятельности и должность:</label>
                    </td>
                    <td width="60%">
                        <input class="input-with-button" id="z1" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="#select-doljnost">Выбрать</a>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z2">Должные обязанности:</label>
                    </td>
                    <td width="60%">
                        <textarea id="z2" rows="20" cols="60"></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z3">Место работы:</label>
                    </td>
                    <td width="60%">
                        <select id="z3">
                            <option>на территории работодателя</option>
                            <option>дома</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z4">Город:</label>
                    </td>
                    <td width="60%">
                        <input class="input-with-button" id="z4" type="text" disabled="disabled" /><a class="form-button-inner maxexpand-a" href="" >Выбрать</a>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z5">Улица:</label>
                    </td>
                    <td width="60%">
                        <input id="z5" type="text" />
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z6">Иногородние соискатели:</label>
                    </td>
                    <td width="60%">
                        <select id="z6">
                            <option>рассматриваются</option>
                            <option>не рассматриваются</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z7-1">Заработная</label><label for="z7-2"> плата</label><label for="z7-3">:</label>
                    </td>
                    <td width="60%">
                       от&nbsp;<input class="input-double" id="z7-1" type="text" />&nbsp;&nbsp;до&nbsp;<input class="input-double" id="z7-2" type="text" />&nbsp;рублей
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z8">Занятость:</label>
                    </td>
                    <td width="60%">
                        <select id="z8">
                            <option>полная</option>
                            <option>частичная</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z9-1">График</label><label for="z9-2">:</label>
                    </td>
                    <td width="60%">
                        с&nbsp;<input class="input-double" id="z9-1" type="text" />&nbsp;&nbsp;до&nbsp;<input class="input-double" id="z9-2" type="text" />&nbsp;&nbsp;&nbsp;часов
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z10">Условия труда:</label>
                    </td>
                    <td width="60%">
                        <textarea id="z10" rows="20" cols="60"></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z11">Опыт работы:</label>
                    </td>
                    <td width="60%">
                        <select id="z11">
                            <option>1-3 года</option>
                            <option>более 3 лет</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z12-1">Возраст</label><label for="z12-2">:</label>
                    </td>
                    <td width="60%">
                        от&nbsp;<input class="input-double" id="z12-1" type="text" />&nbsp;&nbsp;до&nbsp;<input class="input-double" id="z12-2" type="text" />&nbsp;&nbsp;&nbsp;лет
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z13">Пол:</label>
                    </td>
                    <td width="60%">
                        <select id="z13">
                            <option>мужской</option>
                            <option>женский</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z14">Образование:</label>
                    </td>
                    <td width="60%">
                        <select id="z14">
                            <option>среднее</option>
                            <option>высшее</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z15">Иностранный язык:</label>
                    </td>
                    <td width="60%">
                        <input class="input-with-button" id="z15" type="text" disabled="disabled" /><a class="form-button-inner  maxexpand-a" href="#inostranniy-yazik" >Выбрать</a>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        Водительские права:
                    </td>
                    <td width="60%">
                        <input id="z16-1" type="checkbox" />&nbsp;<label for="z16-1">A</label>
                        <input id="z16-2" type="checkbox" />&nbsp;<label for="z16-2">B</label>
                        <input id="z16-3" type="checkbox" />&nbsp;<label for="z16-3">C</label>
                        <input id="z16-4" type="checkbox" />&nbsp;<label for="z16-4">D</label>
                        <input id="z16-5" type="checkbox" />&nbsp;<label for="z16-5">E</label>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        Деятельность организации:
                    </td>
                    <td width="60%">
                        <p class="fieldset-info">Мы производим стеклянные осколки, битый кирпич, мусор, ветош. В производстве задействованы самые последние технологии.</p>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z17">Веб-сайт:</label>
                    </td>
                    <td width="60%">
                        <input id="z17" type="text" />
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z18">Контактное лицо:</label>
                    </td>
                    <td width="60%">
                        <select id="z18">
                            <option>Лицо 1</option>
                            <option>Лицо 2</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        Телефон:
                    </td>
                    <td width="60%">
                        <p class="fieldset-info">+7(495) 123-45-67</p>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        E-mail:
                    </td>
                    <td width="60%">
                        <p class="fieldset-info">spiderman2007@mail.ru</p>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        Другие контакты:
                    </td>
                    <td width="60%">
                        <p class="fieldset-info">Деревня Болотово, спросить Михалыча</p>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z19">Время действия вакансии:</label>
                    </td>
                    <td width="60%">
                        <select id="z19">
                            <option>1 месяц</option>
                            <option>3 месяца</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z20">Особые требования:</label>
                    </td>
                    <td width="60%">
                        <textarea id="z20" rows="20" cols="60"></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <label for="z21">Доступ к вакансии:</label>
                    </td>
                    <td width="60%">
                        <select id="z21">
                            <option>открыт</option>
                            <option>закрыт</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" width="100%" align="right">
                        <a class="common-button savebutton" href="" >сохранить</a>
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

<div id="select-doljnost">
    <h2>Выберите сферу деятельности и должность</h2>
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
