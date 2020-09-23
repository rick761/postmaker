<template>      
        <v-row>
           
            <v-col cols=12>
                <order-list-component title="Succesvol afgerond">
                    <order-list-item-component v-for="(item,key) in recieved_payment" :item="item" :key="key" >
                        <order-open-list-item-component :item="item"  />   
                        <order-account-list-item-component :item="item" />
                    </order-list-item-component>  
                    <v-card-text v-if="recieved_payment.length == 0">
                        Er zijn geen succcesvol afgeronde opdrachten.
                    </v-card-text>   
                </order-list-component>     
            </v-col>

            
            <v-col cols=12 sm=4 v-if=" recieved_payment.length > 0" >
                <v-sheet 
                    class="justify-center align-center white--text h2 px-10 d-flex "
                    color="primary lighten-1"
                    height="200"
                 > {{ recieved_payment.length }}  Afgerond </v-sheet>
            </v-col>

             <v-col cols=12 sm=4 v-if="(quit_postmaker.length ) > 0">
                     <v-sheet
                    class="justify-center align-center white--text d-flex px-10 h2"
                    color="primary lighten-1"
                    height="200"
                >{{ quit_postmaker.length }} Gestopt door postmaker </v-sheet>
            </v-col>
            
            <v-col cols=12 sm=4 v-if="( quit.length + removed.length ) > 0">
                     <v-sheet
                    class="justify-center align-center white--text d-flex px-10  h2"
                    color="primary lighten-1"
                    height="200"
                >{{ quit.length + removed.length}} Gestopt / verwijderd</v-sheet>
            </v-col>
            
            <v-col cols=12 md=4 v-if="quit.length">                

                <order-list-component  title="Gestopt">
                    <order-list-item-component v-for="(item,key) in quit" :item="item" :key="key" >
                        <order-open-list-item-component :item="item"  />   
                        <order-account-list-item-component :item="item" />
                    </order-list-item-component>  
                </order-list-component>  

            </v-col>
             <v-col cols=12 md=4 v-if="quit_postmaker.length">                

                <order-list-component title="Gestopte postmaker">
                    <order-list-item-component v-for="(item,key) in quit_postmaker" :item="item" :key="key" >
                        <order-open-list-item-component :item="item"  />   
                        <order-account-list-item-component :item="item" />
                    </order-list-item-component>  
                </order-list-component>  

            </v-col>
            <v-col cols=12 md=4 v-if="removed.length">                

                <order-list-component title="Verwijderd">
                    <order-list-item-component v-for="(item,key) in removed" :item="item" :key="key" >
                        <order-open-list-item-component :item="item"  /> 
                        <order-account-list-item-component :item="item" />
                    </order-list-item-component>  
                </order-list-component>  

            </v-col>

             
            
        </v-row>

</template>
<script>
import {mapState} from 'vuex';
export default {   
     computed:{
        ...mapState({        
            archived: state => state.orders.archived,
        }),
        removed(){
            if(this.archived)
                return this.archived.filter(item => item.state == 'removed');
        },
        quit(){
            if(this.archived)
                return this.archived.filter(item => item.state == 'quit');
        },
        quit_postmaker(){
            if(this.archived)
                return this.archived.filter(item => item.state == 'quit_postmaker');
        },
        recieved_payment(){
            if(this.archived)
                return this.archived.filter(item => item.state == 'recieved_payment');
        },
    },
    data(){return{
        successfull_items:[
            {title:'Foto opdracht',icon:'mdi-camera-outline'},        
        ],
        stopped_items:[            
            {title:'Tekenen',icon:'mdi-draw'},                     
        ],
    }},
    created(){        
        this.$store.dispatch('orders/getArchived');
    }
}
</script>