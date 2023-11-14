<template>



<transition name="modalAnim">
<div v-if="modalActive" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center p-3" 
    id="modal-content">

            <div class="col-xxl-7 col-md-8 text-start p-3" 
            style="background-color: rgb(4, 180, 116);">


                <div class="col-12">
                    <span class="fw-bold fs-3 text-white">
                    <i class="fas fa-circle-plus me-3">
                    </i>Add new Category</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light">


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Category name</label>
                <input type="text" v-model="category.catname" 
                class="form-control">
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Description</label>
                <textarea type="text" v-model="category.desc" 
                class="form-control"></textarea>  
            </div>

     
            <div class="col-12 d-flex justify-content-end"> 
                <button role="button" class="btn btn-danger mt-3 fw-bold" 
                @click="toggleModal">Close</button>

                <form @submit.prevent="create_category()">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Add new category</button>
                </form>

                </div>      
            </div>      
    </div>
</div>
</transition>





<!-- ADD NEW PRODUCT MODAL -->
<transition name="modalAnim">
<div v-if="addProduct" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center p-3" 
    id="modal-content">

            <div class="col-xxl-7 col-md-8 text-start p-3" 
            style="background-color: rgb(4, 180, 116);">


                <div class="col-12">
                    <span class="fw-bold fs-3 text-white">
                    <i class="fas fa-circle-plus me-3">
                    </i>Add new Product</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light">


            <div class="col-12 mb-2 d-flex justify-content-center">
                <qrcode-scanner v-if="showcam" :qrbox="250" :fps="20"  
                style="width: 500px;"
                @result="onScan"/>
            </div>


            <div class="col-12 mb-2 d-flex justify-content-center">
                <div class="mb-3" v-if="imageURL">
                    <img :src="imageURL" class="img-fluid" width="300" height="300">
                </div>
            </div>

            <div class="col-12 mb-2 d-flex justify-content-center flex-column" v-for="(error, index) in validationErrors" :key="`error_${index}`">

                <div class="div fw-bold text-danger p-2 rounded-5">{{ error[0] }}</div>

                <!-- <li v-for="(error, index) in validationErrors" :key="`error_${index}`" class="text-danger fw-bold">
                    {{ error[0] }}</li> -->
            </div>

            


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Category</label>
                <select class="form-control" v-model="add_prod.category">    
                    <option selected v-for="cat in category_lists" :key="cat.id" :value="cat.id">{{cat.category}}</option>
                </select>
            </div>




            <div class="col-12 mb-2">

                <div class="div" v-if="serialField">

                <label for="" class="form-label fw-bold">Serial Number</label>

                <div class="d-flex" >
                    <input type="text" v-model="serialRes" 
                    class="form-control" @input="filter_input()">

                    <button class="btn btn-primary w-10" @click="toggleCam" 
                    data-bs-toggle="tooltip" data-bs-placement="top" 
                    data-bs-title="Tooltip on top"><i class="fas fa-barcode">        
                    </i></button>
                </div>

                </div>
                

                <div class="div mt-2">
                    <input class="form-check-input me-2" v-model="noSerial" 
                    type="checkbox" @click="serialHide" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        No Serial Number
                    </label>
                </div>
                
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Product name</label>
                <input type="text" v-model="add_prod.product_name" 
                class="form-control">
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Manufacturer</label>
                <input type="text" v-model="add_prod.manufacturer" 
                class="form-control">
            </div>


            <div class="col-12 mb-2 d-flex">
                <div class="price w-50">
                    <label for="" class="form-label fw-bold">Price</label>
                    <input type="text" v-model="add_prod.price" 
                    @input="filter_input()" class="form-control" placeholder="">

                </div>

                <div class="price w-50 mx-2">
                    <label for="" class="form-label fw-bold">Selling Price</label>
                    <input type="text" v-model="add_prod.sellingPrice" 
                    @input="filter_input()" class="form-control" placeholder="">
                </div>
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Size</label>
                <input type="text" v-model="add_prod.size" class="form-control">
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Description</label>
                <textarea name="" v-model="add_prod.description" 
                class="form-control"></textarea>
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Image File</label>
                <input type="file" class="form-control"  @change="imageUpload" 
                aria-describedby="helpId" placeholder="">
            </div>


     
            <div class="col-12 d-flex justify-content-end"> 
                <button role="button" class="btn btn-danger mt-3 fw-bold" 
                @click="toggleProduct">Close</button>

                <form @submit.prevent="add_btn()">
                    <button :disabled="loading" type="submit" class="btn btn-success 
                    mt-3 fw-bold">Add new product</button>
                </form>

                </div>      
            </div>      
    </div>
