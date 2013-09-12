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

<!-- Player -->
<link rel="stylesheet" type="text/css" href="style.css">
<script src="parasol/parasol.js"></script>
<script src="parasol/notebook.js"></script>
<script src="jamendo.js"></script>
<script src="player.js"></script>
<script src="ui.js"></script>
<script src="config.js"></script>
</head>
<body onload="load()">
<?php include('../_php/top-menu.php');?>
<?php include("parser.php"); ?>
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
<p>ХРЕНЗНАЕТЧТО</p>
<p>БЛОК РЕКЛАМЫ</p>
<div style="width:250px; height:450px; border:1px #FF0000 solid">
рекламка google
</div>
					</td>
                    <td class="m20"><div class="td-margin-20"></div></td>
                    <td class="b" colspan="3">
<div id="notebook-tabs" prev="playlist" next="albums">
            <div class="input-box">
                <span class="fasthelp">Press ENTER to search on Jamendo. Click on &#9003; to clear the filter</span>
                <input id="filter" type="text" placeholder="Filter | Search..."
                    onkeyup="ui.onFilterKeyUp(event);">
                <a onclick="document.getElementById('filter').value='';albums.filter='';">&#9003;</a>
            </div>
            <a id="tab-favorite" panel="browser"
                onclick="albums.list = lists.favorite;">&#10026;</a>
            <a id="tab-popular"  panel="browser"
                onclick="albums.list = lists.popular;">Популярное</a>
            <a id="tab-latest"  panel="browser"
                onclick="albums.list = lists.latest;">Последнее</a>
            <a id="tab-search"  panel="browser"
                onclick="albums.list = lists.search;">Поиск</a>
            <a id="tab-configure" panel="configure"><span class="fasthelp">Конфигурация плеера</span>&#9881;</a>
        </div>


        <div id="sidebar">
            <div id="track" inheritable>
                <div class="fasthelp">
                    <span inherits="name"></span>&nbsp;
                    <span inherits="artist"></span>
                </div>
                <audio id="player" controls></audio>
            </div>
                <span id="playlist-options">
                  <a onclick="player.clear();">
                    <span class="fasthelp">Очистить плейлист</span>&#10006;</a>
                </span>
            <div id="playlist"
                ondragover="ui.onDragOver(event);"
                ondragleave="ui.onDragLeave(event);"
                ondrop="ui.onDropPlaylist(event);">
            </div>
        </div>

        <div id="notebook">
            <section id="configure" style="display:none">
                <h1>Configure</h1>
                <div>
                    <i>(you need to reload the page for some effects to take change)</i><br>
                    <input id="config-play" type="checkbox"
                        onclick="config('playOgg', this.checked);"> Play as Ogg<br>
                    <input id="config-dl" type="checkbox"
                        onclick="config('dlOgg', this.checked);"> Download as Ogg<br>
                    <br>
                    <input id="config-save-pl" type="checkbox"
                        onclick="config('savePl', this.checked); player.save();"> Save the playlist<br>
                    <br>
                    Jamendo user for starred items <div class="input-box">
                        <span class="fasthelp">Type the username you want to follow starred items</span>
                        <input id="config-staruser" type="text" placeholder="username"
                            onchange="config.setString('starUser', this.value); jamendo.favorite();">
                        <a onclick="$get('config-staruser').value='';">&#9003;</a>
                    </div><br>
                    <br>
                    StatusNet server address (empty for Identi.ca) <div class="input-box">
                        <span class="fasthelp">Left it empty to use Identi.ca</span>
                        <input id="config-statusnet" type="text" placeholder="http://identi.ca"
                            onchange="config.setString('statusNet', this.value || '');">
                        <a onclick="$get('config-statusnet').value=''; $get('config-statusnet').onchange();">&#9003;</a>
                    </div><br>
                    <br>
                    By default, show:
                    <select id="config-defaulttab" onchange="config('defaultTab', this.value)">
                        <option value="tab-favorite">Favorites</option>
                        <option value="tab-popular">Popular</option>
                        <option value="tab-latest">Latest</option>
                    </select>
                </div>
            </section>
            <section id="browser">
                <div id="albums-container" class="scrollable"
                    onscroll="ui.onScrollAlbums(event);">
                    <div id="albums">
                    </div>
                    <span class="fasthelp">Click to show the album. Double click to
                        add it to the playlist</a>
                </div>
                <div id="album" class="scrollable"
                    ondragover="ui.onDragOver(event);"
                    ondragleave="ui.onDragLeave(event);"
                    ondrop="ui.onDropAlbum(event);">
                    <div id="album-header" inheritable>
                        <img src="cover.png" inherits="image=src">
                        <div id="album-cartouche">
                            <a inherits="url=href" target="_blank">
                                <span class="fasthelp">Go on the album's Jamendo page</span>
                                &#10153;
                            </a>
                            <a inherits="download=href">
                                <span class="fasthelp">Download the album</span>
                                &#11015;
                            </a>
                            <a inherits="promote=href" target="_blank">
                                <span class="fasthelp">Promote the artist</span>
                                &#9824;
                              </a>
                              <a inherits="album=album"
                                onclick="player.set(albums.albums[this.getAttribute('album')].tracks);" >
                                <span class="fasthelp">Append to the playlist</span>
                                &#10010;
                            </a>
                            <!-- &#9752; -->
                            <a inherits="share_fb=href" target="_blank">
                                <span class="fasthelp">Share on Facebook</span>
                                f
                            </a>
                            <a inherits="share_sn=href" target="_blank">
                                <span class="fasthelp">Share on Identi.ca or StatusNet</span>
                                s
                            </a>
                            <a inherits="share_tw=href" target="_blank">
                                <span class="fasthelp">Share on Twitter</span>
                                t
                            </a>
                        </div>
                        <div>
                            <h1><a inherits="artist,artist_url=href" target="_blank"></a></h1>
                            <span inherits="name"></span>
                            <div class="info">
                              <a inherits="license,license_url=href" target="_blank"></a>
                            </div>
                        </div>
                    </div>
                    <div id="album-siblings" prev="albums" next="album-tracks"></div>
                    <div id="album-tracks" prev="album-siblings" next="playlist">
                    </div>
                </div>
            </section>
        </div>


        <!-- XBL -->
        <div style="display:none;">
            <div id="albumitem" class="albumitem listitem" draggable="true"
                onclick="ui.onClickAlbum(event);"
                ondblclick="ui.onDblClickAlbum(event);"
                ondragstart="ui.onDragAlbum(event);">
                <img src="cover.png" inherits="image=src">
                <div class="content">
                    <div inherits="artist"></div>
                    <div inherits="name"></div>
                </div>
            </div>

            <span id="albumpreview" class="albumpreview" keepsiblings="true" draggable="true"
                onclick="ui.onClickAlbum(event);"
                ondblclick="ui.onDblClickAlbum(event);"
                ondragstart="ui.onDragAlbum(event);">
                <span class="fasthelp" inherits="name"></span>
                <img src="cover.png" inherits="image=src"><br>
            </span>

            <div id="trackitem" class="trackitem listitem" draggable="true"
                ondragstart="ui.onDragTrack(event);">
                <span class='append' inherits="track=track">&#10010;</span>
                <!-- <span inherits="stream=stream" onclick="player.play(this.stream);">&#9654;</span> -->

                <span inherits="duration"></span>
                <span inherits="name"></span>
            </div>

            <div id="playlistitem" class="playlistitem"
                ondragover="ui.onDragOver(event);"
                ondragleave="ui.onDragLeave(event);">
                <div class="actions">
                    <a onclick="player.remove(this.parentNode.parentNode);">
                        <span class="fasthelp">Remove track from playlist</span>
                        &#10006;
                    </a>
                    <a inherits="album=album"
                        onclick="albums.show(this.getAttribute('album'));">
                        <span class="fasthelp">Show album</span>
                        &#9664;
                    </a>
                    <a inherits="stream=href" target="_blank">
                            <span class="fasthelp">Download the track</span>
                            &#11015;</a>
                </div>
                <div onclick="player.play(this.parentNode);" class="sub listitem">
                    <span inherits="name"></span>
                    <span class="sub">
                        , by <span inherits="artist"></span>
                        in <span inherits="album_name"></span>
                    </span>
                </div>
            </div>
        </div>


</td><td class="m20"><div class="td-margin-20"></div></td>
<td class="d">
<p>ПЛЕЙЛИСТЫ</p>
<div id="playlist">
<div style="float: left;"><p><a href="">Плейлисты</a></p></div><div><p><a href="">Информация</a></p></div>
<div id="list">
<a href="">Аудиозаписи на компьютере</a><br />
<a href="">Аудиозаписи из профиля</a><br />
<a href="">Радиостанции</a>
</div>
<?php echo '<ul>' . charts() . '</ul>'; ?>
</div>
</td><td class="m20"><div class="td-margin-20"></div></td>
        		</tr>
        	</tbody>
        </table>
    </div>
</center>
</div>

<?php include('../_php/footer.php'); ?>
</body>
</html>