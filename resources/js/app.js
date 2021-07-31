/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');
 import VueRouter from 'vue-router'
 import routes from './routes'
 
 Vue.use(VueRouter)
 
 const router = new VueRouter(routes)
 
//  import Toaster from 'v-toaster'
//  // You need a specific loader for CSS files like https://github.com/webpack/css-loader
//  import 'v-toaster/dist/v-toaster.css'
//  // optional set default imeout, the default is 10000 (10 seconds).
//  Vue.use(Toaster, {timeout: 5000})
 
import Swal from 'sweetalert2'
 window.Swal = Swal

 

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const app = new Vue({
    el: '#app',
    router,
});
