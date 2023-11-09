<template>

<div class="container-fluid col-xxl-12 d-flex justify-content-between ">
  <div class="col-10 me-3">
      <input type="text" @keydown.enter="getInventory" role="searchbox" v-model="search_box" class="form-control rounded-5 p-2" 
      style="box-shadow: 3px 3px 3px rgb(197, 197, 197); 
      border: 1.9px solid rgb(215, 214, 214);" placeholder="Search Inventory">
  </div>

  <div class="col-2 d-flex justify-content-center p-0 m-0">
      <button class="btn btn-success" @click="getInventory"><i class="fas fa-magnifying-glass"></i></button>
  </div>
</div>





<div class="container-fluid mt-3 table-responsive">



    <table class="table text-center mb-0 bg-white">
  <thead>
    <tr>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Image</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Product Name</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Supplier</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Category</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Price</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Stocks</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Safety Stocks</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Production Date</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Expiration Date</th>
    </tr>
  </thead>


  <tbody v-for="i in inv_lists.data">
    <tr>

      <td @click="showImage(i.product.image, i.product.product_name)"
      style="cursor: pointer;">
        <img v-bind:src="storageLink + i.product.image" 
        class="img-fluid" width="100" height="100">
      </td>

      <td>{{i.product.product_name}}</td>
      <td>{{i.supplier}}</td>
      <td>{{i.category}}</td>

      <td>
        {{Intl.NumberFormat('en-PH', { style: 'currency', 
        currency: 'PHP' }).format((i.product.price))}}              
      </td>

      <td>{{i.stocks}}</td>
      <td>{{i.safety_stocks}}</td>


      <td v-if="i.production_date == null">
        No production date
      </td>

      <td v-else>{{i.production_date}}</td>


      <td v-if="i.expiration_date == null">
        No expiration_date date
      </td>

      <td v-else>{{i.expiration_date}}</td>


    </tr>
  </tbody>
  
</table>

<div class="d-flex justify-content-end align-items-center mt-3 fw-bold" >
    <Bootstrap5Pagination :limit="1" :keepLength="true" :data="inv_lists" class="shadow-sm"  
    @pagination-change-page="getInventory"
    />
</div>




</div>


<div class="container-fluid mb-4">

  <h4>Add new stocks</h4>

  <label for="" class="fw-bold mb-2">Category</label>
  <select class="form-control mb-3" v-model="category_lists.category" @change="getSelectedCat(category_lists.category)">    
    <option selected v-for="cat in category_lists">{{cat.category}}</option>
  </select>
  


  <div v-if="catRes">
    <label for="" class="fw-bold mb-2">Product Name</label>
    <select class="form-control mb-3" v-model="inventory.product_info">
      <option v-for="prod in productinfo" :key="prod.id" :value="prod.id">{{prod.product_name}}</option>
    </select>
  </div>
  





  <label for="" class="fw-bold mb-2">Supplier Name</label>
  <input type="text" class="form-control mb-3" v-model="inventory.supplier">

  <label for="" class="fw-bold mb-2">Supplier Email</label>
  <input type="email" class="form-control mb-3" v-model="inventory.supplierEmail">

  <label for="" class="fw-bold mb-2">Supplier Contact Number</label>
  <input type="text" class="form-control mb-3" v-model="inventory.supplierNumber" @input="filter_input">

  

  <label for="" class="fw-bold mb-2">Number of Stocks</label>
  <input type="text" class="form-control mb-3" placeholder="Stocks" @input="filter_input" v-model="inventory.stocks">


  <div class="form-control">
    <label class="mb-3 fw-bold">Choose With or Without Expiration Date</label>

    <div class="d-flex">
      <div class="form-check mb-3 me-4">
        <input class="form-check-input" type="radio" value="1" v-model="expire_radio" name="expiration" id="expiration" checked>
        <label class="form-check-label" for="flexRadioDefault1">With Expiration Date</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" value="0" v-model="expire_radio" name="expiration" id="expiration">
        <label class="form-check-label" for="flexRadioDefault1">Without Expiration Date</label>
      </div>

    </div>
   
  </div>

   

  <div class="mt-3" v-if="expire_radio == '1'">
    <label for="" class="fw-bold mb-2">Date of Production</label>
    <input type="date" class="form-control mb-3" placeholder="Production Date" v-model="inventory.prod_date">

    <label for="" class="fw-bold mb-2">Expiration Date</label>
    <input type="date" class="form-control" placeholder="Expiration Date" v-model="inventory.exp_date">
  </div>


  


  <form @submit.prevent="add_inventory">
    <button type="submit" class="btn btn-success w-100 mt-3 fw-bold">Add new stocks</button>
  </form>
  

