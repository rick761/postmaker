<template>
    <!-- delete -->
    <v-list-item  class="ml-15">        
        <v-list-item-icon>
            <v-icon color="primary">mdi-delete</v-icon> 
        </v-list-item-icon>  
        <v-list-item-content>
            <a @click="deleteOrder" text left class="ml-5 text-left d-block" >  
                    Verwijder                            
            </a>
        </v-list-item-content>
    </v-list-item> 
</template>

<script>
export default {
    props:['item'],
    methods:{
        deleteOrder(){
            this.$store.dispatch('modal/confirmAction',{
                actions: [
                    {                        
                        action: 'api/post',
                        parameter : { 
                            url: 'order/update',
                            data: {
                                id: this.item.id, 
                                state : 'removed'
                            }
                        }         
                    },
                    {
                        action: 'orders/get',
                        parameter: ''
                    }
                ]
            })
        },
    }
}
</script>