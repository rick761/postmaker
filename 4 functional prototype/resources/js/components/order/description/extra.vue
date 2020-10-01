<template>
    <card v-if="descriptions.length" toggle>
        <v-card-subtitle>
            Extra informatie
            <explain>Deze "exta" opdracht informatie kan belangrijk zijn bij het uitvoeren van de opdracht </explain>
        </v-card-subtitle>       
            
        <v-list-item two-line v-for="(description,key) in descriptions" :key="key">

             <v-list-item-icon v-if="description.title != '' && description.text != ''" >
                <v-icon>mdi-music-note-whole</v-icon>
            </v-list-item-icon>

            <v-list-item-content v-if="description.title != '' && description.text != ''" >
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