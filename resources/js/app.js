/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
const vuetify = new Vuetify()
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
Vue.use(Vuetify);
Vue.use(TiptapVuetifyPlugin, {
	// the next line is important! You need to provide the Vuetify Object to this place.
	vuetify, // same as "vuetify: vuetify"
	// optional, default to 'md' (default vuetify icons before v2.0.0)
	iconsGroup: 'md'
  })

Vue.prototype.trans = string => _.get(window.i18n, string);
import Multiselect from 'vue-multiselect'

import swal from 'sweetalert';
import summernote from './summernote/summernote-bs4.min.js';
import moment from 'moment'

Vue.prototype.moment = moment
/**
 * Global filters
 */

Vue.filter('currency', function (value) {
    return '€ ' + parseFloat(value).toFixed(2);
});

Vue.filter('percent', function (value) {
    return parseFloat(value).toFixed(2) + '%';
});
Vue.filter('capitalize', function (s) {
        if (typeof s !== 'string') return ''
        return s.charAt(0).toUpperCase() + s.slice(1)
});

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('multiselect',Multiselect);
Vue.component('course-module', require('./components/CourseModuleComponent.vue').default);
Vue.component('module-content', require('./components/ModuleContentComponent').default);
Vue.component('mass-emails', require('./components/MassEmailsComponent').default);
Vue.component('workshop', require('./components/WorkshopComponent').default);
Vue.component('workshop-edit', require('./components/WorkshopEditComponent').default);
Vue.component('document-create', require('./components/DocumentComponent').default);
Vue.component('document-edit', require('./components/DocumentEditComponent').default);
Vue.component('document-categories', require('./components/DocumentCategoriesComponent').default);
Vue.component('document-list', require('./components/DocumentListComponent').default);
Vue.component('corsi-table', require('./components/CorsiTableComponent').default);
Vue.component('struture-create', require('./components/AddStrutureComponent').default);
Vue.component('struture-edit', require('./components/EditStrutureComponent').default);
Vue.component('structure-view', require('./components/StructureViewComponent').default);
Vue.component('utenti-create', require('./components/UtentiCreateComponent').default);
Vue.component('utenti-view', require('./components/UtentiViewComponent').default);
Vue.component('utenti-basic-create', require('./components/BasicUserCreateComponent').default);
Vue.component('add-discount', require('./components/AddDiscountComponent').default);
Vue.component('structure-details', require('./components/StructureDetailsComponent').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
	vuetify: new Vuetify({
		theme: {
			themes: {
				light: {
					primary: '#388e3c',
				},
			},
		},
	})
});
