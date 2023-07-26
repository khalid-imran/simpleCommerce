import {createApp} from 'vue';
require('../bootstrap');

import App from './App.vue';
import router from "./Router/router";
import store from "./Store/store";
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';

const app = createApp(App);
app.use(store);
app.use(router);
app.use(ToastPlugin,  { position: "top-right"});
app.mount('#app');
