<template>

<transition name="modalAnim">
<div v-if="modalActive" class="container-fluid d-flex justify-content-center align-items-center" 
style="width: 100%; height: 100%; position: fixed; overflow: auto; z-index: 1; background-color: rgba(0, 0, 0, 0.605); overflow: auto;">
    
    <div class="row container d-flex 
    justify-content-center align-items-center">

        <div class="col-lg-5 bg-light shadow-sm rounded-5 p-0">

            <div class="col-12 mb-4 text-start rounded-top-3 p-3" style="background-color: rgb(4, 180, 116);">
                <span class="fw-bold fs-3 text-white"><i class="fas fa-circle-plus me-3">
                </i>Add new category</span>
            </div>

            <div class="div p-4">          

                <div class="col-12 mb-4">
                    <input type="text" class="form-control" v-model="category.catname" placeholder="Enter category name">
                </div>

                <div class="col-12">
                    <input type="text" class="form-control" v-model="category.desc" placeholder="Description">
                </div>

            </div>


            <div class="col-12 border border-black px-3">
                
            </div>

            <div class="d-flex justify-content-end p-3">
                <button class="btn btn-danger me-2" @click="toggleModal">Close</button>

                <form @submit.prevent="create_category()">
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
                
            </div>

        
        </div>
    </div>
</div>
</transition>



<transition name="modalAnim">
    <logout :logoutModal="logoutModal" @close="togglelogoutModal"></logout>
