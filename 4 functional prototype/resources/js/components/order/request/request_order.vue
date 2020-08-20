<template>
    <v-form 
        ref="form"
        v-model="valid"
    >
    <v-card outlined class="mb-0"  >           
            
            <v-card-subtitle>
                Aanvragen 
            </v-card-subtitle>   

            <v-card-text >

                <v-textarea solo v-model="text" />

                Andere prijs                

                <v-slider
                    v-model="payment"
                    class="align-center"
                    :max="payment+100"
                    min="0"                        
                    :thumb-size="24"
                    thumb-label        
                >

                    <template v-slot:prepend>
                        <v-text-field
                            :rules="[v =>  !!v.toString() || 'Niet leeg', ]"
                            required
                            v-model="payment"  
                            persistent-hint                       
                            hint="Euro"
                            class="mt-0 pt-0"                                
                            type="number"
                            style="width: 60px"                            
                        ></v-text-field>
                    </template>

                </v-slider> 

                <v-alert dense text class="mt-3"  v-if="request.status == 'open'" type="success">
                        Aanvraag is geplaatst
                </v-alert>

                <v-alert dense text class="mt-3"  v-if="request.status == 'withrawn'" type="warning">
                        Aanvraag is ingetrokken
                </v-alert>

                <v-alert dense text class="mt-3"  v-if="request.status == 'denied'" type="error">
                        Aanvraag is afgewezen
                </v-alert>

            </v-card-text>

            <v-card-actions>

                <v-spacer></v-spacer>

                <v-btn class="success" v-if="!request_exists"  @click="requestOrder" ><v-icon>mdi-alert-octagram-outline</v-icon> &nbsp; Aanvragen</v-btn>
                <v-btn class="success" v-else @click="requestOrder" ><v-icon>mdi-alert-octagram-outline</v-icon> &nbsp; Opnieuw aanvragen</v-btn>
                <v-btn class="error"   v-if="request_exists && !is_withrawn"  @click="withrawRequest"><v-icon>mdi-alert-octagram-outline</v-icon> &nbsp; Intrekken</v-btn>

            </v-card-actions>

        </v-card>
    </v-form>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data(){return{
        valid:true
    }},
    methods:{
        requestOrder(){           
            if(this.$refs.form.validate()){
                this.$store.dispatch('order/requests/requestOrder');   
            }
        },
        withrawRequest(){            
           this.$store.dispatch('order/requests/withrawRequest');
        },
    },
    computed:{
        ...mapState({
            requests: state => state.order.requests.list, 
            request: state => state.order.requests.data,          
            order: state => state.order.data         
        }),
        text:{
            get(){
                if(this.request)
                    return this.request.text;
            },
            set(value){
                this.$store.commit('order/requests/UPDATE_FIELD_APPLY_ORDER_REQUESTS', ['text', value]);
            }
        },
        payment:{
            get(){     
                if(this.request)
                    return this.request.payment;
            },
            set(value){
                this.$store.commit('order/requests/UPDATE_FIELD_APPLY_ORDER_REQUESTS', ['payment', value]);
            }
        },
        request_exists () {
            return (this.request.id != undefined);
        },
        is_withrawn () {
            return (this.request.status == 'withrawn');
        }
    },    
}
</script>