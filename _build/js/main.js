w.Page = function() {
	return {
		data: {
			test: ''
		},
		methods: {
			_testajax: function (link) {
				w.Router.changePage(link);
			}
		}
	}
}