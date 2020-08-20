<template>
    <!-- delete -->
    <v-list-item >
        <a @click="loadOrder" text left class="ml-15 text-left d-block" >            
                <v-icon>mdi-open-in-new</v-icon>   &nbsp;                                            
                Naar de opdracht                             
        </a>
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