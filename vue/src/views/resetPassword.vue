<template>
    <div>

        <div class="row container-fluid main d-flex justify-content-center align-items-center p-3" @submit.prevent="resetPass(form)">

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-9 bg-light m-4 p-0 rounded-8 h-100">

                <div class="col-12 p-5">
                    <h1 class="fw-bold text-center">Reset Password</h1>
                </div>

                <div class="col-12 border border-light-subtle">
                </div>


                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 28rem;">

                    <form class="col-10 p-4">

                        <div v-if="(errorMsg)" class="alert alert-danger text-center mt- fw-bold p-3">
                            {{ errorMsg }}
                        </div>



                        <input type="password" v-model="form.password" 
                        class="form-control rounded-5 mb-4 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Enter your new password" required>

                        <input type="password" v-model="form.password_confirmation" 
                        class="form-control rounded-5 mb-4 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Confirm Password" required>
  

                        <button class="btn btn-success w-100 fw-bold mb-3"  type="submit"
                        style="box-shadow: 3px 3px 2px rgb(197, 197, 197); 
                        margin-top: 2.1rem; font-size: 1rem; background-color: #04B474;"
                        :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm me-3" 
                        aria-hidden="true"></span>Reset Password</button>


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
import {useRouter, useRoute} from 'vue-router'
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
    const route = useRoute();


    const form = ref({
        password: '',
        password_confirmation: '',
        email: route.query.email,
        token: route.params.token
    })



  

   /*  const rules  = {
        email: {required},
    }

    const v$ = useVulidate(rules, {
        email
    }); */

    const errorMsg = ref('');

    const errorMsg2 = ref('');


    function resetPass(form){
      
  
        /* if(v$.value.$invalid){
            v$.value.$touch();
            return
        } */

        /* loading.value = true; */


        axios_client.post('/reset-password', form)
            .then(response=>{

                 
                Swal.fire({
                    title: 'Success!',
                    text: 'Your password has been changed successfully',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                })


                router.push({name: 'login'})
                

            }).catch(error =>{
                console.log(error.response)
        });
       
   


    }

    return {
        resetPass,errorMsg,loading,errorMsg2,form
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