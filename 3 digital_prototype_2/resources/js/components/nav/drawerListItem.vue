<template>
    <v-list-item 
    link 
    :to="link"
    >
        <v-list-item-icon>             
            <v-badge 
            v-if="badge != '0'" 
            :content="badge" 
            :color="badgeColor"
            overlap
            >
                <v-icon  medium>
                    {{icon}}
                </v-icon>
            </v-badge>

            <v-icon 
            v-else 
            medium
            >
                {{icon}}
            </v-icon>    

        </v-list-item-icon>

        <v-list-item-content>

            <v-list-item-title>
                {{text}}
            </v-list-item-title>

        </v-list-item-content>

    </v-list-item>
</template>

<script>
export default {
    props:{
        link: {default:'/'},
        icon: {default:''},
        text: {default:''},
        badge: {default:'0'},
        badgeColor: {default:'orange'}
    }
}
</script>