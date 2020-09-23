<template>
    <v-list-item v-if="user"  :to="'/account/'+user.id">
        <v-list-item-avatar v-if="user.avatar" >
            <v-img  :src="'./storage/'+user.id+'/avatar/'+user.avatar" ></v-img>                                                
        </v-list-item-avatar>

        <v-list-item-icon v-else>
            <v-icon color="primary">mdi-account</v-icon>
        </v-list-item-icon>

        <v-list-item-content class="text-right" v-if="user.display_name" >
            <span class="float-right">{{user.display_name}}</span>
        </v-list-item-content>                        
    </v-list-item>
</template>

<script>
export default {
    props:['user']
}
</script>