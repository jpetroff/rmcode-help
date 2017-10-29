w.Router = {
	pageContainer: '#app-page',
	url: null,
	isFront: false,
	asyncLoadStarted: false,
	pageTransitionStarted: false,
	pageData: null,
	init: function() {
		this.parse_url(w.location, true);
		w.rmSearch.presentation.isFront = this.isFront;
		w.rmSearch.$mount('#search-component-vue');
		this.initPage();
	},
	initPage: function () {
		w.currentPage = new Vue(w.Page());
		w.currentPage.$mount(this.pageContainer);
		w.currentPage.$el.dataset.visible = true;

		_.delay( function() {w.currentPage.localLink(w.Router.url.hash)}, 1);
		// document.addEventListener("DOMContentLoaded", function(event) {
		//
		// });
	},
	changePage: function(url) {
		this.parse_url(url);
		w.rmSearch.presentation.isFront = this.isFront;

		if(this.url.isLocal) {
			w.currentPage.localLink(this.url.hash);
		} else {
			this.asyncLoadStarted = true;

			w.utils.updateDOM(this.hidePage, this);

			w.utils.ajax({
				method: 'GET',
				url: 'http://rm.local/api/page/' + (this.isFront ? '_front' : this.url.relPath)
			}).then(_.bind(function(data) {
				this.asyncLoadStarted = false;
				this.pageData = data;
				this.showNewPage();
			}, this));
		}
	},
	parse_url: function(_url, skipUpdate) {
		var url = null;

		if (_url && typeof _url.href == 'string') {
			url = _url;
		} else {
			url = document.createElement('a');
			url.href = _url;
		}

		this.url = {
			location: url.href,
			home: w._home_url.href,
			path: url.pathname,
			relPath: w.utils.untrailingslashit( url.pathname.replace( w._home_url.pathname, '') ),
			query: url.search.replace('?', ''),
			hash: url.hash.replace('#', ''),
			isLocal: (w.location.pathname == url.pathname)
		}

		if(!skipUpdate) history.pushState(null, null, this.url.path + (this.url.hash != '' ? '#' + this.url.hash : '') );

		if (this.url.relPath == '') {
			this.isFront = true;
		} else {
			this.isFront = false;
		}
	},
	showNewPage: function(data) {
		if(this.pageTransitionStarted || this.asyncLoadStarted) return;

		w.utils.updateDOM(function() {
			w.currentPage.$el.innerHTML = this.pageData;
			w.currentPage.$destroy();
			this.initPage();
		}, this);
	},
	hidePage: function() {
		w.currentPage.$el.dataset.visible = false;
		w.utils.scrollTop(0, false);
		this.pageTransitionStarted = true;
		w.currentPage.$el.addEventListener(w.utils.transitionName,
			_.bind(function() {
				this.pageTransitionStarted = false;
				this.showNewPage();
			}, this)
		)
	}
}

Router.init();