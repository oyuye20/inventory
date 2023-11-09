<template>

    <div class="container d-flex flex-column justify-content-center align-items-center">
        <qrcode-scanner v-if="showcam" :qrbox="250" :fps="20"  style="width: 500px;"
        @result="onScan"/>
    </div>


  
   



<div class="container d-flex justify-content-center mt-3">
    <div class="col-12">
        <h4><i class="fas fa-circle-plus me-2 mb-3"></i>Add new product</h4>


        <div class="mb-3">
            <label for="" class="form-label">Category</label>
            <select class="form-control" v-model="category">    
                <option selected v-for="cat in category_lists" :key="cat.id" :value="cat.id">{{cat.category}}</option>
            </select>
        </div>




        <div class="mb-3" v-if="serialField">
            <label for="" class="form-label">Serial Number</label>

            <div class="d-flex">
                <input type="text" v-model="serialRes" class="form-control" @input="filter_input()">

                <button class="btn btn-primary w-10" @click="toggleCam" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Tooltip on top"><i class="fas fa-barcode"></i></button>
            </div>


            <!-- <div v-if="v$.serialRes.value.$error">
                <p class="text-danger fw-bold mt-1">{{ "Serial number required" }}</p>
            </div> -->
        </div>


        <div class="form-check">
            <input class="form-check-input" v-model="noSerial" type="checkbox" @click="serialHide" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                No Serial Number
            </label>
        </div>




        <div class="mb-3">
            <label for="" class="form-label">Product name</label>
            <input type="text" v-model="add_prod.product_name" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">

            <div v-if="v$.product_name.$error">
                <p class="text-danger fw-bold mt-1">{{ "Product name required" }}</p>
            </div>
        </div>


        <div class="mb-3" v-if="imageURL">
            <img :src="imageURL" class="img-fluid" width="200" height="200">
        </div>


        <div class="mb-3">
            <label for="" class="form-label">Image File</label>
            <input type="file" class="form-control"  @change="imageUpload" aria-describedby="helpId" placeholder="">
        </div>


        <div class="mb-3">
            <label for="" class="form-label">Manufacturer</label>
            <input type="text" v-model="add_prod.manufacturer" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">

            <div v-if="v$.manufacturer.$error">
                <p class="text-danger fw-bold mt-1">{{ "Manufacturer required" }}</p>
            </div>
        </div>



        <div class="mb-3 d-flex">

        <div class="price w-50">
            <label for="" class="form-label">Price</label>
            <input type="text" v-model="add_prod.price" @input="filter_input()" class="form-control" placeholder="">

            <div v-if="v$.price.$error">
                <p class="text-danger fw-bold mt-1">{{ "Price required" }}</p>
            </div>
        </div>


        <div class="size w-50">
            <div class="mx-2">
                <label for="" class="form-label">Size</label>
                <input type="text" v-model="add_prod.size" class="form-control" placeholder="">

                <div v-if="v$.size.$error">
                    <p class="text-danger fw-bold mt-1">{{ "Size required" }}</p>
                </div>
            </div>     
        </div>


        </div>


        <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <textarea name="" v-model="add_prod.description" id="" class="form-control"></textarea>
        </div>

        <div class="d-flex justify-content-end">
            <router-link :to="{name: 'products'}">     
                <button type="button" 
                class="btn btn-danger me-2 modal-add">Back
                </button>             
            </router-link> 

            <form class="modal-footer" @submit.prevent="add_btn">
                <button type="submit"  :disabled="loading" class="btn btn-success me-2 modal-add">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Add product
                </button>
            </form>       
        </div>


        

    </div>
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


    const EventfileInput = ref(null);
          
    function onLoaded(){
        
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
        onLoaded()
    })


    return {
       add_prod,add_btn,rules,v$,loading,filter_input,getCat,
       category_lists,category,onLoaded,onDecode,showcam,toggleCam,imageUpload,onScan,serialRes,

       imageURL,imageFile,noSerial,serialField,serialHide
    }




}

}





</script>