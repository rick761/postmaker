<template>  
    <v-row>           
        <v-col cols=12 md=8>
            <order-delivery-component />
            <order-info-component />
            <order-extra-description-component />
            <order-chatbox-component />   
        </v-col>  

        <v-col cols=12 md=4>
            <order-actions-component />  
            <order-aside-component />  
            <order-accepted-request-component />   
            <order-files-moodboard-component /> 
        </v-col>    
        
        <order-delivery-final-component />
        <order-delivery-open-component />        
        <order-delivery-new-component />       
         
    </v-row>    
</template>

<script>
  export default {    
      data(){return{
          files:[]
      }},
      created(){         
        this.$store.dispatch('order/get',this.$route.params.orderId);          
      } 
  }
</script>