<template>
    <v-card          
        tile        
        :class="getClass"
        :style="{
            background: $vuetify.theme.currentTheme.background_card,
            height: height
        }"
        
     > 
        <slot />        
    </v-card>    
</template>
<script>
export default {
    props:{
        height: { default: 'auto' },
        mb: { default: 'mb-5' },
        noflex: {default: 0}
    },
    computed: {
        getClass(){            
            if(!(this.noflex != 0)){
                return this.mb;
            }
            return this.mb+' d-flex flex-column';
        }
    }       
    
}
</script>
