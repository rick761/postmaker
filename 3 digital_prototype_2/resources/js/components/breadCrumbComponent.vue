<template> 
        <v-row>
            <v-col cols=12>
                <v-card flat tile outlined>

                    <v-breadcrumbs 
                    v-if=" this.$route.path == '/' " 
                    :items="[default_crumbs]" 
                    large />
                    
                    <v-breadcrumbs 
                    v-if=" this.$route.path !== '/' " 
                    :items="[default_crumbs, {text:this.$route.name} ]" 
                    large />     

                </v-card>  
            </v-col>   
        </v-row>
</template>

<script>
  export default {
    props: {         
        current : { default: ''}
    },
    data: () => ({
      default_crumbs:         
        {
            text: 'Home',
            disabled: false,
            to: '/',
        }           
    }),
    
  }


</script>