</div>
</transition>

<!-- EDIT PRODUCT MODAL -->
<transition name="modalAnim">
<div v-if="editProduct" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center p-3" 
    id="modal-content">

            <div class="col-xxl-7 col-md-8 text-start p-3" 
            style="background-color: rgb(4, 180, 116);">


                <div class="col-12">
                    <span class="fw-bold fs-3 text-white">
                    <i class="fas fa-circle-plus me-3">
                    </i>Edit Product</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light">



            <div class="col-12 mb-2 d-flex justify-content-center">
                <div class="mb-3" v-if="imageURL">
                    <img :src="imageURL" class="img-fluid" width="300" height="300">
                </div>
            </div>


            <!-- <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Category</label>
                <select class="form-control" v-model="add_prod.category">    
                    <option selected v-for="cat in category_lists" :key="cat.id" :value="cat.id">{{cat.category}}</option>
                </select>
            </div> -->




            <div class="col-12 mb-2">

                <label for="" class="form-label fw-bold">Serial Number</label>

                <div class="d-flex" >
                    <input type="text" readonly v-model="editProdData.serial_number" 
                    class="form-control" @input="filter_input()">
                </div>
        
                
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Product name</label>
                <input type="text" v-model="editProdData.product_name" 
                class="form-control">
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Manufacturer</label>
                <input type="text" v-model="editProdData.manufacturer" 
                class="form-control">
            </div>


            <div class="col-12 mb-2 d-flex">
                <div class="price w-50">
                    <label for="" class="form-label fw-bold">Price</label>
                    <input type="text" v-model="editProdData.price" 
                    @input="filter_input()" class="form-control" placeholder="">

                </div>

                <div class="price w-50 mx-2">
                    <label for="" class="form-label fw-bold">Selling Price</label>
                    <input type="text" v-model="editProdData.sellingPrice" 
                    @input="filter_input()" class="form-control" placeholder="">
                </div>
            </div>

            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Size</label>
                <input type="text" v-model="editProdData.size" class="form-control">
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Description</label>
                <textarea name="" v-model="editProdData.description" 
                class="form-control"></textarea>
            </div>


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Image File</label>
                <input type="file" class="form-control"  @change="imageUpload" 
                aria-describedby="helpId" placeholder="">
            </div>


     
            <div class="col-12 d-flex justify-content-end"> 
                <button role="button" class="btn btn-danger mt-3 fw-bold" 
                @click="editProduct = !editProduct">Close</button>

                <form @submit.prevent="updateProdBtn(editProdData.id)">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Update product</button>
                </form>

                </div>      
            </div>      
    </div>
</div>
</transition>





<!-- <add_product :addProduct="addProduct" @close="toggleProduct"/> -->


<body>
<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
            <div class="sidebar_wrapper" :class ="{side: isSidebar}">
                <sidebar/>
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

                        <logout/>

                    </div>

                </div>
            </nav>

            <div class="container-fluid px-4">
                <button class="btn btn-dark mt-3 modal-add" 
                @click="toggleModal">Add new category</button>

                <button type="button" class="btn btn-dark mt-3 
                modal-add" @click="toggleProduct">
                    Add new product
                </button>

                <button @click="exportExcel" class="btn 
                btn-success modal-add"><i class="far fa-file-excel me-2">         
                </i> Export product excel </button>  
            </div>

        
            <products_content v-on:editProd="editProdModal" :key="updateProdLists"/>



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
import  modalComponent  from '@/components/modalComponent.vue';
import logout from '../components/modal/logout.vue';
import Swal from 'sweetalert2'
import sidebar from '../components/sidebar/sidebar.vue';
import { inject } from 'vue'
import products_content from '../components/products_content.vue';


import {useToast} from 'vue-toast-notification';
import {useVuelidate} from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { useRouter } from "vue-router";


