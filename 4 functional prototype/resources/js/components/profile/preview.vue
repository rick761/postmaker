<template>
    <div> 
        <!-- <card><v-card-title><v-icon>mdi-eye</v-icon> &nbsp; Preview</v-card-title></card> -->
        <card 
            class="mx-auto mb-5"                    
        >
            <v-list-item>
                <v-list-item-avatar color="grey" v-if="auth.avatar">  
                    <img
                        :src="'./storage/'+auth.id+'/avatar/'+auth.avatar"                    
                    >
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title class="headline">
                        {{auth.display_name}}                        
                    </v-list-item-title>
                    <v-list-item-subtitle>{{auth.type}}</v-list-item-subtitle>
                </v-list-item-content>
                
            </v-list-item>
            

            <v-carousel v-if="auth.user_images && auth.user_images.length" height="200" >
                 <v-carousel-item @click="$store.dispatch('image/preview','./storage/'+auth.id+'/user_images/'+item.url)"
                    v-for="(item,i) in auth.user_images"
                    :key="i"
                    :src="'./storage/'+auth.id+'/user_images/'+item.url"
                    reverse-transition="fade-transition"
                    transition="fade-transition"
                ></v-carousel-item>                                        
            </v-carousel>                         

            <!--gamification-->
            <v-list-item >                                    
                <!-- <v-list-item-title>
                    <v-icon :color="medalColor('bronze')">mdi-podium-bronze</v-icon>
                    <v-icon :color="medalColor('silver')">mdi-podium-silver</v-icon>
                    <v-icon :color="medalColor('gold')">mdi-podium-gold</v-icon>
                    <v-icon :color="medalColor('platinum')">mdi-podium</v-icon>
                </v-list-item-title> -->
                <v-list-item-subtitle class="text-right mt-3" >
                    <v-icon>mdi-thumb-up-outline</v-icon>                    
                    <span>{{auth.user_likes_count}}</span>
                </v-list-item-subtitle>
            </v-list-item>

            <!--description-->
            <v-card-text>
                {{auth.description}}
            </v-card-text>      

            <!--COMPANY AND WEBSITE-->
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
            </v-list>

            <v-card-actions>                        
                <v-btn color="purple" :to="'/account/'+auth.id" text>Bekijk profiel</v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="auth.type == 'postmaker'"
                    icon
                    @click="preview_show = !preview_show"
                >
                    <v-icon>{{ preview_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                </v-btn>
            </v-card-actions>

            <v-expand-transition>
                    
                <v-card-text v-if="preview_show" > 
                    <!-- Geen gearchiveerde documenten om weer te geven.   -->
                    <v-row>
                        <v-col
                            v-for="(item,key) in user_show_deliverys"
                            :key="key"
                            cols="6"
                        >
                            <v-img
                                class="d-flex align-center"
                                dark
                                height="200"
                                :src="`./storage/${auth.id}/order_delivery/${item.order_delivery_file.order_delivery.order_id}/${item.order_delivery_file.url}`"
                            />

                        </v-col>                        
                    </v-row>                    

                </v-card-text>  
                
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
            auth: state => state.auth.user,
            user_show_deliverys : state => state.auth.archivedDelivery.data
        }),
    },
    
    data(){return{
        preview_show:false,    
        project_show:false,
    }}    
}
</script>