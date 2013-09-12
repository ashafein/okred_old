               				
var LOADER_URL = HOST + '/_images/loader.gif';//путь к загрузчику относительно html'ки
var NOIMAGE_URL = HOST + '/_images/logowithbgbig.png';
var SEARCH_URL = COMPONENT_HOST + '/search/';
                				
var SEARCH_TIME_LIMIT = 750; //ограничение на частоту запросов поиска, значение в миллисекундах, обозначающее сколько времени должно пройти до следующего запроса.
                				
var FADE_SPEED = 250;//коэффициент, на который будут домножаться все анимации исчезновения и появления
                				
var page = 0;
var last_search_time = 0;
                				
var ajax_queries = {};//запоминаются ссылки на последние запросы, чтобы их контроллировать
                				
var last_search_text_query = '';
                				
		
$(document).ready(function()
{ 
        //setPlaylistDynamic();
                					
        $(window).scroll(function()
        {
                if($('#menu #search_btn').length > 0)
                {//если выбрана вкладка поиска
                							
                        if ($(window).scrollTop() >= $(document).height() - ($(window).height() * 1.2))
                        {
                                loadSearchResults(false);
                        }
                }
                						
                						
                if($(window).scrollTop() > $(window).height() / 3)
                {
                        $('.scroll-btn').fadeIn();
                }
                else
                {
                        $('.scroll-btn').fadeOut();
                }
        });//определяет, долистал ли пользователь до конца страницы
                					
        $('a').click(function(event)
        {  //если вдруг покидают домен, то покидаем пределы iframe, так как из-за ошибок безопасности содержимое iframe далее не будет доступно
                						
                event.preventDefault();
                event.stopPropagation();
                						
                var url = ($(event.target).attr('href') != undefined) ? $(event.target).attr('href') : '';
                var host;
                if (url.split('://').length > 1)
                {
                        host = url.split('://')[1].split('/')[0];
                }
                else
                {
                        $(this).unbind('click').click();
                        return true;
                }
                						
                						
                if (host != window.parent.document.location.hostname)
                {
                        window.parent.document.location = url;
                }
                else
                {
                        $(this).unbind('click').click();
                        return true;
                }
                						
                return false;
        });
        setPlaylistDynamic({});
});
                				
/*
                                                Костыль для IE, он не поддерживает hover в div
                                 */
function initIEHover()
{
        $('.playlist .track, .tabs .tab').unbind('mouseenter mouseleave');
        $('.playlist .track, .tabs .tab').hover(function(event)
        {
                $(this).addClass('tab-hover');
        });
        $('.playlist .track, .tabs .tab').mouseleave(function(event)
        {
                $(this).removeClass('tab-hover');
        });
}
                				
/*
                                                    Ициализуерт html блок популярного
                                 */
function initPopularBlock()
{
        $('.tabs #genres .selected').click();
        $('.tabs #menu #search_btn').remove();
        $('.content-wrapper .playlist').find('p').remove();
}
                				
/*
                                                    Инициализирует html блок меню плейлистов
                                 */
