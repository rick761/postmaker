<template>
    <v-form ref="form" v-model="valid">  
        <v-row> 
            <v-col cols="6">                      
            <card>
                <v-card-subtitle>Gegevens</v-card-subtitle>
                <v-card-text>
                    <v-text-field  
                        class="mb-3"   
                        :rules="[reqRule,least10]"
                        v-model="title"
                        label="Naam"                        
                        required
                    ></v-text-field>
                    
                    <v-textarea solo
                        name="input-7-1"
                        label="Omschrijving"
                        v-model="description"
                        :rules="[reqRule]"
                        value=""
                        hint="Vul hier de omschrijving in."
                    ></v-textarea>
                    
                    
                    <v-slider
                        v-model="payment"
                        class="align-center"
                        :max="payment+100"
                        min="0"                        
                        :thumb-size="24"
                        thumb-label
                        hide-details
                    >
                        <template v-slot:prepend>
                            <v-text-field
                                required
                                v-model="payment"
                                label="Euro vergoeding"
                                class="mt-0 pt-0"                                
                                type="number"
                                style="width: 60px"
                            ></v-text-field>
                        </template>
                    </v-slider>               

                    

                    <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >

                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="deliver"
                                label="Project moet klaar zijn op"
                                append-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"                                
                            ></v-text-field>
                        </template>

                        <v-date-picker v-model="deliver" @input="menu2 = false"></v-date-picker>

                    </v-menu>

                </v-card-text>           
            </card>

            <create-order-descriptions-component />

            </v-col>
            <v-col cols=6>

                <card outlined class="mb-5">
                    <v-card-subtitle>Acties</v-card-subtitle>    

                    <!--CREATION DATE-->
                        <v-card-text v-if="inCreation">
                            Aangemaakt op {{ `${new Date().getDate()}-${new Date().getMonth()}-${new Date().getUTCFullYear()}` }}
                        </v-card-text>

                        <v-card-text v-if="!inCreation">
                            Aangemaakt op {{ order.created_at }}
                        </v-card-text>
                    <!---->

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <!--save and create button-->
                            <v-btn v-if="inCreation" color="primary" @click="create()" >                            
                                <v-icon >mdi-content-save</v-icon> 
                                &nbsp; Aanmaken en Opslaan
                            </v-btn>                        
                        <!---->

                        <!--save button  -->
                            <v-btn v-if="!inCreation" color="primary" @click="update()" >                            
                                <v-icon >mdi-content-save</v-icon> 
                                &nbsp; Opslaan
                            </v-btn>                        
                        <!---->

                        <!--publish button and modal-->
                            <v-btn v-if="!inCreation" class="success" @click="publishModalCheck()" ><v-icon>mdi-file-send-outline</v-icon> &nbsp; Publiceer </v-btn>      
                            
                            <modal v-model="publishModal" width=500 title="Weet u het zeker?">
                                De opdracht wordt hiermee publiekelijk gezet. <br>
                                Dan kan hij door alle postmakers worden gelezen en aangevraagd.

                                <template slot="actions">
                                    <v-spacer></v-spacer>                                    
                                    <v-btn class="success" @click="publish()"> <v-icon>mdi-file-send-outline</v-icon> &nbsp; Ja, Publiceer</v-btn>
                                    <v-btn @click="publishModal = !publishModal" class="error"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren</v-btn>
                                </template>

                            </modal>
                        <!---->

                    </v-card-actions>
                </card>


                <card>
                    <v-card-subtitle>
                        Type & tags

                    <v-tooltip color="primary" top>
                        <template v-slot:activator="{ on, attrs }">                    
                            <v-btn  icon v-bind="attrs" v-on="on" class="float-right">
                                <v-icon color="accent lighten-1">mdi-comment-question-outline</v-icon>
                            </v-btn>
                        </template>
                        <span>
                            Door tags toe te voegen kunnen postmaker de opdracht beter vinden.
                        </span>
                    </v-tooltip>

                    </v-card-subtitle>
                    <v-card-text>
                        
                        <!--TYPES-->
                            <v-select
                                v-model="type"
                                :items="iconList"
                                item-text="display"
                                item-value="value"
                                :rules="[reqRule]"
                                label="Type"
                                :append-icon="'mdi-'+icon"
                                required
                            ></v-select>
                        <!---->

                        <create-tags-component />                        

                    </v-card-text>
                </card>

               <create-files-component />
                
            </v-col>
        </v-row>
    </v-form>
</template>


<script>
import { mapState } from 'vuex';
export default {
    computed:{        
        ...mapState({                
            order: state => state.order.data,
        }),
        title: {
            get () { return this.order.title },
            set (value) { this.$store.commit( 'order/SET_TITLE', value );  }
        },
        description: {
            get () { return this.order.description },
            set (value) { this.$store.commit( 'order/SET_DESCRIPTION', value );  }
        },
        payment: {
            get () { return this.order.payment },
            set (value) { this.$store.commit( 'order/SET_PAYMENT', value );  }
        },
        deliver: {
            get () { return this.order.deliver },
            set (value) { this.$store.commit( 'order/SET_DELIVER', value ); }
        },        
        type: {
            get () {  return this.order.type },
            set (value) { this.$store.commit( 'order/SET_TYPE', value ); }
        },
        inCreation(){
            return this.$route.path == "/requester/order/new";
        },
    },   

    data: () => ({

        publishModal: false,
        valid:true,        
        reqRule: v => !!v || 'Is benodigd.',
        least10: v => (v && v.length >= 10) || 'Moet langer zijn dan 10 karakters',   
        extraDescription:[''],
        slider:100,
        // date: new Date().toISOString().substr(0, 10),
        menu: false,    
        menu2: false, 
        files: [],
        icon:'',  
        iconList:[
            { value:'camera', display: 'Camera' },
            { value:'image', display: 'Afbeelding' },
            { value:'draw', display: 'Ontwerpen' },
            { value:'film', display: 'Film' },            
        ],     

    }),

    methods:{      

        create(){            
            if(this.$refs.form.validate()){   
                this.$store.dispatch('order/create');
            }
        },

        update(){
            if(this.$refs.form.validate()){   
                this.$store.dispatch('order/update');
            }
        },

        publish(){
            if(this.$refs.form.validate()){  
                this.$store.dispatch('order/publish');
            }
        },       

        publishModalCheck(){
            if(this.$refs.form.validate()){  
                this.publishModal = !this.publishModal;
            }
        }

    },  
    created(){      
        if(this.$route.path != "/requester/order/new"){ // Not in creation                   
            this.$store.dispatch('order/get',this.$route.params.orderId);            
        }
        if(this.$route.path == "/requester/order/new"){ // In creation  
            this.$store.commit('order/CLEAR_ORDER');                
            this.$store.commit('order/descriptions/SET_ORDER_DESCRIPTION',[]);     
            this.$store.commit('order/files/CLEAR_ORDER_FILES');        
            this.$store.commit('order/tags/CLEAR_ORDER_TAGS');                
        }
    }   
}
</script>