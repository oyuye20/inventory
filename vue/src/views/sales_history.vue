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
                    <h2 class="fs-4 fw-bold"><i class="fas fa-chart-line me-2"></i>Sales Report</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>

            </nav>

        

            <div class="container-fluid px-4">    

                <ul class="nav nav-underline mb-3 d-flex justify-content-center mt-3" id="pills-tab" role="tablist">

                    <li class="nav-item col-lg-2 me-2" role="presentation">
                        <button class="nav-link active fs-5 w-100" id="pills-daily-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-daily" type="button" 
                        role="tab" aria-controls="pills-daily" aria-selected="true"
                        style="color: #04B474">
                        <i class="fas fa-calendar-day me-2"></i>Daily</button>
                    </li>


                    <!-- <li class="nav-item col-lg-2 me-2" role="presentation">
                        <button class="nav-link fs-5 w-100" id="pills-weekly-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-weekly" type="button" 
                        role="tab" aria-controls="pills-weekly" aria-selected="true"
                        style="color: #04B474">
                        <i class="fas fa-calendar-day me-2"></i>Weekly</button>
                    </li> -->




                    <li class="nav-item col-lg-2 me-2" role="presentation">
                        <button class="nav-link fs-5 w-100" id="pills-monthly-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-monthly" type="button" 
                        role="tab" aria-controls="pills-monthly" aria-selected="true"
                        style="color: #04B474">
                        <i class="far fa-calendar-days me-2"></i>Monthly</button>
                    </li>

                    <li class="nav-item col-lg-2 me-2" role="presentation">
                        <button class="nav-link fs-5 w-100" id="pills-yearly-tab" 
                        data-bs-toggle="pill" data-bs-target="#pills-yearly" type="button" 
                        role="tab" aria-controls="#pills-yearly" aria-selected="true"
                        style="color: #04B474">
                        <i class="fas fa-calendar me-2"></i>Yearly</button>
                    </li>

                </ul>

  

                <div class="tab-content" id="pills-tabContent">


                    <div class="tab-pane fade show active" id="pills-daily" 
                    role="tabpanel" aria-labelledby="pills-daily-tab" tabindex="0">
                    
                        <div class="mt-3 w-100 p-3 bg-light d-flex justify-content-between">

                            <div class="title">
                                <span class="fs-5 fw-bold"><i class="fas fa-calendar-day me-2">
                                </i>Daily Sales</span>
                            </div>

                            <div class="date">
                                <span class="fs-5 fw-bold">{{ formatDate }}</span>
                            </div>

                        </div>


                        <div class="mt-3 w-100 mb-3">
                            <input type="date" class="form-control" v-model="filterDay" @change="filterDaily">
                        </div>
                        
                
                        <div class="table-responsive">     
                        
                            <table class="table table-hover table-borderless text-center">
                                <thead class="" style="background-color: #04b4738e;">
                                    <tr>
                                    <th scope="col" class="fw-bold">Product Name</th>
                                    <th scope="col" class="fw-bold">Unit Price</th>
                                    <th scope="col" class="fw-bold">Total Products Sold</th>
                                    <th scope="col" class="fw-bold">Total Sales</th>
                                    <th scope="col" class="fw-bold">Date</th>

                                    <!-- <th>Actions</th> -->
                                    </tr>
                                </thead>

                            <tbody v-for="d in daily.data">

                                <tr>
                                    <td>{{d.product_name}}</td>
                                    <td>₱ {{d.selling_price}}</td>
                                    <td>{{d.total_quantity}}</td>

                                    <td>{{
                                    Intl.NumberFormat
                                    ('en-PH', { style: 'currency', currency: 'PHP' }).format((d.total_sold))         
                                    }}
                                    </td>

                                    <td>{{d.purchase_date}}</td>
                                    
                                </tr>     

                            </tbody>
                    

                            </table>


                            <div class="d-flex justify-content-end align-items-center" >
                                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="daily" class="shadow-sm"  
                                @pagination-change-page="filterDaily"
                                />
                            </div>

                        </div>
                    </div>



                    <div class="tab-pane fade show" id="pills-monthly" role="tabpanel" 
                    aria-labelledby="pills-monthly-tab" tabindex="0">
                        
                    <div class="mt-3 w-100 bg-light p-3 d-flex justify-content-between">
                        <div class="title">
                            <span class="fs-5 fw-bold"><i class="far fa-calendar-days me-2">
                            </i>Monthly Sales</span>
                        </div>

                        <div class="date">
                            <span class="fs-5 fw-bold">{{ formatDate }}</span>
                        </div>
                    </div>



                    <div class="mt-3 w-100 mb-3">
                        <input type="month" class="form-control" v-model="filterMonth" @change="filterMonthly">
                    </div>

                        <div class="table-responsive">     
                            <table class="table table-hover table-borderless text-center">
                                <thead class="" style="background-color: #04b4738e;">
                                    <tr>
                                    <th scope="col" class="fw-bold">Product Name</th>
                                    <th scope="col" class="fw-bold">Unit Price</th>
                                    <th scope="col" class="fw-bold">Total Products Sold</th>
                                    <th scope="col" class="fw-bold">Total Sales</th>
                                    <th scope="col" class="fw-bold">Date</th>
                                    <th scope="col" class="fw-bold">Month Of</th>

                                    <!-- <th>Actions</th> -->
                                    </tr>
                                </thead>

                            <tbody v-for="m in montly.data">
                                <tr>
                                    <td>{{ m.product_name }}</td>
                                    <td>₱ {{m.selling_price}}</td>
                                    <td>{{ m.total_quantity }}</td>          
                                    <td>₱ {{m.total_sold}}</td>  
                                    <td>{{ m.purchase_date }}</td>                      
                                    <td>{{ m.Month }}</td>
                                </tr>

                            </tbody>
                            </table>


                            <div class="d-flex justify-content-end align-items-center" >
                                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="montly" class="shadow-sm"  
                                @pagination-change-page="filterMonthly"
                                />
                            </div>

                        </div>
                    
                    </div>

                    <div class="tab-pane fade show" id="pills-yearly" role="tabpanel" 
                    aria-labelledby="pills-yearly-tab" tabindex="0">


                    <div class="mt-3 w-100 bg-light p-3 d-flex justify-content-between">
                        <div class="title">
                            <span class="fs-5 fw-bold"><i class="fas fa-calendar me-2">
                            </i>Yearly Sales</span>
                        </div>

                        <div class="date">
                            <span class="fs-5 fw-bold">{{ formatDate }}</span>
                        </div>          
                    </div>

                    <div class="table-responsive">     
                            <table class="table table-hover table-borderless text-center">
                                <thead class="" style="background-color: #04b4738e;">
                                    <tr>
                                    <th scope="col" class="fw-bold">Product Name</th>
                                    <th scope="col" class="fw-bold">Unit Price</th>
                                    <th scope="col" class="fw-bold">Total Products Sold</th>
                                    <th scope="col" class="fw-bold">Total Sales</th>
                                    <th scope="col" class="fw-bold">Date</th>
                                    <th scope="col" class="fw-bold">Year Of</th>

                                    <!-- <th>Actions</th> -->
                                    </tr>
                                </thead>

                            <tbody v-for="y in yearly.data">
                                <tr>
                                    <td>{{ y.product_name }}</td>
                                    <td>₱ {{y.selling_price}}</td>
                                    <td>{{ y.total_quantity }}</td>          
                                    <td>₱ {{y.total_sold}}</td>  
                                    <td>{{ y.purchase_date }}</td>                      
                                    <td>{{ y.yearOf }}</td>
                                </tr>

                            </tbody>
                            </table>


                            <div class="d-flex justify-content-end align-items-center" >
                                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="yearly" class="shadow-sm"  
                                @pagination-change-page="filterYearly"
                                />
                            </div>

                        </div>

                        
                    
                




                
                    </div>
      
                        
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
import { ref, watchEffect } from 'vue'
import axios_client from '../axios';
import sidebar from '../components/sidebar/sidebar.vue';
import logout from '../components/modal/logout.vue';


