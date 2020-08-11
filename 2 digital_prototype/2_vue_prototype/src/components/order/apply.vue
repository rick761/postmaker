<template>
    <v-row>
        <v-col>
            <v-card flat>
                <v-card-title>Vraag aan</v-card-title>
                <v-card-subtitle>
                                    
                </v-card-subtitle>
                <v-card-text>
                    
                    <v-textarea
                        outlined
                        name="input-7-4"
                        label="Motivatie"
                         v-model.lazy="motivatie"   
                        ></v-textarea>

                     <p class="text-success" v-if="(requests.apply instanceof Object)" >Er is een aanvraag gedaan</p>
                     <p class="text-danger" v-if="requests.apply.status == 'denied'">*Uw aanvraag is afgewezen</p>

                </v-card-text>
                <v-card-subtitle>
                     <v-btn text color="success" v-if="!(requests.apply instanceof Object)" @click="setApply">
                        Aanvragen
                    </v-btn>

                    <v-btn text color="success" v-if="(requests.apply instanceof Object)" @click="setApply">
                        <span v-if="requests.apply.status == 'denied'" >Opnieuw aanvragen</span>
                        <span v-else >Aanvraag aanpassen</span>
                    </v-btn>

                    <v-btn text color="warning" v-if="(requests.apply instanceof Object)" @click="deleteApply" >
                        Intrekken
                    </v-btn>

                </v-card-subtitle>
            </v-card>
        </v-col>
    </v-row>
    <!-- <collapse  title='Aanvragen'  >

                <p> Opdracht aanvragen </p> 

                <textarea v-if="!loader.loader7"
                    v-model.lazy="motivatie"                                                          
                    :placeholder="'Motivatie (optioneel)'" class="form-control mb-3"
                >                                
                </textarea>

                <textarea disabled :placeholder="'Aan het laden...'" class="form-control mb-3" v-if="loader.loader7" />              
                
                <p class="text-success" v-if="(requests.apply instanceof Object)" >Er een aanvraag gedaan op deze post.</p>
                                                            
                    <button v-if="!(requests.apply instanceof Object)" @click="setApply"  class="btn btn-block btn-primary">                                    
                        <span style="color:white">Opdracht aanvragen </span>
                    </button>

                    <button v-if="(requests.apply instanceof Object)" @click="setApply" class="btn btn-block btn-secondary"> 
                        <span v-if="requests.apply.status == 'denied'" style="color:white;">Opnieuw aanvragen</span>
                        <span v-else style="color:white;">Aanvraag aanpassen</span>
                    </button>                    

                    <button v-if="(requests.apply instanceof Object)" @click="deleteApply" class="btn btn-block btn-danger">                         
                        <span  style="color:white;">Aanvraag intrekken</span>
                    </button>

                    <p class="text-danger" v-if="requests.apply.status == 'denied'">*Uw aanvraag is afgewezen</p>
                 
        </collapse> -->
</template>

<script>
import {mapState} from 'vuex'

export default {
    props:[],
    data(){return{
        motivatieText:""
    }},
    methods:{
        
        setApply(){
            if(this.motivatie != ""){   
                this.motivatie = this.motivatieText; 
                this.$store.dispatch('order_page/order/requests/put',this.motivatieText);
            }
        },

        deleteApply(){
            this.$store.dispatch('order_page/order/requests/del');
        }
    },
    components:{        
                
    },
    computed:{
        ...mapState({  
            requests : state => state.order_page.order.requests,
            order : state => state.order_page.order,
            loader : state => state.loader
        }),  
        motivatie: {
            get () { return this.$store.state.order_page.order.requests.apply.text },
            set (value) {
                this.motivatieText = value ;
            }
        },      
    } 

}

</script>

<style scoped>

</style>