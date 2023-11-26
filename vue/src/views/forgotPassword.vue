<template>
    <div>

        <div class="row container-fluid main d-flex justify-content-center align-items-center p-3" @submit.prevent="forgotPass(email)">

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-9 bg-light m-4 p-0 rounded-8 h-100">

                <div class="col-12 p-5">
                    <h1 class="fw-bold text-center">Forgot Password</h1>
                </div>

                <div class="col-12 border border-light-subtle">
                </div>


                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 28rem;">

                    <form class="col-10 p-4">

                        <div v-if="(errorMsg)" class="alert alert-danger text-center mt- fw-bold p-3">
                            {{ errorMsg }}
                        </div>



                        <input type="email" v-model="email" 
                        class="form-control rounded-5 mb-4 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Enter your email" required>
  

                        <button class="btn btn-success w-100 fw-bold mb-3"  type="submit"
                        style="box-shadow: 3px 3px 2px rgb(197, 197, 197); 
                        margin-top: 2.1rem; font-size: 1rem; background-color: #04B474;"
                        :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm me-3" 
                        aria-hidden="true"></span>Send Link</button>


                       <!--  <div class="d-flex justify-content-center">
                            <a role="button" class="mb-2 fw-bold">Forgot Password?</a>
                        </div> -->
                        
                        
                    </form>
                    
                </div>



            </div>
 
        </div>


    </div>
</template>

<script>
import '../assets/style.css'

import store from '../store'
import {useRouter} from 'vue-router'
import { ref } from 'vue'
import { computed } from "vue";
import useVulidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import axios_client from '../axios';
import Swal from 'sweetalert2'


export default {

    setup(){

    const loading = ref(false);
    const router = useRouter();



    const email = ref('');

  

    const rules  = {
        email: {required},
    }

    const v$ = useVulidate(rules, {
        email
    });

    const errorMsg = ref('');

    const errorMsg2 = ref('');


    function forgotPass(email){
      
  
        /* if(v$.value.$invalid){
            v$.value.$touch();
            return
        } */

        loading.value = true;


        axios_client.post('/forgot-password' ,{email: email})
            .then(response=>{
               
                loading.value = false;
                Swal.fire({
                    title: 'Success!',
                    text: 'Your reset password sent to your email',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                })

            }).catch(error =>{
                console.log(error.response.data)
        });
       
   


    }

    return {
        forgotPass,errorMsg,loading,email,errorMsg2
    }

    },


}


/* const router = useRouter();

const loading = ref(false);

const user = {
    email: '',
    password: ''
}


let errorMsg = ref('');


function login(ev){
    ev.preventDefault();
    loading.value = true;
    store.dispatch('login', user).then(() => {
        loading.value = false;
        router.push({
            name: 'dashboard'
        })
    }).catch(error => {
        loading.value = false;
        errorMsg.value = error.response.data
    })

} */




</script>