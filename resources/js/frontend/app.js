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
app.mixin({
    methods: {
        getPrice: function (product) {
            let price = parseInt(product.variants[0].price);
            let reduce_price = 0
            if(product.discount_type == 1){
                let discountAmount = parseInt(price) / 100 * parseInt(product.discount_amount)
                reduce_price = price - discountAmount;
            } else if (product.discount_type == 0){
                reduce_price = parseInt(price) - parseInt(product.discount_amount)
            } else {
                reduce_price = price
            }
            return {
                price: price,
                reduce_price: reduce_price
            }
        }
    }
})
