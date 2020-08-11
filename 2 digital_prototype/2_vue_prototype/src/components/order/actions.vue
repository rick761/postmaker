<template>
    <v-row>
        <v-col>
            <v-card flat>
                <v-card-title>Acties</v-card-title>
                <v-card-subtitle>Verander de status van het project</v-card-subtitle>

                <v-card-actions v-if="order.user.id == authUser.id" >
                    <v-btn-toggle  
                        v-model="selectedButtons_1"                    
                    >                            
                        <v-btn :disabled="hasPostmaker || order.state == 'archived'" @click="changeState('create')" class="primary" value="create">
                            <span class="hidden-sm-and-down">Aanmaak</span>
                            <v-icon right>mdi-newspaper-plus</v-icon>
                            
                        </v-btn>
                        <v-btn :disabled="hasPostmaker || order.state == 'archived'" @click="changeState('open')" class="success" value="open">
                            <span class="hidden-sm-and-down">Open</span>
                            <v-icon right>mdi-cloud-search-outline</v-icon>
                        </v-btn>
                    </v-btn-toggle>                    
                </v-card-actions>

                <v-card-actions v-if="order.user.id == authUser.id">                     
                    <v-btn-toggle  
                        v-model="selectedButtons_1"                    
                    >
                        <v-btn :disabled="!hasPostmaker || order.state == 'archived'" @click="changeState('in_progress')" class="primary" value="in_progress">
                            <span class="hidden-sm-and-down">Wachten</span>
                            <v-icon right>mdi-progress-wrench</v-icon>
                            
                        </v-btn>

                        <v-btn :disabled="!hasPostmaker || order.state == 'archived'"  @click="changeState('declined')" class="error" value="declined">
                            <span class="hidden-sm-and-down">Afkeuren</span>
                            <v-icon right>mdi-progress-alert</v-icon>
                            
                        </v-btn>

                        <v-btn :disabled="!hasPostmaker || order.state == 'archived'" @click="changeState('accepted')" class="success" value="accepted">
                            <span class="hidden-sm-and-down">Goedkeuren</span>
                            <v-icon right>mdi-progress-check</v-icon>                            
                        </v-btn>                        
                    </v-btn-toggle>
                </v-card-actions>

                <v-card-actions v-if="order.user.id == authUser.id" >

                    <v-btn-toggle  
                        v-model="selectedButtons_1"                    
                    >                            
                        <v-btn :disabled="!hasPostmaker || order.state == 'archived'"  @click="changeState('stop')" class="error" value="stop">
                            <span class="hidden-sm-and-down">Stoppen</span>
                            <v-icon right>mdi-progress-close</v-icon>                            
                        </v-btn>

                        <v-btn :disabled="!hasPostmaker || order.state == 'archived' "  @click="changeState('payed')" class="success" value="payed">
                            <span class="hidden-sm-and-down">Betaald</span>
                            <v-icon right>mdi-progress-check</v-icon>
                        </v-btn>

                    </v-btn-toggle>                    

                </v-card-actions>

                <v-card-actions v-if="order.user.id == authUser.id" >

                    <v-btn-toggle  
                        v-model="selectedButtons_1"                    
                    >                            
                        <v-btn :disabled="!((order.postmaker_state == 'payed' && order.state == 'payed') || (order.postmaker_state == 'stop' && order.state == 'stop') || order.state=='archived' )" @click="changeState('archive')" class="secondary" value="stop">
                            <span class="hidden-sm-and-down">Archiveren</span>
                            <v-icon right>mdi-archive</v-icon>                            
                        </v-btn>                        
                        
                    </v-btn-toggle>                    

                </v-card-actions>

                <v-card-actions v-if="order.postmaker.id == authUser.id" >
                    <v-btn-toggle  
                        v-model="selectedButtons_1"                    
                    >                            
                        <v-btn @click="changePostmakerState('in_progress')" class="primary" value="in_progress">
                            <span class="hidden-sm-and-down">Bezig</span>
                            <v-icon right>mdi-progress-wrench</v-icon>                            
                        </v-btn>
                        <v-btn @click="changePostmakerState('delivered')" class="success" value="delivered">
                            <span class="hidden-sm-and-down">Oplevering</span>
                            <v-icon right>mdi-progress-check</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-card-actions>

                <v-card-actions v-if="order.postmaker.id == authUser.id" >
                    <v-btn-toggle  
                        v-model="selectedButtons_1"                    
                    >                            
                        <v-btn @click="changePostmakerState('stop')" class="error" value="stop">
                            <span class="hidden-sm-and-down">Stoppen</span>
                            <v-icon right>mdi-progress-close</v-icon>
                            
                        </v-btn>
                        <v-btn :disabled="!(order.postmaker_state == 'delivered')" @click="changePostmakerState('payed')" class="success" value="payed">
                            <span class="hidden-sm-and-down">Betaald</span>
                            <v-icon right>mdi-progress-check</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-card-actions>

                <v-card-text >
                    <p>
                        <v-avatar color="grey" size="56" class="mr-4">
                            Post maker                        
                        </v-avatar>
                         <i>                    
                            <span class="text-primary" v-if="order.postmaker_state == 'in_progress'">Wordt gemaakt</span>
                            <span class="text-success" v-if="order.postmaker_state == 'delivered'">Opgeleverd</span>
                            <span class="text-danger" v-if="order.postmaker_state == 'stop'">Wilt stoppen</span>
                            <span class="text-success" v-if="order.postmaker_state == 'payed'">Betaling ontvangen</span>                     
                        </i>                  
                    </p>
                    <p>
                        <v-avatar color="grey" size="56" class="mr-4">
                            Aan vrager                       
                        </v-avatar>
                        <i>                    
                            <span class="text-warning" v-if="order.state == 'create'">Aanmaken</span>
                            <span class="text-success" v-if="order.state == 'open'">Open</span>
                            <span class="text-primary" v-if="order.state == 'in_progress'">Wacht voor een oplevering</span>
                            <span class="text-warning" v-if="order.state == 'declined'">Oplevering is afgewezen</span>
                            <span class="text-success" v-if="order.state == 'accepted'">Oplevering is geaccepteerd</span>
                            <span class="text-success" v-if="order.state == 'payed'">Heeft betaald</span>
                            <span class="text-danger" v-if="order.state == 'stop'">Wilt stoppen</span>    
                            <span class="text-secondary" v-if="order.state == 'archive'">gearchiveerd / afgerond</span>                 
                        </i>
                    </p>
                </v-card-text>
            </v-card>
        </v-col>

   

        



                                              
                                        
    </v-row>
