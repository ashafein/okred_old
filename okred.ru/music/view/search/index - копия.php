<?php if( empty($_REQUEST['page']) ): ?>
<script type="text/javascript">
	/*
        $(document).ready(function(){
		$.cookie('style', '<?php echo $tag; ?>');
		$.cookie('genre', '<?php echo $tag; ?>');
        });
	*/
	//работает КРАЙНЕ некорректно
	// на оно нихуя не работает
</script>
<div class="table-block-container clearit">
	<?php endif; ?>
	<?php if( empty($_REQUEST['only_info']) ): ?>
	<?php if( empty($_REQUEST['page']) ): ?>
	<script type="text/javascript">
	    $(window).scroll(function()
		{
			if ($(window).scrollTop() >= $(document).height() - ($(window).height() * 1.2) )
			{
				loadSearchResults();
			}
		});//определяет, долистал ли пользователь до конца страницы
	</script>
	<div class="table-block clearit">
		<div class="grid big-grid">
			<ul class="grid-items clearit">
				<ul>
					<?php endif; ?>
					<?php for ($i = 0, $l = sizeof($tracks); $i < $l; $i++): ?>
					<li class="grid-item big-grid-item g" onclick="window.parent.player.set({artist: '<?php echo (is_string($tracks[$i]['artist']) ? $tracks[$i]['artist'] : $tracks[$i]['artist']['name']) ?>', track: '<?php echo $tracks[$i]['title'] ?>', data_sd: '<?php echo $tracks[$i]['storage_dir']; ?>', data_id: '<?php echo $tracks[$i]['id']; ?>', album_id: '<?php echo $tracks[$i]['album_id']; ?>' }, 'big');">
						<div class="cover-image" style="background-image: url('<?php echo (@strlen($tracks[$i]['cover']) > 36)?str_replace('30x30', '150x150', $tracks[$i]['cover']):'/_images/logowithbg.png' ?>');">
							<a href="javascript:" class="grid-fill-link full-width-overlay"></a>
							<div class="text-over-image text-over-image--block">
								<div class="text-over-image-text">
									<a href="javascript:" class="grid-item-heading-link">
									<h3>
									    <p class="grid-item-label">
											<?php
												$a = (is_string($tracks[$i]['artist']) ? $tracks[$i]['artist'] : $tracks[$i]['artist']['name']);
												echo ( !empty($a) ? $a . ' &mdash; ' : '') . $tracks[$i]['title'];
												echo ( !empty($tracks[$i]['version']) ? ' ('.$tracks[$i]['version'].')' : '' );
											?>
										</p>
									</h3>
									</a>
								</div>
							</div>
						</div>
					</li>
					<?php endfor; ?>
					<?php if( empty($_REQUEST['page']) ): ?>
				</ul>
			</ul>
		</div>
	</div>
	<?php endif;
	endif; ?>
	
	<?php if($query_type == 'nothing'): ?>
	<h1>Если ничего не искать то ничего и не найдется.</h1>
	<?php endif; ?>
	
	
	<?php if($query_type == 'nothingFound'): ?>
	<div class="table-block clearit" style="width: 100%; height: 100%;">
		<div style="margin-top: -40px">
			<?php
				include_once '../_php/styles_selector.php'; 
			?>
		</div>
		<h2>Ничего не найдено</h2>
	</div>
	<?php endif; ?>
<?php if( empty($_REQUEST['page']) ): ?></div><?php endif; ?>

<?php
	/**
		вызов функции если последняя страница результатов
	*/
if($endOfPages): ?>
<script type="text/javascript">
	page = -1;
</script>
<?php endif; ?>

<!-- <?php echo $artist . ' : ' . $track . ' - ' . $query_type; ?> -->				