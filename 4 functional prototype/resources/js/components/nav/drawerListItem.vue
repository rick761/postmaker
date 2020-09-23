<template>
    <v-list-item 
    link 
    :to="link"
    style="color:white"
    >
        <v-list-item-icon>             
            <v-badge 
            v-if="badge != '0'" 
            :content="badge" 
            :color="badgeColor"
            overlap bottom
            >
                <v-icon>
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
                <span class="float-right" :class="badgeColor+'--text'" > 
                    <slot />
                </span>
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