function initTabsPlaylistBlock()
{
        if(window.parent)
        {
                var playlist = window.parent.playlist;
                var playlist_tabs_block = $('.tabs #playlists');
                var genres_tabs_block = $('.tabs #genres');
                var first_tab = playlist_tabs_block.find('.tab:eq(0)');
                						
                if(!playlist.is_loaded_playlists)
                { //если загрузка плейлистов юзера еще закончилась -- пробуем подождать
                							
                        setTimeout(initTabsPlaylistBlock, 250);
                        return;
                }
                						
                genres_tabs_block.fadeOut(FADE_SPEED);
                playlist_tabs_block.fadeIn(FADE_SPEED);
                						
                for(var i = playlist_tabs_block.children().length - 1; i > 1; i--)
                {//удаляем все плейлисты из списка, кроме кнопки "создать плейлист" и разделителя separator
                							
                        $(playlist_tabs_block.children()[i]).remove();
                }
                						
                if(playlist.my_playlists != undefined)
                {
                        for(i = 0; i < playlist.my_playlists.length; i++)
                        {
                                var current = playlist.my_playlists[i];
                                var block = first_tab.clone().appendTo(playlist_tabs_block);
                                block.attr('id', current.id).find('.title').html(current.name);
                								
                                if(playlist.id == current.id)
                                {
                                        block.addClass('selected');
                                }
                								
                                block.find('.info').append('<div class="right-btn edit-btn" id="edit_playlist_btn" onclick="chooseMenu(this, event)"></div>');//добавляем кнопку редактирования
                                block.find('.info').append('<div class="right-btn delete-btn" id="delete_playlist_btn" onclick="chooseMenu(this, event)"></div>');//добавляем кнопку редактирования
                        }
                							
                        initIEHover();
                        playlist_tabs_block.find('.tab:not(#create_btn, .selected)').droppable(
                        {
                                accept: ".playlist .track",
                                hoverClass: "tab-hover",
                                drop: function( event, ui ) 
                                {
                                        if(window.parent)
                                        {
                                                var playlist = window.parent.playlist;
                                                var tab = $(this);
                                                var data = parseTrackParams(ui.draggable);
                										
                                                playlist.addToPlaylist(tab.attr('id'), data);
                										
                                                if(ui.draggable.parent().find('p').length > 0)
                                                {//если вставлена невидимая отметка того, что список содержит в себе записи плейлиста
                											
                                                        ui.draggable.hide(FADE_SPEED * 2, function()
                                                        {
                                                                playlist.syncContainerData();
                												
                                                                if(ui.draggable.parent().find('.track:visible').length < 1)
                                                                {//если вдруг записей после удаления не осталось, то переходим во вкладку, в которую переносили
                													
                                                                        tab.click();
                                                                }
                                                        });
                                                }
                                                else
                                                {
                                                        ui.draggable.find('#add_track_btn').addClass('ok-btn');
                                                }
                                        }
                                }
                        });
                }
        }
}
                				
/*
                                                    Инициализирует html блок редактирования плейлиста
                                 */
function initCreateWindowBlock(id, name)
{
        name = (id == undefined)?playlist.name:name;
        name = (name == undefined)?'':name;
        id = (id == undefined)?playlist.id:id;
                					
                					
        if(window.parent)
        {
                var playlist = window.parent.playlist;
                						
                if($.cookie('auth') == 1)
                {
                        var content_html = 'Введите название плейлиста: <br><input maxlength="32" style="border: 1px solid #ccc; padding: 2px" type="text" value="' + ((name != undefined)?name:'') + '" placeholder="название плейлиста">';
                							
                        openWindow(((id < 1)?'Создание':'Редактирование') + ' плейлиста', content_html, function()
                        {					
                                playlist.setPlaylist(id, getWindow().find('input:eq(0)').attr('value'), undefined, function()
                                {
                                        playlist.getPlaylists(function()
                                        {
                                                $('.tabs #playlists_btn').click();
                                        });
                                });
                        });
                }
                else
                {
                        openWindow('Ошибка', 'Авторизуйтесь или зарегистрируйтесь для создания плейлиста');
                }
        }
}
                				
/*
                                                    Инициализирует html блок-окно для удаления плейлиста
                                 */
function initDeleteWindowBlock(id)
{
        if(window.parent)
        {
                var playlist = window.parent.playlist;
                openWindow('Удаление плейлиста', 'Вы действительно хотите удалить этот плейлист?', function()
                {
                        playlist.deletePlaylist(id, function(data)
                        {
                                playlist.getPlaylists(function()
                                {
                                        if($('.content-wrapper .playlist p[id=' + id + ']').length > 0)
                                        {//если удаляют выбранный
                										
                                                initPopularBlock();
                                        }
                                        $('.tabs #playlists_btn').click();
                                });
                        });
                }, 
                {
                        отмена: function()
                        { 
                                getWindow().dialog('close');
                        }
                });
        }
}
                				
/*
                                                    Инициализирует html блок-окно для добавления песни
                                 */
function initAddSongWindowBlock()
{
        openWindow('Добавить песню', '<div style="height: 120px; width: 300px"><iframe src="pleer_upload.html" width="100%" height="100%" scrolling="no" border="0" style="overflow: hidden; border:none;"/></div>', function()
        {
                var frame = getWindow().find('iframe')[0].contentWindow;
                if(getWindow().find('iframe')[0].contentWindow.$)
                {
                        getWindow().find('iframe')[0].contentWindow.$('form').submit();
                        return true;
                }
        },
        {
                отмена: function()
                { 
                        getWindow().dialog('close');
                }
        });
}
                				
