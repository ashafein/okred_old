<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
<link href="http://okred.ru/css/reset.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/css/layout.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/css/menu.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/css/jquery.mcustomscrollbar.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/css/tipsy.css" rel="stylesheet" type="text/css" />
<link href="http://okred.ru/source/jquery.fancybox.css?v=2.1.4" rel="stylesheet" type="text/css" media="screen" />

<script src="http://okred.ru/js/jquery-1.8.3.js"></script>
<script src="http://okred.ru/js/jquery-ui.js"></script>
<script src="http://okred.ru/js/jquery.mousewheel.min.js"></script>
<script src="http://okred.ru/js/jquery.mcustomscrollbar.min.js"></script>
<script src="http://okred.ru/js/jquery.cookie.js"></script>
<script src="http://okred.ru/js/jquery.listen.js"></script>
<script src="http://okred.ru/js/ui.draggable.js"></script>
<script src="http://okred.ru/js/search-input.js"></script>
<script src="http://okred.ru/js/tipsy.js"></script>
<script src="http://okred.ru/source/jquery.fancybox.js?v=2.1.4"></script>
<script src="http://okred.ru/js/js.js"></script>
<script language="javascript" type="text/javascript">
	$(".maxexpand-a").fancybox({
				padding: 20,
				openEffect : 'elastic',
				openSpeed  : 300,	
				openOpacity : true,
				closeEffect : 'elastic',
				closeSpeed  : 150,
				closeClick : true,
				helpers : {
					overlay : {
						css : {
							'background' : 'rgba(0,0,0,0.46)'
						}
					}
				}
			});
</script>
</head>
<body>
<?php include('../_php/top-menu.php');?>
<div class="content-wrapper">
<center>
	<div class="table-wrapper">
    	<table class="table-frame">
        	<tbody>
                <tr class="searchbox-holder">
                	<td id="form" class="a" colspan="8">
                    <div id="search_f">
                    	<?php include('../_html/f.html'); ?>
                    </div>
                    </td>
        		</tr>
                <tr class="content-holder">
                	<td class="a">
<p>БЛОК РЕКЛАМЫ</p>
<div style="width:250px; height:450px; border:1px #FF0000 solid">
рекламка google
</div></td>
                    <td class="m20"><div class="td-margin-20"></div></td>
                    <td colspan="5">
					</td>
                    <td class="m20"><div class="td-margin-20"></div></td>
        		</tr>
        	</tbody>
        </table>
    </div>
</center>
</div>

<?php include('../_php/footer.php'); ?>

<div id="maxzoom-video" style="display: none; overflow: hidden; z-index: 9999;">
<div style="display:inline-block; background:#00C; float:left;"><iframe id="video" width="420" height="315" src="http://www.youtube.com/embed/go5HMP3KtqI" frameborder="0" allowfullscreen></iframe></div>
<div style="width:150px; height:315px; background:#FF0000;display:inline-block; overflow:auto;"><?php SmallPreviewGen($XmlArray); ?></div>
</div>
</body>
</html>
