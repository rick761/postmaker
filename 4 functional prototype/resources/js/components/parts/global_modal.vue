<template>
  <div class="text-center">    
    <v-dialog
       transition="dialog-bottom-transition"          
      :value="open"   
      :width="400"       
      @click:outside="handleInput"
      @keydown.esc="handleInput" 
    >      
      <slot name="activator" />    
      <card noflex mb="mb-0">
               
        <v-toolbar dark color="primary" class="mb-5">                   
              <v-toolbar-title>
                  {{modal.title}}
              </v-toolbar-title>            
              <v-spacer />          
              <v-btn  icon @click="handleInput"> <v-icon>mdi-close</v-icon> </v-btn>                        
        </v-toolbar>
        

       <v-card-text>          
          {{modal.text}}
       </v-card-text>
            
        <!-- <v-divider></v-divider> -->

         <v-card-actions>
           <v-spacer /> 
           <v-btn class="success" @click="success">Ja</v-btn>
           <v-btn class="error" @click="handleInput">Nee</v-btn>

        </v-card-actions> 
      </card>
      
    </v-dialog>
  </div>
</template>

<script>
import {mapState} from 'vuex';
  export default {
    props:{
    //   value:{default:0},
    //   title:{default:''},
    //   width:{default:600},
    //   fullscreen:{default:false},      
    },      
    computed:{
        ...mapState({
            modal : state => state.modal.data ,
            open : state => state.modal.open 
        })
    },
    methods: {
      handleInput () {
        this.$store.commit('modal/TOGGLE_GLOBAL_MODAL');
      },
      success(){
        this.handleInput();
        this.$store.dispatch('modal/confirm');        
      }
    },   
  }
</script>

