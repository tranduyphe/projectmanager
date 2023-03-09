require('./bootstrap');
import { createApp } from 'vue';
 
import App from './App.vue';
import router from './router/index';
import VueAxios from 'vue-axios';
import axios from 'axios';
const app = createApp(App);
app.use(VueAxios, axios);
app.use(router).mount('#app');