<template>

  <v-app >

    <!--systbar-->
    <v-system-bar v-if="errors._tmp" color="red" dark app>    
        <v-icon right>mdi-message-cog</v-icon>
        <span v-for="(item,key) in errors._tmp" :key="key">          
          <b>{{key}}</b> <span v-if="Array.isArray(item[0])">{{item[0]}}</span> <span v-else>{{item}}</span>
        </span>        
    </v-system-bar>

    <!--SIDE MENU--->    
    <drawer-component v-model="drawer" v-if="showMenu" />
    

    <!--NAV BAR--->    

    <!--content--->
    <v-main class="blue-grey lighten-5"  >     

      <v-row>
        <v-col cols="11">
         <v-container>
            <router-view></router-view>     
         </v-container>

        </v-col>
        <v-col cols="1">
          <navbar-component @tab="getTab" v-if="showMenu" v-model="drawer" /> 
        </v-col>
      </v-row>


    </v-main>

    <!--footer-->
    <footer-component app />

  </v-app>  
</template>

<script>
import {mapState} from 'vuex'
import footerComponent from './components/footer'
import navbarComponent from './components/navbar'
import drawerComponent from './components/drawer'

export default {

  name: 'App',
  components: {
    footerComponent,
    navbarComponent,
    drawerComponent    
  },

  data: () => ({    
    drawer:0,   
  }),

  /**ONLOAD MODULES **/
  created(){        
    this.$store.dispatch('constants/load');  
    this.$store.dispatch('auth/get').then(()=>{           
      this.$store.dispatch('notifications/init');   
      this.$store.dispatch('orders/get');  
    });  
  },

  computed:{
    ...mapState({
        authUser: state => state.auth.user,
        errors: state=> state.errors
    }),  
    showMenu(){      
      return this.$route.name != 'landing';      
    }
  },

  methods:{
    getTab(e){
      this.tab=e;
    }
  }   

};
</script>