/*
                                                    При клике на пункт меню в .tabs #menu
                					
                                                    target -- передается в событии onclick
                                 */
function chooseMenu(target, event)
{ 
        target = $(target);
        event = (event != undefined)?$.event.fix(event):event;
        //$.event.fix добавляет метод в IE preventDefault
                					
        switch(target.attr('id'))
        {
                case 'search_btn':
                        return false;
                        break;
                						
                case 'create_btn':
                        initCreateWindowBlock(0);
                        return false;
                        break;
                						
                case 'add_song_btn':
                        initAddSongWindowBlock();
                        return false;
                        break;
                						
                case 'edit_playlist_btn':
                        event.stopPropagation(); 
                        initCreateWindowBlock(target.parent().parent().attr('id'), target.parent().find('.title').text())
                        return false;
                        break;
                						
                case 'delete_playlist_btn':
                						
                        event.stopPropagation(); 
                        initDeleteWindowBlock(target.parent().parent().attr('id'));
                						
                        return false;
                        break;
                						
                case 'add_track_btn':
                        event.stopPropagation(); 
                						
                        if(!target.hasClass('ok-btn'))
                        {
                                var playlist = window.parent.playlist;
                							
                                if(playlist.id > 0) 
                                {
                                        target.addClass('ok-btn');
                                        playlist.addToPlaylist(playlist.id, parseTrackParams(target.parent().parent()));
                                }
                                else
                                {
                                        openWindow('Ошибка', 'Выберите плейлист для добавления');
                                }
                        }
                        return false;
                        break;
                						
                case 'delete_track_btn':
                        event.stopPropagation(); 
                						
                        target.toggleClass('add-btn');
                        target.parent().parent().toggleClass('deleted');
                        window.parent.playlist.syncContainerData();
                						
                        return false;
                        break;
                						
                case 'popular_btn':
                        initPopularBlock();
                        break;
                						
                case  'playlists_btn':
                        initTabsPlaylistBlock();
                        break;
                						
                default:
                        if($.isNumeric(target.attr('id')) && target.parent().attr('id') == 'playlists')//если кликнули на плейлист
                        {
                                choosePlaylist(target);
                        }
                        break;
        }
                					
        $('.tabs #menu .tab').removeClass('selected');
        target.addClass('selected');
}
                				
/*
                                                    Запускает проигрывание трека(при клике на трек)
                					
                                                    target -- передается в событии onclick
                                                    data -- параметры трека
                                 */
function choosePlaylist(target)
{
        target = $(target);   
        if(window.parent)
        {
                setAction('playlist', [target.attr('id')]);
                						
                var playlist = window.parent.playlist;
                var playlist_tabs_block = $('.tabs #playlists');
                var playlist_tracks_block = $('.content-wrapper .playlist');
                var first_track_block = playlist_tracks_block.find('.track:eq(0)').clone();//клонируем шаблон
                						
                $('.tabs #playlists_btn').click();
                $('.tabs #menu #search_btn').remove();
                playlist_tabs_block.find('#playlists .tab').removeClass('selected');
                target.addClass('selected');
                						
                playlist.id = target.attr('id');
                if(target.find('.title').length > 0)
                {
                        playlist.name = target.find('.title').text();
                }

                initTabsPlaylistBlock();
                $('.content-wrapper .artists').fadeOut(FADE_SPEED);
                						
                setLoadingState(playlist_tracks_block, true, FADE_SPEED * 2, function()
                {
                        playlist.getPlaylist(target.attr('id'), function(data)
                        {
                                setLoadingState(playlist_tracks_block, false, FADE_SPEED, function()
                                {
                                        data = (typeof data[0]['tracks'] == 'array')?data[0]['tracks']:$.makeArray($.parseJSON(data[0]['tracks']));
                                        data = (data == null)?new Array():data;

                                        playlist_tracks_block.html('<p style="display:none" id="' + String(target.attr('id')) + '"></p>');
                                        //удаляем все, что было раньше и добавляем как бы... якорь плейлиста, для того, чтобы сверять в будущем
                									
                                        first_track_block.css({
                                                display: 'none'
                                        }).appendTo(playlist_tracks_block);//вставляем шаблон и делаем его невидимым
                                        if(data.length == 0)
                                        {
                                                playlist_tracks_block.append('<center>Плейлист пуст</center>');
                                        }
                                        else
                                        {
                                                for(var i = 0; i < data.length; i++)
                                                {
                                                        if(data[i]['track'] != undefined)//если объект не пуст, на всякий пожарный
                                                        {
                                                                playlist.addToContainer(data[i]);
                                                        }
                                                }
                                                setPlaylistDynamic({}, playlist.syncContainerData);
                                        }
                                });
                        });
                });
        }
}
                				
