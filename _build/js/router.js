w.Router = {
	pageContainer: '#app-page',
	url: null,
	isFront: false,
	asyncLoadStarted: false,
	pageTransitionStarted: false,
	pageData: null,
	init: function() {
		w.addEventListener('popstate', _.bind(function(ev){
			this.changePage(w.location, true);
		}, this), false);

		this.parse_url(w.location, true);
		w.rmSearch.presentation.isFront = this.isFront;
		w.rmSearch.$mount('#search-component-vue');
		this.initPage();
	},
	initPage: function () {
		w.currentPage = new Vue(w.Page());
		w.currentPage.$mount(this.pageContainer);
		w.currentPage.$el.dataset.visible = true;
		w.currentPage.scrollAnimationStarted = true;
		if(w.currentPage.navElements.length > 0) {
			w.addEventListener('scroll', this.passScrollParams);
		}

		_.delay( function() {w.currentPage.localLink(w.Router.url.hash)}, 1);
	},
	changePage: function(url, skipUpdate) {
		var needChange = this.parse_url(url, skipUpdate);

		w.rmSearch.presentation.isFront = this.isFront;

		if(this.url.isLocal) {
			w.currentPage.localLink(this.url.hash);
		} else if(needChange) {
			this.asyncLoadStarted = true;

			w.utils.updateDOM(this.hidePage, this);

			w.utils.ajax({
				method: 'GET',
				url: w._home_url + 'api/page/' + (this.isFront ? '_front' : this.url.relPath) + '/'
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

		if(this.url && this.url.location && this.url.location == url.href) {
			console.log('skip parsing – same URL');
			return false;
		}

		var isLocal = this.url && this.url.path && this.url.path == url.pathname;

		this.url = {
			location: url.href,
			home: w._home_url.href,
			path: url.pathname,
			relPath: w.utils.untrailingslashit( url.pathname.replace( w._home_url.pathname, '') ),
			query: url.search.replace('?', ''),
			hash: url.hash.replace('#', ''),
			isLocal: isLocal
		}

		if(!skipUpdate) w.history.pushState(null, null, this.url.path + (this.url.hash != '' ? '#' + this.url.hash : '') );

		if (this.url.relPath == '') {
			this.isFront = true;
			document.title = w._site_title;
		} else {
			this.isFront = false;
		}

		return true;
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
		w.removeEventListener('scroll', this.passScrollParams);
		w.currentPage.$el.dataset.visible = false;
		w.utils.scrollTop(0, false);
		this.pageTransitionStarted = true;
		w.currentPage.$el.addEventListener(w.utils.transitionName,
			_.bind(function() {
				this.pageTransitionStarted = false;
				this.showNewPage();
			}, this)
		)
	},
	updateUrl: function( path, _hash, title ) {
		path = path || this.url.path;
		var hash = _hash != '' ? '#'+_hash : '';
		title = title != '' ? title+' — '+w._site_title : w._site_title;

		w.history.replaceState( null, title, path+hash );
		document.title = title;
		this.url.location = w.location.href;
		this.url.path = w.location.pathname;
		this.url.relPath = w.utils.untrailingslashit( w.location.pathname.replace( w._home_url.pathname, '') );
		this.url.query = w.location.search.replace('?', '');
		this.url.hash = w.location.hash.replace('#', '');
	},
	passScrollParams: function() {
		w.currentPage && w.currentPage.scrollSpy();
	}
}

Router.init();