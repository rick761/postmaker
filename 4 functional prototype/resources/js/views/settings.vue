<template> 
    <v-row>  
        <v-col cols=12>
            <card>
                <v-card-subtitle>Instellingen (experimenteel, material thema werkt goed)</v-card-subtitle>
                <v-card-text>

                    <v-row>                        
                        <v-col>
                            <p>Themas </p>
                                <v-radio-group
                                    v-model="theme"
                                >
                                    <v-radio label="material" value='material'></v-radio>
                                    <v-radio label="standaard" value='default_theme'></v-radio>

                                    <v-radio label="basil" value='basil'></v-radio>
                                    <v-radio label="crane" value='crane'></v-radio>
                                    <v-radio label="owl" value='owl'></v-radio>
                                    <v-radio label="fortnightly" value='fortnightly'></v-radio>     
                                    <v-radio label="rally" value='rally'></v-radio>
                                    <v-radio label="reply" value='reply'></v-radio>
                                    <v-radio label="shrine" value='shrine'></v-radio>                                  
   
                                </v-radio-group> 
                                                
                        </v-col>
                        <v-col>
                            <p>Extra</p>
                            <p>
                                <v-switch v-model="dark_theme"  :label="`Donker thema: ${dark_theme}`"></v-switch>                 
                            </p> 
                            <p>
                                <v-switch v-model="reverse_mode"  :label="`Omgekeerde modus: ${reverse_mode}`"></v-switch>                 
                            </p>                         
                        </v-col>
                    </v-row>
                    
                   
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>

                   
                    
                    <v-btn class="primary" @click="reload">
                        <v-icon>mdi-refresh</v-icon>
                    </v-btn>
                </v-card-actions>
            </card>
        </v-col>
    </v-row>   
</template>
<script>
export default {
    data(){return{        
        dark_theme:false,
        reverse_mode:false,
        theme:'',      
    }},
    watch: {
        dark_theme(newValue){        
            localStorage.setItem('dark-theme',newValue);             
        },
        reverse_mode(newValue){        
            localStorage.setItem('reverse-mode',newValue);             
        },
        theme(newValue){        
            localStorage.setItem('theme',newValue);              
        },       
    },
    methods:{      
        reload(){
            location.reload();
        },      
    },
    created(){
        this.dark_theme = (localStorage.getItem('dark-theme') == 'true');  
        this.reverse_mode = (localStorage.getItem('reverse-mode') == 'true');   
        this.theme = localStorage.getItem('theme');         
    
        if(this.theme == null){
            this.theme = 'material'
        }     
    }
}
</script>