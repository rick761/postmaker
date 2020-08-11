<template>
    <div>
        <v-card v-if="images && images.length" outlined class="mb-5" >   
            <v-carousel height=300>
                <v-carousel-item                                
                    v-for="(item,i) in images"
                    :key="i"
                    :src="'./storage/'+auth.id+'/order_files/'+order.id+'/'+item.url"
                    reverse-transition="fade-transition"
                    transition="fade-transition"
                ></v-carousel-item>
            </v-carousel>          
        </v-card>

        <v-card v-if="otherFiles && otherFiles.length" >
            <v-card-subtitle>Bestanden</v-card-subtitle>
            <v-card-text >
                <p v-for="(item,i) in otherFiles" :key="i">
                    <a :href="'./storage/'+auth.id+'/order_files/'+order.id+'/'+item.url">{{item.url}}</a>
                </p>
                
            </v-card-text>
        </v-card>

    </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
    computed:{

        ...mapState({
            auth: state => state.auth.user,
            order: state => state.order.data,
            order_files : state => state.order.files.list
        }),

        images(){
            return this.order_files.filter(function(file){   
                if(!file.url) return;
                var allowedExtension = ['jpg','png']                
                var ext = file.url.split('.')[file.url.split('.').length-1].toLowerCase();

                for(var i in allowedExtension){
                    if(allowedExtension[i] == ext){
                        return file;
                    }
                }
                
            })
        },

        otherFiles(){
            return this.order_files.filter(function(file){   
                if(!file.url) return;
                var allowedExtension = ['jpg','png']
                var ext = file.url.split('.')[file.url.split('.').length-1].toLowerCase();               
                for(var i in allowedExtension){
                    if(allowedExtension[i] == ext){
                        return false;
                    }
                }
                return file;                
            })
        }

       
    },
    data () { return {            
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
    }},

}
</script>