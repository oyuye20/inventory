<template>

<!-- <transition name="modalAnim" >
    <logout :logoutModal="logoutModal" @close="togglelogoutModal" style="position: relative; z-index: 3;"></logout>
</transition> -->


<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->

        <div class="sidebar_wrapper" :class ="{side: isSidebar}">
            <sidebar/>
        </div>
    

    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->

    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4 d-flex shadow-none">

            <div class="d-flex justify-content-between w-100">
                <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon"><i class="fas fa-bars me-3 fa-2x"></i></a>
                <h2 class="fs-4 fw-bold"><i class="fas fa-chart-pie me-2"></i>Dashboard</h2>
       
                <div class="div d-flex justify-content-center align-items-center" >
                    <logout/>
                </div> 
       
            </div>

         
        </nav>

        <div class="container-fluid px-4">

            <!-- CARD FOR DASHBOARD -->
            <div class="row g-3 my-2 d-flex">

                <router-link :to="{name: 'products'}" class="col-xxl-2 col-xl-3">
                    <div class="d-flex flex-column">
                        <div class="shadow-sm rounded-5" style="height: 10rem; 
                        background-color: rgb(237, 106, 219);">

                        <div class="p-3 d-flex rounded-5 w-100">
                            <div>
                                <h3 class="fs-5 text-light mb-3 fw-bold">
                                <i class="fas fa-box me-2"></i>Products</h3>
                                <p class="fs-4 text-light">{{ product_total }}</p>
                            </div>
                        </div>

                        </div>
                    </div>
                </router-link>

  
            <router-link :to="{name: 'records'}" class="col-xxl-2 col-xl-3">
                <div class="d-flex flex-column">
                    <div class="shadow-sm rounded-5" style="height: 10rem; 
                    background-color: rgb(77, 184, 129)">

                        <div class="p-3 d-flex rounded-5 w-100">
                            <div>
                                <h3 class="fs-5 text-light mb-3 fw-bold"><i class="fas fa-money-bill me-2"></i>Total of Sales</h3>
                                <p class="fs-4 text-light fw-bold">{{Intl.NumberFormat
                                ('en-PH', { style: 'currency', currency: 'PHP' }).format((sale_total))}}</p>
                                
                            </div>
                        </div>
        
                    </div>
                </div>
            </router-link>
            


            <router-link :to="{name: 'records'}" class="col-xxl-2 col-xl-3">
                <div class="d-flex flex-column">
                    <div class="shadow-sm rounded-5" style="height: 10rem; 
                    background-color: rgb(192, 64, 207);">

                        <div class="p-3 d-flex rounded-5 w-100">
                            <div>
                                <h3 class="fs-5 text-light mb-3 fw-bold"><i class="fas fa-money-bill me-2"></i>Net total of sales</h3>
                                <p class="fs-4 text-light" v-for="n in netTotal">{{Intl.NumberFormat
                                ('en-PH', { style: 'currency', currency: 'PHP' }).format((n.total))}}</p>
                                
                            </div>
                        </div>
        
                    </div>
                </div>
            </router-link>


                
                <router-link :to="{name: 'records'}" class="col-xxl-3 col-xl-4">
                    <div class="d-flex flex-column">

                        <div class="p-3 shadow-sm d-flex justify-content-around 
                        flex-column align-items-center rounded-5" style="height: 12rem; background-color: rgb(55, 161, 197);">

                            <div class="p-3 d-flex rounded-5 w-100">
                                <div>
                                    <h3 class="fs-5 text-light mb-3"><i class="fas fa-box-open me-2"></i>Stocks on hand</h3>
                                    <p class="fs-2 text-light fw-bold">{{ num_total_stock }}</p>
                                    
                                </div>
                            </div>
            

                        </div>
                    </div>
                </router-link>




                <router-link :to="{name: 'records'}" class="col-xxl-3 col-xl-4">
                    <div class="d-flex flex-column">
                        <div class="p-3 shadow-sm d-flex justify-content-around 
                        flex-column align-items-center rounded-5" style="height: 12rem; background-color: rgb(47, 165, 151);">
                            <div class="p-3 d-flex rounded-5 w-100">
                                <div>
                                    <h3 class="fs-5 text-light mb-3">
                                    <i class="fas fa-arrow-turn-down me-2"></i>
                                    Critical Stocks</h3>

                                    <p class="fs-2 text-light fw-bold">{{ lowStocks }}</p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </router-link>



                <router-link :to="{name: 'records'}" class="col-xxl-3 col-xl-4">
                    <div class="d-flex flex-column">
                        <div class="p-3 shadow-sm d-flex justify-content-around flex-column 
                        align-items-center rounded-5" style="height: 12rem; background-color: rgb(215, 184, 82);">
                            <div class="p-3 d-flex rounded-5 w-100">

                                <div>
                                    <h3 class="fs-5 text-light mb-3">
                                    <i class="far fa-calendar-xmark me-2"></i>
                                    Expired Products</h3>
                                    
                                    <p class="fs-2 text-light fw-bold">{{ exp_list_count }}</p>                            
                                </div>
                            </div>
                        </div>
                    </div>
                </router-link>

                    <!-- <Bar v-if="isloaded"
                    id="my-chart-id"
                    :options="chartOptions"
                    :data="chartData"/> -->


                        <div class="mt-4" style=" position: relative;
                        margin: auto; height: 50vh; width: 80vw;">
                    
                                <!-- <Bar
                                id="my-chart-id"
                                :options="chartOptions"
                                :data="chartData" :style="styles"
                                /> -->
        

                                <Line
                                id="my-chart-id2"
                                :options="chartOptions2"
                                :data="chartData2" :style="styles"/>
                       
                        </div>
                       
                
                
            </div>           


        </div>
    </div>
