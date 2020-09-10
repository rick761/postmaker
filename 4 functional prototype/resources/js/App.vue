<template>
    <div>          
        <preview-image-component />        
        <drawer-component />
        <global-modal />        
        <system-bar-component />
        
        <v-main style="min-height: 100vh; " :style="{background: $vuetify.theme.currentTheme.background}"  >

            <notification-component />            
            
            <v-row>
                

                <!--icons right-->
                <v-col cols=12 class="text-right pr-8" >    

                    <v-btn :href="LandingsPageUrl()" class="float-right" color="primary" icon>
                        <v-icon>mdi-file-move-outline</v-icon>
                    </v-btn>
                    
                    <form class="float-right" id="logout-form" :action="logoutActionUrl()" method="POST" >
                        <input type="hidden" name="_token" v-bind:value="csrf">   
                        <!-- <v-btn type="submit" text><v-icon>mdi-logout</v-icon> &nbsp; Uitloggen</v-btn>  -->
                        <v-btn type="submit" color="warning" icon>
                            <v-icon>mdi-logout-variant</v-icon>
                        </v-btn>
                    </form>    

                    <v-btn class="float-right" color="secondary" @click="$store.commit('notifications/TOGGLE_NOTIFICATION_MODAL');" icon>
                        <v-badge 
                                v-if="unread_notifications"
                                :content="unread_notifications"
                            >
                            <v-icon>mdi-message-outline</v-icon>                        
                        </v-badge>          
                        <v-icon v-else>mdi-message-outline</v-icon>           
                    </v-btn>
                </v-col>

                <feedback />

                <v-col cols=12>
                    <v-container fluid>                        
                        <breadcrumbComponent /> 
                        <router-view></router-view> 
                    </v-container>    
                </v-col>

            </v-row> 
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

    computed:{       
        ...mapGetters({           
            unread_notifications: 'notifications/UNREAD_NOTIFICATIONS',
        }),
    },

    methods:{
        logoutActionUrl(){
            return window.location.origin+'/logout'; 
        },
        LandingsPageUrl(){
            return window.location.origin;
        },
        
    },

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