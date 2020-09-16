<template>
    <!-- delete -->
    <v-list-item class="ml-15">
        <v-list-item-icon>
            <v-icon color="primary">mdi-open-in-new</v-icon>
        </v-list-item-icon>  
        <v-list-item-content>
            <a @click="loadOrder" text left class="ml-5 text-left d-block" >           
                                                             
                    Naar de opdracht                             
            </a>
        </v-list-item-content>
    </v-list-item> 
</template>

<script>
export default {
    props:['item'],
    methods:{
        loadOrder(){            
            this.$store.dispatch('order/get', this.item.id)
        },
    }
}

</script>