<template>
    <div>


        <div class="wrapper1">
            <div class="container main">
                <div class="row rowLogin">

         
                        <div class="col-md-6 side-image">
                            <img src="../assets/jrLogo.png" class="img-fluid imgLogo">
                        </div>                          

                    


                    <form class="col-md-6 right" @submit.prevent="login">
                        <div class="input-box">
                            <header>LOGIN</header>

                            <div class="input-field text-center" v-if="errorMsg">
                              <p class="fw-bold text-danger fs-6">{{errorMsg}}</p>                         
                            </div>


                            <div class="input-field">
                                <label for="email">Email</label>
                                <input type="text" class="input" id="email" v-model="user.email" required>                               
                            </div>
                            
                            <div class="input-field">
                                <label for="password">Password</label>
                                <input type="password" class="input" id="password" v-model="user.password" required>                             
                            </div>

                            

                            <div class="input-field">
                                <button :disabled="loading" class="btn btn-success d-flex justify-content-center">
                                    <span v-if="loading" class="spinner-border spinner-border-sm me-3 "
                                    aria-hidden="true"></span>Sign IN
                                </button>     
                            </div>

                            <router-link :to="{name: 'forgotPassword'}" class="input-field mt-3 text-center">
                                <a role="button">Forgot Password?</a>
                            </router-link>
                        </div>

                        <!-- <div class="forgot-pass">
                            <p>Forgot Password?</p>
                        </div> -->
                    </form>


                </div>
            </div>
        </div>





        <!-- <div class="row container-fluid main d-flex justify-content-center align-items-center p-3" @submit.prevent="login">

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
 
        </div> -->


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





</script>