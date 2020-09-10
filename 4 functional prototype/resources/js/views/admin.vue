<template>    
        <v-row>
            <v-col>
                
                <card v-if="data">
                    <v-card-title>
                        <v-spacer></v-spacer>
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Zoek"
                            single-line
                            hide-details
                            
                        ></v-text-field>
                    </v-card-title>

                    <v-data-table                        
                        :headers="[
                            {text:'version', value: 'version'},
                            {text:'story', value: 'story'},
                            {text:'rate', value: 'rate'},
                            {text:'feedback', value: 'feedback'},
                            {text:'notation', value: 'notation'},                        
                        ]"
                        :items="data"
                        :search="search"
                    />
                   
                </card>
            </v-col>   
        </v-row>  
</template>

<script>
import {mapState, mapGetters} from 'vuex'
export default {  
    data(){return{
        data : [],
        search: '',
    }},
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
    },
    created(){
         this.$store.dispatch('api/get','/get/feedback').then(()=>{
            this.data = this.$store.state.api.response;
        })
    }
}
</script>