<template>

<!-- v-if="modalActive" -->


<transition name="modalAnim">
<div v-if="modalActive" class="container-fluid d-flex justify-content-center align-items-center" 
style="width: 100%; height: 100%; position: fixed; overflow: auto; z-index: 1; background-color: rgba(0, 0, 0, 0.605); overflow: auto;">
    
    <div class="row container d-flex 
    justify-content-center align-items-center">

        <div class="col-lg-8 bg-light shadow-sm p-0">

            <div class="col-12 mb-4 text-start p-3" style="background-color: rgb(4, 180, 116);">
                <span class="fw-bold fs-5 text-white">Transaction ID: {{transID}}</span>
            </div>


            <div class="d-flex text-center flex-column p-0 m-0">
                <p class="fw-bold">J.R. AMADOR PET AND POULTRY SUPPLIES</p>
                <p class="fw-bold">Unit Sample Malolos KM 42</p>
                <p class="fw-bold">McArthur Hway Bulihan, Malolos City Bul</p>
                <p class="fw-bold">TEL NO : (044)1234-567</p>
            </div>

                <div class="col-12 border border-black"></div>

               <!--  v-for="(list, i) in cart_lists" :key="list.product_id" -->


            <!-- <div class="div p-0 m-1 border border-dark" v-for="(list, i) in cart_lists" :key="list.product_id">

                <div class="col-12 d-flex">
                          
                    <div class="col-8 d-flex border">
                        <span class="fw-bold">{{list.product_name}}</span>
                    </div>

                    <div class="col-2 d-flex justify-content-center">
                        <span class="fw-bold">{{list.quantity}}</span>
                    </div>    
                    
                    <div class="col-2 d-flex justify-content-center">
                        <span class="fw-bold">{{list.price}}</span>
                    </div> 
                </div>
         
            </div> -->

            <div class="div p-2 m-1 " v-for="(list, i) in cart_lists" :key="list.product_id">
                <div class="col-10 d-flex mb-2 ">
                    <div class="col-10">
                        <span class="fw-bold">{{list.product_name}}</span>
                    </div>

                    
                    <div class="col-2 text-center">
                        <span class="fw-bold">{{list.quantity}}</span>
                    </div>

                    <div class="col-2 text-center">
                        <span class="fw-bold">₱ {{list.price}}</span>
                    </div>
                </div>          
            </div>

                

            <div class="div p-2 m-1;k">

                <div class="col-12 d-flex mb-2 ">
                    <div class="col-10">
                        <span class="fw-bold">Sub Total</span>
                    </div>

                    
                    <div class="col-2 text-center">
                        <span class="fw-bold">{{Intl.NumberFormat('en-PH', 
                        { style: 'currency', currency: 'PHP' }).format(CartStore.grand_total)}}</span>
                    </div>    
                </div>

                <div class="col-12 d-flex mb-2 ">
                    <div class="col-10">
                        <span class="fw-bold">Vat</span>
                    </div>

                    
                    <div class="col-2 text-center">
                        <span class="fw-bold">{{Intl.NumberFormat('en-PH', 
                        { style: 'currency', currency: 'PHP' })
                        .format((CartStore.grand_total * 0.12))}}</span>
                    </div>    
                </div>


                <div class="col-12 d-flex mb-2 ">
                    <div class="col-10">
                        <span class="fw-bold">Total Amount</span>
                    </div>

                    
                    <div class="col-2 text-center">
                        <span class="fw-bold">{{Intl.NumberFormat('en-PH', 
                        { style: 'currency', currency: 'PHP' }).format
                        ((CartStore.grand_total + (CartStore.grand_total * .12)))}}</span>
                    </div>    
                </div>

                         
            </div>




            <div class="div p-3 m-1">

                <div class="col-12 d-flex mb-2">
                    <div class="col-10">
                        <span class="fw-bold">Total Payment</span>
                    </div>
                    
                    <div class="col-2 ">
                        <span class="fw-bold">{{Intl.NumberFormat('en-PH', 
                        { style: 'currency', currency: 'PHP' }).format(CashAmount)}}</span>
                    </div>    
                </div>

               
                <div class="col-12 d-flex mb-2">
                    <div class="col-10">
                        <span class="fw-bold">Change</span>
                    </div>
                    
                    <div class="col-2 ">
                        <span class="fw-bold">{{Intl.NumberFormat('en-PH', 
                        { style: 'currency', currency: 'PHP' }).format(changeMoney)}}</span>
                    </div>    
                </div>

                         
            </div>




                

                







            <div class="d-flex justify-content-end p-3">
                <!-- <button class="btn btn-danger me-2" @click="modalActive =! modalActive">Close</button> -->

                <form @submit.prevent="completeOrder()">
                    <button type="submit" class="btn btn-success">Complete Order</button>
                </form>
                
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
                <div class="col-12 mb-4">

                    <input type="text" class="form-control" 
                    @input="filter_input()" v-model="CashAmount"  
                    @keydown.enter="invoice()"

                    placeholder="Enter Amount">
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
                    <h2 class="fs-4 fw-bold"><i class="fas fa-receipt me-2"></i>Transactions</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>
            </nav>

            
            <div class="container-fluid px-4"> 
              
                <!-- <order_content/> -->

                <div class="row gx-2 mt-3">

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
                                        <th scope="col" class="fw-bold">Quantity</th>
                                        <th scope="col" class="fw-bold">Price</th>
                                        <th scope="col" class="fw-bold">Total</th>
                                        <th scope="col" class="fw-bold">Action</th>
                                        </tr>
                                    </thead>

                                <tbody v-for="(list, i) in cart_lists" :key="list.product_id">
                                    <tr>
                                        <td>{{list.product_name}}</td>
                                        <td>{{list.quantity}}</td>
                                        <td>₱ {{list.price}}</td>
                
                                        <td class="d-flex justify-content-center align-items-center">                    
                                            

                                            <button @click="CartStore.decrement(i,list.product_id)" class="btn btn-sm btn-danger">-</button>

                                            <span class="mx-2">₱ {{list.total.toLocaleString('en-US')}}</span>

                                            <button @click="CartStore.increment(i,list.stocks,list.price,list.product_id)" 
                                            class="btn btn-sm btn-success">+</button>
                                    
                                        </td>


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

                                    <h4 class="text-dark"><i class="fas fa-coins me-2 m-2 text-success"></i>
                                        VAT(12%): {{
                                            Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format((CartStore.grand_total * 0.12))                           
                                        }}
                                    </h4>

                                    <h4 class="text-dark"><i class="fas fa-coins me-2 m-2 text-success"></i>
                                        Grand Total: {{
                                            Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format((CartStore.grand_total + (CartStore.grand_total * .12)))                                                    
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
                                            <th scope="col" class="fw-bold">Price</th>
                                            <th scope="col" class="fw-bold">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody v-for="p in lists.data" :key="p.id">
                                            <tr>
                                                <td class="fw-bold"><img v-bind:src="storageLink + p.product.image" 
                                                class="img-fluid" width="100" height="100"></td>

                                                <td>{{p.product.product_name}}</td>

                                                
                                                <td class="fw-bold" v-if="p.stocks ==0">
                                                <span class="fw-bold text-danger">SOLD OUT</span></td>

                                                <td v-else>
                                                    {{p.stocks}}
                                                </td>



                                                <td>
                                                    {{Intl.NumberFormat('en-PH', 
                                                    { style: 'currency', currency: 'PHP' }).
                                                    format(p.product.price)}}
                                                </td>


                                                <td v-if="p.stocks == 0">
                                                    <button disabled class="btn btn-danger" 
                                                    @click="cart_add.add_cart(p.product_id,p.product.
                                                    product_name,p.stocks,p.product.price)">
                                                    +</button>
                                                </td>

                                                <td v-else>
                                                    <button class="btn btn-primary" 
                                                    @click="cart_add.add_cart(p.product_id,p.product.
                                                    product_name,p.stocks,p.product.price)">
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


        const transID = ref(Math.floor(Math.random() * 99999999999999) + 1)

        let product_lists = ref([]);
        let search_data = ref([]);
        const CartStore = useCartStore()
        const cart_add = useCartStore()
        const customer_name = ref("");
        const CashAmount = ref("");
        const changeMoney = ref("");



        const cart_order = CartStore.cart
        const show_alert = ref(false);
        const submit_btn = ref(false);


        const lists = computed(()=> CartStore.prod)
        const cart_lists = computed(()=> CartStore.cart)



        const modalActive = ref(false);
        const modalCash = ref(false);


        const isSidebar = ref(false);
        const quantity = ref('');

        const search_box = ref('');
        const typing = ref(false);

        const store = useStore();
        const router = useRouter();


        const toggleModal = () =>{
            modalActive.value = !modalActive.value;
        }

        /* watchEffect((onvalidate) =>{
        search_box.value

            if(search_box.value.length>0)
            {
                typing.value = true

                const typing_stats = setTimeout(()=>{
                    typing.value = false
                }, 700)

                onvalidate(()=>{
                    clearInterval(typing_stats)

                    axios_client.get('/search/' + search_box.value).then((res)=>{
                    product_lists.value = res.data

                
                    }).catch(error => {
                        console.log(error)
                    })
                })

            }

            else 
            {
                const typing_stats = setTimeout(()=>{
                    typing.value = false
                }, 1000)

                onvalidate(()=>{
                    clearInterval(typing_stats)
                })
            }

        }) */

       
        /* DATE TIME  */
    
        const date = new Date();
        const formatDate = date.toLocaleDateString("en-US")
        /* END OF DATE TIME */






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
            let total = (CartStore.grand_total + (CartStore.grand_total * .12));

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

                changeMoney.value = (CashAmount.value - total)       
            }
        }


        function completeOrder(){
            const today = new Date();
                const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = date +' '+ time;
        
                let form = new FormData();
                form.append('sub_total', Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format((CartStore.grand_total)))
                form.append('customer_name', customer_name.value)
                form.append('change', changeMoney.value)
                form.append('vat', Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(CartStore.grand_total * 0.12))


                form.append('grand_total',  
                Intl.NumberFormat('en-PH', 
                { style: 'currency', currency: 'PHP' }).format((CartStore.grand_total + (CartStore.grand_total * .12))))


                form.append('cart', JSON.stringify(cart_lists.value))
                form.append('purchase_date', dateTime)

                form.append('transactions_id', transID.value)


                axios_client.post("/checkout", form).then(response=>{
                    console.log(response.data)     
                    customer_name.value = ''
                    show_alert.value = true
                    CartStore.clear_cart()
                    CartStore.getProduct()
                    submit_btn.value = false
                    modalActive.value = false
                    transID.value = Math.floor(Math.random() * 99999999999999) + 1

                }).catch(error =>{
                    console.log(error.response)
                    submit_btn.value = false
                })
        }


        onMounted(()=> {
            CartStore.getProduct()
        })

        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }


        return {
            user: computed(() => store.state.user.data)
            ,product_lists,close,search_box,typing,logout,isSidebar,lists,cart_lists,quantity,modalActive,

            lists,cart_add,cart_lists,CartStore,search_data,checkout,customer_name,
            show_alert,cart_order,submit_btn,toggleModal,CashAmount,modalCash,invoice,changeMoney
            ,filter_input,storageLink,completeOrder,transID,formatDate
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
