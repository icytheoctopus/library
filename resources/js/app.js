require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

import HomeComponent from './components/HomeComponent';
import AuthorsComponent from "./components/Authors/AuthorsComponent";
import CreateAuthorComponent from "./components/Authors/CreateAuthorComponent";
import EditAuthorComponent from "./components/Authors/EditAuthorComponent";

import BooksComponent from "./components/Books/BooksComponent";
import CreateBookComponent from "./components/Books/CreateBookComponent";
import EditBookComponent from "./components/Books/EditBookComponent";

const routes = [
    {
        name: 'home',
        path: '/',
        component: HomeComponent
    },
    {
        name: 'authors',
        path: '/authors',
        component: AuthorsComponent
    },
    {
        name: 'create-author',
        path: '/author/create',
        component: CreateAuthorComponent
    },
    {
        name: 'edit-author',
        path: '/author/edit/:id',
        component: EditAuthorComponent
    },
    {
        name: 'books',
        path: '/books',
        component: BooksComponent
    },
    {
        name: 'create-book',
        path: '/book/create',
        component: CreateBookComponent
    },
    {
        name: 'edit-book',
        path: '/books/edit/:id',
        component: EditBookComponent
    }
];

const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');
