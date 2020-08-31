<template>
    <v-expand-transition>
        <v-system-bar fixed top v-if="loading" absolute :height="get_loading_height" color="accent" light style="padding:0" >       
            <v-progress-linear     
                v-if="loading"        
                indeterminate
                rounded 
                color="primary"                
                height="100%"           
            ></v-progress-linear>            
        </v-system-bar>
    </v-expand-transition>
</template>

<script>
import {mapState} from 'vuex';
export default {
    computed:{
        ...mapState({
            loading : state => state.loader.data.systembar
        }),
        get_loading_height(){
            if(this.loading)
                return 12;
            return 2;
        }
    }
}
</script>