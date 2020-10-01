
<template>
<!--  -->
    <v-navigation-drawer  
    style="overflow-y:hidden"
     expand-on-hover
    :mini-variant.sync="mini" 
     
    :style="{background: $vuetify.theme.currentTheme.background_menu}"
    dark permanent  
    v-if="show"
     fixed
    >
       
        <v-list-item style="height:88px" class="px-2 mt-2">
            <v-list-item-avatar  >     
                <v-icon  x-large >mdi-tree-outline</v-icon>               
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title class="h2 mt-3">Postmaker</v-list-item-title>  
                <v-list-item-subtitle>Aanvragen en produceren</v-list-item-subtitle> 
            </v-list-item-content>
             <!-- <v-btn class="px-2 mt-2" icon @click.stop="mini = true" >
                <v-icon x-large >mdi-chevron-left</v-icon>                
            </v-btn>         -->
        </v-list-item>

        <v-divider></v-divider>
  
      <!-- <v-divider></v-divider>    -->
            <drawer-list-item   link="/" icon="mdi-home-outline" text="Home " ></drawer-list-item>                        
            <!---->
            <drawer-list-item    v-if="isAdmin" link="/admin/panel" icon="mdi-home-group" text="Beheer " > </drawer-list-item>            
            <!--REQUESTER-->            
            <drawer-list-item :shown="mini" :badge="nrOfmyOrders"   v-if="isRequester" link="/requester/orders" icon="mdi-briefcase-outline" text="Project" > {{nrOfmyOrders}}  </drawer-list-item>      
            <drawer-list-item :shown="mini" :badge="nrOfRequests"   v-if="isRequester" link="/requester/requested" icon="mdi-message-arrow-left-outline" text="Aanvraag" >   {{nrOfRequests}}  </drawer-list-item>
            <!--POSTMAKER-->            
            <drawer-list-item :shown="mini" :badge="nrOfmyOrders" v-if="isPostmaker" link="/postmaker/orders" icon="mdi-briefcase-outline" text="Project" >{{nrOfmyOrders}}  </drawer-list-item>
            <drawer-list-item :shown="mini" :badge="nrOfOpenOrders" v-if="isPostmaker"  link="/open" icon="mdi-bulletin-board" text="Beschikbaar" > {{nrOfOpenOrders}} </drawer-list-item>             
            <drawer-list-item :shown="mini"  :badge="nrOfRequests" v-if="isPostmaker" link="/postmaker/requested" icon="mdi-message-arrow-right-outline" text="Aanvraag" >  {{nrOfRequests}} </drawer-list-item>

            <!--GENERAL-->           
    	    <drawer-list-item link="/archive" v-if="isPostmaker || isRequester" icon="mdi-archive-outline" text="Archief" > {{nrOfArchivedOrders}}  </drawer-list-item>                        
            <drawer-list-item link="/profile" icon="mdi-account-outline" text="Profiel" />   
            <drawer-list-item link="/settings" icon="mdi-cog-outline" text="Instellingen" />                  
    </v-navigation-drawer>    
</template>

<script>
    import drawerListItem from './nav/drawerListItem';
    import {mapState} from 'vuex';

    export default {
        data(){return{
            show:true,
            mini:true,                  
        }},
        created(){
            if(this.isLandingPage()){
                this.show = false;
            }   
        },
        methods:{
            isLandingPage(){
                return window.location.pathname == '/';
            },            
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