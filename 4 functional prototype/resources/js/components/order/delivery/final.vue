<template>
<div>

    <modal width="700" v-model="delivery_modal_toggler" transition="dialog-bottom-transition" title="Eind oplevering ">
       
        <v-form   
            ref="form"
            v-model="valid"
            lazy-validation
        >   
            
            <v-alert type="warning" dense>
                Let op, dit is de eindoplevering!
            </v-alert>
          
            <v-file-input 
            name="deliveryFile"
            :rules="[
                v => !!v || 'Kies een bestand om op te leveren!',
                v => (v && v.length > 0) || 'Kies een bestand om op te leveren!'
            ]"
             v-model="files" multiple label="Bestanden"></v-file-input> 

                <v-chip 
                    @click:close="$store.commit('order/delivery/DEL_DELIVERY_FILE',key)" 
                    close 
                    class="mb-1 mr-1"
                    v-for="(item,key) in files" 
                    :key="key+item"
                >
                    <v-icon>mdi-file</v-icon> &nbsp; {{item.name}}
            </v-chip>

            <v-file-input 
            name="final-delivery-invoice"            
            v-model="invoice"  label="Factuur"></v-file-input>                    

            <v-checkbox 
                v-model="checkbox" 
                :label="`Ik ben eigenaar van de bestanden en bij deze draag ik ze over.`"
                :rules="[v => !!v || 'Vink aan om door te kunnen gaan!']"
            ></v-checkbox>
             
         </v-form>
        <template slot="actions">
            
            <v-spacer></v-spacer>
            <v-badge 
                overlap 
                bordered 
                color="error"
                icon="mdi-check"
                v-if="!confirmToggle"
            >
                <v-btn @click="preDeliver"  class="success final-delivery-btn"><v-icon>mdi-lock</v-icon> &nbsp; Opleveren </v-btn>
            </v-badge>         

            <v-badge 
                overlap                 
                bordered 
                color="error"
                icon="mdi-check-all"
                v-if="confirmToggle" 
            >
                <v-btn @click="deliver" class="success final-delivery-btn-confirm"><v-icon>mdi-lock-open</v-icon> &nbsp; bevestigen </v-btn>
            </v-badge>
            
            &nbsp;
        </template>
        
    </modal>
   
    <!--/MODAL-->
    </div>
</template>

<script>
import {mapState} from 'vuex'
export default {    
    data(){return{
        valid:true,        
        confirmToggle: false,
        checkbox:false,
        checkbox2:false
    }},
    computed:{
        ...mapState({
            delivery_modal : state => state.order.delivery.final,
            delivery: state => state.order.delivery.data,
            order: state => state.order.data,
        }),

        files:{
             get(){
                return this.delivery.files;
            },
            set(value){
                this.$store.commit('order/delivery/ADD_DELIVERY_FILES',value);                
            }
        },

        invoice:{
            get(){
                return this.delivery.invoice;
            },
            set(value){                
                this.$store.commit('order/delivery/SET_DELIVERY_INVOICE',value);                
            }
        },

        delivery_modal_toggler : {
            get(){ return this.delivery_modal; },
            set(value){               
                this.$store.commit('order/delivery/SET_FINAL_MODAL',value)
            }
        }
    },
    methods:{

        preDeliver(){            
            if(this.$refs.form.validate()){
                this.confirmToggle = !this.confirmToggle;
            }
        },

        deliver(){
            if(this.$refs.form.validate()){
                this.confirmToggle = !this.confirmToggle;
                this.$store.dispatch('order/delivery/createFinal');                
            }
        }

    } 
}
</script>