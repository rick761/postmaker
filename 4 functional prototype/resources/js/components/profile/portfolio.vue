<template>    
    <card>   
        <v-card-subtitle>Archief op profiel weergeven</v-card-subtitle>
        <v-card-text>   
            <span v-if="!archived_orders.length">- Er zijn geen afgeronde projecten, rond eerst een project af.</span>
            <v-expansion-panels >
                <v-expansion-panel @click="loadSelected()" v-for="(order,key) in archived_orders" :key="key" >

                    <v-expansion-panel-header>                                
                        {{order.title}}                                                                      
                    </v-expansion-panel-header>

                    <v-expansion-panel-content>    

                            <v-card-text>
                                
                                <v-item-group v-model="selected[order.id]" multiple >                                        
                                    <v-row >
                                        <v-col v-for="(file, key3) in order.archivedSuccess" :key="key3" cols=4 > 

                                            <v-item v-if="isImage(file.url)" v-slot:default="{ active, toggle }">
                                                <v-img
                                                    
                                                    :color="active ? 'primary' : ''"                                                    
                                                    :src="`./storage/${order.postmaker_id}/order_delivery/${order.id}/${file.url}`"
                                                    class="d-flex align-center"
                                                    dark
                                                    height="200"
                                                    :id="file.id"
                                                    @click="toggle"
                                                >                                                
                                                    <v-scroll-y-transition>
                                                        <div
                                                        v-if="active"
                                                        class="display-3 flex-grow-1 text-center"
                                                        >
                                                            <v-icon x-large>mdi-check</v-icon>
                                                        </div>
                                                    </v-scroll-y-transition>
                                                </v-img>
                                            </v-item>
                                            

                                        </v-col>
                                    </v-row>
                                </v-item-group>
                            </v-card-text>
                                
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn @click ="hideAll(order.id)"
                                    text
                                    color="secondary"
                                >
                                    Niks weergeven
                                </v-btn>
                                <v-btn @click ="showSelected(order.id)"
                                    text
                                    color="primary"
                                >
                                    Opslaan
                                </v-btn>
                            </v-card-actions>

                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-text>    
        </card>   
</template>


<script>
    import {mapState} from 'vuex';

    export default {

        computed:{
            ...mapState({
                auth:  state => state.auth.user,
                archived_orders: state => state.auth.archivedDelivery.archived,
                user_show_deliverys : state => state.auth.archivedDelivery.data
            })                        
        },

        data(){ return{            
            selected:[],
            project_show:false, 
            data_loaded:false,   
        }},

        methods:{

            isImage(url){                 
                var allowedExtension = ['jpg','png']                
                var ext = url.split('.')[url.split('.').length-1].toLowerCase();

                for(var i in allowedExtension){
                    if(allowedExtension[i] == ext){
                        return true;
                    }
                }

                return false;            
            },

            hideAll(id){                
                this.selected[id] = [];      
                this.$forceUpdate(); 
                this.$store.dispatch('auth/archivedDelivery/hide',{order_id: id});
            },

            showSelected(id){
                var ids =[];
                var selectedOrder = this.archived_orders.filter(item => item.id == id)[0];

                for(var i in this.selected[id] ){                          
                   ids.push(selectedOrder.archivedSuccess[this.selected[id][i]]);                   
                }
                
                console.log(this.selected);

                this.$store.dispatch('auth/archivedDelivery/show',{order_id: id, delivery_files: ids});               
            },

            loadSelected(){
                this.$forceUpdate();
                console.log(this.selected);
            },

            setShownDeliveries(){
                var ids = [];

                this.user_show_deliverys.forEach(element => {
                    ids.push(element.order_delivery_file_id);
                });                

                for(var i in this.archived_orders){
                    var order_id = this.archived_orders[i].id;
                    var archived_deliveries = this.archived_orders[i].archivedSuccess;

                    if(!this.selected[order_id]){
                        this.selected[order_id]=[];
                    }

                    for (var i in archived_deliveries){
                        var delivery_id = archived_deliveries[i].id;
                        if(ids.indexOf(delivery_id) != -1){
                            this.selected[order_id].push(parseInt(i));
                        }                        
                    }
                    this.$forceUpdate(); 
                }               
            }
        },
        
        updated(){
            if( !this.data_loaded  && this.user_show_deliverys.length ){
                this.data_loaded = 1;
                this.setShownDeliveries();                
            }
            
        }
    }
</script>