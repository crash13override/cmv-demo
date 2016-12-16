
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('select2', require('./components/Select2.vue'));
Vue.component('todo-list', require('./components/TodoList.vue'));
Vue.component('todo-form-inline', require('./components/TodoFormInline.vue'));
Vue.component('todo-form-excel', require('./components/TodoFormExcel.vue'));
Vue.component('todo-form-csv', require('./components/TodoFormCsv.vue'));

const app = new Vue({
    el: '#app',
    data: {
        cmv: window.cmv
    }
});
