import injector from 'vue-inject';
class GlobalService{
	tableConfig() {
		return {
			footerProps: {
				itemsPerPageOptions: [25, 50, 100, 500, 1000, {"text":"All","value":-1}]
			}
		};
	}
}
injector.service('globalService', GlobalService);
