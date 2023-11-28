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



<!-- <div class="container-fluid col-xxl-12 mt-3">
  <label for="select" class="form-label">Sort by category</label>
  <select class="form-control" v-model="category_lists.category" 
  @change="getSelectedCat(category_lists.category)">
    <option v-for="c in category_lists">{{c.category}}</option>
  </select>
</div> -->






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



        const getSelectedCat = async(category, page = 1) => {
          axios_client.get('/inventoryLists/category/' + category + '?page=' + page)
            .then(response=>{
              inv_lists.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        }
        


        /* function getSelectedCat(category, page = 1){     
          axios_client.get('/inventoryLists/category/' + category + '?page=' + page)
            .then(response=>{
              inv_lists.value = response.data
            }).catch(error =>{
                console.log(error.response.data)
            })
        } */

        



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