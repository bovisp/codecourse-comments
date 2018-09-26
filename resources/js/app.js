import user from './mixins/user'
import pluralize from './mixins/pluralize'
import highlightjs from './directives/highlight'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('comments', require('./components/comments/Comments.vue')); 

Vue.mixin(user)
Vue.mixin(pluralize)

Vue.directive('highlightjs', highlightjs)

const app = new Vue({
    el: '#app'
});
