<template>
  <div class="text-center">    
    <v-dialog scrollable 
      :value="show"        
      @click:outside="close"
      @keydown.esc="close"
    >           
      <card style="overflow:hidden;">

        <v-card-title tile class="headline">
          {{title}}  
          <v-spacer></v-spacer>          
          <v-btn @click="close" text class="error ml-3"> <v-icon>mdi-close</v-icon></v-btn>  
        </v-card-title>     
       
        <v-img  :src="url" />        

      </card>
    </v-dialog>
  </div>
</template>

<script>
import {mapState} from 'vuex';

  export default {       
    methods: {
        close () {
           this.$store.dispatch('image/close');
        }
    },
    computed:{
        ...mapState({                
            show: state => state.image.show,
            url: state => state.image.url,
            title: state => state.image.title,
        })

        
    }
  }
</script>