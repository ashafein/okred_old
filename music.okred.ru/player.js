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

var player = {
  playlist: null,
  current: null,

  init: function () {
    $get('player').addEventListener('ended', function () {
      try {
        player.play();
      }
      catch(e) {
        alert(e);
      }
    }, false);

    var l = config('playlist');
    if(l && config('savePl')) {
      l = JSON.parse(l);

      albums.append(l.albums, lists.extras);
      player.set(l.tracks, null, true);
    }
  },


  play: function (aURL) {
    var track;
    var playlist = this.playlist || $get('playlist');
    if(aURL && aURL.parentNode) {
      track = aURL;
      this.playlist = aURL.parentNode;
    }
    else if(aURL) {
      var current = this.current || playlist.children[0];

      do {
        if(current.getAttribute('stream') == aURL) {
          track = current;
          break;
        }
      } while((current = current.nextSibling))

      if(!track) {
        current = playlist.children[0];

        do {
          if(current.getAttribute('stream') == aURL) {
            track = current;
            break;
          }
        } while((current = current.nextSibling) != this.current && current);

        /*if(!track)
          this.current = 0;*/
      }
    }
    else {
      if(this.current && this.current.nextElementSibling)
        track = this.current.nextElementSibling;
      else
        track = playlist.children[0];
    }

    var player = $get('player');
    if(player.src == track.getAttribute('stream'))
      player.currentTime = 0;
    else {
      player.src = track.getAttribute('stream');
      player.load();
      document.title = track.getAttribute('name') + ' - ' + track.getAttribute('artist');
      $get('track')
           .set('name', track.getAttribute('name'))
           .set('stream', track.getAttribute('stream'))
           .set('album', track.getAttribute('album'))
           .set('album_name', track.getAttribute('album_name'))
           .set('artist', track.getAttribute('artist'));
    }
    player.play();

    if(this.current && this.current != track)
      this.current.removeAttribute('active');
    this.current = track;

    if(track) {
      track.setAttribute('active', 'true');
      track.scrollIntoView(false);
    }

    if(!$get('album-header').hasAttribute('album'))
      albums.show(track.getAttribute('album'));
  },


  set: function (aList, aBefore, aQuiet) {
    if(!aList.length)
      aList = [aList];

    var k = player.current && player.current.parentNode != $get('playlist');

    var fragment = document.createDocumentFragment();
    for(var i = 0; i < aList.length; i++) {
        var elm = ui.playlistitem();
        var item = aList[i];

        elm.set('name', item.name)
           .set('stream', item.stream)
           .set('album', item.album)
           .set('album_name', albums.albums[item.album].name)
           .set('artist', albums.albums[item.album].artist);
        fragment.appendChild(elm);

        if(k && item.stream == player.current.getAttribute('stream')) {
          player.current.removeAttribute('active');
          elm.setAttribute('active', 'true');
          player.current = elm;
          player.playlist = $get('playlist');
          k = false;
        }
    }
    if(aBefore)
      $get('playlist').insertBefore(fragment, aBefore);
    else
      $get('playlist').appendChild(fragment);

    //play if nothing is playing
    if(!(this.current || aQuiet))
      player.play();

    player.save();
  },


  setAlbum: function (aAlbum, aPlay, aBefore) {
    var fct = function () {
      player.set(aAlbum.tracks, aBefore);
      if(aPlay) {
        player.playlist = $get('playlist');
        player.play(aAlbum.tracks[0].stream);
      }
    };

    if(aAlbum.tracks)
      fct();
    else
      jamendo.album(aAlbum.id, fct);
  },


  save: function () {
    if(config('savePl')) {
      var lists = { albums: [], tracks: []};

      var done = [];
      var list = $get('playlist').children;
      for(var i = 0; i < list.length; i++) {
        var e = list[i];
        var a = albums.albums[e.getAttribute('album')];

        lists.tracks.push({ name: e.getAttribute('name'),
                            stream: e.getAttribute('stream'),
                            album: e.getAttribute('album') });

        if(!done[a.album]) {
          lists.albums.push(a);
          done[e.getAttribute('album')] = true;
        }
      }

      config('playlist', JSON.stringify(lists));
    }
  },

  remove: function (aTrack) {
   $get('playlist').removeChild(aTrack);
   if(!$get('playlist').children.length)
     config.remove('playlist');
  },


  clear: function () {
    var container = $get('playlist');
    if((!this.playlist || this.playlist == container) && !$get('player').paused)
      $get('player').pause();


    while(container.children.length)
      container.removeChild(container.children[0]);
    config.remove('playlist');
  },
}


