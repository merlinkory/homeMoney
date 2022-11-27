import './bootstrap';
import {createApp} from 'vue';
import *  as VueRouter from 'vue-router';
// import BootstrapVue3 from 'bootstrap-vue-3'

// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

// element plus
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import CostList from './components/CostList.vue';
import CostForm from './components/CostForm.vue';

const routes = [
    {path: '/', component: CostList},
    {path: '/create', component: CostForm},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/clientarea'),
    routes
})

import App from './components/App.vue';

createApp(App).use(ElementPlus).use(router).mount("#app");
