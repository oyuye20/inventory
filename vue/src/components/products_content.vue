<template>

    

<div class="container-fluid px-4">

 <div class="row container-fluid mb-3 mt-3  border ">


    <!-- <div class="col-xxl-12 d-flex justify-content-between ">

        <div class="col-10 me-3">
            <input type="text" @keydown.enter="search" role="searchbox" v-model="search_box" class="form-control rounded-5 p-2" 
            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search Product">
        </div>

        <div class="col-2 d-flex justify-content-center p-0 m-0">
            <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
        </div>

    </div> -->


</div>



<div v-if="loading" class="p-3 d-flex justify-content-center align-items-center container-fluid h-100 mt-3">
    <span class="spinner-border spinner-border-lg  p-3" aria-hidden="true" style="font-size: ;"></span>
 </div>  


 <!-- PRODUCT TABLE -->
<div v-else class="table-responsive mt-3">



  

    



    <div class="container-fluid table-responsive">
        <h4 class="mt-3 mb-3 bg-light p-3"><i class="fas fa-box-open me-2"></i>Product Info Lists</h4>


        <div class="mb-3 d-flex justify-content-between">
 
            <div class="input-group rounded w-50 me-2">
                <input type="search" @keydown.enter="getProductLists" 
                role="searchbox" v-model="search_box" class="form-control rounded" 
                placeholder="Search"/>
            </div>
             
        </div>

    
        <table class="table align-middle table-hover border-muted ">
            
            <thead>
                <tr>
                    <th scope="col" class="fw-bold">
                    <a role="button" @click.prevent="getSort('serial_number')">Product Number</a>

                    <i v-if="sort_direction =='desc' && sortData =='serial_number'" 
                    class="fas fa-arrow-down-long mx-2"></i>
                    <i v-if="sort_direction =='asc' && sortData =='serial_number'" 
                    class="fas fa-arrow-up-long mx-2"></i>
                
                    </th>



                    <th scope="col" class="fw-bold">
                    <span class="me-2">Category</span>
                    </th>     


                    <th scope="col" class="fw-bold">
                        <a role="button" @click.prevent="getSort('manufacturer')">Manufacturer</a>

                        <i v-if="sort_direction =='desc' && sortData =='manufacturer'" 
                        class="fas fa-arrow-down-long mx-2"></i>
                        <i v-if="sort_direction =='asc' && sortData =='manufacturer'" 
                        class="fas fa-arrow-up-long mx-2"></i>
                    </th>

                    <th scope="col" class="fw-bold">
                        <a role="button" @click.prevent="getSort('product_name')">Product Name</a>

                        <i v-if="sort_direction =='desc' && sortData =='product_name'" 
                        class="fas fa-arrow-down-long mx-2"></i>
                        <i v-if="sort_direction =='asc' && sortData =='product_name'" 
                        class="fas fa-arrow-up-long mx-2"></i>
                    </th>


                    <th scope="col" class="fw-bold">Variation</th>

                    <th scope="col" class="fw-bold">
                        <a role="button" @click.prevent="getSort('selling_price')">Selling Price</a>

                        <i v-if="sort_direction =='desc' && sortData =='selling_price'" 
                        class="fas fa-arrow-down-long mx-2"></i>
                        <i v-if="sort_direction =='asc' && sortData =='selling_price'" 
                        class="fas fa-arrow-up-long mx-2"></i>
                    </th>

                    <th scope="col" class="fw-bold">
                        <a role="button" @click.prevent="getSort('price')">Price</a>

                        <i v-if="sort_direction =='desc' && sortData =='price'" 
                        class="fas fa-arrow-down-long mx-2"></i>
                        <i v-if="sort_direction =='asc' && sortData =='price'" 
                        class="fas fa-arrow-up-long mx-2"></i>
                    </th>

                    <th class="fw-bold">Actions</th>
                </tr>
            </thead>
        <tbody v-for="product in product_lists.data" :key="product.id">

            <tr>                         
                <td>{{product.serial_number}}</td>
                <td>{{product.category.category}}</td>
                <td >{{product.manufacturer}}</td>
                <td>{{product.product_name}}</td>
                <td>{{product.size}}</td>

                <td>               
                {{Intl.NumberFormat('en-PH', { style: 'currency', 
                currency: 'PHP' }).format((product.selling_price))}}
                </td>
                
                <td> 
                {{Intl.NumberFormat('en-PH', { style: 'currency', 
                currency: 'PHP' }).format((product.price))}}
                </td>  
                            
                <td class="m-3">
                    <button class="btn btn-primary p-2 mb-1"
                    data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="top" 
                    title="View Product"><i class="far fa-eye"></i></button>

                    <button class="btn btn-success p-2 mb-1" 
                    data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="top" title="Edit Product"
                    @click="$emit('editProd', product.id)">
                    <i class="bi bi-pencil-square"></i></button>      

                    <button type="button" class="btn btn-warning p-2 mb-1" 
                    data-mdb-ripple-init data-mdb-tooltip-init data-mdb-placement="top" title="Archive Product"
                    @click.prevent="del_prod(product.id, product.product_name)">
                    <i class="fas fa-box-archive"></i></button>
                </td>
            </tr>
            
        </tbody>
        </table>
   

        

        <div class="row container-fluid d-flex justify-content-center">
            <Bootstrap5Pagination :limit="10" :keepLength="true" :data="product_lists" class=""
            @pagination-change-page="getProductLists"/>                 
        </div>

    </div>