import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
    name: 'inventory',

    components: {
        Bootstrap5Pagination,
        tutorial,
        sidebar,
        logout
    },


    setup(){

        const store = useStore();
        const router = useRouter();

        const isSidebar = ref(false);
        const daily = ref([]);
        const montly = ref([]);
        const yearly = ref([]);


        const filterMonth = ref('');
        const filterDay = ref('');


        const start_date = ref('');
        const end_date = ref('');

        
        onMounted(()=> {
            filterMonthly()
            filterYearly()
            filterDaily()
        })



        
        const filterDaily = async(page = 1) => {
            if(filterDay.value == ''){
                axios_client.get('/daily?page=' + page).then(response=>{
                    daily.value = response.data;

                    console.log(response.data)

                }).catch(error =>{
                    console.log(error.response.data)
                })       
            }

            else {
                axios_client.get('/filter/daily/' + filterDay.value + '?page=').then(response=>{
                    daily.value = response.data;
                  
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }         
        }








        const filterMonthly = async(page = 1) => {
            if(filterMonth.value == ''){
                axios_client.get('/monthly?page=' + page).then(response=>{
                    montly.value = response.data;
                }).catch(error =>{
                    console.log(error.response.data)
                })       
            }

            else {
                axios_client.get('/filter/month/' + filterMonth.value + '?page=').then(response=>{
                    montly.value = response.data;
                    
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }         
        }


        const filterYearly = async(page = 1) => {
            axios_client.get('/yearly?page=' + page).then(response=>{
                yearly.value = response.data;
                
            }).catch(error =>{
                console.log(error.response.data)
            })         
        }


        function searchWeekly(){
            
        }


    

        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date();

        const formatDate = date.toLocaleDateString("en-US", options)


        /* const getDaily = async(page = 1) => {
            axios_client.get('/daily?page=' + page).then(response=>{
                daily.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        const getMonthly = async(page = 1) => {
            axios_client.get('/monthly?page=' + page).then(response=>{
                montly.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        } */


        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }

        return {
            user: computed(() => store.state.user.data),logout,isSidebar,daily,yearly,
            formatDate,montly,filterMonth,filterMonthly,filterYearly,filterDaily,filterDay,searchWeekly

            ,start_date,end_date
        }


    }
}
</script>
