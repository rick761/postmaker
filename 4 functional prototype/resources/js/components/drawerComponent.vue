
<template>
    <v-navigation-drawer permanent :mini-variant="mini" v-if="show" app>

        <v-list-item class="px-2 mt-2">
            <v-list-item-avatar @click.stop="mini = false">
                <v-icon x-large >mdi-tree-outline</v-icon>
            </v-list-item-avatar>
            <v-list-item-title class="h2 mt-3">Postmaker</v-list-item-title>   

             <v-btn class="px-2 mt-2" icon @click.stop="mini = true" >
                <v-icon v-if="!mini">mdi-chevron-left</v-icon>
                <v-icon v-else>mdi-chevron-right</v-icon>
            </v-btn>        

        </v-list-item>

      <v-divider></v-divider>
             
            
            <!--REQUESTER-->
            <v-list-item v-if="isAdmin">Requester</v-list-item>
            <drawer-list-item :badge="nrOfmyOrders"   v-if="isRequester || isAdmin" link="/requester/orders" icon="mdi-home-group" text="Opdrachten" />            
            <drawer-list-item :badge="nrOfRequests" v-if="isRequester || isAdmin" link="/requester/requested" icon="mdi-routes-clock" text="Aanvragen" />            


            <!--POSTMAKER-->
            <v-list-item v-if="isAdmin" >Postmaker</v-list-item>
            <drawer-list-item :badge="nrOfmyOrders" v-if="isPostmaker|| isAdmin" link="/postmaker/orders" icon="mdi-home-group" text="Opdrachten" />   
            <drawer-list-item :badge="nrOfRequests" v-if="isPostmaker|| isAdmin" link="/postmaker/requested" icon="mdi-routes-clock" text="Aanvragen" />   

            <!--GENERAL-->
            <v-list-item v-if="isAdmin" >Algemeen</v-list-item>    
    	    <drawer-list-item link="/archive" icon="mdi-buffer" text="Archief" />  




        
        <v-divider></v-divider>     

        <!-- <v-list-item class="px-2 mt-2">
            <v-list-item-avatar>                
                <v-icon large >mdi-account-supervisor-circle</v-icon>
            </v-list-item-avatar>
            <v-list-item-title class="h5 mt-3">Community</v-list-item-title>    
        </v-list-item>    -->

        <!-- <v-list dense>             -->
            <drawer-list-item :badge="nrOfOpenOrders" badgeColor="primary" link="/open" icon="mdi-earth" text="Beschikbaar" />             
            <drawer-list-item link="/inspire" icon="mdi-collage" text="Inspiratie" />  
        <!-- </v-list> -->

        <v-divider></v-divider>

         
            
            <drawer-list-item link="/profile" icon="mdi-card-account-details-outline" text="Profiel" />   
            <drawer-list-item link="/settings" icon="mdi-cog" text="Instellingen" />   
        
        <v-list-item class="px-2 mt-2">
                <v-list-item-avatar>     
                    <v-btn @click="showTemplates = !showTemplates">          
                        <v-icon large >mdi-admin</v-icon>
                    </v-btn> 
                </v-list-item-avatar>
            <v-list-item-title class="h2 mt-3"></v-list-item-title>    
        </v-list-item>

        <div v-if="showTemplates">
        <v-list dense>            

            <v-list-item to="/requester/order/new" >
                <v-list-item-icon>                   
                    <v-icon medium>mdi-ab-testing</v-icon>                   
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Nieuwe opdracht</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
                  
            <v-list-item to="/openOrder" >
                <v-list-item-icon>                   
                    <v-icon medium>mdi-ab-testing</v-icon>                   
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>open opdracht</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
                
            <v-list-item to="/requester/order" >
                <v-list-item-icon>                   
                    <v-icon medium>mdi-ab-testing</v-icon>                   
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Opdracht (Aanvrager)</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
                    
            <v-list-item to="/postmaker/order" >
                <v-list-item-icon>                   
                    <v-icon medium>mdi-ab-testing</v-icon>                   
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Opdracht (Postmaker)</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

        </v-list>
        </div>
    </v-navigation-drawer>    
</template>

<script>
    import drawerListItem from './nav/drawerListItem';
    import {mapState} from 'vuex';

    export default {
        data(){return{
            show:true,
            mini:false,   
            showTemplates:true    
        }},
        created(){
            if(this.isLandingPage()){
                this.show = false;
            }           
        },
        methods:{
            isLandingPage(){
                return window.location.pathname == '/';
            }            
        },
        components:{
            drawerListItem
        },
        computed:{
            ...mapState({                
                auth: state => state.auth.user,
                orders: state => state.orders.list,
                open: state => state.orders.open,
                requested: state => state.orders.requested,
            }),
            nrOfRequests(){
                var count = 0;
                for(var i in this.requested){
                    count += this.requested[i].order_requests.length;
                }
                return count;
            },
            nrOfOpenOrders(){
                return this.open.length;
            },
            nrOfmyOrders(){
                return this.orders.length;
            },
            isAdmin() {
                return this.auth.type == 'admin';
            },
            isPostmaker(){
                return this.auth.type == 'postmaker';
            },
            isRequester(){
                return this.auth.type == 'requester';
            }
        }
        
    }   
</script>