/* import './assets/main.css' */


import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.bundle.js'
import 'bootstrap-icons/font/bootstrap-icons.css'
import {useVuelidate} from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import 'mdb-vue-ui-kit/css/mdb.min.css';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';



// To use Html5QrcodeScanner (more info below)
import {Html5QrcodeScanner} from "html5-qrcode";

// To use Html5Qrcode (more info below)
import {Html5Qrcode} from "html5-qrcode";



import App from './App.vue'
import router from './router'
import store from './store'
import PrimeVue from 'primevue/config'



const app = createApp(App)


app.provide('$storageLink', 'https://api.amadorpetsuppliesinventory.online/storage/images/');


app.component('qrcode-scanner', {
    props: {
      qrbox: {
        type: Number,
        default: 250
      },
      fps: {
        type: Number,
        default: 10
      },
    },
    template: `<div id="qr-code-full-region"></div>`,
    mounted () {
      const config = {
        fps: this.fps,
        qrbox: this.qrbox,
      };
      const html5QrcodeScanner = new Html5QrcodeScanner('qr-code-full-region', config);
      html5QrcodeScanner.render(this.onScanSuccess);
    
    },
    methods: {
      onScanSuccess (decodedText, decodedResult) {
        this.$emit('result', decodedText, decodedResult);
      }
    }
  });





app.use(createPinia())
app.use(PrimeVue , { unstyled: true });
app.use(ToastPlugin);
app.use(router).use(store)
app.mount('#app')
