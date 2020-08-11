<template>
    <v-row>
        <v-col cols="12">
            <v-card  cols="12" flat tile >                
                <v-card-title>Berichten</v-card-title>

                <v-card-text id="chat" >                    
                    <p v-for="(item,key) in messages" :key="key" :class="{'text-right' : item.user_id == authUser.id }">
                        <v-avatar color="grey" class="mr-4">            
                            <span v-if="item.user_id != authUser.id">                
                                <span v-if="authUser.type == 'Contentaanvrager'">{{order.postmaker.first_name}}</span>
                                <span v-if="authUser.type == 'Postmaker'">{{order.user.first_name}}</span>     
                            </span>                  
                            <span v-else>Ik</span>     
                        </v-avatar> {{item.text}} 
                    </p>
                    <p class="text-center" v-if="!messages.length">Er zijn nog geen berichten</p>
                </v-card-text>

                <v-card-actions>

                    <v-toolbar flat >
                        <v-icon>mdi-message</v-icon>
                        <v-text-field v-model="message" class="ml-5"
                            hide-details                
                            single-line
                        ></v-text-field>
                        <v-btn @click="send" class="ml-5 primary" dark icon>
                            <v-icon>mdi-send</v-icon>
                        </v-btn>
                        <v-btn disabled class="ml-5 primary" dark icon>
                            <v-icon>mdi-file</v-icon>
                        </v-btn>
                    </v-toolbar>

                </v-card-actions>
            </v-card>    
        </v-col>      

    </v-row>

</template>

<script>
import {mapState} from 'vuex'
export default {
    props:[],
    data(){return{
        message:''
    }},
    
    computed:{
        ...mapState({  
            order : state => state.order_page.order,
            messages : state => state.order_page.order.messages.list,            
            loader : state => state.loader,
            authUser : state => state.auth.user
        })
    },
    methods:{
        send(){
            if(this.message){
                this.$store.dispatch('order_page/order/messages/new',this.message);
                this.message="";
                var container = document.getElementById("chat");
                container.scrollTop = container.scrollHeight;

            }
        }
    },
    updated(){
       var container = document.getElementById("chat");
       container.scrollTop = container.scrollHeight;
    }
}

</script>

<style scoped>
#chat{
    min-height:300px;
    max-height:500px;
    overflow-y: auto;
}

</style>