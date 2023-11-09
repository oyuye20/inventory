<template>
    

<a role="button" class="fw-bold text-dark fs-5" 
@click="logout"><i class="fas 
fa-arrow-right-from-bracket me-2"></i>
Logout</a>


</template>


<script>
import { ref, watchEffect, defineComponent } from 'vue';
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed, toHandlers } from "vue";
import Swal from 'sweetalert2'
export default {
    

setup() {
    const store = useStore();
    const router = useRouter();


    function logout(){
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
        });


        swalWithBootstrapButtons.fire({
        title: "Warning",
        text: "Are you sure you want to logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",

        }).then((result) => {

        if (result.isConfirmed) 
        {
            store.commit('logout');
            router.push({name: 'login'})   
        } 
        
        else if (result.dismiss === Swal.DismissReason.cancel) 
            {
            
            }
        });
    }


    return {user: computed(() => store.state.user.data), close,logout}
}

    
}
</script>