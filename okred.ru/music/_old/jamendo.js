/*
jPlay: A usefull, practical and sexy Jamendo player
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

function AlbumList (aTab, aLoad) {
  var fct = function (aId, aValue) {
    if(aValue)
      this.list(aId) = aValue;
    return this.list(aId);
  };


  fct.list = {};
  fct.tab = aTab;
  fct._count = 0;

  fct.__defineGetter__("count", function () {
    return this._count;
  });


  fct.clear = function () {
    //TODO
    this.list = {};
  };

  fct.show = function () {
    if(this.tab)
      this.tab.setAttribute('active', 'true');

    if(!this._count) {
      this.load();
      return;
    }

    var list = this.list;
    for(var i in list)
      list[i].ui.albumitem.style.display = "block";
  };


  fct.hide = function () {
    var list = this.list;
    for(var i in list)
      list[i].ui.albumitem.style.display = "none";
    if(this.tab)
      this.tab.removeAttribute('active');
  };


  fct.append = function (aList) {
    if(aList.length)
      for(var i = 0; i < aList.length; i++)
        this.list[aList[i].id] = aList[i];
    else
      for(var i in aList)
        this.list[aList[i].id] = aList[i];
    this.updateCount();
  };


  fct.updateCount = function () {
    this._count = Object.keys(this.list).length;
  };


  fct.load = aLoad || function () {};

  return fct;
}


lists = {
  favorite: null,
  popular : null,
  latest : null,
  search : null,
  extras : null,
};



function secondsToString (aSeconds) {
  var i = aSeconds%60;
  if(i < 10)
    i = '0' + i;
  return parseInt(aSeconds/60) + ':' + i;
}


var albums = {
  albums: [],
  siblings: [],

  // Private ----
  _list: null,


  _setElementData: function (item, elm) {
    elm.set('album', item.album || item.id)
       .set('artist', item.artist_name)
       .set('artist_url', item.artist_url)
       .set('artist_id', item.artist_id)
       .set('image', item.image)
       .set('name', item.name)
       .set('url', item.url);
    return elm;
  },


  _ensureAlbum: function (item, fragmentItem, fragmentPreview) {
    if(!this.albums[item.id]) {
      item.artist = item.artist_name;
      item.ui = {
        albumitem: this._setElementData(item, ui.albumitem()),
        preview:   this._setElementData(item, ui.albumpreview()),
      };

      item.ui.albumitem.style.display = "none";

      fragmentItem.appendChild(item.ui.albumitem);
      if(fragmentPreview)
        fragmentPreview.appendChild(item.ui.preview);

      //FIXME: on multiplatform, move it
      var u = item.license_url;
      if(u.search('artlibre') != -1)
        item.license = 'Art Libre';
      else
        item.license =  u.replace(/.*\/licenses\/([^\/]*).*/, 'cc $1');

      this.albums[item.id] = item;
      return item;
    }
    return this.albums[item.id];
  },


  // Properties ----
  set filter(aValue) {
    this._filter = aValue || '';
    //ui.filter.value = this._filter;
    if(!this._filter.length) {
      this.list = this.list;
      return this._filter;
    }

    var e = new RegExp(aValue, 'gi');
    var l = $get('albums').childNodes;
    for(var i = 0; i < l.length; i++) {
      var elm = l[i];
      if(!elm.style)
        continue;

      if(elm.getAttribute('artist').search(e) != -1 ||
         elm.getAttribute('name').search(e) != -1)
        elm.style.display = 'block';
      else
        elm.style.display = 'none';
    }
    return this._filter;
  },

  get filter() {
    return this._filter;
  },


  set list(aList) {
    if(this._list)
      this._list.hide();
    this._list = aList;
    aList.show();
    return aList;
  },

  get list() {
    return this._list;
  },


  // Methods ----
  init: function () {
    lists.favorite = AlbumList(document.getElementById('tab-favorite'), jamendo.favorite);
    lists.popular = AlbumList(document.getElementById('tab-popular'), jamendo.popular);
    lists.latest = AlbumList(document.getElementById('tab-latest'), jamendo.latest);
    lists.search = AlbumList(document.getElementById('tab-search'), jamendo.search);
    lists.extras = AlbumList(null, null);
  },


  append: function (aAlbums, aList, aSiblingsOfArtist) {
    var top = $get('albums-container').scrollTop;
    var fragmentItems = document.createDocumentFragment();
    var list = aList.list;
    for(var i = 0; i < aAlbums.length; i++) {
      var item = this._ensureAlbum(aAlbums[i], fragmentItems, null);
      aAlbums[i] = item; //update list with the right item

      if(!list[item.id])
        list[item.id] = item;
    }
    aList.updateCount();

    $get('albums').appendChild(fragmentItems);

    if(aSiblingsOfArtist)
      this.siblings[aSiblingsOfArtist] = aAlbums;

    //if(!ui.filter.value) //FIXME: filter property to object album?
    this.list = this.list;
    this.filter = this.filter;

    $get('albums-container').scrollTop = top;
    return aAlbums;
  },


  show: function (aAlbum) {
    if(typeof(aAlbum) != 'object')
      aAlbum = this.albums[aAlbum];

    var old = function (e) {
      e = e.getAttribute('album');
      return !e || e != aAlbum.id;
    }

    $get('album-header')
      .set('album', aAlbum.id)
      .set('image', aAlbum.image)
      .set('artist', aAlbum.artist)
      .set('artist_id', aAlbum.artist_id)
      .set('artist_url', aAlbum.artist_url)
      .set('promote', aAlbum.artist_url + '/promote')
      .set('name', aAlbum.name)
      .set('url', aAlbum.url)
      .set('license', aAlbum.license)
      .set('license_url', aAlbum.license_url)
      .set('download',
           'http://www.jamendo.com/get/album/id/album/archiverestricted/redirect/' +
           aAlbum.id + '/?are=' + (config('dlOgg') ? 'ogg3': 'mp3'))
      .set('share_fb', 'http://www.facebook.com/sharer.php?u=' + aAlbum.url + '&t=' + aAlbum.name)
      .set('share_sn', (config('statusNet') || 'http://identi.ca') +
           '/index.php?action=newnotice&status_textarea=Listening to ' + aAlbum.artist_name + ' in ' +
           aAlbum.name + ' ' + aAlbum.url)
      .set('share_tw', 'http://twitter.com/share?url=' + aAlbum.url +
           '&hashtags=jamendo' + //&via=jPlay
           '&text=Listening to ' + aAlbum.artist_name + ' in ' + aAlbum.name);

    var container = $get('album-siblings');
    if(!container.children.length || old(container.children[0])) {
      while(container.children.length)
        container.removeChild(container.children[0]);

      if(this.siblings[aAlbum.artist_id]) {
        var list = this.siblings[aAlbum.artist_id];
        var fragment = document.createDocumentFragment();
        for(var i = 0; i < list.length; i++)
          fragment.appendChild(list[i].ui.preview);
        container.appendChild(fragment);
      }
      else {
        jamendo.albumsOf(aAlbum.artist_id, function (aReq) {
          var list = JSON.parse(aReq.responseText);
          albums.append(list, lists.extras, aAlbum.artist_id);

          if($get('album-header').getAttribute('artist_id') == aAlbum.artist_id)
            albums.show(aAlbum);
        });
      }
    }

    container = $get('album-tracks');
    if(!container.children.length || old(container.children[0])) {
      while(container.children.length > 0)
        container.removeChild(container.children[0]);

      if(aAlbum.tracks) {
        var tracks = aAlbum.tracks;
        var fragment = document.createDocumentFragment();
        var makeItem = function(item) {
          var elm = ui.trackitem();
          elm.set('name', item.name)
             .set('stream', item.stream)
             .set('duration', item.durationS)
             .set('album', aAlbum.id)
             .set('artist', aAlbum.artist);

          elm.addEventListener('click', function (evt) { ui.onClickTrack(evt, item, aAlbum) }, false);
          fragment.appendChild(elm);
        };
        for(var i = 0; i < tracks.length; i++)
          makeItem(tracks[i]);
        $get('album-tracks').appendChild(fragment);
      }
      else
        jamendo.album(aAlbum.id);
    }
  },
}



