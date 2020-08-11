<template>      
    <v-row>
        <v-col cols=12>
            <order-list-component title="Aanvragen">
                <order-list-item-component v-for="(item,key) in requested_items" :item="item" :key="key" >
                    <order-request-confirm-list-item-component :item="item" />
                </order-list-item-component>  
            </order-list-component>           
        </v-col>            
    </v-row>      
</template>

<script>
export default {
    data(){return{
         requested_items:[
            {active: true,text:'Email templates',  icon:'mdi-draw',         order_requests:{motivation:'Graag maak ik deze opdracht, zie mijn profiel voor referentie'}},
            {title:'Natuurfotos',            icon:'mdi-camera-outline',     order_requests:{ motivation:'blablah blabla'}},
            {title:'Advertentie filmpje',    icon:'mdi-camcorder',          order_requests:{motivation:' blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla'}},
            {title:'Restaurant fotos',       icon:'mdi-camera-outline',     order_requests:{motivation:' blabla blabla blabla blabla blabla'}},
            {title:'Kleurplaat',             icon:'mdi-draw',               order_requests:{motivation:' blabla blabla blabla blabla blabla blabla'}},
        ]
    }}
}
</script>