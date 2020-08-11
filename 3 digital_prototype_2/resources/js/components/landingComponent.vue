<template>
    <v-main dark fluid style="height:100%; background: url('https://picsum.photos/1920/1080?random')" >
        <v-container fluid>

            <v-app-bar dark color="transparent" flat>
                <v-toolbar-title >
                    <v-icon x-large>mdi-tree-outline</v-icon>
                    Postmaker
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn  v-if="guest" @click="registerModal = !registerModal" text class="ma-5">
                    <v-icon>mdi-login-variant</v-icon> &nbsp; Registreren
                </v-btn>
                <form v-if="!guest"  id="logout-form" :action="logoutActionUrl()" method="POST" >
                    <input type="hidden" name="_token" v-bind:value="csrf">   
                    <v-btn type="submit" text><v-icon>mdi-logout</v-icon> &nbsp; Uitloggen</v-btn> 
                </form>
            </v-app-bar>
            

            <v-row style="min-height:40vh" align="end"  >                
                <v-col cols=12  class="white--text h1 mx-auto text-center">
                    Aanvragen en produceren van content.
                    <br>
                    <v-btn v-if="guest" @click="loginModal = !loginModal" x-large tile class="ma-5 success">
                        <v-icon>mdi-login</v-icon> &nbsp; Aanmelden
                    </v-btn>                     
                    <v-btn v-if="!guest" x-large class="ma-5 info" @click="goHome">
                        <v-icon>mdi-tree-outline</v-icon> &nbsp; Naar postmaker
                    </v-btn>
                    <br>
                    <slot/>
                </v-col>                
            </v-row>
            
            <v-card dark>   
                <v-card-title><v-icon x-large>mdi-tree-outline</v-icon>
                    Postmaker</v-card-title>
                <v-card-text>                    
                    <v-row>
                        <v-col cols="12" md="4" >         
                            <v-skeleton-loader type="date-picker"></v-skeleton-loader>
                        </v-col>
                        <v-col cols="12" md="4" >
                            <v-skeleton-loader class="mb-6" type="article, actions" ></v-skeleton-loader>
                            <v-skeleton-loader class="mb-6" type="table-heading, table-tfoot" ></v-skeleton-loader>
                        </v-col>
                        <v-col cols="12" md="4" >
                            <v-skeleton-loader class="mb-6" type="list-item-avatar, divider, list-item-three-line, card-heading, image, actions" ></v-skeleton-loader>               
                        </v-col>                    
                    </v-row>
                </v-card-text>                
            </v-card>
        </v-container>       
        
        <!--modals-->
        <login-modal-component v-model="loginModal" :csrf="csrf"></login-modal-component>
        <register-modal-component v-model="registerModal" :csrf="csrf"></register-modal-component>

    </v-main>
</template>

<script>

export default {    
    props:['csrf','guest'],
    data(){return{
        loginModal :false,
        registerModal: false
    }},
    methods:{
        register(){
            console.log(window.location.href+'register');
        },
        logoutActionUrl(){
            return window.location.origin+'/logout'; 
        },
        goHome(){
            window.location = window.location.origin+'/home';
        }
    }
}
</script>