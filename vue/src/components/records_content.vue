<template>

    <div v-if="loading" class="div p-3 flex-column d-flex justify-content-center align-items-center container-fluid" style="height: 100vh;">
        <p class="fw-bold fs-3">Loading...</p>
        <span class="spinner-border spinner-border-sm  p-3" aria-hidden="true" style="font-size: ;"></span>
    </div>  


<div v-else class="div">

    <!-- CHOICES TAB -->
    <ul class="nav nav-underline mb-3 d-flex justify-content-center mt-3" id="pills-tab" role="tablist">

        <li class="nav-item col-lg-1.5 me-3" role="presentation">
            <button class="nav-link active fs-5" id="pills-sold-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-sold" type="button" 
            role="tab" aria-controls="pills-sold" aria-selected="true" style="color: #04B474">
            <i class="fas fa-triangle-exclamation me-2"></i>
            Sold Items</button>
        </li>


        <li class="nav-item col-lg-1.5  me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-critical-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-critical" type="button" 
            role="tab" aria-controls="pills-critical" aria-selected="true" style="color: #04B474">
            <i class="fas fa-triangle-exclamation me-2"></i>
            Critical Stocks</button>
        </li>


        
        <li class="nav-item col-lg-1.5 me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-critical-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-expired" type="button" 
            role="tab" aria-controls="#pills-expired" aria-selected="true" style="color: #04B474">
            <i class="fas fa-triangle-exclamation me-2"></i>
            Expired Products</button>
        </li>

        <li class="nav-item col-lg-1.5 me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-orders-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-orders" type="button" 
            role="tab" aria-controls="#pills-orders" aria-selected="true" style="color: #04B474">
            <i class="fas fa-cart-shopping me-2"></i>
            Orders</button>
        </li>



        <li class="nav-item col-lg-1.5 me-3" role="presentation" >
            <button class="nav-link fs-5" id="pills-inventory-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-inventory" type="button" 
            role="tab" aria-controls="pills-inventory" aria-selected="false" style="color: #04B474">
            <i class="fas fa-box me-2" ></i>
            Inventory Lists</button>
        </li>


        <li class="nav-item col-lg-1.5  me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-cancel-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-cancel" type="button" 
            role="tab" aria-controls="pills-cancel" aria-selected="false" style="color: #04B474">
            <i class="fas fa-ban me-2"></i>
            Orders Void</button>
        </li>


        <li class="nav-item col-lg-1.5  me-3" role="presentation">
            <button class="nav-link w-70 fs-5" id="pills-stock-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-stock" type="button" 
            role="tab" aria-controls="pills-stock" aria-selected="false" style="color: #04B474">
            <i class="far fa-clock me-2"></i>
            Stock History</button>
        </li>


        </ul>

          

            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-sold" role="tabpanel" aria-labelledby="pills-sold-tab" tabindex="0">
                    
                <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-database me-2"></i>Product Lists</h4>
                <div class="table-responsive">
                    
                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Product Name</th>
                            <th class="fw-bold">Total of sold items</th>
                            <th class="fw-bold">Total Income</th>

                            <!-- <th>Actions</th> -->
                            </tr>
                        </thead>

                    <tbody v-for="sold in items_sold" class="">
                        <tr>
                            <td class="fw-bold">{{sold.product_name}}</td>
                            <td class="fw-bold">{{sold.sold_items}}</td>

                            <td class="fw-bold">₱ {{sold.money}}</td>


                            <!-- <td class="m-3">
                                <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger mx-1 mt-2" @click.prevent="del_prod(product.id)"><i class="bi bi-trash3-fill"></i></button>
                            </td> -->
                        </tr>

                    </tbody>
                    </table>


                    <!-- <div class="d-flex justify-content-end align-items-center" >
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="product_lists" class="shadow-sm"  
                        @pagination-change-page="getProduct"
                        />
                    </div> -->

                </div>









                </div>



                <div class="tab-pane fade show" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab" tabindex="0">Stock</div>

                <div class="tab-pane fade show" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab" tabindex="0">Cancelled Order</div>




                <!-- INVENTORY TAB -->
                <div class="tab-pane fade" id="pills-inventory" role="tabpanel" aria-labelledby="pills-inventory-tab" tabindex="0">

                <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-database me-2"></i>Inventory Lists</h4>
                <div class="table-responsive">
                    

                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Serial Number</th>
                            <th class="fw-bold">Manufacturer</th>
                            <th class="fw-bold">Product Name</th>
                            <th class="fw-bold">Description</th>
                            <th class="fw-bold">Size Name</th>
                            <th class="fw-bold">Stock</th>
                            <th class="fw-bold">Date of Production</th>
                            <th class="fw-bold">Expiration Date</th>
                            <!-- <th>Actions</th> -->
                            </tr>
                        </thead>

                    <tbody v-for="i in inventory_lists.data" :key="i.id">
                        <tr>
                            <td class="fw-bold">{{i.product.serial_number }}</td>
                            <td class="fw-bold">{{i.product.product_name }}</td>
                            <td class="fw-bold">{{i.supplier }}</td>
                            <td class="fw-bold">{{i.category }}</td>
                            <td class="fw-bold">{{i.product.price }}</td>
                            <td class="fw-bold">{{i.stocks }}</td>
                            <td class="fw-bold">{{i.production_date }}</td>
                            <td class="fw-bold">{{i.expiration_date }}</td>


                            <!-- <td class="m-3">
                                <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger mx-1 mt-2" @click.prevent="del_prod(product.id)"><i class="bi bi-trash3-fill"></i></button>
                            </td> -->
                        </tr>

                    </tbody>
                    </table>


                    <div class="d-flex justify-content-end align-items-center" >
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="inventory_lists" class="shadow-sm"  
                        @pagination-change-page="getInventory"
                        />
                    </div>

                </div>


                </div>
                <!-- END OF INVENTORY TAB -->




                <!-- CRITICAL TAB -->
                <div class="tab-pane fade" id="pills-critical" role="tabpanel" aria-labelledby="pills-critical-tab" tabindex="0">

                    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-arrow-trend-down me-2"></i><span class="fw-bold">Critical Stocks</span></h4>
                    
                    <div class="table-responsive">
                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Serial Number</th>
                            <th class="fw-bold">Manufacturer</th>
                            <th class="fw-bold">Product Name</th>
                            <th class="fw-bold">Size</th>
                            <th class="fw-bold">Stock</th>
                            <th class="fw-bold">Status</th>
                            <!-- <th>Actions</th> -->
                            </tr>
                        </thead>

                        <tbody v-for="c in criticalStocks.data" :key="c.id" >
                            <tr>
                                <td hidden>{{c.id}}</td>
                                <td class="fw-bold">{{c.product.serial_number}}</td>
                                <td class="fw-bold">{{c.product.manufacturer}}</td>
                                <td class="fw-bold">{{c.product.product_name}}</td>
                                <td class="fw-bold">{{c.product.size}}</td>
                                <td class="fw-bold text-danger">{{c.stocks}}</td>
                                <td class="fw-bold text-danger">Critical</td>`
                            </tr>
                        </tbody>


                        <div class="d-flex justify-content-end align-items-center" > 
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="criticalStocks" class="shadow-sm"  
                        @pagination-change-page="getCriticalStocks"/>
                        </div>


                    </table>
                </div>
                    
                </div>
                <!-- END OF CRITICAL TAB -->



            
                <!-- EXPIRED TAB -->
                <div class="tab-pane fade" id="pills-expired" role="tabpanel" aria-labelledby="pills-expired-tab" tabindex="0">

                    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-calendar me-2"></i>
                    <span class="fw-bold">Expired Products</span></h4>

                    <div class="table-responsive">
                    

                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Serial Number</th>
                            <th class="fw-bold">Manufacturer</th>
                            <th class="fw-bold">Product Name</th>
                            <th class="fw-bold">Description</th>
                            <th class="fw-bold">Size Name</th>
                            <th class="fw-bold">Stock</th>
                            <th class="fw-bold">Date of Production</th>
                            <th class="fw-bold">Expiration Date</th>
                            <th class="fw-bold">Status</th>
                            <!-- <th>Actions</th> -->
                            </tr>
                        </thead>

                        <tbody v-for="e in expired_lists.data" :key="e.id" class="">
                            <tr>
                                <td hidden>{{e.id}}</td>
                                <td class="fw-bold" >{{e.product.serial_number}}</td>
                                <td class="fw-bold" >{{e.product.manufacturer}}</td>
                                <td class="fw-bold" >{{e.product.product_name}}</td>
                                <td class="fw-bold text-center" style="word-break: break-all;" >{{e.product.description}}</td>
                                <td class="fw-bold" >{{e.product.size}}</td>
                                <td class="fw-bold" >{{e.stocks}}</td>
                                <td class="fw-bold" >{{e.production_date}}</td>
                                <td class="fw-bold text-danger fw-bold" >{{e.expiration_date}}</td>
                                <td class="fw-bold text-danger fw-bold" >Expired</td>

                                <!-- <td class="m-3">
                                    <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" class="btn btn-danger mx-1 mt-2" @click.prevent="del_prod(product.id)"><i class="bi bi-trash3-fill"></i></button>
                                </td> -->
                            </tr>

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end align-items-center" > 
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="expired_lists" class="shadow-sm"  
                        @pagination-change-page="expired_prod"
                        />
                    </div>


                </div>
                    
                </div>
                <!-- END OF CRITICAL TAB -->



                <!-- ORDER TAB -->
                 <div class="tab-pane fade" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab" tabindex="0">

                    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-cart-shopping me-2"></i>
                    <span class="fw-bold">Orders</span></h4>

                    <div class="table-responsive">
                    

                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Customer Name</th>
                            <th class="fw-bold">Gross Total</th>
                            <th class="fw-bold">Discount</th>
                            <th class="fw-bold">Net Total</th>
                            <th class="fw-bold">Change</th>
                            <th class="fw-bold">Purchase Date</th>
                            <th class="fw-bold">Status</th>
                            <th class="fw-bold">View Order</th>
                            </tr>
                        </thead>

                        <tbody v-for="o in orders.data" :key="o.id" class="">
                            <tr>
                                <td class="fw-bold" >{{o.customer_name}}</td>
                                <td class="fw-bold" >{{o.gross_total}}</td>
                                <td class="fw-bold" >{{o.discount}}</td>
                                <td class="fw-bold" > ₱ {{o.net_total}}</td>
                                <td class="fw-bold" >₱ {{o.change}}</td>          
                                <td class="fw-bold" >{{o.purchase_date}}</td>
                                <td class="fw-bold" >{{o.status}}</td>
                                <td class="m-3">
                                    <button class="btn btn-primary"><i class="far fa-eye"></i></button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end align-items-center" > 
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="orders" class="shadow-sm"  
                        @pagination-change-page="getOrders"
                        />
                    </div>


                </div>
                    
                </div>
                <!-- END OF ORDER TAB -->
            

            </div>


</div>





</template>


<script>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect } from 'vue';

export default {
    name: 'records_content',

    components: {
        Bootstrap5Pagination
    },

    setup(){
        let inventory_lists = ref([]);
        let stock_lists = ref([]);
        let expired_lists = ref([]);
        let items_sold = ref([]);

        const criticalStocks = ref([]);
        const orders = ref([]);


        const loading = ref(true);


        /* GET INVENTORY TABLE */
        const getInventory = async(page = 1) => {
            axios_client.get('/inventory?page=' + page).then(response=>{
                inventory_lists.value = response.data;
                loading.value = false;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }








        /* GET ORDERS TABLE */
        const getOrders = async(page = 1) => {
            axios_client.get('/orders?page=' + page).then(response=>{
                orders.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


         /* GET CRITICAL STOCKS TABLE */
         const getCriticalStocks = async(page = 1) => {
            axios_client.get('/critical/stocks?page=' + page).then(response=>{
                criticalStocks.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        }





        /* LISTS OF EXPIRED PRODUCT */
        const expired_prod = async(page = 1) => {
            axios_client.get('/expiration?page=' + page).then(response=>{
                /* console.log(response.data.expiration_date) */

                expired_lists.value = response.data;
              
            }).catch(error =>{
                console.log(error.response)
            })
        }


        /* LISTS OF SOLD ITEMS */
        const sold_items = async() => {
            axios_client.get('/sold').then(response=>{       
                items_sold.value = response.data.sold;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        function del_prod(id){
            let url = '/delete/' + id;
            axios_client.delete(url).then(response => {
                this.getProduct()
            })
        }


        onMounted(()=> {
            getInventory()
            expired_prod()
            sold_items()
            getCriticalStocks()
            getOrders()
        })

        return {
            inventory_lists,stock_lists,getInventory,del_prod,loading,expired_prod,expired_lists,items_sold,sold_items
            ,getCriticalStocks,criticalStocks,getOrders,orders
        }


    }
}
</script>