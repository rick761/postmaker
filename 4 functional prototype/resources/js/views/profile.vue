<template>      
        <v-row>
            <v-col cols="6">                
                <edit-profile-component />                
            </v-col>

            <v-col cols="6">
               <preview-profile-component />
               <portfolio-profile-component class="d-none" />
            </v-col>
        </v-row>      
</template>
<script>
export default {
    data(){return{        
    }},
}
</script>