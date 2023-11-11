<template>


  <div class="container-fluid px-4">

                <button class="btn btn-dark mt-3 modal-add" @click="toggleModal">Add new category</button>

                <!-- <router-link :to="{name: 'add_product'}">
                    <button type="button" class="btn btn-dark mt-3 modal-add">
                        Add new product
                    </button>
                </router-link> -->


                <button type="button" class="btn btn-dark mt-3 modal-add"
                @click="toggleProduct">
                        Add new product
                </button>




                <button @click="exportExcel" class="btn btn-success modal-add"><i class="far fa-file-excel me-2">         
                </i> Export product excel </button>

            

               


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


                    <!-- <div class="input-group mb-3 container-fluid">
                        <input type="text" class="form-control rounded-5 h-100" placeholder="Search Product" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); border: 1.9px solid rgb(215, 214, 214);">

                        <button class="btn btn-primary mx-3 rounded-2 h-100" type="button" ><i class="fas fa-magnifying-glass"></i></button>
                    </div> -->





                    <!-- <div class="col-xl-10 col-lg-9 col-md-9 col-xs-7  border border-dark">
                        <input type="text" @keydown.enter="search" role="searchbox" v-model="search_box" class="form-control rounded-5 p-2" 
                        style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
                        border: 1.9px solid rgb(215, 214, 214);" placeholder="Search Product">
                    </div>

                    <div class="col-1 d-flex justify-content-center p-0 m-0 mx-4 border border-dark">
                        <button class="btn btn-success" @click="search"><i class="fas fa-magnifying-glass"></i></button>
                    </div>  -->      
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
                                    <th scope="col" class="fw-bold">Price</th>
                                    <th scope="col" class="fw-bold">Selling Price</th>
                                    <th class="fw-bold" >Actions</th>
                                </tr>

                            </thead>
                        <tbody v-for="product in product_lists.data" :key="product.id">
            
                            <tr>
                                <td class="fw-bold" @click="showImage(product.image, product.product_name)" style="cursor: pointer;">
                                    <img v-bind:src="storageLink + product.image" 
                                 width="50" height="50">
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
                                    <td>₱ {{product.price}}</td>
                                    <td>₱ {{product.selling_price}}</td>
                                <td class="m-3">

                                    <RouterLink :to="{name: 'edit_product', params:{id:product.id} }">
                                        <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                                    </RouterLink>
                                    
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
import {reactive, onMounted} from 'vue';
import {useVuelidate} from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import axios_client from '../axios';
import { useRouter } from "vue-router";
import { ref } from 'vue'
import { faker } from '@faker-js/faker';
import { StreamBarcodeReader } from "vue-barcode-reader";
import { ImageBarcodeReader } from "vue-barcode-reader";
import Compressor from 'compressorjs';


import {useToast} from 'vue-toast-notification';
/* import 'vue-toast-notification/dist/theme-sugar.css'; */

export default {

    components: {
    StreamBarcodeReader,
    ImageBarcodeReader
    },

    setup(){

    const router = useRouter();
    const loading = ref(false);
    let category_lists = ref([]);

    const category = ref([]);
    const showcam = ref(false);

    const noSerial = ref();


    const serialField = ref(true);

    function serialHide(){
        serialField.value = !serialField.value;
    }




    function onDecode(a,b,c){

        console.log(a)
        /* console.log(a)
        this.add_prod.serial_number = a
        showcam.value = !showcam.value; */
    }

    function toggleCam(){
        showcam.value = !showcam.value;
    }


    const add_prod  = reactive({
        manufacturer: '',
        product_name: '',
        description : '',
        size : '',
        price : '',
        category: '',
        sellingPrice: ''
    })

    const serialRes = ref();


    function filter_input(){
        serialRes.value = serialRes.value.replace(/[^0-9]/g, "");
        this.add_prod.price = this.add_prod.price.replace(/[^0-9]/g, "");
    }



   /*  const serial_number = ref('') */

    const rules  = {
        manufacturer: {required},
        product_name: {required},
        description: {required},
        size: {required},
        price: {required},
    }

    const v$ = useVuelidate(rules, add_prod)



    /* FOR IMAGE UPLOAD FUNCTIONS */
    const imageFile = ref('');
    const imageURL = ref ('');


    const config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    }


    function imageUpload(e){
        const file = imageFile.value = e.target.files[0]
        imageURL.value = URL.createObjectURL(file)
    }
    /* FOR IMAGE UPLOAD FUNCTIONS */

    


    function onScan(decodedText){
        serialRes.value = decodedText
    }







    function add_btn(){
        loading.value = true;
        this.v$.$validate()

        if(!this.v$.$error)
        {

            let new_manu =  this.add_prod.manufacturer.replace(/^./, this.add_prod.manufacturer[0].toUpperCase());
            let new_prod = this.add_prod.product_name.replace(/^./, this.add_prod.product_name[0].toUpperCase());


            let formData = new FormData();
            

            if(serialRes.value == ''){
                formData.append('serial_number', Math.floor(Math.random() * 99999999999999) + 1);
            }

            else {
                formData.append('serial_number', serialRes.value);
            }



            formData.append('manufacturer', new_manu);
            formData.append('product_name', new_prod);
            formData.append('description', this.add_prod.description);
            formData.append('size', this.add_prod.size);
            formData.append('price', this.add_prod.price);
            formData.append('sellingPrice', this.add_prod.sellingPrice);
            formData.append('category', category.value);
            formData.append('image', imageFile.value);

           

            let url = '/add_product';
            axios_client.post(url,formData, config).then(response => {

            console.log(response.data)

            loading.value = false;
            router.push({name: 'products'})


            const $toast = useToast();
            let instance = $toast.success('Product added successfully', {position: 'top'});      
            
            }).catch(error =>{
                loading.value = false;
                console.log(error.response.data)
            })
        } 

        else{
            loading.value = false;
        }
    }


    const getCat = async() => {
        axios_client.get('/select/category')
        .then(response=>{
            category_lists.value = response.data;
        }).catch(error =>{
            console.log(error.response.data)
        })
    }



    onMounted(()=> {
        getCat()
        /* onLoaded() */
    })


    return {
       add_prod,add_btn,rules,v$,loading,filter_input,getCat,
       category_lists,category,onDecode,showcam,toggleCam,imageUpload,onScan,serialRes,

       imageURL,imageFile,noSerial,serialField,serialHide
    }




}

}





</script>