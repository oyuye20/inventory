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
                    </i>Add new inventory stocks</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light">


            <div class="col-12 mb-1">
                <label for="" class="fw-bold mb-2">Category</label>
                <select class="form-control mb-2" v-model="category_lists.category" 
                @change="getSelectedCat(category_lists.category)">    
                    <option selected v-for="cat in category_lists">{{cat.category}}</option>
                </select>
            </div>


            <div class="col-12" v-if="catRes">
                <label for="" class="fw-bold mb-2">Product Name</label>
                <select class="form-control mb-3" v-model="inventory.product_info">
                <option v-for="prod in productinfo" :key="prod.id" :value="prod.id">
                {{prod.product_name}}</option>
                </select>
            </div>

            <div class="col-12">
                <label for="" class="fw-bold mb-2" >Supplier Name</label>
                <select class="form-control mb-3" v-model="inventory.supplier">
                    <option selected v-for="s in supplierSelect" :value="s.id">{{s.supplier_name}}</option>
                </select>
            </div>

                <div class="col-12 mb-1">
                    <label for="" class="fw-bold mb-2">Number of Stocks</label>
                    <input type="text" class="form-control mb-3" placeholder="Stocks" 
                    @input="filter_input" v-model="inventory.stocks">
                </div>


                <div class="col-12 mb-4">
                    <label for="" class="fw-bold mb-2">Safety Stocks</label>
                    <input type="text" class="form-control mb-3" placeholder="Safety Stocks" 
                    @input="filter_input" v-model="inventory.safetyStocks">
                </div>



                <div class="col-12 mb-1">
                    <label class="mb-3 fw-bold">Choose With or Without Expiration Date</label>
                    <div class="d-flex">
                        <div class="form-check mb-3 me-4">
                            <input class="form-check-input" type="radio" 
                            value="1" v-model="expire_radio" name="expiration" 
                            id="expiration" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                            With Expiration Date</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="0" 
                            v-model="expire_radio" name="expiration" id="expiration">
                            <label class="form-check-label" for="flexRadioDefault1">
                            Without Expiration Date</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4 d-flex flex-wrap" v-if="expire_radio == 1">
                    <div class="col-6">
                    <label for="" class="fw-bold mb-2">Production Date  
                    </label>
                    <input type="date" class="form-control mb-3" 
                    placeholder="Production Date" 
                    v-model="inventory.prod_date">

                    </div>


                    <div class="col-6">
                    <label for="" class="fw-bold mb-2">Expiration Date</label>
                    <input type="date" class="form-control" 
                    placeholder="Expiration Date" 
                    v-model="inventory.exp_date">
                        
                    </div>

                    
                </div>


                
                <div class="col-12 d-flex justify-content-end">
                
                <button role="button" class="btn btn-danger mt-3 fw-bold" @click="toggleModal">Close</button>

                <form @submit.prevent="add_inventory">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Add new stocks</button>
                </form>

                </div>


        
            </div>      
    </div>
</div>
</transition>



<transition name="modalAnim">
<div v-if="modalSupplier" class="p-3" id="modal-main">
    
    <div class="row d-flex justify-content-center align-items-center p-3" 
    id="modal-content">

            <div class="col-xxl-7 col-md-8 text-start p-3" 
            style="background-color: rgb(4, 180, 116);">


                <div class="col-12">
                    <span class="fw-bold fs-3 text-white">
                    <i class="fas fa-circle-plus me-3">
                    </i>Add new supplier</span>
                </div>
               
            </div>

            <div class="col-xxl-7 col-md-8 text-start p-3 bg-light">

                <div class="col-12 mb-1">
                    <label for="" class="fw-bold mb-2">Supplier Name</label>
                    <input type="text" class="form-control mb-3" v-model="supplier.name" placeholder="Supplier Name" >
                </div>

                <div class="col-12 mb-1">
                    <label for="" class="fw-bold mb-2">Supplier Contact Number</label>
                    <input type="text" class="form-control mb-3" v-model="supplier.number" placeholder="Supplier Contact Number" 
                    @input="filter_input" >
                </div>

                <div class="col-12 mb-1">
                    <label for="" class="fw-bold mb-2">Supplier Email</label>
                    <input type="email" class="form-control mb-3" v-model="supplier.email" placeholder="Supplier Email">
                </div>

                
                <div class="col-12 d-flex justify-content-end">
                
                <button role="button" class="btn btn-danger mt-3 fw-bold" @click="modalSupplier =! modalSupplier">Close</button>

                <form @submit.prevent="add_supplier">
                    <button type="submit" class="btn btn-success 
                    mt-3 fw-bold">Add new supplier</button>
                </form>

                </div>


        
            </div>      
    </div>
