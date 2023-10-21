<template>
    <div>
       
        <div class="table-responsive mb-3">
            <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-filter me-2"></i>Product info archive</h4>

            <table class="table table-hover table-borderless text-center w-100">
                <thead style="background-color: #04b4738d;">
                    <tr>
                        <th scope="col" class="fw-bold">ID</th>
                        <th scope="col" class="fw-bold">Serial Number</th>
                        <th scope="col" class="fw-bold">Manufacturer</th>
                        <th scope="col" class="fw-bold">Product Name</th>
                        <th scope="col" class="fw-bold">Description</th>
                        <th scope="col" class="fw-bold">Price</th>
                        <th scope="col" class="fw-bold">Size</th>
                       <!--  <th class="fw-bold" >Actions</th> -->
                    </tr>

                </thead>
            <tbody v-for="p in archivedProduct.data" :key="p.id">
                <tr>
                    <td class="fw-bold">{{p.id}}</td>
                    <td class="fw-bold">{{p.serial_number}}</td>
                    <td class="fw-bold">{{p.manufacturer}}</td>
                    <td class="fw-bold">{{p.product_name}}</td>
                    <td class="fw-bold">{{p.description}}</td>
                    <td class="fw-bold">{{p.price}}</td>
                    <td class="fw-bold">{{p.size}}</td>

                    <!-- <td class="m-3">

                        <RouterLink :to="{name: 'edit_product', params:{id:cat.id} }">
                            <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                        </RouterLink>
                        
                        <button type="button" class="btn btn-warning mx-1 mt-2" @click.prevent="del_cat(cat.id)">
                        <i class="fas fa-box-archive"></i></button>

                    </td> -->
                </tr>
            </tbody>
            </table>


            <div class="d-flex justify-content-end align-items-center" >
                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="archivedProduct" class="shadow-sm"  
                @pagination-change-page="getArchivedProduct"
                />
            </div>            
        </div>


        <div class="table-responsive">
            <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-filter me-2"></i>Category archive</h4>

            <table class="table table-hover table-borderless text-center w-100">
                <thead style="background-color: #04b4738d;">
                    <tr>
                        <th scope="col" class="fw-bold">ID</th>
                        <th scope="col" class="fw-bold">Category Name</th>
                        <th scope="col" class="fw-bold">Description</th>
                       <!--  <th class="fw-bold" >Actions</th> -->
                    </tr>

                </thead>
                
                <tbody>
                    <tr>
        
                        <!-- <td class="m-3">

                            <RouterLink :to="{name: 'edit_product', params:{id:cat.id} }">
                                <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                            </RouterLink>
                            
                            <button type="button" class="btn btn-warning mx-1 mt-2" @click.prevent="del_cat(cat.id)">
                            <i class="fas fa-box-archive"></i></button>

                        </td> -->
                    </tr>
                </tbody>
            </table>


            <div class="d-flex justify-content-end align-items-center" >
                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="archivedProduct" class="shadow-sm"  
                @pagination-change-page="getArchivedProduct"
                />
            </div>            
        </div>




    </div>
</template>





<script>
import { ref } from 'vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
export default {

    components: {
        Bootstrap5Pagination
    },

    setup(){

        const archivedProduct = ref([]);


        /* GET PRODUCT ARCHIVE TABLE */
        const getArchivedProduct = async(page = 1) => {
            axios_client.get('http://127.0.0.1:8000/api/archive?page=' + page).then(response=>{

                archivedProduct.value = response.data
                
                console.log(response.data)

            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        onMounted(()=> {
            getArchivedProduct()
        })


        return {getArchivedProduct,archivedProduct}

    }
    
}
</script>