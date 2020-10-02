<template>
    <v-list-item >        
        <!--title-->
        <!-- <v-list-item-avatar v-if="item.postmaker && item.postmaker.avatar">
            <v-img :src="'./storage/'+item.postmaker.id+'/avatar/'+item.postmaker.avatar" />
        </v-list-item-avatar> -->

        <!--content-->
        <v-list-item-content>
            <v-list-item-title v-if="item.postmaker" >
                <span v-if=" item.status == 'accepted' " class="success--text">  Geaccepteerd </span> 
                <span v-if=" item.status == 'denied' " class="error--text">  Geweigerd </span> 
                <span v-if=" item.status == 'withrawn' " class="error--text">  Ingetrokken </span>    
                <v-spacer />                
                     
            </v-list-item-title>

            <profileTag :user="item.postmaker" />
            <v-list-item>
                <v-list-item-subtitle >
                    <p class='text--primary'>Vraagt {{item.payment}} euro voor het uitvoeren van deze opdracht. </p>          
                    <p>
                        <i v-if="item.text" >{{item.text}}</i>
                        <i v-else> Heeft geen motivatie aangegeven</i> 
                    </p>
                </v-list-item-subtitle>
            </v-list-item>
                        
            
        </v-list-item-content>

        <!--buttons-->
        <v-list-item-content v-if="item.status == 'open' ">
            <div class="text-right">
                <v-btn class="d-inline success accept-request-button mb-1" @click="acceptModal = !acceptModal"> <v-icon>mdi-check</v-icon> &nbsp; Accepteren </v-btn>
                <v-btn class="d-inline error" @click="deny()"><v-icon>mdi-close</v-icon> &nbsp; Weigeren</v-btn>
            </div>

            <modal v-model="acceptModal" width=500 title="Weet u het zeker?">
                Hiermee bevestig je de samenwerking met <router-link :to="'/account/'+item.postmaker.id">{{item.postmaker.display_name}}</router-link>. <br> 
                Het bedrag van {{item.payment}} euro wordt afgesproken bij de oplevering.
                <template slot="actions">
                    <v-spacer></v-spacer>                                    
                    <v-btn class="success publish-order-confirm" @click="accept()"> <v-icon>mdi-trash-can-outline</v-icon> &nbsp; Ja, Accepteren</v-btn>
                    <v-btn @click="acceptModal = !acceptModal" class="primary"> <v-icon>mdi-close</v-icon> &nbsp; Annuleren</v-btn>
                </template>
            </modal> 

        </v-list-item-content>        
        
    </v-list-item>
</template>

<script>
export default {
    data(){ return {
        acceptModal:false
    } },
    methods:{
        deny(){           
            this.$store.dispatch('order/requests/deny',this.item.id);
        },
        accept(){            
            this.$store.dispatch('order/requests/accept',this.item.id);         
        }
    },
    props:['item'],
    created(){
        
    }
}
</script>