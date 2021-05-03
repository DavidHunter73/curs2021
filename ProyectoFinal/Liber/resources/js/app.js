require('./bootstrap');
require('alpinejs');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import StarRating from 'vue-star-rating';
Vue.use(VueRouter);

import store from "./store";

import app from './components/App.vue';
import vue_example from './components/VueExample.vue';
import home from './components/Home.vue';
import book from './components/Book.vue';
import genre from './components/Genre.vue';
import login from './components/Login.vue';

Vue.component('star-rating', StarRating);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dhernandez/ProyectoFinal/Liber/public/',
            component: home
        },
        {
            path: '/dhernandez/ProyectoFinal/Liber/public/example/',
            component: vue_example
        },
        {
            path: '/dhernandez/ProyectoFinal/Liber/public/book/',
            component: book
        },
        {
            path: '/dhernandez/ProyectoFinal/Liber/public/genre/',
            component: genre
        },
        {
            path: '/dhernandez/ProyectoFinal/Liber/public/login/',
            component: login
        }
    ]
})

//Vue.component('pagination', require('laravel-vue-pagination'));

const appp = new Vue({
    el: '#app',
    components: { app },
    router,
    store
});