<template>    
        <v-row>

            <v-col cols=12 lg="12">                
                <order-list-component title="In progressie">
                    <order-list-item-component v-for="(item,key) in orders_progressing" :item="item" :key="key" > 
                        <order-open-list-item-component :item="item"  />   
                        <order-account-list-item-component :item="item" />
                        <!-- <order-messages-list-item-component :item="item" /> -->
                        <order-state-list-item-component :item="item" />
                    </order-list-item-component> 
                    <v-card-text v-if="orders_progressing.length == 0">
                        Er zijn geen opdrachten waarmee een postmaker mee aan de slag is.
                    </v-card-text>
                </order-list-component>              
            </v-col> 
            
            <v-col cols=12 lg="6" >     
                <order-list-component title="In aanmaak">
                    <order-list-item-component v-for="(item,key) in orders_in_creation" :item="item" :key="key" >
                        <order-open-list-item-component :item="item"  />
                        <order-remove-list-item-component :item="item"  />                        
                    </order-list-item-component>      
                     <v-card-text v-if="orders_in_creation.length == 0">
                        Er zijn geen nieuw aangemaakt opdrachten.
                    </v-card-text>
                </order-list-component>                
            </v-col>

            <v-col cols=12 lg=6>
                <order-list-component title="Gepubliceerd">
                    <order-list-item-component v-for="(item,key) in orders_published" :item="item" :key="key" > 
                        <order-open-list-item-component :item="item"  />
                        <order-remove-list-item-component :item="item"  />  
                    </order-list-item-component>
                    <v-card-text v-if="orders_published.length == 0">
                        Er zijn geen gepubliceerde opdrachten.
                    </v-card-text>
                </order-list-component>
            </v-col>

           
            <order-delivery-open-component />
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
            return this.orders.filter(item => item.state != 'create' && item.state != 'open');
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