require('./bootstrap');
import { createApp } from 'vue';
import App from './App.vue';
import BootstrapVueNext from 'bootstrap-vue-next';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
// import { BootstrapVue } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
// import 'bootstrap-vue/dist/bootstrap-vue.css';
import "bootstrap";
import router from './router/index';
import VueAxios from 'vue-axios';
import axios from 'axios';
import { store } from './store/store';
import "@resources/assets/scss/app.scss"; 
const app = createApp(App);
app.use(VueAxios, axios);
app.use(store);
app.use(BootstrapVueNext);
app.component('VueDatePicker', VueDatePicker);
app.use(router).mount('#app');