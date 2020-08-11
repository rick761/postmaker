<template>
    <v-container>

    <v-parallax
        dark
        style="height:60vh;"
        class="mx-auto"
        src="https://picsum.photos/1920/1080?random"
        
    >
        <v-row  class="pa-16"           
            justify="center" 
        >
            <v-col cols="12" class="text-center ma-16">
                <h1 class="display-4 font-weight-thin ma-16 mb-4">Postmaker</h1>
                <h5 class="subheading">Aanvragen en produceren van content.</h5> 
            </v-col>

            <v-col  class="text-right" >
                <v-btn x-large color="blue" @click="loginButton" dark>Aanmelden</v-btn>
            </v-col>
            <v-col >
                <v-btn x-large color="success" @click="register=true" dark>Registreren</v-btn>
            </v-col  >
        </v-row>
    </v-parallax>

<!--login-->  
            <v-dialog width="500"  v-model="login" persistent>        
                <v-card class="elevation-12">
                    <v-form ref="formLogin" >

                        <v-toolbar color="primary" dark flat >
                            <v-toolbar-title>Aanmelden</v-toolbar-title>  
                            <v-spacer></v-spacer>
                            <v-btn @click="login=false" icon>
                                <v-icon>mdi-close</v-icon>
                            </v-btn>  
                        </v-toolbar>

                        <v-card-text class="pt-6">
                            
                                <v-text-field
                                v-model="loginData.email"
                                label="Email"
                                name="login"
                                :rules="emailRules"
                                prepend-icon="mdi-account"
                                type="text"
                                ></v-text-field>

                                <v-text-field
                                v-model="loginData.password"
                                id="password"
                                label="Password"
                                name="password"
                                :rules="passwordRules"
                                prepend-icon="mdi-lock"
                                type="password"
                                ></v-text-field>
                            
                            <v-btn @click="loginData.email='postmaker@postmaker.nl', loginData.password = 'postmaker'">postmaker</v-btn> 
                            <v-btn @click="loginData.email='contentaanvrager@contentaanvrager.nl', loginData.password = 'postmaker'">aanvrager</v-btn>
                            
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="submitLogin">Login</v-btn>
                        </v-card-actions>

                    </v-form>
                </v-card>            
            </v-dialog>

 <!--register-->
            <v-dialog  width="500"  v-model="register" persistent>        
                <v-card loading class="elevation-12">
                    <v-form  ref="formRegister">

                    <v-toolbar color="primary" dark flat >
                        <v-toolbar-title>Registrerem</v-toolbar-title>  
                        <v-spacer></v-spacer>
                        <v-btn @click="register=false" icon>
                            <v-icon>mdi-close</v-icon>
                        </v-btn>  
                    </v-toolbar>

                    <v-card-text class="pt-6">                       

                            <v-text-field
                            v-model="registerData.email"
                            label="E-mail"
                            name="Login"
                            :rules="emailRules"
                            prepend-icon="mdi-account"
                            type="text"
                            ></v-text-field>

                            <v-text-field
                                v-model="registerData.password"
                                id="password"
                                label="Wachtwoord"
                                name="password"
                                :rules="passwordRules"
                                prepend-icon="mdi-lock"
                                type="password"
                            ></v-text-field>

                            <v-text-field
                                v-model="registerData.c_password"
                                id="c_password"
                                label="Herhaal wachtwoord"
                                name="password"
                                :rules="passwordRules"                               
                                prepend-icon="mdi-lock"
                                type="password"

                            ></v-text-field>

                            <v-select
                                v-model="registerData.type"
                                prepend-icon="mdi-message-arrow-right-outline"
                                :items="['Postmaker','Contentaanvrager']"
                                :rules="[v => !!v || 'Item is required']"
                                label="Type account"
                                required
                            ></v-select>

                            <v-text-field
                                v-model="registerData.first_name"
                                :rules="firstNameRules"
                                :counter="25"
                                label="Voornaam"
                                prepend-icon="mdi-badge-account"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="registerData.last_name"
                                :rules="lastNameRules"
                                :counter="50"
                                label="Achternaam"
                                prepend-icon="mdi-badge-account"
                                required
                            ></v-text-field>
                        
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="submitRegister">Registreer</v-btn>
                    </v-card-actions>

                    </v-form>
                </v-card>            
            </v-dialog>




