<template>    
    <v-list-item to="/account" >
        <v-list-item-icon class="  ml-15">                                                                          
            <v-icon>mdi-account</v-icon>                                       
        </v-list-item-icon>        
        <v-list-item-content>                                        
            Test user <br> <i class="primary--text">{{item.motivation}}</i>                                 
        </v-list-item-content> 
        <v-list-item-action>
                <v-btn  class="success"><v-icon>mdi-account-check</v-icon> &nbsp; acccepteren</v-btn>
        </v-list-item-action>
        <v-list-item-action>
                <v-btn  class="error"><v-icon>mdi-account-remove</v-icon> &nbsp; weigeren</v-btn>
        </v-list-item-action>
</v-list-item>
    
</template>

<script>
export default {
    props:['item'],
    methods:{        
    }
}
</script>