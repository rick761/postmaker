<template>    
        <v-row>
           

            <v-col cols=8>            
            <v-card outlined  class="mb-5" >
                <v-card-text :class="{'description_hide': !description_show }">
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32
                </v-card-text>
                <v-card-actions>
                    <v-btn text v-if="description_show" @click="description_show = !description_show">verberg</v-btn>
                    <v-btn text v-if="!description_show"  @click="description_show = !description_show">toon</v-btn>
                </v-card-actions>
            </v-card>           

            <v-card outlined class="mb-0"  >
                <v-card-subtitle> Aanvragen </v-card-subtitle>   
            </v-card>

                <v-row>
                    <v-col v-for="i in 2" :key="i" cols=6>                   
                        <v-card outlined>   
                                               
                            <v-list-item class="mt-3">
                                <v-list-item-content>
                                    <v-list-item-title>Travis Howard</v-list-item-title>
                                </v-list-item-content>

                                <v-list-item-avatar>
                                    <v-img :src="'https://cdn.vuetifyjs.com/images/lists/2.jpg'"></v-img>
                                </v-list-item-avatar>
                            </v-list-item>

                            <v-list-item>
                                <v-list-item-content>
                                    Nieuwe prijs
                                </v-list-item-content>
                                <v-list-item-content class="text-right">
                                    <v-list-item-title>800,00</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-card-text>
                                <v-textarea rows=2 disabled solo placeholder="Motivatie" v-model="motivation"></v-textarea> 
                               
                            </v-card-text>
                                     
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn class="success" >Accepteren</v-btn>
                                <v-btn class="error" >Weigeren</v-btn>
                            </v-card-actions>

                        </v-card>
                    </v-col>
                 </v-row>
        </v-col>  


        <v-col cols=4> 
            
            <v-card outlined class="mb-5" >               
                <v-card-text>
                    <p>Opdracht eigenaar <v-btn text small color="primary" >Rick van Megen</v-btn></p>
                    <p>E-mail <span class="ml-3 primary--text">Aanvrager@Aanvrager.nl</span></p>       
                    <v-btn  block color="primary mb-1"><v-icon>mdi-draw</v-icon> &nbsp;  Opdracht aanpassen <v-spacer /></v-btn>      
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
            load:false,
            description_show:true,
            motivation:''

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

<style scoped>
    .description_hide{
        height:50px;overflow:hidden;
    }
</style>