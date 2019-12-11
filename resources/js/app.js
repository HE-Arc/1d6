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

if (localStorage.getItem("apiToken") != null) {
    axios.defaults.headers.common = { "Authorization": `Bearer ${localStorage.getItem("apiToken")}` }
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

// Middleware
import auth from "./middleware/auth.js"

// Available vue routes
const routes = [
    {
        name: 'home',
        path: '/',
        component: IndexPage,
        meta: {
            middleware: auth
        }
    },
    {
        name: 'poll',
        path: '/poll',
        component: PollPage,
        meta: {
            middleware: auth
        }
    },
    {
        name: 'create-poll',
        path: '/create-poll',
        component: CreatePollPage,
        meta: {
            middleware: auth
        }
    },
    {
        name: 'groups',
        path: '/groups',
        component: GroupsPage,
        meta: {
            middleware: auth
        }
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

const router = new VueRouter({ mode: 'history', routes: routes });

// Based on https://markus.oberlehner.net/blog/implementing-a-simple-middleware-with-vue-router/
// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    // If no subsequent Middleware exists,
    // the default `next()` callback is returned.
    if (!subsequentMiddleware) return context.next;

    return (...parameters) => {
        // Run the default Vue Router `next()` callback first.
        context.next(...parameters);
        // Then run the subsequent Middleware with a new
        // `nextMiddleware()` callback.
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({ ...context, next: nextMiddleware });
    };
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];

        const context = {
            from,
            next,
            router,
            to,
        };
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({ ...context, next: nextMiddleware });
    }

    return next();
});

const app = new Vue(Vue.util.extend({ router })).$mount('#app');