<template>
    <card>
        <v-card-title>
            <v-icon>mdi-{{order.type}}</v-icon> &nbsp; {{order.title}}
        </v-card-title>
        <v-card-text>
                <v-chip class="mr-3 mb-3" :key="key" v-for="(item,key) in tags" >#{{item.text}}</v-chip>
        </v-card-text>
        <v-card-text style="max-height:400px; overflow-y:auto;" :class="{'description_hide': !description_show }">
            {{order.description}}
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn icon v-if="description_show" @click="description_show = !description_show"><v-icon>mdi-chevron-up</v-icon></v-btn>
            <v-btn icon v-if="!description_show"  @click="description_show = !description_show"><v-icon>mdi-chevron-down</v-icon></v-btn>
        </v-card-actions>
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
        height:50px;overflow:hidden;
    }
</style>