</transition>





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
                    <div id="sidebtn" class="bg-light fs-5 
                    list-group-item-action d-flex justify-content-center rounded-5" >

                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="fas fa-chart-pie me-4"></i>
                        </div>
                           
                        <div class="div w-100">
                            <span class="fs-4">Dashboard</span>
                        </div>

                    </div>                  
                    </router-link>

          
                    <router-link :to="{name: 'products'}">
                    <div id="sidebtn" class=" fs-5 list-group-item-action 
                    d-flex justify-content-center rounded-5 mt-2" style="background-color: 
                    rgb(185, 232, 206); color: rgb(57, 164, 59);">

                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="bi bi-box-seam-fill me-4"></i>
                        </div>
                           
                        <div class="div w-100">
                            <span class="fs-4">Products</span>
                        </div>

                    </div>
                    </router-link>

                    

                    <router-link :to="{name: 'inventory'}">
                        
                        <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center rounded-5 mt-2" >

                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="fas fa-boxes-stacked me-4"></i>
                        </div>
                           
                        <div class="div w-100">
                            <span class="fs-4">Inventory</span>
                        </div>

                    </div>

                    </router-link>


                    <router-link :to="{name: 'transaction'}">
                    <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center rounded-5 mt-2" >
                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="fas fa-receipt me-4 fa-lg"></i>
                        </div>
                           
                        <div class="div w-100">
                            <span class="fs-4">Transactions</span>
                        </div>
                    </div>
                    </router-link>


                    <router-link :to="{name: 'sales'}">       
                        <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center rounded-5 mt-2" >
                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="fas fa-chart-line me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Sales History</span>
                            </div>
                        </div>
                    </router-link>


                
                    <router-link :to="{name: 'records'}">
                        <div id="sidebtn" class="fs-5 list-group-item-action d-flex justify-content-center rounded-5 mt-2" >
                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="bi bi-database-fill me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Records</span>
                            </div>
                        </div>
                    </router-link>


                    <router-link :to="{name: 'archive'}">
                        <div id="sidebtn" class="fs-5 list-group-item-action 
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
                        <div id="sidebtn" class="fs-5 list-group-item-action 
                        d-flex justify-content-center rounded-5 mt-2" >

                            <div class="div d-flex justify-content-center align-items-center">
                                <i class="fas fa-gear me-4"></i>
                            </div>
                            
                            <div class="div w-100">
                                <span class="fs-4">Settings</span>
                            </div>

                        </div>
                    </router-link>



                    <!-- <a id="sidebtn" role="button" 
                    class="fs-5  d-flex justify-content-center rounded-5 mt-2" >
                        <div class="div d-flex justify-content-center align-items-center">
                            <i class="bi bi-power me-2"></i>
                        </div>
                           
                        <div class="div w-100">
                            <span class="fs-4">Logout</span>
                        </div>
                    </a> -->

              
                </div>

            </div>
     

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->

        <div id="page-content-wrapper">

            <!-- navbar navbar-expand-lg navbar-light bg-transparent --> 

            <nav class="py-4 px-4">  
                <div class="d-flex justify-content-between w-100">
                    <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon"><i class="fas fa-bars me-3 fa-2x"></i></a>
                    
                    <h2 class="fs-4 fw-bold"><i class="fas fa-store me-2"></i>Products</h2>
                    
                    <div class="div">
    
                        <span class="fs-5 h-100 me-4">{{ formatDate }}</span>   

                        <a role="button" class="fw-bold text-dark fs-5" 
                        @click="togglelogoutModal"><i class="fas 
                        fa-arrow-right-from-bracket me-2"></i>
                        Logout</a>

                    </div>

                </div>
            </nav>

            <div class="container-fluid px-4">

                <router-link :to="{name: 'add_product'}">
                    <button type="button" class="btn btn-dark mt-3 modal-add">
                        Add new product
                    </button>
                </router-link>

                <button class="btn btn-dark mt-3 modal-add" @click="toggleModal">Add new category</button>



                <div v-if="loading" class="p-3 d-flex justify-content-center align-items-center container-fluid h-100 mt-3">
                    <span class="spinner-border spinner-border-lg  p-3" aria-hidden="true" style="font-size: ;"></span>
                 </div>  



                 
                
                 <!-- PRODUCT TABLE -->
                <div v-else class="table-responsive">
                    <h4 class="mt-3 mb-3 w-100 bg-light p-3"><i class="fas fa-box-open me-2"></i>Product Info Lists</h4>

                    <div class="container-fluid d-flex justify-content-center mb-3 mt-3">
                        <div class="col-10">
                            <input type="text" @keydown.enter="search" role="searchbox" v-model="search_box" class="form-control rounded-5 p-2" 
                            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search Product">
                        </div>

                        <div class="col-1 d-flex justify-content-center p-0 m-0 mx-4">
                            <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
                        </div>                 
                    </div>


                    <h4 v-if="typing" class="w-100 text-center d-flex justify-content-center align-items-center loading">Loading....</h4>

                    <table v-else class="table table-hover table-borderless text-center w-100">
                        <thead style="background-color: #04b4738d;">
                            <tr>
                                <th scope="col" class="fw-bold">Image</th>
                                <th scope="col" class="fw-bold">Serial Number</th>
                                <th scope="col" class="fw-bold">Manufacturer</th>
                                <th scope="col" class="fw-bold">Category</th>
                                <th scope="col" class="fw-bold">Product Name</th>
                                <th scope="col" class="fw-bold">Description</th>
                                <th scope="col" class="fw-bold">Size Name</th>
                                <th class="fw-bold" >Actions</th>
                            </tr>

                        </thead>
                    <tbody v-for="product in product_lists.data" :key="product.id">

                        <img src="" alt="">
                        
                        <tr>
                            <td class="fw-bold"><img v-bind:src="storageLink + product.image" 
                            class="img-fluid" width="100" height="100"></td>

                            <td hidden>{{product.id}}</td>
                                <td class="fw-bold">{{product.serial_number}}</td>
                                <td class="fw-bold">{{product.manufacturer}}</td>
                                <td class="fw-bold">{{product.category.category}}</td>
                                <td class="fw-bold">{{product.product_name}}</td>
                                <td class="fw-bold">{{product.description}}</td>
                                <td class="fw-bold">{{product.size}}</td>
                            <td class="m-3">

                                <RouterLink :to="{name: 'edit_product', params:{id:product.id} }">
                                    <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                                </RouterLink>
                                
                                <button type="button" class="btn btn-warning mx-1 mt-2" @click.prevent="del_prod(product.id)">
                                <i class="fas fa-box-archive"></i></button>

                            </td>
                        </tr>
                    </tbody>
                    </table>


                    <div class="d-flex justify-content-end align-items-center" >
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="product_lists" class="shadow-sm"  
                        @pagination-change-page="getProduct, search"
                        />
                    </div>            
                </div>
                <!-- END OF PRODUCT TABLE -->


                <!-- CATEGORY TABLE -->
                <div class="table-responsive">
                    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-filter me-2"></i>Category Lists</h4>
    
                    <table class="table table-hover table-borderless text-center w-100">
                        <thead style="background-color: #04b4738d;">
                            <tr>
                                <th scope="col" class="fw-bold">ID</th>
                                <th scope="col" class="fw-bold">Category Name</th>
                                <th scope="col" class="fw-bold">Description</th>
                                <th class="fw-bold" >Actions</th>
                            </tr>

                        </thead>
                    <tbody v-for="cat in category_lists.data" :key="cat.id">
                        <tr>
                            <td class="fw-bold">{{cat.id}}</td>
                            <td class="fw-bold">{{cat.category}}</td>
                            <td class="fw-bold">{{cat.description}}</td>
  
                            <td class="m-3">

                                <RouterLink :to="{name: 'edit_product', params:{id:cat.id} }">
                                    <button class="btn btn-success" data-mdb-toggle="tooltip" 
                                    data-mdb-placement="left" title="Edit"><i class="bi bi-pencil-square">
                                    </i></button>
                                </RouterLink>
                                
                                <button type="button" class="btn btn-warning mx-1 mt-2" data-mdb-toggle="tooltip" 
                                data-mdb-placement="left" title="Edit" @click.prevent="del_cat(cat.id)">
                                <i class="fas fa-box-archive"></i></button>

                            </td>
                        </tr>
                    </tbody>
                    </table>


                    <div class="d-flex justify-content-end align-items-center" >
                        <Bootstrap5Pagination :limit="1" :keepLength="true" :data="category_lists" class="shadow-sm"  
                        @pagination-change-page="getCat"
                        />
                    </div>            
                </div>
                <!-- END OF CATEGORY TABLE -->


        </div>











    </div>
