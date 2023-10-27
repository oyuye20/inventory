<template>

    <div class="container d-flex flex-column justify-content-center align-items-center">
    <StreamBarcodeReader v-if="showcam" class="w-100"
      @decode="(a, b, c) => onDecode(a, b, c)"
      @loaded="() => onLoaded()">
    </StreamBarcodeReader>
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




        <div class="mb-3">
            <label for="" class="form-label">Serial Number</label>

            <div class="d-flex">
                <input type="text"  v-model="add_prod.serial_number" class="form-control">

                <button class="btn btn-primary w-10" @click="toggleCam" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Tooltip on top"><i class="fas fa-barcode"></i></button>
            </div>


            <div v-if="v$.serial_number.$error">
                <p class="text-danger fw-bold mt-1">{{ "Serial number required" }}</p>
            </div>
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


        <form class="modal-footer" @submit.prevent="add_btn">
            <button type="submit"  :disabled="loading" class="btn btn-success me-2 modal-add">
                <span v-if="loading" class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Add product
            </button>
        </form>       

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
        serial_number: '',
        manufacturer: '',
        product_name: '',
        description : '',
        size : '',
        price : '',
        category: '',
    })


    function filter_input(){
        this.add_prod.serial_number = this.add_prod.serial_number.replace(/[^0-9]/g, "");
        this.add_prod.price = this.add_prod.price.replace(/[^0-9]/g, "");
    }



   /*  const serial_number = ref('') */

    const rules  = {
        serial_number: {required},
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




    function add_btn(){
        console.log(category.value)
        loading.value = true;
        this.v$.$validate()

        if(!this.v$.$error)
        {
            let formData = new FormData();
            formData.append('serial_number', this.add_prod.serial_number);
            formData.append('manufacturer', this.add_prod.manufacturer);
            formData.append('product_name', this.add_prod.product_name);
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
       category_lists,category,onLoaded,onDecode,showcam,toggleCam,imageUpload,

       imageURL,imageFile
    }




}

}





</script>