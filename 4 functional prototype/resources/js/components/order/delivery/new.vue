<template>
<div>

    <modal width="700" v-model="delivery_modal_toggler" transition="dialog-bottom-transition" title="Voorbeeld oplevering ">
       
        <v-form   
            ref="form"
            v-model="valid"
            lazy-validation
        >   
            <v-text-field placeholder="Titel" v-model="title" :rules="[v => !!v || 'Vul een titel in!']" />
            <v-textarea rows="2" single-line solo placeholder="Vul een omschrijving in" v-model="text" :rules="[v => !!v || 'Vul een omschrijving in!']" />        
            <v-file-input 
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

            <v-checkbox 
                v-model="checkbox" 
                :label="`Ik ben eigenaar van de bestanden.`"
                :rules="[v => !!v || 'Vink aan om door te kunnen gaan!']"
            ></v-checkbox>

            <v-alert type="warning" outlined dense>
                Let op, dit is een indicatie. lever hier geen eindproduct op.
            </v-alert>

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
                <v-btn @click="preDeliver"  class="success"><v-icon>mdi-lock</v-icon> &nbsp; Opleveren </v-btn>
            </v-badge>         

            <v-badge 
                overlap                 
                bordered 
                color="error"
                icon="mdi-check-all"
                v-if="confirmToggle" 
            >
                <v-btn @click="deliver" class="success"><v-icon>mdi-lock-open</v-icon> &nbsp; bevestigen </v-btn>
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
        checkbox:false
    }},
    computed:{
        ...mapState({
            delivery_modal : state => state.order.delivery.new,
            delivery: state => state.order.delivery.data,
        }),

        title:{ 
            get(){
                return this.delivery.title;
            },
            set(value){
                this.$store.commit('order/delivery/UPDATE_FIELD_DELIVERY',['title', value]);
            }
        },

        text:{ 
            get(){
                return this.delivery.text;
            },
            set(value){
                this.$store.commit('order/delivery/UPDATE_FIELD_DELIVERY',['text', value]);
            }
        },

        files:{
             get(){
                return this.delivery.files;
            },
            set(value){
                this.$store.commit('order/delivery/ADD_DELIVERY_FILES',value);                
            }
        },

        delivery_modal_toggler : {
            get(){ return this.delivery_modal; },
            set(value){               
                this.$store.commit('order/delivery/SET_NEW_MODAL',value)
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
                this.$store.dispatch('order/delivery/create');
                this.$store.commit('order/delivery/SET_NEW_MODAL',false)
            }
        }
    } 
}
</script>