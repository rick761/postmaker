<template>
    <div>       
        <v-list-group v-model="active"  >                        
            <template v-slot:activator> 

                <!-- <v-list-item-icon>                    
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
                </v-list-item-icon> -->
                
                <v-list-item-icon>                                           
                    <v-icon color="accent" >mdi-{{item.type}}</v-icon>                                       
                </v-list-item-icon>            

                <v-list-item-content>     
                    <!-- <v-btn @click="loadOrder" text left class="text-left" >                                       -->
                        {{item.title}} 
                        <v-spacer />

                        <span :class="{                                
                                'error--text': dateDiffInDays(item.deliver) <= 10, 
                                'warning--text': dateDiffInDays(item.deliver) > 10 && dateDiffInDays(item.deliver) <= 20, 
                                'primary--text': dateDiffInDays(item.deliver) > 20 && dateDiffInDays(item.deliver) <= 30,
                                '': dateDiffInDays(item.deliver) > 30 
                                } ">
                             <v-icon small>mdi-calendar</v-icon>             
                             <small>{{item.deliver}} - Verwacht in {{dateDiffInDays(item.deliver)}} dagen.   </small>
                        </span>                                                               
                    <!-- </v-btn>      -->
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
    methods:{    
        dateDiffInDays(b) {            
            var international_date = b.split('-')
            
            const _MS_PER_DAY = 1000 * 60 * 60 * 24;
            const utc1 = new Date();//Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
            const utc2 = new Date(`${international_date[2]}-${international_date[1]}-${international_date[0]}`);          
            return Math.floor((utc2 - utc1) / _MS_PER_DAY);
        }
    }
}
</script>