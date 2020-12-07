require('./bootstrap');

import Vuex from 'vuex'
import router from './router'
import store from './store'
import postApp from './postApp.vue'

// Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);

new Vue({
    router,
    store,
    render: h => h(postApp)
}).$mount('#post');
