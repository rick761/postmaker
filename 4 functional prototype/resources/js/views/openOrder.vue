<template>    
    <v-row>
        <v-col cols=8>   
           <!-- title and card -->
            <v-card outlined  class="mb-5" >
                <v-card-title>
                    <v-icon>mdi-{{order.type}}</v-icon> &nbsp; {{order.title}}
                </v-card-title>
                <v-card-text>
                     <v-chip class="mr-3 mb-3" :key="key" v-for="(item,key) in tags" >#{{item.text}}</v-chip>
                </v-card-text>
                <v-card-text style="max-height:400px; overflow-y:auto;" :class="{'description_hide': !description_show }">
                    {{order.description}}
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn icon v-if="description_show" @click="description_show = !description_show"><v-icon>mdi-chevron-up</v-icon></v-btn>
                    <v-btn icon v-if="!description_show"  @click="description_show = !description_show"><v-icon>mdi-chevron-down</v-icon></v-btn>
                </v-card-actions>
            </v-card>           

            <!--requests -->
            
            <order-request-order-component v-if="!isOwner && isPostmaker" /> 
            
            <v-card outlined v-if="isOwner && requests && requests.length" >
                 <v-card-subtitle>
                     Aanvragen
                </v-card-subtitle>                
                <v-list>
                    <order-incoming-request-component v-for="(request,key) in requests" :item='request' :key='key' /> 
                </v-list>
            </v-card> 

            <v-row style="display:none">
                <v-col v-for="i in 2" :key="i" cols=6>                   
                    <v-card outlined>   
                                            
                        <v-list-item class="mt-3">
                            <v-list-item-content>
                                <v-list-item-title>Travis Howard</v-list-item-title>
                            </v-list-item-content>

                            <v-list-item-avatar>
                                <v-img :src="'https://cdn.vuetifyjs.com/images/lists/2.jpg'"></v-img>
                            </v-list-item-avatar>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-content>
                                Nieuwe prijs
                            </v-list-item-content>
                            <v-list-item-content class="text-right">
                                <v-list-item-title>800,00</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-card-text>
                            <v-textarea rows=2 disabled solo placeholder="Motivatie" v-model="motivation"></v-textarea> 
                            
                        </v-card-text>
                                    
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn class="success" >Accepteren</v-btn>
                            <v-btn class="error" >Weigeren</v-btn>
                        </v-card-actions>

                    </v-card>
                </v-col>
                </v-row>
        </v-col>  

        <v-col cols=4>       
            <order-aside-component />
            <order-files-moodboard-component />                 
        </v-col> 

    </v-row>
    
</template>

<script>
import { mapState } from 'vuex';
  export default {
    computed:{

        ...mapState({
            order: state => state.order.data,
            requests: state => state.order.requests.list,
            auth: state => state.auth.user,
            tags : state => state.order.tags.list
        }),

        isOwner(){
            if(this.auth && this.order.user)
                return this.auth.id == this.order.user.id;
        },

        isPostmaker(){
            if(this.auth.type == 'postmaker' ){
                return 1;
            }
        }

    },
    data () {
        return {
            editModal:false,
            files:[{name:'docks.jpg'},{name:'docks.jpg'},{name:'docks.jpg'}],
            
            load:false,
            description_show:true,
            motivation:''
        }    
    },

    methods:{
        upload(){            
            this.load = true;
            setTimeout( () => {
                this.load = false;                
            }, 1000)
        },
        
    },

    created(){         
        this.$store.dispatch('order/get',this.$route.params.orderId);          
    }

  }
</script>

<style scoped>
    .description_hide{
        height:50px;overflow:hidden;
    }
</style>