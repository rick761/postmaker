<template>    
        <v-row>              

            <v-col cols=12>
                <v-card outlined>
                    <v-card-text>Welkom {{ auth.type }} {{auth.first_name}} {{auth.last_name}}, <br> </v-card-text>
                </v-card>
            </v-col>       

            <v-col cols=4>
                <v-sheet 
                    class="justify-center align-center white--text h2 d-flex "
                    color="green lighten-3"
                    height="200"
                 > 0 Projecten mee bezig 
                 <br>                 
                 </v-sheet>
            </v-col>

            <v-col cols=4>
                     <v-sheet
                    class="justify-center align-center  white--text d-flex h2"                    
                    color="blue lighten-3"
                    height="200"
                >0 berichten</v-sheet>
            </v-col>
            <v-col cols=4>
                     <v-sheet
                    class="justify-center align-center white--text d-flex  h2"
                    color="red lighten-3"
                    height="200"
                >0 Acties vereist</v-sheet>
            </v-col>   

            <v-col cols=12>
                <v-btn x-large to="/open" class="primary"> <v-icon>mdi-magnify</v-icon> </v-btn>                 
                <v-btn v-if="auth.type=='requester'" x-large to="/requester/order/new" class="success ml-3"> <v-icon>mdi-plus</v-icon> &nbsp; Nieuwe post aanmaken </v-btn>                    
            </v-col>          

        </v-row>    


</template>

<script>
import {mapState} from 'vuex'
export default {    
    computed:{
        ...mapState({                
            auth: state => state.auth.user,
        }),
    }
}
</script>