<template>


<transition name="modalAnim">
<div v-if="modalActive" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center" 
    id="modal-content">



    <div class="col-xxl-7 col-xl-8 col-lg-10 col-md-11 col-sm-12 p-3" >

        <div class="col-12">
            <div class="fw-bold text-dark d-flex justify-content-between p-3"
            style="background-color: rgb(4, 180, 116);"> 
                <span>Transaction ID: {{transID}}</span>
                <span>Date: {{ formatDate }}</span>    
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
        <tbody v-for="i in cart_lists">
            <tr>
            <td class="fw-bold text-dark">{{i.serial_number}}</td>
            <td class="fw-bold text-dark">{{i.product_name}}</td>
            <td class="fw-bold text-dark">{{i.quantity }}</td>

            <td class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(i.selling_price)}}</td>

            <td class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(i.total)}}</td>  
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
                format(CartStore.grand_total)}}</span>
            </div>
        </div>

        <div class="d-flex justify-content-center mb-3">
            <div class="col-7 d-flex justify-content-between">
                <span class="fw-bold text-dark">Sub total: </span>

                <span class="fw-bold text-dark">{{discount}} %</span>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-7 d-flex justify-content-between">
                <span class="fw-bold text-dark">Grand total: </span>

                <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(GrandTotal)}}</span>
            </div>
        </div>


        <hr style=" border-top: 3px dashed black;">


        <div class="d-flex justify-content-center mb-3">
            <div class="col-7 d-flex justify-content-between">
                <span class="fw-bold text-dark">Total Payment: </span>

                <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(CashAmount)}}</span>
            </div>
        </div>

        <div class="d-flex justify-content-center mb-5">
            <div class="col-7 d-flex justify-content-between">
                <span class="fw-bold text-dark">Change: </span>

                <span class="fw-bold text-dark">{{Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).
                format(changeMoney)}}</span>
            </div>
        </div>


        <div class="d-flex justify-content-center">
            <div class="col-12 d-flex justify-content-end">


                <button class="btn btn-danger me-2 fw-bold" id="printBtn" v-if="orderCompleted"
                @click="modalActive =! modalActive">Cancel</button>

                <button class="btn btn-primary me-2 fw-bold" id="printBtn" v-if="orderCompleted == false"
                @click="printInvoice">Print Invoice</button>

                <button class="btn btn-success me-2 fw-bold" id="printBtn" v-if="orderCompleted == false"
                @click="closeTransaction">Continue</button>



                <form @submit.prevent="completeOrder()" id="printBtn" v-if="orderCompleted">
                    <button :disabled="submit_btn" type="submit" class="btn btn-success fw-bold d-flex
                    justify-content-center align-items-center">
                    <span v-if="submit_btn" class="spinner-border spinner-border-sm me-3" 
                    aria-hidden="true"></span>Complete Order</button>
                </form>


                
            </div>
        </div>
        

        </div>
    </div>
 </div>
</div>
</transition>




<transition name="modalAnim">
<div v-if="modalCash" class="container-fluid d-flex justify-content-center align-items-center" 
style="width: 100%; height: 100%; position: fixed; overflow: auto; z-index: 1; background-color: rgba(0, 0, 0, 0.605); overflow: auto;">
    
    <div class="row container d-flex 
    justify-content-center align-items-center">

        <div class="col-lg-5 bg-light shadow-sm p-0">

            <div class="col-12 mb-4 text-start p-3" style="background-color: rgb(4, 180, 116);">
                <span class="fw-bold fs-3 text-white"><i class="far fa-money-bill-1 me-3"></i>Cash Invoice</span>
            </div>

            <div class="div p-4">          
                <div class="col-12 mb-2">
                    <label class="form-label fw-bold">Cash</label>
                    <input type="text" class="form-control" 
                    @input="filter_input()" v-model="CashAmount"  
                    @keydown.enter="invoice()"
                    placeholder="Enter Amount">
                </div>

                <div class="col-12 mb-4">
                    <label class="form-label fw-bold">Discount</label>
                    <select class="form-control" v-model="discount">
                        <option value="0">None</option>
                        <option value="0.05">5%</option>
                        <option value="0.10">10%</option>
                        <option value="0.15">15%</option>
                        <option value="0.20">20%</option>
                    </select>
                </div>
            </div>

            

            <div class="col-12 border border-black px-3">
                
            </div>

            <div class="d-flex justify-content-end p-3">
                <button class="btn btn-danger me-2" @click="modalCash =! modalCash">Cancel</button>

                <button class="btn btn-success" @click="invoice()">Continue</button>        
            </div>

        
        </div>
    </div>
