<template>
    <div> 
        <card class="mx-auto mb-5" >
            <v-card-subtitle>
                <a @click="$router.go(-1)"> <v-icon>mdi-keyboard-backspace</v-icon> Terug</a>
            </v-card-subtitle>
            <v-list-item>
                
                <v-list-item-avatar size="62" color="grey"  v-if="user && user.avatar">  
                    <img 
                        @click="$store.dispatch('image/preview','/storage/'+user.id+'/avatar/'+user.avatar)"
                        :src="'./storage/'+user.id+'/avatar/'+user.avatar"
                        :alt="'Error'"
                    >
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title class="headline">
                        <span v-if="user.display_name && user.display_name.length > 5">{{user.display_name}}</span>
                        <span v-else>{{user.first_name}} {{user.last_name}}</span>
                    </v-list-item-title>
                    <v-list-item-subtitle>{{user.type}}</v-list-item-subtitle>
                </v-list-item-content>
                
            </v-list-item>
            

            <v-carousel v-if="user && user.user_images && user.user_images.length" style="min-height:350px;" >
                 <v-carousel-item @click="$store.dispatch('image/preview','./storage/'+user.id+'/user_images/'+item.url)"
                    v-for="(item,i) in user.user_images"
                    :key="i"
                    :src="'./storage/'+user.id+'/user_images/'+item.url"
                    reverse-transition="fade-transition"
                    transition="fade-transition"
                ></v-carousel-item>                                        
            </v-carousel>                         

            <v-list-item >                                    
                <v-list-item-title style="display:none;">
                    <v-icon :color="medalColor('bronze')">mdi-podium-bronze</v-icon>
                    <v-icon :color="medalColor('silver')">mdi-podium-silver</v-icon>
                    <v-icon :color="medalColor('gold')">mdi-podium-gold</v-icon>
                    <v-icon :color="medalColor('platinum')">mdi-podium</v-icon>
                </v-list-item-title>                          
                <v-list-item-subtitle class="text-right mt-3" >
                    <v-icon>mdi-thumb-up-outline</v-icon>
                    {{user.user_likes_count}}
                </v-list-item-subtitle>
            </v-list-item>

            <v-card-text>
                {{user.description}}
            </v-card-text>           

            <v-list class="transparent">    
                <v-list-item v-if="user.company">                                    
                    <v-list-item-icon>
                        <v-icon>mdi-office-building</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Bedrijf</v-list-item-title>     
                    <v-list-item-subtitle class="text-right">
                        {{user.company}}
                    </v-list-item-subtitle>
                </v-list-item>

                <v-list-item v-if="user.website">                                    
                    <v-list-item-icon>
                        <v-icon>mdi-web</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>website</v-list-item-title>     
                    <v-list-item-subtitle class="text-right">
                        <a :href="user.website">{{user.website}}</a>
                    </v-list-item-subtitle>
                </v-list-item>
            </v-list>

            <v-card-actions>          
                <v-spacer></v-spacer>  
                <v-btn text @click="preview_show = !preview_show" >{{preview_show ? 'Minder': 'Meer'}}</v-btn>             
                <v-btn
                    icon
                    @click="preview_show = !preview_show"
                >                    
                    <v-icon>{{ preview_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </v-card-actions>

            <v-expand-transition>
                <div v-show="preview_show">                                                            
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
                    <v-card-text v-else> Geen documenten om weer te geven. </v-card-text>  
                </div>
            </v-expand-transition>
        </card> 
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
        },
        preview(url){
            this.$store.dispatch('image/preview',url);     
        }
    },

    computed:{
        ...mapState({                
            user: state => state.user.data,
        }),
    },

    created(){     
        this.$store.commit('user/CLEAR_USER');
        this.$store.dispatch('user/get_',this.$route.params.user_id);
    },

    
    data(){return{
        preview_show:false,    
        project_show:false,
    }}    
}
</script>