<template>
    <v-row>
        <v-col cols="12">
            <v-card flat>
                <v-card-title>Omschrijving</v-card-title>
                <v-card-subtitle>Aanvullende</v-card-subtitle>
                <v-card-text>
                    
                     <v-expansion-panels flat class="mb-6">
                            <v-expansion-panel v-for="(item,index) in comments.list" :key="index" >
                                <v-expansion-panel-header expand-icon="mdi-menu-down">{{item.title}}<span v-if="!item.title">Nieuwe omschrijving</span></v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-text-field class="mt-2"  dense                              
                                        label="Naam"
                                        placeholder="Titel"
                                        outlined
                                        :value="item.title" @blur="updateField($event.target.value, item, 'title')"
                                    ></v-text-field>                    
                                    <v-textarea dense
                                        v-model.lazy="item.descr"
                                        outlined                        
                                        label="Omschrijving"
                                        :value="item.text"  @blur="updateField($event.target.value, item, 'text')"                           
                                    ></v-textarea>
                                    <v-btn @click="del(item.id)" color="primary" depressed>
                                        <v-icon left>mdi-delete</v-icon>
                                        Delete
                                    </v-btn>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                    </v-expansion-panels>

                        
                
                </v-card-text>
                <v-card-actions>
                     <v-btn @click="add"  color="orange" text >
                        Toevoegen
                    </v-btn>
                </v-card-actions>
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
            comments : state => state.order_page.order.comments,           
            loader : state => state.loader
        })
    },

    methods:{        
        updateField(value, item, field){                                  
            this.$store.dispatch('order_page/order/comments/update', { item : item, value:value, field:field })            
        },
        add(){
            this.$store.dispatch('order_page/order/comments/new',);
        },
        del(index){
            this.$store.dispatch('order_page/order/comments/delete',index);
        },
    } 
}

</script>

<style scoped>

</style>