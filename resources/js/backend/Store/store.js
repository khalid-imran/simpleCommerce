import { createStore } from "vuex";
const store = createStore({
    state: {
        Auth: null,
        AccessToken: null,
        AllClasses: null,
        AllGroup: null,
    },
    getters: {
        GetAuth: function (state) {
            if (state.Auth == null) {
                return JSON.parse(localStorage.getItem("userInfo"));
            }
            return state.Auth;
        },
        GetAccessToken(state) {
            if (state.AccessToken == null) {
                return localStorage.getItem("ecommerce_access_token");
            }
            return state.AccessToken;
        },
    },
    mutations: {
        PutAuth(state, data) {
            localStorage.setItem("userInfo", JSON.stringify(data));
            state.Auth = data;
        },
        PutAccessToken(state, data) {
            localStorage.setItem('ecommerce_access_token', data);
            state.AccessToken = data;
        },
    },
    actions: {
        Logout: function () {
            localStorage.removeItem('ecommerce_access_token');
            window.location.reload();
        }
    },
});
export default store;
