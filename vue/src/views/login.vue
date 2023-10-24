<template>
    <div>




        <div class="row container-fluid main d-flex justify-content-center align-items-center p-3" @submit.prevent="login">

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-9 bg-light m-4 p-0 rounded-8 h-100">

                <div class="col-12 p-5">
                    <h1 class="fw-bold text-center">LOGIN</h1>
                </div>

                <div class="col-12 border border-light-subtle">
                </div>


                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 28rem;">

                    <form class="col-10 p-4">

                        <div v-if="errorMsg" class="alert alert-danger text-center mt-4 fw-bold p-3">
                            <span>{{ errorMsg }}</span>
                        </div>

                        <input type="text" v-model="user.email" 
                        class="form-control rounded-5 mb-4 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Enter Username">

                    
                        <input type="password" v-model="user.password" 
                        class="form-control rounded-5 p-2 fs-5" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" 
                        placeholder="Enter Password">

                        <button class="btn btn-success w-100 fw-bold mb-3"  type="submit"
                        style="box-shadow: 3px 3px 2px rgb(197, 197, 197); 
                        margin-top: 2.1rem; font-size: 1rem; background-color: #04B474;"
                        :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm me-3" 
                        aria-hidden="true"></span>Sign In</button>


                        <div class="d-flex justify-content-center">
                            <a role="button" class="mb-2 fw-bold">Forgot Password?</a>
                        </div>
                        
                        
                    </form>
                    
                </div>



            </div>











            <!-- <div class="row m-0 p-0 d-flex justify-content-end border border-dark">

                <div class="dog col-6">

                    <div class="col-12 h-50 d-flex justify-content-center align-items-center">

                        <div class="col-8 d-flex">
                            <span class="text-light fw-bold fs-1 text-center">
                            J.R. AMADOR PET AND POULTRY SUPPLIES</span>
                        </div>
                        
                    </div>

                    <div class="col-12 h-50 d-flex align-items-end">
                        <img src="../assets/dog2.png" alt="" class="img-fluid w-100">
                    </div>
 
                </div>
                

                <div class="col-6 bg-light rounded-start-5  
                d-flex justify-content-center align-items-center p-3 flex-column">

                    <div class="col-12 d-flex justify-content-center" >               
                        <span class="fs-1 fw-bold text-dark">LOGIN</span>
                    </div>    


                    <form class="col-8">

                        <div class="div" v-if="errorMsg.email">
                            {{ errorMsg.email[0] }}
                        </div>
                
                        

                        <input type="text" placeholder="Enter Username" 
                        v-model="user.email" class="form-control p-2 mb-3 rounded-7" 
                        id="username" style="box-shadow: 3px 3px 2px rgba(175, 175, 175, 0.443);
                        border: 1.5px solid rgb(158, 157, 157)">

                        <input type="password" placeholder="Enter Password" 
                        v-model="user.password" class="form-control p-2 rounded-7" 
                        style="box-shadow: 3px 3px 2px rgba(175, 175, 175, 0.443);
                        border: 1.5px solid rgb(158, 157, 157)">

                        <button class="btn btn-success w-100" type="submit" 
                        :disabled="loading" style="width: 60%; margin-top: 50px;">
                        <span v-if="loading" class="spinner-border spinner-border-sm" 
                        aria-hidden="true"></span>
                        <span role="status" class="mx-1">Login</span>
                        </button>
                        
                    </form>   
                </div>


            </div> -->














          
            <!-- <form class="col-xxl-3 col-lg-6 col-md-8 col-sm-9 form">

                <div v-if="errorMsg" class="alert alert-danger text-center" role="alert">
                    {{errorMsg}}
                </div>


                <p class="text-center fs-2 title fw-bold"><i class="bi bi-key-fill mx-1"></i>Login to JR Amador</p>
                <div class="col-sm-12 border border-dark"></div>

            <div class="mb-3 username field">
              <input type="text" name="email"  v-model="user.email" id="email" class="form-control" placeholder="Username">
        
            </div>

                
            <div class="mb-3 field">
              <input type="password" name="password" v-model="user.password" id="password" class="form-control" placeholder="Password" aria-describedby="helpId">
          
            </div>

            <button type="submit" :disabled="loading" class="btn btn-dark w-100 mb-3 submit-log">
                
                <span v-if="loading"  class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status" class="mx-1">Login</span>
            
            </button>


            </form> -->

 
        </div>

 

        <!-- <form class="container mt-3" @submit="login">
            <h4>Login Form</h4>

            <div v-if="errorMsg" class="alert alert-danger" role="alert">
             {{errorMsg}}
            </div>       

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" v-model="user.email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" v-model="user.password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3 form-check">
                <router-link :to="{name: 'register'}">Not yet registered?</router-link>
            </div>


            
            <button class="btn btn-primary w-100" type="submit" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status" class="mx-1">Login</span>
            </button>



        </form> -->
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


    function login(){
        /* console.log('login')
  
        if(v$.value.$invalid){
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
                errorMsg.value  = error.response.data

                console.log(error.response.data)
            }


        })

    }

    return {
        user: computed(() => store.state.user.data),
        login,errorMsg,loading,user
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