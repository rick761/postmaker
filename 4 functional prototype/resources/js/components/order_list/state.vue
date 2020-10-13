<template>
    <!-- delete -->
    <v-list-item :class=" { 'ml-15': item_from_prop } ">          
        <v-list-item-icon>
            <v-icon color="primary">mdi-clipboard-list-outline</v-icon>
        </v-list-item-icon>     

        <v-list-item-content v-if="auth && auth.type == 'postmaker'">                            
            <v-alert border="right" class="accent--text " :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'progress' ">          Verstuur een tijdelijke oplevering </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }"  dense colored-border   v-if=" computed_item.state == 'open' ">              Solliciteer voor de opdracht via een aanvraag</v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'delivery_accepted' ">  Verstuur de eindoplevering  </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'quit_postmaker' ">     Toch nog doorgaan? </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'quit' ">               Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'removed' ">            Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'recieved_payment' ">   Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'delivered' ">          Wacht op het oordeel van de aanvrager  </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'final_delivered' ">    Geef aan als er een betaling ontvangen is </v-alert>
        </v-list-item-content>
        
        <v-list-item-content v-if="auth && auth.type == 'requester'">
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'open' ">               Wacht op aanvragen</v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'progress' ">           Wacht voor de tijdelijke oplevering  </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'delivery_accepted' ">  Wacht op de de eindoplevering</v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'quit_postmaker' ">     Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'quit' ">               Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'removed' ">            Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'recieved_payment' ">   Geen actie </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'delivered' ">          Accepteren of verbeteren van de oplevering </v-alert>
            <v-alert border="right" class="accent--text" :class="{'text-right': !item_from_prop }" dense colored-border   v-if=" computed_item.state == 'final_delivered' ">    Betaal de factuur</v-alert>
        </v-list-item-content>
    </v-list-item> 
    
</template>

<script>
import {mapState} from 'vuex';
export default {
    
    computed:{
        ...mapState({
            order: state => state.order.data,
            auth: state => state.auth.user
        }),

        computed_item(){
            if(this.item == 0){
                return this.order;
            }
            return this.item;
        },

        item_from_prop(){
            return this.item != 0;
        },

        getClass(){

        }


    },

    props: {
        item: {
            default: 0
        }
    },

    methods:{
        // getAlertType(status){            
        //     if(status == 'progress')
        //         return 'info';
        //     if(status == 'delivered')                
        //         return 'warning'
        //     if(status == 'delivery_accept')
        //         return 'success';            
        //     if(status == 'recieved_payment')
        //         return 'success';            
        //     if(status == 'quit_postmaker')
        //         return 'error';            
        // },
    }
}
</script>