<template>      
    <v-row>           
        <v-col cols=12>            
            <order-list-component title="Aanvragen">
                <order-list-item-component v-for="(item,key) in orders" :item="item" :key="key" >
                    <order-request-apply-list-item-component 
                        v-for="(request,key) in item.order_requests" 
                        :item="request" :key="key"  
                    />
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
       
    }},
    created(){
        this.$store.dispatch('orders/getRequested');
    }
}
</script>