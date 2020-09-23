 <template>
    <div class="d-block">

                    <v-tooltip left>
                        <template v-slot:activator="{ on, attrs }">          
                            <v-btn 
                            v-bind="attrs" 
                            v-on="on"  
                            :href="LandingsPageUrl()" 
                            class="float-right"
                            color="primary" 
                            icon
                            >
                                <v-icon>mdi-file-move-outline</v-icon>
                            </v-btn>
                            </template>
                        <span>Naar de landings pagina</span>
                    </v-tooltip>
                     

                    <v-tooltip left>
                        <template v-slot:activator="{ on, attrs }">                            
                             <form                              
                              id="logout-form" 
                              :action="logoutActionUrl()" 
                              method="POST"
                              class="float-right"
                               >
                                <input type="hidden" name="_token" v-bind:value="csrf">   
                                <!-- <v-btn type="submit" text><v-icon>mdi-logout</v-icon> &nbsp; Uitloggen</v-btn>  -->
                                <v-btn 
                                
                                type="submit" 
                                color="warning"
                                v-bind="attrs"
                                v-on="on" 
                                icon
                                >
                                    <v-icon>mdi-logout-variant</v-icon>
                                </v-btn>
                            </form>  
                        </template>
                        <span>Uitloggen</span>
                    </v-tooltip>

                    <v-badge 
                        v-if="unread_notifications"
                        :content="unread_notifications"
                        overlap 
                        style="margin-top:2px;"
                        class="float-right"                                      
                    >
                        <v-tooltip left >
                            <template v-slot:activator="{ on, attrs }"> 
                                    <v-btn                                 
                                        v-bind="attrs"
                                        v-on="on" 
                                        
                                        color="secondary"
                                        @click="$store.commit('notifications/TOGGLE_NOTIFICATION_MODAL');"
                                        icon
                                    >
                                        <v-icon >mdi-message-outline</v-icon>  
                                    </v-btn>
                            </template>
                            <span>Open berichten</span>
                        </v-tooltip>
                    </v-badge>
    </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex'
export default {
    props:['csrf'],
    computed:{       
        ...mapGetters({           
            unread_notifications: 'notifications/UNREAD_NOTIFICATIONS',
        }),
        ...mapState({
            notifications: state => state.notifications.list
        })
    },
    methods:{
        logoutActionUrl(){
            return window.location.origin+'/logout'; 
        },
        LandingsPageUrl(){
            return window.location.origin;
        },        
    },
    
}
</script>
                            
                        