<!--3 blocks-->
    <v-row class="ma-16" justify="center">
        <v-col  class="text-right" >
            <v-sheet
                class="d-flex pa-16"
                color="yellow lighten-1"
                height="200"
                dark
                
            >     
                <v-icon class="mr-4" x-large >
                    mdi-google-circles-extended
                </v-icon>
                <span class="display-1">
                    600 Posts
                </span>

            </v-sheet>
        </v-col>

        <v-col  class="" >
            <v-sheet
                class="d-flex pa-16"
                color="green lighten-1"
                height="200"
                dark
            >
                <v-icon class="mr-4" x-large >
                    mdi-compass-rose
                </v-icon>
                <span class="display-1">
                    53 Users
                </span>
            </v-sheet>

        </v-col>
        <v-col  class="" >
            <v-sheet
                class="d-flex pa-16"
                color="teal lighten-1"
                height="200"
                dark
            >
                <v-icon class="mr-4" x-large >
                    mdi-meteor
                </v-icon>
                <span class="display-1">
                    128 Beschikbaar
                </span>

            </v-sheet>
        </v-col>       
    </v-row>
    <!--/ 3 blocks-->


    </v-container>
</template>

<script>
export default {
    data: () => ({ 
        login:null,
        register:null,
        loginData:{
            email:'postmaker@postmaker.nl',
            password:'postmaker'  
        },
        registerData:{
            email:'a@b.nl',
            first_name:'aa',
            last_name:'bb',
            password:'123456789',
            c_password:'123456789',
            type:'Postmaker'
        },
        emailRules: [
            v => !!v || 'E-mail mag niet leeg zijn',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        firstNameRules: [
            v => !!v || 'Voornaam mag niet leeg zijn',
            v => v.length <= 10 || 'Moet minder dan 11 karakters lang zijn',
        ],
        lastNameRules: [
            v => !!v || 'Achternaam mag niet leeg zijn',
            v => v.length <= 10 || 'Moet minder dan 11 karakters lang zijn',
        ],
        passwordRules:[
            v => !!v || 'Wachtwoord mag niet leeg zijn',
            v => v.length >= 9 || 'Moet Meer dan 8 karakters lang zijn',
        ],
        repeatPasswordRules:[
            v => !!v || 'Wachtwoord mag niet leeg zijn',
            v => v.length >= 9 || 'Moet Meer dan 8 karakters lang zijn',           
        ]
    }),
    methods:{
        submitLogin(){            
            var validated = this.$refs.formLogin.validate();
            if(validated){
                this.$store.dispatch('clearContent');
                this.$store.dispatch('auth/login',this.loginData);  
            }    
        },
        submitRegister(){
            var validated = this.$refs.formRegister.validate();
            if(validated){
                this.$store.dispatch('clearContent');
                this.$store.dispatch('auth/register',this.registerData);
            }            
        },
        changeUser(type){
            if(type == 'Postmaker'){                
                this.loginData.email='postmaker@postmaker.nl';
                this.loginData.password='postmaker';
                this.login();
            }
            else if (type == 'Contentaanvrager'){                
                this.loginData.email='contentaanvrager@contentaanvrager.nl';
                this.loginData.password='postmaker';
                this.login();
            }
            else if (type == 'Contentaanvrager2'){                
                this.loginData.email='contentaanvrager2@contentaanvrager.nl';
                this.loginData.password='postmaker';
                this.login();
            }
            else if(type == 'Postmaker2'){                
                this.loginData.email='postmaker2@postmaker.nl';
                this.loginData.password='postmaker';
                this.login();
            }         
        },
        loginButton(){
            this.login=true;
            this.$store.dispatch('auth/checkAuth')
        }
    }   
}
</script>

