<template>    
    <v-list-item :to="'/account/'+item.postmaker_id" >

        <v-list-item-avatar class="mt-6  ml-15" v-if="item.postmaker.avatar" >
             <v-img :src="item.postmaker.avatar"></v-img> &nbsp; {{item.postmaker.display_name}}  
        </v-list-item-avatar> 

        <v-list-item-icon class="mt-6  ml-15" v-else >                                                                          
            &nbsp; {{item.postmaker.display_name}}     
        </v-list-item-icon>     

        <v-list-item-content class="text-right">      
            <v-text-field v-if="item.text"  dense rounded single-line filled disabled v-model="item.text"></v-text-field>
            <i v-else>Er is geen motivatie aangegeven</i>                 
        </v-list-item-content> 

        <v-list-item-icon class="mt-6">              
            <v-spacer></v-spacer>                          
            &nbsp; &nbsp; Prijs &nbsp; <v-icon>mdi-currency-eur</v-icon> &nbsp;{{item.payment}}
        </v-list-item-icon> 
        
</v-list-item>
    
</template>

<script>
export default {
    props:['item'],
    methods:{        
    }
}
</script>