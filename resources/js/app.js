require('./bootstrap');
window.Vue = require('vue').default;

// import
import VueRouter from 'vue-router'
import  Form from 'vform'
import {routes} from './routes'
import store from './store'

import Multiselect from 'vue-multiselect'

// use
Vue.use(VueRouter);
window.Form=Form;
Vue.component('multiselect', Multiselect)



const router = new VueRouter({
    mode:'history',
    routes
})


const app = new Vue({
    el: '#app',
    router,
    store
});


export{app}