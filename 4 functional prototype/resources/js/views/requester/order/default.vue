<template>    
    <v-row>
        <v-col cols="12" md="8">   
            <project-progress />  
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
        
        <order-delivery-open-component />
    </v-row>    
</template>

<script>
  export default { 
    created(){         
        this.$store.dispatch('order/get',this.$route.params.orderId);          
    }    
  }
</script>
