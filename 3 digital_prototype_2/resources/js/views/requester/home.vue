<template>    
        <v-row>

            <v-col cols=12 lg="6" >     
                <order-list-component title="In aanmaak">
                    <order-list-item-component v-for="(item,key) in new_items" :item="item" :key="key" >
                        <order-remove-list-item-component />
                    </order-list-item-component>      
                </order-list-component>                
            </v-col>

            <v-col cols=12 lg=6>
                <order-list-component title="Gepubliceerd">
                    <order-list-item-component v-for="(item,key) in open_items" :item="item" :key="key" > 
                        <order-remove-list-item-component />
                    </order-list-item-component>
                </order-list-component>
            </v-col>

            <v-col cols=12 lg="12"> 
                <v-card flat tile outlined>
                    <order-list-component title="In progressie">
                        <order-list-item-component v-for="(item,key) in progressing_items" :item="item" :key="key" >    
                            <order-account-list-item-component :item="item" />
                            <order-messages-list-item-component :item="item" />
                            <order-state-list-item-component :item="item" />
                        </order-list-item-component> 
                    </order-list-component>
                </v-card>  
            </v-col> 

        </v-row>                     
</template>
<script>
export default {
    data(){return{
        active_item:0,
        sort: 'alphabetical-descending',        
        new_items:[
            {title:'Foto opdracht', icon:'mdi-camera-outline'},
            {title:'Film sessie', icon:'mdi-camcorder'},
            {title:'Ontwerpen', icon:'mdi-draw'},
        ],
        open_items:[            
            {title:'Tekenen',icon:'mdi-draw'},
            {title:'Regisseren',icon:'mdi-camcorder' },
            {title:'Fotoshoot',icon:'mdi-camera-outline' },            
        ],
        progressing_items:[
            {title:'Email templates',        icon:'mdi-draw',                state: 'progress',                 deliver:'1 dag'},
            {title:'Natuurfotos',            icon:'mdi-camera-outline',      state: 'delivered',                deliver:'5 dagen'},
            {title:'Advertentie filmpje',    icon:'mdi-camcorder',           state: 'delivery_accept',          deliver:'8 dagen'},
            {title:'Restaurant fotos',       icon:'mdi-camera-outline',      state: 'recieved_payment',         deliver:'450 dagen'},
            {title:'Kleurplaat',             icon:'mdi-draw',                state: 'quit_postmaker',           deliver:'2 dagen'},
        ]
    }},
    methods:{
        log(value){
            console.log(value);
        },        
    }
}
</script>