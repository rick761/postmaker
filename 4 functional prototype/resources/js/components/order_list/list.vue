<template>
    <card mb="mb-0" style="max-height:100vh; overflow-y:auto;" > 
        <v-card-text>
            {{title}}
            <explain v-if="tooltip != ''">
                 {{tooltip}}
            </explain> 
        </v-card-text>
        <slot />
    </card>
</template>

<script>
export default {
    props:{
        tooltip: {default:''},
        title:{
            default:'<title>'
        }
    }
}
</script>