</div>
</transition>



<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
            <div class="sidebar_wrapper" :class ="{side: isSidebar}">
                <sidebar/>
            </div>
        <!-- sidebar-wrapper -->

        <!-- Page Content -->

        <div id="page-content-wrapper">

            <nav class="navbar py-4 px-4 shadow-none">   
                <div class="d-flex justify-content-between w-100">
                    <a v-on:click="isSidebar =! isSidebar" role="button" id="toggle_icon">
                    <i class="fas fa-bars me-3 fa-2x"></i></a>
                    <h2 class="fs-4 m-0 fw-bold"><i class="fas fa-boxes-stacked me-3"></i>Inventory</h2>
                    
                    <div class="div d-flex justify-content-center align-items-center" >
                        <logout/>
                    </div> 
        
                </div>

            </nav>

            <div class="container-fluid px-4">    

                <div class="container-fluid mb-3">
                    <button class="btn btn-dark fw-bold" @click="toggleModal">Add new stocks</button>

                    <button class="btn btn-dark fw-bold" @click="modalSupplier =! modalSupplier">Add new supplier</button>

                    <button @click="exportExcel" class="btn 
                    btn-success modal-add"><i class="far fa-file-excel me-2">         
                    </i> Export inventory excel </button>  
                </div>


                <inventory_content :key="refreshComponent"/>               
            </div>


        </div>



    </div>
    <!-- /#page-content-wrapper -->

</body>

</template>


<script>
import '../assets/dashboard.css'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { useStore } from "vuex";
import { computed, toHandlers } from "vue";
import { useRouter } from "vue-router";
import {reactive, onMounted} from 'vue';
import sidebar from '../components/sidebar/sidebar.vue';
import inventory_content from '../components/inventory_content.vue';
import { ref } from 'vue'
import logout from '../components/modal/logout.vue';
import axios_client from '../axios';
import {useToast} from 'vue-toast-notification';

