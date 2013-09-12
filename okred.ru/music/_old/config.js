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

function config (aKey, aValue) {
  if(config.arguments.length > 1) {
      localStorage.setItem(aKey, aValue);
    return aValue;
  }
  return localStorage.getItem(aKey);
}


config.setString = function (aKey, aValue) {
  if(aValue.length && aValue != '')
    config(aKey, aValue);
  else
    config.remove(aKey);
}

config.remove = function (aKey) {
  localStorage.removeItem(aKey);
}

config.init = function () {
  var defaultTab;

  if(!localStorage.length) {
    config('playOgg', 'true');
    config('dlOgg', 'true');
    config('savePl', 'true');
    config('defaultTab', 'tab-popular');
    defaultTab = 'tab-configure';
  }
  else {
    defaultTab = config('defaultTab') || 'tab-popular';
    var list = defaultTab.substr(4);

    if(lists[list])
      albums.list = lists[list];
  }

  $get('config-play').checked = config('playOgg');
  $get('config-dl').checked = config('dlOgg');
  $get('config-save-pl').checked = config('savePl');
  $get('config-staruser').value = config('starUser') || '';
  $get('config-statusnet').value = config('statusNet') || '';
  $get('config-defaulttab').value = config('defaultTab');

  ui.notebook.select($get(defaultTab));
}

