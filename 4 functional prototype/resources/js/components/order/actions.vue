<template>
    <card >
        <v-card-subtitle>Uit te voeren acties</v-card-subtitle>
        <v-card-text style="overflow-x:auto">

            <!--
                Actions:
                canEdit()
                canRemove()               
                canDeliver()
                canQuitPostmaker()
                canQuit()                
                canDeliveryAccept()
                canFinalDeliver()
                canRecievePayment()
                canContinuePostmaker()
                canImprove()

                 canOpen() // used in creation mode.. not here.

            -->

            <v-btn v-if="canEdit" @click="editModal = !editModal"  block color="primary mb-1"> <v-icon>mdi-draw</v-icon> &nbsp; Opdracht aanpassen <v-spacer /> </v-btn>            
            <v-btn v-if="canRemove" class="mb-1"  @click="deleteModal = !deleteModal"  block color="error"> <v-icon>mdi-trash-can-outline</v-icon> &nbsp;  Opdracht verwijderen <v-spacer /> </v-btn>                   
            <v-btn v-if="canDeliver" @click="delivery"   block color="primary  mb-1"><v-icon>mdi-upload</v-icon> &nbsp; tijdelijke oplevering <v-spacer></v-spacer></v-btn>     
            <v-btn v-if="canFinalDeliver" @click="final"  block color="secondary  mb-1"> <v-icon>mdi-upload</v-icon> &nbsp; Finale oplevering <v-spacer></v-spacer></v-btn>     
            <v-btn v-if="canQuitPostmaker"  @click="wantStopModal = !wantStopModal" block color="error  mb-1"> <v-icon>mdi-close</v-icon> &nbsp; Ik wil stoppen <v-spacer></v-spacer></v-btn>   
            <v-btn v-if="canContinuePostmaker"  @click="wantContinueModal = !wantContinueModal" block color="success  mb-1"> <v-icon>mdi-arrow-right-bold-box</v-icon> &nbsp; Ik wil doorgaan <v-spacer></v-spacer></v-btn>   
            <v-btn v-if="canDeliveryAccept" @click="acceptModal = !acceptModal" class="success mb-1" block> <v-icon>mdi-check</v-icon> &nbsp; Oplevering is goed  <v-spacer></v-spacer></v-btn>
            <v-btn v-if="canImprove" @click="awaitModal = !awaitModal" class="secondary mb-1 " block> <v-icon>mdi-timer-sand</v-icon> &nbsp; Ik wil een verbetering <v-spacer></v-spacer>  </v-btn>    
            <v-btn v-if="canQuit" @click="deletePostmakerModal = !deletePostmakerModal"  class="error mb-1 " block> <v-icon>mdi-alert</v-icon> &nbsp; stop de opdracht  <v-spacer></v-spacer> </v-btn>    
            <v-btn v-if="canRecievePayment" @click="paymentRecievedModal = !paymentRecievedModal"  class="success mb-1 " block> <v-icon>mdi-cash</v-icon> &nbsp; Bedrag heb ik ontvangen  <v-spacer></v-spacer> </v-btn>    
            <v-btn v-if="hasPostmaker" @click="like" class="success mb-1" block> <v-icon>mdi-thumb-up</v-icon> &nbsp; Waardeer samenwerking <v-spacer></v-spacer> </v-btn>    
            
            <modal v-model="paymentRecievedModal" width=500 title="Heeft u een betaling ontvangen?">
                Met deze actie is de betaling ontvangen en wordt de opdracht gearchiveerd. <br>                            
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="error" @click="paymentRecievedOrder()"> <v-icon>mdi-arrow-right-bold-box</v-icon> &nbsp; Ja, Archiveren <v-spacer></v-spacer></v-btn>
                    <v-btn @click="paymentRecievedModal = !paymentRecievedModal" class="success"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

            <modal v-model="wantContinueModal" width=500 title="Weet u het zeker?">
                Je geeft hiermee aan toch te willen doorgaan. <br>                            
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="error" @click="continueOrder()"> <v-icon>mdi-arrow-right-bold-box</v-icon> &nbsp; Ja, Doorgaan <v-spacer></v-spacer></v-btn>
                    <v-btn @click="wantContinueModal = !wantContinueModal" class="success"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

            <modal v-model="deleteModal" width=500 title="Weet u het zeker?">
                De opdracht wordt hiermee permanent verwijderd. <br>                            
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="error" @click="deleteOrder()"> <v-icon>mdi-trash-can-outline</v-icon> &nbsp; Ja, Verwijderen <v-spacer></v-spacer></v-btn>
                    <v-btn @click="deleteModal = !deleteModal" class="success"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

             <modal v-model="deletePostmakerModal" width=500 title="Voor altijd op non-actief?">
                De opdracht wordt hiermee permanent verwijderd en de Postmaker verliest de opdracht. <br>                            
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="error" @click="deletePostmaker()"> <v-icon>mdi-trash-can-outline</v-icon> &nbsp; Ja, Verwijderen <v-spacer></v-spacer></v-btn>
                    <v-btn @click="deletePostmakerModal = !deletePostmakerModal" class="success"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

            <modal v-model="wantStopModal" width=500 title="Wil je echt stoppen?">
                De aanvragen wordt een stopbericht gestuurd, hij kan nog contact opnemen met jou om dit project te hervatten of ervoor kiezen te stoppen. <br>                            
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="error" @click="wantToStop()"> <v-icon>mdi-trash-can-outline</v-icon> &nbsp; Ja, Ik wil stoppen <v-spacer></v-spacer></v-btn>
                    <v-btn @click="wantStopModal = !wantStopModal" class="success"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

            <modal v-model="editModal" width=500 title="Weet u het zeker?">
                De opdracht wordt hiermee in aanpas modus gezet. <br>
                Hierdoor komen alle aanvragen te vervallen.
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="success" @click="edit()"> <v-icon>mdi-file-send-outline</v-icon> &nbsp; Ja, Aanpassen <v-spacer></v-spacer></v-btn>
                    <v-btn @click="editModal = !editModal" class="error"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

            <modal v-model="acceptModal" width=500 title="Goedkeuren van de tijdelijke opleveringen?">
                U gaat hiermeer akkoord dat de huidige opleveringen goed genoeg zijn. <br>
                Met deze actie verstuurd de postmaker u de eindoplevering en de factuur.
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="success" @click="acceptDelivery()"> <v-icon>mdi-file-send-outline</v-icon> &nbsp; Ja, Dat is goed <v-spacer></v-spacer></v-btn>
                    <v-btn @click="acceptModal = !acceptModal" class="error"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 

            <modal v-model="awaitModal" width=500 title="Weet u het zeker?">
                Als u dit aangeeft, krijgt de postmaker te zien dat hij de oplevering moet verbeteren.<br>                
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="success" @click="progress()"> <v-icon>mdi-file-send-outline</v-icon> &nbsp; Ja, Ik wil een verbetering <v-spacer></v-spacer></v-btn>
                    <v-btn @click="awaitModal = !awaitModal" class="error"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren <v-spacer></v-spacer></v-btn>
                </template>
            </modal> 
            

        </v-card-text>
    </card>