/*
                                                    Запускает проигрывание трека(при клике на трек)
                					
                                                    target -- передается в событии onclick
                                                    data -- параметры трека
                                 */
function chooseTrack(target, data)
{
        target = $(target);
        if(window.parent)
        {
                var track_index;
                var is_selected = target.hasClass('selected');
                var player = window.parent.player;
                						
                if(target.hasClass('deleted'))
                {
                        return;
                }
                						
                if(!is_selected)
                { 
                        player.current_playlist = parseTracksParams();
                							
                        for(var i = 0; i < player.current_playlist.length; i++)
                        { 
                                var data2 = player.current_playlist[i];
                                if(data.artist == data2.artist && data.track == data2.track && data.data_sd == data2.data_sd && data.data_id == data2.data_id  && data.pid == data2.pid && data.album_id == data2.album_id)
                                {
                                        track_index = i;
                                        break;
                                }
                        }
                							
                        if(track_index != undefined)
                        {
                                player.set(player.current_playlist[track_index]);
                                player.current_index = track_index;
                        }
                }
                else
                {
                        player.stop();
                }
        }
}
                				
/*
                                                    При клике на жанр
                					
                                                    target -- передается в событии onclick
                                                    is_type -- переменная используется для жанра "все", поскольку печатать его глупо
                                 */
function chooseGenre(target, is_type)
{				
        var block = $(target);
        var block_link = block.find('a');
                					
        $('.tabs #genres').fadeIn(FADE_SPEED);
        $('.tabs #playlists').fadeOut(FADE_SPEED);
        $('.tabs #genres .tab').removeClass('selected');
        block.addClass('selected');
                					
        if (is_type)
        {
                typeTo('#maxsearch-input', block_link.html(), 20);
        }
        $.cookie('style', is_type ? block_link.html().toLowerCase() : null);
                					
        ($.cookie('style') != null)?setAction('genre', [$.cookie('style')]):setAction(null);
                					
                					
        if (ajax_queries.update)
        {//для любителей двойных кликов)
                						
                ajax_queries.update.abort();
        }
                					
        $("body").animate({
                'scrollTop': 0
        }, FADE_SPEED);
        $('.content-wrapper .playlist').css({
                height: String($(window).height()) + 'px'
                });
                					
        setLoadingState('.content-wrapper .playlist, .content-wrapper .artists', true, FADE_SPEED * 10);
                					
        ajax_queries.update = $.ajax({
                url: block.find('a').attr('href').toLowerCase().replace(/\%27/gm, ''), 
                success: function(data)

                {
                        var parser = $('#forjs #2');
                        parser.html(data);
                							
                        $('.content-wrapper .playlist').css({
                                height: '100%'
                        });
                        setLoadingState('.content-wrapper .playlist, .content-wrapper .artists', false, FADE_SPEED * 2, function()
                        {
                                $('.content-wrapper .playlist').html(parser.find('.playlist').html());
                                $('.content-wrapper .artists').html(parser.find('.artists').html());
																
                                makeUnique('.content-wrapper .playlist .track');
                        });
                }
        });
return false;
}
                				
/*
                                                    Загружает следующую страницу в поиске, вызывается в шаблоне страницы поиска
                					
                                                    is_new_query -- Boolean, листаем ли мы данные по заранее введенному запросу или же выводим новые
                                 */
