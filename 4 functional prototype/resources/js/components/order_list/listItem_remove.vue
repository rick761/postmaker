<template>
    <!-- delete -->
    <v-list-item >       
        <a @click="deleteOrder" text left class="ml-15 text-left d-block" >            
                <v-icon>mdi-delete</v-icon>   &nbsp;                                            
                Verwijder                   
        </a>
    </v-list-item> 
</template>

<script>
export default {
    props:['item'],
    methods:{
        deleteOrder(){
            this.$store.dispatch('modal/confirmAction',{
                action: 'order/remove',
                parameter : this.item.id,
                //title: 'test',
                //text: 'test'
            })
        }
    }
}
</script>