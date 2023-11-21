<template>

<transition name="modalAnim">
    <notification :notification="notification" @close="toggleNotif" @readNotif="readNotif2"
    style="position: relative; z-index: 4;"></notification>
</transition>



    <div v-if="loadingSidebar" class="sidebar-heading text-center py-1 fs-4 mt-3 fw-bold d-flex justify-content-center">

        <div class="div d-flex justify-content-center align-items-center me-3">
            <img v-bind:src="storageLink + image"
            style="border-radius: 50%;" width="50" class="border">
        <!--  <i class="fas fa-circle-user fa-2x"></i> -->
        </div>

        <div class="div d-flex flex-column justify-content-end">
            <span class="fs-5">{{ username }}</span>

            <div class="div" v-if="roleNum == 1">
                <span class="text-secondary fs-6">Administrator</span>
            </div>

            <div class="div" v-else>
                <span class="text-secondary fs-6">Staff</span>
            </div>
    
        </div>

    </div>

    <div v-if="roleComputed == '1' && loadingSidebar" role="button"
    class="text-center py-2 fs-4 mt-3
    d-flex justify-content-center" @click="toggleNotif">

        <div class="div">
            <i class="fas fa-bell me-3 position-relative">

            <span class="fs-6 position-absolute top-20 start-80
            fs-7 translate-middle badge rounded-pill badge-danger" :key="updateCount">
            {{countNotifComputed}}
            </span>
            </i>

            <span class="fs-4 active_text ">Notifications</span>
        
        </div>        
    
    </div>


    <hr v-if="loadingSidebar">

  
    <div v-if="loadingSidebar">
        <div v-if="roleComputed == '1' && loadingSidebar" class="list-group list-group-flush my-3 w-100 p-3">

            <router-link :to="{name: 'dashboard'}" class="rounded-5">
                <div id="sidebtn" class="fs-5 list-group-item-action 
                d-flex justify-content-center">

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-chart-pie me-4 active_text"></i>
                    </div>
                        
                    <div class="div w-100">
                        <span class="fs-4 active_text">Dashboard</span>
                    </div>

                </div>
            </router-link>





            <router-link :to="{name: 'products'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action 
                d-flex justify-content-center" >

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="bi bi-box-seam-fill me-4 active_text"></i>
                    </div>
                        
                    <div class="div w-100">
                        <span class="fs-4 active_text">Products</span>
                    </div>

                </div>
            </router-link>


            <router-link :to="{name: 'inventory'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action 
                    d-flex justify-content-center" >

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-boxes-stacked me-4 active_text"></i>
                    </div>
                        
                    <div class="div w-100">
                        <span class="fs-4 active_text">Inventory</span>
                    </div>

                </div>
            </router-link>



            <router-link :to="{name: 'transaction'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center" >

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-receipt me-4 active_text"></i>
                    </div>
                        
                    <div class="div w-100">
                        <span class="fs-4 active_text">Transactions</span>
                    </div>

                </div>
            </router-link>



            <router-link :to="{name: 'sales'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center" >
                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-chart-line me-4 active_text"></i>
                    </div>
                        
                    <div class="div w-100">
                        <span class="fs-4 active_text">Sales History</span>
                    </div>
                </div>  
            </router-link>      



            <router-link :to="{name: 'records'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center" >

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="bi bi-database-fill me-4 active_text"></i>
                    </div>
                    
                    <div class="div w-100">
                        <span class="fs-4 active_text">Records</span>
                    </div>

                </div>
            </router-link>


            <router-link :to="{name: 'archive'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action 
                d-flex justify-content-center">

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-trash me-4 active_text"></i>
                    </div>
                    
                    <div class="div w-100">
                        <span class="fs-4 active_text">Archive</span>
                    </div>

                </div>
            </router-link>


            <router-link :to="{name: 'accounts'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action 
                d-flex justify-content-center">

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-user me-4 active_text"></i>
                    </div>
                    
                    <div class="div w-100">
                        <span class="fs-4 active_text">Accounts</span>
                    </div>

                </div>
            </router-link>

            <router-link :to="{name: 'settings'}" class="rounded-5 mt-2">
                <div id="sidebtn" class="fs-5 list-group-item-action 
                d-flex justify-content-center">

                    <div class="div d-flex justify-content-center align-items-center">
                        <i class="fas fa-gear me-4 active_text"></i>
                    </div>
                    
                    <div class="div w-100">
                        <span class="fs-4 active_text">Settings</span>
                    </div>

                </div>
            </router-link>


        </div>








    <div v-else class="list-group list-group-flush my-3 w-100 p-3">

        <router-link :to="{name: 'dashboard'}" class="rounded-5">
            <div id="sidebtn" class="fs-5 list-group-item-action 
            d-flex justify-content-center">

                <div class="div d-flex justify-content-center align-items-center">
                    <i class="fas fa-chart-pie me-4 active_text"></i>
                </div>
                    
                <div class="div w-100">
                    <span class="fs-4 active_text">Dashboard</span>
                </div>

            </div>
        </router-link>


        <router-link :to="{name: 'transaction'}" class="rounded-5 mt-2">
            <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center" >

                <div class="div d-flex justify-content-center align-items-center">
                    <i class="fas fa-receipt me-4 active_text"></i>
                </div>
                    
                <div class="div w-100">
                    <span class="fs-4 active_text">Transactions</span>
                </div>

            </div>
        </router-link>



        <router-link :to="{name: 'sales'}" class="rounded-5 mt-2">
            <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center" >
                <div class="div d-flex justify-content-center align-items-center">
                    <i class="fas fa-chart-line me-4 active_text"></i>
                </div>
                    
                <div class="div w-100">
                    <span class="fs-4 active_text">Sales History</span>
                </div>
            </div>  
        </router-link>      



        <router-link :to="{name: 'records'}" class="rounded-5 mt-2">
            <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center" >

                <div class="div d-flex justify-content-center align-items-center">
                    <i class="bi bi-database-fill me-4 active_text"></i>
                </div>
                
                <div class="div w-100">
                    <span class="fs-4 active_text">Records</span>
                </div>

            </div>
        </router-link>

    </div>

    </div>



