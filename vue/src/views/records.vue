<template>



<transition name="modalAnim">
<div v-if="modalActive" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center" 
    id="modal-content">



    <div class="col-xxl-7 col-xl-8 col-lg-10 col-md-11 col-sm-12 p-3" >

        <div class="col-12" v-for="c in orderData">
            <div class="fw-bold text-dark d-flex justify-content-between p-3"
            style="background-color: rgb(4, 180, 116);"> 
                <span>Transaction ID: {{c.transactions_id}}</span>
                <span>Date: {{ c.purchase_date }}</span>    
            </div>
        </div>
        

        <div class="col-12 bg-light p-3">
            <p class="col-12 mb-1 text-center fw-bold text-dark">J.R. AMADOR PET AND POULTRY SUPPLIES</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">Unit Sample Malolos KM 42</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">McArthur Hway Bulihan,</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">Malolos City Bulacan</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">TEL NO : (044)1234-567</p>

        <hr style=" border-top: 3px dashed black;">
        

        <div class="table-responsive">
        <table class="table table-borderless">
        <thead style="background-color: transparent;">
            <tr>
            <th class="fw-bold" scope="col">Serial Number</th>
            <th class="fw-bold" scope="col">Product Name</th>
            <th class="fw-bold" scope="col">Quantity</th>
            <th class="fw-bold" scope="col">Price</th>
            </tr>
        </thead>
        <tbody v-for="c in orderData">
            <tr>
            <td class="fw-bold text-dark">{{c.serial_number}}</td>
            <td class="fw-bold text-dark">{{c.product_name}}</td>
            <td class="fw-bold text-dark">{{c.quantity }}</td>

            <td class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(c.selling_price)}}</td>
            </tr>
        </tbody>
        </table>

        </div>

        <hr style=" border-top: 2.5px dashed black;">

        <div v-for="c in orderData">

            <div class="d-flex justify-content-center mb-3">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Sub total: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(c.gross_total)}}</span>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Grand total: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(c.net_total)}}</span>
                </div>
            </div>


            <hr style=" border-top: 3px dashed black;">


            <div class="d-flex justify-content-center mb-3">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Total Payment: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(c.amount)}}</span>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-5">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Change: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(c.change)}}</span>
                </div>
            </div>
        </div>


        
            <div class="d-flex justify-content-center">
                <div class="col-12 d-flex justify-content-end">


                    <button class="btn btn-danger me-2 fw-bold" id="printBtn" 
                    @click="modalActive =! modalActive">Cancel</button>

                    <button class="btn btn-success me-2 fw-bold" id="printBtn"
                    @click="printInvoice">Print Invoice</button>

                    
                </div>
            </div>
        

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
                    <h2 class="fs-4 fw-bold"><i class="bi bi-database-fill me-2"></i>Records</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>

            </nav>

            <div class="container-fluid px-4">

                <!-- <tutorial/> -->
                

                <records_content v-on:openInvoice="openModalInvoice"/>
                
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
import records_content from '../components/records_content.vue'
import tutorial from '../components/tutorial.vue'
import { ref } from 'vue'
import sidebar from '../components/sidebar/sidebar.vue';
import logout from '../components/modal/logout.vue';
import axios_client from '../axios';

export default {
    name: 'records',

    components: {
        records_content,
        tutorial,
        sidebar,
        logout
    },


    setup(){

        const store = useStore();
        const router = useRouter();

        const isSidebar = ref(false);
        const modalActive = ref(false);

        const orderData = ref([]);


        function openModalInvoice(id){
            console.log(id)
            modalActive.value = true;

            axios_client.get('/showInvoice/' + id).then(response=>{
                orderData.value = response.data

                console.log(response.data)
            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        function printInvoice(){
            window.print();
        }

    
        onMounted(()=> {
            
        })



        return {
            logout,isSidebar,openModalInvoice,modalActive,orderData,printInvoice
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
