import { createStore } from "vuex";
const store = createStore({
    state: {
        Auth: null,
        Guest: null,
        AccessToken: null,
        website: null,
        AllGroup: null,
        CartData: [],
    },
    getters: {
        GetAuth: function (state) {
            if (state.Auth == null) {
                return JSON.parse(localStorage.getItem("userInfoFront"));
            }
            return state.Auth;
        },
        GetGuest: function (state) {
            if (state.Guest == null) {
                return JSON.parse(localStorage.getItem("guestInfo"));
            }
            return state.Guest;
        },
        GetAccessToken(state) {
            if (state.AccessToken == null) {
                return localStorage.getItem("ecommerce_user_access_token");
            }
            return state.AccessToken;
        },
        GetWebsite(state) {
            if (state.website == null) {
                return JSON.parse(localStorage.getItem("website_settings"));
            }
            return state.website;
        },
        GetCartData(state) {
            if (state.CartData.length == 0) {
                return JSON.parse(localStorage.getItem("CartData"));
            }
            return state.CartData;
        },
    },
    mutations: {
        PutAuth(state, data) {
            localStorage.setItem("userInfoFront", JSON.stringify(data));
            state.Auth = data;
        },
        PutGuest(state, data) {
            localStorage.setItem("guestInfo", JSON.stringify(data));
            state.Guest = data;
        },
        PutAccessToken(state, data) {
            localStorage.setItem('ecommerce_user_access_token', data);
            state.AccessToken = data;
        },
        PutWebsite(state, data) {
            localStorage.setItem('website_settings', JSON.stringify(data));
            state.website = data;
        },
        PutCartData(state, data) {
            localStorage.setItem('CartData', JSON.stringify(data));
            state.CartData = data;
        },
    },
    actions: {
        Logout: function () {
            localStorage.removeItem('ecommerce_user_access_token');
            window.location.reload();
        },
        removeGuest: function () {
            localStorage.removeItem('guestInfo');
            this.Guest = null
        }
    },
});
export default store;
