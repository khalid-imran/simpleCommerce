import axios from 'axios'
import store from '../Store/store';
let headers = {
    'Content-Type': 'application/json; charset=utf-8',
};
const access_token = store.getters.GetAccessTokenUser;
const ApiService = {
    POST: (url, param, callback, auth = false) => {
        headers['Authorization'] =  'Bearer '+access_token
        axios.post(url, param, {headers: headers}).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                store.dispatch('Logout');
            }
        })
    },
    GET: (url, callback, auth = false) => {
        headers['Authorization'] =  'Bearer '+access_token
        axios.get(url, {headers: headers}).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                store.dispatch('Logout');
            }
        })
    },
    DOWNLOAD: (url, param, headersAxios, callback, auth = false) => {
        headers['Authorization'] =  'Bearer '+access_token
        axios.post(url, param, {
            headers: headers,
            responseType: 'blob' }).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                store.dispatch('Logout');
            }
        })
    },
    UPLOAD: (url, media, callback, auth = false) => {
        const MediaHeaders = {
            "Content-Type": "multipart/form-data",
            "Authorization": 'Bearer '+access_token
        };
        axios.post(url, media, {headers: MediaHeaders}).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                store.dispatch('Logout');
            }
        })
    },
    ErrorHandler(errors) {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('.error-report-g').html('');
        $.each(errors, (i, v) => {
            if (i === 'error') {
                $('.error-report-g').html('<p class="alert alert-danger">' + v + '</p>')
            } else {
                $('[name="' + i + '"]').addClass('is-invalid');
                $('[name="' + i + '"]').closest('.form-group').find('.invalid-feedback').html(v);
            }
        });
    },
    ClearErrorHandler() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    }
}
export default ApiService;
