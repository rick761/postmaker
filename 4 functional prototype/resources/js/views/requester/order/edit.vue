<template>
    <v-form ref="form" v-model="valid">  
        <v-row> 
            <v-col cols="12" md="8">     

            <project-progress />    
            
            <card toggle>
                <v-card-subtitle>
                    Project gegevens
                    <explain> Deze gegevens worden publiekelijk getoond </explain>
                </v-card-subtitle>
                <v-card-text>

                    <v-text-field  
                        class="mb-3"   
                        :rules="[reqRule, least6, v => v.length <= 50 || 'Max 50 karakters']"
                        counter="50"
                        v-model="title"
                        label="De naam van het project"
                        hint="Via deze naam kan het project gevonden worden door postmakers."                        
                        required
                        name="name"
                    ></v-text-field>

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
                                label="Vergoeding"
                                class="mt-0 pt-0" 
                                name="payment"                               
                                type="number"
                                style="width: 100px"
                            ></v-text-field> 
                            <small class="mt-3 ml-1">€</small>
                        </template>
                    </v-slider>   

                    <v-row>
                        <v-col cols=12 lg=6>
                            <label class="v-label">Omschrijving</label>
                             <v-textarea solo
                                name="description"
                               
                                v-model="description"
                                :rules="[reqRule,v => v.length <= 2000 || 'Max 2000 karakters']"
                                counter="2000"
                                value=""
                                height="255"
                                hint="Schrijf hier alle publiekelijke informatie"
                            ></v-textarea>
                        </v-col>
                        <v-col cols=12 lg=6>    
                            <v-tooltip top>
                                <template v-slot:activator="{ on, attrs }">                                       
                                    <span v-bind="attrs" v-on="on">
                                        <label class="v-label d-block">Oplever datum</label>
                                        <v-date-picker  scrollable no-title :min="new Date().toISOString().substr(0, 10)" v-model="deliver"></v-date-picker>                            
                                    </span>
                                </template>
                                <span>Deadline, wanneer moet het af? </span>
                            </v-tooltip>                            
                        </v-col>
                    </v-row>
                   
                          
                    <!-- datepicker -->
                    <!-- <create-order-datepicker-component/> -->

                </v-card-text>           
            </card>

            <create-order-descriptions-component />

            </v-col>
            <v-col cols="12" md="4">

                <card outlined class="mb-5" >
                    <v-card-subtitle>Acties</v-card-subtitle>    

                    <!--CREATION DATE-->
                        <v-card-text v-if="inCreation">
                            Aangemaakt op {{ `${new Date().getDate()}-${new Date().getMonth()}-${new Date().getUTCFullYear()}` }}
                        </v-card-text>

                        <v-card-text v-if="!inCreation">
                            Aangemaakt op {{ order.created_at }}
                        </v-card-text>
                    <!---->

                    <v-card-text style="display:block;">
                        <v-spacer></v-spacer>

                        <!--save and create button-->
                            <v-btn class="mr-1 mb-1 create-project" block v-if="inCreation" color="primary" @click="create()" >                            
                                <v-icon >mdi-content-save</v-icon> 
                                &nbsp; Aanmaken en Opslaan
                            </v-btn>                        
                        <!---->

                        <!--save button  -->
                            <v-btn class="mr-1 mb-1" v-if="!inCreation" block color="primary" @click="update()" >                            
                                <v-icon >mdi-content-save</v-icon> 
                                &nbsp; Opslaan
                            </v-btn>                        
                        <!---->

                        <!--publish button and modal-->
                            <v-btn v-if="!inCreation" block class="mr-1 mb-1 error" @click="removeModalCheck()" ><v-icon>mdi-trash-can-outline</v-icon> &nbsp; Verwijder </v-btn>      

                            <v-btn  v-if="!inCreation" block class="mr-1 mb-1 success publish-order" @click="publishModalCheck()" ><v-icon>mdi-file-send-outline</v-icon> &nbsp; Publiceer </v-btn>      
                            
                            <modal v-model="publishModal" width=500 title="Weet u het zeker?">
                                De opdracht wordt hiermee publiekelijk gezet. <br>
                                Dan kan hij door alle postmakers worden gelezen en aangevraagd.

                                <template slot="actions">
                                    <v-spacer></v-spacer>                                    
                                    <v-btn class="success publish-order-confirm" @click="publish()"> <v-icon>mdi-file-send-outline</v-icon> &nbsp; Ja, Publiceer</v-btn>
                                    <v-btn @click="publishModal = !publishModal" class="error"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren</v-btn>
                                </template>

                            </modal>
                        <!---->

                    </v-card-text>
                </card>


                <card toggle>
                    <v-card-subtitle>
                        Vindbaarheid instellen

                        <explain> 
                            * Het type project geeft aan wat voor opdracht het is. <br>
                            * Door hashtags toe te voegen kunnen postmakers de opdracht beter vinden.
                        </explain>

                    </v-card-subtitle>
                    <v-card-text>
                        
                        <!--TYPES-->
                            <v-select
                                v-model="type"
                                :items="iconList"
                                item-text="display"
                                item-value="value"
                                :rules="[reqRule]"
                                label="Wat voor project is het"                                
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
            get () { return this.order.title != null ? this.order.title : ""  },
            set (value) { this.$store.commit( 'order/SET_TITLE', value );  }
        },
        description: {
            get () { return this.order.description!= null ? this.order.description : ""  },
            set (value) { this.$store.commit( 'order/SET_DESCRIPTION', value );  }
        },
        payment: {
            get () { return this.order.payment!= null ? this.order.payment : "" },
            set (value) { this.$store.commit( 'order/SET_PAYMENT', value );  }
        },
        deliver: {
            get () {     
                if(this.order.deliver){
                    const [unknown1,month,unknown2] = this.order.deliver.split('-');
                    var year,day;
                    if(unknown1.length == 4){
                        year=unknown1;
                        day=unknown2;
                    }
                    if(unknown2.length == 4){
                        year=unknown2;
                        day=unknown1;
                    }
                    return  `${year}-${month}-${day}`
                }
                          
                               
            },
            set (value) {             
                
                // const [unknown1,month,unknown2] = value.split('-');
                // var year,day;

                // if(unknown1.length == 4){
                //     year=unknown1;
                //     day=unknown2;
                // }
                // if(unknown2.length == 4){
                //     year=unknown2;
                //     day=unknown1;
                // }
                
                // this.$store.commit( 'order/SET_DELIVER', `${day}-${month}-${year}` );
                 this.$store.commit( 'order/SET_DELIVER', value );
            }
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
        reqRule: v => !!v || 'Dit veld is verplicht.',
        least6: v => (v && v.length >= 6) || 'Moet meer dan 6 karakters hebben!',   
        extraDescription:[''],
        slider:100,
        date: new Date().toISOString().substr(0, 10),
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
        },

        removeModalCheck(){           
            this.$store.dispatch('modal/confirmAction',{
                actions: [
                    {                        
                        action: 'api/post',
                        parameter : { 
                            url: 'order/update',
                            data: {
                                id: this.order.id, 
                                state : 'removed'
                            }
                        }         
                    },
                    {
                        action: 'order/get',
                        parameter: this.order.id
                    }
                ]
            })
        }

    },  
    created(){      
        if(this.$route.path != "/requester/order/new"){ // Not in creation                   
            this.$store.dispatch('order/get',this.$route.params.orderId);            
        }
        if(this.$route.path == "/requester/order/new"){ // In creation  
            this.$store.commit('order/CLEAR_ORDER');                
            this.$store.commit('order/descriptions/SET_ORDER_DESCRIPTION',[{}]);     
            this.$store.commit('order/files/CLEAR_ORDER_FILES');        
            this.$store.commit('order/tags/CLEAR_ORDER_TAGS');                
        }
    }   
}
</script>