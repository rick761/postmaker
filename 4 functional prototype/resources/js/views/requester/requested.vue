<template>      
    <v-row>
        <v-col cols=12> 
            <order-list-component title="Aanvragen">
                <order-list-item-component v-for="(item,key) in orders" :item="item" :key="key" >
                    <order-request-confirm-list-item-component v-for="(request,key2) in item.order_requests" :item="request" :key="key2"   />
                </order-list-item-component>  
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
    data(){return{
         requested_items:[
            {title:'Kleurplaat', icon:'mdi-draw', order_requests:{motivation:' blabla blabla blabla blabla blabla blabla'}},
        ]
    }},
    created(){
        this.$store.dispatch('orders/getRequested');
    }
}
</script>