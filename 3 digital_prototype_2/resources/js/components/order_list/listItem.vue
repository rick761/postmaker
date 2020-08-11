<template>
    <div>        
        <v-list-group v-model="item.active"  >                        
            <template v-slot:activator> 
                
                <v-list-item-icon>                                           
                    <v-icon v-text="item.icon"></v-icon>                                       
                </v-list-item-icon>

                

                <v-list-item-content>     
                    <v-btn  :to="'/order/'+item.id" text left class="text-left" >                                      
                        {{item.title}} <v-spacer /> {{item.deliver}}                                                                      
                    </v-btn>     
                </v-list-item-content>   

                <v-list-item-icon>

                    <!--project status -->
                     <v-badge 
                        v-if="badge != false"                         
                        :color="badgeColor"
                        :content="badgeText"
                        :icon="badgeIcon"                        
                    >        
                        <v-icon >{{status}}</v-icon>
                    </v-badge> 

                </v-list-item-icon>

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
                active: 0,                
                icon: 'mdi-circle-medium',
                title: '<title>',
                deliver: false,
                id: null,                            
            }            
        }
    },
    computed: {
        status(){ return 'mdi-creation'},
        badge(){ return true; },
        badgeIcon(){ return 'mdi-alert-outline' },
        badgeColor(){ return 'warning'; },
        badgeText(){ return''; }
    },
    methods:{
        getStateIcon(status){
            if(status == 'progress')
                return 'mdi-progress-wrench';
            if(status == 'delivered')                
                return 'mdi-progress-upload'
            if(status == 'delivery_accept')
                return 'mdi-progress-check';            
            if(status == 'recieved_payment')
                return 'mdi-checkbox-marked-circle-outline';            
            if(status == 'quit_postmaker')
                return 'mdi-progress-close';                       
        },

        getStateIconColor(status){
            if(status == 'progress')
                return 'primary';
            if(status == 'delivered')                
                return 'warning'
            if(status == 'delivery_accept')
                return 'success';            
            if(status == 'recieved_payment')
                return 'success';            
            if(status == 'quit_postmaker')
                return 'error';                
        }
    }
}
</script>