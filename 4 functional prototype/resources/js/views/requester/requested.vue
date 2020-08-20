<template>      
    <v-row>
        <v-col cols=12> 

            <order-list-component title="Aanvragen">
                <order-list-item-component v-for="(item,key) in orders" :item="item" :key="key" >
                    <order-open-list-item-component :item="item"  />
                    <order-request-confirm-list-item-component v-for="(request,key2) in item.order_requests" :item="request" :key="key2"   />
                </order-list-item-component>  
                <v-card-text v-if="orders.length == 0">
                    Er zijn geen aanvragen op je gemaakte opdrachten.
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