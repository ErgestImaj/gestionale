/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import select2 from 'select2';


window.Vue = require('vue');

Vue.prototype.trans = string => _.get(window.i18n, string);
import Multiselect from 'vue-multiselect'


import swal from 'sweetalert';
import summernote from './summernote/summernote-bs4.min.js';

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


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

});
