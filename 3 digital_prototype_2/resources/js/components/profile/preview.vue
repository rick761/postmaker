<template>
    <div>   
         <v-card outlined class="mb-1"><v-card-title><v-icon>mdi-eye</v-icon> &nbsp; Preview</v-card-title></v-card>
            <v-card 
            class="mx-auto mb-5"                    
        >
            <v-list-item>
                <v-list-item-avatar color="grey">  
                <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    alt="John"
                ></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">
                        <span v-if="auth.display_name && auth.display_name.length > 5">{{auth.display_name}}</span>
                        <span v-else>{{auth.first_name}} {{auth.last_name}}</span>
                    </v-list-item-title>
                    <v-list-item-subtitle>{{auth.type}}</v-list-item-subtitle>
                </v-list-item-content>
                
            </v-list-item>
            

            <v-carousel height="200" >
                 <v-carousel-item
                    v-for="(item,i) in [{
                            src: 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg',
                        }                                
                    ]"
                    :key="i"
                    :src="item.src"
                    reverse-transition="fade-transition"
                    transition="fade-transition"
                ></v-carousel-item>                                        
            </v-carousel>                         

            <v-list-item>                                    
                <v-list-item-title>
                    <v-icon :color="medalColor('bronze')">mdi-podium-bronze</v-icon>
                    <v-icon :color="medalColor('silver')">mdi-podium-silver</v-icon>
                    <v-icon :color="medalColor('gold')">mdi-podium-gold</v-icon>
                    <v-icon :color="medalColor('platinum')">mdi-podium</v-icon>
                </v-list-item-title>                          
                <v-list-item-subtitle class="text-right mt-3" >
                    <v-icon>mdi-thumb-up-outline</v-icon>
                    25
                </v-list-item-subtitle>
            </v-list-item>

            <v-card-text>
                {{auth.description}}
            </v-card-text>           

            <v-card-actions>                        
                <v-btn color="purple" text>Bekijk profiel</v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    icon
                    @click="preview_show = !preview_show"
                >
                    <v-icon>{{ preview_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </v-card-actions>

            <v-expand-transition>
                <div v-show="preview_show">
                    <v-list class="transparent">    
                        <v-list-item v-if="auth.company">                                    
                            <v-list-item-icon>
                                <v-icon>mdi-office-building</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Bedrijf</v-list-item-title>     
                            <v-list-item-subtitle class="text-right">
                                {{auth.company}}
                            </v-list-item-subtitle>
                        </v-list-item>

                        <v-list-item v-if="auth.website">                                    
                            <v-list-item-icon>
                                <v-icon>mdi-web</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>website</v-list-item-title>     
                            <v-list-item-subtitle class="text-right">
                                <a :href="auth.website">{{auth.website}}</a>
                            </v-list-item-subtitle>
                        </v-list-item>
                                                            
                            <v-carousel height="200" v-if="project_show" >
                                <v-carousel-item
                                    v-for="(item,i) in [{
                                            src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                                        },
                                        {
                                            src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                                        },
                                        {
                                            src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                                        },                                               
                                    ]"
                                    :key="i"
                                    :src="item.src"
                                    reverse-transition="fade-transition"
                                    transition="fade-transition"
                                ></v-carousel-item>                                        
                            </v-carousel>                             
                    </v-list>
                </div>
            </v-expand-transition>
        </v-card>
    </div>
</template>


<script>
import { mapState } from 'vuex';
export default {
    methods:{
        medalColor(medal){
            if(medal == 'bronze')
                return 'brown lighten-2';
            if(medal == 'silver')
                return 'gray lighten-2';
            if(medal == 'gold')
                return 'yellow lighten-1';
            if(medal == 'platinum')
                return 'cyan lighten-3';
        }
    },
    computed:{
        ...mapState({                
            auth: state => state.auth.user,
        }),
    },
    
    data(){return{
        preview_show:true,    
        project_show:false,
    }}    
}
</script>