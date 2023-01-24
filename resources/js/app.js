/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import App from './src/views/App'
import router from './src/routes'
import store from './src/store'
import axios from 'axios'

import {
    rules
} from './src/utils/rules'
import {
    dateFormat
} from './src/utils/date_format'
import {
    auth
} from './src/utils/auth'
import {
    transformCase
} from './src/utils/transform_case'
import {
    path
} from './src/utils/path'

import Vuex from 'vuex'

window.Vue = require('vue').default;

import vuetify from './src/plugins/vuetify'
import requestInterceptor from './src/api/interceptor'


//api
const axiosInstance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',
})

if (auth.token()) {
    axiosInstance.defaults.headers.common['Authorization'] = 'Bearer ' + auth.token();
}


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//global components
Vue.component('app-component', require('./src/views/App.vue').default)
Vue.component('Alert', require('./src/components/Alert.vue').default)
Vue.component('Loading', require('./src/components/Loading.vue').default)
Vue.component('DefaultTable', require('./src/components/data-table/DefaultTable.vue').default)
Vue.component('DefaultHeader', require('./src/components/data-table/DefaultHeader.vue').default)

Vue.prototype.$auth = auth
Vue.prototype.$path = path
Vue.prototype.$rules = rules
Vue.prototype.$axios = axiosInstance
Vue.prototype.$dateFormat = dateFormat
Vue.prototype.$transformCase = transformCase

Vuex.Store.prototype.$auth = auth
Vuex.Store.prototype.$path = path
Vuex.Store.prototype.$router = router
Vuex.Store.prototype.$axios = axiosInstance
Vuex.Store.prototype.$dateFormat = dateFormat
Vuex.Store.prototype.$transformCase = transformCase

requestInterceptor(axiosInstance, router)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router,
    store,
    vuetify
});
