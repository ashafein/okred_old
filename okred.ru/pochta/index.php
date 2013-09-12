<?php include("../_php/beaver.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php meta_data('META'); ?>
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
		
<?php include('../_php/footer.php'); ?>

<div id="maxzoom-video" style="display: none; overflow: hidden; z-index: 9999;">
<div style="display:inline-block; background:#00C; float:left;"><iframe id="video" width="420" height="315" src="http://www.youtube.com/embed/go5HMP3KtqI" frameborder="0" allowfullscreen></iframe></div>
<div style="width:150px; height:315px; background:#FF0000;display:inline-block; overflow:auto;"><?php SmallPreviewGen($XmlArray); ?></div>
</div>
</body>
</html>