</div>
<!-- END OF PRODUCT TABLE -->


<!-- CATEGORY TABLE -->
<div class="table-responsive mt-4">
    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-filter me-2"></i>Category Lists</h4>

    <table class="table align-middle table-hover border-muted">
        <thead>
            <tr>
                <th scope="col" class="fw-bold">Category Name</th>
                <th scope="col" class="fw-bold">Description</th>
                <th scope="col" class="fw-bold">Measurement</th>
                <th class="fw-bold" >Actions</th>
            </tr>

        </thead>
    <tbody v-for="cat in category_lists.data" :key="cat.id">
        <tr>
            <td>{{cat.category}}</td>
            <td>{{cat.description}}</td>
            <td>{{cat.measure}}</td>

            <td class="m-3">

                <button class="btn btn-success" data-mdb-toggle="tooltip" @click="$emit('editCat',cat.id)"
                data-mdb-placement="left" title="Edit"><i class="bi bi-pencil-square">
                </i></button>

                
                <button type="button" class="btn btn-warning mx-1 mt-2" data-mdb-toggle="tooltip" 
                data-mdb-placement="left" title="Edit" @click.prevent="del_cat(cat.id, cat.category)">
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

</template>
<script>

import { computed, toHandlers } from "vue";
import {onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect } from 'vue';
import { inject } from 'vue'
import { Bootstrap5Pagination } from 'laravel-vue-pagination'
import Swal from 'sweetalert2'

export default {

    components: {
    Bootstrap5Pagination,
    },

    setup(){
        const storageLink = inject('$storageLink');
        let product_lists = ref([]);
        let productSearchResults = ref([]);
        let category_lists = ref([]);

        const search_box = ref ('');
        const loading = ref(true);


        const sortData = ref('');
        const sort_direction = ref('desc');
        

        function getSort (sort){

            if(sortData.value == sort){
                sort_direction.value = sort_direction.value == 'desc' ? 'asc' : 'desc';
            }

            sortData.value = sort;
            this.getProductLists()
        }

        

        /* SEARCH PRODUCT LISTS FUNCTION */
        const getProductLists  = async(page = 1) => {
            axios_client.get('/products?page=' + page, 
            {params: {query: search_box.value, sort: sortData.value, sortBy: sort_direction.value}})
            .then(response=>{
                product_lists.value = response.data;
                loading.value = false;
            }).catch(error =>{
                console.log(error.response)
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



        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        /* DELETE A CATEGORY */
         function del_cat(id, category){

            swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to archive ' + category + '?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true

            }).then((result) => {

            if (result.isConfirmed) {

            let url = '/delete/category/' + id;
            axios_client.put(url).then(response => {
                this.getCat()
            }).catch(error => {
                console.log(error.response.data)
            })

            swalWithBootstrapButtons.fire(
            'Archived!',
            'Your category has been archived successfuly.',
            'success'
            )
            } 
            
            else (result.dismiss === Swal.DismissReason.cancel) 
            })
    
        }

        function showImage(image, product) {
            Swal.fire({
                title: 'Image',
                text: product,
                imageUrl: storageLink + image,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: image,
            })
        }


        /* DELETE A PRODUCT */
        function del_prod(id, product){

            swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to archive ' + product + '?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true

            }).then((result) => {

            if (result.isConfirmed) {

                let url = '/delete/' + id;
                axios_client.put(url).then(response => {
                    this.search()
                }).catch(error => {
                    console.log(error.response.data)
                })

                swalWithBootstrapButtons.fire(
                'Archived!',
                'Your product has been archived successfuly.',
                'success'
                )
            } 
            
            else (result.dismiss === Swal.DismissReason.cancel) 
            })
      

        }


        onMounted(()=> {
            getProductLists()
            getCat()
        })


        return {getProductLists, getCat, del_cat,showImage, del_prod,product_lists,storageLink,productSearchResults,category_lists
        ,loading,search_box,getSort,sortData,sort_direction}

    }
    
}
</script>