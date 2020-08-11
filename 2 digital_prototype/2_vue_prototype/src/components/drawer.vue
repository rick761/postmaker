<template>
<v-navigation-drawer  color="blue-grey darken-3" :mini-variant.sync="drawer" permanent dark  app>
      <v-list>
        <!--ICON-->
        <v-list-item two-line class="px-2">
            <v-list-item-avatar color=" yellow darken-3">
              <span class="white--text headline">P</span>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title >{{authUser.type}}</v-list-item-title>
              <v-list-item-subtitle>{{authUser.first_name}} {{authUser.last_name}}</v-list-item-subtitle>
            </v-list-item-content>

            <v-btn
              icon
              @click.stop="drawer = !drawer"
            >
              <v-icon>mdi-chevron-left</v-icon>
            </v-btn>

          </v-list-item>        

        <v-divider></v-divider>        

        <!--HOME-->
        <v-list-item link to="/home" >
         
          <v-list-item-icon>
              <v-badge overlap
                     color="green lighten-2"
                    :content="ORDERS_PERSONAL_COUNT"
              > 
                <v-icon>mdi-home</v-icon>
              </v-badge>
          </v-list-item-icon>
         
          <v-list-item-content>
              <v-list-item-title>Mijn posts</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        
      
      <!--HOME-->
        <v-list-item link to="/requested" >
          <v-list-item-icon>
             <v-badge overlap
                     color="red lighten-2"
                    :content="ORDERS_REQUESTED_COUNT"
              > 
              <v-icon>mdi-target-variant</v-icon>
             </v-badge>
          </v-list-item-icon>
          <v-list-item-content>
              <v-list-item-title>Aanvragen</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!--HOME-->
        <v-list-item link to="/open" >
          <v-list-item-icon>
            <v-badge overlap
                     color="orange lighten-2"
                    :content="ORDERS_OPEN_COUNT"
              > 
              <v-icon>mdi-book-open-variant</v-icon>
            </v-badge>
          </v-list-item-icon>
          <v-list-item-content>
              <v-list-item-title>Open posts</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

      <!--Profiel-->
      <v-list-item link to="/account" >
        <v-list-item-icon>
            <v-icon>mdi-account</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
            <v-list-item-title>Profiel</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <!--Archief-->
      <v-list-item link to="/archive" >
        <v-list-item-icon>
            <v-icon>mdi-archive</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
            <v-list-item-title>Archief</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <!--HOME-->
        <v-list-item link to="/" >
          <v-list-item-icon>
              <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
              <v-list-item-title>Start pagina</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

         <v-list-item class="px-2" v-if="authUser.type=='Contentaanvrager'" >
            <v-list-item-avatar class="yellow darken-3" v-if="drawer" >  
              <v-btn icon class="pl-3" @click="newOrder"   >              
                <v-icon left>mdi-plus</v-icon>         
              </v-btn>                   
            </v-list-item-avatar>
          
            <v-list-item-content>
                <v-list-item-title>
                  <v-btn @click="newOrder"  rounded class="yellow darken-3">
                    <v-icon left>mdi-plus</v-icon>
                    Post
                  </v-btn>   
                </v-list-item-title>
            </v-list-item-content>
        
        </v-list-item>


      </v-list>
      </v-navigation-drawer >    

      
</template>

<script>
import {mapState,mapGetters} from 'vuex'
export default {
  props:['value'],
  data(){return{
    drawer:true
  }},
  computed:{
    ...mapState({
        authUser : state => state.auth.user
    }),
    ...mapGetters({
      ORDERS_OPEN_COUNT: 'orders/ORDERS_OPEN_COUNT',
      ORDERS_PERSONAL_COUNT: 'orders/ORDERS_PERSONAL_COUNT',
      ORDERS_REQUESTED_COUNT: 'orders/ORDERS_REQUESTED_COUNT',
      unread_notifications: 'notifications/UNREAD_NOTIFICATIONS',
  }), 
  },
  methods:{
    newOrder(){
        this.$store.dispatch('orders/create');
      } 
  }
    
    
}
</script>