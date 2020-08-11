<template>      
        <v-row>
                        
            <v-col cols=4>
                <v-sheet
                    class="justify-center align-center white--text h2 d-flex "
                    color="green lighten-3"
                    height="200"
                 > 1 afgerond </v-sheet>
            </v-col>
            <v-col cols=4>
                     <v-sheet
                    class="justify-center align-center  white--text d-flex h2"                    
                    color="blue lighten-3"
                    height="200"
                >2 euro omzet</v-sheet>
            </v-col>
            <v-col cols=4>
                     <v-sheet
                    class="justify-center align-center white--text d-flex  h2"
                    color="red lighten-3"
                    height="200"
                >3 Gestopt</v-sheet>
            </v-col>

            <v-col cols=6>
                <order-list-component title="Succesvol">
                    <order-list-item-component v-for="(item,key) in successfull_items" :item="item" :key="key" >
                        <order-account-list-item-component :item="item" />
                    </order-list-item-component>  
                </order-list-component>                  
            </v-col>

            <v-col cols=6>                

                <order-list-component title="Gestopt">
                    <order-list-item-component v-for="(item,key) in stopped_items" :item="item" :key="key" >
                        <order-account-list-item-component :item="item" />
                    </order-list-item-component>  
                </order-list-component>  

            </v-col>

        </v-row>

</template>
<script>

export default {   
    data(){return{
        successfull_items:[
            {title:'Foto opdracht',icon:'mdi-camera-outline'},        
        ],
        stopped_items:[            
            {title:'Tekenen',icon:'mdi-draw'},                     
        ],
    }}
}
</script>