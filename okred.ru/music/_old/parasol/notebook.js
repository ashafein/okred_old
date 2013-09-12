
parasol.widget.notebook = function (aTabs, aContainer) {
  this.container = aContainer;
  this.tabs = aTabs;

  var self = this;
  this.tabs.addEventListener('click', function (event) {
    self.onclick(event);
  }, true);
}

parasol.widget.notebook.prototype = {
  _current: null,

  onclick: function (event) {
    this.select(event.target);
  },

  select: function (tab) {
    if(!tab.hasAttribute('panel'))
      return;

    if(this._current) {
      this._current.style.display = 'none';
      this._current.removeAttribute('active');
      this._tab.removeAttribute('active');
    }

    var panel = document.getElementById(tab.getAttribute('panel'));
    panel.style.display = 'block';
    panel.setAttribute('active', 'true');
    tab.setAttribute('active', 'true');

    this._current = panel;
    this._tab = tab;
  },
}


