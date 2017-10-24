w.rmSearch = new Vue({
	data: {
		query: '',
		results: []
	},
	created: function() {
	},
	methods: {
		queryInput: function(val) {
			console.log(val);
			this.query = val;
			this.requestResults();
		},
		requestResults: _.debounce(
			function () {
				w.utils.ajax({
					url: 'http://rm.local/wp-admin/admin-ajax.php',
					method: 'POST',
					data: {
						action: 'search',
						query: this.query
					}
				}).then(_.bind(
						function(data) {
							this.results = JSON.parse(data);
							console.log(this.results);
						},
						this
					)
				)
			},
			// This is the number of milliseconds we wait for the
			// user to stop typing.
			500
		)
	}
});

w.rmSearch.$mount('#search-component-vue');