<template>

<transition name="modalAnim">
<div v-if="modal_add" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center p-3" 
    id="modal-content">

            <div class="col-xxl-7 col-md-8 text-start p-3" 
            style="background-color: rgb(4, 180, 116);">


                <div class="col-12">
                    <span class="fw-bold fs-3 text-white">
                    <i class="fas fa-circle-plus me-3">
                    </i>Add new account</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light">

            <div class="col-12 mb-2">
                <div class="mb-3" v-if="imageURL">
                    <img :src="imageURL" class="img-fluid" width="300" height="300">
                </div>
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Username</label>
                <input type="text" v-model="user.username"
                class="form-control">
            </div>
  

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Email</label>
                <input type="email" v-model="user.email"
                class="form-control">
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Password</label>
                <input type="password" v-model="user.password"
                class="form-control">
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Image</label>
                <input type="file" 
                class="form-control" @change="imageUpload">
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Role</label>
                <select v-model="user.role" class="form-control">
                    <option value="1">Admin</option>
                    <option value="0">Staff</option>
                </select>
            </div>


     
            <div class="col-12 d-flex justify-content-end"> 
                <button role="button" class="btn btn-danger mt-3 fw-bold" 
                @click="modal_add =! modal_add">Close</button>

                <form @submit.prevent="create_account()">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Add new account</button>
                </form>

                </div>      
            </div>      
    </div>
</div>
</transition>





<transition name="modalAnim">
<div v-if="modal_edit" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center p-3" 
    id="modal-content">

            <div class="col-xxl-7 col-md-8 text-start p-3" 
            style="background-color: rgb(4, 180, 116);">


                <div class="col-12">
                    <span class="fw-bold fs-3 text-white">
                    <i class="fas fa-circle-plus me-3">
                    </i>Edit account</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light" >

            <div class="col-12 mb-2">
                <div class="mb-3" v-if="imageURL">
                    <img :src="imageURL" class="img-fluid" width="300" height="300">
                </div>
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Username</label>
                <input type="text" v-model="editAccData.username"
                class="form-control">
            </div>
  

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Email</label>
                <input type="email" v-model="editAccData.email"
                class="form-control">
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Status</label>
                <select class="form-control" v-model="editAccData.isActivated">
                    <option value="1">Activated</option>
                    <option value="0">Deactivated</option>
                </select>
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Image</label>
                <input type="file" 
                class="form-control" @change="imageUpload">
            </div>

            <!-- <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Role</label>
                <select class="form-control" v-model="editAccData.role">
                    <option value="1">Admin</option>
                    <option value="0">Staff</option>
                </select>
            </div> -->


     
            <div class="col-12 d-flex justify-content-end"> 
                <button role="button" class="btn btn-danger mt-3 fw-bold" 
                @click="modal_edit =! modal_edit">Close</button>

                <form @submit.prevent="editAccount(editAccData.id)">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Edit account</button>
                </form>

                </div>      
            </div>      
    </div>
</div>
</transition>
















<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->

            <div class="sidebar_wrapper" :class ="{side: isSidebar}">  
                <sidebar/>
            </div>
        

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->

        <div id="page-content-wrapper">
            

            <nav class="navbar py-4 px-4 shadow-none">   
                <div class="d-flex justify-content-between w-100">
                    <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon">
                    <i class="fas fa-bars me-3 fa-2x"></i></a>
                    <h2 class="fs-4 fw-bold"><i class="fas fa-user me-2"></i>Accounts</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>

            </nav>

            <div class="container-fluid px-4">

                <!-- <tutorial/> -->
                

                <accounts_content v-on:addModal="openModal()" v-on:editacc="editModal($event)" :key="updateAccount"/>
                
            </div>


        </div>



    </div>
    <!-- /#page-content-wrapper -->

</body>

</template>


<script>
import '../assets/dashboard.css'
import { useStore } from "vuex";
import { computed, toHandlers } from "vue";
import { useRouter } from "vue-router";
import {reactive, onMounted} from 'vue';
import accounts_content from '../components/accounts_content.vue'
import tutorial from '../components/tutorial.vue'
import { ref } from 'vue'
import sidebar from '../components/sidebar/sidebar.vue';
import logout from '../components/modal/logout.vue';
import axios_client from '../axios';
import Swal from 'sweetalert2'
import {useToast} from 'vue-toast-notification';


export default {
    name: 'records',

    components: {
        accounts_content,
        sidebar,
        logout
    },


    setup(){

        const store = useStore();
        const router = useRouter();

        const isSidebar = ref(false);
        const modal_add = ref(false);
        const modal_edit = ref(false);

        const user = ref({
            username: '',
            email: '',
            password: '',
            role: '',
        })


        const editAccData = ref([]);






        const imageFile = ref('');
        const imageURL = ref ('');
        const updateAccount = ref(0);


        function imageUpload(e){    
            const file = imageFile.value = e.target.files[0]
            imageURL.value = URL.createObjectURL(file) 
        }



    
     


        function openModal(){
            modal_add.value = true;
        }


        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

        function create_account(){

        let formData = new FormData();
        formData.append('username', user.value.username);
        formData.append('email', user.value.email);
        formData.append('password', user.value.password);
        formData.append('role', user.value.role);
        formData.append('image', imageFile.value);
            

        let url = '/auth_register';
        axios_client.post(url,formData,config).then(response => {

        modal_add.value = false;

        Swal.fire({
            title: 'Success!',
            text: 'account added',
            icon: 'success',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        })

        updateAccount.value += 1;


        }).catch(error =>{
            console.log(error.response.data)
        })
        }


        function editModal(id){
            modal_edit.value = true;

            axios_client.get('/editAccount/' + id)
            .then(response=>{
                editAccData.value = response.data


            }).catch(error =>{
                console.log(error.response.data)
            });
        }


        function editAccount(id){

            let formData = new FormData();
            formData.append('accData', JSON.stringify(editAccData.value));
            formData.append('image', imageFile.value);


            axios_client.post(`/accountListEdit/`
            + id, formData, config).then(response=>{

            updateAccount.value += 1;

            modal_edit.value = false;

            const $toast = useToast();
            $toast.success('Account updated successfully', {position: 'top'});  
           

            }).catch(error =>{
                console.log(error.response.data)
            })

        }


 


        onMounted(()=> {
            
        })



        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }

        return {
            user: computed(() => store.state.user.data),logout,isSidebar,openModal,modal_add,create_account,user
            ,imageFile,imageURL,imageUpload,updateAccount,editModal,modal_edit,editAccData,editAccount
        }


    }
}
</script>

<style scoped>
.modalAnim-leave-to,
.modalAnim-enter-from{
    opacity: 0;
}

.modalAnim-leave-from,
.modalAnim-enter-to{
    opacity: 1;
}

.modalAnim-leave-active,
.modalAnim-enter-active{
    transition: opacity 0.3s;
}
    
</style>
