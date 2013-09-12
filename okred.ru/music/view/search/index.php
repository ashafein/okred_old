 	<?php
 	function escape($str)
 	{
 		return str_replace(array('"', '\'', "'", '&#039;'), '', $str);
 	}
 	?>
 	<?php for ($i = 0, $l = sizeof($tracks); $i < $l; $i++): ?>
 	<?php
 	$tracks[$i]['artist'] = escape(is_string($tracks[$i]['artist'])?$tracks[$i]['artist']:$tracks[$i]['artist']['name']);
 	$tracks[$i]['title'] = escape(($tracks[$i]['title'].(!empty($tracks[$i]['version'])?' ('.$tracks[$i]['version'].')':'')));
 	?>
 	<div class="track" onclick="chooseTrack(this, {'artist': '<?php echo $tracks[$i]['artist'] ?>', 'track': '<?php echo $tracks[$i]['title'] ?>',  <?php if(!empty($tracks[$i]['storage_dir'])):?>  'data_sd': '<?php echo $tracks[$i]['storage_dir']; ?>', 'data_id': '<?php echo $tracks[$i]['id']; ?>', 'album_id': '<?php echo $tracks[$i]['album_id']; ?>'<?php elseif( !empty($tracks[$i]['file']) ): ?>'file': '<?php echo $tracks[$i]['file']; ?>'<?php else: ?>'pid': '<?php echo $tracks[$i]['pid']; ?>' <?php endif; ?> });">
 		<div class="info">
 			<div class="play-btn"></div>
 			<div class="artist" >
 				<?php 
 				echo $tracks[$i]['artist'];
 				?>
 			</div>
 			<div class="title">
 				&nbsp;&mdash;&nbsp;<?php echo $tracks[$i]['title'];?>
 			</div>
 			<div class="right-btn add-btn" id="add_track_btn" onclick="chooseMenu(this, event)">
 			</div>
 		</div>
 	</div>
 <?php endfor; ?>

 <?php if($query_type == 'nothing'): ?>
 <h2>Если ничего не искать то ничего и не найдется.</h2>
 <!--шаблон для js-->
 <div class="track" style="display:none">
 	<div class="info">
 		<div class="play-btn"></div>
 		<div class="artist">
 		</div>
 		<div class="title">
 		</div>
 		<div class="right-btn add-btn" id="add_track_btn" onclick="chooseMenu(this, event)">
 		</div>
 	</div>
 </div>
 <script type="text/javascript">
 page = -1;
 </script>
<?php endif; ?>


<?php if($query_type == 'nothingFound'): ?>
	<h2>Ничего не найдено</h2>
	<!--шаблон для js-->
	<div class="track" style="display:none">
		<div class="info">
			<div class="play-btn"></div>
			<div class="artist">
			</div>
			<div class="title">
			</div>
			<div class="right-btn add-btn" id="add_track_btn" onclick="chooseMenu(this, event)">
			</div>
		</div>
	</div>
	<script type="text/javascript">
	page = -1;
	</script>
<?php endif; ?>

<?php if($endOfPages): ?>
	<script type="text/javascript">
	page = -1;
	</script>
<?php endif; ?>
