<template>
    
<transition name="modalAnim1">
    <div class="div" v-show="logoutModal">
        <div class="container-fluid d-flex justify-content-center align-items-center" 
        style="width: 100%; height: 100%; position: fixed; overflow: auto;  background-color: rgba(0, 0, 0, 0.605)">
            <div class="row container d-flex 
            justify-content-center align-items-center">

                    <div class="col-lg-5 bg-light shadow-sm p-0">
                
                        <div class="col-12 mb-1 text-start p-3 bg-light shadow-sm"> 
                            <div class="col-12 d-flex justify-content-center flex-column align-items-center">
                                <span><i class="fas fa-triangle-exclamation me-3 fa-2x text-danger"></i></span>
                                <span class="fs-2 text-danger">Warning</span>
                            </div> 
                        </div>


                        <div class="d-flex justify-content-end p-3 flex-column" style="background-color: rgb(244, 244, 244);">
                            <p class="p-4 text-center fw-bold fs-5">
                            Are you sure you want to logout?
                            </p>


                            <div class="d-flex justify-content-end">    
                                <button class="btn bg-light border borderr-dark fw-bold me-2" @click="close"
                                >No</button>

                                <button role="button" class="btn me-2 text-light fw-bold" @click="logout"
                                style="background-color: #F65656;"
                                >Yes</button>
                            </div>

                        </div>
                </div>
            </div>           
        </div>
    </div>
</transition>





</template>


<script>
import { ref, watchEffect, defineComponent } from 'vue';
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed, toHandlers } from "vue";
export default {
    props: ["logoutModal"],

    setup(props, {emit}) {
        const store = useStore();
        const router = useRouter();


        const close = () => {
            emit('close');
        }


        function logout(){
            store.commit('logout');
            router.push({name: 'login'})
        }


        return {user: computed(() => store.state.user.data), close,logout}
    }

    
}
</script>