<?php
include('../../_php/beaver.php');
include('../var.php');

function prof_option($prof_area_id){
    global $podcattable;
    $prof_result = db_connect('SELECT id, name FROM '.$podcattable.' WHERE dict_prof_area_id = '.$prof_area_id.' ORDER BY name');
    $func_result = "";
    while($prof_row = @mysql_fetch_assoc($prof_result)){
        $func_result .= '<a id="'.$prof_row['id'].'">'.$prof_row['name'].'<span class="tbl-plus"></span></a>';
    }
    echo $func_result;
}

function city_option($region_id){
    global $citytable;
    $city_result = db_connect('SELECT id, name FROM '.$citytable.' WHERE region_ref = '.$region_id.' AND NOT ISNULL(city_ref) ORDER BY name');
	if(@mysql_num_rows($city_result) < 1)
		$city_result = db_connect('SELECT id, name FROM '.$citytable.' WHERE id = '.$region_id);
    $func_result = "";
    while($city_row = @mysql_fetch_assoc($city_result)){
        $func_result .= '<a id="'.$city_row['id'].'">'.$city_row['name'].'<span class="tbl-plus"></span></a>';
    }
    echo $func_result;
}

//option
if(!empty($_GET['opt']))
    switch($_GET['opt']){
        case 'prof': prof_option($_GET['id']);
        break;
		case 'city': city_option($_GET['id']);
        break;
    }
?>