</div>
</transition>


<body>
    <div class="d-flex" id="wrapper">

        <div class="sidebar_wrapper" :class ="{side: isSidebar}">
            <sidebar/>
        </div>
     

        <div id="page-content-wrapper">

            <nav class="navbar py-4 px-4 shadow-none">  
                <div class="d-flex justify-content-between w-100">
                    <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon">
                    <i class="fas fa-bars me-3 fa-2x"></i></a>
                    <h2 class="fs-4 fw-bold"><i class="fas fa-receipt me-2"></i>Transactions</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>
            </nav>


            <div v-if="loadingPage" class="div p-3 flex-column d-flex justify-content-center align-items-center 
            container-fluid" style="height: 100%;">
                <p class="fw-bold fs-3">Loading...</p>
                <span class="spinner-border spinner-border-sm  p-3" aria-hidden="true" style="font-size: ;"></span>
            </div>  


            
            <div v-else class="container-fluid px-4"> 
              
                <div class="row gx-2 mt-3">

                    <!-- PRODUCT LIST TAB -->
                    <div class="col-xl-6 mt-3">
                        <div class="bg-light w-100">

                            <h4 class="p-3 text-light" style="background-color: rgb(4, 180, 116);">
                            <i class="fas fa-box me-2"></i>Products</h4>


                            <!-- PRODUCT LISTS -->
                            <div class="row g-1">
                                <div class="container-fluid d-flex justify-content-center mb-2 mt-2">
                                    <div class="col-10">
                                        <input type="text" @keydown.enter="CartStore.getProduct" role="searchbox" v-model="CartStore.search_box" 
                                        class="form-control rounded-5 p-2" style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                                        border: 1.9px solid rgb(215, 214, 214);" placeholder="Search Product">
                                    </div>

                                    <div class="col-1 d-flex justify-content-center p-0 m-0 mx-4">
                                        <button class="btn btn-success" @click="CartStore.getProduct"><i class="fas fa-magnifying-glass"></i></button>
                                    </div>                 
                                </div>
                              
                                <div class="table-responsive mt-3 mb-3" style="overflow: auto; ">
                                    <table class="table table-hover table-borderless text-center" >
                                        <thead>
                                            <tr>
                                            <th scope="col" class="fw-bold">Image</th>
                                            <th scope="col" class="fw-bold">Product Name</th>
                                            <th scope="col" class="fw-bold">Quantity</th>
                                            <th scope="col" class="fw-bold">Selling Price</th>
                                            <th scope="col" class="fw-bold">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody v-for="p in lists.data" :key="p.id">
                                            <tr>
                                                <td class="fw-bold"><img v-bind:src="storageLink + p.product.image" 
                                                 width="50" height="50"></td>


                                                <td>{{p.product.product_name}}</td>
                          
                                                <td>{{p.stocks}}</td>

                                                
                                                <td>
                                                    {{Intl.NumberFormat('en-PH', 
                                                    { style: 'currency', currency: 'PHP' }).
                                                    format(p.product.selling_price)}}
                                                </td>                            

                                                <td>
                                                    <button class="btn btn-primary" 
                                                    @click="cart_add.add_cart(p.id,p.product.
                                                    product_name,p.stocks,p.product.selling_price,
                                                    p.product.serial_number,p.product.price)">
                                                    +</button>
                                                </td>

                                                <!-- <div v-if="p.stocks == 0" class="div">
                                                
                                                </div>

                                                <div v-else class="div">
                                                
                                                </div> -->

                                                
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>


                          
                            </div>

                            

                            
                            <div class="w-100 d-flex justify-content-center mt-3">
                                <Bootstrap5Pagination :data="lists" :limit="1" @pagination-change-page="CartStore.getProduct"/>
                            </div>
                            
                    </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="bg-light w-100">
                            <h4 class="p-3 text-light" style="background-color: rgb(4, 180, 116);"><i class="fas fa-cash-register me-2"></i>Transaction</h4>


                            <div class="d-flex justify-content-between p-3">
                                <span>Transaction ID: {{transID}}</span>
                                <span>Transaction Date: {{formatDate}}</span>
                            </div>


                            <div class="div mt-3 p-3">
                                <input type="text" class="form-control mb-3" v-model="customer_name" placeholder="Customer Name">
                            </div>

                        
                        
                            <div class="table-responsive mt-3 mb-3" style="overflow: auto; height: 20rem; ">
                                <table class="table table-hover table-borderless text-center" >
                                    
                                    <thead>
                                        <tr>
                                        <th scope="col" class="fw-bold">Product Name</th>
                                        <th scope="col" class="fw-bold">Price</th>
                                        <th scope="col" class="fw-bold">Quantity</th>
                                        <th scope="col" class="fw-bold">Total</th>
                                        <th scope="col" class="fw-bold">Action</th>
                                        </tr>
                                    </thead>

                                <tbody v-for="(list, i) in cart_lists" :key="list.product_id">
                                    <tr>

                                    <td>{{list.product_name}}</td>
                                    <td>₱ {{list.selling_price}}</td>

                                    <td class="d-flex h-100">
                                        <button @click="CartStore.decrement(i,list.product_id)" class="btn btn-sm btn-danger mx-2">-</button>
                                        
                                        <span class="d-flex justify-content-center align-items-center">{{list.quantity}}</span>

                                        <button @click="CartStore.increment(i,list.stocks,list.selling_price,list.product_id)" 
                                        class="btn btn-sm btn-success mx-2">+</button>        
                                    </td>
                                
                                    <td><span class="mx-2">₱ {{list.total.toLocaleString('en-US')}}</span></td>

                                    <td class="fw-bold"><button @click="CartStore.remove_cart(index)" 
                                        role="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                    
                                    </tr>

                                </tbody>
                                </table>
                            </div>


                            <form @submit.prevent="checkout()">
                                <div class="p-3 mt-3" style="background-color: rgb(176, 230, 209);">

                                    <h4 class="text-dark"><i class="fas fa-coins me-2 m-2 text-success"></i>
                                        Sub Total: {{Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(CartStore.grand_total)}}
                                    </h4>

                                    <!-- <h4 class="text-dark"><i class="fas fa-coins me-2 m-2 text-success"></i>
                                        Discount: 
                                    </h4> -->

                                    <h4 class="text-dark"><i class="fas fa-coins me-2 m-2 text-success"></i>
                                        Grand Total: {{
                                        Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format((CartStore.grand_total))                                                    
                                        }}
                                    </h4>

                                    
                                    
                                    <button type="submit" class="btn btn-success" :disabled="submit_btn">         
                                        <span role="status" class="mx-1">Check Out</span>
                                        <span v-if="submit_btn" class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </form>
                                    
                        </div>        
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
import {useCartStore} from '../stores/cart'
import { useStore } from "vuex";
import { computed, toHandlers } from "vue";
import { useRouter } from "vue-router";
import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect } from 'vue';
import {useVuelidate} from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import order_content from '../components/order_content.vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import sidebar from '../components/sidebar/sidebar.vue';
import Swal from 'sweetalert2'
import logout from '../components/modal/logout.vue';
import { inject } from 'vue'


