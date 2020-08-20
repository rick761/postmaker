<template>

    <!-- delete -->
    <v-list-item >        
        <v-list-item-icon class="mt-9  ml-15">                                                                          
            <v-icon>mdi-comment</v-icon>                                       
        </v-list-item-icon>         
        <v-list-item-content class="mt-4 d-flex align-center mr-4" >     
           
            <v-text-field
                placeholder="Geen motivatie aangegeven"
                dense rounded single-line filled disabled
                :value="item.text"
            ></v-text-field>

        </v-list-item-content>                                     
        <v-list-item-action class="mt-0">

                <!-- <v-btn icon dark class="success" :to=" '/open/order/' + item.order_id ">
                    <v-icon>mdi-arrow-right</v-icon>                    
                </v-btn> -->

                <v-alert dense text class="mt-4"  v-if="item.status == 'open'" type="success">
                        Aanvraag is geplaatst
                </v-alert>

                <v-alert dense text class="mt-4"  v-if="item.status == 'withrawn'" type="warning">
                        Aanvraag is ingetrokken
                </v-alert>

                <v-alert dense text class="mt-4"  v-if="item.status == 'denied'" type="error">
                        Aanvraag is afgewezen
                </v-alert>

            

        </v-list-item-action>        
    </v-list-item> 
    
</template>

<script>

    export default {
        props:['item'],    
    }

</script>