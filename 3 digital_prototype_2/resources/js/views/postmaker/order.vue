<template>
  
        <v-row>           
            <v-col cols=8>

            <v-card outlined v-if="files.length" class="mb-5">
                <v-card-title>Opleveringen</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols=4 v-for="(file,key) in files" :key="key" >
                            <v-card >

                                <v-img
                                    class="white--text align-end"
                                    height="200px"
                                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                                >                                
                                    <v-card-title>docks.jpg</v-card-title>
                                </v-img>
                                
                                <v-card-text>
                                    Beschrijving Beschrijving Beschrijving Beschrijving Beschrijving Beschrijving     
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn icon small class="primary" dark><v-icon small>mdi-eye</v-icon></v-btn>                                    
                                    <v-btn icon small class="success" dark><v-icon small>mdi-message</v-icon></v-btn>   
                                    
                                </v-card-actions>

                            </v-card>
                        </v-col>                                              
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card outlined :loading="load" class="mb-3">
                <v-card-subtitle>Opleveren</v-card-subtitle>     
                <v-card-text><v-file-input v-model="files" multiple label="Bestanden uploaden"></v-file-input></v-card-text>     
                <v-card-text v-if="files.length">
                    <v-chip                         
                        @click:close="files.splice(file,1)" 
                        close
                        class="mr-1" 
                        v-for="(file,key) in files" 
                        :key="key"
                        >
                            {{file.name}}
                        </v-chip>
                </v-card-text>      
                <v-card-actions v-if="files.length">
                    <v-spacer></v-spacer>
                    <v-btn @click="upload" color="success"><v-icon>mdi-upload</v-icon> &nbsp; Opleveren</v-btn>
                </v-card-actions>
            </v-card>

            <v-card outlined class="mb-3" >
                <v-card-subtitle>Omschrijving</v-card-subtitle>
                <v-card-text>
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32
                </v-card-text>
            </v-card>
        </v-col>  


        <v-col cols=4>
            <v-card outlined class="mb-3" >   
                <v-card-subtitle>Acties</v-card-subtitle>            
                <v-card-text>
                    <p>Opdracht eigenaar <v-btn text small color="primary" >Arko Elsenaar</v-btn></p>
                    <p>E-mail <span class="ml-3 primary--text">Contentaanvrager@Contentaanvrager.nl</span></p> 
                    <v-btn  block class="success mb-1"><v-icon>mdi-check</v-icon> &nbsp;  Alles opgeleverd <v-spacer /></v-btn>
                    <v-btn  block class="success mb-1"><v-icon>mdi-cash</v-icon> &nbsp;  Betaling ontvangen <v-spacer /></v-btn>                                                       
                    <v-btn  block class="error"><v-icon>mdi-close</v-icon> &nbsp;  Ik wil stoppen<v-spacer /></v-btn>                                                       
                </v-card-text>
            </v-card>       

           

            <v-card outlined class="mb-5" >    
                <v-card-text>
                        Er zijn geen berichten
                </v-card-text>
                <v-card-actions>          
                    <v-text-field  class="ml-2"       
                        label="Message"
                        required
                    ></v-text-field>                
                    <v-btn icon dark class="ml-2 primary">
                        <v-icon>mdi-send</v-icon>
                    </v-btn>
                    <v-btn icon dark class="ml-2 mr-2 primary">
                        <v-icon>mdi-file</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-card>

             <v-card class="mb-5" >                
                <v-carousel height=300>
                    <v-carousel-item                                
                        v-for="(item,i) in items"
                        :key="i"
                        :src="item.src"
                        reverse-transition="fade-transition"
                        transition="fade-transition"
                    ></v-carousel-item>
                </v-carousel>                
            </v-card>

        </v-col>  
        
        
        
        </v-row>
    
</template>

<script>
  export default {

    data () {
        return {
            files:[{name:'docks.jpg'},{name:'docks.jpg'},{name:'docks.jpg'}],
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
            load:false
        }    
    },

    methods:{
        upload(){            
            this.load = true;
            setTimeout( () => {
                this.load = false;                
            },1000)
        }
    }

  }
</script>