import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


export default {
    name: 'order',

    components: {
        order_content,
        Bootstrap5Pagination,
        sidebar,
        logout
    },


    setup(){
        const storageLink = inject('$storageLink');
        const $toast = useToast();

        const CartStore = useCartStore();
        const cart_add = useCartStore();
        const store = useStore();
        const router = useRouter();
        const cart_order = CartStore.cart;

        const lists = computed(()=> CartStore.prod)
        const cart_lists = computed(()=> CartStore.cart)


        const loadingPage = computed(()=> CartStore.loading)




        const transID = ref(Math.floor(Math.random() * 99999999999999) + 1)
        let product_lists = ref([]);
        let search_data = ref([]); 

        const customer_name = ref("");
        const CashAmount = ref("");
        const changeMoney = ref("");
        const quantity = ref('');
        const search_box = ref('');
        const username = ref('');
        const discount = ref('');






        const discountVal = ref('');
        const GrandTotal = ref('');

        
        const show_alert = ref(false);
        const submit_btn = ref(false);
        const modalActive = ref(false);
        const modalCash = ref(false);
        const isSidebar = ref(false);
        const typing = ref(false);

        const orderCompleted = ref(true);
        


        


        /* DATE TIME  */
        const date = new Date();
        const formatDate = date.toLocaleDateString("en-US")
        /* END OF DATE TIME */

        
    
        const toggleModal = () =>{
            modalActive.value = !modalActive.value;
        }

        
       
        const userData = async() => {
            axios_client.get('/user').then(response=>{
                username.value = response.data.username

            }).catch(error =>{
                console.log(error.response.data)
            })
        }





        
        function filter_input(){
            CashAmount.value = CashAmount.value.replace(/[^0-9]/g, "");
        }


        function checkout(){
            if(CartStore.cart.length == 0){  
                $toast.error('Please add product in cart', {position: 'top'});      
            }

            else if (customer_name.value == ""){
                 $toast.error('Please input customer name', {position: 'top'}); 
            }

            else{
                modalCash.value = true              
            }           
        }

     
        function invoice(){
            let total = (CartStore.grand_total);

            discountVal.value = (CartStore.grand_total * discount.value)



            if(CashAmount.value == '')
            {
                $toast.error("Please Enter amount", {position: 'top'}); 
            }

            else if (total > CashAmount.value) {
                $toast.error("Not enough amount", {position: 'top'}); 
            }


            else {
                modalCash.value = !modalCash.value
                modalActive.value = true


                GrandTotal.value = (total - discountVal.value);
                changeMoney.value = (CashAmount.value - GrandTotal.value)
  
            }
        }


        function completeOrder(){
            submit_btn.value = true;

            const today = new Date();
                const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = date +' '+ time;
        
                let form = new FormData();
                form.append('sub_total', CartStore.grand_total)
                form.append('customer_name', customer_name.value)
                form.append('change', changeMoney.value)
                form.append('grand_total', GrandTotal.value)
                form.append('discount', discount.value)
                form.append('orderedBy', username.value)
                form.append('amount', CashAmount.value)

                form.append('cart', JSON.stringify(cart_lists.value))
                form.append('purchase_date', dateTime)

                form.append('transactions_id', transID.value)


                axios_client.post("/checkout", form).then(response=>{
                    console.log(response.data)    

                    submit_btn.value = false
                    orderCompleted.value = false;        

                }).catch(error =>{
                    console.log(error.response.data)
                    submit_btn.value = false
                })
        }

        function printInvoice(){
            window.print();
        }


        function closeTransaction(){
            orderCompleted.value = true;
            customer_name.value = ''
            discountVal.value = ''
            GrandTotal.value = ''
            CashAmount.value = ''
            discount.value = ''
            changeMoney.value = ''


            CartStore.clear_cart()
            CartStore.getProduct()
            transID.value = Math.floor(Math.random() * 99999999999999) + 1
            modalActive.value = false;


            Swal.fire({
                title: 'Success!',
                text: 'Order completed',
                icon: 'success',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            })
        }



        onMounted(()=> {
            CartStore.getProduct()
            userData()
        })

        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }


        return {
            user: computed(() => store.state.user.data)

            ,close,logout,checkout,filter_input,completeOrder,toggleModal,invoice,userData

            ,product_lists,search_box,typing,isSidebar,lists,cart_lists,quantity,modalActive,

            lists,cart_add,cart_lists,CartStore,search_data,customer_name,show_alert,cart_order
            
            ,submit_btn,CashAmount,modalCash,changeMoney,storageLink,transID,formatDate,loadingPage,printInvoice

            ,orderCompleted,closeTransaction,discount,discountVal,GrandTotal

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