export default {
    name: 'products',

    components: {
    Bootstrap5Pagination,
    logout,
    sidebar,
    products_content
},



    setup(){
        /* FOR ADD PRODUCT MODAL */
        const updateProductLists = ref(0);

        const addProduct = ref(false);

        function toggleProduct(){
            addProduct.value = !addProduct.value
        }

        const loading = ref(false);
        const showcam = ref(false);
        const serialField = ref(true);
        const router = useRouter();


        let category_lists = ref([]);
        const noSerial = ref();
        const serialRes = ref('');

        /* FOR IMAGE UPLOAD FUNCTIONS */
        const imageFile = ref('');
        const imageURL = ref ('');


        const add_prod  = ref({
            manufacturer: '',
            product_name: '',
            description : '',
            size : '',
            price : '',
            category: '',
            sellingPrice: '',
        })


        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

      


        function serialHide(){
            serialField.value = !serialField.value;
        }

        function toggleCam(){
            showcam.value = !showcam.value;
        }


        function imageUpload(e){    
            const file = imageFile.value = e.target.files[0]
            imageURL.value = URL.createObjectURL(file) 
        }

        function onScan(decodedText){
            serialRes.value = decodedText
        }


        const getCat = async() => {
            axios_client.get('/select/category')
            .then(response=>{
                category_lists.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        const validationErrors = ref([]);


        function add_btn(){
            loading.value = true;
      
            /* let new_manu =  add_prod.value.manufacturer.replace(/^./, add_prod.value.manufacturer[0].toUpperCase());
            let new_prod = add_prod.value.product_name.replace(/^./, add_prod.value.product_name[0].toUpperCase()); */

            let formData = new FormData();
            
            if(serialRes.value == ''){
                formData.append('serial_number', Math.floor(Math.random() * 99999999999999) + 1);
            }

            else {
                formData.append('serial_number', serialRes.value);
            }


            formData.append('manufacturer', add_prod.value.manufacturer);
            formData.append('product_name', add_prod.value.product_name);
            formData.append('description', add_prod.value.description);
            formData.append('size', add_prod.value.size);
            formData.append('price', add_prod.value.price);
            formData.append('sellingPrice', add_prod.value.sellingPrice);
            formData.append('category', add_prod.value.category);
            formData.append('image', imageFile.value);


            let url = '/add_product';
            axios_client.post(url,formData, config).then(response => {

            console.log(response.data)

            loading.value = false;

            const $toast = useToast();
            updateProductLists.value += 1;
            addProduct.value = false;

            let instance = $toast.success('Product added successfully', {position: 'top'});      
            
            
        

            }).catch(error =>{
                loading.value = false;
                validationErrors.value = error.response.data.errors
            })
            

        }
        /* END OF ADD PRODUCT MODAL  */




        /* FOR UPDATE PRODUCT */
        const editProduct = ref (false);
        const editProdData = ref ([]);
        const updateProdLists = ref(0);


        function editProdModal(id){
            console.log(id);

            axios_client.get(`/product/edit/` 
            + id).then(response=>{

                editProdData.value = response.data

            }).catch(error =>{
                console.log(error)
            })

            editProduct.value = true;
        }


        function updateProdBtn(id){
            let formData = new FormData();
            formData.append('image2', imageFile.value);
            formData.append('product_data', JSON.stringify(editProdData.value));

            console.log(editProdData.value)

            axios_client.post(`/update_product/`
            + id, formData, config).then(response=>{
                loading.value = true;

                editProduct.value = false;
                updateProdLists.value += 1;

                const $toast = useToast();
                $toast.success('Product updated successfully', {position: 'top'});  

                    

            }).catch(error =>{
                console.log(error.response.data)
            })
        }
        /* END OF FOR UPDATE PRODUCT */




        function filter_input(){
            serialRes.value = serialRes.value.replace(/[^\d.-]+/g, '');
            add_prod.value.price = add_prod.value.price.replace(/[^\d.-]+/g, '');
            add_prod.value.sellingPrice = add_prod.value.sellingPrice.replace(/[^0-9]/g, "");

            editProdData.value.price = editProdData.value.price.replace(/[^\d.-]+/g, '');
            editProdData.value.sellingPrice = editProdData.value.sellingPrice.replace(/[^0-9]/g, "");
        }



        const isOpen = ref(false);
        const typing = ref(false);
        const isSidebar = ref(false);
        const modalActive = ref(false);


    
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


        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })


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

                Swal.fire({
                    title: 'Success!',
                    text: 'Category added successfully',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                })


            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        function exportExcel(){
            axios_client({
                url: '/export-excel',
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'product.csv');
                document.body.appendChild(fileLink);
                fileLink.click();
            });
        }


        onMounted(()=> {
            getCat()
        })

        return {
            typing,loading,isSidebar,exportExcel,
            modalActive,toggleModal,create_category,isOpen,formatDate
            ,toggleProduct,addProduct,category


            /* FOR ADD PRODUCT */
            ,close,serialHide,toggleCam,imageUpload,onScan,add_btn,getCat,filter_input
            ,loading,showcam,category_lists,noSerial,config
            ,add_prod,imageFile,imageURL,serialRes,serialField,updateProductLists
            /* END OF ADD PRODUCT */



            /* FOR UPDATE PRODUCT */
            ,editProduct,editProdModal,editProdData,updateProdBtn,updateProdLists,validationErrors
            /* END FOR UPDATE PRODUCT */
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
