<template>
    <div>
       
        <div class="table-responsive mb-3">
            <h4 class="mt-3 w-100 bg-light p-3"><i class="fas fa-filter me-2">

            </i>Product info archive</h4>


            <div class="container-fluid col-xxl-12 d-flex justify-content-between mb-3">
                <div class="col-10 me-3">
                    <input type="text" @keydown.enter="searchProdArchived" role="searchbox" 
                    v-model="search_product" class="form-control rounded-5 p-2" 
                    style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                    border: 1.9px solid rgb(215, 214, 214);" placeholder="Search archived products">
                </div>

                <div class="col-2 d-flex justify-content-center p-0 m-0">
                    <button class="btn btn-success" @click="searchProdArchived">
                    <i class="fas fa-magnifying-glass"></i></button>
                </div>
            </div>









            <table class="table table-hover table-borderless text-center w-100">
                <thead style="background-color: #04b4738d;">
                    <tr>
                        <th scope="col" class="fw-bold">Image</th>
                        <th scope="col" class="fw-bold">ID</th>
                        <th scope="col" class="fw-bold">Serial Number</th>
                        <th scope="col" class="fw-bold">Manufacturer</th>
                        <th scope="col" class="fw-bold">Product Name</th>
                        <th scope="col" class="fw-bold">Description</th>
                        <th scope="col" class="fw-bold">Price</th>
                        <th scope="col" class="fw-bold">Size</th>
                        <th scope="col" class="fw-bold">Actions</th>
                       <!--  <th class="fw-bold" >Actions</th> -->
                    </tr>

                </thead>
            <tbody v-for="p in archivedProduct.data" :key="p.id">
                <tr>

                    <td @click="showImage(p.image, p.product_name)"
                    style="cursor: pointer;">
                        <img v-bind:src="storageLink + p.image" 
                        class="img-fluid" width="100" height="100">
                    </td>


                    <td>{{p.id}}</td>
                    <td>{{p.serial_number}}</td>
                    <td>{{p.manufacturer}}</td>
                    <td>{{p.product_name}}</td>
                    <td>{{p.description}}</td>
                    <td>{{p.price}}</td>
                    <td>{{p.size}}</td>

                    <td class="m-3">
                        <button class="btn btn-success" data-bs-toggle="tooltip" 
                        data-mdb-toggle="tooltip" data-mdb-placement="left" title="Restore"
                        @click="restore(p.id, p.product_name)"><i class="fas fa-arrow-rotate-right"></i></button>
       
                        <!-- <button type="button" class="btn btn-danger mx-1 mt-2" 
                        @click.prevent="permanentDeleteProd(p.id,p.product_name)" data-mdb-toggle="tooltip" 
                        data-mdb-placement="left" title="Delete Permanently">
                        <i class="fas fa-trash"></i></button> -->
                    </td>
                </tr>
            </tbody>
            </table>


            <div class="d-flex justify-content-end align-items-center" >
                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="archivedProduct" class="shadow-sm"  
                @pagination-change-page="searchProdArchived"
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
                        <th class="fw-bold" >Actions</th>
                    </tr>

                </thead>
                
                <tbody v-for="c in archivedCategory.data" :key="c.id">
                    <tr>
                        <td class="fw-bold">{{c.id}}</td>
                        <td class="fw-bold">{{c.category}}</td>
                        <td class="fw-bold">{{c.description}}</td>

                        <td>
                            <button class="btn btn-success" data-bs-toggle="tooltip" 
                            data-mdb-toggle="tooltip" data-mdb-placement="left" title="Restore"
                            @click="restoreCat(c.id)"><i class="fas fa-arrow-rotate-right"></i></button>
        
                            <!-- <button type="button" class="btn btn-danger mx-1 mt-2" 
                            @click.prevent="del_cat(c.id)" data-mdb-toggle="tooltip" 
                            data-mdb-placement="left" title="Delete Permanently">
                            <i class="fas fa-trash"></i></button> -->
                        </td>

                    </tr>
                </tbody>
            </table>


            <div class="d-flex justify-content-end align-items-center" >
                <Bootstrap5Pagination :limit="1" :keepLength="true" :data="archivedCategory" class="shadow-sm"  
                @pagination-change-page="getArchivedCategory"
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
import Swal from 'sweetalert2';
import { inject } from 'vue'

export default {

    components: {
        Bootstrap5Pagination
    },

    setup(){

        const archivedProduct = ref([]);
        const archivedCategory = ref([]);
        const storageLink = inject('$storageLink');
        const search_product = ref('');


        /* GET CATEGORY ARCHIVE TABLE */
        const getArchivedCategory = async(page = 1) => {
            axios_client.get('/archive/category?page=' + page).then(response=>{
                archivedCategory.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        /* GET PRODUCT ARCHIVE TABLE */
        const searchProdArchived = async(page = 1) => {

            if(search_product.value == ''){
                axios_client.get('/archive/product?page=' + page).then(response=>{
                archivedProduct.value = response.data
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }

            else {
                axios_client.get('/archive/product/search/'+ search_product.value + 
                '?page=' + page).then(response=>{
                archivedProduct.value = response.data
                }).catch(error =>{
                    console.log(error.response.data)
                })
            }
            
        }













        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })









        /* PERMANENTLY DELETE A PRODUCT */
        function permanentDeleteProd(id,product){
            swalWithBootstrapButtons.fire({
            title: 'Are you sure you permanently delete '+ product + '?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true

            }).then((result) => {

            if (result.isConfirmed) {

                let url = '/delete/permanent/' + id;
                axios_client.delete(url).then(response => {
                    this.searchProdArchived()
                    this.getArchivedCategory()
                }).catch(error => {
                    console.log(error.response.data)
                })

                swalWithBootstrapButtons.fire(
                'Deleted!',
                'Your product has been deleted successfuly.',
                'success'
                )
            } 
            
            else (result.dismiss === Swal.DismissReason.cancel) 
            })  
        }









        /* RESTORE A PRODUCT */
        function restore(id, product){
            swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to restore ' + product + '?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true

            }).then((result) => {

            if (result.isConfirmed) {

                let url = '/restore/' + id;
                axios_client.put(url).then(response => {
                    this.searchProdArchived()
                    this.getArchivedCategory()
                }).catch(error => {
                    console.log(error.response.data)
                })

                swalWithBootstrapButtons.fire(
                'Restored!',
                'Your product has been restored successfuly.',
                'success'
                )
            } 
            
            else (result.dismiss === Swal.DismissReason.cancel) 
            })  
        }



        /* SHOW IMAGE WHEN CLICKED */
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



        /* RESTORE A CATEGORY */
        function restoreCat(id){
            let url = '/restore/cat/' + id;
            axios_client.put(url).then(response => {
                this.getArchivedCategory()
                this.searchProdArchived()
            }).catch(error => {
                console.log(error.response.data)
            })
        }





        onMounted(()=> {
            searchProdArchived()
            getArchivedCategory()
        })

        return {
            searchProdArchived,restore,getArchivedCategory,restoreCat,
            showImage,permanentDeleteProd,
     
            archivedProduct,archivedCategory,storageLink,swalWithBootstrapButtons,
            search_product
        }

    }
    
}
</script>