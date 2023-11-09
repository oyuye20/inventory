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
            <i class="fas fa-receipt me-2"></i>
            Sold Items</button>
        </li>


        <li class="nav-item col-lg-1.5  me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-critical-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-critical" type="button" 
            role="tab" aria-controls="pills-critical" aria-selected="true" style="color: #04B474">
            <i class="fas fa-arrow-trend-down me-2"></i>
            Critical Stocks</button>
        </li>


        
        <li class="nav-item col-lg-1.5 me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-critical-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-expired" type="button" 
            role="tab" aria-controls="#pills-expired" aria-selected="true" style="color: #04B474">
            <i class="fas fa-calendar-xmark me-2"></i>
            Expired Products</button>
        </li>


        <li class="nav-item col-lg-1.5 me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-expiring-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-expiring" type="button" 
            role="tab" aria-controls="#pills-expiring" aria-selected="true" style="color: #04B474">
            <i class="far fa-hourglass-half me-2"></i>
            Expiring Products</button>
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


        <!-- <li class="nav-item col-lg-1.5 me-3" role="presentation" >
            <button class="nav-link fs-5" id="pills-supplier-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-supplier" type="button" 
            role="tab" aria-controls="pills-supplier" aria-selected="false" style="color: #04B474">
            <i class="fas fa-truck me-2"></i>
            Supplier</button>
        </li> -->



        <!-- <li class="nav-item col-lg-1.5  me-3" role="presentation">
            <button class="nav-link fs-5" id="pills-cancel-tab" 
            data-bs-toggle="pill" data-bs-target="#pills-cancel" type="button" 
            role="tab" aria-controls="pills-cancel" aria-selected="false" style="color: #04B474">
            <i class="fas fa-ban me-2"></i>
            Orders Void</button>
        </li> -->


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

                   
                <h4 class="mt-3 w-100 bg-light p-3 fw-bold"><i class="fas fa-receipt me-2"></i>Sold Items</h4>


                <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                    <div class="col-10 me-3">
                        <input type="text" @keydown.enter="search" role="searchbox" class="form-control rounded-5 p-2" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" placeholder="Search sold items">
                    </div>

                    <div class="col-2 d-flex justify-content-center p-0 m-0">
                        <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
                    </div>
                </div>


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

                    <tbody v-for="sold in items_sold">
                        <tr>
                            <td>{{sold.product_name}}</td>
                            <td>{{sold.sold_items}}</td>
                            <td>₱ {{sold.money}}</td>


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



                <div class="tab-pane fade show" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab" tabindex="0">
                    
                    <h4 class="mt-3 w-100 bg-light p-3 fw-bold"><i class="far fa-clock me-2"></i>Stock History</h4>


                <!-- <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                    <div class="col-10 me-3">
                        <input type="text" @keydown.enter="getInventory" role="searchbox" v-model="search_inventory" class="form-control rounded-5 p-2" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" placeholder="Search inventory">
                    </div>

                    <div class="col-2 d-flex justify-content-center p-0 m-0">
                        <button class="btn btn-success" @click="getInventory"><i class="fas fa-magnifying-glass"></i></button>
                    </div>
                </div> -->

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
                            <th class="fw-bold">Stock By</th>
                            <th class="fw-bold">Stock Date</th>
                            <!-- <th>Actions</th> -->
                            </tr>
                        </thead>

                    <tbody v-for="i in stockHistory_lists.data" :key="i.id">
                        <tr>
                            <td>{{i.product.serial_number }}</td>
                            <td>{{i.product.product_name }}</td>
                            <td>{{i.supplier }}</td>
                            <td>{{i.category }}</td>
                            <td>{{i.product.price }}</td>
                            <td>{{i.stocks }}</td>
                            <td>{{i.stock_by }}</td>
                            <td>{{i.created_at}}</td>


                            <!-- <td class="m-3">
                                <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger mx-1 mt-2" @click.prevent="del_prod(product.id)"><i class="bi bi-trash3-fill"></i></button>
                            </td> -->
                        </tr>

                    </tbody>
                    </table>


                    <div class="d-flex justify-content-end align-items-center" >
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="stockHistory_lists" class="shadow-sm"  
                        @pagination-change-page="stockHistory"
                        />
                    </div>

                </div>
                    
          
                </div>




                <div class="tab-pane fade show" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab" tabindex="0">Cancelled Order</div>




                <!-- INVENTORY TAB -->
                <div class="tab-pane fade" id="pills-inventory" role="tabpanel" aria-labelledby="pills-inventory-tab" tabindex="0">

                <h4 class="mt-3 w-100 bg-light p-3 fw-bold"><i class="fas fa-box me-2" ></i>Inventory Lists</h4>


                <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                    <div class="col-10 me-3">
                        <input type="text" @keydown.enter="getInventory" role="searchbox" v-model="search_inventory" class="form-control rounded-5 p-2" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" placeholder="Search inventory">
                    </div>

                    <div class="col-2 d-flex justify-content-center p-0 m-0">
                        <button class="btn btn-success" @click="getInventory"><i class="fas fa-magnifying-glass"></i></button>
                    </div>
                </div>





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
                            <td>{{i.product.serial_number }}</td>
                            <td>{{i.product.product_name }}</td>
                            <td>{{i.supplier }}</td>
                            <td>{{i.category }}</td>
                            <td>{{i.product.price }}</td>
                            <td>{{i.stocks }}</td>

                            <td v-if="i.production_date == null">
                                No Date
                            </td>

                            <td v-else>
                                <td>{{i.production_date }}</td>
                            </td>



                            <td v-if="i.expiration_date == null">
                                No expiration date
                            </td>

                            <td v-else>
                                <td>{{i.expiration_date }}</td>
                            </td>



                            
                          


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

                    <h4 class="mt-3 w-100 bg-light p-3">
                        <i class="fas fa-arrow-trend-down me-2"></i>
                    <span class="fw-bold">Critical Stocks</span></h4>


                    <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                        <div class="col-10 me-3">
                            <input type="text" @keydown.enter="getCriticalStocks" role="searchbox" v-model="search_critical" class="form-control rounded-5 p-2" 
                            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search critical stocks">
                        </div>

                        <div class="col-2 d-flex justify-content-center p-0 m-0">
                            <button class="btn btn-success" @click="getCriticalStocks"><i class="fas fa-magnifying-glass"></i></button>
                        </div>
                    </div>



                    
                    <div class="table-responsive">
                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Serial Number</th>
                            <th class="fw-bold">Manufacturer</th>
                            <th class="fw-bold">Product Name</th>
                            <th class="fw-bold">Size</th>
                            <th class="fw-bold">Safety Stock</th>
                            <th class="fw-bold">Stock</th>
                            <th class="fw-bold">Status</th>
                            <!-- <th>Actions</th> -->
                            </tr>
                        </thead>

                        <tbody v-for="c in criticalStocks.data" :key="c.id" >
                            <tr>
                                <td hidden>{{c.id}}</td>
                                <td>{{c.product.serial_number}}</td>
                                <td>{{c.product.manufacturer}}</td>
                                <td>{{c.product.product_name}}</td>
                                <td>{{c.product.size}}</td>
                                <td>{{c.safety_stocks}}</td>
                                <td class="fw-bold text-danger">{{c.stocks}}</td>
                                <td class="fw-bold text-danger">Critical</td>
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

                    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-calendar-xmark me-2"></i>
                    <span class="fw-bold">Expired Products</span></h4>


                    <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                        <div class="col-10 me-3">
                            <input type="text" @keydown.enter="search" role="searchbox" class="form-control rounded-5 p-2" 
                            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search expired products">
                        </div>

                        <div class="col-2 d-flex justify-content-center p-0 m-0">
                            <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
                        </div>
                    </div>

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
                                <td>{{e.product.serial_number}}</td>
                                <td>{{e.product.manufacturer}}</td>
                                <td>{{e.product.product_name}}</td>
                                <td style="word-break: break-all;" >{{e.product.description}}</td>
                                <td>{{e.product.size}}</td>
                                <td>{{e.stocks}}</td>
                                <td>{{e.production_date}}</td>
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


                <!-- EXPIRING TAB -->
                <div class="tab-pane fade" id="pills-expiring" role="tabpanel" aria-labelledby="pills-expiring-tab" tabindex="0">

                    <h4 class="mt-3 w-100 bg-light p-3"><i class="far fa-hourglass-half me-2"></i>
                    <span class="fw-bold">Expiring Products</span></h4>


                    <!-- <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                        <div class="col-10 me-3">
                            <input type="text" @keydown.enter="search" role="searchbox" class="form-control rounded-5 p-2" 
                            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search expired products">
                        </div>

                        <div class="col-2 d-flex justify-content-center p-0 m-0">
                            <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
                        </div>
                    </div> -->


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

                            <tbody v-for="e in expiringStocks.data" :key="e.id" class="">
                                <tr>
                                    <td hidden>{{e.id}}</td>
                                    <td>{{e.product.serial_number}}</td>
                                    <td>{{e.product.manufacturer}}</td>
                                    <td>{{e.product.product_name}}</td>
                                    <td style="word-break: break-all;" >{{e.product.description}}</td>
                                    <td>{{e.product.size}}</td>
                                    <td>{{e.stocks}}</td>
                                    <td>{{e.production_date}}</td>
                                    <td class="fw-bold text-warning fw-bold" >{{e.expiration_date}}</td>
                                    <td class="fw-bold text-warning fw-bold" >Expiring</td>

                                    <!-- <td class="m-3">
                                        <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-danger mx-1 mt-2" @click.prevent="del_prod(product.id)"><i class="bi bi-trash3-fill"></i></button>
                                    </td> -->
                                </tr>

                            </tbody>
                        </table>

                    <div class="d-flex justify-content-end align-items-center" > 
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="expiringStocks" class="shadow-sm"  
                        @pagination-change-page="filterExpiringProd"
                        />
                    </div>
                </div>
                    
                </div>
                <!-- END OF CRITICAL TAB -->



                <!-- ORDER TAB -->
                 <div class="tab-pane fade" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab" tabindex="0">

                    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-cart-shopping me-2"></i>
                    <span class="fw-bold">Orders</span></h4>

                    <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                        <div class="col-10 me-3">
                            <input type="text" @keydown.enter="search" role="searchbox" v-model="search_inventory" class="form-control rounded-5 p-2" 
                            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search inventory">
                        </div>

                        <div class="col-2 d-flex justify-content-center p-0 m-0">
                            <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                    

                    <table class="table table-hover table-borderless text-center">
                        <thead>
                            <tr>
                            <th class="fw-bold">Transaction ID</th>
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
                                <td>{{o.transactions_id}}</td>
                                <td>{{o.customer_name}}</td>
                                <td>{{o.gross_total}}</td>
                                <td>{{o.discount}}%</td>
                                <td>₱ {{o.net_total}}</td>
                                <td>₱ {{o.change}}</td>          
                                <td>{{o.purchase_date}}</td>
                                <td>{{o.status}}</td>
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
        const stockHistory_lists = ref([]);
        const expiringStocks = ref([]);




        const search_inventory = ref('');
        const search_expired = ref('');
        const search_order = ref('');
        const search_critical = ref('');
        const search_sold = ref('');



        const loading = ref(true);


        /* GET INVENTORY TABLE  AND SEARCH*/
        const getInventory = async(page = 1) => {

            if(search_inventory.value == ''){
                axios_client.get('/inventory?page=' + page).then(response=>{
                    inventory_lists.value = response.data;
                    loading.value = false;

                }).catch(error =>{
                    console.log(error.response.data)
                })
            }

            else {
                axios_client.get('/inventory/search/' + search_inventory.value  + '?page=' + page).then(response=>{
                    inventory_lists.value = response.data;
                    loading.value = false;

                }).catch(error =>{
                    console.log(error.response.data)
                })
             
            }    
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

            if(search_critical.value == ''){
                axios_client.get('/critical/stocks?page=' + page).then(response=>{
                    criticalStocks.value = response.data
                }).catch(error =>{
                    console.log(error.response.data)
                })     
            }

            else {
                axios_client.get('/critical/search/' + search_critical.value  + '?page=' + page).then(response=>{
                    criticalStocks.value = response.data
                }).catch(error =>{
                    console.log(error.response.data)
                })       
             
            }            
        }



        const stockHistory = async(page = 1) => {
            axios_client.get('/stock/history?page=' + page).then(response=>{

                stockHistory_lists.value = response.data;
              
            }).catch(error =>{
                console.log(error.response)
            })
        }




        /* GET EXPIRING PRODUCTS */
        const filterExpiringProd = async(page = 1) => {
            axios_client.get('/expiring/products?page=' + page).then(response=>{
                expiringStocks.value = response.data    
            }).catch(error =>{
                console.log(error.response)
            })
        }






        /* LISTS OF EXPIRED PRODUCT */
        const expired_prod = async(page = 1) => {
            axios_client.get('/expiration?page=' + page).then(response=>{
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
            stockHistory()
            filterExpiringProd()
        })

        return {
            inventory_lists,stock_lists,expiringStocks,getInventory,del_prod,loading,expired_prod,expired_lists,items_sold,sold_items
            ,getCriticalStocks,stockHistory,filterExpiringProd,criticalStocks,getOrders,orders,stockHistory_lists,

            search_inventory, search_expired, search_order, search_critical, search_sold, 
        }


        

    }
}
</script>