<template>

    <!-- <button class="btn btn-primary">Add new account</button> -->

    <div class="table-responsive mt-4">



        
        <button class="btn btn-primary" @click="$emit('addModal')">Add new account</button>



        <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-user me-2"></i>Account Lists</h4>

        <table class="table table-hover table-borderless text-center w-100">
            <thead>
                <tr>
                    <th scope="col" class="fw-bold">ID</th>
                    <th scope="col" class="fw-bold">Image</th>
                    <th scope="col" class="fw-bold">Email</th>
                    <th scope="col" class="fw-bold">Username</th>
                    <th scope="col" class="fw-bold">Status</th>
                    <th class="fw-bold" >Actions</th>
                </tr>

            </thead>
        <tbody v-for="a in accLists.data">
            <tr>
                <td>{{a.id }}</td>

                <td class="fw-bold">
                <img v-bind:src="storageLink + a.image" 
                class="img-fluid" width="50" height="50"></td>

                <td>{{ a.email }}</td>
                <td>{{ a.username }}</td>

                <td v-if="a.isActivated == 1">
                    <span class="fw-bold text-success">Activated</span>
                </td>

                <td v-else>
                    <span class="fw-bold text-danger">Deactivated</span>
                </td>



                <td class="m-3">
                    <!-- <RouterLink :to="{name: 'edit_product', params:{id:cat.id} }">
                        <button class="btn btn-success" data-mdb-toggle="tooltip" 
                        data-mdb-placement="left" title="Edit"><i class="bi bi-pencil-square">
                        </i></button>
                    </RouterLink> -->
                    
                    <button type="button" class="btn btn-warning mx-1 mt-2" data-mdb-toggle="tooltip" 
                    data-mdb-placement="left" title="Edit" @click.prevent="del_cat(cat.id, cat.category)">
                    <i class="fas fa-box-archive"></i></button>

                </td>


            </tr>
        </tbody>
        </table>


        <div class="d-flex justify-content-end align-items-center" >
            <Bootstrap5Pagination :limit="1" :keepLength="true" :data="accLists" class="shadow-sm"  
            @pagination-change-page="getAccount"/>
        </div>            


    </div>
</template>


<script>
import '../assets/dashboard.css'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';


import { computed, toHandlers } from "vue";
import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect } from 'vue';
import Swal from 'sweetalert2'
import { inject } from 'vue'
export default {

    components: {
        Bootstrap5Pagination
    },


    setup(){
        const accLists = ref([]);
        const storageLink = inject('$storageLink');



        const getAccount = async(page = 1) => {
            axios_client.get('/accounts/lists?page=' + page)
            .then(response=>{
                    accLists.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        onMounted(()=> {
            getAccount()
        })



        return {getAccount,accLists,storageLink}

    }
    
}
</script>