<template>
    <v-container>
    <v-row v-if="$route.params.id == null">
        <v-col cols="6">            
            <v-card flat tile >
                <v-card-text>
                    
                    <br>
                    <v-text-field                        
                        name='first_name'                                             
                        label="Voornaam"   
                        v-model="first_name"   
                        disabled                    
                    ></v-text-field>

                    <v-text-field                        
                        name='last_name'                                         
                        label="Achternaam"  
                        v-model="last_name"    
                        disabled                      
                    ></v-text-field>

                    <v-text-field                        
                        name='phone'                                             
                        label="tel"     
                        v-model="phone"    
                        disabled                  
                    ></v-text-field>

                    <v-select     
                        disabled                  
                        label="type"
                        name="type"
                        v-model="type"   
                        :items="['Postmaker','Contentaanvrager']"                        
                    ></v-select>

                    <v-text-field
                        disabled
                        :value="authUser.email"
                        label="email"                        
                    ></v-text-field>

                </v-card-text>
                <v-card-actions>
                    <v-btn disabled   class="success">
                        Opslaan    
                    </v-btn>
                </v-card-actions>
           </v-card>
          

        </v-col>
        <v-col cols="6">
            <v-card flat tile >
                <v-card-text>
                        <v-card                            
                            tile
                        >
                            <v-img
                                height="100%"
                                src="https://picsum.photos/1920/1080?random&blur=2"
                                dark
                            >
                            <v-row
                            
                                align="end"
                                class="fill-height"
                            >
                                <v-col
                                align-self="start"
                                class="pa-0"
                                cols="12"
                                >
                                <v-avatar
                                    elevation="10"
                                    class="profile"
                                    color="grey"
                                    size="164"
                                    tile
                                >
                                    <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
                                </v-avatar>
                                </v-col>
                                <v-col class="py-0">
                                <v-list-item
                                    color="rgba(0, 0, 0, .4)"
                                    dark
                                >
                                    <v-list-item-content>
                                    <v-list-item-title class="title">{{authUser.first_name}}  {{authUser.last_name}}</v-list-item-title>
                                    <v-list-item-subtitle>{{authUser.type}}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                </v-col>
                            </v-row>
                            </v-img>
                            
                        </v-card>

                        <v-file-input disabled   class="mt-5"  accept="image/*" label="Verander profielfoto"></v-file-input>
                </v-card-text>
            </v-card>
        </v-col>

    </v-row>

    <v-row v-else>
        <v-col cols="12">
          
                    <v-row>

                    <v-col cols="6">

                        <v-card flat tile>
                            <v-card-text>
                                <v-simple-table >   
                                    <tbody>
                                        <tr v-if="profileUser.first_name">                
                                            <td>Naam</td>
                                            <td>
                                                {{profileUser.first_name}} {{profileUser.last_name}}
                                            </td>                        
                                        </tr>
                                        <tr v-if="profileUser.email">                    
                                            <td>Email</td>
                                            <td>
                                                {{profileUser.email}}
                                            </td>                    
                                        </tr>
                                        <tr v-if="profileUser.phone">            
                                            <td>Tel-nr</td>
                                            <td>                    
                                                {{profileUser.phone}}
                                            </td>                
                                        </tr>
                                        <tr v-if="profileUser.type">            
                                            <td>Type</td>
                                            <td>                    
                                                {{profileUser.type}}
                                            </td>                
                                        </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-card-text>
                        </v-card>
                        

                        </v-col>
                        <v-col cols="6">
                            <v-card flat tile >
                                <v-card-text>
                                        <v-card                            
                                            tile
                                        >
                                            <v-img
                                                height="100%"
                                                src="https://picsum.photos/1920/1080?random&blur=2"
                                                dark
                                            >
                                            <v-row
                                            
                                                align="end"
                                                class="fill-height"
                                            >
                                                <v-col
                                                align-self="start"
                                                class="pa-0"
                                                cols="12"
                                                >
                                                <v-avatar
                                                    elevation="10"
                                                    class="profile"
                                                    color="grey"
                                                    size="164"
                                                    tile
                                                >
                                                    <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
                                                </v-avatar>
                                                </v-col>
                                                <v-col class="py-0">
                                                <v-list-item
                                                    color="rgba(0, 0, 0, .4)"
                                                    dark
                                                >
                                                    <v-list-item-content>
                                                    <v-list-item-title class="title">{{profileUser.first_name}} {{profileUser.last_name}}</v-list-item-title>
                                                    <v-list-item-subtitle>{{profileUser.type}}</v-list-item-subtitle>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                </v-col>
                                            </v-row>
                                            </v-img>
                                            
                                        </v-card>                                        
                                </v-card-text>
                            </v-card>
                        </v-col>


                        <v-col cols="12">
                            <v-card tile flat>
                                <v-card-title>Projecten</v-card-title>
                                <v-card-text>
                                    <v-row>
                                        <v-col cols="4">
                                            <v-sheet
                                                class="h5 d-flex pa-10"
                                                color="yellow lighten-3"
                                                height="100"
                                            >121 projecten aangenomen</v-sheet>
                                        </v-col>
                                        <v-col cols="4"><v-sheet
                                                class="d-flex pa-10 h5"
                                                color="green lighten-3"
                                                height="100"
                                            >88 projecten afgerond </v-sheet>
                                        </v-col>
                                        <v-col cols="4"><v-sheet
                                                class="d-flex pa-10 h5"
                                                color="blue lighten-3"
                                                height="100"
                                            > Lid sinds 2020 </v-sheet>
                                        </v-col>
                                    </v-row>

                                    <v-row>
                                        <v-col cols="3"><v-img src="https://picsum.photos/1920/1080?random"/></v-col>
                                        <v-col cols="3"><v-img src="https://picsum.photos/1920/1080?random"/></v-col>
                                        <v-col cols="3"><v-img src="https://picsum.photos/1920/1080?random"/></v-col>
                                        <v-col cols="3" ><v-img src="https://picsum.photos/1920/1080?random"/></v-col>
                                    </v-row>

                                    <v-carousel>
                                        <v-carousel-item
                                        v-for="(item,i) in items"
                                        :key="i"
                                        :src="item.src"
                                        reverse-transition="fade-transition"
                                        transition="fade-transition"
                                        ></v-carousel-item>
                                    </v-carousel>

                                </v-card-text>
                            </v-card>

                        </v-col>
                    </v-row>

                    
                   


        </v-col>
            <div>

                

            </div>
        
       
    </v-row>

    </v-container>
</template>

<script>
import {mapState} from 'vuex'
export default {
    data(){return{
        userData:{
            type: '',
            first_name: '',
            last_name: '' ,
            phone: '' 
        },
        items: [
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
          },
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
          },
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
          },
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
          },
        ],
    }},
    computed:{
        ...mapState({
            authUser : state => state.auth.user,
            errors: state=>state.errors,  
            profileUser : state => state.profile.user,  
            loader2: state => state.loader.loader2       
        }),
        first_name: {
            get () { return this.$store.state.auth.user.first_name; },
            set (value) { this.userData.first_name = value; }
        },
        last_name: {
            get () { return this.$store.state.auth.user.last_name; },
            set (value) { this.userData.last_name = value; }
        },  
        type: {
            get () { return this.$store.state.auth.user.type; },
            set (value) { this.userData.type = value; }
        },  
        phone: {
            get () { return this.$store.state.auth.user.phone; },
            set (value) { this.userData.phone = value; }
        },  
    },
    methods:{       
    },
    updated(){                
    },
    created(){        
        this.$store.dispatch('profile/set', this.$route.params.id);        
    }
    
}
</script>

<style scoped>

</style>