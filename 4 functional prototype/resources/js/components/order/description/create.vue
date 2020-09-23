<template>

        <card>                  

            <v-card-subtitle>

                Aanvullende opdracht specifieke informatie                
                
                <explain>                   
                    Deze informatie is voor de postmaker van de opdracht. Het wordt ook alleen aan de postmaker weergegeven.
                </explain>

            </v-card-subtitle>

            <v-card-text>
                <v-layout 
                    v-for="(description,i) in descriptions"  
                    :key="i"
                >
                    
                    <v-flex style="width:100%" p>

                        <v-text-field  
                            :value="description.title" 
                            @input="e=>updateDescription(i,'title',e)"                        
                            :placeholder="`Titel (${i+1})`" 
                        />
                        
                        <v-textarea  
                            solo                            
                            :value="description.text" 
                            @input="e=>updateDescription(i,'text',e)"                        
                            :placeholder="`Omschrijving (${i+1})`"  
                        />

                    </v-flex>
                    <v-flex class="pt-3 text-right">

                        <v-btn  
                            @click="$store.commit('order/descriptions/DEL_ORDER_DESCRIPTION',i)"
                            text 
                            class="error ml-3"
                         > 
                            <v-icon>mdi-minus</v-icon>
                         </v-btn>
                    </v-flex>      

                </v-layout>
            </v-card-text>    
           

            <v-card-actions>
                <v-btn 
                    class="success mb-6" 
                    @click="$store.commit('order/descriptions/ADD_ORDER_DESCRIPTION')"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>   
            </v-card-actions>                       
        </card>        
</template>

<script>
import { mapState } from 'vuex';
export default {
    computed:{        
        ...mapState({                
            descriptions: state => state.order.descriptions.list,
        }),
    },
    methods:{
        updateDescription(row,field,val){
            this.$store.commit('order/descriptions/UPDATE_FIELD_ORDER_DESCRIPTION',[row,field,val]);
            //console.log(i,e);
        }
    }
}
</script>