</template>

<script>
import { mapState } from 'vuex';
  export default {
    methods:{        
        final(){
            this.$store.commit('order/delivery/CLEAR_DELIVERY');
            this.$store.commit('order/delivery/TOGGLE_FINAL_MODAL');
        },
        delivery(){
            this.$store.commit('order/delivery/CLEAR_DELIVERY');
            this.$store.commit('order/delivery/TOGGLE_NEW_MODAL');
        },
        acceptDelivery(){
            this.$store.dispatch('order/accept');     
            this.acceptModal = !this.acceptModal          ;
        },
        progress(){            
            this.$store.dispatch('order/progress');  
             this.awaitModal = !this.awaitModal;        
        },
        deletePostmaker(){
            this.$store.dispatch('order/quit');            
            this.deletePostmakerModal = !this.deletePostmakerModal;        
        },
        wantToStop(){
             this.$store.dispatch('order/quit_postmaker');
             this.wantStopModal = !this.wantStopModal;   
        },
        deleteOrder(){
            this.$store.dispatch('order/remove')
            this.deleteModal = !this.deleteModal;   
        },
        continueOrder(){
            this.$store.dispatch('order/progress');  
            this.wantContinueModal = !this.wantContinueModal;   
        },
        edit(){
            this.$store.dispatch('order/edit');   
            this.editModal = !this.editModal;  
        },
        paymentRecievedOrder(){
            this.$store.dispatch('order/recieved_payment');   
            this.paymentRecievedModal = !this.paymentRecievedModal;  

        },
        like(){
            this.$store.dispatch('order/like');   
        }

    },
    computed:{
        ...mapState({
            order: state => state.order.data,
            auth: state => state.auth.user
        }),

        isOwner(){
            if(this.auth && this.order.user)
                return this.auth.id == this.order.user.id;
        },

        hasPostmaker(){
            if(this.auth && this.order)
                return this.order.postmaker != null;                
        },

        isPostmaker(){
            if(this.auth && this.order && this.order.postmaker)
                return this.order.postmaker.id == this.auth.id;                
        },
        canEdit(){              return (this.order.state == 'open')                                                         && this.isOwner },
        canRemove(){            return (this.order.state == 'open' || this.order.state == 'create')                         && this.isOwner },  
        canDeliver(){           return (this.order.state == 'progress' || this.order.state == 'delivered')                  && this.isPostmaker },
        canQuitPostmaker(){     return (this.order.state == 'progress' || this.order.state == 'delivered')                  && this.isPostmaker }, 
        canQuit(){              return (this.order.state == 'progress' || this.order.state == 'delivered')                  && this.isOwner },  
        canDeliveryAccept(){    return (this.order.state == 'progress' || this.order.state == 'delivered')                  && this.isOwner  },
        canFinalDeliver(){      return (this.order.state == 'delivery_accepted')                                            && this.isPostmaker },                                   
        canRecievePayment(){    return (this.order.state == 'final_delivered' || this.order.state == 'delivery_accepted')   && this.isPostmaker },                               
        canContinuePostmaker(){ return (this.order.state == 'quit_postmaker')                                               && this.isPostmaker },
        canImprove(){           return (this.order.state == 'delivered')                                                    && this.isOwner }                              


      
       

      
        
      

       
    },



    data () {
        return {
            editModal:false,
            deleteModal:false,
            acceptModal:false,
            awaitModal:false,
            deletePostmakerModal: false,
            wantStopModal:false,
            wantContinueModal:false,
            paymentRecievedModal:false,
        }
    }
  }
</script>