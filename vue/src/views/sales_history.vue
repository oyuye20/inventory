<template>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
            <div class="sidebar_wrapper" :class ="{side: isSidebar}">
                
                <div class="sidebar-heading text-center py-4 fs-4 fw-bold d-flex justify-content-center ">

                    <div class="div d-flex justify-content-center align-items-center me-2">
                        <i class="fas fa-circle-user fa-2x"></i>
                    </div>
                    

                    <div class="div d-flex flex-column justify-content-end">
                        Admin

                        <span class="text-secondary fs-6">Administrator</span>
                    </div>

                </div>


                <div class="list-group list-group-flush my-3 w-100 p-3">

                
                    <router-link :to="{name: 'dashboard'}">

                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                        d-flex justify-content-center rounded-5" >

                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="fas fa-chart-pie me-4"></i>
                        </div>
                            
                        <div class="div w-100">
                            <span class="fs-4">Dashboard</span>
                        </div>

                    </div>
                        
                    </router-link>



                    <router-link :to="{name: 'products'}">               
                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                            d-flex justify-content-center rounded-5 mt-2" >

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="bi bi-box-seam-fill me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Products</span>
                            </div>

                        </div>
                    </router-link>



                    <router-link :to="{name: 'inventory'}">          
                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                            d-flex justify-content-center rounded-5 mt-2">

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="fas fa-boxes-stacked me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Inventory</span>
                            </div>

                        </div>
                    </router-link>

                    
                    

                    <router-link :to="{name: 'transaction'}">
                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                        d-flex justify-content-center rounded-5 mt-2">

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="fas fa-receipt me-4 fa-lg"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Transactions</span>
                            </div>

                        </div>
                    </router-link>




                    <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                    d-flex justify-content-center rounded-5 mt-2" style="background-color: rgb(185, 232, 206); 
                    color: rgb(57, 164, 59);">

                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="fas fa-chart-line me-4"></i>
                        </div>
                            
                        <div class="div w-100">
                            <span class="fs-4">Sales History</span>
                        </div>

                    </div>


                    

                
                    <router-link :to="{name: 'records'}">
                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                        d-flex justify-content-center rounded-5 mt-2" >

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="bi bi-database-fill me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Records</span>
                            </div>

                        </div>
                    </router-link>


                    <router-link :to="{name: 'archive'}">
                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                        d-flex justify-content-center rounded-5 mt-2" >

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="fas fa-trash me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Archive</span>
                            </div>

                        </div>
                    </router-link>
                    


                    <router-link :to="{}">
                        <div id="sidebtn" class="list-group-item fs-5 list-group-item-action 
                        d-flex justify-content-center rounded-5 mt-2" >

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="fas fa-gear me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Settings</span>
                            </div>

                        </div>
                    </router-link>

                
                </div>
                

            </div>
        <!-- sidebar-wrapper -->

        <!-- Page Content -->

        <div id="page-content-wrapper">

            <nav class="navbar shadow-none py-4 px-4">
                <div class="d-flex align-items-center">
                    <!-- <button class="btn btn-primary" @click="toggle_sidebar = !toggle_sidebar">close</button> -->
                    <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon"><i class="fas fa-bars me-3 fa-2x"></i></a>
                    <h2 class="fs-4 fw-bold"><i class="fas fa-chart-line me-2"></i>Sales Report</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>Welcome Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">    

                <ul class="nav nav-underline mb-3 d-flex justify-content-center mt-3" id="pills-tab" role="tablist">

                    <li class="nav-item col-lg-2 me-2" role="presentation">
                        <button class="nav-link active fs-5 w-100" id="pills-daily-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-daily" type="button" 
                        role="tab" aria-controls="pills-daily" aria-selected="true"
                        style="color: #04B474">
                        <i class="far fa-calendar-days me-2"></i>Daily</button>
                    </li>


                    <li class="nav-item col-lg-2 me-2" role="presentation">

                        <button class="nav-link fs-5 w-100" id="pills-monthly-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-monthly" type="button" 
                        role="tab" aria-controls="pills-monthly" aria-selected="true"
                        style="color: #04B474">
                        <i class="far fa-calendar me-2"></i>Monthly</button>

                    </li>

                    <li class="nav-item col-lg-2 me-2" role="presentation">

                        <button class="nav-link fs-5 w-100" id="pills-critical-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-expired" type="button" 
                        role="tab" aria-controls="#pills-expired" aria-selected="true"
                        style="color: #04B474">
                        <i class="fas fa-calendar me-2"></i>Yearly</button>

                    </li>

                </ul>

  

    <div class="tab-content" id="pills-tabContent">


        <div class="tab-pane fade show active" id="pills-daily" 
        role="tabpanel" aria-labelledby="pills-daily-tab" tabindex="0">
          
            <div class="mt-3 w-100 p-3 bg-light d-flex justify-content-between">

                <div class="title">
                    <span class="fs-5 fw-bold"><i class="fas fa-database me-2">
                    </i>Daily Sales</span>
                </div>

                <div class="date">
                    <span class="fs-5 fw-bold">{{ formatDate }}</span>
                </div>

            </div>
            
      
            <div class="table-responsive">     
               
                <!-- <div class="container-fluid text-center" >
                    <span class="fw-bold fs-5">The daily records is empty</span>
                </div> -->


                <table class="table table-hover table-borderless text-center">
                    <thead class="" style="background-color: rgb(4, 180, 116);">
                        <tr>
                        <th scope="col" class="fw-bold text-light">Product Name</th>
                        <th scope="col" class="fw-bold text-light">Unit Price</th>
                        <th scope="col" class="fw-bold text-light">Total Products Sold</th>
                        <th scope="col" class="fw-bold text-light">Total Sales</th>
                        <th scope="col" class="fw-bold text-light">Date</th>

                        <!-- <th>Actions</th> -->
                        </tr>
                    </thead>

                <tbody v-for="d in daily.data">

                    <tr>
                        <td class="fw-bold">{{d.product_name}}</td>

                        <td class="fw-bold"> {{
                        Intl.NumberFormat
                        ('en-PH', { style: 'currency', currency: 'PHP' }).format((d.price))         
                        }}
                        </td>


                        <td class="fw-bold">{{d.total_quantity}}</td>


                        <td class="fw-bold">{{
                        Intl.NumberFormat
                        ('en-PH', { style: 'currency', currency: 'PHP' }).format((d.total_sold))         
                        }}
                        </td>

                        


                        <td class="fw-bold">{{d.purchase_date}}</td>
                        
                    </tr>



                 

                </tbody>
                

                </table>


                <div class="d-flex justify-content-end align-items-center" >
                    <Bootstrap5Pagination :limit="1" :keepLength="true" :data="daily" class="shadow-sm"  
                    @pagination-change-page="getDaily"
                    />
                </div>

            </div>
        </div>




        <div class="tab-pane fade show" id="pills-monthly" role="tabpanel" 
        aria-labelledby="pills-monthly-tab" tabindex="0">
            
        <div class="mt-3 w-100 bg-light p-3 d-flex justify-content-between">

                <div class="title">
                    <span class="fs-5 fw-bold"><i class="fas fa-database me-2"></i>Monthly Sales</span>
                </div>

                <div class="date">
                    <span class="fs-5 fw-bold">{{ formatDate }}</span>
                </div>

        </div>

            <div class="table-responsive">     
                <table class="table table-hover table-borderless text-center">
                    <thead class="" style="background-color: rgb(4, 180, 116);">
                        <tr>
                        <th scope="col" class="fw-bold text-light">Product Name</th>
                        <th scope="col" class="fw-bold text-light">Unit Price</th>
                        <th scope="col" class="fw-bold text-light">Total Products Sold</th>
                        <th scope="col" class="fw-bold text-light">Total Sales</th>
                        <th scope="col" class="fw-bold text-light">Date</th>
                        <th scope="col" class="fw-bold text-light">Month Of</th>

                        <!-- <th>Actions</th> -->
                        </tr>
                    </thead>

                <tbody v-for="m in montly.data">
                    <tr>
                        <td class="fw-bold">{{ m.product_name }}</td>


                        <td class="fw-bold">{{
                        Intl.NumberFormat
                        ('en-PH', { style: 'currency', currency: 'PHP' }).format((m.price))         
                        }}</td>

                        <td class="fw-bold">{{ m.total_quantity }}</td>          

                        <td class="fw-bold">{{
                        Intl.NumberFormat
                        ('en-PH', { style: 'currency', currency: 'PHP' }).format((m.total_sold))         
                        }}</td>  

                        <td class="fw-bold">{{ m.purchase_date }}</td>                      

                        <td class="fw-bold">{{ m.Month }}</td>
                    </tr>

                </tbody>
                </table>


                <div class="d-flex justify-content-end align-items-center" >
                    <Bootstrap5Pagination :limit="1" :keepLength="true" :data="montly" class="shadow-sm"  
                    @pagination-change-page="getMonthly"
                    />
                </div>

            </div>
        
        </div>

        <div class="tab-pane fade show" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab" tabindex="0">Cancelled Order</div>








    
            
        </div>
        <!-- END OF CRITICAL TAB -->




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
import tutorial from '../components/tutorial.vue'
import { ref } from 'vue'
import axios_client from '../axios';

export default {
    name: 'inventory',

    components: {
        Bootstrap5Pagination,
        tutorial
    },


    setup(){

        const store = useStore();
        const router = useRouter();

        const isSidebar = ref(false);
        const daily = ref([]);
        const montly = ref([]);


    
        onMounted(()=> {
            getDaily()
            getMonthly()
        })


        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date();

        const formatDate = date.toLocaleDateString("en-US", options)




        const getDaily = async(page = 1) => {
            axios_client.get('http://127.0.0.1:8000/api/daily?page=' + page).then(response=>{
                daily.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        const getMonthly = async(page = 1) => {
            axios_client.get('http://127.0.0.1:8000/api/monthly?page=' + page).then(response=>{
                montly.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }




        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }

        return {
            user: computed(() => store.state.user.data),logout,isSidebar,getDaily,daily,formatDate,montly,getMonthly
        }


    }
}
</script>
