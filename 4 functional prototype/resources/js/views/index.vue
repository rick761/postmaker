<template>    
        <v-row>              

            <!-- <v-col cols=12>
                <card >
                    <v-card-text>Welkom {{ auth.type }} {{auth.first_name}} {{auth.last_name}}, <br> </v-card-text>
                </card>
            </v-col>        -->

            <v-col cols=12 sm=4 v-if="activeProjects">
                <v-sheet 
                    class="justify-center align-center px-10 white--text h2 d-flex "
                    color="primary lighten-1"
                    height="200"
                 > 
                 <span v-if="activeProjects==1">{{activeProjects}} Actief project</span>
                 <span v-else>{{activeProjects}} Actieve projecten</span>                   
                 </v-sheet>
            </v-col>

            <v-col cols=12 sm=4 v-if="unread_notifications">
                <v-sheet                      
                    class="justify-center align-center px-10 white--text d-flex h2"                    
                    color="warning lighten-1"
                    height="200"
                >{{unread_notifications}} Berichten</v-sheet>

                <!-- <span class="info--text">info</span> -->
                
            </v-col>
            
            <v-col cols=12 sm=4 v-if="archivedProjects"> 
                     <v-sheet
                    class="justify-center align-center white--text px-10 d-flex  h2 pa-5"
                    color="error lighten-1"
                    height="200"
                >
                 <span v-if="archivedProjects==1">{{archivedProjects}} Gearchiveerd project</span>
                 <span v-else>{{archivedProjects}} Gearchiveerde projecten</span>                 
                </v-sheet>
            </v-col>   

            <v-col cols=12>
                <v-btn     
                    
                    :block="(this.$vuetify.breakpoint.name == 'xs')"            
                    v-if="auth.type == 'postmaker'" x-large to="/open" class="primary mr-3  mb-2"
                >
                    <v-icon>mdi-magnify</v-icon> &nbsp; Zoek nieuwe projecten 
                </v-btn>                 
                <v-btn 
                    
                    :block="(this.$vuetify.breakpoint.name == 'xs')"  
                    x-large :to="'/'+auth.type+'/orders'" class="secondary mr-3 mb-2"
                >
                    <v-icon>mdi-eye</v-icon> &nbsp; Mijn projecten 
                </v-btn>     
                <v-btn 
                    
                    :block="(this.$vuetify.breakpoint.name == 'xs')" 
                    v-if="auth.type=='requester'" x-large to="/requester/order/new" class="success mr-3 mb-2" 
                >
                    <v-icon>mdi-plus</v-icon> &nbsp; Nieuwe post aanmaken 
                </v-btn>                    
            </v-col>          

        </v-row>    


</template>

<script>
import {mapState, mapGetters} from 'vuex'
export default {    
    computed:{
        ...mapState({                
            auth: state => state.auth.user,
            archived: state => state.orders.archived,
            active: state => state.orders.list,
            notifications: state => state.notifications.list,
        }),

        ...mapGetters({           
            unread_notifications: 'notifications/UNREAD_NOTIFICATIONS',
        }),

        archivedProjects(){
            if(this.archived){
                return this.archived.length;
            } return 0;
        },

        activeProjects(){
            if(this.active){
                return this.active.length;
            } return 0;
        }
    }
}
</script>