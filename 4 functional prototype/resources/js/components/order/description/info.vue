<template>
    <card toggle >
        <v-card-subtitle>Project informatie
            <span class="float-right mt-2">
                <v-icon>mdi-{{order.type}}</v-icon>&nbsp; {{order.type}} opdracht
              </span>
        </v-card-subtitle>
        <v-card-title>
              {{order.title}}             
        </v-card-title>
        <v-card-text v-if="tags.length">
                <v-chip class="mr-3 mb-3" :key="key" v-for="(item,key) in tags" >#{{item.text}}</v-chip>
        </v-card-text>
        <v-card-text style="max-height:400px; overflow-y:auto;" >
            {{order.description}}
        </v-card-text>       
    </card>  
</template>

<script>
import {mapState} from 'vuex';

export default {
    computed:{
        ...mapState({
            order: state => state.order.data,
            tags : state => state.order.tags.list
        })
    },
    data(){return{
        description_show:true,
    }}
}
</script>

