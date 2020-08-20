<template>
    <card mb="mb-0"  > 
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