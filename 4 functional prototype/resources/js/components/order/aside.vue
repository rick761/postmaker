<template>
    <v-card outlined class="mb-5" >     
                <v-list>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="success">mdi-calendar-arrow-left</v-icon> &nbsp; Sinds
                        </v-list-item-icon>
                        <v-list-item-content class="text-right">
                            {{order.created_at}}
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="error">mdi-calendar-arrow-right</v-icon> &nbsp; Tot
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
                            <span class="float-right">{{order.payment}}</span>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item v-if="order.user" :to="'/account/'+order.user.id">
                        <v-list-item-icon>
                            <v-icon color="secondary">mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content class="text-right" v-if="order.user && order.user.display_name" >
                            <span class="float-right">{{order.user.display_name}}</span>
                        </v-list-item-content>
                        <v-list-item-avatar v-if="order.user && order.user.avatar">
                            <v-img :src="'./storage/'+order.user.id+'/avatar/'+order.user.avatar" ></v-img>
                        </v-list-item-avatar> 
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="primary">mdi-email</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content v-if="order.user" class="text-right">
                            <span class="float-right">{{order.user.email}}</span>
                        </v-list-item-content>
                    </v-list-item>

                </v-list>

                <v-card-text>
                    <v-btn v-if="isOwner" @click="editModal = !editModal"  block color="primary mb-1"><v-icon>mdi-draw</v-icon> &nbsp;  Opdracht aanpassen <v-spacer /></v-btn>      
                    
                    <!-- <v-btn v-if="!inCreation" class="success" @click="publishModalCheck()" ><v-icon>mdi-file-send-outline</v-icon> &nbsp; Publiceer </v-btn>      
                            -->
                        <modal v-model="editModal" width=500 title="Weet u het zeker?">
                            De opdracht wordt hiermee in aanpas modus gezet. <br>
                            Hierdoor komen alle aanvragen te vervallen.
                            <template slot="actions">
                                <v-spacer></v-spacer>                                    
                                <v-btn class="success" @click="edit()"> <v-icon>mdi-file-send-outline</v-icon> &nbsp; Ja, Aanpassen</v-btn>
                                <v-btn @click="editModal = !editModal" class="error"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren</v-btn>
                            </template>
                        </modal> 

                    <v-btn v-if="isOwner" @click="deleteModal = !deleteModal"  block color="error mb-1"><v-icon>mdi-trash-can-outline</v-icon> &nbsp;  Opdracht verwijderen <v-spacer /></v-btn>
                        
                        <modal v-model="deleteModal" width=500 title="Weet u het zeker?">
                            De opdracht wordt hiermee permanent verwijderd. <br>                            
                            <template slot="actions">
                                <v-spacer></v-spacer>                                    
                                <v-btn class="primary" @click="deleteOrder()"> <v-icon>mdi-trash-can-outline</v-icon> &nbsp; Ja, Verwijderen</v-btn>
                                <v-btn @click="deleteModal = !deleteModal" class="success"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren</v-btn>
                            </template>
                        </modal> 

                </v-card-text>
            </v-card>

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
    },
    methods:{
        deleteOrder(){
            console.log('TODO')
        },
        edit(){
            this.$store.dispatch('order/edit');
        }
    },
    data () {
        return {
            editModal:false,
            deleteModal:false,
        }
    }
}

</script>