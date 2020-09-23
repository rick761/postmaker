<template>
    <card :class="{'description_hide': !description_show }" >
        <v-card-subtitle>Project informatie
            <span class="float-right">
                <v-icon>mdi-{{order.type}}</v-icon>&nbsp; {{order.type}} opdracht
                <v-btn icon v-if="description_show" @click="description_show = !description_show"><v-icon>mdi-chevron-up</v-icon></v-btn>
                <v-btn icon v-if="!description_show"  @click="description_show = !description_show"><v-icon>mdi-chevron-down</v-icon></v-btn>
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


<style scoped>
    .description_hide{
        height: 65px !important;overflow:hidden;
    }
</style>