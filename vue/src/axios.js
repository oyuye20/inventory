import axios from "axios";
import store from './store';

/* axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'; */

const axios_client = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',


    /* http://127.0.0.1:8000/api */

    /* baseURL: '' */

    /* http://127.0.0.1:8000/api */
})

axios_client.interceptors.request.use(config => {
    config.headers.Authorization = 'Bearer $(store.state.user.token)';
    return config;
})


export default axios_client;