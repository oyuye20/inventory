<template>



<transition name="modalAnim">
<div v-if="modalActive" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center" 
    id="modal-content">



    <div class="col-xxl-7 col-xl-8 col-lg-10 col-md-11 col-sm-12 p-3" >

        <div class="col-12">
            <div class="fw-bold text-dark d-flex justify-content-between p-3"
            style="background-color: rgb(4, 180, 116);"> 
                <span>Transaction ID: {{transInfo.transactions_id}}</span>
                <span>Date: {{ transInfo.purchase_date }}</span>
            </div>
        </div>
        

        <div class="col-12 bg-light p-3">
            <p class="col-12 mb-1 text-center fw-bold text-dark">J.R. AMADOR PET AND POULTRY SUPPLIES</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">National Road, Brgy Muzon</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">San Jose Del Monte Bulacan</p>
            <p class="col-12 mb-1 text-center fw-bold text-dark">TEL NO : 09222178222</p>

        <hr style=" border-top: 3px dashed black;">
        

        <div class="table-responsive">
        <table class="table table-borderless">
        <thead style="background-color: transparent;">
            <tr>
            <th class="fw-bold" scope="col">Serial Number</th>
            <th class="fw-bold" scope="col">Product Name</th>
            <th class="fw-bold" scope="col">Quantity</th>
            <th class="fw-bold" scope="col">Price</th>
            <th class="fw-bold" scope="col">Total</th>
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

            <td class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(c.total)}}</td>
            </tr>
        </tbody>
        </table>

        </div>

        <hr style=" border-top: 2.5px dashed black;">


            <div class="d-flex justify-content-center mb-3">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Sub total: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(transInfo.gross_total)}}</span>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-3">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Discount: </span>
                    <span class="fw-bold text-dark">% {{ transInfo.discount }}</span>
                </div>
            </div>


            <div class="d-flex justify-content-center">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Grand total: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' })
                    .format(transInfo.net_total)}}</span>
                </div>
            </div>


            <hr style=" border-top: 3px dashed black;">


            <div class="d-flex justify-content-center mb-3">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Total Payment: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(transInfo.amount)}}</span>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-5">
                <div class="col-7 d-flex justify-content-between">
                    <span class="fw-bold text-dark">Change: </span>

                    <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                    { style: 'currency', currency: 'PHP' }).
                    format(transInfo.change)}}</span>

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



<transition name="modalAnim">
<div v-if="stockModal" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center" 
    id="modal-content">



    <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9 col-sm-11 p-3" >

        <div class="col-12" >
            <div class="fw-bold text-light fs-4 d-flex justify-content-between p-3"
            style="background-color: rgb(4, 180, 116);"> 
                Update Stocks
            </div>
        </div>
        

        <div class="col-12 bg-light p-3" v-for="s in stockData">
            <label for="" class="form-label fw-bold">Supplier name</label>
            <input type="text"  
            class="form-control mb-2" v-model="s.supplier">

            <label for="" class="form-label fw-bold">Supplier email</label>
            <input type="text"  
            class="form-control mb-2" v-model="s.supplier_email">

            <label for="" class="form-label fw-bold">Supplier contact number</label>
            <input type="text"  
            class="form-control mb-2" v-model="s.supplier_number">

            <label for="" class="form-label fw-bold">Stocks</label>
            <input type="text" 
            class="form-control mb-3" v-model="s.stocks">

            <label for="" class="form-label fw-bold">Stock By</label>
            <input type="text" 
            class="form-control mb-3" readonly v-model="s.stock_by">


           <div class="d-flex justify-content-end">
                <button class="btn btn-danger fw-bold" @click="stockModal =! stockModal">Close</button>
                <form @submit.prevent="updateStocks(s.id)">
                    <button type="submit" class="btn btn-success fw-bold">Update Stocks</button>
                </form>
               
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
                

                <records_content v-on:openInvoice="openModalInvoice" v-on:openStock="editStocks" :key="refreshRecords"/>
                
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
import Swal from 'sweetalert2';

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
        const stockModal = ref(false);
        const stockData = ref([]);

        const orderData = ref([]);
        const refreshRecords = ref(0);


        const transInfo = ref({
            transactions_id:'',
            purchase_date:'',
            gross_total:'',
            discount:'',
            net_total:'',
            amount:'',
            change: '',
        })



        function openModalInvoice(id){
            console.log(id)
            modalActive.value = true;

            axios_client.get('/showInvoice/' + id).then(response=>{
                orderData.value = response.data


                transInfo.value.transactions_id = response.data[0].transactions_id;
                transInfo.value.purchase_date = response.data[0].purchase_date;
                transInfo.value.gross_total = response.data[0].gross_total;
                transInfo.value.discount = response.data[0].discount;
                transInfo.value.net_total = response.data[0].net_total;
                transInfo.value.amount = response.data[0].amount;
                transInfo.value.change = response.data[0].change;

            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        function editStocks(id){
            stockModal.value = true;
            console.log(id)

            axios_client.get('/getStockID/' + id).then(response=>{
                stockData.value = response.data

                console.log(response.data)
            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        function updateStocks(id){
            
            let formData = new FormData();
            formData.append('stock_data', JSON.stringify(stockData.value));

            axios_client.post('/updateStockID/' + id ,formData).then(response=>{
                stockModal.value = false;

                refreshRecords.value += 1;

                Swal.fire({
                    title: 'Success!',
                    text: 'Stocks updated successfully',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                })

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
            logout,isSidebar,openModalInvoice,modalActive,orderData,printInvoice,editStocks,stockModal,stockData
            ,updateStocks,refreshRecords,transInfo
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
