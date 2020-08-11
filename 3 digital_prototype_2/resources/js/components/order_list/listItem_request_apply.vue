<template>

    <!-- delete -->
    <v-list-item >
        <v-list-item-icon class="mt-9  ml-15">                                                                          
            <v-icon>mdi-comment</v-icon>                                       
        </v-list-item-icon>         
        <v-list-item-content class="mt-4 d-flex align-center mr-4" >     
            <v-text-field
                label="Motivatie"
                outlined dense
            >{{item.motivation}}</v-text-field>
        </v-list-item-content>                                     
        <v-list-item-action class="mt-0">
                <v-btn  class="success"><v-icon>mdi-account-check</v-icon> &nbsp; aanpassen</v-btn>
        </v-list-item-action>
        <v-list-item-action class="mt-0">
                <v-btn  class="error"><v-icon>mdi-account-remove</v-icon> &nbsp; intrekken</v-btn>
        </v-list-item-action>
    </v-list-item> 
    
</template>

<script>
    export default {
        props:['item'],    
    }
</script>