<template>
    <span v-if="0"></span>
    <!-- <v-list-item >
        <a @click="loadUser">
            <v-icon>mdi-account</v-icon>                                              
            Test User                   
            {{item}}                  
        </a>
    </v-list-item> -->
</template>

<script>
export default {
    props:['item'],
    methods:{
        loadUser(){            
            //:to="'/account/'+order.postmaker.id"
            //this.$router.push('')
        },
    }
}
</script>