</template>


<script>
import { ref } from 'vue'
import { useStore } from "vuex";
import {reactive, onMounted} from 'vue';
import { computed, toHandlers } from "vue";
import axios_client from '../../axios';
import notification from '../notification.vue';
import { inject } from 'vue'
import Swal from 'sweetalert2'


export default {

    components: {
        notification
    },

    setup(){
        const storageLink = inject('$storageLink');
        const store = useStore();
        const loadingSidebar = ref (false);
        const roleNum = ref();
        const image = ref();


        const countNotifComputed = computed(() =>
            countNotif.value
        )


        const countNotif = ref();
        const username = ref();
        const updateCount = ref(0);



        const roleComputed = computed(()=>
            roleNum.value
        )

        const notification = ref(false);

        function toggleNotif(){
            notification.value = !notification.value
        }



        const getNotifCount = async() => {
            axios_client.get('/notification/stocks').then(response=>{
                countNotif.value = response.data.count

            }).catch(error =>{
                console.log(error.response.data)
            })
        }


    



        function readNotif2(){
            axios_client.put('/readNotifications').then(response=>{
            console.log(response.data)

            /* updateCount.value += 1; */
            

            console.log(updateCount.value)

            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        

        const userData = async() => {
            axios_client.get('/user').then(response=>{

                roleNum.value = response.data.role
                image.value = response.data.image
                username.value = response.data.username

                loadingSidebar.value = true;

            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        onMounted( ()=> {    
            getNotifCount()  
            userData()
        })


        return {storageLink,store,userData,roleNum,loadingSidebar,readNotif2,
            image,roleComputed,toggleNotif,notification,getNotifCount,countNotif,username
            ,updateCount,countNotifComputed

            ,
        }
    }



    
}
</script>

<style scoped>
a.router-link-exact-active{
    background-color: rgb(185, 232, 206); 
    pointer-events: none;
    cursor: pointer;

    .active_text{
        color: rgb(57, 164, 59);
    }

}


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
