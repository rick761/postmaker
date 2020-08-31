<template>
    <card mb="mb-0" style="max-height:100vh; overflow-y:auto;" > 
        <v-card-text>
            {{title}}
        </v-card-text>
        <slot />
    </card>
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