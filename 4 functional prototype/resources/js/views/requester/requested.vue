<template>      
    <v-row>
        <v-col cols=12>            
            <order-list-component title="Binnenkomende aanvragen" tooltip="Postmakers kunnen jouw projecten aanvragen ter uitvoering, als er gereageerd is kan je dit hier vinden.">                     
                <order-list-item-component v-for="(item,key) in orders" :item="item" :key="key" >
                    <order-open-list-item-component :item="item"  />
                    <order-request-confirm-list-item-component v-for="(request,key2) in item.order_requests" :item="request" :key="key2"   />
                </order-list-item-component>  
                <v-card-text v-if="orders.length == 0">      
                    Geen aanvragen
                </v-card-text>
            </order-list-component>      
        </v-col>            
    </v-row>      
</template>

<script>
import {mapState} from 'vuex'

export default {    
    computed:{
        ...mapState({
            orders : state => state.orders.requested
        }),        
    },    
    created(){
        this.$store.dispatch('orders/getRequested');
        
    }
}
</script>