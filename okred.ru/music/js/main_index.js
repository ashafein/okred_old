
var ajax_queries = {};//запоминаются ссылки на последние запросы, чтобы их контроллировать
var playlist;//объект-работник с плейлистом на сервере и контейнером плейлиста
var player;//объект-работник над плеером
var actions;//объек-работник, запоминающий последнее действие, для того чтобы ссылкой можно было делится
var current_location;
		
$(document).ready(function()
{			 
        actions = 
        {   
                last: null, 
                /*
					action - название функции
					params -- массив параметров для нее
				*/
                setAction: function(action, params)
                {
                        document.location.href = document.location.href.replace(/#\?(.*?)\/call/g, '');
					
                        if(action != undefined)
                        {
                                params = (params == undefined)?new Array():params;
                                for(var i = 0; i < params.length; i++)
                                {
                                        params[i] = encodeURI(params[i]);
                                }
						
                                document.location.href = document.location.href +  '#?' + action + '/' +  params.join('/') + '/call';
                        }
                        actions.last = actions.getAction();
                },
                getAction: function()
                {
                        if(document.location.href.split('#?').length > 1)
                        {
                                return document.location.href.split('#?')[1].split('/call')[0];
                        }
                        else
                        {
                                return null;
                        }
                },
                parseFromAction: function()
                {
                        if(actions.last != undefined)
                        {
                                var frame = getIframe();
                                var params = actions.last.split('/');
                                var action = params[0]; 
                                var vars = params;
                                vars.shift();
						
                                for(var i = 0; i < vars.length; i++)
                                {
                                        vars[i] = decodeURI(vars[i]);
                                }
						
                                switch(action)
                                {
                                        case 'search':
                                                frame.$('.content-wrapper form #maxsearch-input').attr('value', vars[0]);
                                                frame.$('.content-wrapper form .maxsearch-ok').click();
							
                                                break;
							
                                        case 'playlist':
                                                frame.$('.tabs #playlists_btn').click();		
                                                frame.choosePlaylist($('<div id="' + vars[0] + '"></div>'));
                                                break;
							
                                        case 'genre':
                                                $.cookie('style', vars[0]);
                                                frame.location.reload();
							
                                                break;
                                }
                        }
                }
        };
        actions.last = actions.getAction();
			
        playlist = {
                is_loaded_playlists: false,
                my_playlists: null,
                add_queue: [], //очередь добавлений в плейлисты, дабы не было рассинхронизации
                getPlaylists: function(callback) 
                {
                        if($.cookie('auth') == 1)
                        {
                                $.getJSON(COMPONENT_HOST + '/ajax/playlist/byUser/', function(data)
                                {  
                                        playlist.is_loaded_playlists = true;
                                        if( typeof data == 'object' || typeof data == 'array' )
                                        {
                                                playlist.my_playlists = data;
                                        }
                                        else
                                        {
                                                playlist.my_playlists = null;
                                        }
                                        (callback != undefined)?callback(data):null;
                                })
                        }
                        else
                        {
                                playlist.is_loaded_playlists = true;
                        }
                },
                getPlaylist: function(id, callback) 
                {
                        if(ajax_queries.playlist_get)
                        {
                                ajax_queries.playlist_get.abort();
                        }
					
                        ajax_queries.playlist_get = $.ajax({
                                url: COMPONENT_HOST + '/ajax/playlist/get/', 
                                data: {
                                        id: id
                                }, 
                                dataType: 'json', 
                                success: function(data)

                                { 
                                        (callback != undefined)?callback(data):null;
                                }
                        });
                },
                setPlaylist: function(id, name, tracks, callback)
                {
                        if($.cookie('auth') == 1)
                        {
                                id = (id == undefined)?0:id;
                                id = Number(id);
						
                                var vars = {
                                        id: id, 
                                        name: name, 
                                        tracks: tracks
                                };
                                if(tracks == undefined)
                                {
                                        delete vars.tracks;
                                }
                                else if (typeof tracks == 'array' || typeof tracks == 'object')
                                {
                                        vars.tracks = JSON.stringify(vars.tracks);
                                }
						
                                /*console.log('____________________');
							console.log('sending playlist to', COMPONENT_HOST + '/ajax/playlist/' + ((id == 0)?'create':'set') + '/');
							console.log('object is', tracks);
						console.log('____________________');*/
                                $.post(COMPONENT_HOST + '/ajax/playlist/' + ((id == 0)?'create':'set') + '/', vars, function(data)
                                {
                                        (callback != undefined)?callback(data):null;
                                });
                        }
                        else
                        {
                                (callback != undefined)?callback(null):null;
                        }
                },
                deletePlaylist: function(id, callback)
                {
                        $.ajax({
                                url: COMPONENT_HOST + '/ajax/playlist/delete/', 
                                data: {
                                        id: id
                                }, 
                                dataType: 'json', 
                                success: function(data)

                                {
                                        (callback != undefined)?callback(data):null;
                                }
                        });
                },
                addToPlaylist: function(id, object)
                { 
                        if($.cookie('auth') == 1)
                        {						
                                playlist.add_queue[id] = (playlist.add_queue[id] == undefined)?new Array():playlist.add_queue[id];
                                playlist.add_queue[id].push(object);
						
                                playlist.getPlaylist(id, function(data)
                                {  
                                        data = data[0];
                                        data.tracks = (data.tracks == null || data.tracks == 'null')?new Array():$.makeArray($.parseJSON(data.tracks));
							
                                        /*console.log('-------------------------------------------');
								console.log((data.tracks.length > 0)?'ok':data);
								console.log('queue.length', playlist.add_queue[id].length);
								
							console.log(data.tracks);*/
							
                                        for(var i = 0; i < playlist.add_queue[id].length; i++)
                                        {
                                                data.tracks.push(playlist.add_queue[id][i]);
                                        }
                                        playlist.add_queue[id] = new Array();
							
                                        /*console.log('\n');
								console.log(data.tracks);
							console.log('-------------------------------------------');*/
							
                                        playlist.setPlaylist(id, data.name, data.tracks);
                                });
                        }
                        else
                        {
                                (callback != undefined)?callback(data):null;
                        }
                },
                getContainer: function()
                {
                        return getIframe().$('.content-wrapper .playlist');
                },
                addToContainer: function(data)
                {
                        if(playlist.getContainer().find('p[id=' + playlist.id + ']').length > 0)//проверяем ли, соответсвует ли контейнер содержимому плейлиста
                        {
                                var block = playlist.getContainer().find('.track:eq(0)').clone().appendTo(playlist.getContainer());
						
                                block.css({
                                        display: 'block'
                                });
                                block.attr('onclick', 'chooseTrack(this, ' + JSON.stringify(data) + ');');
                                block.find('.artist').html(data.artist);
                                block.find('.title').html('&nbsp;&mdash;&nbsp;' + data.track);
                                block.find('.info').find('.add-btn,.ok-btn').addClass('delete-btn').removeClass('add-btn').removeClass('ok-btn').attr('id', 'delete_track_btn');
						
                                playlist.getContainer().find('center').remove();
						
                                getIframe().makeUnique(playlist.getContainer().find('.track'));
                        }
                },
                syncContainerData: function()
                {
                        if(playlist.getContainer().find('p[id=' + playlist.id + ']').length > 0)//проверяем ли, соответсвует ли контейнер содержимому плейлиста
                        {
                                var tracks = getIframe().parseTracksParams(false);
                                playlist.setPlaylist(playlist.id, playlist.name, tracks);
                        }
                }
        };
			
        player = {
                current_index: 0, 
                current_playlist: [], 
                is_repeat: false, 
                is_random: false
        };
			
        player.set = startTrack;
        player.stop = stopTrack;
        player.nextTrack = nextTrack;
        player.prevTrack = prevTrack;
			
        function startTrack(info)
        {
                if(info.pid == undefined)//если Я.М
                {
                        $.get(COMPONENT_HOST + '/get_url.php?sd=' + info.data_sd + '&id=' + info.data_id, 
                                function(data)
                                {
                                        trackLoaded(data, info);
                                });
                }
                else //если П.П(а другого не остается)
                {
                        trackLoaded('http://pleer.com/mobile/files/' + info.pid + '.mp3', info);
                }
        }
			
        function stopTrack()
        {
                player.container.fadeOut('fast');
                player.obj.pause();
                updateTrackElement();
        }
			
			
        function trackLoaded(url, info)
        {		
                player.container.fadeIn('normal');
				
                player.obj.pause();
                player.obj.setSrc(url);
                player.obj.play();
				
                player.artist = info.artist;
                player.track = info.track;
                player.data_sd = info.data_sd;
                player.data_id = info.data_id;
                player.album_id = info.album_id;
                player.pid = info.pid;
				
                $('.rating-cancel').click();
                $('.mejs-star').fadeTo(100,  1);
                $('.mejs-artist', player.container).html(player.artist);
                $('.mejs-track', player.container).html(player.track);
				
                $.get(COMPONENT_HOST + '/ajax/vote/get/?trackname=' + player.artist + '-' + player.track, function(data)
                {
                        data = Math.round(parseInt(data));
                        if( data > 0 )
                        {
                                player.rater.rating('select', data-1, false);
                        }
                });
        }                                         
			
        player.container = $('#audio');
        player.element = $('#player').mediaelementplayer(
        {
                startVolume: ($.cookie('volume') != null)?Number($.cookie('volume')):0.7,
                success: audioInit,
                error: audioError,
                audioHeight: 40,
                audioWidth: 214,
                features: ['playpause','progress','current','tracks','volume' ],
                enableKeyboard: true
        });   
			
			
        function audioViewBuild()
        {				
                track_info = $('<div class="mejs-track-info"><div class="mejs-track">[ничего]</div><div class="mejs-artist">[не играет]</div></div>').appendTo('.mejs-controls', player.element);
                add_to_playlist = $('<div class="mejs-button mejs-star" onclick="if($(\'.mejs-star\').css(\'opacity\') < 1){return};if(playlist.id > 0){ playlist.addToContainer(player.current_playlist[player.current_index]); playlist.addToPlaylist(playlist.id, player.current_playlist[player.current_index]); $(\'.mejs-star\').fadeTo(100, 0.4)}else{openWindow(\'Ошибка\', \'Выберите плейлист для добавления\');}"><button type="button" aria-controls="mep_0" title="Добавить в выбранный плейлист"></button></div>').appendTo('.mejs-controls', player.element);
				
                player.prev = $('<div class="mejs-button-simple mejs-prev-button mejs-prev"><button type="button" aria-controls="mep_0" title="Предыдущий" onclick="var temp = player.is_repeat; player.is_repeat = false; player.prevTrack(); player.is_repeat = temp;"></button></div>').insertAfter('.mejs-play', player.element);
				
                player.next = $('<div class="mejs-button-simple mejs-next-button mejs-next"><button type="button" aria-controls="mep_0" title="Следующий" onclick="var temp = player.is_repeat; player.is_repeat = false; player.nextTrack(); player.is_repeat = temp;"></button></div>').insertAfter(player.prev);
				
                player.shuffle = $('<div class="mejs-button mejs-shuffle-button mejs-shuffle"><button type="button" aria-controls="mep_0" title="Случайное воспроизведение" onclick="$(this).fadeTo(100, (player.is_random = !player.is_random)?1:0.4);" style="opacity: 0.4"></button></div>').insertAfter(add_to_playlist);
				
                player.loop = $('<div class="mejs-button mejs-loop-on-button mejs-loop-on"><button type="button" aria-controls="mep_0" title="Повторять"  onclick="$(this).fadeTo(100, (player.is_repeat = !player.is_repeat)?1:0.4);" style="opacity: 0.4"></button></div>').insertAfter(add_to_playlist);
				
                //player.rating_block = $('<div class="rating"><span class="summary"></span><a href="javascript:void(0)">1</a> <a href="javascript:void(0)">2</a> <a href="javascript:void(0)">3</a> <a href="javascript:void(0)">4</a> <a href="javascript:void(0)">5</a> </div>').insertAfter('.mejs-horizontal-volume-slider', player.element);
				
                player.rating_block = $('<div class="rating"><input name="star2" type="radio" class="star" value="1"/><input name="star2" type="radio" class="star" value="2"/><input name="star2" type="radio" class="star" value="3"/><input name="star2" type="radio" class="star" value="4"/><input name="star2" type="radio" class="star" value="5"/> </div>').insertAfter('.mejs-horizontal-volume-slider', player.element);
                player.rater = $('.star', player.rating_block).rating({
                        callback: function(value){
                                if( value && player.artist && player.track ) {
                                        value = parseInt(value);
						
                                        $.get(COMPONENT_HOST + '/ajax/vote/?vote=' + value + '&trackname=' + player.artist + '-' + player.track, function(data)
                                        {
                                                data = Math.round(parseInt(data));
                                                if( data > 0 )
                                                {
                                                        player.rater.rating('select', data - 1, false);
                                                }
                                        });
                                }
                        }
                });
				
        $(player.rating_block).find('a').click(function(e)
        {
                $.ajax({
                        url: COMPONENT_HOST + '/ajax/vote/?vote=' + $(this).text() + '&trackname=' + player.artist + '-' + player.track,
                        success: function(data)
                        {
                                data = Math.round(parseInt(data));
                                if( data > 0 )
                                {
                                        player.rater.rating('select', data - 1, false);
                                }
                        }, 
                        error: function()
                        {
                                openWindow('', 'Для голосования необходимо авторизоваться') 
                        }
                });
        });
        track_info.click(function(){
                $(player.container).toggleClass('full')
        });
        $('<span class="mejs-track-info-inline"><span class="mejs-track">[ничего]</span> - <span class="mejs-artist">[не играет]</span></span>').insertBefore('.mejs-time-total', player.element);
}
			
function audioInit(me)
{
        player.obj = me;
        player.obj.addEventListener('volumechange', volumeChanged);
        player.obj.addEventListener('ended', nextTrack);
        player.obj.addEventListener('play', updateTrackElement);
        player.obj.addEventListener('playing', updateTrackElement);
        player.obj.addEventListener('timeupdate', updateTrackElement);
        player.obj.addEventListener('pause', updateTrackElement);
				
        audioViewBuild();
}
			
function audioError()
{
        openWindow('Ошибка аудиоплеера', 'Установите, пожалуйста, для прослушивания Flash Player или обновите браузер.');
        player.set = null; //чтобы плеер не открывался
}
			
function volumeChanged()
{
        $.cookie('volume', (typeof player.obj.volume == 'function')?player.obj.volume():player.obj.volume);
}
			
/*
				Ищет на странице воспроизводимый трек
			*/
function updateTrackElement()
{
        var frame_document = getIframe();
				
        var tracks = frame_document.$('.content-wrapper .track');
				
        frame_document.setPlayingTrack('<div><div class="stop-btn"></div></div>', false);
        if(!player.obj.paused)
        {
                for(var i = 0; i < tracks.length; i++)
                {
                        var element = frame_document.$(tracks[i]);
                        var params = frame_document.parseTrackParams(element);
						
                        if((params.data_sd == player.data_sd && params.data_id == player.data_id && params.data_id != undefined) 
                                || (params.pid == player.pid && params.pid != undefined))
                                {
                                frame_document.setPlayingTrack(element, true);
                                return;
                        }
                }
        }
}
			
/*
				Переключает трек на один вперед или начинает проигрывать плейлист с начала
			*/
function nextTrack()
{
        if(player.is_repeat)
        {
                moveTrack(0);
        }
        else if(!player.is_random && !player.is_repeat)
        {
                if(!moveTrack(+1))
                {
                        moveTrack(0, 0);
                }
        }
        else if(player.is_random)
        {
                moveTrack(0, Math.floor(Math.random() * player.current_playlist.length));
        }
}
			
/*
				Переключает трек на один назад или начинает проигрывать плейлист с конца
			*/
function prevTrack()
{
        if(player.is_repeat)
        {
                moveTrack(0);
        }
        else if(!player.is_random && !player.is_repeat)
        {
                if(!moveTrack(-1))
                {
                        moveTrack(0, player.current_playlist.length - 1);
                }
        }
        else if(player.is_random)
        {
                moveTrack(0, Math.floor(Math.random() * player.current_playlist.length));
        }
}
			
/*
				Перемещает на offset трек относительно index
				
				offset - cмещение относительно текущего +1, -1, 0 или любое другое
				index - индекс от которого будет смещение, по умолчанию текущий
			*/
function moveTrack(offset, index)
{
        index = (index == undefined)?player.current_index:index;
        index = (index == undefined)?0:index;
				
        if(player.current_playlist != undefined)
        {
                if(player.current_playlist[index + offset] != undefined)
                {
                        player.current_index = index + offset;
                        player.set(player.current_playlist[player.current_index]);
                        updateTrackElement();
						
                        return true;
                }
        }
        return false;
}
			
/*инициализация страницы:начало*/
			
$("#nezed").remove();
        $("#swing").remove();
			
        $('#frame_box').html('<iframe src="" width="100%" height="100%"></iframe>');
        current_location = document.location.href.replace(/#.*$/im, '');
			
        $('iframe').on(
        {
                load: function()
                {  
                        actions.parseFromAction();
                        actions.setAction(null);
                        playlist.getPlaylists();
					
                        newHash();
                        $('iframe').contents().on(
                        {
                                click: function(){
                                        player.container.removeClass('full');
                                }
                        });
                }
        }); 
			
        href = safeUrl(document.location.hash);
        if(href.length > 3 && href.search('#?') == -1) 
        {
                $('iframe').attr('src', href);
        } else
{
                $('iframe').attr('src', './client.php');
        }
        newHash(); 
			
/*инициализация страницы:конец*/
});
		
function safeUrl(url)
{
        return url.replace(/^\#\!*\/*/i, '').replace(/^client\.php/i, '').replace(/\w+\:\/\/(\w+\.*)+/i, '').replace(/\/\w+.php/i, '').replace(/\/{2,}/i, '/').replace(/^\//i, '').replace("about:blank", '');
}
		
function newHash()
{
        var frame_document = getIframe().document;
        var href = safeUrl(frame_document.location.href.replace(current_location, ''));
			
        document.location.hash = '!/' + href;
        document.title = frame_document.title;
			
}
		
function getIframe() 
{
        return $('iframe')[0].contentWindow;
}
		
		
/*
			Открывает модальное окно Jquery
			
			title -- заголовок
			data -- html содержимое
			callback_ok -- функция при нажатии на кнопку OK
			buttons -- дополнительные кнопки
		*/
function openWindow(title, data, callback_ok, buttons)
{
        title = (title == undefined)?'':title;
        data = (data == undefined)?'':data;
        buttons = (buttons == undefined)?new Object():buttons;
			
        buttons.ок = function() 
        {
                if(callback_ok != undefined)
                {
                        if(callback_ok() === true)
                        {
                                return;
                        }
                }
				
                $( this ).dialog('close');
        };
			
        $('#dialog-message').attr('title', title).html(data).dialog(
        {
                modal: true,
                resizable: false, 
                buttons: buttons
        }).css('overflow', 'hidden');
        $('.ui-dialog-title').html(title);
}