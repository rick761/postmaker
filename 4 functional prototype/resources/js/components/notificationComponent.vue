<template>    
    <v-overlay     
        opacity="0"     
        :value="open_dialog"  
        @click.native="close($event)" 
    >
            <div class="mr-3 mt-3" style="position:absolute; right:0; top:0;" >                
                <v-slide-y-transition group>

                    <v-alert                         
                       :color="notification.read == 1 ? 'info' : 'primary'"
                        width="400" 
                        dismissible
                        @input="remove(notification)" 
                        v-for="(notification,key) in notifications" 
                        :key="key" 
                    >

                        <a
                         style="color:white;"
                         href="javascript:void(0)" 
                         @click="openNotification(notification)">
                          {{notification.text}}
                        </a>                       
                       
                    </v-alert>

                </v-slide-y-transition>
            </div>
     </v-overlay >
</template>

<script>

import {mapState} from 'vuex';
export default {
    computed:{
        ...mapState({
            open_dialog :state => state.notifications.modal,
            notifications : state => state.notifications.list
        })
    },
    methods: {
        close (e) {
            if(e.target.className == 'v-overlay__scrim'){
                this.$store.commit('notifications/TOGGLE_NOTIFICATION_MODAL');
            }
        },
        remove(notification){
            this.$store.dispatch('notifications/remove',notification);
        },
        openNotification(notification){            
            this.$store.dispatch('notifications/read',notification);
            try{
                if(this.$route.path != notification.url){
                     this.$router.push(notification.url)
                }
                else{
                    this.$router.go();
                }               
            }
            catch(e){
                //console.log(e)
            };
           
        }
    }, 
}

</script>

<style  scoped>
    .v-overlay{display:block}
    
</style>

