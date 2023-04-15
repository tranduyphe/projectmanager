require('./bootstrap');
import { createApp } from 'vue';
import App from './App.vue';
import BootstrapVueNext from 'bootstrap-vue-next';
import VueDatePicker from '@vuepic/vue-datepicker';
import VueApexCharts from "vue3-apexcharts";
import '@vuepic/vue-datepicker/dist/main.css';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import router from './router/index';
import VueAxios from 'vue-axios';
import axios from 'axios';
import { store } from './store/store';
import "@/assets/scss/app.scss"; 
const app = createApp(App);
app.provide('publicPath', PUBLIC_PATH);
app.use(VueAxios, axios);
app.use(VueApexCharts);
app.use(store);
app.use(BootstrapVueNext);
app.component('VueDatePicker', VueDatePicker);
app.use(router).mount('#app');