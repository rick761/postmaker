<template>
    <!-- delete -->
    <v-list-item>                               
        <v-list-item-content class="pl-15 pr-15 pt-0 pb-0">   
            <v-alert :type="getAlertType(item.state)" >
                <span v-if="item.state =='progress'">Wacht op een oplevering.</span>
                <span v-if="item.state =='delivered'">Keur de oplevering.</span>
                <span v-if="item.state =='delivery_accept'">Wacht op de factuur en oplevering van de postmaker</span>
                <span v-if="item.state =='recieved_payment'">U kunt het project archiveren</span>
                <span v-if="item.state =='quit_postmaker'">Neem contact op met postmaker of stop het project</span>          
            </v-alert>
        </v-list-item-content>
    </v-list-item> 
    
</template>

<script>
export default {
    props:['item'],
    methods:{
        getAlertType(status){            
            if(status == 'progress')
                return 'info';
            if(status == 'delivered')                
                return 'warning'
            if(status == 'delivery_accept')
                return 'success';            
            if(status == 'recieved_payment')
                return 'success';            
            if(status == 'quit_postmaker')
                return 'error';            
        },
    }
}
</script>