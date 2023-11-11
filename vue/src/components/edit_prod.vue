<template>
    <div class="container d-flex justify-content-center mt-3">

        
<form class="col-12 p-1 mb-3" @submit.prevent="update_Product()">

    <h4>Edit Product</h4>




    <div class="mb-3" v-if="imageURL">
        <img :src="imageURL" class="img-fluid" width="200" height="200">
        <p>New Image</p>
    </div>



    <div class="mb-3" v-else>
        <img v-bind:src="storageLink + edit_prod_val.image" width="200" height="200">
    </div>



    <div class="mb-3">
        <label for="" class="form-label">Image</label>
        <input type="file" @change="imageUpload" class="form-control">
    </div>





    <div class="mb-3">
        <label for="" class="form-label">Serial Number</label>
        <input type="text" disabled v-model="edit_prod_val.serial_number" 
        class="form-control" >

        <!-- <div v-if="v$.serial_number.$error">
            <p class="text-danger fw-bold mt-1">{{ "Serial number required" }}</p>
        </div> -->

    </div>

    <div class="mb-3">
        <label for="" class="form-label">Product name</label>
        <input type="text" v-model="edit_prod_val.product_name" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Manufacturer</label>
        <input type="text" inputmode="numeric" v-model="edit_prod_val.manufacturer" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Description</label>
        <textarea name="" v-model="edit_prod_val.description" id="" class="form-control"></textarea>
    </div>

    <div class="d-flex justify-content-center col-12">

        <div class="mb-3 col-3 mx-1">
            <label for="" class="form-label">Size</label>
            <input type="text" v-model="edit_prod_val.size" class="form-control">
        </div>

        <div class="mb-3 col-3 mx-1">
            <label for="" class="form-label">Price</label>
            <input type="text" v-model="edit_prod_val.price" @input="filter_input()" class="form-control">
        </div>

        <div class="mb-3 col-3 mx-1">
            <label for="" class="form-label">Selling</label>
            <input type="text" v-model="edit_prod_val.selling_price" @input="filter_input()" class="form-control">
        </div>


    </div>


    <div class="modal-footer">

        <router-link :to="{name: 'products'}">
            <button type="button" 
            class="btn btn-danger me-2 modal-add ">Back
            </button>             
        </router-link>   


        <button type="submit" :disabled="loading" 
        class="btn btn-success me-2 modal-add ">   
        <span v-if="loading" class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Update Product
        </button>  

    </div>       

    <!-- data-bs-dismiss="modal" -->

</form>
</div>
</template>

<script>
import {reactive, onMounted} from 'vue';
import {useVuelidate} from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import axios_client from '../axios';
import { useRouter, useRoute } from "vue-router";
import { ref } from 'vue'
import { defineProps } from "vue";
import { inject } from 'vue'

export default {

    setup(){
    const storageLink = inject('$storageLink');
    const router = useRouter();
    const route = useRoute();
    const loading = ref(false);


    const config = {
        headers: {
            'content-type': 'application/x-www-form-urlencoded'
        }
    }


    const edit_prod_val = ref([]);
    const imageFile = ref('');
    const imageURL = ref ('');
    
    

    const rules  = {
        serial_number: {required}
    }

    const v$ = useVuelidate(rules)



    


    function imageUpload(e){
        const file = imageFile.value = e.target.files[0]
        imageURL.value = URL.createObjectURL(file)
    }



    /* GET PRODUCT TABLE */
    const getProduct = async() => {
        axios_client.get(`/product/edit/` 
        + route.params.id).then(response=>{

            edit_prod_val.value = response.data;


        }).catch(error =>{
            console.log(error)
        })
    }


   

 

    /* UPDATE A PRODUCT */
    function update_Product (){
        loading.value = true;

        let formData = new FormData();
        formData.append('image2', imageFile.value);
        formData.append('product_data', JSON.stringify(edit_prod_val.value));


        axios_client.post(`/update_product/`
         + route.params.id, formData, config).then(response=>{
            loading.value = true;
            router.push({name: 'products'})
        }).catch(error =>{
            console.log(error.response.data)
        })
    }



    /* PREVENT ALPHANUMERIC CHARACTERS INPUT */
    function filter_input(){
        this.edit_prod_val.price.replace(/[^0-9]/g, "");
        this.edit_prod_val.selling_price.replace(/[^0-9]/g, "");
    }


    onMounted(()=> {
        getProduct()
    })


    return {
       rules,v$,loading,getProduct,route,edit_prod_val,update_Product,
       filter_input,storageLink,imageUpload,imageFile,imageURL
    }



}

}





</script>