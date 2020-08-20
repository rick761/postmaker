<template>
    <card v-if="descriptions.length">
        <v-card-subtitle>Extra toelichting</v-card-subtitle>       
            
        <v-list-item two-line v-for="(description,key) in descriptions" :key="key">
             <v-list-item-icon>
                <v-icon>mdi-music-note-whole</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title>{{description.title}}</v-list-item-title>
                <v-list-item-subtitle>{{description.text}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </card>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        computed:{
            ...mapState({
                descriptions: state => state.order.descriptions.list
            })
        }
        
    }
</script>