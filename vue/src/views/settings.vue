<template>
    <body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
            <div class="sidebar_wrapper" :class ="{side: isSidebar}">
                <sidebar/>
            </div>
        <!-- sidebar-wrapper -->

        <!-- Page Content -->

        <div id="page-content-wrapper">

            <nav class="navbar py-4 px-4 shadow-none">   
                <div class="d-flex justify-content-between w-100">
                    <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon">
                    <i class="fas fa-bars me-3 fa-2x"></i></a>
                    <h2 class="fs-4 m-0 fw-bold"><i class="fas fa-user-pen me-3"></i>Edit Profile</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>

            </nav>

            <div class="container-fluid px-4">    
                <settings_content/>
            </div>


        </div>



    </div>
    <!-- /#page-content-wrapper -->

</body>
</template>

<script>

import '../assets/dashboard.css'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { useStore } from "vuex";
import { computed, toHandlers } from "vue";
import { useRouter } from "vue-router";
import {reactive, onMounted} from 'vue';
import sidebar from '../components/sidebar/sidebar.vue';
import inventory_content from '../components/inventory_content.vue';
import settings_content from '../components/settings_content.vue';
import { ref } from 'vue'
import logout from '../components/modal/logout.vue';


import axios_client from '../axios';



export default {
    components: {
        sidebar,
        settings_content,
        logout
    },

     setup(){

        const store = useStore();
        const router = useRouter();

        const isSidebar = ref(false);

    
        onMounted(()=> {

        })



        return {
            isSidebar
        }


    }
}
</script>