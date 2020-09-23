<template>
    <v-list-item 
    link 
    :to="link"
    style="color:white"
    class="ma-0"
    >
        <v-list-item-icon>             
            <v-badge             
            :content="badge" 
            :color="badgeColor"
            overlap left   
            :value="badge!=0 && shown "         
            
            >
                <v-icon>
                    {{icon}} 
                </v-icon>
            </v-badge>
        </v-list-item-icon>

        <v-list-item-content>
            <v-list-item-title>{{text}}</v-list-item-title>
        </v-list-item-content>

                
        <v-list-item-action>
            <v-chip
                class="ma-0" small
                :color="badgeColor"
                text-color="white"
                v-if="badge!=0"
            >
                {{badge}}                   
            </v-chip>     
        </v-list-item-action>
        
    </v-list-item>
</template>

<script>
export default {
    props:{
        link: {default:'/'},
        icon: {default:''},
        text: {default:''},
        badge: {default:'0'},
        badgeColor: {default:'accent'},
        shown: {default:true}
    }
}
</script>