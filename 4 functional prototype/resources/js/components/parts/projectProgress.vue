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
        
       
    
        <v-stepper  :value="getStateNr">
            <v-stepper-header>
                <v-stepper-step  :complete="getStateNr > 1"  step="1" > 
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">                        
                            <v-icon v-bind="attrs" v-on="on" color="accent">mdi-creation</v-icon> <small>Nieuw</small>
                        </template>            
                        <span>Aanmaken, het project schrijven en vorm geven. Daarna publiceren.</span>
                    </v-tooltip>
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step  :complete="getStateNr > 2" step="2">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">                        
                            <v-icon v-bind="attrs" v-on="on"  color="accent">mdi-message-alert-outline</v-icon> <small>Aanvragen &<br> accepteren</small>
                        </template>            
                        <span>Contact maken, wachten op postmakers die zich aansluiten. Vind of ben de beste postmaker voor een opdracht. </span>
                    </v-tooltip>
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step  :complete="getStateNr > 3" step="3">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">                        
                            <v-icon v-bind="attrs" v-on="on" color="accent">mdi-draw</v-icon> <small>Maak &<br> verbeter</small>                        
                        </template>            
                        <span>Test opleveringen, sparren tussen postmaker en aanvrager om tot de beste resultaten te komen.</span>
                    </v-tooltip>
                </v-stepper-step> 

                    <v-divider></v-divider>
                <v-stepper-step :complete="getStateNr > 4" step="4">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">                        
                            <v-icon v-bind="attrs" v-on="on" color="accent">mdi-truck-delivery</v-icon> <small>Opleveren <br> & overdragen</small>                        
                        </template>            
                        <span>Finale oplevering, regel de overdracht en financiele zaken.</span>
                    </v-tooltip>
                </v-stepper-step>   
                <v-divider></v-divider>
                <v-stepper-step  step="5">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">                        
                            <v-icon v-bind="attrs" v-on="on" color="accent">mdi-stop-circle</v-icon> <small>Eind</small>
                        </template>            
                        <span>Project is afgerond, goed afgesloten of eerder al gestopt!</span>
                    </v-tooltip>
                    
                </v-stepper-step>   
            </v-stepper-header>                       
        </v-stepper>

    </card>
</template>

<script>
import { mapState } from 'vuex';

export default {
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