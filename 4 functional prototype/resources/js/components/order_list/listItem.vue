<template>
    <div>       
        <v-list-group v-model="active"  >                        
            <template v-slot:activator> 

                <v-list-item-icon>                    
                    <v-badge  
                        v-if="item.state == 'create'"                        
                        icon="mdi-pencil-outline"  
                        color='warning'                      
                    > <v-icon>mdi-creation</v-icon> </v-badge> 

                     <v-badge  
                        v-if="item.state == 'open'"                        
                        icon="mdi-timer-sand"  
                        color='success'                      
                    > <v-icon>mdi-comment-search</v-icon></v-badge> 
                </v-list-item-icon>
                
                <v-list-item-icon>                                           
                    <v-icon >mdi-{{item.type}}</v-icon>                                       
                </v-list-item-icon>            

                <v-list-item-content>     
                    <v-btn @click="loadOrder" text left class="text-left" >                                      
                        {{item.title}} 
                        <v-spacer />
                        <span :class="{
                                'error--text': dateDiffInDays(item.deliver) <= 10, 
                                'warning--text': dateDiffInDays(item.deliver) > 10 && dateDiffInDays(item.deliver) <= 20, 
                                'primary--text': dateDiffInDays(item.deliver) > 20 && dateDiffInDays(item.deliver) <= 30,
                                'success--text': dateDiffInDays(item.deliver) > 30 
                                } ">
                             <v-icon>mdi-calendar</v-icon>             
                             {{dateDiffInDays(item.deliver)}}                
                        </span>                                                               
                    </v-btn>     
                </v-list-item-content>                   

            </template>
            <v-list>              
                <slot />  
            </v-list>        
        </v-list-group>
    </div>
</template>

<script>
export default {
    props: {
        item : {
            default: {                     
                icon: 'mdi-circle-medium',
                title: '<title>',
                deliver: false,
                id: null,                            
            }            
        },        
    },
    data(){return{
        active:0
    }},
    computed: {
        // status(){ return 'mdi-creation'},
        // badge(){ return true; },
        // badgeIcon(){ return 'mdi-alert-outline' },
        // badgeColor(){ return 'warning'; },
        // badgeText(){ return''; }
    },
    methods:{
        loadOrder(){            
            this.$store.dispatch('order/get', this.item.id)
        },
        // getStateIcon(status){
        //     if(status == 'progress')
        //         return 'mdi-progress-wrench';
        //     if(status == 'delivered')                
        //         return 'mdi-progress-upload'
        //     if(status == 'delivery_accept')
        //         return 'mdi-progress-check';            
        //     if(status == 'recieved_payment')
        //         return 'mdi-checkbox-marked-circle-outline';            
        //     if(status == 'quit_postmaker')
        //         return 'mdi-progress-close';                       
        // },

        // getStateIconColor(status){
        //     if(status == 'progress')
        //         return 'primary';
        //     if(status == 'delivered')                
        //         return 'warning'
        //     if(status == 'delivery_accept')
        //         return 'success';            
        //     if(status == 'recieved_payment')
        //         return 'success';            
        //     if(status == 'quit_postmaker')
        //         return 'error';                
        // },

        dateDiffInDays(b) {            
            const _MS_PER_DAY = 1000 * 60 * 60 * 24;
            const utc1 = new Date();//Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
            const utc2 = new Date(b);          
            return Math.floor((utc2 - utc1) / _MS_PER_DAY);
        }
    }
}
</script>