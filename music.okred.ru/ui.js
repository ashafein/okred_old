/*
jPlay: A useful, practical and sexy Jamendo player
Copyright (C) 2012 - Thomas Baquet < me lordblackfox net >

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function  $get (aId) {
  return document.getElementById(aId);
}

var ui = {
  albums: null,
  album: null,
  filter: null,
  albumitem: null,


  init: function () {
    ui.albumitem = parasol(document.getElementById('albumitem'));
    ui.albumpreview = parasol(document.getElementById('albumpreview'));
    ui.trackitem = parasol(document.getElementById('trackitem'));
    ui.playlistitem = parasol(document.getElementById('playlistitem'));

    document.body.addEventListener('keypress', ui.onKeyPressBody, false);

    parasol();

    this.notebook = new parasol.widget.notebook($get('notebook-tabs'), $get('notebook'));
  },


  onFilterKeyUp: function (evt) {
    //FIXME: keyCode deprecated, but not yet implemented
    if(evt.keyCode == 13) {
      lists.search.clear();
      jamendo.search(evt.target.value);
      albums.filter = '';
      albums.list = lists.search;
      return;
    }
    else if(evt.keyCode == 9)
      return;

    var filter = $get('filter').value;
    if(albums.filter != filter)
      albums.filter = filter;
  },


  onDragAlbum: function (evt) {
    var album = evt.currentTarget.getAttribute('album');
    evt.dataTransfer.setData('text/json', '{"album":' + album + '}');

    // preload
    album = albums.albums[album];
    if(!album.tracks)
      jamendo.album(album.id);
  },


  onDragTrack: function (evt) {
    track = evt.currentTarget;
    evt.dataTransfer.setData('text/json',
      JSON.stringify({track: { 'name': track.getAttribute('name'),
                               'stream': track.getAttribute('stream'),
                               'album': track.getAttribute('album')
                     }}));
  },


  onDragOver : function (evt) {
    var data = evt.dataTransfer.getData('text/json');
    if(!data)
      return;
    evt.preventDefault();
    evt.currentTarget.setAttribute('dragover', 'true');
  },


  onDragLeave: function (evt) {
    evt.currentTarget.removeAttribute('dragover');
  },


  onDropPlaylist: function (evt) {
    evt.currentTarget.removeAttribute('dragover');
    evt.target.removeAttribute('dragover');

    var data = JSON.parse(evt.dataTransfer.getData('text/json'));
    if(!data.album && !data.track)
      return;

    var target = (evt.target == $get('playlist')) ? null : evt.target;

    if(data.album) {
      var album = albums.albums[data.album];
      if(!album)
        return;

      player.setAlbum(album, false, target);
    }
    else if(data.track)
      player.set(data.track, target);

    evt.preventDefault();
  },


  onDropAlbum: function (evt) {
    evt.currentTarget.removeAttribute('dragover');

    var data = JSON.parse(evt.dataTransfer.getData('text/json'));
    if(!data.album && !data.track)
      return;

    if(data.album) {
      var album = albums.albums[data.album];
      if(!album)
        return;
      albums.show(album);
    }
    else if(data.track)
      albums.show(data.track.album);

    evt.preventDefault();
  },


  onScrollAlbums: function (event) {
    var scroll = $get('albums-container').scrollTop + $get('albums-container').clientHeight;
    var size = $get('albums').clientHeight;

    if(scroll >= size + 20)
      albums.list.load();
  },


  onDblClickAlbum: function (event) {
    var album = albums.albums[event.currentTarget.getAttribute('album')];
    if(!album)
      return;

    player.setAlbum(album, false, true);
  },


  onClickAlbum: function (event) {
    albums.show(albums.albums[event.currentTarget.getAttribute('album')]);
  },


  onClickTrack: function (evt, item, album) {
    if(evt.target.className == 'append' || evt.shiftKey)
      player.set([item]);
    else {
      var stream = evt.currentTarget.getAttribute('stream');
      player.playlist = $get('album-tracks');
      player.play(evt.currentTarget);
    }
  },


  onKeyPressBody: function (event) {
    if(event.target.nodeName == "INPUT")
      return;

    //FIXME: deprecated keyCode and charCode
    var useKeyCode = false;
    switch(event.charCode | event.char) {
      case 32:
        var player = $get('player');
        if(player.paused)
          player.play();
        else
          player.pause();

      default:
        useKeyCode = true;
    }

    if(!useKeyCode)
      return;
  },
}





function load () {
  albums.init();
  ui.init();
  config.init();
  player.init(); //depends of: config, albums
}

