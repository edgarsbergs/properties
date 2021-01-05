vmdata.search = {
	description: '',
	num_bedrooms: '',
	property_type_id: '',
	price: '',
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