function RequestGet (aURL, onSuccess, onFail) {
  var r = new XMLHttpRequest();
  if(!r)
    alert("Your navigator sucks. Try with a newer one, like Firefox");

  var req = this;
  r.onreadystatechange = function () {
    if(r.readyState != 4)
      return;

    if(r.status === 200 || r.status === 0)
      onSuccess(r);
    else if(onFail)
      onFail(r);
  }

  r.open('GET', aURL, true);
  r.send();
}



const JamendoAlbumR = 'http://api.jamendo.com/get2/id+name+url+image+artist_id+artist_name+artist_url+license_url/album/json/';

var jamendo = {

  _rq: function (aReq, aList, onLoad) {
    if(aList.loading)
      return;
    aList.loading = true;

    if(aList.count)
      aReq += '&pn=' + (aList.count / 50 + 1);
    RequestGet(aReq, function (aRq) {
                aList.loading = false;

                try {
                  album = JSON.parse(aRq.responseText);
                }
                catch(e){
                  return;
                }

                albums.append(JSON.parse(aRq.responseText), aList);
                if(onLoad)
                  onLoad();
              });
  },


  favorite: function () {
    var user = config('starUser');

    if(!user || !user.length)
      return;
    //lists.favorite.clear();

    jamendo._rq(JamendoAlbumR + 'album_artist+artist_user_starred/?user_idstr=' + user + '&n=50&order=releasedate_desc',
      lists.favorite
      /*, FIXME: how to deal autoload with the following code ?
      function () {
        jamendo._rq(JamendoAlbumR + 'album_user_starred/?user_idstr=' + user + '&n=all', lists.favorite);
      }*/);
  },

  popular: function (aAppend) {
    jamendo._rq(JamendoAlbumR + '?n=50&order=ratingweek_desc', lists.popular);
  },

  latest: function () {
    jamendo._rq(JamendoAlbumR + '?n=50&order=releasedate_desc', lists.latest);
  },

  search: function (aSearch) {
    if(!aSearch) {
      if(!this._search)
        return;
      aSearch = this._search;
    }
    jamendo._rq(JamendoAlbumR + '?n=50&order=searchweight_desc&searchquery=' + aSearch,
                 lists.search);
    this._search = aSearch;
  },

  album: function (aId, aCallback) {
    RequestGet('http://api.jamendo.com/get2/id+name+stream+duration/track/json/?album_id=' +
                 aId + '&streamencoding=' + (config('playOgg') ? 'ogg2' : 'mp3') +
                 '&order=numalbum_asc',
              function (aReq) {
                var album = albums.albums[aId];
                if(!album)
                  return;
                album.tracks = JSON.parse(aReq.responseText);

                var tracks = album.tracks;
                for(i = 0; i < tracks.length; i++) {
                  var item = tracks[i];
                  item.album = album.id;
                  if(!item.durationS)
                    item.durationS = secondsToString(item.duration);
                }

                if($get('album-header').getAttribute('album') == aId)
                  albums.show(album);
                if(aCallback)
                  aCallback(aReq, album);
              });
  },

  albumsOf: function (aArtist, aOnSuccess, aOnFail) {
    RequestGet(JamendoAlbumR + '?artist_id=' + aArtist + '&n=all&order=releasedate_desc',
               aOnSuccess, aOnFail);
  },
}


