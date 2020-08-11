<template>
    <v-row>
        <v-col>
            <v-row>
                <v-col>
                    <v-sheet dark class="pa-5" elevation=1 color="green lighten-3" >                        
                        {{ moneyCount }} euro <span v-if="authUser.type =='Contentaanvrager' ">uitgegeven</span> <span v-else>verdiend</span> 
                    </v-sheet>                    
                </v-col>

                <v-col>
                    <v-sheet dark class="pa-5" elevation=1 color="purple lighten-3">
                        {{orders_archived.length}} projecten gearchiveerd
                    </v-sheet>
                </v-col>
            </v-row>
            <v-list>                
                <v-list-item v-for="(item,key) in orders_archived" :key="key">                                

                    <v-list-item-title>{{item.title}}</v-list-item-title>
                    <v-list-item-subtitle>{{formatDate(item.created_at)}} - {{formatDate(item.deliver)}}</v-list-item-subtitle>   
                    <v-list-item-subtitle>{{item.deliverys.length}} opleveringen</v-list-item-subtitle>                    

                    <v-btn :to="'/order/'+item.id" dark class="primary" icon>
                        <v-icon>mdi-eye</v-icon>
                    </v-btn>

                </v-list-item>
            </v-list>            
        </v-col>
    </v-row>
    
</template>

<script>
import { mapState } from 'vuex';
export default {
    created(){
        this.$store.dispatch('orders/archivedOrders');
    } ,
    computed:{
        ...mapState({
            orders_archived : state=> state.orders.orders_archived,
            authUser : state=> state.auth.user,
        }),
        moneyCount(){
            var money = 0;            
            if(this.orders_archived){
                var list = this.orders_archived.filter(item=>item.postmaker_state = 'payed');
                for(var i in list){
                    if(!isNaN(parseInt(list[i].payment)))
                        money += parseInt(list[i].payment);                                    
                }            
            }
            return money;
        }        
    },
    methods:{
        formatDate(string){
            const _date = new Date(string);
            return _date.getDate()+'-'+_date.getMonth()+'-'+_date.getUTCFullYear();      
      },
    }
}
</script>

<style scoped>

</style>