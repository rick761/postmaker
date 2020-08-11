<template>
    <v-row align="center"> 
       
        <v-col>
            <v-card flat tile>
            <v-window  v-model="window" style="min-height:100%;" class="elevation-1" vertical>

                <v-window-item  v-for="(item,n) in tabs" :key="n">
                     <v-card flat tile>                         
                        <v-card-text>

                            <v-row class="mb-4" align="center">

                                <v-avatar color="grey" class="mr-4">
                                        <v-icon v-if="item=='title'">mdi-format-title</v-icon>
                                        <v-icon v-if="item=='description'">mdi-comment-text-outline</v-icon>
                                        <v-icon v-if="item=='images'">mdi-image</v-icon>
                                </v-avatar>

                                <strong class="title">
                                    <span v-if="item=='title'">{{order.title}}</span>
                                    <span v-if="item=='description'">Extra informatie</span>
                                    <span v-if="item=='images'">Afbeeldingen</span>
                                </strong>               

                                <v-spacer></v-spacer>
                               
                            </v-row>

                            <div v-if="item=='title'">
                                {{order.description}}
                            </div>

                            <div v-if="item=='description'">
                                <div v-for="(item,key) in order.comments.list" :key="key" >
                                    <div v-if=" item.title || item.text "  class=" mb-3">
                                        <h5 v-if="item.title">
                                            {{item.title}} 
                                        </h5>
                                        <div v-if="item.text"  >
                                            {{item.text}}
                                        </div>                                    
                                    </div>
                                </div>
                                <div v-if="!order.comments.list.length">Er is geen extra informatie.</div>

                            </div>
                            <div v-if="item=='images'">
                                <v-row>
                                    <v-col v-for="(img,index) in order.images.list" :key="index" class="d-flex child-flex" cols="4" >
                                        <v-img :src="public_path+'/'+img.url" />
                                    </v-col>
                                </v-row>
                                <div v-if="!order.images.list.length">Er zijn geen afbeeldingen toegevoegd.</div>                                
                            </div>     

                        </v-card-text>
                    </v-card>
                </v-window-item>

            </v-window>

             <v-card-actions class="justify-space-between">
                <v-btn
                    text
                    @click="prev"
                >
                    <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
                <v-item-group
                    v-model="window"
                    class="text-center"
                    mandatory
                >
                    <v-item
                    v-for="n in tabs"
                    :key="`btn-${n}`"
                    v-slot:default="{ active, toggle }"
                    >
                    <v-btn
                        :input-value="active"
                        icon
                        @click="toggle"
                    >
                        <v-icon>mdi-record</v-icon>
                    </v-btn>
                    </v-item>
                </v-item-group>
                <v-btn
                    text
                    @click="next"
                >
                    <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
                </v-card-actions>
            </v-card>

        </v-col>
    </v-row>
</template>

<script>
import {mapState} from 'vuex'
export default {
    props:[],
    data(){return{
        public_path :   localStorage.getItem('server-public-path'),         
        tabs: ['title', 'description', 'images'],
        window: 0,
    }},   
    computed:{
        ...mapState({  
            order : state => state.order_page.order
        })
    },
    methods: {
      next () {
        this.window = this.window + 1 === this.window
          ? 0
          : this.window + 1
      },
      prev () {
        this.window = this.window - 1 < 0
          ? this.tabs - 1
          : this.window - 1
      },
    }, 
}

</script>

<style scoped>

</style>