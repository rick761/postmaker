<template>
    <card >    
        <v-card-text>
                Er zijn geen berichten {{messages}}
        </v-card-text>
        <v-card-actions>          
            <v-text-field  class="ml-2"       
                label="Message"
                required
            ></v-text-field>                
            <v-btn icon dark class="ml-2 primary">
                <v-icon>mdi-send</v-icon>
            </v-btn>
            <v-btn icon dark class="ml-2 mr-2 primary">
                <v-icon>mdi-file</v-icon>
            </v-btn>
        </v-card-actions>
    </card>
</template>

<script>
import {mapState} from 'vuex'
export default {
    computed:{
        ...mapState({
            messages : state => state.order.messages
        })
    }
}
</script>
