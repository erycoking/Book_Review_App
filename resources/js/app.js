
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router';
import Vuex from 'vuex';
import MainApp from './components/MainApp';
import Home from './components/Home.vue';
import Register from './components/auth/Register';
import Login from './components/auth/Login';
import Navbar from './components/Navbar.vue';
import Book from './components/Book.vue';
import StoreData from './store';
import { routes } from './routes';
import {initialize} from './helpers/initializer';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.use(Router);
Vue.use(Vuex);

const store = new Vuex.Store(StoreData);


const router = new Router({
    routes,
    mode: 'history'
});

initialize(store, router);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    components : {
        MainApp, Home, Book, Register, Login, Navbar
    }
});
