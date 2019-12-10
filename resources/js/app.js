// App.js

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';

if(localStorage.getItem("apiToken") != null) {
    axios.defaults.headers.common = {'Authorization': `Bearer ${localStorage.getItem("apiToken")}`}
}

// Layouts
Vue.component('default-layout', require('./layouts/default.vue').default);
Vue.component('login-layout', require('./layouts/login.vue').default);

// Pages
import IndexPage from "./components/pages/index.vue"
import LoginPage from "./components/pages/login.vue"
import CreatePollPage from "./components/pages/create-poll.vue"
import PollPage from "./components/pages/poll.vue"
import RegisterPage from "./components/pages/register.vue"
import GroupsPage from "./components/pages/groups.vue"

// Available vue routes
const routes = [
    {
        name: 'home',
        path: '/',
        component: IndexPage
    },
    {
        name: 'poll',
        path: '/poll',
        component: PollPage
    },
    {
        name: 'create-poll',
        path: '/create-poll',
        component: CreatePollPage
    },
    {
        name: 'groups',
        path: '/groups',
        component: GroupsPage
    },
    {
        name: 'login',
        path: '/login',
        component: LoginPage
    },
    {
        name: 'register',
        path: '/register',
        component: RegisterPage
    }
  ];
  

const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue(Vue.util.extend({ router })).$mount('#app');