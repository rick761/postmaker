<template>
    <card v-if="deliverys && deliverys.length" >
        <v-card-subtitle>
            Opleveringen 
            
        </v-card-subtitle>
        <v-list style="max-height:400px; overflow-y:scroll;">
            <order-delivery-preview-component v-for="(item,key) in reversed_deliverys" :key="key" :last="(key == 0)"  :item="item" />
        </v-list>

    </card>    
</template>

<script>
import {mapState} from 'vuex';

export default {
    computed:{
        ...mapState({
            deliverys: state => state.order.delivery.list
        }),
        reversed_deliverys(){
            return  this.deliverys.slice().reverse();
        }
    },

    data: () => ({
        model: null,
    }),

    methods:{
        upload(){            
            this.load = true;
            setTimeout( () => {
                this.load = false;                
            },1000)
        },
        openModal(i){
            this.modal[i]=1
            this.$forceUpdate();            
        }
    },
}
</script>