</div>
    <!-- /#page-content-wrapper -->


    
</body>

</template>


<script>
import '../assets/dashboard.css'

/* import { shuffle } from 'lodash'; */
import { computed, toHandlers } from "vue";

import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect, defineComponent } from 'vue';

import logout from '../components/modal/logout.vue';
import sidebar from '../components/sidebar/sidebar.vue';
import Swal from 'sweetalert2'
import { Bar } from 'vue-chartjs'

import { Line } from 'vue-chartjs'




import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,  LineController, LineElement, PointElement} from 'chart.js'

import { useStore } from "vuex";
import { useRouter } from "vue-router";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, LineController,
LineElement,
PointElement)

/* import { Chart, registerables } from 'chart.js';
import { BarChart, useBarChart } from 'vue-chart-3';

Chart.register(...registerables); */



/* export default {
    name: 'dashboard',

    components: {
        Bar,
    },
 */

 export default {
    name: 'Dashboard',
    components: {Bar,logout,sidebar,Line},







    setup(){

        const store = useStore();
        const router = useRouter();
    


        const product_lists = ref([]);

        const expired_lists = ref([]);
        let stock_lists = ref([]);
        const product_total = ref('');
        let num_total_stock = ref();
        let crit_stocks1 = ref('');
        let sale_total = ref('');
        const isSidebar = ref(true);
        
        const isloaded = ref(false)

        const items_sold = ref([]);


    

        const sold_items = async() => {
            axios_client.get('/sold').then(response=>{       

            items_sold.value = response.data
            isloaded.value = true;
   
        
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


     



        
    /* const chartData = computed(() => ({
      labels: ['Products'],
      datasets: [
        {
          data: [product_total.value],
          backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
        },
      ],
    }));

    const { barChartProps, barChartRef } = useBarChart({
      chartData,
    }); */



        const exp_list_count = ref('');
        const lowStocks = ref('');

        const search_box = ref('');
        const netTotal = ref('');


        const typing = ref(false);


        const timestamp = ref();


        /* FOR NOTIFICATION */
        const notifCount = ref('');
        const notifLists = ref([]);


        const labels = ref([]);
        const data = ref([]);


        



        const today = new Date();
        const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        const dateTime = date +' '+ time;



        const chartData = computed(() => ({
        labels: ['Products'],
        datasets: [
            {
            data: [product_total.value],
            backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
            },
        ],
        }));



        const chartOptions = ref ({
            backgroundColor: '#f87979'
        })



        const chartData2 = computed(() => ({
        labels: labels.value,
        datasets: [{
                label: 'Total Sold',
                data: data.value,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.3
            }],
        }));


        const getMonthlyAnalytics = async() => {
            axios_client.get('/analytics/monthly').then(response=>{       
            labels.value = response.data.labels
            data.value = response.data.total_sold


            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        const styles = ref({
            width: '100%',
            height: '100%',
        })



        const chartOptions2 = ref ({
            responsive: true,
            backgroundColor: '#f87979',

        })








        const getNotifications = async() => {
            axios_client.get('/notification/stocks').then(response=>{
                notifCount.value = response.data.count
                notifLists.value = response.data.notification

            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        /* TOTAL OF PRODUCTS IN DASHBOARD */
        const total_products = () => {
            axios_client.get('/stats').then(response=>{
                product_total.value = response.data.product_count

                isloaded.value = true
            }).catch(error =>{

            })
        }


        /* NUMBER OF STOCKS */
        const stock_total = async() => {
            axios_client.get('/stock_total').then(response=>{
                num_total_stock.value = response.data.stock_total
            }).catch(error =>{

            })
        }




        /* NET SALES */
        const net_sales = async()=> {
            axios_client.get('/netSales').then(response=>{
                netTotal.value = response.data
               
            }).catch(error =>{

            })
        }




        /* EXPIRED PRODUCT COUNT */
        const exp_count_f = async() => {
            axios_client.get('/expiration/count').then(response=>{
                exp_list_count.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        }





        /* LISTS OF LOW STOCKS PRODUCT */
        const lowStocksCount = async() => {
            axios_client.get('/critical/count').then(response=>{
                lowStocks.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        

        /* TOTAL SALES */
        const total_sales = async() => {
            axios_client.get('/sales').then(response=>{
                sale_total.value = response.data.total_sales
            }).catch(error =>{

            })
        }





        /* LISTS OF EXPIRED PRODUCT */
        const expired_prod = async() => {
            axios_client.get('/expiration').then(response=>{
                /* console.log(response.data.expiration_date) */

                expired_lists.value = response.data.expiration_date;

            }).catch(error =>{

            })
        }


    

        onMounted( async ()=> {      
            getMonthlyAnalytics()
            getNotifications()
            expired_prod()
            total_products()
            stock_total()
            exp_count_f()
            total_sales()
            lowStocksCount()
            sold_items()
            net_sales()
        })



        return { user: computed(() => store.state.user.data),
            product_lists,close,expired_prod,expired_lists
            ,stock_lists,search_box,typing,product_total,total_products,stock_total,getMonthlyAnalytics
            ,num_total_stock,crit_stocks1,exp_count_f,exp_list_count,isSidebar,dateTime,sale_total,total_sales

            ,chartData,chartOptions,sold_items,items_sold,isloaded

            ,getNotifications,notifCount,notifLists,lowStocksCount,lowStocks,


            chartData2,chartOptions2,styles,net_sales,netTotal

            /* , barChartProps, barChartRef,isloaded */
        }



    }
  
};


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
