<template>
    
        <v-row>
            

            <v-col cols=8>
            
          
            <v-card outlined v-if="deliverys.length" class="mb-5">
                <v-card-subtitle>Opleveringen</v-card-subtitle>
                <v-card-text>
                    <v-row>
                       
                        <!-- <v-col cols=4 v-for="(item,key) in deliverys" :key="key">
                            <delivery-component  >
                                aa
                            </delivery-component>
                        </v-col> -->

                        

                        <v-col cols=4 v-for="(item,key) in deliverys" :key="key" >
                            <v-card>

                                <v-img class="white--text align-end" height="200px" src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">                                
                                    <v-card-title>Oplevering</v-card-title>
                                </v-img>
                                
                                <v-card-text>
                                    <p>
                                        Beschrijving van de postmaker bij de oplevering                                           
                                    </p>  
                                </v-card-text>
                                
                                <v-card-actions>  

                                    <br>

                                    <v-badge content="1" color="purple"  left overlap>
                                        <v-btn @click="openModal(key)" small class="secondary" dark><v-icon small>mdi-message</v-icon></v-btn>                                            
                                    </v-badge>   
                                
                                    <!--MODAL-->
                                    <modal  v-model="modal[key]" :title="'oplevering '+key">
                                        <v-textarea rows="2" single-line solo disabled value="Beschrijving van de postmaker bij de oplevering" />
                                        <p>Bestanden:</p>
                                        
                                        <v-list>
                                            <v-list-item>   
                                                <v-list-item-avatar>
                                                    <v-img src="https://cdn.vuetifyjs.com/images/lists/1.jpg"></v-img>
                                                </v-list-item-avatar>

                                                &nbsp;

                                                <v-list-item-content>
                                                    <v-list-item-title >Icoon.jpg</v-list-item-title>
                                                </v-list-item-content>

                                                <v-list-item-icon>
                                                    <v-btn color="secondary" >
                                                        <v-icon >mdi-download</v-icon>
                                                    </v-btn>
                                                </v-list-item-icon>
                                                <v-list-item-icon>
                                                    <v-btn color="secondary" >
                                                        <v-icon >mdi-eye</v-icon>
                                                    </v-btn>
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-list>

                                        <p>Comments:</p>
                                            <v-list>
                                                <v-list-item v-for="i in 2" :key="i">  
                                                    <v-list-item-avatar>                                                       
                                                            <v-img src="https://cdn.vuetifyjs.com/images/lists/1.jpg"></v-img>                                                        
                                                    </v-list-item-avatar>

                                                     <v-list-item-content>                                                        
                                                        <v-list-item-title>29/03/2020 14:14:14</v-list-item-title>
                                                    </v-list-item-content>

                                                    <v-list-item-content>
                                                        <v-list-item-title v-if="i == 1" >MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM</v-list-item-title>
                                                        <v-list-item-title v-else >Of toch niet..</v-list-item-title>
                                                    </v-list-item-content>                                                    
                                                   
                                                </v-list-item>
                                            </v-list>
                                        <template slot="actions">
                                            <v-col cols="4">
                                                <v-text-field counter="30" placeholder="Nieuwe comment"></v-text-field>                                                  
                                            </v-col>
                                            <v-col cols="2"> 
                                                    <v-btn color="primary"><v-icon>mdi-send</v-icon></v-btn>   
                                            </v-col>
                                            <v-col class="text-right">
                                                    <!-- <v-btn icon><v-icon>mdi-thumb-up</v-icon></v-btn>   -->
                                                    <v-btn color="success" ><v-icon >mdi-thumb-up</v-icon>  </v-btn>   
                                                    <v-btn color="warning" ><v-icon >mdi-thumbs-up-down</v-icon>   </v-btn>                                    
                                                    <v-btn color="error" ><v-icon >mdi-thumb-down</v-icon>     </v-btn>
                                            </v-col>
                                        </template>
                                    </modal>
                                    <!--/MODAL-->
                                
                                      
                                    <!--END-->
                                    <v-spacer></v-spacer>        
                                    <!-- <v-icon color="success">mdi-thumb-up</v-icon>     -->
                                    <v-icon color="warning">mdi-thumbs-up-down</v-icon>                                      
                                    <!-- <v-icon color="error">mdi-thumb-down</v-icon>   -->

                                </v-card-actions>

                            </v-card>
                        </v-col>                                              
                    </v-row>
                </v-card-text>
            </v-card>

            

            <v-card outlined  >
                <v-card-text :class="{'description_hide': !description_show }">
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32
                </v-card-text>
                <v-card-actions>
                    <v-btn text v-if="description_show" @click="description_show = !description_show">verberg</v-btn>
                    <v-btn text v-if="!description_show"  @click="description_show = !description_show">toon</v-btn>
                </v-card-actions>
            </v-card>
        </v-col>  


        <v-col cols=4>
            <v-card outlined class="mb-5" >               
                <v-card-text>
                    <p>Opdracht eigenaar <v-btn text small color="primary" >Rick van Megen</v-btn></p>
                    <p>E-mail <span class="ml-3 primary--text">Aanvrager@Aanvrager.nl</span></p>                      
                    <v-btn  block color="success mb-1"><v-icon>mdi-check</v-icon> &nbsp;  Rond Project af<v-spacer /></v-btn>
                    <!-- <v-btn  block color="warning mb-1"><v-icon>mdi-close</v-icon>  Afkeuren <v-spacer /></v-btn> -->
                    <v-btn  block color="error"><v-icon>mdi-close</v-icon>  &nbsp; Beeindig Project<v-spacer /></v-btn>                    
                </v-card-text>
            </v-card>      

            <v-card outlined class="mb-5" >
                
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

            <v-card outlined >    
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

        </v-col>  
        
        
        
    </v-row>
    
</template>

<script>
  export default {

    data () {
        return {
            modal:[],
            deliverys:[{name:'docks.jpg'},{name:'docks.jpg'},{name:'docks.jpg'}],
            
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
            load:false,
            description_show:true
        }    
    },

    methods:{
        upload(){            
            this.load = true;
            setTimeout( () => {
                this.load = false;                
            },1000)
        },
        openModal(i){
            this.modal[i]=1
            this.$forceUpdate();            
        }
    },

    

  }
</script>

<style scoped>
    .description_hide{
        height:50px;overflow:hidden;
    }
</style>