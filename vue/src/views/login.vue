<template>
    <div>

        <!-- <div class="main">
            <div class="row container-fluid p-0 m-0 d-flex justify-content-center">
                <div class="col-5 border border-light">
                    <h1 class="fw-bold">LOGIN</h1>
            
            
            
            
                </div>
            </div>
        </div> -->











        <div class="row container-fluid main d-flex justify-content-center align-items-center p-3" @submit.prevent="login">

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-9 bg-light m-4 p-0 rounded-8 h-100">

                <div class="col-12 p-5">
                    <h1 class="fw-bold text-center">LOGIN</h1>
                </div>

                <div class="col-12 border border-light-subtle">
                </div>


                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 28rem;">

                    <form class="col-10 p-4">

                        <div v-if="(errorMsg)" class="alert alert-danger text-center mt-4 fw-bold p-3">
                            {{ errorMsg }}
                        </div>



                        <input type="email" v-model="user.email" 
                        class="form-control rounded-5 mb-4 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Enter Email" required>

                    
                        <input type="password" v-model="user.password" 
                        class="form-control rounded-5 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Enter Password" required>

                        <button class="btn btn-success w-100 fw-bold mb-3"  type="submit"
                        style="box-shadow: 3px 3px 2px rgb(197, 197, 197); 
                        margin-top: 2.1rem; font-size: 1rem; background-color: #04B474;"
                        :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm me-3" 
                        aria-hidden="true"></span>Login</button>


                        
                        <router-link :to="{name: 'forgotPassword'}" >
                            <a role="button" class="fw-bold text-primary">Forgot Password</a>
                        </router-link>

                       

                        
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



export default {

    setup(){

    const loading = ref(false);
    const router = useRouter();

    const user = {
        email: '',
        password: ''
    }

    const email = ref('');
    const password = ref('');
    

    const rules  = {
        email: {required},
        password: {required}
    }

    const v$ = useVulidate(rules, {
        email,password
    });

    const errorMsg = ref('');

    const errorMsg2 = ref('');


    function login(){
      
  
        /* if(v$.value.$invalid){
            v$.value.$touch();
            return
        } */

        loading.value = true;
        store.dispatch('login', user).then(() => {

    

            loading.value = false;
            router.push({
                name: 'dashboard'
            })
        }).catch(error => {
            loading.value = false;



        
            if(error.response.status === 422){

                if(error.response.data){
                    errorMsg.value  = error.response.data
                }


               
            }


          
            
            

        })

    }

    return {
        user: computed(() => store.state.user.data),
        login,errorMsg,loading,user,errorMsg2
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