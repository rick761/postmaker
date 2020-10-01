<template>      
        <v-row>
            <v-col cols="12" md="6">                
                <edit-profile-component />                
            </v-col>

            <v-col cols="12" md="6">
               <preview-profile-component /> 
               <span v-if="auth.type == 'postmaker'" >      
                    <!-- <portfolio-profile-component />       -->
               </span>  
                            
            </v-col>
        </v-row>      

</template>
<script>
import {mapState} from 'vuex'
export default {
    data(){return{        
    }},
    computed:{
        ...mapState({
            auth: state=>state.auth.user,
        }),
    },
    created(){
        this.$store.dispatch('auth/archivedDelivery/getSuccessFullArchived')
    }
}
</script>