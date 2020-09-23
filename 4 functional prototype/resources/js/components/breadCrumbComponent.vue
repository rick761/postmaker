<template> 
      
           <card mb="mb-0 pl-5 pr-5" >
          <v-row>  
            <v-col>       
                   
              <v-breadcrumbs 
                class="d-inline-block pa-0 pt-2"
                v-if=" this.$route.path == '/' " 
                :items="[default_crumbs]" 
                large
              />     
                
              <v-breadcrumbs 
              class="d-inline-block pa-0 pt-2"
              v-else
                :items="[default_crumbs, current_crumb ]" 
                large 
              /> 
               
              
            </v-col> 
            <v-col>
              <slot/>
            </v-col>
          </v-row> 
          </card>
             
             
</template>

<script>
  export default {

    props: {         
        current : { default: ''}        
    },

    data: () => ({
        default_crumbs:{
            text: 'Home',
            disabled: false,
            to: '/',
        },              
        prev_route_name : null,
        prev_route_path : null
      }
    ),

    computed: {
      current_crumb(){
        return {text:this.$route.name,disabled: false};
      },
      special_crumb(){       
         return { text:  this.prev_route_name, to:  this.prev_route_path}
      },
      special_crumb_exists(){
        if(this.prev_route_name && this.prev_route_path){
          return 1;
        }
        return 0;
      },
      special_crumb_route(){
        return this.$route.name == 'Account';
      }
    },

    updated(){      
      this.prev_route_name = localStorage.getItem('last_route_name');
      this.prev_route_path = localStorage.getItem('last_route_path');
    }

    


  

   
    
  }


</script>