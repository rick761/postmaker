<template>    
    <v-list-item three-line  :to="'/account/'+item.postmaker_id" >

    

    <v-list-item-avatar class="ml-16" v-if="item.postmaker.avatar" >
        <v-img :src="'./storage/'+item.postmaker.id+'/avatar/'+item.postmaker.avatar"></v-img>
    </v-list-item-avatar> 

    <v-list-item-content :class="{'ml-16': !item.postmaker.avatar}">
        <v-list-item-title>
            Aanvraag
            <span class="warning--text" v-if="item.status == 'withrawn'">- Ingetrokken</span>
            <span class="success--text" v-if="item.status == 'open'"> - Openstaand</span>
            <span class="error--text" v-if="item.status == 'denied'"> - Afgewezen</span>
        </v-list-item-title>
        
        <v-list-item-subtitle>
            <b>{{item.postmaker.display_name}}</b> - {{item.text}}<br>
            <span class="primary--text">Prijs € {{item.payment}} </span>
        </v-list-item-subtitle>
    </v-list-item-content>

        

        <!-- <v-list-item-icon >              
            <v-spacer></v-spacer>                          
            &nbsp; &nbsp; Prijs &nbsp;{{item.payment}}
        </v-list-item-icon>  -->
        
</v-list-item>
    
</template>

<script>
export default {
    props:['item'],
    methods:{        
    }
}
</script>