<template>
    <v-main dark fluid 
    :style="`height:100%; background: url('./images/gallery/${Math.ceil(Math.random() * 1)}.jpg') no-repeat top;background-size: cover; background-color:black;`" >
    
        <v-container fluid>

            <feedback />

            <v-app-bar dark color="transparent" flat>
                <v-toolbar-title >
                    <v-icon x-large>mdi-tree-outline</v-icon>
                    Postmaker
                </v-toolbar-title>
                <v-spacer></v-spacer> 

                <span v-if="guest" >Nog geen account?</span> 

                <v-btn  v-if="guest" @click="registerModal = !registerModal" text class="ma-5 register-button">
                    <v-icon>mdi-login-variant</v-icon> &nbsp;  Registreren
                </v-btn>
               
                <form v-if="!guest"  id="logout-form" :action="logoutActionUrl()" method="POST" >
                    <input type="hidden" name="_token" v-bind:value="csrf">   
                    <v-btn type="submit" text><v-icon>mdi-logout</v-icon> &nbsp; Uitloggen</v-btn> 
                </form>
            </v-app-bar>
            

            <v-row class="mb-5" style="min-height:25vh" align="end"  >                
                <v-col cols=12  class="white--text h1 mx-auto text-center">
                    Aanvragen en produceren van content.
                    <br>
                    <v-btn v-if="guest" @click="loginModal = !loginModal" x-large tile class="ma-5 success login-button">
                        <v-icon>mdi-login</v-icon> &nbsp; Inloggen
                    </v-btn>                     
                    <v-btn v-if="!guest" x-large class="ma-5  info" @click="goHome">
                        <v-icon>mdi-tree-outline</v-icon> &nbsp; Naar postmaker
                    </v-btn>
                    <br>
                    <slot/>
                </v-col>                
            </v-row>
            
            <v-card dark>  
                
                   

                   
               
                <v-card-title>
                    <v-icon x-large>mdi-tree-outline</v-icon>
                    Postmaker
                </v-card-title>
               <v-card-text> 
                <!-- <v-tooltip top> -->
                    <!-- <template v-slot:activator="{ on, attrs }"> -->

                        <!-- <v-img class="rounded" @click="loginModal = !loginModal"  v-on="on"  v-bind="attrs" id="preview_postmaker" src="./images/landing/preview.png" >  
                            <div class="v-skeleton-loader__image v-skeleton-loader__bone"></div>
                        </v-img> -->

                          <v-carousel class="rounded" :show-arrows="false" delimiter-icon="mdi-chevron-right" height="600" cycle >
                            <v-carousel-item 
                            
                            v-for="(item,i) in images"
                            :key="i"
                            
                            >
                                <v-img :src="item.src">
                                    <v-row
                                        class="fill-height elevation-1 pa-16"
                                        align="center"
                                        justify="center"
                                        elevation="1"
                                        
                                    >
                                        <div class="text-center display-3 rounded-pill pa-5 primary"  style=" box-shadow: rgb(0, 0, 0) 0px 0px 4px;background:#000;">                                
                                            <v-icon x-large>mdi-{{item.icon}}</v-icon> &nbsp;{{item.txt}}
                                        </div>
                                    </v-row>
                                </v-img>
                            </v-carousel-item>
                        </v-carousel>

                    <!-- </template>
                        <v-icon>mdi-arrow-up</v-icon>
                    </v-tooltip>    -->

                   
                    <!-- <v-row>
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
                    </v-row> -->
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
        registerModal: false,
        images:[
            {src:'./images/landing/preview_1.PNG',txt:"Aanmelden als 'aanvrager' of 'postmaker'!",icon:'account-group'},
            {src:'./images/landing/preview_2.PNG',txt:"De aanvrager maakt een opdracht!",icon:'briefcase-plus-outline'},
            {src:'./images/landing/preview_3.PNG',txt:"De postmaker zoekt naar opdrachten!",icon:'briefcase-search-outline'},
            {src:'./images/landing/preview_4.PNG',txt:"De postmaker solliciteert!",icon:'frequently-asked-questions'},
            {src:'./images/landing/preview_5.PNG',txt:"En de opdracht begint!",icon:'draw'},
        ]
    }},
    methods:{
        register(){
            // console.log(window.location.href+'register');
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

<style  scoped>
.v-skeleton-loader__image {
    height:100% !important;
    opacity:0.9;
}
.v-skeleton-loader__bone:after {
    -webkit-animation: loading 1.5s infinite;
    animation: loading 1.5s infinite;
    content: "";
    height: 100%;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    transform: translateX(-100%);
    z-index: 1;
    background: linear-gradient(90deg,hsla(0,0%,100%,0),hsla(0,0%,100%,.3),hsla(0,0%,100%,0));

}
</style>