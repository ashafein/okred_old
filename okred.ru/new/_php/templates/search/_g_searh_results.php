<div style="clear: both;margin:20px;"></div><br><br>
<style>
.result_row{
    text-align: left;
    margin-bottom: 25px;
}
.result_row a.mainlink{
    color: #0000CC;
    font-weight: normal;
    font-size: 16px;
}
.result_row a.mainlink:hover{
    color: #FF0000;
}
.result_row a.mainlink:visited{
    color: #800080;
}
.result_row a.final_link{
    color: #006600;
    font-size: 12.8px;
    text-decoration: none;
}
.result_row a.final_link:hover{
    text-decoration: underline;
}

.result_row div{
    margin: 5px 0;
    color: #000;
    font-size: 12.8px;
    width: 50%;
}
</style>
<?php
foreach($data as $d)
    $this->renderPartial('_g_result_string', array('d'=>$d));
?>