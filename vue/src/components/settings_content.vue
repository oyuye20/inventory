<template>

    <div class="row d-flex justify-content-center ">

    <div class="col-6 p-4" 
    style="background-color:  rgb(255, 255, 255); 
    box-shadow: 1px 1px 5px rgb(90, 90, 90);">


        <div class="col-12 ">
            <h2 class="fw-bold text-center">Edit Profile</h2>
        </div>


        <div class="col-12 d-flex flex-column justify-content-center align-items-center ">


            <div v-if="imageURL" class="div position-relative" style="border-radius: 50%;">
                <img :src="imageURL" style="border-radius: 50%;" width="250" class="img-fluid">

                <span class="position-absolute top-100 start-5 translate-middle 
                badge rounded-pill badge-success" v-if="image">
                <a role="button" @click="chooseFiles()"><i class="fas fa-pencil fa-2x p-2"></i></a>
                </span>
            </div>


            <div v-else class="div position-relative" style="border-radius: 50%;">
                <img v-bind:src="storageLink + image" alt="" style="border-radius: 50%;" width="250" class="img-fluid">

                <span class="position-absolute top-100 start-5 translate-middle 
                badge rounded-pill badge-success" v-if="image">
                <a role="button" @click="chooseFiles()"><i class="fas fa-pencil fa-2x p-2"></i></a>
                </span>

            </div>

        </div>

        <input type="file" hidden id="fileUpload" @change="imageUpload">

  




        <div class="col-12 d-flex justify-content-center mb-3 mt-3"> 
            <div class="col-5 me-1">
                <label class="fw-bold">Name</label>
                <input type="text" class="form-control" v-model="user_details.username">
            </div>


            <div class="col-5" v-if="user_details.role == 1">
                <label class="fw-bold">Position</label>
                <input type="text" class="form-control" value="Administrator" readonly>
            </div>   

            <div class="col-5" v-else>
                <label class="fw-bold">Position</label>
                <input type="text" class="form-control" value="Staff" readonly>
            </div>   




        </div>


        <div class="col-12 d-flex justify-content-center mb-3"> 
            <div class="col-10 me-2">
                <label class="fw-bold">Email Address</label>
                <input type="text" class="form-control" v-model="user_details.email">
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center mb-3"> 
            <div class="col-10 me-2">
                <label class="fw-bold">Password</label>
                <input type="password" class="form-control">
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center mb-3"> 
            <div class="col-10 me-2">
                <label class="fw-bold">Contact Number</label>
                <input type="text" class="form-control">
            </div>
        </div>


        <form class="col-12 d-flex justify-content-center mb-3" @submit.prevent="updateProfile(id)"> 
            <div class="col-10 me-2">
                <button class="btn w-100 text-light fw-bold"  type="submit" 
                style="background-color: #04B474;">Save Changes</button>
            </div>
        </form>
        

    </div>




    </div>
    
    
    












</template>



<script>

import { ref } from 'vue'
import { useStore } from "vuex";
import {reactive, onMounted} from 'vue';
import { computed, toHandlers } from "vue";
import axios_client from '../axios';
import { inject } from 'vue'
export default {


    setup(){
        const store = useStore();
        const image = ref('');
        const id = ref('');





        const user_details = ref([]);

        const storageLink = inject('$storageLink');

        const imageFile = ref('');
        const imageURL = ref ('');


        function chooseFiles(){
            document.getElementById("fileUpload").click()
        }

        function imageUpload (e){
            const file = imageFile.value = e.target.files[0]
            imageURL.value = URL.createObjectURL(file)
        }



        const userData = async() => {
            axios_client.get('/user').then(response=>{

            image.value = response.data.image;
            user_details.value = response.data;
            id.value = response.data.id;


            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        function updateProfile(id){
            console.log(id)
        }










        onMounted(()=> {      
            userData()
        })

        return {userData,store,storageLink,image,user_details,
            chooseFiles,imageUpload,imageURL,updateProfile,id}
    }


   
    
}
</script>