<template>

    

<div class="container-fluid px-4">

 <div class="row container-fluid mb-3 mt-3  ">

    <div class="col-xxl-12 d-flex justify-content-between ">

        

        <div class="col-10 me-3">
            <input type="text" @keydown.enter="search" role="searchbox" v-model="search_box" class="form-control rounded-5 p-2" 
            style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
            border: 1.9px solid rgb(215, 214, 214);" placeholder="Search Product">
        </div>

        <div class="col-2 d-flex justify-content-center p-0 m-0">
            <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
        </div>

    </div>

</div>



<div v-if="loading" class="p-3 d-flex justify-content-center align-items-center container-fluid h-100 mt-3">
    <span class="spinner-border spinner-border-lg  p-3" aria-hidden="true" style="font-size: ;"></span>
 </div>  


 <!-- PRODUCT TABLE -->
<div v-else class="table-responsive mt-3">



    <h4 class="mt-3 mb-3 w-100 bg-light p-3"><i class="fas fa-box-open me-2"></i>Product Info Lists</h4>

    



    <div class="div">
        <table class="table table-hover table-borderless text-center w-100">
            <thead>
                <tr>
                    <th scope="col" class="fw-bold p-3">Image</th>
                    <th scope="col" class="fw-bold">Serial Number</th>
                    <th scope="col" class="fw-bold">Category</th>     
                    <th scope="col" class="fw-bold">Manufacturer</th>
                    <th scope="col" class="fw-bold">Product Name</th>
                    <th scope="col" class="fw-bold">Description</th>
                    <th scope="col" class="fw-bold">Size Name</th>
                    <th scope="col" class="fw-bold">Selling Price</th>
                    <th scope="col" class="fw-bold">Price</th>
                    <th class="fw-bold" >Actions</th>
                </tr>

            </thead>
        <tbody v-for="product in product_lists.data" :key="product.id">

            <tr>
                <td class="fw-bold" @click="showImage(product.image, product.product_name)" style="cursor: pointer;">
                    <img v-bind:src="storageLink + product.image" 
                 width="100" height="100">
                </td>                              
                <td hidden>{{product.id}}</td>

                    <!-- <td v-if="product.serial_number == 'No Serial Number'">
                        <span class="text-danger fw-bold">{{product.serial_number}}</span>
                    </td> -->

                    <td>{{product.serial_number}}</td>
                    <td>{{product.category.category}}</td>
                    <td>{{product.manufacturer}}</td>
                    <td>{{product.product_name}}</td>
                    <td style="padding: 0; margin: 0; word-wrap:break-word;">{{product.description}}</td>
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
 
                    <button class="btn btn-success" @click="$emit('editProd', product.id)"><i class="bi bi-pencil-square"></i></button>
                    
                    
                    <button type="button" class="btn btn-warning mx-1 mt-2" @click.prevent="del_prod(product.id, product.product_name)">
                    <i class="fas fa-box-archive"></i></button>

                </td>
            </tr>
            
        </tbody>
        </table>

        <div class="container-fluid">
            <Bootstrap5Pagination :limit="30" :keepLength="true" :data="product_lists" class="shadow-sm"  
            @pagination-change-page="search"/>
        </div>   
    </div>


</div>
<!-- END OF PRODUCT TABLE -->


<!-- CATEGORY TABLE -->
<div class="table-responsive mt-4">
    <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-filter me-2"></i>Category Lists</h4>

    <table class="table table-hover table-borderless text-center w-100">
        <thead>
            <tr>
                <th scope="col" class="fw-bold">ID</th>
                <th scope="col" class="fw-bold">Category Name</th>
                <th scope="col" class="fw-bold">Description</th>
                <th class="fw-bold" >Actions</th>
            </tr>

        </thead>
    <tbody v-for="cat in category_lists.data" :key="cat.id">
        <tr>
            <td>{{cat.id}}</td>
            <td>{{cat.category}}</td>
            <td>{{cat.description}}</td>

            <td class="m-3">

                <RouterLink :to="{name: 'edit_product', params:{id:cat.id} }">
                    <button class="btn btn-success" data-mdb-toggle="tooltip" 
                    data-mdb-placement="left" title="Edit"><i class="bi bi-pencil-square">
                    </i></button>
                </RouterLink>
                
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
                axios_client.get('/search/' + search_box.value + '?page=' + page)
                .then(response=>{ 
                    
                    product_lists.value = response.data;
                                   
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }
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
            search()
            getCat()
        })


        return {search, getCat, del_cat,showImage, del_prod,product_lists,storageLink,productSearchResults,category_lists
        ,loading,search_box}

    }
    
}
</script>