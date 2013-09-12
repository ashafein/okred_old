<?php if (!is_xmlrequest): ?>
<?php endif; ?>
<script type="text/javascript">
        $(document).ready(function()
        {
                initIEHover();
        });
        //для IE
</script>

<div class="table-block-container clearit">
        <div class="search">
                <?php
                define('SEARCH_FORM_LOGO_TYPE', 'logo-music');
                define('SEARCH_FORM_URL', 'javascript:loadSearchResults(true)');
                define('SEARCH_FORM_PLACEHOLDER', 'поиск');
                define('SEARCH_FORM_TYPE', 'music');

                include_once '../_php/search_form.php';
                ?>
        </div>
        <div class="table-block">
                <div class="grid small-grid artists">		
                        <ul class="grid-items clearit">
                                <ul><?php for ($i = 0, $l = sizeof($top_artists['artist']); $i < $l; $i++): ?>
                                                <li class="grid-item small-grid-item" onclick="typeTo('.content-wrapper #maxsearch-input', '<?php echo $top_artists['artist'][$i]['name'] ?>', 20, function(){ loadSearchResults(true) });">
                                                        <div class="cover-image" style="background-image: url('<?php echo isset($top_artists['artist'][$i]['image']) ? @$top_artists['artist'][$i]['image'][2]['#text'] : HOST . '/_images/logowithbg.png' ?>');">
                                                                <a href="javascript:;" class="grid-fill-link full-width-overlay"></a>
                                                                <div class="text-over-image text-over-image--block">
                                                                        <div class="text-over-image-text">
                                                                                <a href="javascript:;" class="grid-item-heading-link" >
                                                                                        <h3><p class="grid-item-label"><?php echo $top_artists['artist'][$i]['name'] ?></p></h3>
                                                                                </a>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </li>
                                <?php endfor; ?></ul>
                        </ul>
                        &nbsp;
                </div>
                <div class="playlist">	
                        <?php for ($i = 0, $l = sizeof($top_tracks); $i < $l; $i++): ?>
                                <div class="track" onclick="chooseTrack(this, {'artist': '<?php echo (is_string($top_tracks[$i]['artist']) ? $top_tracks[$i]['artist'] : $top_tracks[$i]['artist']['name']) ?>', 'track': '<?php echo $top_tracks[$i]['title'] ?>', 'data_sd': '<?php echo $top_tracks[$i]['storage_dir']; ?>', 'data_id': '<?php echo $top_tracks[$i]['id']; ?>', 'album_id': '<?php echo $top_tracks[$i]['album_id']; ?>'});">
                                        <div class="info">
                                                <div class="play-btn"></div>
                                                <div class="artist"><?php echo $top_tracks[$i]['artist']; ?></div>
                                                <div class="title">&nbsp;&mdash;&nbsp;<?php echo $top_tracks[$i]['title'] ?></div>
                                                <div class="right-btn add-btn" id="add_track_btn" onclick="chooseMenu(this, event)"></div>
                                        </div>
                                </div>
                        <?php endfor; ?>
                </div>
        </div>
        <?php if (!is_xmlrequest) : ?>
                <div class="table-block сlearit">
                        <div class="tabs">
                                <div id="menu">
                                        <div class="tab selected" id="popular_btn" onclick="chooseMenu(this)">
                                                <div class="info">
                                                        <div class="title">Популярное</div>
                                                </div>
                                        </div>
                                        <div class="tab" id="playlists_btn" onclick="chooseMenu(this)">
                                                <div class="info">
                                                        <div class="title">Мои плейлисты</div>
                                                </div>
                                        </div>
                                        <div class="separator">
                                        </div>
                                        <div class="tab" id="add_song_btn" onclick="chooseMenu(this)">
                                                <div class="info">
                                                        <div class="title">Добавить песню</div>
                                                </div>
                                        </div>
                                </div>
                                <div id="genres">
                                        <div class="separator">
                                        </div>
                                        <?php for ($i = 0, $l = sizeof($genres_on_main); $i < $l; $i++): ?>
                                                <div onclick="chooseGenre(this, <?php echo ($i != 0) ? 'true' : 'false' ?>)" class="tab 
                                                <?php
                                                if (isset($style)) {
                                                        if ($style == strtolower($genres_on_main[$i])) {
                                                                echo 'selected';
                                                        }
                                                } else if ($i == 0) {
                                                        echo 'selected';
                                                }
                                                ?>
                                                     ">
                                                        <div class="info">
                                                                <div class="title">
                                                                        <a href="<?php echo COMPONENT_HOST ?>/client.php?style=<?php echo ($i != 0) ? urlencode($genres_on_main[$i]) : 'all' ?>" onclick="return false;"><?php echo $genres_on_main[$i] ?></a>
                                                                </div>
                                                        </div>
                                                </div>
                                        <?php endfor; ?>
                                </div>
                                <div id="playlists" style="display:none">
                                        <div class="separator">
                                        </div>
                                        <div class="tab" id="create_btn" onclick="chooseMenu(this)">
                                                <div class="info">
                                                        <div class="title">Cоздать плейлист</div>
                                                </div>
                                        </div>
                                        <!--тут будут вкладки плейлистов-->
                                </div>
                        </div>
                </div>
        <?php endif; ?>
</div>
<div class="clearit" style=""></div>

