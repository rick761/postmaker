<template>
    <card>
        <v-card-subtitle>
            Afspraak 
            <explain>De aanvraag is geaccepteerd voor het onderstaande bedrag.</explain>
        </v-card-subtitle>

        <v-list>
            <v-list-item v-for="(item,key) in acceptedRequest" :key="key" >                   
                <v-list-item-content>                    
                    <v-list-item-title v-if="item" >
                        <span v-if=" item.status == 'accepted' " class="success--text">  Geaccepteerd </span>                        
                        <v-spacer />                         
                    </v-list-item-title>
                    <v-list-item-subtitle style="white-space: initial !important;" class="mb-2" >
                        <span  class='text--primary'>Deze opdracht is geaccepteerd voor een bedrag van {{item.payment}} euro</span>                 
                    </v-list-item-subtitle>   

                </v-list-item-content>
               
            </v-list-item>
        </v-list>
    </card>
</template>

<script>
import {mapState} from 'vuex';

export default {
    data(){ return {
        acceptModal:false
    } },
    computed:{
        ...mapState({
            requests: state => state.order.requests.list,
            order: state => state.order.data
        }),       
        acceptedRequest(){
            if(this.requests.length)
                return this.requests.filter(item => item.status == 'accepted');
        },
    },
    created(){
        
    }
}
</script>