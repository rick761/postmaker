<template>
    <div>          
        <preview-image-component />        
        <drawer-component />
        <global-modal />        
        <system-bar-component />
        
        <v-main style="min-height: 100vh; " :style="{background: $vuetify.theme.currentTheme.background}"  >

            <notification-component />   
            <feedback />
            
            <v-container fluid>                        
                <breadcrumbComponent > 
                    <icon-action-component :csrf="csrf" />
                </breadcrumbComponent>
                <router-view></router-view> 
            </v-container>    
         
        </v-main>
        
        <v-footer style="padding: 0 300px;" > </v-footer>
         <!-- {{csrf}}, {{auth}}  -->
    </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex'
export default {    
    props:['csrf','auth'],

    data(){return{
        prevRoute:null,        
    }},   

    created(){        
        this.$store.commit('auth/SET_AUTH', JSON.parse(this.auth));       
        this.$store.dispatch('orders/init');   
        this.$store.dispatch('notifications/init');         
    },         
}
</script>

<style >
.v-avatar img{    
    border-radius: 0 !important;
    height: auto !important;
}
a:hover{
    text-decoration: none;
}
.v-list{
    background: auto !important;
}
.v-btn{
    overflow: hidden;
}
.v-dialog--fullscreen {    
    height: 90vh !important;  
    bottom: 0 !important;
    top: auto !important;
    box-shadow: 0 1px 999px #000;
}
.bottom-0{
    bottom:0;
}
</style>