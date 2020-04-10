import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'materialize-css/dist/js/materialize.min.js';
import Axios from 'axios';
import AuthModule from '@/libs/AuthModule'
import 'materialize-css/dist/js/materialize.min.js';

Axios.defaults.withCredentials = true;
Vue.prototype.$http = Axios;
//Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
