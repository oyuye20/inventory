<template>
    <!-- v-show="logoutModal" -->

<div class="div" v-show="notification">
    <div class="container-fluid d-flex justify-content-center align-items-center" 
    style="width: 100%; height: 100%; position: fixed; overflow: auto;  background-color: rgba(0, 0, 0, 0.605); z-index: 3;" >
        <div class="row container d-flex 
        justify-content-center align-items-center">

                <div class="col-lg-5 bg-light shadow-sm p-0">
            
                    <div class="col-12 mb-1 text-start p-3 bg-light shadow-sm"> 
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <span><i class="fas fa-bell me-3 fa-2x"></i></span>
                            <span class="fs-2">Notifications</span>
                        </div> 
                    </div>


                    <div class="d-flex justify-content-center align-items-center mb-3 mt-3" 
                    v-for="i in notifLists.data">

                        <div class="col-10 justify-content-center align-items-center p-2" 
                        style="background-color: rgb(236, 236, 236);">
                            <span class="fw-bold"><i class="fas fa-bell me-2"></i>{{i.message}}</span>
                        </div>       

                    </div>
                    

                    <div class="d-flex justify-content-center align-items-center mb-3 mt-3">
                    <Bootstrap5Pagination :limit="1" :keepLength="true" :data="notifLists" class="shadow-sm"  
                    @pagination-change-page="getNotifications"/>
                    
                    </div>


                    <div class="col-12 mb-1 text-start p-3 bg-light shadow-sm d-flex justify-content-center">            
                        <button class="btn btn-primary me-2" @click="close">Close</button>         
                        <button class="btn btn-danger">Read all notifications</button>                   
                    </div>

            </div>
        </div>           
    </div>
</div>

</template>


<script>
import { ref, watchEffect, defineComponent } from 'vue';
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed, toHandlers, onMounted } from "vue";
import axios_client from '../axios';
import { Bootstrap5Pagination } from 'laravel-vue-pagination'



export default {
    components: {
        Bootstrap5Pagination,
    },


    props: ["notification"],

    

    setup(props, {emit}) {
        const notifLists = ref([]);


        const close = () => {
            emit('close');
        }


        const getNotifications = async(page = 1) => {
            axios_client.get('/notification/stocks?page=' + page).then(response=>{
                notifLists.value = response.data.notification

            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        onMounted(() => {
            getNotifications()
        })




        return {close,getNotifications,notifLists}
    }

    
}
</script>