export default {
    name: 'inventory',

    components: {
        Bootstrap5Pagination,
        inventory_content,
        sidebar,
        logout
    },

    

    setup(){

        const store = useStore();
        const router = useRouter();
        const $toast = useToast();

        const refreshComponent = ref(0);

        const isSidebar = ref(false);
        const modalActive = ref(false);
        const catRes = ref(false);
        const modalSupplier = ref(false);

        const category_lists = ref([]);
        const productinfo = ref([]);


        const supplierSelect = ref([]);
        

        const expire_radio = ref('1');
        const username = ref('');


        const inventory  = reactive({
          category: '',
          product_info: '',
          stocks: "",
          safetyStocks: "",
          prod_date: '',
          exp_date: '',
          supplier: '',
        })

        const supplier  = ref({
          name: '',
          number: '',
          email: '',
        })



        function filter_input(){
          this.inventory.stocks = this.inventory.stocks.replace(/[^0-9]/g, "");
          this.inventory.safetyStocks = this.inventory.safetyStocks.replace(/[^0-9]/g, "");
          this.inventory.supplierNumber = this.inventory.supplierNumber.replace(/[^0-9]/g, "");
        }


        const userData = async() => {
            axios_client.get('/user').then(response=>{
              username.value = response.data.username;


            }).catch(error =>{
                console.log(error.response.data)
            })
        }


        function add_supplier(){
            console.log('hello')

          let formData = new FormData();
          formData.append('supplier_name', supplier.value.name);
          formData.append('supplier_number', supplier.value.number);
          formData.append('supplier_email', supplier.value.email);
 

          let url = '/supplier/add';
            axios_client.post(url,formData).then(response => {

                refreshComponent.value += 1;

                console.log(response.data)

                $toast.success("Supplier added successfully", {position: 'top'}); 

            }).catch(error =>{
                console.log(error.response.data)
            })


        }







        function add_inventory(){
          
          let formData = new FormData();
          formData.append('category', this.inventory.category);
          formData.append('product_info', this.inventory.product_info);
          formData.append('supplier', this.inventory.supplier);
          formData.append('stocks', this.inventory.stocks);
          formData.append('safetyStocks', this.inventory.safetyStocks);
          formData.append('stockBy', username.value);
          formData.append('updatedBy', username.value);
          formData.append('prod_date', this.inventory.prod_date);
          formData.append('exp_date', this.inventory.exp_date);
          formData.append('noExpiration', expire_radio.value);

          var currentdate = new Date(); 

          let dateNow = currentdate.toISOString().split('T')[0];
          let prod_date = this.inventory.prod_date
          let exp_date1 = this.inventory.exp_date


          let safeStocks = this.inventory.safetyStocks
          let stocks1 = this.inventory.stocks

          

            if((expire_radio.value == '1') && ((prod_date > dateNow) || (exp_date1 <= dateNow))){
                $toast.error("Please enter valid date for production or expiration date", {position: 'top'}); 
            }
          
            else if(safeStocks >= stocks1 ){
                $toast.error("Safety Stocks must less than stock value", {position: 'top'}); 
            }

            else{
            let url = '/inventory/add';
            axios_client.post(url,formData).then(response => {

                refreshComponent.value += 1;

                console.log(response.data)

                modalActive.value = false;

                this.inventory.category = ''
                this.inventory.product_info = ''
                this.inventory.stocks = ''
                this.inventory.prod_date = ''
                this.inventory.exp_date = ''
                this.inventory.supplier = ''
                this.inventory.safetyStocks = ''


                $toast.success("Inventory added successfully", {position: 'top'}); 

            }).catch(error =>{
                console.log(error.response.data)
            })
            }
                  
        }


        function getSupplierLists(){
            axios_client.get('/supplier/select')
            .then(response=>{
                supplierSelect.value = response.data;
                console.log(response.data)
            }).catch(error =>{
                console.log(error.response.data)
            })
        }








        function exportExcel(){
            axios_client({
                url: '/export-excel/inventory',
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'inventory.csv');
                document.body.appendChild(fileLink);
                fileLink.click();
            });
        }
        





        function getSelectedCat (category){      
            console.log(category)


            axios_client.get('/select/product/info/' + category)
            .then(response=>{
                productinfo.value = response.data;
                catRes.value = true;
            }).catch(error =>{
                console.log(error.response.data)
            })

            this.inventory.category = category
        }

        const getCat = async() => {
            axios_client.get('/select/category')
            .then(response=>{
                category_lists.value = response.data;
            }).catch(error =>{
                console.log(error.response.data)
            })
        }






        const toggleModal = () =>{
            modalActive.value = !modalActive.value;
        }

    
        onMounted(()=> {
            getCat()    
            userData()
            getSupplierLists()
        })


        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }



        return {
            user: computed(() => store.state.user.data),logout,getSelectedCat,
            isSidebar,toggleModal,modalActive,inventory,add_inventory,filter_input,userData

            ,category_lists,productinfo,catRes,getCat,expire_radio,refreshComponent,exportExcel,modalSupplier,add_supplier
            ,supplier,getSupplierLists,supplierSelect
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

