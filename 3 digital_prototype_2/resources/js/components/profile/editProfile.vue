<template>
    <v-card outlined flat class="mb-5">
       
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
                    :append-icon="(user.display_name && user.display_name.length > 5) ? 'mdi-eye' : 'mdi-eye-off'"
                    label="Alias (min 6)"
                    persistent-hint                    
                    required
                    :rules="rules.max25"
                    hint="Minimaal 6 karakters wordt de naam weergegeven als profielnaam."   
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
                        <v-chip close class="mb-1 mr-1" v-if="auth.avatar" >{{auth.avatar}}</v-chip>
                    </v-col>
                    <v-col cols=6> 
                        <v-file-input counter v-model="user_images" multiple label="Slider"></v-file-input> 
                         <v-chip close class="mb-1 mr-1" v-for="(item,key) in auth.user_images" :key="key">{{item.url}}</v-chip>   
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
    </v-card>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        data(){ return{
            valid:true,
            test:'',
            _avatar_file : [],
            _user_images_files : [],
            user:{
            },
            rules:{
                max25: [ v => (v && v.length <= 25) || 'Max 25 characters' ]
            }                 
        }},
        computed:{
            ...mapState({                
                auth: state => state.auth.user,
            }),
            first_name: {
                get () {return this.auth.first_name},
                set (value) { this.user.first_name = value; }
            },
            last_name:{
                get () {return this.auth.last_name},
                set (value) { this.user.last_name = value; }
            },
            company:{
                get () {return this.auth.company},
                set (value) { this.user.company = value; }
            },
            website:{
                get () {return this.auth.website},
                set (value) { this.user.website = value; }
            },
            avatar:{
                get () {return this.auth.avatar},
                set (value) {
                     this.user.avatar = value.name;
                     this._avatar_file = value; 
                }
            },
            phone:{
                get () {return this.auth.phone},
                set (value) {
                     this.user.phone = value;                     
                }
            },
            display_name:{
                get () {return this.auth.display_name;},
                set (value) {
                     this.user.display_name = value;  
                }
            },
            user_images:{
                get () {return this.auth.user_images},
                set (value) {      
                     var img = [];
                     for(var i in value){
                         img.push({url:value[i].name})
                    }
                    //this.user.user_images = img;                   
                    this._user_images_files = value;
                }
            },
            description:{
                get () {return this.auth.description},
                set (value) { this.user.description = value; }
            }
        },
        created(){           
             this.$store.dispatch('auth/get');           
        },        
        updated(){             
            //this.user = this._fixMutationError(this.$store.state.auth.user);  
        },
        methods:{
            saveProfile(){
                if(this.$refs.form.validate()){      
                    this.$store.dispatch('auth/save', this.user);
                }
            },
            saveAvatar(){

            },
            saveUserImages(){

            },
            _fixMutationError(val){
                return JSON.parse(JSON.stringify(val));
            }
        }
    }
</script>