</template>

<script>
import {mapState} from 'vuex'


export default {
    props:[],
    components:{        
                
    },
    computed:{
        ...mapState({  
            order : state => state.order_page.order,
            authUser : state => state.auth.user,
            loader : state => state.loader,
            deliverys : state => state.order_page.order.deliverys
        }),
  
        hasUploadedFiles(){
            return this.deliverys.length
        },

        hasPostmaker:function(){
            return this.order.postmaker.id != null;
        }
    },

    data(){return{
        files:'',
        public_path : localStorage.getItem('server-public-path'),
        selectedButtons_1: 'in_progress',
    }},

    methods:{
        changeState(state){
            this.$store.dispatch('order_page/order/changeState',state);
        },
        changePostmakerState(state){
            this.$store.dispatch('order_page/order/changePostmakerState',state);
        },
        uploadFiles(){            
            let formData = new FormData();
            for( var i = 0; i < this.files.length; i++ ){
                let file = this.files[i];
                formData.append('files[' + i + ']', file);
            }
            this.files = "";
            this.$store.dispatch('order_page/order/deliverys/upload', formData );
        },        
        handleFileUploads(){                      
            this.files = this.$refs.files.files; 
        },
        deleteFiles(){
            this.files =''
        }
    } 
}

</script>

<style scoped>
.active{
    box-shadow: 0 0 0 0.2rem rgba(38,143,255,.5);
    opacity: .65;    
    cursor:default;
}
.disabled{
    opacity: .65; 
    cursor:default;
}
</style>