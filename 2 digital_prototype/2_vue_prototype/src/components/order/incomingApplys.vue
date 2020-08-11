<template>
<v-row>
    <v-col>
        <v-card flat>
            <v-card-title>Aanvragen</v-card-title>
            <v-card-subtitle>Binnenkomende</v-card-subtitle>
            <v-card-text>
                     <v-row>
                         <v-col>

                         </v-col>

                     </v-row>

                   
                        <v-card  v-for="(item,key) in requests.incoming" :key="key">
                           
                            
                                <v-card-title class="mb-2" >                                    
                                    <i>{{item.text}}</i>
                                </v-card-title>
                                <v-card-subtitle>
                                    <v-avatar class="mr-1">
                                        <v-img :src="'https://cdn.vuetifyjs.com/images/lists/1.jpg'" > </v-img>
                                    </v-avatar>
                                    <router-link :to="'/account/'+item.postmaker.id">{{item.postmaker.first_name}}</router-link>
                                    <p>
                                        <span class="error--text"  v-if="item.status == 'denied'" >Deze aanvraag is geweigerd </span>
                                        <span class="success--text"  v-if="item.status == 'accepted'">Deze aanvraag is geaccepteerd </span>
                                    </p>
                                   

                                </v-card-subtitle>
                                <v-card-actions>
                                        <v-btn @click="accept(item)" class="success mr-1">Accepteren</v-btn>                                    
                                        <v-btn @click="decline(item)" class='danger'>Weigeren</v-btn>
                                </v-card-actions>                                
                            
                        </v-card >

                    
                    

            </v-card-text>
        </v-card>
    </v-col>
                   
            <!-- <p>Aanvragen voor deze order</p>
            
            <p v-if="! requests.incoming.length">
                <span class="mdi mdi-arrow-right"></span>
                geen aanvragen
            </p>             


            <div class="row">
                <div v-for="(item,key) in requests.incoming" :key="key" class="col-6" >                     
                    <hr>
                    <span class="mdi mdi-arrow-right"></span>
                    Aanvraag van 
                    <router-link :to="'/account/'+item.postmaker.id">
                        {{item.postmaker.first_name}}  {{item.postmaker.last_name}}
                    </router-link>  
                    <p class="card p-3" >
                         <span v-if="item.text">{{item.text}}</span>
                         <span v-else>*Er is geen motivatie ingevuld.</span>
                    </p>                                        
                    <p v-if="item.status == 'open'">
                        <button @click="accept(item)" class="btn btn-success m-1 ">Accepteren</button>
                        <button @click="decline(item)" class='btn btn-danger m-1 '>Weigeren</button>
                    </p>
                    <p>
                        <span v-if="item.status != 'open'" >
                            <span class="text-danger"  v-if="item.status == 'denied'" >Deze aanvraag is geweigerd </span>
                            <span class="text-success"  v-if="item.status == 'accepted'"> Deze aanvraag is geaccepteerd </span>
                        </span>
                    </p>
                </div>
            </div> -->

</v-row>
    
</template>

<script>
import {mapState} from 'vuex'



export default {
    props:[],    
    computed:{
        ...mapState({  
            requests : state => state.order_page.order.requests,
            order : state => state.order_page.order
        }),
    } ,
    methods:{
        accept(item){
            this.$store.dispatch('order_page/order/requests/accept',item);            
        },
        decline(item){
            this.$store.dispatch('order_page/order/requests/decline',item);  
        }
    }
}

</script>

<style scoped>

</style>