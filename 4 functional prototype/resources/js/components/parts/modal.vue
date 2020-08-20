<template>
  <div class="text-center">    
    <v-dialog
      transition="dialog-bottom-transition"    
      :fullscreen="fullscreen"
      :value="value"   
      :width="width"       
      @click:outside="handleInput"
      @keydown.esc="handleInput"
    >      
      <slot name="activator" />    
      <card noflex mb="mb-0">
               
        <v-toolbar dark color="primary" class="mb-5">     
              <div style="display:flex;" class="container">              
                <v-toolbar-title class="mt-2">{{title}}</v-toolbar-title>            
                <v-spacer />          
                <v-btn  icon @click="handleInput"> <v-icon>mdi-close</v-icon> </v-btn>      
              </div>   
        </v-toolbar>
        

       <v-card-text>
          <slot />
       </v-card-text>
            
        <v-divider></v-divider>

        <v-card-actions>
            <slot name="actions" />
        </v-card-actions>
      </card>
      
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props:{
      value:{default:0},
      title:{default:''},
      width:{default:600},
      fullscreen:{default:false},      
    },      
    methods: {
        handleInput (e) {
          this.$emit('input', !this.value )
        }
    },   
  }
</script>

