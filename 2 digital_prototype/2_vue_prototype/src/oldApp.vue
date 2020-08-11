<template>
  <div id="app" >          
      <loader />

      
      <navigation :currentroute="this.$router.currentRoute.name" v-if="this.$router.currentRoute.name != 'Login' && this.$router.currentRoute.name != 'Register'" />
      <error-messages v-if="this.$router.currentRoute.name == 'Login' || this.$router.currentRoute.name == 'Register'" />

      <div class="wrapper">
        <error>   
          <!--content-->
          <router-view />
        </error>         
        <div class="makes_page_larger">&nbsp;</div>         
      </div>           
  </div>
</template>

<script>
import navigation from './components/navigation.vue'
import error from './components/error'
import loader from './components/loader'
import errorMessages from './components/errorMessages'
import {mapState} from 'vuex'

export default {

  data(){return{
        token: localStorage.getItem('user-token'),       
  }},

  components: {
    navigation,
    error,
    loader, 
    errorMessages   
  },

  computed:{
    ...mapState({
        authUser: state => state.auth.user,
        errors: state=> state.errors
    }),  
  }, 

  methods:{
   logout(){      
      this.$store.dispatch('auth/logout');
    }
  },

  // default functions vue
  beforeCreate(){console.log('beforeCreate')},  
  created(){        
    this.$store.dispatch('constants/load');  
    this.$store.dispatch('auth/get').then(()=>{
      this.$store.dispatch('notifications/init');   
    });  
  },

  beforeMount(){console.log('beforeMount')},
  mounted(){console.log('mounted')},
  beforeUpdate(){console.log('beforeUpdate')},
  updated(){console.log('updated')},
  beforeDestroy(){console.log('beforeDestroy')},
  destroyed(){console.log('destroyed')},

};
</script>

<style>
  .makes_page_larger{
    height:70vh;
  }

  #app{
    overflow-y: hidden;    
  }

  .wrapper{
    width: 100%;
    padding-right: 30px;
    padding-left: 30px;
    margin-right: auto;
    margin-left: auto;
  }
  
  * {
      font-family:unset
  } 

  input:-webkit-autofill,
  input:-webkit-autofill:hover,
  input:-webkit-autofill:focus,
  input:-webkit-autofill:active {
      -webkit-box-shadow: 0 0 0 30px white inset !important;
  }

  /* @media (min-width: 1600px) {
      .container {
          max-width: 1520px;
      }
  } */
 
  .primary-text,h1,h2,h3,h4,h5,span,p,div{  }
  .accent-text,a{}
  .inverse-text{}  
  .inverse-accent-text{}  
  .accent-lighter-text,a:hover{}
  .accent-darker-text{}
 .primary-background{}
 .second-background{}
 .third-background{}

  ul{
    margin-block-start: 0;
    margin-block-end: 0;
    padding-inline-start: 0;
  }

  .card-box {
    background-color: #fff;
    padding: 1.5rem;
    -webkit-box-shadow: 0 0 35px 0 rgba(154,161,171,.15);
    box-shadow: 0 0 35px 0 rgba(154,161,171,.15);
    margin-bottom: 24px;
    border-radius: .25rem;
}

p{
    margin-top: 1rem;
}

h1::first-letter,
h2::first-letter,
h3::first-letter,
h4::first-letter,
h5::first-letter,
div::first-letter,
p::first-letter,
label::first-letter,
input::first-letter{
    text-transform: capitalize;
}

.right{
    float:right;
}

.mdi {
    font-size: 17px;
}

.collapse-enter-to, .collapse-leave {
    max-height: 130vh;
    overflow: hidden;
}
.collapse-enter, .collapse-leave-to {
      overflow: hidden;
    max-height: 0;
}   
.collapse-leave-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}
.collapse-enter-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
}

</style>
