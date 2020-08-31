<template>
    <card>
       
        <v-card-title>
            {{auth.email}}
        </v-card-title>

        <v-card-subtitle>
            {{auth.type}}
        </v-card-subtitle>

        <v-form ref="form" v-model="valid">              
            <v-card-text>

                <v-text-field
                    v-model="display_name"                    
                    :append-icon="'mdi-eye'"
                    label="Publieke naam"
                    :rules="[v => !!v || 'Verplicht', v => v.length >= 6 || 'Ten minste 6 karakters']"
                    persistent-hint                    
                    required                  
                    hint="Naam te zien voor andere personen"   
                ></v-text-field>
                
                <v-row>
                    <v-col>
                        <v-text-field                        
                            v-model="first_name" 
                            :rules="[v => !!v || 'Verplicht']"
                            label="Voornaam"                            
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="last_name" 
                            :rules="[v => !!v || 'Verplicht']"
                            label="Achternaam"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-text-field
                    v-model="company"                     
                    label="company"                  
                    required
                ></v-text-field>

                <v-text-field
                    v-model="website" 
                    label="website"
                    required                   
                ></v-text-field>  

                <v-text-field
                    v-model="phone"  
                    label="Tel. nummer"
                    required
                ></v-text-field>  
                
                <v-row>
                    <v-col cols=6>  
                        <v-file-input v-model="avatar" label="Avatar"></v-file-input>                         
                        <v-img v-if="auth.avatar"
                         id="preview_avatar" 
                         alt="avatar" 
                         :src=" '/storage/' + auth.id + '/avatar/' + auth.avatar"
                         @click="$store.dispatch('image/preview',  '/storage/' + auth.id + '/avatar/' + auth.avatar)"                         
                         ></v-img>
                    </v-col>
                    <v-col cols=6> 

                        <v-file-input counter v-model="user_images" multiple label="Slider"></v-file-input> 

                        <v-chip 
                            @click:close="delNewImage(key)" 
                            close 
                            class="mb-1 mr-1"
                            v-for="(item,key) in user_images_files" 
                            :key="key+item"
                        >
                            <v-icon>mdi-image-plus</v-icon> &nbsp; {{item.name}}
                        </v-chip> 
                        
                        <v-chip 
                            @click="$store.dispatch('image/preview', '/storage/' + auth.id + '/user_images/' + item.url )"
                            @click:close="delImage(key2)" 
                            close
                            class="mb-1 mr-1"
                            v-for="(item,key2) in images" 
                            :key="key2"
                        > 
                            <v-icon>mdi-image-size-select-actual</v-icon> &nbsp; {{item.url}}
                        </v-chip> 
                    </v-col>
                </v-row>        
                

                <v-textarea 
                    solo
                    name="input-7-4"
                    label="Biografie"
                    v-model="description"
                ></v-textarea>

            </v-card-text>
            
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="success" @click="saveProfile" > &nbsp; Opslaan</v-btn>
            </v-card-actions>      
        </v-form>
    </card>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        data(){ return{
            valid:true,            
            _avatar_file : [],
            user_images_files : [],
           // user:{}              
        }},
        computed:{
            ...mapState({                
                auth: state => state.auth.user,
                images : state=> state.auth.images.list
            }),
            first_name: {
                get () {return this.auth.first_name},               
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'first_name', value])  
                }
            },
            last_name:{
                get () {return this.auth.last_name},
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'last_name', value])  

                }
                
            },
            company:{
                get () {return this.auth.company},
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'company', value])  
                 }
                
            },
            website:{
                get () {return this.auth.website},               
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'website', value])  
                }
            },
            avatar:{                
                get(){},
                set (value) {
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'avatar', value.name])  
                    this._avatar_file = value; 
                }
            },
            phone:{
                get () {return this.auth.phone},
                set (value) {
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'phone', value])                    
                }
            },
            display_name:{
                get () {return this.auth.display_name;},
                set (value) {
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'display_name', value])  
                }
            },
            user_images:{
                get(){},                
                set (value) {                                                                        
                    this.user_images_files = value;                                    
                    this.$forceUpdate()
                }
            },
            description:{
                get () {return this.auth.description},
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'description', value]); 
                }
            }
        },
        created(){           
             this.$store.dispatch('auth/get_');           
        },                
        methods:{

            saveProfile(){                
                if(this.$refs.form.validate()){                                        
                   this.$store.commit('auth/images/ADD_USER_IMAGES',this.user_images_files);                   
                   this.$store.dispatch('auth/save');                 
                   if(this._avatar_file)
                        this.$store.dispatch('file/upload', {type:'avatar', files:this._avatar_file}).then(()=>{
                            this.reloadProfilePicture();                            
                        }
                    );                   
                   if(this.user_images_files){                
                        this.$store.dispatch('file/upload', {type:'user_images', files:this.user_images_files});                
                   }
                   this.user_images_files = [];                 
                   this.$forceUpdate();
                }
                
            },       

            reloadProfilePicture(){                
                this.$store.commit('auth/SET_AUTH_FIELD',[ 'avatar', this.auth.avatar + '?' + Date.now()])                  
                this.$forceUpdate();
            },    
            
            delNewImage(i){
                this.user.user_images.splice(i,1);
                this.user_images_files.splice(i,1);
                this.$forceUpdate();
            },

            delImage(i){
                this.$store.dispatch('api/post', {url:'/auth/image/delete', data: this.auth.user_images[i]}).then(()=>{
                    // console.log(this.$store.state.api);
                });               
                this.$store.commit('auth/images/DEL_USER_IMAGE', i);
            }

        }
    }
</script>
