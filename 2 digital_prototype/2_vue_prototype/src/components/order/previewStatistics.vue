<template>
    <v-row>
        <v-col>
            <v-card flat tile style="height:100%;">
                <v-card-title>Gegevens</v-card-title>
                <v-card-subtitle>Van project <i>{{order.title}}</i></v-card-subtitle>

                <v-card-text>
                     <v-expansion-panels v-model="panels" flat>
                        <v-expansion-panel>
                            <v-expansion-panel-header>                                
                                <v-list-item-icon>
                                    <v-icon v-text="'mdi-label'"></v-icon>
                                </v-list-item-icon>       
                                Projectgegevens
                            </v-expansion-panel-header>

                            <v-expansion-panel-content>
                                <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    Sinds <span class="ml-5"> {{formatDate(order.created_at)}}</span>
                                </p>
                                <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    Tot <span class="ml-5" >{{formatDate(order.deliver)}}</span>
                                </p>
                                <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    Opbrengst <span class="ml-5">{{order.payment}}</span>
                                </p>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <v-list-item-icon>
                                    <v-icon v-text="'mdi-account'"></v-icon>
                                </v-list-item-icon> 
                                Aanvrager
                                
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    <router-link :to="'/account/'+order.user.id" >{{order.user.first_name}}</router-link>
                                </p>
                                <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    {{order.user.email}}
                                </p>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                
                                <v-list-item-icon>
                                    <v-icon v-text="'mdi-account'"></v-icon>
                                </v-list-item-icon> 
                                Postmaker
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                  <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    <router-link :to="'/account/'+order.postmaker.id" >{{order.postmaker.first_name}}</router-link>
                                </p>
                                <p>
                                    <v-avatar>
                                        <v-icon>mdi mdi-subdirectory-arrow-right</v-icon>
                                    </v-avatar>
                                    {{order.postmaker.email}}
                                </p>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </v-card-text>
            </v-card>
        </v-col>

    </v-row>

</template>

<script>
import {mapState} from 'vuex'

export default {
    props:[],
    data(){return{
        panels:0
    }},
    components:{        
           
    },
    computed:{
        ...mapState({  
            order : state => state.order_page.order
        })
    } ,
    methods:{
        formatDate(string){
            const _date = new Date(string);
            var unix = Date.parse(string);                  
            var inPast = (Date.now() > unix)
            var inFuture= (Date.now() < unix)
            
            if(inFuture){
                var overXDays = Math.ceil((unix - Date.now()) / (1000 * 3600 * 24));                
                return _date.getDate()+'-'+_date.getMonth()+'-'+_date.getUTCFullYear()+' (over '+overXDays+' dagen)';
            }
            if(inPast){                
                return _date.getDate()+'-'+_date.getMonth()+'-'+_date.getUTCFullYear();                              
            }               
        }
    }
}

</script>

<style scoped>

</style>