function loadSearchResults(is_new_query)
{
        $('.content-wrapper .playlist').find('p').remove();
        if(is_new_query)
        { 						
                page = 0;
                last_search_text_query = $('.content-wrapper form #maxsearch-input').attr('value');
                						
                $('.content-wrapper .playlist').css({
                        height: String($(window).height()) + 'px'
                        });
                setLoadingState('.content-wrapper .playlist', true, FADE_SPEED * 10);
                $('.content-wrapper .artists').fadeOut(FADE_SPEED);
                $('.tabs #genres').fadeOut(FADE_SPEED);
                						
                setAction('search', [last_search_text_query]);
        }
                					
        if (page == -1) //если сервер выставил значение -1 -- страницы закончились
        {
                return;
        }
        if (new Date().time - last_search_time < SEARCH_TIME_LIMIT)
        { //дабы не было срабатывания на микро изменения позиции скролла
                						
                return;
        }
                					
                					
        $.get(SEARCH_URL, {
                text: last_search_text_query, 
                page: page
        }, function(data)

        {
                if(is_new_query)
                {
                        $('.content-wrapper .playlist').css({
                                height: '100%'
                        });
                        setLoadingState('.content-wrapper .playlist', false, FADE_SPEED * 2, function()
                        {
                                $('.content-wrapper .playlist').html(data);
                                makeUnique('.content-wrapper .playlist .track');
                                initIEHover();
                        });
                }
                else
                {
                        $('.content-wrapper .playlist').append(data);
                        makeUnique('.content-wrapper .playlist .track');
                        initIEHover();
                }
                						
                if($('.tabs #menu #search_btn').length < 1)
                {
                        $('.tabs #menu .tab').removeClass('selected');
                        $('.tabs #menu .tab:eq(0)').clone().attr('id', 'search_btn').addClass('selected').insertAfter('.tabs #playlists_btn');
                        $('.tabs #menu #search_btn').find('.title').html('Поиск');
                }
                						
                if($('.content-wrapper .playlist .track').length > 0)
                {
                        $('.content-wrapper .playlist h2').remove();
                }
        });
                					
        page++;
        last_search_time = new Date().time;
//setPlaylistDynamic();					
}
                				
/*
                                                Вытаскивает объект из функции onclick у всех треков на странице
                                 */
function parseTracksParams()
{					
        var array = new Array();
        var track_blocks = $('.content-wrapper .playlist .track');
                					
        for(var i = 0; i < track_blocks.length; i++)
        {
                var block = $(track_blocks[i]);
                if(block.attr('onclick') != undefined && !block.hasClass('deleted') && block.css('display') != 'none')
                {
                        var object = parseTrackParams(block);
                        array.push(object);
                }
        }
        return array;
}
                				
/*
                                                Вытаскивает объект параметров из функции onclick у одного трека
                					
                                                    target - элемент, откуда вытащить
                                 */
