<template>
    <card class="pb-5">
        <v-card-subtitle class="d-none">
            Projectstatus
            <explain icon="mdi-timeline-help-outline"> 
               
                <i v-if=" order.state == 'open' " >
                    Het project is publiekelijk gesteld.
                </i>

                <i v-if=" order.state == 'progress' " >
                    Project is aangenomen door een postmaker.
                </i>

                <i  v-if=" order.state == 'final_delivered' " >
                    Eindoplevering is gedaan.
                </i>

                <i  v-if=" order.state == 'delivery_accepted' " >
                    Tijdelijke oplevering is geaccepteerd  .
                </i>

                <i  v-if=" order.state == 'quit_postmaker' " >
                    Postmaker wilt stoppen.
                </i>

                <i  v-if=" order.state == 'quit' " >
                    Opdracht is gestopt.
                </i>

                <i  v-if=" order.state == 'removed' " >
                    Opdracht is verwijderd
                </i>

                <i  v-if=" order.state == 'recieved_payment' " >
                    Betaling is ontvangen.
                </i>

                <i  v-if=" order.state == 'delivered' " >
                    Oplevering is geplaatst.
                </i>

                <i  v-if=" order.state == undefined " >
                    De opdracht is nog niet aangemaakt.
                </i>

            </explain>
        </v-card-subtitle>
        
        <div  
            v-if="currentMsg"          
            class="d-block position-absolute"
            style="z-index:999; width:100%; height:auto; bottom:0; margin-top: 20px; margin-bottom: -85px;"
        >   
            <card color="primary">
                <v-card-subtitle style="color:white" class="pa-5 ma-0 text-center">
                    
                        {{messages[currentMsg]}}
                    
                </v-card-subtitle>
            </card>
        </div>    

        <v-stepper  :value="getStateNr">            
            <v-stepper-header>
                <span @mouseover="show(1)" @mouseleave="clear" style="cursor:pointer" >
                    <v-stepper-step  :complete="getStateNr > 1"  step="1" >                                           
                        <v-icon color="accent">mdi-creation</v-icon> <small>Nieuw</small>                                                          
                    </v-stepper-step>                    
                </span>

                <v-divider></v-divider>
                <span @mouseover="show(2)" @mouseleave="clear"  style="cursor:pointer">
                    <v-stepper-step  :complete="getStateNr > 2" step="2">                                    
                            <v-icon  color="accent">mdi-message-alert-outline</v-icon> <small>Aanvragen &<br> accepteren</small>                   
                    </v-stepper-step>
                </span>

                <v-divider></v-divider>

                <span @mouseover="show(3)" @mouseleave="clear" style="cursor:pointer" >
                    <v-stepper-step  :complete="getStateNr > 3" step="3">                                          
                        <v-icon color="accent">mdi-draw</v-icon> <small>Maak &<br> verbeter</small>        
                    </v-stepper-step> 
                </span>

                <v-divider></v-divider>

                <span @mouseover="show(4)" @mouseleave="clear"  style="cursor:pointer">
                    <v-stepper-step :complete="getStateNr > 4" step="4">                                          
                        <v-icon color="accent">mdi-truck-delivery</v-icon> <small>Opleveren <br> & overdragen</small> 
                    </v-stepper-step>   
                </span>

                <v-divider></v-divider>
                <span @mouseover="show(5)" @mouseleave="clear"  style="cursor:pointer">
                    <v-stepper-step  step="5">                                          
                        <v-icon color="accent">mdi-stop-circle</v-icon> <small>Eind</small>      
                    </v-stepper-step>  
                </span>
            </v-stepper-header>                       
        </v-stepper>
        
    </card>
</template>

<script>
import { mapState } from 'vuex';

export default {
    data(){return{
        currentMsg : 0,
        messages: [
            'test',
            'Aanmaken, het project schrijven en vorm geven. Daarna publiceren.',
            'Contact maken, wachten op postmakers die zich aansluiten. Vind of ben de beste postmaker voor een opdracht.',
            'Test opleveringen, sparren tussen postmaker en aanvrager om tot de beste resultaten te komen.',
            'Finale oplevering, regel de overdracht en financiele zaken.',
            'Project is afgerond, goed afgesloten of eerder al gestopt!',            
        ]
    }},
    methods:{
        show(i){
            this.currentMsg = i;
        },
        clear(){
            this.currentMsg = 0;
        }
    },
    computed:{
        ...mapState({
            order: state => state.order.data,
            auth: state => state.auth.user
        }),

        getStateNr(){
            switch(this.order.state){
                case 'create':      
                return 1;              
                break;
                 case 'open':      
                 return 2;                
                break;
                 case 'progress':  
                 return 3;                    
                break;
                 case 'delivered':    
                 return 3;                 
                break;
                 case 'delivery_accepted':      
                 return 4;               
                break;
                 case 'final_delivered':  
                 return 4;                    
                break;
                 case 'recieved_payment':      
                 return 5;                
                break;
                 case 'quit_postmaker':    
                 return 5;                 
                break;
                 case 'quit':  
                 return 5;                   
                break;
                case 'removed':           
                return 5;          
                break;
                default : return 1;
            }
        }
    }
}
</script>


<style scoped>
    .v-stepper{
        box-shadow: none !important;
    }

</style>