</div>


    
    <!-- /#page-content-wrapper -->

</body>

</template>


<script>
import '../assets/dashboard.css'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';


import { computed, toHandlers } from "vue";
import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect } from 'vue';
import {useVuelidate} from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import  modalComponent  from '@/components/modalComponent.vue';
import { StreamBarcodeReader } from "vue-barcode-reader";
import logout from '../components/modal/logout.vue';

export default {
    name: 'products',

    components: {
    Bootstrap5Pagination,
    StreamBarcodeReader,
    logout
},



    setup(){
        
        let product_lists = ref([]);
        let category_lists = ref([]);
        const isOpen = ref(false);

        const search_box = ref('');


        const typing = ref(false);
        const isSidebar = ref(false);
        const loading = ref(true);
        const modalActive = ref(false);

        const storageLink = ref('http://127.0.0.1:8000/storage/images/');


        /* SEARCH FUNCTION */

        const search  = async(page = 1) => {

            if(search_box.value == ''){
                axios_client.get('/products?page=' + page)
                .then(response=>{
                    product_lists.value = response.data;

                    loading.value = false;
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }

            else {
                axios_client.get('/search/' + search_box.value + '?page=')
                .then(response=>{    
                    

                    product_lists.value = response.data;
                  
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }
        }



        /* FOR LOGOUT MODAL */
        const logoutModal = ref(false);
        const togglelogoutModal = () => {
            logoutModal.value = !logoutModal.value
        }
        /* END OF FOR LOGOUT MODAL */


        

        const category  = reactive({
            desc: '',
            catname: '',
        })


        
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
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date();
        const formatDate = date.toLocaleDateString("en-US", options)
        /* END OF DATE TIME */



        /* DELETE A PRODUCT */
        function del_prod(id){
            let url = '/delete/' + id;
            axios_client.put(url).then(response => {
                this.getProduct()
            })
        }



        /* DELETE A CATEGORY */
         function del_cat(id){
            let url = '/delete/category/' + id;
            axios_client.put(url).then(response => {
                this.getCat()
            }).catch(error => {
                console.log(error.response.data)
            })
        }


        /* GET PRODUCT TABLE */
        const getProduct = async(page = 1) => {
            axios_client.get('/products?page=' + page)
            .then(response=>{
                product_lists.value = response.data;

                loading.value = false;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        /* GET CATEGORY TABLE */
        const getCat = async(page = 1) => {
            axios_client.get('/index/category?page=' + page)
            .then(response=>{
                category_lists.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        /* CREATE CATEGORY */
        function create_category(){
            let formData = new FormData();
            formData.append('category', this.category.catname);
            formData.append('desc', this.category.desc);

            axios_client.post('/category', formData)
            .then(response=>{
                console.log(response.data);
                this.getCat();
                modalActive.value = !modalActive.value;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


    
        onMounted(()=> {
            getProduct()
            getCat()
        })

        return {
            product_lists,del_prod,getProduct,typing,loading,isSidebar,
            modalActive,toggleModal,create_category,category,getCat,category_lists,del_cat,isOpen,formatDate
            ,logoutModal,togglelogoutModal,storageLink,search,search_box
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
