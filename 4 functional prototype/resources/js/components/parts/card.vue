<template>
    <v-card          
        tile        
        :class="getClass"
        :color="color"
        :dark="(color != '0')"
        :style="{
            background: $vuetify.theme.currentTheme.background_card,
            height: height
        }"

        transition="slide-x-transition"
        
     > 
        <div class="float-right mt-4 mr-3" v-if="!(toggle===0)">
            <v-btn icon>
                <v-btn icon v-if="toggle_display" @click="toggle_display = !toggle_display"><v-icon>mdi-chevron-down</v-icon></v-btn>
                <v-btn icon v-if="!toggle_display"  @click="toggle_display = !toggle_display"><v-icon>mdi-chevron-up</v-icon></v-btn>
             </v-btn> 
        </div>
        <div :class="{toggle_close:toggle_display}" >
            <slot />
        </div>        

    </v-card>    
</template>
<script>
export default {
    props:{
        height: { default: 'auto' },
        mb: { default: 'mb-5' },
        noflex: {  default: 0  },
        color:{ default: "0"},
        toggle:{default:0}
    },
    computed: {
        getClass(){            
            if(!(this.noflex != 0)){
                return this.mb;
            }
            return this.mb+' d-flex flex-column';
        }
    },
    data(){return{
        toggle_display:false,
    }}       
    
}
</script>

<style scoped>
    .toggle_close{
        max-height:60px;
        overflow:hidden;
    }
</style>
