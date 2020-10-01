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
                    label="Naam van profiel"
                    :rules="[
                        v => !!v || 'Verplicht', 
                        v => v.length >= 6  || 'Ten minste 6 karakters',
                        v => v.length <= 50 || 'max 50 karakters'                    
                    ]"         
                    counter="50"                             
                    required                  
                    hint="Deze naam wordt getoond aan andere gebruikers"   
                ></v-text-field>
                
                <v-row>
                    <v-col>
                        <v-text-field                        
                            v-model="first_name" 
                            
                            label="Voornaam"          
                            counter="50"                   
                            required
                            :rules="[
                                v => !!v || 'Dit kan niet leeg zijn',
                                v => v.length >= 3 || 'Min 3 karakters',
                                v => v.length <= 255 || 'Max 255 karakters'
                            ]"
                        ></v-text-field>
                    </v-col>
            
                    <v-col>
                        <v-text-field
                            v-model="last_name" 
                            label="Achternaam"
                            counter="50" 
                            required
                            :rules="[
                                v => !!v || 'Dit kan niet leeg zijn',
                                v => v.length >= 3 || 'Min 3 karakters',
                                v => v.length <= 255 || 'Max 255 karakters'
                            ]"
                        ></v-text-field>                        
                    </v-col>
                </v-row>

                <v-text-field
                    v-model="company"                     
                    label="*Bedrijfsnaam"     
                      :rules="[                      
                        
                        v => v.length <= 255 || 'Max 255 karakters'
                    ]"
                    counter="255" 
                    required
                ></v-text-field>
            

                <v-text-field
                    v-model="website" 
                    label="*Website"                      
                    counter="255"
                    required      
                    :rules="[                        
                        v => v.length <= 255 || 'Max 255 karakters'
                    ]"
                                 
                ></v-text-field>  
               

                <v-text-field
                    v-model="phone"  
                    label="*Telefoon nummer"                   
                    counter="255"
                    required
                    :rules="[                        
                        v => v.length <= 255 || 'Max 255 karakters'
                    ]"
                ></v-text-field>  
                 
                
                <v-row>
                    <v-col cols=6>  
                        <v-file-input v-model="avatar" label="Profiel foto"></v-file-input>                         
                        <v-img v-if="auth.avatar"
                         id="preview_avatar" 
                         alt="avatar" 
                         :src=" '/storage/' + auth.id + '/avatar/' + auth.avatar"
                         @click="$store.dispatch('image/preview',  '/storage/' + auth.id + '/avatar/' + auth.avatar)"                         
                         ></v-img>
                    </v-col>
                    <v-col cols=6> 

                        <v-file-input counter v-model="user_images" multiple label="Galerij afbeeldingen"></v-file-input> 

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
                    label="Profiel beschrijving"
                    v-model="description"
                    counter="255"
                     :rules="[
                        v => !!v || 'Dit kan niet leeg zijn',
                        v => v.length <= 255 || 'Max 255 karakters'
                    ]"
                ></v-textarea>
              

            </v-card-text>
            
            <v-card-actions>
                <v-spacer></v-spacer>               
                <v-btn :loading="loader_btns" class="success" @click="saveProfile" > &nbsp; Opslaan</v-btn>
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
                images : state=> state.auth.images.list,
                loader_btns: state=>state.loader.data.buttons

            }),
            first_name: {
                get () {return this.auth.first_name==null?"":this.auth.first_name},               
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'first_name', value])  
                }
            },
            last_name:{
                get () {return this.auth.last_name==null?"":this.auth.last_name},
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'last_name', value])  

                }
                
            },
            company:{
                get () {return this.auth.company==null?"":this.auth.company},
                set (value) { 
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'company', value])  
                 }
                
            },
            website:{
                get () {return this.auth.website==null?"":this.auth.website},               
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
                get () {return this.auth.phone==null?"":this.auth.phone},
                set (value) {
                    this.$store.commit('auth/SET_AUTH_FIELD',[ 'phone', value])                    
                }
            },
            display_name:{
                get () {return this.auth.display_name==null?"":this.auth.display_name},
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
                get () {return this.auth.description==null?"":this.auth.description},
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
                    console.log('validated')    

                   this.$store.commit('auth/images/ADD_USER_IMAGES',this.user_images_files);                   
                   this.$store.dispatch('auth/save');          
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
