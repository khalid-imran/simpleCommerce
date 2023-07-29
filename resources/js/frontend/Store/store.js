import { createStore } from "vuex";
const store = createStore({
    state: {
        Auth: null,
        AccessToken: null,
        website: null,
        AllGroup: null,
    },
    getters: {
        GetAuth: function (state) {
            if (state.Auth == null) {
                return JSON.parse(localStorage.getItem("userInfoFront"));
            }
            return state.Auth;
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
    },
    mutations: {
        PutAuth(state, data) {
            localStorage.setItem("userInfoFront", JSON.stringify(data));
            state.Auth = data;
        },
        PutAccessToken(state, data) {
            localStorage.setItem('ecommerce_user_access_token', data);
            state.AccessToken = data;
        },
        PutWebsite(state, data) {
            localStorage.setItem('website_settings', JSON.stringify(data));
            state.website = data;
        },
    },
    actions: {
        Logout: function () {
            localStorage.removeItem('ecommerce_user_access_token');
            window.location.reload();
        }
    },
});
export default store;
