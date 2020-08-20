<template>
    <card>
        <v-card-subtitle>
            Aanvraag

                <v-tooltip color="primary" top>

                    <template v-slot:activator="{ on, attrs }">                    
                        <v-btn icon v-bind="attrs" v-on="on" class="float-right">
                            <v-icon color="accent lighten-1">mdi-comment-question-outline</v-icon>
                        </v-btn>
                    </template>

                    <span>
                        De aanvraag is geaccepteerd door een postmaker voor het onderstaande bedrag.
                    </span>

                </v-tooltip>

        </v-card-subtitle>
        <v-list>
            <v-list-item v-for="(item,key) in acceptedRequest" :key="key" >   
                <v-list-item-content>
                    <v-list-item-title v-if="item" >
                        <span v-if=" item.status == 'accepted' " class="success--text">  Geaccepteerd </span> 
                        <span v-if=" item.status == 'denied' " class="error--text">  Geweigerd </span> 
                        <span v-if=" item.status == 'withrawn' " class="error--text">  Ingetrokken </span>    
                        <v-spacer />                         
                    </v-list-item-title>
                    <v-list-item-subtitle class="mb-1" >
                        <span class='text--primary'>Bied {{item.payment}} euro</span>                 
                    </v-list-item-subtitle>             
                    <i v-if="item.text" >{{item.text}}</i>
                    <i v-else> Heeft geen motivatie aangegeven</i>                
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
            requests: state => state.order.requests.list
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