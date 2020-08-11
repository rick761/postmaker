<template>
    <v-card outlined >  

        <v-card-text>
            {{title}}
        </v-card-text>

        <slot />


    </v-card>
</template>

<script>
export default {
    props:{
        title:{
            default:'<title>'
        }
    }
}
</script>