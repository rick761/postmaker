<template>
    <div>   
        <drawer-component />
        <v-main style="min-height: 100vh; background:#F6F4F1;" >
            
            <v-row>
                <v-col cols=11>
                    <v-container fluid>
                        <breadcrumbComponent /> 
                        <router-view></router-view> 
                    </v-container>
                </v-col>

                <!--icons right-->
                <v-col cols=1 class="text-right pr-8" >              

                    <v-btn :href="LandingsPageUrl()" color="primary" icon>
                        <v-icon>mdi-file-move-outline</v-icon>
                    </v-btn>

                    <br>

                    <form id="logout-form" :action="logoutActionUrl()" method="POST" >
                        <input type="hidden" name="_token" v-bind:value="csrf">   
                        <!-- <v-btn type="submit" text><v-icon>mdi-logout</v-icon> &nbsp; Uitloggen</v-btn>  -->
                        <v-btn type="submit" color="warning" icon>
                            <v-icon>mdi-logout-variant</v-icon>
                        </v-btn>
                    </form>                    
                    
                    <v-btn color="secondary" icon>
                        <v-badge content="10">
                        <v-icon>mdi-message-outline</v-icon>                        
                        </v-badge>                    
                    </v-btn>

                </v-col>
            </v-row> 
        </v-main>
        
        <v-footer style="padding: 0 300px;" > </v-footer>
         <!-- {{csrf}}, {{auth}}  -->
    </div>
</template>

<script>

export default {    
    props:['csrf','auth'],
    methods:{
        logoutActionUrl(){
            return window.location.origin+'/logout'; 
        },
        LandingsPageUrl(){
            return window.location.origin;
        }
    },
    created(){        
        this.$store.commit('auth/SET_AUTH', JSON.parse(this.auth));                                   
    }, 
}
</script>