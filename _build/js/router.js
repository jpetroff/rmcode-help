w.Router = {
	pageContainer: '#app-page',
	init: function () {
		w.currentPage = new Vue(w.Page());
		w.currentPage.$mount(this.pageContainer);
	},
	changePage: function(url) {
		console.log(url);
		var pagePath = this.getPageFromURL(url);


		w.currentPage.$el.dataset.transition = 1;

		w.utils.ajax({
			method: 'GET',
			url: 'http://rm.local/api/page/' + pagePath
		}).then(_.bind(this.showPage, this));
	},
	getPageFromURL: function(_url) {
		var url = null;
		var pagePath = '/';

		if (_url && typeof _url.href == 'string') {
			url = _url;
			pagePath = w.utils.untrailingslashit(url.pathname.replace( w._home_url.pathname, ''));
		} else {
			url = document.createElement('a');
			url.href = _url;
			pagePath = w.utils.untrailingslashit(url.pathname.replace( w._home_url.pathname, ''));
		}

		return pagePath || '/';
	},
	showPage: function(data) {
		w.currentPage.$el.innerHTML = data;
		w.currentPage.$el.dataset.transition = 0;
		w.currentPage.$destroy();
		this.init();
	}
}

Router.init();