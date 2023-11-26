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



    <h4 class="mt-3 mb-3 w-100 bg-light p-3"><i class="fas fa-box-open me-2"></i>Product Info Lists</h4>

    



    <div class="div">
        <div class="container-fluid mb-3 d-flex justify-content-between">
            
            <div class="input-group rounded w-50 me-2">
            <input type="search" @keydown.enter="search" role="searchbox" v-model="search_box" 
            class="form-control rounded" 
            placeholder="Search"/>
            </div>

            
            <div class="input-group" style="width: 15%;">
                <label class="input-group-text">Sort By</label>
                <select class="form-control" id="inputGroupSelect02" v-model="sortData" @change="getSort(sortData)">
                    <option selected>Choose...</option>
                    <option value="price_low">Price (Lowest)</option>
                    <option value="price_high">Price (Highest)</option>
                    <option value="selPrice_low">Selling Price (Lowest)</option>
                    <option value="selPrice_high">Selling Price (Highest)</option>
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>    
            </div>

            

        </div>


        <table class="table table-hover table-borderless text-center w-100">
            <thead>
                <tr>
                    <th scope="col" class="fw-bold">
                    Product Number          
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>

                    <th scope="col" class="fw-bold">Category
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>     


                    <th scope="col" class="fw-bold">Manufacturer
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>

                    <th scope="col" class="fw-bold">Product Name
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>

                    <th scope="col" class="fw-bold">Variation
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>

                    <th scope="col" class="fw-bold">Selling Price
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>

                    <th scope="col" class="fw-bold">Price
                    <a role="button"><i class="fas fa-arrow-up-wide-short mx-1"></i></a>
                    </th>

                    <th class="fw-bold">Actions</th>
                </tr>
            </thead>
        <tbody v-for="product in product_lists.data" :key="product.id">

            <tr>                         
                <td>{{product.serial_number}}</td>
                <td>{{product.category.category}}</td>
                <td>{{product.manufacturer}}</td>
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
                    <button class="btn btn-primary p-2"><i class="far fa-eye"></i></button>  
                    <button class="btn btn-success p-2" @click="$emit('editProd', product.id)"><i class="bi bi-pencil-square"></i></button>                         
                    <button type="button" class="btn btn-warning mx-1 mt-2 p-2" @click.prevent="del_prod(product.id, product.product_name)">
                    <i class="fas fa-box-archive"></i></button>
                </td>
            </tr>
            
        </tbody>
        </table>

        <div class="row container-fluid d-flex justify-content-center">
            <Bootstrap5Pagination :limit="10" :keepLength="true" :data="product_lists" class=""
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
        const sortData = ref('');


        const loading = ref(true);





        /* SEARCH FUNCTION */
        const search  = async(page = 1) => {

            if(search_box.value == ''){
                axios_client.get('/products?page=' + page)
                .then(response=>{
                    product_lists.value = response.data;

                    console.log(response.data)

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


        function getSort (sort){

            sortData.value = sort;
            /* axios_client.get('/sortProducts/' + sort + '?page=' + page)
            .then(response=>{

                product_lists.value = response.data;

                console.log(response.data)
            }).catch(error =>{
                console.log(error.response.data)
            })       */
        }

        console.log(sortData)



        
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
        ,loading,search_box,getSort,sortData}

    }
    
}
</script>