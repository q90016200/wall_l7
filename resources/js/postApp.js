require('./bootstrap');

import Vuex from 'vuex'
import store from './store'
import post from './post.vue'

// Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);

new Vue({
    store,
    render: h => h(post)
}).$mount('#post');
