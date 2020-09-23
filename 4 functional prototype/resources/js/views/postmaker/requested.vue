<template>      
    <v-row>           
        <v-col cols=12>            
            <order-list-component title="Opdrachten die ik heb aangevraagd" tooltip="Jij kan solliciteren op opdrachten, als je dit gedaan hebt kun je deze hier vinden.">
                <order-list-item-component v-for="(item,key) in orders" :item="item" :key="key" >
                    <order-open-list-item-component :item="item"  />
                    <order-request-apply-list-item-component 
                        v-for="(request,key) in item.order_requests" 
                        :item="request" :key="key"  
                    />                   
                </order-list-item-component>  
                <v-card-text v-if="orders.length == 0">
                    Geen lopende aanvragen.
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
    data(){return{
       
    }},
    created(){
        this.$store.dispatch('orders/getRequested');
    }
}
</script>