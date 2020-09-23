<template>    
    <v-row>       
        <v-col cols=12 lg="12">                
            <order-list-component title="Opdachten waar ik mee bezig ben" >               
                <order-list-item-component v-for="(item,key) in orders" :item="item" :key="key" >
                    <order-open-list-item-component :item="item"  />
                    <order-account-list-item-component :item="item" />
                    <!-- <order-messages-list-item-component :item="item" />    -->
                    <order-state-list-item-component :item="item" />
                </order-list-item-component>
                <v-card-text v-if="orders.length == 0">
                    Er zijn geen aangemonen opdrachten, vraag beschikbare opdrachten aan.
                </v-card-text>
            </order-list-component>             
        </v-col>      
    </v-row>    
</template>

<script>
import { mapState } from 'vuex';
export default {    
    computed:{
         ...mapState({
            orders: state => state.orders.list,           
        }),
    },
    data(){return{  
        progressing_items:[
            {title:'Email templates',        icon:'mdi-draw',                state: 'progress',        deliver:'1 dag'},
            {title:'Natuurfotos',            icon:'mdi-camera-outline',      state: 'delivered',       deliver:'5 dagen'},
            {title:'Advertentie filmpje',    icon:'mdi-camcorder',           state: 'delivery_accept', deliver:'8 dagen'},
        ]
    }},
    methods:{
        log(value){
            console.log(value);
        },        
    },
    created(){        
        this.$store.dispatch('orders/get');
    }
}
</script>