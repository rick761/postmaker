<template>    
        <v-row>

            <v-col cols=12 lg="6" >     
                <order-list-component title="In aanmaak">
                    <order-list-item-component v-for="(item,key) in orders_in_creation" :item="item" :key="key" >
                        <order-remove-list-item-component />
                    </order-list-item-component>      
                </order-list-component>                
            </v-col>

            <v-col cols=12 lg=6>
                <order-list-component title="Gepubliceerd">
                    <order-list-item-component v-for="(item,key) in orders_published" :item="item" :key="key" > 
                        <order-remove-list-item-component />
                    </order-list-item-component>
                </order-list-component>
            </v-col>

            <v-col cols=12 lg="12"> 
               
                <order-list-component title="In progressie">
                    <order-list-item-component v-for="(item,key) in orders_progressing" :item="item" :key="key" >    
                        <order-account-list-item-component :item="item" />
                        <order-messages-list-item-component :item="item" />
                        <order-state-list-item-component :item="item" />
                    </order-list-item-component> 
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

        orders_in_creation(){
            return this.orders.filter(item => item.state == 'create');
        },

        orders_published(){
            return this.orders.filter(item => item.state == 'open');
        },

        orders_progressing(){
            return this.orders.filter(item => item.state == 'progress');
        }

    },
    data(){return{
        active_item:0,
        sort: 'alphabetical-descending',      
        progressing_items:[
        
        ]
    }},   
    created(){        
        this.$store.dispatch('orders/get');
    }
}
</script>