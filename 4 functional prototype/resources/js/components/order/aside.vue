<template>
    <card outlined class="mb-5" >     
                <v-list>                   
                    
                    <order-state-list-item-component />

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-state-machine</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content v-if="order.state" class="text-right">                            

                            <span class="accent--text float-right" v-if=" order.state == 'open' " >
                                Opdracht is publiekelijk gesteld
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'progress' " >
                                Opdracht is aangenomen door een postmaker
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'final_delivered' " >
                                De eindoplevering is gedaan
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'delivery_accepted' " >
                                Tijdelijke oplevering is geaccepteerd  
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'quit_postmaker' " >
                                Postmaker wilt stoppen
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'quit' " >
                                Opdracht is gestopt
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'removed' " >
                                Opdracht is verwijderd
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'recieved_payment' " >
                                Betaling is ontvangen
                            </span>

                            <span class="accent--text float-right" v-if=" order.state == 'delivered' " >
                                Oplevering is geplaatst
                            </span>
                        </v-list-item-content>
                    </v-list-item>
                    
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-calendar-arrow-left</v-icon> &nbsp; 
                        </v-list-item-icon>
                        <v-list-item-content class="text-right">
                            <span class="float-right">{{order.created_at}}</span>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-calendar-arrow-right</v-icon> &nbsp; 
                        </v-list-item-icon>
                        <v-list-item-content class="text-right">
                             <span class="float-right">{{order.deliver}}</span>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-currency-eur</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content class="text-right">
                            <span class="float-right">{{order.payment}} euro</span>
                        </v-list-item-content>
                    </v-list-item>                    

                     <v-list-item v-if="hasPostmaker && !isPostmaker" :to="'/account/'+order.postmaker.id">
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content class="text-right" v-if="order.postmaker && order.postmaker.display_name" >
                            <span class="float-right">{{order.postmaker.display_name}}</span>
                        </v-list-item-content>                        
                    </v-list-item>
                    <v-list-item v-else-if="order.user" :to="'/account/'+order.user.id">
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content class="text-right" v-if="order.user && order.user.display_name" >
                            <span class="float-right">{{order.user.display_name}}</span>
                        </v-list-item-content>                        
                    </v-list-item>

                    <v-list-item v-if="hasPostmaker && !isPostmaker">
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-email</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content v-if="order.postmaker" class="text-right">
                            <span class="float-right">{{order.postmaker.email}}</span>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-else-if="order.user">
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-email</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content v-if="order.user" class="text-right">
                            <span class="float-right">{{order.user.email}}</span>
                        </v-list-item-content>
                    </v-list-item>

                    

                    

                </v-list>
              
            </card>

</template>

<script>
import { mapState } from 'vuex';
  export default {
    computed:{
        ...mapState({
            order: state => state.order.data,
            auth: state => state.auth.user
        }),

        isOwner(){
            if(this.auth && this.order.user)
                return this.auth.id == this.order.user.id;
        },

        hasPostmaker(){
            if(this.auth && this.order)
                return this.order.postmaker != null;                
        },

        inCreation(){
            return this.order.state == 'create';
        },

        isOpen(){
            return this.order.state == 'open';
        },

        inProgress(){
            return this.order.state == 'progress';
        },

        isPostmaker(){
            if(this.auth && this.order)
                return this.order.postmaker.id == this.auth.id;                
        },
    },

}

</script>