</div>




</template>



<script>
import { useStore } from "vuex";
import { computed, toHandlers } from "vue";
import { useRouter } from "vue-router";
import {reactive, onMounted} from 'vue';
import axios_client from '../axios';
import { ref, watchEffect, defineComponent } from 'vue';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Swal from 'sweetalert2'
import {useToast} from 'vue-toast-notification';
import { inject } from 'vue'

export default {

    components: {
        Bootstrap5Pagination
    },
   
    
    setup(){

        const inv_lists = ref([]);
        const category_lists = ref([]);
        const productinfo = ref([]);
        const search_box = ref('');

        const expire_radio = ref('1');
        const username = ref('');
        const catRes = ref(false);


        const $toast = useToast();



        const storageLink = inject('$storageLink');

        const inventory  = reactive({
          category: '',
          product_info: '',
          stocks: '',
          prod_date: '',
          exp_date: '',
          supplier: '',
          supplierEmail: '',
          supplierNumber: ''
        })


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

        
        function filter_input(){
          this.inventory.stocks = this.inventory.stocks.replace(/[^0-9]/g, "");
          this.inventory.supplierNumber = this.inventory.supplierNumber.replace(/[^0-9]/g, "");
        }


        function add_inventory(){

          let safetyStocks = Math.round(this.inventory.stocks * 0.25);
          
          let formData = new FormData();
          formData.append('category', this.inventory.category);

          formData.append('supplier', this.inventory.supplier);
          formData.append('supplierEmail', this.inventory.supplierEmail);
          formData.append('supplierNumber', this.inventory.supplierNumber);



          formData.append('product_info', this.inventory.product_info);
          formData.append('stocks', this.inventory.stocks);
          formData.append('safetyStocks', safetyStocks);


          formData.append('stockBy', username.value);
          formData.append('updatedBy', username.value);




          formData.append('prod_date', this.inventory.prod_date);
          formData.append('exp_date', this.inventory.exp_date);
          formData.append('noExpiration', expire_radio.value);
          


          let url = '/inventory/add';
          axios_client.post(url,formData).then(response => {

            console.log(response.data)

            /* this.inventory.category = ''
            this.inventory.product_info = ''
            this.inventory.stocks = ''
            this.inventory.prod_date = ''
            this.inventory.exp_date = ''
            this.inventory.supplier = ''
            this.inventory.safetyStocks = '' */
            this.getInventory();

            $toast.success("Inventory added successfully", {position: 'top'}); 

          }).catch(error =>{
             
              console.log(error.response.data)
          })
        }


    
        /* GET PRODUCT TABLE */
        const getInventory = async(page = 1) => {

          if(search_box.value == ''){
            axios_client.get('/inventory?page=' + page).then(response=>{
                  inv_lists.value = response.data

              }).catch(error =>{
                  console.log(error.response.data)
              })
           
            }

            else {
              axios_client.get('/inventory/search/' + search_box.value  + '?page=' + page).then(response=>{
                  inv_lists.value = response.data

              }).catch(error =>{
                  console.log(error.response.data)
              })
      
            }

        }


        const userData = async() => {
            axios_client.get('/user').then(response=>{
              username.value = response.data.username;


            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        




        /* GET CATEGORY */
        const getCat = async() => {
            axios_client.get('/select/category')
            .then(response=>{
                category_lists.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }




        function getSelectedCat (category){      
            axios_client.get('/select/product/info/' + category)
            .then(response=>{
                productinfo.value = response.data;
                catRes.value = true;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }



        /* GET PRODUCT NAME IN SELECT INPUT */
        /* const getProductInfo = async() => {
            axios_client.get('/select/product/info')
            .then(response=>{
                productinfo.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        } */





        onMounted(()=> {
            getInventory()
            getCat()
    
            userData()
        })

        return {showImage,getInventory,inv_lists,category_lists,getCat,productinfo,inventory,
          add_inventory,filter_input,storageLink,search_box,expire_radio,userData,username,getSelectedCat,catRes}

    }



}
</script>