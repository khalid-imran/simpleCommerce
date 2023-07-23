import {createApp} from 'vue';
require('../bootstrap');

import App from './App.vue';
import router from "./Router/router";
import store from "./Store/store";
import FloatingVue from 'floating-vue'
import 'floating-vue/dist/style.css'
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.css"

const app = createApp(App);
app.use(store);
app.use(router);
app.use(FloatingVue, {
    themes: {
        'tooltip': {
            delay: { show: 0, hide: 0 },
        },
    },
});
app.use(ToastPlugin,  { position: "top-right"});
app.component('flat-pickr', flatPickr);
app.component('multiselect', Multiselect)
app.mixin({
    methods: {
        formatPrice: function(value) {
            let formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2,
                currencySign: 'accounting'
            });
            let str =  formatter.format(value);
            let replace = str.replace('$', ' ');
            return replace;
        },
        sortASC: function(array) {
            return array.sort(function(a, b) {
                return a.id - b.id;
            });
        },
        makeFormData: function (object) {
            let formData = new FormData()
            for (const property in object) {
                if (object[property]){
                    if (typeof object[property] === 'object' && property !== 'image' && property !== 'signature') {
                        if (Array.isArray(object[property]))  {
                            object[property].map((value, index) => {
                                for (const ArrProperty in value) {
                                    formData.append(property+'['+index+']['+ArrProperty+']', value[ArrProperty])
                                }
                            })
                        } else {
                            for (const childProperty in object[property]) {
                                if (object[property][childProperty]){
                                    formData.append(property+'['+childProperty+']', object[property][childProperty])
                                }
                            }
                        }
                    } else if (typeof object[property] === 'object' && (property === 'image' || property === 'signature'))  {
                        formData.append(property, object[property])
                    } else {
                        formData.append(property, object[property])
                    }
                }
            }
            return formData
        },
        resetPasswordIcon: function () {
            let eye = $('.eye');
            eye.find('.feather-eye').removeClass('d-block').addClass('d-none');
            eye.find('.feather-eye-off').removeClass('d-none').addClass('d-block');
        },
        showPassword: function (event) {
            let node = $(event.target).closest('.input-password');
            let input = node.find('input');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text')
            } else {
                input.attr('type', 'password')
            }
            let eye = node.find('.d-block');
            let eyeClose = node.find('.d-none');
            eye.removeClass('d-block').addClass('d-none')
            eyeClose.removeClass('d-none').addClass('d-block')
        },
        isDataExist: function (modelValue, matchKey, index, data) {
            let found = 0;
            data.map(v => {
                if (v[matchKey] ===  modelValue) {
                    found++;
                }
            })
            if (found > 1) {
                data[index][matchKey] = ''
                this.$toast.error('You already select this item')
            }
        },
        splice: function (index, array) {
            array.splice (index, 1)
        },
        years: function (startYear) {
            let years = [];
            for (let i = startYear; i < new Date().getFullYear()+5; i++) {
                years.push({ id:i, name: i})
            }
            return years
        },
        months: function () {
            return [
                {id: 1, name: 'January'},
                {id: 2, name: 'February'},
                {id: 3, name: 'March'},
                {id: 4, name: 'April'},
                {id: 5, name: 'May'},
                {id: 6, name: 'June'},
                {id: 7, name: 'July'},
                {id: 8, name: 'August'},
                {id: 9, name: 'September'},
                {id: 10, name: 'October'},
                {id: 11, name: 'November'},
                {id: 12, name: 'December'},
            ]
        },
        capitalizeFirstLetter: function (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        structureReturnData: function (proxy) {
            let id = []
            if (!Array.isArray(proxy)) {
                const data = {...proxy};
                id.push(data.id)
            } else {
                id = [...proxy];
            }
            return id
        },
    }
});
app.mount('#app');
