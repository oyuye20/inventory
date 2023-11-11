<template>


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


            <div class="col-12 mb-2">
                <label for="" class="form-label fw-bold">Category</label>
                <select class="form-control" v-model="category">    
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
                @click="close">Close</button>

                <form @submit.prevent="add_btn()">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Add new product</button>
                </form>

                </div>      
            </div>      
    </div>
</div>
</transition>
</template>


<script>
import axios_client from '../../axios';
import { ref } from 'vue'
import {reactive, onMounted} from 'vue';
import {useToast} from 'vue-toast-notification';
import {useVuelidate} from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { useRouter } from "vue-router";

export default {
    props: ["addProduct"],


    setup(props, {emit}){

        const close = () => {
            emit('close');
        }


        const loading = ref(false);
        const showcam = ref(false);
        const serialField = ref(true);
        const router = useRouter();


        let category_lists = ref([]);
        const category = ref([]);
        const noSerial = ref();
        const serialRes = ref();

        /* FOR IMAGE UPLOAD FUNCTIONS */
        const imageFile = ref('');
        const imageURL = ref ('');


        const add_prod  = reactive({
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

        function filter_input(){
            serialRes.value = serialRes.value.replace(/[^\d.-]+/g, '');
            this.add_prod.price = this.add_prod.price.replace(/[^\d.-]+/g, '');
            this.add_prod.sellingPrice = this.add_prod.sellingPrice.replace(/[^0-9]/g, "");
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



        function add_btn(){
            loading.value = true;
      

    

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

        onMounted(()=> {
            getCat()
            /* onLoaded() */
        })


        return{close,serialHide,toggleCam,imageUpload,onScan,add_btn,getCat,filter_input
        ,loading,showcam,category_lists,category,noSerial,config
        
        
        ,add_prod,imageFile,imageURL,serialRes,serialField
        }
        
    }




}
</script>