<template>
    
    <v-tooltip  left>
        <template v-slot:activator="{ on, attrs }">                    
            <v-btn icon v-bind="attrs" v-on="on" :color="text" class="float-right">
                <span v-if="!icon">?</span>
                <v-icon v-else>{{icon}}</v-icon>
            </v-btn>
        </template>
        <span>            
            <slot/>
        </span>
    </v-tooltip>
    
</template>

<script>
export default {
    props:{
        text:{default:'accent'},
        icon:{default:false}
    }
}
</script>

