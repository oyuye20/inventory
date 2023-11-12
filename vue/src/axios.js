import axios from "axios";
import store from './store';

/* axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'; */

const axios_client = axios.create({
    baseURL: 'https://api.amadorpetsuppliesinventory.online/api',
})

axios_client.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${localStorage.getItem("TOKEN")}`;
    return config;
})



export default axios_client;