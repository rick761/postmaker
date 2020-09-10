
<template>
    <v-navigation-drawer fixed  :style="{background: $vuetify.theme.currentTheme.background_menu}" dark permanent  :mini-variant="mini" v-if="show" app>
       
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

            <drawer-list-item link="/" icon="mdi-briefcase-variant" text="Home " ></drawer-list-item>            
            
            <!---->
            <drawer-list-item    v-if="isAdmin" link="/admin/panel" icon="mdi-home-group" text="Beheer " > </drawer-list-item>            

            <!--REQUESTER-->
            
            <drawer-list-item    v-if="isRequester" link="/requester/orders" icon="mdi-home-group" text="Opdrachten " > {{nrOfmyOrders}}  </drawer-list-item>            
            <drawer-list-item    v-if="isRequester" link="/requester/requested" icon="mdi-routes-clock" text="Aanvragen" >   {{nrOfRequests}}  </drawer-list-item>            


            <!--POSTMAKER-->            
            <drawer-list-item  v-if="isPostmaker" link="/postmaker/orders" icon="mdi-home-group" text="Opdrachten" >{{nrOfmyOrders}}  </drawer-list-item>
            <drawer-list-item  v-if="isPostmaker" link="/postmaker/requested" icon="mdi-routes-clock" text="Aanvragen" >  {{nrOfRequests}} </drawer-list-item>

            <!--GENERAL-->           
    	    <drawer-list-item link="/archive" v-if="isPostmaker || isPostmaker" icon="mdi-buffer" text="Archief" > {{nrOfArchivedOrders}}  </drawer-list-item>
        
        <v-divider></v-divider>     

      
            <drawer-list-item badgeColor="primary" link="/open" icon="mdi-earth" text="Beschikbaar" > {{nrOfOpenOrders}} </drawer-list-item>             
            <!-- <drawer-list-item link="/inspire" icon="mdi-collage" text="Inspiratie" />       -->

        <v-divider></v-divider>         
            
            <drawer-list-item link="/profile" icon="mdi-card-account-details-outline" text="Profiel" />   
            <drawer-list-item link="/settings" icon="mdi-cog" text="Instellingen" />           
       
    </v-navigation-drawer>    
</template>

<script>
    import drawerListItem from './nav/drawerListItem';
    import {mapState} from 'vuex';

    export default {
        data(){return{
            show:true,
            mini:false,                  
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
                archived: state => state.orders.archived,
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
             nrOfArchivedOrders(){
                return this.archived.length;
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
        },
        created(){
            if(this.$vuetify.breakpoint.name == 'xs'){
                this.mini = true;
            }
        }
        
    }   
</script>