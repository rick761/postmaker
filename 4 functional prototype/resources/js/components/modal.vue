<template>
  <div class="text-center">    
    <v-dialog
      :value="value"   
      :width="width" 
      @click:outside="handleInput"
    >      

      <slot name="activator">

      </slot>
      <v-card>
        <v-card-title class="headline">
          {{title}}
        </v-card-title>
        <v-divider></v-divider>

       <v-card-text>
          <slot />
       </v-card-text>
            
        <v-divider></v-divider>

        <v-card-actions>
            <slot name="actions" />
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props:{
      value:{default:0},
      title:{default:''},
      width:{default:600}      
    },      
    methods: {
        handleInput (e) {
          this.$emit('input', !this.value )
        }
    }
  }
</script>