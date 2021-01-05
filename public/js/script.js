vmdata.search = {
	description: '',
	num_bedrooms: '',
	property_type_id: '',
    min_price: '',
    max_price: '',
    page: 1,
};

var vm = new Vue({
	el: '#app',
	data: vmdata,
	methods: {
		debouncedSearch: function() {
			var self = this;
			axios.get(window.location.href, {
				params: this.search
			}).then(function (response) {
				self.properties = response.data.properties;
				self.pagination = response.data.pagination;
			});
		},
		getPropertyUrl: function(id) {
			return "/admin/property/" + id;
		}
	},
	watch: {
		search: {
			handler: _.debounce(function(e) {
				this.debouncedSearch();
			}, 200),
			deep: true
		}
	}
});
