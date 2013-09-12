<?php if( empty($_REQUEST['page']) ): ?>
<script type="text/javascript">
	/*
		$(document).ready(function(){
		$.cookie('style', '<?php echo $tag; ?>');
		$.cookie('genre', '<?php echo $tag; ?>');
        });
	*/
	//работает КРАЙНЕ некорректно
</script>
<div class="table-block-container clearit">
	<?php endif; ?>
	<?php if( empty($_REQUEST['only_info']) ): ?>
	<?php if( empty($_REQUEST['page']) ): ?>
	<script type="text/javascript">
	    $(window).scroll(function()
		{
			if ($(window).scrollTop() >= $(document).height() - $(window).height())
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
					<li class="grid-item big-grid-item g" onclick="getHintInfo({artist: '<?php echo (is_string($tracks[$i]['artist']) ? $tracks[$i]['artist'] : $tracks[$i]['artist']['name']) ?>', track: ' <?php echo $tracks[$i]['name'] ?>'}, 'big');">
						<div class="cover-image" style="background-image: url('<?php echo (isset($tracks[$i]['image']) && !empty($tracks[$i]['image'][2]['#text']))?@$tracks[$i]['image'][2]['#text']:'/_images/logowithbg.png' ?>');">
							<a href="#" class="grid-fill-link full-width-overlay"></a>
							<div class="text-over-image text-over-image--block">
								<div class="text-over-image-text">
									<a href="#" class="grid-item-heading-link">
									<h3>
										<p class="grid-item-label">
											<?php
												$a = (is_string($tracks[$i]['artist']) ? $tracks[$i]['artist'] : $tracks[$i]['artist']['name']);
												echo ( !empty($a) ? $a . ' &mdash; ' : '') . $tracks[$i]['name'];
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
	
	<?php if( empty($page) ): ?>
	<?php if ($query_type == 'tag'): ?>
	<div class="search-tip table-block clearit">
		<div class="content">
			<span class="icon" style="font-size: 66px; font-style: italic; float: right; font-family: 'Lucida';padding: 0 20px 10px 30px;line-height: 44px;">i</span>
			<h5>
				<b>О стиле:</b>
				<?php echo removeTrash($tag_info['tag']['wiki']['content']) ?>
			</h5>
		</div>
	</div>
	
	<?php elseif ($query_type == 'artist'): ?>
	<div class="search-tip table-block clearit">
		<div class="grid grid-item clearit">
			<div class="cover-image" style="background-image: url('<?php echo $artist_info['artist']['image'][4]['#text'] ?>');">
				<div class="text-over-image text-over-image--block">
					<div class="text-over-image-text">
						<a class="grid-item-heading-link">
						<h3>
							<p class="grid-item-label">
								<?php echo $artist_info['artist']['name'] ?>
							</p>
						</h3>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			<h5>
				<?php echo removeTrash($artist_info['artist']['bio']['content']) ?>
			</h5>
		</div>
	</div>
	
	<?php elseif(empty($query_type) || $query_type == 'track'): ?>
	<div class="search-tip table-block clearit">
		<div class="grid grid-item clearit">
			<div class="cover-image" style="background-image: url('<?php echo $img ?>');">
				<div class="text-over-image text-over-image--block">
					<div class="text-over-image-text">
						<a class="grid-item-heading-link">
						<h3 title="<?php
							$a = empty($track_info['track']['artist']['name']) ? $artist : $track_info['track']['artist']['name'];
							$a = ( !empty($a) ? $a . ' &mdash; ' : '');
							echo  $a . $track;
							?>">
							<p class="grid-item-label">
								<?php echo $a . $track ?>
							</p>
						</h3>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="content" <?php if(empty($track_info['track']['album']['title']) && !isset($track_info['track']['toptags']['tag']) ) echo 'style="display: none"' ?>>
			<h5>
				<?php
					if( !empty($track_info['track']['album']['title']) )
					echo '<b>Альбом: </b>'.$track_info['track']['album']['title'].'<br/>';
					echo $wiki;
					if( isset($track_info['track']['toptags']['tag']) && is_array($track_info['track']['toptags']['tag']) ) {
						echo '<br/>Стили: ';
						for( $i = 0, $l = min(5, sizeof($track_info['track']['toptags']['tag'])); $i < $l; $i++ ) {
							if( isset($track_info['track']['toptags']['tag']['name']) ) {
								echo $track_info['track']['toptags']['tag']['name'];
								break;
								} else {
								echo $track_info['track']['toptags']['tag'][$i]['name'];
							}
							if( $i < $l - 1)
							echo ', ';
						}
					}
				?>
			</h5>
		</div>
	</div>
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