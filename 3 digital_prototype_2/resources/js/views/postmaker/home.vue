<template>    
    <v-row>       
        <v-col cols=12 lg="12">                
            <order-list-component title="Bezig" >
                <order-list-item-component v-for="(item,key) in progressing_items" :item="item" :key="key" >
                    <order-account-list-item-component :item="item" />
                    <order-messages-list-item-component :item="item" />   
                </order-list-item-component>
            </order-list-component>
            
        </v-col>
        <v-col cols=12 lg="6" >  
            <order-list-component title="Ontvangen betaling">
                <order-list-item-component v-for="(item,key) in payed_items" :item="item" :key="key" >
                    <order-account-list-item-component :item="item" />
                    <order-messages-list-item-component :item="item" />                                              
                </order-list-item-component>      
            </order-list-component>
        </v-col>

         <v-col cols=12 lg="6" > 
            <order-list-component title="Ontvangen betaling">
                <order-list-item-component v-for="(item,key) in stopped_items" :item="item" :key="key" >
                    <order-account-list-item-component :item="item" />
                    <order-messages-list-item-component :item="item" />                                              
                </order-list-item-component>      
            </order-list-component>
         </v-col>         
    </v-row>    
</template>

<script>
export default {
    data(){return{   
        payed_items:[
            {title:'Foto opdracht',icon:'mdi-camera-outline'},        
        ],
        stopped_items:[            
            {title:'Tekenen',icon:'mdi-draw'},                     
        ],
        progressing_items:[
            {title:'Email templates',        icon:'mdi-draw',                state: 'progress',        deliver:'1 dag'},
            {title:'Natuurfotos',            icon:'mdi-camera-outline',      state: 'delivered',       deliver:'5 dagen'},
            {title:'Advertentie filmpje',    icon:'mdi-camcorder',           state: 'delivery_accept', deliver:'8 dagen'},
        ]
    }},
    methods:{
        log(value){
            console.log(value);
        },        
    }
}
</script>