function parseTrackParams(target)
{					
        var object = target.attr('onclick').match(/\, (.*?)\)\;/i)[1];
        object = $.parseJSON(object.replace(/\'/g, '"'));
                					
        return object;
}
                				
/*
                                                Включает или выключает сортировку плейлиста с параметрами
                					
                                                    params -- объект параметров или 'disabled'
                                                    callback -- функция, которую необходимо вызвать по событию изменения
                                 */
function setPlaylistDynamic(params, callback)
{
        params = (params == undefined)?{}:params;
                					
        params.stop = callback;
        params.cancel = '.deleted';
        $('.content-wrapper .playlist').sortable(params);
}
                				
/*
                                                    Выделяет трек в плейлисте проигрываемым/остановленным
                					
                                                    selector -- селектор или объект jquery блока ИЛИ МАССИВ ЭТИХ ОБЪЕКТОВ И СТРОК, к которому нужно применить это
                                                    is_loading -- true: установить загрузчик, false: удалить загрузчик
                                                    animation_time -- время фейдов
                                                    callback -- выполнить после того, как блок спрячется и появится/удалится загрузчик
                                 */
function setPlayingTrack(selector, is_playing)
{
        $('.content-wrapper .playlist .track').removeClass('selected');
        $('.content-wrapper .playlist .track .info .stop-btn').attr('class', '').addClass('play-btn');
                					
        if(is_playing)
        {
                $(selector).addClass('selected');
                $(selector).find('.play-btn').addClass('stop-btn').removeClass('play-btn');
        }
        else
        {
                $(selector).find('.stop-btn').addClass('play-btn').removeClass('stop-btn');
        }
}
                				
/*
                                                    Прячет блок и показывает загрузчик
                					
                                                    selector -- селектор или объект jquery блока или массив, к которому нужно применить это
                                                    is_loading -- true: установить загрузчик, false: удалить загрузчик
                                                    animation_time -- время фейдов
                                                    callback -- выполнить после того, как блок спрячется и появится/удалится загрузчик
                                 */
function setLoadingState(selector, is_loading, animation_time, callback)
{	
        animation_time = (animation_time == undefined) ? FADE_SPEED * 2 : animation_time;
                					
        var width = $(selector).width() + 'px';
        var height = $(selector).height() + 'px';
                					
        $(selector).stop().fadeTo(animation_time, 0.01, function()
        {
                $(selector).find('#loader').remove();//удаляем загрузчик старый
                if (is_loading)
                {
                        $(selector).find('*:only-child').css({
                                display: 'none'
                        }).attr('hided', 'true');//скрываем все остальные элементы и помечаем их
                							
                        $(selector).append(createLoader(width, height));//создаем загрузчик
                        $(selector).stop().fadeTo(animation_time / 2, 1);//и запускаем показ обратно, дабы мы видели loader
                							
                        (callback != undefined) ? callback.call() : null;
                }
                else
                {
                        $(selector).find('*[hided=true]').css({
                                display: 'block'
                        });//показываем заранее скрытые блоки
                							
                        (callback != undefined) ? callback.call() : null;
                							
                        $(selector).stop().fadeTo(animation_time, 1);//и запускаем показ обратно, дабы мы видели уже контент
                }
        });
}
                				
                				
/*
                                                    Устанавливает размер блоков grid-item и grid соотвественно
                					
                                                    size - размер (small, simple, big)
                                 */
function setGridSize(size)
{
        size = (size == undefined) ? 'small' : size;
                					
        $('.grid').removeClass('small-grid').removeClass('simple-grid').removeClass('big-grid').addClass(size + '-grid');
        $('.grid .grid-item').removeClass('small-grid-item').removeClass('simple-grid-item').removeClass('big-grid-item').addClass(size + '-grid-item');
}
                				
                				
/*
                                                    Эффект печати в поле
                					
                                                    lefttext - текст для печати
                                                    interval - промежуток между печатью каждого символа, мс, по умолчанию 100
                                                    is_first_call - или true или не передавать!
                                 */
function typeTo(selector, lefttext, interval, callback)
{
        var target = $(selector);
                					
        if (target.attr('typing') == '1')
        {
                return;
        }
                					
        target.attr('value', '');
        target.attr('typing', '1');
                					
        interval = (interval == undefined) ? 100 : interval;
                					
        var interval_id = setInterval(function()
        {
                target.attr('value', target.attr('value') + lefttext.charAt(0));
                lefttext = lefttext.substring(1);
                						
                if (lefttext == '')
                {
                        clearInterval(interval_id);
                        target.attr('typing', '0');
                							
                        (callback != undefined)?callback():undefined;
                }
        }, interval);
                					
}
                				
/*
                                                    Создает html строку с блоком загрузчика
                					
                                                    width, height -- ширина и высота соотвественно в css формате записи(px, %)
                                 */
function createLoader(width, height)
{
        return '<div id="loader" style="position: relative; display: table; width:' + width + '; height: ' + height + '"><div style="display: table-cell; vertical-align: middle; text-align: center;"><img style="margin: 5px" src="' + LOADER_URL + '"></div></div>';
}
                				
/*
                                                Удаляет повторяющиеся блоки
                					
                                                    selector - селектор элементов, которые нужно сделать уникальными
                                 */
function makeUnique(selector)
{
        var seen = {};
        $(selector).each(function() 
        {
                var txt = $(this).text();
                if (seen[txt])
                {
                        $(this).remove();
                }
                else
                {
                        seen[txt] = true;
                }
        });//удаляем повторения
}
                				
/*
                                                    Открывает модальное окно Jquery
                					
                                                    title -- заголовок
                                                    data -- html содержимое
                                                    callback -- функция при нажатии на кнопку OK
                                 */
function openWindow(title, data, callback, buttons)
{
        if(window.parent)
        {
                window.parent.openWindow(title, data, callback, buttons)
                return;
        }
}
                				
/*
                                                Возвращает объект окна
                                 */
function getWindow()
{
        if(window.parent)
        {
                return window.parent.$('#dialog-message');
        }
        return $('#dialog-message');
}
                				
/*
                                                    Устанавливает у родителя последнее действие, формируя ссылку на действие
                                 */
function setAction(action, params)
{
        (window.parent != undefined)?window.parent.actions.setAction(action, params):null;
}