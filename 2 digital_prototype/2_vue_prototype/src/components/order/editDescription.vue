<template>
    <v-row>
        <v-col cols="12">
            <v-card flat>
                <v-card-title>Opdracht </v-card-title>
                <v-card-subtitle>en opdrachtomschrijving</v-card-subtitle>
                <v-card-text>
                    
                     <v-col cols="12">
                        <v-text-field
                            v-model.lazy="title"
                            label="Naam"
                            placeholder="Titel"
                            outlined
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12">
                        <v-textarea
                            v-model.lazy="descr"
                            outlined
                            name="input-7-4"
                            label="Omschrijving"                           
                        ></v-textarea>
                    </v-col>

                </v-card-text>
            </v-card>
        </v-col>

    </v-row>
</template>

<script>
import {mapState} from 'vuex'

export default {
    props:[],
    components:{        
                
    },
    computed:{
        ...mapState({  
            order : state => state.order_page.order,            
            loader : state => state.loader
        }),
        title: {
            get () {return this.$store.state.order_page.order.title},
            set (value) {
                this.$store.dispatch('order_page/order/set', {title : value})
                this.$store.dispatch('order_page/order/save', {title : value})
            }
        },
        descr: {
            get () {return this.$store.state.order_page.order.description},
            set (value) {
                this.$store.dispatch('order_page/order/set', {description : value})
                this.$store.dispatch('order_page/order/save', {description : value})
            }
        },
    } 
}

</script>

<style scoped>

</style>