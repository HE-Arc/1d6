// App.js

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({ mode: 'history'});
const app = new Vue(Vue.util.extend({ router })).$mount('#app');