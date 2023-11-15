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



<div class="container-fluid col-xxl-12 mt-3">
  <label for="select" class="form-label">Sort by category</label>
  <select class="form-control" v-model="category_lists.category" 
  @change="getSelectedCat(category_lists.category)">
    <option v-for="c in category_lists">{{c.category}}</option>
  </select>
</div>






<div class="container-fluid mt-3 table-responsive">



    <table class="table text-center mb-0 bg-white">
  <thead>
    <tr>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Image</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Serial Number</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Product Name</th>
            <!-- <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Supplier</th> -->
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Category</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Price</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Selling Price</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Stocks</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Safety Stocks</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Production Date</th>
            <th class="fw-bold" style="color: rgba(0, 0, 0, 0.915);">Expiration Date</th>
    </tr>
  </thead>


  <tbody v-for="i in inv_lists.data">
    <tr>

      <td @click="showImage(i.image, i.product_name)"
      style="cursor: pointer;">
        <img v-bind:src="storageLink + i.image" 
        width="100" height="100">
      </td>

      <td>{{i.serial_number}}</td>

      <td>{{i.product_name}}</td>
      <!-- <td>{{i.supplier}}</td> -->
      <td>{{i.category}}</td>

      <td>
        {{Intl.NumberFormat('en-PH', { style: 'currency', 
        currency: 'PHP' }).format((i.price))}}              
      </td>

      <td>
        {{Intl.NumberFormat('en-PH', { style: 'currency', 
        currency: 'PHP' }).format((i.selling_price))}}              
      </td>

      <td>{{i.stocksTotal}}</td>
      <td>{{i.safety_stocksTotal}}</td>


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


<!-- <div class="container-fluid mb-4">

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
  

</div> -->




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

  

        function showImage(image, product) {
            Swal.fire({
                title: product,
                imageUrl: storageLink + image,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: image,
            })
        }


    
        /* GET PRODUCT TABLE */
        const getInventory = async(page = 1) => {

          if(search_box.value == ''){
            axios_client.get('/inventoryLists?page=' + page).then(response=>{
                  inv_lists.value = response.data

              }).catch(error =>{
                  console.log(error.response.data)
              })
           
            }

            else {
              axios_client.get('/inventoryLists/search/' + search_box.value  + '?page=' + page).then(response=>{
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


        const getCat = async() => {
            axios_client.get('/select/category')
            .then(response=>{
                category_lists.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        function getSelectedCat(category){     
          axios_client.get('/inventoryLists/category/' + category)
            .then(response=>{
              inv_lists.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        }

        



        onMounted(()=> {
            getInventory()
            userData()
            getCat()
        })

        return {showImage,getInventory,inv_lists,category_lists,productinfo,
        storageLink,search_box,expire_radio,userData,username,catRes,getCat,getSelectedCat}

    }



}
</script>