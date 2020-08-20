<template>
   
    <modal :fullscreen="true" v-model="delivery_modal_toggler" transition="dialog-bottom-transition" title="Oplevering">
        
        <v-container>
            <card>
                <v-card-title>
                    {{delivery.title}}
                    <v-spacer />
                    <v-icon color="error" v-if="delivery.rate == 'bad'">mdi-thumb-down</v-icon> 
                    <v-icon color="warning" v-if="delivery.rate == 'normal'">mdi-thumbs-up-down</v-icon> 
                    <v-icon color="success" v-if="delivery.rate == 'good'">mdi-thumb-up</v-icon> 
                </v-card-title>
                <v-card-subtitle>{{delivery.text}}</v-card-subtitle>
            </card>
           <v-row>
                <v-col>
                    <v-list>
                        <v-list-item v-for="(file,key) in delivery.order_delivery_files" :key="key">  
                             
                            <!-- <v-list-item-avatar>
                                <v-img src="https://cdn.vuetifyjs.com/images/lists/1.jpg"></v-img>
                            </v-list-item-avatar> -->

                            <v-list-item-icon v-if="file.is_invoice" class="pt-2" >
                                <v-icon class="accent--text" >mdi-account-cash-outline</v-icon> &nbsp;  FACTUUR                               
                            </v-list-item-icon>

                            <v-list-item-icon v-else >
                                <v-icon>mdi-music-note-whole</v-icon>                              
                            </v-list-item-icon>                            

                            {{file.url}}

                            &nbsp;                   

                            <v-spacer />

                            <v-list-item-icon >

                                <v-btn @click="preview(file.url)" color="secondary" >
                                    <v-icon >mdi-eye</v-icon>
                                </v-btn>

                                <v-btn :href="download(file.url)" download class="ml-1" color="secondary" >
                                    <v-icon >mdi-download</v-icon>
                                </v-btn>

                            </v-list-item-icon>

                        </v-list-item>
                    </v-list>            

                </v-col>
                <v-col>
                    <order-delivery-comments-component />
                </v-col>
            </v-row>            
        </v-container>       

        <template slot="actions">
            <v-container class="text-right" v-if="auth.type == 'requester'">                
                <v-btn @click="rate('bad')" class="error "> <v-icon>mdi-thumb-down</v-icon> </v-btn>
                <v-btn @click="rate('normal')"  class="warning ml-1"> <v-icon>mdi-thumbs-up-down</v-icon> </v-btn>
                <v-btn @click="rate('good')"  class="success ml-1"> <v-icon>mdi-thumb-up</v-icon> </v-btn>
            </v-container>
        </template>

    </modal>
    <!--/MODAL-->
    
</template>

<script>
import {mapState} from 'vuex'
export default {    
    computed:{
        ...mapState({
            delivery_modal : state => state.order.delivery.open,
            delivery:  state => state.order.delivery.data,
            order:  state => state.order.data,
            auth:  state => state.auth.user,         
        }),
        delivery_modal_toggler : {
            get(){ return this.delivery_modal; },
            set(value){               
                this.$store.commit('order/delivery/SET_OPEN_MODAL',value)
            }
        },
    },
    methods:{
        download(url){
           return './storage/'+this.order.postmaker.id+'/order_delivery/'+this.order.id+'/'+url;           
        },
        preview(url){
           this.$store.dispatch('image/preview','./storage/'+this.order.postmaker.id+'/order_delivery/'+this.order.id+'/'+url);
        },
        rate($type){
            this.$store.dispatch('order/delivery/rate',$type);
        }
    },

    
}
</script>