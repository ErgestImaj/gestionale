/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./globalService');
window.Vue = require('vue');
import injector from 'vue-inject'
import Vuetify from 'vuetify'
const vuetify = new Vuetify();
import { TiptapVuetifyPlugin } from 'tiptap-vuetify';

Vue.use(Vuetify);
Vue.use(injector);
Vue.use(TiptapVuetifyPlugin, {
	// the next line is important! You need to provide the Vuetify Object to this place.
	vuetify, // same as "vuetify: vuetify"
	// optional, default to 'md' (default vuetify icons before v2.0.0)
	iconsGroup: 'md'
  });

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
        if (typeof s !== 'string') return '';
        return s.charAt(0).toUpperCase() + s.slice(1)
});

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('multiselect',Multiselect);
Vue.component('course-module', require('./components/course/CourseModuleComponent.vue').default);
Vue.component('add-course', require('./components/course/CourseCreateComponent.vue').default);
Vue.component('course-categories', require('./components/course/CourseCategoryComponent.vue').default);
Vue.component('module-list', require('./components/module/ModuleListComponent.vue').default);
Vue.component('add-lms', require('./components/lms/AddLmsComponent').default);
Vue.component('view-lms', require('./components/lms/LmsViewComponent').default);
Vue.component('list-lms', require('./components/lms/LmsListComponent').default);
Vue.component('mass-emails', require('./components/MassEmailsComponent').default);
Vue.component('workshop', require('./components/workshop/WorkshopComponent').default);
Vue.component('workshop-edit', require('./components/workshop/WorkshopEditComponent').default);
Vue.component('document-create', require('./components/document/DocumentComponent').default);
Vue.component('document-edit', require('./components/document/DocumentEditComponent').default);
Vue.component('document-categories', require('./components/document/DocumentCategoriesComponent').default);
Vue.component('document-list', require('./components/document/DocumentListComponent').default);
Vue.component('corsi-table', require('./components/course/CorsiTableComponent').default);
Vue.component('struture-create', require('./components/structure/AddStrutureComponent').default);
Vue.component('struture-edit', require('./components/structure/EditStrutureComponent').default);
Vue.component('structure-view', require('./components/structure/StructureViewComponent').default);
Vue.component('utenti-create', require('./components/users/UtentiCreateComponent').default);
Vue.component('utenti-edit', require('./components/users/UtentiEditComponent').default);
Vue.component('utenti-view', require('./components/users/UtentiViewComponent').default);
Vue.component('utenti-basic-create', require('./components/users/BasicUserCreateComponent').default);
Vue.component('utenti-basic-edit', require('./components/users/BasicUserEditComponent').default);
Vue.component('add-discount', require('./components/structure/AddDiscountComponent').default);
Vue.component('structure-details', require('./components/structure/StructureDetailsComponent').default);
Vue.component('user-details', require('./components/users/UserDetailsComponent').default);
Vue.component('sessione-essame-create', require('./components/sessione-esame/CreateComponent').default);
Vue.component('sessione-essame-list', require('./components/sessione-esame/ListComponent').default);
Vue.component('tracking-list', require('./components/tracking/ListComponent').default);
Vue.component('tracking-create', require('./components/tracking/CreateComponent').default);
Vue.component('tracking-edit', require('./components/tracking/EditComponent').default);
Vue.component('certificate-list', require('./components/certificate/ListComponent').default);
Vue.component('elenco-ordini', require('./components/orders/ElencoOrdiniComponent').default);
Vue.component('ordini-fast-track', require('./components/orders/OrdiniFastTrackComponent').default);
Vue.component('ordini-structure', require('./components/orders/OrdiniStructureComponent').default);
Vue.component('electronic-invoice', require('./components/orders/ElectronicInvoiceComponent').default);


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
