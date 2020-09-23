<template>
    <div>
        <!--TAGS-->
            <v-text-field v-model="tagValue" label="Hashtags toevoegen" @blur="newTag" v-on:keyup.enter="newTag" v-on:keyup.space="newTag" ></v-text-field>  
            <!-- <div>
                <v-chip class="mr-3 mb-3" :key="key" v-for="(item,key) in tagList" close @click:close="delTag(key)" >#{{item}}</v-chip>
            </div> -->

            <!-- {{tags}} -->
            <v-chip class="mr-3 mb-3" :key="key" v-for="(item,key) in tags" @click:close="delTag(key)" close >#{{item.text}}</v-chip>

        <!---->
    </div>
</template>

<script>
import {mapState} from 'vuex';
export default {
    data(){return{
        tagList:[],
        tagValue:''
    }},
    computed:{
        ...mapState({
            tags : state => state.order.tags.list
        })
    },
    methods:{
         newTag(){
            if(this.tagValue == '') return;           
            if(this.tags.length > 4){ this.tagValue = ''; return};
            this.$store.commit('order/tags/ADD_ORDER_TAG', {text: this.tagValue} );            
            this.tagValue = '';
        },

        delTag(i){
            this.$store.commit('order/tags/DEL_ORDER_TAG', i );            
        },
    }
    
}
</script>