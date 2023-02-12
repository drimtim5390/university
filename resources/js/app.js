import Vue from 'vue'
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'
import axios from 'axios'
import ElementUI from 'element-ui'
/* eslint-disable */
import './assets/elements-variable.scss'
import locale from 'element-ui/lib/locale/lang/en'
import router from './router'
import App from './App.vue'

Vue.config.productionTip = false
Vue.use(ElementUI, {locale})
Vue.use(VueRouter)

Vue.use(VueAxios, axios)

new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
})
