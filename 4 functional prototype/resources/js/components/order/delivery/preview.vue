<template>
    <v-list-item @click="loadDelivery" three-line>      
           
        <v-list-item-icon v-if="last">
            <v-icon color="accent" v-if="item.type =='final'" >mdi-crown-outline</v-icon>
            <v-icon color="accent" v-else >mdi-cube-send</v-icon>            
        </v-list-item-icon>

        <v-list-item-icon v-else>
            <v-icon v-if="item.type =='final'"  >mdi-crown-outline</v-icon>
            <v-icon v-else  >mdi-cube-send</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
            <v-list-item-title v-if="last" ><b>{{item.title}}</b></v-list-item-title>
            <v-list-item-title v-else >{{item.title}}</v-list-item-title>
            <v-list-item-subtitle>
                {{item.text}}
                <p>{{item.created_at}}</p>
            </v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-icon class="ml-5">
            <v-icon color="primary">mdi-message-text</v-icon> {{item.order_delivery_comments.length}}
        </v-list-item-icon>

        <v-list-item-icon class="ml-5">
            <v-icon  color="primary">mdi-file</v-icon> {{nrOfFiles}}
        </v-list-item-icon>

        <v-list-item-icon class="ml-5" v-if="item.type != 'final'">
            <v-icon  color="error" v-if="item.rate == 'bad'">mdi-thumb-down</v-icon>
            <v-icon  color="warning" v-if="item.rate == 'normal'">mdi-thumbs-up-down</v-icon>
            <v-icon  color="success" v-if="item.rate == 'good'">mdi-thumb-up</v-icon>
        </v-list-item-icon>

    </v-list-item>     
</template>

<script>
export default {
    props:['item','last'],
    methods:{
        loadDelivery(){            
            this.$store.commit('order/delivery/TOGGLE_OPEN_MODAL');
            this.$store.commit('order/delivery/CLEAR_DELIVERY');
            this.$store.commit('order/delivery/SET_DELIVERY',this.item);
            this.$store.dispatch('order/delivery/comments/get');
        }
    },  
    computed:{
        nrOfFiles(){
            if(this.item.order_delivery_files)
                return this.item.order_delivery_files.length;
        }
    },    
}
</script>